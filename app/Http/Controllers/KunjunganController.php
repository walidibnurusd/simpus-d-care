<?php

namespace App\Http\Controllers;

use App\Models\Action;
use App\Models\Diagnosis;
use App\Models\Disease;
use App\Models\Doctor;
use App\Models\User;
use App\Models\Hospital;
use App\Models\Patients;
use App\Models\Kunjungan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class KunjunganController extends Controller
{
    public function index(Request $request)
    {
        // Get the filtering dates from the request
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $kunjungan = Kunjungan::with('patient');

        if ($startDate) {
            $kunjungan->whereDate('tanggal', '>=', $startDate);
        }

        if ($endDate) {
            $kunjungan->whereDate('tanggal', '<=', $endDate);
        }

        $kunjungan = $kunjungan->get();
        // Return the view with the data
        return view('content.kunjungan.index', compact('kunjungan'));
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
            ]);

            // Update the action with the validated data
            $action->update($validated);
            if (Auth::user()->role == 'dokter') {
                if ($action->tipe === 'poli-umum') {
                    $route = 'action.dokter.index';
                } elseif ($action->tipe === 'poli-gigi') {
                    $route = 'action.dokter.gigi.index';
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
            ]);

            // Update the action with the validated data
            // dd($validated);
            $action->update($validated);
            if ($action->tipe === 'poli-umum') {
                $route = 'action.dokter.index';
            } elseif ($action->tipe === 'poli-gigi') {
                $route = 'action.dokter.gigi.index';
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
