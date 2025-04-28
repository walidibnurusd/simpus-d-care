@extends('layouts.skrining.master-fluid')
@section('title', 'Skrining Malaria')
<style>
    .keterangan ul {
        list-style-type: none;
        padding-left: 0;
    }

    .keterangan ul li {
        margin-bottom: 5px;
    }

    .keterangan strong {
        font-weight: bold;
    }
</style>
@section('content')
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

    <form action="{{ isset($malaria) ? route('malaria.update', $malaria->id) : route('malaria.store') }}" method="POST">
        @csrf
        @if (isset($malaria))
            @method('PUT')
        @endif
        @if ($routeName === 'malaria.view')
            <input type="hidden" name="klaster" value="2">
            <input type="hidden" name="poli" value="kia">
        @elseif($routeName === 'anemia.mtbs.view')
            <input type="hidden" name="klaster" value="2">
            <input type="hidden" name="poli" value="mtbs">
        @elseif($routeName === 'anemia.lansia.view')
            <input type="hidden" name="klaster" value="3">
            <input type="hidden" name="poli" value="lansia">
        @endif

        <div class="form-section">
            <h3>A. Penyelidikan Kasus</h3>
            <h4>A.1 Identitas</h4>
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
                        </select>
                        @error('pasien')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Tanggal Lahir</label>
                        <input type="date" class="form-control" name="tanggal_lahir" id="tanggal_lahir" readonly
                            value="{{ old('tanggal_lahir', $pasien->dob ?? '') }}">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Umur</label>
                        <input type="text" class="form-control" name="umur" readonly id="umurInput">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Status Kehamilan</label>
                        <input taype="text" class="form-control" name="hamil" readonly id="hamil"
                            value="{{ $hamil ? 'Hamil' : 'Tidak Hamil' }}">
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label>Pekerjaan</label>
                        <input type="text" class="form-control" name="pekerjaan" placeholder="Masukkan pekerjaan lengkap"
                            readonly id="pekerjaan" value="{{ old('pekerjaan', $pasien->occupations->name ?? '') }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>No HP</label>
                        <input type="text" class="form-control" name="no_hp" readonly id="no_hp"
                            value="{{ old('no_hp', $pasien->phone ?? '') }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Alamat Lengkap</label>
                        <input type="text" class="form-control" name="alamat_lengkap"
                            placeholder="Masukkan alamat lengkap" readonly id="alamat_lengkap"
                            value="{{ old('alamat_lengkap', $pasien->address ?? '') }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Jenis Kelamin</label>
                        <div class="d-flex">
                            <div class="form-check mr-3">
                                <input type="radio" class="form-check-input" name="jenis_kelamin" value="laki-laki"
                                    id="jk_laki"
                                    {{ old('jenis_kelamin', $pasien->gender ?? '2') == '2' ? 'checked' : '' }}>
                                <label class="form-check-label" for="laki-laki">Laki-laki</label>
                            </div>
                            <div class="form-check">
                                <input type="radio" class="form-check-input" name="jenis_kelamin" value="perempuan"
                                    id="jk_perempuan"
                                    {{ old('jenis_kelamin', $pasien->gender ?? '1') == '1' ? 'checked' : '' }}>
                                <label class="form-check-label" for="perempuan">Perempuan</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Alamat tinggal di daerah endemis malaria ( RT/RW, Kelurahan, Kecamatan, Kota /
                            Kabupaten, Provinsi ) :</label>
                        <input type="text" class="form-control" name="alamat"
                            placeholder="Masukkan alamat tinggal di daerah endemis" id="alamat"
                            value="{{ old('alamat', $malaria->alamat ?? '') }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Gejala yang dirasakan (demam, menggigil, nyeri kepala, mual, muntah, diare,
                            pegal-pegal, nyeri otot) : </label>
                        <input type="text" class="form-control" name="gejala"
                            placeholder="Masukkan gejala yang dirasakan" id="gejala"
                            value="{{ old('gejala', $malaria->gejala ?? '') }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Jenis Wilayah ( Hutan, Tambang, Kebun) :</label>
                        <input type="text" class="form-control" name="jenis_wilayah"
                            placeholder="Masukkan jenis wilayah" id="jenis_wilayah"
                            value="{{ old('jenis_wilayah', $malaria->jenis_wilayah ?? '') }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Tanggal muncul gejala</label>
                        <input type="date" class="form-control" name="tanggal_gejala"
                            value="{{ old('tanggal_gejala', $malaria->tanggal_gejala ?? '') }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Hasil pemeriksaan darah ( miskroskop / RDT ) :</label>
                        <div class="d-flex">
                            <div class="form-check mr-3">
                                <input type="radio" class="form-check-input" name="hasil_darah" value="1"
                                    {{ old('hasil_darah', $malaria->hasil_darah ?? '') == 1 ? 'checked' : '' }}>
                                <label class="form-check-label">Positif</label>
                            </div>
                            <div class="form-check">
                                <input type="radio" class="form-check-input" name="hasil_darah" value="0"
                                    {{ old('hasil_darah', $malaria->hasil_darah ?? '') == 0 ? 'checked' : '' }}>
                                <label class="form-check-label">Negatif</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Jenis Parasit</label>
                        <input type="text" class="form-control" name="jenis_parasit"
                            value="{{ old('jenis_parasit', $malaria->jenis_parasit ?? '') }}">
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Riwayat pernah menderita malaria sebelumnya?</label>
                        <div class="d-flex">
                            <div class="form-check mr-3">
                                <input type="radio" class="form-check-input" name="riwayat_malaria"
                                    id="riwayat_malaria_pernah" value="1"
                                    {{ old('riwayat_malaria', $malaria->riwayat_malaria ?? '') == 1 ? 'checked' : '' }}>
                                <label class="form-check-label" for="riwayat_malaria_pernah">Pernah</label>
                            </div>
                            <div class="form-check">
                                <input type="radio" class="form-check-input" name="riwayat_malaria"
                                    id="riwayat_malaria_tidak" value="0"
                                    {{ old('riwayat_malaria', $malaria->riwayat_malaria ?? '') == 0 ? 'checked' : '' }}>
                                <label class="form-check-label" for="riwayat_malaria_tidak">Tidak</label>
                            </div>
                        </div>
                    </div>

                    <div id="additional_questions" style="display: none;">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="waktu">Waktu:</label>
                                <input type="text" id="waktu" name="waktu" class="form-control"
                                    value=" {{ old('waktu', $malaria->waktu ?? '') }}">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="jenis_parasit_malaria">Jenis Parasit:</label>
                                <input type="text" id="jenis_parasit_malaria" name="jenis_parasit_malaria"
                                    value=" {{ old('jenis_parasit_malaria', $malaria->jenis_parasit_malaria ?? '') }}"
                                    class="form-control">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="jenis_obat_malaria">Jenis Obat yang Didapatkan:</label>
                                <input type="text" id="jenis_obat_malaria" name="jenis_obat_malaria"
                                    value=" {{ old('jenis_obat_malaria', $malaria->jenis_obat_malaria ?? '') }}"
                                    class="form-control">
                            </div>
                        </div>
                    </div>
                </div>


            </div>
            <h4>A.2 Riwayat Kasus</h4>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Tanggal Terdiagnosis</label>
                        <input type="date" class="form-control" name="tanggal_diagnosis" id="tanggal_diagnosis"
                            value="{{ old('tanggal_diagnosis', $malaria->tanggal_diagnosis ?? '') }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Diagnosis</label>
                        <input type="text" class="form-control" name="diagnosis"
                            value=" {{ old('diagnosis', $malaria->diagnosis ?? '') }}">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Fasyankes Tempat Diagnosis</label>
                        <input type="text" class="form-control" name="fasyankes"
                            value=" {{ old('fasyankes', $malaria->fasyankes ?? '') }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Perawatan</label>
                        <input type="text" class="form-control" name="perawatan" placeholder="Masukkan perawatan"
                            id="perawatan" value="{{ old('perawatan', $malaria->perawatan ?? '') }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>No Rekam Medis</label>
                        <input type="text" class="form-control" name="no_rm" id="no_rm"
                            value="{{ old('no_rm', $malaria->no_rm ?? '') }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Metode Diagnosis</label>
                        <input type="text" class="form-control" name="metode_diagnosis" id="metode_diagnosis"
                            value="{{ old('metode_diagnosis', $malaria->metode_diagnosis ?? '') }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Jenis Parasit</label>
                        <input type="text" class="form-control" name="jenis_parasit_malaria_sebelumnya"
                            id="jenis_parasit_malaria_sebelumnya"
                            value="{{ old('jenis_parasit_malaria_sebelumnya', $malaria->jenis_parasit_malaria_sebelumnya ?? '') }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Tanggal muncul gejala</label>
                        <input type="date" class="form-control" name="riwayat_tanggal_gejala"
                            value="{{ old('riwayat_tanggal_gejala', $malaria->riwayat_tanggal_gejala ?? '') }}">
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group">
                        <label>Riwayat pernah menderita malaria sebelumnya?</label>
                        <div class="d-flex">
                            <div class="form-check mr-3">
                                <input type="radio" class="form-check-input" name="riwayat_kasus_malaria"
                                    id="riwayat_kasus_malaria_pernah" value="1"
                                    {{ old('riwayat_kasus_malaria', $malaria->riwayat_kasus_malaria ?? '') == 1 ? 'checked' : '' }}>
                                <label class="form-check-label" for="riwayat_malaria_pernah">Pernah</label>
                            </div>
                            <div class="form-check">
                                <input type="radio" class="form-check-input" name="riwayat_kasus_malaria"
                                    id="riwayat_kasus_malaria_tidak" value="0"
                                    {{ old('riwayat_kasus_malaria', $malaria->riwayat_kasus_malaria ?? '') == 0 ? 'checked' : '' }}>
                                <label class="form-check-label" for="riwayat_malaria_tidak">Tidak</label>
                            </div>
                        </div>
                    </div>

                    <div id="additional_questions_kasus" style="display: none;">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="waktu">Waktu:</label>
                                <input type="text" id="kasus_waktu" name="kasus_waktu" class="form-control"
                                    value="{{ old('kasus_waktu', $malaria->kasus_waktu ?? '') }}">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="jenis_parasit">Jenis Parasit:</label>
                                <input type="text" id="kasus_jenis_parasit" name="kasus_jenis_parasit"
                                    value="{{ old('kasus_jenis_parasit', $malaria->kasus_jenis_parasit ?? '') }}"
                                    class="form-control">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="jenis_obat">Jenis Obat yang Didapatkan:</label>
                                <input type="text" id="kasus_jenis_obat" name="kasus_jenis_obat"
                                    value="{{ old('kasus_jenis_obat', $malaria->kasus_jenis_obat ?? '') }}"
                                    class="form-control">
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <h4>A.3 Pengobatan Malaria</h4>
            <div class="col-md-6">
                <div class="form-group">
                    <label>1. Tanggal pengobatan</label>
                    <input type="date" class="form-control" name="tanggal_pengobatan"
                        value="{{ old('tanggal_pengobatan', $malaria->tanggal_pengobatan ?? '') }}">
                </div>
            </div>
            <div class="col-md-12">
                <label><strong>2. Jenis Pengobatan</strong></label>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Jenis Obat</th>
                            <th>Jumlah</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>DHP</td>
                            <td><input type="number" class="form-control" name="jmlh_obat_dhp" min="0"
                                    value="{{ old('jmlh_obat_dhp', $malaria->jmlh_obat_dhp ?? '') }}"
                                    placeholder="Jumlah">
                            </td>
                        </tr>
                        <tr>
                            <td>Primaquin</td>
                            <td><input type="number" class="form-control" name="jmlh_obat_primaquin" min="0"
                                    value="{{ old('jmlh_obat_dhp', $malaria->jmlh_obat_primaquin ?? '') }}"
                                    placeholder="Jumlah"></td>
                        </tr>
                        <tr>
                            <td>Artesunat</td>
                            <td><input type="number" class="form-control" name="jmlh_obat_artesunat" min="0"
                                    value="{{ old('jmlh_obat_artesunat', $malaria->jmlh_obat_artesunat ?? '') }}"
                                    placeholder="Jumlah"></td>
                        </tr>
                        <tr>
                            <td>Artemeter</td>
                            <td><input type="number" class="form-control" name="jmlh_obat_artemeter" min="0"
                                    value="{{ old('jmlh_obat_artemeter', $malaria->jmlh_obat_artemeter ?? '') }}"
                                    placeholder="Jumlah"></td>
                        </tr>
                        <tr>
                            <td>Kina</td>
                            <td><input type="number" class="form-control" name="jmlh_obat_kina" min="0"
                                    value="{{ old('jmlh_obat_kina', $malaria->jmlh_obat_kina ?? '') }}"
                                    placeholder="Jumlah"></td>
                        </tr>
                        <tr>
                            <td>Klindamisin</td>
                            <td><input type="number" class="form-control" name="jmlh_obat_klindamisin" min="0"
                                    value="{{ old('jmlh_obat_klindamisin', $malaria->jmlh_obat_klindamisin ?? '') }}"
                                    placeholder="Jumlah"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>3. Apakah obat dihabiskan sesuai dengan dosis?</label>
                    <div class="d-flex">
                        <div class="form-check mr-3">
                            <input type="radio" class="form-check-input" name="obat_habis" value="1"
                                {{ old('obat_habis', $malaria->obat_habis ?? '') == 1 ? 'checked' : '' }}>
                            <label class="form-check-label">Ya</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="obat_habis" value="0"
                                {{ old('obat_habis', $malaria->obat_habis ?? '') == 0 ? 'checked' : '' }}>
                            <label class="form-check-label">Tidak</label>
                        </div>
                    </div>
                </div>
            </div>
            <h4>A.4 Asal Penularan</h4>
            <div class="col-md-12">
                <label><strong>1. Riwayat Bepergian 2-4 Minggu Terakhir</strong></label>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Lokasi</th>
                            <th>Tgl ... - Tgl ...</th>
                            <th>Tgl ... - Tgl ...</th>
                            <th>Tgl ... - Tgl ...</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Desa</td>
                            <td><input type="text" class="form-control" name="riwayat_desa_1" placeholder="Isi data"
                                    value="{{ old('riwayat_desa_1', $malaria->riwayat_desa_1 ?? '') }}">
                            </td>
                            <td><input type="text" class="form-control" name="riwayat_desa_2" placeholder="Isi data"
                                    value="{{ old('riwayat_desa_2', $malaria->riwayat_desa_2 ?? '') }}">
                            </td>
                            <td><input type="text" class="form-control" name="riwayat_desa_3" placeholder="Isi data"
                                    value="{{ old('riwayat_desa_3', $malaria->riwayat_desa_3 ?? '') }}">
                            </td>
                        </tr>
                        <tr>
                            <td>Kecamatan</td>
                            <td><input type="text" class="form-control" name="riwayat_kecamatan_1"
                                    value="{{ old('riwayat_kecamatan_1', $malaria->riwayat_kecamatan_1 ?? '') }}"
                                    placeholder="Isi data"></td>
                            <td><input type="text" class="form-control"
                                    name="riwayat_kecamatan_2"value="{{ old('riwayat_kecamatan_2', $malaria->riwayat_kecamatan_2 ?? '') }}"
                                    placeholder="Isi data"></td>
                            <td><input type="text" class="form-control" name="riwayat_kecamatan_3"
                                    value="{{ old('riwayat_kecamatan_3', $malaria->riwayat_kecamatan_3 ?? '') }}"
                                    placeholder="Isi data"></td>
                        </tr>
                        <tr>
                            <td>Kabupaten/Kota</td>
                            <td><input type="text" class="form-control" name="riwayat_kabupaten_1"
                                    value="{{ old('riwayat_kabupaten_1', $malaria->riwayat_kabupaten_1 ?? '') }}"
                                    placeholder="Isi data"></td>
                            <td><input type="text" class="form-control" name="riwayat_kabupaten_2"
                                    value="{{ old('riwayat_kabupaten_2', $malaria->riwayat_kabupaten_2 ?? '') }}"
                                    placeholder="Isi data"></td>
                            <td><input type="text" class="form-control" name="riwayat_kabupaten_3"
                                    value="{{ old('riwayat_kabupaten_3', $malaria->riwayat_kabupaten_3 ?? '') }}"
                                    placeholder="Isi data"></td>
                        </tr>
                        <tr>
                            <td>Provinsi</td>
                            <td><input type="text" class="form-control" name="riwayat_provinsi_1"
                                    value="{{ old('riwayat_provinsi_1', $malaria->riwayat_provinsi_1 ?? '') }}"
                                    placeholder="Isi data"></td>
                            <td><input type="text" class="form-control" name="riwayat_provinsi_2"
                                    value="{{ old('riwayat_provinsi_2', $malaria->riwayat_provinsi_2 ?? '') }}"
                                    placeholder="Isi data"></td>
                            <td><input type="text" class="form-control" name="riwayat_provinsi_3"
                                    value="{{ old('riwayat_provinsi_3', $malaria->riwayat_provinsi_3 ?? '') }}"
                                    placeholder="Isi data"></td>
                        </tr>
                        <tr>
                            <td>Negara</td>
                            <td><input type="text" class="form-control" name="riwayat_negara_1"
                                    value="{{ old('riwayat_negara_1', $malaria->riwayat_negara_1 ?? '') }}"
                                    placeholder="Isi data"></td>
                            <td><input type="text" class="form-control" name="riwayat_negara_2"
                                    value="{{ old('riwayat_negara_2', $malaria->riwayat_negara_2 ?? '') }}"
                                    placeholder="Isi data"></td>
                            <td><input type="text" class="form-control" name="riwayat_negara_3"
                                    value="{{ old('riwayat_negara_3', $malaria->riwayat_negara_3 ?? '') }}"
                                    placeholder="Isi data"></td>
                        </tr>
                        <tr>
                            <td>Jenis Wilayah<br>(Hutan/Tambang/Kebun)</td>
                            <td><input type="text" class="form-control" name="riwayat_jenis_wilayah_1"
                                    value="{{ old('riwayat_jenis_wilayah_1', $malaria->riwayat_jenis_wilayah_1 ?? '') }}"
                                    placeholder="Isi data"></td>
                            <td><input type="text" class="form-control"
                                    name="riwayat_jenis_wilayah_2"value="{{ old('riwayat_jenis_wilayah_2', $malaria->riwayat_jenis_wilayah_2 ?? '') }}"
                                    placeholder="Isi data"></td>
                            <td><input type="text" class="form-control"
                                    name="riwayat_jenis_wilayah_3"value="{{ old('riwayat_jenis_wilayah_3', $malaria->riwayat_jenis_wilayah_3 ?? '') }}"
                                    placeholder="Isi data"></td>
                        </tr>
                        <tr>
                            <td>Kepentingan</td>
                            <td><input type="text" class="form-control"
                                    name="riwayat_kepentingan_1"value="{{ old('riwayat_kepentingan_1', $malaria->riwayat_kepentingan_1 ?? '') }}"
                                    placeholder="Isi data"></td>
                            <td><input type="text" class="form-control"
                                    name="riwayat_kepentingan_2"value="{{ old('riwayat_kepentingan_2', $malaria->riwayat_kepentingan_2 ?? '') }}"
                                    placeholder="Isi data"></td>
                            <td><input type="text" class="form-control"
                                    name="riwayat_kepentingan_3"value="{{ old('riwayat_kepentingan_3', $malaria->riwayat_kepentingan_3 ?? '') }}"
                                    placeholder="Isi data"></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="col-md-12">
                <label><strong>2. Apakah bepergian dalam kelompok (2 orang atau lebih)? sebutkan?</strong></label>
                <table class="table table-bordered" id="kelompokTable">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Alamat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>

                        @if (isset($malaria) && $malaria->kelompokMalaria->isNotEmpty())
                            @foreach ($malaria->kelompokMalaria as $index => $kelompok)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>
                                        <input type="text" class="form-control"
                                            name="kelompok[{{ $index }}][nama]"
                                            value="{{ old("kelompok.{$index}.nama", $kelompok->nama) }}"
                                            placeholder="Nama">
                                    </td>
                                    <td>
                                        <input type="text" class="form-control"
                                            name="kelompok[{{ $index }}][alamat]"
                                            value="{{ old("kelompok.{$index}.alamat", $kelompok->alamat) }}"
                                            placeholder="Alamat">
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-danger remove-row">Hapus</button>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td>1</td>
                                <td>
                                    <input type="text" class="form-control" name="kelompok[0][nama]"
                                        placeholder="Nama">
                                </td>
                                <td>
                                    <input type="text" class="form-control" name="kelompok[0][alamat]"
                                        placeholder="Alamat">
                                </td>
                                <td>
                                    <button type="button" class="btn btn-danger remove-row">Hapus</button>
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
                <button type="button" class="btn btn-primary mb-4" id="addRowKelompok">Tambah Data</button>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>3. Apakah pernah meminum obat profilaksis/pencegahan malaria?</label>
                    <div class="d-flex">
                        <div class="form-check mr-3">
                            <input type="radio" class="form-check-input" name="obat_profilaksis" value="1"
                                {{ old('obat_profilaksis', $malaria->obat_profilaksis ?? '') == 1 ? 'checked' : '' }}>
                            <label class="form-check-label">Ya</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="obat_profilaksis" value="0"
                                {{ old('obat_profilaksis', $malaria->obat_profilaksis ?? '') == 0 ? 'checked' : '' }}>
                            <label class="form-check-label">Tidak</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>4. Apakah pernah menerima transfusi darah?</label>
                    <div class="d-flex">
                        <div class="form-check mr-3">
                            <input type="radio" class="form-check-input" name="transfusi_darah" value="1"
                                {{ old('transfusi_darah', $malaria->transfusi_darah ?? '') == 1 ? 'checked' : '' }}>
                            <label class="form-check-label">Ya</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="transfusi_darah" value="0"
                                {{ old('transfusi_darah', $malaria->transfusi_darah ?? '') == 0 ? 'checked' : '' }}>
                            <label class="form-check-label">Tidak</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>5. Apakah ada kontak dengan kasus malaria lainnya?</label>
                    <div class="d-flex">
                        <div class="form-check mr-3">
                            <input type="radio" class="form-check-input" name="kontak_kasus" value="1"
                                {{ old('kontak_kasus', $malaria->kontak_kasus ?? '') == 1 ? 'checked' : '' }}>
                            <label class="form-check-label">Ya</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="kontak_kasus" value="0"
                                {{ old('kontak_kasus', $malaria->kontak_kasus ?? '') == 0 ? 'checked' : '' }}>
                            <label class="form-check-label">Tidak</label>
                        </div>
                    </div>
                </div>
            </div>
            <h5><strong>Klasifikasi Kasus</strong></h5>
            <div class="col-md-12">
                <label><strong>1. Indigenous</strong></label>
                <p>Titik koordinat tempat penularan: Belum diketahui</p>
            </div>
            <div class="col-md-12">
                <label><strong>2. Import</strong></label>
                <div class="form-group">
                    <label>Desa</label>
                    <input type="text" class="form-control" name="import_desa" placeholder="Masukkan nama desa"
                        value="{{ old('import_desa', $malaria->import_desa ?? '') }}">
                </div>
                <div class="form-group">
                    <label>Kabupaten/Kota</label>
                    <input type="text" class="form-control" name="import_kabupaten"
                        placeholder="Masukkan nama kabupaten/kota"
                        value="{{ old('import_kabupaten', $malaria->import_kabupaten ?? '') }}">
                </div>
                <div class="form-group">
                    <label>Provinsi</label>
                    <input type="text" class="form-control" name="import_provinsi"
                        value="{{ old('import_provinsi', $malaria->import_provinsi ?? '') }}"
                        placeholder="Masukkan nama provinsi">
                </div>
                <div class="form-group">
                    <label>Negara</label>
                    <input type="text" class="form-control" name="import_negara" placeholder="Masukkan nama negara"
                        value="{{ old('import_negara', $malaria->import_negara ?? '') }}">
                </div>
            </div>
            <div class="col-md-12">
                <p><strong>Keterangan:</strong> untuk kasus relaps harus diklasifikasikan asal penularannya apakah impor
                    atau indigenous.</p>
            </div>
            <h3>B. Survey Kontak</h3>
            <div class="col-md-12">
                <table class="table table-bordered" id="surveyKontakTable">
                    <thead style="background-color: #e0f7da;">
                        <tr>
                            <th>No.</th>
                            <th>Nama</th>
                            <th>Umur</th>
                            <th>Jenis Kelamin</th>
                            <th>Alamat</th>
                            <th>Hub dengan Kasus (Tinggal Serumah/Tetangga/Teman Serombongan)</th>
                            <th>Tgl Pengambilan Darah</th>
                            <th>Tgl Diagnosis</th>
                            <th>Hasil Pemeriksaan (Negatif/Pf/Pv/Pm/Po/Pk/P.mix)</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (isset($malaria) && $malaria->surveyKontak->isNotEmpty())
                            @foreach ($malaria->surveyKontak as $index => $surveyKontak)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>
                                        <input type="text" class="form-control"
                                            name="surveyKontak[{{ $index }}][nama]"
                                            value="{{ old("surveyKontak.{$index}.nama", $surveyKontak->nama) }}"
                                            placeholder="Nama">
                                    </td>
                                    <td>
                                        <input type="number" class="form-control"
                                            name="surveyKontak[{{ $index }}][umur]"
                                            value="{{ old("surveyKontak.{$index}.umur", $surveyKontak->umur) }}"
                                            placeholder="Umur">
                                    </td>
                                    <td>
                                        <select class="form-control"
                                            name="surveyKontak[{{ $index }}][jenis_kelamin]">
                                            <option value="1"
                                                {{ old("surveyKontak.{$index}.jenis_kelamin", $surveyKontak->jenis_kelamin) == 1 ? 'selected' : '' }}>
                                                Laki-laki</option>
                                            <option value="0"
                                                {{ old("surveyKontak.{$index}.jenis_kelamin", $surveyKontak->jenis_kelamin) == 0 ? 'selected' : '' }}>
                                                Perempuan</option>
                                        </select>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control"
                                            name="surveyKontak[{{ $index }}][alamat]"
                                            value="{{ old("surveyKontak.{$index}.alamat", $surveyKontak->alamat) }}"
                                            placeholder="Alamat">
                                    </td>
                                    <td>
                                        <input type="text" class="form-control"
                                            name="surveyKontak[{{ $index }}][hub_kasus]"
                                            value="{{ old("surveyKontak.{$index}.hub_kasus", $surveyKontak->hub_kasus) }}"
                                            placeholder="Hubungan">
                                    </td>
                                    <td>
                                        <input type="date" class="form-control"
                                            name="surveyKontak[{{ $index }}][tgl_pengambilan_darah]"
                                            value="{{ old("surveyKontak.{$index}.tgl_pengambilan_darah", $surveyKontak->tgl_pengambilan_darah) }}">
                                    </td>
                                    <td>
                                        <input type="date" class="form-control"
                                            name="surveyKontak[{{ $index }}][tgl_diagnosis]"
                                            value="{{ old("surveyKontak.{$index}.tgl_diagnosis", $surveyKontak->tgl_diagnosis) }}">
                                    </td>
                                    <td>
                                        <input type="text" class="form-control"
                                            name="surveyKontak[{{ $index }}][hasil_pemeriksaan]"
                                            value="{{ old("surveyKontak.{$index}.hasil_pemeriksaan", $surveyKontak->hasil_pemeriksaan) }}"
                                            placeholder="Hasil">
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-danger remove-row">Hapus</button>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td>1</td>
                                <td>
                                    <input type="text" class="form-control" name="surveyKontak[0][nama]"
                                        placeholder="Nama">
                                </td>
                                <td>
                                    <input type="number" class="form-control" name="surveyKontak[0][umur]"
                                        placeholder="Umur">
                                </td>
                                <td>
                                    <select class="form-control" name="surveyKontak[0][jenis_kelamin]">
                                        <option value="1">Laki-laki</option>
                                        <option value="0">Perempuan</option>
                                    </select>
                                </td>
                                <td>
                                    <input type="text" class="form-control" name="surveyKontak[0][alamat]"
                                        placeholder="Alamat">
                                </td>
                                <td>
                                    <input type="text" class="form-control" name="surveyKontak[0][hub_kasus]"
                                        placeholder="Hubungan">
                                </td>
                                <td>
                                    <input type="date" class="form-control"
                                        name="surveyKontak[0][tgl_pengambilan_darah]">
                                </td>
                                <td>
                                    <input type="date" class="form-control" name="surveyKontak[0][tgl_diagnosis]">
                                </td>
                                <td>
                                    <input type="text" class="form-control" name="surveyKontak[0][hasil_pemeriksaan]"
                                        placeholder="Hasil">
                                </td>
                                <td>
                                    <button type="button" class="btn btn-danger remove-row">Hapus</button>
                                </td>
                            </tr>
                        @endif
                    </tbody>

                </table>
                <button type="button" class="btn btn-primary" id="addRowSurveyKontak">Tambah Data</button>
            </div>
            <br>
            <h3>C. Penyelidikan Faktor Risiko Perilaku</h3>

            <!-- Bagian 1: Aktivitas Malam Hari -->
            <div class="col-md-12">
                <label><strong>1. Apakah kasus memiliki aktivitas rutin di luar rumah pada malam hari?</strong></label>
                <table class="table table-bordered">
                    <thead style="background-color: #e0f7da;">
                        <tr>
                            <th>Jam</th>
                            <th>Kegiatan</th>
                            <th>Tempat Kegiatan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>18.00-20.00</td>
                            <td><input type="text" class="form-control" name="kegiatan1" placeholder="Kegiatan">
                            </td>
                            <td><input type="text" class="form-control" name="tempat1" placeholder="Tempat"></td>
                        </tr>
                        <tr>
                            <td>20.00-22.00</td>
                            <td><input type="text" class="form-control" name="kegiatan2" placeholder="Kegiatan">
                            </td>
                            <td><input type="text" class="form-control" name="tempat2" placeholder="Tempat"></td>
                        </tr>
                        <tr>
                            <td>22.00-24.00</td>
                            <td><input type="text" class="form-control" name="kegiatan3" placeholder="Kegiatan">
                            </td>
                            <td><input type="text" class="form-control" name="tempat3" placeholder="Tempat"></td>
                        </tr>
                        <tr>
                            <td>00.00-02.00</td>
                            <td><input type="text" class="form-control" name="kegiatan4" placeholder="Kegiatan">
                            </td>
                            <td><input type="text" class="form-control" name="tempat4" placeholder="Tempat"></td>
                        </tr>
                        <tr>
                            <td>02.00-04.00</td>
                            <td><input type="text" class="form-control" name="kegiatan5" placeholder="Kegiatan">
                            </td>
                            <td><input type="text" class="form-control" name="tempat5" placeholder="Tempat"></td>
                        </tr>
                        <tr>
                            <td>04.00-06.00</td>
                            <td><input type="text" class="form-control" name="kegiatan6" placeholder="Kegiatan">
                            </td>
                            <td><input type="text" class="form-control" name="tempat6" placeholder="Tempat"></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Bagian 2: Kegiatan Kumpul-kumpul -->
            <div class="col-md-12">
                <label><strong>2. Kegiatan Kumpul-kumpul (Kegiatan Sosial) yang Selalu Dihadiri?</strong></label>
                <div class="form-group">
                    <textarea class="form-control" name="kegiatan_sosial" rows="5"
                        placeholder="Tuliskan kegiatan kumpul-kumpul yang selalu dihadiri..."></textarea>
                </div>
            </div>
            <h3>D. Survey Perindukan Nyamuk</h3>

            <!-- Bagian Informasi Lokasi -->
            <div class="row mb-4">
                <div class="col-md-6">
                    <label>Kabupaten:</label>
                    <input type="text" class="form-control" name="kabupaten" placeholder="Masukkan nama kabupaten">
                </div>
                <div class="col-md-6">
                    <label>Kecamatan:</label>
                    <input type="text" class="form-control" name="kecamatan" placeholder="Masukkan nama kecamatan">
                </div>
                <div class="col-md-6">
                    <label>Desa/Kelurahan:</label>
                    <input type="text" class="form-control" name="desa"
                        placeholder="Masukkan nama desa/kelurahan">
                </div>
                <div class="col-md-6">
                    <label>Dusun:</label>
                    <input type="text" class="form-control" name="dusun" placeholder="Masukkan nama dusun">
                </div>
                <div class="col-md-6">
                    <label>Tanggal:</label>
                    <input type="date" class="form-control" name="tanggal_survey">
                </div>
                <div class="col-md-6">
                    <label>Kolektor:</label>
                    <input type="text" class="form-control" name="kolektor" placeholder="Masukkan nama kolektor">
                </div>
            </div>

            <!-- Bagian Tabel Input -->
            <table class="table table-bordered" id="surveyTable">
                <thead style="background-color: #e0f7da;">
                    <tr>
                        <th>No</th>
                        <th>Habitat</th>
                        <th>pH</th>
                        <th>Sal</th>
                        <th>Suhu</th>
                        <th>Kond</th>
                        <th>Kept</th>
                        <th>Dasar</th>
                        <th>Air</th>
                        <th>Tanaman Sktr</th>
                        <th>Tanaman Teduh</th>
                        <th>Predator</th>
                        <th>Jumlah Larva/Cidukan (An)</th>
                        <th>Jumlah Larva/Cidukan (Cx)</th>
                        <th>Jarak Kamp</th>
                        <th>Klp Habitat</th>
                        <th>GPS</th>
                        <th>Catatan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @if (isset($malaria) && $malaria->surveyNyamuk->isNotEmpty())
                        @foreach ($malaria->surveyNyamuk as $index => $surveyNyamuk)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td><input type="text" class="form-control"
                                        name="surveyNyamuk[{{ $index }}][habitat]"
                                        value="{{ old("surveyNyamuk.{$index}.habitat", $surveyNyamuk->habitat) }}"
                                        placeholder="Habitat"></td>
                                <td><input type="text" class="form-control"
                                        name="surveyNyamuk[{{ $index }}][ph]"
                                        value="{{ old("surveyNyamuk.{$index}.ph", $surveyNyamuk->ph) }}"
                                        placeholder="pH"></td>
                                <td><input type="text" class="form-control"
                                        name="surveyNyamuk[{{ $index }}][sal]"
                                        value="{{ old("surveyNyamuk.{$index}.sal", $surveyNyamuk->sal) }}"
                                        placeholder="Sal"></td>
                                <td><input type="text" class="form-control"
                                        name="surveyNyamuk[{{ $index }}][suhu]"
                                        value="{{ old("surveyNyamuk.{$index}.suhu", $surveyNyamuk->suhu) }}"
                                        placeholder="Suhu">
                                </td>
                                <td><input type="text" class="form-control"
                                        name="surveyNyamuk[{{ $index }}][kond]"
                                        value="{{ old("surveyNyamuk.{$index}.kond", $surveyNyamuk->kond) }}"
                                        placeholder="Kond">
                                </td>
                                <td><input type="text" class="form-control"
                                        name="surveyNyamuk[{{ $index }}][kept]"
                                        value="{{ old("surveyNyamuk.{$index}.kept", $surveyNyamuk->kept) }}"
                                        placeholder="Kept">
                                </td>
                                <td><input type="text" class="form-control"
                                        name="surveyNyamuk[{{ $index }}][dasar]"
                                        value="{{ old("surveyNyamuk.{$index}.dasar", $surveyNyamuk->dasar) }}"
                                        placeholder="Dasar">
                                </td>
                                <td><input type="text" class="form-control"
                                        name="surveyNyamuk[{{ $index }}][air]"
                                        value="{{ old("surveyNyamuk.{$index}.air", $surveyNyamuk->air) }}"
                                        placeholder="Air"></td>
                                <td><input type="text" class="form-control"
                                        name="surveyNyamuk[{{ $index }}][sktr]"
                                        value="{{ old("surveyNyamuk.{$index}.sktr", $surveyNyamuk->sktr) }}"
                                        placeholder="Tanaman Sktr"></td>
                                <td><input type="text" class="form-control"
                                        name="surveyNyamuk[{{ $index }}][teduh]"
                                        value="{{ old("surveyNyamuk.{$index}.teduh", $surveyNyamuk->teduh) }}"
                                        placeholder="Tanaman Teduh"></td>
                                <td><input type="text" class="form-control"
                                        name="surveyNyamuk[{{ $index }}][predator]"
                                        value="{{ old("surveyNyamuk.{$index}.predator", $surveyNyamuk->predator) }}"
                                        placeholder="Predator"></td>
                                <td><input type="text" class="form-control"
                                        name="surveyNyamuk[{{ $index }}][larva_an]"
                                        value="{{ old("surveyNyamuk.{$index}.larva_an", $surveyNyamuk->larva_an) }}"
                                        placeholder="An"></td>
                                <td><input type="text" class="form-control"
                                        name="surveyNyamuk[{{ $index }}][larva_cx]"
                                        value="{{ old("surveyNyamuk.{$index}.larva_cx", $surveyNyamuk->larva_cx) }}"
                                        placeholder="Cx"></td>
                                <td><input type="text" class="form-control"
                                        name="surveyNyamuk[{{ $index }}][jarak_kamp]"
                                        value="{{ old("surveyNyamuk.{$index}.jarak_kamp", $surveyNyamuk->jarak_kamp) }}"
                                        placeholder="Jarak Kamp"></td>
                                <td><input type="text" class="form-control"
                                        name="surveyNyamuk[{{ $index }}][klp_habitat]"
                                        value="{{ old("surveyNyamuk.{$index}.klp_habitat", $surveyNyamuk->klp_habitat) }}"
                                        placeholder="Klp Habitat"></td>
                                <td><input type="text" class="form-control"
                                        name="surveyNyamuk[{{ $index }}][gps]"
                                        value="{{ old("surveyNyamuk.{$index}.gps", $surveyNyamuk->gps) }}"
                                        placeholder="GPS"></td>
                                <td><input type="text" class="form-control"
                                        name="surveyNyamuk[{{ $index }}][catatan]"
                                        value="{{ old("surveyNyamuk.{$index}.catatan", $surveyNyamuk->catatan) }}"
                                        placeholder="Catatan"></td>
                                <td><button type="button" class="btn btn-danger remove-row">Hapus</button></td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td>1</td>
                            <td><input type="text" class="form-control" name="surveyNyamuk[0][habitat]"
                                    placeholder="Habitat"></td>
                            <td><input type="text" class="form-control" name="surveyNyamuk[0][ph]" placeholder="pH">
                            </td>
                            <td><input type="text" class="form-control" name="surveyNyamuk[0][sal]"
                                    placeholder="Sal"></td>
                            <td><input type="text" class="form-control" name="surveyNyamuk[0][suhu]"
                                    placeholder="Suhu">
                            </td>
                            <td><input type="text" class="form-control" name="surveyNyamuk[0][kond]"
                                    placeholder="Kond">
                            </td>
                            <td><input type="text" class="form-control" name="surveyNyamuk[0][kept]"
                                    placeholder="Kept">
                            </td>
                            <td><input type="text" class="form-control" name="surveyNyamuk[0][dasar]"
                                    placeholder="Dasar">
                            </td>
                            <td><input type="text" class="form-control" name="surveyNyamuk[0][air]"
                                    placeholder="Air"></td>
                            <td><input type="text" class="form-control" name="surveyNyamuk[0][sktr]"
                                    placeholder="Tanaman Sktr"></td>
                            <td><input type="text" class="form-control" name="surveyNyamuk[0][teduh]"
                                    placeholder="Tanaman Teduh"></td>
                            <td><input type="text" class="form-control" name="surveyNyamuk[0][predator]"
                                    placeholder="Predator"></td>
                            <td><input type="text" class="form-control" name="surveyNyamuk[0][larva_an]"
                                    placeholder="An">
                            </td>
                            <td><input type="text" class="form-control" name="surveyNyamuk[0][larva_cx]"
                                    placeholder="Cx">
                            </td>
                            <td><input type="text" class="form-control" name="surveyNyamuk[0][jarak_kamp]"
                                    placeholder="Jarak Kamp"></td>
                            <td><input type="text" class="form-control" name="surveyNyamuk[0][klp_habitat]"
                                    placeholder="Klp Habitat"></td>
                            <td><input type="text" class="form-control" name="surveyNyamuk[0][gps]"
                                    placeholder="GPS"></td>
                            <td><input type="text" class="form-control" name="surveyNyamuk[0][catatan]"
                                    placeholder="Catatan"></td>
                            <td><button type="button" class="btn btn-danger remove-row">Hapus</button></td>
                        </tr>
                    @endif
                </tbody>

            </table>
            <button type="button" class="btn btn-primary mb-8" id="addRowSurveyNyamuk">Tambah Data</button>
            <br><br>
            <h3>Keterangan</h3>
            <div class="keterangan">
                <div class="row">
                    <div class="col">
                        <p><strong>Keterangan :</strong></p>
                        <p><em>An:</em> Anopheles sp<br><em>Cx:</em> Culex sp</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <p><strong>Kondisi:</strong></p>
                        <ul>
                            <li>1. Mengalir</li>
                            <li>2. Tergenang</li>
                        </ul>
                    </div>
                    <div class="col">
                        <p><strong>Kecepatan Air:</strong></p>
                        <ul>
                            <li>1. Diam</li>
                            <li>2. Lambat</li>
                            <li>3. Sedang</li>
                            <li>4. Deras</li>
                        </ul>
                    </div>
                    <div class="col">
                        <p><strong>Dasar Perairan:</strong></p>
                        <ul>
                            <li>1. Lumpur</li>
                            <li>2. Pasir</li>
                            <li>3. Kerikil</li>
                            <li>4. Batu Sedang</li>
                            <li>5. Batu Besar</li>
                            <li>6. Lempeng Batu</li>
                            <li>7. Tanah</li>
                            <li>8. Keramik</li>
                        </ul>
                    </div>
                    <div class="col">
                        <p><strong>Tanaman Sekitar:</strong></p>
                        <ul>
                            <li>1. Tidak ada</li>
                            <li>2. Rumputan</li>
                            <li>3. Semak</li>
                            <li>4. Alpokat</li>
                            <li>5. Pisang</li>
                            <li>6. Talok</li>
                            <li>7. Pace</li>
                            <li>8. Mangga</li>
                            <li>9. Jambu Air</li>
                        </ul>
                    </div>
                    <div class="col">
                        <p><strong>Tanaman Air:</strong></p>
                        <ul>
                            <li>1. Tidak ada</li>
                            <li>2. Ganggang</li>
                            <li>3. Kiambang</li>
                            <li>4. Tan Dasar</li>
                            <li>5. Lumut</li>
                            <li>6. Melati Air</li>
                        </ul>
                    </div>
                    <div class="col">
                        <p><strong>Tanaman Peneduh:</strong></p>
                        <ul>
                            <li>1. Tidak ada</li>
                            <li>2. Jarang</li>
                            <li>3. Sedang</li>
                            <li>4. Rapat</li>
                        </ul>
                    </div>
                    <div class="col">
                        <p><strong>Predator:</strong></p>
                        <ul>
                            <li>1. Tidak ada</li>
                            <li>2. Ikan</li>
                            <li>3. Kumbang Air</li>
                            <li>4. Larva Capung</li>
                            <li>5. Kecebong</li>
                            <li>6. Cyclop</li>
                        </ul>
                    </div>
                    <div class="col">
                        <p><strong>Kelompok Habitat:</strong></p>
                        <ul>
                            <li>1. Pertanian</li>
                            <li>2. Pertanian-Perkampungan</li>
                            <li>3. Perkampungan</li>
                            <li>4. Hutan</li>
                            <li>5. Rawa</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-12">
                    <label for="kesimpulan" style="color: rgb(19, 11, 241);">Kesimpulan</label>
                    <textarea class="form-control" id="kesimpulan" name="kesimpulan" placeholder="Kesimpulan">{{ old('kesimpulan', $malaria->kesimpulan ?? '') }}</textarea>
                </div>
            </div>
            <div class="text-right mt-4">

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

        });
        document.addEventListener('DOMContentLoaded', function() {
            const umurInput = document.getElementById('umurInput');
            const tanggalLahirInput = document.getElementById('tanggal_lahir');

            if (tanggalLahirInput && umurInput) {
                // Tambahkan event listener untuk menghitung usia saat tanggal lahir berubah
                tanggalLahirInput.addEventListener('change', () => {
                    const tanggalLahirValue = tanggalLahirInput.value;

                    if (!tanggalLahirValue) {
                        umurInput.value = ''; // Kosongkan usia jika tanggal lahir kosong
                        return;
                    }

                    const tanggalLahir = new Date(tanggalLahirValue);
                    const hariIni = new Date();

                    // Periksa apakah tanggal lahir valid
                    if (isNaN(tanggalLahir.getTime())) {
                        umurInput.value = 'Invalid Date';
                        return;
                    }

                    let usia = hariIni.getFullYear() - tanggalLahir.getFullYear();
                    const bulan = hariIni.getMonth() - tanggalLahir.getMonth();

                    // Koreksi jika bulan atau tanggal saat ini lebih kecil dari bulan/tanggal lahir
                    if (bulan < 0 || (bulan === 0 && hariIni.getDate() < tanggalLahir.getDate())) {
                        usia--;
                    }

                    // Set nilai usia ke input umur
                    umurInput.value = usia >= 0 ? usia : 0;
                });

                // Trigger perubahan saat halaman dimuat (jika tanggal lahir sudah ada)
                if (tanggalLahirInput.value) {
                    tanggalLahirInput.dispatchEvent(new Event('change'));
                }
            }
            // Tampilkan Pertanyaan Tambahan Berdasarkan Radio Button
            const toggleAdditionalQuestions = (radioYes, radioNo, targetDivId) => {
                const targetDiv = document.getElementById(targetDivId);
                if (radioYes.checked) {
                    targetDiv.style.display = 'block';
                }
                if (radioNo.checked) {
                    targetDiv.style.display = 'none';
                }
            };

            // Event Listener untuk Pertanyaan Tambahan
            const malariaYes = document.getElementById('riwayat_malaria_pernah');
            const malariaNo = document.getElementById('riwayat_malaria_tidak');
            malariaYes.addEventListener('change', () => toggleAdditionalQuestions(malariaYes, malariaNo,
                'additional_questions'));
            malariaNo.addEventListener('change', () => toggleAdditionalQuestions(malariaYes, malariaNo,
                'additional_questions'));

            const kasusYes = document.getElementById('riwayat_kasus_malaria_pernah');
            const kasusNo = document.getElementById('riwayat_kasus_malaria_tidak');
            kasusYes.addEventListener('change', () => toggleAdditionalQuestions(kasusYes, kasusNo,
                'additional_questions_kasus'));
            kasusNo.addEventListener('change', () => toggleAdditionalQuestions(kasusYes, kasusNo,
                'additional_questions_kasus'));
            toggleAdditionalQuestions(malariaYes, malariaNo, 'additional_questions');
            toggleAdditionalQuestions(kasusYes, kasusNo, 'additional_questions_kasus');

            const addRowKelompok = () => {
                const table = document.getElementById('kelompokTable').getElementsByTagName('tbody')[0];
                const rowCount = table.rows.length + 1;

                const newRow = document.createElement('tr');
                newRow.innerHTML = `
            <td>${rowCount}</td>
            <td><input type="text" class="form-control" name="kelompok[${rowCount}][nama]" placeholder="Nama"></td>
            <td><input type="text" class="form-control" name="kelompok[${rowCount}][alamat]" placeholder="Alamat"></td>
            <td><button type="button" class="btn btn-danger remove-row">Hapus</button></td>
        `;

                table.appendChild(newRow);
            };

            // Fungsi untuk menambahkan baris ke tabel Survey Kontak
            const addRowSurveyKontak = () => {
                const table = document.getElementById('surveyKontakTable').getElementsByTagName('tbody')[0];
                const rowCount = table.rows.length + 1;

                const newRow = document.createElement('tr');
                newRow.innerHTML = `
            <td>${rowCount}</td>
            <td><input type="text" class="form-control" name="survey[${rowCount}][nama]" placeholder="Nama"></td>
            <td><input type="number" class="form-control" name="survey[${rowCount}][umur]" placeholder="Umur"></td>
            <td>
                <select class="form-control" name="survey[${rowCount}][jenis_kelamin]">
                    <option value="1">Laki-laki</option>
                    <option value="0">Perempuan</option>
                </select>
            </td>
            <td><input type="text" class="form-control" name="survey[${rowCount}][alamat]" placeholder="Alamat"></td>
            <td><input type="text" class="form-control" name="survey[${rowCount}][hub_kasus]" placeholder="Hubungan"></td>
            <td><input type="date" class="form-control" name="survey[${rowCount}][tgl_pengambilan_darah]"></td>
            <td><input type="date" class="form-control" name="survey[${rowCount}][tgl_diagnosis]"></td>
            <td><input type="text" class="form-control" name="survey[${rowCount}][hasil_pemeriksaan]" placeholder="Hasil"></td>
            <td><button type="button" class="btn btn-danger remove-row">Hapus</button></td>
        `;

                table.appendChild(newRow);
            };

            // Fungsi untuk menambahkan baris ke tabel Survey Perindukan Nyamuk
            const addRowSurveyNyamuk = () => {
                const table = document.getElementById('surveyTable').getElementsByTagName('tbody')[0];
                const rowCount = table.rows.length + 1;

                const newRow = document.createElement('tr');
                newRow.innerHTML = `
        <td>${rowCount}</td>
        <td><input type="text" class="form-control" name="survey[${rowCount}][habitat]" placeholder="Habitat"></td>
        <td><input type="text" class="form-control" name="survey[${rowCount}][ph]" placeholder="pH"></td>
        <td><input type="text" class="form-control" name="survey[${rowCount}][sal]" placeholder="Sal"></td>
        <td><input type="text" class="form-control" name="survey[${rowCount}][suhu]" placeholder="Suhu"></td>
        <td><input type="text" class="form-control" name="survey[${rowCount}][kond]" placeholder="Kond"></td>
        <td><input type="text" class="form-control" name="survey[${rowCount}][kept]" placeholder="Kept"></td>
        <td><input type="text" class="form-control" name="survey[${rowCount}][dasar]" placeholder="Dasar"></td>
        <td><input type="text" class="form-control" name="survey[${rowCount}][air]" placeholder="Air"></td>
        <td><input type="text" class="form-control" name="survey[${rowCount}][sktr]" placeholder="Tanaman Sktr"></td>
        <td><input type="text" class="form-control" name="survey[${rowCount}][teduh]" placeholder="Tanaman Teduh"></td>
        <td><input type="text" class="form-control" name="survey[${rowCount}][predator]" placeholder="Predator"></td>
        <td><input type="text" class="form-control" name="survey[${rowCount}][larva_an]" placeholder="An"></td>
        <td><input type="text" class="form-control" name="survey[${rowCount}][larva_cx]" placeholder="Cx"></td>
        <td><input type="text" class="form-control" name="survey[${rowCount}][jarak_kamp]" placeholder="Jarak Kamp"></td>
        <td><input type="text" class="form-control" name="survey[${rowCount}][klp_habitat]" placeholder="Klp Habitat"></td>
        <td><input type="text" class="form-control" name="survey[${rowCount}][gps]" placeholder="GPS"></td>
        <td><input type="text" class="form-control" name="survey[${rowCount}][catatan]" placeholder="Catatan"></td>
        <td><button type="button" class="btn btn-danger remove-row">Hapus</button></td>
    `;


                table.appendChild(newRow);
            };

            // Tambahkan event listener ke tombol Tambah Data
            document.getElementById('addRowKelompok').addEventListener('click', addRowKelompok);
            document.getElementById('addRowSurveyNyamuk').addEventListener('click', addRowSurveyNyamuk);
            document.getElementById('addRowSurveyKontak').addEventListener('click', addRowSurveyKontak);

            // Delegasi event untuk tombol Hapus
            document.addEventListener('click', function(e) {
                if (e.target && e.target.classList.contains('remove-row')) {
                    e.target.closest('tr').remove();
                }
            });

        });
    </script>
@endsection
