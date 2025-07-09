@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <h2>Add New Expense</h2>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('expenses.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="purpose" class="form-label">Purpose</label>
                <input type="text" name="purpose" id="purpose" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="details" class="form-label">Details</label>
                <textarea name="details" id="details" class="form-control"></textarea>
            </div>

            <div class="mb-3">
                <label for="amount" class="form-label">Amount</label>
                <input type="number" name="amount" id="amount" class="form-control" required step="0.01">
            </div>

            <div class="mb-3">
                <label for="paidBy" class="form-label">Paid By</label>
                <input type="text" name="paidBy" id="paidBy" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="paymentWay" class="form-label">Payment Method</label>
                <select name="paymentWay" id="paymentWay" class="form-select" required>
                    <option value="cash">Cash</option>
                    <option value="card">Card</option>
                    <option value="online">Online</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Add Expense</button>
            <a href="{{ route('expenses.index') }}" class="btn btn-secondary ms-2">Back</a>
        </form>
    </div>
@endsection
