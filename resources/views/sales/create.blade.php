@extends('layouts.pos')

@section('pos')
    <div class="container py-4">
        <div class="card shadow-lg border-0 modern-sale-card animate__animated animate__fadeIn">
            <div class="card-header bg-white text-danger d-flex align-items-center" style="border-top-left-radius: 1.5rem; border-top-right-radius: 1.5rem;">
                <i class="fa fa-cart-plus fa-lg me-2"></i>
                <h4 class="mb-0 fw-bold">Create New Sale</h4>
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
                    <input type="hidden" name="idempotency_token" value="{{ $token }}">
                    <div class="row g-4">
                        {{-- Sale Type & Customer Info --}}
                        <div class="col-md-7">
                            <div class="row g-3 mb-3">
                                <div class="col-12">
                                    <label class="form-label fw-semibold">Sale Type</label><br>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="sale_type" id="sale_type_distributor" value="distributor">
                            <label class="form-check-label" for="sale_type_distributor">Distributor</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="sale_type" id="sale_type_wholesale" value="wholesale">
                            <label class="form-check-label" for="sale_type_wholesale">Wholesale</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="sale_type" id="sale_type_retail" value="retail">
                            <label class="form-check-label" for="sale_type_retail">Retail</label>
                        </div>
                    </div>
                                <div class="col-md-6" id="distributor_section" style="display:none;">
                        <label for="distributor_id" class="form-label">Distributor</label>
                        <input type="text" class="form-control" id="distributor_search" placeholder="Click to select distributor" readonly data-bs-toggle="modal" data-bs-target="#distributorModal">
                        <input type="hidden" name="distributor_id" id="distributor_id">
                    </div>
                                <div class="col-md-6" id="shopkeeper_section" style="display:none;">
                        <label for="shopkeeper_id" class="form-label">Shopkeeper</label>
                        <input type="text" class="form-control" id="shopkeeper_search" placeholder="Click to select shopkeeper" readonly data-bs-toggle="modal" data-bs-target="#shopkeeperModal">
                        <input type="hidden" name="shopkeeper_id" id="shopkeeper_id">
                                </div>
                                <div class="col-md-6" id="wholesale_section" style="display:none;">
                                    <label for="wholesale_customer_id" class="form-label">Wholesaler</label>
                                    <input type="text" class="form-control" id="wholesale_search" placeholder="Click to select wholesaler" readonly data-bs-toggle="modal" data-bs-target="#wholesaleModal">
                                    <input type="hidden" name="wholesale_customer_id" id="wholesale_customer_id">
                            </div>
                                <div class="col-md-6" id="retail_section" style="display:none;">
                                <label for="retail_customer_name" class="form-label">Customer Name (for walk-in/retail)</label>
                                <input type="text" name="retail_customer_name" id="retail_customer_name" class="form-control" placeholder="Enter customer name">
                                </div>
                            </div>
                            {{-- Item Selection --}}
                            <div class="card border-0 shadow-sm mb-3 modern-section-card">
                                <div class="card-header bg-light d-flex justify-content-between align-items-center rounded-top">
                                    <strong><i class="fa fa-boxes-stacked me-2"></i>Select Items & Quantities</strong>
                                    <div>
                                        <button type="button" class="btn btn-outline-danger rounded-pill me-2 px-3 py-1 animate__animated animate__fadeInUp" data-bs-toggle="modal" data-bs-target="#itemModal">
                                            <i class="fa fa-plus me-1"></i> Add Item
                                        </button>
                                        <button type="button" class="btn btn-outline-primary rounded-pill px-3 py-1 animate__animated animate__fadeInUp" data-bs-toggle="modal" data-bs-target="#manualProductModal">
                                            <i class="fa fa-pen-nib me-1"></i> Add Manual Product
                                    </button>
                                    </div>
                                </div>
                                <div class="card-body p-3" id="selected-items">
                                    {{-- Selected items will be rendered here --}}
                                </div>
                            </div>
                        </div>
                        {{-- Right Section: Summary --}}
                        <div class="col-md-5">
                            <div class="card border-0 shadow-sm modern-section-card">
                                <div class="card-header bg-light rounded-top">
                                    <strong><i class="fa fa-receipt me-2"></i>Summary</strong>
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
                                        <button type="submit" class="btn btn-danger w-50 modern-btn animate__animated animate__pulse"><i class="fa fa-check-circle me-2"></i>Submit Sale</button>
                                        <a href="{{ route('sales.index') }}"
                                            class="btn btn-outline-secondary w-45 ms-2 modern-btn"><i class="fa fa-times me-2"></i>Cancel</a>
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
                {{-- Distributor Modal --}}
                <div class="modal fade" id="distributorModal" tabindex="-1" aria-labelledby="distributorModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="distributorModalLabel">Select Distributor</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <input type="text" id="distributorModalSearch" class="form-control mb-2" placeholder="Search distributor...">
                                <ul class="list-group" id="distributorList">
                                    @foreach ($distributors as $distributor)
                                        <li class="list-group-item distributor-item" data-id="{{ $distributor->id }}" data-name="{{ $distributor->name }}">
                                            {{ $distributor->name }}
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- Shopkeeper Modal --}}
                <div class="modal fade" id="shopkeeperModal" tabindex="-1" aria-labelledby="shopkeeperModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="shopkeeperModalLabel">Select Shopkeeper</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <input type="text" id="shopkeeperModalSearch" class="form-control mb-2" placeholder="Search shopkeeper...">
                                <ul class="list-group" id="shopkeeperList">
                                    @foreach ($shopkeepers as $shopkeeper)
                                        <li class="list-group-item shopkeeper-item" data-id="{{ $shopkeeper->id }}" data-name="{{ $shopkeeper->name }}" data-distributor="{{ $shopkeeper->distributor_id }}">
                                            {{ $shopkeeper->name }}
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- Manual Product Modal --}}
                <div class="modal fade" id="manualProductModal" tabindex="-1" aria-labelledby="manualProductModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content shadow-sm">
                            <div class="modal-header">
                                <h5 class="modal-title" id="manualProductModalLabel">Add Manual Product (External Sale)</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="manual_product_name" class="form-label">Product Name</label>
                                    <input type="text" id="manual_product_name" class="form-control" placeholder="Enter product name">
                                </div>
                                <div class="mb-3">
                                    <label for="manual_product_quantity" class="form-label">Quantity</label>
                                    <input type="number" id="manual_product_quantity" class="form-control" min="1" value="1">
                                </div>
                                <div class="mb-3">
                                    <label for="manual_product_selling_price" class="form-label">Selling Price</label>
                                    <input type="number" id="manual_product_selling_price" class="form-control" min="0" step="0.01" placeholder="Enter selling price">
                                </div>
                                <div class="mb-3">
                                    <label for="manual_product_purchase_price" class="form-label">Purchase Price</label>
                                    <input type="number" id="manual_product_purchase_price" class="form-control" min="0" step="0.01" placeholder="Enter purchase price">
                                </div>
                                <div class="mb-3">
                                    <label for="manual_product_buy_from" class="form-label">Buy From (optional)</label>
                                    <input type="text" id="manual_product_buy_from" class="form-control" placeholder="Enter shop name or leave blank">
                                </div>
                                <button type="button" class="btn btn-primary w-100" id="addManualProductBtn">Add Manual Product</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Add Wholesaler Modal (similar to distributor/shopkeeper) -->
                <div class="modal fade" id="wholesaleModal" tabindex="-1" aria-labelledby="wholesaleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content shadow-sm">
                            <div class="modal-header">
                                <h5 class="modal-title">Select Wholesaler</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <input type="text" id="wholesale-customer-search" class="form-control mb-3" placeholder="Search wholesalers...">
                                <div class="list-group" id="wholesale-customer-list" style="max-height: 300px; overflow-y: auto;">
                                    @foreach ($customers as $customer)
                                        <button type="button" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center"
                                            data-id="{{ $customer->id }}" data-name="{{ $customer->name }}">
                                            <div>
                                                <strong>{{ $customer->name }}</strong>
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
    <!-- FontAwesome CDN for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Animate.css CDN for subtle animations -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <style>
        .modern-sale-card {
            border-radius: 1.5rem;
            background: #f9fafb;
            box-shadow: 0 4px 24px 0 rgba(0,0,0,0.07);
        }
        .modern-section-card {
            border-radius: 1.2rem;
            background: #fff;
            box-shadow: 0 2px 12px 0 rgba(0,0,0,0.04);
        }
        .modern-btn {
            border-radius: 2rem !important;
            font-weight: 600;
            transition: background 0.2s, color 0.2s, box-shadow 0.2s;
        }
        .modern-btn:hover, .modern-btn:focus {
            box-shadow: 0 2px 8px 0 rgba(220,53,69,0.12);
            background: #e3342f;
            color: #fff;
        }
        .btn-outline-primary, .btn-outline-danger {
            border-radius: 2rem;
            font-weight: 500;
            transition: background 0.2s, color 0.2s;
        }
        .btn-outline-primary:hover, .btn-outline-danger:hover {
            background: #f3f4f6;
            color: #0d6efd;
        }
        .form-control, .form-select {
            border-radius: 1rem;
            font-size: 1.05rem;
        }
        .card-header {
            border-top-left-radius: 1.2rem !important;
            border-top-right-radius: 1.2rem !important;
        }
        .card {
            border-radius: 1.2rem !important;
        }
        @media (max-width: 991px) {
            .modern-sale-card, .modern-section-card { border-radius: 1rem; }
            .form-control, .form-select { font-size: 0.98rem; }
        }
        @media (max-width: 767px) {
            .modern-sale-card, .modern-section-card { border-radius: 0.7rem; }
            .form-control, .form-select { font-size: 0.95rem; }
        }
    </style>
