<x-app-layout>
    <div class="py-12 bg-gradient-to-br from-blue-50 to-indigo-100 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Back Button -->
            <div class="mb-6">
                <a href="{{ route($type === 'produk' ? 'dashboard.produk' : 'dashboard.pelatihan') }}" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-500 to-blue-600 border border-blue-500 rounded-lg shadow-sm text-sm font-medium text-white hover:from-blue-600 hover:to-blue-700 hover:border-blue-600 transition-all duration-200 transform hover:scale-105">
                    <i class="fas fa-arrow-left mr-2 text-lg"></i>
                    <span class="font-semibold">Kembali ke Dashboard</span>
                </a>
            </div>


            <div class="bg-white overflow-hidden shadow-2xl sm:rounded-2xl border-0 relative animate-fade-in">
                <!-- Gradient border effect -->
                <div class="absolute inset-0 bg-gradient-to-r from-blue-500 via-purple-500 to-pink-500 rounded-2xl opacity-10"></div>

                <div class="relative bg-white sm:rounded-2xl p-8">
            @php
            function renderProfileSection($ageData, $genderData, $occupationData, $domicileData) {
                $output = '';

                // Section container start
                $output .= '<div class="bg-white overflow-hidden shadow-2xl sm:rounded-2xl border-0 relative animate-fade-in mt-8">';
                $output .= '<div class="absolute inset-0 bg-gradient-to-r from-blue-500 via-purple-500 to-pink-500 rounded-2xl opacity-10"></div>';
                $output .= '<div class="relative bg-white sm:rounded-2xl p-8">';
                $output .= '<div class="mb-8">';

                // Header
                $output .= '<div class="flex items-center justify-center mb-8 animate-fade-in">';
                $output .= '<div class="bg-gradient-to-r from-blue-500 to-purple-600 p-3 rounded-full mr-4 shadow-lg">';
                $output .= '<i class="fas fa-users text-white text-xl"></i>';
                $output .= '</div>';
                $output .= '<div>';
                $output .= '<h2 class="text-3xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">';
                $output .= __('Profil Responden');
                $output .= '</h2>';
                $output .= '<p class="text-gray-600 text-sm mt-1">Analisis demografi responden survei</p>';
                $output .= '</div>';
                $output .= '</div>';

                // Check if data exists
                $hasAgeData = !empty($ageData) && array_sum(array_column($ageData, 'male')) + array_sum(array_column($ageData, 'female')) > 0;
                $hasGenderData = !empty($genderData) && array_sum(array_column($genderData, 'value')) > 0;
                $hasOccupationData = !empty($occupationData) && array_sum(array_column($occupationData, 'value')) > 0;
                $hasDomicileData = !empty($domicileData) && array_sum(array_column($domicileData, 'value')) > 0;

                if (!$hasAgeData && !$hasGenderData && !$hasOccupationData && !$hasDomicileData) {
                    $output .= '<div class="text-center py-8">';
                    $output .= '<div class="inline-flex items-center justify-center w-16 h-16 bg-red-100 rounded-full mb-4">';
                    $output .= '<i class="fas fa-exclamation-triangle text-red-600 text-2xl"></i>';
                    $output .= '</div>';
                    $output .= '<h3 class="text-lg font-medium text-gray-900 mb-2">' . __('Data Tidak Tersedia') . '</h3>';
                    $output .= '<p class="text-gray-500">' . __('Tidak ada data profil responden yang dapat ditampilkan.') . '</p>';
                    $output .= '</div>';
                } else {
                    // Age by Gender Bar Chart
                    if ($hasAgeData) {
                    $output .= '<div class="mb-12">';
                    $output .= '<h3 class="text-xl font-semibold mb-4 text-center">Distribusi Usia Berdasarkan Jenis Kelamin</h3>';
                    $output .= '<div class="flex justify-center mb-6">';
                    $output .= '<div id="age-gender-chart" class="w-full max-w-6xl h-[32rem] chart-container relative overflow-hidden">';
                    $output .= '<div id="age-gender-chart-loading" class="absolute inset-0 bg-white bg-opacity-90 flex items-center justify-center rounded-xl z-10">';
                    $output .= '<div class="text-center">';
                    $output .= '<div class="animate-spin rounded-full h-10 w-10 border-b-2 border-blue-600 mx-auto mb-4"></div>';
                    $output .= '<p class="text-gray-600 font-medium">Memuat grafik...</p>';
                    $output .= '<p class="text-gray-400 text-sm animate-pulse">Menganalisis data usia</p>';
                    $output .= '</div>';
                    $output .= '</div>';
                    $output .= '</div>';
                    $output .= '</div>';
                    }

                    // Age Pie Chart
                    if ($hasAgeData) {
                    $output .= '<div class="mb-12">';
                    $output .= '<h3 class="text-xl font-semibold mb-4 text-center">Distribusi Usia Responden</h3>';
                    $output .= '<div class="flex justify-center mb-6">';
                    $output .= '<div id="age-pie-chart" class="w-full max-w-4xl h-[32rem] chart-container relative overflow-hidden">';
                    $output .= '<div id="age-pie-chart-loading" class="absolute inset-0 bg-white bg-opacity-90 flex items-center justify-center rounded-xl z-10">';
                    $output .= '<div class="text-center">';
                    $output .= '<div class="animate-spin rounded-full h-10 w-10 border-b-2 border-blue-600 mx-auto mb-4"></div>';
                    $output .= '<p class="text-gray-600 font-medium">Memuat grafik...</p>';
                    $output .= '<p class="text-gray-400 text-sm animate-pulse">Menganalisis data usia</p>';
                    $output .= '</div>';
                    $output .= '</div>';
                    $output .= '</div>';
                    $output .= '</div>';
                    }

                    // Occupation Pie Chart
                    if ($hasOccupationData) {
                    $output .= '<div class="mb-12">';
                    $output .= '<h3 class="text-xl font-semibold mb-4 text-center">Distribusi Pekerjaan Responden</h3>';
                    $output .= '<div class="flex justify-center mb-6">';
                    $output .= '<div id="occupation-pie-chart" class="w-full max-w-4xl h-[32rem] chart-container relative overflow-hidden">';
                    $output .= '<div id="occupation-pie-chart-loading" class="absolute inset-0 bg-white bg-opacity-90 flex items-center justify-center rounded-xl z-10">';
                    $output .= '<div class="text-center">';
                    $output .= '<div class="animate-spin rounded-full h-10 w-10 border-b-2 border-blue-600 mx-auto mb-4"></div>';
                    $output .= '<p class="text-gray-600 font-medium">Memuat grafik...</p>';
                    $output .= '<p class="text-gray-400 text-sm animate-pulse">Menganalisis data pekerjaan</p>';
                    $output .= '</div>';
                    $output .= '</div>';
                    $output .= '</div>';
                    $output .= '</div>';
                    }

                    // Domicile Pie Chart
                    if ($hasDomicileData) {
                    $output .= '<div class="mb-12">';
                    $output .= '<h3 class="text-xl font-semibold mb-4 text-center">Distribusi Domisili Responden</h3>';
                    $output .= '<div class="flex justify-center mb-6">';
                    $output .= '<div id="domicile-pie-chart" class="w-full max-w-4xl h-[32rem] chart-container relative overflow-hidden">';
                    $output .= '<div id="domicile-pie-chart-loading" class="absolute inset-0 bg-white bg-opacity-90 flex items-center justify-center rounded-xl z-10">';
                    $output .= '<div class="text-center">';
                    $output .= '<div class="animate-spin rounded-full h-10 w-10 border-b-2 border-blue-600 mx-auto mb-4"></div>';
                    $output .= '<p class="text-gray-600 font-medium">Memuat grafik...</p>';
                    $output .= '<p class="text-gray-400 text-sm animate-pulse">Menganalisis data domisili</p>';
                    $output .= '</div>';
                    $output .= '</div>';
                    $output .= '</div>';
                    $output .= '</div>';
                    }
                }

                // Section container end
                $output .= '</div>';
                $output .= '</div>';
                $output .= '</div>';

                return $output;
            }
            @endphp

            {!! renderProfileSection($ageData, $genderData, $occupationData, $domicileData) !!}
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

