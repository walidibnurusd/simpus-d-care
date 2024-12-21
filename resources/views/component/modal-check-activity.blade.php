<div class="modal fade" id="checkActivityModal{{ $activity->id }}" tabindex="-1"
    aria-labelledby="modalLabel{{ $activity->id }}" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ $activity->activity->name }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="max-height: 75vh; overflow-y: auto;">
                <form id="addActivityForm{{ $activity->id }}" action="{{ route('activityMonitoring.store') }}"
                    method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="activity_id" value="{{ $activity->id }}">
                    <div class="row g-2">
                        <div class="col-md-12">
                            <div
                                style="display: grid; grid-template-columns: 150px 10px 1fr; gap: 5px; text-align: left;">
                                <div><strong>Tanggal</strong></div>
                                <div>:</div>
                                <div>{{ \Carbon\Carbon::parse($activity->date)->format('d-m-Y') }}</div>

                                <div><strong>Lokasi</strong></div>
                                <div>:</div>
                                <div>{{ $activity->location }}</div>

                                <div><strong>Anggota Tim</strong></div>
                                <div>:</div>
                                <div>
                                    @if (!empty($activity->employeesActivity))
                                        @foreach ($activity->employeesActivity as $employeeActivity)
                                            {{ $employeeActivity['employee']['name'] }}{{ !$loop->last ? ',' : '' }}
                                        @endforeach
                                    @else
                                        -
                                    @endif
                                </div>
                                <div><strong>Ket/Hasil Kegiatan</strong></div>
                                <div>:</div>
                                <div>{{ $activity->proofActivity[0]->value }}</div>
                                <div><strong>Saran</strong></div>
                                <div>:</div>
                                <div>{{ $activity->proofActivity[0]->advice }}</div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3 mt-1">


                        @if (!empty($activity->proofActivity[0]->image))
                            <img id="imgPreview" src="{{ asset('storage/' . $activity->proofActivity[0]->image) }}"
                                alt="Foto Saat Ini" class="img-fluid mb-3" style="max-height: 200px;">
                        @else
                            <p class="mt-2">Preview Foto:</p>
                            <img id="imgPreview" src="#" alt="Preview Foto" class="img-fluid mb-3"
                                style="max-height: 200px; display: none;">
                        @endif
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <div><strong>Foto ?</strong></div>
                                <select class="form-select" id="photo" name="photo">
                                    <option value="" disabled
                                        {{ !isset($activity->checkActivity) || is_null($activity->checkActivity->photo) ? 'selected' : '' }}>
                                        Pilih</option>
                                    <option value="1"
                                        {{ isset($activity->checkActivity) && $activity->checkActivity->photo == '1' ? 'selected' : '' }}>
                                        YA Ada</option>
                                    <option value="0"
                                        {{ isset($activity->checkActivity) && $activity->checkActivity->photo == '0' ? 'selected' : '' }}>
                                        Tidak Ada</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="mb-3">
                                <div><strong>Surat Tugas ?</strong></div>
                                <select class="form-select" id="letter_assign" name="letter_assign">
                                    <option value="" disabled
                                        {{ !isset($activity->checkActivity) || is_null($activity->checkActivity->letter_assign) ? 'selected' : '' }}>
                                        Pilih</option>
                                    <option value="1"
                                        {{ isset($activity->checkActivity) && $activity->checkActivity->letter_assign == '1' ? 'selected' : '' }}>
                                        YA Ada</option>
                                    <option value="0"
                                        {{ isset($activity->checkActivity) && $activity->checkActivity->letter_assign == '0' ? 'selected' : '' }}>
                                        Tidak Ada</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="mb-3">
                                <div><strong>Dokumen/LPJ ?</strong></div>
                                <select class="form-select" id="document" name="document">
                                    <option value="" disabled
                                        {{ !isset($activity->checkActivity) || is_null($activity->checkActivity->document) ? 'selected' : '' }}>
                                        Pilih</option>
                                    <option value="1"
                                        {{ isset($activity->checkActivity) && $activity->checkActivity->document == '1' ? 'selected' : '' }}>
                                        YA Ada</option>
                                    <option value="0"
                                        {{ isset($activity->checkActivity) && $activity->checkActivity->document == '0' ? 'selected' : '' }}>
                                        Tidak Ada</option>
                                </select>
                            </div>
                        </div>



                    </div>
                    <div class="d-flex justify-content-start">
                        <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger">Simpan</button>
                    </div>
                </form>

                <div class="mt-4">
                    <table id="proofTable{{ $activity->id }}" class="display small" style="width: 100%;">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>NIK</th>
                                <th>Nama</th>
                                <th>Telp</th>
                                <th>Jenis Kelamin</th>
                                <th>Umur</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($activity->proofActivity as $proof)
                                @foreach ($proof->patients as $item)
                                    @php
                                        $patient = \App\Models\Patients::with('genderName')
                                            ->where('id', $item->patient_id)
                                            ->first();
                                    @endphp

                                    <tr data-patient="{{ json_encode($patient) }}">
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $patient->nik }}</td>
                                        <td>{{ $patient->name }}</td>
                                        <td>{{ $patient->phone }}</td>
                                        <td>{{ $patient->genderName->name }}</td>
                                        <td>
                                            {{ \Carbon\Carbon::parse($patient->dob)->age }} tahun
                                        </td>

                                        <td>{{ $item->description }}</td>

                                    </tr>
                                @endforeach
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@include('component.modal-add-activity-patient')

