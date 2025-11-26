<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <title>JaceTrack - Financial Reports</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
  <style>
    body { background: #f5f7fb; }
    .dashboard-card { background: #fff; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.05); padding: 20px; margin-bottom: 24px; }
    .chart-wrap { position: relative; height: 300px; }
  </style>
</head>
<body>

<header class="p-4 bg-white shadow-sm">
  <div class="container-fluid">
    <h4 class="mb-0"><i class='bx bx-line-chart'></i> Financial Reports</h4>
    <small class="text-muted">Real-time payment & revenue data</small>
  </div>
</header>

<div class="container-fluid px-4 py-4">

  <!-- KPI Cards -->
  <div class="row g-4 mb-4">
    <div class="col-md-3">
      <div class="dashboard-card">
        <h6 class="text-muted mb-2">Total Revenue</h6>
        <h3 class="fw-bold text-success">₱{{ number_format($totalRevenue, 2) }}</h3>
        <small class="text-muted">Verified payments only</small>
      </div>
    </div>
    <div class="col-md-3">
      <div class="dashboard-card">
        <h6 class="text-muted mb-2">Pending Verification</h6>
        <h3 class="fw-bold text-warning">₱{{ number_format($pendingVerification, 2) }}</h3>
        <small class="text-muted">Awaiting admin approval</small>
      </div>
    </div>
    <div class="col-md-3">
      <div class="dashboard-card">
        <h6 class="text-muted mb-2">Completed Deliveries</h6>
        <h3 class="fw-bold text-primary">{{ $totalDeliveries }}</h3>
        <small class="text-muted">Paid orders</small>
      </div>
    </div>
    <div class="col-md-3">
      <div class="dashboard-card">
        <h6 class="text-muted mb-2">Active Riders</h6>
        <h3 class="fw-bold text-info">{{ $activeRiders }}</h3>
        <small class="text-muted">Currently working</small>
      </div>
    </div>
  </div>

  <!-- Charts -->
  <div class="row g-4 mb-4">
    <div class="col-lg-6">
      <div class="dashboard-card">
        <h6 class="mb-3"><i class='bx bx-chart'></i> Monthly Revenue ({{ date('Y') }})</h6>
        <div class="chart-wrap">
          <canvas id="revenueChart"></canvas>
        </div>
      </div>
    </div>
    <div class="col-lg-6">
      <div class="dashboard-card">
        <h6 class="mb-3"><i class='bx bx-pie-chart'></i> Payment Methods</h6>
        <div class="chart-wrap">
          <canvas id="methodChart"></canvas>
        </div>
      </div>
    </div>
  </div>

  <!-- Top Customers -->
  <div class="dashboard-card mb-4">
    <h6 class="mb-3"><i class='bx bx-trophy'></i> Top Customers by Spending</h6>
    <div class="table-responsive">
      <table class="table table-hover">
        <thead>
          <tr>
            <th>Customer</th>
            <th class="text-end">Total Spent</th>
            <th class="text-end">Orders</th>
          </tr>
        </thead>
        <tbody>
          @forelse($topCustomers as $customer)
          <tr>
            <td>
              <strong>{{ $customer->customer->first_name ?? 'Guest' }} {{ $customer->customer->last_name ?? '' }}</strong>
            </td>
            <td class="text-end fw-bold text-success">
              ₱{{ number_format($customer->total_spent, 2) }}
            </td>
            <td class="text-end">{{ $customer->orders_count ?? 0 }}</td>
          </tr>
          @empty
          <tr><td colspan="3" class="text-center text-muted">No data</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

  <!-- Pending Verifications -->
  <div class="dashboard-card">
    <h6 class="mb-3"><i class='bx bx-time'></i> Payments Awaiting Verification</h6>
    <div class="table-responsive">
      <table class="table table-hover">
        <thead>
          <tr>
            <th>Order ID</th>
            <th>Customer</th>
            <th>Amount</th>
            <th>Method</th>
            <th>Proof</th>
            <th class="text-end">Action</th>
          </tr>
        </thead>
        <tbody>
          @forelse($pendingProofs as $payment)
          <tr>
            <td><strong>#{{ $payment->order_id }}</strong></td>
            <td>{{ $payment->shipment->sender_name ?? 'N/A' }}</td>
            <td class="fw-bold">₱{{ number_format($payment->amount, 2) }}</td>
            <td><span class="badge bg-light">{{ $payment->payment_method }}</span></td>
            <td>
              @if($payment->payment_proof)
                <button class="btn btn-sm btn-link" onclick="viewProof('{{ Storage::url($payment->payment_proof) }}')">
                  <i class='bx bx-image'></i> View
                </button>
              @else
                <span class="text-muted">No proof</span>
              @endif
            </td>
            <td class="text-end">
              <form action="{{ route('admin.verifyPayment', $payment->id) }}" method="POST" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-sm btn-success">Verify</button>
              </form>
              <form action="{{ route('admin.rejectPayment', $payment->id) }}" method="POST" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-sm btn-danger">Reject</button>
              </form>
            </td>
          </tr>
          @empty
          <tr><td colspan="6" class="text-center text-muted">No pending payments</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Monthly Revenue Chart
const revenueCtx = document.getElementById('revenueChart').getContext('2d');
new Chart(revenueCtx, {
  type: 'line',
  data: {
    labels: ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'],
    datasets: [{
      label: 'Revenue',
      data: @json($revenueChartData),
      borderColor: '#0d6efd',
      backgroundColor: 'rgba(13, 110, 253, 0.1)',
      fill: true,
      tension: 0.4
    }]
  },
  options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { display: false } } }
});

// Payment Methods Pie Chart
const methodCtx = document.getElementById('methodChart').getContext('2d');
new Chart(methodCtx, {
  type: 'doughnut',
  data: {
    labels: @json($methodLabels),
    datasets: [{
      data: @json($methodValues),
      backgroundColor: ['#198754', '#0d6efd', '#ffc107', '#dc3545']
    }]
  },
  options: {
    responsive: true,
    maintainAspectRatio: false,
    plugins: {
      legend: { position: 'right' },
      tooltip: {
        callbacks: {
          label: function(context) {
            return context.label + ': ₱' + context.parsed.toLocaleString();
          }
        }
      }
    }
  }
});

// View Proof Modal
function viewProof(url) {
  window.open(url, '_blank', 'width=800,height=600');
}
</script>

</body>
</html>