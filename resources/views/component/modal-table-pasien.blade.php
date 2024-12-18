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
 $(document).ready(function () {
    let table; // Deklarasi variabel DataTable

    // Fungsi untuk menginisialisasi DataTable
    function initializeTable() {
        if ($.fn.DataTable.isDataTable('#pasien')) {
            $('#pasien').DataTable().destroy(); // Hancurkan DataTables jika sudah ada
        }

        table = $('#pasien').DataTable({
            ajax: {
                url: '/get-patients', // Endpoint untuk mengambil data
                type: 'GET',
                dataSrc: function (json) {
                    return json.data; // Pastikan data dalam key 'data'
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
            destroy: true, // Mengizinkan inisialisasi ulang
            processing: true,
            serverSide: true,
        });
    }

    // Handle tombol "Pilih" diklik
    $(document).on('click', '.btnPilihPasien', function () {
        const data = $(this).data();

        // Tampilkan data pasien di elemen luar modal
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

        // Set nilai ID ke input form
        $('#nik').val(data.id);

        // Tampilkan bagian detail pasien
        $('#patientDetails').show();

        // Tutup modal
        $('#modalPasien').modal('hide');
    });

    // Inisialisasi ulang DataTables saat modal ditampilkan
    $('#modalPasien').on('shown.bs.modal', function () {
        initializeTable();
    });
});

</script>