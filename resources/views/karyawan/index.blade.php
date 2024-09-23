@extends('layout.main')
@section('content')
  <div class="card">
    <div class="card-header d-flex justify-content-between flex-row">
      <h4>Data Pegawai</h4>
      <div class="my-auto">
        <div class="dropdown">
          <button class="btn btn-outline-secondary"
                  type="button"
                  data-bs-toggle="dropdown"
                  aria-expanded="false">
            Menu
            <i class="fa-solid fa-ellipsis"></i>
          </button>

          <ul class="dropdown-menu">
            {{-- <li><a type="button"
                 class="dropdown-item"
                 data-bs-toggle="modal"
                 data-bs-target="#modalCreateEmployee">
                <i class="fa-regular fa-pen-to-square fa-fw text-primary"></i>
                Tambah / Perbarui Data Pegawai</a></li> --}}
            @hasexactroles('personalia')
              <li>
                <a type="button"
                   class="dropdown-item"
                   data-bs-toggle="modal"
                   data-bs-target="#modalImportEmployee">
                  Import (Upload) <br>Data Pegawai
                  <i class="fa-solid fa-file-import text-success ml-4"></i>
                </a>
              </li>
              <li>
                <hr class="dropdown-divider">
              </li>
              <li>
                <a class="dropdown-item"
                   href="{{ route('karyawan-export') }}">
                  Eksport (Download) <br>Data Pegawai
                  <i class="fa-solid fa-file-export text-success ml-4"></i>
                </a>
              </li>
              <li>
                <hr class="dropdown-divider">
              </li>
              <li>
                <a class="dropdown-item"
                   href="{{ route('karyawan-template') }}">
                  Download <br>Template Import
                  <i class="fa-solid fa-table-cells text-danger ml-4"></i>
                </a>
              </li>
            @endhasexactroles
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
              <th>Nama</th>
              <th>Status Pegawai</th>
              <th>NIK</th>
              <th>NPWP</th>
              <th>Status PTKP</th>
              <th>Email</th>
              <th>No Hp</th>
              <th>TMT Masuk</th>
              <th>TMT Keluar</th>
              <th>EPin</th>
            </tr>
          </thead>
          <tbody>
            @forelse ($pegawai as $p)
              <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $p->npp_baru == null ? $p->npp : $p->npp_baru}}</td>
                <td>{{ $p->nama }}</td>
                <td>{{ $p->status_kepegawaian }}</td>
                <td>{{ $p->nik }}</td>
                <td>{{ $p->npwp }}</td>
                <td>{{ $p->status_ptkp }}</td>
                <td>{{ $p->email }}</td>
                <td>{{ $p->no_hp }}</td>
                <td>{{ $p->tmt_masuk }}</td>
                <td>{{ $p->tmt_keluar }}</td>
                <td>{{ $p->epin }}</td>
              </tr>
            @empty
              <tr>
                <td colspan="9"
                    class="text-center">Belum ada data</td>
              </tr>
            @endforelse
          </tbody>
          <tfoot>
            {{ $pegawai->appends($_GET)->links() }}
          </tfoot>
        </table>
      </div>

    </div>
  </div>
@endsection

@once
  @push('modals')
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
          <form action="{{ route('karyawan-import') }}"
                method="post"
                enctype="multipart/form-data">
            @csrf
            <div class="modal-header">
              <h5 class="modal-title">Impor Data Pegawai</h5>
            </div>
            <div class="modal-body">
              <div class="mb-3">
                <label for="filePegawai"
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
                      class="btn btn-primary">Import
                <i class="fa-solid fa-file-import"></i>
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  @endpush
@endonce
