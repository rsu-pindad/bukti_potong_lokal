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
                Pegawai
              </h2>
              <p class="text-sm text-gray-600">
                Edit, Import Epin
              </p>
            </div>

            <div>
              <div class="inline-flex gap-x-2">
                <button id="" type="button" 
                  class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-none focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none" 
                  aria-haspopup="dialog" 
                  aria-expanded="false" 
                  aria-controls="import-modal-epin" 
                  data-hs-overlay="#import-modal-epin"
                  >
                  <svg class="shrink-0 size-3.5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" x2="12" y1="15" y2="3"/></svg>
                  Import
                </button>
                <a href="{{ route('pajak-employee-epin-export') }}" class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-green-600 hover:bg-green-700 text-white shadow-sm focus:outline-none focus:bg-green-50 disabled:opacity-50 disabled:pointer-events-none" aria-haspopup="menu" aria-expanded="false" aria-label="Dropdown">
                  <svg class="shrink-0 size-3.5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" x2="12" y1="15" y2="3"/></svg>
                  Export
                </a>
                <a href="{{ route('pajak-employee-epin-template') }}" class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-orange-300 hover:bg-orange-500 text-white shadow-sm  focus:outline-none focus:bg-orange-50 disabled:opacity-50 disabled:pointer-events-none" aria-haspopup="menu" aria-expanded="false" aria-label="Dropdown">
                  <svg class="shrink-0 size-3.5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-file-down"><path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z"/><path d="M14 2v4a2 2 0 0 0 2 2h4"/><path d="M12 18v-6"/><path d="m9 15 3 3 3-3"/></svg>
                  Template
                </a>
              </div>
            </div>
          </div>
          <!-- End Header -->

          <!-- Table -->
          <table class="min-w-full divide-y divide-gray-200" id="employee-table">
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
                      NPP
                    </span>
                  </div>
                </th>

                <th scope="col" class="px-6 py-3 text-start">
                  <div class="flex items-center gap-x-2">
                    <span class="text-xs font-semibold uppercase tracking-wide text-gray-800">
                      NAMA
                    </span>
                  </div>
                </th>

                <th scope="col" class="px-6 py-3 text-start">
                  <div class="flex items-center gap-x-2">
                    <span class="text-xs font-semibold uppercase tracking-wide text-gray-800">
                      STATUS
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
                      NPWP
                    </span>
                  </div>
                </th>

                <th scope="col" class="px-6 py-3 text-start">
                  <div class="flex items-center gap-x-2">
                    <span class="text-xs font-semibold uppercase tracking-wide text-gray-800">
                      EMAIL
                    </span>
                  </div>
                </th>

                <th scope="col" class="px-6 py-3 text-start">
                  <div class="flex items-center gap-x-2">
                    <span class="text-xs font-semibold uppercase tracking-wide text-gray-800">
                      NO HP
                    </span>
                  </div>
                </th>

                <th scope="col" class="px-6 py-3 text-start">
                  <div class="flex items-center gap-x-2">
                    <span class="text-xs font-semibold uppercase tracking-wide text-gray-800">
                      PTKP
                    </span>
                  </div>
                </th>

                <th scope="col" class="px-6 py-3 text-start">
                  <div class="flex items-center gap-x-2">
                    <span class="text-xs font-semibold uppercase tracking-wide text-gray-800">
                      EPIN
                    </span>
                  </div>
                </th>

                <th scope="col" class="px-6 py-3 text-start">
                  <div class="flex items-center gap-x-2">
                    <span class="text-xs font-semibold uppercase tracking-wide text-gray-800">
                      MASUK
                    </span>
                  </div>
                </th>

                <th scope="col" class="px-6 py-3 text-start">
                  <div class="flex items-center gap-x-2">
                    <span class="text-xs font-semibold uppercase tracking-wide text-gray-800">
                      KELUAR
                    </span>
                  </div>
                </th>

                <th scope="col" class="px-6 py-3 text-start">
                  <div class="flex items-center gap-x-2">
                    <span class="text-xs font-semibold uppercase tracking-wide text-gray-800">
                      UPDATE
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

<x-pajak.import-modal-epin/>

<script type="module">
  var i = 1;
  document.addEventListener("DOMContentLoaded", (e) => {
    e.preventDefault();
    const token = "{{ csrf_token() }}";
    const apiUrl = "{{ route('pajak-employee-index') }}";
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
          class: 'actionButton flex flex-col justify-evenly gap-4',
          orderable: false,
          searchable: false,
          render: function(data, type, row, meta) {
            return $('<a>')
              .attr('class', "epin py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border text-gray-600 hover:bg-gray-100 hover:text-gray-800 focus:outline-none focus:bg-gray-100 focus:text-gray-800 active:bg-gray-100 active:text-gray-800 disabled:opacity-50 disabled:pointer-events-none")
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

</x-pajak>