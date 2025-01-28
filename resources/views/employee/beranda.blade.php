<x-employee>
<!-- Card Section -->
<div class="max-w-4xl px-4 py-6 sm:px-4 lg:px-6 mx-auto"><!-- Card -->
  <div class="bg-white rounded-xl shadow p-4 sm:p-7" id="identitasPribadi">
    <div class="mb-4">
      <h2 class="text-xl font-bold text-gray-800">
        Profil
      </h2>
      <p class="text-sm text-gray-600">
        Identitas pribadi
      </p>
    </div>

    <form>
      <!-- Grid -->
      <div class="grid sm:grid-cols-12 gap-2 sm:gap-6">
        <div class="sm:col-span-3">
          <label class="inline-block text-sm text-gray-800 mt-2.5">
            Photo
          </label>
        </div>
        <!-- End Col -->

        <div class="sm:col-span-9">
          <div class="flex items-center gap-5">
            <img class="inline-block size-16 rounded-full ring-2 ring-white" src="{!! Avatar::create(auth()->user()->username)->toBase64() !!}" alt="Avatar">
          </div>
        </div>
        <!-- End Col -->

        <div class="sm:col-span-3">
          <label for="nik" class="inline-block text-sm text-gray-800 mt-2.5">
            NIK
          </label>
        </div>
        
        <!-- End Col -->
        <div class="sm:col-span-9" id="ipNik">
          <div class="sm:flex">
            <input readonly id="nik" value="{{$profil->employee->nik}}" type="text" class="py-2 px-3 pe-11 block w-full border-gray-200 shadow-sm -mt-px -ms-px first:rounded-t-lg last:rounded-b-lg sm:first:rounded-s-lg sm:mt-0 sm:first:ms-0 sm:first:rounded-se-none sm:last:rounded-es-none sm:last:rounded-e-lg text-sm relative focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none" placeholder="{{$profil->employee->nik}}">
          </div>
        </div>
        <!-- End Col -->

        <div class="sm:col-span-3">
          <label for="nama" class="inline-block text-sm text-gray-800 mt-2.5">
            Nama Lengkap
          </label>
        </div>

        <!-- End Col -->
        <div class="sm:col-span-9" id="ipNama">
          <div class="sm:flex">
            <input readonly id="nama" value="{{$profil->employee->nama}}" type="text" class="py-2 px-3 pe-11 block w-full border-gray-200 shadow-sm -mt-px -ms-px first:rounded-t-lg last:rounded-b-lg sm:first:rounded-s-lg sm:mt-0 sm:first:ms-0 sm:first:rounded-se-none sm:last:rounded-es-none sm:last:rounded-e-lg text-sm relative focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none" placeholder="{{$profil->employee->nama}}">
          </div>
        </div>
        <!-- End Col -->

        <div class="sm:col-span-3">
          <label for="email" class="inline-block text-sm text-gray-800 mt-2.5">
            Email
          </label>
        </div>
        <!-- End Col -->

        <div class="sm:col-span-9" id="idEmail">
          <input readonly id="email" value="{{$profil->employee->email}}" type="email" class="py-2 px-3 pe-11 block w-full border-gray-200 shadow-sm text-sm rounded-lg focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none" placeholder="{{$profil->employee->email}}">
        </div>
        <!-- End Col -->

        <div class="sm:col-span-3">
          <div class="inline-block">
            <label for="no_hp" class="inline-block text-sm text-gray-800 mt-2.5">
              No HP
            </label>
            <!-- <span class="text-sm text-gray-400">
              (Optional)
            </span> -->
          </div>
        </div>
        <!-- End Col -->

        <div class="sm:col-span-9" id="ipNotel">
          <div class="sm:flex">
            <input readonly id="no_hp" value="{{$profil->employee->no_hp}}" type="text" class="py-2 px-3 pe-11 block w-full border-gray-200 shadow-sm -mt-px -ms-px first:rounded-t-lg last:rounded-b-lg sm:first:rounded-s-lg sm:mt-0 sm:first:ms-0 sm:first:rounded-se-none sm:last:rounded-es-none sm:last:rounded-e-lg text-sm relative focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none" placeholder="{{$profil->employee->no_hp}}">
          </div>
        </div>
        <!-- End Col -->
      </div>
      <!-- End Grid -->

      <div class="mt-5 flex justify-end gap-x-2" id="ipInfoSdm">
        <button type="button" class="w-full py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-none focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none">
          Hub SDM untuk memperbarui data
        </button>
      </div>
    </form>
  </div>
  <!-- End Card -->
</div>
<!-- End Card Section -->