<script>
    var $j = jQuery.noConflict();

    $j('#proofTable{{ $activity->id }}').DataTable({
        "language": {
            "info": "_PAGE_ dari _PAGES_ halaman",
            "paginate": {
                "previous": "<",
                "next": ">",
                "first": "<<",
                "last": ">>"
            }
        },
        "responsive": true,
        "lengthMenu": [10, 25, 50, 100]
    });

    document.getElementById('proofFile').addEventListener('change', function() {
        const [file] = this.files;
        const imgPreview = document.getElementById('imgPreview');
        if (file) {
            imgPreview.src = URL.createObjectURL(file);
            imgPreview.style.display = 'block';
        } else {
            imgPreview.style.display = 'none';
        }
    });


    $j('.btn-delete-modal-proof').off('click').on('click', function() {
        var proofId = $j(this).data('id');

        if (confirm('Are you sure you want to delete this proof?')) {
            $j.ajax({
                url: '{{ route('activityEmployee.deleteProof') }}',
                type: 'POST',
                data: {
                    id: proofId,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        alert(response.message);
                        location.reload(); // Reload the page to see changes
                    } else {
                        alert('Failed to delete proof: ' + response.message);
                    }
                },
                error: function(xhr, status, error) {
                    alert('An error occurred: ' + error);
                }
            });
        }
    });



    document.addEventListener('DOMContentLoaded', function() {
        var proofActivityModal = new bootstrap.Modal(document.getElementById(
            'proofActivityModal{{ $activity->id }}'));
        var addPatientActivityModal = new bootstrap.Modal(document.getElementById(
            'addPatientActivityModal{{ $activity->id }}'));
        var patientsActivityModal = new bootstrap.Modal(document.getElementById(
            'patientsActivityModal{{ $activity->id }}'));

        var isPatientsModalActive = false;

        document.getElementById('addPatientBtn{{ $activity->id }}').addEventListener('click', function() {
            proofActivityModal.hide();
            addPatientActivityModal.show();
        });

        addPatientActivityModal._element.addEventListener('hidden.bs.modal', function() {
            if (!isPatientsModalActive) {
                proofActivityModal.show();
            }
        });

        document.getElementById('searchPatientBtn{{ $activity->id }}').addEventListener('click', function() {
            isPatientsModalActive = true;
            addPatientActivityModal.hide();
            patientsActivityModal.show();
        });

        patientsActivityModal._element.addEventListener('hidden.bs.modal', function() {
            isPatientsModalActive = false;
            addPatientActivityModal.show();
        });

        addPatientActivityModal._element.addEventListener('hidden.bs.modal', function() {
            if (!isPatientsModalActive) {
                proofActivityModal.show();
            }
        });
    });
</script>
