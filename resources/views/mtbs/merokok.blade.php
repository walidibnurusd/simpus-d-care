@extends('layouts.skrining.master')
@section('title', 'Skrining Perilaku Merokok Bagi Anak Usia Sekolah')
@section('content')
    <!-- Success Alert -->
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show d-flex align-items-center" role="alert">
            <i class="mr-2 text-success"></i>
            <strong>Success:</strong> {{ session('success') }}
            <button type="button" class="close ml-auto" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <style>
        .select2-container--default .select2-selection--single {
            height: calc(1.5em + .75rem + 2px);
            border: 1px solid #ced4da;
            border-radius: .25rem;
            padding: .375rem .75rem;
        }
        
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: calc(1.5em + .75rem);
        }
        
        .select2-container .select2-selection--single {
            display: flex;
            align-items: center;
        }
    </style>
    <!-- Validation Errors Alert -->
    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Warning:</strong> Please check the form for errors.
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <form action="{{ isset($merokok) ? route('merokok.mtbs.update', $merokok->id) : route('merokok.mtbs.store') }}"
        method="POST">
        @csrf
        @if (isset($merokok))
            @method('PUT')
        @endif
        <div class="form-section">
            <h3>A. Keterangan Tempat</h3>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>No Kuesioner</label>
                        <input type="text" class="form-control" name="no_kuesioner"
                            value="{{ isset($merokok) ? $merokok->no_kuesioner : '' }}"
                            placeholder="Masukkan nomor kuesioner">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Nama Sekolah</label>
                        <input type="text" class="form-control" name="sekolah"
                            value="{{ isset($merokok) ? $merokok->sekolah : '' }}" placeholder="Masukkan nama sekolah">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Provinsi</label>
                        <input type="text" class="form-control" name="provinsi"
                            value="{{ isset($merokok) ? $merokok->provinsi : '' }}" placeholder="Masukkan nama provinsi">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Puskesmas</label>
                        <input type="text" class="form-control" name="puskesmas"
                            value="{{ isset($merokok) ? $merokok->puskesmas : '' }}" placeholder="Masukkan nama puskesmas">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Nama Petugas</label>
                        <input type="text" class="form-control" name="petugas"
                            value="{{ isset($merokok) ? $merokok->petugas : '' }}" placeholder="Masukkan nama petugas">
                    </div>
                </div>
            </div>




        </div>
        <div class="form-section">
            <h3>B. Karakteristik Responden (Siswa Kelas 4 s/d 12)</h3>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>1. Pasien</label>
                        <select class="form-control form-select select2" id="pasien" name="pasien">
                            <option value="" disabled {{ old('pasien') == '' ? 'selected' : '' }}>Pilih</option>
                            @foreach ($pasien as $item)
                                <option 
                                    value="{{ $item->id }}" 
                                    data-no_hp="{{ $item->phone }}" 
                                    data-nik="{{ $item->nik }}" 
                                    data-dob="{{ $item->dob }}"
                                    data-jenis_kelamin="{{ $item->genderName->name }}"
                                    data-alamat="{{ $item->address }}"
                                    {{ old('pasien', $merokok->pasien ?? '') == $item->id ? 'selected' : '' }}>
                                    {{ $item->name }} - {{ $item->nik }}
                                </option>   
                            @endforeach
                        </select>
                        @error('pasien') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>NIK</label>
                        <input type="number" readonly class="form-control" name="nik" id="nik"
                            value="{{ isset($merokok) ? $merokok->nik : '' }}" placeholder="Masukkan NIK">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Tanggal Lahir</label>
                        <input type="date" readonly class="form-control" name="tanggal_lahir" id="tanggal_lahir"
                            value="{{ isset($merokok) ? $merokok->tanggal_lahir : '' }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Umur</label>
                        <input type="number" class="form-control" name="umur"
                            value="{{ isset($merokok) ? $merokok->umur : '' }}" placeholder="Masukkan umur">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Jenis Kelamin</label>
                        <div class="d-flex">
                            <div class="form-check mr-3">
                                <input type="radio" class="form-check-input" name="jenis_kelamin" value="laki-laki" id="jk_laki"
                                    id="laki-laki"
                                    {{ isset($merokok) && $merokok->jenis_kelamin == 'laki-laki' ? 'checked' : '' }}>
                                <label class="form-check-label" for="laki-laki">Laki-laki</label>
                            </div>
                            <div class="form-check">
                                <input type="radio" class="form-check-input" name="jenis_kelamin" value="perempuan" id="jk_perempuan"
                                    id="perempuan"
                                    {{ isset($merokok) && $merokok->jenis_kelamin == 'perempuan' ? 'checked' : '' }}>
                                <label class="form-check-label" for="perempuan">Perempuan</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-section mt-4">
            <h3>C. Perilaku Merokok</h3>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label>1. Apakah kamu merokok?</label>

                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="merokok" value="1"
                                {{ isset($merokok) && $merokok->merokok == '1' ? 'checked' : '' }}>
                            <label class="form-check-label">Ya, setiap hari</label>
                        </div>

                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="merokok" value="2"
                                {{ isset($merokok) && $merokok->merokok == '2' ? 'checked' : '' }}>
                            <label class="form-check-label">Ya, kadang-kadang</label>
                        </div>

                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="merokok" value="3"
                                {{ isset($merokok) && $merokok->merokok == '3' ? 'checked' : '' }}>
                            <label class="form-check-label">Pernah mencoba walau hanya 1 hisapan</label>
                        </div>

                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="merokok" value="4"
                                {{ isset($merokok) && $merokok->merokok == '4' ? 'checked' : '' }}>
                            <label class="form-check-label">Tidak merokok / tidak pernah mencoba</label>
                        </div>
                    </div>

                    <h5>
                        <strong>Bila jawaban
                            <span style="color: red;">Pernah mencoba walau hanya 1 hisapan dan Tidak merokok / tidak pernah
                                mencoba</span>, langsung
                            ke bagian Bagian D</strong>
                    </h5>
                </div>


                <!-- Pertanyaan tentang jenis rokok -->
                <div style="margin-top:10px">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>2. Jenis rokok apa yang digunakan?</label>

                            <!-- Rokok Konvensional -->
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="jenis_rokok[]"
                                    value="konvensional"
                                    {{ isset($merokok) && in_array('konvensional', $merokok->jenis_rokok ?? []) ? 'checked' : '' }}>
                                <label class="form-check-label">Rokok konvensional (rokok putih, kretek, tingwe,
                                    dll)</label>
                            </div>

                            <!-- Rokok Elektronik -->
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="jenis_rokok[]" value="elektronik"
                                    {{ isset($merokok) && in_array('elektronik', $merokok->jenis_rokok ?? []) ? 'checked' : '' }}>
                                <label class="form-check-label">Rokok elektronik (vape, IQOS, dll)</label>
                            </div>

                            <!-- Keduanya -->
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="jenis_rokok[]" value="keduanya"
                                    {{ isset($merokok) && in_array('keduanya', $merokok->jenis_rokok ?? []) ? 'checked' : '' }}>
                                <label class="form-check-label">Keduanya</label>
                            </div>

                            <!-- Lainnya -->
                            <div class="form-check d-flex align-items-center">
                                <input type="checkbox" class="form-check-input" id="jenis-rokok-lainnya-checkbox"
                                    value="lainnya" onclick="toggleOtherRokokInput()"
                                    {{ isset($merokok) && !empty($merokok->jenis_rokok_lainnya) ? 'checked' : '' }}>
                                <label class="form-check-label mr-2">Lainnya</label>
                                <input type="text" class="form-control w-50" id="jenis-rokok-lainnya-input"
                                    name="jenis_rokok_lainnya" placeholder="Sebutkan jenis rokok lainnya"
                                    value="{{ isset($merokok) ? $merokok->jenis_rokok_lainnya : '' }}"
                                    style="{{ isset($merokok) && !empty($merokok->jenis_rokok_lainnya) ? '' : 'display: none;' }}">
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label>3. Berapa usia kamu mulai merokok?</label>
                            <div class="row align-items-center">
                                <div class="col-auto">
                                    <input type="text" class="form-control" name="usia_merokok"
                                        placeholder="Usia mulai merokok"
                                        value="{{ isset($merokok) ? $merokok->usia_merokok : '' }}">
                                </div>
                                <div class="col-auto">
                                    <p class="mb-0">Tahun</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label>4. Apa alasan kamu mulai merokok? <small>(Bisa pilih lebih dari 1)</small></label>
                            <div class="row">
                                <!-- Ikut-ikutan Teman -->
                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" name="alasan_merokok[]"
                                            value="ikut_teman"
                                            {{ isset($merokok) && in_array('ikut_teman', $merokok->alasan_merokok ?? []) ? 'checked' : '' }}>
                                        <label class="form-check-label">Ikut-ikutan teman</label>
                                    </div>
                                </div>

                                <!-- Pengaruh Keluarga -->
                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" name="alasan_merokok[]"
                                            value="pengaruh_keluarga"
                                            {{ isset($merokok) && in_array('pengaruh_keluarga', $merokok->alasan_merokok ?? []) ? 'checked' : '' }}>
                                        <label class="form-check-label">Pengaruh keluarga</label>
                                    </div>
                                </div>

                                <!-- Rasa Ingin Tahu -->
                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" name="alasan_merokok[]"
                                            value="rasa_ingin_tahu"
                                            {{ isset($merokok) && in_array('rasa_ingin_tahu', $merokok->alasan_merokok ?? []) ? 'checked' : '' }}>
                                        <label class="form-check-label">Rasa ingin tahu</label>
                                    </div>
                                </div>

                                <!-- Terpaksa oleh Teman -->
                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" name="alasan_merokok[]"
                                            value="terpaksa_teman"
                                            {{ isset($merokok) && in_array('terpaksa_teman', $merokok->alasan_merokok ?? []) ? 'checked' : '' }}>
                                        <label class="form-check-label">Terpaksa oleh teman/lingkungan</label>
                                    </div>
                                </div>

                                <!-- Mengisi Waktu Luang -->
                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" name="alasan_merokok[]"
                                            value="mengisi_waktu"
                                            {{ isset($merokok) && in_array('mengisi_waktu', $merokok->alasan_merokok ?? []) ? 'checked' : '' }}>
                                        <label class="form-check-label">Mengisi waktu luang</label>
                                    </div>
                                </div>

                                <!-- Menghilangkan Stres -->
                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" name="alasan_merokok[]"
                                            value="menghilangkan_stres"
                                            {{ isset($merokok) && in_array('menghilangkan_stres', $merokok->alasan_merokok ?? []) ? 'checked' : '' }}>
                                        <label class="form-check-label">Menghilangkan stres</label>
                                    </div>
                                </div>

                                <!-- Lainnya -->
                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" name="alasan_merokok[]"
                                            value="lainnya" onclick="toggleOtherReasonInput(this.checked)"
                                            {{ isset($merokok) && !empty($merokok->alasan_merokok_lainnya) ? 'checked' : '' }}>
                                        <label class="form-check-label">Lainnya</label>
                                    </div>
                                    <div id="other-reason-input"
                                        style="margin-top: 10px; {{ isset($merokok) && !empty($merokok->alasan_merokok_lainnya) ? '' : 'display: none;' }}">
                                        <input type="text" class="form-control" name="alasan_merokok_lainnya"
                                            placeholder="Sebutkan alasan lainnya"
                                            value="{{ isset($merokok) ? $merokok->alasan_merokok_lainnya : '' }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label>5. Berapa jumlah batang rokok yang kamu hisap setiap hari atau minggu?</label>
                            <div class="row align-items-center">
                                <div class="col-md-6 d-flex">
                                    <input type="number" class="form-control mr-2" name="batang_per_hari"
                                        placeholder="Masukkan jumlah"
                                        value="{{ isset($merokok) ? $merokok->batang_per_hari : '' }}">
                                    <label class="form-check-label">batang/hari</label>
                                </div>
                                <div class="col-md-6 d-flex">
                                    <input type="number" class="form-control mr-2" name="batang_per_minggu"
                                        placeholder="Masukkan jumlah"
                                        value="{{ isset($merokok) ? $merokok->batang_per_minggu : '' }}">
                                    <label class="form-check-label">batang/minggu</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label>6. Sudah berapa lama kamu merokok?</label>
                            <div class="row align-items-center">
                                <div class="col-md-4 d-flex">
                                    <input type="number" class="form-control mr-2" name="lama_merokok_minggu"
                                        placeholder="Masukkan jumlah"
                                        value="{{ isset($merokok) ? $merokok->lama_merokok_minggu : '' }}">
                                    <label class="form-check-label">minggu</label>
                                </div>
                                <div class="col-md-4 d-flex">
                                    <input type="number" class="form-control mr-2" name="lama_merokok_bulan"
                                        placeholder="Masukkan jumlah"
                                        value="{{ isset($merokok) ? $merokok->lama_merokok_bulan : '' }}">
                                    <label class="form-check-label">bulan</label>
                                </div>
                                <div class="col-md-4 d-flex">
                                    <input type="number" class="form-control mr-2" name="lama_merokok_tahun"
                                        placeholder="Masukkan jumlah"
                                        value="{{ isset($merokok) ? $merokok->lama_merokok_tahun : '' }}">
                                    <label class="form-check-label">tahun</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label>7. Bagaimana biasanya (paling sering) kamu mendapatkan rokok?</label>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="dapat_rokok[]"
                                    value="beli_batangan"
                                    {{ isset($merokok) && in_array('beli_batangan', $merokok->dapat_rokok ?? []) ? 'checked' : '' }}>
                                <label class="form-check-label">Beli batangan</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="dapat_rokok[]"
                                    value="beli_bungkusan"
                                    {{ isset($merokok) && in_array('beli_bungkusan', $merokok->dapat_rokok ?? []) ? 'checked' : '' }}>
                                <label class="form-check-label">Beli bungkusan</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="dapat_rokok[]"
                                    value="motivasi_diri_sendiri"
                                    {{ isset($merokok) && in_array('motivasi_diri_sendiri', $merokok->dapat_rokok ?? []) ? 'checked' : '' }}>
                                <label class="form-check-label">Dapat dari teman</label>
                            </div>
                            <div class="form-check d-flex align-items-center">
                                <input type="checkbox" class="form-check-input" id="dapat-rokok-lainnya-checkbox"
                                    value="lainnya" onclick="toggleGetRokokInput()"
                                    {{ isset($merokok) && !empty($merokok->dapat_rokok_lainnya) ? 'checked' : '' }}>
                                <label class="form-check-label mr-2">Lainnya</label>
                                <input type="text" class="form-control w-50" id="dapat-rokok-lainnya-input"
                                    name="dapat_rokok_lainnya" placeholder="Sebutkan cara dapat rokok lainnya"
                                    value="{{ isset($merokok) ? $merokok->dapat_rokok_lainnya : '' }}"
                                    style="{{ isset($merokok) && !empty($merokok->dapat_rokok_lainnya) ? '' : 'display: none;' }}">
                            </div>
                        </div>
                    </div>

                    html
                    Copy code
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>8. Apakah ada keinginan kamu untuk berhenti merokok?</label>
                            <div class="d-flex">
                                <div class="form-check mr-3">
                                    <input type="radio" class="form-check-input" name="berhenti_merokok"
                                        value="1"
                                        {{ isset($merokok) && $merokok->berhenti_merokok == 1 ? 'checked' : '' }}
                                        onclick="toggleSmokingQuestions(true)">
                                    <label class="form-check-label">Ya</label>
                                </div>
                                <div class="form-check">
                                    <input type="radio" class="form-check-input" name="berhenti_merokok"
                                        value="0"
                                        {{ isset($merokok) && $merokok->berhenti_merokok == 0 ? 'checked' : '' }}
                                        onclick="toggleSmokingQuestions(false)">
                                    <label class="form-check-label">Tidak</label>
                                </div>
                            </div>
                        </div>
                        <h5><strong>Bila jawaban <span style="color: red;">Tidak</span>, langsung
                                ke bagian Bagian D dan bila <span style="color: red;">Ya </span>ke pertanyaan 9</strong>
                        </h5>
                    </div>

                    <div class="col-md-12" id="alasan-merokok-section"
                        style="{{ isset($merokok) && $merokok->berhenti_merokok == 0 ? 'display:none;' : '' }}">
                        <div class="form-group">
                            <label>9. Apa alasan utama kamu mau berhenti merokok?</label>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="alasan_berhenti_merokok[]"
                                    value="kondisi_kesehatan"
                                    {{ isset($merokok) && in_array('kondisi_kesehatan', $merokok->alasan_berhenti_merokok ?? []) ? 'checked' : '' }}>
                                <label class="form-check-label">Kondisi kesehatan</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="alasan_berhenti_merokok[]"
                                    value="tidak_mampu_beli"
                                    {{ isset($merokok) && in_array('tidak_mampu_beli', $merokok->alasan_berhenti_merokok ?? []) ? 'checked' : '' }}>
                                <label class="form-check-label">Tidak mampu beli/mahal</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="alasan_berhenti_merokok[]"
                                    value="motivasi_diri_sendiri"
                                    {{ isset($merokok) && in_array('motivasi_diri_sendiri', $merokok->alasan_berhenti_merokok ?? []) ? 'checked' : '' }}>
                                <label class="form-check-label">Motivasi diri sendiri</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="alasan_berhenti_merokok[]"
                                    value="motivasi_orang_lain"
                                    {{ isset($merokok) && in_array('motivasi_orang_lain', $merokok->alasan_berhenti_merokok ?? []) ? 'checked' : '' }}>
                                <label class="form-check-label">Motivasi orang tua/guru/teman</label>
                            </div>
                            <div class="form-check d-flex align-items-center">
                                <input type="checkbox" class="form-check-input" id="alasan-rokok-lainnya-checkbox"
                                    value="lainnya"
                                    {{ isset($merokok) && !empty($merokok->alasan_berhenti_merokok_lainnya) ? 'checked' : '' }}
                                    onclick="toggleReasonStopRokokInput()">
                                <label class="form-check-label mr-2">Lainnya</label>
                                <input type="text" class="form-control w-50" id="alasan-rokok-lainnya-input"
                                    name="alasan_berhenti_merokok_lainnya" placeholder="Sebutkan alasan lainnya"
                                    value="{{ isset($merokok) ? $merokok->alasan_berhenti_merokok_lainnya : '' }}"
                                    style="{{ isset($merokok) && !empty($merokok->alasan_berhenti_merokok_lainnya) ? '' : 'display: none;' }}">
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Bagian D -->
            <div id="section-d" style="margin-top: 10px">
                <h3>D. Pengetahuan tentang Rokok dan Dampak Konsumsinya</h3>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>1. Apakah kamu tahu dampak buruk dari merokok?</label>
                            <div class="d-flex">
                                <div class="form-check mr-3">
                                    <input type="radio" class="form-check-input" name="tau_bahaya_rokok" value="1"
                                        {{ isset($merokok) && $merokok->tau_bahaya_rokok == 1 ? 'checked' : '' }}>
                                    <label class="form-check-label">Ya</label>
                                </div>
                                <div class="form-check">
                                    <input type="radio" class="form-check-input" name="tau_bahaya_rokok" value="0"
                                        {{ isset($merokok) && $merokok->tau_bahaya_rokok == 0 ? 'checked' : '' }}>
                                    <label class="form-check-label">Tidak</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>2. Apakah kamu pernah melihat orang yang merokok di sekolah?</label>
                            <div class="d-flex">
                                <div class="form-check mr-3">
                                    <input type="radio" class="form-check-input" name="melihat_orang_merokok" value="1" 
                                        {{ isset($merokok) && $merokok->melihat_orang_merokok == 1 ? 'checked' : '' }}
                                        onclick="toggleAdditionalQuestion(true)">
                                    <label class="form-check-label">Ya</label>
                                </div>
                                <div class="form-check">
                                    <input type="radio" class="form-check-input" name="melihat_orang_merokok" value="0"
                                        {{ isset($merokok) && $merokok->melihat_orang_merokok == 0 ? 'checked' : '' }}
                                        onclick="toggleAdditionalQuestion(false)">
                                    <label class="form-check-label">Tidak</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-12" id="additional-question" style="display: {{ isset($merokok) &&  $merokok->melihat_orang_merokok ==1 ? 'block' : 'none' }}">
                        <div class="form-group">
                            <label>Jika "Ya", sebutkan:</label>
                            <div class="d-flex flex-wrap">
                                <div class="form-check mr-3">
                                    <input type="checkbox" class="form-check-input" name="orang_merokok[]"
                                        value="teman" {{ isset($merokok) && is_array($merokok->orang_merokok) && in_array('teman', $merokok->orang_merokok) ? 'checked' : '' }}>
                                    <label class="form-check-label">Teman</label>
                                </div>
                                <div class="form-check mr-3">
                                    <input type="checkbox" class="form-check-input" name="orang_merokok[]"
                                        value="guru" {{ isset($merokok) && is_array($merokok->orang_merokok) && in_array('guru', $merokok->orang_merokok) ? 'checked' : '' }}>
                                    <label class="form-check-label">Guru</label>
                                </div>
                                <div class="form-check mr-3">
                                    <input type="checkbox" class="form-check-input" name="orang_merokok[]"
                                        value="satpam" {{ isset($merokok) && is_array($merokok->orang_merokok) && in_array('satpam', $merokok->orang_merokok) ? 'checked' : '' }}>
                                    <label class="form-check-label">Satpam</label>
                                </div>
                                <div class="form-check mr-3">
                                    <input type="checkbox" class="form-check-input" name="orang_merokok[]"
                                        value="warga_sekolah" {{ isset($merokok) && is_array($merokok->orang_merokok) && in_array('warga_sekolah', $merokok->orang_merokok) ? 'checked' : '' }}>
                                    <label class="form-check-label">Warga sekolah</label>
                                </div>
                                <div class="form-check mr-3 d-flex align-items-center">
                                    <input type="checkbox" class="form-check-input" id="lainnyaCheckbox" 
                                        {{ isset($merokok) && is_array($merokok->orang_merokok) && in_array('lainnya', $merokok->orang_merokok) ? 'checked' : '' }}
                                        onclick="toggleLainnyaInput()">
                                    <label class="form-check-label">Lainnya</label>
                                    <input type="text" class="form-control ml-2" name="orang_merokok_lainnya" 
                                        id="lainnyaInput" placeholder="Masukkan lainnya" 
                                        style="display: {{ isset($merokok->orang_merokok_lainnya) && $merokok->orang_merokok_lainnya ? 'block' : 'none' }};"
                                        value="{{ isset($merokok->orang_merokok_lainnya) ? $merokok->orang_merokok_lainnya : '' }}">
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>3. Apakah ada anggota keluarga di rumah yang merokok?</label>
                            <div class="d-flex">
                                <div class="form-check mr-3">
                                    <input type="radio" class="form-check-input" name="anggota_keluarga_merokok" value="1"
                                        {{ isset($merokok) && $merokok->anggota_keluarga_merokok == 1 ? 'checked' : '' }}>
                                    <label class="form-check-label">Ya</label>
                                </div>
                                <div class="form-check">
                                    <input type="radio" class="form-check-input" name="anggota_keluarga_merokok" value="0"
                                        {{ isset($merokok) && $merokok->anggota_keluarga_merokok == 0 ? 'checked' : '' }}>
                                    <label class="form-check-label">Tidak</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>4. Apakah teman-teman dekatmu banyak yang merokok?</label>
                            <div class="d-flex">
                                <div class="form-check mr-3">
                                    <input type="radio" class="form-check-input" name="teman_merokok" value="1"
                                        {{ isset($merokok) && $merokok->teman_merokok == 1 ? 'checked' : '' }}>
                                    <label class="form-check-label">Ya</label>
                                </div>
                                <div class="form-check">
                                    <input type="radio" class="form-check-input" name="teman_merokok" value="0"
                                        {{ isset($merokok) && $merokok->teman_merokok == 0 ? 'checked' : '' }}>
                                    <label class="form-check-label">Tidak</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="section-e" style="margin-top: 10px">
                <h3>E. Pemeriksaan Kadar CO Pernapasan</h3>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>1. Apakah kamu bersedia memeriksakan kadar CO pernapasan?</label>
                            <div class="d-flex">
                                <div class="form-check mr-3">
                                    <input type="radio" class="form-check-input" name="periksa_co2" value="1" 
                                        {{ isset($merokok->periksa_co2) && $merokok->periksa_co2 == 1 ? 'checked' : '' }}>
                                    <label class="form-check-label">Ya</label>
                                </div>
                                <div class="form-check">
                                    <input type="radio" class="form-check-input" name="periksa_co2" value="0" 
                                        {{ isset($merokok->periksa_co2) && $merokok->periksa_co2 == 0 ? 'checked' : '' }}>
                                    <label class="form-check-label">Tidak</label>
                                </div>
                            </div>
                        </div>
                    </div>
                
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>2. Hasil pemeriksaan kadar CO pernapasan?</label>
                            <div class="row align-items-center">
                                <div class="col-auto">
                                    <input type="text" class="form-control" name="kadar_co2" placeholder="Kadar Co2"
                                        value="{{ isset($merokok->kadar_co2) ? $merokok->kadar_co2 : '' }}">
                                </div>
                                <div class="col-auto">
                                    <p class="mb-0">ppm</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>

        <div class="text-right mt-4">
            @if (isset($merokok) && $merokok)
            <a href="{{ route('merokok.mtbs.admin') }}" type="button" class="btn btn-secondary mr-2" style="font-size: 20px">Kembali</a>
        @else
            <a href="{{ route('skrining.ilp') }}" type="button" class="btn btn-secondary mr-2" style="font-size: 20px">Kembali</a>
        @endif
            <button type="submit" class="btn btn-primary">Kirim</button>
        </div>
    </form>
    <script>
        function toggleOtherRokokInput() {
            const lainnyaCheckbox = document.getElementById('jenis-rokok-lainnya-checkbox');
            const lainnyaInput = document.getElementById('jenis-rokok-lainnya-input');
            if (lainnyaCheckbox.checked) {
                lainnyaInput.style.display = 'block';
            } else {
                lainnyaInput.style.display = 'none';
            }
        }

        function toggleGetRokokInput() {
            const lainnyaCheckbox = document.getElementById('dapat-rokok-lainnya-checkbox');
            const lainnyaInput = document.getElementById('dapat-rokok-lainnya-input');
            if (lainnyaCheckbox.checked) {
                lainnyaInput.style.display = 'block';
            } else {
                lainnyaInput.style.display = 'none';
            }
        }

        function toggleReasonStopRokokInput() {
            const lainnyaCheckbox = document.getElementById('alasan-rokok-lainnya-checkbox');
            const lainnyaInput = document.getElementById('alasan-rokok-lainnya-input');
            if (lainnyaCheckbox.checked) {
                lainnyaInput.style.display = 'block';
            } else {
                lainnyaInput.style.display = 'none';
            }
        }

        function toggleOtherReasonInput(show) {
            const inputField = document.getElementById('other-reason-input');
            inputField.style.display = show ? 'block' : 'none';
        }

        function toggleAdditionalQuestion(show) {
            const additionalQuestion = document.getElementById("additional-question");
            additionalQuestion.style.display = show ? "block" : "none";
        }

        function toggleLainnyaInput() {
            const lainnyaInput = document.getElementById("lainnyaInput");
            const lainnyaCheckbox = document.getElementById("lainnyaCheckbox");
            lainnyaInput.style.display = lainnyaCheckbox.checked ? "block" : "none";
        }
    </script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function() {
        // Inisialisasi Select2
        $('.select2').select2({
            placeholder: "Pilih pasien",
            allowClear: true    
        });
    
        // Event listener saat pasien dipilih
        $('#pasien').on('change', function() {
            var selectedOption = $(this).find(':selected');
    
            // Ambil data dari atribut data-*
            var no_hp = selectedOption.data('no_hp');
            var nik = selectedOption.data('nik');
            var dob = selectedOption.data('dob');
            var alamat = selectedOption.data('alamat');
            var jk = selectedOption.data('jenis_kelamin');
            console.log(jk);
            
            // Isi input dengan data yang diambil
            $('#no_hp').val(no_hp);
            $('#nik').val(nik);
            $('#tanggal_lahir').val(dob);
            $('#alamat').val(alamat);
            $('input[name="jenis_kelamin"]').prop('checked', false); // Uncheck all checkboxes first
            if (jk === 'Laki-Laki') {
                $('#jk_laki').prop('checked', true);
            } else if (jk === 'Perempuan') {
                $('#jk_perempuan').prop('checked', true);
            }
                });
        $('#pasien').trigger('change');
    });
    
    </script>
@endsection

