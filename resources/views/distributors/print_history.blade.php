<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Distributor Full History - {{ $distributor->name }}</title>
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
            @if($distributor->company && $distributor->company->logo)
                <img src="{{ asset('storage/' . $distributor->company->logo) }}" class="logo" alt="Company Logo">
            @endif
            <span class="company-name">{{ $distributor->company->name ?? '' }}</span>
        </div>
        <div class="company-details">
            @if($distributor->company && $distributor->company->address) <div><i class="bi bi-geo-alt"></i> {{ $distributor->company->address }}</div> @endif
            @if($distributor->company && $distributor->company->cell_no) <div><i class="bi bi-telephone"></i> {{ $distributor->company->cell_no }}</div> @endif
            @if($distributor->company && $distributor->company->email) <div><i class="bi bi-envelope"></i> {{ $distributor->company->email }}</div> @endif
            @if($distributor->company && $distributor->company->website) <div><i class="bi bi-globe"></i> {{ $distributor->company->website }}</div> @endif
        </div>
    </div>
    <div class="no-print">
        <button onclick="window.print()" style="padding:10px 32px; font-size:1.1rem; background:#b71c1c; color:#fff; border:none; border-radius:6px; cursor:pointer;"><i class="bi bi-printer"></i> Print</button>
    </div>
    <div class="section-title">Distributor Full History</div>
    <div style="display: flex; justify-content: center; margin-bottom: 24px;">
        <table style="border: 1.5px solid #b71c1c; border-radius: 10px; width: 700px; background: #fff;">
            <tr>
                <td style="vertical-align: top; width: 50%; border-right: 1.5px solid #b71c1c; padding: 18px 24px;">
                    <div style="margin-bottom: 10px;"><span class="details-label">Name:</span> <span class="details-value">{{ $distributor->name }}</span></div>
                    <div style="margin-bottom: 10px;"><span class="details-label">Phone:</span> <span class="details-value">{{ $distributor->phone ?? '-' }}</span></div>
                    <div style="margin-bottom: 10px;"><span class="details-label">Email:</span> <span class="details-value">{{ $distributor->email ?? '-' }}</span></div>
                    <div style="margin-bottom: 10px;"><span class="details-label">Address:</span> <span class="details-value">{{ $distributor->address ?? '-' }}</span></div>
                    <div style="margin-bottom: 10px;"><span class="details-label">Commission Rate:</span> <span class="details-value">{{ $distributor->commission_rate ?? 0 }}%</span></div>
                </td>
                <td style="vertical-align: top; width: 50%; padding: 18px 24px;">
                    <table class="summary-table">
                        <tr><td class="summary-label">Total Shopkeepers:</td><td class="summary-value">{{ $shopkeepers->count() }}</td></tr>
                        <tr><td class="summary-label">Total Sales:</td><td class="summary-value">Rs {{ number_format($totalSales, 2) }}</td></tr>
                        <tr><td class="summary-label">Total Commission:</td><td class="summary-value">Rs {{ number_format($computedCommission, 2) }}</td></tr>
                        <tr><td class="summary-label">Paid Commission:</td><td class="summary-value">Rs {{ number_format($paidCommission, 2) }}</td></tr>
                        <tr><td class="summary-label">Remaining Commission:</td><td class="summary-value">Rs {{ number_format($remainingCommission, 2) }}</td></tr>
                        <tr><td class="summary-label">Outstanding Balance:</td><td class="summary-value">Rs {{ number_format($totalOutstanding, 2) }}</td></tr>
                    </table>
                </td>
            </tr>
        </table>
    </div>
    <div class="section-title">Shopkeeper Summary</div>
    <table class="history-table">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Total Sale</th>
                <th>Received Amount</th>
                <th>Balance</th>
            </tr>
        </thead>
        <tbody>
            @foreach($shopkeeperSummaries as $i => $sk)
                <tr>
                    <td>{{ $i+1 }}</td>
                    <td>{{ $sk['name'] }}</td>
                    <td>{{ number_format($sk['total_sale'], 2) }}</td>
                    <td>{{ number_format($sk['received'], 2) }}</td>
                    <td>{{ number_format($sk['balance'], 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="section-title">Commission Payment History</div>
    <table class="history-table">
        <thead>
            <tr>
                <th>Date</th>
                <th>Amount</th>
                <th>Note</th>
            </tr>
        </thead>
        <tbody>
            @foreach($commissionPayments as $payment)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($payment->payment_date)->format('d-m-Y') }}</td>
                    <td>{{ number_format($payment->amount, 2) }}</td>
                    <td>{{ $payment->description }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html> 