@endpush

@section('scripts')
    <script>
$(document).ready(function() {
    function updateSections() {
        var type = $('input[name="sale_type"]:checked').val();
        console.log('Sale type changed to:', type); // Debug log
        $('#distributor_section, #shopkeeper_section, #wholesale_section, #retail_section').hide();
        if (type === 'distributor') {
            $('#distributor_section').show();
            $('#shopkeeper_section').show();
        } else if (type === 'wholesale') {
            $('#wholesale_section').show();
        } else if (type === 'retail') {
            $('#retail_section').show();
        }
    }
    $('input[name="sale_type"]').on('change', updateSections);
    // Default to distributor
    $('#sale_type_distributor').prop('checked', true);
    updateSections();

    // Distributor modal search and select
    $('#distributorModalSearch').on('keyup', function() {
        var val = $(this).val().toLowerCase();
        $('#distributorList .distributor-item').each(function() {
            var name = $(this).data('name').toLowerCase();
            $(this).toggle(name.includes(val));
        });
    });
    $('#distributorList .distributor-item').on('click', function() {
        var id = $(this).data('id');
        var name = $(this).data('name');
        $('#distributor_id').val(id);
        $('#distributor_search').val(name);
        $('#shopkeeper_id').val('');
        $('#shopkeeper_search').val('');
        $('#distributorModal').modal('hide');
    });
    // Shopkeeper modal search and select
    function filterShopkeepers() {
        var distId = $('#distributor_id').val();
        $('#shopkeeperList .shopkeeper-item').each(function() {
            var belongs = $(this).data('distributor') == distId;
            $(this).toggle(belongs);
        });
    }
    $('#shopkeeperModal').on('show.bs.modal', filterShopkeepers);
    $('#shopkeeperModalSearch').on('keyup', function() {
        var val = $(this).val().toLowerCase();
        $('#shopkeeperList .shopkeeper-item:visible').each(function() {
            var name = $(this).data('name').toLowerCase();
            $(this).toggle(name.includes(val));
        });
    });
    $('#shopkeeperList .shopkeeper-item').on('click', function() {
        var id = $(this).data('id');
        var name = $(this).data('name');
        $('#shopkeeper_id').val(id);
        $('#shopkeeper_search').val(name);
        $('#shopkeeperModal').modal('hide');
    });

    // Wholesaler modal search and select
    $('#wholesale-customer-search').on('keyup', function() {
        var val = $(this).val().toLowerCase();
        $('#wholesale-customer-list .list-group-item').each(function() {
            var name = $(this).data('name').toLowerCase();
            $(this).toggle(name.includes(val));
        });
    });
    $('#wholesale-customer-list .list-group-item').on('click', function() {
        var id = $(this).data('id');
        var name = $(this).data('name');
        $('#wholesale_customer_id').val(id);
        $('#wholesale_search').val(name);
        $('#wholesaleModal').modal('hide');
    });

    // Item selection logic
    $('#item-list').on('click', 'button[data-id]', function() {
        var itemId = $(this).data('id');
        var itemName = $(this).data('name');
        var retailPrice = $(this).data('retail');
        var wholesalePrice = $(this).data('wholesale');
        var availableStock = $(this).data('unit');
        var saleType = $('input[name="sale_type"]:checked').val();
        var price = (saleType === 'retail') ? retailPrice : wholesalePrice;

        // Prevent duplicate
        if ($('#item-row-' + itemId).length) {
                    alert('Item already selected.');
                    return;
                }

        var row = `
        <div class="row mb-3 align-items-center border-bottom pb-2 item-row" id="item-row-${itemId}">
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
                </div>
            `;
        $('#selected-items').append(row);
        // Hide modal
        $('#itemModal').modal('hide');
    });
    // Remove item
    $('#selected-items').on('click', '.remove-item', function() {
        var itemId = $(this).data('id');
        $('#item-row-' + itemId).remove();
    });

    // --- MANUAL PRODUCT LOGIC ---
    let manualProductIndex = 0;
    // Add manual product
    $('#addManualProductBtn').on('click', function() {
        const name = $('#manual_product_name').val().trim();
        const quantity = parseInt($('#manual_product_quantity').val()) || 1;
        const sellingPrice = parseFloat($('#manual_product_selling_price').val()) || 0;
        const purchasePrice = parseFloat($('#manual_product_purchase_price').val()) || 0;
        const buyFrom = $('#manual_product_buy_from').val().trim();
        if (!name || sellingPrice <= 0 || purchasePrice < 0 || quantity < 1) {
            alert('Please fill all required fields for manual product.');
            return;
        }
        // Unique index for manual product
        const idx = manualProductIndex++;
        // Add to selected items
        const row = `
        <div class="row mb-3 align-items-center border-bottom pb-2 item-row manual-product-row" id="manual-product-row-${idx}">
            <div class="col-md-4">
                <strong>${name} <span class='badge bg-info text-dark ms-1'>Manual</span></strong>
                <input type="hidden" name="manual_products[${idx}][name]" value="${name}">
                <input type="hidden" name="manual_products[${idx}][quantity]" value="${quantity}">
                <input type="hidden" name="manual_products[${idx}][selling_price]" value="${sellingPrice}">
                <input type="hidden" name="manual_products[${idx}][purchase_price]" value="${purchasePrice}">
                <input type="hidden" name="manual_products[${idx}][buy_from]" value="${buyFrom}">
            </div>
            <div class="col-md-2">
                <span>${quantity}</span>
            </div>
            <div class="col-md-3">
                <span>${(quantity * sellingPrice).toFixed(2)}</span>
            </div>
            <div class="col-md-3">
                <button type="button" class="btn btn-warning btn-sm edit-manual-product" data-idx="${idx}">Edit</button>
                <button type="button" class="btn btn-danger btn-sm remove-manual-product" data-idx="${idx}">Remove</button>
            </div>
        </div>
        `;
        $('#selected-items').append(row);
        $('#manualProductModal').modal('hide');
        // Reset modal fields
        $('#manual_product_name').val('');
        $('#manual_product_quantity').val(1);
        $('#manual_product_selling_price').val('');
        $('#manual_product_purchase_price').val('');
        $('#manual_product_buy_from').val('');
        calculateTotals();
    });
    // Remove manual product
    $('#selected-items').on('click', '.remove-manual-product', function() {
        const idx = $(this).data('idx');
        $('#manual-product-row-' + idx).remove();
        calculateTotals();
    });
    // Edit manual product (reopen modal with values)
    $('#selected-items').on('click', '.edit-manual-product', function() {
        const idx = $(this).data('idx');
        const row = $('#manual-product-row-' + idx);
        $('#manual_product_name').val(row.find('input[name$="[name]"]').val());
        $('#manual_product_quantity').val(row.find('input[name$="[quantity]"]').val());
        $('#manual_product_selling_price').val(row.find('input[name$="[selling_price]"]').val());
        $('#manual_product_purchase_price').val(row.find('input[name$="[purchase_price]"]').val());
        $('#manual_product_buy_from').val(row.find('input[name$="[buy_from]"]').val());
        // Remove the row (will be re-added on save)
        row.remove();
        $('#manualProductModal').modal('show');
        calculateTotals();
    });
    // Update calculateTotals to include manual products
    function calculateTotals() {
        var subtotal = 0;
        // Regular items
        $('#selected-items .item-row:not(.manual-product-row)').each(function() {
            var qty = parseFloat($(this).find('.quantity-input').val()) || 0;
            var saleType = $('input[name="sale_type"]:checked').val();
            var price = saleType === 'retail'
                ? parseFloat($(this).find('.quantity-input').data('retail'))
                : parseFloat($(this).find('.quantity-input').data('wholesale'));
            var total = qty * price;
            subtotal += total;
            $(this).find('.item-total').val(total.toFixed(2));
        });
        // Manual products
        $('#selected-items .manual-product-row').each(function() {
            var qty = parseFloat($(this).find('input[name$="[quantity]"]').val()) || 0;
            var price = parseFloat($(this).find('input[name$="[selling_price]"]').val()) || 0;
            var total = qty * price;
            subtotal += total;
        });
        $('#subtotal').val(subtotal.toFixed(2));

        var discount = parseFloat($('#discount').val()) || 0;
        var subtotalAfterDiscount = subtotal - discount;
        if (subtotalAfterDiscount < 0) subtotalAfterDiscount = 0;

        // Tax percentage (from field, remove % sign)
        var taxPercent = parseFloat($('#tax_percentage').val()) || 0;
        var taxAmount = (taxPercent / 100) * subtotalAfterDiscount;
        $('#tax_amount').val(taxAmount.toFixed(2));

        var totalAmount = subtotalAfterDiscount + taxAmount;
        $('#total_amount').val(totalAmount.toFixed(2));

        // Amount received and change
        var amountReceived = parseFloat($('#amount_received').val()) || 0;
        var change = amountReceived - totalAmount;
        $('#change_return').val(change >= 0 ? change.toFixed(2) : '0.00');
    }
    // Trigger calculation on quantity, discount, amount received changes
    $('#selected-items').on('input', '.quantity-input', calculateTotals);
    $('#discount, #amount_received').on('input', calculateTotals);
    // Also recalculate when items are added/removed
    $('#item-list').on('click', 'button[data-id]', function() {
        setTimeout(calculateTotals, 100);
    });
    $('#selected-items').on('click', '.remove-item, .remove-manual-product', function() {
        setTimeout(calculateTotals, 100);
    });
    // Initial calculation
                    calculateTotals();

    // Retail: Amount received must not be less than total
    $('#sale-form').on('submit', function(e) {
        var saleType = $('input[name="sale_type"]:checked').val();
        if (saleType === 'retail') {
            var total = parseFloat($('#total_amount').val()) || 0;
            var received = parseFloat($('#amount_received').val()) || 0;
            if (received < total) {
                alert('For retail sales, the received amount cannot be less than the total amount.');
                $('#amount_received').focus();
                e.preventDefault();
                return false;
            }
        }
    });
        });
    </script>
@endsection
