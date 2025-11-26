<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RequestChange;


use App\Models\User;
use App\Models\Payment; 
use App\Models\AccountDeletionRequest;
use App\Models\Shipment;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
class AdminController extends Controller
{
    /**
     * Display all profile change requests.
     */
    public function viewRequests()
    {
        $requests = RequestChange::with('user')->latest()->get();
        return view('admin.admin_requests', compact('requests'));
    }
public function viewDeletionRequests()
{
    $requests = AccountDeletionRequest::latest()->get();
    return view('admin_deletion_requests', compact('requests'));
}
public function reports(Request $request)
{
    // Base query for BOTH table and chart - respects date filters
    $baseQuery = Shipment::query();
    
    if ($request->filled('start_date')) {
        $baseQuery->whereDate('created_at', '>=', $request->start_date);
    }
    if ($request->filled('end_date')) {
        $baseQuery->whereDate('created_at', '<', date('Y-m-d', strtotime($request->end_date . ' +1 day')));
    }

    // --- KPI CARDS ---
    // Revenue: ONLY delivered shipments in the filtered range
    $totalRevenue = (clone $baseQuery)->where('status', 'delivered')->sum('total_cost');
    $totalDeliveries = Shipment::count(); // All time
    $activeRiders = User::where('role', 'rider')->where('status', 'active')->count();
    $recentIssues = Shipment::whereIn('status', ['cancelled', 'returned'])->with('customer')->latest()->take(5)->get();

    // --- REVENUE CHART (from FILTERED shipments) ---
    $revenueData = (clone $baseQuery)
        ->where('status', 'delivered')
        ->selectRaw('SUM(total_cost) as total, MONTH(created_at) as month')
        ->groupBy('month')
        ->orderBy('month')
        ->pluck('total', 'month')
        ->toArray();

    // Build full year data (Jan-Dec)
    $revenueChartData = [];
    for ($i = 1; $i <= 12; $i++) {
        $revenueChartData[] = $revenueData[$i] ?? 0;
    }

    // --- STATUS CHART (All time) ---
    $statusCounts = Shipment::select('status', DB::raw('count(*) as total'))->groupBy('status')->pluck('total', 'status')->toArray();
    $statusChartData = [
        $statusCounts['delivered'] ?? 0,
        $statusCounts['pending'] ?? 0,
        $statusCounts['cancelled'] ?? 0,
        $statusCounts['returned'] ?? 0
    ];

    // --- TOP RIDERS ---
    $topRiders = User::where('role', 'rider')
        ->withCount(['shipments as completed_deliveries' => function ($query) {
            $query->where('status', 'delivered');
        }])
        ->orderByDesc('completed_deliveries')
        ->take(5)->get();

    // --- RECENT ORDERS TABLE ---
    $recentOrders = $baseQuery->with(['customer', 'rider'])->orderByDesc('created_at')->take(10)->get();

    return view('admin.reports', compact(
        'totalRevenue',
        'totalDeliveries',
        'activeRiders',
        'revenueChartData',
        'statusChartData',
        'topRiders',
        'recentIssues',
        'recentOrders',
        'request'
    ));
}
// Add this method to your AdminController

public function showShipment($shipment) // Laravel will automatically find by ID
{
    $shipment = Shipment::with(['customer', 'rider', 'payment'])->findOrFail($shipment);
    return view('admin.shipment_details', compact('shipment'));
}
public function dashboard()
{
    // ✅ Fetch 10 most recent deliveries
    $shipments = Shipment::orderBy('created_at', 'desc')
        ->take(10)
        ->get();

    // ✅ Fetch all pending proofs (submitted by riders, waiting for admin confirmation)
  $pendingProofs = Shipment::where('proof_status', 'pending')
    ->whereNotNull('proof_of_delivery')
    ->orderByDesc('created_at')
    ->get(['order_id', 'proof_of_delivery', 'proof_status', 'status']);


    // Summary counts
    $totalDeliveries = Shipment::count();
    $failedDeliveries = Shipment::where('status', 'cancelled')->count();
    $activeRiders = User::where('role', 'rider')->where('status', 'active')->count();

    // Chart placeholders
    $deliveryLabels = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];
    $deliveryData = [20, 25, 18, 30, 22, 27, 10];
    $incomeLabels = ['Week 1', 'Week 2', 'Week 3', 'Week 4'];
    $incomeData = [12000, 15000, 11000, 17000];

