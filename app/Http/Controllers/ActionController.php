<?php

namespace App\Http\Controllers;

use App\Models\Action;
use App\Models\Diagnosis;
use App\Models\Disease;
use App\Models\Doctor;
use App\Models\Kia;
use App\Models\User;
use App\Models\Hospital;
use App\Models\Patients;
use App\Models\Kunjungan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ActionController extends Controller
{
    public function index(Request $request)
    {
        // Get the filtering dates from the request
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        // Retrieve all doctors, actions, diagnoses, diseases, and hospitals
        $dokter = User::where('role', 'dokter')->get();
        $diagnosa = Diagnosis::where('tipe', 'poli-umum')->get();
        $penyakit = Disease::all();
        $rs = Hospital::all();

        // Filter actions based on the date range
        $actionsQuery = Action::where('tipe', 'poli-umum');

        if ($startDate) {
            $actionsQuery->whereDate('tanggal', '>=', $startDate);
        }

        if ($endDate) {
            $actionsQuery->whereDate('tanggal', '<=', $endDate);
        }

        $actions = $actionsQuery->get();

        // Get the current route name
        $routeName = $request->route()->getName();

        // Return the view with the data
        return view('content.action.index', compact('actions', 'dokter', 'penyakit', 'rs', 'diagnosa', 'routeName'));
    }
    public function indexPoliGigi(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $dokter = User::where('role', 'dokter')->get();

        $diagnosa = Diagnosis::where('tipe', 'poli-gigi')->get();

        $penyakit = Disease::all();
        $rs = Hospital::all();
        $actionsQuery = Action::where('tipe', 'poli-gigi');

        if ($startDate) {
            $actionsQuery->whereDate('tanggal', '>=', $startDate);
        }

        if ($endDate) {
            $actionsQuery->whereDate('tanggal', '<=', $endDate);
        }

        $actions = $actionsQuery->get();

        $routeName = $request->route()->getName();

        return view('content.action.index', compact('actions', 'dokter', 'penyakit', 'rs', 'diagnosa', 'routeName'));
    }
    public function indexUgd(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $dokter = User::where('role', 'dokter')->get();

        $diagnosa = Diagnosis::where('tipe', 'ruang-tindakan')->get();

        $penyakit = Disease::all();
        $rs = Hospital::all();

        $actionsQuery = Action::where('tipe', 'ruang-tindakan');

        if ($startDate) {
            $actionsQuery->whereDate('tanggal', '>=', $startDate);
        }

        if ($endDate) {
            $actionsQuery->whereDate('tanggal', '<=', $endDate);
        }

        $actions = $actionsQuery->get();
        $routeName = $request->route()->getName();

        return view('content.action.index', compact('actions', 'dokter', 'penyakit', 'rs', 'diagnosa', 'routeName'));
    }
    public function indexDokter(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $dokter = User::where('role', 'dokter')->get();
        $diagnosa = Diagnosis::where('tipe', 'poli-umum')->get();

        $penyakit = Disease::all();
        $rs = Hospital::all();
        $actionsQuery = Action::where('tipe', 'poli-umum')->whereNotNull('diagnosa');

        if ($startDate) {
            $actionsQuery->whereDate('tanggal', '>=', $startDate);
        }

        if ($endDate) {
            $actionsQuery->whereDate('tanggal', '<=', $endDate);
        }

        $actions = $actionsQuery->get();

        $routeName = $request->route()->getName();
        return view('content.action.index-dokter', compact('actions', 'dokter', 'penyakit', 'rs', 'diagnosa', 'routeName'));
    }
    public function indexGigiDokter(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $dokter = User::where('role', 'dokter')->get();
        $diagnosa = Diagnosis::where('tipe', 'poli-gigi')->get();

        $penyakit = Disease::all();
        $rs = Hospital::all();

        $actionsQuery = Action::where('tipe', 'poli-gigi')->whereNotNull('diagnosa');

        if ($startDate) {
            $actionsQuery->whereDate('tanggal', '>=', $startDate);
        }

        if ($endDate) {
            $actionsQuery->whereDate('tanggal', '<=', $endDate);
        }

        $actions = $actionsQuery->get();
        $routeName = $request->route()->getName();

        return view('content.action.index-dokter', compact('actions', 'dokter', 'penyakit', 'rs', 'diagnosa', 'routeName'));
    }

    public function indexUgdDokter(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $dokter = User::where('role', 'dokter')->get();

        $diagnosa = Diagnosis::where('tipe', 'ruang-tindakan')->get();

        $penyakit = Disease::all();
        $rs = Hospital::all();
        $actionsQuery = Action::where('tipe', 'ruang-tindakan')->whereNotNull('diagnosa');

        if ($startDate) {
            $actionsQuery->whereDate('tanggal', '>=', $startDate);
        }

        if ($endDate) {
            $actionsQuery->whereDate('tanggal', '<=', $endDate);
        }

        $actions = $actionsQuery->get();
        $routeName = $request->route()->getName();
        return view('content.action.index-dokter', compact('actions', 'dokter', 'penyakit', 'rs', 'diagnosa', 'routeName'));
    }
    public function indexLab(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $dokter = User::where('role', 'dokter')->get();
        $diagnosa = Diagnosis::where('tipe', 'poli-umum')->get();

        $penyakit = Disease::all();
        $rs = Hospital::all();
        $actionsQuery = Action::where('tipe', 'poli-umum')->whereNotNull('hasil_lab');

        if ($startDate) {
            $actionsQuery->whereDate('tanggal', '>=', $startDate);
        }

        if ($endDate) {
            $actionsQuery->whereDate('tanggal', '<=', $endDate);
        }

        $actions = $actionsQuery->get();

        $routeName = $request->route()->getName();
        return view('content.action.index-lab', compact('actions', 'dokter', 'penyakit', 'rs', 'diagnosa', 'routeName'));
    }
    public function indexGigiLab(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $dokter = User::where('role', 'dokter')->get();
        $diagnosa = Diagnosis::where('tipe', 'poli-gigi')->get();

        $penyakit = Disease::all();
        $rs = Hospital::all();

        $actionsQuery = Action::where('tipe', 'poli-gigi')->whereNotNull('hasil_lab');

        if ($startDate) {
            $actionsQuery->whereDate('tanggal', '>=', $startDate);
        }

        if ($endDate) {
            $actionsQuery->whereDate('tanggal', '<=', $endDate);
        }

        $actions = $actionsQuery->get();
        $routeName = $request->route()->getName();

        return view('content.action.index-lab', compact('actions', 'dokter', 'penyakit', 'rs', 'diagnosa', 'routeName'));
    }

    public function indexUgdLab(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $dokter = User::where('role', 'dokter')->get();

        $diagnosa = Diagnosis::where('tipe', 'ruang-tindakan')->get();

        $penyakit = Disease::all();
        $rs = Hospital::all();
        $actionsQuery = Action::where('tipe', 'ruang-tindakan')->whereNotNull('hasil_lab');

        if ($startDate) {
            $actionsQuery->whereDate('tanggal', '>=', $startDate);
        }

        if ($endDate) {
            $actionsQuery->whereDate('tanggal', '<=', $endDate);
        }

        $actions = $actionsQuery->get();
        $routeName = $request->route()->getName();
        return view('content.action.index-lab', compact('actions', 'dokter', 'penyakit', 'rs', 'diagnosa', 'routeName'));
    }
    public function indexKiaLab(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $dokter = User::where('role', 'dokter')->get();

        $diagnosa = Diagnosis::where('tipe', 'ruang-tindakan')->get();

        $penyakit = Disease::all();
        $rs = Hospital::all();
        $actionsQuery = Action::where('tipe', 'poli-kia')->whereNotNull('hasil_lab');

        if ($startDate) {
            $actionsQuery->whereDate('tanggal', '>=', $startDate);
        }

        if ($endDate) {
            $actionsQuery->whereDate('tanggal', '<=', $endDate);
        }

        $actions = $actionsQuery->get();
        $routeName = $request->route()->getName();
        return view('content.action.index-lab', compact('actions', 'dokter', 'penyakit', 'rs', 'diagnosa', 'routeName'));
    }
    public function indexKbLab(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $dokter = User::where('role', 'dokter')->get();

        $diagnosa = Diagnosis::where('tipe', 'ruang-tindakan')->get();

        $penyakit = Disease::all();
        $rs = Hospital::all();
        $actionsQuery = Action::where('tipe', 'poli-kb')->whereNotNull('hasil_lab');

        if ($startDate) {
            $actionsQuery->whereDate('tanggal', '>=', $startDate);
        }

        if ($endDate) {
            $actionsQuery->whereDate('tanggal', '<=', $endDate);
        }

        $actions = $actionsQuery->get();
        $routeName = $request->route()->getName();
        return view('content.action.index-lab', compact('actions', 'dokter', 'penyakit', 'rs', 'diagnosa', 'routeName'));
    }
    public function indexDokterKia(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $dokter = User::where('role', 'dokter')->get();
        $actionsQuery = Action::where('tipe', 'poli-kia')->where('usia_kehamilan', '!=', 0);
        if ($startDate) {
            $actionsQuery->whereDate('tanggal', '>=', $startDate);
        }

        if ($endDate) {
            $actionsQuery->whereDate('tanggal', '<=', $endDate);
        }

        $actions = $actionsQuery->get();
        $routeName = $request->route()->getName();
        return view('content.action.index-kia', compact('actions', 'dokter', 'routeName'));
    }
    public function indexDokterKb(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $dokter = User::where('role', 'dokter')->get();
        $actionsQuery = Action::where('tipe', 'poli-kb')->whereNotNull('layanan_kb');
        if ($startDate) {
            $actionsQuery->whereDate('tanggal', '>=', $startDate);
        }

        if ($endDate) {
            $actionsQuery->whereDate('tanggal', '<=', $endDate);
        }

        $actions = $actionsQuery->get();
        $routeName = $request->route()->getName();
        return view('content.action.index-kb', compact('actions', 'dokter', 'routeName'));
    }
    public function indexKia(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $dokter = User::where('role', 'dokter')->get();
        $actionsQuery = Action::where('tipe', 'poli-kia');
        if ($startDate) {
            $actionsQuery->whereDate('tanggal', '>=', $startDate);
        }

        if ($endDate) {
            $actionsQuery->whereDate('tanggal', '<=', $endDate);
        }

        $actions = $actionsQuery->get();
        $routeName = $request->route()->getName();
        return view('content.action.index', compact('actions', 'dokter', 'routeName'));
    }
    public function indexKb(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $dokter = User::where('role', 'dokter')->get();
        $actionsQuery = Action::where('tipe', 'poli-kb');
        if ($startDate) {
            $actionsQuery->whereDate('tanggal', '>=', $startDate);
        }

        if ($endDate) {
            $actionsQuery->whereDate('tanggal', '<=', $endDate);
        }

        $actions = $actionsQuery->get();
        $routeName = $request->route()->getName();
        return view('content.action.index', compact('actions', 'dokter', 'routeName'));
    }
    public function actionReport(Request $request)
    {
        // Ambil parameter filter awal dan akhir dari query string
        $startDate = $request->query('start_date');
        $endDate = $request->query('end_date');

        // Query data dari tabel 'actions'
        $query = Action::query();

        // Jika filter tanggal diberikan, tambahkan kondisi ke query
        if ($startDate && $endDate) {
            $query->whereBetween('tanggal', [$startDate, $endDate]);
        }

        // Eksekusi query untuk mendapatkan hasil
        $actions = $query->get();

        // Kirim data ke view
        return view('content.action.print', compact('actions'));
    }

    public function store(Request $request)
    {
        try {
            // Fetch the patient ID based on the provided NIK
            // dd($request->all());
            $patient = Patients::where('nik', $request->nik)->first();

            if (!$patient) {
                return redirect()
                    ->back()
                    ->withErrors(['nik' => 'Patient with the provided NIK does not exist.'])
                    ->withInput();
            }

            // Format the date and merge the patient ID into the request
            $request->merge([
                'id_patient' => $patient->id,
            ]);

            // Validate the request
            $validated = $request->validate([
                'id_patient' => 'required|exists:patients,id',
                'tanggal' => 'required|date',
                'tipe' => 'required',
                'doctor' => 'required',
                'kunjungan' => 'nullable|string|max:255',
                'faskes' => 'nullable|string|max:255',
                'sistol' => 'nullable|numeric',
                'diastol' => 'nullable|numeric',
                'beratBadan' => 'nullable|numeric',
                'tinggiBadan' => 'nullable|numeric',
                'lingkarPinggang' => 'nullable|numeric',
                'nadi' => 'nullable|numeric',
                'nafas' => 'nullable|numeric',
                'suhu' => 'nullable|numeric',
                'riwayat_penyakit_sekarang' => 'nullable',
                'riwayat_penyakit_dulu' => 'nullable',
                'riwayat_penyakit_lainnya' => 'nullable',
                'riwayat_penyakit_keluarga' => 'nullable',
                'riwayat_penyakit_lainnya_keluarga' => 'nullable',
                'riwayat_pengobatan' => 'nullable',
                'riwayat_alergi' => 'nullable',
                'keluhan' => 'nullable|string|max:255',
                'keterangan' => 'nullable|string|max:255',
            ]);

            // Save the validated data into the actions table
            $action = Action::create($validated);
            if ($action->tipe === 'poli-umum') {
                $route = 'action.index';
            } elseif ($action->tipe === 'poli-gigi') {
                $route = 'action.index.gigi';
            } elseif ($action->tipe === 'poli-kia') {
                $route = 'action.kia.index';
            } elseif ($action->tipe === 'poli-kb') {
                $route = 'action.kb.index';
            } else {
                $route = 'action.index.ugd';
            }
            return redirect()->route($route)->with('success', 'Action has been successfully created.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withErrors(['error' => 'An error occurred: ' . $e->getMessage()])
                ->withInput();
        }
    }

    public function update(Request $request, $id)
    {
        try {
            // Find the action record to be updated
            $action = Action::findOrFail($id);

            // Fetch the patient ID based on the provided NIK
            $patient = Patients::where('nik', $request->nikEdit)->first();

            if (!$patient) {
                return redirect()
                    ->back()
                    ->withErrors(['nik' => 'Patient with the provided NIK does not exist.'])
                    ->withInput();
            }

            // Format the date and merge the patient ID into the request
            $request->merge([
                'id_patient' => $patient->id,
            ]);

            // Validate the request
            $validated = $request->validate([
                'id_patient' => 'required|exists:patients,id',
                'tanggal' => 'required|date',
                'doctor' => 'required',
                'kunjungan' => 'nullable|string|max:255',
                'faskes' => 'nullable|string|max:255',
                'sistol' => 'nullable|numeric',
                'diastol' => 'nullable|numeric',
                'beratBadan' => 'nullable|numeric',
                'tinggiBadan' => 'nullable|numeric',
                'lingkarPinggang' => 'nullable|numeric',
                'riwayat_penyakit_sekarang' => 'nullable',
                'riwayat_penyakit_dulu' => 'nullable',
                'riwayat_penyakit_lainnya' => 'nullable',
                'riwayat_penyakit_keluarga' => 'nullable',
                'riwayat_penyakit_lainnya_keluarga' => 'nullable',
                'riwayat_pengobatan' => 'nullable',
                'riwayat_alergi' => 'nullable',
                'keluhan' => 'nullable|string|max:255',
                'diagnosa' => 'nullable',
                'tindakan' => 'nullable',
                'rujuk_rs' => 'nullable|exists:hospitals,id',
                'keterangan' => 'nullable|string|max:255',
                'nadi' => 'nullable|numeric',
                'nafas' => 'nullable|numeric',
                'suhu' => 'nullable|numeric',
                'mata_anemia' => 'nullable|string|max:255',
                'pupil' => 'nullable|string|max:255',
                'ikterus' => 'nullable|string|max:255',
                'udem_palpebral' => 'nullable|string|max:255',
                'nyeri_tekan' => 'nullable|string|max:255',
                'peristaltik' => 'nullable|string|max:255',
                'ascites' => 'nullable|string|max:255',
                'lokasi_abdomen' => 'nullable|string|max:255',
                'thorax' => 'nullable|string|max:255',
                'thorax_bj' => 'nullable|string|max:255',
                'suara_nafas' => 'nullable|string|max:255',
                'ronchi' => 'nullable|string|max:255',
                'wheezing' => 'nullable|string|max:255',
                'ekstremitas' => 'nullable|string|max:255',
                'edema' => 'nullable|string|max:255',
                'tonsil' => 'nullable|string|max:255',
                'fharing' => 'nullable|string|max:255',
                'kelenjar' => 'nullable|string|max:255',
                'genetalia' => 'nullable|string|max:255',
                'warna_kulit' => 'nullable|string|max:255',
                'turgor' => 'nullable|string|max:255',
                'neurologis' => 'nullable|string|max:255',
                'hasil_lab' => 'nullable|string|max:255',
                'obat' => 'nullable',
                'pemeriksaan_penunjang' => 'nullable',
                'usia_kehamilan' => 'nullable',
                'jenis_anc' => 'nullable',
                'lingkar_lengan_atas' => 'nullable',
                'tinggi_fundus_uteri' => 'nullable',
                'presentasi_janin' => 'nullable',
                'denyut_jantung' => 'nullable',
                'kaki_bengkak' => 'nullable',
                'imunisasi_tt' => 'nullable',
                'tablet_fe' => 'nullable',
                'gravida' => 'nullable',
                'partus' => 'nullable',
                'abortus' => 'nullable',
                'proteinuria' => 'nullable',
                'hiv' => 'nullable',
                'sifilis' => 'nullable',
                'hepatitis' => 'nullable',
                'periksa_usg' => 'nullable',
                'hasil_usg' => 'nullable',
                'treatment_anc' => 'nullable',
                'kesimpulan' => 'nullable',
                'tanggal_kembali' => 'nullable',
                'nilai_hb' => 'nullable',
                'layanan_kb' => 'nullable',
                'jmlh_anak_laki' => 'nullable',
                'jmlh_anak_perempuan' => 'nullable',
                'status_kb' => 'nullable',
                'tgl_lahir_anak_bungsu' => 'nullable',
                'kb_terakhir' => 'nullable',
                'tgl_kb_terakhir' => 'nullable',
                'keadaan_umum' => 'nullable',
                'informed_concern' => 'nullable',
                'sakit_kuning' => 'nullable',
                'pendarahan_vagina' => 'nullable',
                'tumor' => 'nullable',
                'diabetes' => 'nullable',
                'pembekuan_darah' => 'nullable',
            ]);
            $validatedData['lingkar_lengan_atas'] = $validatedData['lingkar_lengan_atas'] ?? 0;
            $validatedData['usia_kehamilan'] = $validatedData['usia_kehamilan'] ?? 0;
            $validatedData['tinggi_fundus_uteri'] = $validatedData['tinggi_fundus_uteri'] ?? 0;
            $validatedData['denyut_jantung'] = $validatedData['denyut_jantung'] ?? 0;
            $validatedData['kaki_bengkak'] = $validatedData['kaki_bengkak'] ?? 0;
            $validatedData['imunisasi_tt'] = $validatedData['imunisasi_tt'] ?? 0;
            $validatedData['tablet_fe'] = $validatedData['tablet_fe'] ?? 0;
            $validatedData['proteinuria'] = $validatedData['proteinuria'] ?? 0;
            $validatedData['periksa_usg'] = $validatedData['periksa_usg'] ?? 0;
            // Update the action with the validated data
            // Update the action with the validated data
            $action->update($validated);
            if (Auth::user()->role == 'dokter') {
                if ($action->tipe === 'poli-umum') {
                    $route = 'action.dokter.index';
                } elseif ($action->tipe === 'poli-gigi') {
                    $route = 'action.dokter.gigi.index';
                } elseif ($action->tipe === 'poli-kia') {
                    $route = 'action.kia.dokter.index';
                } elseif ($action->tipe === 'poli-kb') {
                    $route = 'action.kb.dokter.index';
                } else {
                    $route = 'action.dokter.ugd.index';
                }
            } elseif (Auth::user()->role == 'lab') {
                if ($action->tipe === 'poli-umum') {
                    $route = 'action.lab.index';
                } elseif ($action->tipe === 'poli-gigi') {
                    $route = 'action.lab.gigi.index';
                } else {
                    $route = 'action.lab.ugd.index';
                }
            } else {
                if ($action->tipe === 'poli-umum') {
                    $route = 'action.index';
                } elseif ($action->tipe === 'poli-gigi') {
                    $route = 'action.index.gigi';
                } elseif ($action->tipe === 'poli-kia') {
                    $route = 'action.kia.index';
                } elseif ($action->tipe === 'poli-kb') {
                    $route = 'action.kb.index';
                } else {
                    $route = 'action.index.ugd';
                }
            }
            return redirect()->route($route)->with('success', 'Action has been successfully updated.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withErrors(['error' => 'An error occurred: ' . $e->getMessage()])
                ->withInput();
        }
    }
    public function updateDokter(Request $request, $id)
    {
        try {
            $action = Action::find($id);
            if (!$action) {
                return redirect()->back()->with('error', 'Action not found');
            }
            // Fetch the patient ID based on the provided NIK
            $patient = Patients::where('nik', $request->nik)->first();

            if (!$patient) {
                return redirect()
                    ->back()
                    ->withErrors(['nik' => 'Patient with the provided NIK does not exist.'])
                    ->withInput();
            }

            // Merge the request with the formatted tanggal and id_patient
            $request->merge([
                'id_patient' => $patient->id,
            ]);
            // dd($request->);
            // Validate the request
            $validated = $request->validate([
                'id_patient' => 'required',
                'tanggal' => 'required',
                'doctor' => 'required',
                'kunjungan' => 'nullable|string|max:255',
                'faskes' => 'nullable|string|max:255',
                'sistol' => 'nullable|numeric',
                'diastol' => 'nullable|numeric',
                'beratBadan' => 'nullable|numeric',
                'tinggiBadan' => 'nullable|numeric',
                'lingkarPinggang' => 'nullable|numeric',
                'gula' => 'nullable|numeric',
                'merokok' => 'nullable|string|max:255',
                'fisik' => 'nullable|string|max:255',
                'garam' => 'nullable|string|max:255',
                'gula_lebih' => 'nullable|string|max:255',
                'lemak' => 'nullable|string|max:255',
                'alkohol' => 'nullable|string|max:255',
                'hidup' => 'nullable|string|max:255',
                'buah_sayur' => 'nullable|string|max:255',
                'hasil_iva' => 'nullable|string|max:255',
                'tindak_iva' => 'nullable|string|max:255',
                'hasil_sadanis' => 'nullable|string|max:255',
                'tindak_sadanis' => 'nullable|string|max:255',
                'konseling' => 'nullable|string|max:255',
                'car' => 'nullable|string|max:255',
                'rujuk_ubm' => 'nullable|string|max:255',
                'kondisi' => 'nullable|string|max:255',
                'edukasi' => 'nullable|string|max:255',
                'keluhan' => 'nullable|string|max:255',
                'diagnosa' => 'nullable',
                'tindakan' => 'nullable',
                'rujuk_rs' => 'nullable|exists:hospitals,id',
                'keterangan' => 'nullable|string|max:255',
                'nadi' => 'nullable|numeric',
                'nafas' => 'nullable|numeric',
                'suhu' => 'nullable|numeric',
                'mata_anemia' => 'nullable|string|max:255',
                'pupil' => 'nullable|string|max:255',
                'ikterus' => 'nullable|string|max:255',
                'udem_palpebral' => 'nullable|string|max:255',
                'nyeri_tekan' => 'nullable|string|max:255',
                'peristaltik' => 'nullable|string|max:255',
                'ascites' => 'nullable|string|max:255',
                'lokasi_abdomen' => 'nullable|string|max:255',
                'thorax' => 'nullable|string|max:255',
                'thorax_bj' => 'nullable|string|max:255',
                'suara_nafas' => 'nullable|string|max:255',
                'ronchi' => 'nullable|string|max:255',
                'wheezing' => 'nullable|string|max:255',
                'ekstremitas' => 'nullable|string|max:255',
                'edema' => 'nullable|string|max:255',
                'tonsil' => 'nullable|string|max:255',
                'fharing' => 'nullable|string|max:255',
                'kelenjar' => 'nullable|string|max:255',
                'genetalia' => 'nullable|string|max:255',
                'warna_kulit' => 'nullable|string|max:255',
                'turgor' => 'nullable|string|max:255',
                'neurologis' => 'nullable|string|max:255',
                'hasil_lab' => 'nullable|string|max:255',
                'obat' => 'nullable',
                'riwayat_penyakit_sekarang' => 'nullable',
                'riwayat_penyakit_keluarga' => 'nullable',
                'riwayat_penyakit_dulu' => 'nullable',
                'riwayat_penyakit_lainnya' => 'nullable',
                'riwayat_penyakit_lainnya_keluarga' => 'nullable',
                'riwayat_pengobatan' => 'nullable',
                'riwayat_alergi' => 'nullable',
                'pemeriksaan_penunjang' => 'nullable',
                'usia_kehamilan' => 'nullable',
                'jenis_anc' => 'nullable',
                'nilai_hb' => 'nullable',
                'lingkar_lengan_atas' => 'nullable',
                'tinggi_fundus_uteri' => 'nullable',
                'presentasi_janin' => 'nullable',
                'denyut_jantung' => 'nullable',
                'kaki_bengkak' => 'nullable',
                'imunisasi_tt' => 'nullable',
                'tablet_fe' => 'nullable',
                'gravida' => 'nullable',
                'partus' => 'nullable',
                'abortus' => 'nullable',
                'proteinuria' => 'nullable',
                'hiv' => 'nullable',
                'sifilis' => 'nullable',
                'hepatitis' => 'nullable',
                'periksa_usg' => 'nullable',
                'hasil_usg' => 'nullable',
                'treatment_anc' => 'nullable',
                'kesimpulan' => 'nullable',
                'tanggal_kembali' => 'nullable',
                'layanan_kb' => 'nullable',
                'jmlh_anak_laki' => 'nullable',
                'jmlh_anak_perempuan' => 'nullable',
                'status_kb' => 'nullable',
                'tgl_lahir_anak_bungsu' => 'nullable',
                'kb_terakhir' => 'nullable',
                'tgl_kb_terakhir' => 'nullable',
                'keadaan_umum' => 'nullable',
                'informed_concern' => 'nullable',
                'sakit_kuning' => 'nullable',
                'pendarahan_vagina' => 'nullable',
                'tumor' => 'nullable',
                'diabetes' => 'nullable',
                'pembekuan_darah' => 'nullable',
            ]);

            $validated['lingkar_lengan_atas'] = $validated['lingkar_lengan_atas'] ?? 0;
            $validated['usia_kehamilan'] = $validated['usia_kehamilan'] ?? 0;
            $validated['tinggi_fundus_uteri'] = $validated['tinggi_fundus_uteri'] ?? 0;
            $validated['denyut_jantung'] = $validated['denyut_jantung'] ?? 0;
            $validated['kaki_bengkak'] = $validated['kaki_bengkak'] ?? 0;
            $validated['imunisasi_tt'] = $validated['imunisasi_tt'] ?? 0;
            $validated['tablet_fe'] = $validated['tablet_fe'] ?? 0;
            $validated['proteinuria'] = $validated['proteinuria'] ?? 0;
            $validated['periksa_usg'] = $validated['periksa_usg'] ?? 0;
            $action->update($validated);
            if ($action->tipe === 'poli-umum') {
                $route = 'action.dokter.index';
            } elseif ($action->tipe === 'poli-gigi') {
                $route = 'action.dokter.gigi.index';
            } elseif ($action->tipe === 'poli-kia') {
                $route = 'action.kia.dokter.index';
            } elseif ($action->tipe === 'poli-kb') {
                $route = 'action.kb.dokter.index';
            } else {
                $route = 'action.dokter.ugd.index';
            }

            return redirect()->route($route)->with('success', 'Action has been successfully updated.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withErrors(['error' => 'An error occurred: ' . $e->getMessage()])
                ->withInput();
        }
    }
    public function updateLab(Request $request, $id)
    {
        try {
            // Find the action record to be updated
            $action = Action::findOrFail($id);

            // Fetch the patient ID based on the provided NIK
            $patient = Patients::where('nik', $request->nik)->first();

            if (!$patient) {
                return redirect()
                    ->back()
                    ->withErrors(['nik' => 'Patient with the provided NIK does not exist.'])
                    ->withInput();
            }

            // Format the date and merge the patient ID into the request
            $request->merge([
                'id_patient' => $patient->id,
            ]);

            // dd($request->);
            // Validate the request
            $validated = $request->validate([
                'id_patient' => 'required',
                'hasil_lab' => 'nullable',
            ]);

            $action->update($validated);
            if ($action->tipe === 'poli-umum') {
                $route = 'action.lab.index';
            } elseif ($action->tipe === 'poli-gigi') {
                $route = 'action.lab.gigi.index';
            } elseif ($action->tipe === 'poli-kia') {
                $route = 'action.lab.kia.index';
            } elseif ($action->tipe === 'poli-kb') {
                $route = 'action.lab.kb.index';
            } else {
                $route = 'action.lab.ugd.index';
            }
            return redirect()->route($route)->with('success', 'Action has been successfully updated.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withErrors(['error' => 'An error occurred: ' . $e->getMessage()])
                ->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            $action = Action::findOrFail($id);

            $action->delete();

            if (Auth::user()->role == 'dokter') {
                if ($action->tipe === 'poli-umum') {
                    $route = 'action.dokter.index';
                } elseif ($action->tipe === 'poli-gigi') {
                    $route = 'action.dokter.gigi.index';
                } elseif ($action->tipe === 'poli-kia') {
                    $route = 'action.kia.dokter.index';
                } else {
                    $route = 'action.dokter.ugd.index';
                }
            } else {
                if ($action->tipe === 'poli-umum') {
                    $route = 'action.index';
                } elseif ($action->tipe === 'poli-gigi') {
                    $route = 'action.index.gigi';
                } else {
                    $route = 'action.index.ugd';
                }
            }

            return redirect()->route($route)->with('success', 'Data berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }
}
