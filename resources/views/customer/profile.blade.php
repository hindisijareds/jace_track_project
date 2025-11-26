<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>JaceTrack - Profile</title>
  <link rel="shortcut icon" href="{{ asset('images/jacelogoclean.png') }}" type="image/png">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/style_customer_dashboard.css') }}">
</head>
<body>
<div class="container py-4">

  <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary mb-3"><i class="bx bx-arrow-back"></i> Back to Dashboard</a>

  <div class="card shadow p-4">
   <!-- <div class="text-center mb-4">
      <img src="{{ $user->profile_picture ? asset('storage/'.$user->profile_picture) : asset('images/default-avatar.png') }}"
           class="rounded-circle border" width="120" height="120" alt="Profile Picture">
      @if(!$user->profile_picture)
        <p class="text-muted small mt-2">Add a profile picture (one-time only)</p>
      @else
        <p class="text-muted small mt-2">Profile picture change locked. Request admin permission.</p>
      @endif
    </div>-->

    @if(session('success'))
      <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
      <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form method="POST" enctype="multipart/form-data" action="{{ route('customer.updateProfile') }}">
      @csrf
      @method('PUT')

      <h5 class="mb-3">Personal Information</h5>
      <div class="row g-3">
        <div class="col-md-4">
          <label class="form-label">First Name</label>
          <input type="text" name="first_name" value="{{ old('first_name', $user->first_name) }}" class="form-control" {{ $user->info_locked ? 'readonly' : '' }}>
        </div>
        <div class="col-md-4">
          <label class="form-label">Middle Name</label>
          <input type="text" name="middle_name" value="{{ old('middle_name', $user->middle_name) }}" class="form-control" {{ $user->info_locked ? 'readonly' : '' }}>
        </div>
        <div class="col-md-4">
          <label class="form-label">Last Name</label>
          <input type="text" name="last_name" value="{{ old('last_name', $user->last_name) }}" class="form-control" {{ $user->info_locked ? 'readonly' : '' }}>
        </div>
      </div>

     
        <h5 class="mt-4 mb-3">Address</h5>

@php
  $cityBarangays = [
      'Lingayen' => ['Poblacion I','Poblacion II','Poblacion III','San Jose','San Nicolas'],
      'Dagupan' => ['Bonuan Gueset','Bonuan Boquig','Bayan','Poblacion'],
      'Urdaneta' => ['Poblacion I','Poblacion II','San Vicente','San Roque'],
      'Mangaldan' => ['Poblacion','Balungao','San Carlos'],
      'Alaminos' => ['Poblacion','San Jose','San Vicente'],
      'San Carlos' => ['Poblacion','San Juan','San Roque'],
      'Agno' => ['Poblacion','San Lorenzo','San Pedro'],
  ];

  $zipCodes = [
      'Lingayen'=>'2401','Dagupan'=>'2400','Urdaneta'=>'2431','Mangaldan'=>'2411',
      'Alaminos'=>'2404','San Carlos'=>'2420','Agno'=>'2406'
  ];
@endphp

<div class="row g-3">
  <!-- City Dropdown -->
  <div class="col-md-4">
    <label class="form-label">City</label>
    <select name="city" id="city" class="form-select" {{ $user->info_locked ? 'disabled' : '' }} required>
      <option value="">-- Select City --</option>
      @foreach ($cityBarangays as $city => $barangays)
        <option value="{{ $city }}" 
          {{ old('city', $user->city) == $city ? 'selected' : '' }}>
          {{ $city }}
        </option>
      @endforeach
    </select>
  </div>

  <!-- Barangay Dropdown -->
  <div class="col-md-4">
    <label class="form-label">Barangay</label>
    <select name="barangay" id="barangay" class="form-select" {{ $user->info_locked ? 'disabled' : '' }} required>
      <option value="">-- Select Barangay --</option>
      @if(old('city', $user->city))
        @foreach ($cityBarangays[old('city', $user->city)] ?? [] as $barangay)
          <option value="{{ $barangay }}" 
            {{ old('barangay', $user->barangay) == $barangay ? 'selected' : '' }}>
            {{ $barangay }}
          </option>
        @endforeach
      @endif
    </select>
  </div>

  <!-- Zip Code -->
  <div class="col-md-4">
    <label class="form-label">ZIP Code</label>
    <input type="text" name="zip_code" id="zip_code" 
           value="{{ old('zip_code', $user->zip_code ?? ($zipCodes[$user->city] ?? '')) }}"
           class="form-control" readonly>
  </div>

  <!-- Detailed Address -->
  <div class="col-md-12">
    <label class="form-label">Detailed Address</label>
    <input type="text" name="detailed_address" 
           value="{{ old('detailed_address', $user->detailed_address) }}" 
           class="form-control" {{ $user->info_locked ? 'readonly' : '' }} required>
  </div>