    // Riders for modal dropdown
    $riders = User::where('role', 'rider')->get();

    // ✅ Add $pendingProofs to compact
    return view('admin.dashboard', compact(
        'shipments',
        'riders',
        'totalDeliveries',
        'failedDeliveries',
        'activeRiders',
        'deliveryLabels',
        'deliveryData',
        'incomeLabels',
        'incomeData',
        'pendingProofs'
    ));
}


// Show add page + list of riders
public function addRiderPage()
{
    $riders = User::where('role', 'rider')->get();
    return view('rideradd', compact('riders'));
}


// Store new rider
public function storeRider(Request $request)
{
    $validated = $request->validate([
        'first_name' => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z\s]+$/'],
        'last_name'  => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z\s]+$/'],
        'email'      => ['required', 'email', 'unique:users,email'],
        'phone'      => ['required', 'string', 'max:20', 'regex:/^(\+?\d{1,3})?[-.\s]?\(?\d{1,4}\)?[-.\s]?\d{1,4}[-.\s]?\d{1,9}$/'],
        'password'   => ['required', 'string', 'min:8', 'confirmed'],
        'password_confirmation' => ['required'],
        'vehicle_type' => ['required', 'in:Motorcycle,Van,Car,Bicycle'],
        'license_plate' => ['nullable', 'string', 'max:20', 'regex:/^[a-zA-Z0-9\s-]+$/'],
    ], [
        'first_name.regex' => 'First name may only contain letters and spaces.',
        'last_name.regex' => 'Last name may only contain letters and spaces.',
        'phone.regex' => 'Please enter a valid phone number format.',
        'password.min' => 'Password must be at least 8 characters.',
        'password.confirmed' => 'Password confirmation does not match.',
        'vehicle_type.in' => 'Please select a valid vehicle type.',
        'license_plate.regex' => 'License plate may only contain letters, numbers, spaces, and hyphens.',
    ]);

    User::create([
        'first_name' => $validated['first_name'],
        'last_name'  => $validated['last_name'],
        'email'      => $validated['email'],
        'phone'      => $validated['phone'],
        'contact_number' => $validated['phone'],
        'role'       => 'rider',
        'status'     => 'active',
        'vehicle_type' => $validated['vehicle_type'],
        'license_plate' => $validated['license_plate'],
        'password'   => bcrypt($validated['password']),
    ]);

    return redirect()->back()->with('success', 'Rider added successfully!');
}
public function rejectPayment($id)
{
    $payment = Payment::findOrFail($id);
    
    $payment->update([
        'payment_status' => 'rejected',
    ]);

    // Update shipment status too
    $payment->shipment->update([
        'payment_status' => 'rejected',
    ]);

    return back()->with('error', 'Payment rejected.');
}

