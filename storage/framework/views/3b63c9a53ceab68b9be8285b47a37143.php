

<?php $__env->startSection('content'); ?>
<div class="container">
    <h2>Cloud Backup Settings</h2>
    <?php if(session('success')): ?>
        <div class="alert alert-success"><?php echo e(session('success')); ?></div>
    <?php endif; ?>
    <div class="card mt-4">
        <div class="card-body">
            <?php if($cloudBackup): ?>
                <p><strong>Connected Google Account:</strong> <?php echo e($cloudBackup->name); ?> (<?php echo e($cloudBackup->email); ?>)</p>
                <a href="<?php echo e(route('cloud-backup.google.redirect')); ?>" class="btn btn-primary mb-3">Change Google Drive Account</a>
                <hr>
                <form method="POST" action="<?php echo e(route('cloud-backup.settings.update')); ?>">
                    <?php echo csrf_field(); ?>
                    <div class="mb-3">
                        <label for="frequency" class="form-label">Backup Frequency</label>
                        <select name="frequency" id="frequency" class="form-select" required>
                            <option value="daily" <?php echo e($cloudBackup->frequency == 'daily' ? 'selected' : ''); ?>>Daily</option>
                            <option value="weekly" <?php echo e($cloudBackup->frequency == 'weekly' ? 'selected' : ''); ?>>Weekly</option>
                            <option value="monthly" <?php echo e($cloudBackup->frequency == 'monthly' ? 'selected' : ''); ?>>Monthly</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="time" class="form-label">Backup Time (24h format)</label>
                        <input type="time" name="time" id="time" class="form-control" value="<?php echo e($cloudBackup->time ?? '02:00'); ?>" required>
                    </div>
                    <button type="submit" class="btn btn-success">Save Schedule</button>
                </form>
                <?php if($cloudBackup->last_run_at): ?>
                    <p class="mt-3 text-muted">Last backup run: <?php echo e($cloudBackup->last_run_at->format('Y-m-d H:i')); ?></p>
                <?php endif; ?>
            <?php else: ?>
                <p>No Google Drive account connected.</p>
                <a href="<?php echo e(route('cloud-backup.google.redirect')); ?>" class="btn btn-success">Connect Google Drive Account</a>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?> 
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\HP\Desktop\posnex\resources\views/admin/cloud_backup_settings.blade.php ENDPATH**/ ?>