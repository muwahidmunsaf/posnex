<?php $__env->startSection('content'); ?>
<div class="container">
    <h3>Add Inventory Item</h3>
    <form method="POST" action="<?php echo e(route('inventory.store')); ?>" enctype="multipart/form-data">
        <?php echo csrf_field(); ?>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label>Item Name</label>
                <input type="text" name="item_name" class="form-control">
            </div>
            <div class="col-md-3 mb-3">
                <label>Retail Price</label>
                <input type="number" step="0.01" name="retail_amount" class="form-control">
            </div>
            <div class="col-md-3 mb-3">
                <label>Wholesale Price</label>
                <input type="number" step="0.01" name="wholesale_amount" class="form-control">
            </div>
            <div class="col-md-4 mb-3">
                <label>Unit</label>
                <input type="text" name="unit" class="form-control" value="1000">
            </div>
            <div class="col-12 mb-3">
                <label>Details</label>
                <textarea name="details" class="form-control" rows="3"></textarea>
            </div>
            <div class="col-12 mb-3">
                <label>Status</label>
                <select name="status" class="form-select">
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                </select>
            </div>
        </div>
        <button class="btn btn-success">Add Item</button>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\HP\Desktop\posnex\resources\views/inventory/create.blade.php ENDPATH**/ ?>