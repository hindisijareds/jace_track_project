<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Shipment;
use App\Models\Payment;

class ShipmentController extends Controller
{
    public function create()
    {
        return view('shipment');
    }

    public function index()
    {
        $user = Auth::user();
        $shipments = Shipment::where('customer_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('shipment', compact('shipments'));
    }
    
public function orders(Request $request)
{
    $user = Auth::user();
    $status = $request->status;

    $shipments = Shipment::where('customer_id', $user->id)
        ->when($status, function ($query) use ($status) {
            return $query->where('status', $status);
        })
        ->orderBy('created_at', 'desc')
        ->get();

    return view('customer.orders', compact('shipments'));
}

public function track($tracking_number)
{
    $user = Auth::user();

    $shipment = Shipment::with('payment')
        ->where('tracking_number', $tracking_number)
        ->where('customer_id', $user->id)
        ->firstOrFail();

    return view('order', compact('shipment'));
}


    public function store(Request $request)
{
    $request->validate([
        'item_name' => 'required|string|max:255',
        'parcel_type' => 'required|string',
        'parcel_weight' => 'required|numeric',
        'sender_name' => 'required|string|max:255',
        'sender_phone' => 'required|string|max:20',
        'receiver_name' => 'required|string|max:255',
        'receiver_phone' => 'required|string|max:20',
        'sender_address' => 'required|string',
        'receiver_address' => 'required|string',
        'total_cost' => 'required|numeric',
        'payment_method' => 'nullable|string',
    ]);


    $user = Auth::user();

    // Generate tracking number
    $latest = Shipment::orderByDesc('order_id')->first();
    $nextId = $latest ? $latest->order_id + 1 : 1;
    $trackingNumber = 'JX-' . now()->format('Ymd') . '-' . str_pad($nextId, 3, '0', STR_PAD_LEFT);

    // Correctly set item_type & parcel_type
    $itemType = $request->input('item_type', 'Pouch');
    $parcelType = $itemType;
// Add this in your controller's store() method before saving the shipment
if ($request->payment_option === 'pay_now' && $request->hasFile('payment_proof')) {
    $file = $request->file('payment_proof');
    $filename = 'payment_proof_' . time() . '_' . $file->getClientOriginalName();
    $path = $file->storeAs('payment_proofs', $filename, 'public');
    
    $shipment->update([
        'payment_proof_path' => $path,
        'payment_status' => 'awaiting_verification',
    ]);
} elseif ($request->payment_option === 'pay_pickup') {
    $shipment->update([
        'payment_status' => 'pending', // Will be paid on pickup
    ]);
}

// Add these to your Shipment model's $fillable array:
// protected $fillable = [ ..., 'payment_proof_path', 'payment_status'];

// Also add a payment_status field to your shipments table migration:
// $table->enum('payment_status', ['pending', 'pending_verification', 'verified', 'failed'])->default('pending');
    $shipment = Shipment::create([
        'customer_id' => $user->id,
        'tracking_number' => $trackingNumber,
        'status' => 'pending',

        // Parcel Info
        'item_name' => $request->item_name,
        'item_type' => $itemType,
        'parcel_type' => $parcelType,
        'parcel_weight' => $request->parcel_weight,
        'dimension_l' => $request->dimension_l,
        'dimension_w' => $request->dimension_w,
        'dimension_h' => $request->dimension_h,
        'parcel_value' => $request->parcel_value ?? null,

        // Sender & Receiver
        'sender_name' => $request->sender_name,
        'sender_phone' => $request->sender_phone,
        'sender_address' => $request->sender_address,
        'sender_detailed' => $request->sender_detailed,
        'receiver_name' => $request->receiver_name,
        'receiver_phone' => $request->receiver_phone,
        'receiver_address' => $request->receiver_address,
        'receiver_detailed' => $request->receiver_detailed,

        // ✅ Cost breakdown
        'distance_km' => $request->input('distance_km', 0),
        'fuel_liters' => $request->input('fuel_liters', 0),
        'fuel_cost' => $request->input('fuel_cost', 0),
        'maintenance_cost' => $request->input('maintenance_cost', 0),
        'box_size_cost' => $request->input('box_size_cost', 0),
        'box_weight_cost' => $request->input('box_weight_cost', 0),
        'box_total_cost' => $request->input('box_total_cost', 0),
        'total_cost' => $request->input('total_cost', 0),
        'payment_method' => $request->input('payment_method', 'Pay on Pickup'),

        'created_at' => now(),
    ]);
Payment::create([
    'order_id' => $shipment->order_id,
    'amount' => $request->total_cost,
    'payment_method' => $request->payment_method,
    'payment_status' => ($request->payment_method !== 'Pay on Pickup') ? 'paid' : 'pending',
    'payment_date' => ($request->payment_method !== 'Pay on Pickup') ? now() : null,
]);
    return response()->json([
        'success' => true,
        'tracking_number' => $trackingNumber,
    ]);
}
}
