<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sales Invoice - {{ $company->name ?? (auth()->user()->company->name ?? 'POS System') }}</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
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
        .stamp {
            display: block;
            margin: 32px auto 0 auto;
            width: 120px; height: 120px;
            border: 4px solid #b71c1c;
            border-radius: 50%;
            color: #b71c1c;
            font-weight: bold;
            font-size: 1.1rem;
            text-align: center;
            line-height: 120px;
            letter-spacing: 2px;
            opacity: 0.8;
            background: #fff;
            box-shadow: 0 0 8px #b71c1c33;
        }
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
            @if(($company->logo ?? false) || (auth()->user()->company->logo ?? false))
                <img src="{{ asset('storage/' . ($company->logo ?? auth()->user()->company->logo)) }}" class="logo" alt="Company Logo">
            @endif
            <span class="company-name">{{ $company->name ?? (auth()->user()->company->name ?? 'POS System') }}</span>
        </div>
        <div class="company-details">
            @if(($company->address ?? false) || (auth()->user()->company->address ?? false)) <div><i class="bi bi-geo-alt"></i> {{ $company->address ?? auth()->user()->company->address }}</div> @endif
            @if(($company->cell_no ?? false) || (auth()->user()->company->cell_no ?? false)) <div><i class="bi bi-telephone"></i> {{ $company->cell_no ?? auth()->user()->company->cell_no }}</div> @endif
            @if(($company->email ?? false) || (auth()->user()->company->email ?? false)) <div><i class="bi bi-envelope"></i> {{ $company->email ?? auth()->user()->company->email }}</div> @endif
            @if(($company->website ?? false) || (auth()->user()->company->website ?? false)) <div><i class="bi bi-globe"></i> {{ $company->website ?? auth()->user()->company->website }}</div> @endif
        </div>
    </div>
    <div class="summary-row" style="margin: 24px 32px 0 32px; justify-content: space-between; white-space: nowrap; gap: 16px;">
        <span style="white-space: nowrap;"><span style="margin-right:2px; font-weight:bold; color:#b71c1c;">Invoice Date:</span><span class="value">{{ \Carbon\Carbon::parse($sale->sale_date ?? $sale->created_at)->format('d-M-Y') }}</span></span>
        <span style="white-space: nowrap;"><span style="margin-right:2px; font-weight:bold; color:#b71c1c;">Issue Date:</span><span class="value">{{ \Carbon\Carbon::parse($sale->created_at)->format('d-M-Y') }}</span></span>
        <span style="white-space: nowrap;"><span style="margin-right:2px; font-weight:bold; color:#b71c1c;">Invoice No:</span><span class="value">{{ $sale->sale_code }}</span></span>
    </div>
    <div style="text-align:center; margin-top:24px; margin-bottom:8px;">
        <span style="font-size:2rem; font-weight:bold; color:#b71c1c; letter-spacing:1px;">Sales Invoice</span>
            </div>
    <div class="to-block" style="display: flex; justify-content: space-between; gap: 40px; margin-bottom: 16px;">
        @if($sale->sale_type === 'wholesale')
        <div style="flex:1;">
            <b style="font-size:1.1em;">To (Wholesale Customer)</b><br>
            <span class="label">Name:</span> <span class="value">{{ $customer->name ?? '-' }}</span><br>
            <span class="label">Phone:</span> <span class="value">{{ $customer->cel_no ?? '-' }}</span><br>
            <span class="label">Address:</span> <span class="value">{{ $customer->address ?? '-' }}</span><br>
        </div>
        @elseif($sale->sale_type === 'distributor')
        <div style="flex:1;">
            <b style="font-size:1.1em;">To (Shopkeeper)</b><br>
            <span class="label">Name:</span> <span class="value">{{ $sale->shopkeeper->name ?? '-' }}</span><br>
            <span class="label">Phone:</span> <span class="value">{{ $sale->shopkeeper->cel_no ?? '-' }}</span><br>
            <span class="label">Address:</span> <span class="value">{{ $sale->shopkeeper->address ?? '-' }}</span><br>
        </div>
        <div style="flex:1;">
            <b style="font-size:1.1em;">From (Distributor)</b><br>
            <span class="label">Name:</span> <span class="value">{{ $sale->distributor->name ?? '-' }}</span><br>
            <span class="label">Phone:</span> <span class="value">{{ $sale->distributor->cel_no ?? '-' }}</span><br>
            <span class="label">Company:</span> <span class="value">{{ $company->name ?? (auth()->user()->company->name ?? '-') }}</span><br>
        </div>
        @endif
    </div>
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Sr#</th>
                    <th>Item Descriptions</th>
                    <th>Rate</th>
                    <th>Qty</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody>
                @php $grandTotal = 0; $totalQty = 0; $sr = 1; @endphp
                @foreach($sale->inventorySales as $detail)
                    @php $total = $detail->amount * $detail->quantity; $grandTotal += $total; $totalQty += $detail->quantity; @endphp
                <tr>
                    <td>{{ $sr++ }}</td>
                        <td style="text-align:left;">
                            <b>{{ $detail->item->item_name ?? '-' }}</b>
                            @php $details = trim($detail->item->details ?? ''); @endphp
                            @if($details && strtolower($details) !== 'n/a')
                                <div style="font-weight:normal; font-size:1.05em; margin-top:2px;">
                                    {{ $details }}
                                </div>
                            @endif
                        </td>
                        <td>{{ number_format($detail->amount, 2) }}</td>
                        <td>{{ $detail->quantity }}</td>
                        <td>{{ number_format($total, 2) }}</td>
                </tr>
                @endforeach
                @if(isset($externalProducts) && $externalProducts->count())
                    @foreach ($externalProducts as $manual)
                        @php $total = $manual['rate'] * $manual['quantity']; $grandTotal += $total; $totalQty += $manual['quantity']; @endphp
                        <tr>
                            <td>{{ $sr++ }}</td>
                            <td style="text-align:left;"><b>{{ $manual['name'] }}</b></td>
                            <td>{{ number_format($manual['rate'], 2) }}</td>
                            <td>{{ $manual['quantity'] }}</td>
                            <td>{{ number_format($total, 2) }}</td>
                        </tr>
                    @endforeach
                @endif
                <tr class="total-row">
                    <td colspan="3" style="text-align:right;">Total</td>
                    <td>{{ $totalQty }}</td>
                    <td>{{ number_format($grandTotal, 2) }}</td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="totals-block" style="float: right; margin: 18px 32px 0 0;">
        <table>
                <tr>
                <td class="label">Sub Total</td>
                <td class="value">{{ number_format($grandTotal, 2) }}</td>
                </tr>
                <tr>
                <td class="label">Tax ({{ $sale->tax_percentage ?? 0 }}%)</td>
                <td class="value">{{ number_format($sale->tax_amount ?? 0, 2) }}</td>
                </tr>
                <tr>
                <td class="label">Discount</td>
                <td class="value">{{ number_format($sale->discount ?? 0, 2) }}</td>
                </tr>
                <tr>
                <td class="label">Previous Balance</td>
                <td class="value">{{ (isset($previousOutstanding) && $previousOutstanding > 0) ? number_format($previousOutstanding, 2) : '0.00' }}</td>
                </tr>
                <tr>
                <td class="label">Received Amount</td>
                <td class="value">{{ isset($amountReceived) ? number_format($amountReceived, 2) : '0.00' }}</td>
                </tr>
            <tr class="grand">
                <td class="grand">Grand Total</td>
                <td class="grand">{{ number_format(($grandTotal + ($sale->tax_amount ?? 0) - ($sale->discount ?? 0) + ($previousOutstanding ?? 0)), 2) }}</td>
                </tr>
            </table>
    </div>
    <div style="clear:both;"></div>
            <div class="terms">
        <b>Terms & Conditions:</b> This is a computer-generated invoice and does not require a signature.
    </div>
    <div class="thankyou">Thank you for your business!</div>
    @if(($company->logo ?? false) || (auth()->user()->company->logo ?? false))
    <div style="position:fixed; top:50%; left:50%; transform:translate(-50%,-50%); z-index:0; opacity:0.07; pointer-events:none; width:60vw; max-width:600px;">
        <img src="{{ asset('storage/' . ($company->logo ?? auth()->user()->company->logo)) }}" alt="Watermark Logo" style="width:100%; height:auto;">
    </div>
    @endif
    <div class="no-print" style="text-align:center; margin-bottom:32px;">
        <button onclick="window.print()" style="padding:10px 32px; font-size:1.1rem; background:#b71c1c; color:#fff; border:none; border-radius:6px; cursor:pointer;">Print</button>
    </div>
</body>
</html> 