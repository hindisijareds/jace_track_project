<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>JaceTrack - My Deliveries</title>

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
      <a class="nav-link active" href="{{ route('rider.deliveries') }}"><i class="bx bx-package me-2"></i> My Deliveries</a>
        <a class="nav-link" href="{{ route('rider.profile') }}"><i class="bx bx-user me-2"></i> Profile</a>
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
          <h6 class="m-0">My Deliveries</h6>
          <small class="text-muted">Rider: {{ Auth::user()->name }}</small>
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
  <div class="dashboard-card">
    <div class="d-flex justify-content-between align-items-center mb-3">
      <div class="dashboard-title">Assigned Deliveries</div>
      <a href="{{ route('rider.deliveries') }}" class="btn btn-sm btn-outline-primary">
        <i class="bx bx-refresh"></i> Refresh
      </a>
    </div>

    @if(session('success'))
      <div class="alert alert-success small">{{ session('success') }}</div>
    @endif

    <div class="table-responsive">
      <table class="table table-borderless align-middle">
        <thead>
          <tr class="text-muted small">
            <th>#</th>
            <th>Tracking No.</th>
            <th>Customer</th>
            <th>Pickup</th>
            <th>Drop-off</th>
            <th>Status</th>
            <th>Payment</th>
            <th class="text-end">Action</th>
          </tr>
        </thead>
        <tbody>
          @forelse ($deliveries as $index => $delivery)
            <tr>
              <td>{{ $index + 1 }}</td>
              <td><strong>{{ $delivery->tracking_number }}</strong></td>
              <td>{{ $delivery->customer->name ?? $delivery->sender_name ?? 'N/A' }}</td>
              <td>{{ $delivery->pickup ?? 'N/A' }}</td>
              <td>{{ $delivery->dropoff ?? 'N/A' }}</td>
              <td>
                @if($delivery->status === 'delivered')
                  <span class="badge bg-success">Delivered</span>
                @elseif($delivery->status === 'transit')
                  <span class="badge bg-warning text-dark">In Transit</span>
                @elseif($delivery->status === 'cancelled')
                  <span class="badge bg-danger">Cancelled</span>
                @else
                  <span class="badge bg-secondary">{{ ucfirst($delivery->status) }}</span>
                @endif
              </td>
              <td>
                @if($delivery->payment_status === 'paid' || $delivery->payment_status === 'awaiting_verification')
                  <span class="badge bg-success">Paid</span>
                @else
                  <span class="badge bg-danger">Unpaid</span>
                @endif
              </td>
              <td class="text-end">
                @if($delivery->payment_status !== 'paid' && $delivery->payment_status !== 'awaiting_verification')
                  <form action="{{ route('rider.markPaid', $delivery->order_id) }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-outline-success">
                      <i class="bx bx-check"></i> Mark Paid
                    </button>
                  </form>
                @elseif($delivery->status === 'assigned')
  <form action="{{ route('rider.startDelivery', $delivery->order_id) }}" method="POST" class="d-inline">
    @csrf
    <button type="submit" class="btn btn-sm btn-outline-warning">
      <i class="bx bx-play"></i> Start Delivery
    </button>
  </form>
@elseif($delivery->status === 'transit' && !$delivery->proof_of_delivery)
  <button class="btn btn-sm btn-outline-primary"
          onclick="openProofModal('{{ $delivery->order_id }}')">
    <i class="bx bx-upload"></i> Upload Proof
  </button>

                @elseif($delivery->proof_of_delivery)
                  <a href="{{ asset('storage/' . $delivery->proof_of_delivery) }}" target="_blank"
                     class="btn btn-sm btn-outline-secondary">
                    <i class="bx bx-image"></i> View Proof
                  </a>
                @else
                  <button class="btn btn-sm btn-outline-secondary" disabled>
                    <i class="bx bx-lock"></i> Paid
                  </button>
                @endif
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="8" class="text-center text-muted">No deliveries assigned.</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</main>

<!-- Proof Modal -->
<div class="modal fade" id="proofModal" tabindex="-1" aria-labelledby="proofModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="proofModalLabel">Upload Proof of Delivery</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <form id="proofForm" enctype="multipart/form-data">
          @csrf
          <input type="hidden" name="order_id" id="proofOrderId">
          <div class="mb-3">
            <label class="form-label">Upload Image (JPG, PNG)</label>
            <input type="file" name="proof_image" id="proofImage" class="form-control" accept="image/*" required>
          </div>
          <button type="button" class="btn btn-primary w-100" onclick="submitProof()">Submit Proof</button>
        </form>
      </div>
    </div>
  </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
let proofModal;

document.addEventListener('DOMContentLoaded', function() {
  proofModal = new bootstrap.Modal(document.getElementById('proofModal'));
});

// Open modal and set order ID
function openProofModal(orderId) {
  document.getElementById('proofOrderId').value = orderId;
  document.getElementById('proofImage').value = '';
  proofModal.show();
}

// Submit proof using fetch
async function submitProof() {
    const fileInput = document.getElementById('proofImage');
    const orderId = document.getElementById('proofOrderId').value;

    if (!fileInput || fileInput.files.length === 0) {
        alert('Please select a proof image before submitting.');
        return;
    }

    const formData = new FormData();
    formData.append('order_id', orderId);
    formData.append('proof_image', fileInput.files[0]);
    formData.append('_token', document.querySelector('meta[name="csrf-token"]').content); // CSRF token

    try {
        const response = await fetch("{{ route('rider.uploadProof') }}", {
            method: 'POST',
            body: formData,
            credentials: 'same-origin',
        });

        const data = await response.json();

        if (response.ok && data.success) {
            alert('Proof uploaded successfully!');
            location.reload();
        } else {
            console.error(data);
            alert(data.message || 'Upload failed.');
        }
    } catch (err) {
        console.error(err);
        alert('Something went wrong.');
    }
}
</script>




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