// Delete rider
public function disableRider(Request $request, $id)
{
    // Add this at the beginning of the disableRider method
$request->session()->flash('suspend_rider_id', $id);
    $validated = $request->validate([
        'reason' => ['required', 'in:policy_violation,poor_performance,unauthorized_absence,misconduct,leave_of_absence,other'],
        'duration' => ['required', 'in:1_week,1_month,3_months,custom,permanent'],
        'custom_end_date' => ['required_if:duration,custom', 'date', 'after:today'],
        'message' => ['nullable', 'string', 'max:500'],
        'admin_password' => ['required', 'current_password'],
    ], [
        'reason.in' => 'Please select a valid reason for suspension.',
        'duration.in' => 'Please select a valid duration.',
        'custom_end_date.required_if' => 'Custom end date is required when selecting custom duration.',
        'custom_end_date.after' => 'End date must be in the future.',
        'admin_password.current_password' => 'Your password is incorrect.',
    ]);

    $rider = User::findOrFail($id);
    
    // ✅ Check if rider has active deliveries
    $activeDeliveries = \App\Models\Shipment::where('rider_id', $id)
        ->whereIn('status', ['assigned', 'transit', 'proof_pending', 'picked_up'])
        ->exists();
        
    if ($activeDeliveries) {
        return redirect()->back()
            ->with('error', 'Cannot suspend rider: Rider has active deliveries in progress. Please reassign or complete all deliveries first.');
    }

    // Calculate end date and duration text
    $endDate = null;
    $durationText = '';
    switch($validated['duration']) {
        case '1_week':
            $endDate = now()->addWeek();
            $durationText = '1 week';
            break;
        case '1_month':
            $endDate = now()->addMonth();
            $durationText = '1 month';
            break;
        case '3_months':
            $endDate = now()->addMonths(3);
            $durationText = '3 months';
            break;
        case 'custom':
            $endDate = Carbon::parse($validated['custom_end_date']);
            $durationText = 'until ' . $endDate->format('M d, Y');
            break;
        case 'permanent':
            $endDate = null;
            $durationText = 'permanent';
            break;
    }

    $rider->update([
        'status' => 'suspended',
        'suspension_reason' => $validated['reason'],
        'suspension_duration' => $validated['duration'],
        'suspension_end_date' => $endDate,
        'suspension_message' => $validated['message'],
        'suspended_at' => now(),
    ]);

    return redirect()->back()
        ->with('success', "Rider {$rider->first_name} {$rider->last_name} has been suspended for {$durationText}.");
}

// Activate rider
public function activateRider($id)
{
    $rider = User::findOrFail($id);
    $rider->update([
        'status' => 'active',
        'suspension_reason' => null,
        'suspension_duration' => null,
        'suspension_end_date' => null,
        'suspension_message' => null,
        'suspended_at' => null,
    ]);

    return redirect()->back()->with('success', "Rider {$rider->first_name} {$rider->last_name} has been reactivated.");
}


public function assignRider(Request $request)
{
    $request->validate([
        'shipment_id' => 'required',
        'rider_id' => 'required|exists:users,id',
    ]);

    $shipment = \App\Models\Shipment::findOrFail($request->shipment_id);
    $shipment->rider_id = $request->rider_id;
    $shipment->status = 'assigned';
    $shipment->save();

    // optional: notify rider (future feature)
    $rider = \App\Models\User::find($request->rider_id);

    return response()->json([
        'success' => true,
        'message' => 'Rider assigned successfully!',
        'rider_name' => $rider ? "{$rider->first_name} {$rider->last_name}" : null
    ]);
}


public function approveDeletion($id)
{
    $req = AccountDeletionRequest::findOrFail($id);
    $req->status = 'approved';
    $req->save();

    // Immediately delete the user account
    $user = User::find($req->user_id);
    if ($user) {
        $user->delete();
    }

    return back()->with('success', 'Account deleted successfully.');
}

