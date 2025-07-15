@php
    $company = \App\Models\Company::first();
@endphp
@extends('layouts.app')
@section('content')
<div style="text-align:center; margin-bottom:18px;">
    <a href="{{ route('distributor-products.print-receipt', ['assignment_number' => $assignmentNumber, 'vat_percent' => $vatPercent]) }}" target="_blank" class="btn btn-danger" style="font-weight:600; font-size:1.1rem;">
        <i class="bi bi-printer"></i> Print Invoice
    </a>
</div>
<style>
    body {
        background: #f7f7f7;
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
    .modern-table th {
        background: #b71c1c !important;
        color: #fff !important;
        font-weight: bold;
        border: none;
    }
    .modern-table td {
        border-top: 1px solid #f8d7da;
        font-size: 1rem;
    }
    .invoice-body {
        flex: 1 1 auto;
        display: flex;
        flex-direction: column;
        justify-content: flex-start;
        padding: 0 18px;
    }
    .invoice-meta-bottom {
        margin-top: 32px;
        margin-bottom: 0;
        display: flex;
        flex-direction: row;
        justify-content: space-between;
        align-items: flex-end;
    }
    .invoice-meta-bottom .terms {
        font-size: 1rem;
        margin-bottom: 0.5rem;
    }
    .invoice-meta-bottom .signature {
        text-align: right;
    }
    .invoice-meta-bottom .signature .name {
        font-weight: bold;
        font-size: 16px;
        color: #b71c1c;
    }
    .invoice-meta-bottom .signature .role {
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
    @media print {
        body, html {
            background: #fff !important;
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
        .no-print {
            display: none !important;
        }
    }
</style>
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
        <table class="table modern-table" style="margin-top:30px;width:100%;">
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
        <div class="invoice-meta-bottom">
            <div>
                <div class="terms">
                    <strong>Payment Method:</strong> Cash Payment<br>
                    <strong>Terms & Conditions:</strong> Payment due upon receipt. Goods once sold will not be taken back.<br>
                </div>
            </div>
            <div class="signature">
                <div class="name">{{ $company?->name ?? 'Company Name' }}</div>
                <div class="role">Authorized Signature</div>
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
@endsection 