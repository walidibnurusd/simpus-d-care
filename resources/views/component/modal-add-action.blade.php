<!-- Modal Add Action -->
<div class="modal fade" style="z-index: 1050;" id="addActionModal" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title" id="exampleModalLabel">TINDAKAN POLI UMUM</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form id="addPatientForm" action="{{ route('action.store') }}" method="POST" class="px-3">
                    @csrf
                    <div class="row">
                        <div class="col-4">
                            <h5>Detail Pasien</h5>
                            <div id="patientDetails"
                                style="display:none; margin-top: 10px; padding: 10px; border-radius: 5px;">
                                <p><strong>N I K</strong> : <span id="displayNIK"></span></p>
                                <p><strong>Nama Pasien</strong> : <span id="displayName"></span></p>
                                <p><strong>J.Kelamin</strong> : <span id="displayGender"></span></p>
                                <p><strong>Umur</strong> : <span id="displayAge"></span></p>
                                <p><strong>Telepon/WA</strong> : <span id="displayPhone"></span></p>
                                <p><strong>Alamat</strong> : <span id="displayAddress"></span></p>
                                <p><strong>Darah</strong> : <span id="displayBlood"></span></p>
                                <p><strong>Pendidikan</strong> : <span id="displayEducation"></span></p>
                                <p><strong>Pekerjaan</strong> : <span id="displayJob"></span></p>
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
                                                    name="id_patient" placeholder="NIK" required>
                                                <div class="input-group-append">
                                                    <button class="btn btn-primary" type="button" id="btnCariNIK"
                                                        data-bs-toggle="modal" data-bs-target="#modalPasien">
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
                                                name="tanggal" placeholder="Pilih Tanggal" required>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="doctor">Dokter</label>
                                            <select class="form-control" id="doctor" name="id_doctor" required>
                                                <option value="" disabled selected>Pilih Dokter</option>
                                                @foreach ($dokter as $item)
                                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                @endforeach
                                              
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="kunjungan">Kunjungan</label>
                                            <select class="form-control" id="kunjungan" name="kunjungan" required>
                                                <option value="" disabled selected>Pilih Jenis Kunjungan</option>
                                                <option value="baru">Baru </option>
                                                <option value="lama">Lama </option>
                                                
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
                                                <option value="" disabled selected>Pilih Jenis Kartu</option>
                                                <option value="umum">Umum</option>
                                                <option value="akses">AKSES</option>
                                                <option value="bpjs">BPJS-KIS_JKM</option>
                                                <option value="gratis_jkd">Gratis-JKD</option>
                                                <option value="bpjs_mandiri">BPJS-Mandiri</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="nomor">Nomor Kartu</label>
                                            <input type="text" class="form-control" id="nomor" name="nomor"
                                                placeholder="Masukkan Nomor" required>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="wilayah_faskes">Wilayah Faskes</label>
                                            <select class="form-control" id="wilayah_faskes" name="faskes"
                                                required>
                                                <option value="" disabled selected>Pilih Wilayah Faskes</option>
                                                <option value="ya">Ya</option>
                                                <option value="tidak">Tidak</option>

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
                                                placeholder="Masukkan Sistol" required>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="diastol">Diastol</label>
                                            <input type="text" class="form-control" id="diastol" name="diastol"
                                                placeholder="Masukkan Diastol" required>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="berat_badan">Berat Badan</label>
                                            <input type="text" class="form-control" id="berat_badan"
                                                name="beratBadan" placeholder="Masukkan Berat Badan" required>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="tinggi_badan">Tinggi Badan</label>
                                            <input type="text" class="form-control" id="tinggi_badan"
                                                name="tinggiBadan" placeholder="Masukkan Tinggi Badan" required>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="ling_pinggang">Ling. Pinggang</label>
                                            <input type="text" class="form-control" id="ling_pinggang"
                                                name="lingkarPinggang" placeholder="Masukkan Ling. Pinggang" required>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="gula">Gula</label>
                                            <input type="text" class="form-control" id="gula" name="gula"
                                                placeholder="Masukkan Gula" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="container">
                                <div class="row g-2">
                                    <div class="col-md-2 ">
                                        <label for="merokok" style="color: green;">Merokok</label>
                                        <select class="form-control" id="merokok" name="merokok">
                                            <option value="" disabled selected>pilih</option>
                                            <option value="ya">Ya</option>
                                            <option value="tidak">Tidak</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2 ">
                                        <label for="aktivitas_fisik" style="color: green;">Aktivitas Fisik</label>
                                        <select class="form-control" id="aktivitas_fisik" name="fisik">
                                            <option value="" disabled selected>pilih</option>
                                            <option value="aktif">Aktif</option>
                                            <option value="tidak_aktif">Tidak Aktif</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2 ">
                                        <label for="gula" style="color: green;">Gula Berlebih</label>
                                        <select class="form-control" id="gula" name="gula_lebih">
                                            <option value="" disabled selected>pilih</option>
                                            <option value="ya">Ya</option>
                                            <option value="tidak">Tidak</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2 ">
                                        <label for="lemak" style="color: green;">Lemak Berlebih</label>
                                        <select class="form-control" id="lemak" name="lemak">
                                            <option value="" disabled selected>pilih</option>
                                            <option value="ya">Ya</option>
                                            <option value="tidak">Tidak</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2 ">
                                        <label for="garam" style="color: green;">Garam Berlebih</label>
                                        <select class="form-control" id="garam" name="garam">
                                            <option value="" disabled selected>pilih</option>
                                            <option value="ya">Ya</option>
                                            <option value="tidak">Tidak</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2 ">
                                        <label for="buah_sayur" style="color: green;">Mkn Buah/Sayur</label>
                                        <select class="form-control" id="buah_sayur" name="buah_sayur">
                                            <option value="" disabled selected>pilih</option>
                                            <option value="cukup">Cukup</option>
                                            <option value="kurang">Kurang</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="container">
                                <div class="row g-2 mt-2">
                                    <div class="col-md-2 ">
                                        <label for="alkohol" style="color: green;">Minum Alkohol</label>
                                        <select class="form-control" id="alkohol" name="alkohol">
                                            <option value="" disabled selected>pilih</option>
                                            <option value="ya">Ya</option>
                                            <option value="tidak">Tidak</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2 ">
                                        <label for="kondisi_hidup" style="color: green;">Kondisi Hidup</label>
                                        <select class="form-control" id="kondisi_hidup" name="hidup">
                                            <option value="" disabled selected>pilih</option>
                                            <option value="ya">Ya</option>
                                            <option value="tidak">Tidak</option>
                                        </select>
                                    </div>

                                </div>
                            </div>
                            <hr>
                            <div class="container">
                                <div class="row g-2 mt-2">
                                    <div class="col-md-3 ">
                                        <label for="alkohol" style="color: rgb(128, 87, 0);">Hasil IVA</label>
                                        <select class="form-control" id="alkohol" name="hasil_iva">
                                            <option value="" disabled selected>pilih</option>
                                            <option value="positif">Positif</option>
                                            <option value="negatif">Negatif</option>
                                            <option value="kanker">Curiga Kanker</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3 ">
                                        <label for="kondisi_hidup" style="color: rgb(128, 87, 0);">Tindak Lanjut IVA</label>
                                        <select class="form-control" id="kondisi_hidup" name="tindak_iva">
                                            <option value="" disabled selected>pilih</option>
                                            <option value="krioterapi">KRIOTERAPI</option>
                                            <option value="rujuk">RUJUK</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3 ">
                                        <label for="kondisi_hidup" style="color: rgb(128, 87, 0);">HASIL SADANIS</label>
                                        <select class="form-control" id="kondisi_hidup" name="hasil_sadanis">
                                            <option value="" disabled selected>pilih</option>
                                            <option value="benjolan">Benjolan</option>
                                            <option value="tidak">Tidak ada Benjolan</option>
                                            <option value="kanker">Curiga Kanker</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3 ">
                                        <label for="kondisi_hidup" style="color: rgb(128, 87, 0);">Tindak Lanjut SADANIS</label>
                                        <select class="form-control" id="kondisi_hidup" name="tindak_sadanis">
                                            <option value="" disabled selected>pilih</option>
                                            <option value="rujuk">RUJUK</option>
                                            
                                        </select>
                                    </div>

                                </div>
                            </div>
                            <div class="container">
                                <div class="row g-2 mt-2">
                                    <div class="col-md-3 ">
                                        <label for="alkohol" style="color: green;">Konseling</label>
                                        <select class="form-control" id="alkohol" name="konseling">
                                            <option value="" disabled selected>pilih</option>
                                            <option value="konseling1">Konseling1</option>
                                            <option value="konseling2">Konseling2</option>
                                            <option value="konseling3">Konseling3</option>
                                            <option value="konseling4">Konseling4</option>
                                            <option value="konseling5">Konseling5</option>
                                            <option value="konseling6">Konseling6</option>
                                            
                                        </select>
                                    </div>
                                    <div class="col-md-3 ">
                                        <label for="kondisi_hidup" style="color: green;">CAR</label>
                                        <select class="form-control" id="kondisi_hidup" name="car">
                                            <option value="" disabled selected>pilih</option>
                                            <option value="car3">CAR3</option>
                                            <option value="car6">CAR6</option>
                                            <option value="car9">CAR9</option>
                                        
                                        </select>
                                    </div>
                                    <div class="col-md-3 ">
                                        <label for="kondisi_hidup" style="color: green;">RUJUK UBM</label>
                                        <select class="form-control" id="kondisi_hidup" name="rujuk_ubm">
                                            <option value="" disabled selected>pilih</option>
                                            <option value="ya">Ya</option>
                                            <option value="tidak">Tidak</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3 ">
                                        <label for="kondisi_hidup" style="color: green;">KONDISI</label>
                                        <select class="form-control" id="kondisi_hidup" name="kondisi">
                                            <option value="" disabled selected>pilih</option>
                                            <option value="sukses">Sukses</option>
                                            <option value="kambuh">Kambuh</option>
                                            <option value="do">DO</option>
                                           
                                        </select>
                                    </div>

                                </div>
                            </div>
                            <div class="container">
                                <div class="row g-2 mt-2">
                                    <div class="col-md-3 ">
                                        <label for="alkohol" style="color: rgb(22, 24, 22);">Konseling Edukasi Kesehatan</label>
                                        <select class="form-control" id="alkohol" name="edukasi">
                                            <option value="" disabled selected>pilih</option>
                                            <option value="konseling1">Konseling1</option>
                                            <option value="konseling2">Konseling2</option>
                                            <option value="konseling3">Konseling3</option>
                                            <option value="konseling4">Konseling4</option>
                                            <option value="konseling5">Konseling5</option>
                                            <option value="konseling6">Konseling6</option>
                                            
                                        </select>
                                    </div>
                                 

                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-4">
                            <label for="alkohol" style="color: rgb(241, 11, 11);">Riwayat Penyakit Tidak Menular Pada Keluarga</label>
                            <select class="form-control" id="alkohol" name="riwayat_penyakit_keluarga">
                                <option value="" disabled selected>pilih</option>
                                @foreach ($penyakit as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="alkohol" style="color: rgb(241, 11, 11);">Riwayat Penyakit Tidak Menular Pada Sendiri</label>
                            <select class="form-control" id="alkohol" name="riwayat_penyakit_tidak_menular">
                                <option value="" disabled selected>pilih</option>
                                @foreach ($penyakit as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="keluhan" style="color: rgb(241, 11, 11);">Keluhan</label>
                            <input type="text" class="form-control" id="keluhan" name="keluhan"
                            placeholder="Kosongkan Bila sehat" >
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-4">
                            <label for="alkohol" style="color: rgb(19, 11, 241);">DIAGNOSA</label>
                            <select class="form-control" id="alkohol" name="diagnosa">
                                <option value="" disabled selected>pilih</option>
                                @foreach ($diagnosa as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="alkohol" style="color: rgb(19, 11, 241);">TINDAKAN</label>
                            <select class="form-control" id="alkohol" name="tindakan">
                                <option value="" disabled selected>pilih</option>
                                <option value="diberikan">Diberikan Obat</option>
                                <option value="tidak">Tidak</option>
                            
                                
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="alkohol" style="color: rgb(19, 11, 241);">RUJUK RS</label>
                            <select class="form-control" id="alkohol" name="rujuk_rs">
                                <option value="" disabled selected>pilih</option>
                                @foreach ($rs as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                                
                            </select>
                        </div>
                    
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-4">
                            <label for="alkohol" style="color: rgb(19, 11, 241);">KETERANGAN</label>
                            <input type="text" class="form-control" id="keterangan" name="keterangan"
                            placeholder="Keterangan jenis Obatnya" required>
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


@include('component.modal-table-pasien')

<script>
    $(document).ready(function() {
        // Set z-index for modalPasien to be higher than addActionModal
        $('#modalPasien').on('show.bs.modal', function() {
            $(this).css('z-index', '2000'); // set a high z-index for modalPasien
        });

        // Remove backdrop when modalPasien is closed
        $('#modalPasien').on('hidden.bs.modal', function() {
            $('.modal-backdrop').not('.modal-stack').remove();
        });
    });
</script>

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
