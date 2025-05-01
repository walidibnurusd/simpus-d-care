@extends('layouts.skrining.master')
@section('title', 'Skrining Keswa SDQ (4-11 Tahun)')
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

    <form
        action="{{ isset($gangguanJiwaAnak) ? route('sdq.mtbs.update', $gangguanJiwaAnak->id) : route('sdq.mtbs.store') }}"
        method="POST">
        @csrf
        @if (isset($gangguanJiwaAnak))
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
                                    data-jenis_kelamin="{{ $item->genderName->name }}" data-alamat="{{ $item->address }}"
                                    {{ old('pasien', $gangguanJiwaAnak->pasien ?? '') == $item->id ? 'selected' : '' }}>
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
                        <label>Tanggal Lahir</label>
                        <input type="date" class="form-control" name="tanggal_lahir" id="tanggal_lahir" readonly
                            value="{{ old('tanggal_lahir', isset($gangguanJiwaAnak) ? $gangguanJiwaAnak->tanggal_lahir : '') }}">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Alamat Lengkap</label>
                        <input type="text" class="form-control" name="alamat" placeholder="Masukkan alamat lengkap"
                            id="alamat" readonly
                            value="{{ old('alamat', isset($gangguanJiwaAnak) ? $gangguanJiwaAnak->alamat : '') }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Jenis Kelamin</label>
                        <div class="d-flex">
                            <div class="form-check mr-3">
                                <input type="radio" class="form-check-input" name="jenis_kelamin" value="laki-laki"
                                    id="jk_laki" id="laki-laki"
                                    {{ old('jenis_kelamin', isset($gangguanJiwaAnak) && $gangguanJiwaAnak->jenis_kelamin == 'laki-laki' ? 'checked' : '') }}>
                                <label class="form-check-label" for="laki-laki">Laki-laki</label>
                            </div>
                            <div class="form-check">
                                <input type="radio" class="form-check-input" name="jenis_kelamin" value="perempuan"
                                    id="jk_perempuan" id="perempuan"
                                    {{ old('jenis_kelamin', isset($gangguanJiwaAnak) && $gangguanJiwaAnak->jenis_kelamin == 'perempuan' ? 'checked' : '') }}>
                                <label class="form-check-label" for="perempuan">Perempuan</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>



        </div>
        <div class="form-section mt-4">

            <h3>Pertanyaan</h3>

            <div class="form-group">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>1. Dapat memperdulikan perasaan orang lain (Pro)?</label>
                            <div class="d-flex">
                                <div class="form-check mr-3">
                                    <input type="radio" class="form-check-input" name="berusaha_baik" value="2"
                                        onclick="calculateTotalScore()" id="benar_berusaha_baik"
                                        {{ old('berusaha_baik', isset($gangguanJiwaAnak) && $gangguanJiwaAnak->berusaha_baik == 2 ? 'checked' : '') }}>
                                    <label class="form-check-label" for="benar_berusaha_baik">Selalu benar</label>
                                </div>
                                <div class="form-check">
                                    <input type="radio" class="form-check-input" name="berusaha_baik" value="1"
                                        onclick="calculateTotalScore()" id="kadang_berusaha_baik"
                                        {{ old('berusaha_baik', isset($gangguanJiwaAnak) && $gangguanJiwaAnak->berusaha_baik == 1 ? 'checked' : '') }}>
                                    <label class="form-check-label" for="kadang_berusaha_baik">Kadang benar</label>
                                </div>
                                <div class="form-check ml-3">
                                    <input type="radio" class="form-check-input" name="berusaha_baik" value="0"
                                        onclick="calculateTotalScore()" id="tidak_berusaha_baik"
                                        {{ old('berusaha_baik', isset($gangguanJiwaAnak) && $gangguanJiwaAnak->berusaha_baik == 0 ? 'checked' : '') }}>
                                    <label class="form-check-label" for="tidak_berusaha_baik">Tidak benar</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Pertanyaan 2 -->
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>2. Gelisah, terlalu aktif, tidak dapat diam untuk waktu lama (H)?</label>
                            <div class="d-flex">
                                <div class="form-check mr-3">
                                    <input type="radio" class="form-check-input" name="gelisah" value="2"
                                        onclick="calculateTotalScore()" id="benar_gelisah"
                                        {{ old('gelisah', isset($gangguanJiwaAnak) && $gangguanJiwaAnak->gelisah == 2 ? 'checked' : '') }}>
                                    <label class="form-check-label" for="benar_gelisah">Selalu benar</label>
                                </div>
                                <div class="form-check">
                                    <input type="radio" class="form-check-input" name="gelisah" value="1"
                                        onclick="calculateTotalScore()" id="kadang_gelisah"
                                        {{ old('gelisah', isset($gangguanJiwaAnak) && $gangguanJiwaAnak->gelisah == 1 ? 'checked' : '') }}>
                                    <label class="form-check-label" for="kadang_gelisah">Kadang benar</label>
                                </div>
                                <div class="form-check ml-3">
                                    <input type="radio" class="form-check-input" name="gelisah" value="0"
                                        onclick="calculateTotalScore()" id="tidak_gelisah"
                                        {{ old('gelisah', isset($gangguanJiwaAnak) && $gangguanJiwaAnak->gelisah == 0 ? 'checked' : '') }}>
                                    <label class="form-check-label" for="tidak_gelisah">Tidak benar</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Pertanyaan 3 -->
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>3. Sering mengeluh sakit kepala, sakit perut atau sakit lainnya (E)?</label>
                            <div class="d-flex">
                                <div class="form-check mr-3">
                                    <input type="radio" class="form-check-input" name="sakit" value="2"
                                        onclick="calculateTotalScore()" id="benar_sakit"
                                        {{ old('sakit', isset($gangguanJiwaAnak) && $gangguanJiwaAnak->sakit == 2 ? 'checked' : '') }}>
                                    <label class="form-check-label" for="benar_sakit">Selalu benar</label>
                                </div>
                                <div class="form-check">
                                    <input type="radio" class="form-check-input" name="sakit" value="1"
                                        onclick="calculateTotalScore()" id="kadang_sakit"
                                        {{ old('sakit', isset($gangguanJiwaAnak) && $gangguanJiwaAnak->sakit == 1 ? 'checked' : '') }}>
                                    <label class="form-check-label" for="kadang_sakit">Kadang benar</label>
                                </div>
                                <div class="form-check ml-3">
                                    <input type="radio" class="form-check-input" name="sakit" value="0"
                                        onclick="calculateTotalScore()" id="tidak_sakit"
                                        {{ old('sakit', isset($gangguanJiwaAnak) && $gangguanJiwaAnak->sakit == 0 ? 'checked' : '') }}>
                                    <label class="form-check-label" for="tidak_sakit">Tidak benar</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Pertanyaan 4 -->
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>4. Kalau mempunyai mainan, kesenangan atau pensil, anak bersedia berbagi dengan anak-anak
                                lain (Pro)?</label>
                            <div class="d-flex">
                                <div class="form-check mr-3">
                                    <input type="radio" class="form-check-input" name="berbagi" value="2"
                                        onclick="calculateTotalScore()" id="benar_berbagi"
                                        {{ old('berbagi', isset($gangguanJiwaAnak) && $gangguanJiwaAnak->berbagi == 2 ? 'checked' : '') }}>
                                    <label class="form-check-label" for="benar_berbagi">Selalu benar</label>
                                </div>
                                <div class="form-check">
                                    <input type="radio" class="form-check-input" name="berbagi" value="1"
                                        onclick="calculateTotalScore()" id="kadang_berbagi"
                                        {{ old('berbagi', isset($gangguanJiwaAnak) && $gangguanJiwaAnak->berbagi == 1 ? 'checked' : '') }}>
                                    <label class="form-check-label" for="kadang_berbagi">Kadang benar</label>
                                </div>
                                <div class="form-check ml-3">
                                    <input type="radio" class="form-check-input" name="berbagi" value="0"
                                        onclick="calculateTotalScore()" id="tidak_berbagi"
                                        {{ old('berbagi', isset($gangguanJiwaAnak) && $gangguanJiwaAnak->berbagi == 0 ? 'checked' : '') }}>
                                    <label class="form-check-label" for="tidak_berbagi">Tidak benar</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Pertanyaan 5 -->
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>5. Sering sulit mengendalikan kemarahan (C)?</label>
                            <div class="d-flex">
                                <div class="form-check mr-3">
                                    <input type="radio" class="form-check-input" name="marah" value="2"
                                        onclick="calculateTotalScore()" id="benar_marah"
                                        {{ old('marah', isset($gangguanJiwaAnak) && $gangguanJiwaAnak->marah == 2 ? 'checked' : '') }}>
                                    <label class="form-check-label" for="benar_marah">Selalu benar</label>
                                </div>
                                <div class="form-check">
                                    <input type="radio" class="form-check-input" name="marah" value="1"
                                        onclick="calculateTotalScore()" id="kadang_marah"
                                        {{ old('marah', isset($gangguanJiwaAnak) && $gangguanJiwaAnak->marah == 1 ? 'checked' : '') }}>
                                    <label class="form-check-label" for="kadang_marah">Kadang benar</label>
                                </div>
                                <div class="form-check ml-3">
                                    <input type="radio" class="form-check-input" name="marah" value="0"
                                        onclick="calculateTotalScore()" id="tidak_marah"
                                        {{ old('marah', isset($gangguanJiwaAnak) && $gangguanJiwaAnak->marah == 0 ? 'checked' : '') }}>
                                    <label class="form-check-label" for="tidak_marah">Tidak benar</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>6. Cenderung menyendiri, lebih suka bermain seorang diri (P)?</label>
                            <div class="d-flex">
                                <div class="form-check mr-3">
                                    <input type="radio" class="form-check-input" name="suka_sendiri" value="2"
                                        onclick="calculateTotalScore()" id="benar"
                                        {{ old('suka_sendiri') == '2' || (isset($gangguanJiwaAnak) && $gangguanJiwaAnak->suka_sendiri == 2) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="benar">Selalu benar</label>
                                </div>
                                <div class="form-check">
                                    <input type="radio" class="form-check-input" name="suka_sendiri" value="1"
                                        onclick="calculateTotalScore()" id="kadang"
                                        {{ old('suka_sendiri') == '1' || (isset($gangguanJiwaAnak) && $gangguanJiwaAnak->suka_sendiri == 1) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="kadang">Kadang benar</label>
                                </div>
                                <div class="form-check ml-3">
                                    <input type="radio" class="form-check-input" name="suka_sendiri" value="0"
                                        onclick="calculateTotalScore()" id="tidak"
                                        {{ old('suka_sendiri') == '0' || (isset($gangguanJiwaAnak) && $gangguanJiwaAnak->suka_sendiri == 0) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="tidak">Tidak benar</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label>7. Umumnya bertingkah laku baik, biasanya melakukan apa yang disuruh oleh orang dewasa
                                (C)?</label>
                            <div class="d-flex">
                                <div class="form-check mr-3">
                                    <input type="radio" class="form-check-input" name="penurut" value="0"
                                        onclick="calculateTotalScore()" id="benar"
                                        {{ old('penurut') == '0' || (isset($gangguanJiwaAnak) && $gangguanJiwaAnak->penurut == 0) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="benar">Selalu benar</label>
                                </div>
                                <div class="form-check">
                                    <input type="radio" class="form-check-input" name="penurut" value="1"
                                        onclick="calculateTotalScore()" id="kadang"
                                        {{ old('penurut') == '1' || (isset($gangguanJiwaAnak) && $gangguanJiwaAnak->penurut == 1) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="kadang">Kadang benar</label>
                                </div>
                                <div class="form-check ml-3">
                                    <input type="radio" class="form-check-input" name="penurut" value="2"
                                        onclick="calculateTotalScore()" id="tidak"
                                        {{ old('penurut') == '2' || (isset($gangguanJiwaAnak) && $gangguanJiwaAnak->penurut == 2) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="tidak">Tidak benar</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label>8. Banyak kekhawatiran atau sering tampak khawatir (E)?</label>
                            <div class="d-flex">
                                <div class="form-check mr-3">
                                    <input type="radio" class="form-check-input" name="cemas" value="2"
                                        onclick="calculateTotalScore()" id="benar"
                                        {{ old('cemas') == '2' || (isset($gangguanJiwaAnak) && $gangguanJiwaAnak->cemas == 2) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="benar">Selalu benar</label>
                                </div>
                                <div class="form-check">
                                    <input type="radio" class="form-check-input" name="cemas" value="1"
                                        onclick="calculateTotalScore()" id="kadang"
                                        {{ old('cemas') == '1' || (isset($gangguanJiwaAnak) && $gangguanJiwaAnak->cemas == 1) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="kadang">Kadang benar</label>
                                </div>
                                <div class="form-check ml-3">
                                    <input type="radio" class="form-check-input" name="cemas" value="0"
                                        onclick="calculateTotalScore()" id="tidak"
                                        {{ old('cemas') == '0' || (isset($gangguanJiwaAnak) && $gangguanJiwaAnak->cemas == 0) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="tidak">Tidak benar</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label>9. Suka menolong jika seseorang terluka, kecewa atau merasa sakit (Pro)?</label>
                            <div class="d-flex">
                                <div class="form-check mr-3">
                                    <input type="radio" class="form-check-input" name="siap_menolong" value="2"
                                        onclick="calculateTotalScore()" id="benar"
                                        {{ old('siap_menolong') == '2' || (isset($gangguanJiwaAnak) && $gangguanJiwaAnak->siap_menolong == 2) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="benar">Selalu benar</label>
                                </div>
                                <div class="form-check">
                                    <input type="radio" class="form-check-input" name="siap_menolong" value="1"
                                        onclick="calculateTotalScore()" id="kadang"
                                        {{ old('siap_menolong') == '1' || (isset($gangguanJiwaAnak) && $gangguanJiwaAnak->siap_menolong == 1) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="kadang">Kadang benar</label>
                                </div>
                                <div class="form-check ml-3">
                                    <input type="radio" class="form-check-input" name="siap_menolong" value="0"
                                        onclick="calculateTotalScore()" id="tidak"
                                        {{ old('siap_menolong') == '0' || (isset($gangguanJiwaAnak) && $gangguanJiwaAnak->siap_menolong == 0) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="tidak">Tidak benar</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label>10. Terus menerus bergerak dengan resah atau menggeliat-geliat (H)?</label>
                            <div class="d-flex">
                                <div class="form-check mr-3">
                                    <input type="radio" class="form-check-input" name="badan_bergerak" value="2"
                                        onclick="calculateTotalScore()" id="benar"
                                        {{ old('badan_bergerak') == '2' || (isset($gangguanJiwaAnak) && $gangguanJiwaAnak->badan_bergerak == 2) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="benar">Selalu benar</label>
                                </div>
                                <div class="form-check">
                                    <input type="radio" class="form-check-input" name="badan_bergerak" value="1"
                                        onclick="calculateTotalScore()" id="kadang"
                                        {{ old('badan_bergerak') == '1' || (isset($gangguanJiwaAnak) && $gangguanJiwaAnak->badan_bergerak == 1) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="kadang">Kadang benar</label>
                                </div>
                                <div class="form-check ml-3">
                                    <input type="radio" class="form-check-input" name="badan_bergerak" value="0"
                                        onclick="calculateTotalScore()" id="tidak"
                                        {{ old('badan_bergerak') == '0' || (isset($gangguanJiwaAnak) && $gangguanJiwaAnak->badan_bergerak == 0) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="tidak">Tidak benar</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>11. Mempunyai satu atau lebih teman baik (P)?</label>
                            <div class="d-flex">
                                <div class="form-check mr-3">
                                    <input type="radio" class="form-check-input" name="punya_teman" value="0"
                                        {{ isset($gangguanJiwaAnak) && $gangguanJiwaAnak->punya_teman == 0 ? 'checked' : '' }}
                                        onclick="calculateTotalScore()" id="benar">
                                    <label class="form-check-label" for="benar">Selalu benar</label>
                                </div>
                                <div class="form-check">
                                    <input type="radio" class="form-check-input" name="punya_teman" value="1"
                                        {{ isset($gangguanJiwaAnak) && $gangguanJiwaAnak->punya_teman == 1 ? 'checked' : '' }}
                                        onclick="calculateTotalScore()" id="kadang">
                                    <label class="form-check-label" for="kadang">Kadang benar</label>
                                </div>
                                <div class="form-check ml-3">
                                    <input type="radio" class="form-check-input" name="punya_teman" value="2"
                                        {{ isset($gangguanJiwaAnak) && $gangguanJiwaAnak->punya_teman == 2 ? 'checked' : '' }}
                                        onclick="calculateTotalScore()" id="tidak">
                                    <label class="form-check-label" for="tidak">Tidak benar</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label>12. Sering berkelahi dengan anak-anak lain atau mengintimidasi mereka (C)?</label>
                            <div class="d-flex">
                                <div class="form-check mr-3">
                                    <input type="radio" class="form-check-input" name="suka_bertengkar" value="2"
                                        {{ isset($gangguanJiwaAnak) && $gangguanJiwaAnak->suka_bertengkar == 2 ? 'checked' : '' }}
                                        onclick="calculateTotalScore()" id="benar">
                                    <label class="form-check-label" for="benar">Selalu benar</label>
                                </div>
                                <div class="form-check">
                                    <input type="radio" class="form-check-input" name="suka_bertengkar" value="1"
                                        {{ isset($gangguanJiwaAnak) && $gangguanJiwaAnak->suka_bertengkar == 1 ? 'checked' : '' }}
                                        onclick="calculateTotalScore()" id="kadang">
                                    <label class="form-check-label" for="kadang">Kadang benar</label>
                                </div>
                                <div class="form-check ml-3">
                                    <input type="radio" class="form-check-input" name="suka_bertengkar" value="0"
                                        {{ isset($gangguanJiwaAnak) && $gangguanJiwaAnak->suka_bertengkar == 0 ? 'checked' : '' }}
                                        onclick="calculateTotalScore()" id="tidak">
                                    <label class="form-check-label" for="tidak">Tidak benar</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label>13. Sering merasa tidak bahagia, sedih atau menangis (E)?</label>
                            <div class="d-flex">
                                <div class="form-check mr-3">
                                    <input type="radio" class="form-check-input" name="tdk_bahagia" value="0"
                                        {{ isset($gangguanJiwaAnak) && $gangguanJiwaAnak->tdk_bahagia == 0 ? 'checked' : '' }}
                                        onclick="calculateTotalScore()" id="benar">
                                    <label class="form-check-label" for="benar">Selalu benar</label>
                                </div>
                                <div class="form-check">
                                    <input type="radio" class="form-check-input" name="tdk_bahagia" value="1"
                                        {{ isset($gangguanJiwaAnak) && $gangguanJiwaAnak->tdk_bahagia == 1 ? 'checked' : '' }}
                                        onclick="calculateTotalScore()" id="kadang">
                                    <label class="form-check-label" for="kadang">Kadang benar</label>
                                </div>
                                <div class="form-check ml-3">
                                    <input type="radio" class="form-check-input" name="tdk_bahagia" value="2"
                                        {{ isset($gangguanJiwaAnak) && $gangguanJiwaAnak->tdk_bahagia == 2 ? 'checked' : '' }}
                                        onclick="calculateTotalScore()" id="tidak">
                                    <label class="form-check-label" for="tidak">Tidak benar</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label>14. Pada umumnya disukai oleh anak-anak lain (P)?</label>
                            <div class="d-flex">
                                <div class="form-check mr-3">
                                    <input type="radio" class="form-check-input" name="disukai" value="2"
                                        {{ isset($gangguanJiwaAnak) && $gangguanJiwaAnak->disukai == 2 ? 'checked' : '' }}
                                        onclick="calculateTotalScore()" id="benar">
                                    <label class="form-check-label" for="benar">Selalu benar</label>
                                </div>
                                <div class="form-check">
                                    <input type="radio" class="form-check-input" name="disukai" value="1"
                                        {{ isset($gangguanJiwaAnak) && $gangguanJiwaAnak->disukai == 1 ? 'checked' : '' }}
                                        onclick="calculateTotalScore()" id="kadang">
                                    <label class="form-check-label" for="kadang">Kadang benar</label>
                                </div>
                                <div class="form-check ml-3">
                                    <input type="radio" class="form-check-input" name="disukai" value="0"
                                        {{ isset($gangguanJiwaAnak) && $gangguanJiwaAnak->disukai == 0 ? 'checked' : '' }}
                                        onclick="calculateTotalScore()" id="tidak">
                                    <label class="form-check-label" for="tidak">Tidak benar</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label>15. Mudah teralih perhatiannya, tidak dapat berkonsentrasi (H)?</label>
                            <div class="d-flex">
                                <div class="form-check mr-3">
                                    <input type="radio" class="form-check-input" name="mudah_teralih" value="2"
                                        {{ isset($gangguanJiwaAnak) && $gangguanJiwaAnak->mudah_teralih == 2 ? 'checked' : '' }}
                                        onclick="calculateTotalScore()" id="benar">
                                    <label class="form-check-label" for="benar">Selalu benar</label>
                                </div>
                                <div class="form-check">
                                    <input type="radio" class="form-check-input" name="mudah_teralih" value="1"
                                        {{ isset($gangguanJiwaAnak) && $gangguanJiwaAnak->mudah_teralih == 1 ? 'checked' : '' }}
                                        onclick="calculateTotalScore()" id="kadang">
                                    <label class="form-check-label" for="kadang">Kadang benar</label>
                                </div>
                                <div class="form-check ml-3">
                                    <input type="radio" class="form-check-input" name="mudah_teralih" value="0"
                                        {{ isset($gangguanJiwaAnak) && $gangguanJiwaAnak->mudah_teralih == 0 ? 'checked' : '' }}
                                        onclick="calculateTotalScore()" id="tidak">
                                    <label class="form-check-label" for="tidak">Tidak benar</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label>16. Gugup atau sulit berpisah dengan orang tua/pengasuhnya pada situasi baru, mudah
                                kehilangan rasa percaya diri (E)?</label>
                            <div class="d-flex">
                                <div class="form-check mr-3">
                                    <input type="radio" class="form-check-input" name="gugup" value="2"
                                        {{ isset($gangguanJiwaAnak) && $gangguanJiwaAnak->gugup == 2 ? 'checked' : '' }}
                                        onclick="calculateTotalScore()" id="benar">
                                    <label class="form-check-label" for="benar">Selalu benar</label>
                                </div>
                                <div class="form-check">
                                    <input type="radio" class="form-check-input" name="gugup" value="1"
                                        {{ isset($gangguanJiwaAnak) && $gangguanJiwaAnak->gugup == 1 ? 'checked' : '' }}
                                        onclick="calculateTotalScore()" id="kadang">
                                    <label class="form-check-label" for="kadang">Kadang benar</label>
                                </div>
                                <div class="form-check ml-3">
                                    <input type="radio" class="form-check-input" name="gugup" value="0"
                                        {{ isset($gangguanJiwaAnak) && $gangguanJiwaAnak->gugup == 0 ? 'checked' : '' }}
                                        onclick="calculateTotalScore()" id="tidak">
                                    <label class="form-check-label" for="tidak">Tidak benar</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label>17. Bersikap baik terhadap anak-anak yang lebih muda (Pro)?</label>
                            <div class="d-flex">
                                <div class="form-check mr-3">
                                    <input type="radio" class="form-check-input" name="baik_pada_anak" value="2"
                                        {{ isset($gangguanJiwaAnak) && $gangguanJiwaAnak->baik_pada_anak == 2 ? 'checked' : '' }}
                                        onclick="calculateTotalScore()" id="benar">
                                    <label class="form-check-label" for="benar">Selalu benar</label>
                                </div>
                                <div class="form-check">
                                    <input type="radio" class="form-check-input" name="baik_pada_anak" value="1"
                                        {{ isset($gangguanJiwaAnak) && $gangguanJiwaAnak->baik_pada_anak == 1 ? 'checked' : '' }}
                                        onclick="calculateTotalScore()" id="kadang">
                                    <label class="form-check-label" for="kadang">Kadang benar</label>
                                </div>
                                <div class="form-check ml-3">
                                    <input type="radio" class="form-check-input" name="baik_pada_anak" value="0"
                                        {{ isset($gangguanJiwaAnak) && $gangguanJiwaAnak->baik_pada_anak == 0 ? 'checked' : '' }}
                                        onclick="calculateTotalScore()" id="tidak">
                                    <label class="form-check-label" for="tidak">Tidak benar</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label>18. Sering berbohong atau berbuat curang (C)?</label>
                            <div class="d-flex">
                                <div class="form-check mr-3">
                                    <input type="radio" class="form-check-input" name="bohong" value="2"
                                        {{ isset($gangguanJiwaAnak) && $gangguanJiwaAnak->bohong == 2 ? 'checked' : '' }}
                                        onclick="calculateTotalScore()" id="benar">
                                    <label class="form-check-label" for="benar">Selalu benar</label>
                                </div>
                                <div class="form-check">
                                    <input type="radio" class="form-check-input" name="bohong" value="1"
                                        {{ isset($gangguanJiwaAnak) && $gangguanJiwaAnak->bohong == 1 ? 'checked' : '' }}
                                        onclick="calculateTotalScore()" id="kadang">
                                    <label class="form-check-label" for="kadang">Kadang benar</label>
                                </div>
                                <div class="form-check ml-3">
                                    <input type="radio" class="form-check-input" name="bohong" value="0"
                                        {{ isset($gangguanJiwaAnak) && $gangguanJiwaAnak->bohong == 0 ? 'checked' : '' }}
                                        onclick="calculateTotalScore()" id="tidak">
                                    <label class="form-check-label" for="tidak">Tidak benar</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label>19. Diganggu dipermainkan, diintimidasi atau diancam oleh anak-anak lain (P)?</label>
                            <div class="d-flex">
                                <div class="form-check mr-3">
                                    <input type="radio" class="form-check-input" name="diancam" value="2"
                                        {{ isset($gangguanJiwaAnak) && $gangguanJiwaAnak->diancam == 2 ? 'checked' : '' }}
                                        onclick="calculateTotalScore()" id="benar">
                                    <label class="form-check-label" for="benar">Selalu benar</label>
                                </div>
                                <div class="form-check">
                                    <input type="radio" class="form-check-input" name="diancam" value="1"
                                        {{ isset($gangguanJiwaAnak) && $gangguanJiwaAnak->diancam == 1 ? 'checked' : '' }}
                                        onclick="calculateTotalScore()" id="kadang">
                                    <label class="form-check-label" for="kadang">Kadang benar</label>
                                </div>
                                <div class="form-check ml-3">
                                    <input type="radio" class="form-check-input" name="diancam" value="0"
                                        {{ isset($gangguanJiwaAnak) && $gangguanJiwaAnak->diancam == 0 ? 'checked' : '' }}
                                        onclick="calculateTotalScore()" id="tidak">
                                    <label class="form-check-label" for="tidak">Tidak benar</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label>20. Sering menawarkan diri untuk membantu orang lain (orang tua, guru, anak-anak lain)
                                (Pro)?</label>
                            <div class="d-flex">
                                <div class="form-check mr-3">
                                    <input type="radio" class="form-check-input" name="suka_bantu" value="2"
                                        {{ isset($gangguanJiwaAnak) && $gangguanJiwaAnak->suka_bantu == 2 ? 'checked' : '' }}
                                        onclick="calculateTotalScore()" id="benar">
                                    <label class="form-check-label" for="benar">Selalu benar</label>
                                </div>
                                <div class="form-check">
                                    <input type="radio" class="form-check-input" name="suka_bantu" value="1"
                                        {{ isset($gangguanJiwaAnak) && $gangguanJiwaAnak->suka_bantu == 1 ? 'checked' : '' }}
                                        onclick="calculateTotalScore()" id="kadang">
                                    <label class="form-check-label" for="kadang">Kadang benar</label>
                                </div>
                                <div class="form-check ml-3">
                                    <input type="radio" class="form-check-input" name="suka_bantu" value="0"
                                        {{ isset($gangguanJiwaAnak) && $gangguanJiwaAnak->suka_bantu == 0 ? 'checked' : '' }}
                                        onclick="calculateTotalScore()" id="tidak">
                                    <label class="form-check-label" for="tidak">Tidak benar</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label>21. Sebelum melakukan sesuatu ia berfikir dahulu tentang akibatnya (H)?</label>
                            <div class="d-flex">
                                <div class="form-check mr-3">
                                    <input type="radio" class="form-check-input" name="kritis" value="0"
                                        onclick="calculateTotalScore()" id="benar"
                                        {{ isset($gangguanJiwaAnak->kritis) && $gangguanJiwaAnak->kritis == 0 ? 'checked' : '' }}>
                                    <label class="form-check-label" for="benar">Selalu benar</label>
                                </div>
                                <div class="form-check">
                                    <input type="radio" class="form-check-input" name="kritis" value="1"
                                        onclick="calculateTotalScore()" id="kadang"
                                        {{ isset($gangguanJiwaAnak->kritis) && $gangguanJiwaAnak->kritis == 1 ? 'checked' : '' }}>
                                    <label class="form-check-label" for="kadang">Kadang benar</label>
                                </div>
                                <div class="form-check ml-3">
                                    <input type="radio" class="form-check-input" name="kritis" value="2"
                                        onclick="calculateTotalScore()" id="tidak"
                                        {{ isset($gangguanJiwaAnak->kritis) && $gangguanJiwaAnak->kritis == 2 ? 'checked' : '' }}>
                                    <label class="form-check-label" for="tidak">Tidak benar</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label>22. Mencuri dari rumah, sekolah atau tempat lain (C)?</label>
                            <div class="d-flex">
                                <div class="form-check mr-3">
                                    <input type="radio" class="form-check-input" name="mencuri" value="2"
                                        onclick="calculateTotalScore()" id="benar"
                                        {{ isset($gangguanJiwaAnak->mencuri) && $gangguanJiwaAnak->mencuri == 2 ? 'checked' : '' }}>
                                    <label class="form-check-label" for="benar">Selalu benar</label>
                                </div>
                                <div class="form-check">
                                    <input type="radio" class="form-check-input" name="mencuri" value="1"
                                        onclick="calculateTotalScore()" id="kadang"
                                        {{ isset($gangguanJiwaAnak->mencuri) && $gangguanJiwaAnak->mencuri == 1 ? 'checked' : '' }}>
                                    <label class="form-check-label" for="kadang">Kadang benar</label>
                                </div>
                                <div class="form-check ml-3">
                                    <input type="radio" class="form-check-input" name="mencuri" value="0"
                                        onclick="calculateTotalScore()" id="tidak"
                                        {{ isset($gangguanJiwaAnak->mencuri) && $gangguanJiwaAnak->mencuri == 0 ? 'checked' : '' }}>
                                    <label class="form-check-label" for="tidak">Tidak benar</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label>23. Lebih mudah berteman dengan orang dewasa daripada dengan anak-anak lain (P)?</label>
                            <div class="d-flex">
                                <div class="form-check mr-3">
                                    <input type="radio" class="form-check-input" name="mudah_berteman" value="2"
                                        onclick="calculateTotalScore()" id="benar"
                                        {{ isset($gangguanJiwaAnak->mudah_berteman) && $gangguanJiwaAnak->mudah_berteman == 2 ? 'checked' : '' }}>
                                    <label class="form-check-label" for="benar">Selalu benar</label>
                                </div>
                                <div class="form-check">
                                    <input type="radio" class="form-check-input" name="mudah_berteman" value="1"
                                        onclick="calculateTotalScore()" id="kadang"
                                        {{ isset($gangguanJiwaAnak->mudah_berteman) && $gangguanJiwaAnak->mudah_berteman == 1 ? 'checked' : '' }}>
                                    <label class="form-check-label" for="kadang">Kadang benar</label>
                                </div>
                                <div class="form-check ml-3">
                                    <input type="radio" class="form-check-input" name="mudah_berteman" value="0"
                                        onclick="calculateTotalScore()" id="tidak"
                                        {{ isset($gangguanJiwaAnak->mudah_berteman) && $gangguanJiwaAnak->mudah_berteman == 0 ? 'checked' : '' }}>
                                    <label class="form-check-label" for="tidak">Tidak benar</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label>24. Banyak yang ditakuti, mudah menjadi takut (E)?</label>
                            <div class="d-flex">
                                <div class="form-check mr-3">
                                    <input type="radio" class="form-check-input" name="takut" value="2"
                                        onclick="calculateTotalScore()" id="benar"
                                        {{ isset($gangguanJiwaAnak->takut) && $gangguanJiwaAnak->takut == 2 ? 'checked' : '' }}>
                                    <label class="form-check-label" for="benar">Selalu benar</label>
                                </div>
                                <div class="form-check">
                                    <input type="radio" class="form-check-input" name="takut" value="1"
                                        onclick="calculateTotalScore()" id="kadang"
                                        {{ isset($gangguanJiwaAnak->takut) && $gangguanJiwaAnak->takut == 1 ? 'checked' : '' }}>
                                    <label class="form-check-label" for="kadang">Kadang benar</label>
                                </div>
                                <div class="form-check ml-3">
                                    <input type="radio" class="form-check-input" name="takut" value="0"
                                        onclick="calculateTotalScore()" id="tidak"
                                        {{ isset($gangguanJiwaAnak->takut) && $gangguanJiwaAnak->takut == 0 ? 'checked' : '' }}>
                                    <label class="form-check-label" for="tidak">Tidak benar</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label>25. Memiliki perhatian yang baik terhadap apapun, mampu menyelesaikan tugas atau
                                pekerjaan rumah sampai selesai (H)?</label>
                            <div class="d-flex">
                                <div class="form-check mr-3">
                                    <input type="radio" class="form-check-input" name="rajin" value="0"
                                        onclick="calculateTotalScore()" id="benar"
                                        {{ isset($gangguanJiwaAnak->rajin) && $gangguanJiwaAnak->rajin == 0 ? 'checked' : '' }}>
                                    <label class="form-check-label" for="benar">Selalu benar</label>
                                </div>
                                <div class="form-check">
                                    <input type="radio" class="form-check-input" name="rajin" value="1"
                                        onclick="calculateTotalScore()" id="kadang"
                                        {{ isset($gangguanJiwaAnak->rajin) && $gangguanJiwaAnak->rajin == 1 ? 'checked' : '' }}>
                                    <label class="form-check-label" for="kadang">Kadang benar</label>
                                </div>
                                <div class="form-check ml-3">
                                    <input type="radio" class="form-check-input" name="rajin" value="2"
                                        onclick="calculateTotalScore()" id="tidak"
                                        {{ isset($gangguanJiwaAnak->rajin) && $gangguanJiwaAnak->rajin == 2 ? 'checked' : '' }}>
                                    <label class="form-check-label" for="tidak">Tidak benar</label>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>



            </div>
        </div>
        <div class="form-group mt-4">

            <label for="kesimpulan" style="color: rgb(19, 11, 241);">Kesimpulan</label>
            <textarea class="form-control" id="kesimpulan" name="kesimpulan" placeholder="Kesimpulan">{{ old('kesimpulan', $gangguanJiwaAnak->kesimpulan ?? '') }}</textarea>
            <br>
            <label>Skor Total</label>
            <div class="d-flex">
                <input type="text" class="form-control" id="totalScore" value="0"
                    onclick="calculateTotalScore()" disabled>
            </div>
        </div>

        <img src="{{ asset('assets/images/hasil_sdq.png') }}" class="img-fluid mx-auto d-block">
        <div class="text-right mt-4">
            {{-- @if (isset($gangguanJiwaAnak) && $gangguanJiwaAnak)
                <a href="{{ route('sdq.mtbs.admin') }}" type="button" class="btn btn-secondary mr-2"
                    style="font-size: 20px">Kembali</a>
            @else
                <a href="{{ route('skrining.ilp') }}" type="button" class="btn btn-secondary mr-2"
                    style="font-size: 20px">Kembali</a>
            @endif --}}
            <button type="submit" class="btn btn-primary" style="font-size: 20px">Kirim</button>
        </div>


    </form>
    <script>
        function calculateTotalScore() {
            let totalScore = 0;

            document.querySelectorAll('.form-check-input:checked').forEach((input) => {
                let value = parseInt(input.value);
                if (!isNaN(value)) {
                    totalScore += value;
                }
            });

            document.getElementById('totalScore').value = totalScore;
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
                calculateTotalScore();
            });
            $('#pasien').trigger('change');
        });
    </script>
@endsection
