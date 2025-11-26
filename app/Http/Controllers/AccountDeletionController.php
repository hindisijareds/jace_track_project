<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\AccountDeletionRequest;
use App\Models\User;

class AccountDeletionController extends Controller
{
    public function requestDeletion(Request $request)
    {
        $request->validate([
            'reason' => 'required|string|max:1000',
            'password' => 'required|string',
            'deletion_option' => 'required|in:7_days,immediate',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->password, $user->password)) {
            return back()->with('error', 'Incorrect password. Please verify your identity.');
        }

        // Prevent multiple requests
        if (AccountDeletionRequest::where('user_id', $user->id)->where('status', '!=', 'cancelled')->exists()) {
            return back()->with('error', 'You already have a pending deletion request.');
        }

        $deletion = new AccountDeletionRequest();
        $deletion->user_id = $user->id;
        $deletion->reason = $request->reason;
        $deletion->option = $request->deletion_option;

        if ($request->deletion_option === '7_days') {
            $deletion->status = 'scheduled';
            $deletion->scheduled_deletion = now()->addDays(7);
        } else {
            $deletion->status = 'pending'; // admin approval
        }

        $deletion->save();

        return back()->with('success', 'Your account deletion request has been submitted.');
    }

    public function cancelDeletion()
    {
        $user = Auth::user();
        AccountDeletionRequest::where('user_id', $user->id)
            ->where('status', 'scheduled')
            ->update(['status' => 'cancelled']);

        return back()->with('success', 'Account deletion request cancelled successfully.');
    }
}
