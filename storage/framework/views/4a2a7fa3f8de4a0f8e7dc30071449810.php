<!-- FontAwesome CDN for icons (no integrity attribute for compatibility) -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />

<?php $__env->startSection('content'); ?>
<style>
.supplier-cards-row {
    display: flex;
    gap: 24px;
    justify-content: flex-start;
    flex-wrap: wrap;
    margin-bottom: 2rem;
}
.supplier-card {
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
.supplier-card:hover {
    box-shadow: 0 8px 24px rgba(60,72,88,0.16);
    transform: translateY(-2px) scale(1.02);
}
.supplier-card .card-icon {
    font-size: 1.5rem;
    margin-right: 0.8rem;
    flex-shrink: 0;
    display: flex;
    align-items: center;
    justify-content: center;
}
.supplier-card.total-suppliers .card-icon { color: #7c43bd; }
.supplier-card.total-paid .card-icon { color: #219150; }
.supplier-card.total-pending .card-icon { color: #b71c1c; }
.supplier-card.total-purchase .card-icon { color: #b85c00; }
.supplier-card .card-content { flex: 1; }
.supplier-card .card-label {
    font-size: 0.98rem;
    color: #888;
    font-weight: 500;
    margin-bottom: 0.2rem;
}
.supplier-card .card-value {
    font-size: 1.25rem;
    font-weight: 700;
    color: #222;
    letter-spacing: 0.5px;
}
@media (max-width: 1200px) {
    .supplier-cards-row { flex-wrap: wrap; }
    .supplier-card { min-width: 220px; max-width: 100%; }
}
@media (max-width: 900px) {
    .supplier-cards-row { flex-direction: column; gap: 18px; }
    .supplier-card { max-width: 100%; }
}
</style>
    <div class="container">
    <div class="d-flex flex-wrap align-items-center justify-content-between mb-3" style="gap: 1rem;">
        <h3 class="mb-0" style="font-weight:700;color:#7c43bd;letter-spacing:1px;display:flex;align-items:center;gap:10px;">
            <i class="fa-solid fa-truck-field" style="color:#7c43bd;font-size:1.7rem;"></i> Suppliers
        </h3>
        <div class="d-flex flex-wrap align-items-center gap-2" style="gap: 0.7rem;">
            <a href="<?php echo e(route('suppliers.create')); ?>" class="btn btn-primary d-flex align-items-center justify-content-center" title="Add Supplier" style="width:40px;height:40px;padding:0;font-size:1.3rem;"><i class="fa fa-plus"></i></a>
            <a href="#" id="printAllSuppliersBtn" target="_blank" class="btn btn-secondary d-flex align-items-center justify-content-center" title="Print All" style="width:40px;height:40px;padding:0;font-size:1.3rem;"><i class="fa fa-print"></i></a>
            <!-- Search Icon with Popover -->
            <button type="button" class="btn btn-outline-secondary d-flex align-items-center justify-content-center" id="searchPopoverBtn" title="Search by Country" style="width:40px;height:40px;padding:0;font-size:1.3rem;">
                <i class="fa fa-search"></i>
            </button>
            <div id="searchPopover" class="card shadow p-3" style="position:absolute;right:60px;top:60px;min-width:220px;z-index:1050;display:none;">
                <form method="GET" action="<?php echo e(route('suppliers.index')); ?>" class="mb-0" id="supplier-country-search-form-popover">
                    <div class="mb-2">
                        <label for="country" class="form-label mb-1">Country</label>
                        <input type="text" name="country" id="country" class="form-control form-control-sm" value="<?php echo e(request('country')); ?>" placeholder="Enter country name">
                    </div>
                    <button type="submit" class="btn btn-sm btn-primary w-100"><i class="fa fa-search me-1"></i> Search</button>
                </form>
            </div>
            <!-- Filter Icon with Popover -->
            <button type="button" class="btn btn-outline-secondary d-flex align-items-center justify-content-center" id="filterPopoverBtn" title="Filter" style="width:40px;height:40px;padding:0;font-size:1.3rem;">
                <i class="fa fa-filter"></i>
            </button>
            <div id="filterPopover" class="card shadow p-3" style="position:absolute;right:10px;top:60px;min-width:220px;z-index:1050;display:none;">
                <form method="GET" action="<?php echo e(route('suppliers.index')); ?>" class="mb-0" id="supplier-date-filter-form-popover">
                    <div class="mb-2">
                        <label for="from" class="form-label mb-1">From</label>
                        <input type="date" name="from" id="from" class="form-control form-control-sm" value="<?php echo e(request('from')); ?>">
                    </div>
                    <div class="mb-2">
                        <label for="to" class="form-label mb-1">To</label>
                        <input type="date" name="to" id="to" class="form-control form-control-sm" value="<?php echo e(request('to')); ?>">
                    </div>
                    <button type="submit" class="btn btn-sm btn-primary w-100 mb-2"><i class="fa fa-filter me-1"></i> Filter</button>
                    <a href="<?php echo e(route('suppliers.index')); ?>" class="btn btn-sm btn-outline-secondary w-100">Clear Filter</a>
                </form>
            </div>
        </div>
    </div>
    <!-- Modern Overview Cards Row -->
    <div class="supplier-cards-row">
        <div class="supplier-card total-suppliers">
            <span class="card-icon"><i class="fa-solid fa-users"></i></span>
            <div class="card-content">
                <div class="card-label">Total Suppliers</div>
                <div class="card-value"><?php echo e($totalSuppliers); ?></div>
            </div>
        </div>
        <div class="supplier-card total-purchase">
            <span class="card-icon"><i class="fa-solid fa-boxes-stacked"></i></span>
            <div class="card-content">
                <div class="card-label">Total Purchase</div>
                <div class="card-value">Rs. <?php echo e(number_format($totalPurchasePkr, 2)); ?></div>
            </div>
        </div>
        <div class="supplier-card total-paid">
            <span class="card-icon"><i class="fa-solid fa-wallet"></i></span>
            <div class="card-content">
                <div class="card-label">Total Paid Amount (PKR)</div>
                <div class="card-value">Rs. <?php echo e(number_format($totalPaidPkr, 2)); ?></div>
            </div>
        </div>
        <div class="supplier-card total-pending">
            <span class="card-icon"><i class="fa-solid fa-hourglass-half"></i></span>
            <div class="card-content">
                <div class="card-label">Total Pending Amount (PKR)</div>
                <div class="card-value">Rs. <?php echo e(number_format($totalPendingPkr, 2)); ?></div>
            </div>
        </div>
    </div>
    <!-- Remove old filter, print, and add supplier buttons/inputs below cards -->
        <?php if(session('success')): ?>
            <div class="alert alert-success"><?php echo e(session('success')); ?></div>
        <?php endif; ?>

        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Contact Person</th>
                    <th>Cell No</th>
                    <th>Country</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $suppliers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $supplier): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($supplier->supplier_name); ?></td>
                        <td><?php echo e($supplier->contact_person); ?></td>
                        <td><?php echo e($supplier->cell_no); ?></td>
                        <td><?php echo e($supplier->country); ?></td>
                        <td>
                            <a href="<?php echo e(route('suppliers.show', $supplier->id)); ?>" class="btn btn-sm btn-info" title="View"><i class="bi bi-eye"></i></a>
                            <a href="<?php echo e(route('suppliers.edit', $supplier->id)); ?>" class="btn btn-sm btn-warning ms-1" title="Edit"><i class="bi bi-pencil"></i></a>
                            <a href="<?php echo e(route('suppliers.printHistory', $supplier->id)); ?>" target="_blank" class="btn btn-sm btn-secondary ms-1" title="Print Full History" data-supplier-print><i class="bi bi-printer"></i></a>
                            <button type="button" class="btn btn-sm btn-danger ms-1" data-bs-toggle="modal" data-bs-target="#deleteSupplierModal<?php echo e($supplier->id); ?>" title="Delete"><i class="bi bi-trash"></i></button>
                            <!-- Modal -->
                            <div class="modal fade" id="deleteSupplierModal<?php echo e($supplier->id); ?>" tabindex="-1" aria-labelledby="deleteSupplierModalLabel<?php echo e($supplier->id); ?>" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header bg-danger text-white">
                                            <h5 class="modal-title" id="deleteSupplierModalLabel<?php echo e($supplier->id); ?>">Confirm Deletion</h5>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="alert alert-warning">
                                                <strong>Warning:</strong> Deleting this supplier will <b>hide</b> them from the system, but all payment and purchase history will be preserved and not affected. You can restore the supplier later if needed.
                                            </div>
                                            Are you sure you want to delete <strong><?php echo e($supplier->supplier_name); ?></strong>?
                                        </div>
                                        <div class="modal-footer">
                                            <form action="<?php echo e(route('suppliers.destroy', $supplier->id)); ?>" method="POST">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('DELETE'); ?>
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                <button type="submit" class="btn btn-danger">Yes, Delete</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>

        <?php echo e($suppliers->links('vendor.pagination.bootstrap-5')); ?>

    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    function buildPrintUrl() {
        const from = document.getElementById('from').value;
        const to = document.getElementById('to').value;
        let url = "<?php echo e(route('suppliers.printAll')); ?>";
        const params = [];
        if (from) params.push('from=' + encodeURIComponent(from));
        if (to) params.push('to=' + encodeURIComponent(to));
        if (params.length) url += '?' + params.join('&');
        return url;
    }
    document.getElementById('printAllSuppliersBtn').onclick = function(e) {
        e.preventDefault();
        window.open(buildPrintUrl(), '_blank');
    };

    // Update print icon for each supplier to include date range
    document.querySelectorAll('a[data-supplier-print]').forEach(function(btn) {
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
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\HP\Desktop\posnex\resources\views/suppliers/index.blade.php ENDPATH**/ ?>