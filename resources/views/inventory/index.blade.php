@extends('layouts.app')

@section('content')
    <div class="container">
        <h3>Inventory</h3>

        {{-- Search Bar --}}
        <div class="d-flex justify-content-between mb-3">
            <form action="{{ route('inventory.index') }}" method="GET" class="d-flex">
                <input type="text" name="search" value="{{ request('search') }}" class="form-control me-2"
                    placeholder="Search items...">
                <button type="submit" class="btn btn-outline-primary">Search</button>
            </form>
        </div>

        {{-- <a href="{{ route('inventory.create') }}" class="btn btn-primary mb-3">Add New Item</a> --}}

        @if ($inventories->count())
            <table class="table table-bordered align-middle">
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Item</th>
                        <th>Retail</th>
                        <th>Stock</th>
                        <th>Category</th>
                        <th>Supplier</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($inventories as $item)
                        <tr>
                            <td style="width: 80px;">
                                @if ($item->image)
                                    <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->item_name }}"
                                        class="img-thumbnail" style="max-width: 70px; max-height: 70px;">
                                @else
                                    <span class="text-muted">No Image</span>
                                @endif
                            </td>
                            <td>{{ $item->item_name }}</td>
                            <td>{{ $item->retail_amount }}</td>
                            <td>{{ $item->unit }}</td>
                            <td>{{ $item->category->category_name ?? '-' }}</td>
                            <td>{{ $item->supplier->supplier_name ?? '-' }}</td>
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

                                <!-- Delete Button triggers modal -->
                                <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                    data-bs-target="#deleteModal{{ $item->id }}">
                                    Delete
                                </button>
                                <!-- Modal -->
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

            {{ $inventories->links('vendor.pagination.bootstrap-5') }}
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
            });
        </script>
    @endpush

@endsection
