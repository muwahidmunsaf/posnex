
<?php $__env->startSection('content'); ?>
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body">
                    <h3 class="mb-4 text-danger" style="font-weight:700;"><i class="bi bi-arrow-repeat me-2"></i> Reset Application Data</h3>
                    <?php if(session('success')): ?>
                        <div class="alert alert-success"><?php echo e(session('success')); ?></div>
                    <?php endif; ?>
                    <?php if(session('error')): ?>
                        <div class="alert alert-danger"><?php echo e(session('error')); ?></div>
                    <?php endif; ?>
                    <form method="POST" action="<?php echo e(route('admin.reset-data.post')); ?>" onsubmit="return confirm('Are you sure? This cannot be undone!')">
                        <?php echo csrf_field(); ?>
                        <div class="mb-3">
                            <div class="form-check form-check-inline">
                                <input type="checkbox" id="select-all" value="all" name="modules[]" class="form-check-input">
                                <label class="form-check-label fw-bold" for="select-all">Select All</label>
                            </div>
                        </div>
                        <div class="row g-2 mb-3">
                            <?php $__currentLoopData = $modules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="col-md-4 col-6">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input module-checkbox" name="modules[]" value="<?php echo e($key); ?>" id="module-<?php echo e($key); ?>">
                                        <label class="form-check-label" for="module-<?php echo e($key); ?>"><?php echo e($label); ?></label>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                        <button type="submit" class="btn btn-danger w-100 py-2 fw-bold" style="font-size:1.1rem;"><i class="bi bi-trash3 me-1"></i> Reset Selected Data</button>
                    </form>
                    <div class="alert alert-warning mt-4 mb-0">
                        <strong>Warning:</strong> This will permanently delete all selected data from the application.<br>
                        <b>Users will NOT be deleted.</b> Please proceed with caution.
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
document.getElementById('select-all').onclick = function() {
    var checkboxes = document.querySelectorAll('.module-checkbox');
    for (var checkbox of checkboxes) {
        checkbox.checked = this.checked;
    }
};
</script>
<?php $__env->stopSection(); ?> 
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\HP\Desktop\posnex\resources\views/admin/reset_data.blade.php ENDPATH**/ ?>