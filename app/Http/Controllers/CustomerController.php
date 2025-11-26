<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Shipment;
use App\Models\RequestChange; // ✅ Import the model

class CustomerController extends Controller
{
    public function dashboard()
{
    $user = Auth::user();

    // ✅ Fetch the 5 most recent shipments of the logged-in customer
    $shipments = Shipment::where('customer_id', $user->id)
        ->orderBy('created_at', 'desc')
        ->take(5)
        ->get();

    // ✅ Optional: counts for the dashboard cards
    $inProgress = Shipment::where('customer_id', $user->id)->where('status', 'transit')->count();
    $completed = Shipment::where('customer_id', $user->id)->where('status', 'delivered')->count();
    $exceptions = Shipment::where('customer_id', $user->id)->where('status', 'cancelled')->count();

    return view('customer.dashboard', compact('user', 'shipments', 'inProgress', 'completed', 'exceptions'));
}
    public function showProfile()
{
    $user = Auth::user();

    // Make sure contact_number shows the same as phone if not set
    if (empty($user->contact_number)) {
        $user->contact_number = $user->phone;
    }

    // ✅ Detect if admin unlocked the profile
    if (!$user->info_locked && session('just_unlocked') === null) {
        session(['just_unlocked' => true]);
        session()->flash('success', '✅ Your profile edit request was approved by the admin. You can now update your information.');
    }

    return view('customer.profile', compact('user'));
}


    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        // If first-time setup, allow full save
        if (!$user->info_locked) {
            $data = $request->validate([
                'first_name' => 'required|string|max:50',
                'middle_name' => 'nullable|string|max:50',
                'last_name' => 'required|string|max:50',
                'city' => 'required|string',
                'barangay' => 'required|string',
                'zip_code' => 'required|string|max:4',
                'detailed_address' => 'required|string',
                'contact_number' => 'required|string|max:11',
                'email' => 'required|email',
                'profile_picture' => 'nullable|image|max:2048',
            ]);

            // Keep contact_number in sync with phone
            $data['phone'] = $data['contact_number'];

            if ($request->hasFile('profile_picture')) {
                $data['profile_picture'] = $request->file('profile_picture')->store('profile_pictures', 'public');
            }

            $user->update($data);
            $user->info_locked = true; // Lock after first edit
            $user->save();

            return back()->with('success', 'Profile updated successfully! You’ll need admin permission for future changes.');
        }

        return back()->with('error', 'Profile is locked. Request permission to edit.');
    }

   public function requestChange(Request $request)
{
    $request->validate([
        'reason' => 'required|string',
    ]);

    $user = Auth::user();

    RequestChange::create([
        'user_id' => $user->id,
        'field' => 'profile_info', // default label
        'reason' => $request->reason,
        'status' => 'pending',
    ]);

        return back()->with('success', 'Request sent for admin approval.');
    }
}
