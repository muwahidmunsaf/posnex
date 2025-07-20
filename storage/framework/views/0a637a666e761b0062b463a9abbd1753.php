<?php $__env->startSection('content'); ?>
<div class="container">
    <h3>Edit Inventory Item</h3>
    <form method="POST" action="<?php echo e(route('inventory.update', $inventory->id)); ?>" enctype="multipart/form-data">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label>Item Name</label>
                <input type="text" name="item_name" value="<?php echo e(old('item_name', $inventory->item_name)); ?>" class="form-control" required>
            </div>

            <div class="col-md-3 mb-3">
                <label>Retail Price</label>
                <input type="number" name="retail_amount" step="0.01" value="<?php echo e(old('retail_amount', $inventory->retail_amount)); ?>" class="form-control" required>
            </div>

            <div class="col-md-3 mb-3">
                <label>Wholesale Price</label>
                <input type="number" name="wholesale_amount" step="0.01" value="<?php echo e(old('wholesale_amount', $inventory->wholesale_amount)); ?>" class="form-control">
            </div>

            <div class="col-md-4 mb-3">
                <label>Unit</label>
                <input type="text" name="unit" value="<?php echo e(old('unit', $inventory->unit)); ?>" class="form-control" required>
            </div>

            <div class="col-12 mb-3">
                <label>Details</label>
                <textarea name="details" class="form-control" rows="3"><?php echo e(old('details', $inventory->details)); ?></textarea>
            </div>

            <div class="col-12 mb-3">
                <label>Status</label>
                <select name="status" class="form-select" required>
                    <option value="active" <?php echo e($inventory->status == 'active' ? 'selected' : ''); ?>>Active</option>
                    <option value="inactive" <?php echo e($inventory->status == 'inactive' ? 'selected' : ''); ?>>Inactive</option>
                </select>
            </div>

            <div class="col-12">
                <button class="btn btn-primary">Update Item</button>
            </div>
        </div>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\HP\Desktop\posnex\resources\views/inventory/edit.blade.php ENDPATH**/ ?>