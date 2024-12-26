@extends('layouts.simple.master')
@section('title', 'Talamesia')

@section('css')
    
@endsection

@section('style')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/datatables.css') }}">
@endsection

@section('breadcrumb-title')
    <h3>Talamesia</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">Admin</li>
    <li class="breadcrumb-item active">Talamesia</li>
@endsection

@section('content')

    <div class="container-fluid">
        <div class="row">
            <!-- Zero Configuration  Starts-->
            @if(session('success'))
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
                                        <th>Nama</th>
                                        <th>Alamat</th>

                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($talasemia as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->nama }}</td>
                                        
                                        <td>{{ $item->alamat }}</td>
                                        
                                      
                                        <td>
                                            <ul class="action">
                                                <li class="edit"> <a href="{{ route('talasemia.edit', $item->id) }}"><i class="icon-pencil-alt"></i></a>
                                                </li>
                                                <li class="delete">
                                                    <a href="javascript:void(0)" onclick="confirmDelete({{ $item->id }})">
                                                        <i class="icon-trash"></i>
                                                    </a>
                                                    
                                                    <!-- Hidden form for deletion, which will be submitted when confirmed -->
                                                    <form action="{{ route('talasemia.delete', $item->id) }}" method="POST" id="delete-form-{{ $item->id }}" style="display:none;">
                                                        @csrf
                                                        @method('DELETE')
                                                    </form>
                                                </li>
                                                
                                            </ul>
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
    <script src="{{ asset('assets/js/datatable/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/datatable/datatables/datatable.custom.js') }}"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // Function to confirm deletion
    function confirmDelete(id) {
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
                // If confirmed, submit the hidden form
                document.getElementById('delete-form-' + id).submit();
            }
        });
    }
</script>
@endsection
