<?php $__env->startSection('content'); ?>
    <div class="container">
        <h3>PURCHASES</h3>
        <hr>

        <a href="<?php echo e(route ('purchase.create')); ?>" class="mb-3 btn btn-primary">Add Stock</a>
        

        <form method="GET" class="row g-3 align-items-end mb-4">
            <div class="col-md-3">
                <label for="search">Search</label>
                <input type="text" name="search" id="search" class="form-control" value="<?php echo e(request('search')); ?>"
                    placeholder="Supplier or Amount">
            </div>

            <div class="col-md-3">
                <label for="from">From</label>
                <input type="date" name="from" id="from" class="form-control" value="<?php echo e(request('from')); ?>">
            </div>

            <div class="col-md-3">
                <label for="to">To</label>
                <input type="date" name="to" id="to" class="form-control" value="<?php echo e(request('to')); ?>">
            </div>

            <div class="col-md-auto">
                <button type="submit" class="btn btn-primary">Filter</button>
                <a href="<?php echo e(route('purchase.index')); ?>" class="btn btn-secondary">Reset</a>
            </div>
        </form>

        <?php if($purchases->count()): ?>
            <table class="table table-bordered align-middle">
                <thead>
                    <tr>
                        <th>Supplier</th>
                        <th>Total Amount</th>
                        <th>Purchase Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $purchases; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $purchase): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($purchase->supplier->supplier_name ?? '-'); ?></td>
                            <td><?php echo e(number_format($purchase->total_amount, 2)); ?></td>
                            <td><?php echo e($purchase->purchase_date); ?></td>
                            <td>
                                <button class="btn btn-sm btn-info" data-bs-toggle="modal"
                                    data-bs-target="#itemsModal<?php echo e($purchase->id); ?>">
                                    <i class="bi bi-eye-fill"></i>
                                </button>

                                <a href="<?php echo e(route('purchase.edit', $purchase->id)); ?>" class="btn btn-sm btn-warning"><i
                                        class="bi bi-pencil-square"></i>
                                </a>
                                <a href="<?php echo e(route('purchase.print', $purchase->id)); ?>" class="btn btn-sm btn-secondary" title="Print Invoice" target="_blank"><i class="bi bi-printer"></i></a>

                                <?php
                                    $userRole = auth()->user()->role;
                                ?>

                                <?php if(in_array($userRole, ['superadmin', 'admin'])): ?>
                                    <!-- Delete Button triggers modal -->
                                    <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                        data-bs-target="#deleteModal<?php echo e($purchase->id); ?>">
                                        <i class="bi bi-trash-fill"></i>
                                    </button>
                                <?php endif; ?>

                                <!-- Modal -->
                                <div class="modal fade" id="deleteModal<?php echo e($purchase->id); ?>" tabindex="-1"
                                    aria-labelledby="deleteModalLabel<?php echo e($purchase->id); ?>" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-top">
                                        <div class="modal-content">
                                            <div class="modal-header bg-danger text-white">
                                                <h5 class="modal-title" id="deleteModalLabel<?php echo e($purchase->id); ?>">Confirm
                                                    Delete
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                Are you sure you want to delete?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Cancel</button>

                                                <form action="<?php echo e(route('purchase.destroy', $purchase->id)); ?>"
                                                    method="POST" class="d-inline">
                                                    <?php echo csrf_field(); ?>
                                                    <?php echo method_field('DELETE'); ?>
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

            <?php echo e($purchases->links('vendor.pagination.bootstrap-5')); ?>

        <?php else: ?>
            <p>No purchases found.</p>
        <?php endif; ?>

        
        <?php $__currentLoopData = $purchases; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $purchase): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="modal fade" id="itemsModal<?php echo e($purchase->id); ?>" tabindex="-1"
                aria-labelledby="itemsModalLabel<?php echo e($purchase->id); ?>" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Items for Purchase #<?php echo e($purchase->id); ?></h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <?php if($purchase->items && count($purchase->items)): ?>
                                <table class="table table-bordered">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Item</th>
                                            <th>Quantity</th>
                                            <th>Unit Price</th>
                                            <th>Total Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $__currentLoopData = $purchase->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td><?php echo e($item->inventory->item_name ?? '-'); ?></td>
                                                <td><?php echo e($item->quantity); ?></td>
                                                <td><?php echo e(number_format($item->purchase_amount / $item->quantity, 2)); ?></td>
                                                <td><?php echo e(number_format($item->purchase_amount, 2)); ?></td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tbody>
                                </table>
                            <?php else: ?>
                                <p class="text-muted">No items found for this purchase.</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\HP\Desktop\posnex\resources\views/purchases/index.blade.php ENDPATH**/ ?>