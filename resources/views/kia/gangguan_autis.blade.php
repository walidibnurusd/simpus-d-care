@extends('layouts.skrining.master')
@section('title', 'Skrining Gangguan Spektrum Autisme (M-CHAT-R)')
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

    <form
        action="{{ isset($gangguanAutis) ? route('gangguan.autis.update', $gangguanAutis->id) : route('gangguan.autis.store') }}"
        method="POST">
        @csrf
        @if (isset($gangguanAutis))
            @method('PUT')
        @endif
        <div class="form-section">
            <h3>Identitas Anak</h3>
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
                                    {{ old('pasien', $gangguanAutis->pasien ?? '') == $item->id ? 'selected' : '' }}>
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
                        <label>Tanggal Lahir Anak</label>
                        <input type="date" class="form-control" name="tanggal_lahir" id="tanggal_lahir"
                            value="{{ old('tanggal_lahir', isset($gangguanAutis) ? $gangguanAutis->tanggal_lahir : '') }}">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Alamat Lengkap</label>
                        <input type="text" class="form-control" name="alamat" placeholder="Masukkan alamat lengkap"
                            id="alamat"
                            value="{{ old('alamat', isset($gangguanAutis) ? $gangguanAutis->alamat : '') }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Jenis Kelamin</label>
                        <div class="d-flex">
                            <div class="form-check mr-3">
                                <input type="radio" class="form-check-input" name="jenis_kelamin_kecacingan"
                                    value="laki-laki" id="jk_laki"
                                    {{ old('jenis_kelamin', $gangguanAutis->jenis_kelamin ?? '') == 'laki-laki' ? 'checked' : '' }}>
                                <label class="form-check-label" for="laki-laki">Laki-laki</label>
                            </div>
                            <div class="form-check">
                                <input type="radio" class="form-check-input" name="jenis_kelamin" value="perempuan"
                                    id="jk_perempuan"
                                    {{ old('jenis_kelamin', $gangguanAutis->jenis_kelamin ?? '') == 'perempuan' ? 'checked' : '' }}>
                                <label class="form-check-label" for="perempuan">Perempuan</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Scoring Algorithm Section -->
        <div class="scoring-section mt-5">
            <h3>Algoritme Skoring M-CHAT-R</h3>
            <p>Penjelasan mengenai bagaimana menginterpretasikan skor untuk skrining gangguan spektrum autisme (ASD):</p>
            <ul>
                <li>Untuk semua pertanyaan <strong>kecuali 2, 5, dan 12</strong>, respon “<strong>TIDAK</strong>”
                    mengindikasikan risiko ASD.</li>
                <li>Untuk pertanyaan <strong>2, 5, dan 12</strong>, respon “<strong>YA</strong>” mengindikasikan risiko ASD.
                </li>
            </ul>

            <h4>Kategori Risiko Berdasarkan Skor</h4>
            <ul>
                <li><strong>Risiko Rendah:</strong> Skor total 0-2; jika anak berusia kurang dari 24 bulan, lakukan skrining
                    lagi setelah ulang tahun kedua. Tidak diperlukan tindakan lanjut kecuali surveilans yang mengindikasikan
                    risiko ASD.</li>
                <li><strong>Risiko Medium:</strong> Skor total 3-7; lakukan Follow-up (M-CHAT-R/F tahap kedua) untuk
                    informasi tambahan mengenai respon berisiko.
                    <ul>
                        <li>Skrining positif jika skor M-CHAT-R/F adalah 2 atau lebih. Tindakan yang diperlukan adalah
                            merujuk anak untuk evaluasi diagnostik dan eligibilitas untuk intervensi awal.</li>
                        <li>Skrining negatif jika skor M-CHAT-R/F adalah 0-1. Tidak ada tindakan lanjutan yang diperlukan
                            kecuali surveilans. Skrining ulang disarankan saat anak datang kembali.</li>
                    </ul>
                </li>
                <li><strong>Risiko Tinggi:</strong> Skor total 8-20; tidak perlu Follow-up, dan anak harus segera dirujuk
                    untuk evaluasi diagnostik dan evaluasi eligibilitas untuk intervensi awal.</li>
            </ul>
        </div>
        <div class="form-section mt-4">
            <h3>M-CHAR-T</h3>
            <p>Mohon jawab pertanyaan berikut ini tentang anak anda. Pikirkan bagaimana perilaku anak anda biasanya. Jika
                pernah melihat anak anda melakukan tindakan itu beberapa kali, namun dia tidak selalu melakukannya, maka
                jawab tidak. Tolong lingkari ya atau tidak pada setiap pertanyaan. Terima Kasih.</p>


            <!-- Sample Questions from M-CHAT-R -->
            <div class="form-group">
                <label>1. Jika anda menunjuk sesuatu di ruangan, apakah anak anda melihatnya? (Misalnya, jika anda menunjuk
                    hewan atau mainan, apakah anak anda melihat ke arah yang anda tunjuk?)</label>
                <div class="d-flex">
                    <div class="form-check mr-3">
                        <input type="radio" class="form-check-input" name="lihat_objek" value="1"
                            onchange="updateScore()" id="ya1"
                            {{ old('lihat_objek', $gangguanAutis->lihat_objek ?? '') == 1 ? 'checked' : '' }}>
                        <label class="form-check-label" for="ya1">Ya</label>
                    </div>
                    <div class="form-check">
                        <input type="radio" class="form-check-input" name="lihat_objek" value="0" id="tidak1"
                            {{ old('lihat_objek', $gangguanAutis->lihat_objek ?? '') == 0 ? 'checked' : '' }}>
                        <label class="form-check-label" for="tidak1">Tidak</label>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label>2. Pernahkah anda berpikir bahwa anak anda tuli?</label>
                <div class="d-flex">
                    <div class="form-check mr-3">
                        <input type="radio" class="form-check-input" name="tuli" value="1"
                            onchange="updateScore()" id="ya2"
                            {{ isset($gangguanAutis->tuli) && $gangguanAutis->tuli == 1 ? 'checked' : '' }}>
                        <label class="form-check-label" for="ya2">Ya</label>
                    </div>
                    <div class="form-check">
                        <input type="radio" class="form-check-input" name="tuli" value="0" id="tidak2"
                            {{ isset($gangguanAutis->tuli) && $gangguanAutis->tuli == 0 ? 'checked' : '' }}>
                        <label class="form-check-label" for="tidak2">Tidak</label>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label>3. Apakah anak anda pernah bermain pura-pura? (Misalnya, berpura-pura minum dari
                    gelas kosong, berpura-pura berbicara menggunakan telepon, atau menyuapi boneka
                    atau boneka binatang?)</label>
                <div class="d-flex">
                    <div class="form-check mr-3">
                        <input type="radio" class="form-check-input" name="main_pura_pura" value="1"
                            onchange="updateScore()" id="ya3"
                            {{ isset($gangguanAutis->main_pura_pura) && $gangguanAutis->main_pura_pura == 1 ? 'checked' : '' }}>
                        <label class="form-check-label" for="ya3">Ya</label>
                    </div>
                    <div class="form-check">
                        <input type="radio" class="form-check-input" name="main_pura_pura" value="0"
                            id="tidak3"
                            {{ isset($gangguanAutis->main_pura_pura) && $gangguanAutis->main_pura_pura == 0 ? 'checked' : '' }}>
                        <label class="form-check-label" for="tidak3">Tidak</label>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label>4. Apakah anak anda suka memanjat benda-benda? (Misalnya, furniture, alat-alat
                    bermain, atau tangga)</label>
                <div class="d-flex">
                    <div class="form-check mr-3">
                        <input type="radio" class="form-check-input" name="suka_manjat" value="1"
                            onchange="updateScore()" id="ya4"
                            {{ isset($gangguanAutis->suka_manjat) && $gangguanAutis->suka_manjat == 1 ? 'checked' : '' }}>
                        <label class="form-check-label" for="ya4">Ya</label>
                    </div>
                    <div class="form-check">
                        <input type="radio" class="form-check-input" name="suka_manjat" value="0" id="tidak4"
                            {{ isset($gangguanAutis->suka_manjat) && $gangguanAutis->suka_manjat == 0 ? 'checked' : '' }}>
                        <label class="form-check-label" for="tidak4">Tidak</label>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label>5. Apakah anak anda menggerakkan jari-jari tangannya dengan cara
                    yang tidak biasa di dekat matanya? (Misalnya, apakah anak anda menggoyangkan jari
                    dekat pada matanya?)</label>
                <div class="d-flex">
                    <div class="form-check mr-3">
                        <input type="radio" class="form-check-input" name="gerakan_jari" value="1"
                            onchange="updateScore()" id="ya5"
                            {{ isset($gangguanAutis->gerakan_jari) && $gangguanAutis->gerakan_jari == 1 ? 'checked' : '' }}>
                        <label class="form-check-label" for="ya5">Ya</label>
                    </div>
                    <div class="form-check">
                        <input type="radio" class="form-check-input" name="gerakan_jari" value="0"
                            id="tidak5"
                            {{ isset($gangguanAutis->gerakan_jari) && $gangguanAutis->gerakan_jari == 0 ? 'checked' : '' }}>
                        <label class="form-check-label" for="tidak5">Tidak</label>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label>6. Apakah anak anda pernah menunjuk dengan satu jari untuk meminta sesuatu atau
                    untuk meminta tolong? (Misalnya, menunjuk makanan atau mainan yang jauh dari
                    jangkauannya)</label>
                <div class="d-flex">
                    <div class="form-check mr-3">
                        <input type="radio" class="form-check-input" name="tunjuk_minta" value="1"
                            onchange="updateScore()" id="ya6"
                            {{ isset($gangguanAutis->tunjuk_minta) && $gangguanAutis->tunjuk_minta == 1 ? 'checked' : '' }}>
                        <label class="form-check-label" for="ya6">Ya</label>
                    </div>
                    <div class="form-check">
                        <input type="radio" class="form-check-input" name="tunjuk_minta" value="0"
                            id="tidak6"
                            {{ isset($gangguanAutis->tunjuk_minta) && $gangguanAutis->tunjuk_minta == 0 ? 'checked' : '' }}>
                        <label class="form-check-label" for="tidak6">Tidak</label>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label>7. Apakah anak anda pernah menunjuk dengan satu jari untuk menunjukkan sesuatu yang
                    menarik pada anda? (Misalnya, menunjuk pada pesawat di langit atau truk besar di
                    jalan)</label>
                <div class="d-flex">
                    <div class="form-check mr-3">
                        <input type="radio" class="form-check-input" name="tunjuk_menarik" value="1"
                            onchange="updateScore()" id="ya7"
                            {{ isset($gangguanAutis->tunjuk_menarik) && $gangguanAutis->tunjuk_menarik == 1 ? 'checked' : '' }}>
                        <label class="form-check-label" for="ya7">Ya</label>
                    </div>
                    <div class="form-check">
                        <input type="radio" class="form-check-input" name="tunjuk_menarik" value="0"
                            id="tidak7"
                            {{ isset($gangguanAutis->tunjuk_menarik) && $gangguanAutis->tunjuk_menarik == 0 ? 'checked' : '' }}>
                        <label class="form-check-label" for="tidak7">Tidak</label>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label>8. Apakah anak anda tertarik pada anak lain? (Misalnya, apakah anak anda
                    memperhatikan anak lain, tersenyum pada mereka atau pergi ke arah mereka)</label>
                <div class="d-flex">
                    <div class="form-check mr-3">
                        <input type="radio" class="form-check-input" name="tertarik_anak_lain" value="1"
                            onchange="updateScore()" id="ya8"
                            {{ isset($gangguanAutis->tertarik_anak_lain) && $gangguanAutis->tertarik_anak_lain == 1 ? 'checked' : '' }}>
                        <label class="form-check-label" for="ya8">Ya</label>
                    </div>
                    <div class="form-check">
                        <input type="radio" class="form-check-input" name="tertarik_anak_lain" value="0"
                            id="tidak8"
                            {{ isset($gangguanAutis->tertarik_anak_lain) && $gangguanAutis->tertarik_anak_lain == 0 ? 'checked' : '' }}>
                        <label class="form-check-label" for="tidak8">Tidak</label>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label>9. Apakah anak anda pernah memperlihatkan suatu benda dengan membawa atau
                    mengangkatnya kepada anda – tidak untuk minta tolong, hanya untuk berbagi?
                    (Misalnya, memperlihatkan anda bunga, binatang atau truk mainan)</label>
                <div class="d-flex">
                    <div class="form-check mr-3">
                        <input type="radio" class="form-check-input" name="membawa_benda" value="1"
                            onchange="updateScore()" id="ya9"
                            {{ isset($gangguanAutis->membawa_benda) && $gangguanAutis->membawa_benda == 1 ? 'checked' : '' }}>
                        <label class="form-check-label" for="ya9">Ya</label>
                    </div>
                    <div class="form-check">
                        <input type="radio" class="form-check-input" name="membawa_benda" value="0"
                            id="tidak9"
                            {{ isset($gangguanAutis->membawa_benda) && $gangguanAutis->membawa_benda == 0 ? 'checked' : '' }}>
                        <label class="form-check-label" for="tidak9">Tidak</label>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label>10. Apakah anak anda memberikan respon jika namanya dipanggil? (Misalnya, apakah
                    anak anda melihat, bicara atau bergumam, atau menghentikan apa yang sedang
                    dilakukannya saat anda memanggil namanya)</label>
                <div class="d-flex">
                    <div class="form-check mr-3">
                        <input type="radio" class="form-check-input" name="respon_nama_dipanggil" value="1"
                            onchange="updateScore()" id="ya10"
                            {{ isset($gangguanAutis->respon_nama_dipanggil) && $gangguanAutis->respon_nama_dipanggil == 1 ? 'checked' : '' }}>
                        <label class="form-check-label" for="ya10">Ya</label>
                    </div>
                    <div class="form-check">
                        <input type="radio" class="form-check-input" name="respon_nama_dipanggil" value="0"
                            id="tidak10"
                            {{ isset($gangguanAutis->respon_nama_dipanggil) && $gangguanAutis->respon_nama_dipanggil == 0 ? 'checked' : '' }}>
                        <label class="form-check-label" for="tidak10">Tidak</label>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label>11. Saat anda tersenyum pada anak anda, apakah anak anda tersenyum balik?</label>
                <div class="d-flex">
                    <div class="form-check mr-3">
                        <input type="radio" class="form-check-input" name="respon_senyum" value="1"
                            onchange="updateScore()" id="ya11"
                            {{ isset($gangguanAutis->respon_senyum) && $gangguanAutis->respon_senyum == 1 ? 'checked' : '' }}>
                        <label class="form-check-label" for="ya11">Ya</label>
                    </div>
                    <div class="form-check">
                        <input type="radio" class="form-check-input" name="respon_senyum" value="0"
                            id="tidak11"
                            {{ isset($gangguanAutis->respon_senyum) && $gangguanAutis->respon_senyum == 0 ? 'checked' : '' }}>
                        <label class="form-check-label" for="tidak11">Tidak</label>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label>12. Apakah anak anda pernah marah saat mendengar suara bising sehari-hari? (Misalnya,
                apakah anak anda berteriak atau menangis saat mendengar suara bising seperti vacuum
                cleaner atau musik keras)</label>
            <div class="d-flex">
                <div class="form-check mr-3">
                    <input type="radio" class="form-check-input" name="pernah_marah" value="1"
                        onchange="updateScore()" id="ya12"
                        {{ isset($gangguanAutis->pernah_marah) && $gangguanAutis->pernah_marah == 1 ? 'checked' : '' }}>
                    <label class="form-check-label" for="ya12">Ya</label>
                </div>
                <div class="form-check">
                    <input type="radio" class="form-check-input" name="pernah_marah" value="0" id="tidak12"
                        {{ isset($gangguanAutis->pernah_marah) && $gangguanAutis->pernah_marah == 0 ? 'checked' : '' }}>
                    <label class="form-check-label" for="tidak12">Tidak</label>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label>13. Apakah anak anda bisa berjalan?</label>
            <div class="d-flex">
                <div class="form-check mr-3">
                    <input type="radio" class="form-check-input" name="bisa_jalan" value="1"
                        onchange="updateScore()" id="ya13"
                        {{ isset($gangguanAutis->bisa_jalan) && $gangguanAutis->bisa_jalan == 1 ? 'checked' : '' }}>
                    <label class="form-check-label" for="ya13">Ya</label>
                </div>
                <div class="form-check">
                    <input type="radio" class="form-check-input" name="bisa_jalan" value="0" id="tidak13"
                        {{ isset($gangguanAutis->bisa_jalan) && $gangguanAutis->bisa_jalan == 0 ? 'checked' : '' }}>
                    <label class="form-check-label" for="tidak13">Tidak</label>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label>14. Apakah anak anda menatap mata anda saat anda bicara padanya, bermain bersamanya,
                atau saat memakaikan pakaian?</label>
            <div class="d-flex">
                <div class="form-check mr-3">
                    <input type="radio" class="form-check-input" name="menatap_mata" value="1"
                        onchange="updateScore()" id="ya14"
                        {{ isset($gangguanAutis->menatap_mata) && $gangguanAutis->menatap_mata == 1 ? 'checked' : '' }}>
                    <label class="form-check-label" for="ya14">Ya</label>
                </div>
                <div class="form-check">
                    <input type="radio" class="form-check-input" name="menatap_mata" value="0" id="tidak14"
                        {{ isset($gangguanAutis->menatap_mata) && $gangguanAutis->menatap_mata == 0 ? 'checked' : '' }}>
                    <label class="form-check-label" for="tidak14">Tidak</label>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label>15. Apakah anak anda mencoba meniru apa yang anda lakukan? (Misalnya, melambaikan
                tangan, tepuk tangan atau meniru saat anda membuat suara lucu)</label>
            <div class="d-flex">
                <div class="form-check mr-3">
                    <input type="radio" class="form-check-input" name="meniru" value="1"
                        onchange="updateScore()" id="ya15"
                        {{ isset($gangguanAutis->meniru) && $gangguanAutis->meniru == 1 ? 'checked' : '' }}>
                    <label class="form-check-label" for="ya15">Ya</label>
                </div>
                <div class="form-check">
                    <input type="radio" class="form-check-input" name="meniru" value="0" id="tidak15"
                        {{ isset($gangguanAutis->meniru) && $gangguanAutis->meniru == 0 ? 'checked' : '' }}>
                    <label class="form-check-label" for="tidak15">Tidak</label>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label>16. Jika anda memutar kepala untuk melihat sesuatu, apakah anak anda melihat sekeliling
                untuk melihat apa yang anda lihat?</label>
            <div class="d-flex">
                <div class="form-check mr-3">
                    <input type="radio" class="form-check-input" name="memutar_kepala" value="1"
                        onchange="updateScore()" id="ya16"
                        {{ isset($gangguanAutis->memutar_kepala) && $gangguanAutis->memutar_kepala == 1 ? 'checked' : '' }}>
                    <label class="form-check-label" for="ya16">Ya</label>
                </div>
                <div class="form-check">
                    <input type="radio" class="form-check-input" name="memutar_kepala" value="0" id="tidak16"
                        {{ isset($gangguanAutis->memutar_kepala) && $gangguanAutis->memutar_kepala == 0 ? 'checked' : '' }}>
                    <label class="form-check-label" for="tidak16">Tidak</label>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label>17. Apakah anak anda mencoba utuk membuat anda melihat kepadanya? (Misalnya,
                apakah anak anda melihat anda untuk dipuji atau berkata “lihat” atau “lihat aku”)</label>
            <div class="d-flex">
                <div class="form-check mr-3">
                    <input type="radio" class="form-check-input" name="melihat" value="1"
                        onchange="updateScore()" id="ya17"
                        {{ isset($gangguanAutis->melihat) && $gangguanAutis->melihat == 1 ? 'checked' : '' }}>
                    <label class="form-check-label" for="ya17">Ya</label>
                </div>
                <div class="form-check">
                    <input type="radio" class="form-check-input" name="melihat" value="0" id="tidak17"
                        {{ isset($gangguanAutis->melihat) && $gangguanAutis->melihat == 0 ? 'checked' : '' }}>
                    <label class="form-check-label" for="tidak17">Tidak</label>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label>18. Apakah anak anda mengerti saat anda memintanya melakukan sesuatu? (Misalnya,
                jika anda tidak menunjuk, apakah anak anda mengerti kalimat “letakkan buku itu di
                atas kursi” atau “ambilkan saya selimut”)</label>
            <div class="d-flex">
                <div class="form-check mr-3">
                    <input type="radio" class="form-check-input" name="mengerti" value="1"
                        onchange="updateScore()" id="ya18"
                        {{ isset($gangguanAutis->mengerti) && $gangguanAutis->mengerti == 1 ? 'checked' : '' }}>
                    <label class="form-check-label" for="ya18">Ya</label>
                </div>
                <div class="form-check">
                    <input type="radio" class="form-check-input" name="mengerti" value="0" id="tidak18"
                        {{ isset($gangguanAutis->mengerti) && $gangguanAutis->mengerti == 0 ? 'checked' : '' }}>
                    <label class="form-check-label" for="tidak18">Tidak</label>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label>19. Jika sesuatu yang baru terjadi, apakah anak anda menatap wajah anda untuk melihat
                perasaan anda tentang hal tersebut? (Misalnya, jika anak anda mendengar bunyi aneh
                atau lucu, atau melihat mainan baru, akankah dia menatap wajah anda?)</label>
            <div class="d-flex">
                <div class="form-check mr-3">
                    <input type="radio" class="form-check-input" name="menatap_wajah" value="1"
                        onchange="updateScore()" id="ya19"
                        {{ isset($gangguanAutis->menatap_wajah) && $gangguanAutis->menatap_wajah == 1 ? 'checked' : '' }}>
                    <label class="form-check-label" for="ya19">Ya</label>
                </div>
                <div class="form-check">
                    <input type="radio" class="form-check-input" name="menatap_wajah" value="0" id="tidak19"
                        {{ isset($gangguanAutis->menatap_wajah) && $gangguanAutis->menatap_wajah == 0 ? 'checked' : '' }}>
                    <label class="form-check-label" for="tidak19">Tidak</label>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label>20. Apakah anak anda menyukai aktivitas yang bergerak? (Misalnya, diayun-ayun atau
                dihentak-hentakkan pada lutut anda)</label>
            <div class="d-flex">
                <div class="form-check mr-3">
                    <input type="radio" class="form-check-input" name="suka_bergerak" value="1"
                        onchange="updateScore()" id="ya20"
                        {{ isset($gangguanAutis->suka_bergerak) && $gangguanAutis->suka_bergerak == 1 ? 'checked' : '' }}>
                    <label class="form-check-label" for="ya20">Ya</label>
                </div>
                <div class="form-check">
                    <input type="radio" class="form-check-input" name="suka_bergerak" value="0" id="tidak20"
                        {{ isset($gangguanAutis->suka_bergerak) && $gangguanAutis->suka_bergerak == 0 ? 'checked' : '' }}>
                    <label class="form-check-label" for="tidak20">Tidak</label>
                </div>
            </div>
        </div>
        <div class="form-group mt-4">
            <label>Skor Total</label>
            <div class="d-flex">
                <input type="text" class="form-control" id="totalScore" value="0" disabled>
            </div>
        </div>


        <div class="text-right mt-4">
            @if (isset($gangguanAutis))
                <a href="{{ route('gangguan.autis.admin') }}" type="button" class="btn btn-secondary mr-2"
                    style="font-size: 20px">Kembali</a>
            @else
                <a href="{{ route('skrining.ilp') }}" type="button" class="btn btn-secondary mr-2"
                    style="font-size: 20px">Kembali</a>
            @endif
            <button type="submit" class="btn btn-primary" style="font-size: 20px">Kirim</button>
        </div>
        </div>
    </form>
    <script>
        function updateScore() {
            let score = 0;
            // Select all checked "Ya" (value="1") radio buttons
            document.querySelectorAll('input[type="radio"][value="1"]:checked').forEach(() => score++);
            // Update the total score field
            document.getElementById('totalScore').value = score;
        }
        document.addEventListener('DOMContentLoaded', updateScore);
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
