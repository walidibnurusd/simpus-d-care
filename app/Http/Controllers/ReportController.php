<?php

namespace App\Http\Controllers;

use App\Models\Diagnosis;
use App\Models\Disease;
use App\Models\Doctor;
use App\Models\Hospital;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {   
        
        return view('content.report.index');
    }
}
