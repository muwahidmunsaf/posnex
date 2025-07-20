<!doctype html>
<html lang="en">

<head>
    <title>Irshad Autos</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <style>
        .collapse .nav-link {
            background-color: transparent !important;
            color: #212529 !important;
        }

        .collapse .nav-link:hover {
            background-color: #f8f9fa !important;
            color: #0d6efd !important;
        }
        body {
            color: #d32f2f !important;
        }
    </style>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous" />

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.2.0/dist/chartjs-plugin-datalabels.min.js"></script>


</head>

<body>
    <header>
        {{-- @include('includes.navbar')
        @include('includes.sidebar') --}}
    </header>
    <div class="d-flex">
        @include('includes.sidebar')
        <div class="flex-grow-1 p-3" style="margin-left: 250px;">
            @include('includes.navbar')
            <main class="mt-2">
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif

                {{-- @if (session('success'))
                    <p style="color:green;">{{ session('success') }}</p>
                @endif

                @if ($errors->any())
                    <ul style="color:red;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                @endif --}}

                <div class="p-4">
                    @yield('content')
                </div>
            </main>
        </div>
    </div>
    <footer>
        <!-- place footer here -->
    </footer>
    @stack('scripts')
    <!-- Bootstrap JavaScript Libraries -->
    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous">
    </script>


    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" crossorigin="anonymous">
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" crossorigin="anonymous">
    </script>

</body>

</html>
