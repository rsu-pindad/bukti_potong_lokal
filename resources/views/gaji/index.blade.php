@extends('layout.main')
@section('content')
    <div class="card">
        <div class="card-header d-flex align-items-center justify-content-between py-0">
            <span>Data Gaji</span>
            <div class="d-flex gap-2 my-2">
                <form action="" method="get" class="d-flex gap-2 " id="formGet">
                    <select class="form-select form-select-sm" name="month" id="selectMonth">
                        <option value="">Pilih Bulan</option>
                        @foreach ($month as $m)
                            <option value="{{ $m->bulan }}" {{ $getMonth == $m->bulan ? 'selected' : '' }}>
                                {{ $m->bulan }}</option>
                        @endforeach
                    </select>
                    <select class="form-select form-select-sm" name="year" id="selectYear">
                        <option value="">Pilih Tahun</option>
                        @foreach ($year as $y)
                            <option value="{{ $y->tahun }}" {{ $getYear == $y->tahun ? 'selected' : '' }}>
                                {{ $y->tahun }}</option>
                        @endforeach
                    </select>
                </form>
                <div class="my-auto">

                    <div class="dropdown">
                        <button class="btn " type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa-solid fa-ellipsis"></i>
                        </button>
                        <ul class="dropdown-menu">
                            <li><a type="button" class="dropdown-item" data-bs-toggle="modal"
                                    data-bs-target="#modalCreateSalary"><i
                                        class="fa-regular fa-pen-to-square fa-fw text-primary"></i>
                                    Tambah / Perbarui Data Gaji</a></li>
                            <li><a type="button" class="dropdown-item" data-bs-toggle="modal"
                                    data-bs-target="#modalImportSalary"><i
                                        class="fa-regular fa-file-excel fa-fw text-success"></i>
                                    Impor Data Gaji</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>

                            <li><a class="dropdown-item"
                                    href="{{ route('gaji/export', ['month' => $getMonth, 'year' => $getYear]) }}">
                                    <i class="fa-solid fa-file-download fa-fw text-success"></i> Ekspor Data Gaji</a></li>

                            <li>
                                <form action="{{ route('gaji/pph21') }}" method="post">
                                    @csrf
                                    <input type="hidden" name="month" value="{{ $getMonth }}">
                                    <input type="hidden" name="year" value="{{ $getYear }}">
                                    <button type="submit" class="dropdown-item"><i
                                            class="fa-solid fa-calculator fa-fw text-warning"></i> Hitung
                                        PPH21</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-light table-bordered table-hover table-striped" id="dataTable">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>NPP</th>
                            <th>Nama</th>
                            <th>Gaji Pokok</th>
                            <th>Tunjangan Keluarga</th>
                            <th>Tunjangan Pendidikan</th>
                            <th>Nilai Bruto</th>
                            <th>Tunjangan Jabatan</th>
                            <th>Tunjangan Peralihan</th>
                            <th>Tunjangan Kesejahteraan</th>
                            <th>Tunjangan Beras</th>
                            <th>Tunjangan Rayon</th>
                            <th>Tunjangan Makan</th>
                            <th>Tunjangan BPJS Ketenagakerjaan</th>
                            <th>Tunjangan BPJS Kesehatan</th>
                            <th>Tunjangan Dapen</th>
                            <th>Tunjangan Kehadiran</th>
                            <th>Tunjangan BHY</th>
                            <th>Tunjangan Lainnya</th>
                            <th>THR</th>
                            <th>Bonus</th>
                            <th>Lembur</th>
                            <th>Kekurangan</th>
                            <th>Jumlah Hasil</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($gaji as $gj)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $gj->npp }}</td>
                                <td class="text-nowrap">{{ $gj->nama }}</td>
                                <td class="text-nowrap">@currency($gj->gapok) </td>
                                <td class="text-nowrap">@currency($gj->tj_kelu) </td>
                                <td class="text-nowrap">@currency($gj->tj_pend) </td>
                                <td class="text-nowrap">@currency($gj->nl_bruto1) </td>
                                <td class="text-nowrap">@currency($gj->tj_jbt) </td>
                                <td class="text-nowrap">@currency($gj->tj_alih) </td>
                                <td class="text-nowrap">@currency($gj->tj_kesja) </td>
                                <td class="text-nowrap">@currency($gj->tj_beras) </td>
                                <td class="text-nowrap">@currency($gj->tj_rayon) </td>
                                <td class="text-nowrap">@currency($gj->tj_makan) </td>
                                <td class="text-nowrap">@currency($gj->tj_sostek) </td>
                                <td class="text-nowrap">@currency($gj->tj_kes) </td>
                                <td class="text-nowrap">@currency($gj->tj_dapen) </td>
                                <td class="text-nowrap">@currency($gj->tj_hadir) </td>
                                <td class="text-nowrap">@currency($gj->tj_bhy) </td>
                                <td class="text-nowrap">@currency($gj->tj_lainnya) </td>
                                <td class="text-nowrap">@currency($gj->thr) </td>
                                <td class="text-nowrap">@currency($gj->bonus) </td>
                                <td class="text-nowrap">@currency($gj->lembur) </td>
                                <td class="text-nowrap">@currency($gj->kurang) </td>
                                <td class="text-nowrap">@currency($gj->jm_hasil) </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>


    @include('gaji.create')
    @include('gaji.import')
@endsection
