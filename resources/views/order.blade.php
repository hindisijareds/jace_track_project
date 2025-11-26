<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Track Order | JaceTrack</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container py-4">
    <a href="{{ url('/dashboard') }}" class="btn btn-outline-dark mb-3">
        <i class="bx bx-left-arrow-alt"></i> Back
    </a>

    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h5 class="m-0">Tracking Number: {{ $shipment->tracking_number }}</h5>
        </div>

        <div class="card-body">

         <p><strong>Status:</strong>
    @if($shipment->status === 'pending')
        <span class="badge bg-secondary">Pending Approval</span>
    @elseif($shipment->status === 'approved')
        <span class="badge bg-info text-dark">Approved</span>
    @elseif($shipment->status === 'assigned')
        <span class="badge bg-primary text-light">Assigned to Rider</span>
    @elseif($shipment->status === 'transit')
        <span class="badge bg-warning text-dark">In Transit</span>
    @elseif($shipment->status === 'delivered')
        <span class="badge bg-success">Delivered</span>
    @elseif($shipment->status === 'cancelled')
        <span class="badge bg-danger">Cancelled</span>
    @else
        <span class="badge bg-dark">Unknown</span>
    @endif
</p>



            <!-- ✅ Assigned Rider Display -->
            <p><strong>Assigned Rider:</strong>
                @if($shipment->rider_name)
                    {{ $shipment->rider_name }}
                @else
                    <span class="text-muted">Not assigned yet</span>
                @endif
            </p>

            <p><strong>Date Created:</strong> {{ $shipment->created_at->format('Y-m-d') }}</p>

            <hr>

            <h6><i class="bx bx-package"></i> Parcel Information</h6>
            <p><strong>Item:</strong> {{ $shipment->item_name }}</p>
            <p><strong>Weight:</strong> {{ $shipment->parcel_weight }} kg</p>
            <p><strong>Type:</strong> {{ $shipment->parcel_type }}</p>

            <hr>

            <h6><i class="bx bx-map-pin"></i> Addresses</h6>
            <p><strong>From (Pickup):</strong> {{ $shipment->sender_address }}</p>
            <p><strong>To (Delivery):</strong> {{ $shipment->receiver_address }}</p>

            <hr>

            <h6><i class="bx bx-wallet"></i> Payment Details</h6>
            <p><strong>Total Cost:</strong> ₱{{ number_format($shipment->total_cost, 2) }}</p>

            @if($shipment->payment)
                <p><strong>Payment Method:</strong> {{ $shipment->payment->payment_method }}</p>
                <p><strong>Payment Status:</strong>
                    @if($shipment->payment->payment_status == 'paid')
                        ✅ Paid
                    @else
                        ⏳ Pay on Pickup
                    @endif
                </p>
            @else
                <p class="text-danger small">⚠ Payment record missing — Admin action required</p>
            @endif
            
            <hr>

            <h6><i class="bx bx-current-location"></i> Cost Breakdown</h6>
            <ul class="small">
                <li>Distance: <strong>{{ $shipment->distance_km ?? 0 }} km</strong></li>
                <li>Fuel Used: <strong>{{ $shipment->fuel_liters ?? 0 }} L</strong></li>
                <li>Fuel Cost: ₱{{ number_format($shipment->fuel_cost ?? 0, 2) }}</li>
                <li>Maintenance: ₱{{ number_format($shipment->maintenance_cost ?? 0, 2) }}</li>
                <li>Box Costs: ₱{{ number_format($shipment->box_total_cost ?? 0, 2) }}</li>
            </ul>

        </div>
    </div>
</div>

</body>
</html>
