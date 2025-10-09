@extends('layouts.user')
@section('judul','Pertanyaan I')

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
          <form class="form-horizontal" enctype="multipart/form-data"  method="POST" action="{{ route('responden.simpanpertanyaan4') }}">
            @csrf
            <input type="hidden" readonly value="{{ $data->id_responden }}" class="form-control" name="id_responden">
            <div class="card card-info">
                <div class="card-header" style="background-color: #95D5B2; color:black;">
                  <h3 class="card-title">V. Loyalitas Responden </h3>
                </div>
               
                  <div class="card-body">
                    <div class="row">
                        <!-- -->
                          
                          
                          
                          <div class="col-lg-12 mt-2">
                            <div class="form-group">
                                1. Saya akan mengulangi menggunakan jasa pelatihan ini
                                <div class="col-sm-12 mt-2">
                                <select class="form-control select2bs4" required name="l1" style="width: 100%;">
                                  <option value="">-- Pilih Jawaban --</option>
                                  
                                  <option value="1">Sangat tidak setuju</option>
                                  <option value="2" >Tidak setuju</option>
                                  <option value="3">Netral</option>
                                  <option value="4" >Setuju</option>
                                  <option value="5" >Sangat setuju</option>
                                          
                                </select>
                              </div>
                            </div>
                            <div class="form-group">
                              2. Saya akan tetap memilih jasa pelatihan ini meskipun tersedia alternatif pelatihan lain
                              <div class="col-sm-12 mt-2">
                                <select class="form-control select2bs4" required name="l2" style="width: 100%;">
                                  <option value="">-- Pilih Jawaban --</option>
                                  
                                  <option value="1">Sangat tidak setuju</option>
                                  <option value="2" >Tidak setuju</option>
                                  <option value="3">Netral</option>
                                  <option value="4" >Setuju</option>
                                  <option value="5" >Sangat setuju</option>
                                          
                                </select>
                              </div>
                            </div>
                            <div class="form-group">
                              3. Saya akan merekomendasikan pelatihan ini kepada orang lain
                              <div class="col-sm-12 mt-2">
                                <select class="form-control select2bs4" required name="l3" style="width: 100%;">
                                  <option value="">-- Pilih Jawaban --</option>
                                  
                                  <option value="1">Sangat tidak setuju</option>
                                  <option value="2" >Tidak setuju</option>
                                  <option value="3">Netral</option>
                                  <option value="4" >Setuju</option>
                                  <option value="5" >Sangat setuju</option>
                                          
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
