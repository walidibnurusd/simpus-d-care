@extends('layouts.skrining.master')
@section('title', 'Skrining NAPZA')
<style>
    .red-text {
        color: red;
    }
</style>
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

    <form action="{{ isset($napza) ? route('napza.mtbs.update', $napza->id) : route('napza.mtbs.store') }}" method="POST">
        @csrf
        @if (isset($napza))
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
                                    {{ old('pasien', $napza->pasien ?? '') == $item->id ? 'selected' : '' }}>
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
                        <label>Nama Dokter</label>
                        <input type="text" class="form-control" name="nama_dokter" placeholder="Masukkan nama dokter"
                            value="{{ old('nama_dokter', $napza->nama_dokter ?? '') }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Klinik</label>
                        <input type="text" class="form-control" name="klinik" placeholder="Masukkan nama klinik"
                            value="{{ old('klinik', $napza->klinik ?? '') }}">
                    </div>
                </div>
            </div>

            <div class="form-section mt-4">

                <h3>Pendahuluan</h3>

                <p>Pertanyaan-pertanyaan berikut ini menanyakan tentang pengalaman Anda
                    menggunakan alkohol, produk tembakau, dan zat adiktif lainnya seumur hidup Anda dan
                    dalam tiga bulan terakhir. Zat-zat ini dapat dirokok, ditelan, dihisap, dihirup, atau disuntik
                    (tunjukkan kartu respons).</p>
                <p>Beberapa zat dalam daftar adalah resep dokter (seperti amfetamin, sedatif, obat anti
                    nyeri). Untuk wawancara ini, kami tidak akan mencatat obat-obat yang Anda gunakan seperti
                    yang ditentukan oleh dokter Anda. Meskipun demikian, bila Anda menggunakan obat-obat
                    tersebut untuk alasan-alasan selain dari ketentuan, atau menggunakannya lebih sering, atau
                    pada dosis yang lebih tinggi daripada yang ditentukan, atau dengan cara yang tidak
                    seharusnya, mohon beritahu saya.</p>
                <p>Walaupun kami juga tertarik untuk mengetahui tentang penggunaan obat-obat illegal Anda,
                    yakinlah bahwa informasi penggunaan tersebut akan diperlakukan sangat rahasia.</p>
            </div>
            <div class="form-section mt-4">

                <h3>1. Dalam kehidupan anda, zat apa dibawah ini yang
                    pernah digunakan? (di luar penggunaan dengan
                    alasan medis)</h3>
                <div class="form-group">
                    <div class="row">
                        <!-- Pertanyaan Tembakau -->
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>a. Tembakau (rokok, cerutu, kretek, dll.)</label>
                                <div class="d-flex">
                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input" name="pertanyaan1[tembakau]"
                                            value="pernah"
                                            {{ isset($napza->pertanyaan1['tembakau']) && $napza->pertanyaan1['tembakau'] == 'pernah' ? 'checked' : '' }}>
                                        <label class="form-check-label">Pernah</label>
                                    </div>
                                    <div class="form-check ml-3">
                                        <input type="radio" class="form-check-input" name="pertanyaan1[tembakau]"
                                            value="tidak_pernah"
                                            {{ isset($napza->pertanyaan1['tembakau']) && $napza->pertanyaan1['tembakau'] == 'tidak_pernah' ? 'checked' : '' }}>
                                        <label class="form-check-label">Tidak pernah</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Pertanyaan Minuman Alkohol -->
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>b. Minuman beralkohol (bir, anggur, sopi, tomi dll.)</label>
                                <div class="d-flex">
                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input" name="pertanyaan1[alkohol]"
                                            value="pernah"
                                            {{ isset($napza->pertanyaan1['alkohol']) && $napza->pertanyaan1['alkohol'] == 'pernah' ? 'checked' : '' }}>
                                        <label class="form-check-label">Pernah</label>
                                    </div>
                                    <div class="form-check ml-3">
                                        <input type="radio" class="form-check-input" name="pertanyaan1[alkohol]"
                                            value="tidak_pernah"
                                            {{ isset($napza->pertanyaan1['alkohol']) && $napza->pertanyaan1['alkohol'] == 'tidak_pernah' ? 'checked' : '' }}>
                                        <label class="form-check-label">Tidak pernah</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>c. Kanabis (marijuana, ganja, gelek, cimengpot, dll.)</label>
                                <div class="d-flex">
                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input" name="pertanyaan1[kanabis]"
                                            value="pernah"
                                            {{ isset($napza->pertanyaan1['kanabis']) && $napza->pertanyaan1['kanabis'] == 'pernah' ? 'checked' : '' }}>
                                        <label class="form-check-label">Pernah</label>
                                    </div>
                                    <div class="form-check ml-3">
                                        <input type="radio" class="form-check-input" name="pertanyaan1[kanabis]"
                                            value="tidak_pernah"
                                            {{ isset($napza->pertanyaan1['kanabis']) && $napza->pertanyaan1['kanabis'] == 'tidak_pernah' ? 'checked' : '' }}>
                                        <label class="form-check-label">Tidak pernah</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>d. Kokain (coke, crack, etc.)</label>
                                <div class="d-flex">
                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input" name="pertanyaan1[kokain]"
                                            value="pernah"
                                            {{ isset($napza->pertanyaan1['kokain']) && $napza->pertanyaan1['kokain'] == 'pernah' ? 'checked' : '' }}>
                                        <label class="form-check-label">Pernah</label>
                                    </div>
                                    <div class="form-check ml-3">
                                        <input type="radio" class="form-check-input" name="pertanyaan1[kokain]"
                                            value="tidak_pernah"
                                            {{ isset($napza->pertanyaan1['kokain']) && $napza->pertanyaan1['kokain'] == 'tidak_pernah' ? 'checked' : '' }}>
                                        <label class="form-check-label">Tidak pernah</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>e. Stimulan jenis amfetamin (ekstasi, shabu, dll)</label>
                                <div class="d-flex">
                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input" name="pertanyaan1[stimulan]"
                                            value="pernah"
                                            {{ isset($napza->pertanyaan1['stimulan']) && $napza->pertanyaan1['stimulan'] == 'pernah' ? 'checked' : '' }}>
                                        <label class="form-check-label">Pernah</label>
                                    </div>
                                    <div class="form-check ml-3">
                                        <input type="radio" class="form-check-input" name="pertanyaan1[stimulan]"
                                            value="tidak_pernah"
                                            {{ isset($napza->pertanyaan1['stimulan']) && $napza->pertanyaan1['stimulan'] == 'tidak_pernah' ? 'checked' : '' }}>
                                        <label class="form-check-label">Tidak pernah</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>f. Inhalansia (lem, bensin, tiner, dll)</label>
                                <div class="d-flex">
                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input" name="pertanyaan1[inhalansia]"
                                            value="pernah"
                                            {{ isset($napza->pertanyaan1['inhalansia']) && $napza->pertanyaan1['inhalansia'] == 'pernah' ? 'checked' : '' }}>
                                        <label class="form-check-label">Pernah</label>
                                    </div>
                                    <div class="form-check ml-3">
                                        <input type="radio" class="form-check-input" name="pertanyaan1[inhalansia]"
                                            value="tidak_pernah"
                                            {{ isset($napza->pertanyaan1['inhalansia']) && $napza->pertanyaan1['inhalansia'] == 'tidak_pernah' ? 'checked' : '' }}>
                                        <label class="form-check-label">Tidak pernah</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>g. Sedativa atau obat tidur (Benzodiazepin, Lexotan, Rohypnol, Mogadon, dll.)</label>
                                <div class="d-flex">
                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input" name="pertanyaan1[sedativa]"
                                            value="pernah"
                                            {{ isset($napza->pertanyaan1['sedativa']) && $napza->pertanyaan1['sedativa'] == 'pernah' ? 'checked' : '' }}>
                                        <label class="form-check-label">Pernah</label>
                                    </div>
                                    <div class="form-check ml-3">
                                        <input type="radio" class="form-check-input" name="pertanyaan1[sedativa]"
                                            value="tidak_pernah"
                                            {{ isset($napza->pertanyaan1['sedativa']) && $napza->pertanyaan1['sedativa'] == 'tidak_pernah' ? 'checked' : '' }}>
                                        <label class="form-check-label">Tidak pernah</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>h. Halusinogens (LSD, mushrooms, PCP, dll)</label>
                                <div class="d-flex">
                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input" name="pertanyaan1[halusinogens]"
                                            value="pernah"
                                            {{ isset($napza->pertanyaan1['halusinogens']) && $napza->pertanyaan1['halusinogens'] == 'pernah' ? 'checked' : '' }}>
                                        <label class="form-check-label">Pernah</label>
                                    </div>
                                    <div class="form-check ml-3">
                                        <input type="radio" class="form-check-input" name="pertanyaan1[halusinogens]"
                                            value="tidak_pernah"
                                            {{ isset($napza->pertanyaan1['halusinogens']) && $napza->pertanyaan1['halusinogens'] == 'tidak_pernah' ? 'checked' : '' }}>
                                        <label class="form-check-label">Tidak pernah</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>i. Opioid (heroin, morfin, metadon, kodein, dll)</label>
                                <div class="d-flex">
                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input" name="pertanyaan1[opioid]"
                                            value="pernah"
                                            {{ isset($napza->pertanyaan1['opioid']) && $napza->pertanyaan1['opioid'] == 'pernah' ? 'checked' : '' }}>
                                        <label class="form-check-label">Pernah</label>
                                    </div>
                                    <div class="form-check ml-3">
                                        <input type="radio" class="form-check-input" name="pertanyaan1[opioid]"
                                            value="tidak_pernah"
                                            {{ isset($napza->pertanyaan1['opioid']) && $napza->pertanyaan1['opioid'] == 'tidak_pernah' ? 'checked' : '' }}>
                                        <label class="form-check-label">Tidak pernah</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <div class="d-flex align-items-center">
                                    <label>j. Zat-lain: jelaskan</label>
                                    <input type="text" class="form-control ml-2" name="nama_zat_lain"
                                        value="{{ old('nama_zat_lain', $napza->nama_zat_lain ?? '') }}"
                                        style="width: auto;">
                                </div>
                                <div class="d-flex">
                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input" name="pertanyaan1[zatlain]"
                                            value="pernah"
                                            {{ isset($napza->pertanyaan1['zatlain']) && $napza->pertanyaan1['zatlain'] == 'pernah' ? 'checked' : '' }}>
                                        <label class="form-check-label">Pernah</label>
                                    </div>
                                    <div class="form-check ml-3">
                                        <input type="radio" class="form-check-input" name="pertanyaan1[zatlain]"
                                            value="tidak_pernah"
                                            {{ isset($napza->pertanyaan1['zatlain']) && $napza->pertanyaan1['zatlain'] == 'tidak_pernah' ? 'checked' : '' }}>
                                        <label class="form-check-label">Tidak pernah</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
                <h5 class="red-text"><strong>Gali bila semua jawaban tidak pernah: “tidak pernah juga menggunakan ketika
                        Anda di sekolah?”
                        Bila “tidak pernah” untuk semua butir, hentikan wawancara.
                        Bila “pernah” untuk butir yang manapun, tanyakan Pertanyaan 2 untuk tiap zat yang pernah
                        digunakan</strong></h5>
                <br>

                <h3>2. Dalam tiga bulan terakhir, seberapa
                    sering anda pernah menggunakan
                    zat seperti yang anda sebut
                    (ZAT PERTAMA, ZAT KEDUA, DST)?</h3>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>a. Tembakau (rokok, cerutu, kretek, dll.)</label>
                                <div class="d-flex">
                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan2[freq_tembakau_P2]" value="2"
                                            {{ isset($napza->pertanyaan2['freq_tembakau_P2']) && $napza->pertanyaan2['freq_tembakau_P2'] == '2' ? 'checked' : '' }}>
                                        <label class="form-check-label">Sekali atau dua kali</label>
                                    </div>
                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan2[freq_tembakau_P2]" value="3"
                                            {{ isset($napza->pertanyaan2['freq_tembakau_P2']) && $napza->pertanyaan2['freq_tembakau_P2'] == '3' ? 'checked' : '' }}>
                                        <label class="form-check-label">Tiap bulan</label>
                                    </div>
                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan2[freq_tembakau_P2]" value="4"
                                            {{ isset($napza->pertanyaan2['freq_tembakau_P2']) && $napza->pertanyaan2['freq_tembakau_P2'] == '4' ? 'checked' : '' }}>
                                        <label class="form-check-label">Tiap minggu</label>
                                    </div>
                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan2[freq_tembakau_P2]" value="6"
                                            {{ isset($napza->pertanyaan2['freq_tembakau_P2']) && $napza->pertanyaan2['freq_tembakau_P2'] == '6' ? 'checked' : '' }}>
                                        <label class="form-check-label">Selalu atau hampir selalu</label>
                                    </div>
                                    <div class="form-check ml-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan2[freq_tembakau_P2]" value="0"
                                            {{ isset($napza->pertanyaan2['freq_tembakau_P2']) && $napza->pertanyaan2['freq_tembakau_P2'] == '0' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="tidak">Tidak pernah</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label>b. Minuman beralkohol (bir, anggur, sopi, tomi dll.)</label>
                                <div class="d-flex">
                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan2[freq_alkohol_P2]" value="2"
                                            {{ isset($napza->pertanyaan2['freq_alkohol_P2']) && $napza->pertanyaan2['freq_alkohol_P2'] == '2' ? 'checked' : '' }}>
                                        <label class="form-check-label">Sekali atau dua kali</label>
                                    </div>
                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan2[freq_alkohol_P2]" value="3"
                                            {{ isset($napza->pertanyaan2['freq_alkohol_P2']) && $napza->pertanyaan2['freq_alkohol_P2'] == '3' ? 'checked' : '' }}>
                                        <label class="form-check-label">Tiap bulan</label>
                                    </div>
                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan2[freq_alkohol_P2]" value="4"
                                            {{ isset($napza->pertanyaan2['freq_alkohol_P2']) && $napza->pertanyaan2['freq_alkohol_P2'] == '4' ? 'checked' : '' }}>
                                        <label class="form-check-label">Tiap minggu</label>
                                    </div>
                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan2[freq_alkohol_P2]" value="6"
                                            {{ isset($napza->pertanyaan2['freq_alkohol_P2']) && $napza->pertanyaan2['freq_alkohol_P2'] == '6' ? 'checked' : '' }}>
                                        <label class="form-check-label">Selalu atau hampir selalu</label>
                                    </div>
                                    <div class="form-check ml-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan2[freq_alkohol_P2]" value="0"
                                            {{ isset($napza->pertanyaan2['freq_alkohol_P2']) && $napza->pertanyaan2['freq_alkohol_P2'] == '0' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="tidak">Tidak pernah</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label>c. Kanabis (marijuana, ganja, gelek, cimengpot, dll.)</label>
                                <div class="d-flex">
                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan2[freq_kanabis_P2]" value="2"
                                            {{ isset($napza->pertanyaan2['freq_kanabis_P2']) && $napza->pertanyaan2['freq_kanabis_P2'] == '2' ? 'checked' : '' }}>
                                        <label class="form-check-label">Sekali atau dua kali</label>
                                    </div>
                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan2[freq_kanabis_P2]" value="3"
                                            {{ isset($napza->pertanyaan2['freq_kanabis_P2']) && $napza->pertanyaan2['freq_kanabis_P2'] == '3' ? 'checked' : '' }}>
                                        <label class="form-check-label">Tiap bulan</label>
                                    </div>
                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan2[freq_kanabis_P2]" value="4"
                                            {{ isset($napza->pertanyaan2['freq_kanabis_P2']) && $napza->pertanyaan2['freq_kanabis_P2'] == '4' ? 'checked' : '' }}>
                                        <label class="form-check-label">Tiap minggu</label>
                                    </div>
                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan2[freq_kanabis_P2]" value="6"
                                            {{ isset($napza->pertanyaan2['freq_kanabis_P2']) && $napza->pertanyaan2['freq_kanabis_P2'] == '6' ? 'checked' : '' }}>
                                        <label class="form-check-label">Selalu atau hampir selalu</label>
                                    </div>
                                    <div class="form-check ml-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan2[freq_kanabis_P2]" value="0"
                                            {{ isset($napza->pertanyaan2['freq_kanabis_P2']) && $napza->pertanyaan2['freq_kanabis_P2'] == '0' ? 'checked' : '' }}>
                                        <label class="form-check-label">Tidak pernah</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label>d. Kokain (coke, crack, etc.)</label>
                                <div class="d-flex">
                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input" name="pertanyaan2[freq_kokain_P2]"
                                            value="2"
                                            {{ isset($napza->pertanyaan2['freq_kokain_P2']) && $napza->pertanyaan2['freq_kokain_P2'] == '2' ? 'checked' : '' }}>
                                        <label class="form-check-label">Sekali atau dua kali</label>
                                    </div>
                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input" name="pertanyaan2[freq_kokain_P2]"
                                            value="3"
                                            {{ isset($napza->pertanyaan2['freq_kokain_P2']) && $napza->pertanyaan2['freq_kokain_P2'] == '3' ? 'checked' : '' }}>
                                        <label class="form-check-label">Tiap bulan</label>
                                    </div>
                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input" name="pertanyaan2[freq_kokain_P2]"
                                            value="4"
                                            {{ isset($napza->pertanyaan2['freq_kokain_P2']) && $napza->pertanyaan2['freq_kokain_P2'] == '4' ? 'checked' : '' }}>
                                        <label class="form-check-label">Tiap minggu</label>
                                    </div>
                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input" name="pertanyaan2[freq_kokain_P2]"
                                            value="6"
                                            {{ isset($napza->pertanyaan2['freq_kokain_P2']) && $napza->pertanyaan2['freq_kokain_P2'] == '6' ? 'checked' : '' }}>
                                        <label class="form-check-label">Selalu atau hampir selalu</label>
                                    </div>
                                    <div class="form-check ml-3">
                                        <input type="radio" class="form-check-input" name="pertanyaan2[freq_kokain_P2]"
                                            value="0"
                                            {{ isset($napza->pertanyaan2['freq_kokain_P2']) && $napza->pertanyaan2['freq_kokain_P2'] == '0' ? 'checked' : '' }}>
                                        <label class="form-check-label">Tidak pernah</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label>e. Stimulan jenis amfetamin (ekstasi, shabu, dll)</label>
                                <div class="d-flex">
                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan2[freq_stimulan_P2]" value="2"
                                            {{ isset($napza->pertanyaan2['freq_stimulan_P2']) && $napza->pertanyaan2['freq_stimulan_P2'] == '2' ? 'checked' : '' }}>
                                        <label class="form-check-label">Sekali atau dua kali</label>
                                    </div>
                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan2[freq_stimulan_P2]" value="3"
                                            {{ isset($napza->pertanyaan2['freq_stimulan_P2']) && $napza->pertanyaan2['freq_stimulan_P2'] == '3' ? 'checked' : '' }}>
                                        <label class="form-check-label">Tiap bulan</label>
                                    </div>
                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan2[freq_stimulan_P2]" value="4"
                                            {{ isset($napza->pertanyaan2['freq_stimulan_P2']) && $napza->pertanyaan2['freq_stimulan_P2'] == '4' ? 'checked' : '' }}>
                                        <label class="form-check-label">Tiap minggu</label>
                                    </div>
                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan2[freq_stimulan_P2]" value="6"
                                            {{ isset($napza->pertanyaan2['freq_stimulan_P2']) && $napza->pertanyaan2['freq_stimulan_P2'] == '6' ? 'checked' : '' }}>
                                        <label class="form-check-label">Selalu atau hampir selalu</label>
                                    </div>
                                    <div class="form-check ml-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan2[freq_stimulan_P2]" value="0"
                                            {{ isset($napza->pertanyaan2['freq_stimulan_P2']) && $napza->pertanyaan2['freq_stimulan_P2'] == '0' ? 'checked' : '' }}>
                                        <label class="form-check-label">Tidak pernah</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label>f. Inhalansia (lem, bensin, tiner, dll)</label>
                                <div class="d-flex">
                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan2[freq_inhalansia_P2]" value="2"
                                            {{ isset($napza->pertanyaan2['freq_inhalansia_P2']) && $napza->pertanyaan2['freq_inhalansia_P2'] == '2' ? 'checked' : '' }}>
                                        <label class="form-check-label">Sekali atau dua kali</label>
                                    </div>
                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan2[freq_inhalansia_P2]" value="3"
                                            {{ isset($napza->pertanyaan2['freq_inhalansia_P2']) && $napza->pertanyaan2['freq_inhalansia_P2'] == '3' ? 'checked' : '' }}>
                                        <label class="form-check-label">Tiap bulan</label>
                                    </div>
                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan2[freq_inhalansia_P2]" value="4"
                                            {{ isset($napza->pertanyaan2['freq_inhalansia_P2']) && $napza->pertanyaan2['freq_inhalansia_P2'] == '4' ? 'checked' : '' }}>
                                        <label class="form-check-label">Tiap minggu</label>
                                    </div>
                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan2[freq_inhalansia_P2]" value="6"
                                            {{ isset($napza->pertanyaan2['freq_inhalansia_P2']) && $napza->pertanyaan2['freq_inhalansia_P2'] == '6' ? 'checked' : '' }}>
                                        <label class="form-check-label">Selalu atau hampir selalu</label>
                                    </div>
                                    <div class="form-check ml-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan2[freq_inhalansia_P2]" value="0"
                                            {{ isset($napza->pertanyaan2['freq_inhalansia_P2']) && $napza->pertanyaan2['freq_inhalansia_P2'] == '0' ? 'checked' : '' }}>
                                        <label class="form-check-label">Tidak pernah</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label>g. Sedativa atau obat tidur (Benzodiazepin, Lexotan, Rohypnol, Mogadon, dll.)</label>
                                <div class="d-flex">
                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan2[freq_sedativa_P2]" value="2"
                                            {{ isset($napza->pertanyaan2['freq_sedativa_P2']) && $napza->pertanyaan2['freq_sedativa_P2'] == '2' ? 'checked' : '' }}>
                                        <label class="form-check-label">Sekali atau dua kali</label>
                                    </div>
                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan2[freq_sedativa_P2]" value="3"
                                            {{ isset($napza->pertanyaan2['freq_sedativa_P2']) && $napza->pertanyaan2['freq_sedativa_P2'] == '3' ? 'checked' : '' }}>
                                        <label class="form-check-label">Tiap bulan</label>
                                    </div>
                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan2[freq_sedativa_P2]" value="4"
                                            {{ isset($napza->pertanyaan2['freq_sedativa_P2']) && $napza->pertanyaan2['freq_sedativa_P2'] == '4' ? 'checked' : '' }}>
                                        <label class="form-check-label">Tiap minggu</label>
                                    </div>
                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan2[freq_sedativa_P2]" value="6"
                                            {{ isset($napza->pertanyaan2['freq_sedativa_P2']) && $napza->pertanyaan2['freq_sedativa_P2'] == '6' ? 'checked' : '' }}>
                                        <label class="form-check-label">Selalu atau hampir selalu</label>
                                    </div>
                                    <div class="form-check ml-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan2[freq_sedativa_P2]" value="0"
                                            {{ isset($napza->pertanyaan2['freq_sedativa_P2']) && $napza->pertanyaan2['freq_sedativa_P2'] == '0' ? 'checked' : '' }}>
                                        <label class="form-check-label">Tidak pernah</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label>h. Halusinogens (LSD, mushrooms, PCP, dll)</label>
                                <div class="d-flex">
                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan2[freq_halusinogen_P2]" value="2"
                                            {{ isset($napza->pertanyaan2['freq_halusinogen_P2']) && $napza->pertanyaan2['freq_halusinogen_P2'] == '2' ? 'checked' : '' }}>
                                        <label class="form-check-label">Sekali atau dua kali</label>
                                    </div>
                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan2[freq_halusinogen_P2]" value="3"
                                            {{ isset($napza->pertanyaan2['freq_halusinogen_P2']) && $napza->pertanyaan2['freq_halusinogen_P2'] == '3' ? 'checked' : '' }}>
                                        <label class="form-check-label">Tiap bulan</label>
                                    </div>
                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan2[freq_halusinogen_P2]" value="4"
                                            {{ isset($napza->pertanyaan2['freq_halusinogen_P2']) && $napza->pertanyaan2['freq_halusinogen_P2'] == '4' ? 'checked' : '' }}>
                                        <label class="form-check-label">Tiap minggu</label>
                                    </div>
                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan2[freq_halusinogen_P2]" value="6"
                                            {{ isset($napza->pertanyaan2['freq_halusinogen_P2']) && $napza->pertanyaan2['freq_halusinogen_P2'] == '6' ? 'checked' : '' }}>
                                        <label class="form-check-label">Selalu atau hampir selalu</label>
                                    </div>
                                    <div class="form-check ml-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan2[freq_halusinogen_P2]" value="0"
                                            {{ isset($napza->pertanyaan2['freq_halusinogen_P2']) && $napza->pertanyaan2['freq_halusinogen_P2'] == '0' ? 'checked' : '' }}>
                                        <label class="form-check-label">Tidak pernah</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label>i. Opioid (heroin, morfin, metadon, kodein, dll)</label>
                                <div class="d-flex">
                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input" name="pertanyaan2[freq_opioid_P2]"
                                            value="2"
                                            {{ isset($napza->pertanyaan2['freq_opioid_P2']) && $napza->pertanyaan2['freq_opioid_P2'] == '2' ? 'checked' : '' }}>
                                        <label class="form-check-label">Sekali atau dua kali</label>
                                    </div>
                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input" name="pertanyaan2[freq_opioid_P2]"
                                            value="3"
                                            {{ isset($napza->pertanyaan2['freq_opioid_P2']) && $napza->pertanyaan2['freq_opioid_P2'] == '3' ? 'checked' : '' }}>
                                        <label class="form-check-label">Tiap bulan</label>
                                    </div>
                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input" name="pertanyaan2[freq_opioid_P2]"
                                            value="4"
                                            {{ isset($napza->pertanyaan2['freq_opioid_P2']) && $napza->pertanyaan2['freq_opioid_P2'] == '4' ? 'checked' : '' }}>
                                        <label class="form-check-label">Tiap minggu</label>
                                    </div>
                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input" name="pertanyaan2[freq_opioid_P2]"
                                            value="6"
                                            {{ isset($napza->pertanyaan2['freq_opioid_P2']) && $napza->pertanyaan2['freq_opioid_P2'] == '6' ? 'checked' : '' }}>
                                        <label class="form-check-label">Selalu atau hampir selalu</label>
                                    </div>
                                    <div class="form-check ml-3">
                                        <input type="radio" class="form-check-input" name="pertanyaan2[freq_opioid_P2]"
                                            value="0"
                                            {{ isset($napza->pertanyaan2['freq_opioid_P2']) && $napza->pertanyaan2['freq_opioid_P2'] == '0' ? 'checked' : '' }}>
                                        <label class="form-check-label">Tidak pernah</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="d-flex align-items-center">
                                    <label>j. Zat-lain: sebutkan</label>
                                    <input type="text" class="form-control ml-2" name="pertanyaan2[zatlain_name_P2]"
                                        style="width: auto;"
                                        value="{{ isset($napza->pertanyaan2['zatlain_name_P2']) ? $napza->pertanyaan2['zatlain_name_P2'] : '' }}">
                                </div>
                                <div class="d-flex mt-2">
                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan2[freq_zatlain_P2]" value="2"
                                            {{ isset($napza->pertanyaan2['freq_zatlain_P2']) && $napza->pertanyaan2['freq_zatlain_P2'] == '2' ? 'checked' : '' }}>
                                        <label class="form-check-label">Sekali atau dua kali</label>
                                    </div>
                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan2[freq_zatlain_P2]" value="3"
                                            {{ isset($napza->pertanyaan2['freq_zatlain_P2']) && $napza->pertanyaan2['freq_zatlain_P2'] == '3' ? 'checked' : '' }}>
                                        <label class="form-check-label">Tiap bulan</label>
                                    </div>
                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan2[freq_zatlain_P2]" value="4"
                                            {{ isset($napza->pertanyaan2['freq_zatlain_P2']) && $napza->pertanyaan2['freq_zatlain_P2'] == '4' ? 'checked' : '' }}>
                                        <label class="form-check-label">Tiap minggu</label>
                                    </div>
                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan2[freq_zatlain_P2]" value="6"
                                            {{ isset($napza->pertanyaan2['freq_zatlain_P2']) && $napza->pertanyaan2['freq_zatlain_P2'] == '6' ? 'checked' : '' }}>
                                        <label class="form-check-label">Selalu atau hampir selalu</label>
                                    </div>
                                    <div class="form-check ml-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan2[freq_zatlain_P2]" value="0"
                                            {{ isset($napza->pertanyaan2['freq_zatlain_P2']) && $napza->pertanyaan2['freq_zatlain_P2'] == '0' ? 'checked' : '' }}>
                                        <label class="form-check-label">Tidak pernah</label>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>
                    <h5 class="red-text"><strong>Bila “tidak pernah” untuk semua butir dalam pertanyaan 2, loncat ke
                            pertanyaan 6.
                            Bila zat/obat-obatan dalam pertanyaan 2 telah digunakan dalam tiga bulan terakhir,
                            lanjutkan ke pertanyaan 3,4,5 untuk tiap zat/obat-obatan yang digunakan.</strong></h5>
                    <br>
                </div>
                <h3>3. Selama tiga bulan terakhir, seberapa
                    sering anda mempunyai keinginan
                    yang kuat untuk menggunakan (ZAT
                    PERTAMA, ZAT KEDUA, DLL)?</h3>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>a. Tembakau (rokok, cerutu, kretek, dll.)</label>
                                <div class="d-flex">
                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan3[freq_ingin_tembakau]" value="3"
                                            {{ isset($napza->pertanyaan3['freq_ingin_tembakau']) && $napza->pertanyaan3['freq_ingin_tembakau'] == '3' ? 'checked' : '' }}>
                                        <label class="form-check-label">Sekali atau dua kali</label>
                                    </div>
                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan3[freq_ingin_tembakau]" value="4"
                                            {{ isset($napza->pertanyaan3['freq_ingin_tembakau']) && $napza->pertanyaan3['freq_ingin_tembakau'] == '4' ? 'checked' : '' }}>
                                        <label class="form-check-label">Tiap bulan</label>
                                    </div>
                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan3[freq_ingin_tembakau]" value="5"
                                            {{ isset($napza->pertanyaan3['freq_ingin_tembakau']) && $napza->pertanyaan3['freq_ingin_tembakau'] == '5' ? 'checked' : '' }}>
                                        <label class="form-check-label">Tiap minggu</label>
                                    </div>
                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan3[freq_ingin_tembakau]" value="6"
                                            {{ isset($napza->pertanyaan3['freq_ingin_tembakau']) && $napza->pertanyaan3['freq_ingin_tembakau'] == '6' ? 'checked' : '' }}>
                                        <label class="form-check-label">Selalu atau hampir selalu</label>
                                    </div>
                                    <div class="form-check ml-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan3[freq_ingin_tembakau]" value="0"
                                            {{ isset($napza->pertanyaan3['freq_ingin_tembakau']) && $napza->pertanyaan3['freq_ingin_tembakau'] == '0' ? 'checked' : '' }}>
                                        <label class="form-check-label">Tidak pernah</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label>b. Minuman beralkohol (bir, anggur, sopi, tomi dll.)</label>
                                <div class="d-flex">
                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan3[freq_ingin_alkohol]" value="3"
                                            {{ isset($napza->pertanyaan3['freq_ingin_alkohol']) && $napza->pertanyaan3['freq_ingin_alkohol'] == '3' ? 'checked' : '' }}>
                                        <label class="form-check-label">Sekali atau dua kali</label>
                                    </div>
                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan3[freq_ingin_alkohol]" value="4"
                                            {{ isset($napza->pertanyaan3['freq_ingin_alkohol']) && $napza->pertanyaan3['freq_ingin_alkohol'] == '4' ? 'checked' : '' }}>
                                        <label class="form-check-label">Tiap bulan</label>
                                    </div>
                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan3[freq_ingin_alkohol]" value="5"
                                            {{ isset($napza->pertanyaan3['freq_ingin_alkohol']) && $napza->pertanyaan3['freq_ingin_alkohol'] == '5' ? 'checked' : '' }}>
                                        <label class="form-check-label">Tiap minggu</label>
                                    </div>
                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan3[freq_ingin_alkohol]" value="6"
                                            {{ isset($napza->pertanyaan3['freq_ingin_alkohol']) && $napza->pertanyaan3['freq_ingin_alkohol'] == '6' ? 'checked' : '' }}>
                                        <label class="form-check-label">Selalu atau hampir selalu</label>
                                    </div>
                                    <div class="form-check ml-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan3[freq_ingin_alkohol]" value="0"
                                            {{ isset($napza->pertanyaan3['freq_ingin_alkohol']) && $napza->pertanyaan3['freq_ingin_alkohol'] == '0' ? 'checked' : '' }}>
                                        <label class="form-check-label">Tidak pernah</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label>c. Kanabis (marijuana, ganja, gelek, cimengpot, dll.)</label>
                                <div class="d-flex">
                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan3[freq_ingin_kanabis]" value="3"
                                            {{ isset($napza->pertanyaan3['freq_ingin_kanabis']) && $napza->pertanyaan3['freq_ingin_kanabis'] == '3' ? 'checked' : '' }}>
                                        <label class="form-check-label">Sekali atau dua kali</label>
                                    </div>
                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan3[freq_ingin_kanabis]" value="4"
                                            {{ isset($napza->pertanyaan3['freq_ingin_kanabis']) && $napza->pertanyaan3['freq_ingin_kanabis'] == '4' ? 'checked' : '' }}>
                                        <label class="form-check-label">Tiap bulan</label>
                                    </div>
                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan3[freq_ingin_kanabis]" value="5"
                                            {{ isset($napza->pertanyaan3['freq_ingin_kanabis']) && $napza->pertanyaan3['freq_ingin_kanabis'] == '5' ? 'checked' : '' }}>
                                        <label class="form-check-label">Tiap minggu</label>
                                    </div>
                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan3[freq_ingin_kanabis]" value="6"
                                            {{ isset($napza->pertanyaan3['freq_ingin_kanabis']) && $napza->pertanyaan3['freq_ingin_kanabis'] == '6' ? 'checked' : '' }}>
                                        <label class="form-check-label">Selalu atau hampir selalu</label>
                                    </div>
                                    <div class="form-check ml-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan3[freq_ingin_kanabis]" value="0"
                                            {{ isset($napza->pertanyaan3['freq_ingin_kanabis']) && $napza->pertanyaan3['freq_ingin_kanabis'] == '0' ? 'checked' : '' }}>
                                        <label class="form-check-label">Tidak pernah</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label>d. Kokain (coke, crack, etc.)</label>
                                <div class="d-flex">
                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan3[freq_ingin_kokain]" value="3"
                                            {{ isset($napza->pertanyaan3['freq_ingin_kokain']) && $napza->pertanyaan3['freq_ingin_kokain'] == '3' ? 'checked' : '' }}>
                                        <label class="form-check-label">Sekali atau dua kali</label>
                                    </div>
                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan3[freq_ingin_kokain]" value="4"
                                            {{ isset($napza->pertanyaan3['freq_ingin_kokain']) && $napza->pertanyaan3['freq_ingin_kokain'] == '4' ? 'checked' : '' }}>
                                        <label class="form-check-label">Tiap bulan</label>
                                    </div>
                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan3[freq_ingin_kokain]" value="5"
                                            {{ isset($napza->pertanyaan3['freq_ingin_kokain']) && $napza->pertanyaan3['freq_ingin_kokain'] == '5' ? 'checked' : '' }}>
                                        <label class="form-check-label">Tiap minggu</label>
                                    </div>
                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan3[freq_ingin_kokain]" value="6"
                                            {{ isset($napza->pertanyaan3['freq_ingin_kokain']) && $napza->pertanyaan3['freq_ingin_kokain'] == '6' ? 'checked' : '' }}>
                                        <label class="form-check-label">Selalu atau hampir selalu</label>
                                    </div>
                                    <div class="form-check ml-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan3[freq_ingin_kokain]" value="0"
                                            {{ isset($napza->pertanyaan3['freq_ingin_kokain']) && $napza->pertanyaan3['freq_ingin_kokain'] == '0' ? 'checked' : '' }}>
                                        <label class="form-check-label">Tidak pernah</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label>e. Stimulan jenis amfetamin (ekstasi, shabu, dll)</label>
                                <div class="d-flex">
                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan3[freq_ingin_stimulan]" value="3"
                                            {{ isset($napza->pertanyaan3['freq_ingin_stimulan']) && $napza->pertanyaan3['freq_ingin_stimulan'] == '3' ? 'checked' : '' }}>
                                        <label class="form-check-label">Sekali atau dua kali</label>
                                    </div>
                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan3[freq_ingin_stimulan]" value="4"
                                            {{ isset($napza->pertanyaan3['freq_ingin_stimulan']) && $napza->pertanyaan3['freq_ingin_stimulan'] == '4' ? 'checked' : '' }}>
                                        <label class="form-check-label">Tiap bulan</label>
                                    </div>
                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan3[freq_ingin_stimulan]" value="5"
                                            {{ isset($napza->pertanyaan3['freq_ingin_stimulan']) && $napza->pertanyaan3['freq_ingin_stimulan'] == '5' ? 'checked' : '' }}>
                                        <label class="form-check-label">Tiap minggu</label>
                                    </div>
                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan3[freq_ingin_stimulan]" value="6"
                                            {{ isset($napza->pertanyaan3['freq_ingin_stimulan']) && $napza->pertanyaan3['freq_ingin_stimulan'] == '6' ? 'checked' : '' }}>
                                        <label class="form-check-label">Selalu atau hampir selalu</label>
                                    </div>
                                    <div class="form-check ml-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan3[freq_ingin_stimulan]" value="0"
                                            {{ isset($napza->pertanyaan3['freq_ingin_stimulan']) && $napza->pertanyaan3['freq_ingin_stimulan'] == '0' ? 'checked' : '' }}>
                                        <label class="form-check-label">Tidak pernah</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label>f. Inhalansia (lem, bensin, tiner, dll)</label>
                                <div class="d-flex">
                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan3[freq_ingin_inhalansia]" value="3"
                                            {{ isset($napza->pertanyaan3['freq_ingin_inhalansia']) && $napza->pertanyaan3['freq_ingin_inhalansia'] == '3' ? 'checked' : '' }}>
                                        <label class="form-check-label">Sekali atau dua kali</label>
                                    </div>
                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan3[freq_ingin_inhalansia]" value="4"
                                            {{ isset($napza->pertanyaan3['freq_ingin_inhalansia']) && $napza->pertanyaan3['freq_ingin_inhalansia'] == '4' ? 'checked' : '' }}>
                                        <label class="form-check-label">Tiap bulan</label>
                                    </div>
                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan3[freq_ingin_inhalansia]" value="5"
                                            {{ isset($napza->pertanyaan3['freq_ingin_inhalansia']) && $napza->pertanyaan3['freq_ingin_inhalansia'] == '5' ? 'checked' : '' }}>
                                        <label class="form-check-label">Tiap minggu</label>
                                    </div>
                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan3[freq_ingin_inhalansia]" value="6"
                                            {{ isset($napza->pertanyaan3['freq_ingin_inhalansia']) && $napza->pertanyaan3['freq_ingin_inhalansia'] == '6' ? 'checked' : '' }}>
                                        <label class="form-check-label">Selalu atau hampir selalu</label>
                                    </div>
                                    <div class="form-check ml-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan3[freq_ingin_inhalansia]" value="0"
                                            {{ isset($napza->pertanyaan3['freq_ingin_inhalansia']) && $napza->pertanyaan3['freq_ingin_inhalansia'] == '0' ? 'checked' : '' }}>
                                        <label class="form-check-label">Tidak pernah</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label>g. Sedativa atau obat tidur (Benzodiazepin, Lexotan, Rohypnol, Mogadon, dll.)</label>
                                <div class="d-flex">
                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan3[freq_ingin_sedativa]" value="3"
                                            {{ isset($napza->pertanyaan3['freq_ingin_sedativa']) && $napza->pertanyaan3['freq_ingin_sedativa'] == '3' ? 'checked' : '' }}>
                                        <label class="form-check-label">Sekali atau dua kali</label>
                                    </div>
                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan3[freq_ingin_sedativa]" value="4"
                                            {{ isset($napza->pertanyaan3['freq_ingin_sedativa']) && $napza->pertanyaan3['freq_ingin_sedativa'] == '4' ? 'checked' : '' }}>
                                        <label class="form-check-label">Tiap bulan</label>
                                    </div>
                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan3[freq_ingin_sedativa]" value="5"
                                            {{ isset($napza->pertanyaan3['freq_ingin_sedativa']) && $napza->pertanyaan3['freq_ingin_sedativa'] == '5' ? 'checked' : '' }}>
                                        <label class="form-check-label">Tiap minggu</label>
                                    </div>
                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan3[freq_ingin_sedativa]" value="6"
                                            {{ isset($napza->pertanyaan3['freq_ingin_sedativa']) && $napza->pertanyaan3['freq_ingin_sedativa'] == '6' ? 'checked' : '' }}>
                                        <label class="form-check-label">Selalu atau hampir selalu</label>
                                    </div>
                                    <div class="form-check ml-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan3[freq_ingin_sedativa]" value="0"
                                            {{ isset($napza->pertanyaan3['freq_ingin_sedativa']) && $napza->pertanyaan3['freq_ingin_sedativa'] == '0' ? 'checked' : '' }}>
                                        <label class="form-check-label">Tidak pernah</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label>h. Halusinogens (LSD, mushrooms, PCP, dll)</label>
                                <div class="d-flex">
                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan3[freq_ingin_halusinogen]" value="3"
                                            {{ isset($napza->pertanyaan3['freq_ingin_halusinogen']) && $napza->pertanyaan3['freq_ingin_halusinogen'] == '3' ? 'checked' : '' }}>
                                        <label class="form-check-label">Sekali atau dua kali</label>
                                    </div>
                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan3[freq_ingin_halusinogen]" value="4"
                                            {{ isset($napza->pertanyaan3['freq_ingin_halusinogen']) && $napza->pertanyaan3['freq_ingin_halusinogen'] == '4' ? 'checked' : '' }}>
                                        <label class="form-check-label">Tiap bulan</label>
                                    </div>
                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan3[freq_ingin_halusinogen]" value="5"
                                            {{ isset($napza->pertanyaan3['freq_ingin_halusinogen']) && $napza->pertanyaan3['freq_ingin_halusinogen'] == '5' ? 'checked' : '' }}>
                                        <label class="form-check-label">Tiap minggu</label>
                                    </div>
                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan3[freq_ingin_halusinogen]" value="6"
                                            {{ isset($napza->pertanyaan3['freq_ingin_halusinogen']) && $napza->pertanyaan3['freq_ingin_halusinogen'] == '6' ? 'checked' : '' }}>
                                        <label class="form-check-label">Selalu atau hampir selalu</label>
                                    </div>
                                    <div class="form-check ml-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan3[freq_ingin_halusinogen]" value="0"
                                            {{ isset($napza->pertanyaan3['freq_ingin_halusinogen']) && $napza->pertanyaan3['freq_ingin_halusinogen'] == '0' ? 'checked' : '' }}>
                                        <label class="form-check-label">Tidak pernah</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label>i. Opioid (heroin, morfin, metadon, kodein, dll)</label>
                                <div class="d-flex">
                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan3[freq_ingin_opioid]" value="3"
                                            {{ isset($napza->pertanyaan3['freq_ingin_opioid']) && $napza->pertanyaan3['freq_ingin_opioid'] == '3' ? 'checked' : '' }}>
                                        <label class="form-check-label">Sekali atau dua kali</label>
                                    </div>
                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan3[freq_ingin_opioid]" value="4"
                                            {{ isset($napza->pertanyaan3['freq_ingin_opioid']) && $napza->pertanyaan3['freq_ingin_opioid'] == '4' ? 'checked' : '' }}>
                                        <label class="form-check-label">Tiap bulan</label>
                                    </div>
                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan3[freq_ingin_opioid]" value="5"
                                            {{ isset($napza->pertanyaan3['freq_ingin_opioid']) && $napza->pertanyaan3['freq_ingin_opioid'] == '5' ? 'checked' : '' }}>
                                        <label class="form-check-label">Tiap minggu</label>
                                    </div>
                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan3[freq_ingin_opioid]" value="6"
                                            {{ isset($napza->pertanyaan3['freq_ingin_opioid']) && $napza->pertanyaan3['freq_ingin_opioid'] == '6' ? 'checked' : '' }}>
                                        <label class="form-check-label">Selalu atau hampir selalu</label>
                                    </div>
                                    <div class="form-check ml-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan3[freq_ingin_opioid]" value="0"
                                            {{ isset($napza->pertanyaan3['freq_ingin_opioid']) && $napza->pertanyaan3['freq_ingin_opioid'] == '0' ? 'checked' : '' }}>
                                        <label class="form-check-label">Tidak pernah</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="d-flex align-items-center">
                                    <label>j. Zat-lain: sebutkan</label>
                                    <input type="text" class="form-control ml-2"
                                        name="pertanyaan3[freq_ingin_zat_lain]"
                                        value="{{ isset($napza->pertanyaan3['freq_ingin_zat_lain']) ? $napza->pertanyaan3['freq_ingin_zat_lain'] : '' }}"
                                        style="width: auto;">
                                </div>
                                <div class="d-flex mt-2">
                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan3[freq_ingin_zat_lain_freq]" value="3"
                                            {{ isset($napza->pertanyaan3['freq_ingin_zat_lain_freq']) && $napza->pertanyaan3['freq_ingin_zat_lain_freq'] == '3' ? 'checked' : '' }}>
                                        <label class="form-check-label">Sekali atau dua kali</label>
                                    </div>
                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan3[freq_ingin_zat_lain_freq]" value="4"
                                            {{ isset($napza->pertanyaan3['freq_ingin_zat_lain_freq']) && $napza->pertanyaan3['freq_ingin_zat_lain_freq'] == '4' ? 'checked' : '' }}>
                                        <label class="form-check-label">Tiap bulan</label>
                                    </div>
                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan3[freq_ingin_zat_lain_freq]" value="5"
                                            {{ isset($napza->pertanyaan3['freq_ingin_zat_lain_freq']) && $napza->pertanyaan3['freq_ingin_zat_lain_freq'] == '5' ? 'checked' : '' }}>
                                        <label class="form-check-label">Tiap minggu</label>
                                    </div>
                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan3[freq_ingin_zat_lain_freq]" value="6"
                                            {{ isset($napza->pertanyaan3['freq_ingin_zat_lain_freq']) && $napza->pertanyaan3['freq_ingin_zat_lain_freq'] == '6' ? 'checked' : '' }}>
                                        <label class="form-check-label">Selalu atau hampir selalu</label>
                                    </div>
                                    <div class="form-check ml-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan3[freq_ingin_zat_lain_freq]" value="0"
                                            {{ isset($napza->pertanyaan3['freq_ingin_zat_lain_freq']) && $napza->pertanyaan3['freq_ingin_zat_lain_freq'] == '0' ? 'checked' : '' }}>
                                        <label class="form-check-label">Tidak pernah</label>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
                <h3>4. Selama tiga bulan terakhir, seberapa sering obat
                    yang anda gunakan dari (ZAT PERTAMA, ZAT
                    KEDUA, DLL) yang menyebabkan timbulnya
                    masalah kesehatan, sosial, hukum dan masalah
                    keuangan?</h3>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>a. Tembakau (rokok, cerutu, kretek, dll.)</label>
                                <div class="d-flex">
                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan4[freq_masalah_tembakau]" value="4"
                                            {{ isset($napza->pertanyaan4['freq_masalah_tembakau']) && $napza->pertanyaan4['freq_masalah_tembakau'] == '4' ? 'checked' : '' }}>
                                        <label class="form-check-label">Satu atau dua kali</label>
                                    </div>
                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan4[freq_masalah_tembakau]" value="5"
                                            {{ isset($napza->pertanyaan4['freq_masalah_tembakau']) && $napza->pertanyaan4['freq_masalah_tembakau'] == '5' ? 'checked' : '' }}>
                                        <label class="form-check-label">Tiap bulan</label>
                                    </div>
                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan4[freq_masalah_tembakau]" value="6"
                                            {{ isset($napza->pertanyaan4['freq_masalah_tembakau']) && $napza->pertanyaan4['freq_masalah_tembakau'] == '6' ? 'checked' : '' }}>
                                        <label class="form-check-label">Tiap minggu</label>
                                    </div>
                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan4[freq_masalah_tembakau]" value="7"
                                            {{ isset($napza->pertanyaan4['freq_masalah_tembakau']) && $napza->pertanyaan4['freq_masalah_tembakau'] == '7' ? 'checked' : '' }}>
                                        <label class="form-check-label">Harian atau hampir tiap hari</label>
                                    </div>
                                    <div class="form-check ml-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan4[freq_masalah_tembakau]" value="0"
                                            {{ isset($napza->pertanyaan4['freq_masalah_tembakau']) && $napza->pertanyaan4['freq_masalah_tembakau'] == '0' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="tidak">Tidak pernah</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label>b. Minuman beralkohol (bir, anggur, sopi, tomi dll.)</label>
                                <div class="d-flex">
                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan4[freq_masalah_alkohol]" value="4"
                                            {{ isset($napza->pertanyaan4['freq_masalah_alkohol']) && $napza->pertanyaan4['freq_masalah_alkohol'] == '4' ? 'checked' : '' }}>
                                        <label class="form-check-label">Satu atau dua kali</label>
                                    </div>
                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan4[freq_masalah_alkohol]" value="5"
                                            {{ isset($napza->pertanyaan4['freq_masalah_alkohol']) && $napza->pertanyaan4['freq_masalah_alkohol'] == '5' ? 'checked' : '' }}>
                                        <label class="form-check-label">Tiap bulan</label>
                                    </div>
                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan4[freq_masalah_alkohol]" value="6"
                                            {{ isset($napza->pertanyaan4['freq_masalah_alkohol']) && $napza->pertanyaan4['freq_masalah_alkohol'] == '6' ? 'checked' : '' }}>
                                        <label class="form-check-label">Tiap minggu</label>
                                    </div>
                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan4[freq_masalah_alkohol]" value="7"
                                            {{ isset($napza->pertanyaan4['freq_masalah_alkohol']) && $napza->pertanyaan4['freq_masalah_alkohol'] == '7' ? 'checked' : '' }}>
                                        <label class="form-check-label">Harian atau hampir tiap hari</label>
                                    </div>
                                    <div class="form-check ml-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan4[freq_masalah_alkohol]" value="0"
                                            {{ isset($napza->pertanyaan4['freq_masalah_alkohol']) && $napza->pertanyaan4['freq_masalah_alkohol'] == '0' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="tidak">Tidak pernah</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label>c. Kanabis (marijuana, ganja, gelek, cimengpot, dll.)</label>
                                <div class="d-flex">
                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan4[freq_masalah_kanabis]" value="4"
                                            {{ isset($napza->pertanyaan4['freq_masalah_kanabis']) && $napza->pertanyaan4['freq_masalah_kanabis'] == '4' ? 'checked' : '' }}>
                                        <label class="form-check-label">Satu atau dua kali</label>
                                    </div>
                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan4[freq_masalah_kanabis]" value="5"
                                            {{ isset($napza->pertanyaan4['freq_masalah_kanabis']) && $napza->pertanyaan4['freq_masalah_kanabis'] == '5' ? 'checked' : '' }}>
                                        <label class="form-check-label">Tiap bulan</label>
                                    </div>
                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan4[freq_masalah_kanabis]" value="6"
                                            {{ isset($napza->pertanyaan4['freq_masalah_kanabis']) && $napza->pertanyaan4['freq_masalah_kanabis'] == '6' ? 'checked' : '' }}>
                                        <label class="form-check-label">Tiap minggu</label>
                                    </div>
                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan4[freq_masalah_kanabis]" value="7"
                                            {{ isset($napza->pertanyaan4['freq_masalah_kanabis']) && $napza->pertanyaan4['freq_masalah_kanabis'] == '7' ? 'checked' : '' }}>
                                        <label class="form-check-label">Harian atau hampir tiap hari</label>
                                    </div>
                                    <div class="form-check ml-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan4[freq_masalah_kanabis]" value="0"
                                            {{ isset($napza->pertanyaan4['freq_masalah_kanabis']) && $napza->pertanyaan4['freq_masalah_kanabis'] == '0' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="tidak">Tidak pernah</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label>d. Kokain (coke, crack, etc.)</label>
                                <div class="d-flex">
                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan4[freq_masalah_kokain]" value="4"
                                            {{ isset($napza->pertanyaan4['freq_masalah_kokain']) && $napza->pertanyaan4['freq_masalah_kokain'] == '4' ? 'checked' : '' }}>
                                        <label class="form-check-label">Satu atau dua kali</label>
                                    </div>
                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan4[freq_masalah_kokain]" value="5"
                                            {{ isset($napza->pertanyaan4['freq_masalah_kokain']) && $napza->pertanyaan4['freq_masalah_kokain'] == '5' ? 'checked' : '' }}>
                                        <label class="form-check-label">Tiap bulan</label>
                                    </div>
                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan4[freq_masalah_kokain]" value="6"
                                            {{ isset($napza->pertanyaan4['freq_masalah_kokain']) && $napza->pertanyaan4['freq_masalah_kokain'] == '6' ? 'checked' : '' }}>
                                        <label class="form-check-label">Tiap minggu</label>
                                    </div>
                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan4[freq_masalah_kokain]" value="7"
                                            {{ isset($napza->pertanyaan4['freq_masalah_kokain']) && $napza->pertanyaan4['freq_masalah_kokain'] == '7' ? 'checked' : '' }}>
                                        <label class="form-check-label">Harian atau hampir tiap hari</label>
                                    </div>
                                    <div class="form-check ml-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan4[freq_masalah_kokain]" value="0"
                                            {{ isset($napza->pertanyaan4['freq_masalah_kokain']) && $napza->pertanyaan4['freq_masalah_kokain'] == '0' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="tidak">Tidak pernah</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label>e. Stimulan jenis amfetamin (ekstasi, shabu, dll)</label>
                                <div class="d-flex">
                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan4[freq_masalah_stimulan]" value="4"
                                            {{ isset($napza->pertanyaan4['freq_masalah_stimulan']) && $napza->pertanyaan4['freq_masalah_stimulan'] == '4' ? 'checked' : '' }}>
                                        <label class="form-check-label">Satu atau dua kali</label>
                                    </div>
                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan4[freq_masalah_stimulan]" value="5"
                                            {{ isset($napza->pertanyaan4['freq_masalah_stimulan']) && $napza->pertanyaan4['freq_masalah_stimulan'] == '5' ? 'checked' : '' }}>
                                        <label class="form-check-label">Tiap bulan</label>
                                    </div>
                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan4[freq_masalah_stimulan]" value="6"
                                            {{ isset($napza->pertanyaan4['freq_masalah_stimulan']) && $napza->pertanyaan4['freq_masalah_stimulan'] == '6' ? 'checked' : '' }}>
                                        <label class="form-check-label">Tiap minggu</label>
                                    </div>
                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan4[freq_masalah_stimulan]" value="7"
                                            {{ isset($napza->pertanyaan4['freq_masalah_stimulan']) && $napza->pertanyaan4['freq_masalah_stimulan'] == '7' ? 'checked' : '' }}>
                                        <label class="form-check-label">Harian atau hampir tiap hari</label>
                                    </div>
                                    <div class="form-check ml-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan4[freq_masalah_stimulan]" value="0"
                                            {{ isset($napza->pertanyaan4['freq_masalah_stimulan']) && $napza->pertanyaan4['freq_masalah_stimulan'] == '0' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="tidak">Tidak pernah</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label>f. Inhalansia (lem, bensin, tiner, dll)</label>
                                <div class="d-flex">
                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan4[freq_masalah_inhalansia]" value="4"
                                            {{ isset($napza->pertanyaan4['freq_masalah_inhalansia']) && $napza->pertanyaan4['freq_masalah_inhalansia'] == '4' ? 'checked' : '' }}>
                                        <label class="form-check-label">Satu atau dua kali</label>
                                    </div>
                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan4[freq_masalah_inhalansia]" value="5"
                                            {{ isset($napza->pertanyaan4['freq_masalah_inhalansia']) && $napza->pertanyaan4['freq_masalah_inhalansia'] == '5' ? 'checked' : '' }}>
                                        <label class="form-check-label">Tiap bulan</label>
                                    </div>
                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan4[freq_masalah_inhalansia]" value="6"
                                            {{ isset($napza->pertanyaan4['freq_masalah_inhalansia']) && $napza->pertanyaan4['freq_masalah_inhalansia'] == '6' ? 'checked' : '' }}>
                                        <label class="form-check-label">Tiap minggu</label>
                                    </div>
                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan4[freq_masalah_inhalansia]" value="7"
                                            {{ isset($napza->pertanyaan4['freq_masalah_inhalansia']) && $napza->pertanyaan4['freq_masalah_inhalansia'] == '7' ? 'checked' : '' }}>
                                        <label class="form-check-label">Harian atau hampir tiap hari</label>
                                    </div>
                                    <div class="form-check ml-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan4[freq_masalah_inhalansia]" value="0"
                                            {{ isset($napza->pertanyaan4['freq_masalah_inhalansia']) && $napza->pertanyaan4['freq_masalah_inhalansia'] == '0' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="tidak">Tidak pernah</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label>g. Sedativa atau obat tidur (Benzodiazepin, Lexotan, Rohypnol, Mogadon, dll.)</label>
                                <div class="d-flex">
                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan4[freq_masalah_sedativa]" value="4"
                                            {{ isset($napza->pertanyaan4['freq_masalah_sedativa']) && $napza->pertanyaan4['freq_masalah_sedativa'] == '4' ? 'checked' : '' }}>
                                        <label class="form-check-label">Satu atau dua kali</label>
                                    </div>
                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan4[freq_masalah_sedativa]" value="5"
                                            {{ isset($napza->pertanyaan4['freq_masalah_sedativa']) && $napza->pertanyaan4['freq_masalah_sedativa'] == '5' ? 'checked' : '' }}>
                                        <label class="form-check-label">Tiap bulan</label>
                                    </div>
                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan4[freq_masalah_sedativa]" value="6"
                                            {{ isset($napza->pertanyaan4['freq_masalah_sedativa']) && $napza->pertanyaan4['freq_masalah_sedativa'] == '6' ? 'checked' : '' }}>
                                        <label class="form-check-label">Tiap minggu</label>
                                    </div>
                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan4[freq_masalah_sedativa]" value="7"
                                            {{ isset($napza->pertanyaan4['freq_masalah_sedativa']) && $napza->pertanyaan4['freq_masalah_sedativa'] == '7' ? 'checked' : '' }}>
                                        <label class="form-check-label">Harian atau hampir tiap hari</label>
                                    </div>
                                    <div class="form-check ml-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan4[freq_masalah_sedativa]" value="0"
                                            {{ isset($napza->pertanyaan4['freq_masalah_sedativa']) && $napza->pertanyaan4['freq_masalah_sedativa'] == '0' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="tidak">Tidak pernah</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label>h. Halusinogens (LSD, mushrooms, PCP, dll)</label>
                                <div class="d-flex">
                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan4[freq_masalah_halusinogen]" value="4"
                                            {{ isset($napza->pertanyaan4['freq_masalah_halusinogen']) && $napza->pertanyaan4['freq_masalah_halusinogen'] == '4' ? 'checked' : '' }}>
                                        <label class="form-check-label">Satu atau dua kali</label>
                                    </div>
                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan4[freq_masalah_halusinogen]" value="5"
                                            {{ isset($napza->pertanyaan4['freq_masalah_halusinogen']) && $napza->pertanyaan4['freq_masalah_halusinogen'] == '5' ? 'checked' : '' }}>
                                        <label class="form-check-label">Tiap bulan</label>
                                    </div>
                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan4[freq_masalah_halusinogen]" value="6"
                                            {{ isset($napza->pertanyaan4['freq_masalah_halusinogen']) && $napza->pertanyaan4['freq_masalah_halusinogen'] == '6' ? 'checked' : '' }}>
                                        <label class="form-check-label">Tiap minggu</label>
                                    </div>
                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan4[freq_masalah_halusinogen]" value="7"
                                            {{ isset($napza->pertanyaan4['freq_masalah_halusinogen']) && $napza->pertanyaan4['freq_masalah_halusinogen'] == '7' ? 'checked' : '' }}>
                                        <label class="form-check-label">Harian atau hampir tiap hari</label>
                                    </div>
                                    <div class="form-check ml-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan4[freq_masalah_halusinogen]" value="0"
                                            {{ isset($napza->pertanyaan4['freq_masalah_halusinogen']) && $napza->pertanyaan4['freq_masalah_halusinogen'] == '0' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="tidak">Tidak pernah</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label>i. Opioid (heroin, morfin, metadon, kodein, dll)</label>
                                <div class="d-flex">
                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan5[freq_masalah_opioid]" value="4"
                                            {{ isset($napza->pertanyaan5['freq_masalah_opioid']) && $napza->pertanyaan5['freq_masalah_opioid'] == '4' ? 'checked' : '' }}>
                                        <label class="form-check-label">Satu atau dua kali</label>
                                    </div>
                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan5[freq_masalah_opioid]" value="5"
                                            {{ isset($napza->pertanyaan5['freq_masalah_opioid']) && $napza->pertanyaan5['freq_masalah_opioid'] == '5' ? 'checked' : '' }}>
                                        <label class="form-check-label">Tiap bulan</label>
                                    </div>
                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan5[freq_masalah_opioid]" value="6"
                                            {{ isset($napza->pertanyaan5['freq_masalah_opioid']) && $napza->pertanyaan5['freq_masalah_opioid'] == '6' ? 'checked' : '' }}>
                                        <label class="form-check-label">Tiap minggu</label>
                                    </div>
                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan5[freq_masalah_opioid]" value="7"
                                            {{ isset($napza->pertanyaan5['freq_masalah_opioid']) && $napza->pertanyaan5['freq_masalah_opioid'] == '7' ? 'checked' : '' }}>
                                        <label class="form-check-label">Harian atau hampir tiap hari</label>
                                    </div>
                                    <div class="form-check ml-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan5[freq_masalah_opioid]" value="0"
                                            {{ isset($napza->pertanyaan5['freq_masalah_opioid']) && $napza->pertanyaan5['freq_masalah_opioid'] == '0' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="tidak">Tidak pernah</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="d-flex align-items-center">
                                    <label>j. Zat-lain: sebutkan</label>
                                    <input type="text" class="form-control ml-2"
                                        name="pertanyaan5[freq_masalah_zat_lain]"
                                        value="{{ old('pertanyaan5.freq_masalah_zat_lain', $napza->pertanyaan5['freq_masalah_zat_lain'] ?? '') }}"
                                        style="width: auto;">
                                </div>
                                <div class="d-flex mt-2">
                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan5[freq_masalah_zat_lain_freq]" value="4"
                                            {{ isset($napza->pertanyaan5['freq_masalah_zat_lain_freq']) && $napza->pertanyaan5['freq_masalah_zat_lain_freq'] == '4' ? 'checked' : '' }}>
                                        <label class="form-check-label">Satu atau dua kali</label>
                                    </div>
                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan5[freq_masalah_zat_lain_freq]" value="5"
                                            {{ isset($napza->pertanyaan5['freq_masalah_zat_lain_freq']) && $napza->pertanyaan5['freq_masalah_zat_lain_freq'] == '5' ? 'checked' : '' }}>
                                        <label class="form-check-label">Tiap bulan</label>
                                    </div>
                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan5[freq_masalah_zat_lain_freq]" value="6"
                                            {{ isset($napza->pertanyaan5['freq_masalah_zat_lain_freq']) && $napza->pertanyaan5['freq_masalah_zat_lain_freq'] == '6' ? 'checked' : '' }}>
                                        <label class="form-check-label">Tiap minggu</label>
                                    </div>
                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan5[freq_masalah_zat_lain_freq]" value="7"
                                            {{ isset($napza->pertanyaan5['freq_masalah_zat_lain_freq']) && $napza->pertanyaan5['freq_masalah_zat_lain_freq'] == '7' ? 'checked' : '' }}>
                                        <label class="form-check-label">Harian atau hampir tiap hari</label>
                                    </div>
                                    <div class="form-check ml-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan5[freq_masalah_zat_lain_freq]" value="0"
                                            {{ isset($napza->pertanyaan5['freq_masalah_zat_lain_freq']) && $napza->pertanyaan5['freq_masalah_zat_lain_freq'] == '0' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="tidak">Tidak pernah</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <h3>5. Selama tiga bulan terakhir, seberapa sering
                    anda gagal melakukan hal-hal yang biasa anda
                    lakukan disebabkan karena penggunaan dari
                    (ZAT PERTAMA, ZAT KEDUA, DLL )?</h3>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>a. Tembakau (rokok, cerutu, kretek, dll.)</label>
                                <div class="d-flex">
                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan5[freq_gagal_tembakau]" value="5"
                                            {{ isset($napza->pertanyaan5['freq_gagal_tembakau']) && $napza->pertanyaan5['freq_gagal_tembakau'] == '5' ? 'checked' : '' }}>
                                        <label class="form-check-label">Satu atau dua kali</label>
                                    </div>
                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan5[freq_gagal_tembakau]" value="6"
                                            {{ isset($napza->pertanyaan5['freq_gagal_tembakau']) && $napza->pertanyaan5['freq_gagal_tembakau'] == '6' ? 'checked' : '' }}>
                                        <label class="form-check-label">Tiap bulan</label>
                                    </div>
                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan5[freq_gagal_tembakau]" value="7"
                                            {{ isset($napza->pertanyaan5['freq_gagal_tembakau']) && $napza->pertanyaan5['freq_gagal_tembakau'] == '7' ? 'checked' : '' }}>
                                        <label class="form-check-label">Tiap minggu</label>
                                    </div>
                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan5[freq_gagal_tembakau]" value="8"
                                            {{ isset($napza->pertanyaan5['freq_gagal_tembakau']) && $napza->pertanyaan5['freq_gagal_tembakau'] == '8' ? 'checked' : '' }}>
                                        <label class="form-check-label">Harian atau hampir tiap hari</label>
                                    </div>
                                    <div class="form-check ml-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan5[freq_gagal_tembakau]" value="0"
                                            {{ isset($napza->pertanyaan5['freq_gagal_tembakau']) && $napza->pertanyaan5['freq_gagal_tembakau'] == '0' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="tidak">Tidak pernah</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label>b. Minuman beralkohol (bir, anggur, sopi, tomi dll.)</label>
                                <div class="d-flex">
                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan5[freq_gagal_alkohol]" value="5"
                                            {{ isset($napza->pertanyaan5['freq_gagal_alkohol']) && $napza->pertanyaan5['freq_gagal_alkohol'] == '5' ? 'checked' : '' }}>
                                        <label class="form-check-label">Satu atau dua kali</label>
                                    </div>
                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan5[freq_gagal_alkohol]" value="6"
                                            {{ isset($napza->pertanyaan5['freq_gagal_alkohol']) && $napza->pertanyaan5['freq_gagal_alkohol'] == '6' ? 'checked' : '' }}>
                                        <label class="form-check-label">Tiap bulan</label>
                                    </div>
                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan5[freq_gagal_alkohol]" value="7"
                                            {{ isset($napza->pertanyaan5['freq_gagal_alkohol']) && $napza->pertanyaan5['freq_gagal_alkohol'] == '7' ? 'checked' : '' }}>
                                        <label class="form-check-label">Tiap minggu</label>
                                    </div>
                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan5[freq_gagal_alkohol]" value="8"
                                            {{ isset($napza->pertanyaan5['freq_gagal_alkohol']) && $napza->pertanyaan5['freq_gagal_alkohol'] == '8' ? 'checked' : '' }}>
                                        <label class="form-check-label">Harian atau hampir tiap hari</label>
                                    </div>
                                    <div class="form-check ml-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan5[freq_gagal_alkohol]" value="0"
                                            {{ isset($napza->pertanyaan5['freq_gagal_alkohol']) && $napza->pertanyaan5['freq_gagal_alkohol'] == '0' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="tidak">Tidak pernah</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label>c. Kanabis (marijuana, ganja, gelek, cimengpot, dll.)</label>
                                <div class="d-flex">
                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan5[freq_gagal_kanabis]" value="5"
                                            {{ isset($napza->pertanyaan5['freq_gagal_kanabis']) && $napza->pertanyaan5['freq_gagal_kanabis'] == '5' ? 'checked' : '' }}>
                                        <label class="form-check-label">Satu atau dua kali</label>
                                    </div>
                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan5[freq_gagal_kanabis]" value="6"
                                            {{ isset($napza->pertanyaan5['freq_gagal_kanabis']) && $napza->pertanyaan5['freq_gagal_kanabis'] == '6' ? 'checked' : '' }}>
                                        <label class="form-check-label">Tiap bulan</label>
                                    </div>
                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan5[freq_gagal_kanabis]" value="7"
                                            {{ isset($napza->pertanyaan5['freq_gagal_kanabis']) && $napza->pertanyaan5['freq_gagal_kanabis'] == '7' ? 'checked' : '' }}>
                                        <label class="form-check-label">Tiap minggu</label>
                                    </div>
                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan5[freq_gagal_kanabis]" value="8"
                                            {{ isset($napza->pertanyaan5['freq_gagal_kanabis']) && $napza->pertanyaan5['freq_gagal_kanabis'] == '8' ? 'checked' : '' }}>
                                        <label class="form-check-label">Harian atau hampir tiap hari</label>
                                    </div>
                                    <div class="form-check ml-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan5[freq_gagal_kanabis]" value="0"
                                            {{ isset($napza->pertanyaan5['freq_gagal_kanabis']) && $napza->pertanyaan5['freq_gagal_kanabis'] == '0' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="tidak">Tidak pernah</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label>d. Kokain (coke, crack, etc.)</label>
                                <div class="d-flex">
                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan5[freq_gagal_kokain]" value="5"
                                            {{ isset($napza->pertanyaan5['freq_gagal_kokain']) && $napza->pertanyaan5['freq_gagal_kokain'] == '5' ? 'checked' : '' }}>
                                        <label class="form-check-label">Satu atau dua kali</label>
                                    </div>
                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan5[freq_gagal_kokain]" value="6"
                                            {{ isset($napza->pertanyaan5['freq_gagal_kokain']) && $napza->pertanyaan5['freq_gagal_kokain'] == '6' ? 'checked' : '' }}>
                                        <label class="form-check-label">Tiap bulan</label>
                                    </div>
                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan5[freq_gagal_kokain]" value="7"
                                            {{ isset($napza->pertanyaan5['freq_gagal_kokain']) && $napza->pertanyaan5['freq_gagal_kokain'] == '7' ? 'checked' : '' }}>
                                        <label class="form-check-label">Tiap minggu</label>
                                    </div>
                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan5[freq_gagal_kokain]" value="8"
                                            {{ isset($napza->pertanyaan5['freq_gagal_kokain']) && $napza->pertanyaan5['freq_gagal_kokain'] == '8' ? 'checked' : '' }}>
                                        <label class="form-check-label">Harian atau hampir tiap hari</label>
                                    </div>
                                    <div class="form-check ml-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan5[freq_gagal_kokain]" value="0"
                                            {{ isset($napza->pertanyaan5['freq_gagal_kokain']) && $napza->pertanyaan5['freq_gagal_kokain'] == '0' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="tidak">Tidak pernah</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label>e. Stimulan jenis amfetamin (ekstasi, shabu, dll)</label>
                                <div class="d-flex">
                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan5[freq_gagal_stimulan]" value="5"
                                            {{ isset($napza->pertanyaan5['freq_gagal_stimulan']) && $napza->pertanyaan5['freq_gagal_stimulan'] == '5' ? 'checked' : '' }}>
                                        <label class="form-check-label">Satu atau dua kali</label>
                                    </div>
                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan5[freq_gagal_stimulan]" value="6"
                                            {{ isset($napza->pertanyaan5['freq_gagal_stimulan']) && $napza->pertanyaan5['freq_gagal_stimulan'] == '6' ? 'checked' : '' }}>
                                        <label class="form-check-label">Tiap bulan</label>
                                    </div>
                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan5[freq_gagal_stimulan]" value="7"
                                            {{ isset($napza->pertanyaan5['freq_gagal_stimulan']) && $napza->pertanyaan5['freq_gagal_stimulan'] == '7' ? 'checked' : '' }}>
                                        <label class="form-check-label">Tiap minggu</label>
                                    </div>
                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan5[freq_gagal_stimulan]" value="8"
                                            {{ isset($napza->pertanyaan5['freq_gagal_stimulan']) && $napza->pertanyaan5['freq_gagal_stimulan'] == '8' ? 'checked' : '' }}>
                                        <label class="form-check-label">Harian atau hampir tiap hari</label>
                                    </div>
                                    <div class="form-check ml-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan5[freq_gagal_stimulan]" value="0"
                                            {{ isset($napza->pertanyaan5['freq_gagal_stimulan']) && $napza->pertanyaan5['freq_gagal_stimulan'] == '0' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="tidak">Tidak pernah</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label>f. Inhalansia (lem, bensin, tiner, dll)</label>
                                <div class="d-flex">
                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan5[freq_gagal_inhalansia]" value="5"
                                            {{ isset($napza->pertanyaan5['freq_gagal_inhalansia']) && $napza->pertanyaan5['freq_gagal_inhalansia'] == '5' ? 'checked' : '' }}>
                                        <label class="form-check-label">Satu atau dua kali</label>
                                    </div>
                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan5[freq_gagal_inhalansia]" value="6"
                                            {{ isset($napza->pertanyaan5['freq_gagal_inhalansia']) && $napza->pertanyaan5['freq_gagal_inhalansia'] == '6' ? 'checked' : '' }}>
                                        <label class="form-check-label">Tiap bulan</label>
                                    </div>
                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan5[freq_gagal_inhalansia]" value="7"
                                            {{ isset($napza->pertanyaan5['freq_gagal_inhalansia']) && $napza->pertanyaan5['freq_gagal_inhalansia'] == '7' ? 'checked' : '' }}>
                                        <label class="form-check-label">Tiap minggu</label>
                                    </div>
                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan5[freq_gagal_inhalansia]" value="8"
                                            {{ isset($napza->pertanyaan5['freq_gagal_inhalansia']) && $napza->pertanyaan5['freq_gagal_inhalansia'] == '8' ? 'checked' : '' }}>
                                        <label class="form-check-label">Harian atau hampir tiap hari</label>
                                    </div>
                                    <div class="form-check ml-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan5[freq_gagal_inhalansia]" value="0"
                                            {{ isset($napza->pertanyaan5['freq_gagal_inhalansia']) && $napza->pertanyaan5['freq_gagal_inhalansia'] == '0' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="tidak">Tidak pernah</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label>g. Sedativa atau obat tidur (Benzodiazepin, Lexotan, Rohypnol, Mogadon, dll.)</label>
                                <div class="d-flex">
                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan5[freq_gagal_sedativa]" value="5"
                                            {{ isset($napza->pertanyaan5['freq_gagal_sedativa']) && $napza->pertanyaan5['freq_gagal_sedativa'] == '5' ? 'checked' : '' }}>
                                        <label class="form-check-label">Satu atau dua kali</label>
                                    </div>
                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan5[freq_gagal_sedativa]" value="6"
                                            {{ isset($napza->pertanyaan5['freq_gagal_sedativa']) && $napza->pertanyaan5['freq_gagal_sedativa'] == '6' ? 'checked' : '' }}>
                                        <label class="form-check-label">Tiap bulan</label>
                                    </div>
                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan5[freq_gagal_sedativa]" value="7"
                                            {{ isset($napza->pertanyaan5['freq_gagal_sedativa']) && $napza->pertanyaan5['freq_gagal_sedativa'] == '7' ? 'checked' : '' }}>
                                        <label class="form-check-label">Tiap minggu</label>
                                    </div>
                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan5[freq_gagal_sedativa]" value="8"
                                            {{ isset($napza->pertanyaan5['freq_gagal_sedativa']) && $napza->pertanyaan5['freq_gagal_sedativa'] == '8' ? 'checked' : '' }}>
                                        <label class="form-check-label">Harian atau hampir tiap hari</label>
                                    </div>
                                    <div class="form-check ml-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan5[freq_gagal_sedativa]" value="0"
                                            {{ isset($napza->pertanyaan5['freq_gagal_sedativa']) && $napza->pertanyaan5['freq_gagal_sedativa'] == '0' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="tidak">Tidak pernah</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label>h. Halusinogens (LSD, mushrooms, PCP, dll)</label>
                                <div class="d-flex">
                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan5[freq_gagal_halusinogen]" value="5"
                                            {{ isset($napza->pertanyaan5['freq_gagal_halusinogen']) && $napza->pertanyaan5['freq_gagal_halusinogen'] == '5' ? 'checked' : '' }}>
                                        <label class="form-check-label">Satu atau dua kali</label>
                                    </div>
                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan5[freq_gagal_halusinogen]" value="6"
                                            {{ isset($napza->pertanyaan5['freq_gagal_halusinogen']) && $napza->pertanyaan5['freq_gagal_halusinogen'] == '6' ? 'checked' : '' }}>
                                        <label class="form-check-label">Tiap bulan</label>
                                    </div>
                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan5[freq_gagal_halusinogen]" value="7"
                                            {{ isset($napza->pertanyaan5['freq_gagal_halusinogen']) && $napza->pertanyaan5['freq_gagal_halusinogen'] == '7' ? 'checked' : '' }}>
                                        <label class="form-check-label">Tiap minggu</label>
                                    </div>
                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan5[freq_gagal_halusinogen]" value="8"
                                            {{ isset($napza->pertanyaan5['freq_gagal_halusinogen']) && $napza->pertanyaan5['freq_gagal_halusinogen'] == '8' ? 'checked' : '' }}>
                                        <label class="form-check-label">Harian atau hampir tiap hari</label>
                                    </div>
                                    <div class="form-check ml-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan5[freq_gagal_halusinogen]" value="0"
                                            {{ isset($napza->pertanyaan5['freq_gagal_halusinogen']) && $napza->pertanyaan5['freq_gagal_halusinogen'] == '0' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="tidak">Tidak pernah</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label>i. Opioid (heroin, morfin, metadon, kodein, dll)</label>
                                <div class="d-flex">
                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan6[freq_gagal_opioid]" value="5"
                                            {{ isset($napza->pertanyaan6['freq_gagal_opioid']) && $napza->pertanyaan6['freq_gagal_opioid'] == '5' ? 'checked' : '' }}>
                                        <label class="form-check-label">Satu atau dua kali</label>
                                    </div>
                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan6[freq_gagal_opioid]" value="6"
                                            {{ isset($napza->pertanyaan6['freq_gagal_opioid']) && $napza->pertanyaan6['freq_gagal_opioid'] == '6' ? 'checked' : '' }}>
                                        <label class="form-check-label">Tiap bulan</label>
                                    </div>
                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan6[freq_gagal_opioid]" value="7"
                                            {{ isset($napza->pertanyaan6['freq_gagal_opioid']) && $napza->pertanyaan6['freq_gagal_opioid'] == '7' ? 'checked' : '' }}>
                                        <label class="form-check-label">Tiap minggu</label>
                                    </div>
                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan6[freq_gagal_opioid]" value="8"
                                            {{ isset($napza->pertanyaan6['freq_gagal_opioid']) && $napza->pertanyaan6['freq_gagal_opioid'] == '8' ? 'checked' : '' }}>
                                        <label class="form-check-label">Harian atau hampir tiap hari</label>
                                    </div>
                                    <div class="form-check ml-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan6[freq_gagal_opioid]" value="0"
                                            {{ isset($napza->pertanyaan6['freq_gagal_opioid']) && $napza->pertanyaan6['freq_gagal_opioid'] == '0' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="tidak">Tidak pernah</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="d-flex align-items-center">
                                    <label>j. Zat-lain: sebutkan</label>
                                    <input type="text" class="form-control ml-2"
                                        name="pertanyaan6[freq_gagal_zat_lain]" style="width: auto;"
                                        value="{{ isset($napza->pertanyaan6['freq_gagal_zat_lain']) ? $napza->pertanyaan6['freq_gagal_zat_lain'] : '' }}">
                                </div>
                                <div class="d-flex mt-2">
                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan6[freq_gagal_zat_lain_freq]" value="5"
                                            {{ isset($napza->pertanyaan6['freq_gagal_zat_lain_freq']) && $napza->pertanyaan6['freq_gagal_zat_lain_freq'] == '5' ? 'checked' : '' }}>
                                        <label class="form-check-label">Satu atau dua kali</label>
                                    </div>
                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan6[freq_gagal_zat_lain_freq]" value="6"
                                            {{ isset($napza->pertanyaan6['freq_gagal_zat_lain_freq']) && $napza->pertanyaan6['freq_gagal_zat_lain_freq'] == '6' ? 'checked' : '' }}>
                                        <label class="form-check-label">Tiap bulan</label>
                                    </div>
                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan6[freq_gagal_zat_lain_freq]" value="7"
                                            {{ isset($napza->pertanyaan6['freq_gagal_zat_lain_freq']) && $napza->pertanyaan6['freq_gagal_zat_lain_freq'] == '7' ? 'checked' : '' }}>
                                        <label class="form-check-label">Tiap minggu</label>
                                    </div>
                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan6[freq_gagal_zat_lain_freq]" value="8"
                                            {{ isset($napza->pertanyaan6['freq_gagal_zat_lain_freq']) && $napza->pertanyaan6['freq_gagal_zat_lain_freq'] == '8' ? 'checked' : '' }}>
                                        <label class="form-check-label">Harian atau hampir tiap hari</label>
                                    </div>
                                    <div class="form-check ml-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan6[freq_gagal_zat_lain_freq]" value="0"
                                            {{ isset($napza->pertanyaan6['freq_gagal_zat_lain_freq']) && $napza->pertanyaan6['freq_gagal_zat_lain_freq'] == '0' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="tidak">Tidak pernah</label>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
                <h5 class="red-text"><strong>Tanyakan Pertanyaan 6 & 7 untuk semua zat yang pernah digunakan (misalnya zat
                        yang didapat pada Pertanyaan 1)</strong></h5>
                <br>
                <h3>6. Pernahkah teman, keluarga atau orang lain
                    mengekspresikan kekhawatiran tentang
                    penggunaan dari (ZAT PERTAMA, KEDUA, DLL)?</h3>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>a. Tembakau (rokok, cerutu, kretek, dll.)</label>
                                <div class="d-flex">
                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan6[freq_khawatir_tembakau]" value="3"
                                            {{ isset($napza->pertanyaan6['freq_khawatir_tembakau']) && $napza->pertanyaan6['freq_khawatir_tembakau'] == '3' ? 'checked' : '' }}>
                                        <label class="form-check-label">Pernah, tapi tidak dalam 3 bulan terakhir</label>
                                    </div>

                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan6[freq_khawatir_tembakau]" value="6"
                                            {{ isset($napza->pertanyaan6['freq_khawatir_tembakau']) && $napza->pertanyaan6['freq_khawatir_tembakau'] == '6' ? 'checked' : '' }}>
                                        <label class="form-check-label">Pernah, dalam 3 bulan terakhir</label>
                                    </div>

                                    <div class="form-check ml-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan6[freq_khawatir_tembakau]" value="0"
                                            {{ isset($napza->pertanyaan6['freq_khawatir_tembakau']) && $napza->pertanyaan6['freq_khawatir_tembakau'] == '0' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="tidak">Tidak pernah</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label>b. Minuman beralkohol (bir, anggur, sopi, tomi dll.)</label>
                                <div class="d-flex">
                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan6[freq_khawatir_alkohol]" value="3"
                                            {{ isset($napza->pertanyaan6['freq_khawatir_alkohol']) && $napza->pertanyaan6['freq_khawatir_alkohol'] == '3' ? 'checked' : '' }}>
                                        <label class="form-check-label">Pernah, tapi tidak dalam 3 bulan terakhir</label>
                                    </div>

                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan6[freq_khawatir_alkohol]" value="6"
                                            {{ isset($napza->pertanyaan6['freq_khawatir_alkohol']) && $napza->pertanyaan6['freq_khawatir_alkohol'] == '6' ? 'checked' : '' }}>
                                        <label class="form-check-label">Pernah, dalam 3 bulan terakhir</label>
                                    </div>

                                    <div class="form-check ml-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan6[freq_khawatir_alkohol]" value="0"
                                            {{ isset($napza->pertanyaan6['freq_khawatir_alkohol']) && $napza->pertanyaan6['freq_khawatir_alkohol'] == '0' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="tidak">Tidak pernah</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label>c. Kanabis (marijuana, ganja, gelek, cimengpot, dll.)</label>
                                <div class="d-flex">
                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan6[freq_khawatir_kanabis]" value="3"
                                            {{ isset($napza->pertanyaan6['freq_khawatir_kanabis']) && $napza->pertanyaan6['freq_khawatir_kanabis'] == '3' ? 'checked' : '' }}>
                                        <label class="form-check-label">Pernah, tapi tidak dalam 3 bulan terakhir</label>
                                    </div>

                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan6[freq_khawatir_kanabis]" value="6"
                                            {{ isset($napza->pertanyaan6['freq_khawatir_kanabis']) && $napza->pertanyaan6['freq_khawatir_kanabis'] == '6' ? 'checked' : '' }}>
                                        <label class="form-check-label">Pernah, dalam 3 bulan terakhir</label>
                                    </div>

                                    <div class="form-check ml-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan6[freq_khawatir_kanabis]" value="0"
                                            {{ isset($napza->pertanyaan6['freq_khawatir_kanabis']) && $napza->pertanyaan6['freq_khawatir_kanabis'] == '0' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="tidak">Tidak pernah</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label>d. Kokain (coke, crack, etc.)</label>
                                <div class="d-flex">
                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan6[freq_khawatir_kokain]" value="3"
                                            {{ isset($napza->pertanyaan6['freq_khawatir_kokain']) && $napza->pertanyaan6['freq_khawatir_kokain'] == '3' ? 'checked' : '' }}>
                                        <label class="form-check-label">Pernah, tapi tidak dalam 3 bulan terakhir</label>
                                    </div>

                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan6[freq_khawatir_kokain]" value="6"
                                            {{ isset($napza->pertanyaan6['freq_khawatir_kokain']) && $napza->pertanyaan6['freq_khawatir_kokain'] == '6' ? 'checked' : '' }}>
                                        <label class="form-check-label">Pernah, dalam 3 bulan terakhir</label>
                                    </div>

                                    <div class="form-check ml-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan6[freq_khawatir_kokain]" value="0"
                                            {{ isset($napza->pertanyaan6['freq_khawatir_kokain']) && $napza->pertanyaan6['freq_khawatir_kokain'] == '0' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="tidak">Tidak pernah</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label>e. Stimulan jenis amfetamin (ekstasi, shabu, dll)</label>
                                <div class="d-flex">
                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan6[freq_khawatir_stimulan]" value="3"
                                            {{ isset($napza->pertanyaan6['freq_khawatir_stimulan']) && $napza->pertanyaan6['freq_khawatir_stimulan'] == '3' ? 'checked' : '' }}>
                                        <label class="form-check-label">Pernah, tapi tidak dalam 3 bulan terakhir</label>
                                    </div>

                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan6[freq_khawatir_stimulan]" value="6"
                                            {{ isset($napza->pertanyaan6['freq_khawatir_stimulan']) && $napza->pertanyaan6['freq_khawatir_stimulan'] == '6' ? 'checked' : '' }}>
                                        <label class="form-check-label">Pernah, dalam 3 bulan terakhir</label>
                                    </div>

                                    <div class="form-check ml-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan6[freq_khawatir_stimulan]" value="0"
                                            {{ isset($napza->pertanyaan6['freq_khawatir_stimulan']) && $napza->pertanyaan6['freq_khawatir_stimulan'] == '0' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="tidak">Tidak pernah</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label>f. Inhalansia (lem, bensin, tiner, dll)</label>
                                <div class="d-flex">
                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan6[freq_khawatir_inhalansia]" value="3"
                                            {{ isset($napza->pertanyaan6['freq_khawatir_inhalansia']) && $napza->pertanyaan6['freq_khawatir_inhalansia'] == '3' ? 'checked' : '' }}>
                                        <label class="form-check-label">Pernah, tapi tidak dalam 3 bulan terakhir</label>
                                    </div>

                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan6[freq_khawatir_inhalansia]" value="6"
                                            {{ isset($napza->pertanyaan6['freq_khawatir_inhalansia']) && $napza->pertanyaan6['freq_khawatir_inhalansia'] == '6' ? 'checked' : '' }}>
                                        <label class="form-check-label">Pernah, dalam 3 bulan terakhir</label>
                                    </div>

                                    <div class="form-check ml-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan6[freq_khawatir_inhalansia]" value="0"
                                            {{ isset($napza->pertanyaan6['freq_khawatir_inhalansia']) && $napza->pertanyaan6['freq_khawatir_inhalansia'] == '0' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="tidak">Tidak pernah</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label>g. Sedativa atau obat tidur (Benzodiazepin, Lexotan, Rohypnol, Mogadon, dll.)</label>
                                <div class="d-flex">
                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan6[freq_khawatir_sedativa]" value="3"
                                            {{ isset($napza->pertanyaan6['freq_khawatir_sedativa']) && $napza->pertanyaan6['freq_khawatir_sedativa'] == '3' ? 'checked' : '' }}>
                                        <label class="form-check-label">Pernah, tapi tidak dalam 3 bulan terakhir</label>
                                    </div>

                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan6[freq_khawatir_sedativa]" value="6"
                                            {{ isset($napza->pertanyaan6['freq_khawatir_sedativa']) && $napza->pertanyaan6['freq_khawatir_sedativa'] == '6' ? 'checked' : '' }}>
                                        <label class="form-check-label">Pernah, dalam 3 bulan terakhir</label>
                                    </div>

                                    <div class="form-check ml-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan6[freq_khawatir_sedativa]" value="0"
                                            {{ isset($napza->pertanyaan6['freq_khawatir_sedativa']) && $napza->pertanyaan6['freq_khawatir_sedativa'] == '0' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="tidak">Tidak pernah</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label>h. Halusinogens (LSD, mushrooms, PCP, dll)</label>
                                <div class="d-flex">
                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan6[freq_khawatir_halusinogen]" value="3"
                                            {{ isset($napza->pertanyaan6['freq_khawatir_halusinogen']) && $napza->pertanyaan6['freq_khawatir_halusinogen'] == '3' ? 'checked' : '' }}>
                                        <label class="form-check-label">Pernah, tapi tidak dalam 3 bulan terakhir</label>
                                    </div>

                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan6[freq_khawatir_halusinogen]" value="6"
                                            {{ isset($napza->pertanyaan6['freq_khawatir_halusinogen']) && $napza->pertanyaan6['freq_khawatir_halusinogen'] == '6' ? 'checked' : '' }}>
                                        <label class="form-check-label">Pernah, dalam 3 bulan terakhir</label>
                                    </div>

                                    <div class="form-check ml-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan6[freq_khawatir_halusinogen]" value="0"
                                            {{ isset($napza->pertanyaan6['freq_khawatir_halusinogen']) && $napza->pertanyaan6['freq_khawatir_halusinogen'] == '0' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="tidak">Tidak pernah</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label>i. Opioid (heroin, morfin, metadon, kodein, dll)</label>
                                <div class="d-flex">
                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan6[freq_khawatir_opioid]" value="3"
                                            {{ isset($napza->pertanyaan6['freq_khawatir_opioid']) && $napza->pertanyaan6['freq_khawatir_opioid'] == '3' ? 'checked' : '' }}>
                                        <label class="form-check-label">Pernah, tapi tidak dalam 3 bulan terakhir</label>
                                    </div>

                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan6[freq_khawatir_opioid]" value="6"
                                            {{ isset($napza->pertanyaan6['freq_khawatir_opioid']) && $napza->pertanyaan6['freq_khawatir_opioid'] == '6' ? 'checked' : '' }}>
                                        <label class="form-check-label">Pernah, dalam 3 bulan terakhir</label>
                                    </div>

                                    <div class="form-check ml-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan6[freq_khawatir_opioid]" value="0"
                                            {{ isset($napza->pertanyaan6['freq_khawatir_opioid']) && $napza->pertanyaan6['freq_khawatir_opioid'] == '0' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="tidak">Tidak pernah</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="d-flex align-items-center">
                                    <label>j. Zat-lain: sebutkan</label>
                                    <input type="text" class="form-control ml-2"
                                        name="pertanyaan6[freq_khawatir_zat_lain]" style="width: auto;"
                                        value="{{ isset($napza->pertanyaan6['freq_khawatir_zat_lain']) ? $napza->pertanyaan6['freq_khawatir_zat_lain'] : '' }}">
                                </div>
                                <div class="d-flex mt-2">
                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan6[freq_khawatir_zat_lain_freq]" value="3"
                                            {{ isset($napza->pertanyaan6['freq_khawatir_zat_lain_freq']) && $napza->pertanyaan6['freq_khawatir_zat_lain_freq'] == '3' ? 'checked' : '' }}>
                                        <label class="form-check-label">Pernah, tapi tidak dalam 3 bulan terakhir</label>
                                    </div>

                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan6[freq_khawatir_zat_lain_freq]" value="6"
                                            {{ isset($napza->pertanyaan6['freq_khawatir_zat_lain_freq']) && $napza->pertanyaan6['freq_khawatir_zat_lain_freq'] == '6' ? 'checked' : '' }}>
                                        <label class="form-check-label">Pernah, dalam 3 bulan terakhir</label>
                                    </div>

                                    <div class="form-check ml-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan6[freq_khawatir_zat_lain_freq]" value="0"
                                            {{ isset($napza->pertanyaan6['freq_khawatir_zat_lain_freq']) && $napza->pertanyaan6['freq_khawatir_zat_lain_freq'] == '0' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="tidak">Tidak pernah</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>


                </div>
                <h3>7. Pernahkah Anda mencoba untuk mengurangi
                    atau menghentikan penggunaan dari (ZAT
                    PERTAMA, KEDUA, DST) tetapi gagal?</h3>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>a. Tembakau (rokok, cerutu, kretek, dll.)</label>
                                <div class="d-flex">
                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan7[freq_kurang_tembakau]" value="3"
                                            {{ isset($napza->pertanyaan7['freq_kurang_tembakau']) && $napza->pertanyaan7['freq_kurang_tembakau'] == '3' ? 'checked' : '' }}>
                                        <label class="form-check-label">Pernah, tapi tidak dalam 3 bulan terakhir</label>
                                    </div>

                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan7[freq_kurang_tembakau]" value="6"
                                            {{ isset($napza->pertanyaan7['freq_kurang_tembakau']) && $napza->pertanyaan7['freq_kurang_tembakau'] == '6' ? 'checked' : '' }}>
                                        <label class="form-check-label">Pernah, dalam 3 bulan terakhir</label>
                                    </div>

                                    <div class="form-check ml-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan7[freq_kurang_tembakau]" value="0"
                                            {{ isset($napza->pertanyaan7['freq_kurang_tembakau']) && $napza->pertanyaan7['freq_kurang_tembakau'] == '0' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="tidak">Tidak pernah</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label>b. Minuman beralkohol (bir, anggur, sopi, tomi dll.)</label>
                                <div class="d-flex">
                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan7[freq_kurang_alkohol]" value="3"
                                            {{ isset($napza->pertanyaan7['freq_kurang_alkohol']) && $napza->pertanyaan7['freq_kurang_alkohol'] == '3' ? 'checked' : '' }}>
                                        <label class="form-check-label">Pernah, tapi tidak dalam 3 bulan terakhir</label>
                                    </div>

                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan7[freq_kurang_alkohol]" value="6"
                                            {{ isset($napza->pertanyaan7['freq_kurang_alkohol']) && $napza->pertanyaan7['freq_kurang_alkohol'] == '6' ? 'checked' : '' }}>
                                        <label class="form-check-label">Pernah, dalam 3 bulan terakhir</label>
                                    </div>

                                    <div class="form-check ml-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan7[freq_kurang_alkohol]" value="0"
                                            {{ isset($napza->pertanyaan7['freq_kurang_alkohol']) && $napza->pertanyaan7['freq_kurang_alkohol'] == '0' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="tidak">Tidak pernah</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label>c. Kanabis (marijuana, ganja, gelek, cimengpot, dll.)</label>
                                <div class="d-flex">
                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan7[freq_kurang_kanabis]" value="3"
                                            {{ isset($napza->pertanyaan7['freq_kurang_kanabis']) && $napza->pertanyaan7['freq_kurang_kanabis'] == '3' ? 'checked' : '' }}>
                                        <label class="form-check-label">Pernah, tapi tidak dalam 3 bulan terakhir</label>
                                    </div>

                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan7[freq_kurang_kanabis]" value="6"
                                            {{ isset($napza->pertanyaan7['freq_kurang_kanabis']) && $napza->pertanyaan7['freq_kurang_kanabis'] == '6' ? 'checked' : '' }}>
                                        <label class="form-check-label">Pernah, dalam 3 bulan terakhir</label>
                                    </div>

                                    <div class="form-check ml-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan7[freq_kurang_kanabis]" value="0"
                                            {{ isset($napza->pertanyaan7['freq_kurang_kanabis']) && $napza->pertanyaan7['freq_kurang_kanabis'] == '0' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="tidak">Tidak pernah</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label>d. Kokain (coke, crack, etc.)</label>
                                <div class="d-flex">
                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan7[freq_kurang_kokain]" value="3"
                                            {{ isset($napza->pertanyaan7['freq_kurang_kokain']) && $napza->pertanyaan7['freq_kurang_kokain'] == '3' ? 'checked' : '' }}>
                                        <label class="form-check-label">Pernah, tapi tidak dalam 3 bulan terakhir</label>
                                    </div>

                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan7[freq_kurang_kokain]" value="6"
                                            {{ isset($napza->pertanyaan7['freq_kurang_kokain']) && $napza->pertanyaan7['freq_kurang_kokain'] == '6' ? 'checked' : '' }}>
                                        <label class="form-check-label">Pernah, dalam 3 bulan terakhir</label>
                                    </div>

                                    <div class="form-check ml-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan7[freq_kurang_kokain]" value="0"
                                            {{ isset($napza->pertanyaan7['freq_kurang_kokain']) && $napza->pertanyaan7['freq_kurang_kokain'] == '0' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="tidak">Tidak pernah</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label>e. Stimulan jenis amfetamin (ekstasi, shabu, dll)</label>
                                <div class="d-flex">
                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan7[freq_kurang_stimulan_amfetamin]" value="3"
                                            {{ isset($napza->pertanyaan7['freq_kurang_stimulan_amfetamin']) && $napza->pertanyaan7['freq_kurang_stimulan_amfetamin'] == '3' ? 'checked' : '' }}>
                                        <label class="form-check-label">Pernah, tapi tidak dalam 3 bulan terakhir</label>
                                    </div>

                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan7[freq_kurang_stimulan_amfetamin]" value="6"
                                            {{ isset($napza->pertanyaan7['freq_kurang_stimulan_amfetamin']) && $napza->pertanyaan7['freq_kurang_stimulan_amfetamin'] == '6' ? 'checked' : '' }}>
                                        <label class="form-check-label">Pernah, dalam 3 bulan terakhir</label>
                                    </div>

                                    <div class="form-check ml-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan7[freq_kurang_stimulan_amfetamin]" value="0"
                                            {{ isset($napza->pertanyaan7['freq_kurang_stimulan_amfetamin']) && $napza->pertanyaan7['freq_kurang_stimulan_amfetamin'] == '0' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="tidak">Tidak pernah</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label>f. Inhalansia (lem, bensin, tiner, dll)</label>
                                <div class="d-flex">
                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan7[freq_kurang_inhalansia]" value="3"
                                            {{ isset($napza->pertanyaan7['freq_kurang_inhalansia']) && $napza->pertanyaan7['freq_kurang_inhalansia'] == '3' ? 'checked' : '' }}>
                                        <label class="form-check-label">Pernah, tapi tidak dalam 3 bulan terakhir</label>
                                    </div>

                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan7[freq_kurang_inhalansia]" value="6"
                                            {{ isset($napza->pertanyaan7['freq_kurang_inhalansia']) && $napza->pertanyaan7['freq_kurang_inhalansia'] == '6' ? 'checked' : '' }}>
                                        <label class="form-check-label">Pernah, dalam 3 bulan terakhir</label>
                                    </div>

                                    <div class="form-check ml-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan7[freq_kurang_inhalansia]" value="0"
                                            {{ isset($napza->pertanyaan7['freq_kurang_inhalansia']) && $napza->pertanyaan7['freq_kurang_inhalansia'] == '0' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="tidak">Tidak pernah</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label>g. Sedativa atau obat tidur (Benzodiazepin, Lexotan, Rohypnol, Mogadon, dll.)</label>
                                <div class="d-flex">
                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan7[freq_kurang_sedativa]" value="3"
                                            {{ isset($napza->pertanyaan7['freq_kurang_sedativa']) && $napza->pertanyaan7['freq_kurang_sedativa'] == '3' ? 'checked' : '' }}>
                                        <label class="form-check-label">Pernah, tapi tidak dalam 3 bulan terakhir</label>
                                    </div>

                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan7[freq_kurang_sedativa]" value="6"
                                            {{ isset($napza->pertanyaan7['freq_kurang_sedativa']) && $napza->pertanyaan7['freq_kurang_sedativa'] == '6' ? 'checked' : '' }}>
                                        <label class="form-check-label">Pernah, dalam 3 bulan terakhir</label>
                                    </div>

                                    <div class="form-check ml-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan7[freq_kurang_sedativa]" value="0"
                                            {{ isset($napza->pertanyaan7['freq_kurang_sedativa']) && $napza->pertanyaan7['freq_kurang_sedativa'] == '0' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="tidak">Tidak pernah</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label>h. Halusinogens (LSD, mushrooms, PCP, dll)</label>
                                <div class="d-flex">
                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan7[freq_kurang_halusinogen]" value="3"
                                            {{ isset($napza->pertanyaan7['freq_kurang_halusinogen']) && $napza->pertanyaan7['freq_kurang_halusinogen'] == '3' ? 'checked' : '' }}>
                                        <label class="form-check-label">Pernah, tapi tidak dalam 3 bulan terakhir</label>
                                    </div>

                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan7[freq_kurang_halusinogen]" value="6"
                                            {{ isset($napza->pertanyaan7['freq_kurang_halusinogen']) && $napza->pertanyaan7['freq_kurang_halusinogen'] == '6' ? 'checked' : '' }}>
                                        <label class="form-check-label">Pernah, dalam 3 bulan terakhir</label>
                                    </div>

                                    <div class="form-check ml-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan7[freq_kurang_halusinogen]" value="0"
                                            {{ isset($napza->pertanyaan7['freq_kurang_halusinogen']) && $napza->pertanyaan7['freq_kurang_halusinogen'] == '0' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="tidak">Tidak pernah</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label>i. Opioid (heroin, morfin, metadon, kodein, dll)</label>
                                <div class="d-flex">
                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan7[freq_kurang_opioid]" value="3"
                                            {{ isset($napza->pertanyaan7['freq_kurang_opioid']) && $napza->pertanyaan7['freq_kurang_opioid'] == '3' ? 'checked' : '' }}>
                                        <label class="form-check-label">Pernah, tapi tidak dalam 3 bulan terakhir</label>
                                    </div>

                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan7[freq_kurang_opioid]" value="6"
                                            {{ isset($napza->pertanyaan7['freq_kurang_opioid']) && $napza->pertanyaan7['freq_kurang_opioid'] == '6' ? 'checked' : '' }}>
                                        <label class="form-check-label">Pernah, dalam 3 bulan terakhir</label>
                                    </div>

                                    <div class="form-check ml-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan7[freq_kurang_opioid]" value="0"
                                            {{ isset($napza->pertanyaan7['freq_kurang_opioid']) && $napza->pertanyaan7['freq_kurang_opioid'] == '0' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="tidak">Tidak pernah</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="d-flex align-items-center">
                                    <label>j. Zat-lain: sebutkan</label>
                                    <input type="text" class="form-control ml-2"
                                        name="pertanyaan7[freq_kurang_zat_lain]"
                                        value="{{ $napza->pertanyaan7['freq_kurang_zat_lain'] ?? '' }}"
                                        style="width: auto;">
                                </div>
                                <div class="d-flex mt-2">
                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan7[freq_kurang_zat_lain_freq]" value="3"
                                            {{ isset($napza->pertanyaan7['freq_kurang_zat_lain_freq']) && $napza->pertanyaan7['freq_kurang_zat_lain_freq'] == '3' ? 'checked' : '' }}>
                                        <label class="form-check-label">Pernah, tapi tidak dalam 3 bulan terakhir</label>
                                    </div>

                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan7[freq_kurang_zat_lain_freq]" value="6"
                                            {{ isset($napza->pertanyaan7['freq_kurang_zat_lain_freq']) && $napza->pertanyaan7['freq_kurang_zat_lain_freq'] == '6' ? 'checked' : '' }}>
                                        <label class="form-check-label">Pernah, dalam 3 bulan terakhir</label>
                                    </div>

                                    <div class="form-check ml-3">
                                        <input type="radio" class="form-check-input"
                                            name="pertanyaan7[freq_kurang_zat_lain_freq]" value="0"
                                            {{ isset($napza->pertanyaan7['freq_kurang_zat_lain_freq']) && $napza->pertanyaan7['freq_kurang_zat_lain_freq'] == '0' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="tidak">Tidak pernah</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>


                </div>
                <h3>8. Pernahkah Anda menggunakan zat dengan
                    cara disuntik? (HANYA PENGGUNAAN NON
                    MEDIS)?</h3>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Pernahkah Anda menggunakan zat dengan
                                    cara disuntik? (HANYA PENGGUNAAN NON
                                    MEDIS)</label>
                                <div class="d-flex">
                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input" name="pertanyaan8[non_medis]"
                                            value="2"
                                            {{ isset($napza->pertanyaan8['non_medis']) && $napza->pertanyaan8['non_medis'] == '2' ? 'checked' : '' }}>
                                        <label class="form-check-label">Ya, dalam 3 bulan terakhir</label>
                                    </div>

                                    <div class="form-check mr-3">
                                        <input type="radio" class="form-check-input" name="pertanyaan8[non_medis]"
                                            value="3"
                                            {{ isset($napza->pertanyaan8['non_medis']) && $napza->pertanyaan8['non_medis'] == '3' ? 'checked' : '' }}>
                                        <label class="form-check-label">Ya, tapi tidak dalam 3 bulan terakhir</label>
                                    </div>

                                    <div class="form-check ml-3">
                                        <input type="radio" class="form-check-input" name="pertanyaan8[non_medis]"
                                            value="0"
                                            {{ isset($napza->pertanyaan8['non_medis']) && $napza->pertanyaan8['non_medis'] == '0' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="tidak">Tidak pernah</label>
                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>


                </div>
            </div>
        </div>
        <h3>Skor SSI untuk Setiap Zat</h3>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Zat</th>
                        <th>Skor SSI</th>
                        <th>Tidak ada intervensi</th>
                        <th>Intervensi singkat</th>
                        <th>Pengobatan yang lebih intensif *</th>

                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Tembakau</td>
                        <td id="score_tembakau">0</td>
                        <td>0 - 3</td>
                        <td>4- 26</td>
                        <td>27 +</td>

                    </tr>
                    <tr>
                        <td>Minuman Beralkohol</td>
                        <td id="score_alkohol">0</td>
                        <td>0 - 10</td>
                        <td>11-26</td>
                        <td>27 +</td>
                    </tr>
                    <tr>
                        <td>Kanabis</td>
                        <td id="score_kanabis">0</td>
                        <td>0 - 3</td>
                        <td>4- 26</td>
                        <td>27 +</td>
                    </tr>
                    <tr>
                        <td>Kokain</td>
                        <td id="score_kokain">0</td>
                        <td>0 - 3</td>
                        <td>4- 26</td>
                        <td>27 +</td>
                    </tr>
                    <tr>
                        <td>Stimulan</td>
                        <td id="score_stimulan">0</td>
                        <td>0 - 3</td>
                        <td>4- 26</td>
                        <td>27 +</td>
                    </tr>
                    <tr>
                        <td>Inhalansia</td>
                        <td id="score_inhalansia">0</td>
                        <td>0 - 3</td>
                        <td>4- 26</td>
                        <td>27 +</td>
                    </tr>
                    <tr>
                        <td>Sedativa</td>
                        <td id="score_sedativa">0</td>
                        <td>0 - 3</td>
                        <td>4- 26</td>
                        <td>27 +</td>
                    </tr>
                    <tr>
                        <td>Halusinogen</td>
                        <td id="score_halusinogen">0</td>
                        <td>0 - 3</td>
                        <td>4- 26</td>
                        <td>27 +</td>
                    </tr>
                    <tr>
                        <td>Opioid</td>
                        <td id="score_opioid">0</td>
                        <td>0 - 3</td>
                        <td>4- 26</td>
                        <td>27 +</td>
                    </tr>
                    <tr>
                        <td>Zat Lain</td>
                        <td id="score_zatlain">0</td>
                        <td>0 - 3</td>
                        <td>4- 26</td>
                        <td>27 +</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="form-group">
            <div class="col-md-12">
                <label for="kesimpulan" style="color: rgb(19, 11, 241);">Kesimpulan</label>
                <textarea class="form-control" id="kesimpulan" name="kesimpulan" placeholder="Kesimpulan">{{ old('kesimpulan', $napza->kesimpulan ?? '') }}</textarea>
            </div>
        </div>


        <div class="text-right mt-4">
            @if (isset($napza) && $napza)
                <a href="{{ route('napza.mtbs.admin') }}" type="button" class="btn btn-secondary mr-2"
                    style="font-size: 20px">Kembali</a>
            @else
                <a href="{{ route('skrining.ilp') }}" type="button" class="btn btn-secondary mr-2"
                    style="font-size: 20px">Kembali</a>
            @endif


            <button type="submit" class="btn btn-primary" style="font-size: 20px">Kirim</button>
        </div>

    </form>

    {{-- <script>
        // Fungsi untuk menghitung skor SSI berdasarkan input yang ada
        function calculateSSI() {
            // Daftar zat dan aturan P5 (untuk Tembakau, P5 diabaikan)
            const zatInputs = [{
                    name: 'tembakau',
                    skipP5: true
                }, // Tembakau tidak memiliki P5
                {
                    name: 'alkohol',
                    skipP5: false
                },
                {
                    name: 'kanabis',
                    skipP5: false
                },
                {
                    name: 'kokain',
                    skipP5: false
                },
                {
                    name: 'stimulan',
                    skipP5: false
                },
                {
                    name: 'inhalansia',
                    skipP5: false
                },
                {
                    name: 'sedativa',
                    skipP5: false
                },
                {
                    name: 'halusinogen',
                    skipP5: false
                },
                {
                    name: 'opioid',
                    skipP5: false
                },
                {
                    name: 'zatlain',
                    skipP5: false
                }
            ];

            // Loop melalui setiap zat untuk menghitung skor total
            zatInputs.forEach(zat => {
                let totalScore = 0;

                // Loop untuk menjumlahkan nilai dari P2 sampai P7
                for (let i = 2; i <= 7; i++) {
                    // Lewati P5 jika zat tidak memiliki kode P5 (khusus tembakau)
                    if (i === 5 && zat.skipP5) continue;

                    // Mengambil nilai input yang dipilih untuk setiap pertanyaan (P2 hingga P7)
                    const input = document.querySelector(`input[name="freq_${zat.name}_P${i}"]:checked`);
                    if (input) {
                        totalScore += parseInt(input.value);
                    }
                }

                // Menampilkan skor total pada tabel atau bagian yang sesuai
                const scoreElement = document.getElementById(`score_${zat.name}`);
                if (scoreElement) { // Cek jika elemen ditemukan
                    scoreElement.innerText = totalScore;
                }
            });
        }

        // Menjalankan perhitungan ulang setiap kali input radio berubah
        document.querySelectorAll('input[type="radio"]').forEach(input => {
            input.addEventListener('change', calculateSSI);
        });
    </script> --}}


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
            });
            $('#pasien').trigger('change');
        });
    </script>
@endsection
