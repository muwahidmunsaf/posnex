@extends('layouts.pos')

@section('pos')
<div class="container py-4">
    <div class="card shadow-sm">
        <div class="card-header bg-danger text-white">
            <h4 class="mb-0">Edit Sale ({{ $sale->sale_code }})</h4>
        </div>
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
            <form action="{{ route('sales.update', $sale->id) }}" method="POST" id="sale-form" class="mb-5">
                @csrf
                @method('PUT')
                <input type="hidden" name="sale_type" value="{{ $sale->sale_type }}">
                <div class="mb-3">
                    <label class="form-label">Sale Type</label><br>
                    <span class="badge bg-info">{{ ucfirst($sale->sale_type) }}</span>
                </div>
                @if($sale->distributor_id)
                <div class="mb-3">
                    <label class="form-label">Distributor</label>
                    <input type="text" class="form-control" value="{{ $sale->distributor->name ?? '-' }}" readonly>
                    <input type="hidden" name="distributor_id" value="{{ $sale->distributor_id }}">
                </div>
                @endif
                @if($sale->shopkeeper_id)
                <div class="mb-3">
                    <label class="form-label">Shopkeeper</label>
                    <input type="text" class="form-control" value="{{ $sale->shopkeeper->name ?? '-' }}" readonly>
                    <input type="hidden" name="shopkeeper_id" value="{{ $sale->shopkeeper_id }}">
                </div>
                @endif
                @if($sale->customer_id)
                <div class="mb-3">
                    <label class="form-label">Customer</label>
                    <input type="text" class="form-control" value="{{ $sale->customer->name ?? '-' }}" readonly>
                    <input type="hidden" name="wholesale_customer_id" value="{{ $sale->customer_id }}">
                </div>
                @endif
                @if($sale->customer_name && !$sale->customer_id)
                <div class="mb-3">
                    <label class="form-label">Customer Name (Retail)</label>
                    <input type="text" class="form-control" value="{{ $sale->customer_name }}" readonly>
                    <input type="hidden" name="retail_customer_name" value="{{ $sale->customer_name }}">
                </div>
                @endif
                <div class="row g-4">
                    <div class="col-md-7">
                        <div class="card border-0 shadow-sm mb-3">
                            <div class="card-header bg-light d-flex justify-content-between align-items-center">
                                <strong>Edit Items & Quantities</strong>
                                <button type="button" class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#itemModal">
                                    Add Item
                                </button>
                            </div>
                            <div class="card-body p-3" id="selected-items">
                                {{-- Render current sale items as editable rows --}}
                                @foreach($sale->inventorySales as $i => $item)
                                    <div class="row align-items-center mb-2 sale-item-row" data-index="{{ $i }}" data-item-id="{{ $item->item_id }}">
                                        <input type="hidden" name="items[{{ $i }}][inventory_id]" value="{{ $item->item_id }}">
                                        <div class="col-5">
                                            <span>{{ $item->item->item_name ?? 'Item' }}</span>
                                        </div>
                                        <div class="col-3">
                                            <input type="number" name="items[{{ $i }}][quantity]" class="form-control form-control-sm item-qty" min="0" value="{{ $item->quantity }}">
                                        </div>
                                        <div class="col-3">
                                            <input type="number" name="items[{{ $i }}][amount]" class="form-control form-control-sm item-amount" min="0" step="0.01" value="{{ $item->amount }}">
                                        </div>
                                        <div class="col-1">
                                            <button type="button" class="btn btn-sm btn-danger remove-item-btn">&times;</button>
                                        </div>
                                    </div>
                                @endforeach
                                @foreach($sale->manualProducts as $i => $manual)
                                    <div class="row align-items-center mb-2 sale-item-row" data-index="manual-{{ $i }}" data-item-id="manual-{{ $i }}">
                                        <input type="hidden" name="manual_products[{{ $i }}][name]" value="{{ $manual->purchase->item_name ?? '' }}">
                                        <input type="hidden" name="manual_products[{{ $i }}][quantity]" value="1">
                                        <input type="hidden" name="manual_products[{{ $i }}][selling_price]" value="{{ $manual->sale_amount }}">
                                        <input type="hidden" name="manual_products[{{ $i }}][purchase_price]" value="{{ $manual->purchase->purchase_amount ?? '' }}">
                                        <input type="hidden" name="manual_products[{{ $i }}][buy_from]" value="{{ $manual->purchase->purchase_source ?? '' }}">
                                        <div class="col-5">
                                            <span>{{ $manual->purchase->item_name ?? 'Manual Product' }} <span class="badge bg-info ms-1">Manual</span></span>
                                        </div>
                                        <div class="col-3">
                                            <input type="number" class="form-control form-control-sm item-qty" value="1" readonly>
                                        </div>
                                        <div class="col-3">
                                            <input type="number" class="form-control form-control-sm item-amount" value="{{ $manual->sale_amount }}" readonly>
                                        </div>
                                        <div class="col-1">
                                            <button type="button" class="btn btn-sm btn-danger remove-item-btn">&times;</button>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
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
                                    <input type="number" name="discount" id="discount" class="form-control" min="0" step="0.01" value="{{ $sale->discount }}" placeholder="Enter discount amount">
                                </div>
                                <div class="mb-3">
                                    <label for="payment_method" class="form-label">Payment Method</label>
                                    <select name="payment_method" id="payment_method" class="form-select" required>
                                        <option value="cash" {{ $sale->payment_method == 'cash' ? 'selected' : '' }}>Cash</option>
                                        <option value="card" {{ $sale->payment_method == 'card' ? 'selected' : '' }}>Card</option>
                                        <option value="online" {{ $sale->payment_method == 'online' ? 'selected' : '' }}>Online</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="tax_percentage" class="form-label">Tax Percentage</label>
                                    <input type="text" id="tax_percentage" class="form-control" readonly value="{{ $sale->tax_percentage }}%">
                                </div>
                                <div class="mb-3">
                                    <label for="tax_amount" class="form-label">Tax Amount</label>
                                    <input type="text" id="tax_amount" name="tax_amount" class="form-control" readonly value="{{ $sale->tax_amount }}">
                                </div>
                                <div class="mb-3">
                                    <label for="total_amount" class="form-label">Total Amount</label>
                                    <input type="text" id="total_amount" name="total_amount" class="form-control" readonly value="{{ $sale->total_amount }}">
                                </div>
                                <div class="mb-3">
                                    <label for="amount_received" class="form-label">Amount Received</label>
                                    <input type="number" id="amount_received" name="amount_received" class="form-control" min="0" step="0.01" value="{{ $sale->amount_received }}">
                                </div>
                                <div class="mb-3">
                                    <label for="change_return" class="form-label">Change to Return</label>
                                    <input type="number" id="change_return" name="change_return" class="form-control" step="0.01" value="{{ $sale->change_return }}">
                                </div>
                                <div class="d-flex justify-content-between mt-4">
                                    <button type="submit" class="btn btn-danger w-50">Update Sale</button>
                                    <a href="{{ route('sales.index') }}" class="btn btn-outline-secondary w-45 ms-2">Cancel</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            {{-- Item Modal --}}
            <div class="modal fade" id="itemModal" tabindex="-1" aria-labelledby="itemModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content shadow-sm">
                        <div class="modal-header">
                            <h5 class="modal-title">Select Item</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <input type="text" id="item-search" class="form-control mb-3" placeholder="Search items...">
                            <div class="list-group" id="item-list" style="max-height: 300px; overflow-y: auto;">
                                @foreach ($inventories as $inventory)
                                    @php
                                        $isInactive = $inventory->status === 'inactive';
                                        //$isOutOfStock = $inventory->unit <= 0;
                                        //$isLowStock = !$isOutOfStock && $inventory->unit < 10;
                                        $disabled = $isInactive; // Only inactive items are disabled
                                    @endphp
                                    <button type="button" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center {{ $disabled ? 'disabled' : '' }}"
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
                                                @elseif($inventory->unit < 10)
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

