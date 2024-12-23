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
    public function reportAFP()
    {   
        
        return view('content.report.laporan-afp');
    }
    public function reportDifteri()
    {   
        
        return view('content.report.laporan-difteri');
    }
    public function reportC1()
    {   
        
        return view('content.report.laporan-c1');
    }
    public function reportRJP()
    {   
        
        return view('content.report.laporan-rjp');
    }
    public function reportSKDR()
    {   
        
        return view('content.report.laporan-skdr');
    }
    public function reportLKG()
    {   
        
        return view('content.report.laporan-lkg');
    }
    public function reportLRKG()
    {   
        
        return view('content.report.laporan-lrkg');
    }
    public function reportLKT()
    {   
        
        return view('content.report.laporan-lkt');
    }
    public function reportLBKT()
    {   
        
        return view('content.report.laporan-lbkt');
    }
   
}
