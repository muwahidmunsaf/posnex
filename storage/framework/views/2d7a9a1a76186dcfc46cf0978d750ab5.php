<nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
    <div class="container-fluid">
        <a class="navbar-brand fw-bold" href="<?php echo e(url('/')); ?>">
            <img src="<?php echo e(asset('logo.png')); ?>" alt="Irshad Autos Logo" style="height: 40px;">
            <span class="brand-text">Irshad Autos</span>
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="mainNavbar">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <?php if(auth()->guard()->check()): ?>
                    
                <?php endif; ?>
            </ul>

            <ul class="navbar-nav ms-auto">
                <?php if(auth()->guard()->guest()): ?>
                    <li class="nav-item">
                        <a class="btn btn-outline-danger" href="<?php echo e(route('login')); ?>">Login</a>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="btn mt-2 me-3 btn-danger" href="<?php echo e(route('sales.create')); ?>">Point of Sale (POS)</a>
                    </li>
                    <!-- Reminder Bell Icon -->
                    <li class="nav-item dropdown" id="reminder-bell-dropdown">
                        <a class="nav-link position-relative" href="#" id="reminderBell" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-bell" style="font-size: 1.5rem;"></i>
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" id="reminder-badge" style="display:none;">0</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="reminderBell" style="min-width: 350px; max-width: 400px;">
                            <li class="dropdown-header">Reminders</li>
                            <li id="reminder-list-empty"><span class="dropdown-item-text text-muted">No due reminders.</span></li>
                            <div id="reminder-list"></div>
                            <li><hr class="dropdown-divider"></li>
                            <li><a href="<?php echo e(route('notes.index')); ?>" class="dropdown-item text-center">View All Notes/Reminders</a></li>
                        </ul>
                    </li>
                    <?php if(auth()->guard()->check()): ?>
                        <li class="nav-item dropdown dropdown-hover">
                            <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="userDropdown"
                                role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <img src="https://ui-avatars.com/api/?name=<?php echo e(urlencode(auth()->user()->name)); ?>&background=0D8ABC&color=fff&size=32"
                                    alt="Avatar" class="rounded-circle me-2" style="width: 32px; height: 32px;">
                                <?php echo e(auth()->user()->name); ?>

                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                                <?php if(auth()->user()->role === 'superadmin'): ?>
                                    
                                    <li><a class="dropdown-item" href="<?php echo e(route('users.index')); ?>">Users</a></li>
                                <?php endif; ?>
                                <li><a class="dropdown-item" href="<?php echo e(route('company.settings.edit')); ?>">Company Details</a></li>
                                <li><a class="dropdown-item" href="<?php echo e(route('profile.edit')); ?>">Update Profile</a></li>
                                <?php if(in_array(auth()->user()->role, ['admin', 'superadmin'])): ?>
                                    <li><a class="dropdown-item" href="/manage-backup">CSV Backup & Restore</a></li>
                                <?php endif; ?>
                                <li>
                                    <form action="<?php echo e(route('logout')); ?>" method="POST" class="d-inline">
                                        <?php echo csrf_field(); ?>
                                        <button type="submit" class="dropdown-item">Logout</button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    <?php endif; ?>


                <?php endif; ?>
            </ul>

        </div>
    </div>
</nav>
<?php /**PATH C:\Users\HP\Desktop\posnex\resources\views/includes/navbar.blade.php ENDPATH**/ ?>