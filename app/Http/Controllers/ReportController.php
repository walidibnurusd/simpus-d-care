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
    public function printTifoid()
    {   
        
        return view('content.report.print-tifoid');
    }
    public function printDiare()
    {   
        
        return view('content.report.print-diare');
    }
    public function reportDiare()
    {   
        
        return view('content.report.report-diare');
    }
    public function reportSTP()
    {   
        
        return view('content.report.laporan-stp');
    }
    public function reportPTM()
    {   
        
        return view('content.report.laporan-ptm');
    }
   
}
