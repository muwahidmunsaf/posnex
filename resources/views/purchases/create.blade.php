@extends('layouts.app')

@section('content')
<div class="container">
    <h3 class="mb-4">Create Purchase</h3>

    <form action="{{ route('purchase.store') }}" method="POST">
        @csrf
        <input type="hidden" name="idempotency_token" value="{{ $token }}">

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
        <div class="mb-3 row" id="exchange-rate-row" style="display:none;">
            <label for="exchange_rate_to_pkr" class="col-sm-2 col-form-label">Exchange Rate to PKR</label>
            <div class="col-sm-4">
                <input type="number" step="0.00001" min="0" id="exchange_rate_to_pkr" name="exchange_rate_to_pkr" class="form-control">
                <small class="text-muted">Enter the rate at the time of purchase. 1 <span id="currency-code-label">CUR</span> = ? PKR</small>
            </div>
        </div>

        <hr>

        <h5 class="mb-3">Purchase Items</h5>

        <div id="items-labels" class="row mb-1" style="display:none;">
            <div class="col-md-5"><label class="form-label">Product</label></div>
            <div class="col-md-2"><label class="form-label">Quantity</label></div>
            <div class="col-md-3"><label class="form-label">Purchase Amount</label></div>
            <div class="col-md-2"></div>
        </div>
        <div id="items-container"></div>

        <button type="button" id="add-item" class="btn btn-outline-secondary mb-4" data-bs-toggle="modal" data-bs-target="#productModal">+ Add Item</button>

        <div>
            <button type="submit" class="btn btn-primary">Save Purchase</button>
            <a href="{{ route('purchase.index') }}" class="btn btn-secondary ms-2">Cancel</a>
        </div>
    </form>
</div>

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

@push('scripts')
<script>
let itemIndex = 0;
const addedProductIds = new Set();
const itemsLabels = document.getElementById('items-labels');

const productSearch = document.getElementById('product-search');
const productList = document.getElementById('product-list');

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

function updateLabelsVisibility() {
  const container = document.getElementById('items-container');
  itemsLabels.style.display = container.children.length > 0 ? '' : 'none';
}

// --- Supplier currency map ---
const supplierCurrencies = {
@foreach ($suppliers as $supplier)
    {{ $supplier->id }}: { symbol: @json($supplier->currency['symbol']), code: @json($supplier->currency['code']) },
@endforeach
};

function getSelectedSupplierCurrency() {
    const supplierId = document.getElementById('supplier_id').value;
    return supplierCurrencies[supplierId] || { symbol: '', code: '' };
}

// --- Modified addPurchaseItem to show currency ---
function addPurchaseItem(id, name) {
  const container = document.getElementById('items-container');
  const currency = getSelectedSupplierCurrency();
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
    <div class="col-md-3 d-flex align-items-center">
      <input type="number" name="items[${itemIndex}][purchase_amount]" min="0" step="0.01" class="form-control" required>
      <span class="currency-label ms-2" style="white-space:nowrap; font-weight:bold; color:#b71c1c;">${currency.symbol} (${currency.code})</span>
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

// --- Update all currency labels when supplier changes ---
document.getElementById('supplier_id').addEventListener('change', function() {
    const currency = getSelectedSupplierCurrency();
    document.querySelectorAll('.currency-label').forEach(function(span) {
        span.textContent = currency.symbol + ' (' + currency.code + ')';
    });
});

// --- Show/hide exchange rate field based on supplier currency and fetch rate ---
function updateExchangeRateField() {
    const supplierId = document.getElementById('supplier_id').value;
    const currency = supplierCurrencies[supplierId] || { symbol: '', code: '' };
    const row = document.getElementById('exchange-rate-row');
    const codeLabel = document.getElementById('currency-code-label');
    const rateInput = document.getElementById('exchange_rate_to_pkr');
    if (currency.code && currency.code !== 'PKR') {
        row.style.display = '';
        codeLabel.textContent = currency.code;
        rateInput.value = '';
        rateInput.placeholder = 'Fetching...';
        rateInput.disabled = true;
        // Fetch rate from backend
        fetch(`/api/exchange-rate/${currency.code}`)
            .then(res => res.json())
            .then(data => {
                if (data && data.rate) {
                    rateInput.value = data.rate;
                } else {
                    rateInput.value = '';
                }
                rateInput.placeholder = '';
                rateInput.disabled = false;
            })
            .catch(() => {
                rateInput.value = '';
                rateInput.placeholder = '';
                rateInput.disabled = false;
            });
    } else {
        row.style.display = 'none';
        codeLabel.textContent = '';
        rateInput.value = 1;
        rateInput.disabled = false;
    }
}
document.getElementById('supplier_id').addEventListener('change', updateExchangeRateField);
document.addEventListener('DOMContentLoaded', updateExchangeRateField);
</script>
@endpush
@endsection
