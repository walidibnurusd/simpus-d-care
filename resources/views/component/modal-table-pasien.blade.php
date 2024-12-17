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

<link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css">
<script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>

<script>
$(document).ready(function () {
    let table; // Declare the variable outside
    
    // Check if the DataTable is already initialized
    if (!$.fn.DataTable.isDataTable('#tablePasien')) {
        table = $('#tablePasien').DataTable({
            ajax: {
                url: '/get-patients',
                type: 'GET',
                dataSrc: function (json) {
                    if (!json.data) {
                        console.error("Data source error: 'data' field is missing in response.");
                        alert('Invalid data format from server.');
                        return [];
                    }
                    return json.data;
                },
                error: function (xhr, error, code) {
                    console.error('Error fetching data:', xhr.responseText || error);
                    alert('Failed to load patient data. Please try again.');
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
                                data-id="${row.id}" 
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
            processing: true,
            serverSide: true,
        });
    }

    // Handle 'Pilih' button click
    $(document).on('click', '.btnPilihPasien', function () {
        const data = $(this).data();

        // Display selected patient data outside the modal
        $('#displayNIK').text(data.nik);
        $('#displayName').text(data.name);
        $('#displayGender').text(data.gender);
        $('#displayAge').text(data.age);
        $('#displayPhone').text(data.phone);
        $('#displayAddress').text(data.address);
        $('#displayBlood').text(data.blood);
        $('#displayEducation').text(data.education);
        $('#displayJob').text(data.job);
        $('#displayRmNumber').text(data.rm);

        // Set ID into an input field for form submission
        $('#nik').val(data.id);

        // Show patient details section
        $('#patientDetails').show();

        // Close the modal
        $('#modalPasien').modal('hide');
    });

    // Refresh DataTables when the modal is shown
    $('#modalPasien').on('shown.bs.modal', function () {
        if (table) {
            table.ajax.reload(null, false);  // Reload the table without resetting pagination
        }
    });
});


</script>