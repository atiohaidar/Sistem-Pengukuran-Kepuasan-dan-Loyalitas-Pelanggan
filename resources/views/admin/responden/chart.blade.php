@extends('layouts.master')
@section('judul','Data Chart')

@section('content')

  <section class="content">
    <div class="container-fluid">
        
        <div class="row">
          <div class="col-12">
            <div class="card">
                  <div class="card-header">
                    <h3 class="card-title"><b>Database Responden</b></h3>
                    
                  </div>
                  <div class="card-body">
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
                        
                      </tr>
                      </thead>
                      <tbody>
                          @foreach ($database  as $dt)
                      <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>@if($dt->id_bisnis == '') - @else {{ $dt->bisnis->nama_bisnis }} @endif</td>
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
                          
                        </td>
                        
                      </tr>
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
