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
            @hasexactroles('personalia')
              {{-- <li>
                <a type="button"
                   class="dropdown-item"
                   data-bs-toggle="modal"
                   data-bs-target="#modalCreateEmployee">
                  Tambah Data <br>Pegawai
                  <i class="fa-regular fa-pen-to-square fa-fw text-primary"></i>
                </a>
              </li> --}}
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
            @hasexactroles('pajak')
              <li>
                <a type="button"
                   class="dropdown-item"
                   data-bs-toggle="modal"
                   data-bs-target="#modalEpinImportEmployee">
                  Import (Upload) <br>Epin Data Pegawai
                  <i class="fa-solid fa-file-import text-success ml-4"></i>
                </a>
              </li>
              <li>
                <hr class="dropdown-divider">
              </li>
              <li>
                <a class="dropdown-item"
                   href="{{ route('karyawan-epin-export') }}">
                  Eksport (Download) <br>Epin Data Pegawai
                  <i class="fa-solid fa-file-export text-success ml-4"></i>
                </a>
              </li>
              <li>
                <hr class="dropdown-divider">
              </li>
              <li>
                <a class="dropdown-item"
                   href="{{ route('karyawan-epin-template') }}">
                  Download <br>Template EPin Import
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
              @hasexactroles('personalia')
                <th>Email</th>
                <th>No Hp</th>
              @endhasexactroles
              <th>TMT Masuk</th>
              <th>TMT Keluar</th>
              @hasexactroles('pajak')
                <th>EPin</th>
              @endhasexactroles
              <th>Update</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            @hasexactroles('pajak')
              @forelse ($pegawai as $p)
                <tr>
                  <td>{{ $loop->iteration }}</td>
                  <td>{{ $p->npp_baru == null ? $p->npp : $p->npp_baru }}</td>
                  <td>{{ $p->nama }}</td>
                  <td>{{ $p->status_kepegawaian }}</td>
                  <td>{{ $p->nik }}</td>
                  <td>{{ $p->npwp }}</td>
                  <td>{{ $p->status_ptkp }}</td>
                  <td>{{ $p->tmt_masuk }}</td>
                  <td>{{ $p->tmt_keluar }}</td>
                  <td>{{ $p->epin }}</td>
                  <td>{{ Illuminate\Support\Carbon::parse($p->updated_at)->diffForHumans() }}</td>
                  <td>
                    <div class="d-flex justify-content-around flex-row">
                      <div>
                        <a href="{{ route('karyawan-epin-edit', ['id' => $p->id]) }}"
                           class="btn btn-outline-info inlineEdit">
                          Edit
                          <i class="fa-solid fa-pen-to-square"></i>
                        </a>
                      </div>
                    </div>
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="11"
                      class="text-center">Belum ada data</td>
                </tr>
              @endforelse
            @endhasexactroles
            @hasexactroles('personalia')
              @forelse ($pegawai as $p)
                <tr>
                  <td>{{ $loop->iteration }}</td>
                  <td>{{ $p->npp_baru == null ? $p->npp : $p->npp_baru }}</td>
                  <td>{{ $p->nama }}</td>
                  <td>{{ $p->status_kepegawaian }}</td>
                  <td>{{ $p->nik }}</td>
                  <td>{{ $p->npwp }}</td>
                  <td>{{ $p->status_ptkp }}</td>
                  <td>{{ $p->email }}</td>
                  <td>{{ $p->no_hp }}</td>
                  <td>{{ $p->tmt_masuk }}</td>
                  <td>{{ $p->tmt_keluar }}</td>
                  <td>{{ Illuminate\Support\Carbon::parse($p->updated_at)->diffForHumans() }}</td>
                  <td>
                    <div class="d-flex justify-content-around flex-row">
                      <div>
                        <a href="{{ route('karyawan-edit', ['id' => $p->id]) }}"
                           class="btn btn-outline-info inlineEdit">
                          Edit
                          <i class="fa-solid fa-pen-to-square"></i>
                        </a>
                      </div>
                    </div>
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="9"
                      class="text-center">Belum ada data</td>
                </tr>
              @endforelse
            @endhasexactroles
          </tbody>
          <tfoot>
            {{ $pegawai->appends($_GET)->links() }}
          </tfoot>
        </table>
      </div>

    </div>
    @if (count($errors) > 0)
      <script type="module">
        const myModal = new bootstrap.Modal(document.getElementById('modalCreateEmployee'), {})
        myModal.show();
      </script>
    @endif
  </div>
@endsection

