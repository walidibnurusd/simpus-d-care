<?php

namespace App\Http\Controllers;

use App\Models\GangguanAutis;
use App\Models\LayakHamil;
use App\Models\Anemia;
use App\Models\Hipertensi;
use App\Models\Hepatitis;
use App\Models\Kecacingan;
use App\Models\Hiv;
use App\Models\KekerasanAnak;
use App\Models\KekerasanPerempuan;
use App\Models\DiabetesMellitus;
use App\Models\Patients;
use App\Models\Tbc;
use App\Models\Talasemia;
use App\Models\Preeklampsia;
use App\Models\TripleEliminasi;
use App\Models\GangguanJiwaDewasa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class KiaController extends Controller
{
    public function showLayakHamil()
    {
        $pasien = Patients::all();
        return view('kia.layak_hamil', compact('pasien'));
    }
    public function storeLayakHamil(Request $request)
    {
        // Define validation rules
        $validator = Validator::make($request->all(), [
            'pasien' => 'required',
            // 'no_hp' => 'required|string|max:15',
            // 'nik' => 'required|string|max:16|unique:layak_hamil,nik',
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
            'kesimpulan' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->with('error', 'There were validation errors.')->withInput();
        }

        // Store the data using validated inputs and default values
        LayakHamil::create(
            array_merge($validator->validated(), [
                'klaster' => 3,
                'poli' => 'lansia',
            ]),
        );
        return redirect()->back()->with('success', 'Data saved successfully');
    }

    public function showHipertensi(Request $request, $id)
    {
        $pasien = Patients::find($id);
        $routeName = $request->route()->getName();

        if (!$pasien) {
            return redirect()
                ->back()
                ->withErrors(['error' => 'Pasien tidak ditemukan.']);
        }

        return view('kia.hipertensi', compact('pasien', 'routeName'));
    }

    public function storeHipertensi(Request $request)
    {
        // Define validation rules
        $validator = Validator::make($request->all(), [
            'pasien' => 'required',
            'ortu_hipertensi' => 'nullable|boolean',
            'saudara_hipertensi' => 'nullable|boolean',
            'tubuh_gemuk' => 'nullable|boolean',
            'usia_50' => 'nullable|boolean',
            'merokok' => 'nullable|boolean',
            'makan_asin' => 'nullable|boolean',
            'makan_santan' => 'nullable|boolean',
            'makan_lemak' => 'nullable|boolean',
            'sakit_kepala' => 'nullable|boolean',
            'sakit_tenguk' => 'nullable|boolean',
            'tertekan' => 'nullable|boolean',
            'sulit_tidur' => 'nullable|boolean',
            'rutin_olahraga' => 'nullable|boolean',
            'makan_sayur' => 'nullable|boolean',
            'makan_buah' => 'nullable|boolean',
            'kesimpulan' => 'nullable',
            'jmlh_rokok' => 'nullable',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->with('error', 'Validation errors occurred.')->withInput();
        }

        // Store data with default values for 'klaster' and 'poli' if not provided
        $hipertensi = Hipertensi::create(
            array_merge($validator->validated(), [
                'klaster' => $request->klaster,
                'poli' => $request->poli,
            ]),
        );

        // Return response
        return redirect()->back()->with('success', 'Data hipertensi berhasil disimpan');
    }

    public function showPreeklampsia(Request $request, $id)
    {
        $pasien = Patients::find($id);
        $routeName = $request->route()->getName();

        if (!$pasien) {
            return redirect()
                ->back()
                ->withErrors(['error' => 'Pasien tidak ditemukan.']);
        }

        return view('kia.preeklampsia', compact('pasien', 'routeName'));
    }

    public function storePreeklampsia(Request $request)
    {
        // Define validation rules
        $validator = Validator::make($request->all(), [
            'pasien' => 'required',
            'multipara' => 'nullable|boolean',
            'teknologi_hamil' => 'nullable|boolean',
            'umur35' => 'nullable|boolean',
            'nulipara' => 'nullable|boolean',
            'multipara10' => 'nullable|boolean',
            'riwayat_preeklampsia' => 'nullable|boolean',
            'obesitas' => 'nullable|boolean',
            'multipara_sebelumnya' => 'nullable|boolean',
            'hamil_multipel' => 'nullable|boolean',
            'diabetes' => 'nullable|boolean',
            'hipertensi' => 'nullable|boolean',
            'ginjal' => 'nullable|boolean',
            'autoimun' => 'nullable|boolean',
            'phospholipid' => 'nullable|boolean',
            'arterial' => 'nullable|boolean',
            'kesimpulan' => 'nullable',
            'proteinura' => 'nullable',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->with('error', 'Validation errors occurred.')->withInput();
        }

        // Store data with default values for 'klaster' and 'poli' if not provided
        $preeklampsia = Preeklampsia::create(
            array_merge($validator->validated(), [
                'klaster' => 2,
                'poli' => 'kia',
            ]),
        );

        // Return response
        return redirect()->back()->with('success', 'Data preeklampsia berhasil disimpan');
    }

    public function showGangguanAutis($id)
    {
        $pasien = Patients::find($id);
        return view('kia.gangguan_autis', compact('pasien'));
    }
    public function storeGangguanAutis(Request $request)
    {
        // Define validation rules
        $validator = Validator::make($request->all(), [
            'pasien' => 'required',
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
            'kesimpulan' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->with('error', 'There were validation errors.')->withInput();
        }

        // Create and store the new GangguanAutis record
        $gangguanAutis = GangguanAutis::create(
            array_merge($validator->validated(), [
                'klaster' => 2,
                'poli' => 'kia',
            ]),
        );

        // Redirect with a success message
        return redirect()->back()->with('success', 'Data Gangguan Autis created successfully!');
    }
    public function showKecacingan(Request $request, $id)
    {
        $pasien = Patients::find($id);
        $routeName = $request->route()->getName();
        return view('kia.kecacingan', compact('pasien', 'routeName'));
    }

    public function storeKecacingan(Request $request)
    {
        // Define validation rules
        $validator = Validator::make($request->all(), [
            'pasien' => 'required',
            'sakit_perut' => 'required|boolean',
            'diare' => 'required|boolean',
            'bab_darah' => 'required|boolean',
            'bab_cacing' => 'required|boolean',
            'nafsu_makan_turun' => 'required|boolean',
            'gatal' => 'required|boolean',
            'badan_lemah' => 'required|boolean',
            'kulit_pucat' => 'required|boolean',
            'kesimpulan' => 'required',
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->with('error', 'There were validation errors.')->withInput();
        }

        // Create and store the new Kecacingan record with additional fields
        Kecacingan::create(
            array_merge(
                $validator->validated(), // Only uses validated data
                [
                    'klaster' => $request->klaster,
                    'poli' => $request->poli, // Adding 'poli' field with a specific value
                ],
            ),
        );

        // Redirect with a success message
        return redirect()->back()->with('success', 'Data Kecacingan created successfully!');
    }

    public function showHiv()
    {
        $pasien = Patients::all();
        return view('kia.hiv', compact('pasien'));
    }
    public function storeHiv(Request $request)
    {
        // Define validation rules
        $validator = Validator::make($request->all(), [
            'pasien' => 'required',
            'tes_hiv' => 'nullable|boolean',
            'tanggal_tes_terakhir' => '',
            'penurunan_berat' => 'nullable|boolean',
            'jumlah_berat_badan_turun' => 'nullable|numeric|min:0',
            'penyakit_kulit' => 'nullable|boolean',
            'gejala_ispa' => 'nullable|boolean',
            'gejala_sariawan' => 'nullable|boolean',
            'riwayat_sesak' => 'nullable|boolean',
            'riwayat_hepatitis' => 'nullable|boolean',
            'riwayat_seks_bebas' => 'nullable|boolean',
            'riwayat_narkoba' => 'nullable|boolean',
            'riwayat_penyakit_menular' => 'nullable|boolean',
            'kesimpulan' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->with('error', 'There were validation errors.')->withInput();
        }

        Hiv::create(
            array_merge($validator->validated(), [
                'klaster' => 2,
                'poli' => 'kia',
            ]),
        );

        // Redirect with a success message
        return redirect()->back()->with('success', 'Data HIV created successfully!');
    }

    public function showAnemia(Request $request, $id)
    {
        $pasien = Patients::find($id);
        $routeName = $request->route()->getName();
        return view('kia.anemia', compact('pasien', 'routeName'));
    }

    public function storeAnemia(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
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
            'kesimpulan' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $anemia = Anemia::create(
            array_merge($validator->validated(), [
                'klaster' => $request->klaster,
                'poli' => $request->poli,
            ]),
        );

        return redirect()->back()->with('success', 'Data Anemia created successfully!');
    }

    public function showTalasemia(Request $request)
    {
        $pasien = Patients::all();
        $routeName = $request->route()->getName();
        return view('kia.talasemia', compact('pasien', 'routeName'));
    }
    public function storeTalasemia(Request $request)
    {
        // Define validation rules
        $validator = Validator::make($request->all(), [
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
            'kesimpulan' => 'required',
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->with('error', 'There were validation errors.')->withInput();
        }

        Talasemia::create(
            array_merge($validator->validated(), [
                'klaster' => $request->klaster,
                'poli' => $request->poli,
            ]),
        );
        // Redirect with a success message
        return redirect()->back()->with('success', 'Data Talasemia created successfully!');
    }
    public function showHepatitis()
    {
        $pasien = Patients::all();
        return view('kia.hepatitis', compact('pasien'));
    }
    public function storeHepatitis(Request $request)
    {
        // Define validation rules
        // dd($request->all());
        $validator = Validator::make($request->all(), [
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
            'kesimpulan' => 'required',
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->with('error', 'There were validation errors.')->withInput();
        }

        // Create and store the new Hepatitis record with additional fields
        Hepatitis::create(
            array_merge(
                $validator->validated(), // Only uses validated data
                [
                    'klaster' => 2, // Adding 'klaster' field with value 2
                    'poli' => 'kia', // Adding 'poli' field with value 'kia'
                ],
            ),
        );

        // Redirect with a success message
        return redirect()->back()->with('success', 'Data Hepatitis created successfully!');
    }

    public function showKekerasanAnak(Request $request)
    {
        $pasien = Patients::all();
        $routeName = $request->route()->getName();
        return view('kia.kekerasan_anak', compact('pasien', 'routeName'));
    }
    public function storeKekerasanAnak(Request $request)
    {
        // Define validation rules
        $validator = Validator::make($request->all(), [
            'pasien' => 'required',
            'diperoleh_dari' => 'required|string|max:255',
            'hubungan_pasien' => 'required',
            'kekerasan' => 'nullable',
            'tempat' => 'nullable',
            'dampak_pasien' => 'nullable',
            'dampak_pada_anak' => 'nullable',
            'penelantaran_fisik' => 'nullable',
            'tanda_kekerasan' => 'nullable',
            'tanda_kekerasan_check' => 'nullable',
            'derajat_luka_bakar' => 'nullable',
            'kekerasan_seksual' => 'nullable',
            'dampak_kekerasan' => 'nullable',
            'tempat_lain' => 'nullable',
            'kesimpulan' => 'required',
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->with('error', 'There were validation errors.')->withInput();
        }

        // Store validated data with additional fields
        KekerasanAnak::create(
            array_merge($validator->validated(), [
                'klaster' => $request->klaster,
                'poli' => $request->poli,
            ]),
        );

        // Redirect with success message
        return redirect()->back()->with('success', 'Data Kekerasan Anak created successfully!');
    }

    public function showKekerasanPerempuan(Request $request)
    {
        $pasien = Patients::all();
        $routeName = $request->route()->getName();
        return view('kia.kekerasan_perempuan', compact('pasien', 'routeName'));
    }
    public function storeKekerasanPerempuan(Request $request)
    {
        // Define validation rules
        $validator = Validator::make($request->all(), [
            'no_responden' => 'required|string|max:50',
            'pasien' => 'required',
            'tempat_wawancara' => 'required',
            'hubungan_dengan_pasangan' => 'required|string|max:255',
            'mengatasi_pertengkaran_mulut' => 'required|string|max:500',
            'akibat_pertengkaran_mulut' => 'nullable',
            'pasangan_memukul' => 'nullable',
            'ketakutan' => 'nullable',
            'dibatasi' => 'nullable',
            'kesimpulan' => 'required',
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->with('error', 'There were validation errors.')->withInput();
        }

        // Store validated data with additional fields
        KekerasanPerempuan::create(
            array_merge($validator->validated(), [
                'klaster' => $request->klaster,
                'poli' => $request->poli,
            ]),
        );

        // Redirect with success message
        return redirect()->back()->with('success', 'Data Kekerasan Perempuan created successfully!');
    }

    public function showDiabetesMellitus(Request $request, $id)
    {
        $pasien = Patients::find($id);
        $routeName = $request->route()->getName();
        return view('kia.diabetes_mellitus', compact('pasien', 'routeName'));
    }
    public function storeDiabetesMellitus(Request $request)
    {
        // Define validation rules
        $validator = Validator::make($request->all(), [
            'pasien' => 'required',
            'tinggi_badan' => 'required|numeric',
            'berat_badan' => 'required|numeric',
            'lingkar_perut' => 'required|numeric',
            'hasil' => 'required',
            'tekanan_darah_sistol' => 'required|numeric',
            'tekanan_darah_diastol' => 'required|numeric',
            'kesimpulan' => 'required',
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->with('error', 'There were validation errors.')->withInput();
        }

        $diabetes = DiabetesMellitus::create(
            array_merge($validator->validated(), [
                'klaster' => $request->klaster,
                'poli' => $request->poli,
            ]),
        );

        // Redirect with a success message
        return redirect()->back()->with('success', 'Data Diabetes Mellitus created successfully!');
    }
    public function showTbc(Request $request, $id)
    {
        $pasien = Patients::find($id);
        $routeName = $request->route()->getName();
        return view('kia.tbc', compact('pasien', 'routeName'));
    }
    public function storeTbc(Request $request)
    {
        // Define validation rules
        $validator = Validator::make($request->all(), [
            'pasien' => 'required',
            'tempat_skrining' => 'nullable',
            'tinggi_badan' => 'nullable',
            'berat_badan' => 'nullable',
            'status_gizi' => 'nullable',
            'kontak_dengan_pasien' => '',
            'kontak_tbc' => '',
            'jenis_tbc' => 'nullable',
            'pernah_berobat_tbc' => 'nullable',
            'kapan' => 'nullable|date',
            'pernah_berobat_tbc_tdk_tuntas' => 'nullable',
            'kurang_gizi' => 'nullable',
            'merokok' => 'nullable',
            'perokok_pasif' => 'nullable',
            'kencing_manis' => 'nullable',
            'odhiv' => 'nullable',
            'lansia' => 'nullable',
            'ibu_hamil' => 'nullable',
            'tinggal_wilayah_kumuh' => 'nullable',
            'batuk' => 'nullable',
            'durasi' => 'nullable',
            'batuk_darah' => 'nullable',
            'bb_turun' => 'nullable',
            'demam' => 'nullable',
            'lesu' => 'nullable',
            'pembesaran_kelenjar' => 'nullable',
            'sudah_rontgen' => 'nullable',
            'hasil_rontgen' => 'nullable',
            'terduga_tbc' => 'nullable',
            'periksa_tbc_laten' => 'nullable',
            'kesimpulan' => 'required',
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->with('error', 'There were validation errors.')->withInput();
        }

        // Store validated data with additional fields
        Tbc::create(
            array_merge($validator->validated(), [
                'klaster' => $request->klaster,
                'poli' => $request->poli,
            ]),
        );

        // Redirect with success message
        return redirect()->back()->with('success', 'Data TBC created successfully!');
    }
    public function showGangguanJiwaDewasa(Request $request, $id)
    {
        $pasien = Patients::find($id);
        $routeName = $request->route()->getName();
        return view('kia.gangguan_jiwa_dewasa', compact('pasien', 'routeName'));
    }
    public function storeGangguanJiwaDewasa(Request $request)
    {
        // Define validation rules
        $validator = Validator::make($request->all(), [
            'pasien' => 'required',
            'sakit_kepala' => 'nullable',
            'hilang_nafsu_makan' => 'nullable',
            'tidur_nyenyak' => 'nullable',
            'takut' => 'nullable',
            'cemas' => 'nullable',
            'tangan_gemetar' => 'nullable',
            'gangguan_pencernaan' => 'nullable',
            'sulit_berpikir_jernih' => 'nullable',
            'tdk_bahagia' => 'nullable',
            'sering_menangis' => 'nullable',
            'sulit_aktivitas' => 'nullable',
            'sulit_ambil_keputusan' => 'nullable',
            'tugas_terbengkalai' => 'nullable',
            'tdk_berperan' => 'nullable',
            'hilang_minat' => 'nullable',
            'tdk_berharga' => 'nullable',
            'pikiran_mati' => 'nullable',
            'lelah_selalu' => 'nullable',
            'sakit_perut' => 'nullable',
            'mudah_lelah' => 'nullable',
            'kesimpulan' => 'required',
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->with('error', 'There were validation errors.')->withInput();
        }

        // Store validated data with additional fields
        GangguanJiwaDewasa::create(
            array_merge($validator->validated(), [
                'klaster' => $request->klaster,
                'poli' => $request->poli,
            ]),
        );

        // Redirect with success message
        return redirect()->back()->with('success', 'Data Gangguan Jiwa Dewasa created successfully!');
    }
    public function showMigrasiMalaria(Request $request, $id)
    {
        $pasien = Patients::find($id);
        $routeName = $request->route()->getName();
        return view('kia.malaria', compact('pasien', 'routeName'));
    }
    public function storeMalaria(Request $request)
    {
        // Define validation rules
        $validator = Validator::make($request->all(), [
            'pasien' => 'required',
            'sakit_kepala' => 'nullable',
            'hilang_nafsu_makan' => 'nullable',
            'tidur_nyenyak' => 'nullable',
            'takut' => 'nullable',
            'cemas' => 'nullable',
            'tangan_gemetar' => 'nullable',
            'gangguan_pencernaan' => 'nullable',
            'sulit_berpikir_jernih' => 'nullable',
            'tdk_bahagia' => 'nullable',
            'sering_menangis' => 'nullable',
            'sulit_aktivitas' => 'nullable',
            'sulit_ambil_keputusan' => 'nullable',
            'tugas_terbengkalai' => 'nullable',
            'tdk_berperan' => 'nullable',
            'hilang_minat' => 'nullable',
            'tdk_berharga' => 'nullable',
            'pikiran_mati' => 'nullable',
            'lelah_selalu' => 'nullable',
            'sakit_perut' => 'nullable',
            'mudah_lelah' => 'nullable',
            'kesimpulan' => 'required',
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->with('error', 'There were validation errors.')->withInput();
        }

        // Store validated data with additional fields
        GangguanJiwaDewasa::create(
            array_merge($validator->validated(), [
                'klaster' => $request->klaster,
                'poli' => $request->poli,
            ]),
        );

        // Redirect with success message
        return redirect()->back()->with('success', 'Data Gangguan Jiwa Dewasa created successfully!');
    }
    public function showTripleEliminasi($id)
    {
        $pasien = Patients::find($id);
        return view('kia.triple_eliminasi', compact('pasien'));
    }
    public function storeTripleEliminasi(Request $request)
    {
        // Define validation rules
        $validator = Validator::make($request->all(), [
            'pasien' => 'required',
            'gravida' => 'nullable',
            'partus' => 'nullable',
            'abortus' => 'nullable',
            'umur_kehamilan' => 'nullable',
            'taksiran_kehamilan' => 'nullable',
            'nama_puskesmas' => 'nullable',
            'kode_specimen' => 'nullable',
            // 'no_hp' => 'nullable|string|max:15',
            'umur_ibu' => 'nullable',
            // 'alamat' => 'nullable|string',
            'gejala_hepatitis' => 'nullable',
            'gejala_urine_gelap' => 'nullable',
            'gejala_kuning' => 'nullable',
            'gejala_lainnya' => 'nullable',
            'test_hepatitis' => 'nullable',
            'lokasi_tes' => 'nullable',
            'tanggal_tes' => 'nullable',
            'anti_hbs' => 'nullable',
            'anti_hbc' => 'nullable',
            'sgpt' => 'nullable',
            'anti_hbe' => 'nullable',
            'hbeag' => 'nullable',
            'hbv_dna' => 'nullable',
            'transfusi_darah' => 'nullable',
            'kapan_transfusi' => 'nullable',
            'hemodialisa' => 'nullable',
            'kapan_hemodialisa' => 'nullable',
            'jmlh_pasangan_seks' => 'nullable|integer',
            'narkoba' => 'nullable',
            'kapan_narkoba' => 'nullable',
            'vaksin' => 'nullable',
            'kapan_vaksin' => 'nullable',
            'jmlh_vaksin' => 'nullable|integer',
            'tinggal_serumah' => 'nullable',
            'kapan_tinggal_serumah' => 'nullable',
            'hubungan_hepatitis' => 'nullable',
            'hubungan_detail' => 'nullable',
            'test_hiv' => 'nullable',
            'hasil_hiv' => 'nullable',
            'cd4_check' => 'nullable',
            'dimana_cd4' => 'nullable',
            'hasil_cd4' => 'nullable',
            'arv_check' => 'nullable',
            'kapan_arv' => 'nullable',
            'gejala_pms' => 'nullable',
            'kapan_pms' => 'nullable',
            'kesimpulan' => 'required',
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->with('error', 'There were validation errors.')->withInput();
        }

        // Store validated data with additional fields
        TripleEliminasi::create(
            array_merge($validator->validated(), [
                'klaster' => 2,
                'poli' => 'kia',
            ]),
        );

        // Redirect with success message
        return redirect()->back()->with('success', 'Data Triple Eliminasi created successfully!');
    }
}
