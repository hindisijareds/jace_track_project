    <?php

    use Illuminate\Support\Facades\Route;
    use Illuminate\Support\Facades\Auth;
    use App\Models\Shipment;
    use App\Http\Controllers\rideradd;
    use App\Http\Controllers\Auth\AuthenticatedSessionController;
    use App\Http\Controllers\Auth\RegisteredUserController;
    use App\Http\Controllers\ShipmentController;
    use App\Http\Controllers\CustomerController; 
    use App\Http\Controllers\AccountDeletionController;
    use App\Http\Controllers\RiderController;

    // Landing page
    Route::get('/', function () {
        return view('landing');
    });

    // Custom Auth Routes
    Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store']);
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
    use App\Http\Controllers\AdminController;

    Route::middleware(['auth'])->group(function () {
        Route::get('/admin/requests', [AdminController::class, 'viewRequests'])->name('admin.requests');
        Route::put('/admin/requests/{id}/approve', [AdminController::class, 'approve'])->name('admin.requests.approve');
        Route::put('/admin/requests/{id}/reject', [AdminController::class, 'reject'])->name('admin.requests.reject');
    });
    Route::middleware(['auth'])->group(function () {
        Route::get('/admin/deletion-requests', [AdminController::class, 'viewDeletionRequests'])->name('admin.deletion.requests');
        Route::put('/admin/deletion-requests/{id}/approve', [AdminController::class, 'approveDeletion'])->name('admin.deletion.approve');
        Route::put('/admin/deletion-requests/{id}/reject', [AdminController::class, 'rejectDeletion'])->name('admin.deletion.reject');
    });
// Rider Management
Route::get('/admin/riders/add', [AdminController::class, 'addRiderPage'])
    ->name('admin.riders.create');

Route::post('/admin/riders/add', [AdminController::class, 'storeRider'])
    ->name('admin.riders.store');

Route::delete('/admin/riders/delete/{id}', [AdminController::class, 'deleteRider'])
    ->name('admin.riders.delete');

    Route::middleware('auth')->group(function () {
        Route::post('/account/delete-request', [AccountDeletionController::class, 'requestDeletion'])->name('account.delete.request');
        Route::post('/account/cancel-deletion', [AccountDeletionController::class, 'cancelDeletion'])->name('account.delete.cancel');
    });
    Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('/register', [RegisteredUserController::class, 'store']);
    Route::middleware(['auth'])->group(function () {
        Route::get('/shipment', [ShipmentController::class, 'create'])->name('shipment.create');
        Route::post('/shipment', [ShipmentController::class, 'store'])->name('shipment.store');
    });

    Route::post('/api/distance', [ShipmentController::class, 'getDistance'])->name('api.distance');
    // Route for requesting permission to edit profile fields
    Route::post('/profile/request-change', [App\Http\Controllers\CustomerController::class, 'requestChange'])
        ->name('customer.requestChange');
    use App\Http\Controllers\FuelPriceController;

    Route::get('/api/fuel-price', [FuelPriceController::class, 'getDieselPrice']);

    // Role-based dashboards
    Route::middleware('auth')->group(function () {
        Route::get('/profile', [App\Http\Controllers\CustomerController::class, 'showProfile'])->name('profile');
        Route::put('/profile/update', [App\Http\Controllers\CustomerController::class, 'updateProfile'])->name('customer.updateProfile');
        Route::post('/profile/request-change', [App\Http\Controllers\CustomerController::class, 'requestChange'])->name('customer.requestChange');
    });

Route::middleware(['auth'])->prefix('rider')->name('rider.')->group(function () {
    // Keep your existing routes
    Route::get('/dashboard', [RiderController::class, 'dashboard'])->name('dashboard');
    Route::get('/deliveries', [RiderController::class, 'deliveries'])->name('deliveries');
    
    // NEW: Profile routes
    Route::get('/profile', [RiderController::class, 'profile'])->name('profile');
    Route::put('/profile', [RiderController::class, 'updateProfile'])->name('profile.update');
    Route::post('/profile/upload-license', [RiderController::class, 'uploadLicense'])->name('profile.upload-license');
});
    Route::get('/order/{tracking_number}', [ShipmentController::class, 'track'])->name('order.track');
    // My Orders Page
    Route::get('/orders', [ShipmentController::class, 'orders'])->name('orders');

    use App\Http\Controllers\AdminShipmentController;
Route::get('/riders/{rider}', [AdminController::class, 'showRider'])->name('admin.riders.show');
    Route::middleware(['auth', 'admin'])->group(function () {
        Route::get('/admin/shipments', [AdminShipmentController::class, 'index'])->name('admin.shipments');
       Route::get('/admin/deliveries', [AdminController::class, 'deliveries'])->name('admin.deliveries');

        Route::post('/admin/shipments/assign', [AdminShipmentController::class, 'assign'])->name('admin.shipments.assign');
        Route::post('/admin/shipments/approve', [AdminShipmentController::class, 'approveShipment'])->name('admin.shipments.approve');
        Route::post('/admin/shipments/delivered', [AdminShipmentController::class, 'markDelivered'])->name('admin.shipments.delivered');
        Route::post('/admin/shipments/cancel', [AdminShipmentController::class, 'cancelShipment'])->name('admin.shipments.cancel');
        Route::post('/shipments/update-status', [AdminShipmentController::class, 'updateStatus'])->name('admin.shipments.updateStatus');
    });
