@extends('layout.main')
@section('content')
  <div class="card">
    <div class="card-header d-flex align-items-center justify-content-between">
      <span>Data Pegawai Baru</span>
      <div class="my-auto">
        <div class="dropdown">
          <button class="btn"
                  type="button"
                  data-bs-toggle="dropdown"
                  aria-expanded="false">
            <i class="fa-solid fa-ellipsis"></i>
          </button>
          <ul class="dropdown-menu">
            {{-- <li><a type="button"
                 class="dropdown-item"
                 data-bs-toggle="modal"
                 data-bs-target="#modalCreateEmployee">
                <i class="fa-regular fa-pen-to-square fa-fw text-primary"></i>
                Tambah / Perbarui Data Pegawai</a></li> --}}
            <li>
              <a type="button"
                 class="dropdown-item"
                 data-bs-toggle="modal"
                 data-bs-target="#modalImportEmployee">
                <i class="fa-regular fa-file-excel fa-fw text-success"></i>
                Impor Data Pegawai
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>
            {{-- <li>
              <a class="dropdown-item"
                 href="{{ route('pegawai/export') }}">
                <i class="fa-solid fa-file-download fa-fw text-success"></i> Ekspor
                Data Pegawai</a>
            </li> --}}
          </ul>
        </div>
      </div>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table id="dataTable"
               class="table-light table-bordered table-hover table-striped table">
          <thead>
            <tr>
              <th>No</th>
              <th>NPP</th>
              <th>NIK</th>
              <th>NPWP</th>
              {{-- <th>Nama</th> --}}
              <th>Status PTKP</th>
              <th>Email</th>
              <th>No Hp</th>
              <th>EPin</th>
              {{-- <th>Status Pegawai</th> --}}
            </tr>
          </thead>
          <tbody>
            @foreach ($pegawai as $p)
              <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $p->npp }}</td>
                <td>{{ $p->nik }}</td>
                <td>{{ $p->npwp }}</td>
                <td>{{ $p->status_ptkp }}</td>
                <td>{{ $p->email }}</td>
                <td>{{ $p->no_hp }}</td>
                <td>{{ $p->epin }}</td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>

    </div>
  </div>
  <!-- Modal -->
  <div id="modalImportEmployee"
       class="modal fade"
       tabindex="-1"
       role="dialog"
       aria-labelledby="modalTitleId"
       aria-hidden="true">
    <div class="modal-dialog modal-sm modal-lg"
         role="document">
      <div class="modal-content">
        <form action="{{ route('pegawai/import-baru') }}"
              method="post"
              enctype="multipart/form-data">
          @csrf
          <div class="modal-header">
            <h5 class="modal-title">Impor Data Pegawai</h5>
            <button type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close"></button>
          </div>
          <div class="modal-body">

            <div class="mb-3">
              <label for=""
                     class="form-label">File</label>
              <input id="filePegawai"
                     type="file"
                     class="form-control @error('filePegawai') is-invalid @enderror"
                     name="filePegawai"
                     accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet">
              @error('filePegawai')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
          </div>
          <div class="modal-footer">
            <button type="button"
                    class="btn btn-secondary"
                    data-bs-dismiss="modal">Tutup</button>
            <button type="submit"
                    class="btn btn-primary">Simpan</button>
          </div>
        </form>
      </div>
    </div>
  </div>
@endsection
