@extends('layouts.simple.master')
@section('title', 'Tindakan Laboratorium')

@section('css')

@endsection

@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/datatables.css') }}">
@endsection

@section('breadcrumb-title')
    <h3>Tindakan Laboratorium</h3>
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


                @include('component.modal-add-action-lab')

                <div class="card mb-4">
                    <div class="card-header pb-0">
                        <h6>Daftar Data Tindakan</h6>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-4">
                            <table id="actionTable" class="table align-items-center mb-0">
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
                                            PEMERIKSAAN PENUNJANG</th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            HASIL LAB</th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            POLI</th>

                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            AKSI
                                        </th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($actions as $index => $action)
                                        <tr>
                                            <td>
                                                <h6 class="mb-0 text-sm">{{ $index + 1 }}</h6> <!-- Nomor urut -->
                                            </td>
                                            <td>
                                                <p class="text-xs font-weight-bold mb-0">
                                                    {{ \Carbon\Carbon::parse($action->tanggal)->format('Y-m-d') }}</p>
                                            </td>

                                            <td>
                                                <p class="text-xs font-weight-bold mb-0">
                                                    {{ optional($action->patient)->nik }}/{{ optional($action->patient)->no_rm }}
                                                </p>
                                            </td>
                                            <td>
                                                <p class="text-xs font-weight-bold mb-0">
                                                    {{ optional($action->patient)->name }}</p>
                                            </td>
                                            <td>
                                                <p class="text-xs font-weight-bold mb-0">
                                                    {{ \Carbon\Carbon::parse($action->patient->dob)->age }} Tahun</p>
                                                <!-- Ganti dengan perhitungan umur jika perlu -->
                                            </td>

                                            <td>
                                                <p class="text-xs font-weight-bold mb-0">
                                                    {{ ucwords(
                                                        $action->pemeriksaan_penunjang ??
                                                            (isset($action->hasilLab) && $action->hasilLab && !empty($action->hasilLab->jenis_pemeriksaan)
                                                                ? implode(', ', json_decode($action->hasilLab->jenis_pemeriksaan, true))
                                                                : ''),
                                                    ) }}
                                                </p>
                                            </td>



                                            <td>
                                                <p class="text-xs font-weight-bold mb-0">
                                                    @if (!empty($action->hasil_lab))
                                                        {{ ucwords($action->hasil_lab) }}
                                                    @elseif (!empty($action->hasilLab))
                                                        @php
                                                            $jenis_pemeriksaan = [];
                                                            if (
                                                                isset($action->hasilLab) &&
                                                                !empty($action->hasilLab->jenis_pemeriksaan)
                                                            ) {
                                                                // Jika hasilLab dan jenis_pemeriksaan ada, parsing JSON atau gunakan data langsung
                                                                $jenis_pemeriksaan = is_array(
                                                                    $action->hasilLab->jenis_pemeriksaan,
                                                                )
                                                                    ? $action->hasilLab->jenis_pemeriksaan
                                                                    : json_decode(
                                                                        $action->hasilLab->jenis_pemeriksaan,
                                                                        true,
                                                                    );
                                                            }

                                                            $hasilLabValues = [];

                                                            // Pemeriksaan dasar
                                                            if (in_array('GDS', $jenis_pemeriksaan)) {
                                                                $hasilLabValues[] =
                                                                    'GDS: ' . ($action->hasilLab->gds ?? '-');
                                                            }
                                                            if (in_array('GDP', $jenis_pemeriksaan)) {
                                                                $hasilLabValues[] =
                                                                    'GDP: ' . ($action->hasilLab->gdp ?? '-');
                                                            }
                                                            if (in_array('GDP 2 Jam PP', $jenis_pemeriksaan)) {
                                                                $hasilLabValues[] =
                                                                    'GDP 2 Jam PP: ' .
                                                                    ($action->hasilLab->gdp_2_jam_pp ?? '-');
                                                            }
                                                            if (in_array('Cholesterol', $jenis_pemeriksaan)) {
                                                                $hasilLabValues[] =
                                                                    'Cholesterol: ' .
                                                                    ($action->hasilLab->cholesterol ?? '-');
                                                            }
                                                            if (in_array('Asam Urat', $jenis_pemeriksaan)) {
                                                                $hasilLabValues[] =
                                                                    'Asam Urat: ' .
                                                                    ($action->hasilLab->asam_urat ?? '-');
                                                            }

                                                            // Pemeriksaan darah lengkap
                                                            if (in_array('Leukosit', $jenis_pemeriksaan)) {
                                                                $hasilLabValues[] =
                                                                    'Leukosit: ' . ($action->hasilLab->leukosit ?? '-');
                                                            }
                                                            if (in_array('Eritrosit', $jenis_pemeriksaan)) {
                                                                $hasilLabValues[] =
                                                                    'Eritrosit: ' .
                                                                    ($action->hasilLab->eritrosit ?? '-');
                                                            }
                                                            if (in_array('Trombosit', $jenis_pemeriksaan)) {
                                                                $hasilLabValues[] =
                                                                    'Trombosit: ' .
                                                                    ($action->hasilLab->trombosit ?? '-');
                                                            }
                                                            if (in_array('Hemoglobin', $jenis_pemeriksaan)) {
                                                                $hasilLabValues[] =
                                                                    'Hemoglobin: ' .
                                                                    ($action->hasilLab->hemoglobin ?? '-');
                                                            }
                                                            if (in_array('Golongan Darah', $jenis_pemeriksaan)) {
                                                                $hasilLabValues[] =
                                                                    'Golongan Darah: ' .
                                                                    ($action->hasilLab->golongan_darah ?? '-');
                                                            }

                                                            // Pemeriksaan infeksi & penyakit menular
                                                            if (in_array('Widal', $jenis_pemeriksaan)) {
                                                                $hasilLabValues[] =
                                                                    'Widal: ' . ($action->hasilLab->widal ?? '-');
                                                            }
                                                            if (in_array('Malaria', $jenis_pemeriksaan)) {
                                                                $hasilLabValues[] =
                                                                    'Malaria: ' . ($action->hasilLab->malaria ?? '-');
                                                            }
                                                            if (in_array('BTA', $jenis_pemeriksaan)) {
                                                                $hasilLabValues[] =
                                                                    'BTA: ' . ($action->hasilLab->bta ?? '-');
                                                            }
                                                            if (in_array('IgM DBD', $jenis_pemeriksaan)) {
                                                                $hasilLabValues[] =
                                                                    'IgM DBD: ' . ($action->hasilLab->igm_dbd ?? '-');
                                                            }
                                                            if (in_array('IgM Typhoid', $jenis_pemeriksaan)) {
                                                                $hasilLabValues[] =
                                                                    'IgM Typhoid: ' .
                                                                    ($action->hasilLab->igm_typhoid ?? '-');
                                                            }
                                                            if (in_array('Sifilis', $jenis_pemeriksaan)) {
                                                                $hasilLabValues[] =
                                                                    'Sifilis: ' . ($action->hasilLab->sifilis ?? '-');
                                                            }
                                                            if (in_array('HIV', $jenis_pemeriksaan)) {
                                                                $hasilLabValues[] =
                                                                    'HIV: ' . ($action->hasilLab->hiv ?? '-');
                                                            }

                                                            // Pemeriksaan urin
                                                            if (in_array('Albumin', $jenis_pemeriksaan)) {
                                                                $hasilLabValues[] =
                                                                    'Albumin: ' . ($action->hasilLab->albumin ?? '-');
                                                            }
                                                            if (in_array('Reduksi', $jenis_pemeriksaan)) {
                                                                $hasilLabValues[] =
                                                                    'Reduksi: ' . ($action->hasilLab->reduksi ?? '-');
                                                            }
                                                            if (in_array('Urinalisa', $jenis_pemeriksaan)) {
                                                                $hasilLabValues[] =
                                                                    'Urinalisa: ' .
                                                                    ($action->hasilLab->urinalisa ?? '-');
                                                            }
                                                            if (in_array('Tes Kehamilan', $jenis_pemeriksaan)) {
                                                                $hasilLabValues[] =
                                                                    'Tes Kehamilan: ' .
                                                                    ($action->hasilLab->tes_kehamilan ?? '-');
                                                            }

                                                            // Pemeriksaan feses
                                                            if (in_array('Telur Cacing', $jenis_pemeriksaan)) {
                                                                $hasilLabValues[] =
                                                                    'Telur Cacing: ' .
                                                                    ($action->hasilLab->telur_cacing ?? '-');
                                                            }
                                                        @endphp
                                                        {{ implode(', ', $hasilLabValues) }}
                                                    @else
                                                        -
                                                    @endif
                                                </p>
                                            </td>

                                            <td>
                                                <p class="text-xs font-weight-bold mb-0">
                                                    @if ($action->tipe == 'poli-umum')
                                                        Poli Umum
                                                    @elseif ($action->tipe == 'poli-gigi')
                                                        Poli Gigi
                                                    @elseif ($action->tipe == 'poli-kia')
                                                        Poli KIA
                                                    @elseif ($action->tipe == 'poli-kb')
                                                        Poli KB
                                                    @else
                                                        UGD
                                                    @endif
                                                </p>
                                            </td>

                                            <td>
                                                <div class="action-buttons">
                                                    <!-- Tombol Edit -->
                                                    <button type="button"
                                                        class="btn btn-primary btn-sm text-white font-weight-bold"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#editActionModalLab{{ $action->id }}">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    @include('component.modal-edit-action-lab')
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

