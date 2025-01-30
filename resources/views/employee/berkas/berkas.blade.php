<x-employee>
<!-- Card Section -->
<div class="max-w-full px-4 py-6 sm:px-4 lg:px-6 lg:py-10 mx-auto">
  <!-- Card -->
  <div class="bg-white rounded-xl shadow p-4 sm:p-7">
    <div class="text-center mb-8">
      <h2 class="text-2xl md:text-3xl font-bold text-gray-800">
        Cari Berkas Bukan A1
      </h2>
      <p class="text-sm text-gray-600">
        Cari Bukti Potong
      </p>
    </div>

    <form action="{{ URL::signedRoute('personal-parser-bp-search') }}"
    method="post">
    @csrf

      <!-- Section -->
      <div class="py-6 first:pt-0 last:pb-0 border-t first:border-transparent border-gray-200">
        <label for="af-payment-billing-address" class="inline-block text-sm font-medium">
          Informasi Bukti Potong
        </label>

        <div class="mt-2 space-y-3">
          <div class="flex flex-col sm:flex-row gap-3">
            <div>
            <select name="bulan" class="py-2 px-3 pe-9 block w-full border-gray-200 shadow-sm text-sm rounded-lg focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none">
                <option hidden value="" selected>Pilih Bulan</option>
                <option value="01">Januari</option>
                <option value="02">Februari</option>
                <option value="03">Maret</option>
                <option value="04">April</option>
                <option value="05">Mei</option>
                <option value="06">Juni</option>
                <option value="07">Juli</option>
                <option value="08">Agustus</option>
                <option value="09">September</option>
                <option value="10">Oktober</option>
                <option value="11">November</option>
                <option value="12">Desember</option>
            </select>
            </div>
            <div>
            <select name="tahun" class="py-2 px-3 pe-9 block w-full border-gray-200 shadow-sm text-sm rounded-lg focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none">
                <option hidden value="" selected>Pilih Tahun</option>
                <option value="2021">2021</option>
                <option value="2022">2022</option>
                <option value="2023">2023</option>
                <option value="2024">2024</option>
                <option value="2025">2025</option>
                <option value="2026">2026</option>
                <option value="2027">2027</option>
                <option value="2028">2028</option>
            </select>
            </div>
          </div>
        </div>

        <div class="mt-4 space-y-6">
            <button type="submit" class="w-full py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-none focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none">
                Cari Berkas
            </button>
        </div>

      </div>
      <!-- End Section -->


    </form>

    <div class="mt-5 flex justify-end gap-x-2">
      <button type="button" class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-gray-600 text-white hover:bg-gray-700 focus:outline-none focus:bg-gray-700 disabled:opacity-50 disabled:pointer-events-none">
        Cari A1 ?
      </button>
    </div>
  </div>
  <!-- End Card -->
</div>
<!-- End Card Section -->

<!-- Card Section -->
<div class="max-w-full px-4 py-6 sm:px-4 lg:px-6 lg:py-10 mx-auto">
  <!-- Card -->
  <div class="bg-white rounded-xl shadow p-4 sm:p-7">
    <div class="text-center mb-8">
      <h2 class="text-2xl md:text-3xl font-bold text-gray-800">
        Unduh Berkas Bukan A1
      </h2>
      <p class="text-sm text-gray-600">
        Unduh Bukti Potong
      </p>
    </div>

    <form action="{{ URL::signedRoute('personal-parser-bp-search-download') }}"
    method="post">
    @csrf

      <!-- Section -->
      <div class="py-6 first:pt-0 last:pb-0 border-t first:border-transparent border-gray-200">
        <label for="af-payment-billing-address" class="inline-block text-sm font-medium">
          Informasi Bukti Potong
        </label>

        <div class="mt-2 space-y-3">
          <div class="flex flex-col sm:flex-row gap-3">
            <div>
            <select name="bulan" class="py-2 px-3 pe-9 block w-full border-gray-200 shadow-sm text-sm rounded-lg focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none">
                <option hidden value="" selected>Pilih Bulan</option>
                <option value="01">Januari</option>
                <option value="02">Februari</option>
                <option value="03">Maret</option>
                <option value="04">April</option>
                <option value="05">Mei</option>
                <option value="06">Juni</option>
                <option value="07">Juli</option>
                <option value="08">Agustus</option>
                <option value="09">September</option>
                <option value="10">Oktober</option>
                <option value="11">November</option>
                <option value="12">Desember</option>
            </select>
            </div>
            <div>
            <select name="tahun" class="py-2 px-3 pe-9 block w-full border-gray-200 shadow-sm text-sm rounded-lg focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none">
                <option hidden value="" selected>Pilih Tahun</option>
                <option value="2021">2021</option>
                <option value="2022">2022</option>
                <option value="2023">2023</option>
                <option value="2024">2024</option>
                <option value="2025">2025</option>
                <option value="2026">2026</option>
                <option value="2027">2027</option>
                <option value="2028">2028</option>
            </select>
            </div>
          </div>
        </div>

        <div class="mt-4 space-y-6">
            <button type="submit" class="w-full py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-none focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none">
                Unduh Berkas
            </button>
        </div>

      </div>
      <!-- End Section -->


    </form>

    <div class="mt-5 flex justify-end gap-x-2">
      <button type="button" class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-gray-600 text-white hover:bg-gray-700 focus:outline-none focus:bg-gray-700 disabled:opacity-50 disabled:pointer-events-none">
        Unduh A1 ?
      </button>
    </div>
  </div>
  <!-- End Card -->
</div>
<!-- End Card Section -->
</x-employee>