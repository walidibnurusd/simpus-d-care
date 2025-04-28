<div class="modal fade" id="modalPasienEditKunjungan" tabindex="-1" aria-labelledby="modalPasienLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalPasienLabel">Cari Pasien</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="d-flex justify-content-end m-2">
                    <button id="refreshTable{{ $action->id }}" class="btn btn-primary btn-sm ms-2">Refresh</button>
                </div>
                <table class="table table-striped" id="pasienEditKunjungan">
                    <thead>
                        <tr>
                            <th>NIK</th>
                            <th>Nama</th>
                            <th>Alamat</th>
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
        let table; // Deklarasi variabel DataTable

        // Fungsi untuk menginisialisasi DataTable
        function initializeTable() {
            if ($.fn.DataTable.isDataTable('#pasienEditKunjungan')) {
                $('#pasienEditKunjungan').DataTable().destroy(); // Hancurkan DataTables jika sudah ada
            }

            table = $('#pasienEditKunjungan').DataTable({
                ajax: {
                    url: '/get-patients', // Endpoint untuk mengambil data
                    type: 'GET',
                    dataSrc: function(json) {
                        return json.data; // Pastikan data dalam key 'data'
                    },
                    error: function(xhr, error, code) {
                        console.error('Error fetching data:', error);
                        alert('Error fetching patient data!');
                    }
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
                        data: null,
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row) {
                            return `
                            <button class="btn btn-success btnPilihPasienEditKunjungan" 
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
                                data-rm="${row.no_rm}">
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
        $(document).on('click', '.btnPilihPasienEditKunjungan', function() {
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
            $('#NIK{{ $k->id }}').text(data.nik);
            $('#Name{{ $k->id }}').text(data.name);
            $('#Gender{{ $k->id }}').text(data.gender);
            $('#Age{{ $k->id }}').text(age);
            $('#Phone{{ $k->id }}').text(data.phone);
            $('#Address{{ $k->id }}').text(data.address);
            $('#Blood{{ $k->id }}').text(data.blood);
            $('#Education{{ $k->id }}').text(data.education);
            $('#Job{{ $k->id }}').text(data.job);
            $('#RmNumber{{ $k->id }}').text(data.rm);

            // Set nilai ID ke input form
            console.log($('#nikEdit' + data.id));

            $('#nikEdit{{ $k->id }}').val(data.nik);
            $('#nomor_kartu{{ $k->id }}').val(data.nomor_kartu);
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
            $('#jenis_kartu{{ $k->id }}').val(jenisKartu);

            // Tampilkan bagian detail pasien
            $('#patientDetailsEdit').show();

            // Tutup modal
            $('#modalPasienEditKunjungan').modal('hide');
        });

        // Inisialisasi ulang DataTables saat modal ditampilkan
        $('#modalPasienEditKunjungan').on('shown.bs.modal', function() {
            initializeTable();
        });
        $('#refreshTable{{ $action->id }}').on('click', function() {
            table.ajax.reload(null, false);
        });
    });
</script>
