@extends('layouts.mylayout')

@section('title', 'Profil Responden - Survei Kepuasan Pelatihan')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Progress Bar -->
        <div class="mb-8">
            @include('survey.partials.progress-bar')
        </div>

        <!-- Form -->
        <div class="bg-white shadow-lg rounded-lg overflow-hidden">
            <div class="bg-gradient-to-r from-blue-600 to-indigo-600 px-6 py-4">
                <h2 class="text-2xl font-bold text-white">I. Profil Responden</h2>
                <p class="text-blue-100 mt-1">Mohon lengkapi data diri Anda dengan sebenar-benarnya</p>
            </div>

            <form method="POST" action="{{ route('survey.store', ['step' => 'profile']) }}" class="p-6">
                @csrf

                @if(session('success'))
                    <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded">
                        {{ session('success') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded">
                        <ul class="list-disc list-inside">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="grid md:grid-cols-2 gap-6">
                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                            Email <span class="text-red-500">*</span>
                        </label>
                        <input type="email" id="email" name="email"
                               value="{{ old('email', $survey->getProfileData('email')) }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('email') border-red-500 @enderror"
                               placeholder="contoh@email.com" required>
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- WhatsApp -->
                    <div>
                        <label for="whatsapp" class="block text-sm font-medium text-gray-700 mb-2">
                            WhatsApp <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="whatsapp" name="whatsapp"
                               value="{{ old('whatsapp', $survey->getProfileData('whatsapp')) }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('whatsapp') border-red-500 @enderror"
                               placeholder="08123456789" required>
                        @error('whatsapp')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Jenis Kelamin -->
                    <div>
                        <label for="jenis_kelamin" class="block text-sm font-medium text-gray-700 mb-2">
                            Jenis Kelamin <span class="text-red-500">*</span>
                        </label>
                        <select id="jenis_kelamin" name="jenis_kelamin"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('jenis_kelamin') border-red-500 @enderror" required>
                            <option value="">Pilih Jenis Kelamin</option>
                            <option value="L" {{ old('jenis_kelamin', $survey->getProfileData('jenis_kelamin')) == 'L' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="P" {{ old('jenis_kelamin', $survey->getProfileData('jenis_kelamin')) == 'P' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                        @error('jenis_kelamin')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Usia -->
                    <div>
                        <label for="usia" class="block text-sm font-medium text-gray-700 mb-2">
                            Usia <span class="text-red-500">*</span>
                        </label>
                        <input type="number" id="usia" name="usia"
                               value="{{ old('usia', $survey->getProfileData('usia')) }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('usia') border-red-500 @enderror"
                               placeholder="25" min="1" max="120" required>
                        @error('usia')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Pekerjaan -->
                    <div class="md:col-span-2">
                        <label for="pekerjaan" class="block text-sm font-medium text-gray-700 mb-2">
                            Pekerjaan <span class="text-red-500">*</span>
                        </label>
                        <select id="pekerjaan" name="pekerjaan"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('pekerjaan') border-red-500 @enderror" required>
                            <option value="">Pilih Pekerjaan</option>
                            <option value="Karyawan swasta" {{ old('pekerjaan', $survey->getProfileData('pekerjaan')) == 'Karyawan swasta' ? 'selected' : '' }}>Karyawan swasta</option>
                            <option value="Wiraswasta" {{ old('pekerjaan', $survey->getProfileData('pekerjaan')) == 'Wiraswasta' ? 'selected' : '' }}>Wiraswasta</option>
                            <option value="PNS" {{ old('pekerjaan', $survey->getProfileData('pekerjaan')) == 'PNS' ? 'selected' : '' }}>PNS</option>
                            <option value="Pelajar/Mahasiswa" {{ old('pekerjaan', $survey->getProfileData('pekerjaan')) == 'Pelajar/Mahasiswa' ? 'selected' : '' }}>Pelajar/Mahasiswa</option>
                            <option value="Lainnya" {{ old('pekerjaan', $survey->getProfileData('pekerjaan')) == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                        </select>
                        @error('pekerjaan')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Pekerjaan Lain (conditional) -->
                    <div class="md:col-span-2" id="pekerjaan_lain_container" style="display: none;">
                        <label for="pekerjaan_lain" class="block text-sm font-medium text-gray-700 mb-2">
                            Sebutkan Pekerjaan Lainnya
                        </label>
                        <input type="text" id="pekerjaan_lain" name="pekerjaan_lain"
                               value="{{ old('pekerjaan_lain', $survey->getProfileData('pekerjaan_lain')) }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                               placeholder="Sebutkan pekerjaan lainnya">
                    </div>

                    <!-- Domisili -->
                    <div class="md:col-span-2">
                        <label for="domisili" class="block text-sm font-medium text-gray-700 mb-2">
                            Domisili <span class="text-red-500">*</span>
                        </label>
                        <select id="domisili" name="domisili"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('domisili') border-red-500 @enderror" required>
                            <option value="">Pilih Domisili</option>
                            <option value="Aceh" {{ old('domisili', $survey->getProfileData('domisili')) == 'Aceh' ? 'selected' : '' }}>Aceh</option>
                            <option value="Sumatera Utara" {{ old('domisili', $survey->getProfileData('domisili')) == 'Sumatera Utara' ? 'selected' : '' }}>Sumatera Utara</option>
                            <option value="Sumatera Barat" {{ old('domisili', $survey->getProfileData('domisili')) == 'Sumatera Barat' ? 'selected' : '' }}>Sumatera Barat</option>
                            <option value="Riau" {{ old('domisili', $survey->getProfileData('domisili')) == 'Riau' ? 'selected' : '' }}>Riau</option>
                            <option value="Jambi" {{ old('domisili', $survey->getProfileData('domisili')) == 'Jambi' ? 'selected' : '' }}>Jambi</option>
                            <option value="Sumatera Selatan" {{ old('domisili', $survey->getProfileData('domisili')) == 'Sumatera Selatan' ? 'selected' : '' }}>Sumatera Selatan</option>
                            <option value="Bengkulu" {{ old('domisili', $survey->getProfileData('domisili')) == 'Bengkulu' ? 'selected' : '' }}>Bengkulu</option>
                            <option value="Lampung" {{ old('domisili', $survey->getProfileData('domisili')) == 'Lampung' ? 'selected' : '' }}>Lampung</option>
                            <option value="DKI Jakarta" {{ old('domisili', $survey->getProfileData('domisili')) == 'DKI Jakarta' ? 'selected' : '' }}>DKI Jakarta</option>
                            <option value="Jawa Barat" {{ old('domisili', $survey->getProfileData('domisili')) == 'Jawa Barat' ? 'selected' : '' }}>Jawa Barat</option>
                            <option value="Jawa Tengah" {{ old('domisili', $survey->getProfileData('domisili')) == 'Jawa Tengah' ? 'selected' : '' }}>Jawa Tengah</option>
                            <option value="DI Yogyakarta" {{ old('domisili', $survey->getProfileData('domisili')) == 'DI Yogyakarta' ? 'selected' : '' }}>DI Yogyakarta</option>
                            <option value="Jawa Timur" {{ old('domisili', $survey->getProfileData('domisili')) == 'Jawa Timur' ? 'selected' : '' }}>Jawa Timur</option>
                            <option value="Banten" {{ old('domisili', $survey->getProfileData('domisili')) == 'Banten' ? 'selected' : '' }}>Banten</option>
                            <option value="Bali" {{ old('domisili', $survey->getProfileData('domisili')) == 'Bali' ? 'selected' : '' }}>Bali</option>
                            <option value="Nusa Tenggara Barat" {{ old('domisili', $survey->getProfileData('domisili')) == 'Nusa Tenggara Barat' ? 'selected' : '' }}>Nusa Tenggara Barat</option>
                            <option value="Nusa Tenggara Timur" {{ old('domisili', $survey->getProfileData('domisili')) == 'Nusa Tenggara Timur' ? 'selected' : '' }}>Nusa Tenggara Timur</option>
                            <option value="Kalimantan Barat" {{ old('domisili', $survey->getProfileData('domisili')) == 'Kalimantan Barat' ? 'selected' : '' }}>Kalimantan Barat</option>
                            <option value="Kalimantan Tengah" {{ old('domisili', $survey->getProfileData('domisili')) == 'Kalimantan Tengah' ? 'selected' : '' }}>Kalimantan Tengah</option>
                            <option value="Kalimantan Selatan" {{ old('domisili', $survey->getProfileData('domisili')) == 'Kalimantan Selatan' ? 'selected' : '' }}>Kalimantan Selatan</option>
                            <option value="Kalimantan Timur" {{ old('domisili', $survey->getProfileData('domisili')) == 'Kalimantan Timur' ? 'selected' : '' }}>Kalimantan Timur</option>
                            <option value="Kalimantan Utara" {{ old('domisili', $survey->getProfileData('domisili')) == 'Kalimantan Utara' ? 'selected' : '' }}>Kalimantan Utara</option>
                            <option value="Sulawesi Utara" {{ old('domisili', $survey->getProfileData('domisili')) == 'Sulawesi Utara' ? 'selected' : '' }}>Sulawesi Utara</option>
                            <option value="Sulawesi Tengah" {{ old('domisili', $survey->getProfileData('domisili')) == 'Sulawesi Tengah' ? 'selected' : '' }}>Sulawesi Tengah</option>
                            <option value="Sulawesi Selatan" {{ old('domisili', $survey->getProfileData('domisili')) == 'Sulawesi Selatan' ? 'selected' : '' }}>Sulawesi Selatan</option>
                            <option value="Sulawesi Tenggara" {{ old('domisili', $survey->getProfileData('domisili')) == 'Sulawesi Tenggara' ? 'selected' : '' }}>Sulawesi Tenggara</option>
                            <option value="Gorontalo" {{ old('domisili', $survey->getProfileData('domisili')) == 'Gorontalo' ? 'selected' : '' }}>Gorontalo</option>
                            <option value="Sulawesi Barat" {{ old('domisili', $survey->getProfileData('domisili')) == 'Sulawesi Barat' ? 'selected' : '' }}>Sulawesi Barat</option>
                            <option value="Maluku" {{ old('domisili', $survey->getProfileData('domisili')) == 'Maluku' ? 'selected' : '' }}>Maluku</option>
                            <option value="Maluku Utara" {{ old('domisili', $survey->getProfileData('domisili')) == 'Maluku Utara' ? 'selected' : '' }}>Maluku Utara</option>
                            <option value="Papua Barat" {{ old('domisili', $survey->getProfileData('domisili')) == 'Papua Barat' ? 'selected' : '' }}>Papua Barat</option>
                            <option value="Papua" {{ old('domisili', $survey->getProfileData('domisili')) == 'Papua' ? 'selected' : '' }}>Papua</option>
                        </select>
                        @error('domisili')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Navigation Buttons -->
                <div class="mt-8 flex justify-between">
                    <div></div> <!-- Spacer for left side -->
                    <div class="flex space-x-4">
                        <button type="submit" name="action" value="save" class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-md font-medium transition duration-200">
                            <i class="fas fa-save mr-2"></i>Simpan
                        </button>
                        <button type="submit" name="action" value="next" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-md font-medium transition duration-200">
                            Lanjut <i class="fas fa-arrow-right ml-2"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.getElementById('pekerjaan').addEventListener('change', function() {
    const container = document.getElementById('pekerjaan_lain_container');
    if (this.value === 'Lainnya') {
        container.style.display = 'block';
    } else {
        container.style.display = 'none';
    }
});

// Show pekerjaan lain if already selected
document.addEventListener('DOMContentLoaded', function() {
    const pekerjaanSelect = document.getElementById('pekerjaan');
    const container = document.getElementById('pekerjaan_lain_container');
    if (pekerjaanSelect.value === 'Lainnya') {
        container.style.display = 'block';
    }
});
</script>
@endsection