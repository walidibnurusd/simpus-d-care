@extends('layouts.simple.master')

@section('css')
@endsection

@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/datatables.css') }}">
@endsection

@section('breadcrumb-title')
    <h3>Referensi Diagnosis</h3>
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
                <button type="button" class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#addDiagnosisModal">
                    Tambah
                    <i class="fas fa-plus ms-2"></i>
                </button>
            </div>

            <div class="card mb-4">
                <div class="card-header pb-0">
                    <h6>Daftar Data Referensi Diagnosis</h6>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-4">
                        <table id="diagnosis-table" class="table align-items-center mb-0">
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
                                        ICD 10</th>
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

@include('component.modal-edit-delete-reference-diagnosis')
@include('component.modal-add-reference-diagnosis')

@section('script')
    <script>
    let table;
    let name;

    // Konfigurasi Datatable
    $(function () {
        table = $('#diagnosis-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route('reference.diagnosis.data') }}',
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'name', name: 'name' },
                { data: 'icd10', name: 'icd10' },
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

    // Buka modal edit data diagnosis
    $(document).on('click', '.edit-diagnosis', function () {
        const diagnosisId = $(this).data('id');
        name = $(this).data('name');
        const icd10 = $(this).data('icd10');

        $('#edit-diagnosis-id').val(diagnosisId);
        $('#edit-diagnosis-name').val(name);
        $('#edit-diagnosis-icd10').val(icd10);

        $('#editDiagnosisModal').modal('show');
    });

    // Mengirim data edit ke controller melalui AJAX
    $('#editDiagnosisForm').on('submit', function (e) {
        e.preventDefault();
        const id = $('#edit-diagnosis-id').val();
        $.ajax({
            url: `/reference/diagnosis/${id}`,
            type: 'PUT',
            data: {
                _token: '{{ csrf_token() }}',
                name: $('#edit-diagnosis-name').val(),
                icd10: $('#edit-diagnosis-icd10').val(),                        
            },
            success: function () {
                $('#editDiagnosisModal').modal('hide');
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

    // Membuka modal hapus data diagnosis
    $(document).on('click', '.delete-diagnosis', function () {
        $('#delete-diagnosis-id').val($(this).data('id'));
        $('#deleteDiagnosisModal').modal('show');
    });

    // Menghapus data melalui controller dengan ajax
    $('#deleteDiagnosisForm').on('submit', function (e) {
        e.preventDefault();
        const id = $('#delete-diagnosis-id').val();
        $.ajax({
            url: `/reference/diagnosis/${id}`,
            type: 'DELETE',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function () {
                $('#deleteDiagnosisModal').modal('hide');
                table.ajax.reload(null, false);
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: `Data diagnosis berhasil dihapus!`,
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
    $('#createDiagnosisForm').on('submit', function (e) {
        e.preventDefault();

        $.ajax({
            url: '{{ route("reference.diagnosis.store") }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                name: $('#add-diagnosis-name').val(),
                icd10: $('#add-diagnosis-icd10').val(),
            },
            success: function () {
                $('#addDiagnosisModal').modal('hide');

                $('#diagnosis-table').DataTable().ajax.reload(null, false);

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