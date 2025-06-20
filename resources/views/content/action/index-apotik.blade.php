@extends('layouts.simple.master')
@section('title', 'Tindakan Apotik')

@section('css')

@endsection

@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/datatables.css') }}">
@endsection

@section('breadcrumb-title')
    <h3>Tindakan Apotek</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">{{ Auth::user()->name }}</li>
    <li class="breadcrumb-item active">Tindakan</li>
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

                    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addActionModal">
                        Tambah
                        <i class="fas fa-plus ms-2"></i> <!-- Ikon Tambah -->
                    </button>

                    <!-- Form untuk Print dan Filter -->
                    <form action="{{ route('action.report') }}" method="GET" target="_blank" class="mt-3">
                        <div class="row mb-2">
                            <!-- Start Date -->
                            <div class="col-md-3">
                                <label for="start_date" class="form-label">Start Date</label>
                                <input type="date" name="start_date" id="start_date" class="form-control">
                            </div>

                            <!-- End Date -->
                            <div class="col-md-3">
                                <label for="end_date" class="form-label">End Date</label>
                                <input type="date" name="end_date" id="end_date" class="form-control">
                            </div>
                            <div class="col-md-3">
                                <label for="poli">Poli</label>
                                <select class="form-control" id="poli" name="poli">
                                    <option value="" disabled selected>Pilih Poli</option>
                                    <option value="poli-umum">Poli Umum</option>
                                    <option value="poli-gigi">Poli Gigi</option>
                                    <option value="poli-kia">Poli KIA</option>
                                    <option value="poli-kb">Poli KB</option>
                                    <option value="ruang-tindakan">UGD</option>
                                </select>
                            </div>

                            <!-- Tombol Print & Filter-->
                            <div class="col-md-3 d-flex align-items-end">
                                <button type="submit" class="btn btn-warning w-100 mr-2">
                                    Print
                                    <i class="fas fa-print ms-2"></i> <!-- Ikon Print -->
                                </button>
                                <button type="button" id="filterButton" class="btn btn-primary w-100">
                                    Cari <i class="fas fa-search ms-2"></i> <!-- Ikon Cari -->
                                </button>
                            </div>
                        </div>
                    </form>
                </div>


                @include('component.modal-add-action-apotik')

                <div class="card mb-4">
                    <div class="card-header pb-0">
                        <h6>Daftar Data Tindakan</h6>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-4">
                            <table id="actions-table" class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            No
                                        </th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            TANGGAL</th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            NIK/NO.RM</th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            NAMA</th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            UMUR</th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            OBAT</th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            UPDATE OBAT</th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            POLI</th>

                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            AKSI
                                        </th>

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
    {{-- @if ($routeName == 'action.apotik.index') --}}
    <script>
        $(document).ready(function() {
            // Initialize DataTable with pagination
            var table = $('#actions-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route('action.apotik.index') }}',
                    data: function(d) {
                        // Send filter data along with the request
                        d.start_date = $('#start_date').val();
                        d.end_date = $('#end_date').val();
                        d.poli = $('#poli').val();
                    }
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'tanggal',
                        name: 'tanggal'
                    },
                    {
                        data: 'patient_nik',
                        name: 'patient_nik'
                    },
                    {
                        data: 'patient_name',
                        name: 'patient_name'
                    },
                    {
                        data: 'patient_age',
                        name: 'patient_age'
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
                        data: 'tipe',
                        name: 'tipe'
                    },

                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ],
                pageLength: 10, // Set default page size
                lengthMenu: [10, 25, 50, 100], // Set available page sizes
                drawCallback: function(settings) {
                    // You can adjust the pagination here if needed, for example:
                    var totalPages = settings.json.recordsTotal / settings._iDisplayLength;
                }
            });

            // Filter Form Submission (on change)
            $('#filterButton').on('click', function() {

                table.ajax.reload(); // Corrected reload function
            });
        });
    </script>
    {{-- @elseif ($routeName == 'action.apotik.gigi.index')
        <script>
            $(document).ready(function() {
                // Initialize DataTable with pagination
                var table = $('#actions-table').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: '{{ route('action.apotik.gigi.index') }}',
                        data: function(d) {
                            // Send filter data along with the request
                            d.start_date = $('#start_date').val();
                            d.end_date = $('#end_date').val();
                        }
                    },
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex'
                        },
                        {
                            data: 'tanggal',
                            name: 'tanggal'
                        },
                        {
                            data: 'patient_nik',
                            name: 'patient_nik'
                        },
                        {
                            data: 'patient_name',
                            name: 'patient_name'
                        },
                        {
                            data: 'patient_age',
                            name: 'patient_age'
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
                            data: 'action',
                            name: 'action',
                            orderable: false,
                            searchable: false
                        }
                    ],
                    pageLength: 10, // Set default page size
                    lengthMenu: [10, 25, 50, 100], // Set available page sizes
                    drawCallback: function(settings) {
                        // You can adjust the pagination here if needed, for example:
                        var totalPages = settings.json.recordsTotal / settings._iDisplayLength;
                    }
                });

                // Filter Form Submission (on change)
                $('#filter-form').on('submit', function(e) {
                    e.preventDefault(); // Prevent default form submission
                    table.draw(); // Redraw DataTable with new filters
                });
            });
        </script>
    @elseif ($routeName == 'action.apotik.ugd.index')
        <script>
            $(document).ready(function() {
                // Initialize DataTable with pagination
                var table = $('#actions-table').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: '{{ route('action.apotik.ugd.index') }}',
                        data: function(d) {
                            // Send filter data along with the request
                            d.start_date = $('#start_date').val();
                            d.end_date = $('#end_date').val();
                        }
                    },
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex'
                        },
                        {
                            data: 'tanggal',
                            name: 'tanggal'
                        },
                        {
                            data: 'patient_nik',
                            name: 'patient_nik'
                        },
                        {
                            data: 'patient_name',
                            name: 'patient_name'
                        },
                        {
                            data: 'patient_age',
                            name: 'patient_age'
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
                            data: 'action',
                            name: 'action',
                            orderable: false,
                            searchable: false
                        }
                    ],
                    pageLength: 10, // Set default page size
                    lengthMenu: [10, 25, 50, 100], // Set available page sizes
                    drawCallback: function(settings) {
                        // You can adjust the pagination here if needed, for example:
                        var totalPages = settings.json.recordsTotal / settings._iDisplayLength;
                    }
                });

                // Filter Form Submission (on change)
                $('#filter-form').on('submit', function(e) {
                    e.preventDefault(); // Prevent default form submission
                    table.draw(); // Redraw DataTable with new filters
                });
            });
        </script>
    @elseif ($routeName == 'action.apotik.kia.index')
        <script>
            $(document).ready(function() {
                // Initialize DataTable with pagination
                var table = $('#actions-table').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: '{{ route('action.apotik.kia.index') }}',
                        data: function(d) {
                            // Send filter data along with the request
                            d.start_date = $('#start_date').val();
                            d.end_date = $('#end_date').val();
                        }
                    },
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex'
                        },
                        {
                            data: 'tanggal',
                            name: 'tanggal'
                        },
                        {
                            data: 'patient_nik',
                            name: 'patient_nik'
                        },
                        {
                            data: 'patient_name',
                            name: 'patient_name'
                        },
                        {
                            data: 'patient_age',
                            name: 'patient_age'
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
                            data: 'action',
                            name: 'action',
                            orderable: false,
                            searchable: false
                        }
                    ],
                    pageLength: 10, // Set default page size
                    lengthMenu: [10, 25, 50, 100], // Set available page sizes
                    drawCallback: function(settings) {
                        // You can adjust the pagination here if needed, for example:
                        var totalPages = settings.json.recordsTotal / settings._iDisplayLength;
                    }
                });

                // Filter Form Submission (on change)
                $('#filter-form').on('submit', function(e) {
                    e.preventDefault(); // Prevent default form submission
                    table.draw(); // Redraw DataTable with new filters
                });
            });
        </script>
    @elseif ($routeName == 'action.apotik.kb.index')
        <script>
            $(document).ready(function() {
                // Initialize DataTable with pagination
                var table = $('#actions-table').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: '{{ route('action.apotik.kb.index') }}',
                        data: function(d) {
                            // Send filter data along with the request
                            d.start_date = $('#start_date').val();
                            d.end_date = $('#end_date').val();
                        }
                    },
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex'
                        },
                        {
                            data: 'tanggal',
                            name: 'tanggal'
                        },
                        {
                            data: 'patient_nik',
                            name: 'patient_nik'
                        },
                        {
                            data: 'patient_name',
                            name: 'patient_name'
                        },
                        {
                            data: 'patient_age',
                            name: 'patient_age'
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
                            data: 'action',
                            name: 'action',
                            orderable: false,
                            searchable: false
                        }
                    ],
                    pageLength: 10, // Set default page size
                    lengthMenu: [10, 25, 50, 100], // Set available page sizes
                    drawCallback: function(settings) {
                        // You can adjust the pagination here if needed, for example:
                        var totalPages = settings.json.recordsTotal / settings._iDisplayLength;
                    }
                });

                // Filter Form Submission (on change)
                $('#filter-form').on('submit', function(e) {
                    e.preventDefault(); // Prevent default form submission
                    table.draw(); // Redraw DataTable with new filters
                });
            });
        </script>
    @endif --}}

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
