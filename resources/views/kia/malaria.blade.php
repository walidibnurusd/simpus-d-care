@extends('layouts.skrining.master-fluid')
@section('title', 'Skrining Malaria')
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

    <form action="{{ isset($anemia) ? route('anemia.update', $anemia->id) : route('anemia.store') }}" method="POST">
        @csrf
        @if (isset($anemia))
            @method('PUT')
        @endif
        @if ($routeName === 'anemia.view')
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
                        <input type="text" class="form-control" name="hamil" readonly id="hamil" value="">
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
                            value="{{ old('alamat', '' ?? '') }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Gejala yang dirasakan (demam, menggigil, nyeri kepala, mual, muntah, diare,
                            pegal-pegal, nyeri otot) : </label>
                        <input type="text" class="form-control" name="gejala"
                            placeholder="Masukkan gejala yang dirasakan" id="gejala"
                            value="{{ old('gejala', '' ?? '') }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Jenis Wilayah ( Hutan, Tambang, Kebun) :</label>
                        <input type="text" class="form-control" name="jenis_wilayah"
                            placeholder="Masukkan jenis wilayah" id="jenis_wilayah"
                            value="{{ old('jenis_wilayah', '' ?? '') }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Tanggal muncul gejala</label>
                        <input type="date" class="form-control" name="tanggal_gejala"
                            value="{{ old('tanggal_gejala', '' ?? '') }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Hasil pemeriksaan darah ( miskroskop / RDT ) :</label>
                        <div class="d-flex">
                            <div class="form-check mr-3">
                                <input type="radio" class="form-check-input" name="hasil_darah" value="positif"
                                    {{ old('hasil_darah', '' ?? 'positif') == 'positif' ? 'checked' : '' }}>
                                <label class="form-check-label">Positif</label>
                            </div>
                            <div class="form-check">
                                <input type="radio" class="form-check-input" name="hasil_darah" value="negatif"
                                    {{ old('hasil_darah', '' ?? 'negatif') == 'negatif' ? 'checked' : '' }}>
                                <label class="form-check-label">Negatif</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Jenis Parasit</label>
                        <input type="text" class="form-control" name="jenis_parasit"
                            value="{{ old('jenis_parasit', '' ?? '') }}">
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Riwayat pernah menderita malaria sebelumnya?</label>
                        <div class="d-flex">
                            <div class="form-check mr-3">
                                <input type="radio" class="form-check-input" name="riwayat_malaria"
                                    id="riwayat_malaria_pernah" value="pernah">
                                <label class="form-check-label" for="riwayat_malaria_pernah">Pernah</label>
                            </div>
                            <div class="form-check">
                                <input type="radio" class="form-check-input" name="riwayat_malaria"
                                    id="riwayat_malaria_tidak" value="tidak">
                                <label class="form-check-label" for="riwayat_malaria_tidak">Tidak</label>
                            </div>
                        </div>
                    </div>

                    <div id="additional_questions" style="display: none;">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="waktu">Waktu:</label>
                                <input type="text" id="waktu" name="waktu" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="jenis_parasit">Jenis Parasit:</label>
                                <input type="text" id="jenis_parasit" name="jenis_parasit" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="jenis_obat">Jenis Obat yang Didapatkan:</label>
                                <input type="text" id="jenis_obat" name="jenis_obat" class="form-control">
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
                            value="{{ old('tanggal_diagnosis', '' ?? '') }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Diagnosis</label>
                        <input type="text" class="form-control" name="diagnosis">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Fasyankes Tempat Diagnosis</label>
                        <input type="text" class="form-control" name="fasyankes">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Perawatan</label>
                        <input type="text" class="form-control" name="perawatan" placeholder="Masukkan perawatan"
                            id="perawatan" value="{{ old('perawatan', '' ?? '') }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>No Rekam Medis</label>
                        <input type="text" class="form-control" name="no_rm" id="no_rm"
                            value="{{ old('no_rm', '' ?? '') }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Metode Diagnosis</label>
                        <input type="text" class="form-control" name="metode_diagnosis" id="metode_diagnosis"
                            value="{{ old('metode_diagnosis', '' ?? '') }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Jenis Parasit</label>
                        <input type="text" class="form-control" name="metode_diagnosis" id="metode_diagnosis"
                            value="{{ old('metode_diagnosis', '' ?? '') }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Tanggal muncul gejala</label>
                        <input type="date" class="form-control" name="riwayat_tanggal_gejala"
                            value="{{ old('riwayat_tanggal_gejala', '' ?? '') }}">
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group">
                        <label>Riwayat pernah menderita malaria sebelumnya?</label>
                        <div class="d-flex">
                            <div class="form-check mr-3">
                                <input type="radio" class="form-check-input" name="riwayat_kasus_malaria"
                                    id="riwayat_kasus_malaria_pernah" value="pernah">
                                <label class="form-check-label" for="riwayat_malaria_pernah">Pernah</label>
                            </div>
                            <div class="form-check">
                                <input type="radio" class="form-check-input" name="riwayat_kasus_malaria"
                                    id="riwayat_kasus_malaria_tidak" value="tidak">
                                <label class="form-check-label" for="riwayat_malaria_tidak">Tidak</label>
                            </div>
                        </div>
                    </div>

                    <div id="additional_questions_kasus" style="display: none;">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="waktu">Waktu:</label>
                                <input type="text" id="kasus_waktu" name="kasus_waktu" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="jenis_parasit">Jenis Parasit:</label>
                                <input type="text" id="kasus_jenis_parasit" name="kasus_jenis_parasit"
                                    class="form-control">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="jenis_obat">Jenis Obat yang Didapatkan:</label>
                                <input type="text" id="kasus_jenis_obat" name="kasus_jenis_obat"
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
                        value="{{ old('tanggal_pengobatan', '' ?? '') }}">
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
                            <td><input type="number" class="form-control" name="jumlah_obat[dhp]" min="0"
                                    placeholder="Jumlah"></td>
                        </tr>
                        <tr>
                            <td>Primaquin</td>
                            <td><input type="number" class="form-control" name="jumlah_obat[primaquin]" min="0"
                                    placeholder="Jumlah"></td>
                        </tr>
                        <tr>
                            <td>Artesunat</td>
                            <td><input type="number" class="form-control" name="jumlah_obat[artesunat]" min="0"
                                    placeholder="Jumlah"></td>
                        </tr>
                        <tr>
                            <td>Artemeter</td>
                            <td><input type="number" class="form-control" name="jumlah_obat[artemeter]" min="0"
                                    placeholder="Jumlah"></td>
                        </tr>
                        <tr>
                            <td>Kina</td>
                            <td><input type="number" class="form-control" name="jumlah_obat[kina]" min="0"
                                    placeholder="Jumlah"></td>
                        </tr>
                        <tr>
                            <td>Klindamisin</td>
                            <td><input type="number" class="form-control" name="jumlah_obat[klindamisin]"
                                    min="0" placeholder="Jumlah"></td>
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
                                {{ old('obat_habis', '' ?? '1') == '1' ? 'checked' : '' }}>
                            <label class="form-check-label">Ya</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="obat_habis" value="0"
                                {{ old('obat_habis', '' ?? '0') == '0' ? 'checked' : '' }}>
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
                            <td><input type="text" class="form-control" name="riwayat[desa][1]"
                                    placeholder="Isi data"></td>
                            <td><input type="text" class="form-control" name="riwayat[desa][2]"
                                    placeholder="Isi data"></td>
                            <td><input type="text" class="form-control" name="riwayat[desa][3]"
                                    placeholder="Isi data"></td>
                        </tr>
                        <tr>
                            <td>Kecamatan</td>
                            <td><input type="text" class="form-control" name="riwayat[kecamatan][1]"
                                    placeholder="Isi data"></td>
                            <td><input type="text" class="form-control" name="riwayat[kecamatan][2]"
                                    placeholder="Isi data"></td>
                            <td><input type="text" class="form-control" name="riwayat[kecamatan][3]"
                                    placeholder="Isi data"></td>
                        </tr>
                        <tr>
                            <td>Kabupaten/Kota</td>
                            <td><input type="text" class="form-control" name="riwayat[kabupaten][1]"
                                    placeholder="Isi data"></td>
                            <td><input type="text" class="form-control" name="riwayat[kabupaten][2]"
                                    placeholder="Isi data"></td>
                            <td><input type="text" class="form-control" name="riwayat[kabupaten][3]"
                                    placeholder="Isi data"></td>
                        </tr>
                        <tr>
                            <td>Provinsi</td>
                            <td><input type="text" class="form-control" name="riwayat[provinsi][1]"
                                    placeholder="Isi data"></td>
                            <td><input type="text" class="form-control" name="riwayat[provinsi][2]"
                                    placeholder="Isi data"></td>
                            <td><input type="text" class="form-control" name="riwayat[provinsi][3]"
                                    placeholder="Isi data"></td>
                        </tr>
                        <tr>
                            <td>Negara</td>
                            <td><input type="text" class="form-control" name="riwayat[negara][1]"
                                    placeholder="Isi data"></td>
                            <td><input type="text" class="form-control" name="riwayat[negara][2]"
                                    placeholder="Isi data"></td>
                            <td><input type="text" class="form-control" name="riwayat[negara][3]"
                                    placeholder="Isi data"></td>
                        </tr>
                        <tr>
                            <td>Jenis Wilayah<br>(Hutan/Tambang/Kebun)</td>
                            <td><input type="text" class="form-control" name="riwayat[jenis_wilayah][1]"
                                    placeholder="Isi data"></td>
                            <td><input type="text" class="form-control" name="riwayat[jenis_wilayah][2]"
                                    placeholder="Isi data"></td>
                            <td><input type="text" class="form-control" name="riwayat[jenis_wilayah][3]"
                                    placeholder="Isi data"></td>
                        </tr>
                        <tr>
                            <td>Kepentingan</td>
                            <td><input type="text" class="form-control" name="riwayat[kepentingan][1]"
                                    placeholder="Isi data"></td>
                            <td><input type="text" class="form-control" name="riwayat[kepentingan][2]"
                                    placeholder="Isi data"></td>
                            <td><input type="text" class="form-control" name="riwayat[kepentingan][3]"
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
                        <tr>
                            <td>1</td>
                            <td><input type="text" class="form-control" name="kelompok[1][nama]" placeholder="Nama">
                            </td>
                            <td><input type="text" class="form-control" name="kelompok[1][alamat]"
                                    placeholder="Alamat"></td>
                            <td><button type="button" class="btn btn-danger remove-row">Hapus</button></td>
                        </tr>
                    </tbody>
                </table>
                <button type="button" class="btn btn-primary mb-4" id="addRow">Tambah Data</button>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>3. Apakah pernah meminum obat profilaksis/pencegahan malaria?</label>
                    <div class="d-flex">
                        <div class="form-check mr-3">
                            <input type="radio" class="form-check-input" name="obat_profilaksis" value="1"
                                {{ old('obat_profilaksis', '' ?? '1') == '1' ? 'checked' : '' }}>
                            <label class="form-check-label">Ya</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="obat_profilaksis" value="0"
                                {{ old('obat_profilaksis', '' ?? '0') == '0' ? 'checked' : '' }}>
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
                                {{ old('transfusi_darah', '' ?? '1') == '1' ? 'checked' : '' }}>
                            <label class="form-check-label">Ya</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="transfusi_darah" value="0"
                                {{ old('transfusi_darah', '' ?? '0') == '0' ? 'checked' : '' }}>
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
                                {{ old('kontak_kasus', '' ?? '1') == '1' ? 'checked' : '' }}>
                            <label class="form-check-label">Ya</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="kontak_kasus" value="0"
                                {{ old('kontak_kasus', '' ?? '0') == '0' ? 'checked' : '' }}>
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
                    <input type="text" class="form-control" name="import[desa]" placeholder="Masukkan nama desa">
                </div>
                <div class="form-group">
                    <label>Kabupaten/Kota</label>
                    <input type="text" class="form-control" name="import[kabupaten]"
                        placeholder="Masukkan nama kabupaten/kota">
                </div>
                <div class="form-group">
                    <label>Provinsi</label>
                    <input type="text" class="form-control" name="import[provinsi]"
                        placeholder="Masukkan nama provinsi">
                </div>
                <div class="form-group">
                    <label>Negara</label>
                    <input type="text" class="form-control" name="import[negara]" placeholder="Masukkan nama negara">
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
                        <tr>
                            <td>1</td>
                            <td><input type="text" class="form-control" name="survey[1][nama]" placeholder="Nama">
                            </td>
                            <td><input type="number" class="form-control" name="survey[1][umur]" placeholder="Umur">
                            </td>
                            <td>
                                <select class="form-control" name="survey[1][jenis_kelamin]">
                                    <option value="Laki-laki">Laki-laki</option>
                                    <option value="Perempuan">Perempuan</option>
                                </select>
                            </td>
                            <td><input type="text" class="form-control" name="survey[1][alamat]"
                                    placeholder="Alamat"></td>
                            <td><input type="text" class="form-control" name="survey[1][hub_kasus]"
                                    placeholder="Hubungan"></td>
                            <td><input type="date" class="form-control" name="survey[1][tgl_pengambilan_darah]"></td>
                            <td><input type="date" class="form-control" name="survey[1][tgl_diagnosis]"></td>
                            <td><input type="text" class="form-control" name="survey[1][hasil_pemeriksaan]"
                                    placeholder="Hasil"></td>
                            <td><button type="button" class="btn btn-danger remove-row">Hapus</button></td>
                        </tr>
                    </tbody>
                </table>
                <button type="button" class="btn btn-primary" id="addRowSurvey">Tambah Data</button>
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
                            <td><input type="text" class="form-control" name="aktivitas[18-20][kegiatan]"
                                    placeholder="Kegiatan"></td>
                            <td><input type="text" class="form-control" name="aktivitas[18-20][tempat]"
                                    placeholder="Tempat"></td>
                        </tr>
                        <tr>
                            <td>20.00-22.00</td>
                            <td><input type="text" class="form-control" name="aktivitas[20-22][kegiatan]"
                                    placeholder="Kegiatan"></td>
                            <td><input type="text" class="form-control" name="aktivitas[20-22][tempat]"
                                    placeholder="Tempat"></td>
                        </tr>
                        <tr>
                            <td>22.00-24.00</td>
                            <td><input type="text" class="form-control" name="aktivitas[22-24][kegiatan]"
                                    placeholder="Kegiatan"></td>
                            <td><input type="text" class="form-control" name="aktivitas[22-24][tempat]"
                                    placeholder="Tempat"></td>
                        </tr>
                        <tr>
                            <td>00.00-02.00</td>
                            <td><input type="text" class="form-control" name="aktivitas[00-02][kegiatan]"
                                    placeholder="Kegiatan"></td>
                            <td><input type="text" class="form-control" name="aktivitas[00-02][tempat]"
                                    placeholder="Tempat"></td>
                        </tr>
                        <tr>
                            <td>02.00-04.00</td>
                            <td><input type="text" class="form-control" name="aktivitas[02-04][kegiatan]"
                                    placeholder="Kegiatan"></td>
                            <td><input type="text" class="form-control" name="aktivitas[02-04][tempat]"
                                    placeholder="Tempat"></td>
                        </tr>
                        <tr>
                            <td>04.00-06.00</td>
                            <td><input type="text" class="form-control" name="aktivitas[04-06][kegiatan]"
                                    placeholder="Kegiatan"></td>
                            <td><input type="text" class="form-control" name="aktivitas[04-06][tempat]"
                                    placeholder="Tempat"></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Bagian 2: Kegiatan Kumpul-kumpul -->
            <div class="col-md-12">
                <label><strong>2. Kegiatan Kumpul-kumpul (Kegiatan Sosial) yang Selalu Dihadiri?</strong></label>
                <div class="form-group">
                    <textarea class="form-control" name="kegiatan_social" rows="5"
                        placeholder="Tuliskan kegiatan kumpul-kumpul yang selalu dihadiri..."></textarea>
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
            // Fungsi untuk menangani penambahan baris baru
            const handleAddRow = (tableId, prefixName) => {
                const table = document.getElementById(tableId).getElementsByTagName('tbody')[0];
                const rowCount = table.rows.length + 1;

                const newRow = document.createElement('tr');
                newRow.innerHTML = `
        <td>${rowCount}</td>
        <td><input type="text" class="form-control" name="${prefixName}[${rowCount}][nama]" placeholder="Nama"></td>
        <td><input type="number" class="form-control" name="${prefixName}[${rowCount}][umur]" placeholder="Umur"></td>
        <td>
            <select class="form-control" name="${prefixName}[${rowCount}][jenis_kelamin]">
                <option value="Laki-laki">Laki-laki</option>
                <option value="Perempuan">Perempuan</option>
            </select>
        </td>
        <td><input type="text" class="form-control" name="${prefixName}[${rowCount}][alamat]" placeholder="Alamat"></td>
        <td><input type="text" class="form-control" name="${prefixName}[${rowCount}][hub_kasus]" placeholder="Hubungan"></td>
        <td><input type="date" class="form-control" name="${prefixName}[${rowCount}][tgl_pengambilan_darah]"></td>
        <td><input type="date" class="form-control" name="${prefixName}[${rowCount}][tgl_diagnosis]"></td>
        <td><input type="text" class="form-control" name="${prefixName}[${rowCount}][hasil_pemeriksaan]" placeholder="Hasil"></td>
        <td><button type="button" class="btn btn-danger remove-row">Hapus</button></td>
    `;


                table.appendChild(newRow);
            };

            // Delegasi Event untuk Tombol Hapus
            document.addEventListener('click', function(e) {
                if (e.target && e.target.classList.contains('remove-row')) {
                    e.target.closest('tr').remove();
                }
            });

            // Penanganan Tambah Baris untuk Tabel Kelompok
            document.getElementById('addRow').addEventListener('click', function() {
                handleAddRow('kelompokTable', 'kelompok');
            });

            // Penanganan Tambah Baris untuk Tabel Survey Kontak
            document.getElementById('addRowSurvey').addEventListener('click', function() {
                handleAddRow('surveyKontakTable', 'survey');
            });

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

        });
    </script>
@endsection
