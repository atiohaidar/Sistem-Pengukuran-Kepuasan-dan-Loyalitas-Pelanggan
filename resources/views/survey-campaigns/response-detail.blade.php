<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <div class="flex items-center gap-3 mb-1">
                    <a href="{{ route('survey-campaigns.responses', $campaign) }}" 
                       class="text-gray-400 hover:text-gray-600 transition">
                        <i class="fas fa-arrow-left"></i>
                    </a>
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                        {{ __('Detail Respons - ') . $campaign->name }}
                    </h2>
                </div>
                <p class="text-sm text-gray-600 ml-8">
                    {{ $campaign->name }}
                </p>
            </div>
            <a href="{{ route('survey-campaigns.responses', $campaign) }}" 
               class="inline-flex items-center gap-2 bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg transition">
                <i class="fas fa-list"></i>
                <span>Semua Respons</span>
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <!-- Profile Information -->
                    <div class="bg-gray-50 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                        <div class="px-6 py-4 bg-gray-100 border-b border-gray-200">
                            <h3 class="text-lg font-medium text-gray-900">Informasi Responden</h3>
                        </div>
                        <div class="p-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <dl class="space-y-3">
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500">ID Responden</dt>
                                            <dd class="mt-1 text-sm text-gray-900">{{ $surveyResponse->id }}</dd>
                                        </div>
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500">Session Token</dt>
                                            <dd class="mt-1 text-sm text-gray-900">
                                                <span class="font-mono text-xs bg-gray-100 px-2 py-1 rounded">{{ $surveyResponse->session_token }}</span>
                                            </dd>
                                        </div>
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500">Email</dt>
                                            <dd class="mt-1 text-sm text-gray-900">{{ $surveyResponse->profile_data['email'] ?? '-' }}</dd>
                                        </div>
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500">WhatsApp</dt>
                                            <dd class="mt-1 text-sm text-gray-900">{{ $surveyResponse->profile_data['whatsapp'] ?? '-' }}</dd>
                                        </div>
                                    </dl>
                                </div>
                                <div>
                                    <dl class="space-y-3">
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500">Jenis Kelamin</dt>
                                            <dd class="mt-1 text-sm text-gray-900">
                                                @if(isset($surveyResponse->profile_data['jenis_kelamin']))
                                                    {{ $surveyResponse->profile_data['jenis_kelamin'] === 'L' ? 'Laki-laki' : 'Perempuan' }}
                                                @else
                                                    -
                                                @endif
                                            </dd>
                                        </div>
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500">Usia</dt>
                                            <dd class="mt-1 text-sm text-gray-900">{{ $surveyResponse->profile_data['usia'] ?? '-' }} tahun</dd>
                                        </div>
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500">Pekerjaan</dt>
                                            <dd class="mt-1 text-sm text-gray-900">{{ $surveyResponse->profile_data['pekerjaan'] ?? '-' }}</dd>
                                        </div>
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500">Domisili</dt>
                                            <dd class="mt-1 text-sm text-gray-900">{{ $surveyResponse->profile_data['domisili'] ?? '-' }}</dd>
                                        </div>
                                    </dl>
                                </div>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6 pt-6 border-t border-gray-200">
                                <div>
                                    <dl class="space-y-3">
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500">Status</dt>
                                            <dd class="mt-1">
                                                @if($surveyResponse->status === 'completed')
                                                    <span class="px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded-full">Selesai</span>
                                                @else
                                                    <span class="px-2 py-1 text-xs font-medium bg-yellow-100 text-yellow-800 rounded-full">Draft</span>
                                                @endif
                                            </dd>
                                        </div>
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500">Dibuat</dt>
                                            <dd class="mt-1 text-sm text-gray-900">{{ $surveyResponse->created_at->format('d/m/Y H:i:s') }}</dd>
                                        </div>
                                    </dl>
                                </div>
                                <div>
                                    <dl class="space-y-3">
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500">Dimulai</dt>
                                            <dd class="mt-1 text-sm text-gray-900">{{ $surveyResponse->started_at ? $surveyResponse->started_at->format('d/m/Y H:i:s') : '-' }}</dd>
                                        </div>
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500">Selesai</dt>
                                            <dd class="mt-1 text-sm text-gray-900">{{ $surveyResponse->completed_at ? $surveyResponse->completed_at->format('d/m/Y H:i:s') : '-' }}</dd>
                                        </div>
                                    </dl>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Survey Answers -->
                    @if($surveyResponse->status === 'completed')
                        <!-- Harapan Answers -->
                        @if($surveyResponse->harapan_answers)
                            <div class="bg-gray-50 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                                <div class="px-6 py-4 bg-gray-100 border-b border-gray-200">
                                    <h3 class="text-lg font-medium text-gray-900">Jawaban Pentingnya (Harapan)</h3>
                                </div>
                                <div class="p-6">
                                    @foreach($questionLabels['harapan_answers'] as $dimension => $questions)
                                        <h5 class="text-lg font-semibold text-blue-600 mb-3">{{ ucfirst($dimension) }}</h5>
                                        <div class="overflow-x-auto mb-6">
                                            <table class="min-w-full divide-y divide-gray-200">
                                                <thead class="bg-gray-50">
                                                    <tr>
                                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pertanyaan</th>
                                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jawaban</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="bg-white divide-y divide-gray-200">
                                                    @foreach($questions as $key => $question)
                                                        <tr>
                                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $question }}</td>
                                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                                @php
                                                                    $answer = $surveyResponse->harapan_answers[$dimension][$key] ?? null;
                                                                @endphp
                                                                @if($answer)
                                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                                        {{ $answer }}/5
                                                                    </span>
                                                                @else
                                                                    <span class="text-gray-400">-</span>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <!-- Persepsi Answers -->
                        @if($surveyResponse->persepsi_answers)
                            <div class="bg-gray-50 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                                <div class="px-6 py-4 bg-gray-100 border-b border-gray-200">
                                    <h3 class="text-lg font-medium text-gray-900">Jawaban Kinerja (Persepsi)</h3>
                                </div>
                                <div class="p-6">
                                    @foreach($questionLabels['persepsi_answers'] as $dimension => $questions)
                                        <h5 class="text-lg font-semibold text-green-600 mb-3">{{ ucfirst($dimension) }}</h5>
                                        <div class="overflow-x-auto mb-6">
                                            <table class="min-w-full divide-y divide-gray-200">
                                                <thead class="bg-gray-50">
                                                    <tr>
                                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pertanyaan</th>
                                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jawaban</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="bg-white divide-y divide-gray-200">
                                                    @foreach($questions as $key => $question)
                                                        <tr>
                                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $question }}</td>
                                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                                @php
                                                                    $answer = $surveyResponse->persepsi_answers[$dimension][$key] ?? null;
                                                                @endphp
                                                                @if($answer)
                                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                                        {{ $answer }}/5
                                                                    </span>
                                                                @else
                                                                    <span class="text-gray-400">-</span>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <!-- Kepuasan Answers -->
                        @if($surveyResponse->kepuasan_answers)
                            <div class="bg-gray-50 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                                <div class="px-6 py-4 bg-gray-100 border-b border-gray-200">
                                    <h3 class="text-lg font-medium text-gray-900">Jawaban Kepuasan (Kepuasan)</h3>
                                </div>
                                <div class="p-6">
                                    <div class="overflow-x-auto">
                                        <table class="min-w-full divide-y divide-gray-200">
                                            <thead class="bg-gray-50">
                                                <tr>
                                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pertanyaan</th>
                                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jawaban</th>
                                                </tr>
                                            </thead>
                                            <tbody class="bg-white divide-y divide-gray-200">
                                                @foreach($questionLabels['kepuasan_answers'] as $key => $question)
                                                    <tr>
                                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $question }}</td>
                                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                            @php
                                                                $answer = $surveyResponse->kepuasan_answers[$key] ?? null;
                                                            @endphp
                                                            @if($answer)
                                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                                                    {{ $answer }}/5
                                                                </span>
                                                            @else
                                                                <span class="text-gray-400">-</span>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- Loyalitas Answers -->
                        @if($surveyResponse->loyalitas_answers)
                            <div class="bg-gray-50 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                                <div class="px-6 py-4 bg-gray-100 border-b border-gray-200">
                                    <h3 class="text-lg font-medium text-gray-900">Jawaban Loyalitas (Loyalitas)</h3>
                                </div>
                                <div class="p-6">
                                    <div class="overflow-x-auto">
                                        <table class="min-w-full divide-y divide-gray-200">
                                            <thead class="bg-gray-50">
                                                <tr>
                                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pertanyaan</th>
                                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jawaban</th>
                                                </tr>
                                            </thead>
                                            <tbody class="bg-white divide-y divide-gray-200">
                                                @foreach($questionLabels['loyalitas_answers'] as $key => $question)
                                                    <tr>
                                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $question }}</td>
                                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                            @php
                                                                $answer = $surveyResponse->loyalitas_answers[$key] ?? null;
                                                            @endphp
                                                            @if($answer)
                                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                                    {{ $answer }}/5
                                                                </span>
                                                            @else
                                                                <span class="text-gray-400">-</span>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- Feedback Answers -->
                        @if($surveyResponse->feedback_answers)
                            <div class="bg-gray-50 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                                <div class="px-6 py-4 bg-gray-100 border-b border-gray-200">
                                    <h3 class="text-lg font-medium text-gray-900">Feedback dan Saran</h3>
                                </div>
                                <div class="p-6 space-y-6">
                                    @if(isset($surveyResponse->feedback_answers['kritik_saran']) && $surveyResponse->feedback_answers['kritik_saran'])
                                        <div>
                                            <h4 class="text-sm font-medium text-gray-900 mb-2">Kritik dan Saran</h4>
                                            <p class="text-sm text-gray-700 bg-gray-50 p-3 rounded">{{ $surveyResponse->feedback_answers['kritik_saran'] }}</p>
                                        </div>
                                    @endif

                                    @if(isset($surveyResponse->feedback_answers['tema_judul']) && $surveyResponse->feedback_answers['tema_judul'])
                                        <div>
                                            <h4 class="text-sm font-medium text-gray-900 mb-2">Tema/Judul Pelatihan yang Diinginkan</h4>
                                            <p class="text-sm text-gray-700 bg-gray-50 p-3 rounded">{{ $surveyResponse->feedback_answers['tema_judul'] }}</p>
                                        </div>
                                    @endif

                                    @if(isset($surveyResponse->feedback_answers['bentuk_pelatihan']))
                                        <div>
                                            <h4 class="text-sm font-medium text-gray-900 mb-2">Bentuk Pelatihan yang Diinginkan</h4>
                                            <div class="space-y-2">
                                                @foreach($surveyResponse->feedback_answers['bentuk_pelatihan'] as $option)
                                                    <div class="flex items-center">
                                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                                                            {{ $option }}
                                                        </span>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endif
                    @else
                        <div class="bg-yellow-50 border border-yellow-200 rounded-md p-4">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-yellow-800">Survei Belum Selesai</h3>
                                    <div class="mt-2 text-sm text-yellow-700">
                                        <p>Survei ini masih dalam status draft dan belum diisi lengkap.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
