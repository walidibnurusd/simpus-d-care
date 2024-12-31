@extends('layouts.simple.master')
@section('title', 'Laporan')

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
    <h3>Laporan</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">{{ Auth::user()->name }}</li>
    <li class="breadcrumb-item active">Laporan</li>
@endsection

@section('content')

    <div class="container my-4">
        @if (Auth::user()->role == 'admin-poli-umum')
            <h4 class="mb-3">Laporan Poli Umum</h4>
        @else
            <h4 class="mb-3">Laporan Poli Gigi</h4>
        @endif
        @if (Auth::user()->role == 'admin-poli-umum')
            <div class="row">
                <!-- Kolom 1 -->
                <div class="col-md-4 mb-3">

                    <button class="btn btn-danger btn-block w-100 mb-2">Rekap Kunjungan</button>
                    <button class="btn btn-dark btn-block w-100 mb-2">Laporan Berdasarkan Kasus</button>
                    <a href="{{ route('report.up') }}" class="btn btn-danger btn-block w-100 mb-2" target="_blank">Pasien
                        Produktif Baru (15-59THN)</a>
                    <button class="btn btn-info btn-block w-100 mb-2">ISPA Tahunan</button>
                    <a href="{{ route('report.rrt') }}" class="btn btn-warning btn-block w-100 mb-2" target="_blank">Rekap
                        Rujukan Terbanyak</a>
                </div>

                <!-- Kolom 2 -->
                <div class="col-md-4 mb-3">
                    <a href="{{ route('report.tifoid') }}" class="btn btn-primary btn-block w-100 mb-2"
                        target="_blank">Laporan
                        Penyakit
                        Tifoid</a>
                    <a href="{{ route('report.stp') }}" class="btn btn-primary btn-block w-100 mb-2" target="_blank">Laporan
                        Surveilans Terpadu
                        Penyakit Berbasis Puskesmas</a>
                    <a href="{{ route('report.ptm') }}" class="btn btn-success btn-block w-100 mb-2" target="_blank">Rekap
                        Penyakit Tidak Menular</a>
                    <a href="{{ route('report.afp') }}" class="btn btn-danger btn-block w-100 mb-2" target="_blank">Laporan
                        Penderita AFP</a>
                    <a href="{{ route('report.difteri') }}" class="btn btn-dark btn-block w-100 mb-2"
                        target="_blank">Laporan
                        Surveilans Integrasi Difteri</a>
                    <a href="{{ route('report.C1') }}" class="btn btn-info btn-block w-100 mb-2" target="_blank">Laporan
                        Kasus
                        Campak</a>
                    <a href="{{ route('report.skdr') }}" class="btn btn-warning btn-block w-100 mb-2"
                        target="_blank">Laporan
                        SKDR</a>

                </div>

                <!-- Kolom 3 -->
                <div class="col-md-4 mb-3">
                    <a href="{{ route('report.formulir11') }}" class="btn btn-success btn-block w-100 mb-2"
                        target="_blank">Rekap Pesakitan Formulir 11</a>
                    <button class="btn btn-danger btn-block w-100 mb-2">Rekap Kunjungan Umur</button>
                    <a href="{{ route('report.lkrj') }}" class="btn btn-info btn-block w-100 mb-2"
                        target="_blank">Kunjungan
                        Rawat Jalan</a>
                    <a href="{{ route('report.lkt') }}" class="btn btn-danger btn-block w-100 mb-2" target="_blank">Rekap
                        Tahunan Penyakit Terbanyak 10</a>
                    <a href="{{ route('report.lbkt') }}" class="btn btn-dark btn-block w-100 mb-2" target="_blank">Rekap
                        Bulanan Kasus Terbanyak Formulir 14</a>
                    <button class="btn btn-danger btn-block w-100 mb-2">Kunjungan Sehat</button>
                    <button class="btn btn-info btn-block w-100 mb-2">TELINGA Tahunan</button>
                    <a href="{{ route('report.poli.diare') }}" class="btn btn-danger btn-block w-100 mb-2" target="_blank">
                        Laporan Penyakit/DIARE
                    </a>

                </div>
            </div>
        @elseif(Auth::user()->role == 'admin-poli-gigi')
            <div class="row">
                <!-- Kolom 1 -->
                <div class="col-md-6 mb-3">
                    <a href="{{ route('report.lkg') }}" class="btn btn-primary btn-block w-100 mb-2"
                        target="_blank">Laporan
                        Kegiatan Pelayanan Kesehatan Gigi dan Mulut</a>

                </div>

                <!-- Kolom 2 -->
                <div class="col-md-6   mb-3">
                    <a href="{{ route('report.lrkg') }}" class="btn btn-success btn-block w-100 mb-2"
                        target="_blank">Laporan
                        Bulanan Kesakitan Gigi dan Mulut</a>

                </div>
            </div>
        @else
            <div class="row">
                <!-- Kolom 1 -->
                <div class="col-md-6 mb-3">
                    <a href="{{ route('report.urt') }}" class="btn btn-primary btn-block w-100 mb-2" target="_blank">Rekap
                        Layanan UGD</a>

                </div>

                <!-- Kolom 2 -->
                <div class="col-md-6   mb-3">
                    <a href="{{ route('report.rjp') }}" class="btn btn-success btn-block w-100 mb-2" target="_blank">Rekap
                        Tindakan UGD</a>

                </div>
            </div>
        @endif
    </div>
@endsection

@section('script')

@endsection
