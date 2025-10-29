<x-app-layout>
     <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Analisis Loyalitas Pelanggan') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gradient-to-br from-blue-50 to-indigo-100 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Back Button / Campaign Header -->
            <div class="mb-6">
                @if(!empty($campaign))
                    <div class="flex items-start justify-between">
                        <div>
                            <a href="{{ route('grafik.dashboard-campaign', $campaign->id) }}" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-indigo-500 to-indigo-600 border border-indigo-500 rounded-lg shadow-sm text-sm font-medium text-white hover:from-indigo-600 hover:to-indigo-700 hover:border-indigo-600 transition-all duration-200">
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
                    <a href="{{ route($type === 'produk' ? 'dashboard.produk' : 'dashboard.pelatihan') }}" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-indigo-500 to-indigo-600 border border-indigo-500 rounded-lg shadow-sm text-sm font-medium text-white hover:from-indigo-600 hover:to-indigo-700 hover:border-indigo-600 transition-all duration-200 transform hover:scale-105">
                        <i class="fas fa-arrow-left mr-2 text-lg"></i>
                        <span class="font-semibold">Kembali ke Dashboard</span>
                    </a>
                @endif
            </div>


            <div class="bg-white overflow-hidden shadow-2xl sm:rounded-2xl border-0 relative animate-fade-in">
                <!-- Gradient border effect -->
                <div class="absolute inset-0 bg-gradient-to-r from-blue-500 via-purple-500 to-pink-500 rounded-2xl opacity-10"></div>

                <div class="relative bg-white sm:rounded-2xl p-8">
            @php
            function renderLoyalitasQuestionChart($distribution, $questionNumber, $avgScore, $questions) {
                $output = '';

                // Section container start
                $output .= '<div class="bg-white overflow-hidden shadow-2xl sm:rounded-2xl border-0 relative animate-fade-in mt-8">';
                $output .= '<div class="absolute inset-0 bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500 rounded-2xl opacity-10"></div>';
                $output .= '<div class="relative bg-white sm:rounded-2xl p-8">';
                $output .= '<div class="mb-8">';

                // Header
                $output .= '<div class="flex items-center justify-center mb-8 animate-fade-in">';
                $output .= '<div class="bg-gradient-to-r from-indigo-500 to-purple-600 p-3 rounded-full mr-4 shadow-lg">';
                $output .= '<i class="fas fa-star text-white text-xl"></i>';
                $output .= '</div>';
                $output .= '<div>';
                $output .= '<h2 class="text-3xl font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">';
                $output .= __('Pertanyaan Loyalitas L' . $questionNumber);
                $output .= '</h2>';
                $output .= '<p class="text-gray-600 text-sm mt-1">Distribusi jawaban dan rata-rata skor</p>';
                $output .= '</div>';
                $output .= '</div>';

                // Question Text Card
                $questionKey = 'l' . $questionNumber;
                $questionText = $questions['loyalitas_answers'][$questionKey] ?? 'Pertanyaan tidak ditemukan';
                $output .= '<div class="bg-gradient-to-r from-indigo-50 to-purple-100 rounded-xl p-6 mb-6 border border-indigo-200">';
                $output .= '<div class="flex items-start">';
                $output .= '<div class="bg-indigo-600 text-white rounded-full w-8 h-8 flex items-center justify-center font-bold text-sm mr-4 flex-shrink-0">L' . $questionNumber . '</div>';
                $output .= '<div>';
                $output .= '<h3 class="text-lg font-semibold text-gray-800 mb-2">Pertanyaan:</h3>';
                $output .= '<p class="text-gray-700 leading-relaxed">' . $questionText . '</p>';
                $output .= '</div>';
                $output .= '</div>';
                $output .= '</div>';

                // Chart container
                $output .= '<div class="flex justify-center mb-6">';
                $output .= '<div id="loyalitas-l' . $questionNumber . '-chart-container" class="w-full max-w-4xl h-[32rem] chart-container relative overflow-hidden">';
                $output .= '<div id="loyalitas-l' . $questionNumber . '-chart-loading" class="absolute inset-0 bg-white bg-opacity-90 flex items-center justify-center rounded-xl z-10">';
                $output .= '<div class="text-center">';
                $output .= '<div class="animate-spin rounded-full h-10 w-10 border-b-2 border-indigo-600 mx-auto mb-4"></div>';
                $output .= '<p class="text-gray-600 font-medium">Memuat grafik L' . $questionNumber . '...</p>';
                $output .= '<p class="text-gray-400 text-sm animate-pulse">Menganalisis distribusi jawaban</p>';
                $output .= '</div>';
                $output .= '</div>';
                $output .= '</div>';
                $output .= '</div>';

                // Average score card
                $output .= '<div class="bg-gradient-to-r from-indigo-50 to-purple-100 rounded-xl p-6 border border-indigo-200 mb-6">';
                $output .= '<div class="text-center">';
                $output .= '<div class="text-4xl font-bold text-indigo-600 mb-2">' . number_format($avgScore, 2) . '</div>';
                $output .= '<div class="text-lg font-semibold text-gray-800 mb-1">Rata-rata Skor L' . $questionNumber . '</div>';
                $output .= '<div class="text-sm text-gray-600">Skala 1-5 (1 = Sangat Tidak Setuju, 5 = Sangat Setuju)</div>';
                $output .= '</div>';
                $output .= '</div>';

                // Section container end
                $output .= '</div>';
                $output .= '</div>';
                $output .= '</div>';

                return $output;
            }

            function renderILPTable($ilpPercentage, $ilpInterpretation) {
                $output = '';

                // Section container start
                $output .= '<div class="bg-white overflow-hidden shadow-2xl sm:rounded-2xl border-0 relative animate-fade-in mt-8">';
                $output .= '<div class="absolute inset-0 bg-gradient-to-r from-emerald-500 via-teal-500 to-cyan-500 rounded-2xl opacity-10"></div>';
                $output .= '<div class="relative bg-white sm:rounded-2xl p-8">';
                $output .= '<div class="mb-8">';

                // Header
                $output .= '<div class="flex items-center justify-center mb-8 animate-fade-in">';
                $output .= '<div class="bg-gradient-to-r from-emerald-500 to-teal-600 p-3 rounded-full mr-4 shadow-lg">';
                $output .= '<i class="fas fa-trophy text-white text-xl"></i>';
                $output .= '</div>';
                $output .= '<div>';
                $output .= '<h2 class="text-3xl font-bold bg-gradient-to-r from-emerald-600 to-teal-600 bg-clip-text text-transparent">';
                $output .= __('Indeks Loyalitas Pelanggan (ILP)');
                $output .= '</h2>';
                $output .= '<p class="text-gray-600 text-sm mt-1">Ringkasan tingkat loyalitas pelanggan secara keseluruhan</p>';
                $output .= '</div>';
                $output .= '</div>';

                // ILP Summary Card
                $output .= '<div class="bg-gradient-to-r from-emerald-50 to-teal-50 rounded-xl p-6 mb-6 border border-emerald-200">';
                $output .= '<div class="text-center">';
                $output .= '<div class="text-6xl font-bold text-emerald-600 mb-2">' . number_format($ilpPercentage, 1) . '%</div>';
                $output .= '<div class="text-xl font-semibold text-gray-800 mb-1">' . $ilpInterpretation . '</div>';
                $output .= '<div class="text-sm text-gray-600">Indeks Loyalitas Pelanggan</div>';
                $output .= '</div>';
                $output .= '</div>';

                // ILP Scale Table
                $output .= '<div class="overflow-x-auto animate-fade-in">';
                $output .= '<table class="min-w-full divide-y divide-gray-200 bg-white border-0 overflow-hidden rounded-xl shadow-md">';
                $output .= '<thead class="bg-gradient-to-r from-emerald-500 to-teal-600">';
                $output .= '<tr>';
                $output .= '<th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">';
                $output .= '<span class="flex items-center">';
                $output .= '<i class="fas fa-chart-line mr-2"></i>';
                $output .= 'Rentang Skor';
                $output .= '</span></th>';
                $output .= '<th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">Kategori</th>';
                $output .= '<th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">Interpretasi</th>';
                $output .= '<th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">Status</th>';
                $output .= '</tr>';
                $output .= '</thead>';
                $output .= '<tbody class="bg-white divide-y divide-gray-200">';

                $scales = [
                    ['range' => '81-100', 'category' => 'Sangat Loyal', 'interpretation' => 'Tingkat loyalitas sangat tinggi, pelanggan sangat setia', 'color' => 'emerald'],
                    ['range' => '66-80', 'category' => 'Loyal', 'interpretation' => 'Tingkat loyalitas baik, pelanggan cenderung setia', 'color' => 'green'],
                    ['range' => '51-65', 'category' => 'Cukup Loyal', 'interpretation' => 'Tingkat loyalitas cukup, perlu perbaikan', 'color' => 'lime'],
                    ['range' => '35-50', 'category' => 'Kurang Loyal', 'interpretation' => 'Tingkat loyalitas rendah, risiko kehilangan pelanggan', 'color' => 'yellow'],
                    ['range' => '0-34', 'category' => 'Tidak Loyal', 'interpretation' => 'Tingkat loyalitas sangat rendah, pelanggan mudah beralih', 'color' => 'red']
                ];

                foreach ($scales as $scale) {
                    $isCurrent = false;
                    if (($ilpPercentage >= 81 && $scale['range'] === '81-100') ||
                        ($ilpPercentage >= 66 && $ilpPercentage <= 80 && $scale['range'] === '66-80') ||
                        ($ilpPercentage >= 51 && $ilpPercentage <= 65 && $scale['range'] === '51-65') ||
                        ($ilpPercentage >= 35 && $ilpPercentage <= 50 && $scale['range'] === '35-50') ||
                        ($ilpPercentage >= 0 && $ilpPercentage <= 34 && $scale['range'] === '0-34')) {
                        $isCurrent = true;
                    }

                    $rowClass = $isCurrent ? 'bg-' . $scale['color'] . '-50 border-l-4 border-' . $scale['color'] . '-500' : 'hover:bg-gray-50';
                    $statusIcon = $isCurrent ? '<i class="fas fa-check-circle text-' . $scale['color'] . '-600"></i>' : '<i class="fas fa-circle text-gray-300"></i>';

                    $output .= '<tr class="' . $rowClass . ' hover:transform hover:translate-y-[-1px] transition-all duration-200">';
                    $output .= '<td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">' . $scale['range'] . '</td>';
                    $output .= '<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-semibold">' . $scale['category'] . '</td>';
                    $output .= '<td class="px-6 py-4 text-sm text-gray-700">' . $scale['interpretation'] . '</td>';
                    $output .= '<td class="px-6 py-4 whitespace-nowrap text-sm text-center">' . $statusIcon . '</td>';
                    $output .= '</tr>';
                }

                $output .= '</tbody>';
                $output .= '</table>';
                $output .= '</div>';

                // Section container end
                $output .= '</div>';
                $output .= '</div>';
                $output .= '</div>';

                return $output;
            }
            @endphp

            {!! renderLoyalitasQuestionChart($l1Distribution, 1, $avgL1, $questions) !!}
            {!! renderLoyalitasQuestionChart($l2Distribution, 2, $avgL2, $questions) !!}
            {!! renderLoyalitasQuestionChart($l3Distribution, 3, $avgL3, $questions) !!}
            {!! renderILPTable($ilpPercentage, $ilpInterpretation) !!}
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
        margin: {top: 20, right: 30, bottom: 80, left: 60},
        width: 1000,
        height: 500,
        colors: {
            sangat_setuju: '#10B981',
            setuju: '#22C55E',
            netral: '#EAB308',
            tidak_setuju: '#F97316',
            sangat_tidak_setuju: '#EF4444'
        }
    };

    // Function to create loyalitas question chart
    function createLoyalitasChart(data, containerId, questionNumber) {
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

            // Hide tooltip when clicking outside
            d3.select('body').on('click', function(event) {
                if (!d3.select(event.target).classed('bar')) {
                    tooltip.style('opacity', 0);
                }
            });

            // Prepare data
            const categories = Object.keys(data);
            const values = categories.map(cat => data[cat]);
            const colors = [
                chartConfig.colors.sangat_setuju,
                chartConfig.colors.setuju,
                chartConfig.colors.netral,
                chartConfig.colors.tidak_setuju,
                chartConfig.colors.sangat_tidak_setuju
            ];

            // Scales
            const x = d3.scaleBand()
                .domain(categories)
                .range([0, width])
                .padding(0.1);

            const y = d3.scaleLinear()
                .domain([0, d3.max(values) + 2])
                .nice()
                .range([height, 0]);

            // Create bars with animation
            const bars = svg.selectAll('.bar')
                .data(categories)
                .enter().append('rect')
                .attr('class', 'bar')
                .attr('x', d => x(d))
                .attr('y', height) // Start from bottom
                .attr('width', x.bandwidth())
                .attr('height', 0) // Start with height 0
                .attr('fill', (d, i) => colors[i])
                .attr('opacity', 0.8)
                .style('cursor', 'pointer');

            // Animate bars
            bars.transition()
                .duration(800)
                .attr('y', d => y(data[d]))
                .attr('height', d => height - y(data[d]))
                .delay((d, i) => i * 100) // Stagger animation
                .ease(d3.easeBounce);

            // Add hover effects and tooltips
            bars.on('click', function(event, d) {
                const value = data[d];
                const labels = {
                    'sangat_setuju': 'Sangat Setuju',
                    'setuju': 'Setuju',
                    'netral': 'Netral',
                    'tidak_setuju': 'Tidak Setuju',
                    'sangat_tidak_setuju': 'Sangat Tidak Setuju'
                };

                let tooltipContent = `<div class="font-semibold">${labels[d] || d}</div>
                                   <div>Jumlah: ${value} responden</div>
                                   <div class="text-xs mt-1">Pertanyaan L${questionNumber}</div>`;

                // Position tooltip above the bar
                const barX = parseFloat(d3.select(this).attr('x')) + x.bandwidth() / 2;
                const barY = parseFloat(d3.select(this).attr('y'));
                const containerRect = container.node().getBoundingClientRect();
                const svgRect = svg.node().getBoundingClientRect();
                const tooltipX = svgRect.left - containerRect.left + margin.left + barX;
                const tooltipY = svgRect.top - containerRect.top + margin.top + barY - 8;

                tooltip
                    .style('opacity', 1)
                    .html(tooltipContent)
                    .style('left', tooltipX + 'px')
                    .style('top', tooltipY + 'px');
            });

            // Add data labels with animation
            svg.selectAll('.label')
                .data(categories)
                .enter().append('text')
                .attr('class', 'label')
                .attr('x', d => x(d) + x.bandwidth() / 2)
                .attr('y', d => y(data[d]) - 5)
                .attr('text-anchor', 'middle')
                .attr('font-size', '12px')
                .attr('fill', '#333')
                .style('opacity', 0)
                .text(d => data[d])
                .transition()
                .duration(500)
                .delay((d, i) => 1000 + i * 100)
                .style('opacity', 1);

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
                .text(`Distribusi Jawaban L${questionNumber}`);

            // Add legend with animation
            const legendWidth = 400;
            const legend = svg.append('g')
                .attr('class', 'legend')
                .attr('transform', `translate(${(width - legendWidth) / 2}, ${height + 50})`)
                .style('opacity', 0);

            const legendItems = [
                { label: 'Sangat Setuju', color: chartConfig.colors.sangat_setuju },
                { label: 'Setuju', color: chartConfig.colors.setuju },
                { label: 'Netral', color: chartConfig.colors.netral },
                { label: 'Tidak Setuju', color: chartConfig.colors.tidak_setuju },
                { label: 'Sangat Tidak Setuju', color: chartConfig.colors.sangat_tidak_setuju }
            ];

            legendItems.forEach((item, i) => {
                const legendRow = legend.append('g')
                    .attr('transform', `translate(${i * 80}, 0)`)
                    .style('opacity', 0);

                legendRow.append('rect')
                    .attr('width', 12)
                    .attr('height', 12)
                    .attr('fill', item.color)
                    .attr('opacity', 0.8);

                legendRow.append('text')
                    .attr('x', 18)
                    .attr('y', 9)
                    .attr('text-anchor', 'start')
                    .attr('font-size', '10px')
                    .attr('fill', '#333')
                    .text(item.label);

                legendRow.transition()
                    .duration(500)
                    .delay(1200 + i * 100)
                    .style('opacity', 1);
            });

            legend.transition()
                .duration(500)
                .delay(1000)
                .style('opacity', 1);

            // Hide loading overlay
            d3.select(`#${containerId}-loading`).style('display', 'none');

        } catch (error) {
            console.error(`Error creating loyalitas L${questionNumber} chart:`, error);
            d3.select(`#${containerId}`)
                .html('<div class="text-center py-8 text-indigo-600"><i class="fas fa-exclamation-triangle text-2xl mb-2"></i><br>Gagal memuat grafik L' + questionNumber + '</div>');
        }
    }

    // Async rendering wrapper
    function renderChartAsync(chartFunction, ...args) {
        requestAnimationFrame(() => {
            chartFunction(...args);
        });
    }

    // Initialize charts
    const l1Distribution = @json($l1Distribution);
    const l2Distribution = @json($l2Distribution);
    const l3Distribution = @json($l3Distribution);

    // Load charts immediately for testing
    setTimeout(() => {
        console.log('Loading loyalitas charts...');
        console.log('L1:', l1Distribution);
        console.log('L2:', l2Distribution);
        console.log('L3:', l3Distribution);

        renderChartAsync(createLoyalitasChart, l1Distribution, 'loyalitas-l1-chart-container', 1);
        renderChartAsync(createLoyalitasChart, l2Distribution, 'loyalitas-l2-chart-container', 2);
        renderChartAsync(createLoyalitasChart, l3Distribution, 'loyalitas-l3-chart-container', 3);
    }, 1000);
});
</script>
