<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Shipment;
use App\Models\User;

class DashboardController extends Controller
{
    public function show()
    {
        $user = Auth::user();

        if ($user->role === 'admin') {
            $pendingShipments = Shipment::where('status', 'pending')->get();
            $riders = User::where('role', 'rider')->get(); // ✅ fetch riders
            return view('admin.dashboard', compact('pendingShipments', 'riders'));
        } elseif ($user->role === 'rider') {
            return view('rider.dashboard');
        } else {
            $shipments = Shipment::where('customer_id', $user->id)
                ->orderBy('created_at', 'desc')
                ->take(5)
                ->get();

            $inProgress = Shipment::where('customer_id', $user->id)
                ->whereIn('status', ['pending', 'transit'])
                ->count();

            $completed = Shipment::where('customer_id', $user->id)
                ->where('status', 'delivered')
                ->count();

            $exceptions = Shipment::where('customer_id', $user->id)
                ->where('status', 'cancelled')
                ->count();

            return view('customer.dashboard', compact('shipments', 'inProgress', 'completed', 'exceptions'));
        }
    }
}
