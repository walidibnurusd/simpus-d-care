<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\GangguanJiwaAnak;
use App\Models\GangguanJiwaRemaja;
use App\Models\Merokok;
use App\Models\Napza;
use App\Models\Obesitas;
use App\Models\Patients;
use App\Models\TesDayaDengar;
use App\Models\Tbc;
use App\Models\Anemia;
use App\Models\Kecacingan;
use App\Models\KekerasanPerempuan;
use App\Models\KekerasanAnak;
use App\Models\Hipertensi;
use App\Models\Talasemia;
use App\Models\DiabetesMellitus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AdminControllerMTBS extends Controller
{
    public function viewGangguanJiwaAnak()
    {
        $gangguanJiwaAnak = GangguanJiwaAnak::all();
        $pasien = Patients::all();
        return view('mtbs.table.gangguan_jiwa_anak', compact('gangguanJiwaAnak', 'pasien'));
    }
    public function editGangguanJiwaAnak($id)
    {
        $gangguanJiwaAnak = GangguanJiwaAnak::findOrFail($id);
        $pasien = Patients::all();
        return view('mtbs.gangguan_jiwa_anak', compact('gangguanJiwaAnak', 'pasien'));
    }
    public function deleteGangguanJiwaAnak($id)
    {
        // Temukan data hepatitis berdasarkan ID
        $gangguanJiwaAnak = GangguanJiwaAnak::findOrFail($id);

        // Hapus data dari database
        $gangguanJiwaAnak->delete();

        // Redirect ke halaman sebelumnya atau halaman daftar dengan pesan sukses
        return redirect()->route('sdq.mtbs.admin')->with('success', 'Data Gangguan Jiwa Anak berhasil dihapus.');
    }
    public function updateGangguanJiwaAnak(Request $request, $id)
    {
        // Temukan data berdasarkan ID
        $gangguanJiwaAnak = GangguanJiwaAnak::findOrFail($id);

        // Definisikan aturan validasi
        $validator = Validator::make($request->all(), [
            'pasien' => 'required',
            // 'tanggal_lahir' => 'required|date',
            // 'jenis_kelamin' => 'required|string|max:10',
            // 'alamat' => 'required|string|max:500',
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
            'kesimpulan' => 'nullable',
        ]);

        // Periksa apakah validasi gagal
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->with('error', 'Terdapat kesalahan validasi.')->withInput();
        }

        // Memperbarui data dalam database
        $gangguanJiwaAnak->update(
            array_merge($validator->validated(), [
                'klaster' => 2, // Sesuaikan dengan kebutuhan
                'poli' => 'mtbs', // Sesuaikan dengan kebutuhan
            ]),
        );

        // Redirect dengan pesan sukses
        return redirect()->route('sdq.mtbs.admin')->with('success', 'Data Gangguan Jiwa Anak berhasil diperbarui!');
    }
    public function viewGangguanJiwaRemaja()
    {
        $gangguanJiwaRemaja = GangguanJiwaRemaja::all();
        $pasien = Patients::all();
        return view('mtbs.table.gangguan_jiwa_remaja', compact('gangguanJiwaRemaja', 'pasien'));
    }
    public function editGangguanJiwaRemaja($id)
    {
        $gangguanJiwaRemaja = GangguanJiwaRemaja::findOrFail($id);
        $pasien = Patients::all();
        return view('mtbs.gangguan_jiwa_remaja', compact('gangguanJiwaRemaja', 'pasien'));
    }
    public function deleteGangguanJiwaRemaja($id)
    {
        // Temukan data hepatitis berdasarkan ID
        $gangguanJiwaRemaja = GangguanJiwaRemaja::findOrFail($id);

        // Hapus data dari database
        $gangguanJiwaRemaja->delete();

        // Redirect ke halaman sebelumnya atau halaman daftar dengan pesan sukses
        return redirect()->route('sdq.mtbs.admin')->with('success', 'Data Gangguan Jiwa Remaja berhasil dihapus.');
    }
    public function updateGangguanJiwaRemaja(Request $request, $id)
    {
        // Temukan data berdasarkan ID
        $gangguanJiwaRemaja = GangguanJiwaRemaja::findOrFail($id);

        // Definisikan aturan validasi
        $validator = Validator::make($request->all(), [
            'pasien' => 'required',
            // 'tanggal_lahir' => 'required|date',
            // 'jenis_kelamin' => 'required|string|max:10',
            // 'alamat' => 'required|string|max:500',
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
            'diancam' => 'nullable',
            'kesimpulan' => 'required',
        ]);

        // Periksa apakah validasi gagal
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->with('error', 'Terdapat kesalahan validasi.')->withInput();
        }

        // Memperbarui data dalam database
        $gangguanJiwaRemaja->update(
            array_merge($validator->validated(), [
                'klaster' => 2, // Sesuaikan dengan kebutuhan
                'poli' => 'mtbs', // Sesuaikan dengan kebutuhan
            ]),
        );

        // Redirect dengan pesan sukses
        return redirect()->route('sdq.remaja.mtbs.admin')->with('success', 'Data Gangguan Jiwa Remaja berhasil diperbarui!');
    }

    public function viewObesitas()
    {
        $obesitas = Obesitas::with('listPasien')->get();
        return view('mtbs.table.obesitas', compact('obesitas'));
    }
    public function editObesitas($id)
    {
        $obesitas = Obesitas::findOrFail($id);
        $pasien = Patients::all();
        return view('mtbs.obesitas', compact('obesitas', 'pasien'));
    }
    public function deleteObesitas($id)
    {
        // Temukan data hepatitis berdasarkan ID
        $obesitas = Obesitas::findOrFail($id);

        // Hapus data dari database
        $obesitas->delete();

        // Redirect ke halaman sebelumnya atau halaman daftar dengan pesan sukses
        return redirect()->route('obesitas.mtbs.admin')->with('success', 'Data Obesitas berhasil dihapus.');
    }
    public function updateObesitas(Request $request, $id)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'pasien' => 'required',
            'tinggi_badan' => 'required|numeric|min:1',
            'berat_badan' => 'required|numeric|min:1',
            'lingkar_peru' => 'required|numeric|min:1',
            'hasil' => 'required',
            'kesimpulan' => 'required',
        ]);

        // Periksa apakah validasi gagal
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->with('error', 'Terdapat kesalahan validasi.')->withInput();
        }

        // Temukan data obesitas berdasarkan ID
        $obesitas = Obesitas::findOrFail($id);

        // Perbarui data dengan input baru
        $obesitas->update(
            array_merge($validator->validated(), [
                'klaster' => 2, // Nilai default tetap jika diperlukan
                'poli' => 'mtbs', // Nilai default tetap jika diperlukan
            ]),
        );

        // Redirect dengan pesan sukses
        return redirect()->route('obesitas.mtbs.admin')->with('success', 'Data Obesitas berhasil diperbarui!');
    }

    public function viewTestPendengaran()
    {
        $testPendengaran = TesDayaDengar::all();
        $pasien = Patients::all();
        return view('mtbs.table.tes_pendengaran', compact('testPendengaran', 'pasien'));
    }
    public function editTestPendengaran($id)
    {
        $testPendengaran = TesDayaDengar::findOrFail($id);
        $pasien = Patients::all();
        return view('mtbs.tes_pendengaran', compact('testPendengaran', 'pasien'));
    }
    public function deleteTestPendengaran($id)
    {
        // Temukan data hepatitis berdasarkan ID
        $testPendengaran = TesDayaDengar::findOrFail($id);

        // Hapus data dari database
        $testPendengaran->delete();

        // Redirect ke halaman sebelumnya atau halaman daftar dengan pesan sukses
        return redirect()->route('testPendengaran.mtbs.admin')->with('success', 'Data Tes Daya Dengar berhasil dihapus.');
    }
    public function updateTestPendengaran(Request $request, $id)
    {
        // Find the existing record
        $testPendengaran = TesDayaDengar::findOrFail($id);

        // Validate input
        $validator = Validator::make($request->all(), [
            'pasien' => 'required',
            // 'tanggal' => 'required|date',
            // 'jenis_kelamin' => 'nullable|string|max:10',
            'usia' => 'required|string|max:50',
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->with('error', 'Terdapat kesalahan validasi.')->withInput();
        }

        // Update the record
        $testPendengaran->update([
            'pasien' => $request->input('pasien'),
            // 'tanggal' => $request->input('tanggal'),
            // 'jenis_kelamin' => $request->input('jenis_kelamin'),
            'usia' => $request->input('usia'),
            'ekspresif' => $request->input('ekspresif', []), // Default to empty array if not provided
            'reseptif' => $request->input('reseptif', []), // Default to empty array if not provided
            'visual' => $request->input('visual', []), // Default to empty array if not provided
            'klaster' => 2, // Default value if not provided
            'poli' => 'mtbs', // Default value if not provided
            'kesimpulan' => $request->kesimpulan,
        ]);

        // Redirect with success message
        return redirect()
            ->route('testPendengaran.mtbs.admin') // Adjust route as needed
            ->with('success', 'Data Tes Daya Dengar berhasil diperbarui!');
    }
    public function viewMerokok()
    {
        $merokok = Merokok::all();
        $pasien = Patients::all();
        return view('mtbs.table.merokok', compact('merokok', 'pasien'));
    }
    public function editMerokok($id)
    {
        $merokok = Merokok::findOrFail($id);
        $pasien = Patients::all();
        return view('mtbs.merokok', compact('merokok', 'pasien'));
    }
    public function deleteMerokok($id)
    {
        // Temukan data hepatitis berdasarkan ID
        $merokok = Merokok::findOrFail($id);

        // Hapus data dari database
        $merokok->delete();

        // Redirect ke halaman sebelumnya atau halaman daftar dengan pesan sukses
        return redirect()->route('merokok.mtbs.admin')->with('success', 'Data Merokok berhasil dihapus.');
    }
    public function updateMerokok(Request $request, $id)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'no_kuesioner' => 'required|string|max:255',
            'sekolah' => 'nullable|string|max:255',
            'provinsi' => 'nullable|string|max:255',
            'puskesmas' => 'nullable|string|max:255',
            'petugas' => 'nullable|string|max:255',
            'pasien' => 'required',
            // 'nik' => 'required|string|max:16',
            // 'tanggal_lahir' => 'required|date',
            'umur' => 'required|integer',
            // 'jenis_kelamin' => 'required|string',
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
            'kesimpulan' => 'required',
        ]);

        // Periksa apakah validasi gagal
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->with('error', 'Terdapat kesalahan validasi.')->withInput();
        }

        // Cari data berdasarkan ID
        $merokok = Merokok::find($id);

        // Periksa apakah data ditemukan
        if (!$merokok) {
            return redirect()->route('merokok.mtbs.admin')->with('error', 'Data tidak ditemukan.');
        }

        // Perbarui data dengan nilai tambahan menggunakan array_merge
        $merokok->update(
            array_merge($validator->validated(), [
                'klaster' => $merokok->klaster ?? 2, // Tetap gunakan nilai sebelumnya jika ada
                'poli' => $merokok->poli ?? 'mtbs', // Tetap gunakan nilai sebelumnya jika ada
            ]),
        );

        // Redirect dengan pesan sukses
        return redirect()->route('merokok.mtbs.admin')->with('success', 'Data Merokok berhasil diperbarui!');
    }

    public function viewNapza()
    {
        $napza = Napza::all();
        $pasien = Patients::all();
        return view('mtbs.table.napza', compact('napza', 'pasien'));
    }
    public function editNapza($id)
    {
        $napza = Napza::findOrFail($id);
        $pasien = Patients::all();
        return view('mtbs.Napza', compact('napza', 'pasien'));
    }
    public function deleteNapza($id)
    {
        // Temukan data hepatitis berdasarkan ID
        $napza = Napza::findOrFail($id);

        // Hapus data dari database
        $napza->delete();

        // Redirect ke halaman sebelumnya atau halaman daftar dengan pesan sukses
        return redirect()->route('napza.mtbs.admin')->with('success', 'Data Napza berhasil dihapus.');
    }
    public function updateNapza(Request $request, $id)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'pasien' => 'required',
            'nama_dokter' => 'required|string|max:255',
            'klinik' => 'nullable|string|max:255',
            'pertanyaan1' => 'nullable',
            // 'nama_zat_lain' => 'nullable',
            'pertanyaan2' => 'nullable',
            'pertanyaan3' => 'nullable',
            'pertanyaan4' => 'nullable',
            'pertanyaan5' => 'nullable',
            'pertanyaan6' => 'nullable',
            'pertanyaan7' => 'nullable',
            'pertanyaan8' => 'nullable',
            'kesimpulan' => 'required',
        ]);

        // Periksa apakah validasi gagal
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->with('error', 'Terdapat kesalahan validasi.')->withInput();
        }

        // Temukan data Napza berdasarkan ID
        $napza = Napza::findOrFail($id);

        // Perbarui data Napza
        $napza->update(
            array_merge($validator->validated(), [
                'klaster' => $napza->klaster ?? 2, // Menggunakan nilai default jika null
                'poli' => $napza->poli ?? 'mtbs', // Menggunakan nilai default jika null
            ]),
        );

        // Redirect dengan pesan sukses
        return redirect()
            ->route('napza.mtbs.admin') // Ganti dengan rute yang sesuai
            ->with('success', 'Data Napza berhasil diperbarui!');
    }

    public function viewAnemia(Request $request)
    {
        $anemia = Anemia::with('listPasien')->where('poli', 'mtbs')->get();
        $routeName = $request->route()->getName();
        return view('kia.table.anemia', compact('anemia', 'routeName'));
    }
    public function viewTalasemia(Request $request)
    {
        $talasemia = Talasemia::with('listPasien')->where('poli', 'mtbs')->get();
        $routeName = $request->route()->getName();
        return view('kia.table.talasemia', compact('talasemia', 'routeName'));
    }
    public function viewTbc(Request $request)
    {
        $pasien = Patients::all();
        $tbc = Tbc::with('listPasien')->where('poli', 'mtbs')->get();
        $routeName = $request->route()->getName();
        return view('kia.table.tbc', compact('tbc', 'pasien', 'routeName'));
    }
    public function viewKecacingan(Request $request)
    {
        $kecacingan = Kecacingan::with('listPasien')->where('poli', 'mtbs')->get();
        $routeName = $request->route()->getName();
        return view('kia.table.kecacingan', compact('kecacingan', 'routeName'));
    }

    public function viewHipertensi(Request $request)
    {
        $hipertensi = Hipertensi::with('listPasien')->where('poli', 'mtbs')->get();
        $routeName = $request->route()->getName();
        return view('kia.table.hipertensi', compact('hipertensi', 'routeName'));
    }
    public function viewDiabetesMellitus(Request $request)
    {
        $diabetesMellitus = DiabetesMellitus::with('listPasien')->where('poli', 'mtbs')->get();
        $routeName = $request->route()->getName();
        return view('kia.table.diabetes_mellitus', compact('diabetesMellitus', 'routeName'));
    }
    public function viewKekerasanPerempuan(Request $request)
    {
        $kekerasanPerempuan = KekerasanPerempuan::with('listPasien')->where('poli', 'mtbs')->get();
        $routeName = $request->route()->getName();
        return view('kia.table.kekerasan_perempuan', compact('kekerasanPerempuan', 'routeName'));
    }
    public function viewKekerasanAnak(Request $request)
    {
        $kekerasanAnak = KekerasanAnak::with('listPasien')->where('poli', 'mtbs')->get();
        $routeName = $request->route()->getName();
        return view('kia.table.kekerasan_anak', compact('kekerasanAnak', 'routeName'));
    }
}
