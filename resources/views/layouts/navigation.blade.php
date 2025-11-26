<nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #831214;">
  <div class="container-fluid">
    <!-- Brand -->
    <a class="navbar-brand d-flex align-items-center" href="{{ route('dashboard') }}">
      <img src="{{ asset('images/jacelogoclean.png') }}" alt="JaceTrack" width="35" class="me-2">
      <strong>JaceTrack</strong>
    </a>

    <!-- Toggler -->
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
      <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Links -->
    <div class="collapse navbar-collapse" id="navbarContent">
      <ul class="navbar-nav ms-auto align-items-center">
        @auth
          <li class="nav-item">
            <a class="nav-link text-light {{ request()->is('dashboard') ? 'fw-bold' : '' }}" href="{{ route('dashboard') }}">
              <i class="bx bx-home me-1"></i> Dashboard
            </a>
          </li>

          <li class="nav-item">
            <a class="nav-link text-light {{ request()->is('profile') ? 'fw-bold' : '' }}" href="{{ route('profile') }}">
              <i class="bx bx-user me-1"></i> Profile
            </a>
          </li>

          <!-- Dropdown -->
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle text-light" href="#" role="button" data-bs-toggle="dropdown">
              <i class="bx bx-user-circle"></i> {{ Auth::user()->name }}
            </a>
            <ul class="dropdown-menu dropdown-menu-end">
              <li>
                <a class="dropdown-item" href="{{ route('dashboard') }}">
                  <i class="bx bx-grid-alt me-2"></i> Dashboard
                </a>
              </li>
              <li>
                <a class="dropdown-item" href="{{ route('profile') }}">
                  <i class="bx bx-user me-2"></i> Profile
                </a>
              </li>
              <li><hr class="dropdown-divider"></li>
              <li>
                <form method="POST" action="{{ route('logout') }}">
                  @csrf
                  <button class="dropdown-item text-danger">
                    <i class="bx bx-log-out me-2"></i> Logout
                  </button>
                </form>
              </li>
            </ul>
          </li>
        @endauth

        @guest
          <li class="nav-item">
            <a class="nav-link text-light" href="{{ route('login') }}">Login</a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-light" href="{{ route('register') }}">Register</a>
          </li>
        @endguest
      </ul>
    </div>
  </div>
</nav>

<!-- Include Bootstrap -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
