<x-app-layout>
     <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Analisis Kepuasan dan Potensi Loyalitas') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gradient-to-br from-blue-50 to-indigo-100 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Back to Dashboard Button -->

                    <!-- Back Button -->
           

            <div class="mb-6">
                @if(!empty($campaign))
                    <div class="flex items-start justify-between">
                        <div>
                            <a href="{{ route('grafik.dashboard-campaign', $campaign->id) }}" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-500 to-blue-600 border border-blue-500 rounded-lg shadow-sm text-sm font-medium text-white hover:from-blue-600 hover:to-blue-700 hover:border-blue-600 transition-all duration-200">
                                <i class="fas fa-arrow-left mr-2 text-lg"></i>
                                <span class="font-semibold">Kembali ke Analytics</span>
                            </a>
                            <div class="mt-3">
                                <h3 class="text-2xl font-bold">{{ $campaign->name }}</h3>
                                <p class="text-sm text-gray-600">{{ $campaign->responses_count }} responden • {{ $campaign->start_date->format('d M Y') }} - {{ $campaign->end_date->format('d M Y') }}</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-{{ $campaign->getTypeBadgeColor() }}-100 text-{{ $campaign->getTypeBadgeColor() }}-800">
                                <i class="fas {{ $campaign->getTypeIcon() }} mr-1"></i>
                                {{ ucfirst($campaign->type) }}
                            </span>
                        </div>
                    </div>
                @else
                    <a href="{{ route($type === 'produk' ? 'dashboard.produk' : 'dashboard.pelatihan') }}" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-500 to-blue-600 border border-blue-500 rounded-lg shadow-sm text-sm font-medium text-white hover:from-blue-600 hover:to-blue-700 hover:border-blue-600 transition-all duration-200 transform hover:scale-105">
                        <i class="fas fa-arrow-left mr-2 text-lg"></i>
                        <span class="font-semibold">Kembali ke Dashboard</span>
                    </a>
                @endif
            </div>
            <!-- Pertanyaan Kepuasan Section -->
            <div class="bg-white overflow-hidden shadow-2xl sm:rounded-2xl border-0 relative animate-fade-in mb-8">
                <div class="absolute inset-0 bg-gradient-to-r from-blue-500 via-purple-500 to-pink-500 rounded-2xl opacity-10"></div>
                <div class="relative bg-white sm:rounded-2xl p-8">
                    <div class="mb-8">
                        <div class="flex items-center justify-center mb-8 animate-fade-in">
                            <div class="bg-gradient-to-r from-blue-500 to-purple-600 p-3 rounded-full mr-4 shadow-lg">
                                <i class="fas fa-question-circle text-white text-xl"></i>
                            </div>
                            <div>
                                <h2 class="text-3xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">
                                    Pertanyaan Kepuasan
                                </h2>
                                <p class="text-gray-600 text-sm mt-1">Pertanyaan yang diajukan kepada responden</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            @php
                            $colors = ['blue', 'green', 'purple'];
                            $i = 0;
                            @endphp
                            @foreach($questions['kepuasan_answers'] as $key => $question)
                            <div class="bg-gradient-to-r from-{{ $colors[$i % 3] }}-50 to-{{ $colors[$i % 3] }}-100 rounded-xl p-6 border border-{{ $colors[$i % 3] }}-200">
                                <div class="text-center">
                                    <div class="text-2xl font-bold text-{{ $colors[$i % 3] }}-600 mb-3">{{ strtoupper($key) }}</div>
                                    <div class="text-lg font-semibold text-gray-800 mb-3">{{ ucfirst($key) }} Question</div>
                                    <div class="text-sm text-gray-600 leading-relaxed">
                                        "{{ $question }}"
                                    </div>
                                </div>
                            </div>
                            @php $i++; @endphp
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-2xl sm:rounded-2xl border-0 relative animate-fade-in">
                <!-- Gradient border effect -->
                <div class="absolute inset-0 bg-gradient-to-r from-blue-500 via-purple-500 to-pink-500 rounded-2xl opacity-10"></div>

                <div class="relative bg-white sm:rounded-2xl p-8">
            @php
            function renderGapIdealDiharapkanChart($gap, $total_rata_k3, $total_rata_k2, $avgK1, $avgK2) {
                $output = '';

                // Section container start
                $output .= '<div class="bg-white overflow-hidden shadow-2xl sm:rounded-2xl border-0 relative animate-fade-in mt-8">';
                $output .= '<div class="absolute inset-0 bg-gradient-to-r from-red-500 via-orange-500 to-yellow-500 rounded-2xl opacity-10"></div>';
                $output .= '<div class="relative bg-white sm:rounded-2xl p-8">';
                $output .= '<div class="mb-8">';

                // Header
                $output .= '<div class="flex items-center justify-center mb-8 animate-fade-in">';
                $output .= '<div class="bg-gradient-to-r from-red-500 to-orange-600 p-3 rounded-full mr-4 shadow-lg">';
                $output .= '<i class="fas fa-chart-line text-white text-xl"></i>';
                $output .= '</div>';
                $output .= '<div>';
                $output .= '<h2 class="text-3xl font-bold bg-gradient-to-r from-red-600 to-orange-600 bg-clip-text text-transparent">';
                $output .= __('Gap antara layanan yang ideal dan yang diharapkan');
                $output .= '</h2>';
                $output .= '<p class="text-gray-600 text-sm mt-1">Analisis gap dan rata-rata kepuasan</p>';
                $output .= '</div>';
                $output .= '</div>';

                // Chart container
                $output .= '<div class="flex justify-center mb-6">';
                $output .= '<div id="gap-ideal-chart-container" class="w-full max-w-4xl h-[32rem] chart-container relative overflow-hidden">';
                $output .= '<div id="gap-ideal-chart-loading" class="absolute inset-0 bg-white bg-opacity-90 flex items-center justify-center rounded-xl z-10">';
                $output .= '<div class="text-center">';
                $output .= '<div class="animate-spin rounded-full h-10 w-10 border-b-2 border-red-600 mx-auto mb-4"></div>';
                $output .= '<p class="text-gray-600 font-medium">Memuat grafik gap...</p>';
                $output .= '<p class="text-gray-400 text-sm animate-pulse">Menganalisis data gap</p>';
                $output .= '</div>';
                $output .= '</div>';
                $output .= '</div>';
                $output .= '</div>';

                // Summary cards for averages
                $output .= '<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">';
                $output .= '<div class="bg-gradient-to-r from-blue-50 to-blue-100 rounded-xl p-6 border border-blue-200">';
                $output .= '<div class="text-center">';
                $output .= '<div class="text-3xl font-bold text-blue-600 mb-2">' . number_format($gap, 2) . '</div>';
                $output .= '<div class="text-lg font-semibold text-gray-800 mb-1">Gap</div>';
                $output .= '<div class="text-sm text-gray-600">Selisih ideal vs harapan</div>';
                $output .= '</div>';
                $output .= '</div>';

                $output .= '<div class="bg-gradient-to-r from-green-50 to-green-100 rounded-xl p-6 border border-green-200">';
                $output .= '<div class="text-center">';
                $output .= '<div class="text-3xl font-bold text-green-600 mb-2">' . number_format($total_rata_k3, 2) . '</div>';
                $output .= '<div class="text-lg font-semibold text-gray-800 mb-1">Rata-rata K3</div>';
                $output .= '<div class="text-sm text-gray-600">Layanan ideal</div>';
                $output .= '</div>';
                $output .= '</div>';

                $output .= '<div class="bg-gradient-to-r from-purple-50 to-purple-100 rounded-xl p-6 border border-purple-200">';
                $output .= '<div class="text-center">';
                $output .= '<div class="text-3xl font-bold text-purple-600 mb-2">' . number_format($total_rata_k2, 2) . '</div>';
                $output .= '<div class="text-lg font-semibold text-gray-800 mb-1">Rata-rata K2</div>';
                $output .= '<div class="text-sm text-gray-600">Harapan pelanggan</div>';
                $output .= '</div>';
                $output .= '</div>';
                $output .= '</div>';

                // Section container end
                $output .= '</div>';
                $output .= '</div>';
                $output .= '</div>';

                return $output;
            }

            function renderKepuasanChart($kepuasanDistribution, $k1_count, $k1_rata_count_1, $k1_rata_count_2, $k1_rata_count_3, $k1_rata_count_4, $k1_rata_count_5) {
                $output = '';

                // Section container start
                $output .= '<div class="bg-white overflow-hidden shadow-2xl sm:rounded-2xl border-0 relative animate-fade-in mt-8">';
                $output .= '<div class="absolute inset-0 bg-gradient-to-r from-green-500 via-teal-500 to-cyan-500 rounded-2xl opacity-10"></div>';
                $output .= '<div class="relative bg-white sm:rounded-2xl p-8">';
                $output .= '<div class="mb-8">';

                // Header
                $output .= '<div class="flex items-center justify-center mb-8 animate-fade-in">';
                $output .= '<div class="bg-gradient-to-r from-green-500 to-teal-600 p-3 rounded-full mr-4 shadow-lg">';
                $output .= '<i class="fas fa-chart-bar text-white text-xl"></i>';
                $output .= '</div>';
                $output .= '<div>';
                $output .= '<h2 class="text-3xl font-bold bg-gradient-to-r from-green-600 to-teal-600 bg-clip-text text-transparent">';
                $output .= __('Distribusi Kepuasan');
                $output .= '</h2>';
                $output .= '<p class="text-gray-600 text-sm mt-1">Sebaran tingkat kepuasan responden</p>';
                $output .= '</div>';
                $output .= '</div>';

                // Chart container
                $output .= '<div class="flex justify-center mb-6">';
                $output .= '<div id="kepuasan-chart-container" class="w-full max-w-4xl h-[28rem] chart-container relative overflow-hidden">';
                $output .= '<div id="kepuasan-chart-loading" class="absolute inset-0 bg-white bg-opacity-90 flex items-center justify-center rounded-xl z-10">';
                $output .= '<div class="text-center">';
                $output .= '<div class="animate-spin rounded-full h-10 w-10 border-b-2 border-green-600 mx-auto mb-4"></div>';
                $output .= '<p class="text-gray-600 font-medium">Memuat grafik kepuasan...</p>';
                $output .= '<p class="text-gray-400 text-sm animate-pulse">Menganalisis distribusi kepuasan</p>';
                $output .= '</div>';
                $output .= '</div>';
                $output .= '</div>';
                $output .= '</div>';

                // Summary cards for satisfaction distribution
                $output .= '<div class="grid grid-cols-1 md:grid-cols-5 gap-4 mb-6">';

                // Satisfaction levels
                $levels = [
                    ['label' => 'Sangat Puas', 'count' => $k1_rata_count_5, 'color' => 'green'],
                    ['label' => 'Puas', 'count' => $k1_rata_count_4, 'color' => 'blue'],
                    ['label' => 'Cukup Puas', 'count' => $k1_rata_count_3, 'color' => 'yellow'],
                    ['label' => 'Kurang Puas', 'count' => $k1_rata_count_2, 'color' => 'orange'],
                    ['label' => 'Tidak Puas', 'count' => $k1_rata_count_1, 'color' => 'red']
                ];

                foreach ($levels as $level) {
                    $percentage = $k1_count > 0 ? ($level['count'] / $k1_count) * 100 : 0;
                    $output .= '<div class="bg-gradient-to-r from-' . $level['color'] . '-50 to-' . $level['color'] . '-100 rounded-xl p-4 border border-' . $level['color'] . '-200">';
                    $output .= '<div class="text-center">';
                    $output .= '<div class="text-2xl font-bold text-' . $level['color'] . '-600 mb-1">' . $level['count'] . '</div>';
                    $output .= '<div class="text-sm font-semibold text-gray-800 mb-1">' . $level['label'] . '</div>';
                    $output .= '<div class="text-xs text-gray-600">' . number_format($percentage, 1) . '%</div>';
                    $output .= '</div>';
                    $output .= '</div>';
                }

                $output .= '</div>';

                // Section container end
                $output .= '</div>';
                $output .= '</div>';
                $output .= '</div>';

                return $output;
            }

            function renderKesimpulan($totalRespondents, $potensiLoyal, $ikpPercentage, $ilpPercentage) {
                $output = '';

                // Section container start
                $output .= '<div class="bg-white overflow-hidden shadow-2xl sm:rounded-2xl border-0 relative animate-fade-in mt-8">';
                $output .= '<div class="absolute inset-0 bg-gradient-to-r from-purple-500 via-blue-500 to-cyan-500 rounded-2xl opacity-10"></div>';
                $output .= '<div class="relative bg-white sm:rounded-2xl p-8">';
                $output .= '<div class="mb-8">';

                // Header
                $output .= '<div class="flex items-center justify-center mb-8 animate-fade-in">';
                $output .= '<div class="bg-gradient-to-r from-purple-500 to-blue-600 p-3 rounded-full mr-4 shadow-lg">';
                $output .= '<i class="fas fa-trophy text-white text-xl"></i>';
                $output .= '</div>';
                $output .= '<div>';
                $output .= '<h2 class="text-3xl font-bold bg-gradient-to-r from-purple-600 to-blue-600 bg-clip-text text-transparent">';
                $output .= __('Kesimpulan dan Potensi Loyalitas');
                $output .= '</h2>';
                $output .= '<p class="text-gray-600 text-sm mt-1">Ringkasan hasil survey dan analisis loyalitas</p>';
                $output .= '</div>';
                $output .= '</div>';

                // Summary cards
                $output .= '<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">';

                // Total Respondents
                $output .= '<div class="bg-gradient-to-r from-blue-50 to-blue-100 rounded-xl p-6 border border-blue-200">';
                $output .= '<div class="text-center">';
                $output .= '<div class="text-4xl font-bold text-blue-600 mb-2">' . $totalRespondents . '</div>';
                $output .= '<div class="text-lg font-semibold text-gray-800 mb-1">Total Responden</div>';
                $output .= '<div class="text-sm text-gray-600">Jumlah responden survey</div>';
                $output .= '</div>';
                $output .= '</div>';

                // Potensi Loyal
                $output .= '<div class="bg-gradient-to-r from-green-50 to-green-100 rounded-xl p-6 border border-green-200">';
                $output .= '<div class="text-center">';
                $output .= '<div class="text-4xl font-bold text-green-600 mb-2">' . $potensiLoyal . '</div>';
                $output .= '<div class="text-lg font-semibold text-gray-800 mb-1">Potensi Loyal</div>';
                $output .= '<div class="text-sm text-gray-600">Responden berpotensi loyal</div>';
                $output .= '</div>';
                $output .= '</div>';

                // IKP Percentage
                $output .= '<div class="bg-gradient-to-r from-purple-50 to-purple-100 rounded-xl p-6 border border-purple-200">';
                $output .= '<div class="text-center">';
                $output .= '<div class="text-4xl font-bold text-purple-600 mb-2">' . number_format($ikpPercentage, 1) . '%</div>';
                $output .= '<div class="text-lg font-semibold text-gray-800 mb-1">Indeks Kepuasan</div>';
                $output .= '<div class="text-sm text-gray-600">IKP rata-rata</div>';
                $output .= '</div>';
                $output .= '</div>';

                // ILP Percentage
                $output .= '<div class="bg-gradient-to-r from-orange-50 to-orange-100 rounded-xl p-6 border border-orange-200">';
                $output .= '<div class="text-center">';
                $output .= '<div class="text-4xl font-bold text-orange-600 mb-2">' . number_format($ilpPercentage, 1) . '%</div>';
                $output .= '<div class="text-lg font-semibold text-gray-800 mb-1">Indeks Loyalitas</div>';
                $output .= '<div class="text-sm text-gray-600">ILP rata-rata</div>';
                $output .= '</div>';
                $output .= '</div>';

                $output .= '</div>';

                // Detailed analysis
                $loyalPercentage = $totalRespondents > 0 ? ($potensiLoyal / $totalRespondents) * 100 : 0;
                $output .= '<div class="bg-gradient-to-r from-gray-50 to-gray-100 rounded-xl p-6 border border-gray-200">';
                $output .= '<h3 class="text-xl font-bold text-gray-800 mb-4">Analisis Detail</h3>';
                $output .= '<div class="space-y-3">';
                $output .= '<p class="text-gray-700"><strong>Persentase Potensi Loyal:</strong> ' . number_format($loyalPercentage, 1) . '% dari total responden</p>';
                $output .= '<p class="text-gray-700"><strong>Status Kepuasan:</strong> ' . ($ikpPercentage >= 80 ? 'Sangat Baik' : ($ikpPercentage >= 60 ? 'Baik' : 'Perlu Perbaikan')) . '</p>';
                $output .= '<p class="text-gray-700"><strong>Status Loyalitas:</strong> ' . ($ilpPercentage >= 80 ? 'Sangat Loyal' : ($ilpPercentage >= 60 ? 'Loyal' : 'Perlu Perbaikan')) . '</p>';
                $output .= '</div>';
                $output .= '</div>';

                // Section container end
                $output .= '</div>';
                $output .= '</div>';
                $output .= '</div>';

                return $output;
            }
            @endphp

            {!! renderGapIdealDiharapkanChart($gap, $total_rata_k3, $total_rata_k2, $avgK1, $avgK2) !!}
            {!! renderKepuasanChart($kepuasanDistribution, $k1_count, $k1_rata_count_1, $k1_rata_count_2, $k1_rata_count_3, $k1_rata_count_4, $k1_rata_count_5) !!}
            {!! renderKesimpulan(count($responses), $potensiLoyal, $ikpPercentage, $ilpPercentage) !!}
        </div>
    </div>
