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
                <h5 class="modal-title" id="exampleModalLabel">TINDAKAN KIA</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form id="addPatientForm" action="{{ route('action.update', $action->id) }}" method="POST"
                    class="px-3">
                    @csrf
                    <input type="hidden" name="tipe" id="tipe" value="poli-kia">
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
                                                        data-bs-toggle="modal" data-bs-target="#modalPasienEdit">
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
                                    <label for="riwayat_penyakit_dulu" style="color: rgb(241, 11, 11);">Riwayat
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
                                                name="usia_kehamilan" placeholder="Masukkan usia kehamilan"
                                                value="{{ $action->usia_kehamilan }}">
                                            <span class="input-group-text">minggu</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="jenis_anc">Jenis ANC</label>
                                        <select class="form-control" id="jenis_anc" name="jenis_anc">
                                            <option value="" disabled
                                                {{ empty($action->jenis_anc) ? 'selected' : '' }}>Pilih
                                                jenis ANC</option>
                                            <option value="anc1"
                                                {{ $action->jenis_anc == 'anc1' ? 'selected' : '' }}>ANC 1</option>
                                            <option value="anc2"
                                                {{ $action->jenis_anc == 'anc2' ? 'selected' : '' }}>ANC II</option>
                                            <option value="anc3"
                                                {{ $action->jenis_anc == 'anc3' ? 'selected' : '' }}>ANC III</option>
                                            <option value="anc4"
                                                {{ $action->jenis_anc == 'anc4' ? 'selected' : '' }}>ANC IV</option>
                                            <option value="anc5"
                                                {{ $action->jenis_anc == 'anc5' ? 'selected' : '' }}>ANC V</option>
                                            <option value="anc6"
                                                {{ $action->jenis_anc == 'an6' ? 'selected' : '' }}>ANC VI</option>

                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="lingkar_lengan_atas">Lingkar lengan atas </label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="lingkar_lengan_atas"
                                                name="lingkar_lengan_atas" placeholder="Masukkan lingkar lengan atas"
                                                value="{{ $action->lingkar_lengan_atas }}">
                                            <span class="input-group-text">cm</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="tinggi_fundus_uteri">Tinggi fundus uteri</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="tinggi_fundus_uteri"
                                                name="tinggi_fundus_uteri" placeholder="Masukkan tinggi fundus uteri"
                                                value="{{ $action->tinggi_fundus_uteri }}">
                                            <span class="input-group-text">cm</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="presentansi_janin">Presentasi janin</label>
                                        <select class="form-control" id="presentasi_janin" name="presentasi_janin">
                                            <option value="" disabled
                                                {{ empty($action->presentasi_janin) ? 'selected' : '' }}>Pilih
                                                presentasi janin
                                            </option>
                                            <option value="kepala"
                                                {{ $action->presentasi_janin == 'kepala' ? 'selected' : '' }}>
                                                Kepala</option>
                                            <option value="sungsang"
                                                {{ $action->presentasi_janin == 'sungsang' ? 'selected' : '' }}>
                                                Sungsang</option>
                                            <option value="melintang"
                                                {{ $action->presentasi_janin == 'melintang' ? 'selected' : '' }}>
                                                Melintang</option>
                                            <option value="lain-lain"
                                                {{ $action->presentasi_janin == 'lain-lain' ? 'selected' : '' }}>
                                                Lain-lain</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="denyut_jantung">Denyut nyantung </label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="denyut_jantung"
                                                name="denyut_jantung" placeholder="Masukkan denyut jantung"
                                                value="{{ $action->denyut_jantung }}">
                                            <span class="input-group-text">bpm</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-4">
                                <label>Kaki Bengkak</label>
                                <div class="custom-radio-container">
                                    <label class="custom-radio-wrapper">
                                        <input class="custom-radio" type="radio" name="kaki_bengkak"
                                            id="kaki_bengkak_ya" value="1"
                                            {{ $action->kaki_bengkak == 1 ? 'checked' : '' }}>
                                        <span class="custom-radio-label">Ya</span>
                                    </label>
                                    <label class="custom-radio-wrapper">
                                        <input class="custom-radio" type="radio" name="kaki_bengkak"
                                            id="kaki_bengkak_tidak" value="0"
                                            {{ $action->kaki_bengkak == 0 ? 'checked' : '' }}>
                                        <span class="custom-radio-label">Tidak</span>
                                    </label>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <label>Diberikan Imunisasi TT</label>
                                <div class="custom-radio-container">
                                    <label class="custom-radio-wrapper">
                                        <input class="custom-radio" type="radio" name="imunisasi_tt"
                                            id="imunisasi_tt_ya" value="1"
                                            {{ $action->imunisasi_tt == 1 ? 'checked' : '' }}>
                                        <span class="custom-radio-label">Ya</span>
                                    </label>
                                    <label class="custom-radio-wrapper">
                                        <input class="custom-radio" type="radio" name="imunisasi_tt"
                                            id="imunisasi_tt_tidak" value="0"
                                            {{ $action->imunisasi_tt == 0 ? 'checked' : '' }}>
                                        <span class="custom-radio-label">Tidak</span>
                                    </label>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <label>Diberikan Tablet FEk</label>
                                <div class="custom-radio-container">
                                    <label class="custom-radio-wrapper">
                                        <input class="custom-radio" type="radio" name="tablet_fe"
                                            id="tablet_fe_ya" value="1"
                                            {{ $action->tablet_fe == 1 ? 'checked' : '' }}>
                                        <span class="custom-radio-label">Ya</span>
                                    </label>
                                    <label class="custom-radio-wrapper">
                                        <input class="custom-radio" type="radio" name="tablet_fe"
                                            id="tablet_fe_tidak" value="0"
                                            {{ $action->tablet_fe == 0 ? 'checked' : '' }}>
                                        <span class="custom-radio-label">Tidak</span>
                                    </label>
                                </div>
                            </div>

                            <div class="col-md-4 mt-3">
                                <label>Status Kehamilan</label>
                                <div class="row">
                                    <div class="col-md-4">
                                        <input type="text" class="form-control" id="gravida" name="gravida"
                                            placeholder="Gravida" value="{{ $action->gravida }}">
                                    </div>
                                    <div class="col-md-4">
                                        <input type="text" class="form-control" id="partus" name="partus"
                                            placeholder="Partus" value="{{ $action->partus }}">
                                    </div>
                                    <div class="col-md-4">
                                        <input type="text" class="form-control" id="abortus" name="abortus"
                                            placeholder="Abortus" value="{{ $action->abortus }}">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4 mt-3">
                                <label>Nilai Hb</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="nilai_hb" name="nilai_hb"
                                        placeholder="Masukkan Nilai Hb" value="{{ $action->nilai_hb }}">
                                    <span class="input-group-text">g/dl</span>
                                </div>
                            </div>

                            <div class="col-md-4 mt-3">
                                <label>Proteinuria</label>
                                <div class="custom-radio-container">
                                    <label class="custom-radio-wrapper">
                                        <input class="custom-radio" type="radio" name="proteinura"
                                            id="proteinura_ya" value="1"
                                            {{ $action->proteinura == 1 ? 'checked' : '' }}>
                                        <span class="custom-radio-label">Positif</span>
                                    </label>
                                    <label class="custom-radio-wrapper">
                                        <input class="custom-radio" type="radio" name="proteinura"
                                            id="proteinura_tidak" value="0"
                                            {{ $action->proteinura == 0 ? 'checked' : '' }}>
                                        <span class="custom-radio-label">Negatif</span>
                                    </label>
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
                                    <div class="custom-radio-container">
                                        <label class="custom-radio-wrapper">
                                            <input class="custom-radio" type="radio" name="hiv" id="hiv_ya"
                                                value="reaktif" {{ $action->hiv == 'reaktif' ? 'checked' : '' }}>
                                            <span class="custom-radio-label">Reaktif</span>
                                        </label>
                                        <label class="custom-radio-wrapper">
                                            <input class="custom-radio" type="radio" name="hiv" id="hiv_tidak"
                                                value="non-reaktif"
                                                {{ $action->hiv == 'non-reaktif' ? 'checked' : '' }}>
                                            <span class="custom-radio-label">Non-Reaktif</span>
                                        </label>
                                        <label class="custom-radio-wrapper">
                                            <input class="custom-radio" type="radio" name="hiv"
                                                id="hiv_lain_lain" value="tidak_tersedia"
                                                {{ $action->hiv == 'tidak_tersedia' ? 'checked' : '' }}>
                                            <span class="custom-radio-label">Tidak Tersedia</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <label>Sifilis</label>
                                    <div class="custom-radio-container">
                                        <label class="custom-radio-wrapper">
                                            <input class="custom-radio" type="radio" name="sifilis"
                                                id="sifilis_ya" value="reaktif"
                                                {{ $action->sifilis == 'reaktif' ? 'checked' : '' }}>
                                            <span class="custom-radio-label">Reaktif</span>
                                        </label>
                                        <label class="custom-radio-wrapper">
                                            <input class="custom-radio" type="radio" name="sifilis"
                                                id="sifilis_tidak" value="non-reaktif"
                                                {{ $action->sifilis == 'non-reaktif' ? 'checked' : '' }}>
                                            <span class="custom-radio-label">Non-Reaktif</span>
                                        </label>
                                        <label class="custom-radio-wrapper">
                                            <input class="custom-radio" type="radio" name="sifilis"
                                                id="sifilis_lain_lain" value="tidak_tersedia"
                                                {{ $action->sifilis == 'tidak_tersedia' ? 'checked' : '' }}>
                                            <span class="custom-radio-label">Tidak Tersedia</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <label>Hepatitis</label>
                                    <div class="custom-radio-container">
                                        <label class="custom-radio-wrapper">
                                            <input class="custom-radio" type="radio" name="hepatitis"
                                                id="hepatitis_ya" value="reaktif"
                                                {{ $action->hepatitis == 'reaktif' ? 'checked' : '' }}>
                                            <span class="custom-radio-label">Reaktif</span>
                                        </label>
                                        <label class="custom-radio-wrapper">
                                            <input class="custom-radio" type="radio" name="hepatitis"
                                                id="hepatitis_tidak" value="non-reaktif"
                                                {{ $action->hepatitis == 'non-reaktif' ? 'checked' : '' }}>
                                            <span class="custom-radio-label">Non-Reaktif</span>
                                        </label>
                                        <label class="custom-radio-wrapper">
                                            <input class="custom-radio" type="radio" name="hepatitis"
                                                id="hepatitis_lain_lain" value="tidak_tersedia"
                                                {{ $action->hepatitis == 'tidak_tersedia' ? 'checked' : '' }}>
                                            <span class="custom-radio-label">Tidak Tersedia</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <label>Dengan pemeriksaan USG</label>
                                    <div class="custom-radio-container">
                                        <label class="custom-radio-wrapper">
                                            <input class="custom-radio" type="radio" name="periksa_usg"
                                                id="periksa_usg_ya" value="1"
                                                {{ $action->periksa_usg == 1 ? 'checked' : '' }}>
                                            <span class="custom-radio-label">Ya</span>
                                        </label>
                                        <label class="custom-radio-wrapper">
                                            <input class="custom-radio" type="radio" name="periksa_usg"
                                                id="periksa_usg_tidak" value="0"
                                                {{ $action->periksa_usg == 0 ? 'checked' : '' }}>
                                            <span class="custom-radio-label">Tidak</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mt-3">
                                <label for="hasil_usg">Hasil USG</label>
                                <textarea class="form-control" id="hasil_usg" name="hasil_usg" placeholder="Hasil USG">{{ old('hasil_usg', $action->hasil_usg ?? '') }}</textarea>
                            </div>
                            <div class="col-md-6 mt-3">
                                <label for="treatment_anc">Treatment ANC</label>
                                <textarea class="form-control" id="treatment_anc" name="treatment_anc" placeholder="Treatment ANC">{{ old('treatment_anc', $action->treatment_anc ?? '') }}</textarea>
                            </div>
                            <div class="col-md-6 mt-3">
                                <label for="kesimpulan">Kesimpulan</label>
                                <textarea class="form-control" id="kesimpulan" name="kesimpulan" placeholder="Kesimpulan">{{ old('kesimpulan', $action->kesimpulan ?? '') }}</textarea>
                            </div>
                            <div class="col-md-6 mt-3">
                                <label for="tanggal_kembali">Tanggal kembali</label>
                                <input type="date" class="form-control" name="tanggal_kembali"
                                    id="tanggal_kembali" placeholder="Pilih Tanggal"
                                    value="{{ $action->tanggal_kembali }}">
                            </div>
                            <div class="col-md-6 mt-3">
                                <label for="obat" style="color: rgb(19, 11, 241);">Obat</label>
                                <textarea class="form-control" id="obat" name="obat" placeholder="Obat">{{ old('obat', $action->obat ?? '') }}</textarea>
                            </div>
                            <div class="col-md-6 mt-3">
                                <label for="pemeriksaan_penunjang">Pemeriksaan Penunjang</label>
                                <textarea class="form-control" id="pemeriksaan_penunjang" name="pemeriksaan_penunjang"
                                    placeholder="Pemeriksaan penunjang">{{ isset($action->pemeriksaan_penunjang) ? $action->pemeriksaan_penunjang : '' }}</textarea>
                            </div>
                            <div class="col-md-12">
                                <label for="hasil_lab" style="color: rgb(19, 11, 241);">Hasil Laboratorium</label>
                                <textarea class="form-control" id="hasil_lab" name="hasil_lab" placeholder="Hasil Laboratorium">{{ isset($action->hasil_lab) ? $action->hasil_lab : '' }}</textarea>
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
