<x-guest-layout>
    <x-slot name="title">
        Terima Kasih - {{ $campaign->name }}
    </x-slot>

    <div class="min-h-screen bg-gradient-to-br from-green-50 to-green-100 flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-2xl w-full">
            {{-- Main Card --}}
            <div class="bg-white rounded-lg shadow-xl overflow-hidden">
                {{-- Header with Animation --}}
                <div class="bg-gradient-to-r from-green-500 to-green-600 px-6 py-8 text-center">
                    <div class="flex justify-center mb-4">
                        <div class="bg-white rounded-full p-4 animate-bounce">
                            <i class="fas fa-check-circle text-green-500 text-5xl"></i>
                        </div>
                    </div>
                    <h1 class="text-3xl font-bold text-white mb-2">
                        Terima Kasih!
                    </h1>
                    <p class="text-green-100">
                        Respons Anda telah berhasil disimpan
                    </p>
                </div>

                {{-- Content --}}
                <div class="px-6 py-8">
                    {{-- Success Message --}}
                    <div class="text-center mb-8">
                        <div class="inline-flex items-center justify-center w-16 h-16 bg-green-100 rounded-full mb-4">
                            <i class="fas fa-paper-plane text-green-600 text-2xl"></i>
                        </div>
                        <h2 class="text-2xl font-bold text-gray-900 mb-2">
                            Survei Berhasil Dikirim
                        </h2>
                        <p class="text-gray-600 max-w-lg mx-auto">
                            Kami sangat menghargai waktu dan feedback Anda. Masukan Anda sangat berharga untuk membantu kami meningkatkan kualitas layanan.
                        </p>
                    </div>

                    {{-- Campaign Info --}}
                    <div class="bg-gradient-to-r from-green-50 to-emerald-50 rounded-lg p-6 mb-6">
                        <div class="flex items-start gap-4">
                            <div class="flex-shrink-0 bg-white rounded-lg p-3 shadow-sm">
                                <i class="fas {{ $campaign->getTypeIcon() }} text-{{ $campaign->getTypeBadgeColor() }}-600 text-2xl"></i>
                            </div>
                            <div class="flex-1">
                                <p class="text-xs text-gray-500 mb-1">Survei</p>
                                <h3 class="text-lg font-bold text-gray-900 mb-2">
                                    {{ $campaign->name }}
                                </h3>
                                <div class="flex items-center gap-2 text-sm text-gray-600">
                                    <i class="fas fa-building"></i>
                                    <span>{{ $campaign->umkm->umkm->nama_usaha ?? $campaign->umkm->name }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Stats --}}
                    @if($campaign->max_respondents)
                        <div class="bg-gray-50 rounded-lg p-6 mb-6">
                            <div class="flex items-center justify-between mb-3">
                                <div>
                                    <p class="text-sm text-gray-600">Progress Responden</p>
                                    <p class="text-2xl font-bold text-gray-900">
                                        {{ $campaign->responses_count }} / {{ $campaign->max_respondents }}
                                    </p>
                                </div>
                                <div class="text-right">
                                    <p class="text-sm text-gray-600">Persentase</p>
                                    <p class="text-2xl font-bold text-green-600">
                                        {{ number_format($campaign->progress_percentage, 1) }}%
                                    </p>
                                </div>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-3">
                                <div class="bg-gradient-to-r from-green-500 to-emerald-500 h-3 rounded-full transition-all duration-500" 
                                     style="width: {{ $campaign->progress_percentage }}%"></div>
                            </div>
                        </div>
                    @endif

                    {{-- Additional Info --}}
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                        <div class="text-center p-4 bg-blue-50 rounded-lg">
                            <i class="fas fa-clock text-blue-600 text-2xl mb-2"></i>
                            <p class="text-xs text-gray-600">Waktu Respons</p>
                            <p class="text-sm font-medium text-gray-900">~5 menit</p>
                        </div>
                        <div class="text-center p-4 bg-purple-50 rounded-lg">
                            <i class="fas fa-shield-alt text-purple-600 text-2xl mb-2"></i>
                            <p class="text-xs text-gray-600">Data Aman</p>
                            <p class="text-sm font-medium text-gray-900">Terenkripsi</p>
                        </div>
                        <div class="text-center p-4 bg-green-50 rounded-lg">
                            <i class="fas fa-check-double text-green-600 text-2xl mb-2"></i>
                            <p class="text-xs text-gray-600">Status</p>
                            <p class="text-sm font-medium text-gray-900">Terverifikasi</p>
                        </div>
                    </div>

                    {{-- Message --}}
                    <div class="border-l-4 border-green-400 bg-green-50 p-4 mb-6">
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <i class="fas fa-info-circle text-green-400 text-xl mt-0.5"></i>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-green-800">
                                    <strong>Catatan:</strong> Anda dapat mengisi survei ini kembali di lain waktu jika diperlukan. 
                                    Link survei masih aktif hingga {{ $campaign->end_date->format('d M Y') }}.
                                </p>
                            </div>
                        </div>
                    </div>

                    {{-- Social Share (Optional) --}}
                    <div class="text-center pt-6 border-t border-gray-200">
                        <p class="text-sm text-gray-600 mb-3">
                            Bantu kami dengan membagikan survei ini:
                        </p>
                        <div class="flex justify-center gap-3">
                            <a href="https://wa.me/?text={{ urlencode('Ayo isi survei: ' . $campaign->public_url) }}" 
                               target="_blank"
                               class="inline-flex items-center gap-2 bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg transition">
                                <i class="fab fa-whatsapp"></i>
                                <span>WhatsApp</span>
                            </a>
                            <button onclick="copyLink()" 
                                    class="inline-flex items-center gap-2 bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded-lg transition">
                                <i class="fas fa-copy"></i>
                                <span>Copy Link</span>
                            </button>
                        </div>
                    </div>
                </div>

                {{-- Footer --}}
                <div class="bg-gray-50 px-6 py-4 text-center border-t border-gray-200">
                    <p class="text-xs text-gray-500 mb-2">
                        © {{ date('Y') }} {{ $campaign->umkm->umkm->nama_usaha ?? $campaign->umkm->name }}
                    </p>
                    <p class="text-xs text-gray-400">
                        Sistem Survei Kepuasan & Loyalitas Pelanggan
                    </p>
                </div>
            </div>

            {{-- Action Buttons --}}
            <div class="text-center mt-6 space-y-2">
                <a href="{{ $campaign->public_url }}" 
                   class="inline-flex items-center gap-2 bg-white text-gray-700 hover:text-gray-900 px-6 py-3 rounded-lg shadow transition">
                    <i class="fas fa-redo"></i>
                    <span>Isi Survei Lagi</span>
                </a>
                
                <div>
                    <a href="{{ url('/') }}" 
                       class="inline-flex items-center gap-2 text-gray-600 hover:text-gray-900 transition">
                        <i class="fas fa-home"></i>
                        <span>Kembali ke Beranda</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- Toast Notification --}}
    <div id="toast" class="fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg hidden items-center gap-2 z-50">
        <i class="fas fa-check-circle"></i>
        <span id="toastMessage">Link berhasil disalin!</span>
    </div>

    <script>
        function copyLink() {
            const url = '{{ $campaign->public_url }}';
            navigator.clipboard.writeText(url).then(() => {
                showToast('Link berhasil disalin!');
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
</x-guest-layout>
