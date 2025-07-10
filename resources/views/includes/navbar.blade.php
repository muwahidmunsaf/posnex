<nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
    <div class="container-fluid">
        <a class="navbar-brand fw-bold" href="{{ url('/') }}">
            <img src="{{ asset('logo.png') }}" alt="Daisho Gold Logo" style="height: 40px;">
            <span class="brand-text">Daisho Gold</span>
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="mainNavbar">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                @auth
                    {{-- <li class="nav-item">
            <a class="nav-link" href="{{ route('companies.index') }}">Companies</a>
          </li> --}}
                @endauth
            </ul>

            <ul class="navbar-nav ms-auto">
                @guest
                    <li class="nav-item">
                        <a class="btn btn-outline-danger" href="{{ route('login') }}">Login</a>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="btn mt-2 me-3 btn-danger" href="{{ route('sales.create') }}">Point of Sale (POS)</a>
                    </li>
                    @auth
                        <li class="nav-item dropdown dropdown-hover">
                            <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="userDropdown"
                                role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=0D8ABC&color=fff&size=32"
                                    alt="Avatar" class="rounded-circle me-2" style="width: 32px; height: 32px;">
                                {{ auth()->user()->name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                                @if (auth()->user()->role === 'superadmin')
                                    <li><a class="dropdown-item" href="{{ route('companies.index') }}">Companies</a></li>
                                    <li><a class="dropdown-item" href="{{ route('users.index') }}">Users</a></li>
                                @endif
                                <li><a class="dropdown-item" href="{{ route('company.settings.edit') }}">Company Details</a></li>
                                <li><a class="dropdown-item" href="{{ route('profile.edit') }}">Update Profile</a></li>
                                @if (in_array(auth()->user()->role, ['admin', 'superadmin']))
                                    <li><a class="dropdown-item" href="{{ route('admin.backups') }}">Manage Backups</a></li>
                                    <li>
                                        <form action="{{ route('admin.backup') }}" method="POST" id="profile-backup-form">
                                            @csrf
                                            <button type="submit" class="dropdown-item">Backup Now</button>
                                        </form>
                                    </li>
                                    <li>
                                        <form action="{{ route('admin.restore') }}" method="POST" id="profile-restore-form">
                                            @csrf
                                            <button type="submit" class="dropdown-item">Restore (Coming Soon)</button>
                                        </form>
                                    </li>
                                @endif
                                <li>
                                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="dropdown-item">Logout</button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @endauth


                @endguest
            </ul>

        </div>
    </div>
</nav>
