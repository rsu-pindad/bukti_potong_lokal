@props([
'username_karyawan' => '',
'npp_karyawan' => '',
'nama_karyawan' => '',
'npwp_karyawan' => '',
'email_karyawan' => '',
'notel_karyawan' => '',
'st_ptkp_karyawan' => '',
'st_peg_karyawan' => '',
'bsTargetPegawai' => '',
'bsTargetIdentitas' => ''
])
<section class="vh-atuo" style="background-color: #ffffff;">
    <div class="container pb-3 pt-4 h-100 m-auto">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col col-lg-6 mb-4 mb-lg-0">
                <div class="card" style="border-radius: .5rem;">
                    <div class="row g-0">
                        <div class="col-md-4 gradient-custom text-center text-dark" style="border-top-left-radius: .5rem; border-bottom-left-radius: .5rem;">
                            <div class="img-fluid my-3">
                                {!! Avatar::create($username_karyawan)->toSvg() !!}
                            </div>
                            <h5>{{$nama_karyawan}}</h5>
                            <p>{{$st_ptkp_karyawan}}</p>
                        </div>
                        <div class="col-md-8">
                            <div class="card-body p-4">
                                <h6>Identitas Akun</h6>
                                <hr class="mt-0 mb-4">
                                <div class="row pt-1">
                                    <div class="col-12 mb-3">
                                        <h6>Username</h6>
                                        <p class="text-muted">
                                            {{$username_karyawan}}
                                        </p>
                                    </div>
                                </div>
                                <div id="judulIdentitasPribadi" class="mb-2">
                                    <h6 class="d-flex justify-content-between">
                                        Identitas Pribadi
                                        <x-inputs.button 
                                            type="button" 
                                            class="btn btn-outline-secondary btn-sm editPribadi"
                                            data-bs-toggle="modal"
                                            :data-bs-target="$bsTargetIdentitas"
                                            rootId="$bsTargetIdentitas"
                                            rootLabel="Identitas Pribadi"
                                            >
                                            <i class="fa-solid fa-pencil"></i>
                                        </x-inputs.button>
                                    </h6>
                                    <hr class="mt-0 mb-3">
                                    <div class="row pt-1">
                                        <div class="col-12 mb-3 nama_lengkap">
                                            <h6>Nama Lengkap</h6>
                                            <p class="text-muted">
                                                {{$nama_karyawan}}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6 mb-3 email">
                                            <h6>Email</h6>
                                            <p class="text-muted">{{$email_karyawan}}</p>
                                        </div>
                                        <div class="col-6 mb-3 notel">
                                            <h6>No Telepon</h6>
                                            <p class="text-muted">{{$notel_karyawan}}</p>
                                        </div>
                                    </div>
                                </div>
                                <div id="judulIdentitasKepegawaian" class="mb-2">
                                    <h6 class="d-flex justify-content-between">
                                        Informasi Kepegawaian
                                        @if(Auth::user()->karyawan->user_edited === false)
                                        <x-inputs.button 
                                            type="button" 
                                            class="btn btn-outline-secondary btn-sm editKepegawaian"
                                            data-bs-toggle="modal"
                                            :data-bs-target="$bsTargetPegawai"
                                            >
                                            <i class="fa-solid fa-pen"></i>
                                        </x-inputs.button>
                                        @endif
                                    </h6>
                                    <hr class="mt-0 mb-3">
                                    <div class="row pt-1">
                                        <div class="col-12 mb-3 karyawan_npp">
                                            <h6>NPP</h6>
                                            <p class="text-muted">{{$npp_karyawan}}</p>
                                        </div>
                                    </div>
                                    <div class="row pt-1">
                                        <div class="col-12 mb-3 karyawan_npwp">
                                            <h6>NPWP</h6>
                                            <p class="text-muted">{{$npwp_karyawan}}</p>
                                        </div>
                                    </div>
                                    <div class="row pt-1">
                                        <div class="col-6 mb-3 karyawan_ptkp">
                                            <h6>PTKP</h6>
                                            <p class="text-muted">{{$st_ptkp_karyawan}}</p>
                                        </div>
                                        <div class="col-6 mb-3 karyawan_status">
                                            <h6>Status Pegawai</h6>
                                            <p class="text-muted">{{$st_peg_karyawan}}</p>
                                        </div>
                                    </div>
                                </div>
                                <div id="fakturPajak">
                                    <h6 class="d-flex justify-content-between">Faktur Pajak</h6>
                                    <hr class="mt-0 mb-4">
                                    <div class="row pt-1">
                                        <div class="col-12 mb-3">
                                            @php
                                            \Carbon\Carbon::setLocale('id');
                                            $bulan_ini = \Carbon\Carbon::now()->isoFormat('MMMM Y');
                                            $bulan_ini_signed = \Carbon\Carbon::now()->isoFormat('MMY');
                                            @endphp
                                            <h6>Status Bulan {{ $bulan_ini }}</h6>
                                            <p class="text-muted">
                                                @if(Auth::user()->karyawan->user_edited === true)
                                                <form action="{{ URL::signedRoute('pajak-parser') }}" method="post" target="_blank">
                                                    @csrf
                                                    <input type="hidden" name="bulan_ini" value="{{$bulan_ini_signed}}" readonly>
                                                    <button type="submit" class="btn btn-outline-primary btn-sm">Lihat</button>
                                                </form>
                                                {{-- <a href="{ URL::signedRoute('pajak-parser') }" target="_blank">Lihat</a> --}}
                                                @else
                                                Belum Siap
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                    <div class="row pt-1">
                                        <div class="col-12 mb-3">
                                            <h6>Status Bulan Lain</h6>
                                            <p class="text-muted">
                                                @if(Auth::user()->karyawan->user_edited === true)
                                                <form action="{{ URL::signedRoute('pajak-parser-search') }}" method="post" target="_blank">
                                                    @csrf
                                                    <div class="row mb-2">
                                                        <div class="col">
                                                            <x-forms.floating-labels name="bulan" label="Bulan" required>
                                                                <x-inputs.select id="bulan" name="bulan">
                                                                    <option hidden>Pilih Bulan</option>
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
                                                                </x-inputs.select>
                                                            </x-forms.floating-labels>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-2">
                                                        <div class="col">
                                                            <x-forms.floating-labels name="tahun" label="Tahun" required>
                                                                <x-inputs.select id="tahun" name="tahun">
                                                                    <option hidden>Pilih Tahun</option>
                                                                    <option value="2023">2023</option>
                                                                    <option value="2024">2024</option>
                                                                    <option value="2025">2025</option>
                                                                    <option value="2026">2026</option>
                                                                    <option value="2027">2027</option>
                                                                </x-inputs.select>
                                                            </x-forms.floating-labels>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col">
                                                            <x-inputs.button type="submit" class="btn btn-primary">
                                                                Cari
                                                            </x-inputs.button>
                                                        </div>
                                                    </div>
                                                </form>
                                                @else
                                                Belum Siap
                                                @endif
                                            </p>
                                        </div>
                                        {{-- <div class="col-12 mb-3">
                                            <h6>Dokumen</h6>
                                            if(Auth::user()->karyawan->user_edited === true)
                                            <div class="text-muted container-fluid" id="dokumenPajak">
                                                php
                                                $filesPath = storage_path('app/public/files/shares/pajak/template_penilaian.zip');
                                                endphp
                                                bassetArchive($filesPath, 'pajak')
                                                basset('pajak/template_penilaian.pdf')
                                            </div>
                                            else
                                            Mohon Isi Data diri
                                            endif
                                        </div> --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@pushOnce('styles')
<style>
    .gradient-custom {
        /* fallback for old browsers */
        background: #a8a8a8;

        /* Chrome 10-25, Safari 5.1-6 */
        background: -webkit-linear-gradient(to right bottom, rgb(148, 255, 148), rgb(51, 255, 0));

        /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
        background: linear-gradient(to right bottom, rgb(1148, 255, 148), rgb(51, 255, 0))
    }

</style>
@endPushOnce

@pushOnce('scripts')
<script>
    // let dokumen = document.getElementById('dokumenPajak'); x
    // let dokumenObject = dokumen.querySelector('object'); x
    // let dokumenObjectLink = dokumenObject.querySelector('p > a'); x
    // let dokumentObjectAtribute = dokumenObject.getAttribute("data"); x
    // let signedUrl = `{! URL::signedRoute('pajak', ['user' => Auth::user()->username], absolute: false) !!}`;
    // let dokumenLink = dokumen.querySelector('link');
    // let dokumentLinkAtribute = dokumenLink.getAttribute("href");
    
    // let newElement = document.createElement('a');

    // newElement.textContent = `Lihat`;
    // newElement.setAttribute('href',dokumentLinkAtribute);
    // newElement.setAttribute('target','_blank');
    // newElement.setAttribute('id','lihatDokumen');
    // let newElement = document.createElement('a');

    // dokumenObject.setAttribute('class', 'object-fit-fill');

    // dokumen.removeChild(dokumenLink);
    // dokumen.appendChild(newElement);

    // let dokumenLink = dokumen.querySelector('link'),index;
    // // let dokumentLinkAtribute = dokumenLink.getAttribute("href");
    // for (index = dokumenLink.length - 1; index >= 0; index--) {
    //     dokumenLink[index].parentNode.removeChild(dokumenLink[index]);
    // }

    // let text_link = dokumentLinkAtribute;

    // console.log(signedUrl); x

</script>
@endpushOnce