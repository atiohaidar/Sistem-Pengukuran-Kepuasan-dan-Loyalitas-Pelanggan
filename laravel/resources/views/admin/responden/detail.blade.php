@extends('layouts.master')
@section('judul','Detail Responden')

@section('content')

<section class="content">
  <div class="container-fluid">
      
      <div class="row">
        <div class="col-12">
          <div class="card card-primary">
                <div class="card-header">
                  <h3 class="card-title"><b>Detail </b></h3>
                  
                </div>
                <div class="card-body">
                  <center><h2>PROFIL RESPONDEN</h2></center>
                <table class="table table-striped ">
                    
                    <tbody>
                    <tr>
                      
                      <td width="100%">
                          <table class="table table-bordered  table-sm">
                            
                            <tbody>
                              <tr>
                                <td width="15%">Nama Bisnis</td>
                                <td width="3%">:</td>
                                <td width="20%">{{ $data->bisnis->nama_bisnis }}</td>
                                <td width="10%">Email</td>
                                <td width="3%">:</td>
                                <td>{{ $data->email }}</td>
                              </tr>
                              <tr>
                                <td width="15%">WhatsApp</td>
                                <td width="3%">:</td>
                                <td width="20%">{{ $data->whatsapp }}</td>
                                <td width="10%">Jenis Kelamin</td>
                                <td width="3%">:</td>
                                <td>{{ $data->jk }}</td>
                              </tr>
                              <tr>
                                <td width="15%">Usia</td>
                                <td width="3%">:</td>
                                <td width="20%">{{ $data->usia }}</td>
                                <td width="10%">Pekerjaan</td>
                                <td width="3%">:</td>
                                <td>{{ $data->pekerjaan }} [{{ $data->pekerjaan_lain }}]</td>
                              </tr>
                              <tr>
                                <td width="15%">Domisili</td>
                                <td width="3%">:</td>
                                <td width="20%">{{ $data->domi->title }}</td>
                                <td width="10%"></td>
                                <td width="3%"></td>
                                <td></td>
                              </tr>

                              
                              
                              
                            </tbody>
                          </table>
                      </td>
                    </tr>
                    </tbody>
                    
                    
                  </table>
                </div>
                
              </div>
            </div>
      </div>


      <div class="row">
        <div class="col-12">
          <div class="card">
                
                <div class="card-body">
                  <div class="card card-primary card-tabs">
                      <div class="card-header p-0 pt-1">
                        <ul class="nav nav-tabs nav-fill" id="custom-tabs-one-tab" role="tablist">
                          <li class="nav-item">
                            <a class="nav-link active" id="custom-tabs-one-home-tab" data-toggle="pill" href="#custom-tabs-one-home" role="tab" aria-controls="custom-tabs-one-home" aria-selected="true">1.</a>
                          </li>
                          <li class="nav-item">
                            <a class="nav-link" id="custom-tabs-one-profile-tab" data-toggle="pill" href="#custom-tabs-one-profile" role="tab" aria-controls="custom-tabs-one-profile" aria-selected="false">2.</a>
                          </li>
                          <li class="nav-item">
                            <a class="nav-link" id="custom-tabs-one-profile-tab1" data-toggle="pill" href="#custom-tabs-one-profile1" role="tab" aria-controls="custom-tabs-one-profile1" aria-selected="false">3.</a>
                          </li>
                          <li class="nav-item">
                            <a class="nav-link" id="custom-tabs-one-profile-tab2" data-toggle="pill" href="#custom-tabs-one-profile2" role="tab" aria-controls="custom-tabs-one-profile2" aria-selected="false">4.</a>
                          </li>
                          <li class="nav-item">
                            <a class="nav-link" id="custom-tabs-one-profile-tab3" data-toggle="pill" href="#custom-tabs-one-profile3" role="tab" aria-controls="custom-tabs-one-profile3" aria-selected="false">5.</a>
                          </li>

                         
                        </ul>
                      </div>
                      <div class="card-body table-responsive p-1" style="height: 300px;">
                        <div class="tab-content" id="custom-tabs-one-tabContent">
                          <div class="tab-pane fade show active" id="custom-tabs-one-home" role="tabpanel" aria-labelledby="custom-tabs-one-home-tab">
                            <center>
                            <br>
                            <b>Penilaian Tingkat Kepentingan/Harapan</b>
                            </center>
                            <div class="row">
                              <!-- -->
                                <div class="col-lg-12 mt-3 mb-3" style="background-color: rgb(11, 248, 31)">
                                  <b>Reliability</b>
                                </div>
                                
                                
                                <div class="col-lg-12 mt-2">
                                  @foreach ($jawaban_realibility1 as $dt)
                                  <div class="form-group">
                                      1. Kesesuaian isi post test dengan materi pelatihan yang diberikan.
                                      <div class="col-sm-12 mt-2">
                                      <select class="form-control select2bs4" disabled name="r1" style="width: 100%;">
                                        <option value="">-- Pilih Jawaban --</option>
                                        
                                        <option value="1" <?php if($dt->r1 == '1'){ echo 'selected';} ?>>Sangat tidak penting</option>
                                        <option value="2" <?php if($dt->r1 == '2'){ echo 'selected';} ?>>Tidak penting</option>
                                        <option value="3" <?php if($dt->r1 == '3'){ echo 'selected';} ?>>Netral</option>
                                        <option value="4" <?php if($dt->r1 == '4'){ echo 'selected';} ?>>Penting</option>
                                        <option value="5" <?php if($dt->r1 == '5'){ echo 'selected';} ?>>Sangat Penting</option>
                                                
                                      </select>
                                    </div>
                                  </div>
                                  <div class="form-group">
                                    2. Ketepatan waktu pelatihan sesuai dengan jadwal yang telah dijanjikan.
                                    <div class="col-sm-12 mt-2">
                                      <select class="form-control select2bs4" disabled name="r2" style="width: 100%;">
                                        <option value="">-- Pilih Jawaban --</option>
                                        
                                        <option value="1" <?php if($dt->r2 == '1'){ echo 'selected';} ?>>Sangat tidak penting</option>
                                        <option value="2" <?php if($dt->r2 == '2'){ echo 'selected';} ?>>Tidak penting</option>
                                        <option value="3" <?php if($dt->r2 == '3'){ echo 'selected';} ?>>Netral</option>
                                        <option value="4" <?php if($dt->r2 == '4'){ echo 'selected';} ?>>Penting</option>
                                        <option value="5" <?php if($dt->r2 == '5'){ echo 'selected';} ?>>Sangat Penting</option>
                                                
                                      </select>
                                    </div>
                                  </div>
                                  <div class="form-group">
                                    3. Ketepatan waktu dalam memberikan sertifikat pelatihan
                                    <div class="col-sm-12 mt-2">
                                      <select class="form-control select2bs4" disabled name="r3" style="width: 100%;">
                                        <option value="">-- Pilih Jawaban --</option>
                                        
                                        <option value="1" <?php if($dt->r3 == '1'){ echo 'selected';} ?>>Sangat tidak penting</option>
                                        <option value="2" <?php if($dt->r3 == '2'){ echo 'selected';} ?>>Tidak penting</option>
                                        <option value="3" <?php if($dt->r3 == '3'){ echo 'selected';} ?>>Netral</option>
                                        <option value="4" <?php if($dt->r3 == '4'){ echo 'selected';} ?>>Penting</option>
                                        <option value="5" <?php if($dt->r3 == '5'){ echo 'selected';} ?>>Sangat Penting</option>
                                                
                                      </select>
                                    </div>
                                  </div>
      
                                  <div class="form-group">
                                    4. Ketepatan trainer dalam menjawab pertanyaan peserta.
                                    <div class="col-sm-12 mt-2">
                                      <select class="form-control select2bs4" disabled name="r4" style="width: 100%;">
                                        <option value="">-- Pilih Jawaban --</option>
                                        
                                        <option value="1" <?php if($dt->r4 == '1'){ echo 'selected';} ?>>Sangat tidak penting</option>
                                        <option value="2" <?php if($dt->r4 == '2'){ echo 'selected';} ?>>Tidak penting</option>
                                        <option value="3" <?php if($dt->r4 == '3'){ echo 'selected';} ?>>Netral</option>
                                        <option value="4" <?php if($dt->r4 == '4'){ echo 'selected';} ?>>Penting</option>
                                        <option value="5" <?php if($dt->r4 == '5'){ echo 'selected';} ?>>Sangat Penting</option>
                                                
                                      </select>
                                    </div>
                                  </div>
      
                                  <div class="form-group">
                                    5. Materi pelatihan mudah dimengerti.
                                    <div class="col-sm-12 mt-2">
                                      <select class="form-control select2bs4" disabled name="r5" style="width: 100%;">
                                        <option value="">-- Pilih Jawaban --</option>
                                        
                                        <option value="1" <?php if($dt->r5 == '1'){ echo 'selected';} ?>>Sangat tidak penting</option>
                                        <option value="2" <?php if($dt->r5 == '2'){ echo 'selected';} ?>>Tidak penting</option>
                                        <option value="3" <?php if($dt->r5 == '3'){ echo 'selected';} ?>>Netral</option>
                                        <option value="4" <?php if($dt->r5 == '4'){ echo 'selected';} ?>>Penting</option>
                                        <option value="5" <?php if($dt->r5 == '5'){ echo 'selected';} ?>>Sangat Penting</option>
                                                
                                      </select>
                                    </div>
                                  </div>
                                  <div class="form-group">
                                    6. Kemudahan dalam melakukan registrasi pelatihan
                                    <div class="col-sm-12 mt-2">
                                      <select class="form-control select2bs4" disabled name="r6" style="width: 100%;">
                                        <option value="">-- Pilih Jawaban --</option>
                                        
                                        <option value="1" <?php if($dt->r6 == '1'){ echo 'selected';} ?>>Sangat tidak penting</option>
                                        <option value="2" <?php if($dt->r6 == '2'){ echo 'selected';} ?>>Tidak penting</option>
                                        <option value="3" <?php if($dt->r6 == '3'){ echo 'selected';} ?>>Netral</option>
                                        <option value="4" <?php if($dt->r6 == '4'){ echo 'selected';} ?>>Penting</option>
                                        <option value="5" <?php if($dt->r6 == '5'){ echo 'selected';} ?>>Sangat Penting</option>
                                                
                                      </select>
                                    </div>
                                  </div>
                                  <div class="form-group">
                                    7. Kemudahan dalam melakukan pembayaran pelatihan
                                    <div class="col-sm-12 mt-2">
                                      <select class="form-control select2bs4" disabled name="r7" style="width: 100%;">
                                        <option value="">-- Pilih Jawaban --</option>
                                        
                                        <option value="1" <?php if($dt->r7 == '1'){ echo 'selected';} ?>>Sangat tidak penting</option>
                                        <option value="2" <?php if($dt->r7 == '2'){ echo 'selected';} ?>>Tidak penting</option>
                                        <option value="3" <?php if($dt->r7 == '3'){ echo 'selected';} ?>>Netral</option>
                                        <option value="4" <?php if($dt->r7 == '4'){ echo 'selected';} ?>>Penting</option>
                                        <option value="5" <?php if($dt->r7 == '5'){ echo 'selected';} ?>>Sangat Penting</option>
                                                
                                      </select>
                                    </div>
                                  </div>
      
                                  @endforeach
      
      
                                </div>
                                
      
                                <!-- -->
                                <div class="col-lg-12 mt-3 mb-3" style="background-color: rgb(11, 248, 31)">
                                  <b>Assurance</b> 
                                </div>
                                
                                
                                <div class="col-lg-12 mt-2">
                                  @foreach ($jawaban_assurance1 as $dt)
                                  <div class="form-group">
                                    1. Trainer/pegawai bersikap sopan.
                                    <div class="col-sm-12 mt-2">
                                      <select class="form-control select2bs4" disabled name="a1" style="width: 100%;">
                                        <option value="">-- Pilih Jawaban --</option>
                                        
                                        <option value="1" <?php if($dt->a1 == '1'){ echo 'selected';} ?>>Sangat tidak penting</option>
                                        <option value="2" <?php if($dt->a1 == '2'){ echo 'selected';} ?>>Tidak penting</option>
                                        <option value="3" <?php if($dt->a1 == '3'){ echo 'selected';} ?>>Netral</option>
                                        <option value="4" <?php if($dt->a1 == '4'){ echo 'selected';} ?>>Penting</option>
                                        <option value="5" <?php if($dt->a1 == '5'){ echo 'selected';} ?>>Sangat Penting</option>
                                                
                                      </select>
                                    </div>
                                  </div>
                                  <div class="form-group">
                                    2. Trainer memiliki pengetahuan yang luas mengenai materi pelatihan
                                    <div class="col-sm-12 mt-2">
                                      <select class="form-control select2bs4" disabled name="a2" style="width: 100%;">
                                        <option value="">-- Pilih Jawaban --</option>
                                        
                                        <option value="1" <?php if($dt->a2 == '1'){ echo 'selected';} ?>>Sangat tidak penting</option>
                                        <option value="2" <?php if($dt->a2 == '2'){ echo 'selected';} ?>>Tidak penting</option>
                                        <option value="3" <?php if($dt->a2 == '3'){ echo 'selected';} ?>>Netral</option>
                                        <option value="4" <?php if($dt->a2 == '4'){ echo 'selected';} ?>>Penting</option>
                                        <option value="5" <?php if($dt->a2 == '5'){ echo 'selected';} ?>>Sangat Penting</option>
                                                
                                      </select>
                                    </div>
                                  </div>
                                  <div class="form-group">
                                    3. Trainer mampu menyampaikan materi pelatihan dengan cara yang mudah dipahami.
                                    <div class="col-sm-12 mt-2">
                                      <select class="form-control select2bs4" disabled name="a3" style="width: 100%;">
                                        <option value="">-- Pilih Jawaban --</option>
                                        
                                        <option value="1" <?php if($dt->a3 == '1'){ echo 'selected';} ?>>Sangat tidak penting</option>
                                        <option value="2" <?php if($dt->a3 == '2'){ echo 'selected';} ?>>Tidak penting</option>
                                        <option value="3" <?php if($dt->a3 == '3'){ echo 'selected';} ?>>Netral</option>
                                        <option value="4" <?php if($dt->a3 == '4'){ echo 'selected';} ?>>Penting</option>
                                        <option value="5" <?php if($dt->a3 == '5'){ echo 'selected';} ?>>Sangat Penting</option>
                                                
                                      </select>
                                    </div>
                                  </div>
                                  <div class="form-group">
                                    4. Committee service selalu dapat menyelesaikan keluhan pelanggan
                                    <div class="col-sm-12 mt-2">
                                      <select class="form-control select2bs4" disabled name="a4" style="width: 100%;">
                                        <option value="">-- Pilih Jawaban --</option>
                                        
                                        <option value="1" <?php if($dt->a4 == '1'){ echo 'selected';} ?>>Sangat tidak penting</option>
                                        <option value="2" <?php if($dt->a4 == '2'){ echo 'selected';} ?>>Tidak penting</option>
                                        <option value="3" <?php if($dt->a4 == '3'){ echo 'selected';} ?>>Netral</option>
                                        <option value="4" <?php if($dt->a4 == '4'){ echo 'selected';} ?>>Penting</option>
                                        <option value="5" <?php if($dt->a4 == '5'){ echo 'selected';} ?>>Sangat Penting</option>
                                                
                                      </select>
                                    </div>
                                  </div>
                                  
                                  @endforeach
      
                                </div>
                               <!-- -->
      
                               <!-- -->
                               <div class="col-lg-12 mt-3 mb-3" style="background-color: rgb(11, 248, 31)">
                                <b>Tangible</b> 
                              </div>
                              
                              
                              <div class="col-lg-12 mt-2">
                                @foreach ($jawaban_tangible1 as $dt)
                                <div class="form-group">
                                  1. Sistem aplikasi pelatihan online yang user friendly.
                                  <div class="col-sm-12 mt-2">
                                    <select class="form-control select2bs4" disabled name="t1" style="width: 100%;">
                                      <option value="">-- Pilih Jawaban --</option>
                                      
                                      <option value="1" <?php if($dt->t1 == '1'){ echo 'selected';} ?>>Sangat tidak penting</option>
                                        <option value="2" <?php if($dt->t1 == '2'){ echo 'selected';} ?>>Tidak penting</option>
                                        <option value="3" <?php if($dt->t1 == '3'){ echo 'selected';} ?>>Netral</option>
                                        <option value="4" <?php if($dt->t1 == '4'){ echo 'selected';} ?>>Penting</option>
                                        <option value="5" <?php if($dt->t1 == '5'){ echo 'selected';} ?>>Sangat Penting</option>
                                              
                                    </select>
                                  </div>
                                </div>
                                <div class="form-group">
                                  2. Website menampilkan informasi terbaru.
                                  <div class="col-sm-12 mt-2">
                                    <select class="form-control select2bs4" disabled name="t2" style="width: 100%;">
                                      <option value="">-- Pilih Jawaban --</option>
                                      
                                      <option value="1" <?php if($dt->t2 == '1'){ echo 'selected';} ?>>Sangat tidak penting</option>
                                        <option value="2" <?php if($dt->t2 == '2'){ echo 'selected';} ?>>Tidak penting</option>
                                        <option value="3" <?php if($dt->t2 == '3'){ echo 'selected';} ?>>Netral</option>
                                        <option value="4" <?php if($dt->t2 == '4'){ echo 'selected';} ?>>Penting</option>
                                        <option value="5" <?php if($dt->t2 == '5'){ echo 'selected';} ?>>Sangat Penting</option>
                                              
                                    </select>
                                  </div>
                                </div>
                                <div class="form-group">
                                  3. Perlengkapan audio visual berfungsi dengan baik
                                  <div class="col-sm-12 mt-2">
                                    <select class="form-control select2bs4" disabled name="t3" style="width: 100%;">
                                      <option value="">-- Pilih Jawaban --</option>
                                      
                                      <option value="1" <?php if($dt->t3 == '1'){ echo 'selected';} ?>>Sangat tidak penting</option>
                                        <option value="2" <?php if($dt->t3 == '2'){ echo 'selected';} ?>>Tidak penting</option>
                                        <option value="3" <?php if($dt->t3 == '3'){ echo 'selected';} ?>>Netral</option>
                                        <option value="4" <?php if($dt->t3 == '4'){ echo 'selected';} ?>>Penting</option>
                                        <option value="5" <?php if($dt->t3 == '5'){ echo 'selected';} ?>>Sangat Penting</option>
                                              
                                    </select>
                                  </div>
                                </div>
                                <div class="form-group">
                                  4. Koneksi internet host lancar selama pelatihan berlangsung
                                  <div class="col-sm-12 mt-2">
                                    <select class="form-control select2bs4" disabled name="t4" style="width: 100%;">
                                      <option value="">-- Pilih Jawaban --</option>
                                      
                                      <option value="1" <?php if($dt->t4 == '1'){ echo 'selected';} ?>>Sangat tidak penting</option>
                                        <option value="2" <?php if($dt->t4 == '2'){ echo 'selected';} ?>>Tidak penting</option>
                                        <option value="3" <?php if($dt->t4 == '3'){ echo 'selected';} ?>>Netral</option>
                                        <option value="4" <?php if($dt->t4 == '4'){ echo 'selected';} ?>>Penting</option>
                                        <option value="5" <?php if($dt->t4 == '5'){ echo 'selected';} ?>>Sangat Penting</option>
                                              
                                    </select>
                                  </div>
                                </div>
                                <div class="form-group">
                                  5. Tampilan modul pelatihan menarik untuk dibaca.
                                  <div class="col-sm-12 mt-2">
                                    <select class="form-control select2bs4" disabled name="t5" style="width: 100%;">
                                      <option value="">-- Pilih Jawaban --</option>
                                      
                                      <option value="1" <?php if($dt->t5 == '1'){ echo 'selected';} ?>>Sangat tidak penting</option>
                                        <option value="2" <?php if($dt->t5 == '2'){ echo 'selected';} ?>>Tidak penting</option>
                                        <option value="3" <?php if($dt->t5 == '3'){ echo 'selected';} ?>>Netral</option>
                                        <option value="4" <?php if($dt->t5 == '4'){ echo 'selected';} ?>>Penting</option>
                                        <option value="5" <?php if($dt->t5 == '5'){ echo 'selected';} ?>>Sangat Penting</option>
                                              
                                    </select>
                                  </div>
                                </div>
                                <div class="form-group">
                                  6. Trainer berpenampilan rapi.
                                  <div class="col-sm-12 mt-2">
                                    <select class="form-control select2bs4" disabled name="t6" style="width: 100%;">
                                      <option value="">-- Pilih Jawaban --</option>
                                      
                                      <option value="1" <?php if($dt->t6 == '1'){ echo 'selected';} ?>>Sangat tidak penting</option>
                                        <option value="2" <?php if($dt->t6 == '2'){ echo 'selected';} ?>>Tidak penting</option>
                                        <option value="3" <?php if($dt->t6 == '3'){ echo 'selected';} ?>>Netral</option>
                                        <option value="4" <?php if($dt->t6 == '4'){ echo 'selected';} ?>>Penting</option>
                                        <option value="5" <?php if($dt->t6 == '5'){ echo 'selected';} ?>>Sangat Penting</option>
                                              
                                    </select>
                                  </div>
                                </div>
                                @endforeach
      
      
                              </div>
                             <!-- -->
      
      
                             <!-- -->
                             <div class="col-lg-12 mt-3 mb-3" style="background-color: rgb(11, 248, 31)">
                              <b>Empathy</b> 
                            </div>
                            
                            
                            <div class="col-lg-12 mt-2">
                              @foreach ($jawaban_empathy1 as $dt)
                              <div class="form-group">
                                1. Trainer memberi perhatian kepada peserta
                                <div class="col-sm-12 mt-2">
                                  <select class="form-control select2bs4" disabled name="e1" style="width: 100%;">
                                    <option value="">-- Pilih Jawaban --</option>
                                    
                                    <option value="1" <?php if($dt->e1 == '1'){ echo 'selected';} ?>>Sangat tidak penting</option>
                                        <option value="2" <?php if($dt->e1 == '2'){ echo 'selected';} ?>>Tidak penting</option>
                                        <option value="3" <?php if($dt->e1 == '3'){ echo 'selected';} ?>>Netral</option>
                                        <option value="4" <?php if($dt->e1 == '4'){ echo 'selected';} ?>>Penting</option>
                                        <option value="5" <?php if($dt->e1 == '5'){ echo 'selected';} ?>>Sangat Penting</option>
                                            
                                  </select>
                                </div>
                              </div>
                              <div class="form-group">
                                2. Trainer memahami kebutuhan peserta.
                                <div class="col-sm-12 mt-2">
                                  <select class="form-control select2bs4" disabled name="e2" style="width: 100%;">
                                    <option value="">-- Pilih Jawaban --</option>
                                    
                                    <option value="1" <?php if($dt->e2 == '1'){ echo 'selected';} ?>>Sangat tidak penting</option>
                                        <option value="2" <?php if($dt->e2 == '2'){ echo 'selected';} ?>>Tidak penting</option>
                                        <option value="3" <?php if($dt->e2 == '3'){ echo 'selected';} ?>>Netral</option>
                                        <option value="4" <?php if($dt->e2 == '4'){ echo 'selected';} ?>>Penting</option>
                                        <option value="5" <?php if($dt->e2 == '5'){ echo 'selected';} ?>>Sangat Penting</option>
                                            
                                  </select>
                                </div>
                              </div>
                              <div class="form-group">
                                3. Terjalin komunikasi yang baik antara trainer dengan peserta
                                <div class="col-sm-12 mt-2">
                                  <select class="form-control select2bs4" disabled name="e3" style="width: 100%;">
                                    <option value="">-- Pilih Jawaban --</option>
                                    
                                    <option value="1" <?php if($dt->e3 == '1'){ echo 'selected';} ?>>Sangat tidak penting</option>
                                        <option value="2" <?php if($dt->e3 == '2'){ echo 'selected';} ?>>Tidak penting</option>
                                        <option value="3" <?php if($dt->e3 == '3'){ echo 'selected';} ?>>Netral</option>
                                        <option value="4" <?php if($dt->e3 == '4'){ echo 'selected';} ?>>Penting</option>
                                        <option value="5" <?php if($dt->e3 == '5'){ echo 'selected';} ?>>Sangat Penting</option>
                                            
                                  </select>
                                </div>
                              </div>
                              <div class="form-group">
                                4. Trainer berupaya membantu saat peserta mengalami kesulitan
                                <div class="col-sm-12 mt-2">
                                  <select class="form-control select2bs4" disabled name="e4" style="width: 100%;">
                                    <option value="">-- Pilih Jawaban --</option>
                                    
                                    <option value="1" <?php if($dt->e4 == '1'){ echo 'selected';} ?>>Sangat tidak penting</option>
                                    <option value="2" <?php if($dt->e4 == '2'){ echo 'selected';} ?>>Tidak penting</option>
                                    <option value="3" <?php if($dt->e4 == '3'){ echo 'selected';} ?>>Netral</option>
                                    <option value="4" <?php if($dt->e4 == '4'){ echo 'selected';} ?>>Penting</option>
                                    <option value="5" <?php if($dt->e4 == '5'){ echo 'selected';} ?>>Sangat Penting</option>
                                            
                                  </select>
                                </div>
                              </div>
                              <div class="form-group">
                                5. Kecukupan waktu yang dialokasikan untuk pelatihan.
                                <div class="col-sm-12 mt-2">
                                  <select class="form-control select2bs4" disabled name="e5" style="width: 100%;">
                                    <option value="">-- Pilih Jawaban --</option>
                                    
                                    <option value="1" <?php if($dt->e5 == '1'){ echo 'selected';} ?>>Sangat tidak penting</option>
                                    <option value="2" <?php if($dt->e5 == '2'){ echo 'selected';} ?>>Tidak penting</option>
                                    <option value="3" <?php if($dt->e5 == '3'){ echo 'selected';} ?>>Netral</option>
                                    <option value="4" <?php if($dt->e5 == '4'){ echo 'selected';} ?>>Penting</option>
                                    <option value="5" <?php if($dt->e5 == '5'){ echo 'selected';} ?>>Sangat Penting</option>
                                            
                                  </select>
                                </div>
                              </div>
                              
                              @endforeach
      
      
                            </div>
                          </div>
                           <!-- -->
                           <!-- -->
                            <div class="col-lg-12 mt-3 mb-3" style="background-color: rgb(11, 248, 31)">
                                <b>Responsiveness</b> 
                              </div>
                              
                              
                              <div class="col-lg-12 mt-2">
                                @foreach ($jawaban_responsiveness1 as $dt)
                                <div class="form-group">
                                  1. Kecepatan respon contact person perusahaan dalam menanggapi peserta.
                                  <div class="col-sm-12 mt-2">
                                    <select class="form-control select2bs4" disabled name="rs1" style="width: 100%;">
                                      <option value="">-- Pilih Jawaban --</option>
                                      
                                      <option value="1" <?php if($dt->rs1 == '1'){ echo 'selected';} ?>>Sangat tidak penting</option>
                                    <option value="2" <?php if($dt->rs1 == '2'){ echo 'selected';} ?>>Tidak penting</option>
                                    <option value="3" <?php if($dt->rs1 == '3'){ echo 'selected';} ?>>Netral</option>
                                    <option value="4" <?php if($dt->rs1 == '4'){ echo 'selected';} ?>>Penting</option>
                                    <option value="5" <?php if($dt->rs1 == '5'){ echo 'selected';} ?>>Sangat Penting</option>
                                              
                                    </select>
                                  </div>
                                </div>
                                <div class="form-group">
                                  2. Kepastian informasi mengenai jadwal pelatihan
                                  <div class="col-sm-12 mt-2">
                                    <select class="form-control select2bs4" disabled name="rs2" style="width: 100%;">
                                      <option value="">-- Pilih Jawaban --</option>
                                      
                                      <option value="1" <?php if($dt->rs2 == '1'){ echo 'selected';} ?>>Sangat tidak penting</option>
                                    <option value="2" <?php if($dt->rs2 == '2'){ echo 'selected';} ?>>Tidak penting</option>
                                    <option value="3" <?php if($dt->rs2 == '3'){ echo 'selected';} ?>>Netral</option>
                                    <option value="4" <?php if($dt->rs2 == '4'){ echo 'selected';} ?>>Penting</option>
                                    <option value="5" <?php if($dt->rs2 == '5'){ echo 'selected';} ?>>Sangat Penting</option>
                                              
                                    </select>
                                  </div>
                                </div>
                                
                                @endforeach

                              </div>
                   <!-- -->

                   <!-- -->
                    <div class="col-lg-12 mt-3 mb-3" style="background-color: rgb(11, 248, 31)">
                        <b>Applicability</b> 
                      </div>
                      
                      
                      <div class="col-lg-12 mt-2">
                        @foreach ($jawaban_relevance1 as $dt)
                        <div class="form-group">
                          1. Pelatihan berkaitan langsung dengan pekerjaan saya
                          <div class="col-sm-12 mt-2">
                            <select class="form-control select2bs4" disabled name="ap1" style="width: 100%;">
                              <option value="">-- Pilih Jawaban --</option>
                              
                              <option value="1" <?php if($dt->ap1 == '1'){ echo 'selected';} ?>>Sangat tidak penting</option>
                                    <option value="2" <?php if($dt->ap1 == '2'){ echo 'selected';} ?>>Tidak penting</option>
                                    <option value="3" <?php if($dt->ap1 == '3'){ echo 'selected';} ?>>Netral</option>
                                    <option value="4" <?php if($dt->ap1 == '4'){ echo 'selected';} ?>>Penting</option>
                                    <option value="5" <?php if($dt->ap1 == '5'){ echo 'selected';} ?>>Sangat Penting</option>
                                      
                            </select>
                          </div>
                        </div>
                        <div class="form-group">
                          2. Pelatihan yang diberikan mudah untuk diterapkan dalam pekerjaan
                          <div class="col-sm-12 mt-2">
                            <select class="form-control select2bs4" disabled name="ap2" style="width: 100%;">
                              <option value="">-- Pilih Jawaban --</option>
                              
                              <option value="1" <?php if($dt->ap2 == '1'){ echo 'selected';} ?>>Sangat tidak penting</option>
                                    <option value="2" <?php if($dt->ap2 == '2'){ echo 'selected';} ?>>Tidak penting</option>
                                    <option value="3" <?php if($dt->ap2 == '3'){ echo 'selected';} ?>>Netral</option>
                                    <option value="4" <?php if($dt->ap2 == '4'){ echo 'selected';} ?>>Penting</option>
                                    <option value="5" <?php if($dt->ap2 == '5'){ echo 'selected';} ?>>Sangat Penting</option>
                                      
                            </select>
                          </div>
                        </div>
                        
                        
                        @endforeach
                        

                      </div>
                    <!-- -->
                            
                          </div>
                          <!------------------------------------------------------------------------>

                          <div class="tab-pane fade" id="custom-tabs-one-profile" role="tabpanel" aria-labelledby="custom-tabs-one-profile-tab">
                             
                              <center>
                                <br>
                                <b> Penilaian persepsi</b>
                                </center>
                                <div class="row">
                                  <!-- -->
                                    <div class="col-lg-12 mt-3 mb-3" style="background-color: rgb(11, 248, 31)">
                                      <b>Reliability</b>
                                    </div>
                                    
                                    
                                    <div class="col-lg-12 mt-2">
                                      @foreach ($jawaban_realibility2 as $dt)
                                      <div class="form-group">
                                        1. Kesesuaian isi post test dengan materi pelatihan yang diberikan.
                                        <div class="col-sm-12 mt-2">
                                        <select class="form-control select2bs4" disabled name="r1" style="width: 100%;">
                                          <option value="">-- Pilih Jawaban --</option>
                                          
                                          <option value="1" <?php if($dt->r1 == '1'){ echo 'selected';} ?>>Sangat tidak sesuai</option>
                                          <option value="2" <?php if($dt->r1 == '2'){ echo 'selected';} ?>>Tidak sesuai</option>
                                          <option value="3" <?php if($dt->r1 == '3'){ echo 'selected';} ?>>Netral</option>
                                          <option value="4" <?php if($dt->r1 == '4'){ echo 'selected';} ?>>sesuai</option>
                                          <option value="5" <?php if($dt->r1 == '5'){ echo 'selected';} ?>>Sangat sesuai</option>
                                                  
                                        </select>
                                      </div>
                                    </div>
                                    <div class="form-group">
                                      2. Ketepatan waktu pelatihan sesuai dengan jadwal yang telah dijanjikan.
                                      <div class="col-sm-12 mt-2">
                                        <select class="form-control select2bs4" disabled name="r2" style="width: 100%;">
                                          <option value="">-- Pilih Jawaban --</option>
                                          
                                          <option value="1" <?php if($dt->r2 == '1'){ echo 'selected';} ?>>Sangat tidak sesuai</option>
                                          <option value="2" <?php if($dt->r2 == '2'){ echo 'selected';} ?>>Tidak sesuai</option>
                                          <option value="3" <?php if($dt->r2 == '3'){ echo 'selected';} ?>>Netral</option>
                                          <option value="4" <?php if($dt->r2 == '4'){ echo 'selected';} ?>>sesuai</option>
                                          <option value="5" <?php if($dt->r2 == '5'){ echo 'selected';} ?>>Sangat sesuai</option>
                                                  
                                        </select>
                                      </div>
                                    </div>
                                    <div class="form-group">
                                      3. Ketepatan waktu dalam memberikan sertifikat pelatihan
                                      <div class="col-sm-12 mt-2">
                                        <select class="form-control select2bs4" disabled name="r3" style="width: 100%;">
                                          <option value="">-- Pilih Jawaban --</option>
                                          
                                          <option value="1" <?php if($dt->r3 == '1'){ echo 'selected';} ?>>Sangat tidak sesuai</option>
                                          <option value="2" <?php if($dt->r3 == '2'){ echo 'selected';} ?>>Tidak sesuai</option>
                                          <option value="3" <?php if($dt->r3 == '3'){ echo 'selected';} ?>>Netral</option>
                                          <option value="4" <?php if($dt->r3 == '4'){ echo 'selected';} ?>>sesuai</option>
                                          <option value="5" <?php if($dt->r3 == '5'){ echo 'selected';} ?>>Sangat sesuai</option>
                                                  
                                        </select>
                                      </div>
                                    </div>
        
                                    <div class="form-group">
                                      4. Ketepatan trainer dalam menjawab pertanyaan peserta
                                      <div class="col-sm-12 mt-2">
                                        <select class="form-control select2bs4" disabled name="r4" style="width: 100%;">
                                          <option value="">-- Pilih Jawaban --</option>
                                          
                                          <option value="1" <?php if($dt->r4 == '1'){ echo 'selected';} ?>>Sangat tidak sesuai</option>
                                            <option value="2" <?php if($dt->r4 == '2'){ echo 'selected';} ?>>Tidak sesuai</option>
                                            <option value="3" <?php if($dt->r4 == '3'){ echo 'selected';} ?>>Netral</option>
                                            <option value="4" <?php if($dt->r4 == '4'){ echo 'selected';} ?>>sesuai</option>
                                            <option value="5" <?php if($dt->r4 == '5'){ echo 'selected';} ?>>Sangat sesuai</option>
                                                  
                                        </select>
                                      </div>
                                    </div>
        
                                    <div class="form-group">
                                      5. Materi pelatihan mudah dimengerti.
                                      <div class="col-sm-12 mt-2">
                                        <select class="form-control select2bs4" disabled name="r5" style="width: 100%;">
                                          <option value="">-- Pilih Jawaban --</option>
                                          
                                          <option value="1" <?php if($dt->r5 == '1'){ echo 'selected';} ?>>Sangat tidak sesuai</option>
                                            <option value="2" <?php if($dt->r5 == '2'){ echo 'selected';} ?>>Tidak sesuai</option>
                                            <option value="3" <?php if($dt->r5 == '3'){ echo 'selected';} ?>>Netral</option>
                                            <option value="4" <?php if($dt->r5 == '4'){ echo 'selected';} ?>>sesuai</option>
                                            <option value="5" <?php if($dt->r5 == '5'){ echo 'selected';} ?>>Sangat sesuai</option>
                                                  
                                        </select>
                                      </div>
                                    </div>
                                    <div class="form-group">
                                      6. Kemudahan dalam melakukan registrasi pelatihan
                                      <div class="col-sm-12 mt-2">
                                        <select class="form-control select2bs4" disabled name="r6" style="width: 100%;">
                                          <option value="">-- Pilih Jawaban --</option>
                                          
                                            <option value="1" <?php if($dt->r6 == '1'){ echo 'selected';} ?>>Sangat tidak sesuai</option>
                                            <option value="2" <?php if($dt->r6 == '2'){ echo 'selected';} ?>>Tidak sesuai</option>
                                            <option value="3" <?php if($dt->r6 == '3'){ echo 'selected';} ?>>Netral</option>
                                            <option value="4" <?php if($dt->r6 == '4'){ echo 'selected';} ?>>sesuai</option>
                                            <option value="5" <?php if($dt->r6 == '5'){ echo 'selected';} ?>>Sangat sesuai</option>
                                                  
                                        </select>
                                      </div>
                                    </div>
                                    <div class="form-group">
                                      7. Kemudahan dalam melakukan pembayaran pelatihan
                                      <div class="col-sm-12 mt-2">
                                        <select class="form-control select2bs4" disabled name="r7" style="width: 100%;">
                                          <option value="">-- Pilih Jawaban --</option>
                                          
                                            <option value="1" <?php if($dt->r7 == '1'){ echo 'selected';} ?>>Sangat tidak sesuai</option>
                                            <option value="2" <?php if($dt->r7 == '2'){ echo 'selected';} ?>>Tidak sesuai</option>
                                            <option value="3" <?php if($dt->r7 == '3'){ echo 'selected';} ?>>Netral</option>
                                            <option value="4" <?php if($dt->r7 == '4'){ echo 'selected';} ?>>sesuai</option>
                                            <option value="5" <?php if($dt->r7 == '5'){ echo 'selected';} ?>>Sangat sesuai</option>
                                                  
                                        </select>
                                      </div>
                                    </div>
                                      
          
                                      @endforeach
          
          
                                    </div>
                                    
          
                                    <!-- -->
                                    <div class="col-lg-12 mt-3 mb-3" style="background-color: rgb(11, 248, 31)">
                                      <b>Assurance</b> 
                                    </div>
                                    
                                    
                                    <div class="col-lg-12 mt-2">
                                      @foreach ($jawaban_assurance2 as $dt)
                                      <div class="form-group">
                                        1. Trainer/pegawai bersikap sopan.
                                        <div class="col-sm-12 mt-2">
                                          <select class="form-control select2bs4" disabled name="a1" style="width: 100%;">
                                            <option value="">-- Pilih Jawaban --</option>
                                            
                                            <option value="1" <?php if($dt->a1 == '1'){ echo 'selected';} ?>>Sangat tidak sesuai</option>
                                          <option value="2" <?php if($dt->a1 == '2'){ echo 'selected';} ?>>Tidak sesuai</option>
                                          <option value="3" <?php if($dt->a1 == '3'){ echo 'selected';} ?>>Netral</option>
                                          <option value="4" <?php if($dt->a1 == '4'){ echo 'selected';} ?>>sesuai</option>
                                          <option value="5" <?php if($dt->a1 == '5'){ echo 'selected';} ?>>Sangat sesuai</option>
                                                    
                                          </select>
                                        </div>
                                      </div>
                                      <div class="form-group">
                                        2. Trainer memiliki pengetahuan yang luas mengenai materi pelatihan
                                        <div class="col-sm-12 mt-2">
                                          <select class="form-control select2bs4" disabled name="a2" style="width: 100%;">
                                            <option value="">-- Pilih Jawaban --</option>
                                            
                                            <option value="1" <?php if($dt->a2 == '1'){ echo 'selected';} ?>>Sangat tidak sesuai</option>
                                          <option value="2" <?php if($dt->a2 == '2'){ echo 'selected';} ?>>Tidak sesuai</option>
                                          <option value="3" <?php if($dt->a2 == '3'){ echo 'selected';} ?>>Netral</option>
                                          <option value="4" <?php if($dt->a2 == '4'){ echo 'selected';} ?>>sesuai</option>
                                          <option value="5" <?php if($dt->a2 == '5'){ echo 'selected';} ?>>Sangat sesuai</option>
                                                    
                                          </select>
                                        </div>
                                      </div>
                                      <div class="form-group">
                                        3. Trainer mampu menyampaikan materi pelatihan dengan cara yang mudah dipahami.
                                        <div class="col-sm-12 mt-2">
                                          <select class="form-control select2bs4"  disabled name="a3" style="width: 100%;">
                                            <option value="">-- Pilih Jawaban --</option>
                                            
                                            <option value="1" <?php if($dt->a3 == '1'){ echo 'selected';} ?>>Sangat tidak sesuai</option>
                                          <option value="2" <?php if($dt->a3 == '2'){ echo 'selected';} ?>>Tidak sesuai</option>
                                          <option value="3" <?php if($dt->a3 == '3'){ echo 'selected';} ?>>Netral</option>
                                          <option value="4" <?php if($dt->a3 == '4'){ echo 'selected';} ?>>sesuai</option>
                                          <option value="5" <?php if($dt->a3 == '5'){ echo 'selected';} ?>>Sangat sesuai</option>
                                                    
                                          </select>
                                        </div>
                                      </div>
                                      <div class="form-group">
                                        4. Committee service selalu dapat menyelesaikan keluhan pelanggan
                                        <div class="col-sm-12 mt-2">
                                          <select class="form-control select2bs4" disabled name="a4" style="width: 100%;">
                                            <option value="">-- Pilih Jawaban --</option>
                                            
                                            <option value="1" <?php if($dt->a4 == '1'){ echo 'selected';} ?>>Sangat tidak sesuai</option>
                                          <option value="2" <?php if($dt->a4 == '2'){ echo 'selected';} ?>>Tidak sesuai</option>
                                          <option value="3" <?php if($dt->a4 == '3'){ echo 'selected';} ?>>Netral</option>
                                          <option value="4" <?php if($dt->a4 == '4'){ echo 'selected';} ?>>sesuai</option>
                                          <option value="5" <?php if($dt->a4 == '5'){ echo 'selected';} ?>>Sangat sesuai</option>
                                                    
                                          </select>
                                        </div>
                                      </div>
                                      
          
                                      @endforeach
          
                                    </div>
                                   <!-- -->
          
                                   <!-- -->
                                   <div class="col-lg-12 mt-3 mb-3" style="background-color: rgb(11, 248, 31)">
                                    <b>Tangible</b> 
                                  </div>
                                  
                                  
                                  <div class="col-lg-12 mt-2">
                                    @foreach ($jawaban_tangible2 as $dt)
                                    <div class="form-group">
                                      1. Sistem aplikasi pelatihan online yang user friendly.
                                      <div class="col-sm-12 mt-2">
                                        <select class="form-control select2bs4" disabled name="t1" style="width: 100%;">
                                          <option value="">-- Pilih Jawaban --</option>
                                          
                                          <option value="1" <?php if($dt->t1 == '1'){ echo 'selected';} ?>>Sangat tidak sesuai</option>
                                          <option value="2" <?php if($dt->t1 == '2'){ echo 'selected';} ?>>Tidak sesuai</option>
                                          <option value="3" <?php if($dt->t1 == '3'){ echo 'selected';} ?>>Netral</option>
                                          <option value="4" <?php if($dt->t1 == '4'){ echo 'selected';} ?>>sesuai</option>
                                          <option value="5" <?php if($dt->t1 == '5'){ echo 'selected';} ?>>Sangat sesuai</option>
                                                  
                                        </select>
                                      </div>
                                    </div>
                                    <div class="form-group">
                                      2. Website menampilkan informasi terbaru.
                                      <div class="col-sm-12 mt-2">
                                        <select class="form-control select2bs4" disabled name="t2" style="width: 100%;">
                                          <option value="">-- Pilih Jawaban --</option>
                                          
                                          <option value="1" <?php if($dt->t2 == '1'){ echo 'selected';} ?>>Sangat tidak sesuai</option>
                                          <option value="2" <?php if($dt->t2 == '2'){ echo 'selected';} ?>>Tidak sesuai</option>
                                          <option value="3" <?php if($dt->t2 == '3'){ echo 'selected';} ?>>Netral</option>
                                          <option value="4" <?php if($dt->t2 == '4'){ echo 'selected';} ?>>sesuai</option>
                                          <option value="5" <?php if($dt->t2 == '5'){ echo 'selected';} ?>>Sangat sesuai</option>
                                                  
                                        </select>
                                      </div>
                                    </div>
                                    <div class="form-group">
                                      3. Perlengkapan audio visual berfungsi dengan baik
                                      <div class="col-sm-12 mt-2">
                                        <select class="form-control select2bs4" disabled name="t3" style="width: 100%;">
                                          <option value="">-- Pilih Jawaban --</option>
                                          
                                          <option value="1" <?php if($dt->t3 == '1'){ echo 'selected';} ?>>Sangat tidak sesuai</option>
                                          <option value="2" <?php if($dt->t3 == '2'){ echo 'selected';} ?>>Tidak sesuai</option>
                                          <option value="3" <?php if($dt->t3 == '3'){ echo 'selected';} ?>>Netral</option>
                                          <option value="4" <?php if($dt->t3 == '4'){ echo 'selected';} ?>>sesuai</option>
                                          <option value="5" <?php if($dt->t3 == '5'){ echo 'selected';} ?>>Sangat sesuai</option>
                                                  
                                        </select>
                                      </div>
                                    </div>
                                    <div class="form-group">
                                      4. Koneksi internet host lancar selama pelatihan berlangsung
                                      <div class="col-sm-12 mt-2">
                                        <select class="form-control select2bs4" disabled name="t4" style="width: 100%;">
                                          <option value="">-- Pilih Jawaban --</option>
                                          
                                          <option value="1" <?php if($dt->t4 == '1'){ echo 'selected';} ?>>Sangat tidak sesuai</option>
                                          <option value="2" <?php if($dt->t4 == '2'){ echo 'selected';} ?>>Tidak sesuai</option>
                                          <option value="3" <?php if($dt->t4 == '3'){ echo 'selected';} ?>>Netral</option>
                                          <option value="4" <?php if($dt->t4 == '4'){ echo 'selected';} ?>>sesuai</option>
                                          <option value="5" <?php if($dt->t4 == '5'){ echo 'selected';} ?>>Sangat sesuai</option>
                                                  
                                        </select>
                                      </div>
                                    </div>
                                    <div class="form-group">
                                      5. Tampilan modul pelatihan menarik untuk dibaca.
                                      <div class="col-sm-12 mt-2">
                                        <select class="form-control select2bs4" disabled name="t5" style="width: 100%;">
                                          <option value="">-- Pilih Jawaban --</option>
                                          
                                          <option value="1" <?php if($dt->t5 == '1'){ echo 'selected';} ?>>Sangat tidak sesuai</option>
                                          <option value="2" <?php if($dt->t5 == '2'){ echo 'selected';} ?>>Tidak sesuai</option>
                                          <option value="3" <?php if($dt->t5 == '3'){ echo 'selected';} ?>>Netral</option>
                                          <option value="4" <?php if($dt->t5 == '4'){ echo 'selected';} ?>>sesuai</option>
                                          <option value="5" <?php if($dt->t5 == '5'){ echo 'selected';} ?>>Sangat sesuai</option>
                                                  
                                        </select>
                                      </div>
                                    </div>
                                    <div class="form-group">
                                      6. Trainer berpenampilan rapi.
                                      <div class="col-sm-12 mt-2">
                                        <select class="form-control select2bs4" disabled name="t6" style="width: 100%;">
                                          <option value="">-- Pilih Jawaban --</option>
                                          
                                          <option value="1" <?php if($dt->t6 == '1'){ echo 'selected';} ?>>Sangat tidak sesuai</option>
                                          <option value="2" <?php if($dt->t6 == '2'){ echo 'selected';} ?>>Tidak sesuai</option>
                                          <option value="3" <?php if($dt->t6 == '3'){ echo 'selected';} ?>>Netral</option>
                                          <option value="4" <?php if($dt->t6 == '4'){ echo 'selected';} ?>>sesuai</option>
                                          <option value="5" <?php if($dt->t6 == '5'){ echo 'selected';} ?>>Sangat sesuai</option>
                                                  
                                        </select>
                                      </div>
                                    </div>
                                    @endforeach
          
          
                                  </div>
                                 <!-- -->
          
          
                                 <!-- -->
                                 <div class="col-lg-12 mt-3 mb-3" style="background-color: rgb(11, 248, 31)">
                                  <b>Empathy</b> 
                                </div>
                                
                                
                                <div class="col-lg-12 mt-2">
                                  @foreach ($jawaban_empathy2 as $dt)
                                  <div class="form-group">
                                    1. Trainer memberi perhatian kepada peserta.
                                    <div class="col-sm-12 mt-2">
                                      <select class="form-control select2bs4" disabled name="e1" style="width: 100%;">
                                        <option value="">-- Pilih Jawaban --</option>
                                        
                                        <option value="1" <?php if($dt->e1 == '1'){ echo 'selected';} ?>>Sangat tidak sesuai</option>
                                        <option value="2" <?php if($dt->e1 == '2'){ echo 'selected';} ?>>Tidak sesuai</option>
                                        <option value="3" <?php if($dt->e1 == '3'){ echo 'selected';} ?>>Netral</option>
                                        <option value="4" <?php if($dt->e1 == '4'){ echo 'selected';} ?>>sesuai</option>
                                        <option value="5" <?php if($dt->e1 == '5'){ echo 'selected';} ?>>Sangat sesuai</option>
                                                
                                      </select>
                                    </div>
                                  </div>
                                  <div class="form-group">
                                    2. Trainer memahami kebutuhan peserta.
                                    <div class="col-sm-12 mt-2">
                                      <select class="form-control select2bs4" disabled name="e2" style="width: 100%;">
                                        <option value="">-- Pilih Jawaban --</option>
                                        
                                        <option value="1" <?php if($dt->e2 == '1'){ echo 'selected';} ?>>Sangat tidak sesuai</option>
                                        <option value="2" <?php if($dt->e2 == '2'){ echo 'selected';} ?>>Tidak sesuai</option>
                                        <option value="3" <?php if($dt->e2 == '3'){ echo 'selected';} ?>>Netral</option>
                                        <option value="4" <?php if($dt->e2 == '4'){ echo 'selected';} ?>>sesuai</option>
                                        <option value="5" <?php if($dt->e2 == '5'){ echo 'selected';} ?>>Sangat sesuai</option>
                                                
                                      </select>
                                    </div>
                                  </div>
                                  <div class="form-group">
                                    3. Terjalin komunikasi yang baik antara trainer dengan peserta
                                    <div class="col-sm-12 mt-2">
                                      <select class="form-control select2bs4" disabled name="e3" style="width: 100%;">
                                        <option value="">-- Pilih Jawaban --</option>
                                        
                                        <option value="1" <?php if($dt->e3 == '1'){ echo 'selected';} ?>>Sangat tidak sesuai</option>
                                        <option value="2" <?php if($dt->e3 == '2'){ echo 'selected';} ?>>Tidak sesuai</option>
                                        <option value="3" <?php if($dt->e3 == '3'){ echo 'selected';} ?>>Netral</option>
                                        <option value="4" <?php if($dt->e3 == '4'){ echo 'selected';} ?>>sesuai</option>
                                        <option value="5" <?php if($dt->e3 == '5'){ echo 'selected';} ?>>Sangat sesuai</option>
                                                
                                      </select>
                                    </div>
                                  </div>
                                  <div class="form-group">
                                    4. Trainer berupaya membantu saat peserta mengalami kesulitan
                                    <div class="col-sm-12 mt-2">
                                      <select class="form-control select2bs4" disabled name="e4" style="width: 100%;">
                                        <option value="">-- Pilih Jawaban --</option>
                                        
                                        <option value="1" <?php if($dt->e4 == '1'){ echo 'selected';} ?>>Sangat tidak sesuai</option>
                                        <option value="2" <?php if($dt->e4 == '2'){ echo 'selected';} ?>>Tidak sesuai</option>
                                        <option value="3" <?php if($dt->e4 == '3'){ echo 'selected';} ?>>Netral</option>
                                        <option value="4" <?php if($dt->e4 == '4'){ echo 'selected';} ?>>sesuai</option>
                                        <option value="5" <?php if($dt->e4 == '5'){ echo 'selected';} ?>>Sangat sesuai</option>
                                                
                                      </select>
                                    </div>
                                  </div>
                                  <div class="form-group">
                                    5. Kecukupan waktu yang dialokasikan untuk pelatihan.
                                    <div class="col-sm-12 mt-2">
                                      <select class="form-control select2bs4" disabled name="e5" style="width: 100%;">
                                        <option value="">-- Pilih Jawaban --</option>
                                        
                                        <option value="1" <?php if($dt->e5 == '1'){ echo 'selected';} ?>>Sangat tidak sesuai</option>
                                        <option value="2" <?php if($dt->e5 == '2'){ echo 'selected';} ?>>Tidak sesuai</option>
                                        <option value="3" <?php if($dt->e5 == '3'){ echo 'selected';} ?>>Netral</option>
                                        <option value="4" <?php if($dt->e5 == '4'){ echo 'selected';} ?>>sesuai</option>
                                        <option value="5" <?php if($dt->e5 == '5'){ echo 'selected';} ?>>Sangat sesuai</option>
                                                
                                      </select>
                                    </div>
                                  </div>
                                  
                                  @endforeach
          
                                </div>
                                <!-- -->
                                <!-- -->
                                <div class="col-lg-12 mt-3 mb-3" style="background-color: rgb(11, 248, 31)">
                                  <b>Responsiveness</b> 
                                </div>
                                
                                
                                <div class="col-lg-12 mt-2">
                                  @foreach ($jawaban_responsiveness2 as $dt)
                                  <div class="form-group">
                                    1. Kecepatan respon contact person perusahaan dalam menanggapi peserta.
                                    <div class="col-sm-12 mt-2">
                                      <select class="form-control select2bs4" disabled name="rs1" style="width: 100%;">
                                        <option value="">-- Pilih Jawaban --</option>
                                        
                                        <option value="1" <?php if($dt->rs1 == '1'){ echo 'selected';} ?>>Sangat tidak sesuai</option>
                                        <option value="2" <?php if($dt->rs1 == '2'){ echo 'selected';} ?>>Tidak sesuai</option>
                                        <option value="3" <?php if($dt->rs1 == '3'){ echo 'selected';} ?>>Netral</option>
                                        <option value="4" <?php if($dt->rs1 == '4'){ echo 'selected';} ?>>sesuai</option>
                                        <option value="5" <?php if($dt->rs1 == '5'){ echo 'selected';} ?>>Sangat sesuai</option>
                                                
                                      </select>
                                    </div>
                                  </div>
                                  <div class="form-group">
                                    2. Kepastian informasi mengenai jadwal pelatihan
                                    <div class="col-sm-12 mt-2">
                                      <select class="form-control select2bs4" disabled name="rs2" style="width: 100%;">
                                        <option value="">-- Pilih Jawaban --</option>
                                        
                                        <option value="1" <?php if($dt->rs2 == '1'){ echo 'selected';} ?>>Sangat tidak sesuai</option>
                                        <option value="2" <?php if($dt->rs2 == '2'){ echo 'selected';} ?>>Tidak sesuai</option>
                                        <option value="3" <?php if($dt->rs2 == '3'){ echo 'selected';} ?>>Netral</option>
                                        <option value="4" <?php if($dt->rs2 == '4'){ echo 'selected';} ?>>sesuai</option>
                                        <option value="5" <?php if($dt->rs2 == '5'){ echo 'selected';} ?>>Sangat sesuai</option>
                                                
                                      </select>
                                    </div>
                                  </div>
                                  
                                  @endforeach
        
        
                                </div>
                               <!-- -->

                               <!-- -->
                               <div class="col-lg-12 mt-3 mb-3" style="background-color: rgb(11, 248, 31)">
                                <b>Applicability</b> 
                              </div>
                              
                              
                              <div class="col-lg-12 mt-2">
                                @foreach ($jawaban_relevance2 as $dt)
                                <div class="form-group">
                                  1. Pelatihan berkaitan langsung dengan pekerjaan saya
                                  <div class="col-sm-12 mt-2">
                                    <select class="form-control select2bs4" disabled name="ap1" style="width: 100%;">
                                      <option value="">-- Pilih Jawaban --</option>
                                      
                                      <option value="1" <?php if($dt->ap1 == '1'){ echo 'selected';} ?>>Sangat tidak sesuai</option>
                                        <option value="2" <?php if($dt->ap1 == '2'){ echo 'selected';} ?>>Tidak sesuai</option>
                                        <option value="3" <?php if($dt->ap1 == '3'){ echo 'selected';} ?>>Netral</option>
                                        <option value="4" <?php if($dt->ap1 == '4'){ echo 'selected';} ?>>sesuai</option>
                                        <option value="5" <?php if($dt->ap1 == '5'){ echo 'selected';} ?>>Sangat sesuai</option>
                                              
                                    </select>
                                  </div>
                                </div>
                                <div class="form-group">
                                  2. Pelatihan yang diberikan mudah untuk diterapkan dalam pekerjaan
                                  <div class="col-sm-12 mt-2">
                                    <select class="form-control select2bs4" disabled name="ap2" style="width: 100%;">
                                      <option value="">-- Pilih Jawaban --</option>
                                      
                                      <option value="1" <?php if($dt->ap2 == '1'){ echo 'selected';} ?>>Sangat tidak sesuai</option>
                                        <option value="2" <?php if($dt->ap2 == '2'){ echo 'selected';} ?>>Tidak sesuai</option>
                                        <option value="3" <?php if($dt->ap2 == '3'){ echo 'selected';} ?>>Netral</option>
                                        <option value="4" <?php if($dt->ap2 == '4'){ echo 'selected';} ?>>sesuai</option>
                                        <option value="5" <?php if($dt->ap2 == '5'){ echo 'selected';} ?>>Sangat sesuai</option>
                                              
                                    </select>
                                  </div>
                                </div>
                                
                                
                                @endforeach
      
      
                              </div>
                             <!-- -->
                              </div>
                                
                        </div>

                    <div class="tab-pane fade" id="custom-tabs-one-profile1" role="tabpanel" aria-labelledby="custom-tabs-one-profile-tab1">
                         
                            <center>
                            <br>
                            <b>Kepuasan responden</b>
                            </center>

                            <div class="row">
                              <!-- -->
                               <div class="col-lg-12 mt-2">
                                @foreach ($jawaban_kp as $dt)
                                  <div class="form-group">
                                      1. Secara keseluruhan, saya merasa puas pada layanan pelatihan ini
                                      <div class="col-sm-12 mt-2">
                                      <select class="form-control select2bs4" disabled name="k1" style="width: 100%;">
                                        <option value="">-- Pilih Jawaban --</option>
                                        
                                      <option value="1" <?php if($dt->k1 == '1'){ echo 'selected';} ?>>Sangat tidak setuju</option>
                                      <option value="2" <?php if($dt->k1 == '2'){ echo 'selected';} ?>>Tidak setuju</option>
                                      <option value="3" <?php if($dt->k1 == '3'){ echo 'selected';} ?>>Netral</option>
                                      <option value="4" <?php if($dt->k1 == '4'){ echo 'selected';} ?>>Setuju</option>
                                      <option value="5" <?php if($dt->k1 == '5'){ echo 'selected';} ?>>Sangat setuju</option>
                                                
                                      </select>
                                    </div>
                                  </div>
                                  <div class="form-group">
                                    2. Menurut saya, kinerja layanan pelatihan ini telah sesuai dengan harapan saya.
                                    <div class="col-sm-12 mt-2">
                                      <select class="form-control select2bs4" disabled name="k2" style="width: 100%;">
                                        <option value="">-- Pilih Jawaban --</option>
                                        
                                        <option value="1" <?php if($dt->k2 == '1'){ echo 'selected';} ?>>Sangat tidak setuju</option>
                                      <option value="2" <?php if($dt->k2 == '2'){ echo 'selected';} ?>>Tidak setuju</option>
                                      <option value="3" <?php if($dt->k2 == '3'){ echo 'selected';} ?>>Netral</option>
                                      <option value="4" <?php if($dt->k2 == '4'){ echo 'selected';} ?>>Setuju</option>
                                      <option value="5" <?php if($dt->k2 == '5'){ echo 'selected';} ?>>Sangat setuju</option>
                                                
                                      </select>
                                    </div>
                                  </div>
                                  <div class="form-group">
                                    3. Menurut saya, layanan pelatihan ini telah sesuai dengan layanan pelatihan yang ideal
                                    <div class="col-sm-12 mt-2">
                                      <select class="form-control select2bs4" disabled name="k3" style="width: 100%;">
                                        <option value="">-- Pilih Jawaban --</option>
                                        
                                        <option value="1" <?php if($dt->k3 == '1'){ echo 'selected';} ?>>Sangat tidak setuju</option>
                                        <option value="2" <?php if($dt->k3 == '2'){ echo 'selected';} ?>>Tidak setuju</option>
                                        <option value="3" <?php if($dt->k3 == '3'){ echo 'selected';} ?>>Netral</option>
                                        <option value="4" <?php if($dt->k3 == '4'){ echo 'selected';} ?>>Setuju</option>
                                        <option value="5" <?php if($dt->k3 == '5'){ echo 'selected';} ?>>Sangat setuju</option>
                                                
                                      </select>
                                    </div>
                                  </div>
                                  @endforeach
      
                                </div>
                                
                            </div>
                          
                            

                    </div>

                    <div class="tab-pane fade" id="custom-tabs-one-profile2" role="tabpanel" aria-labelledby="custom-tabs-one-profile-tab2">
                      
                        <center>
                        <br>
                        <b>Loyalitas responden</b>
                        </center>
                        <div class="row">
                          <!-- -->
                           <div class="col-lg-12 mt-2">
                            @foreach ($jawaban_lp as $dt)
                              
                              <div class="form-group">
                                1. Saya akan mengulangi menggunakan jasa pelatihan ini
                                <div class="col-sm-12 mt-2">
                                <select class="form-control select2bs4" disabled name="l1" style="width: 100%;">
                                  <option value="">-- Pilih Jawaban --</option>
                                  
                                  <option value="1" <?php if($dt->l1 == '1'){ echo 'selected';} ?>>Sangat tidak setuju</option>
                                  <option value="2" <?php if($dt->l1 == '2'){ echo 'selected';} ?>>Tidak setuju</option>
                                  <option value="3" <?php if($dt->l1 == '3'){ echo 'selected';} ?>>Netral</option>
                                  <option value="4" <?php if($dt->l1 == '4'){ echo 'selected';} ?>>Setuju</option>
                                  <option value="5" <?php if($dt->l1 == '5'){ echo 'selected';} ?>>Sangat setuju</option>
                                          
                                </select>
                              </div>
                            </div>
                            <div class="form-group">
                              2. Saya akan tetap memilih jasa pelatihan ini meskipun tersedia alternatif pelatihan lain
                              <div class="col-sm-12 mt-2">
                                <select class="form-control select2bs4" disabled name="l2" style="width: 100%;">
                                  <option value="">-- Pilih Jawaban --</option>
                                  
                                  <option value="1" <?php if($dt->l2 == '1'){ echo 'selected';} ?>>Sangat tidak setuju</option>
                                  <option value="2" <?php if($dt->l2 == '2'){ echo 'selected';} ?>>Tidak setuju</option>
                                  <option value="3" <?php if($dt->l2 == '3'){ echo 'selected';} ?>>Netral</option>
                                  <option value="4" <?php if($dt->l2 == '4'){ echo 'selected';} ?>>Setuju</option>
                                  <option value="5" <?php if($dt->l2 == '5'){ echo 'selected';} ?>>Sangat setuju</option>
                                          
                                </select>
                              </div>
                            </div>
                            <div class="form-group">
                              3. Saya akan merekomendasikan pelatihan ini kepada orang lain.
                              <div class="col-sm-12 mt-2">
                                <select class="form-control select2bs4" disabled name="l3" style="width: 100%;">
                                  <option value="">-- Pilih Jawaban --</option>
                                  
                                  <option value="1" <?php if($dt->l3 == '1'){ echo 'selected';} ?>>Sangat tidak setuju</option>
                                  <option value="2" <?php if($dt->l3 == '2'){ echo 'selected';} ?>>Tidak setuju</option>
                                  <option value="3" <?php if($dt->l3 == '3'){ echo 'selected';} ?>>Netral</option>
                                  <option value="4" <?php if($dt->l3 == '4'){ echo 'selected';} ?>>Setuju</option>
                                  <option value="5" <?php if($dt->l3 == '5'){ echo 'selected';} ?>>Sangat setuju</option>
                                          
                                </select>
                              </div>
                            </div>
                              @endforeach
  
                            </div>
                            
                        </div>
                        

                </div>

                <div class="tab-pane fade" id="custom-tabs-one-profile3" role="tabpanel" aria-labelledby="custom-tabs-one-profile-tab3">
                  
                    <center>
                    <br>
                    <b>Kritik dan saran</b>
                    </center>

                    <div class="row">
                      <!-- -->
                       <div class="col-lg-12 mt-2">
                        @foreach ($jawaban_kritik_saran as $dt)
                          
                        <div class="form-group">
                          1. Silahkan berikan kritik dan saran terkait layanan pelatihan berdasarkan apa yang anda alami
                          <div class="col-sm-12 mt-2">
                          <textarea name="kritik_saran" disabled rows="5" cols="100">{{ $dt->no1 }}</textarea>
                        </div>
                      </div>
                      <div class="form-group">
                        2. Tema dan judul pelatihan yang diinginkan
                        <div class="col-sm-12 mt-2">
                          <textarea name="tema_judul" disabled rows="5" cols="100">{{ $dt->no2 }}</textarea>
                        </div>
                      </div>
                      <div class="form-group">
                        3. Bentuk pelatihan yang diinginkan
                        <div class="col-sm-12 mt-2">
                          <input type="checkbox" disabled name="online" value="1" <?php if($dt->no3_online == '1'){ echo 'checked';} ?> /> Online<br>
                          <input type="checkbox" disabled name="offline" value="1"  <?php if($dt->no3_offlone == '1'){ echo 'checked';} ?> /> Offline<br>
                          <input type="checkbox" disabled name="streaming" value="1" <?php if($dt->no3_streaming == '1'){ echo 'checked';} ?> /> streaming<br>
                          <input type="checkbox" disabled name="elearning" value="1" <?php if($dt->no3_elearning == '1'){ echo 'checked';} ?> /> E-learning<br>
                        </div>
                      </div>
                          @endforeach

                        </div>
                        
                    </div>
                  
                  
                    

                </div>


                      </div>
                      
                      <!-- /.card -->
                    </div>

                  </div>
                
              </div>
            </div>
      </div>


     
    </div>
  </section>

 
@endsection