.bar:hover, .arc:hover {
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
            male: '#3B82F6',
            female: '#EC4899',
            age: d3.scaleOrdinal(d3.schemeCategory10),
            occupation: d3.scaleOrdinal(d3.schemeSet3),
            domicile: d3.scaleOrdinal(d3.schemePaired)
        }
    };

    // Function to create grouped bar chart for age by gender
    function createAgeGenderChart(data, containerId) {
        try {
            if (!data || !Array.isArray(data) || data.length === 0) {
                console.error('Invalid data provided to age-gender chart');
                return;
            }

            const margin = chartConfig.margin;
            const width = chartConfig.width - margin.left - margin.right;
            const height = chartConfig.height - margin.top - margin.bottom;

            const container = d3.select(`#${containerId}`);
            container.selectAll('*').remove();

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

            const ageGroups = data.map(d => d.age_group);
            const maleData = data.map(d => d.male);
            const femaleData = data.map(d => d.female);

            const x0 = d3.scaleBand()
                .domain(ageGroups)
                .range([0, width])
                .padding(0.2);

            const x1 = d3.scaleBand()
                .domain(['Laki-laki', 'Perempuan'])
                .range([0, x0.bandwidth()])
                .padding(0.05);

            const allValues = [...maleData, ...femaleData, 0];
            const y = d3.scaleLinear()
                .domain([0, d3.max(allValues)])
                .nice()
                .range([height, 0]);

            const ageGroupsG = svg.selectAll('.age-group')
                .data(ageGroups)
                .enter().append('g')
                .attr('class', 'age-group')
                .attr('transform', d => `translate(${x0(d)},0)`);

            ['Laki-laki', 'Perempuan'].forEach((gender, i) => {
                const data = i === 0 ? maleData : femaleData;
                const color = i === 0 ? chartConfig.colors.male : chartConfig.colors.female;

                const bars = ageGroupsG.append('rect')
                    .attr('x', x1(gender))
                    .attr('y', height)
                    .attr('width', x1.bandwidth())
                    .attr('height', 0)
                    .attr('fill', color)
                    .attr('opacity', 0.8)
                    .attr('class', 'bar')
                    .style('cursor', 'pointer');

                bars.transition()
                    .duration(800)
                    .attr('y', (d, j) => y(data[j]))
                    .attr('height', (d, j) => height - y(data[j]))
                    .delay((d, j) => j * 100 + i * 50)
                    .ease(d3.easeBounce);

                bars.on('mouseover', function(event, d) {
                    const ageGroupIndex = ageGroups.indexOf(d);
                    const value = data[ageGroupIndex];
                    const containerRect = container.node().getBoundingClientRect();
                    const svgRect = svg.node().getBoundingClientRect();
                    const barX = parseFloat(d3.select(this).attr('x')) + x1.bandwidth() / 2;
                    const barY = parseFloat(d3.select(this).attr('y'));
                    const tooltipX = svgRect.left - containerRect.left + margin.left + barX;
                    const tooltipY = svgRect.top - containerRect.top + margin.top + barY - 8;

                    tooltip
                        .style('opacity', 1)
                        .html(`<div class="font-semibold">${d} - ${gender}</div><div>Jumlah: ${value}</div>`)
                        .style('left', tooltipX + 'px')
                        .style('top', tooltipY + 'px');
                }).on('mouseout', function() {
                    tooltip.style('opacity', 0);
                });

                ageGroupsG.append('text')
                    .attr('x', x1(gender) + x1.bandwidth() / 2)
                    .attr('y', (d, j) => y(data[j]) - 5)
                    .attr('text-anchor', 'middle')
                    .attr('font-size', '10px')
                    .attr('fill', '#000')
                    .text((d, j) => data[j]);
            });

            svg.append('g')
                .attr('transform', `translate(0,${height})`)
                .call(d3.axisBottom(x0))
                .selectAll('text')
                .attr('transform', 'rotate(-45)')
                .style('text-anchor', 'end');

            svg.append('g')
                .call(d3.axisLeft(y));

            svg.append('text')
                .attr('x', width / 2)
                .attr('y', -10)
                .attr('text-anchor', 'middle')
                .attr('font-size', '16px')
                .attr('font-weight', 'bold')
                .text('Distribusi Usia Berdasarkan Jenis Kelamin');

            const legend = svg.append('g')
                .attr('class', 'legend')
                .attr('transform', `translate(${(width - 200) / 2}, ${height + 50})`);

            const legendItems = [
                { label: 'Laki-laki', color: chartConfig.colors.male },
                { label: 'Perempuan', color: chartConfig.colors.female }
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

            setTimeout(() => {
                d3.select(`#${containerId}-loading`).style('display', 'none');
            }, 2000);

        } catch (error) {
            console.error('Error creating age-gender chart:', error);
            d3.select(`#${containerId}`)
                .html('<div class="text-center py-8 text-red-600"><i class="fas fa-exclamation-triangle text-2xl mb-2"></i><br>Gagal memuat grafik usia</div>');
        }
    }

    // Function to create pie chart
    function createPieChart(data, containerId, title, colorScale) {
        try {
            if (!data || !Array.isArray(data) || data.length === 0) {
                console.error('Invalid data provided to pie chart');
                return;
            }

            const width = 600;
            const height = 400;
            const radius = Math.min(width, height) / 2 - 40;

            const container = d3.select(`#${containerId}`);
            container.selectAll('*').remove();

            if (container.empty()) {
                console.error(`Container #${containerId} not found`);
                return;
            }

            const svg = container
                .append('svg')
                .attr('width', width)
                .attr('height', height)
                .append('g')
                .attr('transform', `translate(${width / 2},${height / 2})`);

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

            const pie = d3.pie()
                .value(d => d.value)
                .sort(null);

            const arc = d3.arc()
                .innerRadius(0)
                .outerRadius(radius);

            const arcs = svg.selectAll('.arc')
                .data(pie(data))
                .enter().append('g')
                .attr('class', 'arc');

            arcs.append('path')
                .attr('d', arc)
                .attr('fill', (d, i) => colorScale(d.data.label))
                .attr('opacity', 0.8)
                .attr('class', 'arc')
                .style('cursor', 'pointer')
                .on('mouseover', function(event, d) {
                    const containerRect = container.node().getBoundingClientRect();
                    const svgRect = svg.node().getBoundingClientRect();
                    const tooltipX = event.pageX - containerRect.left;
                    const tooltipY = event.pageY - containerRect.top - 10;

                    tooltip
                        .style('opacity', 1)
                        .html(`<div class="font-semibold">${d.data.label}</div><div>Jumlah: ${d.data.value}</div><div>Persentase: ${(d.data.value / d3.sum(data, d => d.value) * 100).toFixed(1)}%</div>`)
                        .style('left', tooltipX + 'px')
                        .style('top', tooltipY + 'px');
                })
                .on('mouseout', function() {
                    tooltip.style('opacity', 0);
                });

            // Add labels
            arcs.append('text')
                .attr('transform', d => `translate(${arc.centroid(d)})`)
                .attr('text-anchor', 'middle')
                .attr('font-size', '12px')
                .attr('fill', 'white')
                .attr('font-weight', 'bold')
                .text(d => `${(d.data.value / d3.sum(data, d => d.value) * 100).toFixed(1)}%`);

            // Add legend
            const legend = svg.selectAll('.legend')
                .data(data)
                .enter().append('g')
                .attr('class', 'legend')
                .attr('transform', (d, i) => `translate(-${width/2 - 20}, ${height/2 - 20 - i * 20})`);

            legend.append('rect')
                .attr('width', 12)
                .attr('height', 12)
                .attr('fill', d => colorScale(d.label));

            legend.append('text')
                .attr('x', 18)
                .attr('y', 9)
                .attr('text-anchor', 'start')
                .attr('font-size', '12px')
                .attr('fill', '#333')
                .text(d => `${d.label}: ${d.value}`);

            svg.append('text')
                .attr('x', 0)
                .attr('y', -height/2 + 20)
                .attr('text-anchor', 'middle')
                .attr('font-size', '16px')
                .attr('font-weight', 'bold')
                .text(title);

            setTimeout(() => {
                d3.select(`#${containerId}-loading`).style('display', 'none');
            }, 2000);

        } catch (error) {
            console.error('Error creating pie chart:', error);
            d3.select(`#${containerId}`)
                .html('<div class="text-center py-8 text-red-600"><i class="fas fa-exclamation-triangle text-2xl mb-2"></i><br>Gagal memuat grafik pie</div>');
        }
    }

    // Initialize charts
    const ageData = @json($ageData);
    const genderData = @json($genderData);
    const occupationData = @json($occupationData);
    const domicileData = @json($domicileData);

    // Create age distribution data for pie chart
    const ageDistributionData = ageData.map(item => ({
        label: item.age_group,
        value: item.male + item.female
    })).filter(item => item.value > 0);

    if (ageData && ageData.length > 0) {
        createAgeGenderChart(ageData, 'age-gender-chart');
    }

    if (ageDistributionData && ageDistributionData.length > 0) {
        createPieChart(ageDistributionData, 'age-pie-chart', 'Distribusi Usia Responden', chartConfig.colors.age);
    }

    if (occupationData && occupationData.length > 0) {
        createPieChart(occupationData, 'occupation-pie-chart', 'Distribusi Pekerjaan Responden', chartConfig.colors.occupation);
    }

    if (domicileData && domicileData.length > 0) {
        createPieChart(domicileData, 'domicile-pie-chart', 'Distribusi Domisili Responden', chartConfig.colors.domicile);
    }
});
</script>
