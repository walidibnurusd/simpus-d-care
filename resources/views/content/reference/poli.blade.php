@extends('layouts.simple.master')
@section('title', 'Kajian Awal')

@section('css')
@endsection

@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/datatables.css') }}">
@endsection

@section('breadcrumb-title')
    <h3>Referensi Poli</h3>
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
                <button type="button" class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#addPoliModal">
                    Tambah
                    <i class="fas fa-plus ms-2"></i>
                </button>
            </div>

            <div class="card mb-4">
                <div class="card-header pb-0">
                    <h6>Daftar Data Referensi Poli</h6>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-4">
                        <table id="poli-table" class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        No
                                    </th>
                                    <th
                                        class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        NAMA</th>
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

@include('component.modal-edit-delete-reference-poli')
@include('component.modal-add-reference-poli')

@section('script')
    <script>
    let table;
    let name;

    // Konfigurasi Datatable
    $(function () {
        table = $('#poli-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route('reference.poli.data') }}',
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'name', name: 'name' },
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
    $(document).on('click', '.edit-poli', function () {
        const poliId = $(this).data('id');
        name = $(this).data('name');

        $('#edit-poli-id').val(poliId);
        $('#edit-poli-name').val(name);

        $('#editPoliModal').modal('show');
    });

    // Mengirim data edit ke controller melalui AJAX
    $('#editPoliForm').on('submit', function (e) {
        e.preventDefault();
        const id = $('#edit-poli-id').val();
        $.ajax({
            url: `/reference/poli/${id}`,
            type: 'PUT',
            data: {
                _token: '{{ csrf_token() }}',
                name: $('#edit-poli-name').val(),                
            },
            success: function () {
                $('#editPoliModal').modal('hide');
                table.ajax.reload(null, false);
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: `Data ${name} berhasil diperbarui!`,
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
    $(document).on('click', '.delete-poli', function () {
        $('#delete-poli-id').val($(this).data('id'));
        $('#deletePoliModal').modal('show');
    });

    // Menghapus data melalui controller dengan ajax
    $('#deletePoliForm').on('submit', function (e) {
        e.preventDefault();
        const id = $('#delete-poli-id').val();
        $.ajax({
            url: `/reference/poli/${id}`,
            type: 'DELETE',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function () {
                $('#deletePoliModal').modal('hide');
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
                alert('Failed to delete poli.');
            }
        });
    });

    // Tambah Dokter
    $('#createPoliForm').on('submit', function (e) {
        e.preventDefault();

        $.ajax({
            url: '{{ route("reference.poli.store") }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                name: $('#add-poli-name').val(),
            },
            success: function () {
                $('#addPoliModal').modal('hide');

                $('#poli-table').DataTable().ajax.reload(null, false);

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