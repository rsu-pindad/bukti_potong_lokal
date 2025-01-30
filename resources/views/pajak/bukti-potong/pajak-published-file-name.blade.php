<x-pajak>
<!-- Card Section -->
<div class="max-w-2xl px-4 py-10 sm:px-6 lg:px-8 lg:py-14 mx-auto">

  <div class="flex flex-col shadow rounded-xl p-4">
    <div class="-m-1.5 overflow-x-auto">
      <div class="p-1.5 min-w-full inline-block align-middle">
        <div class="overflow-hidden">
          <table class="min-w-full divide-y divide-gray-200">
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
            <tbody>
            @forelse($files as $file)
              <tr class="odd:bg-white even:bg-gray-100 hover:bg-gray-100">
                  <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">
                  {{ $files->perPage() * ($files->currentPage() - 1) + $loop->iteration }}
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                  {{ $file->file_path }}
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                  {{ $file->file_name }}
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                  {{ $file->file_identitas_npwp }}
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                  {{ $file->file_identitas_nik }}
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                  {{ $file->file_identitas_nama }}
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                    <a target="_blank"
                      href="{{ route('pajak-published-cari-file-pajak', ['folder' => $file->file_path, 'filename' => $file->file_name]) }}"
                      class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border text-blue-600 hover:bg-blue-100 hover:text-blue-800 focus:outline-none focus:bg-blue-100 focus:text-blue-800 active:bg-blue-100 active:text-blue-800 disabled:opacity-50 disabled:pointer-events-none">
                      Lihat
                      <!-- <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg> -->
                    </a>
                  </td>
              </tr>
              @empty
              <tr class="odd:bg-white even:bg-gray-100 hover:bg-gray-100">
                  <td colspan="8" class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">Data belum ada</td>
              </tr>
              @endforelse
            </tbody>
            <tfoot>
            {{ $files->appends($_GET)->links() }}
            </tfoot>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

</x-pajak>