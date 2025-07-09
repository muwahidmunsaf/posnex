@extends('layouts.app')

@section('content')
    <div class="container mt-4">

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3 class="mb-0">INVOICE REPORT</h3>
            <button onclick="printTable()" class="btn btn-success d-print-none">
                <i class="bi bi-printer me-1"></i> Print Report
            </button>
        </div>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form method="GET" action="{{ route('reports.invoices') }}" class="row g-3 mb-3 d-print-none">
            <div class="col-md-4">
                <input type="text" name="search" class="form-control" placeholder="Search Sale Code / Customer"
                    value="{{ request('search') }}">
            </div>
            <div class="col-md-3">
                <input type="date" name="date" class="form-control" value="{{ request('date') }}">
            </div>
            <div class="col-md-auto">
                <button type="submit" class="btn btn-primary">Filter</button>
                <a href="{{ route('reports.invoices') }}" class="btn btn-secondary">Reset</a>
            </div>
        </form>

        <div id="invoiceTableWrapper" class="table-responsive rounded">
            <table class="table table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>Sale ID</th>
                        <th>Created By</th>
                        <th>Customer</th>
                        <th>Subtotal</th>
                        <th>Tax %</th>
                        <th>Tax Amount</th>
                        <th>Total</th>
                        <th>Payment</th>
                        <th>Discount</th>
                        <th class="d-print-none action">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($sales as $sale)
                        <tr>
                            <td>{{ $sale->sale_code }}</td>
                            <td>{{ $sale->created_by }}</td>
                            <td>{{ $sale->customer->name ?? '-' }}</td>
                            <td>{{ number_format($sale->subtotal, 2) }}</td>
                            <td>{{ $sale->tax_percentage }}%</td>
                            <td>{{ number_format($sale->tax_amount, 2) }}</td>
                            <td>{{ number_format($sale->total_amount, 2) }}</td>
                            <td>{{ ucfirst($sale->payment_method) }}</td>
                            <td>{{ number_format($sale->discount, 2) }}</td>
                            <td class="d-print-none">
                                <a href="{{ route('sales.print', $sale->id) }}" class="btn btn-sm btn-primary"
                                    target="_blank">
                                    <i class="bi bi-printer"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="text-center text-muted">No records found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-3 d-print-none">
            {{ $sales->appends(request()->query())->links('vendor.pagination.bootstrap-5') }}
        </div>

    </div>

    {{-- Print Styling --}}
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

            th,
            td {
                border: 1px solid #000 !important;
                padding: 6px;
                font-size: 11px;
            }

            th {
                background-color: #f0f0f0 !important;
            }

            @page {
                size: A4 portrait;
                margin: 15mm;
            }
        }
    </style>

    {{-- Print Script --}}
    {{-- Print Script --}}
    <script>
        function printTable() {
            const tableContent = document.getElementById('invoiceTableWrapper').innerHTML;

            const printWindow = window.open('', '', 'width=900,height=650');
            printWindow.document.write(`
            <html>
                <head>
                    <title>Invoice Report</title>
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
                            padding: 6px;
                            font-size: 11px;
                            text-align: center;
                        }
                        th {
                            background-color: #f0f0f0 !important;
                        }
                        .d-print-none {
                            display: none !important;
                        }
                        @page {
                            size: A4 portrait;
                            margin: 15mm;
                        }
                    </style>
                </head>
                <body onload="window.print(); window.close();">
                    ${tableContent}
                </body>
            </html>
        `);
            printWindow.document.close();
        }
    </script>
@endsection
