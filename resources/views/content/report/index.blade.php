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
    <h4 class="mb-3">Laporan Poli Umum</h4>
    <div class="row">
        <!-- Kolom 1 -->
        <div class="col-md-4 mb-3">
            <button class="btn btn-primary btn-block w-100 mb-2">TELUSUR KUNJUNGAN</button>
            <button class="btn btn-primary btn-block w-100 mb-2">Pengendalian ISPA</button>
            <button class="btn btn-success btn-block w-100 mb-2">Rekap Pesakitan</button>
            <button class="btn btn-danger btn-block w-100 mb-2">Rekap Kunjungan</button>
            <button class="btn btn-dark btn-block w-100 mb-2">Kesehatan Jiwa</button>
            <button class="btn btn-dark btn-block w-100 mb-2">Laporan Berdasarkan Kasus</button>
            <button class="btn btn-danger btn-block w-100 mb-2">PASIEN PRODUKTIF BARU (15-59THN)</button>
            <button class="btn btn-info btn-block w-100 mb-2">ISPA Tahunan</button>
        </div>

        <!-- Kolom 2 -->
        <div class="col-md-4 mb-3">
            <button class="btn btn-primary btn-block w-100 mb-2">Gangguan Indera</button>
            <button class="btn btn-primary btn-block w-100 mb-2">Gangguan Pendengaran</button>
            <button class="btn btn-success btn-block w-100 mb-2">Rekap Rujukan Terbanyak</button>
            <button class="btn btn-danger btn-block w-100 mb-2">Pandu</button>
            <button class="btn btn-dark btn-block w-100 mb-2">Daftar Pasien Jiwa</button>
            <button class="btn btn-info btn-block w-100 mb-2">Klaim Rawat Jalan Pasien Jamkesda</button>
            <button class="btn btn-warning btn-block w-100 mb-2">Rekap Kesakitan Formulir 12</button>
            <button class="btn btn-info btn-block w-100 mb-2">MATA Tahunan</button>
        </div>

        <!-- Kolom 3 -->
        <div class="col-md-4 mb-3">
            <button class="btn btn-success btn-block w-100 mb-2">Rekap Pesakitan Formulir 11</button>
            <button class="btn btn-danger btn-block w-100 mb-2">Rekap Kunjungan Umur</button>
            <button class="btn btn-info btn-block w-100 mb-2">Kunjungan Rawat Jalan</button>
            <button class="btn btn-danger btn-block w-100 mb-2">Rekap Tahunan Penyakit Terbanyak 10</button>
            <button class="btn btn-dark btn-block w-100 mb-2">Rekap Bulanan Kasus Terbanyak Formulir 14</button>
            <button class="btn btn-danger btn-block w-100 mb-2">Kunjungan Sehat</button>
            <button class="btn btn-info btn-block w-100 mb-2">TELINGA Tahunan</button>
            <button class="btn btn-danger btn-block w-100 mb-2">Laporan Penyakit/DIARE</button>
        </div>
    </div>
</div>
@endsection

@section('script')

@endsection