<!-- Card Section -->
<div class="max-w-4xl px-4 py-6 sm:px-4 lg:px-6 mx-auto"><!-- Card -->
  <div class="bg-white rounded-xl shadow p-4 sm:p-7" id="identitasKepegawaian">
    <div class="mb-4">
      <h2 class="text-xl font-bold text-gray-800">
        Identitas kepegawaian
      </h2>
    </div>
    @if (Auth::user()->employee->is_aggree == false)
    <form action="{{ route('personal-update') }}"
    method="POST">
    @method('patch')
    @csrf
    @else
    <form>
    @endif
      <!-- Grid -->
      <div class="grid sm:grid-cols-12 gap-2 sm:gap-6">

        <div class="sm:col-span-3">
          <label for="epin" class="inline-block text-sm text-gray-800 mt-2.5">
            EPIN
          </label>
        </div>
        <!-- End Col -->
        <div class="sm:col-span-9" id="ikEpin">
          <div class="sm:flex">
            <input readonly id="epin" value="{{$profil->employee->epin}}" type="text" class="py-2 px-3 pe-11 block w-full border-gray-200 shadow-sm -mt-px -ms-px first:rounded-t-lg last:rounded-b-lg sm:first:rounded-s-lg sm:mt-0 sm:first:ms-0 sm:first:rounded-se-none sm:last:rounded-es-none sm:last:rounded-e-lg text-sm relative focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none" placeholder="{{$profil->employee->epin}}">
          </div>
        </div>
        <!-- End Col -->

        <div class="sm:col-span-3">
          <label for="npp" class="inline-block text-sm text-gray-800 mt-2.5">
            NPP
          </label>
        </div>
        <!-- End Col -->

        <div class="sm:col-span-9" id="ikNpp">
          <input readonly id="npp" value="{{$profil->employee->npp}}" type="email" class="py-2 px-3 pe-11 block w-full border-gray-200 shadow-sm text-sm rounded-lg focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none" placeholder="{{$profil->employee->npp}}">
        </div>
        <!-- End Col -->

        <div class="sm:col-span-3">
          <label for="npwp" class="inline-block text-sm text-gray-800 mt-2.5">
            NPWP
          </label>
        </div>
        <!-- End Col -->

        <div class="sm:col-span-9" id="ikNpwp">
          <input readonly id="npwp" value="{{$profil->employee->npwp}}" type="email" class="py-2 px-3 pe-11 block w-full border-gray-200 shadow-sm text-sm rounded-lg focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none" placeholder="{{$profil->employee->npwp}}">
        </div>
        <!-- End Col -->

        <div class="sm:col-span-3">
          <label for="st_ptkp" class="inline-block text-sm text-gray-800 mt-2.5">
            Status PTKP
          </label>
        </div>
        <!-- End Col -->

        <div class="sm:col-span-9" id="ikPtkp">
          <div class="sm:flex">
            <label for="st_ptkp" class="flex py-2 px-3 w-full border border-gray-200 shadow-sm -mt-px -ms-px first:rounded-t-lg last:rounded-b-lg sm:first:rounded-s-lg sm:mt-0 sm:first:ms-0 sm:first:rounded-se-none sm:last:rounded-es-none sm:last:rounded-e-lg text-sm relative focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none">
              <input readonly type="radio" name="st_ptkp" class="shrink-0 mt-0.5 border-gray-300 rounded-full text-blue-600 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none" id="st_ptkp" checked>
              <span class="text-sm text-gray-500 ms-3">
                {{$profil->employee->status_ptkp}}
              </span>
            </label>
          </div>
        </div>

        <div class="sm:col-span-3">
          <label for="st_peg" class="inline-block text-sm text-gray-800 mt-2.5">
            Status Pegawai
          </label>
        </div>
        <!-- End Col -->

        <!-- End Col -->
        <div class="sm:col-span-9" id="ikPeg">
          <div class="sm:flex">
            <label for="st_peg" class="flex py-2 px-3 w-full border border-gray-200 shadow-sm -mt-px -ms-px first:rounded-t-lg last:rounded-b-lg sm:first:rounded-s-lg sm:mt-0 sm:first:ms-0 sm:first:rounded-se-none sm:last:rounded-es-none sm:last:rounded-e-lg text-sm relative focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none">
              <input readonly type="radio" name="st_peg" class="shrink-0 mt-0.5 border-gray-300 rounded-full text-blue-600 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none" id="st_peg" checked>
              <span class="text-sm text-gray-500 ms-3">
                {{$profil->employee->status_kepegawaian}}
              </span>
            </label>
          </div>
        </div>

        @if (Auth::user()->employee->is_aggree == false)
        <!-- End Col -->
        <div class="sm:col-span-12 mt-4">
          <div class="sm:flex">
            <label for="aggrement" class="flex py-2 px-3 w-full border border-gray-200 shadow-sm -mt-px -ms-px first:rounded-t-lg last:rounded-b-lg sm:first:rounded-s-lg sm:mt-0 sm:first:ms-0 sm:first:rounded-se-none sm:last:rounded-es-none sm:last:rounded-e-lg text-sm relative focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none">
              <input type="checkbox" name="aggrement" class="shrink-0 mt-0.5 border-gray-300 rounded-full text-blue-600 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none" id="aggrement" value="true">
              <span class="text-md text-pretty text-gray-500 ms-3">
                data kepegawaian saya sudah benar.
                jika terdapat ketidak sesuaikan data kepegawaian,
                mohon hubungi bagian sdm
              </span>
            </label>
            @error('aggrement')
              <p class="text-xs text-red-600 mt-2">
                {{ $message }}
              </p>
            @enderror
          </div>
        </div>
        <!-- End Col -->
         @endif

      </div>
      <!-- End Grid -->
      @if (Auth::user()->employee->is_aggree == false)
      <div class="mt-5 flex justify-end gap-x-2" id="ikAggre">
        <button type="submit" class="w-full py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-none focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none">
           Terapkan & Buka Form Pencarian Bupot
        </button>
      </div>
      @else
      <div class="mt-5 flex justify-end gap-x-2" id="ikAggre">
        <a href="{{ route('personal-parser-index') }}" class="w-full py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-none focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none">
            Cari Bupot
        </a>
      </div>
      @endif

    </form>
  </div>
