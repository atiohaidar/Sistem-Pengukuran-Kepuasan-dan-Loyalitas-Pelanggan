<x-guest-layout title="Register">
    <div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md mx-auto">
            <div class="bg-white shadow-xl rounded-xl p-8 border border-gray-100">
                <div class="text-center mb-6">
                    <div
                        class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-full mb-4 shadow-lg">
                        <i class="fas fa-user-plus text-white text-2xl"></i>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-900 mb-2">Register</h2>
                    <div class="w-16 h-1 bg-gradient-to-r from-blue-500 to-indigo-500 mx-auto rounded-full"></div>
                </div>

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <!-- Name -->
                    <div class="mb-4">
                        <x-input-label for="name" :value="__('Name')" />
                        <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')"
                            required autofocus autocomplete="name" />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <!-- Email Address -->
                    <div class="mb-4">
                        <x-input-label for="email" :value="__('Email')" />
                        <x-text-input id="email" class="block mt-1 w-full" type="email" name="email"
                            :value="old('email')" required autocomplete="username" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Password -->
                    <div class="mb-4">
                        <x-input-label for="password" :value="__('Password')" />

                        <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
                            autocomplete="new-password" />

                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <!-- Confirm Password -->
                    <div class="mb-4">
                        <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

                        <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password"
                            name="password_confirmation" required autocomplete="new-password" />

                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                    </div>

                    <div class="flex items-center justify-end">
                        <div class="me-auto text-sm text-gray-600">
                            <label class="inline-flex items-center">
                                <input id="is_umkm" name="is_umkm" type="checkbox"
                                    class="rounded text-indigo-600 shadow-sm focus:ring-indigo-500" />
                                <span class="ms-2">Daftarkan sebagai akun UMKM</span>
                            </label>
                        </div>

                    </div>

                    <div id="umkm_fields" class="mt-4 p-4 bg-gray-50 rounded-lg border border-gray-100 hidden">
                        <h3 class="font-semibold mb-2">Informasi UMKM</h3>

                        <div class="mb-3">
                            <x-input-label for="nama_usaha" :value="__('Nama Usaha')" />
                            <x-text-input id="nama_usaha" class="block mt-1 w-full" type="text" name="nama_usaha"
                                :value="old('nama_usaha')" />
                            <x-input-error :messages="$errors->get('nama_usaha')" class="mt-2" />
                        </div>

                        <div class="mb-3">
                            <x-input-label for="deskripsi" :value="__('Deskripsi (opsional)')" />
                            <textarea id="deskripsi" name="deskripsi"
                                class="block mt-1 w-full rounded-md border-gray-300"
                                rows="3">{{ old('deskripsi') }}</textarea>
                            <x-input-error :messages="$errors->get('deskripsi')" class="mt-2" />
                        </div>

                        <div class="mb-3">
                            <x-input-label for="kategori_usaha" :value="__('Kategori Usaha')" />
                            <x-text-input id="kategori_usaha" class="block mt-1 w-full" type="text"
                                name="kategori_usaha" :value="old('kategori_usaha')" />
                            <x-input-error :messages="$errors->get('kategori_usaha')" class="mt-2" />
                        </div>

                        <div class="mb-3">
                            <x-input-label for="alamat" :value="__('Alamat (opsional)')" />
                            <textarea id="alamat" name="alamat" class="block mt-1 w-full rounded-md border-gray-300"
                                rows="2">{{ old('alamat') }}</textarea>
                            <x-input-error :messages="$errors->get('alamat')" class="mt-2" />
                        </div>
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                            href="{{ route('login') }}">
                            {{ __('Already registered?') }}
                        </a>

                        <x-primary-button class="ms-4">
                            {{ __('Register') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        const isUmkm = document.getElementById('is_umkm');
        const umkmFields = document.getElementById('umkm_fields');
        isUmkm && isUmkm.addEventListener('change', (e) => {
            if (e.target.checked) umkmFields.classList.remove('hidden'); else umkmFields.classList.add('hidden');
        });
        // on load, if checkbox pre-checked (old input), show fields
        document.addEventListener('DOMContentLoaded', () => {
            if (isUmkm && (isUmkm.checked || '{{ old('is_umkm') }}' === 'on')) umkmFields.classList.remove('hidden');
        });
    </script>
</x-guest-layout>