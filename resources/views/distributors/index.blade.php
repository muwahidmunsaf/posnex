@extends('layouts.app')
<!-- FontAwesome CDN for icons (no integrity attribute for compatibility) -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />

@section('content')
<style>
.distributor-cards-row {
    display: flex;
    gap: 24px;
    justify-content: flex-start;
    flex-wrap: wrap;
    margin-bottom: 2rem;
}
.distributor-card {
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
.distributor-card:hover {
    box-shadow: 0 8px 24px rgba(60,72,88,0.16);
    transform: translateY(-2px) scale(1.02);
}
.distributor-card .card-icon {
    font-size: 1.5rem;
    margin-right: 0.8rem;
    flex-shrink: 0;
    display: flex;
    align-items: center;
    justify-content: center;
}
.distributor-card.total-distributors .card-icon { color: #1976d2; }
.distributor-card.total-paid .card-icon { color: #43a047; }
.distributor-card.total-pending .card-icon { color: #b71c1c; }
.distributor-card.total-remaining .card-icon { color: #ff9800; }
.distributor-card .card-content { flex: 1; }
.distributor-card .card-label { font-size: 0.98rem; color: #888; font-weight: 500; margin-bottom: 0.2rem; }
.distributor-card .card-value { font-size: 1.25rem; font-weight: 700; color: #222; letter-spacing: 0.5px; }
@media (max-width: 1200px) {
    .distributor-cards-row { flex-wrap: wrap; }
    .distributor-card { min-width: 160px; max-width: 100%; }
}
@media (max-width: 900px) {
    .distributor-cards-row { flex-direction: column; gap: 18px; }
    .distributor-card { max-width: 100%; }
}
</style>
<div class="container">
    <div class="d-flex flex-wrap align-items-center justify-content-between mb-3" style="gap: 1rem;">
        <h3 class="mb-0" style="font-weight:700;color:#1976d2;letter-spacing:1px;display:flex;align-items:center;gap:10px;">
            <i class="fa-solid fa-people-group" style="color:#1976d2;font-size:1.7rem;"></i> Distributors
        </h3>
        <div class="d-flex flex-wrap align-items-center gap-2" style="gap: 0.7rem;">
            <a href="{{ route('distributors.create') }}" class="btn btn-primary d-flex align-items-center justify-content-center" title="Add Distributor" style="width:40px;height:40px;padding:0;font-size:1.3rem;"><i class="fa fa-plus"></i></a>
            <a href="#" id="print-all-distributors-btn" class="btn btn-secondary d-flex align-items-center justify-content-center" title="Print All" style="width:40px;height:40px;padding:0;font-size:1.3rem;"><i class="fa fa-print"></i></a>
            <!-- Search Icon with Popover -->
            <button type="button" class="btn btn-outline-secondary d-flex align-items-center justify-content-center" id="searchPopoverBtn" title="Search by Name" style="width:40px;height:40px;padding:0;font-size:1.3rem;">
                <i class="fa fa-search"></i>
            </button>
            <div id="searchPopover" class="card shadow p-3" style="position:absolute;right:60px;top:60px;min-width:220px;z-index:1050;display:none;">
                <form method="GET" action="{{ route('distributors.index') }}" class="mb-0" id="distributor-name-search-form-popover">
                    <div class="mb-2">
                        <label for="name" class="form-label mb-1">Name</label>
                        <input type="text" name="name" id="name" class="form-control form-control-sm" value="{{ request('name') }}" placeholder="Enter distributor name">
                    </div>
                    <button type="submit" class="btn btn-sm btn-primary w-100"><i class="fa fa-search me-1"></i> Search</button>
                </form>
            </div>
            <!-- Filter Icon with Popover -->
            <button type="button" class="btn btn-outline-secondary d-flex align-items-center justify-content-center" id="filterPopoverBtn" title="Filter" style="width:40px;height:40px;padding:0;font-size:1.3rem;">
                <i class="fa fa-filter"></i>
            </button>
            <div id="filterPopover" class="card shadow p-3" style="position:absolute;right:10px;top:60px;min-width:220px;z-index:1050;display:none;">
                <form method="GET" action="{{ route('distributors.index') }}" class="mb-0" id="distributor-date-filter-form-popover">
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
    <div class="distributor-cards-row">
        <div class="distributor-card total-distributors">
            <span class="card-icon"><i class="fa-solid fa-users"></i></span>
            <div class="card-content">
                <div class="card-label">Total Distributors</div>
                <div class="card-value">{{ $totalDistributors }}</div>
            </div>
        </div>
        <div class="distributor-card total-paid">
            <span class="card-icon"><i class="fa-solid fa-hand-holding-dollar"></i></span>
            <div class="card-content">
                <div class="card-label">Total Paid Commission</div>
                <div class="card-value">Rs. {{ number_format($totalPaidCommission, 2) }}</div>
            </div>
        </div>
        <div class="distributor-card total-pending">
            <span class="card-icon"><i class="fa-solid fa-scale-unbalanced"></i></span>
            <div class="card-content">
                <div class="card-label">Total Pending Commission</div>
                <div class="card-value">Rs. {{ number_format($totalPendingCommission, 2) }}</div>
            </div>
        </div>
        <div class="distributor-card total-remaining">
            <span class="card-icon"><i class="fa-solid fa-vault"></i></span>
            <div class="card-content">
                <div class="card-label">Total Remaining Amount</div>
                <div class="card-value">Rs. {{ number_format($totalRemainingAmount, 2) }}</div>
            </div>
        </div>
    </div>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Name</th>
                <th>Phone</th>
                <th>Commission Rate (%)</th>
                <th>Shopkeepers</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($distributors as $distributor)
            <tr>
                <td>{{ $distributor->name }}</td>
                <td>{{ $distributor->phone }}</td>
                <td>{{ $distributor->commission_rate }}</td>
                <td>
                    @php $shopkeepers = $distributor->shopkeepers; @endphp
                    @if($shopkeepers && $shopkeepers->count())
                        {{ $shopkeepers->pluck('name')->implode(', ') }}
                    @else
                        <span class="text-muted">None</span>
                    @endif
                </td>
                <td>
                    <a href="{{ route('distributors.history', $distributor) }}" class="btn btn-sm btn-info" title="View History"><i class="bi bi-eye"></i></a>
                    <a href="{{ route('distributors.edit', $distributor) }}" class="btn btn-sm btn-warning" title="Edit"><i class="bi bi-pencil"></i></a>
                    <a href="#" class="btn btn-sm btn-secondary print-distributor-btn" data-distributor-id="{{ $distributor->id }}" title="Print for Date Range"><i class="bi bi-printer"></i></a>
                    <form action="{{ route('distributors.destroy', $distributor) }}" method="POST" style="display:inline-block;">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete this distributor?')" title="Delete"><i class="bi bi-trash"></i></button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
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
</script>
@endpush
@endsection 