</div>
<!-- Card Section -->

<script type="module">

    document.addEventListener('DOMContentLoaded', function(e){
        e.preventDefault();
        
    const buttonNav =  document.getElementById("navigationToggle");
    const tours = "{{auth()->user()->employee->is_aggree}}";
   
    const driverObj = new driver({
    overlayColor: 'red',
    showProgress: true,
    allowClose: true,
    steps: [{
        element: '#identitasPribadi',
        popover: {
        title: 'Identitas Pribadi',
        description: 'Pastikan data pribadi sesuai.'
        }
    }, {
        element: '#ipNik',
        popover: {
        title: 'Nik',
        description: 'Apakah nik sesuai ?.'
        }
    }, {
        element: '#ipNama',
        popover: {
        title: 'Nama Lengkap',
        description: 'Apakah nama sesuai ?.'
        }
    }, {
        element: '#idEmail',
        popover: {
        title: 'Email',
        description: 'Apakah email sesuai ?.'
        }
    }, {
        element: '#ipNotel',
        popover: {
        title: 'Nomor HP',
        description: 'Apakah nomor HP sesuai ?.'
        }
    }, {
        element: '#ipInfoSdm',
        popover: {
        title: 'Info SDM',
        description: 'Gunakan Tombol berikut untuk menghubungi SDM.'
        }
    }, {
        element: '#identitasKepegawaian',
        popover: {
        title: 'Identitas Kepegawai',
        description: 'Pastikan data kepegawaian sesuai.'
        }
    }, {
        element: '#ikEpin',
        popover: {
        title: 'EPIN',
        description: 'Epin Akan diisi oleh admin pajak internal PMU'
        }
    }, {
        element: '#ikNpp',
        popover: {
        title: 'NPP',
        description: 'Apakah npp sesuai ?.'
        }
    }, {
        element: '#ikNpwp',
        popover: {
        title: 'NPWP',
        description: 'Apakah npwp sesuai ?.'
        }
    }, {
        element: '#ikPtkp',
        popover: {
        title: 'Status PTKP',
        description: 'apakah status ptkp sesuai ?.'
        }
    }, {
        element: '#ikPeg',
        popover: {
        title: 'Status Kepegawaian',
        description: 'apakah status kepegawaian sesuai ?.'
        }
    }, {
        element: '#ikAggre',
        popover: {
        title: 'Buka Form',
        description: 'Gunakan tombol berikut jika data kepegawaian sudah sesuai.'
        }
    },{
        element: '#navigationToggle',
        popover: {
        title: 'Tombol Navigasi',
        description: 'Gunakan tombol berikut untuk membuka menu.'
        }
    }
    ]
    });

    console.log(tours);
    

    // $('#navigationToggle').on('');
    if(tours == 0){
        driverObj.drive();
    }

    // buttonNav.addEventListener("click", nextTour); 

});

</script>
</x-employee>