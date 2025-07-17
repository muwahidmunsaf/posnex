<div class="d-flex" style="min-height: 100vh; overflow: hidden;">
    <div class="d-flex flex-column flex-shrink-0 p-3 bg-light border-end shadow-sm"
        style="width: 250px; height: 100vh; position: fixed; top: 0; left: 0; z-index: 1030;">
        
        <a href="{{ url('/') }}" class="d-flex align-items-center mb-4 text-decoration-none">
            <img src="{{ asset('logo.png') }}" alt="Irshad Autos Logo" style="height: 32px; margin-right: 8px;">
            <span class="fs-5 fw-semibold text-danger">Irshad Autos</span>
        </a>

        <hr>

        <ul class="nav nav-pills flex-column mb-auto">
            {{-- Create Sale --}}
            <li class="nav-item">
                <a href="{{ route('sales.create') }}" 
                   class="nav-link {{ request()->routeIs('sales.create') ? 'active' : 'text-dark' }}">
                    <i class="bi bi-cash me-2"></i> Create Sale
                </a>
            </li>

            {{-- Sales Record --}}
            <li class="nav-item">
                <a href="{{ route('sales.index') }}" 
                   class="nav-link {{ request()->routeIs('sales.index') ? 'active' : 'text-dark' }}">
                    <i class="bi bi-list-check me-2"></i> Sales Record
                </a>
            </li>

            {{-- Manual Sales Record --}}
            <li class="nav-item">
                <a href="{{ route('external-sales.index') }}" 
                   class="nav-link {{ request()->routeIs('external-sales.index') ? 'active' : 'text-dark' }}">
                    <i class="bi bi-list-check me-2"></i> Manual Sales Record
                </a>
            </li>

            {{-- Inventory --}}
            <li class="nav-item">
                <a href="{{ route('inventory.status') }}" 
                   class="nav-link {{ request()->routeIs('inventory.status') ? 'active' : 'text-dark' }}">
                    <i class="bi bi-box-seam me-2"></i> Inventory
                </a>
            </li>
        </ul>

        <hr>

        <div class="text-muted small">
            Logged in as<br><strong>{{ auth()->user()->name ?? 'Guest' }}</strong>
        </div>
    </div>
</div>
