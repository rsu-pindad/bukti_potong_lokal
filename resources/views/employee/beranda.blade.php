<x-employee>

    <x-employee.breadcrumb 
        top_page="beranda"
        current_page="{{Route::currentRouteName()}}" 
    >
    <li class="breadcrumb-item">
        <a href="#">Beranda</a>
    </li>
    </x-employee.breadcrumb>
    <x-employee.personal-profile 
        username_karyawan="{{Auth::user()->username}}" 
        npp_karyawan="{{Auth::user()->karyawan->npp}}" 
        nama_karyawan="{{Auth::user()->karyawan->nama}}" 
        npwp_karyawan="{{Auth::user()->karyawan->npwp}}" 
        email_karyawan="{{Auth::user()->karyawan->email}}" 
        notel_karyawan="{{Auth::user()->karyawan->no_tel}}" 
        st_ptkp_karyawan="{{Auth::user()->karyawan->st_ptkp ?? ''}}" 
        st_peg_karyawan="{{Auth::user()->karyawan->st_peg ?? ''}}" 
        bsTargetPegawai="#informasiKepegawaian" 
        bsTargetIdentitas="#informasiIdentitas"
    />

    @pushOnce('modals')
    <x-modal.default-inner 
        rootId="informasiIdentitas"
        rootLabel="Informasi Identitas"
        >
        <form action="{{ route('employee-edit-pribadi')}}" method="post">
            @method('patch')
            @csrf
            <div class="row mb-2">
                <div class="col-12">
                    <x-forms.floating-labels name="nama" label="Nama">
                        <x-inputs.input 
                            id="nama" 
                            name="nama" 
                            placeholder="nama..." 
                            value="{{Auth::user()->karyawan->nama}}"
                            required />
                    </x-forms.floating-labels>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-12">
                    <x-forms.floating-labels name="email" label="Email">
                        <x-inputs.input 
                            type="email"
                            id="email" 
                            name="email" 
                            placeholder="email..." 
                            value="{{Auth::user()->karyawan->email}}"
                            required />
                    </x-forms.floating-labels>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-12">
                    <x-forms.floating-labels name="NoTel" label="No Telephone">
                        <x-inputs.input 
                            type="tel"
                            id="notel" 
                            name="notel" 
                            placeholder="nomor telephone..." 
                            value="{{Auth::user()->karyawan->no_tel}}"
                            required />
                    </x-forms.floating-labels>
                </div>
            </div>
            <div class="row">
                <div class="col">    
                    <x-inputs.button 
                        type="submit"
                        class="btn btn-primary">
                        Simpan
                    </x-inputs.button>
                </div>
            </div>
        </form>
    </x-modal.default-inner>

    @if(Auth::user()->karyawan->user_edited === false)
    <x-modal.default-inner 
        rootId="informasiKepegawaian"
        rootLabel="Informasi Kepegawaian"
        >
        <form action="{{ route('employee-edit')}}" method="POST">
            @method('patch')
            @csrf
            <div class="row">
                <div class="col-12 mb-3">
                    <x-forms.floating-labels name="npp" label="NPP">
                        <x-inputs.input 
                            id="npp" 
                            name="npp" 
                            class="form-control-plaintext"
                            value="{{Auth::user()->karyawan->npp}}" 
                            placeholder="npp...." 
                            readonly />
                    </x-forms.floating-labels>
                </div>
                <div class="col-12 mb-3">
                    <x-forms.floating-labels name="npwp" label="NPWP">
                        <x-inputs.input
                            id="npwp"
                            name="npwp"
                            value="{{Auth::user()->karyawan->npwp}}"
                            placeholder="npwp...."
                            required
                        />
                    </x-forms.floating-labels>
                </div>
                <div class="col-12 mb-3">
                    <x-forms.floating-labels name="ptkp" label="PTKP" required>
                        <x-inputs.select
                            id="ptkp"
                            name="ptkp"
                            >
                            <option hidden>Pilih Status PTKP</option>
                            <option value="{{Auth::user()->karyawan->st_ptkp ?? ''}}" selected readonly>{{Auth::user()->karyawan->st_ptkp ?? 'Belum Diisi'}}</option>
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
                        <x-inputs.select
                            id="st_peg"
                            name="st_peg"
                        >
                        <option hidden>Pilih Status Karyawan</option>
                        <option value="{{Auth::user()->karyawan->st_peg ?? ''}}" selected readonly>{{Auth::user()->karyawan->st_peg ?? 'Belum Diisi'}}</option>
                        <option value="KONTRAK">KONTRAK</option>
                        <option value="TETAP">TETAP</option>
                        </x-inputs.select>
                    </x-forms.floating-labels>
                </div>
                <div class="col">    
                    <x-inputs.button 
                        type="submit"
                        class="btn btn-primary">
                        Simpan
                    </x-inputs.button>
                </div>
            </div>
        </form>
    </x-modal.default-inner>
    @endif
    @endpushOnce

</x-employee>
