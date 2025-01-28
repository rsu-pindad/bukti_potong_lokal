<x-guest>

<div class="mt-7 bg-white border border-gray-200 rounded-xl shadow-sm">
  <div class="p-4 sm:p-7">
    <div class="text-center">
      <h1 class="block text-2xl font-bold text-gray-800">Ganti Password</h1>
    </div>

    <div class="mt-5">
      <!-- Form -->
      <form action="{{ route('auth-submit-reset-password', $token) }}"
      method="post">
        @csrf
        <div class="grid gap-y-4">
          <!-- Form Group -->
          <div>
            <label for="password" class="block text-sm mb-2">Password : min.6 karakter</label>
            <div class="relative">
              <input type="password" 
              id="password" 
              name="password" 
              placeholder="masukan password" 
              class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none" aria-describedby="password-error">
            </div>
            @error('password')
                <p class="hidden text-xs text-red-600 mt-2" id="password-error">
                    {{ $message }}
                </p>
            @enderror  
            </div>
          <div>
            <label for="password_confirmation" class="block text-sm mb-2">Ulangi Password : sama dengan Password</label>
            <div class="relative">
              <input type="password" 
              id="password_confirmation" 
              name="password_confirmation" 
              placeholder="ulangi password" 
              class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none" aria-describedby="password_confirmation-error">
            </div>
            @error('password_confirmation')
                <p class="hidden text-xs text-red-600 mt-2" id="password_confirmation-error">
                    {{ $message }}
                </p>
            @enderror  
            </div>
          <!-- End Form Group -->

          <button type="submit" class="w-full py-3 px-4 inline-flex justify-center items-center gap-x-2 text-md font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-none focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none">
            ganti password
          </button>
        </div>
      </form>
      <!-- End Form -->
    </div>

  </div>
</div>

</x-guest>