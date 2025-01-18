@extends('layout.main')
@section('content')
  <div class="container">
    <div class="card">
      <div class="card-header d-flex justify-content-between flex-row">
        <h4>Data Pegawai</h4>
        <div class="my-auto">
          <div class="dropdown">
            <button class="btn btn-outline-secondary"
                    type="button"
                    data-bs-toggle="dropdown"
                    aria-expanded="false">
              <i class="fa-solid fa-ellipsis"></i>
            </button>
            <ul class="dropdown-menu">
              @hasexactroles('personalia')
                <li>
                  <a type="button"
                     class="dropdown-item"
                     data-bs-toggle="modal"
                     data-bs-target="#modalImportEmployee">
                    Import Pegawai <i class="fa-solid fa-file-import text-success ml-4"></i>
                  </a>
                </li>
                <li>
                  <hr class="dropdown-divider">
                </li>
                <li>
                  <a class="dropdown-item"
                     href="{{ route('personalia-employee-export') }}">
                    Eksport Pegawai <i class="fa-solid fa-file-export text-success ml-4"></i>
                  </a>
                </li>
                <li>
                  <hr class="dropdown-divider">
                </li>
                <li>
                  <a class="dropdown-item"
                     href="{{ route('personalia-employee-template') }}">
                    Template Import <i class="fa-solid fa-table-cells text-danger ml-4"></i>
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
                     href="{{ route('pajak-karyawan-epin-export') }}">
                    Eksport (Download) <br>Epin Data Pegawai
                    <i class="fa-solid fa-file-export text-success ml-4"></i>
                  </a>
                </li>
                <li>
                  <hr class="dropdown-divider">
                </li>
                <li>
                  <a class="dropdown-item"
                     href="{{ route('pajak-karyawan-epin-template') }}">
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
          <table id="employee-table"
                 class="table-bordered table">
            <thead>
              <tr>
                <th>No</th>
                <th>Npp Lama</th>
                <th>Npp Baru</th>
                <th>Nama</th>
                <th>Status</th>
                <th>NIK</th>
                <th>NPWP</th>
                <th>Email</th>
                <th>No HP</th>
                <th>PTKP</th>
                <th>Masuk</th>
                <th>Keluar</th>
                <th>Update</th>
                <th></th>
              </tr>
            </thead>
          </table>
        </div>
      </div>
    </div>
  </div>
@endsection

@once
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
            <form action="{{ route('personalia-employee-import') }}"
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
                         accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"
                         required>
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
            <form action="{{ route('pajak-karyawan-epin-import') }}"
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
  @push('scripts')
    <script type="module">
      var i = 1;
      document.addEventListener("DOMContentLoaded", (e) => {
        e.preventDefault();
        const token = "{{ csrf_token() }}";
        const apiUrl = "{{ route('personalia-employee-index') }}";
        let EmployeeTable = new DataTable('#employee-table', {
          processing: true,
          serverSide: true,
          paging: true,
          pageLength: 25,
          lengthMenu: [
            [25, 50, 100, -1],
            [25, 50, 100, 'All']
          ],
          ajax: apiUrl,
          columns: [{
              data: null,
              render: function(data, type, row, meta) {
                // return i++;
                return meta.row + meta.settings._iDisplayStart + 1;
              },
              searchable: false,
              orderable: false,
            },
            {
              data: 'npp',
              name: 'npp',
              class: 'text-right',
            },
            {
              data: 'npp_baru',
              name: 'npp_baru',
              class: 'text-right',
            },
            {
              data: 'nama',
              name: 'nama',
              class: 'text-left',
            },
            {
              data: 'status_kepegawaian',
              name: 'status_kepegawaian',
            },
            {
              data: 'nik',
              name: 'nik',
              class: 'text-right',
            },
            {
              data: 'npwp',
              name: 'npwp',
              searchable: false,
              orderable: false,
            },
            {
              data: 'email',
              name: 'email',
              class: 'text-left',
            },
            {
              data: 'no_hp',
              name: 'no_hp',
              orderable: false,
              searchable: false,
            },
            {
              data: 'status_ptkp',
              name: 'status_ptkp',
              orderable: false,
              searchable: false,
            },
            {
              data: 'tmt_masuk',
              name: 'tmt_masuk',
              class: 'text-left',
              searchable: false,
              render: DataTable.render.date(),
            },
            {
              data: 'tmt_keluar',
              name: 'tmt_keluar',
              class: 'text-left',
              searchable: false,
              render: DataTable.render.date(),
            },
            {
              data: 'updated_at',
              name: 'updated_at',
              class: 'text-left',
              searchable: false,
              render: DataTable.render.date(),
            },
            {
              data: 'id',
              class: 'actionButton d-flex',
              orderable: false,
              searchable: false,
              render: function(data, type, row, meta) {
                let htm = $('<a>')
                  .attr('class', 'btn btn-info btn-sm edit mx-2')
                  .attr('data-id', data)
                  .attr('href', '#')
                  .text('Edit')
                  .wrap('<div></div>')
                  .parent()
                  .html();
                htm += $('<a>')
                  .attr('class', 'btn btn-danger btn-sm hapus mx-2')
                  .attr('data-id', data)
                  .attr('href', '#')
                  .text('Hapus')
                  .wrap('<div></div>')
                  .parent()
                  .html();
                return htm;
              }
            },
          ]
        });

        EmployeeTable.on('click', 'td.actionButton a.edit', function(e) {
          var dataId = this.getAttribute('data-id');
          var url = `{{ route('personalia-employee-edit', ':data_id') }}`;
          url = url.replace(':data_id', dataId);
          window.location.href = url;
        });

        EmployeeTable.on('click', 'td.actionButton a.hapus', async function(e) {
          e.preventDefault();
          var dataId = this.getAttribute('data-id');
          var url = await `{{ route('personalia-employee-destroy', ':data_id') }}`;
          url = url.replace(':data_id', dataId);
          fetch(url, {
            method: 'DELETE',
            credentials: "same-origin",
            headers: {
              'Accept': 'application/json',
              'Content-Type': 'application/json',
              "X-Requested-With": "XMLHttpRequest",
              "X-CSRF-TOKEN": token,
            },
          }).then((response) => {
            return response.json();
          }).then((res) => {
            if (res.status === 201) {
              Notiflix.Notify.warning(res.message);
              EmployeeTable.clear();
              EmployeeTable.ajax.reload();
            }else{
              Notiflix.Notify.warning(res.message);
            }
          }).catch((error) => {
            Notiflix.Notify.failure(error);
          });
        });

      });
    </script>
  @endpush
@endonce
