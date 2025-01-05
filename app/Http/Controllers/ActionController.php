<?php

namespace App\Http\Controllers;

use App\Models\Action;
use App\Models\Diagnosis;
use App\Models\Disease;
use App\Models\Doctor;
use App\Models\Hospital;
use App\Models\Patients;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;

class ActionController extends Controller
{
    public function index(Request $request)
    {
        $response = Http::withHeaders([
            'API-KEY' => 'eeNzQPk2nZ/gvOCbkGZ6FDPAOMcDJlxY',
        ])->get('https://simpusdignityspace.cloud/api/master/docters');

        if ($response->successful()) {
            $dokter = $response->json()['data'];
        } else {
            $dokter = [];
        }

        $actions = Action::where('tipe', 'poli-umum')->get();
        $diagnosa = Diagnosis::where('tipe', 'poli-umum')->get();

        $penyakit = Disease::all();
        $rs = Hospital::all();

        $routeName = $request->route()->getName();

        return view('content.action.index', compact('actions', 'dokter', 'penyakit', 'rs', 'diagnosa', 'routeName'));
    }
    public function indexPoliGigi(Request $request)
    {
        $response = Http::withHeaders([
            'API-KEY' => 'eeNzQPk2nZ/gvOCbkGZ6FDPAOMcDJlxY',
        ])->get('https://simpusdignityspace.cloud/api/master/docters');

        if ($response->successful()) {
            $dokter = $response->json()['data'];
        } else {
            $dokter = [];
        }

        $actions = Action::where('tipe', 'poli-gigi')->get();
        $diagnosa = Diagnosis::where('tipe', 'poli-gigi')->get();

        $penyakit = Disease::all();
        $rs = Hospital::all();

        $routeName = $request->route()->getName();

        return view('content.action.index', compact('actions', 'dokter', 'penyakit', 'rs', 'diagnosa', 'routeName'));
    }
    public function indexUgd(Request $request)
    {
        $response = Http::withHeaders([
            'API-KEY' => 'eeNzQPk2nZ/gvOCbkGZ6FDPAOMcDJlxY',
        ])->get('https://simpusdignityspace.cloud/api/master/docters');

        if ($response->successful()) {
            $dokter = $response->json()['data'];
        } else {
            $dokter = [];
        }

        $actions = Action::where('tipe', 'ruang-tindakan')->get();
        $diagnosa = Diagnosis::where('tipe', 'ruang-tindakan')->get();

        $penyakit = Disease::all();
        $rs = Hospital::all();

        $routeName = $request->route()->getName();

        return view('content.action.index', compact('actions', 'dokter', 'penyakit', 'rs', 'diagnosa', 'routeName'));
    }
    public function indexDokter(Request $request)
    {
        $response = Http::withHeaders([
            'API-KEY' => 'eeNzQPk2nZ/gvOCbkGZ6FDPAOMcDJlxY',
        ])->get('https://simpusdignityspace.cloud/api/master/docters');

        if ($response->successful()) {
            $dokter = $response->json()['data'];
        } else {
            $dokter = [];
        }

        $actions = Action::where('tipe', 'poli-umum')->whereNotNull('diagnosa')->get();
        $diagnosa = Diagnosis::where('tipe', 'poli-umum')->get();

        $penyakit = Disease::all();
        $rs = Hospital::all();

        $routeName = $request->route()->getName();
        return view('content.action.index-dokter', compact('actions', 'dokter', 'penyakit', 'rs', 'diagnosa', 'routeName'));
    }
      public function indexGigiDokter(Request $request)
    {
        $response = Http::withHeaders([
            'API-KEY' => 'eeNzQPk2nZ/gvOCbkGZ6FDPAOMcDJlxY',
        ])->get('https://simpusdignityspace.cloud/api/master/docters');

        if ($response->successful()) {
            $dokter = $response->json()['data'];
        } else {
            $dokter = [];
        }

        $actions = Action::where('tipe', 'poli-gigi')->whereNotNull('diagnosa')->get();
        $diagnosa = Diagnosis::where('tipe', 'poli-gigi')->get();

        $penyakit = Disease::all();
        $rs = Hospital::all();

        $routeName = $request->route()->getName();
        return view('content.action.index-dokter', compact('actions', 'dokter', 'penyakit', 'rs', 'diagnosa', 'routeName'));
    }

public function indexUgdDokter(Request $request)
    {
        $response = Http::withHeaders([
            'API-KEY' => 'eeNzQPk2nZ/gvOCbkGZ6FDPAOMcDJlxY',
        ])->get('https://simpusdignityspace.cloud/api/master/docters');

        if ($response->successful()) {
            $dokter = $response->json()['data'];
        } else {
            $dokter = [];
        }

        $actions = Action::where('tipe', 'ruang-tindakan')->whereNotNull('diagnosa')->get();
        $diagnosa = Diagnosis::where('tipe', 'ruang-tindakan')->get();

        $penyakit = Disease::all();
        $rs = Hospital::all();

        $routeName = $request->route()->getName();
        return view('content.action.index-dokter', compact('actions', 'dokter', 'penyakit', 'rs', 'diagnosa', 'routeName'));
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
                'tanggal' => Carbon::createFromFormat('d-m-Y', $request->tanggal)->format('Y-m-d'),
                'id_patient' => $patient->id,
            ]);

            // Validate the request
            $validated = $request->validate([
                'id_patient' => 'required|exists:patients,id',
                'tanggal' => 'required|date',
                'tipe' => 'required',
                'doctor' => 'required',
                'kunjungan' => 'nullable|string|max:255',
                'kartu' => 'nullable|string|max:255',
                'nomor' => 'nullable|string|max:255',
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
                'riwayat_penyakit_keluarga' => 'nullable',
                'riwayat_penyakit_tidak_menular' => 'nullable',
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
                'paru' => 'nullable|string|max:255',
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
                'icd10' => 'nullable|string|max:255',
                'hasil_lab' => 'nullable|string|max:255',
                'hamil' => 'nullable|string|max:255',
            ]);

            // Save the validated data into the actions table
            $action = Action::create($validated);

            return redirect()->route('action.index')->with('success', 'Action has been successfully created.');
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
                'tanggal' => Carbon::createFromFormat('d-m-Y', $request->tanggal)->format('Y-m-d'),
                'id_patient' => $patient->id,
            ]);

            // Validate the request
            $validated = $request->validate([
                'id_patient' => 'required|exists:patients,id',
                'tanggal' => 'required|date',
                'doctor' => 'required',
                'kunjungan' => 'nullable|string|max:255',
                'kartu' => 'nullable|string|max:255',
                'nomor' => 'nullable|string|max:255',
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
                'riwayat_penyakit_keluarga' => 'nullable',
                'riwayat_penyakit_tidak_menular' => 'nullable',
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
                'paru' => 'nullable|string|max:255',
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
                'icd10' => 'nullable|string|max:255',
                'neurologis' => 'nullable|string|max:255',
                'hasil_lab' => 'nullable|string|max:255',
                'obat' => 'nullable',
            ]);

            // Update the action with the validated data
            $action->update($validated);
            if (Auth::user()->role == 'dokter') {
                return redirect()->route('action.dokter.index')->with('success', 'Action has been successfully updated.');
            } else {
                return redirect()->route('action.index')->with('success', 'Action has been successfully updated.');
            }
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
                'tanggal' => $request->tanggal,
                'id_patient' => $patient->id,
            ]);
            // dd($request->);
            // Validate the request
            $validated = $request->validate([
                'id_patient' => 'required',
                'tanggal' => 'required',
                'doctor' => 'required',
                'kunjungan' => 'nullable|string|max:255',
                'kartu' => 'nullable|string|max:255',
                'nomor' => 'nullable|string|max:255',
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
                'riwayat_penyakit_keluarga' => 'nullable',
                'riwayat_penyakit_tidak_menular' => 'nullable',
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
                'paru' => 'nullable|string|max:255',
                'icd10' => 'nullable|string|max:255',
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
            ]);

            // Update the action with the validated data
            // dd($validated);
            $action->update($validated);

            return redirect()->route('action.dokter.index')->with('success', 'Action has been successfully updated.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withErrors(['error' => 'An error occurred: ' . $e->getMessage()])
                ->withInput();
        }
    }

    public function destroy($id)
    {
        $action = Action::findOrFail($id);
        $action->delete();

        if (Auth::user()->role == 'dokter') {
            return redirect()->route('action.dokter.index')->with('success', 'Action has been successfully deleted.');
        } else {
            return redirect()->route('action.index')->with('success', 'Action has been successfully deleted.');
        }
    }
}
