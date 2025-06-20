@extends('layouts.skrining.master')
@section('title', 'Skrining Triple Eliminasi Bumil')
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

    <form action="{{ isset($triple) ? route('triple.eliminasi.update', $triple->id) : route('triple.eliminasi.store') }}"
        method="POST">
        @csrf
        @if (isset($triple))
            @method('PUT')
        @endif
        <div class="form-section">
            <h3>Identitas</h3>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>1. Pasien</label>
                        <select class="form-control form-select select2" id="pasien" name="pasien">
                            <option value="" disabled {{ old('pasien') == '' ? 'selected' : '' }}>Pilih</option>
                            @if ($pasien)
                                <option value="{{ $pasien->id }}" selected>{{ $pasien->name }} - {{ $pasien->nik }}
                                </option>
                            @endif
                        </select>
                        @error('pasien')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>2. Tempat lahir</label>
                        <input type="text" readonly class="form-control" id="tempat_lahir" name="tempat_lahir"
                            placeholder="Masukkan tempat lahir"
                            value="{{ isset($pasien->place_birth) ? $pasien->place_birth : old('tempat_lahir') }}">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>3. Tanggal Lahir</label>
                        <input type="date" readonly class="form-control" id="tanggal_lahir" name="tanggal_lahir"
                            value="{{ isset($pasien->dob) ? $pasien->dob : old('tanggal_lahir') }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>4. Pekerjaan</label>
                        <input type="text" readonly class="form-control" id="pekerjaan" name="pekerjaan" readonly
                            value="{{ $pasien->occupations->name }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>5. Status Perkawinan</label>
                        <input type="text" readonly class="form-control" id="perkawinan" name="perkawinan" readonly
                            value="{{ $pasien->marritalStatus->name }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>6. Status GPA</label>
                        <div class="row">
                            <!-- Gravida -->
                            <div class="col-md-4">
                                <label>Gravida</label>
                                <input type="number" name="gravida" class="form-control" placeholder="0" min="0"
                                    value="{{ isset($triple->gravida) ? $triple->gravida : old('gravida') }}">
                            </div>
                            <!-- Partus -->
                            <div class="col-md-4">
                                <label>Partus</label>
                                <input type="number" name="partus" class="form-control" placeholder="0" min="0"
                                    value="{{ isset($triple->partus) ? $triple->partus : old('partus') }}">
                            </div>
                            <!-- Abortus -->
                            <div class="col-md-4">
                                <label>Abortus</label>
                                <input type="number" name="abortus" class="form-control" placeholder="0" min="0"
                                    value="{{ isset($triple->abortus) ? $triple->abortus : old('abortus') }}">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>7. Umur kehamilan</label>
                        <div class="row">
                            <div class="col-md-12">
                                <input type="number" name="umur_kehamilan" class="form-control" placeholder="0"
                                    min="0"
                                    value="{{ isset($triple->umur_kehamilan) ? $triple->umur_kehamilan : old('umur_kehamilan') }}">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label>8. Taksiran persalinan</label>
                        <div class="row">
                            <div class="col-md-12">
                                <input type="text" name="taksiran_kehamilan" class="form-control"
                                    placeholder="masukkan taksiran kehamilan"
                                    value="{{ isset($triple->taksiran_kehamilan) ? $triple->taksiran_kehamilan : old('taksiran_kehamilan') }}">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>9. Nama puskesmas</label>
                        <div class="row">
                            <div class="col-md-12">
                                <input type="text" name="nama_puskesmas" class="form-control"
                                    placeholder="masukkan nama puskesmas"
                                    value="{{ isset($triple->nama_puskesmas) ? $triple->nama_puskesmas : old('nama_puskesmas') }}">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>10. Kode specimen</label>
                        <div class="row">
                            <div class="col-md-12">
                                <input type="text" name="kode_specimen" class="form-control"
                                    placeholder="masukkan kode specimen"
                                    value="{{ isset($triple->kode_specimen) ? $triple->kode_specimen : old('kode_specimen') }}">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>11. No Telp/Hp</label>
                        <div class="row">
                            <div class="col-md-12">
                                <input type="number" id="no_hp" name="no_hp" readonly class="form-control"
                                    placeholder="masukkan no hp" value="{{ $pasien->phone }}">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label>12. Umur ibu</label>
                        <div class="row align-items-center">
                            <div class="col-md-10">
                                <input type="text" class="form-control" name="umur_ibu"
                                    placeholder="masukkan umur ibu"
                                    value="{{ isset($triple->umur_ibu) ? $triple->umur_ibu : old('umur_ibu') }}">
                            </div>
                            <div class="col-auto">
                                <p class="mb-0">Tahun</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>13. Alamat</label>
                        <div class="row">
                            <div class="col-md-12">
                                <input type="text" id="alamat" name="alamat" class="form-control" readonly
                                    placeholder="masukkan alamat" value="{{ $pasien->address }}">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>14. Pendidikan Terakhir</label>
                        <input type="text" readonly class="form-control" id="pendidikan" name="pendidikan" readonly
                            value="{{ $pasien->educations->name }}">
                    </div>
                </div>

            </div>

        </div>
        <div class="form-section">
            <h3>Data Klinis dan Diagnostik</h3>
            <div class="form-group">
                <label>1. Apakah pernah mengalami gejala-gejala Hepatitis:</label>
                <div class="d-flex align-items-center mb-2">
                    <div class="form-check mr-3">
                        <input type="radio" name="gejala_hepatitis" value="1" class="form-check-input"
                            id="hepatitis-ya"
                            {{ isset($triple->gejala_hepatitis) && $triple->gejala_hepatitis == 1 ? 'checked' : '' }}>
                        <label class="form-check-label" for="hepatitis-ya">Ya</label>
                    </div>
                    <div class="form-check">
                        <input type="radio" name="gejala_hepatitis" value="0" class="form-check-input"
                            id="hepatitis-tidak"
                            {{ isset($triple->gejala_hepatitis) && $triple->gejala_hepatitis == 0 ? 'checked' : '' }}>
                        <label class="form-check-label" for="hepatitis-tidak">Tidak</label>
                    </div>
                </div>

                <!-- Detail Gejala -->
                <div id="detail-gejala"
                    style="{{ isset($triple->gejala_hepatitis) && $triple->gejala_hepatitis == 1 ? '' : 'display: none;' }}">
                    <div class="mb-2">
                        <label>Bila ya, gejalanya:</label>
                    </div>
                    <div class="form-group">
                        <label>Urine berwarna gelap (seperti teh):</label>
                        <input type="text" name="gejala_urine_gelap" class="form-control" placeholder="Jelaskan..."
                            value="{{ isset($triple->gejala_urine_gelap) ? $triple->gejala_urine_gelap : old('gejala_urine_gelap') }}">
                    </div>
                    <div class="form-group">
                        <label>Mata/kuku/kulit kuning:</label>
                        <input type="text" name="gejala_kuning" class="form-control" placeholder="Jelaskan..."
                            value="{{ isset($triple->gejala_kuning) ? $triple->gejala_kuning : old('gejala_kuning') }}">
                    </div>
                    <div class="form-group">
                        <label>Gejala Lainnya:</label>
                        <textarea name="gejala_lainnya" class="form-control" rows="3" placeholder="Jelaskan gejala lainnya...">{{ isset($triple->gejala_lainnya) ? $triple->gejala_lainnya : old('gejala_lainnya') }}</textarea>
                    </div>
                </div>
            </div>
            <div class="form-group" id="pertanyaan-2" style="display: none;">
                <label>2. Apakah pernah test Hepatitis B sebelumnya?</label>
                <div class="d-flex align-items-center mb-2">
                    <div class="form-check mr-3">
                        <input type="radio" name="test_hepatitis" value="1" class="form-check-input"
                            id="test-ya"
                            {{ isset($triple->test_hepatitis) && $triple->test_hepatitis == 1 ? 'checked' : '' }}>
                        <label class="form-check-label" for="test-ya">Ya</label>
                    </div>
                    <div class="form-check">
                        <input type="radio" name="test_hepatitis" value="0" class="form-check-input"
                            id="test-tidak"
                            {{ isset($triple->test_hepatitis) && $triple->test_hepatitis == 0 ? 'checked' : '' }}>
                        <label class="form-check-label" for="test-tidak">Tidak</label>
                    </div>
                </div>

                <div id="detail-test"
                    style="{{ isset($triple->test_hepatitis) && $triple->test_hepatitis == 1 ? '' : 'display: none;' }}">
                    <label for="lokasi">Dimana:</label>
                    <input type="text" id="lokasi" name="lokasi_tes" class="form-control"
                        placeholder="Masukkan lokasi tes"
                        value="{{ isset($triple->lokasi_tes) ? $triple->lokasi_tes : old('lokasi_tes') }}"><br>
                    <label for="tanggalTes">Kapan:</label>
                    <input type="date" id="tanggalTes" name="tanggal_tes" class="form-control"
                        value="{{ isset($triple->tanggal_tes) ? \Carbon\Carbon::parse($triple->tanggal_tes)->format('Y-m-d') : old('tanggal_tes') }}">
                    <label>Hasil Tes:</label>
                    <ul>
                        <li>HBsAg: <input type="text" name="HBsAg" class="form-control" placeholder="Hasil"
                                value="{{ isset($triple->HBsAg) ? $triple->HBsAg : old('HBsAg') }}"></li>
                        <li>Anti HBs: <input type="text" name="anti_hbs" class="form-control" placeholder="Hasil"
                                value="{{ isset($triple->anti_hbs) ? $triple->anti_hbs : old('anti_hbs') }}"></li>
                        <li>Anti HBC: <input type="text" name="anti_hbc" class="form-control" placeholder="Hasil"
                                value="{{ isset($triple->anti_hbc) ? $triple->anti_hbc : old('anti_hbc') }}"></li>
                        <li>SGPT/ALT: <input type="text" name="sgpt" class="form-control" placeholder="Hasil"
                                value="{{ isset($triple->sgpt) ? $triple->sgpt : old('sgpt') }}"></li>
                        <li>Anti Hbe: <input type="text" name="anti_hbe" class="form-control" placeholder="Hasil"
                                value="{{ isset($triple->anti_hbe) ? $triple->anti_hbe : old('anti_hbe') }}"></li>
                        <li>HBeAg: <input type="text" name="hbeag" class="form-control" placeholder="Hasil"
                                value="{{ isset($triple->hbeag) ? $triple->hbeag : old('hbeag') }}"></li>
                        <li>HBV DNA: <input type="text" name="hbv_dna" class="form-control" placeholder="Hasil"
                                value="{{ isset($triple->hbv_dna) ? $triple->hbv_dna : old('hbv_dna') }}"></li>
                    </ul>
                </div>

                <div class="form-group">
                    <label>3. Apakah pernah menerima transfusi darah atau produk darah?</label>
                    <div class="d-flex align-items-center mb-2">
                        <div class="form-check mr-3">
                            <input type="radio" name="transfusi_darah" value="1" class="form-check-input"
                                id="transfusi-ya"
                                {{ isset($triple->transfusi_darah) && $triple->transfusi_darah == 1 ? 'checked' : '' }}>
                            <label class="form-check-label" for="transfusi-ya">Ya</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" name="transfusi_darah" value="0" class="form-check-input"
                                id="transfusi-tidak"
                                {{ isset($triple->transfusi_darah) && $triple->transfusi_darah == 0 ? 'checked' : '' }}>
                            <label class="form-check-label" for="transfusi-tidak">Tidak</label>
                        </div>
                    </div>
                    <div id="detail-transfusi"
                        style="{{ isset($triple->transfusi_darah) && $triple->transfusi_darah == 1 ? '' : 'display: none;' }}">
                        <label for="kapanTransfusi">Bila ya, kapan:</label>
                        <input type="date" id="kapanTransfusi" name="kapan_transfusi" class="form-control"
                            placeholder="Kapan"
                            value="{{ isset($triple->kapan_transfusi) ? \Carbon\Carbon::parse($triple->kapan_transfusi)->format('Y-m-d') : old('kapan_transfusi') }}">
                    </div>
                </div>
                <div class="form-group">
                    <label>4. Apakah pernah menjalani hemodialisa/cuci darah?</label>
                    <div class="d-flex align-items-center mb-2">
                        <div class="form-check mr-3">
                            <input type="radio" name="hemodialisa" value="1" class="form-check-input"
                                id="hemodialisa-ya"
                                {{ isset($triple->hemodialisa) && $triple->hemodialisa == 1 ? 'checked' : '' }}>
                            <label class="form-check-label" for="hemodialisa-ya">Ya</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" name="hemodialisa" value="0" class="form-check-input"
                                id="hemodialisa-tidak"
                                {{ isset($triple->hemodialisa) && $triple->hemodialisa == 0 ? 'checked' : '' }}>
                            <label class="form-check-label" for="hemodialisa-tidak">Tidak</label>
                        </div>
                    </div>
                    <div id="detail-hemodialisa"
                        style="{{ isset($triple->hemodialisa) && $triple->hemodialisa == 1 ? '' : 'display: none;' }}">
                        <label for="kapanHemodialisa">Bila ya, kapan:</label>
                        <input type="date" id="kapanHemodialisa" name="kapan_hemodialisa" class="form-control"
                            placeholder="Kapan"
                            value="{{ isset($triple->kapan_hemodialisa) ? \Carbon\Carbon::parse($triple->kapan_hemodialisa)->format('Y-m-d') : old('kapan_hemodialisa') }}">
                    </div>
                </div>

                <div class="form-group">
                    <label>5. Berapa banyak pasangan seksual sebelum perkawinan sekarang?</label>
                    <input type="number" name="jmlh_pasangan_seks" class="form-control"
                        value="{{ isset($triple->jmlh_pasangan_seks) ? $triple->jmlh_pasangan_seks : old('jmlh_pasangan_seks') }}"
                        placeholder="Masukkan jumlah pasangan seksual">
                </div>

                <div class="form-group">
                    <label>6. Apakah pernah menggunakan narkoba suntik?</label>
                    <div class="d-flex align-items-center mb-2">
                        <div class="form-check mr-3">
                            <input type="radio" name="narkoba" value="1" class="form-check-input"
                                id="narkoba-ya" {{ isset($triple->narkoba) && $triple->narkoba == 1 ? 'checked' : '' }}>
                            <label class="form-check-label" for="narkoba-ya">Ya</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" name="narkoba" value="0" class="form-check-input"
                                id="narkoba-tidak"
                                {{ isset($triple->narkoba) && $triple->narkoba == 0 ? 'checked' : '' }}>
                            <label class="form-check-label" for="narkoba-tidak">Tidak</label>
                        </div>
                    </div>
                    <div id="detail-narkoba"
                        style="{{ isset($triple->narkoba) && $triple->narkoba == 1 ? '' : 'display: none;' }}">
                        <label for="kapannarkoba">Bila ya, kapan:</label>
                        <input type="date" id="kapannarkoba" name="kapan_narkoba" class="form-control"
                            placeholder="Kapan"
                            value="{{ isset($triple->kapan_narkoba) ? \Carbon\Carbon::parse($triple->kapan_narkoba)->format('Y-m-d') : old('kapan_narkoba') }}">
                    </div>
                </div>
                <div class="form-group">
                    <label>7. Apakah pernah mendapat vaksinasi Hepatitis B?</label>
                    <div class="d-flex align-items-center mb-2">
                        <div class="form-check mr-3">
                            <input type="radio" name="vaksin" value="1" class="form-check-input" id="vaksin-ya"
                                {{ isset($triple->vaksin) && $triple->vaksin == 1 ? 'checked' : '' }}>
                            <label class="form-check-label" for="vaksin-ya">Ya</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" name="vaksin" value="0" class="form-check-input"
                                id="vaksin-tidak" {{ isset($triple->vaksin) && $triple->vaksin == 0 ? 'checked' : '' }}>
                            <label class="form-check-label" for="vaksin-tidak">Tidak</label>
                        </div>
                    </div>
                    <div id="detail-vaksin"
                        style="{{ isset($triple->vaksin) && $triple->vaksin == 1 ? '' : 'display: none;' }}">
                        <label for="kapanvaksin">Bila ya, kapan:</label>
                        <input type="date" id="kapanvaksin" name="kapan_vaksin" class="form-control"
                            placeholder="Kapan"
                            value="{{ isset($triple->kapan_vaksin) ? $triple->kapan_vaksin : old('kapan_vaksin') }}">
                    </div>
                </div>

                <div class="form-group" id="pertanyaan-8"
                    style="{{ isset($triple->vaksin) && $triple->vaksin == 1 ? '' : 'display: none;' }}">
                    <label>8. Bila sudah mendapat vaksinasi Hepatitis B, berapa kali?</label>
                    <div class="d-flex align-items-center mb-2">
                        <div class="form-check mr-3">
                            <input type="radio" name="jmlh_vaksin" value="1" class="form-check-input"
                                id="jmlh_vaksin-1x"
                                {{ isset($triple->jmlh_vaksin) && $triple->jmlh_vaksin == 1 ? 'checked' : '' }}>
                            <label class="form-check-label" for="jmlh_vaksin-1x">1x</label>
                        </div>
                        <div class="form-check mr-3">
                            <input type="radio" name="jmlh_vaksin" value="2" class="form-check-input"
                                id="jmlh_vaksin-2x"
                                {{ isset($triple->jmlh_vaksin) && $triple->jmlh_vaksin == 2 ? 'checked' : '' }}>
                            <label class="form-check-label" for="jmlh_vaksin-2x">2x</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" name="jmlh_vaksin" value="3" class="form-check-input"
                                id="jmlh_vaksin-3x"
                                {{ isset($triple->jmlh_vaksin) && $triple->jmlh_vaksin == 3 ? 'checked' : '' }}>
                            <label class="form-check-label" for="jmlh_vaksin-3x">3x</label>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label>9. Apakah anda tinggal serumah/pernah tinggal serumah dengan penderita hep B?</label>
                    <div class="d-flex align-items-center mb-2">
                        <div class="form-check mr-3">
                            <input type="radio" name="tinggal_serumah" value="1" class="form-check-input"
                                id="tinggal_serumah-ya"
                                {{ isset($triple->tinggal_serumah) && $triple->tinggal_serumah == 1 ? 'checked' : '' }}>
                            <label class="form-check-label" for="tinggal_serumah-ya">Ya</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" name="tinggal_serumah" value="0" class="form-check-input"
                                id="tinggal_serumah-tidak"
                                {{ isset($triple->tinggal_serumah) && $triple->tinggal_serumah == 0 ? 'checked' : '' }}>
                            <label class="form-check-label" for="tinggal_serumah-tidak">Tidak</label>
                        </div>
                    </div>
                    <div id="detail-tinggal_serumah"
                        style="{{ isset($triple->tinggal_serumah) && $triple->tinggal_serumah == 1 ? '' : 'display: none;' }}">
                        <label for="kapanTinggal">Bila ya, kapan:</label>
                        <input type="date" id="kapanTinggal" name="kapan_tinggal_serumah" class="form-control"
                            placeholder="Kapan"
                            value="{{ isset($triple->kapan_tinggal_serumah) ? \Carbon\Carbon::parse($triple->kapan_tinggal_serumah)->format('Y-m-d') : old('kapan_transfusi') }}">

                        <label for="hubungan">Apa hubungan anda dengan penderita hepatitis B tsb?</label>
                        <div class="d-flex align-items-center mb-2">
                            <div class="form-check mr-3">
                                <input type="radio" name="hubungan_hepatitis" value="1" class="form-check-input"
                                    id="hubungan-pasangan"
                                    {{ isset($triple->hubungan_hepatitis) && $triple->hubungan_hepatitis == 1 ? 'checked' : '' }}>
                                <label class="form-check-label" for="hubungan-pasangan">Pasangan</label>
                            </div>
                            <div class="form-check">
                                <input type="radio" name="hubungan_hepatitis" value="2" class="form-check-input"
                                    id="hubungan-lainnya"
                                    {{ isset($triple->hubungan_hepatitis) && $triple->hubungan_hepatitis == 2 ? 'checked' : '' }}>
                                <label class="form-check-label" for="hubungan-lainnya">Lainnya</label>
                            </div>
                        </div>
                        <input type="text" id="hubunganDetail" name="hubungan_detail" class="form-control"
                            placeholder="Jelaskan jika lainnya"
                            style="{{ isset($triple->hubungan_hepatitis) && $triple->hubungan_hepatitis == 2 ? '' : 'display: none;' }}"
                            value="{{ isset($triple->hubungan_detail) ? $triple->hubungan_detail : old('hubungan_detail') }}">
                    </div>
                </div>
                <div class="form-group">
                    <label>10. Apakah pernah test HIV sebelumnya?</label>
                    <div class="d-flex align-items-center mb-2">
                        <div class="form-check mr-3">
                            <input type="radio" name="test_hiv" value="1" class="form-check-input"
                                id="test_hiv-ya"
                                {{ isset($triple->test_hiv) && $triple->test_hiv == 1 ? 'checked' : '' }}>
                            <label class="form-check-label" for="test_hiv-ya">Ya</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" name="test_hiv" value="0" class="form-check-input"
                                id="test_hiv-tidak"
                                {{ isset($triple->test_hiv) && $triple->test_hiv == 0 ? 'checked' : '' }}>
                            <label class="form-check-label" for="test_hiv-tidak">Tidak</label>
                        </div>
                    </div>
                    <div id="detail-hiv"
                        style="{{ isset($triple->test_hiv) && $triple->test_hiv == 1 ? '' : 'display: none;' }}">
                        <label for="hasilHiv">a. Bila ya, bagaimana hasilnya?</label>
                        <div class="d-flex align-items-center mb-2">
                            <div class="form-check mr-3">
                                <input type="radio" name="hasil_hiv" value="1" class="form-check-input"
                                    id="hasil-reaktif"
                                    {{ isset($triple->hasil_hiv) && $triple->hasil_hiv == 1 ? 'checked' : '' }}>
                                <label class="form-check-label" for="hasil-reaktif">Reaktif</label>
                            </div>
                            <div class="form-check">
                                <input type="radio" name="hasil_hiv" value="2" class="form-check-input"
                                    id="hasil-nonreaktif"
                                    {{ isset($triple->hasil_hiv) && $triple->hasil_hiv == 2 ? 'checked' : '' }}>
                                <label class="form-check-label" for="hasil-nonreaktif">Non Reaktif</label>
                            </div>
                        </div>

                        <div id="reaktif-detail"
                            style="{{ isset($triple->hasil_hiv) && $triple->hasil_hiv == 1 ? '' : 'display: none;' }}">
                            <label for="cd4Check">b. Bila reaktif, apakah pernah pemeriksaan CD4?</label>
                            <div class="d-flex align-items-center mb-2">
                                <div class="form-check mr-3">
                                    <input type="radio" name="cd4_check" value="1" class="form-check-input"
                                        id="cd4-ya"
                                        {{ isset($triple->cd4_check) && $triple->cd4_check == 1 ? 'checked' : '' }}>
                                    <label class="form-check-label" for="cd4-ya">Ya</label>
                                </div>
                                <div class="form-check">
                                    <input type="radio" name="cd4_check" value="0" class="form-check-input"
                                        id="cd4-tidak"
                                        {{ isset($triple->cd4_check) && $triple->cd4_check == 0 ? 'checked' : '' }}>
                                    <label class="form-check-label" for="cd4-tidak">Tidak</label>
                                </div>
                            </div>
                            <div id="kapan-cd4"
                                style="{{ isset($triple->cd4_check) && $triple->cd4_check == 1 ? '' : 'display: none;' }}">
                                <label for="kapancd4">Bila ya, dimana:</label>
                                <input type="text" id="kapancd4" name="dimana_cd4" class="form-control"
                                    placeholder="Dimana"
                                    value="{{ isset($triple->dimana_cd4) ? $triple->dimana_cd4 : old('dimana_cd4') }}">
                            </div>
                            <div id="cd4-detail"
                                style="{{ isset($triple->cd4_check) && $triple->cd4_check == 1 ? '' : 'display: none;' }}">
                                <label>c. Bila ya, bagaimana hasilnya?</label>
                                <div class="d-flex align-items-center mb-2">
                                    <div class="form-check mr-3">
                                        <input type="radio" name="hasil_cd4" value="1" class="form-check-input"
                                            id="cd4-low"
                                            {{ isset($triple->hasil_cd4) && $triple->hasil_cd4 == 1 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="cd4-low">≤ 350 sel/ml</label>
                                    </div>
                                    <div class="form-check">
                                        <input type="radio" name="hasil_cd4" value="2" class="form-check-input"
                                            id="cd4-high"
                                            {{ isset($triple->hasil_cd4) && $triple->hasil_cd4 == 2 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="cd4-high">> 350 sel/ml</label>
                                    </div>
                                </div>
                            </div>

                            <label for="arvCheck">d. Apakah sudah mendapat ARV?</label>
                            <div class="d-flex align-items-center mb-2">
                                <div class="form-check mr-3">
                                    <input type="radio" name="arv_check" value="1" class="form-check-input"
                                        id="arv-ya"
                                        {{ isset($triple->arv_check) && $triple->arv_check == 1 ? 'checked' : '' }}>
                                    <label class="form-check-label" for="arv-ya">Ya</label>
                                </div>
                                <div class="form-check">
                                    <input type="radio" name="arv_check" value="0" class="form-check-input"
                                        id="arv-tidak"
                                        {{ isset($triple->arv_check) && $triple->arv_check == 0 ? 'checked' : '' }}>
                                    <label class="form-check-label" for="arv-tidak">Tidak</label>
                                </div>
                            </div>
                            <div id="detail-arv"
                                style="{{ isset($triple->arv_check) && $triple->arv_check == 1 ? '' : 'display: none;' }}">
                                <label for="kapanarv">Bila ya, kapan:</label>
                                <input type="date" id="kapanArv" name="kapan_arv" class="form-control"
                                    value="{{ isset($triple->kapan_arv) ? \Carbon\Carbon::parse($triple->kapan_arv)->format('Y-m-d') : old('kapan_arv') }}">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label>11. Apakah anda pernah menderita gejala PMS dalam 1 bulan terakhir?</label>
                    <div class="d-flex align-items-center mb-2">
                        <div class="form-check mr-3">
                            <input type="radio" name="gejala_pms" value="1" class="form-check-input"
                                id="pms-ya"
                                {{ isset($triple->gejala_pms) && $triple->gejala_pms == 1 ? 'checked' : '' }}>
                            <label class="form-check-label" for="pms-ya">Ya</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" name="gejala_pms" value="0" class="form-check-input"
                                id="pms-tidak"
                                {{ isset($triple->gejala_pms) && $triple->gejala_pms == 0 ? 'checked' : '' }}>
                            <label class="form-check-label" for="pms-tidak">Tidak</label>
                        </div>
                    </div>
                    <div id="detail-pms"
                        style="{{ isset($triple->gejala_pms) && $triple->gejala_pms == 1 ? '' : 'display: none;' }}">
                        <label for="kapanpms">Bila ya, kapan:</label>
                        <input type="date" id="kapan-pms" name="kapan_pms" class="form-control"
                            value="{{ isset($triple->kapan_pms) ? \Carbon\Carbon::parse($triple->kapan_pms)->format('Y-m-d') : old('kapan_pms') }}">
                    </div>

                </div>

            </div>
            <div class="form-group">
                <div class="col-md-12">
                    <label for="kesimpulan" style="color: rgb(19, 11, 241);">Kesimpulan</label>
                    <textarea class="form-control" id="kesimpulan" name="kesimpulan" placeholder="Kesimpulan">{{ old('kesimpulan', $triple->kesimpulan ?? '') }}</textarea>
                </div>
            </div>
            <div class="text-right mt-4">
                {{-- @if (isset($triple))
                    <a href="{{ route('triple.eliminasi.admin') }}" type="button" class="btn btn-secondary mr-2"
                        style="font-size: 20px">Kembali</a>
                @else
                    <a href="{{ route('skrining.ilp') }}" type="button" class="btn btn-secondary mr-2"
                        style="font-size: 20px">Kembali</a>
                @endif --}}

                <button type="submit" class="btn btn-primary" style="font-size: 20px">Kirim</button>
            </div>
    </form>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Function untuk menampilkan atau menyembunyikan elemen berdasarkan nilai radio
            function handleDisplay(radioGroupName, targetId, showValue, additionalActions = null) {
                const radios = document.getElementsByName(radioGroupName);
                const target = document.getElementById(targetId);

                radios.forEach(radio => {
                    if (radio.checked) {
                        target.style.display = radio.value === showValue ? 'block' : 'none';
                        if (additionalActions) additionalActions(radio);
                    }

                    radio.addEventListener('change', function() {
                        target.style.display = this.value === showValue ? 'block' : 'none';
                        if (additionalActions) additionalActions(this);
                    });
                });
            }

            // Handling untuk setiap pertanyaan
            handleDisplay('gejala_hepatitis', 'detail-gejala', '1', () => {
                document.getElementById('pertanyaan-2').style.display = 'block';
            });

            handleDisplay('test_hepatitis', 'detail-test', '1');
            handleDisplay('transfusi_darah', 'detail-transfusi', '1');
            handleDisplay('hemodialisa', 'detail-hemodialisa', '1');
            handleDisplay('narkoba', 'detail-narkoba', '1');

            handleDisplay('vaksin', 'detail-vaksin', '1', (radio) => {
                document.getElementById('pertanyaan-8').style.display = 'block';
                document.getElementById('pertanyaan-9').style.display = 'block';
                if (radio.value === '0') {
                    document.getElementById('pertanyaan-8').style.display = 'none';
                }
            });

            handleDisplay('tinggal_serumah', 'detail-tinggal_serumah', '1', () => {
                document.getElementById('pertanyaan-10').style.display = 'block';
            });

            handleDisplay('hubungan_hepatitis', 'hubunganDetail', '2');

            handleDisplay('test_hiv', 'detail-hiv', '1', (radio) => {
                if (radio.value === '0') {
                    document.getElementById('reaktif-detail').style.display = 'none';
                    document.getElementById('cd4-detail').style.display = 'none';
                }
            });

            handleDisplay('hasil_hiv', 'reaktif-detail', '1');
            handleDisplay('cd4_check', 'cd4-detail', '1', (radio) => {
                document.getElementById('kapan-cd4').style.display = radio.value === '1' ? 'block' : 'none';
            });

            handleDisplay('arv_check', 'detail-arv', '1');
            handleDisplay('gejala_pms', 'detail-pms', '1', (radio) => {
                document.getElementById('kapan-pms').style.display = radio.value === '1' ? 'block' : 'none';
            });
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


        });
    </script>
@endsection
