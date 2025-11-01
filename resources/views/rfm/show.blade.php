<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('RFM Analysis - UMKM ') . $umkmId }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Back Button -->
            <div class="mb-6">
                <a href="{{ route('crm.dashboard') }}"
                    class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Kembali ke Dashboard
                </a>
                <a href="{{ route('rfm.create', $umkmId) }}"
                    class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150 ml-4">
                    Tambah Data Manual
                </a>
            </div>

            <!-- Filters: Threshold + Date Range -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="px-6 py-4 bg-gray-100 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Filter Threshold RFM & Periode</h3>
                </div>
                <div class="p-6">
                    <form method="GET" action="{{ route('rfm.show', $umkmId) }}"
                        class="grid grid-cols-1 md:grid-cols-6 gap-4">
                        <div>
                            <label for="recency" class="block text-sm font-medium text-gray-700">Recency (hari)</label>
                            <input type="number" name="recency" id="recency" value="{{ $thresholds['recency'] }}"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <div>
                            <label for="frequency" class="block text-sm font-medium text-gray-700">Frequency
                                (transaksi)</label>
                            <input type="number" name="frequency" id="frequency" value="{{ $thresholds['frequency'] }}"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <div>
                            <label for="monetary" class="block text-sm font-medium text-gray-700">Monetary (Rp)</label>
                            <input type="number" name="monetary" id="monetary" value="{{ $thresholds['monetary'] }}"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <div>
                            <label for="start_date" class="block text-sm font-medium text-gray-700">Mulai</label>
                            <input type="date" name="start_date" id="start_date"
                                value="{{ $filters['start_date'] ?? '' }}"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <div>
                            <label for="end_date" class="block text-sm font-medium text-gray-700">Sampai</label>
                            <input type="date" name="end_date" id="end_date" value="{{ $filters['end_date'] ?? '' }}"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <div class="flex items-end">
                            <button type="submit"
                                class="px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Terapkan Filter
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Summary Cards: Omzet & Churn Rate -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="px-6 py-4 bg-gray-100 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Omzet ({{ $filters['start_date'] }} s/d
                            {{ $filters['end_date'] }})</h3>
                    </div>
                    <div class="p-6">
                        <p class="text-3xl font-bold text-gray-900">Rp {{ number_format($overview['omzet'] ?? 0, 0) }}
                        </p>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="px-6 py-4 bg-gray-100 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Churn Rate</h3>
                    </div>
                    <div class="p-6">
                        @php
                            $rate = $overview['churn']['rate'] ?? null;
                        @endphp
                        <p class="text-3xl font-bold {{ is_null($rate) ? 'text-gray-500' : 'text-red-600' }}">
                            {{ is_null($rate) ? 'N/A' : number_format($rate * 100, 2) . '%' }}
                        </p>
                        <p class="text-sm text-gray-600 mt-2">Prev Active: {{ $overview['churn']['prev_active'] ?? 0 }},
                            Current Active: {{ $overview['churn']['current_active'] ?? 0 }}, Churners:
                            {{ $overview['churn']['churners'] ?? 0 }}</p>
                    </div>
                </div>
            </div>

        

            

            <!-- Active Customers Table -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="px-6 py-4 bg-gray-100 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Jumlah Pelanggan Aktif</h3>
                </div>
                <div class="p-6 overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Kategori</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Student</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Regular</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Total Pelanggan</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Pelanggan Baru
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $overview['active']['student']['baru'] ?? 0 }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $overview['active']['regular']['baru'] ?? 0 }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $overview['active']['total']['baru'] ?? 0 }}</td>
                            </tr>
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Pelanggan Lama
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $overview['active']['student']['lama'] ?? 0 }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $overview['active']['regular']['lama'] ?? 0 }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $overview['active']['total']['lama'] ?? 0 }}</td>
                            </tr>
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Total
                                    Pelanggan Aktif</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $overview['active']['student']['total'] ?? 0 }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $overview['active']['regular']['total'] ?? 0 }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $overview['active']['total']['total'] ?? 0 }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Active Customers Chart -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
            <div class="px-6 py-4 bg-gray-100 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Jumlah Pelanggan Aktif</h3>
                    </div>
                    <div class="p-6">
                        <div id="activeChart" class="w-full h-64"></div>
                    </div>
            </div>

            <!-- Customers per Cluster Table -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="px-6 py-4 bg-gray-100 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Pelanggan per Klaster</h3>
                </div>
                <div class="p-6 overflow-x-auto">
                    @php
                        $clusterOrder = ['Worst Idle', 'Klaster Average Casual', 'Klaster Good Active', 'Klaster Best Elite', 'Uncategorized'];
                    @endphp
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Klaster</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Student</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Regular</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Total</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($clusterOrder as $cluster)
                                @php $row = $overview['clusterCounts'][$cluster] ?? ['student' => 0, 'regular' => 0, 'total' => 0]; @endphp
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $cluster }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $row['student'] }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $row['regular'] }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $row['total'] }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Customers per Cluster Chart -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
               <div class="px-6 py-4 bg-gray-100 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Pelanggan per Klaster</h3>
                    </div>
                    <div class="p-6">
                        <div id="clusterChart" class="w-full h-64"></div>
                    </div>
            </div>

            <!-- RFM Results Table -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="px-6 py-4 bg-gray-100 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Hasil Analisis RFM</h3>
                </div>
                <div class="p-6">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Customer</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Custom ID</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Recency</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Frequency</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Monetary</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Cluster</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($rfmResults as $result)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            {{ $result['customer']->nama_lengkap }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $result['customer']->custom_id }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ number_format($result['recency'], 2) }} hari</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $result['frequency'] }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Rp
                                            {{ number_format($result['monetary'], 0) }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                @if($result['cluster'] == 'Klaster Best Elite') bg-green-100 text-green-800
                                                @elseif($result['cluster'] == 'Klaster Good Active') bg-blue-100 text-blue-800
                                                @elseif($result['cluster'] == 'Uncategorized') bg-yellow-100 text-yellow-800
                                                @elseif($result['cluster'] == 'Worst Idle') bg-red-100 text-red-800
                                                @else bg-gray-100 text-gray-800 @endif">
                                                {{ $result['cluster'] }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Active Customers Breakdown & Cluster Statistics -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="px-6 py-4 bg-gray-100 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Pelanggan Aktif (per jenis)</h3>
                </div>
                <div class="p-6 overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Jenis</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Baru</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Lama</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Total</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach(['student', 'regular', 'total'] as $jenis)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        {{ ucfirst($jenis) }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $overview['active'][$jenis]['baru'] ?? 0 }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $overview['active'][$jenis]['lama'] ?? 0 }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $overview['active'][$jenis]['total'] ?? 0 }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="px-6 py-4 bg-gray-100 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Statistik per Klaster</h3>
                </div>
                <div class="p-6">
                    <!-- Cluster counts table -->
                    <div class="overflow-x-auto mb-6">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Klaster</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Student</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Regular</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Total</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach(($overview['clusterCounts'] ?? []) as $cluster => $counts)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            {{ $cluster }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $counts['student'] ?? 0 }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $counts['regular'] ?? 0 }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $counts['total'] ?? 0 }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @foreach($clusterStats as $cluster => $stats)
                        <div class="mb-6">
                            <h4 class="text-md font-medium text-gray-900 mb-4">{{ $cluster }} ({{ $stats['count'] }}
                                pelanggan)</h4>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div class="bg-gray-50 p-4 rounded-lg">
                                    <h5 class="text-sm font-medium text-gray-500">Recency</h5>
                                    <p class="text-lg font-semibold text-gray-900">Mean:
                                        {{ number_format($stats['recency']['mean'], 2) }}</p>
                                    <p class="text-sm text-gray-600">Median:
                                        {{ number_format($stats['recency']['median'], 2) }}, Mode:
                                        {{ number_format($stats['recency']['mode'], 2) }}</p>
                                    <p class="text-sm text-gray-600">Min: {{ number_format($stats['recency']['min'], 2) }},
                                        Max: {{ number_format($stats['recency']['max'], 2) }}</p>
                                </div>
                                <div class="bg-gray-50 p-4 rounded-lg">
                                    <h5 class="text-sm font-medium text-gray-500">Frequency</h5>
                                    <p class="text-lg font-semibold text-gray-900">Mean:
                                        {{ number_format($stats['frequency']['mean'], 2) }}</p>
                                    <p class="text-sm text-gray-600">Median:
                                        {{ number_format($stats['frequency']['median'], 2) }}, Mode:
                                        {{ number_format($stats['frequency']['mode'], 2) }}</p>
                                    <p class="text-sm text-gray-600">Min:
                                        {{ number_format($stats['frequency']['min'], 2) }}, Max:
                                        {{ number_format($stats['frequency']['max'], 2) }}</p>
                                </div>
                                <div class="bg-gray-50 p-4 rounded-lg">
                                    <h5 class="text-sm font-medium text-gray-500">Monetary</h5>
                                    <p class="text-lg font-semibold text-gray-900">Mean: Rp
                                        {{ number_format($stats['monetary']['mean'], 0) }}</p>
                                    <p class="text-sm text-gray-600">Median: Rp
                                        {{ number_format($stats['monetary']['median'], 0) }}, Mode: Rp
                                        {{ number_format($stats['monetary']['mode'], 0) }}</p>
                                    <p class="text-sm text-gray-600">Min: Rp
                                        {{ number_format($stats['monetary']['min'], 0) }}, Max: Rp
                                        {{ number_format($stats['monetary']['max'], 0) }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<!-- D3 Charts -->
<script src="https://cdn.jsdelivr.net/npm/d3@7"></script>
<script>
    (function() {
        const overview = @json($overview ?? []);

        // Prepare Active Customers data (Student vs Regular) across Baru/Lama/Total
        const active = overview.active || { student: { baru:0, lama:0, total:0 }, regular: { baru:0, lama:0, total:0 } };
        const activeData = [
            { label: 'Pelanggan Baru', student: active.student.baru || 0, regular: active.regular.baru || 0 },
            { label: 'Pelanggan Lama', student: active.student.lama || 0, regular: active.regular.lama || 0 },
            { label: 'Total Pelanggan', student: active.student.total || 0, regular: active.regular.total || 0 },
        ];

        // Prepare Cluster data (Student vs Regular) across ordered clusters
        const clusterCounts = overview.clusterCounts || {};
        const orderedClusters = ['Worst Idle', 'Klaster Average Casual', 'Klaster Good Active', 'Klaster Best Elite', 'Uncategorized'];
        const clusterData = orderedClusters.map(c => ({
            label: c,
            student: (clusterCounts[c]?.student) || 0,
            regular: (clusterCounts[c]?.regular) || 0,
        }));

        function renderGroupedBar(containerId, data, seriesKeys, colors) {
            const container = document.getElementById(containerId);
            if (!container) return;
            // Clear previous
            container.innerHTML = '';

            const width = container.clientWidth || 600;
            const height = container.clientHeight || 300;
            const margin = { top: 10, right: 20, bottom: 40, left: 40 };
            const innerW = width - margin.left - margin.right;
            const innerH = height - margin.top - margin.bottom;

            const svg = d3.select(container)
                .append('svg')
                .attr('width', width)
                .attr('height', height);

            const g = svg.append('g')
                .attr('transform', `translate(${margin.left},${margin.top})`);

            const x0 = d3.scaleBand()
                .domain(data.map(d => d.label))
                .rangeRound([0, innerW])
                .paddingInner(0.2);

            const x1 = d3.scaleBand()
                .domain(seriesKeys)
                .rangeRound([0, x0.bandwidth()])
                .padding(0.1);

            const maxY = d3.max(data, d => d3.max(seriesKeys, key => d[key] || 0)) || 0;
            const y = d3.scaleLinear()
                .domain([0, Math.max(maxY, 1)])
                .nice()
                .range([innerH, 0]);

            const color = d3.scaleOrdinal()
                .domain(seriesKeys)
                .range(colors);

            // Axes
            g.append('g')
                .attr('class', 'x-axis')
                .attr('transform', `translate(0,${innerH})`)
                .call(d3.axisBottom(x0));

            g.append('g')
                .attr('class', 'y-axis')
                .call(d3.axisLeft(y).ticks(5));

            // Bars
            const groups = g.selectAll('g.series')
                .data(data)
                .enter()
                .append('g')
                .attr('transform', d => `translate(${x0(d.label)},0)`);

            groups.selectAll('rect')
                .data(d => seriesKeys.map(key => ({ key, value: d[key] || 0 })))
                .enter()
                .append('rect')
                .attr('x', d => x1(d.key))
                .attr('y', d => y(d.value))
                .attr('width', x1.bandwidth())
                .attr('height', d => innerH - y(d.value))
                .attr('fill', d => color(d.key));

            // Legend
            const legend = svg.append('g')
                .attr('transform', `translate(${margin.left},${10})`);
            seriesKeys.forEach((k, i) => {
                const lg = legend.append('g').attr('transform', `translate(${i * 120},0)`);
                lg.append('rect').attr('width', 12).attr('height', 12).attr('fill', colors[i]);
                lg.append('text').attr('x', 16).attr('y', 10).attr('fill', '#374151').attr('font-size', 12).text(k.charAt(0).toUpperCase() + k.slice(1));
            });
        }

        // Initial render
        renderGroupedBar('activeChart', activeData, ['student','regular'], ['#2563eb', '#f59e0b']);
        renderGroupedBar('clusterChart', clusterData, ['student','regular'], ['#10b981', '#ef4444']);

        // Simple resize handler
        window.addEventListener('resize', () => {
            renderGroupedBar('activeChart', activeData, ['student','regular'], ['#2563eb', '#f59e0b']);
            renderGroupedBar('clusterChart', clusterData, ['student','regular'], ['#10b981', '#ef4444']);
        });
    })();
</script>

