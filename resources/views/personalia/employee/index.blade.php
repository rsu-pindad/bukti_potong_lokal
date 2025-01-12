@extends('layout.main')
@section('content')

<div class="container">
  <div class="table-responsive">
    <table class="table table-bordered" id="employee-table">
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
          <th></th>
        </tr>
      </thead>
    </table>
  </div>
</div>

@endsection

@once
@push('scripts')
<script type="module">
  document.addEventListener("DOMContentLoaded", (e) => {
    e.preventDefault();
    const token = "{{ csrf_token() }}";

    let EmployeeTable = new DataTable('#employee-table', {
      processing: true,
      serverSide: true,
      ajax: '{{ route("employee-index") }}',
      columns: [{
          data: 'id',
          name: 'id',
        },
        {
          data: 'npp',
          name: 'npp',
        },
        {
          data: 'nama',
          name: 'nama',
        },
        {
          data: 'status_kepegawaian',
          name: 'status_kepegawaian',
        },
        {
          data: 'nik',
          name: 'nik',
        },
        {
          data: 'npwp',
          name: 'npwp',
        },
        {
          data: 'email',
          name: 'email',
        },
        {
          data: 'no_hp',
          name: 'no_hp',
        },
        {
          data: 'id',
          class: 'actionButton',
          render: function(data, type, row, meta) {
            let htm = $('<a>')
              .attr('class', 'btn btn-info btn-sm edit')
              .attr('data-id', data)
              .attr('href', '#')
              .text('Edit')
              .wrap('<div></div>')
              .parent()
              .html();
            htm += $('<a>')
              .attr('class', 'btn btn-danger btn-sm hapus')
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
      // var row = event.target.closest('tr');
      var dataId = this.getAttribute('data-id');
      var url = `{{ route('karyawan-edit', ':data_id') }}`;
      url = url.replace(':data_id', dataId);
      window.location.href = url;
      // window.location.reload();
    });
    EmployeeTable.on('click', 'td.actionButton a.hapus', async function(e) {
      // var row = event.target.closest('tr');
      e.preventDefault();
      var dataId = this.getAttribute('data-id');
      var url = await `{{ route('employee-destroy', ':data_id') }}`;
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
                  window.location.reload();
                }
              }).catch((error) => {
                // console.log(error);
              });
    });

  });
</script>
@endpush
@endonce