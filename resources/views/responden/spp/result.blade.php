@extends('layouts.user')

@section('content')
@php
    $ipaConfig = $ipaChart['config'];
    $ipaPoints = $ipaChart['points'];
@endphp

<div class="spp-dashboard">
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="company-badge">{{ $companyInitial }}</div>
                    <div>
                        <h1 class="h3 mb-1">Dashboard Hasil Evaluasi</h1>
                        <h2 class="h5 text-muted mb-2">{{ $companyName }}</h2>
                        <p class="mb-0 small text-muted">Token Akses: <code>{{ $sessionToken }}</code></p>
                    </div>
                </div>
                <div class="d-flex gap-2 header-actions">
                    <a href="{{ route('spp.survey.index') }}" class="btn btn-primary">Mulai Asesmen Baru</a>
                    <button type="button" class="btn btn-outline-secondary" onclick="window.print()">
                        <i class="bi bi-printer"></i> Cetak
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <h3 class="card-title mb-4">Maturity Assessment</h3>
            <div class="card-grid">
                <div>
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Komponen</th>
                                <th>Nilai</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($maturityQuestions as $question)
                                <tr>
                                    <td>{{ $question['label'] }}</td>
                                    <td>{{ $question['value'] }}</td>
                                </tr>
                            @endforeach
                            <tr class="table-primary">
                                <td><strong>Rata-rata</strong></td>
                                <td><strong>{{ number_format($maturityAverage, 2) }}</strong></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="insight-panel">
                    <span class="badge bg-primary mb-2">Level {{ $roundedAverage }}</span>
                    <h4 class="h5">{{ $maturityInsight['title'] }}</h4>
                    <p>{!! nl2br(e($maturityInsight['description'])) !!}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <h3 class="card-title mb-4">Readiness Audit</h3>
            <div class="card-grid">
                <div>
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Bobot Kepentingan</th>
                                <th>Bobot</th>
                                <th>Performansi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($performanceData as $item)
                                <tr>
                                    <td>{{ $item['label'] }}</td>
                                    <td>{{ $item['importance'] }}</td>
                                    <td>{{ number_format($item['performance']) }}%</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div>
                <h4 class="h6 mb-3">Importance - Performance Analysis</h4>
                <svg viewBox="0 0 {{ $ipaConfig['width'] }} {{ $ipaConfig['height'] }}" class="ipa-chart">
                    @php
                        $scaleX = function ($value, $offset = 0) use ($ipaConfig) {
                            $clamped = max(0, min($ipaConfig['xMax'], $value));
                            $usableWidth = $ipaConfig['width'] - ($ipaConfig['padding'] * 2);
                            return $ipaConfig['padding'] + ($clamped / $ipaConfig['xMax']) * $usableWidth + $offset;
                        };

                        $scaleY = function ($value, $offset = 0) use ($ipaConfig) {
                            $clamped = max(0, min($ipaConfig['yMax'], $value));
                            $usableHeight = $ipaConfig['height'] - ($ipaConfig['padding'] * 2);
                            return $ipaConfig['height'] - $ipaConfig['padding'] - ($clamped / $ipaConfig['yMax']) * $usableHeight + $offset;
                        };
                    @endphp

                    <rect x="{{ $scaleX($ipaConfig['xMid']) }}" y="{{ $ipaConfig['padding'] }}" width="{{ $scaleX($ipaConfig['xMax']) - $scaleX($ipaConfig['xMid']) }}" height="{{ $scaleY($ipaConfig['yMid']) - $ipaConfig['padding'] }}" class="quad quad-high" />
                    <rect x="{{ $ipaConfig['padding'] }}" y="{{ $ipaConfig['padding'] }}" width="{{ $scaleX($ipaConfig['xMid']) - $ipaConfig['padding'] }}" height="{{ $scaleY($ipaConfig['yMid']) - $ipaConfig['padding'] }}" class="quad quad-keep" />
                    <rect x="{{ $ipaConfig['padding'] }}" y="{{ $scaleY($ipaConfig['yMid']) }}" width="{{ $scaleX($ipaConfig['xMid']) - $ipaConfig['padding'] }}" height="{{ $scaleY(0) - $scaleY($ipaConfig['yMid']) }}" class="quad quad-low" />
                    <rect x="{{ $scaleX($ipaConfig['xMid']) }}" y="{{ $scaleY($ipaConfig['yMid']) }}" width="{{ $scaleX($ipaConfig['xMax']) - $scaleX($ipaConfig['xMid']) }}" height="{{ $scaleY(0) - $scaleY($ipaConfig['yMid']) }}" class="quad quad-watch" />

                    <line x1="{{ $scaleX($ipaConfig['xMid']) }}" y1="{{ $ipaConfig['padding'] }}" x2="{{ $scaleX($ipaConfig['xMid']) }}" y2="{{ $ipaConfig['height'] - $ipaConfig['padding'] }}" class="grid-line" />
                    <line x1="{{ $ipaConfig['padding'] }}" y1="{{ $scaleY($ipaConfig['yMid']) }}" x2="{{ $ipaConfig['width'] - $ipaConfig['padding'] }}" y2="{{ $scaleY($ipaConfig['yMid']) }}" class="grid-line" />

                    <line x1="{{ $ipaConfig['padding'] }}" y1="{{ $ipaConfig['height'] - $ipaConfig['padding'] }}" x2="{{ $ipaConfig['width'] - $ipaConfig['padding'] }}" y2="{{ $ipaConfig['height'] - $ipaConfig['padding'] }}" class="axis" />
                    <line x1="{{ $ipaConfig['padding'] }}" y1="{{ $ipaConfig['padding'] }}" x2="{{ $ipaConfig['padding'] }}" y2="{{ $ipaConfig['height'] - $ipaConfig['padding'] }}" class="axis" />

                    @foreach([0, 5, 10, 15, 20, 25] as $tick)
                        <line x1="{{ $scaleX($tick) }}" y1="{{ $ipaConfig['height'] - $ipaConfig['padding'] }}" x2="{{ $scaleX($tick) }}" y2="{{ $ipaConfig['height'] - $ipaConfig['padding'] + 6 }}" class="tick" />
                        <text x="{{ $scaleX($tick) }}" y="{{ $ipaConfig['height'] - $ipaConfig['padding'] + 20 }}" class="tick-label">{{ $tick }}</text>
                    @endforeach

                    @foreach([0, 20, 40, 60, 80, 100] as $tick)
                        <line x1="{{ $ipaConfig['padding'] }}" y1="{{ $scaleY($tick) }}" x2="{{ $ipaConfig['padding'] - 6 }}" y2="{{ $scaleY($tick) }}" class="tick" />
                        <text x="{{ $ipaConfig['padding'] - 12 }}" y="{{ $scaleY($tick) + 4 }}" class="tick-label">{{ $tick }}</text>
                    @endforeach

                        @foreach($ipaPoints as $point)
                        @php
                            $x = $scaleX($point['importance']);
                            $y = $scaleY($point['performance']);
                            $label = $point['short_label'];
                            $approxWidth = mb_strlen($label) * 6;
                            $labelX = $x + 14;
                            $labelY = $y + $point['label_y_offset'];
                            $labelAnchor = 'start';
                            if (($labelX + $approxWidth) > ($ipaConfig['width'] - $ipaConfig['padding'])) {
                                $labelAnchor = 'end';
                                $labelX = $x - 14;
                            }

                            if ($labelAnchor === 'end' && $labelX < $ipaConfig['padding']) {
                                $labelAnchor = 'middle';
                                $labelX = $x;
                            }
                        @endphp
                        <circle cx="{{ $x }}" cy="{{ $y }}" r="6" class="ipa-point" />
                        <text x="{{ $labelX }}" y="{{ $labelY }}" class="ipa-label" text-anchor="{{ $labelAnchor }}" fill="{{ $point['color'] }}">{{ $label }}</text>
                    @endforeach
                </svg>
            </div>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <h3 class="card-title mb-4">Performance Assessment</h3>
            <div class="card-grid">
                <div>
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Proses Sistem Pengelolaan Pelanggan</th>
                                <th>Performansi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($processGroups as $group)
                                <tr>
                                    <td>{{ $group['name'] }}</td>
                                    <td>{{ $group['performance'] }}%</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="overall-score">
                    <h4 class="h6 mb-3">Nilai Sistem Pengelolaan Pelanggan</h4>
                    <div class="score-value">{{ $overallScore }}</div>
                </div>
            </div>
            <hr class="my-4">
            <div>
                <h4 class="h5 mb-3">Rekomendasi</h4>
                <p>{!! nl2br(e($recommendationText)) !!}</p>
            </div>
        </div>
    </div>
