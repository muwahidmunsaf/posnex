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
                <div id="items-labels" class="row mb-1" style="display:none;">
                    <div class="col-md-5"><label class="form-label">Product</label></div>
                    <div class="col-md-2"><label class="form-label">Quantity</label></div>
                    <div class="col-md-3"><label class="form-label">Purchase Amount</label></div>
                    <div class="col-md-2"></div>
                </div>
                <div id="items-container">
                    @foreach ($purchase->items as $index => $item)
                        <div class="purchase-item row mb-3 align-items-end">
                            <div class="col-md-5">
                                <input type="hidden" name="items[{{ $index }}][inventory_id]" value="{{ $item->inventory_id }}">
                                <input type="text" class="form-control" value="{{ $item->inventory->item_name ?? '-' }}" readonly>
                            </div>
                            <div class="col-md-2">
                                <input type="number" name="items[{{ $index }}][quantity]" min="1" class="form-control" value="{{ $item->quantity }}" required>
                            </div>
                            <div class="col-md-3">
                                <input type="number" name="items[{{ $index }}][purchase_amount]" min="0" step="0.01" class="form-control" value="{{ $item->purchase_amount }}" required>
                            </div>
                            <div class="col-md-2">
                                <button type="button" class="btn btn-danger btn-sm remove-item" title="Remove Item" style="margin-top: 30px;">&times;</button>
                            </div>
                        </div>
                    @endforeach
                </div>

                <button type="button" id="add-item" class="btn btn-outline-secondary mb-4" data-bs-toggle="modal" data-bs-target="#productModal">+ Add Item</button>

<div class="modal fade" id="productModal" tabindex="-1" aria-labelledby="productModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="productModalLabel">Select Product</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <input type="text" id="product-search" class="form-control mb-3" placeholder="Search products...">
        <div style="max-height:350px; overflow-y:auto;">
          <table class="table table-bordered table-hover mb-0">
            <thead>
              <tr>
                <th>Item Name</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody id="product-list">
              @foreach ($inventories as $inventory)
                <tr data-id="{{ $inventory->id }}" data-name="{{ strtolower($inventory->item_name) }}">
                  <td>{{ $inventory->item_name }}</td>
                  <td><button type="button" class="btn btn-sm btn-primary select-product" data-id="{{ $inventory->id }}" data-name="{{ $inventory->item_name }}">Select</button></td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

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
const addedProductIds = new Set([
    @foreach ($purchase->items as $item)
        '{{ $item->inventory_id }}',
    @endforeach
]);
const itemsLabels = document.getElementById('items-labels');

const productSearch = document.getElementById('product-search');
const productList = document.getElementById('product-list');

function updateLabelsVisibility() {
  const container = document.getElementById('items-container');
  itemsLabels.style.display = container.children.length > 0 ? '' : 'none';
}

productSearch.addEventListener('input', function() {
  const val = this.value.toLowerCase();
  productList.querySelectorAll('tr').forEach(row => {
    row.style.display = row.dataset.name.includes(val) ? '' : 'none';
  });
});

productList.addEventListener('click', function(e) {
  if (e.target.classList.contains('select-product')) {
    const id = e.target.dataset.id;
    const name = e.target.dataset.name;
    if (addedProductIds.has(id)) return;
    addPurchaseItem(id, name);
    addedProductIds.add(id);
    updateProductButtons();
    const modal = bootstrap.Modal.getInstance(document.getElementById('productModal'));
    modal.hide();
  }
});

function addPurchaseItem(id, name) {
  const container = document.getElementById('items-container');
  const newItem = document.createElement('div');
  newItem.classList.add('purchase-item', 'row', 'mb-3', 'align-items-end');
  newItem.innerHTML = `
    <div class="col-md-5">
      <input type="hidden" name="items[${itemIndex}][inventory_id]" value="${id}">
      <input type="text" class="form-control" value="${name}" readonly>
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
  updateLabelsVisibility();
  newItem.querySelector('.remove-item').addEventListener('click', function () {
    newItem.remove();
    addedProductIds.delete(id);
    updateProductButtons();
    updateLabelsVisibility();
  });
}

function updateProductButtons() {
  productList.querySelectorAll('tr').forEach(row => {
    const id = row.dataset.id;
    const btn = row.querySelector('.select-product');
    if (addedProductIds.has(id)) {
      btn.disabled = true;
      btn.textContent = 'Added';
    } else {
      btn.disabled = false;
      btn.textContent = 'Select';
    }
  });
}

document.querySelectorAll('.remove-item').forEach(button => {
    button.addEventListener('click', function () {
        this.closest('.purchase-item').remove();
        // Remove from addedProductIds and update buttons/labels
        const hiddenInput = this.closest('.purchase-item').querySelector('input[type=hidden]');
        if (hiddenInput) {
            addedProductIds.delete(hiddenInput.value);
            updateProductButtons();
            updateLabelsVisibility();
        }
    });
});

document.addEventListener('DOMContentLoaded', updateLabelsVisibility);
</script>
@endpush
@endsection
