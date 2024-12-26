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

class KiaController extends Controller
{
    public function showLayakHamil()
    {
        $pasien = Patients::all();
        return view('kia.layak_hamil',compact('pasien'));
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
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->with('error', 'There were validation errors.')->withInput();
        }

        // Store the data using validated inputs and default values
        LayakHamil::create(
            array_merge($validator->validated(), [
                'klaster' => 2,
                'poli' => 'kia',
            ]),
        );
        return redirect()->route('layakHamil.view')->with('success', 'Data saved successfully');
    }

    public function showHipertensi()
    {
        $pasien = Patients::all();
        return view('kia.hipertensi',compact('pasien'));
    }
    public function storeHipertensi(Request $request)
    {
        // Define validation rules
        $validator = Validator::make($request->all(), [
            'pasien' => 'required',
            // 'tanggal_lahir' => 'required|date',
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
            // 'jmlh_rokok' => ''??0,
        ]);

        // Check validation
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->with('error', 'Validation errors occurred.')->withInput();
        }

        // Store data with default values for 'klaster' and 'poli' if not provided
        $hipertensi = Hipertensi::create(
            array_merge($validator->validated(), [
                'klaster' => 2,
                'poli' => 'kia',
            ]),
        );

        // Return response
        return redirect()->route('hipertensi.view')->with('success', 'Data hipertensi berhasil disimpan');
    }
    public function showGangguanAutis()
    {
        return view('kia.gangguan_autis');
    }
    public function storeGangguanAutis(Request $request)
    {
        // Define validation rules
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required',
            'alamat' => 'nullable|string|max:500',
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
    public function showKecacingan()
    {
         $pasien = Patients::all();
        return view('kia.kecacingan',compact('pasien'));
    }

    public function storeKecacingan(Request $request)
    {
        // Define validation rules
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'alamat' => 'required|string|max:500',
            'jenis_kelamin' => 'required|string',
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

        // Create and store the new Kecacingan record with additional fields
        Kecacingan::create(
            array_merge(
                $validator->validated(), // Only uses validated data
                [
                    'klaster' => 2, // Adding 'klaster' field with a specific value
                    'poli' => 'kia', // Adding 'poli' field with a specific value
                ],
            ),
        );

        // Redirect with a success message
        return redirect()->route('kecacingan.view')->with('success', 'Data Kecacingan created successfully!');
    }

    public function showHiv()
    {
        return view('kia.hiv');
    }
    public function storeHiv(Request $request)
    {
        // Define validation rules
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'tanggal_lahir' => 'required',
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

    public function showAnemia()
    {
        return view('kia.anemia');
    }
    public function storeAnemia(Request $request)
    {
        // Define validation rules
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|string', // Assuming "L" for male, "P" for female
            'alamat' => 'required|string|max:500',
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

        // Create and store the new Anemia record
        $anemia = Anemia::create(
            array_merge(
                $validator->validated(), // Only uses validated data
                [
                    'klaster' => 2,
                    'poli' => 'kia',
                ],
            ),
        );

        // Redirect with a success message
        return redirect()->route('anemia.view')->with('success', 'Data Anemia created successfully!');
    }
    public function showTalasemia()
    {
        return view('kia.talasemia');
    }
    public function storeTalasemia(Request $request)
    {
        // Define validation rules
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'alamat' => 'required|string|max:500',
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
            'hipergimentasi_kulit' => 'required|boolean',
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->with('error', 'There were validation errors.')->withInput();
        }

        // Create and store the new Talasemia record with additional fields
        Talasemia::create(
            array_merge(
                $validator->validated(), // Only uses validated data
                [
                    'klaster' => 2, // Adding 'klaster' field with a default value
                    'poli' => 'kia', // Adding 'poli' field with a default value
                ],
            ),
        );
        // Redirect with a success message
        return redirect()->route('talasemia.view')->with('success', 'Data Talasemia created successfully!');
    }
    public function showHepatitis()
    {
        return view('kia.hepatitis');
    }
    public function storeHepatitis(Request $request)
    {
        // Define validation rules
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'alamat' => 'required|string|max:500',
            'jenis_kelamin' => 'required|string',
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
        return redirect()->route('hepatitis.view')->with('success', 'Data Hepatitis created successfully!');
    }

    public function showKekerasanAnak()
    {
        return view('kia.kekerasan_anak');
    }
    public function storeKekerasanAnak(Request $request)
    {
        // Define validation rules
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'alamat' => 'required|string|max:500',
            'jenis_kelamin' => 'required|string',
            'diperoleh_dari' => 'required|string|max:255',
            'hubungan_pasien' => 'required',
            'kekerasan' => 'required',
            'tempat' => 'nullable',
            'dampak_pasien' => 'nullable',
            'dampak_pada_anak' => 'nullable',
            'penelantaran_fisik' => 'required',
            'tanda_kekerasan' => 'nullable',
            'tanda_kekerasan_check' => 'nullable',
            'derajat_luka_bakar' => 'nullable',
            'kekerasan_seksual' => 'required',
            'dampak_kekerasan' => 'nullable',
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->with('error', 'There were validation errors.')->withInput();
        }

        // Store validated data with additional fields
        KekerasanAnak::create(
            array_merge($validator->validated(), [
                'klaster' => 2, // Assign a default value for klaster
                'poli' => 'kia', // Assign a default value for poli
            ]),
        );

        // Redirect with success message
        return redirect()->route('kekerasan.anak.view')->with('success', 'Data Kekerasan Anak created successfully!');
    }

    public function showKekerasanPerempuan()
    {
        return view('kia.kekerasan_perempuan');
    }
    public function storeKekerasanPerempuan(Request $request)
    {
        // Define validation rules
        $validator = Validator::make($request->all(), [
            'no_responden' => 'required|string|max:50',
            'umur' => 'required|integer|min:1',
            'tempat_wawancara' => 'required',
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

        // Store validated data with additional fields
        KekerasanPerempuan::create(
            array_merge($validator->validated(), [
                'klaster' => 2, // Assign a default value for klaster
                'poli' => 'kia', // Assign a default value for poli
            ]),
        );

        // Redirect with success message
        return redirect()->route('kekerasan.perempuan.view')->with('success', 'Data Kekerasan Perempuan created successfully!');
    }

    public function showDiabetesMellitus()
    {
        return view('kia.diabetes_mellitus');
    }
    public function storeDiabetesMellitus(Request $request)
    {
        // Define validation rules
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'tempat_lahir' => 'required|string|max:255',
            'alamat' => 'required|string|max:500',
            'penyakit_dulu' => 'nullable|string|max:500',
            'penyakit_sekarang' => 'nullable|string|max:500',
            'penyakit_keluarga' => 'nullable|string|max:500',
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

        DiabetesMellitus::create(
            array_merge(
                $validator->validated(), // Only uses validated data
                [
                    'klaster' => 2, // Adding 'klaster' field with value 2
                    'poli' => 'kia', // Adding 'poli' field with value 'kia'
                ],
            ),
        );

        // Redirect with a success message
        return redirect()->route('diabetes.mellitus.view')->with('success', 'Data Diabetes Mellitus created successfully!');
    }
    public function showTbc()
    {
        return view('kia.tbc');
    }
    public function storeTbc(Request $request)
    {
        // Define validation rules
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'tempat_skrining' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'alamat_domisili' => 'required|string|max:500',
            'alamat_ktp' => 'nullable|string|max:500',
            'nik' => 'required',
            'pekerjaan' => 'nullable|string|max:255',
            'imt' => 'nullable',
            'usia' => 'nullable',
            'jenis_kelamin' => 'required|string',
            'no_hp' => 'required',
            'tinggi_badan' => 'required|numeric',
            'berat_badan' => 'required|numeric',
            'status_gizi' => 'nullable|string|max:255',
            'kontak_dengan_pasien' => 'required|in:1,2,3',
            'kontak_tbc' => 'required',
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
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->with('error', 'There were validation errors.')->withInput();
        }

        // Store validated data with additional fields
        Tbc::create(
            array_merge($validator->validated(), [
                'klaster' => 2, // Assign a default value for klaster
                'poli' => 'kia', // Assign a default value for poli
            ]),
        );

        // Redirect with success message
        return redirect()->route('tbc.view')->with('success', 'Data TBC created successfully!');
    }
    public function showTripleEliminasi()
    {
        return view('kia.triple_eliminasi');
    }
    public function storeTripleEliminasi(Request $request)
    {
        // Define validation rules
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'tempat_lahir' => 'nullable|string|max:255',
            'tanggal_lahir' => 'nullable|date',
            'pekerjaan' => 'nullable|string|max:255',
            'status_kawin' => 'nullable|string|max:255',
            'gravida' => 'nullable|integer',
            'partus' => 'nullable|integer',
            'abortus' => 'nullable|integer',
            'umur_kehamilan' => 'nullable|integer',
            'taksiran_kehamilan' => 'nullable',
            'nama_puskesmas' => 'nullable',
            'kode_specimen' => 'nullable',
            'no_hp' => 'nullable|string|max:15',
            'umur_ibu' => 'nullable|integer',
            'alamat' => 'nullable|string',
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
            'kapan_pms' => 'nullable|date',
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
        return redirect()->route('triple.eliminasi.view')->with('success', 'Data Triple Eliminasi created successfully!');
    }
}
