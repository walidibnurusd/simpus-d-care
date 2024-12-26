<?php

namespace App\Http\Controllers;

use App\Models\GangguanJiwaAnak;
use App\Models\GangguanJiwaRemaja;
use App\Models\Merokok;
use App\Models\Napza;
use App\Models\Obesitas;
use App\Models\TesDayaDengar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MtbsController extends Controller
{
    public function showSdqAnak()
    {
        return view('mtbs.gangguan_jiwa_anak');
    }
    public function storeSdqAnak(Request $request)
    {
        // Definisikan aturan validasi
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|string|max:10',
            'alamat' => 'required|string|max:500',
            'berusaha_baik' => 'nullable',
            'gelisah' => 'nullable',
            'sakit' => 'nullable',
            'berbagi' => 'nullable',
            'marah' => 'nullable',
            'suka_sendiri' => 'nullable',
            'penurut' => 'nullable',
            'cemas' => 'nullable',
            'siap_menolong' => 'nullable',
            'badan_bergerak' => 'nullable',
            'punya_teman' => 'nullable',
            'suka_bertengkar' => 'nullable',
            'tdk_bahagia' => 'nullable',
            'disukai' => 'nullable',
            'mudah_teralih' => 'nullable',
            'gugup' => 'nullable',
            'baik_pada_anak' => 'nullable',
            'bohong' => 'nullable',
            'suka_bantu' => 'nullable',
            'kritis' => 'nullable',
            'mencuri' => 'nullable',
            'mudah_berteman' => 'nullable',
            'takut' => 'nullable',
            'rajin' => 'nullable',
          
        ]);

        // Periksa apakah validasi gagal
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->with('error', 'Terdapat kesalahan validasi.')
                ->withInput();
        }

        // Menyimpan data ke dalam database
        GangguanJiwaAnak::create(array_merge(
            $validator->validated(),
            [
                'klaster' => 2, // Ubah 'default_value' sesuai kebutuhan
                'poli' => 'mtbs dan remaja',    // Ubah 'default_value' sesuai kebutuhan
            ]
        ));

        // Redirect dengan pesan sukses
        return redirect()->route('sdq.mtbs.view')
            ->with('success', 'Data Gangguan Jiwa Anak berhasil dibuat!');
    }
    public function showSdqRemaja()
    {
        return view('mtbs.gangguan_jiwa_remaja');
    }
    public function storeSdqRemaja(Request $request)
    {
        // Definisikan aturan validasi
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|string|max:10',
            'alamat' => 'required|string|max:500',
            'peduli_perasaan' => 'nullable',
            'gelisah' => 'nullable',
            'sakit' => 'nullable',
            'berbagi' => 'nullable',
            'marah' => 'nullable',
            'suka_sendiri' => 'nullable',
            'penurut' => 'nullable',
            'cemas' => 'nullable',
            'siap_menolong' => 'nullable',
            'badan_bergerak' => 'nullable',
            'punya_teman' => 'nullable',
            'suka_bertengkar' => 'nullable',
            'tdk_bahagia' => 'nullable',
            'disukai' => 'nullable',
            'mudah_teralih' => 'nullable',
            'gugup' => 'nullable',
            'baik_pada_anak' => 'nullable',
            'bohong' => 'nullable',
            'suka_bantu' => 'nullable',
            'kritis' => 'nullable',
            'mencuri' => 'nullable',
            'mudah_berteman' => 'nullable',
            'takut' => 'nullable',
            'rajin' => 'nullable',
          
        ]);

        // Periksa apakah validasi gagal
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->with('error', 'Terdapat kesalahan validasi.')
                ->withInput();
        }

        // Menyimpan data ke dalam database
        GangguanJiwaRemaja::create(array_merge(
            $validator->validated(),
            [
                'klaster' => 2, // Ubah 'default_value' sesuai kebutuhan
                'poli' => 'mtbs dan remaja',    // Ubah 'default_value' sesuai kebutuhan
            ]
        ));

        // Redirect dengan pesan sukses
        return redirect()->route('sdq.remaja.mtbs.view')
            ->with('success', 'Data Gangguan Jiwa Remaja berhasil dibuat!');
    }
    public function showObesitas()
    {
        return view('mtbs.obesitas');
    }
    public function storeObesitas(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'tempat_lahir' => 'required|string|max:255',
            'alamat' => 'required|string|max:500',
            'tinggi_badan' => 'required|numeric|min:1',
            'berat_badan' => 'required|numeric|min:1',
            'lingkar_peru' => 'required|numeric|min:1',
            'hasil' => 'required',
        ]);

        // Periksa apakah validasi gagal
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->with('error', 'Terdapat kesalahan validasi.')
                ->withInput();
        }

        // Simpan data ke database dengan nilai tambahan menggunakan array_merge
        Obesitas::create(array_merge(
            $validator->validated(),
            [
                'klaster' => 2, // Ubah 'default_value' sesuai kebutuhan
                'poli' => 'mtbs dan remaja',         // Nilai default poli
            ]
        ));

        // Redirect dengan pesan sukses
        return redirect()->route('obesitas.mtbs.view')
            ->with('success', 'Data Obesitas berhasil disimpan!');
    }
    public function showNapza()
    {
        return view('mtbs.napza');
    }
    public function storeNapza(Request $request)
{
    // Validasi input
    $validator = Validator::make($request->all(), [
        'nama_pasien' => 'required|string|max:255',
        'nama_dokter' => 'required|string|max:255',
        'klinik' => 'nullable|string|max:255',
        'pertanyaan1' => 'nullable',
        'nama_zat_lain' => 'nullable',
        'pertanyaan2' => 'nullable',
        'pertanyaan3' => 'nullable',
        'pertanyaan4' => 'nullable',
        'pertanyaan5' => 'nullable',
        'pertanyaan6' => 'nullable',
        'pertanyaan7' => 'nullable',
        'pertanyaan8' => 'nullable',
    ]);

    // Periksa apakah validasi gagal
    if ($validator->fails()) {
        return redirect()->back()
            ->withErrors($validator)
            ->with('error', 'Terdapat kesalahan validasi.')
            ->withInput();
    }

    // Simpan data ke database dengan nilai tambahan
    Napza::create(array_merge(
        $validator->validated(),
        [
            'klaster' => 2, // Nilai default klaster
            'poli' => 'mtbs dan remaja', // Nilai default poli
        ]
    ));

    // Redirect dengan pesan sukses
    return redirect()->route('napza.mtbs.view') // Ganti dengan rute yang sesuai
        ->with('success', 'Data Napza berhasil disimpan!');
}

    public function showMerokok()
    {
        return view('mtbs.merokok');
    }
    public function storeMerokok(Request $request)
{
    // Validasi input
    $validator = Validator::make($request->all(), [
        'no_kuesioner' => 'required|string|max:255',
        'sekolah' => 'nullable|string|max:255',
        'provinsi' => 'nullable|string|max:255',
        'puskesmas' => 'nullable|string|max:255',
        'petugas' => 'nullable|string|max:255',
        'name_responden' => 'required|string|max:255',
        'nik' => 'required|string|max:16',
        'tanggal_lahir' => 'required',
        'umur' => 'required|integer',
        'jenis_kelamin' => 'required|string',
        'merokok' => 'nullable',
        'jenis_rokok' => 'nullable',
        'jenis_rokok_lainnya' => 'nullable',
        'usia_merokok' => 'nullable|integer',
        'alasan_merokok' => 'nullable',
        'alasan_merokok_lainnya' => 'nullable',
        'batang_per_hari' => 'nullable|integer',
        'batang_per_minggu' => 'nullable|integer',
        'lama_merokok_minggu' => 'nullable|integer',
        'lama_merokok_bulan' => 'nullable|integer',
        'lama_merokok_tahun' => 'nullable|integer',
        'dapat_rokok' => 'nullable',
        'dapat_rokok_lainnya' => 'nullable',
        'berhenti_merokok' => 'nullable',
        'alasan_berhenti_merokok' => 'nullable',
        'alasan_berhenti_merokok_lainnya' => 'nullable',
        'tau_bahaya_rokok' => 'nullable',
        'melihat_orang_merokok' => 'nullable',
        'orang_merokok' => 'nullable',
        'orang_merokok_lainnya' => 'nullable',
        'anggota_keluarga_merokok' => 'nullable',
        'teman_merokok' => 'nullable',
        'periksa_co2' => 'nullable',
        'kadar_co2' => 'nullable',
    ]);

    // Periksa apakah validasi gagal
    if ($validator->fails()) {
        return redirect()->back()
            ->withErrors($validator)
            ->with('error', 'Terdapat kesalahan validasi.')
            ->withInput();
    }

    // Simpan data ke database dengan nilai tambahan menggunakan array_merge
    Merokok::create(array_merge(
        $validator->validated(),
        [
            'klaster' => 2, // Nilai default klaster (ubah sesuai kebutuhan)
            'poli' => 'mtbs dan remaja', // Nilai default poli (ubah sesuai kebutuhan)
        ]
    ));

    // Redirect dengan pesan sukses
    return redirect()->route('merokok.mtbs.view')
        ->with('success', 'Data Merokok berhasil disimpan!');
}

    public function showTestPendengaran()
    {
        return view('mtbs.tes_pendengaran');
    }
    public function storeTestPendengaran(Request $request)
    {
        // Validate input
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'jenis_kelamin' => 'nullable|string|max:10',
            'usia' => 'required|string|max:50',
            // 'ekspresif' => 'nullable|array',
            // 'ekspresif.*.question' => 'required|string',
            // 'ekspresif.*.answer' => 'required|in:0,1',
            // 'reseptif' => 'nullable|array',
            // 'reseptif.*.question' => 'required|string',
            // 'reseptif.*.answer' => 'required|in:0,1',
            // 'visual' => 'nullable|array',
            // 'visual.*.question' => 'required|string',
            // 'visual.*.answer' => 'required|in:0,1',
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->with('error', 'Terdapat kesalahan validasi.')
                ->withInput();
        }

        // Save the data to the TesDayaDengar model
        TesDayaDengar::create([
            'nama' => $request->input('nama'),
            'tanggal' => $request->input('tanggal'),
            'jenis_kelamin' => $request->input('jenis_kelamin'),
            'usia' => $request->input('usia'),
            'ekspresif' => $request->input('ekspresif', []), // Default to empty array if not provided
            'reseptif' => $request->input('reseptif', []), // Default to empty array if not provided
            'visual' => $request->input('visual', []), // Default to empty array if not provided
            'klaster' => 2, // Default to empty array if not provided
            'poli' => 'mtbs dan remaja' // Default to empty array if not provided
        ]);

        // Redirect with success message
        return redirect()->route('testPendengaran.mtbs.view') // Adjust route as needed
            ->with('success', 'Data Tes Daya Dengar berhasil disimpan!');
    }
    
    
}
