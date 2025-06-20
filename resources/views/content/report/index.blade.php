@extends('layouts.simple.master')
@section('title', 'Laporan')

@section('css')
@endsection

@section('style')
    <style>
        .profile-picture {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 50%;
            border: 2px solid #ddd;
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
        @if ($routeName === 'report.index')
            <h4 class="mb-3">Laporan Poli Umum</h4>
        @elseif($routeName === 'report.index.gigi')
            <h4 class="mb-3">Laporan Poli Gigi</h4>
        @else
            <h4 class="mb-3">UGD</h4>
        @endif

        <div class="row">
            @php
                $modals = [
                    ['id' => 'modalRekapKunjungan', 'label' => 'Rekap Kunjungan', 'route' => 'report.rrt'],
                    [
                        'id' => 'modalLaporanKasus',
                        'label' => 'Laporan Berdasarkan Kasus',
                        'route' => 'report.rrt',
                    ],
                    [
                        'id' => 'modalPasienProduktif',
                        'label' => 'Laporan Pasien Produktif (15-59THN)',
                        'route' => 'report.uspro',
                    ],
                    ['id' => 'modalISPA', 'label' => 'ISPA Tahunan', 'route' => 'report.rrt'],
                    [
                        'id' => 'modalRujukanTerbanyak',
                        'label' => 'Rekap Rujukan Terbanyak',
                        'route' => 'report.rrt',
                        'method' => 'POST',
                    ],
                    [
                        'id' => 'modalRujukanTerbanyakRS',
                        'label' => 'Rekap Rujukan Terbanyak RS',
                        'route' => 'report.lr',
                    ],
                    ['id' => 'modalTifoid', 'label' => 'Laporan Penyakit Tifoid', 'route' => 'report.tifoid'],
                    [
                        'id' => 'modalSTP',
                        'label' => 'Laporan Surveilans Terpadu Penyakit Berbasis Puskesmas',
                        'route' => 'report.stp',
                    ],
                    ['id' => 'modalAFP', 'label' => 'Laporan Penderita AFP', 'route' => 'report.afp'],
                    [
                        'id' => 'modalDifteri',
                        'label' => 'Laporan Surveilans Integrasi Difteri',
                        'route' => 'report.difteri',
                    ],
                    ['id' => 'modalC1', 'label' => 'Laporan Kasus Campak', 'route' => 'report.C1'],
                    ['id' => 'modalSKDR', 'label' => 'Laporan SKDR', 'route' => 'report.skdr'],
                    [
                        'id' => 'modalFormulir11',
                        'label' => 'Rekap Pesakitan Formulir 11',
                        'route' => 'report.formulir11',
                    ],
                    ['id' => 'modalKunjunganUmur', 'label' => 'Rekap Kunjungan Umur'],
                    ['id' => 'modalKunjunganRawatJalan', 'label' => 'Kunjungan Rawat Jalan', 'route' => 'report.lkrj'],
                    ['id' => 'modalLKT', 'label' => 'Rekap Tahunan Penyakit Terbanyak 10', 'route' => 'report.lkt'],
                    [
                        'id' => 'modalLBKT',
                        'label' => 'Rekap Bulanan Kasus Terbanyak Formulir 14',
                        'route' => 'report.lbkt',
                    ],
                    ['id' => 'modalKunjunganSehat', 'label' => 'Kunjungan Sehat'],
                    ['id' => 'modalTELINGA', 'label' => 'TELINGA Tahunan'],
                    [
                        'id' => 'modalLKG',
                        'label' => 'Laporan Kegiatan Pelayanan Kesehatan Gigi dan Mulut',
                        'route' => 'report.lkg',
                    ],
                    [
                        'id' => 'modalLRKG',
                        'label' => 'Laporan Bulanan Formulir 13',
                        'route' => 'report.formulir13',
                    ],
                    [
                        'id' => 'modalLBF12',
                        'label' => 'Laporan Bulanan Formulir 12',
                        'route' => 'report.formulir12',
                    ],
                    ['id' => 'modalURT', 'label' => 'Rekap Layanan UGD', 'route' => 'report.urt'],
                    ['id' => 'modalRJP', 'label' => 'Rekap Tindakan UGD', 'route' => 'report.rjp'],
                    ['id' => 'modalDiare', 'label' => 'Laporan Penyakit/DIARE', 'route' => 'report.poli.diare'],
                    ['id' => 'modalJamkesda', 'label' => 'Laporan Rawat Jalan Jamkesda', 'route' => 'report.jamkesda'],
                    [
                        'id' => 'modalPanduHipertensi',
                        'label' => 'Laporan Pandu PTM Hipertensi',
                        'route' => 'report.pandu.hipertensi',
                    ],
                    [
                        'id' => 'modalPanduDiabetes',
                        'label' => 'Laporan Pandu PTM Diabetes',
                        'route' => 'report.pandu.diabetes',
                    ],
                    [
                        'id' => 'modalBpjs',
                        'label' => 'Laporan BPJS',
                        'route' => 'report.bpjs',
                    ],
                    [
                        'id' => 'modalKunjungan',
                        'label' => 'Laporan Kunjungan',
                        'route' => 'report.kunjungan',
                    ],
                    [
                        'id' => 'modalIspa',
                        'label' => 'Laporan Ispa',
                        'route' => 'report.ispa',
                    ],
                    [
                        'id' => 'modalPendengaranBaru',
                        'label' => 'Laporan Data Indera Kasus Baru',
                        'route' => 'report.pendengaran.baru',
                    ],
                    [
                        'id' => 'modalPendengaranLama',
                        'label' => 'Laporan Data Indera Kasus Lama',
                        'route' => 'report.pendengaran.lama',
                    ],
                ];
            @endphp

            <div class="row">
                <!-- Kolom 1 -->
                <div class="col-md-4 mb-3">
                    <button class="btn btn-danger w-100 mb-3" data-bs-toggle="modal"
                        data-bs-target="#modalRekapKunjungan">Rekap Kunjungan</button>
                    <button class="btn btn-dark w-100 mb-3" data-bs-toggle="modal"
                        data-bs-target="#modalLaporanKasus">Laporan Berdasarkan Kasus</button>
                    <button class="btn btn-danger w-100 mb-3" data-bs-toggle="modal"
                        data-bs-target="#modalPasienProduktif">Laporan Pasien Produktif (15-59THN)</button>
                    <button class="btn btn-info w-100 mb-3" data-bs-toggle="modal" data-bs-target="#modalISPA">ISPA
                        Tahunan</button>
                    <button class="btn btn-warning w-100 mb-3" data-bs-toggle="modal"
                        data-bs-target="#modalRujukanTerbanyak">Rekap Rujukan Terbanyak</button>
                    <button class="btn btn-warning w-100 mb-3" data-bs-toggle="modal"
                        data-bs-target="#modalRujukanTerbanyakRS">Rekap Rujukan Terbanyak RS</button>
                    <button class="btn btn-warning w-100 mb-3" data-bs-toggle="modal"
                        data-bs-target="#modalLKGLabel">Laporan Kegiatan Pelayanan Kesehatan Gigi dan Mulut</button>
                    <button class="btn btn-danger w-100 mb-3" data-bs-toggle="modal" data-bs-target="#modalURT">Rekap
                        Layanan UGD</button>
                    <button class="btn btn-dark w-100 mb-3" data-bs-toggle="modal" data-bs-target="#modalRJP">Rekap
                        Tindakan UGD</button>
                    <button class="btn btn-success w-100 mb-3" data-bs-toggle="modal"
                        data-bs-target="#modalPanduHipertensi">Laporan Pandu PTM Hipertensi</button>
                    <button class="btn btn-info w-100 mb-3" data-bs-toggle="modal" data-bs-target="#modalBpjs">
                        Laporan BPJS</button>
                </div>

                <!-- Kolom 2 -->
                <div class="col-md-4 mb-3">
                    <button class="btn btn-primary w-100 mb-3" data-bs-toggle="modal" data-bs-target="#modalTifoid">Laporan
                        Penyakit Tifoid</button>
                    <button class="btn btn-primary w-100 mb-3" data-bs-toggle="modal" data-bs-target="#modalSTP">Laporan
                        Surveilans Terpadu</button>
                    <button class="btn btn-danger w-100 mb-3" data-bs-toggle="modal" data-bs-target="#modalAFP">Laporan
                        Penderita AFP</button>
                    <button class="btn btn-info w-100 mb-3" data-bs-toggle="modal" data-bs-target="#modalC1">Laporan Kasus
                        Campak</button>
                    <button class="btn btn-warning w-100 mb-3" data-bs-toggle="modal" data-bs-target="#modalSKDR">Laporan
                        SKDR</button>
                    <button class="btn btn-warning w-100 mb-3" data-bs-toggle="modal" data-bs-target="#modalLRKG">
                        Laporan Bulanan Formulir 13</button>
                    <button class="btn btn-success w-100 mb-3" data-bs-toggle="modal" data-bs-target="#modalLBF12">Laporan
                        Bulanan Formulir 12</button>
                    <button class="btn btn-danger w-100 mb-3" data-bs-toggle="modal" data-bs-target="#modalJamkesda">Laporan
                        Rawat Jalan Jamkesda</button>
                    <button class="btn btn-success w-100 mb-3" data-bs-toggle="modal"
                        data-bs-target="#modalKunjungan">Laporan
                        Kunjungan Baru dan Kunjungan Lama</button>
                    <button class="btn btn-dark w-100 mb-3" data-bs-toggle="modal"
                        data-bs-target="#modalPendengaranBaru">Laporan
                        Data Indera Kasus Baru</button>
                    <button class="btn btn-warning w-100 mb-3" data-bs-toggle="modal"
                        data-bs-target="#modalPendengaranLama">Laporan
                        Data Indera Kasus Lama</button>

                </div>

                <!-- Kolom 3 -->
                <div class="col-md-4 mb-3">
                    <button class="btn btn-success w-100 mb-3" data-bs-toggle="modal"
                        data-bs-target="#modalFormulir11">Rekap Pesakitan Formulir 11</button>
                    <button class="btn btn-danger w-100 mb-3" data-bs-toggle="modal"
                        data-bs-target="#modalKunjunganUmur">Rekap Kunjungan Umur</button>
                    <button class="btn btn-info w-100 mb-3" data-bs-toggle="modal"
                        data-bs-target="#modalKunjunganRawatJalan">Kunjungan Rawat Jalan</button>
                    <button class="btn btn-danger w-100 mb-3" data-bs-toggle="modal" data-bs-target="#modalLKT">Rekap
                        Tahunan Penyakit Terbanyak 10</button>
                    <button class="btn btn-dark w-100 mb-3" data-bs-toggle="modal" data-bs-target="#modalLBKT">Rekap Bulanan
                        Kasus Formulir 14</button>
                    <button class="btn btn-danger w-100 mb-3" data-bs-toggle="modal"
                        data-bs-target="#modalKunjunganSehat">Kunjungan Sehat</button>
                    <button class="btn btn-info w-100 mb-3" data-bs-toggle="modal" data-bs-target="#modalTELINGA">TELINGA
                        Tahunan</button>
                    <button class="btn btn-danger w-100 mb-3" data-bs-toggle="modal" data-bs-target="#modalDiare">Laporan
                        Penyakit/DIARE</button>
                    <button class="btn btn-success w-100 mb-3" data-bs-toggle="modal"
                        data-bs-target="#modalPanduDiabetes">Laporan Pandu PTM Diabetes</button>
                    <button class="btn btn-primary w-100 mb-3" data-bs-toggle="modal" data-bs-target="#modalIspa">Laporan
                        Ispa</button>

                </div>
            </div>

        </div>

        @foreach ($modals as $modal)
            <div class="modal fade" id="{{ $modal['id'] }}" tabindex="-1" aria-labelledby="{{ $modal['id'] }}Label"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="{{ $modal['id'] }}Label">{{ $modal['label'] }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <form action="{{ isset($modal['route']) ? route($modal['route']) : '#' }}"
                            method="{{ $modal['method'] ?? 'GET' }}" target="_blank">
                            @if (($modal['method'] ?? 'GET') === 'POST')
                                @csrf
                            @endif
                            <div class="modal-body">
                                <label for="bulan{{ $modal['id'] }}">Bulan</label>
                                <select id="bulan{{ $modal['id'] }}" name="bulan" class="form-select mb-3">
                                    @foreach ([1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus', 9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'] as $k => $v)
                                        <option value="{{ $k }}">{{ $v }}</option>
                                    @endforeach
                                </select>

                                <label for="tahun{{ $modal['id'] }}">Tahun</label>
                                <select id="tahun{{ $modal['id'] }}" name="tahun" class="form-control mb-3">
                                    @for ($year = 2020; $year <= now()->year; $year++)
                                        <option value="{{ $year }}">{{ $year }}</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                <button type="submit" class="btn btn-primary">Filter</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection

@section('script')
@endsection
