<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Pilih Campaign untuk Analytics') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <!-- Header Info -->
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">
                            <i class="fas fa-chart-line text-indigo-600 mr-2"></i>
                            Analytics & Grafik
                        </h3>
                        <p class="text-sm text-gray-600">
                            Pilih campaign survei untuk melihat grafik dan analisis data responsnya
                        </p>
                    </div>

                    @if($campaigns->isEmpty())
                        <!-- Empty State -->
                        <div class="text-center py-12">
                            <div class="inline-flex items-center justify-center w-16 h-16 bg-gray-100 rounded-full mb-4">
                                <i class="fas fa-inbox text-gray-400 text-2xl"></i>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">
                                Belum Ada Campaign
                            </h3>
                            <p class="text-gray-600 mb-6">
                                Anda belum memiliki campaign survei. Buat campaign terlebih dahulu untuk melihat analytics.
                            </p>
                            <a href="{{ route('survey-campaigns.create') }}" 
                               class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg transition">
                                <i class="fas fa-plus mr-2"></i>
                                Buat Campaign Baru
                            </a>
                        </div>
                    @else
                        <!-- Campaign List -->
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($campaigns as $campaign)
                                <div class="border border-gray-200 rounded-lg hover:shadow-lg transition-all duration-200">
                                    <!-- Card Header -->
                                    <div class="p-4 border-b border-gray-100">
                                        <div class="flex items-start gap-3">
                                            <div class="flex-shrink-0 bg-gradient-to-br from-{{ $campaign->getTypeBadgeColor() }}-500 to-{{ $campaign->getTypeBadgeColor() }}-600 rounded-lg p-3">
                                                <i class="fas {{ $campaign->getTypeIcon() }} text-white text-xl"></i>
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <div class="flex items-center gap-2 mb-1">
                                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-{{ $campaign->getTypeBadgeColor() }}-100 text-{{ $campaign->getTypeBadgeColor() }}-800">
                                                        {{ ucfirst($campaign->type) }}
                                                    </span>
                                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-{{ $campaign->getStatusBadgeColor() }}-100 text-{{ $campaign->getStatusBadgeColor() }}-800">
                                                        <i class="fas fa-circle text-{{ $campaign->getStatusBadgeColor() }}-500 text-xs mr-1"></i>
                                                        {{ ucfirst($campaign->status) }}
                                                    </span>
                                                </div>
                                                <h4 class="font-semibold text-gray-900 truncate">
                                                    {{ $campaign->name }}
                                                </h4>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Card Body -->
                                    <div class="p-4 space-y-3">
                                        <!-- Stats -->
                                        <div class="flex items-center justify-between text-sm">
                                            <div class="flex items-center gap-1 text-gray-600">
                                                <i class="fas fa-users"></i>
                                                <span>{{ $campaign->responses_count }} Responden</span>
                                            </div>
                                            @if($campaign->max_respondents)
                                                <span class="text-xs text-gray-500">
                                                    / {{ $campaign->max_respondents }} max
                                                </span>
                                            @endif
                                        </div>

                                        <!-- Period -->
                                        <div class="flex items-center gap-1 text-xs text-gray-500">
                                            <i class="fas fa-calendar-alt"></i>
                                            <span>{{ $campaign->start_date->format('d M Y') }} - {{ $campaign->end_date->format('d M Y') }}</span>
                                        </div>

                                        <!-- Action Buttons -->
                                        <div class="pt-3 border-t border-gray-100">
                                            @if($campaign->responses_count > 0)
                                                <a href="{{ route('grafik.dashboard-campaign', ['campaign' => $campaign->id]) }}" 
                                                   class="block w-full text-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg transition font-medium">
                                                    <i class="fas fa-chart-line mr-2"></i>
                                                    Lihat Analytics
                                                </a>
                                            @else
                                                <button disabled 
                                                        class="block w-full text-center px-4 py-2 bg-gray-200 text-gray-500 rounded-lg cursor-not-allowed">
                                                    <i class="fas fa-chart-line mr-2"></i>
                                                    Belum Ada Data
                                                </button>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Pagination if needed -->
                        @if($campaigns->count() > 9)
                            <div class="mt-6">
                                {{ $campaigns->links() }}
                            </div>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
