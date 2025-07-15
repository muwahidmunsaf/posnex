@php
    $company = \App\Models\Company::first();
    $totalQty = $assignments->sum('quantity_assigned');
    $totalPrice = $assignments->sum('total_value');
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice - {{ $assignmentNumber }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            background: #f7f7f7;
            font-family: 'Poppins', Arial, sans-serif;
        }
        .print-btns {
            text-align: center;
            margin-bottom: 18px;
        }
        .a4-paper {
            width: 210mm;
            min-height: 297mm;
            margin: 40px auto;
            background: #fff;
            box-sizing: border-box;
            display: flex;
            flex-direction: column;
            height: 297mm;
            box-shadow: 0 0 16px #bbb;
            border-radius: 16px;
            font-family: 'Poppins', Arial, sans-serif;
        }
        .header-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: #fff;
            padding: 24px 18px 8px 18px;
            border-bottom: 2px solid #b71c1c;
            border-radius: 16px 16px 0 0;
        }
        .header-left {
            display: flex;
            align-items: center;
        }
        .header-logo {
            height: 48px;
            margin-right: 14px;
        }
        .company-name {
            font-size: 2.2rem;
            font-weight: bold;
            color: #b71c1c;
            letter-spacing: 2px;
        }
        .invoice-title {
            font-size: 2.2rem;
            font-weight: bold;
            color: #b71c1c;
            letter-spacing: 2px;
        }
        .invoice-details-bar {
            background: #f8d7da;
            color: #b71c1c;
            padding: 10px 18px;
            display: flex;
            justify-content: space-between;
            font-size: 1.1rem;
            border-radius: 0;
            margin-bottom: 24px;
        }
        .amount-due-box {
            background: #b71c1c;
            color: #fff;
            font-size: 1.5rem;
            padding: 12px 36px;
            border-radius: 8px;
            float: right;
            margin: 18px 0 18px 0;
            font-weight: bold;
            box-shadow: none;
        }
        .modern-table {
            width: 100%;
            border-collapse: collapse;
        }
        .modern-table th, .modern-table td {
            border: 1px solid #b71c1c;
            padding: 8px 10px;
            font-size: 1rem;
        }
        .modern-table th {
            background: #b71c1c !important;
            color: #fff !important;
            font-weight: bold;
        }
        .modern-table tfoot td {
            font-weight: bold;
            background: #f8d7da;
            color: #b71c1c;
        }
        .invoice-body {
            flex: 1 1 auto;
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
            padding: 0 18px;
        }
        .footer-section {
            margin: 0 18px 0 18px;
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            margin-top: 32px;
            margin-bottom: 80px;
        }
        .footer-section .terms {
            font-size: 1rem;
            margin-bottom: 0.5rem;
        }
        .footer-section .signature {
            text-align: right;
        }
        .footer-section .signature .name {
            font-weight: bold;
            font-size: 16px;
            color: #b71c1c;
        }
        .footer-section .signature .role {
            color: #b71c1c;
            font-size: 14px;
        }
        .footer-bar {
            background: #b71c1c;
            color: #fff;
            padding: 18px 32px;
            border-radius: 0 0 16px 16px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-size: 1rem;
            flex-shrink: 0;
        }
        .footer-bar .footer-icons span {
            margin-right: 18px;
            display: inline-flex;
            align-items: center;
        }
        .footer-bar .footer-icons i {
            margin-right: 6px;
        }
        .thankyou {
            font-size: 1.2rem;
            font-weight: bold;
            color: #fff;
            margin-left: 24px;
        }
        .no-print {
            margin-top: 20px; text-align: center;
        }
        .stamp {
            display: inline-block;
            border: 2px solid #b71c1c;
            border-radius: 50px;
            background: #fff6f6;
            padding: 18px 32px 10px 32px;
            text-align: center;
            font-family: 'Poppins', Arial, sans-serif;
            margin-top: 10px;
        }
        .stamp-company {
            font-weight: bold;
            font-size: 1.1rem;
            color: #b71c1c;
            margin-bottom: 4px;
        }
        .stamp-role {
            color: #b71c1c;
            font-size: 0.95rem;
            font-weight: 500;
        }
        @media print {
            body, html {
                background: #fff !important;
            }
            .print-btns, .no-print {
                display: none !important;
            }
            .a4-paper {
                width: 210mm !important;
                min-height: 297mm !important;
                height: 297mm !important;
                margin: 0 !important;
                box-shadow: none !important;
                border-radius: 0 !important;
                display: flex !important;
                flex-direction: column !important;
            }
            .footer-bar, .modern-table th, .amount-due-box, .thankyou {
                background: #b71c1c !important;
                color: #fff !important;
                box-shadow: none !important;
            }
            .company-name, .invoice-title {
                color: #b71c1c !important;
            }
            .footer-bar {
                border-top: none !important;
                position: absolute;
                left: 0; right: 0; bottom: 0;
                width: 100%;
            }
        }
    </style>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</head>
