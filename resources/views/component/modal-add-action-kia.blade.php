<style>
    .custom-radio {
        width: 20px;
        /* Mengatur ukuran lebar radio button */
        height: 20px;
        /* Mengatur ukuran tinggi radio button */
        margin-right: 10px;
        /* Memberi jarak antara radio button dan label */
        vertical-align: middle;
        /* Menjaga radio button berada di tengah secara vertikal */
    }


    .form-check-inline {
        margin-right: 15px;
        /* Memberi jarak antara setiap pilihan */
    }
</style>
<!-- Modal Add Action -->
<div class="modal fade" style="z-index: 1050;" id="addActionModal" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header bg-primary">

                <h5 class="modal-title" id="exampleModalLabel">TINDAKAN KIA</h5>

                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form id="addPatientForm" action="" method="POST" class="px-3">
                    <div id="formSection1" class="form-section">
                        @csrf
                        <input type="hidden" name="tipe" id="tipe" value="poli-kia">
                        <input type="hidden" name="action_id" id="action_id">
                        <div class="row">
                            <div class="col-4">
                                <h5>Detail Pasien</h5>
                                <div id="patientDetails"
                                    style="display:none; margin-top: 10px; padding: 10px; border-radius: 5px;">
                                    <p><strong>N I K</strong> : <span id="displayNIK"></span></p>
                                    <p><strong>Nama Pasien</strong> : <span id="displayName"></span></p>
                                    {{-- <p><strong>J.Kelamin</strong> : <span id="displayGender"></span></p> --}}
                                    <p><strong>Umur</strong> : <span id="displayAge"></span></p>
                                    <p><strong>Telepon/WA</strong> : <span id="displayPhone"></span></p>
                                    <p><strong>Alamat</strong> : <span id="displayAddress"></span></p>
                                    <p><strong>Darah</strong> : <span id="displayBlood"></span></p>
                                    {{-- <p><strong>Pendidikan</strong> : <span id="displayEducation"></span></p> --}}
                                    {{-- <p><strong>Pekerjaan</strong> : <span id="displayJob"></span></p> --}}
                                    <p><strong>Nomor RM</strong> : <span id="displayRmNumber"></span></p>
                                </div>
                            </div>
                            <div class="row col-8">
                                <div class="col-12">
                                    <div class="row g-2">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="nik">Cari Pasien</label>
                                                <div class="input-group">
                                                    <input type="text" hidden id="idAction" name="idAction"
                                                        value="">
                                                    <input readonly type="text" class="form-control" id="nik"
                                                        name="nik" placeholder="NIK">
                                                    <div class="input-group-append">
                                                        <button class="btn btn-primary" type="button" id="btnCariNIK"
                                                            data-bs-toggle="modal" data-bs-target="#modalPasienDokter">
                                                            Cari
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="tanggal">Tanggal</label>
                                                <input type="date" class="form-control" id="tanggal" name="tanggal"
                                                    placeholder="Pilih Tanggal">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="doctor">Dokter</label>
                                                <select class="form-control" id="doctor" name="doctor">
                                                    <option value="" disabled selected>Pilih Dokter</option>
                                                    @foreach ($dokter as $item)
                                                        <option value="{{ $item['name'] }}">{{ $item['name'] }}</option>
                                                    @endforeach

                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="kasus">Kasus</label>
                                                <select class="form-control" id="kasus" name="kasus">
                                                    <option value="" disabled selected>Pilih Jenis Kasus
                                                    </option>
                                                    <option value="1">Baru </option>
                                                    <option value="0">Lama </option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="row g-2">

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="jenis_kartu">Jenis Kartu</label>
                                                <input type="text" class="form-control" id="jenis_kartu"
                                                    name="jenis_kartu" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="nomor_kartu">Nomor Kartu</label>
                                                <input type="text" class="form-control" id="nomor_kartu"
                                                    name="nomor_kartu" placeholder="Masukkan Nomor" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="wilayah_faskes">Wilayah Faskes</label>
                                                <input type="text" class="form-control" id="wilayah_faskes"
                                                    name="wilayah_faskes" placeholder="Wilayah Faskes" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <label for="keluhan" style="color: rgb(241, 11, 11);">Keluhan</label>
                                    <textarea class="form-control" id="keluhan" name="keluhan" placeholder="Keluhan"></textarea>
                                </div>
                                <div class="col-md-12">
                                    <label for="riwayat_penyakit_sekarang" style="color: rgb(241, 11, 11);">Riwayat
                                        Penyakit Sekarang</label>
                                    <textarea class="form-control" id="riwayat_penyakit_sekarang" name="riwayat_penyakit_sekarang"
                                        placeholder="Riwayat Penyakit Sekarang"></textarea>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="riwayat_penyakit_dulu" style="color: rgb(241, 11, 11);">Riwayat
                                            Penyakit Terdahulu</label>
                                        <select class="form-control" id="riwayat_penyakit_dulu"
                                            name="riwayat_penyakit_dulu">
                                            <option value="" disabled selected>Pilih</option>
                                            <option value="hipertensi">Hipertensi</option>
                                            <option value="dm">DM</option>
                                            <option value="jantung">Jantung</option>
                                            <option value="stroke">Stroke</option>
                                            <option value="asma">Asma</option>
                                            <option value="liver">Liver</option>
                                            <option value="ginjal">Ginjal</option>
                                            <option value="tb">TB</option>
                                            <option value="lainnya">Lainnya</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12 mt-2" id="penyakit_lainnya_container" style="display: none;">
                                    <label for="penyakit_lainnya" style="color: rgb(241, 11, 11);">Sebutkan
                                        Penyakit Lainnya</label>
                                    <textarea class="form-control" id="riwayat_penyakit_lainnya" name="riwayat_penyakit_lainnya"
                                        placeholder="Isi penyakit lainnya"></textarea>
                                </div>
                                <div class="col-md-12">
                                    <label for="riwayat_pengobatan" style="color: rgb(241, 11, 11);">Riwayat
                                        Pengobatan</label>
                                    <textarea class="form-control" id="riwayat_pengobatan" name="riwayat_pengobatan" placeholder="Riwayat Pengobatan"></textarea>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="riwayat_penyakit_keluarga"
                                            style="color: rgb(241, 11, 11);">Riwayat
                                            Penyakit Keluarga</label>
                                        <select class="form-control" id="riwayat_penyakit_keluarga"
                                            name="riwayat_penyakit_keluarga">
                                            <option value="" disabled selected>Pilih</option>
                                            <option value="hipertensi">Hipertensi</option>
                                            <option value="dm">DM</option>
                                            <option value="jantung">Jantung</option>
                                            <option value="stroke">Stroke</option>
                                            <option value="asma">Asma</option>
                                            <option value="liver">Liver</option>
                                            <option value="ginjal">Ginjal</option>
                                            <option value="tb">TB</option>
                                            <option value="lainnya">Lainnya</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12 mt-2" id="penyakit_lainnya_keluarga_container"
                                    style="display: none;">
                                    <label for="penyakit_lainnya_keluarga" style="color: rgb(241, 11, 11);">Sebutkan
                                        Penyakit Lainnya</label>
                                    <textarea class="form-control" id="riwayat_penyakit_lainnya_keluarga" name="riwayat_penyakit_lainnya_keluarga"
                                        placeholder="Isi penyakit lainnya"></textarea>
                                </div>
                                <div class="col-md-12">
                                    <label for="riwayat_alergi" style="color: rgb(241, 11, 11);">Riwayat
                                        Alergi</label>
                                    <textarea class="form-control" id="riwayat_alergi" name="riwayat_alergi" placeholder="Riwayat Alergi"></textarea>
                                </div>
                                <div class="row mt-3">

                                    <div class="col-md-12">
                                        <label for="alkohol" style="color: rgb(19, 11, 241);">KETERANGAN</label>
                                        <input type="text" class="form-control" id="keterangan" name="keterangan"
                                            placeholder="Keterangan">
                                    </div>


                                </div>


                            </div>
                            <div style="display: flex; align-items: center; text-align: center;">
                                <hr style="flex: 1; border: none; border-top: 1px solid #ccc;">
                                <span style="margin: 0 10px; white-space: nowrap;">Pelayanan ANC</span>
                                <hr style="flex: 1; border: none; border-top: 1px solid #ccc;">
                            </div>

                            <div class="col-12">
                                <div class="row g-2">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="usia_hamil">Usia kehamilan </label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" id="usia_hamil"
                                                    name="usia_kehamilan" placeholder="Masukkan usia kehamilan">
                                                <span class="input-group-text">minggu</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="jenis_anc">Jenis ANC</label>
                                            <select class="form-control" id="jenis_anc" name="jenis_anc">
                                                <option value="" disabled selected>Pilih jenis ANC</option>
                                                <option value="anc1">ANC 1</option>
                                                <option value="anc2">ANC II</option>
                                                <option value="anc3">ANC III</option>
                                                <option value="anc4">ANC IV</option>
                                                <option value="anc5">ANC V</option>
                                                <option value="anc6">ANC VI</option>

                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="lingkar_lengan_atas">Lingkar lengan atas </label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" id="lingkar_lengan_atas"
                                                    name="lingkar_lengan_atas"
                                                    placeholder="Masukkan lingkar lengan atas">
                                                <span class="input-group-text">cm</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="tinggi_fundus_uteri">Tinggi fundus uteri</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" id="tinggi_fundus_uteri"
                                                    name="tinggi_fundus_uteri"
                                                    placeholder="Masukkan tinggi fundus uteri">
                                                <span class="input-group-text">cm</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="presentansi_janin">Presentasi janin</label>
                                            <select class="form-control" id="presentansi_janin"
                                                name="presentasi_janin">
                                                <option value="" disabled selected>Pilih presentasi janin
                                                </option>
                                                <option value="kepala">Kepala</option>
                                                <option value="sungsang">Sungsang</option>
                                                <option value="melintang">Melintang</option>
                                                <option value="lain-lain">Lain-lain</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="denyut_jantung">Denyut nyantung </label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" id="denyut_jantung"
                                                    name="denyut_jantung" placeholder="Masukkan denyut jantung">
                                                <span class="input-group-text">bpm</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-4">
                                    <label>Kaki Bengkak</label>
                                    <div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input custom-radio" type="radio"
                                                name="kaki_bengkak" id="kaki_bengkak_ya" value="1">
                                            <label class="form-check-label" for="kaki_bengkak_ya">Ya</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input custom-radio" type="radio"
                                                name="kaki_bengkak" id="kaki_bengkak_tidak" value="0">
                                            <label class="form-check-label" for="kaki_bengkak_tidak">Tidak</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <label>Diberikan Imunisasi TT</label>
                                    <div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input custom-radio" type="radio"
                                                name="imunisasi_tt" id="imunisasi_tt_ya" value="1">
                                            <label class="form-check-label" for="imunisasi_tt_ya">Ya</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input custom-radio" type="radio"
                                                name="imunisasi_tt" id="imunisasi_tt_tidak" value="0">
                                            <label class="form-check-label" for="imunisasi_tt_tidak">Tidak</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <label>Diberikan Tablet FE</label>
                                    <div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input custom-radio" type="radio"
                                                name="tablet_fe" id="tablet_fe_ya" value="1">
                                            <label class="form-check-label" for="tablet_fe_ya">Ya</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input custom-radio" type="radio"
                                                name="tablet_fe" id="tablet_fe_tidak" value="0">
                                            <label class="form-check-label" for="tablet_fe_tidak">Tidak</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4 mt-3">
                                    <label>Status Kehamilan</label>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <input type="text" class="form-control" id="gravida" name="gravida"
                                                placeholder="Gravida">
                                        </div>
                                        <div class="col-md-4">
                                            <input type="text" class="form-control" id="partus" name="partus"
                                                placeholder="Partus">
                                        </div>
                                        <div class="col-md-4">
                                            <input type="text" class="form-control" id="abortus" name="abortus"
                                                placeholder="Abortus">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4 mt-3">
                                    <label>Nilai Hb</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="nilai_hb" name="nilai_hb"
                                            placeholder="Masukkan Nilai Hb">
                                        <span class="input-group-text">g/dl</span>
                                    </div>
                                </div>

                                <div class="col-md-4 mt-3">
                                    <label>Proteinuria</label>
                                    <div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input custom-radio" type="radio"
                                                name="proteinuria" id="proteinuria_positif" value="1">
                                            <label class="form-check-label" for="proteinuria_positif">Positif</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input custom-radio" type="radio"
                                                name="proteinuria" id="proteinuria_negatif" value="0">
                                            <label class="form-check-label" for="proteinuria_negatif">Negatif</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div style="display: flex; align-items: center; text-align: center;">
                                <hr style="flex: 1; border: none; border-top: 1px solid #ccc;">
                                <span style="margin: 0 10px; white-space: nowrap;">Hasil Test Triple Eliminasi</span>
                                <hr style="flex: 1; border: none; border-top: 1px solid #ccc;">
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-3">
                                    <label>HIV</label>
                                    <div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input custom-radio" type="radio"
                                                name="hiv" id="hiv_reaktif" value="reaktif">
                                            <label class="form-check-label" for="hiv_reaktif">Reaktif</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input custom-radio" type="radio"
                                                name="hiv" id="hiv_non_reaktif" value="non-reaktif">
                                            <label class="form-check-label" for="hiv_non_reaktif">Non-Reaktif</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input custom-radio" type="radio"
                                                name="hiv" id="hiv_tdk_tersedia" value="tidak-tersedia">
                                            <label class="form-check-label" for="hiv_tdk_tersedia">Tidak
                                                Tersedia</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <label>Sifilis</label>
                                    <div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input custom-radio" type="radio"
                                                name="sifilis" id="sifilis_reaktif" value="reaktif">
                                            <label class="form-check-label" for="sifilis_reaktif">Reaktif</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input custom-radio" type="radio"
                                                name="sifilis" id="sifilis_non_reaktif" value="non-reaktif">
                                            <label class="form-check-label"
                                                for="sifilis_non_reaktif">Non-Reaktif</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input custom-radio" type="radio"
                                                name="sifilis" id="sifilis_tdk_tersedia" value="tidak-tersedia">
                                            <label class="form-check-label" for="sifilis_tdk_tersedia">Tidak
                                                Tersedia</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <label>Hepatitis</label>
                                    <div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input custom-radio" type="radio"
                                                name="hepatitis" id="hepatitis_reaktif" value="reaktif">
                                            <label class="form-check-label" for="hepatitis_reaktif">Reaktif</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input custom-radio" type="radio"
                                                name="hepatitis" id="hepatitis_non_reaktif" value="non-reaktif">
                                            <label class="form-check-label"
                                                for="hepatitis_non_reaktif">Non-Reaktif</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input custom-radio" type="radio"
                                                name="hepatitis" id="hepatitis_tdk_tersedia" value="tidak-tersedia">
                                            <label class="form-check-label" for="hepatitis_tdk_tersedia">Tidak
                                                Tersedia</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <label>Dengan pemeriksaan USG</label>
                                    <div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input custom-radio" type="radio"
                                                name="periksa_usg" id="periksa_usg_ya" value="1">
                                            <label class="form-check-label" for="periksa_usg_ya">Ya</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input custom-radio" type="radio"
                                                name="periksa_usg" id="periksa_usg_tidak" value="0">
                                            <label class="form-check-label" for="periksa_usg_tidak">Tidak</label>
                                        </div>
                                    </div>
                                </div>


                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mt-3">
                                <label for="alkohol" style="color: rgb(19, 11, 241);">DIAGNOSA</label>
                                <select class="form-control" id="diagnosa" name="diagnosa[]" multiple>
                                    @foreach ($diagnosa as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}-{{ $item->icd10 }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mt-3">
                                <label for="hasil_usg">Hasil USG</label>
                                <textarea class="form-control" id="hasil_usg" name="hasil_usg" placeholder="Hasil USG"></textarea>
                            </div>
                            <div class="col-md-6 mt-3">
                                <div class="form-group">
                                    <label for="skrining" class="form-label">Hasil Skrining</label>
                                    <button class="btn btn-primary w-100 mt-2" type="button" id="btnCariSkrining"
                                        data-bs-toggle="modal" data-bs-target="#modalSkrining">
                                        Hasil Skrining
                                    </button>

                                </div>
                            </div>
                            <div class="col-md-6 mt-3">
                                <div class="form-group">
                                    <label for="skrining" class="form-label">Riwayat Berobat</label>
                                    <button class="btn btn-success w-100 mt-2" type="button"
                                        id="btnCariRiwayatBerobat" data-bs-toggle="modal"
                                        data-bs-target="#modalBerobat">
                                        Riwayat Berobat
                                    </button>

                                </div>
                            </div>
                            <div class="col-md-6 mt-3">
                                <label for="treatment_anc">Treatment ANC</label>
                                <textarea class="form-control" id="treatment_anc" name="treatment_anc" placeholder="Treatment ANC"></textarea>
                            </div>
                            <div class="col-md-6 mt-3">
                                <label for="kesimpulan">Kesimpulan</label>
                                <textarea class="form-control" id="kesimpulan" name="kesimpulan" placeholder="Kesimpulan"></textarea>
                            </div>
                            <div class="col-md-6 mt-3">
                                <label for="tanggal_kembali">Tanggal kembali</label>
                                <input type="date" class="form-control" name="tanggal_kembali"
                                    id="tanggal_kembali" placeholder="Pilih Tanggal">
                            </div>
                            <div class="col-md-6 mt-3">
                                <label for="obat" style="color: rgb(19, 11, 241);">Obat</label>
                                <textarea class="form-control" id="obat" name="obat" placeholder="Obat"></textarea>
                            </div>
                            {{-- <div class="col-md-6 mt-3">
                                <label for="pemeriksaan_penunjang">Pemeriksaan Penunjang</label>
                                <textarea class="form-control" id="pemeriksaan_penunjang" name="pemeriksaan_penunjang"
                                    placeholder="Pemeriksaan penunjang"></textarea>
                            </div>
                            <div class="col-md-6 mt-3">
                                <label for="hasil_lab" style="color: rgb(19, 11, 241);">Hasil Laboratorium</label>
                                <textarea class="form-control" id="hasil_lab" name="hasil_lab" placeholder="Hasil Laboratorium"></textarea>
                            </div> --}}
                        </div>
                    </div>

                    <div id="formSection2" class="form-section d-none">
                        <h6>Jenis Pemeriksaan Darah</h6>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="gds"
                                        name="jenis_pemeriksaan[]" value="GDS">
                                    <label class="form-check-label" for="gds">GDS</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="gdp"
                                        name="jenis_pemeriksaan[]" value="GDP">
                                    <label class="form-check-label" for="gdp">GDP</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="gdp_2_jam_pp"
                                        name="jenis_pemeriksaan[]" value="GDP 2 Jam pp">
                                    <label class="form-check-label" for="gdp_2_jam_pp">GDP 2 Jam pp</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="cholesterol"
                                        name="jenis_pemeriksaan[]" value="Cholesterol">
                                    <label class="form-check-label" for="cholesterol">Cholesterol</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="asam_urat"
                                        name="jenis_pemeriksaan[]" value="Asam Urat">
                                    <label class="form-check-label" for="asam_urat">Asam Urat</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="leukosit"
                                        name="jenis_pemeriksaan[]" value="Leukosit">
                                    <label class="form-check-label" for="leukosit">Leukosit</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="eritrosit"
                                        name="jenis_pemeriksaan[]" value="Eritrosit">
                                    <label class="form-check-label" for="eritrosit">Eritrosit</label>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="trombosit"
                                        name="jenis_pemeriksaan[]" value="Trombosit">
                                    <label class="form-check-label" for="trombosit">Trombosit</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="hemoglobin"
                                        name="jenis_pemeriksaan[]" value="Hemoglobin">
                                    <label class="form-check-label" for="hemoglobin">Hemoglobin</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="sifilis"
                                        name="jenis_pemeriksaan[]" value="Sifilis">
                                    <label class="form-check-label" for="sifilis">Sifilis</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="hiv"
                                        name="jenis_pemeriksaan[]" value="HIV">
                                    <label class="form-check-label" for="hiv">HIV</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="golongan_darah"
                                        name="jenis_pemeriksaan[]" value="Golongan Darah">
                                    <label class="form-check-label" for="golongan_darah">Golongan Darah</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="widal"
                                        name="jenis_pemeriksaan[]" value="Widal">
                                    <label class="form-check-label" for="widal">Widal</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="malaria"
                                        name="jenis_pemeriksaan[]" value="Malaria">
                                    <label class="form-check-label" for="malaria">Malaria</label>
                                </div>
                            </div>
                        </div>
                        <!-- Tambahan Pemeriksaan URINE -->
                        <h6>Jenis Pemeriksaan URINE</h6>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="albumin"
                                name="jenis_pemeriksaan[]" value="Albumin">
                            <label class="form-check-label" for="albumin">Albumin</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="reduksi"
                                name="jenis_pemeriksaan[]" value="Reduksi">
                            <label class="form-check-label" for="reduksi">Reduksi</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="urinalisa"
                                name="jenis_pemeriksaan[]" value="Urinalisa">
                            <label class="form-check-label" for="urinalisa">Urinalisa</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="tes_kehamilan"
                                name="jenis_pemeriksaan[]" value="Tes Kehamilan">
                            <label class="form-check-label" for="tes_kehamilan">Tes Kehamilan</label>
                        </div>

                        <!-- Tambahan Pemeriksaan FESES -->
                        <h6>Jenis Pemeriksaan FESES</h6>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="telur_cacing"
                                name="jenis_pemeriksaan[]" value="Telur Cacing">
                            <label class="form-check-label" for="telur_cacing">Telur Cacing</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="bta"
                                name="jenis_pemeriksaan[]" value="BTA">
                            <label class="form-check-label" for="bta">BTA</label>
                        </div>

                        <!-- Tambahan Pemeriksaan IgM -->
                        <h6>Pemeriksaan IgM</h6>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="igm_dbd"
                                name="jenis_pemeriksaan[]" value="IgM DBD">
                            <label class="form-check-label" for="igm_dbd">IgM DBD</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="igm_typhoid"
                                name="jenis_pemeriksaan[]" value="IgM Typhoid">
                            <label class="form-check-label" for="igm_typhoid">IgM Typhoid</label>
                        </div>
                    </div>
            </div>

            <div class="modal-footer">

                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-success" id="nextSectionButton">Lanjut
                    Pemeriksaan</button>
                <button type="submit" class="btn btn-primary">Simpan Data</button>
                </form>
            </div>
        </div>

    </div>

</div>




@include('component.modal-table-pasien-dokter')
@include('component.modal-skrining')
@include('component.modal-berobat')



<style>
    .select2-dropdown {
        z-index: 9999 !important;
    }

    .select2-container {
        z-index: 1060 !important;
        /* Pastikan dropdown Select2 berada di atas modal */
    }
</style>



<script>
    $(document).ready(function() {
        $('#diagnosa').select2({
            placeholder: "Pilih",
            allowClear: true,
            minimumResultsForSearch: 0
        });
    });
    document.addEventListener('DOMContentLoaded', function() {
        let currentSection = 1;
        document.getElementById('nextSectionButton').addEventListener('click', function() {
            const section1 = document.getElementById('formSection1');
            const section2 = document.getElementById('formSection2');
            const button = this;

            if (section1.classList.contains('d-none')) {
                // Kembali ke Section 1
                section1.classList.remove('d-none');
                section2.classList.add('d-none');
                button.textContent = 'Lanjut Pemeriksaan';
            } else {
                // Lanjut ke Section 2
                section1.classList.add('d-none');
                section2.classList.remove('d-none');
                button.textContent = 'Kembali';
            }
        });
        const selectElement = document.getElementById('riwayat_penyakit_dulu');
        const selectPenyakitKeluargaElement = document.getElementById('riwayat_penyakit_keluarga');
        const lainnyaContainer = document.getElementById('penyakit_lainnya_container');
        const lainnyaTextarea = document.getElementById('riwayat_penyakit_lainnya');
        const lainnyaKeluargaContainer = document.getElementById('penyakit_lainnya_keluarga_container');
        const lainnyaKeluargaTextarea = document.getElementById('riwayat_penyakit_lainnya_keluarga');

        if (selectElement && selectPenyakitKeluargaElement) {
            selectElement.addEventListener('change', function() {
                if (this.value === 'lainnya') {
                    lainnyaContainer.style.display = 'block';
                } else {
                    lainnyaContainer.style.display = 'none';
                    lainnyaTextarea.value = '';
                }
            });

            selectPenyakitKeluargaElement.addEventListener('change', function() {
                if (this.value === 'lainnya') {
                    lainnyaKeluargaContainer.style.display = 'block';
                } else {
                    lainnyaKeluargaContainer.style.display = 'none';
                    lainnyaKeluargaTextarea.value = '';
                }
            });
        } else {
            console.error("Elemen tidak ditemukan!");
        }
        @if (session('success'))
            Swal.fire({
                title: 'Success!',
                text: "{{ session('success') }}",
                icon: 'success',
                confirmButtonText: 'OK'
            });
        @endif

        // Display error message if validation errors exist
        @if ($errors->any())
            Swal.fire({
                title: 'Error!',
                html: '<ul>' +
                    '@foreach ($errors->all() as $error)' +
                    '<li>{{ $error }}</li>' +
                    '@endforeach' +
                    '</ul>',
                icon: 'error',
                confirmButtonText: 'OK'
            });
        @endif
    });
    // Display success message if session has a success
</script>
