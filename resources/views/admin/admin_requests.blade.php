<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>JaceTrack - Profile Change Requests</title>
  <link rel="shortcut icon" href="{{ asset('images/jacelogoclean.png') }}" type="image/png" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/style_admin_dashboard.css') }}">
</head>
<body>

  <header class="topbar d-flex align-items-center justify-content-between px-3 py-2 shadow-sm">
    <div class="d-flex align-items-center gap-2">
      <img src="{{ asset('images/jacelogoclean.png') }}" alt="logo" style="height:36px;">
      <h5 class="m-0 fw-bold text-primary">JaceTrack Admin</h5>
    </div>
    <div>
      <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary btn-sm"><i class="bx bx-arrow-back"></i> Dashboard</a>
    </div>
  </header>

  <div class="container py-4">
    <h4 class="fw-bold mb-3 text-primary"><i class="bx bx-mail-send me-2"></i>Profile Change Requests</h4>

    @if(session('success'))
      <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
      <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="card shadow-sm">
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-bordered align-middle text-center">
            <thead class="table-dark">
              <tr>
                <th>#</th>
                <th>User ID</th>
                <th>Field</th>
                <th>Reason</th>
                <th>Status</th>
                <th>Date Requested</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              @forelse($requests as $req)
                <tr>
                  <td>{{ $req->id }}</td>
                  <td>{{ $req->user_id }}</td>
                  <td>{{ ucfirst($req->field) }}</td>
                  <td class="text-start">{{ $req->reason }}</td>
                  <td>
                    @if($req->status === 'pending')
                      <span class="badge bg-warning text-dark">Pending</span>
                    @elseif($req->status === 'approved')
                      <span class="badge bg-success">Approved</span>
                    @else
                      <span class="badge bg-danger">Rejected</span>
                    @endif
                  </td>
                  <td>{{ $req->created_at->format('M d, Y h:i A') }}</td>
                  <td>
                    @if($req->status === 'pending')
                      <form action="{{ route('admin.requests.approve', $req->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('PUT')
                        <button class="btn btn-success btn-sm"><i class="bx bx-check"></i> Approve</button>
                      </form>
                      <form action="{{ route('admin.requests.reject', $req->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('PUT')
                        <button class="btn btn-danger btn-sm"><i class="bx bx-x"></i> Reject</button>
                      </form>
                    @else
                      <small class="text-muted">Processed</small>
                    @endif
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="7" class="text-muted">No requests found.</td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
