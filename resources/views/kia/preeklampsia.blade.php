@extends('layouts.skrining.master')
@section('title', 'Skrining Preeklampsia')
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

        .required {
            color: red;
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
        action="{{ isset($preeklampsia) ? route('preeklampsia.update', $preeklampsia->id) : route('preeklampsia.store') }}"
        method="POST">
        @csrf
        @if (isset($preeklampsia))
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
                                {{-- @else
                                <option value="" disabled selected>Pilih</option>
                                @foreach ($allPasien as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }} - {{ $item->nik }}</option>
                                @endforeach --}}
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
                        <label>Alamat Lengkap</label>
                        <input type="text" class="form-control" name="alamat" id="alamat" readonly
                            value="{{ old('alamat', $pasien->address ?? '') }}" placeholder="Masukkan alamat lengkap">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Jenis Kelamin</label>
                        <div class="d-flex">
                            <div class="form-check mr-3">
                                <input type="radio" class="form-check-input" name="jenis_kelamin" value="laki-laki"
                                    id="jk_laki"
                                    {{ old('jenis_kelamin', $pasien->gender ?? '') == '2' ? 'checked' : '' }}>
                                <label class="form-check-label" for="laki-laki">Laki-laki</label>
                            </div>
                            <div class="form-check">
                                <input type="radio" class="form-check-input" name="jenis_kelamin" value="perempuan"
                                    id="jk_perempuan"
                                    {{ old('jenis_kelamin', $pasien->gender ?? '') == '1' ? 'checked' : '' }}>
                                <label class="form-check-label" for="perempuan">Perempuan</label>
                            </div>
                        </div>
                    </div>

                </div>


            </div>

            <!-- Penyakit Section -->
            <div class="form-section mt-4">
                <h3>Amnesis</h3>
                <div class="form-group">
                    <label>1. Multipara dengan kehamilan oleh pasangan baru <span class="required">**</span></label>
                    <div class="d-flex">
                        <div class="form-check mr-3">
                            <input type="radio" class="form-check-input" name="multipara" value="1" data-score="1"
                                id="ya"
                                {{ old('multipara', $preeklampsia->multipara ?? '') == '1' ? 'checked' : '' }}>
                            <label class="form-check-label" for="ya">Ya</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="multipara" value="0" data-score="0"
                                id="tidak"
                                {{ old('multipara', $preeklampsia->multipara ?? '') == '0' ? 'checked' : '' }}>
                            <label class="form-check-label" for="tidak">Tidak</label>
                        </div>
                    </div>

                </div>
                <div class="form-group">
                    <label>2. Kehamilan dengan teknologi reproduksi berbantu : bayi tabung, obat induksi ovulasi <span
                            class="required">**</span></label>
                    <div class="d-flex">
                        <div class="form-check mr-3">
                            <input type="radio" class="form-check-input" name="teknologi_hamil" value="1"
                                data-score="1" id="saudara_ya"
                                {{ old('teknologi_hamil', $preeklampsia->teknologi_hamil ?? '') == '1' ? 'checked' : '' }}>
                            <label class="form-check-label" for="saudara_ya">Ya</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="teknologi_hamil" value="0"
                                data-score="0" id="saudara_tidak"
                                {{ old('teknologi_hamil', $preeklampsia->teknologi_hamil ?? '') == '0' ? 'checked' : '' }}>
                            <label class="form-check-label" for="saudara_tidak">Tidak</label>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label>3. Umur >= 35 tahun <span class="required">**</span></label>
                    <div class="d-flex">
                        <div class="form-check mr-3">
                            <input type="radio" class="form-check-input" name="umur35" value="1" data-score="1"
                                id="gemuk_ya" {{ old('umur35', $preeklampsia->umur35 ?? '') == '1' ? 'checked' : '' }}>
                            <label class="form-check-label" for="gemuk_ya">Ya</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="umur35" value="0" data-score="0"
                                id="gemuk_tidak" {{ old('umur35', $preeklampsia->umur35 ?? '') == '0' ? 'checked' : '' }}>
                            <label class="form-check-label" for="gemuk_tidak">Tidak</label>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label>4. Nulipara <span class="required">**</span></label>
                    <div class="d-flex">
                        <div class="form-check mr-3">
                            <input type="radio" class="form-check-input" name="nulipara" value="1"
                                data-score="1" id="usia50_ya"
                                {{ old('nulipara', $preeklampsia->nulipara ?? '') == '1' ? 'checked' : '' }}>
                            <label class="form-check-label" for="usia50_ya">Ya</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="nulipara" value="0"
                                data-score="0" id="usia50_tidak"
                                {{ old('nulipara', $preeklampsia->nulipara ?? '') == '0' ? 'checked' : '' }}>
                            <label class="form-check-label" for="usia50_tidak">Tidak</label>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label>5. Multipara yang jarak kehamilan sebelumnya > 10 tahun <span class="required">**</span></label>
                    <div class="d-flex">
                        <div class="form-check mr-3">
                            <input type="radio" class="form-check-input" name="multipara10" value="1"
                                data-score="1" id="multipara10Ya" onclick="toggleRokokInput(true)"
                                {{ old('multipara10', $preeklampsia->multipara10 ?? '') == '1' ? 'checked' : '' }}>
                            <label class="form-check-label" for="multipara10_ya">Ya</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="multipara10" value="0"
                                data-score="0" id="multipara10Tidak" onclick="toggleRokokInput(false)"
                                {{ old('multipara10', $preeklampsia->multipara10 ?? '') == '0' ? 'checked' : '' }}>
                            <label class="form-check-label" for="multipara10_tidak">Tidak</label>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label>6. Riwayat preeklampsia pada ibu atau saudara perempuan <span class="required">**</span></label>
                    <div class="d-flex">
                        <div class="form-check mr-3">
                            <input type="radio" class="form-check-input" name="riwayat_preeklampsia" value="1"
                                data-score="1" id="asin_ya"
                                {{ old('riwayat_preeklampsia', $preeklampsia->riwayat_preeklampsia ?? '') == '1' ? 'checked' : '' }}>
                            <label class="form-check-label" for="asin_ya">Ya</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="riwayat_preeklampsia" value="0"
                                data-score="0" id="asin_tidak"
                                {{ old('riwayat_preeklampsia', $preeklampsia->riwayat_preeklampsia ?? '') == '0' ? 'checked' : '' }}>
                            <label class="form-check-label" for="asin_tidak">Tidak</label>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label>7. Obesitas sebelum hamil (IMT > 30 kg/m2) <span class="required">**</span></label>
                    <div class="d-flex">
                        <div class="form-check mr-3">
                            <input type="radio" class="form-check-input" name="obesitas" value="1"
                                data-score="1" id="santan_ya"
                                {{ old('obesitas', $preeklampsia->obesitas ?? '') == '1' ? 'checked' : '' }}>
                            <label class="form-check-label" for="santan_ya">Ya</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="obesitas" value="0"
                                data-score="0" id="santan_tidak"
                                {{ old('obesitas', $preeklampsia->obesitas ?? '') == '0' ? 'checked' : '' }}>
                            <label class="form-check-label" for="santan_tidak">Tidak</label>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label>8. Multipara dengan riwayat preeklampsia sebelumnya <span class="required">***</span></label>
                    <div class="d-flex">
                        <div class="form-check mr-3">
                            <input type="radio" class="form-check-input" name="multipara_sebelumnya" value="1"
                                data-score="1" id="lemak_ya"
                                {{ old('multipara_sebelumnya', $preeklampsia->multipara_sebelumnya ?? '') == '1' ? 'checked' : '' }}>
                            <label class="form-check-label" for="lemak_ya">Ya</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="multipara_sebelumnya" value="0"
                                data-score="0" id="lemak_tidak"
                                {{ old('multipara_sebelumnya', $preeklampsia->multipara_sebelumnya ?? '') == '0' ? 'checked' : '' }}>
                            <label class="form-check-label" for="lemak_tidak">Tidak</label>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label>9. Kehamilan multipel <span class="required">***</span></label>
                    <div class="d-flex">
                        <div class="form-check mr-3">
                            <input type="radio" class="form-check-input" name="hamil_multipel" value="1"
                                data-score="1" id="kepala_ya"
                                {{ old('hamil_multipel', $preeklampsia->hamil_multipel ?? '') == '1' ? 'checked' : '' }}>
                            <label class="form-check-label" for="kepala_ya">Ya</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="hamil_multipel" value="0"
                                data-score="0" id="kepala_tidak"
                                {{ old('hamil_multipel', $preeklampsia->hamil_multipel ?? '') == '0' ? 'checked' : '' }}>
                            <label class="form-check-label" for="kepala_tidak">Tidak</label>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label>10. Diabetes dalam kehamilan <span class="required">***</span></label>
                    <div class="d-flex">
                        <div class="form-check mr-3">
                            <input type="radio" class="form-check-input" name="diabetes" value="1"
                                data-score="1" id="tengkuk_ya"
                                {{ old('diabetes', $preeklampsia->diabetes ?? '') == '1' ? 'checked' : '' }}>
                            <label class="form-check-label" for="tengkuk_ya">Ya</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="diabetes" value="0"
                                data-score="0" id="tengkuk_tidak"
                                {{ old('diabetes', $preeklampsia->diabetes ?? '') == '0' ? 'checked' : '' }}>
                            <label class="form-check-label" for="tengkuk_tidak">Tidak</label>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label>11. Hipertensi kronik <span class="required">***</span></label>
                    <div class="d-flex">
                        <div class="form-check mr-3">
                            <input type="radio" class="form-check-input" name="hipertensi" value="1"
                                data-score="1" id="hipertensi_ya"
                                {{ old('hipertensi', $preeklampsia->hipertensi ?? '') == '1' ? 'checked' : '' }}>
                            <label class="form-check-label" for="hipertensi_ya">Ya</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="hipertensi" value="0"
                                data-score="0" id="hipertensi_tidak"
                                {{ old('hipertensi', $preeklampsia->hipertensi ?? '') == '0' ? 'checked' : '' }}>
                            <label class="form-check-label" for="hipertensi_tidak">Tidak</label>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label>12. Penyakit ginjal <span class="required">***</span></label>
                    <div class="d-flex">
                        <div class="form-check mr-3">
                            <input type="radio" class="form-check-input" name="ginjal" value="1" data-score="1"
                                id="ginjal_ya" {{ old('ginjal', $preeklampsia->ginjal ?? '') == '1' ? 'checked' : '' }}>
                            <label class="form-check-label" for="ginjal_ya">Ya</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="ginjal" value="0" data-score="0"
                                id="ginjal_tidak"
                                {{ old('ginjal', $preeklampsia->ginjal ?? '') == '0' ? 'checked' : '' }}>
                            <label class="form-check-label" for="ginjal_tidak">Tidak</label>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label>13. Penyakit autoimon, SLE <span class="required">***</span></label>
                    <div class="d-flex">
                        <div class="form-check mr-3">
                            <input type="radio" class="form-check-input" name="autoimun" value="1"
                                data-score="0" id="autoimun_ya"
                                {{ old('autoimun', $preeklampsia->autoimun ?? '') == '1' ? 'checked' : '' }}>
                            <label class="form-check-label" for="autoimun_ya">Ya</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="autoimun" value="0"
                                id="autoimun_tidak"
                                {{ old('autoimun', $preeklampsia->autoimun ?? '') == '0' ? 'checked' : '' }}>
                            <label class="form-check-label" for="autoimun_tidak">Tidak</label>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label>14. Anti phospholipid syndrome <span class="required">***</span></label>
                    <div class="d-flex">
                        <div class="form-check mr-3">
                            <input type="radio" class="form-check-input" name="phospholipid" value="1"
                                data-score="0" id="phospholipid_ya"
                                {{ old('phospholipid', $preeklampsia->phospholipid ?? '') == '1' ? 'checked' : '' }}>
                            <label class="form-check-label" for="phospholipid_ya">Ya</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="phospholipid" value="0"
                                id="phospholipid_tidak"
                                {{ old('phospholipid', $preeklampsia->phospholipid ?? '') == '0' ? 'checked' : '' }}>
                            <label class="form-check-label" for="phospholipid_tidak">Tidak</label>
                        </div>
                    </div>
                </div>

                <h3>Pemeriksaan Fisik</h3>
                <div class="form-group">
                    <label>15. Mean Arterial Presure > 90 mmHg <span class="required">**</span></label>
                    <div class="d-flex">
                        <div class="form-check mr-3">
                            <input type="radio" class="form-check-input" name="arterial" value="1"
                                data-score="0" id="arterial_ya"
                                {{ old('arterial', $preeklampsia->arterial ?? '') == '1' ? 'checked' : '' }}>
                            <label class="form-check-label" for="arterial_ya">Ya</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="arterial" value="0"
                                id="arterial_tidak"
                                {{ old('arterial', $preeklampsia->arterial ?? '') == '0' ? 'checked' : '' }}>
                            <label class="form-check-label" for="arterial_tidak">Tidak</label>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label>16. Proteinura (urin celup > +1 pada 2 kali pemeriksaan berjarak 6 jam atau segera kuantitatif
                        300 mg/24 jam) <span class="required">**</span></label>
                    <div class="d-flex">
                        <div class="form-check mr-3">
                            <input type="radio" class="form-check-input" name="proteinura" value="1"
                                data-score="0" id="proteinura_ya"
                                {{ old('proteinura', $preeklampsia->proteinura ?? '') == '1' ? 'checked' : '' }}>
                            <label class="form-check-label" for="proteinura_ya">Ya</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="proteinura" value="0"
                                id="proteinura_tidak"
                                {{ old('proteinura', $preeklampsia->proteinura ?? '') == '0' ? 'checked' : '' }}>
                            <label class="form-check-label" for="proteinura_tidak">Tidak</label>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-12">
                        <label for="kesimpulan" style="color: rgb(19, 11, 241);">Kesimpulan</label>
                        <textarea class="form-control" id="kesimpulan" name="kesimpulan" placeholder="Kesimpulan">{{ old('kesimpulan', $preeklampsia->kesimpulan ?? '') }}</textarea>
                    </div>
                </div>
                <div class="form-section mt-4">
                    <h3>Keterangan Sistem Skoring</h3>
                    <p>
                        <strong><span class="required">**</span>(risiko sedang)</strong>
                    </p>
                    <p>
                        <strong><span class="required">***</span>(risiko tinggi)</strong>
                    </p>

                </div>
            </div>
            <div class="text-right mt-4">
                {{-- @if (isset($preeklampsia))
                    <a href="{{ route('hipertensi.admin') }}" type="button" class="btn btn-secondary mr-2"
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
        $(document).ready(function() {

            $('.select2').select2({
                placeholder: "Pilih pasien",
                allowClear: true
            });
        });
    </script>
@endsection
