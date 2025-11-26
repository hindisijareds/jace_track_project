<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>JaceTrack - My Orders</title>

  <link rel="shortcut icon" href="{{ asset('images/jacelogoclean.png') }}" type="image/png" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/style_customer_dashboard.css') }}" />
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
        <small>Customer</small>
      </div>
    </div>

    <nav class="nav flex-column">
      <a class="nav-link" href="{{ route('dashboard') }}"><i class="bx bx-home me-2"></i> Dashboard</a>
      <a class="nav-link active" href="#"><i class="bx bx-package me-2"></i> My Orders</a>
      <a class="nav-link" href="#"><i class="bx bx-wallet me-2"></i> Payments</a>
      <a class="nav-link" href="#"><i class="bx bx-map me-2"></i> Track Parcel</a>
      <a class="nav-link" href="{{ route('profile') }}"><i class="bx bx-user me-2"></i> Profile</a>
      <a class="nav-link" href="#"><i class="bx bx-help-circle me-2"></i> Support</a>
      <a class="nav-link" href="{{ url('/') }}"><i class="bx bx-home me-2"></i> Main Page</a>

      <form method="POST" action="{{ route('logout') }}" class="d-inline">
        @csrf
        <button type="submit" class="nav-link btn btn-link mt-2 text-start">
            <i class="bx bx-log-out me-2"></i> Logout
        </button>
      </form>
    </nav>
  </aside>

  <!-- Page Content -->
  <div class="flex-grow-1">
    
    <!-- Topbar -->
    <header class="topbar">
      <div class="left">
        <button id="btnToggle" class="btn btn-outline-secondary d-lg-none"><i class="bx bx-menu"></i></button>
        <img src="{{ asset('images/jacelogoclean.png') }}" alt="logo" />

        <div>
          <h6 class="m-0">My Orders</h6>
          <small class="text-muted">Welcome, {{ Auth::user()->first_name ?? 'Customer' }}!</small>
        </div>
      </div>
      <div class="d-flex align-items-center">
        <div class="me-3 text-muted small">
            ID: <strong>#CUST-{{ str_pad(Auth::id(), 4, '0', STR_PAD_LEFT) }}</strong>
        </div>
        <i class="bx bx-user-circle fs-3"></i>
      </div>
    </header>

    <main class="container-fluid p-4">

      <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="dashboard-title">All Orders</h5>
        <a href="{{ url('shipment') }}" class="btn btn-primary btn-lg">
          <i class="bx bx-plus"></i> Create Order
        </a>
      </div>
<div class="mb-4">
    <ul class="nav nav-pills">
    <li class="nav-item">
    <a class="nav-link {{ request('status') == 'pending' ? 'active' : '' }}" 
       href="{{ route('orders', ['status' => 'pending']) }}">
       Pending Approval
    </a>
</li>

        <li class="nav-item">
            <a class="nav-link {{ request('status') == '' ? 'active' : '' }}" href="{{ route('orders') }}">All</a>
        </li>

        <li class="nav-item">
            <a class="nav-link {{ request('status') == 'transit' ? 'active' : '' }}" href="{{ route('orders', ['status' => 'transit']) }}">
                In Transit
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link {{ request('status') == 'delivered' ? 'active' : '' }}" href="{{ route('orders', ['status' => 'delivered']) }}">
                Delivered
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link {{ request('status') == 'cancelled' ? 'active' : '' }}" href="{{ route('orders', ['status' => 'cancelled']) }}">
                Cancelled
            </a>
        </li>
    </ul>
</div>

      <div class="table-responsive">
        <table class="table table-borderless align-middle">
          <thead>
            <tr class="text-muted small">
              <th>#</th>
              <th>Tracking No.</th>
              <th>Recipient</th>
              <th>Status</th>
              <th>Date</th>
              <th class="text-end">Actions</th>
            </tr>
          </thead>

           @forelse ($shipments as $index => $shipment)
    <tr>
      <td>{{ $index + 1 }}</td>
      <td><strong>{{ $shipment->tracking_number }}</strong></td>
      <td>{{ $shipment->receiver_name }}</td>
      <td>
        @if($shipment->status === 'pending')
  <span class="badge bg-secondary">Pending</span>
@elseif($shipment->status === 'approved')
  <span class="badge bg-info text-dark">Approved</span>
@elseif($shipment->status === 'assigned')
  <span class="badge bg-primary text-light">Assigned</span>
@elseif($shipment->status === 'transit')
  <span class="badge bg-warning text-dark">In Transit</span>
@elseif($shipment->status === 'delivered')
  <span class="badge bg-success">Delivered</span>
