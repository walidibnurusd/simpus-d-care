@extends('layouts.skrining.master')
@section('title', 'Skrining HIV/AIDS')
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

    <form action="{{ isset($hiv) ? route('hiv.update', $hiv->id) : route('hiv.store') }}" method="POST">
        @csrf
        @if (isset($hiv))
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
                                    data-pob="{{ $item->place_birth }}"
                                    {{ old('pasien', $hiv->pasien ?? '') == $item->id ? 'selected' : '' }}>
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
                            value="{{ old('tanggal_lahir', $hiv->tanggal_lahir ?? '') }}">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Alamat Lengkap</label>
                        <input type="text" class="form-control" name="alamat" id="alamat"
                            value="{{ old('alamat', $hiv->alamat ?? '') }}" placeholder="Masukkan alamat lengkap">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Jenis Kelamin</label>
                        <div class="d-flex">
                            <div class="form-check mr-3">
                                <input type="radio" class="form-check-input" name="jenis_kelamin" value="laki-laki"
                                    id="jk_laki"
                                    {{ old('jenis_kelamin', $hiv->jenis_kelamin ?? '') == 'laki-laki' ? 'checked' : '' }}>
                                <label class="form-check-label" for="laki-laki">Laki-laki</label>
                            </div>
                            <div class="form-check">
                                <input type="radio" class="form-check-input" name="jenis_kelamin" value="perempuan"
                                    id="jk_perempuan"
                                    {{ old('jenis_kelamin', $hiv->jenis_kelamin ?? '') == 'perempuan' ? 'checked' : '' }}>
                                <label class="form-check-label" for="perempuan">Perempuan</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Screening Questions Section -->
            <div class="form-section mt-4">
                <h3>Pertanyaan</h3>
                <div class="form-group">
                    <label>1. Apakah anda pernah melakukan tes HIV?</label>
                    <div class="d-flex">
                        <div class="form-check mr-3">
                            <input type="radio" class="form-check-input" name="tes_hiv" value="1" id="tes_hiv_ya"
                                {{ old('tes_hiv', $hiv->tes_hiv ?? '') == 1 ? 'checked' : '' }}
                                onchange="toggleFollowUpQuestions()">
                            <label class="form-check-label" for="tes_hiv_ya">Ya</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="tes_hiv" value="0" id="tes_hiv_tidak"
                                {{ old('tes_hiv', $hiv->tes_hiv ?? '') == 0 ? 'checked' : '' }}
                                onchange="toggleFollowUpQuestions()">
                            <label class="form-check-label" for="tes_hiv_tidak">Tidak</label>
                        </div>
                    </div>
                </div>
            </div>


            <div id="last_test_date" style="display: none;">
                <div class="form-group">
                    <label>2. Kapan terakhir Anda melakukan pemeriksaan HIV?</label>
                    <input type="date" class="form-control" name="tanggal_tes_terakhir"
                        value="{{ isset($hiv->tanggal_tes_terakhir) ? $hiv->tanggal_tes_terakhir : '' }}">
                </div>

                <div class="form-group">
                    <label>3. Apakah anda mengalami penurunan berat badan drastis dalam 3 bulan terakhir tanpa ada upaya
                        diet?</label>
                    <div class="d-flex">
                        <div class="form-check mr-3">
                            <input type="radio" class="form-check-input" name="penurunan_berat" value="1"
                                {{ isset($hiv->penurunan_berat) && $hiv->penurunan_berat == 1 ? 'checked' : '' }}>
                            <label class="form-check-label">Ya</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="penurunan_berat" value="0"
                                {{ isset($hiv->penurunan_berat) && $hiv->penurunan_berat == 0 ? 'checked' : '' }}>
                            <label class="form-check-label">Tidak</label>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label>4. Bila iya, berapa penurunan berat badanya?</label>
                    <div class="d-flex">
                        <div class="form-check mr-3">
                            <input type="radio" class="form-check-input" name="jumlah_berat_badan_turun"
                                value="1"
                                {{ isset($hiv->jumlah_berat_badan_turun) && $hiv->jumlah_berat_badan_turun == 1 ? 'checked' : '' }}>
                            <label class="form-check-label">Ya</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="jumlah_berat_badan_turun"
                                value="0"
                                {{ isset($hiv->jumlah_berat_badan_turun) && $hiv->jumlah_berat_badan_turun == 0 ? 'checked' : '' }}>
                            <label class="form-check-label">Tidak</label>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label>5. Apakah anda sedang menderita penyakit kulit seperti ruam merah, koreng kekuningan, atau
                        herpes?</label>
                    <div class="d-flex">
                        <div class="form-check mr-3">
                            <input type="radio" class="form-check-input" name="penyakit_kulit" value="1"
                                {{ isset($hiv->penyakit_kulit) && $hiv->penyakit_kulit == 1 ? 'checked' : '' }}>
                            <label class="form-check-label">Ya</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="penyakit_kulit" value="0"
                                {{ isset($hiv->penyakit_kulit) && $hiv->penyakit_kulit == 0 ? 'checked' : '' }}>
                            <label class="form-check-label">Tidak</label>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label>6. Apakah anda mengalami gejala ISPA (flu, sinusitis) yang berulang?</label>
                    <div class="d-flex">
                        <div class="form-check mr-3">
                            <input type="radio" class="form-check-input" name="gejala_ispa" value="1"
                                {{ isset($hiv->gejala_ispa) && $hiv->gejala_ispa == 1 ? 'checked' : '' }}>
                            <label class="form-check-label">Ya</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="gejala_ispa" value="0"
                                {{ isset($hiv->gejala_ispa) && $hiv->gejala_ispa == 0 ? 'checked' : '' }}>
                            <label class="form-check-label">Tidak</label>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label>7. Apakah terdapat gejala seperti sariawan kronis dan atau diare kronis lebih dari 1
                        bulan?</label>
                    <div class="d-flex">
                        <div class="form-check mr-3">
                            <input type="radio" class="form-check-input" name="gejala_sariawan" value="1"
                                {{ isset($hiv->gejala_sariawan) && $hiv->gejala_sariawan == 1 ? 'checked' : '' }}>
                            <label class="form-check-label">Ya</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="gejala_sariawan" value="0"
                                {{ isset($hiv->gejala_sariawan) && $hiv->gejala_sariawan == 0 ? 'checked' : '' }}>
                            <label class="form-check-label">Tidak</label>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label>8. Apakah ada riwayat atau sedang menderita batuk sesak (Pneumonia) ataupun TBC dalam 1 tahun
                        terakhir?</label>
                    <div class="d-flex">
                        <div class="form-check mr-3">
                            <input type="radio" class="form-check-input" name="riwayat_sesak" value="1"
                                {{ isset($hiv->riwayat_sesak) && $hiv->riwayat_sesak == 1 ? 'checked' : '' }}>
                            <label class="form-check-label">Ya</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="riwayat_sesak" value="0"
                                {{ isset($hiv->riwayat_sesak) && $hiv->riwayat_sesak == 0 ? 'checked' : '' }}>
                            <label class="form-check-label">Tidak</label>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label>9. Apakah anda memiliki riwayat Hepatitis B / C?</label>
                    <div class="d-flex">
                        <div class="form-check mr-3">
                            <input type="radio" class="form-check-input" name="riwayat_hepatitis" value="1"
                                {{ isset($hiv->riwayat_hepatitis) && $hiv->riwayat_hepatitis == 1 ? 'checked' : '' }}>
                            <label class="form-check-label">Ya</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="riwayat_hepatitis" value="0"
                                {{ isset($hiv->riwayat_hepatitis) && $hiv->riwayat_hepatitis == 0 ? 'checked' : '' }}>
                            <label class="form-check-label">Tidak</label>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label>10. Apakah dalam 3 bulan terakhir melakukan perilaku seksual berisiko seperti seks bebas (dengan
                        WPS) baik dengan maupun tanpa pengaman, berganti-ganti pasangan seksual, atau hubungan seksual
                        sesama jenis?</label>
                    <div class="d-flex">
                        <div class="form-check mr-3">
                            <input type="radio" class="form-check-input" name="riwayat_seks_bebas" value="1"
                                {{ isset($hiv->riwayat_seks_bebas) && $hiv->riwayat_seks_bebas == 1 ? 'checked' : '' }}>
                            <label class="form-check-label">Ya</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="riwayat_seks_bebas" value="0"
                                {{ isset($hiv->riwayat_seks_bebas) && $hiv->riwayat_seks_bebas == 0 ? 'checked' : '' }}>
                            <label class="form-check-label">Tidak</label>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label>11. Apakah ada riwayat penggunaan obat-obat terlarang (narkoba suntik)?</label>
                    <div class="d-flex">
                        <div class="form-check mr-3">
                            <input type="radio" class="form-check-input" name="riwayat_narkoba" value="1"
                                {{ isset($hiv->riwayat_narkoba) && $hiv->riwayat_narkoba == 1 ? 'checked' : '' }}>
                            <label class="form-check-label">Ya</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="riwayat_narkoba" value="0"
                                {{ isset($hiv->riwayat_narkoba) && $hiv->riwayat_narkoba == 0 ? 'checked' : '' }}>
                            <label class="form-check-label">Tidak</label>
                        </div>
                    </div>
                </div>
            </div>



            <div id="symptom_questions" style="display: none;">
                <div class="form-group">
                    <label>2. Apakah anda mengalami penurunan berat badan drastis dalam 3 bulan terakhir tanpa ada upaya
                        diet?</label>
                    <div class="d-flex">
                        <div class="form-check mr-3">
                            <input type="radio" class="form-check-input" name="penurunan_berat" value="1"
                                {{ isset($hiv->penurunan_berat) && $hiv->penurunan_berat == 1 ? 'checked' : '' }}>
                            <label class="form-check-label">Ya</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="penurunan_berat" value="0"
                                {{ isset($hiv->penurunan_berat) && $hiv->penurunan_berat == 0 ? 'checked' : '' }}>
                            <label class="form-check-label">Tidak</label>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label>3. Bila iya, berapa penurunan berat badanya?</label>
                    <div class="d-flex">
                        <div class="form-check mr-3">
                            <input type="radio" class="form-check-input" name="jumlah_berat_badan_turun"
                                value="1"
                                {{ isset($hiv->jumlah_berat_badan_turun) && $hiv->jumlah_berat_badan_turun == 1 ? 'checked' : '' }}>
                            <label class="form-check-label">Ya</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="jumlah_berat_badan_turun"
                                value="0"
                                {{ isset($hiv->jumlah_berat_badan_turun) && $hiv->jumlah_berat_badan_turun == 0 ? 'checked' : '' }}>
                            <label class="form-check-label">Tidak</label>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label>4. Apakah anda sedang menderita penyakit kulit seperti ruam merah, koreng kekuningan, atau
                        herpes?</label>
                    <div class="d-flex">
                        <div class="form-check mr-3">
                            <input type="radio" class="form-check-input" name="penyakit_kulit" value="1"
                                {{ isset($hiv->penyakit_kulit) && $hiv->penyakit_kulit == 1 ? 'checked' : '' }}>
                            <label class="form-check-label">Ya</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="penyakit_kulit" value="0"
                                {{ isset($hiv->penyakit_kulit) && $hiv->penyakit_kulit == 0 ? 'checked' : '' }}>
                            <label class="form-check-label">Tidak</label>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label>5. Apakah anda mengalami gejala ISPA (flu, sinusitis) yang berulang?</label>
                    <div class="d-flex">
                        <div class="form-check mr-3">
                            <input type="radio" class="form-check-input" name="gejala_ispa" value="1"
                                {{ isset($hiv->gejala_ispa) && $hiv->gejala_ispa == 1 ? 'checked' : '' }}>
                            <label class="form-check-label">Ya</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="gejala_ispa" value="0"
                                {{ isset($hiv->gejala_ispa) && $hiv->gejala_ispa == 0 ? 'checked' : '' }}>
                            <label class="form-check-label">Tidak</label>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label>6. Apakah terdapat gejala seperti sariawan kronis dan atau diare kronis lebih dari 1
                        bulan?</label>
                    <div class="d-flex">
                        <div class="form-check mr-3">
                            <input type="radio" class="form-check-input" name="gejala_sariawan" value="1"
                                {{ isset($hiv->gejala_sariawan) && $hiv->gejala_sariawan == 1 ? 'checked' : '' }}>
                            <label class="form-check-label">Ya</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="gejala_sariawan" value="0"
                                {{ isset($hiv->gejala_sariawan) && $hiv->gejala_sariawan == 0 ? 'checked' : '' }}>
                            <label class="form-check-label">Tidak</label>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label>7. Apakah ada riwayat atau sedang menderita batuk sesak (Pneumonia) ataupun TBC dalam 1 tahun
                        terakhir?</label>
                    <div class="d-flex">
                        <div class="form-check mr-3">
                            <input type="radio" class="form-check-input" name="riwayat_sesak" value="1"
                                {{ isset($hiv->riwayat_sesak) && $hiv->riwayat_sesak == 1 ? 'checked' : '' }}>
                            <label class="form-check-label">Ya</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="riwayat_sesak" value="0"
                                {{ isset($hiv->riwayat_sesak) && $hiv->riwayat_sesak == 0 ? 'checked' : '' }}>
                            <label class="form-check-label">Tidak</label>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label>8. Apakah anda memiliki riwayat Hepatitis B / C?</label>
                    <div class="d-flex">
                        <div class="form-check mr-3">
                            <input type="radio" class="form-check-input" name="riwayat_hepatitis" value="1"
                                {{ isset($hiv->riwayat_hepatitis) && $hiv->riwayat_hepatitis == 1 ? 'checked' : '' }}>
                            <label class="form-check-label">Ya</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="riwayat_hepatitis" value="0"
                                {{ isset($hiv->riwayat_hepatitis) && $hiv->riwayat_hepatitis == 0 ? 'checked' : '' }}>
                            <label class="form-check-label">Tidak</label>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label>9. Apakah dalam 3 bulan terakhir melakukan perilaku seksual berisiko seperti seks bebas (dengan
                        WPS) baik dengan maupun tanpa pengaman, berganti-ganti pasangan seksual, atau hubungan seksual
                        sesama jenis?</label>
                    <div class="d-flex">
                        <div class="form-check mr-3">
                            <input type="radio" class="form-check-input" name="riwayat_seks_bebas" value="1"
                                {{ isset($hiv->riwayat_seks_bebas) && $hiv->riwayat_seks_bebas == 1 ? 'checked' : '' }}>
                            <label class="form-check-label">Ya</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="riwayat_seks_bebas" value="0"
                                {{ isset($hiv->riwayat_seks_bebas) && $hiv->riwayat_seks_bebas == 0 ? 'checked' : '' }}>
                            <label class="form-check-label">Tidak</label>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label>10. Apakah ada riwayat penggunaan obat-obat terlarang (narkoba suntik)?</label>
                    <div class="d-flex">
                        <div class="form-check mr-3">
                            <input type="radio" class="form-check-input" name="riwayat_narkoba" value="1"
                                {{ isset($hiv->riwayat_narkoba) && $hiv->riwayat_narkoba == 1 ? 'checked' : '' }}>
                            <label class="form-check-label">Ya</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="riwayat_narkoba" value="0"
                                {{ isset($hiv->riwayat_narkoba) && $hiv->riwayat_narkoba == 0 ? 'checked' : '' }}>
                            <label class="form-check-label">Tidak</label>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label>11. Apakah anda memiliki riwayat penyakit menular seksual yang berulang?</label>
                    <div class="d-flex">
                        <div class="form-check mr-3">
                            <input type="radio" class="form-check-input" name="riwayat_penyakit_menular"
                                value="1"
                                {{ isset($hiv->riwayat_penyakit_menular) && $hiv->riwayat_penyakit_menular == 1 ? 'checked' : '' }}>
                            <label class="form-check-label">Ya</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="riwayat_penyakit_menular"
                                value="0"
                                {{ isset($hiv->riwayat_penyakit_menular) && $hiv->riwayat_penyakit_menular == 0 ? 'checked' : '' }}>
                            <label class="form-check-label">Tidak</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-12">
                    <label for="kesimpulan" style="color: rgb(19, 11, 241);">Kesimpulan</label>
                    <textarea class="form-control" id="kesimpulan" name="kesimpulan" placeholder="Kesimpulan">{{ old('kesimpulan', $hiv->kesimpulan ?? '') }}</textarea>
                </div>
            </div>
        </div>



        <div class="text-right mt-4">
            {{-- @if (isset($hiv))
                <a href="{{ route('hiv.admin') }}" type="button" class="btn btn-secondary mr-2"
                    style="font-size: 20px">Kembali</a>
            @else
                <a href="{{ route('skrining.ilp') }}" type="button" class="btn btn-secondary mr-2"
                    style="font-size: 20px">Kembali</a>
            @endif --}}
            <button type="submit" class="btn btn-primary" style="font-size: 20px">Kirim</button>
        </div>
    </form>

    <!-- JavaScript for toggling question visibility -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            toggleFollowUpQuestions(); // Menjalankan fungsi saat DOM siap
            populateFormData(); // Mengisi form dengan data jika ada (untuk edit)
        });

        function toggleFollowUpQuestions() {
            const tesHivYa = document.getElementById('tes_hiv_ya').checked;
            const tesHivTidak = document.getElementById('tes_hiv_tidak').checked;

            // Tampilkan pertanyaan terkait (2-11) jika jawabannya "Ya" pada tes HIV
            document.getElementById('last_test_date').style.display = tesHivYa ? 'block' : 'none';
            document.getElementById('symptom_questions').style.display = tesHivTidak ? 'block' : 'none';
        }

        function populateFormData() {
            const formData = {!! json_encode($hiv ?? null) !!}; // Mengambil data hiv jika ada

            // Mengisi data pada form berdasarkan jawaban yang sudah ada
            if (formData) {
                // Mengecek apakah tes HIV sudah dilakukan (pertanyaan 1)
                if (formData.tes_hiv === 1) {
                    document.getElementById('tes_hiv_ya').checked = true;
                    toggleFollowUpQuestions(); // Menampilkan pertanyaan terkait jika "Ya"
                } else {
                    document.getElementById('tes_hiv_tidak').checked = true;
                    toggleFollowUpQuestions(); // Menampilkan pertanyaan gejala jika "Tidak"
                }

                // Mengisi data untuk pertanyaan 2-11 jika tersedia dan tes HIV "Ya"
                if (formData.tes_hiv === 1) {
                    if (formData.tanggal_tes_terakhir) {
                        document.querySelector('input[name="tanggal_tes_terakhir"]').value = formData.tanggal_tes_terakhir;
                    }

                    // Mengisi jawaban untuk pertanyaan 3-11
                    const questionNames = [
                        'penurunan_berat', 'jumlah_berat_badan_turun', 'penyakit_kulit', 'gejala_ispa',
                        'gejala_sariawan',
                        'riwayat_sesak', 'riwayat_hepatitis', 'riwayat_seks_bebas', 'riwayat_narkoba',
                        'riwayat_penyakit_menular'
                    ];

                    questionNames.forEach(name => {
                        const value = formData[name];
                        if (value !== undefined) {
                            const radioBtn = document.querySelector(`input[name="${name}"][value="${value}"]`);
                            if (radioBtn) radioBtn.checked = true;
                        }
                    });
                }

                // Jika jawabannya "Tidak" pada tes HIV, tampilkan pertanyaan gejala
                if (formData.tes_hiv === 0) {
                    document.getElementById('symptom_questions').style.display = 'block';
                }
            }
        }
    </script>
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
                var pob = selectedOption.data('pob');



                $('#tanggal_lahir').val(dob);
                $('#alamat').val(alamat);
                $('#tempat_lahir').val(pob);
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
