@include('component.modal-patients')

<!-- Add Patient Modal -->
<div class="modal fade" id="addPatientActivityModal{{ $activity->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Data</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addActivityForm{{ $activity->id }}" action="{{ route('activityEmployee.storePatientProof') }}"
                    method="POST" class="px-3">
                    @csrf
                    <input type="hidden" name="idPatient" id="idPatient{{ $activity->id }}">
                    <input type="hidden" name="idProof" id="idProof{{ $activity->id }}"
                        value="{{ $activity->proofActivity[0]->id ?? '' }}">
                    <input type="hidden" name="idProofEdit" id="idProofEdit{{ $activity->id }}">
                    <div class="row g-2 mb-2">
                        <div class="col-md-12">
                            <div
                                style="display: grid; grid-template-columns: 150px 10px 1fr; gap: 5px; text-align: left;">
                                <div><strong>Nama Lengkap</strong></div>
                                <div>:</div>
                                <div id="patientName{{ $activity->id }}"></div>

                                <div><strong>Alamat</strong></div>
                                <div>:</div>
                                <div id="patientAddress{{ $activity->id }}"></div>

                                <div><strong>Jenis Kelamin</strong></div>
                                <div>:</div>
                                <div id="patientGender{{ $activity->id }}"></div>

                                <div><strong>Umur</strong></div>
                                <div>:</div>
                                <div id="patientAge{{ $activity->id }}"></div>
                            </div>
                        </div>
                    </div>

                    <button id="searchPatientBtn{{ $activity->id }}" type="button" class="btn btn-secondary">Cari
                        Pasien</button>

                    <div class="form-group">
                        <label for="notes">Keterangan</label>
                        <textarea class="form-control" id="notes{{ $activity->id }}" name="notes" placeholder="Keterangan" required></textarea>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    var $j = jQuery.noConflict();
    document.addEventListener('DOMContentLoaded', function() {


        // Function to calculate age
        function calculateAge(dob) {
            var diff = Date.now() - dob.getTime();
            var ageDate = new Date(diff);
            return Math.abs(ageDate.getUTCFullYear() - 1970); // Calculate year difference
        }
        var addPatientActivityModal = new bootstrap.Modal(document.getElementById(
            'addPatientActivityModal{{ $activity->id }}'));
        var patientsActivityModal = new bootstrap.Modal(document.getElementById(
            'patientsActivityModal{{ $activity->id }}'));
        document.querySelectorAll('#patientTable{{ $activity->id }} tbody .select-patient-btn').forEach(
            function(button) {
                button.addEventListener('click', function() {
                    var patient = JSON.parse(this.closest('tr').dataset.patient);
                    var proofId = "{{ $activity->proofActivity[0]->id ?? '' }}";

                    document.getElementById('idPatient{{ $activity->id }}').value = patient.id;
                    document.getElementById('idProof{{ $activity->id }}').value = proofId;
                    document.getElementById('patientName{{ $activity->id }}').textContent = patient
                        .name;
                    document.getElementById('patientAddress{{ $activity->id }}').textContent =
                        patient.address;
                    document.getElementById('patientGender{{ $activity->id }}').textContent =
                        patient.gender_name.name;

                    var dob = new Date(patient.dob);
                    var age = calculateAge(dob);
                    document.getElementById('patientAge{{ $activity->id }}').textContent = age +
                        ' tahun';

                    addPatientActivityModal.show();
                });
            });
        // Add click event for each row to transfer data to the add modal
        // $j('#patientTable{{ $activity->id }} tbody').on('click', '.select-patient-btn', function() {
        //     var patient = $j(this).closest('tr').data('patient');
        //     if (patient) {
        //         // Populate the data into the add patient modal
        //         $j('#idPatient{{ $activity->id }}').val(patient.id.toString());
        //         $j('#idProof{{ $activity->id }}').val("{{ $activity->proofActivity[0]->id ?? '' }}");
        //         $j('#patientName{{ $activity->id }}').text(patient.name);
        //         $j('#patientAddress{{ $activity->id }}').text(patient.address);
        //         $j('#patientGender{{ $activity->id }}').text(patient.gender_name.name);

        //         var dob = new Date(patient.dob); // Convert DOB to Date object
        //         var age = calculateAge(dob);
        //         $j('#patientAge{{ $activity->id }}').text(age + ' tahun');

        //         var addPatientActivityModal = new bootstrap.Modal(document.getElementById('addPatientActivityModal{{ $activity->id }}'));
        //         addPatientActivityModal.show();
        //     }
        // });

        // Edit proof button click event
        $j('#proofTable{{ $activity->id }} tbody').on('click', '#btn-editproof{{ $activity->id }}',
            function() {

                var patientData = $j(this).closest('tr').data('patient');
                var proofId = $j(this).data('id'); // Get the proof ID from the button's data attribute
                var description = $j(this).data(
                    'des'); // Get the description from the button's data attribute
                console.log(patientData)
                if (patientData) {
                    // Populate the data into the modal
                    $j('#idPatient{{ $activity->id }}').val(patientData.id.toString());
                    $j('#idProofEdit{{ $activity->id }}').val(proofId);
                    $j('#patientName{{ $activity->id }}').text(patientData.name);
                    $j('#patientAddress{{ $activity->id }}').text(patientData.address);
                    $j('#patientGender{{ $activity->id }}').text(patientData.gender_name.name);

                    var dob = new Date(patientData.dob);
                    var age = calculateAge(dob);
                    $j('#patientAge{{ $activity->id }}').text(age + ' tahun');
                    $j('#notes{{ $activity->id }}').val(description);

                    var addPatientActivityModal = new bootstrap.Modal(document.getElementById(
                        'addPatientActivityModal{{ $activity->id }}'));
                    addPatientActivityModal.show();
                }
            });
    });
</script>
