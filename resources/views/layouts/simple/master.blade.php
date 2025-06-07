<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description"
        content="Cuba admin is super flexible, powerful, clean &amp; modern responsive bootstrap 5 admin template with unlimited possibilities.">
    <meta name="keywords"
        content="admin template, Cuba admin template, dashboard template, flat admin template, responsive admin template, web app">
    <meta name="author" content="pixelstrap">

    <link rel="icon" href="{{ asset('assets/assets/img/logo-mks.png') }}" type="image/x-icon">
    <link rel="shortcut icon" href="{{ asset('assets/assets/img/logo-mks.png') }}" type="image/x-icon">

    <!-- CSS Libraries -->
    <link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css"
        rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/select2.css') }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.2.0/css/datepicker.min.css"
        rel="stylesheet">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Aplikasi Pelaporan Puskesmas</title>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Rubik:400,400i,500,500i,700,700i&amp;display=swap"
        rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,500,500i,700,700i,900&amp;display=swap"
        rel="stylesheet">

    <!-- Additional Styles -->
    @include('layouts.simple.css')
    @yield('style')

    <style>
        .select2-selection__choice__remove {
            text-align: right;
        }

        .badge {
            display: inline-block;
            padding: 0.25em 0.4em;
            font-size: 0.75rem;
            font-weight: 600;
            text-align: center;
            white-space: nowrap;
            vertical-align: baseline;
            border-radius: 0.25rem;
        }

        .navbar-brand-img {
            height: 50px;
            width: auto;
            object-fit: contain;
            margin-right: 10px;
        }

        .badge-underweight {
            background-color: #32cd32;
            /* Light Green */
            color: #ffffff;
        }

        .badge-normal {
            background-color: #228b22;
            /* Dark Green */
            color: #ffffff;
        }

        .badge-overweight {
            background-color: #ffd700;
            /* Yellow */
            color: #000000;
        }

        .badge-obesity1 {
            background-color: #ff8c00;
            /* Orange */
            color: #ffffff;
        }

        .badge-obesity2 {
            background-color: #ff4500;
            /* Orange-Red */
            color: #ffffff;
        }

        .badge-obesity3 {
            background-color: #8b0000;
            /* Dark Red */
            color: #ffffff;
        }

        input[type="text"],
        textarea,
        select {
            color: #000;
            /* Black */
            background-color: #fff;
            /* White */
            border: 1px solid #ccc;
            /* Gray Border */
        }

        input[type="text"]:focus,
        textarea:focus,
        select:focus {
            outline: none;
            border-color: #007bff;
            /* Blue Border */
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
            /* Focus Effect */
        }

        ::placeholder {
            color: #999;
            /* Placeholder Gray */
            opacity: 1;
            /* Non-transparent */
        }

        .form-control {
            color: #212529;
            /* Darker text */
            background-color: #f8f9fa;
            /* Light gray background */
            border: 1px solid #ced4da;
            /* Gray border */
        }

        .form-control:focus {
            color: #212529;
            background-color: #fff;
            border-color: #80bdff;
            outline: 0;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }

        .form-control {
            background-color: #ffffff !important;
            color: #212529 !important;
            border: 1px solid #ced4da !important;
        }
    </style>
</head>

<body
    @if (Route::current()->getName() == 'index') onload="startTime()" @elseif (Route::current()->getName() == 'button-builder') class="button-builder" @endif>
    <div class="loader-wrapper">
        <div class="loader-index"><span></span></div>
        <svg>
            <defs></defs>
            <filter id="goo">
                <feGaussianBlur in="SourceGraphic" stdDeviation="11" result="blur"></feGaussianBlur>
                <feColorMatrix in="blur" values="1 0 0 0 0  0 1 0 0 0  0 0 1 0 0  0 0 0 19 -9" result="goo">
                </feColorMatrix>
            </filter>
        </svg>
    </div>
    <!-- tap on top starts-->
    <div class="tap-top"><i data-feather="chevrons-up"></i></div>
    <!-- tap on tap ends-->
    <!-- page-wrapper Start-->
    <div class="page-wrapper compact-wrapper" id="pageWrapper">
        <!-- Page Header Start-->
        @include('layouts.simple.header')
        <!-- Page Header Ends  -->
        <!-- Page Body Start-->
        <div class="page-body-wrapper">
            <!-- Page Sidebar Start-->
            @include('layouts.simple.sidebar')
            <!-- Page Sidebar Ends-->
            <div class="page-body">
                <div class="container-fluid">
                    <div class="page-title">
                        <div class="row">
                            <div class="col-6">
                                @yield('breadcrumb-title')
                            </div>
                            <div class="col-6">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ route('/') }}">
                                            <svg class="stroke-icon">
                                                <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-home') }}"></use>
                                            </svg></a></li>
                                    @yield('breadcrumb-items')
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Container-fluid starts-->
                @yield('content')
                <!-- Container-fluid Ends-->
            </div>
            <!-- footer start-->
            @include('layouts.simple.footer')
        </div>
    </div>
    <!-- latest jquery-->
    @include('layouts.simple.script')
</body>

</html>
