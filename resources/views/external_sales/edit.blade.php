@extends('layouts.pos')

@section('pos')
    <div class="container py-4">
        <div class="card shadow-sm">
            <div class="card-header bg-danger text-white">
                <h4 class="mb-0">Edit Manual Sale</h4>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('external-sales.update', $sale->id) }}">
                    @csrf
                    @method('PUT')
                    <div class="row g-3">
                        <div class="col-md-6">
                            <h5>PURCHASE</h5>
                            <hr>
                            <div class="mb-3">
                                <label class="form-label">Item Name <span class="text-danger">*</span></label>
                                <input type="text" name="item_name" class="form-control" value="{{ old('item_name', $purchase->item_name ?? '') }}" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Details</label>
                                <textarea name="details" class="form-control" rows="4">{{ old('details', $purchase->details ?? '') }}</textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Purchase Price <span class="text-danger">*</span></label>
                                <input type="number" step="0.01" name="purchase_amount" class="form-control" value="{{ old('purchase_amount', $purchase->purchase_amount ?? '') }}" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Purchase Source</label>
                                <input type="text" name="purchase_source" class="form-control" value="{{ old('purchase_source', $purchase->purchase_source ?? '') }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h5>SALE</h5>
                            <hr>
                            <div class="mb-3">
                                <label class="form-label">Sale Amount <span class="text-danger">*</span></label>
                                <input type="number" step="0.01" name="sale_amount" id="sale_amount" class="form-control" value="{{ old('sale_amount', $sale->sale_amount) }}" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Payment Method <span class="text-danger">*</span></label>
                                <select name="payment_method" id="payment_method" class="form-select" required>
                                    <option value="cash" {{ old('payment_method', $sale->payment_method) == 'cash' ? 'selected' : '' }}>Cash</option>
                                    <option value="card" {{ old('payment_method', $sale->payment_method) == 'card' ? 'selected' : '' }}>Card</option>
                                    <option value="online" {{ old('payment_method', $sale->payment_method) == 'online' ? 'selected' : '' }}>Online</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Customer <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="text" id="selected_customer_name" class="form-control" placeholder="Select customer..." value="{{ old('customer_name', $sale->customer->name ?? '') }}" readonly required>
                                    <input type="hidden" name="customer_id" id="selected_customer_id" value="{{ old('customer_id', $sale->customer_id) }}">
                                    <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#customerModal">Search</button>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Tax Amount</label>
                                <input type="text" id="tax_amount" class="form-control bg-light" value="{{ old('tax_amount', $sale->tax_amount) }}" readonly>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Total Amount</label>
                                <input type="text" id="total_amount" class="form-control bg-light" value="{{ old('total_amount', $sale->total_amount) }}" readonly>
                            </div>
                        </div>
                        <div class="text-end mt-4">
                            <button type="submit" class="btn btn-success px-4">
                                <i class="bi bi-save me-1"></i> Update Sale
                            </button>
                        </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Customer Search Modal -->
    <div class="modal fade" id="customerModal" tabindex="-1" aria-labelledby="customerModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content shadow">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="customerModalLabel">Select Customer</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="text" id="customerSearch" class="form-control mb-3" placeholder="Search by name or phone...">
                    <ul class="list-group" id="customerResults" style="max-height: 300px; overflow-y: auto;">
                        @foreach ($customers as $customer)
                            <li class="list-group-item customer-item" data-id="{{ $customer->id }}" data-name="{{ $customer->name }}">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span>{{ $customer->name }}</span>
                                    <small class="text-muted">{{ $customer->type }} | {{ $customer->cel_no ?? 'No phone' }}</small>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <script>
        const taxRates = @json($taxes);
        const saleAmountInput = document.getElementById('sale_amount');
        const paymentMethodInput = document.getElementById('payment_method');
        const taxAmountField = document.getElementById('tax_amount');
        const totalAmountField = document.getElementById('total_amount');
        function updateAmounts() {
            const amount = parseFloat(saleAmountInput.value) || 0;
            const method = paymentMethodInput.value;
            const taxPercent = taxRates[method] || 0;
            const tax = (taxPercent / 100) * amount;
            const total = amount + tax;
            taxAmountField.value = tax.toFixed(2);
            totalAmountField.value = total.toFixed(2);
        }
        saleAmountInput.addEventListener('input', updateAmounts);
        paymentMethodInput.addEventListener('change', updateAmounts);
        // Live customer search
        const customerSearch = document.getElementById('customerSearch');
        const customerItems = document.querySelectorAll('.customer-item');
        customerSearch.addEventListener('input', function() {
            const query = this.value.toLowerCase();
            customerItems.forEach(item => {
                const name = item.getAttribute('data-name').toLowerCase();
                item.style.display = name.includes(query) ? 'block' : 'none';
            });
        });
        customerItems.forEach(item => {
            item.addEventListener('click', function() {
                document.getElementById('selected_customer_id').value = this.getAttribute('data-id');
                document.getElementById('selected_customer_name').value = this.getAttribute('data-name');
                bootstrap.Modal.getInstance(document.getElementById('customerModal')).hide();
            });
        });
    </script>
@endsection 