</div>

<style>
.spp-dashboard {
    max-width: 1100px;
    margin: 2rem auto;
    padding: 0 1rem 2rem;
}

.company-badge {
    width: 64px;
    height: 64px;
    border-radius: 1rem;
    background: linear-gradient(135deg, #667eea, #764ba2);
    color: white;
    font-size: 2rem;
    font-weight: 600;
    display: flex;
    align-items: center;
    justify-content: center;
}

.card-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 2rem;
}

.insight-panel {
    background: linear-gradient(135deg, rgba(13, 110, 253, 0.1), rgba(13, 110, 253, 0.2));
    padding: 1.5rem;
    border-radius: 0.5rem;
}

.ipa-chart {
    width: 100%;
}

.quad {
    opacity: 0.35;
}

.quad-high { fill: #fee2e2; }
.quad-keep { fill: #dcfce7; }
.quad-low { fill: #fef3c7; }
.quad-watch { fill: #dbeafe; }

.grid-line {
    stroke: #94a3b8;
    stroke-dasharray: 4;
    opacity: 0.6;
}

.axis {
    stroke: #1f2937;
    stroke-width: 1.5;
}

.tick {
    stroke: #1f2937;
    stroke-width: 1.5;
}

.tick-label {
    fill: #1f2937;
    font-size: 12px;
    text-anchor: middle;
}

.ipa-point {
    fill: #0d6efd;
    stroke: #0c4a6e;
    stroke-width: 2;
}

.ipa-label {
    font-size: 12px;
    font-weight: 600;
}

.overall-score {
    background: #f8f9fa;
    border-radius: 0.5rem;
    padding: 2rem;
    text-align: center;
}

.score-value {
    font-size: 4rem;
    font-weight: 700;
    color: #0d6efd;
}

@media print {
    .btn, .header-actions {
        display: none !important;
    }
}
</style>
@endsection
