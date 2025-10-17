<x-app-layout>
     <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Grafik Rata-rata Gap Per Dimensi') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gradient-to-br from-blue-50 to-indigo-100 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
           

            <div class="bg-white overflow-hidden shadow-2xl sm:rounded-2xl border-0 relative animate-fade-in-up">
                <!-- Gradient border effect -->
                <div class="absolute inset-0 bg-gradient-to-r from-blue-500 via-purple-500 to-pink-500 rounded-2xl opacity-10"></div>
                
                <div class="relative bg-white sm:rounded-2xl p-8">
                    <div class="mb-8">
                        <div class="flex items-center justify-center mb-8 animate-fade-in-up">
                            <div class="bg-gradient-to-r from-blue-500 to-purple-600 p-3 rounded-full mr-4 shadow-lg">
                                <i class="fas fa-chart-bar text-white text-xl"></i>
                            </div>
                            <div>
                                <h2 class="text-3xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">
                                    {{ __('Dimensi Reliability') }}
                                </h2>
                                <p class="text-gray-600 text-sm mt-1">Analisis Gap Persepsi vs Harapan Pelanggan</p>
                            </div>
                        </div>
                        
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
                                <div id="reliability-chart" class="w-full max-w-4xl h-[28rem] chart-container relative overflow-hidden">
                                    <!-- Loading overlay -->
                                    <div id="chart-loading" class="absolute inset-0 bg-white bg-opacity-90 flex items-center justify-center rounded-xl z-10">
                                        <div class="text-center">
                                            <div class="loading-spinner"></div>
                                            <p class="text-gray-600 font-medium">Memuat grafik...</p>
                                            <p class="text-gray-400 text-sm animate-pulse-slow">Menganalisis data Reliability</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                          
                          
                            <div class="overflow-x-auto animate-fade-in-up">
                                <table class="min-w-full divide-y divide-gray-200 bg-white border-0 table-enhanced">
                                    <thead class="table-header-gradient">
                                        <tr>
                                            <th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">
                                                <span class="flex items-center">
                                                    <i class="fas fa-chart-line mr-2"></i>
                                                    Kategori
                                                </span>
                                            </th>
                                            <th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">R1</th>
                                            <th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">R2</th>
                                            <th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">R3</th>
                                            <th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">R4</th>
                                            <th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">R5</th>
                                            <th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">R6</th>
                                            <th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">R7</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        <tr class="table-row-hover">
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 border-r border-gray-200">
                                                <span class="flex items-center">
                                                    <div class="w-3 h-3 rounded-full bg-blue-600 mr-3"></div>
                                                    {{ __('Rata-rata persepsi') }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-center font-medium">{{ number_format($reliabilityData['r1_ratapersepsi_rata'] ?? 0, 2) }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-center font-medium">{{ number_format($reliabilityData['r2_ratapersepsi_rata'] ?? 0, 2) }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-center font-medium">{{ number_format($reliabilityData['r3_ratapersepsi_rata'] ?? 0, 2) }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-center font-medium">{{ number_format($reliabilityData['r4_ratapersepsi_rata'] ?? 0, 2) }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-center font-medium">{{ number_format($reliabilityData['r5_ratapersepsi_rata'] ?? 0, 2) }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-center font-medium">{{ number_format($reliabilityData['r6_ratapersepsi_rata'] ?? 0, 2) }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-center font-medium">{{ number_format($reliabilityData['r7_ratapersepsi_rata'] ?? 0, 2) }}</td>
                                        </tr>
                                        <tr class="table-row-hover">
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 border-r border-gray-200">
                                                <span class="flex items-center">
                                                    <div class="w-3 h-3 rounded-full bg-orange-500 mr-3"></div>
                                                    {{ __('Rata-rata harapan') }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-center font-medium">{{ number_format($reliabilityData['r1_ratakepentingan_rata'] ?? 0, 2) }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-center font-medium">{{ number_format($reliabilityData['r2_ratakepentingan_rata'] ?? 0, 2) }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-center font-medium">{{ number_format($reliabilityData['r3_ratakepentingan_rata'] ?? 0, 2) }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-center font-medium">{{ number_format($reliabilityData['r4_ratakepentingan_rata'] ?? 0, 2) }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-center font-medium">{{ number_format($reliabilityData['r5_ratakepentingan_rata'] ?? 0, 2) }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-center font-medium">{{ number_format($reliabilityData['r6_ratakepentingan_rata'] ?? 0, 2) }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-center font-medium">{{ number_format($reliabilityData['r7_ratakepentingan_rata'] ?? 0, 2) }}</td>
                                        </tr>
                                        <tr class="table-row-hover">
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 border-r border-gray-200">
                                                <span class="flex items-center">
                                                    <div class="w-3 h-3 rounded-full bg-gray-600 mr-3"></div>
                                                    {{ __('Gap') }}
                                                </span>
                                            </td>
                                            @for($i = 1; $i <= 7; $i++)
                                                @php
                                                    $gap = ($reliabilityData["r{$i}_ratapersepsi_rata"] ?? 0) - ($reliabilityData["r{$i}_ratakepentingan_rata"] ?? 0);
                                                    $gapClass = $gap >= 0 ? 'gap-positive' : 'gap-negative';
                                                @endphp
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-center font-bold {{ $gapClass }} rounded-lg mx-1 my-2 transition-all duration-200">
                                                    {{ number_format($gap, 2) }}
                                                </td>
                                            @endfor
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Dimensi Tangible Section -->
            <div class="bg-white overflow-hidden shadow-2xl sm:rounded-2xl border-0 relative animate-fade-in-up mt-8">
                <!-- Gradient border effect -->
                <div class="absolute inset-0 bg-gradient-to-r from-green-500 via-teal-500 to-cyan-500 rounded-2xl opacity-10"></div>
                
                <div class="relative bg-white sm:rounded-2xl p-8">
                    <div class="mb-8">
                        <div class="flex items-center justify-center mb-8 animate-fade-in-up">
                            <div class="bg-gradient-to-r from-green-500 to-teal-600 p-3 rounded-full mr-4 shadow-lg">
                                <i class="fas fa-building text-white text-xl"></i>
                            </div>
                            <div>
                                <h2 class="text-3xl font-bold bg-gradient-to-r from-green-600 to-teal-600 bg-clip-text text-transparent">
                                    {{ __('Dimensi Tangible') }}
                                </h2>
                                <p class="text-gray-600 text-sm mt-1">Analisis Gap Persepsi vs Harapan Pelanggan</p>
                            </div>
                        </div>
                        
                        @if(empty($tangibleData) || !is_array($tangibleData))
                            <div class="text-center py-8">
                                <div class="inline-flex items-center justify-center w-16 h-16 bg-red-100 rounded-full mb-4">
                                    <i class="fas fa-exclamation-triangle text-red-600 text-2xl"></i>
                                </div>
                                <h3 class="text-lg font-medium text-gray-900 mb-2">{{ __('Data Tidak Tersedia') }}</h3>
                                <p class="text-gray-500">{{ __('Tidak ada data yang dapat ditampilkan untuk grafik Tangible.') }}</p>
                            </div>
                        @else
                            <div class="flex justify-center mb-6">
                                <div id="tangible-chart" class="w-full max-w-4xl h-[28rem] chart-container relative overflow-hidden">
                                    <!-- Loading overlay -->
                                    <div id="tangible-chart-loading" class="absolute inset-0 bg-white bg-opacity-90 flex items-center justify-center rounded-xl z-10">
                                        <div class="text-center">
                                            <div class="loading-spinner"></div>
                                            <p class="text-gray-600 font-medium">Memuat grafik...</p>
                                            <p class="text-gray-400 text-sm animate-pulse-slow">Menganalisis data Tangible</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="overflow-x-auto animate-fade-in-up">
                                <table class="min-w-full divide-y divide-gray-200 bg-white border-0 table-enhanced">
                                    <thead class="table-header-gradient">
                                        <tr>
                                            <th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">
                                                <span class="flex items-center">
                                                    <i class="fas fa-chart-line mr-2"></i>
                                                    Kategori
                                                </span>
                                            </th>
                                            <th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">T1</th>
                                            <th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">T2</th>
                                            <th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">T3</th>
                                            <th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">T4</th>
                                            <th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">T5</th>
                                            <th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">T6</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        <tr class="table-row-hover">
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 border-r border-gray-200">
                                                <span class="flex items-center">
                                                    <div class="w-3 h-3 rounded-full bg-blue-600 mr-3"></div>
                                                    {{ __('Rata-rata persepsi') }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-center font-medium">{{ number_format($tangibleData['t1_ratapersepsi_rata'] ?? 0, 2) }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-center font-medium">{{ number_format($tangibleData['t2_ratapersepsi_rata'] ?? 0, 2) }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-center font-medium">{{ number_format($tangibleData['t3_ratapersepsi_rata'] ?? 0, 2) }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-center font-medium">{{ number_format($tangibleData['t4_ratapersepsi_rata'] ?? 0, 2) }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-center font-medium">{{ number_format($tangibleData['t5_ratapersepsi_rata'] ?? 0, 2) }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-center font-medium">{{ number_format($tangibleData['t6_ratapersepsi_rata'] ?? 0, 2) }}</td>
                                        </tr>
                                        <tr class="table-row-hover">
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 border-r border-gray-200">
                                                <span class="flex items-center">
                                                    <div class="w-3 h-3 rounded-full bg-orange-500 mr-3"></div>
                                                    {{ __('Rata-rata harapan') }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-center font-medium">{{ number_format($tangibleData['t1_ratakepentingan_rata'] ?? 0, 2) }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-center font-medium">{{ number_format($tangibleData['t2_ratakepentingan_rata'] ?? 0, 2) }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-center font-medium">{{ number_format($tangibleData['t3_ratakepentingan_rata'] ?? 0, 2) }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-center font-medium">{{ number_format($tangibleData['t4_ratakepentingan_rata'] ?? 0, 2) }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-center font-medium">{{ number_format($tangibleData['t5_ratakepentingan_rata'] ?? 0, 2) }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-center font-medium">{{ number_format($tangibleData['t6_ratakepentingan_rata'] ?? 0, 2) }}</td>
                                        </tr>
                                        <tr class="table-row-hover">
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 border-r border-gray-200">
                                                <span class="flex items-center">
                                                    <div class="w-3 h-3 rounded-full bg-gray-600 mr-3"></div>
                                                    {{ __('Gap') }}
                                                </span>
                                            </td>
                                            @for($i = 1; $i <= 6; $i++)
                                                @php
                                                    $gap = ($tangibleData["t{$i}_ratapersepsi_rata"] ?? 0) - ($tangibleData["t{$i}_ratakepentingan_rata"] ?? 0);
                                                    $gapClass = $gap >= 0 ? 'gap-positive' : 'gap-negative';
                                                @endphp
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-center font-bold {{ $gapClass }} rounded-lg mx-1 my-2 transition-all duration-200">
                                                    {{ number_format($gap, 2) }}
                                                </td>
                                            @endfor
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

/* Enhanced table styles */
.table-enhanced {
    overflow: hidden;
    border-radius: 12px;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
}

.table-header-gradient {
    background: linear-gradient(135deg, #3B82F6 0%, #8B5CF6 100%);
}

.gap-positive {
    background-color: rgba(16, 185, 129, 0.1);
    color: #059669;
    font-weight: 600;
    border-radius: 6px;
    margin: 2px;
    padding: 4px 8px;
    transition: all 0.2s ease;
}

.gap-negative {
    background-color: rgba(239, 68, 68, 0.1);
    color: #DC2626;
    font-weight: 600;
    border-radius: 6px;
    margin: 2px;
    padding: 4px 8px;
    transition: all 0.2s ease;
}

.table-row-hover:hover {
    background-color: rgba(59, 130, 246, 0.05);
    transform: translateY(-1px);
    transition: all 0.2s ease;
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

@keyframes pulse {
    0%, 100% {
        opacity: 1;
    }
    50% {
        opacity: 0.5;
    }
}

.animate-fade-in-up {
    animation: fadeInUp 0.6s ease-out;
}

.animate-pulse-slow {
    animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
}

/* Enhanced loading spinner */
.loading-spinner {
    border: 3px solid #f3f3f3;
    border-top: 3px solid #3B82F6;
    border-radius: 50%;
    width: 40px;
    height: 40px;
    animation: spin 1s linear infinite;
    margin: 0 auto 16px;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
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
                d3.select('#chart-loading').style('display', 'none');
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
    
    if (chartData && Object.keys(chartData).length > 0) {
        const categories = ['R1', 'R2', 'R3', 'R4', 'R5', 'R6', 'R7'];
        createGroupedBarChart(chartData, categories, 'reliability-chart', '{{ __("Dimensi Reliability") }}', questionsData);
    }
    
    if (tangibleChartData && Object.keys(tangibleChartData).length > 0) {
        const tangibleCategories = ['T1', 'T2', 'T3', 'T4', 'T5', 'T6'];
        createGroupedBarChart(tangibleChartData, tangibleCategories, 'tangible-chart', '{{ __("Dimensi Tangible") }}', tangibleQuestionsData);
    }
});
</script>
