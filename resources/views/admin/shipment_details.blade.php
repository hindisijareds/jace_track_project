<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>JaceTrack - Shipment #{{ $shipment->id }}</title>
  <link rel="shortcut icon" href="{{ asset('images/jacelogoclean.png') }}" type="image/png"/>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
  <style>
    :root{ --jace-blue:#00b8de; --jace-deep:#212244; }
    body { background: #f6f8fb; }
    .card { border-radius: 12px; border: none; box-shadow: 0 4px 20px rgba(0,0,0,0.05); }
    .section-title { font-weight: 700; color: var(--jace-deep); margin-bottom: 15px; }
  </style>
</head>
<body class="container py-4">

<div class="mb-4">
  <a href="{{ url()->previous() }}" class="btn btn-outline-secondary">
    <i class="bx bx-arrow-back"></i> Back to Reports
  </a>
</div>

<div class="card p-4 mb-4">
  <div class="d-flex justify-content-between align-items-start">
    <div>
      <h3 class="fw-bold text-primary">Shipment #{{ $shipment->id }}</h3>
      <p class="text-muted mb-0">Created: {{ $shipment->created_at->format('M d, Y h:i A') }}</p>
    </div>
    <span class="badge bg-{{ $shipment->status == 'delivered' ? 'success' : 'warning' }} fs-6">
      {{ ucfirst($shipment->status) }}
    </span>
  </div>
</div>

<div class="row g-3">
  {{-- Sender Info --}}
  <div class="col-md-6">
    <div class="card p-3">
      <h5 class="section-title"><i class="bx bx-user-circle text-primary"></i> Sender</h5>
      <div class="small">
        <strong>{{ $shipment->sender_name }}</strong><br>
        {{ $shipment->sender_phone }}<br>
        {{ $shipment->sender_address }}<br>
        {{ $shipment->sender_detailed }}
      </div>
    </div>
  </div>

  {{-- Receiver Info --}}
  <div class="col-md-6">
    <div class="card p-3">
      <h5 class="section-title"><i class="bx bx-user text-success"></i> Receiver</h5>
      <div class="small">
        <strong>{{ $shipment->receiver_name }}</strong><br>
        {{ $shipment->receiver_phone }}<br>
        {{ $shipment->receiver_address }}<br>
        {{ $shipment->receiver_detailed }}
      </div>
    </div>
  </div>

  {{-- Parcel Details --}}
  <div class="col-md-6">
    <div class="card p-3">
      <h5 class="section-title"><i class="bx bx-package text-info"></i> Parcel Details</h5>
      <div class="small">
        <strong>Item:</strong> {{ $shipment->item_name }}<br>
        <strong>Type:</strong> {{ ucfirst($shipment->parcel_type) }}<br>
        @if($shipment->parcel_type == 'pouch')
          <strong>Size:</strong> {{ ucfirst($shipment->pouch_size) }}<br>
        @else
          <strong>Dimensions:</strong> {{ $shipment->dimension_l }}×{{ $shipment->dimension_w }}×{{ $shipment->dimension_h }} cm<br>
          <strong>Weight:</strong> {{ $shipment->parcel_weight }} kg<br>
        @endif
        <strong>Value:</strong> ₱{{ number_format($shipment->parcel_value ?? 0, 2) }}
      </div>
    </div>
  </div>

  {{-- Cost Breakdown --}}
  <div class="col-md-6">
    <div class="card p-3">
      <h5 class="section-title"><i class="bx bx-calculator text-warning"></i> Cost Breakdown</h5>
      <div class="small">
        <div class="d-flex justify-content-between">
          <span>Distance ({{ $shipment->distance_km }} km)</span>
          <span>₱{{ number_format($shipment->fuel_cost + $shipment->maintenance_cost, 2) }}</span>
        </div>
        <hr class="my-1">
        <div class="d-flex justify-content-between">
          <span>{{ ucfirst($shipment->parcel_type) }} Cost</span>
          <span>₱{{ number_format($shipment->box_total_cost, 2) }}</span>
        </div>
        <hr class="my-1">
        <div class="d-flex justify-content-between fw-bold text-primary">
          <span>Total</span>
          <span>₱{{ number_format($shipment->total_cost, 2) }}</span>
        </div>
      </div>
    </div>
  </div>

  {{-- Payment Info --}}
  <div class="col-md-6">
    <div class="card p-3">
      <h5 class="section-title"><i class="bx bx-wallet text-success"></i> Payment</h5>
      <div class="small">
        <strong>Method:</strong> {{ ucwords(str_replace('_', ' ', $shipment->payment_option)) }}<br>
        @if($shipment->payment_method)
          <strong>Channel:</strong> {{ ucwords(str_replace('_', ' ', $shipment->payment_method)) }}<br>
        @endif
        <strong>Status:</strong> 
        <span class="badge bg-{{ $shipment->payment_status == 'paid' ? 'success' : 'warning' }}">
          {{ ucfirst($shipment->payment_status ?? 'pending') }}
        </span>
      </div>
    </div>
  </div>

  {{-- Rider Info --}}
  @if($shipment->rider)
  <div class="col-md-6">
    <div class="card p-3">
      <h5 class="section-title"><i class="bx bx-user-check text-info"></i> Assigned Rider</h5>
      <div class="small">
        <strong>{{ $shipment->rider->first_name }} {{ $shipment->rider->last_name }}</strong><br>
        {{ $shipment->rider->email }}<br>
        {{ $shipment->rider->phone ?? $shipment->rider->contact_number }}
      </div>
    </div>
  </div>
  @endif
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>