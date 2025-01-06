<!-- Modal Add Action -->
<div class="modal fade" style="z-index: 1050;" id="editActionModal{{ $action->id }}" tabindex="-1"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                @if ($routeName === 'action.index')
                    <h5 class="modal-title" id="exampleModalLabel">TINDAKAN POLI UMUM</h5>
                @elseif ($routeName === 'action.index.gigi')
                    <h5 class="modal-title" id="exampleModalLabel">TINDAKAN POLI GIGI</h5>
                @else
                    <h5 class="modal-title" id="exampleModalLabel">TINDAKAN UGD</h5>
                @endif
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form id="addPatientForm" action="{{ route('action.update', $action->id) }}" method="POST"
                    class="px-3">
                    @csrf
                    @if ($routeName === 'action.index')
                        <input type="hidden" name="tipe" value="poli-umum">
                    @elseif($routeName === 'action.index.gigi')
                        <input type="hidden" name="tipe" value="poli-gigi">
                    @else
                        <input type="hidden" name="tipe" value="ruang-tindakan">
                    @endif
                    <div class="row">
                        <div class="col-4">
                            <h5>Detail Pasien</h5>
                            <div id="patientDetailsEdit" style=" margin-top: 10px; padding: 10px; border-radius: 5px;">
                                <p><strong>N I K</strong> : <span id="NIK">{{ $action->patient->nik }}</span></p>
                                <p><strong>Nama Pasien</strong> : <span
                                        id="Name">{{ $action->patient->name }}</span></p>
                                {{-- <p><strong>J.Kelamin</strong> : <span id="Gender">{{ $action->patient->genderName->name }}</span></p> --}}
                                <p><strong>Umur</strong> : <span id="Age"></span>
                                    {{ \Carbon\Carbon::parse($action->patient->dob)->age }}</p>
                                <p><strong>Telepon/WA</strong> : <span
                                        id="Phone">{{ $action->patient->phone }}</span></p>
                                <p><strong>Alamat</strong> : <span id="Address">{{ $action->patient->address }}</span>
                                </p>
                                <p><strong>Darah</strong> : <span
                                        id="Blood">{{ $action->patient->blood_type }}</span></p>
                                {{-- <p><strong>Pendidikan</strong> : <span id="Education">{{ $action->patient->educations->name }}</span></p> --}}
                                {{-- <p><strong>Pekerjaan</strong> : <span id="Job"></span>{{ $action->patient->occupations->name }}</p> --}}
                                <p><strong>Nomor RM</strong> : <span id="RmNumber">{{ $action->patient->no_rm }}</span>
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
                                                <input readonly type="text" class="form-control" id="nikEdit"
                                                    name="nikEdit" placeholder="NIK" required>
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
                                                value="{{ $action->tanggal }}" placeholder="Pilih Tanggal" required>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="doctor">Dokter</label>
                                            <select class="form-control" id="doctor" name="doctor" required>
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
                                            <select class="form-control" id="kunjungan" name="kunjungan" required>
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
                                                value="{{ $action->patient->jenis_kartu }}">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="nomor">Nomor Kartu</label>
                                            <input type="text" class="form-control" id="nomor" name="nomor"
                                                placeholder="Masukkan Nomor"
                                                value="{{ $action->patient->nomor_kartu }}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="wilayah_faskes">Wilayah Faskes</label>
                                            <select class="form-control" id="wilayah_faskes" name="faskes" required>
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
                                    <div class="col-md-12">
                                        <label for="keluhan" style="color: rgb(241, 11, 11);">Keluhan</label>
                                        <textarea class="form-control" id="keluhan" name="keluhan" placeholder="Keluhan">{{ old('keluhan', $action->keluhan ?? '') }}</textarea>
                                    </div>
                                    <div class="col-md-12">
                                        <label for="riwayat_penyakit_sekarang"
                                            style="color: rgb(241, 11, 11);">Riwayat
                                            Penyakit Sekarang</label>
                                        <textarea class="form-control" id="riwayat_penyakit_sekarang" name="riwayat_penyakit_sekarang"
                                            placeholder="Riwayat Penyakit Sekarang">{{ old('riwayat_penyakit_sekarang', $action->riwayat_penyakit_sekarang ?? '') }}</textarea>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="riwayat_penyakit_dulu"
                                                style="color: rgb(241, 11, 11);">Riwayat Penyakit Terdahulu</label>
                                            <select class="form-control" id="riwayat_penyakit_dulu"
                                                name="riwayat_penyakit_dulu" required>
                                                <option value="" disabled
                                                    {{ empty($action->riwayat_penyakit_dulu) ? 'selected' : '' }}>pilih
                                                </option>>Pilih</option>
                                                <option value="hipertensi"
                                                    {{ $action->riwayat_penyakit_dulu == 'hipertensi' ? 'selected' : '' }}>
                                                    Hipertensi</option>
                                                <option value="dm"
                                                    {{ $action->riwayat_penyakit_dulu == 'dm' ? 'selected' : '' }}>DM
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
                                                    {{ $action->riwayat_penyakit_dulu == 'tb' ? 'selected' : '' }}>TB
                                                </option>
                                                <option value="lainnya"
                                                    {{ $action->riwayat_penyakit_dulu == 'lainnya' ? 'selected' : '' }}>
                                                    Lainnya</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12 mt-2" id="penyakit_lainnya_container"
                                        style="display: none;">
                                        <label for="penyakit_lainnya" style="color: rgb(241, 11, 11);">Sebutkan
                                            Penyakit Lainnya</label>
                                        <textarea class="form-control" id="penyakit_lainnya" name="penyakit_lainnya" placeholder="Isi penyakit lainnya"><{{ old('penyakit_lainnya', $action->penyakit_lainnya ?? '') }}/textarea>
                                    </div>
                                    <div class="col-md-12">
                                        <label for="riwayat_pengobatan" style="color: rgb(241, 11, 11);">Riwayat
                                            Pengobatan</label>
                                        <textarea class="form-control" id="riwayat_pengobatan" name="riwayat_pengobatan" placeholder="Riwayat Pengobatan">{{ old('riwayat_pengobatan', $action->riwayat_pengobatan ?? '') }}</textarea>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="riwayat_penyakit_keluarga"
                                                style="color: rgb(241, 11, 11);">Riwayat Penyakit Keluarga</label>
                                            <select class="form-control" id="riwayat_penyakit_keluarga"
                                                name="riwayat_penyakit_keluarga" required>
                                                <option value="" disabled
                                                    {{ empty($action->riwayat_penyakit_keluarga) ? 'selected' : '' }}>
                                                    pilih
                                                </option>>Pilih</option>
                                                <option value="hipertensi"
                                                    {{ $action->riwayat_penyakit_keluarga == 'hipertensi' ? 'selected' : '' }}>
                                                    Hipertensi</option>
                                                <option value="dm"
                                                    {{ $action->riwayat_penyakit_keluarga == 'dm' ? 'selected' : '' }}>
                                                    DM
                                                </option>
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
                                                    TB
                                                </option>
                                                <option value="lainnya"
                                                    {{ $action->riwayat_penyakit_keluarga == 'lainnya' ? 'selected' : '' }}>
                                                    Lainnya</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12 mt-2" id="penyakit_lainnya_keluarga_container"
                                        style="display: none;">
                                        <label for="penyakit_lainnya_keluarga"
                                            style="color: rgb(241, 11, 11);">Sebutkan
                                            Penyakit Lainnya</label>
                                        <textarea class="form-control" id="penyakit_lainnya_keluarga" name="penyakit_lainnya_keluarga"
                                            placeholder="Isi penyakit lainnya">{{ old('riwayat_lainnya_keluarga', $action->riwayat_lainnya_keluarga ?? '') }}</textarea>
                                    </div>
                                    <div class="col-md-12">
                                        <label for="riwayat_alergi" style="color: rgb(241, 11, 11);">Riwayat
                                            Alergi</label>
                                        <textarea class="form-control" id="riwayat_alergi" name="riwayat_alergi" placeholder="Riwayat Alergi">{{ old('riwayat_alergi', $action->riwayat_alergi ?? '') }}</textarea>
                                    </div>

                                </div>
                            </div>
                            <div style="display: flex; align-items: center; text-align: center;">
                                <hr style="flex: 1; border: none; border-top: 1px solid #ccc;">
                                <span style="margin: 0 10px; white-space: nowrap;">Pemeriksaan</span>
                                <hr style="flex: 1; border: none; border-top: 1px solid #ccc;">
                            </div>

                            <div class="col-12">
                                <div class="row g-2">
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="sistol">Sistol</label>
                                            <input type="text" class="form-control" id="sistol" name="sistol"
                                                placeholder="Masukkan Sistol" required value="{{ $action->sistol }}">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="diastol">Diastol</label>
                                            <input type="text" class="form-control" id="diastol" name="diastol"
                                                placeholder="Masukkan Diastol" required
                                                value="{{ $action->diastol }}">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="berat_badan">Berat Badan</label>
                                            <input type="text" class="form-control" id="berat_badan"
                                                name="beratBadan" placeholder="Masukkan Berat Badan" required
                                                value="{{ $action->beratBadan }}">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="tinggi_badan">Tinggi Badan</label>
                                            <input type="text" class="form-control" id="tinggi_badan"
                                                name="tinggiBadan" placeholder="Masukkan Tinggi Badan" required
                                                value="{{ $action->tinggiBadan }}">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="ling_pinggang">Ling. Pinggang</label>
                                            <input type="text" class="form-control" id="ling_pinggang"
                                                name="lingkarPinggang" placeholder="Masukkan Ling. Pinggang" required
                                                value="{{ $action->lingkarPinggang }}">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="nadi">Nadi</label>
                                            <input type="text" class="form-control" id="nadi" name="nadi"
                                                placeholder="Masukkan Nadi" value="{{ $action->nandi }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="nafas">Pernafasan</label>
                                            <input type="text" class="form-control" id="nafas" name="nafas"
                                                placeholder="Masukkan Nafas" value="{{ $action->nafas }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="suhu">Suhu</label>
                                            <input type="text" class="form-control" id="suhu" name="suhu"
                                                placeholder="Masukkan Suhu" value="{{ $action->suhu }}"required>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            @if ($action->tipe == 'poli-umum' && Auth::user()->role == 'dokter')
                                <div style="display: flex; align-items: center; text-align: center;">
                                    <hr style="flex: 1; border: none; border-top: 1px solid #ccc;">
                                    <span style="margin: 0 10px; white-space: nowrap;">Pemeriksaan Fisik</span>
                                    <hr style="flex: 1; border: none; border-top: 1px solid #ccc;">
                                </div>
                                <div class="container">
                                    <div class="row g-2">

                                        <!-- Mata-Anemia -->
                                        <div class="col-md-2">
                                            <label for="mata_anemia" style="color: green;">Mata-Anemia</label>
                                            <select class="form-control" id="mata_anemia" name="mata_anemia">
                                                <option value="" disabled
                                                    {{ old('mata_anemia', $action->mata_anemia ?? '') == '' ? 'selected' : '' }}>
                                                    pilih</option>
                                                <option value="ya"
                                                    {{ old('mata_anemia', $action->mata_anemia ?? '') == 'ya' ? 'selected' : '' }}>
                                                    Ya</option>
                                                <option value="tidak"
                                                    {{ old('mata_anemia', $action->mata_anemia ?? '') == 'tidak' ? 'selected' : '' }}>
                                                    Tidak</option>
                                            </select>
                                        </div>
                                        <!-- Mata-Pupil -->
                                        <div class="col-md-2">
                                            <label for="pupil" style="color: green;">Mata-Pupil</label>
                                            <select class="form-control" id="pupil" name="pupil">
                                                <option value="" disabled
                                                    {{ old('pupil', $action->pupil ?? '') == '' ? 'selected' : '' }}>
                                                    pilih
                                                </option>
                                                <option value="isokor"
                                                    {{ old('pupil', $action->pupil ?? '') == 'isokor' ? 'selected' : '' }}>
                                                    Isokor</option>
                                                <option value="anisokor"
                                                    {{ old('pupil', $action->pupil ?? '') == 'anisokor' ? 'selected' : '' }}>
                                                    Anisokor</option>
                                            </select>
                                        </div>
                                        <!-- Mata-Ikterus -->
                                        <div class="col-md-2">
                                            <label for="ikterus" style="color: green;">Mata-Ikterus</label>
                                            <select class="form-control" id="ikterus" name="ikterus">
                                                <option value="" disabled
                                                    {{ old('ikterus', $action->ikterus ?? '') == '' ? 'selected' : '' }}>
                                                    pilih</option>
                                                <option value="ya"
                                                    {{ old('ikterus', $action->ikterus ?? '') == 'ya' ? 'selected' : '' }}>
                                                    Ya</option>
                                                <option value="tidak"
                                                    {{ old('ikterus', $action->ikterus ?? '') == 'tidak' ? 'selected' : '' }}>
                                                    Tidak</option>
                                            </select>
                                        </div>
                                        <!-- Mata-Udem Palpebral -->
                                        <div class="col-md-2">
                                            <label for="udem_palpebral" style="color: green;">Mata-Udem
                                                Palpebral</label>
                                            <select class="form-control" id="udem_palpebral" name="udem_palpebral">
                                                <option value="" disabled
                                                    {{ old('udem_palpebral', $action->udem_palpebral ?? '') == '' ? 'selected' : '' }}>
                                                    pilih</option>
                                                <option value="ya"
                                                    {{ old('udem_palpebral', $action->udem_palpebral ?? '') == 'ya' ? 'selected' : '' }}>
                                                    Ya</option>
                                                <option value="tidak"
                                                    {{ old('udem_palpebral', $action->udem_palpebral ?? '') == 'tidak' ? 'selected' : '' }}>
                                                    Tidak</option>
                                            </select>
                                        </div>
                                        <!-- Abdomen-Nyeri Tekan -->
                                        <div class="col-md-2">
                                            <label for="nyeri_tekan" style="color: green;">Abdomen-Nyeri Tekan</label>
                                            <select class="form-control" id="nyeri_tekan" name="nyeri_tekan">
                                                <option value="" disabled
                                                    {{ old('nyeri_tekan', $action->nyeri_tekan ?? '') == '' ? 'selected' : '' }}>
                                                    pilih</option>
                                                <option value="ya"
                                                    {{ old('nyeri_tekan', $action->nyeri_tekan ?? '') == 'ya' ? 'selected' : '' }}>
                                                    Ya</option>
                                                <option value="tidak"
                                                    {{ old('nyeri_tekan', $action->nyeri_tekan ?? '') == 'tidak' ? 'selected' : '' }}>
                                                    Tidak</option>
                                            </select>
                                        </div>
                                        <!-- Abdomen-Peristaltik -->
                                        <div class="col-md-2">
                                            <label for="peristaltik" style="color: green;">Abdomen-Peristaltik</label>
                                            <select class="form-control" id="peristaltik" name="peristaltik">
                                                <option value="" disabled
                                                    {{ old('peristaltik', $action->peristaltik ?? '') == '' ? 'selected' : '' }}>
                                                    pilih</option>
                                                <option value="normal"
                                                    {{ old('peristaltik', $action->peristaltik ?? '') == 'normal' ? 'selected' : '' }}>
                                                    Normal</option>
                                                <option value="meningkat"
                                                    {{ old('peristaltik', $action->peristaltik ?? '') == 'meningkat' ? 'selected' : '' }}>
                                                    Meningkat</option>
                                                <option value="menurun"
                                                    {{ old('peristaltik', $action->peristaltik ?? '') == 'menurun' ? 'selected' : '' }}>
                                                    Menurun</option>
                                            </select>
                                        </div>
                                        <!-- Abdomen-Ascites -->
                                        <div class="col-md-2">
                                            <label for="ascites" style="color: green;">Abdomen-Ascites</label>
                                            <select class="form-control" id="ascites" name="ascites">
                                                <option value="" disabled
                                                    {{ old('ascites', $action->ascites ?? '') == '' ? 'selected' : '' }}>
                                                    pilih</option>
                                                <option value="ya"
                                                    {{ old('ascites', $action->ascites ?? '') == 'ya' ? 'selected' : '' }}>
                                                    Ya</option>
                                                <option value="tidak"
                                                    {{ old('ascites', $action->ascites ?? '') == 'tidak' ? 'selected' : '' }}>
                                                    Tidak</option>
                                            </select>
                                        </div>

                                        <div class="col-md-2">
                                            <label for="lokasi_abdomen" style="color: green;">Abdomen-Lokasi</label>
                                            <input type="text" class="form-control" id="lokasi_abdomen"
                                                name="lokasi_abdomen"
                                                value="{{ old('lokasi_abdomen', $action->lokasi_abdomen ?? '') }}"
                                                placeholder="Lokasi Abdomen">
                                        </div>
                                        <div class="col-md-2">
                                            <label for="thorax" style="color: green;">Thorax</label>
                                            <select class="form-control" id="thorax" name="thorax">
                                                <option value="" disabled
                                                    {{ old('thorax', $action->thorax ?? '') == '' ? 'selected' : '' }}>
                                                    pilih</option>
                                                <option value="simetris"
                                                    {{ old('thorax', $action->thorax ?? '') == 'simetris' ? 'selected' : '' }}>
                                                    Simetris</option>
                                                <option value="asimetris"
                                                    {{ old('thorax', $action->thorax ?? '') == 'asimetris' ? 'selected' : '' }}>
                                                    Asimetris</option>
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <label for="thorax_bj" style="color: green;">Thorax-BJ I/II</label>
                                            <select class="form-control" id="thorax_bj" name="thorax_bj">
                                                <option value="" disabled
                                                    {{ old('thorax_bj', $action->thorax_bj ?? '') == '' ? 'selected' : '' }}>
                                                    pilih</option>
                                                <option value="regular"
                                                    {{ old('thorax_bj', $action->thorax_bj ?? '') == 'regular' ? 'selected' : '' }}>
                                                    Regular</option>
                                                <option value="irregular"
                                                    {{ old('thorax_bj', $action->thorax_bj ?? '') == 'irregular' ? 'selected' : '' }}>
                                                    Irregular</option>
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <label for="suara_nafas" style="color: green;">Thorax-Suara Nafas</label>
                                            <select class="form-control" id="suara_nafas" name="suara_nafas">
                                                <option value="" disabled
                                                    {{ old('suara_nafas', $action->suara_nafas ?? '') == '' ? 'selected' : '' }}>
                                                    pilih</option>
                                                <option value="ya"
                                                    {{ old('suara_nafas', $action->suara_nafas ?? '') == 'vesikuler' ? 'selected' : '' }}>
                                                    Vesikuler</option>
                                                <option value="tidak"
                                                    {{ old('suara_nafas', $action->suara_nafas ?? '') == 'bronkoveskuler' ? 'selected' : '' }}>
                                                    Bronkoveskuler</option>
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <label for="ronchi" style="color: green;">Thorax-Ronchi</label>
                                            <select class="form-control" id="ronchi" name="ronchi">
                                                <option value="" disabled
                                                    {{ old('ronchi', $action->ronchi ?? '') == '' ? 'selected' : '' }}>
                                                    pilih</option>
                                                <option value="ya"
                                                    {{ old('ronchi', $action->ronchi ?? '') == 'ya' ? 'selected' : '' }}>
                                                    Ya</option>
                                                <option value="tidak"
                                                    {{ old('ronchi', $action->ronchi ?? '') == 'tidak' ? 'selected' : '' }}>
                                                    Tidak</option>
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <label for="wheezing" style="color: green;">Thorax-Wheezing</label>
                                            <select class="form-control" id="wheezing" name="wheezing">
                                                <option value="" disabled
                                                    {{ old('wheezing', $action->wheezing ?? '') == '' ? 'selected' : '' }}>
                                                    pilih</option>
                                                <option value="ya"
                                                    {{ old('wheezing', $action->wheezing ?? '') == 'ya' ? 'selected' : '' }}>
                                                    Ya</option>
                                                <option value="tidak"
                                                    {{ old('wheezing', $action->wheezing ?? '') == 'tidak' ? 'selected' : '' }}>
                                                    Tidak</option>
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <label for="ekstremitas" style="color: green;">Ekstremitas</label>
                                            <select class="form-control" id="ekstremitas" name="ekstremitas">
                                                <option value="" disabled
                                                    {{ old('ekstremitas', $action->ekstremitas ?? '') == '' ? 'selected' : '' }}>
                                                    pilih</option>
                                                <option value="hangat"
                                                    {{ old('ekstremitas', $action->ekstremitas ?? '') == 'hangat' ? 'selected' : '' }}>
                                                    Hangat</option>
                                                <option value="dingin"
                                                    {{ old('ekstremitas', $action->ekstremitas ?? '') == 'dingin' ? 'selected' : '' }}>
                                                    Dingin</option>
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <label for="edema" style="color: green;">Ekstremitas-Edema</label>
                                            <select class="form-control" id="edema" name="edema">
                                                <option value="" disabled
                                                    {{ old('edema', $action->edema ?? '') == '' ? 'selected' : '' }}>
                                                    pilih
                                                </option>
                                                <option value="ya"
                                                    {{ old('edema', $action->edema ?? '') == 'ya' ? 'selected' : '' }}>
                                                    Ya
                                                </option>
                                                <option value="tidak"
                                                    {{ old('edema', $action->edema ?? '') == 'tidak' ? 'selected' : '' }}>
                                                    Tidak</option>
                                                <option value="lainnya"
                                                    {{ old('edema', $action->edema ?? '') == 'lainnya' ? 'selected' : '' }}>
                                                    Lainnya</option>
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <label for="tonsil" style="color: green;">THT-Tonsil</label>
                                            <input type="text" class="form-control" id="tonsil" name="tonsil"
                                                value="{{ old('tonsil', $action->tonsil ?? '') }}"
                                                placeholder="Tonsil">
                                        </div>
                                        <div class="col-md-2">
                                            <label for="fharing" style="color: green;">THT-Fharing</label>
                                            <input type="text" class="form-control" id="fharing" name="fharing"
                                                value="{{ old('fharing', $action->fharing ?? '') }}"
                                                placeholder="Fharing">
                                        </div>
                                        <div class="col-md-2">
                                            <label for="kelenjar" style="color: green;">Leher-Pembesaran
                                                Kelenjar</label>
                                            <input type="text" class="form-control" id="kelenjar"
                                                name="kelenjar"
                                                value="{{ old('kelenjar', $action->kelenjar ?? '') }}"
                                                placeholder="Pembesaran Kelenjar">
                                        </div>
                                        <div class="col-md-2">
                                            <label for="genetalia" style="color: green;">Genetalia</label>
                                            <input type="text" class="form-control" id="genetalia"
                                                name="genetalia"
                                                value="{{ old('genetalia', $action->genetalia ?? '') }}"
                                                placeholder="Genetalia Jika Diperlukan">
                                        </div>
                                        <div class="col-md-2">
                                            <label for="warna_kulit" style="color: green;">Kulit-Warna</label>
                                            <input type="text" class="form-control" id="warna_kulit"
                                                name="warna_kulit"
                                                value="{{ old('warna_kulit', $action->warna_kulit ?? '') }}"
                                                placeholder="Warna Kulit">
                                        </div>
                                        <div class="col-md-2">
                                            <label for="turgor" style="color: green;">Kulit-Turgor</label>
                                            <input type="text" class="form-control" id="turgor" name="turgor"
                                                value="{{ old('turgor', $action->turgor ?? '') }}"
                                                placeholder="Turgor Kulit">
                                        </div>
                                        <div class="col-md-2">
                                            <label for="neurologis" style="color: green;">Pemeriksaan
                                                Neurologis</label>
                                            <input type="text" class="form-control" id="neurologis"
                                                name="neurologis"
                                                value="{{ old('neurologis', $action->neurologis ?? '') }}"
                                                placeholder="Pemeriksaan Neurologis Jika Diperlukan">
                                        </div>
                                    </div>
                                </div>
                                <div style="display: flex; align-items: center; text-align: center;">
                                    <hr style="flex: 1; border: none; border-top: 1px solid #ccc;">
                                    <span style="margin: 0 10px; white-space: nowrap;">Pemeriksaan Penunjang</span>
                                    <hr style="flex: 1; border: none; border-top: 1px solid #ccc;">
                                </div>
                                <div class="container">
                                    <div class="row g-2">
                                        <div class="col-md-12">
                                            <label for="hasil_lab" style="color: green;">Hasil Laboratorium</label>
                                            <input type="text" class="form-control" id="hasil_lab"
                                                name="hasil_lab"
                                                value="{{ old('hasil_lab', $action->hasil_lab ?? '') }}"
                                                placeholder="Hasil Laboratorium">
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                    @if (Auth::user()->role == 'dokter')
                        <div class="row mt-3">
                            <div class="col-md-4">
                                <label for="diagnosaEdit" style="color: rgb(19, 11, 241);">DIAGNOSA</label>
                                <select class="form-control" id="diagnosaEdit" name="diagnosa[]" multiple>
                                    @foreach ($diagnosa as $item)
                                        <option value="{{ $item->id }}"
                                            {{ in_array($item->id, old('diagnosa', $action->diagnosa ?? [])) ? 'selected' : '' }}>
                                            {{ $item->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-4">
                                <label for="pemeriksaan_penunjang" style="color: rgb(19, 11, 241);">Pemeriksaan
                                    Penunjang</label>
                                <textarea class="form-control" id="pemeriksaan_penunjang" name="pemeriksaan_penunjang"
                                    placeholder="Pemeriksaan penunjang">{{ old('pemeriksaan_penunjang', $action->pemeriksaan_penunjang ?? '') }}</textarea>
                            </div>
                            <div class="col-md-4">
                                <label for="tindakanEdit" style="color: rgb(19, 11, 241);">TINDAKAN</label>
                                <select class="form-control" id="tindakanEdit" name="tindakan">
                                    <option value="" {{ empty($action->tindakan) ? 'selected' : '' }} disabled
                                        selected>pilih</option>
                                    @if ($action->tipe == 'poli-umum')
                                        <option value="Diberikan Obat"
                                            {{ old('tindakan', $action->tindakan ?? '') == 'Diberikan Obat' ? 'selected' : '' }}>
                                            Diberikan Obat</option>
                                        <option value="Dirujuk"
                                            {{ old('tindakan', $action->tindakan ?? '') == 'Dirujuk' ? 'selected' : '' }}>
                                            Dirujuk
                                        </option>
                                    @elseif($action->tipe == 'poli-gigi')
                                        <option value="Gigi Sulung Tumpatan Sementara"
                                            {{ old('tindakan', $action->tindakan ?? '') == 'Gigi Sulung Tumpatan Sementara' ? 'selected' : '' }}>
                                            Gigi Sulung Tumpatan Sementara
                                        </option>
                                        <option value="Tidak Ada"
                                            {{ old('tindakan', $action->tindakan ?? '') == 'Tidak Ada' ? 'selected' : '' }}>
                                            Tidak Ada
                                        </option>
                                        <option value="Gigi Tetap Tumpatan Tetap"
                                            {{ old('tindakan', $action->tindakan ?? '') == 'Gigi Tetap Tumpatan Tetap' ? 'selected' : '' }}>
                                            Gigi Tetap Tumpatan Tetap
                                        </option>
                                        <option value="Gigi Sulung Tumpatan Tetap"
                                            {{ old('tindakan', $action->tindakan ?? '') == 'Gigi Sulung Tumpatan Tetap' ? 'selected' : '' }}>
                                            Gigi Sulung Tumpatan Tetap
                                        </option>
                                        <option value="Perawatan Saluran Akar"
                                            {{ old('tindakan', $action->tindakan ?? '') == 'Perawatan Saluran Akar' ? 'selected' : '' }}>
                                            Perawatan Saluran Akar
                                        </option>
                                        <option value="Gigi Sulung Pencabutan"
                                            {{ old('tindakan', $action->tindakan ?? '') == 'Gigi Sulung Pencabutan' ? 'selected' : '' }}>
                                            Gigi Sulung Pencabutan
                                        </option>
                                        <option value="Gigi Tetap Pencabutan"
                                            {{ old('tindakan', $action->tindakan ?? '') == 'Gigi Tetap Pencabutan' ? 'selected' : '' }}>
                                            Gigi Tetap Pencabutan
                                        </option>
                                        <option value="Pembersihan Karang Gigi"
                                            {{ old('tindakan', $action->tindakan ?? '') == 'Pembersihan Karang Gigi' ? 'selected' : '' }}>
                                            Pembersihan Karang Gigi
                                        </option>
                                        <option value="Odontectomy"
                                            {{ old('tindakan', $action->tindakan ?? '') == 'Odontectomy' ? 'selected' : '' }}>
                                            Odontectomy
                                        </option>
                                        <option value="Sebagian Prothesa"
                                            {{ old('tindakan', $action->tindakan ?? '') == 'Sebagian Prothesa' ? 'selected' : '' }}>
                                            Sebagian Prothesa
                                        </option>
                                        <option value="Penuh Prothesa"
                                            {{ old('tindakan', $action->tindakan ?? '') == 'Penuh Prothesa' ? 'selected' : '' }}>
                                            Penuh Prothesa
                                        </option>
                                        <option value="Reparasi Prothesa"
                                            {{ old('tindakan', $action->tindakan ?? '') == 'Reparasi Prothesa' ? 'selected' : '' }}>
                                            Reparasi Prothesa
                                        </option>
                                        <option value="Premedikasi"
                                            {{ old('tindakan', $action->tindakan ?? '') == 'Premedikasi' ? 'selected' : '' }}>
                                            Premedikasi/Pengobatan
                                        </option>
                                        <option value="Tindakan Lain"
                                            {{ old('tindakan', $action->tindakan ?? '') == 'Tindakan Lain' ? 'selected' : '' }}>
                                            Tindakan Lain
                                        </option>
                                        <option value="Incici Abses Gigi"
                                            {{ old('tindakan', $action->tindakan ?? '') == 'Incici Abses Gigi' ? 'selected' : '' }}>
                                            Incici Abses Gigi</option>
                                    @else
                                        <option value="Observasi Tanpa Tindakan Invasif"
                                            {{ old('tindakan', $action->tindakan ?? '') == 'Observasi Tanpa Tindakan Invasif' ? 'selected' : '' }}>
                                            Observasi Tanpa Tindakan Invasif
                                        </option>
                                        <option value="Observasi Dengan Tindakan Invasif"
                                            {{ old('tindakan', $action->tindakan ?? '') == 'Observasi Dengan Tindakan Invasif' ? 'selected' : '' }}>
                                            Observasi Dengan Tindakan Invasif
                                        </option>
                                        <option value="Tidak Ada"
                                            {{ old('tindakan', $action->tindakan ?? '') == 'Tidak Ada' ? 'selected' : '' }}>
                                            Tidak Ada
                                        </option>
                                        <option value="Corpus Alineum"
                                            {{ old('tindakan', $action->tindakan ?? '') == 'Corpus Alineum' ? 'selected' : '' }}>
                                            Corpus Alineum
                                        </option>
                                        <option value="Ekstraksi Kuku"
                                            {{ old('tindakan', $action->tindakan ?? '') == 'Ekstraksi Kuku' ? 'selected' : '' }}>
                                            Ekstraksi Kuku
                                        </option>
                                        <option value="Sircumsisi (Bedah Ringan)"
                                            {{ old('tindakan', $action->tindakan ?? '') == 'Sircumsisi (Bedah Ringan)' ? 'selected' : '' }}>
                                            Sircumsisi (Bedah Ringan)
                                        </option>
                                        <option value="Incisi Abses"
                                            {{ old('tindakan', $action->tindakan ?? '') == 'Incisi Abses' ? 'selected' : '' }}>
                                            Incisi Abses
                                        </option>
                                        <option value="Rawat Luka"
                                            {{ old('tindakan', $action->tindakan ?? '') == 'Rawat Luka' ? 'selected' : '' }}>
                                            Rawat Luka
                                        </option>
                                        <option value="Ganti Verban"
                                            {{ old('tindakan', $action->tindakan ?? '') == 'Ganti Verban' ? 'selected' : '' }}>
                                            Ganti Verban
                                        </option>
                                        <option value="Spooling"
                                            {{ old('tindakan', $action->tindakan ?? '') == 'Spooling' ? 'selected' : '' }}>
                                            Spooling
                                        </option>
                                        <option value="Toilet Telinga"
                                            {{ old('tindakan', $action->tindakan ?? '') == 'Toilet Telinga' ? 'selected' : '' }}>
                                            Toilet Telinga
                                        </option>
                                        <option value="Tetes Telinga"
                                            {{ old('tindakan', $action->tindakan ?? '') == 'Tetes Telinga' ? 'selected' : '' }}>
                                            Tetes Telinga
                                        </option>
                                        <option value="Aff Hecting"
                                            {{ old('tindakan', $action->tindakan ?? '') == 'Aff Hecting' ? 'selected' : '' }}>
                                            Aff Hecting
                                        </option>
                                        <option value="Hecting (Jahit Luka)"
                                            {{ old('tindakan', $action->tindakan ?? '') == 'Hecting (Jahit Luka)' ? 'selected' : '' }}>
                                            Hecting (Jahit Luka)</option>
                                        <option value="Tampon/Off Tampon"
                                            {{ old('tindakan', $action->tindakan ?? '') == 'Tampon/Off Tampon' ? 'selected' : '' }}>
                                            Tampon/Off Tampon</option>
                                    @endif
                                </select>
                            </div>
                        </div>
                    @endif

                    <div class="row mt-3">
                        @if (Auth::user()->role == 'dokter')
                            <div class="col-md-4">
                                <label for="obat" style="color: rgb(19, 11, 241);">Obat</label>
                                <textarea class="form-control" id="obat" name="obat" placeholder="Obat">{{ old('obat', $action->obat ?? '') }}</textarea>
                            </div>
                            <div class="col-md-4">
                                <label for="rujuk_rs" style="color: rgb(19, 11, 241);">RUJUK RS</label>
                                <select class="form-control" id="rujuk_rs" name="rujuk_rs">
                                    <option value="" disabled selected>pilih</option>
                                    @foreach ($rs as $item)
                                        <option value="{{ $item->id }}"
                                            {{ old('rujuk_rs', $action->rujuk_rs ?? '') == $item->id ? 'selected' : '' }}>
                                            {{ $item->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        @endif
                        <div class="col-md-4">
                            <label for="keterangan" style="color: rgb(19, 11, 241);">KETERANGAN</label>
                            <input type="text" class="form-control" id="keterangan" name="keterangan"
                                value="{{ old('keterangan', $action->keterangan ?? '') }}" placeholder="Keterangan"
                                required>
                        </div>
                    </div>

            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
        <button type="submit" class="btn btn-primary">Simpan Data</button>
        </form>
    </div>
</div>


@include('component.modal-table-edit-pasien')

<script>
    var nikValue = "{{ $action->patient->nik ?? '' }}";
    document.getElementById('nikEdit').value = nikValue;
    //  console.log(nikValue);
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
    // Initialize Flatpickr for the date picker
    document.addEventListener('DOMContentLoaded', function() {
        const selectElement = document.getElementById('riwayat_penyakit_dulu');
        const selectPenyakitKeluargaElement = document.getElementById('riwayat_penyakit_keluarga');
        const lainnyaContainer = document.getElementById('penyakit_lainnya_container');
        const lainnyaTextarea = document.getElementById('penyakit_lainnya');
        const lainnyaKeluargaContainer = document.getElementById('penyakit_lainnya_keluarga_container');
        const lainnyaKeluargaTextarea = document.getElementById('penyakit_keluarga_lainnya');

        selectElement.addEventListener('change', function() {
            if (this.value === 'lainnya') {
                lainnyaContainer.style.display = 'block';
                lainnyaTextarea.required = true;
            } else {
                lainnyaContainer.style.display = 'none';
                lainnyaTextarea.value = '';
                lainnyaTextarea.required = false;
            }
        });
        selectPenyakitKeluargaElement.addEventListener('change', function() {
            if (this.value === 'lainnya') {
                lainnyaKeluargaContainer.style.display = 'block';
                lainnyaKeluargaTextarea.required = true;
            } else {
                lainnyaKeluargaContainer.style.display = 'none';
                lainnyaKeluargaTextarea.value = '';
                lainnyaKeluargaTextarea.required = false;
            }
        });

    });
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

<!-- Flatpickr CSS -->
<link href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" rel="stylesheet">

<!-- Flatpickr JS -->
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
