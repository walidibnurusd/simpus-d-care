<<<<<<< HEAD
    @extends('layouts.simple.master')
    @section('title', 'Tindakan')

    @section('css')

    @endsection

    @section('style')
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/datatables.css') }}">
    @endsection

    @section('breadcrumb-title')
        <h3>Tindakan Dokter</h3>
    @endsection

    @section('breadcrumb-items')
        <li class="breadcrumb-item">{{ Auth::user()->name }}</li>
        <li class="breadcrumb-item active">Tindakan Dokter</li>
    @endsection

    @section('content')
        <div class="main-content content mt-6" id="main-content">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Success!</strong> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="row">
                <div class="col-12 mb-4">
                    <div class="button-container">
                        <!-- Tombol Tambah -->
                        @if (Auth::user()->role == 'dokter' || Auth::user()->role == 'tindakan')
                            <button type="button" class="btn btn-success" data-bs-toggle="modal"
                                data-bs-target="#addActionModal">
                                Tambah
                                <i class="fas fa-plus ms-2"></i> <!-- Ikon Tambah -->
                            </button>
                        @endif
                        <!-- Form untuk Print dan Filter -->
                        <form action="{{ route('action.report') }}" method="GET" target="_blank" class="mt-3">
                            <div class="row">
                                <!-- Start Date -->
                                <div class="col-md-4">
                                    <label for="start_date" class="form-label">Start Date</label>
                                    <input type="date" name="start_date" id="start_date" class="form-control">
                                </div>

                                <!-- End Date -->
                                <div class="col-md-4">
                                    <label for="end_date" class="form-label">End Date</label>
                                    <input type="date" name="end_date" id="end_date" class="form-control">
                                </div>

                                <!-- Tombol Print -->
                                <div class="col-md-2 d-flex align-items-end">
                                    <button type="submit" class="btn btn-warning w-100">
                                        Print
                                        <i class="fas fa-print ms-2"></i> <!-- Ikon Print -->
                                    </button>
                                </div>
                            </div>
                        </form>

                        <!-- Tombol Filter -->
                        <div class="row mt-3">
                            <div class="col-md-2 offset-md-8 d-flex align-items-end">
                                <button type="button" id="filterButton" class="btn btn-primary w-100">
                                    Cari <i class="fas fa-search ms-2"></i> <!-- Ikon Cari -->
                                </button>
                            </div>
                        </div>
                    </div>


                    @include('component.modal-add-action-dokter')

                    <div class="card mb-4">
                        <div class="card-header pb-0">
                            <h6>Daftar Data Tindakan</h6>
                        </div>
                        <div class="card-body px-0 pt-0 pb-2">
                            <div class="table-responsive p-4">
                                <table id="actionTable" class="table align-items-center mb-0">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>TANGGAL</th>
                                            <th>NIK/NO.RM</th>
                                            <th>NAMA</th>
                                            <th>UMUR</th>
                                            <th>KARTU</th>
                                            <th>KELUHAN</th>
                                            <th>DIAGNOSA</th>
                                            <th>TINDAKAN POLI</th>

                                            @if ($routeName === 'action.dokter.ruang.tindakan.index')
                                                <th>TINDAKAN RUANG TINDAKAN</th>
                                            @endif
                                            <th>HASIL LAB</th>
                                            <th>OBAT</th>
                                            <th>UPDATE APOTIK</th>
                                            <th>RUJUK RS</th>
                                            <th>KUNJ</th>
                                            <th>FASKES</th>
                                            @if (Auth::user()->role == 'dokter' || Auth::user()->role == 'apotik' || Auth::user()->role == 'tindakan')
                                                <th>AKSI</th>
                                            @endif
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>

    @endsection

    @section('script')
        <script src="https://cdn.jsdelivr.net/npm/moment@2.29.1/moment.min.js"></script>
        @if ($routeName == 'action.dokter.index')
            <script>
                $(document).ready(function() {
                    const table = $('#actionTable').DataTable({
                        processing: true,
                        serverSide: true,
                        ajax: {
                            url: "{{ route('action.dokter.index') }}",
                            type: 'GET',
                            data: function(d) {
                                // Add date filters if available
                                d.start_date = $('#start_date').val();
                                d.end_date = $('#end_date').val();
                            }
                        },
                        columns: [{
                                data: 'DT_RowIndex',
                                name: 'DT_RowIndex',
                                orderable: false,
                                searchable: false
                            },
                            {
                                data: 'tanggal',
                                name: 'tanggal'
                            },
                            {
                                data: 'patient_nik',
                                name: 'patient.nik'
                            },
                            {
                                data: 'patient_name',
                                name: 'patient.name'
                            },
                            {
                                data: 'patient_age',
                                name: 'patient.dob'
                            },
                            {
                                data: 'kartu',
                                name: 'patient.jenis_kartu'
                            },
                            {
                                data: 'keluhan',
                                name: 'keluhan'
                            },
                            {
                                data: 'diagnosa',
                                name: 'diagnosa'
                            },
                            {
                                data: 'tindakan',
                                name: 'tindakan'
                            },
                            {
                                data: 'hasil_lab',
                                name: 'hasil_lab'
                            },
                            {
                                data: 'obat',
                                name: 'obat'
                            },
                            {
                                data: 'update_obat',
                                name: 'update_obat'
                            },
                            {
                                data: 'hospital_referral.name',
                                name: 'hospitalReferral.name'
                            },
                            {
                                data: 'kunjungan',
                                data: 'kunjungan',

                            },
                            {
                                data: 'faskes',
                                render: function(data, type, row) {

                                    let faskes = data || row.patient.wilayah_faskes;


                                    if (faskes === 1 || faskes === 'ya') {
                                        return 'Ya';
                                    } else if (faskes === 0 || faskes === 'tidak') {
                                        return 'Luar Wilayah';
                                    } else {
                                        return faskes;
                                    }
                                }
                            },
                            @if (Auth::user()->role == 'dokter' || Auth::user()->role == 'apotik')
                                {
                                    data: 'action',
                                    name: 'action',
                                    orderable: false,
                                    searchable: false
                                }
                            @endif
                        ],
                        order: [
                            [1, 'desc']
                        ]
                    });

                    $('#filterButton').on('click', function() {

                        table.ajax.reload(); // Corrected reload function
                    });
                });
            </script>
        @elseif ($routeName == 'action.dokter.gigi.index')
            <script>
                $(document).ready(function() {
                    var table = $('#actionTable').DataTable({
                        processing: true,
                        serverSide: true,
                        ajax: {
                            url: "{{ route('action.dokter.gigi.index') }}",
                            type: 'GET',
                            data: function(d) {
                                // Add date filters if available
                                var start_date = $('#start_date').val();
                                var end_date = $('#end_date').val();
                                if (start_date) {
                                    d.start_date = start_date;
                                }
                                if (end_date) {
                                    d.end_date = end_date;
                                }

                                // console.log("Start Date: ", start_date);
                                // console.log("End Date: ", end_date);
                            }
                        },
                        columns: [{
                                data: 'DT_RowIndex',
                                name: 'DT_RowIndex',
                                orderable: false,
                                searchable: false
                            },
                            {
                                data: 'tanggal',
                                name: 'tanggal'
                            },
                            {
                                data: 'patient_nik',
                                name: 'patient.nik'
                            },
                            {
                                data: 'patient_name',
                                name: 'patient.name'
                            },
                            {
                                data: 'patient_age',
                                name: 'patient.dob'
                            },
                            {
                                data: 'kartu',
                                name: 'patient.jenis_kartu'
                            },
                            {
                                data: 'keluhan',
                                name: 'keluhan'
                            },
                            {
                                data: 'diagnosa',
                                name: 'diagnosa'
                            },
                            {
                                data: 'tindakan',
                                name: 'tindakan'
                            },
                            {
                                data: 'hasil_lab',
                                name: 'hasil_lab'
                            },
                            {
                                data: 'obat',
                                name: 'obat'
                            }, {
                                data: 'update_obat',
                                name: 'update_obat'
                            },
                            {
                                data: 'hospital_referral.name',
                                name: 'hospitalReferral.name'
                            },
                            {
                                data: 'kunjungan',
                                name: 'kunjungan'
                            },
                            {
                                data: 'faskes',
                                render: function(data, type, row) {

                                    let faskes = data || row.patient.wilayah_faskes;


                                    if (faskes === 1 || faskes === 'ya') {
                                        return 'Ya';
                                    } else if (faskes === 0 || faskes === 'tidak') {
                                        return 'Luar Wilayah';
                                    } else {
                                        return faskes;
                                    }
                                }
                            },
                            @if (Auth::user()->role == 'dokter' || Auth::user()->role == 'apotik')
                                {
                                    data: 'action',
                                    name: 'action',
                                    orderable: false,
                                    searchable: false
                                }
                            @endif
                        ],
                        order: [
                            [1, 'desc']
                        ]
                    });

                    $('#filterButton').on('click', function() {
                        table.ajax.reload(); // Corrected reload function
                    });
                });
            </script>
        @elseif ($routeName == 'action.dokter.ugd.index')
            <script>
                $(document).ready(function() {
                    var table = $('#actionTable').DataTable({
                        processing: true,
                        serverSide: true,
                        ajax: {
                            url: "{{ route('action.dokter.ugd.index') }}",
                            type: 'GET',
                            data: function(d) {
                                // Add date filters if available
                                var start_date = $('#start_date').val();
                                var end_date = $('#end_date').val();
                                if (start_date) {
                                    d.start_date = start_date;
                                }
                                if (end_date) {
                                    d.end_date = end_date;
                                }

                            }
                        },
                        columns: [{
                                data: 'DT_RowIndex',
                                name: 'DT_RowIndex',
                                orderable: false,
                                searchable: false
                            },
                            {
                                data: 'tanggal',
                                name: 'tanggal'
                            },
                            {
                                data: 'patient_nik',
                                name: 'patient.nik'
                            },
                            {
                                data: 'patient_name',
                                name: 'patient.name'
                            },
                            {
                                data: 'patient_age',
                                name: 'patient.dob'
                            },
                            {
                                data: 'kartu',
                                name: 'patient.jenis_kartu'
                            },
                            {
                                data: 'keluhan',
                                name: 'keluhan'
                            },
                            {
                                data: 'diagnosa',
                                name: 'diagnosa'
                            },
                            {
                                data: 'tindakan',
                                name: 'tindakan'
                            },
                            {
                                data: 'hasil_lab',
                                name: 'hasil_lab'
                            },
                            {
                                data: 'obat',
                                name: 'obat'
                            }, {
                                data: 'update_obat',
                                name: 'update_obat'
                            },
                            {
                                data: 'hospital_referral.name',
                                name: 'hospitalReferral.name'
                            },
                            {
                                data: 'kunjungan',
                                name: 'kunjungan'
                            },
                            {
                                data: 'faskes',
                                render: function(data, type, row) {

                                    let faskes = data || row.patient.wilayah_faskes;


                                    if (faskes === 1 || faskes === 'ya') {
                                        return 'Ya';
                                    } else if (faskes === 0 || faskes === 'tidak') {
                                        return 'Luar Wilayah';
                                    } else {
                                        return faskes;
                                    }
                                }
                            },
                            @if (Auth::user()->role == 'dokter' || Auth::user()->role == 'apotik' || Auth::user()->role == 'tindakan')
                                {
                                    data: 'action',
                                    name: 'action',
                                    orderable: false,
                                    searchable: false
                                }
                            @endif
                        ],
                        order: [
                            [1, 'desc']
                        ]
                    });

                    $('#filterButton').on('click', function() {

                        table.ajax.reload(); // Corrected reload function
                    });
                });
            </script>
        @elseif ($routeName == 'action.dokter.ruang.tindakan.index')
            <script>
                $(document).ready(function() {
                    var table = $('#actionTable').DataTable({
                        processing: true,
                        serverSide: true,
                        ajax: {
                            url: "{{ route('action.dokter.ruang.tindakan.index') }}",
                            type: 'GET',
                            data: function(d) {
                                // Add date filters if available
                                var start_date = $('#start_date').val();
                                var end_date = $('#end_date').val();
                                if (start_date) {
                                    d.start_date = start_date;
                                }
                                if (end_date) {
                                    d.end_date = end_date;
                                }

                            }
                        },
                        columns: [{
                                data: 'DT_RowIndex',
                                name: 'DT_RowIndex',
                                orderable: false,
                                searchable: false
                            },
                            {
                                data: 'tanggal',
                                name: 'tanggal'
                            },
                            {
                                data: 'patient_nik',
                                name: 'patient.nik'
                            },
                            {
                                data: 'patient_name',
                                name: 'patient.name'
                            },
                            {
                                data: 'patient_age',
                                name: 'patient.dob'
                            },
                            {
                                data: 'kartu',
                                name: 'patient.jenis_kartu'
                            },
                            {
                                data: 'keluhan',
                                name: 'keluhan'
                            },
                            {
                                data: 'diagnosa',
                                name: 'diagnosa'
                            },
                            {
                                data: 'tindakan',
                                name: 'tindakan'
                            },
                            {
                                data: 'tindakan_ruang_tindakan',
                                name: 'tindakan_ruang_tindakan'
                            },
                            {
                                data: 'hasil_lab',
                                name: 'hasil_lab'
                            },
                            {
                                data: 'obat',
                                name: 'obat'
                            }, {
                                data: 'update_obat',
                                name: 'update_obat'
                            },
                            {
                                data: 'hospital_referral.name',
                                name: 'hospitalReferral.name'
                            },
                            {
                                data: 'kunjungan',
                                name: 'kunjungan'
                            },
                            {
                                data: 'faskes',
                                render: function(data, type, row) {

                                    let faskes = data || row.patient.wilayah_faskes;


                                    if (faskes === 1 || faskes === 'ya') {
                                        return 'Ya';
                                    } else if (faskes === 0 || faskes === 'tidak') {
                                        return 'Luar Wilayah';
                                    } else {
                                        return faskes;
                                    }
                                }
                            },
                            @if (Auth::user()->role == 'tindakan')
                                {
                                    data: 'action',
                                    name: 'action',
                                    orderable: false,
                                    searchable: false
                                }
                            @endif
                        ],
                        order: [
                            [1, 'desc']
                        ]
                    });

                    $('#filterButton').on('click', function() {

                        table.ajax.reload(); // Corrected reload function
                    });
                });
            </script>
        @endif
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Check for success message
                @if (session('success'))
                    Swal.fire({
                        title: 'Success!',
                        text: "{{ session('success') }}",
                        icon: 'success',
                        confirmButtonText: 'OK'
                    });
                @endif

                // Check for validation errors
                @if ($errors->any())
                    Swal.fire({
                        title: 'Error!',
                        html: '<ul>' +
                            '@foreach ($errors->all() as $error)' +
                            '<li>{{ $error }}</li>' +
                            '@endforeach' +
                            '</ul>',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                @endif
            });
        </script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                document.querySelectorAll('.btn-delete').forEach(function(button) {
                    button.addEventListener('click', function(event) {
                        event.preventDefault();

                        var formAction = this.getAttribute('data-form-action');

                        Swal.fire({
                            title: 'Konfirmasi Penghapusan',
                            text: 'Apakah Anda yakin ingin menghapus Tindakan ini?',
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
                                // Create and submit the form
                                var form = document.createElement('form');
                                form.method = 'POST';
                                form.action = formAction;

                                var csrfToken = document.createElement('input');
                                csrfToken.type = 'hidden';
                                csrfToken.name = '_token';
                                csrfToken.value = "{{ csrf_token() }}";
                                form.appendChild(csrfToken);

                                var methodField = document.createElement('input');
                                methodField.type = 'hidden';
                                methodField.name = '_method';
                                methodField.value = 'DELETE';
                                form.appendChild(methodField);

                                document.body.appendChild(form);
                                form.submit();
                            }
                        });
                    });
                });
            });
        </script>
    @endsection
