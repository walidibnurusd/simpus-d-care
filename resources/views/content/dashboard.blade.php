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
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">AKSI
                                        </th>
                                    </tr>
                                </thead>


                            </table>

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
                                            NIK <input type="text" id="nik-filter-kunjungan"
                                                class="filter-input-kunjungan" placeholder="Cari NIK"></th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            No RM<input type="text" id="no-rm-filter-kunjungan"
                                                class="filter-input-kunjungan" placeholder="Cari NO RM"></th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            NAMA <input type="text" id="name-filter-kunjungan"
                                                class="filter-input-kunjungan" placeholder="Cari Nama"></th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            TEMPAT/TGL.LAHIR <input type="text" id="dob-filter-kunjungan"
                                                class="filter-input-kunjungan" placeholder="Cari TTL"></th>

                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            POLI BEROBAT <input type="text" id="poli-filter-kunjungan"
                                                class="filter-input-kunjungan" placeholder="Cari Poli"></th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            HAMIL <input type="text" id="hamil-filter-kunjungan"
                                                class="filter-input-kunjungan" placeholder="Cari Hamil"></th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            KLASTER <input type="text" id="klaster-filter-kunjungan"
                                                class="filter-input-kunjungan" placeholder="Cari KLaster"></th>

                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            TANGGAL KUNJUNGAN <input type="date" id="tanggal-filter-kunjungan"
                                                class="filter-input-kunjungan" placeholder="Cari Tanggal Kunjungan"></th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
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
                // $('#filterButton').on('click', function() {
                //     table.ajax.reload(); // Mengambil data dengan filter tanggal
                // });
                // $('.filter-input').on('keyup change', function() {
                //     table.ajax.reload(); // Reload the table with filter values
                // });
                var tableKunjungan = $('#kunjungan-table').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: '{{ route('kunjungan.index') }}',
                        data: function(d) {
                            // Send filter data along with the request
                            d.start_date = $('#start_date').val();
                            d.end_date = $('#end_date').val();
                            d.nik = $('#nik-filter-kunjungan').val();
                            d.name = $('#name-filter-kunjungan').val();
                            d.poli = $('#poli-filter-kunjungan').val();
                            d.dob = $('#dob-filter-kunjungan').val();
                            d.hamil = $('#hamil-filter-kunjungan').val();
                            d.klaster = $('#klaster-filter-kunjungan').val();
                            d.tanggal = $('#tanggal-filter-kunjungan').val();
                            d.no_rm = $('#no-rm-filter-kunjungan').val();
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
                            name: 'tanggal',
                            orderable: false,
                            searchable: false
                        },

                        {
                            data: 'action',
                            name: 'action',
                            orderable: false,
                            searchable: false
                        }
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
                    pageLength: 10, // Set default page size
                    lengthMenu: [10, 25, 50, 100], // Set available page sizes

                });
                // $('.filter-input-kunjungan').on('keyup change', function() {
                //     tableKunjungan.ajax.reload(); // Reload the table with filter values
                // });

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
