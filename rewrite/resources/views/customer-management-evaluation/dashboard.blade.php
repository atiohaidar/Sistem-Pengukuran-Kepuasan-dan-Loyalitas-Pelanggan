@extends('layouts.guest')

@section('content')
<div class="min-h-screen bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-6xl mx-auto space-y-8">
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
                    <input id="share-link" type="text" readonly value="{{ url('/customer-management-evaluation/dashboard/' . $token) }}" class="block w-96 px-3 py-2 border border-gray-300 rounded-md shadow-sm bg-gray-50 text-sm" onclick="this.select()">
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
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Komponen</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nilai</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @php
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
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $label }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $data['maturity'][$key] ?? 0 }}</td>
                                </tr>
                            @endforeach
                            <tr class="bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900">Average</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900">{{ number_format($results['maturityAverage'], 2) }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div>
                    <h4 class="text-lg font-medium text-gray-900 mb-2">Insights Gained</h4>
                    <h5 class="text-md font-semibold text-indigo-600 mb-3">{{ $results['maturityInsightData']['title'] }}</h5>
                    <p class="text-sm text-gray-600 whitespace-pre-wrap">{{ $results['maturityInsightData']['description'] }}</p>
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
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Bobot Kepentingan</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Bobot</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Performansi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($results['performanceData'] as $item)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $item['label'] }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $item['importance'] }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ number_format($item['performance'], 0) }}%</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div>
                    <h4 class="text-lg font-medium text-gray-900 mb-4">Importance - Performance Analysis</h4>
                    <!-- Simple scatter plot placeholder -->
                    <div class="bg-gray-100 p-4 rounded-lg">
                        <p class="text-sm text-gray-600">Grafik IPA akan ditampilkan di sini. Untuk implementasi penuh, gunakan library seperti Chart.js.</p>
                        <!-- Placeholder for IPA graph -->
                        <div class="mt-4">
                            @foreach($results['performanceData'] as $item)
                                <div class="flex items-center mb-2">
                                    <span class="w-32 text-sm">{{ $item['label'] }}</span>
                                    <div class="flex-1 bg-gray-200 rounded-full h-2">
                                        <div class="bg-indigo-600 h-2 rounded-full" style="width: {{ $item['importance'] }}%"></div>
                                    </div>
                                    <span class="ml-2 text-sm">{{ $item['importance'] }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Performance Assessment -->
        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="text-2xl font-bold text-gray-900 mb-4">Performance Assessment</h3>
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div>
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Proses Sistem Pengelolaan Pelanggan</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Performansi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($results['processGroupResults'] as $group)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $group['name'] }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $group['performance'] }}%</td>
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
@endsection