@extends('layouts.skrining.master')
@section('title', 'Skrining TBC')
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

    <form action="{{ isset($tbc) ? route('tbc.update', $tbc->id) : route('tbc.store') }}" method="POST">
        @csrf
        @if (isset($tbc))
            @method('PUT')
        @endif
        @if ($routeName === 'tbc.view')
            <input type="hidden" name="klaster" value="2">
            <input type="hidden" name="poli" value="kia">
        @elseif($routeName === 'tbc.mtbs.view')
            <input type="hidden" name="klaster" value="2">
            <input type="hidden" name="poli" value="mtbs">
        @elseif($routeName === 'tbc.lansia.view')
            <input type="hidden" name="klaster" value="3">
            <input type="hidden" name="poli" value="lansia">
        @endif
        <div class="form-section">
            <h3>Identitas</h3>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>1. Pasien</label>
                        <select class="form-control form-select select2" id="pasien" name="pasien">
                            <option value="" disabled {{ old('pasien') == '' ? 'selected' : '' }}>Pilih</option>
                            @if ($pasien)
                                <option value="{{ $pasien->id }}" selected>{{ $pasien->name }} - {{ $pasien->nik }}
                                </option>
                            @endif
                        </select>
                        @error('pasien')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Tempat</label>
                        <input type="text" class="form-control" name="tempat_skrining"
                            placeholder="Masukkan tempat skrining" value="{{ $tbc->tempat_skrining ?? '' }}">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Alamat KTP</label>
                        <input type="text" class="form-control" name="alamat_ktp" placeholder="Masukkan alamat KTP"
                            id="alamat" value="{{ $pasien->address ?? '' }}" readonly>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Alamat Domisili</label>
                        <input type="text" class="form-control" name="alamat_domisili" id="alamatd"
                            placeholder="Masukkan alamat domisili" value="{{ $pasien->address ?? '' }}" readonly>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Pekerjaan</label>
                        <input type="text" class="form-control" name="pekerjaan" placeholder="Masukkan pekerjaan"
                            id="pekerjaan" value="{{ $pasien->occupations->name ?? '' }}" readonly>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Tanggal Lahir</label>
                        <input type="date" class="form-control" name="tanggal_lahir" id="tanggal_lahir"
                            value="{{ $pasien->dob ?? '' }}" readonly>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Usia</label>
                        <input type="number" class="form-control" name="usia" value="{{ $tbc->usia ?? '' }}"
                            id="usiaInput" readonly>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Jenis Kelamin</label>
                        <div class="d-flex">
                            <div class="form-check mr-3">
                                <input type="radio" class="form-check-input" name="jenis_kelamin" value="laki-laki"
                                    id="jk_laki" id="laki-laki" {{ $pasien->gender == '2' ? 'checked' : '' }}>
                                <label class="form-check-label" for="laki-laki">Laki-laki</label>
                            </div>
                            <div class="form-check">
                                <input type="radio" class="form-check-input" name="jenis_kelamin" value="perempuan"
                                    id="jk_perempuan" id="perempuan" {{ $pasien->gender == '1' ? 'checked' : '' }}>
                                <label class="form-check-label" for="perempuan">Perempuan</label>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="col-md-6">
                    <div class="form-group">
                        <label>No HP</label>
                        <input type="number" class="form-control" name="no_hp" placeholder="Masukkan no HP"
                            id="no_hp" value="{{ $pasien->phone ?? '' }}" readonly>
                    </div>
                </div>
            </div>

        </div>
        <div class="form-section mt-4">
            <h3>Pemeriksaan Berat Badan dan Tinggi Badan</h3>
            <div class="col-md-12 mb-3">
                <div class="form-group">
                    <label style="width: 150px;">1. Tinggi Badan</label>
                    <input type="text" class="form-control" name="tinggi_badan" placeholder="Masukkan tinggi badan"
                        style="width: 100px; display: inline-block;" value="{{ isset($tbc) ? $tbc->tinggi_badan : '' }}">
                    <span style="margin-left: 5px;">cm</span>
                </div>
            </div>

            <div class="col-md-12 mb-3">
                <div class="form-group">
                    <label style="width: 150px;">2. Berat Badan</label>
                    <input type="text" class="form-control" name="berat_badan" placeholder="Masukkan berat badan"
                        style="width: 100px; display: inline-block;" value="{{ isset($tbc) ? $tbc->berat_badan : '' }}">
                    <span style="margin-left: 5px;">kg</span>
                </div>
            </div>

            <div class="col-md-12 mb-3" style="display: none" id="imtSection">
                <div class="form-group">
                    <label style="width: 150px;">3. IMT</label>
                    <input type="text" class="form-control" name="imt" placeholder="Masukkan IMT" id="imtInput"
                        style="width: 100px; display: inline-block;" value="{{ isset($tbc) ? $tbc->imt : '' }}">
                    <span style="margin-left: 5px;">kg/m^2</span>
                </div>
            </div>
            {{-- <h style="color:red"><strong>Agar hasil status gizi muncul , isi terlebih dahulu usia</strong></h> --}}
            <div class="form-group">
                <label>Hasil Status Gizi:</label>
                <div class="col-md-6">
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" name="status_gizi" value=1 id="buruk"
                            {{ isset($tbc) && $tbc->status_gizi == 1 ? 'checked' : '' }}>
                        <label class="form-check-label" id="labelBuruk" for="buruk"></label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" name="status_gizi" value=2 id="kurang"
                            {{ isset($tbc) && $tbc->status_gizi == 2 ? 'checked' : '' }}>
                        <label class="form-check-label" id="labelKurang" for="kurang"></label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" name="status_gizi" value=3 id="baik"
                            {{ isset($tbc) && $tbc->status_gizi == 3 ? 'checked' : '' }}>
                        <label class="form-check-label" id="labelBaik" for="baik"></label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" name="status_gizi" value=4 id="lebih"
                            {{ isset($tbc) && $tbc->status_gizi == 4 ? 'checked' : '' }}>
                        <label class="form-check-label" id="labelLebih" for="lebih"></label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" name="status_gizi" value=5 id="obesitas"
                            {{ isset($tbc) && $tbc->status_gizi == 5 ? 'checked' : '' }}>
                        <label class="form-check-label" id="labelObesitas" for="obesitas"></label>
                    </div>
                </div>

                <label style="margin-top: 15px;">Standar Hasil Status Gizi:</label>
                <label id="standarGiziLabel" style="margin-top: 15px;">Standar Hasil Status Gizi:</label>
                <ul id="standarGiziList">

                </ul>
            </div>
        </div>

        <div class="form-section">
            <h3>Pemeriksaan Riwayat Kontak TBC</h3>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label>1. Apakah ada kontak dengan pasien TBC?</label>
                        <div class="d-flex">
                            <div class="form-check mr-3">
                                <input type="radio" class="form-check-input" name="kontak_dengan_pasien"
                                    value="1" id="ya"
                                    {{ isset($tbc) && $tbc->kontak_dengan_pasien == 1 ? 'checked' : (old('kontak_dengan_pasien') == 1 ? 'checked' : '') }}
                                    onclick="toggleKontakJenis(true)">
                                <label class="form-check-label" for="ya">Ya</label>
                            </div>
                            <div class="form-check">
                                <input type="radio" class="form-check-input" name="kontak_dengan_pasien"
                                    value="2" id="tidak"
                                    {{ isset($tbc) && $tbc->kontak_dengan_pasien == 2 ? 'checked' : (old('kontak_dengan_pasien') == 2 ? 'checked' : '') }}
                                    onclick="toggleKontakJenis(false)">
                                <label class="form-check-label" for="tidak">Tidak</label>
                            </div>
                            <div class="form-check ml-3">
                                <input type="radio" class="form-check-input" name="kontak_dengan_pasien"
                                    value="3" id="tidak_tahu"
                                    {{ isset($tbc) && $tbc->kontak_dengan_pasien == 3 ? 'checked' : (old('kontak_dengan_pasien') == 3 ? 'checked' : '') }}
                                    onclick="toggleKontakJenis(false)">
                                <label class="form-check-label" for="tidak_tahu">Tidak diketahui</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12" id="jenisKontakSection" style="display: none; margin-top: 15px;">
                    <div class="form-group">
                        <label>2. Pilih jenis kontak TBC</label>
                        <div class="d-flex">
                            <div class="form-check mr-3">
                                <input type="radio" class="form-check-input" name="kontak_tbc" value="1"
                                    {{ isset($tbc) && $tbc->kontak_tbc == 1 ? 'checked' : (old('kontak_tbc') == 1 ? 'checked' : '') }}>
                                <label class="form-check-label">Kontak serumah</label>
                            </div>
                            <div class="form-check">
                                <input type="radio" class="form-check-input" name="kontak_tbc" value="2"
                                    {{ isset($tbc) && $tbc->kontak_tbc == 2 ? 'checked' : (old('kontak_tbc') == 2 ? 'checked' : '') }}>
                                <label class="form-check-label">Kontak erat</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>3. Sebutkan nama kasus indeks TBC</label>
                        <input type="text" class="form-control" name="kasus_tbc"
                            value="{{ isset($tbc) ? $tbc->kasus_tbc : old('kasus_tbc') }}"
                            placeholder="Masukkan kasus indeks TBC">
                    </div>
                    <div class="form-group">
                        <label>4. Pilih jenis TBC yang diderita oleh kasus indeks</label>
                        <div class="d-flex">
                            <div class="form-check mr-3">
                                <input type="radio" class="form-check-input" name="jenis_tbc" value="1"
                                    {{ isset($tbc) && $tbc->jenis_tbc == 1 ? 'checked' : (old('jenis_tbc') == 1 ? 'checked' : '') }}>
                                <label class="form-check-label">TBC paru bakteriologis</label>
                            </div>
                            <div class="form-check">
                                <input type="radio" class="form-check-input" name="jenis_tbc" value="2"
                                    {{ isset($tbc) && $tbc->jenis_tbc == 2 ? 'checked' : (old('jenis_tbc') == 2 ? 'checked' : '') }}>
                                <label class="form-check-label">TBC klinis</label>
                            </div>
                            <div class="form-check">
                                <input type="radio" class="form-check-input" name="jenis_tbc" value="3"
                                    {{ isset($tbc) && $tbc->jenis_tbc == 3 ? 'checked' : (old('jenis_tbc') == 3 ? 'checked' : '') }}>
                                <label class="form-check-label">TBC Ekstra paru</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-section">

            <h3>Faktor Resiko</h3>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>1. Pernah terdiagnosa/ berobat TBC?</label>
                        <div class="d-flex">
                            <div class="form-check mr-3">
                                <input type="radio" class="form-check-input" name="pernah_berobat_tbc" value="1"
                                    id="ya"
                                    {{ isset($tbc->pernah_berobat_tbc) && $tbc->pernah_berobat_tbc == 1 ? 'checked' : '' }}
                                    onclick="toggleKapan(true)">
                                <label class="form-check-label" for="ya">Ya</label>
                            </div>
                            <div class="form-check">
                                <input type="radio" class="form-check-input" name="pernah_berobat_tbc" value="0"
                                    id="tidak"
                                    {{ isset($tbc->pernah_berobat_tbc) && $tbc->pernah_berobat_tbc == 0 ? 'checked' : '' }}
                                    onclick="toggleKapan(false)">
                                <label class="form-check-label" for="tidak">Tidak</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group" id="kapanSection"
                        style="display: {{ isset($tbc->pernah_berobat_tbc) && $tbc->pernah_berobat_tbc == 1 ? 'block' : 'none' }}; margin-top: 15px;">
                        <label>Kapan?</label>
                        <input type="text" class="form-control" name="kontak_dengan_pasien"
                            placeholder="Masukkan waktu diagnosa/berobat TBC"
                            value="{{ $tbc->kontak_dengan_pasien ?? '' }}">
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label>2. Pernah terdiagnosa/ berobat TBC tidak tuntas?</label>
                        <div class="d-flex">
                            <div class="form-check mr-3">
                                <input type="radio" class="form-check-input" name="pernah_berobat_tbc_tdk_tuntas"
                                    value="1" id="ya"
                                    {{ isset($tbc->pernah_berobat_tbc_tdk_tuntas) && $tbc->pernah_berobat_tbc_tdk_tuntas == 1 ? 'checked' : '' }}>
                                <label class="form-check-label" for="ya">Ya</label>
                            </div>
                            <div class="form-check">
                                <input type="radio" class="form-check-input" name="pernah_berobat_tbc_tdk_tuntas"
                                    value="0" id="tidak"
                                    {{ isset($tbc->pernah_berobat_tbc_tdk_tuntas) && $tbc->pernah_berobat_tbc_tdk_tuntas == 0 ? 'checked' : '' }}>
                                <label class="form-check-label" for="tidak">Tidak</label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Repeat the pattern for the rest of your questions -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label>3. Kekurangan gizi?</label>
                        <div class="d-flex">
                            <div class="form-check mr-3">
                                <input type="radio" class="form-check-input" name="kurang_gizi" value="1"
                                    id="ya"
                                    {{ isset($tbc->kurang_gizi) && $tbc->kurang_gizi == 1 ? 'checked' : '' }}>
                                <label class="form-check-label" for="ya">Ya</label>
                            </div>
                            <div class="form-check">
                                <input type="radio" class="form-check-input" name="kurang_gizi" value="0"
                                    id="tidak"
                                    {{ isset($tbc->kurang_gizi) && $tbc->kurang_gizi == 0 ? 'checked' : '' }}>
                                <label class="form-check-label" for="tidak">Tidak</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>4. Merokok?</label>
                        <div class="d-flex">
                            <div class="form-check mr-3">
                                <input type="radio" class="form-check-input" name="merokok" value="1"
                                    id="ya" {{ isset($tbc->merokok) && $tbc->merokok == 1 ? 'checked' : '' }}>
                                <label class="form-check-label" for="ya">Ya</label>
                            </div>
                            <div class="form-check">
                                <input type="radio" class="form-check-input" name="merokok" value="0"
                                    id="tidak" {{ isset($tbc->merokok) && $tbc->merokok == 0 ? 'checked' : '' }}>
                                <label class="form-check-label" for="tidak">Tidak</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label>5. Perokok pasif?</label>
                        <div class="d-flex">
                            <div class="form-check mr-3">
                                <input type="radio" class="form-check-input" name="perokok_pasif" value="1"
                                    id="ya"
                                    {{ isset($tbc->perokok_pasif) && $tbc->perokok_pasif == 1 ? 'checked' : '' }}>
                                <label class="form-check-label" for="ya">Ya</label>
                            </div>
                            <div class="form-check">
                                <input type="radio" class="form-check-input" name="perokok_pasif" value="0"
                                    id="tidak"
                                    {{ isset($tbc->perokok_pasif) && $tbc->perokok_pasif == 0 ? 'checked' : '' }}>
                                <label class="form-check-label" for="tidak">Tidak</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label>6. Riwayat DM/kencing manis?</label>
                        <div class="d-flex">
                            <div class="form-check mr-3">
                                <input type="radio" class="form-check-input" name="kencing_manis" value="1"
                                    id="ya"
                                    {{ isset($tbc->kencing_manis) && $tbc->kencing_manis == 1 ? 'checked' : '' }}>
                                <label class="form-check-label" for="ya">Ya</label>
                            </div>
                            <div class="form-check">
                                <input type="radio" class="form-check-input" name="kencing_manis" value="2"
                                    id="tidak"
                                    {{ isset($tbc->kencing_manis) && $tbc->kencing_manis == 2 ? 'checked' : '' }}>
                                <label class="form-check-label" for="tidak">Tidak</label>
                            </div>
                            <div class="form-check ml-3">
                                <input type="radio" class="form-check-input" name="kencing_manis" value="3"
                                    id="tidak_diketahui"
                                    {{ isset($tbc->kencing_manis) && $tbc->kencing_manis == 3 ? 'checked' : '' }}>
                                <label class="form-check-label" for="tidak_diketahui">Tidak diketahui</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label>7. ODIV?</label>
                        <div class="d-flex">
                            <div class="form-check mr-3">
                                <input type="radio" class="form-check-input" name="odhiv" value="1"
                                    id="ya" {{ isset($tbc->odhiv) && $tbc->odhiv == 1 ? 'checked' : '' }}>
                                <label class="form-check-label" for="ya">Ya</label>
                            </div>
                            <div class="form-check">
                                <input type="radio" class="form-check-input" name="odhiv" value="2"
                                    id="tidak" {{ isset($tbc->odhiv) && $tbc->odhiv == 2 ? 'checked' : '' }}>
                                <label class="form-check-label" for="tidak">Tidak</label>
                            </div>
                            <div class="form-check ml-3">
                                <input type="radio" class="form-check-input" name="odhiv" value="3"
                                    id="tidak_diketahui" {{ isset($tbc->odhiv) && $tbc->odhiv == 3 ? 'checked' : '' }}>
                                <label class="form-check-label" for="tidak_diketahui">Tidak diketahui</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label>8. Lansia > 65 tahun?</label>
                        <div class="d-flex">
                            <div class="form-check mr-3">
                                <input type="radio" class="form-check-input" name="lansia" value="1"
                                    id="ya" {{ isset($tbc->lansia) && $tbc->lansia == 1 ? 'checked' : '' }}>
                                <label class="form-check-label" for="ya">Ya</label>
                            </div>
                            <div class="form-check">
                                <input type="radio" class="form-check-input" name="lansia" value="0"
                                    id="tidak" {{ isset($tbc->lansia) && $tbc->lansia == 0 ? 'checked' : '' }}>
                                <label class="form-check-label" for="tidak">Tidak</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label>9. Ibu hamil?</label>
                        <div class="d-flex">
                            <div class="form-check mr-3">
                                <input type="radio" class="form-check-input" name="ibu_hamil" value="1"
                                    id="ya" {{ isset($tbc->ibu_hamil) && $tbc->ibu_hamil == 1 ? 'checked' : '' }}>
                                <label class="form-check-label" for="ya">Ya</label>
                            </div>
                            <div class="form-check">
                                <input type="radio" class="form-check-input" name="ibu_hamil" value="0"
                                    id="tidak" {{ isset($tbc->ibu_hamil) && $tbc->ibu_hamil == 0 ? 'checked' : '' }}>
                                <label class="form-check-label" for="tidak">Tidak</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label>10. Tinggal di wilayah padat kumuh miskin?</label>
                        <div class="d-flex">
                            <div class="form-check mr-3">
                                <input type="radio" class="form-check-input" name="tinggal_wilayah_kumuh"
                                    value="1" id="ya"
                                    {{ isset($tbc->tinggal_wilayah_kumuh) && $tbc->tinggal_wilayah_kumuh == 1 ? 'checked' : '' }}>
                                <label class="form-check-label" for="ya">Ya</label>
                            </div>
                            <div class="form-check">
                                <input type="radio" class="form-check-input" name="tinggal_wilayah_kumuh"
                                    value="0" id="tidak"
                                    {{ isset($tbc->tinggal_wilayah_kumuh) && $tbc->tinggal_wilayah_kumuh == 0 ? 'checked' : '' }}>
                                <label class="form-check-label" for="tidak">Tidak</label>
                            </div>
                        </div>
                    </div>
                </div>

            </div>


        </div>
        <div class="form-section">

            <h3>Skrining Gejala</h3>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label id="batukLabel">1. Batuk >= 2 minggu</label>
                        <div class="d-flex">
                            <div class="form-check mr-3">
                                <input type="radio" class="form-check-input" name="batuk" value="1"
                                    id="batuk_ya" {{ isset($tbc->batuk) && $tbc->batuk == 1 ? 'checked' : '' }}
                                    onclick="toggleBatuk(true)">
                                <label class="form-check-label" for="batuk_ya">Ya</label>
                            </div>
                            <div class="form-check">
                                <input type="radio" class="form-check-input" name="batuk" value="0"
                                    id="batuk_tidak" {{ isset($tbc->batuk) && $tbc->batuk == 0 ? 'checked' : '' }}
                                    onclick="toggleBatuk(false)">
                                <label class="form-check-label" for="batuk_tidak">Tidak</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group" id="batukSection"
                        style="display: {{ isset($tbc->batuk) && $tbc->batuk == 1 ? 'block' : 'none' }}; margin-top: 15px;">
                        <label>Durasi?</label>
                        <input type="text" class="form-control" name="durasi" placeholder="Durasi batuk"
                            value="{{ old('durasi', isset($tbc->durasi) ? $tbc->durasi_batuk : '') }}">
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label>2. Batuk darah?</label>
                        <div class="d-flex">
                            <div class="form-check mr-3">
                                <input type="radio" class="form-check-input" name="batuk_darah" value="1"
                                    id="batuk_darah_ya"
                                    {{ isset($tbc->batuk_darah) && $tbc->batuk_darah == 1 ? 'checked' : '' }}>
                                <label class="form-check-label" for="batuk_darah_ya">Ya</label>
                            </div>
                            <div class="form-check">
                                <input type="radio" class="form-check-input" name="batuk_darah" value="0"
                                    id="batuk_darah_tidak"
                                    {{ isset($tbc->batuk_darah) && $tbc->batuk_darah == 0 ? 'checked' : '' }}>
                                <label class="form-check-label" for="batuk_darah_tidak">Tidak</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label id="bbLabel">3. BB turun tanpa penyebab jelas/BB tidak naik dalam 2 bulan sebelumnya/nafsu
                            makan
                            turun?</label>
                        <div class="d-flex">
                            <div class="form-check mr-3">
                                <input type="radio" class="form-check-input" name="bb_turun" value="1"
                                    id="bb_turun_ya" {{ isset($tbc->bb_turun) && $tbc->bb_turun == 1 ? 'checked' : '' }}>
                                <label class="form-check-label" for="bb_turun_ya">Ya</label>
                            </div>
                            <div class="form-check">
                                <input type="radio" class="form-check-input" name="bb_turun" value="0"
                                    id="bb_turun_tidak"
                                    {{ isset($tbc->bb_turun) && $tbc->bb_turun == 0 ? 'checked' : '' }}>
                                <label class="form-check-label" for="bb_turun_tidak">Tidak</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label id="demamLabel">4. Demam hilang timbul tanpa sebab yang jelas ≥ 2 minggu?</label>
                        <div class="d-flex">
                            <div class="form-check mr-3">
                                <input type="radio" class="form-check-input" name="demam" value="1"
                                    id="demam_ya" {{ isset($tbc->demam) && $tbc->demam == 1 ? 'checked' : '' }}>
                                <label class="form-check-label" for="demam_ya">Ya</label>
                            </div>
                            <div class="form-check">
                                <input type="radio" class="form-check-input" name="demam" value="0"
                                    id="demam_tidak" {{ isset($tbc->demam) && $tbc->demam == 0 ? 'checked' : '' }}>
                                <label class="form-check-label" for="demam_tidak">Tidak</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label id="lesuLabel">5. Lesu atau malaise, anak kurang aktif bermain?</label>
                        <div class="d-flex">
                            <div class="form-check mr-3">
                                <input type="radio" class="form-check-input" name="lesu" value="1"
                                    id="lesu_ya" {{ isset($tbc->lesu) && $tbc->lesu == 1 ? 'checked' : '' }}>
                                <label class="form-check-label" for="lesu_ya">Ya</label>
                            </div>
                            <div class="form-check">
                                <input type="radio" class="form-check-input" name="lesu" value="0"
                                    id="lesu_tidak" {{ isset($tbc->lesu) && $tbc->lesu == 0 ? 'checked' : '' }}>
                                <label class="form-check-label" for="lesu_tidak">Tidak</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label>6. Pembesaran kelenjar getah bening?</label>
                        <div class="d-flex">
                            <div class="form-check mr-3">
                                <input type="radio" class="form-check-input" name="pembesaran_kelenjar" value="1"
                                    id="pembesaran_kelenjar_ya"
                                    {{ isset($tbc->pembesaran_kelenjar) && $tbc->pembesaran_kelenjar == 1 ? 'checked' : '' }}>
                                <label class="form-check-label" for="pembesaran_kelenjar_ya">Ya</label>
                            </div>
                            <div class="form-check">
                                <input type="radio" class="form-check-input" name="pembesaran_kelenjar" value="2"
                                    id="pembesaran_kelenjar_tidak"
                                    {{ isset($tbc->pembesaran_kelenjar) && $tbc->pembesaran_kelenjar == 2 ? 'checked' : '' }}>
                                <label class="form-check-label" for="pembesaran_kelenjar_tidak">Tidak</label>
                            </div>
                            <div class="form-check ml-3">
                                <input type="radio" class="form-check-input" name="pembesaran_kelenjar" value="3"
                                    id="pembesaran_kelenjar_tidak_diketahui"
                                    {{ isset($tbc->pembesaran_kelenjar) && $tbc->pembesaran_kelenjar == 3 ? 'checked' : '' }}>
                                <label class="form-check-label" for="pembesaran_kelenjar_tidak_diketahui">Tidak
                                    diketahui</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>



        </div>
        <div class="form-section">
            <h3>Skrining Rontgen Toraks</h3>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>1. Apakah dilakukan skrining rontgen toraks?</label>
                        <div class="d-flex">
                            <div class="form-check mr-3">
                                <input type="radio" class="form-check-input" name="sudah_rontgen" value="1"
                                    id="ya"
                                    {{ isset($tbc->sudah_rontgen) && $tbc->sudah_rontgen == 1 ? 'checked' : '' }}
                                    onclick="toggleRontgen(true)">
                                <label class="form-check-label" for="ya">Ya</label>
                            </div>
                            <div class="form-check">
                                <input type="radio" class="form-check-input" name="sudah_rontgen" value="0"
                                    id="tidak"
                                    {{ isset($tbc->sudah_rontgen) && $tbc->sudah_rontgen == 0 ? 'checked' : '' }}
                                    onclick="toggleRontgen(false)">
                                <label class="form-check-label" for="tidak">Tidak</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group" id="rontgenSection" style="display: none; margin-top: 15px;">
                        <label>2. Hasil Skrining Rontgen Toraks apa?</label>
                        <div class="d-flex">
                            <div class="form-check mr-3">
                                <input type="radio" class="form-check-input" name="hasil_rontgen" value="1"
                                    id="normal"
                                    {{ isset($tbc->hasil_rontgen) && $tbc->hasil_rontgen == 1 ? 'checked' : '' }}>
                                <label class="form-check-label" for="normal">Normal</label>
                            </div>
                            <div class="form-check">
                                <input type="radio" class="form-check-input" name="hasil_rontgen" value="2"
                                    id="abnormal_tbc"
                                    {{ isset($tbc->hasil_rontgen) && $tbc->hasil_rontgen == 2 ? 'checked' : '' }}>
                                <label class="form-check-label" for="abnormal">Abnormalitas mengarah TBC</label>
                            </div>
                            <div class="form-check">
                                <input type="radio" class="form-check-input" name="hasil_rontgen" value="3"
                                    id="abnormal_tdk_tb"
                                    {{ isset($tbc->hasil_rontgen) && $tbc->hasil_rontgen == 3 ? 'checked' : '' }}>
                                <label class="form-check-label" for="abnormal_tdk_tb">Abnormalitas tidak mengarah
                                    TBC</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-section">
            <h3>Terduga TBC</h3>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <div class="d-flex">
                            <div class="form-check mr-3">
                                <input type="radio" class="form-check-input" name="terduga_tbc" value="1"
                                    id="ya"
                                    {{ isset($tbc->terduga_tbc) && $tbc->terduga_tbc == 1 ? 'checked' : '' }}>
                                <label class="form-check-label" for="ya">Ya</label>
                            </div>
                            <div class="form-check">
                                <input type="radio" class="form-check-input" name="terduga_tbc" value="0"
                                    id="tidak"
                                    {{ isset($tbc->terduga_tbc) && $tbc->terduga_tbc == 0 ? 'checked' : '' }}>
                                <label class="form-check-label" for="tidak">Tidak</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-section">
            <h3>Pemeriksaan TBC Laten</h3>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <div class="d-flex">
                            <div class="form-check mr-3">
                                <input type="radio" class="form-check-input" name="periksa_tbc_laten" value="1"
                                    id="ya"
                                    {{ isset($tbc->periksa_tbc_laten) && $tbc->periksa_tbc_laten == 1 ? 'checked' : '' }}>
                                <label class="form-check-label" for="ya">Ya</label>
                            </div>
                            <div class="form-check">
                                <input type="radio" class="form-check-input" name="periksa_tbc_laten" value="0"
                                    id="tidak"
                                    {{ isset($tbc->periksa_tbc_laten) && $tbc->periksa_tbc_laten == 0 ? 'checked' : '' }}>
                                <label class="form-check-label" for="tidak">Tidak</label>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div class="form-group">
            <div class="col-md-12">
                <label for="kesimpulan" style="color: rgb(19, 11, 241);">Kesimpulan</label>
                <textarea class="form-control" id="kesimpulan" name="kesimpulan" placeholder="Kesimpulan">{{ old('kesimpulan', $tbc->kesimpulan ?? '') }}</textarea>
            </div>
        </div>
        <div class="form-section mt-4">
            <h3>Keterangan</h3>
            <p>
                Dikatakan <strong>terduga TBC</strong>, jika terdapat salah satu atau lebih gejala TBC dan atau memiliki
                hasil skrining rontgen toraks abnormalitas mengarah TBC.
            </p>
            <p>
                Dikatakan <strong>bukan terduga TBC</strong>, jika tidak ada gejala TBC dan hasil skrining rontgen toraks
                menunjukkan normal/abnormalitas tidak mengarah ke TBC.
            </p>
            <p>
                Dikatakan <strong>Pemeriksaan TBC Laten "Ya"</strong>, jika:
            <ul>
                <li>Jika usia < 5 tahun kontak dengan pasien TBC dan bukan terduga TBC.</li>
                <li>Jika ODHIV dan bukan terduga TBC.</li>
                <li>Jika usia > 5 tahun kontak dengan pasien TBC dan bukan terduga TBC.</li>
            </ul>
            </p>
            <p>
                Dikatakan <strong>Pemeriksaan TBC Laten "Tidak"</strong>, jika: dikatakan sebagai terduga TBC.
            </p>
        </div>


        <div class="text-right mt-4">
            {{-- @if (isset($tbc))
                <a href="{{ route('tbc.admin') }}" type="button" class="btn btn-secondary mr-2"
                    style="font-size: 20px">Kembali</a>
            @else
                <a href="{{ route('skrining.ilp') }}" type="button" class="btn btn-secondary mr-2"
                    style="font-size: 20px">Kembali</a>
            @endif --}}
            <button type="submit" class="btn btn-primary" style="font-size: 20px">Kirim</button>
        </div>
    </form>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $(document).ready(function() {
            // Inisialisasi Select2
            $('.select2').select2({
                placeholder: "Pilih pasien",
                allowClear: true
            });


        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Event Listener untuk Tanggal Lahir
            const tanggalLahirInput = document.getElementById('tanggal_lahir');
            const usiaInput = document.getElementById('usiaInput');

            if (tanggalLahirInput && usiaInput) {
                // Tambahkan event listener untuk menghitung usia saat tanggal lahir berubah
                tanggalLahirInput.addEventListener('change', () => {
                    const tanggalLahir = new Date(tanggalLahirInput.value);
                    const hariIni = new Date();
                    let usia = hariIni.getFullYear() - tanggalLahir.getFullYear();
                    const bulan = hariIni.getMonth() - tanggalLahir.getMonth();

                    // Koreksi jika bulan/tanggal sekarang lebih kecil dari bulan/tanggal lahir
                    if (bulan < 0 || (bulan === 0 && hariIni.getDate() < tanggalLahir.getDate())) {
                        usia--;
                    }

                    // Perbarui nilai usia (jangan biarkan negatif)
                    usiaInput.value = usia >= 0 ? usia : 0;

                    // Panggil fungsi terkait usia
                    handleUsiaChange();
                });
            }

            // Jalankan fungsi awal jika nilai sudah diatur
            if (tanggalLahirInput?.value) {
                tanggalLahirInput.dispatchEvent(new Event('change'));
            }
        });

        function handleUsiaChange() {
            const usiaInput = document.getElementById('usiaInput');
            const usia = parseInt(usiaInput?.value || 0, 10);

            // Panggil fungsi-fungsi terkait usia
            toggleIMTSection(usia);
            updateGiziKeterangan(usia);
            updateStatusGiziLabels(usia);
            updateBatukLabel(usia);
            updateBbTurunLabel(usia);
            updateDemamLabel(usia);
            updateLesuLabel(usia);
        }

        function toggleIMTSection(usia) {
            const imtSection = document.getElementById('imtSection');
            if (imtSection) {
                imtSection.style.display = usia > 18 ? 'block' : 'none';
            }
        }

        function toggleKontakJenis(show) {
            const jenisKontakSection = document.getElementById('jenisKontakSection');
            if (jenisKontakSection) {
                jenisKontakSection.style.display = show ? 'block' : 'none';
            }
        }

        function toggleKapan(show) {
            const kapanSection = document.getElementById('kapanSection');
            if (kapanSection) {
                kapanSection.style.display = show ? 'block' : 'none';
            }
        }

        function toggleBatuk(show) {
            const batukSection = document.getElementById('batukSection');
            if (batukSection) {
                batukSection.style.display = show ? 'block' : 'none';
            }
        }

        function toggleRontgen(show) {
            const rontgenSection = document.getElementById('rontgenSection');
            if (rontgenSection) {
                rontgenSection.style.display = show ? 'block' : 'none';
            }
        }

        function updateGiziKeterangan(usia) {
            const standarGiziLabel = document.getElementById('standarGiziLabel');
            const standarGiziList = document.getElementById('standarGiziList');

            if (!standarGiziLabel || !standarGiziList) return;

            if (usia < 5) {
                standarGiziLabel.textContent = 'Standar Hasil Status Gizi:';
                standarGiziList.innerHTML = `
            <li>< 2 tahun menggunakan perhitungan BB/PB dilihat berdasarkan tabel z-score</li>
            <li>2 – 5 tahun menggunakan perhitungan BB/TB dilihat berdasarkan tabel z-score</li>
        `;
            } else if (usia >= 5 && usia < 15) {
                standarGiziLabel.textContent = 'Standar Hasil Status Gizi:';
                standarGiziList.innerHTML = `
            <li>5 – 15 tahun menggunakan perhitungan IMT/U dilihat berdasarkan tabel z-score</li>
        `;
            } else if (usia >= 15 && usia <= 18) {
                standarGiziLabel.textContent = 'Standar Hasil Status Gizi:';
                standarGiziList.innerHTML = `
            <li>15 – 18 tahun menggunakan perhitungan IMT/U dilihat berdasarkan tabel z-score</li>
        `;
            } else {
                standarGiziLabel.textContent = 'Standar Hasil Status Gizi:';
                standarGiziList.innerHTML = `
            <li>Sangat Kurus: < 17,0 Kg/m2</li>
            <li>Kurus: 17 - < 18,5 Kg/m2</li>
            <li>Normal: 18,5 - 25,0 Kg/m2</li>
            <li>Gemuk: >25,0 - 27,0 Kg/m2</li>
            <li>Obese: > 27,0 Kg/m2</li>
        `;
            }
        }

        function updateStatusGiziLabels(usia) {
            const labelBuruk = document.getElementById('labelBuruk');
            const labelKurang = document.getElementById('labelKurang');
            const labelBaik = document.getElementById('labelBaik');
            const labelLebih = document.getElementById('labelLebih');
            const labelObesitas = document.getElementById('labelObesitas');

            if (!labelBuruk || !labelKurang || !labelBaik || !labelLebih || !labelObesitas) return;

            if (usia < 5 || (usia >= 15 && usia <= 18)) {
                labelBuruk.textContent = 'Gizi buruk';
                labelKurang.textContent = 'Gizi kurang';
                labelBaik.textContent = 'Gizi baik';
                labelLebih.textContent = 'Gizi lebih';
                labelObesitas.textContent = 'Obesitas';
            } else {
                labelBuruk.textContent = 'Sangat kurus';
                labelKurang.textContent = 'Kurus';
                labelBaik.textContent = 'Normal';
                labelLebih.textContent = 'Gemuk';
                labelObesitas.textContent = 'Obesitas';
            }
        }

        function updateBatukLabel(usia) {
            const batukLabel = document.getElementById('batukLabel');
            const batukSection = document.getElementById('batukSection');

            if (!batukLabel || !batukSection) return;

            if (usia >= 15) {
                batukLabel.textContent = '1. Batuk (semua bentuk batuk tanpa melihat durasi)';
                batukSection.style.display = 'none';
            } else {
                batukLabel.textContent = '1. Batuk >= 2 minggu';
                batukSection.style.display = 'none';
            }
        }

        function updateBbTurunLabel(usia) {
            const bbLabel = document.getElementById('bbLabel');

            if (usia >= 15) {
                bbLabel.textContent = '3. BB turun tanpa penyebab jelas/BB tidak naik/nafsu makan turun';

            } else {
                bbLabel.textContent =
                    "3. BB turun tanpa penyebab jelas/BB tidak naik dalam 2 bulan sebelumnya/nafsu makan turun";

            }
        }

        function updateDemamLabel(usia) {
            const demamLabel = document.getElementById('demamLabel');


            if (!demamLabel) return;

            if (usia >= 15) {
                demamLabel.textContent = '4. Demam hilang timbul tanpa sebab yang jelas';

            } else {
                demamLabel.textContent =
                    '4. Demam hilang timbul tanpa sebab yang jelas ≥ 2 minggu';

            }
        }

        function updateLesuLabel(usia) {
            const lesuLabel = document.getElementById('lesuLabel');


            if (!lesuLabel) return;

            if (usia >= 15) {
                lesuLabel.textContent = '5. Berkeringat malam hari tanpa kegiatan';

            } else {
                lesuLabel.textContent =
                    '5. Lesu atau malaise, anak kurang aktif bermain';

            }
        }
    </script>
@endsection