public function rejectDeletion($id)
{
    $req = AccountDeletionRequest::findOrFail($id);
    $req->status = 'cancelled';
    $req->save();

    return back()->with('success', 'Account deletion request rejected.');
}

    /**
     * Approve a specific request.
     */
   public function approve($id)
{
    $req = RequestChange::findOrFail($id);
    $req->status = 'approved';
    $req->save();

    // ✅ Unlock user's profile
    $user = \App\Models\User::find($req->user_id);
    if ($user) {
        $user->info_locked = false;
        $user->save();

        // Optional: mark that this user was just unlocked
        session(['unlocked_user_'.$user->id => true]);
    }

    return back()->with('success', 'Request approved — profile unlocked for editing.');
}


    /**
     * Reject a specific request.
     */
    public function reject($id)
    {
        $req = RequestChange::findOrFail($id);
        $req->status = 'rejected';
        $req->save();

        return back()->with('error', 'Request rejected.');
    }
      public function paymentVerifications()
{
    // Payments awaiting verification
    $pendingProofs = Payment::with(['shipment'])
        ->where('payment_status', 'awaiting_verification')
        ->get();

    // KPI Card data
    $totalRevenue = Payment::where('payment_status', 'paid')->sum('amount');
    $pendingVerification = Payment::where('payment_status', 'awaiting_verification')->sum('amount');
    $totalTransactions = Payment::count();
    $totalDeliveries = Shipment::where('status', 'delivered')->count();
    $activeRiders = User::where('role', 'rider')->where('status', 'active')->count();

    // Monthly Revenue Chart (for this year)
    $revenueData = Payment::select(
            DB::raw('SUM(amount) as total'),
            DB::raw('MONTH(payment_date) as month')
        )
        ->whereYear('payment_date', date('Y'))
        ->where('payment_status', 'paid')
        ->groupBy('month')
        ->orderBy('month')
        ->pluck('total', 'month')
        ->toArray();

    $revenueChartData = [];
    for ($i = 1; $i <= 12; $i++) {
        $revenueChartData[] = $revenueData[$i] ?? 0;
    }

    // Payment Methods Chart (from shipments)
    $methodData = Shipment::select('payment_method', DB::raw('SUM(total_cost) as total'))
        ->whereNotNull('payment_method')
        ->where('payment_method', '!=', '')
        ->groupBy('payment_method')
        ->pluck('total', 'payment_method')
        ->toArray();

    $methodLabels = [];
    $methodValues = [];
    foreach ($methodData as $method => $total) {
        $methodLabels[] = ucwords(str_replace('_', ' ', $method));
        $methodValues[] = $total;
    }

    // Top Customers (from shipments)
    $topCustomers = Shipment::select('customer_id', 
            DB::raw('SUM(total_cost) as total_spent'),
            DB::raw('COUNT(*) as orders_count'))
        ->where('status', 'delivered')
        ->whereNotNull('customer_id')
        ->groupBy('customer_id')
        ->orderByDesc('total_spent')
        ->take(5)
        ->get();

    return view('admin.payments', compact(
        'pendingProofs',        // Renamed to match view expectation
        'totalRevenue',
        'pendingVerification',
        'totalTransactions',
        'totalDeliveries',
        'activeRiders',
        'revenueChartData',
        'methodLabels',
        'methodValues',
        'topCustomers'
    ));
}
    /**
 * Display payment proofs awaiting verification
 */
public function paymentProofs()
{
    // Change payment_proof_path TO proof_of_delivery
    $pendingProofs = Shipment::where('payment_status', 'awaiting_verification')
        ->whereNotNull('proof_of_delivery')  // <-- FIX HERE
        ->with(['customer'])
        ->orderByDesc('created_at')
        ->get();

    return view('admin.payment_proofs', compact('pendingProofs'));
}

/**
 * Verify and approve a payment proof
 */
public function showRider($id)
{
    // Get rider details
    $rider = User::findOrFail($id);
    
    // Get current/active deliveries with pagination
    $currentDeliveries = Shipment::with(['customer', 'payment'])
        ->where('rider_id', $id)
        ->whereIn('status', ['assigned', 'transit', 'proof_pending'])
        ->orderByDesc('created_at')
        ->paginate(10, ['*'], 'current_page'); // 10 items per page
    
    // Get delivery history with pagination
    $deliveryHistory = Shipment::with(['customer', 'payment'])
        ->where('rider_id', $id)
        ->where('status', 'delivered')
        ->orderByDesc('created_at')
        ->paginate(10, ['*'], 'history_page'); // 10 items per page
    
    // Get rider stats (keep these as counts, not paginated)
    $totalDeliveries = Shipment::where('rider_id', $id)->count();
    $completedDeliveries = Shipment::where('rider_id', $id)->where('status', 'delivered')->count();
    $pendingDeliveries = Shipment::where('rider_id', $id)->whereIn('status', ['assigned', 'transit'])->count();

    return view('admin.rider_show', compact(
        'rider', 
        'currentDeliveries', 
        'deliveryHistory',
        'totalDeliveries',
        'completedDeliveries',
        'pendingDeliveries'
    ));
}
public function approvePaymentProof($shipmentId)
{
    $shipment = Shipment::findOrFail($shipmentId);
    
    $shipment->update([
        'payment_status' => 'verified',
    ]);

    return back()->with('success', 'Payment proof verified successfully.');
}

