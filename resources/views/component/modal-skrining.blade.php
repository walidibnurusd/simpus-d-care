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
    $('#modalSkrining').on('show.bs.modal', function() {
        const patientId = $('#btnCariskrining').data('id'); // Ambil ID pasien dari tombol

        if (patientId) {
            if ($.fn.DataTable.isDataTable('#skrining')) {
                $('#skrining').DataTable().ajax.url(`/get-skrining/${patientId}`).load();
            } else {
                $('#skrining').DataTable({
                    ajax: {
                        url: `/get-skrining-patient/${patientId}`,
                        type: 'GET',
                        dataSrc: 'data',
                        error: function(xhr, error) {
                            console.error('Error fetching data:', error);
                            alert('Error fetching skrining data!');
                        }
                    },
                    columns: [{
                            data: 'jenis',
                            name: 'jenis'
                        },
                        {
                            data: 'kesimpulan',
                            name: 'kesimpulan'
                        },
                    ],
                    destroy: true,
                    processing: true,
                    serverSide: true,
                });
            }
        } else {
            alert('Pilih pasien terlebih dahulu!');
        }
    });
</script>
