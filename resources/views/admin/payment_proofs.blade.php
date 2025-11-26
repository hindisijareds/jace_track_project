<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>JaceTrack - Payment Proofs</title>
  <link rel="shortcut icon" href="{{ asset('images/jacelogoclean.png') }}" type="image/png" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css " rel="stylesheet">
  <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css " rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/style_admin_dashboard.css') }}" />
  <script src="https://cdn.jsdelivr.net/npm/chart.js "></script>

  <style>
    /* UI FIXES: Making the body look cleaner */
    body {
        background-color: #f5f7fb; /* Light grey background for contrast */
    }
    
    /* Modern Card Style */
    .dashboard-card {
        background: #fff;
        border-radius: 12px;
        padding: 20px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05); /* Soft shadow */
        border: none;
        margin-bottom: 20px;
        height: 100%;
        transition: transform 0.2s;
    }

    .dashboard-title {
        font-weight: 600;
        color: #495057;
        margin-bottom: 10px;
        font-size: 1rem;
    }

    /* Table Styling */
    .table thead th {
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.5px;
        background-color: #f8f9fa;
        border-bottom: 1px solid #eee;
    }
    
    .table tbody tr:hover {
        background-color: #fcfcfc;
    }

    /* Chart Container */
    .chart-wrap {
        position: relative;
        height: 300px;
        width: 100%;
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
        <small class="text-muted">Operations & Reports</small>
      </div>
    </div>
  </div>
  <div class="d-flex align-items-center gap-3">
    <div class="me-2 text-muted small">Admin ID: <strong>#ADM-001</strong></div>
    <i class="bx bx-bell fs-4 text-muted"></i>
    <i class="bx bx-user-circle fs-4 text-muted"></i>
  </div>
</header>

<div class="offcanvas offcanvas-start" tabindex="-1" id="mobileSidebar">
  <div class="offcanvas-header">
    <h5 id="mobileSidebarLabel" class="m-0 d-flex align-items-center gap-2">
      <img src="{{ asset('images/jacelogoclean.png') }}" alt="logo" style="height:34px;"> JaceTrack
    </h5>
    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"></button>
  </div>
  <div class="offcanvas-body p-0">
    <nav class="nav flex-column p-3">
      <a class="nav-link" href="{{ route('admin.dashboard') }}"><i class="bx bx-home me-2"></i> Dashboard</a>
      <a class="nav-link" href="{{ route('admin.deliveries') }}"><i class="bx bx-package me-2"></i> Deliveries</a>
      <a class="nav-link" href="{{ route('admin.riders.create') }}"><i class="bx bx-user me-2"></i> Riders</a>
      <a class="nav-link" href="{{ route('admin.reports') }}"><i class="bx bx-line-chart me-2"></i> Reports</a>
      <a class="nav-link active" href="{{ route('admin.payment_proofs') }}"><i class="bx bx-credit-card me-2"></i> Payment</a>
      <a class="nav-link" href="#"><i class="bx bx-money me-2"></i> Income</a>
      <a class="nav-link" href="#"><i class="bx bx-cog me-2"></i> Settings</a>
      <a class="nav-link" href="{{ route('admin.requests') }}"><i class="bx bx-mail-send me-2"></i> Requests</a>
      <a class="nav-link" href="{{ route('admin.deletion.requests') }}"><i class="bx bx-user-x me-2"></i> Request Deletion</a>
      <a class="nav-link" href="{{ url('/') }}"><i class="bx bx-home me-2"></i> Main Page</a>
      <form method="POST" action="{{ route('logout') }}" class="d-inline">
        @csrf
        <button type="submit" class="nav-link btn btn-link mt-3 text-start text-danger">
          <i class="bx bx-log-out me-2"></i> Logout
        </button>
      </form>
    </nav>
  </div>
</div>

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
        <a class="nav-link" href="{{ route('admin.riders.create') }}"><i class="bx bx-user me-2"></i> Riders</a>
        <a class="nav-link" href="{{ route('admin.reports') }}"><i class="bx bx-line-chart me-2"></i> Reports</a>
          <a class="nav-link" href="{{ route('admin.reports') }}"><i class="bx bx-line-chart me-2"></i> Reports</a>
        <a class="nav-link" href="{{ route('admin.payment_proofs') }}"><i class="bx bx-money me-2"></i> Payments</a>
        <a class="nav-link" href="#"><i class="bx bx-money me-2"></i> Income</a>
        <a class="nav-link" href="#"><i class="bx bx-cog me-2"></i> Settings</a>
        <a class="nav-link" href="{{ route('admin.requests') }}"><i class="bx bx-mail-send me-2"></i> Requests</a>
        <a class="nav-link" href="{{ route('admin.deletion.requests') }}"><i class="bx bx-user-x me-2"></i> Request Deletion</a>
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
      
      <div class="dashboard-card mb-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
          <h5 class="dashboard-title mb-0">Payment Proofs Verification</h5>
          <span class="badge bg-warning text-dark">
            {{ $pendingProofs->count() }} Pending
          </span>
        </div>

        @if(session('success'))
          <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
          </div>
        @endif
        @if(session('error'))
          <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
          </div>
        @endif

        <div class="table-responsive">
          <table class="table align-middle">
            <thead>
              <tr>
                <th>Order ID</th>
                <th>Customer</th>
                <th>Amount</th>
                <th>Payment Method</th>
                <th>Proof</th>
                <th>Submitted At</th>
                <th class="text-end">Actions</th>
              </tr>
            </thead>
            <tbody>
              @forelse($pendingProofs as $proof)
                <tr>
                  <td><strong>{{ $proof->order_id }}</strong></td>
                  <td>{{ $proof->customer->first_name ?? 'N/A' }} {{ $proof->customer->last_name ?? '' }}</td>
                  <td>₱{{ number_format($proof->total_cost, 2) }}</td>
                  <td>
                    <span class="badge bg-light text-dark">
                      {{ ucwords(str_replace('_', ' ', $proof->payment_method)) }}
                    </span>
                  </td>
                  <td>
                   {{-- Change payment_proof_path TO proof_of_delivery --}}
@if($proof->proof_of_delivery)  {{-- FIX HERE --}}
    <button class="btn btn-sm btn-outline-primary" 
            onclick="viewProof('{{ asset('storage/' . $proof->proof_of_delivery) }}', '{{ $proof->order_id }}')">
        <i class="bx bx-image"></i> View Proof
    </button>
@else
    <span class="text-muted small">No file</span>
@endif
                  </td>
                  <td>{{ $proof->created_at->format('M d, Y h:i A') }}</td>
                  <td class="text-end">
                    <div class="d-flex gap-1 justify-content-end">
                      <form action="{{ route('admin.payment_proofs.approve', $proof->id) }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-success" 
                                onclick="return confirm('Approve payment for order {{ $proof->order_id }}?')">
                          <i class="bx bx-check"></i> Approve
                        </button>
                      </form>
                      <form action="{{ route('admin.payment_proofs.reject', $proof->id) }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-danger" 
                                onclick="return confirm('Reject payment for order {{ $proof->order_id }}?')">
                          <i class="bx bx-x"></i> Reject
                        </button>
                      </form>
                    </div>
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="7" class="text-center text-muted py-4">
                    <i class="bx bx-check-circle fs-1 d-block mb-2"></i>
                    No pending payment proofs
                  </td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>

    </main>
  </div>
</div>

<!-- Proof View Modal -->
<div class="modal fade" id="proofViewModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Payment Proof</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body text-center">
        <img id="modalProofImage" src="" alt="Payment Proof" class="img-fluid rounded">
        <div class="mt-3">
          <small class="text-muted">Order ID: <strong id="modalOrderId"></strong></small>
        </div>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js "></script>

<script>
// Proof view modal function
function viewProof(imageUrl, orderId) {
  document.getElementById('modalProofImage').src = imageUrl;
  document.getElementById('modalOrderId').textContent = orderId;
  const modal = new bootstrap.Modal(document.getElementById('proofViewModal'));
  modal.show();
}

// Auto-hide alerts
document.addEventListener('DOMContentLoaded', function() {
  const alerts = document.querySelectorAll('.alert');
  alerts.forEach(alert => {
    setTimeout(() => {
      const bsAlert = new bootstrap.Alert(alert);
      bsAlert.close();
    }, 5000);
  });
});
</script>

<script src="{{ asset('js/preloader.js') }}"></script>
</body>
</html>