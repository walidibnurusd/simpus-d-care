@extends('layouts.simple.master')
@section('title', 'Pengeluaran Obat Unit Lain')

@section('css')

@endsection

@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/datatables.css') }}">
@endsection

@section('breadcrumb-title')
    <h3>Pengeluaran Obat Unit Lain</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">{{ Auth::user()->name }}</li>
    <li class="breadcrumb-item active">Pengeluaran Obat Unit Lain</li>
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

                    <button type="button" class="btn btn-success" data-bs-toggle="modal"
                        data-bs-target="#pengeluaranObatModal">
                        Tambah
                        <i class="fas fa-plus ms-2"></i> <!-- Ikon Tambah -->
                    </button>

                </div>


                @include('component.modal-pengeluaran-obat')

                <div class="card mb-4">
                    <div class="card-header pb-0">
                        <h6>Daftar Pengeluaran Obat Unit Lain</h6>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-4">
                            <table id="terima-obat-table" class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            NO
                                        </th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            TANGGAL</th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            NAMA OBAT</th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            KODE</th>

                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            BENTUK OBAT</th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            JUMLAH</th>
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
    <script src="https://cdn.jsdelivr.net/npm/moment@2.29.1/moment.min.js"></script>
    {{-- @if ($routeName == 'action.apotik.index') --}}
    <script>
        $(document).ready(function() {
            // Initialize DataTable with pagination
            var table = $('#terima-obat-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route('table-terima-obat') }}',
                    // data: function(d) {
                    //     // Send filter data along with the request
                    //     d.start_date = $('#start_date').val();
                    //     d.end_date = $('#end_date').val();
                    //     d.poli = $('#poli').val();
                    // }
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'date',
                        name: 'date'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'code',
                        name: 'code'
                    },
                    {
                        data: 'shape',
                        name: 'shape'
                    },
                    {
                        data: 'mount',
                        name: 'mount'
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