@section('scripts')
<script>
$(document).ready(function() {
    // --- ADD/REMOVE/EDIT ITEMS LOGIC ---
    function getNextIndex() {
        var max = -1;
        $('#selected-items .sale-item-row').each(function() {
            var idx = parseInt($(this).attr('data-index'));
            if (idx > max) max = idx;
        });
        return max + 1;
    }
    // Add item from modal
    $('#item-list').on('click', 'button[data-id]', function() {
        var itemId = $(this).data('id');
        var itemName = $(this).data('name');
        var retailPrice = $(this).data('retail');
        var wholesalePrice = $(this).data('wholesale');
        var availableStock = $(this).data('unit');
        var saleType = $('input[name="sale_type"]').val();
        var price = (saleType === 'retail') ? retailPrice : wholesalePrice;
        // Prevent duplicate
        if ($('.sale-item-row[data-item-id="' + itemId + '"]').length) {
            alert('Item already selected.');
            return;
        }
        var idx = getNextIndex();
        var row = `
        <div class="row align-items-center mb-2 sale-item-row" data-index="${idx}" data-item-id="${itemId}">
            <input type="hidden" name="items[${idx}][inventory_id]" value="${itemId}">
            <div class="col-5">
                <span>${itemName}</span>
            </div>
            <div class="col-3">
                <input type="number" name="items[${idx}][quantity]" class="form-control form-control-sm item-qty" min="0" value="1">
            </div>
            <div class="col-3">
                <input type="number" name="items[${idx}][amount]" class="form-control form-control-sm item-amount" min="0" step="0.01" value="${parseFloat(price).toFixed(2)}">
            </div>
            <div class="col-1">
                <button type="button" class="btn btn-sm btn-danger remove-item-btn">&times;</button>
            </div>
        </div>
        `;
        $('#selected-items').append(row);
        $('#itemModal').modal('hide');
        setTimeout(calculateTotals, 100);
    });
    // Remove item
    $('#selected-items').on('click', '.remove-item-btn', function() {
        $(this).closest('.sale-item-row').remove();
        setTimeout(calculateTotals, 100);
    });
    // --- SUMMARY CALCULATION LOGIC ---
    function calculateTotals() {
        var subtotal = 0;
        $('#selected-items .sale-item-row').each(function() {
            var qty = parseFloat($(this).find('.item-qty').val()) || 0;
            var price = parseFloat($(this).find('.item-amount').val()) || 0;
            var total = qty * price;
            subtotal += total;
        });
        $('#subtotal').val(subtotal.toFixed(2));
        var discount = parseFloat($('#discount').val()) || 0;
        var subtotalAfterDiscount = subtotal - discount;
        if (subtotalAfterDiscount < 0) subtotalAfterDiscount = 0;
        var taxPercent = parseFloat($('#tax_percentage').val()) || 0;
        var taxAmount = (taxPercent / 100) * subtotalAfterDiscount;
        $('#tax_amount').val(taxAmount.toFixed(2));
        var totalAmount = subtotalAfterDiscount + taxAmount;
        $('#total_amount').val(totalAmount.toFixed(2));
        var amountReceived = parseFloat($('#amount_received').val()) || 0;
        var change = amountReceived - totalAmount;
        $('#change_return').val(change >= 0 ? change.toFixed(2) : '0.00');
    }
    // Trigger calculation on quantity, discount, amount received changes
    $('#selected-items').on('input', '.item-qty, .item-amount', calculateTotals);
    $('#discount, #amount_received').on('input', calculateTotals);
    // Initial calculation
    calculateTotals();
});
</script>
@endsection 