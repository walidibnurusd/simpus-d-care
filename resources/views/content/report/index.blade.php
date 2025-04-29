<<<<<<< HEAD
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
        @if ($routeName === 'report.index')
            <h4 class="mb-3">Laporan Poli Umum</h4>
        @elseif($routeName === 'report.index.gigi')
            <h4 class="mb-3">Laporan Poli Gigi</h4>
        @else
            <h4 class="mb-3">UGD</h4>
        @endif
        {{-- @if ($routeName === 'report.index') --}}
            <div class="row">
                <!-- Kolom 1 -->
                <div class="col-md-4 mb-3">
                    <!-- Button triggers modals -->
                    <button class="btn btn-danger btn-block w-100 mb-2" data-bs-toggle="modal"
                        data-bs-target="#modalRekapKunjungan">Rekap Kunjungan</button>
                    <button class="btn btn-dark btn-block w-100 mb-2" data-bs-toggle="modal"
                        data-bs-target="#modalLaporanKasus">Laporan Berdasarkan Kasus</button>
                    <button class="btn btn-danger btn-block w-100 mb-2" data-bs-toggle="modal"
                        data-bs-target="#modalPasienProduktif">Pasien Produktif Baru (15-59THN)</button>
                    <button class="btn btn-info btn-block w-100 mb-2" data-bs-toggle="modal"
                        data-bs-target="#modalISPA">ISPA Tahunan</button>
                    <button class="btn btn-warning btn-block w-100 mb-2" data-bs-toggle="modal"
                        data-bs-target="#modalRujukanTerbanyak">Rekap Rujukan Terbanyak</button>
                    <button class="btn btn-warning btn-block w-100 mb-2" data-bs-toggle="modal"
                        data-bs-target="#modalRujukanTerbanyakRS">Rekap Rujukan Terbanyak RS</button>
                </div>



                <!-- Kolom 2 -->
                <div class="col-md-4 mb-3">
                    <a href="javascript:void(0)" class="btn btn-primary btn-block w-100 mb-2" data-bs-toggle="modal"
                        data-bs-target="#modalTifoid">Laporan Penyakit Tifoid</a>
                    <a href="javascript:void(0)" class="btn btn-primary btn-block w-100 mb-2" data-bs-toggle="modal"
                        data-bs-target="#modalSTP">Laporan Surveilans Terpadu Penyakit Berbasis Puskesmas</a>
                    <a href="javascript:void(0)" class="btn btn-success btn-block w-100 mb-2" data-bs-toggle="modal"
                        data-bs-target="#modalPTM">Rekap Penyakit Tidak Menular</a>
                    <a href="javascript:void(0)" class="btn btn-danger btn-block w-100 mb-2" data-bs-toggle="modal"
                        data-bs-target="#modalAFP">Laporan Penderita AFP</a>
                    <a href="javascript:void(0)" class="btn btn-dark btn-block w-100 mb-2" data-bs-toggle="modal"
                        data-bs-target="#modalDifteri">Laporan Surveilans Integrasi Difteri</a>
                    <a href="javascript:void(0)" class="btn btn-info btn-block w-100 mb-2" data-bs-toggle="modal"
                        data-bs-target="#modalC1">Laporan Kasus Campak</a>
                    <a href="javascript:void(0)" class="btn btn-warning btn-block w-100 mb-2" data-bs-toggle="modal"
                        data-bs-target="#modalSKDR">Laporan SKDR</a>


                </div>

                <!-- Kolom 3 -->
                <div class="col-md-4 mb-3">
                    <a class="btn btn-success btn-block w-100 mb-2" data-bs-toggle="modal"
                        data-bs-target="#modalFormulir11">Rekap Pesakitan Formulir 11</a>
                    <button class="btn btn-danger btn-block w-100 mb-2" data-bs-toggle="modal"
                        data-bs-target="#modalKunjunganUmur">Rekap Kunjungan Umur</button>
                    <button class="btn btn-info btn-block w-100 mb-2" data-bs-toggle="modal"
                        data-bs-target="#modalKunjunganRawatJalan">Kunjungan Rawat Jalan</button>
                    <a class="btn btn-danger btn-block w-100 mb-2" data-bs-toggle="modal" data-bs-target="#modalLKT">Rekap
                        Tahunan Penyakit Terbanyak 10</a>
                    <a class="btn btn-dark btn-block w-100 mb-2" data-bs-toggle="modal" data-bs-target="#modalLBKT">Rekap
                        Bulanan Kasus Terbanyak Formulir 14</a>
                    <button class="btn btn-danger btn-block w-100 mb-2" data-bs-toggle="modal"
                        data-bs-target="#modalKunjunganSehat">Kunjungan Sehat</button>
                    <button class="btn btn-info btn-block w-100 mb-2" data-bs-toggle="modal"
                        data-bs-target="#modalTELINGA">TELINGA Tahunan</button>
                    <button class="btn btn-danger btn-block w-100 mb-2" data-bs-toggle="modal"
                        data-bs-target="#modalDiare">Laporan Penyakit/DIARE</button>
                </div>
            </div>
        {{-- @elseif($routeName === 'report.index.gigi') --}}
            <div class="row">
                <div class="col-md-6 mb-3">
                    <button type="button" class="btn btn-primary btn-block w-100 mb-2" data-bs-toggle="modal"
                        data-bs-target="#modalLKG">
                        Laporan Kegiatan Pelayanan Kesehatan Gigi dan Mulut
                    </button>
                </div>

                <div class="col-md-6 mb-3">
                    <button type="button" class="btn btn-success btn-block w-100 mb-2" data-bs-toggle="modal"
                        data-bs-target="#modalLRKG">
                        Laporan Bulanan Kesakitan Gigi dan Mulut
                    </button>
                </div>
            </div>
        {{-- @else --}}
            <div class="row">
                <!-- Kolom 1 -->
                <div class="col-md-6 mb-3">
                    <button type="button" class="btn btn-primary btn-block w-100 mb-2" data-bs-toggle="modal"
                        data-bs-target="#modalURT">
                        Rekap Layanan UGD
                    </button>
                </div>

                <div class="col-md-6 mb-3">
                    <button type="button" class="btn btn-success btn-block w-100 mb-2" data-bs-toggle="modal"
                        data-bs-target="#modalRJP">
                        Rekap Tindakan UGD
                    </button>
                </div>
            </div>
        {{-- @endif --}}
        <div class="modal fade" id="modalURT" tabindex="-1" aria-labelledby="modalURTLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalURTLabel">Filter Rekap Layanan UGD</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('report.urt') }}" method="GET" target="_blank">
                        <div class="modal-body">
                            <label for="bulanURT" class="form-label">Bulan</label>
                            <select id="bulanURT" name="bulan" class="form-control mb-3">
                                <option value="01">Januari</option>
                                <option value="02">Februari</option>
                                <option value="03">Maret</option>
                                <option value="04">April</option>
                                <option value="05">Mei</option>
                                <option value="06">Juni</option>
                                <option value="07">Juli</option>
                                <option value="08">Agustus</option>
                                <option value="09">September</option>
                                <option value="10">Oktober</option>
                                <option value="11">November</option>
                                <option value="12">Desember</option>
                            </select>

                            <label for="tahunURT" class="form-label">Tahun</label>
                            <select id="tahunURT" name="tahun" class="form-control mb-3">
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

        <!-- Modal untuk Rekap Tindakan UGD -->
        <div class="modal fade" id="modalRJP" tabindex="-1" aria-labelledby="modalRJPLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalRJPLabel">Filter Rekap Tindakan UGD</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('report.rjp') }}" method="GET" target="_blank">
                        <div class="modal-body">
                            <label for="bulanRJP" class="form-label">Bulan</label>
                            <select id="bulanRJP" name="bulan" class="form-control mb-3">
                                <option value="01">Januari</option>
                                <option value="02">Februari</option>
                                <option value="03">Maret</option>
                                <option value="04">April</option>
                                <option value="05">Mei</option>
                                <option value="06">Juni</option>
                                <option value="07">Juli</option>
                                <option value="08">Agustus</option>
                                <option value="09">September</option>
                                <option value="10">Oktober</option>
                                <option value="11">November</option>
                                <option value="12">Desember</option>
                            </select>

                            <label for="tahunRJP" class="form-label">Tahun</label>
                            <select id="tahunRJP" name="tahun" class="form-control mb-3">
                                @for ($year = 2020; $year <= now()->year; $year++)
                                    <option value="{{ $year }}">{{ $year }}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-success">Filter</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- Modal untuk Laporan Kegiatan Pelayanan Kesehatan Gigi dan Mulut -->
          <div class="modal fade" id="modalLKG" tabindex="-1" aria-labelledby="modalLKGLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalLKGLabel">Filter Laporan Kegiatan Pelayanan Kesehatan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('report.lkg') }}" method="GET" target="_blank">
                        <div class="modal-body">
                            <label for="bulanRJP" class="form-label">Bulan</label>
                            <select id="bulanRJP" name="bulan" class="form-control mb-3">
                                <option value="01">Januari</option>
                                <option value="02">Februari</option>
                                <option value="03">Maret</option>
                                <option value="04">April</option>
                                <option value="05">Mei</option>
                                <option value="06">Juni</option>
                                <option value="07">Juli</option>
                                <option value="08">Agustus</option>
                                <option value="09">September</option>
                                <option value="10">Oktober</option>
                                <option value="11">November</option>
                                <option value="12">Desember</option>
                            </select>
                            <label for="tahunLKG" class="form-label">Tahun</label>
                            <select id="tahunLKG" name="tahun" class="form-control mb-3">
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
        <!-- Modal untuk Laporan Bulanan Kesakitan Gigi dan Mulut -->
        <div class="modal fade" id="modalLRKG" tabindex="-1" aria-labelledby="modalLRKGLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalLRKGLabel">Filter Laporan Bulanan Kesakitan Gigi dan Mulut</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('report.lrkg') }}" method="GET" target="_blank">
                        <div class="modal-body">
                            <label for="bulanLRKG" class="form-label">Bulan</label>
                            <select id="bulanLRKG" name="bulan" class="form-control mb-3">
                                <option value="01">Januari</option>
                                <option value="02">Februari</option>
                                <option value="03">Maret</option>
                                <option value="04">April</option>
                                <option value="05">Mei</option>
                                <option value="06">Juni</option>
                                <option value="07">Juli</option>
                                <option value="08">Agustus</option>
                                <option value="09">September</option>
                                <option value="10">Oktober</option>
                                <option value="11">November</option>
                                <option value="12">Desember</option>
                            </select>

                            <label for="tahunLRKG" class="form-label">Tahun</label>
                            <select id="tahunLRKG" name="tahun" class="form-control mb-3">
                                @for ($year = 2020; $year <= now()->year; $year++)
                                    <option value="{{ $year }}">{{ $year }}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-success">Filter</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal fade" id="modalTELINGA" tabindex="-1" aria-labelledby="modalTELINGALabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalTELINGALabel">TELINGA Tahunan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="" method="GET">
                        <div class="modal-body">
                            <label for="tahunTELINGA">Tahun</label>
                            <select id="tahunTELINGA" name="tahun" class="form-control mb-3">
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

        <!-- Laporan Penyakit/DIARE Modal -->
        <div class="modal fade" id="modalDiare" tabindex="-1" aria-labelledby="modalDiareLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalDiareLabel">Laporan Penyakit/DIARE</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('report.poli.diare') }}" method="GET">
                        <div class="modal-body">
                            <label for="bulanDiare">Bulan</label>
                            <select id="bulanRujukanTerbanyak" name="bulan" class="form-select mb-3">
                                <option value="1">Januari</option>
                                <option value="2">Februari</option>
                                <option value="3">Maret</option>
                                <option value="4">April</option>
                                <option value="5">Mei</option>
                                <option value="6">Juni</option>
                                <option value="7">Juli</option>
                                <option value="8">Agustus</option>
                                <option value="9">September</option>
                                <option value="10">Oktober</option>
                                <option value="11">November</option>
                                <option value="12">Desember</option>
                            </select>

                            <label for="tahunDiare">Tahun</label>
                            <select id="tahunTELINGA" name="tahun" class="form-control mb-3">
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
        <!-- Rekap Tahunan Penyakit Terbanyak 10 -->
        <div class="modal fade" id="modalLKT" tabindex="-1" aria-labelledby="modalLKTLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalLKTLabel">Rekap Tahunan Penyakit Terbanyak 10</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('report.lkt') }}" method="GET">
                        <div class="modal-body">
                            <label for="bulanLBKT">Bulan</label>
                            <select id="bulanRujukanTerbanyak" name="bulan" class="form-select mb-3">
                                @foreach ([
                                    1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
                                    5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
                                    9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
                                ] as $key => $month)
                                    <option value="{{ $key }}">{{ $month }}</option>
                                @endforeach
                            </select>
        
                            <label for="tahunLKT">Tahun</label>
                            <select id="tahunTELINGA" name="tahun" class="form-control mb-3">
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
        

        <!-- Rekap Bulanan Kasus Terbanyak Formulir 14 -->
        <div class="modal fade" id="modalLBKT" tabindex="-1" aria-labelledby="modalLBKTLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalLBKTLabel">Rekap Bulanan Kasus Terbanyak Formulir 14</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('report.lbkt') }}" method="GET">
                        <div class="modal-body">
                            <label for="bulanLBKT">Bulan</label>
                            <select id="bulanRujukanTerbanyak" name="bulan" class="form-select mb-3">
                                <option value="1">Januari</option>
                                <option value="2">Februari</option>
                                <option value="3">Maret</option>
                                <option value="4">April</option>
                                <option value="5">Mei</option>
                                <option value="6">Juni</option>
                                <option value="7">Juli</option>
                                <option value="8">Agustus</option>
                                <option value="9">September</option>
                                <option value="10">Oktober</option>
                                <option value="11">November</option>
                                <option value="12">Desember</option>
                            </select>

                            <label for="tahunLBKT">Tahun</label>
                            <select id="tahunLBKT" name="tahun" class="form-control mb-3">
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

        <!-- Kunjungan Sehat -->
        <div class="modal fade" id="modalKunjunganSehat" tabindex="-1" aria-labelledby="modalKunjunganSehatLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalKunjunganSehatLabel">Kunjungan Sehat</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="" method="GET">
                        <div class="modal-body">
                            <label for="bulanKunjunganSehat">Bulan</label>
                            <select id="bulanRujukanTerbanyak" name="bulan" class="form-select mb-3">
                                <option value="1">Januari</option>
                                <option value="2">Februari</option>
                                <option value="3">Maret</option>
                                <option value="4">April</option>
                                <option value="5">Mei</option>
                                <option value="6">Juni</option>
                                <option value="7">Juli</option>
                                <option value="8">Agustus</option>
                                <option value="9">September</option>
                                <option value="10">Oktober</option>
                                <option value="11">November</option>
                                <option value="12">Desember</option>
                            </select>

                            <label for="tahunKunjunganSehat">Tahun</label>
                            <select id="tahunKunjunganSehat" name="tahun" class="form-control mb-3">
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
        <!-- Rekap Pesakitan Formulir 11 -->
        <div class="modal fade" id="modalFormulir11" tabindex="-1" aria-labelledby="modalFormulir11Label"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalFormulir11Label">Rekap Pesakitan Formulir 11</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('report.formulir11') }}" method="GET">
                        <div class="modal-body">
                            <label for="bulanFormulir11">Bulan</label>
                            <select id="bulanRujukanTerbanyak" name="bulan" class="form-select mb-3">
                                <option value="1">Januari</option>
                                <option value="2">Februari</option>
                                <option value="3">Maret</option>
                                <option value="4">April</option>
                                <option value="5">Mei</option>
                                <option value="6">Juni</option>
                                <option value="7">Juli</option>
                                <option value="8">Agustus</option>
                                <option value="9">September</option>
                                <option value="10">Oktober</option>
                                <option value="11">November</option>
                                <option value="12">Desember</option>
                            </select>

                            <label for="tahunFormulir11">Tahun</label>
                            <select id="tahunFormulir11" name="tahun" class="form-control mb-3">
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

        <!-- Rekap Kunjungan Umur -->
        <div class="modal fade" id="modalKunjunganUmur" tabindex="-1" aria-labelledby="modalKunjunganUmurLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalKunjunganUmurLabel">Rekap Kunjungan Umur</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="" method="GET">
                        <div class="modal-body">
                            <label for="bulanKunjunganUmur">Bulan</label>
                            <select id="bulanRujukanTerbanyak" name="bulan" class="form-select mb-3">
                                <option value="1">Januari</option>
                                <option value="2">Februari</option>
                                <option value="3">Maret</option>
                                <option value="4">April</option>
                                <option value="5">Mei</option>
                                <option value="6">Juni</option>
                                <option value="7">Juli</option>
                                <option value="8">Agustus</option>
                                <option value="9">September</option>
                                <option value="10">Oktober</option>
                                <option value="11">November</option>
                                <option value="12">Desember</option>
                            </select>

                            <label for="tahunKunjunganUmur">Tahun</label>
                            <select id="tahunKunjunganUmur" name="tahun" class="form-control mb-3">
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

        <!-- Tambahkan modal lainnya untuk setiap tombol -->
        <!-- Contoh untuk Kunjungan Rawat Jalan -->
        <div class="modal fade" id="modalKunjunganRawatJalan" tabindex="-1"
            aria-labelledby="modalKunjunganRawatJalanLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalKunjunganRawatJalanLabel">Kunjungan Rawat Jalan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('report.lkrj') }}" method="GET">
                        <div class="modal-body">
                            <label for="bulanKunjunganRawatJalan">Bulan</label>
                            <select id="bulanRujukanTerbanyak" name="bulan" class="form-select mb-3">
                                <option value="1">Januari</option>
                                <option value="2">Februari</option>
                                <option value="3">Maret</option>
                                <option value="4">April</option>
                                <option value="5">Mei</option>
                                <option value="6">Juni</option>
                                <option value="7">Juli</option>
                                <option value="8">Agustus</option>
                                <option value="9">September</option>
                                <option value="10">Oktober</option>
                                <option value="11">November</option>
                                <option value="12">Desember</option>
                            </select>

                            <label for="tahunKunjunganRawatJalan">Tahun</label>
                            <select id="tahunKunjunganRawatJalan" name="tahun" class="form-control mb-3">
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
        <!-- Modal Rekap Kunjungan -->
        <div class="modal fade" id="modalRekapKunjungan" tabindex="-1" aria-labelledby="modalRekapKunjunganLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalRekapKunjunganLabel">Rekap Kunjungan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <label for="bulanRujukanTerbanyak">Bulan</label>
                        <select id="bulanRujukanTerbanyak" name="bulan" class="form-select mb-3">
                            <option value="1">Januari</option>
                            <option value="2">Februari</option>
                            <option value="3">Maret</option>
                            <option value="4">April</option>
                            <option value="5">Mei</option>
                            <option value="6">Juni</option>
                            <option value="7">Juli</option>
                            <option value="8">Agustus</option>
                            <option value="9">September</option>
                            <option value="10">Oktober</option>
                            <option value="11">November</option>
                            <option value="12">Desember</option>
                        </select>
                        <label for="tahunRujukanTerbanyak">Tahun</label>
                        <select id="tahunRujukanTerbanyak" class="form-control" name="tahun" required>
                            @for ($i = 2020; $i <= date('Y'); $i++)
                                <option value="{{ $i }}">{{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        {{-- <form action="{{ route('report.rekapKunjungan') }}" method="GET"> --}}
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        {{-- </form> --}}
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Laporan Berdasarkan Kasus -->
        <div class="modal fade" id="modalLaporanKasus" tabindex="-1" aria-labelledby="modalLaporanKasusLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalLaporanKasusLabel">Laporan Berdasarkan Kasus</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <label for="bulanRujukanTerbanyak">Bulan</label>
                        <select id="bulanRujukanTerbanyak" name="bulan" class="form-select mb-3">
                            <option value="1">Januari</option>
                            <option value="2">Februari</option>
                            <option value="3">Maret</option>
                            <option value="4">April</option>
                            <option value="5">Mei</option>
                            <option value="6">Juni</option>
                            <option value="7">Juli</option>
                            <option value="8">Agustus</option>
                            <option value="9">September</option>
                            <option value="10">Oktober</option>
                            <option value="11">November</option>
                            <option value="12">Desember</option>
                        </select>
                        <label for="tahunRujukanTerbanyak">Tahun</label>
                        <select id="tahunRujukanTerbanyak" class="form-control" name="tahun" required>
                            @for ($i = 2020; $i <= date('Y'); $i++)
                                <option value="{{ $i }}">{{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        {{-- <form action="{{ route('report.laporanKasus') }}" method="GET"> --}}
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        {{-- </form> --}}
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Pasien Produktif Baru (15-59THN) -->
        <div class="modal fade" id="modalPasienProduktif" tabindex="-1" aria-labelledby="modalPasienProduktifLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalPasienProduktifLabel">Pasien Produktif Baru (15-59THN)</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('report.up') }}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <label for="bulanRujukanTerbanyak">Bulan</label>
                            <select id="bulanRujukanTerbanyak" name="bulan" class="form-select mb-3">
                                <option value="1">Januari</option>
                                <option value="2">Februari</option>
                                <option value="3">Maret</option>
                                <option value="4">April</option>
                                <option value="5">Mei</option>
                                <option value="6">Juni</option>
                                <option value="7">Juli</option>
                                <option value="8">Agustus</option>
                                <option value="9">September</option>
                                <option value="10">Oktober</option>
                                <option value="11">November</option>
                                <option value="12">Desember</option>
                            </select>
                            <label for="tahunRujukanTerbanyak">Tahun</label>
                            <select id="tahunRujukanTerbanyak" class="form-control" name="tahun" required>
                                @for ($i = 2020; $i <= date('Y'); $i++)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal ISPA Tahunan -->
        <div class="modal fade" id="modalISPA" tabindex="-1" aria-labelledby="modalISPALabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalISPALabel">ISPA Tahunan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <label for="bulanRujukanTerbanyak">Bulan</label>
                        <select id="bulanRujukanTerbanyak" name="bulan" class="form-select mb-3">
                            <option value="1">Januari</option>
                            <option value="2">Februari</option>
                            <option value="3">Maret</option>
                            <option value="4">April</option>
                            <option value="5">Mei</option>
                            <option value="6">Juni</option>
                            <option value="7">Juli</option>
                            <option value="8">Agustus</option>
                            <option value="9">September</option>
                            <option value="10">Oktober</option>
                            <option value="11">November</option>
                            <option value="12">Desember</option>
                        </select>
                        <label for="tahunRujukanTerbanyak">Tahun</label>
                        <select id="tahunRujukanTerbanyak" class="form-control" name="tahun" required>
                            @for ($i = 2020; $i <= date('Y'); $i++)
                                <option value="{{ $i }}">{{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        {{-- <form action="{{ route('report.ispa') }}" method="GET"> --}}
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        {{-- </form> --}}
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Rekap Rujukan Terbanyak -->
        <div class="modal fade" id="modalRujukanTerbanyak" tabindex="-1" aria-labelledby="modalRujukanTerbanyakLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalRujukanTerbanyakLabel">Rekap Rujukan Terbanyak</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('report.rrt') }}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <label for="bulanRujukanTerbanyak">Bulan</label>
                            <select id="bulanRujukanTerbanyak" name="bulan" class="form-select mb-3">
                                <option value="1">Januari</option>
                                <option value="2">Februari</option>
                                <option value="3">Maret</option>
                                <option value="4">April</option>
                                <option value="5">Mei</option>
                                <option value="6">Juni</option>
                                <option value="7">Juli</option>
                                <option value="8">Agustus</option>
                                <option value="9">September</option>
                                <option value="10">Oktober</option>
                                <option value="11">November</option>
                                <option value="12">Desember</option>
                            </select>
                            <label for="tahunRujukanTerbanyak">Tahun</label>
                            <select id="tahunRujukanTerbanyak" class="form-control" name="tahun" required>
                                @for ($i = 2020; $i <= date('Y'); $i++)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
        <div class="modal fade" id="modalRujukanTerbanyakRS" tabindex="-1" aria-labelledby="modalRujukanTerbanyakLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalRujukanTerbanyakLabel">Rekap Rujukan Terbanyak</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('report.lr') }}" method="GET">
                        @csrf
                        <div class="modal-body">
                            <label for="bulanRujukanTerbanyak">Bulan</label>
                            <select id="bulanRujukanTerbanyak" name="bulan" class="form-select mb-3">
                                <option value="1">Januari</option>
                                <option value="2">Februari</option>
                                <option value="3">Maret</option>
                                <option value="4">April</option>
                                <option value="5">Mei</option>
                                <option value="6">Juni</option>
                                <option value="7">Juli</option>
                                <option value="8">Agustus</option>
                                <option value="9">September</option>
                                <option value="10">Oktober</option>
                                <option value="11">November</option>
                                <option value="12">Desember</option>
                            </select>
                            <label for="tahunRujukanTerbanyak">Tahun</label>
                            <select id="tahunRujukanTerbanyak" class="form-control" name="tahun" required>
                                @for ($i = 2020; $i <= date('Y'); $i++)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
        <!-- Modal for Tifoid Report -->
        <div class="modal fade" id="modalTifoid" tabindex="-1" aria-labelledby="modalTifoidLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalTifoidLabel">Laporan Penyakit Tifoid</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('report.tifoid') }}" method="GET">
                        @csrf
                        <div class="modal-body">
                            <label for="bulanTifoid">Bulan</label>
                            <select id="bulanTifoid" name="bulan" class="form-select mb-3">
                                <option value="1">Januari</option>
                                <option value="2">Februari</option>
                                <option value="3">Maret</option>
                                <option value="4">April</option>
                                <option value="5">Mei</option>
                                <option value="6">Juni</option>
                                <option value="7">Juli</option>
                                <option value="8">Agustus</option>
                                <option value="9">September</option>
                                <option value="10">Oktober</option>
                                <option value="11">November</option>
                                <option value="12">Desember</option>
                            </select>

                            <label for="tahunTifoid">Tahun</label>
                            <select id="tahunTifoid" name="tahun" class="form-control mb-3" required>
                                @for ($i = 2020; $i <= date('Y'); $i++)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal for Surveilans Terpadu Penyakit Berbasis Puskesmas -->
        <div class="modal fade" id="modalSTP" tabindex="-1" aria-labelledby="modalSTPLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalSTPLabel">Laporan Surveilans Terpadu Penyakit Berbasis Puskesmas
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('report.stp') }}" method="GET">
                        <div class="modal-body">
                            <label for="bulanSTP">Bulan</label>
                            <select id="bulanSTP" name="bulan" class="form-select mb-3">
                                <option value="1">Januari</option>
                                <option value="2">Februari</option>
                                <option value="3">Maret</option>
                                <option value="4">April</option>
                                <option value="5">Mei</option>
                                <option value="6">Juni</option>
                                <option value="7">Juli</option>
                                <option value="8">Agustus</option>
                                <option value="9">September</option>
                                <option value="10">Oktober</option>
                                <option value="11">November</option>
                                <option value="12">Desember</option>
                            </select>

                            <label for="tahunSTP">Tahun</label>
                            <select id="tahunSTP" name="tahun" class="form-control mb-3" required>
                                @for ($i = 2020; $i <= date('Y'); $i++)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal for Rekap Penyakit Tidak Menular -->
        <div class="modal fade" id="modalPTM" tabindex="-1" aria-labelledby="modalPTMLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalPTMLabel">Rekap Penyakit Tidak Menular</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('report.ptm') }}" method="GET">
                        <div class="modal-body">
                            <label for="bulanPTM">Bulan</label>
                            <select id="bulanPTM" name="bulan" class="form-select mb-3">
                                <option value="1">Januari</option>
                                <option value="2">Februari</option>
                                <option value="3">Maret</option>
                                <option value="4">April</option>
                                <option value="5">Mei</option>
                                <option value="6">Juni</option>
                                <option value="7">Juli</option>
                                <option value="8">Agustus</option>
                                <option value="9">September</option>
                                <option value="10">Oktober</option>
                                <option value="11">November</option>
                                <option value="12">Desember</option>
                            </select>

                            <label for="tahunPTM">Tahun</label>
                            <select id="tahunPTM" name="tahun" class="form-control mb-3" required>
                                @for ($i = 2020; $i <= date('Y'); $i++)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal for AFP -->
        <div class="modal fade" id="modalAFP" tabindex="-1" aria-labelledby="modalAFPLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalAFPLabel">Laporan Penderita AFP</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('report.afp') }}" method="GET">
                        <div class="modal-body">
                            <label for="bulanAFP">Bulan</label>
                            <select id="bulanAFP" name="bulan" class="form-select mb-3">
                                <option value="1">Januari</option>
                                <option value="2">Februari</option>
                                <option value="3">Maret</option>
                                <option value="4">April</option>
                                <option value="5">Mei</option>
                                <option value="6">Juni</option>
                                <option value="7">Juli</option>
                                <option value="8">Agustus</option>
                                <option value="9">September</option>
                                <option value="10">Oktober</option>
                                <option value="11">November</option>
                                <option value="12">Desember</option>
                            </select>

                            <label for="tahunAFP">Tahun</label>
                            <select id="tahunAFP" name="tahun" class="form-control mb-3" required>
                                @for ($i = 2020; $i <= date('Y'); $i++)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal for Difteri -->
        <div class="modal fade" id="modalDifteri" tabindex="-1" aria-labelledby="modalDifteriLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalDifteriLabel">Laporan Surveilans Integrasi Difteri</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('report.difteri') }}" method="GET">
                        <div class="modal-body">
                            <label for="bulanDifteri">Bulan</label>
                            <select id="bulanDifteri" name="bulan" class="form-select mb-3">
                                <option value="1">Januari</option>
                                <option value="2">Februari</option>
                                <option value="3">Maret</option>
                                <option value="4">April</option>
                                <option value="5">Mei</option>
                                <option value="6">Juni</option>
                                <option value="7">Juli</option>
                                <option value="8">Agustus</option>
                                <option value="9">September</option>
                                <option value="10">Oktober</option>
                                <option value="11">November</option>
                                <option value="12">Desember</option>
                            </select>

                            <label for="tahunDifteri">Tahun</label>
                            <select id="tahunDifteri" name="tahun" class="form-control mb-3" required>
                                @for ($i = 2020; $i <= date('Y'); $i++)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal for Kasus Campak -->
        <div class="modal fade" id="modalC1" tabindex="-1" aria-labelledby="modalC1Label" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalC1Label">Laporan Kasus Campak</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <form action="{{ route('report.C1') }}" method="GET">
                        <div class="modal-body">
                            <label for="bulanC1">Bulan</label>
                            <select id="bulanC1" name="bulan" class="form-select mb-3">
                                <option value="1">Januari</option>
                                <option value="2">Februari</option>
                                <option value="3">Maret</option>
                                <option value="4">April</option>
                                <option value="5">Mei</option>
                                <option value="6">Juni</option>
                                <option value="7">Juli</option>
                                <option value="8">Agustus</option>
                                <option value="9">September</option>
                                <option value="10">Oktober</option>
                                <option value="11">November</option>
                                <option value="12">Desember</option>
                            </select>

                            <label for="tahunC1">Tahun</label>
                            <select id="tahunC1" name="tahun" class="form-control mb-3" required>
                                @for ($i = 2020; $i <= date('Y'); $i++)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal for SKDR -->
        <div class="modal fade" id="modalSKDR" tabindex="-1" aria-labelledby="modalSKDRLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalSKDRLabel">Laporan SKDR</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <form action="{{ route('report.skdr') }}" method="GET">
                        <div class="modal-body">
                            <label for="bulanSKDR">Bulan</label>
                            <select id="bulanSKDR" name="bulan" class="form-select mb-3">
                                <option value="1">Januari</option>
                                <option value="2">Februari</option>
                                <option value="3">Maret</option>
                                <option value="4">April</option>
                                <option value="5">Mei</option>
                                <option value="6">Juni</option>
                                <option value="7">Juli</option>
                                <option value="8">Agustus</option>
                                <option value="9">September</option>
                                <option value="10">Oktober</option>
                                <option value="11">November</option>
                                <option value="12">Desember</option>
                            </select>

                            <label for="tahunSKDR">Tahun</label>
                            <select id="tahunSKDR" name="tahun" class="form-control mb-3" required>
                                @for ($i = 2020; $i <= date('Y'); $i++)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    </div>
