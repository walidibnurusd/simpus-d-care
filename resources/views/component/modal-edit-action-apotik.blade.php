<!-- Modal Add Action -->
<div class="modal fade" style="z-index: 1050;" id="editActionModal{{ $action->id }}" tabindex="-1"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                @if ($routeName === 'action.apotik.index')
                    <h5 class="modal-title" id="exampleModalLabel">TINDAKAN POLI UMUM</h5>
                @elseif ($routeName === 'action.apotik.gigi.index')
                    <h5 class="modal-title" id="exampleModalLabel">TINDAKAN POLI GIGI</h5>
                @elseif ($routeName === 'action.apotik.kia.index')
                    <h5 class="modal-title" id="exampleModalLabel">TINDAKAN POLI KIA</h5>
                @elseif ($routeName === 'action.apotik.kb.index')
                    <h5 class="modal-title" id="exampleModalLabel">TINDAKAN POLI KB</h5>
                @else
                    <h5 class="modal-title" id="exampleModalLabel">TINDAKAN UGD</h5>
                @endif
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form id="addPatientForm" action="{{ route('action.update.apotik', $action->id) }}" method="POST"
                    class="px-3">
                    @csrf
                    @if ($routeName === 'action.apotik.index')
                        <input type="hidden" name="tipe" value="poli-umum">
                    @elseif($routeName === 'action.apotik.gigi.index')
                        <input type="hidden" name="tipe" value="poli-gigi">
                    @elseif($routeName === 'action.apotik.kia.index')
                        <input type="hidden" name="tipe" value="poli-kia">
                    @elseif($routeName === 'action.apotik.kb.index')
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
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-12" style="margin-bottom: 15px;">
                            <label for="obat" style="color: rgb(19, 11, 241);">Obat</label>
                            <textarea class="form-control" id="obat" name="obat" readonly placeholder="Obat">{{ old('obat', $action->obat ?? '') }}</textarea>
                        </div>
                        <div class="col-md-12">
                            <label for="update_obat" style="color: rgb(19, 11, 241);">Update Obat</label>
                            <textarea class="form-control" id="update_obat" name="update_obat" placeholder="Update Obat">{{ old('update_obat', $action->update_obat ?? '') }}</textarea>
                        </div>
                    </div>
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
    var nikValue = "{{ $action->patient->nik ?? '' }}";
    document.getElementById('nikEdit{{ $action->id }}').value = nikValue;
    console.log(nikValue);
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
