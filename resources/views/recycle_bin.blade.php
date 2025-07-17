@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex align-items-center mb-4" style="gap: 12px;">
        <i class="bi bi-trash3-fill" style="font-size:2.2rem;color:#b71c1c;"></i>
        <h2 class="mb-0" style="font-weight:700;color:#b71c1c;letter-spacing:1px;">Recycle Bin</h2>
    </div>
    <div class="row g-4">
        <div class="col-md-6 col-lg-6">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <h5 class="card-title mb-3" style="color:#b71c1c;font-weight:600;"><i class="bi bi-truck me-2"></i>Deleted Suppliers</h5>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover align-middle mb-0" style="border-radius:12px;overflow:hidden;">
                            <thead class="table-light">
                                <tr>
                                    <th>Name</th>
                                    <th>Contact Person</th>
                                    <th>Cell No</th>
                                    <th>Country</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($deletedSuppliers as $supplier)
                                    <tr>
                                        <td>{{ $supplier->supplier_name }}</td>
                                        <td>{{ $supplier->contact_person }}</td>
                                        <td>{{ $supplier->cell_no }}</td>
                                        <td>{{ $supplier->country }}</td>
                                        <td>
                                            <form action="{{ route('suppliers.restore', $supplier->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                <button type="submit" class="btn btn-success btn-sm"><i class="bi bi-arrow-clockwise"></i> Restore</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted py-4">
                                            <i class="bi bi-emoji-frown" style="font-size:1.5rem;"></i><br>No deleted suppliers found.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-6">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <h5 class="card-title mb-3" style="color:#b71c1c;font-weight:600;"><i class="bi bi-person-x me-2"></i>Deleted Customers</h5>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover align-middle mb-0" style="border-radius:12px;overflow:hidden;">
                            <thead class="table-light">
                                <tr>
                                    <th>Name</th>
                                    <th>Contact Person</th>
                                    <th>Cell No</th>
                                    <th>City</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($deletedCustomers as $customer)
                                    <tr>
                                        <td>{{ $customer->name }}</td>
                                        <td>{{ $customer->contact_person ?? '-' }}</td>
                                        <td>{{ $customer->cell_no ?? '-' }}</td>
                                        <td>{{ $customer->city ?? '-' }}</td>
                                        <td>
                                            <form action="{{ route('customers.restore', $customer->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                <button type="submit" class="btn btn-success btn-sm"><i class="bi bi-arrow-clockwise"></i> Restore</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted py-4">
                                            <i class="bi bi-emoji-frown" style="font-size:1.5rem;"></i><br>No deleted customers found.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-6">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <h5 class="card-title mb-3" style="color:#b71c1c;font-weight:600;"><i class="bi bi-people-fill me-2"></i>Deleted Distributors</h5>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover align-middle mb-0" style="border-radius:12px;overflow:hidden;">
                            <thead class="table-light">
                                <tr>
                                    <th>Name</th>
                                    <th>Phone</th>
                                    <th>Address</th>
                                    <th>Commission Rate</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($deletedDistributors as $distributor)
                                    <tr>
                                        <td>{{ $distributor->name }}</td>
                                        <td>{{ $distributor->phone ?? '-' }}</td>
                                        <td>{{ $distributor->address ?? '-' }}</td>
                                        <td>{{ $distributor->commission_rate ?? '-' }}%</td>
                                        <td>
                                            <form action="{{ route('distributors.restore', $distributor->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                <button type="submit" class="btn btn-success btn-sm"><i class="bi bi-arrow-clockwise"></i> Restore</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted py-4">
                                            <i class="bi bi-emoji-frown" style="font-size:1.5rem;"></i><br>No deleted distributors found.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-6">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <h5 class="card-title mb-3" style="color:#b71c1c;font-weight:600;"><i class="bi bi-shop me-2"></i>Deleted Shopkeepers</h5>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover align-middle mb-0" style="border-radius:12px;overflow:hidden;">
                            <thead class="table-light">
                                <tr>
                                    <th>Name</th>
                                    <th>Phone</th>
                                    <th>Address</th>
                                    <th>Distributor</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($deletedShopkeepers as $shopkeeper)
                                    <tr>
                                        <td>{{ $shopkeeper->name }}</td>
                                        <td>{{ $shopkeeper->phone ?? '-' }}</td>
                                        <td>{{ $shopkeeper->address ?? '-' }}</td>
                                        <td>{{ optional($shopkeeper->distributor)->name ?? '-' }}</td>
                                        <td>
                                            <form action="{{ route('shopkeepers.restore', $shopkeeper->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                <button type="submit" class="btn btn-success btn-sm"><i class="bi bi-arrow-clockwise"></i> Restore</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted py-4">
                                            <i class="bi bi-emoji-frown" style="font-size:1.5rem;"></i><br>No deleted shopkeepers found.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
    .card { border-radius: 16px; }
    .card-title { font-size: 1.18em; letter-spacing: 0.5px; }
    .table { border-radius: 12px; overflow: hidden; }
    .table th, .table td { vertical-align: middle !important; }
    .table-hover tbody tr:hover { background: #f9eaea; }
    @media (max-width: 991px) {
        .row.g-4 > [class^='col-'] { margin-bottom: 18px; }
    }
</style>
@endsection 