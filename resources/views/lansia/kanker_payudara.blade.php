@extends('layouts.skrining.master')
@section('title', 'Skrining Deteksi Dini Kanker Leher Rahim dan Kanker Payudara')
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

    <form
        action="{{ isset($kankerPayudara) ? route('kankerPayudara.lansia.update', $kankerPayudara->id) : route('kankerPayudara.lansia.store') }}"
        method="POST">
        @csrf
        @if (isset($kankerPayudara))
            @method('PUT')
        @endif
        <div class="form-section">
            <h3>Informasi Pasien</h3>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>1. Nomor Klien</label>
                        <input type="number" class="form-control" name="nomor_klien" placeholder="Masukkan nomor klien"
                            value="{{ old('nomor_klien', $kankerPayudara->nomor_klien ?? '') }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>2. Pasien</label>
                        <select class="form-control form-select select2" id="pasien" name="pasien">
                            <option value="" disabled {{ old('pasien') == '' ? 'selected' : '' }}>Pilih</option>
                            @foreach ($pasien as $item)
                                <option value="{{ $item->id }}" data-no_hp="{{ $item->phone }}"
                                    data-nik="{{ $item->nik }}" data-rt="{{ $item->rw }}"
                                    data-dob="{{ $item->dob }}" data-pekerjaan="{{ $item->occupations->name }}"
                                    data-alamat="{{ $item->address }}" data-pendidikan="{{ $item->educations->name }}"
                                    {{ old('pasien', $kankerPayudara->pasien ?? '') == $item->id ? 'selected' : '' }}>
                                    {{ $item->name }} - {{ $item->nik }}
                                </option>
                            @endforeach
                        </select>
                        @error('pasien')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>3. Umur</label>
                        <div class="row align-items-center">
                            <div class="col-md-10">
                                <input type="number" class="form-control" name="umur" placeholder="Masukkan umur"
                                    id="umurInput" readonly>
                            </div>
                            <div class="col-auto">
                                <p class="mb-0">Tahun</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>4. Suku bangsa</label>
                        <div class="row">
                            <div class="col-md-12">
                                <input type="text" name="suku_bangsa" class="form-control"
                                    placeholder="Masukkan suku bangsa"
                                    value="{{ old('suku_bangsa', $kankerPayudara->suku_bangsa ?? '') }}">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>5. Agama</label>
                        <div class="row">
                            <div class="col-md-12">
                                <input type="text" name="agama" class="form-control" placeholder="Masukkan agama"
                                    value="{{ old('agama', $kankerPayudara->agama ?? '') }}">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>6. Berat badan</label>
                        <div class="row align-items-center">
                            <div class="col-md-10">
                                <input type="number" class="form-control" name="berat_badan"
                                    placeholder="Masukkan berat badan"
                                    value="{{ old('berat_badan', $kankerPayudara->berat_badan ?? '') }}">
                            </div>
                            <div class="col-auto">
                                <p class="mb-0">Kg</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>7. Tinggi badan</label>
                        <div class="row align-items-center">
                            <div class="col-md-10">
                                <input type="number" class="form-control" name="tinggi_badan"
                                    placeholder="Masukkan tinggi badan"
                                    value="{{ old('tinggi_badan', $kankerPayudara->tinggi_badan ?? '') }}">
                            </div>
                            <div class="col-auto">
                                <p class="mb-0">Cm</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>8. Alamat</label>
                        <div class="row">
                            <div class="col-md-12">
                                <input type="text" name="alamat" class="form-control" placeholder="Masukkan alamat"
                                    id="alamat" readonly value="{{ old('alamat', $kankerPayudara->alamat ?? '') }}">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>9. Perkawinan pasangan</label>
                        <div class="row align-items-center">
                            <div class="col-md-10">
                                <input type="number" class="form-control" name="perkawinan_pasangan"
                                    placeholder="Masukkan perkawinan pasangan"
                                    value="{{ old('perkawinan_pasangan', $kankerPayudara->perkawinan_pasangan ?? '') }}">
                            </div>
                            <div class="col-auto">
                                <p class="mb-0">kali</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>10. Klien</label>
                        <div class="row align-items-center">
                            <div class="col-md-10">
                                <input type="number" class="form-control" name="klien" placeholder="Masukkan klien"
                                    value="{{ old('klien', $kankerPayudara->klien ?? '') }}">
                            </div>
                            <div class="col-auto">
                                <p class="mb-0">kali</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>11. Pekerjaan klien</label>
                        <div class="row">
                            <div class="col-md-12">
                                <input type="text" name="pekerjaan_klien" class="form-control" id="pekerjaan"
                                    readonly placeholder="Masukkan pekerjaan klien"
                                    value="{{ old('pekerjaan_klien', $kankerPayudara->pekerjaan_klien ?? '') }}">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>12. Pekerjaan suami</label>
                        <div class="row">
                            <div class="col-md-12">
                                <input type="text" name="pekerjaan_suami" class="form-control"
                                    placeholder="Masukkan pekerjaan suami"
                                    value="{{ old('pekerjaan_suami', $kankerPayudara->pekerjaan_suami ?? '') }}">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>13. Pendidikan terakhir</label>
                        <div class="row">
                            <div class="col-md-12">
                                <input type="text" name="pendidikan_terakhir" class="form-control" id="pendidikan"
                                    readonly placeholder="Masukkan pendidikan terakhir"
                                    value="{{ old('pendidikan_terakhir', $kankerPayudara->pendidikan_terakhir ?? '') }}">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>14. Jumlah anak kandung</label>
                        <div class="row">
                            <div class="col-md-12">
                                <input type="number" name="jmlh_anak_kandung" class="form-control"
                                    placeholder="Masukkan jumlah anak kandung"
                                    value="{{ old('jmlh_anak_kandung', $kankerPayudara->jmlh_anak_kandung ?? '') }}">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>15. RT/RW</label>
                        <div class="row">
                            <div class="col-md-12">
                                <input type="text" name="rt_rw" class="form-control" placeholder="Masukkan RT/RW"
                                    id="rt" readonly value="{{ old('rt_rw', $kankerPayudara->rt_rw ?? '') }}">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label>16. Kelurahan/Desa</label>
                        <div class="row">
                            <div class="col-md-12">
                                <input type="text" name="kelurahan_desa" class="form-control"
                                    placeholder="Masukkan Kelurahan/Desa"
                                    value="{{ old('kelurahan_desa', $kankerPayudara->kelurahan_desa ?? '') }}">
                            </div>
                        </div>
                    </div>
                </div>


            </div>

        </div>
        <div class="form-section">
            <h3>Faktor Risiko Tambahan</h3>
            <div class="row">
                <!-- 1. Menstruasi <12 tahun -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label>1. Menstruasi &lt;12 tahun</label>
                        <div class="d-flex align-items-center">
                            <div class="form-check mr-3">
                                <input type="radio" name="menstruasi" value="1" class="form-check-input"
                                    {{ old('menstruasi', $kankerPayudara->menstruasi ?? '') == 1 ? 'checked' : '' }}>
                                <label class="form-check-label">Ya</label>
                            </div>
                            <div class="form-check">
                                <input type="radio" name="menstruasi" value="0" class="form-check-input"
                                    {{ old('menstruasi', $kankerPayudara->menstruasi ?? '') == 0 ? 'checked' : '' }}>
                                <label class="form-check-label">Tidak</label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 2. Usia pertama berhubungan seksual <17 tahun -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label>2. Usia pertama berhubungan seksual &lt;17 tahun</label>
                        <div class="d-flex align-items-center">
                            <div class="form-check mr-3">
                                <input type="radio" name="usia_seks" value="1" class="form-check-input"
                                    {{ old('usia_seks', $kankerPayudara->usia_seks ?? '') == 1 ? 'checked' : '' }}>
                                <label class="form-check-label">Ya</label>
                            </div>
                            <div class="form-check">
                                <input type="radio" name="usia_seks" value="0" class="form-check-input"
                                    {{ old('usia_seks', $kankerPayudara->usia_seks ?? '') == 0 ? 'checked' : '' }}>
                                <label class="form-check-label">Tidak</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- 3. Sering keputihan -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label>3. Sering keputihan</label>
                        <div class="d-flex align-items-center">
                            <div class="form-check mr-3">
                                <input type="radio" name="keputihan" value="1" class="form-check-input"
                                    {{ old('keputihan', $kankerPayudara->keputihan ?? '') == 1 ? 'checked' : '' }}>
                                <label class="form-check-label">Ya</label>
                            </div>
                            <div class="form-check">
                                <input type="radio" name="keputihan" value="0" class="form-check-input"
                                    {{ old('keputihan', $kankerPayudara->keputihan ?? '') == 0 ? 'checked' : '' }}>
                                <label class="form-check-label">Tidak</label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 4. Merokok -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label>4. Merokok</label>
                        <div class="d-flex align-items-center">
                            <div class="form-check mr-3">
                                <input type="radio" name="merokok" value="1" class="form-check-input"
                                    {{ old('merokok', $kankerPayudara->merokok ?? '') == 1 ? 'checked' : '' }}>
                                <label class="form-check-label">Ya</label>
                            </div>
                            <div class="form-check">
                                <input type="radio" name="merokok" value="0" class="form-check-input"
                                    {{ old('merokok', $kankerPayudara->merokok ?? '') == 0 ? 'checked' : '' }}>
                                <label class="form-check-label">Tidak</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- 5. Terpapar asap rokok >1 jam sehari -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label>5. Terpapar asap rokok >1 jam sehari</label>
                        <div class="d-flex align-items-center">
                            <div class="form-check mr-3">
                                <input type="radio" name="terpapar_asap_rokok" value="1" class="form-check-input"
                                    {{ old('terpapar_asap_rokok', $kankerPayudara->terpapar_asap_rokok ?? '') == 1 ? 'checked' : '' }}>
                                <label class="form-check-label">Ya</label>
                            </div>
                            <div class="form-check">
                                <input type="radio" name="terpapar_asap_rokok" value="0" class="form-check-input"
                                    {{ old('terpapar_asap_rokok', $kankerPayudara->terpapar_asap_rokok ?? '') == 0 ? 'checked' : '' }}>
                                <label class="form-check-label">Tidak</label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 6. Sering konsumsi buah & sayur (5 porsi/hari) -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label>6. Sering konsumsi buah & sayur (5 porsi/hari)</label>
                        <div class="d-flex align-items-center">
                            <div class="form-check mr-3">
                                <input type="radio" name="konsumsi_buah_sayur" value="1" class="form-check-input"
                                    {{ old('konsumsi_buah_sayur', $kankerPayudara->konsumsi_buah_sayur ?? '') == 1 ? 'checked' : '' }}>
                                <label class="form-check-label">Ya</label>
                            </div>
                            <div class="form-check">
                                <input type="radio" name="konsumsi_buah_sayur" value="0" class="form-check-input"
                                    {{ old('konsumsi_buah_sayur', $kankerPayudara->konsumsi_buah_sayur ?? '') == 0 ? 'checked' : '' }}>
                                <label class="form-check-label">Tidak</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- 7. Sering konsumsi makanan berlemak -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label>7. Sering konsumsi makanan berlemak</label>
                        <div class="d-flex align-items-center">
                            <div class="form-check mr-3">
                                <input type="radio" name="konsumsi_makanan_lemak" value="1"
                                    class="form-check-input"
                                    {{ old('konsumsi_makanan_lemak', $kankerPayudara->konsumsi_makanan_lemak ?? '') == 1 ? 'checked' : '' }}>
                                <label class="form-check-label">Ya</label>
                            </div>
                            <div class="form-check">
                                <input type="radio" name="konsumsi_makanan_lemak" value="0"
                                    class="form-check-input"
                                    {{ old('konsumsi_makanan_lemak', $kankerPayudara->konsumsi_makanan_lemak ?? '') == 0 ? 'checked' : '' }}>
                                <label class="form-check-label">Tidak</label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 8. Sering konsumsi makanan berpengawet -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label>8. Sering konsumsi makanan berpengawet</label>
                        <div class="d-flex align-items-center">
                            <div class="form-check mr-3">
                                <input type="radio" name="konsumsi_makanan_pengawet" value="1"
                                    class="form-check-input"
                                    {{ old('konsumsi_makanan_pengawet', $kankerPayudara->konsumsi_makanan_pengawet ?? '') == 1 ? 'checked' : '' }}>
                                <label class="form-check-label">Ya</label>
                            </div>
                            <div class="form-check">
                                <input type="radio" name="konsumsi_makanan_pengawet" value="0"
                                    class="form-check-input"
                                    {{ old('konsumsi_makanan_pengawet', $kankerPayudara->konsumsi_makanan_pengawet ?? '') == 0 ? 'checked' : '' }}>
                                <label class="form-check-label">Tidak</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- 9. Kurang aktivitas fisik (30 menit/hari) -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label>9. Kurang aktivitas fisik (30 menit/hari)</label>
                        <div class="d-flex align-items-center">
                            <div class="form-check mr-3">
                                <input type="radio" name="kurang_aktivitas" value="1" class="form-check-input"
                                    {{ old('kurang_aktivitas', $kankerPayudara->kurang_aktivitas ?? '') == 1 ? 'checked' : '' }}>
                                <label class="form-check-label">Ya</label>
                            </div>
                            <div class="form-check">
                                <input type="radio" name="kurang_aktivitas" value="0" class="form-check-input"
                                    {{ old('kurang_aktivitas', $kankerPayudara->kurang_aktivitas ?? '') == 0 ? 'checked' : '' }}>
                                <label class="form-check-label">Tidak</label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 10. Pernah Pap smear -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label>10. Pernah Pap smear</label>
                        <div class="d-flex align-items-center">
                            <div class="form-check mr-3">
                                <input type="radio" name="pap_smear" value="1" class="form-check-input"
                                    {{ old('pap_smear', $kankerPayudara->pap_smear ?? '') == 1 ? 'checked' : '' }}>
                                <label class="form-check-label">Ya</label>
                            </div>
                            <div class="form-check">
                                <input type="radio" name="pap_smear" value="0" class="form-check-input"
                                    {{ old('pap_smear', $kankerPayudara->pap_smear ?? '') == 0 ? 'checked' : '' }}>
                                <label class="form-check-label">Tidak</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="row">
                <!-- 11. Sering berganti pasangan -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label>11. Sering berganti pasangan</label>
                        <div class="d-flex align-items-center">
                            <div class="form-check mr-3">
                                <input type="radio" name="berganti_pasangan" value="1" class="form-check-input"
                                    {{ old('berganti_pasangan', $kankerPayudara->berganti_pasangan ?? '') == 1 ? 'checked' : '' }}>
                                <label class="form-check-label">Ya</label>
                            </div>
                            <div class="form-check">
                                <input type="radio" name="berganti_pasangan" value="0" class="form-check-input"
                                    {{ old('berganti_pasangan', $kankerPayudara->berganti_pasangan ?? '') == 0 ? 'checked' : '' }}>
                                <label class="form-check-label">Tidak</label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 12. Riwayat keluarga kanker -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label>12. Riwayat keluarga kanker</label>
                        <div class="d-flex align-items-center mb-2">
                            <div class="form-check mr-3">
                                <input type="radio" name="riwayat_kanker" value="1" class="form-check-input"
                                    {{ old('riwayat_kanker', $kankerPayudara->riwayat_kanker ?? '') == 1 ? 'checked' : '' }}>
                                <label class="form-check-label">Ya</label>
                            </div>
                            <div class="form-check">
                                <input type="radio" name="riwayat_kanker" value="0" class="form-check-input"
                                    {{ old('riwayat_kanker', $kankerPayudara->riwayat_kanker ?? '') == 0 ? 'checked' : '' }}>
                                <label class="form-check-label">Tidak</label>
                            </div>
                        </div>

                        <div id="jenis_kanker"
                            style="display: {{ old('riwayat_kanker', $kankerPayudara->riwayat_kanker ?? '') == 1 ? 'block' : 'none' }};">
                            <label for="jenisKanker">Sebutkan jenis kanker:</label>
                            <input type="text" id="jenisKanker" name="jenis_kanker" class="form-control"
                                placeholder="Jenis kanker"
                                value="{{ old('jenis_kanker', $kankerPayudara->jenis_kanker ?? '') }}">
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- 13. Kehamilan pertama >35 tahun -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label>13. Kehamilan pertama >35 tahun</label>
                        <div class="d-flex align-items-center">
                            <div class="form-check mr-3">
                                <input type="radio" name="kehamilan_pertama" value="1" class="form-check-input"
                                    {{ old('kehamilan_pertama', $kankerPayudara->kehamilan_pertama ?? '') == 1 ? 'checked' : '' }}>
                                <label class="form-check-label">Ya</label>
                            </div>
                            <div class="form-check">
                                <input type="radio" name="kehamilan_pertama" value="0" class="form-check-input"
                                    {{ old('kehamilan_pertama', $kankerPayudara->kehamilan_pertama ?? '') == 0 ? 'checked' : '' }}>
                                <label class="form-check-label">Tidak</label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 14. Pernah menyusui -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label>14. Pernah menyusui</label>
                        <div class="d-flex align-items-center">
                            <div class="form-check mr-3">
                                <input type="radio" name="menyusui" value="1" class="form-check-input"
                                    {{ old('menyusui', $kankerPayudara->menyusui ?? '') == 1 ? 'checked' : '' }}>
                                <label class="form-check-label">Ya</label>
                            </div>
                            <div class="form-check">
                                <input type="radio" name="menyusui" value="0" class="form-check-input"
                                    {{ old('menyusui', $kankerPayudara->menyusui ?? '') == 0 ? 'checked' : '' }}>
                                <label class="form-check-label">Tidak</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="row">
                <!-- 15. Pernah melahirkan -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label>15. Pernah melahirkan</label>
                        <div class="d-flex align-items-center">
                            <div class="form-check mr-3">
                                <input type="radio" name="melahirkan" value="1" class="form-check-input"
                                    {{ old('melahirkan', $kankerPayudara->melahirkan ?? '') == 1 ? 'checked' : '' }}>
                                <label class="form-check-label">Ya</label>
                            </div>
                            <div class="form-check">
                                <input type="radio" name="melahirkan" value="0" class="form-check-input"
                                    {{ old('melahirkan', $kankerPayudara->melahirkan ?? '') == 0 ? 'checked' : '' }}>
                                <label class="form-check-label">Tidak</label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 16. Melahirkan ≥4 kali -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label>16. Melahirkan ≥4 kali</label>
                        <div class="d-flex align-items-center">
                            <div class="form-check mr-3">
                                <input type="radio" name="melahirkan_4_kali" value="1" class="form-check-input"
                                    {{ old('melahirkan_4_kali', $kankerPayudara->melahirkan_4_kali ?? '') == 1 ? 'checked' : '' }}>
                                <label class="form-check-label">Ya</label>
                            </div>
                            <div class="form-check">
                                <input type="radio" name="melahirkan_4_kali" value="0" class="form-check-input"
                                    {{ old('melahirkan_4_kali', $kankerPayudara->melahirkan_4_kali ?? '') == 0 ? 'checked' : '' }}>
                                <label class="form-check-label">Tidak</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- 17. Menikah >1 kali -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label>17. Menikah >1 kali</label>
                        <div class="d-flex align-items-center">
                            <div class="form-check mr-3">
                                <input type="radio" name="menikah_lbh_1" value="1" class="form-check-input"
                                    {{ old('menikah_lbh_1', $kankerPayudara->menikah_lbh_1 ?? '') == 1 ? 'checked' : '' }}>
                                <label class="form-check-label">Ya</label>
                            </div>
                            <div class="form-check">
                                <input type="radio" name="menikah_lbh_1" value="0" class="form-check-input"
                                    {{ old('menikah_lbh_1', $kankerPayudara->menikah_lbh_1 ?? '') == 0 ? 'checked' : '' }}>
                                <label class="form-check-label">Tidak</label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 19. KB hormonal (Pil >5 tahun) -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label>19. KB hormonal (Pil >5 tahun)</label>
                        <div class="d-flex align-items-center">
                            <div class="form-check mr-3">
                                <input type="radio" name="kb_hormonal_pil" value="1" class="form-check-input"
                                    {{ old('kb_hormonal_pil', $kankerPayudara->kb_hormonal_pil ?? '') == 1 ? 'checked' : '' }}>
                                <label class="form-check-label">Ya</label>
                            </div>
                            <div class="form-check">
                                <input type="radio" name="kb_hormonal_pil" value="0" class="form-check-input"
                                    {{ old('kb_hormonal_pil', $kankerPayudara->kb_hormonal_pil ?? '') == 0 ? 'checked' : '' }}>
                                <label class="form-check-label">Tidak</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="row">
                <!-- 20. KB hormonal (Suntik >5 tahun) -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label>20. KB hormonal (Suntik >5 tahun)</label>
                        <div class="d-flex align-items-center">
                            <div class="form-check mr-3">
                                <input type="radio" name="kb_hormonal_suntik" value="1" class="form-check-input"
                                    {{ old('kb_hormonal_suntik', $kankerPayudara->kb_hormonal_suntik ?? '') == 1 ? 'checked' : '' }}>
                                <label class="form-check-label">Ya</label>
                            </div>
                            <div class="form-check">
                                <input type="radio" name="kb_hormonal_suntik" value="0" class="form-check-input"
                                    {{ old('kb_hormonal_suntik', $kankerPayudara->kb_hormonal_suntik ?? '') == 0 ? 'checked' : '' }}>
                                <label class="form-check-label">Tidak</label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 21. Riwayat tumor jinak payudara -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label>21. Riwayat tumor jinak payudara</label>
                        <div class="d-flex align-items-center">
                            <div class="form-check mr-3">
                                <input type="radio" name="tumor_jinak" value="1" class="form-check-input"
                                    {{ old('tumor_jinak', $kankerPayudara->tumor_jinak ?? '') == 1 ? 'checked' : '' }}>
                                <label class="form-check-label">Ya</label>
                            </div>
                            <div class="form-check">
                                <input type="radio" name="tumor_jinak" value="0" class="form-check-input"
                                    {{ old('tumor_jinak', $kankerPayudara->tumor_jinak ?? '') == 0 ? 'checked' : '' }}>
                                <label class="form-check-label">Tidak</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- 22. Menopause >50 tahun -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label>22. Menopause >50 tahun</label>
                        <div class="d-flex align-items-center">
                            <div class="form-check mr-3">
                                <input type="radio" name="menopause" value="1" class="form-check-input"
                                    {{ old('menopause', $kankerPayudara->menopause ?? '') == 1 ? 'checked' : '' }}>
                                <label class="form-check-label">Ya</label>
                            </div>
                            <div class="form-check">
                                <input type="radio" name="menopause" value="0" class="form-check-input"
                                    {{ old('menopause', $kankerPayudara->menopause ?? '') == 0 ? 'checked' : '' }}>
                                <label class="form-check-label">Tidak</label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 23. Obesitas (IMT >27 kg/m²) -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label>23. Obesitas (IMT >27 kg/m²)</label>
                        <div class="d-flex align-items-center">
                            <div class="form-check mr-3">
                                <input type="radio" name="obesitas" value="1" class="form-check-input"
                                    {{ old('obesitas', $kankerPayudara->obesitas ?? '') == 1 ? 'checked' : '' }}>
                                <label class="form-check-label">Ya</label>
                            </div>
                            <div class="form-check">
                                <input type="radio" name="obesitas" value="0" class="form-check-input"
                                    {{ old('obesitas', $kankerPayudara->obesitas ?? '') == 0 ? 'checked' : '' }}>
                                <label class="form-check-label">Tidak</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="form-section">
            <h3>Pemeriksaan Payudara (diisi oleh petugas medis)</h3>
            <img src="{{ asset('assets/images/payudara.png') }}" alt="Pemeriksaan Payudara"
                class="img-fluid mx-auto d-block">

            <h4 class="mt-4">Pemeriksaan Kulit</h4>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-check-inline">
                        <input type="checkbox" name="kulit[]" value="normal" class="form-check-input"
                            {{ in_array('normal', old('kulit', $kankerPayudara->kulit ?? [])) ? 'checked' : '' }}>
                        <label class="form-check-label">Normal</label>
                    </div>
                    <div class="form-check-inline">
                        <input type="checkbox" name="kulit[]" value="abnormal" class="form-check-input"
                            {{ in_array('abnormal', old('kulit', $kankerPayudara->kulit ?? [])) ? 'checked' : '' }}>
                        <label class="form-check-label">Abnormal</label>
                    </div>
                    <div class="form-check-inline">
                        <input type="checkbox" name="kulit[]" value="kulit_jeruk" class="form-check-input"
                            {{ in_array('kulit_jeruk', old('kulit', $kankerPayudara->kulit ?? [])) ? 'checked' : '' }}>
                        <label class="form-check-label">Kulit Jeruk</label>
                    </div>
                    <div class="form-check-inline">
                        <input type="checkbox" name="kulit[]" value="penarikan_kulit" class="form-check-input"
                            {{ in_array('penarikan_kulit', old('kulit', $kankerPayudara->kulit ?? [])) ? 'checked' : '' }}>
                        <label class="form-check-label">Penarikan Kulit</label>
                    </div>
                    <div class="form-check-inline">
                        <input type="checkbox" name="kulit[]" value="luka_basah" class="form-check-input"
                            {{ in_array('luka_basah', old('kulit', $kankerPayudara->kulit ?? [])) ? 'checked' : '' }}>
                        <label class="form-check-label">Luka Basah</label>
                    </div>
                </div>
            </div>

            <h4 class="mt-4">Pemeriksaan Areola/Papilla</h4>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-check-inline">
                        <input type="checkbox" name="areola[]" value="normal" class="form-check-input"
                            {{ in_array('normal', old('areola', $kankerPayudara->areola ?? [])) ? 'checked' : '' }}>
                        <label class="form-check-label">Normal</label>
                    </div>
                    <div class="form-check-inline">
                        <input type="checkbox" name="areola[]" value="abnormal" class="form-check-input"
                            {{ in_array('abnormal', old('areola', $kankerPayudara->areola ?? [])) ? 'checked' : '' }}>
                        <label class="form-check-label">Abnormal</label>
                    </div>
                    <div class="form-check-inline">
                        <input type="checkbox" name="areola[]" value="retraksi" class="form-check-input"
                            {{ in_array('retraksi', old('areola', $kankerPayudara->areola ?? [])) ? 'checked' : '' }}>
                        <label class="form-check-label">Retraksi</label>
                    </div>
                    <div class="form-check-inline">
                        <input type="checkbox" name="areola[]" value="luka_basah" class="form-check-input"
                            {{ in_array('luka_basah', old('areola', $kankerPayudara->areola ?? [])) ? 'checked' : '' }}>
                        <label class="form-check-label">Luka Basah</label>
                    </div>
                    <div class="form-check-inline">
                        <input type="checkbox" name="areola[]" value="cairan_abnormal" class="form-check-input"
                            {{ in_array('cairan_abnormal', old('areola', $kankerPayudara->areola ?? [])) ? 'checked' : '' }}>
                        <label class="form-check-label">Cairan Abnormal dari Puting Susu</label>
                    </div>
                </div>
            </div>


            <h4 class="mt-4">Benjolan pada Payudara</h4>
            <div class="row">
                <div class="col-md-6">
                    <label>Apakah ada benjolan?</label>
                    <div class="d-flex align-items-center mb-2">
                        <div class="form-check mr-3">
                            <input type="radio" name="benjolan" value="1" class="form-check-input"
                                {{ old('benjolan', $kankerPayudara->benjolan ?? null) == 1 ? 'checked' : '' }}>
                            <label class="form-check-label">Ya</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" name="benjolan" value="0" class="form-check-input"
                                {{ old('benjolan', $kankerPayudara->benjolan ?? null) == 0 ? 'checked' : '' }}>
                            <label class="form-check-label">Tidak</label>
                        </div>
                    </div>
                    <div id="ukuran_benjolan"
                        style="display: {{ old('benjolan', $kankerPayudara->benjolan ?? null) == 1 ? 'block' : 'none' }}">
                        <label for="ukuran_benjolan">Jika ya, ukuran (cm):</label>
                        <input type="text" name="ukuran_benjolan" class="form-control" placeholder="Contoh: 3x2 cm"
                            value="{{ old('ukuran_benjolan', $kankerPayudara->ukuran_benjolan ?? '') }}">
                    </div>
                </div>
            </div>

            <h4 class="mt-4">Penatalaksanaan</h4>
            <div class="row">
                <div class="col-md-6">
                    <label>Hasil Pemeriksaan Payudara</label>
                    <div class="form-check">
                        <input type="checkbox" name="normal[]" value="normal" class="form-check-input"
                            {{ in_array('normal', old('normal', $kankerPayudara->normal ?? [])) ? 'checked' : '' }}>
                        <label class="form-check-label"><b>Normal</b></label>
                    </div>
                    <div class="ml-4">
                        <div class="form-check">
                            <input type="checkbox" name="normal[]" value="sadari" class="form-check-input"
                                {{ in_array('sadari', old('normal', $kankerPayudara->normal ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label">Anjurkan SADARI setiap bulan</label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" name="normal[]" value="oemeriksa_payudara" class="form-check-input"
                                {{ in_array('oemeriksa_payudara', old('normal', $kankerPayudara->normal ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label">Pemeriksaan Payudara 1 tahun sekali</label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" name="normal[]" value="mammografi" class="form-check-input"
                                {{ in_array('mammografi', old('normal', $kankerPayudara->normal ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label">Pemeriksaan mammografi pada usia >40 tahun</label>
                        </div>
                    </div>
                    <div class="form-check mt-4">
                        <input type="checkbox" name="kelainan_jinak[]" value="kelainan_jinak" class="form-check-input"
                            {{ in_array('kelainan_jinak', old('kelainan_jinak', $kankerPayudara->kelainan_jinak ?? [])) ? 'checked' : '' }}>
                        <label class="form-check-label"><b>Kemungkinan Kelainan Payudara Jinak</b></label>
                    </div>
                    <div class="ml-4">
                        <div class="form-check">
                            <input type="checkbox" name="kelainan_jinak[]" value="rujuk" class="form-check-input"
                                {{ in_array('rujuk', old('kelainan_jinak', $kankerPayudara->kelainan_jinak ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label">Rujuk untuk pemeriksaan lanjutan</label>
                        </div>
                    </div>
                    <div class="form-check mt-4">
                        <input type="checkbox" name="kelainan_ganas[]" value="kelainan_ganas" class="form-check-input"
                            {{ in_array('kelainan_ganas', old('kelainan_ganas', $kankerPayudara->kelainan_ganas ?? [])) ? 'checked' : '' }}>
                        <label class="form-check-label"><b>Dicurigai Kelainan Payudara Ganas</b></label>
                    </div>
                    <div class="ml-4">
                        <div class="form-check">
                            <input type="checkbox" name="kelainan_ganas[]" value="rujukan" class="form-check-input"
                                {{ in_array('rujukan', old('kelainan_ganas', $kankerPayudara->kelainan_ganas ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label">Rujuk untuk pemeriksaan lanjutan</label>
                        </div>
                    </div>
                </div>
            </div>


        </div>
        <div class="form-section">
            <h3>Pemeriksaan IVA</h3>
            <label>Ada Kelainan</label>
            <img src="{{ asset('assets/images/peta_serviks.png') }}" alt="Pemeriksaan peta_serviks"
                class="img-fluid mx-auto d-block" style="max-width: 300px; height: 300px;">

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>1. Vulva</label>
                        <div class="d-flex align-items-center">
                            <div class="form-check mr-3">
                                <input type="radio" name="vulva" value="1" class="form-check-input"
                                    @isset($kankerPayudara->vulva) @if ($kankerPayudara->vulva == 1) checked @endif @endisset
                                    onclick="toggleInput('vulva_details', true)">
                                <label class="form-check-label">Ya</label>
                            </div>
                            <div class="form-check">
                                <input type="radio" name="vulva" value="0" class="form-check-input"
                                    @isset($kankerPayudara->vulva) @if ($kankerPayudara->vulva == 0) checked @endif @endisset
                                    onclick="toggleInput('vulva_details', false)">
                                <label class="form-check-label">Tidak</label>
                            </div>
                        </div>
                        <div id="vulva_details" class="mt-2"
                            style="display: @isset($kankerPayudara->vulva) @if ($kankerPayudara->vulva == 1) block @else none @endif @endisset;">
                            <label>Sebutkan:</label>
                            <input type="text" name="vulva_details" class="form-control"
                                @isset($kankerPayudara->vulva_details) value="{{ $kankerPayudara->vulva_details }}" @endisset
                                placeholder="Deskripsikan kelainan">
                        </div>
                    </div>
                </div>

                <!-- Repeat similar structure for Vagina -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label>2. Vagina</label>
                        <div class="d-flex align-items-center">
                            <div class="form-check mr-3">
                                <input type="radio" name="vagina" value="1" class="form-check-input"
                                    @isset($kankerPayudara->vagina) @if ($kankerPayudara->vagina == 1) checked @endif @endisset
                                    onclick="toggleInput('vagina_details', true)">
                                <label class="form-check-label">Ya</label>
                            </div>
                            <div class="form-check">
                                <input type="radio" name="vagina" value="0" class="form-check-input"
                                    @isset($kankerPayudara->vagina) @if ($kankerPayudara->vagina == 0) checked @endif @endisset
                                    onclick="toggleInput('vagina_details', false)">
                                <label class="form-check-label">Tidak</label>
                            </div>
                        </div>
                        <div id="vagina_details" class="mt-2"
                            style="display: @isset($kankerPayudara->vagina) @if ($kankerPayudara->vagina == 1) block @else none @endif @endisset;">
                            <label>Sebutkan:</label>
                            <input type="text" name="vagina_details" class="form-control"
                                @isset($kankerPayudara->vagina_details) value="{{ $kankerPayudara->vagina_details }}" @endisset
                                placeholder="Deskripsikan kelainan">
                        </div>
                    </div>
                </div>


                <div class="col-md-6">
                    <div class="form-group">
                        <label>3. Serviks</label>
                        <div class="d-flex align-items-center">
                            <div class="form-check mr-3">
                                <input type="radio" name="serviks" value="1" class="form-check-input"
                                    @isset($kankerPayudara->serviks) @if ($kankerPayudara->serviks == 1) checked @endif @endisset
                                    onclick="toggleInput('serviks_details', true)">
                                <label class="form-check-label">Ya</label>
                            </div>
                            <div class="form-check">
                                <input type="radio" name="serviks" value="0" class="form-check-input"
                                    @isset($kankerPayudara->serviks) @if ($kankerPayudara->serviks == 0) checked @endif @endisset
                                    onclick="toggleInput('serviks_details', false)">
                                <label class="form-check-label">Tidak</label>
                            </div>
                        </div>
                        <div id="serviks_details" class="mt-2"
                            style="display: @isset($kankerPayudara->serviks) @if ($kankerPayudara->serviks == 1) block @else none @endif @endisset;">
                            <label>Sebutkan:</label>
                            <input type="text" name="serviks_details" class="form-control"
                                @isset($kankerPayudara->serviks_details) value="{{ $kankerPayudara->serviks_details }}" @endisset
                                placeholder="Deskripsikan kelainan">
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label>4. Uterus</label>
                        <div class="d-flex align-items-center">
                            <div class="form-check mr-3">
                                <input type="radio" name="uterus" value="1" class="form-check-input"
                                    @isset($kankerPayudara->uterus) @if ($kankerPayudara->uterus == 1) checked @endif @endisset
                                    onclick="toggleInput('uterus_details', true)">
                                <label class="form-check-label">Ya</label>
                            </div>
                            <div class="form-check">
                                <input type="radio" name="uterus" value="0" class="form-check-input"
                                    @isset($kankerPayudara->uterus) @if ($kankerPayudara->uterus == 0) checked @endif @endisset
                                    onclick="toggleInput('uterus_details', false)">
                                <label class="form-check-label">Tidak</label>
                            </div>
                        </div>
                        <div id="uterus_details" class="mt-2"
                            style="display: @isset($kankerPayudara->uterus) @if ($kankerPayudara->uterus == 1) block @else none @endif @endisset;">
                            <label>Sebutkan:</label>
                            <input type="text" name="uterus_details" class="form-control"
                                @isset($kankerPayudara->uterus_details) value="{{ $kankerPayudara->uterus_details }}" @endisset
                                placeholder="Deskripsikan kelainan">
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label>5. Adnexa</label>
                        <div class="d-flex align-items-center">
                            <div class="form-check mr-3">
                                <input type="radio" name="adnexa" value="1" class="form-check-input"
                                    @isset($kankerPayudara->adnexa) @if ($kankerPayudara->adnexa == 1) checked @endif @endisset
                                    onclick="toggleInput('adnexa_details', true)">
                                <label class="form-check-label">Ya</label>
                            </div>
                            <div class="form-check">
                                <input type="radio" name="adnexa" value="0" class="form-check-input"
                                    @isset($kankerPayudara->adnexa) @if ($kankerPayudara->adnexa == 0) checked @endif @endisset
                                    onclick="toggleInput('adnexa_details', false)">
                                <label class="form-check-label">Tidak</label>
                            </div>
                        </div>
                        <div id="adnexa_details" class="mt-2"
                            style="display: @isset($kankerPayudara->adnexa) @if ($kankerPayudara->adnexa == 1) block @else none @endif @endisset;">
                            <label>Sebutkan:</label>
                            <input type="text" name="adnexa_details" class="form-control"
                                @isset($kankerPayudara->adnexa_details) value="{{ $kankerPayudara->adnexa_details }}" @endisset
                                placeholder="Deskripsikan kelainan">
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>6. Pemeriksaan Rectovaginal (jika diindikasikan)</label>
                        <div class="d-flex align-items-center">
                            <div class="form-check mr-3">
                                <input type="radio" name="rectovaginal" value="1" class="form-check-input"
                                    @isset($kankerPayudara->rectovaginal) @if ($kankerPayudara->rectovaginal == 1) checked @endif @endisset
                                    onclick="toggleInput('rectovaginal_details', true)">
                                <label class="form-check-label">Ya</label>
                            </div>
                            <div class="form-check">
                                <input type="radio" name="rectovaginal" value="0" class="form-check-input"
                                    @isset($kankerPayudara->rectovaginal) @if ($kankerPayudara->rectovaginal == 0) checked @endif @endisset
                                    onclick="toggleInput('rectovaginal_details', false)">
                                <label class="form-check-label">Tidak</label>
                            </div>
                        </div>
                        <div id="rectovaginal_details" class="mt-2"
                            style="display: @isset($kankerPayudara->rectovaginal) @if ($kankerPayudara->rectovaginal == 1) block @else none @endif @endisset;">
                            <label>Sebutkan:</label>
                            <input type="text" name="rectovaginal_details" class="form-control"
                                @isset($kankerPayudara->rectovaginal_details) value="{{ $kankerPayudara->rectovaginal_details }}" @endisset
                                placeholder="Deskripsikan kelainan">
                        </div>
                    </div>
                </div>

            </div>

            <h4 class="mt-4">Hasil IVA & Penatalaksanaan</h4>
            <div class="row">
                <div class="col-md-12">
                    <label>Hasil IVA</label>
                    <!-- IVA Negatif -->
                    <div class="form-check">
                        <input type="checkbox" name="iva_negatif[]" value="iva_negatif" class="form-check-input"
                            @isset($kankerPayudara->iva_negatif) @if (in_array('iva_negatif', $kankerPayudara->iva_negatif)) checked @endif @endisset>
                        <label class="form-check-label"><b>IVA Negatif</b></label>
                    </div>
                    <div class="ml-4">
                        <div class="form-check">
                            <input type="checkbox" name="iva_negatif[]" value="anjuran_kembali_5th"
                                class="form-check-input"
                                @isset($kankerPayudara->iva_negatif) @if (in_array('anjuran_kembali_5th', $kankerPayudara->iva_negatif)) checked @endif @endisset>
                            <label class="form-check-label">Anjurkan kembali setelah 5 tahun untuk melakukan tes (bila
                                tanpa keluhan)</label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" name="iva_negatif[]" value="anjuran_datang_segera"
                                class="form-check-input"
                                @isset($kankerPayudara->iva_negatif) @if (in_array('anjuran_datang_segera', $kankerPayudara->iva_negatif)) checked @endif @endisset>
                            <label class="form-check-label">Anjuran datang segera</label>
                        </div>
                    </div>

                    <!-- IVA Positif -->
                    <div class="form-check mt-4">
                        <input type="checkbox" name="iva_positif[]" value="iva_positif" class="form-check-input"
                            @isset($kankerPayudara->iva_positif) @if (in_array('iva_positif', $kankerPayudara->iva_positif)) checked @endif @endisset>
                        <label class="form-check-label"><b>IVA Positif</b></label>
                    </div>
                    <div class="ml-4">
                        <div class="form-check">
                            <input type="checkbox" name="iva_positif[]" value="konseling" class="form-check-input"
                                @isset($kankerPayudara->iva_positif) @if (in_array('konseling', $kankerPayudara->iva_positif)) checked @endif @endisset>
                            <label class="form-check-label">Beri konseling tentang risiko kanker leher rahim dan pilihan
                                pengobatan</label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" name="iva_positif[]" value="berobat" class="form-check-input"
                                @isset($kankerPayudara->iva_positif) @if (in_array('berobat', $kankerPayudara->iva_positif)) checked @endif @endisset>
                            <label class="form-check-label">Menerima pengobatan yang dianjurkan</label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" id="kunjungan_ulang_checkbox" class="form-check-input"
                                onclick="toggleField('kunjungan_ulang_field', this)"
                                @isset($kankerPayudara->iva_positif) @if (in_array('kunjungan_ulang', $kankerPayudara->iva_positif)) checked @endif @endisset>
                            <label class="form-check-label">Tanggal kunjungan ulang</label>
                        </div>
                        <div id="kunjungan_ulang_field" class="ml-4 mt-2"
                            style="display: @isset($kankerPayudara->iva_positif) @if (in_array('kunjungan_ulang', $kankerPayudara->iva_positif)) block @else none @endif @endisset;">
                            <input type="date" name="tanggal_kunjungan" class="form-control"
                                @isset($kankerPayudara->tanggal_kunjungan) value="{{ $kankerPayudara->tanggal_kunjungan }}" @endisset>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" name="iva_positif[]" value="pengobatan_diberikan"
                                class="form-check-input"
                                @isset($kankerPayudara->iva_positif) @if (in_array('pengobatan_diberikan', $kankerPayudara->iva_positif)) checked @endif @endisset>
                            <label class="form-check-label">Pengobatan yang diberikan</label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" name="iva_positif[]" value="krioterapi" class="form-check-input"
                                @isset($kankerPayudara->iva_positif) @if (in_array('krioterapi', $kankerPayudara->iva_positif)) checked @endif @endisset>
                            <label class="form-check-label">Krioterapi (petunjuk diberikan)</label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" id="lainnya_checkbox" class="form-check-input"
                                onclick="toggleField('lainnya_field', this)"
                                @isset($kankerPayudara->iva_positif) @if (in_array('lainnya', $kankerPayudara->iva_positif)) checked @endif @endisset>
                            <label class="form-check-label">Lainnya (petunjuk diberikan)</label>
                        </div>
                        <div id="lainnya_field" class="ml-4 mt-2"
                            style="display: @isset($kankerPayudara->iva_positif) @if (in_array('lainnya', $kankerPayudara->iva_positif)) block @else none @endif @endisset;">
                            <input type="text" name="lainnya" class="form-control" placeholder="Deskripsikan lainnya"
                                @isset($kankerPayudara->lainnya) value="{{ $kankerPayudara->lainnya }}" @endisset>
                        </div>
                    </div>
                    <div class="form-check mt-4">
                        <input type="checkbox" name="ims[]" value="ims" class="form-check-input"
                            @isset($kankerPayudara->ims) @if (in_array('ims', $kankerPayudara->ims)) checked @endif @endisset>
                        <label class="form-check-label"><b>Diduga IMS</b></label>
                    </div>
                    <div class="ml-4">
                        <div class="form-check">
                            <input type="checkbox" id="diobati_checkbox" class="form-check-input" name="ims[]"
                                value="diobati"
                                @isset($kankerPayudara->ims) @if (in_array('diobati', $kankerPayudara->ims)) checked @endif @endisset
                                onclick="toggleField('diobati_field', this)">
                            <label class="form-check-label">Diobati</label>
                        </div>
                        <div id="diobati_field" class="ml-4 mt-2" style="display: none;">
                            <input type="text" name="detail_diobati" class="form-control"
                                placeholder="Deskripsikan diobati"
                                @isset($kankerPayudara->detail_diobati) value="{{ $kankerPayudara->detail_diobati }}" @endisset>
                        </div>

                        <div class="form-check">
                            <input type="checkbox" id="dirujuk_checkbox" class="form-check-input" name="ims[]"
                                value="dirujuk"
                                @isset($kankerPayudara->ims) @if (in_array('dirujuk', $kankerPayudara->ims)) checked @endif @endisset
                                onclick="toggleField('dirujuk_field', this)">
                            <label class="form-check-label">Dirujuk</label>
                        </div>
                        <div id="dirujuk_field" class="ml-4 mt-2" style="display: none;">
                            <input type="text" name="dirujuk" class="form-control" placeholder="Deskripsikan dirujuk"
                                @isset($kankerPayudara->dirujuk) value="{{ $kankerPayudara->dirujuk }}" @endisset>
                        </div>
                    </div>

                    <div class="form-check mt-4">
                        <input type="checkbox" name="rujukan[]" value="rujukan" class="form-check-input"
                            @isset($kankerPayudara->rujukan) @if (in_array('rujukan', $kankerPayudara->rujukan)) checked @endif @endisset>
                        <label class="form-check-label"><b>Rujukan</b></label>
                    </div>
                    <div class="ml-4">
                        <div class="form-check">
                            <input type="checkbox" name="rujukan[]" value="kanker_leher_rahim" class="form-check-input"
                                @isset($kankerPayudara->rujukan) @if (in_array('kanker_leher_rahim', $kankerPayudara->rujukan)) checked @endif @endisset>
                            <label class="form-check-label">Curiga kanker leher rahim</label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" name="rujukan[]" value="lesi_75" class="form-check-input"
                                @isset($kankerPayudara->rujukan) @if (in_array('lesi_75', $kankerPayudara->rujukan)) checked @endif @endisset>
                            <label class="form-check-label">Lesi >75%</label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" name="rujukan[]" value="lesi_2" class="form-check-input"
                                @isset($kankerPayudara->rujukan) @if (in_array('lesi_2', $kankerPayudara->rujukan)) checked @endif @endisset>
                            <label class="form-check-label">Lesi >2 mm melebihi ujung prob krio</label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" name="rujukan[]" value="lesi_meluas" class="form-check-input"
                                @isset($kankerPayudara->rujukan) @if (in_array('lesi_meluas', $kankerPayudara->rujukan)) checked @endif @endisset>
                            <label class="form-check-label">Lesi meluas sampai dinding vagina</label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" name="rujukan[]" value="dirujuk" class="form-check-input"
                                @isset($kankerPayudara->rujukan) @if (in_array('dirujuk', $kankerPayudara->rujukan)) checked @endif @endisset>
                            <label class="form-check-label">Dirujuk untuk tes atau pengobatan lanjutan</label>
                        </div>
                    </div>



                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-12">
                <label for="kesimpulan" style="color: rgb(19, 11, 241);">Kesimpulan</label>
                <textarea class="form-control" id="kesimpulan" name="kesimpulan" placeholder="Kesimpulan">{{ old('kesimpulan', $kankerPayudara->kesimpulan ?? '') }}</textarea>
            </div>
        </div>

        <div class="text-right mt-4">
            {{-- @if (isset($kankerPayudara) && $kankerPayudara)
                <a href="{{ route('kankerPayudara.lansia.admin') }}" type="button" class="btn btn-secondary mr-2"
                    style="font-size: 20px">Kembali</a>
            @else
                <a href="{{ route('skrining.ilp') }}" type="button" class="btn btn-secondary mr-2"
                    style="font-size: 20px">Kembali</a>
            @endif --}}
            <button type="submit" class="btn btn-primary" style="font-size: 20px">Kirim</button>
        </div>
    </form>
    <script>
        function toggleInput(elementId, show) {
            const element = document.getElementById(elementId);
            element.style.display = show ? 'block' : 'none';
        }

        function toggleField(fieldId, checkbox) {
            const field = document.getElementById(fieldId);
            if (checkbox.checked) {
                field.style.display = 'block';
            } else {
                field.style.display = 'none';
            }
        }
        document.addEventListener('DOMContentLoaded', function() {
            const riwayatBenjolanRadios = document.getElementsByName('benjolan');
            const ukuranBenjolanField = document.getElementById('ukuran_benjolan');

            riwayatBenjolanRadios.forEach(radio => {
                radio.addEventListener('change', function() {
                    if (this.value === '1') { // Jika "Ya"
                        ukuranBenjolanField.style.display = 'block';
                    } else {
                        ukuranBenjolanField.style.display = 'none';
                    }
                });
            });
            const imsCheckboxes = document.querySelectorAll('input[name="ims[]"]');
            imsCheckboxes.forEach(checkbox => {
                if (checkbox.value === 'diobati' && checkbox.checked) {
                    toggleInput('diobati_field', true);
                }
                if (checkbox.value === 'dirujuk' && checkbox.checked) {
                    toggleInput('dirujuk_field', true);
                }
                checkbox.addEventListener('change', function() {
                    if (this.value === 'diobati') {
                        toggleInput('diobati_field', this.checked);
                    }
                    if (this.value === 'dirujuk') {
                        toggleInput('dirujuk_field', this.checked);
                    }
                });
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

            // Event listener saat pasien dipilih
            $('#pasien').on('change', function() {
                var selectedOption = $(this).find(':selected');

                // Ambil data dari atribut data-*
                var no_hp = selectedOption.data('no_hp');
                var pendidikan = selectedOption.data('pendidikan');
                var rt = selectedOption.data('rt');
                var alamat = selectedOption.data('alamat');
                var pekerjaan = selectedOption.data('pekerjaan');
                var jk = selectedOption.data('jenis_kelamin');
                var dob = selectedOption.data('dob');
                // Isi input dengan data yang diambil
                $('#no_hp').val(no_hp);
                $('#pendidikan').val(pendidikan);
                $('#rt').val(rt);
                $('#alamat').val(alamat);
                $('#pekerjaan').val(pekerjaan);
                $('#tanggal_lahir').val(dob);
                $('input[name="jenis_kelamin"]').prop('checked', false); // Uncheck all checkboxes first
                if (jk === 'Laki-Laki') {
                    $('#jk_laki').prop('checked', true);
                } else if (jk === 'Perempuan') {
                    $('#jk_perempuan').prop('checked', true);
                }
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
            });
            $('#pasien').trigger('change');
        });
    </script>
@endsection
