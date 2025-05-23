<!-- Modal untuk Menampilkan Riwayat Berobat -->
<div class="modal fade" id="modalBerobatEdit" tabindex="-1" aria-labelledby="modalSkriningLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalSkriningLabel">Daftar Riwayat Berobat</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table class="table table-striped" id="berobatEdit">
                    <thead>
                        <tr>
                            <th>Tgl Kunjungan</th>
                            <th>Poli Berobat</th>
                            <th>Diagnosa</th>
                            <th>ICD10</th>
                            <th>Obat</th>
                            <th>Hasil Lab</th>
                            <th>Rujuk Poli</th>
                            <th>Rujuk RS</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Data akan dimuat via AJAX -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Sertakan jQuery (pastikan versi 3.6.0 atau sesuai) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Sertakan script Bootstrap JS dan DataTables JS sesuai kebutuhan -->

<script>
    $(document).ready(function() {
        // Event handler untuk tombol pencarian/lihat riwayat berobatEdit
        $('.btnCariRiwayatBerobatEdit').on('click', function() {
            // Ambil ID pasien dari data attribute pada tombol
            const patientId = $(this).data('patient-id');


            if (patientId) {
                // Jika DataTable sudah diinisialisasi di table dengan id #berobatEdit, perbarui URL ajax dan reload datanya
                if ($.fn.DataTable.isDataTable('#berobatEdit')) {
                    $('#berobatEdit').DataTable().ajax.url(`/get-patients-kunjungan/${patientId}`)
                        .load();
                } else {
                    // Jika belum, inisialisasi DataTable baru
                    $('#berobatEdit').DataTable({
                        processing: true,
                        serverSide: true,
                        ajax: `/get-patients-kunjungan/${patientId}`,
                        columns: [{
                                data: 'tanggal',
                                name: 'tanggal'
                            },
                            {
                                data: 'poli',
                                name: 'poli'
                            },
                            {
                                data: 'diagnosa',
                                name: 'diagnosa'
                            },
                            {
                                data: 'icd10',
                                name: 'icd10'
                            },
                            {
                                data: 'obat',
                                name: 'obat'
                            },
                           {
                                data: 'hasil_lab',
                                name: 'hasil_lab',
                                render: function(data, type, row) {
                                    return type === 'display' ? data : data.replace(/<br\s*\/?>/g, '\n');
                                }
                            },


                            {
                                data: 'rujuk_poli',
                                name: 'rujuk_poli'
                            },
                            {
                                data: 'rujuk_rs',
                                name: 'rujuk_rs'
                            }
                        ]
                    });
                }
                // Tampilkan modal (pastikan Anda menggunakan Bootstrap 5 atau sesuaikan dengan library modal Anda)
                $('#modalBerobatEdit').modal('show');
            } else {
                alert('Pilih pasien terlebih dahulu!');
            }
        });

        // Event handler ketika modal ditutup
        $('#modalBerobatEdit').on('hidden.bs.modal', function() {});
    });
</script>
