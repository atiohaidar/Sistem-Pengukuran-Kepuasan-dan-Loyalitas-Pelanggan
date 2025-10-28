<x-guest-layout title="Penilaian Tingkat Kepentingan - Survei Kepuasan {{ ucfirst($type ?? 'Pelatihan') }}">
    <div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 py-8">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Survey Header -->
            <div class="mb-8">
                @include('survey.partials.header')
            </div>

            <!-- Form -->
            <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                <div class="bg-gradient-to-r from-blue-600 to-indigo-600 px-6 py-4">
                    <h2 class="text-2xl font-bold text-white">II. Penilaian Tingkat Kepentingan / Harapan responden
                        terhadap kualitas {{ $type === 'produk' ? 'produk/layanan' : 'layanan pelatihan' }}</h2>
                    <p class="text-blue-100 mt-1">Berikan jawaban yang sesuai dengan preferensi anda. Tentukan seberapa
                        penting atribut tersebut memengaruhi Anda dalam menggunakan
                        {{ $type === 'produk' ? 'produk/layanan' : 'jasa pelatihan' }} ini</p>
                </div>

                <form method="POST"
                    action="{{ isset($campaign) ? route('public-survey.submit', ['slug' => $campaign->slug, 'step' => 'harapan']) : route('survey.store', ['type' => $type ?? 'pelatihan', 'step' => 'harapan']) }}"
                    class="p-6">
                    @csrf
                    @if(isset($campaign))
                        <input type="hidden" name="step" value="harapan">
                    @endif

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
                        <h3 class="text-xl font-semibold text-gray-800 mb-4 bg-blue-50 p-3 rounded">Reliability
                            (Kehandalan)</h3>
                        <div class="space-y-4">
                            @php $reliabilityData = $survey->getAnswers('harapan', 'reliability') ?? []; @endphp

                            @php
                                function renderHarapanSelect($name, $data, $key, $default = null)
                                {
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
                                @php $counter = 1; @endphp
                                @foreach($questions['harapan_answers']['reliability'] as $key => $question)
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">{{ $counter }}.
                                            {{ $question }}</label>
                                        {!! renderHarapanSelect('reliability[' . $key . ']', $reliabilityData, $key) !!}
                                    </div>
                                    @php $counter++; @endphp
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- Assurance Section -->
                    <div class="mb-8">
                        <h3 class="text-xl font-semibold text-gray-800 mb-4 bg-green-50 p-3 rounded">Assurance (Jaminan)
                        </h3>
                        <div class="space-y-4">
                            @php $assuranceData = $survey->getAnswers('harapan', 'assurance') ?? []; @endphp

                            <div class="grid md:grid-cols-2 gap-4">
                                @php $counter = 1; @endphp
                                @foreach($questions['harapan_answers']['assurance'] as $key => $question)
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">{{ $counter }}.
                                            {{ $question }}</label>
                                        {!! renderHarapanSelect('assurance[' . $key . ']', $assuranceData, $key) !!}
                                    </div>
                                    @php $counter++; @endphp
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- Tangible Section -->
                    <div class="mb-8">
                        <h3 class="text-xl font-semibold text-gray-800 mb-4 bg-purple-50 p-3 rounded">Tangible (Bukti
                            Fisik)</h3>
                        <div class="space-y-4">
                            @php $tangibleData = $survey->getAnswers('harapan', 'tangible') ?? []; @endphp

                            <div class="grid md:grid-cols-2 gap-4">
                                @php $counter = 1; @endphp
                                @foreach($questions['harapan_answers']['tangible'] as $key => $question)
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">{{ $counter }}.
                                            {{ $question }}</label>
                                        {!! renderHarapanSelect('tangible[' . $key . ']', $tangibleData, $key) !!}
                                    </div>
                                    @php $counter++; @endphp
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- Empathy Section -->
                    <div class="mb-8">
                        <h3 class="text-xl font-semibold text-gray-800 mb-4 bg-pink-50 p-3 rounded">Empathy (Empati)
                        </h3>
                        <div class="space-y-4">
                            @php $empathyData = $survey->getAnswers('harapan', 'empathy') ?? []; @endphp

                            <div class="grid md:grid-cols-2 gap-4">
                                @php $counter = 1; @endphp
                                @foreach($questions['harapan_answers']['empathy'] as $key => $question)
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">{{ $counter }}.
                                            {{ $question }}</label>
                                        {!! renderHarapanSelect('empathy[' . $key . ']', $empathyData, $key) !!}
                                    </div>
                                    @php $counter++; @endphp
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- Responsiveness Section -->
                    <div class="mb-8">
                        <h3 class="text-xl font-semibold text-gray-800 mb-4 bg-yellow-50 p-3 rounded">Responsiveness
                            (Daya Tanggap)</h3>
                        <div class="space-y-4">
                            @php $responsivenessData = $survey->getAnswers('harapan', 'responsiveness') ?? []; @endphp

                            <div class="grid md:grid-cols-2 gap-4">
                                @php $counter = 1; @endphp
                                @foreach($questions['harapan_answers']['responsiveness'] as $key => $question)
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">{{ $counter }}.
                                            {{ $question }}</label>
                                        {!! renderHarapanSelect('responsiveness[' . $key . ']', $responsivenessData, $key) !!}
                                    </div>
                                    @php $counter++; @endphp
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- Applicability Section -->
                    <div class="mb-8">
                        <h3 class="text-xl font-semibold text-gray-800 mb-4 bg-indigo-50 p-3 rounded">Applicability
                            (Penerapan)</h3>
                        <div class="space-y-4">
                            @php $applicabilityData = $survey->getAnswers('harapan', 'applicability') ?? []; @endphp

                            <div class="grid md:grid-cols-2 gap-4">
                                @php $counter = 1; @endphp
                                @foreach($questions['harapan_answers']['applicability'] as $key => $question)
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">{{ $counter }}.
                                            {{ $question }}</label>
                                        {!! renderHarapanSelect('applicability[' . $key . ']', $applicabilityData, $key) !!}
                                    </div>
                                    @php $counter++; @endphp
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- Navigation Buttons -->
                    <div class="mt-8 flex justify-between">
                        <div>
                            @if($canGoBack)
                                <a href="{{ route('survey.step', ['type' => $type, 'step' => \App\Http\Controllers\SurveyController::getPreviousStep($step)]) }}"
                                    class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                    <i class="fas fa-arrow-left mr-1"></i>Kembali
                                </a>
                            @endif
                        </div>
                        <div>
                            <button type="submit" name="action" value="next"
                                class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-md font-medium transition duration-200">
                                Lanjut <i class="fas fa-arrow-right ml-2"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Progress Bar -->
            <div class="mt-8">
                @include('survey.partials.progress')
            </div>
        </div>
    </div>

    <script>
        // Survey Local Storage Management
        document.addEventListener('DOMContentLoaded', function () {
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
            document.querySelector('form').addEventListener('submit', function () {
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