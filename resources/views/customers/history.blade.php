@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card mb-4 p-4 shadow-sm" style="border-radius: 14px; border: 1.5px solid #b71c1c; background: #fff;">
        <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between mb-2">
            <div>
                <div style="font-size:1.6em; font-weight:bold; color:#b71c1c;"><i class="bi bi-person-circle"></i> Customer History: <span style="color:#222;">{{ $customer->name }}</span></div>
                <div class="mt-2" style="font-size:1.08em;">
                    <span class="me-4"><strong>Type:</strong> <span style="color:#b71c1c;">{{ ucfirst($customer->type) }}</span></span>
                    <span class="me-4"><strong>Cell No:</strong> <span style="color:#b71c1c;">{{ $customer->cel_no }}</span></span>
                    <span class="me-4"><strong>Email:</strong> <span style="color:#b71c1c;">{{ $customer->email }}</span></span>
                    <span class="me-4"><strong>Address:</strong> <span style="color:#b71c1c;">{{ $customer->address }}</span></span>
                </div>
            </div>
            <div class="text-md-end mt-3 mt-md-0">
                <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#receivePaymentModal"><i class="bi bi-cash-coin"></i> Receive Payment</button>
                <a href="{{ route('customers.printHistory', $customer->id) }}" target="_blank" class="btn btn-secondary ms-2" title="Print Full History"><i class="bi bi-printer"></i></a>
            </div>
        </div>
        <div class="row text-center mt-3 mb-1 g-2">
            @php
                $totalSales = $sales->sum('total_amount');
                $totalReturns = 0;
                foreach ($sales as $sale) {
                    $totalReturns += $sale->returns->sum(function($ret) { return $ret->amount * $ret->quantity; });
                }
                $totalReceived = $payments->sum('amount_paid') + $sales->sum('amount_received');
                $balance = ($totalSales - $totalReturns) - $totalReceived;
            @endphp
            <div class="col-6 col-md-3">
                <div class="p-2 rounded" style="background:#f3e5e5; border:1.5px solid #b71c1c;">
                    <div style="font-size:1.1em; color:#b71c1c; font-weight:600;"><i class="bi bi-bag"></i> Total Sales</div>
                    <div style="font-size:1.15em; color:#222; font-weight:bold;">{{ number_format($totalSales, 2) }}</div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="p-2 rounded" style="background:#f3e5e5; border:1.5px solid #b71c1c;">
                    <div style="font-size:1.1em; color:#b71c1c; font-weight:600;"><i class="bi bi-arrow-counterclockwise"></i> Total Returns</div>
                    <div style="font-size:1.15em; color:#222; font-weight:bold;">{{ number_format($totalReturns, 2) }}</div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="p-2 rounded" style="background:#f3e5e5; border:1.5px solid #b71c1c;">
                    <div style="font-size:1.1em; color:#b71c1c; font-weight:600;"><i class="bi bi-cash-coin"></i> Total Received</div>
                    <div style="font-size:1.15em; color:#222; font-weight:bold;">{{ number_format($totalReceived, 2) }}</div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="p-2 rounded" style="background:#f3e5e5; border:1.5px solid #b71c1c;">
                    <div style="font-size:1.1em; color:#b71c1c; font-weight:600;"><i class="bi bi-wallet2"></i> Balance</div>
                    <div style="font-size:1.15em; color:#222; font-weight:bold;">{{ number_format($balance, 2) }}</div>
                </div>
            </div>
        </div>
    </div>
    <!-- Receive Payment Modal -->
    <div class="modal fade" id="receivePaymentModal" tabindex="-1" aria-labelledby="receivePaymentModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <form method="POST" action="{{ route('payments.store') }}">
            @csrf
            <div class="modal-header">
              <h5 class="modal-title" id="receivePaymentModalLabel">Receive Payment</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <input type="hidden" name="customer_id" value="{{ $customer->id }}">
              <div class="mb-3">
                <label for="amount_paid" class="form-label">Amount</label>
                <input type="number" class="form-control" name="amount_paid" id="amount_paid" min="1" step="0.01" required>
              </div>
              <div class="mb-3">
                <label for="payment_date" class="form-label">Date</label>
                <input type="date" class="form-control" name="payment_date" id="payment_date" value="{{ date('Y-m-d') }}" required>
              </div>
    <div class="mb-3">
                <label for="note" class="form-label">Note</label>
                <textarea class="form-control" name="note" id="note" rows="2"></textarea>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
              <button type="submit" class="btn btn-success">Record Payment</button>
            </div>
          </form>
        </div>
      </div>
    </div>
    <!-- Payment History Table -->
    <div class="card p-3 shadow-sm mb-4" style="border-radius: 12px; border: 1.5px solid #f3e5e5;">
      <div class="d-flex align-items-center mb-2">
        <div class="section-title" style="font-size:1.2em; color:#b71c1c; font-weight:600; cursor:pointer;" data-bs-toggle="collapse" data-bs-target="#paymentHistoryCollapse" aria-expanded="false" aria-controls="paymentHistoryCollapse">
            <i class="bi bi-cash-stack"></i> Payment History
            <button class="btn btn-sm btn-outline-secondary ms-2" type="button" data-bs-toggle="collapse" data-bs-target="#paymentHistoryCollapse" aria-expanded="false" aria-controls="paymentHistoryCollapse">
                <span class="collapsed">View</span><span class="collapse">Hide</span>
            </button>
        </div>
      </div>
      <div class="collapse" id="paymentHistoryCollapse">
      <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle mb-0" style="background:#fff;">
          <thead class="table-light">
            <tr style="background:#f3e5e5; color:#b71c1c;">
              <th>Date</th>
              <th>Amount</th>
              <th>Note</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            @foreach($payments as $payment)
            <tr>
              <td>{{ $payment->date ?? $payment->created_at->format('Y-m-d') }}</td>
              <td>{{ number_format($payment->amount_paid, 2) }}</td>
              <td>{{ $payment->note }}</td>
              <td>
                <!-- Edit Button -->
                <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editPaymentModal{{ $payment->id }}"><i class="bi bi-pencil"></i></button>
                <!-- Delete Button -->
                <form action="{{ route('payments.destroy', $payment->id) }}" method="POST" style="display:inline;">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete this payment?')"><i class="bi bi-trash"></i></button>
                </form>
                <!-- Print Button -->
                <a href="{{ route('payments.print', $payment->id) }}" class="btn btn-sm btn-secondary" target="_blank"><i class="bi bi-printer"></i></a>
              </td>
            </tr>
            <!-- Edit Payment Modal -->
            <div class="modal fade" id="editPaymentModal{{ $payment->id }}" tabindex="-1" aria-labelledby="editPaymentModalLabel{{ $payment->id }}" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <form method="POST" action="{{ route('payments.update', $payment->id) }}">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                      <h5 class="modal-title" id="editPaymentModalLabel{{ $payment->id }}">Edit Payment</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      <input type="hidden" name="customer_id" value="{{ $customer->id }}">
                      <div class="mb-3">
                        <label for="amount_paid_edit{{ $payment->id }}" class="form-label">Amount</label>
                        <input type="number" class="form-control" name="amount_paid" id="amount_paid_edit{{ $payment->id }}" min="1" step="0.01" value="{{ $payment->amount_paid }}" required>
                      </div>
                      <div class="mb-3">
                        <label for="payment_date_edit{{ $payment->id }}" class="form-label">Date</label>
                        <input type="date" class="form-control" name="payment_date" id="payment_date_edit{{ $payment->id }}" value="{{ $payment->date ?? $payment->created_at->format('Y-m-d') }}" required>
                      </div>
                      <div class="mb-3">
                        <label for="note_edit{{ $payment->id }}" class="form-label">Note</label>
                        <textarea class="form-control" name="note" id="note_edit{{ $payment->id }}" rows="2">{{ $payment->note }}</textarea>
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
      </div>
    </div>
    <!-- Sales History Dropdown -->
    <div class="card mb-4 p-3 shadow-sm" style="border-radius: 12px; border: 1.5px solid #f3e5e5;">
        <div class="d-flex align-items-center mb-2">
            <div class="section-title" style="font-size:1.2em; color:#b71c1c; font-weight:600; cursor:pointer;" data-bs-toggle="collapse" data-bs-target="#salesHistoryCollapse" aria-expanded="false" aria-controls="salesHistoryCollapse">
                <i class="bi bi-bag-check"></i> Sales History
                <button class="btn btn-sm btn-outline-secondary ms-2" type="button" data-bs-toggle="collapse" data-bs-target="#salesHistoryCollapse" aria-expanded="false" aria-controls="salesHistoryCollapse">
                    <span class="collapsed">View</span><span class="collapse">Hide</span>
                </button>
            </div>
        </div>
        <div class="collapse" id="salesHistoryCollapse">
        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle mb-0" style="background:#fff;">
                <thead class="table-light">
                    <tr style="background:#f3e5e5; color:#b71c1c;">
                <th>Sale Code</th>
                <th>Date</th>
                <th>Total</th>
                <th>Returned</th>
                <th>Outstanding</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($sales as $sale)
            <tr>
                <td>{{ $sale->sale_code }}</td>
                <td>{{ $sale->created_at->format('d-m-Y h:i A') }}</td>
                <td>{{ number_format($sale->total_amount, 2) }}</td>
                <td>{{ number_format($sale->total_returned, 2) }}</td>
                <td>{{ number_format($sale->outstanding, 2) }}</td>
                <td>
                            <a href="{{ route('sales.print', $sale->id) }}" class="btn btn-sm btn-danger" target="_blank"><i class="bi bi-printer"></i> Print</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
        </div>
        </div>
    </div>
    <!-- Payments & Returns Timeline Dropdown -->
    <div class="card p-3 shadow-sm mb-4" style="border-radius: 12px; border: 1.5px solid #f3e5e5;">
        <div class="d-flex align-items-center mb-2">
            <div class="section-title" style="font-size:1.2em; color:#b71c1c; font-weight:600; cursor:pointer;" data-bs-toggle="collapse" data-bs-target="#timelineCollapse" aria-expanded="false" aria-controls="timelineCollapse">
                <i class="bi bi-clock-history"></i> Payments & Returns Timeline
                <button class="btn btn-sm btn-outline-secondary ms-2" type="button" data-bs-toggle="collapse" data-bs-target="#timelineCollapse" aria-expanded="false" aria-controls="timelineCollapse">
                    <span class="collapsed">View</span><span class="collapse">Hide</span>
                </button>
            </div>
        </div>
        <div class="collapse" id="timelineCollapse">
        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle mb-0" style="background:#fff;">
                <thead class="table-light">
                    <tr style="background:#f3e5e5; color:#b71c1c;">
                <th>Date</th>
                <th>Description</th>
                <th>Amount</th>
                <th>Running Balance</th>
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
                                'date' => $pay->created_at,
                                'desc' => 'Payment',
                                'amount' => -$pay->amount_paid,
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
@endsection 