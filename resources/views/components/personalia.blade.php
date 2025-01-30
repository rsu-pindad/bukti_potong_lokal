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
    <!-- ========== HEADER ========== -->
<header class="sticky top-0 inset-x-0 flex flex-wrap md:justify-start md:flex-nowrap z-[48] w-full bg-white border-b text-sm py-2.5 ">
  <nav class="max-w-[85rem] px-4 sm:px-6 lg:px-8 flex basis-full items-center w-full mx-auto">
    <div class="me-5">
      <!-- Logo -->
      <a class="flex-none rounded-md text-xl inline-block font-semibold focus:outline-none focus:opacity-80" href="#" aria-label="Preline">
      <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-banknote"><rect width="20" height="12" x="2" y="6" rx="2"/><circle cx="12" cy="12" r="2"/><path d="M6 12h.01M18 12h.01"/></svg>
      </a>
      
      <!-- End Logo -->

      <div class="lg:hidden ms-1">

      </div>
    </div>

    <div class="w-full flex items-center justify-end ms-auto md:justify-between gap-x-1 md:gap-x-3">
      <!-- Collapse -->
      <div class="md:hidden">
        <button type="button" class="hs-collapse-toggle size-[38px] relative inline-flex justify-center items-center gap-x-2 text-sm font-semibold rounded-full border border-transparent text-gray-800 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none" id="hs-secondaru-navbar-collapse" aria-expanded="false" aria-controls="hs-secondaru-navbar" aria-label="Toggle navigation" data-hs-collapse="#hs-secondaru-navbar">
          <svg class="hs-collapse-open:hidden size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="3" x2="21" y1="6" y2="6"/><line x1="3" x2="21" y1="12" y2="12"/><line x1="3" x2="21" y1="18" y2="18"/></svg>
          <svg class="hs-collapse-open:block shrink-0 hidden size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
          <span class="sr-only">Toggle navigation</span>
        </button>
      </div>
      <!-- End Collapse -->


      <div class="grow flex flex-row items-center justify-end gap-1">
        <!-- Dropdown -->
        <div class="hs-dropdown [--placement:bottom-right] relative inline-flex">
          <button id="hs-dropdown-account" type="button" class="size-[38px] inline-flex justify-center items-center gap-x-2 text-sm font-semibold rounded-full border border-transparent text-gray-800 focus:outline-none disabled:opacity-50 disabled:pointer-events-none" aria-haspopup="menu" aria-expanded="false" aria-label="Dropdown">
            <img class="shrink-0 size-[38px] rounded-full" src="{!! Avatar::create(auth()->user()->username)->toBase64() !!}" alt="Avatar">
          </button>

          <div class="hs-dropdown-menu transition-[opacity,margin] duration hs-dropdown-open:opacity-100 opacity-0 hidden min-w-60 bg-white shadow-md rounded-lg mt-2 after:h-4 after:absolute after:-bottom-4 after:start-0 after:w-full before:h-4 before:absolute before:-top-4 before:start-0 before:w-full" role="menu" aria-orientation="vertical" aria-labelledby="hs-dropdown-account">
            <div class="py-3 px-5 bg-gray-100 rounded-t-lg">
              <p class="text-sm text-gray-500">Masuk Sebagai</p>
              <p class="text-sm font-medium text-gray-800">{{auth()->user()->username}}</p>
            </div>
            <div class="p-1.5 space-y-0.5">
              <a class="flex items-center gap-x-3.5 py-2 px-3 rounded-lg text-sm text-gray-800 hover:bg-gray-100 focus:outline-none focus:bg-gray-100" href="{{route('logout')}}">
                <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                Keluar
              </a>
            </div>
          </div>
        </div>
        <!-- End Dropdown -->
      </div>
    </div>
  </nav>
</header>
<!-- ========== END HEADER ========== -->

<!-- ========== MAIN CONTENT ========== -->
<main id="content">
  <!-- Secondary Navbar -->
  <div class="md:py-4 bg-white md:border-b border-gray-200">
    <nav class="relative max-w-[85rem] w-full mx-auto md:flex md:items-center md:gap-3 px-4 sm:px-6 lg:px-8">
      <!-- Collapse -->
      <div id="hs-secondaru-navbar" class="hs-collapse hidden overflow-hidden transition-all duration-300 basis-full grow md:block" aria-labelledby="hs-secondaru-navbar-collapse">
        <div class="overflow-hidden overflow-y-auto max-h-[75vh] [&::-webkit-scrollbar]:w-2 [&::-webkit-scrollbar-thumb]:rounded-full [&::-webkit-scrollbar-track]:bg-gray-100 [&::-webkit-scrollbar-thumb]:bg-gray-300">
          <div class="py-2 md:py-0 flex flex-col md:flex-row md:items-center gap-y-0.5 md:gap-y-0 md:gap-x-6">
            <a class="py-2 md:py-0 flex items-center font-medium text-sm text-blue-600 focus:outline-none focus:text-blue-600" href="#" aria-current="page">
              <svg class="shrink-0 size-4 me-3 md:me-2 block md:hidden" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M15 21v-8a1 1 0 0 0-1-1h-4a1 1 0 0 0-1 1v8"/><path d="M3 10a2 2 0 0 1 .709-1.528l7-5.999a2 2 0 0 1 2.582 0l7 5.999A2 2 0 0 1 21 10v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/></svg>
              Dashboard
            </a>

            <a class="py-2 md:py-0 flex items-center font-medium text-sm text-gray-800 hover:text-gray-500 focus:outline-none focus:text-gray-500" href="{{route('pajak-employee-index')}}">
              <svg class="shrink-0 size-4 me-3 md:me-2 block md:hidden" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
              Pegawai
            </a>

          </div>
        </div>
      </div>
      <!-- End Collapse -->
    </nav>
  </div>
  <!-- End Secondary Navbar -->

  <div class="max-w-[85rem] min-h-[75rem] mx-auto py-10 px-4 sm:px-6 lg:px-8">
    {{$slot}}
  </div>
</main>
<!-- ========== END MAIN CONTENT ========== -->
  </body>

</html>
