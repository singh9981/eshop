<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WelcomeController extends Controller
{
    public function index()
    {
        if (Auth::check() === true) {
            if (Auth::check() && Auth::user()->role === 'super_admin') {
                return redirect()->route('super.admin.dashboard')
                    ->with('warning', 'Only allowed for Super Admin');
            }
        } else {
            return view('welcome');
        }
    }
}
