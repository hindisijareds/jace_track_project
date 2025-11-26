<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>JaceTrack - Deliveries Management</title>
  <link rel="shortcut icon" href="{{ asset('images/jacelogoclean.png') }}" type="image/png">
  
  {{-- Bootstrap & Icons --}}
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
  
  {{-- Custom CSS --}}
  <link rel="stylesheet" href="{{ asset('css/style_admin_dashboard.css') }}">
  
  {{-- UI Polish Styles --}}
  <style>
    body { background-color: #f5f7fb; }
    
    /* Modern Dashboard Card */
    .dashboard-card { 
        background: #fff; 
        border-radius: 12px; 
        border: none;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        padding: 0; 
        overflow: hidden;
        margin-bottom: 24px;
        transition: transform 0.2s;
    }

    .card-header-custom {
        padding: 20px;
        border-bottom: 1px solid #f0f0f0;
        display: flex;
        justify-content: space-between;
        align-items: center;
        background: #fff;
    }
    
    /* Table Polish */
    .table thead th { 
        text-transform: uppercase; 
        font-size: 0.75rem; 
        font-weight: 600;
        letter-spacing: 0.5px; 
        color: #6c757d; 
        background-color: #f8f9fa; 
        border-bottom: 1px solid #eee; 
        padding: 12px 16px;
    }
    .table tbody td { 
        padding: 16px; 
        vertical-align: middle; 
        border-bottom: 1px solid #f0f0f0;
        font-size: 0.9rem;
    }
    .table tbody tr:hover { background-color: #fcfcfc; }
    
    /* Badges & Buttons */
    .badge { font-weight: 500; padding: 6px 10px; border-radius: 6px; }
    
    /* Dropdown Styling */
    .dropdown-menu { border: none; box-shadow: 0 4px 15px rgba(0,0,0,0.1); border-radius: 8px; }
    .dropdown-item { padding: 8px 16px; font-size: 0.9rem; }
    .dropdown-item:active { background-color: #e9ecef; color: #000; }

    /* === PAGINATION FIXES === */
    .pagination {
        margin: 0;
        padding: 0;
        gap: 4px;
    }
    .results-info {
    font-size: 0.875rem;
    color: #6c757d;
    font-weight: 500;
    margin: 0;
    line-height: 1.5; /* Match pagination button height */
}

.pagination {
    margin: 0 !important; /* Override any default margins */
}
    .page-item .page-link {
        border: 1px solid #dee2e6;
        border-radius: 8px;
        padding: 8px 14px;
        font-size: 0.875rem;
        font-weight: 500;
        color: #495057;
        background: #fff;
        transition: all 0.2s;
    }
    
    .page-item .page-link:hover {
        background: #e9ecef;
        color: #0d6efd;
        transform: translateY(-1px);
    }
    
    .page-item.active .page-link {
        background: #0d6efd;
        color: #fff;
        border-color: #0d6efd;
    }
    
    .page-item.disabled .page-link {
        color: #adb5bd;
        pointer-events: none;
        background: #f8f9fa;
    }
    
    .pagination .page-link i {
        font-size: 1rem;
        vertical-align: middle;
    }
    
    /* Results info styling */
    .results-info {
        font-size: 0.875rem;
        color: #6c757d;
        font-weight: 500;
    }
  </style>
</head>
<body>

<header class="topbar d-flex align-items-center justify-content-between">
  <div class="d-flex align-items-center gap-3">
    <button class="btn btn-outline-secondary d-lg-none" data-bs-toggle="offcanvas" data-bs-target="#mobileSidebar">
      <i class="bx bx-menu"></i>
    </button>
    <div class="brand d-flex align-items-center gap-2">
      <img src="{{ asset('images/jacelogoclean.png') }}" alt="logo">
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
    <h5 class="m-0 d-flex align-items-center gap-2">
      <img src="{{ asset('images/jacelogoclean.png') }}" alt="logo" style="height:34px;"> JaceTrack
    </h5>
    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"></button>
  </div>
  <div class="offcanvas-body p-0">
    <nav class="nav flex-column p-3">
      <a class="nav-link" href="#"><i class="bx bx-home me-2"></i> Dashboard</a>
      <a class="nav-link active" href="{{ route('admin.deliveries') }}"><i class="bx bx-package me-2"></i> Deliveries</a>
      <a class="nav-link" href="{{ route('admin.riders.create') }}"><i class="bx bx-user me-2"></i> Riders</a>
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
        <a class="nav-link" href="{{ route('dashboard') }}"><i class="bx bx-home me-2"></i> Dashboard</a>
        <a class="nav-link active" href="{{ route('admin.deliveries') }}"><i class="bx bx-package me-2"></i> Deliveries</a>
        <a class="nav-link" href="{{ route('admin.riders.create') }}"><i class="bx bx-user me-2"></i> Riders</a>
      <a class="nav-link" href="{{ route('admin.reports') }}"><i class="bx bx-line-chart me-2"></i> Reports</a>
        <a class="nav-link" href="{{ route('admin.payments') }}"><i class="bx bx-money me-2"></i> Payments</a>
        <a class="nav-link" href="#"><i class="bx bx-money me-2"></i> Income</a>
        <a class="nav-link" href="#"><i class="bx bx-cog me-2"></i> Settings</a>
        <a class="nav-link" href="{{ route('admin.requests') }}"><i class="bx bx-mail-send me-2"></i> Requests</a>
        <a class="nav-link" href="{{ route('admin.deletion.requests') }}"><i class="bx bx-user-x me-2"></i> Request Deletion</a>
        <a class="nav-link" href="landing.html"><i class="bx bx-home me-2"></i> Main Page</a>
        <form method="POST" action="{{ route('logout') }}" class="d-inline">
          @csrf
          <button type="submit" class="nav-link btn btn-link mt-3 text-start text-danger">
            <i class="bx bx-log-out me-2"></i> Logout
          </button>
        </form>
      </nav>
    </aside>

    {{-- UPDATED MAIN BODY CONTENT --}}
<main class="col-12 col-lg-10 px-4 py-4">
  
  {{-- Page Title Section --}}
  <div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h5 class="fw-bold text-dark mb-0">Deliveries Management</h5>
        <small class="text-muted">Filter and manage all shipment statuses</small>
    </div>
    <div class="d-flex gap-2">
        <button class="btn btn-white border bg-white shadow-sm text-muted" onclick="location.reload()">
            <i class="bx bx-refresh"></i>
        </button>
        <button class="btn btn-primary shadow-sm">
            <i class="bx bx-plus me-1"></i> New Shipment
        </button>
    </div>
  </div>

  {{-- Filter Controls --}}
  <div class="dashboard-card mb-3">
    <div class="card-header-custom">
        <div class="row align-items-end g-2">
            <div class="col-md-3">
                <label class="form-label small text-muted mb-1">Start Date</label>
                <input type="date" class="form-control form-control-sm" id="startDate" 
                       value="{{ request('start_date') }}" onchange="applyFilters()">
            </div>
            <div class="col-md-3">
                <label class="form-label small text-muted mb-1">End Date</label>
                <input type="date" class="form-control form-control-sm" id="endDate" 
                       value="{{ request('end_date') }}" onchange="applyFilters()">
            </div>
            <div class="col-md-2">
                <label class="form-label small text-muted mb-1">Assignment</label>
                <select class="form-select form-select-sm" id="assignmentFilter" onchange="applyFilters()">
                    <option value="all" {{ request('assignment') == 'all' ? 'selected' : '' }}>All</option>
                    <option value="assigned" {{ request('assignment') == 'assigned' ? 'selected' : '' }}>Assigned</option>
                    <option value="unassigned" {{ request('assignment') == 'unassigned' ? 'selected' : '' }}>Unassigned</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label small text-muted mb-1">Quick Status Filter</label>
                <select class="form-select form-select-sm" id="statusFilter" onchange="applyFilters()">
                    <option value="all" {{ request('status') == 'all' || !request('status') ? 'selected' : '' }}>All Status</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="assigned" {{ request('status') == 'assigned' ? 'selected' : '' }}>Assigned</option>
                    <option value="transit" {{ request('status') == 'transit' ? 'selected' : '' }}>In Transit</option>
                    <option value="delivered" {{ request('status') == 'delivered' ? 'selected' : '' }}>Delivered</option>
                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
            </div>
            <div class="col-md-1 d-flex align-items-end">
                <button class="btn btn-sm btn-outline-secondary w-100" onclick="resetFilters()">
                    <i class="bx bx-refresh"></i>
                </button>
            </div>
        </div>
    </div>
  </div>

{{-- Tab Navigation --}}
@php
    // Ensure $statusCounts exists and is a collection
    $statusCounts = $statusCounts ?? collect();
    $currentStatus = request('status', 'all');
    
    // Safely get counts with defaults
    $allCount = $statusCounts->sum();
    $pendingCount = $statusCounts->get('pending', 0);
    $assignedCount = $statusCounts->get('assigned', 0);
    $transitCount = $statusCounts->get('transit', 0);
    $deliveredCount = $statusCounts->get('delivered', 0);
    $cancelledCount = $statusCounts->get('cancelled', 0);
@endphp

<ul class="nav nav-pills mb-3" id="deliveryTabs" role="tablist">
    <li class="nav-item" role="presentation">
        <a class="nav-link {{ $currentStatus == 'all' ? 'active' : '' }} fw-semibold" 
           href="{{ route('admin.deliveries', array_merge(request()->except('status', 'page'), ['status' => 'all'])) }}" 
           role="tab">
           All <span class="badge bg-secondary ms-1">{{ $allCount }}</span>
        </a>
    </li>
    <li class="nav-item" role="presentation">
        <a class="nav-link {{ $currentStatus == 'pending' ? 'active' : '' }} fw-semibold" 
           href="{{ route('admin.deliveries', array_merge(request()->except('status', 'page'), ['status' => 'pending'])) }}" 
           role="tab">
           Pending <span class="badge bg-warning text-dark ms-1">{{ $pendingCount }}</span>
        </a>
    </li>
    <li class="nav-item" role="presentation">
        <a class="nav-link {{ $currentStatus == 'assigned' ? 'active' : '' }} fw-semibold" 
           href="{{ route('admin.deliveries', array_merge(request()->except('status', 'page'), ['status' => 'assigned'])) }}" 
           role="tab">
           Assigned <span class="badge bg-info ms-1">{{ $assignedCount }}</span>
        </a>
    </li>
    <li class="nav-item" role="presentation">
        <a class="nav-link {{ $currentStatus == 'transit' ? 'active' : '' }} fw-semibold" 
           href="{{ route('admin.deliveries', array_merge(request()->except('status', 'page'), ['status' => 'transit'])) }}" 
           role="tab">
           In Transit <span class="badge bg-primary ms-1">{{ $transitCount }}</span>
        </a>
    </li>
    <li class="nav-item" role="presentation">
        <a class="nav-link {{ $currentStatus == 'delivered' ? 'active' : '' }} fw-semibold" 
           href="{{ route('admin.deliveries', array_merge(request()->except('status', 'page'), ['status' => 'delivered'])) }}" 
           role="tab">
           Delivered <span class="badge bg-success ms-1">{{ $deliveredCount }}</span>
        </a>
    </li>
    <li class="nav-item" role="presentation">
        <a class="nav-link {{ $currentStatus == 'cancelled' ? 'active' : '' }} fw-semibold" 
           href="{{ route('admin.deliveries', array_merge(request()->except('status', 'page'), ['status' => 'cancelled'])) }}" 
           role="tab">
           Cancelled <span class="badge bg-danger ms-1">{{ $cancelledCount }}</span>
        </a>
    </li>
</ul>

  {{-- Deliveries Card --}}
  <div class="dashboard-card">
    <div class="card-header-custom">
        <div class="d-flex align-items-center gap-2">
            <h6 class="fw-bold mb-0 text-dark">
                {{ ucfirst(request('status', 'All')) }} Shipments
            </h6>
            <span class="badge bg-primary bg-opacity-10 text-primary">{{ $shipments->total() }} Total</span>
        </div>
        <div class="d-flex gap-2">
            <input type="text" class="form-control form-control-sm" placeholder="Search tracking..." id="searchInput" 
                   value="{{ request('search') }}" onkeyup="if(event.key==='Enter') applySearch()">
            <button class="btn btn-sm btn-outline-secondary" onclick="applySearch()">
                <i class="bx bx-search"></i>
            </button>
        </div>
    </div>

    <div class="table-responsive">
      <table class="table align-middle mb-0">
        <thead>
          <tr>
            <th class="ps-4">Tracking / Date</th>
            <th>Customer</th>
            <th>Addresses</th>
            <th>Rider</th>
            <th>Status</th>
            <th>Payment</th>
            <th>Proof</th>
            <th class="text-end pe-4">Actions</th>
          </tr>
        </thead>
        <tbody>
          @forelse ($shipments as $index => $delivery)
            <tr data-id="{{ $delivery->id }}">
              {{-- Tracking & Date --}}
              <td class="ps-4">
                <div class="fw-bold text-dark">{{ $delivery->tracking_number }}</div>
                <small class="text-muted" style="font-size:0.75rem;">
                    {{ $delivery->created_at->format('M d, Y') }}
                </small>
              </td>
              
              {{-- Customer --}}
              <td>
                <div class="d-flex align-items-center gap-2">
                    <div class="bg-light rounded-circle d-flex align-items-center justify-content-center text-primary fw-bold" style="width:32px; height:32px; font-size:0.8rem;">
                        {{ substr($delivery->sender_name, 0, 1) }}
                    </div>
                    <div>
                        <div class="fw-semibold text-dark" style="font-size:0.9rem;">{{ $delivery->sender_name }}</div>
                        <small class="text-muted d-block" style="font-size:0.75rem;">{{ $delivery->sender_phone }}</small>
                    </div>
                </div>
              </td>
              
              {{-- Addresses --}}
              <td>
                <small class="d-block text-muted">From: <span class="text-dark">{{ \Illuminate\Support\Str::limit($delivery->sender_address, 15) }}</span></small>
                <small class="d-block text-muted">To: <span class="text-dark">{{ \Illuminate\Support\Str::limit($delivery->receiver_address, 15) }}</span></small>
              </td>
              
              {{-- Rider --}}
              <td>
                @if($delivery->rider_name)
                    <span class="d-inline-flex align-items-center gap-1 text-primary">
                        <i class='bx bx-user'></i> {{ $delivery->rider_name }}
                    </span>
                @else
                    <span class="text-muted fst-italic small">Unassigned</span>
                @endif
              </td>
              
              {{-- Status --}}
              <td>
                @switch($delivery->status)
                    @case('pending') <span class="badge bg-warning text-dark">Pending</span> @break
                    @case('approved') <span class="badge bg-secondary">Approved</span> @break
                    @case('assigned') <span class="badge bg-info text-dark">Assigned</span> @break
                    @case('transit') <span class="badge bg-primary">In Transit</span> @break
                    @case('delivered') <span class="badge bg-success">Delivered</span> @break
                    @case('cancelled') <span class="badge bg-danger">Cancelled</span> @break
                    @default <span class="badge bg-light text-dark">{{ ucfirst($delivery->status) }}</span>
                @endswitch
              </td>
              
              {{-- Payment --}}
              <td>
                @if($delivery->payment_status === 'awaiting_verification')
                    <form action="{{ route('admin.approvePayment', $delivery->order_id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-outline-success py-0 px-2" style="font-size: 0.75rem;">
                            Verify
                        </button>
                    </form>
                @elseif($delivery->payment_status === 'paid')
                    <span class="text-success small fw-bold"><i class="bx bx-check-circle"></i> Paid</span>
                @else
                    <span class="text-danger small fw-bold">Unpaid</span>
                @endif
              </td>

              {{-- Proof --}}
              <td>
                @if($delivery->proof_of_delivery)
                  <button class="btn btn-light border btn-sm" 
                        style="font-size: 0.8rem;"
                        onclick="openProofModal('{{ asset('storage/' . $delivery->proof_of_delivery) }}', '{{ $delivery->order_id }}', '{{ $delivery->proof_status ?? 'pending' }}')">
                    <i class='bx bx-image-alt'></i> View
                  </button>
                @else
                  <span class="text-muted small">-</span>
                @endif
              </td>

              {{-- Actions Dropdown --}}
              <td class="text-end pe-4">
                <div class="dropdown">
                    <button class="btn btn-light btn-sm border-0 rounded-circle" data-bs-toggle="dropdown">
                        <i class="bx bx-dots-vertical-rounded"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end shadow">
                        <li>
                            <button class="dropdown-item text-primary" onclick='showOrderDetails(@json($delivery))'>
                                <i class="bx bx-show me-2"></i> View Details
                            </button>
                        </li>
                        <li>
                            <a class="dropdown-item text-secondary" href="{{ route('order.track', $delivery->tracking_number) }}" target="_blank">
                                <i class="bx bx-map me-2"></i> Track Order
                            </a>
                        </li>
                        
                        <li><hr class="dropdown-divider"></li>

                        @if($delivery->status == 'pending')
                            <li><a class="dropdown-item text-success" href="#" onclick="approveShipment('{{ $delivery->order_id }}')"><i class="bx bx-check me-2"></i> Approve</a></li>
                            <li><a class="dropdown-item text-danger" href="#" onclick="cancelShipment('{{ $delivery->order_id }}')"><i class="bx bx-x me-2"></i> Cancel</a></li>
                        
                        @elseif($delivery->status == 'approved')
                            <li><a class="dropdown-item text-info" href="#" onclick="openAssignModal('{{ $delivery->order_id }}')"><i class="bx bx-user-plus me-2"></i> Assign Rider</a></li>
                            <li><a class="dropdown-item text-danger" href="#" onclick="cancelShipment('{{ $delivery->order_id }}')"><i class="bx bx-x me-2"></i> Cancel</a></li>
                        
                        @elseif(in_array($delivery->status, ['assigned', 'transit']))
                            <li><a class="dropdown-item text-success" href="#" onclick="markDelivered('{{ $delivery->order_id }}')"><i class="bx bx-package me-2"></i> Mark Delivered</a></li>
                            <li><a class="dropdown-item text-danger" href="#" onclick="cancelShipment('{{ $delivery->order_id }}')"><i class="bx bx-x me-2"></i> Cancel</a></li>
                        @endif
                    </ul>
                </div>
              </td>
            </tr>
          @empty
            <tr>
                <td colspan="8" class="text-center py-5">
                    <div class="text-muted">
                        <i class="bx bx-box fs-1 mb-2"></i>
                        <p>No deliveries found for this filter.</p>
                    </div>
                </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

{{-- PAGINATION FIX - Modern Design --}}
@if($shipments->hasPages())
<div class="p-3 border-top bg-light">
    <div class="row align-items-center g-3">
        {{-- Results Info --}}
        <div class="col-12 col-md-5">
            <div class="d-flex align-items-center gap-2">
                <i class="bx bx-list-check text-muted opacity-75 fs-5"></i>
                <div class="results-info">
                    <span class="text-muted">Showing</span>
                    <span class="fw-semibold text-dark">{{ $shipments->firstItem() }}-{{ $shipments->lastItem() }}</span>
                    <span class="text-muted">of</span>
                    <span class="fw-semibold text-dark">{{ $shipments->total() }}</span>
                    <span class="text-muted">shipments</span>
                </div>
            </div>
        </div>
        
        {{-- Pagination --}}
        <div class="col-12 col-md-7">
            <div class="d-flex justify-content-start justify-content-md-end">
                {{ $shipments->appends(request()->except('page'))->links('vendor.pagination.bootstrap-5') }}
            </div>
        </div>
    </div>
</div>
@endif
  </div>
</main>

{{-- Add this JavaScript at the bottom before the </body> tag --}}
<script>
function applyFilters() {
    const status = document.getElementById('statusFilter').value;
    const assignment = document.getElementById('assignmentFilter').value;
    const startDate = document.getElementById('startDate').value;
    const endDate = document.getElementById('endDate').value;
    
    const params = new URLSearchParams();
    if (status && status !== 'all') params.set('status', status);
    if (assignment && assignment !== 'all') params.set('assignment', assignment);
    if (startDate) params.set('start_date', startDate);
    if (endDate) params.set('end_date', endDate);
    
    window.location.href = '{{ route("admin.deliveries") }}?' + params.toString();
}

function resetFilters() {
    window.location.href = '{{ route("admin.deliveries") }}';
}

function applySearch() {
    const search = document.getElementById('searchInput').value;
    const params = new URLSearchParams(window.location.search);
    if (search) {
        params.set('search', search);
    } else {
        params.delete('search');
    }
    window.location.href = '{{ route("admin.deliveries") }}?' + params.toString();
}
</script>

{{-- Bootstrap JS Bundle --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('js/preloader.js') }}"></script>
</body>
</html>