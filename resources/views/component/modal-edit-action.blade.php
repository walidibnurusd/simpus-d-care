<!-- Modal Add Action -->
<div class="modal fade" style="z-index: 1050;" id="editActionModal{{ $action->id }}" tabindex="-1"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                @if ($routeName === 'action.index')
                    <h5 class="modal-title" id="exampleModalLabel">TINDAKAN POLI UMUM</h5>
                @elseif ($routeName === 'action.index.gigi')
                    <h5 class="modal-title" id="exampleModalLabel">TINDAKAN POLI GIGI</h5>
                @else
                    <h5 class="modal-title" id="exampleModalLabel">TINDAKAN UGD</h5>
                @endif
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form id="addPatientForm" action="{{ route('action.update', $action->id) }}" method="POST"
                    class="px-3">
                    @csrf
                    <div class="row">
                        <div class="col-4">
                            <h5>Detail Pasien</h5>


                            <div id="patientDetailsEdit" style=" margin-top: 10px; padding: 10px; border-radius: 5px;">
                                <p><strong>N I K</strong> : <span id="NIK">{{ $action->patient->nik }}</span></p>
                                <p><strong>Nama Pasien</strong> : <span
                                        id="Name">{{ $action->patient->name }}</span></p>
                                {{-- <p><strong>J.Kelamin</strong> : <span id="Gender">{{ $action->patient->genderName->name }}</span></p> --}}
                                <p><strong>Umur</strong> : <span id="Age"></span>
                                    {{ \Carbon\Carbon::parse($action->patient->dob)->age }}</p>
                                <p><strong>Telepon/WA</strong> : <span
                                        id="Phone">{{ $action->patient->phone }}</span></p>
                                <p><strong>Alamat</strong> : <span id="Address">{{ $action->patient->address }}</span>
                                </p>
                                <p><strong>Darah</strong> : <span
                                        id="Blood">{{ $action->patient->blood_type }}</span></p>
                                {{-- <p><strong>Pendidikan</strong> : <span id="Education">{{ $action->patient->educations->name }}</span></p> --}}
                                {{-- <p><strong>Pekerjaan</strong> : <span id="Job"></span>{{ $action->patient->occupations->name }}</p> --}}
                                <p><strong>Nomor RM</strong> : <span id="RmNumber">{{ $action->patient->no_rm }}</span>
                                </p>
                            </div>

                        </div>

                        <div class="row col-8">
                            <div class="col-12">
                                <div class="row g-2">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="nik">Cari Pasien</label>
                                            <div class="input-group">
                                                <input readonly type="text" class="form-control" id="nikEdit"
                                                    name="nikEdit" placeholder="NIK" required>
                                                <div class="input-group-append">
                                                    <button class="btn btn-primary" type="button" id="btnCariNIK"
                                                        data-bs-toggle="modal" data-bs-target="#modalPasienEdit">
                                                        Cari
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="tanggal">Tanggal</label>
                                            <input type="text" class="form-control flatpickr-input" id="tanggal"
                                                name="tanggal" value="{{ $action->tanggal }}"
                                                placeholder="Pilih Tanggal" required>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="doctor">Dokter</label>
                                            <select class="form-control" id="doctor" name="doctor" required>
                                                <option value="" disabled selected>Pilih Dokter</option>
                                                @foreach ($dokter as $item)
                                                    <option value="{{ $item['name'] }}"
                                                        {{ $action->doctor == $item['name'] ? 'selected' : '' }}>
                                                        {{ $item['name'] }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="kunjungan">Kunjungan</label>
                                            <select class="form-control" id="kunjungan" name="kunjungan" required>
                                                <option value="" disabled
                                                    {{ empty($action->kunjungan) ? 'selected' : '' }}>Pilih Jenis
                                                    Kunjungan</option>
                                                <option value="baru"
                                                    {{ $action->kunjungan == 'baru' ? 'selected' : '' }}>Baru</option>
                                                <option value="lama"
                                                    {{ $action->kunjungan == 'lama' ? 'selected' : '' }}>Lama</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="row g-2">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="kartu">Kartu</label>
                                            <select class="form-control" id="kartu" name="kartu" required>
                                                <option value="" disabled
                                                    {{ empty($action->kartu) ? 'selected' : '' }}>Pilih Jenis Kartu
                                                </option>
                                                <option value="umum"
                                                    {{ $action->kartu == 'umum' ? 'selected' : '' }}>Umum</option>
                                                <option value="akses"
                                                    {{ $action->kartu == 'akses' ? 'selected' : '' }}>AKSES</option>
                                                <option value="bpjs"
                                                    {{ $action->kartu == 'bpjs' ? 'selected' : '' }}>BPJS-KIS_JKM
                                                </option>
                                                <option value="gratis_jkd"
                                                    {{ $action->kartu == 'gratis_jkd' ? 'selected' : '' }}>Gratis-JKD
                                                </option>
                                                <option value="bpjs_mandiri"
                                                    {{ $action->kartu == 'bpjs_mandiri' ? 'selected' : '' }}>
                                                    BPJS-Mandiri
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="nomor">Nomor Kartu</label>
                                            <input type="text" class="form-control" id="nomor" name="nomor"
                                                placeholder="Masukkan Nomor" value="{{ $action->nomor }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="wilayah_faskes">Wilayah Faskes</label>
                                            <select class="form-control" id="wilayah_faskes" name="faskes" required>
                                                <option value="" disabled
                                                    {{ empty($action->faskes) ? 'selected' : '' }}>Pilih Wilayah Faskes
                                                </option>
                                                <option value="ya"
                                                    {{ $action->faskes == 'ya' ? 'selected' : '' }}>Ya</option>
                                                <option value="tidak"
                                                    {{ $action->faskes == 'tidak' ? 'selected' : '' }}>Tidak</option>

                                            </select>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div style="display: flex; align-items: center; text-align: center;">
                                <hr style="flex: 1; border: none; border-top: 1px solid #ccc;">
                                <span style="margin: 0 10px; white-space: nowrap;">Pemeriksaan</span>
                                <hr style="flex: 1; border: none; border-top: 1px solid #ccc;">
                            </div>

                            <div class="col-12">
                                <div class="row g-2">
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="sistol">Sistol</label>
                                            <input type="text" class="form-control" id="sistol" name="sistol"
                                                placeholder="Masukkan Sistol" required value="{{ $action->sistol }}">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="diastol">Diastol</label>
                                            <input type="text" class="form-control" id="diastol" name="diastol"
                                                placeholder="Masukkan Diastol" required
                                                value="{{ $action->diastol }}">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="berat_badan">Berat Badan</label>
                                            <input type="text" class="form-control" id="berat_badan"
                                                name="beratBadan" placeholder="Masukkan Berat Badan" required
                                                value="{{ $action->beratBadan }}">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="tinggi_badan">Tinggi Badan</label>
                                            <input type="text" class="form-control" id="tinggi_badan"
                                                name="tinggiBadan" placeholder="Masukkan Tinggi Badan" required
                                                value="{{ $action->tinggiBadan }}">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="ling_pinggang">Ling. Pinggang</label>
                                            <input type="text" class="form-control" id="ling_pinggang"
                                                name="lingkarPinggang" placeholder="Masukkan Ling. Pinggang" required
                                                value="{{ $action->lingkarPinggang }}">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="gula">Gula</label>
                                            <input type="text" class="form-control" id="gula" name="gula"
                                                placeholder="Masukkan Gula" required value="{{ $action->gula }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @if ($action->tipe == 'poli-umum')
                                <div class="container">
                                    <div class="row g-2">
                                        <div class="col-md-2 ">
                                            <label for="merokok" style="color: green;">Merokok</label>
                                            <select class="form-control" id="merokok" name="merokok">
                                                <option value="" disabled
                                                    {{ empty($action->merokok) ? 'selected' : '' }}>pilih</option>
                                                <option value="ya"
                                                    {{ $action->merokok == 'ya' ? 'selected' : '' }}>Ya
                                                </option>
                                                <option value="tidak"
                                                    {{ $action->merokok == 'tidak' ? 'selected' : '' }}>Tidak</option>
                                            </select>
                                        </div>
                                        <div class="col-md-2 ">
                                            <label for="aktivitas_fisik" style="color: green;">Aktivitas Fisik</label>
                                            <select class="form-control" id="aktivitas_fisik" name="fisik">
                                                <option value="" disabled
                                                    {{ empty($action->fisik) ? 'selected' : '' }}>pilih</option>
                                                <option value="aktif"
                                                    {{ $action->fisik == 'aktif' ? 'selected' : '' }}>
                                                    Aktif</option>
                                                <option value="tidak_aktif"
                                                    {{ $action->fisik == 'tidak_aktif' ? 'selected' : '' }}>Tidak Aktif
                                                </option>
                                            </select>
                                        </div>
                                        <div class="col-md-2 ">
                                            <label for="gula" style="color: green;">Gula Berlebih</label>
                                            <select class="form-control" id="gula" name="gula_lebih">
                                                <option value="" disabled
                                                    {{ empty($action->gula_lebih) ? 'selected' : '' }}>pilih</option>
                                                <option value="ya"
                                                    {{ $action->gula_lebih == 'ya' ? 'selected' : '' }}>Ya</option>
                                                <option value="tidak"
                                                    {{ $action->gula_lebih == 'tidak' ? 'selected' : '' }}>Tidak
                                                </option>
                                            </select>
                                        </div>
                                        <div class="col-md-2 ">
                                            <label for="lemak" style="color: green;">Lemak Berlebih</label>
                                            <select class="form-control" id="lemak" name="lemak">
                                                <option value="" disabled
                                                    {{ empty($action->lemak) ? 'selected' : '' }}>pilih</option>
                                                <option value="ya" {{ $action->lemak == 'ya' ? 'selected' : '' }}>
                                                    Ya
                                                </option>
                                                <option value="tidak"
                                                    {{ $action->lemak == 'tidak' ? 'selected' : '' }}>
                                                    Tidak</option>
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <label for="garam" style="color: green;">Garam Berlebih</label>
                                            <select class="form-control" id="garam" name="garam">
                                                <option value="" disabled
                                                    {{ old('garam', $action->garam) == '' ? 'selected' : '' }}>pilih
                                                </option>
                                                <option value="ya"
                                                    {{ old('garam', $action->garam) == 'ya' ? 'selected' : '' }}>Ya
                                                </option>
                                                <option value="tidak"
                                                    {{ old('garam', $action->garam) == 'tidak' ? 'selected' : '' }}>
                                                    Tidak
                                                </option>
                                            </select>
                                        </div>

                                        <div class="col-md-2">
                                            <label for="buah_sayur" style="color: green;">Mkn Buah/Sayur</label>
                                            <select class="form-control" id="buah_sayur" name="buah_sayur">
                                                <option value="" disabled
                                                    {{ old('buah_sayur', $action->buah_sayur) == '' ? 'selected' : '' }}>
                                                    pilih</option>
                                                <option value="cukup"
                                                    {{ old('buah_sayur', $action->buah_sayur) == 'cukup' ? 'selected' : '' }}>
                                                    Cukup</option>
                                                <option value="kurang"
                                                    {{ old('buah_sayur', $action->buah_sayur) == 'kurang' ? 'selected' : '' }}>
                                                    Kurang</option>
                                            </select>
                                        </div>

                                    </div>
                                </div>
                                <div class="container mb-4">
                                    <div class="row g-2 mt-2">
                                        <div class="col-md-2">
                                            <label for="alkohol" style="color: green;">Minum Alkohol</label>
                                            <select class="form-control" id="alkohol" name="alkohol">
                                                <option value="" disabled
                                                    {{ old('alkohol', $action->alkohol) == '' ? 'selected' : '' }}>
                                                    pilih
                                                </option>
                                                <option value="ya"
                                                    {{ old('alkohol', $action->alkohol) == 'ya' ? 'selected' : '' }}>Ya
                                                </option>
                                                <option value="tidak"
                                                    {{ old('alkohol', $action->alkohol) == 'tidak' ? 'selected' : '' }}>
                                                    Tidak</option>
                                            </select>
                                        </div>

                                        <div class="col-md-2">
                                            <label for="kondisi_hidup" style="color: green;">Kondisi Hidup</label>
                                            <select class="form-control" id="kondisi_hidup" name="hidup">
                                                <option value="" disabled
                                                    {{ old('hidup', $action->hidup) == '' ? 'selected' : '' }}>pilih
                                                </option>
                                                <option value="ya"
                                                    {{ old('hidup', $action->hidup) == 'ya' ? 'selected' : '' }}>Ya
                                                </option>
                                                <option value="tidak"
                                                    {{ old('hidup', $action->hidup) == 'tidak' ? 'selected' : '' }}>
                                                    Tidak
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <hr>
                                <div class="container">
                                    <div class="row g-2 mt-2">
                                        <!-- Hasil IVA -->
                                        <div class="col-md-3">
                                            <label for="alkohol" style="color: rgb(128, 87, 0);">Hasil IVA</label>
                                            <select class="form-control" id="alkohol" name="hasil_iva">
                                                <option value="" disabled
                                                    {{ old('hasil_iva', $action->hasil_iva ?? '') == '' ? 'selected' : '' }}>
                                                    pilih</option>
                                                <option value="positif"
                                                    {{ old('hasil_iva', $action->hasil_iva ?? '') == 'positif' ? 'selected' : '' }}>
                                                    Positif</option>
                                                <option value="negatif"
                                                    {{ old('hasil_iva', $action->hasil_iva ?? '') == 'negatif' ? 'selected' : '' }}>
                                                    Negatif</option>
                                                <option value="kanker"
                                                    {{ old('hasil_iva', $action->hasil_iva ?? '') == 'kanker' ? 'selected' : '' }}>
                                                    Curiga Kanker</option>
                                            </select>
                                        </div>

                                        <!-- Tindak Lanjut IVA -->
                                        <div class="col-md-3">
                                            <label for="tindak_iva" style="color: rgb(128, 87, 0);">Tindak Lanjut
                                                IVA</label>
                                            <select class="form-control" id="tindak_iva" name="tindak_iva">
                                                <option value="" disabled
                                                    {{ old('tindak_iva', $action->tindak_iva ?? '') == '' ? 'selected' : '' }}>
                                                    pilih</option>
                                                <option value="krioterapi"
                                                    {{ old('tindak_iva', $action->tindak_iva ?? '') == 'krioterapi' ? 'selected' : '' }}>
                                                    KRIOTERAPI</option>
                                                <option value="rujuk"
                                                    {{ old('tindak_iva', $action->tindak_iva ?? '') == 'rujuk' ? 'selected' : '' }}>
                                                    RUJUK</option>
                                            </select>
                                        </div>

                                        <!-- Hasil SADANIS -->
                                        <div class="col-md-3">
                                            <label for="hasil_sadanis" style="color: rgb(128, 87, 0);">Hasil
                                                SADANIS</label>
                                            <select class="form-control" id="hasil_sadanis" name="hasil_sadanis">
                                                <option value="" disabled
                                                    {{ old('hasil_sadanis', $action->hasil_sadanis ?? '') == '' ? 'selected' : '' }}>
                                                    pilih</option>
                                                <option value="benjolan"
                                                    {{ old('hasil_sadanis', $action->hasil_sadanis ?? '') == 'benjolan' ? 'selected' : '' }}>
                                                    Benjolan</option>
                                                <option value="tidak"
                                                    {{ old('hasil_sadanis', $action->hasil_sadanis ?? '') == 'tidak' ? 'selected' : '' }}>
                                                    Tidak ada Benjolan</option>
                                                <option value="kanker"
                                                    {{ old('hasil_sadanis', $action->hasil_sadanis ?? '') == 'kanker' ? 'selected' : '' }}>
                                                    Curiga Kanker</option>
                                            </select>
                                        </div>

                                        <!-- Tindak Lanjut SADANIS -->
                                        <div class="col-md-3">
                                            <label for="tindak_sadanis" style="color: rgb(128, 87, 0);">Tindak Lanjut
                                                SADANIS</label>
                                            <select class="form-control" id="tindak_sadanis" name="tindak_sadanis">
                                                <option value="" disabled
                                                    {{ old('tindak_sadanis', $action->tindak_sadanis ?? '') == '' ? 'selected' : '' }}>
                                                    pilih</option>
                                                <option value="rujuk"
                                                    {{ old('tindak_sadanis', $action->tindak_sadanis ?? '') == 'rujuk' ? 'selected' : '' }}>
                                                    RUJUK</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="container">
                                    <div class="row g-2 mt-2">
                                        <!-- Konseling -->
                                        <div class="col-md-3">
                                            <label for="konseling" style="color: green;">Konseling</label>
                                            <select class="form-control" id="konseling" name="konseling">
                                                <option value="" disabled
                                                    {{ old('konseling', $action->konseling ?? '') == '' ? 'selected' : '' }}>
                                                    pilih</option>
                                                <option value="konseling1"
                                                    {{ old('konseling', $action->konseling ?? '') == 'konseling1' ? 'selected' : '' }}>
                                                    Konseling1</option>
                                                <option value="konseling2"
                                                    {{ old('konseling', $action->konseling ?? '') == 'konseling2' ? 'selected' : '' }}>
                                                    Konseling2</option>
                                                <option value="konseling3"
                                                    {{ old('konseling', $action->konseling ?? '') == 'konseling3' ? 'selected' : '' }}>
                                                    Konseling3</option>
                                                <option value="konseling4"
                                                    {{ old('konseling', $action->konseling ?? '') == 'konseling4' ? 'selected' : '' }}>
                                                    Konseling4</option>
                                                <option value="konseling5"
                                                    {{ old('konseling', $action->konseling ?? '') == 'konseling5' ? 'selected' : '' }}>
                                                    Konseling5</option>
                                                <option value="konseling6"
                                                    {{ old('konseling', $action->konseling ?? '') == 'konseling6' ? 'selected' : '' }}>
                                                    Konseling6</option>
                                            </select>
                                        </div>

                                        <!-- CAR -->
                                        <div class="col-md-3">
                                            <label for="car" style="color: green;">CAR</label>
                                            <select class="form-control" id="car" name="car">
                                                <option value="" disabled
                                                    {{ old('car', $action->car ?? '') == '' ? 'selected' : '' }}>pilih
                                                </option>
                                                <option value="car3"
                                                    {{ old('car', $action->car ?? '') == 'car3' ? 'selected' : '' }}>
                                                    CAR3
                                                </option>
                                                <option value="car6"
                                                    {{ old('car', $action->car ?? '') == 'car6' ? 'selected' : '' }}>
                                                    CAR6
                                                </option>
                                                <option value="car9"
                                                    {{ old('car', $action->car ?? '') == 'car9' ? 'selected' : '' }}>
                                                    CAR9
                                                </option>
                                            </select>
                                        </div>

                                        <!-- Rujuk UBM -->
                                        <div class="col-md-3">
                                            <label for="rujuk_ubm" style="color: green;">RUJUK UBM</label>
                                            <select class="form-control" id="rujuk_ubm" name="rujuk_ubm">
                                                <option value="" disabled
                                                    {{ old('rujuk_ubm', $action->rujuk_ubm ?? '') == '' ? 'selected' : '' }}>
                                                    pilih</option>
                                                <option value="ya"
                                                    {{ old('rujuk_ubm', $action->rujuk_ubm ?? '') == 'ya' ? 'selected' : '' }}>
                                                    Ya</option>
                                                <option value="tidak"
                                                    {{ old('rujuk_ubm', $action->rujuk_ubm ?? '') == 'tidak' ? 'selected' : '' }}>
                                                    Tidak</option>
                                            </select>
                                        </div>

                                        <!-- Kondisi -->
                                        <div class="col-md-3">
                                            <label for="kondisi" style="color: green;">KONDISI</label>
                                            <select class="form-control" id="kondisi" name="kondisi">
                                                <option value="" disabled
                                                    {{ old('kondisi', $action->kondisi ?? '') == '' ? 'selected' : '' }}>
                                                    pilih</option>
                                                <option value="sukses"
                                                    {{ old('kondisi', $action->kondisi ?? '') == 'sukses' ? 'selected' : '' }}>
                                                    Sukses</option>
                                                <option value="kambuh"
                                                    {{ old('kondisi', $action->kondisi ?? '') == 'kambuh' ? 'selected' : '' }}>
                                                    Kambuh</option>
                                                <option value="do"
                                                    {{ old('kondisi', $action->kondisi ?? '') == 'do' ? 'selected' : '' }}>
                                                    DO</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="container">
                                    <div class="row g-2 mt-2">
                                        <!-- Konseling Edukasi Kesehatan -->
                                        <div class="col-md-3">
                                            <label for="edukasi" style="color: rgb(22, 24, 22);">Konseling Edukasi
                                                Kesehatan</label>
                                            <select class="form-control" id="edukasi" name="edukasi">
                                                <option value="" disabled
                                                    {{ old('edukasi', $action->edukasi ?? '') == '' ? 'selected' : '' }}>
                                                    pilih</option>
                                                <option value="gizi"
                                                    {{ old('edukasi', $action->edukasi ?? '') == 'gizi' ? 'selected' : '' }}>
                                                    Gizi</option>
                                                <option value="aktifitas_fisik"
                                                    {{ old('edukasi', $action->edukasi ?? '') == 'aktifitas_fisik' ? 'selected' : '' }}>
                                                    Aktifitas Fisik</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div style="display: flex; align-items: center; text-align: center;">
                                    <hr style="flex: 1; border: none; border-top: 1px solid #ccc;">
                                    <span style="margin: 0 10px; white-space: nowrap;">Pemeriksaan Fisik</span>
                                    <hr style="flex: 1; border: none; border-top: 1px solid #ccc;">
                                </div>
                                <div class="container">
                                    <div class="row g-2">

                                        <!-- Mata-Anemia -->
                                        <div class="col-md-2">
                                            <label for="mata_anemia" style="color: green;">Mata-Anemia</label>
                                            <select class="form-control" id="mata_anemia" name="mata_anemia">
                                                <option value="" disabled
                                                    {{ old('mata_anemia', $action->mata_anemia ?? '') == '' ? 'selected' : '' }}>
                                                    pilih</option>
                                                <option value="ya"
                                                    {{ old('mata_anemia', $action->mata_anemia ?? '') == 'ya' ? 'selected' : '' }}>
                                                    Ya</option>
                                                <option value="tidak"
                                                    {{ old('mata_anemia', $action->mata_anemia ?? '') == 'tidak' ? 'selected' : '' }}>
                                                    Tidak</option>
                                            </select>
                                        </div>
                                        <!-- Mata-Pupil -->
                                        <div class="col-md-2">
                                            <label for="pupil" style="color: green;">Mata-Pupil</label>
                                            <select class="form-control" id="pupil" name="pupil">
                                                <option value="" disabled
                                                    {{ old('pupil', $action->pupil ?? '') == '' ? 'selected' : '' }}>
                                                    pilih
                                                </option>
                                                <option value="isokor"
                                                    {{ old('pupil', $action->pupil ?? '') == 'isokor' ? 'selected' : '' }}>
                                                    Isokor</option>
                                                <option value="anisokor"
                                                    {{ old('pupil', $action->pupil ?? '') == 'anisokor' ? 'selected' : '' }}>
                                                    Anisokor</option>
                                            </select>
                                        </div>
                                        <!-- Mata-Ikterus -->
                                        <div class="col-md-2">
                                            <label for="ikterus" style="color: green;">Mata-Ikterus</label>
                                            <select class="form-control" id="ikterus" name="ikterus">
                                                <option value="" disabled
                                                    {{ old('ikterus', $action->ikterus ?? '') == '' ? 'selected' : '' }}>
                                                    pilih</option>
                                                <option value="ya"
                                                    {{ old('ikterus', $action->ikterus ?? '') == 'ya' ? 'selected' : '' }}>
                                                    Ya</option>
                                                <option value="tidak"
                                                    {{ old('ikterus', $action->ikterus ?? '') == 'tidak' ? 'selected' : '' }}>
                                                    Tidak</option>
                                            </select>
                                        </div>
                                        <!-- Mata-Udem Palpebral -->
                                        <div class="col-md-2">
                                            <label for="udem_palpebral" style="color: green;">Mata-Udem
                                                Palpebral</label>
                                            <select class="form-control" id="udem_palpebral" name="udem_palpebral">
                                                <option value="" disabled
                                                    {{ old('udem_palpebral', $action->udem_palpebral ?? '') == '' ? 'selected' : '' }}>
                                                    pilih</option>
                                                <option value="ya"
                                                    {{ old('udem_palpebral', $action->udem_palpebral ?? '') == 'ya' ? 'selected' : '' }}>
                                                    Ya</option>
                                                <option value="tidak"
                                                    {{ old('udem_palpebral', $action->udem_palpebral ?? '') == 'tidak' ? 'selected' : '' }}>
                                                    Tidak</option>
                                            </select>
                                        </div>
                                        <!-- Abdomen-Nyeri Tekan -->
                                        <div class="col-md-2">
                                            <label for="nyeri_tekan" style="color: green;">Abdomen-Nyeri Tekan</label>
                                            <select class="form-control" id="nyeri_tekan" name="nyeri_tekan">
                                                <option value="" disabled
                                                    {{ old('nyeri_tekan', $action->nyeri_tekan ?? '') == '' ? 'selected' : '' }}>
                                                    pilih</option>
                                                <option value="ya"
                                                    {{ old('nyeri_tekan', $action->nyeri_tekan ?? '') == 'ya' ? 'selected' : '' }}>
                                                    Ya</option>
                                                <option value="tidak"
                                                    {{ old('nyeri_tekan', $action->nyeri_tekan ?? '') == 'tidak' ? 'selected' : '' }}>
                                                    Tidak</option>
                                            </select>
                                        </div>
                                        <!-- Abdomen-Peristaltik -->
                                        <div class="col-md-2">
                                            <label for="peristaltik" style="color: green;">Abdomen-Peristaltik</label>
                                            <select class="form-control" id="peristaltik" name="peristaltik">
                                                <option value="" disabled
                                                    {{ old('peristaltik', $action->peristaltik ?? '') == '' ? 'selected' : '' }}>
                                                    pilih</option>
                                                <option value="normal"
                                                    {{ old('peristaltik', $action->peristaltik ?? '') == 'normal' ? 'selected' : '' }}>
                                                    Normal</option>
                                                <option value="meningkat"
                                                    {{ old('peristaltik', $action->peristaltik ?? '') == 'meningkat' ? 'selected' : '' }}>
                                                    Meningkat</option>
                                                <option value="menurun"
                                                    {{ old('peristaltik', $action->peristaltik ?? '') == 'menurun' ? 'selected' : '' }}>
                                                    Menurun</option>
                                            </select>
                                        </div>
                                        <!-- Abdomen-Ascites -->
                                        <div class="col-md-2">
                                            <label for="ascites" style="color: green;">Abdomen-Ascites</label>
                                            <select class="form-control" id="ascites" name="ascites">
                                                <option value="" disabled
                                                    {{ old('ascites', $action->ascites ?? '') == '' ? 'selected' : '' }}>
                                                    pilih</option>
                                                <option value="ya"
                                                    {{ old('ascites', $action->ascites ?? '') == 'ya' ? 'selected' : '' }}>
                                                    Ya</option>
                                                <option value="tidak"
                                                    {{ old('ascites', $action->ascites ?? '') == 'tidak' ? 'selected' : '' }}>
                                                    Tidak</option>
                                            </select>
                                        </div>

                                        <div class="col-md-2">
                                            <label for="lokasi_abdomen" style="color: green;">Abdomen-Lokasi</label>
                                            <input type="text" class="form-control" id="lokasi_abdomen"
                                                name="lokasi_abdomen"
                                                value="{{ old('lokasi_abdomen', $action->lokasi_abdomen ?? '') }}"
                                                placeholder="Lokasi Abdomen">
                                        </div>
                                        <div class="col-md-2">
                                            <label for="thorax" style="color: green;">Thorax</label>
                                            <select class="form-control" id="thorax" name="thorax">
                                                <option value="" disabled
                                                    {{ old('thorax', $action->thorax ?? '') == '' ? 'selected' : '' }}>
                                                    pilih</option>
                                                <option value="simetris"
                                                    {{ old('thorax', $action->thorax ?? '') == 'simetris' ? 'selected' : '' }}>
                                                    Simetris</option>
                                                <option value="asimetris"
                                                    {{ old('thorax', $action->thorax ?? '') == 'asimetris' ? 'selected' : '' }}>
                                                    Asimetris</option>
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <label for="thorax_bj" style="color: green;">Thorax-BJ I/II</label>
                                            <select class="form-control" id="thorax_bj" name="thorax_bj">
                                                <option value="" disabled
                                                    {{ old('thorax_bj', $action->thorax_bj ?? '') == '' ? 'selected' : '' }}>
                                                    pilih</option>
                                                <option value="regular"
                                                    {{ old('thorax_bj', $action->thorax_bj ?? '') == 'regular' ? 'selected' : '' }}>
                                                    Regular</option>
                                                <option value="irregular"
                                                    {{ old('thorax_bj', $action->thorax_bj ?? '') == 'irregular' ? 'selected' : '' }}>
                                                    Irregular</option>
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <label for="paru" style="color: green;">Thorax-Paru</label>
                                            <input type="text" class="form-control" id="paru" name="paru"
                                                value="{{ old('paru', $action->paru ?? '') }}" placeholder="Paru">
                                        </div>
                                        <div class="col-md-2">
                                            <label for="suara_nafas" style="color: green;">Thorax-Suara Nafas</label>
                                            <input type="text" class="form-control" id="suara_nafas"
                                                name="suara_nafas"
                                                value="{{ old('suara_nafas', $action->suara_nafas ?? '') }}"
                                                placeholder="Suara Nafas">
                                        </div>
                                        <div class="col-md-2">
                                            <label for="ronchi" style="color: green;">Thorax-Ronchi</label>
                                            <select class="form-control" id="ronchi" name="ronchi">
                                                <option value="" disabled
                                                    {{ old('ronchi', $action->ronchi ?? '') == '' ? 'selected' : '' }}>
                                                    pilih</option>
                                                <option value="ya"
                                                    {{ old('ronchi', $action->ronchi ?? '') == 'ya' ? 'selected' : '' }}>
                                                    Ya</option>
                                                <option value="tidak"
                                                    {{ old('ronchi', $action->ronchi ?? '') == 'tidak' ? 'selected' : '' }}>
                                                    Tidak</option>
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <label for="wheezing" style="color: green;">Thorax-Wheezing</label>
                                            <select class="form-control" id="wheezing" name="wheezing">
                                                <option value="" disabled
                                                    {{ old('wheezing', $action->wheezing ?? '') == '' ? 'selected' : '' }}>
                                                    pilih</option>
                                                <option value="ya"
                                                    {{ old('wheezing', $action->wheezing ?? '') == 'ya' ? 'selected' : '' }}>
                                                    Ya</option>
                                                <option value="tidak"
                                                    {{ old('wheezing', $action->wheezing ?? '') == 'tidak' ? 'selected' : '' }}>
                                                    Tidak</option>
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <label for="ekstremitas" style="color: green;">Ekstremitas</label>
                                            <select class="form-control" id="ekstremitas" name="ekstremitas">
                                                <option value="" disabled
                                                    {{ old('ekstremitas', $action->ekstremitas ?? '') == '' ? 'selected' : '' }}>
                                                    pilih</option>
                                                <option value="hangat"
                                                    {{ old('ekstremitas', $action->ekstremitas ?? '') == 'hangat' ? 'selected' : '' }}>
                                                    Hangat</option>
                                                <option value="dingin"
                                                    {{ old('ekstremitas', $action->ekstremitas ?? '') == 'dingin' ? 'selected' : '' }}>
                                                    Dingin</option>
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <label for="edema" style="color: green;">Ekstremitas-Edema</label>
                                            <select class="form-control" id="edema" name="edema">
                                                <option value="" disabled
                                                    {{ old('edema', $action->edema ?? '') == '' ? 'selected' : '' }}>
                                                    pilih
                                                </option>
                                                <option value="ya"
                                                    {{ old('edema', $action->edema ?? '') == 'ya' ? 'selected' : '' }}>
                                                    Ya
                                                </option>
                                                <option value="tidak"
                                                    {{ old('edema', $action->edema ?? '') == 'tidak' ? 'selected' : '' }}>
                                                    Tidak</option>
                                                <option value="lainnya"
                                                    {{ old('edema', $action->edema ?? '') == 'lainnya' ? 'selected' : '' }}>
                                                    Lainnya</option>
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <label for="tonsil" style="color: green;">THT-Tonsil</label>
                                            <input type="text" class="form-control" id="tonsil" name="tonsil"
                                                value="{{ old('tonsil', $action->tonsil ?? '') }}"
                                                placeholder="Tonsil">
                                        </div>
                                        <div class="col-md-2">
                                            <label for="fharing" style="color: green;">THT-Fharing</label>
                                            <input type="text" class="form-control" id="fharing" name="fharing"
                                                value="{{ old('fharing', $action->fharing ?? '') }}"
                                                placeholder="Fharing">
                                        </div>
                                        <div class="col-md-2">
                                            <label for="kelenjar" style="color: green;">Leher-Pembesaran
                                                Kelenjar</label>
                                            <input type="text" class="form-control" id="kelenjar"
                                                name="kelenjar"
                                                value="{{ old('kelenjar', $action->kelenjar ?? '') }}"
                                                placeholder="Pembesaran Kelenjar">
                                        </div>
                                        <div class="col-md-2">
                                            <label for="genetalia" style="color: green;">Genetalia</label>
                                            <input type="text" class="form-control" id="genetalia"
                                                name="genetalia"
                                                value="{{ old('genetalia', $action->genetalia ?? '') }}"
                                                placeholder="Genetalia Jika Diperlukan">
                                        </div>
                                        <div class="col-md-2">
                                            <label for="warna_kulit" style="color: green;">Kulit-Warna</label>
                                            <input type="text" class="form-control" id="warna_kulit"
                                                name="warna_kulit"
                                                value="{{ old('warna_kulit', $action->warna_kulit ?? '') }}"
                                                placeholder="Warna Kulit">
                                        </div>
                                        <div class="col-md-2">
                                            <label for="turgor" style="color: green;">Kulit-Turgor</label>
                                            <input type="text" class="form-control" id="turgor" name="turgor"
                                                value="{{ old('turgor', $action->turgor ?? '') }}"
                                                placeholder="Turgor Kulit">
                                        </div>
                                        <div class="col-md-2">
                                            <label for="neurologis" style="color: green;">Pemeriksaan
                                                Neurologis</label>
                                            <input type="text" class="form-control" id="neurologis"
                                                name="neurologis"
                                                value="{{ old('neurologis', $action->neurologis ?? '') }}"
                                                placeholder="Pemeriksaan Neurologis Jika Diperlukan">
                                        </div>
                                    </div>
                                </div>
                                <div style="display: flex; align-items: center; text-align: center;">
                                    <hr style="flex: 1; border: none; border-top: 1px solid #ccc;">
                                    <span style="margin: 0 10px; white-space: nowrap;">Pemeriksaan Penunjang</span>
                                    <hr style="flex: 1; border: none; border-top: 1px solid #ccc;">
                                </div>
                                <div class="container">
                                    <div class="row g-2">
                                        <div class="col-md-12">
                                            <label for="hasil_lab" style="color: green;">Hasil Laboratorium</label>
                                            <input type="text" class="form-control" id="hasil_lab"
                                                name="hasil_lab"
                                                value="{{ old('hasil_lab', $action->hasil_lab ?? '') }}"
                                                placeholder="Hasil Laboratorium">
                                        </div>
                                    </div>
                                </div>
                            @elseif($action->tipe == 'poli-gigi')
                                <div class="container">
                                    <div class="row g-2">
                                        <div class="col-md-2 ">
                                            <label for="hamil" style="color: green;">Hamil</label>
                                            <select class="form-control" id="hamil" name="hamil">
                                                <option {{ empty($action->hamil) ? 'selected' : '' }} disabled
                                                    selected>pilih</option>
                                                <option
                                                    value="ya"{{ old('hamil', $action->hamil) == 'ya' ? 'selected' : '' }}>
                                                    Ya</option>
                                                <option
                                                    value="tidak"{{ old('hamil', $action->hamil) == 'tidak' ? 'selected' : '' }}>
                                                    Tidak</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                    @if ($action->tipe == 'poli-umum')
                        <div class="row mt-3">
                            <div class="col-md-4">
                                <label for="riwayat_penyakit_keluargaEdit" style="color: rgb(241, 11, 11);">Riwayat
                                    Penyakit Tidak Menular Pada Keluarga</label>
                                <select class="form-control" id="riwayat_penyakit_keluargaEdit"
                                    name="riwayat_penyakit_keluarga[]" multiple>
                                    @foreach ($penyakit as $item)
                                        <option value="{{ $item->id }}"
                                            {{ in_array($item->id, old('riwayat_penyakit_keluarga', $action->riwayat_penyakit_keluarga ?? [])) ? 'selected' : '' }}>
                                            {{ $item->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="riwayat_penyakit_tidak_menularEdit"
                                    style="color: rgb(241, 11, 11);">Riwayat
                                    Penyakit Tidak Menular Pada Sendiri</label>
                                <select class="form-control" id="riwayat_penyakit_tidak_menularEdit"
                                    name="riwayat_penyakit_tidak_menular[]" multiple>
                                    @foreach ($penyakit as $item)
                                        <option value="{{ $item->id }}"
                                            {{ in_array($item->id, old('riwayat_penyakit_tidak_menular', $action->riwayat_penyakit_tidak_menular ?? [])) ? 'selected' : '' }}>
                                            {{ $item->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="keluhan" style="color: rgb(241, 11, 11);">Keluhan</label>
                                <input type="text" class="form-control" id="keluhan" name="keluhan"
                                    value="{{ old('keluhan', $action->keluhan ?? '') }}"
                                    placeholder="Kosongkan Bila sehat">
                            </div>
                        </div>
                    @endif
                    <div class="row mt-3">
                        <div class="col-md-4">
                            <label for="diagnosaEdit" style="color: rgb(19, 11, 241);">DIAGNOSA</label>
                            <select class="form-control" id="diagnosaEdit" name="diagnosa[]" multiple>
                                @foreach ($diagnosa as $item)
                                    <option value="{{ $item->id }}"
                                        {{ in_array($item->id, old('diagnosa', $action->diagnosa ?? [])) ? 'selected' : '' }}>
                                        {{ $item->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        {{-- <div class="col-md-4">
                            <label for="icd10" style="color: rgb(19, 11, 241);">ICD 10</label>
                            <input type="text" class="form-control" id="icd10" name="icd10"
                                placeholder="ICD 10" value="{{ old('icd10', $action->icd10 ?? '') }}" required>
                        </div> --}}
                        <div class="col-md-4">
                            <label for="tindakanEdit" style="color: rgb(19, 11, 241);">TINDAKAN</label>
                            <select class="form-control" id="tindakanEdit" name="tindakan">
                                <option value="" {{ empty($action->tindakan) ? 'selected' : '' }} disabled
                                    selected>pilih</option>
                                @if ($action->tipe == 'poli-umum')
                                    <option value="Diberikan Obat"
                                        {{ old('tindakan', $action->tindakan ?? '') == 'Diberikan Obat' ? 'selected' : '' }}>
                                        Diberikan Obat</option>
                                    <option value="Tidak"
                                        {{ old('tindakan', $action->tindakan ?? '') == 'Tidak' ? 'selected' : '' }}>
                                        Tidak
                                    </option>
                                @elseif($action->tipe == 'poli-gigi')
                                    <option value="Gigi Sulung Tumpatan Sementara"
                                        {{ old('tindakan', $action->tindakan ?? '') == 'Gigi Sulung Tumpatan Sementara' ? 'selected' : '' }}>
                                        Gigi Sulung Tumpatan Sementara
                                    </option>
                                    <option value="Tidak Ada"
                                        {{ old('tindakan', $action->tindakan ?? '') == 'Tidak Ada' ? 'selected' : '' }}>
                                        Tidak Ada
                                    </option>
                                    <option value="Gigi Tetap Tumpatan Tetap"
                                        {{ old('tindakan', $action->tindakan ?? '') == 'Gigi Tetap Tumpatan Tetap' ? 'selected' : '' }}>
                                        Gigi Tetap Tumpatan Tetap
                                    </option>
                                    <option value="Gigi Sulung Tumpatan Tetap"
                                        {{ old('tindakan', $action->tindakan ?? '') == 'Gigi Sulung Tumpatan Tetap' ? 'selected' : '' }}>
                                        Gigi Sulung Tumpatan Tetap
                                    </option>
                                    <option value="Perawatan Saluran Akar"
                                        {{ old('tindakan', $action->tindakan ?? '') == 'Perawatan Saluran Akar' ? 'selected' : '' }}>
                                        Perawatan Saluran Akar
                                    </option>
                                    <option value="Gigi Sulung Pencabutan"
                                        {{ old('tindakan', $action->tindakan ?? '') == 'Gigi Sulung Pencabutan' ? 'selected' : '' }}>
                                        Gigi Sulung Pencabutan
                                    </option>
                                    <option value="Gigi Tetap Pencabutan"
                                        {{ old('tindakan', $action->tindakan ?? '') == 'Gigi Tetap Pencabutan' ? 'selected' : '' }}>
                                        Gigi Tetap Pencabutan
                                    </option>
                                    <option value="Pembersihan Karang Gigi"
                                        {{ old('tindakan', $action->tindakan ?? '') == 'Pembersihan Karang Gigi' ? 'selected' : '' }}>
                                        Pembersihan Karang Gigi
                                    </option>
                                    <option value="Odontectomy"
                                        {{ old('tindakan', $action->tindakan ?? '') == 'Odontectomy' ? 'selected' : '' }}>
                                        Odontectomy
                                    </option>
                                    <option value="Sebagian Prothesa"
                                        {{ old('tindakan', $action->tindakan ?? '') == 'Sebagian Prothesa' ? 'selected' : '' }}>
                                        Sebagian Prothesa
                                    </option>
                                    <option value="Penuh Prothesa"
                                        {{ old('tindakan', $action->tindakan ?? '') == 'Penuh Prothesa' ? 'selected' : '' }}>
                                        Penuh Prothesa
                                    </option>
                                    <option value="Reparasi Prothesa"
                                        {{ old('tindakan', $action->tindakan ?? '') == 'Reparasi Prothesa' ? 'selected' : '' }}>
                                        Reparasi Prothesa
                                    </option>
                                    <option value="Premedikasi"
                                        {{ old('tindakan', $action->tindakan ?? '') == 'Premedikasi' ? 'selected' : '' }}>
                                        Premedikasi/Pengobatan
                                    </option>
                                    <option value="Tindakan Lain"
                                        {{ old('tindakan', $action->tindakan ?? '') == 'Tindakan Lain' ? 'selected' : '' }}>
                                        Tindakan Lain
                                    </option>
                                    <option value="Incici Abses Gigi"
                                        {{ old('tindakan', $action->tindakan ?? '') == 'Incici Abses Gigi' ? 'selected' : '' }}>
                                        Incici Abses Gigi</option>
                                @else
                                    <option value="Observasi Tanpa Tindakan Invasif"
                                        {{ old('tindakan', $action->tindakan ?? '') == 'Observasi Tanpa Tindakan Invasif' ? 'selected' : '' }}>
                                        Observasi Tanpa Tindakan Invasif
                                    </option>
                                    <option value="Observasi Dengan Tindakan Invasif"
                                        {{ old('tindakan', $action->tindakan ?? '') == 'Observasi Dengan Tindakan Invasif' ? 'selected' : '' }}>
                                        Observasi Dengan Tindakan Invasif
                                    </option>
                                    <option value="Tidak Ada"
                                        {{ old('tindakan', $action->tindakan ?? '') == 'Tidak Ada' ? 'selected' : '' }}>
                                        Tidak Ada
                                    </option>
                                    <option value="Corpus Alineum"
                                        {{ old('tindakan', $action->tindakan ?? '') == 'Corpus Alineum' ? 'selected' : '' }}>
                                        Corpus Alineum
                                    </option>
                                    <option value="Ekstraksi Kuku"
                                        {{ old('tindakan', $action->tindakan ?? '') == 'Ekstraksi Kuku' ? 'selected' : '' }}>
                                        Ekstraksi Kuku
                                    </option>
                                    <option value="Sircumsisi (Bedah Ringan)"
                                        {{ old('tindakan', $action->tindakan ?? '') == 'Sircumsisi (Bedah Ringan)' ? 'selected' : '' }}>
                                        Sircumsisi (Bedah Ringan)
                                    </option>
                                    <option value="Incisi Abses"
                                        {{ old('tindakan', $action->tindakan ?? '') == 'Incisi Abses' ? 'selected' : '' }}>
                                        Incisi Abses
                                    </option>
                                    <option value="Rawat Luka"
                                        {{ old('tindakan', $action->tindakan ?? '') == 'Rawat Luka' ? 'selected' : '' }}>
                                        Rawat Luka
                                    </option>
                                    <option value="Ganti Verban"
                                        {{ old('tindakan', $action->tindakan ?? '') == 'Ganti Verban' ? 'selected' : '' }}>
                                        Ganti Verban
                                    </option>
                                    <option value="Spooling"
                                        {{ old('tindakan', $action->tindakan ?? '') == 'Spooling' ? 'selected' : '' }}>
                                        Spooling
                                    </option>
                                    <option value="Toilet Telinga"
                                        {{ old('tindakan', $action->tindakan ?? '') == 'Toilet Telinga' ? 'selected' : '' }}>
                                        Toilet Telinga
                                    </option>
                                    <option value="Tetes Telinga"
                                        {{ old('tindakan', $action->tindakan ?? '') == 'Tetes Telinga' ? 'selected' : '' }}>
                                        Tetes Telinga
                                    </option>
                                    <option value="Aff Hecting"
                                        {{ old('tindakan', $action->tindakan ?? '') == 'Aff Hecting' ? 'selected' : '' }}>
                                        Aff Hecting
                                    </option>
                                    <option value="Hecting (Jahit Luka)"
                                        {{ old('tindakan', $action->tindakan ?? '') == 'Hecting (Jahit Luka)' ? 'selected' : '' }}>
                                        Hecting (Jahit Luka)</option>
                                    <option value="Tampon/Off Tampon"
                                        {{ old('tindakan', $action->tindakan ?? '') == 'Tampon/Off Tampon' ? 'selected' : '' }}>
                                        Tampon/Off Tampon</option>
                                @endif
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="obat" style="color: rgb(19, 11, 241);">Obat</label>
                            <textarea class="form-control" id="obat" name="obat" placeholder="Obat">{{ old('obat', $action->obat ?? '') }}</textarea>
                        </div>



                    </div>

                    <div class="row mt-3">
                        <div class="col-md-4">
                            <label for="rujuk_rs" style="color: rgb(19, 11, 241);">RUJUK RS</label>
                            <select class="form-control" id="rujuk_rs" name="rujuk_rs">
                                <option value="" disabled selected>pilih</option>
                                @foreach ($rs as $item)
                                    <option value="{{ $item->id }}"
                                        {{ old('rujuk_rs', $action->rujuk_rs ?? '') == $item->id ? 'selected' : '' }}>
                                        {{ $item->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="keterangan" style="color: rgb(19, 11, 241);">KETERANGAN</label>
                            <input type="text" class="form-control" id="keterangan" name="keterangan"
                                value="{{ old('keterangan', $action->keterangan ?? '') }}" placeholder="Keterangan"
                                required>
                        </div>
                    </div>


            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
        <button type="submit" class="btn btn-primary">Simpan Data</button>
        </form>
    </div>
</div>


@include('component.modal-table-edit-pasien')

<script>
    var nikValue = "{{ $action->patient->nik ?? '' }}";
    document.getElementById('nikEdit').value = nikValue;
    //  console.log(nikValue);
</script>
<script>
    $(document).ready(function() {
        $('#riwayat_penyakit_keluargaEdit').select2({
            placeholder: "Pilih",
            allowClear: true,
            minimumResultsForSearch: 0
        });
    });
    $(document).ready(function() {
        $('#riwayat_penyakit_tidak_menularEdit').select2({
            placeholder: "Pilih",
            allowClear: true,
            minimumResultsForSearch: 0
        });
    });
    $(document).ready(function() {
        $('#diagnosaEdit').select2({
            placeholder: "Pilih",
            allowClear: true,
            minimumResultsForSearch: 0
        });
    });
    $(document).ready(function() {
        $('#tindakanEdit').select2({
            placeholder: "Pilih",
            allowClear: true,
            minimumResultsForSearch: 0
        });
    });
</script>

<style>
    .select2-dropdown {
        z-index: 9999 !important;
    }
</style>

<script>
    // Initialize Flatpickr for the date picker
    document.addEventListener('DOMContentLoaded', function() {
        flatpickr('#tanggal', {
            dateFormat: 'd-m-Y', // Format tanggal
            defaultDate: new Date(), // Optional: default to today's date
            locale: {
                firstDayOfWeek: 0 // Optional: Sunday as the first day of the week
            }
        });
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Display success message if session has a success
        @if (session('success'))
            Swal.fire({
                title: 'Success!',
                text: "{{ session('success') }}",
                icon: 'success',
                confirmButtonText: 'OK'
            });
        @endif

        // Display error message if validation errors exist
        @if ($errors->any())
            Swal.fire({
                title: 'Error!',
                html: '<ul>' +
                    '@foreach ($errors->all() as $error)' +
                    '<li>{{ $error }}</li>' +
                    '@endforeach' +
                    '</ul>',
                icon: 'error',
                confirmButtonText: 'OK'
            });
        @endif
    });
</script>

<!-- Flatpickr CSS -->
<link href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" rel="stylesheet">

<!-- Flatpickr JS -->
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
