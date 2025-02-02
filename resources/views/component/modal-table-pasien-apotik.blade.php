<div class="modal fade" id="modalPasienApotik" tabindex="-1" aria-labelledby="modalPasienApotikLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="w-100">
                    <h5 class="modal-title" id="modalPasienApotikLabel">Cari Pasien</h5>
                    <div class="form-group mt-2">
                        <label for="filterDate" class="form-label">Filter Tanggal</label>
                        <input type="date" id="filterDate" class="form-control">
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="d-flex justify-content-end m-2">
                    <button id="refreshTable" class="btn btn-primary btn-sm ms-2">Refresh</button>
                </div>
                <table class="table table-striped" id="pasienApotik">
                    <thead>
                        <tr>
                            <th>NIK</th>
                            <th>Nama</th>
                            <th>Tanggal Kajian Awal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>



<script>
    $(document).ready(function() {

        let table;

        function initializeTable() {
            const tipe = $('#tipe').val();
            const url = `/get-patients-apotik/${tipe}`;
            const filterDate = $('#filterDate').val();
            table = $('#pasienApotik').DataTable({
                ajax: {
                    url: url,
                    type: 'GET',
                    data: function(d) {
                        d.filterDate = filterDate;
                    }

                },
                columns: [{
                        data: 'patient.nik',
                        name: 'nik'
                    },
                    {
                        data: 'patient.name',
                        name: 'name'
                    },
                    {
                        data: 'created_at',
                        name: 'created_at',
                        render: function(data) {
                            if (!data) return '-'; // Jika data kosong, tampilkan tanda "-"

                            // Konversi ke format dd-mm-yyyy hh:mm:ss
                            const dateObj = new Date(data);
                            const day = String(dateObj.getDate()).padStart(2, '0');
                            const month = String(dateObj.getMonth() + 1).padStart(2,
                                '0'); // Bulan dimulai dari 0
                            const year = dateObj.getFullYear();
                            const hours = String(dateObj.getHours()).padStart(2, '0');
                            const minutes = String(dateObj.getMinutes()).padStart(2, '0');
                            const seconds = String(dateObj.getSeconds()).padStart(2, '0');

                            return `${day}-${month}-${year} ${hours}:${minutes}:${seconds}`;
                        }
                    },
                    {
                        data: null,
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row) {
                            return `
                        <button class="btn btn-success btnPilihPasien" 
    data-id-patient="${row.patient.id}" 
    data-id="${row.id}" 
    data-nik="${row.patient.nik}" 
    data-name="${row.patient.name}" 
    data-gender="${row.patient.gender}" 
    data-age="${row.patient.dob}" 
    data-phone="${row.patient.phone}" 
    data-address="${row.patient.address}" 
    data-blood="${row.patient.blood_type}" 
    data-education="${row.patient.education}" 
    data-job="${row.patient.occupation}" 
    data-rm="${row.patient.no_rm}" 
    data-tanggal="${row.tanggal}" 
    data-doctor="${row.doctor}" 
    data-kunjungan="${row.kunjungan}"    
    data-obat="${row.obat}"    
    data-updateobat="${row.update_obat}" 
data-bs-dismiss="modal">
    Pilih
</button>

                        `;
                        },
                    },
                ],
                destroy: true,
                processing: true,
                serverSide: true,
            });
        }
        $('#filterDate').on('change', function() {
            if ($.fn.DataTable.isDataTable('#pasienApotik')) {
                table.destroy();
            }
            initializeTable();
        });



        $(document).on('click', '.btnPilihPasien', function() {

            const data = $(this).data();

            var dob = data.age;


            function calculateAge(dob) {
                var birthDate = new Date(dob);
                var ageDifMs = Date.now() - birthDate.getTime();
                var ageDate = new Date(ageDifMs);
                return Math.abs(ageDate.getUTCFullYear() - 1970);
            }


            var age = calculateAge(dob);

            $('#displayNIK').text(data.nik);
            $('#displayName').text(data.name);
            $('#displayGender').text(data.gender);
            $('#displayAge').text(age);
            $('#displayPhone').text(data.phone);
            $('#displayAddress').text(data.address);
            $('#displayBlood').text(data.blood);
            $('#displayEducation').text(data.education);
            $('#displayJob').text(data.job);
            $('#displayRmNumber').text(data.rm);

            const actionId = data.id;
            const actionUrl = "{{ route('action.update.apotik', '__ID__') }}".replace('__ID__',
                actionId);
            $('#addPatientForm').attr('action', actionUrl);
            // Set nilai ID ke input form
            $('#nik').val(data.nik);
            $('#idAction').val(data.id);
            $('#tanggal').val(data.tanggal);
            $('#doctor').val(data.doctor);
            $('#nomor_kartu').val(data.nomor);
            $('#kunjungan').val(data.kunjungan);

            $('#obat').val(data.obat);
            $('#update_obat').val(data.updateobat);

            $('#modalPasienApotik').modal('hide');
        });
        initializeTable();
        // Inisialisasi ulang DataTables saat modal ditampilkan
        $('#modalPasienApotik').on('shown.bs.modal', function() {
            initializeTable();
        });
        $('#refreshTable').on('click', function() {

            table.ajax.reload(null, false);
        });
    });
</script>
