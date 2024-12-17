<div class="modal fade" id="modalPasien" tabindex="-1" aria-labelledby="modalPasienLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalPasienLabel">Cari Pasien</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table class="table table-striped" id="tablePasien">
                    <thead>
                        <tr>
                            <th>NIK</th>
                            <th>Nama</th>
                            <th>Alamat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- DataTables content will be populated here -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>



<script>
    $(document).ready(function () {
        // Initialize DataTable only once
        const table = $('#tablePasien').DataTable({
            ajax: {
                url: '/get-patients', // Endpoint to fetch patient data
                type: 'GET',
                dataSrc: function (json) {
                    return json.data;  // Ensure data is returned as 'data'
                },
                error: function (xhr, error, code) {
                    console.error('Error fetching data:', error);
                    alert('Error fetching patient data!');
                }
            },
            columns: [
                { data: 'nik', name: 'nik' },
                { data: 'name', name: 'name' },
                { data: 'address', name: 'address' },
                {
                    data: null,
                    orderable: false,
                    searchable: false,
                    render: function (data, type, row) {
                        return `
                            <button class="btn btn-success btnPilihPasien" 
                                data-nik="${row.nik}" 
                                data-name="${row.name}" 
                                data-gender="${row.gender}" 
                                data-age="${row.age}" 
                                data-phone="${row.phone}" 
                                data-address="${row.address}" 
                                data-blood="${row.blood}" 
                                data-education="${row.education}" 
                                data-job="${row.job}" 
                                data-rm="${row.rm}">
                                Pilih
                            </button>
                        `;
                    },
                },
            ],
        });

        // Handle 'Pilih' button click
        $(document).on('click', '.btnPilihPasien', function () {
            const nik = $(this).data('nik');
            const name = $(this).data('name');
            const gender = $(this).data('gender');
            const age = $(this).data('age');
            const phone = $(this).data('phone');
            const address = $(this).data('address');
            const blood = $(this).data('blood');
            const education = $(this).data('education');
            const job = $(this).data('job');
            const rmNumber = $(this).data('rm');

            // Display selected patient data outside the modal
            $('#displayNIK').text(nik);
            $('#displayName').text(name);
            $('#displayGender').text(gender);
            $('#displayAge').text(age);
            $('#displayPhone').text(phone);
            $('#displayAddress').text(address);
            $('#displayBlood').text(blood);
            $('#displayEducation').text(education);
            $('#displayJob').text(job);
            $('#displayRmNumber').text(rmNumber);

            // Show the patient details
            $('#patientDetails').show();

            // Optionally, you can store NIK in an input field (if needed for forms)
            $('#nik').val(nik);  // Example: Replace '#nik' with the correct input field ID

            // Close the modal
            $('#modalPasien').modal('hide');
        });

        // Refresh DataTables when the modal is shown
        $('#modalPasien').on('shown.bs.modal', function () {
            table.ajax.reload();  // Reload the table to show fresh data
        });
    });
</script>