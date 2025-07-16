@extends('layouts.app')

@section('content')
<style>
    .summary-card {
        box-shadow: 0 2px 8px rgba(183,28,28,0.08); border-radius: 12px; border: 1.5px solid #b71c1c;
        margin-bottom: 12px; background: #fff; min-height: 100px;
    }
    .summary-card strong { color: #b71c1c; font-size: 1em; }
    .summary-value { font-size: 1.15em; font-weight: 600; color: #222; }
    .summary-pkr { font-size: 0.95em; color: #666; }
    .section-title {
        font-size: 1.08em; color: #b71c1c; font-weight: 600; margin-bottom: 10px; display: flex; align-items: center; gap: 8px;
        letter-spacing: 0.2px;
    }
    .table-card {
        background: #fff; border-radius: 12px; box-shadow: 0 2px 8px rgba(183,28,28,0.07);
        padding: 14px 8px 8px 8px; margin-bottom: 18px; border: 1.5px solid #f3e5e5;
    }
    .table-custom th, .table-custom td { vertical-align: middle !important; padding: 6px 8px; font-size: 0.98em; }
    .table-custom th { background: #f3e5e5; color: #b71c1c; font-weight: 600; font-size: 1em; }
    .table-custom tbody tr:nth-child(even) { background: #faf6f6; }
    .table-custom tbody tr:hover { background: #ffeaea; }
    .amount-main { font-weight: 600; font-size: 1em; color: #222; }
    .amount-pkr { font-size: 0.92em; color: #888; font-weight: normal; display: block; margin-top: 2px; }
    .action-icons { display: flex; align-items: center; justify-content: center; gap: 8px; }
    .action-icons .bi { font-size: 1.1em; cursor: pointer; }
    .action-icons .bi-trash { color: #b71c1c; }
    .action-icons .bi-printer { color: #333; }
    .btn-sm { font-size: 0.92em; padding: 2px 10px; border-radius: 5px; }
    @media (max-width: 991px) {
        .table-card { margin-bottom: 12px; padding: 8px 2px; }
    }
    @media (max-width: 767px) {
        .row.mb-4 > .col-md-6 { margin-bottom: 12px; }
    }
</style>
<div class="container">
    <div class="card mb-4 p-3 d-flex flex-md-row align-items-center justify-content-between" style="border:1.5px solid #b71c1c; border-radius:12px; box-shadow:0 2px 8px rgba(183,28,28,0.08);">
        <div class="d-flex align-items-center">
            <div>
                <div style="font-size:1.5em; font-weight:bold; color:#b71c1c;">Name: {{ $supplier->supplier_name }}</div>
                <div style="color:#333; font-size:1em;">Contact Person: <span style="font-weight:bold; color:#b71c1c;">{{ $supplier->contact_person }}</span></div>
                <div style="color:#333; font-size:1em;">Phone: <span style="font-weight:bold; color:#b71c1c;">{{ $supplier->cell_no }}</span></div>
                @if($supplier->email)
                <div style="color:#333; font-size:1em;">Email: <span style="font-weight:bold; color:#b71c1c;">{{ $supplier->email }}</span></div>
                @endif
                @if($supplier->address)
                <div style="color:#333; font-size:1em;">Address: <span style="font-weight:bold; color:#b71c1c;">{{ $supplier->address }}</span></div>
                @endif
                <div style="color:#333; font-size:1em;">Country: <span style="font-weight:bold; color:#b71c1c;">{{ $supplier->country }}</span></div>
            </div>
        </div>
        <div class="d-flex flex-column align-items-end">
            <a href="{{ route('suppliers.printHistory', $supplier->id) }}" target="_blank" class="btn btn-danger mb-2"><i class="bi bi-printer"></i> Print Full History</a>
        </div>
    </div>
    @if($supplier->currency['code'] !== 'PKR' && $currentRate)
        <div class="alert alert-info" style="font-size:1.1em;">
            <i class="bi bi-currency-exchange"></i> Current Rate: 1 {{ $supplier->currency['code'] }} = {{ number_format($currentRate, 4) }} PKR
        </div>
    @endif
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="summary-card p-3">
                <strong><i class="bi bi-bag"></i> Total Purchase:</strong><br>
                <span class="summary-value">
                @if($supplier->country == 'Pakistan' || $supplier->currency['code'] == 'PKR')
                    Rs {{ number_format($totalPurchase, 2) }} <span class="text-muted" style="font-size:0.7em;">(PKR)</span>
                @else
                    {{ $supplier->currency['symbol'] }} {{ number_format($totalPurchase, 2) }} <span class="text-muted">({{ $supplier->currency['code'] }})</span>
                @endif
                </span>
                @if($supplier->country != 'Pakistan' && $supplier->currency['code'] != 'PKR')
                    <br><span class="summary-pkr">Rs {{ number_format($totalPurchase * $currentRate, 2) }} (PKR, current rate)</span>
                @endif
            </div>
        </div>
        <div class="col-md-4">
            <div class="summary-card p-3">
                <strong><i class="bi bi-cash-coin"></i> Total Paid:</strong><br>
                <span class="summary-value">
                @if($supplier->country == 'Pakistan' || $supplier->currency['code'] == 'PKR')
                    Rs {{ number_format($totalPaid, 2) }} <span class="text-muted" style="font-size:0.7em;">(PKR)</span>
                @else
                    {{ $supplier->currency['symbol'] }} {{ number_format($totalPaid, 2) }} <span class="text-muted">({{ $supplier->currency['code'] }})</span>
                @endif
                </span>
                @if($supplier->country != 'Pakistan' && $supplier->currency['code'] != 'PKR')
                    <br><span class="summary-pkr">Rs {{ number_format($totalPaid * $currentRate, 2) }} (PKR, current rate)</span>
                @endif
            </div>
        </div>
        <div class="col-md-4">
            <div class="summary-card p-3">
                <strong><i class="bi bi-wallet2"></i> Balance:</strong><br>
                <span class="summary-value">
                @if($supplier->country == 'Pakistan' || $supplier->currency['code'] == 'PKR')
                    Rs {{ number_format($balance, 2) }} <span class="text-muted" style="font-size:0.7em;">(PKR)</span>
                @else
                    {{ $supplier->currency['symbol'] }} {{ number_format($balance, 2) }} <span class="text-muted">({{ $supplier->currency['code'] }})</span>
                @endif
                </span>
                @if($supplier->country != 'Pakistan' && $supplier->currency['code'] != 'PKR')
                    <br><span class="summary-pkr">Rs {{ number_format($balance * $currentRate, 2) }} (PKR, current rate)</span>
                @endif
            </div>
        </div>
    </div>
    <div class="mb-4">
        <div class="table-card mb-3">
            <div class="section-title" style="cursor:pointer;" data-bs-toggle="collapse" data-bs-target="#purchaseHistoryCollapse" aria-expanded="false" aria-controls="purchaseHistoryCollapse">
                <i class="bi bi-bag-check"></i> Purchase History
                <button class="btn btn-sm btn-outline-secondary ms-2" type="button" data-bs-toggle="collapse" data-bs-target="#purchaseHistoryCollapse" aria-expanded="false" aria-controls="purchaseHistoryCollapse">
                    <span class="collapsed">View</span><span class="collapse">Hide</span>
                </button>
            </div>
            <div class="collapse" id="purchaseHistoryCollapse">
                <div class="table-responsive">
                    <table class="table table-bordered table-custom">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Invoice</th>
                                <th>Amount</th>
                                <th>Print</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($purchases as $purchase)
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($purchase->purchase_date)->format('d-M-Y') }}</td>
                                    <td>D{{ str_pad($purchase->id, 3, '0', STR_PAD_LEFT) }}-{{ str_pad($purchase->id, 5, '0', STR_PAD_LEFT) }}</td>
                                    <td style="text-align:left;">
                                        <span class="amount-main">
                                        @if($supplier->country == 'Pakistan' || $supplier->currency['code'] == 'PKR')
                                            Rs {{ number_format($purchase->total_amount, 2) }} (PKR)
                                        @else
                                            {{ $supplier->currency['symbol'] }} {{ number_format($purchase->total_amount, 2) }} ({{ $supplier->currency['code'] }})
                                        @endif
                                        </span>
                                        @if($supplier->country != 'Pakistan' && $supplier->currency['code'] != 'PKR')
                                            <span class="amount-pkr">Rs {{ number_format($purchase->total_amount * $currentRate, 2) }} (PKR, current rate)
                                            @if($purchase->pkr_amount && $purchase->exchange_rate_to_pkr)
                                                <br>(At time: Rs {{ number_format($purchase->pkr_amount, 2) }} @ {{ number_format($purchase->exchange_rate_to_pkr, 4) }})
                                            @endif
                                            </span>
                                        @endif
                                    </td>
                                    <td class="action-icons">
                                        <a href="{{ route('purchase.print', $purchase->id) }}" target="_blank" title="Print Invoice">
                                            <i class="bi bi-printer" data-bs-toggle="tooltip" title="Print"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="table-card">
            <div class="section-title" style="cursor:pointer;" data-bs-toggle="collapse" data-bs-target="#paymentHistoryCollapse" aria-expanded="false" aria-controls="paymentHistoryCollapse">
                <i class="bi bi-cash-stack"></i> Payment History
                <button class="btn btn-sm btn-outline-secondary ms-2" type="button" data-bs-toggle="collapse" data-bs-target="#paymentHistoryCollapse" aria-expanded="false" aria-controls="paymentHistoryCollapse">
                    <span class="collapsed">View</span><span class="collapse">Hide</span>
                </button>
            </div>
            <div class="collapse" id="paymentHistoryCollapse">
                <div class="table-responsive">
                    <table class="table table-bordered table-custom">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Amount</th>
                                <th>Method</th>
                                <th>Note</th>
                                <th>Print / Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($payments as $payment)
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($payment->payment_date)->format('d-M-Y') }}</td>
                                    <td style="text-align:left;">
                                        <span class="amount-main">
                                        @if($supplier->country == 'Pakistan' || $supplier->currency['code'] == 'PKR')
                                            Rs {{ number_format($payment->amount, 2) }} (PKR)
                                        @else
                                            {{ $supplier->currency['symbol'] }} {{ number_format($payment->amount, 2) }} ({{ $payment->currency_code ?? $supplier->currency['code'] }})
                                        @endif
                                        </span>
                                        @if($supplier->country != 'Pakistan' && $supplier->currency['code'] != 'PKR')
                                            <span class="amount-pkr">Rs {{ number_format($payment->amount * $currentRate, 2) }} (PKR, current rate)
                                            @if($payment->pkr_amount && $payment->exchange_rate_to_pkr)
                                                <br>(At time: Rs {{ number_format($payment->pkr_amount, 2) }} @ {{ number_format($payment->exchange_rate_to_pkr, 4) }})
                                            @endif
                                            </span>
                                        @endif
                                    </td>
                                    <td>{{ $payment->payment_method }}</td>
                                    <td>{{ $payment->note }}</td>
                                    <td class="action-icons">
                                        <a href="{{ route('suppliers.printPaymentReceipt', ['supplier' => $supplier->id, 'payment' => $payment->id]) }}" target="_blank" title="Print Payment Receipt">
                                            <i class="bi bi-printer" data-bs-toggle="tooltip" title="Print"></i>
                                        </a>
                                        <form action="{{ route('suppliers.deletePayment', ['supplier' => $supplier->id, 'payment' => $payment->id]) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-link p-0 ms-2" onclick="return confirm('Delete this payment?')" title="Delete Payment">
                                                <i class="bi bi-trash" style="color:#b71c1c; font-size:1.3em;" data-bs-toggle="tooltip" title="Delete"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="payment-form-card">
        <h6 class="mb-3" style="color:#b71c1c;"><i class="bi bi-plus-circle"></i> Record New Payment</h6>
        <form method="POST" action="{{ route('suppliers.pay', $supplier->id) }}">
            @csrf
            <div class="mb-2">
                <label>Amount</label>
                <input type="number" step="0.01" name="amount" class="form-control" required>
            </div>
            <div class="mb-2">
                <label>Date</label>
                <input type="date" name="payment_date" class="form-control" value="{{ date('Y-m-d') }}" required>
            </div>
            <div class="mb-2">
                <label>Method</label>
                <input type="text" name="payment_method" class="form-control">
            </div>
            <div class="mb-2">
                <label>Note</label>
                <input type="text" name="note" class="form-control">
            </div>
            @if($supplier->country != 'Pakistan' && $supplier->currency['code'] != 'PKR')
            <div class="mb-2">
                <label>Currency</label>
                <input type="text" name="currency_code" class="form-control" value="{{ $supplier->currency['code'] }}" readonly>
            </div>
            <div class="mb-2">
                <label>Exchange Rate to PKR (at time of payment)</label>
                <input type="number" step="0.00001" name="exchange_rate_to_pkr" class="form-control" value="{{ $currentRate }}" required>
                <small class="text-muted">Enter the rate at the time of payment. 1 {{ $supplier->currency['code'] }} = {{ $currentRate }} PKR</small>
            </div>
            @endif
            <button class="btn btn-success"><i class="bi bi-cash"></i> Pay Supplier</button>
        </form>
    </div>
</div>
@endsection 