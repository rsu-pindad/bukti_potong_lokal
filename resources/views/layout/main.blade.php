<!doctype html>
<html lang="en">

  <head>
    <title>{{ $title ?? 'PMU' }}</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1, shrink-to-fit=no">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

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
             href="#">
            PMU
          </a>
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
              @hasexactroles('personalia')
                <li class="nav-item border-top border-dark mx-2">
                  <a class="nav-link {{ Route::currentRouteName() == 'personalia-employee-index' ? 'active' : '' }}"
                     href="{{ route('personalia-employee-index') }}"
                     aria-current="page">
                    <i class="fa-solid fa-users"></i> Pegawai
                  </a>
                </li>
              @endhasexactroles
              @hasexactroles('pajak')
                <li class="nav-item border-top border-dark mx-2">
                  <a class="nav-link {{ Route::currentRouteName() == 'pajak-employee-index' ? 'active' : '' }}"
                     href="{{ route('pajak-employee-index') }}"
                     aria-current="page">
                    <i class="fa-solid fa-users"></i> Pegawai
                  </a>
                </li>
              @endhasexactroles
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
                <li class="nav-item border-top border-dark mx-2">
                  <a class="nav-link"
                     href="/pajak_manager">
                    <i class="fa-solid fa-folder-tree"></i> File Manager
                  </a>
                </li>
              @endhasexactroles
              @hasexactroles('pajak')
                <li class="nav-item border-top border-dark mx-2">
                  <a class="nav-link {{ Route::currentRouteName() == 'pajak-file-index' ? 'active' : '' }}"
                     href="{{ route('pajak-file-index') }}">
                    <i class="fa-solid fa-bullhorn"></i> Publish File
                  </a>
                </li>
                <li class="nav-item border-top border-dark mx-2">
                  <a class="nav-link {{ Route::currentRouteName() == 'pajak-published-file-index' ? 'active' : '' }}"
                     href="{{ route('pajak-published-file-index') }}">
                    <i class="fa-solid fa-bullhorn"></i> Published File
                  </a>
                </li>
                <li class="nav-item border-top border-dark mx-2">
                  <a class="nav-link {{ Route::currentRouteName() == 'pajak-cari-index' ? 'active' : '' }}"
                     href="{{ route('pajak-cari-index') }}">
                    <i class="fa-solid fa-bullhorn"></i> Cari Bupot
                  </a>
                </li>
              @endhasexactroles
            </ul>
            <ul class="navbar-nav mt-lg-0 mr-0 mt-2">
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

    <script type="module">
      $(function() {
        $("form").submit(function() {
          $('#loader').css('display', 'flex');
        });
      });

      const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
      const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
    </script>

    @stack('scripts')
    @stack('modals')

  </body>

</html>
