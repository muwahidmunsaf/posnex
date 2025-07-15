@extends('layouts.app')

@section('content')
    <div class="container">
        <h3>PURCHASES</h3>
        <hr>

        <a href="{{route ('purchase.create')}}" class="mb-3 btn btn-primary">Add Stock</a>
        

        <form method="GET" class="row g-3 align-items-end mb-4">
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
                <a href="{{ route('purchase.index') }}" class="btn btn-secondary">Reset</a>
            </div>
        </form>

        @if ($purchases->count())
            <table class="table table-bordered align-middle">
                <thead>
                    <tr>
                        <th>Supplier</th>
                        <th>Total Amount</th>
                        <th>Purchase Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($purchases as $purchase)
                        <tr>
                            <td>{{ $purchase->supplier->supplier_name ?? '-' }}</td>
                            <td>{{ number_format($purchase->total_amount, 2) }}</td>
                            <td>{{ $purchase->purchase_date }}</td>
                            <td>
                                <button class="btn btn-sm btn-info" data-bs-toggle="modal"
                                    data-bs-target="#itemsModal{{ $purchase->id }}">
                                    <i class="bi bi-eye-fill"></i>
                                </button>

                                <a href="{{ route('purchase.edit', $purchase->id) }}" class="btn btn-sm btn-warning"><i
                                        class="bi bi-pencil-square"></i>
                                </a>
                                <a href="{{ route('purchase.print', $purchase->id) }}" class="btn btn-sm btn-secondary" title="Print Invoice" target="_blank"><i class="bi bi-printer"></i></a>

                                @php
                                    $userRole = auth()->user()->role;
                                @endphp

                                @if (in_array($userRole, ['superadmin', 'admin']))
                                    <!-- Delete Button triggers modal -->
                                    <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                        data-bs-target="#deleteModal{{ $purchase->id }}">
                                        <i class="bi bi-trash-fill"></i>
                                    </button>
                                @endif

                                <!-- Modal -->
                                <div class="modal fade" id="deleteModal{{ $purchase->id }}" tabindex="-1"
                                    aria-labelledby="deleteModalLabel{{ $purchase->id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-top">
                                        <div class="modal-content">
                                            <div class="modal-header bg-danger text-white">
                                                <h5 class="modal-title" id="deleteModalLabel{{ $purchase->id }}">Confirm
                                                    Delete
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                Are you sure you want to delete?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Cancel</button>

                                                <form action="{{ route('purchase.destroy', $purchase->id) }}"
                                                    method="POST" class="d-inline">
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

            {{ $purchases->links('vendor.pagination.bootstrap-5') }}
        @else
            <p>No purchases found.</p>
        @endif

        {{-- Purchase Item Modals --}}
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
@endsection
