<!DOCTYPE html>
<html lang="en">

  <head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible"
          content="ie=edge">
    <title>{{ $title ?? 'Guest Layout' }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')

  </head>

  <body class="d-flex align-items-center py-4">

    {{ $slot }}

    @stack('scripts')
  </body>

</html>
