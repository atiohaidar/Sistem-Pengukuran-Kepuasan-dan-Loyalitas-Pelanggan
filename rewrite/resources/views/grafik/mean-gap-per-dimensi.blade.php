<x-app-layout>
     <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Grafik Rata-rata Gap Per Dimensi') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gradient-to-br from-blue-50 to-indigo-100 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
           

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-xl border border-gray-100">
                <div class="p-8">
                    <div class="mb-8">
                        <h2 class="text-xl font-semibold mb-4 text-center">{{ __('Dimensi Reliability') }}</h2>
                        
                        @if(empty($reliabilityData) || !is_array($reliabilityData))
                            <div class="text-center py-8">
                                <div class="inline-flex items-center justify-center w-16 h-16 bg-red-100 rounded-full mb-4">
                                    <i class="fas fa-exclamation-triangle text-red-600 text-2xl"></i>
                                </div>
                                <h3 class="text-lg font-medium text-gray-900 mb-2">{{ __('Data Tidak Tersedia') }}</h3>
                                <p class="text-gray-500">{{ __('Tidak ada data yang dapat ditampilkan untuk grafik Reliability.') }}</p>
                            </div>
                        @else
                            <div class="flex justify-center mb-6">
                                <div id="reliability-chart" class="w-full max-w-4xl h-[28rem] bg-gray-50 border rounded-lg shadow-md"></div>
                            </div>
                            
                            <!-- Legend -->
                            <div class="mt-6 flex justify-center">
                                <div class="bg-gray-50 border rounded-lg p-4 shadow-sm">
                                    <h4 class="text-sm font-semibold mb-3 text-center">{{ __('Legenda') }}</h4>
                                    <div class="flex flex-wrap justify-center gap-4">
                                        <div class="flex items-center">
                                            <div class="w-4 h-4 rounded mr-2" style="background-color: #0000FF;"></div>
                                            <span class="text-sm">{{ __('Persepsi') }}: {{ __('Rata-rata nilai persepsi responden') }}</span>
                                        </div>
                                        <div class="flex items-center">
                                            <div class="w-4 h-4 rounded mr-2" style="background-color: #D2691E;"></div>
                                            <span class="text-sm">{{ __('Harapan') }}: {{ __('Rata-rata nilai harapan responden') }}</span>
                                        </div>
                                        <div class="flex items-center">
                                            <div class="w-4 h-4 rounded mr-2" style="background-color: #2F4F4F;"></div>
                                            <span class="text-sm">{{ __('Gap') }}: {{ __('Persepsi - Harapan (positif = persepsi ≥ harapan, negatif = sebaliknya)') }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                          
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200 bg-white border border-gray-300 rounded-lg shadow-sm">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b border-gray-300"></th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b border-gray-300">R1</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b border-gray-300">R2</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b border-gray-300">R3</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b border-gray-300">R4</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b border-gray-300">R5</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b border-gray-300">R6</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b border-gray-300">R7</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 border-r border-gray-200">{{ __('Rata-rata persepsi') }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-center">{{ number_format($reliabilityData['r1_ratapersepsi_rata'] ?? 0, 2) }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-center">{{ number_format($reliabilityData['r2_ratapersepsi_rata'] ?? 0, 2) }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-center">{{ number_format($reliabilityData['r3_ratapersepsi_rata'] ?? 0, 2) }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-center">{{ number_format($reliabilityData['r4_ratapersepsi_rata'] ?? 0, 2) }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-center">{{ number_format($reliabilityData['r5_ratapersepsi_rata'] ?? 0, 2) }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-center">{{ number_format($reliabilityData['r6_ratapersepsi_rata'] ?? 0, 2) }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-center">{{ number_format($reliabilityData['r7_ratapersepsi_rata'] ?? 0, 2) }}</td>
                                        </tr>
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 border-r border-gray-200">{{ __('Rata-rata harapan') }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-center">{{ number_format($reliabilityData['r1_ratakepentingan_rata'] ?? 0, 2) }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-center">{{ number_format($reliabilityData['r2_ratakepentingan_rata'] ?? 0, 2) }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-center">{{ number_format($reliabilityData['r3_ratakepentingan_rata'] ?? 0, 2) }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-center">{{ number_format($reliabilityData['r4_ratakepentingan_rata'] ?? 0, 2) }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-center">{{ number_format($reliabilityData['r5_ratakepentingan_rata'] ?? 0, 2) }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-center">{{ number_format($reliabilityData['r6_ratakepentingan_rata'] ?? 0, 2) }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-center">{{ number_format($reliabilityData['r7_ratakepentingan_rata'] ?? 0, 2) }}</td>
                                        </tr>
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 border-r border-gray-200">{{ __('Gap') }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-center">{{ number_format(($reliabilityData['r1_ratapersepsi_rata'] ?? 0) - ($reliabilityData['r1_ratakepentingan_rata'] ?? 0), 2) }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-center">{{ number_format(($reliabilityData['r2_ratapersepsi_rata'] ?? 0) - ($reliabilityData['r2_ratakepentingan_rata'] ?? 0), 2) }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-center">{{ number_format(($reliabilityData['r3_ratapersepsi_rata'] ?? 0) - ($reliabilityData['r3_ratakepentingan_rata'] ?? 0), 2) }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-center">{{ number_format(($reliabilityData['r4_ratapersepsi_rata'] ?? 0) - ($reliabilityData['r4_ratakepentingan_rata'] ?? 0), 2) }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-center">{{ number_format(($reliabilityData['r5_ratapersepsi_rata'] ?? 0) - ($reliabilityData['r5_ratakepentingan_rata'] ?? 0), 2) }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-center">{{ number_format(($reliabilityData['r6_ratapersepsi_rata'] ?? 0) - ($reliabilityData['r6_ratakepentingan_rata'] ?? 0), 2) }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-center">{{ number_format(($reliabilityData['r7_ratapersepsi_rata'] ?? 0) - ($reliabilityData['r7_ratakepentingan_rata'] ?? 0), 2) }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
<script src="https://d3js.org/d3.v7.min.js"></script>
<style>
.tooltip {
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    box-shadow: 0 2px 8px rgba(0,0,0,0.15);
    max-width: 250px;
    word-wrap: break-word;
}
.bar:hover {
    filter: brightness(1.1);
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
    function createGroupedBarChart(data, categories, containerId, title) {
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
                '{{ __("Rata-rata nilai persepsi responden terhadap pertanyaan") }}',
                '{{ __("Rata-rata nilai harapan responden terhadap pertanyaan") }}',
                '{{ __("Gap = Persepsi - Harapan. Nilai positif = persepsi lebih tinggi dari harapan, negatif = sebaliknya") }}'
            ];

            series.forEach((seriesName, i) => {
                const data = seriesData[i];

                const bars = categoryGroups.append('rect')
                    .attr('x', x1(seriesName))
                    .attr('y', (d, j) => y(Math.max(0, data[j])))
                    .attr('width', x1.bandwidth())
                    .attr('height', (d, j) => Math.abs(y(data[j]) - y(0)))
                    .attr('fill', seriesColors[i])
                    .attr('opacity', 0.8)
                    .attr('class', 'bar')
                    .style('cursor', 'pointer');

                // Add hover effects
                bars.on('mouseover', function(event, d) {
                    // Highlight bar
                    d3.select(this)
                        .attr('opacity', 1)
                        .attr('stroke', '#000')
                        .attr('stroke-width', 2);

                    // Show tooltip
                    const categoryIndex = categories.indexOf(d);
                    const actualValue = data[categoryIndex];
                    const persepsiValue = persepsiData[categoryIndex];
                    const harapanValue = harapanData[categoryIndex];
                    const gapValue = gapData[categoryIndex];

                    let tooltipContent = `<div class="font-semibold">${d} - ${seriesName}</div>`;

                    if (seriesName === 'Gap') {
                        tooltipContent += `
                            <div>Gap Score: ${actualValue.toFixed(2)}</div>
                            <div class="text-xs mt-1">
                                Persepsi: ${persepsiValue.toFixed(2)}<br>
                                Harapan: ${harapanValue.toFixed(2)}<br>
                                ${actualValue >= 0 ? '✅ Persepsi ≥ Harapan' : '⚠️ Persepsi < Harapan'}
                            </div>
                        `;
                    } else {
                        tooltipContent += `
                            <div>Nilai: ${actualValue.toFixed(2)}</div>
                            <div class="text-xs mt-1">${seriesDescriptions[i]}</div>
                        `;
                    }

                    tooltip
                        .style('opacity', 1)
                        .html(tooltipContent)
                        .style('left', (event.pageX + 10) + 'px')
                        .style('top', (event.pageY - 10) + 'px');
                })
                .on('mousemove', function(event) {
                    tooltip
                        .style('left', (event.pageX + 10) + 'px')
                        .style('top', (event.pageY - 10) + 'px');
                })
                .on('mouseout', function() {
                    // Reset bar
                    d3.select(this)
                        .attr('opacity', 0.8)
                        .attr('stroke', 'none');

                    // Hide tooltip
                    tooltip.style('opacity', 0);
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
                .attr('transform', `translate(${(width - legendWidth) / 2}, ${height + 40})`);

            const legendItems = [
                { label: 'Persepsi', color: chartConfig.colors.persepsi },
                { label: 'Harapan', color: chartConfig.colors.harapan },
                { label: 'Gap', color: chartConfig.colors.gap }
            ];

            legendItems.forEach((item, i) => {
                const legendRow = legend.append('g')
                    .attr('transform', `translate(${i * 100}, 0)`);

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
            });

        } catch (error) {
            console.error('Error creating chart:', error);
            // Show error message in container
            d3.select(`#${containerId}`)
                .html('<div class="text-center py-8 text-red-600"><i class="fas fa-exclamation-triangle text-2xl mb-2"></i><br>Gagal memuat grafik</div>');
        }
    }

    // Initialize chart if data is available
    const chartData = @json($reliabilityData);
    if (chartData && Object.keys(chartData).length > 0) {
        const categories = ['R1', 'R2', 'R3', 'R4', 'R5', 'R6', 'R7'];
        createGroupedBarChart(chartData, categories, 'reliability-chart', '{{ __("Dimensi Reliability") }}');
    }
});
</script>
