@extends('layouts.user')

@section('content')

<div class="container py-5">
  <div class="row justify-content-center">
    <div class="col-lg-8 col-md-10">
      <div class="card shadow-lg">
        <div class="card-header bg-success text-white text-center py-4">
          <h4 class="mb-0"><strong>Aplikasi Survei Kepuasan dan Loyalitas Pelanggan</strong></h4>
        </div>
        
        <div class="card-body p-4">
          <form method="POST" action="{{ route('responden.simpanpertanyaan3') }}">
            @csrf
            <input type="hidden" value="{{ $data->id_responden }}" name="id_responden">
            
            <div class="card mb-4">
              <div class="card-header bg-light">
                <h5 class="mb-0">IV. Kepuasan Responden</h5>
              </div>
              <div class="card-body">
                <div class="mb-3">
                  <label class="form-label">1. Secara keseluruhan, saya merasa puas pada layanan pelatihan ini.</label>
                  <select class="form-select" name="k1" required>
                    <option value="">-- Pilih Jawaban --</option>
                    <option value="1">Sangat tidak setuju</option>
                    <option value="2">Tidak setuju</option>
                    <option value="3">Netral</option>
                    <option value="4">Setuju</option>
                    <option value="5">Sangat setuju</option>
                  </select>
                </div>

                <div class="mb-3">
                  <label class="form-label">2. Menurut saya, kinerja layanan pelatihan ini telah sesuai dengan harapan saya.</label>
                  <select class="form-select" name="k2" required>
                    <option value="">-- Pilih Jawaban --</option>
                    <option value="1">Sangat tidak setuju</option>
                    <option value="2">Tidak setuju</option>
                    <option value="3">Netral</option>
                    <option value="4">Setuju</option>
                    <option value="5">Sangat setuju</option>
                  </select>
                </div>

                <div class="mb-3">
                  <label class="form-label">3. Menurut saya, layanan pelatihan ini telah sesuai dengan layanan pelatihan yang ideal.</label>
                  <select class="form-select" name="k3" required>
                    <option value="">-- Pilih Jawaban --</option>
                    <option value="1">Sangat tidak setuju</option>
                    <option value="2">Tidak setuju</option>
                    <option value="3">Netral</option>
                    <option value="4">Setuju</option>
                    <option value="5">Sangat setuju</option>
                  </select>
                </div>
                          



              </div>
              
              <div class="card-footer">
                <button type="submit" class="btn btn-success w-100 py-2">LANJUTKAN <i class="bi bi-arrow-right"></i></button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection
