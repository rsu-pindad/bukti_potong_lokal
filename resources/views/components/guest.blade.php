<!doctype html>
<html lang="en">

  <head>
      <!-- Required meta tags -->
      <meta charset="utf-8">
      <meta name="viewport"
      content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <link rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/notiflix@3.2.8/src/notiflix.min.css">
      <title>{{ config('app.name', 'Bukti Potong') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
  </head>

  <body>

  <main class="w-full mx-auto h-screen flex items-center justify-center">
    {{ $slot }}
  </main>

  </body>

</html>
