@extends('layouts.skrining.master')
@section('title', 'Skrining Hipertensi')
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

    <form action="{{ isset($hipertensi) ? route('hipertensi.update', $hipertensi->id) : route('hipertensi.store') }}"
        method="POST">
        @csrf
        @if (isset($hipertensi))
            @method('PUT')
        @endif
        @if ($routeName === 'hipertensi.view')
            <input type="hidden" name="klaster" value="2">
            <input type="hidden" name="poli" value="kia">
        @elseif($routeName === 'hipertensi.mtbs.view')
            <input type="hidden" name="klaster" value="2">
            <input type="hidden" name="poli" value="mtbs">
        @elseif($routeName === 'hipertensi.lansia.view')
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
                            @foreach ($pasien as $item)
                                <option value="{{ $item->id }}" data-no_hp="{{ $item->phone }}"
                                    data-nik="{{ $item->nik }}" data-dob="{{ $item->dob }}"
                                    data-jenis_kelamin="{{ $item->genderName->name }}" data-alamat="{{ $item->address }}"
                                    {{ old('pasien', $hipertensi->pasien ?? '') == $item->id ? 'selected' : '' }}>
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
                            value="{{ old('tanggal_lahir', $hipertensi->tanggal_lahir ?? '') }}">
                    </div>
                </div>
            </div>

            <div class="row">

                <div class="col-md-6">
                    <div class="form-group">
                        <label>Alamat Lengkap</label>
                        <input type="text" class="form-control" name="alamat" id="alamat"
                            value="{{ old('alamat', $hipertensi->alamat ?? '') }}" placeholder="Masukkan alamat lengkap">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Jenis Kelamin</label>
                        <div class="d-flex">
                            <div class="form-check mr-3">
                                <input type="radio" class="form-check-input" name="jenis_kelamin" value="laki-laki"
                                    id="jk_laki"
                                    {{ old('jenis_kelamin', $hipertensi->jenis_kelamin ?? '') == 'laki-laki' ? 'checked' : '' }}>
                                <label class="form-check-label" for="laki-laki">Laki-laki</label>
                            </div>
                            <div class="form-check">
                                <input type="radio" class="form-check-input" name="jenis_kelamin" value="perempuan"
                                    id="jk_perempuan"
                                    {{ old('jenis_kelamin', $hipertensi->jenis_kelamin ?? '') == 'perempuan' ? 'checked' : '' }}>
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
                    <label>1. Apakah ayah atau ibu kandung Anda menderita tekanan darah tinggi?</label>
                    <div class="d-flex">
                        <div class="form-check mr-3">
                            <input type="radio" class="form-check-input" name="ortu_hipertensi" value="1"
                                data-score="1" onchange="calculateTotalScore()" id="ya"
                                {{ old('ortu_hipertensi', $hipertensi->ortu_hipertensi ?? '') == '1' ? 'checked' : '' }}>
                            <label class="form-check-label" for="ya">Ya</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="ortu_hipertensi" value="0"
                                data-score="0" onchange="calculateTotalScore()" id="tidak"
                                {{ old('ortu_hipertensi', $hipertensi->ortu_hipertensi ?? '') == '0' ? 'checked' : '' }}>
                            <label class="form-check-label" for="tidak">Tidak</label>
                        </div>
                    </div>

                </div>
                <div class="form-group">
                    <label>2. Apakah saudara sekandung Anda ada yang menderita tekanan darah tinggi?</label>
                    <div class="d-flex">
                        <div class="form-check mr-3">
                            <input type="radio" class="form-check-input" name="saudara_hipertensi" value="1"
                                data-score="1" onchange="calculateTotalScore()" id="saudara_ya"
                                {{ old('saudara_hipertensi', $hipertensi->saudara_hipertensi ?? '') == '1' ? 'checked' : '' }}>
                            <label class="form-check-label" for="saudara_ya">Ya</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="saudara_hipertensi" value="0"
                                data-score="0" onchange="calculateTotalScore()" id="saudara_tidak"
                                {{ old('saudara_hipertensi', $hipertensi->saudara_hipertensi ?? '') == '0' ? 'checked' : '' }}>
                            <label class="form-check-label" for="saudara_tidak">Tidak</label>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label>3. Apakah tubuh Anda sekarang gemuk?</label>
                    <div class="d-flex">
                        <div class="form-check mr-3">
                            <input type="radio" class="form-check-input" name="tubuh_gemuk" value="1"
                                data-score="1" onchange="calculateTotalScore()" id="gemuk_ya"
                                {{ old('tubuh_gemuk', $hipertensi->tubuh_gemuk ?? '') == '1' ? 'checked' : '' }}>
                            <label class="form-check-label" for="gemuk_ya">Ya</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="tubuh_gemuk" value="0"
                                data-score="0" onchange="calculateTotalScore()" id="gemuk_tidak"
                                {{ old('tubuh_gemuk', $hipertensi->tubuh_gemuk ?? '') == '0' ? 'checked' : '' }}>
                            <label class="form-check-label" for="gemuk_tidak">Tidak</label>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label>4. Apakah Anda sekarang berusia 50 tahun?</label>
                    <div class="d-flex">
                        <div class="form-check mr-3">
                            <input type="radio" class="form-check-input" name="usia_50" value="1" data-score="1"
                                onchange="calculateTotalScore()" id="usia50_ya"
                                {{ old('usia_50', $hipertensi->usia_50 ?? '') == '1' ? 'checked' : '' }}>
                            <label class="form-check-label" for="usia50_ya">Ya</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="usia_50" value="0" data-score="0"
                                onchange="calculateTotalScore()" id="usia50_tidak"
                                {{ old('usia_50', $hipertensi->usia_50 ?? '') == '0' ? 'checked' : '' }}>
                            <label class="form-check-label" for="usia50_tidak">Tidak</label>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label>5. Apakah Anda selama ini merokok?</label>
                    <div class="d-flex">
                        <div class="form-check mr-3">
                            <input type="radio" class="form-check-input" name="merokok" value="1" data-score="1"
                                onchange="calculateTotalScore()" id="merokokYa" onclick="toggleRokokInput(true)"
                                {{ old('merokok', $hipertensi->merokok ?? '') == '1' ? 'checked' : '' }}>
                            <label class="form-check-label" for="merokok_ya">Ya</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="merokok" value="0" data-score="0"
                                onchange="calculateTotalScore()" id="merokokTidak" onclick="toggleRokokInput(false)"
                                {{ old('merokok', $hipertensi->merokok ?? '') == '0' ? 'checked' : '' }}>
                            <label class="form-check-label" for="merokok_tidak">Tidak</label>
                        </div>
                    </div>
                </div>
                <div class="form-group" id="jumlahRokokSection" style="display: none; margin-top: 15px;">
                    <label for="jumlahRokok">Jumlah rokok per hari</label>
                    <input type="number" class="form-control" name="jmlh_rokok" id="jumlahRokok"
                        value="{{ old('jmlh_rokok', $hipertensi->jmlh_rokok ?? '') }}"
                        placeholder="Masukkan jumlah rokok per hari">
                </div>
                <div class="form-group">
                    <label>6. Apakah Anda selama ini biasa makan makanan yang asin?</label>
                    <div class="d-flex">
                        <div class="form-check mr-3">
                            <input type="radio" class="form-check-input" name="makan_asin" value="1"
                                data-score="1" onchange="calculateTotalScore()" id="asin_ya"
                                {{ old('makan_asin', $hipertensi->makan_asin ?? '') == '1' ? 'checked' : '' }}>
                            <label class="form-check-label" for="asin_ya">Ya</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="makan_asin" value="0"
                                data-score="0" onchange="calculateTotalScore()" id="asin_tidak"
                                {{ old('makan_asin', $hipertensi->makan_asin ?? '') == '0' ? 'checked' : '' }}>
                            <label class="form-check-label" for="asin_tidak">Tidak</label>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label>7. Apakah Anda selama ini biasa makan makanan yang bersantan?</label>
                    <div class="d-flex">
                        <div class="form-check mr-3">
                            <input type="radio" class="form-check-input" name="makan_santan" value="1"
                                data-score="1" onchange="calculateTotalScore()" id="santan_ya"
                                {{ old('makan_santan', $hipertensi->makan_santan ?? '') == '1' ? 'checked' : '' }}>
                            <label class="form-check-label" for="santan_ya">Ya</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="makan_santan" value="0"
                                data-score="0" onchange="calculateTotalScore()" id="santan_tidak"
                                {{ old('makan_santan', $hipertensi->makan_santan ?? '') == '0' ? 'checked' : '' }}>
                            <label class="form-check-label" for="santan_tidak">Tidak</label>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label>8. Apakah Anda selama ini biasa makan makanan yang berlemak hewani?</label>
                    <div class="d-flex">
                        <div class="form-check mr-3">
                            <input type="radio" class="form-check-input" name="makan_lemak" value="1"
                                data-score="1" onchange="calculateTotalScore()" id="lemak_ya"
                                {{ old('makan_lemak', $hipertensi->makan_lemak ?? '') == '1' ? 'checked' : '' }}>
                            <label class="form-check-label" for="lemak_ya">Ya</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="makan_lemak" value="0"
                                data-score="0" onchange="calculateTotalScore()" id="lemak_tidak"
                                {{ old('makan_lemak', $hipertensi->makan_lemak ?? '') == '0' ? 'checked' : '' }}>
                            <label class="form-check-label" for="lemak_tidak">Tidak</label>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label>9. Apakah Anda sering merasa sakit kepala?</label>
                    <div class="d-flex">
                        <div class="form-check mr-3">
                            <input type="radio" class="form-check-input" name="sakit_kepala" value="1"
                                data-score="1" onchange="calculateTotalScore()" id="kepala_ya"
                                {{ old('sakit_kepala', $hipertensi->sakit_kepala ?? '') == '1' ? 'checked' : '' }}>
                            <label class="form-check-label" for="kepala_ya">Ya</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="sakit_kepala" value="0"
                                data-score="0" onchange="calculateTotalScore()" id="kepala_tidak"
                                {{ old('sakit_kepala', $hipertensi->sakit_kepala ?? '') == '0' ? 'checked' : '' }}>
                            <label class="form-check-label" for="kepala_tidak">Tidak</label>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label>10. Apakah Anda sering merasa sakit atau kaku di tengkuk?</label>
                    <div class="d-flex">
                        <div class="form-check mr-3">
                            <input type="radio" class="form-check-input" name="sakit_tenguk" value="1"
                                data-score="1" onchange="calculateTotalScore()" id="tengkuk_ya"
                                {{ old('sakit_tenguk', $hipertensi->sakit_tenguk ?? '') == '1' ? 'checked' : '' }}>
                            <label class="form-check-label" for="tengkuk_ya">Ya</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="sakit_tenguk" value="0"
                                data-score="0" onchange="calculateTotalScore()" id="tengkuk_tidak"
                                {{ old('sakit_tenguk', $hipertensi->sakit_tenguk ?? '') == '0' ? 'checked' : '' }}>
                            <label class="form-check-label" for="tengkuk_tidak">Tidak</label>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label>11. Apakah Anda sedang merasa tertekan di lingkungan kerja keluarga?</label>
                    <div class="d-flex">
                        <div class="form-check mr-3">
                            <input type="radio" class="form-check-input" name="tertekan" value="1"
                                data-score="1" onchange="calculateTotalScore()" id="tertekan_ya"
                                {{ old('tertekan', $hipertensi->tertekan ?? '') == '1' ? 'checked' : '' }}>
                            <label class="form-check-label" for="tertekan_ya">Ya</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="tertekan" value="0"
                                data-score="0" onchange="calculateTotalScore()" id="tertekan_tidak"
                                {{ old('tertekan', $hipertensi->tertekan ?? '') == '0' ? 'checked' : '' }}>
                            <label class="form-check-label" for="tertekan_tidak">Tidak</label>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label>12. Apakah Anda sering sulit tidur?</label>
                    <div class="d-flex">
                        <div class="form-check mr-3">
                            <input type="radio" class="form-check-input" name="sulit_tidur" value="1"
                                data-score="1" onchange="calculateTotalScore()" id="sulit_tidur_ya"
                                {{ old('sulit_tidur', $hipertensi->sulit_tidur ?? '') == '1' ? 'checked' : '' }}>
                            <label class="form-check-label" for="sulit_tidur_ya">Ya</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="sulit_tidur" value="0"
                                data-score="0" onchange="calculateTotalScore()" id="sulit_tidur_tidak"
                                {{ old('sulit_tidur', $hipertensi->sulit_tidur ?? '') == '0' ? 'checked' : '' }}>
                            <label class="form-check-label" for="sulit_tidur_tidak">Tidak</label>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label>13. Apakah Anda melakukan olahraga secara rutin?</label>
                    <div class="d-flex">
                        <div class="form-check mr-3">
                            <input type="radio" class="form-check-input" name="rutin_olahraga" value="1"
                                data-score="0" onchange="calculateTotalScore()" id="rutin_olahraga_ya"
                                {{ old('rutin_olahraga', $hipertensi->rutin_olahraga ?? '') == '1' ? 'checked' : '' }}>
                            <label class="form-check-label" for="rutin_olahraga_ya">Ya</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="rutin_olahraga" value="0"
                                data-score="0" onchange="calculateTotalScore()" data-score="1"
                                onchange="calculateTotalScore()" id="rutin_olahraga_tidak"
                                {{ old('rutin_olahraga', $hipertensi->rutin_olahraga ?? '') == '0' ? 'checked' : '' }}>
                            <label class="form-check-label" for="rutin_olahraga_tidak">Tidak</label>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label>14. Apakah Anda setiap hari makan sayur?</label>
                    <div class="d-flex">
                        <div class="form-check mr-3">
                            <input type="radio" class="form-check-input" name="makan_sayur" value="1"
                                data-score="0" onchange="calculateTotalScore()" id="makan_sayur_ya"
                                {{ old('makan_sayur', $hipertensi->makan_sayur ?? '') == '1' ? 'checked' : '' }}>
                            <label class="form-check-label" for="makan_sayur_ya">Ya</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="makan_sayur" value="0"
                                data-score="0" onchange="calculateTotalScore()" data-score="1"
                                onchange="calculateTotalScore()" id="makan_sayur_tidak"
                                {{ old('makan_sayur', $hipertensi->makan_sayur ?? '') == '0' ? 'checked' : '' }}>
                            <label class="form-check-label" for="makan_sayur_tidak">Tidak</label>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label>15. Apakah Anda biasa makan buah setiap hari?</label>
                    <div class="d-flex">
                        <div class="form-check mr-3">
                            <input type="radio" class="form-check-input" name="makan_buah" value="1"
                                data-score="0" onchange="calculateTotalScore()" id="makan_buah_ya"
                                {{ old('makan_buah', $hipertensi->makan_buah ?? '') == '1' ? 'checked' : '' }}>
                            <label class="form-check-label" for="makan_buah_ya">Ya</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="makan_buah" value="0"
                                data-score="0" onchange="calculateTotalScore()" data-score="1"
                                onchange="calculateTotalScore()" id="makan_buah_tidak"
                                {{ old('makan_buah', $hipertensi->makan_buah ?? '') == '0' ? 'checked' : '' }}>
                            <label class="form-check-label" for="makan_buah_tidak">Tidak</label>
                        </div>
                    </div>
                </div>
                <div class="form-group mt-4">
                    <label>Skor Total</label>
                    <div class="d-flex">
                        <input type="text" class="form-control" id="totalScore" value="0"
                            onclick="calculateTotalScore()" disabled>
                    </div>
                </div>
                <div class="form-section mt-4">
                    <h3>Keterangan</h3>
                    <p>
                        <strong>Pertanyaan No 1-12, jika jawaban 'Ya' diberi nilai 1 pada kolom skor</strong>
                    </p>
                    <p>
                        <strong>Pertanyaan No 13-15, jika jawaban 'Ya' diberi nilai 0 pada kolom skor</strong>
                    </p>
                    <p>
                        <strong>Jika jumlah skor >= 7, Anda berisiko menderita tekanan darah tinggi</strong>
                    </p>

                </div>
            </div>
            <div class="text-right mt-4">
                @if (isset($hipertensi))
                    <a href="{{ route('hipertensi.admin') }}" type="button" class="btn btn-secondary mr-2"
                        style="font-size: 20px">Kembali</a>
                @else
                    <a href="{{ route('skrining.ilp') }}" type="button" class="btn btn-secondary mr-2"
                        style="font-size: 20px">Kembali</a>
                @endif
                <button type="submit" class="btn btn-primary" style="font-size: 20px">Kirim</button>
            </div>
    </form>
    <script>
        function toggleRokokInput(show) {
            const jumlahRokokSection = document.getElementById('jumlahRokokSection');
            if (jumlahRokokSection) {
                jumlahRokokSection.style.display = show ? 'block' : 'none';
            }

            // Jika tidak merokok, kosongkan nilai input jumlah rokok
            if (!show) {
                const jumlahRokokInput = document.getElementById('jumlahRokok');
                if (jumlahRokokInput) jumlahRokokInput.value = '';
            }
        }

        function calculateTotalScore() {
            let totalScore = 0;

            // Ambil semua input radio yang sudah dipilih dengan atribut data-score
            const inputs = document.querySelectorAll('input[data-score]:checked');

            inputs.forEach((input) => {
                const score = parseInt(input.getAttribute('data-score'), 10) || 0;
                totalScore += score;
            });

            // Update skor total di input
            document.getElementById('totalScore').value = totalScore;

            // Tampilkan pesan risiko berdasarkan skor
            const skorMessage = document.getElementById('skorMessage');
            if (totalScore >= 7) {
                skorMessage.textContent = 'Anda berisiko menderita tekanan darah tinggi.';
                skorMessage.style.color = 'red';
            } else {
                skorMessage.textContent = 'Anda memiliki risiko rendah menderita tekanan darah tinggi.';
                skorMessage.style.color = 'green';
            }
        }


        // Menjalankan logika awal jika ada data lama (untuk halaman edit)
        document.addEventListener('DOMContentLoaded', () => {
            const merokokYa = document.getElementById('merokokYa');
            const merokokTidak = document.getElementById('merokokTidak');

            if (merokokYa && merokokYa.checked) {
                toggleRokokInput(true);
            } else if (merokokTidak && merokokTidak.checked) {
                toggleRokokInput(false);
            }

            // Hitung skor awal jika data lama tersedia (untuk halaman edit)
            calculateTotalScore();
        });
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


                var no_hp = selectedOption.data('no_hp');
                var nik = selectedOption.data('nik');
                var dob = selectedOption.data('dob');
                var alamat = selectedOption.data('alamat');
                var jk = selectedOption.data('jenis_kelamin');


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
