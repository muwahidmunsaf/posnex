@extends('layouts.app')

@section('content')
<style>
@media print {
    body * { visibility: hidden !important; }
    .table-responsive, .table-responsive * { visibility: visible !important; }
    .table-responsive { position: absolute; left: 0; top: 0; width: 100%; }
    .sidebar, .navbar, .btn, form, .alert, h3, .container > *:not(.table-responsive) { display: none !important; }
    .print-address { display: table-cell !important; }
    .no-print { display: none !important; }
}
@media screen {
    .print-address { display: none !important; }
}
</style>
<div class="container">
    <h3>Customers</h3>
    <a href="{{ route('customers.create') }}" class="btn btn-primary mb-3">Add Customer</a>

    <form method="GET" action="{{ route('customers.index') }}" class="row g-3 mb-3">
        <div class="col-auto">
            <input type="text" name="city" class="form-control" placeholder="Search by City" value="{{ $city ?? '' }}">
        </div>
        <div class="col-auto">
            <button type="submit" class="btn btn-secondary">Filter</button>
            <button type="button" class="btn btn-outline-primary" onclick="window.print()">Print List</button>
        </div>
    </form>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($customers->count())
    <div class="table-responsive">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Name</th>
                <th>Type</th>
                <th>Cell No</th>
                <th>Email</th>
                <th>CNIC</th>
                <th>City</th>
                <th class="print-address">Address</th>
                <th class="no-print">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($customers as $customer)
            <tr>
                <td>{{ $customer->name }}</td>
                <td>{{ ucfirst($customer->type) }}</td>
                <td>{{ $customer->cel_no }}</td>
                <td>{{ $customer->email }}</td>
                <td>{{ $customer->cnic }}</td>
                <td>{{ $customer->city }}</td>
                <td class="print-address">{{ $customer->address }}</td>
                <td class="no-print">
                    <a href="{{ route('customers.edit', $customer->id) }}" class="btn btn-sm btn-warning">Edit</a>
                    <a href="{{ route('customers.history', $customer->id) }}" class="btn btn-sm btn-info ms-1">View History</a>
                    <!-- Delete button trigger modal -->
                    <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $customer->id }}">
                        Delete
                    </button>
                    <!-- Modal -->
                    <div class="modal fade" id="deleteModal{{ $customer->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $customer->id }}" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-top">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="deleteModalLabel{{ $customer->id }}">Confirm Delete</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    Are you sure you want to delete <strong>{{ $customer->name }}</strong>?
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    <form action="{{ route('customers.destroy', $customer->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Yes, Delete</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End modal -->
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    </div>
    {{ $customers->links('vendor.pagination.bootstrap-5') }}
    @else
    <p>No customers found.</p>
    @endif
</div>
@endsection

@push('scripts')
<script>
function printPaymentHistory(elementId) {
    var printContents = document.getElementById(elementId).innerHTML;
    var originalContents = document.body.innerHTML;
    document.body.innerHTML = printContents;
    window.print();
    document.body.innerHTML = originalContents;
    location.reload();
}
</script>
@endpush
