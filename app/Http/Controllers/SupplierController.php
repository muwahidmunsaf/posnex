<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\ActivityLog;
use App\Traits\LogsActivity;

class SupplierController extends Controller
{
    use LogsActivity;

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Auth::user()->role === 'employee') {
            abort(403);
        }
        $companyId = Auth::user()->company_id;
        $suppliers = Supplier::where('company_id', $companyId)->latest()->paginate(10);
        $allSuppliers = Supplier::where('company_id', $companyId)->get();
        $totalSuppliers = $allSuppliers->count();
        $totalPaidPkr = 0;
        $totalPurchasePkr = 0;
        foreach ($allSuppliers as $supplier) {
            $paidPkr = $supplier->supplierPayments()->sum('pkr_amount');
            $purchasePkr = $supplier->purchases()->sum('pkr_amount');
            $totalPaidPkr += $paidPkr;
            $totalPurchasePkr += $purchasePkr;
        }
        $totalPendingPkr = max($totalPurchasePkr - $totalPaidPkr, 0);
        return view('suppliers.index', compact('suppliers', 'totalSuppliers', 'totalPaidPkr', 'totalPendingPkr', 'totalPurchasePkr'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('suppliers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (Auth::user()->role === 'employee') {
            abort(403);
        }
        $request->validate([
            'supplier_name' => 'required|string|max:255',
            'cell_no' => 'required|string|max:20',
            'contact_person' => 'required|string|max:255',
            'country' => 'required|string|max:255',
        ]);
        $country = $request->country ?: 'Pakistan';
        $supplier = Supplier::create([
            'supplier_name' => $request->supplier_name,
            'cell_no' => $request->cell_no,
            'tel_no' => $request->tel_no,
            'contact_person' => $request->contact_person,
            'email' => $request->email,
            'address' => $request->address,
            'company_id' => Auth::user()->company_id,
            'country' => $country,
        ]);
        
        // Log the activity using trait
        $this->logCreate($supplier, 'Supplier', $supplier->supplier_name);
        
        return redirect()->route('suppliers.index')->with('success', 'Supplier created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $supplier = Supplier::findOrFail($id);
        $purchases = $supplier->purchases()->with('items')->orderBy('purchase_date', 'desc')->get();
        $payments = $supplier->supplierPayments()->orderBy('payment_date', 'desc')->get();
        $totalPurchase = $purchases->sum('total_amount');
        $totalPaid = $payments->sum('amount');
        $balance = $totalPurchase - $totalPaid;

        $currencyCode = $supplier->currency['code'] ?? 'PKR';
        Log::info('Supplier currency code: ' . $currencyCode);
        $currentRate = $this->getCurrencyRateToPKR($currencyCode);

        return view('suppliers.history', compact('supplier', 'purchases', 'payments', 'totalPurchase', 'totalPaid', 'balance', 'currentRate'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Supplier $supplier)
    {
        return view('suppliers.edit', compact('supplier'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Supplier $supplier)
    {
        if (Auth::user()->role === 'employee') {
            abort(403);
        }
        $request->validate([
            'supplier_name' => 'required|string|max:255',
            'cell_no' => 'required|string|max:20',
            'contact_person' => 'required|string|max:255',
            'country' => 'required|string|max:255',
        ]);
        $data = $request->all();
        $data['country'] = $request->country ?: 'Pakistan';
        $supplier->update($data);
        
        // Log the activity using trait
        $this->logUpdate($supplier, 'Supplier', $supplier->supplier_name);
        
        return redirect()->route('suppliers.index')->with('success', 'Supplier updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Supplier $supplier)
    {
        if (Auth::user()->role === 'employee') {
            abort(403);
        }
        
        // Log the activity before deletion using trait
        $this->logDelete($supplier, 'Supplier', $supplier->supplier_name);
        
        $supplier->delete();
        return redirect()->route('suppliers.index')->with('success', 'Supplier deleted successfully.');
    }

    public function pay(Request $request, $supplierId)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0.01',
            'payment_date' => 'required|date',
            'payment_method' => 'nullable|string|max:255',
            'note' => 'nullable|string|max:255',
        ]);
        $supplier = \App\Models\Supplier::findOrFail($supplierId);
        $currencyCode = $supplier->currency['code'] ?? 'USD';
        $amount = $request->amount;
        $exchangeRate = 1.0;
        $pkrAmount = $amount;
        if ($currencyCode !== 'PKR') {
            try {
                $response = Http::get("https://api.exchangerate.host/latest", [
                    'base' => $currencyCode,
                    'symbols' => 'PKR',
                ]);
                if ($response->ok() && isset($response['rates']['PKR'])) {
                    $exchangeRate = $response['rates']['PKR'];
                    $pkrAmount = $amount * $exchangeRate;
                } else {
                    Log::error('Exchange rate API error (payment): ' . $response->body());
                }
            } catch (\Exception $e) {
                Log::error('Exchange rate API exception (payment): ' . $e->getMessage());
                $exchangeRate = 1.0;
                $pkrAmount = $amount;
            }
        }
        \App\Models\SupplierPayment::create([
            'supplier_id' => $supplierId,
            'amount' => $amount,
            'payment_date' => $request->payment_date,
            'payment_method' => $request->payment_method,
            'note' => $request->note,
            'currency_code' => $currencyCode,
            'exchange_rate_to_pkr' => $exchangeRate,
            'pkr_amount' => $pkrAmount,
        ]);
        return redirect()->route('suppliers.show', $supplierId)->with('success', 'Payment recorded successfully.');
    }

    public function printPaymentReceipt($supplierId, $paymentId)
    {
        $supplier = \App\Models\Supplier::findOrFail($supplierId);
        $payment = \App\Models\SupplierPayment::findOrFail($paymentId);
        return view('suppliers.payment_receipt', compact('supplier', 'payment'));
    }

    public function printHistory($id, Request $request)
    {
        $supplier = Supplier::findOrFail($id);
        $from = $request->query('from');
        $to = $request->query('to');
        $purchases = $supplier->purchases();
        $payments = $supplier->supplierPayments();
        if ($from) $purchases->whereDate('purchase_date', '>=', $from);
        if ($to) $purchases->whereDate('purchase_date', '<=', $to);
        if ($from) $payments->whereDate('payment_date', '>=', $from);
        if ($to) $payments->whereDate('payment_date', '<=', $to);
        $purchases = $purchases->with('items')->orderBy('purchase_date', 'desc')->get();
        $payments = $payments->orderBy('payment_date', 'desc')->get();
        $totalPurchase = $purchases->sum('total_amount');
        $totalPaid = $payments->sum('amount');
        $balance = $totalPurchase - $totalPaid;

        $currencyCode = $supplier->currency['code'] ?? 'PKR';
        $currentRate = $this->getCurrencyRateToPKR($currencyCode);

        return view('suppliers.print_history', compact('supplier', 'purchases', 'payments', 'totalPurchase', 'totalPaid', 'balance', 'currentRate', 'from', 'to'));
    }

    public function printAll(Request $request)
    {
        $user = Auth::user();
        $company = $user->company;
        $from = $request->query('from');
        $to = $request->query('to');
        $suppliers = \App\Models\Supplier::where('company_id', $user->company_id)
            ->with(['purchases', 'supplierPayments'])
            ->get();
        $supplierSummaries = $suppliers->map(function($supplier) use ($from, $to) {
            $purchases = $supplier->purchases();
            $payments = $supplier->supplierPayments();
            if ($from) $purchases->whereDate('purchase_date', '>=', $from);
            if ($to) $purchases->whereDate('purchase_date', '<=', $to);
            if ($from) $payments->whereDate('payment_date', '>=', $from);
            if ($to) $payments->whereDate('payment_date', '<=', $to);
            $totalPurchase = $purchases->sum('total_amount');
            $totalPaid = $payments->sum('amount');
            $balance = $totalPurchase - $totalPaid;
            return [
                'name' => $supplier->supplier_name,
                'country' => $supplier->country,
                'currency_symbol' => $supplier->currency['symbol'] ?? 'Rs',
                'currency_code' => $supplier->currency['code'] ?? 'PKR',
                'total_purchase' => $totalPurchase,
                'total_paid' => $totalPaid,
                'balance' => $balance,
            ];
        });
        $totalPurchase = $supplierSummaries->sum('total_purchase');
        $totalPaid = $supplierSummaries->sum('total_paid');
        $totalBalance = $supplierSummaries->sum('balance');
        return view('suppliers.print_all', compact('supplierSummaries', 'company', 'totalPurchase', 'totalPaid', 'totalBalance', 'from', 'to'));
    }

    public function deletePayment($supplierId, $paymentId)
    {
        $payment = \App\Models\SupplierPayment::where('supplier_id', $supplierId)->where('id', $paymentId)->firstOrFail();
        $payment->delete();
        return back()->with('success', 'Payment deleted successfully.');
    }

    // Helper to get currency rate to PKR with fallback and debug logging
    public function getCurrencyRateToPKR($currencyCode)
    {
        if ($currencyCode === 'PKR') {
            Log::info('Currency is PKR, rate = 1.0');
            return 1.0;
        }
        // Try direct conversion
        $response = \Illuminate\Support\Facades\Http::get("https://open.er-api.com/v6/latest/{$currencyCode}");
        Log::info('Direct rate response for ' . $currencyCode . ' to PKR: ' . $response->body());
        if ($response->ok() && isset($response['rates']['PKR']) && $response['rates']['PKR'] != 1.0) {
            Log::info('Direct rate found: ' . $response['rates']['PKR']);
            return $response['rates']['PKR'];
        }
        // Fallback: via USD
        $usdResp = \Illuminate\Support\Facades\Http::get("https://open.er-api.com/v6/latest/USD");
        $curResp = \Illuminate\Support\Facades\Http::get("https://open.er-api.com/v6/latest/{$currencyCode}");
        Log::info('USD to PKR response: ' . $usdResp->body());
        Log::info($currencyCode . ' to USD response: ' . $curResp->body());
        $usdToPkr = $usdResp->ok() && isset($usdResp['rates']['PKR']) ? $usdResp['rates']['PKR'] : null;
        $currencyToUsd = $curResp->ok() && isset($curResp['rates']['USD']) ? $curResp['rates']['USD'] : null;
        if ($usdToPkr && $currencyToUsd && $currencyToUsd != 0) {
            $rate = $usdToPkr / $currencyToUsd;
            Log::info('Fallback rate calculated: ' . $rate);
            return $rate;
        }
        Log::warning('Could not get a valid rate for ' . $currencyCode . ' to PKR, returning 1.0');
        return 1.0;
    }
}
