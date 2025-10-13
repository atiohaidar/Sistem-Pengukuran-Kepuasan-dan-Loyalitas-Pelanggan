
<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>{{ config('app.name', 'APLIKASI_SURVEI') }}</title>

  <link href="{{ asset('css/app.css') }}" rel="stylesheet">
  <script src="//code.jquery.com/jquery-2.1.4.min.js"></script>
   <link rel="stylesheet" href="{{ asset('assets_backend/plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="{{ asset('assets_backend/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets_backend/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets_backend/plugins/jqvmap/jqvmap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets_backend/dist/css/adminlte.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets_backend/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets_backend/plugins/daterangepicker/daterangepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('assets_backend/plugins/summernote/summernote-bs4.css') }}">
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets_backend/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets_backend/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets_backend/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets_backend/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets_backend/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets_backend/plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css') }}">

  	<link rel="stylesheet" href="{{ asset('assets_backend/dist/css/css/circle.css') }}">

<style>
.highcharts-figure, .highcharts-data-table table {
  min-width: 510px; 
  max-width: 1200px;
  margin: 1em auto;
}

#container {
  height: 400px;
}

.highcharts-data-table table {
	font-family: Verdana, sans-serif;
	border-collapse: collapse;
	border: 1px solid #EBEBEB;
	margin: 10px auto;
	text-align: center;
	width: 100%;
	max-width: 500px;
}
.highcharts-data-table caption {
  padding: 1em 0;
  font-size: 1.2em;
  color: #555;
}
.highcharts-data-table th {
	font-weight: 600;
  padding: 0.5em;
}
.highcharts-data-table td, .highcharts-data-table th, .highcharts-data-table caption {
  padding: 0.5em;
}
.highcharts-data-table thead tr, .highcharts-data-table tr:nth-child(even) {
  background: #f8f8f8;
}
.highcharts-data-table tr:hover {
  background: #f1f7ff;
}


</style>

<style type="text/css">


  .page {
      margin: 40px;
      align-items: center;
      text-align: center;
      align-content: center;
  }

  .dark-area {
      background-color: #666;
      padding: 40px;
      margin: 0 -40px 20px -40px;
      clear: both;
  }

  .clearfix:before,.clearfix:after {content: " "; display: table;}
  .clearfix:after {clear: both;}
  .clearfix {*zoom: 1;}

</style>
</head>
<body class="hold-transition sidebar-mini">
    
<div class="wrapper" id="app">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-dark navbar-navy">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars white"></i></a>
        </li>
        
      </ul>

    <!-- SEARCH FORM -->
    
      
    

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <!-- Messages Dropdown Menu -->
        
        <!-- Notifications Dropdown Menu -->
        <li class="nav-item">
            <a class="nav-link" href="#">
                <i class="fas fa-bell white"></i>
            </a>
        </li>
        
      </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    
    <a href="" class="brand-link">
        <span class="brand-text font-weight-light"><center><b>APLIKASI SURVEI</b></center></span>
      </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
     
    
     <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
               <li class="nav-item has-treeview">
                <a href="{{ route('admin.dashboard') }}" class="nav-link">
                  <i class="nav-icon fas fa-tachometer-alt blue"></i>
                  <p>
                    Dashboard
                   
                  </p>
                </a>
                
              </li>
              
              
              
              <li class="nav-item has-treeview">
                <a href="{{ route('admin.responden') }}" class="nav-link">
                  <i class="nav-icon fas fa-users cyan"></i>
                  <p>
                    Data Responden
                    
                  </p>
                </a>
                
              </li>

              <li class="nav-item has-treeview">
                <a href="#" class="nav-link">
                  <i class="nav-icon fas fa-chart-pie"></i>
                  <p>
                    Grafik/Visual
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="{{ route('admin.grafik.grafik5') }}" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Profil responden</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{ route('admin.grafik.grafik3') }}" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Rata-rata Gap per indikator</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{ route('admin.grafik.grafik4') }}" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Rata-rata Gap per dimensi</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{ route('admin.grafik.grafik2') }}" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Rekomendasi</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{ route('admin.grafik.grafik1') }}" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Kepuasan</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{ route('admin.grafik.grafik6') }}" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Loyalitas</p>
                    </a>
                  </li>
                  
                </ul>
              </li>

              <li class="nav-item has-treeview">
                <a href="{{ route('admin.spp.index') }}" class="nav-link">
                  <i class="nav-icon fas fa-clipboard-check"></i>
                  <p>
                    Evaluasi SPP
                    
                  </p>
                </a>
                
              </li>

             
              <li class="nav-item">
                <a href="{{ route('logout') }}" class="nav-link" onclick="event.preventDefault();
                                            document.getElementById('logout-form').submit();">
                           
                  <i class="nav-icon fas fa-power-off red"></i>
                  <p>
                    {{ __('Logout') }} 
                    
                  </p>
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
                
              </li>
              
              

              
        
         
          
        </ul>

        
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="content-header">
          <div class="container-fluid">
            <div class="row mb-2">
              <div class="col-sm-8">
                <h1 class="m-0 text-dark">@yield('judul')</h1>
                
              </div><!-- /.col -->
              <div class="col-sm-4">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="#">Aplikasi Survei</a></li>
                 
                </ol>
              </div><!-- /.col -->
              
            </div><!-- /.row -->
            <hr/>
          </div><!-- /.container-fluid -->
        </div>

        @yield('content')



      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <strong>Copyright &copy; 2021 <a href="">Aplikasi Survei</a>.</strong>
   
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 1.1
    </div>
  </footer>
 
  <!-- Control Sidebar -->
  
  <!-- /.control-sidebar -->

  <!-- Main Footer -->
  
</div>
<!-- ./wrapper -->



<script src="{{ asset('assets_backend/plugins/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('assets_backend/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<script src="{{ asset('assets_backend/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets_backend/plugins/chart.js/Chart.min.js') }}"></script>
<script src="{{ asset('assets_backend/plugins/jqvmap/jquery.vmap.min.js') }}"></script>
<script src="{{ asset('assets_backend/plugins/jqvmap/maps/jquery.vmap.usa.js') }}"></script>
<script src="{{ asset('assets_backend/plugins/jquery-knob/jquery.knob.min.js') }}"></script>
<script src="{{ asset('assets_backend/plugins/moment/moment.min.js') }}"></script>
<script src="{{ asset('assets_backend/plugins/daterangepicker/daterangepicker.js') }}"></script>
<script src="{{ asset('assets_backend/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
<script src="{{ asset('assets_backend/plugins/summernote/summernote-bs4.min.js') }}"></script>
<script src="{{ asset('assets_backend/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
<script src="{{ asset('assets_backend/dist/js/adminlte.js') }}"></script>
<script src="{{ asset('assets_backend/dist/js/demo.js') }}"></script>
<script src="{{ asset('assets_backend/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets_backend/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets_backend/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('assets_backend/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets_backend/plugins/select2/js/select2.full.min.js') }}"></script>
<script src="{{ asset('assets_backend/plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js') }}"></script>
<script src="{{ asset('assets_backend/plugins/inputmask/min/jquery.inputmask.bundle.min.js') }}"></script>
<script src="{{ asset('assets_backend/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js') }}"></script>
<script src="{{ asset('assets_backend/plugins/bootstrap-switch/js/bootstrap-switch.min.js') }}"></script>
<!--<script src="assets_backend/dist/js/adminlte.min.js"></script>-->
<script>
  $(function () {
    $("#example1").DataTable({
      "responsive": true,
      "autoWidth": false,
    });
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
  });


  $(function () {
    //Initialize Select2 Elements
    $('.select2').select2()

    //Initialize Select2 Elements
    $('.select2bs4').select2({
      theme: 'bootstrap4'
    })

    //Datemask dd/mm/yyyy
    $('#datemask').inputmask('yyyy-mm-dd', { 'placeholder': 'yyyy-mm-dd' })
    //Datemask2 mm/dd/yyyy
    $('#datemask2').inputmask('yyyy-mm-dd', { 'placeholder': 'yyyy-mm-dd' })
    //Money Euro
    $('[data-mask]').inputmask()

    //Date range picker
    $('#reservationdate').datetimepicker({
      format: 'YYYY-MM-DD'
    });
    //Date range picker
    $('#reservation').daterangepicker()
    //Date range picker with time picker
    $('#reservationtime').daterangepicker({
      timePicker: true,
      timePickerIncrement: 30,
      locale: {
        format: 'YYYY-MM-DD hh:mm A'
      }
    })
    //Date range as a button
    $('#daterange-btn').daterangepicker(
      {
        ranges   : {
          'Today'       : [moment(), moment()],
          'Yesterday'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
          'Last 7 Days' : [moment().subtract(6, 'days'), moment()],
          'Last 30 Days': [moment().subtract(29, 'days'), moment()],
          'This Month'  : [moment().startOf('month'), moment().endOf('month')],
          'Last Month'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
        startDate: moment().subtract(29, 'days'),
        endDate  : moment()
      },
      function (start, end) {
        $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
      }
    )

    //Timepicker
    $('#timepicker').datetimepicker({
      format: 'LT'
    })
    
    //Bootstrap Duallistbox
    $('.duallistbox').bootstrapDualListbox()

    //Colorpicker
    $('.my-colorpicker1').colorpicker()
    //color picker with addon
    $('.my-colorpicker2').colorpicker()

    $('.my-colorpicker2').on('colorpickerChange', function(event) {
      $('.my-colorpicker2 .fa-square').css('color', event.color.toString());
    });

    $("input[data-bootstrap-switch]").each(function(){
      $(this).bootstrapSwitch('state', $(this).prop('checked'));
    });

  })
</script>

@yield('footer')
</body>
</html>
