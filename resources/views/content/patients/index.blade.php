@extends('layouts.simple.master')
@section('title', 'Pasien')

@section('css')

@endsection

@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/datatables.css') }}">
@endsection

@section('breadcrumb-title')
    <h3>Pasien</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">{{ Auth::user()->name }}</li>
    <li class="breadcrumb-item active">Pasien</li>
@endsection

@section('content')

    <div class="main-content content mt-6" id="main-content">
        <div class="row">
            <div class="col-12" style="min-height: 100vh; overflow-x: hidden;">
                <div class="button-container">
                    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addPatientModal">
                        Tambah
                        <i class="fas fa-plus ms-2"></i> <!-- Icon with margin to the left -->
                    </button>
                    <a href="{{ route('patient.report') }}" class="btn btn-warning" target="_blank">
                        Print
                        <i class="fas fa-print ms-2"></i> <!-- Ikon print dengan margin -->
                    </a>
                    <!-- Tombol Import -->
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#importModal">
                        Import
                        <i class="fas fa-file-import ms-2"></i> <!-- Ikon dengan margin -->
                    </button>

                </div>
                <div class="button-container">

                    <div class="row mt-4">
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

                @include('component.modal-add-patient')
                <!-- Modal -->


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
                                            JK</th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            TELEPON</th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            NIKAH</th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            No RM</th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            No FAMILY FOLDER</th>

                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            TANGGAL INPUT</th>

                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            AKSI</th>
                                    </tr>
                                </thead>

                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>
    <div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="importModalLabel">Import Data Pasien</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('patient.import') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <label for="fileImport" class="form-label">Pilih File</label>
                        <input type="file" id="fileImport" name="file" class="form-control" accept=".csv, .xls, .xlsx"
                            required>
                        <small class="text-muted">Format file yang didukung: .csv, .xls, .xlsx</small>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Import</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@section('script')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/moment@2.29.1/moment.min.js"></script>

    <script>
        $(document).ready(function() {
            const table = $('#patient').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('patient.data') }}",
                    type: 'GET',
                    data: function(d) {
                        // Debugging: Cek apakah start_date dan end_date dikirim
                        console.log('Start Date:', $('#start_date').val());
                        console.log('End Date:', $('#end_date').val());

                        // Menambahkan filter tanggal ke dalam data
                        d.start_date = $('#start_date').val();
                        d.end_date = $('#end_date').val();
                    }
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        searchable: false,
                        orderable: false
                    },
                    {
                        data: 'nik',
                        name: 'nik'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'address',
                        name: 'address'
                    },
                    {
                        data: 'dob',
                        name: 'dob'
                    },
                    {
                        data: 'gender',
                        name: 'gender'
                    },
                    {
                        data: 'phone',
                        name: 'phone'
                    },
                    {
                        data: 'marrital_status',
                        name: 'marrital_status'
                    },
                    {
                        data: 'no_rm',
                        name: 'no_rm'
                    },
                    {
                        data: 'no_family_folder',
                        name: 'no_family_folder'
                    },
                    {
                        data: 'created_at',
                        name: 'created_at'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ],
                language: {
                    search: "Cari:",
                    info: "_PAGE_ dari _PAGES_ halaman",
                    paginate: {
                        previous: "<",
                        next: ">",
                        first: "<<",
                        last: ">>"
                    }
                },
                responsive: true,
                lengthMenu: [10, 25, 50, 100],
            });

            // Event listener untuk tombol filter
            $('#filterButton').on('click', function() {
                table.ajax.reload(); // Mengambil data dengan filter tanggal
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
        document.addEventListener('DOMContentLoaded', function() {
            // Attach event listener to each delete button
            document.querySelectorAll('.btn-delete').forEach(function(button) {
                button.addEventListener('click', function(event) {
                    event.preventDefault(); // Prevent default button action

                    // Get patient ID from the button's ID
                    var buttonId = this.id; // 'delete-button-{id}'
                    var patientId = buttonId.split('-')
                        .pop(); // Extract the patient ID from the button's id

                    // Build the delete URL dynamically
                    var formAction = '{{ route('patient.destroy', '') }}' + '/' + patientId;

                    // Show SweetAlert2 confirmation popup
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
                            // Create a form for DELETE request
                            var form = document.createElement('form');
                            form.method = 'POST';
                            form.action = formAction;

                            // Add CSRF token to the form
                            var csrfToken = document.createElement('input');
                            csrfToken.type = 'hidden';
                            csrfToken.name = '_token';
                            csrfToken.value = "{{ csrf_token() }}";
                            form.appendChild(csrfToken);

                            // Add DELETE method (Laravel uses _method to simulate DELETE)
                            var methodField = document.createElement('input');
                            methodField.type = 'hidden';
                            methodField.name = '_method';
                            methodField.value = 'DELETE';
                            form.appendChild(methodField);

                            // Append form to the body and submit
                            document.body.appendChild(form);
                            form.submit(); // Trigger form submission to delete the patient
                        }
                    });
                });
            });
        });
    </script>

    <script>
        document.addEventListener('click', function(event) {
            // Check if the clicked element has the class 'btn-delete'
            if (event.target.closest('.btn-delete')) {
                event.preventDefault();

                const button = event.target.closest('.btn-delete');
                const buttonId = button.id;
                const patientId = buttonId.split('-').pop();

                // Build the delete URL
                const deleteUrl = `{{ url('/patients/') }}/${patientId}`;

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
