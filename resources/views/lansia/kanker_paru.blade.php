@extends('layouts.skrining.master')
@section('title', 'Skrining Kanker Paru')
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

    <form
        action="{{ isset($kankerParu) ? route('kankerParu.lansia.update', $kankerParu->id) : route('kankerParu.lansia.store') }}"
        method="POST">
        @csrf
        @if (isset($kankerParu))
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
                                    {{ old('pasien', $kankerParu->pasien ?? '') == $item->id ? 'selected' : '' }}>
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
                        <input type="date" class="form-control" name="tanggal" value="{{ $kankerParu->tanggal ?? '' }}"
                            id="tanggal_lahir">
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
                                <input type="radio" class="form-check-input" name="usia" value="1"
                                    id="tidakPernah" {{ old('usia', $kankerParu->usia ?? '') == 1 ? 'checked' : '' }}>
                                <label class="form-check-label" for="tidakPernah">
                                    < 45 tahun</label>
                            </div>
                            <div class="form-check">
                                <input type="radio" class="form-check-input" name="usia" value="2" id="usia50"
                                    {{ old('usia', $kankerParu->usia ?? '') == 2 ? 'checked' : '' }}>
                                <label class="form-check-label" for="usia50">46-65 tahun</label>
                            </div>
                            <div class="form-check ml-3">
                                <input type="radio" class="form-check-input" name="usia" value="3" id="ya"
                                    {{ old('usia', $kankerParu->usia ?? '') == 3 ? 'checked' : '' }}>
                                <label class="form-check-label" for="ya">65 tahun</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Jenis Kelamin</label>
                        <div class="d-flex">
                            <div class="form-check mr-3">
                                <input type="radio" class="form-check-input" name="jenis_kelamin_kankerParu"
                                    value="laki-laki" id="jk_laki"
                                    {{ old('jenis_kelamin', $kankerParu->jenis_kelamin ?? '') == 'laki-laki' ? 'checked' : '' }}>
                                <label class="form-check-label" for="laki-laki">Laki-laki</label>
                            </div>
                            <div class="form-check">
                                <input type="radio" class="form-check-input" name="jenis_kelamin" value="perempuan"
                                    id="jk_perempuan"
                                    {{ old('jenis_kelamin', $kankerParu->jenis_kelamin ?? '') == 'perempuan' ? 'checked' : '' }}>
                                <label class="form-check-label" for="perempuan">Perempuan</label>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label>1.Apakah Anda pernah didiagnosisi/menderita kanker?</label>
                    <div class="d-flex">
                        <div class="form-check mr-3">
                            <input type="radio" class="form-check-input" name="kanker" value="1" id="tidak"
                                {{ old('kanker', $kankerParu->kanker ?? '') == 1 ? 'checked' : '' }}>
                            <label class="form-check-label" for="tidak">Tidak pernah</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="kanker" value="2" id="sedang"
                                {{ old('kanker', $kankerParu->kanker ?? '') == 2 ? 'checked' : '' }}>
                            <label class="form-check-label" for="sedang">Ya, pernah < 5 tahun yang lalu</label>
                        </div>
                        <div class="form-check ml-3">
                            <input type="radio" class="form-check-input" name="kanker" value="3" id="ya"
                                {{ old('kanker', $kankerParu->kanker ?? '') == 3 ? 'checked' : '' }}>
                            <label class="form-check-label" for="ya">Ya, pernah tahun yang lalu</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label>2.Apakah ada keluarga (ayah/ibu/saudara kandung) didiagnosis/menderita kanker
                        sebelumnya?</label>
                    <div class="d-flex">
                        <div class="form-check mr-3">
                            <input type="radio" class="form-check-input" name="keluarga_kanker" value="1"
                                id="tidak"
                                {{ old('keluarga_kanker', $kankerParu->keluarga_kanker ?? '') == 1 ? 'checked' : '' }}>
                            <label class="form-check-label" for="tidak">Tidak Ada</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="keluarga_kanker" value="2"
                                id="sedang"
                                {{ old('keluarga_kanker', $kankerParu->keluarga_kanker ?? '') == 2 ? 'checked' : '' }}>
                            <label class="form-check-label" for="sedang">Ya, kanker jenis lain</label>
                        </div>
                        <div class="form-check ml-3">
                            <input type="radio" class="form-check-input" name="keluarga_kanker" value="3"
                                id="ya"
                                {{ old('keluarga_kanker', $kankerParu->keluarga_kanker ?? '') == 3 ? 'checked' : '' }}>
                            <label class="form-check-label" for="ya">Ya, ada kanker paru</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label>3.Riwayat merokok/paparan asap rokok (rokok kretek/rokok
                        putih/vipe/shisya/cerutu/rokok linting,dll)</label>
                    <div class="d-flex">
                        <div class="form-check mr-3">
                            <input type="radio" class="form-check-input" name="merokok" value="1" id="tidak"
                                {{ old('merokok', $kankerParu->merokok ?? '') == 1 ? 'checked' : '' }}>
                            <label class="form-check-label" for="tidak">Tidak merokok</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="merokok" value="2" id="sedang"
                                {{ old('merokok', $kankerParu->merokok ?? '') == 2 ? 'checked' : '' }}>
                            <label class="form-check-label" for="sedang">Perokok pasif (dari lingkungan rumah/tempat
                                kerja)</label>
                        </div>
                        <div class="form-check ml-3">
                            <input type="radio" class="form-check-input" name="merokok" value="3" id="ya"
                                {{ old('merokok', $kankerParu->merokok ?? '') == 3 ? 'checked' : '' }}>
                            <label class="form-check-label" for="ya">Bekas perokok, berhenti < 15 tahun lalu</label>
                        </div>
                        <div class="form-check ml-3">
                            <input type="radio" class="form-check-input" name="merokok" value="4" id="ya"
                                {{ old('merokok', $kankerParu->merokok ?? '') == 4 ? 'checked' : '' }}>
                            <label class="form-check-label" for="ya">Perokok aktif (dalam 1 tahun ini masih
                                merokok)</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label>4.Lingkungan tempat tinggal berpotensi tinggi (lingkungan
                        pabrik/pertambangan/tempat buangan sampah/tepi jalan besar)</label>
                    <div class="d-flex">
                        <div class="form-check mr-3">
                            <input type="radio" class="form-check-input" name="riwayat_tempat_kerja" value="1"
                                id="tidak"
                                {{ old('riwayat_tempat_kerja', $kankerParu->riwayat_tempat_kerja ?? '') == 1 ? 'checked' : '' }}>
                            <label class="form-check-label" for="tidak">Tidak</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="riwayat_tempat_kerja" value="2"
                                id="sedang"
                                {{ old('riwayat_tempat_kerja', $kankerParu->riwayat_tempat_kerja ?? '') == 2 ? 'checked' : '' }}>
                            <label class="form-check-label" for="sedang">Tidak yakin/ragu-ragu</label>
                        </div>
                        <div class="form-check ml-3">
                            <input type="radio" class="form-check-input" name="riwayat_tempat_kerja" value="3"
                                id="ya"
                                {{ old('riwayat_tempat_kerja', $kankerParu->riwayat_tempat_kerja ?? '') == 3 ? 'checked' : '' }}>
                            <label class="form-check-label" for="ya">Ya</label>
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label>5.Lingkungan dalam rumah yang tidak sehat (ventilasi buruj/atap dari asbes/lantai
                        tanah/dapur kayu bakar/dapur breket/menggunakan rutin obat nyamuk
                        bakar/semprot,dll)</label>
                    <div class="d-flex">
                        <div class="form-check mr-3">
                            <input type="radio" class="form-check-input" name="lingkungan_rumah" value="1"
                                id="tidak"
                                {{ old('lingkungan_rumah', $kankerParu->lingkungan_rumah ?? '') == 1 ? 'checked' : '' }}>
                            <label class="form-check-label" for="tidak">Tidak</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="lingkungan_rumah" value="2"
                                id="sedang"
                                {{ old('lingkungan_rumah', $kankerParu->lingkungan_rumah ?? '') == 2 ? 'checked' : '' }}>
                            <label class="form-check-label" for="sedang">Tidak yakin/ragu-ragu</label>
                        </div>
                        <div class="form-check ml-3">
                            <input type="radio" class="form-check-input" name="lingkungan_rumah" value="3"
                                id="ya"
                                {{ old('lingkungan_rumah', $kankerParu->lingkungan_rumah ?? '') == 3 ? 'checked' : '' }}>
                            <label class="form-check-label" for="ya">Ya</label>
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label>6.Pernah didiagnosis/diobati penyakit paru kronik</label>
                    <div class="d-flex">
                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="paru_kronik" value="2"
                                id="sedang"
                                {{ old('paru_kronik', $kankerParu->paru_kronik ?? '') == 2 ? 'checked' : '' }}>
                            <label class="form-check-label" for="sedang">Ya, pernah. Penyakit Paru Kronik Lain
                                (PPOK):</label>
                        </div>
                        <div class="form-check ml-3">
                            <input type="radio" class="form-check-input" name="paru_kronik" value="3"
                                id="ya"
                                {{ old('paru_kronik', $kankerParu->paru_kronik ?? '') == 3 ? 'checked' : '' }}>
                            <label class="form-check-label" for="ya">Ya, pernah. Tuberkulosis (TBC)</label>
                        </div>

                    </div>
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
                Interpretasi Hasil dan Intervensi Lanjut:
                <li>Risiko ringan (skor ≤ 11) → Foto Toraks
                </li>
                <li>Risiko sedang (skor 12-16) → Rujuk ke FKTRL</li>
                <li>Risiko berat (skor 17-29) → Rujuk ke FKTRL</li>
            </strong></ul>

        </div>


        <div class="text-right mt-4">
            @if (isset($kankerParu) && $kankerParu)
                <a href="{{ route('kankerParu.lansia.admin') }}" type="button" class="btn btn-secondary mr-2"
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
                // 'jenis_kelamin',
                'usia',
                'kanker',
                'keluarga_kanker',
                'merokok',
                'riwayat_tempat_kerja',
                'tempat_tinggal',
                'lingkungan_rumah',
                'paru_kronik'
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
