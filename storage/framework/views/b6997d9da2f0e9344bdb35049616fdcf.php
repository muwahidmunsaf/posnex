<?php $__env->startSection('pos'); ?>
    <div class="container mt-4">
        <h3><i class="fa fa-receipt text-secondary me-2"></i>INVOICE</h3>
        <hr>
        <?php if(session('success')): ?>
            <div class="alert alert-success"><?php echo e(session('success')); ?></div>
        <?php endif; ?>
        <div class="card shadow p-3 mb-4">
            <form method="GET" action="<?php echo e(route('sales.index')); ?>" class="d-flex flex-row flex-wrap align-items-center gap-2 mb-3" style="max-width:500px;">
                <input type="text" name="search" class="form-control rounded-pill" placeholder="Search Sale Code..." value="<?php echo e(request('search')); ?>" style="min-width:180px;">
                <button type="submit" class="btn btn-primary rounded-circle d-flex align-items-center justify-content-center" title="Search" style="width:40px;height:40px;"><i class="fa fa-search"></i></button>
                <a href="<?php echo e(route('sales.index')); ?>" class="btn btn-secondary rounded-circle d-flex align-items-center justify-content-center" title="Reset" style="width:40px;height:40px;"><i class="fa fa-undo"></i></a>
            </form>
            <div style="width:100%;">
                <table class="table table-hover align-middle rounded" style="width:100%;">
                    <thead class="table-light">
                        <tr>
                            <th>Sale ID</th>
                            <th>Created By</th>
                            <th>Customer</th>
                            <th>Distributor</th>
                            <th>Shopkeeper</th>
                            <th>Subtotal</th>
                            <th>Total</th>
                            <th>Payment Method</th>
                            <th>Discount</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $sales; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sale): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr class="<?php echo e($sale->has_return ? 'highlight-row' : ''); ?>">
                                <td class="<?php echo e($sale->has_return ? 'highlight-cell' : ''); ?>"><?php echo e($sale->sale_code); ?></td>
                                <td class="<?php echo e($sale->has_return ? 'highlight-cell' : ''); ?>"><?php echo e($sale->created_by); ?></td>
                                <td class="<?php echo e($sale->has_return ? 'highlight-cell' : ''); ?>"><?php echo e($sale->customer->name  ?? '-'); ?></td>
                                <td class="<?php echo e($sale->has_return ? 'highlight-cell' : ''); ?>"><?php echo e($sale->distributor->name ?? '-'); ?></td>
                                <td class="<?php echo e($sale->has_return ? 'highlight-cell' : ''); ?>"><?php echo e($sale->shopkeeper->name ?? '-'); ?></td>
                                <td class="<?php echo e($sale->has_return ? 'highlight-cell' : ''); ?>"><?php echo e($sale->subtotal); ?></td>
                                <td class="<?php echo e($sale->has_return ? 'highlight-cell' : ''); ?>"><?php echo e($sale->total_amount); ?></td>
                                <td class="<?php echo e($sale->has_return ? 'highlight-cell' : ''); ?>"><?php echo e(ucfirst($sale->payment_method)); ?></td>
                                <td class="<?php echo e($sale->has_return ? 'highlight-cell' : ''); ?>"><?php echo e($sale->discount); ?></td>
                                <td class="<?php echo e($sale->has_return ? 'highlight-cell' : ''); ?>">
                                    <div class="d-flex gap-1 align-items-center">
                                        <a href="<?php echo e(route('sales.print', $sale->id)); ?>" class="btn btn-sm btn-primary rounded-circle d-flex align-items-center justify-content-center" target="_blank" title="Print"><i class="fa fa-print"></i></a>
                                        <a href="<?php echo e(route('sales.return', $sale->id)); ?>" class="btn btn-sm btn-warning rounded-circle d-flex align-items-center justify-content-center" title="Return/Exchange"><i class="fa fa-undo"></i></a>
                                        <?php if($sale->manualProducts->count() == 0): ?>
                                            <a href="<?php echo e(route('sales.edit', $sale->id)); ?>" class="btn btn-sm btn-info rounded-circle d-flex align-items-center justify-content-center" title="Edit"><i class="fa fa-edit"></i></a>
                                        <?php else: ?>
                                            <a href="#" class="btn btn-sm btn-info rounded-circle d-flex align-items-center justify-content-center disabled" title="Edit disabled for sales with both regular and manual products" tabindex="-1" aria-disabled="true"><i class="fa fa-edit"></i></a>
                                        <?php endif; ?>
                                        <form action="<?php echo e(route('sales.destroy', $sale->id)); ?>" method="POST" style="display:inline-block;">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="submit" class="btn btn-sm btn-danger rounded-circle d-flex align-items-center justify-content-center" title="Delete" onclick="return confirm('Are you sure you want to delete this sale?')">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
            <?php echo e($sales->links('vendor.pagination.bootstrap-5')); ?>

        </div>
    </div>
    <!-- FontAwesome CDN for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
    .table thead th { border-top: none; }
    .table-hover tbody tr:hover { background: #f5f7fa; }
    .table td, .table th {
        vertical-align: middle;
        border-radius: 8px;
        border: 1.5px solid #e3e6ea; /* Light cell border */
    }
    .table tr {
        border-bottom: 2.5px solid #cfd8dc; /* More prominent row border */
    }
    .btn.rounded-circle { width: 32px; height: 32px; padding: 0; font-size: 1.1rem; }
    .form-control.rounded-pill { border-radius: 50px; }
    .card { border-radius: 18px; }
    /* Remove min-width and force full width */
    .table, .table-responsive { width: 100% !important; min-width: 0 !important; }
    @media (max-width: 991px) {
        .table {
            font-size: 13px;
        }
        .btn.rounded-circle { width: 28px; height: 28px; font-size: 1rem; }
        .form-control.rounded-pill { font-size: 13px; }
    }
    @media (max-width: 767px) {
        .table {
            font-size: 12px;
        }
        .btn.rounded-circle { width: 24px; height: 24px; font-size: 0.95rem; }
        .form-control.rounded-pill { font-size: 12px; }
        .table-responsive { border-radius: 8px; }
    }
    .highlight-row {
        background-color: #fffbe6 !important;
    }
    .highlight-cell {
        background-color:rgb(248, 198, 192) !important;
    }
    </style>
    <?php $__env->startPush('scripts'); ?>
    <script>
    window.addEventListener('pageshow', function(event) {
        if (event.persisted) {
            window.location.reload();
        }
    });
    </script>
    <?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.pos', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\HP\Desktop\posnex\resources\views/sales/index.blade.php ENDPATH**/ ?>