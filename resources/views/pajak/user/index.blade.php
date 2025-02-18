@extends('layout.main')
@section('content')
  <div class="container">
    <div class="card">
      <div class="card-header d-flex justify-content-between flex-row">
        <h4>Data User</h4>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table id="user-table"
                 class="table-bordered table">
            <thead>
              <tr>
                <th>No</th>
                <th>Username</th>
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
        const apiUrl = "{{ route('pajak-user-index') }}";
        let EmployeeTable = new DataTable('#user-table', {
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
              data: 'username',
              name: 'username',
              class: 'text-right',
            },
            {
              data: 'id',
              class: 'actionButton d-flex',
              orderable: false,
              searchable: false,
              render: function(data, type, row, meta) {
                return $('<a>')
                  .attr('class', 'btn btn-info btn-sm userAssign mx-2')
                  .attr('data-id', data)
                  .attr('href', '#')
                  .text('User')
                  .wrap('<div></div>')
                  .parent()
                  .html();
              }
            },
          ]
        });

        EmployeeTable.on('click', 'td.actionButton a.userAssign', function(e) {
          var dataId = this.getAttribute('data-id');
          var url = `{{ route('pajak-user-edit', ':data_id') }}`;
          url = url.replace(':data_id', dataId);
          window.location.href = url;
        });

      });
    </script>
  @endpush
@endonce
