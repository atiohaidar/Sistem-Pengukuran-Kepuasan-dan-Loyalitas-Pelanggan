@extends('layouts.mylayout')

@section('title', 'Penilaian Tingkat Kepentingan - Survei Kepuasan Pelatihan')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Progress Bar -->
        <div class="mb-8">
            @include('survey.partials.progress-bar')
        </div>

        <!-- Form -->
        <div class="bg-white shadow-lg rounded-lg overflow-hidden">
            <div class="bg-gradient-to-r from-blue-600 to-indigo-600 px-6 py-4">
                <h2 class="text-2xl font-bold text-white">II. Penilaian Tingkat Kepentingan / Harapan responden terhadap kualitas layanan pelatihan</h2>
                <p class="text-blue-100 mt-1">Berikan jawaban yang sesuai dengan preferensi anda. Tentukan seberapa penting atribut tersebut memengaruhi Anda dalam menggunakan jasa pelatihan ini</p>
            </div>

            <form method="POST" action="{{ route('survey.store', ['step' => 'importance']) }}" class="p-6">
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

                <!-- Reliability Section -->
                <div class="mb-8">
                    <h3 class="text-xl font-semibold text-gray-800 mb-4 bg-blue-50 p-3 rounded">Reliability (Kehandalan)</h3>
                    <div class="space-y-4">
                        @php $reliabilityData = $survey->getAnswers('importance', 'reliability') ?? []; @endphp

                        @php
    function renderImportanceSelect($name, $data, $key, $default = null) {
        $selected = $data[$key] ?? old($name) ?? $default ?? '';
        $options = [
            '' => 'Pilih tingkat kepentingan',
            '0' => '0 - Tidak relevan',
            '1' => '1 - Sangat tidak penting',
            '2' => '2 - Tidak penting',
            '3' => '3 - Netral',
            '4' => '4 - Penting',
            '5' => '5 - Sangat penting'
        ];

        $html = '<select name="' . $name . '" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md" required>';
        foreach ($options as $value => $label) {
            $selectedAttr = ($selected == $value) ? ' selected' : '';
            $html .= '<option value="' . $value . '"' . $selectedAttr . '>' . $label . '</option>';
        }
        $html .= '</select>';
        return $html;
    }
