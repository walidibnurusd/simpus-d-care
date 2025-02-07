<div class="modal fade" id="modalPasien" tabindex="-1" aria-labelledby="modalPasienLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalPasienLabel">Cari Pasien</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table class="table table-striped" id="pasien">
                    <thead>
                        <tr>
                            <th>NIK</th>
                            <th>NO RM</th>
                            <th>NO Family Folder</th>
                            <th>Nama</th>
                            <th>Alamat</th>
                            <th>Tanggal Lahir</th>
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
            // if ($.fn.DataTable.isDataTable('#pasien')) {
            //     $('#pasien').DataTable().destroy(); // Hancurkan DataTables jika sudah ada
            // }

            table = $('#pasien').DataTable({
                ajax: {
                    url: '/get-patients', // Endpoint untuk mengambil data
                    type: 'GET',

                },
                columns: [{
                        data: 'nik',
                        name: 'nik'
                    },
                    {
                        data: 'no_rm',
                        name: 'no_rm'
                    }, {
                        data: 'no_family_folder',
                        name: 'no_family_folder'
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
                        data: 'dob',
                        data: 'dob',

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
                                data-poli="${row.poli}" 
                                data-name="${row.name}" 
                                data-gender="${row.gender}" 
                                data-age="${row.dob}" 
                                data-place_birth="${row.place_birth}" 
                                data-marrital="${row.marrital_status}" 
                                data-phone="${row.phone}" 
                                data-address="${row.address}" 
                                data-blood="${row.blood_type}" 
                                data-education="${row.education}" 
                                data-province="${row.indonesia_province_id}" 
                                data-city="${row.indonesia_city_id}" 
                                data-district="${row.indonesia_district}" 
                                data-village="${row.indonesia_village}" 
                                data-rw="${row.rw}" 
                                data-address="${row.address}" 
                                data-job="${row.occupation}" 
                                data-wilayahfaskes="${row.wilayah_faskes}" 
                                data-kunjungan="${row.kunjungan}" 
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
        $(document).on('click', '.btnPilihPasien', function() {

            const data = $(this).data();
            // Assuming 'data.dob' contains the date of birth, e.g., "1990-01-01"
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
            $('#nikAdd').val(data.nik);
            $('#name').val(data.name);
            $('#no_rm').val(data.rm);
            $('#marriage_status').val(data.marrital);
            $('#phone').val(data.phone);
            $('#blood_type').val(data.blood);
            $('#blood_type').val(data.blood);
            $('#education').val(data.education);
            $('#occupation').val(data.job);
            $('#gender').val(data.gender);
            $('#nomor_kartu').val(data.nomor_kartu);
            $('#poli').val(data.poli);

            $('#dob').val(data.age);
            $('#place_birth').val(data.place_birth);
            $('#province').val(data.province);
            $('#city').val(data.city);
            $('#district').val(data.district);
            $('#village').val(data.village);
            $('#rw').val(data.rw);
            $('#address').val(data.address);
            $('#wilayah_faskes').val(data.wilayah_faskes);
            $('#kunjungan').val(data.kunjungan);

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
            $('#jenis_kartu').val(data.jenis_kartu);

            let klaster = null;
            if (age > 18) {
                klaster = 3
            } else {
                klaster = 2
            }
            $('#klaster').val(klaster);


            $('#patientDetails').show();

            // Tutup modal
            $('#modalPasien').modal('hide');
        });

        // Inisialisasi ulang DataTables saat modal ditampilkan
        $('#modalPasien').on('shown.bs.modal', function() {
            initializeTable();
        });
    });
</script>