=======
    @extends('layouts.simple.master')
    @section('title', 'Tindakan')

    @section('css')

    @endsection

    @section('style')
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/datatables.css') }}">
    @endsection

    @section('breadcrumb-title')
        <h3>Tindakan Dokter</h3>
    @endsection

    @section('breadcrumb-items')
        <li class="breadcrumb-item">{{ Auth::user()->name }}</li>
        <li class="breadcrumb-item active">Tindakan Dokter</li>
    @endsection

    @section('content')
        <div class="main-content content mt-6" id="main-content">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Success!</strong> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="row">
                <div class="col-12 mb-4">
                    <div class="button-container">
                        <!-- Tombol Tambah -->
                        @if (Auth::user()->role == 'dokter' || Auth::user()->role == 'tindakan')
                            <button type="button" class="btn btn-success" data-bs-toggle="modal"
                                data-bs-target="#addActionModal">
                                Tambah
                                <i class="fas fa-plus ms-2"></i> <!-- Ikon Tambah -->
                            </button>
                        @endif
                        <!-- Form untuk Print dan Filter -->
                        <form action="{{ route('action.report') }}" method="GET" target="_blank" class="mt-3">
                            <div class="row">
                                <!-- Start Date -->
                                <div class="col-md-4">
                                    <label for="start_date" class="form-label">Start Date</label>
                                    <input type="date" name="start_date" id="start_date" class="form-control">
                                </div>

                                <!-- End Date -->
                                <div class="col-md-4">
                                    <label for="end_date" class="form-label">End Date</label>
                                    <input type="date" name="end_date" id="end_date" class="form-control">
                                </div>

                                <!-- Tombol Print -->
                                <div class="col-md-2 d-flex align-items-end">
                                    <button type="submit" class="btn btn-warning w-100">
                                        Print
                                        <i class="fas fa-print ms-2"></i> <!-- Ikon Print -->
                                    </button>
                                </div>
                            </div>
                        </form>

                        <!-- Tombol Filter -->
                        <div class="row mt-3">
                            <div class="col-md-2 offset-md-8 d-flex align-items-end">
                                <button type="button" id="filterButton" class="btn btn-primary w-100">
                                    Cari <i class="fas fa-search ms-2"></i> <!-- Ikon Cari -->
                                </button>
                            </div>
                        </div>
                    </div>


                    @include('component.modal-add-action-dokter')

                    <div class="card mb-4">
                        <div class="card-header pb-0">
                            <h6>Daftar Data Tindakan</h6>
                        </div>
                        <div class="card-body px-0 pt-0 pb-2">
                            <div class="table-responsive p-4">
                                <table id="actionTable" class="table align-items-center mb-0">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>TANGGAL</th>
                                            <th>NIK/NO.RM</th>
                                            <th>NAMA</th>
                                            <th>UMUR</th>
                                            <th>KARTU</th>
                                            <th>KELUHAN</th>
                                            <th>DIAGNOSA</th>
                                            <th>TINDAKAN POLI</th>

                                            @if ($routeName === 'action.dokter.ruang.tindakan.index')
                                                <th>TINDAKAN RUANG TINDAKAN</th>
                                            @endif
                                            <th>HASIL LAB</th>
                                            <th>OBAT</th>
                                            <th>UPDATE APOTIK</th>
                                            <th>RUJUK RS</th>
                                            <th>KUNJ</th>
                                            <th>FASKES</th>
                                            @if (Auth::user()->role == 'dokter' || Auth::user()->role == 'apotik' || Auth::user()->role == 'tindakan')
                                                <th>AKSI</th>
                                            @endif
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>

    @endsection

    @section('script')
        <script src="https://cdn.jsdelivr.net/npm/moment@2.29.1/moment.min.js"></script>
        @if ($routeName == 'action.dokter.index')
            <script>
                $(document).ready(function() {
                    const table = $('#actionTable').DataTable({
                        processing: true,
                        serverSide: true,
                        ajax: {
                            url: "{{ route('action.dokter.index') }}",
                            type: 'GET',
                            data: function(d) {
                                // Add date filters if available
                                d.start_date = $('#start_date').val();
                                d.end_date = $('#end_date').val();
                            }
                        },
                        columns: [{
                                data: 'DT_RowIndex',
                                name: 'DT_RowIndex',
                                orderable: false,
                                searchable: false
                            },
                            {
                                data: 'tanggal',
                                name: 'tanggal'
                            },
                            {
                                data: 'patient_nik',
                                name: 'patient.nik'
                            },
                            {
                                data: 'patient_name',
                                name: 'patient.name'
                            },
                            {
                                data: 'patient_age',
                                name: 'patient.dob'
                            },
                            {
                                data: 'kartu',
                                name: 'patient.jenis_kartu'
                            },
                            {
                                data: 'keluhan',
                                name: 'keluhan'
                            },
                            {
                                data: 'diagnosa',
                                name: 'diagnosa'
                            },
                            {
                                data: 'tindakan',
                                name: 'tindakan'
                            },
                            {
                                data: 'hasil_lab',
                                name: 'hasil_lab'
                            },
                            {
                                data: 'obat',
                                name: 'obat'
                            },
                            {
                                data: 'update_obat',
                                name: 'update_obat'
                            },
                            {
                                data: 'hospital_referral.name',
                                name: 'hospitalReferral.name'
                            },
                            {
                                data: 'kunjungan',
                                data: 'kunjungan',

                            },
                            {
                                data: 'faskes',
                                render: function(data, type, row) {

                                    let faskes = data || row.patient.wilayah_faskes;


                                    if (faskes === 1 || faskes === 'ya') {
                                        return 'Ya';
                                    } else if (faskes === 0 || faskes === 'tidak') {
                                        return 'Luar Wilayah';
                                    } else {
                                        return faskes;
                                    }
                                }
                            },
                            @if (Auth::user()->role == 'dokter' || Auth::user()->role == 'apotik')
                                {
                                    data: 'action',
                                    name: 'action',
                                    orderable: false,
                                    searchable: false
                                }
                            @endif
                        ],
                        order: [
                            [1, 'desc']
                        ]
                    });

                    $('#filterButton').on('click', function() {

                        table.ajax.reload(); // Corrected reload function
                    });
                });
            </script>
        @elseif ($routeName == 'action.dokter.gigi.index')
            <script>
                $(document).ready(function() {
                    var table = $('#actionTable').DataTable({
                        processing: true,
                        serverSide: true,
                        ajax: {
                            url: "{{ route('action.dokter.gigi.index') }}",
                            type: 'GET',
                            data: function(d) {
                                // Add date filters if available
                                var start_date = $('#start_date').val();
                                var end_date = $('#end_date').val();
                                if (start_date) {
                                    d.start_date = start_date;
                                }
                                if (end_date) {
                                    d.end_date = end_date;
                                }

                                // console.log("Start Date: ", start_date);
                                // console.log("End Date: ", end_date);
                            }
                        },
                        columns: [{
                                data: 'DT_RowIndex',
                                name: 'DT_RowIndex',
                                orderable: false,
                                searchable: false
                            },
                            {
                                data: 'tanggal',
                                name: 'tanggal'
                            },
                            {
                                data: 'patient_nik',
                                name: 'patient.nik'
                            },
                            {
                                data: 'patient_name',
                                name: 'patient.name'
                            },
                            {
                                data: 'patient_age',
                                name: 'patient.dob'
                            },
                            {
                                data: 'kartu',
                                name: 'patient.jenis_kartu'
                            },
                            {
                                data: 'keluhan',
                                name: 'keluhan'
                            },
                            {
                                data: 'diagnosa',
                                name: 'diagnosa'
                            },
                            {
                                data: 'tindakan',
                                name: 'tindakan'
                            },
                            {
                                data: 'hasil_lab',
                                name: 'hasil_lab'
                            },
                            {
                                data: 'obat',
                                name: 'obat'
                            }, {
                                data: 'update_obat',
                                name: 'update_obat'
                            },
                            {
                                data: 'hospital_referral.name',
                                name: 'hospitalReferral.name'
                            },
                            {
                                data: 'kunjungan',
                                name: 'kunjungan'
                            },
                            {
                                data: 'faskes',
                                render: function(data, type, row) {

                                    let faskes = data || row.patient.wilayah_faskes;


                                    if (faskes === 1 || faskes === 'ya') {
                                        return 'Ya';
                                    } else if (faskes === 0 || faskes === 'tidak') {
                                        return 'Luar Wilayah';
                                    } else {
                                        return faskes;
                                    }
                                }
                            },
                            @if (Auth::user()->role == 'dokter' || Auth::user()->role == 'apotik')
                                {
                                    data: 'action',
                                    name: 'action',
                                    orderable: false,
                                    searchable: false
                                }
                            @endif
                        ],
                        order: [
                            [1, 'desc']
                        ]
                    });

                    $('#filterButton').on('click', function() {
                        table.ajax.reload(); // Corrected reload function
                    });
                });
            </script>
        @elseif ($routeName == 'action.dokter.ugd.index')
            <script>
                $(document).ready(function() {
                    var table = $('#actionTable').DataTable({
                        processing: true,
                        serverSide: true,
                        ajax: {
                            url: "{{ route('action.dokter.ugd.index') }}",
                            type: 'GET',
                            data: function(d) {
                                // Add date filters if available
                                var start_date = $('#start_date').val();
                                var end_date = $('#end_date').val();
                                if (start_date) {
                                    d.start_date = start_date;
                                }
                                if (end_date) {
                                    d.end_date = end_date;
                                }

                            }
                        },
                        columns: [{
                                data: 'DT_RowIndex',
                                name: 'DT_RowIndex',
                                orderable: false,
                                searchable: false
                            },
                            {
                                data: 'tanggal',
                                name: 'tanggal'
                            },
                            {
                                data: 'patient_nik',
                                name: 'patient.nik'
                            },
                            {
                                data: 'patient_name',
                                name: 'patient.name'
                            },
                            {
                                data: 'patient_age',
                                name: 'patient.dob'
                            },
                            {
                                data: 'kartu',
                                name: 'patient.jenis_kartu'
                            },
                            {
                                data: 'keluhan',
                                name: 'keluhan'
                            },
                            {
                                data: 'diagnosa',
                                name: 'diagnosa'
                            },
                            {
                                data: 'tindakan',
                                name: 'tindakan'
                            },
                            {
                                data: 'hasil_lab',
                                name: 'hasil_lab'
                            },
                            {
                                data: 'obat',
                                name: 'obat'
                            }, {
                                data: 'update_obat',
                                name: 'update_obat'
                            },
                            {
                                data: 'hospital_referral.name',
                                name: 'hospitalReferral.name'
                            },
                            {
                                data: 'kunjungan',
                                name: 'kunjungan'
                            },
                            {
                                data: 'faskes',
                                render: function(data, type, row) {

                                    let faskes = data || row.patient.wilayah_faskes;


                                    if (faskes === 1 || faskes === 'ya') {
                                        return 'Ya';
                                    } else if (faskes === 0 || faskes === 'tidak') {
                                        return 'Luar Wilayah';
                                    } else {
                                        return faskes;
                                    }
                                }
                            },
                            @if (Auth::user()->role == 'dokter' || Auth::user()->role == 'apotik' || Auth::user()->role == 'tindakan')
                                {
                                    data: 'action',
                                    name: 'action',
                                    orderable: false,
                                    searchable: false
                                }
                            @endif
                        ],
                        order: [
                            [1, 'desc']
                        ]
                    });

                    $('#filterButton').on('click', function() {

                        table.ajax.reload(); // Corrected reload function
                    });
                });
            </script>
        @elseif ($routeName == 'action.dokter.ruang.tindakan.index')
            <script>
                $(document).ready(function() {
                    var table = $('#actionTable').DataTable({
                        processing: true,
                        serverSide: true,
                        ajax: {
                            url: "{{ route('action.dokter.ruang.tindakan.index') }}",
                            type: 'GET',
                            data: function(d) {
                                // Add date filters if available
                                var start_date = $('#start_date').val();
                                var end_date = $('#end_date').val();
                                if (start_date) {
                                    d.start_date = start_date;
                                }
                                if (end_date) {
                                    d.end_date = end_date;
                                }

                            }
                        },
                        columns: [{
                                data: 'DT_RowIndex',
                                name: 'DT_RowIndex',
                                orderable: false,
                                searchable: false
                            },
                            {
                                data: 'tanggal',
                                name: 'tanggal'
                            },
                            {
                                data: 'patient_nik',
                                name: 'patient.nik'
                            },
                            {
                                data: 'patient_name',
                                name: 'patient.name'
                            },
                            {
                                data: 'patient_age',
                                name: 'patient.dob'
                            },
                            {
                                data: 'kartu',
                                name: 'patient.jenis_kartu'
                            },
                            {
                                data: 'keluhan',
                                name: 'keluhan'
                            },
                            {
                                data: 'diagnosa',
                                name: 'diagnosa'
                            },
                            {
                                data: 'tindakan',
                                name: 'tindakan'
                            },
                            {
                                data: 'tindakan_ruang_tindakan',
                                name: 'tindakan_ruang_tindakan'
                            },
                            {
                                data: 'hasil_lab',
                                name: 'hasil_lab'
                            },
                            {
                                data: 'obat',
                                name: 'obat'
                            }, {
                                data: 'update_obat',
                                name: 'update_obat'
                            },
                            {
                                data: 'hospital_referral.name',
                                name: 'hospitalReferral.name'
                            },
                            {
                                data: 'kunjungan',
                                name: 'kunjungan'
                            },
                            {
                                data: 'faskes',
                                render: function(data, type, row) {

                                    let faskes = data || row.patient.wilayah_faskes;


                                    if (faskes === 1 || faskes === 'ya') {
                                        return 'Ya';
                                    } else if (faskes === 0 || faskes === 'tidak') {
                                        return 'Luar Wilayah';
                                    } else {
                                        return faskes;
                                    }
                                }
                            },
                            @if (Auth::user()->role == 'tindakan')
                                {
                                    data: 'action',
                                    name: 'action',
                                    orderable: false,
                                    searchable: false
                                }
                            @endif
                        ],
                        order: [
                            [1, 'desc']
                        ]
                    });

                    $('#filterButton').on('click', function() {

                        table.ajax.reload(); // Corrected reload function
                    });
                });
            </script>
        @endif
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Check for success message
                @if (session('success'))
                    Swal.fire({
                        title: 'Success!',
                        text: "{{ session('success') }}",
                        icon: 'success',
                        confirmButtonText: 'OK'
                    });
                @endif

                // Check for validation errors
                @if ($errors->any())
                    Swal.fire({
                        title: 'Error!',
                        html: '<ul>' +
                            '@foreach ($errors->all() as $error)' +
                            '<li>{{ $error }}</li>' +
                            '@endforeach' +
                            '</ul>',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                @endif
            });
        </script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                document.querySelectorAll('.btn-delete').forEach(function(button) {
                    button.addEventListener('click', function(event) {
                        event.preventDefault();

                        var formAction = this.getAttribute('data-form-action');

                        Swal.fire({
                            title: 'Konfirmasi Penghapusan',
                            text: 'Apakah Anda yakin ingin menghapus Tindakan ini?',
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
                                // Create and submit the form
                                var form = document.createElement('form');
                                form.method = 'POST';
                                form.action = formAction;

                                var csrfToken = document.createElement('input');
                                csrfToken.type = 'hidden';
                                csrfToken.name = '_token';
                                csrfToken.value = "{{ csrf_token() }}";
                                form.appendChild(csrfToken);

                                var methodField = document.createElement('input');
                                methodField.type = 'hidden';
                                methodField.name = '_method';
                                methodField.value = 'DELETE';
                                form.appendChild(methodField);

                                document.body.appendChild(form);
                                form.submit();
                            }
                        });
                    });
                });
            });
        </script>
    @endsection
>>>>>>> 9df8fede466960d27744a11e4cb830e2a9437611
