<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Customer Full History - {{ $customer->name }}</title>
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
            @if($customer->company && $customer->company->logo)
                <img src="{{ asset('storage/' . $customer->company->logo) }}" class="logo" alt="Company Logo">
            @endif
            <span class="company-name">{{ $customer->company->name ?? '' }}</span>
        </div>
        <div class="company-details">
            @if($customer->company && $customer->company->address) <div><i class="bi bi-geo-alt"></i> {{ $customer->company->address }}</div> @endif
            @if($customer->company && $customer->company->cell_no) <div><i class="bi bi-telephone"></i> {{ $customer->company->cell_no }}</div> @endif
            @if($customer->company && $customer->company->email) <div><i class="bi bi-envelope"></i> {{ $customer->company->email }}</div> @endif
            @if($customer->company && $customer->company->website) <div><i class="bi bi-globe"></i> {{ $customer->company->website }}</div> @endif
        </div>
    </div>
    <div class="no-print">
        <button onclick="window.print()" style="padding:10px 32px; font-size:1.1rem; background:#b71c1c; color:#fff; border:none; border-radius:6px; cursor:pointer;"><i class="bi bi-printer"></i> Print</button>
    </div>
    <div class="section-title">Customer Full History</div>
    @if(!empty($fromParam) || !empty($toParam))
        <div style="text-align:center; font-size: 1em; color: #555; margin-bottom: 12px;">
            @if($fromParam && $toParam)
                From {{ \Carbon\Carbon::parse($fromParam)->format('d M, Y') }} to {{ \Carbon\Carbon::parse($toParam)->format('d M, Y') }}
            @elseif($fromParam)
                From {{ \Carbon\Carbon::parse($fromParam)->format('d M, Y') }}
            @elseif($toParam)
                Up to {{ \Carbon\Carbon::parse($toParam)->format('d M, Y') }}
            @endif
        </div>
    @endif
    <table class="summary-table">
        <tr><td class="label">Customer Name:</td><td class="value">{{ $customer->name }}</td></tr>
        <tr><td class="label">Type:</td><td class="value">{{ ucfirst($customer->type) }}</td></tr>
        <tr><td class="label">Cell No:</td><td class="value">{{ $customer->cel_no ?: 'N/A' }}</td></tr>
        <tr><td class="label">Email:</td><td class="value">{{ $customer->email ?: 'N/A' }}</td></tr>
        <tr><td class="label">Address:</td><td class="value">{{ $customer->address ?: 'N/A' }}</td></tr>
        <tr><td class="label">City:</td><td class="value">{{ $customer->city ?: 'N/A' }}</td></tr>
        <tr><td class="label">Total Sales:</td><td class="value">{{ number_format($totalSales, 2) }}</td></tr>
        <tr><td class="label">Total Returns:</td><td class="value">{{ number_format($totalReturns, 2) }}</td></tr>
        <tr><td class="label">Total Received:</td><td class="value">{{ number_format($totalPaid, 2) }}</td></tr>
        <tr><td class="label">Balance:</td><td class="value">{{ number_format($outstanding, 2) }}</td></tr>
    </table>
    <table class="history-table">
        <caption style="caption-side:top; text-align:left; font-weight:bold; color:#b71c1c; font-size:1.1em; padding-bottom:4px;">Sales History</caption>
        <thead>
            <tr>
                <th>Sale Code</th>
                <th>Date</th>
                <th>Total</th>
                <th>Returned</th>
                <th>Outstanding</th>
            </tr>
        </thead>
        <tbody>
            @foreach($sales as $sale)
                <tr>
                    <td>{{ $sale->sale_code }}</td>
                    <td>{{ $sale->created_at->format('d-m-Y h:i A') }}</td>
                    <td>{{ number_format($sale->total_amount, 2) }}</td>
                    <td>{{ number_format($sale->total_returned, 2) }}</td>
                    <td>{{ number_format($sale->outstanding, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <table class="history-table">
        <caption style="caption-side:top; text-align:left; font-weight:bold; color:#b71c1c; font-size:1.1em; padding-bottom:4px;">Payment History</caption>
        <thead>
            <tr>
                <th>Date</th>
                <th>Amount</th>
                <th>Note</th>
            </tr>
        </thead>
        <tbody>
            @foreach($payments as $payment)
                <tr>
                    <td>{{ $payment->date ?? $payment->created_at->format('Y-m-d') }}</td>
                    <td>{{ number_format($payment->amount_paid, 2) }}</td>
                    <td>{{ $payment->note }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <table class="history-table">
        <caption style="caption-side:top; text-align:left; font-weight:bold; color:#b71c1c; font-size:1.1em; padding-bottom:4px;">Payment & Return Timeline</caption>
        <thead>
            <tr>
                <th>Date</th>
                <th>Description</th>
                <th>Amount</th>
                <th>Balance</th>
            </tr>
        </thead>
        <tbody>
            @php
                $events = [];
                foreach ($sales as $sale) {
                    $events[] = [
                        'type' => 'sale',
                        'date' => $sale->created_at,
                        'desc' => 'Sale: ' . $sale->sale_code,
                        'amount' => $sale->total_amount,
                    ];
                    foreach ($sale->returns as $ret) {
                        $events[] = [
                            'type' => 'return',
                            'date' => $ret->created_at,
                            'desc' => 'Return: ' . ($ret->item->item_name ?? '-') . ' x' . $ret->quantity,
                            'amount' => -($ret->amount * $ret->quantity),
                        ];
                    }
                }
                foreach ($payments as $pay) {
                    $events[] = [
                        'type' => 'payment',
                        'date' => $pay->created_at,
                        'desc' => 'Payment',
                        'amount' => -$pay->amount_paid,
                    ];
                }
                usort($events, function($a, $b) { return $a['date'] <=> $b['date']; });
                $runningBalance = 0;
            @endphp
            @foreach($events as $event)
                @php $runningBalance += $event['amount']; @endphp
                <tr>
                    <td>{{ $event['date']->format('d-m-Y h:i A') }}</td>
                    <td>{{ $event['desc'] }}</td>
                    <td>{{ number_format($event['amount'], 2) }}</td>
                    <td>{{ number_format($runningBalance, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    @if($customer->company && $customer->company->logo)
    <div style="position:fixed; top:50%; left:50%; transform:translate(-50%,-50%); z-index:0; opacity:0.07; pointer-events:none; width:60vw; max-width:600px;">
        <img src="{{ asset('storage/' . $customer->company->logo) }}" alt="Watermark Logo" style="width:100%; height:auto;">
    </div>
    @endif
</body>
</html> 