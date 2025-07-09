@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h3>Salary Payments</h3>
    <form method="GET" class="row g-3 align-items-end mb-3">
        <div class="col-auto">
            <label for="month" class="form-label mb-0">Month</label>
            <input type="month" name="month" id="month" class="form-control" value="{{ $selectedMonth ?? '' }}">
        </div>
        <div class="col-auto">
            <label for="search" class="form-label mb-0">Search Employee</label>
            <input type="text" name="search" id="search" class="form-control" placeholder="Employee name" value="{{ $search ?? '' }}">
        </div>
        <div class="col-auto">
            <button type="submit" class="btn btn-primary">Filter</button>
            @if(request('month') || request('search'))
                <a href="{{ route('salaries.index') }}" class="btn btn-secondary ms-2">Clear</a>
            @endif
        </div>
    </form>
    <a href="{{ route('salaries.create') }}" class="btn btn-primary mb-3">Add Salary Payment</a>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Employee</th>
                <th>Amount</th>
                <th>Payment Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($salaries as $salary)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $salary->employee->name }}</td>
                    <td>{{ number_format($salary->amount, 2) }}</td>
                    <td>{{ $salary->date }}</td>
                    <td>
                        <a href="{{ route('salaries.edit', $salary->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('salaries.destroy', $salary->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection 