<x-guest>
    <div class="bg-gray-50 border border-gray-200 rounded-xl shadow-sm">
        <div class="py-6 px-10">
            <div class="text-center text-balance">
                <h1 class="block text-3xl font-bold font-mono text-gray-800">PMU Bukti Potong</h1>
            </div>
            <!-- Form -->
            <form class="mt-8" action="{{ route('auth-authenticate') }}"
            method="post">
            @csrf
                <div class="grid gap-y-4">
                <!-- Form Group -->
                <div>
                    <label for="username" class="block text-md mb-2">Username</label>
                    <div class="relative">
                        <input type="text" name="username" class="py-3 px-4 block w-full border-gray-200 rounded-lg text-md focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none" placeholder="masukan username" aria-describedby="username-error">
                    </div>
                    @error('username')
                    <p class="text-xs text-red-600 mt-2">
                        {{ $message }}
                    </p>
                    @enderror
                </div>
                <!-- End Form Group -->

                <!-- Form Group -->
                <div>
                    <div class="flex justify-between items-center">
                    <label for="password" class="block text-md mb-2">Password</label>
                    </div>
                    <div class="relative">
                    <input type="password"  name="password" class="py-3 px-4 block w-full border-gray-200 rounded-lg text-md focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none" placeholder="masukan password" aria-describedby="password-error">
                    </div>
                    @error('password')
                    <p class="text-xs text-red-600 mt-2">
                        {{ $message }}
                    </p>
                    @enderror
                </div>
                <!-- End Form Group -->

                <button type="submit" class="w-full py-3 px-4 inline-flex justify-center items-center gap-x-2 text-md font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-none focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none">
                    Masuk
                </button>
                </div>
            </form>
            <!-- End Form -->
            
            <div class="my-2">
                <div class="py-3 flex items-center text-xs text-gray-400 uppercase before:flex-1 before:border-t before:border-gray-200 before:me-6 after:flex-1 after:border-t after:border-gray-200 after:ms-6">
                    atau
                </div>
            </div>

            <div class="mt-2 sm:mt-4 flex flex-row gap-x-4 justify-between">
                <a class="inline-flex items-center gap-x-1 text-md text-blue-600 decoration-2 hover:underline focus:outline-none focus:underline font-medium dark:text-blue-500" href="{{ route('cari-index') }}">
                Daftar
                </a>

                <a class="inline-flex items-center gap-x-1 text-md text-blue-600 decoration-2 hover:underline focus:outline-none focus:underline font-medium dark:text-blue-500" href="{{ route('auth-forgot-password') }}">
                Lupa password
                </a>
            </div>

        </div>
    </div>
</x-guest>