@endsection

@section('script')

@endsection
=======
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
        @if ($routeName === 'report.index')
            <h4 class="mb-3">Laporan Poli Umum</h4>
        @elseif($routeName === 'report.index.gigi')
            <h4 class="mb-3">Laporan Poli Gigi</h4>
        @else
            <h4 class="mb-3">UGD</h4>
        @endif
        {{-- @if ($routeName === 'report.index') --}}
            <div class="row">
                <!-- Kolom 1 -->
                <div class="col-md-4 mb-3">
                    <!-- Button triggers modals -->
                    <button class="btn btn-danger btn-block w-100 mb-2" data-bs-toggle="modal"
                        data-bs-target="#modalRekapKunjungan">Rekap Kunjungan</button>
                    <button class="btn btn-dark btn-block w-100 mb-2" data-bs-toggle="modal"
                        data-bs-target="#modalLaporanKasus">Laporan Berdasarkan Kasus</button>
                    <button class="btn btn-danger btn-block w-100 mb-2" data-bs-toggle="modal"
                        data-bs-target="#modalPasienProduktif">Pasien Produktif Baru (15-59THN)</button>
                    <button class="btn btn-info btn-block w-100 mb-2" data-bs-toggle="modal"
                        data-bs-target="#modalISPA">ISPA Tahunan</button>
                    <button class="btn btn-warning btn-block w-100 mb-2" data-bs-toggle="modal"
                        data-bs-target="#modalRujukanTerbanyak">Rekap Rujukan Terbanyak</button>
                    <button class="btn btn-warning btn-block w-100 mb-2" data-bs-toggle="modal"
                        data-bs-target="#modalRujukanTerbanyakRS">Rekap Rujukan Terbanyak RS</button>
                </div>



                <!-- Kolom 2 -->
                <div class="col-md-4 mb-3">
                    <a href="javascript:void(0)" class="btn btn-primary btn-block w-100 mb-2" data-bs-toggle="modal"
                        data-bs-target="#modalTifoid">Laporan Penyakit Tifoid</a>
                    <a href="javascript:void(0)" class="btn btn-primary btn-block w-100 mb-2" data-bs-toggle="modal"
                        data-bs-target="#modalSTP">Laporan Surveilans Terpadu Penyakit Berbasis Puskesmas</a>
                    <a href="javascript:void(0)" class="btn btn-success btn-block w-100 mb-2" data-bs-toggle="modal"
                        data-bs-target="#modalPTM">Rekap Penyakit Tidak Menular</a>
                    <a href="javascript:void(0)" class="btn btn-danger btn-block w-100 mb-2" data-bs-toggle="modal"
                        data-bs-target="#modalAFP">Laporan Penderita AFP</a>
                    <a href="javascript:void(0)" class="btn btn-dark btn-block w-100 mb-2" data-bs-toggle="modal"
                        data-bs-target="#modalDifteri">Laporan Surveilans Integrasi Difteri</a>
                    <a href="javascript:void(0)" class="btn btn-info btn-block w-100 mb-2" data-bs-toggle="modal"
                        data-bs-target="#modalC1">Laporan Kasus Campak</a>
                    <a href="javascript:void(0)" class="btn btn-warning btn-block w-100 mb-2" data-bs-toggle="modal"
                        data-bs-target="#modalSKDR">Laporan SKDR</a>


                </div>

                <!-- Kolom 3 -->
                <div class="col-md-4 mb-3">
                    <a class="btn btn-success btn-block w-100 mb-2" data-bs-toggle="modal"
                        data-bs-target="#modalFormulir11">Rekap Pesakitan Formulir 11</a>
                    <button class="btn btn-danger btn-block w-100 mb-2" data-bs-toggle="modal"
                        data-bs-target="#modalKunjunganUmur">Rekap Kunjungan Umur</button>
                    <button class="btn btn-info btn-block w-100 mb-2" data-bs-toggle="modal"
                        data-bs-target="#modalKunjunganRawatJalan">Kunjungan Rawat Jalan</button>
                    <a class="btn btn-danger btn-block w-100 mb-2" data-bs-toggle="modal" data-bs-target="#modalLKT">Rekap
                        Tahunan Penyakit Terbanyak 10</a>
                    <a class="btn btn-dark btn-block w-100 mb-2" data-bs-toggle="modal" data-bs-target="#modalLBKT">Rekap
                        Bulanan Kasus Terbanyak Formulir 14</a>
                    <button class="btn btn-danger btn-block w-100 mb-2" data-bs-toggle="modal"
                        data-bs-target="#modalKunjunganSehat">Kunjungan Sehat</button>
                    <button class="btn btn-info btn-block w-100 mb-2" data-bs-toggle="modal"
                        data-bs-target="#modalTELINGA">TELINGA Tahunan</button>
                    <button class="btn btn-danger btn-block w-100 mb-2" data-bs-toggle="modal"
                        data-bs-target="#modalDiare">Laporan Penyakit/DIARE</button>
                </div>
            </div>
        {{-- @elseif($routeName === 'report.index.gigi') --}}
            <div class="row">
                <div class="col-md-6 mb-3">
                    <button type="button" class="btn btn-primary btn-block w-100 mb-2" data-bs-toggle="modal"
                        data-bs-target="#modalLKG">
                        Laporan Kegiatan Pelayanan Kesehatan Gigi dan Mulut
                    </button>
                </div>

                <div class="col-md-6 mb-3">
                    <button type="button" class="btn btn-success btn-block w-100 mb-2" data-bs-toggle="modal"
                        data-bs-target="#modalLRKG">
                        Laporan Bulanan Kesakitan Gigi dan Mulut
                    </button>
                </div>
            </div>
        {{-- @else --}}
            <div class="row">
                <!-- Kolom 1 -->
                <div class="col-md-6 mb-3">
                    <button type="button" class="btn btn-primary btn-block w-100 mb-2" data-bs-toggle="modal"
                        data-bs-target="#modalURT">
                        Rekap Layanan UGD
                    </button>
                </div>

                <div class="col-md-6 mb-3">
                    <button type="button" class="btn btn-success btn-block w-100 mb-2" data-bs-toggle="modal"
                        data-bs-target="#modalRJP">
                        Rekap Tindakan UGD
                    </button>
                </div>
            </div>
        {{-- @endif --}}
        <div class="modal fade" id="modalURT" tabindex="-1" aria-labelledby="modalURTLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalURTLabel">Filter Rekap Layanan UGD</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('report.urt') }}" method="GET" target="_blank">
                        <div class="modal-body">
                            <label for="bulanURT" class="form-label">Bulan</label>
                            <select id="bulanURT" name="bulan" class="form-control mb-3">
                                <option value="01">Januari</option>
                                <option value="02">Februari</option>
                                <option value="03">Maret</option>
                                <option value="04">April</option>
                                <option value="05">Mei</option>
                                <option value="06">Juni</option>
                                <option value="07">Juli</option>
                                <option value="08">Agustus</option>
                                <option value="09">September</option>
                                <option value="10">Oktober</option>
                                <option value="11">November</option>
                                <option value="12">Desember</option>
                            </select>

                            <label for="tahunURT" class="form-label">Tahun</label>
                            <select id="tahunURT" name="tahun" class="form-control mb-3">
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

        <!-- Modal untuk Rekap Tindakan UGD -->
        <div class="modal fade" id="modalRJP" tabindex="-1" aria-labelledby="modalRJPLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalRJPLabel">Filter Rekap Tindakan UGD</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('report.rjp') }}" method="GET" target="_blank">
                        <div class="modal-body">
                            <label for="bulanRJP" class="form-label">Bulan</label>
                            <select id="bulanRJP" name="bulan" class="form-control mb-3">
                                <option value="01">Januari</option>
                                <option value="02">Februari</option>
                                <option value="03">Maret</option>
                                <option value="04">April</option>
                                <option value="05">Mei</option>
                                <option value="06">Juni</option>
                                <option value="07">Juli</option>
                                <option value="08">Agustus</option>
                                <option value="09">September</option>
                                <option value="10">Oktober</option>
                                <option value="11">November</option>
                                <option value="12">Desember</option>
                            </select>

                            <label for="tahunRJP" class="form-label">Tahun</label>
                            <select id="tahunRJP" name="tahun" class="form-control mb-3">
                                @for ($year = 2020; $year <= now()->year; $year++)
                                    <option value="{{ $year }}">{{ $year }}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-success">Filter</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- Modal untuk Laporan Kegiatan Pelayanan Kesehatan Gigi dan Mulut -->
          <div class="modal fade" id="modalLKG" tabindex="-1" aria-labelledby="modalLKGLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalLKGLabel">Filter Laporan Kegiatan Pelayanan Kesehatan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('report.lkg') }}" method="GET" target="_blank">
                        <div class="modal-body">
                            <label for="bulanRJP" class="form-label">Bulan</label>
                            <select id="bulanRJP" name="bulan" class="form-control mb-3">
                                <option value="01">Januari</option>
                                <option value="02">Februari</option>
                                <option value="03">Maret</option>
                                <option value="04">April</option>
                                <option value="05">Mei</option>
                                <option value="06">Juni</option>
                                <option value="07">Juli</option>
                                <option value="08">Agustus</option>
                                <option value="09">September</option>
                                <option value="10">Oktober</option>
                                <option value="11">November</option>
                                <option value="12">Desember</option>
                            </select>
                            <label for="tahunLKG" class="form-label">Tahun</label>
                            <select id="tahunLKG" name="tahun" class="form-control mb-3">
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
        <!-- Modal untuk Laporan Bulanan Kesakitan Gigi dan Mulut -->
        <div class="modal fade" id="modalLRKG" tabindex="-1" aria-labelledby="modalLRKGLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalLRKGLabel">Filter Laporan Bulanan Kesakitan Gigi dan Mulut</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('report.lrkg') }}" method="GET" target="_blank">
                        <div class="modal-body">
                            <label for="bulanLRKG" class="form-label">Bulan</label>
                            <select id="bulanLRKG" name="bulan" class="form-control mb-3">
                                <option value="01">Januari</option>
                                <option value="02">Februari</option>
                                <option value="03">Maret</option>
                                <option value="04">April</option>
                                <option value="05">Mei</option>
                                <option value="06">Juni</option>
                                <option value="07">Juli</option>
                                <option value="08">Agustus</option>
                                <option value="09">September</option>
                                <option value="10">Oktober</option>
                                <option value="11">November</option>
                                <option value="12">Desember</option>
                            </select>

                            <label for="tahunLRKG" class="form-label">Tahun</label>
                            <select id="tahunLRKG" name="tahun" class="form-control mb-3">
                                @for ($year = 2020; $year <= now()->year; $year++)
                                    <option value="{{ $year }}">{{ $year }}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-success">Filter</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal fade" id="modalTELINGA" tabindex="-1" aria-labelledby="modalTELINGALabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalTELINGALabel">TELINGA Tahunan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="" method="GET">
                        <div class="modal-body">
                            <label for="tahunTELINGA">Tahun</label>
                            <select id="tahunTELINGA" name="tahun" class="form-control mb-3">
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

        <!-- Laporan Penyakit/DIARE Modal -->
        <div class="modal fade" id="modalDiare" tabindex="-1" aria-labelledby="modalDiareLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalDiareLabel">Laporan Penyakit/DIARE</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('report.poli.diare') }}" method="GET">
                        <div class="modal-body">
                            <label for="bulanDiare">Bulan</label>
                            <select id="bulanRujukanTerbanyak" name="bulan" class="form-select mb-3">
                                <option value="1">Januari</option>
                                <option value="2">Februari</option>
                                <option value="3">Maret</option>
                                <option value="4">April</option>
                                <option value="5">Mei</option>
                                <option value="6">Juni</option>
                                <option value="7">Juli</option>
                                <option value="8">Agustus</option>
                                <option value="9">September</option>
                                <option value="10">Oktober</option>
                                <option value="11">November</option>
                                <option value="12">Desember</option>
                            </select>

                            <label for="tahunDiare">Tahun</label>
                            <select id="tahunTELINGA" name="tahun" class="form-control mb-3">
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
        <!-- Rekap Tahunan Penyakit Terbanyak 10 -->
        <div class="modal fade" id="modalLKT" tabindex="-1" aria-labelledby="modalLKTLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalLKTLabel">Rekap Tahunan Penyakit Terbanyak 10</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('report.lkt') }}" method="GET">
                        <div class="modal-body">
                            <label for="bulanLBKT">Bulan</label>
                            <select id="bulanRujukanTerbanyak" name="bulan" class="form-select mb-3">
                                @foreach ([
                                    1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
                                    5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
                                    9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
                                ] as $key => $month)
                                    <option value="{{ $key }}">{{ $month }}</option>
                                @endforeach
                            </select>
        
                            <label for="tahunLKT">Tahun</label>
                            <select id="tahunTELINGA" name="tahun" class="form-control mb-3">
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
        

        <!-- Rekap Bulanan Kasus Terbanyak Formulir 14 -->
        <div class="modal fade" id="modalLBKT" tabindex="-1" aria-labelledby="modalLBKTLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalLBKTLabel">Rekap Bulanan Kasus Terbanyak Formulir 14</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('report.lbkt') }}" method="GET">
                        <div class="modal-body">
                            <label for="bulanLBKT">Bulan</label>
                            <select id="bulanRujukanTerbanyak" name="bulan" class="form-select mb-3">
                                <option value="1">Januari</option>
                                <option value="2">Februari</option>
                                <option value="3">Maret</option>
                                <option value="4">April</option>
                                <option value="5">Mei</option>
                                <option value="6">Juni</option>
                                <option value="7">Juli</option>
                                <option value="8">Agustus</option>
                                <option value="9">September</option>
                                <option value="10">Oktober</option>
                                <option value="11">November</option>
                                <option value="12">Desember</option>
                            </select>

                            <label for="tahunLBKT">Tahun</label>
                            <select id="tahunLBKT" name="tahun" class="form-control mb-3">
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

        <!-- Kunjungan Sehat -->
        <div class="modal fade" id="modalKunjunganSehat" tabindex="-1" aria-labelledby="modalKunjunganSehatLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalKunjunganSehatLabel">Kunjungan Sehat</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="" method="GET">
                        <div class="modal-body">
                            <label for="bulanKunjunganSehat">Bulan</label>
                            <select id="bulanRujukanTerbanyak" name="bulan" class="form-select mb-3">
                                <option value="1">Januari</option>
                                <option value="2">Februari</option>
                                <option value="3">Maret</option>
                                <option value="4">April</option>
                                <option value="5">Mei</option>
                                <option value="6">Juni</option>
                                <option value="7">Juli</option>
                                <option value="8">Agustus</option>
                                <option value="9">September</option>
                                <option value="10">Oktober</option>
                                <option value="11">November</option>
                                <option value="12">Desember</option>
                            </select>

                            <label for="tahunKunjunganSehat">Tahun</label>
                            <select id="tahunKunjunganSehat" name="tahun" class="form-control mb-3">
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
        <!-- Rekap Pesakitan Formulir 11 -->
        <div class="modal fade" id="modalFormulir11" tabindex="-1" aria-labelledby="modalFormulir11Label"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalFormulir11Label">Rekap Pesakitan Formulir 11</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('report.formulir11') }}" method="GET">
                        <div class="modal-body">
                            <label for="bulanFormulir11">Bulan</label>
                            <select id="bulanRujukanTerbanyak" name="bulan" class="form-select mb-3">
                                <option value="1">Januari</option>
                                <option value="2">Februari</option>
                                <option value="3">Maret</option>
                                <option value="4">April</option>
                                <option value="5">Mei</option>
                                <option value="6">Juni</option>
                                <option value="7">Juli</option>
                                <option value="8">Agustus</option>
                                <option value="9">September</option>
                                <option value="10">Oktober</option>
                                <option value="11">November</option>
                                <option value="12">Desember</option>
                            </select>

                            <label for="tahunFormulir11">Tahun</label>
                            <select id="tahunFormulir11" name="tahun" class="form-control mb-3">
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

        <!-- Rekap Kunjungan Umur -->
        <div class="modal fade" id="modalKunjunganUmur" tabindex="-1" aria-labelledby="modalKunjunganUmurLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalKunjunganUmurLabel">Rekap Kunjungan Umur</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="" method="GET">
                        <div class="modal-body">
                            <label for="bulanKunjunganUmur">Bulan</label>
                            <select id="bulanRujukanTerbanyak" name="bulan" class="form-select mb-3">
                                <option value="1">Januari</option>
                                <option value="2">Februari</option>
                                <option value="3">Maret</option>
                                <option value="4">April</option>
                                <option value="5">Mei</option>
                                <option value="6">Juni</option>
                                <option value="7">Juli</option>
                                <option value="8">Agustus</option>
                                <option value="9">September</option>
                                <option value="10">Oktober</option>
                                <option value="11">November</option>
                                <option value="12">Desember</option>
                            </select>

                            <label for="tahunKunjunganUmur">Tahun</label>
                            <select id="tahunKunjunganUmur" name="tahun" class="form-control mb-3">
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

        <!-- Tambahkan modal lainnya untuk setiap tombol -->
        <!-- Contoh untuk Kunjungan Rawat Jalan -->
        <div class="modal fade" id="modalKunjunganRawatJalan" tabindex="-1"
            aria-labelledby="modalKunjunganRawatJalanLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalKunjunganRawatJalanLabel">Kunjungan Rawat Jalan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('report.lkrj') }}" method="GET">
                        <div class="modal-body">
                            <label for="bulanKunjunganRawatJalan">Bulan</label>
                            <select id="bulanRujukanTerbanyak" name="bulan" class="form-select mb-3">
                                <option value="1">Januari</option>
                                <option value="2">Februari</option>
                                <option value="3">Maret</option>
                                <option value="4">April</option>
                                <option value="5">Mei</option>
                                <option value="6">Juni</option>
                                <option value="7">Juli</option>
                                <option value="8">Agustus</option>
                                <option value="9">September</option>
                                <option value="10">Oktober</option>
                                <option value="11">November</option>
                                <option value="12">Desember</option>
                            </select>

                            <label for="tahunKunjunganRawatJalan">Tahun</label>
                            <select id="tahunKunjunganRawatJalan" name="tahun" class="form-control mb-3">
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
        <!-- Modal Rekap Kunjungan -->
        <div class="modal fade" id="modalRekapKunjungan" tabindex="-1" aria-labelledby="modalRekapKunjunganLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalRekapKunjunganLabel">Rekap Kunjungan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <label for="bulanRujukanTerbanyak">Bulan</label>
                        <select id="bulanRujukanTerbanyak" name="bulan" class="form-select mb-3">
                            <option value="1">Januari</option>
                            <option value="2">Februari</option>
                            <option value="3">Maret</option>
                            <option value="4">April</option>
                            <option value="5">Mei</option>
                            <option value="6">Juni</option>
                            <option value="7">Juli</option>
                            <option value="8">Agustus</option>
                            <option value="9">September</option>
                            <option value="10">Oktober</option>
                            <option value="11">November</option>
                            <option value="12">Desember</option>
                        </select>
                        <label for="tahunRujukanTerbanyak">Tahun</label>
                        <select id="tahunRujukanTerbanyak" class="form-control" name="tahun" required>
                            @for ($i = 2020; $i <= date('Y'); $i++)
                                <option value="{{ $i }}">{{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        {{-- <form action="{{ route('report.rekapKunjungan') }}" method="GET"> --}}
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        {{-- </form> --}}
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Laporan Berdasarkan Kasus -->
        <div class="modal fade" id="modalLaporanKasus" tabindex="-1" aria-labelledby="modalLaporanKasusLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalLaporanKasusLabel">Laporan Berdasarkan Kasus</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <label for="bulanRujukanTerbanyak">Bulan</label>
                        <select id="bulanRujukanTerbanyak" name="bulan" class="form-select mb-3">
                            <option value="1">Januari</option>
                            <option value="2">Februari</option>
                            <option value="3">Maret</option>
                            <option value="4">April</option>
                            <option value="5">Mei</option>
                            <option value="6">Juni</option>
                            <option value="7">Juli</option>
                            <option value="8">Agustus</option>
                            <option value="9">September</option>
                            <option value="10">Oktober</option>
                            <option value="11">November</option>
                            <option value="12">Desember</option>
                        </select>
                        <label for="tahunRujukanTerbanyak">Tahun</label>
                        <select id="tahunRujukanTerbanyak" class="form-control" name="tahun" required>
                            @for ($i = 2020; $i <= date('Y'); $i++)
                                <option value="{{ $i }}">{{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        {{-- <form action="{{ route('report.laporanKasus') }}" method="GET"> --}}
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        {{-- </form> --}}
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Pasien Produktif Baru (15-59THN) -->
        <div class="modal fade" id="modalPasienProduktif" tabindex="-1" aria-labelledby="modalPasienProduktifLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalPasienProduktifLabel">Pasien Produktif Baru (15-59THN)</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('report.up') }}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <label for="bulanRujukanTerbanyak">Bulan</label>
                            <select id="bulanRujukanTerbanyak" name="bulan" class="form-select mb-3">
                                <option value="1">Januari</option>
                                <option value="2">Februari</option>
                                <option value="3">Maret</option>
                                <option value="4">April</option>
                                <option value="5">Mei</option>
                                <option value="6">Juni</option>
                                <option value="7">Juli</option>
                                <option value="8">Agustus</option>
                                <option value="9">September</option>
                                <option value="10">Oktober</option>
                                <option value="11">November</option>
                                <option value="12">Desember</option>
                            </select>
                            <label for="tahunRujukanTerbanyak">Tahun</label>
                            <select id="tahunRujukanTerbanyak" class="form-control" name="tahun" required>
                                @for ($i = 2020; $i <= date('Y'); $i++)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal ISPA Tahunan -->
        <div class="modal fade" id="modalISPA" tabindex="-1" aria-labelledby="modalISPALabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalISPALabel">ISPA Tahunan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <label for="bulanRujukanTerbanyak">Bulan</label>
                        <select id="bulanRujukanTerbanyak" name="bulan" class="form-select mb-3">
                            <option value="1">Januari</option>
                            <option value="2">Februari</option>
                            <option value="3">Maret</option>
                            <option value="4">April</option>
                            <option value="5">Mei</option>
                            <option value="6">Juni</option>
                            <option value="7">Juli</option>
                            <option value="8">Agustus</option>
                            <option value="9">September</option>
                            <option value="10">Oktober</option>
                            <option value="11">November</option>
                            <option value="12">Desember</option>
                        </select>
                        <label for="tahunRujukanTerbanyak">Tahun</label>
                        <select id="tahunRujukanTerbanyak" class="form-control" name="tahun" required>
                            @for ($i = 2020; $i <= date('Y'); $i++)
                                <option value="{{ $i }}">{{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        {{-- <form action="{{ route('report.ispa') }}" method="GET"> --}}
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        {{-- </form> --}}
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Rekap Rujukan Terbanyak -->
        <div class="modal fade" id="modalRujukanTerbanyak" tabindex="-1" aria-labelledby="modalRujukanTerbanyakLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalRujukanTerbanyakLabel">Rekap Rujukan Terbanyak</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('report.rrt') }}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <label for="bulanRujukanTerbanyak">Bulan</label>
                            <select id="bulanRujukanTerbanyak" name="bulan" class="form-select mb-3">
                                <option value="1">Januari</option>
                                <option value="2">Februari</option>
                                <option value="3">Maret</option>
                                <option value="4">April</option>
                                <option value="5">Mei</option>
                                <option value="6">Juni</option>
                                <option value="7">Juli</option>
                                <option value="8">Agustus</option>
                                <option value="9">September</option>
                                <option value="10">Oktober</option>
                                <option value="11">November</option>
                                <option value="12">Desember</option>
                            </select>
                            <label for="tahunRujukanTerbanyak">Tahun</label>
                            <select id="tahunRujukanTerbanyak" class="form-control" name="tahun" required>
                                @for ($i = 2020; $i <= date('Y'); $i++)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
        <div class="modal fade" id="modalRujukanTerbanyakRS" tabindex="-1" aria-labelledby="modalRujukanTerbanyakLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalRujukanTerbanyakLabel">Rekap Rujukan Terbanyak</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('report.lr') }}" method="GET">
                        @csrf
                        <div class="modal-body">
                            <label for="bulanRujukanTerbanyak">Bulan</label>
                            <select id="bulanRujukanTerbanyak" name="bulan" class="form-select mb-3">
                                <option value="1">Januari</option>
                                <option value="2">Februari</option>
                                <option value="3">Maret</option>
                                <option value="4">April</option>
                                <option value="5">Mei</option>
                                <option value="6">Juni</option>
                                <option value="7">Juli</option>
                                <option value="8">Agustus</option>
                                <option value="9">September</option>
                                <option value="10">Oktober</option>
                                <option value="11">November</option>
                                <option value="12">Desember</option>
                            </select>
                            <label for="tahunRujukanTerbanyak">Tahun</label>
                            <select id="tahunRujukanTerbanyak" class="form-control" name="tahun" required>
                                @for ($i = 2020; $i <= date('Y'); $i++)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
        <!-- Modal for Tifoid Report -->
        <div class="modal fade" id="modalTifoid" tabindex="-1" aria-labelledby="modalTifoidLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalTifoidLabel">Laporan Penyakit Tifoid</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('report.tifoid') }}" method="GET">
                        @csrf
                        <div class="modal-body">
                            <label for="bulanTifoid">Bulan</label>
                            <select id="bulanTifoid" name="bulan" class="form-select mb-3">
                                <option value="1">Januari</option>
                                <option value="2">Februari</option>
                                <option value="3">Maret</option>
                                <option value="4">April</option>
                                <option value="5">Mei</option>
                                <option value="6">Juni</option>
                                <option value="7">Juli</option>
                                <option value="8">Agustus</option>
                                <option value="9">September</option>
                                <option value="10">Oktober</option>
                                <option value="11">November</option>
                                <option value="12">Desember</option>
                            </select>

                            <label for="tahunTifoid">Tahun</label>
                            <select id="tahunTifoid" name="tahun" class="form-control mb-3" required>
                                @for ($i = 2020; $i <= date('Y'); $i++)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal for Surveilans Terpadu Penyakit Berbasis Puskesmas -->
        <div class="modal fade" id="modalSTP" tabindex="-1" aria-labelledby="modalSTPLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalSTPLabel">Laporan Surveilans Terpadu Penyakit Berbasis Puskesmas
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('report.stp') }}" method="GET">
                        <div class="modal-body">
                            <label for="bulanSTP">Bulan</label>
                            <select id="bulanSTP" name="bulan" class="form-select mb-3">
                                <option value="1">Januari</option>
                                <option value="2">Februari</option>
                                <option value="3">Maret</option>
                                <option value="4">April</option>
                                <option value="5">Mei</option>
                                <option value="6">Juni</option>
                                <option value="7">Juli</option>
                                <option value="8">Agustus</option>
                                <option value="9">September</option>
                                <option value="10">Oktober</option>
                                <option value="11">November</option>
                                <option value="12">Desember</option>
                            </select>

                            <label for="tahunSTP">Tahun</label>
                            <select id="tahunSTP" name="tahun" class="form-control mb-3" required>
                                @for ($i = 2020; $i <= date('Y'); $i++)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal for Rekap Penyakit Tidak Menular -->
        <div class="modal fade" id="modalPTM" tabindex="-1" aria-labelledby="modalPTMLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalPTMLabel">Rekap Penyakit Tidak Menular</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('report.ptm') }}" method="GET">
                        <div class="modal-body">
                            <label for="bulanPTM">Bulan</label>
                            <select id="bulanPTM" name="bulan" class="form-select mb-3">
                                <option value="1">Januari</option>
                                <option value="2">Februari</option>
                                <option value="3">Maret</option>
                                <option value="4">April</option>
                                <option value="5">Mei</option>
                                <option value="6">Juni</option>
                                <option value="7">Juli</option>
                                <option value="8">Agustus</option>
                                <option value="9">September</option>
                                <option value="10">Oktober</option>
                                <option value="11">November</option>
                                <option value="12">Desember</option>
                            </select>

                            <label for="tahunPTM">Tahun</label>
                            <select id="tahunPTM" name="tahun" class="form-control mb-3" required>
                                @for ($i = 2020; $i <= date('Y'); $i++)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal for AFP -->
        <div class="modal fade" id="modalAFP" tabindex="-1" aria-labelledby="modalAFPLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalAFPLabel">Laporan Penderita AFP</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('report.afp') }}" method="GET">
                        <div class="modal-body">
                            <label for="bulanAFP">Bulan</label>
                            <select id="bulanAFP" name="bulan" class="form-select mb-3">
                                <option value="1">Januari</option>
                                <option value="2">Februari</option>
                                <option value="3">Maret</option>
                                <option value="4">April</option>
                                <option value="5">Mei</option>
                                <option value="6">Juni</option>
                                <option value="7">Juli</option>
                                <option value="8">Agustus</option>
                                <option value="9">September</option>
                                <option value="10">Oktober</option>
                                <option value="11">November</option>
                                <option value="12">Desember</option>
                            </select>

                            <label for="tahunAFP">Tahun</label>
                            <select id="tahunAFP" name="tahun" class="form-control mb-3" required>
                                @for ($i = 2020; $i <= date('Y'); $i++)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal for Difteri -->
        <div class="modal fade" id="modalDifteri" tabindex="-1" aria-labelledby="modalDifteriLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalDifteriLabel">Laporan Surveilans Integrasi Difteri</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('report.difteri') }}" method="GET">
                        <div class="modal-body">
                            <label for="bulanDifteri">Bulan</label>
                            <select id="bulanDifteri" name="bulan" class="form-select mb-3">
                                <option value="1">Januari</option>
                                <option value="2">Februari</option>
                                <option value="3">Maret</option>
                                <option value="4">April</option>
                                <option value="5">Mei</option>
                                <option value="6">Juni</option>
                                <option value="7">Juli</option>
                                <option value="8">Agustus</option>
                                <option value="9">September</option>
                                <option value="10">Oktober</option>
                                <option value="11">November</option>
                                <option value="12">Desember</option>
                            </select>

                            <label for="tahunDifteri">Tahun</label>
                            <select id="tahunDifteri" name="tahun" class="form-control mb-3" required>
                                @for ($i = 2020; $i <= date('Y'); $i++)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal for Kasus Campak -->
        <div class="modal fade" id="modalC1" tabindex="-1" aria-labelledby="modalC1Label" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalC1Label">Laporan Kasus Campak</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <form action="{{ route('report.C1') }}" method="GET">
                        <div class="modal-body">
                            <label for="bulanC1">Bulan</label>
                            <select id="bulanC1" name="bulan" class="form-select mb-3">
                                <option value="1">Januari</option>
                                <option value="2">Februari</option>
                                <option value="3">Maret</option>
                                <option value="4">April</option>
                                <option value="5">Mei</option>
                                <option value="6">Juni</option>
                                <option value="7">Juli</option>
                                <option value="8">Agustus</option>
                                <option value="9">September</option>
                                <option value="10">Oktober</option>
                                <option value="11">November</option>
                                <option value="12">Desember</option>
                            </select>

                            <label for="tahunC1">Tahun</label>
                            <select id="tahunC1" name="tahun" class="form-control mb-3" required>
                                @for ($i = 2020; $i <= date('Y'); $i++)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal for SKDR -->
        <div class="modal fade" id="modalSKDR" tabindex="-1" aria-labelledby="modalSKDRLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalSKDRLabel">Laporan SKDR</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <form action="{{ route('report.skdr') }}" method="GET">
                        <div class="modal-body">
                            <label for="bulanSKDR">Bulan</label>
                            <select id="bulanSKDR" name="bulan" class="form-select mb-3">
                                <option value="1">Januari</option>
                                <option value="2">Februari</option>
                                <option value="3">Maret</option>
                                <option value="4">April</option>
                                <option value="5">Mei</option>
                                <option value="6">Juni</option>
                                <option value="7">Juli</option>
                                <option value="8">Agustus</option>
                                <option value="9">September</option>
                                <option value="10">Oktober</option>
                                <option value="11">November</option>
                                <option value="12">Desember</option>
                            </select>

                            <label for="tahunSKDR">Tahun</label>
                            <select id="tahunSKDR" name="tahun" class="form-control mb-3" required>
                                @for ($i = 2020; $i <= date('Y'); $i++)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    </div>
@endsection

@section('script')

@endsection
>>>>>>> 9df8fede466960d27744a11e4cb830e2a9437611
