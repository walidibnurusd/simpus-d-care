<<<<<<< HEAD
\@extends('layouts.skrining.master')
@section('title', 'Skrining Kekerasan Pada Anak')
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
        action="{{ isset($kekerasanAnak) ? route('kekerasan.anak.update', $kekerasanAnak->id) : route('kekerasan.anak.store') }}"
        method="POST">
        @csrf
        @if (isset($kekerasanAnak))
            @method('PUT')
        @endif
        @if ($routeName === 'kekerasan.anak.view')
            <input type="hidden" name="klaster" value="2">
            <input type="hidden" name="poli" value="kia">
        @elseif($routeName === 'kekerasan.anak.mtbs.view')
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
                                    data-alamat="{{ $item->address }}" data-jenis_kelamin="{{ $item->genderName->name }}"
                                    data-pob="{{ $item->place_birth }}"
                                    {{ old('pasien', $kekerasanAnak->pasien ?? '') == $item->id ? 'selected' : '' }}>
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
                        <label>Tempat Lahir</label>
                        <input type="text" class="form-control" name="tempat_lahir" placeholder="Masukkan tempat lahir"
                            readonly id="tempat_lahir"
                            value="{{ isset($kekerasanAnak) ? $kekerasanAnak->tempat_lahir : old('tempat_lahir') }}">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Tanggal Lahir</label>
                        <input type="date" class="form-control" name="tanggal_lahir" id="tanggal_lahir" readonly
                            value="{{ isset($kekerasanAnak) ? $kekerasanAnak->tanggal_lahir : old('tanggal_lahir') }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Alamat Lengkap</label>
                        <input type="text" class="form-control" name="alamat" placeholder="Masukkan alamat lengkap"
                            readonly id="alamat"
                            value="{{ isset($kekerasanAnak) ? $kekerasanAnak->alamat : old('alamat') }}">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Jenis Kelamin</label>
                        <div class="d-flex">
                            <div class="form-check mr-3">
                                <input type="radio" class="form-check-input" name="jenis_kelamin" value="laki-laki"
                                    id="jk_laki"
                                    {{ old('jenis_kelamin', $kekerasanAnak->jenis_kelamin ?? '') == 'laki-laki' ? 'checked' : '' }}>
                                <label class="form-check-label" for="laki-laki">Laki-laki</label>
                            </div>
                            <div class="form-check">
                                <input type="radio" class="form-check-input" name="jenis_kelamin" value="perempuan"
                                    id="jk_perempuan"
                                    {{ old('jenis_kelamin', $kekerasanAnak->jenis_kelamin ?? '') == 'perempuan' ? 'checked' : '' }}>
                                <label class="form-check-label" for="perempuan">Perempuan</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label>Diperoleh dari</label>
                        <input type="text" class="form-control" name="diperoleh_dari"
                            placeholder="Masukkan diperoleh dari"
                            value="{{ isset($kekerasanAnak) ? $kekerasanAnak->diperoleh_dari : old('diperoleh_dari') }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Hubungan dengan pasien</label>
                        <input type="text" class="form-control" name="hubungan_pasien"
                            placeholder="Masukkan hubungan dengan pasien"
                            value="{{ isset($kekerasanAnak) ? $kekerasanAnak->hubungan_pasien : old('hubungan_pasien') }}">
                    </div>
                </div>
            </div>

            <div class="form-section mt-4">
                <h3>Anamnesa dan Pemeriksaan Fisik</h3>

                <div class="form-group">
                    <label>1. Bentuk kekerasan</label>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="kekerasan[]" value="seksual"
                                    id="seksual"
                                    {{ isset($kekerasanAnak->kekerasan) && in_array('seksual', $kekerasanAnak->kekerasan) ? 'checked' : '' }}>
                                <label class="form-check-label" for="seksual">Kekerasan seksual</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="kekerasan[]" value="fisik"
                                    id="fisik"
                                    {{ isset($kekerasanAnak->kekerasan) && in_array('fisik', $kekerasanAnak->kekerasan) ? 'checked' : '' }}>
                                <label class="form-check-label" for="fisik">Kekerasan fisik</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="kekerasan[]" value="psikis"
                                    id="psikis"
                                    {{ isset($kekerasanAnak->kekerasan) && in_array('psikis', $kekerasanAnak->kekerasan) ? 'checked' : '' }}>
                                <label class="form-check-label" for="psikis">Kekerasan psikis</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="kekerasan[]" value="penelantaran"
                                    id="penelantaran"
                                    {{ isset($kekerasanAnak->kekerasan) && in_array('penelantaran', $kekerasanAnak->kekerasan) ? 'checked' : '' }}>
                                <label class="form-check-label" for="penelantaran">Penelantaran:</label>
                            </div>
                            <div class="form-check ml-3">
                                <input type="checkbox" class="form-check-input" name="kekerasan[]" value="gizi"
                                    id="gizi"
                                    {{ isset($kekerasanAnak->kekerasan) && in_array('gizi', $kekerasanAnak->kekerasan) ? 'checked' : '' }}>
                                <label class="form-check-label" for="gizi">Gizi</label>
                            </div>
                            <div class="form-check ml-3">
                                <input type="checkbox" class="form-check-input" name="kekerasan[]" value="pendidikan"
                                    id="pendidikan"
                                    {{ isset($kekerasanAnak->kekerasan) && in_array('pendidikan', $kekerasanAnak->kekerasan) ? 'checked' : '' }}>
                                <label class="form-check-label" for="pendidikan">Pendidikan</label>
                            </div>
                            <div class="form-check ml-3">
                                <input type="checkbox" class="form-check-input" name="kekerasan[]" value="ekonomi"
                                    id="ekonomi"
                                    {{ isset($kekerasanAnak->kekerasan) && in_array('ekonomi', $kekerasanAnak->kekerasan) ? 'checked' : '' }}>
                                <label class="form-check-label" for="ekonomi">Ekonomi</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label>2. Tempat kejadian</label>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="tempat[]"
                                    value="dalam_rumah_tangga" id="dalam_rumah_tangga"
                                    {{ isset($kekerasanAnak->tempat) && in_array('dalam_rumah_tangga', $kekerasanAnak->tempat) ? 'checked' : '' }}>
                                <label class="form-check-label" for="dalam_rumah_tangga">Dalam rumah tangga</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="tempat[]" value="tempat_kerja"
                                    id="tempat_kerja"
                                    {{ isset($kekerasanAnak->tempat) && in_array('tempat_kerja', $kekerasanAnak->tempat) ? 'checked' : '' }}>
                                <label class="form-check-label" for="tempat_kerja">Di tempat kerja/sekolah</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="tempat[]" value="jalanan"
                                    id="jalanan"
                                    {{ isset($kekerasanAnak->tempat) && in_array('jalanan', $kekerasanAnak->tempat) ? 'checked' : '' }}>
                                <label class="form-check-label" for="jalanan">Jalanan</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="tempat[]" value="daerah_konflik"
                                    id="daerah_konflik"
                                    {{ isset($kekerasanAnak->tempat) && in_array('daerah_konflik', $kekerasanAnak->tempat) ? 'checked' : '' }}>
                                <label class="form-check-label" for="daerah_konflik">Di daerah konflik</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="tempat[]" value="lain_lain"
                                    id="lain_lain"
                                    {{ isset($kekerasanAnak->tempat) && in_array('lain_lain', $kekerasanAnak->tempat) ? 'checked' : '' }}
                                    onclick="toggleTextInput()">
                                <label class="form-check-label" for="lain_lain">Lain-lain, sebutkan</label>
                            </div>
                            <div id="lain_lain_input"
                                style="display: {{ isset($kekerasanAnak->tempat) && in_array('lain_lain', $kekerasanAnak->tempat) ? 'block' : 'none' }}; margin-top: 10px;">
                                <label for="tempat_lain">Sebutkan tempat lainnya:</label>
                                <input type="text" class="form-control" name="tempat_lain" id="tempat_lain"
                                    value="{{ $kekerasanAnak->tempat_lain ?? '' }}">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label>3. Dampak yang terjadi pada pasien dengan kdrt</label>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="dampak_pasien[]"
                                    value="cidera_bilateral" id="cidera_bilateral"
                                    {{ isset($kekerasanAnak->dampak_pasien) && in_array('cidera_bilateral', $kekerasanAnak->dampak_pasien) ? 'checked' : '' }}>
                                <label class="form-check-label" for="cidera_bilateral">Cidera bilateral /
                                    multilateral</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="dampak_pasien[]"
                                    value="cidera_penyembuhan" id="cidera_penyembuhan"
                                    {{ isset($kekerasanAnak->dampak_pasien) && in_array('cidera_penyembuhan', $kekerasanAnak->dampak_pasien) ? 'checked' : '' }}>
                                <label class="form-check-label" for="cidera_penyembuhan">Beberapa cidera dengan beberapa
                                    tampak penyembuhan</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="dampak_pasien[]"
                                    value="tidak_sesuai" id="tidak_sesuai"
                                    {{ isset($kekerasanAnak->dampak_pasien) && in_array('tidak_sesuai', $kekerasanAnak->dampak_pasien) ? 'checked' : '' }}>
                                <label class="form-check-label" for="tidak_sesuai">Keterangan yang tidak sesuai dengan
                                    cideranya</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="dampak_pasien[]"
                                    value="pertolongan_terlambat" id="pertolongan_terlambat"
                                    {{ isset($kekerasanAnak->dampak_pasien) && in_array('pertolongan_terlambat', $kekerasanAnak->dampak_pasien) ? 'checked' : '' }}>
                                <label class="form-check-label" for="pertolongan_terlambat">Keterlambatan mendapatkan
                                    pertolongan medis / berobat</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="dampak_pasien[]"
                                    value="kekerasan_berulang" id="kekerasan_berulang"
                                    {{ isset($kekerasanAnak->dampak_pasien) && in_array('kekerasan_berulang', $kekerasanAnak->dampak_pasien) ? 'checked' : '' }}>
                                <label class="form-check-label" for="kekerasan_berulang">Berulangnya mendapatkan kekerasan
                                    fisik dan berobat ke Puskesmas akibat dari trauma</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label>4. Dampak kekerasan pada anak (Psychological Abuse)</label>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="dampak_pada_anak[]"
                                    value="ekspresi_wajah" id="ekspresi_wajah"
                                    {{ isset($kekerasanAnak->dampak_pada_anak) && in_array('ekspresi_wajah', $kekerasanAnak->dampak_pada_anak ?? []) ? 'checked' : '' }}>
                                <label class="form-check-label" for="ekspresi_wajah">Ekpresi wajah:</label>
                            </div>
                            <div class="form-check ml-3">
                                <input type="checkbox" class="form-check-input" name="dampak_pada_anak[]" value="sedih"
                                    id="sedih"
                                    {{ isset($kekerasanAnak->dampak_pada_anak) && in_array('sedih', $kekerasanAnak->dampak_pada_anak ?? []) ? 'checked' : '' }}>
                                <label class="form-check-label" for="sedih">Sedih</label>
                            </div>
                            <div class="form-check ml-3">
                                <input type="checkbox" class="form-check-input" name="dampak_pada_anak[]" value="takut"
                                    id="takut"
                                    {{ isset($kekerasanAnak->dampak_pada_anak) && in_array('takut', $kekerasanAnak->dampak_pada_anak ?? []) ? 'checked' : '' }}>
                                <label class="form-check-label" for="takut">Takut</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="dampak_pada_anak[]"
                                    value="agresif" id="agresif"
                                    {{ isset($kekerasanAnak->dampak_pada_anak) && in_array('agresif', $kekerasanAnak->dampak_pada_anak ?? []) ? 'checked' : '' }}>
                                <label class="form-check-label" for="agresif">Perubahan perilaku anak agresif atau
                                    penarikan diri yang berlebihan</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="dampak_pada_anak[]"
                                    value="cerita_berubah" id="cerita_berubah"
                                    {{ isset($kekerasanAnak->dampak_pada_anak) && in_array('cerita_berubah', $kekerasanAnak->dampak_pada_anak ?? []) ? 'checked' : '' }}>
                                <label class="form-check-label" for="cerita_berubah">Cerita yang berubah dari ucapan yang
                                    sebelumnya</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="dampak_pada_anak[]"
                                    value="lari_dari_rumah" id="lari_dari_rumah"
                                    {{ isset($kekerasanAnak->dampak_pada_anak) && in_array('lari_dari_rumah', $kekerasanAnak->dampak_pada_anak ?? []) ? 'checked' : '' }}>
                                <label class="form-check-label" for="lari_dari_rumah">Lari dari rumah atau melakukan
                                    kenakalan remaja</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="dampak_pada_anak[]"
                                    value="hindari_kontak_mata" id="hindari_kontak_mata"
                                    {{ isset($kekerasanAnak->dampak_pada_anak) && in_array('hindari_kontak_mata', $kekerasanAnak->dampak_pada_anak ?? []) ? 'checked' : '' }}>
                                <label class="form-check-label" for="hindari_kontak_mata">Menghindari kontak mata</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="dampak_pada_anak[]" value="pasif"
                                    id="pasif"
                                    {{ isset($kekerasanAnak->dampak_pada_anak) && in_array('pasif', $kekerasanAnak->dampak_pada_anak ?? []) ? 'checked' : '' }}>
                                <label class="form-check-label" for="pasif">Terlalu penurut / pasif</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="dampak_pada_anak[]"
                                    value="lari_dari_orang_tua" id="lari_dari_orang_tua"
                                    {{ isset($kekerasanAnak->dampak_pada_anak) && in_array('lari_dari_orang_tua', $kekerasanAnak->dampak_pada_anak ?? []) ? 'checked' : '' }}>
                                <label class="form-check-label" for="lari_dari_orang_tua">Menjauhi orang tua atau
                                    pengasuh</label>
                            </div>
                        </div>
                    </div>
                </div>



                <div class="form-group">
                    <label>5. Penelantaran fisik pada anak</label>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="penelantaran_fisik[]"
                                    value="gagal_tumbuh" id="gagal_tumbuh"
                                    {{ in_array('gagal_tumbuh', $kekerasanAnak->penelantaran_fisik ?? []) ? 'checked' : '' }}>
                                <label class="form-check-label" for="gagal_tumbuh">Gagal tumbuh / keterlambatan
                                    perkembangan
                                    fisik maupun mental</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="penelantaran_fisik[]"
                                    value="luka" id="luka"
                                    {{ in_array('luka', $kekerasanAnak->penelantaran_fisik ?? []) ? 'checked' : '' }}>
                                <label class="form-check-label" for="luka">Luka / penyakit yang dibiarkan tidak
                                    diobati</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="penelantaran_fisik[]"
                                    value="lemah" id="lemah"
                                    {{ in_array('lemah', $kekerasanAnak->penelantaran_fisik ?? []) ? 'checked' : '' }}>
                                <label class="form-check-label" for="lemah">Keadaan Umum (KU) lemah atau
                                    letargi</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="penelantaran_fisik[]"
                                    value="pakaian_lusuh" id="pakaian_lusuh"
                                    {{ in_array('pakaian_lusuh', $kekerasanAnak->penelantaran_fisik ?? []) ? 'checked' : '' }}>
                                <label class="form-check-label" for="pakaian_lusuh">Pakaian yang lusuh dan kotor</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label>6. Tanda-tanda yang didapatkan pada korban kekerasan</label>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-check form-check-inline">
                                <!-- Check if the checkbox was checked (either from DB or old input) -->
                                <input type="checkbox" class="form-check-input" name="tanda_kekerasan_check[]"
                                    value="memar" style="margin-right: 10px;"
                                    {{ (isset($kekerasanAnak->tanda_kekerasan_check) &&
                                        is_array($kekerasanAnak->tanda_kekerasan_check) &&
                                        in_array('memar', $kekerasanAnak->tanda_kekerasan_check)) ||
                                    (is_array(old('tanda_kekerasan_check')) && in_array('memar', old('tanda_kekerasan_check')))
                                        ? 'checked'
                                        : '' }}>
                                <label style="width: 250px;">Terdapat memar di</label>

                                <!-- Use old input value for the text field, or value from DB if available -->
                                <input type="text" class="form-control" name="tanda_kekerasan[]"
                                    placeholder="Masukkan lokasi memar"
                                    value="{{ old('tanda_kekerasan.0', isset($kekerasanAnak->tanda_kekerasan[0]) ? $kekerasanAnak->tanda_kekerasan[0] : '') }}"
                                    style="width: calc(60% - 160px); display: inline-block;">
                            </div>
                        </div>


                        <div class="col-md-12">
                            <div class="form-check form-check-inline">
                                <input type="checkbox" class="form-check-input" name="tanda_kekerasan_check[]"
                                    value="robek" style="margin-right: 10px;"
                                    {{ (isset($kekerasanAnak->tanda_kekerasan_check) && in_array('robek', $kekerasanAnak->tanda_kekerasan_check)) ||
                                    old('tanda_kekerasan_check')
                                        ? 'checked'
                                        : '' }}>
                                <label style="width: 250px;">Luka lecet dan luka robek di</label>
                                <input type="text" class="form-control" name="tanda_kekerasan[]"
                                    placeholder="Masukkan lokasi luka lecet dan luka robek"
                                    value="{{ old('tanda_kekerasan', isset($kekerasanAnak->tanda_kekerasan[1]) ? $kekerasanAnak->tanda_kekerasan[1] : '') }}"
                                    style="width: calc(60% - 160px); display: inline-block;">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-check form-check-inline">
                                <input type="checkbox" class="form-check-input" style="margin-right: 10px;"
                                    name="tanda_kekerasan_check[]" value="patah"
                                    {{ (isset($kekerasanAnak->tanda_kekerasan_check) && in_array('patah', $kekerasanAnak->tanda_kekerasan_check)) ||
                                    old('tanda_kekerasan_check')
                                        ? 'checked'
                                        : '' }}>
                                <label style="width: 250px;">Patah tulang baru / lama di</label>
                                <input type="text" class="form-control" name="tanda_kekerasan[]"
                                    placeholder="Masukkan lokasi patah tulang baru/lama"
                                    value="{{ old('tanda_kekerasan', isset($kekerasanAnak->tanda_kekerasan[2]) ? $kekerasanAnak->tanda_kekerasan[2] : '') }}"
                                    style="width: calc(60% - 160px); display: inline-block;">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-check form-check-inline">
                                <input type="checkbox" class="form-check-input" style="margin-right: 10px;"
                                    name="tanda_kekerasan_check[]" value="gigi_patah"
                                    {{ (isset($kekerasanAnak->tanda_kekerasan_check) &&
                                        in_array('gigi_patah', $kekerasanAnak->tanda_kekerasan_check)) ||
                                    old('tanda_kekerasan_check')
                                        ? 'checked'
                                        : '' }}>
                                <label style="width: 250px;">Gigi Patah / Berdarah</label>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-check form-check-inline">
                                <input type="checkbox" class="form-check-input" style="margin-right: 10px;"
                                    name="tanda_kekerasan_check[]" value="luka_bakar"
                                    {{ (isset($kekerasanAnak->tanda_kekerasan_check) &&
                                        in_array('luka_bakar', $kekerasanAnak->tanda_kekerasan_check)) ||
                                    old('tanda_kekerasan_check')
                                        ? 'checked'
                                        : '' }}>
                                <label style="width: 250px;">Terdapat luka bakar di lokasi</label>
                                <input type="text" class="form-control" name="tanda_kekerasan[]"
                                    placeholder="Masukkan lokasi luka bakar"
                                    value="{{ old('tanda_kekerasan', isset($kekerasanAnak->tanda_kekerasan[3]) ? $kekerasanAnak->tanda_kekerasan[3] : '') }}"
                                    style="width: calc(40% - 160px); display: inline-block;">
                                <label style="margin-left: 10px;">derajat</label>
                                <input type="text" class="form-control" name="derajat_luka_bakar"
                                    value="{{ old('derajat_luka_bakar', isset($kekerasanAnak->derajat_luka_bakar) ? $kekerasanAnak->derajat_luka_bakar : '') }}"
                                    placeholder="Derajat" style="width: 100px; display: inline-block; margin-left: 10px;">
                                <label style="margin-left: 5px;">%</label>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-check form-check-inline">
                                <input type="checkbox" class="form-check-input" style="margin-right: 10px;"
                                    name="tanda_kekerasan_check[]" value="cedera"
                                    {{ (isset($kekerasanAnak->tanda_kekerasan_check) &&
                                        in_array('cedera', $kekerasanAnak->tanda_kekerasan_check)) ||
                                    old('tanda_kekerasan_check')
                                        ? 'checked'
                                        : '' }}>
                                <label style="width: 250px;">Cedera kepala di daerah</label>
                                <input type="text" class="form-control" name="tanda_kekerasan[]"
                                    placeholder="Masukkan lokasi cedera kepala"
                                    value="{{ old('tanda_kekerasan', isset($kekerasanAnak->tanda_kekerasan[4]) ? $kekerasanAnak->tanda_kekerasan[4] : '') }}"
                                    style="width: calc(60% - 160px); display: inline-block;">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label>7. Tanda kekerasan seksual (Sexual Abuse)</label>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="kekerasan_seksual[]"
                                    value="luka_alat_kelamin" id="luka_alat_kelamin"
                                    {{ isset($kekerasanAnak) && in_array('luka_alat_kelamin', $kekerasanAnak->kekerasan_seksual ?? []) ? 'checked' : '' }}>
                                <label class="form-check-label" for="luka_alat_kelamin">Adanya perlukaan /jejas pada alat
                                    kelamin</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="kekerasan_seksual[]"
                                    value="nyeri_vagina" id="nyeri_vagina"
                                    {{ isset($kekerasanAnak) && in_array('nyeri_vagina', $kekerasanAnak->kekerasan_seksual ?? []) ? 'checked' : '' }}>
                                <label class="form-check-label" for="nyeri_vagina">Adanya rasa nyeri, perdarahan dari
                                    vagina</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label>8. Dampak yang terjadi pada korban kekerasan perkosaan</label>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="dampak_kekerasan[]"
                                    value="rasa_takut" id="rasa_takut"
                                    {{ isset($kekerasanAnak) && in_array('rasa_takut', $kekerasanAnak->dampak_kekerasan ?? []) ? 'checked' : '' }}>
                                <label class="form-check-label" for="rasa_takut">Rasa Takut</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="dampak_kekerasan[]" value="cemas"
                                    id="cemas"
                                    {{ isset($kekerasanAnak) && in_array('cemas', $kekerasanAnak->dampak_kekerasan ?? []) ? 'checked' : '' }}>
                                <label class="form-check-label" for="cemas">Cemas</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="dampak_kekerasan[]" value="gugup"
                                    id="gugup"
                                    {{ isset($kekerasanAnak) && in_array('gugup', $kekerasanAnak->dampak_kekerasan ?? []) ? 'checked' : '' }}>
                                <label class="form-check-label" for="gugup">Gugup</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="dampak_kekerasan[]"
                                    value="depresi" id="depresi"
                                    {{ isset($kekerasanAnak) && in_array('depresi', $kekerasanAnak->dampak_kekerasan ?? []) ? 'checked' : '' }}>
                                <label class="form-check-label" for="depresi">Depresi</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="dampak_kekerasan[]"
                                    value="bingung" id="bingung"
                                    {{ isset($kekerasanAnak) && in_array('bingung', $kekerasanAnak->dampak_kekerasan ?? []) ? 'checked' : '' }}>
                                <label class="form-check-label" for="bingung">Tampak serba bingung</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="dampak_kekerasan[]"
                                    value="mata_tidak_fokus" id="mata_tidak_fokus"
                                    {{ isset($kekerasanAnak) && in_array('mata_tidak_fokus', $kekerasanAnak->dampak_kekerasan ?? []) ? 'checked' : '' }}>
                                <label class="form-check-label" for="mata_tidak_fokus">Mata tidak fokus</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="dampak_kekerasan[]" value="tegang"
                                    id="tegang"
                                    {{ isset($kekerasanAnak) && in_array('tegang', $kekerasanAnak->dampak_kekerasan ?? []) ? 'checked' : '' }}>
                                <label class="form-check-label" for="tegang">Tegang</label>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="dampak_kekerasan[]"
                                    value="sulit_bicara" id="sulit_bicara"
                                    {{ isset($kekerasanAnak) && in_array('sulit_bicara', $kekerasanAnak->dampak_kekerasan ?? []) ? 'checked' : '' }}>
                                <label class="form-check-label" for="sulit_bicara">Sulit bicara</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="dampak_kekerasan[]"
                                    value="banyak_melamun" id="banyak_melamun"
                                    {{ isset($kekerasanAnak) && in_array('banyak_melamun', $kekerasanAnak->dampak_kekerasan ?? []) ? 'checked' : '' }}>
                                <label class="form-check-label" for="banyak_melamun">Banyak melamun</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="dampak_kekerasan[]"
                                    value="ekspresi_tegang" id="ekspresi_tegang"
                                    {{ isset($kekerasanAnak) && in_array('ekspresi_tegang', $kekerasanAnak->dampak_kekerasan ?? []) ? 'checked' : '' }}>
                                <label class="form-check-label" for="ekspresi_tegang">Ekspresi wajah tegang</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="dampak_kekerasan[]"
                                    value="penampilan_tidak_rapi" id="penampilan_tidak_rapi"
                                    {{ isset($kekerasanAnak) && in_array('penampilan_tidak_rapi', $kekerasanAnak->dampak_kekerasan ?? []) ? 'checked' : '' }}>
                                <label class="form-check-label" for="penampilan_tidak_rapi">Penampilan tidak rapi atau
                                    tidak teratur</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="dampak_kekerasan[]"
                                    value="kebencian_kemarahan" id="kebencian_kemarahan"
                                    {{ isset($kekerasanAnak) && in_array('kebencian_kemarahan', $kekerasanAnak->dampak_kekerasan ?? []) ? 'checked' : '' }}>
                                <label class="form-check-label" for="kebencian_kemarahan">Terlihat menunjukkan kebencian
                                    dan kemarahan</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="dampak_kekerasan[]"
                                    value="mudah_curiga" id="mudah_curiga"
                                    {{ isset($kekerasanAnak) && in_array('mudah_curiga', $kekerasanAnak->dampak_kekerasan ?? []) ? 'checked' : '' }}>
                                <label class="form-check-label" for="mudah_curiga">Mudah curiga kepada orang lain</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="dampak_kekerasan[]"
                                    value="perasaan_sensitif" id="perasaan_sensitif"
                                    {{ isset($kekerasanAnak) && in_array('perasaan_sensitif', $kekerasanAnak->dampak_kekerasan ?? []) ? 'checked' : '' }}>
                                <label class="form-check-label" for="perasaan_sensitif">Perasaan sensitif</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group mt-4">
                        <div class="form-group">
                            <div class="col-md-12">
                                <label for="kesimpulan" style="color: rgb(19, 11, 241);">Kesimpulan</label>
                                <textarea class="form-control" id="kesimpulan" name="kesimpulan" placeholder="Kesimpulan">{{ old('kesimpulan', $kekerasanAnak->kesimpulan ?? '') }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>


            </div>

            <div class="text-right mt-4">
                {{-- @if (isset($kekerasanAnak))
                    <a href="{{ route('kekerasan.anak.admin') }}" type="button" class="btn btn-secondary mr-2"
                        style="font-size: 20px">Kembali</a>
                @else
                    <a href="{{ route('skrining.ilp') }}" type="button" class="btn btn-secondary mr-2"
                        style="font-size: 20px">Kembali</a>
                @endif --}}
                <button type="submit" class="btn btn-primary" style="font-size: 20px">Kirim</button>
            </div>
    </form>
    <script>
        function toggleTextInput() {
            var checkbox = document.getElementById('lain_lain');
            var textInput = document.getElementById('lain_lain_input');

            // Tampilkan atau sembunyikan input teks berdasarkan status checkbox
            if (checkbox.checked) {
                textInput.style.display = 'block';
            } else {
                textInput.style.display = 'none';
            }
        }
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
                var pob = selectedOption.data('pob');



                $('#tanggal_lahir').val(dob);
                $('#alamat').val(alamat);
                $('#tempat_lahir').val(pob);
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
=======
\@extends('layouts.skrining.master')
@section('title', 'Skrining Kekerasan Pada Anak')
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
        action="{{ isset($kekerasanAnak) ? route('kekerasan.anak.update', $kekerasanAnak->id) : route('kekerasan.anak.store') }}"
        method="POST">
        @csrf
        @if (isset($kekerasanAnak))
            @method('PUT')
        @endif
        @if ($routeName === 'kekerasan.anak.view')
            <input type="hidden" name="klaster" value="2">
            <input type="hidden" name="poli" value="kia">
        @elseif($routeName === 'kekerasan.anak.mtbs.view')
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
                                    data-alamat="{{ $item->address }}" data-jenis_kelamin="{{ $item->genderName->name }}"
                                    data-pob="{{ $item->place_birth }}"
                                    {{ old('pasien', $kekerasanAnak->pasien ?? '') == $item->id ? 'selected' : '' }}>
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
                        <label>Tempat Lahir</label>
                        <input type="text" class="form-control" name="tempat_lahir" placeholder="Masukkan tempat lahir"
                            readonly id="tempat_lahir"
                            value="{{ isset($kekerasanAnak) ? $kekerasanAnak->tempat_lahir : old('tempat_lahir') }}">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Tanggal Lahir</label>
                        <input type="date" class="form-control" name="tanggal_lahir" id="tanggal_lahir" readonly
                            value="{{ isset($kekerasanAnak) ? $kekerasanAnak->tanggal_lahir : old('tanggal_lahir') }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Alamat Lengkap</label>
                        <input type="text" class="form-control" name="alamat" placeholder="Masukkan alamat lengkap"
                            readonly id="alamat"
                            value="{{ isset($kekerasanAnak) ? $kekerasanAnak->alamat : old('alamat') }}">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Jenis Kelamin</label>
                        <div class="d-flex">
                            <div class="form-check mr-3">
                                <input type="radio" class="form-check-input" name="jenis_kelamin" value="laki-laki"
                                    id="jk_laki"
                                    {{ old('jenis_kelamin', $kekerasanAnak->jenis_kelamin ?? '') == 'laki-laki' ? 'checked' : '' }}>
                                <label class="form-check-label" for="laki-laki">Laki-laki</label>
                            </div>
                            <div class="form-check">
                                <input type="radio" class="form-check-input" name="jenis_kelamin" value="perempuan"
                                    id="jk_perempuan"
                                    {{ old('jenis_kelamin', $kekerasanAnak->jenis_kelamin ?? '') == 'perempuan' ? 'checked' : '' }}>
                                <label class="form-check-label" for="perempuan">Perempuan</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label>Diperoleh dari</label>
                        <input type="text" class="form-control" name="diperoleh_dari"
                            placeholder="Masukkan diperoleh dari"
                            value="{{ isset($kekerasanAnak) ? $kekerasanAnak->diperoleh_dari : old('diperoleh_dari') }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Hubungan dengan pasien</label>
                        <input type="text" class="form-control" name="hubungan_pasien"
                            placeholder="Masukkan hubungan dengan pasien"
                            value="{{ isset($kekerasanAnak) ? $kekerasanAnak->hubungan_pasien : old('hubungan_pasien') }}">
                    </div>
                </div>
            </div>

            <div class="form-section mt-4">
                <h3>Anamnesa dan Pemeriksaan Fisik</h3>

                <div class="form-group">
                    <label>1. Bentuk kekerasan</label>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="kekerasan[]" value="seksual"
                                    id="seksual"
                                    {{ isset($kekerasanAnak->kekerasan) && in_array('seksual', $kekerasanAnak->kekerasan) ? 'checked' : '' }}>
                                <label class="form-check-label" for="seksual">Kekerasan seksual</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="kekerasan[]" value="fisik"
                                    id="fisik"
                                    {{ isset($kekerasanAnak->kekerasan) && in_array('fisik', $kekerasanAnak->kekerasan) ? 'checked' : '' }}>
                                <label class="form-check-label" for="fisik">Kekerasan fisik</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="kekerasan[]" value="psikis"
                                    id="psikis"
                                    {{ isset($kekerasanAnak->kekerasan) && in_array('psikis', $kekerasanAnak->kekerasan) ? 'checked' : '' }}>
                                <label class="form-check-label" for="psikis">Kekerasan psikis</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="kekerasan[]" value="penelantaran"
                                    id="penelantaran"
                                    {{ isset($kekerasanAnak->kekerasan) && in_array('penelantaran', $kekerasanAnak->kekerasan) ? 'checked' : '' }}>
                                <label class="form-check-label" for="penelantaran">Penelantaran:</label>
                            </div>
                            <div class="form-check ml-3">
                                <input type="checkbox" class="form-check-input" name="kekerasan[]" value="gizi"
                                    id="gizi"
                                    {{ isset($kekerasanAnak->kekerasan) && in_array('gizi', $kekerasanAnak->kekerasan) ? 'checked' : '' }}>
                                <label class="form-check-label" for="gizi">Gizi</label>
                            </div>
                            <div class="form-check ml-3">
                                <input type="checkbox" class="form-check-input" name="kekerasan[]" value="pendidikan"
                                    id="pendidikan"
                                    {{ isset($kekerasanAnak->kekerasan) && in_array('pendidikan', $kekerasanAnak->kekerasan) ? 'checked' : '' }}>
                                <label class="form-check-label" for="pendidikan">Pendidikan</label>
                            </div>
                            <div class="form-check ml-3">
                                <input type="checkbox" class="form-check-input" name="kekerasan[]" value="ekonomi"
                                    id="ekonomi"
                                    {{ isset($kekerasanAnak->kekerasan) && in_array('ekonomi', $kekerasanAnak->kekerasan) ? 'checked' : '' }}>
                                <label class="form-check-label" for="ekonomi">Ekonomi</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label>2. Tempat kejadian</label>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="tempat[]"
                                    value="dalam_rumah_tangga" id="dalam_rumah_tangga"
                                    {{ isset($kekerasanAnak->tempat) && in_array('dalam_rumah_tangga', $kekerasanAnak->tempat) ? 'checked' : '' }}>
                                <label class="form-check-label" for="dalam_rumah_tangga">Dalam rumah tangga</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="tempat[]" value="tempat_kerja"
                                    id="tempat_kerja"
                                    {{ isset($kekerasanAnak->tempat) && in_array('tempat_kerja', $kekerasanAnak->tempat) ? 'checked' : '' }}>
                                <label class="form-check-label" for="tempat_kerja">Di tempat kerja/sekolah</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="tempat[]" value="jalanan"
                                    id="jalanan"
                                    {{ isset($kekerasanAnak->tempat) && in_array('jalanan', $kekerasanAnak->tempat) ? 'checked' : '' }}>
                                <label class="form-check-label" for="jalanan">Jalanan</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="tempat[]" value="daerah_konflik"
                                    id="daerah_konflik"
                                    {{ isset($kekerasanAnak->tempat) && in_array('daerah_konflik', $kekerasanAnak->tempat) ? 'checked' : '' }}>
                                <label class="form-check-label" for="daerah_konflik">Di daerah konflik</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="tempat[]" value="lain_lain"
                                    id="lain_lain"
                                    {{ isset($kekerasanAnak->tempat) && in_array('lain_lain', $kekerasanAnak->tempat) ? 'checked' : '' }}
                                    onclick="toggleTextInput()">
                                <label class="form-check-label" for="lain_lain">Lain-lain, sebutkan</label>
                            </div>
                            <div id="lain_lain_input"
                                style="display: {{ isset($kekerasanAnak->tempat) && in_array('lain_lain', $kekerasanAnak->tempat) ? 'block' : 'none' }}; margin-top: 10px;">
                                <label for="tempat_lain">Sebutkan tempat lainnya:</label>
                                <input type="text" class="form-control" name="tempat_lain" id="tempat_lain"
                                    value="{{ $kekerasanAnak->tempat_lain ?? '' }}">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label>3. Dampak yang terjadi pada pasien dengan kdrt</label>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="dampak_pasien[]"
                                    value="cidera_bilateral" id="cidera_bilateral"
                                    {{ isset($kekerasanAnak->dampak_pasien) && in_array('cidera_bilateral', $kekerasanAnak->dampak_pasien) ? 'checked' : '' }}>
                                <label class="form-check-label" for="cidera_bilateral">Cidera bilateral /
                                    multilateral</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="dampak_pasien[]"
                                    value="cidera_penyembuhan" id="cidera_penyembuhan"
                                    {{ isset($kekerasanAnak->dampak_pasien) && in_array('cidera_penyembuhan', $kekerasanAnak->dampak_pasien) ? 'checked' : '' }}>
                                <label class="form-check-label" for="cidera_penyembuhan">Beberapa cidera dengan beberapa
                                    tampak penyembuhan</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="dampak_pasien[]"
                                    value="tidak_sesuai" id="tidak_sesuai"
                                    {{ isset($kekerasanAnak->dampak_pasien) && in_array('tidak_sesuai', $kekerasanAnak->dampak_pasien) ? 'checked' : '' }}>
                                <label class="form-check-label" for="tidak_sesuai">Keterangan yang tidak sesuai dengan
                                    cideranya</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="dampak_pasien[]"
                                    value="pertolongan_terlambat" id="pertolongan_terlambat"
                                    {{ isset($kekerasanAnak->dampak_pasien) && in_array('pertolongan_terlambat', $kekerasanAnak->dampak_pasien) ? 'checked' : '' }}>
                                <label class="form-check-label" for="pertolongan_terlambat">Keterlambatan mendapatkan
                                    pertolongan medis / berobat</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="dampak_pasien[]"
                                    value="kekerasan_berulang" id="kekerasan_berulang"
                                    {{ isset($kekerasanAnak->dampak_pasien) && in_array('kekerasan_berulang', $kekerasanAnak->dampak_pasien) ? 'checked' : '' }}>
                                <label class="form-check-label" for="kekerasan_berulang">Berulangnya mendapatkan kekerasan
                                    fisik dan berobat ke Puskesmas akibat dari trauma</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label>4. Dampak kekerasan pada anak (Psychological Abuse)</label>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="dampak_pada_anak[]"
                                    value="ekspresi_wajah" id="ekspresi_wajah"
                                    {{ isset($kekerasanAnak->dampak_pada_anak) && in_array('ekspresi_wajah', $kekerasanAnak->dampak_pada_anak ?? []) ? 'checked' : '' }}>
                                <label class="form-check-label" for="ekspresi_wajah">Ekpresi wajah:</label>
                            </div>
                            <div class="form-check ml-3">
                                <input type="checkbox" class="form-check-input" name="dampak_pada_anak[]" value="sedih"
                                    id="sedih"
                                    {{ isset($kekerasanAnak->dampak_pada_anak) && in_array('sedih', $kekerasanAnak->dampak_pada_anak ?? []) ? 'checked' : '' }}>
                                <label class="form-check-label" for="sedih">Sedih</label>
                            </div>
                            <div class="form-check ml-3">
                                <input type="checkbox" class="form-check-input" name="dampak_pada_anak[]" value="takut"
                                    id="takut"
                                    {{ isset($kekerasanAnak->dampak_pada_anak) && in_array('takut', $kekerasanAnak->dampak_pada_anak ?? []) ? 'checked' : '' }}>
                                <label class="form-check-label" for="takut">Takut</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="dampak_pada_anak[]"
                                    value="agresif" id="agresif"
                                    {{ isset($kekerasanAnak->dampak_pada_anak) && in_array('agresif', $kekerasanAnak->dampak_pada_anak ?? []) ? 'checked' : '' }}>
                                <label class="form-check-label" for="agresif">Perubahan perilaku anak agresif atau
                                    penarikan diri yang berlebihan</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="dampak_pada_anak[]"
                                    value="cerita_berubah" id="cerita_berubah"
                                    {{ isset($kekerasanAnak->dampak_pada_anak) && in_array('cerita_berubah', $kekerasanAnak->dampak_pada_anak ?? []) ? 'checked' : '' }}>
                                <label class="form-check-label" for="cerita_berubah">Cerita yang berubah dari ucapan yang
                                    sebelumnya</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="dampak_pada_anak[]"
                                    value="lari_dari_rumah" id="lari_dari_rumah"
                                    {{ isset($kekerasanAnak->dampak_pada_anak) && in_array('lari_dari_rumah', $kekerasanAnak->dampak_pada_anak ?? []) ? 'checked' : '' }}>
                                <label class="form-check-label" for="lari_dari_rumah">Lari dari rumah atau melakukan
                                    kenakalan remaja</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="dampak_pada_anak[]"
                                    value="hindari_kontak_mata" id="hindari_kontak_mata"
                                    {{ isset($kekerasanAnak->dampak_pada_anak) && in_array('hindari_kontak_mata', $kekerasanAnak->dampak_pada_anak ?? []) ? 'checked' : '' }}>
                                <label class="form-check-label" for="hindari_kontak_mata">Menghindari kontak mata</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="dampak_pada_anak[]" value="pasif"
                                    id="pasif"
                                    {{ isset($kekerasanAnak->dampak_pada_anak) && in_array('pasif', $kekerasanAnak->dampak_pada_anak ?? []) ? 'checked' : '' }}>
                                <label class="form-check-label" for="pasif">Terlalu penurut / pasif</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="dampak_pada_anak[]"
                                    value="lari_dari_orang_tua" id="lari_dari_orang_tua"
                                    {{ isset($kekerasanAnak->dampak_pada_anak) && in_array('lari_dari_orang_tua', $kekerasanAnak->dampak_pada_anak ?? []) ? 'checked' : '' }}>
                                <label class="form-check-label" for="lari_dari_orang_tua">Menjauhi orang tua atau
                                    pengasuh</label>
                            </div>
                        </div>
                    </div>
                </div>



                <div class="form-group">
                    <label>5. Penelantaran fisik pada anak</label>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="penelantaran_fisik[]"
                                    value="gagal_tumbuh" id="gagal_tumbuh"
                                    {{ in_array('gagal_tumbuh', $kekerasanAnak->penelantaran_fisik ?? []) ? 'checked' : '' }}>
                                <label class="form-check-label" for="gagal_tumbuh">Gagal tumbuh / keterlambatan
                                    perkembangan
                                    fisik maupun mental</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="penelantaran_fisik[]"
                                    value="luka" id="luka"
                                    {{ in_array('luka', $kekerasanAnak->penelantaran_fisik ?? []) ? 'checked' : '' }}>
                                <label class="form-check-label" for="luka">Luka / penyakit yang dibiarkan tidak
                                    diobati</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="penelantaran_fisik[]"
                                    value="lemah" id="lemah"
                                    {{ in_array('lemah', $kekerasanAnak->penelantaran_fisik ?? []) ? 'checked' : '' }}>
                                <label class="form-check-label" for="lemah">Keadaan Umum (KU) lemah atau
                                    letargi</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="penelantaran_fisik[]"
                                    value="pakaian_lusuh" id="pakaian_lusuh"
                                    {{ in_array('pakaian_lusuh', $kekerasanAnak->penelantaran_fisik ?? []) ? 'checked' : '' }}>
                                <label class="form-check-label" for="pakaian_lusuh">Pakaian yang lusuh dan kotor</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label>6. Tanda-tanda yang didapatkan pada korban kekerasan</label>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-check form-check-inline">
                                <!-- Check if the checkbox was checked (either from DB or old input) -->
                                <input type="checkbox" class="form-check-input" name="tanda_kekerasan_check[]"
                                    value="memar" style="margin-right: 10px;"
                                    {{ (isset($kekerasanAnak->tanda_kekerasan_check) &&
                                        is_array($kekerasanAnak->tanda_kekerasan_check) &&
                                        in_array('memar', $kekerasanAnak->tanda_kekerasan_check)) ||
                                    (is_array(old('tanda_kekerasan_check')) && in_array('memar', old('tanda_kekerasan_check')))
                                        ? 'checked'
                                        : '' }}>
                                <label style="width: 250px;">Terdapat memar di</label>

                                <!-- Use old input value for the text field, or value from DB if available -->
                                <input type="text" class="form-control" name="tanda_kekerasan[]"
                                    placeholder="Masukkan lokasi memar"
                                    value="{{ old('tanda_kekerasan.0', isset($kekerasanAnak->tanda_kekerasan[0]) ? $kekerasanAnak->tanda_kekerasan[0] : '') }}"
                                    style="width: calc(60% - 160px); display: inline-block;">
                            </div>
                        </div>


                        <div class="col-md-12">
                            <div class="form-check form-check-inline">
                                <input type="checkbox" class="form-check-input" name="tanda_kekerasan_check[]"
                                    value="robek" style="margin-right: 10px;"
                                    {{ (isset($kekerasanAnak->tanda_kekerasan_check) && in_array('robek', $kekerasanAnak->tanda_kekerasan_check)) ||
                                    old('tanda_kekerasan_check')
                                        ? 'checked'
                                        : '' }}>
                                <label style="width: 250px;">Luka lecet dan luka robek di</label>
                                <input type="text" class="form-control" name="tanda_kekerasan[]"
                                    placeholder="Masukkan lokasi luka lecet dan luka robek"
                                    value="{{ old('tanda_kekerasan', isset($kekerasanAnak->tanda_kekerasan[1]) ? $kekerasanAnak->tanda_kekerasan[1] : '') }}"
                                    style="width: calc(60% - 160px); display: inline-block;">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-check form-check-inline">
                                <input type="checkbox" class="form-check-input" style="margin-right: 10px;"
                                    name="tanda_kekerasan_check[]" value="patah"
                                    {{ (isset($kekerasanAnak->tanda_kekerasan_check) && in_array('patah', $kekerasanAnak->tanda_kekerasan_check)) ||
                                    old('tanda_kekerasan_check')
                                        ? 'checked'
                                        : '' }}>
                                <label style="width: 250px;">Patah tulang baru / lama di</label>
                                <input type="text" class="form-control" name="tanda_kekerasan[]"
                                    placeholder="Masukkan lokasi patah tulang baru/lama"
                                    value="{{ old('tanda_kekerasan', isset($kekerasanAnak->tanda_kekerasan[2]) ? $kekerasanAnak->tanda_kekerasan[2] : '') }}"
                                    style="width: calc(60% - 160px); display: inline-block;">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-check form-check-inline">
                                <input type="checkbox" class="form-check-input" style="margin-right: 10px;"
                                    name="tanda_kekerasan_check[]" value="gigi_patah"
                                    {{ (isset($kekerasanAnak->tanda_kekerasan_check) &&
                                        in_array('gigi_patah', $kekerasanAnak->tanda_kekerasan_check)) ||
                                    old('tanda_kekerasan_check')
                                        ? 'checked'
                                        : '' }}>
                                <label style="width: 250px;">Gigi Patah / Berdarah</label>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-check form-check-inline">
                                <input type="checkbox" class="form-check-input" style="margin-right: 10px;"
                                    name="tanda_kekerasan_check[]" value="luka_bakar"
                                    {{ (isset($kekerasanAnak->tanda_kekerasan_check) &&
                                        in_array('luka_bakar', $kekerasanAnak->tanda_kekerasan_check)) ||
                                    old('tanda_kekerasan_check')
                                        ? 'checked'
                                        : '' }}>
                                <label style="width: 250px;">Terdapat luka bakar di lokasi</label>
                                <input type="text" class="form-control" name="tanda_kekerasan[]"
                                    placeholder="Masukkan lokasi luka bakar"
                                    value="{{ old('tanda_kekerasan', isset($kekerasanAnak->tanda_kekerasan[3]) ? $kekerasanAnak->tanda_kekerasan[3] : '') }}"
                                    style="width: calc(40% - 160px); display: inline-block;">
                                <label style="margin-left: 10px;">derajat</label>
                                <input type="text" class="form-control" name="derajat_luka_bakar"
                                    value="{{ old('derajat_luka_bakar', isset($kekerasanAnak->derajat_luka_bakar) ? $kekerasanAnak->derajat_luka_bakar : '') }}"
                                    placeholder="Derajat" style="width: 100px; display: inline-block; margin-left: 10px;">
                                <label style="margin-left: 5px;">%</label>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-check form-check-inline">
                                <input type="checkbox" class="form-check-input" style="margin-right: 10px;"
                                    name="tanda_kekerasan_check[]" value="cedera"
                                    {{ (isset($kekerasanAnak->tanda_kekerasan_check) &&
                                        in_array('cedera', $kekerasanAnak->tanda_kekerasan_check)) ||
                                    old('tanda_kekerasan_check')
                                        ? 'checked'
                                        : '' }}>
                                <label style="width: 250px;">Cedera kepala di daerah</label>
                                <input type="text" class="form-control" name="tanda_kekerasan[]"
                                    placeholder="Masukkan lokasi cedera kepala"
                                    value="{{ old('tanda_kekerasan', isset($kekerasanAnak->tanda_kekerasan[4]) ? $kekerasanAnak->tanda_kekerasan[4] : '') }}"
                                    style="width: calc(60% - 160px); display: inline-block;">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label>7. Tanda kekerasan seksual (Sexual Abuse)</label>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="kekerasan_seksual[]"
                                    value="luka_alat_kelamin" id="luka_alat_kelamin"
                                    {{ isset($kekerasanAnak) && in_array('luka_alat_kelamin', $kekerasanAnak->kekerasan_seksual ?? []) ? 'checked' : '' }}>
                                <label class="form-check-label" for="luka_alat_kelamin">Adanya perlukaan /jejas pada alat
                                    kelamin</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="kekerasan_seksual[]"
                                    value="nyeri_vagina" id="nyeri_vagina"
                                    {{ isset($kekerasanAnak) && in_array('nyeri_vagina', $kekerasanAnak->kekerasan_seksual ?? []) ? 'checked' : '' }}>
                                <label class="form-check-label" for="nyeri_vagina">Adanya rasa nyeri, perdarahan dari
                                    vagina</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label>8. Dampak yang terjadi pada korban kekerasan perkosaan</label>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="dampak_kekerasan[]"
                                    value="rasa_takut" id="rasa_takut"
                                    {{ isset($kekerasanAnak) && in_array('rasa_takut', $kekerasanAnak->dampak_kekerasan ?? []) ? 'checked' : '' }}>
                                <label class="form-check-label" for="rasa_takut">Rasa Takut</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="dampak_kekerasan[]" value="cemas"
                                    id="cemas"
                                    {{ isset($kekerasanAnak) && in_array('cemas', $kekerasanAnak->dampak_kekerasan ?? []) ? 'checked' : '' }}>
                                <label class="form-check-label" for="cemas">Cemas</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="dampak_kekerasan[]" value="gugup"
                                    id="gugup"
                                    {{ isset($kekerasanAnak) && in_array('gugup', $kekerasanAnak->dampak_kekerasan ?? []) ? 'checked' : '' }}>
                                <label class="form-check-label" for="gugup">Gugup</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="dampak_kekerasan[]"
                                    value="depresi" id="depresi"
                                    {{ isset($kekerasanAnak) && in_array('depresi', $kekerasanAnak->dampak_kekerasan ?? []) ? 'checked' : '' }}>
                                <label class="form-check-label" for="depresi">Depresi</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="dampak_kekerasan[]"
                                    value="bingung" id="bingung"
                                    {{ isset($kekerasanAnak) && in_array('bingung', $kekerasanAnak->dampak_kekerasan ?? []) ? 'checked' : '' }}>
                                <label class="form-check-label" for="bingung">Tampak serba bingung</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="dampak_kekerasan[]"
                                    value="mata_tidak_fokus" id="mata_tidak_fokus"
                                    {{ isset($kekerasanAnak) && in_array('mata_tidak_fokus', $kekerasanAnak->dampak_kekerasan ?? []) ? 'checked' : '' }}>
                                <label class="form-check-label" for="mata_tidak_fokus">Mata tidak fokus</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="dampak_kekerasan[]" value="tegang"
                                    id="tegang"
                                    {{ isset($kekerasanAnak) && in_array('tegang', $kekerasanAnak->dampak_kekerasan ?? []) ? 'checked' : '' }}>
                                <label class="form-check-label" for="tegang">Tegang</label>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="dampak_kekerasan[]"
                                    value="sulit_bicara" id="sulit_bicara"
                                    {{ isset($kekerasanAnak) && in_array('sulit_bicara', $kekerasanAnak->dampak_kekerasan ?? []) ? 'checked' : '' }}>
                                <label class="form-check-label" for="sulit_bicara">Sulit bicara</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="dampak_kekerasan[]"
                                    value="banyak_melamun" id="banyak_melamun"
                                    {{ isset($kekerasanAnak) && in_array('banyak_melamun', $kekerasanAnak->dampak_kekerasan ?? []) ? 'checked' : '' }}>
                                <label class="form-check-label" for="banyak_melamun">Banyak melamun</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="dampak_kekerasan[]"
                                    value="ekspresi_tegang" id="ekspresi_tegang"
                                    {{ isset($kekerasanAnak) && in_array('ekspresi_tegang', $kekerasanAnak->dampak_kekerasan ?? []) ? 'checked' : '' }}>
                                <label class="form-check-label" for="ekspresi_tegang">Ekspresi wajah tegang</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="dampak_kekerasan[]"
                                    value="penampilan_tidak_rapi" id="penampilan_tidak_rapi"
                                    {{ isset($kekerasanAnak) && in_array('penampilan_tidak_rapi', $kekerasanAnak->dampak_kekerasan ?? []) ? 'checked' : '' }}>
                                <label class="form-check-label" for="penampilan_tidak_rapi">Penampilan tidak rapi atau
                                    tidak teratur</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="dampak_kekerasan[]"
                                    value="kebencian_kemarahan" id="kebencian_kemarahan"
                                    {{ isset($kekerasanAnak) && in_array('kebencian_kemarahan', $kekerasanAnak->dampak_kekerasan ?? []) ? 'checked' : '' }}>
                                <label class="form-check-label" for="kebencian_kemarahan">Terlihat menunjukkan kebencian
                                    dan kemarahan</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="dampak_kekerasan[]"
                                    value="mudah_curiga" id="mudah_curiga"
                                    {{ isset($kekerasanAnak) && in_array('mudah_curiga', $kekerasanAnak->dampak_kekerasan ?? []) ? 'checked' : '' }}>
                                <label class="form-check-label" for="mudah_curiga">Mudah curiga kepada orang lain</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="dampak_kekerasan[]"
                                    value="perasaan_sensitif" id="perasaan_sensitif"
                                    {{ isset($kekerasanAnak) && in_array('perasaan_sensitif', $kekerasanAnak->dampak_kekerasan ?? []) ? 'checked' : '' }}>
                                <label class="form-check-label" for="perasaan_sensitif">Perasaan sensitif</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group mt-4">
                        <div class="form-group">
                            <div class="col-md-12">
                                <label for="kesimpulan" style="color: rgb(19, 11, 241);">Kesimpulan</label>
                                <textarea class="form-control" id="kesimpulan" name="kesimpulan" placeholder="Kesimpulan">{{ old('kesimpulan', $kekerasanAnak->kesimpulan ?? '') }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>


            </div>

            <div class="text-right mt-4">
                {{-- @if (isset($kekerasanAnak))
                    <a href="{{ route('kekerasan.anak.admin') }}" type="button" class="btn btn-secondary mr-2"
                        style="font-size: 20px">Kembali</a>
                @else
                    <a href="{{ route('skrining.ilp') }}" type="button" class="btn btn-secondary mr-2"
                        style="font-size: 20px">Kembali</a>
                @endif --}}
                <button type="submit" class="btn btn-primary" style="font-size: 20px">Kirim</button>
            </div>
    </form>
    <script>
        function toggleTextInput() {
            var checkbox = document.getElementById('lain_lain');
            var textInput = document.getElementById('lain_lain_input');

            // Tampilkan atau sembunyikan input teks berdasarkan status checkbox
            if (checkbox.checked) {
                textInput.style.display = 'block';
            } else {
                textInput.style.display = 'none';
            }
        }
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
                var pob = selectedOption.data('pob');



                $('#tanggal_lahir').val(dob);
                $('#alamat').val(alamat);
                $('#tempat_lahir').val(pob);
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
>>>>>>> 9df8fede466960d27744a11e4cb830e2a9437611
