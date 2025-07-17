@extends('layouts.app')
@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <a href="{{ route('distributors.history', ['distributor' => $shopkeeper->distributor_id]) }}" class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-arrow-left"></i> Back to Distributor
        </a>
        <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#receivePaymentModal">
            <i class="bi bi-cash-coin"></i> Receive Payment
        </button>
    </div>
    <!-- Shopkeeper Details Modern Card -->
    <div class="card mb-4 shadow-sm p-3" style="background: linear-gradient(90deg, #f8fafc 60%, #e3e6f3 100%);">
        <div class="row align-items-center g-0">
            <div class="col-auto pe-0">
                <div class="d-flex flex-column align-items-center justify-content-center" style="height:100%">
                    <div class="avatar bg-primary text-white rounded-circle mb-2" style="width:72px;height:72px;display:flex;align-items:center;justify-content:center;font-size:2.5rem;box-shadow:0 2px 8px #0001;">
                        {{ strtoupper(substr($shopkeeper->name,0,1)) }}
                    </div>
                </div>
            </div>
            <div class="col ps-4">
                <h3 class="mb-1 fw-bold">{{ $shopkeeper->name }}</h3>
                <div class="mb-2">
                    <span class="me-3"><i class="bi bi-telephone text-primary"></i> <span class="fw-semibold">{{ $shopkeeper->phone ?? '-' }}</span></span>
                    <span class="me-3"><i class="bi bi-geo-alt text-danger"></i> <span class="fw-semibold">{{ $shopkeeper->address ?? '-' }}</span></span>
                </div>
                <div class="mb-2">
                    <span class="me-3"><i class="bi bi-truck text-warning"></i> Distributor: <a href="{{ route('distributors.history', ['distributor' => $shopkeeper->distributor_id]) }}" class="fw-semibold text-decoration-underline" style="color:#b71c1c;">{{ $shopkeeper->distributor->name ?? '-' }}</a></span>
                    <span><i class="bi bi-calendar-event text-info"></i> Added: <span class="fw-semibold">{{ $shopkeeper->created_at->format('M d, Y') }}</span></span>
                </div>
            </div>
            <div class="col-auto d-flex flex-column align-items-end justify-content-center">
                <a href="{{ route('shopkeepers.edit', $shopkeeper) }}" class="btn btn-warning btn-sm mb-2" title="Edit Shopkeeper"><i class="bi bi-pencil"></i></a>
                <form action="{{ route('shopkeepers.destroy', $shopkeeper) }}" method="POST" style="display:inline-block;">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Delete this shopkeeper?')" title="Delete Shopkeeper"><i class="bi bi-trash"></i></button>
                </form>
            </div>
        </div>
    </div>
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card text-center shadow-sm">
                <div class="card-body">
                    <i class="bi bi-cash-stack text-success" style="font-size:2rem;"></i>
                    <h5 class="mb-0">Rs {{ number_format($totalSales, 2) }}</h5>
                    <div class="text-muted">Total Sales</div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-center shadow-sm">
                <div class="card-body">
                    <i class="bi bi-wallet2 text-primary" style="font-size:2rem;"></i>
                    <h5 class="mb-0 {{ $shopkeeper->outstanding_balance > 0 ? 'text-danger' : 'text-success' }}">Rs {{ number_format($shopkeeper->outstanding_balance, 2) }}</h5>
                    <div class="text-muted">Balance</div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-center shadow-sm">
                <div class="card-body">
                    <i class="bi bi-flag text-info" style="font-size:2rem;"></i>
                    <h5 class="mb-0">Rs {{ number_format(optional($shopkeeper->transactions()->where('type', 'product_sold')->where('description', 'Opening Outstanding')->latest()->first())->total_amount ?? 0, 2) }}</h5>
                    <div class="text-muted">Opening Outstanding</div>
                </div>
            </div>
        </div>
    </div>
    <div class="card mb-4 shadow-sm">
        <div class="card-header bg-light">
            <h5 class="mb-0"><i class="bi bi-receipt"></i> Sales (POS)</h5>
        </div>
        <div class="card-body">
            @if($sales->count())
            <div class="table-responsive">
                <table class="table table-bordered align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Sale Code</th>
                            <th>Date</th>
                            <th>Total</th>
                            <th>Received</th>
                            <th>Outstanding</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($sales as $sale)
                        <tr>
                            <td>{{ $sale->sale_code }}</td>
                            <td>{{ $sale->created_at->format('d-m-Y h:i A') }}</td>
                            <td>Rs {{ number_format($sale->total_amount, 2) }}</td>
                            <td>Rs {{ number_format($sale->amount_received ?? 0, 2) }}</td>
                            <td class="fw-bold {{ ($sale->total_amount - ($sale->amount_received ?? 0)) > 0 ? 'text-danger' : 'text-success' }}">Rs {{ number_format($sale->total_amount - ($sale->amount_received ?? 0), 2) }}</td>
                            <td>
                                <a href="{{ route('sales.print', $sale->id) }}" class="btn btn-sm btn-primary" target="_blank" title="Print"><i class="bi bi-printer"></i></a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
                <div class="text-center text-muted">
                    <i class="bi bi-emoji-frown" style="font-size:2rem;"></i>
                    <div>No sales found for this shopkeeper.</div>
                </div>
            @endif
        </div>
    </div>
    <div class="card mb-4 shadow-sm">
        <div class="card-header bg-light">
            <h5 class="mb-0"><i class="bi bi-clock-history"></i> Payment History</h5>
        </div>
        <div class="card-body">
            @php
                $openingOutstanding = $shopkeeper->transactions()->where('type', 'product_sold')->where('description', 'Opening Outstanding')->latest()->first();
                $payments = $shopkeeper->transactions()->where('type', 'payment_made')->orderByDesc('transaction_date')->get();
            @endphp
            @if($payments->count())
            <div class="table-responsive">
                <table class="table table-bordered align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Date</th>
                            <th>Amount</th>
                            <th>Note</th>
                            <th>Commission</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($payments as $payment)
                        <tr>
                            <td>{{ $payment->transaction_date->format('d-m-Y') }}</td>
                            <td>Rs {{ number_format($payment->total_amount, 2) }}</td>
                            <td>{{ $payment->description }}</td>
                            <td><span class="badge bg-success">Rs {{ number_format($payment->commission_amount, 2) }}</span></td>
                            <td>
                                <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editPaymentModal{{ $payment->id }}" title="Edit"><i class="bi bi-pencil"></i></button>
                                <button class="btn btn-sm btn-danger delete-payment-btn" data-payment-id="{{ $payment->id }}" title="Delete"><i class="bi bi-trash"></i></button>
                            </td>
                        </tr>
                        <!-- Edit Payment Modal -->
                        <div class="modal fade" id="editPaymentModal{{ $payment->id }}" tabindex="-1" aria-labelledby="editPaymentModalLabel{{ $payment->id }}" aria-hidden="true">
                          <div class="modal-dialog">
                            <div class="modal-content">
                              <form class="editPaymentForm" data-payment-id="{{ $payment->id }}">
                                <div class="modal-header">
                                  <h5 class="modal-title" id="editPaymentModalLabel{{ $payment->id }}">Edit Payment</h5>
                                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                  <input type="hidden" name="shopkeeper_id" value="{{ $shopkeeper->id }}">
                                  <input type="hidden" name="distributor_id" value="{{ $shopkeeper->distributor_id }}">
                                  <input type="hidden" name="type" value="payment_made">
                                  <div class="mb-3">
                                    <label for="edit_total_amount{{ $payment->id }}" class="form-label">Amount Received</label>
                                    <input type="number" step="0.01" name="total_amount" id="edit_total_amount{{ $payment->id }}" class="form-control" min="0" required value="{{ $payment->total_amount }}">
                                  </div>
                                  <div class="mb-3">
                                    <label for="edit_transaction_date{{ $payment->id }}" class="form-label">Date</label>
                                    <input type="date" name="transaction_date" id="edit_transaction_date{{ $payment->id }}" class="form-control" value="{{ $payment->transaction_date->format('Y-m-d') }}" required>
                                  </div>
                                  <div class="mb-3">
                                    <label for="edit_description{{ $payment->id }}" class="form-label">Note</label>
                                    <textarea name="description" id="edit_description{{ $payment->id }}" class="form-control" rows="2">{{ $payment->description }}</textarea>
                                  </div>
                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                  <button type="submit" class="btn btn-success">Update Payment</button>
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
                <div class="text-center text-muted">
                    <i class="bi bi-emoji-frown" style="font-size:2rem;"></i>
                    <div>No payments found for this shopkeeper.</div>
                </div>
            @endif
        </div>
    </div>
    <!-- After Payment History, add Payment & Return Timeline -->
    <div class="card mb-4 shadow-sm">
        <div class="card-header bg-light">
            <h5 class="mb-0"><i class="bi bi-clock-history"></i> Payment & Return Timeline</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Date</th>
                            <th>Description</th>
                            <th>Amount</th>
                            <th>Balance</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $events = [];
                            foreach ($sales as $sale) {
                                $events[] = [
                                    'type' => 'sale',
                                    'date' => $sale->created_at,
                                    'desc' => 'Sale: ' . $sale->sale_code,
                                    'amount' => $sale->total_amount,
                                ];
                                foreach ($sale->returns as $ret) {
                                    $events[] = [
                                        'type' => 'return',
                                        'date' => $ret->created_at,
                                        'desc' => 'Return: ' . ($ret->item->item_name ?? '-') . ' x' . $ret->quantity,
                                        'amount' => -($ret->amount * $ret->quantity),
                                    ];
                                }
                            }
                            foreach ($payments as $pay) {
                                $events[] = [
                                    'type' => 'payment',
                                    'date' => $pay->transaction_date,
                                    'desc' => 'Payment',
                                    'amount' => -$pay->total_amount,
                                ];
                            }
                            usort($events, function($a, $b) { return $a['date'] <=> $b['date']; });
                            $runningBalance = 0;
                        @endphp
                        @foreach($events as $event)
                            @php $runningBalance += $event['amount']; @endphp
                            <tr>
                                <td>{{ $event['date']->format('d-m-Y h:i A') }}</td>
                                <td>{{ $event['desc'] }}</td>
                                <td>{{ number_format($event['amount'], 2) }}</td>
                                <td>{{ number_format($runningBalance, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

    <!-- Receive Payment Modal -->
    <div class="modal fade" id="receivePaymentModal" tabindex="-1" aria-labelledby="receivePaymentModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <form id="receivePaymentForm">
            <div class="modal-header">
              <h5 class="modal-title" id="receivePaymentModalLabel">Receive Payment</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <input type="hidden" name="shopkeeper_id" value="{{ $shopkeeper->id }}">
              <input type="hidden" name="distributor_id" value="{{ $shopkeeper->distributor_id }}">
              <input type="hidden" name="type" value="payment_made">
              <input type="hidden" name="status" value="completed">
              <div class="mb-3">
                <label for="total_amount" class="form-label">Amount Received</label>
                <input type="number" step="0.01" name="total_amount" id="total_amount" class="form-control" min="0" required>
              </div>
              <div class="mb-3">
                <label for="transaction_date" class="form-label">Date</label>
                <input type="date" name="transaction_date" id="transaction_date" class="form-control" value="{{ date('Y-m-d') }}" required>
              </div>
              <div class="mb-3">
                <label for="description" class="form-label">Note</label>
                <textarea name="description" id="description" class="form-control" rows="2"></textarea>
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

    <script>
    document.addEventListener('DOMContentLoaded', function() {
      var form = document.getElementById('receivePaymentForm');
      if (form) {
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
          .then(async response => {
            if (response.ok) {
              alert('Payment saved successfully!');
              setTimeout(() => window.location.reload(), 800);
              return response.text();
            } else {
              let data;
              try { data = await response.json(); } catch { data = null; }
              throw data;
            }
          })
          .catch((data) => {
            let msg = 'Error saving payment.';
            if (data && data.errors) {
              msg = Object.values(data.errors).flat().join('\n');
            } else if (data && data.message) {
              msg = data.message;
            }
            alert(msg);
          });
        };
      }
    });
    </script>
@endsection 
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
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
      .then(async response => {
        if (response.ok) {
          alert('Payment deleted successfully!');
          setTimeout(() => window.location.reload(), 800);
        } else {
          let data;
          try { data = await response.json(); } catch { data = null; }
          throw data;
        }
      })
      .catch((data) => {
        let msg = 'Error deleting payment.';
        if (data && data.errors) {
          msg = Object.values(data.errors).flat().join('\n');
        } else if (data && data.message) {
          msg = data.message;
        }
        alert(msg);
      });
    };
  });
});
</script>
@endpush 