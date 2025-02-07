<!-- Modal Add Action -->
<div class="modal fade" style="z-index: 1050;" id="addActionModal" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                @if ($routeName === 'action.index')
                    <h5 class="modal-title" id="exampleModalLabel">KAJIAN AWAL POLI UMUM</h5>
                    <input type="hidden" name="tipe" value="poli-umum">
                @elseif($routeName === 'action.index.gigi')
                    <h5 class="modal-title" id="exampleModalLabel">KAJIAN AWAL POLI GIGI</h5>
                    <input type="hidden" name="tipe" value="poli-gigi">
                @elseif($routeName === 'action.kia.index')
                    <h5 class="modal-title" id="exampleModalLabel">KAJIAN AWAL POLI KIA</h5>
                    <input type="hidden" name="tipe" value="poli-kia">
                @elseif($routeName === 'action.kb.index')
                    <h5 class="modal-title" id="exampleModalLabel">KAJIAN AWAL POLI KB</h5>
                    <input type="hidden" name="tipe" value="poli-kia">
                @else
                    <h5 class="modal-title" id="exampleModalLabel">KAJIAN AWAL UGD</h5>
                    <input type="hidden" name="tipe" value="ruang-tindakan">
                @endif
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form id="addPatientForm" action="{{ route('action.store') }}" method="POST" class="px-3">
                    @csrf
                    @if ($routeName === 'action.index')
                        <input type="hidden" name="tipe" id="tipe" value="poli-umum">
                    @elseif($routeName === 'action.index.gigi')
                        <input type="hidden" name="tipe" id="tipe" value="poli-gigi">
                    @elseif($routeName === 'action.kia.index')
                        <input type="hidden" name="tipe" id="tipe" value="poli-kia">
                    @elseif($routeName === 'action.kb.index')
                        <input type="hidden" name="tipe" id="tipe" value="poli-kb">
                    @else
                        <input type="hidden" name="tipe" id="tipe" value="ruang-tindakan">
                    @endif
                    <div class="row">
                        <div class="col-4">
                            <h5>Detail Pasien</h5>
                            <div id="patientDetails"
                                style="display:none; margin-top: 10px; padding: 10px; border-radius: 5px;">
                                <p><strong>ID</strong> : <span id="idPatient"></span></p>
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
                                                <input readonly type="text" class="form-control" id="nik"
                                                    name="nik" placeholder="NIK">
                                                <div class="input-group-append">
                                                    <button class="btn btn-primary" type="button" id="btnCariNIK"
                                                        data-bs-toggle="modal" data-bs-target="#modalPasienKunjungan">
                                                        Cari
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="tanggal">Tanggal</label>
                                            <input type="date" class="form-control" name="tanggal" id="tanggal"
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
                                    {{-- <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="kunjungan">Kunjungan</label>
                                            <select class="form-control" id="kunjungan" name="kunjungan">
                                                <option value="" disabled selected>Pilih Jenis Kunjungan</option>
                                                <option value="baru">Baru </option>
                                                <option value="lama">Lama </option>
                                            </select>
                                        </div>
                                    </div> --}}
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
                                    {{-- <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="wilayah_faskes">Wilayah Faskes</label>
                                            <select class="form-control" id="wilayah_faskes" name="faskes">
                                                <option value="" disabled selected>Pilih Wilayah Faskes</option>
                                                <option value="ya">Ya</option>
                                                <option value="tidak">Tidak</option>

                                            </select>
                                        </div>
                                    </div> --}}
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
                                                style="color: rgb(241, 11, 11);">Riwayat Penyakit Terdahulu</label>
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
                                        <textarea class="form-control" id="penyakit_lainnya" name="riwayat_penyakit_lainnya"
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
                                                style="color: rgb(241, 11, 11);">Riwayat Penyakit Keluarga</label>
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
                                        <textarea class="form-control" id="penyakit_lainnya_keluarga" name="riwayat_penyakit_lainnya_keluarga"
                                            placeholder="Isi penyakit lainnya"></textarea>
                                    </div>
                                    <div class="col-md-12">
                                        <label for="riwayat_alergi" style="color: rgb(241, 11, 11);">Riwayat
                                            Alergi</label>
                                        <textarea class="form-control" id="riwayat_alergi" name="riwayat_alergi" placeholder="Riwayat Alergi"></textarea>
                                    </div>

                                </div>
                            </div>
                            @if ($routeName !== 'action.kia.index' && $routeName !== 'action.kb.index')
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
                            @endif
                        </div>
                    </div>

                    <div class="row mt-3">

                        <div class="col-md-4">
                            <label for="alkohol" style="color: rgb(19, 11, 241);">KETERANGAN</label>
                            <input type="text" class="form-control" id="keterangan" name="keterangan"
                                placeholder="Keterangan">
                        </div>


                    </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-primary" data-bs-toggle="modal"
                    data-bs-target="#modalPasienKunjungan">Simpan Data</button>
                </form>
            </div>
        </div>
    </div>

</div>


@include('component.modal-table-pasien-kunjungan')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<style>
    .select2-dropdown {
        z-index: 9999 !important;
    }
</style>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const today = new Date().toLocaleDateString('en-CA');

        document.getElementById('tanggal').value = today;
        const selectElement = document.getElementById('riwayat_penyakit_dulu');
        const selectPenyakitKeluargaElement = document.getElementById('riwayat_penyakit_keluarga');
        const lainnyaContainer = document.getElementById('penyakit_lainnya_container');
        const lainnyaTextarea = document.getElementById('penyakit_lainnya');
        const lainnyaKeluargaContainer = document.getElementById('penyakit_lainnya_keluarga_container');
        const lainnyaKeluargaTextarea = document.getElementById('penyakit_keluarga_lainnya');

        selectElement.addEventListener('change', function() {
            if (this.value === 'lainnya') {
                lainnyaContainer.style.display = 'block';
                lainnyaTextarea = true;
            } else {
                lainnyaContainer.style.display = 'none';
                lainnyaTextarea.value = '';
                lainnyaTextarea = false;
            }
        });
        selectPenyakitKeluargaElement.addEventListener('change', function() {
            if (this.value === 'lainnya') {
                lainnyaKeluargaContainer.style.display = 'block';
                lainnyaKeluargaTextarea = true;
            } else {
                lainnyaKeluargaContainer.style.display = 'none';
                lainnyaKeluargaTextarea.value = '';
                lainnyaKeluargaTextarea = false;
            }
        });
    });
</script>

{{-- <script>
    // Initialize Flatpickr for the date picker
    document.addEventListener('DOMContentLoaded', function() {
        flatpickr('#tanggal', {
            dateFormat: 'd-m-Y',
            defaultDate: new Date(),
            locale: {
                firstDayOfWeek: 0
            }
        });
    });
</script> --}}

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
