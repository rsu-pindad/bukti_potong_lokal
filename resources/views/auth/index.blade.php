<!doctype html>
<html lang="en">

<head>
    <title>PT PINDAD MEDIKA UTAMA | {{ $title }}</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS v5.3.1 -->
    <link href="/vendor/bootstrap-5.3.1/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome 6.4.2 CSS -->
    <link rel="stylesheet" href="/vendor/fontawesome-free-6.4.2-web/css/all.min.css" />

</head>

<body>
    <main class="row" style="height: 100vh;">
        <div class="col-8 m-auto">
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
                            <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-user fa-fw text-secondary"></i></span>
                            @error('username')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <label for="" class="form-label">Password</label>
                        <div class="input-group mb-3">
                            <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" id="password" placeholder="Password">
                            <span class="input-group-text" id="basic-addon2"><i class="fa-solid fa-lock fa-fw text-secondary"></i></span>
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
    <script src="/vendor/fontawesome-free-6.4.2/js/all.min.js"></script>
</body>

</html>
