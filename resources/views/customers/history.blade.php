@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h3>Customer History: {{ $customer->name }}</h3>
    <div class="mb-3">
        <strong>Type:</strong> {{ ucfirst($customer->type) }}<br>
        <strong>Cell No:</strong> {{ $customer->cel_no }}<br>
        <strong>Email:</strong> {{ $customer->email }}<br>
        <strong>Address:</strong> {{ $customer->address }}<br>
        <strong>Outstanding:</strong> {{ number_format($outstanding, 2) }}
    </div>
    <h5>Sales</h5>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Sale Code</th>
                <th>Date</th>
                <th>Total</th>
                <th>Returned</th>
                <th>Outstanding</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($sales as $sale)
            <tr>
                <td>{{ $sale->sale_code }}</td>
                <td>{{ $sale->created_at->format('d-m-Y h:i A') }}</td>
                <td>{{ number_format($sale->total_amount, 2) }}</td>
                <td>{{ number_format($sale->total_returned, 2) }}</td>
                <td>{{ number_format($sale->outstanding, 2) }}</td>
                <td>
                    <a href="{{ route('sales.print', $sale->id) }}" class="btn btn-sm btn-primary" target="_blank">Print</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <h5>Payments & Returns Timeline</h5>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Date</th>
                <th>Description</th>
                <th>Amount</th>
                <th>Running Balance</th>
            </tr>
        </thead>
        <tbody>
            @foreach($events as $event)
            <tr>
                <td>{{ $event['date']->format('d-m-Y h:i A') }}</td>
                <td>{{ $event['desc'] }}</td>
                <td>{{ number_format($event['amount'], 2) }}</td>
                <td>{{ number_format($event['balance'], 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection 