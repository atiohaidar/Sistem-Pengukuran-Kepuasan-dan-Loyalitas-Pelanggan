<x-app-layout>
     <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Analisis Kepuasan dan Potensi Loyalitas') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gradient-to-br from-blue-50 to-indigo-100 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">


            <div class="bg-white overflow-hidden shadow-2xl sm:rounded-2xl border-0 relative animate-fade-in">
                <!-- Gradient border effect -->
                <div class="absolute inset-0 bg-gradient-to-r from-blue-500 via-purple-500 to-pink-500 rounded-2xl opacity-10"></div>

                <div class="relative bg-white sm:rounded-2xl p-8">
            @php
            function renderGapIdealDiharapkanChart($dimensionGaps, $avgK1, $avgK2) {
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
                $output .= __('Gap Ideal vs Diharapkan');
                $output .= '</h2>';
                $output .= '<p class="text-gray-600 text-sm mt-1">Analisis gap per dimensi dan rata-rata kepuasan</p>';
                $output .= '</div>';
                $output .= '</div>';

                // Chart container
                $output .= '<div class="flex justify-center mb-6">';
                $output .= '<div id="gap-ideal-chart-container" class="w-full max-w-4xl h-[28rem] chart-container relative overflow-hidden">';
                $output .= '<div id="gap-ideal-chart-loading" class="absolute inset-0 bg-white bg-opacity-90 flex items-center justify-center rounded-xl z-10">';
                $output .= '<div class="text-center">';
                $output .= '<div class="animate-spin rounded-full h-10 w-10 border-b-2 border-red-600 mx-auto mb-4"></div>';
                $output .= '<p class="text-gray-600 font-medium">Memuat grafik gap...</p>';
                $output .= '<p class="text-gray-400 text-sm animate-pulse">Menganalisis data gap</p>';
                $output .= '</div>';
                $output .= '</div>';
                $output .= '</div>';
                $output .= '</div>';

                // Summary cards for K1 and K2 averages
                $output .= '<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">';
                $output .= '<div class="bg-gradient-to-r from-blue-50 to-blue-100 rounded-xl p-6 border border-blue-200">';
                $output .= '<div class="text-center">';
                $output .= '<div class="text-3xl font-bold text-blue-600 mb-2">' . number_format($avgK1, 2) . '</div>';
                $output .= '<div class="text-lg font-semibold text-gray-800 mb-1">Rata-rata K1</div>';
                $output .= '<div class="text-sm text-gray-600">Pertanyaan Kepuasan 1</div>';
                $output .= '</div>';
                $output .= '</div>';

                $output .= '<div class="bg-gradient-to-r from-green-50 to-green-100 rounded-xl p-6 border border-green-200">';
                $output .= '<div class="text-center">';
                $output .= '<div class="text-3xl font-bold text-green-600 mb-2">' . number_format($avgK2, 2) . '</div>';
                $output .= '<div class="text-lg font-semibold text-gray-800 mb-1">Rata-rata K2</div>';
                $output .= '<div class="text-sm text-gray-600">Pertanyaan Kepuasan 2</div>';
                $output .= '</div>';
                $output .= '</div>';
                $output .= '</div>';

                // Section container end
                $output .= '</div>';
                $output .= '</div>';
                $output .= '</div>';

                return $output;
            }

            function renderKepuasanChart($kepuasanDistribution) {
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

            {!! renderGapIdealDiharapkanChart($dimensionGaps, $avgK1, $avgK2) !!}
            {!! renderKepuasanChart($kepuasanDistribution) !!}
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

    // Function to create gap ideal vs diharapkan chart
    function createGapIdealChart(data, containerId, avgK1, avgK2) {
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

            // Prepare data - combine dimensions and K1/K2 averages
            const dimensions = Object.keys(data);
            const gapValues = dimensions.map(dim => data[dim]);

            // Add K1 and K2 as special categories
            const allCategories = [...dimensions, 'K1_Avg', 'K2_Avg'];
            const allValues = [...gapValues, avgK1, avgK2];

            // Scales
            const x = d3.scaleBand()
                .domain(allCategories)
                .range([0, width])
                .padding(0.1);

            const y = d3.scaleLinear()
                .domain([d3.min(allValues) - 0.5, d3.max(allValues) + 0.5])
                .nice()
                .range([height, 0]);

            // Create bars
            svg.selectAll('.bar')
                .data(allCategories)
                .enter().append('rect')
                .attr('class', 'bar')
                .attr('x', d => x(d))
                .attr('y', d => {
                    if (d === 'K1_Avg') return y(Math.max(0, avgK1));
                    if (d === 'K2_Avg') return y(Math.max(0, avgK2));
                    return y(Math.max(0, data[d]));
                })
                .attr('width', x.bandwidth())
                .attr('height', d => {
                    if (d === 'K1_Avg') return Math.abs(y(avgK1) - y(0));
                    if (d === 'K2_Avg') return Math.abs(y(avgK2) - y(0));
                    return Math.abs(y(data[d]) - y(0));
                })
                .attr('fill', d => {
                    if (d === 'K1_Avg' || d === 'K2_Avg') return chartConfig.colors.kepuasan;
                    return data[d] >= 0 ? chartConfig.colors.positive : chartConfig.colors.negative;
                })
                .attr('opacity', 0.8)
                .style('cursor', 'pointer')
                .on('mouseover', function(event, d) {
                    let value, label, desc;
                    if (d === 'K1_Avg') {
                        value = avgK1;
                        label = 'Rata-rata K1';
                        desc = 'Rata-rata pertanyaan kepuasan pertama';
                    } else if (d === 'K2_Avg') {
                        value = avgK2;
                        label = 'Rata-rata K2';
                        desc = 'Rata-rata pertanyaan kepuasan kedua';
                    } else {
                        value = data[d];
                        label = d.charAt(0).toUpperCase() + d.slice(1);
                        desc = value >= 0 ? 'Gap positif - performa baik' : 'Gap negatif - perlu perbaikan';
                    }

                    tooltip
                        .style('opacity', 1)
                        .html(`<div class="font-semibold">${label}</div>
                               <div>Nilai: ${value.toFixed(2)}</div>
                               <div class="text-xs mt-1">${desc}</div>`);

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
                .text('Gap Ideal vs Diharapkan & Rata-rata Kepuasan');

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

            // Prepare data
            const categories = Object.keys(data);
            const values = categories.map(cat => data[cat]);
            const colors = ['#EF4444', '#F97316', '#EAB308', '#22C55E', '#10B981']; // Red to Green

            // Scales
            const x = d3.scaleBand()
                .domain(categories)
                .range([0, width])
                .padding(0.1);

            const y = d3.scaleLinear()
                .domain([0, d3.max(values) + 5])
                .nice()
                .range([height, 0]);

            // Create bars
            svg.selectAll('.bar')
                .data(categories)
                .enter().append('rect')
                .attr('class', 'bar')
                .attr('x', d => x(d))
                .attr('y', d => y(data[d]))
                .attr('width', x.bandwidth())
                .attr('height', d => height - y(data[d]))
                .attr('fill', (d, i) => colors[i])
                .attr('opacity', 0.8)
                .style('cursor', 'pointer')
                .on('mouseover', function(event, d) {
                    const value = data[d];
                    const labels = {
                        'sangat_puas': 'Sangat Puas',
                        'puas': 'Puas',
                        'cukup_puas': 'Cukup Puas',
                        'kurang_puas': 'Kurang Puas',
                        'tidak_puas': 'Tidak Puas'
                    };

                    tooltip
                        .style('opacity', 1)
                        .html(`<div class="font-semibold">${labels[d] || d}</div>
                               <div>Jumlah: ${value} responden</div>`);

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
                .data(categories)
                .enter().append('text')
                .attr('class', 'label')
                .attr('x', d => x(d) + x.bandwidth() / 2)
                .attr('y', d => y(data[d]) - 5)
                .attr('text-anchor', 'middle')
                .attr('font-size', '12px')
                .attr('fill', '#333')
                .text(d => data[d]);

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
                .html('<div class="text-center py-8 text-green-600"><i class="fas fa-exclamation-triangle text-2xl mb-2"></i><br>Gagal memuat grafik kepuasan</div>');
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
    const dimensionGaps = @json($dimensionGaps);
    const avgK1 = @json($avgK1);
    const avgK2 = @json($avgK2);
    const kepuasanDistribution = @json($kepuasanDistribution);

    // Load charts immediately for testing
    setTimeout(() => {
        console.log('Loading gap ideal chart...');
        renderChartAsync(createGapIdealChart, dimensionGaps, 'gap-ideal-chart-container', avgK1, avgK2);

        console.log('Loading kepuasan chart...');
        renderChartAsync(createKepuasanChart, kepuasanDistribution, 'kepuasan-chart-container');
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
