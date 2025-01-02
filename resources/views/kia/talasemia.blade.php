@extends('layouts.skrining.master')
@section('title', 'Skrining Talasemia')
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

    <form action="{{ isset($talasemia) ? route('talasemia.update', $talasemia->id) : route('talasemia.store') }}"
        method="POST">
        @csrf
        @if (isset($talasemia))
            @method('PUT')
        @endif
        @if ($routeName === 'talasemia.view')
            <input type="hidden" name="klaster" value="2">
            <input type="hidden" name="poli" value="kia">
        @elseif($routeName === 'talasemia.mtbs.view')
            <input type="hidden" name="klaster" value="2">
            <input type="hidden" name="poli" value="mtbs">
        @elseif($routeName === 'talasemia.lansia.view')
            <input type="hidden" name="klaster" value="3">
            <input type="hidden" name="poli" value="lansia">
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
                                    {{ old('pasien', $talasemia->pasien ?? '') == $item->id ? 'selected' : '' }}>
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
                            value="{{ isset($talasemia) ? $talasemia->tanggal_lahir : '' }}">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Alamat Lengkap</label>
                        <input type="text" class="form-control" name="alamat" placeholder="Masukkan alamat lengkap"
                            id="alamat" value="{{ isset($talasemia) ? $talasemia->alamat : '' }}">
                    </div>
                </div>
            </div>


            <!-- Tanda dan Gejala Anamnesa Section -->
            <div class="form-section mt-4">
                <h3>Anamnesa</h3>
                <div class="form-group">
                    <label>1. Apakah rutin menerima transfusi darah?</label>
                    <div class="d-flex">
                        <div class="form-check mr-3">
                            <input type="radio" class="form-check-input" name="terima_darah" value="1" id="ya"
                                {{ isset($talasemia) && $talasemia->terima_darah == 1 ? 'checked' : '' }}>
                            <label class="form-check-label" for="ya">Ya</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="terima_darah" value="0" id="tidak"
                                {{ isset($talasemia) && $talasemia->terima_darah == 0 ? 'checked' : '' }}>
                            <label class="form-check-label" for="tidak">Tidak</label>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label>2. Apakah memiliki saudara penyandang talasemia?</label>
                    <div class="d-flex">
                        <div class="form-check mr-3">
                            <input type="radio" class="form-check-input" name="saudara_talasemia" value="1"
                                id="ya"
                                {{ isset($talasemia) && $talasemia->saudara_talasemia == 1 ? 'checked' : '' }}>
                            <label class="form-check-label" for="ya">Ya</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="saudara_talasemia" value="0"
                                id="tidak"
                                {{ isset($talasemia) && $talasemia->saudara_talasemia == 0 ? 'checked' : '' }}>
                            <label class="form-check-label" for="tidak">Tidak</label>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label>3. Apakah ada anggota keluarga yang rutin melakukan transfusi darah?</label>
                    <div class="d-flex">
                        <div class="form-check mr-3">
                            <input type="radio" class="form-check-input" name="keluarga_transfusi" value="1"
                                id="ya"
                                {{ isset($talasemia) && $talasemia->keluarga_transfusi == 1 ? 'checked' : '' }}>
                            <label class="form-check-label" for="ya">Ya</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="keluarga_transfusi" value="0"
                                id="tidak"
                                {{ isset($talasemia) && $talasemia->keluarga_transfusi == 0 ? 'checked' : '' }}>
                            <label class="form-check-label" for="tidak">Tidak</label>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label>4. Riwayat tumbuh kembang dan pubertas terlambat?</label>
                    <div class="d-flex">
                        <div class="form-check mr-3">
                            <input type="radio" class="form-check-input" name="pubertas_telat" value="1"
                                id="ya"
                                {{ isset($talasemia) && $talasemia->pubertas_telat == 1 ? 'checked' : '' }}>
                            <label class="form-check-label" for="ya">Ya</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="pubertas_telat" value="0"
                                id="tidak"
                                {{ isset($talasemia) && $talasemia->pubertas_telat == 0 ? 'checked' : '' }}>
                            <label class="form-check-label" for="tidak">Tidak</label>
                        </div>
                    </div>
                </div>

                <br>

                <li>Bila jawaban YA, lakukan pemeriksaan darah lengkap minimal mencakup
                    pemeriksaan Hb, MCV dan MCHC, serta melakukan pemeriksaan sediaan hapus
                    darah tepi.</li>
            </div>
            <div class="form-section mt-4">
                <h3>Pemeriksaan Fisik</h3>
                <img src="{{ asset('assets/images/facies_cooley.png') }}"
                    style="max-width: 300px; height: 300px;"alt="Pemeriksaan facies_cooley"
                    class="img-fluid mx-auto d-block">
                <div class="form-group">
                    <label>1. Anemia/pucat?</label>
                    <div class="d-flex">
                        <div class="form-check mr-3">
                            <input type="radio" class="form-check-input" name="anemia" value="1" id="ya_anemia"
                                {{ isset($talasemia) && $talasemia->anemia == 1 ? 'checked' : '' }}>
                            <label class="form-check-label" for="ya_anemia">Ya</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="anemia" value="0"
                                id="tidak_anemia" {{ isset($talasemia) && $talasemia->anemia == 0 ? 'checked' : '' }}>
                            <label class="form-check-label" for="tidak_anemia">Tidak</label>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label>2. Ikterus?</label>
                    <div class="d-flex">
                        <div class="form-check mr-3">
                            <input type="radio" class="form-check-input" name="ikterus" value="1"
                                id="ya_ikterus" {{ isset($talasemia) && $talasemia->ikterus == 1 ? 'checked' : '' }}>
                            <label class="form-check-label" for="ya_ikterus">Ya</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="ikterus" value="0"
                                id="tidak_ikterus" {{ isset($talasemia) && $talasemia->ikterus == 0 ? 'checked' : '' }}>
                            <label class="form-check-label" for="tidak_ikterus">Tidak</label>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label>3. Facies Cooley?</label>
                    <div class="d-flex">
                        <div class="form-check mr-3">
                            <input type="radio" class="form-check-input" name="faices_cooley" value="1"
                                id="ya_cooley" {{ isset($talasemia) && $talasemia->faices_cooley == 1 ? 'checked' : '' }}>
                            <label class="form-check-label" for="ya_cooley">Ya</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="faices_cooley" value="0"
                                id="tidak_cooley"
                                {{ isset($talasemia) && $talasemia->faices_cooley == 0 ? 'checked' : '' }}>
                            <label class="form-check-label" for="tidak_cooley">Tidak</label>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label>4. Perut buncit (hepatosplenomegaly)?</label>
                    <div class="d-flex">
                        <div class="form-check mr-3">
                            <input type="radio" class="form-check-input" name="perut_buncit" value="1"
                                id="ya_buncit" {{ isset($talasemia) && $talasemia->perut_buncit == 1 ? 'checked' : '' }}>
                            <label class="form-check-label" for="ya_buncit">Ya</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="perut_buncit" value="0"
                                id="tidak_buncit"
                                {{ isset($talasemia) && $talasemia->perut_buncit == 0 ? 'checked' : '' }}>
                            <label class="form-check-label" for="tidak_buncit">Tidak</label>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label>5. Gizi kurang/buruk?</label>
                    <div class="d-flex">
                        <div class="form-check mr-3">
                            <input type="radio" class="form-check-input" name="gizi_buruk" value="1"
                                id="ya_gizi" {{ isset($talasemia) && $talasemia->gizi_buruk == 1 ? 'checked' : '' }}>
                            <label class="form-check-label" for="ya_gizi">Ya</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="gizi_buruk" value="0"
                                id="tidak_gizi" {{ isset($talasemia) && $talasemia->gizi_buruk == 0 ? 'checked' : '' }}>
                            <label class="form-check-label" for="tidak_gizi">Tidak</label>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label>6. Perawakan pendek?</label>
                    <div class="d-flex">
                        <div class="form-check mr-3">
                            <input type="radio" class="form-check-input" name="tubuh_pendek" value="1"
                                id="ya_pendek" {{ isset($talasemia) && $talasemia->tubuh_pendek == 1 ? 'checked' : '' }}>
                            <label class="form-check-label" for="ya_pendek">Ya</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="tubuh_pendek" value="0"
                                id="tidak_pendek"
                                {{ isset($talasemia) && $talasemia->tubuh_pendek == 0 ? 'checked' : '' }}>
                            <label class="form-check-label" for="tidak_pendek">Tidak</label>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label>7. Hiperpigmentasi kulit?</label>
                    <div class="d-flex">
                        <div class="form-check mr-3">
                            <input type="radio" class="form-check-input" name="hiperpigmentasi_kulit" value="1"
                                id="ya_kulit"
                                {{ isset($talasemia) && $talasemia->hiperpigmentasi_kulit == 1 ? 'checked' : '' }}>
                            <label class="form-check-label" for="ya_kulit">Ya</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="hiperpigmentasi_kulit" value="0"
                                id="tidak_kulit"
                                {{ isset($talasemia) && $talasemia->hiperpigmentasi_kulit == 0 ? 'checked' : '' }}>
                            <label class="form-check-label" for="tidak_kulit">Tidak</label>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-12">
                        <label for="kesimpulan" style="color: rgb(19, 11, 241);">Kesimpulan</label>
                        <textarea class="form-control" id="kesimpulan" name="kesimpulan" placeholder="Kesimpulan">{{ old('kesimpulan', $talasemia->kesimpulan ?? '') }}</textarea>
                    </div>
                </div>>

            </div>

            <div class="form-section mt-4">
                <h3>Laboratorium (jika tidak ada fasilitas pemeriksaan, rujuk ke fasilitas laboratorium
                    lainnya)</h3>
                <li>Pemeriksaan Hb</li>
                <li>MCV</li>
                <li>MCHC</li>
                <li>Sediaan hapus darah tepi</li>
            </div>
            <h5>Analisis Hasil Pemeriksaan</h5>
            <li>Pasien dicurigai sebagai pembawa sifat talasemia bila nilai salah satu dari Hb, MCV atau MCH
                lebih rendah dari batasan normal (Hb < 11 mg/dL, MCV < 80 fL, MCH < 27 pq) maka pasien harus dirujuk ke
                    FKRTL untuk pemeriksaan lebih lanjut, atau dapat juga melakukan rujukan sampel (darah yang diambil
                    dibagi ke dalam 2 tabung dan dirujuk di hari yang sama)</li>


                    <div class="text-right mt-4">
                        @if (isset($talasemia))
                            <a href="{{ route('talasemia.admin') }}" type="button" class="btn btn-secondary mr-2"
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


                $('#tanggal_lahir').val(dob);
                $('#alamat').val(alamat);
            });
            $('#pasien').trigger('change');
        });
    </script>
@endsection
