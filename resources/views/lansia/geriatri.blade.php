@extends('layouts.skrining.master')
@section('title', 'SKRINING LANSIA SEDERHANA (SKILAS)')
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

    <form action="{{ isset($geriatri) ? route('geriatri.lansia.update', $geriatri->id) : route('geriatri.lansia.store') }}"
        method="POST">
        @csrf
        @if (isset($geriatri))
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
                                <option value="{{ $item->id }}" data-rw="{{ $item->rw }}"
                                    data-nik="{{ $item->nik }}" data-dob="{{ $item->dob }}"
                                    data-alamat="{{ $item->address }}" data-jenis_kelamin="{{ $item->genderName->name }}"
                                    {{ old('pasien', $geriatri->pasien ?? '') == $item->id ? 'selected' : '' }}>
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
                        <label>Umur</label>
                        <input type="number" class="form-control" name="umur" placeholder="Masukkan nama umur" readonly
                            id="umur" value="{{ old('umur', $geriatri->umur ?? '') }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Jenis Kelamin</label>
                        <div class="d-flex">
                            <div class="form-check mr-3">
                                <input type="radio" class="form-check-input" name="jenis_kelamin_geriatri"
                                    value="laki-laki" id="jk_laki"
                                    {{ old('jenis_kelamin', $geriatri->jenis_kelamin ?? '') == 'laki-laki' ? 'checked' : '' }}>
                                <label class="form-check-label" for="laki-laki">Laki-laki</label>
                            </div>
                            <div class="form-check">
                                <input type="radio" class="form-check-input" name="jenis_kelamin" value="perempuan"
                                    id="jk_perempuan"
                                    {{ old('jenis_kelamin', $geriatri->jenis_kelamin ?? '') == 'perempuan' ? 'checked' : '' }}>
                                <label class="form-check-label" for="perempuan">Perempuan</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Alamat</label>
                        <input type="text" class="form-control" name="alamat" placeholder="Masukkan nama alamat"
                            readonly id="alamat" value="{{ old('alamat', $geriatri->alamat ?? '') }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>RW</label>
                        <input type="text" class="form-control" name="rw" placeholder="Masukkan nama rw" readonly
                            id="rw" value="{{ old('rw', $geriatri->rw ?? '') }}">
                    </div>
                </div>
            </div>




        </div>
        <div class="form-section mt-4">
            <h3>Pertanyaan</h3>
            <div class="row">
                <div class="col-md-12">

                </div>

                <div class="col-md-12">
                    <div class="form-group">
                        <label>1. Orientasi terhadap waktu dan tempat: <br>
                            a. Tanggal berapa sekarang? <br>
                            b. Dimana anda berada sekarang (rumah, klinik, dsb)?
                        </label>
                        <div class="d-flex">
                            <div class="form-check mr-3">
                                <input type="radio" class="form-check-input" name="tempat_waktu" value="1"
                                    onclick="calculateTotalScore()"
                                    {{ old('tempat_waktu', $geriatri->tempat_waktu ?? '') == '1' ? 'checked' : '' }}>
                                <label class="form-check-label">Ya, ada penurunan kognitif</label>
                            </div>

                            <div class="form-check ml-3">
                                <input type="radio" class="form-check-input" name="tempat_waktu" value="0"
                                    onclick="calculateTotalScore()"
                                    {{ old('tempat_waktu', $geriatri->tempat_waktu ?? '') == '0' ? 'checked' : '' }}>
                                <label class="form-check-label">Tidak</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label>2. Mengingat dan mengulang tiga kata: bunga, pintu, nasi (sebagai contoh)

                        </label>
                        <div class="d-flex">
                            <div class="form-check mr-3">
                                <input type="radio" class="form-check-input" name="ulang_kata" value="1"
                                    onclick="calculateTotalScore()"
                                    {{ old('ulang_kata', $geriatri->ulang_kata ?? '') == '1' ? 'checked' : '' }}>
                                <label class="form-check-label">Ya, ada penurunan kognitif</label>
                            </div>

                            <div class="form-check ml-3">
                                <input type="radio" class="form-check-input" name="ulang_kata" value="0"
                                    onclick="calculateTotalScore()"
                                    {{ old('ulang_kata', $geriatri->ulang_kata ?? '') == '0' ? 'checked' : '' }}>
                                <label class="form-check-label">Tidak</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label>3. Tes berdiri dari kursi: Berdiri dari kursi lima kali tanpa menggunakan tangan. Apakah
                            orang tersebut dapat berdiri dikursi sebanyak 5 kali dalam 14 detik?

                        </label>
                        <div class="d-flex">
                            <div class="form-check mr-3">
                                <input type="radio" class="form-check-input" name="tes_berdiri" value="1"
                                    onclick="calculateTotalScore()"
                                    {{ old('tes_berdiri', $geriatri->tes_berdiri ?? '') == '1' ? 'checked' : '' }}>
                                <label class="form-check-label">Ya, ada keterbatasan mobilisasi</label>
                            </div>

                            <div class="form-check ml-3">
                                <input type="radio" class="form-check-input" name="tes_berdiri" value="0"
                                    onclick="calculateTotalScore()"
                                    {{ old('tes_berdiri', $geriatri->tes_berdiri ?? '') == '0' ? 'checked' : '' }}>
                                <label class="form-check-label">Tidak</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label>4. Apakah berat badan anda berkurang > 3kg dalam 3 bulan terakhir atau pakaian menjadi lebih
                            longgar?

                        </label>
                        <div class="d-flex">
                            <div class="form-check mr-3">
                                <input type="radio" class="form-check-input" name="pakaian" value="1"
                                    onclick="calculateTotalScore()"
                                    {{ old('pakaian', $geriatri->pakaian ?? '') == '1' ? 'checked' : '' }}>
                                <label class="form-check-label">Ya, berat badan menurun</label>
                            </div>

                            <div class="form-check ml-3">
                                <input type="radio" class="form-check-input" name="pakaian" value="0"
                                    onclick="calculateTotalScore()"
                                    {{ old('pakaian', $geriatri->pakaian ?? '') == '0' ? 'checked' : '' }}>
                                <label class="form-check-label">Tidak</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group">
                        <label>5. Apakah anda hilang nafsu makan atau mengalami kesulitan makan, menggunakan selang/sonde)?

                        </label>
                        <div class="d-flex">
                            <div class="form-check mr-3">
                                <input type="radio" class="form-check-input" name="nafsu_makan" value="1"
                                    onclick="calculateTotalScore()"
                                    {{ old('nafsu_makan', $geriatri->nafsu_makan ?? '') == '1' ? 'checked' : '' }}>
                                <label class="form-check-label">Ya, berat badan menurun</label>
                            </div>

                            <div class="form-check ml-3">
                                <input type="radio" class="form-check-input" name="nafsu_makan" value="0"
                                    onclick="calculateTotalScore()"
                                    {{ old('nafsu_makan', $geriatri->nafsu_makan ?? '') == '0' ? 'checked' : '' }}>
                                <label class="form-check-label">Tidak</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group">
                        <label>6. Apakah ukuran lingkar lengan atas (LiLA) <21 cm? * </label>
                                <div class="d-flex">
                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input" name="ukuran_lingkar"
                                            value="1" onclick="calculateTotalScore()"
                                            {{ old('ukuran_lingkar', $geriatri->ukuran_lingkar ?? '') == '1' ? 'checked' : '' }}>
                                        <label class="form-check-label">Ya, Lila kurang dari 21 cm</label>
                                    </div>

                                    <div class="form-check ml-3">
                                        <input type="radio" class="form-check-input" name="ukuran_lingkar"
                                            value="0" onclick="calculateTotalScore()"
                                            {{ old('ukuran_lingkar', $geriatri->pakaian ?? '') == '0' ? 'checked' : '' }}>
                                        <label class="form-check-label">Tidak</label>
                                    </div>
                                </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group">
                        <label>7. Apakah anda mengalami masalah pada mata: kesulitan melihat jauh, membaca, penyakit
                            mata,atau sedang dalam pengobatan medis (diabetes, tekanan darah tinnggi)? Jika tidak, lakukan
                            TES MELIHAT

                        </label>
                        <div class="d-flex">
                            <div class="form-check mr-3">
                                <input type="radio" class="form-check-input" name="tes_melihat" value="1"
                                    onclick="calculateTotalScore()"
                                    {{ old('tes_melihat', $geriatri->tes_melihat ?? '') == '1' ? 'checked' : '' }}>
                                <label class="form-check-label">Ya, ada gangguan penglihatan</label>
                            </div>

                            <div class="form-check ml-3">
                                <input type="radio" class="form-check-input" name="tes_melihat" value="0"
                                    onclick="calculateTotalScore()"
                                    {{ old('tes_melihat', $geriatri->tes_melihat ?? '') == '0' ? 'checked' : '' }}>
                                <label class="form-check-label">Tidak</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group">
                        <label>8. TES MELIHAT : Apakah jawaban hitung jari benar dalam 3 kali berturut-turut?

                        </label>
                        <div class="d-flex">
                            <div class="form-check mr-3">
                                <input type="radio" class="form-check-input" name="hitung_jari" value="1"
                                    onclick="calculateTotalScore()"
                                    {{ old('hitung_jari', $geriatri->hitung_jari ?? '') == '1' ? 'checked' : '' }}>
                                <label class="form-check-label">Ya, ada gangguan penglihatan</label>
                            </div>

                            <div class="form-check ml-3">
                                <input type="radio" class="form-check-input" name="hitung_jari" value="0"
                                    onclick="calculateTotalScore()"
                                    {{ old('hitung_jari', $geriatri->hitung_jari ?? '') == '0' ? 'checked' : '' }}>
                                <label class="form-check-label">Tidak</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label>9. Mendengar bisikan saat TES BISIK. Jika tidak dapat dilakukan Tes Bisik, rujuk Puskesmas

                        </label>
                        <div class="d-flex">
                            <div class="form-check mr-3">
                                <input type="radio" class="form-check-input" name="tes_bisik" value="1"
                                    onclick="calculateTotalScore()"
                                    {{ old('tes_bisik', $geriatri->tes_bisik ?? '') == '1' ? 'checked' : '' }}>
                                <label class="form-check-label">Ya, ada gangguan pendengaran
                                </label>
                            </div>

                            <div class="form-check ml-3">
                                <input type="radio" class="form-check-input" name="tes_bisik" value="0"
                                    onclick="calculateTotalScore()"
                                    {{ old('tes_bisik', $geriatri->tes_bisik ?? '') == '0' ? 'checked' : '' }}>
                                <label class="form-check-label">Tidak</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label>10. Selama dua minggu terakhir, apakah anda merasa terganggu oleh Perasaan sedih, tertekan,
                            atau putus asa

                        </label>
                        <div class="d-flex">
                            <div class="form-check mr-3">
                                <input type="radio" class="form-check-input" name="perasaan_sedih" value="1"
                                    onclick="calculateTotalScore()"
                                    {{ old('perasaan_sedih', $geriatri->perasaan_sedih ?? '') == '1' ? 'checked' : '' }}>
                                <label class="form-check-label">Ya</label>
                            </div>

                            <div class="form-check ml-3">
                                <input type="radio" class="form-check-input" name="perasaan_sedih" value="0"
                                    onclick="calculateTotalScore()"
                                    {{ old('perasaan_sedih', $geriatri->perasaan_sedih ?? '') == '0' ? 'checked' : '' }}>
                                <label class="form-check-label">Tidak</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label>11.Selama dua minggu terakhir, apakah anda merasa terganggu oleh sedikit minat atau
                            kesenangan dalam melakukan sesuatu

                        </label>
                        <div class="d-flex">
                            <div class="form-check mr-3">
                                <input type="radio" class="form-check-input" name="kesenangan" value="1"
                                    onclick="calculateTotalScore()"
                                    {{ old('kesenangan', $geriatri->kesenangan ?? '') == '1' ? 'checked' : '' }}>
                                <label class="form-check-label">Ya</label>
                            </div>

                            <div class="form-check ml-3">
                                <input type="radio" class="form-check-input" name="kesenangan" value="0"
                                    onclick="calculateTotalScore()"
                                    {{ old('kesenangan', $geriatri->kesenangan ?? '') == '0' ? 'checked' : '' }}>
                                <label class="form-check-label">Tidak</label>
                            </div>
                        </div>
                    </div>
                </div>




            </div>
            <div class="form-group mt-4">
                <div class="form-group">
                    <label><strong>Hasil:</strong></label>
                    <p id="totalScore">Total Skor: 0</p>
                </div>
            </div>


        </div>

        <div class="text-right mt-4">
            @if (isset($geriatri) && $geriatri)
                <a href="{{ route('puma.lansia.admin') }}" type="button" class="btn btn-secondary mr-2"
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
            // Daftar nama pertanyaan
            let questionNames = [
                'tempat_waktu',
                'ulang_kata',
                'tes_berdiri',
                'pakaian',
                'nafsu_makan',
                'ukuran_lingkar',
                'tes_melihat',
                'hitung_jari',
                'tes_bisik',
                'perasaan_sedih',
                'kesenangan'
            ];

            let totalScore = 0;


            questionNames.forEach(name => {
                let selectedOption = document.querySelector(`input[name="${name}"]:checked`);
                totalScore += selectedOption ? parseInt(selectedOption.value) : 0;
            });

            document.getElementById('totalScore').innerText = `Total Skor: ${totalScore}`;
        }
        document.addEventListener('DOMContentLoaded', calculateTotalScore);
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
                var rw = selectedOption.data('rw');
                var jk = selectedOption.data('jenis_kelamin');


                $('#tanggal_lahir').val(dob);
                $('#alamat').val(alamat);
                $('#rw').val(rw);
                $('input[name="jenis_kelamin"]').prop('checked', false); // Uncheck all checkboxes first
                if (jk === 'Laki-Laki') {
                    $('#jk_laki').prop('checked', true);
                } else if (jk === 'Perempuan') {
                    $('#jk_perempuan').prop('checked', true);
                }
                if (dob) {
                    var dobDate = new Date(dob);
                    var today = new Date();
                    var age = today.getFullYear() - dobDate.getFullYear();
                    var monthDiff = today.getMonth() - dobDate.getMonth();
                    if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < dobDate.getDate())) {
                        age--;
                    }
                    $('#umur').val(age);
                } else {
                    $('#umur').val('');
                }
            });
            $('#pasien').trigger('change');
        });
    </script>

@endsection
