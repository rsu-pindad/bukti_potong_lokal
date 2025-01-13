@props([
    'username_karyawan' => '',
    'npp_karyawan' => '',
    'nama_karyawan' => '',
    'nik_karyawan' => '',
    'epin_karyawan' => '',
    'npwp_karyawan' => '',
    'email_karyawan' => '',
    'notel_karyawan' => '',
    'st_ptkp_karyawan' => '',
    'st_peg_karyawan' => '',
    'bsTargetPegawai' => '',
    'bsTargetIdentitas' => '',
])
<section class="vh-atuo"
         style="background-color: #ffffff;">
  <div class="h-100 container m-auto pb-3 pt-4">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col col-lg-6 mb-lg-0 mb-4">
        <div class="card"
             style="border-radius: .5rem;">
          <div class="row g-0">
            <div class="col-md-4 gradient-custom text-dark text-center"
                 style="border-top-left-radius: .5rem; border-bottom-left-radius: .5rem;">
              <div class="img-fluid my-3">
                {!! Avatar::create($username_karyawan)->toSvg() !!}
              </div>
              <h5>{{ $nama_karyawan }}</h5>
              <p>{{ $st_ptkp_karyawan }}</p>
            </div>
            <div class="col-md-8">
              <div class="card-body p-4">
                <h6>Identitas Akun</h6>
                <hr class="mb-4 mt-0">
                <div class="row pt-1">
                  <div class="col-12 mb-3">
                    <h6>Username</h6>
                    <p class="text-muted">
                      {{ $username_karyawan }}
                    </p>
                  </div>
                </div>
                <div id="judulIdentitasPribadi"
                     class="mb-2">
                  <h6 class="d-flex justify-content-between">
                    Identitas Pribadi
                    <x-inputs.button type="button"
                                     class="btn btn-outline-secondary btn-sm editPribadi"
                                     data-bs-toggle="modal"
                                     :data-bs-target="$bsTargetIdentitas"
                                     rootId="$bsTargetIdentitas"
                                     rootLabel="Identitas Pribadi">
                      <i class="fa-solid fa-pencil"></i>
                    </x-inputs.button>
                  </h6>
                  <hr class="mb-3 mt-0">
                  <div class="row pt-1">
                    <div class="col-12 nik_pegawai mb-3">
                      <h6>NIK</h6>
                      <p class="text-muted">
                        {{ $nik_karyawan }}
                      </p>
                    </div>
                  </div>
                  <div class="row pt-1">
                    <div class="col-12 nama_lengkap mb-3">
                      <h6>Nama Lengkap</h6>
                      <p class="text-muted">
                        {{ $nama_karyawan }}
                      </p>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-6 email mb-3">
                      <h6>Email</h6>
                      <p class="text-muted">{{ $email_karyawan }}</p>
                    </div>
                    <div class="col-6 notel mb-3">
                      <h6>No Telepon</h6>
                      <p class="text-muted">{{ $notel_karyawan }}</p>
                    </div>
                  </div>
                </div>
                <div id="judulIdentitasKepegawaian"
                     class="mb-2">
                  <h6 class="d-flex justify-content-between">
                    Informasi Kepegawaian
                    @if (Auth::user()->karyawan->user_edited === false)
                      <x-inputs.button type="button"
                                       class="btn btn-outline-secondary btn-sm editKepegawaian"
                                       data-bs-toggle="modal"
                                       :data-bs-target="$bsTargetPegawai">
                        <i class="fa-solid fa-pen"></i>
                      </x-inputs.button>
                    @endif
                  </h6>
                  <hr class="mb-3 mt-0">
                  <div class="row pt-1">
                    <div class="col-6 karyawan_epin mb-3">
                      <h6>EPIN</h6>
                      <p class="text-muted">{{ $epin_karyawan }}</p>
                    </div>

                    <div class="col-6 karyawan_npp mb-3">
                      <h6>NPP</h6>
                      <p class="text-muted">{{ $npp_karyawan }}</p>
                    </div>
                  </div>
                  <div class="row pt-1">
                    <div class="col-12 karyawan_npwp mb-3">
                      <h6>NPWP</h6>
                      <p class="text-muted">{{ $npwp_karyawan }}</p>
                    </div>
                  </div>
                  <div class="row pt-1">
                    <div class="col-6 karyawan_ptkp mb-3">
                      <h6>PTKP</h6>
                      <p class="text-muted">{{ $st_ptkp_karyawan }}</p>
                    </div>
                    <div class="col-6 karyawan_status mb-3">
                      <h6>Status Pegawai</h6>
                      <p class="text-muted">{{ $st_peg_karyawan }}</p>
                    </div>
                  </div>
                </div>
                <div id="fakturPajak">
                  <h6 class="d-flex justify-content-between">Bukti Potong</h6>
                  <hr class="mb-4 mt-0">
                  <div class="row pt-1">
                    @if (!Auth::user()->karyawan->user_edited)
                      <p class="text-muted">Mohon lihat informasi kepegawaian</p>
                    @endif
                    <div class="col-12 mb-3">
                      @php
                        \Carbon\Carbon::setLocale('id');
                        $bulan_ini = \Carbon\Carbon::now()->isoFormat('MMMM Y');
                        $bulan_ini_signed = \Carbon\Carbon::now()->isoFormat('MMY');
                      @endphp
                      <h6>Status Bulan {{ $bulan_ini }}</h6>
                      <p class="text-muted">
                        @if (Auth::user()->karyawan->user_edited === true)
                          <div class="d-flex">
                            <form action="{{ URL::signedRoute('personal-parser-bp') }}"
                                  method="post"
                                  class="mx-2">
                              @csrf
                              <input type="hidden"
                                     name="bulan_ini"
                                     value="{{ $bulan_ini_signed }}"
                                     readonly>
                              <button type="submit"
                                      class="btn btn-outline-primary btn-sm">
                                Lihat
                                <i class="fa-solid fa-eye"></i>
                              </button>
                            </form>
                            <form action="{{ URL::signedRoute('personal-parser-bp-download') }}"
                                  method="post"
                                  class="mx-2">
                              @csrf
                              <input type="hidden"
                                     name="bulan_ini"
                                     value="{{ $bulan_ini_signed }}"
                                     readonly>
                              <button type="submit"
                                      class="btn btn-outline-secondary btn-sm">
                                Unduh
                                <i class="fa-solid fa-download"></i>
                              </button>
                            </form>
                          </div>
                          {{-- <a href="{ URL::signedRoute('personal-parser-bp') }" target="_blank">Lihat</a> --}}
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
                        @if (Auth::user()->karyawan->user_edited === true)
                          <div class="d-flex">
                            <form action="{{ URL::signedRoute('personal-parser-bp-search') }}"
                                  method="post"
                                  class="mx-2">
                              @csrf
                              <div class="row mb-2">
                                <div class="col">
                                  <x-forms.floating-labels name="bulan"
                                                           label="Bulan"
                                                           required>
                                    <x-inputs.select id="bulan"
                                                     name="bulan">
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
                                  <x-forms.floating-labels name="tahun"
                                                           label="Tahun"
                                                           required>
                                    <x-inputs.select id="tahun"
                                                     name="tahun">
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
                                  <x-inputs.button type="submit"
                                                   class="btn btn-primary">
                                    Cari
                                    <i class="fa-solid fa-magnifying-glass"></i>
                                  </x-inputs.button>
                                </div>
                              </div>
                            </form>
                            <form action="{{ URL::signedRoute('personal-parser-bp-search-download') }}"
                                  method="post"
                                  class="mx-2">
                              @csrf
                              <div class="row">
                                <div class="col">
                                  <x-inputs.button type="submit"
                                                   class="btn btn-secondary">
                                    Unduh
                                    <i class="fa-solid fa-download"></i>
                                  </x-inputs.button>
                                </div>
                              </div>
                            </form>
                          </div>
                        @else
                          Belum Siap
                        @endif
                      </p>
                    </div>
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
