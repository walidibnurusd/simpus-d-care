@extends('layouts.simple.master')
@section('title', 'Kajian Awal')

@section('css')
@endsection

@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/datatables.css') }}">
@endsection

@section('breadcrumb-title')
    <h3>Referensi Dokter</h3>
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
                <button type="button" class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#addUserModal">
                    Tambah
                    <i class="fas fa-plus ms-2"></i>
                </button>
            </div>

            <div class="card mb-4">
                <div class="card-header pb-0">
                    <h6>Daftar Data Referensi Dokter</h6>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-4">
                        <table id="doctors-table" class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        No
                                    </th>
                                    <th
                                        class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        NIP</th>
                                    <th
                                        class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        NAMA</th>
                                    <th
                                        class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        EMAIL</th>
                                    <th
                                        class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        NO. TELP</th>
                                    <th
                                        class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        ALAMAT</th>
                                    <!-- <th
                                        class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        SUMBER</th> -->
                                    <th
                                        class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        TANGGAL DITAMBAH</th>
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

@include('component.modal-edit-delete-reference-doctor')
@include('component.modal-add-reference-doctor')

@section('script')
    <script>
    let table;
    let userName;

    // Konfigurasi Datatable
    $(function () {
        table = $('#doctors-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route('reference.doctor.data') }}',
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'nip', name: 'nip'},
                { data: 'name', name: 'name' },
                { data: 'email', name: 'email' },
                { data: 'no_hp', name: 'no_hp' },
                { data: 'address', name: 'address' },
                {
                    data: 'updated_at',
                    name: 'updated_at',
                    render: function (data) {
                        const date = new Date(data);
                        const day = String(date.getDate()).padStart(2, '0');
                        const month = String(date.getMonth() + 1).padStart(2, '0');
                        const year = date.getFullYear();
                        const hours = String(date.getHours()).padStart(2, '0');
                        const minutes = String(date.getMinutes()).padStart(2, '0');
                        const seconds = String(date.getSeconds()).padStart(2, '0');

                        return `${day}/${month}/${year} ${hours}:${minutes}:${seconds}`;
                    }
                },
                { data: 'actions', orderable: false, searchable: false }
            ]
        });
    });

    // Buka modal edit data dokter
    $(document).on('click', '.edit-user', function () {
        const userId = $(this).data('id');
        userName = $(this).data('name');
        const userEmail = $(this).data('email');
        const userNip = $(this).data('nip');
        const userNik = $(this).data('nik');
        const userAddress = $(this).data('address');
        const userPhoneNumber = $(this).data('phone_number')

        $('#edit-user-id').val(userId);
        $('#edit-user-name').val(userName);
        $('#edit-user-email').val(userEmail);
        $('#edit-user-nip').val(userNip);
        $('#edit-user-nik').val(userNik);
        $('#edit-user-address').val(userAddress);
        $('#edit-user-phone_number').val(userPhoneNumber);

        $('#editUserModal').modal('show');
    });

    // Mengirim data edit ke controller melalui AJAX
    $('#editUserForm').on('submit', function (e) {
        e.preventDefault();
        const id = $('#edit-user-id').val();
        $.ajax({
            url: `/reference/doctor/${id}`,
            type: 'PUT',
            data: {
                _token: '{{ csrf_token() }}',
                name: $('#edit-user-name').val(),
                email: $('#edit-user-email').val(),
                nip: $('#edit-user-nip').val(),
                address: $('#edit-user-address').val(),
                phone_number: $('#edit-user-phone_number').val(),
                password: $('#edit-user-password').val()
            },
            success: function () {
                $('#editUserModal').modal('hide');
                table.ajax.reload(null, false);
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: `Data ${userName} berhasil diperbarui!`,
                    timer: 2000,
                    showConfirmButton: false
                });
            },
            error: function (xhr) {
                if (xhr.status === 422) {
                    const errors = xhr.responseJSON.errors;
                    let errorMessage = '';

                    Object.values(errors).forEach(function (messages) {
                        messages.forEach(function (message) {
                            errorMessage += `• ${message}<br>`;
                        });
                    });

                    Swal.fire({
                        icon: 'error',
                        title: 'Validasi Gagal!',
                        html: errorMessage,
                        confirmButtonText: 'Oke'
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Terjadi Kesalahan!',
                        text: 'Silakan coba lagi.',
                        confirmButtonText: 'Oke'
                    });
                }
            }
        });
    });

    // Membuka modal hapus data dokter
    $(document).on('click', '.delete-user', function () {
        $('#delete-user-id').val($(this).data('id'));
        $('#deleteUserModal').modal('show');
    });

    // Menghapus data melalui controller dengan ajax
    $('#deleteUserForm').on('submit', function (e) {
        e.preventDefault();
        const id = $('#delete-user-id').val();
        $.ajax({
            url: `/reference/doctor/${id}`,
            type: 'DELETE',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function () {
                $('#deleteUserModal').modal('hide');
                table.ajax.reload(null, false);
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: `Data dokter berhasil dihapus!`,
                    timer: 2000,
                    showConfirmButton: false
                });
            },
            error: function() {
                alert('Failed to delete user.');
            }
        });
    });

    // Tambah Dokter
    $('#createDoctorForm').on('submit', function (e) {
        e.preventDefault();

        $.ajax({
            url: '{{ route("reference.doctor.store") }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                name: $('#add-user-name').val(),
                email: $('#add-user-email').val(),
                nip: $('#add-user-nip').val(),
                address: $('#add-user-address').val(),
                phone_number: $('#add-user-phone_number').val(),
                password: $('#add-user-password').val()
            },
            success: function () {
                $('#addUserModal').modal('hide');

                $('#doctors-table').DataTable().ajax.reload(null, false);

                Swal.fire({
                    icon: 'success',
                    title: 'Sukses!',
                    text: 'Data berhasil ditambahkan!',
                    timer: 2000,
                    showConfirmButton: false
                });
            },
            error: function (xhr) {
                if (xhr.status === 422) {
                    const errors = xhr.responseJSON.errors;
                    let errorMessage = '';

                    Object.values(errors).forEach(function (messages) {
                        messages.forEach(function (message) {
                            errorMessage += `• ${message}<br>`;
                        });
                    });

                    Swal.fire({
                        icon: 'error',
                        title: 'Validasi Gagal!',
                        html: errorMessage,
                        confirmButtonText: 'Oke'
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Terjadi Kesalahan!',
                        text: 'Silakan coba lagi.',
                        confirmButtonText: 'Oke'
                    });
                }
            }
        });
    });

</script>

@endsection

@endsection