<x-employee>

  <x-employee.breadcrumb top_page="beranda"
                         current_page="{{ Auth::user()->username ?? '' }}">
    <li class="breadcrumb-item">
      <a href="#">Beranda</a>
    </li>
  </x-employee.breadcrumb>
  <x-employee.personal-profile username_karyawan="{{ Auth::user()->username }}"
                               npp_karyawan="{{ Auth::user()->employee->npp ?? '' }}"
                               nama_karyawan="{{ Auth::user()->employee->nama ?? '' }}"
                               npwp_karyawan="{{ Auth::user()->employee->npwp ?? '' }}"
                               nik_karyawan="{{ Auth::user()->employee->nik ?? '' }}"
                               epin_karyawan="{{ Auth::user()->employee->epin ?? '-' }}"
                               email_karyawan="{{ Auth::user()->employee->email ?? '' }}"
                               notel_karyawan="{{ Auth::user()->employee->no_hp ?? '' }}"
                               st_ptkp_karyawan="{{ Auth::user()->employee->status_ptkp ?? '' }}"
                               st_peg_karyawan="{{ Auth::user()->employee->status_kepegawaian ?? '' }}"
                               bsTargetPegawai="#informasiKepegawaian"
                               bsTargetIdentitas="#informasiIdentitas" />

  @pushOnce('modals')
    <x-modal.default-inner rootId="informasiIdentitas"
                           rootLabel="Informasi Identitas">
      <x-slot:header>
        <i class="fa-solid fa-user px-2"></i>
      </x-slot:header>
      <form action="{{ route('personal-update') }}"
            method="post">
        @method('patch')
        @csrf
        <div class="row mb-2">
          <div class="col-12">
            <x-forms.floating-labels name="nama"
                                     label="Nama">
              <x-inputs.input id="nama"
                              name="nama"
                              placeholder="nama..."
                              value="{{ Auth::user()->employee->nama }}"
                              required />
            </x-forms.floating-labels>
          </div>
        </div>
        <div class="row mb-2">
          <div class="col-12">
            <x-forms.floating-labels name="email"
                                     label="Email">
              <x-inputs.input id="email"
                              type="email"
                              name="email"
                              placeholder="email..."
                              value="{{ Auth::user()->employee->email }}"
                              required />
            </x-forms.floating-labels>
          </div>
        </div>
        <div class="row mb-2">
          <div class="col-12">
            <x-forms.floating-labels name="NoTel"
                                     label="No Telephone">
              <x-inputs.input id="notel"
                              type="tel"
                              name="notel"
                              placeholder="nomor telephone..."
                              value="{{ Auth::user()->employee->no_hp }}"
                              required />
            </x-forms.floating-labels>
          </div>
        </div>
        <div class="row">
          <div class="col">
            <x-inputs.button type="submit"
                             class="btn btn-primary">
              Simpan
            </x-inputs.button>
          </div>
        </div>
      </form>
    </x-modal.default-inner>

    @if (!Auth::user()->employee->is_setuju)
      <x-modal.default-inner rootId="informasiKepegawaian"
                             rootLabel="Informasi Kepegawaian">
        <x-slot:header>
          <i class="fa-solid fa-id-card px-2"></i>
        </x-slot:header>
        <form action="{{ route('personal-edit') }}"
              method="POST">
          @method('patch')
          @csrf
          <div class="row">
            <div class="col-12 mb-3">
              <x-forms.floating-labels name="npp"
                                       label="NPP">
                <x-inputs.input id="npp"
                                name="npp"
                                class="form-control-plaintext"
                                value="{{ Auth::user()->employee->npp }}"
                                placeholder="npp...."
                                readonly />
              </x-forms.floating-labels>
            </div>
            <div class="col-12 mb-3">
              <x-forms.floating-labels name="npwp"
                                       label="NPWP">
                <x-inputs.input id="npwp"
                                name="npwp"
                                value="{{ Auth::user()->employee->npwp }}"
                                placeholder="npwp...."
                                required
                                readonly />
              </x-forms.floating-labels>
            </div>
            <div class="col-12 mb-3">
              <x-forms.floating-labels name="ptkp"
                                       label="PTKP"
                                       required>
                <x-inputs.select id="ptkp"
                                 name="ptkp"
                                 readonly>
                  <option value="{{ Auth::user()->employee->status_ptkp ?? '' }}"
                          selected
                          readonly>{{ Auth::user()->employee->status_ptkp ?? 'Belum Diisi' }}</option>
                  
                </x-inputs.select>
              </x-forms.floating-labels>
            </div>
            <div class="col-12 mb-3">
              <x-forms.floating-labels name="stpeg"
                                       label="Status"
                                       required>
                <x-inputs.select id="st_peg"
                                 name="st_peg"
                                 readonly>
                  <option value="{{ Auth::user()->employee->status_kepegawaian ?? '' }}"
                          selected
                          readonly>{{ Auth::user()->employee->status_kepegawaian ?? 'Belum Diisi' }}</option>
                  
                </x-inputs.select>
              </x-forms.floating-labels>
            </div>
            <div class="col-12 mb-3">
              <x-forms.check id="persetujuan"
                             labelId="persetujuan">
                <x-inputs.input id="persetujuan"
                                type="checkbox"
                                name="persetujuan"
                                class="form-check-input"
                                value="true" />
                <x-slot:caption>
                  data kepegawaian saya sudah benar.
                  jika terdapat ketidak sesuaikan data kepegawaian,
                  mohon hubungi bagian sdm
                </x-slot:caption>
              </x-forms.check>
            </div>
            <div class="col">
              <div class="d-grid gap-2">
                <x-inputs.button type="submit"
                                 class="btn btn-primary">
                  Simpan & Buka Form Bukti Potong
                </x-inputs.button>
              </div>
            </div>
          </div>
        </form>
      </x-modal.default-inner>
    @endif
  @endpushOnce

  @pushOnce('scripts')
    <script type="module">
      //   const driver = window.driver.js.driver;

      const driverObj = driver({
        showProgress: true,
        allowClose: false,
        steps: [{
          element: '#judulIdentitasPribadi',
          popover: {
            title: 'Identitas Pribadi',
            description: 'Mohon lengkapi data pribadi'
          }
        }, {
          element: '.nama_lengkap',
          popover: {
            title: 'Nama Lengkap',
            description: 'Mohon isi nama lengkap'
          }
        }, {
          element: '.email',
          popover: {
            title: 'Email',
            description: 'Mohon isi email'
          }
        }, {
          element: '.notel',
          popover: {
            title: 'Nomor Telepon',
            description: 'Mohon isi nomor telepon'
          }
        }, {
          element: '.editPribadi',
          popover: {
            title: 'Edit Pribadi',
            description: 'Gunakan icon berikut'
          }
        }, {
          element: '#judulIdentitasKepegawaian',
          popover: {
            title: 'Identitas Pegawai',
            description: 'Mohon Lengkapi data pegawai'
          }
        }, {
          element: '.karyawan_epin',
          popover: {
            title: 'EPIN',
            description: 'Epin Akan diisi oleh pajak'
          }
        }, {
          element: '.karyawan_npwp',
          popover: {
            title: 'NPWP',
            description: 'Mohon Isi NPWP 16 Digit'
          }
        }, {
          element: '.karyawan_ptkp',
          popover: {
            title: 'PTKP',
            description: 'Pilih PTKP'
          }
        }, {
          element: '.karyawan_status',
          popover: {
            title: 'Status',
            description: 'Pilih Status'
          }
        }, {
          element: '.editKepegawaian',
          popover: {
            title: 'Edit Kepegawaian',
            description: 'Gunakan icon berikut'
          }
        }, {
          element: '#fakturPajak',
          popover: {
            title: 'Bukti Potong',
            description: 'Dokumen Bukti Potong dapat dilihat setelah melengkapi identitas kepegawaian'
          }
        }, ]
      });

      if (localStorage.getItem('tours') !== 'viewed') {
        driverObj.drive();
        localStorage.setItem('tours', 'viewed');
      }
    </script>
    <script type="module">
      document.addEventListener("DOMContentLoaded", () => {
        var notel = document.getElementById("notel");
        // console.log(notel);
        var npwp = document.getElementById("npwp");
        // console.log(npwp);
        var im = new Inputmask("08999999[9999]");
        var np = new Inputmask("99.999.999.9-999.999");
        im.mask(notel);
        np.mask(npwp);
      });
    </script>
  @endpushOnce

</x-employee>
