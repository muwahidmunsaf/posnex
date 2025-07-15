@extends('layouts.app')

@section('content')
    <div class="container">
        <h3>Inventory</h3>

        {{-- Bulk Delete Button --}}
        <form id="bulk-delete-form" action="{{ route('inventory.bulkDelete') }}" method="POST" style="display:inline;">
            @csrf
            <button type="submit" class="btn btn-danger mb-3" id="delete-selected-btn" disabled>Delete Selected</button>
        </form>

        <div class="d-flex justify-content-between align-items-center mb-3">
            <div class="d-flex align-items-center gap-2">
                <form action="{{ route('inventory.importExcel') }}" method="POST" enctype="multipart/form-data" class="d-flex align-items-center gap-2 mb-0">
                    @csrf
                    <input type="file" name="excel_file" accept=".xlsx,.csv" class="form-control" required style="max-width:200px;">
                    <button type="submit" class="btn btn-primary">Import via Excel</button>
                </form>
                <a href="{{ route('inventory.exportExcel', request()->all()) }}" class="btn btn-success">Export to Excel</a>
                <a href="{{ route('inventory.printCatalogue', request()->all()) }}" class="btn btn-secondary" target="_blank">Print Catalogue</a>
            </div>
            <div class="ms-auto">
                @if($inventories instanceof \Illuminate\Pagination\LengthAwarePaginator || $inventories instanceof \Illuminate\Pagination\Paginator)
                    <span>
                        Showing {{ $inventories->firstItem() }} to {{ $inventories->lastItem() }} of {{ $inventories->total() }} products
                    </span>
                @else
                    <span>
                        Showing 1 to {{ $inventories->count() }} of {{ $inventories->count() }} products
                    </span>
                @endif
            </div>
        </div>

        {{-- Per Page Dropdown --}}
        <form method="GET" action="" class="d-inline-block mb-3">
            <label for="per_page" class="me-2">Show</label>
            <select name="per_page" id="per_page" class="form-select d-inline-block w-auto" onchange="this.form.submit()">
                <option value="10" {{ request('per_page', 10) == 10 ? 'selected' : '' }}>10</option>
                <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100</option>
                <option value="all" {{ request('per_page') == 'all' ? 'selected' : '' }}>All</option>
            </select>
            <span class="ms-2">products per page</span>
        </form>

        {{-- Search Bar --}}
        <div class="d-flex justify-content-between mb-3">
            <form action="{{ route('inventory.index') }}" method="GET" class="d-flex">
                <input type="text" name="search" value="{{ request('search') }}" class="form-control me-2"
                    placeholder="Search items...">
                <input type="hidden" name="per_page" value="{{ request('per_page', 10) }}">
                <button type="submit" class="btn btn-outline-primary">Search</button>
            </form>
        </div>

        {{-- <a href="{{ route('inventory.create') }}" class="btn btn-primary mb-3">Add New Item</a> --}}

        @if ($inventories->count())
            <table class="table table-bordered align-middle">
                <thead>
                    <tr>
                        <th><input type="checkbox" id="select-all"></th>
                        <th>Item</th>
                        <th>Retail</th>
                        <th>Wholesale</th>
                        <th>Stock</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($inventories as $item)
                        <tr>
                            <td><input type="checkbox" class="row-checkbox" name="selected_ids[]" value="{{ $item->id }}" form="bulk-delete-form"></td>
                            <td>{{ $item->item_name }}</td>
                            <td>{{ $item->retail_amount }}</td>
                            <td>{{ $item->wholesale_amount }}</td>
                            <td>{{ $item->unit }}</td>
                            <td>
                                <div class="form-check form-switch">
                                    <input class="form-check-input status-toggle" type="checkbox"
                                        data-id="{{ $item->id }}" {{ $item->status === 'active' ? 'checked' : '' }}>
                                    <label class="form-check-label">
                                        {{ $item->status === 'active' ? 'Active' : 'Inactive' }}
                                    </label>
                                </div>
                            </td>
                            <td>
                                <a href="{{ route('inventory.edit', $item->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                    data-bs-target="#deleteModal{{ $item->id }}">
                                    Delete
                                </button>
                                <div class="modal fade" id="deleteModal{{ $item->id }}" tabindex="-1"
                                    aria-labelledby="deleteModalLabel{{ $item->id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-top">
                                        <div class="modal-content">
                                            <div class="modal-header bg-danger text-white">
                                                <h5 class="modal-title" id="deleteModalLabel{{ $item->id }}">Confirm
                                                    Delete
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                Are you sure you want to delete <strong>{{ $item->name }}</strong>?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Cancel</button>
                                                <form action="{{ route('inventory.destroy', $item->id) }}" method="POST"
                                                    class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">Yes, Delete</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            @if ($inventories instanceof \Illuminate\Pagination\LengthAwarePaginator || $inventories instanceof \Illuminate\Pagination\Paginator)
                {{ $inventories->links('vendor.pagination.bootstrap-5') }}
            @endif
        @else
            <p>No items found.</p>
        @endif
    </div>
    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                document.querySelectorAll('.status-toggle').forEach(function(toggle) {
                    toggle.addEventListener('change', function() {
                        const itemId = this.dataset.id;
                        const isChecked = this.checked;

                        fetch(`/inventory/${itemId}/toggle-status`, {
                                method: 'PATCH',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                },
                                body: JSON.stringify({
                                    status: isChecked ? 'active' : 'inactive'
                                })
                            })
                            .then(res => {
                                if (!res.ok) throw new Error('Failed to update status.');
                                return res.json();
                            })
                            .then(data => {
                                this.nextElementSibling.textContent = data.status_label;
                            })
                            .catch(error => {
                                alert(error.message);
                                this.checked = !isChecked; // revert if failed
                            });
                    });
                });

                // Bulk select logic
                const selectAll = document.getElementById('select-all');
                const checkboxes = document.querySelectorAll('.row-checkbox');
                const deleteBtn = document.getElementById('delete-selected-btn');
                function updateDeleteBtn() {
                    const anyChecked = Array.from(checkboxes).some(cb => cb.checked);
                    deleteBtn.disabled = !anyChecked;
                }
                selectAll.addEventListener('change', function() {
                    checkboxes.forEach(cb => cb.checked = selectAll.checked);
                    updateDeleteBtn();
                });
                checkboxes.forEach(cb => {
                    cb.addEventListener('change', function() {
                        updateDeleteBtn();
                        if (!cb.checked) selectAll.checked = false;
                        else if (Array.from(checkboxes).every(cb => cb.checked)) selectAll.checked = true;
                    });
                });
                updateDeleteBtn();
            });
        </script>
    @endpush

@endsection
