<!doctype html>
<html lang="en">

<head>
    <title>{{ $title }}</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="{{ basset(base_path('vendor/twbs/bootstrap/dist/css/bootstrap.min.css')) }}">
    <link rel="stylesheet" href="{{ basset(base_path('vendor/twbs/bootstrap-icons/font/bootstrap-icons.min.css')) }}">

    <link href="/vendor/DataTables-1.13.6/datatables.min.css" rel="stylesheet">

    <link rel="stylesheet" href="/vendor/fontawesome-free-6.4.2-web/css/all.min.css" />

    @stack('styles')

    <style>
        #loader {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            width: 100%;
            background: rgba(0, 0, 0, 0.75);
            z-index: 99999;
        }

    </style>

</head>

<body>
    <header class="border-bottom py-2">
        <nav class="navbar navbar-expand-sm navbar-light bg-light">
            <div class="container">
                <a class="navbar-brand" href="{{ route('gaji') }}">PMU</a>
                <button class="navbar-toggler d-lg-none" type="button" data-bs-toggle="collapse" data-bs-target="#collapsibleNavId" aria-controls="collapsibleNavId" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="collapsibleNavId">
                    <ul class="navbar-nav me-auto mt-2 mt-lg-0">
                        <li class="nav-item">
                            <a class="nav-link {{ Route::currentRouteName() == 'pegawai' ? 'active' : '' }}" href="{{ route('pegawai') }}" aria-current="page">Pegawai
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ Route::currentRouteName() == 'gaji' ? 'active' : '' }}" href="{{ route('gaji') }}">Gaji
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ Route::currentRouteName() == 'pph21' ? 'active' : '' }}" href="{{ route('pph21') }}">PPH21
                            </a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Akses
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{ route('permission') }}">Permission</a></li>
                                <li><a class="dropdown-item" href="{{ route('role') }}">Role</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item" href="{{ route('akses') }}">List Akses</a></li>
                            </ul>
                        </li>
                    </ul>
                    <ul class="navbar-nav mt-2 mt-lg-0">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('logout') }}">Logout</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <div id="loader" class="row">
        <div class="col-auto m-auto">
            <i class="fa-solid fa-spinner fa-spin-pulse fa-2xl text-white"></i>
        </div>
    </div>

    <main class="mt-4">
        <div class="container">
            @yield('content')
        </div>
    </main>

    @stack('scripts')

    <script src="{{ basset(base_path('vendor/twbs/bootstrap/dist/js/bootstrap.bundle.js')) }}"></script>
    <script src="/vendor/DataTables-1.13.6/datatables.min.js"></script>
    <script src="/vendor/fontawesome-free-6.4.2/js/all.min.js"></script>

    <script>
        $(document).ready(function() {
            new DataTable('#dataTable');

            const formGet = document.getElementById('formGet')
            const selectMonth = document.getElementById('selectMonth')
            const selectYear = document.getElementById('selectYear')

            console.log(selectMonth);
            selectMonth.addEventListener('change', function(event) {
                formGet.submit()
            })

            selectYear.addEventListener('change', function(event) {
                formGet.submit()
            })

            $("#selectPPH21").on("change", function() {
                formGet.submit()
            })
        });

    </script>

    <script>
        $(function() {
            $("form").submit(function() {
                $('#loader').css('display', 'flex');
            });
        });

        const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
        const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))

    </script>

    @include('sweetalert::alert')

    @include('js.pegawai')
    @include('js.gaji')

    @stack('modals')

</body>

</html>
