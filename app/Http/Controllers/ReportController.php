<?php

namespace App\Http\Controllers;

use App\Models\Diagnosis;
use App\Models\Disease;
use App\Models\Doctor;
use App\Models\Hospital;
use App\Models\Action;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
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
    public function reportURT()
    {
        $services = ['Hecting (Jahit Luka)', 'Ganti Verban', 'Insici Abses', 'Sircumsisi (Bedah Ringan)', 'Ekstraksi Kuku', 'Observasi dengan tindakan Invasif', 'Observasi tanpa tindakan Invasif'];

        $data = [];

        foreach ($services as $service) {
            $data[$service] = [
                'akses' => Action::where('tindakan', $service)->where('kartu', 'akses')->count(),
                'bpjs_mandiri' => Action::where('tindakan', $service)->where('kartu', 'bpjs_mandiri')->count(),
                'bpjs_kis' => Action::where('tindakan', $service)->where('kartu', 'bpjs')->count(),
                'gratis' => Action::where('tindakan', $service)->where('kartu', 'gratis_jkd')->count(),
                'umum' => Action::where('tindakan', $service)->where('kartu', 'umum')->count(),
            ];
        }
        return view('content.report.laporan-urt', compact('data'));
    }
    public function reportLKRJ()
    {
        return view('content.report.laporan-lkrj');
    }
    public function reportRRT()
    {
        return view('content.report.laporan-rrt');
    }
    public function reportLL()
    {
        return view('content.report.laporan-ll');
    }
    public function reportFormulir10()
    {
        return view('content.report.laporan-formulir10');
    }

    public function reportFormulir11()
    {
        return view('content.report.laporan-formulir11');
    }
    public function reportFormulir12()
    {
        return view('content.report.laporan-formulir12');
    }
    public function reportLR()
    {
        return view('content.report.laporan-lr');
    }
    public function reportUP()
    {
        $patients = Action::whereHas('patient', function ($query) {
            $query->whereBetween(DB::raw('TIMESTAMPDIFF(YEAR, dob, CURDATE())'), [15, 59]);
        })->get();

        return view('content.report.laporan-up', compact('patients'));
    }
}
