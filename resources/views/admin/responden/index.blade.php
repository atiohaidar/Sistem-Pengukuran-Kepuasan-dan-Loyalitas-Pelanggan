@extends('layouts.master')
@section('judul','Data Responden')

@section('content')

<div class="container-fluid py-3">
  <div class="row">
    <div class="col-12">
      <div class="card shadow">
        <div class="card-header bg-white d-flex justify-content-between align-items-center">
          <h5 class="mb-0"><strong>Database Responden</strong></h5>
          <a href="{{ route('admin.export') }}" class="btn btn-primary">
            <i class="bi bi-file-earmark-excel"></i> Export Excel
          </a>
        </div>
        <div class="card-body">
          @if ($message = Session::get('success'))
          <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>{{ $message }}</strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
          </div>
          @endif

          @if ($message = Session::get('error'))
          <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>{{ $message }}</strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
          </div>
          @endif

          @if ($message = Session::get('warning'))
          <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <strong>{{ $message }}</strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
          </div>
          @endif

          <div class="table-responsive">
            <table id="example2" class="table table-bordered table-striped table-hover">
              <thead class="table-light">
                <tr>
                  <th style="width: 5%">No</th>
                  <th>Nama Bisnis</th>
                  <th>Email</th>
                  <th>WhatsApp</th>
                  <th>JK</th>
                  <th>Usia</th>
                  <th>Pekerjaan</th>
                  <th>Domisili</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($database as $dt)
                <tr>
                  <td>{{ $loop->iteration }}</td>
                  <td>@if($dt->id_bisnis == '' || !$dt->bisnis) - @else {{ $dt->bisnis->nama_bisnis }} @endif</td>
                  <td>
                    <a class="btn btn-primary btn-sm" href="{{ route('admin.detail.responden', $dt->id_responden) }}">
                      {{ $dt->email }}
                    </a>
                  </td>
                  <td>{{ $dt->whatsapp }}</td>
                  <td>{{ $dt->jk }}</td>
                  <td>{{ $dt->usia }}</td>
                  <td>{{ $dt->pekerjaan }} @if($dt->pekerjaan_lain) [{{ $dt->pekerjaan_lain }}] @endif</td>
                  <td>@if($dt->domisili == '') - @else {{ $dt->domi->title }} @endif</td>
                  <td>
                    <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#modalHapus{{ $dt->id_responden }}">
                      <i class="bi bi-trash"></i> Hapus
                    </button>
                  </td>
                </tr>

                <!-- Modal Hapus -->
                <div class="modal fade" id="modalHapus{{ $dt->id_responden }}" tabindex="-1">
                  <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                      <form method="POST" action="{{ route('admin.responden.hapus', $dt->id_responden) }}">
                        @csrf
                        @method('delete')
                        <div class="modal-header bg-danger text-white">
                          <h5 class="modal-title">Konfirmasi</h5>
                          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body text-center">
                          <p>Yakin Mau Hapus Data ini?</p>
                          <p class="text-muted">{{ $dt->email }}</p>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                          <button type="submit" class="btn btn-danger">Hapus</button>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
                @endforeach
              </tbody>
              <tfoot class="table-light">
                <tr>
                  <th>No</th>
                  <th>Nama Bisnis</th>
                  <th>Email</th>
                  <th>WhatsApp</th>
                  <th>JK</th>
                  <th>Usia</th>
                  <th>Pekerjaan</th>
                  <th>Domisili</th>
                  <th>Aksi</th>
                </tr>
              </tfoot>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

 
@endsection
