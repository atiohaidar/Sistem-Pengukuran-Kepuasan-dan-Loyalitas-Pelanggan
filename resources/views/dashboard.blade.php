<x-app-layout title="Dashboard - Survei Kepuasan">
    <div class="min-h-screen bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50">
        <!-- Header -->
        <div class="bg-white shadow-lg">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center py-6">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900">Dashboard</h1>
                        <p class="text-gray-600 mt-1">Ringkasan Sistem Pengukuran Kepuasan dan Loyalitas</p>
                    </div>
                    <div class="flex items-center space-x-4">
                        <div class="text-right">
                            <p class="text-sm text-gray-600">Selamat datang,</p>
                            <p class="text-lg font-semibold text-gray-900">{{ Auth::user()->name }}</p>
                        </div>
                        <div
                            class="w-12 h-12 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-full flex items-center justify-center">
                            <i class="fas fa-user text-white text-lg"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <!-- Stats Overview -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
                <!-- Total Survei Pelatihan -->
                <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-blue-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Survei Pelatihan</p>
                            <p class="text-3xl font-bold text-gray-900">
                                {{ \App\Models\PelatihanSurveyResponse::whereNotNull('completed_at')->count() }}</p>
                            <p class="text-sm text-green-600 mt-1">
                                <i class="fas fa-graduation-cap mr-1"></i>
                                Completed
                            </p>
                        </div>
                        <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-graduation-cap text-blue-600 text-xl"></i>
                        </div>
                    </div>
                    <div class="mt-4">
                        <a href="{{ route('dashboard.survey-management.index', ['type' => 'pelatihan']) }}"
                            class="text-sm text-blue-600 hover:text-blue-800 font-medium">
                            Lihat Detail <i class="fas fa-arrow-right ml-1"></i>
                        </a>
                    </div>
                </div>

                <!-- Total Survei Produk -->
                <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-indigo-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Survei Produk</p>
                            <p class="text-3xl font-bold text-gray-900">
                                {{ \App\Models\ProdukSurveyResponse::whereNotNull('completed_at')->count() }}</p>
                            <p class="text-sm text-green-600 mt-1">
                                <i class="fas fa-box-open mr-1"></i>
                                Completed
                            </p>
                        </div>
                        <div class="w-12 h-12 bg-indigo-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-box-open text-indigo-600 text-xl"></i>
                        </div>
                    </div>
                    <div class="mt-4">
                        <a href="{{ route('dashboard.survey-management.index', ['type' => 'produk']) }}"
                            class="text-sm text-indigo-600 hover:text-indigo-800 font-medium">
                            Lihat Detail <i class="fas fa-arrow-right ml-1"></i>
                        </a>
                    </div>
                </div>

                <!-- Total Responden -->
                <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-green-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Total Responden</p>
                            <p class="text-3xl font-bold text-gray-900">
                                {{ \App\Models\PelatihanSurveyResponse::whereNotNull('completed_at')->count() + \App\Models\ProdukSurveyResponse::whereNotNull('completed_at')->count() }}
                            </p>
                            <p class="text-sm text-green-600 mt-1">
                                <i class="fas fa-users mr-1"></i>
                                Aktif
                            </p>
                        </div>
                        <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-users text-green-600 text-xl"></i>
                        </div>
                    </div>
                    <div class="mt-4">
                        <a href="{{ route('dashboard.customer-evaluation-management.index') }}"
                            class="text-sm text-green-600 hover:text-green-800 font-medium">
                            Kelola Data <i class="fas fa-arrow-right ml-1"></i>
                        </a>
                    </div>
                </div>

                <!-- Rata-rata Kepuasan -->
                <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-purple-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Rata-rata Kepuasan</p>
                            <p class="text-3xl font-bold text-gray-900">
                                @php
                                    $totalKepuasan = 0;
                                    $countKepuasan = 0;

                                    // Hitung rata-rata dari PelatihanSurveyResponse
                                    $pelatihanCompleted = \App\Models\PelatihanSurveyResponse::whereNotNull('completed_at')->get();
                                    foreach ($pelatihanCompleted as $survey) {
                                        if ($survey->kepuasan_answers) {
                                            foreach ($survey->kepuasan_answers as $answer) {
                                                $totalKepuasan += $answer;
                                                $countKepuasan++;
                                            }
                                        }
                                    }

                                    // Hitung rata-rata dari ProdukSurveyResponse
                                    $produkCompleted = \App\Models\ProdukSurveyResponse::whereNotNull('completed_at')->get();
                                    foreach ($produkCompleted as $survey) {
                                        if ($survey->kepuasan_answers) {
                                            foreach ($survey->kepuasan_answers as $answer) {
                                                $totalKepuasan += $answer;
                                                $countKepuasan++;
                                            }
                                        }
                                    }

                                    $avgRating = $countKepuasan > 0 ? round($totalKepuasan / $countKepuasan, 1) : 0;
                                @endphp
                                {{ $avgRating }}
                            </p>
                            <p class="text-sm text-purple-600 mt-1">
                                <i class="fas fa-star mr-1"></i>
                                dari 5.0 ({{ $countKepuasan }} jawaban)
                            </p>
                        </div>
                        <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-star text-purple-600 text-xl"></i>
                        </div>
                    </div>
                    <div class="mt-4">
                        <a href="{{ route('grafik.mean-gap-per-dimensi') }}"
                            class="text-sm text-purple-600 hover:text-purple-800 font-medium">
                            Lihat Analisis <i class="fas fa-arrow-right ml-1"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Recent Activity & Quick Actions -->
            <div class="grid lg:grid-cols-3 gap-8 mb-12">
                <!-- Recent Surveys -->
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-xl shadow-lg p-6">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-xl font-bold text-gray-900">Survei Terbaru</h3>
                            <a href="{{ route('dashboard.survey-management.index', ['type' => 'pelatihan']) }}"
                                class="text-sm text-blue-600 hover:text-blue-800 font-medium">
                                Lihat Semua
                            </a>
                        </div>

                        <div class="space-y-4">
                            @php
                                $recentPelatihan = \App\Models\PelatihanSurveyResponse::whereNotNull('completed_at')
                                    ->orderBy('completed_at', 'desc')
                                    ->take(3)
                                    ->get();
                                $recentProduk = \App\Models\ProdukSurveyResponse::whereNotNull('completed_at')
                                    ->orderBy('completed_at', 'desc')
                                    ->take(3)
                                    ->get();
                                $recentSurveys = $recentPelatihan->concat($recentProduk)->sortByDesc('completed_at')->take(5);
                            @endphp

                            @forelse($recentSurveys as $survey)
                                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                    <div class="flex items-center space-x-3">
                                        <div
                                            class="w-10 h-10 rounded-full flex items-center justify-center {{ $survey instanceof \App\Models\PelatihanSurveyResponse ? 'bg-blue-100' : 'bg-indigo-100' }}">
                                            <i
                                                class="fas {{ $survey instanceof \App\Models\PelatihanSurveyResponse ? 'fa-graduation-cap text-blue-600' : 'fa-box-open text-indigo-600' }}"></i>
                                        </div>
                                        <div>
                                            <p class="font-medium text-gray-900">
                                                Survei
                                                {{ $survey instanceof \App\Models\PelatihanSurveyResponse ? 'Pelatihan' : 'Produk' }}
                                            </p>
                                            <p class="text-sm text-gray-600">
                                                {{ $survey->profile_data['email'] ?? 'N/A' }} •
                                                {{ $survey->completed_at ? $survey->completed_at->diffForHumans() : 'N/A' }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        <span
                                            class="px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded-full">
                                            Completed
                                        </span>
                                        <a href="{{ route('dashboard.survey-management.show', ['type' => ($survey instanceof \App\Models\PelatihanSurveyResponse ? 'pelatihan' : 'produk'), 'id' => $survey->id]) }}"
                                            class="text-blue-600 hover:text-blue-800">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-8">
                                    <i class="fas fa-inbox text-gray-400 text-3xl mb-4"></i>
                                    <p class="text-gray-600">Belum ada survei yang completed</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div>
                    <div class="bg-white rounded-xl shadow-lg p-6">
                        <h3 class="text-xl font-bold text-gray-900 mb-6">Aksi Cepat</h3>

                        <div class="space-y-3">
                            <a href="{{ route('survey.index', ['type' => 'pelatihan']) }}"
                                class="flex items-center justify-between w-full p-4 bg-gradient-to-r from-blue-50 to-blue-100 hover:from-blue-100 hover:to-blue-200 rounded-lg transition-all duration-200 group">
                                <div class="flex items-center space-x-3">
                                    <div class="w-8 h-8 bg-blue-500 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-graduation-cap text-white text-sm"></i>
                                    </div>
                                    <span class="font-medium text-gray-900">Survei Pelatihan</span>
                                </div>
                                <i
                                    class="fas fa-arrow-right text-blue-600 group-hover:translate-x-1 transition-transform"></i>
                            </a>

                            <a href="{{ route('survey.index', ['type' => 'produk']) }}"
                                class="flex items-center justify-between w-full p-4 bg-gradient-to-r from-indigo-50 to-indigo-100 hover:from-indigo-100 hover:to-indigo-200 rounded-lg transition-all duration-200 group">
                                <div class="flex items-center space-x-3">
                                    <div class="w-8 h-8 bg-indigo-500 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-box-open text-white text-sm"></i>
                                    </div>
                                    <span class="font-medium text-gray-900">Survei Produk</span>
                                </div>
                                <i
                                    class="fas fa-arrow-right text-indigo-600 group-hover:translate-x-1 transition-transform"></i>
                            </a>

                            <a href="{{ route('grafik.mean-gap-per-dimensi') }}"
                                class="flex items-center justify-between w-full p-4 bg-gradient-to-r from-green-50 to-green-100 hover:from-green-100 hover:to-green-200 rounded-lg transition-all duration-200 group">
                                <div class="flex items-center space-x-3">
                                    <div class="w-8 h-8 bg-green-500 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-chart-bar text-white text-sm"></i>
                                    </div>
                                    <span class="font-medium text-gray-900">Lihat Analitik</span>
                                </div>
                                <i
                                    class="fas fa-arrow-right text-green-600 group-hover:translate-x-1 transition-transform"></i>
                            </a>

                            <a href="{{ route('dashboard.customer-evaluation-management.index') }}"
                                class="flex items-center justify-between w-full p-4 bg-gradient-to-r from-purple-50 to-purple-100 hover:from-purple-100 hover:to-purple-200 rounded-lg transition-all duration-200 group">
                                <div class="flex items-center space-x-3">
                                    <div class="w-8 h-8 bg-purple-500 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-users text-white text-sm"></i>
                                    </div>
                                    <span class="font-medium text-gray-900">Evaluasi Pelanggan</span>
                                </div>
                                <i
                                    class="fas fa-arrow-right text-purple-600 group-hover:translate-x-1 transition-transform"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Charts Preview -->
            <div class="bg-white rounded-xl shadow-lg p-6 mb-8">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-xl font-bold text-gray-900">Pratinjau Analisis</h3>
                    <a href="{{ route('grafik.mean-gap-per-dimensi') }}"
                        class="text-sm text-blue-600 hover:text-blue-800 font-medium">
                        Lihat Lengkap
                    </a>
                </div>

                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <!-- Kepuasan Overview -->
                    <div class="bg-gradient-to-br from-blue-50 to-blue-100 p-6 rounded-lg">
                        <div class="flex items-center justify-between mb-4">
                            <h4 class="font-semibold text-gray-900">Kepuasan Pelanggan</h4>
                            <i class="fas fa-smile text-blue-600 text-xl"></i>
                        </div>
                        <div class="text-3xl font-bold text-blue-600 mb-2">{{ $avgRating }}</div>
                        <p class="text-sm text-gray-600">Rata-rata dari {{ $countKepuasan }} jawaban</p>
                        <div class="mt-3 bg-blue-200 rounded-full h-2">
                            <div class="bg-blue-600 h-2 rounded-full"
                                style="width: {{ $avgRating > 0 ? ($avgRating / 5) * 100 : 0 }}%"></div>
                        </div>
                    </div>

                    <!-- Response Rate -->
                    <div class="bg-gradient-to-br from-green-50 to-green-100 p-6 rounded-lg">
                        <div class="flex items-center justify-between mb-4">
                            <h4 class="font-semibold text-gray-900">Tingkat Response</h4>
                            <i class="fas fa-chart-line text-green-600 text-xl"></i>
                        </div>
                        @php
                            $totalStarted = \App\Models\PelatihanSurveyResponse::count() + \App\Models\ProdukSurveyResponse::count();
                            $totalCompleted = \App\Models\PelatihanSurveyResponse::whereNotNull('completed_at')->count() + \App\Models\ProdukSurveyResponse::whereNotNull('completed_at')->count();
                            $responseRate = $totalStarted > 0 ? round(($totalCompleted / $totalStarted) * 100, 1) : 0;
                        @endphp
                        <div class="text-3xl font-bold text-green-600 mb-2">{{ $responseRate }}%</div>
                        <p class="text-sm text-gray-600">{{ $totalCompleted }} dari {{ $totalStarted }} responden</p>
                        <div class="mt-3 bg-green-200 rounded-full h-2">
                            <div class="bg-green-600 h-2 rounded-full" style="width: {{ $responseRate }}%"></div>
                        </div>
                    </div>

                    <!-- Survey Distribution -->
                    <div class="bg-gradient-to-br from-purple-50 to-purple-100 p-6 rounded-lg">
                        <div class="flex items-center justify-between mb-4">
                            <h4 class="font-semibold text-gray-900">Distribusi Survei</h4>
                            <i class="fas fa-pie-chart text-purple-600 text-xl"></i>
                        </div>
                        <div class="space-y-2">
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-600">Pelatihan</span>
                                <span
                                    class="text-sm font-medium">{{ \App\Models\PelatihanSurveyResponse::whereNotNull('completed_at')->count() }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-600">Produk</span>
                                <span
                                    class="text-sm font-medium">{{ \App\Models\ProdukSurveyResponse::whereNotNull('completed_at')->count() }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>