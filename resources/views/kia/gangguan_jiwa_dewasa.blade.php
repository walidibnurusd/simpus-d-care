@extends('layouts.skrining.master')
@section('title', 'Skrining Keswa SDQ (4-11 Tahun)')
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
        action="{{ isset($gangguanJiwaDewasa) ? route('srq.dewasa.update', $gangguanJiwaDewasa->id) : route('srq.dewasa.store') }}"
        method="POST">
        @csrf
        @if (isset($gangguanJiwaDewasa))
            @method('PUT')
        @endif
        @if ($routeName === 'srq.dewasa.view')
            <input type="hidden" name="klaster" value="2">
            <input type="hidden" name="poli" value="kia">
            {{-- @elseif($routeName === 'srq.mtbs.view')
            <input type="hidden" name="klaster" value="2">
            <input type="hidden" name="poli" value="mtbs">
        @elseif($routeName === 'srq.lansia.view')
            <input type="hidden" name="klaster" value="3">
            <input type="hidden" name="poli" value="lansia"> --}}
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
                        <label>Tanggal Lahir</label>
                        <input type="date" class="form-control" name="tanggal_lahir" id="tanggal_lahir" readonly
                            value="{{ $pasien->dob }}">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Alamat Lengkap</label>
                        <input type="text" class="form-control" name="alamat" placeholder="Masukkan alamat lengkap"
                            id="alamat" readonly value="{{ $pasien->address }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Jenis Kelamin</label>
                        <div class="d-flex">
                            <div class="form-check mr-3">
                                <input type="radio" class="form-check-input" name="jenis_kelamin" value="laki-laki"
                                    id="jk_laki" id="laki-laki" {{ $pasien->gender == '2' ? 'checked' : '' }}>
                                <label class="form-check-label" for="laki-laki">Laki-laki</label>
                            </div>
                            <div class="form-check">
                                <input type="radio" class="form-check-input" name="jenis_kelamin" value="perempuan"
                                    id="jk_perempuan" id="perempuan" {{ $pasien->gender == '1' ? 'checked' : '' }}>
                                <label class="form-check-label" for="perempuan">Perempuan</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>



        </div>
        <div class="form-section mt-4">

            <h3>Pertanyaan</h3>

            <div class="form-group">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>1. Apakah Anda sering merasa sakit kepala?</label>
                            <div class="d-flex">
                                <div class="form-check mr-3">
                                    <input type="radio" class="form-check-input" name="sakit_kepala" value="1"
                                        onclick="calculateTotalScore()"
                                        {{ old('sakit_kepala', isset($gangguanJiwaDewasa) && $gangguanJiwaDewasa->sakit_kepala == 1 ? 'checked' : '') }}>
                                    <label class="form-check-label">Ya</label>
                                </div>
                                <div class="form-check">
                                    <input type="radio" class="form-check-input" name="sakit_kepala" value="0"
                                        onclick="calculateTotalScore()"
                                        {{ old('sakit_kepala', isset($gangguanJiwaDewasa) && $gangguanJiwaDewasa->sakit_kepala == 0 ? 'checked' : '') }}>
                                    <label class="form-check-label">Tidak</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Pertanyaan 2 -->
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>2. Apakah Anda kehilangan nafsu makan?</label>
                            <div class="d-flex">
                                <div class="form-check mr-3">
                                    <input type="radio" class="form-check-input" name="hilang_nafsu_makan" value="1"
                                        onclick="calculateTotalScore()"
                                        {{ old('hilang_nafsu_makan', isset($gangguanJiwaDewasa) && $gangguanJiwaDewasa->hilang_nafsu_makan == 1 ? 'checked' : '') }}>
                                    <label class="form-check-label">Ya</label>
                                </div>
                                <div class="form-check">
                                    <input type="radio" class="form-check-input" name="hilang_nafsu_makan"
                                        value="0" onclick="calculateTotalScore()"
                                        {{ old('hilang_nafsu_makan', isset($gangguanJiwaDewasa) && $gangguanJiwaDewasa->sakit_kepala == 0 ? 'checked' : '') }}>
                                    <label class="form-check-label">Tidak</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Pertanyaan 3 -->
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>3. Apakah tidur Anda nyenyak?</label>
                            <div class="d-flex">
                                <div class="form-check mr-3">
                                    <input type="radio" class="form-check-input" name="tidur_nyenyak" value="1"
                                        onclick="calculateTotalScore()"
                                        {{ old('tidur_nyenyak', isset($gangguanJiwaDewasa) && $gangguanJiwaDewasa->tidur_nyenyak == 1 ? 'checked' : '') }}>
                                    <label class="form-check-label">Ya</label>
                                </div>
                                <div class="form-check">
                                    <input type="radio" class="form-check-input" name="tidur_nyenyak" value="0"
                                        onclick="calculateTotalScore()"
                                        {{ old('tidur_nyenyak', isset($gangguanJiwaDewasa) && $gangguanJiwaDewasa->tidur_nyenyak == 0 ? 'checked' : '') }}>
                                    <label class="form-check-label">Tidak</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Pertanyaan 4 -->
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>4. Apakah Anda mudah merasa takut?</label>
                            <div class="d-flex">
                                <div class="form-check mr-3">
                                    <input type="radio" class="form-check-input" name="takut" value="1"
                                        onclick="calculateTotalScore()"
                                        {{ old('takut', isset($gangguanJiwaDewasa) && $gangguanJiwaDewasa->takut == 1 ? 'checked' : '') }}>
                                    <label class="form-check-label">Ya</label>
                                </div>
                                <div class="form-check">
                                    <input type="radio" class="form-check-input" name="takut" value="0"
                                        onclick="calculateTotalScore()"
                                        {{ old('takut', isset($gangguanJiwaDewasa) && $gangguanJiwaDewasa->takut == 0 ? 'checked' : '') }}>
                                    <label class="form-check-label">Tidak</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Pertanyaan 5 -->
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>5. Apakah Anda merasa cemas,tegang atau khawatir?</label>
                            <div class="d-flex">
                                <div class="form-check mr-3">
                                    <input type="radio" class="form-check-input" name="cemas" value="1"
                                        onclick="calculateTotalScore()"
                                        {{ old('cemas', isset($gangguanJiwaDewasa) && $gangguanJiwaDewasa->cemas == 1 ? 'checked' : '') }}>
                                    <label class="form-check-label">Ya</label>
                                </div>
                                <div class="form-check">
                                    <input type="radio" class="form-check-input" name="cemas" value="0"
                                        onclick="calculateTotalScore()"
                                        {{ old('cemas', isset($gangguanJiwaDewasa) && $gangguanJiwaDewasa->cemas == 0 ? 'checked' : '') }}>
                                    <label class="form-check-label">Tidak</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>6. Apakah tangan Anda gemetar?</label>
                            <div class="d-flex">
                                <div class="form-check mr-3">
                                    <input type="radio" class="form-check-input" name="tangan_gemetar" value="1"
                                        onclick="calculateTotalScore()"
                                        {{ old('tangan_gemetar', isset($gangguanJiwaDewasa) && $gangguanJiwaDewasa->tangan_gemetar == 1 ? 'checked' : '') }}>
                                    <label class="form-check-label">Ya</label>
                                </div>
                                <div class="form-check">
                                    <input type="radio" class="form-check-input" name="tangan_gemetar" value="0"
                                        onclick="calculateTotalScore()"
                                        {{ old('tangan_gemetar', isset($gangguanJiwaDewasa) && $gangguanJiwaDewasa->tangan_gemetar == 0 ? 'checked' : '') }}>
                                    <label class="form-check-label">Tidak</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label>7. Apakah Anda mengalami gangguan pencernaan?</label>
                            <div class="d-flex">
                                <div class="form-check mr-3">
                                    <input type="radio" class="form-check-input" name="gangguan_percernaan"
                                        value="1" onclick="calculateTotalScore()"
                                        {{ old('gangguan_percernaan', isset($gangguanJiwaDewasa) && $gangguanJiwaDewasa->gangguan_percernaan == 1 ? 'checked' : '') }}>
                                    <label class="form-check-label">Ya</label>
                                </div>
                                <div class="form-check">
                                    <input type="radio" class="form-check-input" name="gangguan_percernaan"
                                        value="0" onclick="calculateTotalScore()"
                                        {{ old('gangguan_percernaan', isset($gangguanJiwaDewasa) && $gangguanJiwaDewasa->gangguan_percernaan == 0 ? 'checked' : '') }}>
                                    <label class="form-check-label">Tidak</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label>8. Apakah Anda merasa sulit berpikir jernih?</label>
                            <div class="d-flex">
                                <div class="form-check mr-3">
                                    <input type="radio" class="form-check-input" name="sulit_berpikir_jernih"
                                        value="1" onclick="calculateTotalScore()"
                                        {{ old('sulit_berpikir_jernih', isset($gangguanJiwaDewasa) && $gangguanJiwaDewasa->sulit_berpikir_jernih == 1 ? 'checked' : '') }}>
                                    <label class="form-check-label">Ya</label>
                                </div>
                                <div class="form-check">
                                    <input type="radio" class="form-check-input" name="sulit_berpikir_jernih"
                                        value="0" onclick="calculateTotalScore()"
                                        {{ old('sulit_berpikir_jernih', isset($gangguanJiwaDewasa) && $gangguanJiwaDewasa->sulit_berpikir_jernih == 0 ? 'checked' : '') }}>
                                    <label class="form-check-label">Tidak</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label>9. Apakah Anda merasa tidak bahagia?</label>
                            <div class="d-flex">
                                <div class="form-check mr-3">
                                    <input type="radio" class="form-check-input" name="tdk_bahagia" value="1"
                                        onclick="calculateTotalScore()"
                                        {{ old('tdk_bahagia', isset($gangguanJiwaDewasa) && $gangguanJiwaDewasa->tdk_bahagia == 1 ? 'checked' : '') }}>
                                    <label class="form-check-label">Ya</label>
                                </div>
                                <div class="form-check">
                                    <input type="radio" class="form-check-input" name="tdk_bahagia" value="0"
                                        onclick="calculateTotalScore()"
                                        {{ old('tdk_bahagia', isset($gangguanJiwaDewasa) && $gangguanJiwaDewasa->tdk_bahagia == 0 ? 'checked' : '') }}>
                                    <label class="form-check-label">Tidak</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label>10. Apakah Anda lebih sering menangis?</label>
                            <div class="d-flex">
                                <div class="form-check mr-3">
                                    <input type="radio" class="form-check-input" name="sering_menangis" value="1"
                                        onclick="calculateTotalScore()"
                                        {{ old('sering_menangis', isset($gangguanJiwaDewasa) && $gangguanJiwaDewasa->sering_menangis == 1 ? 'checked' : '') }}>
                                    <label class="form-check-label">Ya</label>
                                </div>
                                <div class="form-check">
                                    <input type="radio" class="form-check-input" name="sering_menangis" value="0"
                                        onclick="calculateTotalScore()"
                                        {{ old('sering_menangis', isset($gangguanJiwaDewasa) && $gangguanJiwaDewasa->sering_menangis == 0 ? 'checked' : '') }}>
                                    <label class="form-check-label">Tidak</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>11. Apakah Anda merasa sulit untuk menikmati aktivitas sehari-hari?</label>
                            <div class="d-flex">
                                <div class="form-check mr-3">
                                    <input type="radio" class="form-check-input" name="sulit_aktivitas" value="1"
                                        onclick="calculateTotalScore()"
                                        {{ old('sulit_aktivitas', isset($gangguanJiwaDewasa) && $gangguanJiwaDewasa->sulit_aktivitas == 1 ? 'checked' : '') }}>
                                    <label class="form-check-label">Ya</label>
                                </div>
                                <div class="form-check">
                                    <input type="radio" class="form-check-input" name="sulit_aktivitas" value="0"
                                        onclick="calculateTotalScore()"
                                        {{ old('sulit_aktivitas', isset($gangguanJiwaDewasa) && $gangguanJiwaDewasa->sulit_aktivitas == 0 ? 'checked' : '') }}>
                                    <label class="form-check-label">Tidak</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label>12. Apakah Anda mengalami kesulitan untuk mengambil keputusan?</label>
                            <div class="d-flex">
                                <div class="form-check mr-3">
                                    <input type="radio" class="form-check-input" name="sulit_ambil_keputusan"
                                        value="1" onclick="calculateTotalScore()"
                                        {{ old('sulit_ambil_keputusan', isset($gangguanJiwaDewasa) && $gangguanJiwaDewasa->sulit_ambil_keputusan == 1 ? 'checked' : '') }}>
                                    <label class="form-check-label">Ya</label>
                                </div>
                                <div class="form-check">
                                    <input type="radio" class="form-check-input" name="sulit_ambil_keputusan"
                                        value="0" onclick="calculateTotalScore()"
                                        {{ old('sulit_ambil_keputusan', isset($gangguanJiwaDewasa) && $gangguanJiwaDewasa->sulit_ambil_keputusan == 0 ? 'checked' : '') }}>
                                    <label class="form-check-label">Tidak</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label>13. Apakah aktivitas/tugas sehari-hari Anda terbengkalai?</label>
                            <div class="d-flex">
                                <div class="form-check mr-3">
                                    <input type="radio" class="form-check-input" name="tugas_terbengkalai"
                                        value="1" onclick="calculateTotalScore()"
                                        {{ old('tugas_terbengkalai', isset($gangguanJiwaDewasa) && $gangguanJiwaDewasa->tugas_terbengkalai == 1 ? 'checked' : '') }}>
                                    <label class="form-check-label">Ya</label>
                                </div>
                                <div class="form-check">
                                    <input type="radio" class="form-check-input" name="tugas_terbengkalai"
                                        value="0" onclick="calculateTotalScore()"
                                        {{ old('tugas_terbengkalai', isset($gangguanJiwaDewasa) && $gangguanJiwaDewasa->tugas_terbengkalai == 0 ? 'checked' : '') }}>
                                    <label class="form-check-label">Tidak</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label>14. Apakah Anda merasa tidak mampu berperan dalam kehidupan ini?</label>
                            <div class="d-flex">
                                <div class="form-check mr-3">
                                    <input type="radio" class="form-check-input" name="tdk_berperan" value="1"
                                        onclick="calculateTotalScore()"
                                        {{ old('tdk_berperan', isset($gangguanJiwaDewasa) && $gangguanJiwaDewasa->tdk_berperan == 1 ? 'checked' : '') }}>
                                    <label class="form-check-label">Ya</label>
                                </div>
                                <div class="form-check">
                                    <input type="radio" class="form-check-input" name="tdk_berperan" value="0"
                                        onclick="calculateTotalScore()"
                                        {{ old('tdk_berperan', isset($gangguanJiwaDewasa) && $gangguanJiwaDewasa->tdk_berperan == 0 ? 'checked' : '') }}>
                                    <label class="form-check-label">Tidak</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label>15. Apakah Anda kehilangan minat terhadap banyak hal?</label>
                            <div class="d-flex">
                                <div class="form-check mr-3">
                                    <input type="radio" class="form-check-input" name="hilang_minat" value="1"
                                        onclick="calculateTotalScore()"
                                        {{ old('hilang_minat', isset($gangguanJiwaDewasa) && $gangguanJiwaDewasa->hilang_minat == 1 ? 'checked' : '') }}>
                                    <label class="form-check-label">Ya</label>
                                </div>
                                <div class="form-check">
                                    <input type="radio" class="form-check-input" name="hilang_minat" value="0"
                                        onclick="calculateTotalScore()"
                                        {{ old('hilang_minat', isset($gangguanJiwaDewasa) && $gangguanJiwaDewasa->hilang_minat == 0 ? 'checked' : '') }}>
                                    <label class="form-check-label">Tidak</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label>16. Apakah Anda merasa tidak berharga?</label>
                            <div class="d-flex">
                                <div class="form-check mr-3">
                                    <input type="radio" class="form-check-input" name="tdk_berharga" value="1"
                                        onclick="calculateTotalScore()"
                                        {{ old('tdk_berharga', isset($gangguanJiwaDewasa) && $gangguanJiwaDewasa->tdk_berharga == 1 ? 'checked' : '') }}>
                                    <label class="form-check-label">Ya</label>
                                </div>
                                <div class="form-check">
                                    <input type="radio" class="form-check-input" name="tdk_berharga" value="0"
                                        onclick="calculateTotalScore()"
                                        {{ old('tdk_berharga', isset($gangguanJiwaDewasa) && $gangguanJiwaDewasa->tdk_berharga == 0 ? 'checked' : '') }}>
                                    <label class="form-check-label">Tidak</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label>17. Apakah Anda mempunyai pikiran untuk mengakhiri hidup Anda?</label>
                            <div class="d-flex">
                                <div class="form-check mr-3">
                                    <input type="radio" class="form-check-input" name="pikiran_mati" value="1"
                                        onclick="calculateTotalScore()"
                                        {{ old('pikiran_mati', isset($gangguanJiwaDewasa) && $gangguanJiwaDewasa->pikiran_mati == 1 ? 'checked' : '') }}>
                                    <label class="form-check-label">Ya</label>
                                </div>
                                <div class="form-check">
                                    <input type="radio" class="form-check-input" name="pikiran_mati" value="0"
                                        onclick="calculateTotalScore()"
                                        {{ old('pikiran_mati', isset($gangguanJiwaDewasa) && $gangguanJiwaDewasa->pikiran_mati == 0 ? 'checked' : '') }}>
                                    <label class="form-check-label">Tidak</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label>18. Apakah Anda merasa lelah sepanjang waktu?</label>
                            <div class="d-flex">
                                <div class="form-check mr-3">
                                    <input type="radio" class="form-check-input" name="lelah_selalu" value="1"
                                        onclick="calculateTotalScore()"
                                        {{ old('lelah_selalu', isset($gangguanJiwaDewasa) && $gangguanJiwaDewasa->lelah_selalu == 1 ? 'checked' : '') }}>
                                    <label class="form-check-label">Ya</label>
                                </div>
                                <div class="form-check">
                                    <input type="radio" class="form-check-input" name="lelah_selalu" value="0"
                                        onclick="calculateTotalScore()"
                                        {{ old('lelah_selalu', isset($gangguanJiwaDewasa) && $gangguanJiwaDewasa->lelah_selalu == 0 ? 'checked' : '') }}>
                                    <label class="form-check-label">Tidak</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label>19. Apakah Anda merasa tidak enak di perut?</label>
                            <div class="d-flex">
                                <div class="form-check mr-3">
                                    <input type="radio" class="form-check-input" name="sakit_perut" value="1"
                                        onclick="calculateTotalScore()"
                                        {{ old('sakit_perut', isset($gangguanJiwaDewasa) && $gangguanJiwaDewasa->sakit_perut == 1 ? 'checked' : '') }}>
                                    <label class="form-check-label">Ya</label>
                                </div>
                                <div class="form-check">
                                    <input type="radio" class="form-check-input" name="sakit_perut" value="0"
                                        onclick="calculateTotalScore()"
                                        {{ old('sakit_perut', isset($gangguanJiwaDewasa) && $gangguanJiwaDewasa->sakit_perut == 0 ? 'checked' : '') }}>
                                    <label class="form-check-label">Tidak</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label>20. Apakah Anda mudah lelah?</label>
                            <div class="d-flex">
                                <div class="form-check mr-3">
                                    <input type="radio" class="form-check-input" name="mudah_lelah" value="1"
                                        onclick="calculateTotalScore()"
                                        {{ old('mudah_lelah', isset($gangguanJiwaDewasa) && $gangguanJiwaDewasa->mudah_lelah == 1 ? 'checked' : '') }}>
                                    <label class="form-check-label">Ya</label>
                                </div>
                                <div class="form-check">
                                    <input type="radio" class="form-check-input" name="mudah_lelah" value="0"
                                        onclick="calculateTotalScore()"
                                        {{ old('mudah_lelah', isset($gangguanJiwaDewasa) && $gangguanJiwaDewasa->mudah_lelah == 0 ? 'checked' : '') }}>
                                    <label class="form-check-label">Tidak</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group mt-4">

            <label for="kesimpulan" style="color: rgb(19, 11, 241);">Kesimpulan</label>
            <textarea class="form-control" id="kesimpulan" name="kesimpulan" placeholder="Kesimpulan">{{ old('kesimpulan', $gangguanJiwaDewasa->kesimpulan ?? '') }}</textarea>
            <br>
            <label>Skor Total</label>
            <div class="d-flex">
                <input type="text" class="form-control" id="totalScore" value="0"
                    onclick="calculateTotalScore()" disabled>
            </div>
        </div>
        <div class="form-section mt-4">
            <h3>Interpretasi Hasil Kuesioner SRQ-20 dan Intervensi</h3>

            <div class="form-group">
                <p><strong>Skor:</strong></p>

                <p><strong>&lt; 6</strong><br>
                    <strong>Interpretasi:</strong> Normal<br>
                    <strong>Intervensi:</strong><br>
                    Edukasi untuk memelihara dan meningkatkan kesehatan jiwa dengan cara Komunikasi Antar Pribadi (KAP).
                    Materi edukasi kesehatan jiwa yang diberikan merujuk pada juknis GME dan Depresi atau Pedoman Skrining
                    Kesehatan Jiwa.
                </p>

                <p><strong>&ge; 6</strong><br>
                    <strong>Interpretasi:</strong> Abnormal (Berpotensi mengalami masalah kesehatan jiwa)<br>
                    <strong>Intervensi:</strong><br>
                    KAP kesehatan jiwa, pencegahan gangguan jiwa, dan/atau dirujuk ke Puskesmas untuk pemeriksaan lanjutan
                    dalam bentuk wawancara psikiatrik oleh dokter/psikolog klinis untuk menentukan diagnosis gangguan jiwa.
                    Rujukan ke RS/RSJ jika diperlukan.
                </p>

                <p><strong>Kategori Gejala Berdasarkan Jawaban "Ya":</strong></p>
                <ul>
                    <li><strong>Gejala Depresi:</strong> Nomor 6, 9, 10, 14, 15, 16, dan 17.</li>
                    <li><strong>Gejala Cemas:</strong> Nomor 3, 4, dan 5.</li>
                    <li><strong>Gejala Somatik:</strong> Nomor 1, 2, 7, dan 19.</li>
                    <li><strong>Gejala Kognitif:</strong> Nomor 8, 12, dan 13.</li>
                    <li><strong>Gejala Penurunan Energi:</strong> Nomor 8, 11, 12, 13, 18, dan 20.</li>
                </ul>
            </div>
        </div>

        <div class="text-right mt-4">
            <button type="submit" class="btn btn-primary" style="font-size: 20px">Kirim</button>
        </div>


    </form>
    <script>
        function calculateTotalScore() {
            let totalScore = 0;

            document.querySelectorAll('.form-check-input:checked').forEach((input) => {
                let value = parseInt(input.value);
                if (!isNaN(value)) {
                    totalScore += value;
                }
            });

            document.getElementById('totalScore').value = totalScore;
        }
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
