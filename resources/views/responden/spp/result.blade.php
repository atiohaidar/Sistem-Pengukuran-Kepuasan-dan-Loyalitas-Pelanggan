@extends('layouts.user')

@section('content')
@php
    $ipaConfig = $ipaChart['config'];
    $ipaPoints = $ipaChart['points'];
@endphp

<div class="spp-dashboard">
    <div class="dashboard-card header-card">
        <div class="header-left">
            <div class="company-badge">{{ $companyInitial }}</div>
            <div>
                <h1>Dashboard Hasil Evaluasi</h1>
                <h2>{{ $companyName }}</h2>
                <p class="token">Token Akses: <code>{{ $sessionToken }}</code></p>
            </div>
        </div>
        <div class="header-actions">
            <a href="{{ route('spp.survey.index') }}" class="btn btn-secondary">Mulai Asesmen Baru</a>
            <button type="button" class="btn btn-tertiary" onclick="window.print()">Cetak Hasil</button>
        </div>
    </div>

    <div class="dashboard-card">
        <h3>Maturity Assessment</h3>
        <div class="card-grid">
            <div>
                <table class="dashboard-table">
                    <thead>
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
                        <tr class="table-total">
                            <td>Rata-rata</td>
                            <td>{{ number_format($maturityAverage, 2) }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="insight-panel">
                <span class="badge badge-primary">Level {{ $roundedAverage }}</span>
                <h4>{{ $maturityInsight['title'] }}</h4>
                <p>{!! nl2br(e($maturityInsight['description'])) !!}</p>
            </div>
        </div>
    </div>

    <div class="dashboard-card">
        <h3>Readiness Audit</h3>
        <div class="card-grid">
            <div>
                <table class="dashboard-table">
                    <thead>
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
            <div class="ipa-wrapper">
                <h4>Importance - Performance Analysis</h4>
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

    <div class="dashboard-card">
        <h3>Performance Assessment</h3>
        <div class="card-grid">
            <div>
                <table class="dashboard-table">
                    <thead>
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
                <h4>Nilai Sistem Pengelolaan Pelanggan</h4>
                <div class="score-value">{{ $overallScore }}</div>
            </div>
        </div>
        <div class="recommendation">
            <h4>Rekomendasi</h4>
            <p>{!! nl2br(e($recommendationText)) !!}</p>
        </div>
    </div>
</div>

<style>
:root {
    --primary-color: #1e3c72;
    --secondary-color: #2a5298;
    --accent-color: #0ea5e9;
    --gray-color: #d1d5db;
    --light-gray-color: #f3f4f6;
    --dark-gray-color: #4b5563;
    --text-color: #1f2937;
    --muted-text-color: #6b7280;
    --border-radius: 16px;
}

.spp-dashboard {
    max-width: 1100px;
    margin: 40px auto;
    padding: 0 20px 40px;
    font-family: 'Inter', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    color: var(--text-color);
}

.dashboard-card {
    background: #ffffff;
    border-radius: var(--border-radius);
    box-shadow: 0 20px 40px rgba(30, 60, 114, 0.12);
    padding: 32px;
    margin-bottom: 32px;
}

.dashboard-card h3 {
    margin-top: 0;
    margin-bottom: 24px;
    font-size: 1.5rem;
    color: var(--primary-color);
}

.header-card {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 24px;
}

.header-left {
    display: flex;
    align-items: center;
    gap: 20px;
}

.company-badge {
    width: 64px;
    height: 64px;
    border-radius: 16px;
    background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
    color: #ffffff;
    font-size: 2rem;
    font-weight: 600;
    display: flex;
    align-items: center;
    justify-content: center;
}

.header-card h1 {
    margin: 0;
    font-size: 1.75rem;
}

.header-card h2 {
    margin: 6px 0 12px;
    font-size: 1.2rem;
    color: var(--muted-text-color);
}

.token {
    margin: 0;
    color: var(--muted-text-color);
}

.header-actions {
    display: flex;
    gap: 12px;
}

.btn {
    padding: 0.75rem 1.6rem;
    border-radius: 999px;
    text-decoration: none;
    font-weight: 600;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
    cursor: pointer;
    border: none;
}

.btn-secondary {
    background: var(--primary-color);
    color: #ffffff;
    box-shadow: 0 12px 24px rgba(30, 60, 114, 0.2);
}

.btn-tertiary {
    background: #ffffff;
    color: var(--primary-color);
    border: 1px solid var(--primary-color);
}

.btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 14px 28px rgba(30, 60, 114, 0.22);
}

.card-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 32px;
}

.dashboard-table {
    width: 100%;
    border-collapse: collapse;
    background: #ffffff;
    border-radius: 12px;
    overflow: hidden;
}

.dashboard-table thead {
    background: var(--light-gray-color);
}

.dashboard-table th,
.dashboard-table td {
    padding: 12px 16px;
    border-bottom: 1px solid #e5e7eb;
    text-align: left;
}

.dashboard-table tbody tr:last-child td {
    border-bottom: none;
}

.table-total td {
    font-weight: 600;
    background: rgba(14, 165, 233, 0.12);
}

.insight-panel {
    background: linear-gradient(135deg, rgba(14, 165, 233, 0.1), rgba(14, 165, 233, 0.25));
    padding: 24px;
    border-radius: 16px;
    display: flex;
    flex-direction: column;
    gap: 12px;
}

.insight-panel p {
    margin: 0;
    color: var(--dark-gray-color);
}

.badge {
    display: inline-block;
    padding: 6px 12px;
    border-radius: 999px;
    font-weight: 600;
    font-size: 0.85rem;
}

.badge-primary {
    background: rgba(30, 60, 114, 0.12);
    color: var(--primary-color);
}

.ipa-wrapper {
    display: flex;
    flex-direction: column;
    gap: 16px;
}

.ipa-chart {
    width: 100%;
    background: #ffffff;
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
    fill: var(--accent-color);
    stroke: #0c4a6e;
    stroke-width: 2;
}

.ipa-label {
    font-size: 12px;
    font-weight: 600;
}

.overall-score {
    background: var(--light-gray-color);
    border-radius: 16px;
    padding: 24px;
    text-align: center;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
}

.overall-score h4 {
    margin-top: 0;
    margin-bottom: 12px;
}

.score-value {
    font-size: 4rem;
    font-weight: 700;
    color: var(--primary-color);
}

.recommendation {
    margin-top: 32px;
    border-top: 1px solid var(--gray-color);
    padding-top: 24px;
}

.recommendation p {
    white-space: pre-wrap;
    margin: 0;
}

@media (max-width: 768px) {
    .header-card {
        flex-direction: column;
        align-items: flex-start;
    }

    .header-actions {
        width: 100%;
        justify-content: flex-start;
    }

    .ipa-wrapper {
        align-items: center;
    }

    .overall-score {
        padding: 32px 16px;
    }
}

@media print {
    body {
        background: #ffffff;
    }
    .spp-dashboard {
        padding: 0;
    }
    .dashboard-card {
        box-shadow: none;
        border: 1px solid #e5e7eb;
        margin-bottom: 16px;
    }
    .btn, .header-actions {
        display: none !important;
    }
}
</style>
@endsection
