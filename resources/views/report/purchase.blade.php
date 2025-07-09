@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3 class="mb-0">PURCHASE REPORT</h3>
            <button onclick="printTable()" class="btn btn-success d-print-none">
                <i class="bi bi-printer me-1"></i> Print Report
            </button>
        </div>

        {{-- Filter Form --}}
        <form method="GET" class="row g-3 align-items-end mb-4 d-print-none">
            <div class="col-md-3">
                <label for="search">Search</label>
                <input type="text" name="search" id="search" class="form-control" value="{{ request('search') }}"
                    placeholder="Supplier or Amount">
            </div>

            <div class="col-md-3">
                <label for="from">From</label>
                <input type="date" name="from" id="from" class="form-control" value="{{ request('from') }}">
            </div>

            <div class="col-md-3">
                <label for="to">To</label>
                <input type="date" name="to" id="to" class="form-control" value="{{ request('to') }}">
            </div>

            <div class="col-md-auto">
                <button type="submit" class="btn btn-primary">Filter</button>
                <a href="{{ route('reports.purchase') }}" class="btn btn-secondary">Reset</a>
            </div>
        </form>

        {{-- Table --}}
        <div id="purchaseTableWrapper" class="table-responsive rounded">
            @if ($purchases->count())
                <table class="table table-bordered align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>Supplier</th>
                            <th>Total Amount</th>
                            <th>Purchase Date</th>
                            <th id="action">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($purchases as $purchase)
                            <tr>
                                <td>{{ $purchase->supplier->supplier_name ?? '-' }}</td>
                                <td>{{ number_format($purchase->total_amount, 2) }}</td>
                                <td>{{ $purchase->purchase_date }}</td>
                                <td id="action">
                                    <button class="btn btn-sm btn-info" data-bs-toggle="modal"
                                        data-bs-target="#itemsModal{{ $purchase->id }}">
                                        View Items
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="d-print-none mt-3">
                    {{ $purchases->appends(request()->query())->links('vendor.pagination.bootstrap-5') }}
                </div>
            @else
                <p>No purchases found.</p>
            @endif
        </div>

        {{-- Modals --}}
        @foreach ($purchases as $purchase)
            <div class="modal fade" id="itemsModal{{ $purchase->id }}" tabindex="-1"
                aria-labelledby="itemsModalLabel{{ $purchase->id }}" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Items for Purchase #{{ $purchase->id }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            @if ($purchase->items && count($purchase->items))
                                <table class="table table-bordered">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Item</th>
                                            <th>Quantity</th>
                                            <th>Unit Price</th>
                                            <th>Total Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($purchase->items as $item)
                                            <tr>
                                                <td>{{ $item->inventory->item_name ?? '-' }}</td>
                                                <td>{{ $item->quantity }}</td>
                                                <td>{{ number_format($item->purchase_amount / $item->quantity, 2) }}</td>
                                                <td>{{ number_format($item->purchase_amount, 2) }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @else
                                <p class="text-muted">No items found for this purchase.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    {{-- Print Styles --}}
    <style>
        @media print {
            .d-print-none {
                display: none !important;
            }
            #action{
                display: none !important;
            }

            body {
                -webkit-print-color-adjust: exact !important;
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
                text-align: center;
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
    <script>
        function printTable() {
            const tableContent = document.getElementById('purchaseTableWrapper').innerHTML;
            const printWindow = window.open('', '', 'width=900,height=650');
            printWindow.document.write(`
        <html>
            <head>
                <title>Purchase Report</title>
                <style>
                    body {
                        font-family: Arial, sans-serif;
                        -webkit-print-color-adjust: exact !important;
                    }
                    .d-print-none {
                        display: none !important;
                    }
                    #action {
                        display: none !important;
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
