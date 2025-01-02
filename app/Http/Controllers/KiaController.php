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
use App\Models\TripleEliminasi;
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
        return redirect()->route('layakHamil.view')->with('success', 'Data saved successfully');
    }

    public function showHipertensi(Request $request)
    {
        $pasien = Patients::all();
        $routeName = $request->route()->getName();
        return view('kia.hipertensi', compact('pasien', 'routeName'));
    }
    public function storeHipertensi(Request $request)
    {
        // Define validation rules
        $validator = Validator::make($request->all(), [
            'pasien' => 'required',
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
            'kesimpulan' => 'required',
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
        return redirect()->route('hipertensi.view')->with('success', 'Data hipertensi berhasil disimpan');
    }
    public function showGangguanAutis()
    {
        $pasien = Patients::all();
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
        return redirect()->route('gangguan.autis.view')->with('success', 'Data Gangguan Autis created successfully!');
    }
    public function showKecacingan(Request $request)
    {
        $pasien = Patients::all();
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
        return redirect()->route('kecacingan.view')->with('success', 'Data Kecacingan created successfully!');
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

        // Check if validation fails
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->with('error', 'There were validation errors.')->withInput();
        }

        // Create and store the new Hiv record with additional fields
        Hiv::create(
            array_merge(
                $validator->validated(), // Only use validated data
                [
                    'klaster' => 2, // Adding 'klaster' field with a default value
                    'poli' => 'kia', // Adding 'poli' field with a default value
                ],
            ),
        );

        // Redirect with a success message
        return redirect()->route('hiv.view')->with('success', 'Data HIV created successfully!');
    }

    public function showAnemia(Request $request)
    {
        $pasien = Patients::all();
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
            'mengatasi_pertengkaran_mulur' => 'required|string|max:500',
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

    public function showDiabetesMellitus(Request $request)
    {
        $pasien = Patients::all();
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
    public function showTbc(Request $request)
    {
        $pasien = Patients::all();
        $routeName = $request->route()->getName();
        return view('kia.tbc', compact('pasien', 'routeName'));
    }
    public function storeTbc(Request $request)
    {
        // Define validation rules
        $validator = Validator::make($request->all(), [
            'pasien' => 'required',
            'tempat_skrining' => 'required|string|max:255',
            'tinggi_badan' => 'required|numeric',
            'berat_badan' => 'required|numeric',
            'status_gizi' => 'nullable|string|max:255',
            'kontak_dengan_pasien' => '',
            'kontak_tbc' => '',
            'jenis_tbc' => 'nullable|string|max:255',
            'pernah_berobat_tbc' => 'required',
            'kapan' => 'nullable|date',
            'pernah_berobat_tbc_tdk_tuntas' => 'required',
            'kurang_gizi' => 'required',
            'merokok' => 'required',
            'perokok_pasif' => 'required',
            'kencing_manis' => 'required',
            'odhiv' => '',
            'lansia' => 'required',
            'ibu_hamil' => 'required',
            'tinggal_wilayah_kumuh' => 'required',
            'batuk' => 'required',
            'durasi' => 'nullable|string|max:255',
            'batuk_darah' => 'required',
            'bb_turun' => 'required',
            'demam' => 'required',
            'lesu' => 'required',
            'pembesaran_kelenjar' => 'required',
            'sudah_rontgen' => 'required',
            'hasil_rontgen' => 'nullable|string|max:255',
            'terduga_tbc' => 'required',
            'periksa_tbc_laten' => 'required',
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
    public function showTripleEliminasi()
    {
        $pasien = Patients::all();
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
            'pendidikan' => 'nullable',
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
                'klaster' => 2, // Assign a default value for klaster
                'poli' => 'kia', // Assign a default value for poli
            ]),
        );

        // Redirect with success message
        return redirect()->back()->with('success', 'Data Triple Eliminasi created successfully!');
    }
}
