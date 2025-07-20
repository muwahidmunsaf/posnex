

<?php $__env->startSection('content'); ?>
    <div class="container">
        <h3>Update Profile</h3>
        <?php if(session('success')): ?>
            <div class="alert alert-success"><?php echo e(session('success')); ?></div>
        <?php endif; ?>

        <form method="POST" action="<?php echo e(route('profile.update')); ?>">
            <?php echo csrf_field(); ?>

            <div class="mb-3">
                <label>Name</label>
                <input name="name" value="<?php echo e(old('name', $user->name)); ?>" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Email</label>
                <input name="email" value="<?php echo e(old('email', $user->email)); ?>" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>New Password <small class="text-muted">(Leave blank if unchanged)</small></label>
                <input type="password" name="password" class="form-control">
            </div>

            <div class="mb-3">
                <label>Confirm New Password</label>
                <input type="password" name="password_confirmation" class="form-control">
            </div>

            <button class="btn btn-primary">Update Profile</button>
        </form>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\HP\Desktop\posnex\resources\views/profile/edit.blade.php ENDPATH**/ ?>