<div class="modal fade" id="modalPasienEdit{{ $action->id }}" tabindex="-1" aria-labelledby="modalPasienLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalPasienLabel">Cari Pasien</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table class="table table-striped" id="pasienEdit{{ $action->id }}">
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

<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>


<script>
    $(document).ready(function() {
        let table; // Deklarasi variabel DataTable
    
        // Fungsi untuk menginisialisasi DataTable
        function initializeTable() {
            if ($.fn.DataTable.isDataTable('#pasienEdit{{ $action->id }}')) {
                $('#pasienEdit{{ $action->id }}').DataTable().destroy(); // Hancurkan DataTables jika sudah ada
            }

            table = $('#pasienEdit{{ $action->id }}').DataTable({
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
                            <button class="btn btn-success btnPilihPasienEdit{{ $action->id }}" 
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
                                data-rm="${row.no_rm}" data-bs-dismiss="modal" >
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
        initializeTable();
        // Handle tombol "Pilih" diklik
        $(document).on('click', '.btnPilihPasienEdit{{ $action->id }}', function() {
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
            $('#NIK{{ $action->id }}').text(data.nik);
            $('#Name{{ $action->id }}').text(data.name);
            $('#Gender{{ $action->id }}').text(data.gender);
            $('#Age{{ $action->id }}').text(age);
            $('#Phone{{ $action->id }}').text(data.phone);
            $('#Address{{ $action->id }}').text(data.address);
            $('#Blood{{ $action->id }}').text(data.blood);
            $('#Education{{ $action->id }}').text(data.education);
            $('#Job{{ $action->id }}').text(data.job);
            $('#RmNumber{{ $action->id }}').text(data.rm);

            // Set nilai ID ke input form


            $('#nikEdit{{ $action->id }}').val(data.nik);
            $('#nomor_kartu{{ $action->id }}').val(data.nomor_kartu);
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
            $('#jenis_kartu{{ $action->id }}').val(jenisKartu);

            // Tampilkan bagian detail pasien
            $('#patientDetailsEdit').show();

            // Tutup modal
            $('#modalPasienEdit').modal('hide');
        });

        // Inisialisasi ulang DataTables saat modal ditampilkan
        $('#modalPasienEdit').on('shown.bs.modal', function() {
            initializeTable();
        });
    });
</script>
