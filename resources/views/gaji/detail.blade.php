@extends('layout.main')
@section('content')
    <div class="alert alert-light" role="alert">
        <strong>{{ $gaji->npp }}</strong> - {{ $gaji->nama }}
    </div>
    <div class="row mb-5">
        <div class="col-md-6">
            <div class="card ">
                <div class="card-header">
                    Penghasilan
                </div>
                <div class="card-body">
                    <ul class="list-group small">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div class="fw-bold">Gaji Pokok</div>
                            <span class="fw-normal">@currency($gaji->gapok)</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div class="fw-bold">Tunjangan Keluarga</div>
                            <span class="fw-normal">@currency($gaji->tj_kelu)</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div class="fw-bold">Tunjangan Pendidikan</div>
                            <span class="fw-normal">@currency($gaji->tj_pend)</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div class="fw-bold">Bruto</div>
                            <span class="fw-normal">@currency($gaji->nl_bruto1)</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div class="fw-bold">Tunjangan Jabatan</div>
                            <span class="fw-normal">@currency($gaji->tj_jbt)</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div class="fw-bold">Tunjangan Kesejahteraan</div>
                            <span class="fw-normal">@currency($gaji->tj_kesja)</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div class="fw-bold">Tunjangan Makan</div>
                            <span class="fw-normal">@currency($gaji->tj_makan)</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div class="fw-bold">Tunjangan Ketenagakerjaan</div>
                            <span class="fw-normal">@currency($gaji->tj_sostek)</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div class="fw-bold">Tunjangan Kesehatan</div>
                            <span class="fw-normal">@currency($gaji->tj_kes)</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div class="fw-bold">Tunjangan Dapen</div>
                            <span class="fw-normal">@currency($gaji->tj_dapen)</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div class="fw-bold">Tunjangan Kehadiran</div>
                            <span class="fw-normal">@currency($gaji->tj_hadir)</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div class="fw-bold">Tunjangan Lainnya</div>
                            <span class="fw-normal">@currency($gaji->tj_lainnya)</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div class="fw-bold">THR</div>
                            <span class="fw-normal">@currency($gaji->thr)</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div class="fw-bold">Bonus</div>
                            <span class="fw-normal">@currency($gaji->bonus)</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div class="fw-bold">Lembur</div>
                            <span class="fw-normal">@currency($gaji->lembur)</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div class="fw-bold">Kekurangan</div>
                            <span class="fw-normal">@currency($gaji->kurang)</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div class="fw-bold">Jumlah Hasil</div>
                            <span class="fw-normal">@currency($gaji->jm_hasil)</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    Potongan
                </div>
                <div class="card-body">
                    <ul class="list-group small">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div class="fw-bold">Potongan Dapen</div>
                            <span class="fw-normal">@currency($gaji->pot_dapen)</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div class="fw-bold">Potongan Ketenagakerjaan</div>
                            <span class="fw-normal">@currency($gaji->pot_sostek)</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div class="fw-bold">Potongan Kesehatan</div>
                            <span class="fw-normal">@currency($gaji->pot_kes)</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div class="fw-bold">Potongan SWK</div>
                            <span class="fw-normal">@currency($gaji->pot_swk)</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div class="fw-bold">Jumlah Potongan</div>
                            <span class="fw-normal">@currency($gaji->jm_potongan)</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
