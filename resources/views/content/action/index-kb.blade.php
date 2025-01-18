@extends('layouts.simple.master')
@section('title', 'Tindakan KIA')

@section('css')

@endsection

@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/datatables.css') }}">
@endsection

@section('breadcrumb-title')
    @if ($routeName === 'action.kb.dokter.index')
        <h3>Tindakan Dokter</h3>
    @else
        <h3>Kajian Awal</h3>
    @endif
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">{{ Auth::user()->name }}</li>
    <li class="breadcrumb-item active">Tindakan KB</li>
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
                    @if (Auth::user()->role == 'dokter')
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


                @include('component.modal-add-action-kb')

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
                                            KARTU</th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            KELUHAN</th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            OBAT</th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            HASIL LAB</th>

                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            KUNJ</th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            FASKES</th>
                                        @if (Auth::user()->role == 'dokter')
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                AKSI
                                            </th>
                                        @endif
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
                                                    @switch($action->patient->jenis_kartu)
                                                        @case('pbi')
                                                            PBI (KIS)
                                                        @break

                                                        @case('askes')
                                                            AKSES
                                                        @break

                                                        @case('jkn_mandiri')
                                                            JKN Mandiri
                                                        @break

                                                        @case('umum')
                                                            Umum
                                                        @break

                                                        @case('jkd')
                                                            JKD
                                                        @break

                                                        @default
                                                            Tidak Diketahui
                                                    @endswitch
                                                </p>
                                            </td>
                                            <td>
                                                <p class="text-xs font-weight-bold mb-0">{{ $action->keluhan }}</p>
                                            </td>
                                            <td>
                                                <p class="text-xs font-weight-bold mb-0">{{ $action->obat }}</p>
                                            </td>
                                            <td>
                                                <p class="text-xs font-weight-bold mb-0">{{ $action->hasil_lab }}</p>
                                            </td>

                                            <td>
                                                <p class="text-xs font-weight-bold mb-0">
                                                    {{ ucwords($action->kunjungan) }}
                                                </p>
                                            </td>
                                            <td>
                                                <p class="text-xs font-weight-bold mb-0">{{ ucwords($action->faskes) }}
                                                </p>
                                            </td>
                                            @if (Auth::user()->role == 'dokter')
                                                <td>
                                                    <div class="action-buttons">
                                                        <!-- Tombol Edit -->
                                                        <button type="button"
                                                            class="btn btn-primary btn-sm text-white font-weight-bold"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#editActionModal{{ $action->id }}">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                        @include('component.modal-edit-action-kb')
                                                        <!-- Tombol Delete -->
                                                        <form action="{{ route('action.destroy', $action->id) }}"
                                                            method="POST" class="d-inline form-delete">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="button"
                                                                class="btn btn-danger btn-delete btn-sm text-white font-weight-bold">
                                                                <i class="fas fa-trash-alt"></i>
                                                            </button>
                                                        </form>

                                                    </div>
                                                </td>
                                            @endif
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

                    // Ambil URL dari data-action
                    var formAction = this.getAttribute('data-action');

                    Swal.fire({
                        title: 'Konfirmasi Penghapusan',
                        text: 'Apakah Anda yakin ingin menghapus tindakan ini?',
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
                            // Submit form menggunakan fetch atau form asli
                            var form = this.closest('form');
                            if (form) {
                                form.submit();
                            }
                        }
                    });
                });
            });
        });
    </script>
@endsection
