<x-guest-layout>
    <div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-6xl mx-auto space-y-8">
            <!-- Debug: Print $data -->
            <!-- <div class="bg-white shadow rounded-lg p-6 mb-6">
                <h2 class="text-xl font-bold text-red-600">Debug: Isi $data</h2>
                <pre class="bg-gray-100 p-4 rounded text-sm">{{ json_encode($data, JSON_PRETTY_PRINT) }}</pre>
                <pre class="bg-gray-100 p-4 rounded text-sm">{{ json_encode($results, JSON_PRETTY_PRINT) }}</pre>

            </div> -->

            <!-- Header -->
            <div class="bg-white shadow rounded-lg p-6">
                <h1 class="text-3xl font-bold text-gray-900">Dashboard Hasil Evaluasi</h1>
                <h2 class="text-xl text-gray-700 mt-2">{{ $data['company_name'] }}</h2>
                <div class="mt-4 flex space-x-4">
                    @if(!$isShared)
                        <a href="{{ route('customer-management-evaluation.maturity') }}"
                            class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Edit Evaluasi
                        </a>
                        <a href="{{ route('customer-management-evaluation.welcome') }}"
                            class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Mulai Asesmen Baru
                        </a>
                    @endif
                    <div class="flex items-center">
                        <label for="share-link" class="block text-sm font-medium text-gray-700 mr-2">Link Share:</label>
                        <input id="share-link" type="text" readonly
                            value="{{ url('/customer-management-evaluation/dashboard/' . $token) }}"
                            class="block w-96 px-3 py-2 border border-gray-300 rounded-md shadow-sm bg-gray-50 text-sm"
                            onclick="this.select()">
                    </div>
                </div>
            </div>

            <!-- Maturity Assessment -->
            <div class="bg-white shadow rounded-lg p-6">
                <h3 class="text-2xl font-bold text-gray-900 mb-4">Maturity Assessment</h3>
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <div>
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Komponen</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Nilai</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @php
                                    // Define labels for maturity keys
                                    $maturityLabels = [
                                        'visi' => 'Visi',
                                        'strategi' => 'Strategi',
                                        'pengalamanKonsumen' => 'Pengalaman Konsumen',
                                        'kolaborasiOrganisasi' => 'Kolaborasi Organisasi',
                                        'proses' => 'Proses',
                                        'informasi' => 'Informasi',
                                        'teknologi' => 'Teknologi',
                                        'matriks' => 'Matriks',
                                    ];
                                @endphp

                                @foreach($maturityLabels as $key => $label)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            {{ $label }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $data['maturity'][$key] ?? 0 }}
                                        </td>
                                    </tr>
                                @endforeach
                                <tr class="bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900">Average</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900">
                                        {{ number_format($results['maturityAverage'], 2) }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div>
                        <h4 class="text-lg font-medium text-gray-900 mb-2">Insights Gained</h4>
                        <h5 class="text-md font-semibold text-indigo-600 mb-3">
                            {{ $results['maturityInsightData']['title'] }}
                        </h5>
                        <p class="text-sm text-gray-600 whitespace-pre-wrap">
                            {{ $results['maturityInsightData']['description'] }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Readiness Audit -->
            <div class="bg-white shadow rounded-lg p-6">
                <h3 class="text-2xl font-bold text-gray-900 mb-4">Readiness Audit</h3>
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <div>
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Bobot Kepentingan</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Bobot</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Performansi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($results['persepsiData'] as $item)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            {{ $item['label'] }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $item['harapan'] }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ number_format($item['persepsi'], 0) }}%
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div>
                        <h4 class="text-lg font-medium text-gray-900 mb-4">Harapan - Persepsi Analysis</h4>
                        <div class="bg-white p-4 rounded-lg border">
                            <div id="scatter-chart" class="w-full" style="height: 300px;"></div>
                            <div class="mt-3">
                                <button id="toggle-debug" class="text-sm text-indigo-600 underline">Toggle plot
                                    debug</button>
                                <pre id="scatter-debug" class="hidden mt-2 p-2 bg-gray-100 text-xs rounded"
                                    style="max-height:200px;overflow:auto;"></pre>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Persepsi Assessment -->
            <div class="bg-white shadow rounded-lg p-6">
                <h3 class="text-2xl font-bold text-gray-900 mb-4">Persepsi Assessment</h3>
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <div>
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Proses Sistem Pengelolaan Pelanggan</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Performansi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($results['processGroupResults'] as $group)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            {{ $group['name'] }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $group['persepsi'] }}%
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="flex items-center justify-center bg-indigo-50 p-6 rounded-lg">
                        <div class="text-center">
                            <h4 class="text-lg font-medium text-gray-900 mb-2">Nilai Sistem Pengelolaan Pelanggan</h4>
                            <div class="text-6xl font-bold text-indigo-600">{{ $results['overallScore'] }}</div>
                        </div>
                    </div>
                </div>
                <div class="mt-6 border-t border-gray-200 pt-6">
                    <h4 class="text-lg font-medium text-gray-900 mb-2">Rekomendasi</h4>
                    <p class="text-sm text-gray-600 whitespace-pre-wrap">{{ $results['recommendation'] }}</p>
                </div>
            </div>
        </div>
    </div>
    <script src="https://d3js.org/d3.v7.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const data = @json($results['persepsiData']);
            const width = 450;
            const height = 300;
            const padding = 40;
            const xMax = 25;
            const yMax = 100;
            const xMid = 12.5;
            const yMid = 70;

            // create svg and allow overflow so labels outside the chart area remain visible
            const svg = d3.select('#scatter-chart')
                .append('svg')
                .attr('width', '100%')
                .attr('height', height)
                .attr('viewBox', `0 0 ${width} ${height}`)
                .style('overflow', 'visible');

            const xScale = d3.scaleLinear().domain([0, xMax]).range([padding, width - padding]);
            const yScale = d3.scaleLinear().domain([0, yMax]).range([height - padding, padding]);

            // Grid lines
            const xTicks = [0, 5, 10, 15, 20, 25];
            const yTicks = [0, 20, 40, 60, 80, 100];
            xTicks.forEach(tick => {
                svg.append('line')
                    .attr('x1', xScale(tick)).attr('y1', padding)
                    .attr('x2', xScale(tick)).attr('y2', height - padding)
                    .attr('stroke', '#e5e7eb').attr('stroke-width', 1);
            });
            yTicks.forEach(tick => {
                svg.append('line')
                    .attr('x1', padding).attr('y1', yScale(tick))
                    .attr('x2', width - padding).attr('y2', yScale(tick))
                    .attr('stroke', '#e5e7eb').attr('stroke-width', 1);
            });

            // Quadrants
            svg.append('rect').attr('x', padding).attr('y', padding)
                .attr('width', xScale(xMid) - padding).attr('height', yScale(yMid) - padding)
                .attr('fill', '#fef3c7').attr('opacity', 0.3);
            svg.append('rect').attr('x', xScale(xMid)).attr('y', padding)
                .attr('width', width - padding - xScale(xMid)).attr('height', yScale(yMid) - padding)
                .attr('fill', '#d1fae5').attr('opacity', 0.3);
            svg.append('rect').attr('x', padding).attr('y', yScale(yMid))
                .attr('width', xScale(xMid) - padding).attr('height', height - padding - yScale(yMid))
                .attr('fill', '#fee2e2').attr('opacity', 0.3);
            svg.append('rect').attr('x', xScale(xMid)).attr('y', yScale(yMid))
                .attr('width', width - padding - xScale(xMid)).attr('height', height - padding - yScale(yMid))
                .attr('fill', '#d1fae5').attr('opacity', 0.3);

            // Quadrant labels
            svg.append('text').attr('x', padding + 10).attr('y', padding + 20).attr('font-size', 12).attr('fill', '#92400e').text('Low Priority');
            svg.append('text').attr('x', width - padding - 60).attr('y', padding + 20).attr('font-size', 12).attr('fill', '#166534').text('Keep Up');
            svg.append('text').attr('x', padding + 10).attr('y', height - padding - 10).attr('font-size', 12).attr('fill', '#dc2626').text('Low Priority');
            svg.append('text').attr('x', width - padding - 60).attr('y', height - padding - 10).attr('font-size', 12).attr('fill', '#166534').text('High Priority');

            // Axis
            svg.append('line').attr('x1', padding).attr('y1', height - padding).attr('x2', width - padding).attr('y2', height - padding).attr('stroke', '#374151').attr('stroke-width', 2);
            svg.append('line').attr('x1', padding).attr('y1', padding).attr('x2', padding).attr('y2', height - padding).attr('stroke', '#374151').attr('stroke-width', 2);

            // Axis ticks and labels
            xTicks.forEach(tick => {
                svg.append('line').attr('x1', xScale(tick)).attr('y1', height - padding).attr('x2', xScale(tick)).attr('y2', height - padding + 5).attr('stroke', '#374151').attr('stroke-width', 1);
                svg.append('text').attr('x', xScale(tick)).attr('y', height - padding + 20).attr('text-anchor', 'middle').attr('font-size', 10).attr('fill', '#6b7280').text(tick);
            });
            yTicks.forEach(tick => {
                svg.append('line').attr('x1', padding).attr('y1', yScale(tick)).attr('x2', padding - 5).attr('y2', yScale(tick)).attr('stroke', '#374151').attr('stroke-width', 1);
                svg.append('text').attr('x', padding - 10).attr('y', yScale(tick) + 4).attr('text-anchor', 'end').attr('font-size', 10).attr('fill', '#6b7280').text(tick);
            });

            // Axis labels
            svg.append('text').attr('x', width / 2).attr('y', height - 10).attr('text-anchor', 'middle').attr('font-size', 12).attr('fill', '#374151').text('Harapan');
            svg.append('text').attr('x', 15).attr('y', height / 2).attr('text-anchor', 'middle').attr('transform', `rotate(-90 15 ${height / 2})`).attr('font-size', 12).attr('fill', '#374151').text('Persepsi (%)');

            // Prepare point data (fixed) and separate label nodes (movable)
            const colors = ['#ef4444', '#f97316', '#eab308', '#22c55e', '#3b82f6', '#8b5cf6', '#ec4899', '#6b7280', '#374151', '#f59e0b', '#10b981'];
            const points = data.map((item, index) => {
                // Use raw harapan value directly for plotting.
                // The backend/table shows `harapan` as the "Bobot" column; chart will now reflect that same value.
                const rawHarapan = Number(item.harapan);
                const rawPersepsi = Number(item.persepsi);
                const harapan = rawHarapan; // no frontend scaling/detection
                const persepsi = rawPersepsi;
                const x = xScale(harapan);
                const y = yScale(persepsi);
                const color = colors[index % colors.length];
                const fullLabel = item.label;
                const displayLabel = String(item.label).length > 15 ? String(item.label).substring(0, 15) + '…' : String(item.label);
                return { x, y, color, fullLabel, label: displayLabel, rawHarapan: rawHarapan, rawPersepsi: rawPersepsi, plottedHarapan: harapan };
            });

            // clamp function to ensure circles stay inside plotting area
            const clampX = (x) => Math.max(padding, Math.min(width - padding, x));
            const clampY = (y) => Math.max(padding, Math.min(height - padding, y));

            // attach clamped coordinates and log if any point is out-of-range (debug)
            points.forEach((p, idx) => {
                p.cx = clampX(p.x);
                p.cy = clampY(p.y);
                if (p.x !== p.cx || p.y !== p.cy) {
                    console.warn(`Point #${idx} was out of plotting bounds. rawHarapan=${p.rawHarapan}, plottedHarapan=${p.plottedHarapan}, rawPersepsi=${p.rawPersepsi}, x=${p.x}, y=${p.y}, clamped to cx=${p.cx}, cy=${p.cy}`);
                }
            });

            // Draw fixed points
            svg.selectAll('circle')
                .data(points)
                .enter()
                .append('circle')
                .attr('cx', d => d.cx) // use clamped coordinates for visible points
                .attr('cy', d => d.cy)
                .attr('r', 6)
                .attr('fill', d => d.color)
                .attr('stroke', '#ffffff')
                .attr('stroke-width', 2)
                .style('cursor', 'pointer')
                .on('mouseover', function(event, d, i) { showTooltip(event, { index: i }); })
                .on('mousemove', function(event, d, i) { showTooltip(event, { index: i }); })
                .on('mouseout', hideTooltip);

            // Create label nodes (movable). Initial offset is to the right-top.
            const labelNodes = points.map((p, i) => ({
                x: p.x + 25,
                y: p.y - 10,
                targetX: p.x,
                targetY: p.y,
                label: p.label,
                fullLabel: p.fullLabel,
                color: p.color,
                width: 0,
                plottedHarapan: p.plottedHarapan,
                rawPersepsi: p.rawPersepsi,
                index: i,
                cx: p.cx,
                cy: p.cy
            }));

            // Lines from points to labels (x1/y1 fixed to point, x2/y2 follow label)
            const lines = svg.selectAll('.connector')
                .data(labelNodes)
                .enter()
                .append('line')
                .attr('class', 'connector')
                // use clamped point coordinates as connector start so visible on chart edge
                .attr('x1', (d, i) => points[i].cx)
                .attr('y1', (d, i) => points[i].cy)
                .attr('x2', (d) => d.x)
                .attr('y2', (d) => d.y)
                .attr('stroke', (d) => d.color)
                .attr('stroke-width', 1);

            // Labels
            const labelGroup = svg.append('g').attr('class', 'labels');
            const texts = labelGroup.selectAll('text')
                .data(labelNodes)
                .enter()
                .append('text')
                .attr('x', d => d.x)
                .attr('y', d => d.y)
                .attr('font-size', 10)
                .attr('fill', '#374151')
                .attr('stroke', '#ffffff')
                .attr('stroke-width', 3)
                .attr('paint-order', 'stroke fill')
                .text(d => d.label)
                .style('cursor', 'default');

            // Ensure the chart container can position an HTML tooltip
            d3.select('#scatter-chart').style('position', 'relative');
            const tooltip = d3.select('#scatter-chart').append('div')
                .attr('class', 'scatter-tooltip')
                .style('position', 'absolute')
                .style('pointer-events', 'none')
                .style('background', 'rgba(255,255,255,0.95)')
                .style('border', '1px solid #ddd')
                .style('padding', '6px 8px')
                .style('font-size', '12px')
                .style('color', '#111827')
                .style('border-radius', '4px')
                .style('box-shadow', '0 2px 6px rgba(0,0,0,0.08)')
                .style('display', 'none');

            function showTooltip(event, d, extra) {
                const containerNode = d3.select('#scatter-chart').node();
                const [cx, cy] = d3.pointer(event, containerNode);
                // d may be a point (circle) or a labelNode - map to labelNode when needed
                const node = d.fullLabel || d.label ? d : (extra && extra.index != null ? labelNodes[extra.index] : d);
                const label = node.fullLabel || node.label || '';
                const importance = node.plottedHarapan ?? node.plottedHarapan ?? extra?.plottedHarapan;
                const performance = node.rawPersepsi ?? extra?.rawPersepsi ?? '';
                const html = `<strong>${label}</strong><br/>Importance: ${importance}<br/>Performance: ${performance}%`;
                tooltip.html(html)
                    .style('left', Math.max(8, cx + 12) + 'px')
                    .style('top', Math.max(8, cy + 12) + 'px')
                    .style('display', 'block');
            }
            function hideTooltip() { tooltip.style('display', 'none'); }

            // Add hover for labels
          texts.on('mouseover', function(event, d) { showTooltip(event, d); })
              .on('mousemove', function(event, d) { showTooltip(event, d); })
              .on('mouseout', hideTooltip);

            // Measure text widths (needs DOM to render first) then store width in node
            // Use a short timeout to ensure browser has rendered the text
            setTimeout(() => {
                texts.each(function (d, i) {
                    const bbox = this.getBBox();
                    d.width = bbox.width;
                    d.height = bbox.height;
                });

                // Force simulation on labelNodes to avoid overlap. Labels are attracted to their target points but may move outside bounds.
                const simulation = d3.forceSimulation(labelNodes)
                    .force('collision', d3.forceCollide(d => Math.max(14, (d.width || 12) / 2 + 6)))
                    .force('x', d3.forceX(d => d.targetX + Math.sign(d.x - d.targetX) * 40).strength(0.25))
                    .force('y', d3.forceY(d => d.targetY + Math.sign(d.y - d.targetY) * 10).strength(0.25))
                    .force('repel', d3.forceManyBody().strength(-10))
                    .alpha(0.9)
                    .alphaDecay(0.04)
                    .on('tick', () => {
                        // Clamp label positions so they don't run arbitrarily far off-screen
                        texts.attr('x', d => d.x = Math.max(-100, Math.min(width + 100, d.x)))
                            .attr('y', d => d.y = Math.max(-50, Math.min(height + 50, d.y)));
                        lines.attr('x2', d => d.x).attr('y2', d => d.y);
                    });

                // Make labels draggable with mouse. After drag ends label stays fixed at new position (fx/fy).
                // Double-click a label to release it so the force simulation can reposition it again.
                const dragBehavior = d3.drag()
                    .on('start', function (event, d) {
                        if (!event.active) simulation.alphaTarget(0.3).restart();
                        d.fx = d.x;
                        d.fy = d.y;
                    })
                    .on('drag', function (event, d) {
                        // keep label within a reasonable canvas area
                        d.fx = Math.max(-100, Math.min(width + 100, event.x));
                        d.fy = Math.max(-50, Math.min(height + 50, event.y));
                        // move the text element being dragged
                        d3.select(this).attr('x', d.fx).attr('y', d.fy);
                        // update the connector line attached to this label
                        lines.filter(function (ln) { return ln.index === d.index; })
                            .attr('x2', d.fx)
                            .attr('y2', d.fy);
                    })
                    .on('end', function (event, d) {
                        if (!event.active) simulation.alphaTarget(0);
                        // lock position by keeping fx/fy; also sync internal x/y
                        d.x = d.fx;
                        d.y = d.fy;
                    });

                texts.call(dragBehavior);

                // double-click to release a label so simulation can reposition it again
                texts.on('dblclick', function (event, d) {
                    d.fx = null;
                    d.fy = null;
                    simulation.alpha(0.9).restart();
                });


                // expose debug data to debug panel
                const debugEl = document.getElementById('scatter-debug');
                if (debugEl) {
                    const debugData = points.map((p, i) => ({
                        index: i,
                        label: p.label,
                        rawHarapan: p.rawHarapan,
                        plottedHarapan: p.plottedHarapan,
                        rawPersepsi: p.rawPersepsi,
                        x: p.x,
                        y: p.y,
                        cx: p.cx,
                        cy: p.cy
                    }));
                    debugEl.textContent = JSON.stringify(debugData, null, 2);
                }

                document.getElementById('toggle-debug').addEventListener('click', function () {
                    const el = document.getElementById('scatter-debug');
                    if (!el) return;
                    el.classList.toggle('hidden');
                });

            }, 0);
        });
    </script>
    </x-mylayout>