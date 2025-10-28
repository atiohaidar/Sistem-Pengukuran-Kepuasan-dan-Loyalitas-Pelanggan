<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Analytics Dashboard') }}
                </h2>
                <p class="text-sm text-gray-600 mt-1">{{ $campaign->name }}</p>
            </div>
            <a href="{{ route('grafik.select-campaign') }}" class="text-gray-600 hover:text-gray-900">
                <i class="fas fa-arrow-left mr-2"></i>Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Campaign Info Card -->
            <div class="bg-white rounded-lg shadow-sm border p-6 mb-6">
                <div class="flex items-start gap-4">
                    <div class="flex-shrink-0 bg-gradient-to-br from-{{ $campaign->getTypeBadgeColor() }}-500 to-{{ $campaign->getTypeBadgeColor() }}-600 rounded-lg p-4 shadow-md">
                        <i class="fas {{ $campaign->getTypeIcon() }} text-white text-3xl"></i>
                    </div>
                    <div class="flex-1">
                        <div class="flex items-center gap-2 mb-2">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-{{ $campaign->getTypeBadgeColor() }}-100 text-{{ $campaign->getTypeBadgeColor() }}-800">
                                <i class="fas {{ $campaign->getTypeIcon() }} mr-1"></i>
                                {{ ucfirst($campaign->type) }}
                            </span>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-{{ $campaign->getStatusBadgeColor() }}-100 text-{{ $campaign->getStatusBadgeColor() }}-800">
                                <i class="fas fa-circle text-{{ $campaign->getStatusBadgeColor() }}-500 text-xs mr-1"></i>
                                {{ ucfirst($campaign->status) }}
                            </span>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-2">{{ $campaign->name }}</h3>
                        @if($campaign->description)
                            <p class="text-gray-600 mb-3">{{ $campaign->description }}</p>
                        @endif
                        <div class="flex items-center gap-6 text-sm text-gray-600">
                            <div class="flex items-center gap-1">
                                <i class="fas fa-users"></i>
                                <span><strong>{{ $campaign->responses_count }}</strong> responden</span>
                            </div>
                            <div class="flex items-center gap-1">
                                <i class="fas fa-calendar-alt"></i>
                                <span>{{ $campaign->start_date->format('d M Y') }} - {{ $campaign->end_date->format('d M Y') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Analytics Menu Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Mean Gap per Dimensi -->
                <a href="{{ route('grafik.mean-gap-per-dimensi', ['type' => $campaign->type, 'campaignId' => $campaign->id]) }}" 
                   class="block bg-white rounded-lg shadow-sm border hover:shadow-lg transition-all duration-200 overflow-hidden">
                    <div class="p-6">
                        <div class="flex items-start gap-4">
                            <div class="flex-shrink-0 bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg p-3">
                                <i class="fas fa-chart-bar text-white text-2xl"></i>
                            </div>
                            <div class="flex-1">
                                <h4 class="font-semibold text-gray-900 mb-2">Mean Gap per Dimensi</h4>
                                <p class="text-sm text-gray-600">
                                    Analisis gap antara harapan dan persepsi untuk setiap dimensi kualitas layanan
                                </p>
                            </div>
                        </div>
                    </div>
                </a>

                <!-- Persepsi vs Harapan -->
                <a href="{{ route('grafik.mean-persepsi-harapan-gap-per-dimensi', ['type' => $campaign->type, 'campaignId' => $campaign->id]) }}" 
                   class="block bg-white rounded-lg shadow-sm border hover:shadow-lg transition-all duration-200 overflow-hidden">
                    <div class="p-6">
                        <div class="flex items-start gap-4">
                            <div class="flex-shrink-0 bg-gradient-to-br from-green-500 to-green-600 rounded-lg p-3">
                                <i class="fas fa-chart-line text-white text-2xl"></i>
                            </div>
                            <div class="flex-1">
                                <h4 class="font-semibold text-gray-900 mb-2">Persepsi vs Harapan</h4>
                                <p class="text-sm text-gray-600">
                                    Perbandingan rata-rata persepsi dan harapan untuk setiap dimensi layanan
                                </p>
                            </div>
                        </div>
                    </div>
                </a>

                <!-- Profil Responden -->
                <a href="{{ route('grafik.profil-responden', ['type' => $campaign->type, 'campaignId' => $campaign->id]) }}" 
                   class="block bg-white rounded-lg shadow-sm border hover:shadow-lg transition-all duration-200 overflow-hidden">
                    <div class="p-6">
                        <div class="flex items-start gap-4">
                            <div class="flex-shrink-0 bg-gradient-to-br from-purple-500 to-purple-600 rounded-lg p-3">
                                <i class="fas fa-users text-white text-2xl"></i>
                            </div>
                            <div class="flex-1">
                                <h4 class="font-semibold text-gray-900 mb-2">Profil Responden</h4>
                                <p class="text-sm text-gray-600">
                                    Demografi responden berdasarkan usia, gender, pekerjaan, dan domisili
                                </p>
                            </div>
                        </div>
                    </div>
                </a>

                <!-- Rekomendasi -->
                <a href="{{ route('grafik.rekomendasi', ['type' => $campaign->type, 'campaignId' => $campaign->id]) }}" 
                   class="block bg-white rounded-lg shadow-sm border hover:shadow-lg transition-all duration-200 overflow-hidden">
                    <div class="p-6">
                        <div class="flex items-start gap-4">
                            <div class="flex-shrink-0 bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-lg p-3">
                                <i class="fas fa-lightbulb text-white text-2xl"></i>
                            </div>
                            <div class="flex-1">
                                <h4 class="font-semibold text-gray-900 mb-2">Rekomendasi</h4>
                                <p class="text-sm text-gray-600">
                                    Rekomendasi perbaikan berdasarkan analisis gap dan indeks kepuasan
                                </p>
                            </div>
                        </div>
                    </div>
                </a>

                <!-- Kepuasan (IKP) -->
                <a href="{{ route('grafik.kepuasan', ['type' => $campaign->type, 'campaignId' => $campaign->id]) }}" 
                   class="block bg-white rounded-lg shadow-sm border hover:shadow-lg transition-all duration-200 overflow-hidden">
                    <div class="p-6">
                        <div class="flex items-start gap-4">
                            <div class="flex-shrink-0 bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-lg p-3">
                                <i class="fas fa-smile text-white text-2xl"></i>
                            </div>
                            <div class="flex-1">
                                <h4 class="font-semibold text-gray-900 mb-2">Kepuasan (IKP)</h4>
                                <p class="text-sm text-gray-600">
                                    Indeks Kepuasan Pelanggan dan distribusi tingkat kepuasan responden
                                </p>
                            </div>
                        </div>
                    </div>
                </a>

                <!-- Loyalitas (ILP) -->
                <a href="{{ route('grafik.loyalitas', ['type' => $campaign->type, 'campaignId' => $campaign->id]) }}" 
                   class="block bg-white rounded-lg shadow-sm border hover:shadow-lg transition-all duration-200 overflow-hidden">
                    <div class="p-6">
                        <div class="flex items-start gap-4">
                            <div class="flex-shrink-0 bg-gradient-to-br from-red-500 to-red-600 rounded-lg p-3">
                                <i class="fas fa-heart text-white text-2xl"></i>
                            </div>
                            <div class="flex-1">
                                <h4 class="font-semibold text-gray-900 mb-2">Loyalitas (ILP)</h4>
                                <p class="text-sm text-gray-600">
                                    Indeks Loyalitas Pelanggan dan distribusi tingkat loyalitas responden
                                </p>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
