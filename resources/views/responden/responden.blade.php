@extends('layouts.user')
@section('judul','Pilih Bisnis')

@section('content')

  <section class="content">
    <div class="container-fluid">
        
        <div class="row">
          
          <div class="col-lg-3  d-lg-block d-md-block d-sm-block d-none"></div>
        
          <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12 mt-5" style="background-color: #40916C">
            <br/>
            <br/>
            <center><h4 style="color:black;"><b>Aplikasi Survei Kepuasan dan Loyalitas Pelanggan</b></h4></center>
              <br/>
          <form class="form-horizontal" enctype="multipart/form-data"  method="POST" action="{{ route('responden.simpanresponden') }}">
            @csrf

            <div class="card card-info">
                <div class="card-header" style="background-color: #95D5B2; color:black;">
                  <h3 class="card-title">I. Profil Responden </h3>
                </div>
                
                  <div class="card-body">
                      <p>Bagian ini berisi pertanyaan mengenai data diri responden.<br />
                        Mohon diisi dengan sebenar-benarnya. Data responden akan kami jaga kerahasiaannya.</p>
                        
                      <div class="row">
                        
                          <div class="col-lg-12">
                            <div class="form-group">
                              <label class="col-sm-6 col-form-label">Email</label>
                              <div class="col-sm-12">
                                <input type="hidden" readonly value="4" class="form-control" name="id_bisnis">
                                <input type="text" placeholder="isi email"  required class="form-control" name="email">
                                 
                              </div>
                            </div>

                            <div class="form-group">
                              <label class="col-sm-6 col-form-label">WhatsApp</label>
                              <div class="col-sm-12">
                                <input type="text" placeholder="isi whatsapp" required class="form-control" name="whatsapp">
                              </div>
                            </div>

                            <div class="form-group">
                              <label class="col-sm-6 col-form-label">Jenis Kelamin</label>
                              <div class="col-sm-12">
                                <select class="form-control select2bs4" required name="jk" style="width: 100%;">
                                  <option value="">Pilih</option>
                                  
                                  <option value="laki-laki">Laki-laki</option>
                                  <option value="perempuan" >Perempuan</option>
                                          
                                </select>
                              </div>
                            </div>

                            <div class="form-group">
                              <label class="col-sm-6 col-form-label">Usia</label>
                              <div class="col-sm-12">
                                <select class="form-control select2bs4" required name="usia" style="width: 100%;">
                                  <option value="">Pilih</option>
                                  
                                  <option value="<25"> < 25 tahun</option>
                                  <option value="25-34" >25-34 tahun</option>
                                  <option value="35-44" >35-44 tahun</option>
                                  <option value="45-54" >45-54 tahun</option>
                                  <option value="55-64" >55-64 tahun</option>
                                  <option value=">64"> > 64 tahun</option>
                                          
                                </select>
                              </div>
                            </div>
                            

                            <div class="form-group">
                              <label class="col-sm-6 col-form-label">Pekerjaan</label>
                              <div class="col-sm-12">
                                <select class="form-control select2bs4" required name="pekerjaan" style="width: 100%;">
                                  <option value="">Pilih</option>
                                  
                                  <option value="karyawan_swasta">Karyawan swasta</option>
                                  <option value="wiraswasta" >Wiraswasta</option>
                                  <option value="PNS">PNS</option>
                                  <option value="pelajar" >Pelajar/Mahasiswa</option>
                                  <option value="lain" >Lainnya</option>
                                          
                                </select>

                                <input type="text" placeholder="isi jika pekerjaan lainnya" class="form-control mt-2" name="lain">
                              </div>
                            </div>

                            <div class="form-group">
                              <label class="col-sm-6 col-form-label">Domisili</label>
                              <div class="col-sm-12">
                                <select class="form-control select2bs4" required name="domisili" style="width: 100%;">
                                  <option value="">-- Pilih --</option>
                                  @foreach($data as $dt)
                                  <option value="{{ $dt->id }}">{{ $dt->title }}</option>
                                  @endforeach
                                          
                                </select>
                              </div>
                            </div>
    
                          </div>
                    
                      </div>
                  </div>
                 
                  <div class="card-footer">
                    
                    <button type="submit" style="background-color: rgba(19, 88, 25, 0.925)" class="btn btn-success btn-block">LANJUTKAN >></button>
                  </div>
                
              </div>
             
              </form>
            </div>
    
    
    
        
            <div class="col-lg-3  d-lg-block d-md-block d-sm-block d-none"></div>  
        </div>
    </div>
  </section>

@endsection
