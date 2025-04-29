<<<<<<< HEAD
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
                            <th>Status</th>
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
    $(document).ready(function() {
        $('#btnCariSkrining').on('click', function() {
            const patientId = $(this).data('id'); // Ambil ID pasien dari tombol
            console.log('data pasien', patientId);

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
                        columns: [{
                                data: 'jenis_skrining',
                                title: 'Jenis Skrining'
                            },
                            {
                                data: 'status_skrining',
                                title: 'Status Skrining'
                            },
                            {
                                data: 'kesimpulan_skrining',
                                title: 'Kesimpulan Skrining'
                            },
                            {
                                data: null,
                                title: 'Action',
                                render: function(data, type, row) {
                                    let actionButtons = '';

                                    // Jika status skrining belum selesai, tampilkan tombol Mulai Skrining
                                    if (row.status_skrining === 'Belum Selesai') {
                                        const startRoute =
                                            `${data.poliPatient}/${data.route_name}/${data.patientId}`;
                                        console.log(startRoute);
                                        actionButtons += `
                    <button class="btn btn-success btn-sm" onclick="handleStartSkrining('${startRoute}')">
                        Mulai Skrining
                    </button>
                `;
                                    }

                                    // Jika data skrining ada, tampilkan tombol Detail dan Delete
                                    if (row.status_skrining == 'Selesai') {
                                        const detailRoute =
                                            `${data.poli}/${data.route_name}/${data.id}`;
                                        const deleteRoute =
                                            `admin/${data.poli}/${data.route_name}/${data.id}`;

                                        actionButtons += `
                    <button class="btn btn-primary btn-sm" onclick="handleAction('${detailRoute}')">
                        Detail
                    </button>
                `;
                                    }

                                    return actionButtons ||
                                        '<span class="text-muted">Tidak ada aksi</span>';
                                }
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
        $('#modalSkrining').on('hidden.bs.modal', function() {
            console.log('Modal Skrining ditutup!');
        });
    });

    function handleStartSkrining(route) {
        window.open(`/${route}`, '_blank');
    }
    // Contoh fungsi untuk menangani aksi di tombol Action
    function handleAction(route) {
        const url = `/admin/${route}`;
        window.open(url, '_blank');
    }
</script>
=======
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
                            <th>Status</th>
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
    $(document).ready(function() {
        $('#btnCariSkrining').on('click', function() {
            const patientId = $(this).data('id'); // Ambil ID pasien dari tombol
            console.log('data pasien', patientId);

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
                        columns: [{
                                data: 'jenis_skrining',
                                title: 'Jenis Skrining'
                            },
                            {
                                data: 'status_skrining',
                                title: 'Status Skrining'
                            },
                            {
                                data: 'kesimpulan_skrining',
                                title: 'Kesimpulan Skrining'
                            },
                            {
                                data: null,
                                title: 'Action',
                                render: function(data, type, row) {
                                    const route =
                                        `show/${data.poli}/${data.route_name}/${data.id}`;
                                    return `<button class="btn btn-primary btn-sm" onclick="handleAction('${route}')">Detail</button>`;
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
        $('#modalSkrining').on('hidden.bs.modal', function() {
            console.log('Modal Skrining ditutup!');
        });
    });

    // Contoh fungsi untuk menangani aksi di tombol Action
    function handleAction(route) {
        const url = `/admin/${route}`;
        window.open(url, '_blank');
    }
</script>
>>>>>>> 9df8fede466960d27744a11e4cb830e2a9437611
