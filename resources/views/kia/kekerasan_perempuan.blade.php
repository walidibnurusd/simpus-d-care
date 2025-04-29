<<<<<<< HEAD
@extends('layouts.skrining.master')
@section('title', 'Skrining Kekerasan Pada Perempuan')
@section('content')
    <!-- Identitas Section -->
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
        action="{{ isset($kekerasanPerempuan) ? route('kekerasan.perempuan.update', $kekerasanPerempuan->id) : route('kekerasan.perempuan.store') }}"
        method="POST">
        @csrf
        @if (isset($kekerasanPerempuan))
            @method('PUT')
        @endif
        @if ($routeName === 'kekerasan.perempuan.view')
            <input type="hidden" name="klaster" value="2">
            <input type="hidden" name="poli" value="kia">
        @elseif($routeName === 'kekerasan.perempuan.mtbs.view')
            <input type="hidden" name="klaster" value="2">
            <input type="hidden" name="poli" value="mtbs">
        @endif

        <div class="form-section">
            <h3>Identitas</h3>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Pasien</label>
                        <select class="form-control form-select select2" id="pasien" name="pasien">
                            <option value="" disabled {{ old('pasien') == '' ? 'selected' : '' }}>Pilih</option>
                            @if ($pasien)
                                <option value="{{ $pasien->id }}" selected>{{ $pasien->name }} - {{ $pasien->nik }}
                                </option>
                            @endif
                        </select> @error('pasien')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>No. Responden</label>
                        <input type="number" class="form-control" name="no_responden"
                            placeholder="Masukkan nomor responden"
                            value="{{ old('no_responden', $kekerasanPerempuan->no_responden ?? '') }}">
                    </div>
                </div>
            </div>


            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Umur</label>
                        <input type="number" class="form-control" name="usia" value="{{ $tbc->usia ?? '' }}"
                            id="usiaInput" readonly>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Tempat wawancara</label>
                        <input type="text" class="form-control" name="tempat_wawancara"
                            placeholder="Masukkan tempat wawancara"
                            value="{{ old('tempat_wawancara', $kekerasanPerempuan->tempat_wawancara ?? '') }}">
                    </div>
                </div>
            </div>
        </div>

        <div class="form-section mt-4">

            <h3>Pertanyaan Awal</h3>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label>1. Secara umum, bagaimana Ibu menggambarkan hubungan Ibu dengan pasangan?</label>
                        <div class="d-flex">
                            <div class="form-check mr-3">
                                <input type="radio" class="form-check-input" name="hubungan_dengan_pasangan"
                                    value="3" id="penuh_ketegangan" onclick="calculateScore()"
                                    {{ isset($kekerasanPerempuan->hubungan_dengan_pasangan) && $kekerasanPerempuan->hubungan_dengan_pasangan == 3 ? 'checked' : '' }}>
                                <label class="form-check-label" for="penuh_ketegangan">Penuh ketegangan</label>
                            </div>
                            <div class="form-check">
                                <input type="radio" class="form-check-input" name="hubungan_dengan_pasangan"
                                    value="2" id="agak_ketegangan" onclick="calculateScore()"
                                    {{ isset($kekerasanPerempuan->hubungan_dengan_pasangan) && $kekerasanPerempuan->hubungan_dengan_pasangan == 2 ? 'checked' : '' }}>
                                <label class="form-check-label" for="agak_ketegangan">Agak ada ketegangan</label>
                            </div>
                            <div class="form-check ml-3">
                                <input type="radio" class="form-check-input" name="hubungan_dengan_pasangan"
                                    value="1" id="tanpa_ketegangan" onclick="calculateScore()"
                                    {{ isset($kekerasanPerempuan->hubungan_dengan_pasangan) && $kekerasanPerempuan->hubungan_dengan_pasangan == 1 ? 'checked' : '' }}>
                                <label class="form-check-label" for="tanpa_ketegangan">Tanpa ketegangan</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group">
                        <label>2. Apakah Ibu dan pasangan Ibu mengatasi pertengkaran mulut dengan?</label>
                        <div class="d-flex">
                            <div class="form-check mr-3">
                                <input type="radio" class="form-check-input" name="mengatasi_pertengkaran_mulut"
                                    value="3" id="sangat_kesulitan" onclick="calculateScore()"
                                    {{ isset($kekerasanPerempuan->mengatasi_pertengkaran_mulut) && $kekerasanPerempuan->mengatasi_pertengkaran_mulut == 3 ? 'checked' : '' }}>
                                <label class="form-check-label" for="sangat_kesulitan">Sangat kesulitan</label>
                            </div>
                            <div class="form-check">
                                <input type="radio" class="form-check-input" name="mengatasi_pertengkaran_mulut"
                                    value="2" id="agak_kesulitan" onclick="calculateScore()"
                                    {{ isset($kekerasanPerempuan->mengatasi_pertengkaran_mulut) && $kekerasanPerempuan->mengatasi_pertengkaran_mulut == 2 ? 'checked' : '' }}>
                                <label class="form-check-label" for="agak_kesulitan">Agak kesulitan</label>
                            </div>
                            <div class="form-check ml-3">
                                <input type="radio" class="form-check-input" name="mengatasi_pertengkaran_mulut"
                                    value="1" id="tanpa_kesulitan" onclick="calculateScore()"
                                    {{ isset($kekerasanPerempuan->mengatasi_pertengkaran_mulut) && $kekerasanPerempuan->mengatasi_pertengkaran_mulut == 1 ? 'checked' : '' }}>
                                <label class="form-check-label" for="tanpa_kesulitan">Tanpa kesulitan</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>

        <div class="form-group d-none" id="pertanyaanLanjutanSection">
            <h3>Pertanyaan Lanjutan</h3>
            <div class="row">
                <!-- Question 3 -->
                <div class="col-md-12">
                    <div class="form-group">
                        <label>3. Apakah pertengkaran mulut mengakibatkan Ibu merasa direndahkan atau merasa tidak
                            nyaman dengan diri sendiri?</label>
                        <div class="d-flex">
                            <div class="form-check mr-3">
                                <input type="radio" class="form-check-input" name="akibat_pertengkaran_mulut"
                                    value="3" onclick="calculateScore()"
                                    {{ isset($kekerasanPerempuan->akibat_pertengkaran_mulut) && $kekerasanPerempuan->akibat_pertengkaran_mulut == 3 ? 'checked' : '' }}>
                                <label class="form-check-label" for="sering">Sering</label>
                            </div>
                            <div class="form-check">
                                <input type="radio" class="form-check-input" name="akibat_pertengkaran_mulut"
                                    value="2" onclick="calculateScore()"
                                    {{ isset($kekerasanPerempuan->akibat_pertengkaran_mulut) && $kekerasanPerempuan->akibat_pertengkaran_mulut == 2 ? 'checked' : '' }}>
                                <label class="form-check-label" for="kadang_kadang">Kadang-kadang</label>
                            </div>
                            <div class="form-check ml-3">
                                <input type="radio" class="form-check-input" name="akibat_pertengkaran_mulut"
                                    value="1" onclick="calculateScore()"
                                    {{ isset($kekerasanPerempuan->akibat_pertengkaran_mulut) && $kekerasanPerempuan->akibat_pertengkaran_mulut == 1 ? 'checked' : '' }}>
                                <label class="form-check-label" for="tidak_pernah">Tidak pernah</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 d-none">
                    <div class="form-group">
                        <label>Tanggal Lahir</label>
                        <input type="date" class="form-control" name="tanggal_lahir" id="tanggal_lahir"
                            value="{{ $pasien->dob ?? '' }}" readonly>
                    </div>
                </div>

                <!-- Question 4 -->
                <div class="col-md-12">
                    <div class="form-group">
                        <label>4. Apakah pertengkaran mulut mengakibatkan pasangan Ibu memukul, menendang, atau
                            mendorong?</label>
                        <div class="d-flex">
                            <div class="form-check mr-3">
                                <input type="radio" class="form-check-input" name="pasangan_memukul" value="3"
                                    onclick="calculateScore()"
                                    {{ isset($kekerasanPerempuan->pasangan_memukul) && $kekerasanPerempuan->pasangan_memukul == 3 ? 'checked' : '' }}>
                                <label class="form-check-label" for="sering">Sering</label>
                            </div>
                            <div class="form-check">
                                <input type="radio" class="form-check-input" name="pasangan_memukul" value="2"
                                    onclick="calculateScore()"
                                    {{ isset($kekerasanPerempuan->pasangan_memukul) && $kekerasanPerempuan->pasangan_memukul == 2 ? 'checked' : '' }}>
                                <label class="form-check-label" for="kadang_kadang">Kadang-kadang</label>
                            </div>
                            <div class="form-check ml-3">
                                <input type="radio" class="form-check-input" name="pasangan_memukul" value="1"
                                    onclick="calculateScore()"
                                    {{ isset($kekerasanPerempuan->pasangan_memukul) && $kekerasanPerempuan->pasangan_memukul == 1 ? 'checked' : '' }}>
                                <label class="form-check-label" for="tidak_pernah">Tidak pernah</label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Question 5 -->
                <div class="col-md-12">
                    <div class="form-group">
                        <label>5. Apakah Ibu merasa ketakutan pada yang dikatakan atau dilakukan oleh pasangan
                            Ibu?</label>
                        <div class="d-flex">
                            <div class="form-check mr-3">
                                <input type="radio" class="form-check-input" name="ketakutan" value="3"
                                    onclick="calculateScore()"
                                    {{ isset($kekerasanPerempuan->ketakutan) && $kekerasanPerempuan->ketakutan == 3 ? 'checked' : '' }}>
                                <label class="form-check-label" for="sering">Sering</label>
                            </div>
                            <div class="form-check">
                                <input type="radio" class="form-check-input" name="ketakutan" value="2"
                                    onclick="calculateScore()"
                                    {{ isset($kekerasanPerempuan->ketakutan) && $kekerasanPerempuan->ketakutan == 2 ? 'checked' : '' }}>
                                <label class="form-check-label" for="kadang_kadang">Kadang-kadang</label>
                            </div>
                            <div class="form-check ml-3">
                                <input type="radio" class="form-check-input" name="ketakutan" value="1"
                                    onclick="calculateScore()"
                                    {{ isset($kekerasanPerempuan->ketakutan) && $kekerasanPerempuan->ketakutan == 1 ? 'checked' : '' }}>
                                <label class="form-check-label" for="tidak_pernah">Tidak pernah</label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Question 6 -->
                <div class="col-md-12">
                    <div class="form-group">
                        <label>6. Apakah Ibu merasa dibatasi dalam mengatur pembelanjaan rumah tangga?</label>
                        <div class="d-flex">
                            <div class="form-check mr-3">
                                <input type="radio" class="form-check-input" name="dibatasi" value="3"
                                    onclick="calculateScore()"
                                    {{ isset($kekerasanPerempuan->dibatasi) && $kekerasanPerempuan->dibatasi == 3 ? 'checked' : '' }}>
                                <label class="form-check-label" for="sering">Sering</label>
                            </div>
                            <div class="form-check">
                                <input type="radio" class="form-check-input" name="dibatasi" value="2"
                                    onclick="calculateScore()"
                                    {{ isset($kekerasanPerempuan->dibatasi) && $kekerasanPerempuan->dibatasi == 2 ? 'checked' : '' }}>
                                <label class="form-check-label" for="kadang_kadang">Kadang-kadang</label>
                            </div>
                            <div class="form-check ml-3">
                                <input type="radio" class="form-check-input" name="dibatasi" value="1"
                                    onclick="calculateScore()"
                                    {{ isset($kekerasanPerempuan->dibatasi) && $kekerasanPerempuan->dibatasi == 1 ? 'checked' : '' }}>
                                <label class="form-check-label" for="tidak_pernah">Tidak pernah</label>
                            </div>
                        </div>
                    </div>
                </div>


            </div>

        </div>

        <div class="form-group mt-4">

            <div class="form-group">

                <label for="kesimpulan" style="color: rgb(19, 11, 241);">Kesimpulan</label>
                <textarea class="form-control" id="kesimpulan" name="kesimpulan" placeholder="Kesimpulan">{{ old('kesimpulan', $kekerasanPerempuan->kesimpulan ?? '') }}</textarea>

            </div>
            <br>
            <label>Skor Total</label>
            <div class="d-flex">
                <input type="text" class="form-control" id="totalScore" value="0" disabled>
            </div>
        </div>
        <li><strong>Jika hasil penjumlahan skor dari pertanyaan awal dan pertanyaan Lanjutan ≥ 13
                maka pasien terindikasi mengalami kekerasan</strong></li>


        <div class="text-right mt-4">
            {{-- @if (isset($kekerasanPerempuan))
                <a href="{{ route('kekerasan.perempuan.admin') }}" type="button" class="btn btn-secondary mr-2"
                    style="font-size: 20px">Kembali</a>
            @else
                <a href="{{ route('skrining.ilp') }}" type="button" class="btn btn-secondary mr-2"
                    style="font-size: 20px">Kembali</a>
            @endif --}}
            <button type="submit" class="btn btn-primary" style="font-size: 20px">Kirim</button>
        </div>
    </form>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Event Listener untuk Tanggal Lahir
            const tanggalLahirInput = document.getElementById('tanggal_lahir');
            const usiaInput = document.getElementById('usiaInput');

            if (tanggalLahirInput && usiaInput) {
                // Tambahkan event listener untuk menghitung usia saat tanggal lahir berubah
                tanggalLahirInput.addEventListener('change', () => {
                    const tanggalLahir = new Date(tanggalLahirInput.value);
                    const hariIni = new Date();
                    let usia = hariIni.getFullYear() - tanggalLahir.getFullYear();
                    const bulan = hariIni.getMonth() - tanggalLahir.getMonth();

                    // Koreksi jika bulan/tanggal sekarang lebih kecil dari bulan/tanggal lahir
                    if (bulan < 0 || (bulan === 0 && hariIni.getDate() < tanggalLahir.getDate())) {
                        usia--;
                    }

                    // Perbarui nilai usia (jangan biarkan negatif)
                    usiaInput.value = usia >= 0 ? usia : 0;

                    // Panggil fungsi terkait usia
                    handleUsiaChange();
                });
            }

            // Jalankan fungsi awal jika nilai sudah diatur
            if (tanggalLahirInput?.value) {
                tanggalLahirInput.dispatchEvent(new Event('change'));
            }
        });

        function calculateScore() {
            let totalScore = 0;

            // Calculate the score from 'Pertanyaan Awal'
            const awalQuestions = document.querySelectorAll(
                'input[name="hubungan_dengan_pasangan"]:checked, input[name="mengatasi_pertengkaran_mulut"]:checked'
            );
            awalQuestions.forEach(question => {
                totalScore += parseInt(question.value);
            });

            // Display or hide 'Pertanyaan Lanjutan' based on totalScore
            const pertanyaanLanjutanSection = document.getElementById('pertanyaanLanjutanSection');
            if (totalScore > 5) {
                pertanyaanLanjutanSection.classList.remove('d-none'); // Show 'Pertanyaan Lanjutan'
            } else {
                pertanyaanLanjutanSection.classList.add('d-none'); // Hide 'Pertanyaan Lanjutan'
            }

            // Update the total score display
            document.getElementById('totalScore').value = totalScore;
        }

        // Attach calculateScore function to each option
        document.querySelectorAll('input[type="radio"]').forEach(radio => {
            radio.addEventListener('change', calculateScore);
        });

        // Run calculateScore on page load to handle pre-filled data
        window.onload = function() {
            calculateScore(); // Initialize the score and show/hide questions appropriately
        };
    </script>
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


                var dob = selectedOption.data('dob');


                $('#tanggal_lahir').val(dob);

                if (dob) {
                    var today = new Date();
                    var birthDate = new Date(dob);
                    var age = today.getFullYear() - birthDate.getFullYear();
                    var monthDiff = today.getMonth() - birthDate.getMonth();
                    if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthDate.getDate())) {
                        age--;
                    }
                    $('#umurInput').val(age); // Set umur pada input

                }
                calculateScore();

            });
            $('#pasien').trigger('change');
        });
    </script>

