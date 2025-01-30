<x-pajak>
<!-- Card Section -->
<div class="max-w-full px-4 py-10 sm:px-6 lg:px-8 lg:py-14 mx-auto">

  <div class="flex flex-col shadow rounded-xl p-4">
    <div class="-m-1.5 overflow-x-auto">
      <div class="p-1.5 min-w-full inline-block align-middle">
        <div class="overflow-hidden">
          <table id="published-file-table" class="min-w-full divide-y divide-gray-200">
            <thead>
              <tr>
                <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">NO</th>
                <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">FOLDER</th>
                <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">FILE</th>
                <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">NPWP</th>
                <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">NIK</th>
                <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">NAMA</th>
                <th scope="col" class="px-6 py-3 text-end text-xs font-medium text-gray-500 uppercase">AKSI</th>
              </tr>
            </thead>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<script type="module">
    var i = 1;
    document.addEventListener("DOMContentLoaded", (e) => {
    e.preventDefault();
    const file = "{{ request()->get('file') }}";
    console.log(file);
    const token = "{{ csrf_token() }}";
    var apiUrl = "{{ route('pajak-published-file-data-pajak', ':file') }}";
    apiUrl = apiUrl.replace(':file', file);
    console.log(apiUrl);
    
    let BupotTable = new DataTable('#published-file-table', {
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
            data: 'id',
            class: 'actionButton flex',
            orderable: false,
            searchable: false,
            render: function(data, type, row, meta) {
            var url = "{{ route('pajak-cari-file-bupot', ':slug') }}";
            url = url.replace(':slug', data);

            return $('<a>')
                .attr('class', 'lihatBupot py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border text-blue-600 hover:bg-blue-100 hover:text-blue-800 focus:outline-none focus:bg-blue-100 focus:text-blue-800 active:bg-blue-100 active:text-blue-800 disabled:opacity-50 disabled:pointer-events-none')
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

</x-pajak>