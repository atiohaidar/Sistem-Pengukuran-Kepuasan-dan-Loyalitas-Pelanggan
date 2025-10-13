@extends('layouts.master')

@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Data Evaluasi SPP</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Evaluasi SPP</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Daftar Evaluasi SPP</h3>
                            <div class="card-tools">
                                <a href="{{ route('admin.spp.export') }}" class="btn btn-success btn-sm">
                                    <i class="fas fa-file-excel"></i> Export Excel
                                </a>
                                <a href="{{ route('spp.survey.index') }}" target="_blank" class="btn btn-primary btn-sm">
                                    <i class="fas fa-external-link-alt"></i> Link Survey
                                </a>
                            </div>
                        </div>
                        
                        <div class="card-body">
                            @if(session('success'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    {{ session('success') }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif

                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th width="5%">No</th>
                                        <th>Nama Perusahaan</th>
                                        <th>Token</th>
                                        <th>Maturity Level</th>
                                        <th>Maturity Score</th>
                                        <th>Status</th>
                                        <th>Tanggal Submit</th>
                                        <th width="15%">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($evaluations as $key => $eval)
                                    <tr>
                                        <td>{{ $evaluations->firstItem() + $key }}</td>
                                        <td>{{ $eval->company_name }}</td>
                                        <td>
                                            <code>{{ substr($eval->session_token, 0, 10) }}...</code>
                                            <a href="{{ route('spp.survey.result', $eval->session_token) }}" 
                                               target="_blank" 
                                               class="btn btn-xs btn-info" 
                                               title="Lihat Hasil">
                                                <i class="fas fa-external-link-alt"></i>
                                            </a>
                                        </td>
                                        <td>
                                            <span class="badge badge-{{ $eval->maturity_level >= 4 ? 'success' : ($eval->maturity_level >= 3 ? 'warning' : 'danger') }}">
                                                Level {{ $eval->maturity_level }}
                                            </span>
                                        </td>
                                        <td>{{ number_format($eval->maturity_score, 2) }}</td>
                                        <td>
                                            <span class="badge badge-{{ $eval->status == 'completed' ? 'success' : 'secondary' }}">
                                                {{ ucfirst($eval->status) }}
                                            </span>
                                        </td>
                                        <td>{{ $eval->created_at->format('d/m/Y H:i') }}</td>
                                        <td>
                                            <a href="{{ route('admin.spp.show', $eval->id) }}" class="btn btn-sm btn-info">
                                                <i class="fas fa-eye"></i> Detail
                                            </a>
                                            <form action="{{ route('admin.spp.destroy', $eval->id) }}" 
                                                  method="POST" 
                                                  style="display:inline-block;"
                                                  onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            <div class="mt-3">
                                {{ $evaluations->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@section('scripts')
<script>
  $(function () {
    $("#example1").DataTable({
      "responsive": true,
      "autoWidth": false,
      "paging": false,
      "searching": true,
      "ordering": true,
      "info": false,
    });
  });
</script>
@endsection
