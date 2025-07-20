<?php $__env->startSection('content'); ?>
    <div class="container">
        <h3>Company Settings</h3>

        <?php if(session('success')): ?>
            <div class="alert alert-success"><?php echo e(session('success')); ?></div>
        <?php endif; ?>

        <?php if(!$company): ?>
            <div class="alert alert-danger">No company found for your account.</div>
        <?php else: ?>
            <form method="POST" action="<?php echo e(route('company.settings.update')); ?>" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>

                <div class="mb-3">
                    <label>Company Name</label>
                    <input name="name" value="<?php echo e(old('name', $company->name)); ?>" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Phone #</label>
                    <input name="cell_no" value="<?php echo e(old('cell_no', $company->cell_no)); ?>" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label>Email</label>
                    <input name="email" value="<?php echo e(old('email', $company->email)); ?>" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label>Website</label>
                    <input name="website" value="<?php echo e(old('website', $company->website)); ?>" class="form-control">
                </div>
                <div class="mb-3">
                    <label>Address</label>
                    <input name="address" value="<?php echo e(old('address', $company->address)); ?>" class="form-control">
                </div>

                <div class="mb-3">
                    <label>Company Logo</label><br>
                    <?php if($company->logo): ?>
                        <img src="<?php echo e(asset('storage/' . $company->logo)); ?>" alt="Current Logo" style="max-height:60px; margin-bottom:8px;">
                    <?php endif; ?>
                    <input type="file" name="logo" class="form-control">
                    <small class="text-muted">Upload a new logo to replace the current one.</small>
                </div>

                <div class="mb-3">
                    <label>Tax % (Cash)</label>
                    <input name="taxCash" value="<?php echo e(old('taxCash', $company->tax_cash)); ?>" class="form-control">
                </div>

                <div class="mb-3">
                    <label>Tax % (Card)</label>
                    <input name="taxCard" value="<?php echo e(old('taxCard', $company->tax_card)); ?>" class="form-control">
                </div>

                <div class="mb-3">
                    <label>Tax % (Online)</label>
                    <input name="taxOnline" value="<?php echo e(old('taxOnline', $company->tax_online)); ?>" class="form-control">
                </div>

                <button class="btn btn-primary">Save Settings</button>
            </form>
        <?php endif; ?>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\HP\Desktop\posnex\resources\views/company/settings.blade.php ENDPATH**/ ?>