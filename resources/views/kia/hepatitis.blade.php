@extends('layouts.skrining.master')
@section('title', 'Skrining Hepatitis')
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

    <!-- Form Action -->
    <form action="{{ isset($hepatitis) ? route('hepatitis.update', $hepatitis->id) : route('hepatitis.store') }}"
        method="POST">
        @csrf
        @if (isset($hepatitis))
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
                                    data-alamat="{{ $item->address }}" data-jenis_kelamin="{{ $item->genderName->name }}"
                                    {{ old('pasien', $hepatitis->pasien ?? '') == $item->id ? 'selected' : '' }}>
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
                        <input type="date" class="form-control" name="tanggal_lahir" id="tanggal_lahir"
                            value="{{ isset($hepatitis) ? $hepatitis->tanggal_lahir : old('tanggal_lahir') }}">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Alamat Lengkap</label>
                        <input type="text" class="form-control" name="alamat" placeholder="Masukkan alamat lengkap"
                            id="alamat" value="{{ isset($hepatitis) ? $hepatitis->alamat : old('alamat') }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Jenis Kelamin</label>
                        <div class="d-flex">
                            <div class="form-check mr-3">
                                <input type="radio" class="form-check-input" name="jenis_kelamin_kecacingan"
                                    value="laki-laki" id="jk_laki"
                                    {{ old('jenis_kelamin', $kecacingan->jenis_kelamin ?? '') == 'laki-laki' ? 'checked' : '' }}>
                                <label class="form-check-label" for="laki-laki">Laki-laki</label>
                            </div>
                            <div class="form-check">
                                <input type="radio" class="form-check-input" name="jenis_kelamin" value="perempuan"
                                    id="jk_perempuan"
                                    {{ old('jenis_kelamin', $kecacingan->jenis_kelamin ?? '') == 'perempuan' ? 'checked' : '' }}>
                                <label class="form-check-label" for="perempuan">Perempuan</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-section mt-4">
                <h3>Pertanyaan</h3>

                <div class="form-group">
                    <label>1. Apakah anda sudah pernah melakukan pemeriksaan Hepatitis sebelumnya ?</label>
                    <div class="d-flex">
                        <div class="form-check mr-3">
                            <input type="radio" class="form-check-input" name="sudah_periksa_hepatitis" value="0"
                                {{ isset($hepatitis) && $hepatitis->sudah_periksa_hepatitis == 0 ? 'checked' : (old('sudah_periksa_hepatitis') == '0' ? 'checked' : '') }}>
                            <label class="form-check-label">Tidak</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="sudah_periksa_hepatitis" value="1"
                                {{ isset($hepatitis) && $hepatitis->sudah_periksa_hepatitis == 1 ? 'checked' : (old('sudah_periksa_hepatitis') == '1' ? 'checked' : '') }}>
                            <label class="form-check-label">Ya</label>
                        </div>
                    </div>


                </div>


                <div class="form-group">
                    <label>2. Apakah Anda pernah mengalami keluhan:</label>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="keluhan[]" value="mata_kuning"
                                    id="mata_kuning"
                                    {{ isset($hepatitis) && in_array('mata_kuning', $hepatitis->keluhan) ? 'checked' : (old('keluhan') && in_array('mata_kuning', old('keluhan')) ? 'checked' : '') }}>
                                <label class="form-check-label" for="mata_kuning">Mata / kuku / kulit terlihat
                                    kuning</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="keluhan[]" value="lemas"
                                    id="lemas"
                                    {{ isset($hepatitis) && in_array('lemas', $hepatitis->keluhan) ? 'checked' : (old('keluhan') && in_array('lemas', old('keluhan')) ? 'checked' : '') }}>
                                <label class="form-check-label" for="lemas">Lemas/letargi</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="keluhan[]" value="mual"
                                    id="mual"
                                    {{ isset($hepatitis) && in_array('mual', $hepatitis->keluhan) ? 'checked' : (old('keluhan') && in_array('mual', old('keluhan')) ? 'checked' : '') }}>
                                <label class="form-check-label" for="mual">Mual, muntah</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="keluhan[]" value="sakit_perut"
                                    id="sakit_perut"
                                    {{ isset($hepatitis) && in_array('sakit_perut', $hepatitis->keluhan) ? 'checked' : (old('keluhan') && in_array('sakit_perut', old('keluhan')) ? 'checked' : '') }}>
                                <label class="form-check-label" for="sakit_perut">Nyeri perut bagian atas</label>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="keluhan[]" value="feses_pucat"
                                    id="feses_pucat"
                                    {{ isset($hepatitis) && in_array('feses_pucat', $hepatitis->keluhan) ? 'checked' : (old('keluhan') && in_array('feses_pucat', old('keluhan')) ? 'checked' : '') }}>
                                <label class="form-check-label" for="feses_pucat">Warna feses menjadi pucat</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="keluhan[]" value="urin_gelap"
                                    id="urin_gelap"
                                    {{ isset($hepatitis) && in_array('urin_gelap', $hepatitis->keluhan) ? 'checked' : (old('keluhan') && in_array('urin_gelap', old('keluhan')) ? 'checked' : '') }}>
                                <label class="form-check-label" for="urin_gelap">Urin berwarna gelap seperti teh</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="keluhan[]"
                                    value="nafsu_makan_turun" id="nafsu_makan_turun"
                                    {{ isset($hepatitis) && in_array('nafsu_makan_turun', $hepatitis->keluhan) ? 'checked' : (old('keluhan') && in_array('nafsu_makan_turun', old('keluhan')) ? 'checked' : '') }}>
                                <label class="form-check-label" for="nafsu_makan_turun">Penurunan nafsu makan</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="keluhan[]" value="tidak_ada"
                                    id="tidak_ada"
                                    {{ isset($hepatitis) && in_array('tidak_ada', $hepatitis->keluhan) ? 'checked' : (old('keluhan') && in_array('tidak_ada', old('keluhan')) ? 'checked' : '') }}>
                                <label class="form-check-label" for="tidak_ada">Tidak ada keluhan</label>
                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>3. Apakah anda sedang mengalami demam atau riwayat demam dalam 1 minggu
                                    terakhir?</label>
                                <div class="d-flex">
                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input" name="demam" value="0"
                                            {{ isset($hepatitis) && $hepatitis->demam == 0 ? 'checked' : (old('demam') == '0' ? 'checked' : '') }}>
                                        <label class="form-check-label">Tidak</label>
                                    </div>
                                    <div class="form-check">
                                        <input type="radio" class="form-check-input" name="demam" value="1"
                                            {{ isset($hepatitis) && $hepatitis->demam == 1 ? 'checked' : (old('demam') == '1' ? 'checked' : '') }}>
                                        <label class="form-check-label">Ya</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>4. Apakah pernah mendapatkan transfusi darah atau produk darah?</label>
                                <div class="d-flex">
                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input" name="dapat_transfusi_darah"
                                            value="0"
                                            {{ isset($hepatitis) && $hepatitis->dapat_transfusi_darah == 0 ? 'checked' : (old('dapat_transfusi_darah') == '0' ? 'checked' : '') }}>
                                        <label class="form-check-label">Tidak</label>
                                    </div>
                                    <div class="form-check">
                                        <input type="radio" class="form-check-input" name="dapat_transfusi_darah"
                                            value="1"
                                            {{ isset($hepatitis) && $hepatitis->dapat_transfusi_darah == 1 ? 'checked' : (old('dapat_transfusi_darah') == '1' ? 'checked' : '') }}>
                                        <label class="form-check-label">Ya</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>5. Apakah anda pernah atau sering berhubungan seksual yang berisiko seperti pasangan
                                    yang berganti-ganti atau LSL (khusus responden laki-laki)?</label>
                                <div class="d-flex">
                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input" name="sering_seks" value="0"
                                            {{ isset($hepatitis) && $hepatitis->sering_seks == 0 ? 'checked' : (old('sering_seks') == '0' ? 'checked' : '') }}>
                                        <label class="form-check-label">Tidak</label>
                                    </div>
                                    <div class="form-check">
                                        <input type="radio" class="form-check-input" name="sering_seks" value="1"
                                            {{ isset($hepatitis) && $hepatitis->sering_seks == 1 ? 'checked' : (old('sering_seks') == '1' ? 'checked' : '') }}>
                                        <label class="form-check-label">Ya</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>6. Apakah anda pernah menggunakan narkoba suntik?</label>
                                <div class="d-flex">
                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input" name="narkoba" value="0"
                                            {{ isset($hepatitis) && $hepatitis->narkoba == 0 ? 'checked' : (old('narkoba') == '0' ? 'checked' : '') }}>
                                        <label class="form-check-label">Tidak</label>
                                    </div>
                                    <div class="form-check">
                                        <input type="radio" class="form-check-input" name="narkoba" value="1"
                                            {{ isset($hepatitis) && $hepatitis->narkoba == 1 ? 'checked' : (old('narkoba') == '1' ? 'checked' : '') }}>
                                        <label class="form-check-label">Ya</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>7. Apakah anda sudah pernah mendapatkan vaksin hepatitis B?</label>
                                <div class="d-flex">
                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input" name="vaksin_hepatitis_b"
                                            value="0"
                                            {{ isset($hepatitis) && $hepatitis->vaksin_hepatitis_b == 0 ? 'checked' : (old('vaksin_hepatitis_b') == '0' ? 'checked' : '') }}>
                                        <label class="form-check-label">Tidak</label>
                                    </div>
                                    <div class="form-check">
                                        <input type="radio" class="form-check-input" name="vaksin_hepatitis_b"
                                            value="1"
                                            {{ isset($hepatitis) && $hepatitis->vaksin_hepatitis_b == 1 ? 'checked' : (old('vaksin_hepatitis_b') == '1' ? 'checked' : '') }}>
                                        <label class="form-check-label">Ya</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>8. Apakah ada anggota keluarga yang sedang menderita hepatitis / penyakit
                                    kuning?</label>
                                <div class="d-flex">
                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input" name="keluarga_hepatitis"
                                            value="0"
                                            {{ isset($hepatitis) && $hepatitis->keluarga_hepatitis == 0 ? 'checked' : (old('keluarga_hepatitis') == '0' ? 'checked' : '') }}>
                                        <label class="form-check-label">Tidak</label>
                                    </div>
                                    <div class="form-check">
                                        <input type="radio" class="form-check-input" name="keluarga_hepatitis"
                                            value="1"
                                            {{ isset($hepatitis) && $hepatitis->keluarga_hepatitis == 1 ? 'checked' : (old('keluarga_hepatitis') == '1' ? 'checked' : '') }}>
                                        <label class="form-check-label">Ya</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>9. Apakah anda pernah menderita Penyakit menular seksual dalam waktu 1 bulan
                                    terakhir?</label>
                                <div class="d-flex">
                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input" name="menderita_penyakit_menular"
                                            value="0"
                                            {{ isset($hepatitis) && $hepatitis->menderita_penyakit_menular == 0 ? 'checked' : (old('menderita_penyakit_menular') == '0' ? 'checked' : '') }}>
                                        <label class="form-check-label">Tidak</label>
                                    </div>
                                    <div class="form-check">
                                        <input type="radio" class="form-check-input" name="menderita_penyakit_menular"
                                            value="1"
                                            {{ isset($hepatitis) && $hepatitis->menderita_penyakit_menular == 1 ? 'checked' : (old('menderita_penyakit_menular') == '1' ? 'checked' : '') }}>
                                        <label class="form-check-label">Ya</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>10. Apakah anda sudah pernah di tes HIV sebelumnya? Apa hasilnya?</label>
                                <div class="d-flex">
                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input" name="hasil_hiv" value="2"
                                            {{ isset($hepatitis) && $hepatitis->hasil_hiv == 2 ? 'checked' : (old('hasil_hiv') == '2' ? 'checked' : '') }}>
                                        <label class="form-check-label">Pernah, hasil (+)</label>
                                    </div>
                                    <div class="form-check">
                                        <input type="radio" class="form-check-input" name="hasil_hiv" value="1"
                                            {{ isset($hepatitis) && $hepatitis->hasil_hiv == 1 ? 'checked' : (old('hasil_hiv') == '1' ? 'checked' : '') }}>
                                        <label class="form-check-label">Pernah, hasil (-)</label>
                                    </div>
                                    <div class="form-check ml-3">
                                        <input type="radio" class="form-check-input" name="hasil_hiv" value="0"
                                            {{ isset($hepatitis) && $hepatitis->hasil_hiv == 0 ? 'checked' : (old('hasil_hiv') == '0' ? 'checked' : '') }}>
                                        <label class="form-check-label">Belum pernah</label>
                                    </div>
                                </div>
                            </div>
                        </div>




                    </div>


                </div>
            </div>
            <div class="form-group">
                <div class="col-md-12">
                    <label for="kesimpulan" style="color: rgb(19, 11, 241);">Kesimpulan</label>
                    <textarea class="form-control" id="kesimpulan" name="kesimpulan" placeholder="Kesimpulan">{{ old('kesimpulan', $hepatitis->kesimpulan ?? '') }}</textarea>
                </div>
            </div>
            <div class="text-right mt-4">
                @if (isset($hepatitis))
                    <a href="{{ route('hepatitis.admin') }}" type="button" class="btn btn-secondary mr-2"
                        style="font-size: 20px">Kembali</a>
                @else
                    <a href="{{ route('skrining.ilp') }}" type="button" class="btn btn-secondary mr-2"
                        style="font-size: 20px">Kembali</a>
                @endif
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

            $('#pasien').on('change', function() {
                var selectedOption = $(this).find(':selected');

                var dob = selectedOption.data('dob');
                var alamat = selectedOption.data('alamat');
                var jk = selectedOption.data('jenis_kelamin');



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
