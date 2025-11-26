<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Add Rider - JaceTrack Admin</title>

  <link rel="shortcut icon" href="{{ asset('images/jacelogoclean.png') }}" type="image/png" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css " rel="stylesheet">
  <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css " rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/style_admin_dashboard.css') }}">

  {{-- UI Polish Styles --}}
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

    .form-label { font-weight: 600; font-size: 0.85rem; color: #495057; }
    .form-control, .form-select { 
        padding: 10px 15px; 
        border-radius: 8px; 
        border: 1px solid #dee2e6;
        font-size: 0.9rem;
    }
    .form-control:focus, .form-select:focus { box-shadow: 0 0 0 3px rgba(13, 110, 253, 0.1); border-color: #0d6efd; }
    
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

    .avatar-circle {
        width: 36px;
        height: 36px;
        background-color: #e9ecef;
        color: #495057;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        font-size: 0.8rem;
    }

    .clickable-row {
      cursor: pointer;
      transition: background-color 0.2s ease;
    }
    .clickable-row:hover {
      background-color: #f8f9fa !important;
    }

    .is-invalid { border-color: #dc3545; }
    .invalid-feedback { display: block; }
    
    /* Custom Modal Styling */
    .modal-header.bg-danger {
        background-color: #dc3545;
        color: white;
    }
    .suspension-preview {
        background-color: #fff3cd;
        border: 1px solid #ffeaa7;
        border-radius: 8px;
        padding: 15px;
        margin-top: 15px;
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
        <small class="text-muted">Rider Management</small>
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

      @if(session('success'))
        <div class="alert alert-success d-flex align-items-center mb-3">
          <i class="bx bx-check-circle me-2"></i>
          {{ session('success') }}
        </div>
      @endif

      @if(session('error'))
        <div class="alert alert-danger d-flex align-items-center mb-3">
          <i class="bx bx-error-circle me-2"></i>
          {{ session('error') }}
        </div>
      @endif

      <div class="row mb-4">
        <div class="col-md-6 col-lg-4">
            <div class="dashboard-card p-3 d-flex align-items-center gap-3">
                <div class="bg-primary bg-opacity-10 text-primary p-3 rounded-circle">
                    <i class="bx bx-group fs-3"></i>
                </div>
                <div>
                    <h5 class="mb-0 fw-bold">{{ $riders->count() }}</h5>
                    <small class="text-muted">Total Registered Riders</small>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-4">
            <div class="dashboard-card p-3 d-flex align-items-center gap-3">
                <div class="bg-success bg-opacity-10 text-success p-3 rounded-circle">
                    <i class="bx bx-check-shield fs-3"></i>
                </div>
                <div>
                    <h5 class="mb-0 fw-bold">{{ $riders->where('status', 'active')->count() ?? 0 }}</h5>
                    <small class="text-muted">Active Now</small>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-4">
            <div class="dashboard-card p-3 d-flex align-items-center gap-3">
                <div class="bg-warning bg-opacity-10 text-warning p-3 rounded-circle">
                    <i class="bx bx-user-x fs-3"></i>
                </div>
                <div>
                    <h5 class="mb-0 fw-bold">{{ $riders->where('status', 'suspended')->count() ?? 0 }}</h5>
                    <small class="text-muted">Suspended</small>
                </div>
            </div>
        </div>
      </div>

      <div class="row">
        <div class="col-lg-5">
            <div class="dashboard-card">
                <div class="card-header-custom">
                    <h6 class="mb-0 fw-bold"><i class="bx bx-user-plus me-2"></i>Register New Rider</h6>
                </div>
                <div class="p-4">
                    <form method="POST" action="{{ route('admin.riders.store') }}">
                      @csrf
                      <div class="row g-3">
                          <!-- First Name -->
                          <div class="col-md-6">
                            <label class="form-label">First Name *</label>
                            <input type="text" name="first_name" class="form-control @error('first_name') is-invalid @enderror" 
                                placeholder="e.g. Denver" value="{{ old('first_name') }}" required>
                            @error('first_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                          </div>

                          <!-- Last Name -->
                          <div class="col-md-6">
                            <label class="form-label">Last Name *</label>
                            <input type="text" name="last_name" class="form-control @error('last_name') is-invalid @enderror" 
                                placeholder="e.g. Enriquez" value="{{ old('last_name') }}" required>
                            @error('last_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                          </div>

                          <!-- Email -->
                          <div class="col-12">
                            <label class="form-label">Email Address *</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light text-muted"><i class="bx bx-envelope"></i></span>
                                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" 
                                    placeholder="rider@jacetrack.com" value="{{ old('email') }}" required>
                            </div>
                            @error('email')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                          </div>

                          <!-- Phone -->
                          <div class="col-12">
                            <label class="form-label">Phone Number *</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light text-muted"><i class="bx bx-phone"></i></span>
                                <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" 
                                    placeholder="0912 345 6789" value="{{ old('phone') }}" required>
                            </div>
                            @error('phone')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                          </div>
                          
                          <!-- Vehicle Type -->
                          <div class="col-md-6">
                             <label class="form-label">Vehicle Type *</label>
                             <select name="vehicle_type" class="form-select @error('vehicle_type') is-invalid @enderror" required>
                                 <option value="">Select Vehicle</option>
                                 <option value="Motorcycle" {{ old('vehicle_type') == 'Motorcycle' ? 'selected' : '' }}>Motorcycle</option>
                                 <option value="Van" {{ old('vehicle_type') == 'Van' ? 'selected' : '' }}>Van</option>
                                 <option value="Car" {{ old('vehicle_type') == 'Car' ? 'selected' : '' }}>Car</option>
                                 <option value="Bicycle" {{ old('vehicle_type') == 'Bicycle' ? 'selected' : '' }}>Bicycle</option>
                             </select>
                             @error('vehicle_type')
                                 <div class="invalid-feedback">{{ $message }}</div>
                             @enderror
                          </div>

                          <!-- License Plate -->
                          <div class="col-md-6">
                             <label class="form-label">License Plate</label>
                             <input type="text" name="license_plate" class="form-control @error('license_plate') is-invalid @enderror" 
                                placeholder="ABC 123" value="{{ old('license_plate') }}">
                             @error('license_plate')
                                 <div class="invalid-feedback">{{ $message }}</div>
                             @enderror
                          </div>

                          <!-- Password -->
                          <div class="col-12">
                            <label class="form-label">Password *</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light text-muted"><i class="bx bx-lock-alt"></i></span>
                                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" 
                                    placeholder="Create strong password (min 8 chars)" required>
                            </div>
                            @error('password')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                          </div>

                          <!-- Confirm Password -->
                          <div class="col-12">
                            <label class="form-label">Confirm Password *</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light text-muted"><i class="bx bx-lock-alt"></i></span>
                                <input type="password" name="password_confirmation" class="form-control" 
                                    placeholder="Confirm password" required>
                            </div>
                          </div>

                          <!-- Submit -->
                          <div class="col-12 mt-4">
                            <button class="btn btn-primary w-100 py-2 fw-bold shadow-sm">
                                <i class="bx bx-plus-circle me-1"></i> Add Rider
                            </button>
                          </div>
                      </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-7">
          <div class="dashboard-card h-100">
            <div class="card-header-custom d-flex justify-content-between align-items-center">
              <h6 class="mb-0 fw-bold">Rider Directory</h6>
              <div class="input-group input-group-sm" style="width: 200px;">
                  <span class="input-group-text bg-light border-end-0"><i class="bx bx-search"></i></span>
                  <input type="text" class="form-control border-start-0 ps-0" placeholder="Search rider...">
              </div>
            </div>

            <div class="table-responsive">
              <table class="table table-hover align-middle mb-0">
                <thead>
                  <tr>
                    <th class="ps-4">Rider</th>
                    <th>Contact Info</th>
                    <th>Status</th>
                    <th class="text-end pe-4">Actions</th>
                  </tr>
                </thead>

<tbody>
  @forelse($riders as $rider)
  {{-- Add opacity-50 class if suspended --}}
  <tr class="clickable-row {{ $rider->status == 'suspended' ? 'opacity-50' : '' }}" data-url="{{ route('admin.riders.show', $rider->id) }}">
    <td class="ps-4">
        <div class="d-flex align-items-center gap-3">
            <div class="avatar-circle">
                {{ substr($rider->first_name, 0, 1) }}{{ substr($rider->last_name, 0, 1) }}
            </div>
            <div>
                <div class="fw-bold text-dark">{{ $rider->first_name }} {{ $rider->last_name }}</div>
                <small class="text-muted">{{ $rider->vehicle_type ?? 'Motorcycle' }}</small>
            </div>
        </div>
    </td>
    <td>
        <div class="d-flex flex-column">
            <small class="text-muted"><i class="bx bx-envelope me-1"></i> {{ $rider->email }}</small>
            <small class="text-muted"><i class="bx bx-phone me-1"></i> {{ $rider->phone }}</small>
        </div>
    </td>
    <td>
        @if($rider->status == 'active')
            <span class="badge bg-success bg-opacity-10 text-success">Active</span>
        @elseif($rider->status == 'suspended')
            {{-- Show suspension details --}}
            <span class="badge bg-warning bg-opacity-10 text-warning">
                <i class="bx bx-user-x me-1"></i>Suspended
                @if($rider->suspension_end_date)
                    <br><small>{{ now()->diffForHumans($rider->suspension_end_date, ['parts' => 2]) }}</small>
                @else
                    <br><small>Permanent</small>
                @endif
            </span>
            @if($rider->suspension_reason)
                <br><small class="text-muted text-uppercase" style="font-size: 0.7rem;">
                    {{ str_replace('_', ' ', $rider->suspension_reason) }}
                </small>
            @endif
        @else
            <span class="badge bg-secondary bg-opacity-10 text-secondary">Inactive</span>
        @endif
    </td>
    <td class="text-end pe-4">
      <div class="btn-group btn-group-sm" role="group">
        <a href="{{ route('admin.riders.show', $rider->id) }}" class="btn btn-light" title="View Details">
          <i class="bx bx-show"></i>
        </a>
        
        @if($rider->status == 'active')
          {{-- Check if rider has active deliveries --}}
          @php
            $hasActiveDeliveries = \App\Models\Shipment::where('rider_id', $rider->id)
                ->whereIn('status', ['assigned', 'transit', 'proof_pending', 'picked_up'])
                ->exists();
          @endphp
          
          @if($hasActiveDeliveries)
            <button type="button" class="btn btn-light text-muted" title="Cannot suspend: Active deliveries" disabled>
              <i class="bx bx-user-x"></i>
            </button>
          @else
            <button type="button" class="btn btn-light text-warning" title="Suspend Rider" 
              data-bs-toggle="modal" data-bs-target="#suspendModal{{ $rider->id }}">
              <i class="bx bx-user-x"></i>
            </button>
          @endif
        @else
          <form method="POST" action="{{ route('admin.riders.activate', $rider->id) }}" class="d-inline">
            @csrf
            <button type="submit" class="btn btn-light text-success" title="Activate Rider">
              <i class="bx bx-user-check"></i>
            </button>
          </form>
        @endif
      </div>
    </td>
  </tr>

  {{-- Keep your existing modals here --}}
  <!-- Suspend Modal -->
  <div class="modal fade" id="suspendModal{{ $rider->id }}" tabindex="-1">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header bg-warning text-dark">
          <h5 class="modal-title"><i class="bx bx-user-x me-2"></i>Suspend Rider</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <form method="POST" action="{{ route('admin.riders.disable', $rider->id) }}">
          @csrf
          <div class="modal-body">
            <div class="alert alert-warning">
              <i class="bx bx-error-circle me-2"></i>
              <strong>You are about to suspend:</strong> {{ $rider->first_name }} {{ $rider->last_name }}
            </div>

            {{-- Display validation errors if any --}}
            @if($errors->any() && session('suspend_rider_id') == $rider->id)
              <div class="alert alert-danger">
                <ul class="mb-0">
                  @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                  @endforeach
                </ul>
              </div>
            @endif

            <!-- Reason -->
            <div class="mb-3">
              <label class="form-label fw-bold">Reason for Suspension *</label>
              <select name="reason" class="form-select" required>
                <option value="">Select Reason</option>
                <option value="policy_violation">Policy Violation</option>
                <option value="poor_performance">Poor Performance</option>
                <option value="unauthorized_absence">Unauthorized Absence</option>
                <option value="misconduct">Misconduct</option>
                <option value="leave_of_absence">Leave of Absence</option>
                <option value="other">Other</option>
              </select>
            </div>

            <!-- Duration -->
            <div class="mb-3">
              <label class="fw-bold d-block">Suspension Duration *</label>
              <div class="row g-2">
                <div class="col-md-6">
                  <label class="form-check-label w-100">
                    <input type="radio" name="duration" value="1_week" class="form-check-input" required> 1 Week
                  </label>
                </div>
                <div class="col-md-6">
                  <label class="form-check-label w-100">
                    <input type="radio" name="duration" value="1_month" class="form-check-input"> 1 Month
                  </label>
                </div>
                <div class="col-md-6">
                  <label class="form-check-label w-100">
                    <input type="radio" name="duration" value="3_months" class="form-check-input"> 3 Months
                  </label>
                </div>
                <div class="col-md-6">
                  <label class="form-check-label w-100">
                    <input type="radio" name="duration" value="custom" class="form-check-input"> Custom Date
                  </label>
                </div>
                <div class="col-md-6">
                  <label class="form-check-label w-100">
                    <input type="radio" name="duration" value="permanent" class="form-check-input"> Permanent
                  </label>
                </div>
              </div>
            </div>

            <!-- Custom Date -->
            <div class="mb-3" id="customDate{{ $rider->id }}" style="display:none;">
              <label class="form-label fw-bold">Custom End Date *</label>
              <input type="date" name="custom_end_date" class="form-control">
            </div>

            <!-- Message -->
            <div class="mb-3">
              <label class="form-label fw-bold">Additional Message (Optional)</label>
              <textarea name="message" class="form-control" rows="3" placeholder="Provide additional details..."></textarea>
            </div>

            <!-- Admin Password Confirmation -->
            <div class="mb-3">
              <label class="form-label fw-bold">Confirm Your Password *</label>
              <div class="input-group">
                <span class="input-group-text bg-light text-muted"><i class="bx bx-lock"></i></span>
                <input type="password" name="admin_password" class="form-control" required>
              </div>
            </div>

            <!-- Warning -->
            <div class="alert alert-danger mb-0">
              <i class="bx bx-error me-2"></i>
              <strong>Warning:</strong> This action will prevent the rider from logging in and receiving assignments.
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
              <i class="bx bx-x me-1"></i> Cancel
            </button>
            <button type="submit" class="btn btn-warning">
              <i class="bx bx-user-x me-1"></i> Confirm Suspension
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>

  @empty
  <tr>
    <td colspan="4" class="text-center py-5 text-muted">
      <i class="bx bx-user-x fs-1 mb-2"></i>
      <p>No riders found in the system.</p>
    </td>
  </tr>
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js  "></script>
<script src="{{ asset('js/preloader.js') }}"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
  // Make rows clickable
  const clickableRows = document.querySelectorAll('.clickable-row');
  clickableRows.forEach(row => {
    row.addEventListener('click', function(e) {
      if (e.target.closest('a') || e.target.closest('button') || e.target.closest('form')) return;
      const url = this.dataset.url;
      if (url) window.location.href = url;
    });
  });

  // Show/hide custom date
  document.querySelectorAll('input[name="duration"]').forEach(radio => {
    radio.addEventListener('change', function() {
      const modal = this.closest('.modal');
      const customDateDiv = modal.querySelector('[id^="customDate"]');
      if (this.value === 'custom') {
        customDateDiv.style.display = 'block';
        customDateDiv.querySelector('input').required = true;
      } else {
        customDateDiv.style.display = 'none';
        customDateDiv.querySelector('input').required = false;
      }
    });
  });

  // Re-open modal if validation fails
  @if($errors->any() && session('suspend_rider_id'))
    var modal = new bootstrap.Modal(document.getElementById('suspendModal{{ session('suspend_rider_id') }}'));
    modal.show();
  @endif
});
</script>
<script>
document.addEventListener('DOMContentLoaded', function() {
  // Make rows clickable
  const clickableRows = document.querySelectorAll('.clickable-row');
  clickableRows.forEach(row => {
    row.addEventListener('click', function(e) {
      if (e.target.closest('a') || e.target.closest('button') || e.target.closest('form')) return;
      const url = this.dataset.url;
      if (url) window.location.href = url;
    });
  });

  // Show/hide custom date
  document.querySelectorAll('input[name="duration"]').forEach(radio => {
    radio.addEventListener('change', function() {
      const modal = this.closest('.modal');
      const customDateDiv = modal.querySelector('[id^="customDate"]');
      if (this.value === 'custom') {
        customDateDiv.style.display = 'block';
        customDateDiv.querySelector('input').required = true;
      } else {
        customDateDiv.style.display = 'none';
        customDateDiv.querySelector('input').required = false;
      }
    });
  });
});
</script>

</body>
</html>