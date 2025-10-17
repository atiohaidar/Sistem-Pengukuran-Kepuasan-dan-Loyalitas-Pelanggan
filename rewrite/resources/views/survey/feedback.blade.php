<x-mylayout title="Kritik dan Saran - Survei Kepuasan Pelatihan">
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Progress Bar -->
        <div class="mb-8">
            @include('survey.partials.progress-bar')
        </div>

        <!-- Form -->
        <div class="bg-white shadow-lg rounded-lg overflow-hidden">
            <div class="bg-gradient-to-r from-red-600 to-pink-600 px-6 py-4">
                <h2 class="text-2xl font-bold text-white">VI. Kritik dan Saran</h2>
                <p class="text-red-100 mt-1">>Dengan anda mengisi kritik dan saran ini, diharapkan kualitas layanan pelatihan ini akan semakin baik dan sesuai dengan kepentingan anda.</p>
            </div>

            <form method="POST" action="{{ route('survey.store', ['step' => 'feedback']) }}" class="p-6">
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
                    @php $feedbackData = $survey->getAnswers('feedback') ?? []; @endphp

                    <!-- Question 1: Kritik dan Saran -->
                    <div class="bg-gray-50 p-6 rounded-lg">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">1. Silahkan berikan kritik dan saran terkait layanan pelatihan berdasarkan apa yang Anda alami.</h3>
                        <textarea name="kritik_saran" rows="6"
                                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500 resize-vertical"
                                  placeholder="Tuliskan kritik dan saran Anda di sini...">{{ $feedbackData['kritik_saran'] ?? old('kritik_saran') }}</textarea>
                        <p class="text-sm text-gray-500 mt-2">Maksimal 1000 karakter</p>
                    </div>

                    <!-- Question 2: Tema/Judul Pelatihan -->
                    <div class="bg-gray-50 p-6 rounded-lg">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">2. Tema dan judul pelatihan yang Anda inginkan.</h3>
                        <textarea name="tema_judul" rows="4"
                                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500 resize-vertical"
                                  placeholder="Contoh: Digital Marketing untuk UMKM, Manajemen Keuangan, dll.">{{ $feedbackData['tema_judul'] ?? old('tema_judul') }}</textarea>
                        <p class="text-sm text-gray-500 mt-2">Maksimal 500 karakter</p>
                    </div>

                    <!-- Question 3: Bentuk Pelatihan -->
                    <div class="bg-gray-50 p-6 rounded-lg">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">3. Bentuk pelatihan yang Anda inginkan.</h3>
                        <p class="text-gray-600 mb-4">Pilih semua yang sesuai:</p>

                        @php
                            $bentukOptions = ['online', 'offline', 'streaming', 'elearning'];
                            $selectedBentuk = $feedbackData['bentuk_pelatihan'] ?? old('bentuk_pelatihan', []);
                        @endphp

                        <div class="grid md:grid-cols-2 gap-4">
                            <label class="flex items-center space-x-3 p-3 border border-gray-200 rounded-lg hover:bg-gray-50 cursor-pointer">
                                <input type="checkbox" name="bentuk_pelatihan[online]" value="1"
                                       {{ isset($selectedBentuk['online']) && $selectedBentuk['online'] ? 'checked' : '' }}
                                       class="text-red-600 focus:ring-red-500 rounded">
                                <div>
                                    <span class="font-medium text-gray-800">Online</span>
                                    <p class="text-sm text-gray-600">Pelatihan dilakukan secara daring</p>
                                </div>
                            </label>

                            <label class="flex items-center space-x-3 p-3 border border-gray-200 rounded-lg hover:bg-gray-50 cursor-pointer">
                                <input type="checkbox" name="bentuk_pelatihan[offline]" value="1"
                                       {{ isset($selectedBentuk['offline']) && $selectedBentuk['offline'] ? 'checked' : '' }}
                                       class="text-red-600 focus:ring-red-500 rounded">
                                <div>
                                    <span class="font-medium text-gray-800">Offline</span>
                                    <p class="text-sm text-gray-600">Pelatihan dilakukan secara luring/tatap muka</p>
                                </div>
                            </label>

                            <label class="flex items-center space-x-3 p-3 border border-gray-200 rounded-lg hover:bg-gray-50 cursor-pointer">
                                <input type="checkbox" name="bentuk_pelatihan[streaming]" value="1"
                                       {{ isset($selectedBentuk['streaming']) && $selectedBentuk['streaming'] ? 'checked' : '' }}
                                       class="text-red-600 focus:ring-red-500 rounded">
                                <div>
                                    <span class="font-medium text-gray-800">Streaming</span>
                                    <p class="text-sm text-gray-600">Pelatihan disiarkan secara live streaming</p>
                                </div>
                            </label>

                            <label class="flex items-center space-x-3 p-3 border border-gray-200 rounded-lg hover:bg-gray-50 cursor-pointer">
                                <input type="checkbox" name="bentuk_pelatihan[elearning]" value="1"
                                       {{ isset($selectedBentuk['elearning']) && $selectedBentuk['elearning'] ? 'checked' : '' }}
                                       class="text-red-600 focus:ring-red-500 rounded">
                                <div>
                                    <span class="font-medium text-gray-800">E-learning</span>
                                    <p class="text-sm text-gray-600">Pelatihan mandiri melalui platform online</p>
                                </div>
                            </label>
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
                        <button type="submit" name="action" value="next" class="bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded-md font-medium transition duration-200">
                            Selesai <i class="fas fa-check ml-2"></i>
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
    document.querySelectorAll('input, textarea').forEach(input => {
        input.addEventListener('input', saveToLocalStorage);
        input.addEventListener('change', saveToLocalStorage);
    });

    function saveToLocalStorage() {
        const data = {};

        // Handle textareas
        document.querySelectorAll('textarea').forEach(textarea => {
            if (textarea.value.trim()) {
                data[textarea.name] = textarea.value;
            }
        });

        // Handle checkboxes
        document.querySelectorAll('input[type="checkbox"]').forEach(checkbox => {
            if (checkbox.checked) {
                if (!data[checkbox.name]) data[checkbox.name] = [];
                data[checkbox.name].push(checkbox.value);
            }
        });

        localStorage.setItem(storageKey, JSON.stringify(data));
    }

    function loadFromLocalStorage() {
        const savedData = localStorage.getItem(storageKey);
        if (!savedData) return;

        try {
            const data = JSON.parse(savedData);

            // Restore textareas
            Object.keys(data).forEach(name => {
                if (typeof data[name] === 'string') {
                    const textarea = document.querySelector(`textarea[name="${name}"]`);
                    if (textarea) textarea.value = data[name];
                } else if (Array.isArray(data[name])) {
                    // Restore checkboxes
                    data[name].forEach(value => {
                        const checkbox = document.querySelector(`input[name="${name}"][value="${value}"]`);
                        if (checkbox) checkbox.checked = true;
                    });
                }
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