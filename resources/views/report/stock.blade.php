@extends('layouts.app')

@section('content')
    <div class="container mt-4">

        <div class="d-flex justify-content-between align-items-center mb-4 d-print-none">
            <h4 class="mb-0">Current Inventory Stock</h4>
            <button onclick="printTable()" class="btn btn-primary">
                <i class="bi bi-printer me-1"></i> Print Report
            </button>
        </div>

        <div id="print-section">
            <table class="table table-bordered table-striped" id="stockTable">
                <thead class="table-light">
                    <tr>
                        <th class="text-center" colspan="3">
                            <h3>Current Inventory Stock</h3>
                        </th>
                    </tr>
                    <tr>
                        <th>Item Name</th>
                        <th>Unit</th>
                        <th>Status</th>
                    </tr>

                </thead>
                <tbody>
                    @foreach ($inventories as $item)
                        <tr>
                            <td>{{ $item->item_name }}</td>
                            <td>{{ $item->unit }}</td>
                            <td>
                                @if ($item->status === 'inactive')
                                    <span class="badge bg-secondary">Inactive</span>
                                @elseif($item->unit <= 0)
                                    <span class="badge bg-danger">Out of Stock</span>
                                @elseif($item->unit < 10)
                                    <span class="badge bg-warning text-dark">Low Stock</span>
                                @else
                                    <span class="badge bg-success">In Stock</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>

    {{-- Print Specific Section Script --}}
    <script>
        function printTable() {
            const printContent = document.getElementById('print-section').innerHTML;
            const originalContent = document.body.innerHTML;

            document.body.innerHTML = printContent;
            window.print();
            document.body.innerHTML = originalContent;
            location.reload(); // reload to reattach JS/events
        }
    </script>

    {{-- Print Styling --}}
    <style>
        @media print {
            body {
                -webkit-print-color-adjust: exact !important;
                font-size: 9px;
            }

            table {
                width: 100%;
                border-collapse: collapse !important;
            }

            th,
            td {
                border: 1px solid #000 !important;
                padding: 3px;
            }

            th {
                background-color: #f8f9fa !important;
            }

            .badge {
                font-size: 11px;
            }

            @page {
                size: A4 portrait;
                margin: 15mm;
            }

            html,
            body {
                width: auto;
                height: auto;
            }
        }
    </style>
@endsection
