@extends('layouts.skrining.master')
@section('title', 'Skrining Kecacingan')
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

    <form action="{{ isset($kecacingan) ? route('kecacingan.update', $kecacingan->id) : route('kecacingan.store') }}"
        method="POST">
        @csrf
        @if (isset($kecacingan))
            @method('PUT')
        @endif
        <div class="form-section">
            <h3>Identitas</h3>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Nama</label>
                        <input type="text" class="form-control" name="nama" placeholder="Masukkan nama lengkap"
                            value="{{ old('nama', isset($kecacingan) ? $kecacingan->nama : '') }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Tanggal Lahir</label>
                        <input type="date" class="form-control" name="tanggal_lahir"
                            value="{{ old('tanggal_lahir', isset($kecacingan) ? $kecacingan->tanggal_lahir : '') }}">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Alamat Lengkap</label>
                        <input type="text" class="form-control" name="alamat" placeholder="Masukkan alamat lengkap"
                            value="{{ old('alamat', isset($kecacingan) ? $kecacingan->alamat : '') }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Jenis Kelamin</label>
                        <div class="d-flex">
                            <div class="form-check mr-3">
                                <input type="radio" class="form-check-input" name="jenis_kelamin" value="laki-laki"
                                    id="laki-laki"
                                    {{ old('jenis_kelamin', isset($kecacingan) ? $kecacingan->jenis_kelamin : '') == 'laki-laki' ? 'checked' : '' }}>
                                <label class="form-check-label" for="laki-laki">Laki-laki</label>
                            </div>
                            <div class="form-check">
                                <input type="radio" class="form-check-input" name="jenis_kelamin" value="perempuan"
                                    id="perempuan"
                                    {{ old('jenis_kelamin', isset($kecacingan) ? $kecacingan->jenis_kelamin : '') == 'perempuan' ? 'checked' : '' }}>
                                <label class="form-check-label" for="perempuan">Perempuan</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Penyakit Section -->
            <div class="form-section mt-4">
                <h3>Pertanyaan</h3>
                <div class="form-group">
                    <label>1. Apakah anda sering mengeluh sakit perut, mual dan muntah ?</label>
                    <div class="d-flex">
                        <div class="form-check mr-3">
                            <input type="radio" class="form-check-input" name="sakit_perut" value="1"
                                id="ya_sakit_perut"
                                {{ isset($kecacingan->sakit_perut) && $kecacingan->sakit_perut == 1 ? 'checked' : '' }}>
                            <label class="form-check-label" for="ya_sakit_perut">Ya</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="sakit_perut" value="0"
                                id="tidak_sakit_perut"
                                {{ isset($kecacingan->sakit_perut) && $kecacingan->sakit_perut == 0 ? 'checked' : '' }}>
                            <label class="form-check-label" for="tidak_sakit_perut">Tidak</label>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label>2. Apakah anda sering mengalami diare / bab cair?</label>
                    <div class="d-flex">
                        <div class="form-check mr-3">
                            <input type="radio" class="form-check-input" name="diare" value="1" id="ya_diare"
                                {{ isset($kecacingan->diare) && $kecacingan->diare == 1 ? 'checked' : '' }}>
                            <label class="form-check-label" for="ya_diare">Ya</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="diare" value="0" id="tidak_diare"
                                {{ isset($kecacingan->diare) && $kecacingan->diare == 0 ? 'checked' : '' }}>
                            <label class="form-check-label" for="tidak_diare">Tidak</label>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label>3. Apakah ada riwayat BAB bercampur darah ?</label>
                    <div class="d-flex">
                        <div class="form-check mr-3">
                            <input type="radio" class="form-check-input" name="bab_darah" value="1"
                                id="ya_bab_darah"
                                {{ isset($kecacingan->bab_darah) && $kecacingan->bab_darah == 1 ? 'checked' : '' }}>
                            <label class="form-check-label" for="ya_bab_darah">Ya</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="bab_darah" value="0"
                                id="tidak_bab_darah"
                                {{ isset($kecacingan->bab_darah) && $kecacingan->bab_darah == 0 ? 'checked' : '' }}>
                            <label class="form-check-label" for="tidak_bab_darah">Tidak</label>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label>4. Apakah pernah pada saat BAB terdapat cacing di feses ?</label>
                    <div class="d-flex">
                        <div class="form-check mr-3">
                            <input type="radio" class="form-check-input" name="bab_cacing" value="1"
                                id="ya_bab_cacing"
                                {{ isset($kecacingan->bab_cacing) && $kecacingan->bab_cacing == 1 ? 'checked' : '' }}>
                            <label class="form-check-label" for="ya_bab_cacing">Ya</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="bab_cacing" value="0"
                                id="tidak_bab_cacing"
                                {{ isset($kecacingan->bab_cacing) && $kecacingan->bab_cacing == 0 ? 'checked' : '' }}>
                            <label class="form-check-label" for="tidak_bab_cacing">Tidak</label>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label>5. Apakah anda mengalami penurunan nafsu makan sehingga berat badan menurun?</label>
                    <div class="d-flex">
                        <div class="form-check mr-3">
                            <input type="radio" class="form-check-input" name="nafsu_makan_turun" value="1"
                                id="ya_nafsu_makan"
                                {{ isset($kecacingan->nafsu_makan_turun) && $kecacingan->nafsu_makan_turun == 1 ? 'checked' : '' }}>
                            <label class="form-check-label" for="ya_nafsu_makan">Ya</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="nafsu_makan_turun" value="0"
                                id="tidak_nafsu_makan"
                                {{ isset($kecacingan->nafsu_makan_turun) && $kecacingan->nafsu_makan_turun == 0 ? 'checked' : '' }}>
                            <label class="form-check-label" for="tidak_nafsu_makan">Tidak</label>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label>6. Apakah anda mengeluh gatal di sekitar anus / iritasi pada anus karena gatal?</label>
                    <div class="d-flex">
                        <div class="form-check mr-3">
                            <input type="radio" class="form-check-input" name="gatal" value="1" id="ya_gatal"
                                {{ isset($kecacingan->gatal) && $kecacingan->gatal == 1 ? 'checked' : '' }}>
                            <label class="form-check-label" for="ya_gatal">Ya</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="gatal" value="0"
                                id="tidak_gatal"
                                {{ isset($kecacingan->gatal) && $kecacingan->gatal == 0 ? 'checked' : '' }}>
                            <label class="form-check-label" for="tidak_gatal">Tidak</label>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label>7. Apakah badan anda terasa lemah letih lesu?</label>
                    <div class="d-flex">
                        <div class="form-check mr-3">
                            <input type="radio" class="form-check-input" name="badan_lemah" value="1"
                                id="ya_badan_lemah"
                                {{ isset($kecacingan->badan_lemah) && $kecacingan->badan_lemah == 1 ? 'checked' : '' }}>
                            <label class="form-check-label" for="ya_badan_lemah">Ya</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="badan_lemah" value="0"
                                id="tidak_badan_lemah"
                                {{ isset($kecacingan->badan_lemah) && $kecacingan->badan_lemah == 0 ? 'checked' : '' }}>
                            <label class="form-check-label" for="tidak_badan_lemah">Tidak</label>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label>8. Apakah kulit terlihat pucat?</label>
                    <div class="d-flex">
                        <div class="form-check mr-3">
                            <input type="radio" class="form-check-input" name="kulit_pucat" value="1"
                                id="ya_kulit_pucat"
                                {{ isset($kecacingan->kulit_pucat) && $kecacingan->kulit_pucat == 1 ? 'checked' : '' }}>
                            <label class="form-check-label" for="ya_kulit_pucat">Ya</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="kulit_pucat" value="0"
                                id="tidak_kulit_pucat"
                                {{ isset($kecacingan->kulit_pucat) && $kecacingan->kulit_pucat == 0 ? 'checked' : '' }}>
                            <label class="form-check-label" for="tidak_kulit_pucat">Tidak</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="text-right mt-4">
                @if (isset($kecacingan))
                <a href="{{ route('kecacingan.admin') }}" type="button" class="btn btn-secondary mr-2" style="font-size: 20px">Kembali</a>
            @else
                <a href="{{ route('skrining.ilp') }}" type="button" class="btn btn-secondary mr-2" style="font-size: 20px">Kembali</a>
            @endif
                <button type="submit" class="btn btn-primary" style="font-size: 20px">Kirim</button>
            </div>
    </form>
@endsection
