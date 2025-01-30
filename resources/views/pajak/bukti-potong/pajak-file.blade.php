<x-pajak>

<!-- Card Section -->
<div class="max-w-full px-4 py-10 sm:px-6 lg:px-8 lg:py-14 mx-auto">
  <!-- Card -->
  <div class="bg-white rounded-xl shadow p-4 mb-4 sm:p-7">
    <div class="text-center mb-8">
      <h2 class="text-2xl md:text-3xl font-bold text-gray-800">
        Unggah Dokumen Bukti Potong
      </h2>
      <p class="text-sm text-gray-600">
        
      </p>
    </div>

    <form action="{{ route('pajak-file-upload-bukti-potong') }}"
        method="post"
        enctype="multipart/form-data">
        @csrf

        <div class="overflow-y-auto py-2">
          <label for="buktiPotong"
                 class="sr-only">Pilih file</label>
          <input id="buktiPotong"
                 type="file"
                 name="buktiPotong"
                 class="block w-full rounded-lg border border-gray-200 text-sm shadow-sm file:me-4 file:border-0 file:bg-gray-50 file:px-4 file:py-3 focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:pointer-events-none disabled:opacity-50">
          @error('buktiPotong')
          <p class="text-sm text-red-600 mt-2" id="hs-validation-name-error-helper">
            {{ $message }}
          </p>
          @enderror
        </div>

        <div class="relative py-2">
            <button type="submit" class="w-full py-3 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-none focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none">
                Unggah
            </button>
        </div>
    </form>

  </div>

  <div class="flex flex-col shadow rounded-xl p-4">
    <div class="-m-1.5 overflow-x-auto">
      <div class="p-1.5 min-w-full inline-block align-middle">
        <div class="overflow-hidden">
          <table class="min-w-full divide-y divide-gray-200">
            <thead>
              <tr>
                <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">NO</th>
                <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">NAMA FILE</th>
                <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">STATUS</th>
                <th scope="col" class="px-6 py-3 text-end text-xs font-medium text-gray-500 uppercase">AKSI</th>
              </tr>
            </thead>
            <tbody>
            @forelse($zip_files as $item)
              @php
                  $itemName = explode('/', $item);
                  $folder = Storage::disk('public')->directories('files/shares/pajak/publish/' . $itemName['3']);
                  if (count($folder) > 0) {
                      $folderExplode = explode('/', $folder['0']);
                      $folderTanggal = $folderExplode['5'];
                  }
              @endphp
              <tr class="odd:bg-white even:bg-gray-100 hover:bg-gray-100">
                  <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">
                  {{ $loop->iteration }}
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                  {{ $itemName['3'] }}
                  </td>
                  @if(count($folder) > 0)
                      <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                      {{ $folderTanggal }}
                      </td>
                      <td class="px-6 py-4 whitespace-nowrap text-end text-sm font-medium">
                          <form action="{{ route('pajak-file-unpublish') }}"
                                  method="post">
                              @csrf
                              <input type="hidden"
                                      name="nama_file"
                                      value="{{ $itemName['3'] }}">
                              <input type="hidden"
                                      name="folder_target"
                                      value="{{ $folderTanggal }}">
                              <button type="submit" onclick="return confirm('Unpublish dokumen?')" class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border text-yellow-600 hover:bg-yellow-100 hover:text-yellow-800 focus:outline-none focus:bg-yellow-100 focus:text-yellow-800 active:bg-yellow-100 active:text-yellow-800 disabled:opacity-50 disabled:pointer-events-none">
                                Unpublish
                              </button>
                          </form>
                      </td>
                  @else
                      <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                      Unpublish
                      </td>
                      <td class="px-6 py-4 whitespace-nowrap text-end text-sm font-medium flex flex-col justify-evenly gap-4">
                          <div>
                              <a class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border text-blue-600 hover:bg-blue-100 hover:text-blue-800 focus:outline-none focus:bg-blue-100 focus:text-blue-800 active:bg-blue-100 active:text-blue-800 disabled:opacity-50 disabled:pointer-events-none"
                                href="{{ route('pajak-file-publish', ['filename' => $itemName['3']]) }}">
                              Set
                              </a>
                          </div>
                          <div>
                              <form action="{{ route('pajak-file-remove-bukti-potong') }}"
                                      method="post">
                                  @csrf
                                  <input type="hidden"
                                  name="filename"
                                  value="{{ $itemName['3'] }}"
                                  readonly>
                                  <button type="submit" onclick="return confirm('Hapus file?')" class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border text-red-600 hover:bg-red-100 hover:text-red-800 focus:outline-none focus:bg-red-100 focus:text-red-800 active:bg-red-100 active:text-red-800 disabled:opacity-50 disabled:pointer-events-none">
                                  Hapus
                                  </button>
                              </form>
                          </div>
                      </td>
                  @endif
              </tr>
              @empty
              <tr class="odd:bg-white even:bg-gray-100 hover:bg-gray-100">
                  <td colspan="4" class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">Data belum ada</td>
              </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

</div>



</x-pajak>