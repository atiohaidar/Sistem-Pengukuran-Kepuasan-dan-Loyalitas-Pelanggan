<x-app-layout>
     <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Analisis Pelatihan') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gradient-to-br from-blue-50 to-indigo-100 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Header Section -->
            <div class="bg-white overflow-hidden shadow-2xl sm:rounded-2xl border-0 relative animate-fade-in mb-8">
                <div class="absolute inset-0 bg-gradient-to-r from-blue-500 via-purple-500 to-pink-500 rounded-2xl opacity-10"></div>
                <div class="relative bg-white sm:rounded-2xl p-8">
                    <div class="text-center">
                        <div class="flex items-center justify-center mb-6">
                            <div class="bg-gradient-to-r from-blue-500 to-purple-600 p-4 rounded-full shadow-lg">
                                <i class="fas fa-graduation-cap text-white text-3xl"></i>
                            </div>
                        </div>
                        <h1 class="text-4xl font-bold bg-gradient-to-r from-blue-600 via-purple-600 to-pink-600 bg-clip-text text-transparent mb-4">
                            Dashboard Analisis Pelatihan
                        </h1>
                        <p class="text-lg text-gray-600 max-w-3xl mx-auto leading-relaxed mb-6">
                            Akses berbagai analisis dan laporan terkait hasil survey kepuasan dan loyalitas pelanggan program pelatihan.
                        </p>

                        <!-- Quick Stats -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-8">
                            <div class="bg-gradient-to-r from-blue-50 to-blue-100 rounded-xl p-6 border border-blue-200">
                                <div class="text-center">
                                    <div class="text-3xl font-bold text-blue-600 mb-2">{{ $totalResponses }}</div>
                                    <div class="text-lg font-semibold text-gray-800 mb-1">Total Responden</div>
                                    <div class="text-sm text-gray-600">Jumlah responden survey</div>
                                </div>
                            </div>
                            <div class="bg-gradient-to-r from-green-50 to-green-100 rounded-xl p-6 border border-green-200">
                                <div class="text-center">
                                    <div class="text-3xl font-bold text-green-600 mb-2">{{ number_format($ikpPercentage, 1) }}%</div>
                                    <div class="text-lg font-semibold text-gray-800 mb-1">Indeks Kepuasan</div>
                                    <div class="text-sm text-gray-600">IKP rata-rata</div>
                                </div>
                            </div>
                            <div class="bg-gradient-to-r from-purple-50 to-purple-100 rounded-xl p-6 border border-purple-200">
                                <div class="text-center">
                                    <div class="text-3xl font-bold text-purple-600 mb-2">{{ number_format($ilpPercentage, 1) }}%</div>
                                    <div class="text-lg font-semibold text-gray-800 mb-1">Indeks Loyalitas</div>
                                    <div class="text-sm text-gray-600">ILP rata-rata</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Analysis Cards Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">

                <!-- Profil Responden Card -->
                <div class="bg-white overflow-hidden shadow-2xl sm:rounded-2xl border-0 relative group hover:transform hover:scale-105 transition-all duration-300 animate-fade-in">
                    <div class="absolute inset-0 bg-gradient-to-r from-blue-500 via-purple-500 to-pink-500 rounded-2xl opacity-20 group-hover:opacity-30 transition-opacity duration-300"></div>
                    <div class="relative bg-white sm:rounded-2xl p-8 h-full">
                        <div class="text-center">
                            <div class="bg-gradient-to-r from-blue-500 to-purple-600 p-4 rounded-full mx-auto mb-6 shadow-lg group-hover:shadow-xl transition-shadow duration-300">
                                <i class="fas fa-users text-white text-2xl"></i>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-800 mb-4">Profil Responden</h3>
                            <p class="text-gray-600 mb-8 leading-relaxed">
                                Analisis demografi responden berdasarkan usia, jenis kelamin, pekerjaan, dan domisili.
                                Memahami karakteristik peserta pelatihan secara menyeluruh.
                            </p>
                            <a href="{{ route('grafik.profil-responden') }}"
                               class="inline-flex items-center justify-center w-full px-6 py-3 bg-gradient-to-r from-blue-500 to-purple-600 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300 group-hover:from-blue-600 group-hover:to-purple-700">
                                <i class="fas fa-chart-bar mr-3"></i>
                                Lihat Analisis Profil
                                <i class="fas fa-arrow-right ml-3 group-hover:translate-x-1 transition-transform duration-300"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Analisis Kepuasan Card -->
                <div class="bg-white overflow-hidden shadow-2xl sm:rounded-2xl border-0 relative group hover:transform hover:scale-105 transition-all duration-300 animate-fade-in" style="animation-delay: 0.1s;">
                    <div class="absolute inset-0 bg-gradient-to-r from-green-500 via-teal-500 to-cyan-500 rounded-2xl opacity-20 group-hover:opacity-30 transition-opacity duration-300"></div>
                    <div class="relative bg-white sm:rounded-2xl p-8 h-full">
                        <div class="text-center">
                            <div class="bg-gradient-to-r from-green-500 to-teal-600 p-4 rounded-full mx-auto mb-6 shadow-lg group-hover:shadow-xl transition-shadow duration-300">
                                <i class="fas fa-smile text-white text-2xl"></i>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-800 mb-4">Analisis Kepuasan</h3>
                            <p class="text-gray-600 mb-8 leading-relaxed">
                                Evaluasi tingkat kepuasan peserta terhadap program pelatihan dengan Indeks Kepuasan Pelanggan (IKP).
                                Mengidentifikasi area kekuatan dan kelemahan.
                            </p>
                            <a href="{{ route('grafik.kepuasan') }}"
                               class="inline-flex items-center justify-center w-full px-6 py-3 bg-gradient-to-r from-green-500 to-teal-600 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300 group-hover:from-green-600 group-hover:to-teal-700">
                                <i class="fas fa-chart-line mr-3"></i>
                                Lihat Analisis Kepuasan
                                <i class="fas fa-arrow-right ml-3 group-hover:translate-x-1 transition-transform duration-300"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Analisis Loyalitas Card -->
                <div class="bg-white overflow-hidden shadow-2xl sm:rounded-2xl border-0 relative group hover:transform hover:scale-105 transition-all duration-300 animate-fade-in" style="animation-delay: 0.2s;">
                    <div class="absolute inset-0 bg-gradient-to-r from-purple-500 via-pink-500 to-rose-500 rounded-2xl opacity-20 group-hover:opacity-30 transition-opacity duration-300"></div>
                    <div class="relative bg-white sm:rounded-2xl p-8 h-full">
                        <div class="text-center">
                            <div class="bg-gradient-to-r from-purple-500 to-pink-600 p-4 rounded-full mx-auto mb-6 shadow-lg group-hover:shadow-xl transition-shadow duration-300">
                                <i class="fas fa-heart text-white text-2xl"></i>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-800 mb-4">Analisis Loyalitas</h3>
                            <p class="text-gray-600 mb-8 leading-relaxed">
                                Mengukur tingkat loyalitas peserta dengan Indeks Loyalitas Pelanggan (ILP).
                                Mengidentifikasi potensi retensi dan rekomendasi pelanggan.
                            </p>
                            <a href="{{ route('grafik.loyalitas') }}"
                               class="inline-flex items-center justify-center w-full px-6 py-3 bg-gradient-to-r from-purple-500 to-pink-600 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300 group-hover:from-purple-600 group-hover:to-pink-700">
                                <i class="fas fa-chart-pie mr-3"></i>
                                Lihat Analisis Loyalitas
                                <i class="fas fa-arrow-right ml-3 group-hover:translate-x-1 transition-transform duration-300"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Gap Analysis Card -->
                <div class="bg-white overflow-hidden shadow-2xl sm:rounded-2xl border-0 relative group hover:transform hover:scale-105 transition-all duration-300 animate-fade-in" style="animation-delay: 0.3s;">
                    <div class="absolute inset-0 bg-gradient-to-r from-yellow-500 via-orange-500 to-red-500 rounded-2xl opacity-20 group-hover:opacity-30 transition-opacity duration-300"></div>
                    <div class="relative bg-white sm:rounded-2xl p-8 h-full">
                        <div class="text-center">
                            <div class="bg-gradient-to-r from-yellow-500 to-orange-600 p-4 rounded-full mx-auto mb-6 shadow-lg group-hover:shadow-xl transition-shadow duration-300">
                                <i class="fas fa-balance-scale text-white text-2xl"></i>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-800 mb-4">Gap Analysis</h3>
                            <p class="text-gray-600 mb-8 leading-relaxed">
                                Analisis perbedaan antara ekspektasi (harapan) dan persepsi (realitas) peserta.
                                Mengidentifikasi area yang perlu diperbaiki dalam program pelatihan.
                            </p>
                            <a href="{{ route('grafik.mean-persepsi-harapan-gap-per-dimensi') }}"
                               class="inline-flex items-center justify-center w-full px-6 py-3 bg-gradient-to-r from-yellow-500 to-orange-600 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300 group-hover:from-yellow-600 group-hover:to-orange-700">
                                <i class="fas fa-chart-area mr-3"></i>
                                Lihat Gap Analysis
                                <i class="fas fa-arrow-right ml-3 group-hover:translate-x-1 transition-transform duration-300"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Rekomendasi Card -->
                <div class="bg-white overflow-hidden shadow-2xl sm:rounded-2xl border-0 relative group hover:transform hover:scale-105 transition-all duration-300 animate-fade-in" style="animation-delay: 0.4s;">
                    <div class="absolute inset-0 bg-gradient-to-r from-indigo-500 via-blue-500 to-cyan-500 rounded-2xl opacity-20 group-hover:opacity-30 transition-opacity duration-300"></div>
                    <div class="relative bg-white sm:rounded-2xl p-8 h-full">
                        <div class="text-center">
                            <div class="bg-gradient-to-r from-indigo-500 to-blue-600 p-4 rounded-full mx-auto mb-6 shadow-lg group-hover:shadow-xl transition-shadow duration-300">
                                <i class="fas fa-lightbulb text-white text-2xl"></i>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-800 mb-4">Rekomendasi</h3>
                            <p class="text-gray-600 mb-8 leading-relaxed">
                                Saran perbaikan berdasarkan hasil analisis gap dan kepuasan.
                                Rekomendasi strategis untuk meningkatkan kualitas program pelatihan.
                            </p>
                            <a href="{{ route('grafik.rekomendasi') }}"
                               class="inline-flex items-center justify-center w-full px-6 py-3 bg-gradient-to-r from-indigo-500 to-blue-600 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300 group-hover:from-indigo-600 group-hover:to-blue-700">
                                <i class="fas fa-clipboard-list mr-3"></i>
                                Lihat Rekomendasi
                                <i class="fas fa-arrow-right ml-3 group-hover:translate-x-1 transition-transform duration-300"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Rata-rata Gap per Indikator Card -->
                <div class="bg-white overflow-hidden shadow-2xl sm:rounded-2xl border-0 relative group hover:transform hover:scale-105 transition-all duration-300 animate-fade-in" style="animation-delay: 0.5s;">
                    <div class="absolute inset-0 bg-gradient-to-r from-red-500 via-pink-500 to-purple-500 rounded-2xl opacity-20 group-hover:opacity-30 transition-opacity duration-300"></div>
                    <div class="relative bg-white sm:rounded-2xl p-8 h-full">
                        <div class="text-center">
                            <div class="bg-gradient-to-r from-red-500 to-pink-600 p-4 rounded-full mx-auto mb-6 shadow-lg group-hover:shadow-xl transition-shadow duration-300">
                                <i class="fas fa-tachometer-alt text-white text-2xl"></i>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-800 mb-4">Rata-rata Gap per Indikator</h3>
                            <p class="text-gray-600 mb-8 leading-relaxed">
                                Analisis detail gap untuk setiap indikator dalam dimensi SERVQUAL.
                                Memahami performa spesifik dari setiap aspek program pelatihan.
                            </p>
                            <a href="{{ route('grafik.mean-gap-per-dimensi') }}"
                               class="inline-flex items-center justify-center w-full px-6 py-3 bg-gradient-to-r from-red-500 to-pink-600 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300 group-hover:from-red-600 group-hover:to-pink-700">
                                <i class="fas fa-chart-column mr-3"></i>
                                Lihat Detail Gap
                                <i class="fas fa-arrow-right ml-3 group-hover:translate-x-1 transition-transform duration-300"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Manajemen Data Survey Card -->
                <div class="bg-white overflow-hidden shadow-2xl sm:rounded-2xl border-0 relative group hover:transform hover:scale-105 transition-all duration-300 animate-fade-in" style="animation-delay: 0.6s;">
                    <div class="absolute inset-0 bg-gradient-to-r from-teal-500 via-cyan-500 to-blue-500 rounded-2xl opacity-20 group-hover:opacity-30 transition-opacity duration-300"></div>
                    <div class="relative bg-white sm:rounded-2xl p-8 h-full">
                        <div class="text-center">
                            <div class="bg-gradient-to-r from-teal-500 to-cyan-600 p-4 rounded-full mx-auto mb-6 shadow-lg group-hover:shadow-xl transition-shadow duration-300">
                                <i class="fas fa-database text-white text-2xl"></i>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-800 mb-4">Manajemen Data Survey</h3>
                            <p class="text-gray-600 mb-8 leading-relaxed">
                                Kelola dan pantau semua data responden survey pelatihan.
                                Lihat detail responden, export data, dan hapus data yang tidak diperlukan.
                            </p>
                            <a href="{{ route('dashboard.survey-management.index') }}"
                               class="inline-flex items-center justify-center w-full px-6 py-3 bg-gradient-to-r from-teal-500 to-cyan-600 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300 group-hover:from-teal-600 group-hover:to-cyan-700">
                                <i class="fas fa-cogs mr-3"></i>
                                Kelola Data Survey
                                <i class="fas fa-arrow-right ml-3 group-hover:translate-x-1 transition-transform duration-300"></i>
                            </a>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Footer Info -->
            <div class="text-center mt-12 animate-fade-in" style="animation-delay: 0.6s;">
                <div class="bg-white/50 backdrop-blur-sm rounded-2xl p-6 shadow-lg">
                    <div class="flex items-center justify-center mb-4">
                        <i class="fas fa-info-circle text-blue-500 mr-2"></i>
                        <span class="text-sm font-medium text-gray-700">Informasi</span>
                    </div>
                    <p class="text-sm text-gray-600 leading-relaxed">
                        Dashboard ini menyediakan berbagai analisis komprehensif untuk memahami kepuasan dan loyalitas peserta pelatihan.
                        Gunakan data ini untuk pengambilan keputusan yang lebih baik dalam pengembangan program.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Custom animations */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in {
            animation: fadeIn 0.8s ease-out;
        }

        .animate-fade-in-up {
            animation: fadeInUp 0.8s ease-out;
            opacity: 0;
            animation-fill-mode: forwards;
        }

        /* Hover effects */
        .group:hover .group-hover\:shadow-xl {
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .grid-cols-4 {
                grid-template-columns: 1fr;
            }

            .text-4xl {
                font-size: 2.5rem;
            }
        }

        /* Gradient text animation */
        .bg-clip-text {
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        /* Backdrop blur support */
        @supports (backdrop-filter: blur(10px)) {
            .backdrop-blur-sm {
                backdrop-filter: blur(10px);
            }
        }
    </style>
</x-app-layout>