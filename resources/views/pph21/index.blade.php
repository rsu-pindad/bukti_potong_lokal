@extends('layout.main')
@section('content')
    <div class="card">
        <div class="card-header d-flex align-items-center justify-content-between py-0">
            <span>Data PPH21</span>
            <div class="d-flex gap-2 my-2">
                <form action="" method="get" class="d-flex gap-2 " id="formGet">
                    <select class="form-select form-select-sm" name="pajak" id="selectPPH21">
                        <option value="">Pilih Pajak</option>
                        <option value="all" {{ $getPajak == 'all' ? 'selected' : '' }}>Semua Data</option>
                        <option value="0" {{ $getPajak == '0' ? 'selected' : '' }}>Tidak Kena Pajak</option>
                        <option value="1" {{ $getPajak == '1' ? 'selected' : '' }}>Kena Pajak</option>
                    </select>
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
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <a href="{{ route('pph21/export', ['month' => $getMonth, 'year' => $getYear]) }}"
                                    class="dropdown-item "><i class="fa-solid fa-file-download fa-fw text-success"></i>
                                    Ekspor Data
                                    PPH21</a>
                            </li>
                            <li>
                                <form action="{{ route('pph21/delete') }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <input type="hidden" name="month" value="{{ $getMonth }}">
                                    <input type="hidden" name="year" value="{{ $getYear }}">
                                    <button type="submit" class="dropdown-item"><i
                                            class="fa-solid fa-trash-alt fa-fw text-danger"></i> Hapus Data
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
                            <th>Bulan</th>
                            <th>Tahun</th>
                            <th>NPP</th>
                            <th>Nama</th>
                            <th>Gapok</th>
                            <th>Tunjangan</th>
                            <th>Premi AS</th>
                            <th>THR</th>
                            <th>Bonus</th>
                            <th>Tunjangan Pajak</th>
                            <th>Bruto</th>
                            <th>Penghasilan</th>
                            <th>Biaya Jabatan</th>
                            <th>Iuran Pensiun</th>
                            <th>Potongan</th>
                            <th>Total Penghasilan</th>
                            <th>Neto Sebulan</th>
                            <th>Neto Setahun</th>
                            <th>PTKP</th>
                            <th>PKP</th>
                            <th>PPH21 Setahun</th>
                            <th>PPH21 Sebulan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pph21 as $p)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ \Carbon\Carbon::createFromFormat('Y-m-d', $p->tgl_gaji)->isoFormat('MMM') }}
                                </td>
                                <td>{{ \Carbon\Carbon::createFromFormat('Y-m-d', $p->tgl_gaji)->format('Y') }}</td>
                                <td>{{ $p->npp }}</td>
                                <td class="text-nowrap">{{ $p->nama }}</td>
                                <td class="text-nowrap">@currency($p->gapok)</td>
                                <td class="text-nowrap">@currency($p->tunjangan)</td>
                                <td class="text-nowrap">@currency($p->premi_as)</td>
                                <td class="text-nowrap">@currency($p->thr)</td>
                                <td class="text-nowrap">@currency($p->bonus)</td>
                                <td class="text-nowrap">@currency($p->tj_pajak)</td>
                                <td class="text-nowrap">@currency($p->bruto)</td>
                                <td class="text-nowrap">@currency($p->penghasilan)</td>
                                <td class="text-nowrap">@currency($p->biaya_jabatan)</td>
                                <td class="text-nowrap">@currency($p->iuran_pensiun)</td>
                                <td class="text-nowrap">@currency($p->potongan)</td>
                                <td class="text-nowrap">@currency($p->total_penghasilan)</td>
                                <td class="text-nowrap">@currency($p->neto_sebulan)</td>
                                <td class="text-nowrap">@currency($p->neto_setahun)</td>
                                <td class="text-nowrap">@currency($p->ptkp)</td>
                                <td class="text-nowrap">@currency($p->pkp)</td>
                                <td class="text-nowrap">@currency($p->pph21_setahun)</td>
                                <td class="text-nowrap">@currency($p->pph21_sebulan)</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>


    <!-- Modal -->
    <div class="modal fade" id="modalCreateSalary" tabindex="-1" role="dialog" aria-labelledby="modalTitleId"
        aria-hidden="true">
        <div class="modal-dialog modal-sm modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitleId">Tambah Data Gaji</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

                </div>
                <div class="modal-body">
                    <form action="" method="post">
                        @csrf

                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="modalImportSalary" tabindex="-1" role="dialog" aria-labelledby="modalTitleId"
        aria-hidden="true">
        <div class="modal-dialog modal-sm modal-lg" role="document">
            <div class="modal-content">
                <form action="{{ route('gaji/import') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Impor Data Gaji</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        <div class="mb-3">
                            <label for="" class="form-label">File</label>
                            <input type="file" class="form-control @error('fileGaji') is-invalid @enderror"
                                name="fileGaji" id="fileGaji"
                                accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet">
                            @error('fileGaji')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