Route::get('/admin/riders/add', [AdminController::class, 'addRiderPage'])
    ->name('admin.riders.create');
Route::post('/admin/riders/add', [AdminController::class, 'storeRider'])
    ->name('admin.riders.store');


// ✅ ADD THESE THREE ROUTES:
Route::post('/admin/riders/{id}/disable', [AdminController::class, 'disableRider'])
    ->name('admin.riders.disable');
Route::post('/admin/riders/{id}/activate', [AdminController::class, 'activateRider'])
    ->name('admin.riders.activate');
Route::middleware(['auth', 'admin'])->group(function () {
    // ... existing admin routes
    
    Route::get('/admin/payment-proofs', [AdminController::class, 'paymentProofs'])->name('admin.payment_proofs');
    Route::post('/admin/payment-proofs/{shipment}/approve', [AdminController::class, 'approvePaymentProof'])->name('admin.payment_proofs.approve');
    Route::post('/admin/payment-proofs/{shipment}/reject', [AdminController::class, 'rejectPaymentProof'])->name('admin.payment_proofs.reject');
});
Route::post('/admin/deliveries/approve-payment/{order_id}', [AdminShipmentController::class, 'approvePayment'])
    ->name('admin.approvePayment');

    // Admin dashboard
    Route::get('/admin_dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    // Assign rider to a shipment
// Add this with your other admin routes
Route::get('/admin/shipments/{shipment}', [AdminController::class, 'showShipment'])
    ->name('admin.shipment.show');
  
Route::post('/admin/shipments/confirm-delivered', [AdminShipmentController::class, 'confirmDelivered'])
    ->name('admin.shipments.confirmDelivered');
// Add this inside your admin route group or after other admin routes
Route::get('/admin/shipments/{shipment}', [AdminController::class, 'showShipment'])
    ->name('admin.shipment.show');

    // Rider routes
    Route::middleware(['auth', 'rider'])->group(function () {
        Route::get('/rider/deliveries', [RiderController::class, 'deliveries'])->name('rider.deliveries');
      
Route::post('/rider/start-delivery/{order_id}', [RiderController::class, 'startDelivery'])->name('rider.startDelivery');

        Route::post('/rider/mark-paid/{order_id}', [RiderController::class, 'markAsPaid'])->name('rider.markPaid');
    });
Route::post('/rider/upload-proof', [RiderController::class, 'uploadProof'])
    ->name('rider.uploadProof'); // no middleware
Route::post('/admin/confirm-proof', [AdminController::class, 'confirmProof'])->name('admin.confirmProof');
Route::post('/admin/reject-proof', [AdminController::class, 'rejectProof'])->name('admin.rejectProof');
Route::get('/admin/reports', [AdminController::class, 'reports'])
    ->name('admin.reports');
Route::get('/reports', [AdminController::class, 'reports'])->name('reports');
    // Admin routes
    Route::middleware(['auth', 'admin'])->group(function () {
        // ✅ Proof of Delivery confirmation routes
Route::post('/admin/proof/confirm', [App\Http\Controllers\AdminController::class, 'confirmProof'])->name('admin.proof.confirm');
Route::post('/admin/proof/reject', [App\Http\Controllers\AdminController::class, 'rejectProof'])->name('admin.proof.reject');
Route::get('/reports', [AdminController::class, 'reports'])->name('reports');
        Route::get('/admin/payments', [AdminController::class, 'paymentVerifications'])->name('admin.payments');
        Route::post('/admin/payments/verify/{id}', [AdminController::class, 'verifyPayment'])->name('admin.verifyPayment');
    });
  Route::post('/admin/payments/reject/{id}', [AdminController::class, 'rejectPayment'])
        ->name('admin.rejectPayment');
Route::get('/dashboard', function () {
    $user = Auth::user();

    if ($user->role === 'admin') {
        // Redirect admins to proper dashboard logic
        return redirect()->route('admin.dashboard');
    } elseif ($user->role === 'rider') {
        return view('rider.dashboard');
    } else {
        $shipments = \App\Models\Shipment::where('customer_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        $inProgress = \App\Models\Shipment::where('customer_id', $user->id)
            ->whereIn('status', ['pending', 'transit'])
            ->count();

        $completed = \App\Models\Shipment::where('customer_id', $user->id)
            ->where('status', 'delivered')
            ->count();

        $exceptions = \App\Models\Shipment::where('customer_id', $user->id)
            ->where('status', 'cancelled')
            ->count();

        return view('customer.dashboard', compact('shipments', 'inProgress', 'completed', 'exceptions'));
    }
})->name('dashboard');



    require __DIR__ . '/auth.php';
