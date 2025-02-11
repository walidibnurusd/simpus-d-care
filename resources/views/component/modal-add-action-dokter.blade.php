<!-- Modal Add Action -->
<div class="modal fade" style="z-index: 1050;" id="addActionModal" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                @if ($routeName === 'action.dokter.index')
                    <h5 class="modal-title" id="exampleModalLabel">TINDAKAN POLI UMUM</h5>
                @elseif($routeName === 'action.dokter.gigi.index')
                    <h5 class="modal-title" id="exampleModalLabel">TINDAKAN POLI GIGI</h5>
                @elseif($routeName === 'action.dokter.ruang.tindakan.index')
                    <h5 class="modal-title" id="exampleModalLabel">RUANG TINDAKAN</h5>
                @else
                    <h5 class="modal-title" id="exampleModalLabel">TINDAKAN UGD</h5>
                @endif
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form id="addPatientForm" action="" method="POST" class="px-3">
                    <div id="formSection1" class="form-section">
                        @csrf
                        @if ($routeName === 'action.dokter.index')
                            <input type="hidden" name="tipe" id="tipe" value="poli-umum">
                        @elseif($routeName === 'action.dokter.gigi.index')
                            <input type="hidden" name="tipe" id="tipe" value="poli-gigi">
                        @elseif($routeName === 'action.dokter.ruang.tindakan.index')
                            <input type="hidden" name="tipe" id="tipe" value="tindakan">
                        @else
                            <input type="hidden" name="tipe" id="tipe" value="ruang-tindakan">
                        @endif
                        <input type="hidden" name="action_id" id="action_id">
                        <div class="row">
                            <div class="col-4">
                                <h5>Detail Pasien</h5>
                                <div id="patientDetails"
                                    style="display:none; margin-top: 10px; padding: 10px; border-radius: 5px;">
                                    <p><strong>N I K</strong> : <span id="displayNIK"></span></p>
                                    <p><strong>Nama Pasien</strong> : <span id="displayName"></span></p>
                                    {{-- <p><strong>J.Kelamin</strong> : <span id="displayGender"></span></p> --}}
                                    <p><strong>Umur</strong> : <span id="displayAge"></span></p>
                                    <p><strong>Telepon/WA</strong> : <span id="displayPhone"></span></p>
                                    <p><strong>Alamat</strong> : <span id="displayAddress"></span></p>
                                    <p><strong>Darah</strong> : <span id="displayBlood"></span></p>
                                    {{-- <p><strong>Pendidikan</strong> : <span id="displayEducation"></span></p> --}}
                                    {{-- <p><strong>Pekerjaan</strong> : <span id="displayJob"></span></p> --}}
                                    <p><strong>Nomor RM</strong> : <span id="displayRmNumber"></span></p>
                                </div>
                            </div>
                            <div class="row col-8">
                                <div class="col-12">
                                    <div class="row g-2">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="nik">Cari Pasien</label>
                                                <div class="input-group">
                                                    <input type="text" hidden id="idAction" name="idAction"
                                                        value="">
                                                    <input readonly type="text" class="form-control" id="nik"
                                                        name="nik" placeholder="NIK">
                                                    <div class="input-group-append">
                                                        <button class="btn btn-primary" type="button" id="btnCariNIK"
                                                            data-bs-toggle="modal" data-bs-target="#modalPasienDokter">
                                                            Cari
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="tanggal">Tanggal</label>
                                                <input type="date" class="form-control" id="tanggal" name="tanggal"
                                                    placeholder="Pilih Tanggal">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="doctor">Dokter</label>
                                                <select class="form-control" id="doctor" name="doctor">
                                                    <option value="" disabled selected>Pilih Dokter</option>
                                                    @foreach ($dokter as $item)
                                                        <option value="{{ $item['name'] }}">{{ $item['name'] }}</option>
                                                    @endforeach

                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="kasus">Kasus</label>
                                                <select class="form-control" id="kasus" name="kasus">
                                                    <option value="" disabled selected>Pilih Jenis Kasus
                                                    </option>
                                                    <option value="1">Baru </option>
                                                    <option value="0">Lama </option>

                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="row g-2">

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="jenis_kartu">Jenis Kartu</label>
                                                <input type="text" class="form-control" id="jenis_kartu"
                                                    name="jenis_kartu" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="nomor_kartu">Nomor Kartu</label>
                                                <input type="text" class="form-control" id="nomor_kartu"
                                                    name="nomor_kartu" placeholder="Masukkan Nomor" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="wilayah_faskes">Wilayah Faskes</label>
                                                <input type="text" class="form-control" id="wilayah_faskes"
                                                    name="wilayah_faskes" placeholder="Wilayah Faskes" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <label for="keluhan" style="color: rgb(241, 11, 11);">Keluhan</label>
                                            <textarea class="form-control" id="keluhan" name="keluhan" placeholder="Keluhan"></textarea>
                                        </div>
                                        <div class="col-md-12">
                                            <label for="riwayat_penyakit_sekarang"
                                                style="color: rgb(241, 11, 11);">Riwayat
                                                Penyakit Sekarang</label>
                                            <textarea class="form-control" id="riwayat_penyakit_sekarang" name="riwayat_penyakit_sekarang"
                                                placeholder="Riwayat Penyakit Sekarang"></textarea>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="riwayat_penyakit_dulu"
                                                    style="color: rgb(241, 11, 11);">Riwayat
                                                    Penyakit Terdahulu</label>
                                                <select class="form-control" id="riwayat_penyakit_dulu"
                                                    name="riwayat_penyakit_dulu">
                                                    <option value="" disabled selected>Pilih</option>
                                                    <option value="hipertensi">Hipertensi</option>
                                                    <option value="dm">DM</option>
                                                    <option value="jantung">Jantung</option>
                                                    <option value="stroke">Stroke</option>
                                                    <option value="asma">Asma</option>
                                                    <option value="liver">Liver</option>
                                                    <option value="ginjal">Ginjal</option>
                                                    <option value="tb">TB</option>
                                                    <option value="lainnya">Lainnya</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-12 mt-2" id="penyakit_lainnya_container"
                                            style="display: none;">
                                            <label for="penyakit_lainnya" style="color: rgb(241, 11, 11);">Sebutkan
                                                Penyakit Lainnya</label>
                                            <textarea class="form-control" id="riwayat_penyakit_lainnya" name="riwayat_penyakit_lainnya"
                                                placeholder="Isi penyakit lainnya"></textarea>
                                        </div>
                                        <div class="col-md-12">
                                            <label for="riwayat_pengobatan" style="color: rgb(241, 11, 11);">Riwayat
                                                Pengobatan</label>
                                            <textarea class="form-control" id="riwayat_pengobatan" name="riwayat_pengobatan" placeholder="Riwayat Pengobatan"></textarea>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="riwayat_penyakit_keluarga"
                                                    style="color: rgb(241, 11, 11);">Riwayat
                                                    Penyakit Keluarga</label>
                                                <select class="form-control" id="riwayat_penyakit_keluarga"
                                                    name="riwayat_penyakit_keluarga">
                                                    <option value="" disabled selected>Pilih</option>
                                                    <option value="hipertensi">Hipertensi</option>
                                                    <option value="dm">DM</option>
                                                    <option value="jantung">Jantung</option>
                                                    <option value="stroke">Stroke</option>
                                                    <option value="asma">Asma</option>
                                                    <option value="liver">Liver</option>
                                                    <option value="ginjal">Ginjal</option>
                                                    <option value="tb">TB</option>
                                                    <option value="lainnya">Lainnya</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-12 mt-2" id="penyakit_lainnya_keluarga_container"
                                            style="display: none;">
                                            <label for="penyakit_lainnya_keluarga"
                                                style="color: rgb(241, 11, 11);">Sebutkan
                                                Penyakit Lainnya</label>
                                            <textarea class="form-control" id="riwayat_penyakit_lainnya_keluarga" name="riwayat_penyakit_lainnya_keluarga"
                                                placeholder="Isi penyakit lainnya"></textarea>
                                        </div>
                                        <div class="col-md-12">
                                            <label for="riwayat_alergi" style="color: rgb(241, 11, 11);">Riwayat
                                                Alergi</label>
                                            <textarea class="form-control" id="riwayat_alergi" name="riwayat_alergi" placeholder="Riwayat Alergi"></textarea>
                                        </div>
                                        <div class="row mt-3">

                                            <div class="col-md-12">
                                                <label for="alkohol"
                                                    style="color: rgb(19, 11, 241);">KETERANGAN</label>
                                                <input type="text" class="form-control" id="keterangan"
                                                    name="keterangan" placeholder="Keterangan">
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
                                                <input type="text" class="form-control" id="sistol"
                                                    name="sistol" placeholder="Masukkan Sistol">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="diastol">Diastol</label>
                                                <input type="text" class="form-control" id="diastol"
                                                    name="diastol" placeholder="Masukkan Diastol">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="berat_badan">Berat Badan</label>
                                                <input type="text" class="form-control" id="berat_badan"
                                                    name="beratBadan" placeholder="Masukkan Berat Badan">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="tinggi_badan">Tinggi Badan</label>
                                                <input type="text" class="form-control" id="tinggi_badan"
                                                    name="tinggiBadan" placeholder="Masukkan Tinggi Badan">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="ling_pinggang">Ling. Pinggang</label>
                                                <input type="text" class="form-control" id="ling_pinggang"
                                                    name="lingkarPinggang" placeholder="Masukkan Ling. Pinggang">
                                            </div>
                                        </div>

                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="nadi">Nadi</label>
                                                <input type="text" class="form-control" id="nadi"
                                                    name="nadi" placeholder="Masukkan Nadi">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="nafas">Pernafasan</label>
                                                <input type="text" class="form-control" id="nafas"
                                                    name="nafas" placeholder="Masukkan Nafas">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="suhu">Suhu</label>
                                                <input type="text" class="form-control" id="suhu"
                                                    name="suhu" placeholder="Masukkan Suhu">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @if ($routeName === 'action.dokter.index')
                                    <div style="display: flex; align-items: center; text-align: center;">
                                        <hr style="flex: 1; border: none; border-top: 1px solid #ccc;">
                                        <span style="margin: 0 10px; white-space: nowrap;">Pemeriksaan Fisik</span>
                                        <hr style="flex: 1; border: none; border-top: 1px solid #ccc;">
                                    </div>
                                    <div class="container">
                                        <div class="row g-2">
                                            <div class="col-md-2 ">
                                                <label for="mata_anemia" style="color: green;">Mata-Anemia</label>
                                                <select class="form-control" id="mata_anemia" name="mata_anemia">
                                                    <option value="" disabled selected>pilih</option>
                                                    <option value="ya">Ya</option>
                                                    <option value="tidak">Tidak</option>
                                                </select>
                                            </div>
                                            <div class="col-md-2 ">
                                                <label for="pupil" style="color: green;">Mata-Pupil</label>
                                                <select class="form-control" id="pupil" name="pupil">
                                                    <option value="" disabled selected>pilih</option>
                                                    <option value="isokor">Isokor</option>
                                                    <option value="anisokor">Anisokor</option>
                                                </select>
                                            </div>
                                            <div class="col-md-2 ">
                                                <label for="ikterus" style="color: green;">Mata-Ikterus</label>
                                                <select class="form-control" id="ikterus" name="ikterus">
                                                    <option value="" disabled selected>pilih</option>
                                                    <option value="ya">Ya</option>
                                                    <option value="tidak">Tidak</option>
                                                </select>
                                            </div>
                                            <div class="col-md-2 ">
                                                <label for="udem_palpebral" style="color: green;">Mata-Udem
                                                    Palpebral</label>
                                                <select class="form-control" id="udem_palpebral"
                                                    name="udem_palpebral">
                                                    <option value="" disabled selected>pilih</option>
                                                    <option value="ya">Ya</option>
                                                    <option value="tidak">Tidak</option>
                                                </select>
                                            </div>
                                            <div class="col-md-2 ">
                                                <label for="nyeri_tekan" style="color: green;">Abdomen-Nyeri
                                                    Tekan</label>
                                                <select class="form-control" id="nyeri_tekan" name="nyeri_tekan">
                                                    <option value="" disabled selected>pilih</option>
                                                    <option value="ya">Ya</option>
                                                    <option value="tidak">Tidak</option>
                                                </select>
                                            </div>
                                            <div class="col-md-2 ">
                                                <label for="peristaltik"
                                                    style="color: green;">Abdomen-Peristaltik</label>
                                                <select class="form-control" id="peristaltik" name="peristaltik">
                                                    <option value="" disabled selected>pilih</option>
                                                    <option value="normal">Normal</option>
                                                    <option value="meningkat">Meningkat</option>
                                                    <option value="menurun">Menurun</option>
                                                </select>
                                            </div>
                                            <div class="col-md-2 ">
                                                <label for="ascites" style="color: green;">Abdomen-Ascites</label>
                                                <select class="form-control" id="ascites" name="ascites">
                                                    <option value="" disabled selected>pilih</option>
                                                    <option value="ya">Ya</option>
                                                    <option value="tidak">Tidak</option>
                                                </select>
                                            </div>
                                            <div class="col-md-2 ">
                                                <label for="lokasi_abdomen"
                                                    style="color: green;">Abdomen-Lokasi</label>
                                                <input type="text" class="form-control" id="lokasi_abdomen"
                                                    name="lokasi_abdomen" placeholder="Lokasi Abdomen">
                                            </div>
                                            <div class="col-md-2 ">
                                                <label for="thorax" style="color: green;">Thorax</label>
                                                <select class="form-control" id="thorax" name="thorax">
                                                    <option value="" disabled selected>pilih</option>
                                                    <option value="simetris">Simetris</option>
                                                    <option value="asimetris">Asimetris</option>
                                                </select>
                                            </div>
                                            <div class="col-md-2 ">
                                                <label for="thorax_bj" style="color: green;">Thorax-BJ I/II</label>
                                                <select class="form-control" id="thorax_bj" name="thorax_bj">
                                                    <option value="" disabled selected>pilih</option>
                                                    <option value="regular">Regular</option>
                                                    <option value="irregular">Irregular</option>
                                                </select>
                                            </div>
                                            <div class="col-md-2 ">
                                                <label for="suara_nafas" style="color: green;">Thorax-Suara
                                                    Nafas</label>
                                                <select class="form-control" id="suara_nafas" name="suara_nafas">
                                                    <option value="" disabled selected>pilih</option>
                                                    <option value="vesikuler">Vesikuler</option>
                                                    <option value="bronkoveskuler">Bronkoveskuler</option>
                                                </select>
                                            </div>
                                            <div class="col-md-2 ">
                                                <label for="ronchi" style="color: green;">Thorax-Ronchi</label>
                                                <select class="form-control" id="ronchi" name="ronchi">
                                                    <option value="" disabled selected>pilih</option>
                                                    <option value="ya">Ya</option>
                                                    <option value="tidak">Tidak</option>
                                                </select>
                                            </div>
                                            <div class="col-md-2 ">
                                                <label for="wheezing" style="color: green;">Thorax-Wheezing</label>
                                                <select class="form-control" id="wheezing" name="wheezing">
                                                    <option value="" disabled selected>pilih</option>
                                                    <option value="ya">Ya</option>
                                                    <option value="tidak">Tidak</option>
                                                </select>
                                            </div>
                                            <div class="col-md-2 ">
                                                <label for="ekstremitas" style="color: green;">Ekstremitas</label>
                                                <select class="form-control" id="ekstremitas" name="ekstremitas">
                                                    <option value="" disabled selected>pilih</option>
                                                    <option value="hangat">Hangat</option>
                                                    <option value="dingin">Dingin</option>
                                                </select>
                                            </div>
                                            <div class="col-md-2 ">
                                                <label for="edema" style="color: green;">Ekstremitas-Edema</label>
                                                <select class="form-control" id="edema" name="edema">
                                                    <option value="" disabled selected>pilih</option>
                                                    <option value="ya">Ya</option>
                                                    <option value="tidak">Tidak</option>
                                                    <option value="lainnya">Lainnya</option>
                                                </select>
                                            </div>
                                            <div class="col-md-2 ">
                                                <label for="tonsil" style="color: green;">THT-Tonsil</label>
                                                <input type="text" class="form-control" id="tonsil"
                                                    name="tonsil" placeholder="Tonsil">
                                            </div>
                                            <div class="col-md-2 ">
                                                <label for="fharing" style="color: green;">THT-Fharing</label>
                                                <input type="text" class="form-control" id="fharing"
                                                    name="fharing" placeholder="Fharing">
                                            </div>
                                            <div class="col-md-2 ">
                                                <label for="kelenjar" style="color: green;">Leher-Pembesaran
                                                    Kelenjar</label>
                                                <input type="text" class="form-control" id="kelenjar"
                                                    name="kelenjar" placeholder="Pembesaran Kelenjar">
                                            </div>
                                            <div class="col-md-2 ">
                                                <label for="genetalia" style="color: green;">Genetalia</label>
                                                <input type="text" class="form-control" id="genetalia"
                                                    name="genetalia" placeholder="Genetalia Jika Diperlukan">
                                            </div>
                                            <div class="col-md-2 ">
                                                <label for="warna_kulit" style="color: green;">Kulit-Warna</label>
                                                <input type="text" class="form-control" id="warna_kulit"
                                                    name="warna_kulit" placeholder="Warna Kulit">
                                            </div>
                                            <div class="col-md-2 ">
                                                <label for="turgor" style="color: green;">Kulit-Turgor</label>
                                                <input type="text" class="form-control" id="turgor"
                                                    name="turgor" placeholder="Turgor Kulit">
                                            </div>
                                            <div class="col-md-2 ">
                                                <label for="neurologis" style="color: green;">Pemeriksaan
                                                    Neurologis</label>
                                                <input type="text" class="form-control" id="neurologis"
                                                    name="neurologis"
                                                    placeholder="Pemeriksaan Neurologis Jika Diperlukan">
                                            </div>
                                        </div>
                                    </div>
                                    {{-- <div style="display: flex; align-items: center; text-align: center;">
                                        <hr style="flex: 1; border: none; border-top: 1px solid #ccc;">
                                        <span style="margin: 0 10px; white-space: nowrap;">Pemeriksaan Penunjang</span>
                                        <hr style="flex: 1; border: none; border-top: 1px solid #ccc;">
                                    </div> --}}
                                @endif
                            </div>
                        </div>
                        @if (Auth::user()->role != 'tindakan')
                            <div class="row mt-3">
                                <div class="col-md-4">
                                    <label for="alkohol" style="color: rgb(19, 11, 241);">DIAGNOSA</label>
                                    <select class="form-control" id="diagnosa" name="diagnosa[]" multiple>
                                        @foreach ($diagnosa as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}-{{ $item->icd10 }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="skrining" class="form-label">Hasil Skrining</label>
                                        <button class="btn btn-primary w-100 mt-2" type="button"
                                            id="btnCariskrining" data-bs-toggle="modal"
                                            data-bs-target="#modalSkrining">
                                            Hasil Skrining
                                        </button>

                                    </div>
                                </div>
                                {{-- <div class="col-md-4">
                                    <label for="pemeriksaan_penunjang" style="color: rgb(19, 11, 241);">Pemeriksaan
                                        Penunjang</label>
                                    <textarea class="form-control" id="pemeriksaan_penunjang" name="pemeriksaan_penunjang"
                                        placeholder="Pemeriksaan Penunjang"></textarea>
                                </div> --}}
                            </div>
                        @endif
                        <div class="row mt-3">

                            @if ($routeName !== 'action.dokter.ruang.tindakan.index')
                                <div class="col-md-4">
                                    <label for="alkohol" style="color: rgb(19, 11, 241);">TINDAKAN</label>
                                    <select class="form-control" id="tindakan" name="tindakan">
                                        <option value="" disabled selected>pilih</option>
                                        @if ($routeName === 'action.dokter.index')
                                            <option value="Diberikan Obat">Diberikan Obat</option>
                                            <option value="Dirujuk">Dirujuk</option>
                                        @elseif($routeName === 'action.dokter.gigi.index')
                                            <option value="Gigi Sulung Tumpatan Sementara">Gigi Sulung Tumpatan
                                                Sementara
                                            </option>
                                            <option value="Gigi Tetap Tumpatan Sementara">Gigi Tetap Tumpatan Sementara
                                            </option>
                                            <option value="Gigi Tetap Tumpatan Tetap">Gigi Tetap Tumpatan Tetap
                                            </option>
                                            <option value="Gigi Sulung Tumpatan Tetap">Gigi Sulung Tumpatan Tetap
                                            </option>
                                            <option value="Perawatan Saluran Akar">Perawatan Saluran Akar
                                            </option>
                                            <option value="Gigi Sulung Pencabutan">Gigi Sulung Pencabutan
                                            </option>
                                            <option value="Gigi Tetap Pencabutan">Gigi Tetap Pencabutan
                                            </option>
                                            <option value="Pembersihan Karang Gigi">Pembersihan Karang Gigi
                                            </option>
                                            <option value="Odontectomy">Odontectomy
                                            </option>
                                            <option value="Sebagian Prothesa">Sebagian Prothesa
                                            </option>
                                            <option value="Penuh Prothesa">Penuh Prothesa
                                            </option>
                                            <option value="Reparasi Prothesa">Reparasi Prothesa
                                            </option>
                                            <option value="Premedikasi/Pengobatan">Premedikasi/Pengobatan
                                            </option>
                                            </option>
                                            <option value="Tindakan Lain">Tindakan Lain
                                            </option>
                                            <option value="Incici Abses Gigi">Incici Abses Gigi</option>
                                        @else
                                            <option value="Observasi Tanpa Tindakan Invasif">Observasi Tanpa Tindakan
                                                Invasif
                                            </option>
                                            <option value="Observasi Dengan Tindakan Invasif">Observasi Dengan Tindakan
                                                Invasif
                                            </option>
                                            <option value="Tidak Ada">Tidak Ada
                                            </option>
                                            <option value="Corpus Alineum">Corpus Alineum
                                            </option>
                                            <option value="Ekstraksi Kuku">Ekstraksi Kuku
                                            </option>
                                            <option value="Sircumsisi (Bedah Ringan)">Sircumsisi (Bedah Ringan)
                                            </option>
                                            <option value="Incisi Abses">Incisi Abses
                                            </option>
                                            <option value="Rawat Luka">Rawat Luka
                                            </option>
                                            <option value="Ganti Verban">Ganti Verban
                                            </option>
                                            <option value="Spooling">Spooling
                                            </option>
                                            <option value="Toilet Telinga">Toilet Telinga
                                            </option>
                                            <option value="Tetes Telinga">Tetes Telinga
                                            </option>
                                            <option value="Aff Hecting">Aff Hecting
                                            </option>
                                            </option>
                                            <option value="Hecting (Jahit Luka)">Hecting (Jahit Luka)
                                            </option>
                                            <option value="Tampon/Off Tampon">Tampon/Off Tampon</option>
                                        @endif
                                    </select>
                                </div>
                            @else
                                <div class="col-md-4">
                                    <label for="alkohol" style="color: rgb(19, 11, 241);">TINDAKAN</label>
                                    <select class="form-control" id="tindakan_ruang_tindakan"
                                        name="tindakan_ruang_tindakan">
                                        <option value="" disabled selected>pilih</option>

                                        <option value="Observasi Tanpa Tindakan Invasif">Observasi Tanpa Tindakan
                                            Invasif
                                        </option>
                                        <option value="Observasi Dengan Tindakan Invasif">Observasi Dengan Tindakan
                                            Invasif
                                        </option>
                                        <option value="Tidak Ada">Tidak Ada
                                        </option>
                                        <option value="Corpus Alineum">Corpus Alineum
                                        </option>
                                        <option value="Ekstraksi Kuku">Ekstraksi Kuku
                                        </option>
                                        <option value="Sircumsisi (Bedah Ringan)">Sircumsisi (Bedah Ringan)
                                        </option>
                                        <option value="Incisi Abses">Incisi Abses
                                        </option>
                                        <option value="Rawat Luka">Rawat Luka
                                        </option>
                                        <option value="Ganti Verban">Ganti Verban
                                        </option>
                                        <option value="Spooling">Spooling
                                        </option>
                                        <option value="Toilet Telinga">Toilet Telinga
                                        </option>
                                        <option value="Tetes Telinga">Tetes Telinga
                                        </option>
                                        <option value="Aff Hecting">Aff Hecting
                                        </option>
                                        </option>
                                        <option value="Hecting (Jahit Luka)">Hecting (Jahit Luka)
                                        </option>
                                        <option value="Tampon/Off Tampon">Tampon/Off Tampon</option>

                                    </select>
                                </div>
                            @endif
                            <div class="col-md-4">
                                <label for="obat" style="color: rgb(19, 11, 241);">Obat</label>
                                <textarea class="form-control" id="obat" name="obat" placeholder="Obat"></textarea>
                            </div>

                            @if ($routeName == 'action.dokter.ruang.tindakan.index')
                                <div class="col-md-4">
                                    <label for="alkohol" style="color: rgb(19, 11, 241);">DIAGNOSA</label>
                                    <select class="form-control" id="diagnosaEdit" name="diagnosa[]" disabled>
                                        <option value="" disabled selected>Pilih</option>
                                        @foreach ($diagnosa as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}-{{ $item->icd10 }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                            @endif
                            @if (Auth::user()->role != 'tindakan')
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="rujuk_rs" style="color: rgb(19, 11, 241);">RUJUK RS</label>
                                        <select class="form-control" id="rujuk_rs" name="rujuk_rs"
                                            data-placeholder="Pilih Rumah Sakit">
                                            <option></option> <!-- Empty option to show placeholder -->
                                            @foreach ($rs as $item)
                                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            @endif
                            @if ($routeName === 'action.dokter.index')
                                <div class="col-md-4">
                                    <label for="beri_tindakan" style="color: rgb(19, 11, 241);">Dirujuk Ke Ruang
                                        Tindakan</label>
                                    <select class="form-control" id="beri_tindakan" name="beri_tindakan">
                                        <option value="" disabled selected>pilih</option>
                                        <option value="1">Iya</option>
                                        <option value="0">Tidak</option>
                                    </select>
                                </div>
                            @endif

                            <div class="col-md-4">
                                <label for="alkohol" style="color: rgb(19, 11, 241);">KETERANGAN</label>
                                <input type="text" class="form-control" id="keterangan" name="keterangan"
                                    placeholder="Keterangan">
                            </div>
                        </div>

                    </div>
                    @if (Auth::user()->role == 'dokter' || $routeName === 'action.dokter.ugd.index')
                        <div id="formSection2" class="form-section d-none">
                            <h6>Jenis Pemeriksaan Darah</h6>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="gds"
                                            name="jenis_pemeriksaan[]" value="GDS">
                                        <label class="form-check-label" for="gds">GDS</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="gdp"
                                            name="jenis_pemeriksaan[]" value="GDP">
                                        <label class="form-check-label" for="gdp">GDP</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="gdp_2_jam_pp"
                                            name="jenis_pemeriksaan[]" value="GDP 2 Jam pp">
                                        <label class="form-check-label" for="gdp_2_jam_pp">GDP 2 Jam pp</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="cholesterol"
                                            name="jenis_pemeriksaan[]" value="Cholesterol">
                                        <label class="form-check-label" for="cholesterol">Cholesterol</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="asam_urat"
                                            name="jenis_pemeriksaan[]" value="Asam Urat">
                                        <label class="form-check-label" for="asam_urat">Asam Urat</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="leukosit"
                                            name="jenis_pemeriksaan[]" value="Leukosit">
                                        <label class="form-check-label" for="leukosit">Leukosit</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="eritrosit"
                                            name="jenis_pemeriksaan[]" value="Eritrosit">
                                        <label class="form-check-label" for="eritrosit">Eritrosit</label>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="trombosit"
                                            name="jenis_pemeriksaan[]" value="Trombosit">
                                        <label class="form-check-label" for="trombosit">Trombosit</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="hemoglobin"
                                            name="jenis_pemeriksaan[]" value="Hemoglobin">
                                        <label class="form-check-label" for="hemoglobin">Hemoglobin</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="sifilis"
                                            name="jenis_pemeriksaan[]" value="Sifilis">
                                        <label class="form-check-label" for="sifilis">Sifilis</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="hiv"
                                            name="jenis_pemeriksaan[]" value="HIV">
                                        <label class="form-check-label" for="hiv">HIV</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="golongan_darah"
                                            name="jenis_pemeriksaan[]" value="Golongan Darah">
                                        <label class="form-check-label" for="golongan_darah">Golongan Darah</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="widal"
                                            name="jenis_pemeriksaan[]" value="Widal">
                                        <label class="form-check-label" for="widal">Widal</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="malaria"
                                            name="jenis_pemeriksaan[]" value="Malaria">
                                        <label class="form-check-label" for="malaria">Malaria</label>
                                    </div>
                                </div>
                            </div>
                            <!-- Tambahan Pemeriksaan URINE -->
                            <h6>Jenis Pemeriksaan URINE</h6>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="albumin"
                                    name="jenis_pemeriksaan[]" value="Albumin">
                                <label class="form-check-label" for="albumin">Albumin</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="reduksi"
                                    name="jenis_pemeriksaan[]" value="Reduksi">
                                <label class="form-check-label" for="reduksi">Reduksi</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="urinalisa"
                                    name="jenis_pemeriksaan[]" value="Urinalisa">
                                <label class="form-check-label" for="urinalisa">Urinalisa</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="tes_kehamilan"
                                    name="jenis_pemeriksaan[]" value="Tes Kehamilan">
                                <label class="form-check-label" for="tes_kehamilan">Tes Kehamilan</label>
                            </div>

                            <!-- Tambahan Pemeriksaan FESES -->
                            <h6>Jenis Pemeriksaan FESES</h6>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="telur_cacing"
                                    name="jenis_pemeriksaan[]" value="Telur Cacing">
                                <label class="form-check-label" for="telur_cacing">Telur Cacing</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="bta"
                                    name="jenis_pemeriksaan[]" value="BTA">
                                <label class="form-check-label" for="bta">BTA</label>
                            </div>

                            <!-- Tambahan Pemeriksaan IgM -->
                            <h6>Pemeriksaan IgM</h6>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="igm_dbd"
                                    name="jenis_pemeriksaan[]" value="IgM DBD">
                                <label class="form-check-label" for="igm_dbd">IgM DBD</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="igm_typhoid"
                                    name="jenis_pemeriksaan[]" value="IgM Typhoid">
                                <label class="form-check-label" for="igm_typhoid">IgM Typhoid</label>
                            </div>
                        </div>
                    @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                @if (Auth::user()->role == 'dokter' || $routeName === 'action.dokter.ugd.index')
                    <button type="button" class="btn btn-success" id="nextSectionButton">Lanjut
                        Pemeriksaan</button>
                @endif
                <button type="submit" id="submit" class="btn btn-primary" data-bs-toggle="modal"
                    data-bs-target="#modalPasienDokter">Simpan Data</button>
                </form>
            </div>
        </div>
    </div>

</div>


@include('component.modal-table-pasien-dokter')
@include('component.modal-skrining')


<script>
    let currentSection = 1;
    document.getElementById('nextSectionButton').addEventListener('click', function() {
        const section1 = document.getElementById('formSection1');
        const section2 = document.getElementById('formSection2');
        const button = this;

        if (section1.classList.contains('d-none')) {
            // Kembali ke Section 1
            section1.classList.remove('d-none');
            section2.classList.add('d-none');
            button.textContent = 'Lanjut Pemeriksaan';
        } else {
            // Lanjut ke Section 2
            section1.classList.add('d-none');
            section2.classList.remove('d-none');
            button.textContent = 'Kembali';
        }
    });
    $(document).ready(function() {
        // Initialize select2 for all relevant elements
        $('#diagnosa, #tindakan, #rujuk_rs')
            .select2({
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
