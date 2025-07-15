<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>All Distributors Summary</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
        body { font-family: Arial, sans-serif; background: #fff; margin: 0; padding: 0; }
        .header { display: flex; justify-content: space-between; align-items: flex-start; border-bottom: 2.5px solid #b71c1c; padding: 24px 32px 12px 32px; }
        .section-title { font-size: 1.3rem; color: #b71c1c; font-weight: bold; margin: 32px 0 16px 0; text-align:center; }
        .summary-table { width: 100%; border-collapse: collapse; margin: 0 auto 32px auto; }
        .summary-table th, .summary-table td { border: 1.5px solid #b71c1c; padding: 8px; }
        .summary-table th { background: #f3e5e5; color: #b71c1c; font-weight: bold; }
        .summary-table td { color: #222; text-align: center; }
        .no-print { display: block; margin: 24px 0 0 0; text-align: right; }
        @media print { .no-print { display: none !important; } }
    </style>
</head>
<body>
    <div class="no-print">
        <button onclick="window.print()" style="padding:10px 32px; font-size:1.1rem; background:#b71c1c; color:#fff; border:none; border-radius:6px; cursor:pointer;"><i class="bi bi-printer"></i> Print</button>
    </div>
    <div class="header">
        @php $company = auth()->user()->company ?? null; @endphp
        <div style="display: flex; align-items: center;">
            @if($company && $company->logo)
                <img src="{{ asset('storage/' . $company->logo) }}" class="logo" alt="Company Logo" style="height:60px; margin-right:18px;">
            @endif
            <span class="company-name" style="font-size:2rem; font-weight:bold; color:#b71c1c;">{{ $company->name ?? '' }}</span>
        </div>
        <div class="company-details" style="text-align:right; font-size:1rem; color:#333; line-height:1.7;">
            @if($company && $company->address) <div><i class="bi bi-geo-alt"></i> {{ $company->address }}</div> @endif
            @if($company && $company->cell_no) <div><i class="bi bi-telephone"></i> {{ $company->cell_no }}</div> @endif
            @if($company && $company->email) <div><i class="bi bi-envelope"></i> {{ $company->email }}</div> @endif
            @if($company && $company->website) <div><i class="bi bi-globe"></i> {{ $company->website }}</div> @endif
        </div>
    </div>
    @if($startDate || $endDate)
        <div style="text-align:center; margin-bottom:12px; color:#b71c1c; font-weight:bold;">
            Showing data
            @if($startDate) from <span>{{ $startDate }}</span>@endif
            @if($endDate) to <span>{{ $endDate }}</span>@endif
        </div>
    @endif
    <div class="section-title">All Distributors Summary</div>
    <table class="summary-table">
        <thead>
            <tr>
                <th>Sr #</th>
                <th>Name</th>
                <th>Commission Rate (%)</th>
                <th>Total Commission</th>
                <th>Paid</th>
                <th>Remaining</th>
                <th>Total Shopkeepers</th>
                <th>Total Sales</th>
                <th>Balance</th>
            </tr>
        </thead>
        <tbody>
            @php
                $sumCommission = 0;
                $sumPaid = 0;
                $sumRemaining = 0;
                $sumShopkeepers = 0;
                $sumSales = 0;
                $sumBalance = 0;
            @endphp
            @foreach($summary as $row)
                @php
                    $sumCommission += $row['total_commission'];
                    $sumPaid += $row['paid'];
                    $sumRemaining += $row['remaining'];
                    $sumShopkeepers += $row['total_shopkeepers'];
                    $sumSales += $row['total_sales'];
                    $sumBalance += $row['balance'];
                @endphp
                <tr>
                    <td>{{ $row['sr'] }}</td>
                    <td>{{ $row['name'] }}</td>
                    <td>{{ number_format($row['commission_rate'], 2) }}</td>
                    <td>{{ number_format($row['total_commission'], 2) }}</td>
                    <td>{{ number_format($row['paid'], 2) }}</td>
                    <td>{{ number_format($row['remaining'], 2) }}</td>
                    <td>{{ $row['total_shopkeepers'] }}</td>
                    <td>{{ number_format($row['total_sales'], 2) }}</td>
                    <td>{{ number_format($row['balance'], 2) }}</td>
                </tr>
            @endforeach
            <tr style="font-weight:bold; background:#f3e5e5; color:#b71c1c;">
                <td colspan="3" style="text-align:right;">Total:</td>
                <td>{{ number_format($sumCommission, 2) }}</td>
                <td>{{ number_format($sumPaid, 2) }}</td>
                <td>{{ number_format($sumRemaining, 2) }}</td>
                <td>{{ $sumShopkeepers }}</td>
                <td>{{ number_format($sumSales, 2) }}</td>
                <td>{{ number_format($sumBalance, 2) }}</td>
            </tr>
        </tbody>
    </table>
</body>
</html> 