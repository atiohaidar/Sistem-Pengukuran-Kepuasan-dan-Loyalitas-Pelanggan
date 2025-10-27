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
                    <div class="w-16 h-1 bg-gradient-to-r from-blue-500 to-indigo-500 mx-auto rounded-full mb-4"></div>

                    <!-- Progress Indicator -->
                    <div class="flex items-center justify-center space-x-4 mb-6">
                        <div class="flex items-center">
                            <div id="step1-indicator" class="w-8 h-8 rounded-full bg-blue-500 text-white flex items-center justify-center text-sm font-bold">1</div>
                            <span class="ml-2 text-sm text-gray-600">Data Pribadi</span>
                        </div>
                        <div class="w-8 h-0.5 bg-gray-300"></div>
                        <div class="flex items-center">
                            <div id="step2-indicator" class="w-8 h-8 rounded-full bg-gray-300 text-gray-500 flex items-center justify-center text-sm font-bold">2</div>
                            <span class="ml-2 text-sm text-gray-600">Informasi UMKM</span>
                        </div>
                    </div>
                </div>

                <form method="POST" action="{{ route('register') }}" id="registerForm">
                    @csrf

                    <!-- Step 1: Personal Data -->
                    <div id="step1" class="step">
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

                        <div class="flex items-center justify-end mt-6">
                            <button type="button" id="nextBtn" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-lg transition duration-200">
                                Selanjutnya
                            </button>
                        </div>
                    </div>

                    <!-- Step 2: UMKM Information -->
                    <div id="step2" class="step hidden">
                        <div class="p-4 bg-gray-50 rounded-lg border border-gray-100">
                            <h3 class="font-semibold mb-4 text-center">Informasi UMKM</h3>

                            <div class="mb-4">
                                <x-input-label for="nama_usaha" :value="__('Nama Usaha')" />
                                <x-text-input id="nama_usaha" class="block mt-1 w-full" type="text" name="nama_usaha"
                                    :value="old('nama_usaha')" required />
                                <x-input-error :messages="$errors->get('nama_usaha')" class="mt-2" />
                            </div>

                            <div class="mb-4">
                                <x-input-label for="deskripsi" :value="__('Deskripsi (opsional)')" />
                                <textarea id="deskripsi" name="deskripsi"
                                    class="block mt-1 w-full rounded-md border-gray-300"
                                    rows="3">{{ old('deskripsi') }}</textarea>
                                <x-input-error :messages="$errors->get('deskripsi')" class="mt-2" />
                            </div>

                            <div class="mb-4">
                                <x-input-label for="kategori_usaha" :value="__('Kategori Usaha')" />
                                <x-text-input id="kategori_usaha" class="block mt-1 w-full" type="text"
                                    name="kategori_usaha" :value="old('kategori_usaha')" required />
                                <x-input-error :messages="$errors->get('kategori_usaha')" class="mt-2" />
                            </div>

                            <div class="mb-4">
                                <x-input-label for="alamat" :value="__('Alamat (opsional)')" />
                                <textarea id="alamat" name="alamat" class="block mt-1 w-full rounded-md border-gray-300"
                                    rows="2">{{ old('alamat') }}</textarea>
                                <x-input-error :messages="$errors->get('alamat')" class="mt-2" />
                            </div>
                        </div>

                        <div class="flex items-center justify-between mt-6">
                            <button type="button" id="prevBtn" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded-lg transition duration-200">
                                Sebelumnya
                            </button>
                            <div>
                                <a class="underline text-sm text-gray-600 hover:text-gray-900 mr-4" href="{{ route('login') }}">
                                    {{ __('Already registered?') }}
                                </a>
                                <x-primary-button>
                                    {{ __('Register') }}
                                </x-primary-button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        let currentStep = 1;
        const totalSteps = 2;

        const steps = document.querySelectorAll('.step');
        const step1Indicator = document.getElementById('step1-indicator');
        const step2Indicator = document.getElementById('step2-indicator');
        const nextBtn = document.getElementById('nextBtn');
        const prevBtn = document.getElementById('prevBtn');

        function showStep(step) {
            steps.forEach(s => s.classList.add('hidden'));
            document.getElementById('step' + step).classList.remove('hidden');

            // Update indicators
            if (step === 1) {
                step1Indicator.className = 'w-8 h-8 rounded-full bg-blue-500 text-white flex items-center justify-center text-sm font-bold';
                step2Indicator.className = 'w-8 h-8 rounded-full bg-gray-300 text-gray-500 flex items-center justify-center text-sm font-bold';
            } else {
                step1Indicator.className = 'w-8 h-8 rounded-full bg-green-500 text-white flex items-center justify-center text-sm font-bold';
                step2Indicator.className = 'w-8 h-8 rounded-full bg-blue-500 text-white flex items-center justify-center text-sm font-bold';
            }
        }

        function validateStep1() {
            const name = document.getElementById('name').value.trim();
            const email = document.getElementById('email').value.trim();
            const password = document.getElementById('password').value;
            const passwordConfirmation = document.getElementById('password_confirmation').value;

            if (!name || !email || !password || !passwordConfirmation) {
                alert('Harap isi semua field yang diperlukan.');
                return false;
            }

            if (password !== passwordConfirmation) {
                alert('Password dan konfirmasi password tidak cocok.');
                return false;
            }

            // Basic email validation
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email)) {
                alert('Format email tidak valid.');
                return false;
            }

            return true;
        }

        nextBtn.addEventListener('click', () => {
            if (validateStep1()) {
                currentStep = 2;
                showStep(currentStep);
            }
        });

        prevBtn.addEventListener('click', () => {
            currentStep = 1;
            showStep(currentStep);
        });

        // Initialize
        showStep(currentStep);
    </script>
</x-guest-layout>