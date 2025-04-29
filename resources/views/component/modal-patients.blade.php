<div class="modal fade" id="patientsActivityModal{{ $activity->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Daftar Pasien</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="max-height: 75vh; overflow-y: auto;">
                <div class="mt-4">
                    <table id="patientTable{{ $activity->id }}" class="display small" style="width: 100%;">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>NIK</th>
                                <th>Nama</th>
                                <th>Alamat</th>
                                <th>Tempat/Tanggal Lahir</th>
                                <th>JK</th>
                                <th>Telepon</th>
                                <th>Nikah</th>
                                <th>No.RM</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($patients as $patient)
                                <tr data-patient="{{ json_encode($patient) }}">
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $patient->nik }}</td>
                                    <td>{{ $patient->name }}</td>
                                    <td>{{ $patient->address }}</td>
                                    <td>
                                        <p class="mb-0" style="font-size: 14px">{{ $patient->place_birth }}</p>
                                        <p class="mb-0">{{ $patient->dob }} <span class="age-red">({{ $patient->getAgeAttribute() }}-thn)</span></p>
                                    </td>
                                    <td>{{ $patient->genderName->name }}</td>
                                    <td>{{ $patient->phone }}</td>
                                    <td>{{ $patient->marritalStatus->name }}</td>
                                    <td>{{ $patient->no_rm }}</td>
                                    <td>
                                        <button class="btn btn-primary select-patient-btn" data-bs-dismiss="modal">Pilih</button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    var $j = jQuery.noConflict();

    $j('#patientTable{{ $activity->id }}').DataTable({
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
    document.addEventListener('DOMContentLoaded', function() {
        var patientsActivityModal = new bootstrap.Modal(document.getElementById(
            'patientsActivityModal{{ $activity->id }}'));

    });
</script>

<style>
    .modal-full {
        width: 60%;
        max-width: 60%;
        margin: 0;
        /* Modal tetap terpusat */
    }

    .modal-header .btn-close {
        background-color: #dc3545;
        /* Warna merah */
        border: none;
        padding: 5px 10px;
        color: white;
        font-size: 16px;
        font-weight: bold;
    }

    .modal-header .btn-close:hover {
        background-color: #c82333;
        /* Warna merah gelap saat di-hover */
    }
</style>
