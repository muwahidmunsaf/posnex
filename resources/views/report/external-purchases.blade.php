@extends('layouts.app')

@section('content')
    <div class="container mt-4">

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="mb-0">External Purchases Report</h4>
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
                <a href="{{ route('reports.externalPurchases') }}" class="btn btn-secondary">Reset</a>
            </div>
        </form>

        <div id="externalPurchaseTableWrapper" class="table-responsive rounded">
            <table class="table table-bordered table-striped">
                <thead class="table-light">
                    <tr>
                        <th>Purchase ID</th>
                        <th>Item</th>
                        <th>Details</th>
                        <th>Amount</th>
                        <th>Source</th>
                        <th>Created By</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($purchases as $purchase)
                        <tr>
                            <td>{{ $purchase->purchaseE_id }}</td>
                            <td>{{ $purchase->item_name }}</td>
                            <td>{{ $purchase->details }}</td>
                            <td>{{ $purchase->purchase_amount }}</td>
                            <td>{{ $purchase->purchase_source }}</td>
                            <td>{{ $purchase->created_by }}</td>
                            <td>{{ $purchase->created_at->format('d-m-Y') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">No records found for selected date.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-3 d-print-none">
            {{ $purchases->appends(request()->query())->links('vendor.pagination.bootstrap-5') }}
        </div>
    </div>

    {{-- Print Script --}}
    <script>
        function printTable() {
            const tableContent = document.getElementById('externalPurchaseTableWrapper').innerHTML;

            const printWindow = window.open('', '', 'width=900,height=650');
            printWindow.document.write(`
            <html>
                <head>
                    <title>External Purchases Report</title>
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
