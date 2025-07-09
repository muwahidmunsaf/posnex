@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h3>Salary Payment Details</h3>
    <div class="card mt-4" style="max-width: 500px;">
        <div class="card-body">
            <h5 class="card-title">{{ $salary->employee->name }}</h5>
            <p class="card-text"><strong>Amount:</strong> {{ number_format($salary->amount, 2) }}</p>
            <p class="card-text"><strong>Payment Date:</strong> {{ $salary->payment_date }}</p>
            <a href="{{ route('salaries.index') }}" class="btn btn-secondary mt-3">Back to List</a>
        </div>
    </div>
</div>
@endsection 