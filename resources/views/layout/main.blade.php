<!doctype html>
<html lang="en">

<head>
    <title>{{ $title }}</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS v5.2.1 -->
    <link rel="stylesheet" href="/dist/css/bootstrap.min.css">

    <link href="/dist/datatables.min.css" rel="stylesheet">

    <!-- FontAwesome 6.2.0 CSS -->
    <link rel="stylesheet" href="/dist/fontawesome-free-6.4.2-web/css/all.min.css" />


</head>

<body>
    <header>
        <!-- place navbar here -->
        <nav class="navbar navbar-expand-sm navbar-light bg-light">
            <div class="container">
                <a class="navbar-brand" href="#">Navbar</a>
                <button class="navbar-toggler d-lg-none" type="button" data-bs-toggle="collapse"
                    data-bs-target="#collapsibleNavId" aria-controls="collapsibleNavId" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="collapsibleNavId">
                    <ul class="navbar-nav me-auto mt-2 mt-lg-0">
                        <li class="nav-item">
                            <a class="nav-link {{ Route::currentRouteName() == 'pegawai' ? 'active' : '' }}"
                                href="{{ route('pegawai') }}" aria-current="page">Pegawai </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('gaji') }}">Gaji</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">PPH21</a>
                        </li>

                    </ul>
                    <form class="d-flex my-2 my-lg-0">
                        <input class="form-control me-sm-2" type="text" placeholder="Search">
                        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
                    </form>
                </div>
            </div>
        </nav>

    </header>
    <main class="mt-4">
        <div class="container">
            @yield('content')
        </div>
    </main>
    <footer>






    </footer>

    <script src="/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/dist/datatables.min.js"></script>
    <script src="/dist/fontawesome-free-6.4.2-web/css/all.min.js"></script>
    <script>
        new DataTable('#dataTable');

        const formGet = document.getElementById('formGet')
        const selectMonth = document.getElementById('selectMonth')
        const selectYear = document.getElementById('selectYear')

        selectMonth.addEventListener('change', function(event) {
            formGet.submit()
        })
        selectYear.addEventListener('change', function(event) {
            formGet.submit()
        })
    </script>
</body>

</html>
