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
use Illuminate\Support\Facades\Log;
class ReportController extends Controller
{
    public function index()
    {
        return view('content.report.index');
    }
    public function printTifoid()
    {
        $tifoid = Action::with('patient.villages')
            ->whereIn('diagnosa', [265, 39])
            ->orWhere(function ($query) {
                $query->whereJsonContains('diagnosa', '265')->orWhereJsonContains('diagnosa', '39');
            })
            ->get();
        $tifoid->load('patient.villages');

        return view('content.report.print-tifoid', compact('tifoid'));
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
        $rujukan = Action::select('rujuk_rs', DB::raw('COUNT(*) as count'))->where('rujuk_rs', '!=', '1')->groupBy('rujuk_rs')->orderBy('count', 'desc')->take(10)->get();
        $actions = Action::select('diagnosa', 'icd10')->get();

        $diagnosisData = [];

        foreach ($actions as $action) {
            $diagnosisIds = [];
            if (is_array($action->diagnosa)) {
                $diagnosisIds = $action->diagnosa;
            } elseif (is_string($action->diagnosa)) {
                $decoded = json_decode($action->diagnosa, true);
                if (is_array($decoded)) {
                    $diagnosisIds = $decoded;
                }
            }

            if (empty($diagnosisIds)) {
                continue;
            }

            foreach ($diagnosisIds as $diagnosisId) {
                $key = $diagnosisId . '-' . ($action->icd10 ?? 'Unknown');

                if (!isset($diagnosisData[$key])) {
                    $diagnosisData[$key] = [
                        'name' => Diagnosis::find($diagnosisId)?->name ?? 'Unknown',
                        'icd10' => $action->icd10,
                        'count' => 0,
                    ];
                }

                $diagnosisData[$key]['count']++;
            }
        }

        usort($diagnosisData, fn($a, $b) => $b['count'] - $a['count']);

        $topDiagnoses = array_slice($diagnosisData, 0, 10);

        return view('content.report.laporan-rrt', compact('rujukan', 'diagnosisData'));
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
