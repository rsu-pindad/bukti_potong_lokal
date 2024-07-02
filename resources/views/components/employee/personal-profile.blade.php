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
                        <div class="col-md-4 gradient-custom text-center text-white" style="border-top-left-radius: .5rem; border-bottom-left-radius: .5rem;">
                            <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava1-bg.webp" alt="Avatar" class="img-fluid my-3" style="width: 80px;" />
                            <h5>{{$nama_karyawan}}</h5>
                            <p>{{$st_ptkp_karyawan}}</p>
                            <i class="far fa-edit mb-5"></i>
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
                                <h6 class="d-flex justify-content-between">
                                    Identitas Pribadi
                                    <x-inputs.button 
                                        type="button" 
                                        class="btn btn-outline-secondary btn-sm"
                                        data-bs-toggle="modal"
                                        :data-bs-target="$bsTargetIdentitas"
                                        rootId="$bsTargetIdentitas"
                                        rootLabel="Identitas Pribadi"
                                        >
                                        <i class="bi bi-pencil"></i>
                                    </x-inputs.button>
                                </h6>
                                <hr class="mt-0 mb-4">
                                <div class="row pt-1">
                                    <div class="col-12 mb-3">
                                        <h6>Nama Lengkap</h6>
                                        <p class="text-muted">
                                            {{$nama_karyawan}}
                                        </p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6 mb-3">
                                        <h6>Email</h6>
                                        <p class="text-muted">{{$email_karyawan}}</p>
                                    </div>
                                    <div class="col-6 mb-3">
                                        <h6>No Telepon</h6>
                                        <p class="text-muted">{{$notel_karyawan}}</p>
                                    </div>
                                </div>
                                <h6 class="d-flex justify-content-between">
                                    Informasi Kepegawaian
                                    @if(Auth::user()->karyawan->user_edited === false)
                                    <x-inputs.button 
                                        type="button" 
                                        class="btn btn-outline-secondary btn-sm"
                                        data-bs-toggle="modal"
                                        :data-bs-target="$bsTargetPegawai"
                                        >
                                        <i class="bi bi-pencil"></i>
                                    </x-inputs.button>
                                    @endif
                                </h6>
                                <hr class="mt-0 mb-4">
                                <div class="row pt-1">
                                    <div class="col-12 mb-3">
                                        <h6>NPP</h6>
                                        <p class="text-muted">{{$npp_karyawan}}</p>
                                    </div>
                                </div>
                                <div class="row pt-1">
                                    <div class="col-12 mb-3">
                                        <h6>NPWP</h6>
                                        <p class="text-muted">{{$npwp_karyawan}}</p>
                                    </div>
                                </div>
                                <div class="row pt-1">
                                    <div class="col-6 mb-3">
                                        <h6>PTKP</h6>
                                        <p class="text-muted">{{$st_ptkp_karyawan}}</p>
                                    </div>
                                    <div class="col-6 mb-3">
                                        <h6>Status Pegawai</h6>
                                        <p class="text-muted">{{$st_peg_karyawan}}</p>
                                    </div>
                                </div>
                                <h6>Faktur Pajak</h6>
                                <hr class="mt-0 mb-4">
                                <div class="row pt-1">
                                    <div class="col-6 mb-3">
                                        <h6>Status</h6>
                                        <p class="text-muted">Belum tersedia</p>
                                    </div>
                                    <div class="col-6 mb-3">
                                        <h6>Dokumen</h6>
                                        <p class="text-muted">Belum tersedia</p>
                                    </div>
                                </div>
                                {{-- <div class="d-flex justify-content-start">
                                    <a href="#!"><i class="fab fa-facebook-f fa-lg me-3"></i></a>
                                    <a href="#!"><i class="fab fa-twitter fa-lg me-3"></i></a>
                                    <a href="#!"><i class="fab fa-instagram fa-lg"></i></a>
                                </div> --}}
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
