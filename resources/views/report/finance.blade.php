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
        <div class="text-center mb-3 d-none d-print-block">
            <h4 class="fw-bold mb-0">{{ config('app.name') }} - Finance Report</h4>
            <small>From {{ $from->format('d M, Y') }} to {{ $to->format('d M, Y') }}</small>
        </div>

        <table class="table table-bordered align-middle text-center">
            <thead class="table-light">
                <tr>
                    <th style="width: 70%">Category</th>
                    <th style="width: 30%">Amount (PKR)</th>
                </tr>
            </thead>
            <tbody>
                <tr class="table-primary fw-bold">
                    <td colspan="2">Income</td>
                </tr>
                <tr>
                    <td>Sales</td>
                    <td>{{ number_format($totalSale, 2) }}</td>
                </tr>
                <tr>
                    <td>Returns</td>
                    <td class="text-danger">-{{ number_format($totalReturns, 2) }}</td>
                </tr>
                <tr>
                    <td><strong>Net Sales</strong></td>
                    <td><strong>{{ number_format($netSale, 2) }}</strong></td>
                </tr>
                <tr>
                    <td>External Sales</td>
                    <td>{{ number_format($externalSale, 2) }}</td>
                </tr>

                <tr class="table-danger fw-bold">
                    <td colspan="2">Expenses</td>
                </tr>
                <tr>
                    <td>Purchases</td>
                    <td>{{ number_format($totalPurchase, 2) }}</td>
                </tr>
                <tr>
                    <td>External Purchases</td>
                    <td>{{ number_format($externalPurchase, 2) }}</td>
                </tr>
                <tr>
                    <td>General Expenses</td>
                    <td>{{ number_format($totalExpense, 2) }}</td>
                </tr>

                <tr class="table-dark text-white fw-bold">
                    <td>Net Income</td>
                    <td>
                        {{ number_format(($netSale + $externalSale) - ($totalPurchase + $externalPurchase + $totalExpense), 2) }}
                    </td>
                </tr>
            </tbody>
        </table>
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

        table {
            width: 100%;
            border-collapse: collapse !important;
        }

        th, td {
            border: 1px solid #000 !important;
            padding: 8px;
            font-size: 12px;
        }

        th {
            background-color: #e9ecef !important;
        }

        .table-primary {
            background-color: #cfe2ff !important;
        }

        .table-danger {
            background-color: #f8d7da !important;
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
