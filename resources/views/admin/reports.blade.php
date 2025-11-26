<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>JaceTrack - Reports & Analytics</title>
  <link rel="shortcut icon" href="{{ asset('images/jacelogoclean.png') }}" type="image/png" />
  
  {{-- Bootstrap & Icons --}}
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
  
  {{-- Custom CSS --}}
  <link rel="stylesheet" href="{{ asset('css/style_admin_dashboard.css') }}" />
  
  {{-- Chart.js --}}
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

  {{-- UI Styles Matching Admin Dashboard --}}
  <style>
    body { background-color: #f5f7fb; }
    
    .dashboard-card {
        background: #fff;
        border-radius: 12px;
        padding: 20px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        border: none;
        margin-bottom: 20px;
        height: 100%;
        transition: transform 0.2s;
    }

    .dashboard-title {
        font-weight: 600;
        color: #495057;
        margin-bottom: 15px;
        font-size: 1rem;
    }

    .table thead th {
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.5px;
        background-color: #f8f9fa;
        border-bottom: 1px solid #eee;
        padding: 12px;
    }
    
    .table tbody tr:hover { background-color: #fcfcfc; }
    .table tbody td { vertical-align: middle; padding: 12px; font-size: 0.9rem; }

    .chart-wrap { position: relative; height: 300px; width: 100%; }
    
    /* Badges */
    .badge { font-weight: 500; padding: 6px 10px; border-radius: 6px; }
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
        <small class="text-muted">Analytics & Performance</small>
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
      <a class="nav-link active" href="#"><i class="bx bx-line-chart me-2"></i> Reports</a>
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
        <a class="nav-link" href="{{ route('admin.dashboard') }}"><i class="bx bx-home me-2"></i> Dashboard</a>
        <a class="nav-link" href="{{ route('admin.deliveries') }}"><i class="bx bx-package me-2"></i> Deliveries</a>
        <a class="nav-link" href="{{ route('admin.riders.create') }}"><i class="bx bx-user me-2"></i> Riders</a>
        
        {{-- ACTIVE STATE --}}
        <a class="nav-link active" href="#"><i class="bx bx-line-chart me-2"></i> Reports</a>
        
 <a class="nav-link" href="{{ route('admin.payment_proofs') }}"><i class="bx bx-money me-2"></i> Payments</a>
        <a class="nav-link" href="#"><i class="bx bx-money me-2"></i> Income</a>
        <a class="nav-link" href="#"><i class="bx bx-cog me-2"></i> Settings</a>
        <a class="nav-link" href="{{ route('admin.requests') }}"><i class="bx bx-mail-send me-2"></i> Request Changes</a>
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

    <main class="col-12 col-lg-10 px-4 py-4">
      
      {{-- Header Actions --}}
      <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h5 class="fw-bold text-dark mb-0">System Reports</h5>
            <small class="text-muted">Financial & Operational Overview</small>
        </div>
        <div class="d-flex gap-2">
            <button class="btn btn-white border bg-white shadow-sm text-muted" onclick="window.print()">
                <i class="bx bx-printer"></i> Print
            </button>
            <button class="btn btn-primary shadow-sm">
                <i class="bx bx-download me-1"></i> Export Data
            </button>
        </div>
      </div>

      {{-- KPI CARDS --}}
      <div class="row g-3 mb-3">
        <div class="col-6 col-md-3">
          <div class="dashboard-card text-center d-flex flex-column justify-content-center align-items-center">
            <div class="dashboard-title text-uppercase text-secondary" style="font-size: 0.8rem;">Total Revenue</div>
            <h3 class="text-primary mb-1 display-6 fw-bold">₱{{ number_format($totalRevenue ?? 0, 2) }}</h3>
            <span class="badge bg-light text-secondary rounded-pill">Year to Date</span>
          </div>
        </div>
        <div class="col-6 col-md-3">
          <div class="dashboard-card text-center d-flex flex-column justify-content-center align-items-center">
            <div class="dashboard-title text-uppercase text-secondary" style="font-size: 0.8rem;">Total Deliveries</div>
            <h3 class="text-info mb-1 display-6 fw-bold">{{ $totalDeliveries ?? 0 }}</h3>
            <span class="badge bg-light text-secondary rounded-pill">All Time</span>
          </div>
        </div>
        <div class="col-6 col-md-3">
          <div class="dashboard-card text-center d-flex flex-column justify-content-center align-items-center">
            <div class="dashboard-title text-uppercase text-secondary" style="font-size: 0.8rem;">Active Riders</div>
            <h3 class="text-success mb-1 display-6 fw-bold">{{ $activeRiders ?? 0 }}</h3>
            <span class="badge bg-light text-success rounded-pill">Currently Active</span>
          </div>
        </div>
        <div class="col-6 col-md-3">
          <div class="dashboard-card text-center d-flex flex-column justify-content-center align-items-center">
            <div class="dashboard-title text-uppercase text-secondary" style="font-size: 0.8rem;">Issues / Returns</div>
            <h3 class="text-danger mb-1 display-6 fw-bold">{{ $recentIssues->count() ?? 0 }}</h3>
            <span class="badge bg-light text-danger rounded-pill">Need Attention</span>
          </div>
        </div>
      </div>

      {{-- CHARTS ROW --}}
      <div class="row g-3 mb-3">
        <div class="col-lg-8">
          <div class="dashboard-card">
            <div class="d-flex justify-content-between align-items-start mb-2">
              <div class="dashboard-title">Revenue Trends (This Year)</div>
              <span class="badge bg-primary bg-opacity-10 text-primary">Monthly</span>
            </div>
            <div class="chart-wrap">
              <canvas id="revenueChart"></canvas>
            </div>
          </div>
        </div>

        <div class="col-lg-4">
          <div class="dashboard-card">
            <div class="d-flex justify-content-between align-items-start mb-2">
              <div class="dashboard-title">Status Breakdown</div>
              <small class="text-muted">By Volume</small>
            </div>
            <div class="chart-wrap" style="height: 250px;">
              <canvas id="statusChart"></canvas>
            </div>
            <div class="mt-3 text-center">
                <small class="text-muted">Distribution of all shipments</small>
            </div>
          </div>
        </div>
      </div>

      {{-- TABLES ROW --}}
      <div class="row g-3">
        {{-- ORDERS TABLE ROW --}}
<div class="row g-3 mb-3">
  <div class="col-12">
    <div class="dashboard-card">
      {{-- Header with filters --}}
      <div class="d-flex justify-content-between align-items-center mb-3">
        <div class="dashboard-title mb-0">Recent Orders</div>
        <div class="d-flex gap-2 align-items-center">
          <form method="GET" action="{{ route('admin.reports') }}" class="d-flex gap-2">
            <input type="date" name="start_date" class="form-control form-control-sm" 
                   value="{{ request('start_date') }}" style="width: 150px;">
            <input type="date" name="end_date" class="form-control form-control-sm" 
                   value="{{ request('end_date') }}" style="width: 150px;">
            <button type="submit" class="btn btn-sm btn-primary">
              <i class="bx bx-filter"></i> Filter
            </button>
          </form>
        </div>
      </div>

      {{-- Orders Table --}}
      <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
          <thead style="background: #f8f9fa;">
            <tr>
              <th>Order ID</th>
              <th>Date</th>
              <th>Item Details</th>
              <th>Sender → Receiver</th>
              <th>Payment</th>
              <th class="text-end">Total Cost</th>
              <th>Status</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            @forelse($recentOrders as $order)
            <tr>
              <td>
                <strong class="text-primary">#{{ $order->id }}</strong>
              </td>
              <td>
                <div class="fw-semibold">{{ $order->created_at->format('M d') }}</div>
                <small class="text-muted">{{ $order->created_at->format('Y') }}</small>
              </td>
              <td>
                <div class="fw-semibold">{{ $order->item_name }}</div>
                <small class="text-muted">{{ ucfirst($order->parcel_type) }}</small>
              </td>
              <td>
                <div class="small">
                  <i class="bx bx-user-circle text-primary"></i> {{ $order->sender_name }}
                  <i class="bx bx-right-arrow-alt mx-1 text-muted"></i>
                  <i class="bx bx-user text-success"></i> {{ $order->receiver_name }}
                </div>
              </td>
              <td>
  @php
    $paymentDisplay = 'Pay on Pickup (Cash)'; // Default for pickup orders
    
    if (!empty($order->payment_method)) {
        if ($order->payment_method === 'gcash') {
            $paymentDisplay = 'Online Payment (GCash)';
        } elseif ($order->payment_method === 'bank_transfer') {
            $paymentDisplay = 'Online Payment (Bank Transfer)';
        } else {
            $paymentDisplay = ucwords(str_replace('_', ' ', $order->payment_method));
        }
    }
  @endphp
  
  <span class="badge bg-light text-dark">
    {{ $paymentDisplay }}
  </span>
</td>
              <td class="text-end fw-bold text-success">₱{{ number_format($order->total_cost, 2) }}</td>
              <td>
                @php
                  $statusColors = [
                      'pending' => 'warning',
                      'assigned' => 'info',
                      'picked_up' => 'primary',
                      'in_transit' => 'secondary',
                      'delivered' => 'success',
                      'cancelled' => 'danger',
                      'returned' => 'dark'
                  ];
                @endphp
                <span class="badge bg-{{ $statusColors[$order->status] ?? 'secondary' }} text-white">
                  {{ ucfirst($order->status) }}
                </span>
              </td>
              <td>
  @if($order && $order->id)
  <a href="{{ route('admin.shipment.show', $order->id) }}" 
     class="btn btn-sm btn-outline-primary" target="_blank">
    <i class="bx bx-show"></i> View
  </a>
  @else
  <span class="text-muted small">-</span>
  @endif
</td>

            </tr>
            @empty
            <tr>
              <td colspan="8" class="text-center py-4 text-muted">
                <i class="bx bx-inbox fs-1 d-block mb-2"></i>
                <p class="mb-0">No orders found for the selected date range</p>
              </td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>

      {{-- Summary Footer --}}
      <div class="mt-3 p-3 bg-light rounded">
        <div class="row text-center">
          <div class="col-md-3">
            <div class="fw-bold text-primary fs-5">₱{{ number_format($totalRevenue, 2) }}</div>
            <div class="text-muted small">Total Revenue (Filtered)</div>
          </div>
          <div class="col-md-3">
            <div class="fw-bold fs-5">{{ $recentOrders->where('status', 'delivered')->count() }}</div>
            <div class="text-muted small">Delivered</div>
          </div>
          <div class="col-md-3">
            <div class="fw-bold fs-5">{{ $recentOrders->where('status', 'cancelled')->count() }}</div>
            <div class="text-muted small">Cancelled</div>
          </div>
          <div class="col-md-3">
            <div class="fw-bold fs-5">{{ $recentOrders->count() }}</div>
            <div class="text-muted small">Total Orders</div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
        {{-- Top Riders --}}
        <div class="col-lg-6">
          <div class="dashboard-card">
            <div class="dashboard-title mb-3">Top Performing Riders</div>
            <div class="table-responsive">
              <table class="table table-borderless align-middle">
                <thead class="text-muted small">
                  <tr>
                    <th>Rank</th>
                    <th>Rider Name</th>
                    <th>Completed Orders</th>
                    <th class="text-end">Perf. Score</th>
                  </tr>
                </thead>
                <tbody>
                  @forelse($topRiders as $index => $rider)
                  <tr>
                    <td>
                        @if($index == 0) <span class="badge bg-warning text-dark rounded-circle">1</span>
                        @elseif($index == 1) <span class="badge bg-secondary text-white rounded-circle">2</span>
                        @elseif($index == 2) <span class="badge bg-light text-dark border rounded-circle">3</span>
                        @else {{ $index + 1 }} @endif
                    </td>
                    <td>
                        <div class="fw-bold">{{ $rider->first_name }} {{ $rider->last_name }}</div>
                        <small class="text-muted">{{ $rider->email }}</small>
                    </td>
                    <td>
                        <span class="fw-bold text-success">{{ $rider->completed_deliveries }}</span>
                    </td>
                    <td class="text-end">
                        <span class="badge bg-success bg-opacity-10 text-success">Excellent</span>
                    </td>
                  </tr>
                  @empty
                  <tr><td colspan="4" class="text-center text-muted">No data available.</td></tr>
                  @endforelse
                </tbody>
              </table>
            </div>
          </div>
        </div>

        {{-- Recent Issues --}}
        <div class="col-lg-6">
          <div class="dashboard-card">
            <div class="dashboard-title mb-3">Recent Issues / Cancellations</div>
            <div class="table-responsive">
              <table class="table table-borderless align-middle">
                <thead class="text-muted small">
                  <tr>
                    <th>Tracking</th>
                    <th>Customer</th>
                    <th>Status</th>
                    <th class="text-end">Date</th>
                  </tr>
                </thead>
                <tbody>
                  @forelse($recentIssues as $issue)
                  <tr>
                    <td><span class="fw-bold text-dark">{{ $issue->tracking_number }}</span></td>
                    <td>{{ $issue->customer->first_name ?? 'Unknown' }}</td>
                    <td>
                        @if($issue->status == 'cancelled')
                            <span class="badge bg-danger">Cancelled</span>
                        @else
                            <span class="badge bg-warning text-dark">Returned</span>
                        @endif
                    </td>
                    <td class="text-end text-muted small">{{ $issue->updated_at->format('M d') }}</td>
                  </tr>
                  @empty
                  <tr><td colspan="4" class="text-center text-muted">No recent issues found.</td></tr>
                  @endforelse
                </tbody>
              </table>
            </div>
          </div>
        </div>

      </div>

    </main>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
document.addEventListener("DOMContentLoaded", function() {
    
    // 1. Revenue Chart (Line)
    const ctxRevenue = document.getElementById('revenueChart').getContext('2d');
    new Chart(ctxRevenue, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            datasets: [{
                label: 'Revenue (₱)',
                data: @json($revenueChartData), // Data from Controller
                borderColor: '#0d6efd',
                backgroundColor: 'rgba(13, 110, 253, 0.1)',
                borderWidth: 2,
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: true, grid: { borderDash: [5, 5] } },
                x: { grid: { display: false } }
            }
        }
    });

    // 2. Status Chart (Doughnut)
    const ctxStatus = document.getElementById('statusChart').getContext('2d');
    new Chart(ctxStatus, {
        type: 'doughnut',
        data: {
            labels: ['Delivered', 'Pending', 'Cancelled', 'Returned'],
            datasets: [{
                data: @json($statusChartData), // Data from Controller
                backgroundColor: [
                    '#198754', // Green (Delivered)
                    '#ffc107', // Yellow (Pending)
                    '#dc3545', // Red (Cancelled)
                    '#6c757d'  // Grey (Returned)
                ],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { position: 'bottom' }
            }
        }
    });
});
</script>

<script src="{{ asset('js/preloader.js') }}"></script>
</body>
</html>