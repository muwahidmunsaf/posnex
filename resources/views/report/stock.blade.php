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
                <div style="font-size: 1.3rem; color: #b71c1c; font-weight: bold; margin: 32px 0 16px 0; text-align:center;">Current Inventory Stock</div>
            </div>
            <!-- End Print Header -->
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
                        <th>Sold Unit</th>
                        <th>Status</th>
                    </tr>

                </thead>
                <tbody>
                    @foreach ($inventories as $item)
                        <tr>
                            <td>{{ $item->item_name }}</td>
                            <td>{{ $item->unit }}</td>
                            <td>{{ $item->sold_unit }}</td>
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
