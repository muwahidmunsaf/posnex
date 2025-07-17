<nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
    <div class="container-fluid">
        <a class="navbar-brand fw-bold" href="{{ url('/') }}">
            <img src="{{ asset('logo.png') }}" alt="Irshad Autos Logo" style="height: 40px;">
            <span class="brand-text">Irshad Autos</span>
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
                    @php
                        $user = Auth::user();
                    @endphp

                    @if ($user && $user->role !== 'employee')
                        <li class="nav-item">
                            <a class="btn mt-2 me-3 btn-danger" href="{{ url('/dashboard') }}">Dashboard</a>
                        </li>
                    @endif

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="userDropdown"
                            role="button" data-bs-toggle="dropdown">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=0D8ABC&color=fff&size=32"
                                alt="Avatar" class="rounded-circle me-2" style="width: 32px; height: 32px;">
                            {{ auth()->user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                            @php
                                $user = Auth::user();
                            @endphp

                            @if ($user && $user->role == 'superadmin')
                                <li><a class="dropdown-item" href="{{ route('companies.index') }}">Companies</a></li>
                                <li><a class="dropdown-item" href="{{ route('users.index') }}">Users</a></li>
                            @endif
                            <li>
                                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="dropdown-item">Logout</button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>
