<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Customer Payment Receipt</title>
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
            @if(auth()->user() && auth()->user()->company && auth()->user()->company->logo)
                <img src="{{ asset('storage/' . auth()->user()->company->logo) }}" class="logo" alt="Company Logo">
            @endif
            <span class="company-name" style="display:block; margin-left:10px;">{{ auth()->user()->company->name ?? config('app.name', 'Company') }}</span>
        </div>
        <div class="company-details">
            @if(auth()->user() && auth()->user()->company && auth()->user()->company->address) <div><i class="bi bi-geo-alt"></i> {{ auth()->user()->company->address }}</div> @endif
            @if(auth()->user() && auth()->user()->company && auth()->user()->company->cell_no) <div><i class="bi bi-telephone"></i> {{ auth()->user()->company->cell_no }}</div> @endif
            @if(auth()->user() && auth()->user()->company && auth()->user()->company->email) <div><i class="bi bi-envelope"></i> {{ auth()->user()->company->email }}</div> @endif
            @if(auth()->user() && auth()->user()->company && auth()->user()->company->website) <div><i class="bi bi-globe"></i> {{ auth()->user()->company->website }}</div> @endif
        </div>
    </div>
    <hr style="border:1.5px solid #b71c1c; margin: 0 32px 0 32px;">
    <div style="display:flex; justify-content:space-between; align-items:center; margin: 16px 32px 0 32px; font-size:1.1rem; font-weight:bold; color:#b71c1c;">
        <div style="flex:1; text-align:left;">
            Invoice Date: <span style="color:#222; font-weight:normal;">{{ \Carbon\Carbon::parse($payment->payment_date ?? $payment->date ?? $payment->created_at)->format('d-M-Y') }}</span>
        </div>
        <div style="flex:1; text-align:center;">
            Issue Date: <span style="color:#222; font-weight:normal;">{{ \Carbon\Carbon::parse($payment->created_at)->format('d-M-Y') }}</span>
        </div>
        <div style="flex:1; text-align:right;">
            Invoice No: <span style="color:#222; font-weight:normal;">PAY-{{ str_pad($payment->id, 6, '0', STR_PAD_LEFT) }}</span>
        </div>
    </div>
    <div class="receipt-title">Customer Payment Invoice</div>
    <div class="info-block">
        <table style="width: 100%; border-collapse: collapse; margin-bottom: 24px;">
            <tr style="border: 1.5px solid #b71c1c;">
                <td class="label" style="font-weight:bold; color:#b71c1c; border: 1.5px solid #b71c1c; padding:8px;">Customer Name:</td>
                <td class="value" style="border: 1.5px solid #b71c1c; padding:8px;">{{ $customer->name }}</td>
            </tr>
            <tr style="border: 1.5px solid #b71c1c;">
                <td class="label" style="font-weight:bold; color:#b71c1c; border: 1.5px solid #b71c1c; padding:8px;">Payment Date:</td>
                <td class="value" style="border: 1.5px solid #b71c1c; padding:8px;">{{ \Carbon\Carbon::parse($payment->payment_date ?? $payment->date ?? $payment->created_at)->format('d-M-Y') }}</td>
            </tr>
            <tr style="border: 1.5px solid #b71c1c;">
                <td class="label" style="font-weight:bold; color:#b71c1c; border: 1.5px solid #b71c1c; padding:8px;">Received Amount:</td>
                <td class="value" style="border: 1.5px solid #b71c1c; padding:8px;">{{ number_format($payment->amount_paid, 2) }}</td>
            </tr>
            <tr style="border: 1.5px solid #b71c1c;">
                <td class="label" style="font-weight:bold; color:#b71c1c; border: 1.5px solid #b71c1c; padding:8px;">Note:</td>
                <td class="value" style="border: 1.5px solid #b71c1c; padding:8px;">{{ $payment->note }}</td>
            </tr>
            <tr style="border: 1.5px solid #b71c1c;">
                <td class="label" style="font-weight:bold; color:#b71c1c; border: 1.5px solid #b71c1c; padding:8px;">Remaining Balance:</td>
                <td class="value" style="border: 1.5px solid #b71c1c; padding:8px;">
                    @php
                        $totalSales = $customer->sales->sum('total_amount');
                        $totalReturns = 0;
                        foreach ($customer->sales as $sale) {
                            $totalReturns += $sale->returns->sum(function($ret) { return $ret->amount * $ret->quantity; });
                        }
                        $totalPaid = $customer->payments->where('id', '<=', $payment->id)->sum('amount_paid');
                        $balance = ($totalSales - $totalReturns) - $totalPaid;
                    @endphp
                    {{ number_format($balance, 2) }}
                </td>
            </tr>
        </table>
        <div class="terms" style="color:#b71c1c; font-size:0.98em; margin-top:24px;">
            <b>Terms & Conditions:</b> This is a computer-generated invoice and does not require a signature.
        </div>
    </div>
    <div class="thankyou">Thank you for your business!</div>
    <div class="stamp" style="
        margin: 32px auto 0 auto;
        width: 150px;
        height: 150px;
        border: 6px dashed #1565c0;
        border-radius: 50%;
        color: #1565c0;
        font-size: 2.2rem;
        font-family: 'Courier New', Courier, monospace;
        font-weight: bold;
        opacity: 0.42;
        transform: rotate(-12deg);
        pointer-events: none;
        user-select: none;
        box-shadow: 0 4px 18px 0 #1565c055;
        letter-spacing: 2px;
        text-shadow: 1px 1px 2px #1565c055;
        text-transform: uppercase;
        background: transparent;
        z-index: 10;
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
    ">
        RECEIVED
    </div>
    <!-- Watermark -->
    @if(auth()->user() && auth()->user()->company && auth()->user()->company->logo)
    <div style="position:fixed; top:50%; left:50%; transform:translate(-50%,-50%); z-index:0; opacity:0.07; pointer-events:none; width:60vw; max-width:600px;">
        <img src="{{ asset('storage/' . auth()->user()->company->logo) }}" alt="Watermark Logo" style="width:100%; height:auto;">
    </div>
    @endif
    <!-- End Watermark -->
    <div class="no-print" style="text-align:center; margin-bottom:32px;">
        <button onclick="window.print()" style="padding:10px 32px; font-size:1.1rem; background:#b71c1c; color:#fff; border:none; border-radius:6px; cursor:pointer;">Print</button>
    </div>
</body>
</html> 