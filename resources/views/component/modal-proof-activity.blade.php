<!-- Proof Activity Modal -->
<div class="modal fade" id="proofActivityModal{{ $activity->id }}" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ $activity->activity->name }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="max-height: 75vh; overflow-y: auto;">
                <form id="addActivityForm{{ $activity->id }}" action="{{ route('activityEmployee.store') }}"
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
                            </div>
                        </div>
                    </div>

                    <div class="mb-3 mt-1">
                        <div><strong>Bukti Foto</strong></div>
                        <input type="file" class="form-control" id="proofFile{{ $activity->id }}" name="image"
                            accept="image/*">
                        <small class="form-text text-muted">Allowed file types: png, jpg, jpeg.</small>

                        @if (!empty($activity->proofActivity[0]->image))
                            <p class="mt-2">Foto Saat Ini:</p>
                            <img id="imgPreview{{ $activity->id }}"
                                src="{{ asset('storage/' . $activity->proofActivity[0]->image) }}" alt="Foto Saat Ini"
                                class="img-fluid mb-3" style="max-height: 200px;">
                        @else
                            <p class="mt-2">Preview Foto:</p>
                            <img id="imgPreview{{ $activity->id }}" src="#" alt="Preview Foto"
                                class="img-fluid mb-3" style="max-height: 200px; display: none;">
                        @endif
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <div><strong>Keterangan Hasil Kegiatan</strong></div>
                                <input type="text" class="form-control" name="value"
                                    value="{{ $activity->proofActivity[0]->value ?? '' }}" placeholder="Keterangan">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <div><strong>Saran</strong></div>
                                <input type="text" class="form-control" name="advice"
                                    value="{{ $activity->proofActivity[0]->advice ?? '' }}" placeholder="Saran">
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-start">
                        <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger">Simpan</button>
                    </div>
                </form>

                <div class="mt-4">
                    <button type="button" id="addPatientBtn{{ $activity->id }}"
                        class="btn btn-success btn-sm text-white mt-2"
                        style="font-size: 0.75rem; padding: 0.25rem 0.5rem;">
                        Tambah Pasien
                    </button>
                    <table id="proofTable{{ $activity->id }}" class="display small" style="width: 100%;">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>NIK</th>
                                <th>Nama</th>
                                <th>Telp</th>
                                <th>Jenis Kelamin</th>
                                <th>Umur</th>
                                <th>Keterangan</th>
                                <th>Aksi</th>
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
                                        <td>{{ $loop->parent->iteration }}.{{ $loop->iteration }}</td>
                                        <td>{{ $patient->nik }}</td>
                                        <td>{{ $patient->name }}</td>
                                        <td>{{ $patient->phone }}</td>
                                        <td>{{ $patient->genderName->name }}</td>
                                        <td>{{ \Carbon\Carbon::parse($patient->dob)->age }} tahun</td>
                                        <td>{{ $item->description }}</td>
                                        <td>
                                            <button type="button" id="btn-editproof{{ $activity->id }}"
                                                class="btn btn-primary btn-sm text-white font-weight-bold btn-editproof"
                                                data-id="{{ $item->id }}" data-des="{{ $item->description }}"
                                                style="font-size: 0.75rem; padding: 0.25rem 0.5rem;">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button type="button"
                                                class="btn btn-danger btn-sm text-white font-weight-bold btn-delete-modal-proof"
                                                data-id="{{ $item->id }}"
                                                style="font-size: 0.75rem; padding: 0.25rem 0.5rem;">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </td>
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

    $j(document).ready(function() {
        // Initialize DataTable
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

        // Image preview for adding proof
        document.getElementById('proofFile{{ $activity->id }}').addEventListener('change', function() {
            const [file] = this.files;
            const imgPreview = document.getElementById('imgPreview{{ $activity->id }}');
            if (file) {
                imgPreview.src = URL.createObjectURL(file);
                imgPreview.style.display = 'block';
            } else {
                imgPreview.style.display = 'none';
            }
        });
        $j(document).off('click', '.btn-delete-modal-proof').on('click', '.btn-delete-modal-proof', function() {
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

        // Modal handling logic
        var proofActivityModal = new bootstrap.Modal(document.getElementById(
            'proofActivityModal{{ $activity->id }}'));
        var addPatientActivityModal = new bootstrap.Modal(document.getElementById(
            'addPatientActivityModal{{ $activity->id }}'));
        var patientsActivityModal = new bootstrap.Modal(document.getElementById(
            'patientsActivityModal{{ $activity->id }}'));
        var isPatientsModalActive = false;

        $j(document).on('click', '#addPatientBtn{{ $activity->id }}', function() {
            proofActivityModal.hide();
            addPatientActivityModal.show();
        });
        $j(document).on('click', '#btn-editproof{{ $activity->id }}', function() {
            proofActivityModal.hide();
            addPatientActivityModal.show();
        });

        addPatientActivityModal._element.addEventListener('hidden.bs.modal', function() {
            if (!isPatientsModalActive) {
                proofActivityModal.show();
            }
        });

        $j(document).on('click', '#searchPatientBtn{{ $activity->id }}', function() {
            isPatientsModalActive = true;
            addPatientActivityModal.hide();
            patientsActivityModal.show();
        });

        patientsActivityModal._element.addEventListener('hidden.bs.modal', function() {
            isPatientsModalActive = false;
            addPatientActivityModal.show();
        });
    });
</script>
