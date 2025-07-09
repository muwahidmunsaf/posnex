<div class="d-flex" style="min-height: 100vh; overflow: hidden;">
    <div class="d-flex flex-column flex-shrink-0 p-3 bg-light border-end shadow-sm"
        style="width: 250px; height: 100vh; max-height: 100vh; overflow-y: auto; position: fixed; top: 0; left: 0; z-index: 1030;">
        <a href="{{ url('/') }}" class="d-flex align-items-center mb-4 text-decoration-none">
            <i class="bi bi-shop me-2 fs-4 text-primary"></i>
            <span class="fs-5 fw-semibold">{{ config('app.name', 'POS') }}</span>
        </a>
        <hr>

        <ul class="nav nav-pills flex-column mb-auto">
            @php
                $user = auth()->user();
                $isAdmin = $user && in_array($user->role, ['admin', 'superadmin']);
                $perms = $user && is_array($user->permissions) ? $user->permissions : [];
            @endphp

            {{-- Dashboard --}}
            <li class="nav-item">
                <a href="{{ url('/dashboard') }}"
                    class="nav-link {{ request()->is('dashboard') ? 'active' : 'text-dark' }}">
                    <i class="bi bi-speedometer me-2"></i> Dashboard
                </a>
            </li>

            {{-- Inventory --}}
            @if($isAdmin || in_array('inventory', $perms))
            <li>
                <a class="nav-link d-flex justify-content-between align-items-center {{ request()->is('inventory*') || request()->is('purchase*') || request()->is('categories*') ? '' : 'collapsed' }}"
                    data-bs-toggle="collapse" href="#inventoryMenu"
                    aria-expanded="{{ request()->is('inventory*') || request()->is('purchase*') || request()->is('categories*') ? 'true' : 'false' }}">
                    <span><i class="bi bi-box-seam me-2"></i> Inventory</span>
                    <i class="bi bi-chevron-down"></i>
                </a>
                <div class="collapse {{ request()->is('inventory*') || request()->is('purchase*') || request()->is('categories*') ? 'show' : '' }}"
                    id="inventoryMenu">
                    <ul class="nav flex-column ps-4">
                        <li><a href="{{ route('inventory.index') }}"
                                class="nav-link {{ request()->routeIs('inventory.index') ? 'active' : 'text-dark' }}">View
                                Inventory</a></li>
                        <li><a href="{{ route('inventory.create') }}"
                                class="nav-link {{ request()->routeIs('inventory.create') ? 'active' : 'text-dark' }}">Add
                                Item</a></li>
                        <li><a href="{{ route('purchase.index') }}"
                                class="nav-link {{ request()->routeIs('purchase.index') ? 'active' : 'text-dark' }}">Stock
                                Entry</a></li>
                        <li><a href="{{ route('categories.index') }}"
                                class="nav-link {{ request()->routeIs('categories.index') ? 'active' : 'text-dark' }}">Categories</a>
                        </li>
                    </ul>
                </div>
            </li>
            @endif

            {{-- Suppliers & Customers --}}
            <li>
                <a class="nav-link d-flex justify-content-between align-items-center {{ request()->is('suppliers*') || request()->is('customers*') ? '' : 'collapsed' }}"
                    data-bs-toggle="collapse" href="#customerMenu"
                    aria-expanded="{{ request()->is('suppliers*') || request()->is('customers*') ? 'true' : 'false' }}">
                    <span><i class="bi bi-person-lines-fill me-2"></i> Suppliers / Customers</span>
                    <i class="bi bi-chevron-down"></i>
                </a>
                <div class="collapse {{ request()->is('suppliers*') || request()->is('customers*') ? 'show' : '' }}"
                    id="customerMenu">
                    <ul class="nav flex-column ps-4">
                        <li><a href="{{ route('suppliers.index') }}"
                                class="nav-link {{ request()->routeIs('suppliers.index') ? 'active' : 'text-dark' }}">Supplier
                                List</a></li>
                        <li><a href="{{ route('suppliers.create') }}"
                                class="nav-link {{ request()->routeIs('suppliers.create') ? 'active' : 'text-dark' }}">Add
                                Supplier</a></li>
                        <li><a href="{{ route('customers.index') }}"
                                class="nav-link {{ request()->routeIs('customers.index') ? 'active' : 'text-dark' }}">Customer
                                List</a></li>
                        <li><a href="{{ route('customers.create') }}"
                                class="nav-link {{ request()->routeIs('customers.create') ? 'active' : 'text-dark' }}">Add
                                Customer</a></li>
                    </ul>
                </div>
            </li>

            {{-- Expenses --}}
            @if($isAdmin || in_array('expenses', $perms))
            <li>
                <a href="{{ route('expenses.index') }}"
                    class="nav-link {{ request()->is('expenses') ? 'active' : 'text-dark' }}">
                    <i class="bi bi-wallet2 me-2"></i> Expenses
                </a>
            </li>
            @endif

            {{-- HR Management --}}
            @if($isAdmin || in_array('employees', $perms))
            <li>
                <a class="nav-link d-flex justify-content-between align-items-center {{ request()->is('employees*') || request()->is('salaries*') ? '' : 'collapsed' }}"
                    data-bs-toggle="collapse" href="#hrMenu"
                    aria-expanded="{{ request()->is('employees*') || request()->is('salaries*') ? 'true' : 'false' }}">
                    <span><i class="bi bi-people-fill me-2"></i> HR Management</span>
                    <i class="bi bi-chevron-down"></i>
                </a>
                <div class="collapse {{ request()->is('employees*') || request()->is('salaries*') ? 'show' : '' }}" id="hrMenu">
                    <ul class="nav flex-column ps-4">
                        <li><a href="{{ route('employees.index') }}"
                                class="nav-link {{ request()->routeIs('employees.index') ? 'active' : 'text-dark' }}">Employees</a></li>
                        <li><a href="{{ route('salaries.index') }}"
                                class="nav-link {{ request()->routeIs('salaries.index') ? 'active' : 'text-dark' }}">Salary Payments</a></li>
                    </ul>
                </div>
            </li>
            @endif

            {{-- Reports --}}
            @if($isAdmin || in_array('reports', $perms))
            <li>
                <a class="nav-link d-flex justify-content-between align-items-center {{ request()->is('reports*') ? '' : 'collapsed' }}"
                    data-bs-toggle="collapse" href="#reportMenu"
                    aria-expanded="{{ request()->is('reports*') ? 'true' : 'false' }}">
                    <span><i class="bi bi-bar-chart me-2"></i> Reports</span>
                    <i class="bi bi-chevron-down"></i>
                </a>
                <div class="collapse {{ request()->is('reports*') ? 'show' : '' }}" id="reportMenu">
                    <ul class="nav flex-column ps-4">
                        <li><a href="{{ route('reports.stock') }}"
                                class="nav-link {{ request()->routeIs('reports.stock') ? 'active' : 'text-dark' }}">Stock
                                Report</a></li>
                        <li><a href="{{ route('reports.finance') }}"
                                class="nav-link {{ request()->routeIs('reports.finance') ? 'active' : 'text-dark' }}">Finance
                                Report</a></li>
                        <li><a href="{{ route('reports.invoices') }}"
                                class="nav-link {{ request()->routeIs('reports.invoices') ? 'active' : 'text-dark' }}">Invoices</a>
                        </li>
                        <li><a href="{{ route('reports.purchase') }}"
                                class="nav-link {{ request()->routeIs('reports.purchase') ? 'active' : 'text-dark' }}">Purchases</a>
                        </li>
                        <li><a href="{{ route('reports.externalSales') }}"
                                class="nav-link {{ request()->routeIs('reports.externalSales') ? 'active' : 'text-dark' }}">External
                                Sales</a></li>
                        <li><a href="{{ route('reports.externalPurchases') }}"
                                class="nav-link {{ request()->routeIs('reports.externalPurchases') ? 'active' : 'text-dark' }}">External
                                Purchases</a></li>
                    </ul>
                </div>
            </li>
            @endif

            {{-- Returns/Exchanges --}}
            @if(auth()->check() && in_array(auth()->user()->role, ['admin', 'superadmin']))
                <li class="mt-2">
                    <a class="nav-link d-flex justify-content-between align-items-center {{ request()->routeIs('returns.index') ? 'active' : 'collapsed' }}"
                        href="{{ route('returns.index') }}">
                        <span><i class="bi bi-arrow-counterclockwise me-2"></i> Returns/Exchanges</span>
                    </a>
                </li>
            @endif

            {{-- User Management --}}
            @if(auth()->check() && in_array(auth()->user()->role, ['admin', 'superadmin']))
                <li class="mt-2">
                    <a class="nav-link d-flex justify-content-between align-items-center {{ request()->is('users*') ? '' : 'collapsed' }}"
                        href="{{ route('users.index') }}">
                        <span><i class="bi bi-people me-2"></i> User Management</span>
                    </a>
                </li>
            @endif

            {{-- Activity Logs --}}
            @if(auth()->check() && in_array(auth()->user()->role, ['admin', 'superadmin']))
                <li class="mt-2">
                    <a class="nav-link d-flex justify-content-between align-items-center {{ request()->is('activity-logs*') ? '' : 'collapsed' }}"
                        href="{{ route('activity-logs.index') }}">
                        <span><i class="bi bi-clock-history me-2"></i> Activity Logs</span>
                    </a>
                </li>
            @endif

        </ul>

        <hr>
        <div class="text-muted small">
            Logged in as<br><strong>{{ auth()->user()->name ?? 'Guest' }}</strong>
        </div>
    </div>
</div>
