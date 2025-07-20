<?php $__env->startSection('pos'); ?>
<div class="container mt-4">
    <h3><i class="fa fa-file-invoice-dollar text-secondary me-2"></i>MANUAL SALE INVOICE</h3>
    <hr>
    <?php if(session('success')): ?>
        <div class="alert alert-success"><?php echo e(session('success')); ?></div>
    <?php endif; ?>
    <div class="card shadow p-3 mb-4">
        <div class="d-flex flex-row flex-wrap align-items-center gap-2 mb-3" style="max-width:500px;">
            <input type="text" id="invoiceSearch" class="form-control rounded-pill" placeholder="Search Invoice..." style="min-width:180px;">
            <button type="button" class="btn btn-primary rounded-circle d-flex align-items-center justify-content-center" title="Search" style="width:40px;height:40px;" onclick="filterTable()"><i class="fa fa-search"></i></button>
            <button type="button" class="btn btn-secondary rounded-circle d-flex align-items-center justify-content-center" title="Reset" style="width:40px;height:40px;" onclick="resetTable()"><i class="fa fa-undo"></i></button>
        </div>
        <div class="table-responsive rounded">
            <table class="table table-hover align-middle rounded" id="invoiceTable" style="overflow:hidden;">
                <thead class="table-light">
                    <tr>
                        <th>Sale ID</th>
                        <th>Item Name</th>
                        <th>Sale Amount</th>
                        <th>Purchase Amount</th>
                        <th>Total</th>
                        <th>Payment</th>
                        <th>Created By</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $externalSales; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sale): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr style="transition:background 0.2s;">
                            <td><?php echo e($sale->saleE_id); ?></td>
                            <td><?php echo e($sale->purchase->item_name ?? '-'); ?></td>
                            <td><?php echo e(number_format($sale->sale_amount, 2)); ?></td>
                            <td><?php echo e(isset($sale->purchase->purchase_amount) ? number_format($sale->purchase->purchase_amount, 2) : '-'); ?></td>
                            <td><?php echo e(number_format($sale->total_amount, 2)); ?></td>
                            <td><?php echo e(ucfirst($sale->payment_method)); ?></td>
                            <td><?php echo e($sale->created_by); ?></td>
                            <td>
                                <div class="d-flex gap-1">
                                    <a href="<?php echo e(route('external-sales.invoice', $sale->id)); ?>" class="btn btn-sm btn-primary rounded-circle d-flex align-items-center justify-content-center" target="_blank" title="Print"><i class="fa fa-print"></i></a>
                                    <?php if($sale->parent_sale_id): ?>
                                        <button class="btn btn-sm btn-danger rounded-circle d-flex align-items-center justify-content-center disabled" title="Delete disabled for manual products linked to a regular sale" tabindex="-1" aria-disabled="true"><i class="fa fa-trash"></i></button>
                                    <?php else: ?>
                                        <form action="<?php echo e(route('external-sales.destroy', $sale->id)); ?>" method="POST" style="display:inline-block;">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="submit" class="btn btn-sm btn-danger rounded-circle d-flex align-items-center justify-content-center" title="Delete" onclick="return confirm('Are you sure you want to delete this manual sale?')">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </form>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
        <?php echo e($externalSales->links('vendor.pagination.bootstrap-5')); ?>

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
    border: 1.5px solid #e3e6ea;
}
.table tr {
    border-bottom: 2.5px solid #cfd8dc;
}
.btn.rounded-circle { width: 32px; height: 32px; padding: 0; font-size: 1.1rem; }
.form-control.rounded-pill { border-radius: 50px; }
.card { border-radius: 18px; }
.table-responsive {
    width: 100%;
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
}
.table {
    width: 100%;
    min-width: 900px;
    border-collapse: separate;
    border-spacing: 0;
}
@media (max-width: 991px) {
    .table {
        min-width: 700px;
        font-size: 13px;
    }
    .btn.rounded-circle { width: 28px; height: 28px; font-size: 1rem; }
    .form-control.rounded-pill { font-size: 13px; }
}
@media (max-width: 767px) {
    .table {
        min-width: 600px;
        font-size: 12px;
    }
    .btn.rounded-circle { width: 24px; height: 24px; font-size: 0.95rem; }
    .form-control.rounded-pill { font-size: 12px; }
    .table-responsive { border-radius: 8px; }
}
</style>
<script>
function filterTable() {
    let value = document.getElementById('invoiceSearch').value.toLowerCase();
    let rows = document.querySelectorAll('#invoiceTable tbody tr');
    rows.forEach(row => {
        let text = row.textContent.toLowerCase();
        row.style.display = text.includes(value) ? '' : 'none';
    });
}
document.getElementById('invoiceSearch').addEventListener('keyup', filterTable);
function resetTable() {
    document.getElementById('invoiceSearch').value = '';
    filterTable();
}
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.pos', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\HP\Desktop\posnex\resources\views/external_sales/index.blade.php ENDPATH**/ ?>