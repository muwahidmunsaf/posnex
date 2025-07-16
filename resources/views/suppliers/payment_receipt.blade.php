<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Supplier Payment Receipt</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 0; background: #fff; }
        .header { display: flex; justify-content: space-between; align-items: flex-start; border-bottom: 2.5px solid #b71c1c; padding: 24px 32px 12px 32px; }
        .header-left { display: flex; align-items: center; }
        .logo { height: 60px; margin-right: 18px; }
        .company-name { font-size: 2rem; font-weight: bold; color: #b71c1c; }
        .company-details { text-align: right; font-size: 1rem; color: #333; line-height: 1.7; }
        .company-details i { color: #b71c1c; margin-right: 4px; }
        .receipt-title { text-align: center; font-size: 1.5rem; color: #b71c1c; font-weight: bold; margin: 32px 0 16px 0; }
        .info-block { margin: 24px 32px; font-size: 1.1rem; }
        .info-block .label { font-weight: bold; color: #b71c1c; }
        .info-block .value { color: #222; }
        .thankyou { text-align: center; font-size: 1.1rem; color: #b71c1c; margin-top: 32px; font-weight: bold; letter-spacing: 1px; }
        @media print {
            .no-print { display: none !important; }
            body { background: #fff !important; }
            .header { border-bottom: 2.5px solid #b71c1c !important; }
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="header-left">
            @if($supplier->company && $supplier->company->logo)
                <img src="{{ asset('storage/' . $supplier->company->logo) }}" class="logo" alt="Company Logo">
            @endif
            <span class="company-name" style="display:block; margin-left:10px;">{{ $supplier->company->name ?? '' }}</span>
        </div>
        <div class="company-details">
            @if($supplier->company && $supplier->company->address) <div><i class="bi bi-geo-alt"></i> {{ $supplier->company->address }}</div> @endif
            @if($supplier->company && $supplier->company->cell_no) <div><i class="bi bi-telephone"></i> {{ $supplier->company->cell_no }}</div> @endif
            @if($supplier->company && $supplier->company->email) <div><i class="bi bi-envelope"></i> {{ $supplier->company->email }}</div> @endif
            @if($supplier->company && $supplier->company->website) <div><i class="bi bi-globe"></i> {{ $supplier->company->website }}</div> @endif
        </div>
    </div>
    <hr style="border:1.5px solid #b71c1c; margin: 0 32px 0 32px;">
    <div style="display:flex; justify-content:space-between; align-items:center; margin: 16px 32px 0 32px; font-size:1.1rem; font-weight:bold; color:#b71c1c;">
        <div style="flex:1; text-align:left;">
            Invoice Date: <span style="color:#222; font-weight:normal;">{{ \Carbon\Carbon::parse($payment->payment_date)->format('d-M-Y') }}</span>
        </div>
        <div style="flex:1; text-align:center;">
            Issue Date: <span style="color:#222; font-weight:normal;">{{ \Carbon\Carbon::parse($payment->created_at)->format('d-M-Y') }}</span>
        </div>
        <div style="flex:1; text-align:right;">
            Invoice No: <span style="color:#222; font-weight:normal;">PAY-{{ str_pad($payment->id, 6, '0', STR_PAD_LEFT) }}</span>
        </div>
    </div>
    <div class="receipt-title">Supplier Payment Invoice</div>
    <div class="info-block">
        <table style="width: 100%; border-collapse: collapse; margin-bottom: 24px;">
            <tr style="border: 1.5px solid #b71c1c;">
                <td class="label" style="font-weight:bold; color:#b71c1c; border: 1.5px solid #b71c1c; padding:8px;">Supplier Name:</td>
                <td class="value" style="border: 1.5px solid #b71c1c; padding:8px;">{{ $supplier->supplier_name }}</td>
            </tr>
            <tr style="border: 1.5px solid #b71c1c;">
                <td class="label" style="font-weight:bold; color:#b71c1c; border: 1.5px solid #b71c1c; padding:8px;">Payment Date:</td>
                <td class="value" style="border: 1.5px solid #b71c1c; padding:8px;">{{ \Carbon\Carbon::parse($payment->payment_date)->format('d-M-Y') }}</td>
            </tr>
            <tr style="border: 1.5px solid #b71c1c;">
                <td class="label" style="font-weight:bold; color:#b71c1c; border: 1.5px solid #b71c1c; padding:8px;">Amount:</td>
                <td class="value" style="border: 1.5px solid #b71c1c; padding:8px;">
                    @if($supplier->country == 'Pakistan' || $supplier->currency['code'] == 'PKR')
                        Rs {{ number_format($payment->amount, 2) }} (PKR)
                    @else
                        {{ $supplier->currency['symbol'] }} {{ number_format($payment->amount, 2) }} ({{ $payment->currency_code ?? $supplier->currency['code'] }})
                    @endif
                </td>
            </tr>
            <tr style="border: 1.5px solid #b71c1c;">
                <td class="label" style="font-weight:bold; color:#b71c1c; border: 1.5px solid #b71c1c; padding:8px;">Payment Method:</td>
                <td class="value" style="border: 1.5px solid #b71c1c; padding:8px;">{{ $payment->payment_method }}</td>
            </tr>
            <tr style="border: 1.5px solid #b71c1c;">
                <td class="label" style="font-weight:bold; color:#b71c1c; border: 1.5px solid #b71c1c; padding:8px;">Note:</td>
                <td class="value" style="border: 1.5px solid #b71c1c; padding:8px;">{{ $payment->note }}</td>
            </tr>
            @if($supplier->country != 'Pakistan' && $payment->currency_code && strtoupper($payment->currency_code) != 'PKR')
            <tr style="border: 1.5px solid #b71c1c;">
                <td class="label" style="font-weight:bold; color:#b71c1c; border: 1.5px solid #b71c1c; padding:8px;">Conversion Rate:</td>
                <td class="value" style="border: 1.5px solid #b71c1c; padding:8px;">
                    1 {{ $payment->currency_code }} = {{ number_format($payment->exchange_rate_to_pkr, 4) }} PKR
                </td>
            </tr>
            @endif
            <tr style="border: 1.5px solid #b71c1c;">
                <td class="label" style="font-weight:bold; color:#b71c1c; border: 1.5px solid #b71c1c; padding:8px;">Remaining Balance:</td>
                <td class="value" style="border: 1.5px solid #b71c1c; padding:8px;">
                    @php
                        $totalPurchase = $supplier->purchases->sum('total_amount');
                        $totalPaid = $supplier->supplierPayments->where('id', '<=', $payment->id)->sum('amount');
                        $balance = $totalPurchase - $totalPaid;
                    @endphp
                    @if($supplier->country == 'Pakistan' || $supplier->currency['code'] == 'PKR')
                        Rs {{ number_format($balance, 2) }} (PKR)
                    @else
                        {{ $supplier->currency['symbol'] }} {{ number_format($balance, 2) }} ({{ $supplier->currency['code'] }})
                    @endif
                </td>
            </tr>
        </table>
        @if(true)
        <div style="position:relative; width:100%;">
            <div style="position:absolute; right:48px; top:32px; transform:rotate(-10deg); z-index:10;">
                <span style="display:inline-block; padding:10px 38px; font-size:1.7rem; color:#43a047; background:transparent; border-radius:12px; font-weight:800; letter-spacing:7px; opacity:0.95; border:3px solid #43a047;">PAID</span>
            </div>
        </div>
        @endif
        <div class="terms" style="color:#b71c1c; font-size:0.98em; margin-top:24px;">
            <b>Terms & Conditions:</b> This is a computer-generated invoice and does not require a signature.
        </div>
    </div>
    <div class="thankyou">Thank you for your business!</div>
    <div class="no-print" style="text-align:center; margin-bottom:32px;">
        <button onclick="window.print()" style="padding:10px 32px; font-size:1.1rem; background:#b71c1c; color:#fff; border:none; border-radius:6px; cursor:pointer;">Print</button>
    </div>
    @if($supplier->company && $supplier->company->logo)
    <div style="position:fixed; top:50%; left:50%; transform:translate(-50%,-50%); z-index:0; opacity:0.07; pointer-events:none; width:60vw; max-width:600px;">
        <img src="{{ asset('storage/' . $supplier->company->logo) }}" alt="Watermark Logo" style="width:100%; height:auto;">
    </div>
    @endif
</body>
</html> 