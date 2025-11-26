<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Rider Details - JaceTrack Admin</title>

  <link rel="shortcut icon" href="{{ asset('images/jacelogoclean.png') }}" type="image/png" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/style_admin_dashboard.css') }}">

  <style>
    body { background-color: #f5f7fb; }
    .dashboard-card { 
        background: #fff; 
        border-radius: 12px; 
        border: none;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        padding: 0; 
        overflow: hidden;
        margin-bottom: 24px;
    }
    .card-header-custom {
        padding: 20px;
        border-bottom: 1px solid #f0f0f0;
        background: #fff;
    }
    .avatar-circle {
        width: 80px;
        height: 80px;
        background-color: #e9ecef;
        color: #495057;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        font-size: 1.5rem;
    }
    /* Fix pagination styling */
.pagination {
  margin-bottom: 0;
  justify-content: center; /* Center the pagination */
}

.pagination .page-item .page-link {
  color: #495057;
  border: 1px solid #dee2e6;
  padding: 0.5rem 0.75rem;
  margin: 0 2px;
  border-radius: 6px;
  transition: all 0.2s ease;
}

.pagination .page-item.active .page-link {
  background-color: #0d6efd;
  border-color: #0d6efd;
  color: white;
  font-weight: 600;
}

.pagination .page-item.disabled .page-link {
  color: #6c757d;
  pointer-events: none;
  background-color: #fff;
  border-color: #dee2e6;
}

.pagination .page-item:hover .page-link {
  background-color: #f8f9fa;
  border-color: #adb5bd;
}

/* If pagination appears broken in the card */
.dashboard-card .border-top {
  background-color: #fff;
  border-top: 1px solid #f0f0f0 !important;
}
  </style>
</head>

<body>

<div id="preloader">
  <img src="{{ asset('images/jacelogoclean.png') }}" alt="JaceTrack Logo">
</div>

<header class="topbar d-flex align-items-center justify-content-between">
  <div class="d-flex align-items-center gap-3">
    <button class="btn btn-outline-secondary d-lg-none" data-bs-toggle="offcanvas" data-bs-target="#mobileSidebar">
      <i class="bx bx-menu"></i>
    </button>

    <div class="brand d-flex align-items-center gap-2">
      <img src="{{ asset('images/jacelogoclean.png') }}" alt="JaceTrack logo">
      <div>
        <h6>JaceTrack - Admin</h6>
        <small class="text-muted">Rider Monitoring</small>
      </div>
    </div>
  </div>

  <div class="d-flex align-items-center gap-3">
    <div class="text-muted small">Admin ID: <strong>#ADM-001</strong></div>
    <i class="bx bx-bell fs-4 text-muted"></i>
    <i class="bx bx-user-circle fs-4 text-muted"></i>
  </div>
</header>

<div class="container-fluid">
  <div class="row">

    <aside class="col-lg-2 d-none d-lg-block sidebar">
      <div class="brand">
        <img src="{{ asset('images/jacelogoclean.png') }}" alt="JaceTrack logo">
        <div>
          <div style="font-weight:700; font-size:1rem;">JaceTrack</div>
          <small>Admin</small>
        </div>
      </div>

      <nav class="nav flex-column">
        <a class="nav-link" href="{{ route('admin.dashboard') }}"><i class="bx bx-home me-2"></i> Dashboard</a>
        <a class="nav-link" href="{{ route('admin.deliveries') }}"><i class="bx bx-package me-2"></i> Deliveries</a>
        <a class="nav-link active" href="{{ route('admin.riders.create') }}"><i class="bx bx-user me-2"></i> Riders</a>
        <a class="nav-link" href="{{ route('admin.reports') }}"><i class="bx bx-line-chart me-2"></i> Reports</a>
        <a class="nav-link" href="{{ route('admin.payment_proofs') }}"><i class="bx bx-money me-2"></i> Payments</a>
        <a class="nav-link" href="#"><i class="bx bx-money me-2"></i> Income</a>
        <a class="nav-link" href="#"><i class="bx bx-cog me-2"></i> Settings</a>
        <a class="nav-link" href="{{ route('admin.requests') }}"><i class="bx bx-mail-send me-2"></i> Request Changes</a>
        <a class="nav-link" href="{{ route('admin.deletion.requests') }}"><i class="bx bx-user-x me-2"></i> Deletion Requests</a>
        <a class="nav-link" href="{{ url('/') }}"><i class="bx bx-home me-2"></i> Main Page</a>

        <form method="POST" action="{{ route('logout') }}" class="d-inline">
          @csrf
          <button type="submit" class="nav-link btn btn-link mt-3 text-start text-danger">
            <i class="bx bx-log-out me-2"></i> Logout
          </button>
        </form>
      </nav>
    </aside>

    <main class="col-12 col-lg-10 px-4 py-4">
<div class="mb-3">
    <a href="{{ route('admin.riders.create') }}" class="btn btn-outline-secondary btn-sm">
      <i class="bx bx-arrow-back me-1"></i> Back to Riders
    </a>
  </div>
      <!-- Rider Profile Card -->
      <div class="dashboard-card mb-4">
        <div class="card-header-custom">
          <h6 class="mb-0 fw-bold">Rider Profile</h6>
        </div>
        <div class="p-4">
          <div class="row align-items-center">
            <div class="col-md-2 text-center mb-3 mb-md-0">
              <div class="avatar-circle mx-auto">
                {{ substr($rider->first_name, 0, 1) }}{{ substr($rider->last_name, 0, 1) }}
              </div>
            </div>
            <div class="col-md-5">
              <h4 class="fw-bold mb-1">{{ $rider->first_name }} {{ $rider->middle_name }} {{ $rider->last_name }}</h4>
              <p class="text-muted mb-2">{{ $rider->email }}</p>
              <p class="mb-1"><i class="bx bx-phone me-2"></i> {{ $rider->contact_number ?? $rider->phone ?? 'N/A' }}</p>
              <p class="mb-0"><i class="bx bx-map me-2"></i> {{ $rider->city ?? 'N/A' }}, {{ $rider->barangay ?? 'N/A' }}</p>
            </div>
            <div class="col-md-5 text-md-end">
              <div class="row g-2">
                <div class="col-6 col-md-4">
                  <div class="bg-light p-2 rounded text-center">
                    <h5 class="fw-bold mb-0">{{ $completedDeliveries }}</h5>
                    <small class="text-muted">Completed</small>
                  </div>
                </div>
                <div class="col-6 col-md-4">
                  <div class="bg-light p-2 rounded text-center">
                    <h5 class="fw-bold mb-0">{{ $pendingDeliveries }}</h5>
                    <small class="text-muted">Active</small>
                  </div>
                </div>
                <div class="col-6 col-md-4">
                  <div class="bg-light p-2 rounded text-center">
                    <h5 class="fw-bold mb-0">{{ $totalDeliveries }}</h5>
                    <small class="text-muted">Total</small>
                  </div>
                </div>
              </div>
              <div class="mt-2">
                <span class="badge bg-{{ $rider->status == 'active' ? 'success' : 'secondary' }} bg-opacity-10 text-{{ $rider->status == 'active' ? 'success' : 'secondary' }}">
                  {{ ucfirst($rider->status) }}
                </span>
                <small class="text-muted d-block mt-1">Rider ID: #RDR-{{ $rider->id }}</small>
              </div>
            </div>
          </div>

          <!-- Address & Vehicle Info -->
          <div class="row mt-4 pt-3 border-top">
            <div class="col-md-6">
              <h6 class="fw-bold mb-2">Address Information</h6>
              <p class="text-muted small mb-1">
                <strong>City:</strong> {{ $rider->city ?? 'N/A' }}<br>
                <strong>Barangay:</strong> {{ $rider->barangay ?? 'N/A' }}<br>
                <strong>Zip Code:</strong> {{ $rider->zip_code ?? 'N/A' }}<br>
                <strong>Detailed Address:</strong> {{ $rider->detailed_address ?? 'N/A' }}
              </p>
            </div>
            <div class="col-md-6">
              <h6 class="fw-bold mb-2">Vehicle Information</h6>
              <p class="text-muted small mb-1">
                <strong>Type:</strong> {{ $rider->vehicle_type ?? 'Not Specified' }}<br>
                <strong>License Plate:</strong> {{ $rider->license_plate ?? 'N/A' }}<br>
                <strong>Driver's License:</strong> 
                @if($rider->profile_picture)
                  <a href="{{ asset('storage/' . $rider->profile_picture) }}" target="_blank" class="text-decoration-none">
                    <i class="bx bx-id-card me-1"></i> View License
                  </a>
                @else
                  <span class="text-muted">Not uploaded</span>
                @endif
              </p>
            </div>
          </div>
        </div>
      </div>

     <!-- Current Deliveries -->
<div class="dashboard-card mb-4">
  <div class="card-header-custom">
    <h6 class="mb-0 fw-bold"><i class="bx bx-package me-2"></i>Current Deliveries</h6>
  </div>
  <div class="table-responsive">
    <table class="table table-hover align-middle mb-0">
      <thead>
        <tr>
          <th class="ps-4">Order ID</th>
          <th>Customer</th>
          <th>Pickup</th>
          <th>Drop-off</th>
          <th>Status</th>
          <th class="text-end pe-4">Amount</th>
        </tr>
      </thead>
      <tbody>
        @forelse($currentDeliveries as $delivery)
        <tr>
          <td class="ps-4 fw-bold">#{{ $delivery->order_id }}</td>
          <td>
            <div class="fw-bold">{{ $delivery->customer->name ?? 'N/A' }}</div>
            <small class="text-muted">{{ $delivery->customer->email ?? '' }}</small>
          </td>
          <td class="small">
            {{ $delivery->sender_address ?? 'N/A' }}
            @if(!empty($delivery->sender_detailed))
              <br><small class="text-muted">{{ $delivery->sender_detailed }}</small>
            @endif
          </td>
          <td class="small">
            {{ $delivery->receiver_address ?? 'N/A' }}
            @if(!empty($delivery->receiver_detailed))
              <br><small class="text-muted">{{ $delivery->receiver_detailed }}</small>
            @endif
          </td>
          <td>
            <span class="badge bg-{{ $delivery->status == 'transit' ? 'warning text-dark' : ($delivery->status == 'assigned' ? 'info' : 'secondary') }} bg-opacity-10 text-{{ $delivery->status == 'transit' ? 'warning' : ($delivery->status == 'assigned' ? 'info' : 'secondary') }}">
              {{ ucfirst($delivery->status) }}
            </span>
          </td>
          <td class="text-end pe-4 fw-bold">₱{{ number_format($delivery->total_cost, 2) }}</td>
        </tr>
        @empty
        <tr>
          <td colspan="6" class="text-center py-4 text-muted">
            <i class="bx bx-inbox fs-1 mb-2"></i>
            <p class="mb-0">No active deliveries for this rider</p>
          </td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>
  
  <!-- Pagination for Current Deliveries -->
@if($currentDeliveries->hasPages())
  <div class="px-4 py-3 border-top">
    {{ $currentDeliveries->links('pagination::bootstrap-5') }}
  </div>
@endif
</div>
      <!-- Delivery History -->
<div class="dashboard-card">
  <div class="card-header-custom">
    <h6 class="mb-0 fw-bold"><i class="bx bx-history me-2"></i>Delivery History</h6>
  </div>
  <div class="table-responsive">
    <table class="table table-hover align-middle mb-0">
      <thead>
        <tr>
          <th class="ps-4">Order ID</th>
          <th>Customer</th>
          <th>Pickup</th>
          <th>Drop-off</th>
          <th>Delivered At</th>
          <th class="text-end pe-4">Amount</th>
        </tr>
      </thead>
      <tbody>
        @forelse($deliveryHistory as $history)
        <tr>
          <td class="ps-4 fw-bold">#{{ $history->order_id }}</td>
          <td>
            <div class="fw-bold">{{ $history->customer->name ?? 'N/A' }}</div>
            <small class="text-muted">{{ $history->customer->email ?? '' }}</small>
          </td>
          <td class="small">
            {{ $history->sender_address ?? 'N/A' }}
            @if(!empty($history->sender_detailed))
              <br><small class="text-muted">{{ $history->sender_detailed }}</small>
            @endif
          </td>
          <td class="small">
            {{ $history->receiver_address ?? 'N/A' }}
            @if(!empty($history->receiver_detailed))
              <br><small class="text-muted">{{ $history->receiver_detailed }}</small>
            @endif
          </td>
          <td class="small">{{ $history->delivered_at ? Carbon\Carbon::parse($history->delivered_at)->format('M d, Y h:i A') : 'N/A' }}</td>
          <td class="text-end pe-4 fw-bold">₱{{ number_format($history->total_cost, 2) }}</td>
        </tr>
        @empty
        <tr>
          <td colspan="6" class="text-center py-4 text-muted">
            <i class="bx bx-calendar-x fs-1 mb-2"></i>
            <p class="mb-0">No completed deliveries yet</p>
          </td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>
  
  <!-- Pagination for Delivery History -->
@if($deliveryHistory->hasPages())
  <div class="px-4 py-3 border-top">
    {{ $deliveryHistory->links('pagination::bootstrap-5') }}
  </div>
  @endif
</div>

    </main>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('js/preloader.js') }}"></script>

</body>
</html>