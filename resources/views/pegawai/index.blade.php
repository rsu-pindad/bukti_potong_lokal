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
                                data-bs-target="#modalCreateEmployee"><i class="fa-solid fa-plus fa-fw text-primary"></i>
                                Tambah Data Pegawai</a></li>
                        <li><a type="button" class="dropdown-item" data-bs-toggle="modal"
                                data-bs-target="#modalImportEmployee"><i
                                    class="fa-solid fa-file-excel fa-fw text-success"></i>
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
                            <th>NPWP</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pegawai as $p)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $p->npp }}</td>
                                <td>{{ $p->nama }}</td>
                                <td>{{ $p->npwp }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="modalCreateEmployee" tabindex="-1" role="dialog" aria-labelledby="modalTitleId"
        aria-hidden="true">
        <div class="modal-dialog modal-sm modal-lg" role="document">
            <div class="modal-content">
                <form action="{{ route('pegawai/store') }}" method="post">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalTitleId">Tambah Data Pegawai</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="" class="form-label">NPP</label>
                            <input type="text" class="form-control @error('npp') is-invalid @enderror" name="npp"
                                id="npp" placeholder="NPP">
                            @error('npp')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Nama</label>
                            <input type="text" class="form-control @error('nama') is-invalid @enderror" name="nama"
                                id="nama" placeholder="Nama">
                            @error('nama')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">NPWP</label>
                            <input type="text" class="form-control @error('npwp') is-invalid @enderror" name="npwp"
                                id="npwp" placeholder="NPWP">
                            @error('npwp')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="modalImportEmployee" tabindex="-1" role="dialog" aria-labelledby="modalTitleId"
        aria-hidden="true">
        <div class="modal-dialog modal-sm modal-lg" role="document">
            <div class="modal-content">
                <form action="{{ route('pegawai/import') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Impor Data Pegawai</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        <div class="mb-3">
                            <label for="" class="form-label">File</label>
                            <input type="file" class="form-control @error('filePegawai') is-invalid @enderror"
                                name="filePegawai" id="filePegawai"
                                accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet">
                            @error('filePegawai')
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
