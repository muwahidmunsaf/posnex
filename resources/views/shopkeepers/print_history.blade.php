<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Shopkeeper Full History - {{ $shopkeeper->name }}</title>
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
        .two-col-card { display: flex; gap: 32px; margin: 32px 0 24px 0; }
        .details-col, .summary-col { flex: 1; background: #fff; border: 1.5px solid #b71c1c; border-radius: 10px; padding: 18px 24px; }
        .details-col { min-width: 260px; }
        .summary-col { min-width: 260px; }
        .details-label { color: #b71c1c; font-weight: bold; width: 120px; display: inline-block; }
        .details-value { color: #222; }
        .summary-table { width: 100%; border-collapse: collapse; }
        .summary-table td { border: none; padding: 6px 0; }
        .summary-label { color: #b71c1c; font-weight: bold; }
        .summary-value { color: #222; font-weight: 600; }
        .history-table { width: 100%; border-collapse: collapse; margin-bottom: 24px; }
        .history-table th, .history-table td { border: 1.5px solid #b71c1c; padding: 8px; }
        .history-table th { background: #f3e5e5; color: #b71c1c; font-weight: bold; }
        .history-table td { color: #222; }
        .no-print { display: block; margin: 24px 0 0 0; text-align: right; }
        @media print { .no-print { display: none !important; } }
        @media (max-width: 900px) {
            .two-col-card { flex-direction: column; gap: 12px; }
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="header-left">
            @if($shopkeeper->company && $shopkeeper->company->logo)
                <img src="{{ asset('storage/' . $shopkeeper->company->logo) }}" class="logo" alt="Company Logo">
            @endif
            <span class="company-name">{{ $shopkeeper->company->name ?? '' }}</span>
        </div>
        <div class="company-details">
            @if($shopkeeper->company && $shopkeeper->company->address) <div><i class="bi bi-geo-alt"></i> {{ $shopkeeper->company->address }}</div> @endif
            @if($shopkeeper->company && $shopkeeper->company->cell_no) <div><i class="bi bi-telephone"></i> {{ $shopkeeper->company->cell_no }}</div> @endif
            @if($shopkeeper->company && $shopkeeper->company->email) <div><i class="bi bi-envelope"></i> {{ $shopkeeper->company->email }}</div> @endif
            @if($shopkeeper->company && $shopkeeper->company->website) <div><i class="bi bi-globe"></i> {{ $shopkeeper->company->website }}</div> @endif
        </div>
    </div>
    @if($shopkeeper->company && $shopkeeper->company->logo)
    <div style="position:fixed; top:50%; left:50%; transform:translate(-50%,-50%); z-index:0; opacity:0.07; pointer-events:none; width:60vw; max-width:600px;">
        <img src="{{ asset('storage/' . $shopkeeper->company->logo) }}" alt="Watermark Logo" style="width:100%; height:auto;">
    </div>
    @endif
    <!-- End Watermark -->
    <div class="no-print">
        <button onclick="window.print()" style="padding:10px 32px; font-size:1.1rem; background:#b71c1c; color:#fff; border:none; border-radius:6px; cursor:pointer;"><i class="bi bi-printer"></i> Print</button>
    </div>
    <div class="section-title">Shopkeeper Full History</div>
    <div style="display: flex; justify-content: center; margin-bottom: 24px;">
        <table style="border: 1.5px solid #b71c1c; border-radius: 10px; width: 700px; background: #fff;">
            <tr>
                <td style="vertical-align: top; width: 50%; border-right: 1.5px solid #b71c1c; padding: 18px 24px;">
                    <div style="margin-bottom: 10px;"><span class="details-label">Name:</span> <span class="details-value">{{ $shopkeeper->name ?: 'N/A' }}</span></div>
                    <div style="margin-bottom: 10px;"><span class="details-label">Distributor:</span> <span class="details-value">{{ $shopkeeper->distributor->name ?? 'N/A' }}</span></div>
                    <div style="margin-bottom: 10px;"><span class="details-label">Phone:</span> <span class="details-value">{{ $shopkeeper->phone ?: 'N/A' }}</span></div>
                    <div style="margin-bottom: 10px;"><span class="details-label">Address:</span> <span class="details-value">{{ $shopkeeper->address ?: 'N/A' }}</span></div>
                </td>
                <td style="vertical-align: top; width: 50%; padding: 18px 24px;">
                    <table class="summary-table">
                        <tr><td class="summary-label">Total Sales:</td><td class="summary-value">Rs {{ number_format($totalSales, 2) }}</td></tr>
                        <tr><td class="summary-label">Total Returned:</td><td class="summary-value">Rs {{ number_format($totalReturns, 2) }}</td></tr>
                        <tr><td class="summary-label">Total Paid:</td><td class="summary-value">Rs {{ number_format($totalPaid, 2) }}</td></tr>
                        <tr><td class="summary-label">Balance:</td><td class="summary-value">Rs {{ number_format($outstanding, 2) }}</td></tr>
                    </table>
                </td>
            </tr>
        </table>
    </div>
    <div class="section-title">Sales History</div>
    <table class="history-table">
        <thead>
            <tr>
                <th>#</th>
                <th>Sale Code</th>
                <th>Date</th>
                <th>Quantity</th>
                <th>Total</th>
                <th>Returned</th>
                <th>Balance</th>
            </tr>
        </thead>
        <tbody>
            @foreach($sales as $i => $sale)
                <tr>
                    <td>{{ $i+1 }}</td>
                    <td>{{ $sale->sale_code }}</td>
                    <td>{{ $sale->created_at->format('d-m-Y h:i A') }}</td>
                    <td>{{ $sale->inventorySales->sum('quantity') }}</td>
                    <td>{{ number_format($sale->total_amount, 2) }}</td>
                    <td>{{ number_format($sale->total_returned, 2) }}</td>
                    <td>{{ number_format($sale->outstanding, 2) }}</td>
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
                <th>Note</th>
            </tr>
        </thead>
        <tbody>
            @foreach($payments as $payment)
                <tr>
                    <td>{{ $payment->transaction_date->format('d-m-Y') }}</td>
                    <td>{{ number_format($payment->total_amount, 2) }}</td>
                    <td>{{ $payment->description }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="section-title">Payment & Return Timeline</div>
    <table class="history-table">
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
                        'date' => $pay->transaction_date,
                        'desc' => 'Payment',
                        'amount' => -$pay->total_amount,
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
</body>
</html> 