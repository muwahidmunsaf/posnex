<?php $__env->startSection('content'); ?>
    <div class="container">
        <h3>Inventory</h3>

        
        <form id="bulk-delete-form" action="<?php echo e(route('inventory.bulkDelete')); ?>" method="POST" style="display:inline;">
            <?php echo csrf_field(); ?>
            <button type="submit" class="btn btn-danger mb-3" id="delete-selected-btn" disabled>Delete Selected</button>
        </form>

        <div class="d-flex justify-content-between align-items-center mb-3">
            <div class="d-flex align-items-center gap-2">
                <form action="<?php echo e(route('inventory.importExcel')); ?>" method="POST" enctype="multipart/form-data" class="d-flex align-items-center gap-2 mb-0">
                    <?php echo csrf_field(); ?>
                    <input type="file" name="excel_file" accept=".xlsx,.csv" class="form-control" required style="max-width:200px;">
                    <button type="submit" class="btn btn-primary">Import via Excel</button>
                </form>
                <a href="<?php echo e(route('inventory.exportExcel', request()->all())); ?>" class="btn btn-success">Export to Excel</a>
                <a href="<?php echo e(route('inventory.printCatalogue', request()->all())); ?>" class="btn btn-secondary" target="_blank">Print Catalogue</a>
            </div>
            <div class="ms-auto">
                <?php if($inventories instanceof \Illuminate\Pagination\LengthAwarePaginator || $inventories instanceof \Illuminate\Pagination\Paginator): ?>
                    <span>
                        Showing <?php echo e($inventories->firstItem()); ?> to <?php echo e($inventories->lastItem()); ?> of <?php echo e($inventories->total()); ?> products
                    </span>
                <?php else: ?>
                    <span>
                        Showing 1 to <?php echo e($inventories->count()); ?> of <?php echo e($inventories->count()); ?> products
                    </span>
                <?php endif; ?>
            </div>
        </div>

        
        <form method="GET" action="" class="d-inline-block mb-3">
            <label for="per_page" class="me-2">Show</label>
            <select name="per_page" id="per_page" class="form-select d-inline-block w-auto" onchange="this.form.submit()">
                <option value="10" <?php echo e(request('per_page', 10) == 10 ? 'selected' : ''); ?>>10</option>
                <option value="50" <?php echo e(request('per_page') == 50 ? 'selected' : ''); ?>>50</option>
                <option value="100" <?php echo e(request('per_page') == 100 ? 'selected' : ''); ?>>100</option>
                <option value="all" <?php echo e(request('per_page') == 'all' ? 'selected' : ''); ?>>All</option>
            </select>
            <span class="ms-2">products per page</span>
        </form>

        
        <div class="d-flex justify-content-between mb-3">
            <form action="<?php echo e(route('inventory.index')); ?>" method="GET" class="d-flex">
                <input type="text" name="search" value="<?php echo e(request('search')); ?>" class="form-control me-2"
                    placeholder="Search items...">
                <input type="hidden" name="per_page" value="<?php echo e(request('per_page', 10)); ?>">
                <button type="submit" class="btn btn-outline-primary">Search</button>
            </form>
        </div>

        

        <?php if($inventories->count()): ?>
            <table class="table table-bordered align-middle">
                <thead>
                    <tr>
                        <th><input type="checkbox" id="select-all"></th>
                        <th>Item</th>
                        <th>Retail</th>
                        <th>Wholesale</th>
                        <th>Stock</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $inventories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><input type="checkbox" class="row-checkbox" name="selected_ids[]" value="<?php echo e($item->id); ?>" form="bulk-delete-form"></td>
                            <td><?php echo e($item->item_name); ?></td>
                            <td><?php echo e($item->retail_amount); ?></td>
                            <td><?php echo e($item->wholesale_amount); ?></td>
                            <td><?php echo e($item->unit); ?></td>
                            <td>
                                <div class="form-check form-switch">
                                    <input class="form-check-input status-toggle" type="checkbox"
                                        data-id="<?php echo e($item->id); ?>" <?php echo e($item->status === 'active' ? 'checked' : ''); ?>>
                                    <label class="form-check-label">
                                        <?php echo e($item->status === 'active' ? 'Active' : 'Inactive'); ?>

                                    </label>
                                </div>
                            </td>
                            <td>
                                <a href="<?php echo e(route('inventory.edit', $item->id)); ?>" class="btn btn-sm btn-warning">Edit</a>
                                <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                    data-bs-target="#deleteModal<?php echo e($item->id); ?>">
                                    Delete
                                </button>
                                <div class="modal fade" id="deleteModal<?php echo e($item->id); ?>" tabindex="-1"
                                    aria-labelledby="deleteModalLabel<?php echo e($item->id); ?>" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-top">
                                        <div class="modal-content">
                                            <div class="modal-header bg-danger text-white">
                                                <h5 class="modal-title" id="deleteModalLabel<?php echo e($item->id); ?>">Confirm
                                                    Delete
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                Are you sure you want to delete <strong><?php echo e($item->name); ?></strong>?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Cancel</button>
                                                <form action="<?php echo e(route('inventory.destroy', $item->id)); ?>" method="POST"
                                                    class="d-inline">
                                                    <?php echo csrf_field(); ?>
                                                    <?php echo method_field('DELETE'); ?>
                                                    <button type="submit" class="btn btn-danger">Yes, Delete</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>

            <?php if($inventories instanceof \Illuminate\Pagination\LengthAwarePaginator || $inventories instanceof \Illuminate\Pagination\Paginator): ?>
                <?php echo e($inventories->links('vendor.pagination.bootstrap-5')); ?>

            <?php endif; ?>
        <?php else: ?>
            <p>No items found.</p>
        <?php endif; ?>
    </div>
    <?php $__env->startPush('scripts'); ?>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                document.querySelectorAll('.status-toggle').forEach(function(toggle) {
                    toggle.addEventListener('change', function() {
                        const itemId = this.dataset.id;
                        const isChecked = this.checked;

                        fetch(`/inventory/${itemId}/toggle-status`, {
                                method: 'PATCH',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
                                },
                                body: JSON.stringify({
                                    status: isChecked ? 'active' : 'inactive'
                                })
                            })
                            .then(res => {
                                if (!res.ok) throw new Error('Failed to update status.');
                                return res.json();
                            })
                            .then(data => {
                                this.nextElementSibling.textContent = data.status_label;
                            })
                            .catch(error => {
                                alert(error.message);
                                this.checked = !isChecked; // revert if failed
                            });
                    });
                });

                // Bulk select logic
                const selectAll = document.getElementById('select-all');
                const checkboxes = document.querySelectorAll('.row-checkbox');
                const deleteBtn = document.getElementById('delete-selected-btn');
                function updateDeleteBtn() {
                    const anyChecked = Array.from(checkboxes).some(cb => cb.checked);
                    deleteBtn.disabled = !anyChecked;
                }
                selectAll.addEventListener('change', function() {
                    checkboxes.forEach(cb => cb.checked = selectAll.checked);
                    updateDeleteBtn();
                });
                checkboxes.forEach(cb => {
                    cb.addEventListener('change', function() {
                        updateDeleteBtn();
                        if (!cb.checked) selectAll.checked = false;
                        else if (Array.from(checkboxes).every(cb => cb.checked)) selectAll.checked = true;
                    });
                });
                updateDeleteBtn();
            });
        </script>
    <?php $__env->stopPush(); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\HP\Desktop\posnex\resources\views/inventory/index.blade.php ENDPATH**/ ?>