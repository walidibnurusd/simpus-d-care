<?php

namespace App\Http\Controllers;

use App\Models\Action;
use App\Models\Patients;
use App\Models\Hipertensi;
use App\Models\GangguanAutis;
use App\Models\Anemia;
use App\Models\Talasemia;
use App\Models\DiabetesMellitus;
use App\Models\GangguanJiwaAnak;
use App\Models\GangguanJiwaRemaja;
use App\Models\Geriatri;
use App\Models\Hepatitis;
use App\Models\Hiv;
use App\Models\KankerKolorektal;
use App\Models\KankerParu;
use App\Models\KankerPayudara;
use App\Models\Kecacingan;
use App\Models\KekerasanPerempuan;
use App\Models\KekerasanAnak;
use App\Models\LayakHamil;
use App\Models\Merokok;
use App\Models\Napza;
use App\Models\Obesitas;
use App\Models\Tbc;
use App\Models\TesDayaDengar;
use App\Models\TripleEliminasi;
use App\Models\Puma;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Yajra\DataTables\DataTables;

class SkriningController extends Controller
{
        public function index()
    {
        $patients = Patients::all();
        return view('content.skrining.index', compact('patients'));
    }
   public function getSkriningPatient(Request $request, $id)
{
    // Ambil data pasien berdasarkan ID
    $patient = Patients::findOrFail($id);

    if (!$patient) {
        return response()->json(['error' => 'Patient not found'], 404);
    }

    $klaster = $patient->klaster;
    $poliPatient = $patient->poli;

    $skriningData = [];

    // Daftar lengkap jenis skrining untuk klaster 2 dan 3
    $allSkriningTypes = [
        2 => [
            'Hipertensi', 'Gangguan Spektrum Autisme', 'Kecacingan', 'HIV & IMS', 
            'Anemia', 'Talasemia', 'Hepatitis', 'Kekerasan terhadap Anak', 
            'Kekerasan terhadap Perempuan', 'Diabetes Mellitus', 'TBC', 
            'Triple Eliminasi Bumil', 'Tes Pendengaran', 'SDQ (4-11 Tahun)', 
            'SDQ (11-18 Tahun)', 'Obesitas', 'NAPZA', 
            'Perilaku Merokok bagi Anak Sekolah',
        ],
        3 => [
            'Kanker Paru', 'Kanker Kolorektal', 'PPOK (PUMA)', 'Geriatri', 
            'Kanker Leher Rahim dan Kanker Payudara', 'Hipertensi', 'TBC', 
            'Layak Hamil', 'Anemia', 'Talasemia',
        ],
    ];

    $jenisSkrining = $allSkriningTypes[$klaster] ?? [];

    foreach ($jenisSkrining as $jenis) {
        // Ambil data skrining sesuai jenis
        $data = match ($jenis) {
            'Hipertensi' => Hipertensi::where('pasien', $id)->where('klaster', $klaster)->first(),
            'Gangguan Spektrum Autisme' => GangguanAutis::where('pasien', $id)->where('klaster', $klaster)->first(),
            // Tambahkan semua jenis lainnya seperti ini...
            default => null,
        };

        $skriningData[] = [
            'jenis_skrining' => $jenis,
            'kesimpulan_skrining' => $data->kesimpulan ?? '',
            'status_skrining' => $data ? 'Selesai' : 'Belum Selesai',
            'id' => $data->id ?? null,
            'poli' => $data->poli ?? 'Tidak Diketahui',
            'poliPatient' => $poliPatient,
            'route_name' => $this->formatRouteName($jenis),
        ];
    }

    // Ambil parameter pencarian dari DataTables
    $searchValue = $request->input('search.value', '');

    // Filter data berdasarkan pencarian
    if (!empty($searchValue)) {
        $skriningData = array_filter($skriningData, function ($row) use ($searchValue) {
            return stripos($row['jenis_skrining'], $searchValue) !== false || 
                   stripos($row['kesimpulan_skrining'], $searchValue) !== false || 
                   stripos($row['status_skrining'], $searchValue) !== false;
        });
    }

    // Pagination parameters
    $start = $request->input('start', 0);
    $length = $request->input('length', 10);
    $draw = $request->input('draw', 1);

    $paginatedData = array_slice(array_values($skriningData), $start, $length);

    return response()->json([
        'draw' => (int) $draw,
        'recordsTotal' => count($skriningData),
        'recordsFiltered' => count($skriningData),
        'data' => $paginatedData,
    ]);
}

    private function getRouteNameMapping()
    {
        return [
            'HIV & IMS' => 'hiv',
            'Gangguan Spektrum Autisme' => 'gangguan-autis',
            'Kecacingan' => 'kecacingan',
            'Hipertensi' => 'hipertensi',
            'Anemia' => 'anemia',
            'Talasemia' => 'talasemia',
            'Hepatitis' => 'hepatitis',
            'Kekerasan terhadap Anak' => 'kekerasan-anak',
            'Kekerasan terhadap Perempuan' => 'kekerasan-perempuan',
            'Diabetes Mellitus' => 'diabetes-mellitus',
            'TBC' => 'tbc',
            'Triple Eliminasi Bumil' => 'triple-eliminasi',
            'Tes Pendengaran' => 'test-pendengaran',
            'SDQ (4-11 Tahun)' => 'sdq-anak',
            'SDQ (11-18 Tahun)' => 'sdq-remaja',
            'Obesitas' => 'obesitas',
            'NAPZA' => 'napza',
            'Perilaku Merokok bagi Anak Sekolah' => 'merokok',
            'Kanker Paru' => 'kanker-paru',
            'Kanker Kolorektal' => 'kanker-kolorektal',
            'PPOK (PUMA)' => 'puma',
            'Geriatri' => 'geriatri',
            'Kanker Leher Rahim dan Kanker Payudara' => 'kanker-payudara',
            'Layak Hamil' => 'layak-hamil',
        ];
    }

    private function formatRouteName($jenis)
    {
        $routeMapping = $this->getRouteNameMapping();
        return $routeMapping[$jenis] ?? strtolower(str_replace(['&', ' '], '-', preg_replace('/[^a-zA-Z0-9\s]/', '', $jenis)));
    }

}
