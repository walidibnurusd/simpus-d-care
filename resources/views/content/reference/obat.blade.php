@extends('layouts.simple.master')

@section('css')
@endsection

@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/datatables.css') }}">
@endsection

@section('breadcrumb-title')
    <h3>Referensi Obat</h3>
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
                <button type="button" class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#addObatModal">
                    Tambah
                    <i class="fas fa-plus ms-2"></i>
                </button>
            </div>

            <div class="card mb-4">
                <div class="card-header pb-0">
                    <h6>Daftar Data Referensi Obat</h6>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-4">
                        <table id="obat-table" class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        No
                                    </th>
                                    <th
                                        class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        NAMA</th>
                                    <th
                                        class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        KODE</th>
                                    <th
                                        class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        BENTUK</th>
                                    <th
                                        class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        JUMLAH</th>
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

@include('component.modal-edit-delete-reference-obat')
@include('component.modal-add-reference-obat')

@section('script')
    <script>
    let table;

    // Konfigurasi Datatable
    $(function () {
        table = $('#obat-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route('reference.obat.data') }}',
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'name', name: 'name' },
                { data: 'code', name: 'code' },
                { data: 'shape', name: 'shape' },
                { data: 'amount', name: 'amount' },

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

    // Buka modal edit data obat
    $(document).on('click', '.edit-obat', function () {
        const obatId = $(this).data('id');
        const name = $(this).data('name');
        const code = $(this).data('code');
        const shape = $(this).data('shape');
        const amount = $(this).data('amount');

        $('#edit-obat-id').val(obatId);
        $('#edit-obat-name').val(name);
        $('#edit-obat-code').val(code);
        $('#edit-obat-shape').val(shape);
        $('#edit-obat-amount').val(amount);


        $('#editObatModal').modal('show');
    });

    // Mengirim data edit ke controller melalui AJAX
    $('#editObatForm').on('submit', function (e) {
        e.preventDefault();
        const id = $('#edit-obat-id').val();
        $.ajax({
            url: `/reference/obat/${id}`,
            type: 'PUT',
            data: {
                _token: '{{ csrf_token() }}',
                name: $('#edit-obat-name').val(),
                code: $('#edit-obat-code').val(),
                shape: $('#edit-obat-shape').val(),
                amount: $('#edit-obat-amount').val(),
            },
            success: function () {
                $('#editObatModal').modal('hide');
                table.ajax.reload(null, false);
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: `Data obat berhasil diperbarui!`,
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

    // Membuka modal hapus data obat
    $(document).on('click', '.delete-obat', function () {
        $('#delete-obat-id').val($(this).data('id'));
        $('#deleteObatModal').modal('show');
    });

    // Menghapus data melalui controller dengan ajax
    $('#deleteObatForm').on('submit', function (e) {
        e.preventDefault();
        const id = $('#delete-obat-id').val();
        $.ajax({
            url: `/reference/obat/${id}`,
            type: 'DELETE',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function () {
                $('#deleteObatModal').modal('hide');
                table.ajax.reload(null, false);
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: `Data obat berhasil dihapus!`,
                    timer: 2000,
                    showConfirmButton: false
                });
            },
            error: function() {
                alert('Failed to delete obat.');
            }
        });
    });

    // Tambah Obat
    $('#createObatForm').on('submit', function (e) {
        e.preventDefault();

        $.ajax({
            url: '{{ route("reference.obat.store") }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                name: $('#add-obat-name').val(),
                code: $('#add-obat-code').val(),
                shape: $('#add-obat-shape').val(),
                amount: $('#add-obat-amount').val(),
            },
            success: function () {
                $('#addObatModal').modal('hide');

                $('#obat-table').DataTable().ajax.reload(null, false);

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