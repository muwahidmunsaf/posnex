@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">Finance Report</h4>
        <button onclick="printTable()" type="button" class="btn btn-success d-print-none">
            <i class="bi bi-printer me-1"></i> Print Report
        </button>
    </div>

    <form method="GET" class="row g-3 align-items-end mb-4 d-print-none">
        <div class="col-md-4">
            <label for="from">From</label>
            <input type="date" name="from" id="from" class="form-control"
                value="{{ request('from', $from->format('Y-m-d')) }}">
        </div>
        <div class="col-md-4">
            <label for="to">To</label>
            <input type="date" name="to" id="to" class="form-control"
                value="{{ request('to', $to->format('Y-m-d')) }}">
        </div>
        <div class="col-md-auto">
            <button type="submit" class="btn btn-primary">Filter</button>
            <a href="{{ route('reports.finance') }}" class="btn btn-secondary">Reset</a>
        </div>
    </form>

    <div id="financeTableWrapper" class="table-responsive">
        <!-- Print Header -->
        <div class="d-none d-print-block" style="margin-bottom: 24px;">
            <div style="display: flex; justify-content: space-between; align-items: flex-start; border-bottom: 2.5px solid #b71c1c; padding: 24px 32px 12px 32px;">
                <div style="display: flex; align-items: center;">
                    @if(Auth::user() && Auth::user()->company && Auth::user()->company->logo)
                        <img src="{{ asset('storage/' . Auth::user()->company->logo) }}" alt="Logo" style="height: 60px; margin-right: 18px;">
                    @endif
                    <span style="font-size: 2rem; font-weight: bold; color: #b71c1c;">{{ Auth::user()->company->name ?? config('app.name') }}</span>
                </div>
                <div style="text-align: right; font-size: 1rem; color: #333; line-height: 1.7;">
                    @if(Auth::user() && Auth::user()->company && Auth::user()->company->address)
                        <div><i class="bi bi-geo-alt" style="color:#b71c1c; margin-right:4px;"></i> {{ Auth::user()->company->address }}</div>
                    @endif
                    @if(Auth::user() && Auth::user()->company && Auth::user()->company->cell_no)
                        <div><i class="bi bi-telephone" style="color:#b71c1c; margin-right:4px;"></i> {{ Auth::user()->company->cell_no }}</div>
                    @endif
                    @if(Auth::user() && Auth::user()->company && Auth::user()->company->email)
                        <div><i class="bi bi-envelope" style="color:#b71c1c; margin-right:4px;"></i> {{ Auth::user()->company->email }}</div>
                    @endif
                    @if(Auth::user() && Auth::user()->company && Auth::user()->company->website)
                        <div><i class="bi bi-globe" style="color:#b71c1c; margin-right:4px;"></i> {{ Auth::user()->company->website }}</div>
                    @endif
                </div>
            </div>
            <div style="font-size: 1.3rem; color: #b71c1c; font-weight: bold; margin: 32px 0 16px 0; text-align:center;">Finance Report</div>
            <div style="text-align:center; font-size: 1em; color: #555; margin-bottom: 2px;">From {{ $from->format('d M, Y') }} to {{ $to->format('d M, Y') }}</div>
        </div>
        <!-- End Print Header -->

        <div class="card shadow-sm rounded-4 p-3 print-no-card" style="background: #f8fafc;">
        <table class="table table-bordered align-middle text-end" style="background: white; border-radius: 12px; overflow: hidden;">
            <thead class="table-light">
                <tr>
                    <th style="width: 70%; text-align: left;">Category</th>
                    <th style="width: 30%; text-align: right;">Amount (PKR)</th>
                </tr>
            </thead>
            <tbody>
                <tr class="section-title income-title">
                    <td colspan="2">INCOME</td>
                </tr>
                <tr>
                    <td style="text-align: left;">Total Sales</td>
                    <td class="text-success">{{ number_format($totalSale, 2) }}</td>
                </tr>
                <tr>
                    <td style="text-align: left;">Returns</td>
                    <td class="text-danger">{{ number_format($totalReturns, 2) }}</td>
                </tr>
                <tr>
                    <td style="text-align: left;">Tax</td>
                    <td>{{ number_format($totalTax, 2) }}</td>
                </tr>
                <tr>
                    <td style="text-align: left;">Discounts</td>
                    <td>{{ number_format($totalDiscounts, 2) }}</td>
                </tr>
                <tr style="font-weight: bold;">
                    <td style="text-align: left;">Net Sales (Including Tax)</td>
                    <td class="text-primary">{{ number_format($netSaleIncludingTax, 2) }}</td>
                </tr>
                <tr style="font-weight: bold;">
                    <td style="text-align: left;">Net Sales (Excluding Tax)</td>
                    <td class="text-primary">{{ number_format($netSaleExcludingTax, 2) }}</td>
                </tr>
                <tr>
                    <td style="text-align: left;">External Sales</td>
                    <td>{{ number_format($externalSale, 2) }}</td>
                </tr>
                <tr>
                    <td style="text-align: left;">Payments Received</td>
                    <td>{{ number_format($paymentsReceived, 2) }}</td>
                </tr>
                <tr>
                    <td style="text-align: left;">Accounts Receivable</td>
                    <td>{{ number_format($pendingBalance, 2) }}</td>
                </tr>

                <tr class="section-title expenses-title">
                    <td colspan="2">EXPENSES</td>
                </tr>
                <tr>
                    <td style="text-align: left;">Purchases</td>
                    <td>{{ number_format($totalPurchase, 2) }}</td>
                </tr>
                <tr>
                    <td style="text-align: left;">External Purchases</td>
                    <td>{{ number_format($externalPurchase, 2) }}</td>
                </tr>
                <tr>
                    <td style="text-align: left;">General Expenses</td>
                    <td>{{ number_format($generalExpense, 2) }}</td>
                </tr>
                <tr>
                    <td style="text-align: left;">Marketing Expenses</td>
                    <td>{{ number_format($marketingExpense, 2) }}</td>
                </tr>
                <tr>
                    <td style="text-align: left;">Utility Bills</td>
                    <td>{{ number_format($utilityExpense, 2) }}</td>
                </tr>
                <tr>
                    <td style="text-align: left;">Salaries & Wages</td>
                    <td>{{ number_format($salaryExpense, 2) }}</td>
                </tr>
                <tr>
                    <td style="text-align: left;">Miscellaneous Expenses</td>
                    <td>{{ number_format($miscExpense, 2) }}</td>
                </tr>

                <tr class="section-title summary-title">
                    <td colspan="2">SUMMARY</td>
                </tr>
                <tr style="font-weight: bold; font-size: 1.1em;">
                    <td style="text-align: left;">Gross Profit</td>
                    <td class="text-success">{{ number_format($grossProfit, 2) }}</td>
                </tr>
                <tr style="font-weight: bold; font-size: 1.1em;">
                    <td style="text-align: left;">Net Profit</td>
                    <td class="text-success">{{ number_format($netProfit, 2) }}</td>
                </tr>
                <tr style="font-weight: bold; font-size: 1.1em;">
                    <td style="text-align: left;">Cash In Hand</td>
                    <td class="{{ $cashInHand < 0 ? 'text-danger' : 'text-success' }}">{{ number_format($cashInHand, 2) }}</td>
                </tr>
                <tr>
                    <td style="text-align: left;">Accounts Receivable</td>
                    <td>{{ number_format($pendingBalance, 2) }}</td>
                </tr>
                <tr>
                    <td style="text-align: left;">Accounts Payable</td>
                    <td>{{ number_format($accountsPayablePKR, 2) }}</td>
                </tr>
                <tr style="font-weight: bold; font-size: 1.1em;">
                    <td style="text-align: left;">Net Cash Flow</td>
                    <td class="{{ $netCashFlow < 0 ? 'text-danger' : 'text-success' }}">{{ number_format($netCashFlow, 2) }}</td>
                </tr>
            </tbody>
        </table>
        </div>
    </div>
