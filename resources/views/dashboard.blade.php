<x-app-layout title="Dashboard - Survei Kepuasan">
    <div class="min-h-screen bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50">
        <!-- Header -->


        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <!-- Welcome Section -->
            <div class="text-center mb-16">
                <div
                    class="inline-flex items-center justify-center w-24 h-24 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-full mb-8 shadow-lg">
                    <i class="fas fa-chart-line text-white text-3xl"></i>
                </div>
                <h2 class="text-4xl font-bold text-gray-900 mb-4">Sistem Survei Kepuasan</h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto leading-relaxed">
                    Pilih jenis survei yang ingin Anda ikuti untuk membantu kami meningkatkan kualitas layanan dan
                    produk kami.
                </p>
            </div>

            <!-- Survey Cards -->
            <div class="grid md:grid-cols-2 gap-12 mb-16">

                <!-- Pelatihan Survey Card -->
                <div
                    class="bg-white overflow-hidden shadow-2xl sm:rounded-2xl border-0 relative group hover:transform hover:scale-105 transition-all duration-300 animate-fade-in-up">
                    <div
                        class="absolute inset-0 bg-gradient-to-r from-blue-500 via-purple-500 to-pink-500 rounded-2xl opacity-20 group-hover:opacity-30 transition-opacity duration-300">
                    </div>

                    <div class="relative bg-white sm:rounded-2xl p-8 h-full">
                        <div class="text-center">
                            <div
                                class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-r from-blue-500 to-purple-600 rounded-full mb-6 shadow-lg">
                                <i class="fas fa-graduation-cap text-white text-2xl"></i>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-800 mb-4">Survei Kepuasan Pelatihan</h3>
                            <p class="text-sm text-blue-600 font-medium mb-2">UNTUK PESERTA PELATIHAN</p>
                            <p class="text-gray-600 mb-8 leading-relaxed">Survei untuk mengukur kepuasan peserta
                                terhadap program pelatihan yang telah diikuti. Berikan masukan Anda untuk meningkatkan
                                kualitas program pelatihan kami.</p>

                            <div class="text-left mb-8 space-y-3">
                                <div class="flex items-center text-sm text-gray-600">
                                    <i class="fas fa-check-circle text-green-500 mr-3"></i>
                                    <span>Evaluasi materi pelatihan</span>
                                </div>
                                <div class="flex items-center text-sm text-gray-600">
                                    <i class="fas fa-check-circle text-green-500 mr-3"></i>
                                    <span>Penilaian trainer</span>
                                </div>
                                <div class="flex items-center text-sm text-gray-600">
                                    <i class="fas fa-check-circle text-green-500 mr-3"></i>
                                    <span>Analisis fasilitas</span>
                                </div>
                            </div>

                            <a href="{{ route('survey.index', ['type' => 'pelatihan']) }}"
                                class="inline-flex items-center justify-center w-full px-8 py-4 bg-gradient-to-r from-blue-500 to-purple-600 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300 group-hover:from-blue-600 group-hover:to-purple-700">
                                <i class="fas fa-play-circle mr-3"></i>
                                Mulai Survei Pelatihan
                                <i
                                    class="fas fa-arrow-right ml-3 group-hover:translate-x-1 transition-transform duration-300"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Produk Survey Card -->
                <div class="bg-white overflow-hidden shadow-2xl sm:rounded-2xl border-0 relative group hover:transform hover:scale-105 transition-all duration-300 animate-fade-in-up"
                    style="animation-delay: 0.1s;">
                    <div
                        class="absolute inset-0 bg-gradient-to-r from-indigo-500 via-blue-500 to-sky-500 rounded-2xl opacity-20 group-hover:opacity-30 transition-opacity duration-300">
                    </div>

                    <div class="relative bg-white sm:rounded-2xl p-8 h-full">
                        <div class="text-center">
                            <div
                                class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-r from-indigo-500 to-blue-600 rounded-full mb-6 shadow-lg">
                                <i class="fas fa-box-open text-white text-2xl"></i>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-800 mb-4">Survei Kepuasan Produk</h3>
                            <p class="text-sm text-indigo-600 font-medium mb-2">UNTUK PELANGGAN PRODUK</p>
                            <p class="text-gray-600 mb-8 leading-relaxed">Survei untuk mengukur kepuasan pelanggan
                                terhadap produk atau layanan. Bantu kami meningkatkan kualitas produk dengan masukan
                                Anda.</p>

                            <div class="text-left mb-8 space-y-3">
                                <div class="flex items-center text-sm text-gray-600">
                                    <i class="fas fa-check-circle text-green-500 mr-3"></i>
                                    <span>Evaluasi kualitas produk</span>
                                </div>
                                <div class="flex items-center text-sm text-gray-600">
                                    <i class="fas fa-check-circle text-green-500 mr-3"></i>
                                    <span>Penilaian layanan & pengiriman</span>
                                </div>
                                <div class="flex items-center text-sm text-gray-600">
                                    <i class="fas fa-check-circle text-green-500 mr-3"></i>
                                    <span>Feedback penggunaan</span>
                                </div>
                            </div>

                            <a href="{{ route('survey.index', ['type' => 'produk']) }}"
                                class="inline-flex items-center justify-center w-full px-8 py-4 bg-gradient-to-r from-indigo-500 to-blue-600 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300 group-hover:from-indigo-600 group-hover:to-blue-700">
                                <i class="fas fa-play-circle mr-3"></i>
                                Mulai Survei Produk
                                <i
                                    class="fas fa-arrow-right ml-3 group-hover:translate-x-1 transition-transform duration-300"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Management Section -->
            <div class="bg-white rounded-2xl shadow-xl p-8 mb-8">
                <div class="text-center mb-8">
                    <h3 class="text-2xl font-bold text-gray-800 mb-4">Panel Manajemen</h3>
                    <p class="text-gray-600">Kelola data survei dan lihat hasil analisis</p>
                </div>

                <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <!-- Survey Management -->
                    <a href="{{ route('dashboard.survey-management.index', ['type' => 'pelatihan']) }}"
                        class="group bg-gradient-to-br from-blue-50 to-blue-100 p-6 rounded-xl border border-blue-200 hover:shadow-lg transition-all duration-300 hover:transform hover:scale-105">
                        <div class="text-center">
                            <div
                                class="w-12 h-12 bg-blue-500 rounded-lg flex items-center justify-center mx-auto mb-4 group-hover:bg-blue-600 transition-colors">
                                <i class="fas fa-graduation-cap text-white"></i>
                            </div>
                            <h4 class="font-semibold text-gray-800 mb-2">Survei Pelatihan</h4>
                            <p class="text-sm text-gray-600">Kelola data survei pelatihan</p>
                        </div>
                    </a>

                    <!-- Produk Survey Management -->
                    <a href="{{ route('dashboard.survey-management.index', ['type' => 'produk']) }}"
                        class="group bg-gradient-to-br from-indigo-50 to-indigo-100 p-6 rounded-xl border border-indigo-200 hover:shadow-lg transition-all duration-300 hover:transform hover:scale-105">
                        <div class="text-center">
                            <div
                                class="w-12 h-12 bg-indigo-500 rounded-lg flex items-center justify-center mx-auto mb-4 group-hover:bg-indigo-600 transition-colors">
                                <i class="fas fa-box-open text-white"></i>
                            </div>
                            <h4 class="font-semibold text-gray-800 mb-2">Survei Produk</h4>
                            <p class="text-sm text-gray-600">Kelola data survei produk</p>
                        </div>
                    </a>

                    <!-- Analytics -->
                    <a href="{{ route('grafik.mean-gap-per-dimensi') }}"
                        class="group bg-gradient-to-br from-green-50 to-green-100 p-6 rounded-xl border border-green-200 hover:shadow-lg transition-all duration-300 hover:transform hover:scale-105">
                        <div class="text-center">
                            <div
                                class="w-12 h-12 bg-green-500 rounded-lg flex items-center justify-center mx-auto mb-4 group-hover:bg-green-600 transition-colors">
                                <i class="fas fa-chart-bar text-white"></i>
                            </div>
                            <h4 class="font-semibold text-gray-800 mb-2">Analitik</h4>
                            <p class="text-sm text-gray-600">Lihat grafik dan analisis</p>
                        </div>
                    </a>

                    <!-- Customer Evaluation -->
                    <a href="{{ route('dashboard.customer-evaluation-management.index') }}"
                        class="group bg-gradient-to-br from-purple-50 to-purple-100 p-6 rounded-xl border border-purple-200 hover:shadow-lg transition-all duration-300 hover:transform hover:scale-105">
                        <div class="text-center">
                            <div
                                class="w-12 h-12 bg-purple-500 rounded-lg flex items-center justify-center mx-auto mb-4 group-hover:bg-purple-600 transition-colors">
                                <i class="fas fa-users text-white"></i>
                            </div>
                            <h4 class="font-semibold text-gray-800 mb-2">Evaluasi</h4>
                            <p class="text-sm text-gray-600">Evaluasi manajemen pelanggan</p>
                        </div>
                    </a>
                </div>
            </div>

            <!-- Quick Stats -->
            <div class="grid md:grid-cols-3 gap-8">
                <div class="bg-white rounded-xl shadow-lg p-6 text-center">
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-poll-h text-blue-600 text-2xl"></i>
                    </div>
                    <h4 class="text-2xl font-bold text-gray-800 mb-2">--</h4>
                    <p class="text-gray-600">Total Survei</p>
                </div>

                <div class="bg-white rounded-xl shadow-lg p-6 text-center">
                    <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-users text-green-600 text-2xl"></i>
                    </div>
                    <h4 class="text-2xl font-bold text-gray-800 mb-2">--</h4>
                    <p class="text-gray-600">Responden</p>
                </div>

                <div class="bg-white rounded-xl shadow-lg p-6 text-center">
                    <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-star text-purple-600 text-2xl"></i>
                    </div>
                    <h4 class="text-2xl font-bold text-gray-800 mb-2">--</h4>
                    <p class="text-gray-600">Rata-rata Kepuasan</p>
                </div>
            </div>
        </div>
    </div>

    <style>
        @keyframes fade-in-up {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in-up {
            animation: fade-in-up 0.6s ease-out forwards;
        }
    </style>
</x-app-layout>