@extends('layout.main')
@section('content')
  <div class="container">
    <div class="card">
      <div class="card-header d-flex justify-content-between flex-row">
        <h4>Bukti Potong Pegawai</h4>
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
                  <a class="dropdown-item"
                     href="{{ route('pajak-cari-link-export') }}">
                    Eksport Link Bupot
                    <i class="fa-solid fa-file-export text-success ml-4"></i>
                  </a>
                </li>
              @endhasexactroles
            </ul>
          </div>
        </div>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table id="bupot-table"
                 class="table-bordered table">
            <thead>
              <tr>
                <th>No</th>
                <th>Folder</th>
                <th>Nama File</th>
                <th>NPWP</th>
                <th>NIK</th>
                <th>Nama Pegawai</th>
                <th>Url Keluar</th>
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
  @push('scripts')
    <script type="module">
      var i = 1;
      document.addEventListener("DOMContentLoaded", (e) => {
        e.preventDefault();
        const token = "{{ csrf_token() }}";
        const apiUrl = "{{ route('pajak-cari-index') }}";
        let BupotTable = new DataTable('#bupot-table', {
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
              data: 'file_path',
              name: 'file_path',
              class: 'text-right',
            },
            {
              data: 'file_name',
              name: 'file_name',
              class: 'text-right',
            },
            {
              data: 'file_identitas_npwp',
              name: 'file_identitas_npwp',
              class: 'text-left',
            },
            {
              data: 'file_identitas_nik',
              name: 'file_identitas_nik',
              class: 'text-right',
            },
            {
              data: 'file_identitas_nama',
              name: 'file_identitas_nama',
            },
            {
              data: 'short_link',
              name: 'short_link',
            },
            {
              data: 'id',
              class: 'actionButton d-flex',
              orderable: false,
              searchable: false,
              render: function(data, type, row, meta) {
                var url = '{{ route('pajak-cari-file-bupot', ':slug') }}';
                url = url.replace(':slug', data);

                return $('<a>')
                  .attr('class', 'btn btn-info lihatBupot mx-2')
                  .attr('href', url)
                  .attr('target', '_blank')
                  .text('lihat')
                  .wrap('<div></div>')
                  .parent()
                  .html();
              }
            },
          ]
        });

      });
    </script>
  @endpush
@endonce
