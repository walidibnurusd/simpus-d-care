<!-- Modal Add Action -->
<div class="modal fade" style="z-index: 1050;" id="addActionModal" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                @if ($routeName === 'action.lab.index')
                    <h5 class="modal-title" id="exampleModalLabel">TINDAKAN POLI UMUM</h5>
                @elseif($routeName === 'action.lab.gigi.index')
                    <h5 class="modal-title" id="exampleModalLabel">TINDAKAN POLI GIGI</h5>
                @elseif($routeName === 'action.lab.kia.index')
                    <h5 class="modal-title" id="exampleModalLabel">TINDAKAN POLI KIA</h5>
                @elseif($routeName === 'action.lab.kb.index')
                    <h5 class="modal-title" id="exampleModalLabel">TINDAKAN POLI KB</h5>
                @else
                    <h5 class="modal-title" id="exampleModalLabel">TINDAKAN UGD</h5>
                @endif
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form id="addPatientForm" action="" method="POST" class="px-3">

                    @csrf
                    @if ($routeName === 'action.lab.index')
                        <input type="hidden" name="tipe" id="tipe" value="poli-umum">
                    @elseif($routeName === 'action.lab.gigi.index')
                        <input type="hidden" name="tipe" id="tipe" value="poli-gigi">
                    @elseif($routeName === 'action.lab.kia.index')
                        <input type="hidden" name="tipe" id="tipe" value="poli-kia">
                    @elseif($routeName === 'action.lab.kb.index')
                        <input type="hidden" name="tipe" id="tipe" value="poli-kb">
                    @else
                        <input type="hidden" name="tipe" id="tipe" value="ruang-tindakan">
                    @endif
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
                                                    name="nik" placeholder="NIK" required>
                                                <div class="input-group-append">
                                                    <button class="btn btn-primary" type="button" id="btnCariNIK"
                                                        data-bs-toggle="modal" data-bs-target="#modalPasienLab">
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
                                                placeholder="Pilih Tanggal" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="doctor">Dokter</label>
                                            <select class="form-control" id="doctor" name="doctor" disabled>
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
                                            <select class="form-control" id="kunjungan" name="kunjungan" d>
                                                <option value="" disabled selected>Pilih Jenis Kunjungan
                                                </option>
                                                <option value="baru">Baru </option>
                                                <option value="lama">Lama </option>

                                            </select>
                                        </div>
                                    </div> --}}
                                </div>
                            </div>

                            <div style="display: none; align-items: center; text-align: center;" id="pd">
                                <hr style="flex: 1; border: none; border-top: 1px solid #ccc;">
                                <span style="margin: 0 10px; white-space: nowrap;">Jenis Pemeriksaan Darah</span>
                                <hr style="flex: 1; border: none; border-top: 1px solid #ccc;">
                            </div>
                            <div class="container">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <!-- GDS Field -->
                                        <label for="gds" class="form-label" id="label-gds"
                                            style="display: none;">Hasil GDS</label>
                                        <input class="form-control" type="text" id="gds" name="gds"
                                            placeholder="GDS" style="display: none;">

                                        <!-- GDP Field -->
                                        <label for="gdp" class="form-label" id="label-gdp"
                                            style="display: none;">Hasil GDP</label>
                                        <input class="form-control" type="text" id="gdp" name="gdp"
                                            placeholder="GDP" style="display: none;">

                                        <!-- GDP 2 Jam pp Field -->
                                        <label for="gdp_2_jam_pp" class="form-label" id="label-gdp_2_jam_pp"
                                            style="display: none;">Hasil GDP 2 Jam pp</label>
                                        <input class="form-control" type="text" id="gdp_2_jam_pp"
                                            name="gdp_2_jam_pp" placeholder="GDP 2 Jam pp" style="display: none;">

                                        <!-- Cholesterol Field -->
                                        <label for="cholesterol" class="form-label" id="label-cholesterol"
                                            style="display: none;">Hasil Cholesterol</label>
                                        <input class="form-control" type="text" id="cholesterol"
                                            name="cholesterol" placeholder="Cholesterol" style="display: none;">

                                        <!-- Asam Urat Field -->
                                        <label for="asam_urat" class="form-label" id="label-asam_urat"
                                            style="display: none;">Hasil Asam Urat</label>
                                        <input class="form-control" type="text" id="asam_urat" name="asam_urat"
                                            placeholder="Asam Urat" style="display: none;">

                                        <!-- Leukosit Field -->
                                        <label for="leukosit" class="form-label" id="label-leukosit"
                                            style="display: none;">Hasil Leukosit</label>
                                        <input class="form-control" type="text" id="leukosit" name="leukosit"
                                            placeholder="Leukosit" style="display: none;">

                                        <!-- Eritrosit Field -->
                                        <label for="eritrosit" class="form-label" id="label-eritrosit"
                                            style="display: none;">Hasil Eritrosit</label>
                                        <input class="form-control" type="text" id="eritrosit" name="eritrosit"
                                            placeholder="Eritrosit" style="display: none;">
                                    </div>
                                    <div class="col-md-6">
                                        <!-- Trombosit Field -->
                                        <label for="trombosit" class="form-label" id="label-trombosit"
                                            style="display: none;">Hasil Trombosit</label>
                                        <input class="form-control" type="text" id="trombosit" name="trombosit"
                                            placeholder="Trombosit" style="display: none;">

                                        <!-- Hemoglobin Field -->
                                        <label for="hemoglobin" class="form-label" id="label-hemoglobin"
                                            style="display: none;">Hasil Hemoglobin</label>
                                        <input class="form-control" type="text" id="hemoglobin" name="hemoglobin"
                                            placeholder="Hemoglobin" style="display: none;">

                                        <!-- Sifilis Field -->
                                        <label for="sifilis" class="form-label" id="label-sifilis"
                                            style="display: none;">Hasil Sifilis</label>
                                        <input class="form-control" type="text" id="sifilis" name="sifilis"
                                            placeholder="Sifilis" style="display: none;">

                                        <!-- HIV Field -->
                                        <label for="hiv" class="form-label" id="label-hiv"
                                            style="display: none;">Hasil HIV</label>
                                        <input class="form-control" type="text" id="hiv" name="hiv"
                                            placeholder="HIV" style="display: none;">

                                        <!-- Golongan Darah Field -->
                                        <label for="golongan_darah" class="form-label" id="label-golongan_darah"
                                            style="display: none;">Hasil Golongan Darah</label>
                                        <input class="form-control" type="text" id="golongan_darah"
                                            name="golongan_darah" placeholder="Golongan Darah"
                                            style="display: none;">

                                        <!-- Widal Field -->
                                        <label for="widal" class="form-label" id="label-widal"
                                            style="display: none;">Hasil Widal</label>
                                        <input class="form-control" type="text" id="widal" name="widal"
                                            placeholder="Widal" style="display: none;">

                                        <!-- Malaria Field -->
                                        <label for="malaria" class="form-label" id="label-malaria"
                                            style="display: none;">Hasil Malaria</label>
                                        <input class="form-control" type="text" id="malaria" name="malaria"
                                            placeholder="Malaria" style="display: none;">
                                    </div>
                                </div>
                            </div>

                            <div style="display: none; align-items: center; text-align: center;" id="pu">
                                <hr style="flex: 1; border: none; border-top: 1px solid #ccc;">
                                <span style="margin: 0 10px; white-space: nowrap;">Jenis Pemeriksaan URINE</span>
                                <hr style="flex: 1; border: none; border-top: 1px solid #ccc;">
                            </div>
                            <div class="container">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <!-- Albumin Field -->
                                        <label for="albumin" class="form-label" id="label-albumin"
                                            style="display: none;">Hasil Albumin</label>
                                        <input class="form-control" type="text" id="albumin" name="albumin"
                                            placeholder="Albumin" style="display: none;">

                                        <!-- Reduksi Field -->
                                        <label for="reduksi" class="form-label" id="label-reduksi"
                                            style="display: none;">Hasil Reduksi</label>
                                        <input class="form-control" type="text" id="reduksi" name="reduksi"
                                            placeholder="Reduksi" style="display: none;">
                                    </div>
                                    <div class="col-md-6">
                                        <!-- Urinalisa Field -->
                                        <label for="urinalisa" class="form-label" id="label-urinalisa"
                                            style="display: none;">Hasil Urinalisa</label>
                                        <input class="form-control" type="text" id="urinalisa" name="urinalisa"
                                            placeholder="Urinalisa" style="display: none;">

                                        <!-- Tes Kehamilan Field -->
                                        <label for="tes_kehamilan" class="form-label" id="label-tes_kehamilan"
                                            style="display: none;">Hasil Tes Kehamilan</label>
                                        <input class="form-control" type="text" id="tes_kehamilan"
                                            name="tes_kehamilan" placeholder="Tes Kehamilan" style="display: none;">
                                    </div>
                                </div>
                            </div>

                            <div style="display: none; align-items: center; text-align: center;" id="pf">
                                <hr style="flex: 1; border: none; border-top: 1px solid #ccc;">
                                <span style="margin: 0 10px; white-space: nowrap;">Jenis Pemeriksaan FESES</span>
                                <hr style="flex: 1; border: none; border-top: 1px solid #ccc;">
                            </div>
                            <div class="container">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <!-- Telur Cacing Field -->
                                        <label for="telur_cacing" class="form-label" id="label-telur_cacing"
                                            style="display: none;">Hasil Telur Cacing</label>
                                        <input class="form-control" type="text" id="telur_cacing"
                                            name="telur_cacing" placeholder="Telur Cacing" style="display: none;">
                                    </div>
                                    <div class="col-md-6">
                                        <!-- BTA Field -->
                                        <label for="bta" class="form-label" id="label-bta"
                                            style="display: none;">Hasil BTA</label>
                                        <input class="form-control" type="text" id="bta" name="bta"
                                            placeholder="BTA" style="display: none;">
                                    </div>
                                </div>
                            </div>

                            <div style="display: none; align-items: center; text-align: center;" id="pi">
                                <hr style="flex: 1; border: none; border-top: 1px solid #ccc;">
                                <span style="margin: 0 10px; white-space: nowrap;">Pemeriksaan IgM</span>
                                <hr style="flex: 1; border: none; border-top: 1px solid #ccc;">
                            </div>
                            <div class="container">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <!-- IgM DBD Field -->
                                        <label for="igm_dbd" class="form-label" id="label-igm_dbd"
                                            style="display: none;">Hasil IgM DBD</label>
                                        <input class="form-control" type="text" id="igm_dbd" name="igm_dbd"
                                            placeholder="IgM DBD" style="display: none;">
                                    </div>
                                    <div class="col-md-6">
                                        <!-- IgM Typhoid Field -->
                                        <label for="igm_typhoid" class="form-label" id="label-igm_typhoid"
                                            style="display: none;">Hasil IgM Typhoid</label>
                                        <input class="form-control" type="text" id="igm_typhoid"
                                            name="igm_typhoid" placeholder="IgM Typhoid" style="display: none;">
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    {{-- <div class="row mt-3">
                        <div class="col-md-12" style="margin-bottom: 15px;">
                            <label for="pemeriksaan_penunjang" style="color: rgb(19, 11, 241);">Pemeriksaan
                                Penunjang</label>
                            <textarea class="form-control" id="pemeriksaan_penunjang" name="pemeriksaan_penunjang" readonly
                                placeholder="Pemeriksaan Penunjang"></textarea>
                        </div>
                        <div class="col-md-12">
                            <label for="hasil_lab" style="color: rgb(19, 11, 241);">Hasil Laboratorium</label>
                            <textarea class="form-control" id="hasil_lab" name="hasil_lab" placeholder="Hasil Laboratorium"></textarea>
                        </div>
                    </div> --}}





            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-primary" data-bs-toggle="modal"
                    data-bs-target="#modalPasienLab">Simpan Data</button>
                </form>
            </div>
        </div>

    </div>

</div>


@include('component.modal-table-pasien-lab')





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
