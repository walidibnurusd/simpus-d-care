<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Patients;

class DashboardController extends Controller
{
    // public function index()
    // {
    //     return view('content.dashboard');
    // }
    public function profile() {
        $user = Auth::user(); // Get the currently authenticated user
        // dd($user);
        return view('content.profile.index', ['user' => $user]);
    }
      public function index()
    {
        $patients = Patients::paginate(10); // Ambil data dengan paginasi 10 per halaman
        return view('content.dashboard', compact('patients'));
    }

}
