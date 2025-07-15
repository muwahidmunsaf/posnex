<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>All Suppliers Report</title>
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
        .suppliers-table { width: 100%; border-collapse: collapse; margin-bottom: 24px; }
        .suppliers-table th, .suppliers-table td { border: 1.5px solid #b71c1c; padding: 8px; }
        .suppliers-table th { background: #f3e5e5; color: #b71c1c; font-weight: bold; }
        .suppliers-table td { color: #222; }
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
    <div class="section-title">All Suppliers Report</div>
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
    <table class="suppliers-table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Country</th>
                <th>Total Purchase</th>
                <th>Total Paid</th>
                <th>Balance</th>
            </tr>
        </thead>
        <tbody>
            @foreach($supplierSummaries as $s)
                <tr>
                    <td>{{ $s['name'] }}</td>
                    <td>{{ $s['country'] }}</td>
                    <td>{{ $s['currency_symbol'] }} {{ number_format($s['total_purchase'], 2) }} <span class="text-muted">({{ $s['currency_code'] }})</span></td>
                    <td>{{ $s['currency_symbol'] }} {{ number_format($s['total_paid'], 2) }} <span class="text-muted">({{ $s['currency_code'] }})</span></td>
                    <td>{{ $s['currency_symbol'] }} {{ number_format($s['balance'], 2) }} <span class="text-muted">({{ $s['currency_code'] }})</span></td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html> 