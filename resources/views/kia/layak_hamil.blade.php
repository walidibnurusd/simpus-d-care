<<<<<<< HEAD
@extends('layouts.skrining.master')
@section('title', 'Skrining Layak Hamil')


@section('content')
    <!-- Identitas Section -->
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

    <form action="{{ isset($layakHamil) ? route('layak_hamil.update', $layakHamil->id) : route('layak_hamil.store') }}"
        method="POST">
        @csrf
        @if (isset($layakHamil))
            @method('PUT')
        @endif
        <div class="form-section">
            <h3>Identitas</h3>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>1. Pasien</label>
                        <select class="form-control form-select select2" id="pasien" name="pasien">
                            <option value="" disabled {{ old('pasien') == '' ? 'selected' : '' }}>Pilih</option>
                            @foreach ($pasien as $item)
                                <option value="{{ $item->id }}" data-no_hp="{{ $item->phone }}"
                                    data-nik="{{ $item->nik }}" data-dob="{{ $item->dob }}"
                                    data-alamat="{{ $item->address }}"
                                    {{ old('pasien', $layakHamil->pasien ?? '') == $item->id ? 'selected' : '' }}>
                                    {{ $item->name }} - {{ $item->nik }}
                                </option>
                            @endforeach
                        </select>
                        @error('pasien')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>


                <div class="col-md-6">
                    <div class="form-group">
                        <label>2. No HP</label>
                        <input type="number" class="form-control" readonly
                            value="{{ old('no_hp', $layakHamil->no_hp ?? '') }}" id="no_hp" name="no_hp"
                            placeholder="Masukkan nomor HP">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>3. NIK</label>
                        <input type="text" readonly class="form-control"
                            value="{{ old('nik', $layakHamil->nik ?? '') }}" id="nik" name="nik"
                            placeholder="Masukkan NIK">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>4. Status</label>
                        <div class="d-flex">
                            <div class="form-check mr-3">
                                <input type="radio" class="form-check-input" name="status" value="PUS" id="statusPUS"
                                    {{ old('status', $layakHamil->status ?? '') == 'PUS' ? 'checked' : '' }}>
                                <label class="form-check-label" for="statusPUS">PUS</label>
                            </div>
                            <div class="form-check">
                                <input type="radio" class="form-check-input" name="status" value="Catin"
                                    id="statusCatin"
                                    {{ old('status', $layakHamil->status ?? '') == 'Catin' ? 'checked' : '' }}>
                                <label class="form-check-label" for="statusCatin">Catin</label>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>5. Nama Suami/Calon Suami</label>
                        <input type="text" class="form-control" name="nama_suami"
                            value="{{ old('nama_suami', $layakHamil->nama_suami ?? '') }}"
                            placeholder="Masukkan no_hp suami/calon suami">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>6. Alamat Domisili</label>
                        <input readonly type="text" class="form-control" name="alamat" id="alamat"
                            value="{{ old('alamat', $layakHamil->alamat ?? '') }}" placeholder="Masukkan alamat domisili">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>7. Apakah masih menginginkan kehamilan</label>
                        <div class="d-flex">
                            <div class="form-check mr-3">
                                <input type="radio" class="form-check-input" name="ingin_hamil" value="0"
                                    id="tidakIngin" @if (old('ingin_hamil', $layakHamil->ingin_hamil ?? '') == 0) checked @endif>
                                <label class="form-check-label" for="tidakIngin">Tidak</label>
                            </div>
                            <div class="form-check">
                                <input type="radio" class="form-check-input" name="ingin_hamil" value="1"
                                    id="ingin" @if (old('ingin_hamil', $layakHamil->ingin_hamil ?? '') == 1) checked @endif>
                                <label class="form-check-label" for="ingin">Ya</label>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>8. Tanggal Lahir</label>
                        <input type="date" class="form-control" readonly name="tanggal_lahir" id="tanggal_lahir"
                            value="{{ old('tanggal_lahir', $layakHamil->tanggal_lahir ?? '') }}">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>9. Umur</label>
                        <div class="d-flex flex-wrap">
                            <div class="form-check mr-3">
                                <input type="radio" class="form-check-input" name="umur" value="<20"
                                    id="umur1" @if (old('umur', $layakHamil->umur ?? '') == '<20') checked @endif>
                                <label class="form-check-label" for="umur1">&lt; 20 Tahun</label>
                            </div>
                            <div class="form-check mr-3">
                                <input type="radio" class="form-check-input" name="umur" value="20-35"
                                    id="umur2" @if (old('umur', $layakHamil->umur ?? '') == '20-35') checked @endif>
                                <label class="form-check-label" for="umur2">20 - 35 Tahun</label>
                            </div>
                            <div class="form-check mr-3">
                                <input type="radio" class="form-check-input" name="umur" value="36-40"
                                    id="umur3" @if (old('umur', $layakHamil->umur ?? '') == '36-40') checked @endif>
                                <label class="form-check-label" for="umur3">36 - 40 Tahun</label>
                            </div>
                            <div class="form-check">
                                <input type="radio" class="form-check-input" name="umur" value=">40"
                                    id="umur4" @if (old('umur', $layakHamil->umur ?? '') == '>40')
                                checked
                                @endif>
                                <label class="form-check-label" for="umur4">&gt; 40 Tahun</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>10. Jumlah Anak</label>
                        <div class="d-flex flex-wrap">
                            <div class="form-check mr-3">
                                <input type="radio" class="form-check-input" name="jumlah_anak" value=">3"
                                    id="anakLebih3" @if (old('jumlah_anak', $layakHamil->jumlah_anak ?? '') == '>3')
                                checked
                                @endif>
                                <label class="form-check-label" for="anakLebih3">&gt; 3 Anak</label>
                            </div>
                            <div class="form-check mr-3">
                                <input type="radio" class="form-check-input" name="jumlah_anak" value="1-2"
                                    id="anak1-2" @if (old('jumlah_anak', $layakHamil->jumlah_anak ?? '') == '1-2') checked @endif>
                                <label class="form-check-label" for="anak1-2">1 - 2 Anak</label>
                            </div>
                            <div class="form-check">
                                <input type="radio" class="form-check-input" name="jumlah_anak" value="0"
                                    id="anakBelum" @if (old('jumlah_anak', $layakHamil->jumlah_anak ?? '') == '0') checked @endif>
                                <label class="form-check-label" for="anakBelum">Belum Ada</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>11. Waktu Persalinan Terakhir</label>
                        <div class="d-flex">
                            <div class="form-check mr-3">
                                <input type="radio" class="form-check-input" name="waktu_persalinan_terakhir"
                                    value="<2" id="persalinan2" @if (old('waktu_persalinan_terakhir', $layakHamil->waktu_persalinan_terakhir ?? '') == '<2') checked @endif>
                                <label class="form-check-label" for="persalinan2">&lt; 2 Tahun Lalu</label>
                            </div>
                            <div class="form-check mr-3">
                                <input type="radio" class="form-check-input" name="waktu_persalinan_terakhir"
                                    value=">2" id="persalinan2plus" @if (old('waktu_persalinan_terakhir', $layakHamil->waktu_persalinan_terakhir ?? '') == '>2')
                                checked
                                @endif>
                                <label class="form-check-label" for="persalinan2plus">&gt; 2 Tahun Lalu</label>
                            </div>
                            <div class="form-check">
                                <input type="radio" class="form-check-input" name="waktu_persalinan_terakhir"
                                    value="0" id="belumPersalinan" @if (old('waktu_persalinan_terakhir', $layakHamil->waktu_persalinan_terakhir ?? '') == '0') checked @endif>
                                <label class="form-check-label" for="belumPersalinan">Belum Pernah</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>12. Lingkar Lengan Atas</label>
                        <div class="d-flex">
                            <div class="form-check mr-3">
                                <input type="radio" class="form-check-input" name="lingkar_lengan_atas" value="<23.5"
                                    id="lingkarKecil" @if (old('lingkar_lengan_atas', $layakHamil->lingkar_lengan_atas ?? '') == '<23.5') checked @endif>
                                <label class="form-check-label" for="lingkarKecil">&lt; 23.5 cm</label>
                            </div>
                            <div class="form-check mr-3">
                                <input type="radio" class="form-check-input" name="lingkar_lengan_atas" value=">23.5"
                                    id="lingkarBesar" @if (old('lingkar_lengan_atas', $layakHamil->lingkar_lengan_atas ?? '') == '>23.5')
                                checked
                                @endif>
                                <label class="form-check-label" for="lingkarBesar">&gt; 23.5 cm</label>
                            </div>
                            <div class="form-check">
                                <input type="radio" class="form-check-input" name="lingkar_lengan_atas" value="0"
                                    id="kek" @if (old('lingkar_lengan_atas', $layakHamil->lingkar_lengan_atas ?? '') == '0') checked @endif>
                                <label class="form-check-label" for="kek">KEK</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- Penyakit Section -->
        <div class="form-section">
            <h3>Penyakit</h3>
            <div class="form-group">
                <label>1. Apakah Anda pernah menderita salah satu penyakit di bawah ini:</label>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" name="penyakit[]" value="hipertensi"
                                id="hipertensi" @if (in_array('hipertensi', $layakHamil->penyakit ?? [])) checked @endif>
                            <label class="form-check-label" for="hipertensi">Darah Tinggi (Hipertensi)</label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" name="penyakit[]" value="diabetes"
                                id="diabetes" @if (in_array('diabetes', $layakHamil->penyakit ?? [])) checked @endif>
                            <label class="form-check-label" for="diabetes">Diabetes Mellitus</label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" name="penyakit[]" value="jantung"
                                id="jantung" @if (in_array('jantung', $layakHamil->penyakit ?? [])) checked @endif>
                            <label class="form-check-label" for="jantung">Penyakit Jantung</label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" name="penyakit[]" value="kronis"
                                id="kronis" @if (in_array('kronis', $layakHamil->penyakit ?? [])) checked @endif>
                            <label class="form-check-label" for="kronis">Penyakit Kronis</label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" name="penyakit[]" value="pengentalan_darah"
                                id="pengentalan_darah" @if (in_array('pengentalan_darah', $layakHamil->penyakit ?? [])) checked @endif>
                            <label class="form-check-label" for="pengentalan_darah">Pengentalan Darah</label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" name="penyakit[]" value="menular_seksual"
                                id="menular_seksual" @if (in_array('menular_seksual', $layakHamil->penyakit ?? [])) checked @endif>
                            <label class="form-check-label" for="menular_seksual">Penyakit Menular Seksual</label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" name="penyakit[]" value="asma"
                                id="asma" @if (in_array('asma', $layakHamil->penyakit ?? [])) checked @endif>
                            <label class="form-check-label" for="asma">Asma</label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" name="penyakit[]" value="gondok"
                                id="gondok" @if (in_array('gondok', $layakHamil->penyakit ?? [])) checked @endif>
                            <label class="form-check-label" for="gondok">Gondok</label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" name="penyakit[]" value="kanker"
                                id="kanker" @if (in_array('kanker', $layakHamil->penyakit ?? [])) checked @endif>
                            <label class="form-check-label" for="kanker">Kanker</label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" name="penyakit[]" value="malaria"
                                id="malaria" @if (in_array('malaria', $layakHamil->penyakit ?? [])) checked @endif>
                            <label class="form-check-label" for="malaria">Malaria</label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" name="penyakit[]" value="torch"
                                id="torch" @if (in_array('torch', $layakHamil->penyakit ?? [])) checked @endif>
                            <label class="form-check-label" for="torch">TORCH</label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" name="penyakit[]" value="hiv"
                                id="hiv" @if (in_array('hiv', $layakHamil->penyakit ?? [])) checked @endif>
                            <label class="form-check-label" for="hiv">HIV</label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" name="penyakit[]" value="tb_paru"
                                id="tb_paru" @if (in_array('tb_paru', $layakHamil->penyakit ?? [])) checked @endif>
                            <label class="form-check-label" for="tb_paru">TB Paru</label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" name="penyakit[]" value="hepatitis"
                                id="hepatitis" @if (in_array('hepatitis', $layakHamil->penyakit ?? [])) checked @endif>
                            <label class="form-check-label" for="hepatitis">Hepatitis</label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" name="penyakit[]" value="talasemia"
                                id="talasemia" @if (in_array('talasemia', $layakHamil->penyakit ?? [])) checked @endif>
                            <label class="form-check-label" for="talasemia">Talasemia</label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" name="penyakit[]" value="gangguan_mental"
                                id="gangguan_mental" @if (in_array('gangguan_mental', $layakHamil->penyakit ?? [])) checked @endif>
                            <label class="form-check-label" for="gangguan_mental">Gang. Mental</label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label>2. Apakah suami Anda pernah atau sedang menderita penyakit di bawah ini:</label>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" name="penyakit_suami[]"
                                value="tb_paru_suami" id="tb_paru_suami"
                                @if (in_array('tb_paru_suami', $layakHamil->penyakit_suami ?? [])) checked @endif>
                            <label class="form-check-label" for="tb_paru_suami">TB Paru</label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" name="penyakit_suami[]"
                                value="menular_seksual_suami" id="menular_seksual_suami"
                                @if (in_array('menular_seksual_suami', $layakHamil->penyakit_suami ?? [])) checked @endif>
                            <label class="form-check-label" for="menular_seksual_suami">Penyakit Menular Seksual</label>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" name="penyakit_suami[]"
                                value="hepatitis_suami" id="hepatitis_suami"
                                @if (in_array('hepatitis_suami', $layakHamil->penyakit_suami ?? [])) checked @endif>
                            <label class="form-check-label" for="hepatitis_suami">Hepatitis</label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" name="penyakit_suami[]" value="hiv_suami"
                                id="hiv_suami" @if (in_array('hiv_suami', $layakHamil->penyakit_suami ?? [])) checked @endif>
                            <label class="form-check-label" for="hiv_suami">HIV</label>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" name="penyakit_suami[]"
                                value="talasemia_suami" id="talasemia_suami"
                                @if (in_array('talasemia_suami', $layakHamil->penyakit_suami ?? [])) checked @endif>
                            <label class="form-check-label" for="talasemia_suami">Talasemia</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label>3. Deteksi dini masalah kesehatan jiwa:</label>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" name="kesehatan_jiwa[]"
                                value="deteksi_sakit_kepala" id="deteksi_sakit_kepala"
                                @if (in_array('deteksi_sakit_kepala', $layakHamil->kesehatan_jiwa ?? [])) checked @endif>
                            <label class="form-check-label" for="deteksi_sakit_kepala">Apakah Anda sering
                                menderita
                                sakit kepala?</label>

                        </div>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" name="kesehatan_jiwa[]"
                                value="deteksi_nafsu_makan" id="deteksi_nafsu_makan"
                                @if (in_array('deteksi_nafsu_makan', $layakHamil->kesehatan_jiwa ?? [])) checked @endif>
                            <label class="form-check-label" for="deteksi_nafsu_makan">Apakah Anda
                                kehilangan
                                nafsu makan?</label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input"
                                @if (in_array('deteksi_tidur_lelap', $layakHamil->kesehatan_jiwa ?? [])) checked @endif name="kesehatan_jiwa[]"
                                value="deteksi_tidur_lelap" id="deteksi_tidur_lelap">
                            <label class="form-check-label" for="deteksi_tidur_lelap">Apakah tidur Anda
                                tidak
                                lelap?</label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input"
                                @if (in_array('deteksi_takut', $layakHamil->kesehatan_jiwa ?? [])) checked @endif name="kesehatan_jiwa[]"
                                value="deteksi_takut" id="deteksi_takut">
                            <label class="form-check-label" for="deteksi_takut">Apakah Anda mudah
                                menjadi takut?</label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input"
                                @if (in_array('deteksi_cemas', $layakHamil->kesehatan_jiwa ?? [])) checked @endif name="kesehatan_jiwa[]"
                                value="deteksi_cemas" id="deteksi_cemas">
                            <label class="form-check-label" for="deteksi_cemas">Apakah Anda merasa
                                cemas, tegang dan khawatir?</label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input"
                                @if (in_array('deteksi_tangan_gemetar', $layakHamil->kesehatan_jiwa ?? [])) checked @endif name="kesehatan_jiwa[]"
                                value="deteksi_tangan_gemetar" id="deteksi_tangan_gemetar">
                            <label class="form-check-label" for="deteksi_tangan_gemetar">Apakah tangan
                                Anda
                                gemetar?</label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input"
                                @if (in_array('deteksi_gangguan_pencernaan', $layakHamil->kesehatan_jiwa ?? [])) checked @endif name="kesehatan_jiwa[]"
                                value="deteksi_gangguan_pencernaan" id="deteksi_gangguan_pencernaan">
                            <label class="form-check-label" for="deteksi_gangguan_pencernaan">Apakah Anda
                                mengalami gangguan pencernaan?</label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input"
                                @if (in_array('deteksi_berfikir_jernih', $layakHamil->kesehatan_jiwa ?? [])) checked @endif name="kesehatan_jiwa[]"
                                value="deteksi_berfikir_jernih" id="deteksi_berfikir_jernih">
                            <label class="form-check-label" for="deteksi_berfikir_jernih">Apakah Anda
                                merasa
                                sulit berfikir jernih?</label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input"
                                @if (in_array('deteksi_bahagia', $layakHamil->kesehatan_jiwa ?? [])) checked @endif name="kesehatan_jiwa[]"
                                value="deteksi_bahagia" id="deteksi_bahagia">
                            <label class="form-check-label" for="deteksi_bahagia">Apakah Anda merasa tidak
                                bahagia?</label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input"
                                @if (in_array('deteksi_menangis', $layakHamil->kesehatan_jiwa ?? [])) checked @endif name="kesehatan_jiwa[]"
                                value="deteksi_menangis" id="deteksi_menangis">
                            <label class="form-check-label" for="deteksi_menangis">Apakah Anda sering
                                menangis?</label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input"
                                @if (in_array('deteksi_aktivitas', $layakHamil->kesehatan_jiwa ?? [])) checked @endif name="kesehatan_jiwa[]"
                                value="deteksi_aktivitas" id="deteksi_aktivitas">
                            <label class="form-check-label" for="deteksi_aktivitas">Apakah Anda merasa
                                sulit
                                untuk menikmati aktivitas sehari-hari?</label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input"
                                @if (in_array('deteksi_sulit_keputusan', $layakHamil->kesehatan_jiwa ?? [])) checked @endif name="kesehatan_jiwa[]"
                                value="deteksi_sulit_keputusan" id="deteksi_sulit_keputusan">
                            <label class="form-check-label" for="deteksi_sulit_keputusan">Apakah Anda
                                mengalami
                                kesulitan untuk mengambil keputusan?</label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input"
                                @if (in_array('deteksi_terbengkalai', $layakHamil->kesehatan_jiwa ?? [])) checked @endif name="kesehatan_jiwa[]"
                                value="deteksi_terbengkalai" id="deteksi_terbengkalai">
                            <label class="form-check-label" for="deteksi_terbengkalai">Apakah aktivitas
                                sehari-hari Anda terbengkalai?</label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input"
                                @if (in_array('deteksi_kehidupan', $layakHamil->kesehatan_jiwa ?? [])) checked @endif name="kesehatan_jiwa[]"
                                value="deteksi_kehidupan" id="deteksi_kehidupan">
                            <label class="form-check-label" for="deteksi_kehidupan">Apakah Anda merasa
                                tidak
                                mampu berperan dalam kehidupan ini?</label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input"
                                @if (in_array('deteksi_kehilangan', $layakHamil->kesehatan_jiwa ?? [])) checked @endif name="kesehatan_jiwa[]"
                                value="deteksi_kehilangan" id="deteksi_kehilangan">
                            <label class="form-check-label" for="deteksi_kehilangan">Apakah Anda
                                kehilangan
                                minat terhadap banyak hal?</label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input"
                                @if (in_array('deteksi_tidak_berharga', $layakHamil->kesehatan_jiwa ?? [])) checked @endif name="kesehatan_jiwa[]"
                                value="deteksi_tidak_berharga" id="deteksi_tidak_berharga">
                            <label class="form-check-label" for="deteksi_tidak_berharga">Apakah Anda
                                merasa
                                tidak
                                berharga?</label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input"
                                @if (in_array('deteksi_pikiran', $layakHamil->kesehatan_jiwa ?? [])) checked @endif name="kesehatan_jiwa[]"
                                value="deteksi_pikiran" id="deteksi_pikiran">
                            <label class="form-check-label" for="deteksi_pikiran">Apakah Anda mempunyai
                                pikiran untuk mengakhiri hidup Anda?</label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input"
                                @if (in_array('deteksi_lelah_waktu', $layakHamil->kesehatan_jiwa ?? [])) checked @endif name="kesehatan_jiwa[]"
                                value="deteksi_lelah_waktu" id="deteksi_lelah_waktu">
                            <label class="form-check-label" for="deteksi_lelah_waktu">Apakah Anda merasa
                                lelah
                                sepanjang waktu?</label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input"
                                @if (in_array('deteksi_perut', $layakHamil->kesehatan_jiwa ?? [])) checked @endif name="kesehatan_jiwa[]"
                                value="deteksi_perut" id="deteksi_perut">
                            <label class="form-check-label" for="deteksi_perut">Apakah Anda merasa tidak
                                enak diperut?</label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input"
                                @if (in_array('deteksi_mudah_lelah', $layakHamil->kesehatan_jiwa ?? [])) checked @endif name="kesehatan_jiwa[]"
                                value="deteksi_mudah_lelah" id="deteksi_mudah_lelah">
                            <label class="form-check-label" for="deteksi_mudah_lelah">Apakah Anda mudah
                                lelah
                                ?</label>
                        </div>
                        <div class="form-group">
                            <div class="col-md-12">
                                <label for="kesimpulan" style="color: rgb(19, 11, 241);">Kesimpulan</label>
                                <textarea class="form-control" id="kesimpulan" name="kesimpulan" placeholder="Kesimpulan">{{ old('kesimpulan', $layakHamil->kesimpulan ?? '') }}</textarea>
                            </div>
                        </div>

                    </div>


                </div>
            </div>
        </div>
        <div class="text-right mt-4">
            {{-- @if (isset($layakHamil))
                <a href="{{ route('layakHamil.admin') }}" type="button" class="btn btn-secondary mr-2"
                    style="font-size: 20px">Kembali</a>
            @else
                <a href="{{ route('skrining.ilp') }}" type="button" class="btn btn-secondary mr-2"
                    style="font-size: 20px">Kembali</a>
            @endif --}}
            <button type="submit" class="btn btn-primary" style="font-size: 20px">Kirim</button>
        </div>
    </form>
@endsection
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

            // Isi input dengan data yang diambil
            $('#no_hp').val(no_hp);
            $('#nik').val(nik);
            $('#tanggal_lahir').val(dob);
            $('#alamat').val(alamat);
        });
        $('#pasien').trigger('change');
    });
</script>
=======
@extends('layouts.skrining.master')
@section('title', 'Skrining Layak Hamil')


@section('content')
    <!-- Identitas Section -->
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

    <form action="{{ isset($layakHamil) ? route('layak_hamil.update', $layakHamil->id) : route('layak_hamil.store') }}"
        method="POST">
        @csrf
        @if (isset($layakHamil))
            @method('PUT')
        @endif
        <div class="form-section">
            <h3>Identitas</h3>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>1. Pasien</label>
                        <select class="form-control form-select select2" id="pasien" name="pasien">
                            <option value="" disabled {{ old('pasien') == '' ? 'selected' : '' }}>Pilih</option>
                            @foreach ($pasien as $item)
                                <option value="{{ $item->id }}" data-no_hp="{{ $item->phone }}"
                                    data-nik="{{ $item->nik }}" data-dob="{{ $item->dob }}"
                                    data-alamat="{{ $item->address }}"
                                    {{ old('pasien', $layakHamil->pasien ?? '') == $item->id ? 'selected' : '' }}>
                                    {{ $item->name }} - {{ $item->nik }}
                                </option>
                            @endforeach
                        </select>
                        @error('pasien')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>


                <div class="col-md-6">
                    <div class="form-group">
                        <label>2. No HP</label>
                        <input type="number" class="form-control" readonly
                            value="{{ old('no_hp', $layakHamil->no_hp ?? '') }}" id="no_hp" name="no_hp"
                            placeholder="Masukkan nomor HP">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>3. NIK</label>
                        <input type="text" readonly class="form-control"
                            value="{{ old('nik', $layakHamil->nik ?? '') }}" id="nik" name="nik"
                            placeholder="Masukkan NIK">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>4. Status</label>
                        <div class="d-flex">
                            <div class="form-check mr-3">
                                <input type="radio" class="form-check-input" name="status" value="PUS" id="statusPUS"
                                    {{ old('status', $layakHamil->status ?? '') == 'PUS' ? 'checked' : '' }}>
                                <label class="form-check-label" for="statusPUS">PUS</label>
                            </div>
                            <div class="form-check">
                                <input type="radio" class="form-check-input" name="status" value="Catin"
                                    id="statusCatin"
                                    {{ old('status', $layakHamil->status ?? '') == 'Catin' ? 'checked' : '' }}>
                                <label class="form-check-label" for="statusCatin">Catin</label>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>5. Nama Suami/Calon Suami</label>
                        <input type="text" class="form-control" name="nama_suami"
                            value="{{ old('nama_suami', $layakHamil->nama_suami ?? '') }}"
                            placeholder="Masukkan no_hp suami/calon suami">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>6. Alamat Domisili</label>
                        <input readonly type="text" class="form-control" name="alamat" id="alamat"
                            value="{{ old('alamat', $layakHamil->alamat ?? '') }}" placeholder="Masukkan alamat domisili">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>7. Apakah masih menginginkan kehamilan</label>
                        <div class="d-flex">
                            <div class="form-check mr-3">
                                <input type="radio" class="form-check-input" name="ingin_hamil" value="0"
                                    id="tidakIngin" @if (old('ingin_hamil', $layakHamil->ingin_hamil ?? '') == 0) checked @endif>
                                <label class="form-check-label" for="tidakIngin">Tidak</label>
                            </div>
                            <div class="form-check">
                                <input type="radio" class="form-check-input" name="ingin_hamil" value="1"
                                    id="ingin" @if (old('ingin_hamil', $layakHamil->ingin_hamil ?? '') == 1) checked @endif>
                                <label class="form-check-label" for="ingin">Ya</label>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>8. Tanggal Lahir</label>
                        <input type="date" class="form-control" readonly name="tanggal_lahir" id="tanggal_lahir"
                            value="{{ old('tanggal_lahir', $layakHamil->tanggal_lahir ?? '') }}">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>9. Umur</label>
                        <div class="d-flex flex-wrap">
                            <div class="form-check mr-3">
                                <input type="radio" class="form-check-input" name="umur" value="<20"
                                    id="umur1" @if (old('umur', $layakHamil->umur ?? '') == '<20') checked @endif>
                                <label class="form-check-label" for="umur1">&lt; 20 Tahun</label>
                            </div>
                            <div class="form-check mr-3">
                                <input type="radio" class="form-check-input" name="umur" value="20-35"
                                    id="umur2" @if (old('umur', $layakHamil->umur ?? '') == '20-35') checked @endif>
                                <label class="form-check-label" for="umur2">20 - 35 Tahun</label>
                            </div>
                            <div class="form-check mr-3">
                                <input type="radio" class="form-check-input" name="umur" value="36-40"
                                    id="umur3" @if (old('umur', $layakHamil->umur ?? '') == '36-40') checked @endif>
                                <label class="form-check-label" for="umur3">36 - 40 Tahun</label>
                            </div>
                            <div class="form-check">
                                <input type="radio" class="form-check-input" name="umur" value=">40"
                                    id="umur4" @if (old('umur', $layakHamil->umur ?? '') == '>40')
                                checked
                                @endif>
                                <label class="form-check-label" for="umur4">&gt; 40 Tahun</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>10. Jumlah Anak</label>
                        <div class="d-flex flex-wrap">
                            <div class="form-check mr-3">
                                <input type="radio" class="form-check-input" name="jumlah_anak" value=">3"
                                    id="anakLebih3" @if (old('jumlah_anak', $layakHamil->jumlah_anak ?? '') == '>3')
                                checked
                                @endif>
                                <label class="form-check-label" for="anakLebih3">&gt; 3 Anak</label>
                            </div>
                            <div class="form-check mr-3">
                                <input type="radio" class="form-check-input" name="jumlah_anak" value="1-2"
                                    id="anak1-2" @if (old('jumlah_anak', $layakHamil->jumlah_anak ?? '') == '1-2') checked @endif>
                                <label class="form-check-label" for="anak1-2">1 - 2 Anak</label>
                            </div>
                            <div class="form-check">
                                <input type="radio" class="form-check-input" name="jumlah_anak" value="0"
                                    id="anakBelum" @if (old('jumlah_anak', $layakHamil->jumlah_anak ?? '') == '0') checked @endif>
                                <label class="form-check-label" for="anakBelum">Belum Ada</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>11. Waktu Persalinan Terakhir</label>
                        <div class="d-flex">
                            <div class="form-check mr-3">
                                <input type="radio" class="form-check-input" name="waktu_persalinan_terakhir"
                                    value="<2" id="persalinan2" @if (old('waktu_persalinan_terakhir', $layakHamil->waktu_persalinan_terakhir ?? '') == '<2') checked @endif>
                                <label class="form-check-label" for="persalinan2">&lt; 2 Tahun Lalu</label>
                            </div>
                            <div class="form-check mr-3">
                                <input type="radio" class="form-check-input" name="waktu_persalinan_terakhir"
                                    value=">2" id="persalinan2plus" @if (old('waktu_persalinan_terakhir', $layakHamil->waktu_persalinan_terakhir ?? '') == '>2')
                                checked
                                @endif>
                                <label class="form-check-label" for="persalinan2plus">&gt; 2 Tahun Lalu</label>
                            </div>
                            <div class="form-check">
                                <input type="radio" class="form-check-input" name="waktu_persalinan_terakhir"
                                    value="0" id="belumPersalinan" @if (old('waktu_persalinan_terakhir', $layakHamil->waktu_persalinan_terakhir ?? '') == '0') checked @endif>
                                <label class="form-check-label" for="belumPersalinan">Belum Pernah</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>12. Lingkar Lengan Atas</label>
                        <div class="d-flex">
                            <div class="form-check mr-3">
                                <input type="radio" class="form-check-input" name="lingkar_lengan_atas" value="<23.5"
                                    id="lingkarKecil" @if (old('lingkar_lengan_atas', $layakHamil->lingkar_lengan_atas ?? '') == '<23.5') checked @endif>
                                <label class="form-check-label" for="lingkarKecil">&lt; 23.5 cm</label>
                            </div>
                            <div class="form-check mr-3">
                                <input type="radio" class="form-check-input" name="lingkar_lengan_atas" value=">23.5"
                                    id="lingkarBesar" @if (old('lingkar_lengan_atas', $layakHamil->lingkar_lengan_atas ?? '') == '>23.5')
                                checked
                                @endif>
                                <label class="form-check-label" for="lingkarBesar">&gt; 23.5 cm</label>
                            </div>
                            <div class="form-check">
                                <input type="radio" class="form-check-input" name="lingkar_lengan_atas" value="0"
                                    id="kek" @if (old('lingkar_lengan_atas', $layakHamil->lingkar_lengan_atas ?? '') == '0') checked @endif>
                                <label class="form-check-label" for="kek">KEK</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- Penyakit Section -->
        <div class="form-section">
            <h3>Penyakit</h3>
            <div class="form-group">
                <label>1. Apakah Anda pernah menderita salah satu penyakit di bawah ini:</label>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" name="penyakit[]" value="hipertensi"
                                id="hipertensi" @if (in_array('hipertensi', $layakHamil->penyakit ?? [])) checked @endif>
                            <label class="form-check-label" for="hipertensi">Darah Tinggi (Hipertensi)</label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" name="penyakit[]" value="diabetes"
                                id="diabetes" @if (in_array('diabetes', $layakHamil->penyakit ?? [])) checked @endif>
                            <label class="form-check-label" for="diabetes">Diabetes Mellitus</label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" name="penyakit[]" value="jantung"
                                id="jantung" @if (in_array('jantung', $layakHamil->penyakit ?? [])) checked @endif>
                            <label class="form-check-label" for="jantung">Penyakit Jantung</label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" name="penyakit[]" value="kronis"
                                id="kronis" @if (in_array('kronis', $layakHamil->penyakit ?? [])) checked @endif>
                            <label class="form-check-label" for="kronis">Penyakit Kronis</label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" name="penyakit[]" value="pengentalan_darah"
                                id="pengentalan_darah" @if (in_array('pengentalan_darah', $layakHamil->penyakit ?? [])) checked @endif>
                            <label class="form-check-label" for="pengentalan_darah">Pengentalan Darah</label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" name="penyakit[]" value="menular_seksual"
                                id="menular_seksual" @if (in_array('menular_seksual', $layakHamil->penyakit ?? [])) checked @endif>
                            <label class="form-check-label" for="menular_seksual">Penyakit Menular Seksual</label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" name="penyakit[]" value="asma"
                                id="asma" @if (in_array('asma', $layakHamil->penyakit ?? [])) checked @endif>
                            <label class="form-check-label" for="asma">Asma</label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" name="penyakit[]" value="gondok"
                                id="gondok" @if (in_array('gondok', $layakHamil->penyakit ?? [])) checked @endif>
                            <label class="form-check-label" for="gondok">Gondok</label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" name="penyakit[]" value="kanker"
                                id="kanker" @if (in_array('kanker', $layakHamil->penyakit ?? [])) checked @endif>
                            <label class="form-check-label" for="kanker">Kanker</label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" name="penyakit[]" value="malaria"
                                id="malaria" @if (in_array('malaria', $layakHamil->penyakit ?? [])) checked @endif>
                            <label class="form-check-label" for="malaria">Malaria</label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" name="penyakit[]" value="torch"
                                id="torch" @if (in_array('torch', $layakHamil->penyakit ?? [])) checked @endif>
                            <label class="form-check-label" for="torch">TORCH</label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" name="penyakit[]" value="hiv"
                                id="hiv" @if (in_array('hiv', $layakHamil->penyakit ?? [])) checked @endif>
                            <label class="form-check-label" for="hiv">HIV</label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" name="penyakit[]" value="tb_paru"
                                id="tb_paru" @if (in_array('tb_paru', $layakHamil->penyakit ?? [])) checked @endif>
                            <label class="form-check-label" for="tb_paru">TB Paru</label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" name="penyakit[]" value="hepatitis"
                                id="hepatitis" @if (in_array('hepatitis', $layakHamil->penyakit ?? [])) checked @endif>
                            <label class="form-check-label" for="hepatitis">Hepatitis</label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" name="penyakit[]" value="talasemia"
                                id="talasemia" @if (in_array('talasemia', $layakHamil->penyakit ?? [])) checked @endif>
                            <label class="form-check-label" for="talasemia">Talasemia</label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" name="penyakit[]" value="gangguan_mental"
                                id="gangguan_mental" @if (in_array('gangguan_mental', $layakHamil->penyakit ?? [])) checked @endif>
                            <label class="form-check-label" for="gangguan_mental">Gang. Mental</label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label>2. Apakah suami Anda pernah atau sedang menderita penyakit di bawah ini:</label>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" name="penyakit_suami[]"
                                value="tb_paru_suami" id="tb_paru_suami"
                                @if (in_array('tb_paru_suami', $layakHamil->penyakit_suami ?? [])) checked @endif>
                            <label class="form-check-label" for="tb_paru_suami">TB Paru</label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" name="penyakit_suami[]"
                                value="menular_seksual_suami" id="menular_seksual_suami"
                                @if (in_array('menular_seksual_suami', $layakHamil->penyakit_suami ?? [])) checked @endif>
                            <label class="form-check-label" for="menular_seksual_suami">Penyakit Menular Seksual</label>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" name="penyakit_suami[]"
                                value="hepatitis_suami" id="hepatitis_suami"
                                @if (in_array('hepatitis_suami', $layakHamil->penyakit_suami ?? [])) checked @endif>
                            <label class="form-check-label" for="hepatitis_suami">Hepatitis</label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" name="penyakit_suami[]" value="hiv_suami"
                                id="hiv_suami" @if (in_array('hiv_suami', $layakHamil->penyakit_suami ?? [])) checked @endif>
                            <label class="form-check-label" for="hiv_suami">HIV</label>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" name="penyakit_suami[]"
                                value="talasemia_suami" id="talasemia_suami"
                                @if (in_array('talasemia_suami', $layakHamil->penyakit_suami ?? [])) checked @endif>
                            <label class="form-check-label" for="talasemia_suami">Talasemia</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label>3. Deteksi dini masalah kesehatan jiwa:</label>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" name="kesehatan_jiwa[]"
                                value="deteksi_sakit_kepala" id="deteksi_sakit_kepala"
                                @if (in_array('deteksi_sakit_kepala', $layakHamil->kesehatan_jiwa ?? [])) checked @endif>
                            <label class="form-check-label" for="deteksi_sakit_kepala">Apakah Anda sering
                                menderita
                                sakit kepala?</label>

                        </div>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" name="kesehatan_jiwa[]"
                                value="deteksi_nafsu_makan" id="deteksi_nafsu_makan"
                                @if (in_array('deteksi_nafsu_makan', $layakHamil->kesehatan_jiwa ?? [])) checked @endif>
                            <label class="form-check-label" for="deteksi_nafsu_makan">Apakah Anda
                                kehilangan
                                nafsu makan?</label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input"
                                @if (in_array('deteksi_tidur_lelap', $layakHamil->kesehatan_jiwa ?? [])) checked @endif name="kesehatan_jiwa[]"
                                value="deteksi_tidur_lelap" id="deteksi_tidur_lelap">
                            <label class="form-check-label" for="deteksi_tidur_lelap">Apakah tidur Anda
                                tidak
                                lelap?</label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input"
                                @if (in_array('deteksi_takut', $layakHamil->kesehatan_jiwa ?? [])) checked @endif name="kesehatan_jiwa[]"
                                value="deteksi_takut" id="deteksi_takut">
                            <label class="form-check-label" for="deteksi_takut">Apakah Anda mudah
                                menjadi takut?</label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input"
                                @if (in_array('deteksi_cemas', $layakHamil->kesehatan_jiwa ?? [])) checked @endif name="kesehatan_jiwa[]"
                                value="deteksi_cemas" id="deteksi_cemas">
                            <label class="form-check-label" for="deteksi_cemas">Apakah Anda merasa
                                cemas, tegang dan khawatir?</label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input"
                                @if (in_array('deteksi_tangan_gemetar', $layakHamil->kesehatan_jiwa ?? [])) checked @endif name="kesehatan_jiwa[]"
                                value="deteksi_tangan_gemetar" id="deteksi_tangan_gemetar">
                            <label class="form-check-label" for="deteksi_tangan_gemetar">Apakah tangan
                                Anda
                                gemetar?</label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input"
                                @if (in_array('deteksi_gangguan_pencernaan', $layakHamil->kesehatan_jiwa ?? [])) checked @endif name="kesehatan_jiwa[]"
                                value="deteksi_gangguan_pencernaan" id="deteksi_gangguan_pencernaan">
                            <label class="form-check-label" for="deteksi_gangguan_pencernaan">Apakah Anda
                                mengalami gangguan pencernaan?</label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input"
                                @if (in_array('deteksi_berfikir_jernih', $layakHamil->kesehatan_jiwa ?? [])) checked @endif name="kesehatan_jiwa[]"
                                value="deteksi_berfikir_jernih" id="deteksi_berfikir_jernih">
                            <label class="form-check-label" for="deteksi_berfikir_jernih">Apakah Anda
                                merasa
                                sulit berfikir jernih?</label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input"
                                @if (in_array('deteksi_bahagia', $layakHamil->kesehatan_jiwa ?? [])) checked @endif name="kesehatan_jiwa[]"
                                value="deteksi_bahagia" id="deteksi_bahagia">
                            <label class="form-check-label" for="deteksi_bahagia">Apakah Anda merasa tidak
                                bahagia?</label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input"
                                @if (in_array('deteksi_menangis', $layakHamil->kesehatan_jiwa ?? [])) checked @endif name="kesehatan_jiwa[]"
                                value="deteksi_menangis" id="deteksi_menangis">
                            <label class="form-check-label" for="deteksi_menangis">Apakah Anda sering
                                menangis?</label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input"
                                @if (in_array('deteksi_aktivitas', $layakHamil->kesehatan_jiwa ?? [])) checked @endif name="kesehatan_jiwa[]"
                                value="deteksi_aktivitas" id="deteksi_aktivitas">
                            <label class="form-check-label" for="deteksi_aktivitas">Apakah Anda merasa
                                sulit
                                untuk menikmati aktivitas sehari-hari?</label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input"
                                @if (in_array('deteksi_sulit_keputusan', $layakHamil->kesehatan_jiwa ?? [])) checked @endif name="kesehatan_jiwa[]"
                                value="deteksi_sulit_keputusan" id="deteksi_sulit_keputusan">
                            <label class="form-check-label" for="deteksi_sulit_keputusan">Apakah Anda
                                mengalami
                                kesulitan untuk mengambil keputusan?</label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input"
                                @if (in_array('deteksi_terbengkalai', $layakHamil->kesehatan_jiwa ?? [])) checked @endif name="kesehatan_jiwa[]"
                                value="deteksi_terbengkalai" id="deteksi_terbengkalai">
                            <label class="form-check-label" for="deteksi_terbengkalai">Apakah aktivitas
                                sehari-hari Anda terbengkalai?</label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input"
                                @if (in_array('deteksi_kehidupan', $layakHamil->kesehatan_jiwa ?? [])) checked @endif name="kesehatan_jiwa[]"
                                value="deteksi_kehidupan" id="deteksi_kehidupan">
                            <label class="form-check-label" for="deteksi_kehidupan">Apakah Anda merasa
                                tidak
                                mampu berperan dalam kehidupan ini?</label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input"
                                @if (in_array('deteksi_kehilangan', $layakHamil->kesehatan_jiwa ?? [])) checked @endif name="kesehatan_jiwa[]"
                                value="deteksi_kehilangan" id="deteksi_kehilangan">
                            <label class="form-check-label" for="deteksi_kehilangan">Apakah Anda
                                kehilangan
                                minat terhadap banyak hal?</label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input"
                                @if (in_array('deteksi_tidak_berharga', $layakHamil->kesehatan_jiwa ?? [])) checked @endif name="kesehatan_jiwa[]"
                                value="deteksi_tidak_berharga" id="deteksi_tidak_berharga">
                            <label class="form-check-label" for="deteksi_tidak_berharga">Apakah Anda
                                merasa
                                tidak
                                berharga?</label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input"
                                @if (in_array('deteksi_pikiran', $layakHamil->kesehatan_jiwa ?? [])) checked @endif name="kesehatan_jiwa[]"
                                value="deteksi_pikiran" id="deteksi_pikiran">
                            <label class="form-check-label" for="deteksi_pikiran">Apakah Anda mempunyai
                                pikiran untuk mengakhiri hidup Anda?</label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input"
                                @if (in_array('deteksi_lelah_waktu', $layakHamil->kesehatan_jiwa ?? [])) checked @endif name="kesehatan_jiwa[]"
                                value="deteksi_lelah_waktu" id="deteksi_lelah_waktu">
                            <label class="form-check-label" for="deteksi_lelah_waktu">Apakah Anda merasa
                                lelah
                                sepanjang waktu?</label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input"
                                @if (in_array('deteksi_perut', $layakHamil->kesehatan_jiwa ?? [])) checked @endif name="kesehatan_jiwa[]"
                                value="deteksi_perut" id="deteksi_perut">
                            <label class="form-check-label" for="deteksi_perut">Apakah Anda merasa tidak
                                enak diperut?</label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input"
                                @if (in_array('deteksi_mudah_lelah', $layakHamil->kesehatan_jiwa ?? [])) checked @endif name="kesehatan_jiwa[]"
                                value="deteksi_mudah_lelah" id="deteksi_mudah_lelah">
                            <label class="form-check-label" for="deteksi_mudah_lelah">Apakah Anda mudah
                                lelah
                                ?</label>
                        </div>
                        <div class="form-group">
                            <div class="col-md-12">
                                <label for="kesimpulan" style="color: rgb(19, 11, 241);">Kesimpulan</label>
                                <textarea class="form-control" id="kesimpulan" name="kesimpulan" placeholder="Kesimpulan">{{ old('kesimpulan', $layakHamil->kesimpulan ?? '') }}</textarea>
                            </div>
                        </div>

                    </div>


                </div>
            </div>
        </div>
        <div class="text-right mt-4">
            {{-- @if (isset($layakHamil))
                <a href="{{ route('layakHamil.admin') }}" type="button" class="btn btn-secondary mr-2"
                    style="font-size: 20px">Kembali</a>
            @else
                <a href="{{ route('skrining.ilp') }}" type="button" class="btn btn-secondary mr-2"
                    style="font-size: 20px">Kembali</a>
            @endif --}}
            <button type="submit" class="btn btn-primary" style="font-size: 20px">Kirim</button>
        </div>
    </form>
@endsection
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

            // Isi input dengan data yang diambil
            $('#no_hp').val(no_hp);
            $('#nik').val(nik);
            $('#tanggal_lahir').val(dob);
            $('#alamat').val(alamat);
        });
        $('#pasien').trigger('change');
    });
</script>
>>>>>>> 9df8fede466960d27744a11e4cb830e2a9437611
