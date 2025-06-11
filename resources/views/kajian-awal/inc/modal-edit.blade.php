<!-- Modal Add Action -->
@php
	if (!isset($poli)) {
		$poli = App\Models\Poli::all();
	}

	if (!isset($diagnosa)) {
		$diagnosa = App\Models\Diagnosis::all();
	}
@endphp
<style>
    .form-check-input-edit {
        width: 20px !important;
        height: 20px !important;
        cursor: pointer !important;
    }

    .form-check-label {
        font-size: 16px;
        margin-left: 8px;
    }
</style>

	<div class="modal-header bg-primary">
	    @if ($routeName === 'action.dokter.index')
	        <h5 class="modal-title" id="exampleModalLabel">TINDAKAN POLI UMUM</h5>
	    @elseif ($routeName === 'action.dokter.gigi.index')
	        <h5 class="modal-title" id="exampleModalLabel">TINDAKAN POLI GIGI</h5>
	    @elseif ($routeName === 'kia.dokter.index')
	        <h5 class="modal-title" id="exampleModalLabel">TINDAKAN POLI KIA</h5>
	    @elseif ($routeName === 'kb.dokter.index')
	        <h5 class="modal-title" id="exampleModalLabel">TINDAKAN POLI KB</h5>
	    @elseif ($routeName === 'action.dokter.ruang.tindakan.index')
	        <h5 class="modal-title" id="exampleModalLabel">TINDAKAN RUANG TINDAKAN</h5>
	    @elseif ($routeName === 'action.index.data')
	        <h5 class="modal-title" id="exampleModalLabel">KAJIAN AWAL POLI UMUM</h5>
	        <input type="hidden" name="tipe" value="poli-umum">
	    @elseif($routeName === 'action.index.gigi')
	        <h5 class="modal-title" id="exampleModalLabel">KAJIAN AWAL POLI GIGI</h5>
	        <input type="hidden" name="tipe" value="poli-gigi">
	    @elseif($routeName === 'action.kia.index')
	        <h5 class="modal-title" id="exampleModalLabel">KAJIAN AWAL POLI KIA</h5>
	        <input type="hidden" name="tipe" value="poli-kia">
	    @elseif($routeName === 'action.kb.index')
	        <h5 class="modal-title" id="exampleModalLabel">KAJIAN AWAL POLI KB</h5>
	        <input type="hidden" name="tipe" value="poli-kia">
	    @elseif($routeName === 'action.ugd.index')
	        <h5 class="modal-title" id="exampleModalLabel">KAJIAN AWAL UGD</h5>
	        <input type="hidden" name="tipe" value="ruang-tindakan">
	    @else
	        <h5 class="modal-title" id="exampleModalLabel">TINDAKAN UGD</h5>
	    @endif
	    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
	</div>

	<div class="modal-body">
	    <form id="editPatientForm{{ $action->id }}" action="{{ route('action.update', $action->id) }}"
	        method="POST" class="px-3">
	        <div id="formSection1{{ $action->id }}" class="form-section">
	            @csrf
	            @if ($routeName === 'action.index' || 'action.dokter.index')
	                <input type="hidden" name="tipe" value="poli-umum">
	            @elseif($routeName === 'action.index.gigi' || 'action.dokter.gigi.index')
	                <input type="hidden" name="tipe" value="poli-gigi">
	            @elseif ($routeName === 'action.kia.index' || 'kia.dokter.index')
	                <input type="hidden" name="tipe" value="poli-kia">
	            @elseif ($routeName === 'action.kb.index' || 'kb.dokter.index')
	                <input type="hidden" name="tipe" value="poli-kb">
	            @else
	                <input type="hidden" name="tipe" value="ruang-tindakan">
	            @endif
	            <div class="row">
	                <div class="col-4">
	                    <h5>Detail Pasien</h5>
	                    <div id="patientDetailsEdit"
	                        style=" margin-top: 10px; padding: 10px; border-radius: 5px;">
	                        <p><strong>N I K</strong> : <span
	                                id="NIK{{ $action->id }}">{{ $action->patient->nik ?? '' }}</span></p>
	                        <p><strong>Nama Pasien</strong> : <span
	                                id="Name{{ $action->id }}">{{ $action->patient->name ?? '' }}</span></p>
	                        {{-- <p><strong>J.Kelamin</strong> : <span id="Gender">{{ $action->patient->genderName->name }}</span></p> --}}
	                        <p><strong>Umur</strong> : <span id="Age"></span>
	                            @if (optional($action->patient)->dob)
	                                {{ \Carbon\Carbon::parse($action->patient->dob)->age }}
	                            @else
	                                -
	                            @endif
	                        </p>
	                        <p><strong>Telepon/WA</strong> : <span
	                                id="Phone{{ $action->id }}">{{ $action->patient->phone ?? '' }}</span>
	                        </p>
	                        <p><strong>Alamat</strong> : <span
	                                id="Address">{{ $action->patient->address ?? '' }}</span>
	                        </p>
	                        <p><strong>Darah</strong> : <span
	                                id="Blood{{ $action->id }}">{{ $action->patient->blood_type ?? '' }}</span>
	                        </p>
	                        {{-- <p><strong>Pendidikan</strong> : <span id="Education">{{ $action->patient->educations->name }}</span></p> --}}
	                        {{-- <p><strong>Pekerjaan</strong> : <span id="Job"></span>{{ $action->patient->occupations->name }}</p> --}}
	                        <p><strong>Nomor RM</strong> : <span
	                                id="RmNumber{{ $action->id }}">{{ $action->patient->no_rm ?? '' }}</span>
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
	                                    <input type="date" class="form-control" id="tanggal"
	                                        name="tanggal" value="{{ $action->tanggal }}"
	                                        placeholder="Pilih Tanggal">
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
	                            @if (Auth::user()->role != 'admin-kajian-awal')
	                                <div class="col-md-3">
	                                    <div class="form-group">
	                                        <label for="kasus">Kasus</label>
	                                        <select class="form-control" id="kasus" name="kasus">
	                                            <option value="" disabled
	                                                {{ empty($action->kasus) ? 'selected' : '' }}>Pilih Jenis
	                                                Kasus</option>
	                                            <option value="1"
	                                                {{ $action->kasus == '1' ? 'selected' : '' }}>Baru
	                                            </option>
	                                            <option value="0"
	                                                {{ $action->kasus == '0' ? 'selected' : '' }}>Lama
	                                            </option>
	                                        </select>
	                                    </div>
	                                </div>
	                            @endif
	                        </div>
	                    </div>
	                    <div class="col-12">
	                        <div class="row g-2">
	                            <div class="col-md-3">
	                                <div class="form-group">
	                                    <label for="kartu">Kartu</label>
	                                    <input type="text" class="form-control" id="jenis_kartu"
	                                        name="jenis_kartu" readonly
	                                        value="{{ match (optional($action->patient)->jenis_kartu) {
	                                            'pbi' => 'PBI (KIS)',
	                                            'askes' => 'ASKES',
	                                            'jkn_mandiri' => 'JKN Mandiri',
	                                            'umum' => 'Umum',
	                                            'jkd' => 'JKD',
	                                            default => 'Tidak Diketahui',
	                                        } }}">
	                                </div>

	                            </div>
	                            <div class="col-md-3">
	                                <div class="form-group">
	                                    <label for="nomor">Nomor Kartu</label>
	                                    <input type="text" class="form-control"
	                                        id="nomor_kartu{{ $action->id }}" name="nomor"
	                                        placeholder="Masukkan Nomor"
	                                        value="{{ $action->patient->nomor_kartu ?? '' }}" readonly>
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
	                            @if (
	                                $routeName == 'action.dokter.index' ||
	                                    Auth::user()->role == 'admin-kajian-awal' ||
	                                    $routeName == 'action.dokter.gigi.index' ||
	                                    $routeName == 'action.dokter.ruang.tindakan.index' ||
	                                    $routeName == 'action.kia.dokter.index' ||
	                                    $routeName == 'action.dokter.kb.index' ||
	                                    $routeName == 'action.dokter.ugd.index')
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
	                                            style="color: rgb(241, 11, 11);">Riwayat Penyakit
	                                            Terdahulu</label>
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
	                                    <label for="penyakit_lainnya"
	                                        style="color: rgb(241, 11, 11);">Sebutkan
	                                        Penyakit Lainnya</label>
	                                    <textarea class="form-control" id="penyakit_lainnya_edit" name="riwayat_penyakit_lainnya"
	                                        placeholder="Isi penyakit lainnya">{{ old('penyakit_lainnya', $action->riwayat_penyakit_lainnya ?? '') }}</textarea>

	                                </div>
	                                <div class="col-md-12">
	                                    <label for="riwayat_pengobatan"
	                                        style="color: rgb(241, 11, 11);">Riwayat
	                                        Pengobatan</label>
	                                    <textarea class="form-control" id="riwayat_pengobatan" name="riwayat_pengobatan" placeholder="Riwayat Pengobatan">{{ old('riwayat_pengobatan', $action->riwayat_pengobatan ?? '') }}</textarea>
	                                </div>
	                                <div class="col-md-12">
	                                    <div class="form-group">
	                                        <label for="riwayat_penyakit_keluarga"
	                                            style="color: rgb(241, 11, 11);">Riwayat Penyakit
	                                            Keluarga</label>
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
	                                    <label for="penyakit_lainnya_keluarga"
	                                        style="color: rgb(241, 11, 11);">Sebutkan
	                                        Penyakit Lainnya</label>
	                                    <textarea class="form-control" id="penyakit_lainnya_keluarga_edit" name="riwayat_penyakit_lainnya_keluarga"
	                                        placeholder="Isi penyakit lainnya">{{ old('riwayat_penyakit_lainnya_keluarga', $action->riwayat_penyakit_lainnya_keluarga ?? '') }}</textarea>
	                                </div>
	                                <div class="col-md-12">
	                                    <label for="riwayat_alergi" style="color: rgb(241, 11, 11);">Riwayat
	                                        Alergi</label>
	                                    <textarea class="form-control" id="riwayat_alergi" name="riwayat_alergi" placeholder="Riwayat Alergi">{{ old('riwayat_alergi', $action->riwayat_alergi ?? '') }}</textarea>
	                                </div>
	                            @endif

	                        </div>
	                    </div>
	                    @if ($routeName != 'action.kia.index' && $routeName != 'action.kb.index')
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
	                                        <input type="text" class="form-control" id="sistol"
	                                            name="sistol" placeholder="Masukkan Sistol"
	                                            value="{{ $action->sistol }}">
	                                    </div>
	                                </div>
	                                <div class="col-md-2">
	                                    <div class="form-group">
	                                        <label for="diastol">Diastol</label>
	                                        <input type="text" class="form-control" id="diastol"
	                                            name="diastol" placeholder="Masukkan Diastol"
	                                            value="{{ $action->diastol }}">
	                                    </div>
	                                </div>
	                                <div class="col-md-2">
	                                    <div class="form-group">
	                                        <label for="berat_badan">Berat Badan</label>
	                                        <input type="text" class="form-control" id="berat_badan"
	                                            name="beratBadan" placeholder="Masukkan Berat Badan"
	                                            value="{{ $action->beratBadan }}">
	                                    </div>
	                                </div>
	                                <div class="col-md-2">
	                                    <div class="form-group">
	                                        <label for="tinggi_badan">Tinggi Badan</label>
	                                        <input type="text" class="form-control" id="tinggi_badan"
	                                            name="tinggiBadan" placeholder="Masukkan Tinggi Badan"
	                                            value="{{ $action->tinggiBadan }}">
	                                    </div>
	                                </div>
	                                <div class="col-md-2">
	                                    <div class="form-group">
	                                        <label for="ling_pinggang">Ling. Pinggang</label>
	                                        <input type="text" class="form-control" id="ling_pinggang"
	                                            name="lingkarPinggang" placeholder="Masukkan Ling. Pinggang"
	                                            value="{{ $action->lingkarPinggang }}">
	                                    </div>
	                                </div>
	                                <div class="col-md-2">
	                                    <div class="form-group">
	                                        <label for="nadi">Nadi</label>
	                                        <input type="text" class="form-control" id="nadi"
	                                            name="nadi" placeholder="Masukkan Nadi"
	                                            value="{{ $action->nadi }}">
	                                    </div>
	                                </div>
	                                <div class="col-md-2">
	                                    <div class="form-group">
	                                        <label for="nafas">Pernafasan</label>
	                                        <input type="text" class="form-control" id="nafas"
	                                            name="nafas" placeholder="Masukkan Nafas"
	                                            value="{{ $action->nafas }}">
	                                    </div>
	                                </div>
	                                <div class="col-md-2">
	                                    <div class="form-group">
	                                        <label for="suhu">Suhu</label>
	                                        <input type="text" class="form-control" id="suhu"
	                                            name="suhu" placeholder="Masukkan Suhu"
	                                            value="{{ $action->suhu }}">
	                                    </div>
	                                </div>

	                            </div>
	                        </div>
	                    @endif
	                    @if ($action->tipe == 'poli-umum' && Auth::user()->role == 'dokter')
	                        <div
	                            style="display:
	                                        flex; align-items: center; text-align: center;">
	                            <hr style="flex: 1; border: none; border-top: 1px solid #ccc;">
	                            <span style="margin: 0 10px; white-space: nowrap;">Pemeriksaan
	                                Fisik</span>
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
	                                    <select class="form-control" id="udem_palpebral"
	                                        name="udem_palpebral">
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
	                                    <label for="nyeri_tekan" style="color: green;">Abdomen-Nyeri
	                                        Tekan</label>
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
	                                    <label for="peristaltik"
	                                        style="color: green;">Abdomen-Peristaltik</label>
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
	                                    <label for="lokasi_abdomen"
	                                        style="color: green;">Abdomen-Lokasi</label>
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
	                                    <label for="thorax_bj" style="color: green;">Thorax-BJ
	                                        I/II</label>
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
	                                    <label for="suara_nafas" style="color: green;">Thorax-Suara
	                                        Nafas</label>
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
	                                    <input type="text" class="form-control" id="tonsil"
	                                        name="tonsil"
	                                        value="{{ old('tonsil', $action->tonsil ?? '') }}"
	                                        placeholder="Tonsil">
	                                </div>
	                                <div class="col-md-2">
	                                    <label for="fharing" style="color: green;">THT-Fharing</label>
	                                    <input type="text" class="form-control" id="fharing"
	                                        name="fharing"
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
	                                    <input type="text" class="form-control" id="turgor"
	                                        name="turgor"
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
	                            <span style="margin: 0 10px; white-space: nowrap;">Pemeriksaan
	                                Penunjang</span>
	                            <hr style="flex: 1; border: none; border-top: 1px solid #ccc;">
	                        </div>
	                    @endif
	                </div>
	            </div>

	            @if (Auth::user()->role == 'dokter' || Auth::user()->role == 'tindakan')
	                <div class="row mt-3">
	                    <div class="col-md-4">
	                        <div class="form-group">
	                            <label for="skrining" class="form-label">Obat</label>
	                            <button class="btn btn-primary w-100 mt-2" type="button" id="btnAddObat"
	                                data-bs-toggle="modal"
	                                data-bs-target="#editActionObatModal{{ $action->id }}">
	                                Obat
	                            </button>

	                        </div>
	                    </div>
	                    @if ($routeName !== 'action.dokter.ugd.index')
	                        <div class="col-md-4">
	                            <label for="diagnosaEditAction" style="color: rgb(19, 11, 241);">DIAGNOSA
	                                SEKUNDER</label>
	                            <select class="form-select select2"
	                                id="diagnosaEditAction{{ $action->id }}" name="diagnosa[]" multiple>
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
	                        <div class="col-md-4">
	                            <label for="poli" style="color: rgb(19, 11, 241);">DIAGNOSA PRIMER</label>
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
	                    @endif
	                    <div class="col-md-4">
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
	                    @if (Auth::user()->role != 'tindakan')
	                        <div class="col-md-4">
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
	                    @endif
	                    <div class="col-md-4">
	                        <div class="form-group">
	                            <label for="skrining" class="form-label">Riwayat Berobat</label>
	                            <button class="btn btn-success w-100 mt-2 btnCariRiwayatBerobatEdit"
	                                type="button" data-bs-toggle="modal" data-bs-target="#modalBerobatEdit"
	                                data-patient-id="{{ $action->id_patient }}">
	                                Riwayat Berobat
	                            </button>


	                        </div>
	                    </div>
	                </div>


	                {{-- <div class="col-md-6">
	                        <label for="pemeriksaan_penunjang" style="color: rgb(19, 11, 241);">Pemeriksaan
	                            Penunjang</label>
	                        <textarea class="form-control" id="pemeriksaan_penunjang" name="pemeriksaan_penunjang"
	                            placeholder="Pemeriksaan penunjang">{{ old('pemeriksaan_penunjang', $action->pemeriksaan_penunjang ?? '') }}</textarea>
	                    </div> --}}
	                <div class="row mt-3">
	                    @if (Auth::user()->role == 'dokter')
	                        <div class="col-md-6">
	                            <label for="tindakanEdit" style="color: rgb(19, 11, 241);">TINDAKAN</label>
	                            <select class="form-control" id="tindakanEdit{{ $action->id }}"
	                                name="tindakan[]">
	                                <option value="" {{ empty($action->tindakan) ? 'selected' : '' }}
	                                    disabled selected>pilih</option>
	                                @if ($action->tipe == 'poli-umum')
	                                    <option value="Diberikan Obat"
	                                        {{ old('tindakan', $action->tindakan ?? '') == 'Diberikan Obat' ? 'selected' : '' }}>
	                                        Diberikan Obat</option>
	                                    <option value="Dirujuk"
	                                        {{ old('tindakan', $action->tindakan ?? '') == 'Dirujuk' ? 'selected' : '' }}>
	                                        Dirujuk
	                                    </option>
	                                @else
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
	                                @endif
	                            </select>

	                        </div>
	                    @else
	                        @if ($routeName === 'action.dokter.ruang.tindakan.index')
	                            <div class="col-md-4">
	                                <label for="tindakanEdit"
	                                    style="color: rgb(19, 11, 241);">TINDAKAN</label>
	                                <select class="form-control" id="tindakanEdit{{ $action->id }}"
	                                    name="tindakan_ruang_tindakan[]" multiple>
	                                    <option value="Observasi Tanpa Tindakan Invasif"
	                                        {{ in_array('Observasi Tanpa Tindakan Invasif', explode(',', old('tindakan_ruang_tindakan', $action->tindakan_ruang_tindakan ?? ''))) ? 'selected' : '' }}>
	                                        Observasi Tanpa Tindakan Invasif
	                                    </option>
	                                    <option value="Observasi Dengan Tindakan Invasif"
	                                        {{ in_array('Observasi Dengan Tindakan Invasif', explode(',', old('tindakan_ruang_tindakan', $action->tindakan_ruang_tindakan ?? ''))) ? 'selected' : '' }}>
	                                        Observasi Dengan Tindakan Invasif
	                                    </option>
	                                    <option value="Tidak Ada"
	                                        {{ in_array('Tidak Ada', explode(',', old('tindakan_ruang_tindakan', $action->tindakan_ruang_tindakan ?? ''))) ? 'selected' : '' }}>
	                                        Tidak Ada
	                                    </option>
	                                    <option value="Corpus Alineum"
	                                        {{ in_array('Corpus Alineum', explode(',', old('tindakan_ruang_tindakan', $action->tindakan_ruang_tindakan ?? ''))) ? 'selected' : '' }}>
	                                        Corpus Alineum
	                                    </option>
	                                    <option value="Ekstraksi Kuku"
	                                        {{ in_array('Ekstraksi Kuku', explode(',', old('tindakan_ruang_tindakan', $action->tindakan_ruang_tindakan ?? ''))) ? 'selected' : '' }}>
	                                        Ekstraksi Kuku
	                                    </option>
	                                    <option value="Sircumsisi (Bedah Ringan)"
	                                        {{ in_array('Sircumsisi (Bedah Ringan)', explode(',', old('tindakan_ruang_tindakan', $action->tindakan_ruang_tindakan ?? ''))) ? 'selected' : '' }}>
	                                        Sircumsisi (Bedah Ringan)
	                                    </option>
	                                    <option value="Incisi Abses"
	                                        {{ in_array('Incisi Abses', explode(',', old('tindakan_ruang_tindakan', $action->tindakan_ruang_tindakan ?? ''))) ? 'selected' : '' }}>
	                                        Incisi Abses
	                                    </option>
	                                    <option value="Rawat Luka"
	                                        {{ in_array('Rawat Luka', explode(',', old('tindakan_ruang_tindakan', $action->tindakan_ruang_tindakan ?? ''))) ? 'selected' : '' }}>
	                                        Rawat Luka
	                                    </option>
	                                    <option value="Ganti Verban"
	                                        {{ in_array('Ganti Verban', explode(',', old('tindakan_ruang_tindakan', $action->tindakan_ruang_tindakan ?? ''))) ? 'selected' : '' }}>
	                                        Ganti Verban
	                                    </option>
	                                    <option value="Spooling"
	                                        {{ in_array('Spooling', explode(',', old('tindakan_ruang_tindakan', $action->tindakan_ruang_tindakan ?? ''))) ? 'selected' : '' }}>
	                                        Spooling
	                                    </option>
	                                    <option value="Toilet Telinga"
	                                        {{ in_array('Toilet Telinga', explode(',', old('tindakan_ruang_tindakan', $action->tindakan_ruang_tindakan ?? ''))) ? 'selected' : '' }}>
	                                        Toilet Telinga
	                                    </option>
	                                    <option value="Tetes Telinga"
	                                        {{ in_array('Tetes Telinga', explode(',', old('tindakan_ruang_tindakan', $action->tindakan_ruang_tindakan ?? ''))) ? 'selected' : '' }}>
	                                        Tetes Telinga
	                                    </option>
	                                    <option value="Aff Hecting"
	                                        {{ in_array('Aff Hecting', explode(',', old('tindakan_ruang_tindakan', $action->tindakan_ruang_tindakan ?? ''))) ? 'selected' : '' }}>
	                                        Aff Hecting
	                                    </option>
	                                    <option value="Hecting (Jahit Luka)"
	                                        {{ in_array('Hecting (Jahit Luka)', explode(',', old('tindakan_ruang_tindakan', $action->tindakan_ruang_tindakan ?? ''))) ? 'selected' : '' }}>
	                                        Hecting (Jahit Luka)</option>
	                                    <option value="Tampon/Off Tampon"
	                                        {{ in_array('Tampon/Off Tampon', explode(',', old('tindakan_ruang_tindakan', $action->tindakan_ruang_tindakan ?? ''))) ? 'selected' : '' }}>
	                                        Tampon/Off Tampon</option>

	                                </select>
	                            </div>
	                        @else
	                            <div class="col-md-6">
	                                <label for="tindakanEdit"
	                                    style="color: rgb(19, 11, 241);">TINDAKAN</label>
	                                <select class="form-control" id="tindakanEdit{{ $action->id }}"
	                                    name="tindakan[]" multiple>
	                                    <option value="Observasi Tanpa Tindakan Invasif"
	                                        {{ in_array('Observasi Tanpa Tindakan Invasif', explode(',', old('tindakan', $action->tindakan ?? ''))) ? 'selected' : '' }}>
	                                        Observasi Tanpa Tindakan Invasif
	                                    </option>
	                                    <option value="Observasi Dengan Tindakan Invasif"
	                                        {{ in_array('Observasi Dengan Tindakan Invasif', explode(',', old('tindakan', $action->tindakan ?? ''))) ? 'selected' : '' }}>
	                                        Observasi Dengan Tindakan Invasif
	                                    </option>
	                                    <option value="Tidak Ada"
	                                        {{ in_array('Tidak Ada', explode(',', old('tindakan', $action->tindakan ?? ''))) ? 'selected' : '' }}>
	                                        Tidak Ada
	                                    </option>
	                                    <option value="Corpus Alineum"
	                                        {{ in_array('Corpus Alineum', explode(',', old('tindakan', $action->tindakan ?? ''))) ? 'selected' : '' }}>
	                                        Corpus Alineum
	                                    </option>
	                                    <option value="Ekstraksi Kuku"
	                                        {{ in_array('Ekstraksi Kuku', explode(',', old('tindakan', $action->tindakan ?? ''))) ? 'selected' : '' }}>
	                                        Ekstraksi Kuku
	                                    </option>
	                                    <option value="Sircumsisi (Bedah Ringan)"
	                                        {{ in_array('Sircumsisi (Bedah Ringan)', explode(',', old('tindakan', $action->tindakan ?? ''))) ? 'selected' : '' }}>
	                                        Sircumsisi (Bedah Ringan)
	                                    </option>
	                                    <option value="Incisi Abses"
	                                        {{ in_array('Incisi Abses', explode(',', old('tindakan', $action->tindakan ?? ''))) ? 'selected' : '' }}>
	                                        Incisi Abses
	                                    </option>
	                                    <option value="Rawat Luka"
	                                        {{ in_array('Rawat Luka', explode(',', old('tindakan', $action->tindakan ?? ''))) ? 'selected' : '' }}>
	                                        Rawat Luka
	                                    </option>
	                                    <option value="Ganti Verban"
	                                        {{ in_array('Ganti Verban', explode(',', old('tindakan', $action->tindakan ?? ''))) ? 'selected' : '' }}>
	                                        Ganti Verban
	                                    </option>
	                                    <option value="Spooling"
	                                        {{ in_array('Spooling', explode(',', old('tindakan', $action->tindakan ?? ''))) ? 'selected' : '' }}>
	                                        Spooling
	                                    </option>
	                                    <option value="Toilet Telinga"
	                                        {{ in_array('Toilet Telinga', explode(',', old('tindakan', $action->tindakan ?? ''))) ? 'selected' : '' }}>
	                                        Toilet Telinga
	                                    </option>
	                                    <option value="Tetes Telinga"
	                                        {{ in_array('Tetes Telinga', explode(',', old('tindakan', $action->tindakan ?? ''))) ? 'selected' : '' }}>
	                                        Tetes Telinga
	                                    </option>
	                                    <option value="Aff Hecting"
	                                        {{ in_array('Aff Hecting', explode(',', old('tindakan', $action->tindakan ?? ''))) ? 'selected' : '' }}>
	                                        Aff Hecting
	                                    </option>
	                                    <option value="Hecting (Jahit Luka)"
	                                        {{ in_array('Hecting (Jahit Luka)', explode(',', old('tindakan', $action->tindakan ?? ''))) ? 'selected' : '' }}>
	                                        Hecting (Jahit Luka)</option>
	                                    <option value="Tampon/Off Tampon"
	                                        {{ in_array('Tampon/Off Tampon', explode(',', old('tindakan', $action->tindakan ?? ''))) ? 'selected' : '' }}>
	                                        Tampon/Off Tampon</option>

	                                </select>
	                            </div>
	                        @endif
	                    @endif
	                </div>
	            @endif


	            <div class="row mt-3">
	                @if (Auth::user()->role != 'admin-kajian-awal')
	                    <div class="col-md-6">
	                        <label for="rujuk_rs" style="color: rgb(19, 11, 241);">RUJUK RS</label>
	                        <select class="form-control" id="rujuk_rs{{ $action->id }}" name="rujuk_rs">
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

	                @if ($routeName === 'action.dokter.index')
	                    <div class="col-md-4">
	                        <label for="beri_tindakan" style="color: rgb(19, 11, 241);">Dirujuk Ke Ruang
	                            Tindakan</label>
	                        <select class="form-control" id="beri_tindakan" name="beri_tindakan">
	                            <option value="" disabled selected>pilih</option>
	                            <option value="1"
	                                {{ old('beri_tindakan', $action->beri_tindakan ?? '') == 1 ? 'selected' : '' }}>
	                                Iya</option>
	                            <option value="0"
	                                {{ old('beri_tindakan', $action->beri_tindakan ?? '') == 0 ? 'selected' : '' }}>
	                                Tidak</option>
	                        </select>
	                    </div>
	                @endif
	                <div class="col-md-6">
	                    <label for="keterangan" style="color: rgb(19, 11, 241);">KETERANGAN</label>
	                    <input type="text" class="form-control" id="keterangan" name="keterangan"
	                        value="{{ old('keterangan', $action->keterangan ?? '') }}"
	                        placeholder="Keterangan">
	                </div>
	            </div>
	        </div>

	        @if (Auth::user()->role == 'dokter' || $routeName === 'action.dokter.ugd.index')
	            <div id="formSection2{{ $action->id }}" class="form-section d-none">
	                <h6>Jenis Pemeriksaan Darah</h6>
	                @php

	                    $jenis_pemeriksaan =
	                        json_decode($action->hasilLab?->jenis_pemeriksaan ?? '[]', true) ?? [];

	                @endphp
	                <div class="row">

	                    <div class="col-md-6">
	                        <div class="form-check">
	                            <input class="form-check-input-edit" type="checkbox" id="gds"
	                                name="jenis_pemeriksaan[]" value="GDS"
	                                {{ in_array('GDS', $jenis_pemeriksaan ?? []) ? 'checked' : '' }}>
	                            <label class="form-check-label" for="gds">GDS
	                            </label>
	                        </div>
	                        <div class="form-check">
	                            <input class="form-check-input-edit" type="checkbox" id="gdp"
	                                name="jenis_pemeriksaan[]" value="GDP"
	                                {{ in_array('GDP', $jenis_pemeriksaan ?? []) ? 'checked' : '' }}>
	                            <label class="form-check-label" for="gdp">GDP</label>
	                        </div>
	                        <div class="form-check">
	                            <input class="form-check-input-edit" type="checkbox" id="gdp_2_jam_pp"
	                                name="jenis_pemeriksaan[]" value="GDP 2 Jam pp"
	                                {{ in_array('GDP 2 Jam pp', $jenis_pemeriksaan ?? []) ? 'checked' : '' }}>
	                            <label class="form-check-label" for="gdp_2_jam_pp">GDP 2 Jam pp</label>
	                        </div>
	                        <div class="form-check">
	                            <input class="form-check-input-edit" type="checkbox" id="cholesterol"
	                                name="jenis_pemeriksaan[]" value="Cholesterol"
	                                {{ in_array('Cholesterol', $jenis_pemeriksaan ?? []) ? 'checked' : '' }}>
	                            <label class="form-check-label" for="cholesterol">Cholesterol</label>
	                        </div>
	                        <div class="form-check">
	                            <input class="form-check-input-edit" type="checkbox" id="asam_urat"
	                                name="jenis_pemeriksaan[]" value="Asam Urat"
	                                {{ in_array('Asam Urat', $jenis_pemeriksaan ?? []) ? 'checked' : '' }}>
	                            <label class="form-check-label" for="asam_urat">Asam Urat</label>
	                        </div>
	                        <div class="form-check">
	                            <input class="form-check-input-edit" type="checkbox" id="leukosit"
	                                name="jenis_pemeriksaan[]" value="Leukosit"
	                                {{ in_array('Leukosit', $jenis_pemeriksaan ?? []) ? 'checked' : '' }}>
	                            <label class="form-check-label" for="leukosit">Leukosit</label>
	                        </div>
	                        <div class="form-check">
	                            <input class="form-check-input-edit" type="checkbox" id="eritrosit"
	                                name="jenis_pemeriksaan[]" value="Eritrosit"
	                                {{ in_array('Eritrosit', $jenis_pemeriksaan ?? []) ? 'checked' : '' }}>
	                            <label class="form-check-label" for="eritrosit">Eritrosit</label>
	                        </div>
	                    </div>

	                    <div class="col-md-6">
	                        <div class="form-check">
	                            <input class="form-check-input-edit" type="checkbox" id="trombosit"
	                                name="jenis_pemeriksaan[]" value="Trombosit"
	                                {{ in_array('Trombosit', $jenis_pemeriksaan ?? []) ? 'checked' : '' }}>
	                            <label class="form-check-label" for="trombosit">Trombosit</label>
	                        </div>
	                        <div class="form-check">
	                            <input class="form-check-input-edit" type="checkbox" id="hemoglobin"
	                                name="jenis_pemeriksaan[]" value="Hemoglobin"
	                                {{ in_array('Hemoglobin', $jenis_pemeriksaan ?? []) ? 'checked' : '' }}>
	                            <label class="form-check-label" for="hemoglobin">Hemoglobin</label>
	                        </div>
	                        <div class="form-check">
	                            <input class="form-check-input-edit" type="checkbox" id="sifilis"
	                                name="jenis_pemeriksaan[]" value="Sifilis"
	                                {{ in_array('Sifilis', $jenis_pemeriksaan ?? []) ? 'checked' : '' }}>
	                            <label class="form-check-label" for="sifilis">Sifilis</label>
	                        </div>
	                        <div class="form-check">
	                            <input class="form-check-input-edit" type="checkbox" id="hiv"
	                                name="jenis_pemeriksaan[]" value="HIV"
	                                {{ in_array('HIV', $jenis_pemeriksaan ?? []) ? 'checked' : '' }}>
	                            <label class="form-check-label" for="hiv">HIV</label>
	                        </div>
	                        <div class="form-check">
	                            <input class="form-check-input-edit" type="checkbox" id="golongan_darah"
	                                name="jenis_pemeriksaan[]" value="Golongan Darah"
	                                {{ in_array('Golongan Darah', $jenis_pemeriksaan ?? []) ? 'checked' : '' }}>
	                            <label class="form-check-label" for="golongan_darah">Golongan Darah</label>
	                        </div>
	                        <div class="form-check">
	                            <input class="form-check-input-edit" type="checkbox" id="widal"
	                                name="jenis_pemeriksaan[]" value="Widal"
	                                {{ in_array('Widal', $jenis_pemeriksaan ?? []) ? 'checked' : '' }}>
	                            <label class="form-check-label" for="widal">Widal</label>
	                        </div>
	                        <div class="form-check">
	                            <input class="form-check-input-edit" type="checkbox" id="malaria"
	                                name="jenis_pemeriksaan[]" value="Malaria"
	                                {{ in_array('Malaria', $jenis_pemeriksaan ?? []) ? 'checked' : '' }}>
	                            <label class="form-check-label" for="malaria">Malaria</label>
	                        </div>
	                    </div>
	                </div>

	                <!-- Tambahan Pemeriksaan URINE -->
	                <h6>Jenis Pemeriksaan URINE</h6>
	                <div class="form-check">
	                    <input class="form-check-input-edit" type="checkbox" id="albumin"
	                        name="jenis_pemeriksaan[]" value="Albumin"
	                        {{ in_array('Albumin', $jenis_pemeriksaan ?? []) ? 'checked' : '' }}>
	                    <label class="form-check-label" for="albumin">Albumin</label>
	                </div>
	                <div class="form-check">
	                    <input class="form-check-input-edit" type="checkbox" id="reduksi"
	                        name="jenis_pemeriksaan[]" value="Reduksi"
	                        {{ in_array('Reduksi', $jenis_pemeriksaan ?? []) ? 'checked' : '' }}>
	                    <label class="form-check-label" for="reduksi">Reduksi</label>
	                </div>
	                <div class="form-check">
	                    <input class="form-check-input-edit" type="checkbox" id="urinalisa"
	                        name="jenis_pemeriksaan[]" value="Urinalisa"
	                        {{ in_array('Urinalisa', $jenis_pemeriksaan ?? []) ? 'checked' : '' }}>
	                    <label class="form-check-label" for="urinalisa">Urinalisa</label>
	                </div>
	                <div class="form-check">
	                    <input class="form-check-input-edit" type="checkbox" id="tes_kehamilan"
	                        name="jenis_pemeriksaan[]" value="Tes Kehamilan"
	                        {{ in_array('Tes Kehamilan', $jenis_pemeriksaan ?? []) ? 'checked' : '' }}>
	                    <label class="form-check-label" for="tes_kehamilan">Tes Kehamilan</label>
	                </div>

	                <!-- Tambahan Pemeriksaan FESES -->
	                <h6>Jenis Pemeriksaan FESES</h6>
	                <div class="form-check">
	                    <input class="form-check-input-edit" type="checkbox" id="telur_cacing"
	                        name="jenis_pemeriksaan[]" value="Telur Cacing"
	                        {{ in_array('Telur Cacing', $jenis_pemeriksaan ?? []) ? 'checked' : '' }}>
	                    <label class="form-check-label" for="telur_cacing">Telur Cacing</label>
	                </div>


	                <!-- Tambahan Pemeriksaan IgM -->
	                <h6>Pemeriksaan IgM</h6>
	                <div class="form-check">
	                    <input class="form-check-input-edit" type="checkbox" id="igm_dbd"
	                        name="jenis_pemeriksaan[]" value="IgM DBD"
	                        {{ in_array('IgM DBD', $jenis_pemeriksaan ?? []) ? 'checked' : '' }}>
	                    <label class="form-check-label" for="igm_dbd">IgM DBD</label>
	                </div>
	                <div class="form-check">
	                    <input class="form-check-input-edit" type="checkbox" id="igm_typhoid"
	                        name="jenis_pemeriksaan[]" value="IgM Typhoid"
	                        {{ in_array('IgM Typhoid', $jenis_pemeriksaan ?? []) ? 'checked' : '' }}>
	                    <label class="form-check-label" for="igm_typhoid">IgM Typhoid</label>
	                </div>
	                <h6>Jenis Pemeriksaan Dahak</h6>
	                <div class="form-check">
	                    <input class="form-check-input-edit" type="checkbox" id="bta"
	                        name="jenis_pemeriksaan[]" value="BTA"
	                        {{ in_array('BTA', $jenis_pemeriksaan ?? []) ? 'checked' : '' }}>
	                    <label class="form-check-label" for="bta">BTA</label>
	                </div>
	                <div class="form-check">
	                    <input class="form-check-input-edit" type="checkbox" id="tcm"
	                        name="jenis_pemeriksaan[]" value="TCM"
	                        {{ in_array('TCM', $jenis_pemeriksaan ?? []) ? 'checked' : '' }}>
	                    <label class="form-check-label" for="tcm">TCM</label>
	                </div>
	            </div>
	        @endif

	        <div class="modal-footer">
	            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
	            @if (Auth::user()->role == 'dokter' || $routeName === 'action.dokter.ugd.index')
	                <button type="button" class="btn btn-success"
	                    id="nextSectionButton{{ $action->id }}">Lanjut
	                    Pemeriksaan</button>
	            @endif
	            <button type="submit" class="btn btn-primary">Simpan Data</button>
	        </div>

	    </form>
	</div>


@include('component.modal-table-edit-pasien')
@include('component.modal-skrining-edit')
@include('component.modal-berobat-edit')
@include('component.modal-edit-action-obat')

<!-- jQuery harus PERTAMA -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.full.min.js"></script>
<script>
    var nikValue = "{{ $action->patient->nik ?? '' }}";
    document.getElementById('nikEdit{{ $action->id }}').value = nikValue;
</script>
<script>
    $(document).ready(function() {
        // Array of element IDs
        const elementIds = [
            '#diagnosaEditAction{{ $action->id }}',
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
<script>
    @if (Auth::user()->role == 'dokter' || $routeName === 'action.dokter.ugd.index')
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
            console.log(section2);
        });
    @endif
</script>

<style>
    .select2-dropdown {
        z-index: 9999 !important;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Attach event listeners dynamically for all modal edit elements
        const allModals = document.querySelectorAll('.modal');
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
