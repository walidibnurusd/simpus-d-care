@extends('layouts.skrining.master')
@section('title', 'Skrining Tes Daya Dengar')
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
        action="{{ isset($testPendengaran) ? route('testPendengaran.mtbs.update', $testPendengaran->id) : route('testPendengaran.mtbs.store') }}"
        method="POST">
        @csrf
        @if (isset($testPendengaran))
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
                                    {{ old('pasien', $testPendengaran->pasien ?? '') == $item->id ? 'selected' : '' }}>
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
                        <input type="date" readonly class="form-control" name="tanggal" id="tanggal_lahir"
                            value="{{ old('tanggal', $testPendengaran->tanggal ?? '') }}">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Jenis Kelamin</label>
                        <div class="d-flex">
                            <div class="form-check mr-3">
                                <input type="radio" class="form-check-input" name="jenis_kelamin" value="laki-laki"
                                    id="jk_laki" id="laki-laki"
                                    {{ old('jenis_kelamin', $testPendengaran->jenis_kelamin ?? '') == 'laki-laki' ? 'checked' : '' }}>
                                <label class="form-check-label" for="laki-laki">Laki-laki</label>
                            </div>
                            <div class="form-check">
                                <input type="radio" class="form-check-input" name="jenis_kelamin" value="perempuan"
                                    id="jk_perempuan" id="perempuan"
                                    {{ old('jenis_kelamin', $testPendengaran->jenis_kelamin ?? '') == 'perempuan' ? 'checked' : '' }}>
                                <label class="form-check-label" for="perempuan">Perempuan</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Usia</label>
                        <div class="d-flex">
                            <div class="form-check mr-3">
                                <input type="radio" class="form-check-input" name="usia"
                                    value="0"onclick="toggleSection(this.value)" id="tidakPernah"
                                    {{ old('usia', $testPendengaran->usia ?? '') == 0 ? 'checked' : '' }}>
                                <label class="form-check-label" for="tidakPernah">
                                    < 3 Bulan </label>
                            </div>
                            <div class="form-check">
                                <input type="radio" class="form-check-input" name="usia" value="1" id="ya"
                                    onclick="toggleSection(this.value)"
                                    {{ old('usia', $testPendengaran->usia ?? '') == 1 ? 'checked' : '' }}>
                                <label class="form-check-label" for="usia50"> > 3 bulan dan < 6 Bulan </label>
                            </div>
                            <div class="form-check ml-3">
                                <input type="radio" onclick="toggleSection(this.value)" class="form-check-input"
                                    name="usia" value="2" id="ya"
                                    {{ old('usia', $testPendengaran->usia ?? '') == 2 ? 'checked' : '' }}>
                                <label class="form-check-label" for="ya"> > 6 bulan dan < 12 Bulan </label>
                            </div>
                            <div class="form-check ml-3">
                                <input type="radio" onclick="toggleSection(this.value)" class="form-check-input"
                                    name="usia" value="3" id="ya"
                                    {{ old('usia', $testPendengaran->usia ?? '') == 3 ? 'checked' : '' }}>
                                <label class="form-check-label" for="ya"> > 12 bulan dan < 18 Bulan </label>
                            </div>
                            <div class="form-check ml-3">
                                <input type="radio" onclick="toggleSection(this.value)" class="form-check-input"
                                    name="usia" value="4" id="ya"
                                    {{ old('usia', $testPendengaran->usia ?? '') == 4 ? 'checked' : '' }}>
                                <label class="form-check-label" for="ya"> > 18 bulan dan < 24 Bulan </label>
                            </div>
                            <div class="form-check ml-3">
                                <input type="radio" onclick="toggleSection(this.value)" class="form-check-input"
                                    name="usia" value="5" id="ya"
                                    {{ old('usia', $testPendengaran->usia ?? '') == 5 ? 'checked' : '' }}>
                                <label class="form-check-label" for="ya"> > 24 bulan dan < 30 Bulan </label>
                            </div>
                            <div class="form-check ml-3">
                                <input type="radio" onclick="toggleSection(this.value)" class="form-check-input"
                                    name="usia" value="6" id="ya"
                                    {{ old('usia', $testPendengaran->usia ?? '') == 6 ? 'checked' : '' }}>
                                <label class="form-check-label" for="ya"> > 30 bulan dan < 36 Bulan </label>
                            </div>
                            <div class="form-check ml-3">
                                <input type="radio" onclick="toggleSection(this.value)" class="form-check-input"
                                    name="usia" value="7" id="ya"
                                    {{ old('usia', $testPendengaran->usia ?? '') == 7 ? 'checked' : '' }}>
                                <label class="form-check-label" for="ya"> > 36 bulan dan < 6 Tahun </label>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Tanda dan Gejala Anemia Section -->
            <div class="form-section mt-4" id="sectionKurangDariTiga" style="display: none;">
                <h3>Umur Kurang atau Sampai 3 Bulan</h3>
                <h4>Kemampuan Ekspresif</h4>
                <div class="form-group">
                    <label>1. Apakah bayi dapat mengatakan “Aaaaa,Oooo”?</label>
                    <input type="hidden" name="ekspresif[question1]"
                        value="1. Apakah bayi dapat mengatakan “Aaaaa,Oooo”?">
                    <div class="d-flex">
                        <div class="form-check mr-3">
                            <input type="radio" class="form-check-input" name="ekspresif[answer1]" value="1"
                                id="ekspresif_ya"
                                {{ isset($testPendengaran->ekspresif['answer1']) && $testPendengaran->ekspresif['answer1'] == '1' ? 'checked' : (old('ekspresif.answer1') == '1' ? 'checked' : '') }}>
                            <label class="form-check-label" for="ekspresif_ya">Ya</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="ekspresif[answer1]" value="0"
                                id="ekspresif_tidak"
                                {{ isset($testPendengaran->ekspresif['answer1']) && $testPendengaran->ekspresif['answer1'] == '0' ? 'checked' : (old('ekspresif.answer1') == '0' ? 'checked' : '') }}>
                            <label class="form-check-label" for="ekspresif_tidak">Tidak</label>
                        </div>
                    </div>
                </div>


                <div class="form-group">
                    <label>2. Apakah bayi menatap wajah dan tampak mendengarkan Anda, lalu berbicara saat Anda diam?</label>
                    <input type="hidden" name="ekspresif[question11]"
                        value="2. Apakah bayi menatap wajah dan tampak mendengarkan Anda, lalu berbicara saat Anda diam?">
                    <div class="d-flex">
                        <div class="form-check mr-3">
                            <input type="radio" class="form-check-input" name="ekspresif[answer11]" value="1"
                                id="ekspresif_ya"
                                {{ isset($testPendengaran->ekspresif['answer11']) && $testPendengaran->ekspresif['answer11'] == '1' ? 'checked' : (old('ekspresif.answer11') == '1' ? 'checked' : '') }}>
                            <label class="form-check-label" for="ekspresif_ya">Ya</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="ekspresif[answer11]" value="0"
                                id="ekspresif_tidak"
                                {{ isset($testPendengaran->ekspresif['answer11']) && $testPendengaran->ekspresif['answer11'] == '0' ? 'checked' : (old('ekspresif.answer11') == '0' ? 'checked' : '') }}>
                            <label class="form-check-label" for="ekspresif_tidak">Tidak</label>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label>3. Apakah Anda dapat seolah-olah berbicara dengan bayi Anda?</label>
                    <input type="hidden" name="3. Apakah Anda dapat seolah-olah berbicara dengan bayi Anda?">
                    <div class="d-flex">
                        <div class="form-check mr-3">
                            <input type="radio" class="form-check-input" name="ekspresif[answer111]" value="1"
                                id="ekspresif_ya"
                                {{ isset($testPendengaran->ekspresif['answer111']) && $testPendengaran->ekspresif['answer111'] == '1' ? 'checked' : (old('ekspresif.answer111') == '1' ? 'checked' : '') }}>
                            <label class="form-check-label" for="ekspresif_ya">Ya</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="ekspresif[answer111]" value="0"
                                id="ekspresif_tidak"
                                {{ isset($testPendengaran->ekspresif['answer111']) && $testPendengaran->ekspresif['answer111'] == '0' ? 'checked' : (old('ekspresif.answer111') == '0' ? 'checked' : '') }}>
                            <label class="form-check-label" for="ekspresif_tidak">Tidak</label>
                        </div>
                    </div>

                </div>
                <h4>Kemampuan Reseptif</h4>
                <div class="form-group">
                    <label>1. Apakah bayi kaget bila mendengar suar (mengejapkan mata, napas lebih cepat)?</label>
                    <input type="hidden" name="reseptif[question1]"
                        value="1. Apakah bayi kaget bila mendengar suar (mengejapkan mata, napas lebih cepat)?">
                    <div class="d-flex">
                        <div class="form-check mr-3">
                            <input type="radio" class="form-check-input" name="reseptif[answer1]" value="1"
                                id="ekspresif_ya"
                                {{ isset($testPendengaran->reseptif['answer1']) && $testPendengaran->reseptif['answer1'] == '1' ? 'checked' : (old('reseptif.answer1') == '1' ? 'checked' : '') }}>
                            <label class="form-check-label" for="ekspresif_ya">Ya</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="reseptif[answer1]" value="0"
                                id="ekspresif_tidak"
                                {{ isset($testPendengaran->reseptif['answer1']) && $testPendengaran->reseptif['answer1'] == '0' ? 'checked' : (old('reseptif.answer1') == '0' ? 'checked' : '') }}>
                            <label class="form-check-label" for="ekspresif_tidak">Tidak</label>
                        </div>
                    </div>
                </div>


                <div class="form-group">
                    <label>2. Apakah bayi kelihatan menoleh bila Anda berbicara di sebelahnya?</label>
                    <input type="hidden" name="reseptif[question11]"
                        value="2. Apakah bayi kelihatan menoleh bila Anda berbicara di sebelahnya?">
                    <div class="d-flex">
                        <div class="form-check mr-3">
                            <input type="radio" class="form-check-input" name="reseptif[answer11]" value="1"
                                id="ekspresif_ya"
                                {{ isset($testPendengaran->reseptif['answer11']) && $testPendengaran->reseptif['answer11'] == '1' ? 'checked' : (old('reseptif.answer11') == '1' ? 'checked' : '') }}>
                            <label class="form-check-label" for="ekspresif_ya">Ya</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="reseptif[answer11]" value="0"
                                id="ekspresif_tidak"
                                {{ isset($testPendengaran->reseptif['answer11']) && $testPendengaran->reseptif['answer11'] == '0' ? 'checked' : (old('reseptif.answer11') == '0' ? 'checked' : '') }}>
                            <label class="form-check-label" for="ekspresif_tidak">Tidak</label>
                        </div>
                    </div>
                </div>
                <h4>Kemampuan Visual</h4>
                <div class="form-group">
                    <label>1. Apakah bayi Anda dapat tersenyum?</label>
                    <input type="hidden" name="visual[question1]" value="1. Apakah bayi Anda dapat tersenyum?">
                    <div class="d-flex">
                        <div class="form-check mr-3">
                            <input type="radio" class="form-check-input" name="visual[answer1]" value="1"
                                id="ekspresif_ya"
                                {{ isset($testPendengaran->visual['answer1']) && $testPendengaran->visual['answer1'] == '1' ? 'checked' : (old('visual.answer1') == '1' ? 'checked' : '') }}>
                            <label class="form-check-label" for="ekspresif_ya">Ya</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="visual[answer1]" value="0"
                                id="ekspresif_tidak"
                                {{ isset($testPendengaran->visual['answer1']) && $testPendengaran->visual['answer1'] == '0' ? 'checked' : (old('visual.answer1') == '0' ? 'checked' : '') }}>
                            <label class="form-check-label" for="ekspresif_tidak">Tidak</label>
                        </div>
                    </div>
                </div>


                <div class="form-group">
                    <label>2. Apakah bayi Anda kenal dengan Anda, seperti tersenyum lebih cepat pada Anda dibandingkan orang
                        lain?</label>
                    <input type="hidden" name="visual[question11]"
                        value="2. Apakah bayi Anda kenal dengan Anda, seperti tersenyum lebih cepat pada Anda dibandingkan orang lain?">
                    <div class="d-flex">
                        <div class="form-check mr-3">
                            <input type="radio" class="form-check-input" name="visual[answer11]" value="1"
                                id="ekspresif_ya"
                                {{ isset($testPendengaran->visual['answer11']) && $testPendengaran->visual['answer11'] == '1' ? 'checked' : (old('visual.answer11') == '1' ? 'checked' : '') }}>
                            <label class="form-check-label" for="ekspresif_ya">Ya</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="visual[answer11]" value="0"
                                id="ekspresif_tidak"
                                {{ isset($testPendengaran->visual['answer11']) && $testPendengaran->visual['answer11'] == '0' ? 'checked' : (old('visual.answer11') == '0' ? 'checked' : '') }}>
                            <label class="form-check-label" for="ekspresif_tidak">Tidak</label>
                        </div>
                    </div>
                </div>


            </div>

            <div class="form-section mt-4" id="sectionTigaHinggaEnam" style="display: none;">
                <h3>Umur lebih dari 3 bulan sampai 6 bulan</h3>
                <h4>Kemampuan Ekspresif</h4>
                <div class="form-group">
                    <label>1. Apakah bayi Anda dapat tertawa keras?</label>
                    <input type="hidden" name="ekspresif[question2]" value="1. Apakah bayi Anda dapat tertawa keras?">
                    <div class="d-flex">
                        <div class="form-check mr-3">
                            <input type="radio" class="form-check-input" name="ekspresif[answer2]" value="1"
                                id="ekspresif_ya"
                                {{ isset($testPendengaran->ekspresif['answer2']) && $testPendengaran->ekspresif['answer2'] == '1' ? 'checked' : (old('ekspresif.answer2') == '1' ? 'checked' : '') }}>
                            <label class="form-check-label" for="ekspresif_ya">Ya</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="ekspresif[answer2]" value="0"
                                id="ekspresif_tidak"
                                {{ isset($testPendengaran->ekspresif['answer2']) && $testPendengaran->ekspresif['answer2'] == '0' ? 'checked' : (old('ekspresif.answer2') == '0' ? 'checked' : '') }}>
                            <label class="form-check-label" for="ekspresif_tidak">Tidak</label>
                        </div>
                    </div>
                </div>


                <div class="form-group">
                    <label>2. Apakah bayi dapat bermain menggelembungkan mulut seperti meniup balon?</label>
                    <input type="hidden" name="ekspresif[question22]"
                        value="2. Apakah bayi dapat bermain menggelembungkan mulut seperti meniup balon?">
                    <div class="d-flex">
                        <div class="form-check mr-3">
                            <input type="radio" class="form-check-input" name="ekspresif[answer22]" value="1"
                                id="ekspresif_ya"
                                {{ isset($testPendengaran->ekspresif['answer22']) && $testPendengaran->ekspresif['answer22'] == '1' ? 'checked' : (old('ekspresif.answer22') == '1' ? 'checked' : '') }}>
                            <label class="form-check-label" for="ekspresif_ya">Ya</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="ekspresif[answer22]" value="0"
                                id="ekspresif_tidak"
                                {{ isset($testPendengaran->ekspresif['answer22']) && $testPendengaran->ekspresif['answer22'] == '0' ? 'checked' : (old('ekspresif.answer22') == '0' ? 'checked' : '') }}>
                            <label class="form-check-label" for="ekspresif_tidak">Tidak</label>
                        </div>
                    </div>
                </div>


                <h4>Kemampuan Reseptif</h4>
                <div class="form-group">
                    <label>1. Apakah bayi dapat memberi respon tertentu, seperti menjadi lebih riang bila Anda
                        datang?</label>
                    <input type="hidden" name="reseptif[question2]"
                        value="1. Apakah bayi dapat memberi respon tertentu, seperti menjadi lebih riang bila Anda datang?">
                    <div class="d-flex">
                        <div class="form-check mr-3">
                            <input type="radio" class="form-check-input" name="reseptif[answer2]" value="1"
                                id="ekspresif_ya"
                                {{ isset($testPendengaran->reseptif['answer2']) && $testPendengaran->reseptif['answer2'] == '1' ? 'checked' : (old('reseptif.answer2') == '1' ? 'checked' : '') }}>
                            <label class="form-check-label" for="ekspresif_ya">Ya</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="reseptif[answer2]" value="0"
                                id="ekspresif_tidak"
                                {{ isset($testPendengaran->reseptif['answer2']) && $testPendengaran->reseptif['answer2'] == '0' ? 'checked' : (old('reseptif.answer2') == '0' ? 'checked' : '') }}>
                            <label class="form-check-label" for="ekspresif_tidak">Tidak</label>
                        </div>
                    </div>
                </div>


                <div class="form-group">
                    <label>2. Pemeriksa duduk menghadap bayi yang dipangku orang tuanya, bunyikan bel disamping tanpa
                        terlihat bayi, Apakah bayi itu menoleh ke samping?</label>
                    <input type="hidden" name="reseptif[question22]"
                        value="2. Pemeriksa duduk menghadap bayi yang dipangku orang tuanya, bunyikan bel disamping tanpa terlihat bayi, Apakah bayi itu menoleh ke samping?">
                    <div class="d-flex">
                        <div class="form-check mr-3">
                            <input type="radio" class="form-check-input" name="reseptif[answer22]" value="1"
                                id="ekspresif_ya"
                                {{ isset($testPendengaran->reseptif['answer22']) && $testPendengaran->reseptif['answer22'] == '1' ? 'checked' : (old('reseptif.answer22') == '1' ? 'checked' : '') }}>
                            <label class="form-check-label" for="ekspresif_ya">Ya</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="reseptif[answer22]" value="0"
                                id="ekspresif_tidak"
                                {{ isset($testPendengaran->reseptif['answer22']) && $testPendengaran->reseptif['answer22'] == '0' ? 'checked' : (old('reseptif.answer22') == '0' ? 'checked' : '') }}>
                            <label class="form-check-label" for="ekspresif_tidak">Tidak</label>
                        </div>
                    </div>
                </div>
                <h4>Kemampuan Visual</h4>
                <div class="form-group">
                    <label>1. Pemeriksa menatap mata bayi sekitar 45 cm, lalu gunakan mainan untuk menarik pandangan bayi ke
                        kiri, kanan, atas, dan
                        bawah, Apakah bayi dapat menikutinya?</label>
                    <input type="hidden" name="visual[question2]"
                        value="1. Pemeriksa menatap mata bayi sekitar 45 cm, lalu gunakan mainan untuk menarik pandangan bayi ke kiri, kanan, atas, dan
                        bawah, Apakah bayi dapat menikutinya?">
                    <div class="d-flex">
                        <div class="form-check mr-3">
                            <input type="radio" class="form-check-input" name="visual[answer2]" value="1"
                                id="ekspresif_ya"
                                {{ isset($testPendengaran->visual['answer2']) && $testPendengaran->visual['answer2'] == '1' ? 'checked' : (old('visual.answer2') == '1' ? 'checked' : '') }}>
                            <label class="form-check-label" for="ekspresif_ya">Ya</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="visual[answer2]" value="0"
                                id="ekspresif_tidak"
                                {{ isset($testPendengaran->visual['answer2']) && $testPendengaran->visual['answer2'] == '0' ? 'checked' : (old('visual.answer2') == '0' ? 'checked' : '') }}>
                            <label class="form-check-label" for="ekspresif_tidak">Tidak</label>
                        </div>
                    </div>
                </div>


                <div class="form-group">
                    <label>2. Apakah bayi berkedip bila pemeriksa melakukan gerakan menusuk mata, lalu berhenti sekitar 3 cm
                        tanpa menyentuh
                        mata?</label>
                    <input type="hidden" name="visual[question22]"
                        value="2. Apakah bayi berkedip bila pemeriksa melakukan gerakan menusuk mata, lalu berhenti sekitar 3 cm tanpa menyentuh mata?">
                    <div class="d-flex">
                        <div class="form-check mr-3">
                            <input type="radio" class="form-check-input" name="visual[answer22]" value="1"
                                id="ekspresif_ya"
                                {{ isset($testPendengaran->visual['answer22']) && $testPendengaran->visual['answer22'] == '1' ? 'checked' : (old('visual.answer22') == '1' ? 'checked' : '') }}>
                            <label class="form-check-label" for="ekspresif_ya">Ya</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="visual[answer22]" value="0"
                                id="ekspresif_tidak"
                                {{ isset($testPendengaran->visual['answer22']) && $testPendengaran->visual['answer22'] == '0' ? 'checked' : (old('visual.answer22') == '0' ? 'checked' : '') }}>
                            <label class="form-check-label" for="ekspresif_tidak">Tidak</label>
                        </div>
                    </div>
                </div>


            </div>
            <div class="form-section mt-4" id="sectionEnamSampaiDuabelas" style="display: none;">
                <h3>Umur lebih dari 3 bulan sampai 12 bulan</h3>
                <h4>Kemampuan Ekspresif</h4>
                <div class="form-group">
                    <label>1. Apakah bayi dapat membuat suara berulang seperti “mamamama”, “babababa”?</label>
                    <input type="hidden" name="ekspresif[question3]"
                        value="1. Apakah bayi dapat membuat suara berulang seperti “mamamama”, “babababa”?">
                    <div class="d-flex">
                        <div class="form-check mr-3">
                            <input type="radio" class="form-check-input" name="ekspresif[answer3]" value="1"
                                id="ekspresif_ya"
                                {{ isset($testPendengaran->ekspresif['answer3']) && $testPendengaran->ekspresif['answer3'] == '1' ? 'checked' : (old('ekspresif.answer3') == '1' ? 'checked' : '') }}>
                            <label class="form-check-label" for="ekspresif_ya">Ya</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="ekspresif[answer3]" value="0"
                                id="ekspresif_tidak"
                                {{ isset($testPendengaran->ekspresif['answer3']) && $testPendengaran->ekspresif['answer3'] == '0' ? 'checked' : (old('ekspresif.answer3') == '0' ? 'checked' : '') }}>
                            <label class="form-check-label" for="ekspresif_tidak">Tidak</label>
                        </div>
                    </div>
                </div>


                <div class="form-group">
                    <label>2. Apakah bayi dapat memanggil mama atau papa, walaupun tidak untuk memanggil orang
                        tuanya?</label>
                    <input type="hidden" name="ekspresif[question33]"
                        value="2. Apakah bayi dapat memanggil mama atau papa, walaupun tidak untuk memanggil orang tuanya?">
                    <div class="d-flex">
                        <div class="form-check mr-3">
                            <input type="radio" class="form-check-input" name="ekspresif[answer33]" value="1"
                                id="ekspresif_ya"
                                {{ isset($testPendengaran->ekspresif['answer33']) && $testPendengaran->ekspresif['answer33'] == '1' ? 'checked' : (old('ekspresif.answer33') == '1' ? 'checked' : '') }}>
                            <label class="form-check-label" for="ekspresif_ya">Ya</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="ekspresif[answer33]" value="0"
                                id="ekspresif_tidak"
                                {{ isset($testPendengaran->ekspresif['answer33']) && $testPendengaran->ekspresif['answer33'] == '0' ? 'checked' : (old('ekspresif.answer33') == '0' ? 'checked' : '') }}>
                            <label class="form-check-label" for="ekspresif_tidak">Tidak</label>
                        </div>
                    </div>
                </div>


                <h4>Kemampuan Reseptif</h4>
                <div class="form-group">
                    <label>1.Anak dapat menunjukkan paling sedikit 1 anggota badan, missal” mana hidungmu?”, “mana matamu?”
                        tanpa diberi contoh</label>
                    <input type="hidden" name="reseptif[question3]"
                        value="1. Pemeriksa duduk menghadap bayi yang dipangku orang tuanya, bunyikan bel di samping bawah tanpa terlihat bayi,Apakah bayi langsung menoleh ke samping bawah?">
                    <div class="d-flex">
                        <div class="form-check mr-3">
                            <input type="radio" class="form-check-input" name="reseptif[answer3]" value="1"
                                id="ekspresif_ya"
                                {{ isset($testPendengaran->reseptif['answer3']) && $testPendengaran->reseptif['answer3'] == '1' ? 'checked' : (old('reseptif.answer3') == '1' ? 'checked' : '') }}>
                            <label class="form-check-label" for="ekspresif_ya">Ya</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="reseptif[answer3]" value="0"
                                id="ekspresif_tidak"
                                {{ isset($testPendengaran->reseptif['answer3']) && $testPendengaran->reseptif['answer3'] == '0' ? 'checked' : (old('reseptif.answer3') == '0' ? 'checked' : '') }}>
                            <label class="form-check-label" for="ekspresif_tidak">Tidak</label>
                        </div>
                    </div>
                </div>


                <div class="form-group">
                    <label>2. Apakah anak mengikuti perintah tanpa dibantu gerakan badan, seperti “stop, berikan
                        mainanmu”?</label>
                    <input type="hidden" name="reseptif[question33]"
                        value="2. Apakah anak mengikuti perintah tanpa dibantu gerakan badan, seperti “stop, berikan mainanmu”?">
                    <div class="d-flex">
                        <div class="form-check mr-3">
                            <input type="radio" class="form-check-input" name="reseptif[answer33]" value="1"
                                id="ekspresif_ya"
                                {{ isset($testPendengaran->reseptif['answer33']) && $testPendengaran->reseptif['answer33'] == '1' ? 'checked' : (old('reseptif.answer33') == '1' ? 'checked' : '') }}>
                            <label class="form-check-label" for="ekspresif_ya">Ya</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="reseptif[answer33]" value="0"
                                id="ekspresif_tidak"
                                {{ isset($testPendengaran->reseptif['answer33']) && $testPendengaran->reseptif['answer33'] == '0' ? 'checked' : (old('reseptif.answer33') == '0' ? 'checked' : '') }}>
                            <label class="form-check-label" for="ekspresif_tidak">Tidak</label>
                        </div>
                    </div>
                </div>
                <h4>Kemampuan Visual</h4>
                <div class="form-group">
                    <label>1. Apakah bayi mengikuti perintah dengan dibantu gerakan badan, seperti “stop, berikan
                        mainanmu”?</label>
                    <input type="hidden" name="visual[question3]"
                        value="1. Apakah bayi mengikuti perintah dengan dibantu gerakan badan, seperti “stop, berikan mainanmu”?">
                    <div class="d-flex">
                        <div class="form-check mr-3">
                            <input type="radio" class="form-check-input" name="visual[answer3]" value="1"
                                id="ekspresif_ya"
                                {{ isset($testPendengaran->visual['answer3']) && $testPendengaran->visual['answer3'] == '1' ? 'checked' : (old('visual.answer3') == '1' ? 'checked' : '') }}>
                            <label class="form-check-label" for="ekspresif_ya">Ya</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="visual[answer3]" value="0"
                                id="ekspresif_tidak"
                                {{ isset($testPendengaran->visual['answer3']) && $testPendengaran->visual['answer3'] == '0' ? 'checked' : (old('visual.answer3') == '0' ? 'checked' : '') }}>
                            <label class="form-check-label" for="ekspresif_tidak">Tidak</label>
                        </div>
                    </div>
                </div>


                <div class="form-group">
                    <label>2. Apakah bayi secara spontan memulai permainan dengan gerakan tubuh, seperti”po kame-ame” atau
                        “cilukba”</label>
                    <input type="hidden" name="visual[question33]"
                        value="2. Apakah bayi secara spontan memulai permainan dengan gerakan tubuh, seperti”po kame-ame” atau “cilukba”">
                    <div class="d-flex">
                        <div class="form-check mr-3">
                            <input type="radio" class="form-check-input" name="visual[answer33]" value="1"
                                id="ekspresif_ya"
                                {{ isset($testPendengaran->visual['answer33']) && $testPendengaran->visual['answer33'] == '1' ? 'checked' : (old('visual.answer33') == '1' ? 'checked' : '') }}>
                            <label class="form-check-label" for="ekspresif_ya">Ya</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="visual[answer33]" value="0"
                                id="ekspresif_tidak"
                                {{ isset($testPendengaran->visual['answer33']) && $testPendengaran->visual['answer33'] == '0' ? 'checked' : (old('visual.answer33') == '0' ? 'checked' : '') }}>
                            <label class="form-check-label" for="ekspresif_tidak">Tidak</label>
                        </div>
                    </div>
                </div>


            </div>
            <div class="form-section mt-4" id="sectionDuabelasSampaiDelapanBelas" style="display: none;">
                <h3>Umur lebih dari 12 bulan sampai 18 bulan</h3>
                <h4>Kemampuan Ekspresif</h4>
                <div class="form-group">
                    <label>1. Apakah anak dapat memanggil mama atau papa, hanya untuk memanggil orang tuanya?</label>
                    <input type="hidden" name="ekspresif[question4]"
                        value="1. Apakah anak dapat memanggil mama atau papa, hanya untuk memanggil orang tuanya?">
                    <div class="d-flex">
                        <div class="form-check mr-3">
                            <input type="radio" class="form-check-input" name="ekspresif[answer4]" value="1"
                                id="ekspresif_ya"
                                {{ isset($testPendengaran->ekspresif['answer4']) && $testPendengaran->ekspresif['answer4'] == '1' ? 'checked' : (old('ekspresif.answer4') == '1' ? 'checked' : '') }}>
                            <label class="form-check-label" for="ekspresif_ya">Ya</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="ekspresif[answer4]" value="0"
                                id="ekspresif_tidak"
                                {{ isset($testPendengaran->ekspresif['answer4']) && $testPendengaran->ekspresif['answer4'] == '0' ? 'checked' : (old('ekspresif.answer4') == '0' ? 'checked' : '') }}>
                            <label class="form-check-label" for="ekspresif_tidak">Tidak</label>
                        </div>
                    </div>
                </div>


                <div class="form-group">
                    <label>2. Apakah anak memulai menggunakan kata-kata lain, selain kata mama, anggota keluarga lain &
                        hewan peliharaan?</label>
                    <input type="hidden" name="ekspresif[question44]"
                        value="2. Apakah anak memulai menggunakan kata-kata lain, selain kata mama, anggota keluarga lain & hewan peliharaan?">
                    <div class="d-flex">
                        <div class="form-check mr-3">
                            <input type="radio" class="form-check-input" name="ekspresif[answer44]" value="1"
                                id="ekspresif_ya"
                                {{ isset($testPendengaran->ekspresif['answer44']) && $testPendengaran->ekspresif['answer44'] == '1' ? 'checked' : (old('ekspresif.answer44') == '1' ? 'checked' : '') }}>
                            <label class="form-check-label" for="ekspresif_ya">Ya</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="ekspresif[answer44]" value="0"
                                id="ekspresif_tidak"
                                {{ isset($testPendengaran->ekspresif['answer44']) && $testPendengaran->ekspresif['answer44'] == '0' ? 'checked' : (old('ekspresif.answer44') == '0' ? 'checked' : '') }}>
                            <label class="form-check-label" for="ekspresif_tidak">Tidak</label>
                        </div>
                    </div>
                </div>


                <h4>Kemampuan Reseptif</h4>
                <div class="form-group">
                    <label>1. Pemeriksa duduk menghadap bayi yang dipangku orang tuanya, bunyikan bel di samping bawah tanpa
                        terlihat bayi,
                        Apakah bayi langsung menoleh ke samping bawah?</label>
                    <input type="hidden" name="reseptif[question4]"
                        value="1. Pemeriksa duduk menghadap bayi yang dipangku orang tuanya, bunyikan bel di samping bawah tanpa terlihat bayi, Apakah bayi langsung menoleh ke samping bawah?">
                    <div class="d-flex">
                        <div class="form-check mr-3">
                            <input type="radio" class="form-check-input" name="reseptif[answer4]" value="1"
                                id="ekspresif_ya"
                                {{ isset($testPendengaran->reseptif['answer4']) && $testPendengaran->reseptif['answer4'] == '1' ? 'checked' : (old('reseptif.answer4') == '1' ? 'checked' : '') }}>
                            <label class="form-check-label" for="ekspresif_ya">Ya</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="reseptif[answer4]" value="0"
                                id="ekspresif_tidak"
                                {{ isset($testPendengaran->reseptif['answer4']) && $testPendengaran->reseptif['answer4'] == '0' ? 'checked' : (old('reseptif.answer4') == '0' ? 'checked' : '') }}>
                            <label class="form-check-label" for="ekspresif_tidak">Tidak</label>
                        </div>
                    </div>
                </div>


                <div class="form-group">
                    <label>2. Apakah anak mengikuti perintah tanpa dibantu gerakan badan, seperti”stop, berikan
                        mainanmu”?</label>
                    <input type="hidden" name="reseptif[question44]"
                        value="2. Apakah anak mengikuti perintah tanpa dibantu gerakan badan, seperti”stop, berikan mainanmu”?">
                    <div class="d-flex">
                        <div class="form-check mr-3">
                            <input type="radio" class="form-check-input" name="reseptif[answer44]" value="1"
                                id="ekspresif_ya"
                                {{ isset($testPendengaran->reseptif['answer44']) && $testPendengaran->reseptif['answer44'] == '1' ? 'checked' : (old('reseptif.answer44') == '1' ? 'checked' : '') }}>
                            <label class="form-check-label" for="ekspresif_ya">Ya</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="reseptif[answer44]" value="0"
                                id="ekspresif_tidak"
                                {{ isset($testPendengaran->reseptif['answer44']) && $testPendengaran->reseptif['answer44'] == '0' ? 'checked' : (old('reseptif.answer44') == '0' ? 'checked' : '') }}>
                            <label class="form-check-label" for="ekspresif_tidak">Tidak</label>
                        </div>
                    </div>
                </div>
                <h4>Kemampuan Visual</h4>
                <div class="form-group">
                    <label>1. Apakah anak secara spontan memulai permainan dengan gerakan tubuh, seperti “pok kame-ame” atau
                        “cilukba”?</label>
                    <input type="hidden" name="visual[question4]"
                        value="1. Apakah anak secara spontan memulai permainan dengan gerakan tubuh, seperti “pok kame-ame” atau “cilukba”?">
                    <div class="d-flex">
                        <div class="form-check mr-3">
                            <input type="radio" class="form-check-input" name="visual[answer4]" value="1"
                                id="ekspresif_ya"
                                {{ isset($testPendengaran->visual['answer4']) && $testPendengaran->visual['answer4'] == '1' ? 'checked' : (old('visual.answer4') == '1' ? 'checked' : '') }}>
                            <label class="form-check-label" for="ekspresif_ya">Ya</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="visual[answer4]" value="0"
                                id="ekspresif_tidak"
                                {{ isset($testPendengaran->visual['answer4']) && $testPendengaran->visual['answer4'] == '0' ? 'checked' : (old('visual.answer4') == '0' ? 'checked' : '') }}>
                            <label class="form-check-label" for="ekspresif_tidak">Tidak</label>
                        </div>
                    </div>
                </div>


                <div class="form-group">
                    <label>2. Apakah anak Anda menunjuk dengan jari telunjuk bila ingin sesuatu, bukan degan cara memegang
                        dengan semua jari?</label>
                    <input type="hidden" name="visual[question44]"
                        value="2. Apakah anak Anda menunjuk dengan jari telunjuk bila ingin sesuatu, bukan degan cara memegang dengan semua jari?">
                    <div class="d-flex">
                        <div class="form-check mr-3">
                            <input type="radio" class="form-check-input" name="visual[answer44]" value="1"
                                id="ekspresif_ya"
                                {{ isset($testPendengaran->visual['answer44']) && $testPendengaran->visual['answer44'] == '1' ? 'checked' : (old('visual.answer44') == '1' ? 'checked' : '') }}>
                            <label class="form-check-label" for="ekspresif_ya">Ya</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="visual[answer44]" value="0"
                                id="ekspresif_tidak"
                                {{ isset($testPendengaran->visual['answer44']) && $testPendengaran->visual['answer44'] == '0' ? 'checked' : (old('visual.answer44') == '0' ? 'checked' : '') }}>
                            <label class="form-check-label" for="ekspresif_tidak">Tidak</label>
                        </div>
                    </div>
                </div>


            </div>
            <div class="form-section mt-4" id="section18Sampai24" style="display: none;">
                <h3>Umur lebih dari 18 bulan sampai 24 bulan</h3>
                <h4>Kemampuan Ekspresif</h4>
                <div class="form-group">
                    <label>1. Apakah anak dapat mengucapkan 2 atau lebih kata yang menunjukkan, seperti ”susu”, “Minum”,
                        “lagi”?</label>
                    <input type="hidden" name="ekspresif[question5]"
                        value="1. Apakah anak dapat mengucapkan 2 atau lebih kata yang menunjukkan, seperti ”susu”, “Minum”, “lagi”?">
                    <div class="d-flex">
                        <div class="form-check mr-3">
                            <input type="radio" class="form-check-input" name="ekspresif[answer5]" value="1"
                                id="ekspresif_ya"
                                {{ isset($testPendengaran->ekspresif['answer5']) && $testPendengaran->ekspresif['answer5'] == '1' ? 'checked' : (old('ekspresif.answer5') == '1' ? 'checked' : '') }}>
                            <label class="form-check-label" for="ekspresif_ya">Ya</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="ekspresif[answer5]" value="0"
                                id="ekspresif_tidak"
                                {{ isset($testPendengaran->ekspresif['answer5']) && $testPendengaran->ekspresif['answer5'] == '0' ? 'checked' : (old('ekspresif.answer4') == '0' ? 'checked' : '') }}>
                            <label class="form-check-label" for="ekspresif_tidak">Tidak</label>
                        </div>
                    </div>
                </div>


                <div class="form-group">
                    <label>2. Apakah anak secara spontan mengatakan 2 kombinasi kata, seperti “mau bobo”, “lihat
                        papa”?</label>
                    <input type="hidden" name="ekspresif[question55]"
                        value="2. Apakah anak secara spontan mengatakan 2 kombinasi kata, seperti “mau bobo”, “lihat papa”?">
                    <div class="d-flex">
                        <div class="form-check mr-3">
                            <input type="radio" class="form-check-input" name="ekspresif[answer55]" value="1"
                                id="ekspresif_ya"
                                {{ isset($testPendengaran->ekspresif['answer55']) && $testPendengaran->ekspresif['answer55'] == '1' ? 'checked' : (old('ekspresif.answer55') == '1' ? 'checked' : '') }}>
                            <label class="form-check-label" for="ekspresif_ya">Ya</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="ekspresif[answer55]" value="0"
                                id="ekspresif_tidak"
                                {{ isset($testPendengaran->ekspresif['answer55']) && $testPendengaran->ekspresif['answer55'] == '0' ? 'checked' : (old('ekspresif.answer55') == '0' ? 'checked' : '') }}>
                            <label class="form-check-label" for="ekspresif_tidak">Tidak</label>
                        </div>
                    </div>
                </div>


                <h4>Kemampuan Reseptif</h4>
                <div class="form-group">
                    <label>1. Anak dapat menunjukkan paling sedikit 1 anggota badan, missal” mana hidungmu?”, “mana matamu?”
                        tanpa diberi contoh</label>
                    <input type="hidden" name="reseptif[question5]"
                        value="1. Anak dapat menunjukkan paling sedikit 1 anggota badan, missal” mana hidungmu?”, “mana matamu?” tanpa diberi contoh">
                    <div class="d-flex">
                        <div class="form-check mr-3">
                            <input type="radio" class="form-check-input" name="reseptif[answer5]" value="1"
                                id="ekspresif_ya"
                                {{ isset($testPendengaran->reseptif['answer5']) && $testPendengaran->reseptif['answer5'] == '1' ? 'checked' : (old('reseptif.answer5') == '1' ? 'checked' : '') }}>
                            <label class="form-check-label" for="ekspresif_ya">Ya</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="reseptif[answer5]" value="0"
                                id="ekspresif_tidak"
                                {{ isset($testPendengaran->reseptif['answer5']) && $testPendengaran->reseptif['answer5'] == '0' ? 'checked' : (old('reseptif.answer5') == '0' ? 'checked' : '') }}>
                            <label class="form-check-label" for="ekspresif_tidak">Tidak</label>
                        </div>
                    </div>
                </div>


                <div class="form-group">
                    <label>2. Apakah anak dapat mengerjakan 2 macam perintah dalam 1 kalimat, seperti “ambil sepatumu dan
                        taruh disini” tanpa diberi
                        contoh?</label>
                    <input type="hidden" name="reseptif[question55]"
                        value="2. Apakah anak dapat mengerjakan 2 macam perintah dalam 1 kalimat, seperti “ambil sepatumu dan taruh disini” tanpa diberi contoh?">
                    <div class="d-flex">
                        <div class="form-check mr-3">
                            <input type="radio" class="form-check-input" name="reseptif[answer55]" value="1"
                                id="ekspresif_ya"
                                {{ isset($testPendengaran->reseptif['answer55']) && $testPendengaran->reseptif['answer55'] == '1' ? 'checked' : (old('reseptif.answer55') == '1' ? 'checked' : '') }}>
                            <label class="form-check-label" for="ekspresif_ya">Ya</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="reseptif[answer55]" value="0"
                                id="ekspresif_tidak"
                                {{ isset($testPendengaran->reseptif['answer55']) && $testPendengaran->reseptif['answer55'] == '0' ? 'checked' : (old('reseptif.answer55') == '0' ? 'checked' : '') }}>
                            <label class="form-check-label" for="ekspresif_tidak">Tidak</label>
                        </div>
                    </div>
                </div>
                <h4>Kemampuan Visual</h4>
                <div class="form-group">
                    <label>1. Apakah anak secara spontan memulai permainan dengan gerakan tubuh, seperti “po kame-ame” atau
                        “cilukba”</label>
                    <input type="hidden" name="visual[question5]"
                        value="1. Apakah anak secara spontan memulai permainan dengan gerakan tubuh, seperti “po kame-ame” atau “cilukba”">
                    <div class="d-flex">
                        <div class="form-check mr-3">
                            <input type="radio" class="form-check-input" name="visual[answer5]" value="1"
                                id="ekspresif_ya"
                                {{ isset($testPendengaran->visual['answer5']) && $testPendengaran->visual['answer5'] == '1' ? 'checked' : (old('visual.answer5') == '1' ? 'checked' : '') }}>
                            <label class="form-check-label" for="ekspresif_ya">Ya</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="visual[answer5]" value="0"
                                id="ekspresif_tidak"
                                {{ isset($testPendengaran->visual['answer5']) && $testPendengaran->visual['answer5'] == '0' ? 'checked' : (old('visual.answer5') == '0' ? 'checked' : '') }}>
                            <label class="form-check-label" for="ekspresif_tidak">Tidak</label>
                        </div>
                    </div>
                </div>


                <div class="form-group">
                    <label>2. Apakah anak Anda menunjuk dengan jari telunjuk bila ingin sesuatu, bukan dengan cara memegang
                        dengan semua jari?</label>
                    <input type="hidden" name="visual[question55]"
                        value="2. Apakah anak Anda menunjuk dengan jari telunjuk bila ingin sesuatu, bukan dengan cara memegang dengan semua jari?">
                    <div class="d-flex">
                        <div class="form-check mr-3">
                            <input type="radio" class="form-check-input" name="visual[answer55]" value="1"
                                id="ekspresif_ya"
                                {{ isset($testPendengaran->visual['answer55']) && $testPendengaran->visual['answer55'] == '1' ? 'checked' : (old('visual.answer55') == '1' ? 'checked' : '') }}>
                            <label class="form-check-label" for="ekspresif_ya">Ya</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="visual[answer55]" value="0"
                                id="ekspresif_tidak"
                                {{ isset($testPendengaran->visual['answer55']) && $testPendengaran->visual['answer55'] == '0' ? 'checked' : (old('visual.answer55') == '0' ? 'checked' : '') }}>
                            <label class="form-check-label" for="ekspresif_tidak">Tidak</label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-section mt-4" id="section24Sampai30" style="display: none;">
                <h3>Umur lebih dari 24 bulan sampai 30 bulan</h3>
                <h4>Kemampuan Ekspresif</h4>
                <div class="form-group">
                    <label>1. Apakah anak mulai menggunakan kata-kata lain, selain kata mama, papa, anggota keluarga lain,
                        dan hewan peliharaan?</label>
                    <input type="hidden" name="ekspresif[question6]"
                        value="1. Apakah anak mulai menggunakan kata-kata lain, selain kata mama, papa, anggota keluarga lain, dan hewan peliharaan?">
                    <div class="d-flex">
                        <div class="form-check mr-3">
                            <input type="radio" class="form-check-input" name="ekspresif[answer6]" value="1"
                                id="ekspresif_ya"
                                {{ isset($testPendengaran->ekspresif['answer6']) && $testPendengaran->ekspresif['answer6'] == '1' ? 'checked' : (old('ekspresif.answer6') == '1' ? 'checked' : '') }}>
                            <label class="form-check-label" for="ekspresif_ya">Ya</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="ekspresif[answer6]" value="0"
                                id="ekspresif_tidak"
                                {{ isset($testPendengaran->ekspresif['answer6']) && $testPendengaran->ekspresif['answer6'] == '0' ? 'checked' : (old('ekspresif.answer6') == '0' ? 'checked' : '') }}>
                            <label class="form-check-label" for="ekspresif_tidak">Tidak</label>
                        </div>
                    </div>
                </div>


                <div class="form-group">
                    <label>2. Apakah anak mulai mengungkapkan kata yang berati ‘milik’ missal “bonekaku”?</label>
                    <input type="hidden" name="ekspresif[question66]"
                        value="2. Apakah anak mulai mengungkapkan kata yang berati ‘milik’ missal “bonekaku”?">
                    <div class="d-flex">
                        <div class="form-check mr-3">
                            <input type="radio" class="form-check-input" name="ekspresif[answer66]" value="1"
                                id="ekspresif_ya"
                                {{ isset($testPendengaran->ekspresif['answer66']) && $testPendengaran->ekspresif['answer66'] == '1' ? 'checked' : (old('ekspresif.answer66') == '1' ? 'checked' : '') }}>
                            <label class="form-check-label" for="ekspresif_ya">Ya</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="ekspresif[answer66]" value="0"
                                id="ekspresif_tidak"
                                {{ isset($testPendengaran->ekspresif['answer66']) && $testPendengaran->ekspresif['answer66'] == '0' ? 'checked' : (old('ekspresif.answer66') == '0' ? 'checked' : '') }}>
                            <label class="form-check-label" for="ekspresif_tidak">Tidak</label>
                        </div>
                    </div>
                </div>


                <h4>Kemampuan Reseptif</h4>
                <div class="form-group">
                    <label>1.Apakah anak dapat mengerjakan 2 macam perintah dalam satu kalimat, seperti “Ambil sepatu dan
                        taruh disini” tanpa diberi
                        contoh?</label>
                    <input type="hidden" name="reseptif[question6]"
                        value="1. Apakah anak dapat mengerjakan 2 macam perintah dalam satu kalimat, seperti “Ambil sepatu dan taruh disini” tanpa diberi contoh?">
                    <div class="d-flex">
                        <div class="form-check mr-3">
                            <input type="radio" class="form-check-input" name="reseptif[answer6]" value="1"
                                id="ekspresif_ya"
                                {{ isset($testPendengaran->reseptif['answer6']) && $testPendengaran->reseptif['answer6'] == '1' ? 'checked' : (old('reseptif.answer6') == '1' ? 'checked' : '') }}>
                            <label class="form-check-label" for="ekspresif_ya">Ya</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="reseptif[answer6]" value="0"
                                id="ekspresif_tidak"
                                {{ isset($testPendengaran->reseptif['answer6']) && $testPendengaran->reseptif['answer6'] == '0' ? 'checked' : (old('reseptif.answer6') == '0' ? 'checked' : '') }}>
                            <label class="form-check-label" for="ekspresif_tidak">Tidak</label>
                        </div>
                    </div>
                </div>


                <div class="form-group">
                    <label>2.Apakah anak dapat menunjuk minimal 2 nama benda di depannya (cangkir, bola, sendok)?</label>
                    <input type="hidden" name="reseptif[question66]"
                        value="2. Apakah anak dapat menunjuk minimal 2 nama benda di depannya (cangkir, bola, sendok)?">
                    <div class="d-flex">
                        <div class="form-check mr-3">
                            <input type="radio" class="form-check-input" name="reseptif[answer66]" value="1"
                                id="ekspresif_ya"
                                {{ isset($testPendengaran->reseptif['answer66']) && $testPendengaran->reseptif['answer66'] == '1' ? 'checked' : (old('reseptif.answer66') == '1' ? 'checked' : '') }}>
                            <label class="form-check-label" for="ekspresif_ya">Ya</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="reseptif[answer66]" value="0"
                                id="ekspresif_tidak"
                                {{ isset($testPendengaran->reseptif['answer66']) && $testPendengaran->reseptif['answer66'] == '0' ? 'checked' : (old('reseptif.answer66') == '0' ? 'checked' : '') }}>
                            <label class="form-check-label" for="ekspresif_tidak">Tidak</label>
                        </div>
                    </div>
                </div>
                <h4>Kemampuan Visual</h4>
                <div class="form-group">
                    <label>1.Apakah anak secara spontan memulai permainan dengan gerakan tubuh, seperti “Pok Ame-ame” atau
                        “cilukba”?</label>
                    <input type="hidden" name="visual[question6]"
                        value="1.Apakah anak secara spontan memulai permainan dengan gerakan tubuh, seperti “Pok Ame-ame” atau “cilukba”?">
                    <div class="d-flex">
                        <div class="form-check mr-3">
                            <input type="radio" class="form-check-input" name="visual[answer6]" value="1"
                                id="ekspresif_ya"
                                {{ isset($testPendengaran->visual['answer6']) && $testPendengaran->visual['answer6'] == '1' ? 'checked' : (old('visual.answer6') == '1' ? 'checked' : '') }}>
                            <label class="form-check-label" for="ekspresif_ya">Ya</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="visual[answer6]" value="0"
                                id="ekspresif_tidak"
                                {{ isset($testPendengaran->visual['answer6']) && $testPendengaran->visual['answer6'] == '0' ? 'checked' : (old('visual.answer6') == '0' ? 'checked' : '') }}>
                            <label class="form-check-label" for="ekspresif_tidak">Tidak</label>
                        </div>
                    </div>
                </div>


                <div class="form-group">
                    <label>2. Apakah anak Anda menunjuk dengan jari telunjuk bila ingin sesuatu, bukan dengan cara memegang
                        dengan semua jari?</label>
                    <input type="hidden" name="visual[question66]"
                        value="2. Apakah anak Anda menunjuk dengan jari telunjuk bila ingin sesuatu, bukan dengan cara memegang dengan semua jari?">
                    <div class="d-flex">
                        <div class="form-check mr-3">
                            <input type="radio" class="form-check-input" name="visual[answer66]" value="1"
                                id="ekspresif_ya"
                                {{ isset($testPendengaran->visual['answer66']) && $testPendengaran->visual['answer66'] == '1' ? 'checked' : (old('visual.answer66') == '1' ? 'checked' : '') }}>
                            <label class="form-check-label" for="ekspresif_ya">Ya</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="visual[answer66]" value="0"
                                id="ekspresif_tidak"
                                {{ isset($testPendengaran->visual['answer66']) && $testPendengaran->visual['answer66'] == '0' ? 'checked' : (old('visual.answer66') == '0' ? 'checked' : '') }}>
                            <label class="form-check-label" for="ekspresif_tidak">Tidak</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-section mt-4" id="section30Sampai36" style="display: none;">
                <h3>Umur lebih dari 30 bulan sampai 36 bulan</h3>
                <h4>Kemampuan Ekspresif</h4>
                <div class="form-group">
                    <label>1. Apakah anak dapat menyebutkan nama benda dan kegunaannya, seperti cangkir untuk minum, bola
                        untuk dilempar, pensil
                        warna untuk menggambar, sendok untuk makan?</label>
                    <input type="hidden" name="ekspresif[question7]"
                        value="1.Apakah anak dapat menyebutkan nama benda dan kegunaannya, seperti cangkir untuk minum, bola untuk dilempar, pensil warna untuk menggambar, sendok untuk makan?">
                    <div class="d-flex">
                        <div class="form-check mr-3">
                            <input type="radio" class="form-check-input" name="ekspresif[answer7]" value="1"
                                id="ekspresif_ya"
                                {{ isset($testPendengaran->ekspresif['answer7']) && $testPendengaran->ekspresif['answer7'] == '1' ? 'checked' : (old('ekspresif.answer7') == '1' ? 'checked' : '') }}>
                            <label class="form-check-label" for="ekspresif_ya">Ya</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="ekspresif[answer7]" value="0"
                                id="ekspresif_tidak"
                                {{ isset($testPendengaran->ekspresif['answer7']) && $testPendengaran->ekspresif['answer7'] == '0' ? 'checked' : (old('ekspresif.answer7') == '0' ? 'checked' : '') }}>
                            <label class="form-check-label" for="ekspresif_tidak">Tidak</label>
                        </div>
                    </div>
                </div>


                <div class="form-group">
                    <label>2. Apakah lebih dari tiga perempat orang mengerti apa yang dibicarakan anak Anda?</label>
                    <input type="hidden" name="ekspresif[question77]"
                        value="2. Apakah lebih dari tiga perempat orang mengerti apa yang dibicarakan anak Anda?">
                    <div class="d-flex">
                        <div class="form-check mr-3">
                            <input type="radio" class="form-check-input" name="ekspresif[answer77]" value="1"
                                id="ekspresif_ya"
                                {{ isset($testPendengaran->ekspresif['answer77']) && $testPendengaran->ekspresif['answer77'] == '1' ? 'checked' : (old('ekspresif.answer77') == '1' ? 'checked' : '') }}>
                            <label class="form-check-label" for="ekspresif_ya">Ya</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="ekspresif[answer77]" value="0"
                                id="ekspresif_tidak"
                                {{ isset($testPendengaran->ekspresif['answer77']) && $testPendengaran->ekspresif['answer77'] == '0' ? 'checked' : (old('ekspresif.answer77') == '0' ? 'checked' : '') }}>
                            <label class="form-check-label" for="ekspresif_tidak">Tidak</label>
                        </div>
                    </div>
                </div>


                <h4>Kemampuan Reseptif</h4>
                <div class="form-group">
                    <label>1.Apakah anak dapat menunjukkan minimal 2 nama benda di depannya sesuai fungsinya (missal untuk
                        minum: cangkir,
                        untuk dilempar: bola, untuk makan: sendok, untuk menggambar: pensil warna)?</label>
                    <input type="hidden" name="reseptif[question7]"
                        value="1. Apakah anak dapat menunjukkan minimal 2 nama benda di depannya sesuai fungsinya (missal untuk minum: cangkir, untuk dilempar: bola, untuk makan: sendok, untuk menggambar: pensil warna)?">
                    <div class="d-flex">
                        <div class="form-check mr-3">
                            <input type="radio" class="form-check-input" name="reseptif[answer7]" value="1"
                                id="ekspresif_ya"
                                {{ isset($testPendengaran->reseptif['answer7']) && $testPendengaran->reseptif['answer7'] == '1' ? 'checked' : (old('reseptif.answer7') == '1' ? 'checked' : '') }}>
                            <label class="form-check-label" for="ekspresif_ya">Ya</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="reseptif[answer7]" value="0"
                                id="ekspresif_tidak"
                                {{ isset($testPendengaran->reseptif['answer7']) && $testPendengaran->reseptif['answer7'] == '0' ? 'checked' : (old('reseptif.answer7') == '0' ? 'checked' : '') }}>
                            <label class="form-check-label" for="ekspresif_tidak">Tidak</label>
                        </div>
                    </div>
                </div>


                <div class="form-group">
                    <label>2.Apakah anak dapat mengerjakan perintah yang disertai kata depan? (missal: ‘Sekarang kubus itu
                        di bawah meja, tolong
                        taruh di atas meja”?)</label>
                    <input type="hidden" name="reseptif[question77]"
                        value="2. Apakah anak dapat mengerjakan perintah yang disertai kata depan? (missal: ‘Sekarang kubus itu di bawah meja, tolong taruh di atas meja”?)">
                    <div class="d-flex">
                        <div class="form-check mr-3">
                            <input type="radio" class="form-check-input" name="reseptif[answer77]" value="1"
                                id="ekspresif_ya"
                                {{ isset($testPendengaran->reseptif['answer77']) && $testPendengaran->reseptif['answer77'] == '1' ? 'checked' : (old('reseptif.answer77') == '1' ? 'checked' : '') }}>
                            <label class="form-check-label" for="ekspresif_ya">Ya</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="reseptif[answer77]" value="0"
                                id="ekspresif_tidak"
                                {{ isset($testPendengaran->reseptif['answer77']) && $testPendengaran->reseptif['answer77'] == '0' ? 'checked' : (old('reseptif.answer77') == '0' ? 'checked' : '') }}>
                            <label class="form-check-label" for="ekspresif_tidak">Tidak</label>
                        </div>
                    </div>
                </div>
                <h4>Kemampuan Visual</h4>
                <div class="form-group">
                    <label>1.Apakah anak secara spontan memulai permainan dengan gerakan tubuh, seperti “Pok Ame-ame” atau
                        “cilukba”?</label>
                    <input type="hidden" name="visual[question7]"
                        value="1.Apakah anak secara spontan memulai permainan dengan gerakan tubuh, seperti “Pok Ame-ame” atau “cilukba”?">
                    <div class="d-flex">
                        <div class="form-check mr-3">
                            <input type="radio" class="form-check-input" name="visual[answer7]" value="1"
                                id="ekspresif_ya"
                                {{ isset($testPendengaran->visual['answer7']) && $testPendengaran->visual['answer7'] == '1' ? 'checked' : (old('visual.answer7') == '1' ? 'checked' : '') }}>
                            <label class="form-check-label" for="ekspresif_ya">Ya</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="visual[answer7]" value="0"
                                id="ekspresif_tidak"
                                {{ isset($testPendengaran->visual['answer7']) && $testPendengaran->visual['answer7'] == '0' ? 'checked' : (old('visual.answer7') == '0' ? 'checked' : '') }}>
                            <label class="form-check-label" for="ekspresif_tidak">Tidak</label>
                        </div>
                    </div>
                </div>


                <div class="form-group">
                    <label>2. Apakah anak Anda menunjuk dengan jari telunjuk bila ingin sesuatu, bukan dengan cara memegang
                        dengan semua jari?</label>
                    <input type="hidden" name="visual[question77]"
                        value="2. Apakah anak Anda menunjuk dengan jari telunjuk bila ingin sesuatu, bukan dengan cara memegang dengan semua jari?">
                    <div class="d-flex">
                        <div class="form-check mr-3">
                            <input type="radio" class="form-check-input" name="visual[answer77]" value="1"
                                id="ekspresif_ya"
                                {{ isset($testPendengaran->visual['answer77']) && $testPendengaran->visual['answer77'] == '1' ? 'checked' : (old('visual.answer77') == '1' ? 'checked' : '') }}>
                            <label class="form-check-label" for="ekspresif_ya">Ya</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="visual[answer77]" value="0"
                                id="ekspresif_tidak"
                                {{ isset($testPendengaran->visual['answer77']) && $testPendengaran->visual['answer77'] == '0' ? 'checked' : (old('visual.answer77') == '0' ? 'checked' : '') }}>
                            <label class="form-check-label" for="ekspresif_tidak">Tidak</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-section mt-4" id="section36Sampai6" style="display: none;">
                <h3>Umur lebih dari 36 bulan sampai 6 tahun</h3>
                <h4>Kemampuan Ekspresif</h4>
                <div class="form-group">
                    <label>1. Apakah anak dapat menyebutkan nama benda dan kegunaannya, seperti cangkir untuk minum, bola
                        untuk dilempar, pensil
                        warna untuk menggambar, sendok untuk makan?</label>
                    <input type="hidden" name="ekspresif[question8]"
                        value="1.Apakah anak dapat menyebutkan nama benda dan kegunaannya, seperti cangkir untuk minum, bola untuk dilempar, pensil warna untuk menggambar, sendok untuk makan?">
                    <div class="d-flex">
                        <div class="form-check mr-3">
                            <input type="radio" class="form-check-input" name="ekspresif[answer8]" value="1"
                                id="ekspresif_ya"
                                {{ isset($testPendengaran->ekspresif['answer8']) && $testPendengaran->ekspresif['answer8'] == '1' ? 'checked' : (old('ekspresif.answer8') == '1' ? 'checked' : '') }}>
                            <label class="form-check-label" for="ekspresif_ya">Ya</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="ekspresif[answer8]" value="0"
                                id="ekspresif_tidak"
                                {{ isset($testPendengaran->ekspresif['answer8']) && $testPendengaran->ekspresif['answer8'] == '0' ? 'checked' : (old('ekspresif.answer8') == '0' ? 'checked' : '') }}>
                            <label class="form-check-label" for="ekspresif_tidak">Tidak</label>
                        </div>
                    </div>
                </div>


                <div class="form-group">
                    <label>2. Apakah lebih dari tiga perempat orang mengerti apa yang dibicarakan anak Anda?</label>
                    <input type="hidden" name="ekspresif[question88]"
                        value="2. Apakah lebih dari tiga perempat orang mengerti apa yang dibicarakan anak Anda?">
                    <div class="d-flex">
                        <div class="form-check mr-3">
                            <input type="radio" class="form-check-input" name="ekspresif[answer88]" value="1"
                                id="ekspresif_ya"
                                {{ isset($testPendengaran->ekspresif['answer88']) && $testPendengaran->ekspresif['answer88'] == '1' ? 'checked' : (old('ekspresif.answer88') == '1' ? 'checked' : '') }}>
                            <label class="form-check-label" for="ekspresif_ya">Ya</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="ekspresif[answer88]" value="0"
                                id="ekspresif_tidak"
                                {{ isset($testPendengaran->ekspresif['answer88']) && $testPendengaran->ekspresif['answer88'] == '0' ? 'checked' : (old('ekspresif.answer88') == '0' ? 'checked' : '') }}>
                            <label class="form-check-label" for="ekspresif_tidak">Tidak</label>
                        </div>
                    </div>
                </div>


                <h4>Kemampuan Reseptif</h4>
                <div class="form-group">
                    <label>1.Apakah anak dapat menunjukkan minimal 2 nama benda di depannya sesuai fungsinya (missal untuk
                        minum: cangkir,
                        untuk dilempar: bola, untuk makan: sendok, untuk menggambar: pensil warna)?</label>
                    <input type="hidden" name="reseptif[question8]"
                        value="1. Apakah anak dapat menunjukkan minimal 2 nama benda di depannya sesuai fungsinya (missal untuk minum: cangkir, untuk dilempar: bola, untuk makan: sendok, untuk menggambar: pensil warna)?">
                    <div class="d-flex">
                        <div class="form-check mr-3">
                            <input type="radio" class="form-check-input" name="reseptif[answer8]" value="1"
                                id="ekspresif_ya"
                                {{ isset($testPendengaran->reseptif['answer8']) && $testPendengaran->reseptif['answer8'] == '1' ? 'checked' : (old('reseptif.answer8') == '1' ? 'checked' : '') }}>
                            <label class="form-check-label" for="ekspresif_ya">Ya</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="reseptif[answer8]" value="0"
                                id="ekspresif_tidak"
                                {{ isset($testPendengaran->reseptif['answer8']) && $testPendengaran->reseptif['answer8'] == '0' ? 'checked' : (old('reseptif.answer8') == '0' ? 'checked' : '') }}>
                            <label class="form-check-label" for="ekspresif_tidak">Tidak</label>
                        </div>
                    </div>
                </div>
                <h4>Kemampuan Visual</h4>
                <div class="form-group">
                    <label>1.Apakah anak secara spontan memulai permainan dengan gerakan tubuh, seperti “Pok Ame-ame” atau
                        “cilukba”?</label>
                    <input type="hidden" name="visual[question8]"
                        value="1.Apakah anak secara spontan memulai permainan dengan gerakan tubuh, seperti “Pok Ame-ame” atau “cilukba”?">
                    <div class="d-flex">
                        <div class="form-check mr-3">
                            <input type="radio" class="form-check-input" name="visual[answer8]" value="1"
                                id="ekspresif_ya"
                                {{ isset($testPendengaran->visual['answer8']) && $testPendengaran->visual['answer8'] == '1' ? 'checked' : (old('visual.answer8') == '1' ? 'checked' : '') }}>
                            <label class="form-check-label" for="ekspresif_ya">Ya</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="visual[answer8]" value="0"
                                id="ekspresif_tidak"
                                {{ isset($testPendengaran->visual['answer8']) && $testPendengaran->visual['answer8'] == '0' ? 'checked' : (old('visual.answer8') == '0' ? 'checked' : '') }}>
                            <label class="form-check-label" for="ekspresif_tidak">Tidak</label>
                        </div>
                    </div>
                </div>


                <div class="form-group">
                    <label>2. Apakah anak Anda menunjuk dengan jari telunjuk bila ingin sesuatu, bukan dengan cara memegang
                        dengan semua jari?</label>
                    <input type="hidden" name="visual[question88]"
                        value="2. Apakah anak Anda menunjuk dengan jari telunjuk bila ingin sesuatu, bukan dengan cara memegang dengan semua jari?">
                    <div class="d-flex">
                        <div class="form-check mr-3">
                            <input type="radio" class="form-check-input" name="visual[answer88]" value="1"
                                id="ekspresif_ya"
                                {{ isset($testPendengaran->visual['answer88']) && $testPendengaran->visual['answer88'] == '1' ? 'checked' : (old('visual.answer88') == '1' ? 'checked' : '') }}>
                            <label class="form-check-label" for="ekspresif_ya">Ya</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="visual[answer88]" value="0"
                                id="ekspresif_tidak"
                                {{ isset($testPendengaran->visual['answer88']) && $testPendengaran->visual['answer88'] == '0' ? 'checked' : (old('visual.answer88') == '0' ? 'checked' : '') }}>
                            <label class="form-check-label" for="ekspresif_tidak">Tidak</label>
                        </div>
                    </div>
                </div>
            </div>


            <div class="form-group">
                <div class="col-md-12">
                    <label for="kesimpulan" style="color: rgb(19, 11, 241);">Kesimpulan</label>
                    <textarea class="form-control" id="kesimpulan" name="kesimpulan" placeholder="Kesimpulan">{{ old('kesimpulan', $testPendengaran->kesimpulan ?? '') }}</textarea>
                </div>
            </div>


            <div class="text-right mt-4">
                {{-- @if (isset($testPendengaran) && $testPendengaran)
                    <a href="{{ route('testPendengaran.mtbs.admin') }}" type="button"
                        class="btn btn-secondary mr-2" style="font-size: 20px">Kembali</a>
                @else
                    <a href="{{ route('skrining.ilp') }}" type="button" class="btn btn-secondary mr-2"
                        style="font-size: 20px">Kembali</a>
                @endif --}}
                <button type="submit" class="btn btn-primary" style="font-size: 20px">Kirim</button>
            </div>


    </form>
    <script>
        // Function to toggle visibility of sections and disable hidden inputs
        function toggleSection(value) {
            // Define section IDs
            const sections = {
                '0': 'sectionKurangDariTiga',
                '1': 'sectionTigaHinggaEnam',
                '2': 'sectionEnamSampaiDuabelas',
                '3': 'sectionDuabelasSampaiDelapanBelas',
                '4': 'section18Sampai24',
                '5': 'section24Sampai30',
                '6': 'section30Sampai36',
                '7': 'section36Sampai6'
            };

            // Hide all sections and disable hidden inputs within them
            Object.values(sections).forEach(sectionId => {
                const section = document.getElementById(sectionId);
                console.log(section);

                const hiddenInputs = section ? section.querySelectorAll('input[type="hidden"]') : [];

                // Disable hidden inputs in the section
                hiddenInputs.forEach(input => input.disabled = true);

                // Hide the section
                if (section) section.style.display = 'none';
            });

            // Show the relevant section and enable hidden inputs if the section is selected
            if (sections[value]) {
                const sectionToShow = document.getElementById(sections[value]);
                const hiddenInputsToEnable = sectionToShow ? sectionToShow.querySelectorAll('input[type="hidden"]') : [];

                // Enable hidden inputs in the selected section
                hiddenInputsToEnable.forEach(input => input.disabled = false);

                // Show the selected section
                if (sectionToShow) sectionToShow.style.display = 'block';
            }
        }

        // Ensure correct state on page load (for old data)
        document.addEventListener('DOMContentLoaded', () => {
            const selectedValue = document.querySelector('input[name="usia"]:checked')?.value;
            toggleSection(selectedValue);
        });
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