@once
  @push('scripts')
    <script type="module">
      document.addEventListener("DOMContentLoaded", () => {
        var inputNpwp = document.getElementById("npwp");
        var maskNpwp = new Inputmask("99.999.999.9-999.999");
        maskNpwp.mask(inputNpwp);

        var inputHp = document.getElementById("hp");
        var maskHp = new Inputmask("08999999[9999]");
        maskHp.mask(inputHp);

        // document.querySelectorAll('.inlineCheck').forEach(function(item) {
        //   item.addEventListener('click', function() {
        //     document.querySelectorAll('.inlineEdit').forEach(function(items) {
        //       if (items.style.visibility === 'hidden') {
        //         items.style.visibility = 'visible';
        //       } else {
        //         items.style.visibility = 'hidden';
        //       }
        //     })
        //   });
        // });
      });
    </script>
  @endpush
  @push('modals')
    @hasexactroles('personalia')
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
      <!-- Modal -->
      <div id="modalCreateEmployee"
           class="modal fade"
           tabindex="-1"
           role="dialog"
           aria-labelledby="modalTitleId"
           aria-hidden="true">
        <div class="modal-dialog modal-sm modal-lg"
             role="document">
          <div class="modal-content">
            <form action="{{ route('karyawan-store') }}"
                  method="post">
              @csrf
              <div class="modal-header">
                <h4 id="modalTitleId"
                    class="modal-title">Tambah Data Pegawai
                </h4>
              </div>
              <div class="modal-body row">
                <div class="col-md-12">
                  <div class="mb-3">
                    <label for="nikDataList"
                           class="form-label">NIK</label>
                    <input id="nikDataList"
                           class="form-control @error('nik') is-invalid @enderror"
                           list="datalistOptions"
                           name="nik"
                           placeholder="Masukan NIK">
                    @error('npp')
                      <div class="invalid-feedback">
                        {{ $message }}
                      </div>
                    @enderror
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="mb-3">
                    <label for="nppDataList"
                           class="form-label">NPP</label>
                    <input id="nppDataList"
                           class="form-control @error('npp') is-invalid @enderror"
                           list="datalistOptions"
                           name="npp"
                           placeholder="Masukan Npp">
                    @error('npp')
                      <div class="invalid-feedback">
                        {{ $message }}
                      </div>
                    @enderror
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="mb-3">
                    <label for="npwp"
                           class="form-label">NPWP</label>
                    <input id="npwp"
                           type="text"
                           class="form-control @error('npwp') is-invalid @enderror"
                           name="npwp"
                           placeholder="NPWP">
                    @error('npwp')
                      <div class="invalid-feedback">
                        {{ $message }}
                      </div>
                    @enderror
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="mb-3">
                    <label for="nama"
                           class="form-label">Nama</label>
                    <input id="nama"
                           type="text"
                           class="form-control @error('nama') is-invalid @enderror"
                           name="nama"
                           placeholder="Nama"
                           value="{{ old('npp') }}">
                    @error('nama')
                      <div class="invalid-feedback">
                        {{ $message }}
                      </div>
                    @enderror
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="mb-3">
                    <label for="email"
                           class="form-label">Email</label>
                    <input id="email"
                           type="email"
                           class="form-control @error('email') is-invalid @enderror"
                           name="email"
                           placeholder="email"
                           value="{{ old('email') }}">
                    @error('email')
                      <div class="invalid-feedback">
                        {{ $message }}
                      </div>
                    @enderror
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="mb-3">
                    <label for="hp"
                           class="form-label">No HP</label>
                    <input id="hp"
                           type="phone"
                           class="form-control @error('hp') is-invalid @enderror"
                           name="hp"
                           placeholder="No HP"
                           value="{{ old('hp') }}">
                    @error('hp')
                      <div class="invalid-feedback">
                        {{ $message }}
                      </div>
                    @enderror
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="mb-3">
                    <label for=""
                           class="form-label">Status Pegawai</label>
                    <select id="st_peg"
                            class="form-select @error('st_peg') is-invalid @enderror"
                            name="st_peg">
                      <option value="">Pilih Status Pegawai</option>
                      <option value="KONTRAK">KONTRAK</option>
                      <option value="TETAP">TETAP</option>
                    </select>
                    @error('st_peg')
                      <div class="invalid-feedback">
                        {{ $message }}
                      </div>
                    @enderror
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="mb-3">
                    <label for=""
                           class="form-label">Status PTKP</label>
                    <select id="st_ptkp"
                            class="form-select @error('st_ptkp') is-invalid @enderror"
                            name="st_ptkp">
                      <option value="">Pilih Status PTKP</option>
                      <option value="TK0">TK0</option>
                      <option value="TK1">TK1</option>
                      <option value="TK2">TK2</option>
                      <option value="TK3">TK3</option>
                      <option value="K0">K0</option>
                      <option value="K1">K1</option>
                      <option value="K2">K2</option>
                      <option value="K3">K3</option>
                    </select>
                    @error('st_ptkp')
                      <div class="invalid-feedback">
                        {{ $message }}
                      </div>
                    @enderror
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="mb-3">
                    <label for="masuk"
                           class="form-label">TMT Masuk</label>
                    <input id="masuk"
                           type="date"
                           class="form-control @error('masuk') is-invalid @enderror"
                           name="masuk"
                           value="{{ old('masuk') }}">
                    @error('masuk')
                      <div class="invalid-feedback">
                        {{ $message }}
                      </div>
                    @enderror
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="mb-3">
                    <label for="keluar"
                           class="form-label">TMT Keluar</label>
                    <input id="keluar"
                           type="date"
                           class="form-control @error('keluar') is-invalid @enderror"
                           name="keluar"
                           value="{{ old('keluar') }}">
                    @error('keluar')
                      <div class="invalid-feedback">
                        {{ $message }}
                      </div>
                    @enderror
                  </div>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button"
                        class="btn btn-secondary"
                        data-bs-dismiss="modal"
                        aria-label="Close">
                  Tutup
                </button>
                <button type="submit"
                        class="btn btn-primary">
                  Simpan
                </button>
              </div>
            </form>

          </div>
        </div>
      </div>
    @endhasexactroles

    @hasexactroles('pajak')
      <!-- Modal -->
      <div id="modalEpinImportEmployee"
           class="modal fade"
           tabindex="-1"
           role="dialog"
           aria-labelledby="modalTitleId"
           aria-hidden="true">
        <div class="modal-dialog modal-sm modal-lg"
             role="document">
          <div class="modal-content">
            <form action="{{ route('karyawan-epin-import') }}"
                  method="post"
                  enctype="multipart/form-data">
              @csrf
              <div class="modal-header">
                <h5 class="modal-title">Impor EPin Data Pegawai</h5>
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
    @endhasexactroles
  @endpush
@endonce
