<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <div class="flex items-center gap-3 mb-1">
                    <a href="{{ route('survey-campaigns.index') }}" 
                       class="text-gray-400 hover:text-gray-600 transition">
                        <i class="fas fa-arrow-left"></i>
                    </a>
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                        {{ __('Dashboard Kampanye') }}
                    </h2>
                </div>
                <p class="text-sm text-gray-600 ml-8">
                    {{ $campaign->name }}
                </p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('survey-campaigns.responses', $campaign) }}" 
                   class="inline-flex items-center gap-2 bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg transition">
                    <i class="fas fa-list"></i>
                    <span>Semua Respons</span>
                </a>
                <a href="{{ route('survey-campaigns.export', $campaign) }}" 
                   class="inline-flex items-center gap-2 bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition">
                    <i class="fas fa-download"></i>
                    <span>Export</span>
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            {{-- Campaign Info Card --}}
            <div class="bg-gradient-to-r from-{{ $campaign->getTypeBadgeColor() }}-500 to-{{ $campaign->getTypeBadgeColor() }}-600 rounded-xl shadow-lg p-6 mb-8 text-white">
                <div class="flex items-start justify-between">
                    <div class="flex items-start gap-4">
                        <div class="flex-shrink-0 bg-white bg-opacity-20 rounded-lg p-4">
                            <i class="fas {{ $campaign->getTypeIcon() }} text-white text-3xl"></i>
                        </div>
                        <div>
                            <div class="flex items-center gap-3 mb-2">
                                <h3 class="text-2xl font-bold">{{ $campaign->name }}</h3>
                                <span class="px-3 py-1 text-sm font-medium rounded-full bg-white bg-opacity-20">
                                    {{ ucfirst($campaign->status) }}
                                </span>
                            </div>
                            @if($campaign->description)
                                <p class="text-white text-opacity-90 mb-3">{{ $campaign->description }}</p>
                            @endif
                            <div class="flex items-center gap-6 text-sm">
                                <span><i class="fas fa-calendar mr-2"></i>{{ $campaign->start_date->format('d M Y') }} - {{ $campaign->end_date->format('d M Y') }}</span>
                                @if($campaign->max_respondents)
                                    <span><i class="fas fa-users mr-2"></i>Target: {{ $campaign->max_respondents }} responden</span>
                                @endif
                                <span><i class="fas fa-clock mr-2"></i>{{ $campaign->days_remaining }} hari tersisa</span>
                            </div>
                        </div>
                    </div>
                    <button onclick="copyLink('{{ $campaign->public_url }}')" 
                            class="bg-white text-{{ $campaign->getTypeBadgeColor() }}-600 px-4 py-2 rounded-lg hover:bg-opacity-90 transition">
                        <i class="fas fa-copy mr-2"></i>Copy Link
                    </button>
                </div>
            </div>

            {{-- Stats Overview --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                {{-- Total Respons --}}
                <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-blue-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Total Respons</p>
                            <p class="text-3xl font-bold text-gray-900">{{ $totalResponses }}</p>
                            @if($campaign->max_respondents)
                                <p class="text-sm text-blue-600 mt-1">
                                    <i class="fas fa-chart-pie mr-1"></i>
                                    {{ number_format($campaign->progress_percentage, 1) }}% dari target
                                </p>
                            @else
                                <p class="text-sm text-green-600 mt-1">
                                    <i class="fas fa-infinity mr-1"></i>
                                    Tanpa batas
                                </p>
                            @endif
                        </div>
                        <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-file-alt text-blue-600 text-xl"></i>
                        </div>
                    </div>
                </div>

                {{-- Hari Ini --}}
                <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-green-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Respons Hari Ini</p>
                            <p class="text-3xl font-bold text-gray-900">{{ $todayCount }}</p>
                            <p class="text-sm text-green-600 mt-1">
                                <i class="fas fa-calendar-day mr-1"></i>
                                {{ now()->format('d M Y') }}
                            </p>
                        </div>
                        <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-calendar-day text-green-600 text-xl"></i>
                        </div>
                    </div>
                </div>

                {{-- Minggu Ini --}}
                <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-purple-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Minggu Ini</p>
                            <p class="text-3xl font-bold text-gray-900">{{ $weekCount }}</p>
                            <p class="text-sm text-purple-600 mt-1">
                                <i class="fas fa-calendar-week mr-1"></i>
                                7 hari terakhir
                            </p>
                        </div>
                        <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-calendar-week text-purple-600 text-xl"></i>
                        </div>
                    </div>
                </div>

                {{-- Rata-rata Kepuasan --}}
                <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-yellow-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Rata-rata Kepuasan</p>
                            <p class="text-3xl font-bold text-gray-900">
                                {{ $results['kepuasan_pelanggan']['overall_mean'] ?? 0 }}
                            </p>
                            <p class="text-sm text-yellow-600 mt-1">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="fas fa-star {{ $i <= round($results['kepuasan_pelanggan']['overall_mean'] ?? 0) ? 'text-yellow-500' : 'text-gray-300' }}"></i>
                                @endfor
                            </p>
                        </div>
                        <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-smile text-yellow-600 text-xl"></i>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Progress Chart & Recent Responses --}}
            <div class="grid lg:grid-cols-3 gap-8 mb-8">
                {{-- Recent Responses --}}
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-xl shadow-lg p-6">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-xl font-bold text-gray-900">Respons Terbaru</h3>
                            <a href="{{ route('survey-campaigns.responses', $campaign) }}"
                                class="text-sm text-blue-600 hover:text-blue-800 font-medium">
                                Lihat Semua
                            </a>
                        </div>

                        <div class="space-y-4">
                            @forelse($recentResponses as $response)
                                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-10 h-10 rounded-full flex items-center justify-center bg-indigo-100">
                                            <span class="text-indigo-600 font-medium text-sm">
                                                {{ strtoupper(substr($response->nama, 0, 2)) }}
                                            </span>
                                        </div>
                                        <div>
                                            <p class="font-medium text-gray-900">{{ $response->nama }}</p>
                                            <p class="text-sm text-gray-600">
                                                {{ $response->email ?? $response->nomor_hp ?? 'N/A' }} •
                                                {{ $response->created_at->diffForHumans() }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        <span class="px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded-full">
                                            <i class="fas fa-check-circle mr-1"></i>Selesai
                                        </span>
                                        <a href="{{ route('survey-campaigns.response-detail', [$campaign, $response]) }}"
                                            class="text-blue-600 hover:text-blue-800">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-8">
                                    <i class="fas fa-inbox text-gray-400 text-3xl mb-4"></i>
                                    <p class="text-gray-600">Belum ada respons</p>
                                    <button onclick="copyLink('{{ $campaign->public_url }}')" 
                                            class="mt-4 inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-3 rounded-lg transition">
                                        <i class="fas fa-copy"></i>
                                        <span>Copy Link Survei</span>
                                    </button>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                {{-- Campaign Stats --}}
                <div>
                    <div class="bg-white rounded-xl shadow-lg p-6 mb-6">
                        <h3 class="text-xl font-bold text-gray-900 mb-6">Status Kampanye</h3>

                        <div class="space-y-4">
                            {{-- Progress Bar --}}
                            @if($campaign->max_respondents)
                                <div>
                                    <div class="flex justify-between text-sm mb-2">
                                        <span class="text-gray-600">Progress</span>
                                        <span class="font-medium">{{ number_format($campaign->progress_percentage, 1) }}%</span>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-3">
                                        <div class="bg-gradient-to-r from-blue-500 to-indigo-600 h-3 rounded-full transition-all duration-500" 
                                             style="width: {{ $campaign->progress_percentage }}%"></div>
                                    </div>
                                    <p class="text-xs text-gray-500 mt-2">
                                        {{ $totalResponses }} / {{ $campaign->max_respondents }} responden
                                    </p>
                                </div>
                            @endif

                            {{-- Days Remaining --}}
                            <div class="bg-blue-50 rounded-lg p-4">
                                <div class="flex items-center justify-between">
                                    <span class="text-sm font-medium text-gray-700">Waktu Tersisa</span>
                                    <span class="text-lg font-bold text-blue-600">{{ $campaign->days_remaining }} hari</span>
                                </div>
                            </div>

                            {{-- Status --}}
                            <div class="bg-{{ $campaign->getStatusBadgeColor() }}-50 rounded-lg p-4">
                                <div class="flex items-center justify-between">
                                    <span class="text-sm font-medium text-gray-700">Status</span>
                                    <span class="text-sm font-bold text-{{ $campaign->getStatusBadgeColor() }}-600">
                                        {{ ucfirst($campaign->status) }}
                                    </span>
                                </div>
                            </div>

                            {{-- Public URL --}}
                            <div class="pt-4 border-t border-gray-200">
                                <p class="text-sm font-medium text-gray-700 mb-2">Link Survei Publik</p>
                                <div class="flex items-center gap-2">
                                    <input type="text" 
                                           value="{{ $campaign->public_url }}" 
                                           readonly
                                           class="flex-1 px-3 py-2 bg-gray-50 border border-gray-300 rounded-lg text-sm">
                                    <button onclick="copyLink('{{ $campaign->public_url }}')" 
                                            class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg transition">
                                        <i class="fas fa-copy"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Charts & Analytics --}}
            @if($totalResponses > 0)
                <div class="bg-white rounded-xl shadow-lg p-6 mb-8">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-xl font-bold text-gray-900">Analisis Hasil Survei</h3>
                    </div>

                    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                        {{-- Kepuasan Pelanggan --}}
                        <div class="bg-gradient-to-br from-green-50 to-green-100 p-6 rounded-lg">
                            <div class="flex items-center justify-between mb-4">
                                <h4 class="font-semibold text-gray-900">Kepuasan Pelanggan</h4>
                                <i class="fas fa-smile text-green-600 text-xl"></i>
                            </div>
                            <div class="text-3xl font-bold text-green-600 mb-2">
                                {{ $results['kepuasan_pelanggan']['overall_mean'] ?? 0 }}
                            </div>
                            <p class="text-sm text-gray-600">dari 5.0 skala</p>
                            <div class="mt-3 bg-green-200 rounded-full h-2">
                                <div class="bg-green-600 h-2 rounded-full"
                                    style="width: {{ ($results['kepuasan_pelanggan']['overall_mean'] ?? 0) / 5 * 100 }}%"></div>
                            </div>
                        </div>

                        {{-- Harapan --}}
                        <div class="bg-gradient-to-br from-yellow-50 to-yellow-100 p-6 rounded-lg">
                            <div class="flex items-center justify-between mb-4">
                                <h4 class="font-semibold text-gray-900">Harapan Pelanggan</h4>
                                <i class="fas fa-star text-yellow-600 text-xl"></i>
                            </div>
                            <div class="text-3xl font-bold text-yellow-600 mb-2">
                                {{ $results['harapan']['overall_mean'] ?? 0 }}
                            </div>
                            <p class="text-sm text-gray-600">dari 5.0 skala</p>
                            <div class="mt-3 bg-yellow-200 rounded-full h-2">
                                <div class="bg-yellow-600 h-2 rounded-full"
                                    style="width: {{ ($results['harapan']['overall_mean'] ?? 0) / 5 * 100 }}%"></div>
                            </div>
                        </div>

                        {{-- Persepsi --}}
                        <div class="bg-gradient-to-br from-blue-50 to-blue-100 p-6 rounded-lg">
                            <div class="flex items-center justify-between mb-4">
                                <h4 class="font-semibold text-gray-900">Persepsi/Kinerja</h4>
                                <i class="fas fa-chart-bar text-blue-600 text-xl"></i>
                            </div>
                            <div class="text-3xl font-bold text-blue-600 mb-2">
                                {{ $results['persepsi']['overall_mean'] ?? 0 }}
                            </div>
                            <p class="text-sm text-gray-600">dari 5.0 skala</p>
                            <div class="mt-3 bg-blue-200 rounded-full h-2">
                                <div class="bg-blue-600 h-2 rounded-full"
                                    style="width: {{ ($results['persepsi']['overall_mean'] ?? 0) / 5 * 100 }}%"></div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Gap Analysis --}}
                @if(isset($results['gap_analysis']) && count($results['gap_analysis']['dimensions']) > 0)
                    <div class="bg-white rounded-xl shadow-lg p-6">
                        <h3 class="text-xl font-bold text-gray-900 mb-6">Gap Analysis per Dimensi</h3>
                        
                        <div class="space-y-4">
                            @foreach($results['gap_analysis']['dimensions'] as $dimension)
                                <div class="border-l-4 border-indigo-500 bg-gray-50 p-4 rounded-r-lg">
                                    <div class="flex items-center justify-between mb-2">
                                        <h4 class="font-semibold text-gray-900">{{ $dimension['name'] }}</h4>
                                        <span class="text-sm font-medium px-3 py-1 rounded-full 
                                            {{ $dimension['gap'] < 0 ? 'bg-red-100 text-red-700' : 'bg-green-100 text-green-700' }}">
                                            Gap: {{ number_format($dimension['gap'], 2) }}
                                        </span>
                                    </div>
                                    <div class="grid grid-cols-2 gap-4 text-sm">
                                        <div>
                                            <span class="text-gray-600">Harapan:</span>
                                            <span class="font-medium ml-2">{{ number_format($dimension['harapan_mean'], 2) }}</span>
                                        </div>
                                        <div>
                                            <span class="text-gray-600">Persepsi:</span>
                                            <span class="font-medium ml-2">{{ number_format($dimension['persepsi_mean'], 2) }}</span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            @else
                {{-- Empty State --}}
                <div class="bg-white rounded-xl shadow-lg p-12 text-center">
                    <div class="inline-flex items-center justify-center w-20 h-20 bg-gray-100 rounded-full mb-6">
                        <i class="fas fa-chart-line text-gray-400 text-3xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Belum Ada Data Analisis</h3>
                    <p class="text-gray-600 mb-6">
                        Analisis akan muncul setelah ada responden yang mengisi survei.
                    </p>
                    <button onclick="copyLink('{{ $campaign->public_url }}')" 
                            class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white px-8 py-3 rounded-lg transition">
                        <i class="fas fa-share-alt"></i>
                        <span>Bagikan Link Survei</span>
                    </button>
                </div>
            @endif
        </div>
    </div>

    {{-- Toast Notification --}}
    <div id="toast" class="fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg hidden items-center gap-2 z-50">
        <i class="fas fa-check-circle"></i>
        <span id="toastMessage">Link berhasil disalin!</span>
    </div>

    @push('scripts')
    <script>
        function copyLink(url) {
            navigator.clipboard.writeText(url).then(() => {
                showToast('Link survei berhasil disalin!');
            });
        }

        function showToast(message) {
            const toast = document.getElementById('toast');
            const toastMessage = document.getElementById('toastMessage');
            toastMessage.textContent = message;
            toast.classList.remove('hidden');
            toast.classList.add('flex');
            
            setTimeout(() => {
                toast.classList.add('hidden');
                toast.classList.remove('flex');
            }, 3000);
        }
    </script>
    @endpush
</x-app-layout>
