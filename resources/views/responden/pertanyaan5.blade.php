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
          <form class="form-horizontal" enctype="multipart/form-data"  method="POST" action="{{ route('responden.simpanpertanyaan5') }}">
            @csrf
            <input type="hidden" readonly value="{{ $data->id_responden }}" class="form-control" name="id_responden">
            <div class="card card-info">
                <div class="card-header" style="background-color: #95D5B2; color:black;">
                  <h3 class="card-title">VI. Kritik dan saran </h3>
                </div>
               
                  <div class="card-body">
                    <p>Dengan anda mengisi kritik dan saran ini, diharapkan kualitas layanan pelatihan ini akan semakin baik dan sesuai dengan kepentingan anda.
                     
                      <div class="row">
                        <!-- -->
                          
                          
                          
                          <div class="col-lg-12 mt-2">
                            <div class="form-group">
                                1. Silahkan berikan kritik dan saran terkait layanan pelatihan berdasarkan apa yang anda alami
                                <div class="col-sm-12 mt-2">
                                <textarea name="kritik_saran" rows="5" cols="80"></textarea>
                              </div>
                            </div>
                            <div class="form-group">
                              2. Tema dan judul pelatihan yang diinginkan
                              <div class="col-sm-12 mt-2">
                                <textarea name="tema_judul" rows="5" cols="80"></textarea>
                              </div>
                            </div>
                            <div class="form-group">
                              3. Bentuk pelatihan yang diinginkan
                              <div class="col-sm-12 mt-2">
                                <input type="checkbox" name="online" value="1" /> Online<br>
                                <input type="checkbox" name="offline" value="1" /> Offline<br>
                                <input type="checkbox" name="streaming" value="1" /> streaming<br>
                                <input type="checkbox" name="elearning" value="1" /> E-learning<br>
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
