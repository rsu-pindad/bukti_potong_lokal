@extends('layout.main')
@section('content')
    <div class="alert alert-light" role="alert">
        <strong>{{ $pph21->gaji->npp }}</strong> - {{ $pph21->gaji->nama }}
        <a class="btn btn-success btn-sm float-right" href="{{ route('pph21/export-detail',request()->segment(3)) }}">
            <i class="fa-solid fa-file-download fa-fw"></i>
            Export Excel
        </a>
    </div>
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card ">
                <div class="card-header">
                    Penghasilan
                </div>
                <div class="card-body">
                    <ul class="list-group small">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div class="fw-bold">Gaji Pokok</div>
                            <span class="fw-normal">@currency($pph21->gaji->gapok)</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div class="fw-bold">Tunjangan</div>
                            <span class="fw-normal">@currency($pph21->tunjangan)</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div class="fw-bold">Premi AS</div>
                            <span class="fw-normal">@currency($pph21->premi_as)</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div class="fw-bold">THR</div>
                            <span class="fw-normal">@currency($pph21->thr)</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div class="fw-bold">Bonus</div>
                            <span class="fw-normal">@currency($pph21->bonus)</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div class="fw-bold">Tunjangan Pajak</div>
                            <span class="fw-normal">@currency($pph21->tj_pajak)</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div class="fw-bold">Bruto</div>
                            <span class="fw-normal">@currency($pph21->bruto)</span>
                        </li>

                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card ">
                <div class="card-header">
                    Potongan
                </div>
                <div class="card-body">
                    <ul class="list-group small">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div class="fw-bold">Biaya Jabatan</div>
                            <span class="fw-normal">@currency($pph21->biaya_jabatan)</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div class="fw-bold">Iuran Pensiun</div>
                            <span class="fw-normal">@currency($pph21->iuran_pensiun)</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div class="fw-bold">Potongan Ketenagakerjaan</div>
                            <span class="fw-normal">@currency($pph21->gaji->pot_sostek)</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div class="fw-bold">Potongan Kesehatan</div>
                            <span class="fw-normal">@currency($pph21->gaji->pot_kes)</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div class="fw-bold">Potongan SWK</div>
                            <span class="fw-normal">@currency($pph21->gaji->pot_swk)</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div class="fw-bold">Total Potongan</div>
                            <span class="fw-normal">@currency($pph21->total_potongan)</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card ">
                <div class="card-header">
                    Perhitungan PPH21
                </div>
                <div class="card-body">
                    <ul class="list-group small">
                        <li class="list-group-item d-flex justify-content-between align-items-center"
                            data-bs-toggle="tooltip" data-bs-title="{{ $tooltip['neto_sebulan'] }}">
                            <div class="fw-bold">Neto Sebulan</div>
                            <span class="fw-normal">@currency($pph21->neto_sebulan)</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center"
                            data-bs-toggle="tooltip" data-bs-title="{{ $tooltip['neto_setahun'] }}">
                            <div class="fw-bold">Neto Setahun</div>
                            <span class="fw-normal">@currency($pph21->neto_setahun)</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div class="fw-bold">PTKP</div>
                            <span class="fw-normal">@currency($pph21->ptkp)</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center"
                            data-bs-toggle="tooltip" data-bs-title="{{ $tooltip['pkp'] }}">
                            <div class="fw-bold">PKP</div>
                            <span class="fw-normal">@currency($pph21->pkp)</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center"
                            data-bs-toggle="tooltip" data-bs-title="{{ $tooltip['pph21_setahun'] }}">
                            <div class="fw-bold">PPH21 Setahun</div>
                            <span class="fw-normal">@currency($pph21->pph21_setahun)</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center"
                            data-bs-toggle="tooltip" data-bs-title="{{ $tooltip['pph21_sebulan'] }}">
                            <div class="fw-bold">PPH21 Sebulan</div>
                            <span class="fw-normal">@currency($pph21->pph21_sebulan)</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
