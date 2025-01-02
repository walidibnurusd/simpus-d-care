<div class="modal fade" id="modalSkrining" tabindex="-1" aria-labelledby="modalSkriningLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalSkriningLabel">Daftar Skrining</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table class="table table-striped" id="skrining">
                    <thead>
                        <tr>
                            <th>Jenis</th>
                            <th>Kesimpulan</th>
                            <th>Action</th>
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
    $('#btnCariskrining').on('click', function () {
        const patientId = $(this).data('id'); // Ambil ID pasien dari tombol

        if (patientId) {
            if ($.fn.DataTable.isDataTable('#skrining')) {
                // Jika DataTable sudah ada, perbarui URL dan reload data
                $('#skrining').DataTable().ajax.url(`/get-skrining/${patientId}`).load();
            } else {
                // Inisialisasi DataTable baru
                $('#skrining').DataTable({
                    ajax: {
                        url: `/get-skrining/${patientId}`,
                        type: 'GET',
                    },
                    columns: [
                        { data: 'jenis_skrining', title: 'Jenis Skrining' },
                        { data: 'kesimpulan_skrining', title: 'Kesimpulan Skrining' },
                        {
                            data: null,
                            title: 'Action',
                            render: function (data, type, row) {
                                return `<button class="btn btn-primary btn-sm" onclick="handleAction(${data.id})">Action</button>`;
                            },
                        },
                    ],
                    processing: true,
                    serverSide: true,
                    searching: true, // Pastikan pencarian diaktifkan
                    destroy: true, // Mengizinkan tabel diinisialisasi ulang
                });
            }
        } else {
            alert('Pilih pasien terlebih dahulu!');
        }
    });

    // Tambahkan event handler ketika modal ditutup
    $('#modalSkrining').on('hidden.bs.modal', function () {
        console.log('Modal Skrining ditutup!');
    });
});

// Contoh fungsi untuk menangani aksi di tombol Action
function handleAction(id) {
    alert(`Aksi untuk ID: ${id}`);
}




</script>
