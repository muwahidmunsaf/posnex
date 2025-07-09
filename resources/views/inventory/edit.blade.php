@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Edit Inventory Item</h3>
    <form method="POST" action="{{ route('inventory.update', $inventory->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="row">
            <div class="col-md-6 mb-3">
                <label>Item Name</label>
                <input type="text" name="item_name" value="{{ old('item_name', $inventory->item_name) }}" class="form-control" required>
            </div>

            <div class="col-md-3 mb-3">
                <label>Retail Price</label>
                <input type="number" name="retail_amount" step="0.01" value="{{ old('retail_amount', $inventory->retail_amount) }}" class="form-control" required>
            </div>

            <div class="col-md-3 mb-3">
                <label>Wholesale Price</label>
                <input type="number" name="wholesale_amount" step="0.01" value="{{ old('wholesale_amount', $inventory->wholesale_amount) }}" class="form-control">
            </div>

            <div class="col-md-4 mb-3">
                <label>Unit</label>
                <input type="text" name="unit" value="{{ old('unit', $inventory->unit) }}" class="form-control" required>
            </div>

            <div class="col-md-4 mb-3">
                <label>Barcode</label>
                <input type="text" name="barcode" value="{{ old('barcode', $inventory->barcode) }}" class="form-control">
            </div>

            <div class="col-md-4 mb-3">
                <label>SKU</label>
                <input type="text" name="sku" value="{{ old('sku', $inventory->sku) }}" class="form-control">
            </div>

            <div class="col-md-6 mb-3">
                <label>Category</label>
                <select name="category_id" class="form-select" required>
                    <option value="">Select Category</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ $inventory->category_id == $cat->id ? 'selected' : '' }}>
                            {{ $cat->category_name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-6 mb-3">
                <label>Supplier</label>
                <select name="supplier_id" class="form-select" required>
                    <option value="">Select Supplier</option>
                    @foreach($suppliers as $sup)
                        <option value="{{ $sup->id }}" {{ $inventory->supplier_id == $sup->id ? 'selected' : '' }}>
                            {{ $sup->supplier_name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-12 mb-3">
                <label>Details</label>
                <textarea name="details" class="form-control" rows="3" required>{{ old('details', $inventory->details) }}</textarea>
            </div>

            <div class="col-12 mb-3">
                <label>Status</label>
                <select name="status" class="form-select" required>
                    <option value="active" {{ $inventory->status == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ $inventory->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>

            <div class="col-md-6 mb-3">
                <label>Item Image (optional)</label>
                <input type="file" name="image" class="form-control">
                @if($inventory->image)
                    <div class="mt-2">
                        <img src="{{ asset('storage/' . $inventory->image) }}" alt="Item Image" width="120">
                    </div>
                @endif
            </div>

            <div class="col-12">
                <button class="btn btn-primary">Update Item</button>
            </div>
        </div>
    </form>
</div>
@endsection
