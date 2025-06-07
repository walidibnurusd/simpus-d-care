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
@php
    // Helper function to determine the print option label
    function getPrintOptionLabel()
    {
        $routeName = Route::currentRouteName();
        if ($routeName == 'action.dokter.index') {
            return 'Poli Umum';
        } elseif ($routeName == 'action.dokter.gigi.index') {
            return 'Poli Gigi';
        } elseif ($routeName == 'action.dokter.ugd.index') {
            return 'UGD';
        } else {
            return 'Ruang Tindakan';
        }
    }

    // Helper function to determine the print option value
    function getPrintOptionValue()
    {
        $routeName = Route::currentRouteName();

        if ($routeName == 'action.dokter.index') {
            return 'poli-umum';
        } elseif ($routeName == 'action.dokter.gigi.index') {
            return 'poli-gigi';
        } elseif ($routeName == 'action.dokter.ugd.index') {
            return 'ruang-tindakan';
        } else {
            return 'tindakan';
        }
    }
@endphp

@section('content')
    <div class="main-content content mt-6" id="main-content">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Success!</strong> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div class="row mb-3">
            <div class="col-md-12 d-flex justify-content-start">
                <button type="button" class="btn btn-primary" id="sendToSatuSehatButton">
                    Kirim ke Satu Sehat
                </button>
            </div>
        </div>
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
                    <form action="{{ route('action.report') }}" method="GET" target="_blank" class="mt-3"
                        id="printForm">
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
                                <button type="button" class="btn btn-warning w-100" id="printButton">
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
                                        <th><input type="checkbox" id="checkAll"></th> <!-- Checkbox for each row -->
                                        <th>No</th>
                                        <th>TANGGAL</th>
                                        <th>NIK/NO.RM</th>
                                        <th>NAMA</th>
                                        <th>UMUR</th>
                                        <th>KARTU</th>
                                        <th>KELUHAN</th>
                                        <th>DIAGNOSA SEKUNDER</th>
                                        <th>DIAGNOSA PRIMER</th>
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
                                        <th>KONEKSI SATU SEHAT</th>
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
    <div class="modal fade" id="printModal" tabindex="-1" aria-labelledby="printModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="printModalLabel">Pilih</h5>
                </div>
                <div class="modal-body">
                    <p>Pilih:</p>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="poli_report" id="printAll" value="all"
                            checked>
                        <label class="form-check-label" for="printAll">Semua Poli</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="poli_report" id="printPoli"
                            value="{{ getPrintOptionValue() }}">
                        <label class="form-check-label" for="printPoli">{{ getPrintOptionLabel() }}</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="closeModalButton">Tutup</button>
                    <button type="button" class="btn btn-warning" id="confirmPrint">Print</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="sendModal" tabindex="-1" aria-labelledby="sendModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="sendModalLabel">Konfirmasi Kirim ke Satu Sehat</h5>
                </div>
                <div class="modal-body">
                    Apakah Anda yakin ingin mengirim data yang dipilih ke Satu Sehat?
                    <div id="loadingIndicator" style="display:none;">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <p>Memproses pengiriman...</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                        id="closeSendModalButton">Tutup</button>
                    <button type="button" class="btn btn-primary" id="confirmSend">Kirim</button>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('script')
    <script src="https://cdn.jsdelivr.net/npm/moment@2.29.1/moment.min.js"></script>

    <script>
        // Pastikan menggunakan JavaScript murni untuk modal Bootstrap 5
        var sendModal = new bootstrap.Modal(document.getElementById('sendModal'));
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('sendToSatuSehatButton').addEventListener('click', function() {
                var selectedActions = [];
                document.querySelectorAll('#actionTable tbody input.actionCheckbox:checked').forEach(
                    function(checkbox) {
                        selectedActions.push(checkbox.value); // Menyimpan ID baris yang dipilih
                    });

                if (selectedActions.length > 0) {
                    // Menampilkan modal kirim

                    sendModal.show();
                    document.getElementById('closeSendModalButton').addEventListener('click', function() {
                        sendModal.hide(); // Menyembunyikan modal setelah tombol diklik
                    });
                } else {
                    alert('Pilih setidaknya satu tindakan');
                }
            });


        });

        $(document).ready(function() {


            var printModal = new bootstrap.Modal(document.getElementById('printModal'));

            // Open modal when 'Print' button is clicked
            $('#printButton').on('click', function() {
                printModal.show(); // Show the modal explicitly
            });

            // Close modal when 'Tutup' button is clicked
            document.getElementById('closeModalButton').addEventListener('click', function() {
                printModal.hide(); // Hide the modal
            });


            $('#confirmPrint').on('click', function() {
                $('#printForm').find('input[name="poli_report"]').remove();
                const printOption = $('input[name="poli_report"]:checked').val();
                $('#printForm').append('<input type="hidden" name="poli_report" value="' + printOption +
                    '">');
                $('#printForm').submit();
                var myModal = new bootstrap.Modal(document.getElementById('printModal'));
                myModal.hide();
            });
            $('#checkAll').on('change', function() {
                var isChecked = $(this).prop('checked');
                $('.actionCheckbox').prop('checked', isChecked);
            });


            // Send selected actions to Satu Sehat
            $('#sendToSatuSehatButton').on('click', function() {
                const selectedActions = [];
                $('#actionTable tbody input.actionCheckbox:checked').each(function() {
                    selectedActions.push($(this).val());
                });


                if (selectedActions.length > 0) {
                    $('#sendModal').modal('show');
                } else {
                    Swal.fire('Peringatan', 'Pilih setidaknya satu tindakan.', 'warning');
                }
            });

            $('#confirmSend').on('click', function() {
                const selectedActions = [];
                $('#actionTable tbody input.actionCheckbox:checked').each(function() {
                    selectedActions.push($(this).val());
                });

                if (selectedActions.length > 0) {
                    $('#loadingIndicator').show();
                    $('#confirmSend').prop('disabled', true);
                    $('#closeSendModalButton').prop('disabled', true);
                    $.ajax({
                        url: "{{ route('sendToSatuSehat') }}",
                        method: 'POST',
                        data: {
                            actions: selectedActions,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            if (response.success) {
                                if (response.failed.length > 0) {
                                    $('#loadingIndicator').hide();

                                    // Aktifkan tombol Kirim dan Tutup Modal kembali
                                    $('#confirmSend').prop('disabled', false);
                                    $('#closeSendModalButton').prop('disabled', false);
                                    // Jika ada yang gagal dikirim, tampilkan detailnya
                                    let failedList = response.failed.map(f =>
                                        `ID ${f.action_id}: ${f.reason}`).join('<br>');
                                    Swal.fire({
                                        icon: 'warning',
                                        title: 'Sebagian Gagal Dikirim',
                                        html: `<strong>${response.sent.length} berhasil</strong><br><strong>${response.failed.length} gagal</strong><br><br>${failedList}`
                                    });
                                } else {
                                    // Semua sukses
                                    Swal.fire('Berhasil',
                                        `${response.sent.length} data berhasil dikirim ke Satu Sehat.`,
                                        'success');
                                }
                            } else {
                                // Jika respons success: false
                                Swal.fire('Gagal',
                                    'Server mengembalikan error saat memproses permintaan.',
                                    'error');
                            }
                            $('#sendModal').modal('hide');
                        },
                        error: function(xhr, status, error) {
                            $('#loadingIndicator').hide();

                            // Aktifkan tombol Kirim dan Tutup Modal kembali
                            $('#confirmSend').prop('disabled', false);
                            $('#closeSendModalButton').prop('disabled', false);
                            console.error(xhr.responseText);
                            Swal.fire('Gagal', 'Kesalahan server atau jaringan.', 'error');
                            $('#sendModal').modal('hide');
                        }
                    });
                }
            });

        });
    </script>
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
                            searchable: false,
                            render: function(data, type, row) {
                                return `<input type="checkbox" class="actionCheckbox" value="${row.id}">`; // Checkbox for each row
                            }
                        },

                        {
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
                            data: 'diagnosa_primer',
                            name: 'diagnosa_primer'
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


                                if (faskes == 1 || faskes == 'ya') {
                                    return 'Ya';
                                } else if (faskes == 0 || faskes == 'tidak') {
                                    return 'Luar Wilayah';
                                } else {
                                    return faskes;
                                }
                            }
                        },
                        {
                            data: 'status_satu_sehat',
                            name: 'status_satu_sehat'
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
                        searchable: false,
                        render: function(data, type, row) {
                            return `<input type="checkbox" class="actionCheckbox" value="${row.id}">`; // Checkbox for each row
                        }
                    },
                    {
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
                        data: 'diagnosa_primer',
                        name: 'diagnosa_primer'
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


                            if (faskes == 1 || faskes == 'ya') {
                                return 'Ya';
                            } else if (faskes == 0 || faskes == 'tidak') {
                                return 'Luar Wilayah';
                            } else {
                                return faskes;
                            }
                        }
                    },
                    {
                        data: 'status_satu_sehat',
                        name: 'status_satu_sehat'
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
                            searchable: false,
                            render: function(data, type, row) {
                                return `<input type="checkbox" class="actionCheckbox" value="${row.id}">`; // Checkbox for each row
                            }
                        },
                        {
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
                            data: 'diagnosa_primer',
                            name: 'diagnosa_primer'
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
                            data: 'status_satu_sehat',
                            name: 'status_satu_sehat'
                        },
                        {
                            data: 'faskes',
                            render: function(data, type, row) {

                                let faskes = data || row.patient.wilayah_faskes;


                                if (faskes == 1 || faskes == 'ya') {
                                    return 'Ya';
                                } else if (faskes == 0 || faskes == 'tidak') {
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
                            searchable: false,
                            render: function(data, type, row) {
                                return `<input type="checkbox" class="actionCheckbox" value="${row.id}">`; // Checkbox for each row
                            }
                        },
                        {
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
                            data: 'diagnosa_primer',
                            name: 'diagnosa_primer'
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


                                if (faskes == 1 || faskes == 'ya') {
                                    return 'Ya';
                                } else if (faskes == 0 || faskes == 'tidak') {
                                    return 'Luar Wilayah';
                                } else {
                                    return faskes;
                                }
                            },

                        },
                        {
                            data: 'status_satu_sehat',
                            name: 'status_satu_sehat'
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
