@extends('layouts.pos')

@section('pos')
    <div class="container py-4">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">Create New Sale</h4>
            </div>

            {{-- Validation Errors --}}
            @if ($errors->any())
                <div class="alert alert-danger shadow-sm">
                    <ul class="mb-0 ps-3">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="card-body">
                <form action="{{ route('sales.store') }}" method="POST" id="sale-form" class="mb-5">
                    @csrf

                    <div class="row g-4">
                        {{-- Left Section --}}
                        <div class="col-md-7">
                            {{-- Sale Type --}}
                            @if ($company->type === 'both')
                                <div class="mb-3">
                                    <label for="sale_type" class="form-label">Sale Type</label>
                                    <select name="sale_type" id="sale_type" class="form-select" required>
                                        <option value="retail">Retail</option>
                                        <option value="wholesale">Wholesale</option>
                                    </select>
                                    <input type="hidden" name="sale_type" id="sale_type_hidden" value="retail">
                                </div>
                            @else
                                <input type="hidden" name="sale_type" id="sale_type" value="{{ $company->type }}">
                            @endif

                            {{-- Customer Section --}}
                            <div class="mb-3">
                                <label for="wholesale_customer_id" class="form-label">Wholesale Customer</label>
                                <select name="wholesale_customer_id" id="wholesale_customer_id" class="form-select">
                                    <option value="">Select wholesale customer</option>
                                    @foreach ($customers as $customer)
                                        <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="retail_customer_name" class="form-label">Customer Name (for walk-in/retail)</label>
                                <input type="text" name="retail_customer_name" id="retail_customer_name" class="form-control" placeholder="Enter customer name">
                            </div>

                            {{-- Item Selection --}}
                            <div class="card border-0 shadow-sm mb-3">
                                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                                    <strong>Select Items & Quantities</strong>
                                    <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal"
                                        data-bs-target="#itemModal">
                                        Add Item
                                    </button>
                                </div>
                                <div class="card-body p-3" id="selected-items">
                                    {{-- Selected items will be rendered here --}}
                                </div>
                            </div>
                        </div>

                        {{-- Right Section: Summary --}}
                        <div class="col-md-5">
                            <div class="card border-0 shadow-sm">
                                <div class="card-header bg-light">
                                    <strong>Summary</strong>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label for="subtotal" class="form-label">Subtotal</label>
                                        <input type="text" id="subtotal" class="form-control" readonly value="0.00">
                                    </div>

                                    <div class="mb-3">
                                        <label for="discount" class="form-label">Discount (Optional)</label>
                                        <input type="number" name="discount" id="discount" class="form-control"
                                            min="0" step="0.01" value="0"
                                            placeholder="Enter discount amount">
                                    </div>

                                    <div class="mb-3">
                                        <label for="payment_method" class="form-label">Payment Method</label>
                                        <select name="payment_method" id="payment_method" class="form-select" required>
                                            <option value="cash">Cash</option>
                                            <option value="card">Card</option>
                                            <option value="online">Online</option>
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label for="tax_percentage" class="form-label">Tax Percentage</label>
                                        <input type="text" id="tax_percentage" class="form-control" readonly
                                            value="0%">
                                    </div>

                                    <div class="mb-3">
                                        <label for="tax_amount" class="form-label">Tax Amount</label>
                                        <input type="text" id="tax_amount" name="tax_amount" class="form-control"
                                            readonly value="0.00">
                                    </div>

                                    <div class="mb-3">
                                        <label for="total_amount" class="form-label">Total Amount</label>
                                        <input type="text" id="total_amount" name="total_amount" class="form-control"
                                            readonly value="0.00">
                                    </div>

                                    <div class="mb-3">
                                        <label for="amount_received" class="form-label">Amount Received</label>
                                        <input type="number" id="amount_received" name="amount_received" class="form-control" min="0" step="0.01" placeholder="Enter amount received">
                                    </div>

                                    <div class="mb-3">
                                        <label for="change_return" class="form-label">Change to Return</label>
                                        <input type="text" id="change_return" name="change_return" class="form-control" readonly value="0.00">
                                    </div>

                                    <div class="d-flex justify-content-between mt-4">
                                        <button type="submit" class="btn btn-primary w-50">Submit Sale</button>
                                        <a href="{{ route('sales.index') }}"
                                            class="btn btn-outline-secondary w-45 ms-2">Cancel</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

                {{-- Item Modal --}}
                <div class="modal fade" id="itemModal" tabindex="-1" aria-labelledby="itemModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content shadow-sm">
                            <div class="modal-header">
                                <h5 class="modal-title">Select Item</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <input type="text" id="item-search" class="form-control mb-3"
                                    placeholder="Search items...">
                                <div class="list-group" id="item-list" style="max-height: 300px; overflow-y: auto;">
                                    @foreach ($inventories as $inventory)
                                        @php
                                            $isInactive = $inventory->status === 'inactive';
                                            $isOutOfStock = $inventory->unit <= 0;
                                            $isLowStock = !$isOutOfStock && $inventory->unit < 10;
                                            $disabled = $isInactive || $isOutOfStock;
                                        @endphp
                                        <button type="button"
                                            class="list-group-item list-group-item-action d-flex justify-content-between align-items-center {{ $disabled ? 'disabled' : '' }}"
                                            data-id="{{ $inventory->id }}" data-name="{{ $inventory->item_name }}"
                                            data-retail="{{ $inventory->retail_amount }}"
                                            data-wholesale="{{ $inventory->wholesale_amount }}"
                                            data-unit="{{ $inventory->unit }}" {{ $disabled ? 'disabled' : '' }}>
                                            <div>
                                                <strong>{{ $inventory->item_name }}</strong>
                                                <div class="text-muted small">
                                                    Retail: {{ number_format($inventory->retail_amount, 2) }} |
                                                    Wholesale: {{ number_format($inventory->wholesale_amount, 2) }} |
                                                    In Stock: {{ $inventory->unit }}
                                                    @if ($isInactive)
                                                        <span class="badge bg-secondary ms-2">Inactive</span>
                                                    @elseif($isOutOfStock)
                                                        <span class="badge bg-danger ms-2">Out of Stock</span>
                                                    @elseif($isLowStock)
                                                        <span class="badge bg-warning text-dark ms-2">Low Stock</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </button>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const taxRates = {
                cash: {{ $company->taxCash }},
                card: {{ $company->taxCard }},
                online: {{ $company->taxOnline }}
            };

            const saleTypeSelect = document.getElementById('sale_type');
            const paymentMethodSelect = document.getElementById('payment_method');
            const discountInput = document.getElementById('discount');
            const selectedItemsContainer = document.getElementById('selected-items');
            const itemList = document.getElementById('item-list');
            const itemSearch = document.getElementById('item-search');

            function getCurrentSaleType() {
                return saleTypeSelect ? saleTypeSelect.value : '{{ $company->type }}';
            }

            function updateTaxPercentage() {
                const paymentMethod = paymentMethodSelect.value;
                const taxPercent = taxRates[paymentMethod] || 0;
                document.getElementById('tax_percentage').value = taxPercent + '%';
                return taxPercent;
            }

            function calculateTotals() {
                const saleType = getCurrentSaleType();
                const quantityInputs = document.querySelectorAll('.quantity-input');
                let subtotal = 0;

                quantityInputs.forEach(input => {
                    const qty = parseFloat(input.value) || 0;
                    const retailPrice = parseFloat(input.dataset.retail);
                    const wholesalePrice = parseFloat(input.dataset.wholesale);
                    const price = (saleType === 'retail') ? retailPrice : wholesalePrice;
                    const total = qty * price;

                    const row = input.closest('.item-row');
                    const itemTotalInput = row.querySelector('.item-total');
                    itemTotalInput.value = total.toFixed(2);

                    subtotal += total;
                });

                document.getElementById('subtotal').value = subtotal.toFixed(2);

                const discount = parseFloat(discountInput.value) || 0;
                const taxPercent = updateTaxPercentage();
                const taxableAmount = Math.max(subtotal - discount, 0);
                const taxAmount = (taxPercent / 100) * taxableAmount;

                document.getElementById('tax_amount').value = taxAmount.toFixed(2);

                const totalAmount = taxableAmount + taxAmount;
                document.getElementById('total_amount').value = totalAmount.toFixed(2);

                // Calculate change
                const amountReceivedInput = document.getElementById('amount_received');
                const changeReturnInput = document.getElementById('change_return');
                if (amountReceivedInput && changeReturnInput) {
                    const amountReceived = parseFloat(amountReceivedInput.value) || 0;
                    const change = amountReceived - totalAmount;
                    changeReturnInput.value = change >= 0 ? change.toFixed(2) : '0.00';
                }
            }

            function addItemToSelected(item) {
                const itemId = item.dataset.id;
                if (document.getElementById(`item-row-${itemId}`)) {
                    alert('Item already selected.');
                    return;
                }

                const itemName = item.dataset.name;
                const retailPrice = item.dataset.retail;
                const wholesalePrice = item.dataset.wholesale;
                const availableStock = parseInt(item.dataset.unit);

                const saleType = getCurrentSaleType();
                const price = (saleType === 'retail') ? retailPrice : wholesalePrice;

                const row = document.createElement('div');
                row.className = 'row mb-3 align-items-center border-bottom pb-2 item-row';
                row.id = `item-row-${itemId}`;
                row.innerHTML = `
                <div class="col-md-4">
                    <strong>${itemName}</strong>
                    <input type="hidden" name="items[${itemId}][inventory_id]" value="${itemId}">
                </div>
                <div class="col-md-2">
                    <input type="number" name="items[${itemId}][quantity]"
                        class="form-control quantity-input" min="1" max="${availableStock}" value="1" placeholder="Quantity"
                        data-retail="${retailPrice}"
                        data-wholesale="${wholesalePrice}"
                        data-stock="${availableStock}">
                </div>
                <div class="col-md-3">
                    <input type="text" class="form-control item-total" value="${parseFloat(price).toFixed(2)}" readonly>
                </div>
                <div class="col-md-3">
                    <button type="button" class="btn btn-danger btn-sm remove-item" data-id="${itemId}">Remove</button>
                </div>
            `;

                selectedItemsContainer.appendChild(row);

                calculateTotals();

                const qtyInput = row.querySelector('.quantity-input');
                qtyInput.addEventListener('input', function() {
                    const max = parseInt(this.getAttribute('max'));
                    let val = parseInt(this.value);
                    if (val > max) {
                        alert('Cannot sell more than available stock (' + max + ').');
                        this.value = max;
                    } else if (val < 1) {
                        this.value = 1;
                    }
                    calculateTotals();
                });
                row.querySelector('.remove-item').addEventListener('click', function() {
                    document.getElementById(`item-row-${itemId}`).remove();
                    calculateTotals();
                });
            }

            // Item selection
            if (itemList) {
                itemList.addEventListener('click', function(e) {
                    const target = e.target.closest('button[data-id]');
                    if (target && !target.classList.contains('disabled')) {
                        addItemToSelected(target);
                        const modal = bootstrap.Modal.getInstance(document.getElementById('itemModal'));
                        modal.hide();
                    }
                });
            }

            // Item live search
            itemSearch.addEventListener('input', function() {
                const searchTerm = this.value.toLowerCase().trim();

                document.querySelectorAll('#item-list .list-group-item').forEach(btn => {
                    const name = btn.dataset.name?.toLowerCase() || '';
                    if (name.includes(searchTerm)) {
                        btn.classList.remove('d-none');
                    } else {
                        btn.classList.add('d-none');
                    }
                });
            });



            // Sale type
            if (saleTypeSelect) {
                saleTypeSelect.addEventListener('change', calculateTotals);
            }

            // Payment method
            if (paymentMethodSelect) {
                paymentMethodSelect.addEventListener('change', () => {
                    updateTaxPercentage();
                    calculateTotals();
                });
            }

            // Discount
            if (discountInput) {
                discountInput.addEventListener('input', calculateTotals);
            }

            // Amount received
            const amountReceivedInput = document.getElementById('amount_received');
            if (amountReceivedInput) {
                amountReceivedInput.addEventListener('input', calculateTotals);
            }

            // Customer validation: Only one required
            const saleForm = document.getElementById('sale-form');
            if (saleForm) {
                saleForm.addEventListener('submit', function(e) {
                    const wholesaleId = document.getElementById('wholesale_customer_id').value;
                    const retailName = document.getElementById('retail_customer_name').value.trim();
                    if (!wholesaleId && !retailName) {
                        alert('Please select a wholesale customer or enter a retail customer name.');
                        e.preventDefault();
                        return false;
                    }
                    if (wholesaleId && retailName) {
                        alert('Please fill only one: either select a wholesale customer or enter a retail customer name, not both.');
                        e.preventDefault();
                        return false;
                    }
                    // Ensure change_return is up to date before submit
                    const amountReceivedInput = document.getElementById('amount_received');
                    const changeReturnInput = document.getElementById('change_return');
                    if (amountReceivedInput && changeReturnInput) {
                        const totalAmount = parseFloat(document.getElementById('total_amount').value) || 0;
                        const amountReceived = parseFloat(amountReceivedInput.value) || 0;
                        const change = amountReceived - totalAmount;
                        changeReturnInput.value = change >= 0 ? change.toFixed(2) : '0.00';
                    }
                });
            }

            // Select2 for wholesale customer
            $("#wholesale_customer_id").select2({
                placeholder: 'Select wholesale customer',
                allowClear: true,
                width: '100%'
            });

            const wholesaleCustomerSelect = document.getElementById('wholesale_customer_id');
            const retailCustomerInput = document.getElementById('retail_customer_name');

            function updateSaleTypeAndLock() {
                const wholesaleId = wholesaleCustomerSelect.value;
                const retailName = retailCustomerInput.value.trim();
                if (wholesaleId) {
                    if (saleTypeSelect) {
                        saleTypeSelect.value = 'wholesale';
                        saleTypeSelect.style.display = 'none';
                    }
                    document.getElementById('sale_type_hidden').value = 'wholesale';
                } else if (retailName) {
                    if (saleTypeSelect) {
                        saleTypeSelect.value = 'retail';
                        saleTypeSelect.style.display = 'none';
                    }
                    document.getElementById('sale_type_hidden').value = 'retail';
                } else {
                    if (saleTypeSelect) {
                        saleTypeSelect.style.display = '';
                    }
                    document.getElementById('sale_type_hidden').value = saleTypeSelect.value;
                }
                calculateTotals();
            }

            if (wholesaleCustomerSelect) {
                wholesaleCustomerSelect.addEventListener('change', function() {
                    if (this.value) {
                        retailCustomerInput.value = '';
                    }
                    updateSaleTypeAndLock();
                });
            }
            if (retailCustomerInput) {
                retailCustomerInput.addEventListener('input', function() {
                    if (this.value.trim()) {
                        if (wholesaleCustomerSelect) wholesaleCustomerSelect.value = '';
                        $(wholesaleCustomerSelect).trigger('change');
                    }
                    updateSaleTypeAndLock();
                });
            }
            if (saleTypeSelect) {
                saleTypeSelect.addEventListener('change', function() {
                    document.getElementById('sale_type_hidden').value = saleTypeSelect.value;
                    calculateTotals();
                });
            }
            // On page load
            updateSaleTypeAndLock();
        });
    </script>
@endpush
