@extends('layouts.master')

@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Detail Evaluasi SPP</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.spp.index') }}">Evaluasi SPP</a></li>
                        <li class="breadcrumb-item active">Detail</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <!-- Info Perusahaan -->
            <div class="row">
                <div class="col-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Informasi Perusahaan</h3>
                        </div>
                        <div class="card-body">
                            <dl class="row">
                                <dt class="col-sm-3">Nama Perusahaan:</dt>
                                <dd class="col-sm-9">{{ $evaluation->company_name }}</dd>
                                
                                <dt class="col-sm-3">Session Token:</dt>
                                <dd class="col-sm-9">
                                    <code>{{ $evaluation->session_token }}</code>
                                    <a href="{{ route('spp.survey.result', $evaluation->session_token) }}" 
                                       target="_blank" 
                                       class="btn btn-xs btn-info ml-2">
                                        <i class="fas fa-external-link-alt"></i> Lihat Hasil Public
                                    </a>
                                </dd>
                                
                                <dt class="col-sm-3">Status:</dt>
                                <dd class="col-sm-9">
                                    <span class="badge badge-{{ $evaluation->status == 'completed' ? 'success' : 'secondary' }}">
                                        {{ ucfirst($evaluation->status) }}
                                    </span>
                                </dd>
                                
                                <dt class="col-sm-3">Tanggal Submit:</dt>
                                <dd class="col-sm-9">{{ $evaluation->created_at->format('d F Y, H:i:s') }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Hasil Maturity Assessment -->
            <div class="row">
                <div class="col-md-6">
                    <div class="card card-success">
                        <div class="card-header">
                            <h3 class="card-title">Maturity Assessment</h3>
                        </div>
                        <div class="card-body">
                            <div class="text-center mb-3">
                                <h1 class="display-4">
                                    <span class="badge badge-{{ $evaluation->maturity_level >= 4 ? 'success' : ($evaluation->maturity_level >= 3 ? 'warning' : 'danger') }}">
                                        Level {{ $evaluation->maturity_level }}
                                    </span>
                                </h1>
                                <p class="lead">{{ $evaluation->getMaturityLevelDescription() }}</p>
                                <p><strong>Score:</strong> {{ number_format($evaluation->maturity_score, 2) }}/5.00</p>
                            </div>
                            
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Pertanyaan</th>
                                        <th class="text-center">Jawaban</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach(['maturity_1', 'maturity_2', 'maturity_3', 'maturity_4', 'maturity_5', 'maturity_6', 'maturity_7', 'maturity_8'] as $index => $field)
                                    <tr>
                                        <td>Maturity {{ $index + 1 }}</td>
                                        <td class="text-center">
                                            <span class="badge badge-info">{{ $evaluation->$field }}/5</span>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card card-warning">
                        <div class="card-header">
                            <h3 class="card-title">Process Group Scores</h3>
                        </div>
                        <div class="card-body">
                            @php
                                $processGroups = [
                                    'strategy_development' => 'Strategy Development',
                                    'value_creation' => 'Value Creation',
                                    'multichannel_integration' => 'Multi-channel Integration',
                                    'information_management' => 'Information Management',
                                    'performance_assessment' => 'Performance Assessment'
                                ];
                            @endphp
                            
                            @foreach($processGroups as $key => $name)
                            <div class="mb-3">
                                <div class="d-flex justify-content-between">
                                    <span><strong>{{ $name }}</strong></span>
                                    <span class="badge badge-primary">{{ number_format($evaluation->{$key . '_score'}, 2) }}/5.00</span>
                                </div>
                                <div class="progress">
                                    <div class="progress-bar bg-{{ $evaluation->{$key . '_score'} >= 4 ? 'success' : ($evaluation->{$key . '_score'} >= 3 ? 'warning' : 'danger') }}" 
                                         role="progressbar" 
                                         style="width: {{ ($evaluation->{$key . '_score'} / 5) * 100 }}%"
                                         aria-valuenow="{{ $evaluation->{$key . '_score'} }}" 
                                         aria-valuemin="0" 
                                         aria-valuemax="5">
                                    </div>
                                </div>
                            </div>
                            @endforeach

                            <div class="alert alert-info mt-3">
                                <strong>Area Terlemah:</strong> {{ $evaluation->getLowestProcessGroup() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Priority Assessment -->
            <div class="row">
                <div class="col-12">
                    <div class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title">Priority Assessment (Total: {{ collect(range(1, 11))->sum(function($i) use ($evaluation) { return $evaluation->{'priority_' . $i}; }) }}%)</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                @foreach(range(1, 11) as $i)
                                <div class="col-md-4 col-sm-6 mb-2">
                                    <div class="small-box bg-light">
                                        <div class="inner">
                                            <h4>{{ $evaluation->{'priority_' . $i} }}%</h4>
                                            <p>Priority Item {{ $i }}</p>
                                        </div>
                                        <div class="icon">
                                            <i class="fas fa-star"></i>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Readiness Audit -->
            <div class="row">
                <div class="col-12">
                    <div class="card card-danger">
                        <div class="card-header">
                            <h3 class="card-title">Readiness Audit</h3>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th width="5%">No</th>
                                        <th>Pertanyaan</th>
                                        <th width="15%" class="text-center">Jawaban</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach(range(1, 11) as $i)
                                    <tr>
                                        <td>{{ $i }}</td>
                                        <td>Readiness Question {{ $i }}</td>
                                        <td class="text-center">
                                            <span class="badge badge-{{ $evaluation->{'readiness_' . $i} >= 4 ? 'success' : ($evaluation->{'readiness_' . $i} >= 3 ? 'warning' : 'danger') }}">
                                                {{ $evaluation->{'readiness_' . $i} }}/5
                                            </span>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <a href="{{ route('admin.spp.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                    <form action="{{ route('admin.spp.destroy', $evaluation->id) }}" 
                          method="POST" 
                          style="display:inline-block;"
                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-trash"></i> Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
