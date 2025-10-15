@extends('layouts.app')

@section('title', 'Detail Survei - ' . $surveyResponse->id)

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <!-- Back Button -->
            <div class="mb-3">
                <a href="{{ route('dashboard.survey-management') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Kembali ke Daftar Survei
                </a>
            </div>

            <!-- Profile Information -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Informasi Responden</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <th width="150">ID Responden:</th>
                                    <td>{{ $surveyResponse->id }}</td>
                                </tr>
                                <tr>
                                    <th>Session Token:</th>
                                    <td><code>{{ $surveyResponse->session_token }}</code></td>
                                </tr>
                                <tr>
                                    <th>Email:</th>
                                    <td>{{ $surveyResponse->profile_data['email'] ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>WhatsApp:</th>
                                    <td>{{ $surveyResponse->profile_data['whatsapp'] ?? '-' }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <th width="150">Jenis Kelamin:</th>
                                    <td>
                                        @if($surveyResponse->profile_data['jenis_kelamin'] ?? null)
                                            {{ $surveyResponse->profile_data['jenis_kelamin'] === 'L' ? 'Laki-laki' : 'Perempuan' }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Usia:</th>
                                    <td>{{ $surveyResponse->profile_data['usia'] ?? '-' }} tahun</td>
                                </tr>
                                <tr>
                                    <th>Pekerjaan:</th>
                                    <td>{{ $surveyResponse->profile_data['pekerjaan'] ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Domisili:</th>
                                    <td>{{ $surveyResponse->profile_data['domisili'] ?? '-' }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <th width="150">Status:</th>
                                    <td>
                                        <span class="badge {{ $surveyResponse->status === 'completed' ? 'badge-success' : 'badge-warning' }}">
                                            {{ $surveyResponse->status === 'completed' ? 'Selesai' : 'Draft' }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Dibuat:</th>
                                    <td>{{ $surveyResponse->created_at->format('d/m/Y H:i:s') }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <th width="150">Dimulai:</th>
                                    <td>{{ $surveyResponse->started_at ? $surveyResponse->started_at->format('d/m/Y H:i:s') : '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Selesai:</th>
                                    <td>{{ $surveyResponse->completed_at ? $surveyResponse->completed_at->format('d/m/Y H:i:s') : '-' }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Survey Answers -->
            @if($surveyResponse->status === 'completed')
            <!-- Importance Answers -->
            @if($surveyResponse->importance_answers)
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Jawaban Pentingnya (Importance)</h3>
                </div>
                <div class="card-body">
                    @foreach($questionLabels['importance_answers'] as $dimension => $questions)
                    <h5 class="text-primary">{{ ucfirst($dimension) }}</h5>
                    <div class="table-responsive mb-4">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Pertanyaan</th>
                                    <th width="100">Skor</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($questions as $key => $question)
                                <tr>
                                    <td>{{ $question }}</td>
                                    <td>
                                        <span class="badge badge-info">
                                            {{ $surveyResponse->importance_answers[$dimension][$key] ?? '-' }}/5
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Performance Answers -->
            @if($surveyResponse->performance_answers)
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Jawaban Kinerja (Performance)</h3>
                </div>
                <div class="card-body">
                    @foreach($questionLabels['performance_answers'] as $dimension => $questions)
                    <h5 class="text-success">{{ ucfirst($dimension) }}</h5>
                    <div class="table-responsive mb-4">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Pertanyaan</th>
                                    <th width="100">Skor</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($questions as $key => $question)
                                <tr>
                                    <td>{{ $question }}</td>
                                    <td>
                                        <span class="badge badge-success">
                                            {{ $surveyResponse->performance_answers[$dimension][$key] ?? '-' }}/5
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Satisfaction Answers -->
            @if($surveyResponse->satisfaction_answers)
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Jawaban Kepuasan (Satisfaction)</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Pertanyaan</th>
                                    <th width="100">Skor</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($questionLabels['satisfaction_answers'] as $key => $question)
                                <tr>
                                    <td>{{ $question }}</td>
                                    <td>
                                        <span class="badge badge-warning">
                                            {{ $surveyResponse->satisfaction_answers[$key] ?? '-' }}/5
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endif

            <!-- Loyalty Answers -->
            @if($surveyResponse->loyalty_answers)
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Jawaban Loyalitas (Loyalty)</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Pertanyaan</th>
                                    <th width="100">Skor</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($questionLabels['loyalty_answers'] as $key => $question)
                                <tr>
                                    <td>{{ $question }}</td>
                                    <td>
                                        <span class="badge badge-primary">
                                            {{ $surveyResponse->loyalty_answers[$key] ?? '-' }}/5
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endif

            <!-- Feedback Answers -->
            @if($surveyResponse->feedback_answers)
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Feedback dan Saran</h3>
                </div>
                <div class="card-body">
                    @if(isset($surveyResponse->feedback_answers['kritik_saran']) && $surveyResponse->feedback_answers['kritik_saran'])
                    <div class="mb-3">
                        <h6>Kritik dan Saran:</h6>
                        <p class="border p-2 rounded">{{ $surveyResponse->feedback_answers['kritik_saran'] }}</p>
                    </div>
                    @endif

                    @if(isset($surveyResponse->feedback_answers['tema_judul']) && $surveyResponse->feedback_answers['tema_judul'])
                    <div class="mb-3">
                        <h6>Tema/Judul Pelatihan yang Diinginkan:</h6>
                        <p class="border p-2 rounded">{{ $surveyResponse->feedback_answers['tema_judul'] }}</p>
                    </div>
                    @endif

                    @if(isset($surveyResponse->feedback_answers['bentuk_pelatihan']))
                    <div class="mb-3">
                        <h6>Bentuk Pelatihan yang Diinginkan:</h6>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox"
                                           {{ ($surveyResponse->feedback_answers['bentuk_pelatihan']['online'] ?? false) ? 'checked' : '' }}
                                           disabled>
                                    <label class="form-check-label">Online</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox"
                                           {{ ($surveyResponse->feedback_answers['bentuk_pelatihan']['offline'] ?? false) ? 'checked' : '' }}
                                           disabled>
                                    <label class="form-check-label">Offline</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox"
                                           {{ ($surveyResponse->feedback_answers['bentuk_pelatihan']['streaming'] ?? false) ? 'checked' : '' }}
                                           disabled>
                                    <label class="form-check-label">Streaming</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox"
                                           {{ ($surveyResponse->feedback_answers['bentuk_pelatihan']['elearning'] ?? false) ? 'checked' : '' }}
                                           disabled>
                                    <label class="form-check-label">E-Learning</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
            @endif
            @else
            <div class="card">
                <div class="card-body">
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle"></i>
                        Survei ini masih dalam status draft dan belum diisi lengkap.
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.badge {
    font-size: 0.9em;
}

.table th {
    background-color: #f8f9fa;
    font-weight: 600;
}

.card {
    margin-bottom: 1.5rem;
}

.card-header {
    background-color: #f8f9fa;
    border-bottom: 1px solid #dee2e6;
}
</style>
@endpush