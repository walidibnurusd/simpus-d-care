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

class PatientsController extends Controller
{
    public function getPatients(Request $request)
    {
        // Ambil parameter pagination dari DataTables
        $start = $request->input('start', 0);
        $length = $request->input('length', 10);
        $draw = $request->input('draw', 1);
        $searchValue = $request->input('search.value', '');
    
        // Hitung halaman berdasarkan DataTables `start` dan `length`
        $page = ($start / $length) + 1;
    
        // Query dengan relasi dan filter pencarian
        $query = Patients::with('genderName', 'educations', 'occupations');
    
        if (!empty($searchValue)) {
            $query->where('name', 'LIKE', "%{$searchValue}%")
                ->orWhere('address', 'LIKE', "%{$searchValue}%")
                ->orWhereHas('genderName', function ($q) use ($searchValue) {
                    $q->where('gender', 'LIKE', "%{$searchValue}%");
                });
        }
    
        // Ambil data dengan pagination
        $patients = $query->paginate($length, ['*'], 'page', $page);
    
        // Format data untuk DataTables
        return response()->json([
            'draw' => (int) $draw,
            'recordsTotal' => $patients->total(),
            'recordsFiltered' => $patients->total(),
            'data' => $patients->items(), // Data pasien
        ]);
    }
    
