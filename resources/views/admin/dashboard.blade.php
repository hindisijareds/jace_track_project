<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>JaceTrack - Admin Dashboard (Responsive)</title>
  <link rel="shortcut icon" href="{{ asset('images/jacelogoclean.png') }}" type="image/png" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/style_admin_dashboard.css') }}" />
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

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
      <a class="nav-link active" href="#"><i class="bx bx-home me-2"></i> Dashboard</a>
      <a class="nav-link" href="{{ route('admin.deliveries') }}"><i class="bx bx-package me-2"></i> Deliveries</a>
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
        <a class="nav-link active" href="#"><i class="bx bx-home me-2"></i> Dashboard</a>
        <a class="nav-link" href="{{ route('admin.deliveries') }}"><i class="bx bx-package me-2"></i> Deliveries</a>
        <a class="nav-link" href="{{ route('admin.riders.create') }}"><i class="bx bx-user me-2"></i> Riders</a>
          <a class="nav-link" href="{{ route('admin.reports') }}"><i class="bx bx-line-chart me-2"></i> Reports</a>
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
      
      <div class="row g-4 mb-4">
        <div class="col-6 col-md-3">
          <div class="dashboard-card text-center d-flex flex-column justify-content-center align-items-center">
            <div class="dashboard-title text-uppercase text-secondary" style="font-size: 0.8rem;">Total Deliveries</div>
            <h3 class="text-primary mb-1 display-6 fw-bold">{{ $totalDeliveries ?? 0 }}</h3>
            <span class="badge bg-light text-secondary rounded-pill">All-time</span>
          </div>
        </div>
        <div class="col-6 col-md-3">
          <div class="dashboard-card text-center d-flex flex-column justify-content-center align-items-center">
            <div class="dashboard-title text-uppercase text-secondary" style="font-size: 0.8rem;">Active Riders</div>
            <h3 class="text-success mb-1 display-6 fw-bold">{{ $activeRiders ?? 0 }}</h3>
            <span class="badge bg-light text-success rounded-pill">● Online now</span>
          </div>
        </div>
        <div class="col-6 col-md-3">
          <div class="dashboard-card text-center d-flex flex-column justify-content-center align-items-center">
            <div class="dashboard-title text-uppercase text-secondary" style="font-size: 0.8rem;">Monthly Income</div>
            <h3 class="text-warning mb-1 display-6 fw-bold">₱45k</h3>
            <span class="badge bg-light text-warning rounded-pill">After fees</span>
          </div>
        </div>
        <div class="col-6 col-md-3">
          <div class="dashboard-card text-center d-flex flex-column justify-content-center align-items-center">
            <div class="dashboard-title text-uppercase text-secondary" style="font-size: 0.8rem;">Failed Deliveries</div>
            <h3 class="text-danger mb-1 display-6 fw-bold">{{ $failedDeliveries ?? 0 }}</h3>
            <span class="badge bg-light text-danger rounded-pill">Needs Attention</span>
          </div>
        </div>
      </div>

      <div class="row g-4 mb-4">
        <div class="col-lg-6">
          <div class="dashboard-card">
            <div class="d-flex justify-content-between align-items-center mb-4">
              <h6 class="dashboard-title mb-0">Delivery Trends</h6>
              <span class="badge bg-primary bg-opacity-10 text-primary">Last 7 days</span>
            </div>
            <div class="chart-wrap">
              <canvas id="deliveryChart"></canvas>
            </div>
          </div>
        </div>

        <div class="col-lg-6">
          <div class="dashboard-card">
            <div class="d-flex justify-content-between align-items-center mb-4">
              <h6 class="dashboard-title mb-0">Income Overview</h6>
              <span class="badge bg-success bg-opacity-10 text-success">This Month</span>
            </div>
            <div class="chart-wrap">
              <canvas id="incomeChart"></canvas>
            </div>
          </div>
        </div>
      </div>

      <div class="dashboard-card">
        <div class="d-flex justify-content-between align-items-center mb-3">
          <h5 class="dashboard-title mb-0">Recent Deliveries</h5>
          <a href="{{ route('admin.deliveries') }}" class="btn btn-sm btn-primary px-3 rounded-pill">View All</a>
        </div>

        <div class="table-responsive">
          <table class="table align-middle">
            <thead class="text-muted">
              <tr>
                <th>Tracking</th>
                <th>Details</th>
                <th>Rider</th>
                <th>Status</th>
                <th>Payment</th>
                <th>Proof</th>
                <th class="text-end">Actions</th>
              </tr>
            </thead>
            <tbody>
              @forelse ($shipments as $index => $delivery)
                <tr data-id="{{ $delivery->id }}">
                  <td>
                    <strong>{{ $delivery->tracking_number }}</strong>
                  </td>
                  <td>
                    <small class="d-block text-muted">From: {{ Str::limit($delivery->sender_address, 15) }}</small>
                    <small class="d-block text-muted">To: {{ Str::limit($delivery->receiver_address, 15) }}</small>
                  </td>
                  <td>{{ $delivery->rider_name ?? 'Unassigned' }}</td>
                  <td>
                    @switch($delivery->status)
                        @case('pending') <span class="badge bg-warning text-dark">Pending</span> @break
                        @case('approved') <span class="badge bg-secondary">Approved</span> @break
                        @case('assigned') <span class="badge bg-info text-dark">Assigned</span> @break
                        @case('delivered') <span class="badge bg-success">Delivered</span> @break
                        @case('cancelled') <span class="badge bg-danger">Cancelled</span> @break
                        @default <span class="badge bg-light text-dark">{{ ucfirst($delivery->status) }}</span>
                    @endswitch
                  </td>
                  <td>
                    @if($delivery->payment_status === 'awaiting_verification')
                      <form action="{{ route('admin.approvePayment', $delivery->order_id) }}" method="POST" style="display:inline;">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-outline-success" title="Approve Payment">
                          <i class="bx bx-check"></i>
                        </button>
                      </form>
                    @elseif($delivery->payment_status === 'paid')
                      <span class="text-success"><i class='bx bxs-check-circle'></i> Paid</span>
                    @else
                      <span class="text-danger"><i class='bx bxs-x-circle'></i> Unpaid</span>
                    @endif
                  </td>
                  <td>
                    @if($delivery->proof_of_delivery)
                        <button class="btn btn-sm btn-light border" 
                            onclick="openProofModal('{{ asset('storage/' . $delivery->proof_of_delivery) }}', '{{ $delivery->order_id }}', '{{ $delivery->proof_status ?? 'pending' }}')">
                            <i class='bx bx-image'></i> View
                        </button>
                    @else
                        <span class="text-muted small">-</span>
                    @endif
                  </td>

                  <td class="text-end">
                    <div class="d-flex justify-content-end gap-1">
                        @if($delivery->status == 'pending')
                            <button class="btn btn-sm btn-success" onclick="approveShipment('{{ $delivery->order_id }}')">Approve</button>
                            <button class="btn btn-sm btn-outline-danger" onclick="cancelShipment('{{ $delivery->order_id }}')">Cancel</button>

                        @elseif($delivery->status == 'approved')
                            <button class="btn btn-sm btn-primary" onclick="openAssignModal('{{ $delivery->order_id }}')">Assign</button>
                            <button class="btn btn-sm btn-outline-danger" onclick="cancelShipment('{{ $delivery->order_id }}')">Cancel</button>

                        @elseif($delivery->status == 'assigned')
                            <button class="btn btn-sm btn-success" onclick="markDelivered('{{ $delivery->order_id }}')">Complete</button>
                            <button class="btn btn-sm btn-outline-danger" onclick="cancelShipment('{{ $delivery->order_id }}')">Cancel</button>

                        @elseif($delivery->status == 'delivered')
                            <span class="text-muted"><i class='bx bx-check-double'></i> Done</span>

                        @elseif($delivery->status == 'cancelled')
                            <span class="text-muted">Cancelled</span>
                        @endif
                    </div>
                  </td>
                </tr>
              @empty
                <tr><td colspan="7" class="text-center text-muted py-4">No recent deliveries found.</td></tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>

      <div class="dashboard-card mt-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
          <h5 class="dashboard-title mb-0">Pending Proofs of Delivery</h5>
        </div>

        @if(isset($pendingProofs) && $pendingProofs->isNotEmpty())
        <div class="table-responsive">
          <table class="table align-middle">
            <thead class="text-muted">
              <tr>
                <th>Order ID</th>
                <th>Proof</th>
                <th class="text-end">Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach($pendingProofs as $proof)
                <tr>
                  <td>#{{ $proof->order_id }}</td>
                  <td>
                    <a href="{{ asset('storage/' . $proof->proof_of_delivery) }}" target="_blank">
                      <img src="{{ asset('storage/' . $proof->proof_of_delivery) }}"
                           alt="Proof"
                           style="width: 50px; height: 50px; object-fit: cover; border-radius: 6px; border:1px solid #ddd;">
                    </a>
                  </td>
                  <td class="text-end">
                    <form action="{{ route('admin.confirmProof') }}" method="POST" class="d-inline">
                      @csrf
                      <input type="hidden" name="order_id" value="{{ $proof->order_id }}">
                      <button type="submit" class="btn btn-sm btn-success"><i class='bx bx-check'></i></button>
                    </form>
                    <form action="{{ route('admin.rejectProof') }}" method="POST" class="d-inline">
                      @csrf
                      <input type="hidden" name="order_id" value="{{ $proof->order_id }}">
                      <button type="submit" class="btn btn-sm btn-danger"><i class='bx bx-x'></i></button>
                    </form>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
        @else
          <p class="text-muted mb-0 text-center py-3">No pending proofs at the moment.</p>
        @endif
      </div>

    </main>
  </div>
