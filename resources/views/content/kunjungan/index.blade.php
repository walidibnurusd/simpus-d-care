@extends('layouts.simple.master')
@section('title', 'Kunjungan')

@section('css')

@endsection

@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/datatables.css') }}">
@endsection

@section('breadcrumb-title')
    <h3>Kunjungan</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">{{ Auth::user()->name }}</li>
    <li class="breadcrumb-item active">Kunjungan</li>
@endsection

@section('content')

    <div class="main-content content mt-6" id="main-content">
        <div class="row">
            <div class="col-12" style="min-height: 100vh; overflow-x: hidden;">
                {{-- <div class="button-container">
                    <button type="button" class="btn btn-success" data-bs-toggle="modal"
                        data-bs-target="#addKunjunganModal">
                        Tambah
                        <i class="fas fa-plus ms-2"></i> <!-- Icon with margin to the left -->
                    </button>
                </div> --}}
                <div class="button-container">

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
                            <button type="button" id="filterButton" class="btn btn-primary w-100">
                                Cari <i class="fas fa-search ms-2"></i> <!-- Ikon Cari -->
                            </button>
                        </div>
                    </div>


                </div>
                <div class="card mb-4">
                    <div class="card-header pb-0">
                        <h6>Daftar Data Kunjungan</h6>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-4">
                            <table id="kunjungan-table" class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            No
                                        </th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            NIK</th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            No RM</th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            NAMA</th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            TEMPAT/TGL.LAHIR</th>

                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            POLI BEROBAT</th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            HAMIL</th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            KLASTER</th>

                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            TANGGAL INPUT</th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            AKSI</th>

                                        {{-- <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            AKSI</th> --}}
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
    <script>
        $(document).ready(function() {
            // Initialize DataTable with pagination
            var table = $('#kunjungan-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route('kunjungan.index') }}',
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
                        data: 'patient_nik',
                        name: 'patient_nik'
                    },
                    {
                        data: 'patient_no_rm',
                        name: 'patient_no_rm'
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
                        data: 'poli',
                        name: 'poli'
                    },
                    {
                        data: 'hamil',
                        name: 'hamil'
                    },
                    {
                        data: 'patient_klaster',
                        name: 'patient_klaster'
                    },
                    {
                        data: 'tanggal',
                        name: 'tanggal'
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
        document.addEventListener('click', function(event) {
            // Check if the clicked element has the class 'btn-delete'
            if (event.target.closest('.btn-delete')) {
                event.preventDefault();

                const button = event.target.closest('.btn-delete');
                const buttonId = button.id;
                const kunjunganId = buttonId.split('-').pop();

                // Build the delete URL
                const deleteUrl = `{{ url('/kunjungan/') }}/${kunjunganId}`;

                // Show SweetAlert2 confirmation
                Swal.fire({
                    title: 'Konfirmasi Penghapusan',
                    text: 'Apakah Anda yakin ingin menghapus pasien ini?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Hapus',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Create a form element dynamically for deletion
                        const form = document.createElement('form');
                        form.method = 'POST';
                        form.action = deleteUrl;

                        // Add CSRF token
                        const csrfField = document.createElement('input');
                        csrfField.type = 'hidden';
                        csrfField.name = '_token';
                        csrfField.value = '{{ csrf_token() }}';
                        form.appendChild(csrfField);

                        // Add DELETE method
                        const methodField = document.createElement('input');
                        methodField.type = 'hidden';
                        methodField.name = '_method';
                        methodField.value = 'DELETE';
                        form.appendChild(methodField);

                        // Append and submit the form
                        document.body.appendChild(form);
                        form.submit();
                    }
                });
            }
        });
    </script>
@endsection
