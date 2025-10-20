<x-app-layout>
     <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Rekomendasi Berdasarkan Analisis Gap dan Standar Deviasi') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gradient-to-br from-blue-50 to-indigo-100 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Back Button -->
            <div class="mb-6">
                <a href="{{ route('dashboard.pelatihan') }}" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-red-500 to-red-600 border border-red-500 rounded-lg shadow-sm text-sm font-medium text-white hover:from-red-600 hover:to-red-700 hover:border-red-600 transition-all duration-200 transform hover:scale-105">
                    <i class="fas fa-arrow-left mr-2 text-lg"></i>
                    <span class="font-semibold">Kembali ke Dashboard</span>
                </a>
            </div>


            <div class="bg-white overflow-hidden shadow-2xl sm:rounded-2xl border-0 relative animate-fade-in">
                <!-- Gradient border effect -->
                <div class="absolute inset-0 bg-gradient-to-r from-blue-500 via-purple-500 to-pink-500 rounded-2xl opacity-10"></div>

                <div class="relative bg-white sm:rounded-2xl p-8">
            @php
            function renderGapChartSection($gapData, $dimensionsConfig) {
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
                $output .= __('Analisis Gap Per Dimensi');
                $output .= '</h2>';
                $output .= '<p class="text-gray-600 text-sm mt-1">Gap = Persepsi - Harapan. Nilai negatif menunjukkan area yang perlu diperbaiki</p>';
                $output .= '</div>';
                $output .= '</div>';

                // Chart container
                $output .= '<div class="flex justify-center mb-6">';
                $output .= '<div id="gap-chart-container" class="w-full max-w-4xl h-[28rem] chart-container relative overflow-hidden">';
                $output .= '<div id="gap-chart-loading" class="absolute inset-0 bg-white bg-opacity-90 flex items-center justify-center rounded-xl z-10">';
                $output .= '<div class="text-center">';
                $output .= '<div class="animate-spin rounded-full h-10 w-10 border-b-2 border-red-600 mx-auto mb-4"></div>';
                $output .= '<p class="text-gray-600 font-medium">Memuat grafik gap...</p>';
                $output .= '<p class="text-gray-400 text-sm animate-pulse">Menganalisis data gap per dimensi</p>';
                $output .= '</div>';
                $output .= '</div>';
                $output .= '</div>';
                $output .= '</div>';

                // Section container end
                $output .= '</div>';
                $output .= '</div>';
                $output .= '</div>';

                return $output;
            }

            function renderStdDevChartSection($stdDevData, $dimensionsConfig) {
                $output = '';

                // Section container start
                $output .= '<div class="bg-white overflow-hidden shadow-2xl sm:rounded-2xl border-0 relative animate-fade-in mt-8">';
                $output .= '<div class="absolute inset-0 bg-gradient-to-r from-purple-500 via-blue-500 to-cyan-500 rounded-2xl opacity-10"></div>';
                $output .= '<div class="relative bg-white sm:rounded-2xl p-8">';
                $output .= '<div class="mb-8">';

                // Header
                $output .= '<div class="flex items-center justify-center mb-8 animate-fade-in">';
                $output .= '<div class="bg-gradient-to-r from-purple-500 to-blue-600 p-3 rounded-full mr-4 shadow-lg">';
                $output .= '<i class="fas fa-chart-bar text-white text-xl"></i>';
                $output .= '</div>';
                $output .= '<div>';
                $output .= '<h2 class="text-3xl font-bold bg-gradient-to-r from-purple-600 to-blue-600 bg-clip-text text-transparent">';
                $output .= __('Standar Deviasi Gap Per Dimensi');
                $output .= '</h2>';
                $output .= '<p class="text-gray-600 text-sm mt-1">Variabilitas gap menunjukkan konsistensi performa</p>';
                $output .= '</div>';
                $output .= '</div>';

                // Chart container
                $output .= '<div class="flex justify-center mb-6">';
                $output .= '<div id="stddev-chart-container" class="w-full max-w-4xl h-[28rem] chart-container relative overflow-hidden">';
                $output .= '<div id="stddev-chart-loading" class="absolute inset-0 bg-white bg-opacity-90 flex items-center justify-center rounded-xl z-10">';
                $output .= '<div class="text-center">';
                $output .= '<div class="animate-spin rounded-full h-10 w-10 border-b-2 border-purple-600 mx-auto mb-4"></div>';
                $output .= '<p class="text-gray-600 font-medium">Memuat grafik standar deviasi...</p>';
                $output .= '<p class="text-gray-400 text-sm animate-pulse">Menganalisis variabilitas data</p>';
                $output .= '</div>';
                $output .= '</div>';
                $output .= '</div>';
                $output .= '</div>';

                // Section container end
                $output .= '</div>';
                $output .= '</div>';
                $output .= '</div>';

                return $output;
            }

            function renderIKPTable($ikpPercentage, $ikpInterpretation) {
                $output = '';

                // Section container start
                $output .= '<div class="bg-white overflow-hidden shadow-2xl sm:rounded-2xl border-0 relative animate-fade-in mt-8">';
                $output .= '<div class="absolute inset-0 bg-gradient-to-r from-green-500 via-teal-500 to-cyan-500 rounded-2xl opacity-10"></div>';
                $output .= '<div class="relative bg-white sm:rounded-2xl p-8">';
                $output .= '<div class="mb-8">';

                // Header
                $output .= '<div class="flex items-center justify-center mb-8 animate-fade-in">';
                $output .= '<div class="bg-gradient-to-r from-green-500 to-teal-600 p-3 rounded-full mr-4 shadow-lg">';
                $output .= '<i class="fas fa-trophy text-white text-xl"></i>';
                $output .= '</div>';
                $output .= '<div>';
                $output .= '<h2 class="text-3xl font-bold bg-gradient-to-r from-green-600 to-teal-600 bg-clip-text text-transparent">';
                $output .= __('Indeks Kepuasan Pelanggan (IKP)');
                $output .= '</h2>';
                $output .= '<p class="text-gray-600 text-sm mt-1">Ringkasan tingkat kepuasan pelanggan secara keseluruhan</p>';
                $output .= '</div>';
                $output .= '</div>';

                // IKP Summary Card
                $output .= '<div class="bg-gradient-to-r from-green-50 to-teal-50 rounded-xl p-6 mb-6 border border-green-200">';
                $output .= '<div class="text-center">';
                $output .= '<div class="text-6xl font-bold text-green-600 mb-2">' . number_format($ikpPercentage, 1) . '%</div>';
                $output .= '<div class="text-xl font-semibold text-gray-800 mb-1">' . $ikpInterpretation . '</div>';
                $output .= '<div class="text-sm text-gray-600">Indeks Kepuasan Pelanggan</div>';
                $output .= '</div>';
                $output .= '</div>';

                // IKP Scale Table
                $output .= '<div class="overflow-x-auto animate-fade-in">';
                $output .= '<table class="min-w-full divide-y divide-gray-200 bg-white border-0 overflow-hidden rounded-xl shadow-md">';
                $output .= '<thead class="bg-gradient-to-r from-green-500 to-teal-600">';
                $output .= '<tr>';
                $output .= '<th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">Rentang Skor</th>';
                $output .= '<th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">Kategori</th>';
                $output .= '<th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">Interpretasi</th>';
                $output .= '<th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">Status</th>';
                $output .= '</tr>';
                $output .= '</thead>';
                $output .= '<tbody class="bg-white divide-y divide-gray-200">';

                $scales = [
                    ['range' => '81-100', 'category' => 'Sangat Puas', 'interpretation' => 'Kinerja sangat baik, melebihi ekspektasi', 'color' => 'green'],
                    ['range' => '66-80', 'category' => 'Puas', 'interpretation' => 'Kinerja baik, memenuhi ekspektasi', 'color' => 'blue'],
                    ['range' => '51-65', 'category' => 'Cukup Puas', 'interpretation' => 'Kinerja cukup, perlu sedikit perbaikan', 'color' => 'yellow'],
                    ['range' => '35-50', 'category' => 'Kurang Puas', 'interpretation' => 'Kinerja kurang, perlu perbaikan signifikan', 'color' => 'orange'],
                    ['range' => '0-34', 'category' => 'Tidak Puas', 'interpretation' => 'Kinerja buruk, perlu perbaikan total', 'color' => 'red']
                ];

                foreach ($scales as $scale) {
                    $isCurrent = false;
                    if (($ikpPercentage >= 81 && $scale['range'] === '81-100') ||
                        ($ikpPercentage >= 66 && $ikpPercentage <= 80 && $scale['range'] === '66-80') ||
                        ($ikpPercentage >= 51 && $ikpPercentage <= 65 && $scale['range'] === '51-65') ||
                        ($ikpPercentage >= 35 && $ikpPercentage <= 50 && $scale['range'] === '35-50') ||
                        ($ikpPercentage >= 0 && $ikpPercentage <= 34 && $scale['range'] === '0-34')) {
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

            {!! renderGapChartSection($gapData, $dimensionsConfig) !!}
            {!! renderStdDevChartSection($stdDevData, $dimensionsConfig) !!}
            {!! renderIKPTable($ikpPercentage, $ikpInterpretation) !!}
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
            stddev: '#7C3AED',
            positive: '#10B981',
            negative: '#EF4444'
        }
    };

    // Function to create gap chart
    function createGapChart(data, containerId) {
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

            // Prepare data
            const dimensions = Object.keys(data);
            const gapValues = dimensions.map(dim => data[dim]);

            // Scales
            const x = d3.scaleBand()
                .domain(dimensions)
                .range([0, width])
                .padding(0.1);

            const y = d3.scaleLinear()
                .domain([d3.min(gapValues) - 0.5, d3.max(gapValues) + 0.5])
                .nice()
                .range([height, 0]);

            // Create bars
            svg.selectAll('.bar')
                .data(dimensions)
                .enter().append('rect')
                .attr('class', 'bar')
                .attr('x', d => x(d))
                .attr('y', d => y(Math.max(0, data[d])))
                .attr('width', x.bandwidth())
                .attr('height', d => Math.abs(y(data[d]) - y(0)))
                .attr('fill', d => data[d] >= 0 ? chartConfig.colors.positive : chartConfig.colors.negative)
                .attr('opacity', 0.8)
                .style('cursor', 'pointer')
                .on('mouseover', function(event, d) {
                    const value = data[d];
                    const recommendation = value < -1 ? 'Perlu perbaikan prioritas tinggi' :
                                         value < 0 ? 'Perlu perbaikan' :
                                         'Kinerja baik';

                    tooltip
                        .style('opacity', 1)
                        .html(`<div class="font-semibold">${d.charAt(0).toUpperCase() + d.slice(1)}</div>
                               <div>Gap Score: ${value.toFixed(2)}</div>
                               <div class="text-xs mt-1">${recommendation}</div>`);

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
                .text('Gap Analysis Per Dimensi');

            // Add zero line
            svg.append('line')
                .attr('x1', 0)
                .attr('x2', width)
                .attr('y1', y(0))
                .attr('y2', y(0))
                .attr('stroke', '#666')
                .attr('stroke-width', 1)
                .attr('stroke-dasharray', '5,5');

            // Hide loading overlay
            d3.select(`#${containerId}-loading`).style('display', 'none');

        } catch (error) {
            console.error('Error creating gap chart:', error);
            d3.select(`#${containerId}`)
                .html('<div class="text-center py-8 text-red-600"><i class="fas fa-exclamation-triangle text-2xl mb-2"></i><br>Gagal memuat grafik gap</div>');
        }
    }

    // Function to create standard deviation chart
    function createStdDevChart(data, containerId) {
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

            // Prepare data
            const dimensions = Object.keys(data);
            const stdDevValues = dimensions.map(dim => data[dim]);

            // Scales
            const x = d3.scaleBand()
                .domain(dimensions)
                .range([0, width])
                .padding(0.1);

            const y = d3.scaleLinear()
                .domain([0, d3.max(stdDevValues) + 0.2])
                .nice()
                .range([height, 0]);

            // Create bars
            svg.selectAll('.bar')
                .data(dimensions)
                .enter().append('rect')
                .attr('class', 'bar')
                .attr('x', d => x(d))
                .attr('y', d => y(data[d]))
                .attr('width', x.bandwidth())
                .attr('height', d => height - y(data[d]))
                .attr('fill', chartConfig.colors.stddev)
                .attr('opacity', 0.8)
                .style('cursor', 'pointer')
                .on('mouseover', function(event, d) {
                    const value = data[d];
                    const variability = value > 1 ? 'Variabilitas tinggi' :
                                      value > 0.5 ? 'Variabilitas sedang' :
                                      'Variabilitas rendah';

                    tooltip
                        .style('opacity', 1)
                        .html(`<div class="font-semibold">${d.charAt(0).toUpperCase() + d.slice(1)}</div>
                               <div>Std Dev: ${value.toFixed(2)}</div>
                               <div class="text-xs mt-1">${variability}</div>`);

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
                .text('Standar Deviasi Gap Per Dimensi');

            // Hide loading overlay
            d3.select(`#${containerId}-loading`).style('display', 'none');

        } catch (error) {
            console.error('Error creating std dev chart:', error);
            d3.select(`#${containerId}`)
                .html('<div class="text-center py-8 text-purple-600"><i class="fas fa-exclamation-triangle text-2xl mb-2"></i><br>Gagal memuat grafik standar deviasi</div>');
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
    function renderChartAsync(chartFunction, data, containerId) {
        requestAnimationFrame(() => {
            chartFunction(data, containerId);
        });
    }

    // Initialize charts
    const gapData = @json($gapData);
    const stdDevData = @json($stdDevData);

    // For debugging - load charts immediately instead of lazy loading
    console.log('Loading charts immediately for debugging...');
    console.log('Gap data:', gapData);
    console.log('StdDev data:', stdDevData);

    // Load charts immediately for testing
    setTimeout(() => {
        console.log('Loading gap chart...');
        renderChartAsync(createGapChart, gapData, 'gap-chart-container');
        
        console.log('Loading std dev chart...');
        renderChartAsync(createStdDevChart, stdDevData, 'stddev-chart-container');
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
