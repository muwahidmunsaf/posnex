@extends('layouts.app')
@section('content')
<div class="container">
    <!-- Back Button -->
    <div class="mb-3">
        <a href="{{ route('distributors.index') }}" class="btn btn-secondary">← Back to Distributors</a>
    </div>
    <!-- Print Button -->
    <div class="mb-3 text-end">
        <a href="{{ route('distributors.printHistory', $distributor) }}" target="_blank" class="btn btn-danger">
            <i class="bi bi-printer"></i> Print Full History
        </a>
    </div>
    <!-- Distributor Details Card -->
    <div class="card mb-4 shadow-sm">
        <div class="card-header bg-white">
            <h4 class="mb-0"><i class="bi bi-person-badge"></i> {{ $distributor->name }}</h4>
        </div>
        <div class="card-body row g-3">
            <div class="col-md-6 col-lg-4 mb-2">
                <div><strong>Phone:</strong> {{ $distributor->phone ?? '-' }}</div>
            </div>
            <div class="col-md-6 col-lg-4 mb-2">
                <div><strong>Email:</strong> {{ $distributor->email ?? '-' }}</div>
            </div>
            <div class="col-md-6 col-lg-4 mb-2">
                <div><strong>Address:</strong> {{ $distributor->address ?? '-' }}</div>
            </div>
            <div class="col-md-6 col-lg-4 mb-2">
                <div><strong>Commission Rate:</strong> {{ $distributor->commission_rate ?? 0 }}%</div>
            </div>
            <div class="col-md-6 col-lg-4 mb-2">
                <div><strong>Added On:</strong> {{ $distributor->created_at->format('M d, Y') }}</div>
            </div>
        </div>
    </div>
    <!-- Distributor Summary -->
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card text-center shadow-sm h-100">
                <div class="card-body">
                    <div class="mb-2"><i class="bi bi-people-fill text-primary" style="font-size:2rem;"></i></div>
                    <h3 class="text-primary mb-0">{{ $shopkeepers->count() }}</h3>
                    <div class="text-muted">Total Shopkeepers</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center shadow-sm h-100">
        <div class="card-body">
                    <div class="mb-2"><i class="bi bi-percent text-purple" style="font-size:2rem;"></i></div>
                    <h3 class="text-purple mb-0">{{ $distributor->commission_rate ?? 0 }}%</h3>
                    <div class="text-muted">Commission Rate</div>
                </div>
                    </div>
                </div>
                <div class="col-md-3">
            <div class="card text-center shadow-sm h-100">
                <div class="card-body">
                    <div class="mb-2"><i class="bi bi-cash-stack text-success" style="font-size:2rem;"></i></div>
                    <h3 class="text-success mb-0">Rs {{ number_format($distributor->total_sales, 2) }}</h3>
                    <div class="text-muted">Total Sales</div>
                </div>
                    </div>
                </div>
                <div class="col-md-3">
            <div class="card text-center shadow-sm h-100">
                <div class="card-body">
                    <div class="mb-2"><i class="bi bi-award-fill text-warning" style="font-size:2rem;"></i></div>
                    @php $computedCommission = $distributor->total_sales * ($distributor->commission_rate ?? 0) / 100; @endphp
                    <h3 class="text-warning mb-0">Rs {{ number_format($computedCommission, 2) }}</h3>
                    <div class="text-muted">Total Commission</div>
                </div>
            </div>
        </div>
    </div>
    <!-- Financial Summary -->
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card text-center shadow-sm h-100">
                <div class="card-body">
                    <div class="mb-2"><i class="bi bi-wallet2 text-success" style="font-size:2rem;"></i></div>
                    @php
                        $paidCommission = $distributor->payments()->where('type', 'commission')->where('status', 'completed')->sum('amount');
                        if ($paidCommission > 0) {
                            $remainingCommission = max($distributor->total_commission - $paidCommission, 0);
                        } else {
                            $remainingCommission = $distributor->total_commission;
                        }
                    @endphp
                    <h4 class="text-success mb-0">Rs {{ number_format($remainingCommission, 2) }}</h4>
                    <div class="text-muted">Remaining Commission</div>
                    <!-- Pay Commission Button -->
                    <button class="btn btn-outline-primary btn-sm mt-2" data-bs-toggle="modal" data-bs-target="#payCommissionModal">
                        <i class="bi bi-cash-coin"></i> Pay Commission
                    </button>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-center shadow-sm h-100">
        <div class="card-body">
                    <div class="mb-2"><i class="bi bi-currency-exchange text-info" style="font-size:2rem;"></i></div>
                    <h4 class="text-info mb-0">Rs {{ number_format($paidCommission, 2) }}</h4>
                    <div class="text-muted">Paid Commission</div>
                </div>
                    </div>
                </div>
                <div class="col-md-4">
            <div class="card text-center shadow-sm h-100">
                <div class="card-body">
                    <div class="mb-2"><i class="bi bi-exclamation-circle-fill text-danger" style="font-size:2rem;"></i></div>
                    @php $outstanding = $shopkeepers->sum(function($s) { return $s->outstanding_balance; }); @endphp
                    <h4 class="text-danger mb-0">Rs {{ number_format($outstanding, 2) }}</h4>
                    <div class="text-muted">Outstanding Balance</div>
                </div>
            </div>
        </div>
    </div>
    <!-- Pay Commission Modal -->
    <div class="modal fade" id="payCommissionModal" tabindex="-1" aria-labelledby="payCommissionModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <form method="POST" action="{{ route('distributors.payCommission', $distributor) }}">
            @csrf
            <input type="hidden" name="distributor_id" value="{{ $distributor->id }}">
            <input type="hidden" name="type" value="commission">
            <input type="hidden" name="status" value="completed">
            <div class="modal-header">
              <h5 class="modal-title" id="payCommissionModalLabel">Pay Commission to {{ $distributor->name }}</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <div class="mb-3">
                <label for="commission_amount" class="form-label">Amount</label>
                <input type="number" step="0.01" min="0" name="amount" id="commission_amount" class="form-control" required>
              </div>
              <div class="mb-3">
                <label for="commission_payment_date" class="form-label">Payment Date</label>
                <input type="date" name="payment_date" id="commission_payment_date" class="form-control" value="{{ date('Y-m-d') }}" required>
              </div>
              <div class="mb-3">
                <label for="commission_description" class="form-label">Description</label>
                <textarea name="description" id="commission_description" class="form-control" rows="2"></textarea>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
              <button type="submit" class="btn btn-primary">Pay</button>
            </div>
          </form>
        </div>
      </div>
    </div>
    <!-- Commission Payment History Table -->
    <div class="card mb-4 shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Commission Payment History</h5>
        </div>
        <div class="card-body">
            @php $commissionPayments = $distributor->payments()->where('type', 'commission')->orderByDesc('payment_date')->get(); @endphp
            @if($commissionPayments->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Date</th>
                                <th>Amount</th>
                                <th>Note</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($commissionPayments as $payment)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($payment->payment_date)->format('M d, Y') }}</td>
                                <td>Rs {{ number_format($payment->amount, 2) }}</td>
                                <td>{{ $payment->description }}</td>
                                <td>
                                    <!-- Edit Button -->
                                    <button class="btn btn-sm btn-outline-warning" title="Edit" data-bs-toggle="modal" data-bs-target="#editCommissionModal{{ $payment->id }}"><i class="bi bi-pencil"></i></button>
                                    <!-- Delete Button -->
                                    <form action="{{ route('distributors.deleteCommission', ['distributor' => $distributor->id, 'distributorPayment' => $payment->id]) }}" method="POST" style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete" onclick="return confirm('Delete this commission payment?')"><i class="bi bi-trash"></i></button>
                                    </form>
                                    <!-- Edit Modal -->
                                    <div class="modal fade" id="editCommissionModal{{ $payment->id }}" tabindex="-1" aria-labelledby="editCommissionModalLabel{{ $payment->id }}" aria-hidden="true">
                                      <div class="modal-dialog">
                                        <div class="modal-content">
                                          <form method="POST" action="{{ route('distributors.updateCommission', ['distributor' => $distributor->id, 'distributorPayment' => $payment->id]) }}">
                                            @csrf
                                            <input type="hidden" name="distributor_id" value="{{ $distributor->id }}">
                                            <input type="hidden" name="type" value="commission">
                                            <input type="hidden" name="status" value="completed">
                                            <div class="modal-header">
                                              <h5 class="modal-title" id="editCommissionModalLabel{{ $payment->id }}">Edit Commission Payment</h5>
                                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                              <div class="mb-3">
                                                <label for="edit_commission_amount{{ $payment->id }}" class="form-label">Amount</label>
                                                <input type="number" step="0.01" min="0" name="amount" id="edit_commission_amount{{ $payment->id }}" class="form-control" value="{{ $payment->amount }}" required>
                                              </div>
                                              <div class="mb-3">
                                                <label for="edit_commission_payment_date{{ $payment->id }}" class="form-label">Payment Date</label>
                                                <input type="date" name="payment_date" id="edit_commission_payment_date{{ $payment->id }}" class="form-control" value="{{ $payment->payment_date->format('Y-m-d') }}" required>
                                              </div>
                                              <div class="mb-3">
                                                <label for="edit_commission_description{{ $payment->id }}" class="form-label">Description</label>
                                                <textarea name="description" id="edit_commission_description{{ $payment->id }}" class="form-control" rows="2">{{ $payment->description }}</textarea>
                                              </div>
                                            </div>
                                            <div class="modal-footer">
                                              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                              <button type="submit" class="btn btn-primary">Update</button>
                                            </div>
                                          </form>
                                        </div>
                                      </div>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-muted text-center">No commission payments recorded yet.</p>
            @endif
        </div>
    </div>
    <!-- Shopkeepers List -->
    <div class="card mb-4 shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Shopkeepers Managed by {{ $distributor->name }}</h5>
            <a href="{{ route('shopkeepers.create', ['distributor_id' => $distributor->id]) }}" class="btn btn-danger btn-sm"><i class="bi bi-plus-circle"></i> Add Shopkeeper</a>
        </div>
        <div class="card-body">
            @if($shopkeepers->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Name</th>
                                <th>Phone</th>
                                <th>Address</th>
                                <th>Total Sales</th>
                                <th>Outstanding Balance</th>
                                <th>Added Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($shopkeepers as $shopkeeper)
                            <tr>
                                <td>{{ $shopkeeper->name }}</td>
                                <td>{{ $shopkeeper->phone ?? '-' }}</td>
                                <td>{{ $shopkeeper->address ?? '-' }}</td>
                                <td>Rs {{ number_format($shopkeeper->total_sales, 2) }}</td>
                                <td class="fw-bold {{ $shopkeeper->outstanding_balance > 0 ? 'text-danger' : 'text-success' }}">Rs {{ number_format($shopkeeper->outstanding_balance, 2) }}</td>
                                <td>{{ $shopkeeper->created_at->format('M d, Y') }}</td>
                                <td>
                                    <a href="{{ route('shopkeepers.show', $shopkeeper) }}" class="btn btn-sm btn-outline-info" title="View"><i class="bi bi-eye"></i></a>
                                    <a href="{{ route('shopkeepers.edit', $shopkeeper) }}" class="btn btn-sm btn-outline-warning" title="Edit"><i class="bi bi-pencil"></i></a>
                                    <button class="btn btn-sm btn-outline-success" title="Receive Payment" data-bs-toggle="modal" data-bs-target="#receivePaymentModal{{ $shopkeeper->id }}"><i class="bi bi-cash-coin"></i></button>
                                </td>
                            </tr>
                            <!-- Receive Payment Modal for this shopkeeper -->
                            <div class="modal fade" id="receivePaymentModal{{ $shopkeeper->id }}" tabindex="-1" aria-labelledby="receivePaymentModalLabel{{ $shopkeeper->id }}" aria-hidden="true">
                              <div class="modal-dialog">
                                <div class="modal-content">
                                  <form class="receivePaymentForm" data-shopkeeper-id="{{ $shopkeeper->id }}">
                                    <div class="modal-header">
                                      <h5 class="modal-title" id="receivePaymentModalLabel{{ $shopkeeper->id }}">Receive Payment for {{ $shopkeeper->name }}</h5>
                                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                      <input type="hidden" name="shopkeeper_id" value="{{ $shopkeeper->id }}">
                                      <input type="hidden" name="distributor_id" value="{{ $shopkeeper->distributor_id }}">
                                      <input type="hidden" name="type" value="payment_made">
                                      <div class="mb-3">
                                        <label for="total_amount{{ $shopkeeper->id }}" class="form-label">Amount Received</label>
                                        <input type="number" step="0.01" name="total_amount" id="total_amount{{ $shopkeeper->id }}" class="form-control" min="0" required>
                                      </div>
                                      <div class="mb-3">
                                        <label for="transaction_date{{ $shopkeeper->id }}" class="form-label">Date</label>
                                        <input type="date" name="transaction_date" id="transaction_date{{ $shopkeeper->id }}" class="form-control" value="{{ date('Y-m-d') }}" required>
                                      </div>
                                      <div class="mb-3">
                                        <label for="description{{ $shopkeeper->id }}" class="form-label">Note</label>
                                        <textarea name="description" id="description{{ $shopkeeper->id }}" class="form-control" rows="2"></textarea>
                                      </div>
                                    </div>
                                    <div class="modal-footer">
                                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                      <button type="submit" class="btn btn-success">Save Payment</button>
                                    </div>
                                  </form>
                                </div>
                              </div>
                            </div>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-muted text-center">No shopkeepers found for this distributor.</p>
            @endif
        </div>
    </div>
    <!-- Recent Transactions (unchanged) -->
    @includeIf('distributors.partials.recent_transactions', ['distributor' => $distributor])
</div>
@endsection 
<style>
.text-purple { color: #6f42c1 !important; }
</style>
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
  document.querySelectorAll('.receivePaymentForm').forEach(function(form) {
    form.onsubmit = function(e) {
      e.preventDefault();
      var formData = new FormData(form);
      fetch("{{ route('shopkeeper-transactions.store') }}", {
        method: 'POST',
        headers: {
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: formData
      })
      .then(response => {
        if (response.ok) {
          return response.text();
        } else {
          return response.json().then(data => { throw data; });
        }
      })
      .then(() => window.location.reload())
      .catch((data) => {
        let msg = 'Error saving payment.';
        if (data && data.errors) {
          msg = Object.values(data.errors).flat().join('\n');
        }
        alert(msg);
      });
    };
  });
  // Edit Payment AJAX
  document.querySelectorAll('.editPaymentForm').forEach(function(form) {
    form.onsubmit = function(e) {
      e.preventDefault();
      var paymentId = form.getAttribute('data-payment-id');
      var formData = new FormData(form);
      fetch(`/shopkeeper-transactions/${paymentId}`, {
        method: 'POST',
        headers: {
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
          'X-HTTP-Method-Override': 'PUT'
        },
        body: formData
      })
      .then(response => {
        if (response.ok) {
          return response.text();
        } else {
          return response.json().then(data => { throw data; });
        }
      })
      .then(() => window.location.reload())
      .catch((data) => {
        let msg = 'Error updating payment.';
        if (data && data.errors) {
          msg = Object.values(data.errors).flat().join('\n');
        }
        alert(msg);
      });
    };
  });
  // Delete Payment AJAX
  document.querySelectorAll('.delete-payment-btn').forEach(function(btn) {
    btn.onclick = function() {
      if (!confirm('Are you sure you want to delete this payment?')) return;
      var paymentId = btn.getAttribute('data-payment-id');
      fetch(`/shopkeeper-transactions/${paymentId}`, {
        method: 'POST',
        headers: {
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
          'X-HTTP-Method-Override': 'DELETE'
        }
      })
      .then(response => {
        if (response.ok) {
          window.location.reload();
        } else {
          return response.json().then(data => { throw data; });
        }
      })
      .catch((data) => {
        let msg = 'Error deleting payment.';
        if (data && data.errors) {
          msg = Object.values(data.errors).flat().join('\n');
        }
        alert(msg);
      });
    };
  });
});
</script>
@endpush 