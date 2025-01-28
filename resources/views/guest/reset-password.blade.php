<x-guest>

<div class="mt-7 bg-white border border-gray-200 rounded-xl shadow-sm">
  <div class="p-4 sm:p-7">
    <div class="text-center">
      <h1 class="block text-2xl font-bold text-gray-800">Lupa password ?</h1>
      <p class="mt-2 text-sm text-gray-600">
        masukan npp, tautan ganti password dikirim via whatsapp
      </p>
    </div>

    <div class="mt-5">
      <!-- Form -->
      <form action="{{ route('auth-send-reset-link') }}"
      method="post">
        @csrf
        <div class="grid gap-y-4">
          <!-- Form Group -->
          <div>
            <label for="npp" class="block text-sm mb-2">NPP</label>
            <div class="relative">
              <input type="text" 
              id="npp" 
              name="npp" 
              value="{{ old('npp') }}"
              placeholder="masukan npp" 
              class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none" aria-describedby="npp-error">
            </div>
            @error('npp')
                <p class="hidden text-xs text-red-600 mt-2" id="npp-error">
                    {{ $message }}
                </p>
            @enderror  
            </div>
          <!-- End Form Group -->

          <button type="submit" class="w-full py-3 px-4 inline-flex justify-center items-center gap-x-2 text-md font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-none focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none">
            reset password
          </button>
        </div>
      </form>
      <!-- End Form -->
    </div>

    <div class="mt-3">
    <a class="inline-flex items-center gap-x-1 text-sm text-blue-600 decoration-2 hover:underline focus:outline-none focus:underline font-medium dark:text-blue-500" href="{{ route('auth-login') }}">
                masuk
                <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
            </a>
    </div>
  </div>
</div>

</x-guest>