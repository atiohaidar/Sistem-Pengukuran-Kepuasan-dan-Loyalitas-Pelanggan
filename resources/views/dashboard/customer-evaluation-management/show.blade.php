<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail UMKM - ') . $umkm->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Back Button -->
            <div class="mb-6">
                <a href="{{ route('dashboard.customer-evaluation-management.index') }}"
                    class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Kembali ke Daftar UMKM
                </a>
            </div>

            <!-- UMKM Information -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="px-6 py-4 bg-gray-100 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Informasi UMKM</h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <dl class="space-y-3">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">ID UMKM</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $umkm->id }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Token CRM</dt>
                                    <dd class="mt-1 text-sm text-gray-900">
                                        <code
                                            class="px-2 py-1 bg-gray-100 rounded text-xs">{{ $umkm->crm_token }}</code>
                                    </dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Nama UMKM</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $umkm->name }}</dd>
                                </div>
                            </dl>
                        </div>
                        <div>
                            <dl class="space-y-3">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Total Respondents (completed)</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $totalRespondents }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Total Records (all submissions)</dt>
                                    <dd class="mt-1 text-sm text-gray-900">
                                        {{ $aggregatedData['total_evaluations'] ?? 'N/A' }}
                                    </dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Evaluasi Lengkap</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $completedEvaluations }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Dibuat</dt>
                                    <dd class="mt-1 text-sm text-gray-900">
                                        {{ $umkm->created_at->format('d/m/Y H:i:s') }}
                                    </dd>
                                </div>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Readiness Audit with Scatter Chart -->
            @if($totalRespondents > 0 && isset($results['persepsiData']) && count($results['persepsiData']) > 0)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                    <div class="px-6 py-4 bg-white border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Readiness Audit - Harapan vs Persepsi Analysis</h3>
                        <p class="text-sm text-gray-600 mt-1">Scatter plot menunjukkan hubungan antara tingkat harapan dan
                            persepsi pelanggan terhadap berbagai aspek CRM</p>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                            <div>
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Aspek CRM</th>
                                            <th
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Rata-rata Harapan</th>
                                            <th
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Rata-rata Persepsi</th>
                                            <th
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Jumlah Response</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach($results['persepsiData'] as $item)
                                            <tr>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                    {{ $item['label'] }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    {{ number_format($item['harapan'], 1) }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    {{ number_format($item['persepsi'], 1) }}%
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    {{ $item['count'] }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div>
                                <h4 class="text-lg font-medium text-gray-900 mb-4">Scatter Plot Analysis</h4>
                                <div class="bg-gray-50 p-4 rounded-lg border">
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
                </div>

                <!-- Persepsi Assessment -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                    <div class="px-6 py-4 bg-white border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Persepsi Assessment - Overall Performance</h3>
                    </div>
                    <div class="p-6">
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
                                                Performansi Rata-rata</th>
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
                                    <h4 class="text-lg font-medium text-gray-900 mb-2">Nilai Sistem Pengelolaan Pelanggan
                                    </h4>
                                    <div class="text-6xl font-bold text-indigo-600">{{ $results['overallScore'] }}</div>
                                    <p class="text-sm text-gray-600 mt-2">dari 100 poin maksimal</p>
                                </div>
                            </div>
                        </div>
                        <div class="mt-6 border-t border-gray-200 pt-6">
                            <h4 class="text-lg font-medium text-gray-900 mb-2">Rekomendasi</h4>
                            <p class="text-sm text-gray-600 whitespace-pre-wrap">{{ $results['recommendation'] }}</p>
                        </div>
                    </div>
                </div>
            @endif

            @if($totalRespondents == 0)
                <div class="bg-yellow-50 border border-yellow-200 rounded-md p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-yellow-800">Belum ada data evaluasi</h3>
                            <div class="mt-2 text-sm text-yellow-700">
                                <p>UMKM ini belum memiliki respondents yang mengisi evaluasi CRM. Bagikan link survey
                                    berikut kepada stakeholders UMKM:</p>
                                <p class="mt-2 font-mono text-xs bg-yellow-100 p-2 rounded">
                                    {{ url('/crm/survey/' . $umkm->crm_token) }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            <!-- Maturity Assessment -->
            @if($totalRespondents > 0)
                <div class="bg-gray-50 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                    <div class="px-6 py-4 bg-gray-100 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Asesmen Maturitas (Rata-rata dari
                            {{ $totalRespondents }} Respondents)
                        </h3>
                    </div>
                    <div class="p-6">
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Komponen</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Rata-rata Nilai</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Jumlah Response</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Deskripsi</th>
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
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                {{ $label }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                @if(isset($aggregatedData['maturity'][$key]['average']))
                                                    <span
                                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                        {{ number_format($aggregatedData['maturity'][$key]['average'], 1) }}/5
                                                    </span>
                                                @else
                                                    <span class="text-gray-400">-</span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $aggregatedData['maturity'][$key]['count'] ?? 0 }}
                                            </td>
                                            <td class="px-6 py-4 text-sm text-gray-500">
                                                @php
                                                    $maturityDescriptions = [
                                                        1 => 'Tidak ada atau sangat terbatas',
                                                        2 => 'Ada inisiatif awal namun belum terintegrasi',
                                                        3 => 'Sudah diterapkan di beberapa area',
                                                        4 => 'Sudah terintegrasi di seluruh organisasi',
                                                        5 => 'Sangat matang dan menjadi keunggulan kompetitif'
                                                    ];
                                                    $roundedValue = isset($aggregatedData['maturity'][$key]['average']) ? round($aggregatedData['maturity'][$key]['average']) : null;
                                                @endphp
                                                {{ $maturityDescriptions[$roundedValue] ?? '-' }}
                                            </td>
                                        </tr>
                                    @endforeach
                                    <tr class="bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900">Rata-rata
                                            Keseluruhan</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900">
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                {{ number_format($aggregatedData['maturityAverage'], 1) }}/5
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900">
                                            {{ $totalRespondents }}
                                        </td>
                                        <td class="px-6 py-4 text-sm font-bold text-gray-900">
                                            @php
                                                $overallRounded = round($aggregatedData['maturityAverage']);
                                            @endphp
                                            {{ $maturityDescriptions[$overallRounded] ?? '-' }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Priority Assessment -->
            @if($totalRespondents > 0)
                <div class="bg-gray-50 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                    <div class="px-6 py-4 bg-gray-100 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Prioritas Implementasi (Rata-rata dari
                            {{ $totalRespondents }} Respondents)
                        </h3>
                    </div>
                    <div class="p-6">
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Area Fokus</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Rata-rata Prioritas (%)</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Jumlah Response</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Tingkat Prioritas</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @php
                                        $priorityLabels = app(\App\Services\SurveyQuestionService::class)->getPriorityItems();
                                    @endphp
                                    @foreach($priorityLabels as $key => $label)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                {{ $label['label'] }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                @if(isset($aggregatedData['priority'][$key]['average']))
                                                    <span
                                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                                        {{ number_format($aggregatedData['priority'][$key]['average'], 1) }}%
                                                    </span>
                                                @else
                                                    <span class="text-gray-400">-</span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $aggregatedData['priority'][$key]['count'] ?? 0 }}
                                            </td>
                                            <td class="px-6 py-4 text-sm text-gray-500">
                                                @php
                                                    $priorityValue = isset($aggregatedData['priority'][$key]['average']) ? $aggregatedData['priority'][$key]['average'] : 0;
                                                    if ($priorityValue >= 80) {
                                                        $priorityLevel = 'Sangat Tinggi';
                                                        $priorityColor = 'text-red-600';
                                                    } elseif ($priorityValue >= 60) {
                                                        $priorityLevel = 'Tinggi';
                                                        $priorityColor = 'text-orange-600';
                                                    } elseif ($priorityValue >= 40) {
                                                        $priorityLevel = 'Sedang';
                                                        $priorityColor = 'text-yellow-600';
                                                    } elseif ($priorityValue >= 20) {
                                                        $priorityLevel = 'Rendah';
                                                        $priorityColor = 'text-green-600';
                                                    } else {
                                                        $priorityLevel = 'Sangat Rendah';
                                                        $priorityColor = 'text-blue-600';
                                                    }
                                                @endphp
                                                <span class="{{ $priorityColor }} font-medium">{{ $priorityLevel }}</span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Readiness Assessment -->
            @if($totalRespondents > 0)
                <div class="bg-gray-50 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                    <div class="px-6 py-4 bg-gray-100 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Tingkat Kesiapan Organisasi (Rata-rata dari
                            {{ $totalRespondents }} Respondents)
                        </h3>
                    </div>
                    <div class="p-6">
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Aspek Kesiapan</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Rata-rata Nilai</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Jumlah Response</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Tingkat Kesiapan</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @php
                                        $readinessLabels = app(\App\Services\SurveyQuestionService::class)->getReadinessQuestions();
                                    @endphp
                                    @foreach($readinessLabels as $key => $question)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                {{ $question['label'] }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                @if(isset($aggregatedData['readiness'][$key]['average']))
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                                                                @if(round($aggregatedData['readiness'][$key]['average']) == 1) bg-red-100 text-red-800
                                                                                @elseif(round($aggregatedData['readiness'][$key]['average']) == 2) bg-orange-100 text-orange-800
                                                                                @elseif(round($aggregatedData['readiness'][$key]['average']) == 3) bg-yellow-100 text-yellow-800
                                                                                @elseif(round($aggregatedData['readiness'][$key]['average']) == 4) bg-green-100 text-green-800
                                                                                @elseif(round($aggregatedData['readiness'][$key]['average']) == 5) bg-blue-100 text-blue-800
                                                                                @endif">
                                                        {{ number_format($aggregatedData['readiness'][$key]['average'], 1) }}/5
                                                    </span>
                                                @else
                                                    <span class="text-gray-400">-</span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $aggregatedData['readiness'][$key]['count'] ?? 0 }}
                                            </td>
                                            <td class="px-6 py-4 text-sm text-gray-500">
                                                @php
                                                    $readinessDescriptions = [
                                                        1 => 'Sangat tidak siap - Perlu banyak persiapan',
                                                        2 => 'Tidak siap - Perlu persiapan signifikan',
                                                        3 => 'Cukup siap - Perlu beberapa persiapan',
                                                        4 => 'Siap - Hanya perlu sedikit penyesuaian',
                                                        5 => 'Sangat siap - Siap untuk implementasi'
                                                    ];
                                                    $roundedValue = isset($aggregatedData['readiness'][$key]['average']) ? round($aggregatedData['readiness'][$key]['average']) : null;
                                                @endphp
                                                {{ $readinessDescriptions[$roundedValue] ?? '-' }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endif


        </div>
    </div>

    <!-- Scatter Chart Script -->
    @if($totalRespondents > 0 && isset($results['persepsiData']) && count($results['persepsiData']) > 0)
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
                    .on('mouseover', function (event, d, i) { showTooltip(event, { index: i }); })
                    .on('mousemove', function (event, d, i) { showTooltip(event, { index: i }); })
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
                texts.on('mouseover', function (event, d) { showTooltip(event, d); })
                    .on('mousemove', function (event, d) { showTooltip(event, d); })
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
    @endif
</x-app-layout>