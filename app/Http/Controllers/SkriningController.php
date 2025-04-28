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
use App\Models\GangguanJiwaDewasa;
use App\Models\LayakHamil;
use App\Models\Merokok;
use App\Models\Napza;
use App\Models\Obesitas;
use App\Models\Tbc;
use App\Models\TesDayaDengar;
use App\Models\TripleEliminasi;
use App\Models\Puma;
use App\Models\Preeklampsia;
use App\Models\Malaria;
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
        try {
        $patient = Patients::with([
            'kunjungans' => function ($query) {
                $query->orderBy('tanggal', 'desc'); // Urutkan kunjungan berdasarkan tanggal terbaru
            },
        ])->findOrFail($id);

        if (!$patient) {
            return response()->json(['error' => 'Patient not found'], 404);
        }

        $age = \Carbon\Carbon::parse($patient->dob)->age;

        // Ambil kunjungan terakhir
        $latestKunjungan = $patient->kunjungans->first();

        // Tentukan klaster berdasarkan logika
        if ($age < 5 && (!$latestKunjungan || !$latestKunjungan->hamil)) {
            $klaster = 2;
            $poliPatient = 'anak';
        } elseif ($latestKunjungan && $latestKunjungan->hamil) {
            $klaster = 2;
            $poliPatient = 'kia';
        } elseif ($age >= 5 && $age <= 18) {
            $klaster = 2;
            $poliPatient = 'mtbs';
        } else {
            $klaster = 3;
            $poliPatient = 'lansia';
        }
        // Tambahkan klaster ke data pasien
        $patient->klaster = $klaster;

        $skriningData = [];

        // Daftar lengkap jenis skrining untuk klaster 2 dan 3
        $allSkriningTypes = [
            2 => [
                'kia' => ['Preeklampsia', 'Hipertensi', 'Diabetes Mellitus', 'Anemia', 'Triple Eliminasi Bumil', 'TBC', 'SRQ (>18 Tahun)', 'Kekerasan terhadap Perempuan', 'Malaria'],
                'anak' => ['Hipertensi', 'Gangguan Spektrum Autisme', 'Kecacingan', 'HIV & IMS', 'Anemia', 'Talasemia', 'Hepatitis', 'Diabetes Mellitus', 'TBC'],
                'mtbs' => ['Hipertensi', 'Kecacingan', 'Anemia', 'Talasemia', 'Kekerasan terhadap Anak', 'Kekerasan terhadap Perempuan', 'Diabetes Mellitus', 'TBC', 'Tes Pendengaran', 'SDQ (4-11 Tahun)', 'SDQ (11-18 Tahun)', 'Obesitas', 'NAPZA', 'Perilaku Merokok bagi Anak Sekolah'],
            ],
            3 => ['lansia' => ['Kanker Paru', 'Kanker Kolorektal', 'PPOK (PUMA)', 'Geriatri', 'Kanker Leher Rahim dan Kanker Payudara', 'Hipertensi', 'TBC', 'Layak Hamil', 'Anemia', 'Talasemia']],
        ];

        $jenisSkrining = $allSkriningTypes[$klaster][$poliPatient];

        foreach ($jenisSkrining as $jenis) {
            // Ambil data skrining sesuai jenis
            $data = match ($jenis) {
                'Hipertensi' => Hipertensi::where('pasien', $id)->where('klaster', $klaster)->first(),
                'Gangguan Spektrum Autisme' => GangguanAutis::where('pasien', $id)->where('klaster', $klaster)->first(),
                'Kecacingan' => Kecacingan::where('pasien', $id)->where('klaster', $klaster)->first(),
                'HIV & IMS' => Hiv::where('pasien', $id)->where('klaster', $klaster)->first(),
                'Anemia' => Anemia::where('pasien', $id)->where('klaster', $klaster)->first(),
                'Talasemia' => Talasemia::where('pasien', $id)->where('klaster', $klaster)->first(),
                'Hepatitis' => Hepatitis::where('pasien', $id)->where('klaster', $klaster)->first(),
                'Kekerasan terhadap Anak' => KekerasanAnak::where('pasien', $id)->where('klaster', $klaster)->first(),
                'Kekerasan terhadap Perempuan' => KekerasanPerempuan::where('pasien', $id)->where('klaster', $klaster)->first(),
                'Diabetes Mellitus' => DiabetesMellitus::where('pasien', $id)->where('klaster', $klaster)->first(),
                'TBC' => Tbc::where('pasien', $id)->where('klaster', $klaster)->first(),
                'Triple Eliminasi Bumil' => TripleEliminasi::where('pasien', $id)->where('klaster', $klaster)->first(),
                'Tes Pendengaran' => TesDayaDengar::where('pasien', $id)->where('klaster', $klaster)->first(),
                'SDQ (4-11 Tahun)' => GangguanJiwaAnak::where('pasien', $id)->where('klaster', $klaster)->first(),
                'SDQ (11-18 Tahun)' => GangguanJiwaRemaja::where('pasien', $id)->where('klaster', $klaster)->first(),
                'Obesitas' => Obesitas::where('pasien', $id)->where('klaster', $klaster)->first(),
                'NAPZA' => Napza::where('pasien', $id)->where('klaster', $klaster)->first(),
                'Perilaku Merokok bagi Anak Sekolah' => Merokok::where('pasien', $id)->where('klaster', $klaster)->first(),
                'Kanker Paru' => KankerParu::where('pasien', $id)->where('klaster', $klaster)->first(),
                'Kanker Kolorektal' => KankerKolorektal::where('pasien', $id)->where('klaster', $klaster)->first(),
                'PPOK (PUMA)' => Puma::where('pasien', $id)->where('klaster', $klaster)->first(),
                'Geriatri' => Geriatri::where('pasien', $id)->where('klaster', $klaster)->first(),
                'Layak Hamil' => LayakHamil::where('pasien', $id)->where('klaster', $klaster)->first(),
                'Kanker Leher Rahim dan Kanker Payudara' => KankerPayudara::where('pasien', $id)->where('klaster', $klaster)->first(),
                'Preeklampsia' => Preeklampsia::where('pasien', $id)->where('klaster', $klaster)->first(),
                'SRQ (>18 Tahun)' => GangguanJiwaDewasa::where('pasien', $id)->where('klaster', $klaster)->first(),
                'Malaria' => Malaria::where('pasien', $id)->where('klaster', $klaster)->first(),

                default => null,
            };

            $skriningData[] = [
                'jenis_skrining' => $jenis,
                'kesimpulan_skrining' => $data->kesimpulan ?? '',
                'status_skrining' => $data ? 'Selesai' : 'Belum Selesai',
                'id' => $data->id ?? null,
                'poli' => $data->poli ?? 'Tidak Diketahui',
                'poliPatient' => $poliPatient,
                'patientId' => $patient->id,
                'route_name' => $this->formatRouteName($jenis),
            ];
        }

        // Ambil parameter pencarian dari DataTables
        $searchValue = $request->input('search.value', '');

        // Filter data berdasarkan pencarian
        if (!empty($searchValue)) {
            $skriningData = array_filter($skriningData, function ($row) use ($searchValue) {
                return stripos($row['jenis_skrining'], $searchValue) !== false || stripos($row['kesimpulan_skrining'], $searchValue) !== false || stripos($row['status_skrining'], $searchValue) !== false;
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
    catch (\Exception $e) {
        // Log the error with the exception message and stack trace
        Log::error("Error in getSkriningPatient for Patient ID: $id", [
            'error' => $e->getMessage(),
            'stack' => $e->getTraceAsString(),
        ]);

        return response()->json(['error' => 'An error occurred while processing the request.'], 500);
    }
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
            'Triple Eliminasi Bumil' => 'triple-eliminasi-bumil',
            'Tes Pendengaran' => 'test-pendengaran',
            'SDQ (4-11 Tahun)' => 'keswa-sdq',
            'SDQ (11-18 Tahun)' => 'keswa-sdq-remaja',
            'Obesitas' => 'obesitas',
            'NAPZA' => 'napza',
            'Perilaku Merokok bagi Anak Sekolah' => 'merokok',
            'Kanker Paru' => 'kanker-paru',
            'Kanker Kolorektal' => 'kanker-kolorektal',
            'PPOK (PUMA)' => 'puma',
            'Geriatri' => 'geriatri',
            'Kanker Leher Rahim dan Kanker Payudara' => 'kanker-payudara',
            'Layak Hamil' => 'layak-hamil',
            'SRQ (>18 Tahun)' => 'keswa-srq-dewasa',
            'Malaria' => 'malaria',
        ];
    }

    private function formatRouteName($jenis)
    {
        $routeMapping = $this->getRouteNameMapping();
        return $routeMapping[$jenis] ?? strtolower(str_replace(['&', ' '], '-', preg_replace('/[^a-zA-Z0-9\s]/', '', $jenis)));
    }
}
