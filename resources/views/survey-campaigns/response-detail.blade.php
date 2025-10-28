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
                        {{ __('Detail Respons') }}
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

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            {{-- Responden Info Card --}}
            <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
                <div class="flex items-start justify-between mb-6">
                    <div class="flex items-start gap-4">
                        <div class="flex-shrink-0 h-16 w-16 bg-indigo-100 rounded-full flex items-center justify-center">
                            <span class="text-indigo-600 font-bold text-xl">
                                {{ strtoupper(substr($response->nama, 0, 2)) }}
                            </span>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-gray-900 mb-1">{{ $response->nama }}</h3>
                            <div class="flex items-center gap-4 text-sm text-gray-600">
                                <span><i class="fas fa-venus-mars mr-1"></i> {{ $response->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }}</span>
                                @if($response->usia)
                                    <span><i class="fas fa-birthday-cake mr-1"></i> {{ $response->usia }} tahun</span>
                                @endif
                                @if($response->pekerjaan)
                                    <span><i class="fas fa-briefcase mr-1"></i> {{ $response->pekerjaan }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <span class="px-3 py-1 text-sm font-medium rounded-full bg-green-100 text-green-800">
                        <i class="fas fa-check-circle mr-1"></i> Selesai
                    </span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 pt-4 border-t border-gray-200">
                    <div class="flex items-center gap-3">
                        <div class="bg-blue-100 rounded-lg p-2">
                            <i class="fas fa-envelope text-blue-600"></i>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500">Email</p>
                            <p class="text-sm font-medium text-gray-900">{{ $response->email ?? '-' }}</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="bg-green-100 rounded-lg p-2">
                            <i class="fas fa-phone text-green-600"></i>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500">Nomor HP</p>
                            <p class="text-sm font-medium text-gray-900">{{ $response->nomor_hp ?? '-' }}</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="bg-purple-100 rounded-lg p-2">
                            <i class="fas fa-calendar text-purple-600"></i>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500">Waktu Submit</p>
                            <p class="text-sm font-medium text-gray-900">{{ $response->created_at->format('d M Y, H:i') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Answers Detail --}}
            <div class="space-y-6">
                {{-- Harapan Section --}}
                @if($response->harapan_answers && count($harapanQuestions) > 0)
                    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                        <div class="bg-gradient-to-r from-yellow-500 to-yellow-600 px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="bg-white bg-opacity-20 rounded-lg p-2">
                                    <i class="fas fa-star text-white"></i>
                                </div>
                                <h3 class="text-lg font-bold text-white">Harapan Pelanggan</h3>
                            </div>
                        </div>
                        <div class="p-6">
                            @foreach($harapanQuestions as $category => $questions)
                                <h4 class="text-md font-semibold text-gray-800 mb-3 mt-4 first:mt-0">{{ ucfirst($category) }}</h4>
                                @foreach($questions as $key => $question)
                                    <div class="mb-4 last:mb-0 pb-4 last:pb-0 border-b last:border-b-0 border-gray-200">
                                        <div class="flex items-start gap-3">
                                            <div class="flex-1">
                                                <p class="text-sm font-medium text-gray-900 mb-2">{{ $question }}</p>
                                                @php
                                                    $answer = $response->harapan_answers[$category][$key] ?? null;
                                                @endphp
                                                @if($answer)
                                                    <div class="bg-yellow-50 rounded-lg p-3">
                                                        <div class="flex items-center justify-between">
                                                            <span class="text-yellow-900 font-medium">Nilai: {{ $answer }}</span>
                                                            <div class="flex items-center gap-1">
                                                                @for($i = 1; $i <= 5; $i++)
                                                                    <i class="fas fa-star text-{{ $i <= (int)$answer ? 'yellow-500' : 'gray-300' }}"></i>
                                                                @endfor
                                                            </div>
                                                        </div>
                                                    </div>
                                                @else
                                                    <p class="text-sm text-gray-400 italic">Tidak dijawab</p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- Persepsi Section --}}
                @if($response->persepsi_answers && count($persepsiQuestions) > 0)
                    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                        <div class="bg-gradient-to-r from-blue-500 to-blue-600 px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="bg-white bg-opacity-20 rounded-lg p-2">
                                    <i class="fas fa-chart-bar text-white"></i>
                                </div>
                                <h3 class="text-lg font-bold text-white">Persepsi/Kinerja</h3>
                            </div>
                        </div>
                        <div class="p-6">
                            @foreach($persepsiQuestions as $category => $questions)
                                <h4 class="text-md font-semibold text-gray-800 mb-3 mt-4 first:mt-0">{{ ucfirst($category) }}</h4>
                                @foreach($questions as $key => $question)
                                    <div class="mb-4 last:mb-0 pb-4 last:pb-0 border-b last:border-b-0 border-gray-200">
                                        <div class="flex items-start gap-3">
                                            <div class="flex-1">
                                                <p class="text-sm font-medium text-gray-900 mb-2">{{ $question }}</p>
                                                @php
                                                    $answer = $response->persepsi_answers[$category][$key] ?? null;
                                                @endphp
                                                @if($answer)
                                                    <div class="bg-blue-50 rounded-lg p-3">
                                                        <div class="flex items-center justify-between">
                                                            <span class="text-blue-900 font-medium">Nilai: {{ $answer }}</span>
                                                            <div class="flex items-center gap-1">
                                                                @for($i = 1; $i <= 5; $i++)
                                                                    <i class="fas fa-star text-{{ $i <= (int)$answer ? 'blue-500' : 'gray-300' }}"></i>
                                                                @endfor
                                                            </div>
                                                        </div>
                                                    </div>
                                                @else
                                                    <p class="text-sm text-gray-400 italic">Tidak dijawab</p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- Kepuasan Section --}}
                @if($response->kepuasan_answers && count($kepuasanQuestions) > 0)
                    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                        <div class="bg-gradient-to-r from-green-500 to-green-600 px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="bg-white bg-opacity-20 rounded-lg p-2">
                                    <i class="fas fa-smile text-white"></i>
                                </div>
                                <h3 class="text-lg font-bold text-white">Kepuasan Pelanggan</h3>
                            </div>
                        </div>
                        <div class="p-6">
                            @foreach($kepuasanQuestions as $key => $question)
                                <div class="mb-4 last:mb-0 pb-4 last:pb-0 border-b last:border-b-0 border-gray-200">
                                    <div class="flex items-start gap-3">
                                        <div class="flex-1">
                                            <p class="text-sm font-medium text-gray-900 mb-2">{{ $question }}</p>
                                            @php
                                                $answer = $response->kepuasan_answers[$key] ?? null;
                                            @endphp
                                            @if($answer)
                                                <div class="bg-green-50 rounded-lg p-3">
                                                    <div class="flex items-center justify-between">
                                                        <span class="text-green-900 font-medium">Nilai: {{ $answer }}</span>
                                                        <div class="flex items-center gap-1">
                                                            @for($i = 1; $i <= 5; $i++)
                                                                <i class="fas fa-star text-{{ $i <= (int)$answer ? 'green-500' : 'gray-300' }}"></i>
                                                            @endfor
                                                        </div>
                                                    </div>
                                                </div>
                                            @else
                                                <p class="text-sm text-gray-400 italic">Tidak dijawab</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- Loyalitas Section --}}
                @if($response->loyalitas_answers && count($loyaltyQuestions) > 0)
                    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                        <div class="bg-gradient-to-r from-red-500 to-red-600 px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="bg-white bg-opacity-20 rounded-lg p-2">
                                    <i class="fas fa-heart text-white"></i>
                                </div>
                                <h3 class="text-lg font-bold text-white">Loyalitas Pelanggan</h3>
                            </div>
                        </div>
                        <div class="p-6">
                            @foreach($loyaltyQuestions as $key => $question)
                                <div class="mb-4 last:mb-0 pb-4 last:pb-0 border-b last:border-b-0 border-gray-200">
                                    <div class="flex items-start gap-3">
                                        <div class="flex-1">
                                            <p class="text-sm font-medium text-gray-900 mb-2">{{ $question }}</p>
                                            @php
                                                $answer = $response->loyalitas_answers[$key] ?? null;
                                            @endphp
                                            @if($answer)
                                                <div class="bg-red-50 rounded-lg p-3">
                                                    <div class="flex items-center justify-between">
                                                        <span class="text-red-900 font-medium">Nilai: {{ $answer }}</span>
                                                        <div class="flex items-center gap-1">
                                                            @for($i = 1; $i <= 5; $i++)
                                                                <i class="fas fa-star text-{{ $i <= (int)$answer ? 'red-500' : 'gray-300' }}"></i>
                                                            @endfor
                                                        </div>
                                                    </div>
                                                </div>
                                            @else
                                                <p class="text-sm text-gray-400 italic">Tidak dijawab</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- Feedback Section --}}
                @if($response->kritik_saran)
                    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                        <div class="bg-gradient-to-r from-purple-500 to-purple-600 px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="bg-white bg-opacity-20 rounded-lg p-2">
                                    <i class="fas fa-comments text-white"></i>
                                </div>
                                <h3 class="text-lg font-bold text-white">Kritik & Saran</h3>
                            </div>
                        </div>
                        <div class="p-6">
                            <div class="bg-purple-50 rounded-lg p-4">
                                <p class="text-sm text-gray-700 leading-relaxed">{{ $response->kritik_saran }}</p>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            {{-- Action Buttons --}}
            <div class="mt-6 flex items-center justify-between">
                <a href="{{ route('survey-campaigns.responses', $campaign) }}" 
                   class="inline-flex items-center gap-2 text-gray-600 hover:text-gray-900 transition">
                    <i class="fas fa-arrow-left"></i>
                    <span>Kembali ke Daftar Respons</span>
                </a>
                <a href="{{ route('survey-campaigns.export', $campaign) }}" 
                   class="inline-flex items-center gap-2 bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg transition">
                    <i class="fas fa-download"></i>
                    <span>Export Semua Data</span>
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
