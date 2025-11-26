<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shipment;
use App\Models\User;

class AdminShipmentController extends Controller
{
    public function index()
    {
        $pendingShipments = Shipment::orderBy('created_at', 'desc')->take(10)->get();

        $riders = User::where('role', 'rider')->get();

        return view('admin.dashboard', compact('pendingShipments', 'riders'));
    }

    public function deliveries()
{
    $shipments = \App\Models\Shipment::with('rider')->orderBy('created_at', 'desc')->get();
    $riders = \App\Models\User::where('role', 'rider')->get();

    return view('admin.deliveries', compact('shipments', 'riders'));
}

public function markInTransit(Request $request)
{
    $request->validate([
        'shipment_id' => 'required|exists:shipments,id',
    ]);

    $shipment = Shipment::findOrFail($request->shipment_id);
    $shipment->status = 'transit';
    $shipment->save();

    return back()->with('success', 'Shipment marked as in transit.');
}



  public function approveShipment(Request $request)
{
    try {
        $request->validate([
            'order_id' => 'required|exists:shipments,order_id',
        ]);

        $shipment = \App\Models\Shipment::where('order_id', $request->order_id)->firstOrFail();

        // ✅ Set as approved
        $shipment->status = 'approved';
        $shipment->save();

        return response()->json([
            'success' => true,
            'message' => 'Shipment approved successfully.',
        ]);
    } catch (\Throwable $e) {
        return response()->json([
            'success' => false,
            'message' => $e->getMessage(),
        ], 500);
    }
}


public function approvePayment($order_id)
{
    $shipment = Shipment::with('payment')->where('order_id', $order_id)->firstOrFail();

    // Update the payment record
    if ($shipment->payment) {
        $shipment->payment->update([
            'payment_status' => 'paid',
        ]);
    }

    // ✅ Also update shipment record to show as paid
    $shipment->update([
        'payment_status' => 'paid',
    ]);

    return back()->with('success', 'Payment verified and marked as paid.');
}




public function assign(Request $request)
{
    try {
        $request->validate([
            'order_id' => 'required|exists:shipments,order_id',
            'rider_id' => 'required|exists:users,id',
        ]);

        // ✅ Find shipment by order_id (not id)
        $shipment = Shipment::where('order_id', $request->order_id)->firstOrFail();

        // ✅ Find rider
        $rider = User::findOrFail($request->rider_id);

        // ✅ Update shipment
        $shipment->rider_id = $rider->id;
        $shipment->rider_name = $rider->first_name . ' ' . $rider->last_name;
        $shipment->status = 'assigned';
        $shipment->save();

        return response()->json([
            'success' => true,
            'message' => 'Rider assigned successfully!',
        ]);

    } catch (ValidationException $e) {
        // Validation errors → JSON response
        return response()->json([
            'success' => false,
            'message' => 'Validation failed',
            'errors' => $e->errors(),
        ], 422);

    } catch (\Throwable $e) {
        // Any other error → JSON response
        return response()->json([
            'success' => false,
            'message' => $e->getMessage(),
        ], 500);
    }
}







    /**
     * Mark shipment as delivered by admin or rider
     */
    public function markDelivered(Request $request)
    {
        $request->validate([
            'shipment_id' => 'required|exists:shipments,id'
        ]);

        $shipment = Shipment::findOrFail($request->shipment_id);
        $shipment->status = 'delivered';
        $shipment->delivered_at = now(); // Optional: add delivered_at column in your table
        $shipment->save();

        return back()->with('success', 'Shipment marked as delivered.');
    }

    /**
     * Cancel shipment by admin or rider
     */
    public function cancelShipment(Request $request)
    {
        $request->validate([
            'shipment_id' => 'required|exists:shipments,id',
            'cancelled_by' => 'required|string' // 'admin' or 'rider'
        ]);

        $shipment = Shipment::findOrFail($request->shipment_id);
        $shipment->status = 'cancelled';
        $shipment->cancelled_by = $request->cancelled_by;
        $shipment->cancelled_at = now(); // Optional: add cancelled_at column
        $shipment->save();

        return back()->with('error', 'Shipment cancelled by ' . ucfirst($request->cancelled_by) . '.');
    }
}
