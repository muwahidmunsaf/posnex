@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h3>Employee Details</h3>
    <div class="card mt-4" style="max-width: 500px;">
        <div class="card-body">
            <h5 class="card-title">{{ $employee->name }}</h5>
            <p class="card-text"><strong>Position:</strong> {{ $employee->position }}</p>
            <p class="card-text"><strong>Salary:</strong> {{ number_format($employee->salary, 2) }}</p>
            <p class="card-text"><strong>Contact:</strong> {{ $employee->contact }}</p>
            <p class="card-text"><strong>Address:</strong> {{ $employee->address }}</p>
            <a href="{{ route('employees.index') }}" class="btn btn-secondary mt-3">Back to List</a>
        </div>
    </div>
</div>
@endsection 