@extends('layouts.app')

@section('title', 'Manajemen Data Survei')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Manajemen Data Survei Pelatihan</h3>
                    <div class="card-tools">
                        <a href="{{ route('dashboard.survey-management.export') }}" class="btn btn-success btn-sm">
                            <i class="fas fa-download"></i> Export CSV
                        </a>
                    </div>
                </div>

                <!-- Statistics Cards -->
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-info">
                                <div class="inner">
                                    <h3>{{ $stats['total_responses'] }}</h3>
                                    <p>Total Responden</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-users"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-success">
                                <div class="inner">
                                    <h3>{{ $stats['completed_responses'] }}</h3>
                                    <p>Survei Selesai</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-check-circle"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-warning">
                                <div class="inner">
                                    <h3>{{ $stats['draft_responses'] }}</h3>
                                    <p>Survei Draft</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-edit"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-primary">
                                <div class="inner">
                                    <h3>{{ $stats['unique_sessions'] }}</h3>
                                    <p>Sesi Unik</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-clock"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Survey Responses Table -->
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Email</th>
                                    <th>Jenis Kelamin</th>
                                    <th>Usia</th>
                                    <th>Pekerjaan</th>
                                    <th>Domisili</th>
                                    <th>Status</th>
                                    <th>Dibuat</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($surveyResponses as $response)
                                <tr>
                                    <td>{{ $response->id }}</td>
                                    <td>{{ $response->profile_data['email'] ?? '-' }}</td>
                                    <td>
                                        @if($response->profile_data['jenis_kelamin'] ?? null)
                                            {{ $response->profile_data['jenis_kelamin'] === 'L' ? 'Laki-laki' : 'Perempuan' }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>{{ $response->profile_data['usia'] ?? '-' }}</td>
                                    <td>{{ $response->profile_data['pekerjaan'] ?? '-' }}</td>
                                    <td>{{ $response->profile_data['domisili'] ?? '-' }}</td>
                                    <td>
                                        <span class="badge {{ $response->status === 'completed' ? 'badge-success' : 'badge-warning' }}">
                                            {{ $response->status === 'completed' ? 'Selesai' : 'Draft' }}
                                        </span>
                                    </td>
                                    <td>{{ $response->created_at->format('d/m/Y H:i') }}</td>
                                    <td>
                                        <a href="{{ route('dashboard.survey-management.show', $response->id) }}"
                                           class="btn btn-info btn-sm">
                                            <i class="fas fa-eye"></i> Detail
                                        </a>
                                        <form action="{{ route('dashboard.survey-management.destroy', $response->id) }}"
                                              method="POST" class="d-inline"
                                              onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                <i class="fas fa-trash"></i> Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="9" class="text-center">
                                        <div class="alert alert-info">
                                            <i class="fas fa-info-circle"></i> Belum ada data survei.
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    @if($surveyResponses->hasPages())
                    <div class="d-flex justify-content-center mt-4">
                        {{ $surveyResponses->links() }}
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.small-box {
    border-radius: 0.25rem;
    box-shadow: 0 0 1px rgba(0,0,0,.125), 0 1px 3px rgba(0,0,0,.2);
    margin-bottom: 1rem;
}

.small-box .inner {
    padding: 10px;
}

.small-box .icon {
    color: rgba(0,0,0,0.15);
    z-index: 0;
}

.small-box .icon > i {
    font-size: 70px;
    top: 20px;
}

.table-responsive {
    max-height: 600px;
    overflow-y: auto;
}
</style>
@endpush

@push('scripts')
<script>
$(document).ready(function() {
    // Initialize any additional JavaScript if needed
});
</script>
@endpush