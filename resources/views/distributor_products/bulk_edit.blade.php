@extends('layouts.app')
@section('content')
<div class="container">
    <h2 class="mb-4">Edit Assignment #{{ $assignment_number }}</h2>
    <div class="card">
        <div class="card-body">
            <form action="{{ route('distributor-products.bulk-update', ['assignment_number' => $assignment_number]) }}" method="POST" id="assignmentForm">
                @csrf
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="distributor_id" class="form-label">Distributor</label>
                        <select name="distributor_id" id="distributor_id" class="form-select" required disabled>
                            <option value="">Select Distributor</option>
                            @foreach(App\Models\Distributor::all() as $dist)
                                <option value="{{ $dist->id }}" {{ $distributor->id == $dist->id ? 'selected' : '' }}>{{ $dist->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="assignment_date" class="form-label">Assignment Date</label>
                        <input type="date" name="assignment_date" id="assignment_date" class="form-control" value="{{ $assignments->first()->assignment_date->format('Y-m-d') }}" required>
                    </div>
                </div>
                <div class="card mb-3">
                    <div class="card-header">
                        <h6 class="mb-0">Products</h6>
                    </div>
                    <div class="card-body">
                        <div id="productsContainer">
                            @foreach($assignments as $i => $assignment)
                            <div class="product-row border rounded p-3 mb-2">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label class="form-label">Product</label>
                                        <select name="products[{{ $i }}][inventory_id]" class="form-select product-select" required>
                                            <option value="">Select Product</option>
                                            @foreach(App\Models\Inventory::where('status', 'active')->get() as $product)
                                                <option value="{{ $product->id }}" data-price="{{ $product->wholesale_amount ?? $product->retail_amount ?? 0 }}" {{ $assignment->inventory_id == $product->id ? 'selected' : '' }}>{{ $product->item_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label">Quantity</label>
                                        <input type="number" name="products[{{ $i }}][quantity]" class="form-control quantity-input" min="1" value="{{ $assignment->quantity_assigned }}" required>
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label">Unit Price</label>
                                        <input type="number" step="0.01" name="products[{{ $i }}][unit_price]" class="form-control price-input" min="0" value="{{ $assignment->unit_price }}" required>
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label">Total</label>
                                        <input type="text" class="form-control row-total" value="Rs {{ number_format($assignment->quantity_assigned * $assignment->unit_price, 2) }}" readonly>
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label">&nbsp;</label>
                                        <button type="button" class="btn btn-danger btn-sm d-block" onclick="removeProductRow(this)">
                                            <i class="bi bi-trash"></i> Remove
                                        </button>
                                    </div>
                                    <input type="hidden" name="products[{{ $i }}][id]" value="{{ $assignment->id }}">
                                </div>
                            </div>
                            @endforeach
                        </div>
                        <button type="button" class="btn btn-success btn-sm" onclick="addProductRow()">
                            <i class="bi bi-plus"></i> Add Product
                        </button>
                    </div>
                </div>
                <div class="card mb-3">
                    <div class="card-header">
                        <h6 class="mb-0">Summary</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <strong>Total Items: </strong><span id="totalItems">0</span>
                            </div>
                            <div class="col-md-4">
                                <strong>Total Value: </strong><span id="totalValue">Rs 0.00</span>
                            </div>
                            <div class="col-md-4">
                                <strong>Assignment #: </strong><span id="assignmentNumber">{{ $assignment_number }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="vat_percent" class="form-label">VAT (%)</label>
                    <input type="number" step="0.01" name="vat_percent" id="vat_percent" class="form-control" value="15" min="0" max="100">
                </div>
                <div class="mb-3">
                    <label for="notes" class="form-label">Notes</label>
                    <textarea name="notes" id="notes" class="form-control" rows="2">{{ $assignments->first()->notes }}</textarea>
                </div>
                <button type="submit" class="btn btn-primary">Update Assignment</button>
                <a href="{{ route('distributor-products.index') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</div>
<template id="productRowTemplate">
    <div class="product-row border rounded p-3 mb-2">
        <div class="row">
            <div class="col-md-4">
                <label class="form-label">Product</label>
                <select name="products[INDEX][inventory_id]" class="form-select product-select" required>
                    <option value="">Select Product</option>
                    @foreach(App\Models\Inventory::where('status', 'active')->get() as $product)
                        <option value="{{ $product->id }}" data-price="{{ $product->wholesale_amount ?? $product->retail_amount ?? 0 }}">{{ $product->item_name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label">Quantity</label>
                <input type="number" name="products[INDEX][quantity]" class="form-control quantity-input" min="1" required>
            </div>
            <div class="col-md-2">
                <label class="form-label">Unit Price</label>
                <input type="number" step="0.01" name="products[INDEX][unit_price]" class="form-control price-input" min="0" required>
            </div>
            <div class="col-md-2">
                <label class="form-label">Total</label>
                <input type="text" class="form-control row-total" readonly>
            </div>
            <div class="col-md-2">
                <label class="form-label">&nbsp;</label>
                <button type="button" class="btn btn-danger btn-sm d-block" onclick="removeProductRow(this)">
                    <i class="bi bi-trash"></i> Remove
                </button>
            </div>
        </div>
    </div>
</template>
<script>
let productIndex = {{ $assignments->count() }};
function addProductRow() {
    const container = document.getElementById('productsContainer');
    const template = document.getElementById('productRowTemplate');
    const clone = template.content.cloneNode(true);
    clone.querySelectorAll('[name*="INDEX"]').forEach(element => {
        element.name = element.name.replace('INDEX', productIndex);
    });
    const productSelect = clone.querySelector('.product-select');
    const quantityInput = clone.querySelector('.quantity-input');
    const priceInput = clone.querySelector('.price-input');
    productSelect.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        const price = selectedOption.dataset.price || 0;
        priceInput.value = price;
        calculateRowTotal(this);
    });
    quantityInput.addEventListener('input', function() {
        calculateRowTotal(this);
    });
    priceInput.addEventListener('input', function() {
        calculateRowTotal(this);
    });
    container.appendChild(clone);
    productIndex++;
    updateSummary();
}
function removeProductRow(button) {
    button.closest('.product-row').remove();
    updateSummary();
}
function calculateRowTotal(element) {
    const row = element.closest('.product-row');
    const quantity = parseFloat(row.querySelector('.quantity-input').value) || 0;
    const price = parseFloat(row.querySelector('.price-input').value) || 0;
    const total = quantity * price;
    row.querySelector('.row-total').value = 'Rs ' + total.toFixed(2);
    updateSummary();
}
function updateSummary() {
    let totalItems = 0;
    let totalValue = 0;
    document.querySelectorAll('.product-row').forEach(row => {
        const quantity = parseFloat(row.querySelector('.quantity-input').value) || 0;
        const price = parseFloat(row.querySelector('.price-input').value) || 0;
        totalItems += quantity;
        totalValue += quantity * price;
    });
    document.getElementById('totalItems').textContent = totalItems;
    document.getElementById('totalValue').textContent = 'Rs ' + totalValue.toFixed(2);
}
document.addEventListener('DOMContentLoaded', function() {
    updateSummary();
});
</script>
@endsection 