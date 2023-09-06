@extends('layout.main')
@section('content')
    <div class="card">
        <div class="card-header d-flex align-items-center justify-content-between">
            <span>Data Pegawai</span>
            <div class="my-auto">
                <div class="dropdown">
                    <button class="btn" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fa-solid fa-ellipsis"></i>
                    </button>
                    <ul class="dropdown-menu">
                        <li><a type="button" class="dropdown-item" data-bs-toggle="modal"
                                data-bs-target="#modalCreateEmployee"><i
                                    class="fa-regular fa-pen-to-square fa-fw text-primary"></i>
                                Tambah / Perbarui Data Pegawai</a></li>
                        <li><a type="button" class="dropdown-item" data-bs-toggle="modal"
                                data-bs-target="#modalImportEmployee"><i
                                    class="fa-regular fa-file-excel fa-fw text-success"></i>
                                Impor Data Pegawai</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="{{ route('pegawai/export') }}"><i
                                    class="fa-solid fa-file-download fa-fw text-success"></i> Ekspor Data Pegawai</a></li>
                    </ul>
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
                            <th>Status PTKP</th>
                            <th>NPWP</th>
                            <th>Status Pegawai</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pegawai as $p)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $p->npp }}</td>
                                <td>{{ $p->nama }}</td>
                                <td>{{ $p->st_ptkp }}</td>
                                <td>{{ $p->npwp }}</td>
                                <td>{{ $p->st_peg }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>

    @include('pegawai.create')
    @include('pegawai.import')
@endsection
