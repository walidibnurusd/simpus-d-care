@extends('layouts.skrining.master')
@section('title', 'Skrining Kanker Kolorektal')
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
        action="{{ isset($kankerKolorektal) ? route('kankerKolorektal.lansia.update', $kankerKolorektal->id) : route('kankerKolorektal.lansia.store') }}"
        method="POST">
        @csrf
        @if (isset($kankerKolorektal))
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
                                    {{ old('pasien', $kankerKolorektal->pasien ?? '') == $item->id ? 'selected' : '' }}>
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
                        <input type="date" class="form-control" name="tanggal" id="tanggal_lahir" readonly
                            value="{{ $kankerKolorektal->tanggal ?? '' }}">
                    </div>
                </div>
            </div>


        </div>


        <div class="form-section">
            <h3>Pertanyaan</h3>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Usia</label>
                        <div class="d-flex">
                            <div class="form-check mr-3">
                                <input type="radio" class="form-check-input" name="usia" value="0"
                                    id="tidakPernah"
                                    {{ old('usia', $kankerKolorektal->usia ?? '') == 0 ? 'checked' : '' }}>
                                <label class="form-check-label" for="tidakPernah">
                                    < 50 tahun</label>
                            </div>
                            <div class="form-check">
                                <input type="radio" class="form-check-input" name="usia" value="2" id="usia50"
                                    {{ old('usia', $kankerKolorektal->usia ?? '') == 2 ? 'checked' : '' }}>
                                <label class="form-check-label" for="usia50">50-69 tahun</label>
                            </div>
                            <div class="form-check ml-3">
                                <input type="radio" class="form-check-input" name="usia" value="3" id="ya"
                                    {{ old('usia', $kankerKolorektal->usia ?? '') == 3 ? 'checked' : '' }}>
                                <label class="form-check-label" for="ya">≥ 70 Tahun</label>
                            </div>
                        </div>
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
            <div class="col-md-12">
                <div class="form-group">
                    <label>1.Apakah riwayat keluarga kanker kolorektal generasi pertama
                        (Ayah atau Ibu kandung, kakak atau adik kandung)</label>
                    <div class="d-flex">

                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="riwayat_kanker" value="2"
                                id="sedang"
                                {{ old('riwayat_kanker', $kankerKolorektal->riwayat_kanker ?? '') == 2 ? 'checked' : '' }}>
                            <label class="form-check-label" for="sedang">Ya</label>
                        </div>
                        <div class="form-check ml-3">
                            <input type="radio" class="form-check-input" name="riwayat_kanker" value="0"
                                id="ya"
                                {{ old('riwayat_kanker', $kankerKolorektal->riwayat_kanker ?? '') == 0 ? 'checked' : '' }}>
                            <label class="form-check-label" for="ya">Tidak Ada</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label>2.Apakah Anda Merokok?</label>
                    <div class="d-flex">
                        <div class="form-check mr-3">
                            <input type="radio" class="form-check-input" name="merokok" value="1" id="tidak"
                                {{ old('merokok', $kankerKolorektal->merokok ?? '') == 1 ? 'checked' : '' }}>
                            <label class="form-check-label" for="tidak">Dulu pernah</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="merokok" value="2" id="sedang"
                                {{ old('merokok', $kankerKolorektal->merokok ?? '') == 2 ? 'checked' : '' }}>
                            <label class="form-check-label" for="sedang">Saat ini</label>
                        </div>
                        <div class="form-check ml-3">
                            <input type="radio" class="form-check-input" name="merokok" value="0" id="ya"
                                {{ old('merokok', $kankerKolorektal->merokok ?? '') == 0 ? 'checked' : '' }}>
                            <label class="form-check-label" for="ya">Tidak merokok</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label>3.Buang Air Besar bercampur darah dan/atau lendir</label>
                    <div class="d-flex">
                        <input type="text" class="form-control" name="bercampur_darah"
                            value="{{ $kankerKolorektal->bercampur_darah ?? '' }}">
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label>4.Diare Kronis</label>
                    <div class="d-flex">
                        <input type="text" class="form-control" name="diare_kronis"
                            value="{{ $kankerKolorektal->diare_kronis ?? '' }}">
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label>5.Buang Air Besar 2 – 3 minggu seperti kotoran
                        kambing</label>
                    <div class="d-flex">
                        <input type="text" class="form-control" name="bab_kambing"
                            value="{{ $kankerKolorektal->bab_kambing ?? '' }}">
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label>6.Konstipasi kronis</label>
                    <div class="d-flex">
                        <input type="text" class="form-control" name="konstipasi_kronis"
                            value="{{ $kankerKolorektal->konstipasi_kronis ?? '' }}">
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label>7.Perubahan bentuk dan frekuensi defekasi</label>
                    <div class="d-flex">
                        <input type="text" class="form-control" name="frekuensi_defekasi"
                            value="{{ $kankerKolorektal->frekuensi_defekasi ?? '' }}">
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="col-md-12">
                    <label for="kesimpulan" style="color: rgb(19, 11, 241);">Kesimpulan</label>
                    <textarea class="form-control" id="kesimpulan" name="kesimpulan" placeholder="Kesimpulan">{{ old('kesimpulan', $kankerKolorektal->kesimpulan ?? '') }}</textarea>
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
        <ul><strong>
                Interpretasi Hasil APCS Score:
                <li>0 – 1 : Risiko rendah
                </li>
                <li>2 – 3 : Risiko sedang</li>
                <li>4 – 7 : Risiko tinggi</li>
            </strong></ul>

        </div>


        <div class="text-right mt-4">
            @if (isset($kankerKolorektal) && $kankerKolorektal)
                <a href="{{ route('kankerKolorektal.lansia.admin') }}" type="button" class="btn btn-secondary mr-2"
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
            const questionNames = [
                'jenis_kelamin',
                'usia',
                'riwayat_kanker',
                'merokok',
            ];

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
