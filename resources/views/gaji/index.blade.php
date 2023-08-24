<!doctype html>
<html lang="en">

<head>
    <title>{{ $title }}</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS v5.2.1 -->
    <link rel="stylesheet" href="/dist/css/bootstrap.min.css">

    <link href="/dist/datatables.min.css" rel="stylesheet">

    <!-- FontAwesome 6.2.0 CSS -->
    <link rel="stylesheet" href="/dist/fontawesome-free-6.4.2-web/css/all.min.css" />


</head>

<body>
    <header>
        <!-- place navbar here -->
        <nav class="navbar navbar-expand-sm navbar-light bg-light">
            <div class="container">
                <a class="navbar-brand" href="#">Navbar</a>
                <button class="navbar-toggler d-lg-none" type="button" data-bs-toggle="collapse"
                    data-bs-target="#collapsibleNavId" aria-controls="collapsibleNavId" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="collapsibleNavId">
                    <ul class="navbar-nav me-auto mt-2 mt-lg-0">
                        <li class="nav-item">
                            <a class="nav-link active" href="#" aria-current="page">Home <span
                                    class="visually-hidden">(current)</span></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Link</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="dropdownId" data-bs-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">Dropdown</a>
                            <div class="dropdown-menu" aria-labelledby="dropdownId">
                                <a class="dropdown-item" href="#">Action 1</a>
                                <a class="dropdown-item" href="#">Action 2</a>
                            </div>
                        </li>
                    </ul>
                    <form class="d-flex my-2 my-lg-0">
                        <input class="form-control me-sm-2" type="text" placeholder="Search">
                        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
                    </form>
                </div>
            </div>
        </nav>

    </header>

    <main>
        <div class="container">
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between py-0">
                    <span>Header</span>
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
                            <button type="" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                data-bs-target="#modalCreateSalary"><i class="fa-solid fa-plus"></i>
                                Tambah</button>
                            <button type="" class="btn btn-success btn-sm" data-bs-toggle="modal"
                                data-bs-target="#modalImportSalary"><i class="fa-solid fa-file-excel"></i>
                                Impor</button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-light table-bordered table-hover table-striped" id="dataTable">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Bulan / Tahun</th>
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
                                    <th>Lembur</th>
                                    <th>Kekurangan</th>
                                    <th>Jumlah Hasil</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($gaji as $gj)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            {{ \Carbon\Carbon::createFromFormat('Y-m-d', $gj->tgl_gaji)->isoFormat('MMM') }}{{ ' ' }}
                                            {{ \Carbon\Carbon::createFromFormat('Y-m-d', $gj->tgl_gaji)->format('Y') }}
                                        </td>
                                        <td>{{ $gj->npp }}</td>
                                        <td>{{ $gj->nama }}</td>
                                        <td>@currency($gj->gapok) </td>
                                        <td>@currency($gj->tj_kelu) </td>
                                        <td>@currency($gj->tj_pend) </td>
                                        <td>@currency($gj->nl_bruto1) </td>
                                        <td>@currency($gj->tj_jbt) </td>
                                        <td>@currency($gj->tj_alih) </td>
                                        <td>@currency($gj->tj_kesja) </td>
                                        <td>@currency($gj->tj_beras) </td>
                                        <td>@currency($gj->tj_rayon) </td>
                                        <td>@currency($gj->tj_makan) </td>
                                        <td>@currency($gj->tj_sostek) </td>
                                        <td>@currency($gj->tj_kes) </td>
                                        <td>@currency($gj->tj_dapen) </td>
                                        <td>@currency($gj->tj_hadir) </td>
                                        <td>@currency($gj->tj_bhy) </td>
                                        <td>@currency($gj->lembur) </td>
                                        <td>@currency($gj->kurang) </td>
                                        <td>@currency($gj->jm_hasil) </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
                <div class="card-footer text-muted">
                    Footer
                </div>
            </div>
        </div>
    </main>


    <footer>

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
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
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




    </footer>

    <script src="/dist/js/bootstrap.min.js"></script>
    <script src="/dist/datatables.min.js"></script>
    <script src="/dist/fontawesome-free-6.4.2-web/css/all.min.js"></script>
    <script>
        new DataTable('#dataTable');

        const formGet = document.getElementById('formGet')
        const selectMonth = document.getElementById('selectMonth')
        const selectYear = document.getElementById('selectYear')

        selectMonth.addEventListener('change', function(event) {
            formGet.submit()
        })
        selectYear.addEventListener('change', function(event) {
            formGet.submit()
        })
    </script>
</body>

</html>
