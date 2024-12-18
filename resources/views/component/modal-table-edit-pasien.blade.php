<div class="modal fade" id="modalPasienEdit" tabindex="-1" aria-labelledby="modalPasienLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalPasienLabel">Cari Pasien</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table class="table table-striped" id="pasienEdit">
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
        // if ($.fn.DataTable.isDataTable('#pasienEdit')) {
        //     $('#pasienEdit').DataTable().destroy(); // Hancurkan DataTables jika sudah ada
        // }

        table = $('#pasienEdit').DataTable({
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
                            <button class="btn btn-success btnPilihPasienEdit" 
                                data-id="${row.id}" 
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
    $(document).on('click', '.btnPilihPasienEdit', function () {
        const data = $(this).data();
        var dob = data.age;  // data.dob should be in the format 'YYYY-MM-DD'

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
        $('#NIK').text(data.nik);
        $('#Name').text(data.name);
        $('#Gender').text(data.gender);
        $('#Age').text(age);
        $('#Phone').text(data.phone);
        $('#Address').text(data.address);
        $('#Blood').text(data.blood);
        $('#Education').text(data.education);
        $('#Job').text(data.job);
        $('#RmNumber').text(data.rm);

        // Set nilai ID ke input form
        $('#nikEdit').val(data.nik);

        // Tampilkan bagian detail pasien
        $('#patientDetailsEdit').show();

        // Tutup modal
        $('#modalPasienEdit').modal('hide');
    });

    // Inisialisasi ulang DataTables saat modal ditampilkan
    $('#modalPasienEdit').on('shown.bs.modal', function () {
        initializeTable();
    });
});

</script>