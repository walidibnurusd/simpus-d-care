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
        <li class="breadcrumb-item active">Kunjungan</li>
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
                                                Diagnosa <input type="text" id="diagnosa-filter-kunjungan"
                                                    class="filter-input-kunjungan" placeholder="Cari Diagnosa"></th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                ICD10 <input type="text" id="icd10-filter-kunjungan"
                                                    class="filter-input-kunjungan" placeholder="Cari ICD10"></th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                TANGGAL KUNJUNGAN <input type="date" id="tanggal-filter-kunjungan"
                                                    class="filter-input-kunjungan" placeholder="Cari Tanggal Kunjungan">
                                            </th>

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


        </div>


    @endsection

    @section('script')
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="https://cdn.jsdelivr.net/npm/moment@2.29.1/moment.min.js"></script>

        <script>
            $(document).ready(function() {
                var tableKunjungan = $('#kunjungan-table').DataTable({
                    processing: true,
                    serverSide: true,
                    searching: false,
                    ajax: {
                        url: '{{ route('kunjungan.dashboard') }}',
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
                            d.diagnosa = $('#diagnosa-filter-kunjungan').val();
                            d.icd10 = $('#icd10-filter-kunjungan').val();
                        }
                    },
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex'
                        },
                        {
                            data: 'patient_nik',
                            name: 'patient_nik',
                            orderable: false,
                            searchable: false
                        },
                        {
                            data: 'patient_no_rm',
                            name: 'patient_no_rm',
                            orderable: false,
                            searchable: false
                        },
                        {
                            data: 'patient_name',
                            name: 'patient_name',
                            orderable: false,
                            searchable: false
                        },
                        {
                            data: 'patient_age',
                            name: 'patient_age',
                            orderable: false,
                            searchable: false
                        },
                        {
                            data: 'poli',
                            name: 'poli',
                            orderable: false,
                            searchable: false
                        },
                        {
                            data: 'hamil',
                            name: 'hamil',
                            orderable: false,
                            searchable: false
                        },
                        {
                            data: 'patient_klaster',
                            name: 'patient_klaster',
                            orderable: false,
                            searchable: false
                        },
                        {
                            data: 'diagnosa',
                            name: 'diagnosa',
                            orderable: false,
                            searchable: false
                        },
                        {
                            data: 'icd10',
                            name: 'icd10',
                            orderable: false,
                            searchable: false
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
                    lengthMenu: [10, 25, 50, 100], // Set available page size

                });
                $('#filterButton').on('click', function() {
                    tableKunjungan.ajax.reload(); // Mengambil data dengan filter tanggal
                });
                $('#tanggal-filter-kunjungan').on('change', function() {
                    // When date filter changes, reload the table with the new data
                    tableKunjungan.draw();
                });
                $('#nik-filter-kunjungan, #name-filter-kunjungan, #poli-filter-kunjungan, #dob-filter-kunjungan, #hamil-filter-kunjungan, #klaster-filter-kunjungan, #no-rm-filter-kunjungan, #diagnosa-filter-kunjungan,#icd10-filter-kunjungan')
                    .on('input', function() {
                        tableKunjungan.draw();
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
    @endsection
