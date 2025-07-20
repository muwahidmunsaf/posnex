

<?php $__env->startSection('content'); ?>
<div class="container py-4">
    <h3>Activity Logs</h3>
    <form method="GET" class="row g-3 align-items-end mb-3">
        <div class="col-auto">
            <label for="user" class="form-label mb-0">User</label>
            <input type="text" name="user" id="user" class="form-control" value="<?php echo e($user ?? ''); ?>">
        </div>
        <div class="col-auto">
            <label for="role" class="form-label mb-0">Role</label>
            <select name="role" id="role" class="form-select">
                <option value="">All</option>
                <option value="admin" <?php echo e(($role ?? '') == 'admin' ? 'selected' : ''); ?>>Admin</option>
                <option value="superadmin" <?php echo e(($role ?? '') == 'superadmin' ? 'selected' : ''); ?>>Superadmin</option>
                <option value="manager" <?php echo e(($role ?? '') == 'manager' ? 'selected' : ''); ?>>Manager</option>
                <option value="employee" <?php echo e(($role ?? '') == 'employee' ? 'selected' : ''); ?>>Employee</option>
            </select>
        </div>
        <div class="col-auto">
            <label for="action" class="form-label mb-0">Action</label>
            <input type="text" name="action" id="action" class="form-control" value="<?php echo e($action ?? ''); ?>">
        </div>
        <div class="col-auto">
            <label for="date" class="form-label mb-0">Date</label>
            <input type="date" name="date" id="date" class="form-control" value="<?php echo e($date ?? ''); ?>">
        </div>
        <div class="col-auto">
            <button type="submit" class="btn btn-primary">Filter</button>
            <?php if(request('user') || request('role') || request('action') || request('date')): ?>
                <a href="<?php echo e(route('activity-logs.index')); ?>" class="btn btn-secondary ms-2">Clear</a>
            <?php endif; ?>
        </div>
    </form>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Date</th>
                <th>User</th>
                <th>Role</th>
                <th>Action</th>
                <th>Details</th>
            </tr>
        </thead>
        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $logs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $log): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td><?php echo e($log->created_at->format('Y-m-d H:i')); ?></td>
                    <td><?php echo e($log->user_name); ?></td>
                    <td><?php echo e($log->user_role); ?></td>
                    <td><?php echo e($log->action); ?></td>
                    <td><?php echo e($log->details); ?></td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="5" class="text-center">No logs found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
    <?php echo e($logs->links('vendor.pagination.bootstrap-5')); ?>

</div>
<?php $__env->stopSection(); ?> 
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\HP\Desktop\posnex\resources\views/activity_logs/index.blade.php ENDPATH**/ ?>