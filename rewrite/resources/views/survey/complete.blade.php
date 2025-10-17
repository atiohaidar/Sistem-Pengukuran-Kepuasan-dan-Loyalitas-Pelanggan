<x-mylayout title="Survei Selesai - Terima Kasih">
<div class="min-h-screen bg-gradient-to-br from-green-50 to-emerald-100 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto">
        <!-- Success Message -->
        <div class="text-center mb-12">
            <div class="bg-white rounded-full w-24 h-24 flex items-center justify-center mx-auto mb-6 shadow-lg">
                <i class="fas fa-check-circle text-green-600 text-4xl"></i>
            </div>
            <h1 class="text-4xl font-bold text-gray-900 mb-4">Terima Kasih!</h1>
            <p class="text-xl text-gray-600 mb-8">
                Survei Anda telah berhasil diselesaikan
            </p>
        </div>

        <!-- Summary Card -->
        <div class="bg-white shadow-lg rounded-lg overflow-hidden mb-8">
            <div class="bg-gradient-to-r from-green-600 to-emerald-600 px-6 py-4">
                <h2 class="text-2xl font-bold text-white">Ringkasan Survei</h2>
            </div>

            <div class="p-6">
                <div class="grid md:grid-cols-2 gap-6">
                    <!-- Survey Info -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Informasi Survei</h3>
                        <div class="space-y-3">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Token Survei:</span>
                                <code class="bg-gray-100 px-2 py-1 rounded text-sm">{{ $survey->session_token }}</code>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Waktu Mulai:</span>
                                <span class="font-medium">{{ $survey->started_at ? $survey->started_at->format('d/m/Y H:i') : '-' }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Waktu Selesai:</span>
                                <span class="font-medium">{{ $survey->completed_at ? $survey->completed_at->format('d/m/Y H:i') : '-' }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Status:</span>
                                <span class="bg-green-100 text-green-800 px-2 py-1 rounded-full text-xs font-medium">
                                    {{ $survey->status === 'completed' ? 'Selesai' : 'Draft' }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Progress Summary -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Progress Survei</h3>
                        <div class="space-y-3">
                            <div>
                                <div class="flex justify-between text-sm mb-1">
                                    <span>Profile</span>
                                    <span>{{ $survey->profile_data ? '100%' : '0%' }}</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="bg-blue-600 h-2 rounded-full" style="width: {{ $survey->profile_data ? '100%' : '0%' }}"></div>
                                </div>
                            </div>
                            <div>
                                <div class="flex justify-between text-sm mb-1">
                                    <span>Harapan</span>
                                    <span>{{ $survey->harapan_answers ? '100%' : '0%' }}</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="bg-green-600 h-2 rounded-full" style="width: {{ $survey->harapan_answers ? '100%' : '0%' }}"></div>
                                </div>
                            </div>
                            <div>
                                <div class="flex justify-between text-sm mb-1">
                                    <span>Persepsi</span>
                                    <span>{{ $survey->persepsi_answers ? '100%' : '0%' }}</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="bg-purple-600 h-2 rounded-full" style="width: {{ $survey->persepsi_answers ? '100%' : '0%' }}"></div>
                                </div>
                            </div>
                            <div>
                                <div class="flex justify-between text-sm mb-1">
                                    <span>Kepuasan</span>
                                    <span>{{ $survey->kepuasan_answers ? '100%' : '0%' }}</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="bg-yellow-600 h-2 rounded-full" style="width: {{ $survey->kepuasan_answers ? '100%' : '0%' }}"></div>
                                </div>
                            </div>
                            <div>
                                <div class="flex justify-between text-sm mb-1">
                                    <span>Loyalitas</span>
                                    <span>{{ $survey->loyalitas_answers ? '100%' : '0%' }}</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="bg-orange-600 h-2 rounded-full" style="width: {{ $survey->loyalitas_answers ? '100%' : '0%' }}"></div>
                                </div>
                            </div>
                            <div>
                                <div class="flex justify-between text-sm mb-1">
                                    <span>Feedback</span>
                                    <span>{{ $survey->feedback_answers ? '100%' : '0%' }}</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="bg-red-600 h-2 rounded-full" style="width: {{ $survey->feedback_answers ? '100%' : '0%' }}"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Thank You Message -->
        <div class="bg-white shadow-lg rounded-lg p-8 text-center mb-8">
            <h3 class="text-2xl font-semibold text-gray-800 mb-4">Partisipasi Anda Sangat Berarti</h3>
            <p class="text-gray-600 mb-6">
                Masukan dan penilaian Anda akan membantu kami meningkatkan kualitas layanan pelatihan
                untuk memberikan pengalaman yang lebih baik di masa depan.
            </p>
            <div class="flex justify-center space-x-4">
                <div class="text-center">
                    <i class="fas fa-chart-line text-blue-600 text-3xl mb-2"></i>
                    <p class="text-sm text-gray-600">Analisis Data</p>
                </div>
                <div class="text-center">
                    <i class="fas fa-lightbulb text-yellow-600 text-3xl mb-2"></i>
                    <p class="text-sm text-gray-600">Perbaikan Layanan</p>
                </div>
                <div class="text-center">
                    <i class="fas fa-users text-green-600 text-3xl mb-2"></i>
                    <p class="text-sm text-gray-600">Kepuasan Peserta</p>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="text-center">
            <a href="{{ route('survey.index') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-lg text-lg transition duration-300 transform hover:scale-105 shadow-lg inline-block">
                <i class="fas fa-home mr-2"></i>
                Kembali ke Halaman Utama
            </a>
        </div>

        <!-- Footer Note -->
        <div class="text-center mt-8">
            <p class="text-gray-500 text-sm">
                Lembaga Pelatihan Professional - Survei Kepuasan dan Loyalitas Pelanggan
            </p>
        </div>
    </div>
</div>
</x-mylayout>