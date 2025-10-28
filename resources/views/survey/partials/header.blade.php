<!-- Survey Header Info -->
@if(isset($campaign))
    <div class="bg-white rounded-lg shadow-sm border p-6 mb-4">
        <div class="flex items-start gap-4">
            <!-- Icon -->
            <div class="flex-shrink-0 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-lg p-3 shadow-md">
                <i class="fas {{ $campaign->getTypeIcon() }} text-white text-2xl"></i>
            </div>
            
            <!-- Content -->
            <div class="flex-1">
                <div class="flex items-center gap-2 mb-1">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-{{ $campaign->getTypeBadgeColor() }}-100 text-{{ $campaign->getTypeBadgeColor() }}-800">
                        <i class="fas {{ $campaign->getTypeIcon() }} mr-1"></i>
                        {{ ucfirst($campaign->type) }}
                    </span>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-{{ $campaign->getStatusBadgeColor() }}-100 text-{{ $campaign->getStatusBadgeColor() }}-800">
                        <i class="fas fa-circle text-{{ $campaign->getStatusBadgeColor() }}-500 text-xs mr-1"></i>
                        {{ ucfirst($campaign->status) }}
                    </span>
                </div>
                
                <h2 class="text-xl font-bold text-gray-900 mb-2">
                    {{ $campaign->name }}
                </h2>
                
                @if($campaign->description)
                    <p class="text-sm text-gray-600 leading-relaxed">
                        {{ $campaign->description }}
                    </p>
                @endif
                
                <!-- Campaign Period -->
                <div class="flex items-center gap-4 mt-3 text-xs text-gray-500">
                    <div class="flex items-center gap-1">
                        <i class="fas fa-calendar-alt"></i>
                        <span>{{ $campaign->start_date->format('d M Y') }} - {{ $campaign->end_date->format('d M Y') }}</span>
                    </div>
                    @if($campaign->max_respondents)
                        <div class="flex items-center gap-1">
                            <i class="fas fa-users"></i>
                            <span>{{ $campaign->responses_count }}/{{ $campaign->max_respondents }} responden</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@else
    <!-- Legacy Mode - Simple Header -->
    <div class="bg-white rounded-lg shadow-sm border p-6 mb-4">
        <div class="flex items-start gap-4">
            <div class="flex-shrink-0 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-lg p-3 shadow-md">
                <i class="fas {{ ($type ?? 'pelatihan') === 'produk' ? 'fa-box' : 'fa-graduation-cap' }} text-white text-2xl"></i>
            </div>
            
            <div class="flex-1">
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-{{ ($type ?? 'pelatihan') === 'produk' ? 'purple' : 'indigo' }}-100 text-{{ ($type ?? 'pelatihan') === 'produk' ? 'purple' : 'indigo' }}-800 mb-2">
                    <i class="fas {{ ($type ?? 'pelatihan') === 'produk' ? 'fa-box' : 'fa-graduation-cap' }} mr-1"></i>
                    {{ ucfirst($type ?? 'pelatihan') }}
                </span>
                
                <h2 class="text-xl font-bold text-gray-900 mb-2">
                    Survei Kepuasan {{ ($type ?? 'pelatihan') === 'produk' ? 'Produk/Layanan' : 'Pelatihan' }}
                </h2>
                
                <p class="text-sm text-gray-600 leading-relaxed">
                    Kami mengundang Anda untuk mengisi survei kepuasan ini. Masukan Anda sangat berharga untuk membantu kami meningkatkan kualitas {{ ($type ?? 'pelatihan') === 'produk' ? 'produk/layanan' : 'pelatihan' }} kami.
                </p>
            </div>
        </div>
    </div>
@endif