<body>
<div class="print-btns no-print">
    <button onclick="window.print()">Print Invoice</button>
    <button onclick="window.close()">Close</button>
</div>
<div class="a4-paper">
    <div class="header-row">
        <div class="header-left">
            <img src="{{ $company?->logo ? asset('storage/'.$company->logo) : asset('logo.png') }}" class="header-logo" alt="Company Logo">
            <span class="company-name">{{ $company?->name ?? 'Company Name' }}</span>
        </div>
        <div class="invoice-title">INVOICE</div>
    </div>
    <div class="invoice-details-bar">
        <div><strong>Invoice Date:</strong> {{ $assignments->first()->assignment_date->format('d-M-Y') }}</div>
        <div><strong>Issue Date:</strong> {{ now()->format('d-M-Y') }}</div>
        <div><strong>Invoice No:</strong> {{ $assignmentNumber }}</div>
    </div>
    <div class="invoice-body">
        <div style="display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:18px;">
            <div>
                <strong>TO</strong><br>
                <strong>Name:</strong> {{ $distributor->name }}<br>
                <strong>Phone:</strong> {{ $distributor->phone ?? '-' }}<br>
                <strong>Address:</strong> {{ $distributor->address ?? '-' }}
            </div>
            <div>
                <span class="amount-due-box">Amount Due: Rs {{ number_format($grandTotal, 2) }}</span>
            </div>
        </div>
        <table class="modern-table">
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
                @foreach($assignments as $i => $assignment)
                <tr>
                    <td>{{ $i+1 }}</td>
                    <td>{{ $assignment->inventory->item_name ?? 'N/A' }}</td>
                    <td>Rs {{ number_format($assignment->unit_price, 2) }}</td>
                    <td>{{ $assignment->quantity_assigned }}</td>
                    <td>Rs {{ number_format($assignment->total_value, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3" style="text-align:right;">Total</td>
                    <td>{{ $totalQty }}</td>
                    <td>Rs {{ number_format($totalPrice, 2) }}</td>
                </tr>
            </tfoot>
        </table>
        <div style="display:flex;justify-content:flex-end;">
            <table class="table" style="width:auto;">
                <tr>
                    <td class="text-end">Sub Total</td>
                    <td class="text-end">Rs {{ number_format($totalValue, 2) }}</td>
                </tr>
                <tr>
                    <td class="text-end">VAT ({{ $vatPercent }}%)</td>
                    <td class="text-end">Rs {{ number_format($vatAmount, 2) }}</td>
                </tr>
                <tr>
                    <td class="text-end"><strong>Grand Total</strong></td>
                    <td class="text-end"><strong>Rs {{ number_format($grandTotal, 2) }}</strong></td>
                </tr>
            </table>
        </div>
    </div>
    <div class="footer-section">
        <div>
            <div class="terms">
                <strong>Payment Method:</strong> Cash Payment<br>
                <strong>Terms & Conditions:</strong> Payment due upon receipt. Goods once sold will not be taken back.<br>
            </div>
        </div>
        <div class="signature">
            <div class="stamp">
                <div class="stamp-company">{{ $company?->name ?? 'Company Name' }}</div>
                <div class="stamp-role">Authorized Signature</div>
            </div>
        </div>
    </div>
    <div class="footer-bar">
        <div class="footer-icons">
            <span><i class="bi bi-geo-alt"></i> {{ $company?->address ?? '' }}</span>
            <span><i class="bi bi-telephone"></i> {{ $company?->cell_no ?? '' }}</span>
            <span><i class="bi bi-envelope"></i> {{ $company?->email ?? '' }}</span>
            <span><i class="bi bi-globe"></i> {{ $company?->website ?? '' }}</span>
        </div>
        <span class="thankyou">Thank You For Your Business!</span>
    </div>
</div>
<script>
window.onload = function() {
    setTimeout(function() { window.print(); }, 300);
}
</script>
</body>
</html> 