<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Edit Kampanye Survei') }}
            </h2>
            <a href="{{ route('survey-campaigns.dashboard', $campaign) }}" class="text-gray-600 hover:text-gray-900">
                <i class="fas fa-arrow-left mr-2"></i>Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form action="{{ route('survey-campaigns.update', $campaign) }}" method="POST" id="campaignForm">
                        @csrf
                        @method('PUT')

                        {{-- Jenis Survei --}}
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Jenis Survei <span class="text-red-500">*</span>
                            </label>
                            <div class="grid grid-cols-2 gap-4">
                                <label class="relative flex items-center p-4 border-2 rounded-lg cursor-pointer transition hover:border-indigo-500 {{ old('type', $campaign->type) === 'produk' ? 'border-indigo-500 bg-indigo-50' : 'border-gray-300' }}">
                                    <input type="radio" 
                                           name="type" 
                                           value="produk" 
                                           class="sr-only"
                                           {{ old('type', $campaign->type) === 'produk' ? 'checked' : '' }}
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

                                <label class="relative flex items-center p-4 border-2 rounded-lg cursor-pointer transition hover:border-indigo-500 {{ old('type', $campaign->type) === 'pelatihan' ? 'border-indigo-500 bg-indigo-50' : 'border-gray-300' }}">
                                    <input type="radio" 
                                           name="type" 
                                           value="pelatihan" 
                                           class="sr-only"
                                           {{ old('type', $campaign->type) === 'pelatihan' ? 'checked' : '' }}
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
                                   value="{{ old('name', $campaign->name) }}"
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
                                       value="{{ old('slug', $campaign->slug) }}"
                                       class="flex-1 border border-gray-300 rounded-lg px-4 py-2 focus:ring-indigo-500 focus:border-indigo-500 @error('slug') border-red-500 @enderror" 
                                       placeholder="slug-url"
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
                                    Preview URL: <span class="font-mono text-indigo-600" id="previewUrl">{{ url('/survey/') }}/{{ old('slug', $campaign->slug) }}</span>
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
                                      maxlength="1000">{{ old('description', $campaign->description) }}</textarea>
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
                                       value="{{ old('start_date', $campaign->start_date->format('Y-m-d\TH:i')) }}"
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
                                       value="{{ old('end_date', $campaign->end_date->format('Y-m-d\TH:i')) }}"
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
                                   value="{{ old('max_respondents', $campaign->max_respondents) }}"
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

                        {{-- Status --}}
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Status <span class="text-red-500">*</span>
                            </label>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                <label class="relative flex flex-col items-center p-4 border-2 rounded-lg cursor-pointer transition hover:border-indigo-500 {{ old('status', $campaign->status) === 'draft' ? 'border-indigo-500 bg-indigo-50' : 'border-gray-300' }}">
                                    <input type="radio" 
                                           name="status" 
                                           value="draft" 
                                           class="sr-only"
                                           {{ old('status', $campaign->status) === 'draft' ? 'checked' : '' }}
                                           required>
                                    <div class="bg-gray-100 rounded-full p-3 mb-2">
                                        <i class="fas fa-edit text-gray-600 text-xl"></i>
                                    </div>
                                    <p class="text-sm font-medium text-gray-900">Draft</p>
                                </label>

                                <label class="relative flex flex-col items-center p-4 border-2 rounded-lg cursor-pointer transition hover:border-indigo-500 {{ old('status', $campaign->status) === 'active' ? 'border-indigo-500 bg-indigo-50' : 'border-gray-300' }}">
                                    <input type="radio" 
                                           name="status" 
                                           value="active" 
                                           class="sr-only"
                                           {{ old('status', $campaign->status) === 'active' ? 'checked' : '' }}>
                                    <div class="bg-green-100 rounded-full p-3 mb-2">
                                        <i class="fas fa-check-circle text-green-600 text-xl"></i>
                                    </div>
                                    <p class="text-sm font-medium text-gray-900">Aktif</p>
                                </label>

                                <label class="relative flex flex-col items-center p-4 border-2 rounded-lg cursor-pointer transition hover:border-indigo-500 {{ old('status', $campaign->status) === 'closed' ? 'border-indigo-500 bg-indigo-50' : 'border-gray-300' }}">
                                    <input type="radio" 
                                           name="status" 
                                           value="closed" 
                                           class="sr-only"
                                           {{ old('status', $campaign->status) === 'closed' ? 'checked' : '' }}>
                                    <div class="bg-red-100 rounded-full p-3 mb-2">
                                        <i class="fas fa-times-circle text-red-600 text-xl"></i>
                                    </div>
                                    <p class="text-sm font-medium text-gray-900">Closed</p>
                                </label>

                                <label class="relative flex flex-col items-center p-4 border-2 rounded-lg cursor-pointer transition hover:border-indigo-500 {{ old('status', $campaign->status) === 'archived' ? 'border-indigo-500 bg-indigo-50' : 'border-gray-300' }}">
                                    <input type="radio" 
                                           name="status" 
                                           value="archived" 
                                           class="sr-only"
                                           {{ old('status', $campaign->status) === 'archived' ? 'checked' : '' }}>
                                    <div class="bg-blue-100 rounded-full p-3 mb-2">
                                        <i class="fas fa-archive text-blue-600 text-xl"></i>
                                    </div>
                                    <p class="text-sm font-medium text-gray-900">Archived</p>
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
                                Simpan Perubahan
                            </button>
                            <a href="{{ route('survey-campaigns.dashboard', $campaign) }}" 
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
        // Auto-generate slug from name
        const nameInput = document.getElementById('name');
        const slugInput = document.getElementById('slug');
        const previewUrl = document.getElementById('previewUrl');
        const baseUrl = '{{ url("/survey") }}/';

        function generateSlug(text) {
            return text
                .toLowerCase()
                .replace(/[^\w\s-]/g, '')
                .replace(/\s+/g, '-')
                .replace(/-+/g, '-')
                .replace(/^-+|-+$/g, '');
        }

        function updateSlug() {
            const slug = generateSlug(nameInput.value);
            slugInput.value = slug;
            previewUrl.textContent = baseUrl + slug;
        }

        nameInput.addEventListener('input', updateSlug);
        
        slugInput.addEventListener('input', function() {
            previewUrl.textContent = baseUrl + this.value;
        });

        document.getElementById('regenerateSlug').addEventListener('click', updateSlug);

        // Radio button styling
        document.querySelectorAll('input[type="radio"]').forEach(radio => {
            radio.addEventListener('change', function() {
                const labels = this.closest('.grid').querySelectorAll('label');
                labels.forEach(label => {
                    label.classList.remove('border-indigo-500', 'bg-indigo-50');
                    label.classList.add('border-gray-300');
                });
                
                if (this.checked) {
                    const label = this.closest('label');
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
