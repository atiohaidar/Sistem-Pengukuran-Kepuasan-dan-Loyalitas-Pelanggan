<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sistem Pengukuran Kepuasan dan Loyalitas Pelanggan</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 min-h-screen">
    <div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl w-full space-y-8">

            <!-- Header Section -->
            <div class="text-center animate-fade-in">
                <div class="flex items-center justify-center mb-8">
                    <div class="bg-gradient-to-r from-blue-500 via-purple-500 to-pink-500 p-4 rounded-full shadow-2xl animate-pulse">
                        <i class="fas fa-chart-line text-white text-3xl"></i>
                    </div>
                </div>

                <h1 class="text-4xl md:text-6xl font-bold bg-gradient-to-r from-blue-600 via-purple-600 to-pink-600 bg-clip-text text-transparent mb-4">
                    Sistem Pengukuran
                </h1>
                <h2 class="text-2xl md:text-4xl font-semibold text-gray-700 mb-6">
                    Kepuasan dan Loyalitas Pelanggan
                </h2>

                <p class="text-lg text-gray-600 max-w-2xl mx-auto leading-relaxed">
                    Pilih jenis survei yang ingin Anda ikuti
                </p>
            </div>

            <!-- Survey Options -->
            <div class="grid md:grid-cols-2 gap-8 mt-12">

                <!-- Pelatihan Survey Card -->
                <div class="bg-white overflow-hidden shadow-2xl sm:rounded-2xl border-0 relative group hover:transform hover:scale-105 transition-all duration-300 animate-fade-in-up">
                    <!-- Gradient border effect -->
                    <div class="absolute inset-0 bg-gradient-to-r from-blue-500 via-purple-500 to-pink-500 rounded-2xl opacity-20 group-hover:opacity-30 transition-opacity duration-300"></div>

                    <div class="relative bg-white sm:rounded-2xl p-8 h-full">
                        <div class="text-center">
                            <!-- Icon -->
                            <!-- <div class="bg-gradient-to-r from-blue-500 to-purple-600 p-4 rounded-full mx-auto mb-6 shadow-lg group-hover:shadow-xl transition-shadow duration-300">
                                <i class="fas fa-graduation-cap text-white text-2xl"></i>
                            </div> -->

                            <!-- Title -->
                            <h3 class="text-2xl font-bold text-gray-800 mb-4">
                                Survei Pelatihan
                            </h3>

                            <!-- Description -->
                            <p class="text-gray-600 mb-8 leading-relaxed">
                                Survei untuk mengukur kepuasan peserta terhadap program pelatihan yang telah diikuti.
                                Berikan feedback Anda untuk membantu kami meningkatkan kualitas program pelatihan.
                            </p>

                            <!-- Features List -->
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
                                <div class="flex items-center text-sm text-gray-600">
                                    <i class="fas fa-check-circle text-green-500 mr-3"></i>
                                    <span>Feedback keseluruhan</span>
                                </div>
                            </div>

                            <!-- Button -->
                            <a href="{{ route('survey.index') }}"
                               class="inline-flex items-center justify-center w-full px-8 py-4 bg-gradient-to-r from-blue-500 to-purple-600 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300 group-hover:from-blue-600 group-hover:to-purple-700">
                                <i class="fas fa-play-circle mr-3"></i>
                                Mulai Survei Pelatihan
                                <i class="fas fa-arrow-right ml-3 group-hover:translate-x-1 transition-transform duration-300"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Customer Management Evaluation Card -->
                <div class="bg-white overflow-hidden shadow-2xl sm:rounded-2xl border-0 relative group hover:transform hover:scale-105 transition-all duration-300 animate-fade-in-up" style="animation-delay: 0.2s;">
                    <!-- Gradient border effect -->
                    <div class="absolute inset-0 bg-gradient-to-r from-green-500 via-teal-500 to-cyan-500 rounded-2xl opacity-20 group-hover:opacity-30 transition-opacity duration-300"></div>

                    <div class="relative bg-white sm:rounded-2xl p-8 h-full">
                        <div class="text-center">
                            <!-- Icon -->
                            <!-- <div class="bg-gradient-to-r from-green-500 to-teal-600 p-4 rounded-full mx-auto mb-6 shadow-lg group-hover:shadow-xl transition-shadow duration-300">
                                <i class="fas fa-users-cog text-white text-2xl"></i>
                            </div> -->

                            <!-- Title -->
                            <h3 class="text-2xl font-bold text-gray-800 mb-4">
                                Evaluasi Manajemen Pelanggan
                            </h3>

                            <!-- Description -->
                            <p class="text-gray-600 mb-8 leading-relaxed">
                                Evaluasi komprehensif terhadap kesiapan dan prioritas implementasi sistem manajemen pelanggan.
                                Bantu kami memahami kebutuhan organisasi Anda.
                            </p>

                            <!-- Features List -->
                            <div class="text-left mb-8 space-y-3">
                                <div class="flex items-center text-sm text-gray-600">
                                    <i class="fas fa-check-circle text-green-500 mr-3"></i>
                                    <span>Assessment kematangan</span>
                                </div>
                                <div class="flex items-center text-sm text-gray-600">
                                    <i class="fas fa-check-circle text-green-500 mr-3"></i>
                                    <span>Analisis prioritas</span>
                                </div>
                                <div class="flex items-center text-sm text-gray-600">
                                    <i class="fas fa-check-circle text-green-500 mr-3"></i>
                                    <span>Evaluasi kesiapan</span>
                                </div>
                                <div class="flex items-center text-sm text-gray-600">
                                    <i class="fas fa-check-circle text-green-500 mr-3"></i>
                                    <span>Dashboard hasil</span>
                                </div>
                            </div>

                            <!-- Button -->
                            <a href="{{ route('customer-management-evaluation.welcome') }}"
                               class="inline-flex items-center justify-center w-full px-8 py-4 bg-gradient-to-r from-green-500 to-teal-600 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300 group-hover:from-green-600 group-hover:to-teal-700">
                                <i class="fas fa-play-circle mr-3"></i>
                                Mulai Evaluasi Pelanggan
                                <i class="fas fa-arrow-right ml-3 group-hover:translate-x-1 transition-transform duration-300"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer Info -->
            <div class="text-center mt-12 animate-fade-in" style="animation-delay: 0.4s;">
                <div class="bg-white/50 backdrop-blur-sm rounded-2xl p-6 shadow-lg">
                    <div class="flex items-center justify-center mb-4">
                        <i class="fas fa-info-circle text-blue-500 mr-2"></i>
                        <span class="text-sm font-medium text-gray-700">Informasi</span>
                    </div>
                    <p class="text-sm text-gray-600 leading-relaxed">
                        Kedua survei ini dirancang untuk membantu kami memberikan layanan yang lebih baik.
                        Jawaban Anda akan sangat berharga untuk pengembangan sistem kami.
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
            .grid-cols-2 {
                grid-template-columns: 1fr;
            }

            .text-4xl {
                font-size: 2.5rem;
            }

            .text-6xl {
                font-size: 3.5rem;
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
</body>
</html></content>
<parameter name="filePath">/workspaces/Sistem-Pengukuran-Kepuasan-dan-Loyalitas-Pelanggan/resources/views/welcome.blade.php
