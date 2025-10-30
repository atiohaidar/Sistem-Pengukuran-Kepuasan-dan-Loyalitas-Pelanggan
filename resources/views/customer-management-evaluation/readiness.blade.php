<x-guest-layout>
<div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-3xl mx-auto">
        <!-- Progress Bar -->
        <div class="mb-8">
            <div class="flex items-center justify-between mb-4">
                <span class="text-sm font-medium text-gray-700">Langkah 3 dari 3</span>
                <span class="text-sm font-medium text-gray-700">100%</span>
            </div>
            <div class="w-full bg-gray-200 rounded-full h-2">
                <div class="bg-indigo-600 h-2 rounded-full" style="width: 100%"></div>
            </div>
        </div>

        <!-- Form -->
        <div class="bg-white shadow rounded-lg p-6">
            <h2 class="text-2xl font-bold text-gray-900 mb-4">Audit Sistem Pengelolaan Pelanggan</h2>
            <p class="text-gray-600 mb-6">Pada tahap ini, pilih kondisi sistem manajemen pelanggan yang paling sesuai dengan perusahaan anda.</p>

            <form action="{{ route('customer-management-evaluation.store-readiness', ['token' => request()->route('token')]) }}" method="POST">
                @csrf

                <!-- Readiness Questions -->
                <div class="space-y-6">
@php
    $questions = app(\App\Services\SurveyQuestionService::class)->getReadinessQuestions();
@endphp                    @foreach($questions as $key => $question)
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                {{ $question['label'] }}
                            </label>
                            <select name="{{ $key }}" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md" required>
                                <option value="">Pilih...</option>
                                @foreach($question['options'] as $value => $text)
                                    <option value="{{ $value }}" {{ ($data['readiness'][$key] ?? 3) == $value ? 'selected' : '' }}>
                                        {{ $value }} - {{ $text }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    @endforeach
                </div>

                <!-- Navigation Buttons -->
                <div class="mt-8 flex justify-between">
                    <a href="{{ route('customer-management-evaluation.priority', ['token' => request()->route('token')]) }}"
                       class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Kembali
                    </a>
                    <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Lihat Hasil
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
</x-guest-layout>