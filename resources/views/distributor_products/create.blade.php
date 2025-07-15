@extends('layouts.app')
@section('content')
<div class="container">
    <h2 class="mb-4">Assign Products to Distributor</h2>
    <div class="card">
        <div class="card-body">
            <form action="{{ route('distributor-products.store') }}" method="POST" id="assignmentForm">
                @csrf
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="distributor_id" class="form-label">Distributor</label>
                        <select name="distributor_id" id="distributor_id" class="form-select" required>
                            <option value="">Select Distributor</option>
                            @foreach($distributors as $distributor)
                                <option value="{{ $distributor->id }}" {{ $distributor_id == $distributor->id ? 'selected' : '' }}>{{ $distributor->name }}</option>
                            @endforeach
                        </select>
                        @error('distributor_id')<div class="text-danger">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label for="assignment_date" class="form-label">Assignment Date</label>
                        <input type="date" name="assignment_date" id="assignment_date" class="form-control" value="{{ date('Y-m-d') }}" required>
                        @error('assignment_date')<div class="text-danger">{{ $message }}</div>@enderror
                    </div>
                </div>

                <!-- Products Section -->
                <div class="card mb-3">
                    <div class="card-header">
                        <h6 class="mb-0">Products</h6>
                    </div>
                    <div class="card-body">
                        <div id="productsContainer">
                            <!-- Product rows will be added here -->
                        </div>
                        <button type="button" class="btn btn-success btn-sm" onclick="addProductRow()">
                            <i class="bi bi-plus"></i> Add Product
                        </button>
                    </div>
                </div>

                <!-- Summary -->
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
                                <strong>Assignment #: </strong><span id="assignmentNumber">{{ 'ASG-' . date('Ymd') . '-' . str_pad(rand(1, 999), 3, '0', STR_PAD_LEFT) }}</span>
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
                    <textarea name="notes" id="notes" class="form-control" rows="2"></textarea>
                    @error('notes')<div class="text-danger">{{ $message }}</div>@enderror
                </div>

                <button type="submit" class="btn btn-danger">Complete Assignment</button>
                <a href="{{ route('distributor-products.index', ['distributor_id' => $distributor_id]) }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</div>

<!-- Hidden template for product rows -->
<template id="productRowTemplate">
    <div class="product-row border rounded p-3 mb-2">
        <div class="row">
            <div class="col-md-4">
                <label class="form-label">Product</label>
                <select name="products[INDEX][inventory_id]" class="form-select product-select" required>
                    <option value="">Select Product</option>
                    @foreach($products as $product)
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
let productIndex = 0;

function addProductRow() {
    const container = document.getElementById('productsContainer');
    const template = document.getElementById('productRowTemplate');
    const clone = template.content.cloneNode(true);
    
    // Replace INDEX with actual index
    clone.querySelectorAll('[name*="INDEX"]').forEach(element => {
        element.name = element.name.replace('INDEX', productIndex);
    });
    
    // Add event listeners
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

// Add first product row on page load
document.addEventListener('DOMContentLoaded', function() {
    addProductRow();
});
</script>
@endsection 