<?php

namespace App\Http\Controllers;

use App\Models\Geriatri;
use App\Models\KankerKolorektal;
use App\Models\KankerParu;
use App\Models\KankerPayudara;
use App\Models\Puma;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LansiaController extends Controller
{
    public function showPuma()
    {
        return view('lansia.puma');
    }
    public function storePuma(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'puskesmas' => 'required|string|max:255',
            'petugas' => 'required|string|max:255',
            'jenis_kelamin' => 'required',
            'usia' => 'required|integer|min:0',
            'merokok' => 'required|boolean',
            'jumlah_rokok' => 'nullable|integer|min:0',
            'lama_rokok' => 'nullable|integer|min:0',
            'rokok_per_tahun' => 'nullable|numeric|min:0',
            'nafas_pendek' => 'required|boolean',
            'punya_dahak' => 'required|boolean',
            'batuk' => 'required|boolean',
            'periksa_paru' => 'required|boolean',
        ]);

        // Periksa apakah validasi gagal
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->with('error', 'Terdapat kesalahan validasi.')
                ->withInput();
        }

        // Menyimpan data ke dalam database
        Puma::create(array_merge(
            $validator->validated(), // Data hasil validasi
            [
                'klaster' => 3, // Nilai default untuk klaster
                'poli' => 'lansia', // Nilai default untuk poli
            ]
        ));

        // Redirect dengan pesan sukses
        return redirect()->route('puma.lansia.view')
            ->with('success', 'Data Puma berhasil disimpan!');
    }
    public function showKankerParu()
    {
        return view('lansia.kanker_paru');
    }
    public function storeKankerParu(Request $request)
    {
        // Validate the input data
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'jenis_kelamin' => 'required|string|max:50',
            'usia' => 'required|integer|min:0',
            'kanker' => 'nullable',
            'keluarga_kanker' => 'nullable',
            'merokok' => 'nullable',
            'riwayat_tempat_kerja' => 'nullable',
            'tempat_tinggal' => 'nullable',
            'lingkungan_rumah' => 'nullable',
            'paru_kronik' => 'nullable',
         
        ]);

        // Check if validation failed
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->with('error', 'There were validation errors.')
                ->withInput();
        }

        // Store the validated data into the database
        KankerParu::create(array_merge(
            $validator->validated(), // Validated data
            [
                // Optionally add default values if required
                'klaster' => 3, // Already passed in request
                'poli' => 'lansia', // Already passed in request
            ]
        ));

        // Redirect with success message
        return redirect()->route('kankerParu.lansia.view')
            ->with('success', 'Data Kanker Paru has been successfully saved!');
    }
    public function showKankerKolorektal()
    {
        return view('lansia.kanker_kolorektal');
    }
    public function storeKankerKolorektal(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'jenis_kelamin' => 'required|integer|in:0,1',
            'usia' => 'required|integer|min:0',
            'riwayat_kanker' => 'nullable',
            'merokok' => 'nullable',
            'bercampur_darah' => 'nullable|string|max:255',
            'diare_kronis' => 'nullable|string|max:255',
            'bab_kambing' => 'nullable|string|max:255',
            'konstipasi_kronis' => 'nullable|string|max:255',
            'frekuensi_defekasi' => 'nullable|string|max:255',
        ]);

        // Periksa apakah validasi gagal
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->with('error', 'Terdapat kesalahan validasi.')
                ->withInput();
        }

        // Menyimpan data ke dalam database
        KankerKolorektal::create(array_merge(
            $validator->validated(), // Data hasil validasi
            [
                'klaster' => 3, // Nilai default untuk klaster
                'poli' => 'lansia', // Nilai default untuk poli
            ]
        ));

        // Redirect dengan pesan sukses
        return redirect()->route('kankerKolorektal.lansia.view')
            ->with('success', 'Data Kanker Kolorektal berhasil disimpan!');
    }
    public function showKankerPayudara()
    {
        return view('lansia.kanker_payudara');
    }
    public function storeKankerPayudara(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'nomor_klien' => 'required|string|max:255',
            'nama' => 'required|string|max:255',
            'umur' => 'required|integer|min:1',
            'suku_bangsa' => 'nullable|string|max:255',
            'agama' => 'nullable|string|max:255',
            'berat_badan' => 'nullable|numeric|min:1',
            'tinggi_badan' => 'nullable|numeric|min:1',
            'alamat' => 'nullable|string|max:500',
            'perkawinan_pasangan' => 'nullable',
            'klien' => 'nullable',
            'pekerjaan_klien' => 'nullable',
            'pekerjaan_suami' => 'nullable',
            'pendidikan_terakhir' => 'nullable',
            'jmlh_anak_kandung' => 'nullable|integer|min:0',
            'rt_rw' => 'nullable',
            'kelurahan_desa' => 'nullable',
            'menstruasi' => 'nullable',
            'usia_seks' => 'nullable|integer|min:0',
            'keputihan' => 'nullable|boolean',
            'merokok' => 'nullable|boolean',
            'terpapar_asap_rokok' => 'nullable',
            'konsumsi_buah_sayur' => 'nullable',
            'konsumsi_makanan_lemak' => 'nullable',
            'konsumsi_makanan_pengawet' => 'nullable',
            'kurang_aktivitas' => 'nullable',
            'pap_smear' => 'nullable',
            'berganti_pasangan' => 'nullable',
            'riwayat_kanker' => 'nullable',
            'jenis_kanker' => 'nullable',
            'kehamilan_pertama' => 'nullable|integer|min:0',
            'menyusui' => 'nullable',
            'melahirkan' => 'nullable',
            'melahirkan_4_kali' => 'nullable',
            'menikah_lbh_1' => 'nullable',
            'kb_hormonal_pil' => 'nullable',
            'kb_hormonal_suntik' => 'nullable',
            'tumor_jinak' => 'nullable',
            'menopause' => 'nullable',
            'obesitas' => 'nullable',
            'kulit' => 'nullable',
            'areola' => 'nullable',
            'benjolan' => 'nullable',
            'ukuran_benjolan' => 'nullable|numeric|min:0',
            'normal' => 'nullable',
            'kelainan_jinak' => 'nullable',
            'kelainan_ganas' => 'nullable',
            'vulva' => 'nullable',
            'vulva_details' => 'nullable',
            'vagina' => 'nullable',
            'vagina_details' => 'nullable',
            'serviks' => 'nullable',
            'serviks_details' => 'nullable',
            'uterus' => 'nullable',
            'uterus_details' => 'nullable',
            'adnexa' => 'nullable',
            'adnexa_details' => 'nullable',
            'rectovaginal' => 'nullable',
            'rectovaginal_details' => 'nullable',
            'iva_negatif' => 'nullable',
            'iva_positif' => 'nullable',
            'tanggal_kunjungan' => '',
            'lainnya' => 'nullable',
            'ims' => 'nullable',
            'detail_diobati' => 'nullable',
            'dirujuk' => 'nullable',
            'rujukan' => 'nullable',
        ]);

        // Periksa apakah validasi gagal
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->with('error', 'Terdapat kesalahan validasi.')
                ->withInput();
        }

        // Tambahkan nilai default untuk ukuran_benjolan jika kosong
        $validatedData = $validator->validated();
        $validatedData['ukuran_benjolan'] = $validatedData['ukuran_benjolan'] ?? 0;

        // Simpan data ke database
        KankerPayudara::create(array_merge(
            $validatedData,
            [
                'klaster' => 3, // Nilai default klaster
                'poli' => 'lansia', // Nilai default poli
            ]
        ));

        // Redirect dengan pesan sukses
        return redirect()->route('kankerPayudara.lansia.view') // Ganti dengan rute yang sesuai
            ->with('success', 'Data Kanker Payudara berhasil disimpan!');
    }
    public function showGeriatri()
    {
        return view('lansia.geriatri');
    }
    public function storeGeriatri(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'umur' => 'required|integer|min:0',
            'jenis_kelamin' => 'nullable|string|max:50',
            'alamat' => 'nullable|string|max:255',
            'rt' => 'nullable|string|max:10',
            'rw' => 'nullable|string|max:10',
            'tempat_waktu' => 'nullable|integer|min:0',
            'ulang_kata' => 'nullable|integer|min:0',
            'tes_berdiri' => 'nullable|integer|min:0',
            'pakaian' => 'nullable|integer|min:0',
            'nafsu_makan' => 'nullable|integer|min:0',
            'ukuran_lingkar' => 'nullable|integer|min:0',
            'tes_melihat' => 'nullable|integer|min:0',
            'hitung_jari' => 'nullable|integer|min:0',
            'tes_bisik' => 'nullable|integer|min:0',
            'perasaan_sedih' => 'nullable|integer|min:0',
            'kesenangan' => 'nullable|integer|min:0',
        ]);

        // Periksa apakah validasi gagal
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->with('error', 'Terdapat kesalahan validasi.')
                ->withInput();
        }

        // Menyimpan data ke dalam database
        Geriatri::create(array_merge(
            $validator->validated(),
            [
                'klaster' => 3, // Nilai default untuk klaster
                'poli' => 'lansia', // Nilai default untuk poli
            ]
        ));

        // Redirect dengan pesan sukses
        return redirect()->route('geriatri.lansia.view') // Ganti sesuai rute Anda
            ->with('success', 'Data Geriatri berhasil disimpan!');
    }



}