</div>

<div class="modal fade" id="proofModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header border-0">
        <h5 class="modal-title">Proof of Delivery</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body text-center bg-light">
        <img id="proofImage" src="" alt="Proof" class="img-fluid rounded shadow-sm mb-3" style="max-height: 500px;">
        <div id="proofActions" class="text-center mt-3"></div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="assignModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-sm modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Assign Rider</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <input type="hidden" id="assignId">
        <div class="mb-2">
          <label class="form-label">Select Rider</label>
          <select id="assignRiderSelect" class="form-select">
            <option value="">-- Choose Rider --</option>
            @foreach($riders as $rider)
              <option value="{{ $rider->id }}">{{ $rider->first_name }} {{ $rider->last_name }}</option>
            @endforeach
          </select>
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button class="btn btn-primary" onclick="submitAssignRider()">Assign</button>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

@php
    $deliveryLabels = $deliveryLabels ?? ['Mon','Tue','Wed','Thu','Fri','Sat','Sun'];
    $deliveryData = $deliveryData ?? [20,25,18,30,22,27,10];
    $incomeLabels = $incomeLabels ?? ['Week 1','Week 2','Week 3','Week 4'];
    $incomeData = $incomeData ?? [12000,15000,11000,17000];
@endphp

<script>
document.addEventListener("DOMContentLoaded", function() {
  // === Charts ===
  const deliveryCtx = document.getElementById('deliveryChart').getContext('2d');
  const incomeCtx = document.getElementById('incomeChart').getContext('2d');

  new Chart(deliveryCtx, {
    type: 'line',
    data: { 
      labels: @json($deliveryLabels), 
      datasets: [{ 
          label: 'Deliveries', 
          data: @json($deliveryData), 
          borderColor: '#0d6efd',
          backgroundColor: 'rgba(13, 110, 253, 0.1)',
          fill: true, 
          tension: 0.4 
      }] 
    },
    options: { responsive:true, maintainAspectRatio:false, plugins:{legend:{display:false}}, scales:{y:{beginAtZero:true, grid:{display:false}}, x:{grid:{display:false}}} }
  });

  new Chart(incomeCtx, {
    type: 'bar',
    data: { 
      labels: @json($incomeLabels), 
      datasets: [{ 
          label:'Income', 
          data: @json($incomeData),
          backgroundColor: '#198754',
          borderRadius: 4
      }] 
    },
    options: { responsive:true, maintainAspectRatio:false, plugins:{legend:{display:false}}, scales:{y:{beginAtZero:true}, x:{grid:{display:false}}} }
  });

  // === Bootstrap Modal for Assign Rider ===
  const assignModal = new bootstrap.Modal(document.getElementById('assignModal'));

  window.openAssignModal = function(orderId) {
    document.getElementById('assignId').value = orderId;
    document.getElementById('assignRiderSelect').value = '';
    assignModal.show();
  };

  window.submitAssignRider = function() {
    const orderId = document.getElementById('assignId').value;
    const riderId = document.getElementById('assignRiderSelect').value;

    if (!riderId) {
      alert('Please select a rider first.');
      return;
    }

    const fd = new FormData();
    fd.append('order_id', orderId);
    fd.append('rider_id', riderId);
    fd.append('_token', '{{ csrf_token() }}');

    fetch("{{ route('admin.shipments.assign') }}", {
      method: 'POST',
      body: fd
    })
    .then(res => res.json())
    .then(data => {
      if (data.success) {
        alert(data.message || 'Rider assigned successfully!');
        assignModal.hide();
        location.reload();
      } else {
        alert(data.message || 'Failed to assign rider.');
      }
    })
    .catch(err => console.error('Error assigning rider:', err));
  };
});

