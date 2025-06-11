@extends('layouts.simple.master')
@section('title', 'Tindakan KB')

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
                    @if (Auth::user()->role == 'dokter')
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
                                            DIAGNOSA SEKUNDER</th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            DIAGNOSA PRIMER</th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            OBAT</th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            UPDATE APOTIK</th>
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
                        <label class="form-check-label" for="printAll">
                            Semua Poli
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="poli_report" id="printPoli" value="poli-kb">
                        <label class="form-check-label" for="printPoli">
                            Poli KB
                        </label>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                        id="closeModalButton">Tutup</button>
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
                                    $('#loadingIndicator').hide();
                                    $('#confirmSend').prop('disabled', false);
                                    $('#closeSendModalButton').prop('disabled', false);
                                    // Semua sukses
                                    Swal.fire('Berhasil',
                                        `${response.sent.length} data berhasil dikirim ke Satu Sehat.`,
                                        'success');
                                }
                            } else {
                                $('#loadingIndicator').hide();
                                $('#confirmSend').prop('disabled', false);
                                $('#closeSendModalButton').prop('disabled', false);
                                Swal.fire('Gagal',
                                    'Server mengembalikan error saat memproses permintaan.',
                                    'error');
                            }
                            $('#sendModal').modal('hide');
                            $('#confirmSend').prop('disabled', false);
                            $('#closeSendModalButton').prop('disabled', false);

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
    <script>
        $(document).ready(function() {
            var table = $('#actionTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('action.kb.dokter.index') }}", // Your AJAX route
                    data: function(d) {
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
                        data: 'kartu',
                        name: 'kartu'
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
                        data: 'obat',
                        name: 'obat'
                    },
                    {
                        data: 'update_obat',
                        name: 'update_obat'
                    },
                    {
                        data: 'hasil_lab',
                        name: 'hasil_lab'
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
                    @if (Auth::user()->role == 'dokter')
                        {
                            data: 'action',
                            name: 'action',
                            orderable: false,
                            searchable: false
                        }
                    @endif
                ]
            });
            $('#filterButton').on('click', function() {
                console.log('Filter button clicked');
                table.ajax.reload(); // Corrected reload function
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
