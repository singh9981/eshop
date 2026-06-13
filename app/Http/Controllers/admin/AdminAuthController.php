<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AdminAuthController extends Controller
{    

public function login(Request $request)
{
    if (Auth::guard('admin')->attempt($request->only('email','password'))) {

        $admin = Auth::guard('admin')->user();

        // ❌ inactive
        if (!$admin->is_active) {
            Auth::guard('admin')->logout();
            return back()->with('error','Account Disabled');
        }

        // ❌ expiry check (only admin)
        if ($admin->type === 'admin' &&
            Carbon::now()->gt($admin->access_expiry_date)) {

            Auth::guard('admin')->logout();
            return back()->with('error','Access Expired');
        }

        return redirect('/admin/dashboard');
    }

    return back()->with('error','Invalid Credentials');
}

}
