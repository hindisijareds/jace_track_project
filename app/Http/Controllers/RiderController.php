<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use App\Models\Shipment;

class RiderController extends Controller
{
    // Show all assigned deliveries
    public function deliveries()
    {
        $rider = Auth::user();

        $deliveries = Shipment::with(['payment', 'customer'])
            ->where('rider_id', $rider->id)
            ->orderByDesc('created_at')
            ->get();

        return view('rider.deliveries', compact('deliveries'));
    }

    public function startDelivery($orderId)
    {
        $shipment = Shipment::where('order_id', $orderId)->first();
        if ($shipment) {
            $shipment->status = 'transit';
            $shipment->save();
            return back()->with('success', 'Delivery started!');
        }
        return back()->with('error', 'Shipment not found.');
    }

    public function dashboard()
    {
        return view('rider.dashboard');
    }

    public function uploadProof(Request $request)
    {
        try {
            \Log::info('Upload proof triggered', $request->all());

            $request->validate([
                'order_id' => 'required|integer',
                'proof_image' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            ]);

            $shipment = Shipment::where('order_id', $request->order_id)->first();

            if (!$shipment) {
                return response()->json(['success' => false, 'message' => 'Shipment not found']);
            }

            // Store file
            $path = $request->file('proof_image')->store('proofs', 'public');

            // ✅ Use proof_of_delivery (NOT proof_image)
            $shipment->update([
                'proof_of_delivery' => $path,
                'proof_status' => 'pending',
                'status' => 'proof_pending',
            ]);

            // Double-check write succeeded
            \Log::info('Proof saved successfully', [
                'order_id' => $shipment->order_id,
                'proof_of_delivery' => $shipment->proof_of_delivery,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Proof uploaded successfully, waiting for admin confirmation.'
            ]);
        } catch (\Exception $e) {
            \Log::error('Upload proof error: '.$e->getMessage());
            return response()->json(['success' => false, 'message' => 'Server error: '.$e->getMessage()]);
        }
    }

    // NEW: Show rider profile
    public function profile()
    {
        $rider = Auth::user();
        return view('rider.profile', compact('rider'));
    }

    // NEW: Update rider profile
    public function updateProfile(Request $request)
    {
        $rider = Auth::user();
        
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $rider->id,
            'contact_number' => 'nullable|string|max:20',
            'city' => 'nullable|string|max:255',
            'barangay' => 'nullable|string|max:255',
            'zip_code' => 'nullable|string|max:10',
            'detailed_address' => 'nullable|string|max:500',
            'vehicle_type' => 'nullable|string|in:motorcycle,bicycle,car',
        ]);
        
        $rider->update($validated);
        return redirect()->back()->with('success', 'Profile updated successfully!');
    }

    // NEW: Upload Driver's License
    public function uploadLicense(Request $request)
    {
        $request->validate([
            'license_photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        
        $rider = Auth::user();
        
        if ($request->hasFile('license_photo')) {
            // Delete old photo if exists
            if ($rider->profile_picture) {
                Storage::disk('public')->delete($rider->profile_picture);
            }
            
            // Store new photo
            $path = $request->file('license_photo')->store('license_photos', 'public');
            $rider->update(['profile_picture' => $path]);
        }
        
        return redirect()->back()->with('success', "Driver's license uploaded successfully!");
    }

    public function markAsPaid($order_id)
    {
        $shipment = Shipment::with('payment')->findOrFail($order_id);

        if (Auth::user()->role !== 'rider') {
            abort(403, 'Unauthorized action.');
        }

        if ($shipment->payment && $shipment->payment->payment_status === 'pending') {
            $shipment->payment->update([
                'payment_status' => 'awaiting_verification',
            ]);
        }

        $shipment->update([
            'payment_status' => 'awaiting_verification',
        ]);

        return back()->with('success', 'Marked as paid upon pickup — awaiting admin verification.');
    }
}