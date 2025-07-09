@extends('layouts.app')

@section('content')
<div class="container">
    <h3 class="mb-4">Create Purchase</h3>

    <form action="{{ route('purchase.store') }}" method="POST">
        @csrf

        <div class="mb-3 row">
            <label for="purchase_date" class="col-sm-2 col-form-label">Purchase Date</label>
            <div class="col-sm-4">
                <input type="date" id="purchase_date" name="purchase_date" class="form-control" value="{{ old('purchase_date', date('Y-m-d')) }}" required>
            </div>
        </div>

        <div class="mb-3 row">
            <label for="supplier_id" class="col-sm-2 col-form-label">Supplier</label>
            <div class="col-sm-6">
                <select name="supplier_id" id="supplier_id" class="form-select" required>
                    <option value="">Select Supplier</option>
                    @foreach ($suppliers as $supplier)
                        <option value="{{ $supplier->id }}" {{ old('supplier_id') == $supplier->id ? 'selected' : '' }}>
                            {{ $supplier->supplier_name }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <hr>

        <h5 class="mb-3">Purchase Items</h5>

        <div id="items-container">
            <div class="purchase-item row mb-3 align-items-end">
                <div class="col-md-5">
                    <label class="form-label">Inventory</label>
                    <select name="items[0][inventory_id]" class="form-select" required>
                        <option value="">Select Item</option>
                        @foreach ($inventories as $inventory)
                            <option value="{{ $inventory->id }}">{{ $inventory->item_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Quantity</label>
                    <input type="number" name="items[0][quantity]" min="1" class="form-control" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Purchase Amount</label>
                    <input type="number" name="items[0][purchase_amount]" min="0" step="0.01" class="form-control" required>
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-danger btn-sm remove-item" title="Remove Item" style="margin-top: 30px;">&times;</button>
                </div>
            </div>
        </div>

        <button type="button" id="add-item" class="btn btn-outline-secondary mb-4">+ Add Item</button>

        <div>
            <button type="submit" class="btn btn-primary">Save Purchase</button>
            <a href="{{ route('purchase.index') }}" class="btn btn-secondary ms-2">Cancel</a>
        </div>
    </form>
</div>

@push('scripts')
<script>
    let itemIndex = 1;

    document.getElementById('add-item').addEventListener('click', function () {
        const container = document.getElementById('items-container');

        const newItem = document.createElement('div');
        newItem.classList.add('purchase-item', 'row', 'mb-3', 'align-items-end');
        newItem.innerHTML = `
            <div class="col-md-5">
                <select name="items[${itemIndex}][inventory_id]" class="form-select" required>
                    <option value="">Select Item</option>
                    @foreach ($inventories as $inventory)
                        <option value="{{ $inventory->id }}">{{ $inventory->item_name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <input type="number" name="items[${itemIndex}][quantity]" min="1" class="form-control" required>
            </div>
            <div class="col-md-3">
                <input type="number" name="items[${itemIndex}][purchase_amount]" min="0" step="0.01" class="form-control" required>
            </div>
            <div class="col-md-2">
                <button type="button" class="btn btn-danger btn-sm remove-item" title="Remove Item" style="margin-top: 30px;">&times;</button>
            </div>
        `;
        container.appendChild(newItem);
        itemIndex++;

        newItem.querySelector('.remove-item').addEventListener('click', function () {
            newItem.remove();
        });
    });

    document.querySelectorAll('.remove-item').forEach(button => {
        button.addEventListener('click', function () {
            this.closest('.purchase-item').remove();
        });
    });
</script>
@endpush
@endsection
