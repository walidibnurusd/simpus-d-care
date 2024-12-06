
@extends('layouts.simple.master')
@section('title', 'Tindakan')

@section('css')

@endsection

@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/datatables.css') }}">
@endsection

@section('breadcrumb-title')
    <h3>Tindakan</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">{{ Auth::user()->name }}</li>
    <li class="breadcrumb-item active">Tindakan</li>
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
                <a href="{{ route('action.report') }}" class="btn btn-warning" target="_blank">
                    Print
                    <i class="fas fa-print ms-2"></i> <!-- Ikon print dengan margin -->
                </a>
                

            </div>

            {{-- @include('component.modal-add-action') --}}
            <!-- Modal -->


            <div class="card mb-4">
                <div class="card-header pb-0">
                    <h6>Daftar Data Tindakan</h6>
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
                                        DIAGNOSA</th>
                                    <th
                                        class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        TINDAKAN</th>
                                    <th
                                        class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        RUJUK RS</th>

                                    <th
                                        class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        KUNJ</th>
                                    <th
                                        class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        FASKES</th>

                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        AKSI</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($actions as $index => $action)
                                    {{-- @include('component.modal-edit-action') --}}
                                    <tr>
                                        <td>
                                            <h6 class="mb-0 text-sm">{{ $index + 1 }}</h6> <!-- Row number -->
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">{{ $action->nik }}</p>
                                            <!-- NIK -->
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">{{ $action->nik }}</p>
                                            <!-- NIK -->
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">{{ $action->nik }}</p>
                                            <!-- NIK -->
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">{{ $action->name }}</p>
                                            <!-- Name -->
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">{{ $action->address }}</p>
                                            <!-- Address -->
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">{{ $action->place_birth }}</p>
                                            <p class="text-xs font-weight-bold mb-0">{{ $action->dob }}
                                                <span class="age-red">({{ $action->getAgeAttribute() }}-thn)</span>
                                            </p>
                                            <!-- Date of Birth -->
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">
                                                {{ $action->genderName->name }}</p>
                                            <!-- Gender -->
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">{{ $action->phone }}</p>
                                            <!-- Phone -->
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">
                                                {{ $action->marritalStatus->name }}</p>
                                            <!-- Marital Status -->
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">{{ $action->no_rm }}</p>
                                            <!-- No RM -->
                                        </td>

                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">{{ $action->created_at }}</p>
                                            <!-- Place of Birth -->
                                        </td>
                                        <td>
                                            <div class="action-buttons">
                                                <button type="button"
                                                    class="  mb-0 btn btn-primary btn-sm text-white font-weight-bold text-xs"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#editActionModal{{ $action->id }}">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button type="button"
                                                    class="btn btn-danger btn-sm text-white font-weight-bold d-flex align-items-center btn-delete"
                                                    data-form-action="{{ route('action.destroy', $action->id) }}">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
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