@endsection

@section('script')
    <script src="https://cdn.jsdelivr.net/npm/moment@2.29.1/moment.min.js"></script>

    <script>
        $(document).ready(function() {
            var table = $('#actionTable').DataTable({
                "language": {
                    "info": "_PAGE_ dari _PAGES_ halaman",
                    "paginate": {
                        "previous": "<",
                        "next": ">",
                        "first": "<<",
                        "last": ">>"
                    }
                },
                "responsive": true,
                "lengthMenu": [10, 25, 50, 100], // Set the number of rows per page
                "initComplete": function() {
                    // Custom search function for date range
                    $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
                        var startDate = $('#start_date').val();
                        var endDate = $('#end_date').val();
                        var actionDate = data[
                            1]; // Assumes the 'Tanggal' column is the second column (index 1)

                        // If startDate and endDate are provided, compare with the actionDate
                        if (startDate && endDate) {
                            // Format both dates as YYYY-MM-DD for comparison
                            var actionDateFormatted = moment(actionDate, 'YYYY-MM-DD').format(
                                'YYYY-MM-DD');

                            return actionDateFormatted >= startDate && actionDateFormatted <=
                                endDate;
                        }

                        return true;
                    });
                }
            });

            // Event listener for the filter button
            $('#filterButton').on('click', function() {
                table.draw();
            });

            // // Clear filters if either date is changed
            // $('#start_date, #end_date').on('change', function() {
            //     table.draw();
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
