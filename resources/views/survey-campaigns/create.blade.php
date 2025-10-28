<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Buat Kampanye Survei Baru') }}
            </h2>
            <a href="{{ route('survey-campaigns.index') }}" class="text-gray-600 hover:text-gray-900">
                <i class="fas fa-arrow-left mr-2"></i>Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form action="{{ route('survey-campaigns.store') }}" method="POST" id="campaignForm">
                        @csrf

                        {{-- Jenis Survei --}}
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Jenis Survei <span class="text-red-500">*</span>
                            </label>
                            <div class="grid grid-cols-2 gap-4">
                                <label class="type-option relative flex items-center p-4 border-2 rounded-lg cursor-pointer transition hover:border-indigo-500 border-gray-300">
                                    <input type="radio" 
                                           name="type" 
                                           value="produk" 
                                           class="sr-only type-radio"
                                           {{ old('type') === 'produk' ? 'checked' : '' }}
                                           required>
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 bg-purple-100 rounded-full p-3">
                                            <i class="fas fa-box text-purple-600 text-xl"></i>
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-sm font-medium text-gray-900">Produk</p>
                                            <p class="text-xs text-gray-500">Survei kepuasan produk/layanan</p>
                                        </div>
                                    </div>
                                </label>

                                <label class="type-option relative flex items-center p-4 border-2 rounded-lg cursor-pointer transition hover:border-indigo-500 border-gray-300">
                                    <input type="radio" 
                                           name="type" 
                                           value="pelatihan" 
                                           class="sr-only type-radio"
                                           {{ old('type') === 'pelatihan' ? 'checked' : '' }}
                                           required>
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 bg-indigo-100 rounded-full p-3">
                                            <i class="fas fa-graduation-cap text-indigo-600 text-xl"></i>
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-sm font-medium text-gray-900">Pelatihan</p>
                                            <p class="text-xs text-gray-500">Survei kepuasan pelatihan</p>
                                        </div>
                                    </div>
                                </label>
                            </div>
                            @error('type')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Nama Kegiatan --}}
                        <div class="mb-6">
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                                Nama Kegiatan <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   name="name" 
                                   id="name"
                                   value="{{ old('name') }}"
                                   class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-indigo-500 focus:border-indigo-500 @error('name') border-red-500 @enderror" 
                                   placeholder="Contoh: Pelatihan Digital Marketing Batch 2"
                                   maxlength="255"
                                   required>
                            <p class="text-xs text-gray-500 mt-1">Maksimal 255 karakter</p>
                            @error('name')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Slug URL --}}
                        <div class="mb-6">
                            <label for="slug" class="block text-sm font-medium text-gray-700 mb-2">
                                Slug URL <span class="text-red-500">*</span>
                            </label>
                            <div class="flex items-center gap-2">
                                <input type="text" 
                                       name="slug" 
                                       id="slug"
                                       value="{{ old('slug') }}"
                                       class="flex-1 border border-gray-300 rounded-lg px-4 py-2 focus:ring-indigo-500 focus:border-indigo-500 @error('slug') border-red-500 @enderror" 
                                       placeholder="akan-di-generate-otomatis"
                                       maxlength="255"
                                       required>
                                <button type="button" 
                                        id="regenerateSlug"
                                        class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded-lg transition">
                                    <i class="fas fa-sync-alt mr-2"></i>Generate
                                </button>
                            </div>
                            <div class="mt-2 p-3 bg-gray-50 rounded-lg">
                                <p class="text-xs text-gray-600">
                                    <i class="fas fa-link mr-1"></i>
                                    Preview URL: <span class="font-mono text-indigo-600" id="previewUrl">{{ url('/survey/') }}/</span>
                                </p>
                            </div>
                            <p class="text-xs text-gray-500 mt-1">Hanya huruf, angka, dan tanda hubung (-)</p>
                            @error('slug')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Deskripsi --}}
                        <div class="mb-6">
                            <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                                Deskripsi
                            </label>
                            <textarea name="description" 
                                      id="description"
                                      rows="4"
                                      class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-indigo-500 focus:border-indigo-500 @error('description') border-red-500 @enderror" 
                                      placeholder="Jelaskan tentang survei ini..."
                                      maxlength="1000">{{ old('description') }}</textarea>
                            <p class="text-xs text-gray-500 mt-1">Opsional, maksimal 1000 karakter</p>
                            @error('description')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Periode Survei --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <label for="start_date" class="block text-sm font-medium text-gray-700 mb-2">
                                    Tanggal Mulai <span class="text-red-500">*</span>
                                </label>
                                <input type="datetime-local" 
                                       name="start_date" 
                                       id="start_date"
                                       value="{{ old('start_date') }}"
                                       class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-indigo-500 focus:border-indigo-500 @error('start_date') border-red-500 @enderror" 
                                       required>
                                @error('start_date')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="end_date" class="block text-sm font-medium text-gray-700 mb-2">
                                    Tanggal Selesai <span class="text-red-500">*</span>
                                </label>
                                <input type="datetime-local" 
                                       name="end_date" 
                                       id="end_date"
                                       value="{{ old('end_date') }}"
                                       class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-indigo-500 focus:border-indigo-500 @error('end_date') border-red-500 @enderror" 
                                       required>
                                @error('end_date')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        {{-- Maksimal Responden --}}
                        <div class="mb-6">
                            <label for="max_respondents" class="block text-sm font-medium text-gray-700 mb-2">
                                Maksimal Responden
                            </label>
                            <input type="number" 
                                   name="max_respondents" 
                                   id="max_respondents"
                                   value="{{ old('max_respondents') }}"
                                   class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-indigo-500 focus:border-indigo-500 @error('max_respondents') border-red-500 @enderror" 
                                   placeholder="Kosongkan untuk unlimited"
                                   min="1">
                            <p class="text-xs text-gray-500 mt-1">
                                <i class="fas fa-info-circle mr-1"></i>
                                Kosongkan jika tidak ada batasan jumlah responden. Survei akan otomatis ditutup jika mencapai batas.
                            </p>
                            @error('max_respondents')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Status Awal --}}
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Status Awal <span class="text-red-500">*</span>
                            </label>
                            <div class="grid grid-cols-2 gap-4">
                                <label class="status-option relative flex items-center p-4 border-2 rounded-lg cursor-pointer transition hover:border-indigo-500 border-indigo-500 bg-indigo-50">
                                    <input type="radio" 
                                           name="status" 
                                           value="draft" 
                                           class="sr-only status-radio"
                                           {{ old('status', 'draft') === 'draft' ? 'checked' : '' }}
                                           required>
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 bg-gray-100 rounded-full p-3">
                                            <i class="fas fa-edit text-gray-600 text-xl"></i>
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-sm font-medium text-gray-900">Draft</p>
                                            <p class="text-xs text-gray-500">Belum bisa diakses publik</p>
                                        </div>
                                    </div>
                                </label>

                                <label class="status-option relative flex items-center p-4 border-2 rounded-lg cursor-pointer transition hover:border-indigo-500 border-gray-300">
                                    <input type="radio" 
                                           name="status" 
                                           value="active" 
                                           class="sr-only status-radio"
                                           {{ old('status') === 'active' ? 'checked' : '' }}>
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 bg-green-100 rounded-full p-3">
                                            <i class="fas fa-check-circle text-green-600 text-xl"></i>
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-sm font-medium text-gray-900">Aktif</p>
                                            <p class="text-xs text-gray-500">Langsung bisa diakses publik</p>
                                        </div>
                                    </div>
                                </label>
                            </div>
                            @error('status')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Submit Buttons --}}
                        <div class="flex gap-3 pt-4 border-t border-gray-200">
                            <button type="submit" 
                                    class="flex-1 bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-3 rounded-lg transition font-medium">
                                <i class="fas fa-save mr-2"></i>
                                Simpan Kampanye
                            </button>
                            <a href="{{ route('survey-campaigns.index') }}" 
                               class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-700 px-6 py-3 rounded-lg transition font-medium text-center">
                                <i class="fas fa-times mr-2"></i>
                                Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        // Set default dates
        document.addEventListener('DOMContentLoaded', function() {
            const startDateInput = document.getElementById('start_date');
            const endDateInput = document.getElementById('end_date');
            
            // Set default start date to today
            const today = new Date();
            const todayStr = today.toISOString().slice(0, 16); // Format: YYYY-MM-DDTHH:MM
            
            // Set default end date to tomorrow
            const tomorrow = new Date(today);
            tomorrow.setDate(tomorrow.getDate() + 1);
            const tomorrowStr = tomorrow.toISOString().slice(0, 16);
            
            if (!startDateInput.value) {
                startDateInput.value = todayStr;
            }
            if (!endDateInput.value) {
                endDateInput.value = tomorrowStr;
            }
        });

        // Auto-generate slug from name
        const nameInput = document.getElementById('name');
        const slugInput = document.getElementById('slug');
        const previewUrl = document.getElementById('previewUrl');
        const baseUrl = '{{ url("/survey") }}/';

        function generateSlug(text) {
            return text
                .toLowerCase()
                .replace(/[^\w\s-]/g, '') // Remove special characters
                .replace(/\s+/g, '-')      // Replace spaces with -
                .replace(/-+/g, '-')       // Replace multiple - with single -
                .replace(/^-+|-+$/g, '');  // Trim - from start and end
        }

        function updateSlug() {
            const slug = generateSlug(nameInput.value);
            slugInput.value = slug;
            previewUrl.textContent = baseUrl + slug;
        }

        nameInput.addEventListener('input', updateSlug);
        
        slugInput.addEventListener('input', function() {
            const slug = this.value;
            previewUrl.textContent = baseUrl + slug;
        });

        document.getElementById('regenerateSlug').addEventListener('click', updateSlug);

        // Radio button styling for Jenis Survei
        document.querySelectorAll('.type-radio').forEach(radio => {
            radio.addEventListener('change', function() {
                // Remove active state from all type options
                document.querySelectorAll('.type-option').forEach(label => {
                    label.classList.remove('border-indigo-500', 'bg-indigo-50');
                    label.classList.add('border-gray-300');
                });
                
                // Add active state to selected option
                if (this.checked) {
                    const label = this.closest('.type-option');
                    label.classList.remove('border-gray-300');
                    label.classList.add('border-indigo-500', 'bg-indigo-50');
                }
            });
        });

        // Radio button styling for Status
        document.querySelectorAll('.status-radio').forEach(radio => {
            radio.addEventListener('change', function() {
                // Remove active state from all status options
                document.querySelectorAll('.status-option').forEach(label => {
                    label.classList.remove('border-indigo-500', 'bg-indigo-50');
                    label.classList.add('border-gray-300');
                });
                
                // Add active state to selected option
                if (this.checked) {
                    const label = this.closest('.status-option');
                    label.classList.remove('border-gray-300');
                    label.classList.add('border-indigo-500', 'bg-indigo-50');
                }
            });
        });

        // Date validation
        const startDateInput = document.getElementById('start_date');
        const endDateInput = document.getElementById('end_date');

        endDateInput.addEventListener('change', function() {
            if (startDateInput.value && endDateInput.value) {
                if (new Date(endDateInput.value) <= new Date(startDateInput.value)) {
                    alert('Tanggal selesai harus lebih besar dari tanggal mulai!');
                    endDateInput.value = '';
                }
            }
        });
    </script>
    @endpush
</x-app-layout>
