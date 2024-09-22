<!doctype html>
<html lang="en">

  <head>
    <title>{{ $title }}</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet"
          href="{{ basset(base_path('vendor/twbs/bootstrap/dist/css/bootstrap.min.css')) }}">

    @basset(base_path('vendor/fortawesome/font-awesome/css/all.css'))
    @basset(base_path('vendor/fortawesome/font-awesome/webfonts/fa-brands-400.ttf'))
    @basset(base_path('vendor/fortawesome/font-awesome/webfonts/fa-brands-400.woff2'))
    @basset(base_path('vendor/fortawesome/font-awesome/webfonts/fa-regular-400.ttf'))
    @basset(base_path('vendor/fortawesome/font-awesome/webfonts/fa-regular-400.woff2'))
    @basset(base_path('vendor/fortawesome/font-awesome/webfonts/fa-solid-900.ttf'))
    @basset(base_path('vendor/fortawesome/font-awesome/webfonts/fa-solid-900.woff2'))

    @bassetDirectory(base_path('vendor/datatables.net/'), 'datatables.net')
    @basset('datatables.net/datatables.net-bs5/css/dataTables.bootstrap5.min.css')
    @basset('datatables.net/datatables.net-fixedcolumns-bs5/css/fixedColumns.bootstrap5.min.css')
    @basset('datatables.net/datatables.net-fixedheader-bs5/css/fixedHeader.bootstrap5.min.css')
    @basset('datatables.net/datatables.net-rowgroup-bs5/css/rowGroup.bootstrap5.min.css')
    @basset('datatables.net/datatables.net-scroller-bs5/css/scroller.bootstrap5.min.css')

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
          <a class="navbar-brand"
             href="{{ route('gaji') }}">PMU</a>
          <button class="navbar-toggler d-lg-none"
                  type="button"
                  data-bs-toggle="collapse"
                  data-bs-target="#collapsibleNavId"
                  aria-controls="collapsibleNavId"
                  aria-expanded="false"
                  aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div id="collapsibleNavId"
               class="navbar-collapse collapse">
            <ul class="navbar-nav mt-lg-0 me-auto mt-2">
              @hasanyrole(['admin', 'pajak'])
                @hasexactroles('pajak')
                  {{-- <li class="nav-item border-top border-dark mx-2">
                    <a class="nav-link {{ Route::currentRouteName() == 'karyawan' ? 'active' : '' }}"
                       href="{{ route('karyawan') }}"
                       aria-current="page">
                      <i class="fa-solid fa-users"></i> Pegawai </br>(Data Baru)
                    </a>
                  </li> --}}
                  <li class="nav-item border-top border-dark mx-2">
                    <a class="nav-link {{ Route::currentRouteName() == 'pegawai' ? 'active' : '' }}"
                       href="{{ route('pegawai') }}"
                       aria-current="page">
                      <i class="fa-solid fa-users"></i> Pegawai </br>(Data Lama)
                    </a>
                  </li>
                  <li class="nav-item border-top border-dark mx-2">
                    <a class="nav-link {{ Route::currentRouteName() == 'gaji' ? 'active' : '' }}"
                       href="{{ route('gaji') }}">
                      <i class="fa-solid fa-file-invoice-dollar"></i> Gaji
                    </a>
                  </li>
                  <li class="nav-item border-top border-dark mx-2">
                    <a class="nav-link {{ Route::currentRouteName() == 'pph21' ? 'active' : '' }}"
                       href="{{ route('pph21') }}">
                      <i class="fa-solid fa-file-invoice-dollar"></i> PPH21
                    </a>
                  </li>
                @endhasexactroles
              @endhasanyrole
              @hasexactroles('super-admin')
                <li class="nav-item dropdown border-top border-dark mx-2">
                  <a class="nav-link dropdown-toggle"
                     href="#"
                     role="button"
                     data-bs-toggle="dropdown"
                     aria-expanded="false">
                    <i class="fa-solid fa-user-lock"></i> Akses
                  </a>
                  <ul class="dropdown-menu">
                    <li><a class="dropdown-item"
                         href="{{ route('permission') }}">Permission</a></li>
                    <li><a class="dropdown-item"
                         href="{{ route('role') }}">Role</a></li>
                    <li>
                      <hr class="dropdown-divider">
                    </li>
                    <li><a class="dropdown-item"
                         href="{{ route('akses') }}">List Akses</a></li>
                  </ul>
                </li>
              @endhasexactroles
              @hasexactroles('pajak')
                <li class="nav-item border-top border-dark mx-2">
                  <a class="nav-link"
                     href="/pajak_manager">
                    <i class="fa-solid fa-folder-tree"></i> File Manager
                  </a>
                </li>
                <li class="nav-item border-top border-dark mx-2">
                  <a class="nav-link {{ Route::currentRouteName() == 'pajak-index' ? 'active' : '' }}"
                     href="{{ route('pajak-index') }}">
                    <i class="fa-solid fa-bullhorn"></i> Publish File
                  </a>
                </li>
                <li class="nav-item border-top border-dark mx-2">
                  <a class="nav-link {{ Route::currentRouteName() == 'pajak-published-index' ? 'active' : '' }}"
                     href="{{ route('pajak-published-index') }}">
                    <i class="fa-solid fa-bullhorn"></i> Published File
                  </a>
                </li>
              @endhasexactroles
              @hasanyrole('personalia')
                <li class="nav-item border-top border-dark mx-2">
                  <a class="nav-link {{ Route::currentRouteName() == 'karyawan' ? 'active' : '' }}"
                     href="{{ route('karyawan') }}"
                     aria-current="page">
                    <i class="fa-solid fa-users"></i> Pegawai </br>(Data Baru)
                  </a>
                </li>
              @endhasanyrole
            </ul>
            <ul class="navbar-nav mt-lg-0 mt-2">
              <li class="nav-item border-top border-dark mx-2">
                <a class="nav-link"
                   href="{{ route('logout') }}">
                  <i class="fa-solid fa-arrow-right-from-bracket"></i> Logout
                </a>
              </li>
            </ul>
          </div>
        </div>
      </nav>
    </header>

    <div id="loader"
         class="row">
      <div class="col-auto m-auto">
        <i class="fa-solid fa-spinner fa-spin-pulse fa-2xl text-white"></i>
      </div>
    </div>

    <main class="mt-4">
      <div class="container">
        @yield('content')
      </div>
    </main>

    @basset(base_path('vendor/twbs/bootstrap/dist/js/bootstrap.bundle.js'))
    @basset('https://code.jquery.com/jquery-3.7.1.min.js')
    @basset(base_path('vendor/fortawesome/font-awesome/js/all.js'))
    @bassetDirectory(base_path('vendor/datatables.net/'), 'datatables.net')
    @basset('datatables.net/datatables.net/js/dataTables.js')
    @basset('datatables.net/datatables.net-bs5/js/dataTables.bootstrap5.min.js')
    @basset('datatables.net/datatables.net-fixedcolumns-bs5/js/fixedColumns.bootstrap5.min.js')
    @basset('datatables.net/datatables.net-fixedheader-bs5/js/fixedHeader.bootstrap5.min.js')
    @basset('datatables.net/datatables.net-rowgroup-bs5/js/rowGroup.bootstrap5.min.js')
    @basset('datatables.net/datatables.net-scroller-bs5/js/scroller.bootstrap5.min.js')

    @stack('scripts')

    <script>
      $(document).ready(function() {
        new DataTable('#dataTable');

        const formGet = document.getElementById('formGet')
        const selectMonth = document.getElementById('selectMonth')
        const selectYear = document.getElementById('selectYear')

        // console.log(selectMonth);
        if (selectMonth != null) {
          selectMonth.addEventListener('change', function(event) {
            formGet.submit()
          })
        }

        if (selectYear != null) {
          selectYear.addEventListener('change', function(event) {
            formGet.submit()
          })
        }

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
