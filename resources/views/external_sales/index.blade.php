@extends('layouts.pos')

@section('pos')
<div class="container mt-4">
    <h3>MANNUAL SALE INVOICE</h3>
<hr>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Sale ID</th>
                <th>Item Name</th>
                <th>Sale Amount</th>
                <th>Tax Amount</th>
                <th>Total</th>
                <th>Payment</th>
                <th>Created By</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($externalSales as $sale)
                <tr>
                    <td>{{ $sale->saleE_id }}</td>
                    <td>{{ $sale->purchase->item_name ?? '-' }}</td>
                    <td>{{ number_format($sale->sale_amount, 2) }}</td>
                    <td>{{ number_format($sale->tax_amount, 2) }}</td>
                    <td>{{ number_format($sale->total_amount, 2) }}</td>
                    <td>{{ ucfirst($sale->payment_method) }}</td>
                    <td>{{ $sale->created_by }}</td>
                    <td>
                        <a href="{{ route('external-sales.invoice', $sale->id) }}" class="btn btn-sm btn-primary" target="_blank"><i class="bi bi-printer"></i> Print</a>
                        {{-- Uncomment if delete is needed --}}
                        {{-- 
                        <form action="{{ route('external-sales.destroy', $sale->id) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Are you sure?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">Delete</button>
                        </form>
                        --}}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $externalSales->links('vendor.pagination.bootstrap-5') }}
</div>
@endsection
