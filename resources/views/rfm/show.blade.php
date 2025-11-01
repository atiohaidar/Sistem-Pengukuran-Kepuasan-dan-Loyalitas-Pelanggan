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

            <!-- Threshold Filter -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="px-6 py-4 bg-gray-100 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Filter Threshold RFM</h3>
                </div>
                <div class="p-6">
                    <form method="GET" action="{{ route('rfm.show', $umkmId) }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div>
                            <label for="recency" class="block text-sm font-medium text-gray-700">Recency (hari)</label>
                            <input type="number" name="recency" id="recency" value="{{ $thresholds['recency'] }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <div>
                            <label for="frequency" class="block text-sm font-medium text-gray-700">Frequency (transaksi)</label>
                            <input type="number" name="frequency" id="frequency" value="{{ $thresholds['frequency'] }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <div>
                            <label for="monetary" class="block text-sm font-medium text-gray-700">Monetary (Rp)</label>
                            <input type="number" name="monetary" id="monetary" value="{{ $thresholds['monetary'] }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <div class="flex items-end">
                            <button type="submit" class="px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Terapkan Filter
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Summary Cards: Omzet -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="px-6 py-4 bg-gray-100 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Omzet (30 hari)</h3>
                    </div>
                    <div class="p-6">
                        <div class="text-3xl font-bold text-gray-900">Rp {{ number_format($overview['omzet'] ?? 0, 0) }}</div>
                        <p class="text-sm text-gray-500 mt-1">Total nilai transaksi periode frekuensi</p>
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
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kategori</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Student</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Regular</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Pelanggan</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Pelanggan Baru</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $overview['active']['student']['baru'] ?? 0 }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $overview['active']['regular']['baru'] ?? 0 }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $overview['active']['total']['baru'] ?? 0 }}</td>
                            </tr>
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Pelanggan Lama</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $overview['active']['student']['lama'] ?? 0 }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $overview['active']['regular']['lama'] ?? 0 }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $overview['active']['total']['lama'] ?? 0 }}</td>
                            </tr>
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Total Pelanggan Aktif</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $overview['active']['student']['total'] ?? 0 }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $overview['active']['regular']['total'] ?? 0 }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $overview['active']['total']['total'] ?? 0 }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Customers per Cluster Table -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="px-6 py-4 bg-gray-100 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Pelanggan per Klaster</h3>
                </div>
                <div class="p-6 overflow-x-auto">
                    @php
                        $clusterOrder = ['Worst Idle','Klaster Average Casual','Klaster Good Active','Klaster Best Elite','Uncategorized'];
                    @endphp
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Klaster</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Student</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Regular</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($clusterOrder as $cluster)
                                @php $row = $overview['clusterCounts'][$cluster] ?? ['student'=>0,'regular'=>0,'total'=>0]; @endphp
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $cluster }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $row['student'] }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $row['regular'] }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $row['total'] }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
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
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Custom ID</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Recency</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Frequency</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Monetary</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cluster</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($rfmResults as $result)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $result['customer']->nama_lengkap }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $result['customer']->custom_id }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ number_format($result['recency'], 2) }} hari</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $result['frequency'] }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Rp {{ number_format($result['monetary'], 0) }}</td>
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

            <!-- Cluster Statistics -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="px-6 py-4 bg-gray-100 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Statistik per Klaster</h3>
                </div>
                <div class="p-6">
                    @foreach($clusterStats as $cluster => $stats)
                    <div class="mb-6">
                        <h4 class="text-md font-medium text-gray-900 mb-4">{{ $cluster }} ({{ $stats['count'] }} pelanggan)</h4>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <h5 class="text-sm font-medium text-gray-500">Recency</h5>
                                <p class="text-lg font-semibold text-gray-900">Mean: {{ number_format($stats['recency']['mean'], 2) }}</p>
                                <p class="text-sm text-gray-600">Median: {{ number_format($stats['recency']['median'], 2) }}, Mode: {{ number_format($stats['recency']['mode'], 2) }}</p>
                                <p class="text-sm text-gray-600">Min: {{ number_format($stats['recency']['min'], 2) }}, Max: {{ number_format($stats['recency']['max'], 2) }}</p>
                            </div>
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <h5 class="text-sm font-medium text-gray-500">Frequency</h5>
                                <p class="text-lg font-semibold text-gray-900">Mean: {{ number_format($stats['frequency']['mean'], 2) }}</p>
                                <p class="text-sm text-gray-600">Median: {{ number_format($stats['frequency']['median'], 2) }}, Mode: {{ number_format($stats['frequency']['mode'], 2) }}</p>
                                <p class="text-sm text-gray-600">Min: {{ number_format($stats['frequency']['min'], 2) }}, Max: {{ number_format($stats['frequency']['max'], 2) }}</p>
                            </div>
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <h5 class="text-sm font-medium text-gray-500">Monetary</h5>
                                <p class="text-lg font-semibold text-gray-900">Mean: Rp {{ number_format($stats['monetary']['mean'], 0) }}</p>
                                <p class="text-sm text-gray-600">Median: Rp {{ number_format($stats['monetary']['median'], 0) }}, Mode: Rp {{ number_format($stats['monetary']['mode'], 0) }}</p>
                                <p class="text-sm text-gray-600">Min: Rp {{ number_format($stats['monetary']['min'], 0) }}, Max: Rp {{ number_format($stats['monetary']['max'], 0) }}</p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>