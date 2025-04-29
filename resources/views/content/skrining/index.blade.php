<<<<<<< HEAD
@extends('layouts.simple.master')
@section('title', 'Skrining Pasien')

@section('css')

@endsection

@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/datatables.css') }}">
@endsection

@section('breadcrumb-title')
    <h3>Skrining Pasien</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">{{ Auth::user()->name }}</li>
    <li class="breadcrumb-item active">Pasien</li>
@endsection

@section('content')

    <div class="main-content content mt-6" id="main-content">
        <div class="row">
            <div class="col-12" style="min-height: 100vh; overflow-x: hidden;">
                <div class="card mb-4">
                    <div class="card-header pb-0">
                        <h6>Daftar Data Pasien</h6>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-4">
                            <table id="patient" class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">No
                                        </th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            NIK</th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            NAMA</th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            ALAMAT</th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            TEMPAT/TGL.LAHIR</th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            No RM</th>

                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            AKSI</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($patients as $index => $patient)
                                        <tr>
                                            <td>
                                                <h6 class="mb-0 text-sm">{{ $index + 1 }}</h6> <!-- Row number -->
                                            </td>
                                            <td>
                                                <p class="text-xs  mb-0">{{ $patient->nik }}</p>
                                                <!-- NIK -->
                                            </td>
                                            <td>
                                                <p class="text-xs  mb-0">{{ $patient->name }}</p>
                                                <!-- Name -->
                                            </td>
                                            <td>
                                                <p class="text-xs  mb-0">{{ $patient->address }}</p>
                                                <!-- Address -->
                                            </td>
                                            <td>
                                                <p class="text-xs  mb-0">{{ $patient->place_birth }}</p>
                                                <p class="text-xs  mb-0">{{ $patient->dob }}
                                                    <span class="age-red">({{ $patient->getAgeAttribute() }}-thn)</span>
                                                </p>
                                                <!-- Date of Birth -->
                                            </td>
                                            <td>
                                                <p class="text-xs  mb-0">{{ $patient->no_rm }}</p>
                                                <!-- No RM -->
                                            </td>

                                            <td>
                                                <div class="action-buttons">
                                                    <button class="btn btn-primary w-100 mt-2 btnCariskrining"
                                                        type="button" data-id="{{ $patient->id }}" data-bs-toggle="modal"
                                                        data-bs-target="#modalSkrining">
                                                        Hasil Skrining
                                                    </button>
                                                </div>
                                            </td>

                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('component.modal-skrining')
@endsection

