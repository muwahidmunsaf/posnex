@extends('layouts.app')
@section('content')
<div class="container">
    <h2 class="mb-4">Add Shopkeeper Transaction</h2>
    <div class="card">
        <div class="card-body">
            <form action="{{ route('shopkeeper-transactions.store') }}" method="POST">
                @csrf
                @php
                    $isPayment = (request('type') === 'payment_made' || old('type') === 'payment_made');
                @endphp
                @if($isPayment)
                    <input type="hidden" name="shopkeeper_id" value="{{ $shopkeeper_id }}">
                    <input type="hidden" name="distributor_id" value="{{ $distributors->firstWhere('id', $shopkeepers->firstWhere('id', $shopkeeper_id)->distributor_id ?? null)->id ?? '' }}">
                    <input type="hidden" name="type" value="payment_made">
                    <div class="mb-3">
                        <label for="total_amount" class="form-label">Amount Received</label>
                        <input type="number" step="0.01" name="total_amount" id="total_amount" class="form-control" min="0" required>
                        @error('total_amount')<div class="text-danger">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label for="transaction_date" class="form-label">Date</label>
                        <input type="date" name="transaction_date" id="transaction_date" class="form-control" value="{{ date('Y-m-d') }}" required>
                        @error('transaction_date')<div class="text-danger">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Note</label>
                        <textarea name="description" id="description" class="form-control" rows="2"></textarea>
                        @error('description')<div class="text-danger">{{ $message }}</div>@enderror
                    </div>
                @else
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="shopkeeper_id" class="form-label">Shopkeeper</label>
                            <select name="shopkeeper_id" id="shopkeeper_id" class="form-select" required>
                                <option value="">Select Shopkeeper</option>
                                @foreach($shopkeepers as $shopkeeper)
                                    <option value="{{ $shopkeeper->id }}" {{ $shopkeeper_id == $shopkeeper->id ? 'selected' : '' }}>{{ $shopkeeper->name }}</option>
                                @endforeach
                            </select>
                            @error('shopkeeper_id')<div class="text-danger">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="distributor_id" class="form-label">Distributor</label>
                            <select name="distributor_id" id="distributor_id" class="form-select" required>
                                <option value="">Select Distributor</option>
                                @foreach($distributors as $distributor)
                                    <option value="{{ $distributor->id }}">{{ $distributor->name }}</option>
                                @endforeach
                            </select>
                            @error('distributor_id')<div class="text-danger">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="type" class="form-label">Transaction Type</label>
                            <select name="type" id="type" class="form-select" required>
                                <option value="">Select Type</option>
                                <option value="product_received">Product Received</option>
                                <option value="product_sold">Product Sold</option>
                                <option value="product_returned">Product Returned</option>
                                <option value="payment_made">Payment Made</option>
                            </select>
                            @error('type')<div class="text-danger">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="transaction_date" class="form-label">Transaction Date</label>
                            <input type="date" name="transaction_date" id="transaction_date" class="form-control" value="{{ date('Y-m-d') }}" required>
                            @error('transaction_date')<div class="text-danger">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="inventory_id" class="form-label">Product</label>
                            <select name="inventory_id" id="inventory_id" class="form-select">
                                <option value="">Select Product</option>
                                @foreach($products as $product)
                                    <option value="{{ $product->id }}">{{ $product->name }}</option>
                                @endforeach
                            </select>
                            @error('inventory_id')<div class="text-danger">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="quantity" class="form-label">Quantity</label>
                            <input type="number" name="quantity" id="quantity" class="form-control" min="1">
                            @error('quantity')<div class="text-danger">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="unit_price" class="form-label">Unit Price</label>
                            <input type="number" step="0.01" name="unit_price" id="unit_price" class="form-control" min="0">
                            @error('unit_price')<div class="text-danger">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="total_amount" class="form-label">Total Amount</label>
                            <input type="number" step="0.01" name="total_amount" id="total_amount" class="form-control" min="0">
                            @error('total_amount')<div class="text-danger">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="commission_amount" class="form-label">Commission Amount</label>
                    <input type="number" step="0.01" name="commission_amount" id="commission_amount" class="form-control" value="0" min="0">
                    @error('commission_amount')<div class="text-danger">{{ $message }}</div>@enderror
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea name="description" id="description" class="form-control" rows="2"></textarea>
                    @error('description')<div class="text-danger">{{ $message }}</div>@enderror
                </div>
                @endif
                <button type="submit" class="btn btn-danger">Add Transaction</button>
                <a href="{{ route('shopkeeper-transactions.index', ['shopkeeper_id' => $shopkeeper_id]) }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</div>
@endsection 