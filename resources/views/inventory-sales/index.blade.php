@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Inventory Sales</h1>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Sale ID</th>
                <th>Item ID</th>
                <th>Quantity</th>
                <th>Amount</th>
                <th>Total Amount</th>
                <th>Sale Type</th>
            </tr>
        </thead>
        <tbody>
            @foreach($inventorySales as $invSale)
                <tr>
                    <td>{{ $invSale->id }}</td>
                    <td>{{ $invSale->sale_id }}</td>
                    <td>{{ $invSale->item_id }}</td>
                    <td>{{ $invSale->quantity }}</td>
                    <td>{{ $invSale->amount }}</td>
                    <td>{{ $invSale->total_amount }}</td>
                    <td>{{ $invSale->sale_type }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $inventorySales->links() }}
</div>
@endsection 