@extends('layouts.simple.master')
@section('title', 'Kadar Lemak')

@section('css')

@endsection

@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/datatables.css') }}">
@endsection

@section('breadcrumb-title')
    <h3>Kadar Lemak</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">{{ Auth::user()->name }}</li>
    <li class="breadcrumb-item active">Pegawai</li>
@endsection

@section('content')

    <div class="container-fluid">
        <div class="row">
            <!-- Zero Configuration  Starts-->
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show d-flex align-items-center" role="alert">
                    <i class="mr-2 text-success"></i>
                    <strong>Success:</strong> {{ session('success') }}
                    <button type="button" class="close ml-auto" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif


            <!-- Validation Errors Alert -->
            @if ($errors->any())
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <strong>Warning:</strong> Please check the form for errors.
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header pb-0 card-no-border">
                      
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="display" id="basic-1">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>NIP</th>
                                        <th>Nama</th>
                                        <th>Kadar Lemak</th>
                                        <th>Jenis Kelamin</th>
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($employee as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item->nip }}</td>
                                            <td>{{ $item->nama }}</td>
                                            <td><a href="{{route('kl',$item->id)}}">Klik</a></td>
                                            <td>{{ $item->jenis_kelamin }}</td>
                                          
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
    <script src="{{ asset('assets/js/datatable/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/datatable/datatables/datatable.custom.js') }}"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // Fungsi untuk menghapus employee dengan SweetAlert2
        function deleteEmployee(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: 'This action cannot be undone!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Jika dikonfirmasi, kirim permintaan AJAX untuk menghapus data
                    $.ajax({
                        url: '/employee/' + id, // Ubah sesuai dengan rute delete Anda
                        type: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}',
                        },
                        success: function(response) {
                            // Tampilkan notifikasi sukses jika penghapusan berhasil
                            Swal.fire(
                                'Deleted!',
                                'The employee has been deleted.',
                                'success'
                            ).then(() => {
                                // Hapus baris data yang sudah dihapus dari tabel
                                $('#employee-' + id).remove();
                            });
                        },
                        error: function(xhr) {
                            // Jika terjadi error, tampilkan pesan error
                            Swal.fire(
                                'Error!',
                                'There was a problem deleting the employee.',
                                'error'
                            );
                        }
                    });
                }
            });
        }
    </script>
@endsection