@endsection
=======
@extends('layouts.skrining.master')
@section('title', 'Skrining Kekerasan Pada Perempuan')
@section('content')
    <!-- Identitas Section -->
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
        action="{{ isset($kekerasanPerempuan) ? route('kekerasan.perempuan.update', $kekerasanPerempuan->id) : route('kekerasan.perempuan.store') }}"
        method="POST">
        @csrf
        @if (isset($kekerasanPerempuan))
            @method('PUT')
        @endif
        @if ($routeName === 'kekerasan.perempuan.view')
            <input type="hidden" name="klaster" value="2">
            <input type="hidden" name="poli" value="kia">
        @elseif($routeName === 'kekerasan.perempuan.mtbs.view')
            <input type="hidden" name="klaster" value="2">
            <input type="hidden" name="poli" value="mtbs">
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
                                    {{ old('pasien', $kekerasanPerempuan->pasien ?? '') == $item->id ? 'selected' : '' }}>
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
                        <label>No. Responden</label>
                        <input type="number" class="form-control" name="no_responden"
                            placeholder="Masukkan nomor responden"
                            value="{{ old('no_responden', $kekerasanPerempuan->no_responden ?? '') }}">
                    </div>
                </div>
            </div>


            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Umur</label>
                        <input type="number" class="form-control" name="umur" placeholder="Masukkan umur" id="umurInput"
                            readonly readonly value="{{ old('umur', $kekerasanPerempuan->umur ?? '') }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Tempat wawancara</label>
                        <input type="text" class="form-control" name="tempat_wawancara"
                            placeholder="Masukkan tempat wawancara"
                            value="{{ old('tempat_wawancara', $kekerasanPerempuan->tempat_wawancara ?? '') }}">
                    </div>
                </div>
            </div>
        </div>

        <div class="form-section mt-4">

            <h3>Pertanyaan Awal</h3>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label>1. Secara umum, bagaimana Ibu menggambarkan hubungan Ibu dengan pasangan?</label>
                        <div class="d-flex">
                            <div class="form-check mr-3">
                                <input type="radio" class="form-check-input" name="hubungan_dengan_pasangan"
                                    value="3" id="penuh_ketegangan" onclick="calculateScore()"
                                    {{ isset($kekerasanPerempuan->hubungan_dengan_pasangan) && $kekerasanPerempuan->hubungan_dengan_pasangan == 3 ? 'checked' : '' }}>
                                <label class="form-check-label" for="penuh_ketegangan">Penuh ketegangan</label>
                            </div>
                            <div class="form-check">
                                <input type="radio" class="form-check-input" name="hubungan_dengan_pasangan"
                                    value="2" id="agak_ketegangan" onclick="calculateScore()"
                                    {{ isset($kekerasanPerempuan->hubungan_dengan_pasangan) && $kekerasanPerempuan->hubungan_dengan_pasangan == 2 ? 'checked' : '' }}>
                                <label class="form-check-label" for="agak_ketegangan">Agak ada ketegangan</label>
                            </div>
                            <div class="form-check ml-3">
                                <input type="radio" class="form-check-input" name="hubungan_dengan_pasangan"
                                    value="1" id="tanpa_ketegangan" onclick="calculateScore()"
                                    {{ isset($kekerasanPerempuan->hubungan_dengan_pasangan) && $kekerasanPerempuan->hubungan_dengan_pasangan == 1 ? 'checked' : '' }}>
                                <label class="form-check-label" for="tanpa_ketegangan">Tanpa ketegangan</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group">
                        <label>2. Apakah Ibu dan pasangan Ibu mengatasi pertengkaran mulut dengan?</label>
                        <div class="d-flex">
                            <div class="form-check mr-3">
                                <input type="radio" class="form-check-input" name="mengatasi_pertengkaran_mulut"
                                    value="3" id="sangat_kesulitan" onclick="calculateScore()"
                                    {{ isset($kekerasanPerempuan->mengatasi_pertengkaran_mulut) && $kekerasanPerempuan->mengatasi_pertengkaran_mulut == 3 ? 'checked' : '' }}>
                                <label class="form-check-label" for="sangat_kesulitan">Sangat kesulitan</label>
                            </div>
                            <div class="form-check">
                                <input type="radio" class="form-check-input" name="mengatasi_pertengkaran_mulut"
                                    value="2" id="agak_kesulitan" onclick="calculateScore()"
                                    {{ isset($kekerasanPerempuan->mengatasi_pertengkaran_mulut) && $kekerasanPerempuan->mengatasi_pertengkaran_mulut == 2 ? 'checked' : '' }}>
                                <label class="form-check-label" for="agak_kesulitan">Agak kesulitan</label>
                            </div>
                            <div class="form-check ml-3">
                                <input type="radio" class="form-check-input" name="mengatasi_pertengkaran_mulut"
                                    value="1" id="tanpa_kesulitan" onclick="calculateScore()"
                                    {{ isset($kekerasanPerempuan->mengatasi_pertengkaran_mulut) && $kekerasanPerempuan->mengatasi_pertengkaran_mulut == 1 ? 'checked' : '' }}>
                                <label class="form-check-label" for="tanpa_kesulitan">Tanpa kesulitan</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>

        <div class="form-group d-none" id="pertanyaanLanjutanSection">
            <h3>Pertanyaan Lanjutan</h3>
            <div class="row">
                <!-- Question 3 -->
                <div class="col-md-12">
                    <div class="form-group">
                        <label>3. Apakah pertengkaran mulut mengakibatkan Ibu merasa direndahkan atau merasa tidak
                            nyaman dengan diri sendiri?</label>
                        <div class="d-flex">
                            <div class="form-check mr-3">
                                <input type="radio" class="form-check-input" name="akibat_pertengkaran_mulut"
                                    value="3" onclick="calculateScore()"
                                    {{ isset($kekerasanPerempuan->akibat_pertengkaran_mulut) && $kekerasanPerempuan->akibat_pertengkaran_mulut == 3 ? 'checked' : '' }}>
                                <label class="form-check-label" for="sering">Sering</label>
                            </div>
                            <div class="form-check">
                                <input type="radio" class="form-check-input" name="akibat_pertengkaran_mulut"
                                    value="2" onclick="calculateScore()"
                                    {{ isset($kekerasanPerempuan->akibat_pertengkaran_mulut) && $kekerasanPerempuan->akibat_pertengkaran_mulut == 2 ? 'checked' : '' }}>
                                <label class="form-check-label" for="kadang_kadang">Kadang-kadang</label>
                            </div>
                            <div class="form-check ml-3">
                                <input type="radio" class="form-check-input" name="akibat_pertengkaran_mulut"
                                    value="1" onclick="calculateScore()"
                                    {{ isset($kekerasanPerempuan->akibat_pertengkaran_mulut) && $kekerasanPerempuan->akibat_pertengkaran_mulut == 1 ? 'checked' : '' }}>
                                <label class="form-check-label" for="tidak_pernah">Tidak pernah</label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Question 4 -->
                <div class="col-md-12">
                    <div class="form-group">
                        <label>4. Apakah pertengkaran mulut mengakibatkan pasangan Ibu memukul, menendang, atau
                            mendorong?</label>
                        <div class="d-flex">
                            <div class="form-check mr-3">
                                <input type="radio" class="form-check-input" name="pasangan_memukul" value="3"
                                    onclick="calculateScore()"
                                    {{ isset($kekerasanPerempuan->pasangan_memukul) && $kekerasanPerempuan->pasangan_memukul == 3 ? 'checked' : '' }}>
                                <label class="form-check-label" for="sering">Sering</label>
                            </div>
                            <div class="form-check">
                                <input type="radio" class="form-check-input" name="pasangan_memukul" value="2"
                                    onclick="calculateScore()"
                                    {{ isset($kekerasanPerempuan->pasangan_memukul) && $kekerasanPerempuan->pasangan_memukul == 2 ? 'checked' : '' }}>
                                <label class="form-check-label" for="kadang_kadang">Kadang-kadang</label>
                            </div>
                            <div class="form-check ml-3">
                                <input type="radio" class="form-check-input" name="pasangan_memukul" value="1"
                                    onclick="calculateScore()"
                                    {{ isset($kekerasanPerempuan->pasangan_memukul) && $kekerasanPerempuan->pasangan_memukul == 1 ? 'checked' : '' }}>
                                <label class="form-check-label" for="tidak_pernah">Tidak pernah</label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Question 5 -->
                <div class="col-md-12">
                    <div class="form-group">
                        <label>5. Apakah Ibu merasa ketakutan pada yang dikatakan atau dilakukan oleh pasangan
                            Ibu?</label>
                        <div class="d-flex">
                            <div class="form-check mr-3">
                                <input type="radio" class="form-check-input" name="ketakutan" value="3"
                                    onclick="calculateScore()"
                                    {{ isset($kekerasanPerempuan->ketakutan) && $kekerasanPerempuan->ketakutan == 3 ? 'checked' : '' }}>
                                <label class="form-check-label" for="sering">Sering</label>
                            </div>
                            <div class="form-check">
                                <input type="radio" class="form-check-input" name="ketakutan" value="2"
                                    onclick="calculateScore()"
                                    {{ isset($kekerasanPerempuan->ketakutan) && $kekerasanPerempuan->ketakutan == 2 ? 'checked' : '' }}>
                                <label class="form-check-label" for="kadang_kadang">Kadang-kadang</label>
                            </div>
                            <div class="form-check ml-3">
                                <input type="radio" class="form-check-input" name="ketakutan" value="1"
                                    onclick="calculateScore()"
                                    {{ isset($kekerasanPerempuan->ketakutan) && $kekerasanPerempuan->ketakutan == 1 ? 'checked' : '' }}>
                                <label class="form-check-label" for="tidak_pernah">Tidak pernah</label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Question 6 -->
                <div class="col-md-12">
                    <div class="form-group">
                        <label>6. Apakah Ibu merasa dibatasi dalam mengatur pembelanjaan rumah tangga?</label>
                        <div class="d-flex">
                            <div class="form-check mr-3">
                                <input type="radio" class="form-check-input" name="dibatasi" value="3"
                                    onclick="calculateScore()"
                                    {{ isset($kekerasanPerempuan->dibatasi) && $kekerasanPerempuan->dibatasi == 3 ? 'checked' : '' }}>
                                <label class="form-check-label" for="sering">Sering</label>
                            </div>
                            <div class="form-check">
                                <input type="radio" class="form-check-input" name="dibatasi" value="2"
                                    onclick="calculateScore()"
                                    {{ isset($kekerasanPerempuan->dibatasi) && $kekerasanPerempuan->dibatasi == 2 ? 'checked' : '' }}>
                                <label class="form-check-label" for="kadang_kadang">Kadang-kadang</label>
                            </div>
                            <div class="form-check ml-3">
                                <input type="radio" class="form-check-input" name="dibatasi" value="1"
                                    onclick="calculateScore()"
                                    {{ isset($kekerasanPerempuan->dibatasi) && $kekerasanPerempuan->dibatasi == 1 ? 'checked' : '' }}>
                                <label class="form-check-label" for="tidak_pernah">Tidak pernah</label>
                            </div>
                        </div>
                    </div>
                </div>


            </div>

        </div>

        <div class="form-group mt-4">

            <div class="form-group">

                <label for="kesimpulan" style="color: rgb(19, 11, 241);">Kesimpulan</label>
                <textarea class="form-control" id="kesimpulan" name="kesimpulan" placeholder="Kesimpulan">{{ old('kesimpulan', $kekerasanPerempuan->kesimpulan ?? '') }}</textarea>

            </div>
            <br>
            <label>Skor Total</label>
            <div class="d-flex">
                <input type="text" class="form-control" id="totalScore" value="0" disabled>
            </div>
        </div>
        <li><strong>Jika hasil penjumlahan skor dari pertanyaan awal dan pertanyaan Lanjutan ≥ 13
                maka pasien terindikasi mengalami kekerasan</strong></li>


        <div class="text-right mt-4">
            {{-- @if (isset($kekerasanPerempuan))
                <a href="{{ route('kekerasan.perempuan.admin') }}" type="button" class="btn btn-secondary mr-2"
                    style="font-size: 20px">Kembali</a>
            @else
                <a href="{{ route('skrining.ilp') }}" type="button" class="btn btn-secondary mr-2"
                    style="font-size: 20px">Kembali</a>
            @endif --}}
            <button type="submit" class="btn btn-primary" style="font-size: 20px">Kirim</button>
        </div>
    </form>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function calculateScore() {
            let totalScore = 0;

            // Calculate the score from 'Pertanyaan Awal'
            const awalQuestions = document.querySelectorAll(
                'input[name="hubungan_dengan_pasangan"]:checked, input[name="mengatasi_pertengkaran_mulut"]:checked'
            );
            awalQuestions.forEach(question => {
                totalScore += parseInt(question.value);
            });

            // Display or hide 'Pertanyaan Lanjutan' based on totalScore
            const pertanyaanLanjutanSection = document.getElementById('pertanyaanLanjutanSection');
            if (totalScore > 5) {
                pertanyaanLanjutanSection.classList.remove('d-none'); // Show 'Pertanyaan Lanjutan'
            } else {
                pertanyaanLanjutanSection.classList.add('d-none'); // Hide 'Pertanyaan Lanjutan'
            }

            // Update the total score display
            document.getElementById('totalScore').value = totalScore;
        }

        // Attach calculateScore function to each option
        document.querySelectorAll('input[type="radio"]').forEach(radio => {
            radio.addEventListener('change', calculateScore);
        });

        // Run calculateScore on page load to handle pre-filled data
        window.onload = function() {
            calculateScore(); // Initialize the score and show/hide questions appropriately
        };
    </script>
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


                var dob = selectedOption.data('dob');


                $('#tanggal_lahir').val(dob);

                if (dob) {
                    var today = new Date();
                    var birthDate = new Date(dob);
                    var age = today.getFullYear() - birthDate.getFullYear();
                    var monthDiff = today.getMonth() - birthDate.getMonth();
                    if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthDate.getDate())) {
                        age--;
                    }
                    $('#umurInput').val(age); // Set umur pada input

                }
                calculateScore();

            });
            $('#pasien').trigger('change');
        });
    </script>

@endsection
>>>>>>> 9df8fede466960d27744a11e4cb830e2a9437611
