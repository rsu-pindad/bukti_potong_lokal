<x-pajak>

<!-- Table Section -->
<div class="max-w-[85rem] px-4 py-4 sm:px-4 lg:px-4 lg:py-4 mx-auto">
  <!-- Card -->
  <div class="flex flex-col">
    <div class="-m-1.5 overflow-x-auto">
      <div class="p-1.5 min-w-full inline-block align-middle">
        <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">
          <!-- Header -->
          <div class="px-6 py-4 grid gap-3 md:flex md:justify-between md:items-center border-b border-gray-200">
            <div>
              <h2 class="text-xl font-semibold text-gray-800">
                Bukti Potong
              </h2>
              <p class="text-sm text-gray-600">
                Cari Bukti Potong Karyawan
              </p>
            </div>

          </div>
          <!-- End Header -->

          <!-- Table -->
          <table class="min-w-full divide-y divide-gray-200" id="bupot-table">
            <thead class="bg-gray-50">
              <tr>
                <!-- <th scope="col" class="ps-6 py-3 text-start">
                  <label for="hs-at-with-checkboxes-main" class="flex">
                    <input type="checkbox" class="shrink-0 border-gray-300 rounded text-blue-600 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none" id="hs-at-with-checkboxes-main">
                    <span class="sr-only">Checkbox</span>
                  </label>
                </th> -->

                <th scope="col" class="ps-6 lg:ps-3 xl:ps-0 pe-6 py-3 text-start">
                  <div class="flex items-center gap-x-2">
                    <span class="text-xs font-semibold uppercase tracking-wide text-gray-800">
                      NO
                    </span>
                  </div>
                </th>

                <th scope="col" class="px-6 py-3 text-start">
                  <div class="flex items-center gap-x-2">
                    <span class="text-xs font-semibold uppercase tracking-wide text-gray-800">
                      FOLDER
                    </span>
                  </div>
                </th>

                <th scope="col" class="px-6 py-3 text-start">
                  <div class="flex items-center gap-x-2">
                    <span class="text-xs font-semibold uppercase tracking-wide text-gray-800">
                      FILE
                    </span>
                  </div>
                </th>

                <th scope="col" class="px-6 py-3 text-start">
                  <div class="flex items-center gap-x-2">
                    <span class="text-xs font-semibold uppercase tracking-wide text-gray-800">
                      NPWP
                    </span>
                  </div>
                </th>

                <th scope="col" class="px-6 py-3 text-start">
                  <div class="flex items-center gap-x-2">
                    <span class="text-xs font-semibold uppercase tracking-wide text-gray-800">
                      NIK
                    </span>
                  </div>
                </th>

                <th scope="col" class="px-6 py-3 text-start">
                  <div class="flex items-center gap-x-2">
                    <span class="text-xs font-semibold uppercase tracking-wide text-gray-800">
                      NAMA PEGAWAI
                    </span>
                  </div>
                </th>

                <th scope="col" class="px-6 py-3 text-end"></th>
              </tr>
            </thead>
          </table>
          <!-- End Table -->

        </div>
      </div>
    </div>
  </div>
  <!-- End Card -->
</div>
<!-- End Table Section -->

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
            data: 'id',
            class: 'actionButton flex',
            orderable: false,
            searchable: false,
            render: function(data, type, row, meta) {
            var url = '{{ route('pajak-cari-file-bupot', ':slug') }}';
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