@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h3>Returns & Exchanges History</h3>
    <form method="GET" class="row g-3 mb-3">
        <div class="col-md-2">
            <input type="date" name="date" class="form-control" value="{{ request('date') }}" placeholder="Date">
        </div>
        <div class="col-md-2">
            <input type="text" name="customer" class="form-control" value="{{ request('customer') }}" placeholder="Customer">
        </div>
        <div class="col-md-2">
            <input type="text" name="item" class="form-control" value="{{ request('item') }}" placeholder="Item">
        </div>
        <div class="col-md-2">
            <input type="text" name="processed_by" class="form-control" value="{{ request('processed_by') }}" placeholder="Processed By">
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-primary">Filter</button>
            <a href="{{ route('returns.index') }}" class="btn btn-secondary ms-2">Reset</a>
        </div>
    </form>
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>Date</th>
                    <th>Sale Code</th>
                    <th>Customer</th>
                    <th>Item</th>
                    <th>Qty</th>
                    <th>Amount</th>
                    <th>Reason</th>
                    <th>Processed By</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($returns as $ret)
                <tr>
                    <td>{{ $ret->created_at->format('d-m-Y H:i') }}</td>
                    <td>
                        @if($ret->sale)
                        <a href="{{ route('sales.print', $ret->sale_id) }}" target="_blank">{{ $ret->sale->sale_code }}</a>
                        @endif
                    </td>
                    <td>
                        @if($ret->sale && $ret->sale->customer)
                        <a href="{{ route('customers.history', $ret->sale->customer->id) }}">{{ $ret->sale->customer->name }}</a>
                        @else
                        -
                        @endif
                    </td>
                    <td>{{ $ret->item->item_name ?? '-' }}</td>
                    <td>{{ $ret->quantity }}</td>
                    <td>{{ number_format($ret->amount, 2) }}</td>
                    <td>{{ $ret->reason }}</td>
                    <td>{{ $ret->processed_by }}</td>
                    <td>
                        @if($ret->sale)
                        <a href="{{ route('sales.print', $ret->sale_id) }}" class="btn btn-sm btn-primary" target="_blank">Sale</a>
                        @endif
                        @if($ret->sale && $ret->sale->customer)
                        <a href="{{ route('customers.history', $ret->sale->customer->id) }}" class="btn btn-sm btn-info ms-1">Customer</a>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        {{ $returns->links('vendor.pagination.bootstrap-5') }}
    </div>
</div>
@endsection 