</div>


      <h5 class="mt-4 mb-3">Contact Information</h5>
      <div class="row g-3">
        <div class="col-md-6">
          <label class="form-label">Contact Number</label>
          <input type="text" name="contact_number" value="{{ old('contact_number', $user->contact_number) }}" class="form-control" {{ $user->info_locked ? 'readonly' : '' }}>
          @if($user->phone_verified)
            <span class="badge bg-success mt-1"><i class="bx bx-check"></i> Verified</span>
          @else
            <span class="badge bg-warning mt-1">Unverified</span>
          @endif
        </div>
        <div class="col-md-6">
          <label class="form-label">Email</label>
          <input type="email" name="email" value="{{ old('email', $user->email) }}" class="form-control" {{ $user->info_locked ? 'readonly' : '' }}>
          @if($user->email_verified)
            <span class="badge bg-success mt-1"><i class="bx bx-check"></i> Verified</span>
          @else
            <span class="badge bg-warning mt-1">Unverified</span>
          @endif
        </div>
      </div>

      @if(!$user->info_locked)
        <!--<div class="mt-4">
          <label class="form-label">Profile Picture</label>
          <input type="file" name="profile_picture" class="form-control">
        </div>-->
        <div class="text-end mt-4">
          <button type="submit" class="btn btn-primary">Save Profile</button>
        </div>
      @else
        <div class="text-end mt-4">
          <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#requestModal">
            Request Profile Change
          </button>
        </div>
      @endif
      <div class="text-end mt-4">
  <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteAccountModal">
    <i class="bx bx-trash"></i> Delete Account
  </button>
</div>
<!-- Delete Account Modal -->
<div class="modal fade" id="deleteAccountModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <form method="POST" action="{{ route('account.delete.request') }}">
        @csrf

        <div class="modal-header bg-danger text-white">
          <h5 class="modal-title"><i class="bx bx-error-circle"></i> Confirm Account Deletion</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body">
          <p class="mb-3 text-danger">
            You are about to permanently delete your account. This action cannot be undone.
          </p>

          <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" id="confirmDelete" required>
            <label class="form-check-label" for="confirmDelete">
              I understand that this will permanently delete my account and all data.
            </label>
          </div>

          <div class="mb-3">
            <label class="form-label fw-bold">Reason for deleting your account</label>
            <textarea name="reason" class="form-control" rows="3" placeholder="Please tell us why you want to delete..." required></textarea>
          </div>

          <div class="mb-3">
            <label class="form-label fw-bold">Verify Your Identity</label>
            <input type="password" name="password" class="form-control" placeholder="Enter your password to confirm" required>
          </div>

          <div class="mb-3">
            <label class="form-label fw-bold">Deletion Option</label>
            <select name="deletion_option" class="form-select" required>
              <option value="7_days">Delete after 7 days (You can cancel before deletion)</option>
              <option value="immediate">Request immediate deletion (Admin approval required)</option>
            </select>
          </div>

          <div class="alert alert-warning mt-3">
            <i class="bx bx-info-circle"></i> If you select “Delete after 7 days,” you can cancel anytime before the 7-day period ends.
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-danger">Continue Deletion</button>
        </div>
      </form>
    </div>
  </div>
</div>

    </form>
  </div>

 <!-- Request Change Modal -->
<div class="modal fade" id="requestModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form method="POST" action="{{ route('customer.requestChange') }}">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title">Request Profile Change</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">

          <div class="mb-3">
            <label class="form-label">Reason for change</label>
            <textarea name="reason" class="form-control" placeholder="Explain why you need to update this info..." required></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button class="btn btn-primary">Submit Request</button>
        </div>
      </form>
    </div>
  </div>
</div>


</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
  const cityBarangays = @json($cityBarangays);
  const zipCodes = @json($zipCodes);

  document.addEventListener("DOMContentLoaded", function() {
    const citySelect = document.getElementById("city");
    const barangaySelect = document.getElementById("barangay");
    const zipInput = document.getElementById("zip_code");

    if (citySelect) {
      citySelect.addEventListener("change", function() {
        const city = this.value;
        barangaySelect.innerHTML = '<option value="">-- Select Barangay --</option>';

        if (city && cityBarangays[city]) {
          cityBarangays[city].forEach(function(brgy) {
            const option = document.createElement("option");
            option.value = brgy;
            option.textContent = brgy;
            barangaySelect.appendChild(option);
          });

          // Auto-fill ZIP code
          zipInput.value = zipCodes[city] || '';
        } else {
          zipInput.value = '';
        }
      });
    }
  });
</script>

</body>
</html>
