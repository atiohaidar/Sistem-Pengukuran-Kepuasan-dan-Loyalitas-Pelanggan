<x-guest-layout title="Kepuasan Responden - Survei Kepuasan Pelatihan">
<div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Progress Bar -->
        <div class="mb-8">
            @include('survey.partials.progress-bar')
        </div>

        <!-- Form -->
        <div class="bg-white shadow-lg rounded-lg overflow-hidden">
            <div class="bg-gradient-to-r from-green-600 to-teal-600 px-6 py-4">
                <h2 class="text-2xl font-bold text-white">IV. Kepuasan Responden</h2>
                <p class="text-green-100 mt-1">Berikan penilaian tingkat kepuasan Anda terhadap layanan pelatihan</p>
            </div>

            <form method="POST" action="{{ route('survey.store', ['step' => 'kepuasan']) }}" class="p-6">
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

                <div class="space-y-8">
                    @php $kepuasanData = $survey->getAnswers('kepuasan') ?? []; @endphp

                    <!-- Question 1 -->
                    <div class="bg-gray-50 p-6 rounded-lg">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">1. Secara keseluruhan, saya merasa puas pada layanan pelatihan ini.</h3>
                        <div class="flex flex-wrap gap-4">
                            @php $options = ['Sangat tidak setuju', 'Tidak setuju', 'Netral', 'Setuju', 'Sangat setuju']; @endphp
                            @for($i = 1; $i <= 5; $i++)
                                <label class="flex items-center space-x-2 cursor-pointer">
                                    <input type="radio" name="k1" value="{{ $i }}"
                                           {{ ($kepuasanData['k1'] ?? old('k1')) == $i ? 'checked' : '' }}
                                           class="text-green-600 focus:ring-green-500" required>
                                    <span class="text-sm font-medium">{{ $i }} - {{ $options[$i-1] }}</span>
                                </label>
                            @endfor
                        </div>
                    </div>

                    <!-- Question 2 -->
                    <div class="bg-gray-50 p-6 rounded-lg">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">2. Menurut saya, kinerja layanan pelatihan ini telah sesuai dengan harapan saya.</h3>
                        <div class="flex flex-wrap gap-4">
                            @for($i = 1; $i <= 5; $i++)
                                <label class="flex items-center space-x-2 cursor-pointer">
                                    <input type="radio" name="k2" value="{{ $i }}"
                                           {{ ($kepuasanData['k2'] ?? old('k2')) == $i ? 'checked' : '' }}
                                           class="text-green-600 focus:ring-green-500" required>
                                    <span class="text-sm font-medium">{{ $i }} - {{ $options[$i-1] }}</span>
                                </label>
                            @endfor
                        </div>
                    </div>

                    <!-- Question 3 -->
                    <div class="bg-gray-50 p-6 rounded-lg">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">3. Menurut saya, layanan pelatihan ini telah sesuai dengan layanan pelatihan yang ideal.</h3>
                        <div class="flex flex-wrap gap-4">
                            @for($i = 1; $i <= 5; $i++)
                                <label class="flex items-center space-x-2 cursor-pointer">
                                    <input type="radio" name="k3" value="{{ $i }}"
                                           {{ ($kepuasanData['k3'] ?? old('k3')) == $i ? 'checked' : '' }}
                                           class="text-green-600 focus:ring-green-500" required>
                                    <span class="text-sm font-medium">{{ $i }} - {{ $options[$i-1] }}</span>
                                </label>
                            @endfor
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
        const data = {};

        // Get all checked radio buttons
        document.querySelectorAll('input[type="radio"]:checked').forEach(radio => {
            data[radio.name] = radio.value;
        });

        localStorage.setItem(storageKey, JSON.stringify(data));
    }

    function loadFromLocalStorage() {
        const savedData = localStorage.getItem(storageKey);
        if (!savedData) return;

        try {
            const data = JSON.parse(savedData);

            // Restore radio button selections
            Object.keys(data).forEach(name => {
                const radio = document.querySelector(`input[name="${name}"][value="${data[name]}"]`);
                if (radio) radio.checked = true;
            });
        } catch (e) {
            console.warn('Failed to load survey data from localStorage:', e);
        }
    }
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