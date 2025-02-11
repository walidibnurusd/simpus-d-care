<style>
    .custom-radio {

        margin-right: 5px;
        /* Jarak antara radio button dan label */
        vertical-align: middle;
        /* Selaraskan dengan teks */
        width: 20px;
        /* Mengatur ukuran lebar radio button */
        height: 20px;
        /* Kembalikan ukuran default */
        appearance: radio;
        /* Pastikan tampil sebagai radio button default */
    }

    .custom-radio-container {
        display: flex;
        align-items: center;
        gap: 10px;
        /* Jarak antar radio button */
    }

    .custom-radio-label {
        font-size: 14px;
        /* Ukuran teks label */
        vertical-align: middle;
        /* Selaraskan dengan radio button */
    }
</style>
<!-- Modal Add Action -->
<div class="modal fade" style="z-index: 1050;" id="editActionModal{{ $action->id }}" tabindex="-1"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title" id="exampleModalLabel">TINDAKAN KB</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form id="addPatientForm" action="{{ route('action.update', $action->id) }}" method="POST"
                    class="px-3">
                    @csrf
                    <input type="hidden" name="tipe" id="tipe" value="poli-kb">
                    <div class="row">
                        <div class="col-4">
                            <h5>Detail Pasien</h5>
                            <div id="patientDetailsEdit" style=" margin-top: 10px; padding: 10px; border-radius: 5px;">
                                <p><strong>N I K</strong> : <span
                                        id="NIK{{ $action->id }}">{{ $action->patient->nik }}</span></p>
                                <p><strong>Nama Pasien</strong> : <span
                                        id="Name{{ $action->id }}">{{ $action->patient->name }}</span></p>
                                {{-- <p><strong>J.Kelamin</strong> : <span id="Gender">{{ $action->patient->genderName->name }}</span></p> --}}
                                <p><strong>Umur</strong> : <span id="Age"></span>
                                    {{ \Carbon\Carbon::parse($action->patient->dob)->age }}</p>
                                <p><strong>Telepon/WA</strong> : <span
                                        id="Phone{{ $action->id }}">{{ $action->patient->phone }}</span></p>
                                <p><strong>Alamat</strong> : <span id="Address">{{ $action->patient->address }}</span>
                                </p>
                                <p><strong>Darah</strong> : <span
                                        id="Blood{{ $action->id }}">{{ $action->patient->blood_type }}</span></p>
                                {{-- <p><strong>Pendidikan</strong> : <span id="Education">{{ $action->patient->educations->name }}</span></p> --}}
                                {{-- <p><strong>Pekerjaan</strong> : <span id="Job"></span>{{ $action->patient->occupations->name }}</p> --}}
                                <p><strong>Nomor RM</strong> : <span
                                        id="RmNumber{{ $action->id }}">{{ $action->patient->no_rm }}</span>
                                </p>
                            </div>

                        </div>

                        <div class="row col-8">
                            <div class="col-12">
                                <div class="row g-2">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="nik">Cari Pasien</label>
                                            <div class="input-group">
                                                <input readonly type="text" class="form-control"
                                                    id="nikEdit{{ $action->id }}" value="" name="nikEdit"
                                                    placeholder="NIK">
                                                <div class="input-group-append">
                                                    <button class="btn btn-primary" type="button" id="btnCariNIK"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#modalPasienEdit{{ $action->id }}">
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
                                                value="{{ $action->tanggal }}" placeholder="Pilih Tanggal">
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="doctor">Dokter</label>
                                            <select class="form-control" id="doctor" name="doctor">
                                                <option value="" disabled selected>Pilih Dokter</option>
                                                @foreach ($dokter as $item)
                                                    <option value="{{ $item->name }}"
                                                        {{ $action->doctor == $item->name ? 'selected' : '' }}>
                                                        {{ $item->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="kunjungan">Kunjungan</label>
                                            <select class="form-control" id="kunjungan" name="kunjungan">
                                                <option value="" disabled
                                                    {{ empty($action->kunjungan) ? 'selected' : '' }}>Pilih Jenis
                                                    Kunjungan</option>
                                                <option value="baru"
                                                    {{ $action->kunjungan == 'baru' ? 'selected' : '' }}>Baru</option>
                                                <option value="lama"
                                                    {{ $action->kunjungan == 'lama' ? 'selected' : '' }}>Lama</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="row g-2">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="kartu">Kartu</label>
                                            <input type="text" class="form-control" id="jenis_kartu"
                                                name="jenis_kartu" readonly
                                                value="{{ $action->patient->jenis_kartu == 'pbi'
                                                    ? 'PBI (KIS)'
                                                    : ($action->patient->jenis_kartu == 'askes'
                                                        ? 'AKSES'
                                                        : ($action->patient->jenis_kartu == 'jkn_mandiri'
                                                            ? 'JKN Mandiri'
                                                            : ($action->patient->jenis_kartu == 'umum'
                                                                ? 'Umum'
                                                                : ($action->patient->jenis_kartu == 'jkd'
                                                                    ? 'JKD'
                                                                    : 'Tidak Diketahui')))) }}">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="nomor">Nomor Kartu</label>
                                            <input type="text" class="form-control"
                                                id="nomor_kartu{{ $action->id }}" name="nomor"
                                                placeholder="Masukkan Nomor"
                                                value="{{ $action->patient->nomor_kartu }}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="wilayah_faskes">Wilayah Faskes</label>
                                            <select class="form-control" id="wilayah_faskes" name="faskes">
                                                <option value="" disabled
                                                    {{ empty($action->faskes) ? 'selected' : '' }}>Pilih Wilayah Faskes
                                                </option>
                                                <option value="ya"
                                                    {{ $action->faskes == 'ya' ? 'selected' : '' }}>Ya</option>
                                                <option value="tidak"
                                                    {{ $action->faskes == 'tidak' ? 'selected' : '' }}>Tidak</option>

                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <label for="keluhan" style="color: rgb(241, 11, 11);">Keluhan</label>
                                <textarea class="form-control" id="keluhan" name="keluhan" placeholder="Keluhan">{{ old('keluhan', $action->keluhan ?? '') }}</textarea>
                            </div>
                            <div class="col-md-12">
                                <label for="riwayat_penyakit_sekarang" style="color: rgb(241, 11, 11);">Riwayat
                                    Penyakit Sekarang</label>
                                <textarea class="form-control" id="riwayat_penyakit_sekarang" name="riwayat_penyakit_sekarang"
                                    placeholder="Riwayat Penyakit Sekarang">{{ old('riwayat_penyakit_sekarang', $action->riwayat_penyakit_sekarang ?? '') }}</textarea>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="riwayat_penyakit_dulu_edit" style="color: rgb(241, 11, 11);">Riwayat
                                        Penyakit Terdahulu</label>
                                    <select class="form-control" id="riwayat_penyakit_dulu_edit"
                                        name="riwayat_penyakit_dulu">
                                        <option value="" disabled
                                            {{ empty($action->riwayat_penyakit_dulu) ? 'selected' : '' }}>
                                            pilih
                                        </option>>Pilih</option>
                                        <option value="hipertensi"
                                            {{ $action->riwayat_penyakit_dulu == 'hipertensi' ? 'selected' : '' }}>
                                            Hipertensi</option>
                                        <option value="dm"
                                            {{ $action->riwayat_penyakit_dulu == 'dm' ? 'selected' : '' }}>
                                            DM
                                        </option>
                                        <option value="jantung"
                                            {{ $action->riwayat_penyakit_dulu == 'jantung' ? 'selected' : '' }}>
                                            Jantung</option>
                                        <option value="stroke"
                                            {{ $action->riwayat_penyakit_dulu == 'stroke' ? 'selected' : '' }}>
                                            Stroke</option>
                                        <option value="asma"
                                            {{ $action->riwayat_penyakit_dulu == 'asma' ? 'selected' : '' }}>
                                            Asma</option>
                                        <option value="liver"
                                            {{ $action->riwayat_penyakit_dulu == 'liver' ? 'selected' : '' }}>
                                            Liver</option>
                                        <option value="ginjal"
                                            {{ $action->riwayat_penyakit_dulu == 'ginjal' ? 'selected' : '' }}>
                                            Ginjal</option>
                                        <option value="tb"
                                            {{ $action->riwayat_penyakit_dulu == 'tb' ? 'selected' : '' }}>
                                            TB
                                        </option>
                                        <option value="lainnya"
                                            {{ $action->riwayat_penyakit_dulu == 'lainnya' ? 'selected' : '' }}>
                                            Lainnya</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12 mt-2" id="penyakit_lainnya_container_edit" style="display: none;">
                                <label for="penyakit_lainnya" style="color: rgb(241, 11, 11);">Sebutkan
                                    Penyakit Lainnya</label>
                                <textarea class="form-control" id="penyakit_lainnya_edit" name="riwayat_penyakit_lainnya"
                                    placeholder="Isi penyakit lainnya">{{ old('penyakit_lainnya', $action->riwayat_penyakit_lainnya ?? '') }}</textarea>
                            </div>
                            <div class="col-md-12">
                                <label for="riwayat_pengobatan" style="color: rgb(241, 11, 11);">Riwayat
                                    Pengobatan</label>
                                <textarea class="form-control" id="riwayat_pengobatan" name="riwayat_pengobatan" placeholder="Riwayat Pengobatan">{{ old('riwayat_pengobatan', $action->riwayat_pengobatan ?? '') }}</textarea>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="riwayat_penyakit_keluarga" style="color: rgb(241, 11, 11);">Riwayat
                                        Penyakit Keluarga</label>
                                    <select class="form-control" id="riwayat_penyakit_keluarga_edit"
                                        name="riwayat_penyakit_keluarga">
                                        <option value="" disabled
                                            {{ empty($action->riwayat_penyakit_keluarga) ? 'selected' : '' }}>
                                            Pilih</option>
                                        <option value="hipertensi"
                                            {{ $action->riwayat_penyakit_keluarga == 'hipertensi' ? 'selected' : '' }}>
                                            Hipertensi</option>
                                        <option value="dm"
                                            {{ $action->riwayat_penyakit_keluarga == 'dm' ? 'selected' : '' }}>
                                            DM</option>
                                        <option value="jantung"
                                            {{ $action->riwayat_penyakit_keluarga == 'jantung' ? 'selected' : '' }}>
                                            Jantung</option>
                                        <option value="stroke"
                                            {{ $action->riwayat_penyakit_keluarga == 'stroke' ? 'selected' : '' }}>
                                            Stroke</option>
                                        <option value="asma"
                                            {{ $action->riwayat_penyakit_keluarga == 'asma' ? 'selected' : '' }}>
                                            Asma</option>
                                        <option value="liver"
                                            {{ $action->riwayat_penyakit_keluarga == 'liver' ? 'selected' : '' }}>
                                            Liver</option>
                                        <option value="ginjal"
                                            {{ $action->riwayat_penyakit_keluarga == 'ginjal' ? 'selected' : '' }}>
                                            Ginjal</option>
                                        <option value="tb"
                                            {{ $action->riwayat_penyakit_keluarga == 'tb' ? 'selected' : '' }}>
                                            TB</option>
                                        <option value="lainnya"
                                            {{ $action->riwayat_penyakit_keluarga == 'lainnya' ? 'selected' : '' }}>
                                            Lainnya</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12 mt-2" id="penyakit_lainnya_keluarga_container_edit"
                                style="display: none;">
                                <label for="penyakit_lainnya_keluarga" style="color: rgb(241, 11, 11);">Sebutkan
                                    Penyakit Lainnya</label>
                                <textarea class="form-control" id="penyakit_lainnya_keluarga_edit" name="riwayat_penyakit_lainnya_keluarga"
                                    placeholder="Isi penyakit lainnya">{{ old('riwayat_penyakit_lainnya_keluarga', $action->riwayat_penyakit_lainnya_keluarga ?? '') }}</textarea>
                            </div>
                            <div class="col-md-12">
                                <label for="riwayat_alergi" style="color: rgb(241, 11, 11);">Riwayat
                                    Alergi</label>
                                <textarea class="form-control" id="riwayat_alergi" name="riwayat_alergi" placeholder="Riwayat Alergi">{{ old('riwayat_alergi', $action->riwayat_alergi ?? '') }}</textarea>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-12">
                                    <label for="keterangan" style="color: rgb(19, 11, 241);">KETERANGAN</label>
                                    <input type="text" class="form-control" id="keterangan" name="keterangan"
                                        placeholder="Keterangan"
                                        value="{{ isset($action->keterangan) ? $action->keterangan : '' }}">
                                </div>
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
                                            <option value="" disabled
                                                {{ empty($action->layanan_kb) ? 'selected' : '' }}>Pilih</option>
                                            <option value="1" {{ $action->layanan_kb == '1' ? 'selected' : '' }}>
                                                Pelayanan KB :
                                                Suntik</option>
                                            <option value="2" {{ $action->layanan_kb == '2' ? 'selected' : '' }}>
                                                Pelayanan KB : Pencabutan IUD (AKDR)</option>
                                            <option value="3" {{ $action->layanan_kb == '3' ? 'selected' : '' }}>
                                                Pelayanan KB : Pemasangan IUD (AKDR)</option>
                                            <option value="4" {{ $action->layanan_kb == '4' ? 'selected' : '' }}>
                                                Pelayanan KB : Pemasangan dan Pencabutan IUD (AKDR)
                                            </option>
                                            <option value="5" {{ $action->layanan_kb == '5' ? 'selected' : '' }}>
                                                Pelayanan KB : Pencabutan Implant</option>
                                            <option value="6" {{ $action->layanan_kb == '6' ? 'selected' : '' }}>
                                                Pelayanan KB : Pemasangan Implant</option>
                                            <option value="7" {{ $action->layanan_kb == '7' ? 'selected' : '' }}>
                                                Pelayanan KB : Pemasangan dan Pencabutan Implant
                                            </option>
                                            <option value="8" {{ $action->layanan_kb == '8' ? 'selected' : '' }}>
                                                MOP / Vasektomi
                                            </option>

                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="jmlh_anak_laki">Jmlh. Anak Hidup (Laki-laki) </label>
                                        <div class="input-group">
                                            <input type="number" class="form-control" id="jmlh_anak_laki"
                                                name="jmlh_anak_laki" placeholder="0"
                                                value="{{ $action->jmlh_anak_laki }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="jmlh_anak_perempuan">Jmlh. Anak Hidup (Perempuan) </label>
                                        <div class="input-group">
                                            <input type="number" class="form-control" id="jmlh_anak_perempuan"
                                                name="jmlh_anak_perempuan" placeholder="0"
                                                value="{{ $action->jmlh_anak_perempuan }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="status_kb">Status Peserta KB</label>
                                        <select class="form-control" id="status_kb" name="status_kb">
                                            <option value="" disabled
                                                {{ empty($action->status_kb) ? 'selected' : '' }}>Pilih</option>
                                            <option value="1" {{ $action->status_kb == '1' ? 'selected' : '' }}>
                                                Baru Pertama Kali</option>
                                            <option value="2" {{ $action->status_kb == '2' ? 'selected' : '' }}>
                                                Sesudah Bersalin</option>
                                            <option value="3" {{ $action->status_kb == '3' ? 'selected' : '' }}>
                                                Pindah Tempat Pelayanan, Ganti Cara</option>
                                            <option value="4" {{ $action->status_kb == '4' ? 'selected' : '' }}>
                                                Pindah Tempat Pelayanan, Cara Sama
                                            </option>
                                            <option value="5" {{ $action->status_kb == '5' ? 'selected' : '' }}>
                                                Tempat Pelayanan Sama, Ganti Cara</option>
                                            <option value="6" {{ $action->status_kb == '6' ? 'selected' : '' }}>
                                                Tempat Pelayanan Sama, Cara Sama/Lanjutkan</option>
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
                                                name="tgl_lahir_anak_bungsu"
                                                value="{{ $action->tgl_lahir_anak_bungsu }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="kb_terakhir">Cara KB Terakhir</label>
                                        <select class="form-control" id="kb_terakhir" name="kb_terakhir">
                                            <option value="" disabled
                                                {{ empty($action->kb_terakhir) ? 'selected' : '' }}>Pilih</option>
                                            <option value="1"
                                                {{ $action->kb_terakhir == '1' ? 'selected' : '' }}>
                                                Tidak Ada</option>
                                            <option value="2"
                                                {{ $action->kb_terakhir == '2' ? 'selected' : '' }}>
                                                IUD</option>
                                            <option value="3"
                                                {{ $action->kb_terakhir == '3' ? 'selected' : '' }}>
                                                MOP</option>
                                            <option value="4"
                                                {{ $action->kb_terakhir == '4' ? 'selected' : '' }}>
                                                MOW
                                            </option>
                                            <option value="5"
                                                {{ $action->kb_terakhir == '5' ? 'selected' : '' }}>
                                                Kondom</option>
                                            <option value="6"
                                                {{ $action->kb_terakhir == '6' ? 'selected' : '' }}>
                                                Implant</option>
                                            <option value="7"
                                                {{ $action->kb_terakhir == '7' ? 'selected' : '' }}>
                                                Suntikan</option>
                                            <option value="8"
                                                {{ $action->kb_terakhir == '8' ? 'selected' : '' }}>
                                                Pil</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="tgl_kb_terakhir">Tgl.KB Terakhir</label>
                                        <div class="input-group">
                                            <input type="date" class="form-control" id="tgl_kb_terakhir"
                                                name="tgl_kb_terakhir" value="{{ $action->tgl_kb_terakhir }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="keadaan_umum">Keadaan Umum</label>
                                        <select class="form-control" id="keadaan_umum" name="keadaan_umum">
                                            <option value="" disabled
                                                {{ empty($action->keadaan_umum) ? 'selected' : '' }}>Pilih</option>
                                            <option value="1"
                                                {{ $action->keadaan_umum == '1' ? 'selected' : '' }}>Baik</option>
                                            <option value="2"
                                                {{ $action->keadaan_umum == '2' ? 'selected' : '' }}>Sedang</option>
                                            <option value="3"
                                                {{ $action->keadaan_umum == '3' ? 'selected' : '' }}>Kurang</option>
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
                                            name="informed_concern" id="informed_concern_ya"
                                            value="1"{{ $action->informed_concern == 1 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="informed_concern_ya">Ada</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input custom-radio" type="radio"
                                            name="informed_concern" id="informed_concern_tidak" value="0"
                                            {{ $action->informed_concern == 0 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="informed_concern_tidak">Tidak</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label>Hamil/Diduga hamil</label>
                                <div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input custom-radio" type="radio" name="hamil"
                                            id="hamil_ya" value="1" {{ $action->hamil == 1 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="hamil_ya">Ya</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input custom-radio" type="radio" name="hamil"
                                            id="hamil_tidak" value="0"
                                            {{ $action->hamil == 0 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="hamil_tidak">Tidak</label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <label>Sakit Kuning</label>
                                <div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input custom-radio" type="radio"
                                            name="sakit_kuning" id="sakit_kuning_ya" value="1"
                                            {{ $action->sakit_kuning == 1 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="sakit_kuning_ya">Ya</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input custom-radio" type="radio"
                                            name="sakit_kuning" id="sakit_kuning_tidak" value="0"
                                            {{ $action->sakit_kuning == 0 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="sakit_kuning_tidak">Tidak</label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <label>Pendarahan Pervaginaan</label>
                                <div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input custom-radio" type="radio"
                                            name="pendarahan_vagina" id="pendarahan_vagina_ya" value="1"
                                            {{ isset($action->pendarahan_vagina) && $action->pendarahan_vagina == 1 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="pendarahan_vagina_ya">Ya</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input custom-radio" type="radio"
                                            name="pendarahan_vagina" id="pendarahan_vagina_tidak" value="0"
                                            {{ isset($action->pendarahan_vagina) && $action->pendarahan_vagina == 0 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="pendarahan_vagina_tidak">Tidak</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 mt-3">
                                <label>Tumor</label>
                                <div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input custom-radio" type="radio" name="tumor"
                                            id="tumor_ya" value="1"
                                            {{ isset($action->tumor) && $action->tumor == 1 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="tumor_ya">Ya</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input custom-radio" type="radio" name="tumor"
                                            id="tumor_tidak" value="0"
                                            {{ isset($action->tumor) && $action->tumor == 0 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="tumor_tidak">Tidak</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 mt-3">
                                <label>IMS/HIV/AIDS</label>
                                <div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input custom-radio" type="radio" name="hiv"
                                            id="hiv_ya" value="1"
                                            {{ isset($action->hiv) && $action->hiv == 1 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="hiv_ya">Ya</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input custom-radio" type="radio" name="hiv"
                                            id="hiv_tidak" value="0"
                                            {{ isset($action->hiv) && $action->hiv == 0 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="hiv_tidak">Tidak</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 mt-3">
                                <label>Tanda Tanda Diabetes</label>
                                <div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input custom-radio" type="radio" name="diabetes"
                                            id="diabetes_ya" value="1"
                                            {{ isset($action->diabetes) && $action->diabetes == 1 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="diabetes_ya">Ya</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input custom-radio" type="radio" name="diabetes"
                                            id="diabetes_tidak" value="0"
                                            {{ isset($action->diabetes) && $action->diabetes == 0 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="diabetes_tidak">Tidak</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 mt-3">
                                <label>Kelainan Pembekuan Darah</label>
                                <div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input custom-radio" type="radio"
                                            name="pembekuan_darah" id="pembekuan_darah_ya" value="1"
                                            {{ isset($action->pembekuan_darah) && $action->pembekuan_darah == 1 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="pembekuan_darah_ya">Ya</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input custom-radio" type="radio"
                                            name="pembekuan_darah" id="pembekuan_darah_tidak" value="0"
                                            {{ isset($action->pembekuan_darah) && $action->pembekuan_darah == 0 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="pembekuan_darah_tidak">Tidak</label>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                {{-- <div class="col-md-6 mt-3">
                                    <label for="pemeriksaan_penunjang">Pemeriksaan Penunjang</label>
                                    <textarea class="form-control" id="pemeriksaan_penunjang" name="pemeriksaan_penunjang"
                                        placeholder="Pemeriksaan penunjang">{{ isset($action->pemeriksaan_penunjang) ? $action->pemeriksaan_penunjang : '' }}</textarea>
                                </div> --}}
                                <div class="col-md-6 mt-3">
                                    <label for="kesimpulan">Kesimpulan</label>
                                    <textarea class="form-control" id="kesimpulan" name="kesimpulan" placeholder="Kesimpulan">{{ isset($action->kesimpulan) ? $action->kesimpulan : '' }}</textarea>
                                </div>
                                <div class="col-md-6 mt-3">
                                    <label for="obat" style="color: rgb(19, 11, 241);">Obat</label>
                                    <textarea class="form-control" id="obat" name="obat" placeholder="Obat">{{ isset($action->obat) ? $action->obat : '' }}</textarea>
                                </div>
                                <div class="col-md-12">
                                    <label for="hasil_lab" style="color: rgb(19, 11, 241);">Hasil Laboratorium</label>
                                    <textarea class="form-control" id="hasil_lab" name="hasil_lab" placeholder="Hasil Laboratorium">{{ isset($action->hasil_lab) ? $action->hasil_lab : '' }}</textarea>
                                </div>



                            </div>
                        </div>
                    </div>



                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Simpan Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>


@include('component.modal-table-edit-pasien')

<script>
    var nikValue = "{{ $action->patient->nik ?? '' }}";
    document.getElementById('nikEdit{{ $action->id }}').value = nikValue;
    console.log(nikValue);
</script>
<script>
    $(document).ready(function() {
        $('#diagnosaEdit').select2({
            placeholder: "Pilih",
            allowClear: true,
            minimumResultsForSearch: 0
        });
    });
    $(document).ready(function() {
        $('#tindakanEdit').select2({
            placeholder: "Pilih",
            allowClear: true,
            minimumResultsForSearch: 0
        });
    });
</script>

<style>
    .select2-dropdown {
        z-index: 9999 !important;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Attach event listeners dynamically for all modal edit elements
        const allModals = document.querySelectorAll('.modal'); // Semua modal yang memiliki form edit
        allModals.forEach((modal) => {
            const selectPenyakitDulu = modal.querySelector('[id^="riwayat_penyakit_dulu_edit"]');
            const selectPenyakitKeluarga = modal.querySelector(
                '[id^="riwayat_penyakit_keluarga_edit"]');

            // Container untuk input "lainnya"
            const lainnyaContainer = modal.querySelector('#penyakit_lainnya_container_edit');
            const lainnyaTextarea = modal.querySelector('#penyakit_lainnya_edit');

            const lainnyaKeluargaContainer = modal.querySelector(
                '#penyakit_lainnya_keluarga_container_edit');
            const lainnyaKeluargaTextarea = modal.querySelector('#penyakit_lainnya_keluarga_edit');

            if (selectPenyakitDulu) {
                // Event listener untuk 'riwayat_penyakit_dulu_edit'
                selectPenyakitDulu.addEventListener('change', function() {
                    toggleLainnya(selectPenyakitDulu, lainnyaContainer, lainnyaTextarea);
                });
            }

            if (selectPenyakitKeluarga) {
                // Event listener untuk 'riwayat_penyakit_keluarga_edit'
                selectPenyakitKeluarga.addEventListener('change', function() {
                    toggleLainnya(selectPenyakitKeluarga, lainnyaKeluargaContainer,
                        lainnyaKeluargaTextarea);
                });
            }

            // Populate form data on modal show
            modal.addEventListener('show.bs.modal', function() {
                populateFormData(
                    modal,
                    selectPenyakitDulu,
                    lainnyaContainer,
                    lainnyaTextarea,
                    'riwayat_penyakit_dulu'
                );
                populateFormData(
                    modal,
                    selectPenyakitKeluarga,
                    lainnyaKeluargaContainer,
                    lainnyaKeluargaTextarea,
                    'riwayat_penyakit_keluarga'
                );
            });
        });
    });

    // Fungsi toggle "lainnya"
    function toggleLainnya(select, container, textarea) {
        if (select.value === 'lainnya') {
            container.style.display = 'block';
            textarea = true;
        } else {
            container.style.display = 'none';
            textarea.value = '';
            textarea = false;
        }
    }

    // Populate data berdasarkan modal
    function populateFormData(modal, selectElement, container, textarea, field) {
        const actionId = modal.getAttribute('id').replace('editActionModal', ''); // Ambil ID tindakan dari modal
        const actions = {!! json_encode($actions ?? []) !!}; // Semua data tindakan dari Laravel

        const actionData = actions.find((action) => action.id.toString() === actionId);

        if (actionData && actionData[field]) {
            selectElement.value = actionData[field];
            toggleLainnya(selectElement, container, textarea);

            if (actionData[field] === 'lainnya' && actionData[`${field}_lainnya`]) {
                textarea.value = actionData[`${field}_lainnya`];
            }
        }
    }
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Display success message if session has a success
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
</script>
