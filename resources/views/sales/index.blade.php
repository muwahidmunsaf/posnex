@extends('layouts.pos')

@section('pos')
    <div class="container mt-4">
        <h3>INVOICE</h3>
        <hr>
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        <form method="GET" action="{{ route('sales.index') }}" class="row g-3 mb-3">
            <div class="col-auto">
                <input type="text" name="search" class="form-control" placeholder="Search Sale Code"
                    value="{{ request('search') }}">
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-primary">Search</button>
                <a href="{{ route('sales.index') }}" class="btn btn-secondary">Reset</a>
            </div>
        </form>
<div class="table-responsive rounded">
        <table class="table table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>Sale ID</th>
                    <th>Created By</th>
                    <th>Customer</th>
                    <th>Subtotal</th>
                    <th>Tax %</th>
                    <th>Tax Amount</th>
                    <th>Total</th>
                    <th>Payment Method</th>
                    <th>Discount</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($sales as $sale)
                    <tr>
                        <td>{{ $sale->sale_code }}</td>
                        <td>{{ $sale->created_by }}</td>
                        <td>{{ $sale->customer->name  ?? '-'}}</td>
                        <td>{{ $sale->subtotal }}</td>
                        <td>{{ $sale->tax_percentage }}%</td>
                        <td>{{ $sale->tax_amount }}</td>
                        <td>{{ $sale->total_amount }}</td>
                        <td>{{ ucfirst($sale->payment_method) }}</td>
                        <td>{{ $sale->discount }}</td>
                        <td>
                            <a href="{{ route('sales.print', $sale->id) }}" class="btn btn-sm btn-primary" target="_blank">
                                <i class="bi bi-printer"></i> Print
                            </a>
                            <a href="{{ route('sales.return', $sale->id) }}" class="btn btn-sm btn-warning ms-1">
                                <i class="bi bi-arrow-counterclockwise"></i> Return/Exchange
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        </div>
        {{ $sales->links('vendor.pagination.bootstrap-5') }}
    </div>
@endsection
