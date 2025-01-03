@extends('layouts.skrining.master')
@section('title', 'Skrining PPOK (Puma)')
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

    <form action="{{ isset($puma) ? route('puma.lansia.update', $puma->id) : route('puma.lansia.store') }}" method="POST">
        @csrf
        @if (isset($puma))
            @method('PUT')
        @endif
        <div class="form-section">
            <ul>
                <li><strong>Deteksi dini PPOK dilakukan pada peserta usia > 40 tahun</strong></li>
                <li><strong>Wawancara menggunakan kusioner PUMA dapat dilakukan oleh Tenaga Kesehatan atau Kader
                        Kesehatan</strong></li>
            </ul>
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
                                    {{ old('pasien', $puma->pasien ?? '') == $item->id ? 'selected' : '' }}>
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
                        <label>Puskesmas</label>
                        <input type="text" class="form-control" name="puskesmas" placeholder="Masukkan nama puskesmas"
                            value="{{ old('puskesmas', $puma->puskesmas ?? '') }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Petugas</label>
                        <input type="text" class="form-control" name="petugas" placeholder="Masukkan nama petugas"
                            value="{{ old('petugas', $puma->petugas ?? '') }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Jenis Kelamin</label>
                        <div class="d-flex">
                            <div class="form-check mr-3">
                                <input type="radio" class="form-check-input" name="jenis_kelamin" value="laki-laki"
                                    id="jk_laki"
                                    {{ old('jenis_kelamin', $puma->jenis_kelamin ?? '') == 'laki-laki' ? 'checked' : '' }}>
                                <label class="form-check-label" for="laki-laki">Laki-laki</label>
                            </div>
                            <div class="form-check">
                                <input type="radio" class="form-check-input" name="jenis_kelamin" value="perempuan"
                                    id="jk_perempuan"
                                    {{ old('jenis_kelamin', $puma->jenis_kelamin ?? '') == 'perempuan' ? 'checked' : '' }}>
                                <label class="form-check-label" for="perempuan">Perempuan</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Usia</label>
                        <div class="d-flex">
                            <div class="form-check mr-3">
                                <input type="radio" class="form-check-input" name="usia" value="0" id="usia40"
                                    {{ old('usia', $puma->usia ?? '') == 0 ? 'checked' : '' }}>
                                <label class="form-check-label" for="usia40">40-49 tahun</label>
                            </div>
                            <div class="form-check">
                                <input type="radio" class="form-check-input" name="usia" value="1" id="usia50"
                                    {{ old('usia', $puma->usia ?? '') == 1 ? 'checked' : '' }}>
                                <label class="form-check-label" for="usia50">50-59 tahun</label>
                            </div>
                            <div class="form-check ml-3">
                                <input type="radio" class="form-check-input" name="usia" value="2" id="usia60"
                                    {{ old('usia', $puma->usia ?? '') == 2 ? 'checked' : '' }}>
                                <label class="form-check-label" for="usia60">> 60 tahun</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>




        </div>
        <div class="form-section mt-4">
            <h3>Pertanyaan</h3>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label>1. Merokok</label>
                        <p>Apakah Anda pernah merokok?</p>
                        <div>
                            <p>Tidak merokok, jika merokok kurang dari 20 bungkus selama hidup atau kurang dari 1 rokok/hari
                                dalam 1 tahun maka pilih Tidak</p>
                            <div class="form-check">
                                <input type="radio" class="form-check-input" name="merokok" value="0"
                                    onclick="calculateTotalScore(); toggleSmokingQuestions(false)"
                                    {{ old('merokok', $puma->merokok ?? '') == '0' ? 'checked' : '' }}>
                                <label class="form-check-label">Tidak</label>
                            </div>
                            <div class="form-check">
                                <input type="radio" class="form-check-input" name="merokok" value="1"
                                    onclick="calculateTotalScore(); toggleSmokingQuestions(true)"
                                    {{ old('merokok', $puma->merokok ?? '') == '1' ? 'checked' : '' }}>
                                <label class="form-check-label">Ya</label>
                            </div>
                        </div>
                        <div id="smoking-questions"
                            style="display: {{ old('merokok', $puma->merokok ?? '') == '1' ? 'block' : 'none' }};">
                            <br>
                            <p>Merokok (diisi oleh responden) :</p>
                            <label>Rata-rata jumlah rokok/hari</label>
                            <input type="number" class="form-control" name="jumlah_rokok_per_hari"
                                placeholder="Masukkan jumlah batang"
                                value="{{ old('jumlah_rokok_per_hari', $puma->jumlah_rokok_per_hari ?? '') }}">

                            <label>Lama merokok dalam tahun</label>
                            <input type="number" class="form-control" name="lama_merokok"
                                placeholder="Masukkan lama merokok dalam tahun"
                                value="{{ old('lama_merokok', $puma->lama_merokok ?? '') }}">

                            <label>Hitung Pack years (oleh petugas)</label>
                            <p class="form-check-label">Pack years = Lama merokok dalam tahun x Jumlah batang rokok per
                                hari / 20</p>

                            <label>Contoh:</label>
                            <ul>
                                <li>Jumlah merokok/hari = 15 batang</li>
                                <li>Lama merokok = 20 tahun</li>
                                <li>Pack years = 15 x 20 = 300/20 = 15 bungkus tahun</li>
                            </ul>
                            <p>Maka pilih 0 : < 20 bungkus tahun</p>

                                    <div class="d-flex">
                                        <div class="form-check mr-3">
                                            <input type="radio" class="form-check-input" name="rokok_per_tahun"
                                                value="0" onclick="calculateTotalScore()"
                                                {{ old('rokok_per_tahun', $puma->rokok_per_tahun ?? '') == '0' ? 'checked' : '' }}>
                                            <label class="form-check-label">
                                                < 20 bungkus tahun</label>
                                        </div>
                                        <div class="form-check">
                                            <input type="radio" class="form-check-input" name="rokok_per_tahun"
                                                value="1" onclick="calculateTotalScore()"
                                                {{ old('rokok_per_tahun', $puma->rokok_per_tahun ?? '') == '1' ? 'checked' : '' }}>
                                            <label class="form-check-label">20 - 30 bungkus tahun</label>
                                        </div>
                                        <div class="form-check ml-3">
                                            <input type="radio" class="form-check-input" name="rokok_per_tahun"
                                                value="2" onclick="calculateTotalScore()"
                                                {{ old('rokok_per_tahun', $puma->rokok_per_tahun ?? '') == '2' ? 'checked' : '' }}>
                                            <label class="form-check-label">> 30 bungkus tahun</label>
                                        </div>
                                    </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group">
                        <label>2. Apakah Anda pernah merasa napas pendek ketika Anda berjalan lebih cepat pada jalan yang
                            datar atau pada jalan yang sedikit menanjak?</label>
                        <div class="d-flex">
                            <div class="form-check mr-3">
                                <input type="radio" class="form-check-input" name="nafas_pendek" value="1"
                                    onclick="calculateTotalScore()"
                                    {{ old('nafas_pendek', $puma->nafas_pendek ?? '') == '1' ? 'checked' : '' }}>
                                <label class="form-check-label">Ya</label>
                            </div>

                            <div class="form-check ml-3">
                                <input type="radio" class="form-check-input" name="nafas_pendek" value="0"
                                    onclick="calculateTotalScore()"
                                    {{ old('nafas_pendek', $puma->nafas_pendek ?? '') == '0' ? 'checked' : '' }}>
                                <label class="form-check-label">Tidak</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group">
                        <label>3. Apakah Anda biasanya mempunyai dahak yang berasal dari paru atau kesulitan mengeluarkan
                            dahak saat Anda sedang tidak menderita flu?</label>
                        <div class="d-flex">
                            <div class="form-check mr-3">
                                <input type="radio" class="form-check-input" name="punya_dahak" value="1"
                                    onclick="calculateTotalScore()"
                                    {{ old('punya_dahak', $puma->punya_dahak ?? '') == '1' ? 'checked' : '' }}>
                                <label class="form-check-label">Ya</label>
                            </div>

                            <div class="form-check ml-3">
                                <input type="radio" class="form-check-input" name="punya_dahak" value="0"
                                    onclick="calculateTotalScore()"
                                    {{ old('punya_dahak', $puma->punya_dahak ?? '') == '0' ? 'checked' : '' }}>
                                <label class="form-check-label">Tidak</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group">
                        <label>4. Apakah Anda biasanya batuk saat Anda sedang tidak menderita flu?</label>
                        <div class="d-flex">
                            <div class="form-check mr-3">
                                <input type="radio" class="form-check-input" name="batuk" value="1"
                                    onclick="calculateTotalScore()"
                                    {{ old('batuk', $puma->batuk ?? '') == '1' ? 'checked' : '' }}>
                                <label class="form-check-label">Ya</label>
                            </div>

                            <div class="form-check ml-3">
                                <input type="radio" class="form-check-input" name="batuk" value="0"
                                    onclick="calculateTotalScore()"
                                    {{ old('batuk', $puma->batuk ?? '') == '0' ? 'checked' : '' }}>
                                <label class="form-check-label">Tidak</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group">
                        <label>5. Apakah Dokter atau tenaga kesehatan lainnya pernah meminta Anda untuk melakukan
                            pemeriksaan fungsi paru dengan alat spirometry atau peakflow meter (meniup ke dalam suatu
                            alat)?</label>
                        <div class="d-flex">
                            <div class="form-check mr-3">
                                <input type="radio" class="form-check-input" name="periksa_paru" value="1"
                                    onclick="calculateTotalScore()"
                                    {{ old('periksa_paru', $puma->periksa_paru ?? '') == '1' ? 'checked' : '' }}>
                                <label class="form-check-label">Ya</label>
                            </div>

                            <div class="form-check ml-3">
                                <input type="radio" class="form-check-input" name="periksa_paru" value="0"
                                    onclick="calculateTotalScore()"
                                    {{ old('periksa_paru', $puma->periksa_paru ?? '') == '0' ? 'checked' : '' }}>
                                <label class="form-check-label">Tidak</label>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="form-group mt-4">
                <label for="kesimpulan" style="color: rgb(19, 11, 241);">Kesimpulan</label>
                <textarea class="form-control" id="kesimpulan" name="kesimpulan" placeholder="Kesimpulan">{{ old('kesimpulan', $puma->kesimpulan ?? '') }}</textarea>
                <br>
                <label>Skor Total</label>
                <div class="d-flex">
                    <input type="text" class="form-control" id="totalScore" value="0"
                        onclick="calculateTotalScore()" disabled>
                </div>
            </div>
            <ul><strong>
                    <li>Jika hasil wawancara didapatkan nilai > 6 maka peserta dirujuk ke FKTP untuk melakukan
                        pemeriksaan uji fungsi paru menggunakan Spirometri untuk penegakan diagnosis Interpretasi :
                    </li>
                    <li>Skor < 6 : Edukasi gaya hidup sehat dan kunjungan rutin</li>
                </strong></ul>
        </div>


        <div class="text-right mt-4">
            @if (isset($puma) && $puma)
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
        function toggleSmokingQuestions(show) {
            const smokingQuestions = document.getElementById("smoking-questions");
            if (show) {
                smokingQuestions.style.display = "block";
            } else {
                smokingQuestions.style.display = "none";
            }
        }

        function calculateTotalScore() {
            let totalScore = 0;
            let skipSmoking = false;

            // Check if smoking question is answered "Ya"
            const smokingRadioButtons = document.getElementsByName("merokok");
            smokingRadioButtons.forEach((radio) => {
                if (radio.checked && radio.value === "1") {
                    skipSmoking = true;
                    document.getElementById("smoking-questions").style.display = "block";
                } else if (radio.checked && radio.value === "0") {
                    document.getElementById("smoking-questions").style.display = "none";
                }
            });

            // List of all question names to calculate score
            const questionNames = ["nafas_pendek", "punya_dahak", "batuk", "periksa_paru", "rokok_per_tahun", "usia"];

            // Calculate score based on checked answers
            questionNames.forEach((name) => {
                const radios = document.getElementsByName(name);
                radios.forEach((radio) => {
                    if (radio.checked) {
                        totalScore += parseInt(radio.value);
                    }
                });
            });

            // Only add merokok score if "Tidak" is selected
            if (!skipSmoking) {
                smokingRadioButtons.forEach((radio) => {
                    if (radio.checked) {
                        totalScore += parseInt(radio.value);
                    }
                });
            }

            // Update the total score in the input field
            document.getElementById("totalScore").value = totalScore;
        }

        // Attach the calculateTotalScore function to all radio buttons
        document.querySelectorAll('input[type="radio"]').forEach((radio) => {
            radio.addEventListener('change', calculateTotalScore);
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
                calculateTotalScore();  
            });
            $('#pasien').trigger('change');
        });
    </script>
@endsection
