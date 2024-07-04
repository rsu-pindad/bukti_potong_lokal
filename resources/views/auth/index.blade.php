<!doctype html>
<html lang="en">

<head>
    <title>PT PINDAD MEDIKA UTAMA | {{ $title }}</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="{{ basset(base_path('vendor/twbs/bootstrap/dist/css/bootstrap.min.css')) }}">
    <link rel="stylesheet" href="{{ basset(base_path('vendor/twbs/bootstrap-icons/font/bootstrap-icons.min.css')) }}">

</head>

<body>
    <main class="row" style="height: 100vh;">
        <div class="col-lg-3 col-md-5 col-sm-8 col-xs-12 m-auto p-5">
            <div class="card">
                <div class="card-header">
                    <h3 class="text-center m-0">PPH21</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('auth/authenticate') }}" method="post">
                        @csrf
                        <label for="" class="form-label">Username</label>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control @error('username') is-invalid @enderror" name="username" id="username" placeholder="Username" value="{{ old('username') }}">
                            <span class="input-group-text" id="basic-addon1">
                                <i class="bi bi-person-fill"></i>
                            </span>
                            @error('username')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <label for="" class="form-label">Password</label>
                        <div class="input-group mb-3">
                            <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" id="password" placeholder="Password">
                            <span class="input-group-text" id="basic-addon2">
                                <i class="bi bi-lock-fill"></i>
                            </span>
                            @error('password')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Masuk</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
    <script src="{{ basset(base_path('vendor/twbs/bootstrap/dist/js/bootstrap.min.js')) }}"></script>
</body>

</html>
