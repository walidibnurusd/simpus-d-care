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
<div class="modal fade" style="z-index: 1050;" id="addActionModal" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header bg-primary">

                <h5 class="modal-title" id="exampleModalLabel">TINDAKAN KB</h5>

                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form id="addPatientForm" action="" method="POST" class="px-3">
                    @csrf
                    <input type="hidden" name="tipe" id="tipe" value="poli-kb">
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
                                                        data-bs-toggle="modal" data-bs-target="#modalPasien">
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
                                            <label for="kunjungan">Kunjungan</label>
                                            <select class="form-control" id="kunjungan" name="kunjungan">
                                                <option value="" disabled selected>Pilih Jenis Kunjungan</option>
                                                <option value="baru">Baru </option>
                                                <option value="lama">Lama </option>

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
                                            <select class="form-control" id="wilayah_faskes" name="faskes">
                                                <option value="" disabled selected>Pilih Wilayah Faskes</option>
                                                <option value="ya">Ya</option>
                                                <option value="tidak">Tidak</option>

                                            </select>
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
                                <textarea class="form-control" id="penyakit_lainnya" name="riwayat_penyakit_lainnya"
                                    placeholder="Isi penyakit lainnya"></textarea>
                            </div>
                            <div class="col-md-12">
                                <label for="riwayat_pengobatan" style="color: rgb(241, 11, 11);">Riwayat
                                    Pengobatan</label>
                                <textarea class="form-control" id="riwayat_pengobatan" name="riwayat_pengobatan" placeholder="Riwayat Pengobatan"></textarea>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="riwayat_penyakit_keluarga" style="color: rgb(241, 11, 11);">Riwayat
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
                                <textarea class="form-control" id="penyakit_lainnya_keluarga" name="riwayat_penyakit_lainnya_keluarga"
                                    placeholder="Isi penyakit lainnya"></textarea>
                            </div>
                            <div class="col-md-12">
                                <label for="riwayat_alergi" style="color: rgb(241, 11, 11);">Riwayat
                                    Alergi</label>
                                <textarea class="form-control" id="riwayat_alergi" name="riwayat_alergi" placeholder="Riwayat Alergi"></textarea>
                            </div>

                        </div>
                        <div style="display: flex; align-items: center; text-align: center;">
                            <hr style="flex: 1; border: none; border-top: 1px solid #ccc;">
                            <span style="margin: 0 10px; white-space: nowrap;">Pelayanan KB</span>
                            <hr style="flex: 1; border: none; border-top: 1px solid #ccc;">
                        </div>

                        <div class="row mt-3">
                            <div class="row g-2">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="layanan_kb">Jenis Pelayanan KB</label>
                                        <select class="form-control" id="layanan_kb" name="layanan_kb">
                                            <option value="" disabled selected>Pilih</option>
                                            <option value="1">Pelayanan KB : Suntik</option>
                                            <option value="2">Pelayanan KB : Pencabutan IUD (AKDR)</option>
                                            <option value="3">Pelayanan KB : Pemasangan IUD (AKDR)</option>
                                            <option value="4">Pelayanan KB : Pemasangan dan Pencabutan IUD (AKDR)
                                            </option>
                                            <option value="5">Pelayanan KB : Pencabutan Implant</option>
                                            <option value="6">Pelayanan KB : Pemasangan Implant</option>
                                            <option value="7">Pelayanan KB : Pemasangan dan Pencabutan Implant
                                            </option>
                                            <option value="8">MOP / Vasektomi
                                            </option>

                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="jmlh_anak_laki">Jmlh. Anak Hidup (Laki-laki) </label>
                                        <div class="input-group">
                                            <input type="number" class="form-control" id="jmlh_anak_laki"
                                                name="jmlh_anak_laki" placeholder="0">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="jmlh_anak_perempuan">Jmlh. Anak Hidup (Perempuan) </label>
                                        <div class="input-group">
                                            <input type="number" class="form-control" id="jmlh_anak_perempuan"
                                                name="jmlh_anak_perempuan" placeholder="0">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="status_kb">Status Peserta KB</label>
                                        <select class="form-control" id="status_kb" name="status_kb">
                                            <option value="" disabled selected>Pilih</option>
                                            <option value="1">Baru Pertama Kali</option>
                                            <option value="2">Sesudah Bersalin</option>
                                            <option value="3">Pindah Tempat Pelayanan, Ganti Cara</option>
                                            <option value="4">Pindah Tempat Pelayanan, Cara Sama
                                            </option>
                                            <option value="5">Tempat Pelayanan Sama, Ganti Cara</option>
                                            <option value="6">Tempat Pelayanan Sama, Cara Sama/Lanjutkan</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="row g-2">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="tgl_lahir_anak_bungsu">Tgl.Lahir Anak Terkecil</label>
                                        <div class="input-group">
                                            <input type="date" class="form-control" id="tgl_lahir_anak_bungsu"
                                                name="tgl_lahir_anak_bungsu">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="kb_terakhir">Cara KB Terakhir</label>
                                        <select class="form-control" id="kb_terakhir" name="kb_terakhir">
                                            <option value="" disabled selected>Pilih</option>
                                            <option value="1">Tidak Ada</option>
                                            <option value="2">IUD</option>
                                            <option value="3">MOP</option>
                                            <option value="4">MOW
                                            </option>
                                            <option value="5">Kondom</option>
                                            <option value="6">Implant</option>
                                            <option value="7">Suntikan</option>
                                            <option value="8">Pil</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="tgl_kb_terakhir">Tgl.KB Terakhir</label>
                                        <div class="input-group">
                                            <input type="date" class="form-control" id="tgl_kb_terakhir"
                                                name="tgl_kb_terakhir">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="keadaan_umum">Keadaan Umum</label>
                                        <select class="form-control" id="keadaan_umum" name="keadaan_umum">
                                            <option value="" disabled selected>Pilih</option>
                                            <option value="1">Baik</option>
                                            <option value="2">Sedang</option>
                                            <option value="3">Kurang</option>
                                        </select>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-3">
                                <label>Informed Concern</label>
                                <div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input custom-radio" type="radio"
                                            name="informed_concern" id="informed_concern_ya" value="1">
                                        <label class="form-check-label" for="informed_concern_ya">Ada</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input custom-radio" type="radio"
                                            name="informed_concern" id="informed_concern_tidak" value="0">
                                        <label class="form-check-label" for="informed_concern_tidak">Tidak</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label>Hamil/Diduga hamil</label>
                                <div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input custom-radio" type="radio" name="hamil"
                                            id="hamil_ya" value="1">
                                        <label class="form-check-label" for="hamil_ya">Ya</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input custom-radio" type="radio" name="hamil"
                                            id="hamil_tidak" value="0">
                                        <label class="form-check-label" for="hamil_tidak">Tidak</label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <label>Sakit Kuning</label>
                                <div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input custom-radio" type="radio"
                                            name="sakit_kuning" id="sakit_kuning_ya" value="1">
                                        <label class="form-check-label" for="sakit_kuning_ya">Ya</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input custom-radio" type="radio"
                                            name="sakit_kuning" id="sakit_kuning_tidak" value="0">
                                        <label class="form-check-label" for="sakit_kuning_tidak">Tidak</label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <label>Pendarahan Pervaginaan</label>
                                <div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input custom-radio" type="radio"
                                            name="pendarahan_vagina" id="pendarahan_vagina_ya" value="1">
                                        <label class="form-check-label" for="pendarahan_vagina_ya">Ya</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input custom-radio" type="radio"
                                            name="pendarahan_vagina" id="pendarahan_vagina_tidak" value="0">
                                        <label class="form-check-label" for="pendarahan_vagina_tidak">Tidak</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 mt-3">
                                <label>Tumor</label>
                                <div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input custom-radio" type="radio" name="tumor"
                                            id="tumor_ya" value="1">
                                        <label class="form-check-label" for="tumor_ya">Ya</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input custom-radio" type="radio" name="tumor"
                                            id="tumor_tidak" value="0">
                                        <label class="form-check-label" for="tumor_tidak">Tidak</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 mt-3">
                                <label>IMS/HIV/AIDS</label>
                                <div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input custom-radio" type="radio" name="hiv"
                                            id="hiv_ya" value="1">
                                        <label class="form-check-label" for="hiv_ya">Ya</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input custom-radio" type="radio" name="hiv"
                                            id="hiv_tidak" value="0">
                                        <label class="form-check-label" for="hiv_tidak">Tidak</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 mt-3">
                                <label>Tanda Tanda Diabetes</label>
                                <div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input custom-radio" type="radio" name="diabetes"
                                            id="diabetes_ya" value="1">
                                        <label class="form-check-label" for="diabetes_ya">Ya</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input custom-radio" type="radio" name="diabetes"
                                            id="diabetes_tidak" value="0">
                                        <label class="form-check-label" for="diabetes_tidak">Tidak</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 mt-3">
                                <label>Kelainan Pembekuan Darah</label>
                                <div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input custom-radio" type="radio"
                                            name="pembekuan_darah" id="pembekuan_darah_ya" value="1">
                                        <label class="form-check-label" for="pembekuan_darah_ya">Ya</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input custom-radio" type="radio"
                                            name="pembekuan_darah" id="pembekuan_darah_tidak" value="0">
                                        <label class="form-check-label" for="pembekuan_darah_tidak">Tidak</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-md-6 mt-3">
                            <label for="pemeriksaan_penunjang">Pemeriksaan Penunjang</label>
                            <textarea class="form-control" id="pemeriksaan_penunjang" name="pemeriksaan_penunjang"
                                placeholder="Pemeriksaan penunjang"></textarea>
                        </div>
                        <div class="col-md-6 mt-3">
                            <label for="kesimpulan">Kesimpulan</label>
                            <textarea class="form-control" id="kesimpulan" name="kesimpulan" placeholder="Kesimpulan"></textarea>
                        </div>
                        <div class="col-md-6 mt-3">
                            <label for="obat" style="color: rgb(19, 11, 241);">Obat</label>
                            <textarea class="form-control" id="obat" name="obat" placeholder="Obat"></textarea>
                        </div>
                    </div>


            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-primary">Simpan Data</button>
                </form>
            </div>
        </div>

    </div>

</div>




@include('component.modal-table-pasien-dokter')
@include('component.modal-skrining')



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
    document.addEventListener('DOMContentLoaded', function() {

        const selectElement = document.getElementById('riwayat_penyakit_dulu');
        const selectPenyakitKeluargaElement = document.getElementById('riwayat_penyakit_keluarga');
        const lainnyaContainer = document.getElementById('penyakit_lainnya_container');
        const lainnyaTextarea = document.getElementById('penyakit_lainnya');
        const lainnyaKeluargaContainer = document.getElementById('penyakit_lainnya_keluarga_container');
        const lainnyaKeluargaTextarea = document.getElementById('penyakit_lainnya_keluarga');

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