</x-app-layout>
<script src="https://d3js.org/d3.v7.min.js"></script>
<style>
.tooltip {
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    box-shadow: 0 10px 25px rgba(0,0,0,0.2);
    max-width: 280px;
    word-wrap: break-word;
    border-radius: 8px;
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255,255,255,0.2);
    position: relative;
    text-align: center;
}

.bar:hover {
    filter: brightness(1.1);
}

/* Chart container enhancements */
.chart-container {
    position: relative;
    background: linear-gradient(135deg, rgba(59, 130, 246, 0.05) 0%, rgba(139, 92, 246, 0.05) 100%);
    border: 2px solid transparent;
    background-clip: padding-box;
    border-radius: 12px;
}

.chart-container::before {
    content: '';
    position: absolute;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    z-index: -1;
    margin: -2px;
    border-radius: inherit;
    background: linear-gradient(135deg, #3B82F6, #8B5CF6);
}

/* Responsive improvements */
@media (max-width: 768px) {
    .chart-container {
        height: 300px !important;
    }

    .tooltip {
        max-width: 200px;
        font-size: 11px;
    }
}

/* Custom animations */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.animate-fade-in-up {
    animation: fadeInUp 0.6s ease-out;
}
</style>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Configuration for charts
    const chartConfig = {
        margin: {top: 20, right: 30, bottom: 60, left: 60},
        width: 800,
        height: 400,
        colors: {
            gap: '#DC2626',
            kepuasan: '#10B981',
            positive: '#10B981',
            negative: '#EF4444'
        }
    };

    // Function to create gap ideal vs harapan chart
    function createGapIdealChart(data, containerId) {
        try {
            const margin = chartConfig.margin;
            const width = chartConfig.width - margin.left - margin.right;
            const height = chartConfig.height - margin.top - margin.bottom;

            // Clear existing chart
            const container = d3.select(`#${containerId}`);
            container.selectAll('*').remove();

            const svg = container
                .append('svg')
                .attr('width', width + margin.left + margin.right)
                .attr('height', height + margin.top + margin.bottom)
                .append('g')
                .attr('transform', `translate(${margin.left},${margin.top})`);

            // Create tooltip
            const tooltip = d3.select(`#${containerId}`)
                .append('div')
                .attr('class', 'tooltip')
                .style('position', 'absolute')
                .style('background', 'rgba(0, 0, 0, 0.8)')
                .style('color', 'white')
                .style('padding', '8px 12px')
                .style('border-radius', '4px')
                .style('font-size', '12px')
                .style('pointer-events', 'none')
                .style('opacity', 0)
                .style('z-index', 1000);

            // Prepare data for two bars: Ideal (K3) and Harapan (K2)
            const chartData = [
                { label: 'Layanan Ideal', value: data.total_rata_k3, color: '#10B981' },
                { label: 'Harapan', value: data.total_rata_k2, color: '#3B82F6' }
            ];

            // Scales
            const x = d3.scaleBand()
                .domain(chartData.map(d => d.label))
                .range([0, width])
                .padding(0.3);

            const y = d3.scaleLinear()
                .domain([0, d3.max(chartData, d => d.value) + 1])
                .nice()
                .range([height, 0]);

            // Create bars
            svg.selectAll('.bar')
                .data(chartData)
                .enter().append('rect')
                .attr('class', 'bar')
                .attr('x', d => x(d.label))
                .attr('y', d => y(d.value))
                .attr('width', x.bandwidth())
                .attr('height', d => height - y(d.value))
                .attr('fill', d => d.color)
                .attr('opacity', 0.8)
                .style('cursor', 'pointer')
                .on('mouseover', function(event, d) {
                    tooltip
                        .style('opacity', 1)
                        .html(`<div class="font-semibold">${d.label}</div>
                               <div>Rata-rata: ${d.value.toFixed(2)}</div>`);

                    d3.select(this).attr('opacity', 1);
                })
                .on('mousemove', function(event) {
                    tooltip
                        .style('left', (event.pageX + 10) + 'px')
                        .style('top', (event.pageY - 10) + 'px');
                })
                .on('mouseout', function() {
                    tooltip.style('opacity', 0);
                    d3.select(this).attr('opacity', 0.8);
                });

            // Add data labels
            svg.selectAll('.label')
                .data(chartData)
                .enter().append('text')
                .attr('class', 'label')
                .attr('x', d => x(d.label) + x.bandwidth() / 2)
                .attr('y', d => y(d.value) - 5)
                .attr('text-anchor', 'middle')
                .attr('font-size', '12px')
                .attr('fill', '#333')
                .text(d => d.value.toFixed(2));

            // Add axes
            svg.append('g')
                .attr('transform', `translate(0,${height})`)
                .call(d3.axisBottom(x))
                .selectAll('text')
                .attr('transform', 'rotate(-45)')
                .style('text-anchor', 'end');

            svg.append('g')
                .call(d3.axisLeft(y));

            // Add gap line and annotation
            const gap = data.gap;
            const midX = (x('Layanan Ideal') + x.bandwidth() / 2 + x('Harapan') + x.bandwidth() / 2) / 2;
            const gapY = height / 2;

            // Gap line
            svg.append('line')
                .attr('x1', x('Layanan Ideal') + x.bandwidth())
                .attr('y1', y(chartData[0].value))
                .attr('x2', x('Harapan'))
                .attr('y2', y(chartData[1].value))
                .attr('stroke', gap >= 0 ? '#10B981' : '#EF4444')
                .attr('stroke-width', 2)
                .attr('stroke-dasharray', '5,5');

            // Gap annotation
            svg.append('text')
                .attr('x', midX)
                .attr('y', gapY - 20)
                .attr('text-anchor', 'middle')
                .attr('font-size', '14px')
                .attr('font-weight', 'bold')
                .attr('fill', gap >= 0 ? '#10B981' : '#EF4444')
                .text(`Gap: ${gap.toFixed(2)}`);

            // Add title
            svg.append('text')
                .attr('x', width / 2)
                .attr('y', -10)
                .attr('text-anchor', 'middle')
                .attr('font-size', '16px')
                .attr('font-weight', 'bold')
                .text('Perbandingan Layanan Ideal vs Harapan');

            // Hide loading overlay
            d3.select(`#${containerId}-loading`).style('display', 'none');

        } catch (error) {
            console.error('Error creating gap ideal chart:', error);
            d3.select(`#${containerId}`)
                .html('<div class="text-center py-8 text-red-600"><i class="fas fa-exclamation-triangle text-2xl mb-2"></i><br>Gagal memuat grafik gap</div>');
        }
    }

    // Function to create kepuasan distribution chart
    function createKepuasanChart(data, containerId) {
        try {
            const margin = chartConfig.margin;
            const width = chartConfig.width - margin.left - margin.right;
            const height = chartConfig.height - margin.top - margin.bottom;

            // Clear existing chart
            const container = d3.select(`#${containerId}`);
            container.selectAll('*').remove();

            const svg = container
                .append('svg')
                .attr('width', width + margin.left + margin.right)
                .attr('height', height + margin.top + margin.bottom)
                .append('g')
                .attr('transform', `translate(${margin.left},${margin.top})`);

            // Create tooltip
            const tooltip = d3.select(`#${containerId}`)
                .append('div')
                .attr('class', 'tooltip')
                .style('position', 'absolute')
                .style('background', 'rgba(0, 0, 0, 0.8)')
                .style('color', 'white')
                .style('padding', '8px 12px')
                .style('border-radius', '4px')
                .style('font-size', '12px')
                .style('pointer-events', 'none')
                .style('opacity', 0)
                .style('z-index', 1000);

            // Prepare data for satisfaction levels
            const chartData = [
                { label: 'Tidak Puas', value: data.tidak_puas, color: '#EF4444' },
                { label: 'Kurang Puas', value: data.kurang_puas, color: '#F97316' },
                { label: 'Cukup Puas', value: data.cukup_puas, color: '#F59E0B' },
                { label: 'Puas', value: data.puas, color: '#3B82F6' },
                { label: 'Sangat Puas', value: data.sangat_puas, color: '#10B981' }
            ];

            // Scales
            const x = d3.scaleBand()
                .domain(chartData.map(d => d.label))
                .range([0, width])
                .padding(0.3);

            const y = d3.scaleLinear()
                .domain([0, d3.max(chartData, d => d.value) + 1])
                .nice()
                .range([height, 0]);

            // Create bars
            svg.selectAll('.bar')
                .data(chartData)
                .enter().append('rect')
                .attr('class', 'bar')
                .attr('x', d => x(d.label))
                .attr('y', d => y(d.value))
                .attr('width', x.bandwidth())
                .attr('height', d => height - y(d.value))
                .attr('fill', d => d.color)
                .attr('opacity', 0.8)
                .style('cursor', 'pointer')
                .on('mouseover', function(event, d) {
                    tooltip
                        .style('opacity', 1)
                        .html(`<div class="font-semibold">${d.label}</div>
                               <div>Jumlah: ${d.value}</div>`);

                    d3.select(this).attr('opacity', 1);
                })
                .on('mousemove', function(event) {
                    tooltip
                        .style('left', (event.pageX + 10) + 'px')
                        .style('top', (event.pageY - 10) + 'px');
                })
                .on('mouseout', function() {
                    tooltip.style('opacity', 0);
                    d3.select(this).attr('opacity', 0.8);
                });

            // Add data labels
            svg.selectAll('.label')
                .data(chartData)
                .enter().append('text')
                .attr('class', 'label')
                .attr('x', d => x(d.label) + x.bandwidth() / 2)
                .attr('y', d => y(d.value) - 5)
                .attr('text-anchor', 'middle')
                .attr('font-size', '12px')
                .attr('fill', '#333')
                .text(d => d.value);

            // Add axes
            svg.append('g')
                .attr('transform', `translate(0,${height})`)
                .call(d3.axisBottom(x))
                .selectAll('text')
                .attr('transform', 'rotate(-45)')
                .style('text-anchor', 'end');

            svg.append('g')
                .call(d3.axisLeft(y));

            // Add title
            svg.append('text')
                .attr('x', width / 2)
                .attr('y', -10)
                .attr('text-anchor', 'middle')
                .attr('font-size', '16px')
                .attr('font-weight', 'bold')
                .text('Distribusi Tingkat Kepuasan');

            // Hide loading overlay
            d3.select(`#${containerId}-loading`).style('display', 'none');

        } catch (error) {
            console.error('Error creating kepuasan chart:', error);
            d3.select(`#${containerId}`)
                .html('<div class="text-center py-8 text-red-600"><i class="fas fa-exclamation-triangle text-2xl mb-2"></i><br>Gagal memuat grafik kepuasan</div>');
        }
    }

    // Debounce utility function
    function debounce(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    }

    // Async rendering wrapper
    function renderChartAsync(chartFunction, ...args) {
        requestAnimationFrame(() => {
            chartFunction(...args);
        });
    }

    // Initialize charts
    const avgK1 = @json($avgK1);
    const avgK2 = @json($avgK2);
    const gap = @json($gap);
    const total_rata_k3 = @json($total_rata_k3);
    const total_rata_k2 = @json($total_rata_k2);
    const kepuasanDistribution = @json($kepuasanDistribution);
    const k1_count = @json($k1_count);
    const k1_rata_count_1 = @json($k1_rata_count_1);
    const k1_rata_count_2 = @json($k1_rata_count_2);
    const k1_rata_count_3 = @json($k1_rata_count_3);
    const k1_rata_count_4 = @json($k1_rata_count_4);
    const k1_rata_count_5 = @json($k1_rata_count_5);

    // Load charts immediately for testing
    setTimeout(() => {
        console.log('Loading gap ideal chart...');
        const gapData = {
            gap: gap,
            total_rata_k3: total_rata_k3,
            total_rata_k2: total_rata_k2
        };
        renderChartAsync(createGapIdealChart, gapData, 'gap-ideal-chart-container');

        console.log('Loading kepuasan chart...');
        // Use the satisfaction distribution data for the chart
        const satisfactionData = {
            'tidak_puas': k1_rata_count_1,
            'kurang_puas': k1_rata_count_2,
            'cukup_puas': k1_rata_count_3,
            'puas': k1_rata_count_4,
            'sangat_puas': k1_rata_count_5
        };
        renderChartAsync(createKepuasanChart, satisfactionData, 'kepuasan-chart-container');
    }, 1000);

    // Add debounced click handler for tooltips globally
    const debouncedTooltipHandler = debounce((event) => {
        if (!d3.select(event.target).classed('bar')) {
            d3.selectAll('.tooltip').style('opacity', 0);
        }
    }, 300);

    d3.select('body').on('click', debouncedTooltipHandler);
});
</script>
