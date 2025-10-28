<x-guest-layout>
    <x-slot name="title">
        Survei Ditutup - {{ $campaign->name }}
    </x-slot>

    <div class="min-h-screen bg-gray-50 flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-2xl w-full">
            {{-- Main Card --}}
            <div class="bg-white rounded-lg shadow-xl overflow-hidden">
                {{-- Header --}}
                <div class="bg-gradient-to-r from-red-500 to-red-600 px-6 py-8 text-center">
                    <div class="flex justify-center mb-4">
                        <div class="bg-white rounded-full p-4">
                            <i class="fas fa-times-circle text-red-500 text-5xl"></i>
                        </div>
                    </div>
                    <h1 class="text-3xl font-bold text-white mb-2">
                        Survei Ditutup
                    </h1>
                    <p class="text-red-100">
                        Maaf, survei ini tidak dapat diakses saat ini
                    </p>
                </div>

                {{-- Content --}}
                <div class="px-6 py-8">
                    {{-- Campaign Info --}}
                    <div class="bg-gray-50 rounded-lg p-6 mb-6">
                        <div class="flex items-start gap-4">
                            <div class="flex-shrink-0 bg-{{ $campaign->getTypeBadgeColor() }}-100 rounded-lg p-3">
                                <i class="fas {{ $campaign->getTypeIcon() }} text-{{ $campaign->getTypeBadgeColor() }}-600 text-2xl"></i>
                            </div>
                            <div class="flex-1">
                                <h2 class="text-xl font-bold text-gray-900 mb-2">
                                    {{ $campaign->name }}
                                </h2>
                                <div class="flex items-center gap-2 text-sm text-gray-600 mb-2">
                                    <i class="fas fa-building"></i>
                                    <span>{{ $campaign->umkm->umkm->nama_usaha ?? $campaign->umkm->name }}</span>
                                </div>
                                @if($campaign->description)
                                    <p class="text-sm text-gray-600">
                                        {{ $campaign->description }}
                                    </p>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- Reason Message --}}
                    <div class="bg-red-50 border-l-4 border-red-400 p-4 mb-6">
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <i class="fas fa-exclamation-triangle text-red-400 text-xl mt-0.5"></i>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-red-800 mb-1">
                                    Alasan Penutupan:
                                </h3>
                                <p class="text-sm text-red-700">
                                    {{ $reason }}
                                </p>
                            </div>
                        </div>
                    </div>

                    {{-- Campaign Details --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                        <div class="flex items-center gap-3 p-4 bg-gray-50 rounded-lg">
                            <div class="flex-shrink-0 bg-blue-100 rounded-lg p-3">
                                <i class="fas fa-calendar-alt text-blue-600"></i>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500">Periode</p>
                                <p class="text-sm font-medium text-gray-900">
                                    {{ $campaign->start_date->format('d M Y') }}
                                </p>
                                <p class="text-xs text-gray-600">
                                    s/d {{ $campaign->end_date->format('d M Y') }}
                                </p>
                            </div>
                        </div>

                        <div class="flex items-center gap-3 p-4 bg-gray-50 rounded-lg">
                            <div class="flex-shrink-0 bg-purple-100 rounded-lg p-3">
                                <i class="fas fa-users text-purple-600"></i>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500">Responden</p>
                                <p class="text-sm font-medium text-gray-900">
                                    {{ $campaign->responses_count }}
                                    @if($campaign->max_respondents)
                                        / {{ $campaign->max_respondents }}
                                    @endif
                                </p>
                                @if($campaign->max_respondents)
                                    <p class="text-xs text-gray-600">
                                        {{ number_format($campaign->progress_percentage, 0) }}% terisi
                                    </p>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- Additional Info --}}
                    <div class="text-center">
                        <p class="text-sm text-gray-600 mb-4">
                            Untuk informasi lebih lanjut, silakan hubungi penyelenggara survei.
                        </p>
                        
                        {{-- Contact Info (if available) --}}
                        @if($campaign->umkm->email)
                            <div class="inline-flex items-center gap-2 text-sm text-gray-700 bg-gray-100 px-4 py-2 rounded-lg">
                                <i class="fas fa-envelope text-gray-500"></i>
                                <a href="mailto:{{ $campaign->umkm->email }}" class="hover:text-indigo-600 transition">
                                    {{ $campaign->umkm->email }}
                                </a>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Footer --}}
                <div class="bg-gray-50 px-6 py-4 text-center border-t border-gray-200">
                    <p class="text-xs text-gray-500">
                        © {{ date('Y') }} {{ $campaign->umkm->umkm->nama_usaha ?? $campaign->umkm->name }}. 
                        Sistem Survei Kepuasan & Loyalitas Pelanggan.
                    </p>
                </div>
            </div>

            {{-- Back Button --}}
            <div class="text-center mt-6">
                <a href="{{ url('/') }}" 
                   class="inline-flex items-center gap-2 text-gray-600 hover:text-gray-900 transition">
                    <i class="fas fa-home"></i>
                    <span>Kembali ke Beranda</span>
                </a>
            </div>
        </div>
    </div>
</x-guest-layout>
