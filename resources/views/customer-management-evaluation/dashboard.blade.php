<x-guest-layout>
<div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 py-12 px-4 sm:px-6 lg:px-8">
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
                            @foreach($results['persepsiData'] as $item)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $item['label'] }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $item['harapan'] }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ number_format($item['persepsi'], 0) }}%</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div>
                    <h4 class="text-lg font-medium text-gray-900 mb-4">Harapan - Persepsi Analysis</h4>
                    <div class="bg-white p-4 rounded-lg border">
                        <svg width="450" height="300" viewBox="0 0 450 300" class="w-full h-auto">
                            @php
                                $width = 450;
                                $height = 300;
                                $padding = 40;
                                $xMax = 25;
                                $yMax = 100;
                                $xMid = 12.5;
                                $yMid = 70;

                                $scaleX = function($val) use ($width, $padding, $xMax) {
                                    return ($val / $xMax) * ($width - $padding * 2) + $padding;
                                };

                                $scaleY = function($val) use ($height, $padding, $yMax) {
                                    return $height - $padding - ($val / $yMax) * ($height - $padding * 2);
                                };

                                $xTicks = [0, 5, 10, 15, 20, 25];
                                $yTicks = [0, 20, 40, 60, 80, 100];
                            @endphp

                            <!-- Grid lines -->
                            @foreach($xTicks as $tick)
                                <line x1="{{ $scaleX($tick) }}" y1="{{ $padding }}" x2="{{ $scaleX($tick) }}" y2="{{ $height - $padding }}" stroke="#e5e7eb" stroke-width="1"/>
                            @endforeach
                            @foreach($yTicks as $tick)
                                <line x1="{{ $padding }}" y1="{{ $scaleY($tick) }}" x2="{{ $width - $padding }}" y2="{{ $scaleY($tick) }}" stroke="#e5e7eb" stroke-width="1"/>
                            @endforeach

                            <!-- Quadrants -->
                            <rect x="{{ $padding }}" y="{{ $padding }}" width="{{ $scaleX($xMid) - $padding }}" height="{{ $scaleY($yMid) - $padding }}" fill="#fef3c7" opacity="0.3"/>
                            <rect x="{{ $scaleX($xMid) }}" y="{{ $padding }}" width="{{ $width - $padding - $scaleX($xMid) }}" height="{{ $scaleY($yMid) - $padding }}" fill="#d1fae5" opacity="0.3"/>
                            <rect x="{{ $padding }}" y="{{ $scaleY($yMid) }}" width="{{ $scaleX($xMid) - $padding }}" height="{{ $height - $padding - $scaleY($yMid) }}" fill="#fee2e2" opacity="0.3"/>
                            <rect x="{{ $scaleX($xMid) }}" y="{{ $scaleY($yMid) }}" width="{{ $width - $padding - $scaleX($xMid) }}" height="{{ $height - $padding - $scaleY($yMid) }}" fill="#d1fae5" opacity="0.3"/>

                            <!-- Quadrant labels -->
                            <text x="{{ $padding + 10 }}" y="{{ $padding + 20 }}" font-size="12" fill="#92400e">Low Priority</text>
                            <text x="{{ $width - $padding - 60 }}" y="{{ $padding + 20 }}" font-size="12" fill="#166534">Keep Up</text>
                            <text x="{{ $padding + 10 }}" y="{{ $height - $padding - 10 }}" font-size="12" fill="#dc2626">Low Priority</text>
                            <text x="{{ $width - $padding - 60 }}" y="{{ $height - $padding - 10 }}" font-size="12" fill="#166534">High Priority</text>

                            <!-- X and Y axis -->
                            <line x1="{{ $padding }}" y1="{{ $height - $padding }}" x2="{{ $width - $padding }}" y2="{{ $height - $padding }}" stroke="#374151" stroke-width="2"/>
                            <line x1="{{ $padding }}" y1="{{ $padding }}" x2="{{ $padding }}" y2="{{ $height - $padding }}" stroke="#374151" stroke-width="2"/>

                            <!-- X axis ticks and labels -->
                            @foreach($xTicks as $tick)
                                <line x1="{{ $scaleX($tick) }}" y1="{{ $height - $padding }}" x2="{{ $scaleX($tick) }}" y2="{{ $height - $padding + 5 }}" stroke="#374151" stroke-width="1"/>
                                <text x="{{ $scaleX($tick) }}" y="{{ $height - $padding + 20 }}" text-anchor="middle" font-size="10" fill="#6b7280">{{ $tick }}</text>
                            @endforeach

                            <!-- Y axis ticks and labels -->
                            @foreach($yTicks as $tick)
                                <line x1="{{ $padding }}" y1="{{ $scaleY($tick) }}" x2="{{ $padding - 5 }}" y2="{{ $scaleY($tick) }}" stroke="#374151" stroke-width="1"/>
                                <text x="{{ $padding - 10 }}" y="{{ $scaleY($tick) + 4 }}" text-anchor="end" font-size="10" fill="#6b7280">{{ $tick }}</text>
                            @endforeach

                            <!-- Axis labels -->
                            <text x="{{ $width / 2 }}" y="{{ $height - 10 }}" text-anchor="middle" font-size="12" fill="#374151">Harapan</text>
                            <text x="15" y="{{ $height / 2 }}" text-anchor="middle" transform="rotate(-90 15 {{ $height / 2 }})" font-size="12" fill="#374151">Persepsi (%)</text>

                            <!-- Data points -->
                            @foreach($results['persepsiData'] as $index => $item)
                                @php
                                    $harapan = $item['harapan'] * 5; // Scale 1-5 to 5-25
                                    $persepsi = $item['persepsi'];
                                    $x = $scaleX($harapan);
                                    $y = $scaleY($persepsi);
                                    $colors = ['#ef4444', '#f97316', '#eab308', '#22c55e', '#3b82f6', '#8b5cf6', '#ec4899', '#6b7280', '#374151', '#f59e0b', '#10b981'];
                                    $color = $colors[$index % count($colors)];
                                    // Use 4 directions to avoid overlap: right-top, left-top, right-bottom, left-bottom
                                    $directions = [
                                        ['x' => 25, 'y' => -10], // right-top
                                        ['x' => -90, 'y' => -10], // left-top
                                        ['x' => 25, 'y' => 20], // right-bottom
                                        ['x' => -90, 'y' => 20], // left-bottom
                                    ];
                                    $dir = $directions[$index % 4];
                                    $offsetX = $dir['x'];
                                    $offsetY = $dir['y'];
                                    $labelX = $x + $offsetX;
                                    $labelY = $y + $offsetY;
                                @endphp
                                <circle cx="{{ $x }}" cy="{{ $y }}" r="6" fill="{{ $color }}" stroke="#ffffff" stroke-width="2"/>
                                <line x1="{{ $x }}" y1="{{ $y }}" x2="{{ $labelX }}" y2="{{ $labelY }}" stroke="{{ $color }}" stroke-width="1"/>
                                <text x="{{ $labelX }}" y="{{ $labelY }}" font-size="10" fill="#374151" stroke="#ffffff" stroke-width="3" paint-order="stroke fill">{{ substr($item['label'], 0, 15) }}</text>
                            @endforeach
                        </svg>
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
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Proses Sistem Pengelolaan Pelanggan</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Performansi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($results['processGroupResults'] as $group)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $group['name'] }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $group['persepsi'] }}%</td>
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
</x-mylayout>