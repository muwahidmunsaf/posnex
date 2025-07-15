@extends('layouts.app')
<!-- FontAwesome CDN for icons (no integrity attribute for compatibility) -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />

@section('content')
<style>
/* Modern Overview Cards */
.customer-cards-row {
    display: flex;
    gap: 24px;
    justify-content: flex-start;
    flex-wrap: wrap;
    margin-bottom: 2rem;
}
.customer-card {
    flex: 1 1 160px;
    min-width: 160px;
    max-width: 240px;
    background: #fff;
    border-radius: 18px;
    box-shadow: 0 4px 16px rgba(60,72,88,0.08);
    display: flex;
    align-items: center;
    padding: 1.1rem 0.8rem;
    position: relative;
    overflow: hidden;
    transition: box-shadow 0.2s, transform 0.2s;
}
.customer-card:hover {
    box-shadow: 0 8px 24px rgba(60,72,88,0.16);
    transform: translateY(-2px) scale(1.02);
}
.customer-card .card-icon {
    font-size: 1.5rem;
    margin-right: 0.8rem;
    flex-shrink: 0;
    display: flex;
    align-items: center;
    justify-content: center;
}
.customer-card.total-customers .card-icon { color: #1976d2; }
.customer-card.total-sales .card-icon { color: #1976d2; }
.customer-card.total-received .card-icon { color: #43a047; }
.customer-card.total-balance .card-icon { color: #ff9800; }
.customer-card .card-content { flex: 1; }
.customer-card .card-label { font-size: 0.98rem; color: #888; font-weight: 500; margin-bottom: 0.2rem; }
.customer-card .card-value { font-size: 1.25rem; font-weight: 700; color: #222; letter-spacing: 0.5px; }
@media (max-width: 1200px) {
    .customer-cards-row { flex-wrap: wrap; }
    .customer-card { min-width: 160px; max-width: 100%; }
}
@media (max-width: 900px) {
    .customer-cards-row { flex-direction: column; gap: 18px; }
    .customer-card { max-width: 100%; }
}
@media print {
    body * { visibility: hidden !important; }
    .table-responsive, .table-responsive * { visibility: visible !important; }
    .table-responsive { position: absolute; left: 0; top: 0; width: 100%; }
    .sidebar, .navbar, .btn, form, .alert, h3, .container > *:not(.table-responsive) { display: none !important; }
    .print-address { display: table-cell !important; }
    .no-print { display: none !important; }
}
@media screen {
    .print-address { display: none !important; }
}
</style>
<div class="container">
    <div class="d-flex flex-wrap align-items-center justify-content-between mb-3" style="gap: 1rem;">
        <h3 class="mb-0" style="font-weight:700;color:#b71c1c;letter-spacing:1px;display:flex;align-items:center;gap:10px;">
            <i class="fa-solid fa-users-viewfinder" style="color:#b71c1c;font-size:1.7rem;"></i> Customers
        </h3>
        <div class="d-flex flex-wrap align-items-center gap-2" style="gap: 0.7rem;">
            <a href="{{ route('customers.create') }}" class="btn btn-primary d-flex align-items-center justify-content-center" title="Add Customer" style="width:40px;height:40px;padding:0;font-size:1.3rem;"><i class="fa fa-plus"></i></a>
            <a href="{{ route('customers.printAll') }}" target="_blank" class="btn btn-secondary d-flex align-items-center justify-content-center" id="print-all-customers-btn" title="Print All" style="width:40px;height:40px;padding:0;font-size:1.3rem;"><i class="fa fa-print"></i></a>
            <!-- Search Icon with Popover -->
            <button type="button" class="btn btn-outline-secondary d-flex align-items-center justify-content-center" id="searchPopoverBtn" title="Search by City" style="width:40px;height:40px;padding:0;font-size:1.3rem;">
                <i class="fa fa-search"></i>
            </button>
            <div id="searchPopover" class="card shadow p-3" style="position:absolute;right:60px;top:60px;min-width:220px;z-index:1050;display:none;">
                <form method="GET" action="{{ route('customers.index') }}" class="mb-0" id="customer-city-search-form-popover">
                    <div class="mb-2">
                        <label for="city" class="form-label mb-1">City</label>
                        <input type="text" name="city" id="city" class="form-control form-control-sm" value="{{ request('city') }}" placeholder="Enter city name">
                    </div>
                    <button type="submit" class="btn btn-sm btn-primary w-100"><i class="fa fa-search me-1"></i> Search</button>
                </form>
            </div>
            <!-- Filter Icon with Popover -->
            <button type="button" class="btn btn-outline-secondary d-flex align-items-center justify-content-center" id="filterPopoverBtn" title="Filter" style="width:40px;height:40px;padding:0;font-size:1.3rem;">
                <i class="fa fa-filter"></i>
            </button>
            <div id="filterPopover" class="card shadow p-3" style="position:absolute;right:10px;top:60px;min-width:220px;z-index:1050;display:none;">
                <form method="GET" action="{{ route('customers.index') }}" class="mb-0" id="customer-date-filter-form-popover">
                    <div class="mb-2">
                        <label for="from" class="form-label mb-1">From</label>
                        <input type="date" name="from" id="from" class="form-control form-control-sm" value="{{ request('from') }}">
                    </div>
                    <div class="mb-2">
                        <label for="to" class="form-label mb-1">To</label>
                        <input type="date" name="to" id="to" class="form-control form-control-sm" value="{{ request('to') }}">
                    </div>
                    <button type="submit" class="btn btn-sm btn-primary w-100"><i class="fa fa-filter me-1"></i> Filter</button>
                </form>
            </div>
        </div>
    </div>
    <!-- Modern Overview Cards Row -->
    <div class="customer-cards-row">
        <div class="customer-card total-customers">
            <span class="card-icon"><i class="fa-solid fa-users"></i></span>
            <div class="card-content">
                <div class="card-label">Total Customers</div>
                <div class="card-value">{{ $totalCustomers }}</div>
            </div>
        </div>
        <div class="customer-card total-sales">
            <span class="card-icon"><i class="fa-solid fa-chart-line"></i></span>
            <div class="card-content">
                <div class="card-label">Total Sales</div>
                <div class="card-value">Rs. {{ number_format($totalSales, 2) }}</div>
            </div>
        </div>
        <div class="customer-card total-received">
            <span class="card-icon"><i class="fa-solid fa-wallet"></i></span>
            <div class="card-content">
                <div class="card-label">Total Received Amount</div>
                <div class="card-value">Rs. {{ number_format($totalReceived, 2) }}</div>
            </div>
        </div>
        <div class="customer-card total-balance">
            <span class="card-icon"><i class="fa-solid fa-flag-checkered"></i></span>
            <div class="card-content">
                <div class="card-label">Total Balance</div>
                <div class="card-value">Rs. {{ number_format($totalBalance, 2) }}</div>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($customers->count())
    <div class="table-responsive">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Name</th>
                <th>Type</th>
                <th>Cell No</th>
                <th>City</th>
                <th>Total Sale</th>
                <th>Received</th>
                <th>Balance</th>
                <th class="no-print">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($customers as $customer)
            <tr>
                <td>{{ $customer->name }}</td>
                <td>{{ ucfirst($customer->type) }}</td>
                <td>{{ $customer->cel_no }}</td>
                <td>{{ $customer->city }}</td>
                <td>{{ number_format($customer->sales->sum('total_amount'), 2) }}</td>
                <td>{{ number_format($customer->payments->sum('amount_paid') + $customer->sales->sum('amount_received'), 2) }}</td>
                <td>{{ number_format($customer->sales->sum('total_amount') - ($customer->payments->sum('amount_paid') + $customer->sales->sum('amount_received')), 2) }}</td>
                <td class="no-print">
                    <a href="{{ route('customers.edit', $customer->id) }}" class="btn btn-sm btn-warning" title="Edit"><i class="bi bi-pencil"></i></a>
                    <a href="{{ route('customers.history', $customer->id) }}" class="btn btn-sm btn-info ms-1" title="View History"><i class="bi bi-eye"></i></a>
                    <a href="{{ route('customers.printHistory', $customer->id) }}" class="btn btn-sm btn-secondary ms-1" target="_blank" title="Print History" data-customer-print><i class="bi bi-printer"></i></a>
                    <button type="button" class="btn btn-sm btn-danger ms-1" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $customer->id }}" title="Delete"><i class="bi bi-trash"></i></button>
                    <!-- Modal -->
                    <div class="modal fade" id="deleteModal{{ $customer->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $customer->id }}" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-top">
                            <div class="modal-header">
                                <h5 class="modal-title" id="deleteModalLabel{{ $customer->id }}">Confirm Delete</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                Are you sure you want to delete <strong>{{ $customer->name }}</strong>?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <form action="{{ route('customers.destroy', $customer->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Yes, Delete</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- End modal -->
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    </div>
    {{ $customers->links('vendor.pagination.bootstrap-5') }}
    @else
    <p>No customers found.</p>
    @endif
</div>
@endsection

@push('scripts')
<script>
function printPaymentHistory(elementId) {
    var printContents = document.getElementById(elementId).innerHTML;
    var originalContents = document.body.innerHTML;
    document.body.innerHTML = printContents;
    window.print();
    document.body.innerHTML = originalContents;
    location.reload();
}
// Update Print All button to include date range
const printAllBtn = document.getElementById('print-all-customers-btn');
if (printAllBtn) {
    printAllBtn.onclick = function(e) {
        const from = document.getElementById('from').value;
        const to = document.getElementById('to').value;
        let url = printAllBtn.getAttribute('href');
        const params = [];
        if (from) params.push('from=' + encodeURIComponent(from));
        if (to) params.push('to=' + encodeURIComponent(to));
        if (params.length) url += (url.includes('?') ? '&' : '?') + params.join('&');
        printAllBtn.setAttribute('href', url);
    };
}
// Update print icon for each customer to include date range
    document.querySelectorAll('a[data-customer-print]').forEach(function(btn) {
        btn.onclick = function(e) {
            e.preventDefault();
            const from = document.getElementById('from').value;
            const to = document.getElementById('to').value;
            let url = btn.getAttribute('href');
            const params = [];
            if (from) params.push('from=' + encodeURIComponent(from));
            if (to) params.push('to=' + encodeURIComponent(to));
            if (params.length) url += (url.includes('?') ? '&' : '?') + params.join('&');
            window.open(url, '_blank');
        };
    });
// Search popover logic
const searchBtn = document.getElementById('searchPopoverBtn');
const searchPopover = document.getElementById('searchPopover');
document.addEventListener('click', function(e) {
    if (searchBtn && searchPopover) {
        if (searchBtn.contains(e.target)) {
            searchPopover.style.display = searchPopover.style.display === 'block' ? 'none' : 'block';
        } else if (!searchPopover.contains(e.target)) {
            searchPopover.style.display = 'none';
        }
    }
});
// Filter popover logic
const filterBtn = document.getElementById('filterPopoverBtn');
const filterPopover = document.getElementById('filterPopover');
document.addEventListener('click', function(e) {
    if (filterBtn && filterPopover) {
        if (filterBtn.contains(e.target)) {
            filterPopover.style.display = filterPopover.style.display === 'block' ? 'none' : 'block';
        } else if (!filterPopover.contains(e.target)) {
            filterPopover.style.display = 'none';
        }
    }
});
</script>
@endpush
