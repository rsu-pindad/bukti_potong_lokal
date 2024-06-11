@extends('layout.main')
@section('content')

@use('Carbon\Carbon')
@php
    $local_data = Carbon::parse($pph21->tgl_pph21)->locale('id');
    $set_month = $local_data->isoFormat('MMMM');
@endphp

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
        <div class="col-6 col-md-6">
            <div class="card">
                <div class="card-header">
                    RINCIAN NILAI BRUTO
                </div>
                <div class="card-body">
                    <table class="table table table-borderless table-responsive table-condensed">
                        <tr>
                            <td colspan="2">Gaji Pokok</td>
                            <td>@currency($pph21->gaji->gapok)</td>
                        </tr>
                        <tr>
                            <td>Tunj Keluarga</td>
                            <td>@currency($pph21->gaji->tj_kelu)</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Tunj Kesejahteraan</td>
                            <td>@currency($pph21->gaji->tj_kesja)</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Tunj Makan</td>
                            <td>@currency($pph21->gaji->tj_makan)</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Tunj Ketenaga</td>
                            <td>@currency($pph21->gaji->tj_sostek)</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Tunj Kesehatan</td>
                            <td>@currency($pph21->gaji->tj_kes)</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Tunj Dapen</td>
                            <td>@currency($pph21->gaji->tj_dapen)</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Tunj Hadir</td>
                            <td>@currency($pph21->gaji->tj_hadir)</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td colspan="2">Total Tunjangan</td>
                            <td>@currency($pph21->tunjangan)</td>
                        </tr>
                        <tr>
                            <td colspan="2">Nilai Bruto</td>
                            <td><b>@currency($pph21->bruto)</b></td>
                        </tr>
                    </table>
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
                        <!-- <li class="list-group-item d-flex justify-content-between align-items-center"
                            data-bs-toggle="tooltip" data-bs-title="{{ $tooltip['pph21_setahun'] }}">
                            <div class="fw-bold">PPH21 Setahun</div>
                            <span class="fw-normal">@currency($pph21->pph21_setahun)</span>
                        </li> -->
                        <li class="list-group-item d-flex justify-content-between align-items-center"
                            data-bs-toggle="tooltip" data-bs-title="{{ $tooltip['pph21_sebulan'] }}">
                            
                            <div class="fw-bold">PPH21 Sebulan <i>({{ $set_month }})</i></div>
                            <span class="fw-normal">@currency($pph21->pph21_sebulan)</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
