<div class="d-flex" style="min-height: 100vh; overflow: hidden;">
    <div class="d-flex flex-column flex-shrink-0 p-3 bg-light border-end shadow-sm"
        style="width: 250px; height: 100vh; position: fixed; top: 0; left: 0; z-index: 1030;">
        
        <a href="<?php echo e(url('/')); ?>" class="d-flex align-items-center mb-4 text-decoration-none">
            <img src="<?php echo e(asset('logo.png')); ?>" alt="Irshad Autos Logo" style="height: 32px; margin-right: 8px;">
            <span class="fs-5 fw-semibold text-danger">Irshad Autos</span>
        </a>

        <hr>

        <ul class="nav nav-pills flex-column mb-auto">
            
            <li class="nav-item">
                <a href="<?php echo e(route('sales.create')); ?>" 
                   class="nav-link <?php echo e(request()->routeIs('sales.create') ? 'active' : 'text-dark'); ?>">
                    <i class="bi bi-cash me-2"></i> Create Sale
                </a>
            </li>

            
            <li class="nav-item">
                <a href="<?php echo e(route('sales.index')); ?>" 
                   class="nav-link <?php echo e(request()->routeIs('sales.index') ? 'active' : 'text-dark'); ?>">
                    <i class="bi bi-list-check me-2"></i> Sales Record
                </a>
            </li>

            
            <li class="nav-item">
                <a href="<?php echo e(route('external-sales.index')); ?>" 
                   class="nav-link <?php echo e(request()->routeIs('external-sales.index') ? 'active' : 'text-dark'); ?>">
                    <i class="bi bi-list-check me-2"></i> Manual Sales Record
                </a>
            </li>

            
            <li class="nav-item">
                <a href="<?php echo e(route('inventory.status')); ?>" 
                   class="nav-link <?php echo e(request()->routeIs('inventory.status') ? 'active' : 'text-dark'); ?>">
                    <i class="bi bi-box-seam me-2"></i> Inventory
                </a>
            </li>
        </ul>

        <ul class="nav nav-pills flex-column mb-auto">
            
        </ul>

        <hr>

        <div class="text-muted small">
            Logged in as<br><strong><?php echo e(auth()->user()->name ?? 'Guest'); ?></strong>
        </div>
    </div>
</div>
<?php /**PATH C:\Users\HP\Desktop\posnex\resources\views/includes/posSidebar.blade.php ENDPATH**/ ?>