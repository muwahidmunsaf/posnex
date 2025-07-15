@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Distributor Payments</h1>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Distributor</th>
                <th>Amount</th>
                <th>Type</th>
                <th>Status</th>
                <th>Payment Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach($payments as $payment)
                <tr>
                    <td>{{ $payment->id }}</td>
                    <td>{{ $payment->distributor->name ?? '' }}</td>
                    <td>{{ $payment->amount }}</td>
                    <td>{{ $payment->type }}</td>
                    <td>{{ $payment->status }}</td>
                    <td>{{ $payment->payment_date }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $payments->links() }}
</div>
@endsection 