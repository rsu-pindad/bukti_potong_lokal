<!doctype html>
<html lang="en">

  <head>
    <title>PT PINDAD MEDIKA UTAMA | {{ $title }}</title>
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
              <i class="fa-solid fa-file-invoice-dollar px-2"></i> Bukti Potong Lokal PMU
            </h4>
          </div>
          <div class="card-body">
            <form action="{{ route('auth/authenticate') }}"
                  method="post">
              @csrf
              <label for="username"
                     class="form-label">Username</label>
              <div class="input-group mb-3">
                <input id="username"
                       type="text"
                       class="form-control @error('username') is-invalid @enderror"
                       name="username"
                       placeholder="Username"
                       value="{{ old('username') }}">
                <span id="basic-addon1"
                      class="input-group-text">
                  <i class="fa-solid fa-user"></i>
                </span>
                @error('username')
                  <div class="invalid-feedback">
                    {{ $message }}
                  </div>
                @enderror
              </div>
              <label for="password"
                     class="form-label">Password</label>
              <div class="input-group mb-3">
                <input id="password"
                       type="password"
                       class="form-control @error('password') is-invalid @enderror"
                       name="password"
                       placeholder="Password">
                <span id="basic-addon2"
                      class="input-group-text">
                  <i class="fa-solid fa-lock"></i>
                </span>
                @error('password')
                  <div class="invalid-feedback">
                    {{ $message }}
                  </div>
                @enderror
              </div>
              <div class="d-grid">
                <button type="submit"
                        class="btn btn-primary">
                  Masuk
                </button>
              </div>
            </form>
          </div>
          <div class="card-footer">
            <a href="{{ route('cari-index') }}">belum punya akun ?</a>
          </div>
        </div>
      </div>
    </main>

  </body>

</html>
