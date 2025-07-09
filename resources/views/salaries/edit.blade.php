@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h3>Edit Salary Payment</h3>
    <form action="{{ route('salaries.update', $salary->id) }}" method="POST" class="mt-4" style="max-width: 500px;">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="employee_id" class="form-label">Employee</label>
            <select name="employee_id" id="employee_id" class="form-control" required>
                <option value="">Select Employee</option>
                @foreach($employees as $employee)
                    <option value="{{ $employee->id }}" {{ old('employee_id', $salary->employee_id) == $employee->id ? 'selected' : '' }}>{{ $employee->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="amount" class="form-label">Amount</label>
            <input type="number" name="amount" id="amount" class="form-control" min="0" step="0.01" required value="{{ old('amount', $salary->amount) }}">
        </div>
        <div class="mb-3">
            <label for="date" class="form-label">Payment Date</label>
            <input type="date" name="date" id="date" class="form-control" required value="{{ old('date', $salary->date) }}">
        </div>
        <button type="submit" class="btn btn-primary">Update Payment</button>
        <a href="{{ route('salaries.index') }}" class="btn btn-secondary ms-2">Cancel</a>
    </form>
</div>
@endsection 