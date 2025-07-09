@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <h3>Edit Purchase</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('purchase.update', $purchase->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="supplier_id" class="form-label">Supplier</label>
                        <select name="supplier_id" id="supplier_id" class="form-select" required>
                            <option value="">Select Supplier</option>
                            @foreach ($suppliers as $supplier)
                                <option value="{{ $supplier->id }}" {{ $purchase->supplier_id == $supplier->id ? 'selected' : '' }}>
                                    {{ $supplier->supplier_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label for="purchase_date" class="form-label">Purchase Date</label>
                        <input type="text" id="purchase_date" name="purchase_date"
                            class="form-control" value="{{ $purchase->purchase_date }}" readonly>
                    </div>
                </div>

                <hr>
                <h5>Purchase Items</h5>
                <div id="items-container">
                    @foreach ($purchase->items as $index => $item)
                        <div class="purchase-item row mb-3">
                            <div class="col-md-5">
                                <select name="items[{{ $index }}][inventory_id]" class="form-select" required>
                                    <option value="">Select Item</option>
                                    @foreach ($inventories as $inventory)
                                        <option value="{{ $inventory->id }}"
                                            {{ $item->inventory_id == $inventory->id ? 'selected' : '' }}>
                                            {{ $inventory->item_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <input type="number" name="items[{{ $index }}][quantity]" min="1"
                                    class="form-control" value="{{ $item->quantity }}" required>
                            </div>
                            <div class="col-md-3">
                                <input type="number" name="items[{{ $index }}][purchase_amount]" min="0" step="0.01"
                                    class="form-control" value="{{ $item->purchase_amount }}" required>
                            </div>
                            <div class="col-md-1 d-flex align-items-end">
                                <button type="button" class="btn btn-danger btn-sm remove-item">X</button>
                            </div>
                        </div>
                    @endforeach
                </div>

                <button type="button" id="add-item" class="btn btn-secondary mb-3">Add Item</button>

                <div class="text-end">
                    <a href="{{ route('purchase.index')}}" type="" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary">Update Purchase</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    let itemIndex = {{ $purchase->items->count() }};

    document.getElementById('add-item').addEventListener('click', function () {
        const container = document.getElementById('items-container');

        const newItem = document.createElement('div');
        newItem.classList.add('purchase-item', 'row', 'mb-3');
        newItem.innerHTML = `
            <div class="col-md-5">
                <select name="items[${itemIndex}][inventory_id]" class="form-select" required>
                    <option value="">Select Item</option>
                    @foreach ($inventories as $inventory)
                        <option value="{{ $inventory->id }}">{{ $inventory->item_name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <input type="number" name="items[${itemIndex}][quantity]" min="1" class="form-control" required>
            </div>
            <div class="col-md-3">
                <input type="number" name="items[${itemIndex}][purchase_amount]" min="0" step="0.01" class="form-control" required>
            </div>
            <div class="col-md-1 d-flex align-items-end">
                <button type="button" class="btn btn-danger btn-sm remove-item">X</button>
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
