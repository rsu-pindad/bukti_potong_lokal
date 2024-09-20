<x-employee>

    <x-employee.breadcrumb top_page="beranda" current_page="{{Route::currentRouteName()}}">
        <li class="breadcrumb-item">
            <a href="#">Beranda</a>
        </li>
    </x-employee.breadcrumb>
    <x-employee.personal-profile 
        username_karyawan="{{Auth::user()->username}}" 
        npp_karyawan="{{Auth::user()->karyawan->npp ?? ''}}" 
        nama_karyawan="{{Auth::user()->karyawan->nama ?? ''}}" 
        npwp_karyawan="{{Auth::user()->karyawan->npwp ?? ''}}" 
        nik_karyawan="{{Auth::user()->karyawan->nik ?? ''}}" 
        epin_karyawan="{{Auth::user()->karyawan->epin ?? '-'}}" 
        email_karyawan="{{Auth::user()->karyawan->email ?? ''}}" 
        notel_karyawan="{{Auth::user()->karyawan->no_tel ?? ''}}" 
        st_ptkp_karyawan="{{Auth::user()->karyawan->st_ptkp ?? ''}}" 
        st_peg_karyawan="{{Auth::user()->karyawan->st_peg ?? ''}}"
        bsTargetPegawai="#informasiKepegawaian" 
        bsTargetIdentitas="#informasiIdentitas" />

    @pushOnce('modals')
    <x-modal.default-inner rootId="informasiIdentitas" rootLabel="Informasi Identitas">
        <x-slot:header>
            <i class="fa-solid fa-user px-2"></i>
        </x-slot:header>
        <form action="{{ route('employee-edit-pribadi')}}" method="post">
            @method('patch')
            @csrf
            <div class="row mb-2">
                <div class="col-12">
                    <x-forms.floating-labels name="nama" label="Nama">
                        <x-inputs.input id="nama" name="nama" placeholder="nama..." value="{{Auth::user()->karyawan->nama}}" required />
                    </x-forms.floating-labels>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-12">
                    <x-forms.floating-labels name="email" label="Email">
                        <x-inputs.input type="email" id="email" name="email" placeholder="email..." value="{{Auth::user()->karyawan->email}}" required />
                    </x-forms.floating-labels>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-12">
                    <x-forms.floating-labels name="NoTel" label="No Telephone">
                        <x-inputs.input type="tel" id="notel" name="notel" placeholder="nomor telephone..." value="{{Auth::user()->karyawan->no_tel}}" required />
                    </x-forms.floating-labels>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <x-inputs.button type="submit" class="btn btn-primary">
                        Simpan
                    </x-inputs.button>
                </div>
            </div>
        </form>
    </x-modal.default-inner>

    @if(Auth::user()->karyawan->user_edited === false)
    <x-modal.default-inner rootId="informasiKepegawaian" rootLabel="Informasi Kepegawaian">
        <x-slot:header>
            <i class="fa-solid fa-id-card px-2"></i>
        </x-slot:header>
        <form action="{{ route('employee-edit')}}" method="POST">
            @method('patch')
            @csrf
            <div class="row">
                <div class="col-12 mb-3">
                    <x-forms.floating-labels name="npp" label="NPP">
                        <x-inputs.input id="npp" name="npp" class="form-control-plaintext" value="{{Auth::user()->karyawan->npp}}" placeholder="npp...." readonly />
                    </x-forms.floating-labels>
                </div>
                <div class="col-12 mb-3">
                    <x-forms.floating-labels name="npwp" label="NPWP">
                        <x-inputs.input id="npwp" name="npwp" value="{{Auth::user()->karyawan->npwp}}" placeholder="npwp...." required />
                    </x-forms.floating-labels>
                </div>
                <div class="col-12 mb-3">
                    <x-forms.floating-labels name="ptkp" label="PTKP" required>
                        <x-inputs.select id="ptkp" name="ptkp">
                            <option hidden>Pilih Status PTKP</option>
                            <option hidden value="{{Auth::user()->karyawan->st_ptkp ?? ''}}" selected readonly>{{Auth::user()->karyawan->st_ptkp ?? 'Belum Diisi'}}</option>
                            <option value="TK0">TK0</option>
                            <option value="TK1">TK1</option>
                            <option value="TK2">TK2</option>
                            <option value="TK3">TK3</option>
                            <option value="K0">K0</option>
                            <option value="K1">K1</option>
                            <option value="K2">K2</option>
                            <option value="K3">K3</option>
                        </x-inputs.select>
                    </x-forms.floating-labels>
                </div>
                <div class="col-12 mb-3">
                    <x-forms.floating-labels name="stpeg" label="Status" required>
                        <x-inputs.select id="st_peg" name="st_peg">
                            <option hidden>Pilih Status Karyawan</option>
                            <option value="{{Auth::user()->karyawan->st_peg ?? ''}}" selected readonly>{{Auth::user()->karyawan->st_peg ?? 'Belum Diisi'}}</option>
                            <option value="KONTRAK">KONTRAK</option>
                            <option value="TETAP">TETAP</option>
                        </x-inputs.select>
                    </x-forms.floating-labels>
                </div>
                <div class="col-12 mb-3">      
                    <x-forms.check id="persetujuan" labelId="persetujuan">
                        <x-inputs.input 
                            type="checkbox" 
                            id="persetujuan" 
                            name="persetujuan"
                            class="form-check-input"
                            value="true"
                        />    
                        <x-slot:caption>
                            Dengan ini saya, 
                            menyatakan telah mengisi data kepegawaian dengan benar,
                            sesuai dengan aturan yang ditetapkan perusahaan
                            saya siap bertanggung jawab atas data kepegaiawan yang saya isi.
                        </x-slot:caption>   
                    </x-forms.check>   
                </div>
                <div class="col">
                    <x-inputs.button type="submit" class="btn btn-primary">
                        Simpan
                    </x-inputs.button>
                </div>
            </div>
        </form>
    </x-modal.default-inner>
    @endif
    @endpushOnce

    @pushOnce('scripts')
    @basset('https://cdn.jsdelivr.net/npm/driver.js@1.0.1/dist/driver.js.iife.js')
    @endpushOnce
    @pushOnce('styles')
    @basset('https://cdn.jsdelivr.net/npm/driver.js@1.0.1/dist/driver.css')
    @endpushOnce

    @pushOnce('scripts')
    <script>
        const driver = window.driver.js.driver;

        const driverObj = driver({
            showProgress: true
            , allowClose: false
            , steps: [{
                    element: '#judulIdentitasPribadi'
                    , popover: {
                        title: 'Identitas Pribadi'
                        , description: 'Mohon lengkapi data pribadi'
                    }
                }
                , {
                    element: '.nama_lengkap'
                    , popover: {
                        title: 'Nama Lengkap'
                        , description: 'Mohon isi nama lengkap'
                    }
                }
                , {
                    element: '.email'
                    , popover: {
                        title: 'Email'
                        , description: 'Mohon isi email'
                    }
                }
                , {
                    element: '.notel'
                    , popover: {
                        title: 'Nomor Telepon'
                        , description: 'Mohon isi nomor telepon'
                    }
                }
                , {
                    element: '.editPribadi'
                    , popover: {
                        title: 'Edit Pribadi'
                        , description: 'Gunakan icon berikut'
                    }
                }
                , {
                    element: '#judulIdentitasKepegawaian'
                    , popover: {
                        title: 'Identitas Pegawai'
                        , description: 'Mohon Lengkapi data pegawai'
                    }
                }
                , {
                    element: '.karyawan_epin'
                    , popover: {
                        title: 'EPIN'
                        , description: 'Epin Akan diisi oleh pajak'
                    }
                }
                , {
                    element: '.karyawan_npwp'
                    , popover: {
                        title: 'NPWP'
                        , description: 'Mohon Isi NPWP 16 Digit'
                    }
                }
                , {
                    element: '.karyawan_ptkp'
                    , popover: {
                        title: 'PTKP'
                        , description: 'Pilih PTKP'
                    }
                }
                , {
                    element: '.karyawan_status'
                    , popover: {
                        title: 'Status'
                        , description: 'Pilih Status'
                    }
                }
                , {
                    element: '.editKepegawaian'
                    , popover: {
                        title: 'Edit Kepegawaian'
                        , description: 'Gunakan icon berikut'
                    }
                }
                , {
                    element: '#fakturPajak'
                    , popover: {
                        title: 'Faktur Pajak'
                        , description: 'Dokumen Faktur pajak dapat dilihat setelah melengkapi identitas kepegawaian'
                    }
                }
            , ]
        });

        if (localStorage.getItem('tours') !== 'viewed') {
            driverObj.drive();
            localStorage.setItem('tours', 'viewed');
        }

    </script>
    <script>
        $(document).ready(function(){
            $('#notel').inputmask({"mask": "08999999[9999]"});
            $('#npwp').inputmask({"mask": "99.999.999.9-999.999"});
        });
    </script>
    @endpushOnce

</x-employee>