@endphp

                        <div class="grid md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">1. Kesesuaian isi post test dengan materi pelatihan yang diberikan</label>
                                {!! renderImportanceSelect('reliability[r1]', $reliabilityData, 'r1') !!}
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">2. Ketepatan waktu pelatihan sesuai dengan jadwal yang telah dijanjikan</label>
                                {!! renderImportanceSelect('reliability[r2]', $reliabilityData, 'r2') !!}
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">3. Ketepatan waktu dalam memberikan sertifikat pelatihan</label>
                                {!! renderImportanceSelect('reliability[r3]', $reliabilityData, 'r3') !!}
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">4. Ketepatan trainer dalam menjawab pertanyaan peserta</label>
                                {!! renderImportanceSelect('reliability[r4]', $reliabilityData, 'r4') !!}
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">5. Materi pelatihan mudah dimengerti</label>
                                {!! renderImportanceSelect('reliability[r5]', $reliabilityData, 'r5') !!}
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">6. Kemudahan dalam melakukan registrasi pelatihan</label>
                                {!! renderImportanceSelect('reliability[r6]', $reliabilityData, 'r6') !!}
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">7. Kemudahan dalam melakukan pembayaran pelatihan</label>
                                {!! renderImportanceSelect('reliability[r7]', $reliabilityData, 'r7') !!}
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Assurance Section -->
                <div class="mb-8">
                    <h3 class="text-xl font-semibold text-gray-800 mb-4 bg-green-50 p-3 rounded">Assurance (Jaminan)</h3>
                    <div class="space-y-4">
                        @php $assuranceData = $survey->getAnswers('importance', 'assurance') ?? []; @endphp

                        <div class="grid md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">1. Trainer/pegawai bersikap sopan</label>
                                {!! renderImportanceSelect('assurance[a1]', $assuranceData, 'a1') !!}
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">2. Trainer memiliki pengetahuan yang luas mengenai materi pelatihan</label>
                                {!! renderImportanceSelect('assurance[a2]', $assuranceData, 'a2') !!}
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">3. Trainer mampu menyampaikan materi pelatihan dengan cara yang mudah dipahami</label>
                                {!! renderImportanceSelect('assurance[a3]', $assuranceData, 'a3') !!}
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">4. Committee service selalu dapat menyelesaikan keluhan pelanggan</label>
                                {!! renderImportanceSelect('assurance[a4]', $assuranceData, 'a4') !!}
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tangible Section -->
                <div class="mb-8">
                    <h3 class="text-xl font-semibold text-gray-800 mb-4 bg-purple-50 p-3 rounded">Tangible (Bukti Fisik)</h3>
                    <div class="space-y-4">
                        @php $tangibleData = $survey->getAnswers('importance', 'tangible') ?? []; @endphp

                        <div class="grid md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">1. Sistem aplikasi pelatihan online yang user friendly</label>
                                {!! renderImportanceSelect('tangible[t1]', $tangibleData, 't1') !!}
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">2. Website menampilkan informasi terbaru</label>
                                {!! renderImportanceSelect('tangible[t2]', $tangibleData, 't2') !!}
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">3. Perlengkapan audio visual berfungsi dengan baik</label>
                                {!! renderImportanceSelect('tangible[t3]', $tangibleData, 't3') !!}
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">4. Koneksi internet host lancar selama pelatihan berlangsung</label>
                                {!! renderImportanceSelect('tangible[t4]', $tangibleData, 't4') !!}
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">5. Tampilan modul pelatihan menarik untuk dibaca</label>
                                {!! renderImportanceSelect('tangible[t5]', $tangibleData, 't5') !!}
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">6. Trainer berpenampilan rapi</label>
                                {!! renderImportanceSelect('tangible[t6]', $tangibleData, 't6') !!}
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Empathy Section -->
                <div class="mb-8">
                    <h3 class="text-xl font-semibold text-gray-800 mb-4 bg-pink-50 p-3 rounded">Empathy (Empati)</h3>
                    <div class="space-y-4">
                        @php $empathyData = $survey->getAnswers('importance', 'empathy') ?? []; @endphp

                        <div class="grid md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">1. Trainer memberi perhatian kepada peserta</label>
                                {!! renderImportanceSelect('empathy[e1]', $empathyData, 'e1') !!}
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">2. Trainer memahami kebutuhan peserta</label>
                                {!! renderImportanceSelect('empathy[e2]', $empathyData, 'e2') !!}
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">3. Terjalin komunikasi yang baik antara trainer dengan peserta</label>
                                {!! renderImportanceSelect('empathy[e3]', $empathyData, 'e3') !!}
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">4. Trainer berupaya membantu saat peserta mengalami kesulitan</label>
                                {!! renderImportanceSelect('empathy[e4]', $empathyData, 'e4') !!}
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">5. Kecukupan waktu yang dialokasikan untuk pelatihan</label>
                                {!! renderImportanceSelect('empathy[e5]', $empathyData, 'e5') !!}
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Responsiveness Section -->
                <div class="mb-8">
                    <h3 class="text-xl font-semibold text-gray-800 mb-4 bg-yellow-50 p-3 rounded">Responsiveness (Daya Tanggap)</h3>
                    <div class="space-y-4">
                        @php $responsivenessData = $survey->getAnswers('importance', 'responsiveness') ?? []; @endphp

                        <div class="grid md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">1. Kecepatan respon contact person perusahaan dalam menanggapi peserta</label>
                                {!! renderImportanceSelect('responsiveness[r1]', $responsivenessData, 'r1') !!}
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">2. Kepastian informasi mengenai jadwal pelatihan</label>
                                {!! renderImportanceSelect('responsiveness[r2]', $responsivenessData, 'r2') !!}
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Applicability Section -->
                <div class="mb-8">
                    <h3 class="text-xl font-semibold text-gray-800 mb-4 bg-indigo-50 p-3 rounded">Applicability (Penerapan)</h3>
                    <div class="space-y-4">
                        @php $applicabilityData = $survey->getAnswers('importance', 'applicability') ?? []; @endphp

                        <div class="grid md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">1. Pelatihan berkaitan langsung dengan pekerjaan saya</label>
                                {!! renderImportanceSelect('applicability[ap1]', $applicabilityData, 'ap1') !!}
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">2. Pelatihan yang diberikan mudah untuk diterapkan dalam pekerjaan</label>
                                {!! renderImportanceSelect('applicability[ap2]', $applicabilityData, 'ap2') !!}
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Navigation Buttons -->
                <div class="mt-8 flex justify-between">
                    <div>
                        @if($canGoBack)
                            <a href="{{ route('survey.step', ['step' => \App\Http\Controllers\SurveyController::getPreviousStep($step)]) }}"
                               class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                <i class="fas fa-arrow-left mr-1"></i>Kembali
                            </a>
                        @endif
                    </div>
                    <div>
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
// Survey Local Storage Management
document.addEventListener('DOMContentLoaded', function() {
    const sessionToken = '{{ $survey->session_token }}';
    const step = '{{ $step }}';
    const storageKey = `survey_${sessionToken}_${step}`;

    // Load saved data from localStorage
    loadFromLocalStorage();

    // Save to localStorage on input change
    document.querySelectorAll('input[type="radio"]').forEach(radio => {
        radio.addEventListener('change', saveToLocalStorage);
    });

    function saveToLocalStorage() {
        const formData = new FormData(document.querySelector('form'));
        const data = {};

        // Group radio buttons by name
        document.querySelectorAll('input[type="radio"]:checked').forEach(radio => {
            const name = radio.name;
            const value = radio.value;

            // Handle nested structure for reliability, assurance, etc.
            if (name.includes('[')) {
                const parts = name.replace(']', '').split('[');
                if (!data[parts[0]]) data[parts[0]] = {};
                data[parts[0]][parts[1]] = value;
            } else {
                data[name] = value;
            }
        });

        localStorage.setItem(storageKey, JSON.stringify(data));
    }

    function loadFromLocalStorage() {
        const savedData = localStorage.getItem(storageKey);
        if (!savedData) return;

        try {
            const data = JSON.parse(savedData);

            // Restore radio button selections
            Object.keys(data).forEach(section => {
                if (typeof data[section] === 'object') {
                    // Handle nested sections like reliability[r1]
                    Object.keys(data[section]).forEach(key => {
                        const radioName = `${section}[${key}]`;
                        const radioValue = data[section][key];
                        const radio = document.querySelector(`input[name="${radioName}"][value="${radioValue}"]`);
                        if (radio) radio.checked = true;
                    });
                } else {
                    // Handle simple fields
                    const radio = document.querySelector(`input[name="${section}"][value="${data[section]}"]`);
                    if (radio) radio.checked = true;
                }
            });
        } catch (e) {
            console.warn('Failed to load survey data from localStorage:', e);
        }
    }

    // Clear localStorage when form is submitted successfully
    document.querySelector('form').addEventListener('submit', function() {
        // Keep data in localStorage until successfully saved to server
        // Will be cleared on successful redirect to next step
    });
});

// Clear localStorage for this step when page loads (after successful save)
if (window.location.search.includes('success')) {
    const sessionToken = '{{ $survey->session_token }}';
    const step = '{{ $step }}';
    const storageKey = `survey_${sessionToken}_${step}`;
    localStorage.removeItem(storageKey);
}
</script>
@endsection