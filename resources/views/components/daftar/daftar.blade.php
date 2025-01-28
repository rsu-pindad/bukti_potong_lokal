@props(['route', 'showSelf'])
<main class="form-signin mx-auto my-auto w-full">
  @if ($route === 'cari' && $showSelf === false)
  <!-- Hero -->
    <div class="relative overflow-hidden">
      <div class="max-w-[85rem] mx-auto px-4 sm:px-6 lg:px-8 py-10 sm:py-24">
        <div class="text-center">
          <h1 class="text-4xl sm:text-6xl font-bold text-gray-800">
            Daftar
          </h1>

          <p class="mt-3 text-gray-600">
            Identitas kepegawaian
          </p>

          <div class="mt-7 sm:mt-12 mx-auto max-w-xl relative">
            <!-- Form -->
            <form action="{{ route('cari-npp') }}" method="post">
              @csrf
              <div class="relative z-10 flex gap-x-3 p-3 bg-white border rounded-lg shadow-lg shadow-gray-100">
                <div class="w-full">
                  <label for="npp" class="block text-sm text-gray-700 font-medium"><span class="sr-only">Cari Identitas kepegawaian</span></label>
                  <input type="text" name="npp" class="py-2.5 px-4 block w-full border-transparent rounded-lg focus:border-blue-500 focus:ring-blue-500" placeholder="Cari NPP">
                </div>
                <div>
                  <button type="submit" class="size-[46px] inline-flex justify-center items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-none focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none">
                      <svg class="shrink-0 size-5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
                  </button>
                </div>
              </div>
            </form>
            <!-- End Form -->

            <!-- SVG Element -->
            <div class="hidden md:block absolute top-0 end-0 -translate-y-12 translate-x-20">
              <svg class="w-16 h-auto text-orange-500" width="121" height="135" viewBox="0 0 121 135" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M5 16.4754C11.7688 27.4499 21.2452 57.3224 5 89.0164" stroke="currentColor" stroke-width="10" stroke-linecap="round"/>
                <path d="M33.6761 112.104C44.6984 98.1239 74.2618 57.6776 83.4821 5" stroke="currentColor" stroke-width="10" stroke-linecap="round"/>
                <path d="M50.5525 130C68.2064 127.495 110.731 117.541 116 78.0874" stroke="currentColor" stroke-width="10" stroke-linecap="round"/>
              </svg>
            </div>
            <!-- End SVG Element -->

            <!-- SVG Element -->
            <div class="hidden md:block absolute bottom-0 start-0 translate-y-10 -translate-x-32">
              <svg class="w-40 h-auto text-cyan-500" width="347" height="188" viewBox="0 0 347 188" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M4 82.4591C54.7956 92.8751 30.9771 162.782 68.2065 181.385C112.642 203.59 127.943 78.57 122.161 25.5053C120.504 2.2376 93.4028 -8.11128 89.7468 25.5053C85.8633 61.2125 130.186 199.678 180.982 146.248L214.898 107.02C224.322 95.4118 242.9 79.2851 258.6 107.02C274.299 134.754 299.315 125.589 309.861 117.539L343 93.4426" stroke="currentColor" stroke-width="7" stroke-linecap="round"/>
              </svg>
            </div>
            <!-- End SVG Element -->
          </div>

          <div class="mt-10 sm:mt-20">
            <a class="inline-flex items-center gap-x-1 text-sm text-blue-600 decoration-2 hover:underline focus:outline-none focus:underline font-medium dark:text-blue-500" href="{{ route('auth-login') }}">
              Masuk
            </a>
          </div>

        </div>
      </div>
    </div>
  <!-- End Hero -->
  @endif
  @if ($route === 'daftar' && $showSelf === true)
  <!-- Card Section -->
  <div class="max-w-2xl px-4 py-10 sm:px-6 lg:px-8 lg:py-14 mx-auto">
    <!-- Card -->
    <div class="bg-white rounded-xl shadow p-4 sm:p-7">
      <div class="text-center mb-8">
        <h2 class="text-2xl md:text-3xl font-bold text-gray-800">
          Daftar
        </h2>
        <p class="text-sm text-gray-600">
          Identitas kepegawaian.
        </p>
      </div>

      <form action="{{ route('daftar-store') }}"
        method="post">
        @csrf
        <!-- Section -->
        <div class="py-4 first:pt-0 last:pb-0 border-t first:border-transparent border-gray-200">
          <label for="npp" class="inline-block text-sm font-medium">
            NPP
          </label>

          <div class="mt-2 space-y-3">
            <input type="text" 
            id="npp" 
            name="npp"
            value="{{ session()->get('npp') }}" 
            class="py-2 px-3 pe-11 block w-full border-gray-200 shadow-sm text-sm rounded-lg focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none" placeholder="NPP" readonly>
          </div>

          <label for="nik" class="inline-block text-sm font-medium">
            NIK
          </label>

          <div class="mt-2 space-y-3">
            <input type="text" 
            id="nik" 
            name="nik" 
            value="{{ session()->get('nik') }}"
            class="py-2 px-3 pe-11 block w-full border-gray-200 shadow-sm text-sm rounded-lg focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none" placeholder="NIK" readonly>  
          </div>

          <label for="npwp" class="inline-block text-sm font-medium">
            NPWP
          </label>

          <div class="mt-2 space-y-3">
            <input type="text" 
            id="npwp" 
            name="npwp" 
            value="{{ session()->get('npwp') }}"
            class="py-2 px-3 pe-11 block w-full border-gray-200 shadow-sm text-sm rounded-lg focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none" placeholder="NPWP" readonly>
          </div>
        </div>
        <!-- End Section -->

        <!-- Section -->
        <div class="py-4 first:pt-0 last:pb-0 border-t first:border-transparent border-gray-200">
          <label for="email" class="inline-block text-sm font-medium">
            EMAIL
          </label>

          <div class="mt-2 space-y-3">
            <input type="email" 
            id="email" 
            name="email"
            value="{{ session()->get('email') }}" 
            class="py-2 px-3 pe-11 block w-full border-gray-200 shadow-sm text-sm rounded-lg focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none" placeholder="EMAIL" readonly>
          </div>

          <label for="no_hp" class="inline-block text-sm font-medium">
            NO HP
          </label>

          <div class="mt-2 space-y-3">
            <input type="text" 
            id="no_hp" 
            name="no_hp" 
            value="{{ session()->get('no_hp') }}"
            class="py-2 px-3 pe-11 block w-full border-gray-200 shadow-sm text-sm rounded-lg focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none" placeholder="NO HP" readonly>
          </div>

          <label for="status_ptkp" class="inline-block text-sm font-medium">
            STATUS PTKP
          </label>

          <div class="mt-2 space-y-3">
            <input type="text" 
            id="status_ptkp" 
            name="status_ptkp" 
            value="{{ session()->get('status_ptkp') }}"
            class="py-2 px-3 pe-11 block w-full border-gray-200 shadow-sm text-sm rounded-lg focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none" placeholder="STATUS PTKP" readonly>
          </div>
        </div>
        <!-- End Section -->

        <!-- Section -->
        <div class="py-4 first:pt-0 last:pb-0 border-t first:border-transparent border-gray-200">
          <label for="otp" class="block text-sm font-medium mb-2" id="otpHelper">OTP</label>
          <div class="flex rounded-lg shadow-sm">
            <input type="text" id="otp" name="otp" class="py-3 px-4 block w-full border-gray-200 shadow-sm rounded-s-lg text-sm focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none " placeholder="Dapatkan OTP">
            <button id="sendOTPCODE" type="button" class="py-3 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-semibold rounded-e-md border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-none focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none">
              Dapatkan OTP
            </button>
          </div>
        </div>
        <!-- End Section -->

        <!-- Section -->
        <div class="py-4 first:pt-0 last:pb-0 border-t first:border-transparent border-gray-200">
          <label for="username" class="inline-block text-sm font-medium">
            USERNAME : min.5 karakter; max.12 karakter
          </label>

          <div class="mt-2 space-y-3">
            <input type="text" id="username" name="username" class="py-2 px-3 pe-11 block w-full border-gray-200 shadow-sm text-sm rounded-lg focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none" placeholder="masukan username">
          </div>

          <label for="password" class="inline-block text-sm font-medium">
            PASSWORD : min.6 karakter
          </label>

          <div class="mt-2 space-y-3">
            <input type="password" id="password" name="password" class="py-2 px-3 pe-11 block w-full border-gray-200 shadow-sm text-sm rounded-lg focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none" placeholder="masukan password">
          </div>

          <label for="password_confirmation" class="inline-block text-sm font-medium">
            ULANGI PASSWORD : sama dengan PASSWORD
          </label>

          <div class="mt-2 space-y-3">
            <input type="password" id="password_confirmation" name="password_confirmation" class="py-2 px-3 pe-11 block w-full border-gray-200 shadow-sm text-sm rounded-lg focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none" placeholder="ulangi passsword">
          </div>
        </div>
        <!-- End Section -->
        
        <div class="mt-4 flex justify-end gap-x-2">
          <button type="submit" class="w-full py-2 px-3 inline-flex items-center gap-x-2 text-lg font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-none focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none">
            Daftar
          </button>
        </div>

      </form>

      <div class="mt-8 sm:mt-14 flex flex-row gap-x-4 justify-between">
        <a class="inline-flex items-center gap-x-1 text-md text-blue-600 decoration-2 hover:underline focus:outline-none focus:underline font-medium dark:text-blue-500" href="{{ route('cari-index') }}">
          <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>
          Cari NPP
        </a>

        <a class="inline-flex items-center gap-x-1 text-md text-blue-600 decoration-2 hover:underline focus:outline-none focus:underline font-medium dark:text-blue-500" href="{{ route('auth-login') }}">
          Masuk
          <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
        </a>
      </div>

    </div>
    <!-- End Card -->
  </div>
  <!-- End Card Section -->
  @endif
