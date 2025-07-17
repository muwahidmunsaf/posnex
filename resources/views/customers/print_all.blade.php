<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>All Customers Report</title>
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
        .customers-table { width: 100%; border-collapse: collapse; margin-bottom: 24px; }
        .customers-table th, .customers-table td { border: 1.5px solid #b71c1c; padding: 8px; }
        .customers-table th { background: #f3e5e5; color: #b71c1c; font-weight: bold; }
        .customers-table td { color: #222; }
        .no-print { display: block; margin: 24px 0 0 0; text-align: right; }
        @media print { .no-print { display: none !important; } }
    </style>
</head>
<body>
    <div class="header">
        <div class="header-left">
            @if($company && $company->logo)
                <img src="{{ asset('storage/' . $company->logo) }}" class="logo" alt="Company Logo">
            @endif
            <span class="company-name">{{ $company->name ?? '' }}</span>
        </div>
        <div class="company-details">
            @if($company && $company->address) <div><i class="bi bi-geo-alt"></i> {{ $company->address }}</div> @endif
            @if($company && $company->cell_no) <div><i class="bi bi-telephone"></i> {{ $company->cell_no }}</div> @endif
            @if($company && $company->email) <div><i class="bi bi-envelope"></i> {{ $company->email }}</div> @endif
            @if($company && $company->website) <div><i class="bi bi-globe"></i> {{ $company->website }}</div> @endif
        </div>
    </div>
    <div class="no-print">
        <button onclick="window.print()" style="padding:10px 32px; font-size:1.1rem; background:#b71c1c; color:#fff; border:none; border-radius:6px; cursor:pointer;"><i class="bi bi-printer"></i> Print</button>
    </div>
    <div class="section-title">All Customers Report</div>
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
    <table class="customers-table">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>City</th>
                <th>Total Sale</th>
                <th>Received Amount</th>
                <th>Balance</th>
            </tr>
        </thead>
        <tbody>
            @php
                $totalSale = 0;
                $totalReceived = 0;
                $totalBalance = 0;
            @endphp
            @foreach($customers as $i => $customer)
                @php
                   $sales = $customer->sales;
                   $payments = $customer->payments;
                   if (!empty($fromParam)) {
                       $sales = $sales->filter(function($sale) use ($fromParam) {
                           return $sale->created_at >= $fromParam;
                       });
                       $payments = $payments->filter(function($pay) use ($fromParam) {
                           return $pay->created_at >= $fromParam;
                       });
                   }
                   if (!empty($toParam)) {
                       $sales = $sales->filter(function($sale) use ($toParam) {
                           return $sale->created_at <= $toParam;
                       });
                       $payments = $payments->filter(function($pay) use ($toParam) {
                           return $pay->created_at <= $toParam;
                       });
                   }
                    $sale = $sales->sum('total_amount');
                    $received = $payments->sum('amount_paid') + $sales->sum('amount_received');
                    $balance = $sale - $received;
                    $totalSale += $sale;
                    $totalReceived += $received;
                    $totalBalance += $balance;
                @endphp
                <tr>
                    <td>{{ $i+1 }}</td>
                    <td>{{ $customer->name }}</td>
                    <td>{{ $customer->city }}</td>
                    <td>{{ number_format($sale, 2) }}</td>
                    <td>{{ number_format($received, 2) }}</td>
                    <td>{{ number_format($balance, 2) }}</td>
                </tr>
            @endforeach
            <tr style="font-weight:bold; background:#f3e5e5; color:#b71c1c;">
                <td colspan="3" style="text-align:right;">Total</td>
                <td>{{ number_format($totalSale, 2) }}</td>
                <td>{{ number_format($totalReceived, 2) }}</td>
                <td>{{ number_format($totalBalance, 2) }}</td>
            </tr>
        </tbody>
    </table>
    @if($company && $company->logo)
    <div style="position:fixed; top:50%; left:50%; transform:translate(-50%,-50%); z-index:0; opacity:0.07; pointer-events:none; width:60vw; max-width:600px;">
        <img src="{{ asset('storage/' . $company->logo) }}" alt="Watermark Logo" style="width:100%; height:auto;">
    </div>
    @endif
</body>
</html> 