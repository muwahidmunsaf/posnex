@extends('layouts.app')

@section('content')
<div class="container">
    <h3 class="mb-4">Deleted Customers</h3>
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <a href="{{ route('customers.index') }}" class="btn btn-secondary mb-3">Back to Customers</a>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Name</th>
                <th>Contact Person</th>
                <th>Cell No</th>
                <th>City</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($deletedCustomers as $customer)
                <tr>
                    <td>{{ $customer->name }}</td>
                    <td>{{ $customer->contact_person ?? '-' }}</td>
                    <td>{{ $customer->cell_no ?? '-' }}</td>
                    <td>{{ $customer->city ?? '-' }}</td>
                    <td>
                        <form action="{{ route('customers.restore', $customer->id) }}" method="POST" style="display:inline;">
                            @csrf
                            <button type="submit" class="btn btn-success btn-sm">Restore</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">No deleted customers found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection 