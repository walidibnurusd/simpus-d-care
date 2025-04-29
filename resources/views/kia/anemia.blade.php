<<<<<<< HEAD
@extends('layouts.skrining.master')
@section('title', 'Skrining Anemia')
@section('content')
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show d-flex align-items-center" role="alert">
            <i class="mr-2 text-success"></i>
            <strong>Success:</strong> {{ session('success') }}
            <button type="button" class="close ml-auto" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif


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

    <form action="{{ isset($anemia) ? route('anemia.update', $anemia->id) : route('anemia.store') }}" method="POST">
        @csrf
        @if (isset($anemia))
            @method('PUT')
        @endif
        @if ($routeName === 'anemia.view')
            <input type="hidden" name="klaster" value="2">
            <input type="hidden" name="poli" value="kia">
        @elseif($routeName === 'anemia.mtbs.view')
            <input type="hidden" name="klaster" value="2">
            <input type="hidden" name="poli" value="mtbs">
        @elseif($routeName === 'anemia.lansia.view')
            <input type="hidden" name="klaster" value="3">
            <input type="hidden" name="poli" value="lansia">
        @endif

        <div class="form-section">
            <h3>Identitas</h3>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Pasien</label>
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
                        <label>Tanggal Lahir</label>
                        <input type="date" class="form-control" name="tanggal_lahir" id="tanggal_lahir" readonly
                            value="{{ old('tanggal_lahir', $pasien->dob ?? '') }}">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Alamat Lengkap</label>
                        <input type="text" class="form-control" name="alamat" placeholder="Masukkan alamat lengkap"
                            readonly id="alamat" value="{{ old('alamat', $pasien->address ?? '') }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Jenis Kelamin</label>
                        <div class="d-flex">
                            <div class="form-check mr-3">
                                <input type="radio" class="form-check-input" name="jenis_kelamin" value="laki-laki"
                                    id="jk_laki"
                                    {{ old('jenis_kelamin', $pasien->gender ?? '2') == '2' ? 'checked' : '' }}>
                                <label class="form-check-label" for="laki-laki">Laki-laki</label>
                            </div>
                            <div class="form-check">
                                <input type="radio" class="form-check-input" name="jenis_kelamin" value="perempuan"
                                    id="jk_perempuan"
                                    {{ old('jenis_kelamin', $pasien->gender ?? '1') == '1' ? 'checked' : '' }}>
                                <label class="form-check-label" for="perempuan">Perempuan</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tanda dan Gejala Anemia Section -->
            <div class="form-section mt-4">
                <h3>Tanda dan Gejala Anemia</h3>

                <div class="form-group">
                    <label>1. Keluhan 5L (Letih, Lemah, Lesu, Lelah, Lalai)?</label>
                    <div class="d-flex">
                        <div class="form-check mr-3">
                            <input type="radio" class="form-check-input" name="keluhan_5l" value="1"
                                id="keluhan_5l_ya"
                                {{ old('keluhan_5l', $anemia->keluhan_5l ?? '') == '1' ? 'checked' : '' }}>
                            <label class="form-check-label" for="keluhan_5l_ya">Ya</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="keluhan_5l" value="0"
                                id="keluhan_5l_tidak"
                                {{ old('keluhan_5l', $anemia->keluhan_5l ?? '') == '0' ? 'checked' : '' }}>
                            <label class="form-check-label" for="keluhan_5l_tidak">Tidak</label>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label>2. Mudah mengantuk?</label>
                    <div class="d-flex">
                        <div class="form-check mr-3">
                            <input type="radio" class="form-check-input" name="mudah_mengantuk" value="1"
                                id="mudah_mengantuk_ya"
                                {{ old('mudah_mengantuk', $anemia->mudah_mengantuk ?? '') == '1' ? 'checked' : '' }}>
                            <label class="form-check-label" for="mudah_mengantuk_ya">Ya</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="mudah_mengantuk" value="0"
                                id="mudah_mengantuk_tidak"
                                {{ old('mudah_mengantuk', $anemia->mudah_mengantuk ?? '') == '0' ? 'checked' : '' }}>
                            <label class="form-check-label" for="mudah_mengantuk_tidak">Tidak</label>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label>3. Sulit berkonsentrasi?</label>
                    <div class="d-flex">
                        <div class="form-check mr-3">
                            <input type="radio" class="form-check-input" name="sulit_konsentrasi" value="1"
                                id="sulit_konsentrasi_ya"
                                {{ old('sulit_konsentrasi', $anemia->sulit_konsentrasi ?? '') == '1' ? 'checked' : '' }}>
                            <label class="form-check-label" for="sulit_konsentrasi_ya">Ya</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="sulit_konsentrasi" value="0"
                                id="sulit_konsentrasi_tidak"
                                {{ old('sulit_konsentrasi', $anemia->sulit_konsentrasi ?? '') == '0' ? 'checked' : '' }}>
                            <label class="form-check-label" for="sulit_konsentrasi_tidak">Tidak</label>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label>4. Sering pusing, mata berkunang-kunang?</label>
                    <div class="d-flex">
                        <div class="form-check mr-3">
                            <input type="radio" class="form-check-input" name="sering_pusing" value="1"
                                id="sering_pusing_ya"
                                {{ old('sering_pusing', $anemia->sering_pusing ?? '') == '1' ? 'checked' : '' }}>
                            <label class="form-check-label" for="sering_pusing_ya">Ya</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="sering_pusing" value="0"
                                id="sering_pusing_tidak"
                                {{ old('sering_pusing', $anemia->sering_pusing ?? '') == '0' ? 'checked' : '' }}>
                            <label class="form-check-label" for="sering_pusing_tidak">Tidak</label>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label>5. Sakit kepala, baik dalam beberapa hari maupun lebih lama dari itu?</label>
                    <div class="d-flex">
                        <div class="form-check mr-3">
                            <input type="radio" class="form-check-input" name="sakit_kepala" value="1"
                                id="sakit_kepala_ya"
                                {{ old('sakit_kepala', $anemia->sakit_kepala ?? '') == '1' ? 'checked' : '' }}>
                            <label class="form-check-label" for="sakit_kepala_ya">Ya</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="sakit_kepala" value="0"
                                id="sakit_kepala_tidak"
                                {{ old('sakit_kepala', $anemia->sakit_kepala ?? '') == '0' ? 'checked' : '' }}>
                            <label class="form-check-label" for="sakit_kepala_tidak">Tidak</label>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label>6. Riwayat talasemia pada keluarga?</label>
                    <div class="d-flex">
                        <div class="form-check mr-3">
                            <input type="radio" class="form-check-input" name="riwayat_talasemia" value="1"
                                id="riwayat_talasemia_ya"
                                {{ old('riwayat_talasemia', $anemia->riwayat_talasemia ?? '') == '1' ? 'checked' : '' }}>
                            <label class="form-check-label" for="riwayat_talasemia_ya">Ya</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="riwayat_talasemia" value="0"
                                id="riwayat_talasemia_tidak"
                                {{ old('riwayat_talasemia', $anemia->riwayat_talasemia ?? '') == '0' ? 'checked' : '' }}>
                            <label class="form-check-label" for="riwayat_talasemia_tidak">Tidak</label>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label>7. Tanyakan : <br> Gaya hidup terkait konsumsi sayur, buah, protein hewani, kebersihan diri, dan
                        penyakit yang sedang diderita</label>
                    <textarea class="form-control" name="gaya_hidup" rows="4" placeholder="Masukkan gaya hidup">{{ old('gaya_hidup', $anemia->gaya_hidup ?? '') }}</textarea>
                </div>

                <div class="form-group">
                    <label>8. Apakah Anda selama ini biasa makan makanan yang berlemak hewani?</label>
                    <div class="d-flex">
                        <div class="form-check mr-3">
                            <input type="radio" class="form-check-input" name="makan_lemak" value="1"
                                id="makan_lemak_ya"
                                {{ old('makan_lemak', $anemia->makan_lemak ?? '') == '1' ? 'checked' : '' }}>
                            <label class="form-check-label" for="makan_lemak_ya">Ya</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="makan_lemak" value="0"
                                id="makan_lemak_tidak"
                                {{ old('makan_lemak', $anemia->makan_lemak ?? '') == '0' ? 'checked' : '' }}>
                            <label class="form-check-label" for="makan_lemak_tidak">Tidak</label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-section mt-4">
                <h3>Pemeriksaan Fisik</h3>
                <div class="form-group">
                    <label>1. Konjungtiva pucat?</label>
                    <div class="d-flex">
                        <div class="form-check mr-3">
                            <input type="radio" class="form-check-input" name="kongjungtiva_pucat" value="1"
                                id="kongjungtiva_pucat_ya"
                                {{ old('kongjungtiva_pucat', $anemia->kongjungtiva_pucat ?? '') == '1' ? 'checked' : '' }}>
                            <label class="form-check-label" for="kongjungtiva_pucat_ya">Ya</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="kongjungtiva_pucat" value="0"
                                id="kongjungtiva_pucat_tidak"
                                {{ old('kongjungtiva_pucat', $anemia->kongjungtiva_pucat ?? '') == '0' ? 'checked' : '' }}>
                            <label class="form-check-label" for="kongjungtiva_pucat_tidak">Tidak</label>
                        </div>
                    </div>
                </div>

                <!-- Repeat similar blocks for the remaining questions in this section -->

                <div class="form-group">
                    <label>2. Telapak tangan, wajah, bibir, kulit, kuku pucat?</label>
                    <div class="d-flex">
                        <div class="form-check mr-3">
                            <input type="radio" class="form-check-input" name="pucat" value="1"
                                id="pucat_bibir_ya" {{ old('pucat', $anemia->pucat ?? '') == '1' ? 'checked' : '' }}>
                            <label class="form-check-label" for="pucat_bibir_ya">Ya</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="pucat" value="0"
                                id="pucat_bibir_tidak" {{ old('pucat', $anemia->pucat ?? '') == '0' ? 'checked' : '' }}>
                            <label class="form-check-label" for="pucat_bibir_tidak">Tidak</label>
                        </div>
                    </div>
                </div>

                <div class="form-section mt-4">
                    <h3>Pemeriksaan Penuniana</h3>
                    <div class="form-group">
                        <label>1. Pemeriksaan Kadar Hemoglobin dengan PoCT Hb meter (Posyandu dan Pustu) atau Hematology
                            Analyzer di Puskesmas?</label>
                        <textarea class="form-control" name="kadar_hemoglobin" rows="4"
                            placeholder="Masukkan pemeriksaan kadar hemoglobin">{{ old('kadar_hemoglobin', $anemia->kadar_hemoglobin ?? '') }}</textarea>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-12">
                        <label for="kesimpulan" style="color: rgb(19, 11, 241);">Kesimpulan</label>
                        <textarea class="form-control" id="kesimpulan" name="kesimpulan" placeholder="Kesimpulan">{{ old('kesimpulan', $anemia->kesimpulan ?? '') }}</textarea>
                    </div>
                </div>

            </div>

            <div class="text-right mt-4">
                {{-- @if (isset($anemia))
                    <a href="{{ route('anemia.admin') }}" type="button" class="btn btn-secondary mr-2"
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

            $('.select2').select2({
                placeholder: "Pilih pasien",
                allowClear: true
            });

        });
    </script>
@endsection
=======
@extends('layouts.skrining.master')
@section('title', 'Skrining Anemia')
@section('content')
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show d-flex align-items-center" role="alert">
            <i class="mr-2 text-success"></i>
            <strong>Success:</strong> {{ session('success') }}
            <button type="button" class="close ml-auto" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif


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

    <form action="{{ isset($anemia) ? route('anemia.update', $anemia->id) : route('anemia.store') }}" method="POST">
        @csrf
        @if (isset($anemia))
            @method('PUT')
        @endif
        @if ($routeName === 'anemia.view')
            <input type="hidden" name="klaster" value="2">
            <input type="hidden" name="poli" value="kia">
        @elseif($routeName === 'anemia.mtbs.view')
            <input type="hidden" name="klaster" value="2">
            <input type="hidden" name="poli" value="mtbs">
        @elseif($routeName === 'anemia.lansia.view')
            <input type="hidden" name="klaster" value="3">
            <input type="hidden" name="poli" value="lansia">
        @endif

        <div class="form-section">
            <h3>Identitas</h3>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Pasien</label>
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
                        <label>Tanggal Lahir</label>
                        <input type="date" class="form-control" name="tanggal_lahir" id="tanggal_lahir" readonly
                            value="{{ old('tanggal_lahir', $pasien->dob ?? '') }}">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Alamat Lengkap</label>
                        <input type="text" class="form-control" name="alamat" placeholder="Masukkan alamat lengkap"
                            readonly id="alamat" value="{{ old('alamat', $pasien->address ?? '') }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Jenis Kelamin</label>
                        <div class="d-flex">
                            <div class="form-check mr-3">
                                <input type="radio" class="form-check-input" name="jenis_kelamin" value="laki-laki"
                                    id="jk_laki"
                                    {{ old('jenis_kelamin', $pasien->gender ?? '2') == '2' ? 'checked' : '' }}>
                                <label class="form-check-label" for="laki-laki">Laki-laki</label>
                            </div>
                            <div class="form-check">
                                <input type="radio" class="form-check-input" name="jenis_kelamin" value="perempuan"
                                    id="jk_perempuan"
                                    {{ old('jenis_kelamin', $pasien->gender ?? '1') == '1' ? 'checked' : '' }}>
                                <label class="form-check-label" for="perempuan">Perempuan</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tanda dan Gejala Anemia Section -->
            <div class="form-section mt-4">
                <h3>Tanda dan Gejala Anemia</h3>

                <div class="form-group">
                    <label>1. Keluhan 5L (Letih, Lemah, Lesu, Lelah, Lalai)?</label>
                    <div class="d-flex">
                        <div class="form-check mr-3">
                            <input type="radio" class="form-check-input" name="keluhan_5l" value="1"
                                id="keluhan_5l_ya"
                                {{ old('keluhan_5l', $anemia->keluhan_5l ?? '') == '1' ? 'checked' : '' }}>
                            <label class="form-check-label" for="keluhan_5l_ya">Ya</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="keluhan_5l" value="0"
                                id="keluhan_5l_tidak"
                                {{ old('keluhan_5l', $anemia->keluhan_5l ?? '') == '0' ? 'checked' : '' }}>
                            <label class="form-check-label" for="keluhan_5l_tidak">Tidak</label>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label>2. Mudah mengantuk?</label>
                    <div class="d-flex">
                        <div class="form-check mr-3">
                            <input type="radio" class="form-check-input" name="mudah_mengantuk" value="1"
                                id="mudah_mengantuk_ya"
                                {{ old('mudah_mengantuk', $anemia->mudah_mengantuk ?? '') == '1' ? 'checked' : '' }}>
                            <label class="form-check-label" for="mudah_mengantuk_ya">Ya</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="mudah_mengantuk" value="0"
                                id="mudah_mengantuk_tidak"
                                {{ old('mudah_mengantuk', $anemia->mudah_mengantuk ?? '') == '0' ? 'checked' : '' }}>
                            <label class="form-check-label" for="mudah_mengantuk_tidak">Tidak</label>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label>3. Sulit berkonsentrasi?</label>
                    <div class="d-flex">
                        <div class="form-check mr-3">
                            <input type="radio" class="form-check-input" name="sulit_konsentrasi" value="1"
                                id="sulit_konsentrasi_ya"
                                {{ old('sulit_konsentrasi', $anemia->sulit_konsentrasi ?? '') == '1' ? 'checked' : '' }}>
                            <label class="form-check-label" for="sulit_konsentrasi_ya">Ya</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="sulit_konsentrasi" value="0"
                                id="sulit_konsentrasi_tidak"
                                {{ old('sulit_konsentrasi', $anemia->sulit_konsentrasi ?? '') == '0' ? 'checked' : '' }}>
                            <label class="form-check-label" for="sulit_konsentrasi_tidak">Tidak</label>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label>4. Sering pusing, mata berkunang-kunang?</label>
                    <div class="d-flex">
                        <div class="form-check mr-3">
                            <input type="radio" class="form-check-input" name="sering_pusing" value="1"
                                id="sering_pusing_ya"
                                {{ old('sering_pusing', $anemia->sering_pusing ?? '') == '1' ? 'checked' : '' }}>
                            <label class="form-check-label" for="sering_pusing_ya">Ya</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="sering_pusing" value="0"
                                id="sering_pusing_tidak"
                                {{ old('sering_pusing', $anemia->sering_pusing ?? '') == '0' ? 'checked' : '' }}>
                            <label class="form-check-label" for="sering_pusing_tidak">Tidak</label>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label>5. Sakit kepala, baik dalam beberapa hari maupun lebih lama dari itu?</label>
                    <div class="d-flex">
                        <div class="form-check mr-3">
                            <input type="radio" class="form-check-input" name="sakit_kepala" value="1"
                                id="sakit_kepala_ya"
                                {{ old('sakit_kepala', $anemia->sakit_kepala ?? '') == '1' ? 'checked' : '' }}>
                            <label class="form-check-label" for="sakit_kepala_ya">Ya</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="sakit_kepala" value="0"
                                id="sakit_kepala_tidak"
                                {{ old('sakit_kepala', $anemia->sakit_kepala ?? '') == '0' ? 'checked' : '' }}>
                            <label class="form-check-label" for="sakit_kepala_tidak">Tidak</label>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label>6. Riwayat talasemia pada keluarga?</label>
                    <div class="d-flex">
                        <div class="form-check mr-3">
                            <input type="radio" class="form-check-input" name="riwayat_talasemia" value="1"
                                id="riwayat_talasemia_ya"
                                {{ old('riwayat_talasemia', $anemia->riwayat_talasemia ?? '') == '1' ? 'checked' : '' }}>
                            <label class="form-check-label" for="riwayat_talasemia_ya">Ya</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="riwayat_talasemia" value="0"
                                id="riwayat_talasemia_tidak"
                                {{ old('riwayat_talasemia', $anemia->riwayat_talasemia ?? '') == '0' ? 'checked' : '' }}>
                            <label class="form-check-label" for="riwayat_talasemia_tidak">Tidak</label>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label>7. Tanyakan : <br> Gaya hidup terkait konsumsi sayur, buah, protein hewani, kebersihan diri, dan
                        penyakit yang sedang diderita</label>
                    <textarea class="form-control" name="gaya_hidup" rows="4" placeholder="Masukkan gaya hidup">{{ old('gaya_hidup', $anemia->gaya_hidup ?? '') }}</textarea>
                </div>

                <div class="form-group">
                    <label>8. Apakah Anda selama ini biasa makan makanan yang berlemak hewani?</label>
                    <div class="d-flex">
                        <div class="form-check mr-3">
                            <input type="radio" class="form-check-input" name="makan_lemak" value="1"
                                id="makan_lemak_ya"
                                {{ old('makan_lemak', $anemia->makan_lemak ?? '') == '1' ? 'checked' : '' }}>
                            <label class="form-check-label" for="makan_lemak_ya">Ya</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="makan_lemak" value="0"
                                id="makan_lemak_tidak"
                                {{ old('makan_lemak', $anemia->makan_lemak ?? '') == '0' ? 'checked' : '' }}>
                            <label class="form-check-label" for="makan_lemak_tidak">Tidak</label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-section mt-4">
                <h3>Pemeriksaan Fisik</h3>
                <div class="form-group">
                    <label>1. Konjungtiva pucat?</label>
                    <div class="d-flex">
                        <div class="form-check mr-3">
                            <input type="radio" class="form-check-input" name="kongjungtiva_pucat" value="1"
                                id="kongjungtiva_pucat_ya"
                                {{ old('kongjungtiva_pucat', $anemia->kongjungtiva_pucat ?? '') == '1' ? 'checked' : '' }}>
                            <label class="form-check-label" for="kongjungtiva_pucat_ya">Ya</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="kongjungtiva_pucat" value="0"
                                id="kongjungtiva_pucat_tidak"
                                {{ old('kongjungtiva_pucat', $anemia->kongjungtiva_pucat ?? '') == '0' ? 'checked' : '' }}>
                            <label class="form-check-label" for="kongjungtiva_pucat_tidak">Tidak</label>
                        </div>
                    </div>
                </div>

                <!-- Repeat similar blocks for the remaining questions in this section -->

                <div class="form-group">
                    <label>2. Telapak tangan, wajah, bibir, kulit, kuku pucat?</label>
                    <div class="d-flex">
                        <div class="form-check mr-3">
                            <input type="radio" class="form-check-input" name="pucat" value="1"
                                id="pucat_bibir_ya" {{ old('pucat', $anemia->pucat ?? '') == '1' ? 'checked' : '' }}>
                            <label class="form-check-label" for="pucat_bibir_ya">Ya</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="pucat" value="0"
                                id="pucat_bibir_tidak" {{ old('pucat', $anemia->pucat ?? '') == '0' ? 'checked' : '' }}>
                            <label class="form-check-label" for="pucat_bibir_tidak">Tidak</label>
                        </div>
                    </div>
                </div>

                <div class="form-section mt-4">
                    <h3>Pemeriksaan Penuniana</h3>
                    <div class="form-group">
                        <label>1. Pemeriksaan Kadar Hemoglobin dengan PoCT Hb meter (Posyandu dan Pustu) atau Hematology
                            Analyzer di Puskesmas?</label>
                        <textarea class="form-control" name="kadar_hemoglobin" rows="4"
                            placeholder="Masukkan pemeriksaan kadar hemoglobin">{{ old('kadar_hemoglobin', $anemia->kadar_hemoglobin ?? '') }}</textarea>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-12">
                        <label for="kesimpulan" style="color: rgb(19, 11, 241);">Kesimpulan</label>
                        <textarea class="form-control" id="kesimpulan" name="kesimpulan" placeholder="Kesimpulan">{{ old('kesimpulan', $anemia->kesimpulan ?? '') }}</textarea>
                    </div>
                </div>

            </div>

            <div class="text-right mt-4">
                {{-- @if (isset($anemia))
                    <a href="{{ route('anemia.admin') }}" type="button" class="btn btn-secondary mr-2"
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

            $('.select2').select2({
                placeholder: "Pilih pasien",
                allowClear: true
            });

        });
    </script>
@endsection
>>>>>>> 9df8fede466960d27744a11e4cb830e2a9437611
