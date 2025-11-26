<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>JaceTrack - Rider Profile</title>

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
      <a class="nav-link" href="{{ route('rider.dashboard') }}"><i class="bx bx-home me-2"></i> Dashboard</a>
      <a class="nav-link" href="{{ route('rider.deliveries') }}"><i class="bx bx-package me-2"></i> My Deliveries</a>
      <a class="nav-link active" href="{{ route('rider.profile') }}"><i class="bx bx-user me-2"></i> Profile</a>
      <a class="nav-link" href="#"><i class="bx bx-map me-2"></i> Routes</a>
      <a class="nav-link" href="#"><i class="bx bx-wallet me-2"></i> Earnings</a>
      <a class="nav-link" href="#"><i class="bx bx-line-chart me-2"></i> Performance</a>
      <a class="nav-link" href="#"><i class="bx bx-support me-2"></i> Support</a>
      <a class="nav-link" href="{{ url('/') }}"><i class="bx bx-home me-2"></i> Main Page</a>

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
          <h6 class="m-0">Rider Profile</h6>
          <small class="text-muted">Welcome back, {{ Auth::user()->first_name }} {{ Auth::user()->last_name }}!</small>
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
      @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
          {{ session('success') }}
          <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
      @endif

      <div class="dashboard-card">
        <div class="dashboard-title mb-4">Profile Information</div>
        
        <div class="row">
          <!-- Driver's License Upload Section -->
          <div class="col-12 col-lg-4 mb-4">
            <div class="border p-4 rounded text-center">
              <h6 class="mb-3">Driver's License</h6>
              @if($rider->profile_picture)
                <img src="{{ asset('storage/' . $rider->profile_picture) }}" alt="License Photo" class="img-fluid rounded mb-3" style="max-height: 200px;">
              @else
                <div class="bg-light border rounded d-flex align-items-center justify-content-center mb-3" style="height: 150px;">
                  <i class="bx bx-id-card fs-1 text-muted"></i>
                </div>
              @endif
              <form method="POST" action="{{ route('rider.profile.upload-license') }}" enctype="multipart/form-data">
                @csrf
                <input type="file" name="license_photo" class="form-control mb-3" accept="image/*" required>
                <button type="submit" class="btn btn-primary btn-sm w-100">Upload License</button>
              </form>
            </div>
          </div>

          <!-- Rider Info Section -->
          <div class="col-12 col-lg-8">
            <form method="POST" action="{{ route('rider.profile.update') }}">
              @csrf
              @method('PUT')
              
              <div class="row g-3">
                <!-- Name Fields (Auto-populated) -->
                <div class="col-md-4">
                  <label class="form-label">First Name</label>
                  <input type="text" name="first_name" class="form-control" value="{{ $rider->first_name }}" required>
                </div>
                <div class="col-md-4">
                  <label class="form-label">Middle Name</label>
                  <input type="text" name="middle_name" class="form-control" value="{{ $rider->middle_name ?? '' }}">
                </div>
                <div class="col-md-4">
                  <label class="form-label">Last Name</label>
                  <input type="text" name="last_name" class="form-control" value="{{ $rider->last_name }}" required>
                </div>

                <!-- Contact & Email -->
                <div class="col-md-6">
                  <label class="form-label">Email Address</label>
                  <input type="email" name="email" class="form-control" value="{{ $rider->email }}" required>
                </div>
                <div class="col-md-6">
                  <label class="form-label">Contact Number</label>
                  <input type="text" name="contact_number" class="form-control" value="{{ $rider->contact_number ?? '' }}">
                </div>

                <!-- Address -->
                <div class="col-md-6">
                  <label class="form-label">City</label>
                  <input type="text" name="city" class="form-control" value="{{ $rider->city ?? '' }}">
                </div>
                <div class="col-md-6">
                  <label class="form-label">Barangay</label>
                  <input type="text" name="barangay" class="form-control" value="{{ $rider->barangay ?? '' }}">
                </div>
                <div class="col-md-6">
                  <label class="form-label">Zip Code</label>
                  <input type="text" name="zip_code" class="form-control" value="{{ $rider->zip_code ?? '' }}">
                </div>
                <div class="col-md-6">
                  <label class="form-label">Detailed Address</label>
                  <input type="text" name="detailed_address" class="form-control" value="{{ $rider->detailed_address ?? '' }}">
                </div>

                <!-- Vehicle -->
                <div class="col-md-6">
                  <label class="form-label">Vehicle Type</label>
                  <select name="vehicle_type" class="form-select">
                    <option value="">Select Vehicle</option>
                    <option value="motorcycle" {{ ($rider->vehicle_type ?? '') == 'motorcycle' ? 'selected' : '' }}>Motorcycle</option>
                    <option value="bicycle" {{ ($rider->vehicle_type ?? '') == 'bicycle' ? 'selected' : '' }}>Bicycle</option>
                    <option value="car" {{ ($rider->vehicle_type ?? '') == 'car' ? 'selected' : '' }}>Car</option>
                  </select>
                </div>

                <div class="col-12">
                  <button type="submit" class="btn btn-success">Save Changes</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </main>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('js/preloader.js') }}"></script>
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
</body>
</html>