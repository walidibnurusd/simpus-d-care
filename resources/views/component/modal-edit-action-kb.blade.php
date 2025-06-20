<!-- Modal Add Action -->
@php
    $diagnosa = App\Models\Diagnosis::all();
    $poli = App\Models\Poli::all();
    // dd($diagnosa);
@endphp
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

    .form-check-input {
        width: 20px !important;
        height: 20px !important;
        cursor: pointer !important;
    }

    .form-check-label {
        font-size: 16px;
        margin-left: 8px;
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
                <form id="editPatientForm{{ $action->id }}" action="{{ route('action.update', $action->id) }}"
                    method="POST" class="px-3">
                    <div id="formSection1{{ $action->id }}" class="form-section">
                        @csrf
                        <input type="hidden" name="tipe" id="tipe" value="poli-kb">
                        <div class="row">
                            <div class="col-4">
                                <h5>Detail Pasien</h5>
                                <div id="patientDetailsEdit"
                                    style=" margin-top: 10px; padding: 10px; border-radius: 5px;">
                                    <p><strong>N I K</strong> : <span
                                            id="NIK{{ $action->id }}">{{ $action->patient->nik }}</span></p>
                                    <p><strong>Nama Pasien</strong> : <span
                                            id="Name{{ $action->id }}">{{ $action->patient->name }}</span></p>
                                    {{-- <p><strong>J.Kelamin</strong> : <span id="Gender">{{ $action->patient->genderName->name }}</span></p> --}}
                                    <p><strong>Umur</strong> : <span id="Age"></span>
                                        {{ \Carbon\Carbon::parse($action->patient->dob)->age }}</p>
                                    <p><strong>Telepon/WA</strong> : <span
                                            id="Phone{{ $action->id }}">{{ $action->patient->phone }}</span></p>
                                    <p><strong>Alamat</strong> : <span
                                            id="Address">{{ $action->patient->address }}</span>
                                    </p>
                                    <p><strong>Darah</strong> : <span
                                            id="Blood{{ $action->id }}">{{ $action->patient->blood_type }}</span>
                                    </p>
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
                                                <label for="kasus">Kasus</label>
                                                <select class="form-control" id="kasus" name="kasus">
                                                    <option value="" disabled
                                                        {{ empty($action->kasus) ? 'selected' : '' }}>Pilih Jenis Kasus
                                                    </option>
                                                    <option value="1"
                                                        {{ $action->kasus == '1' ? 'selected' : '' }}>
                                                        Baru
                                                    </option>
                                                    <option value="0"
                                                        {{ $action->kasus == '0' ? 'selected' : '' }}>
                                                        Lama
                                                    </option>
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
                                                <select class="form-control" id="wilayah_faskes" name="faskes"
                                                    disabled>
                                                    <option value="" disabled
                                                        {{ empty($action->patient->wilayah_faskes) ? 'selected' : '' }}>
                                                        Pilih Wilayah
                                                        Faskes
                                                    </option>
                                                    <option value="1"
                                                        {{ $action->patient->wilayah_faskes == '1' ? 'selected' : '' }}>
                                                        Ya</option>
                                                    <option value="0"
                                                        {{ $action->patient->wilayah_faskes == '0' ? 'selected' : '' }}>
                                                        Tidak
                                                    </option>

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
                                        <label for="riwayat_penyakit_dulu_edit"
                                            style="color: rgb(241, 11, 11);">Riwayat
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
                                <div class="col-md-12 mt-2" id="penyakit_lainnya_container_edit"
                                    style="display: none;">
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
                                        <label for="riwayat_penyakit_keluarga"
                                            style="color: rgb(241, 11, 11);">Riwayat
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
                                                <option value="1"
                                                    {{ $action->layanan_kb == '1' ? 'selected' : '' }}>
                                                    Pelayanan KB :
                                                    Suntik</option>
                                                <option value="2"
                                                    {{ $action->layanan_kb == '2' ? 'selected' : '' }}>
                                                    Pelayanan KB : Pencabutan IUD (AKDR)</option>
                                                <option value="3"
                                                    {{ $action->layanan_kb == '3' ? 'selected' : '' }}>
                                                    Pelayanan KB : Pemasangan IUD (AKDR)</option>
                                                <option value="4"
                                                    {{ $action->layanan_kb == '4' ? 'selected' : '' }}>
                                                    Pelayanan KB : Pemasangan dan Pencabutan IUD (AKDR)
                                                </option>
                                                <option value="5"
                                                    {{ $action->layanan_kb == '5' ? 'selected' : '' }}>
                                                    Pelayanan KB : Pencabutan Implant</option>
                                                <option value="6"
                                                    {{ $action->layanan_kb == '6' ? 'selected' : '' }}>
                                                    Pelayanan KB : Pemasangan Implant</option>
                                                <option value="7"
                                                    {{ $action->layanan_kb == '7' ? 'selected' : '' }}>
                                                    Pelayanan KB : Pemasangan dan Pencabutan Implant
                                                </option>
                                                <option value="8"
                                                    {{ $action->layanan_kb == '8' ? 'selected' : '' }}>
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
                                                <option value="1"
                                                    {{ $action->status_kb == '1' ? 'selected' : '' }}>
                                                    Baru Pertama Kali</option>
                                                <option value="2"
                                                    {{ $action->status_kb == '2' ? 'selected' : '' }}>
                                                    Sesudah Bersalin</option>
                                                <option value="3"
                                                    {{ $action->status_kb == '3' ? 'selected' : '' }}>
                                                    Pindah Tempat Pelayanan, Ganti Cara</option>
                                                <option value="4"
                                                    {{ $action->status_kb == '4' ? 'selected' : '' }}>
                                                    Pindah Tempat Pelayanan, Cara Sama
                                                </option>
                                                <option value="5"
                                                    {{ $action->status_kb == '5' ? 'selected' : '' }}>
                                                    Tempat Pelayanan Sama, Ganti Cara</option>
                                                <option value="6"
                                                    {{ $action->status_kb == '6' ? 'selected' : '' }}>
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
                                                    {{ $action->keadaan_umum == '2' ? 'selected' : '' }}>Sedang
                                                </option>
                                                <option value="3"
                                                    {{ $action->keadaan_umum == '3' ? 'selected' : '' }}>Kurang
                                                </option>
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
                                            <input class="form-check-input custom-radio" type="radio"
                                                name="hamil" id="hamil_ya" value="1"
                                                {{ $action->hamil == 1 ? 'checked' : '' }}>
                                            <label class="form-check-label" for="hamil_ya">Ya</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input custom-radio" type="radio"
                                                name="hamil" id="hamil_tidak" value="0"
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
                                            <label class="form-check-label"
                                                for="pendarahan_vagina_tidak">Tidak</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 mt-3">
                                    <label>Tumor</label>
                                    <div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input custom-radio" type="radio"
                                                name="tumor" id="tumor_ya" value="1"
                                                {{ isset($action->tumor) && $action->tumor == 1 ? 'checked' : '' }}>
                                            <label class="form-check-label" for="tumor_ya">Ya</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input custom-radio" type="radio"
                                                name="tumor" id="tumor_tidak" value="0"
                                                {{ isset($action->tumor) && $action->tumor == 0 ? 'checked' : '' }}>
                                            <label class="form-check-label" for="tumor_tidak">Tidak</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 mt-3">
                                    <label>IMS/HIV/AIDS</label>
                                    <div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input custom-radio" type="radio"
                                                name="hiv" id="hiv_ya" value="1"
                                                {{ isset($action->hiv) && $action->hiv == 1 ? 'checked' : '' }}>
                                            <label class="form-check-label" for="hiv_ya">Ya</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input custom-radio" type="radio"
                                                name="hiv" id="hiv_tidak" value="0"
                                                {{ isset($action->hiv) && $action->hiv == 0 ? 'checked' : '' }}>
                                            <label class="form-check-label" for="hiv_tidak">Tidak</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 mt-3">
                                    <label>Tanda Tanda Diabetes</label>
                                    <div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input custom-radio" type="radio"
                                                name="diabetes" id="diabetes_ya" value="1"
                                                {{ isset($action->diabetes) && $action->diabetes == 1 ? 'checked' : '' }}>
                                            <label class="form-check-label" for="diabetes_ya">Ya</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input custom-radio" type="radio"
                                                name="diabetes" id="diabetes_tidak" value="0"
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
                                    <div class="col-md-4 mt-3">
                                        <label for="poli" style="color: rgb(19, 11, 241);">Rujuk Poli</label>
                                        <select class="form-control" id="poliEdit{{ $action->id }}"
                                            name="id_rujuk_poli">
                                            <option value="" disabled selected>pilih</option>
                                            @foreach ($poli as $item)
                                                <option value="{{ $item->id }}"
                                                    @if (old('id_rujuk_poli', $action->id_rujuk_poli ?? '') == $item->id) selected @endif>
                                                    {{ $item->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4 mt-3">
                                        <label for="poli" style="color: rgb(19, 11, 241);">DIAGNOSA UTAMA</label>
                                        <select class="form-control" id="diagnosaPrimerEdit{{ $action->id }}"
                                            name="diagnosa_primer">
                                            <option value="" disabled selected>pilih</option>
                                            @foreach ($diagnosa as $item)
                                                <option value="{{ $item->id }}"
                                                    @if (old('diagnosa_primer', $action->diagnosa_primer ?? '') == $item->id) selected @endif>
                                                    {{ $item->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4 mt-3">
                                        <label for="diagnosaEdit" style="color: rgb(19, 11, 241);">DIAGNOSA
                                            SEKUNDER</label>
                                        <select class="form-control" id="diagnosaEdit{{ $action->id }}"
                                            name="diagnosa[]" multiple>
                                            @php
                                                // Decode JSON if it exists
                                                $selectedDiagnosa = is_string($action->diagnosa)
                                                    ? json_decode($action->diagnosa, true)
                                                    : $action->diagnosa;
                                            @endphp
                                            @foreach ($diagnosa as $item)
                                                <option value="{{ $item->id }}"
                                                    {{ in_array($item->id, old('diagnosa', $selectedDiagnosa ?: [])) ? 'selected' : '' }}>
                                                    {{ $item->name }}-{{ $item->icd10 }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4 mt-3">
                                        <label for="kesimpulan">Kesimpulan</label>
                                        <textarea class="form-control" id="kesimpulan" name="kesimpulan" placeholder="Kesimpulan">{{ isset($action->kesimpulan) ? $action->kesimpulan : '' }}</textarea>
                                    </div>
                                    <div class="col-md-4 mt-3">
                                        <div class="form-group">
                                            <label for="skrining" class="form-label">Hasil Skrining</label>
                                            <button class="btn btn-primary w-100 mt-2" type="button"
                                                id="btnCariskriningEdit" data-bs-toggle="modal"
                                                data-bs-target="#modalSkriningEdit"
                                                data-patient-id="{{ $action->id_patient }}">
                                                <!-- Tambahkan data-patient-id -->
                                                Hasil Skrining
                                            </button>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mt-3">
                                        <div class="form-group">
                                            <label for="skrining" class="form-label">Riwayat Berobat</label>
                                            <button class="btn btn-success w-100 mt-2 btnCariRiwayatBerobatEdit"
                                                type="button" data-bs-toggle="modal"
                                                data-bs-target="#modalBerobatEdit"
                                                data-patient-id="{{ $action->id_patient }}">
                                                Riwayat Berobat
                                            </button>


                                        </div>
                                    </div>
                                    <div class="col-md-6 mt-3">
                                        <label for="rujuk_rs" style="color: rgb(19, 11, 241);">RUJUK RS</label>
                                        <select class="form-control" id="rujuk_rs{{ $action->id }}"
                                            name="rujuk_rs">
                                            <option value="" disabled selected>pilih</option>
                                            @foreach ($rs as $item)
                                                <option value="{{ $item->id }}"
                                                    {{ old('rujuk_rs', $action->rujuk_rs ?? '') == $item->id ? 'selected' : '' }}>
                                                    {{ $item->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6 mt-3">
                                        <div class="form-group">
                                            <label for="skrining" class="form-label">Obat</label>
                                            <button class="btn btn-primary w-100 mt-2" type="button" id="btnAddObat"
                                                data-bs-toggle="modal"
                                                data-bs-target="#editActionObatModal{{ $action->id }}">
                                                Obat
                                            </button>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @if (Auth::user()->role == 'dokter')
                        <div id="formSection2{{ $action->id }}" class="form-section d-none">
                            <h6>Jenis Pemeriksaan Darah</h6>
                            @php

                                $jenis_pemeriksaan =
                                    json_decode($action->hasilLab?->jenis_pemeriksaan ?? '[]', true) ?? [];
                            @endphp
                            <div class="row">

                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="gds"
                                            name="jenis_pemeriksaan[]" value="GDS"
                                            {{ in_array('GDS', $jenis_pemeriksaan ?? []) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="gds">GDS
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="gdp"
                                            name="jenis_pemeriksaan[]" value="GDP"
                                            {{ in_array('GDP', $jenis_pemeriksaan ?? []) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="gdp">GDP</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="gdp_2_jam_pp"
                                            name="jenis_pemeriksaan[]" value="GDP 2 Jam pp"
                                            {{ in_array('GDP 2 Jam pp', $jenis_pemeriksaan ?? []) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="gdp_2_jam_pp">GDP 2 Jam pp</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="cholesterol"
                                            name="jenis_pemeriksaan[]" value="Cholesterol"
                                            {{ in_array('Cholesterol', $jenis_pemeriksaan ?? []) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="cholesterol">Cholesterol</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="asam_urat"
                                            name="jenis_pemeriksaan[]" value="Asam Urat"
                                            {{ in_array('Asam Urat', $jenis_pemeriksaan ?? []) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="asam_urat">Asam Urat</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="leukosit"
                                            name="jenis_pemeriksaan[]" value="Leukosit"
                                            {{ in_array('Leukosit', $jenis_pemeriksaan ?? []) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="leukosit">Leukosit</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="eritrosit"
                                            name="jenis_pemeriksaan[]" value="Eritrosit"
                                            {{ in_array('Eritrosit', $jenis_pemeriksaan ?? []) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="eritrosit">Eritrosit</label>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="trombosit"
                                            name="jenis_pemeriksaan[]" value="Trombosit"
                                            {{ in_array('Trombosit', $jenis_pemeriksaan ?? []) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="trombosit">Trombosit</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="hemoglobin"
                                            name="jenis_pemeriksaan[]" value="Hemoglobin"
                                            {{ in_array('Hemoglobin', $jenis_pemeriksaan ?? []) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="hemoglobin">Hemoglobin</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="sifilis"
                                            name="jenis_pemeriksaan[]" value="Sifilis"
                                            {{ in_array('Sifilis', $jenis_pemeriksaan ?? []) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="sifilis">Sifilis</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="hiv"
                                            name="jenis_pemeriksaan[]" value="HIV"
                                            {{ in_array('HIV', $jenis_pemeriksaan ?? []) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="hiv">HIV</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="golongan_darah"
                                            name="jenis_pemeriksaan[]" value="Golongan Darah"
                                            {{ in_array('Golongan Darah', $jenis_pemeriksaan ?? []) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="golongan_darah">Golongan
                                            Darah</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="widal"
                                            name="jenis_pemeriksaan[]" value="Widal"
                                            {{ in_array('Widal', $jenis_pemeriksaan ?? []) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="widal">Widal</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="malaria"
                                            name="jenis_pemeriksaan[]" value="Malaria"
                                            {{ in_array('Malaria', $jenis_pemeriksaan ?? []) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="malaria">Malaria</label>
                                    </div>
                                </div>
                            </div>

                            <!-- Tambahan Pemeriksaan URINE -->
                            <h6>Jenis Pemeriksaan URINE</h6>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="albumin"
                                    name="jenis_pemeriksaan[]" value="Albumin"
                                    {{ in_array('Albumin', $jenis_pemeriksaan ?? []) ? 'checked' : '' }}>
                                <label class="form-check-label" for="albumin">Albumin</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="reduksi"
                                    name="jenis_pemeriksaan[]" value="Reduksi"
                                    {{ in_array('Reduksi', $jenis_pemeriksaan ?? []) ? 'checked' : '' }}>
                                <label class="form-check-label" for="reduksi">Reduksi</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="urinalisa"
                                    name="jenis_pemeriksaan[]" value="Urinalisa"
                                    {{ in_array('Urinalisa', $jenis_pemeriksaan ?? []) ? 'checked' : '' }}>
                                <label class="form-check-label" for="urinalisa">Urinalisa</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="tes_kehamilan"
                                    name="jenis_pemeriksaan[]" value="Tes Kehamilan"
                                    {{ in_array('Tes Kehamilan', $jenis_pemeriksaan ?? []) ? 'checked' : '' }}>
                                <label class="form-check-label" for="tes_kehamilan">Tes Kehamilan</label>
                            </div>

                            <!-- Tambahan Pemeriksaan FESES -->
                            <h6>Jenis Pemeriksaan FESES</h6>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="telur_cacing"
                                    name="jenis_pemeriksaan[]" value="Telur Cacing"
                                    {{ in_array('Telur Cacing', $jenis_pemeriksaan ?? []) ? 'checked' : '' }}>
                                <label class="form-check-label" for="telur_cacing">Telur Cacing</label>
                            </div>
                            <!--<div class="form-check">-->
                            <!--    <input class="form-check-input" type="checkbox" id="bta"-->
                            <!--        name="jenis_pemeriksaan[]" value="BTA"-->
                            <!--        {{ in_array('BTA', $jenis_pemeriksaan ?? []) ? 'checked' : '' }}>-->
                            <!--    <label class="form-check-label" for="bta">BTA</label>-->
                            <!--</div>-->

                            <!-- Tambahan Pemeriksaan IgM -->
                            <h6>Pemeriksaan IgM</h6>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="igm_dbd"
                                    name="jenis_pemeriksaan[]" value="IgM DBD"
                                    {{ in_array('IgM DBD', $jenis_pemeriksaan ?? []) ? 'checked' : '' }}>
                                <label class="form-check-label" for="igm_dbd">IgM DBD</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="igm_typhoid"
                                    name="jenis_pemeriksaan[]" value="IgM Typhoid"
                                    {{ in_array('IgM Typhoid', $jenis_pemeriksaan ?? []) ? 'checked' : '' }}>
                                <label class="form-check-label" for="igm_typhoid">IgM Typhoid</label>
                            </div>
                            <h6>Jenis Pemeriksaan Dahak</h6>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="bta"
                                    name="jenis_pemeriksaan[]" value="BTA"
                                    {{ in_array('BTA', $jenis_pemeriksaan ?? []) ? 'checked' : '' }}>
                                <label class="form-check-label" for="bta">BTA</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="tcm"
                                    name="jenis_pemeriksaan[]" value="TCM"
                                    {{ in_array('TCM', $jenis_pemeriksaan ?? []) ? 'checked' : '' }}>
                                <label class="form-check-label" for="tcm">TCM</label>
                            </div>
                        </div>
                    @endif


                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        @if (Auth::user()->role == 'dokter')
                            <button type="button" class="btn btn-success"
                                id="nextSectionButton{{ $action->id }}">Lanjut
                                Pemeriksaan</button>
                        @endif
                        <button type="submit" class="btn btn-primary">Simpan Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>


@include('component.modal-table-edit-pasien')
@include('component.modal-skrining-edit')
@include('component.modal-berobat-edit')
@include('component.modal-edit-action-obat')

<!-- jQuery harus PERTAMA -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- CSS -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css" />

<!-- JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.full.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<script>
    var nikValue = "{{ $action->patient->nik ?? '' }}";
    document.getElementById('nikEdit{{ $action->id }}').value = nikValue;
</script>
<script>
    $(document).ready(function() {
        const elementIds = [
            '#diagnosaEdit{{ $action->id }}',
            '#poliEdit{{ $action->id }}',
            '#rujuk_rs{{ $action->id }}',
            '#tindakanEdit{{ $action->id }}',
            '#diagnosaPrimerEdit{{ $action->id }}',
        ];

        // Apply select2 to each element in the array
        elementIds.forEach(function(id) {
            $(id).select2({
                placeholder: "Pilih",
                allowClear: true,
                minimumResultsForSearch: 0
            });
        });
    });
</script>

<style>
    .select2-dropdown {
        z-index: 9999 !important;
    }
</style>

<script>
    document.getElementById('nextSectionButton{{ $action->id }}').addEventListener('click', function() {
        const section1 = document.getElementById('formSection1{{ $action->id }}');
        const section2 = document.getElementById('formSection2{{ $action->id }}');
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
