@extends('layouts.app')
@section('content')
<div class="container">
    <h2 class="mb-4">Edit Product Assignment</h2>
    <div class="card">
        <div class="card-body">
            <form action="{{ route('distributor-products.update', $distributorProduct) }}" method="POST">
                @csrf @method('PUT')
                <div class="mb-3">
                    <label for="distributor_id" class="form-label">Distributor</label>
                    <select name="distributor_id" id="distributor_id" class="form-select" required>
                        <option value="">Select Distributor</option>
                        @foreach($distributors as $distributor)
                            <option value="{{ $distributor->id }}" {{ $distributorProduct->distributor_id == $distributor->id ? 'selected' : '' }}>{{ $distributor->name }}</option>
                        @endforeach
                    </select>
                    @error('distributor_id')<div class="text-danger">{{ $message }}</div>@enderror
                </div>
                <div class="mb-3">
                    <label for="inventory_id" class="form-label">Product</label>
                    <select name="inventory_id" id="inventory_id" class="form-select" required>
                        <option value="">Select Product</option>
                        @foreach($products as $product)
                            <option value="{{ $product->id }}" {{ $distributorProduct->inventory_id == $product->id ? 'selected' : '' }}>{{ $product->name }}</option>
                        @endforeach
                    </select>
                    @error('inventory_id')<div class="text-danger">{{ $message }}</div>@enderror
                </div>
                <div class="mb-3">
                    <label for="quantity_assigned" class="form-label">Quantity Assigned</label>
                    <input type="number" name="quantity_assigned" id="quantity_assigned" class="form-control" value="{{ $distributorProduct->quantity_assigned }}" required>
                    @error('quantity_assigned')<div class="text-danger">{{ $message }}</div>@enderror
                </div>
                <div class="mb-3">
                    <label for="quantity_remaining" class="form-label">Quantity Remaining</label>
                    <input type="number" name="quantity_remaining" id="quantity_remaining" class="form-control" value="{{ $distributorProduct->quantity_remaining }}" required>
                    @error('quantity_remaining')<div class="text-danger">{{ $message }}</div>@enderror
                </div>
                <div class="mb-3">
                    <label for="unit_price" class="form-label">Unit Price</label>
                    <input type="number" step="0.01" name="unit_price" id="unit_price" class="form-control" value="{{ $distributorProduct->unit_price }}" required>
                    @error('unit_price')<div class="text-danger">{{ $message }}</div>@enderror
                </div>
                <div class="mb-3">
                    <label for="assignment_date" class="form-label">Assignment Date</label>
                    <input type="date" name="assignment_date" id="assignment_date" class="form-control" value="{{ $distributorProduct->assignment_date->format('Y-m-d') }}" required>
                    @error('assignment_date')<div class="text-danger">{{ $message }}</div>@enderror
                </div>
                <div class="mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select name="status" id="status" class="form-select" required>
                        <option value="active" {{ $distributorProduct->status == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="completed" {{ $distributorProduct->status == 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="cancelled" {{ $distributorProduct->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                    @error('status')<div class="text-danger">{{ $message }}</div>@enderror
                </div>
                <div class="mb-3">
                    <label for="notes" class="form-label">Notes</label>
                    <textarea name="notes" id="notes" class="form-control" rows="2">{{ $distributorProduct->notes }}</textarea>
                    @error('notes')<div class="text-danger">{{ $message }}</div>@enderror
                </div>
                <button type="submit" class="btn btn-danger">Update Assignment</button>
                <a href="{{ route('distributor-products.index', ['distributor_id' => $distributorProduct->distributor_id]) }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</div>
@endsection 