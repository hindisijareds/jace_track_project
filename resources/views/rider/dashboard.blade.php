<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>JaceTrack - Rider Dashboard</title>

  <link rel="shortcut icon" href="{{ asset('images/jacelogoclean.png') }}" type="image/png" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/style_rider_dashboard.css') }}" />
</head>
<body>

<div id="preloader">
  <img src="{{ asset('images/jacelogoclean.png') }}" alt="JaceTrack Logo">
</div>

<div class="d-flex">
  <!-- Sidebar -->
  <aside class="sidebar" id="sidebar">
    <div class="brand">
      <img src="{{ asset('images/jacelogoclean.png') }}" alt="JaceTrack logo">
      <div>
        <div class="name">JaceTrack</div>
        <small>Rider</small>
      </div>
    </div>

    <nav class="nav flex-column">
      <a class="nav-link active" href="#"><i class="bx bx-home me-2"></i> Dashboard</a>
      <a class="nav-link" href="{{ route('rider.deliveries') }}"><i class="bx bx-package me-2"></i> My Deliveries</a>
       <a class="nav-link" href="{{ route('rider.profile') }}"><i class="bx bx-user me-2"></i> Profile</a>
      <a class="nav-link" href="#"><i class="bx bx-map me-2"></i> Routes</a>
      <a class="nav-link" href="#"><i class="bx bx-wallet me-2"></i> Earnings</a>
      <a class="nav-link" href="#"><i class="bx bx-line-chart me-2"></i> Performance</a>
      <a class="nav-link" href="#"><i class="bx bx-support me-2"></i> Support</a>
      <a class="nav-link" href="{{ url('/') }}"><i class="bx bx-home me-2"></i> Main Page</a>

      <!-- ✅ Proper Logout form -->
      <form method="POST" action="{{ route('logout') }}" class="d-inline">
        @csrf
        <button type="submit" class="nav-link btn btn-link mt-2 text-start">
          <i class="bx bx-log-out me-2"></i> Logout
        </button>
      </form>
    </nav>
  </aside>

  <!-- Overlay -->
  <div id="mask" class="content-mask"></div>

  <!-- Main Content -->
  <div class="flex-grow-1">
    <header class="topbar">
      <div class="left">
        <button id="btnToggle" class="btn btn-outline-secondary d-lg-none">
          <i class="bx bx-menu"></i>
        </button>
        <img src="{{ asset('images/jacelogoclean.png') }}" alt="JaceTrack logo" />
        <div>
          <h6 class="m-0">Rider Dashboard</h6>
          <small class="text-muted">Welcome back, {{ Auth::user()->name }}!</small>
        </div>
      </div>
      <div class="d-flex align-items-center">
        <div class="me-3 small text-muted">ID: <strong>#RDR-{{ Auth::id() }}</strong></div>
        <div class="icons">
          <i class="bx bx-bell"></i>
          <i class="bx bx-user-circle"></i>
        </div>
      </div>
    </header>

    <main class="container-fluid p-4">
      <div class="row g-3">
        <div class="col-12 col-md-4">
          <div class="dashboard-card">
            <div class="dashboard-title">Active Deliveries</div>
            <div class="d-flex justify-content-between align-items-end">
              <div>
                <h2 class="text-primary mb-0">3</h2>
                <small class="text-muted">Ongoing</small>
              </div>
              <i class="bx bx-truck fs-1 text-muted"></i>
            </div>
          </div>
        </div>

        <div class="col-12 col-md-4">
          <div class="dashboard-card">
            <div class="dashboard-title">Completed Today</div>
            <div class="d-flex justify-content-between align-items-end">
              <div>
                <h2 class="text-success mb-0">8</h2>
                <small class="text-muted">Delivered</small>
              </div>
              <i class="bx bx-check-circle fs-1 text-muted"></i>
            </div>
          </div>
        </div>

        <div class="col-12 col-md-4">
          <div class="dashboard-card">
            <div class="dashboard-title">Earnings</div>
            <div class="d-flex justify-content-between align-items-end">
              <div>
                <h2 class="text-warning mb-0">₱2,350</h2>
                <small class="text-muted">Today</small>
              </div>
              <i class="bx bx-wallet fs-1 text-muted"></i>
            </div>
          </div>
        </div>
      </div>

      <div class="dashboard-card">
        <div class="d-flex justify-content-between align-items-center mb-3">
          <div class="dashboard-title">My Deliveries</div>
          <button class="btn btn-sm btn-outline-primary">
            <i class="bx bx-refresh"></i> Refresh
          </button>
        </div>

        <div class="table-responsive">
          <table class="table table-borderless align-middle">
            <thead>
              <tr class="text-muted small">
                <th>#</th>
                <th>Tracking No.</th>
                <th>Pickup</th>
                <th>Drop-off</th>
                <th>Status</th>
                <th class="text-end">Action</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>1</td>
                <td><strong>JX-20250928-011</strong></td>
                <td>Rosales</td>
                <td>Villasis</td>
                <td><span class="badge bg-warning text-dark">In Transit</span></td>
                <td class="text-end"><button class="btn btn-sm btn-outline-secondary">Update</button></td>
              </tr>
              <tr>
                <td>2</td>
                <td><strong>JX-20250928-007</strong></td>
                <td>Urdaneta</td>
                <td>Dagupan</td>
                <td><span class="badge bg-success">Delivered</span></td>
                <td class="text-end"><button class="btn btn-sm btn-outline-secondary">Details</button></td>
              </tr>
              <tr>
                <td>3</td>
                <td><strong>JX-20250928-005</strong></td>
                <td>Umingan</td>
                <td>Rosales</td>
                <td><span class="badge bg-danger">Failed</span></td>
                <td class="text-end"><button class="btn btn-sm btn-outline-secondary">Retry</button></td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </main>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
  const sidebar = document.getElementById('sidebar');
  const mask = document.getElementById('mask');
  document.getElementById('btnToggle').addEventListener('click', () => {
    sidebar.classList.toggle('open');
    mask.classList.toggle('show');
  });
  mask.addEventListener('click', () => {
    sidebar.classList.remove('open');
    mask.classList.remove('show');
  });
</script>

<script src="{{ asset('js/preloader.js') }}"></script>
</body>
</html>