@section('script')

    <script>
        $(document).ready(function() {
            // Inisialisasi DataTable untuk daftar pasien
            $('#patient').DataTable({
                language: {
                    info: "_PAGE_ dari _PAGES_ halaman",
                    paginate: {
                        previous: "<",
                        next: ">",
                        first: "<<",
                        last: ">>"
                    }
                },
                responsive: true,
                lengthMenu: [10, 25, 50, 100]
            });

            // Event delegation untuk tombol btnCariskrining
            $(document).on('click', '.btnCariskrining', function() {
                const patientId = $(this).data('id'); // Ambil ID pasien dari tombol
                console.log('Patient ID:', patientId); // Debugging

                if (patientId) {
                    // Jika DataTable sudah diinisialisasi, reload data
                    if ($.fn.DataTable.isDataTable('#skrining')) {
                        $('#skrining').DataTable().ajax.url(`/get-skrining/${patientId}`).load();
                    } else {
                        // Inisialisasi DataTable untuk modal skrining
                        $('#skrining').DataTable({
                            ajax: {
                                url: `/get-skrining/${patientId}`,
                                type: 'GET',
                            },
                            columns: [{
                                    data: 'jenis_skrining'
                                },
                                {
                                    data: 'status_skrining'
                                },
                                {
                                    data: 'kesimpulan_skrining'
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
                    <button class="btn btn-danger btn-sm" onclick="handleDelete('${deleteRoute}', '${row.jenis_skrining}')">
                        Delete
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
                            destroy: true
                        });
                    }
                } else {
                    alert('Patient ID tidak ditemukan!');
                }
            });
        });

        function handleStartSkrining(route) {
            window.open(`${route}`, '_blank');
        }

        // Fungsi untuk membuka detail
        function handleAction(route) {
            window.open(`/admin/${route}`, '_blank');
        }

        function handleDelete(deleteRoute, jenisSkrining) {
            const csrfTokenMeta = document.querySelector('meta[name="csrf-token"]');
            const csrfToken = csrfTokenMeta ? csrfTokenMeta.getAttribute('content') : null;

            if (!csrfToken) {
                alert('CSRF token tidak ditemukan. Pastikan meta tag CSRF ada di halaman.');
                return;
            }
            console.log('Delete Route:', deleteRoute);


            Swal.fire({
                title: 'Konfirmasi Penghapusan',
                text: `Apakah Anda yakin ingin menghapus skrining "${jenisSkrining}"?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Hapus',
                cancelButtonText: 'Batal',
                customClass: {
                    popup: 'swal2-popup-custom'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(deleteRoute, {
                            method: 'DELETE',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrfToken,
                            },
                        })
                        .then(response => {
                            if (response.ok) {
                                Swal.fire(
                                    'Berhasil!',
                                    'Data skrining berhasil dihapus.',
                                    'success'
                                ).then(() => {
                                    $('#skrining').DataTable().ajax
                                        .reload(); // Reload DataTable setelah penghapusan
                                });
                            } else {
                                return response.json().then(data => {
                                    throw new Error(data.error || 'Gagal menghapus data.');
                                });
                            }
                        })
                        .catch(error => {
                            Swal.fire(
                                'Kesalahan!',
                                error.message,
                                'error'
                            );
                        });
                }
            });
        }
    </script>

@endsection
=======
@extends('layouts.simple.master')
@section('title', 'Skrining Pasien')

@section('css')

@endsection

@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/datatables.css') }}">
@endsection

@section('breadcrumb-title')
    <h3>Skrining Pasien</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">{{ Auth::user()->name }}</li>
    <li class="breadcrumb-item active">Pasien</li>
@endsection

@section('content')

    <div class="main-content content mt-6" id="main-content">
        <div class="row">
            <div class="col-12" style="min-height: 100vh; overflow-x: hidden;">
                <div class="card mb-4">
                    <div class="card-header pb-0">
                        <h6>Daftar Data Pasien</h6>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-4">
                            <table id="patient" class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">No
                                        </th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            NIK</th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            NAMA</th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            ALAMAT</th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            TEMPAT/TGL.LAHIR</th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            No RM</th>

                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            AKSI</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($patients as $index => $patient)
                                        <tr>
                                            <td>
                                                <h6 class="mb-0 text-sm">{{ $index + 1 }}</h6> <!-- Row number -->
                                            </td>
                                            <td>
                                                <p class="text-xs  mb-0">{{ $patient->nik }}</p>
                                                <!-- NIK -->
                                            </td>
                                            <td>
                                                <p class="text-xs  mb-0">{{ $patient->name }}</p>
                                                <!-- Name -->
                                            </td>
                                            <td>
                                                <p class="text-xs  mb-0">{{ $patient->address }}</p>
                                                <!-- Address -->
                                            </td>
                                            <td>
                                                <p class="text-xs  mb-0">{{ $patient->place_birth }}</p>
                                                <p class="text-xs  mb-0">{{ $patient->dob }}
                                                    <span class="age-red">({{ $patient->getAgeAttribute() }}-thn)</span>
                                                </p>
                                                <!-- Date of Birth -->
                                            </td>
                                            <td>
                                                <p class="text-xs  mb-0">{{ $patient->no_rm }}</p>
                                                <!-- No RM -->
                                            </td>

                                            <td>
                                                <div class="action-buttons">
                                                    <button class="btn btn-primary w-100 mt-2 btnCariskrining"
                                                        type="button" data-id="{{ $patient->id }}" data-bs-toggle="modal"
                                                        data-bs-target="#modalSkrining">
                                                        Hasil Skrining
                                                    </button>
                                                </div>
                                            </td>

                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('component.modal-skrining')
@endsection

@section('script')

    <script>
        $(document).ready(function() {
            // Inisialisasi DataTable untuk daftar pasien
            $('#patient').DataTable({
                language: {
                    info: "_PAGE_ dari _PAGES_ halaman",
                    paginate: {
                        previous: "<",
                        next: ">",
                        first: "<<",
                        last: ">>"
                    }
                },
                responsive: true,
                lengthMenu: [10, 25, 50, 100]
            });

            // Event delegation untuk tombol btnCariskrining
            $(document).on('click', '.btnCariskrining', function() {
                const patientId = $(this).data('id'); // Ambil ID pasien dari tombol
                console.log('Patient ID:', patientId); // Debugging

                if (patientId) {
                    // Jika DataTable sudah diinisialisasi, reload data
                    if ($.fn.DataTable.isDataTable('#skrining')) {
                        $('#skrining').DataTable().ajax.url(`/get-skrining/${patientId}`).load();
                    } else {
                        // Inisialisasi DataTable untuk modal skrining
                        $('#skrining').DataTable({
                            ajax: {
                                url: `/get-skrining/${patientId}`,
                                type: 'GET',
                            },
                            columns: [{
                                    data: 'jenis_skrining'
                                },
                                {
                                    data: 'status_skrining'
                                },
                                {
                                    data: 'kesimpulan_skrining'
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
                    <button class="btn btn-danger btn-sm" onclick="handleDelete('${deleteRoute}', '${row.jenis_skrining}')">
                        Delete
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
                            destroy: true
                        });
                    }
                } else {
                    alert('Patient ID tidak ditemukan!');
                }
            });
        });

        function handleStartSkrining(route) {
            window.open(`${route}`, '_blank');
        }

        // Fungsi untuk membuka detail
        function handleAction(route) {
            window.open(`/admin/${route}`, '_blank');
        }

        function handleDelete(deleteRoute, jenisSkrining) {
            const csrfTokenMeta = document.querySelector('meta[name="csrf-token"]');
            const csrfToken = csrfTokenMeta ? csrfTokenMeta.getAttribute('content') : null;

            if (!csrfToken) {
                alert('CSRF token tidak ditemukan. Pastikan meta tag CSRF ada di halaman.');
                return;
            }
            console.log('Delete Route:', deleteRoute);


            Swal.fire({
                title: 'Konfirmasi Penghapusan',
                text: `Apakah Anda yakin ingin menghapus skrining "${jenisSkrining}"?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Hapus',
                cancelButtonText: 'Batal',
                customClass: {
                    popup: 'swal2-popup-custom'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(deleteRoute, {
                            method: 'DELETE',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrfToken,
                            },
                        })
                        .then(response => {
                            if (response.ok) {
                                Swal.fire(
                                    'Berhasil!',
                                    'Data skrining berhasil dihapus.',
                                    'success'
                                ).then(() => {
                                    $('#skrining').DataTable().ajax
                                        .reload(); // Reload DataTable setelah penghapusan
                                });
                            } else {
                                return response.json().then(data => {
                                    throw new Error(data.error || 'Gagal menghapus data.');
                                });
                            }
                        })
                        .catch(error => {
                            Swal.fire(
                                'Kesalahan!',
                                error.message,
                                'error'
                            );
                        });
                }
            });
        }
    </script>

@endsection
>>>>>>> 9df8fede466960d27744a11e4cb830e2a9437611
