<div id="import-modal-pegawai"
     class="hs-overlay hs-overlay-backdrop-open:bg-blue-950/90 pointer-events-none fixed start-0 top-0 z-[80] hidden size-full overflow-y-auto overflow-x-hidden"
     role="dialog"
     tabindex="-1"
     aria-labelledby="import-modal-pegawai-label">
  <div
       class="hs-overlay-animation-target m-3 flex min-h-[calc(100%-3.5rem)] scale-95 items-center opacity-0 transition-all duration-200 ease-in-out hs-overlay-open:scale-100 hs-overlay-open:opacity-100 sm:mx-auto sm:w-full sm:max-w-lg">
    <div class="pointer-events-auto flex w-full flex-col rounded-xl border bg-white shadow-sm">
      <form action="{{ route('personalia-employee-import') }}"
            method="post"
            enctype="multipart/form-data">
        @csrf
        <div class="flex items-center justify-between border-b px-4 py-3">
          <h3 id="import-modal-pegawai-label"
              class="font-bold text-gray-800">
            Import Pegawai
          </h3>
          <button type="button"
                  class="inline-flex size-8 items-center justify-center gap-x-2 rounded-full border border-transparent bg-gray-100 text-gray-800 hover:bg-gray-200 focus:bg-gray-200 focus:outline-none disabled:pointer-events-none disabled:opacity-50"
                  aria-label="Close"
                  data-hs-overlay="#import-modal-pegawai">
            <span class="sr-only">Close</span>
            <svg class="size-4 shrink-0"
                 xmlns="http://www.w3.org/2000/svg"
                 width="24"
                 height="24"
                 viewBox="0 0 24 24"
                 fill="none"
                 stroke="currentColor"
                 stroke-width="2"
                 stroke-linecap="round"
                 stroke-linejoin="round">
              <path d="M18 6 6 18"></path>
              <path d="m6 6 12 12"></path>
            </svg>
          </button>
        </div>
        <div class="overflow-y-auto p-4">

          <label for="filePegawai"
                 class="sr-only">Pilih file</label>
          <input id="filePegawai"
                 type="file"
                 name="filePegawai"
                 class="block w-full rounded-lg border border-gray-200 text-sm shadow-sm file:me-4 file:border-0 file:bg-gray-50 file:px-4 file:py-3 focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:pointer-events-none disabled:opacity-50">
          @error('filePegawai')
          <p class="text-sm text-red-600 mt-2" id="hs-validation-name-error-helper">
            {{ $message }}
          </p>
          @enderror
        </div>
        <div class="flex items-center justify-end gap-x-2 border-t px-4 py-3">
          <button type="button"
                  class="inline-flex items-center gap-x-2 rounded-lg border border-gray-200 bg-white px-3 py-2 text-sm font-medium text-gray-800 shadow-sm hover:bg-gray-50 focus:bg-gray-50 focus:outline-none disabled:pointer-events-none disabled:opacity-50"
                  data-hs-overlay="#import-modal-pegawai">
            Tutup
          </button>
          <button type="submit"
                  class="inline-flex items-center gap-x-2 rounded-lg border border-transparent bg-blue-600 px-3 py-2 text-sm font-medium text-white hover:bg-blue-700 focus:bg-blue-700 focus:outline-none disabled:pointer-events-none disabled:opacity-50">
            Import
          </button>
        </div>
      </form>
    </div>
  </div>
</div>