// === Approve Shipment Function ===
function approveShipment(orderId) {
  if (!orderId) return alert('Missing order id');
  if (!confirm('Approve this shipment?')) return;

  const fd = new FormData();
  fd.append('order_id', orderId);

  fetch("{{ route('admin.shipments.approve') }}", {
    method: 'POST',
    headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
    body: fd
  })
  .then(res => res.json())
  .then(data => {
      if (data.success) {
        alert(data.message || 'Shipment approved.');
        location.reload();
      } else {
        alert(data.message || 'Failed to approve shipment.');
      }
  })
  .catch(err => {
    console.error('Approve error:', err);
    alert('Network error while approving shipment.');
  });
}

// === FIXED: Mark Delivered ===
function markDelivered(id) {
  if (!confirm('Mark this shipment as delivered?')) return;

  // FIX: Using 'order_id' to match standard and fixed content-type
  fetch("{{ route('admin.shipments.delivered') }}", {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'X-CSRF-TOKEN': '{{ csrf_token() }}'
    },
    body: JSON.stringify({ order_id: id }) 
  })
  .then(response => response.json())
  .then(data => {
    if (data.success) {
      alert('Shipment marked as delivered successfully!');
      location.reload();
    } else {
      alert(data.message || 'Failed to mark delivered.');
    }
  })
  .catch(err => console.error('Error:', err));
}

