<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>JaceTrack - Login & Signup</title>
  
  <link rel="shortcut icon" href="{{ asset('images/jacelogoclean.png') }}" type="image/png">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/style_login.css') }}">
</head>
<body>

<div class="auth-card">
  <img src="{{ asset('images/jacelogoclean.png') }}" width="70" class="logo" alt="JaceTrack">

  <!-- Tabs -->
  <ul class="nav nav-tabs justify-content-center mb-4" id="authTabs" role="tablist">
    <li class="nav-item" role="presentation">
      <button class="nav-link {{ old('tab') !== 'signup' ? 'active' : '' }}" id="login-tab" data-bs-toggle="tab" data-bs-target="#login" type="button" role="tab">Login</button>
    </li>
    <li class="nav-item" role="presentation">
      <button class="nav-link {{ old('tab') === 'signup' ? 'active' : '' }}" id="signup-tab" data-bs-toggle="tab" data-bs-target="#signup" type="button" role="tab">Signup</button>
    </li>
  </ul>

  <!-- Tab Content -->
  <div class="tab-content">
   <!-- Login -->
<div class="tab-pane fade {{ old('tab') !== 'signup' ? 'show active' : '' }}" id="login" role="tabpanel">
  <h4 class="text-center mb-3">Log In</h4>
  <form method="POST" action="{{ route('login') }}">
    @csrf
    <input type="hidden" name="tab" value="login">
    
    <div class="mb-3">
      <label class="form-label">Phone Number or Email</label>
      <input type="text" name="login" class="form-control" placeholder="Enter phone number or email" value="{{ old('login') }}" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Password</label>
      <input type="password" name="password" class="form-control" placeholder="Enter password" required>
    </div>

    <button type="submit" class="btn btn-jace w-100">Log In</button>
  </form>
</div>


    <!-- Signup -->
<div class="tab-pane fade {{ old('tab') === 'signup' ? 'show active' : '' }}" id="signup" role="tabpanel">
  <h4 class="text-center mb-3">Create Account</h4>
  <form method="POST" action="{{ route('register') }}">
    @csrf
    <input type="hidden" name="tab" value="signup">

    <div class="row g-3">
      <div class="col-md-6">
        <label class="form-label">Phone Number</label>
        <input type="text" name="phone" class="form-control" placeholder="09xxxxxxxxx" maxlength="11" value="{{ old('phone') }}" required>
      </div>

      <div class="col-md-6">
        <label class="form-label">Email</label>
        <input type="email" name="email" class="form-control" placeholder="you@example.com" value="{{ old('email') }}" required>
      </div>

      <div class="col-md-4">
        <label class="form-label">First Name</label>
        <input type="text" name="first_name" class="form-control" placeholder="First name" value="{{ old('first_name') }}" required>
      </div>
      <div class="col-md-4">
        <label class="form-label">Middle Name</label>
        <input type="text" name="middle_name" class="form-control" placeholder="Middle name" value="{{ old('middle_name') }}">
      </div>
      <div class="col-md-4">
        <label class="form-label">Last Name</label>
        <input type="text" name="last_name" class="form-control" placeholder="Last name" value="{{ old('last_name') }}" required>
      </div>

      <div class="col-md-6">
        <label class="form-label">Password</label>
        <input type="password" name="password" class="form-control" placeholder="Minimum 6 characters" required>
      </div>

<div class="col-md-6">
  <label class="form-label">Confirm Password</label>
  <input type="password" name="password_confirmation" class="form-control" placeholder="Re-enter password" required>
</div>

      <input type="hidden" name="role" value="customer">

    </div>

    <button type="submit" class="btn btn-jace w-100 mt-4">Sign Up</button>
  </form>
</div>


<!-- Error Modal -->
<div class="modal fade" id="errorModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-danger">
      <div class="modal-header bg-danger text-white">
        <h5 class="modal-title">Error</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        @if ($errors->any())
          {{ $errors->first() }}
        @endif
        @if (session('error'))
          {{ session('error') }}
        @endif
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!-- Success Modal -->
<div class="modal fade" id="successModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-success">
      <div class="modal-header bg-success text-white">
        <h5 class="modal-title">Success</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        @if (session('success'))
          {{ session('success') }}
        @endif
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success" data-bs-dismiss="modal">OK</button>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
  document.addEventListener("DOMContentLoaded", function() {
    @if ($errors->any() || session('error'))
      var errorModal = new bootstrap.Modal(document.getElementById('errorModal'));
      errorModal.show();
    @endif

    @if (session('success'))
      var successModal = new bootstrap.Modal(document.getElementById('successModal'));
      successModal.show();
    @endif
  });
</script>

</body>
</html>