</main>

<script type="module">
    document.addEventListener("DOMContentLoaded", () => {
    const nik = document.getElementById("nik");
    const npwp = document.getElementById("npwp");
    const notel = document.getElementById("no_hp");
    const email = document.getElementById("email");

    const maksedNik = MaskData.maskStringV2(nik.value, {
      maskWith: "*",
      maxMaskedCharacters: 16,
      unmaskedStartCharacters: 4,
      unmaskedEndCharacters: 1,
    });
    const maksedNpwp = MaskData.maskStringV2(npwp.value, {
      maskWith: "*",
      maxMaskedCharacters: 15,
      unmaskedStartCharacters: 4,
      unmaskedEndCharacters: 4,
    });
    const maskedNoTel = MaskData.maskPhone(notel.value, {
      maskWith: "*",
      unmaskedStartDigits: 4,
      unmaskedEndDigits: 1
    });
    const maskedMail = MaskData.maskEmail2(email.value, {
      maskWith: "*",
      unmaskedStartCharactersBeforeAt: 3,
      unmaskedEndCharactersAfterAt: 3,
      maskAtTheRate: false
    });
    nik.value = maksedNik;
    npwp.value = maksedNpwp;
    notel.value = maskedNoTel;
    email.value = maskedMail;
    const token = $('meta[name="_token"]').attr('content');

    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
      }
    });

    $('#sendOTPCODE').on('click', function(e) {
      e.preventDefault();
      $.ajax({
        url: "{{ route('send-otp') }}",
        type: 'POST',
        data: {
          "_token": "{{ csrf_token() }}",
        },
        success: function(result) {
          if (result.status == 'terkirim') {
            localStorage.setItem('hasSendOtp', 'dikirim');
            location.reload();
          } else {
            alert('Terjadi Kesalahan');
          }
        }
      });
    });

    if (localStorage.getItem('hasSendOtp') === 'dikirim') {
      // localStorage.setItem('hasSendOtp', 'true');
      // $('#sendOTPCODE').attr("disabled", "disabled");
      $('#sendOTPCODE').text("Kirim Ulang");
      $('#otpHelper').text("Otp Sudah dikirim");
    }

  });
</script>
