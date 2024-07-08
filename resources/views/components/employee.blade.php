<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Pegawai</title>

    <link rel="stylesheet" href="{{ basset(base_path('vendor/twbs/bootstrap/dist/css/bootstrap.min.css')) }}">
    <link rel="stylesheet" href="{{ basset(base_path('vendor/fortawesome/font-awesome/css/all.min.css')) }}">
    
    <style>
        .bi {
            display: inline-block;
            width: 1rem;
            height: 1rem;
        }

        /*
        * Sidebar
        */

        @media (min-width: 768px) {
            .sidebar .offcanvas-lg {
                position: -webkit-sticky;
                position: sticky;
                top: 48px;
            }

            .navbar-search {
                display: block;
            }
        }

        .sidebar .nav-link {
            font-size: .875rem;
            font-weight: 500;
        }

        .sidebar .nav-link.active {
            color: #2470dc;
        }

        .sidebar-heading {
            font-size: .75rem;
        }

        /*
        * Navbar
        */

        .navbar-brand {
            padding-top: .75rem;
            padding-bottom: .75rem;
            background-color: rgba(0, 0, 0, .25);
            box-shadow: inset -1px 0 0 rgba(0, 0, 0, .25);
        }

        .navbar .form-control {
            padding: .75rem 1rem;
        }

    </style>

    @stack('styles')

</head>
<body>

    <x-employee.header />

    <div class="container-fluid">

        <div class="row">
            <x-employee.sidebar />

            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                {{$slot}}
            </main>
        </div>

    </div>

    @stack('modals')

    <script src="{{ basset(base_path('vendor/twbs/bootstrap/dist/js/bootstrap.min.js')) }}"></script>
    @basset('https://code.jquery.com/jquery-3.7.1.min.js')
    <script src="{{ basset(base_path('vendor/robinherbots/jquery.inputmask/dist/jquery.inputmask.min.js')) }}"></script>
    <script src="{{ basset(base_path('vendor/robinherbots/jquery.inputmask/dist/bindings/inputmask.binding.js')) }}"></script>
    <script src="{{ basset(base_path('vendor/fortawesome/font-awesome/js/all.min.js')) }}"></script>

    @stack('scripts')
    @include('sweetalert::alert')

</body>
</html>
