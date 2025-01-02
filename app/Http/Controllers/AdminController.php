<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\GangguanAutis;
use App\Models\Anemia;
use App\Models\LayakHamil;
use App\Models\Hepatitis;
use App\Models\Hiv;
use App\Models\Kecacingan;
use App\Models\DiabetesMellitus;
use App\Models\Hipertensi;
use App\Models\Talasemia;
use App\Models\KekerasanAnak;
use App\Models\Tbc;
use App\Models\KekerasanPerempuan;
use App\Models\Patients;
use App\Models\TripleEliminasi;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator as FacadesValidator;

class AdminController extends Controller
{
    public function viewLayakHamil()
    {
        $layakHamil = LayakHamil::with('listPasien')->get();
        // dd($layakHamil);
        return view('kia.table.layak_hamil', compact('layakHamil'));
    }
    public function editLayakHamil($id)
    {
        $pasien = Patients::all();
        $layakHamil = LayakHamil::findOrFail($id);
        return view('kia.layak_hamil', compact('layakHamil', 'pasien'));
    }
    public function updateLayakHamil(Request $request, $id)
    {
        // Define validation rules
        $validator = FacadesValidator::make($request->all(), [
            'pasien' => 'required',
            // 'no_hp' => 'required|string|max:15',
            // 'nik' => 'required|string|max:16|unique:layak_hamil,nik,' . $id,
            'status' => 'required|string|max:50',
            'nama_suami' => 'required|string|max:255',
            // 'alamat' => 'required|string',
            'ingin_hamil' => 'required|boolean',
            // 'tanggal_lahir' => 'required|date',
            'umur' => 'required',
            'jumlah_anak' => 'required',
            'waktu_persalinan_terakhir' => 'required',
            'lingkar_lengan_atas' => 'required',
            'penyakit' => 'array',
            'penyakit_suami' => 'array',
            'kesehatan_jiwa' => 'array',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->with('error', 'There were validation errors.')->withInput();
        }

        // Find the record by ID
        $layakHamil = LayakHamil::find($id);

        if (!$layakHamil) {
            return redirect()->back()->with('error', 'Record not found.');
        }

        // Update the record with validated data
        $layakHamil->update(
            array_merge($validator->validated(), [
                'klaster' => 2,
                'poli' => 'kia',
            ]),
        );

        return redirect()->route('layakHamil.admin')->with('success', 'Data updated successfully');
    }
    public function deleteLayakHamil($id)
    {
        // Find the record by ID
        $layakHamil = LayakHamil::find($id);

        if (!$layakHamil) {
            return redirect()->route('layakHamil.admin')->with('error', 'Record not found.');
        }

        // Delete the record
        $layakHamil->delete();

        return redirect()->route('layakHamil.admin')->with('success', 'Data deleted successfully.');
    }
    public function viewHipertensi(Request $request)
    {
        $hipertensi = Hipertensi::with('listPasien')->where('poli', 'kia')->get();
        $routeName = $request->route()->getName();
        return view('kia.table.hipertensi', compact('hipertensi', 'routeName'));
    }
    public function editHipertensi(Request $request, $id)
    {
        $pasien = Patients::all();
        $hipertensi = Hipertensi::findOrFail($id);
        $routeName = $request->route()->getName();
        return view('kia.hipertensi', compact('hipertensi', 'pasien', 'routeName'));
    }
    public function updateHipertensi(Request $request, $id)
    {
        $hipertensi = Hipertensi::findOrFail($id);
        $validator = FacadesValidator::make($request->all(), [
            'pasien' => 'required',
            // 'nama' => 'required|string|max:255',
            // 'tanggal_lahir' => 'required',
            // 'jenis_kelamin' => 'required|string|max:10',
            // 'alamat' => 'required|string|max:255',
            'ortu_hipertensi' => 'required|boolean',
            'saudara_hipertensi' => 'required|boolean',
            'tubuh_gemuk' => 'required|boolean',
            'usia_50' => 'required|boolean',
            'merokok' => 'required|boolean',
            'makan_asin' => 'required|boolean',
            'makan_santan' => 'required|boolean',
            'makan_lemak' => 'required|boolean',
            'sakit_kepala' => 'required|boolean',
            'sakit_tenguk' => 'required|boolean',
            'tertekan' => 'required|boolean',
            'sulit_tidur' => 'required|boolean',
            'rutin_olahraga' => 'required|boolean',
            'makan_sayur' => 'required|boolean',
            'makan_buah' => 'required|boolean',
            // 'jmlh_rokok' =>'nullable'
        ]);

        // Check validation
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->with('error', 'Validation errors occurred.')->withInput();
        }

        // Update the data with validated inputs and set default values for 'klaster' and 'poli' if necessary
        $hipertensi->update(
            array_merge($validator->validated(), [
                'klaster' => $request->input('klaster', $hipertensi->klaster ?? 2), // Keep existing value or default to 2
                'poli' => $request->input('poli', $hipertensi->poli ?? 'kia'), // Keep existing value or default to 'kia'
            ]),
        );

        // Redirect with success message
        return redirect()->route('hipertensi.admin')->with('success', 'Data hipertensi berhasil diperbarui');
    }
    public function deleteHipertensi($id)
    {
        // Find the record by ID
        $hipertensi = Hipertensi::find($id);

        if (!$hipertensi) {
            return redirect()->route('hipertensi.admin')->with('error', 'Record not found.');
        }

        // Delete the record
        $hipertensi->delete();

        return redirect()->route('hipertensi.admin')->with('success', 'Data deleted successfully.');
    }
    public function viewGangguanAutis()
    {
        $gangguanAutis = GangguanAutis::with('listPasien')->get();
        return view('kia.table.gangguan_autis', compact('gangguanAutis'));
    }
    public function editGangguanAutis($id)
    {
        $gangguanAutis = GangguanAutis::findOrFail($id);
        $pasien = Patients::all();
        return view('kia.gangguan_autis', compact('gangguanAutis', 'pasien'));
    }
    public function deleteGangguanAutis($id)
    {
        // Find the record by ID
        $gangguanAutis = GangguanAutis::find($id);

        if (!$gangguanAutis) {
            return redirect()->route('gangguan.autis.admin')->with('error', 'Record not found.');
        }

        // Delete the record
        $gangguanAutis->delete();

        return redirect()->route('gangguan.autis.admin')->with('success', 'Data deleted successfully.');
    }
    public function updateGangguanAutis(Request $request, $id)
    {
        // Find the existing record
        $gangguanAutis = GangguanAutis::findOrFail($id);

        // Define validation rules
        $validator = FacadesValidator::make($request->all(), [
            'pasien' => 'required|string|max:255',
            'lihat_objek' => 'nullable|boolean',
            'tuli' => 'nullable|boolean',
            'main_pura_pura' => 'nullable|boolean',
            'suka_manjat' => 'nullable|boolean',
            'gerakan_jari' => 'nullable|boolean',
            'tunjuk_minta' => 'nullable|boolean',
            'tunjuk_menarik' => 'nullable|boolean',
            'tertarik_anak_lain' => 'nullable|boolean',
            'membawa_benda' => 'nullable|boolean',
            'respon_nama_dipanggil' => 'nullable|boolean',
            'respon_senyum' => 'nullable|boolean',
            'pernah_marah' => 'nullable|boolean',
            'bisa_jalan' => 'nullable|boolean',
            'menatap_mata' => 'nullable|boolean',
            'meniru' => 'nullable|boolean',
            'memutar_kepala' => 'nullable|boolean',
            'melihat' => 'nullable|boolean',
            'mengerti' => 'nullable|boolean',
            'menatap_wajah' => 'nullable|boolean',
            'suka_bergerak' => 'nullable|boolean',
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->with('error', 'There were validation errors.')->withInput();
        }

        // Update the GangguanAutis record
        $gangguanAutis->update(
            array_merge($validator->validated(), [
                'klaster' => 2,
                'poli' => 'kia',
            ]),
        );

        // Redirect with a success message
        return redirect()->route('gangguan.autis.admin')->with('success', 'Data Gangguan Autis updated successfully!');
    }
    public function viewAnemia(Request $request)
    {
        $anemia = Anemia::with('listPasien')->where('poli', 'kia')->get();
        $routeName = $request->route()->getName();
        return view('kia.table.anemia', compact('anemia', 'routeName'));
    }
    public function editAnemia(Request $request, $id)
    {
        $anemia = Anemia::findOrFail($id);
        $pasien = Patients::all();
        $routeName = $request->route()->getName();
        return view('kia.anemia', compact('anemia', 'pasien', 'routeName'));
    }
    public function deleteAnemia($id)
    {
        // Find the record by its ID and ensure it exists
        $anemia = Anemia::findOrFail($id);

        // Delete the record from the database
        $anemia->delete();

        // Redirect the user with a success message
        return redirect()->route('anemia.admin')->with('success', 'Data anemia berhasil dihapus.');
    }
    public function updateAnemia(Request $request, $id)
    {
        $anemia = Anemia::findOrFail($id);

        // Define validation rules
        // dd($request->all())
        $validator = FacadesValidator::make($request->all(), [
            'pasien' => 'required',
            'keluhan_5l' => 'required|boolean',
            'mudah_mengantuk' => 'required|boolean',
            'sulit_konsentrasi' => 'required|boolean',
            'sering_pusing' => 'required|boolean',
            'sakit_kepala' => 'required|boolean',
            'riwayat_talasemia' => 'required|string',
            'gaya_hidup' => 'required',
            'makan_lemak' => 'required|boolean',
            'kongjungtiva_pucat' => 'required|boolean',
            'pucat' => 'required|boolean',
            'kadar_hemoglobin' => 'required',
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator) // Sends validation error messages
                ->with('error', 'There were validation errors.') // Custom error message
                ->withInput(); // Retains input data for repopulating the form
        }

        // Update the existing Anemia record with validated data
        $anemia->update(
            array_merge(
                $validator->validated(), // Only uses validated data
                [
                    'klaster' => 2,
                    'poli' => 'kia',
                ],
            ),
        );

        // Redirect with a success message
        return redirect()->route('anemia.admin')->with('success', 'Data Anemia updated successfully!');
    }

    public function viewHepatitis()
    {
        $hepatitis = Hepatitis::with('listPasien')->get();
        return view('kia.table.hepatitis', compact('hepatitis'));
    }
    public function editHepatitis($id)
    {
        $hepatitis = Hepatitis::findOrFail($id);
        $pasien = Patients::all();
        return view('kia.hepatitis', compact('hepatitis', 'pasien'));
    }
    public function updateHepatitis(Request $request, $id)
    {
        // Define validation rules
        $validator = FacadesValidator::make($request->all(), [
            'pasien' => 'required',
            'sudah_periksa_hepatitis' => 'required|boolean',
            'keluhan' => 'required|array',
            'demam' => 'required|boolean',
            'dapat_transfusi_darah' => 'required|boolean',
            'sering_seks' => 'required|boolean',
            'narkoba' => 'required|boolean',
            'vaksin_hepatitis_b' => 'required|boolean',
            'keluarga_hepatitis' => 'required|boolean',
            'menderita_penyakit_menular' => 'required|boolean',
            'hasil_hiv' => 'required|string|max:255',
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->with('error', 'There were validation errors.')->withInput();
        }

        // Find the existing Hepatitis record by ID
        $hepatitis = Hepatitis::find($id);

        // Check if the record exists
        if (!$hepatitis) {
            return redirect()->route('hepatitis.view')->with('error', 'Hepatitis record not found.');
        }

        // Update the Hepatitis record with validated data and additional fields
        $hepatitis->update(
            array_merge(
                $validator->validated(), // Only uses validated data
                [
                    'klaster' => 2, // Adding or updating 'klaster' field
                    'poli' => 'kia', // Adding or updating 'poli' field
                ],
            ),
        );

        // Redirect with a success message
        return redirect()->route('hepatitis.admin')->with('success', 'Data Hepatitis updated successfully!');
    }
    public function deleteHepatitis($id)
    {
        // Temukan data hepatitis berdasarkan ID
        $hepatitis = Hepatitis::findOrFail($id);

        // Hapus data dari database
        $hepatitis->delete();

        // Redirect ke halaman sebelumnya atau halaman daftar dengan pesan sukses
        return redirect()->route('hepatitis.admin')->with('success', 'Data hepatitis berhasil dihapus.');
    }
    public function viewTalasemia(Request $request)
    {
        $talasemia = Talasemia::with('listPasien')->where('poli', 'kia')->get();
        $routeName = $request->route()->getName();
        return view('kia.table.talasemia', compact('talasemia', 'routeName'));
    }
    public function editTalasemia(Request $request, $id)
    {
        $talasemia = Talasemia::findOrFail($id);
        $pasien = Patients::all();
        $routeName = $request->route()->getName();
        return view('kia.talasemia', compact('talasemia', 'pasien', 'routeName'));
    }
    public function deleteTalasemia($id)
    {
        // Temukan data hepatitis berdasarkan ID
        $talasemia = Talasemia::findOrFail($id);

        // Hapus data dari database
        $talasemia->delete();

        // Redirect ke halaman sebelumnya atau halaman daftar dengan pesan sukses
        return redirect()->route('talasemia.admin')->with('success', 'Data talasemia berhasil dihapus.');
    }
    public function updateTalasemia(Request $request, $id)
    {
        // Define validation rules
        $validator = FacadesValidator::make($request->all(), [
            'pasien' => 'required',
            'terima_darah' => 'required|boolean',
            'saudara_talasemia' => 'required|boolean',
            'keluarga_transfusi' => 'required|boolean',
            'pubertas_telat' => 'required|boolean',
            'anemia' => 'required|boolean',
            'ikterus' => 'required|boolean',
            'faices_cooley' => 'required|boolean',
            'perut_buncit' => 'required|boolean',
            'gizi_buruk' => 'required|boolean',
            'tubuh_pendek' => 'required|boolean',
            'hiperpigmentasi_kulit' => 'required|boolean',
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->with('error', 'There were validation errors.')->withInput();
        }

        // Find the existing Talasemia record
        $talasemia = Talasemia::findOrFail($id);

        // Update the Talasemia record with validated data
        $talasemia->update(
            array_merge(
                $validator->validated(), // Only use validated data
                [
                    'klaster' => $talasemia->klaster ?? 2, // Preserve existing 'klaster' or default to 2
                    'poli' => $talasemia->poli ?? 'kia', // Preserve existing 'poli' or default to 'kia'
                ],
            ),
        );

        // Redirect with a success message
        return redirect()->route('talasemia.admin')->with('success', 'Data Talasemia updated successfully!');
    }
    public function viewHiv()
    {
        $hiv = Hiv::with('listPasien')->get();

        return view('kia.table.hiv', compact('hiv'));
    }
    public function editHiv($id)
    {
        $hiv = Hiv::findOrFail($id);
        $pasien = Patients::all();
        return view('kia.hiv', compact('hiv', 'pasien'));
    }
    public function deleteHiv($id)
    {
        // Temukan data hepatitis berdasarkan ID
        $hiv = Hiv::findOrFail($id);

        // Hapus data dari database
        $hiv->delete();

        // Redirect ke halaman sebelumnya atau halaman daftar dengan pesan sukses
        return redirect()->route('hiv.admin')->with('success', 'Data hiv berhasil dihapus.');
    }
    public function updateHiv(Request $request, $id)
    {
        // Find the Hiv record by ID
        $hiv = Hiv::findOrFail($id);

        // Define validation rules
        $validator = FacadesValidator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|string|max:10',
            'alamat' => 'required|string|max:500',
            'tes_hiv' => 'required|boolean',
            'tanggal_tes_terakhir' => '',
            'penurunan_berat' => 'required|boolean',
            'jumlah_berat_badan_turun' => 'nullable|numeric|min:0',
            'penyakit_kulit' => 'required|boolean',
            'gejala_ispa' => 'required|boolean',
            'gejala_sariawan' => 'required|boolean',
            'riwayat_sesak' => 'required|boolean',
            'riwayat_hepatitis' => 'required|boolean',
            'riwayat_seks_bebas' => 'required|boolean',
            'riwayat_narkoba' => 'required|boolean',
            'riwayat_penyakit_menular' => 'required|boolean',
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->with('error', 'There were validation errors.')->withInput();
        }
        // dd( $validator->validated());
        // Update the existing Hiv record with validated data
        $hiv->update(
            array_merge(
                $validator->validated(), // Only use validated data
                [
                    // Optional: you can leave klaster and poli out if you don't want to update them
                    'klaster' => $hiv->klaster, // Keep the existing klaster value
                    'poli' => $hiv->poli, // Keep the existing poli value
                ],
            ),
        );

        // Redirect with a success message
        return redirect()->route('hiv.admin')->with('success', 'Data HIV updated successfully!');
    }
    public function viewKecacingan(Request $request)
    {
        $kecacingan = Kecacingan::with('listPasien')->where('poli', 'kia')->get();
        $routeName = $request->route()->getName();
        return view('kia.table.kecacingan', compact('kecacingan', 'routeName'));
    }
    public function editKecacingan(Request $request, $id)
    {
        $pasien = Patients::all();
        $kecacingan = Kecacingan::findOrFail($id);
        $routeName = $request->route()->getName();
        return view('kia.kecacingan', compact('kecacingan', 'pasien', 'routeName'));
    }
    public function deleteKecacingan($id)
    {
        // Temukan data hepatitis berdasarkan ID
        $kecacingan = Kecacingan::findOrFail($id);

        // Hapus data dari database
        $kecacingan->delete();

        // Redirect ke halaman sebelumnya atau halaman daftar dengan pesan sukses
        return redirect()->route('kecacingan.admin')->with('success', 'Data kecacingan berhasil dihapus.');
    }
    public function updateKecacingan(Request $request, $id)
    {
        // Find the Kecacingan record by ID
        $kecacingan = Kecacingan::findOrFail($id);

        // Define validation rules
        $validator = FacadesValidator::make($request->all(), [
            'pasien' => 'required',
            'sakit_perut' => 'required|boolean',
            'diare' => 'required|boolean',
            'bab_darah' => 'required|boolean',
            'bab_cacing' => 'required|boolean',
            'nafsu_makan_turun' => 'required|boolean',
            'gatal' => 'required|boolean',
            'badan_lemah' => 'required|boolean',
            'kulit_pucat' => 'required|boolean',
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->with('error', 'There were validation errors.')->withInput();
        }

        // Update the existing Kecacingan record with validated data
        $kecacingan->update(
            array_merge(
                $validator->validated(), // Only uses validated data
                [
                    'klaster' => 2, // You can change this value if necessary
                    'poli' => 'kia', // You can change this value if necessary
                ],
            ),
        );

        // Redirect with a success message
        return redirect()->route('kecacingan.admin')->with('success', 'Data Kecacingan updated successfully!');
    }
    public function viewDiabetesMellitus(Request $request)
    {
        $diabetesMellitus = DiabetesMellitus::with('listPasien')->where('poli', 'kia')->get();
        $routeName = $request->route()->getName();
        return view('kia.table.diabetes_mellitus', compact('diabetesMellitus', 'routeName'));
    }
    public function editDiabetesMellitus(Request $request, $id)
    {
        $diabetesMellitus = DiabetesMellitus::findOrFail($id);
        $pasien = Patients::all();
        $routeName = $request->route()->getName();
        return view('kia.diabetes_mellitus', compact('diabetesMellitus', 'pasien', 'routeName'));
    }
    public function deleteDiabetesMellitus($id)
    {
        // Temukan data hepatitis berdasarkan ID
        $diabetesMellitus = DiabetesMellitus::findOrFail($id);

        // Hapus data dari database
        $diabetesMellitus->delete();

        // Redirect ke halaman sebelumnya atau halaman daftar dengan pesan sukses
        return redirect()->route('diabetes.mellitus.admin')->with('success', 'Data Diabetes Mellitus berhasil dihapus.');
    }
    public function updateDiabetesMellitus(Request $request, $id)
    {
        // Find the DiabetesMellitus record by ID
        $diabetesMellitus = DiabetesMellitus::findOrFail($id);

        // Define validation rules
        $validator = FacadesValidator::make($request->all(), [
            'pasien' => 'required',
            'tinggi_badan' => 'required|numeric',
            'berat_badan' => 'required|numeric',
            'lingkar_perut' => 'required|numeric',
            'hasil' => 'required',
            'tekanan_darah_sistol' => 'required|numeric',
            'tekanan_darah_diastol' => 'required|numeric',
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->with('error', 'There were validation errors.')->withInput();
        }

        // Update the existing DiabetesMellitus record with validated data
        $diabetesMellitus->update(
            array_merge(
                $validator->validated(), // Only uses validated data
                [
                    'klaster' => 2, // You can change this value if needed
                    'poli' => 'kia', // You can change this value if needed
                ],
            ),
        );

        // Redirect with a success message
        return redirect()->route('diabetes.mellitus.admin')->with('success', 'Data Diabetes Mellitus updated successfully!');
    }
    public function viewTbc(Request $request)
    {
        $tbc = Tbc::with('listPasien')->where('poli', 'kia')->get();
        $routeName = $request->route()->getName();
        return view('kia.table.tbc', compact('tbc', 'routeName'));
    }
    public function editTbc(Request $request, $id)
    {
        $pasien = Patients::all();
        $tbc = Tbc::findOrFail($id);
        $routeName = $request->route()->getName();
        return view('kia.tbc', compact('tbc', 'pasien', 'routeName'));
    }
    public function deleteTbc($id)
    {
        // Temukan data hepatitis berdasarkan ID
        $tbc = Tbc::findOrFail($id);

        // Hapus data dari database
        $tbc->delete();

        // Redirect ke halaman sebelumnya atau halaman daftar dengan pesan sukses
        return redirect()->route('tbc.admin')->with('success', 'Data TBC berhasil dihapus.');
    }
    public function updateTbc(Request $request, $id)
    {
        // Find the existing Tbc record by ID
        $tbc = Tbc::findOrFail($id);

        // Define validation rules
        $validator = FacadesValidator::make($request->all(), [
            'pasien' => 'required',
            'tempat_skrining' => 'required|string|max:255',
            // 'tanggal_lahir' => 'required|date',
            // 'alamat_domisili' => 'required|string|max:500',
            // 'alamat_ktp' => 'nullable|string|max:500',
            // 'nik' => 'required',
            // 'imt' => 'nullable',
            'usia' => 'nullable',
            // 'pekerjaan' => 'nullable|string|max:255',
            // 'jenis_kelamin' => 'required|string',
            // 'no_hp' => 'required',
            'tinggi_badan' => 'required|numeric',
            'berat_badan' => 'required|numeric',
            'status_gizi' => 'nullable',
            'kontak_dengan_pasien' => '',
            'kontak_tbc' => 'boolean',
            'jenis_tbc' => 'nullable|string|max:255',
            'pernah_berobat_tbc' => 'required|boolean',
            'kapan' => 'nullable|date',
            'pernah_berobat_tbc_tdk_tuntas' => 'required|boolean',
            'kurang_gizi' => 'required|boolean',
            'merokok' => 'required|boolean',
            'perokok_pasif' => 'required|boolean',
            'kencing_manis' => 'required',
            'odhiv' => '',
            'lansia' => 'required|boolean',
            'ibu_hamil' => 'required|boolean',
            'tinggal_wilayah_kumuh' => 'required|boolean',
            'batuk' => 'required|boolean',
            'durasi' => 'nullable|string|max:255',
            'batuk_darah' => 'required|boolean',
            'bb_turun' => 'required|boolean',
            'demam' => 'required|boolean',
            'lesu' => 'required|boolean',
            'pembesaran_kelenjar' => 'required',
            'sudah_rontgen' => 'required|boolean',
            'hasil_rontgen' => 'nullable|string|max:255',
            'terduga_tbc' => 'required|boolean',
            'periksa_tbc_laten' => 'required|boolean',
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->with('error', 'There were validation errors.')->withInput();
        }

        // Update the Tbc record with the validated data and additional fields
        $tbc->update(
            array_merge($validator->validated(), [
                'klaster' => 2, // Ensure klaster remains the same or update as needed
                'poli' => 'kia', // Ensure poli remains the same or update as needed
            ]),
        );

        // Redirect with success message
        return redirect()->route('tbc.admin')->with('success', 'Data TBC updated successfully!');
    }

    public function viewKekerasanPerempuan(Request $request)
    {
        $kekerasanPerempuan = KekerasanPerempuan::with('listPasien')->where('poli', 'kia')->get();
        $routeName = $request->route()->getName();
        return view('kia.table.kekerasan_perempuan', compact('kekerasanPerempuan', 'routeName'));
    }
    public function editKekerasanPerempuan(Request $request, $id)
    {
        $pasien = Patients::all();
        $kekerasanPerempuan = KekerasanPerempuan::findOrFail($id);
        $routeName = $request->route()->getName();
        return view('kia.kekerasan_perempuan', compact('kekerasanPerempuan', 'routeName', 'pasien'));
    }
    public function deleteKekerasanPerempuan($id)
    {
        // Temukan data hepatitis berdasarkan ID
        $kekerasanPerempuan = KekerasanPerempuan::findOrFail($id);

        // Hapus data dari database
        $kekerasanPerempuan->delete();

        // Redirect ke halaman sebelumnya atau halaman daftar dengan pesan sukses
        return redirect()->route('kekerasan.perempuan.admin')->with('success', 'Data Kekerasan Perempuan berhasil dihapus.');
    }
    public function updateKekerasanPerempuan(Request $request, $id)
    {
        // Define validation rules
        $validator = FacadesValidator::make($request->all(), [
            'no_responden' => 'required|string|max:50',
            'umur' => 'required|integer|min:1',
            'tempat_wawancara' => 'required|string|max:255',
            'hubungan_dengan_pasangan' => 'required|string|max:255',
            'mengatasi_pertengkaran_mulur' => 'required|string|max:500',
            'akibat_pertengkaran_mulut' => 'nullable',
            'pasangan_memukul' => 'required',
            'ketakutan' => 'nullable',
            'dibatasi' => 'nullable',
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->with('error', 'There were validation errors.')->withInput();
        }

        // Find the existing record by ID
        $kekerasanPerempuan = KekerasanPerempuan::findOrFail($id);

        // Update the record with validated data and additional fields
        $kekerasanPerempuan->update(
            array_merge($validator->validated(), [
                'klaster' => 2, // Assign or update the default value for klaster
                'poli' => 'kia', // Assign or update the default value for poli
            ]),
        );

        // Redirect with success message
        return redirect()->route('kekerasan.perempuan.admin')->with('success', 'Data Kekerasan Perempuan updated successfully!');
    }

    public function viewKekerasanAnak()
    {
        $kekerasanAnak = KekerasanAnak::with('listPasien')->get();
        return view('kia.table.kekerasan_anak', compact('kekerasanAnak'));
    }
    public function editKekerasanAnak($id)
    {
        $kekerasanAnak = KekerasanAnak::findOrFail($id);
        $pasien = Patients::all();
        return view('kia.kekerasan_anak', compact('kekerasanAnak', 'pasien'));
    }
    public function deleteKekerasanAnak($id)
    {
        // Temukan data hepatitis berdasarkan ID
        $kekerasanAnak = KekerasanAnak::findOrFail($id);

        // Hapus data dari database
        $kekerasanAnak->delete();

        // Redirect ke halaman sebelumnya atau halaman daftar dengan pesan sukses
        return redirect()->route('kekerasan.eliminasi.admin')->with('success', 'Data Kekerasan Anak berhasil dihapus.');
    }

    public function updateKekerasanAnak(Request $request, $id)
    {
        // Find the record to update
        $kekerasanAnak = KekerasanAnak::findOrFail($id);

        // Define validation rules
        $validator = FacadesValidator::make($request->all(), [
            'pasien' => 'required',
            'diperoleh_dari' => 'required|string|max:255',
            'hubungan_pasien' => 'required',
            'kekerasan' => 'required',
            'tempat' => 'nullable',
            'dampak_pasien' => 'nullable',
            'dampak_pada_anak' => 'nullable',
            'penelantaran_fisik' => 'required',
            'tanda_kekerasan_check' => 'nullable',
            'derajat_luka_bakar' => 'nullable',
            'tanda_kekerasan' => 'nullable',
            'kekerasan_seksual' => 'required',
            'dampak_kekerasan' => 'nullable',
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->with('error', 'There were validation errors.')->withInput();
        }

        // Update the record with validated data and additional fields
        $kekerasanAnak->update(
            array_merge($validator->validated(), [
                'klaster' => 2, // Default value for klaster
                'poli' => 'kia', // Default value for poli
            ]),
        );

        // Redirect with success message
        return redirect()->route('kekerasan.anak.admin')->with('success', 'Data Kekerasan Anak updated successfully!');
    }
    public function viewTripleEliminasi()
    {
        $triple = TripleEliminasi::all();

        return view('kia.table.triple_eliminasi', compact('triple'));
    }
    public function editTripleEliminasi($id)
    {
        $triple = TripleEliminasi::findOrFail($id);
        $pasien = Patients::all();
        return view('kia.triple_eliminasi', compact('triple', 'pasien'));
    }
    public function deleteTripleEliminasi($id)
    {
        // Temukan data hepatitis berdasarkan ID
        $triple = TripleEliminasi::findOrFail($id);

        // Hapus data dari database
        $triple->delete();

        // Redirect ke halaman sebelumnya atau halaman daftar dengan pesan sukses
        return redirect()->route('triple.eliminasi.admin')->with('success', 'Data Triple Eliminasi berhasil dihapus.');
    }
    public function updateTripleEliminasi(Request $request, $id)
    {
        // Define validation rules
        $validator = FacadesValidator::make($request->all(), [
            'pasien' => 'required',
            // 'tempat_lahir' => 'nullable|string|max:255',
            // 'tanggal_lahir' => 'nullable|date',
            'pekerjaan' => 'nullable|string|max:255',
            'status_kawin' => 'nullable|string|max:255',
            'gravida' => 'nullable|integer',
            'partus' => 'nullable|integer',
            'abortus' => 'nullable|integer',
            'umur_kehamilan' => 'nullable|integer',
            'taksiran_kehamilan' => 'nullable',
            'nama_puskesmas' => 'nullable',
            'kode_specimen' => 'nullable',
            // 'no_hp' => 'nullable|string|max:15',
            'umur_ibu' => 'nullable|integer',
            // 'alamat' => 'nullable|string',
            'pendidikan' => 'nullable',
            'gejala_hepatitis' => 'nullable|boolean',
            'gejala_urine_gelap' => 'nullable|boolean',
            'gejala_kuning' => 'nullable|boolean',
            'gejala_lainnya' => 'nullable',
            'test_hepatitis' => 'nullable|boolean',
            'lokasi_tes' => 'nullable',
            'tanggal_tes' => 'nullable|date',
            'anti_hbs' => 'nullable',
            'anti_hbc' => 'nullable',
            'sgpt' => 'nullable',
            'anti_hbe' => 'nullable',
            'hbeag' => 'nullable',
            'hbv_dna' => 'nullable',
            'transfusi_darah' => 'nullable|boolean',
            'kapan_transfusi' => 'nullable|date',
            'hemodialisa' => 'nullable|boolean',
            'kapan_hemodialisa' => 'nullable|date',
            'jmlh_pasangan_seks' => 'nullable|integer',
            'narkoba' => 'nullable|boolean',
            'kapan_narkoba' => 'nullable|date',
            'vaksin' => 'nullable|boolean',
            'kapan_vaksin' => 'nullable|date',
            'jmlh_vaksin' => 'nullable|integer',
            'tinggal_serumah' => 'nullable|boolean',
            'kapan_tinggal_serumah' => 'nullable|date',
            'hubungan_hepatitis' => 'nullable',
            'hubungan_detail' => 'nullable',
            'test_hiv' => 'nullable|boolean',
            'hasil_hiv' => 'nullable',
            'cd4_check' => 'nullable|boolean',
            'dimana_cd4' => 'nullable',
            'hasil_cd4' => 'nullable',
            'arv_check' => 'nullable|boolean',
            'kapan_arv' => 'nullable',
            'gejala_pms' => 'nullable|boolean',
            'kapan_pms' => 'nullable',
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->with('error', 'There were validation errors.')->withInput();
        }

        // Find the existing record
        $tripleEliminasi = TripleEliminasi::find($id);

        if (!$tripleEliminasi) {
            return redirect()->route('triple.eliminasi.view')->with('error', 'Data not found.');
        }

        // Update the record
        $tripleEliminasi->update(
            array_merge($validator->validated(), [
                'klaster' => 2, // Ensure that the klaster value is updated as required
                'poli' => 'kia', // Ensure that the poli value is updated as required
            ]),
        );

        // Redirect with success message
        return redirect()->route('triple.eliminasi.admin')->with('success', 'Data Triple Eliminasi updated successfully!');
    }
}
