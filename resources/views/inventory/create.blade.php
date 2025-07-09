@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Add Inventory Item</h3>
    <form method="POST" action="{{ route('inventory.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-md-6 mb-3">
                <label>Item Name</label>
                <input type="text" name="item_name" class="form-control" required>
            </div>
            <div class="col-md-3 mb-3">
                <label>Retail Price</label>
                <input type="number" step="0.01" name="retail_amount" class="form-control" required>
            </div>
            <div class="col-md-3 mb-3">
                <label>Wholesale Price</label>
                <input type="number" step="0.01" name="wholesale_amount" class="form-control">
            </div>
            <div class="col-md-4 mb-3">
                <label>Unit</label>
                <input type="text" name="unit" class="form-control" required>
            </div>
            <div class="col-md-4 mb-3">
                <label>Barcode</label>
                <input type="text" name="barcode" class="form-control">
            </div>
            <div class="col-md-4 mb-3">
                <label>SKU</label>
                <input type="text" name="sku" class="form-control">
            </div>
            <div class="col-md-6 mb-3">
                <label>Category</label>
                <select name="category_id" class="form-select" required>
                    <option value="">Select Category</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->category_name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6 mb-3">
                <label>Supplier</label>
                <select name="supplier_id" class="form-select" required>
                    <option value="">Select Supplier</option>
                    @foreach($suppliers as $sup)
                        <option value="{{ $sup->id }}">{{ $sup->supplier_name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-12 mb-3">
                <label>Details</label>
                <textarea name="details" class="form-control" rows="3" required></textarea>
            </div>
            <div class="col-12 mb-3">
                <label>Status</label>
                <select name="status" class="form-select" required>
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                </select>
            </div>
            <div class="col-md-6 mb-3">
                <label>Item Image (optional)</label>
                <input type="file" name="image" class="form-control">
            </div>
        </div>
        <button class="btn btn-success">Add Item</button>
    </form>
</div>
@endsection
