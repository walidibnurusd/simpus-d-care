<!-- Modal Add Action -->
<div class="modal fade" style="z-index: 1050;" id="editActionModal{{ $action->id }}" tabindex="-1"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                @if ($routeName === 'action.lab.index')
                    <h5 class="modal-title" id="exampleModalLabel">TINDAKAN POLI UMUM</h5>
                @elseif ($routeName === 'action.lab.gigi.index')
                    <h5 class="modal-title" id="exampleModalLabel">TINDAKAN POLI GIGI</h5>
                @elseif ($routeName === 'action.lab.kia.index')
                    <h5 class="modal-title" id="exampleModalLabel">TINDAKAN POLI KIA</h5>
                @elseif ($routeName === 'action.lab.kb.index')
                    <h5 class="modal-title" id="exampleModalLabel">TINDAKAN POLI KB</h5>
                @else
                    <h5 class="modal-title" id="exampleModalLabel">TINDAKAN UGD</h5>
                @endif
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form id="addPatientForm" action="{{ route('action.update.lab', $action->id) }}" method="POST"
                    class="px-3">
                    @csrf
                    @if ($routeName === 'action.lab.index')
                        <input type="hidden" name="tipe" value="poli-umum">
                    @elseif($routeName === 'action.lab.gigi.index')
                        <input type="hidden" name="tipe" value="poli-gigi">
                    @elseif($routeName === 'action.lab.kia.index')
                        <input type="hidden" name="tipe" value="poli-kia">
                    @elseif($routeName === 'action.lab.kb.index')
                        <input type="hidden" name="tipe" value="poli-kb">
                    @else
                        <input type="hidden" name="tipe" value="ruang-tindakan">
                    @endif
                    <div class="row">
                        <div class="col-4">
                            <h5>Detail Pasien</h5>
                            <div id="patientDetailsEdit" style=" margin-top: 10px; padding: 10px; border-radius: 5px;">
                                <p><strong>N I K</strong> : <span
                                        id="NIK{{ $action->id }}">{{ $action->patient->nik }}</span></p>
                                <p><strong>Nama Pasien</strong> : <span
                                        id="Name{{ $action->id }}">{{ $action->patient->name }}</span></p>
                                {{-- <p><strong>J.Kelamin</strong> : <span id="Gender">{{ $action->patient->genderName->name }}</span></p> --}}
                                <p><strong>Umur</strong> : <span id="Age"></span>
                                    {{ \Carbon\Carbon::parse($action->patient->dob)->age }}</p>
                                <p><strong>Telepon/WA</strong> : <span
                                        id="Phone{{ $action->id }}">{{ $action->patient->phone }}</span></p>
                                <p><strong>Alamat</strong> : <span id="Address">{{ $action->patient->address }}</span>
                                </p>
                                <p><strong>Darah</strong> : <span
                                        id="Blood{{ $action->id }}">{{ $action->patient->blood_type }}</span></p>
                                <p><strong>Nomor RM</strong> : <span
                                        id="RmNumber{{ $action->id }}">{{ $action->patient->no_rm }}</span>
                                </p>
                            </div>

                        </div>

                        <div class="row col-8">
                            <div class="col-12">
                                <div class="row g-2">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="nik">Cari Pasien</label>
                                            <div class="input-group">
                                                <input readonly type="text" class="form-control"
                                                    id="nikEdit{{ $action->id }}" value="" name="nik"
                                                    placeholder="NIK" required>
                                                <div class="input-group-append">
                                                    <button class="btn btn-primary" type="button" id="btnCariNIK"
                                                        data-bs-toggle="modal" data-bs-target="#modalPasienEdit">
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
                                                value="{{ $action->tanggal }}" placeholder="Pilih Tanggal" required>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="doctor">Dokter</label>
                                            <select class="form-control" id="doctor" name="doctor" required>
                                                <option value="" disabled selected>Pilih Dokter</option>
                                                @foreach ($dokter as $item)
                                                    <option value="{{ $item->name }}"
                                                        {{ $action->doctor == $item->name ? 'selected' : '' }}>
                                                        {{ $item->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    {{-- <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="kunjungan">Kunjungan</label>
                                            <select class="form-control" id="kunjungan" name="kunjungan" required>
                                                <option value="" disabled
                                                    {{ empty($action->kunjungan) ? 'selected' : '' }}>Pilih Jenis
                                                    Kunjungan</option>
                                                <option value="baru"
                                                    {{ $action->kunjungan == 'baru' ? 'selected' : '' }}>Baru</option>
                                                <option value="lama"
                                                    {{ $action->kunjungan == 'lama' ? 'selected' : '' }}>Lama</option>
                                            </select>
                                        </div>
                                    </div> --}}
                                </div>
                            </div>

                            <div style="display: none; align-items: center; text-align: center;"
                                id="pd{{ $action->id }}">
                                <hr style="flex: 1; border: none; border-top: 1px solid #ccc;">
                                <span style="margin: 0 10px; white-space: nowrap;">Jenis Pemeriksaan Darah</span>
                                <hr style="flex: 1; border: none; border-top: 1px solid #ccc;">
                            </div>
                            <div class="container">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <!-- GDS Field -->
                                        <label for="gds" class="form-label" id="label-gds{{ $action->id }}"
                                            style="display: none;">Hasil GDS</label>
                                        <input class="form-control" type="text" id="gds{{ $action->id }}"
                                            value="{{ $action->hasilLab->gds ?? '' }}" name="gds"
                                            placeholder="GDS" style="display: none;">

                                        <!-- GDP Field -->
                                        <label for="gdp" class="form-label" id="label-gdp{{ $action->id }}"
                                            style="display: none;">Hasil GDP</label>
                                        <input class="form-control" type="text" id="gdp{{ $action->id }}"
                                            value="{{ $action->hasilLab->gdp ?? '' }}" name="gdp"
                                            placeholder="GDP" style="display: none;">

                                        <!-- GDP 2 Jam pp Field -->
                                        <label for="gdp_2_jam_pp" class="form-label"
                                            id="label-gdp_2_jam_pp{{ $action->id }}" style="display: none;">Hasil
                                            GDP 2
                                            Jam pp</label>
                                        <input class="form-control" type="text"
                                            id="gdp_2_jam_pp{{ $action->id }}"
                                            value="{{ $action->hasilLab->gdp_2_jam_pp ?? '' }}" name="gdp_2_jam_pp"
                                            placeholder="GDP 2 Jam pp" style="display: none;">

                                        <!-- Cholesterol Field -->
                                        <label for="cholesterol" class="form-label"
                                            id="label-cholesterol{{ $action->id }}" style="display: none;">Hasil
                                            Cholesterol</label>
                                        <input class="form-control" type="text"
                                            id="cholesterol{{ $action->id }}"
                                            value="{{ $action->hasilLab->cholesterol ?? '' }}" name="cholesterol"
                                            placeholder="Cholesterol" style="display: none;">

                                        <!-- Asam Urat Field -->
                                        <label for="asam_urat" class="form-label"
                                            id="label-asam_urat{{ $action->id }}" style="display: none;">Hasil Asam
                                            Urat</label>
                                        <input class="form-control" type="text"
                                            id="asam_urat{{ $action->id }}"value="{{ $action->hasilLab->asam_urat ?? '' }}"
                                            name="asam_urat" placeholder="Asam Urat" style="display: none;">

                                        <!-- Leukosit Field -->
                                        <label for="leukosit" class="form-label"
                                            id="label-leukosit{{ $action->id }}" style="display: none;">Hasil
                                            Leukosit</label>
                                        <input class="form-control" type="text" id="leukosit{{ $action->id }}"
                                            value="{{ $action->hasilLab->leukosit ?? '' }}" name="leukosit"
                                            placeholder="Leukosit" style="display: none;">

                                        <!-- Eritrosit Field -->
                                        <label for="eritrosit" class="form-label"
                                            id="label-eritrosit{{ $action->id }}" style="display: none;">Hasil
                                            Eritrosit</label>
                                        <input class="form-control" type="text" id="eritrosit{{ $action->id }}"
                                            value="{{ $action->hasilLab->eritrosit ?? '' }}" name="eritrosit"
                                            placeholder="Eritrosit" style="display: none;">
                                    </div>
                                    <div class="col-md-6">
                                        <!-- Trombosit Field -->
                                        <label for="trombosit" class="form-label"
                                            id="label-trombosit{{ $action->id }}" style="display: none;">Hasil
                                            Trombosit</label>
                                        <input class="form-control" type="text" id="trombosit{{ $action->id }}"
                                            value="{{ $action->hasilLab->trombosit ?? '' }}" name="trombosit"
                                            placeholder="Trombosit" style="display: none;">

                                        <!-- Hemoglobin Field -->
                                        <label for="hemoglobin" class="form-label"
                                            id="label-hemoglobin{{ $action->id }}" style="display: none;">Hasil
                                            Hemoglobin</label>
                                        <input class="form-control" type="text"
                                            id="hemoglobin{{ $action->id }}"
                                            value="{{ $action->hasilLab->hemoglobin ?? '' }}" name="hemoglobin"
                                            placeholder="Hemoglobin" style="display: none;">

                                        <!-- Sifilis Field -->
                                        <label for="sifilis" class="form-label"
                                            id="label-sifilis{{ $action->id }}" style="display: none;">Hasil
                                            Sifilis</label>
                                        <input class="form-control" type="text" id="sifilis{{ $action->id }}"
                                            value="{{ $action->hasilLab->sifilis ?? '' }}" name="sifilis"
                                            placeholder="Sifilis" style="display: none;">

                                        <!-- HIV Field -->
                                        <label for="hiv" class="form-label" id="label-hiv{{ $action->id }}"
                                            style="display: none;">Hasil HIV</label>
                                        <input class="form-control" type="text" id="hiv{{ $action->id }}"
                                            value="{{ $action->hasilLab->hiv ?? '' }}" name="hiv"
                                            placeholder="HIV" style="display: none;">

                                        <!-- Golongan Darah Field -->
                                        <label for="golongan_darah" class="form-label"
                                            id="label-golongan_darah{{ $action->id }}" style="display: none;">Hasil
                                            Golongan Darah</label>
                                        <input class="form-control" type="text"
                                            id="golongan_darah{{ $action->id }}"
                                            value="{{ $action->hasilLab->golongan_darah ?? '' }}"
                                            name="golongan_darah" placeholder="Golongan Darah"
                                            style="display: none;">

                                        <!-- Widal Field -->
                                        <label for="widal" class="form-label" id="label-widal{{ $action->id }}"
                                            style="display: none;">Hasil Widal</label>
                                        <input class="form-control" type="text" id="widal{{ $action->id }}"
                                            value="{{ $action->hasilLab->widal ?? '' }}" name="widal"
                                            placeholder="Widal" style="display: none;">

                                        <!-- Malaria Field -->
                                        <label for="malaria" class="form-label"
                                            id="label-malaria{{ $action->id }}" style="display: none;">Hasil
                                            Malaria</label>
                                        <input class="form-control" type="text" id="malaria{{ $action->id }}"
                                            value="{{ $action->hasilLab->malaria ?? '' }}" name="malaria"
                                            placeholder="Malaria" style="display: none;">
                                    </div>
                                </div>
                            </div>

                            <div style="display: none; align-items: center; text-align: center;"
                                id="pu{{ $action->id }}">
                                <hr style="flex: 1; border: none; border-top: 1px solid #ccc;">
                                <span style="margin: 0 10px; white-space: nowrap;">Jenis Pemeriksaan URINE</span>
                                <hr style="flex: 1; border: none; border-top: 1px solid #ccc;">
                            </div>
                            <div class="container">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <!-- Albumin Field -->
                                        <label for="albumin" class="form-label"
                                            id="label-albumin{{ $action->id }}" style="display: none;">Hasil
                                            Albumin</label>
                                        <input class="form-control" type="text" id="albumin{{ $action->id }}"
                                            value="{{ $action->hasilLab->albumin ?? '' }}" name="albumin"
                                            placeholder="Albumin" style="display: none;">

                                        <!-- Reduksi Field -->
                                        <label for="reduksi" class="form-label"
                                            id="label-reduksi{{ $action->id }}" style="display: none;">Hasil
                                            Reduksi</label>
                                        <input class="form-control" type="text" id="reduksi{{ $action->id }}"
                                            value="{{ $action->hasilLab->reduksi ?? '' }}" name="reduksi"
                                            placeholder="Reduksi" style="display: none;">
                                    </div>
                                    <div class="col-md-6">
                                        <!-- Urinalisa Field -->
                                        <label for="urinalisa" class="form-label"
                                            id="label-urinalisa{{ $action->id }}" style="display: none;">Hasil
                                            Urinalisa</label>
                                        <input class="form-control" type="text" id="urinalisa{{ $action->id }}"
                                            value="{{ $action->hasilLab->urinalisa ?? '' }}" name="urinalisa"
                                            placeholder="Urinalisa" style="display: none;">

                                        <!-- Tes Kehamilan Field -->
                                        <label for="tes_kehamilan" class="form-label"
                                            id="label-tes_kehamilan{{ $action->id }}" style="display: none;">Hasil
                                            Tes
                                            Kehamilan</label>
                                        <input class="form-control" type="text"
                                            id="tes_kehamilan{{ $action->id }}"
                                            value="{{ $action->hasilLab->tes_kehamilan ?? '' }}" name="tes_kehamilan"
                                            placeholder="Tes Kehamilan" style="display: none;">
                                    </div>
                                </div>
                            </div>

                            <div style="display: none; align-items: center; text-align: center;"
                                id="pf{{ $action->id }}">
                                <hr style="flex: 1; border: none; border-top: 1px solid #ccc;">
                                <span style="margin: 0 10px; white-space: nowrap;">Jenis Pemeriksaan FESES</span>
                                <hr style="flex: 1; border: none; border-top: 1px solid #ccc;">
                            </div>
                            <div class="container">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <!-- Telur Cacing Field -->
                                        <label for="telur_cacing" class="form-label"
                                            id="label-telur_cacing{{ $action->id }}" style="display: none;">Hasil
                                            Telur
                                            Cacing</label>
                                        <input class="form-control" type="text"
                                            id="telur_cacing{{ $action->id }}"
                                            value="{{ $action->hasilLab->telur_cacing ?? '' }}" name="telur_cacing"
                                            placeholder="Telur Cacing" style="display: none;">
                                    </div>
                                    <div class="col-md-6">
                                        <!-- BTA Field -->
                                        <label for="bta" class="form-label" id="label-bta{{ $action->id }}"
                                            style="display: none;">Hasil BTA</label>
                                        <input class="form-control" type="text" id="bta{{ $action->id }}"
                                            value="{{ $action->hasilLab->bta ?? '' }}" name="bta"
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
                                        <label for="igm_dbd" class="form-label"
                                            id="label-igm_dbd{{ $action->id }}" style="display: none;">Hasil IgM
                                            DBD</label>
                                        <input class="form-control" type="text" id="igm_dbd{{ $action->id }}"
                                            value="{{ $action->hasilLab->igm_dbd ?? '' }}" name="igm_dbd"
                                            placeholder="IgM DBD" style="display: none;">
                                    </div>
                                    <div class="col-md-6">
                                        <!-- IgM Typhoid Field -->
                                        <label for="igm_typhoid" class="form-label"
                                            id="label-igm_typhoid{{ $action->id }}" style="display: none;">Hasil
                                            IgM
                                            Typhoid</label>
                                        <input class="form-control" type="text"
                                            id="igm_typhoid{{ $action->id }}"
                                            value="{{ $action->hasilLab->igm_typhoid ?? '' }}" name="igm_typhoid"
                                            placeholder="IgM Typhoid" style="display: none;">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        {{-- <div class="col-md-12" style="margin-bottom: 15px;">
                            <label for="pemeriksaan_penunjang" style="color: rgb(19, 11, 241);">Pemeriksaan
                                Penunjang</label>
                            <textarea class="form-control" id="pemeriksaan_penunjang" name="pemeriksaan_penunjang" readonly
                                placeholder="Pemeriksaan Penunjang">{{ old('pemeriksaan_penunjang', $action->pemeriksaan_penunjang ?? '') }}</textarea>
                        </div>
                        <div class="col-md-12">
                            <label for="hasil_lab" style="color: rgb(19, 11, 241);">Hasil Laboratorium</label>
                            <textarea class="form-control" id="hasil_lab" name="hasil_lab" placeholder="Hasil Laboratorium">{{ old('hasil_lab', $action->hasil_lab ?? '') }}</textarea>
                        </div>
                    </div> --}}
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-primary">Simpan Data</button>
                        </div>
                </form>
            </div>
        </div>
    </div>

</div>


@include('component.modal-table-edit-pasien')

<script>
    // Set NIK value
    var nikValue = "{{ $action->patient->nik ?? '' }}";
    document.getElementById('nikEdit{{ $action->id }}').value = nikValue;
    console.log(nikValue);

    // Helper function to toggle display for elements
    function toggleDisplay(labelId, inputId, containerId) {
        document.getElementById(labelId).style.display = "block";
        document.getElementById(inputId).style.display = "block";
        document.getElementById(containerId).style.display = "flex";
    }

    // Check if hasilLab object is not null
    var hasilLab = @json($action->hasilLab);

    if (hasilLab) {
        if (hasilLab.gds !== null) toggleDisplay("label-gds{{ $action->id }}", "gds{{ $action->id }}",
            "pd{{ $action->id }}");
        if (hasilLab.gdp !== null) toggleDisplay("label-gdp{{ $action->id }}", "gdp{{ $action->id }}",
            "pd{{ $action->id }}");
        if (hasilLab.gdp_2_jam_pp !== null) toggleDisplay("label-gdp_2_jam_pp{{ $action->id }}",
            "gdp_2_jam_pp{{ $action->id }}", "pd{{ $action->id }}");
        if (hasilLab.cholesterol !== null) toggleDisplay("label-cholesterol{{ $action->id }}",
            "cholesterol{{ $action->id }}", "pd{{ $action->id }}");
        if (hasilLab.asam_urat !== null) toggleDisplay("label-asam_urat{{ $action->id }}",
            "asam_urat{{ $action->id }}", "pd{{ $action->id }}");
        if (hasilLab.leukosit !== null) toggleDisplay("label-leukosit{{ $action->id }}",
            "leukosit{{ $action->id }}", "pd{{ $action->id }}");
        if (hasilLab.eritrosit !== null) toggleDisplay("label-eritrosit{{ $action->id }}",
            "eritrosit{{ $action->id }}", "pd{{ $action->id }}");
        if (hasilLab.trombosit !== null) toggleDisplay("label-trombosit{{ $action->id }}",
            "trombosit{{ $action->id }}", "pd{{ $action->id }}");
        if (hasilLab.hemoglobin !== null) toggleDisplay("label-hemoglobin{{ $action->id }}",
            "hemoglobin{{ $action->id }}", "pd{{ $action->id }}");
        if (hasilLab.sifilis !== null) toggleDisplay("label-sifilis{{ $action->id }}",
            "sifilis{{ $action->id }}", "pd{{ $action->id }}");
        if (hasilLab.hiv !== null) toggleDisplay("label-hiv{{ $action->id }}", "hiv{{ $action->id }}",
            "pd{{ $action->id }}");
        if (hasilLab.golongan_darah !== null) toggleDisplay("label-golongan_darah{{ $action->id }}",
            "golongan_darah{{ $action->id }}", "pd{{ $action->id }}");
        if (hasilLab.widal !== null) toggleDisplay("label-widal{{ $action->id }}", "widal{{ $action->id }}",
            "pd{{ $action->id }}");
        if (hasilLab.malaria !== null) toggleDisplay("label-malaria{{ $action->id }}",
            "malaria{{ $action->id }}", "pd{{ $action->id }}");
        if (hasilLab.albumin !== null) toggleDisplay("label-albumin{{ $action->id }}",
            "albumin{{ $action->id }}", "pu{{ $action->id }}");
        if (hasilLab.reduksi !== null) toggleDisplay("label-reduksi{{ $action->id }}",
            "reduksi{{ $action->id }}", "pu{{ $action->id }}");
        if (hasilLab.urinalisa !== null) toggleDisplay("label-urinalisa{{ $action->id }}",
            "urinalisa{{ $action->id }}", "pu{{ $action->id }}");
        if (hasilLab.tes_kehamilan !== null) toggleDisplay("label-tes_kehamilan{{ $action->id }}",
            "tes_kehamilan{{ $action->id }}", "pu{{ $action->id }}");
        if (hasilLab.telur_cacing !== null) toggleDisplay("label-telur_cacing{{ $action->id }}",
            "telur_cacing{{ $action->id }}", "pf{{ $action->id }}");
        if (hasilLab.bta !== null) toggleDisplay("label-bta{{ $action->id }}", "bta{{ $action->id }}",
            "pf{{ $action->id }}");
        if (hasilLab.igm_dbd !== null) toggleDisplay("label-igm_dbd{{ $action->id }}",
            "igm_dbd{{ $action->id }}", "pi{{ $action->id }}");
        if (hasilLab.igm_typhoid !== null) toggleDisplay("label-igm_typhoid{{ $action->id }}",
            "igm_typhoid{{ $action->id }}", "pi{{ $action->id }}");
    }
</script>



<script>
    $(document).ready(function() {
        $('#diagnosaEdit').select2({
            placeholder: "Pilih",
            allowClear: true,
            minimumResultsForSearch: 0
        });
    });
    $(document).ready(function() {
        $('#tindakanEdit').select2({
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
        // Attach event listeners dynamically for all modal edit elements
        const allModals = document.querySelectorAll('.modal'); // Semua modal yang memiliki form edit
        allModals.forEach((modal) => {
            const selectPenyakitDulu = modal.querySelector('[id^="riwayat_penyakit_dulu_edit"]');
            const selectPenyakitKeluarga = modal.querySelector(
                '[id^="riwayat_penyakit_keluarga_edit"]');

            // Container untuk input "lainnya"
            const lainnyaContainer = modal.querySelector('#penyakit_lainnya_container_edit');
            const lainnyaTextarea = modal.querySelector('#penyakit_lainnya_edit');

            const lainnyaKeluargaContainer = modal.querySelector(
                '#penyakit_lainnya_keluarga_container_edit');
            const lainnyaKeluargaTextarea = modal.querySelector('#penyakit_lainnya_keluarga_edit');

            if (selectPenyakitDulu) {
                // Event listener untuk 'riwayat_penyakit_dulu_edit'
                selectPenyakitDulu.addEventListener('change', function() {
                    toggleLainnya(selectPenyakitDulu, lainnyaContainer, lainnyaTextarea);
                });
            }

            if (selectPenyakitKeluarga) {
                // Event listener untuk 'riwayat_penyakit_keluarga_edit'
                selectPenyakitKeluarga.addEventListener('change', function() {
                    toggleLainnya(selectPenyakitKeluarga, lainnyaKeluargaContainer,
                        lainnyaKeluargaTextarea);
                });
            }

            // Populate form data on modal show
            modal.addEventListener('show.bs.modal', function() {
                populateFormData(
                    modal,
                    selectPenyakitDulu,
                    lainnyaContainer,
                    lainnyaTextarea,
                    'riwayat_penyakit_dulu'
                );
                populateFormData(
                    modal,
                    selectPenyakitKeluarga,
                    lainnyaKeluargaContainer,
                    lainnyaKeluargaTextarea,
                    'riwayat_penyakit_keluarga'
                );
            });
        });
    });

    // Fungsi toggle "lainnya"
    function toggleLainnya(select, container, textarea) {
        if (select.value === 'lainnya') {
            container.style.display = 'block';
            textarea.required = true;
        } else {
            container.style.display = 'none';
            textarea.value = '';
            textarea.required = false;
        }
    }

    // Populate data berdasarkan modal
    function populateFormData(modal, selectElement, container, textarea, field) {
        const actionId = modal.getAttribute('id').replace('editActionModal', ''); // Ambil ID tindakan dari modal
        const actions = {!! json_encode($actions ?? []) !!}; // Semua data tindakan dari Laravel

        const actionData = actions.find((action) => action.id.toString() === actionId);

        if (actionData && actionData[field]) {
            selectElement.value = actionData[field];
            toggleLainnya(selectElement, container, textarea);

            if (actionData[field] === 'lainnya' && actionData[`${field}_lainnya`]) {
                textarea.value = actionData[`${field}_lainnya`];
            }
        }
    }
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