</div>

{{-- Print Styles --}}
<style>
    @media print {
        body {
            -webkit-print-color-adjust: exact !important;
        }
        .d-print-none {
            display: none !important;
        }
        .d-print-block {
            display: block !important;
        }
        .print-no-card {
            box-shadow: none !important;
            border-radius: 0 !important;
            background: white !important;
            padding: 0 !important;
        }
        table {
            width: 100%;
            border-collapse: collapse !important;
        }
        th, td {
            border: 1px solid #000 !important;
            padding: 12px 10px !important;
            font-size: 15px !important;
        }
        th {
            background-color: #e9ecef !important;
            font-size: 1.1em !important;
        }
        .table-primary {
            background-color: #cfe2ff !important;
        }
        .table-danger {
            background-color: #f8d7da !important;
        }
        .table-secondary {
            background-color: #dee2e6 !important;
        }
        .table-dark {
            background-color: #343a40 !important;
            color: #fff !important;
        }
        @page {
            size: A4 portrait;
            margin: 15mm;
        }
    }
    .card {
        border-radius: 16px;
        box-shadow: 0 2px 12px rgba(0,0,0,0.07);
        border: none;
    }
    .table th, .table td {
        vertical-align: middle;
        font-size: 1em;
        padding: 10px 14px;
    }
    .table thead th {
        background: #e9ecef;
        font-weight: bold;
        font-size: 1.05em;
    }
    .text-success { color: #198754 !important; }
    .text-danger { color: #dc3545 !important; }
    .text-primary { color: #0d6efd !important; }
    .section-title {
        text-align: center !important;
        font-weight: bold !important;
        font-size: 1.15em !important;
        background: #ffe066 !important;
        color: #b71c1c !important;
        letter-spacing: 1px;
    }
    .income-title { background: #cfe2ff !important; color: #0d6efd !important; }
    .expenses-title { background: #f8d7da !important; color: #dc3545 !important; }
    .summary-title { background: #dee2e6 !important; color: #495057 !important; }
</style>

{{-- Print Script --}}
<script>
    function printTable() {
        const originalContent = document.body.innerHTML;
        const tableContent = document.getElementById('financeTableWrapper').innerHTML;

        document.body.innerHTML = `
        <html>
            <head>
                <title>Finance Report</title>
                <style>
                    body {
                        font-family: Arial, sans-serif;
                        -webkit-print-color-adjust: exact !important;
                    }
                    table {
                        width: 100%;
                        border-collapse: collapse !important;
                    }
                    th, td {
                        border: 1px solid #000 !important;
                        padding: 8px;
                        font-size: 12px;
                        text-align: center;
                    }
                    th {
                        background-color: #f2f2f2 !important;
                    }
                    .table-primary { background-color: #cfe2ff !important; }
                    .table-danger { background-color: #f8d7da !important; }
                    .table-dark { background-color: #343a40 !important; color: #fff !important; }
                </style>
            </head>
            <body>${tableContent}</body>
        </html>
        `;

        window.print();
        document.body.innerHTML = originalContent;
        location.reload();
    }
</script>
@endsection
