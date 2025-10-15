<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Survei - ') . $surveyResponse->id }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <!-- Back Button -->
                    <div class="mb-6">
                        <a href="{{ route('dashboard.survey-management.index') }}"
                           class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            Kembali ke Daftar Survei
                        </a>
                    </div>

                    <!-- Profile Information -->
                    <div class="bg-gray-50 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                        <div class="px-6 py-4 bg-gray-100 border-b border-gray-200">
                            <h3 class="text-lg font-medium text-gray-900">Informasi Responden</h3>
                        </div>
                        <div class="p-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <dl class="space-y-3">
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500">ID Responden</dt>
                                            <dd class="mt-1 text-sm text-gray-900">{{ $surveyResponse->id }}</dd>
                                        </div>
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500">Session Token</dt>
                                            <dd class="mt-1 text-sm text-gray-900">
                                                <code class="px-2 py-1 bg-gray-100 rounded text-xs">{{ $surveyResponse->session_token }}</code>
                                            </dd>
                                        </div>
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500">Email</dt>
                                            <dd class="mt-1 text-sm text-gray-900">{{ $surveyResponse->profile_data['email'] ?? '-' }}</dd>
                                        </div>
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500">WhatsApp</dt>
                                            <dd class="mt-1 text-sm text-gray-900">{{ $surveyResponse->profile_data['whatsapp'] ?? '-' }}</dd>
                                        </div>
                                    </dl>
                                </div>
                                <div>
                                    <dl class="space-y-3">
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500">Jenis Kelamin</dt>
                                            <dd class="mt-1 text-sm text-gray-900">
                                                @if($surveyResponse->profile_data['jenis_kelamin'] ?? null)
                                                    {{ $surveyResponse->profile_data['jenis_kelamin'] === 'L' ? 'Laki-laki' : 'Perempuan' }}
                                                @else
                                                    -
                                                @endif
                                            </dd>
                                        </div>
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500">Usia</dt>
                                            <dd class="mt-1 text-sm text-gray-900">{{ $surveyResponse->profile_data['usia'] ?? '-' }} tahun</dd>
                                        </div>
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500">Pekerjaan</dt>
                                            <dd class="mt-1 text-sm text-gray-900">{{ $surveyResponse->profile_data['pekerjaan'] ?? '-' }}</dd>
                                        </div>
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500">Domisili</dt>
                                            <dd class="mt-1 text-sm text-gray-900">{{ $surveyResponse->profile_data['domisili'] ?? '-' }}</dd>
                                        </div>
                                    </dl>
                                </div>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6 pt-6 border-t border-gray-200">
                                <div>
                                    <dl class="space-y-3">
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500">Status</dt>
                                            <dd class="mt-1">
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $surveyResponse->status === 'completed' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                                    {{ $surveyResponse->status === 'completed' ? 'Selesai' : 'Draft' }}
                                                </span>
                                            </dd>
                                        </div>
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500">Dibuat</dt>
                                            <dd class="mt-1 text-sm text-gray-900">{{ $surveyResponse->created_at->format('d/m/Y H:i:s') }}</dd>
                                        </div>
                                    </dl>
                                </div>
                                <div>
                                    <dl class="space-y-3">
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500">Dimulai</dt>
                                            <dd class="mt-1 text-sm text-gray-900">{{ $surveyResponse->started_at ? $surveyResponse->started_at->format('d/m/Y H:i:s') : '-' }}</dd>
                                        </div>
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500">Selesai</dt>
                                            <dd class="mt-1 text-sm text-gray-900">{{ $surveyResponse->completed_at ? $surveyResponse->completed_at->format('d/m/Y H:i:s') : '-' }}</dd>
                                        </div>
                                    </dl>
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
                </div>
            </div>
        </div>
    </div>

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
</x-app-layout>