<x-guest-layout title="Penilaian Persepsi - Survei Kepuasan Pelatihan">
<div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 py-8">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Progress Bar -->
        <div class="mb-8">
            @include('survey.partials.progress-bar')
        </div>

        <!-- Form -->
        <div class="bg-white shadow-lg rounded-lg overflow-hidden">
            <div class="bg-gradient-to-r from-purple-600 to-pink-600 px-6 py-4">
                <h2 class="text-2xl font-bold text-white">III. Penilaian Persepsi</h2>
                <p class="text-purple-100 mt-1">Berikan penilaian sesuai dengan pengalaman Anda terhadap kinerja kualitas layanan yang diberikan</p>
            </div>

            <form method="POST" action="{{ route('survey.store', ['step' => 'persepsi']) }}" class="p-6">
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
                        @php $reliabilityData = $survey->getAnswers('persepsi', 'reliability') ?? []; @endphp

                        @php
    function renderPersepsiSelect($name, $data, $key, $default = null) {
        $selected = $data[$key] ?? old($name) ?? $default ?? '';
        $options = [
            '' => 'Pilih tingkat kepuasan',
            '0' => '0 - Tidak Relevan',
            '1' => '1 - Sangat Tidak Setuju',
            '2' => '2 - Tidak Setuju',
            '3' => '3 - Netral',
            '4' => '4 - Setuju',
            '5' => '5 - Sangat Setuju'
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
                                <label class="block text-sm font-medium text-gray-700 mb-2">1. Isi post test sesuai dengan materi pelatihan yang diberikan</label>
                                {!! renderPersepsiSelect('reliability[r1]', $reliabilityData, 'r1') !!}
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">2. Waktu pelatihan sesuai dengan jadwal yang telah dijanjikan</label>
                                {!! renderPersepsiSelect('reliability[r2]', $reliabilityData, 'r2') !!}
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">3. Sertifikat pelatihan diberikan tepat waktu</label>
                                {!! renderPersepsiSelect('reliability[r3]', $reliabilityData, 'r3') !!}
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">4. Trainer menjawab pertanyaan peserta dengan baik</label>
                                {!! renderPersepsiSelect('reliability[r4]', $reliabilityData, 'r4') !!}
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">5. Materi pelatihan mudah dimengerti</label>
                                {!! renderPersepsiSelect('reliability[r5]', $reliabilityData, 'r5') !!}
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">6. Registrasi pelatihan mudah dilakukan</label>
                                {!! renderPersepsiSelect('reliability[r6]', $reliabilityData, 'r6') !!}
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">7. Pembayaran pelatihan mudah dilakukan</label>
                                {!! renderPersepsiSelect('reliability[r7]', $reliabilityData, 'r7') !!}
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Assurance Section -->
                <div class="mb-8">
                    <h3 class="text-xl font-semibold text-gray-800 mb-4 bg-green-50 p-3 rounded">Assurance (Jaminan)</h3>
                    <div class="space-y-4">
                        @php $assuranceData = $survey->getAnswers('persepsi', 'assurance') ?? []; @endphp

                        <div class="grid md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">1. Trainer/pegawai bersikap sopan</label>
                                {!! renderPersepsiSelect('assurance[a1]', $assuranceData, 'a1') !!}
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">2. Trainer memiliki pengetahuan yang luas mengenai materi pelatihan</label>
                                {!! renderPersepsiSelect('assurance[a2]', $assuranceData, 'a2') !!}
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">3. Trainer mampu menyampaikan materi pelatihan dengan cara yang mudah dipahami</label>
                                {!! renderPersepsiSelect('assurance[a3]', $assuranceData, 'a3') !!}
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">4. Committee service selalu dapat menyelesaikan keluhan pelanggan</label>
                                {!! renderPersepsiSelect('assurance[a4]', $assuranceData, 'a4') !!}
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tangible Section -->
                <div class="mb-8">
                    <h3 class="text-xl font-semibold text-gray-800 mb-4 bg-purple-50 p-3 rounded">Tangible (Bukti Fisik)</h3>
                    <div class="space-y-4">
                        @php $tangibleData = $survey->getAnswers('persepsi', 'tangible') ?? []; @endphp

                        <div class="grid md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">1. Sistem aplikasi pelatihan online yang user friendly</label>
                                {!! renderPersepsiSelect('tangible[t1]', $tangibleData, 't1') !!}
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">2. Website menampilkan informasi terbaru</label>
                                {!! renderPersepsiSelect('tangible[t2]', $tangibleData, 't2') !!}
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">3. Perlengkapan audio visual berfungsi dengan baik</label>
                                {!! renderPersepsiSelect('tangible[t3]', $tangibleData, 't3') !!}
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">4. Koneksi internet host lancar selama pelatihan berlangsung</label>
                                {!! renderPersepsiSelect('tangible[t4]', $tangibleData, 't4') !!}
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">5. Tampilan modul pelatihan menarik untuk dibaca</label>
                                {!! renderPersepsiSelect('tangible[t5]', $tangibleData, 't5') !!}
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">6. Trainer berpenampilan rapi</label>
                                {!! renderPersepsiSelect('tangible[t6]', $tangibleData, 't6') !!}
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Empathy Section -->
                <div class="mb-8">
                    <h3 class="text-xl font-semibold text-gray-800 mb-4 bg-pink-50 p-3 rounded">Empathy (Empati)</h3>
                    <div class="space-y-4">
                        @php $empathyData = $survey->getAnswers('persepsi', 'empathy') ?? []; @endphp

                        <div class="grid md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">1. Trainer memberikan perhatian kepada peserta</label>
                                {!! renderPersepsiSelect('empathy[e1]', $empathyData, 'e1') !!}
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">2. Trainer memahami kebutuhan peserta</label>
                                {!! renderPersepsiSelect('empathy[e2]', $empathyData, 'e2') !!}
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">3. Terjalin komunikasi yang baik antara trainer dengan peserta</label>
                                {!! renderPersepsiSelect('empathy[e3]', $empathyData, 'e3') !!}
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">4. Trainer berupaya membantu saat peserta mengalami kesulitan.</label>
                                {!! renderPersepsiSelect('empathy[e4]', $empathyData, 'e4') !!}
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">5. Waktu yang dialokasikan untuk pelatihan cukup</label>
                                {!! renderPersepsiSelect('empathy[e5]', $empathyData, 'e5') !!}
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Responsiveness Section -->
                <div class="mb-8">
                    <h3 class="text-xl font-semibold text-gray-800 mb-4 bg-yellow-50 p-3 rounded">Responsiveness (Daya Tanggap)</h3>
                    <div class="space-y-4">
                        @php $responsivenessData = $survey->getAnswers('persepsi', 'responsiveness') ?? []; @endphp

                        <div class="grid md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">1. Contact person Perusahaan cepat memberikan respon dalam menanggapi peserta</label>
                                {!! renderPersepsiSelect('responsiveness[r1]', $responsivenessData, 'r1') !!}
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">2. Informasi Jadwal pelatihan diberikan dengan tepat</label>
                                {!! renderPersepsiSelect('responsiveness[r2]', $responsivenessData, 'r2') !!}
                            </div>

                       
                        </div>
                    </div>
                </div>

                <!-- Applicability Section -->
                <div class="mb-8">
                    <h3 class="text-xl font-semibold text-gray-800 mb-4 bg-indigo-50 p-3 rounded">Applicability (Penerapan)</h3>
                    <div class="space-y-4">
                        @php $applicabilityData = $survey->getAnswers('persepsi', 'applicability') ?? []; @endphp

                        <div class="grid md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">1. Materi pelatihan mudah diterapkan dalam pekerjaan sehari-hari</label>
                                {!! renderPersepsiSelect('applicability[ap1]', $applicabilityData, 'ap1') !!}
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">2. Materi pelatihan dapat meningkatkan produktivitas kerja</label>
                                {!! renderPersepsiSelect('applicability[ap2]', $applicabilityData, 'ap2') !!}
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
</x-mylayout>