@elseif($shipment->status === 'cancelled')
  <span class="badge bg-danger">Cancelled</span>
@else
  <span class="badge bg-dark">Unknown</span>
@endif


      </td>
      <td>{{ $shipment->created_at->format('Y-m-d') }}</td>
      <td class="text-end">
  <button 
  class="btn btn-sm btn-outline-primary"
  onclick='showOrderDetails(@json($shipment->toArray()))'>
  View
</button>

<a href="{{ route('order.track', $shipment->tracking_number) }}" 
   class="btn btn-sm btn-outline-secondary">
    Track
</a>

</td>

    </tr>

            @empty
    <tr>
      <td colspan="6" class="text-center text-muted">No orders yet.</td>
    </tr>
  @endforelse
          </tbody>
        </table>
      </div>

    </main>
  </div>
</div>

<!-- MODAL -->
<div class="modal fade" id="orderModal" tabindex="-1">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Order Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body" id="orderDetails">
        Loading...
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
function showOrderDetails(shipment) {
    console.log(shipment);
let costBreakdown = `
  <div class="mt-3 p-3 border rounded bg-light">
    <h6 class="fw-bold mb-2"><i class="bx bx-calculator"></i> Cost Breakdown</h6>
    <div class="row small">
      <div class="col-md-6">
        <p><strong>Distance:</strong> ${shipment.distance_km ?? 0} km</p>
        <p><strong>Fuel Used:</strong> ${shipment.fuel_liters ?? 0} L</p>
        <p><strong>Fuel Cost:</strong> ₱${parseFloat(shipment.fuel_cost ?? 0).toFixed(2)}</p>
        <p><strong>Maintenance:</strong> ₱${parseFloat(shipment.maintenance_cost ?? 0).toFixed(2)}</p>
      </div>
      <div class="col-md-6">
        <p><strong>Box (Size):</strong> ₱${parseFloat(shipment.box_size_cost ?? 0).toFixed(2)}</p>
        <p><strong>Box (Weight):</strong> ₱${parseFloat(shipment.box_weight_cost ?? 0).toFixed(2)}</p>
        <p><strong>Box Total:</strong> ₱${parseFloat(shipment.box_total_cost ?? 0).toFixed(2)}</p>
        <hr>
        <p class="fw-bold text-primary fs-5">
          <i class="bx bx-wallet"></i> Total Cost: ₱${parseFloat(shipment.total_cost ?? 0).toFixed(2)}
        </p>
      </div>
    </div>
  </div>
`;


  let details = `
    <div class="row mb-3">
      <div class="col-md-6">
        <h6><strong>Tracking Number:</strong> ${shipment.tracking_number}</h6>
        <p><strong>Status:</strong> 
          ${shipment.status === 'pending' 
            ? '<span class="badge bg-warning text-dark">Pending</span>' 
            : shipment.status === 'delivered' 
              ? '<span class="badge bg-success">Delivered</span>' 
              : '<span class="badge bg-danger">Cancelled</span>'}
        </p>
        <p><strong>Date Created:</strong> ${shipment.created_at}</p>
      </div>
      <div class="col-md-6">
        <p><strong>Item:</strong> ${shipment.item_name}</p>
        <p><strong>Type:</strong> ${shipment.parcel_type}</p>
        <p><strong>Weight:</strong> ${shipment.parcel_weight} kg</p>
        <p><strong>Dimensions:</strong> 
          ${shipment.dimension_l || '-'} × ${shipment.dimension_w || '-'} × ${shipment.dimension_h || '-'}
        </p>
        <p><strong>Value:</strong> ₱${shipment.parcel_value ?? '0.00'}</p>
      </div>
    </div>

    <hr>
    <div class="row">
      <div class="col-md-6">
        <h6><i class="bx bx-send"></i> Sender</h6>
        <p><strong>${shipment.sender_name}</strong><br>
        ${shipment.sender_phone}<br>
        ${shipment.sender_address}<br>
        <small>${shipment.sender_detailed || ''}</small></p>
      </div>
      <div class="col-md-6">
        <h6><i class="bx bx-package"></i> Receiver</h6>
        <p><strong>${shipment.receiver_name}</strong><br>
        ${shipment.receiver_phone}<br>
        ${shipment.receiver_address}<br>
        <small>${shipment.receiver_detailed || ''}</small></p>
      </div>
    </div>

    ${costBreakdown}
  `;

  document.getElementById('orderDetails').innerHTML = details;
  new bootstrap.Modal(document.getElementById('orderModal')).show();
}
</script>

<script src="{{ asset('js/preloader.js') }}"></script>

</body>
</html>
