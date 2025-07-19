

<?php $__env->startSection('content'); ?>
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
                                <?php $__empty_1 = true; $__currentLoopData = $deletedSuppliers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $supplier): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr>
                                        <td><?php echo e($supplier->supplier_name); ?></td>
                                        <td><?php echo e($supplier->contact_person); ?></td>
                                        <td><?php echo e($supplier->cell_no); ?></td>
                                        <td><?php echo e($supplier->country); ?></td>
                                        <td>
                                            <form action="<?php echo e(route('suppliers.restore', $supplier->id)); ?>" method="POST" style="display:inline;">
                                                <?php echo csrf_field(); ?>
                                                <button type="submit" class="btn btn-success btn-sm"><i class="bi bi-arrow-clockwise"></i> Restore</button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td colspan="5" class="text-center text-muted py-4">
                                            <i class="bi bi-emoji-frown" style="font-size:1.5rem;"></i><br>No deleted suppliers found.
                                        </td>
                                    </tr>
                                <?php endif; ?>
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
                                <?php $__empty_1 = true; $__currentLoopData = $deletedCustomers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $customer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr>
                                        <td><?php echo e($customer->name); ?></td>
                                        <td><?php echo e($customer->contact_person ?? '-'); ?></td>
                                        <td><?php echo e($customer->cell_no ?? '-'); ?></td>
                                        <td><?php echo e($customer->city ?? '-'); ?></td>
                                        <td>
                                            <form action="<?php echo e(route('customers.restore', $customer->id)); ?>" method="POST" style="display:inline;">
                                                <?php echo csrf_field(); ?>
                                                <button type="submit" class="btn btn-success btn-sm"><i class="bi bi-arrow-clockwise"></i> Restore</button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td colspan="5" class="text-center text-muted py-4">
                                            <i class="bi bi-emoji-frown" style="font-size:1.5rem;"></i><br>No deleted customers found.
                                        </td>
                                    </tr>
                                <?php endif; ?>
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
                                <?php $__empty_1 = true; $__currentLoopData = $deletedDistributors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $distributor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr>
                                        <td><?php echo e($distributor->name); ?></td>
                                        <td><?php echo e($distributor->phone ?? '-'); ?></td>
                                        <td><?php echo e($distributor->address ?? '-'); ?></td>
                                        <td><?php echo e($distributor->commission_rate ?? '-'); ?>%</td>
                                        <td>
                                            <form action="<?php echo e(route('distributors.restore', $distributor->id)); ?>" method="POST" style="display:inline;">
                                                <?php echo csrf_field(); ?>
                                                <button type="submit" class="btn btn-success btn-sm"><i class="bi bi-arrow-clockwise"></i> Restore</button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td colspan="5" class="text-center text-muted py-4">
                                            <i class="bi bi-emoji-frown" style="font-size:1.5rem;"></i><br>No deleted distributors found.
                                        </td>
                                    </tr>
                                <?php endif; ?>
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
                                <?php $__empty_1 = true; $__currentLoopData = $deletedShopkeepers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $shopkeeper): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr>
                                        <td><?php echo e($shopkeeper->name); ?></td>
                                        <td><?php echo e($shopkeeper->phone ?? '-'); ?></td>
                                        <td><?php echo e($shopkeeper->address ?? '-'); ?></td>
                                        <td><?php echo e(optional($shopkeeper->distributor)->name ?? '-'); ?></td>
                                        <td>
                                            <form action="<?php echo e(route('shopkeepers.restore', $shopkeeper->id)); ?>" method="POST" style="display:inline;">
                                                <?php echo csrf_field(); ?>
                                                <button type="submit" class="btn btn-success btn-sm"><i class="bi bi-arrow-clockwise"></i> Restore</button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td colspan="5" class="text-center text-muted py-4">
                                            <i class="bi bi-emoji-frown" style="font-size:1.5rem;"></i><br>No deleted shopkeepers found.
                                        </td>
                                    </tr>
                                <?php endif; ?>
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
<?php $__env->stopSection(); ?> 
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\HP\Desktop\posnex\resources\views/recycle_bin.blade.php ENDPATH**/ ?>