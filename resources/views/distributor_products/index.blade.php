@extends('layouts.app')
@section('content')
<div class="container">
    <h2 class="mb-4">Assign Products to Distributors</h2>
    <div class="mb-3">
        <form method="GET" class="row g-2 align-items-end">
            <div class="col-auto">
                <label for="distributor_id" class="form-label">Filter by Distributor</label>
                <select name="distributor_id" id="distributor_id" class="form-select">
                    <option value="">All Distributors</option>
                    @foreach($distributors as $distributor)
                        <option value="{{ $distributor->id }}" {{ $distributor_id == $distributor->id ? 'selected' : '' }}>{{ $distributor->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-danger">Filter</button>
            </div>
            <div class="col-auto ms-auto">
                <a href="{{ route('distributor-products.create', ['distributor_id' => $distributor_id]) }}" class="btn btn-success">Assign Product</a>
            </div>
        </form>
    </div>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('print_assignment_number'))
        <div class="alert alert-info" style="display:flex;align-items:center;justify-content:space-between;">
            <span>Assignment completed. You can print the invoice:</span>
            <a href="{{ route('distributor-products.print-receipt', ['assignment_number' => session('print_assignment_number'), 'vat_percent' => session('print_vat_percent', 15)]) }}" target="_blank" class="btn btn-danger ms-3">
                <i class="bi bi-printer"></i> Print Invoice
            </a>
        </div>
    @endif
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Assignment #</th>
                            <th>Distributor</th>
                            <th>Product</th>
                            <th>Quantity Assigned</th>
                            <th>Quantity Remaining</th>
                            <th>Unit Price</th>
                            <th>Total Value</th>
                            <th>Status</th>
                            <th>Assignment Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($assignments as $assignment)
                        <tr>
                            <td>{{ $assignment['assignment_number'] ?? 'N/A' }}</td>
                            <td>{{ $assignment['distributor']->name }}</td>
                            <td>{{ $assignment['products'] }}</td>
                            <td>{{ $assignment['quantity_assigned'] }}</td>
                            <td>{{ $assignment['quantity_remaining'] }}</td>
                            <td>{{ $assignment['unit_prices'] }}</td>
                            <td>Rs {{ number_format($assignment['total_value'], 2) }}</td>
                            <td>{{ ucfirst($assignment['status']) }}</td>
                            <td>{{ \Carbon\Carbon::parse($assignment['assignment_date'])->format('Y-m-d') }}</td>
                            <td>
                                @if($assignment['assignment_number'])
                                    <a href="{{ route('distributor-products.print-receipt', ['assignment_number' => $assignment['assignment_number']]) }}" class="btn btn-sm btn-info" target="_blank">Print</a>
                                @endif
                                <a href="{{ route('distributor-products.bulk-edit', ['assignment_number' => $assignment['assignment_number']]) }}" class="btn btn-sm btn-warning">Edit</a>
                                <form action="{{ route('distributor-products.bulk-delete', ['assignment_number' => $assignment['assignment_number']]) }}" method="POST" style="display:inline-block;">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete this entire assignment and all its products?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="10" class="text-center">No product assignments found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                {{ $assignments->withQueryString()->links() }}
            </div>
        </div>
    </div>
</div>
@endsection 