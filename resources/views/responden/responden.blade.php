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
          <form method="POST" action="{{ route('responden.simpanresponden') }}">
            @csrf

            <div class="card mb-4">
              <div class="card-header bg-light">
                <h5 class="mb-0">I. Profil Responden</h5>
              </div>
              <div class="card-body">
                <p class="text-muted">Bagian ini berisi pertanyaan mengenai data diri responden.<br/>
                  Mohon diisi dengan sebenar-benarnya. Data responden akan kami jaga kerahasiaannya.</p>
                
                <input type="hidden" value="4" name="id_bisnis">
                
                <div class="mb-3">
                  <label for="email" class="form-label">Email</label>
                  <input type="email" class="form-control" id="email" name="email" placeholder="isi email" required>
                </div>

                <div class="mb-3">
                  <label for="whatsapp" class="form-label">WhatsApp</label>
                  <input type="text" class="form-control" id="whatsapp" name="whatsapp" placeholder="isi whatsapp" required>
                </div>

                <div class="mb-3">
                  <label for="jk" class="form-label">Jenis Kelamin</label>
                  <select class="form-select" id="jk" name="jk" required>
                    <option value="">Pilih</option>
                    <option value="L">Laki-laki</option>
                    <option value="P">Perempuan</option>
                  </select>
                </div>

                <div class="mb-3">
                  <label for="usia" class="form-label">Usia</label>
                  <input type="number" class="form-control" id="usia" name="usia" placeholder="Masukkan usia Anda" required min="1" max="120">
                </div>

                <div class="mb-3">
                  <label for="pekerjaan" class="form-label">Pekerjaan</label>
                  <select class="form-select" id="pekerjaan" name="pekerjaan" required>
                    <option value="">Pilih</option>
                    <option value="Pegawai Swasta">Karyawan swasta</option>
                    <option value="Wiraswasta">Wiraswasta</option>
                    <option value="PNS">PNS</option>
                    <option value="Pelajar">Pelajar/Mahasiswa</option>
                    <option value="Mahasiswa">Mahasiswa</option>
                    <option value="Lainnya">Lainnya</option>
                  </select>
                  <input type="text" class="form-control mt-2" name="lain" placeholder="isi jika pekerjaan lainnya">
                </div>

                <div class="mb-3">
                  <label for="domisili" class="form-label">Domisili</label>
                  <select class="form-select" id="domisili" name="domisili" required>
                    <option value="">-- Pilih --</option>
                    @foreach($data as $dt)
                    <option value="{{ $dt->id }}">{{ $dt->title }}</option>
                    @endforeach
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
