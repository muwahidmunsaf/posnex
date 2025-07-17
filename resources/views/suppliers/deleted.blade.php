@extends('layouts.app')

@section('content')
<div class="container">
    <h3 class="mb-4">Deleted Suppliers</h3>
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <a href="{{ route('suppliers.index') }}" class="btn btn-secondary mb-3">Back to Suppliers</a>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Name</th>
                <th>Contact Person</th>
                <th>Cell No</th>
                <th>Country</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($deletedSuppliers as $supplier)
                <tr>
                    <td>{{ $supplier->supplier_name }}</td>
                    <td>{{ $supplier->contact_person }}</td>
                    <td>{{ $supplier->cell_no }}</td>
                    <td>{{ $supplier->country }}</td>
                    <td>
                        <form action="{{ route('suppliers.restore', $supplier->id) }}" method="POST" style="display:inline;">
                            @csrf
                            <button type="submit" class="btn btn-success btn-sm">Restore</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">No deleted suppliers found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection 