
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>{{ config('app.name', 'APLIKASI_SURVEI') }}</title>

  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Bootstrap Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
  <!-- DataTables Bootstrap 5 -->
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">

<style>
/* Minimal custom styles */
.sidebar {
  position: fixed;
  top: 56px;
  bottom: 0;
  left: 0;
  z-index: 100;
  padding: 0;
  overflow-x: hidden;
  overflow-y: auto;
  background-color: #212529;
  width: 250px;
}

.sidebar .nav-link {
  color: rgba(255, 255, 255, 0.8);
  padding: 0.75rem 1rem;
}

.sidebar .nav-link:hover {
  color: #fff;
  background-color: rgba(255, 255, 255, 0.1);
}

.sidebar .nav-link.active {
  color: #fff;
  background-color: #0d6efd;
}

.main-content {
  margin-left: 250px;
  padding: 20px;
}

@media (max-width: 768px) {
  .sidebar {
    position: static;
    width: 100%;
  }
  .main-content {
    margin-left: 0;
  }
}
</style>
</head>
<body>
<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="{{ route('admin.dashboard') }}">
      <i class="bi bi-clipboard-data"></i> APLIKASI SURVEI
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item">
          <a class="nav-link" href="#">
            <i class="bi bi-bell"></i>
          </a>
        </li>
      </ul>
    </div>
  </div>
</nav>

<div class="container-fluid">
  <div class="row">
    <!-- Sidebar -->
    <nav class="col-md-3 col-lg-2 d-md-block sidebar collapse">
      <div class="position-sticky pt-3">
        <ul class="nav flex-column">
          <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.dashboard') }}">
              <i class="bi bi-speedometer2"></i> Dashboard
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.responden') }}">
              <i class="bi bi-people"></i> Data Responden
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#grafikMenu" role="button">
              <i class="bi bi-bar-chart"></i> Grafik/Visual <i class="bi bi-chevron-down float-end"></i>
            </a>
            <div class="collapse" id="grafikMenu">
              <ul class="nav flex-column ms-3">
                <li class="nav-item">
                  <a class="nav-link" href="{{ route('admin.grafik.grafik5') }}">
                    <i class="bi bi-circle"></i> Profil responden
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="{{ route('admin.grafik.grafik3') }}">
                    <i class="bi bi-circle"></i> Rata-rata Gap per indikator
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="{{ route('admin.grafik.grafik4') }}">
                    <i class="bi bi-circle"></i> Rata-rata Gap per dimensi
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="{{ route('admin.grafik.grafik2') }}">
                    <i class="bi bi-circle"></i> Rekomendasi
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="{{ route('admin.grafik.grafik1') }}">
                    <i class="bi bi-circle"></i> Kepuasan
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="{{ route('admin.grafik.grafik6') }}">
                    <i class="bi bi-circle"></i> Loyalitas
                  </a>
                </li>
              </ul>
            </div>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.spp.index') }}">
              <i class="bi bi-clipboard-check"></i> Evaluasi SPP
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
              <i class="bi bi-power"></i> {{ __('Logout') }}
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
              @csrf
            </form>
          </li>
        </ul>
      </div>
    </nav>

    <!-- Main content -->
    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 main-content">
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">@yield('judul')</h1>
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Aplikasi Survei</a></li>
          </ol>
        </nav>
      </div>

      @yield('content')
    </main>
  </div>
</div>

<!-- Footer -->
<footer class="bg-light text-center text-muted py-3 mt-5">
  <div class="container">
    <strong>Copyright &copy; 2021 <a href="">Aplikasi Survei</a>.</strong>
    <span class="float-end"><b>Version</b> 1.1</span>
  </div>
</footer>



<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<!-- Bootstrap 5 JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- DataTables -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>
<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

<script>
  $(function () {
    // Initialize DataTables with Bootstrap 5
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
</script>

@yield('footer')
</body>
</html>
