<x-app-layout>
     <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Grafik Rata-rata Gap Per Dimensi') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gradient-to-br from-blue-50 to-indigo-100 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
           

            <div class="bg-white overflow-hidden shadow-2xl sm:rounded-2xl border-0 relative animate-fade-in">
                <!-- Gradient border effect -->
                <div class="absolute inset-0 bg-gradient-to-r from-blue-500 via-purple-500 to-pink-500 rounded-2xl opacity-10"></div>
                
                <div class="relative bg-white sm:rounded-2xl p-8">
            @php
            function renderTableRows($data, $prefix, $count) {
                $output = '';
                
                // Row Persepsi
                $output .= '<tr class="hover:bg-blue-50 hover:transform hover:translate-y-[-1px] transition-all duration-200">';
                $output .= '<td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 border-r border-gray-200">';
                $output .= '<span class="flex items-center">';
                $output .= '<div class="w-3 h-3 rounded-full bg-blue-600 mr-3"></div>';
                $output .= __('Rata-rata persepsi');
                $output .= '</span></td>';
                for($i = 1; $i <= $count; $i++) {
                    $value = $data[$prefix . $i . '_ratapersepsi_rata'] ?? 0;
                    $output .= '<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-center font-medium">' . number_format($value, 2) . '</td>';
                }
                $output .= '</tr>';
                
                // Row Harapan
                $output .= '<tr class="hover:bg-blue-50 hover:transform hover:translate-y-[-1px] transition-all duration-200">';
                $output .= '<td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 border-r border-gray-200">';
                $output .= '<span class="flex items-center">';
                $output .= '<div class="w-3 h-3 rounded-full bg-orange-500 mr-3"></div>';
                $output .= __('Rata-rata harapan');
                $output .= '</span></td>';
                for($i = 1; $i <= $count; $i++) {
                    $value = $data[$prefix . $i . '_ratakepentingan_rata'] ?? 0;
                    $output .= '<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-center font-medium">' . number_format($value, 2) . '</td>';
                }
                $output .= '</tr>';
                
                // Row Gap
                $output .= '<tr class="hover:bg-blue-50 hover:transform hover:translate-y-[-1px] transition-all duration-200">';
                $output .= '<td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 border-r border-gray-200">';
                $output .= '<span class="flex items-center">';
                $output .= '<div class="w-3 h-3 rounded-full bg-gray-600 mr-3"></div>';
                $output .= __('Gap');
                $output .= '</span></td>';
                for($i = 1; $i <= $count; $i++) {
                    $gap = ($data[$prefix . $i . '_ratapersepsi_rata'] ?? 0) - ($data[$prefix . $i . '_ratakepentingan_rata'] ?? 0);
                    $gapClass = $gap >= 0 ? 'bg-green-50 text-green-700 font-semibold rounded-md m-0.5 px-2 py-1 transition-all duration-200' : 'bg-red-50 text-red-700 font-semibold rounded-md m-0.5 px-2 py-1 transition-all duration-200';
                    $output .= '<td class="px-6 py-4 whitespace-nowrap text-sm text-center font-bold ' . $gapClass . '">';
                    $output .= number_format($gap, 2);
                    $output .= '</td>';
                }
                $output .= '</tr>';
                
                return $output;
            }
            
            function renderTableHeaders($prefix, $count) {
                $output = '<th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">';
                $output .= '<span class="flex items-center">';
                $output .= '<i class="fas fa-chart-line mr-2"></i>';
                $output .= 'Kategori';
                $output .= '</span></th>';
                for($i = 1; $i <= $count; $i++) {
                    $output .= '<th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">' . $prefix . $i . '</th>';
                }
                return $output;
            }
            
            function renderDimensionSection($data, $questions, $config) {
                $output = '';
                
                // Section container start
                $output .= '<div class="bg-white overflow-hidden shadow-2xl sm:rounded-2xl border-0 relative animate-fade-in mt-8">';
                $output .= '<div class="absolute inset-0 bg-gradient-to-r ' . $config['gradient'] . ' rounded-2xl opacity-10"></div>';
                $output .= '<div class="relative bg-white sm:rounded-2xl p-8">';
                $output .= '<div class="mb-8">';
                
                // Header
                $output .= '<div class="flex items-center justify-center mb-8 animate-fade-in">';
                $output .= '<div class="bg-gradient-to-r ' . $config['headerGradient'] . ' p-3 rounded-full mr-4 shadow-lg">';
                $output .= '<i class="fas fa-' . $config['icon'] . ' text-white text-xl"></i>';
                $output .= '</div>';
                $output .= '<div>';
                $output .= '<h2 class="text-3xl font-bold bg-gradient-to-r ' . $config['titleGradient'] . ' bg-clip-text text-transparent">';
                $output .= __('Dimensi ' . $config['name']);
                $output .= '</h2>';
                $output .= '<p class="text-gray-600 text-sm mt-1">Analisis Gap Persepsi vs Harapan Pelanggan</p>';
                $output .= '</div>';
                $output .= '</div>';
                
                // Check if data exists
                if (empty($data) || !is_array($data)) {
                    $output .= '<div class="text-center py-8">';
                    $output .= '<div class="inline-flex items-center justify-center w-16 h-16 bg-red-100 rounded-full mb-4">';
                    $output .= '<i class="fas fa-exclamation-triangle text-red-600 text-2xl"></i>';
                    $output .= '</div>';
                    $output .= '<h3 class="text-lg font-medium text-gray-900 mb-2">' . __('Data Tidak Tersedia') . '</h3>';
                    $output .= '<p class="text-gray-500">' . __('Tidak ada data yang dapat ditampilkan untuk grafik ' . $config['name'] . '.') . '</p>';
                    $output .= '</div>';
                } else {
                    // Chart container
                    $output .= '<div class="flex justify-center mb-6">';
                    $output .= '<div id="' . $config['chartId'] . '" class="w-full max-w-4xl h-[28rem] chart-container relative overflow-hidden">';
                    $output .= '<div id="' . $config['loadingId'] . '" class="absolute inset-0 bg-white bg-opacity-90 flex items-center justify-center rounded-xl z-10">';
                    $output .= '<div class="text-center">';
                    $output .= '<div class="animate-spin rounded-full h-10 w-10 border-b-2 border-blue-600 mx-auto mb-4"></div>';
                    $output .= '<p class="text-gray-600 font-medium">Memuat grafik...</p>';
                    $output .= '<p class="text-gray-400 text-sm animate-pulse">Menganalisis data ' . $config['name'] . '</p>';
                    $output .= '</div>';
                    $output .= '</div>';
                    $output .= '</div>';
                    $output .= '</div>';
                    
                    // Table
                    $output .= '<div class="overflow-x-auto animate-fade-in">';
                    $output .= '<table class="min-w-full divide-y divide-gray-200 bg-white border-0 overflow-hidden rounded-xl shadow-md">';
                    $output .= '<thead class="bg-gradient-to-r from-blue-500 to-purple-600">';
                    $output .= '<tr>';
                    $output .= renderTableHeaders($config['prefix'], $config['count']);
                    $output .= '</tr>';
                    $output .= '</thead>';
                    $output .= '<tbody class="bg-white divide-y divide-gray-200">';
                    $output .= renderTableRows($data, strtolower($config['prefix']), $config['count']);
                    $output .= '</tbody>';
                    $output .= '</table>';
                    $output .= '</div>';
                }
                
                // Section container end
                $output .= '</div>';
                $output .= '</div>';
                $output .= '</div>';
                
                return $output;
            }
            @endphp

            {!! renderDimensionSection($reliabilityData, $reliabilityQuestions, [
                'name' => 'Reliability',
                'prefix' => 'R',
                'count' => 7,
                'icon' => 'chart-bar',
                'chartId' => 'reliability-chart',
                'loadingId' => 'chart-loading',
                'gradient' => 'from-blue-500 via-purple-500 to-pink-500',
                'headerGradient' => 'from-blue-500 to-purple-600',
                'titleGradient' => 'from-blue-600 to-purple-600'
            ]) !!}

            {!! renderDimensionSection($tangibleData, $tangibleQuestions, [
                'name' => 'Tangible',
                'prefix' => 'T',
                'count' => 6,
                'icon' => 'building',
                'chartId' => 'tangible-chart',
                'loadingId' => 'tangible-chart-loading',
                'gradient' => 'from-green-500 via-teal-500 to-cyan-500',
                'headerGradient' => 'from-green-500 to-teal-600',
                'titleGradient' => 'from-green-600 to-teal-600'
            ]) !!}

            {!! renderDimensionSection($responsivenessData, $responsivenessQuestions, [
                'name' => 'Responsiveness',
                'prefix' => 'RS',
                'count' => 2,
                'icon' => 'clock',
                'chartId' => 'responsiveness-chart',
                'loadingId' => 'responsiveness-chart-loading',
                'gradient' => 'from-yellow-500 via-orange-500 to-red-500',
                'headerGradient' => 'from-yellow-500 to-orange-600',
                'titleGradient' => 'from-yellow-600 to-orange-600'
            ]) !!}

            {!! renderDimensionSection($assuranceData, $assuranceQuestions, [
                'name' => 'Assurance',
                'prefix' => 'A',
                'count' => 4,
                'icon' => 'shield-alt',
                'chartId' => 'assurance-chart',
                'loadingId' => 'assurance-chart-loading',
                'gradient' => 'from-purple-500 via-pink-500 to-rose-500',
                'headerGradient' => 'from-purple-500 to-pink-600',
                'titleGradient' => 'from-purple-600 to-pink-600'
            ]) !!}

            {!! renderDimensionSection($empathyData, $empathyQuestions, [
                'name' => 'Empathy',
                'prefix' => 'E',
                'count' => 5,
                'icon' => 'heart',
                'chartId' => 'empathy-chart',
                'loadingId' => 'empathy-chart-loading',
                'gradient' => 'from-red-500 via-pink-500 to-purple-500',
                'headerGradient' => 'from-red-500 to-pink-600',
                'titleGradient' => 'from-red-600 to-pink-600'
            ]) !!}

            {!! renderDimensionSection($applicabilityData, $applicabilityQuestions, [
                'name' => 'Applicability',
                'prefix' => 'AP',
                'count' => 2,
                'icon' => 'cogs',
                'chartId' => 'applicability-chart',
                'loadingId' => 'applicability-chart-loading',
                'gradient' => 'from-indigo-500 via-blue-500 to-cyan-500',
                'headerGradient' => 'from-indigo-500 to-blue-600',
                'titleGradient' => 'from-indigo-600 to-blue-600'
            ]) !!}
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
    #reliability-chart {
        height: 300px !important;
    }
    
    .tooltip {
        max-width: 200px;
        font-size: 11px;
    }
    
    .table-enhanced th,
    .table-enhanced td {
        padding: 8px 4px;
        font-size: 12px;
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

.animate-pulse-slow {
    animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
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
            persepsi: '#0000FF',
            harapan: '#D2691E', 
            gap: '#2F4F4F'
        }
    };

    // Reusable function to create grouped bar chart
    function createGroupedBarChart(data, categories, containerId, title, questionsData) {
        try {
            // Validate data
            if (!data || !Array.isArray(categories) || categories.length === 0) {
                console.error('Invalid data or categories provided to chart');
                return;
            }

            const margin = chartConfig.margin;
            const width = chartConfig.width - margin.left - margin.right;
            const height = chartConfig.height - margin.top - margin.bottom;

            // Clear existing chart
            const container = d3.select(`#${containerId}`);
            container.selectAll('*').remove();

            // Check if container exists
            if (container.empty()) {
                console.error(`Container #${containerId} not found`);
                return;
            }

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

            // Extract data arrays
            const persepsiData = categories.map(cat => data[`${cat.toLowerCase()}_ratapersepsi_rata`] || 0);
            const harapanData = categories.map(cat => data[`${cat.toLowerCase()}_ratakepentingan_rata`] || 0);
            const gapData = persepsiData.map((p, i) => p - harapanData[i]);

            // Scales
            const x0 = d3.scaleBand()
                .domain(categories)
                .range([0, width])
                .padding(0.1);

            const x1 = d3.scaleBand()
                .domain(['Persepsi', 'Harapan', 'Gap'])
                .range([0, x0.bandwidth()])
                .padding(0.05);

            const allValues = [...persepsiData, ...harapanData, ...gapData, 0];
            const y = d3.scaleLinear()
                .domain([d3.min(allValues), d3.max(allValues)])
                .nice()
                .range([height, 0]);

            // Create groups for each category
            const categoryGroups = svg.selectAll('.category')
                .data(categories)
                .enter().append('g')
                .attr('class', 'category')
                .attr('transform', d => `translate(${x0(d)},0)`);

            // Add bars for each series
            const series = ['Persepsi', 'Harapan', 'Gap'];
            const seriesData = [persepsiData, harapanData, gapData];
            const seriesColors = [chartConfig.colors.persepsi, chartConfig.colors.harapan, chartConfig.colors.gap];
            const seriesDescriptions = [
                'Rata-rata nilai persepsi responden',
                'Rata-rata nilai harapan responden',
                'Gap = Persepsi - Harapan. Nilai positif = persepsi lebih tinggi dari harapan, negatif = sebaliknya'
            ];

            series.forEach((seriesName, i) => {
                const data = seriesData[i];

                const bars = categoryGroups.append('rect')
                    .attr('x', x1(seriesName))
                    .attr('y', (d, j) => y(0)) // Start from baseline
                    .attr('width', x1.bandwidth())
                    .attr('height', 0) // Start with height 0
                    .attr('fill', seriesColors[i])
                    .attr('opacity', 0.8)
                    .attr('class', 'bar')
                    .style('cursor', 'pointer');

                // Animate bars
                bars.transition()
                    .duration(800)
                    .attr('y', (d, j) => y(Math.max(0, data[j])))
                    .attr('height', (d, j) => Math.abs(y(data[j]) - y(0)))
                    .delay((d, j) => j * 100 + i * 50) // Stagger animation
                    .ease(d3.easeBounce);

                // Add hover effects
                bars.on('click', function(event, d) {
                    // Get the bar position for tooltip placement above the bar
                    const barX = parseFloat(d3.select(this).attr('x')) + x1.bandwidth() / 2;
                    const barY = parseFloat(d3.select(this).attr('y'));
                    const categoryIndex = categories.indexOf(d);
                    const actualValue = data[categoryIndex];
                    const persepsiValue = persepsiData[categoryIndex];
                    const harapanValue = harapanData[categoryIndex];
                    const gapValue = gapData[categoryIndex];

                    let tooltipContent = `<div class="font-semibold">${d} - ${seriesName}</div>`;

                    // Get the question for this category
                    const categoryKey = d.toLowerCase();
                    const question = questionsData ? questionsData[categoryKey] : null;

                    if (seriesName === 'Gap') {
                        tooltipContent += `
                            <div>Gap Score: ${actualValue.toFixed(2)}</div>
                            <div class="text-xs mt-1">
                                Persepsi: ${persepsiValue.toFixed(2)}<br>
                                Harapan: ${harapanValue.toFixed(2)}<br>
                                ${actualValue >= 0 ? '✅ Persepsi ≥ Harapan' : '⚠️ Persepsi < Harapan'}
                            </div>
                        `;
                        if (question) {
                            tooltipContent += `<div class="text-xs mt-2 italic">"${question}"</div>`;
                        }
                    } else {
                        tooltipContent += `
                            <div>Nilai: ${actualValue.toFixed(2)}</div>
                            <div class="text-xs mt-1">${seriesDescriptions[i]}</div>
                        `;
                        if (question) {
                            tooltipContent += `<div class="text-xs mt-2 italic">"${question}"</div>`;
                        }
                    }

                    // Position tooltip above the bar
                    const containerRect = container.node().getBoundingClientRect();
                    const svgRect = svg.node().getBoundingClientRect();
                    const tooltipX = svgRect.left - containerRect.left + margin.left + barX;
                    const tooltipY = svgRect.top - containerRect.top + margin.top + barY - 8; // Position so arrow points to bar

                    tooltip
                        .style('opacity', 1)
                        .html(tooltipContent)
                        .style('left', tooltipX + 'px')
                        .style('top', tooltipY + 'px');
                });

                // Add data labels
                categoryGroups.append('text')
                    .attr('x', x1(seriesName) + x1.bandwidth() / 2)
                    .attr('y', (d, j) => y(data[j]) - 5)
                    .attr('text-anchor', 'middle')
                    .attr('font-size', '10px')
                    .attr('fill', '#000')
                    .text((d, j) => data[j].toFixed(2));
            });

            // Add axes
            svg.append('g')
                .attr('transform', `translate(0,${height})`)
                .call(d3.axisBottom(x0))
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
                .text(title);

            // Add legend inside the chart (centered below the graph)
            const legendWidth = 300; // Approximate width of legend
            const legend = svg.append('g')
                .attr('class', 'legend')
                .attr('transform', `translate(${(width - legendWidth) / 2}, ${height + 40})`)
                .style('opacity', 0); // Start invisible

            const legendItems = [
                { label: 'Persepsi', color: chartConfig.colors.persepsi },
                { label: 'Harapan', color: chartConfig.colors.harapan },
                { label: 'Gap', color: chartConfig.colors.gap }
            ];

            legendItems.forEach((item, i) => {
                const legendRow = legend.append('g')
                    .attr('transform', `translate(${i * 100}, 0)`)
                    .style('opacity', 0); // Start invisible

                legendRow.append('rect')
                    .attr('width', 12)
                    .attr('height', 12)
                    .attr('fill', item.color)
                    .attr('opacity', 0.8);

                legendRow.append('text')
                    .attr('x', 18)
                    .attr('y', 9)
                    .attr('text-anchor', 'start')
                    .attr('font-size', '12px')
                    .attr('fill', '#333')
                    .text(item.label);

                // Animate legend items
                legendRow.transition()
                    .duration(500)
                    .delay(1000 + i * 200) // Start after bars animation
                    .style('opacity', 1);
            });

            // Animate legend container
            legend.transition()
                .duration(500)
                .delay(800)
                .style('opacity', 1);

            // Hide loading overlay after animation completes
            setTimeout(() => {
                d3.select(`#${containerId}-loading`).style('display', 'none');
            }, 2000); // Wait for all animations to complete

        } catch (error) {
            console.error('Error creating chart:', error);
            // Show error message in container
            d3.select(`#${containerId}`)
                .html('<div class="text-center py-8 text-red-600"><i class="fas fa-exclamation-triangle text-2xl mb-2"></i><br>Gagal memuat grafik</div>');
        }
    }

    // Initialize chart if data is available
    const chartData = @json($reliabilityData);
    const questionsData = @json($reliabilityQuestions);
    const tangibleChartData = @json($tangibleData);
    const tangibleQuestionsData = @json($tangibleQuestions);
    const responsivenessChartData = @json($responsivenessData);
    const responsivenessQuestionsData = @json($responsivenessQuestions);
    const assuranceChartData = @json($assuranceData);
    const assuranceQuestionsData = @json($assuranceQuestions);
    const empathyChartData = @json($empathyData);
    const empathyQuestionsData = @json($empathyQuestions);
    const applicabilityChartData = @json($applicabilityData);
    const applicabilityQuestionsData = @json($applicabilityQuestions);
    
    // Configuration for all dimensions
    const dimensions = [
        {
            data: chartData,
            questions: questionsData,
            categories: ['R1', 'R2', 'R3', 'R4', 'R5', 'R6', 'R7'],
            chartId: 'reliability-chart',
            title: '{{ __("Dimensi Reliability") }}'
        },
        {
            data: tangibleChartData,
            questions: tangibleQuestionsData,
            categories: ['T1', 'T2', 'T3', 'T4', 'T5', 'T6'],
            chartId: 'tangible-chart',
            title: '{{ __("Dimensi Tangible") }}'
        },
        {
            data: responsivenessChartData,
            questions: responsivenessQuestionsData,
            categories: ['RS1', 'RS2'],
            chartId: 'responsiveness-chart',
            title: '{{ __("Dimensi Responsiveness") }}'
        },
        {
            data: assuranceChartData,
            questions: assuranceQuestionsData,
            categories: ['A1', 'A2', 'A3', 'A4'],
            chartId: 'assurance-chart',
            title: '{{ __("Dimensi Assurance") }}'
        },
        {
            data: empathyChartData,
            questions: empathyQuestionsData,
            categories: ['E1', 'E2', 'E3', 'E4', 'E5'],
            chartId: 'empathy-chart',
            title: '{{ __("Dimensi Empathy") }}'
        },
        {
            data: applicabilityChartData,
            questions: applicabilityQuestionsData,
            categories: ['AP1', 'AP2'],
            chartId: 'applicability-chart',
            title: '{{ __("Dimensi Applicability") }}'
        }
    ];
    
    // Initialize all charts
    dimensions.forEach(dim => {
        if (dim.data && Object.keys(dim.data).length > 0) {
            createGroupedBarChart(dim.data, dim.categories, dim.chartId, dim.title, dim.questions);
        }
    });
});
</script>
