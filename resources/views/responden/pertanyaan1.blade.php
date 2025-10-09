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
          <form class="form-horizontal" enctype="multipart/form-data"  method="POST" action="{{ route('responden.simpanpertanyaan1') }}">
            @csrf
            <input type="hidden" readonly value="{{ $data->id_responden }}" class="form-control" name="id_responden">
            <div class="card card-info">
                <div class="card-header" style="background-color: #95D5B2; color:black;">
                  <h3 class="card-title">II. Penilaian tingkat kepentingan / Harapan responden terhadap kualitas layanan pelatihan </h3>
                </div>
               
                  <div class="card-body">
                    <p>Berikan jawaban yang sesuai dengan preferensi anda. Tentukan seberapa penting atribut tersebut memengaruhi Anda dalam menggunakan jasa pelatihan ini.<br />
                      Pilihan jawaban: "Sangat tidak penting, tidak penting, netral, penting, dan sangat penting".
                     
                      <div class="row">
                        <!-- -->
                          <div class="col-lg-12 mt-3 mb-3" style="background-color: #95D5B2">
                            <b>Reliability</b>
                          </div>
                          
                          
                          <div class="col-lg-12 mt-2">
                            <div class="form-group">
                                1. Kesesuaian isi post test dengan materi pelatihan yang diberikan.
                                <div class="col-sm-12 mt-2">
                                <select class="form-control select2bs4" required name="r1" style="width: 100%;">
                                  <option value="">-- Pilih Jawaban --</option>
                                  
                                  <option value="1">Sangat tidak penting</option>
                                  <option value="2" >Tidak penting</option>
                                  <option value="3">Netral</option>
                                  <option value="4" >Penting</option>
                                  <option value="5" >Sangat Penting</option>
                                          
                                </select>
                              </div>
                            </div>
                            <div class="form-group">
                              2. Ketepatan waktu pelatihan sesuai dengan jadwal yang telah dijanjikan.
                              <div class="col-sm-12 mt-2">
                                <select class="form-control select2bs4" required name="r2" style="width: 100%;">
                                  <option value="">-- Pilih Jawaban --</option>
                                  
                                  <option value="1">Sangat tidak penting</option>
                                  <option value="2" >Tidak penting</option>
                                  <option value="3">Netral</option>
                                  <option value="4" >Penting</option>
                                  <option value="5" >Sangat Penting</option>
                                          
                                </select>
                              </div>
                            </div>
                            <div class="form-group">
                              3. Ketepatan waktu dalam memberikan sertifikat pelatihan
                              <div class="col-sm-12 mt-2">
                                <select class="form-control select2bs4" required name="r3" style="width: 100%;">
                                  <option value="">-- Pilih Jawaban --</option>
                                  
                                  <option value="1">Sangat tidak penting</option>
                                  <option value="2" >Tidak penting</option>
                                  <option value="3">Netral</option>
                                  <option value="4" >Penting</option>
                                  <option value="5" >Sangat Penting</option>
                                          
                                </select>
                              </div>
                            </div>

                            <div class="form-group">
                              4. Ketepatan trainer dalam menjawab pertanyaan peserta
                              <div class="col-sm-12 mt-2">
                                <select class="form-control select2bs4" required name="r4" style="width: 100%;">
                                  <option value="">-- Pilih Jawaban --</option>
                                  
                                  <option value="1">Sangat tidak penting</option>
                                  <option value="2" >Tidak penting</option>
                                  <option value="3">Netral</option>
                                  <option value="4" >Penting</option>
                                  <option value="5" >Sangat Penting</option>
                                          
                                </select>
                              </div>
                            </div>

                            <div class="form-group">
                              5. Materi pelatihan mudah dimengerti.
                              <div class="col-sm-12 mt-2">
                                <select class="form-control select2bs4" required name="r5" style="width: 100%;">
                                  <option value="">-- Pilih Jawaban --</option>
                                  
                                  <option value="1">Sangat tidak penting</option>
                                  <option value="2" >Tidak penting</option>
                                  <option value="3">Netral</option>
                                  <option value="4" >Penting</option>
                                  <option value="5" >Sangat Penting</option>
                                          
                                </select>
                              </div>
                            </div>
                            <div class="form-group">
                              6. Kemudahan dalam melakukan registrasi pelatihan.
                              <div class="col-sm-12 mt-2">
                                <select class="form-control select2bs4" required name="r6" style="width: 100%;">
                                  <option value="">-- Pilih Jawaban --</option>
                                  
                                  <option value="1">Sangat tidak penting</option>
                                  <option value="2" >Tidak penting</option>
                                  <option value="3">Netral</option>
                                  <option value="4" >Penting</option>
                                  <option value="5" >Sangat Penting</option>
                                          
                                </select>
                              </div>
                            </div>
                            <div class="form-group">
                              7. Kemudahan dalam melakukan pembayaran pelatihan.
                              <div class="col-sm-12 mt-2">
                                <select class="form-control select2bs4" required name="r7" style="width: 100%;">
                                  <option value="">-- Pilih Jawaban --</option>
                                  
                                  <option value="1">Sangat tidak penting</option>
                                  <option value="2" >Tidak penting</option>
                                  <option value="3">Netral</option>
                                  <option value="4" >Penting</option>
                                  <option value="5" >Sangat Penting</option>
                                          
                                </select>
                              </div>
                            </div>




                          </div>
                          

                          <!-- -->
                          <div class="col-lg-12 mt-3 mb-3" style="background-color: #95D5B2">
                            <b>Assurance</b> 
                          </div>
                          
                          
                          <div class="col-lg-12 mt-2">
                            <div class="form-group">
                              1. Trainer/pegawai bersikap sopan.
                              <div class="col-sm-12 mt-2">
                                <select class="form-control select2bs4" name="a1" style="width: 100%;">
                                  <option value="">-- Pilih Jawaban --</option>
                                  
                                  <option value="1">Sangat tidak penting</option>
                                  <option value="2" >Tidak penting</option>
                                  <option value="3">Netral</option>
                                  <option value="4" >Penting</option>
                                  <option value="5" >Sangat Penting</option>
                                          
                                </select>
                              </div>
                            </div>
                            <div class="form-group">
                              2. Trainer memiliki pengetahuan yang luas mengenai materi pelatihan.
                              <div class="col-sm-12 mt-2">
                                <select class="form-control select2bs4" name="a2" style="width: 100%;">
                                  <option value="">-- Pilih Jawaban --</option>
                                  
                                  <option value="1">Sangat tidak penting</option>
                                  <option value="2" >Tidak penting</option>
                                  <option value="3">Netral</option>
                                  <option value="4" >Penting</option>
                                  <option value="5" >Sangat Penting</option>
                                          
                                </select>
                              </div>
                            </div>
                            <div class="form-group">
                              3. Trainer mampu menyampaikan materi pelatihan dengan cara yang mudah dipahami.
                              <div class="col-sm-12 mt-2">
                                <select class="form-control select2bs4" name="a3" style="width: 100%;">
                                  <option value="">-- Pilih Jawaban --</option>
                                  
                                  <option value="1">Sangat tidak penting</option>
                                  <option value="2" >Tidak penting</option>
                                  <option value="3">Netral</option>
                                  <option value="4" >Penting</option>
                                  <option value="5" >Sangat Penting</option>
                                          
                                </select>
                              </div>
                            </div>
                            <div class="form-group">
                              4. Committee service selalu dapat menyelesaikan keluhan pelanggan.
                              <div class="col-sm-12 mt-2">
                                <select class="form-control select2bs4" name="a4" style="width: 100%;">
                                  <option value="">-- Pilih Jawaban --</option>
                                  
                                  <option value="1">Sangat tidak penting</option>
                                  <option value="2" >Tidak penting</option>
                                  <option value="3">Netral</option>
                                  <option value="4" >Penting</option>
                                  <option value="5" >Sangat Penting</option>
                                          
                                </select>
                              </div>
                            </div>
                            

                          </div>
                         <!-- -->

                         <!-- -->
                         <div class="col-lg-12 mt-3 mb-3" style="background-color: #95D5B2">
                          <b>Tangible</b> 
                        </div>
                        
                        
                        <div class="col-lg-12 mt-2">
                          <div class="form-group">
                            1. Sistem aplikasi pelatihan online yang user friendly.
                            <div class="col-sm-12 mt-2">
                              <select class="form-control select2bs4" name="t1" style="width: 100%;">
                                <option value="">-- Pilih Jawaban --</option>
                                
                                <option value="1">Sangat tidak penting</option>
                                <option value="2" >Tidak penting</option>
                                <option value="3">Netral</option>
                                <option value="4" >Penting</option>
                                <option value="5" >Sangat Penting</option>
                                        
                              </select>
                            </div>
                          </div>
                          <div class="form-group">
                            2. Website menampilkan informasi terbaru.
                            <div class="col-sm-12 mt-2">
                              <select class="form-control select2bs4" name="t2" style="width: 100%;">
                                <option value="">-- Pilih Jawaban --</option>
                                
                                <option value="1">Sangat tidak penting</option>
                                <option value="2" >Tidak penting</option>
                                <option value="3">Netral</option>
                                <option value="4" >Penting</option>
                                <option value="5" >Sangat Penting</option>
                                        
                              </select>
                            </div>
                          </div>
                          <div class="form-group">
                            3. Perlengkapan audio visual berfungsi dengan baik
                            <div class="col-sm-12 mt-2">
                              <select class="form-control select2bs4" name="t3" style="width: 100%;">
                                <option value="">-- Pilih Jawaban --</option>
                                
                                <option value="1">Sangat tidak penting</option>
                                <option value="2" >Tidak penting</option>
                                <option value="3">Netral</option>
                                <option value="4" >Penting</option>
                                <option value="5" >Sangat Penting</option>
                                        
                              </select>
                            </div>
                          </div>
                          <div class="form-group">
                            4. Koneksi internet host lancar selama pelatihan berlangsung
                            <div class="col-sm-12 mt-2">
                              <select class="form-control select2bs4" name="t4" style="width: 100%;">
                                <option value="">-- Pilih Jawaban --</option>
                                
                                <option value="1">Sangat tidak penting</option>
                                <option value="2" >Tidak penting</option>
                                <option value="3">Netral</option>
                                <option value="4" >Penting</option>
                                <option value="5" >Sangat Penting</option>
                                        
                              </select>
                            </div>
                          </div>
                          <div class="form-group">
                            5. Tampilan modul pelatihan menarik untuk dibaca.
                            <div class="col-sm-12 mt-2">
                              <select class="form-control select2bs4" name="t5" style="width: 100%;">
                                <option value="">-- Pilih Jawaban --</option>
                                
                                <option value="1">Sangat tidak penting</option>
                                <option value="2" >Tidak penting</option>
                                <option value="3">Netral</option>
                                <option value="4" >Penting</option>
                                <option value="5" >Sangat Penting</option>
                                        
                              </select>
                            </div>
                          </div>
                          <div class="form-group">
                            6. Trainer berpenampilan rapi.
                            <div class="col-sm-12 mt-2">
                              <select class="form-control select2bs4" name="t6" style="width: 100%;">
                                <option value="">-- Pilih Jawaban --</option>
                                
                                <option value="1">Sangat tidak penting</option>
                                <option value="2" >Tidak penting</option>
                                <option value="3">Netral</option>
                                <option value="4" >Penting</option>
                                <option value="5" >Sangat Penting</option>
                                        
                              </select>
                            </div>
                          </div>



                        </div>
                       <!-- -->


                       <!-- -->
                       <div class="col-lg-12 mt-3 mb-3" style="background-color: #95D5B2">
                        <b>Empathy</b> 
                      </div>
                      
                      
                      <div class="col-lg-12 mt-2">
                        <div class="form-group">
                          1. Trainer memberi perhatian kepada peserta.
                          <div class="col-sm-12 mt-2">
                            <select class="form-control select2bs4" name="e1" style="width: 100%;">
                              <option value="">-- Pilih Jawaban --</option>
                              
                              <option value="1">Sangat tidak penting</option>
                              <option value="2" >Tidak penting</option>
                              <option value="3">Netral</option>
                              <option value="4" >Penting</option>
                              <option value="5" >Sangat Penting</option>
                                      
                            </select>
                          </div>
                        </div>
                        <div class="form-group">
                          2. Trainer memahami kebutuhan peserta.
                          <div class="col-sm-12 mt-2">
                            <select class="form-control select2bs4" name="e2" style="width: 100%;">
                              <option value="">-- Pilih Jawaban --</option>
                              
                              <option value="1">Sangat tidak penting</option>
                              <option value="2" >Tidak penting</option>
                              <option value="3">Netral</option>
                              <option value="4" >Penting</option>
                              <option value="5" >Sangat Penting</option>
                                      
                            </select>
                          </div>
                        </div>
                        <div class="form-group">
                          3. Terjalin komunikasi yang baik antara trainer dengan peserta
                          <div class="col-sm-12 mt-2">
                            <select class="form-control select2bs4" name="e3" style="width: 100%;">
                              <option value="">-- Pilih Jawaban --</option>
                              
                              <option value="1">Sangat tidak penting</option>
                              <option value="2" >Tidak penting</option>
                              <option value="3">Netral</option>
                              <option value="4" >Penting</option>
                              <option value="5" >Sangat Penting</option>
                                      
                            </select>
                          </div>
                        </div>
                        <div class="form-group">
                          4. Trainer berupaya membantu saat peserta mengalami kesulitan
                          <div class="col-sm-12 mt-2">
                            <select class="form-control select2bs4" name="e4" style="width: 100%;">
                              <option value="">-- Pilih Jawaban --</option>
                              
                              <option value="1">Sangat tidak penting</option>
                              <option value="2" >Tidak penting</option>
                              <option value="3">Netral</option>
                              <option value="4" >Penting</option>
                              <option value="5" >Sangat Penting</option>
                                      
                            </select>
                          </div>
                        </div>
                        <div class="form-group">
                          5. Kecukupan waktu yang dialokasikan untuk pelatihan.
                          <div class="col-sm-12 mt-2">
                            <select class="form-control select2bs4" name="e5" style="width: 100%;">
                              <option value="">-- Pilih Jawaban --</option>
                              
                              <option value="1">Sangat tidak penting</option>
                              <option value="2" >Tidak penting</option>
                              <option value="3">Netral</option>
                              <option value="4" >Penting</option>
                              <option value="5" >Sangat Penting</option>
                                      
                            </select>
                          </div>
                        </div>
                        

                      </div>
                     <!-- -->

                     <!-- -->
                     <div class="col-lg-12 mt-3 mb-3" style="background-color: #95D5B2">
                      <b>Responsiveness</b> 
                    </div>
                    
                    
                    <div class="col-lg-12 mt-2">
                      <div class="form-group">
                        1. Kecepatan respon contact person perusahaan dalam menanggapi peserta.
                        <div class="col-sm-12 mt-2">
                          <select class="form-control select2bs4" name="rs1" style="width: 100%;">
                            <option value="">-- Pilih Jawaban --</option>
                            
                            <option value="1">Sangat tidak penting</option>
                            <option value="2" >Tidak penting</option>
                            <option value="3">Netral</option>
                            <option value="4" >Penting</option>
                            <option value="5" >Sangat Penting</option>
                                    
                          </select>
                        </div>
                      </div>
                      <div class="form-group">
                        2. Kepastian informasi mengenai jadwal pelatihan
                        <div class="col-sm-12 mt-2">
                          <select class="form-control select2bs4" name="rs2" style="width: 100%;">
                            <option value="">-- Pilih Jawaban --</option>
                            
                            <option value="1">Sangat tidak penting</option>
                            <option value="2" >Tidak penting</option>
                            <option value="3">Netral</option>
                            <option value="4" >Penting</option>
                            <option value="5" >Sangat Penting</option>
                                    
                          </select>
                        </div>
                      </div>
                      

                    </div>
                   <!-- -->


                   <!-- -->
                   <div class="col-lg-12 mt-3 mb-3" style="background-color: #95D5B2">
                    <b>Applicability</b> 
                  </div>
                  
                  
                  <div class="col-lg-12 mt-2">
                    <div class="form-group">
                      1. Pelatihan berkaitan langsung dengan pekerjaan saya
                      <div class="col-sm-12 mt-2">
                        <select class="form-control select2bs4" name="ap1" style="width: 100%;">
                          <option value="">-- Pilih Jawaban --</option>
                          
                          <option value="1">Sangat tidak penting</option>
                          <option value="2" >Tidak penting</option>
                          <option value="3">Netral</option>
                          <option value="4" >Penting</option>
                          <option value="5" >Sangat Penting</option>
                                  
                        </select>
                      </div>
                    </div>
                    <div class="form-group">
                      2. Pelatihan yang diberikan mudah untuk diterapkan dalam pekerjaan
                      <div class="col-sm-12 mt-2">
                        <select class="form-control select2bs4" name="ap2" style="width: 100%;">
                          <option value="">-- Pilih Jawaban --</option>
                          
                          <option value="1">Sangat tidak penting</option>
                          <option value="2" >Tidak penting</option>
                          <option value="3">Netral</option>
                          <option value="4" >Penting</option>
                          <option value="5" >Sangat Penting</option>
                                  
                        </select>
                      </div>
                    </div>
                                    
                    

                  </div>
                 <!-- -->



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
