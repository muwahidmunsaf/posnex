<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Catalogue - {{ $company->name }}</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 0; background: #fff; }
        .header { display: flex; justify-content: space-between; align-items: center; border-bottom: 2px solid #b71c1c; padding: 24px 32px 12px 32px; }
        .header-left { display: flex; align-items: center; }
        .logo { height: 60px; margin-right: 18px; }
        .company-name { font-size: 2rem; font-weight: bold; color: #b71c1c; }
        .company-details { text-align: right; font-size: 1rem; color: #333; }
        .title { text-align: center; font-size: 2.2rem; font-weight: bold; color: #b71c1c; margin: 32px 0 18px 0; letter-spacing: 2px; }
        table { width: 95%; margin: 0 auto 32px auto; border-collapse: collapse; }
        th, td { border: 1px solid #b71c1c; padding: 8px 12px; font-size: 1rem; }
        th { background: #b71c1c; color: #fff; font-weight: bold; }
        tr:nth-child(even) { background: #f8d7da; }
        @media print {
            .no-print { display: none !important; }
            body { background: #fff !important; }
            .header { border-bottom: 2px solid #b71c1c !important; }
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="header-left">
            @if($company->logo)
                <img src="{{ asset('storage/' . $company->logo) }}" class="logo" alt="Company Logo">
            @endif
            <span class="company-name">{{ $company->name }}</span>
        </div>
        <div class="company-details">
            @if($company->address) <div>{{ $company->address }}</div> @endif
            @if($company->cell_no) <div>Phone: {{ $company->cell_no }}</div> @endif
            @if($company->email) <div>Email: {{ $company->email }}</div> @endif
            @if($company->website) <div>Website: {{ $company->website }}</div> @endif
        </div>
    </div>
    <div class="title">Catalogue</div>
    <table>
        <thead>
            <tr>
                <th>Sr#</th>
                <th>Item Name</th>
                <th>Retail Price</th>
                <th>Wholesale Price</th>
            </tr>
        </thead>
        <tbody>
            @foreach($inventories as $i => $item)
                <tr>
                    <td>{{ $i+1 }}</td>
                    <td>{{ $item->item_name }}</td>
                    <td>{{ $item->retail_amount }}</td>
                    <td>{{ $item->wholesale_amount }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="no-print" style="text-align:center; margin-bottom:32px;">
        <button onclick="window.print()" style="padding:10px 32px; font-size:1.1rem; background:#b71c1c; color:#fff; border:none; border-radius:6px; cursor:pointer;">Print</button>
    </div>
</body>
</html> 