<x-pajak>
<!-- Card Section -->
<div class="max-w-full px-4 py-10 sm:px-6 lg:px-8 lg:py-14 mx-auto">

  <div class="flex flex-col shadow rounded-xl p-4">
    <div class="-m-1.5 overflow-x-auto">
      <div class="p-1.5 min-w-full inline-block align-middle">
        <div class="overflow-hidden">
          <table class="min-w-full divide-y divide-gray-200">
            <thead>
              <tr>
                <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">NO</th>
                <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">NAMA FILE</th>
                <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">NAMA FOLDER</th>
                <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">STATUS</th>
                <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">JUMLAH FILE</th>
                <th scope="col" class="px-6 py-3 text-end text-xs font-medium text-gray-500 uppercase">AKSI</th>
              </tr>
            </thead>
            <tbody>
            @forelse($published as $publish)
              <tr class="odd:bg-white even:bg-gray-100 hover:bg-gray-100">
                  <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">
                  {{ $published->perPage() * ($published->currentPage() - 1) + $loop->iteration }}
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                  {{ $publish->folder_publish }}
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                  {{ $publish->folder_name }}
                  </td>
                  @if($publish->folder_status == 0)
                      <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                      Belum Dicari
                      </td>
                      <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                      {{ $publish->folder_jumlah_final + $publish->folder_jumlah_tidak_final + $publish->folder_jumlah_aone }}
                      </td>
                      <td class="px-6 py-4 whitespace-nowrap text-end text-sm font-medium">
                          <form action="{{ route('pajak-published-file-cari-data-pajak') }}"
                                  method="post">
                              @csrf
                              <input type="hidden"
                                      value="{{ $publish->id }}"
                                      name="fileId">
                              <input type="hidden"
                                      name="isReset"
                                      value="false">
                              <button type="submit" class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border text-green-600 hover:bg-green-100 hover:text-green-800 focus:outline-none focus:bg-green-100 focus:text-green-800 active:bg-green-100 active:text-green-800 disabled:opacity-50 disabled:pointer-events-none">
                                  Cari
                              </button>
                          </form>
                      </td>
                  @else
                      <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                      Sudah Dicari
                      </td>
                      
                      <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                      {{ $publish->folder_jumlah_final + $publish->folder_jumlah_tidak_final + $publish->folder_jumlah_aone }}
                      </td>
                      <td colspan="2" class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                          <form action="{{ route('pajak-published-file-data-pajak') }}"
                              method="get">
                              <div>
                                  <input type="hidden"
                                  name="file"
                                  value="{{ $publish->id }}"
                                  readonly>
                                  <button type="submit"
                                    class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border text-blue-600 hover:bg-blue-100 hover:text-blue-800 focus:outline-none focus:bg-blue-100 focus:text-blue-800 active:bg-blue-100 active:text-blue-800 disabled:opacity-50 disabled:pointer-events-none">
                                    <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-eye"><path d="M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 1 0 0 1 0 .696 10.75 10.75 0 0 1-19.876 0"/><circle cx="12" cy="12" r="3"/></svg>
                                  </button>
                              </div>
                          </form>
                      </td>
                  @endif
              </tr>
              @empty
              <tr class="odd:bg-white even:bg-gray-100 hover:bg-gray-100">
                  <td colspan="7" class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">Data belum ada</td>
              </tr>
              @endforelse
            </tbody>
            <tfoot>
              {{ $published->links() }}
            </tfoot>
          </table>
        </div>
      </div>
    </div>
  </div>

</div>

</x-pajak>