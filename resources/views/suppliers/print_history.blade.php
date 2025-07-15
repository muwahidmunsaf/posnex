<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Supplier Full History - {{ $supplier->supplier_name }}</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
        body { font-family: Arial, sans-serif; background: #fff; margin: 0; padding: 0; }
        .header { display: flex; justify-content: space-between; align-items: flex-start; border-bottom: 2.5px solid #b71c1c; padding: 24px 32px 12px 32px; }
        .header-left { display: flex; align-items: center; }
        .logo { height: 60px; margin-right: 18px; }
        .company-name { font-size: 2rem; font-weight: bold; color: #b71c1c; }
        .company-details { text-align: right; font-size: 1rem; color: #333; line-height: 1.7; }
        .company-details i { color: #b71c1c; margin-right: 4px; }
        .section-title { font-size: 1.3rem; color: #b71c1c; font-weight: bold; margin: 32px 0 16px 0; text-align:center; }
        .summary-table, .history-table { width: 100%; border-collapse: collapse; margin-bottom: 24px; }
        .summary-table td, .history-table th, .history-table td { border: 1.5px solid #b71c1c; padding: 8px; }
        .summary-table .label { font-weight: bold; color: #b71c1c; width: 200px; }
        .summary-table .value { color: #222; }
        .history-table th { background: #f3e5e5; color: #b71c1c; font-weight: bold; }
        .history-table td { color: #222; }
        .no-print { display: block; margin: 24px 0 0 0; text-align: right; }
        @media print { .no-print { display: none !important; } }
    </style>
</head>
<body>
    <div class="header">
        <div class="header-left">
            @if($supplier->company && $supplier->company->logo)
                <img src="{{ asset('storage/' . $supplier->company->logo) }}" class="logo" alt="Company Logo">
            @endif
            <span class="company-name">{{ $supplier->company->name ?? '' }}</span>
        </div>
        <div class="company-details">
            @if($supplier->company && $supplier->company->address) <div><i class="bi bi-geo-alt"></i> {{ $supplier->company->address }}</div> @endif
            @if($supplier->company && $supplier->company->cell_no) <div><i class="bi bi-telephone"></i> {{ $supplier->company->cell_no }}</div> @endif
            @if($supplier->company && $supplier->company->email) <div><i class="bi bi-envelope"></i> {{ $supplier->company->email }}</div> @endif
            @if($supplier->company && $supplier->company->website) <div><i class="bi bi-globe"></i> {{ $supplier->company->website }}</div> @endif
        </div>
    </div>
    <div class="no-print">
        <button onclick="window.print()" style="padding:10px 32px; font-size:1.1rem; background:#b71c1c; color:#fff; border:none; border-radius:6px; cursor:pointer;"><i class="bi bi-printer"></i> Print</button>
    </div>
    <div class="section-title">Supplier Full History</div>
    @if(!empty($from) || !empty($to))
        <div style="text-align:center; font-size: 1em; color: #555; margin-bottom: 12px;">
            @if($from && $to)
                From {{ \Carbon\Carbon::parse($from)->format('d M, Y') }} to {{ \Carbon\Carbon::parse($to)->format('d M, Y') }}
            @elseif($from)
                From {{ \Carbon\Carbon::parse($from)->format('d M, Y') }}
            @elseif($to)
                Up to {{ \Carbon\Carbon::parse($to)->format('d M, Y') }}
            @endif
        </div>
    @endif
    <table class="summary-table">
        <tr><td class="label">Supplier Name:</td><td class="value">{{ $supplier->supplier_name }}</td></tr>
        <tr><td class="label">Country:</td><td class="value">{{ $supplier->country }}</td></tr>
        <tr><td class="label">Total Purchase:</td><td class="value">
            @if($supplier->country == 'Pakistan' || $supplier->currency['code'] == 'PKR')
                Rs {{ number_format($totalPurchase, 2) }} (PKR)
            @else
                {{ $supplier->currency['symbol'] }} {{ number_format($totalPurchase, 2) }} ({{ $supplier->currency['code'] }})
            @endif
        </td></tr>
        <tr><td class="label">Total Paid:</td><td class="value">
            @if($supplier->country == 'Pakistan' || $supplier->currency['code'] == 'PKR')
                Rs {{ number_format($totalPaid, 2) }} (PKR)
            @else
                {{ $supplier->currency['symbol'] }} {{ number_format($totalPaid, 2) }} ({{ $supplier->currency['code'] }})
            @endif
        </td></tr>
        <tr><td class="label">Balance:</td><td class="value">
            @if($supplier->country == 'Pakistan' || $supplier->currency['code'] == 'PKR')
                Rs {{ number_format($balance, 2) }} (PKR)
            @else
                {{ $supplier->currency['symbol'] }} {{ number_format($balance, 2) }} ({{ $supplier->currency['code'] }})
            @endif
        </td></tr>
    </table>
    <div class="section-title">Purchase History</div>
    <table class="history-table">
        <thead>
            <tr>
                <th>Date</th>
                <th>Invoice</th>
                <th>Amount</th>
            </tr>
        </thead>
        <tbody>
            @foreach($purchases as $purchase)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($purchase->purchase_date)->format('d-M-Y') }}</td>
                    <td>D{{ str_pad($purchase->id, 3, '0', STR_PAD_LEFT) }}-{{ str_pad($purchase->id, 5, '0', STR_PAD_LEFT) }}</td>
                    <td>
                        @if($supplier->country == 'Pakistan' || $supplier->currency['code'] == 'PKR')
                            Rs {{ number_format($purchase->total_amount, 2) }} <span class="text-muted">(PKR)</span>
                        @else
                            {{ $supplier->currency['symbol'] }} {{ number_format($purchase->total_amount, 2) }} <span class="text-muted">({{ $supplier->currency['code'] }})</span>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="section-title">Payment History</div>
    <table class="history-table">
        <thead>
            <tr>
                <th>Date</th>
                <th>Amount</th>
                <th>Method</th>
                <th>Note</th>
            </tr>
        </thead>
        <tbody>
            @foreach($payments as $payment)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($payment->payment_date)->format('d-M-Y') }}</td>
                    <td>
                        @if($supplier->country == 'Pakistan' || $supplier->currency['code'] == 'PKR')
                            Rs {{ number_format($payment->amount, 2) }} <span class="text-muted">(PKR)</span>
                        @else
                            {{ $supplier->currency['symbol'] }} {{ number_format($payment->amount, 2) }} <span class="text-muted">({{ $payment->currency_code ?? $supplier->currency['code'] }})</span>
                        @endif
                    </td>
                    <td>{{ $payment->payment_method }}</td>
                    <td>{{ $payment->note }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html> 