@extends('layouts.pos')

@section('pos')
<div class="container py-4">
    <div class="card shadow-sm">
        <div class="card-header bg-warning text-dark">
            <h4 class="mb-0">Return/Exchange for Sale #{{ $sale->sale_code }}</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('sales.processReturn', $sale->id) }}" method="POST">
                @csrf
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Item</th>
                            <th>Sold Qty</th>
                            <th>Return Qty</th>
                            <th>Reason</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($sale->inventorySales as $detail)
                        <tr>
                            <td>{{ $detail->item->item_name }}</td>
                            <td>{{ $detail->quantity }}</td>
                            <td>
                                <input type="number" name="returns[{{ $detail->id }}][quantity]" class="form-control" min="0" max="{{ $detail->quantity }}" value="0">
                                <input type="hidden" name="returns[{{ $detail->id }}][item_id]" value="{{ $detail->item->id }}">
                                <input type="hidden" name="returns[{{ $detail->id }}][amount]" value="{{ $detail->amount }}">
                            </td>
                            <td>
                                <input type="text" name="returns[{{ $detail->id }}][reason]" class="form-control" placeholder="Optional">
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <button type="submit" class="btn btn-warning">Process Return</button>
                <a href="{{ route('sales.index') }}" class="btn btn-secondary ms-2">Cancel</a>
            </form>
        </div>
    </div>
</div>
@endsection 