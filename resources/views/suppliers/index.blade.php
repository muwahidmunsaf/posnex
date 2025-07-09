@extends('layouts.app')

@section('content')
    <div class="container">
        <h3>Suppliers</h3>
        <a href="{{ route('suppliers.create') }}" class="btn btn-primary mb-3">Add Supplier</a>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Contact Person</th>
                    <th>Cell No</th>
                    <th>Email</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($suppliers as $supplier)
                    <tr>
                        <td>{{ $supplier->supplier_name }}</td>
                        <td>{{ $supplier->contact_person }}</td>
                        <td>{{ $supplier->cell_no }}</td>
                        <td>{{ $supplier->email }}</td>
                        <td>
                            <a href="{{ route('suppliers.edit', $supplier->id) }}" class="btn btn-sm btn-warning">Edit</a>
                            <!-- Delete Button trigger modal -->
                            <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                data-bs-target="#deleteSupplierModal{{ $supplier->id }}">
                                Delete
                            </button>

                            <!-- Modal -->
                            <div class="modal fade" id="deleteSupplierModal{{ $supplier->id }}" tabindex="-1"
                                aria-labelledby="deleteSupplierModalLabel{{ $supplier->id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header bg-danger text-white">
                                            <h5 class="modal-title" id="deleteSupplierModalLabel{{ $supplier->id }}">
                                                Confirm Deletion</h5>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            Are you sure you want to delete
                                            <strong>{{ $supplier->supplier_name }}</strong>?
                                        </div>
                                        <div class="modal-footer">
                                            <form action="{{ route('suppliers.destroy', $supplier->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Cancel</button>
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

        {{ $suppliers->links('vendor.pagination.bootstrap-5') }}
    </div>
@endsection