    public function getSkriningPatient(Request $request, $id)
    {
        // Ambil data pasien berdasarkan ID
        $patient = Patients::findOrFail($id);

        if (!$patient) {
            return response()->json(['error' => 'Patient not found'], 404);
        }

        $klaster = $patient->klaster;

        $skriningData = [];

        switch ($klaster) {
            case 2:
                $skrining = [
                    'Hipertensi' => Hipertensi::where('pasien', $id)->where('klaster', 2)->first(),
                    'Gangguan Spektrum Autisme' => GangguanAutis::where('pasien', $id)->where('klaster', 2)->first(),
                    'Kecacingan' => Kecacingan::where('pasien', $id)->where('klaster', 2)->first(),
                    'HIV & IMS' => Hiv::where('pasien', $id)->where('klaster', 2)->first(),
                    'Anemia' => Anemia::where('pasien', $id)->where('klaster', 2)->first(),
                    'Talasemia' => Talasemia::where('pasien', $id)->where('klaster', 2)->first(),
                    'Hepatitis' => Hepatitis::where('pasien', $id)->where('klaster', 2)->first(),
                    'Kekerasan terhadap Anak' => KekerasanAnak::where('pasien', $id)->where('klaster', 2)->first(),
                    'Kekerasan terhadap Perempuan' => KekerasanPerempuan::where('pasien', $id)->where('klaster', 2)->first(),
                    'Diabetes Mellitus' => DiabetesMellitus::where('pasien', $id)->where('klaster', 2)->first(),
                    'TBC' => Tbc::where('pasien', $id)->where('klaster', 2)->first(),
                    'Triple Eliminasi Bumil' => TripleEliminasi::where('pasien', $id)->where('klaster', 2)->first(),
                    'Tes Pendengaran' => TesDayaDengar::where('pasien', $id)->where('klaster', 2)->first(),
                    'SDQ (4-11 Tahun)' => GangguanJiwaAnak::where('pasien', $id)->where('klaster', 2)->first(),
                    'SDQ (11-18 Tahun)' => GangguanJiwaRemaja::where('pasien', $id)->where('klaster', 2)->first(),
                    'Kekerasan terhadap Anak' => KekerasanAnak::where('pasien', $id)->where('klaster', 2)->first(),
                    'Kekerasan terhadap Perempuan' => KekerasanPerempuan::where('pasien', $id)->where('klaster', 2)->first(),
                    'Obesitas' => Obesitas::where('pasien', $id)->where('klaster', 2)->first(),
                    'NAPZA' => Napza::where('pasien', $id)->where('klaster', 2)->first(),
                    'Perilaku Merokok bagi Anak Sekolah' => Merokok::where('pasien', $id)->where('klaster', 2)->first(),
                ];
                break;

            case 3:
                $skrining = [
                    'Kanker Paru' => KankerParu::where('pasien', $id)->where('klaster', 3)->first(),
                    'Kanker Kolorektal' => KankerKolorektal::where('pasien', $id)->where('klaster', 3)->first(),
                    'PPOK (PUMA)' => Puma::where('pasien', $id)->where('klaster', 3)->first(),
                    'Geriatri' => Geriatri::where('pasien', $id)->where('klaster', 3)->first(),
                    'Kanker Leher Rahim dan Kanker Payudara' => KankerPayudara::where('pasien', $id)->where('klaster', 3)->first(),
                    'Hipertensi' => Hipertensi::where('pasien', $id)->get(),
                    'TBC' => Tbc::where('pasien', $id)->where('klaster', 3)->first(),
                    'Layak Hamil' => LayakHamil::where('pasien', $id)->where('klaster', 3)->first(),
                    'Anemia' => Anemia::where('pasien', $id)->where('klaster', 3)->first(),
                    'Talasemia' => Talasemia::where('pasien', $id)->where('klaster', 3)->first(),
                ];
                break;

            default:
                $skrining = [];
                break;
        }

        foreach ($skrining as $jenis => $data) {
            $skriningData[] = [
                'jenis_skrining' => $jenis,
                'kesimpulan_skrining' => $data ? 'Tersedia' : 'Belum Tersedia',
                'status_skrining' => $data ? 'Selesai' : 'Belum Selesai',
            ];
        }
        
        // Ambil parameter pencarian dari DataTables
        $searchValue = $request->input('search.value', '');
        
        // Jika ada parameter pencarian, filter data
        if (!empty($searchValue)) {
            $skriningData = array_filter($skriningData, function ($row) use ($searchValue) {
                return stripos($row['jenis_skrining'], $searchValue) !== false ||
                       stripos($row['kesimpulan_skrining'], $searchValue) !== false ||
                       stripos($row['status_skrining'], $searchValue) !== false;
            });
        }
        
        // DataTables pagination parameters
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

    public function getPatientsDokter(Request $request)
    {
        // Ambil parameter DataTables
        $start = $request->input('start', 0);
        $length = $request->input('length', 10);
        $draw = $request->input('draw', 1);
        $searchValue = $request->input('search.value', '');
    
        // Hitung halaman berdasarkan DataTables `start` dan `length`
        $page = ($start / $length) + 1;
    
        // Query data Action yang dibuat hari ini dengan relasi
        $query = Action::with('patient.genderName', 'patient.educations', 'patient.occupations')
            ->whereDate('tanggal', Carbon::today());
    
        // Filter pencarian jika ada nilai pencarian
        if (!empty($searchValue)) {
            $query->whereHas('patient', function ($q) use ($searchValue) {
                $q->where('name', 'LIKE', "%{$searchValue}%")
                    ->orWhere('address', 'LIKE', "%{$searchValue}%")
                    ->orWhereHas('genderName', function ($q2) use ($searchValue) {
                        $q2->where('gender', 'LIKE', "%{$searchValue}%");
                    })
                    ->orWhereHas('educations', function ($q2) use ($searchValue) {
                        $q2->where('education_name', 'LIKE', "%{$searchValue}%");
                    })
                    ->orWhereHas('occupations', function ($q2) use ($searchValue) {
                        $q2->where('occupation_name', 'LIKE', "%{$searchValue}%");
                    });
            });
        }
    
        // Ambil data dengan pagination
        $patients = $query->paginate($length, ['*'], 'page', $page);
    
        // Format data untuk DataTables
        return response()->json([
            'draw' => (int) $draw,
            'recordsTotal' => $patients->total(),
            'recordsFiltered' => $patients->total(),
            'data' => $patients->items(), // Data pasien yang dipaginasikan
        ]);
    }
    

    public function index()
    {
        $patients = Patients::all();
        return view('content.patients.index', compact('patients'));
    }
    public function store(Request $request)
    {
        try {
            // Validate the request data
            $validatedData = $request->validate([
                'nik' => 'required|string|max:16',
                'name' => 'required|string|max:255',
                'phone' => 'required|string|max:15',
                'gender' => 'required|integer',
                'place_birth' => 'required|string|max:255',
                'dob' => 'required|date',
                'no_rm' => 'required|string|max:255',
                'marriage_status' => 'required|integer',
                'blood_type' => 'required|string',
                'education' => 'required|integer',
                'occupation' => 'required|integer',
                'province' => 'required|integer',
                'city' => 'required|integer',
                'district' => 'required',
                'village' => 'nullable',
                'rw' => 'nullable',
                'address' => 'required|string|max:255',
                'jenis_kartu' => 'required|string|max:255',
                'nomor_kartu' => 'required|string|max:255',
            ]);

            // Create a new patient record
            $patient = new Patients();
            $patient->nik = $validatedData['nik'];
            $patient->name = $validatedData['name'];
            $patient->phone = $validatedData['phone'];
            $patient->gender = $validatedData['gender'];
            $patient->place_birth = $validatedData['place_birth'];
            $patient->dob = $validatedData['dob'];
            $patient->no_rm = $validatedData['no_rm'];
            $patient->marrital_status = $validatedData['marriage_status'];
            $patient->blood_type = $validatedData['blood_type'];
            $patient->education = $validatedData['education'];
            $patient->occupation = $validatedData['occupation'];
            $patient->indonesia_province_id = $validatedData['province'];
            $patient->indonesia_city_id = $validatedData['city'];
            $patient->indonesia_district = $validatedData['district'];
            $patient->indonesia_village = $validatedData['village'] ?? null;
            $patient->rw = $validatedData['rw'] ?? null;
            $patient->address = $validatedData['address'];
            $patient->jenis_kartu = $validatedData['jenis_kartu'];
            $patient->nomor_kartu = $validatedData['nomor_kartu'];
            // dd($patient);
            $patient->save();

            // Redirect back with a success message
            return redirect()->back()->with('success', 'Patient data added successfully.');
        } catch (Exception $e) {
            // Log the error
            Log::error('Error adding patient: ' . $e->getMessage());

            // Redirect back with an error message
            return redirect()->back()->withErrors('An error occurred while adding the patient. Please try again.');
        }
    }

    public function update(Request $request, $id)
    {
        try {
            // Validate the request data
            $validatedData = $request->validate([
                'nik' => 'required|string|max:16',
                'name' => 'required|string|max:255',
                'phone' => 'required|string|max:15',
                'gender' => 'required|integer',
                'place_birth' => 'required|string|max:255',
                'dob' => 'required|date',
                'no_rm' => 'required|string|max:255',
                'marriage_status' => 'required|integer',
                'blood_type' => 'required|string',
                'education' => 'required|integer',
                'occupation' => 'required|integer',
                'province' => 'required|integer',
                'city' => 'required|integer',
                'district' => 'required',
                'village' => 'nullable',
                'rw' => 'nullable',
                'address' => 'required|string|max:255',
                'jenis_kartu' => 'required|string|max:255',
                'nomor_kartu' => 'required|string|max:255',
            ]);

            // Find the patient record by ID
            $patient = Patients::findOrFail($id);

            // Update the patient record with validated data
            $patient->nik = $validatedData['nik'];
            $patient->name = $validatedData['name'];
            $patient->phone = $validatedData['phone'];
            $patient->gender = $validatedData['gender'];
            $patient->place_birth = $validatedData['place_birth'];
            $patient->dob = $validatedData['dob'];
            $patient->no_rm = $validatedData['no_rm'];
            $patient->marrital_status = $validatedData['marriage_status'];
            $patient->blood_type = $validatedData['blood_type'];
            $patient->education = $validatedData['education'];
            $patient->occupation = $validatedData['occupation'];
            $patient->indonesia_province_id = $validatedData['province'];
            $patient->indonesia_city_id = $validatedData['city'];
            $patient->indonesia_district = $validatedData['district'];
            $patient->indonesia_village = $validatedData['village'] ?? null;
            $patient->rw = $validatedData['rw'] ?? null;
            $patient->address = $validatedData['address'];
            $patient->jenis_kartu = $validatedData['jenis_kartu'];
            $patient->nomor_kartu = $validatedData['nomor_kartu'];

            // Save the updated patient record
            $patient->save();

            // Redirect back with a success message
            return redirect()->back()->with('success', 'Patient data updated successfully.');
        } catch (Exception $e) {
            // Log the error
            Log::error('Error updating patient: ' . $e->getMessage());

            // Redirect back with an error message
            return redirect()->back()->withErrors('An error occurred while updating the patient. Please try again.');
        }
    }

    // PatientController.php
    public function destroy($id)
    {
        // Find the patient by ID or fail
        $patient = Patients::findOrFail($id);

        // Delete the patient
        $patient->delete();

        // Redirect with a success message
        return redirect()->route('patient.index')->with('success', 'Patient deleted successfully.');
    }
    public function patientReport()
    {
        $patients = Patients::all(); // Ganti dengan query sesuai kebutuhan
        return view('content.patients.print', compact('patients'));
    }
}
