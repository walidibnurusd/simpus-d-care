@extends('layouts.skrining.master')
@section('title', 'Skrining Keswa SDQ (11-18 Tahun)')
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
        action="{{ isset($gangguanJiwaRemaja) ? route('sdq.remaja.mtbs.update', $gangguanJiwaRemaja->id) : route('sdq.remaja.mtbs.store') }}"
        method="POST">
        @csrf
        @if (isset($gangguanJiwaRemaja))
            @method('PUT')
        @endif
        <div class="form-section">
            <h3>Identitas</h3>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Pasien</label>
                        <select class="form-control form-select select2" id="pasien" name="pasien">
                            <option value="" disabled {{ old('pasien') == '' ? 'selected' : '' }}>Pilih</option>
                            @foreach ($pasien as $item)
                                <option value="{{ $item->id }}" data-no_hp="{{ $item->phone }}"
                                    data-nik="{{ $item->nik }}" data-dob="{{ $item->dob }}"
                                    data-jenis_kelamin="{{ $item->genderName->name }}" data-alamat="{{ $item->address }}"
                                    {{ old('pasien', $gangguanJiwaRemaja->pasien ?? '') == $item->id ? 'selected' : '' }}>
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
                        <input type="date" readonly class="form-control" name="tanggal_lahir" id="tanggal_lahir"
                            value="{{ isset($gangguanJiwaRemaja) ? $gangguanJiwaRemaja->tanggal_lahir : old('tanggal_lahir') }}">
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
                                    {{ isset($gangguanJiwaRemaja) && $gangguanJiwaRemaja->jenis_kelamin == 'laki-laki' ? 'checked' : (old('jenis_kelamin') == 'laki-laki' ? 'checked' : '') }}>
                                <label class="form-check-label" for="laki-laki">Laki-laki</label>
                            </div>
                            <div class="form-check">
                                <input type="radio" class="form-check-input" name="jenis_kelamin" value="perempuan"
                                    id="jk_perempuan" id="perempuan"
                                    {{ isset($gangguanJiwaRemaja) && $gangguanJiwaRemaja->jenis_kelamin == 'perempuan' ? 'checked' : (old('jenis_kelamin') == 'perempuan' ? 'checked' : '') }}>
                                <label class="form-check-label" for="perempuan">Perempuan</label>
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
                                <label>1. Saya berusaha baik kepada orang lain. Saya peduli dengan perasaan mereka
                                    (pro)?</label>
                                <div class="d-flex">
                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input" name="berusaha_baik" value="2"
                                            onclick="calculateTotalScore()" id="benar"
                                            {{ isset($gangguanJiwaRemaja) && $gangguanJiwaRemaja->berusaha_baik == 2 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="benar">Selalu benar</label>
                                    </div>
                                    <div class="form-check">
                                        <input type="radio" class="form-check-input" name="berusaha_baik" value="1"
                                            onclick="calculateTotalScore()" id="kadang"
                                            {{ isset($gangguanJiwaRemaja) && $gangguanJiwaRemaja->berusaha_baik == 1 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="kadang">Kadang benar</label>
                                    </div>
                                    <div class="form-check ml-3">
                                        <input type="radio" class="form-check-input" name="berusaha_baik" value="0"
                                            onclick="calculateTotalScore()" id="tidak"
                                            {{ isset($gangguanJiwaRemaja) && $gangguanJiwaRemaja->berusaha_baik == 0 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="tidak">Tidak benar</label>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label>2. Saya gelisah. saya tidak dapat diam untuk waktu lama (H)?</label>
                                <div class="d-flex">
                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input" name="gelisah" value="2"
                                            onclick="calculateTotalScore()" id="benar"
                                            {{ isset($gangguanJiwaRemaja) && $gangguanJiwaRemaja->gelisah == 2 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="benar">Selalu benar</label>
                                    </div>
                                    <div class="form-check">
                                        <input type="radio" class="form-check-input" name="gelisah" value="1"
                                            onclick="calculateTotalScore()" id="kadang"
                                            {{ isset($gangguanJiwaRemaja) && $gangguanJiwaRemaja->gelisah == 1 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="kadang">Kadang benar</label>
                                    </div>
                                    <div class="form-check ml-3">
                                        <input type="radio" class="form-check-input" name="gelisah" value="0"
                                            onclick="calculateTotalScore()" id="tidak"
                                            {{ isset($gangguanJiwaRemaja) && $gangguanJiwaRemaja->gelisah == 0 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="tidak">Tidak benar</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label>3. Saya sering sakit kepala, sakit perut atau macam-macam sakit lainnya?</label>
                                <div class="d-flex">
                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input" name="sakit" value="2"
                                            onclick="calculateTotalScore()" id="benar"
                                            {{ isset($gangguanJiwaRemaja) && $gangguanJiwaRemaja->sakit == 2 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="benar">Selalu benar</label>
                                    </div>
                                    <div class="form-check">
                                        <input type="radio" class="form-check-input" name="sakit" value="1"
                                            onclick="calculateTotalScore()" id="kadang"
                                            {{ isset($gangguanJiwaRemaja) && $gangguanJiwaRemaja->sakit == 1 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="kadang">Kadang benar</label>
                                    </div>
                                    <div class="form-check ml-3">
                                        <input type="radio" class="form-check-input" name="sakit" value="0"
                                            onclick="calculateTotalScore()" id="tidak"
                                            {{ isset($gangguanJiwaRemaja) && $gangguanJiwaRemaja->sakit == 0 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="tidak">Tidak benar</label>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="col-md-12">
                            <div class="form-group">
                                <label>4. Kalau saya memiliki mainan, CD, atau makanan, Saya biasanya berbagi dengan orang
                                    lain (pro)?</label>
                                <div class="d-flex">
                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input" name="berbagi" value="2"
                                            onclick="calculateTotalScore()" id="benar"
                                            {{ isset($gangguanJiwaRemaja) && $gangguanJiwaRemaja->berbagi == 2 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="benar">Selalu benar</label>
                                    </div>
                                    <div class="form-check">
                                        <input type="radio" class="form-check-input" name="berbagi" value="1"
                                            onclick="calculateTotalScore()" id="kadang"
                                            {{ isset($gangguanJiwaRemaja) && $gangguanJiwaRemaja->berbagi == 1 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="kadang">Kadang benar</label>
                                    </div>
                                    <div class="form-check ml-3">
                                        <input type="radio" class="form-check-input" name="berbagi" value="0"
                                            onclick="calculateTotalScore()" id="tidak"
                                            {{ isset($gangguanJiwaRemaja) && $gangguanJiwaRemaja->berbagi == 0 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="tidak">Tidak benar</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label>5. Saya menjadi sangat marah dan sering tidak dapat mengendalikan kemarahan saya
                                    (C)?</label>
                                <div class="d-flex">
                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input" name="marah" value="2"
                                            onclick="calculateTotalScore()" id="benar"
                                            {{ isset($gangguanJiwaRemaja) && $gangguanJiwaRemaja->marah == 2 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="benar">Selalu benar</label>
                                    </div>
                                    <div class="form-check">
                                        <input type="radio" class="form-check-input" name="marah" value="1"
                                            onclick="calculateTotalScore()" id="kadang"
                                            {{ isset($gangguanJiwaRemaja) && $gangguanJiwaRemaja->marah == 1 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="kadang">Kadang benar</label>
                                    </div>
                                    <div class="form-check ml-3">
                                        <input type="radio" class="form-check-input" name="marah" value="0"
                                            onclick="calculateTotalScore()" id="tidak"
                                            {{ isset($gangguanJiwaRemaja) && $gangguanJiwaRemaja->marah == 0 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="tidak">Tidak benar</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label>6. Saya lebih suka sendiri daripada bersama dengan orang yang seusiaku (P)?</label>
                                <div class="d-flex">
                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input" name="suka_sendiri"
                                            value="2" onclick="calculateTotalScore()" id="benar"
                                            {{ isset($gangguanJiwaRemaja) && $gangguanJiwaRemaja->suka_sendiri == 2 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="benar">Selalu benar</label>
                                    </div>
                                    <div class="form-check">
                                        <input type="radio" class="form-check-input" name="suka_sendiri"
                                            value="1" onclick="calculateTotalScore()" id="kadang"
                                            {{ isset($gangguanJiwaRemaja) && $gangguanJiwaRemaja->suka_sendiri == 1 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="kadang">Kadang benar</label>
                                    </div>
                                    <div class="form-check ml-3">
                                        <input type="radio" class="form-check-input" name="suka_sendiri"
                                            value="0" onclick="calculateTotalScore()" id="tidak"
                                            {{ isset($gangguanJiwaRemaja) && $gangguanJiwaRemaja->suka_sendiri == 0 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="tidak">Tidak benar</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label>7. Saya biasanya melakukan apa yang diperintahkan oleh orang lain (C)?</label>
                                <div class="d-flex">
                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input" name="penurut" value="0"
                                            onclick="calculateTotalScore()" id="benar"
                                            {{ isset($gangguanJiwaRemaja) && $gangguanJiwaRemaja->penurut == 0 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="benar">Selalu benar</label>
                                    </div>
                                    <div class="form-check">
                                        <input type="radio" class="form-check-input" name="penurut" value="1"
                                            onclick="calculateTotalScore()" id="kadang"
                                            {{ isset($gangguanJiwaRemaja) && $gangguanJiwaRemaja->penurut == 1 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="kadang">Kadang benar</label>
                                    </div>
                                    <div class="form-check ml-3">
                                        <input type="radio" class="form-check-input" name="penurut" value="2"
                                            onclick="calculateTotalScore()" id="tidak"
                                            {{ isset($gangguanJiwaRemaja) && $gangguanJiwaRemaja->penurut == 2 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="tidak">Tidak benar</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label>8. Saya banyak merasa cemas atau khawatir terhadap apapun (E)?</label>
                                <div class="d-flex">
                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input" name="cemas" value="2"
                                            onclick="calculateTotalScore()" id="benar"
                                            {{ isset($gangguanJiwaRemaja) && $gangguanJiwaRemaja->cemas == 2 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="benar">Selalu benar</label>
                                    </div>
                                    <div class="form-check">
                                        <input type="radio" class="form-check-input" name="cemas" value="1"
                                            onclick="calculateTotalScore()" id="kadang"
                                            {{ isset($gangguanJiwaRemaja) && $gangguanJiwaRemaja->cemas == 1 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="kadang">Kadang benar</label>
                                    </div>
                                    <div class="form-check ml-3">
                                        <input type="radio" class="form-check-input" name="cemas" value="0"
                                            onclick="calculateTotalScore()" id="tidak"
                                            {{ isset($gangguanJiwaRemaja) && $gangguanJiwaRemaja->cemas == 0 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="tidak">Tidak benar</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label>9. Saya selalu siap menolong jika seseorang terluka, kecewa atau merasa sakit hati
                                    (pro)?</label>
                                <div class="d-flex">
                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input" name="siap_menolong"
                                            value="2" onclick="calculateTotalScore()" id="benar"
                                            {{ isset($gangguanJiwaRemaja) && $gangguanJiwaRemaja->siap_menolong == 2 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="benar">Selalu benar</label>
                                    </div>
                                    <div class="form-check">
                                        <input type="radio" class="form-check-input" name="siap_menolong"
                                            value="1" onclick="calculateTotalScore()" id="kadang"
                                            {{ isset($gangguanJiwaRemaja) && $gangguanJiwaRemaja->siap_menolong == 1 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="kadang">Kadang benar</label>
                                    </div>
                                    <div class="form-check ml-3">
                                        <input type="radio" class="form-check-input" name="siap_menolong"
                                            value="0" onclick="calculateTotalScore()" id="tidak"
                                            {{ isset($gangguanJiwaRemaja) && $gangguanJiwaRemaja->siap_menolong == 0 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="tidak">Tidak benar</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label>10. Bila sedang gelisah atau cemas badan saya sering bergerak – gerak tanpa saya
                                    sadari (H)?</label>
                                <div class="d-flex">
                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input" name="badan_bergerak"
                                            value="2" onclick="calculateTotalScore()" id="benar"
                                            {{ isset($gangguanJiwaRemaja) && $gangguanJiwaRemaja->badan_bergerak == 2 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="benar">Selalu benar</label>
                                    </div>
                                    <div class="form-check">
                                        <input type="radio" class="form-check-input" name="badan_bergerak"
                                            value="1" onclick="calculateTotalScore()" id="kadang"
                                            {{ isset($gangguanJiwaRemaja) && $gangguanJiwaRemaja->badan_bergerak == 1 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="kadang">Kadang benar</label>
                                    </div>
                                    <div class="form-check ml-3">
                                        <input type="radio" class="form-check-input" name="badan_bergerak"
                                            value="0" onclick="calculateTotalScore()" id="tidak"
                                            {{ isset($gangguanJiwaRemaja) && $gangguanJiwaRemaja->badan_bergerak == 0 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="tidak">Tidak benar</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label>11. Saya mempunyai satu orang teman baik atau lebih (P)?</label>
                                <div class="d-flex">
                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input" name="punya_teman" value="0"
                                            onclick="calculateTotalScore()" id="benar"
                                            {{ isset($gangguanJiwaRemaja) && $gangguanJiwaRemaja->punya_teman == 0 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="benar">Selalu benar</label>
                                    </div>
                                    <div class="form-check">
                                        <input type="radio" class="form-check-input" name="punya_teman" value="1"
                                            onclick="calculateTotalScore()" id="kadang"
                                            {{ isset($gangguanJiwaRemaja) && $gangguanJiwaRemaja->punya_teman == 1 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="kadang">Kadang benar</label>
                                    </div>
                                    <div class="form-check ml-3">
                                        <input type="radio" class="form-check-input" name="punya_teman" value="2"
                                            onclick="calculateTotalScore()" id="tidak"
                                            {{ isset($gangguanJiwaRemaja) && $gangguanJiwaRemaja->punya_teman == 2 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="tidak">Tidak benar</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label>12. Saya sering bertengkar dengan orang lain. Saya dapat memaksa orang lain melakukan
                                    apa yang saya inginkan (C)?</label>
                                <div class="d-flex">
                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input" name="suka_bertengkar"
                                            value="2" onclick="calculateTotalScore()" id="benar"
                                            {{ isset($gangguanJiwaRemaja) && $gangguanJiwaRemaja->suka_bertengkar == 2 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="benar">Selalu benar</label>
                                    </div>
                                    <div class="form-check">
                                        <input type="radio" class="form-check-input" name="suka_bertengkar"
                                            value="1" onclick="calculateTotalScore()" id="kadang"
                                            {{ isset($gangguanJiwaRemaja) && $gangguanJiwaRemaja->suka_bertengkar == 1 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="kadang">Kadang benar</label>
                                    </div>
                                    <div class="form-check ml-3">
                                        <input type="radio" class="form-check-input" name="suka_bertengkar"
                                            value="0" onclick="calculateTotalScore()" id="tidak"
                                            {{ isset($gangguanJiwaRemaja) && $gangguanJiwaRemaja->suka_bertengkar == 0 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="tidak">Tidak benar</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label>13. Saya sering merasa tidak bahagia, sedih atau menangis (E)?</label>
                                <div class="d-flex">
                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input" name="tdk_bahagia" value="0"
                                            onclick="calculateTotalScore()" id="benar"
                                            {{ isset($gangguanJiwaRemaja) && $gangguanJiwaRemaja->tdk_bahagia == 0 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="benar">Selalu benar</label>
                                    </div>
                                    <div class="form-check">
                                        <input type="radio" class="form-check-input" name="tdk_bahagia" value="1"
                                            onclick="calculateTotalScore()" id="kadang"
                                            {{ isset($gangguanJiwaRemaja) && $gangguanJiwaRemaja->tdk_bahagia == 1 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="kadang">Kadang benar</label>
                                    </div>
                                    <div class="form-check ml-3">
                                        <input type="radio" class="form-check-input" name="tdk_bahagia" value="2"
                                            onclick="calculateTotalScore()" id="tidak"
                                            {{ isset($gangguanJiwaRemaja) && $gangguanJiwaRemaja->tdk_bahagia == 2 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="tidak">Tidak benar</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label>14. Orang lain seusia saya umumnya menyukai saya (P)?</label>
                                <div class="d-flex">
                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input" name="disukai" value="2"
                                            onclick="calculateTotalScore()" id="benar"
                                            {{ isset($gangguanJiwaRemaja) && $gangguanJiwaRemaja->disukai == 2 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="benar">Selalu benar</label>
                                    </div>
                                    <div class="form-check">
                                        <input type="radio" class="form-check-input" name="disukai" value="1"
                                            onclick="calculateTotalScore()" id="kadang"
                                            {{ isset($gangguanJiwaRemaja) && $gangguanJiwaRemaja->disukai == 1 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="kadang">Kadang benar</label>
                                    </div>
                                    <div class="form-check ml-3">
                                        <input type="radio" class="form-check-input" name="disukai" value="0"
                                            onclick="calculateTotalScore()" id="tidak"
                                            {{ isset($gangguanJiwaRemaja) && $gangguanJiwaRemaja->disukai == 0 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="tidak">Tidak benar</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label>15. Perhatian saya mudah teralih, saya sulit untuk memusatkan perhatian pada apapun
                                    (H)?</label>
                                <div class="d-flex">
                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input" name="mudah_teralih"
                                            value="2" onclick="calculateTotalScore()" id="benar"
                                            {{ isset($gangguanJiwaRemaja) && $gangguanJiwaRemaja->mudah_teralih == 2 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="benar">Selalu benar</label>
                                    </div>
                                    <div class="form-check">
                                        <input type="radio" class="form-check-input" name="mudah_teralih"
                                            value="1" onclick="calculateTotalScore()" id="kadang"
                                            {{ isset($gangguanJiwaRemaja) && $gangguanJiwaRemaja->mudah_teralih == 1 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="kadang">Kadang benar</label>
                                    </div>
                                    <div class="form-check ml-3">
                                        <input type="radio" class="form-check-input" name="mudah_teralih"
                                            value="0" onclick="calculateTotalScore()" id="tidak"
                                            {{ isset($gangguanJiwaRemaja) && $gangguanJiwaRemaja->mudah_teralih == 0 ? 'checked' : '' }}>
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
                                            onclick="calculateTotalScore()" id="benar"
                                            {{ isset($gangguanJiwaRemaja) && $gangguanJiwaRemaja->gugup == 2 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="benar">Selalu benar</label>
                                    </div>
                                    <div class="form-check">
                                        <input type="radio" class="form-check-input" name="gugup" value="1"
                                            onclick="calculateTotalScore()" id="kadang"
                                            {{ isset($gangguanJiwaRemaja) && $gangguanJiwaRemaja->gugup == 1 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="kadang">Kadang benar</label>
                                    </div>
                                    <div class="form-check ml-3">
                                        <input type="radio" class="form-check-input" name="gugup" value="0"
                                            onclick="calculateTotalScore()" id="tidak"
                                            {{ isset($gangguanJiwaRemaja) && $gangguanJiwaRemaja->gugup == 0 ? 'checked' : '' }}>
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
                                        <input type="radio" class="form-check-input" name="baik_pada_anak"
                                            value="2" onclick="calculateTotalScore()" id="benar"
                                            {{ isset($gangguanJiwaRemaja) && $gangguanJiwaRemaja->baik_pada_anak == 2 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="benar">Selalu benar</label>
                                    </div>
                                    <div class="form-check">
                                        <input type="radio" class="form-check-input" name="baik_pada_anak"
                                            value="1" onclick="calculateTotalScore()" id="kadang"
                                            {{ isset($gangguanJiwaRemaja) && $gangguanJiwaRemaja->baik_pada_anak == 1 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="kadang">Kadang benar</label>
                                    </div>
                                    <div class="form-check ml-3">
                                        <input type="radio" class="form-check-input" name="baik_pada_anak"
                                            value="0" onclick="calculateTotalScore()" id="tidak"
                                            {{ isset($gangguanJiwaRemaja) && $gangguanJiwaRemaja->baik_pada_anak == 0 ? 'checked' : '' }}>
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
                                            onclick="calculateTotalScore()" id="benar"
                                            {{ isset($gangguanJiwaRemaja) && $gangguanJiwaRemaja->bohong == 2 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="benar">Selalu benar</label>
                                    </div>
                                    <div class="form-check">
                                        <input type="radio" class="form-check-input" name="bohong" value="1"
                                            onclick="calculateTotalScore()" id="kadang"
                                            {{ isset($gangguanJiwaRemaja) && $gangguanJiwaRemaja->bohong == 1 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="kadang">Kadang benar</label>
                                    </div>
                                    <div class="form-check ml-3">
                                        <input type="radio" class="form-check-input" name="bohong" value="0"
                                            onclick="calculateTotalScore()" id="tidak"
                                            {{ isset($gangguanJiwaRemaja) && $gangguanJiwaRemaja->bohong == 0 ? 'checked' : '' }}>
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
                                            onclick="calculateTotalScore()" id="benar"
                                            {{ isset($gangguanJiwaRemaja) && $gangguanJiwaRemaja->diancam == 2 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="benar">Selalu benar</label>
                                    </div>
                                    <div class="form-check">
                                        <input type="radio" class="form-check-input" name="diancam" value="1"
                                            onclick="calculateTotalScore()" id="kadang"
                                            {{ isset($gangguanJiwaRemaja) && $gangguanJiwaRemaja->diancam == 1 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="kadang">Kadang benar</label>
                                    </div>
                                    <div class="form-check ml-3">
                                        <input type="radio" class="form-check-input" name="diancam" value="0"
                                            onclick="calculateTotalScore()" id="tidak"
                                            {{ isset($gangguanJiwaRemaja) && $gangguanJiwaRemaja->diancam == 0 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="tidak">Tidak benar</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label>20. Sering menawarkan diri untuk membantu orang lain (orang tua, guru, anak-anak
                                    lain) (Pro)?</label>
                                <div class="d-flex">
                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input" name="suka_bantu" value="2"
                                            onclick="calculateTotalScore()" id="benar"
                                            {{ isset($gangguanJiwaRemaja) && $gangguanJiwaRemaja->suka_bantu == 2 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="benar">Selalu benar</label>
                                    </div>
                                    <div class="form-check">
                                        <input type="radio" class="form-check-input" name="suka_bantu" value="1"
                                            onclick="calculateTotalScore()" id="kadang"
                                            {{ isset($gangguanJiwaRemaja) && $gangguanJiwaRemaja->suka_bantu == 1 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="kadang">Kadang benar</label>
                                    </div>
                                    <div class="form-check ml-3">
                                        <input type="radio" class="form-check-input" name="suka_bantu" value="0"
                                            onclick="calculateTotalScore()" id="tidak"
                                            {{ isset($gangguanJiwaRemaja) && $gangguanJiwaRemaja->suka_bantu == 0 ? 'checked' : '' }}>
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
                                            {{ isset($gangguanJiwaRemaja) && $gangguanJiwaRemaja->kritis == 0 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="benar">Selalu benar</label>
                                    </div>
                                    <div class="form-check">
                                        <input type="radio" class="form-check-input" name="kritis" value="1"
                                            onclick="calculateTotalScore()" id="kadang"
                                            {{ isset($gangguanJiwaRemaja) && $gangguanJiwaRemaja->kritis == 1 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="kadang">Kadang benar</label>
                                    </div>
                                    <div class="form-check ml-3">
                                        <input type="radio" class="form-check-input" name="kritis" value="2"
                                            onclick="calculateTotalScore()" id="tidak"
                                            {{ isset($gangguanJiwaRemaja) && $gangguanJiwaRemaja->kritis == 2 ? 'checked' : '' }}>
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
                                            {{ isset($gangguanJiwaRemaja) && $gangguanJiwaRemaja->mencuri == 2 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="benar">Selalu benar</label>
                                    </div>
                                    <div class="form-check">
                                        <input type="radio" class="form-check-input" name="mencuri" value="1"
                                            onclick="calculateTotalScore()" id="kadang"
                                            {{ isset($gangguanJiwaRemaja) && $gangguanJiwaRemaja->mencuri == 1 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="kadang">Kadang benar</label>
                                    </div>
                                    <div class="form-check ml-3">
                                        <input type="radio" class="form-check-input" name="mencuri" value="0"
                                            onclick="calculateTotalScore()" id="tidak"
                                            {{ isset($gangguanJiwaRemaja) && $gangguanJiwaRemaja->mencuri == 0 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="tidak">Tidak benar</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label>23. Lebih mudah berteman dengan orang dewasa daripada dengan anak-anak lain
                                    (P)?</label>
                                <div class="d-flex">
                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input" name="mudah_berteman"
                                            value="2" onclick="calculateTotalScore()" id="benar"
                                            {{ isset($gangguanJiwaRemaja) && $gangguanJiwaRemaja->mudah_berteman == 2 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="benar">Selalu benar</label>
                                    </div>
                                    <div class="form-check">
                                        <input type="radio" class="form-check-input" name="mudah_berteman"
                                            value="1" onclick="calculateTotalScore()" id="kadang"
                                            {{ isset($gangguanJiwaRemaja) && $gangguanJiwaRemaja->mudah_berteman == 1 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="kadang">Kadang benar</label>
                                    </div>
                                    <div class="form-check ml-3">
                                        <input type="radio" class="form-check-input" name="mudah_berteman"
                                            value="0" onclick="calculateTotalScore()" id="tidak"
                                            {{ isset($gangguanJiwaRemaja) && $gangguanJiwaRemaja->mudah_berteman == 0 ? 'checked' : '' }}>
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
                                            {{ isset($gangguanJiwaRemaja) && $gangguanJiwaRemaja->takut == 2 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="benar">Selalu benar</label>
                                    </div>
                                    <div class="form-check">
                                        <input type="radio" class="form-check-input" name="takut" value="1"
                                            onclick="calculateTotalScore()" id="kadang"
                                            {{ isset($gangguanJiwaRemaja) && $gangguanJiwaRemaja->takut == 1 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="kadang">Kadang benar</label>
                                    </div>
                                    <div class="form-check ml-3">
                                        <input type="radio" class="form-check-input" name="takut" value="0"
                                            onclick="calculateTotalScore()" id="tidak"
                                            {{ isset($gangguanJiwaRemaja) && $gangguanJiwaRemaja->takut == 0 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="tidak">Tidak benar</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label>25. Memiliki perhatian yang baik terhadap apapun, mampu menyelesaikan tugas atau
                                    pekerjaan rumah sampai selesai(H)?</label>
                                <div class="d-flex">
                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input" name="rajin" value="0"
                                            onclick="calculateTotalScore()" id="benar"
                                            {{ isset($gangguanJiwaRemaja) && $gangguanJiwaRemaja->rajin == 0 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="benar">Selalu benar</label>
                                    </div>
                                    <div class="form-check">
                                        <input type="radio" class="form-check-input" name="rajin" value="1"
                                            onclick="calculateTotalScore()" id="kadang"
                                            {{ isset($gangguanJiwaRemaja) && $gangguanJiwaRemaja->rajin == 1 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="kadang">Kadang benar</label>
                                    </div>
                                    <div class="form-check ml-3">
                                        <input type="radio" class="form-check-input" name="rajin" value="2"
                                            onclick="calculateTotalScore()" id="tidak"
                                            {{ isset($gangguanJiwaRemaja) && $gangguanJiwaRemaja->rajin == 2 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="tidak">Tidak benar</label>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
            <img src="{{ asset('assets/images/hasil_sdq.png') }}" class="img-fluid mx-auto d-block">
            <div class="form-group mt-4">

                <label for="kesimpulan" style="color: rgb(19, 11, 241);">Kesimpulan</label>
                <textarea class="form-control" id="kesimpulan" name="kesimpulan" placeholder="Kesimpulan">{{ old('kesimpulan', $gangguanJiwaRemaja->kesimpulan ?? '') }}</textarea>


                <label>Skor Total</label>
                <div class="d-flex">
                    <input type="text" class="form-control" id="totalScore" value="0"
                        onclick="calculateTotalScore()" disabled>
                </div>
            </div>
        </div>

        <div class="text-right mt-4">
            @if (isset($gangguanJiwaRemaja) && $gangguanJiwaRemaja)
                <a href="{{ route('sdq.remaja.mtbs.admin') }}" type="button" class="btn btn-secondary mr-2"
                    style="font-size: 20px">Kembali</a>
            @else
                <a href="{{ route('skrining.ilp') }}" type="button" class="btn btn-secondary mr-2"
                    style="font-size: 20px">Kembali</a>
            @endif
            <button type="submit" class="btn btn-primary" style="font-size: 20px">Kirim</button>
        </div>
    </form>

    <script>
        function calculateTotalScore() {
            let totalScore = 0;


            document.querySelectorAll('.form-check-input:checked').forEach((input) => {
                totalScore += parseInt(input.value);
            });


            document.getElementById('totalScore').value = totalScore;
        }


        document.querySelectorAll('.form-check-input').forEach((input) => {
            input.addEventListener('change', calculateTotalScore);
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
