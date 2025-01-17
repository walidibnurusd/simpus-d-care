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

                <div class="card mb-4">
                    <div class="card-header pb-0">
                        <h6>Daftar Data Kunjungan</h6>
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

                                        {{-- <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            AKSI</th> --}}
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($kunjungan as $index => $k)
                                        <tr>
                                            <td>
                                                <h6 class="mb-0 text-sm">{{ $index + 1 }}</h6> <!-- Row number -->
                                            </td>
                                            <td>
                                                <p class="text-xs  mb-0">{{ $k->patient->nik }}</p>
                                                <!-- NIK -->
                                            </td>
                                            <td>
                                                <p class="text-xs  mb-0">{{ $k->patient->no_rm }}</p>
                                                <!-- No RM -->
                                            </td>
                                            <td>
                                                <p class="text-xs  mb-0">{{ $k->patient->name }}</p>
                                                <!-- Name -->
                                            </td>
                                            <td>
                                                <p class="text-xs  mb-0">{{ $k->patient->place_birth }}</p>
                                                <p class="text-xs  mb-0">{{ $k->patient->dob }}
                                                    <span class="age-red">({{ $k->patient->getAgeAttribute() }}-thn)</span>
                                                </p>
                                                <!-- Date of Birth -->
                                            </td>

                                            <td>
                                                @if ($k->poli == 'poli-umum')
                                                    <p class="text-xs  mb-0">Poli Umum</p>
                                                @elseif($k->poli == 'poli-gigi')
                                                    <p class="text-xs  mb-0">Poli Gigi</p>
                                                @elseif($k->poli == 'poli-kia')
                                                    <p class="text-xs  mb-0">Poli KIA</p>
                                                @elseif($k->poli == 'poli-kb')
                                                    <p class="text-xs  mb-0">Poli KB</p>
                                                @else
                                                    <p class="text-xs  mb-0">UGD</p>
                                                @endif
                                                <!-- No RM -->
                                            </td>
                                            <td>
                                                @if ($k->hamil == '1')
                                                    <p class="text-xs  mb-0">Ya</p>
                                                @else
                                                    <p class="text-xs  mb-0">Tidak</p>
                                                @endif
                                                <!-- No RM -->
                                            </td>
                                            <td>
                                                @if ($k->patient->getAgeAttribute() < 18 || $k->hamil == '1')
                                                    <p class="text-xs mb-0">Klaster 2</p>
                                                @else
                                                    <p class="text-xs mb-0">Klaster 3</p>
                                                @endif
                                            </td>

                                            <td>
                                                <p class="text-xs mb-0">{{ $k->created_at->format('d-m-Y H:i:s') }}</p>

                                            </td>
                                            {{-- <td>
                                                <div class="action-buttons">
                                                    <button type="button"
                                                        class="mb-0 btn btn-primary btn-sm text-white font-weight-bold text-xs"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#editKunjunganModal{{ $k->id }}">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button type="button"
                                                        class="btn btn-danger btn-sm text-white font-weight-bold d-flex align-items-center btn-delete"
                                                        data-form-action="{{ route('patient.destroy', $k->id) }}">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                </div>

                                            </td> --}}

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
    <script>
        $(document).ready(function() {
            $('#patient').DataTable({

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
                "lengthMenu": [10, 25, 50, 100] // Set the number of rows per page
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
                        text: 'Apakah Anda yakin ingin menghapus pasien ini?',
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
