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
          <form class="form-horizontal" enctype="multipart/form-data"  method="GET" action="{{ route('responden.bisnis') }}">
            

            <div class="card card-info">
                <div class="card-header" style="background-color: #95D5B2; color:black;">
                  <h3 class="card-title">Isi Bisnis Anda </h3>
                </div>
               
                  <div class="card-body">
                    
                      <div class="row">
                        
                          <div class="col-lg-12">
                            <div class="form-group">
                              <label class="col-sm-6 col-form-label">Nama Bisnis</label>
                              <div class="col-sm-12">
                                <select class="form-control select2bs4" required name="bisnis" style="width: 100%;">
                                  <option value="">-- Pilih --</option>
                                  <option value="4">Lembaga Pelatihan</option>
                                  <option value="1" disabled>Coffee shop</option>
                                  <option value="2" disabled>Usaha Fashion</option>
                                  <option value="3" disabled>Usaha Agro Bisnis</option>
                                          
                                </select>
                                 
                              </div>
                            </div>
    
                          </div>
                    
                      </div>
                  </div>
                 
                  <div class="card-footer">
                    
                    <button type="submit" style="background-color: rgba(19, 88, 25, 0.925)" class="btn btn-success btn-block">ISI KUESIONER</button>
                  </div>
                
              </div>
             
              </form>
            </div>
    
    
    
        
            <div class="col-lg-3  d-lg-block d-md-block d-sm-block d-none"></div>  
        </div>
    </div>
  </section>

@endsection
