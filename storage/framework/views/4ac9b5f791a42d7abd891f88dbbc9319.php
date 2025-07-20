<?php $__env->startSection('content'); ?>
<div class="container py-4">
    <h2 class="mb-4 fw-bold text-primary"><i class="bi bi-hdd-stack"></i> Backup</h2>
    <div class="row g-4 align-items-stretch">
        <div class="col-12 col-lg-6">
            <div class="card shadow-sm h-100 border-0 bg-light">
                <div class="card-header bg-white fw-bold border-bottom"><i class="bi bi-table"></i> Select Data to Backup</div>
                <div class="card-body">
                    <form action="<?php echo e(route('admin.csv-backup.export')); ?>" method="POST" id="backup-form">
                        <?php echo csrf_field(); ?>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" id="select-all">
                            <label class="form-check-label fw-bold" for="select-all"><i class="bi bi-check2-square"></i> Select All</label>
                        </div>
                        <div class="row row-cols-1 row-cols-md-2 g-2">
                            <div class="col">
                                <div class="form-check mb-2">
                                    <input class="form-check-input backup-category" type="checkbox" name="categories[]" value="users" id="users">
                                    <label class="form-check-label" for="users"><i class="bi bi-people"></i> Users & Roles</label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input backup-category" type="checkbox" name="categories[]" value="suppliers" id="suppliers">
                                    <label class="form-check-label" for="suppliers"><i class="bi bi-truck"></i> Suppliers & Payments</label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input backup-category" type="checkbox" name="categories[]" value="shopkeepers" id="shopkeepers">
                                    <label class="form-check-label" for="shopkeepers"><i class="bi bi-shop"></i> Shopkeepers & Transactions</label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input backup-category" type="checkbox" name="categories[]" value="distributors" id="distributors">
                                    <label class="form-check-label" for="distributors"><i class="bi bi-box-seam"></i> Distributors, Payments, Products</label>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-check mb-2">
                                    <input class="form-check-input backup-category" type="checkbox" name="categories[]" value="returns" id="returns">
                                    <label class="form-check-label" for="returns"><i class="bi bi-arrow-counterclockwise"></i> Returns</label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input backup-category" type="checkbox" name="categories[]" value="hr" id="hr">
                                    <label class="form-check-label" for="hr"><i class="bi bi-person-badge"></i> HR (Employees, Salaries)</label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input backup-category" type="checkbox" name="categories[]" value="reports" id="reports">
                                    <label class="form-check-label" for="reports"><i class="bi bi-bar-chart"></i> Reports (Sales, Purchases, Expenses, etc.)</label>
                                </div>
                            </div>
                        </div>
                        <div class="text-end mt-3">
                            <button type="submit" class="btn btn-primary btn-lg px-4 py-2 shadow-sm"><i class="bi bi-download"></i> Download Backup (XLSX ZIP)</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-6 d-flex flex-column gap-4">
            <div class="card shadow-sm border-0 bg-danger bg-opacity-10 h-100 mb-0">
                <div class="card-header bg-danger text-white fw-bold border-0"><i class="bi bi-exclamation-triangle"></i> Full System Backup</div>
                <div class="card-body">
                    <p class="mb-3">This will create a ZIP file containing a full database backup (.sql) and all important files. <span class="text-danger fw-bold">Use this for disaster recovery or migration.</span></p>
                    <form action="<?php echo e(route('admin.full-backup')); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="btn btn-danger btn-lg px-4 py-2 shadow-sm"><i class="bi bi-hdd-network"></i> Download Full System Backup (ZIP)</button>
                    </form>
                </div>
            </div>
            <div class="card shadow-sm border-0 bg-info bg-opacity-10 h-100 mb-0">
                <div class="card-header bg-info text-white fw-bold border-0"><i class="bi bi-cloud-arrow-up"></i> Cloud Backup (Google Drive)</div>
                <div class="card-body">
                    <?php if(isset($cloudBackup) && $cloudBackup): ?>
                        <div class="d-flex align-items-center mb-2">
                            <span class="me-2" style="display:inline-block;width:32px;height:32px;background:#fff;border-radius:6px;box-shadow:0 1px 2px #0001;text-align:center;line-height:32px;">
                                <i class="bi bi-person-check-fill text-success" style="font-size:1.5rem;"></i>
                            </span>
                            <div>
                                <strong>Connected Google Account:</strong> <?php echo e($cloudBackup->name); ?> (<?php echo e($cloudBackup->email); ?>)
                            </div>
                        </div>
                        <a href="<?php echo e(route('cloud-backup.google.redirect')); ?>" class="btn btn-outline-primary btn-sm mb-3"><i class="bi bi-google"></i> Change Google Drive Account</a>
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
                            <button type="submit" class="btn btn-success px-4 py-2 shadow-sm"><i class="bi bi-save"></i> Save Schedule</button>
                        </form>
                        <?php if($cloudBackup->last_run_at): ?>
                            <div class="mt-3 text-muted"><i class="bi bi-clock-history"></i> Last backup run: <span class="badge bg-light text-dark"><?php echo e($cloudBackup->last_run_at->format('Y-m-d H:i')); ?></span></div>
                        <?php endif; ?>
                    <?php else: ?>
                        <p>No Google Drive account connected.</p>
                        <a href="<?php echo e(route('cloud-backup.google.redirect')); ?>" class="btn btn-success"><i class="bi bi-google"></i> Connect Google Drive Account</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <script>
        // Select All logic
        document.getElementById('select-all').addEventListener('change', function() {
            document.querySelectorAll('.backup-category').forEach(cb => cb.checked = this.checked);
        });
    </script>
</div>
<?php $__env->stopSection(); ?> 
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\HP\Desktop\posnex\resources\views/admin/csv_backup.blade.php ENDPATH**/ ?>