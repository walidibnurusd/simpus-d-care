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
    $('#btnCariskrining').on('click', function() {
        const patientId = $(this).data('id'); // Ambil ID pasien dari tombol

        if (patientId) {
            if ($.fn.DataTable.isDataTable('#skrining')) {
                // Jika DataTable sudah ada, reload data
                $('#skrining').DataTable().ajax.url(`/get-skrining/${patientId}`).load();
            } else {
                // Jika DataTable belum ada, inisialisasi
                $('#skrining').DataTable({
                    ajax: {
                        url: `/get-skrining/${patientId}`,
                        type: 'GET',
                        dataSrc: function(json) {
                            // Pastikan data berada di dalam 'skrining_data'
                            console.log(json.skrining_data);
                            return json.skrining_data; // Mengembalikan data yang sesuai
                        },
                        error: function(xhr, error) {
                            console.error('Error fetching data:', error);
                            alert('Error fetching skrining data!');
                        }
                    },
                    columns: [
                        {
                            data: 'jenis_skrining', // Sesuaikan dengan data yang diterima
                            name: 'jenis_skrining',
                            title: 'Jenis Skrining'
                        },
                        {
                            data: 'kesimpulan_skrining', // Sesuaikan dengan data yang diterima
                            name: 'kesimpulan_skrining',
                            title: 'Kesimpulan Skrining'
                        }
                    ],
                    destroy: true, // Mengizinkan inisialisasi ulang jika sudah ada DataTable
                    processing: true,
                    serverSide: true
                });
            }
        } else {
            alert('Pilih pasien terlebih dahulu!');
        }
    });
});


</script>