// === FIXED: Cancel Shipment ===
function cancelShipment(id) {
  // FIX: Removed 'by' parameter from input, hardcoded to 'admin' internally
  if (!confirm('Cancel this shipment?')) return;
  
  fetch("{{ route('admin.shipments.cancel') }}", {
    method: 'POST',
    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
    body: JSON.stringify({ 
        shipment_id: id, // Ensure your controller checks both shipment_id OR order_id, or match here
        order_id: id,    // Sending both to be safe
        cancelled_by: 'admin' // FIX: Explicitly stating Admin cancelled it
    })
  }).then(() => location.reload());
}
</script>

<script>
  const proofModal = new bootstrap.Modal(document.getElementById('proofModal'));

  window.openProofModal = function(imageUrl, orderId, proofStatus) {
    document.getElementById('proofImage').src = imageUrl;
    let actions = '';

    if (proofStatus === 'pending') {
      actions = `
        <button class="btn btn-success me-2" onclick="confirmProof('${orderId}')">Confirm</button>
        <button class="btn btn-danger" onclick="rejectProof('${orderId}')">Reject</button>
      `;
    } else if (proofStatus === 'confirmed') {
      actions = `<span class="badge bg-success">Already Confirmed</span>`;
    } else if (proofStatus === 'rejected') {
      actions = `<span class="badge bg-danger">Rejected</span>`;
    }

    document.getElementById('proofActions').innerHTML = actions;
    proofModal.show();
  }

  function confirmProof(orderId) {
    if (!confirm('Confirm this proof of delivery?')) return;

    fetch("{{ route('admin.confirmProof') }}", {
      method: 'POST',
      headers: { 
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': '{{ csrf_token() }}' 
      },
      body: JSON.stringify({ order_id: orderId })
    })
    .then(res => res.json())
    .then(data => {
      alert(data.message);
      location.reload();
    });
  }

  function rejectProof(orderId) {
    if (!confirm('Reject this proof of delivery?')) return;

    fetch("{{ route('admin.rejectProof') }}", {
      method: 'POST',
      headers: { 
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': '{{ csrf_token() }}' 
      },
      body: JSON.stringify({ order_id: orderId })
    })
    .then(res => res.json())
    .then(data => {
      alert(data.message);
      location.reload();
    });
  }
</script>

<script src="{{ asset('js/preloader.js') }}"></script>
</body>
</html>