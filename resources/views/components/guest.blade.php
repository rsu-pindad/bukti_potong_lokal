<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title ?? 'Guest Layout'}}</title>

    <link rel="stylesheet" href="{{ basset(base_path('vendor/twbs/bootstrap/dist/css/bootstrap.min.css')) }}">
    <link rel="stylesheet" href="{{ basset(base_path('vendor/twbs/bootstrap-icons/font/bootstrap-icons.min.css')) }}">
    {{-- <link rel="stylesheet" href="{{ basset(base_path('vendor/twbs/bootstrap-icons/font/fonts/bootstrap-icons.woff')) }}" media="font/woff"> --}}
    {{-- <link rel="stylesheet" href="{{ basset(base_path('vendor/twbs/bootstrap-icons/font/fonts/bootstrap-icons.woff2')) }}" media="font/woff2"> --}}

    @stack('styles')

</head>
<body class="d-flex align-items-center py-4">

    {{ $slot }}

    <script src="{{ basset(base_path('vendor/twbs/bootstrap/dist/js/bootstrap.min.js')) }}"></script>
    @stack('scripts')
</body>
</html>
