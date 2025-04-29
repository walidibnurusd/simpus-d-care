<<<<<<< HEAD
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

                        <div class="row mt-4 mb-4">
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
                            <h6>Daftar Data Pasien</h6>
                        </div>
                        <div class="card-body px-0 pt-0 pb-2">
                            <div class="table-responsive p-4">
                                <table id="patient" class="table align-items-center mb-0">
                                    <thead>
                                        <tr>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                No
                                            </th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                NIK
                                                <input type="text" id="nik-filter" class="filter-input"
                                                    placeholder="Cari NIK">
                                            </th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                NAMA
                                                <input type="text" id="name-filter" class="filter-input"
                                                    placeholder="Cari Nama">
                                            </th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                ALAMAT
                                                <input type="text" id="address-filter" class="filter-input"
                                                    placeholder="Cari Alamat">
                                            </th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                TEMPAT/TGL.LAHIR
                                                <input type="text" id="dob-filter" class="filter-input"
                                                    placeholder="Cari TTL">
                                            </th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                JK
                                                <input type="text" id="gender-filter" class="filter-input"
                                                    placeholder="Cari Jenis Kelamin">
                                            </th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                TELEPON
                                                <input type="text" id="phone-filter" class="filter-input"
                                                    placeholder="Cari Nomor Hp">
                                            </th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                NIKAH
                                                <input type="text" id="marrital-status-filter" class="filter-input"
                                                    placeholder="Cari Nikah">
                                            </th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                No RM
                                                <input type="text" id="no-rm-filter" class="filter-input"
                                                    placeholder="Cari No RM">
                                            </th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                No FAMILY FOLDER
                                                <input type="text" id="no-family-folder-filter" class="filter-input"
                                                    placeholder="Cari Family Folder">
                                            </th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                TANGGAL INPUT
                                                <input type="date" id="created-at-filter" class="filter-input"
                                                    placeholder="Cari Tanggal">
                                            </th>
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
                    searching: false,
                    ajax: {
                        url: "{{ route('patient.dashboard') }}",
                        type: 'GET',
                        data: function(d) {
                            // Debugging: Cek apakah start_date dan end_date dikirim
                            // console.log('Start Date:', $('#start_date').val());
                            // console.log('End Date:', $('#end_date').val());

                            // Menambahkan filter tanggal ke dalam data
                            d.start_date = $('#start_date').val();
                            d.end_date = $('#end_date').val();
                            d.nik = $('#nik-filter').val();
                            d.name = $('#name-filter').val();
                            d.address = $('#address-filter').val();
                            d.dob = $('#dob-filter').val();
                            d.gender = $('#gender-filter').val();
                            d.phone = $('#phone-filter').val();
                            d.marrital_status = $('#marrital-status-filter').val();
                            d.no_rm = $('#no-rm-filter').val();
                            d.no_family_folder = $('#no-family-folder-filter').val();
                            d.created_at = $('#created-at-filter').val();

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
                            name: 'nik',
                            orderable: false,
                            searchable: false
                        },
                        {
                            data: 'name',
                            name: 'name',
                            orderable: false,
                            searchable: false
                        },
                        {
                            data: 'address',
                            name: 'address',
                            orderable: false,
                            searchable: false
                        },
                        {
                            data: 'dob',
                            name: 'dob',
                            orderable: false,
                            searchable: false
                        },
                        {
                            data: 'gender',
                            name: 'gender',
                            orderable: false,
                            searchable: false
                        },
                        {
                            data: 'phone',
                            name: 'phone',
                            orderable: false,
                            searchable: false
                        },
                        {
                            data: 'marrital_status',
                            name: 'marrital_status',
                            orderable: false,
                            searchable: false
                        },
                        {
                            data: 'no_rm',
                            name: 'no_rm',
                            orderable: false,
                            searchable: false
                        },
                        {
                            data: 'no_family_folder',
                            name: 'no_family_folder',
                            orderable: false,
                            searchable: false
                        },
                        {
                            data: 'created_at',
                            name: 'created_at',
                            orderable: false,
                            searchable: false
                        },
                        {
                            data: 'action',
                            name: 'action',
                            orderable: false,
                            searchable: false
                        },
                    ],
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
                    lengthMenu: [10, 25, 50, 100],
                });

                // Event listener untuk tombol filter
                // $('#filterButton').on('click', function() {
                //     table.ajax.reload(); // Mengambil data dengan filter tanggal
                // });
                // $('.filter-input').on('keyup change', function() {
                //     table.ajax.reload(); // Reload the table with filter values
                // });
                $('#filterButton').on('click', function() {
                    table.ajax.reload(); // Mengambil data dengan filter tanggal
                });
                $('#created-at-filter').on('change', function() {
                    // When date filter changes, reload the table with the new data
                    table.draw();
                });
                $('#nik-filter, #name-filter, #address-filter, #dob-filter, #gender-filter, #phone-filter, #marrital-status-filter, #no-rm-filter, #no-family-folder-filter')
                    .on('input', function() {
                        table.draw();
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
    @endsection
=======
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

                        <div class="row mt-4 mb-4">
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
                            <h6>Daftar Data Pasien</h6>
                        </div>
                        <div class="card-body px-0 pt-0 pb-2">
                            <div class="table-responsive p-4">
                                <table id="patient" class="table align-items-center mb-0">
                                    <thead>
                                        <tr>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                No
                                            </th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                NIK
                                                <input type="text" id="nik-filter" class="filter-input"
                                                    placeholder="Cari NIK">
                                            </th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                NAMA
                                                <input type="text" id="name-filter" class="filter-input"
                                                    placeholder="Cari Nama">
                                            </th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                ALAMAT
                                                <input type="text" id="address-filter" class="filter-input"
                                                    placeholder="Cari Alamat">
                                            </th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                TEMPAT/TGL.LAHIR
                                                <input type="text" id="dob-filter" class="filter-input"
                                                    placeholder="Cari TTL">
                                            </th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                JK
                                                <input type="text" id="gender-filter" class="filter-input"
                                                    placeholder="Cari Jenis Kelamin">
                                            </th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                TELEPON
                                                <input type="text" id="phone-filter" class="filter-input"
                                                    placeholder="Cari Nomor Hp">
                                            </th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                NIKAH
                                                <input type="text" id="marrital-status-filter" class="filter-input"
                                                    placeholder="Cari Nikah">
                                            </th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                No RM
                                                <input type="text" id="no-rm-filter" class="filter-input"
                                                    placeholder="Cari No RM">
                                            </th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                No FAMILY FOLDER
                                                <input type="text" id="no-family-folder-filter" class="filter-input"
                                                    placeholder="Cari Family Folder">
                                            </th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                TANGGAL INPUT
                                                <input type="date" id="created-at-filter" class="filter-input"
                                                    placeholder="Cari Tanggal">
                                            </th>
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
                    searching: false,
                    ajax: {
                        url: "{{ route('patient.dashboard') }}",
                        type: 'GET',
                        data: function(d) {
                            // Debugging: Cek apakah start_date dan end_date dikirim
                            // console.log('Start Date:', $('#start_date').val());
                            // console.log('End Date:', $('#end_date').val());

                            // Menambahkan filter tanggal ke dalam data
                            d.start_date = $('#start_date').val();
                            d.end_date = $('#end_date').val();
                            d.nik = $('#nik-filter').val();
                            d.name = $('#name-filter').val();
                            d.address = $('#address-filter').val();
                            d.dob = $('#dob-filter').val();
                            d.gender = $('#gender-filter').val();
                            d.phone = $('#phone-filter').val();
                            d.marrital_status = $('#marrital-status-filter').val();
                            d.no_rm = $('#no-rm-filter').val();
                            d.no_family_folder = $('#no-family-folder-filter').val();
                            d.created_at = $('#created-at-filter').val();

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
                            name: 'nik',
                            orderable: false,
                            searchable: false
                        },
                        {
                            data: 'name',
                            name: 'name',
                            orderable: false,
                            searchable: false
                        },
                        {
                            data: 'address',
                            name: 'address',
                            orderable: false,
                            searchable: false
                        },
                        {
                            data: 'dob',
                            name: 'dob',
                            orderable: false,
                            searchable: false
                        },
                        {
                            data: 'gender',
                            name: 'gender',
                            orderable: false,
                            searchable: false
                        },
                        {
                            data: 'phone',
                            name: 'phone',
                            orderable: false,
                            searchable: false
                        },
                        {
                            data: 'marrital_status',
                            name: 'marrital_status',
                            orderable: false,
                            searchable: false
                        },
                        {
                            data: 'no_rm',
                            name: 'no_rm',
                            orderable: false,
                            searchable: false
                        },
                        {
                            data: 'no_family_folder',
                            name: 'no_family_folder',
                            orderable: false,
                            searchable: false
                        },
                        {
                            data: 'created_at',
                            name: 'created_at',
                            orderable: false,
                            searchable: false
                        },
                        {
                            data: 'action',
                            name: 'action',
                            orderable: false,
                            searchable: false
                        },
                    ],
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
                    lengthMenu: [10, 25, 50, 100],
                });

                // Event listener untuk tombol filter
                // $('#filterButton').on('click', function() {
                //     table.ajax.reload(); // Mengambil data dengan filter tanggal
                // });
                // $('.filter-input').on('keyup change', function() {
                //     table.ajax.reload(); // Reload the table with filter values
                // });
                $('#filterButton').on('click', function() {
                    table.ajax.reload(); // Mengambil data dengan filter tanggal
                });
                $('#created-at-filter').on('change', function() {
                    // When date filter changes, reload the table with the new data
                    table.draw();
                });
                $('#nik-filter, #name-filter, #address-filter, #dob-filter, #gender-filter, #phone-filter, #marrital-status-filter, #no-rm-filter, #no-family-folder-filter')
                    .on('input', function() {
                        table.draw();
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
    @endsection
>>>>>>> 9df8fede466960d27744a11e4cb830e2a9437611
