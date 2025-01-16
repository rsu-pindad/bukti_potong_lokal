<!doctype html>
<html lang="en">

  <head>
    <title>PT PINDAD MEDIKA UTAMA | {{ $title ?? '' }}</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>{{ config('app.name', 'Bukti Potong') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
  </head>

  <body>
    <main class="row"
          style="height: 100vh;">
      <div class="col-lg-4 col-md-6 col-sm-10 col-xs-12 m-auto p-5">
        <div class="card">
          <div class="card-header">
            <h4 class="m-0 text-center">
              <i class="fa-solid fa-file-invoice-dollar px-2"></i> PMU Bukti Potong
            </h4>
          </div>
          <div class="card-body">
            <form action="{{ route('auth-submit-reset-password', $token) }}"
                  method="post">
              @csrf
              <label for="password"
                     class="form-label">Password
                <div id="password"
                     class="form-text">min:6</div>
              </label>
              <div class="input-group mb-3">
                <input id="password"
                       type="password"
                       class="form-control @error('password') is-invalid @enderror"
                       name="password"
                       placeholder="masukan password">
                <span id="basic-addon1"
                      class="input-group-text">
                  <i class="fa-solid fa-user"></i>
                </span>
                @error('password')
                  <div class="invalid-feedback">
                    {{ $message }}
                  </div>
                @enderror
              </div>
              <label for="password_confirmation"
                     class="form-label">Ulangi Password

                <div id="password_confirmation"
                     class="form-text">min:6</div>
              </label>
              <div class="input-group mb-3">
                <input id="password_confirmation"
                       type="password"
                       class="form-control @error('password_confirmation') is-invalid @enderror"
                       name="password_confirmation"
                       placeholder="ulangi password">
                <span id="basic-addon1"
                      class="input-group-text">
                  <i class="fa-solid fa-user"></i>
                </span>
                @error('password_confirmation')
                  <div class="invalid-feedback">
                    {{ $message }}
                  </div>
                @enderror
              </div>
              <div class="d-grid">
                <button type="submit"
                        class="btn btn-primary">
                  Reset Password
                </button>
              </div>
            </form>
          </div>
          <div class="card-footer">
            <a href="{{ route('login') }}">login</a>
          </div>
        </div>
      </div>
    </main>

  </body>

</html>
