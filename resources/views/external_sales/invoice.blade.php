<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Manual Sale Invoice - {{ $sale->saleE_id }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 0; background: #fff; }
        .header { display: flex; justify-content: space-between; align-items: flex-start; border-bottom: 2.5px solid #b71c1c; padding: 24px 32px 12px 32px; }
        .header-left { display: flex; align-items: center; }
        .logo { height: 60px; margin-right: 18px; }
        .company-name { font-size: 2rem; font-weight: bold; color: #b71c1c; }
        .company-details { text-align: right; font-size: 1rem; color: #333; line-height: 1.7; }
        .company-details i { color: #b71c1c; margin-right: 4px; }
        .summary-row { display: flex; justify-content: flex-start; align-items: center; gap: 32px; margin: 24px 0 0 32px; }
        .summary-row span { font-weight: bold; font-size: 1.08rem; color: #b71c1c; margin-right: 12px; }
        .summary-row .value { color: #222; font-weight: normal; margin-right: 24px; }
        .amount-due { text-align: right; font-size: 1.5rem; font-weight: bold; color: #888; margin: 0 32px 0 0; }
        .amount-due strong { color: #b71c1c; }
        .to-block { margin: 18px 0 0 32px; font-size: 1.05rem; }
        .to-block b { color: #b71c1c; }
        .to-block .label { font-weight: bold; }
        .to-block .value { color: #222; }
        .table-container { margin: 24px 32px 0 32px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 0; }
        th, td { border: 1.5px solid #b71c1c; padding: 8px 12px; font-size: 1rem; }
        th { background: #b71c1c; color: #fff; font-weight: bold; text-align: center; }
        td { text-align: center; }
        tr.total-row td { font-weight: bold; background: #f3e5e5; }
        .totals-block { width: 350px; float: right; margin: 18px 32px 0 0; font-size: 1.05rem; }
        .totals-block table { width: 100%; border: none; }
        .totals-block td { border: none; padding: 4px 0; text-align: right; }
        .totals-block .label { color: #333; }
        .totals-block .value { color: #222; }
        .totals-block .grand { font-weight: bold; color: #b71c1c; font-size: 1.13rem; }
        .terms { clear: both; margin: 48px 32px 0 32px; font-size: 0.98rem; color: #b71c1c; }
        .thankyou { text-align: center; font-size: 1.1rem; color: #b71c1c; margin-top: 32px; font-weight: bold; letter-spacing: 1px; }
        @media print {
            .no-print { display: none !important; }
            body { background: #fff !important; }
            .header { border-bottom: 2.5px solid #b71c1c !important; }
            .totals-block { float: none; margin: 18px auto 0 auto; }
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="header-left">
            @if(auth()->user()->company->logo ?? false)
                <img src="{{ asset('storage/' . auth()->user()->company->logo) }}" class="logo" alt="Company Logo">
            @endif
            <span class="company-name">{{ auth()->user()->company->name ?? 'POS System' }}</span>
        </div>
        <div class="company-details">
            @if(auth()->user()->company->address ?? false) <div><i class="bi bi-geo-alt"></i> {{ auth()->user()->company->address }}</div> @endif
            @if(auth()->user()->company->cell_no ?? false) <div><i class="bi bi-telephone"></i> {{ auth()->user()->company->cell_no }}</div> @endif
            @if(auth()->user()->company->email ?? false) <div><i class="bi bi-envelope"></i> {{ auth()->user()->company->email }}</div> @endif
            @if(auth()->user()->company->website ?? false) <div><i class="bi bi-globe"></i> {{ auth()->user()->company->website }}</div> @endif
        </div>
    </div>
    <div class="summary-row" style="margin: 24px 32px 0 32px; justify-content: space-between; white-space: nowrap; gap: 16px;">
        <span style="white-space: nowrap;"><span style="margin-right:2px; font-weight:bold; color:#b71c1c;">Invoice Date:</span><span class="value">{{ \Carbon\Carbon::parse($sale->created_at)->format('d-M-Y') }}</span></span>
        <span style="white-space: nowrap;"><span style="margin-right:2px; font-weight:bold; color:#b71c1c;">Issue Date:</span><span class="value">{{ \Carbon\Carbon::parse($sale->created_at)->format('d-M-Y') }}</span></span>
        <span style="white-space: nowrap;"><span style="margin-right:2px; font-weight:bold; color:#b71c1c;">Invoice No:</span><span class="value">{{ $sale->saleE_id }}</span></span>
    </div>
    <div style="text-align:center; margin-top:24px; margin-bottom:8px;">
        <span style="font-size:2rem; font-weight:bold; color:#b71c1c; letter-spacing:1px;">Manual Sale Invoice</span>
    </div>
    <div class="to-block">
        <b>Customer</b><br>
        <span class="label">Name:</span> <span class="value">{{ $sale->customer->name ?? 'N/A' }}</span><br>
        <span class="label">Created By:</span> <span class="value">{{ $sale->created_by }}</span><br>
    </div>
    <div class="table-container">
        <table>
        <thead>
            <tr>
                    <th>Name</th>
                    <th>Quantity</th>
                    <th>Purchase Amount</th>
                    <th>Selling Amount</th>
                    <th>Buy From</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $sale->purchase->item_name ?? 'N/A' }}</td>
                <td>1</td>
                    <td>{{ number_format($sale->purchase->purchase_amount ?? 0, 2) }}</td>
                <td>{{ number_format($sale->sale_amount, 2) }}</td>
                    <td>{{ $sale->purchase->purchase_source ?? '-' }}</td>
                </tr>
                <tr class="total-row">
                    <td style="text-align:right; font-weight:bold;" colspan="1">Total</td>
                    <td style="font-weight:bold;">1</td>
                    <td style="font-weight:bold;">{{ number_format($sale->purchase->purchase_amount ?? 0, 2) }}</td>
                    <td style="font-weight:bold;">{{ number_format($sale->sale_amount, 2) }}</td>
                    <td></td>
            </tr>
        </tbody>
    </table>
    </div>
    <!-- Watermark -->
    @if(auth()->user()->company->logo ?? false)
    <div style="position:fixed; top:50%; left:50%; transform:translate(-50%,-50%); z-index:0; opacity:0.07; pointer-events:none; width:60vw; max-width:600px;">
        <img src="{{ asset('storage/' . auth()->user()->company->logo) }}" alt="Watermark Logo" style="width:100%; height:auto;">
    </div>
    @endif
    <!-- End Watermark -->
    <div style="clear:both;"></div>
    <div class="terms">
        <b>Terms & Conditions:</b> This is a computer-generated invoice and does not require a signature.
    </div>
    <div class="thankyou">Thank you for your business!</div>
    <div class="no-print" style="text-align:center; margin-bottom:32px;">
        <button onclick="window.print()" style="padding:10px 32px; font-size:1.1rem; background:#b71c1c; color:#fff; border:none; border-radius:6px; cursor:pointer;">Print</button>
        <a href="{{ route('external-sales.index') }}" class="btn btn-secondary btn-sm">Back</a>
    </div>
</body>
</html>
