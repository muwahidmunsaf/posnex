@extends('layouts.app')
@section('content')
<div class="container">
    <h2 class="mb-4">Shopkeeper Transactions</h2>
    <div class="mb-3">
        <form method="GET" class="row g-2 align-items-end">
            <div class="col-auto">
                <label for="shopkeeper_id" class="form-label">Filter by Shopkeeper</label>
                <select name="shopkeeper_id" id="shopkeeper_id" class="form-select">
                    <option value="">All Shopkeepers</option>
                    @foreach($shopkeepers as $shopkeeper)
                        <option value="{{ $shopkeeper->id }}" {{ $shopkeeper_id == $shopkeeper->id ? 'selected' : '' }}>{{ $shopkeeper->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-auto">
                <label for="type" class="form-label">Transaction Type</label>
                <select name="type" id="type" class="form-select">
                    <option value="">All Types</option>
                    <option value="product_received" {{ $type == 'product_received' ? 'selected' : '' }}>Product Received</option>
                    <option value="product_sold" {{ $type == 'product_sold' ? 'selected' : '' }}>Product Sold</option>
                    <option value="product_returned" {{ $type == 'product_returned' ? 'selected' : '' }}>Product Returned</option>
                    <option value="payment_made" {{ $type == 'payment_made' ? 'selected' : '' }}>Payment Made</option>
                </select>
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-danger">Filter</button>
            </div>
            <div class="col-auto ms-auto">
                <a href="{{ route('shopkeeper-transactions.create', ['shopkeeper_id' => $shopkeeper_id]) }}" class="btn btn-success">Add Transaction</a>
            </div>
        </form>
    </div>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Shopkeeper</th>
                            <th>Distributor</th>
                            <th>Type</th>
                            <th>Product</th>
                            <th>Quantity</th>
                            <th>Unit Price</th>
                            <th>Total Amount</th>
                            <th>Commission</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transactions as $transaction)
                        <tr>
                            <td>{{ $transaction->transaction_date->format('Y-m-d') }}</td>
                            <td>{{ $transaction->shopkeeper->name }}</td>
                            <td>{{ $transaction->distributor->name }}</td>
                            <td>
                                @switch($transaction->type)
                                    @case('product_received')
                                        <span class="badge bg-primary">Received</span>
                                        @break
                                    @case('product_sold')
                                        <span class="badge bg-success">Sold</span>
                                        @break
                                    @case('product_returned')
                                        <span class="badge bg-warning">Returned</span>
                                        @break
                                    @case('payment_made')
                                        <span class="badge bg-info">Payment</span>
                                        @break
                                @endswitch
                            </td>
                            <td>{{ $transaction->inventory->name ?? 'N/A' }}</td>
                            <td>{{ $transaction->quantity }}</td>
                            <td>{{ number_format($transaction->unit_price, 2) }}</td>
                            <td>{{ number_format($transaction->total_amount, 2) }}</td>
                            <td>{{ number_format($transaction->commission_amount, 2) }}</td>
                            <td>{{ ucfirst($transaction->status) }}</td>
                            <td>
                                <a href="{{ route('shopkeeper-transactions.edit', $transaction) }}" class="btn btn-sm btn-warning">Edit</a>
                                <form action="{{ route('shopkeeper-transactions.destroy', $transaction) }}" method="POST" style="display:inline-block;">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete this transaction?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="11" class="text-center">No transactions found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                {{ $transactions->withQueryString()->links() }}
            </div>
        </div>
    </div>
</div>
@endsection 