/**
 * Reject a payment proof
 */
public function rejectPaymentProof($shipmentId)
{
    $shipment = Shipment::findOrFail($shipmentId);
    
    // Delete the proof file
    if ($shipment->payment_proof_path) {
        Storage::disk('public')->delete($shipment->payment_proof_path);
    }
    
    $shipment->update([
        'payment_status' => 'rejected',
        'payment_proof_path' => null,
    ]);

    return back()->with('error', 'Payment proof rejected. Customer must re-upload.');
}
public function deliveries(Request $request)
{
    $query = Shipment::with('rider');
    
    // Apply status filter
    if ($request->filled('status') && $request->status !== 'all') {
        $query->where('status', $request->status);
    }
    
    // Apply date range filter
    if ($request->filled('start_date')) {
        $query->whereDate('created_at', '>=', $request->start_date);
    }
    if ($request->filled('end_date')) {
        $query->whereDate('created_at', '<=', $request->end_date);
    }
    
    // Filter by assignment
    if ($request->filled('assignment') && $request->assignment === 'unassigned') {
        $query->whereNull('rider_id');
    } elseif ($request->filled('assignment') && $request->assignment === 'assigned') {
        $query->whereNotNull('rider_id');
    }
    
    // Apply search filter
    if ($request->filled('search')) {
        $query->where(function($q) use ($request) {
            $q->where('tracking_number', 'like', '%' . $request->search . '%')
              ->orWhere('order_id', 'like', '%' . $request->search . '%');
        });
    }
    
    // Order by latest first and paginate
    $shipments = $query->orderByDesc('created_at')->paginate(10);
    
    // Get all riders for the assign modal
    $riders = User::where('role', 'rider')->get();
    
    // Get status counts for tabs
    $statusCounts = Shipment::select('status', DB::raw('count(*) as total'))
        ->groupBy('status')
        ->pluck('total', 'status');

    return view('admin.deliveries', compact('shipments', 'riders', 'statusCounts'));
}
public function verifyPayment($id)
{
    $payment = Payment::findOrFail($id);

    $payment->update([
        'payment_status' => 'paid',
        'payment_date' => now(),
    ]);

    // Also update shipment
    $payment->shipment->update([
        'payment_status' => 'paid',
    ]);

    return back()->with('success', 'Payment verified and approved successfully.');
}
    public function confirmProof(Request $request)
{
    $request->validate([
        'order_id' => 'required|exists:shipments,order_id',
    ]);

    $shipment = Shipment::where('order_id', $request->order_id)->firstOrFail();

    // ✅ Check if proof exists before confirming
    // ✅ Check if proof image exists before confirming
if (!$shipment->proof_of_delivery) {
    return response()->json(['success' => false, 'message' => 'No proof image found for this delivery.'], 400);
}



    $shipment->update([
        'proof_status' => 'confirmed',
        'status' => 'delivered',
        'delivered_at' => now(),
    ]);

    return response()->json([
        'success' => true,
        'message' => 'Proof of delivery confirmed successfully.',
    ]);
}

public function rejectProof(Request $request)
{
    $request->validate([
        'order_id' => 'required|exists:shipments,order_id',
    ]);

    $shipment = Shipment::where('order_id', $request->order_id)->firstOrFail();

    // ✅ Optional: reset proof_of_delivery field if rejected
    $shipment->update([
        'proof_status' => 'rejected',
    ]);

    return response()->json([
        'success' => true,
        'message' => 'Proof of delivery has been rejected.',
    ]);
}

}
