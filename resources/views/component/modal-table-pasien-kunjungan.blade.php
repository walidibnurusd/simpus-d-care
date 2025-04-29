<<<<<<< HEAD
<div class="modal fade" id="modalPasienKunjungan" tabindex="-1" aria-labelledby="modalPasienKunjunganLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalPasienKunjunganLabel">Cari Pasien</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="d-flex justify-content-end m-2">
                    <button id="refreshTable" class="btn btn-primary btn-sm ms-2">Refresh</button>
                </div>
                <table class="table table-striped" id="pasienKunjungan">
                    <thead>
                        <tr>
                            <th>NIK</th>
                            <th>Nama</th>
                            <th>Alamat</th>
                            <th>Tanggal Kunjungan</th>
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
<!-- Bootstrap 5 (tanpa jQuery) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js"></script>



<script>
    $(document).ready(function() {

        let table; // Deklarasi variabel DataTable

        // Fungsi untuk menginisialisasi DataTable
        function initializeTable() {
            const tipe = $('#tipe').val(); // Ambil route name
            const url = `/get-patients/${tipe}`;
            table = $('#pasienKunjungan').DataTable({
                ajax: {
                    url: url, // Endpoint untuk mengambil data
                    type: 'GET',
                    dataSrc: function(response) {
                        return response
                            .data; // Pastikan 'data' adalah key yang mengandung array dari server
                    },
                },
                columns: [{
                        data: 'nik',
                        name: 'nik'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'address',
                        name: 'address'
                    },
                    {
                        data: 'created_at',
                        name: 'created_at'
                    },
                    {
                        data: null,
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row) {
                            return `
                            <button class="btn btn-success btnPilihPasien" 
                                data-id="${row.id}" 
                                data-jenis_kartu="${row.jenis_kartu}" 
                                data-nomor_kartu="${row.nomor_kartu}" 
                                data-nik="${row.nik}" 
                                data-name="${row.name}" 
                                data-gender="${row.gender}" 
                                data-age="${row.dob}" 
                                data-phone="${row.phone}" 
                                data-address="${row.address}" 
                                data-blood="${row.blood_type}" 
                                data-education="${row.education}" 
                                data-job="${row.occupation}" 
                                data-rm="${row.no_rm}"   data-bs-dismiss="modal" >
                                Pilih
                            </button>
                        `;
                        },
                    },
                ],
                destroy: true, // Mengizinkan inisialisasi ulang
                processing: true,
                serverSide: true,
            });
        }

        // Handle tombol "Pilih" diklik
        $(document).on('click', '.btnPilihPasien', function() {
            const data = $(this).data();
            var dob = data.age; // data.dob should be in the format 'YYYY-MM-DD'

            // Function to calculate age from dob
            function calculateAge(dob) {
                var birthDate = new Date(dob);
                var ageDifMs = Date.now() - birthDate.getTime(); // Difference in milliseconds
                var ageDate = new Date(ageDifMs); // Convert ms to date object
                return Math.abs(ageDate.getUTCFullYear() - 1970); // Get the age in years
            }

            // Get the age
            var age = calculateAge(dob);
            // Tampilkan data pasien di elemen luar modal
            $('#displayNIK').text(data.nik);
            $('#idPatient').text(data.id);
            $('#displayName').text(data.name);
            $('#displayGender').text(data.gender);
            $('#displayAge').text(age);
            $('#displayPhone').text(data.phone);
            $('#displayAddress').text(data.address);
            $('#displayBlood').text(data.blood);
            $('#displayEducation').text(data.education);
            $('#displayJob').text(data.job);
            $('#displayRmNumber').text(data.rm);

            $('#nik').val(data.nik);
            $('#namePatient').val(data.name);
            $('#nomor_kartu').val(data.nomor_kartu);

            let jenisKartu = data.jenis_kartu;
            if (jenisKartu === 'pbi') {
                jenisKartu = 'PBI (KIS)';
            } else if (jenisKartu === 'askes') {
                jenisKartu = 'AKSES'
            } else if (jenisKartu === 'jkn_mandiri') {
                jenisKartu = 'JKN Mandiri'
            } else if (jenisKartu === 'umum') {
                jenisKartu = 'Umum'
            } else {
                jenisKartu = 'JKD'
            }
            $('#jenis_kartu').val(jenisKartu);

            $('#patientDetails').show();

            // Tutup modal
            $('#modalPasienKunjungan').modal('hide');
        });

        // Inisialisasi DataTable hanya sekali saat halaman pertama kali dimuat
        if ($('#pasienKunjungan').length && !$.fn.DataTable.isDataTable('#pasienKunjungan')) {
            initializeTable();
        }

        // Inisialisasi ulang DataTables saat modal ditampilkan
        $('#modalPasienKunjungan').on('shown.bs.modal', function() {
            // Jika DataTable sudah ada, hancurkan dulu sebelum diinisialisasi ulang
            if ($.fn.DataTable.isDataTable('#pasienKunjungan')) {
                $('#pasienKunjungan').DataTable().clear().destroy();
            }
            // Pastikan tabel baru diinisialisasi setelah modal muncul
            initializeTable();
        });
        $('#refreshTable').on('click', function() {

            table.ajax.reload(null, false);
        });
        $('#addPatientForm').submit(async function(e) {
            e.preventDefault();
            let formData = $('#addPatientForm').serialize();
            formData += "&_token=" + $('meta[name="csrf-token"]').attr('content');
            let actionId = $('#action_id').val() ?? null;

            // Tentukan URL berdasarkan ada tidaknya actionId
            let url = actionId ? `/tindakan-dokter/${actionId}` : '/tindakan';
            $.ajax({
                url: url,
                type: 'POST',
                data: formData,
                success: async function(response) {
                    // Menampilkan notifikasi sukses
                    await Swal.fire({
                        title: 'Success!',
                        text: response.success || 'Data berhasil diproses!',
                        icon: 'success',
                        confirmButtonText: 'OK'
                    });

                    // Sembunyikan detail pasien & reset form
                    $('#patientDetails').hide();
                    $('#displayNIK, #displayName, #displayAge, #displayPhone, #displayAddress, #displayBlood, #displayRmNumber, #diagnosa')
                        .text('');
                    $('#addPatientForm')[0].reset();

                    // Reload DataTable dan tunggu sampai selesai
                    await new Promise((resolve) => {
                        table.ajax.reload(resolve, false);
                        console.log('jalan');

                    });

                    // Perbarui daftar diagnosa
                    await updateDiagnosaList();

                    // Tunggu hingga data pasien benar-benar diperbarui sebelum menampilkan modal
                    await refreshPatientData();

                    // Cek apakah ada data dalam tabel sebelum menampilkan modal
                    setTimeout(() => {
                        if ($('#patientTableBody tr').length > 0) {
                            $('#modalPasien').modal('show');
                        } else {
                            console.warn("Data pasien belum ter-refresh.");
                        }
                    }, 500); // Delay 500ms untuk memastikan data sudah ter-load
                },
                error: function(xhr) {
                    console.error(xhr);
                    let errorMsg = xhr.responseJSON?.error || "Terjadi kesalahan!";
                    Swal.fire({
                        title: 'Error!',
                        text: errorMsg,
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }
            });

        });
    });
</script>
=======
<div class="modal fade" id="modalPasienKunjungan" tabindex="-1" aria-labelledby="modalPasienKunjunganLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalPasienKunjunganLabel">Cari Pasien</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="d-flex justify-content-end m-2">
                    <button id="refreshTable" class="btn btn-primary btn-sm ms-2">Refresh</button>
                </div>
                <table class="table table-striped" id="pasienKunjungan">
                    <thead>
                        <tr>
                            <th>NIK</th>
                            <th>Nama</th>
                            <th>Alamat</th>
                            <th>Tanggal Kunjungan</th>
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
<!-- Bootstrap 5 (tanpa jQuery) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js"></script>



<script>
    $(document).ready(function() {

        let table; // Deklarasi variabel DataTable

        // Fungsi untuk menginisialisasi DataTable
        function initializeTable() {
            const tipe = $('#tipe').val(); // Ambil route name
            const url = `/get-patients/${tipe}`;
            table = $('#pasienKunjungan').DataTable({
                ajax: {
                    url: url, // Endpoint untuk mengambil data
                    type: 'GET',
                    dataSrc: function(response) {
                        return response
                            .data; // Pastikan 'data' adalah key yang mengandung array dari server
                    },
                },
                columns: [{
                        data: 'nik',
                        name: 'nik'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'address',
                        name: 'address'
                    },
                    {
                        data: 'created_at',
                        name: 'created_at'
                    },
                    {
                        data: null,
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row) {
                            return `
                            <button class="btn btn-success btnPilihPasien" 
                                data-id="${row.id}" 
                                data-jenis_kartu="${row.jenis_kartu}" 
                                data-nomor_kartu="${row.nomor_kartu}" 
                                data-nik="${row.nik}" 
                                data-name="${row.name}" 
                                data-gender="${row.gender}" 
                                data-age="${row.dob}" 
                                data-phone="${row.phone}" 
                                data-address="${row.address}" 
                                data-blood="${row.blood_type}" 
                                data-education="${row.education}" 
                                data-job="${row.occupation}" 
                                data-rm="${row.no_rm}"   data-bs-dismiss="modal" >
                                Pilih
                            </button>
                        `;
                        },
                    },
                ],
                destroy: true, // Mengizinkan inisialisasi ulang
                processing: true,
                serverSide: true,
            });
        }

        // Handle tombol "Pilih" diklik
        $(document).on('click', '.btnPilihPasien', function() {
            const data = $(this).data();
            var dob = data.age; // data.dob should be in the format 'YYYY-MM-DD'

            // Function to calculate age from dob
            function calculateAge(dob) {
                var birthDate = new Date(dob);
                var ageDifMs = Date.now() - birthDate.getTime(); // Difference in milliseconds
                var ageDate = new Date(ageDifMs); // Convert ms to date object
                return Math.abs(ageDate.getUTCFullYear() - 1970); // Get the age in years
            }

            // Get the age
            var age = calculateAge(dob);
            // Tampilkan data pasien di elemen luar modal
            $('#displayNIK').text(data.nik);
            $('#idPatient').text(data.id);
            $('#displayName').text(data.name);
            $('#displayGender').text(data.gender);
            $('#displayAge').text(age);
            $('#displayPhone').text(data.phone);
            $('#displayAddress').text(data.address);
            $('#displayBlood').text(data.blood);
            $('#displayEducation').text(data.education);
            $('#displayJob').text(data.job);
            $('#displayRmNumber').text(data.rm);

            $('#nik').val(data.nik);
            $('#namePatient').val(data.name);
            $('#nomor_kartu').val(data.nomor_kartu);

            let jenisKartu = data.jenis_kartu;
            if (jenisKartu === 'pbi') {
                jenisKartu = 'PBI (KIS)';
            } else if (jenisKartu === 'askes') {
                jenisKartu = 'AKSES'
            } else if (jenisKartu === 'jkn_mandiri') {
                jenisKartu = 'JKN Mandiri'
            } else if (jenisKartu === 'umum') {
                jenisKartu = 'Umum'
            } else {
                jenisKartu = 'JKD'
            }
            $('#jenis_kartu').val(jenisKartu);

            $('#patientDetails').show();

            // Tutup modal
            $('#modalPasienKunjungan').modal('hide');
        });

        // Inisialisasi DataTable hanya sekali saat halaman pertama kali dimuat
        if ($('#pasienKunjungan').length && !$.fn.DataTable.isDataTable('#pasienKunjungan')) {
            initializeTable();
        }

        // Inisialisasi ulang DataTables saat modal ditampilkan
        $('#modalPasienKunjungan').on('shown.bs.modal', function() {
            // Jika DataTable sudah ada, hancurkan dulu sebelum diinisialisasi ulang
            if ($.fn.DataTable.isDataTable('#pasienKunjungan')) {
                $('#pasienKunjungan').DataTable().clear().destroy();
            }
            // Pastikan tabel baru diinisialisasi setelah modal muncul
            initializeTable();
        });
        $('#refreshTable').on('click', function() {

            table.ajax.reload(null, false);
        });
        $('#addPatientForm').submit(async function(e) {
            e.preventDefault();
            let formData = $('#addPatientForm').serialize();
            formData += "&_token=" + $('meta[name="csrf-token"]').attr('content');
            let actionId = $('#action_id').val() ?? null;

            // Tentukan URL berdasarkan ada tidaknya actionId
            let url = actionId ? `/tindakan-dokter/${actionId}` : '/tindakan';
            $.ajax({
                url: url,
                type: 'POST',
                data: formData,
                success: async function(response) {
                    // Menampilkan notifikasi sukses
                    await Swal.fire({
                        title: 'Success!',
                        text: response.success || 'Data berhasil diproses!',
                        icon: 'success',
                        confirmButtonText: 'OK'
                    });

                    // Sembunyikan detail pasien & reset form
                    $('#patientDetails').hide();
                    $('#displayNIK, #displayName, #displayAge, #displayPhone, #displayAddress, #displayBlood, #displayRmNumber, #diagnosa')
                        .text('');
                    $('#addPatientForm')[0].reset();

                    // Reload DataTable dan tunggu sampai selesai
                    await new Promise((resolve) => {
                        table.ajax.reload(resolve, false);
                        console.log('jalan');

                    });

                    // Perbarui daftar diagnosa
                    await updateDiagnosaList();

                    // Tunggu hingga data pasien benar-benar diperbarui sebelum menampilkan modal
                    await refreshPatientData();

                    // Cek apakah ada data dalam tabel sebelum menampilkan modal
                    setTimeout(() => {
                        if ($('#patientTableBody tr').length > 0) {
                            $('#modalPasien').modal('show');
                        } else {
                            console.warn("Data pasien belum ter-refresh.");
                        }
                    }, 500); // Delay 500ms untuk memastikan data sudah ter-load
                },
                error: function(xhr) {
                    console.error(xhr);
                    let errorMsg = xhr.responseJSON?.error || "Terjadi kesalahan!";
                    Swal.fire({
                        title: 'Error!',
                        text: errorMsg,
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }
            });

        });
    });
</script>
>>>>>>> 9df8fede466960d27744a11e4cb830e2a9437611
