<?php

namespace App\Http\Controllers;

use App\Models\Geriatri;
use App\Models\KankerKolorektal;
use App\Models\KankerParu;
use App\Models\KankerPayudara;
use App\Models\Patients;
use App\Models\Puma;
use App\Models\Anemia;
use App\Models\Tbc;
use App\Models\Kecacingan;
use App\Models\Hipertensi;
use App\Models\Talasemia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AdminLansiaController extends Controller
{
    public function viewPuma()
    {
        $pasien = Patients::all();
        $puma = Puma::all();
        return view('lansia.table.puma', compact('puma', 'pasien'));
    }
    public function editPuma($id)
    {
        $puma = Puma::findOrFail($id);
        $pasien = Patients::all();
        return view('lansia.Puma', compact('puma', 'pasien'));
    }
    public function deletePuma($id)
    {
        // Temukan data hepatitis berdasarkan ID
        $puma = Puma::findOrFail($id);

        // Hapus data dari database
        $puma->delete();

        // Redirect ke halaman sebelumnya atau halaman daftar dengan pesan sukses
        return redirect()->route('puma.lansia.admin')->with('success', 'Data Puma berhasil dihapus.');
    }
    public function updatePuma(Request $request, $id)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'pasien' => 'required',
            'puskesmas' => 'required|string|max:255',
            'petugas' => 'required|string|max:255',
            // 'jenis_kelamin' => 'required',
            'usia' => 'required|integer|min:0',
            'merokok' => 'required|boolean',
            'jumlah_rokok' => 'nullable|integer|min:0',
            'lama_rokok' => 'nullable|integer|min:0',
            'rokok_per_tahun' => 'nullable|numeric|min:0',
            'nafas_pendek' => 'required|boolean',
            'punya_dahak' => 'required|boolean',
            'batuk' => 'required|boolean',
            'periksa_paru' => 'required|boolean',
            'kesimpulan' => 'required',
        ]);

        // Periksa apakah validasi gagal
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->with('error', 'Terdapat kesalahan validasi.')->withInput();
        }

        // Cari data berdasarkan ID
        $puma = Puma::findOrFail($id);

        // Perbarui data ke dalam database
        $puma->update(
            array_merge(
                $validator->validated(), // Data hasil validasi
                [
                    'klaster' => 3, // Tetap gunakan nilai lama jika tidak diisi
                    'poli' => 'lansia', // Tetap gunakan nilai lama jika tidak diisi
                ],
            ),
        );

        // Redirect dengan pesan sukses
        return redirect()->route('puma.lansia.admin')->with('success', 'Data Puma berhasil diperbarui!');
    }

    public function viewKankerParu()
    {
        $kankerParu = KankerParu::with('listPasien')->get();
        return view('lansia.table.kanker_paru', compact('kankerParu'));
    }
    public function editKankerParu($id)
    {
        $kankerParu = KankerParu::findOrFail($id);
        $pasien = Patients::all();
        return view('lansia.kanker_paru', compact('kankerParu', 'pasien'));
    }
    public function deleteKankerParu($id)
    {
        // Temukan data hepatitis berdasarkan ID
        $kankerParu = KankerParu::findOrFail($id);

        // Hapus data dari database
        $kankerParu->delete();

        // Redirect ke halaman sebelumnya atau halaman daftar dengan pesan sukses
        return redirect()->route('kankerParu.lansia.admin')->with('success', 'Data Kanker paru berhasil dihapus.');
    }
    public function updateKankerParu(Request $request, $id)
    {
        // Validate the input data
        $validator = Validator::make($request->all(), [
            'pasien' => 'required',
            'kanker' => 'nullable',
            'keluarga_kanker' => 'nullable',
            'merokok' => 'nullable',
            'riwayat_tempat_kerja' => 'nullable',
            'tempat_tinggal' => 'nullable',
            'lingkungan_rumah' => 'nullable',
            'paru_kronik' => 'nullable',
            'kesimpulan' => 'required',
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->with('error', 'There were validation errors.')->withInput();
        }

        // Find the existing record by ID
        $kankerParu = KankerParu::findOrFail($id);

        // Update the record with validated data
        $kankerParu->update(
            array_merge(
                $validator->validated(), // Validated data
                [
                    // Optionally add or modify default values if needed
                    'klaster' => $request->klaster ?? $kankerParu->klaster, // Retain the existing klaster if not passed
                    'poli' => $request->poli ?? $kankerParu->poli, // Retain the existing poli if not passed
                ],
            ),
        );

        // Redirect with success message
        return redirect()->route('kankerParu.lansia.admin')->with('success', 'Data Kanker Paru has been successfully updated!');
    }
    public function viewKankerKolorektal()
    {
        $pasien = Patients::all();
        $kankerKolorektal = KankerKolorektal::all();
        return view('lansia.table.kanker_kolorektal', compact('kankerKolorektal', 'pasien'));
    }
    public function editKankerKolorektal($id)
    {
        $pasien = Patients::all();
        $kankerKolorektal = KankerKolorektal::findOrFail($id);
        return view('lansia.kanker_kolorektal', compact('kankerKolorektal', 'pasien'));
    }
    public function deleteKankerKolorektal($id)
    {
        // Temukan data hepatitis berdasarkan ID
        $kankerKolorektal = KankerKolorektal::findOrFail($id);

        // Hapus data dari database
        $kankerKolorektal->delete();

        // Redirect ke halaman sebelumnya atau halaman daftar dengan pesan sukses
        return redirect()->route('kankerKolorektal.lansia.admin')->with('success', 'Data Kanker Kolorektal berhasil dihapus.');
    }
    public function updateKankerKolorektal(Request $request, $id)
    {
        // Temukan data berdasarkan ID
        $kankerKolorektal = KankerKolorektal::findOrFail($id);

        // Validasi input
        $validator = Validator::make($request->all(), [
            'pasien' => 'required',
            // 'tanggal' => 'required|date',
            // 'jenis_kelamin' => 'required|integer|in:0,1',
            'usia' => 'required|integer|min:0',
            'riwayat_kanker' => 'nullable',
            'merokok' => 'nullable',
            'bercampur_darah' => 'nullable|string|max:255',
            'diare_kronis' => 'nullable|string|max:255',
            'bab_kambing' => 'nullable|string|max:255',
            'konstipasi_kronis' => 'nullable|string|max:255',
            'frekuensi_defekasi' => 'nullable|string|max:255',
            'kesimpulan' => 'required',
        ]);

        // Periksa apakah validasi gagal
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->with('error', 'Terdapat kesalahan validasi.')->withInput();
        }

        // Memperbarui data di database
        $kankerKolorektal->update(
            array_merge(
                $validator->validated(), // Data hasil validasi
                [
                    'klaster' => 3, // Tetap mempertahankan nilai default jika ada
                    'poli' => 'lansia', // Tetap mempertahankan nilai default jika ada
                ],
            ),
        );

        // Redirect dengan pesan sukses
        return redirect()->route('kankerKolorektal.lansia.admin')->with('success', 'Data Kanker Kolorektal berhasil diperbarui!');
    }

    public function viewKankerPayudara()
    {
        $kankerPayudara = KankerPayudara::all();
        return view('lansia.table.kanker_payudara', compact('kankerPayudara'));
    }
    public function editKankerPayudara($id)
    {
        $kankerPayudara = KankerPayudara::findOrFail($id);
        $pasien = Patients::all();
        return view('lansia.kanker_payudara', compact('kankerPayudara', 'pasien'));
    }
    public function deleteKankerPayudara($id)
    {
        // Temukan data hepatitis berdasarkan ID
        $kankerPayudara = KankerPayudara::findOrFail($id);

        // Hapus data dari database
        $kankerPayudara->delete();

        // Redirect ke halaman sebelumnya atau halaman daftar dengan pesan sukses
        return redirect()->route('kankerPayudara.lansia.admin')->with('success', 'Data Kanker Payudara berhasil dihapus.');
    }
    public function updateKankerPayudara(Request $request, $id)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'nomor_klien' => 'required|string|max:255',
            'pasien' => 'required',
            'umur' => 'required|integer|min:1',
            'suku_bangsa' => 'nullable|string|max:255',
            'agama' => 'nullable|string|max:255',
            'berat_badan' => 'nullable|numeric|min:1',
            'tinggi_badan' => 'nullable|numeric|min:1',
            // 'alamat' => 'nullable|string|max:500',
            'perkawinan_pasangan' => 'nullable',
            'klien' => 'nullable',
            // 'pekerjaan_klien' => 'nullable',
            'pekerjaan_suami' => 'nullable',
            // 'pendidikan_terakhir' => 'nullable',
            'jmlh_anak_kandung' => 'nullable|integer|min:0',
            // 'rt_rw' => 'nullable',
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
            'ims' => 'nullable|array',
            'ims.*' => 'string',
            'detail_diobati' => 'nullable',
            'dirujuk' => 'nullable',
            'rujukan' => 'nullable',
            'kesimpulan' => 'required',
        ]);

        // Periksa apakah validasi gagal
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->with('error', 'Terdapat kesalahan validasi.')->withInput();
        }

        // Ambil data yang ingin diupdate
        $kankerPayudara = KankerPayudara::findOrFail($id);

        // Tambahkan nilai default untuk ukuran_benjolan jika kosong
        $validatedData = $validator->validated();
        $validatedData['ukuran_benjolan'] = $validatedData['ukuran_benjolan'] ?? 0;

        // Update data ke database
        $kankerPayudara->update(
            array_merge($validatedData, [
                'klaster' => 3, // Nilai default klaster
                'poli' => 'lansia', // Nilai default poli
            ]),
        );

        // Redirect dengan pesan sukses
        return redirect()
            ->route('kankerPayudara.lansia.admin') // Ganti dengan rute yang sesuai
            ->with('success', 'Data Kanker Payudara berhasil diupdate!');
    }
    public function viewGeriatri()
    {
        $geriatri = Geriatri::with('listPasien')->get();
        return view('lansia.table.geriatri', compact('geriatri'));
    }
    public function editGeriatri($id)
    {
        $geriatri = Geriatri::findOrFail($id);
        $pasien = Patients::all();
        return view('lansia.geriatri', compact('geriatri', 'pasien'));
    }
    public function deleteGeriatri($id)
    {
        // Temukan data hepatitis berdasarkan ID
        $geriatri = Geriatri::findOrFail($id);

        // Hapus data dari database
        $geriatri->delete();

        // Redirect ke halaman sebelumnya atau halaman daftar dengan pesan sukses
        return redirect()->route('geriatri.lansia.admin')->with('success', 'Data Geriatri berhasil dihapus.');
    }
    public function updateGeriatri(Request $request, $id)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'pasien' => 'required',
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
            'kesimpulan' => 'required',
        ]);

        // Periksa apakah validasi gagal
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->with('error', 'Terdapat kesalahan validasi.')->withInput();
        }

        try {
            // Temukan data berdasarkan ID, atau gagal jika tidak ditemukan
            $geriatri = Geriatri::findOrFail($id);

            // Update data
            $geriatri->update(
                array_merge($validator->validated(), [
                    'klaster' => $geriatri->klaster, // Tetap gunakan nilai klaster yang ada
                    'poli' => $geriatri->poli, // Tetap gunakan nilai poli yang ada
                ]),
            );

            // Redirect dengan pesan sukses
            return redirect()
                ->route('geriatri.lansia.admin') // Sesuaikan rute Anda
                ->with('success', 'Data Geriatri berhasil diperbarui!');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            // Jika data tidak ditemukan
            return redirect()->back()->with('error', 'Data Geriatri tidak ditemukan.');
        } catch (\Exception $e) {
            // Tangkap error lainnya
            \Log::error('Update Error:', ['message' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Gagal memperbarui data. Silakan coba lagi.')->withInput();
        }
    }
    public function viewAnemia(Request $request)
    {
        $anemia = Anemia::with('listPasien')->where('poli', 'lansia')->get();
        $routeName = $request->route()->getName();
        return view('kia.table.anemia', compact('anemia', 'routeName'));
    }
    public function viewTbc(Request $request)
    {
        $pasien = Patients::all();
        $tbc = Tbc::with('listPasien')->where('poli', 'lansia')->get();
        $routeName = $request->route()->getName();
        return view('kia.table.tbc', compact('tbc', 'pasien', 'routeName'));
    }
    public function viewKecacingan()
    {
        $kecacingan = Kecacingan::with('listPasien')->where('poli', 'lansia')->get();
        return view('kia.table.kecacingan', compact('kecacingan'));
    }
    public function viewHipertensi(Request $request)
    {
        $hipertensi = Hipertensi::with('listPasien')->where('poli', 'lansia')->get();
        $routeName = $request->route()->getName();
        return view('kia.table.hipertensi', compact('hipertensi', 'routeName'));
    }
    public function viewTalasemia(Request $request)
    {
        $talasemia = Talasemia::with('listPasien')->where('poli', 'lansia')->get();
        $routeName = $request->route()->getName();
        return view('kia.table.talasemia', compact('talasemia', 'routeName'));
    }
}
