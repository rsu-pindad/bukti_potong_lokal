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
              @hasexactroles('pajak')
                <li>
                  <a type="button"
                     class="dropdown-item"
                     data-bs-toggle="modal"
                     data-bs-target="#modalEpinImportEmployee">
                    Import Epin Pegawai <i class="fa-solid fa-file-import text-success ml-4"></i>
                  </a>
                </li>
                <li>
                  <hr class="dropdown-divider">
                </li>
                <li>
                  <a class="dropdown-item"
                     href="{{ route('pajak-employee-epin-export') }}">
                    Eksport Epin Pegawai<i class="fa-solid fa-file-export text-success ml-4"></i>
                  </a>
                </li>
                <li>
                  <hr class="dropdown-divider">
                </li>
                <li>
                  <a class="dropdown-item"
                     href="{{ route('pajak-employee-epin-template') }}">
                    Template EPin Import <i class="fa-solid fa-table-cells text-danger ml-4"></i>
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
                <th>Npp</th>
                <th>Nama</th>
                <th>Status</th>
                <th>NIK</th>
                <th>NPWP</th>
                <th>Email</th>
                <th>No HP</th>
                <th>PTKP</th>
                <th>Epin</th>
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
            <form action="{{ route('pajak-employee-epin-import') }}"
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
        const apiUrl = '{{ route('pajak-employee-index') }}';
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
              data: 'epin',
              name: 'epin',
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
                return $('<a>')
                  .attr('class', 'btn btn-secondary btn-sm epin mx-2')
                  .attr('data-id', data)
                  .attr('href', '#')
                  .text('Epin')
                  .wrap('<div></div>')
                  .parent()
                  .html();
              }
            },
          ]
        });

        EmployeeTable.on('click', 'td.actionButton a.epin', function(e) {
          var dataId = this.getAttribute('data-id');
          var url = `{{ route('pajak-employee-epin-edit', ':data_id') }}`;
          url = url.replace(':data_id', dataId);
          window.location.href = url;
        });

      });
    </script>
  @endpush
@endonce
