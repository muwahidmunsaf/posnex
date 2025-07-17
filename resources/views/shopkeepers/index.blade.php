@extends('layouts.app')
<!-- FontAwesome CDN for icons (no integrity attribute for compatibility) -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />

@section('content')
<style>
.shopkeeper-cards-row {
    display: flex;
    gap: 24px;
    justify-content: flex-start;
    flex-wrap: wrap;
    margin-bottom: 2rem;
}
.shopkeeper-card {
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
.shopkeeper-card:hover {
    box-shadow: 0 8px 24px rgba(60,72,88,0.16);
    transform: translateY(-2px) scale(1.02);
}
.shopkeeper-card .card-icon {
    font-size: 1.5rem;
    margin-right: 0.8rem;
    flex-shrink: 0;
    display: flex;
    align-items: center;
    justify-content: center;
}
.shopkeeper-card.total-shopkeepers .card-icon { color: #8e24aa; }
.shopkeeper-card.total-sales .card-icon { color: #1976d2; }
.shopkeeper-card.total-received .card-icon { color: #43a047; }
.shopkeeper-card.total-balance .card-icon { color: #b71c1c; }
.shopkeeper-card .card-content { flex: 1; }
.shopkeeper-card .card-label { font-size: 0.98rem; color: #888; font-weight: 500; margin-bottom: 0.2rem; }
.shopkeeper-card .card-value { font-size: 1.25rem; font-weight: 700; color: #222; letter-spacing: 0.5px; }
@media (max-width: 1200px) {
    .shopkeeper-cards-row { flex-wrap: wrap; }
    .shopkeeper-card { min-width: 160px; max-width: 100%; }
}
@media (max-width: 900px) {
    .shopkeeper-cards-row { flex-direction: column; gap: 18px; }
    .shopkeeper-card { max-width: 100%; }
}
</style>
<div class="container">
    <div class="d-flex flex-wrap align-items-center justify-content-between mb-3" style="gap: 1rem;">
        <h3 class="mb-0" style="font-weight:700;color:#8e24aa;letter-spacing:1px;display:flex;align-items:center;gap:10px;">
            <i class="fa-solid fa-store" style="color:#8e24aa;font-size:1.7rem;"></i> Shopkeepers
        </h3>
        <div class="d-flex flex-wrap align-items-center gap-2" style="gap: 0.7rem;">
            <a href="{{ route('shopkeepers.create', ['distributor_id' => $distributor_id]) }}" class="btn btn-primary d-flex align-items-center justify-content-center" title="Add Shopkeeper" style="width:40px;height:40px;padding:0;font-size:1.3rem;"><i class="fa fa-plus"></i></a>
            <a href="{{ route('shopkeepers.printAll', array_filter(['from' => request('from'), 'to' => request('to'), 'distributor_id' => $distributor_id])) }}" target="_blank" id="print-all-shopkeepers-btn" class="btn btn-secondary d-flex align-items-center justify-content-center" title="Print All" style="width:40px;height:40px;padding:0;font-size:1.3rem;"><i class="fa fa-print"></i></a>
            <!-- Search Icon with Popover -->
            <button type="button" class="btn btn-outline-secondary d-flex align-items-center justify-content-center" id="searchPopoverBtn" title="Search by Name" style="width:40px;height:40px;padding:0;font-size:1.3rem;">
                <i class="fa fa-search"></i>
            </button>
            <div id="searchPopover" class="card shadow p-3" style="position:absolute;right:60px;top:60px;min-width:220px;z-index:1050;display:none;">
                <form method="GET" action="{{ route('shopkeepers.index') }}" class="mb-0" id="shopkeeper-name-search-form-popover">
                    <div class="mb-2">
                        <label for="name" class="form-label mb-1">Name</label>
                        <input type="text" name="name" id="name" class="form-control form-control-sm" value="{{ request('name') }}" placeholder="Enter shopkeeper name">
                    </div>
                    <button type="submit" class="btn btn-sm btn-primary w-100"><i class="fa fa-search me-1"></i> Search</button>
                </form>
            </div>
            <!-- Filter Icon with Popover -->
            <button type="button" class="btn btn-outline-secondary d-flex align-items-center justify-content-center" id="filterPopoverBtn" title="Filter" style="width:40px;height:40px;padding:0;font-size:1.3rem;">
                <i class="fa fa-filter"></i>
            </button>
            <div id="filterPopover" class="card shadow p-3" style="position:absolute;right:10px;top:60px;min-width:220px;z-index:1050;display:none;">
                <form method="GET" action="{{ route('shopkeepers.index') }}" class="mb-0" id="shopkeeper-date-filter-form-popover">
                    <div class="mb-2">
                        <label for="from" class="form-label mb-1">From</label>
                        <input type="date" name="from" id="from" class="form-control form-control-sm" value="{{ request('from') }}">
                    </div>
                    <div class="mb-2">
                        <label for="to" class="form-label mb-1">To</label>
                        <input type="date" name="to" id="to" class="form-control form-control-sm" value="{{ request('to') }}">
                    </div>
                    @if($distributor_id)
                        <input type="hidden" name="distributor_id" value="{{ $distributor_id }}">
                    @endif
                    <button type="submit" class="btn btn-sm btn-primary w-100"><i class="fa fa-filter me-1"></i> Filter</button>
                    <button type="button" class="btn btn-sm btn-secondary w-100 mt-2" id="clear-date-filter"><i class="fa fa-times me-1"></i> Clear Filter</button>
                </form>
            </div>
        </div>
    </div>
    <!-- Modern Overview Cards Row -->
    <div class="shopkeeper-cards-row">
        <div class="shopkeeper-card total-shopkeepers">
            <span class="card-icon"><i class="fa-solid fa-user-group"></i></span>
            <div class="card-content">
                <div class="card-label">Total Shopkeepers</div>
                <div class="card-value">{{ $totalShopkeepers }}</div>
            </div>
        </div>
        <div class="shopkeeper-card total-sales">
            <span class="card-icon"><i class="fa-solid fa-chart-line"></i></span>
            <div class="card-content">
                <div class="card-label">Total Sales</div>
                <div class="card-value">Rs. {{ number_format($totalSales, 2) }}</div>
            </div>
        </div>
        <div class="shopkeeper-card total-received">
            <span class="card-icon"><i class="fa-solid fa-money-bill-wave"></i></span>
            <div class="card-content">
                <div class="card-label">Total Received Amount</div>
                <div class="card-value">Rs. {{ number_format($totalReceived, 2) }}</div>
            </div>
        </div>
        <div class="shopkeeper-card total-balance">
            <span class="card-icon"><i class="fa-solid fa-scale-balanced"></i></span>
            <div class="card-content">
                <div class="card-label">Total Balance</div>
                <div class="card-value">Rs. {{ number_format($totalBalance, 2) }}</div>
            </div>
        </div>
    </div>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <div class="card">
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Phone</th>
                        <th>Address</th>
                        <th>Distributor</th>
                        <th>Total Sales</th>
                        <th>Outstanding Sale</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($shopkeepers as $shopkeeper)
                    <tr>
                        <td>{{ $shopkeeper->name }}</td>
                        <td>{{ $shopkeeper->phone ?? '-' }}</td>
                        <td>{{ $shopkeeper->address ?? '-' }}</td>
                        <td>{{ $shopkeeper->distributor->name }}</td>
                        <td>Rs {{ number_format($shopkeeper->total_sales, 2) }}</td>
                        <td>Rs {{ number_format($shopkeeper->outstanding_balance, 2) }}</td>
                        <td>
                            <a href="{{ route('shopkeepers.printHistory', ['shopkeeper' => $shopkeeper->id, 'from' => request('from'), 'to' => request('to')]) }}" target="_blank" class="btn btn-sm btn-secondary" title="Print for Date Range"><i class="bi bi-printer"></i></a>
                            <a href="{{ route('shopkeepers.show', $shopkeeper) }}" class="btn btn-sm btn-info" title="View"><i class="bi bi-eye"></i></a>
                            <a href="{{ route('shopkeepers.edit', $shopkeeper) }}" class="btn btn-sm btn-warning" title="Edit"><i class="bi bi-pencil"></i></a>
                            <!-- Delete Button to trigger modal -->
                            <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteShopkeeperModal{{ $shopkeeper->id }}" title="Delete">
                                <i class="bi bi-trash"></i>
                            </button>
                            <!-- Hidden form for deletion -->
                            <form action="{{ route('shopkeepers.destroy', $shopkeeper) }}" method="POST" style="display:none;" id="deleteShopkeeperForm{{ $shopkeeper->id }}">
                                @csrf @method('DELETE')
                            </form>
                            <!-- Modal (outside form) -->
                            <div class="modal fade" id="deleteShopkeeperModal{{ $shopkeeper->id }}" tabindex="-1" aria-labelledby="deleteShopkeeperModalLabel{{ $shopkeeper->id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header bg-danger text-white">
                                            <h5 class="modal-title" id="deleteShopkeeperModalLabel{{ $shopkeeper->id }}">Confirm Deletion</h5>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="alert alert-warning">
                                                <strong>Warning:</strong> Deleting this shopkeeper will <b>hide</b> them from the system, but all related sales and payment history will be preserved and not affected. You can restore the shopkeeper later if needed.
                                            </div>
                                            Are you sure you want to delete <strong>{{ $shopkeeper->name }}</strong>?
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                            <button type="button" class="btn btn-danger" onclick="document.getElementById('deleteShopkeeperForm{{ $shopkeeper->id }}').submit();">Yes, Delete</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center">No shopkeepers found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@push('scripts')
<script>
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
document.getElementById('clear-date-filter').onclick = function() {
    document.getElementById('from').value = '';
    document.getElementById('to').value = '';
    document.getElementById('shopkeeper-date-filter-form-popover').submit();
};
</script>
@endpush
@endsection 