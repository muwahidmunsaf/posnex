@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <div class="d-flex justify-content-between mb-3">
            <h3>EXPENSE RECORDS</h3>
            <a href="{{ route('expenses.create') }}" class="btn btn-success d-block" style="max-width: 200px;">
                <i class="bi bi-plus-circle me-1"></i> Add Expense
            </a>
        </div>
        <hr>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Purpose</th>
                    <th>Details</th>
                    <th>Amount</th>
                    <th>Paid By</th>
                    <th>Payment Method</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                @forelse($expenses as $expense)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $expense->purpose }}</td>
                        <td>{{ $expense->details }}</td>
                        <td>{{ number_format($expense->amount, 2) }}</td>
                        <td>{{ $expense->paidBy }}</td>
                        <td>{{ ucfirst($expense->paymentWay) }}</td>
                        <td>{{ $expense->created_at->format('d M Y') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">No expenses found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
