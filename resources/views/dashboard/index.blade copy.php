@extends('layouts.master')
@section('judul','Dashboard')

@section('content')
    <div class="row mt-3">
        
        <div class="col-lg-3 col-6">
        
            <div class="small-box bg-info">
                <div class="inner">
                <h3>150</h3>

                <p>Karyawan Aktiv</p>
                </div>
                <div class="icon">
                <i class="fa fa-users"></i>
                
                </div>
                <a href="karyawan.php" class="small-box-footer">Lihat Detail <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        
        <div class="col-lg-3 col-6">
        
            <div class="small-box bg-warning">
                <div class="inner">
                <h3>44</h3>

                <p>Karyawan Non Aktiv</p>
                </div>
                <div class="icon">
                <i class="fa fa-users"></i>
                </div>
                <a href="karyawan.php" class="small-box-footer">Lihat Detail <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>

        <div class="col-lg-3 col-6">
        
            <div class="small-box bg-success">
                <div class="inner">
                <h3>2</h3>

                <p>Pengajuan Karyawan Baru</p>
                </div>
                <div class="icon">
                <i class="fa fa-user-plus"></i>
                </div>
                <a href="karyawan.php" class="small-box-footer">Lihat Detail <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        
    </div>
 
@endsection
