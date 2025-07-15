@extends('layouts.pos')

@section('pos')
    <div class="container mt-4">
        <h3><i class="fa fa-boxes-stacked text-secondary me-2"></i>INVENTORY STATUS</h3>
<hr>
        <div class="card shadow p-3 mb-4">
            <div class="d-flex flex-row flex-wrap align-items-center gap-2 mb-3" style="max-width:500px;">
                <input type="text" id="inventorySearch" class="form-control rounded-pill" placeholder="Search Inventory..." style="min-width:180px;">
                <button type="button" class="btn btn-primary rounded-circle d-flex align-items-center justify-content-center" title="Search" style="width:40px;height:40px;" onclick="filterInventoryTable()"><i class="fa fa-search"></i></button>
                <button type="button" class="btn btn-secondary rounded-circle d-flex align-items-center justify-content-center" title="Reset" style="width:40px;height:40px;" onclick="resetInventoryTable()"><i class="fa fa-undo"></i></button>
            </div>
            <div class="table-responsive rounded">
                <table class="table table-hover align-middle rounded" id="inventoryTable" style="overflow:hidden;">
                    <thead class="table-light">
                        <tr>
                            <th>Item Name</th>
                            <th>Unit</th>
                            <th>Retail Price</th>
                            <th>Wholesale Price</th>
                            <th>Unit Sold</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($inventories as $item)
                            @php
                                $status = 'In Stock';
                                $badge = 'success';
                                if ($item->unit <= 0) {
                                    $status = 'Out of Stock';
                                    $badge = 'danger';
                                } elseif ($item->unit < 10) {
                                    $status = 'Low Stock';
                                    $badge = 'warning';
                                }
                                if ($item->status === 'inactive') {
                                    $status = 'Inactive';
                                    $badge = 'secondary';
                                }
                            @endphp
                            <tr style="transition:background 0.2s;">
                                <td>{{ $item->item_name }}</td>
                                <td>{{ $item->unit }}</td>
                                <td>{{ $item->retail_amount }}</td>
                                <td>{{ $item->wholesale_amount ?? '-' }}</td>
                                <td>{{ $item->unit_sold }}</td>
                                <td><span class="badge bg-{{ $badge }}">{{ $status }}</span></td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">No inventory items found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <!-- FontAwesome CDN for icons -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <style>
        .table thead th { border-top: none; }
        .table-hover tbody tr:hover { background: #f5f7fa; }
        .table td, .table th {
            vertical-align: middle;
            border-radius: 8px;
            border: 1.5px solid #e3e6ea;
        }
        .table tr {
            border-bottom: 2.5px solid #cfd8dc;
        }
        .btn.rounded-circle { width: 32px; height: 32px; padding: 0; font-size: 1.1rem; }
        .form-control.rounded-pill { border-radius: 50px; }
        .card { border-radius: 18px; }
        .table-responsive {
            width: 100%;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }
        .table {
            width: 100%;
            min-width: 900px;
            border-collapse: separate;
            border-spacing: 0;
        }
        @media (max-width: 991px) {
            .table {
                min-width: 700px;
                font-size: 13px;
            }
            .btn.rounded-circle { width: 28px; height: 28px; font-size: 1rem; }
            .form-control.rounded-pill { font-size: 13px; }
        }
        @media (max-width: 767px) {
            .table {
                min-width: 600px;
                font-size: 12px;
            }
            .btn.rounded-circle { width: 24px; height: 24px; font-size: 0.95rem; }
            .form-control.rounded-pill { font-size: 12px; }
            .table-responsive { border-radius: 8px; }
        }
        </style>
        <script>
        function filterInventoryTable() {
            let value = document.getElementById('inventorySearch').value.toLowerCase();
            let rows = document.querySelectorAll('#inventoryTable tbody tr');
            rows.forEach(row => {
                let text = row.textContent.toLowerCase();
                row.style.display = text.includes(value) ? '' : 'none';
            });
        }
        document.getElementById('inventorySearch').addEventListener('keyup', filterInventoryTable);
        function resetInventoryTable() {
            document.getElementById('inventorySearch').value = '';
            filterInventoryTable();
        }
        </script>
    </div>
@endsection
