@extends('layouts.app')

@section('content')
    <div class="container mt-4">

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="mb-0">External Sales Report</h4>
            <button onclick="printTable()" class="btn btn-success d-print-none">
                <i class="bi bi-printer me-1"></i> Print Report
            </button>
        </div>

        <form method="GET" class="row row-cols-lg-auto g-3 align-items-center mb-3 d-print-none">
            <div class="col-12">
                <input type="date" name="date" class="form-control" value="{{ request('date') }}">
            </div>
            <div class="col-12">
                <button type="submit" class="btn btn-primary">Filter</button>
                <a href="{{ route('reports.externalSales') }}" class="btn btn-secondary">Reset</a>
            </div>
        </form>

        <div id="externalSalesTableWrapper" class="table-responsive rounded">
            <table class="table table-bordered table-striped">
                <thead class="table-light">
                    <tr>
                        <th>Sale ID</th>
                        <th>Item</th>
                        <th>Sale Amount</th>
                        <th>Tax</th>
                        <th>Total</th>
                        <th>Payment</th>
                        <th>Customer</th>
                        <th>Created By</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($sales as $sale)
                        <tr>
                            <td>{{ $sale->saleE_id }}</td>
                            <td>{{ $sale->purchase->item_name ?? '-' }}</td>
                            <td>{{ $sale->sale_amount }}</td>
                            <td>{{ $sale->tax_amount }}</td>
                            <td>{{ $sale->total_amount }}</td>
                            <td>{{ ucfirst($sale->payment_method) }}</td>
                            <td>{{ $sale->customer->name ?? 'N/A' }}</td>
                            <td>{{ $sale->created_by }}</td>
                            <td>{{ $sale->created_at->format('d-m-Y') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center">No records found for selected date.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-3 d-print-none">
            {{ $sales->appends(request()->query())->links('vendor.pagination.bootstrap-5') }}
        </div>
    </div>

    {{-- Print Script --}}
    <script>
        function printTable() {
            const tableContent = document.getElementById('externalSalesTableWrapper').innerHTML;

            const printWindow = window.open('', '', 'width=900,height=650');
            printWindow.document.write(`
            <html>
                <head>
                    <title>External Sales Report</title>
                    <style>
                        body {
                            font-family: Arial, sans-serif;
                            -webkit-print-color-adjust: exact !important;
                        }
                        table {
                            width: 100%;
                            border-collapse: collapse;
                        }
                        th, td {
                            border: 1px solid #000;
                            padding: 6px;
                            font-size: 11px;
                            text-align: center;
                        }
                        th {
                            background-color: #f0f0f0;
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
