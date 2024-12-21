@extends('layouts.simple.master')
@section('title', 'Pasien')

@section('css')

@endsection

@section('style')
<style>
     .profile-picture {
        width: 100px;
        /* Adjust width as needed */
        height: 100px;
        /* Adjust height as needed */
        object-fit: cover;
        /* Ensure the image covers the area without distortion */
        border-radius: 50%;
        /* Make the image circular */
        border: 2px solid #ddd;
        /* Optional: Add a border around the image */
    }
</style>
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/datatables.css') }}">
@endsection

@section('breadcrumb-title')
    <h3>Pasien</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">{{ Auth::user()->name }}</li>
    <li class="breadcrumb-item active">Pasien</li>
@endsection

@section('content')
<div class="main-content content mt-6" id="main-content">
    <div class="row">
        <div class="col-12" style="min-height: 100vh; overflow-x: hidden;">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <h6>Profile</h6>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-4">
                        <!-- Profile Information -->
                        <div class="row">
                            <div class="col-md-4 text-center">
                                <img src="{{ asset('assets/assets/img/avatar.png') }}" alt="Profile Picture"
                                    class="profile-picture mb-3">
                                <h5>{{ $user->name }}</h5>
                                <p class="text-muted">{{ $user->email }}</p>
                            </div>
                            <div class="col-md-8">
                                <h5>Informasi Pengguna</h5>
                                <table class="table">
                                    <tbody>
                                        @if (!$user->role == 'admin')
                                            <tr>
                                                <th scope="row">NIP</th>
                                                <td>{{ $user->detail->nip }}</td>
                                            </tr>
                                        @endif
                                        <tr>
                                            <th scope="row">Nama Pengguna</th>
                                            <td>{{ $user->name }}</td>
                                        </tr>

                                        <tr>
                                            <th scope="row">Email</th>
                                            <td>{{ $user->email }}</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Phone</th>
                                            <td>{{ $user->no_hp }}</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Address</th>
                                            <td>{{ $user->address }}</td>
                                        </tr>
                                        <tr></tr>
                                    </tbody>
                                </table>
                                <button class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#editProfileModal">Edit Profile</button>
                                <button class="btn btn-warning" data-bs-toggle="modal"
                                    data-bs-target="#changePasswordModal">Ganti Password</button>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@include('component.modal-edit-profile')
@include('component.modal-change-password')


</div>
@endsection

@section('script')
<script>
    $(document).ready(function() {
        $('#example').DataTable({
            "pagingType": "full_numbers", // You can change this to suit your needs
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
@endsection

