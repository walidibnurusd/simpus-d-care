<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    // public function index()
    // {
    //     return view('content.dashboard');
    // }
    public function profile() {
        $user = Auth::user(); // Get the currently authenticated user
        return view('content.profile.index', ['user' => $user]);
    }
}
