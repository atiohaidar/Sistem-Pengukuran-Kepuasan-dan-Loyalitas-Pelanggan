@extends('layouts.master')
@section('judul','Data Responden')

@section('content')

  <section class="content">
    <div class="container-fluid">
        
        <div class="row">
          <div class="col-12">
            <div class="card">
                  <div class="card-header">
                    <h3 class="card-title"><b>Database Responden</b></h3>
                    <a href="{{  route('admin.export') }}" class="btn btn-primary  float-right mt-2"><i class="far fa-copy"></i> Export Excel</a>
                  </div>
                  <div class="card-body"><br>
                    @if ($message = Session::get('success'))
                    <div class="alert alert-success alert-block mt-3">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <strong>{{ $message }}</strong>
                    </div>
                    @endif
        
                    @if ($message = Session::get('error'))
                        <div class="alert alert-danger alert-block">
                            <button type="button" class="close" data-dismiss="alert">×</button>
                            <strong>{{ $message }}</strong>
                        </div>
                    @endif
        
                    @if ($message = Session::get('warning'))
                        <div class="alert alert-warning alert-block">
                            <button type="button" class="close" data-dismiss="alert">×</button>
                            <strong>{{ $message }}</strong>
                        </div>
                    @endif
                  <table id="example2" class="table table-bordered table-striped">
                      <thead>
                      <tr>
                        <th width="5%">No</th>
                        <th>Nama Bisnis</th>
                        <th>Email</th>
                        <th>WhatsApp</th>
                        <th>JK</th>
                        <th>Usia</th>
                        <th>Pekerjaan</th>
                        <th>Domisili</th>
                        <th></th>
                        
                      </tr>
                      </thead>
                      <tbody>
                          @foreach ($database  as $dt)
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
                        <td>{{ $dt->pekerjaan }} [ {{ $dt->pekerjaan_lain }} ]</td>
                        <td>@if($dt->domisili == '') - @else {{ $dt->domi->title }} @endif</td>
                        <td>
                          <button type="button" class="btn btn-warning btn-sm btn-flat" data-toggle="modal" data-target="#modal-sm-hapus{{ $dt->id_responden }}">Hapus</button>
                          
                        </td>
                        
                      </tr>
                      <div class="modal fade" id="modal-sm-hapus{{ $dt->id_responden }}">
                            <div class="modal-dialog modal-sm">
                              <div class="modal-content">
                                <form class="form-horizontal" method="POST" action="{{ route('admin.responden.hapus', $dt->id_responden) }}">
                                    @csrf
                                    @method('delete')

                                  <div class="card card-danger">
                                      <div class="card-header">
                                        <h3 class="card-title">Konfirmasi</h3>
                                      </div>
                                    
                                        <div class="card-body">
                                          <center>Yakin Mau Hapus Data ini ?... 

                                            <br/>( {{ $dt->email }} )
                                          </center>
                                          
                                        </div>
                                      
                                        <div class="card-footer">
                                          
                                          <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                                          <button type="submit" class="btn btn-danger float-right">Hapus</button>
                                        </div>
                                      
                                    </div>

                                    </form>
                              </div>
                              <!-- /.modal-content -->
                            </div>
                            <!-- /.modal-dialog -->
                          </div>
                      @endforeach


                      </tbody>
                      <tfoot>
                      <tr>
                        <th width="5%">No</th>
                        <th>Nama Bisnis</th>
                        <th>Email</th>
                        <th>WhatsApp</th>
                        <th>JK</th>
                        <th>Usia</th>
                        <th>Pekerjaan</th>
                        <th>Domisili</th>
                        <th></th>
                      </tr>
                      </tfoot>
                    </table>
                  </div>
                  
                </div>
              </div>
        </div>
       
      </div>
    </section>

 
@endsection
