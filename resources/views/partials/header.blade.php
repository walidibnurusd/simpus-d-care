<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('assets/assets/img/apple-icon.png') }}">
    <link rel="icon" type="image/png" href="{{ asset('assets/assets/image/favicon.png') }}">
    <title>Aplikasi Pelaporan Puskesmas</title>

    <!-- Fonts and icons -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- Nucleo Icons -->
    <link href="{{ asset('assets/assets/css/nucleo-icons.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/assets/css/style.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/assets/css/nucleo-svg.css') }}" rel="stylesheet" />

    <!-- Bootstrap and Argon CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link id="pagestyle" href="{{ asset('assets/assets/css/argon-dashboard.css?v=2.0.4') }}" rel="stylesheet" />

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css">

    <!-- Select2 CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />

    <!-- jQuery UI CSS -->
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <!-- Include jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- jQuery UI JS -->
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

    <!-- Include DataTables JS -->
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

    <!-- Include Select2 JS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.full.min.js"></script>

    <!-- Moment.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>

    <!-- Bootstrap-Datetimepicker -->
    <script
        src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js">
    </script>

    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>

</head>
<style>
  .collapse {
    z-index: 10;
}


    .custom-select,
    .custom-button {
        height: 38px;
        /* Sesuaikan dengan tinggi tombol */
        padding: 6px 12px;
        /* Sesuaikan padding agar proporsional */
        font-size: 14px;
        /* Sesuaikan ukuran font */
        border-radius: 5px;
        /* Pastikan border-radius sesuai dengan tombol */
    }

    .custom-select {
        width: auto;
    }

    .card-header {
        border-bottom: 1px solid #dee2e6;
        /* Light gray border color */
        padding-bottom: 0.75rem;
        /* Padding below the header text */
    }

    .button-container {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        /* Add space between buttons */
    }

    body {
        padding-top: 60px;
        /* Adjust according to the height of the navbar */
    }

    .main-content {
        margin-left: 270px !important;
        /* Expanded sidebar width */
        transition: margin-left 0.3s ease;
    }

    .main-content.sidenav-collapsed {
        margin-left: 0px !important;
        /* Collapsed sidebar width */
    }



    .captcha-canvas {
        border: 1px solid #ccc;
        /* Border abu-abu */
        background-color: #f7f7f7;
        /* Latar belakang abu-abu */
        border-radius: 8px;
        /* Sudut membulat */
    }


    .sidenav {
        transition: width 0.3s ease;
        width: 250px;
        /* Expanded width */
        overflow: hidden;
        position: fixed;
        top: 0;
        bottom: 0;
        left: 0;
        background: #fff;
        border-right: 1px solid #ddd;
    }

    .sidenav.collapsed {
        width: 0px;
        /* Collapsed width */
    }

    .sidenav .navbar-brand img {
        width: 50px;
        /* Expanded logo size */
        transition: width 0.3s ease;
    }

    .sidenav.collapsed .navbar-brand img {
        width: 24px;
        /* Collapsed logo size */
    }

    .sidenav .navbar-brand span {
        transition: opacity 0.3s ease;
    }

    .sidenav.collapsed .navbar-brand span {
        opacity: 0;
        visibility: hidden;
    }

    .sidenav .nav-link {
        display: flex;
        align-items: center;
        padding: 1rem;
        white-space: nowrap;
        transition: opacity 0.3s ease;
    }

    .sidenav.collapsed .nav-link .nav-link-text {
        opacity: 0;
        visibility: hidden;
    }

    .sidenav .icon {
        width: 24px;
        text-align: center;
    }

    .collapse-btn {
        transition: transform 0.3s ease;
    }

    .sidenav.collapsed .collapse-btn {
        transform: rotate(180deg);
        /* Rotate icon when collapsed */
    }

    .sidenav {
        z-index: 9995 !important;
    }

    .sidenav.collapsed .navbar-logo-img {
        height: 50px !important;
        /* Smaller logo for collapsed sidebar */
        width: auto;
    }

    @media only screen and (max-width: 768px) {


        .main-content {
            margin-left: 0 !important;
            /* Hilangkan margin untuk layar kecil */
        }

        /* Jika navbar atau sidebar bertabrakan, tambahkan z-index yang lebih tinggi pada salah satu */
        .navbar,
        .sidenav {
            z-index: 1050;
            /* Menyesuaikan z-index untuk menempatkan elemen di depan/belakang */
        }

    }

    .modal {
        z-index: 9999 !important;
        /* Very high z-index */
    }

    .modal-backdrop {
        z-index: 9998;
        /* Slightly lower than the modal */
    }

    .alert {
        z-index: 9997 !important;
    }

    .dataTable {
        border-radius: 15px;
    }

    .dataTable tr:last-child td {
        border-bottom: none;
        /* Hilangkan garis bawah pada baris terakhir */
    }

    /* Membulatkan sudut atas header */
    .dataTable thead tr:first-child th:first-child {
        border-top-left-radius: 5px;
    }

    .dataTable thead tr:first-child th:last-child {
        border-top-right-radius: 5px;
    }

    /* Membulatkan sudut bawah footer */
    .dataTable tbody tr:last-child td:first-child {
        border-bottom-left-radius: 5px;
    }

    .dataTable tbody tr:last-child td:last-child {
        border-bottom-right-radius: 5px;
    }


    /* Gaya untuk pagination */
    .dataTables_wrapper .dataTables_paginate .paginate_button {

        padding: 0.1em 0.2em;
        height: 24px;
        width: 24px;
        font-size: 12px !important;
        margin: 0.1em;
        border-radius: 4px;
        border: 1px solid #ddd;
        background-color: #DEE8F4 !important;
        color: #3531A2 !important;
        text-decoration: none;
        cursor: pointer;
        transition: background-color 0.3s, color 0.3s;
        font-weight: 500 !important;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button.current {
        background-color: #00DEE6 !important;
        color: #1a1a1a !important;
        font-weight: 500 !important;
    }


    .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
        background-color: #00DEE6 !important;
        color: #1a1a1a !important;
        background: none !important;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button:active {
        background: none;
        color: black !important;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button.current,
    .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover {

        background: #00DEE6 !important;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button:focus {
        outline: none;
        background-color: #00DEE6;
        color: #1a1a1a !important;
    }


    .dataTables_wrapper .dataTables_paginate .paginate_button.previous,
    .dataTables_wrapper .dataTables_paginate .paginate_button.next {
        font-weight: bold;
        background-color: transparent;
        border: none;
        color: #3531A2 !important;
        transition: color 0.3s;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button.previous:hover,
    .dataTables_wrapper .dataTables_paginate .paginate_button.next:hover {
        color: #005f8f;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button.disabled {
        color: #3531A2 !important;
    }

    .dataTables_info {
        font-size: 12px !important;
    }

    .action-buttons {
        display: flex;
        justify-content: center;
        gap: 1px;
        /* Jarak kecil antara tombol */
    }

    .action-buttons a,
    .action-buttons button {
        width: 24px !important;
        height: 24px !important;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 12px !important;
        /* Ukuran font lebih kecil */
        border-radius: 4px;

        color: white !important;
        transition: background-color 0.3s;
        padding: 2px !important;
        /* Padding lebih kecil di dalam tombol */
    }
</style>

<body class="">
    <div class="container position-sticky z-index-sticky top-0">
        <div class="row">

            <div class="col-8 ms-auto">
                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert"
                        style="position: absolute">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="close" data-bs-dismiss="alert" aria-label="Close"
                            style="color: white; background: none; border: none; font-size: 1.5rem;">
                            &times;
                        </button>
                    </div>
                @endif


            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js">
        < script src = "https://code.jquery.com/jquery-3.5.1.min.js" >
    </script>
