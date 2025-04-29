<<<<<<< HEAD
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LAPORAN HASIL KEGIATAN PELAYANAN KESEHATAN GIGI DAN MULUT

    </title>
    <style>
        body {
            font-family: "Times New Roman", Times, serif;
            font-size: 12px;
        }

        .header {
            text-align: center;
        }

        .header img {
            width: 80px;
            height: auto;
        }

        .header h1,
        .header h2,
        .header p {
            margin: 0;
            line-height: 1.2;
        }

        .table-container {
            margin-top: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table th,
        table td {
            border: 1px solid #000;
            padding: 5px;
            text-align: center;
        }

        table th {
            background-color: #f0f0f0;
        }

        @media print {
            @page {
                size: legal;
                /* Ukuran kertas Letter */
                margin: 20px;
                /* Margin */
            }

            body {
                transform: scale(1);
                /* Skala untuk mengecilkan */
                /* Titik asal transformasi */
            }
        }

        .left-align {
            text-align: left;
        }
    </style>

</head>

<body>
    <div class="header">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <img src="{{ asset('assets/assets/img/logo.png') }}" alt="Logo Left">
            <div>
                <h1>PEMERINTAH KOTA MAKASSAR</h1>
                <h2 style="margin: 0px">DINAS KESEHATAN</h2>
                <h3 style="margin:0px">UPT Puskesmas Tamangapa</h3>
                <p>Jl.Tamangapa Raya No.264 Kode Pos : 90235 Makassar</p>
                <p>Telp.0411-494014 Call Center : 081245193468</p>
                <p>email: Pkmtamangapa@gmail.com https://puskesmastamangapa.or.id</p>
            </div>
            <img src="../assets/assets/img/logo-puskesmas.png" alt="Logo Right">
        </div>
        <hr>
        <h3 style="margin-top: 20px;">LAPORAN HASIL KEGIATAN PELAYANAN KESEHATAN GIGI DAN MULUT

        </h3>
        <p>BULAN {{ strtoupper(\Carbon\Carbon::create()->month($bulan)->translatedFormat('F')) }}
            TAHUN {{ $tahun }}</p>
    </div>

    <div class="table-container">
        <table border="1">
            <thead>
                <tr>
                    <th rowspan="2" style="width: 10%">NO</th>
                    <th rowspan="2">KEGIATAN</th>
                    <th rowspan="2">TARGET</th>
                    <th colspan="2">HASIL</th>
                    <th rowspan="2">JUMLAH</th>
                    <th rowspan="2">%</th>

                </tr>
                <tr>
                    <th>L</th>
                    <th>P</th>
                </tr>
            </thead>
            <tbody>
            <tbody>
                <tr>
                    <td>I</td>
                    <td class="left-align">KUNJUNGAN PUSKESMAS</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>

                </tr>
                <tr>
                    <td>1</td>
                    <td class="left-align">Hari Buka BP. Gigi</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>

                </tr>
                <tr>
                    <td>2</td>
                    <td class="left-align">Jumlah Penduduk di Wilayah Kerja</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>

                </tr>
                <tr>
                    <td>3</td>
                    <td class="left-align">Jml. Kunjungan Baru Rawat Jalan Gigi</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>

                </tr>
                <tr>
                    <td>4</td>
                    <td class="left-align">Jml. Kunjungan Lama Rawat Jalan Gigi</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>

                </tr>
                <tr>
                    <td>5</td>
                    <td class="left-align">Jml. Kunjungan Baru Rawat Jalan Gigi Bumil</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>

                </tr>
                <tr>
                    <td>6</td>
                    <td class="left-align">Jml. Kunjungan Lama Rawat Jalan Gigi Bumil</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>

                </tr>
                <tr>
                    <td>7</td>
                    <td class="left-align">Jml. Kunjungan Baru Rawat Jalan Gigi Apras</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>

                </tr>
                <tr>
                    <td>8</td>
                    <td class="left-align">Jml. Kunjungan Lama Rawat Jalan Gigi Apras</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>

                </tr>
                <tr>
                    <td>9</td>
                    <td class="left-align">Jml. Kunjungan Baru Rawat Jalan Gigi Anak Sekolah</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>

                </tr>
                <tr>
                    <td>10</td>
                    <td class="left-align">Jml. Kunjungan Lama Rawat Jalan Gigi Anak Sekolah</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>

                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>

                </tr>
                <tr>
                    <td>II</td>
                    <td class="left-align">JENIS PENYAKIT DAN KELAINAN GIGI</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                @foreach ($diagnosisData as $index => $diagnosis)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td class="left-align">
                            {{ $diagnosis['name'] }}
                            @isset($diagnosis['code'])
                                ({{ $diagnosis['code'] }})
                            @endisset
                        </td>
                        <td></td>
                        <td>{{ $diagnosis['laki_laki'] ?? 0 }}</td>
                        <td>{{ $diagnosis['perempuan'] ?? 0 }}</td>
                        <td>{{ $diagnosis['total'] ?? 0 }}</td>
                        <td></td>
                    </tr>
                @endforeach

                <tr>
                    <td>III</td>
                    <td class="left-align">TINDAKAN PERAWATAN</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                @foreach ($tindakanGigi as $index=>$tindakanNama)
                @php
                    $filteredTindakan = $tindakan->where('tindakan', $tindakanNama)->where('tipe','poli-gigi');
                    $lakiLakiCount = $filteredTindakan->where('patient.gender', 2)->count();
                    $perempuanCount = $filteredTindakan->where('patient.gender', 1)->count();
                    $total = $lakiLakiCount + $perempuanCount;
                @endphp
    
                <tr>
                    <td>{{ $index+1 }}</td>
                    <td class="left-align">{{ $tindakanNama }}</td>
                    <td></td>
                    <td>{{ $lakiLakiCount }}</td>
                    <td>{{ $perempuanCount }}</td>
                    <td>{{ $total }}</td>
                    <td></td>
                </tr>
            @endforeach
                <tr>

                    <td>IV</td>
                    <td class="left-align">RUJUKAN</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>1</td>
                    <td class="left-align">Rujukan Keatas (Rumah Sakit)</td>
                    <td></td>
                    <td>{{$rujukanL}}</td>
                    <td>{{$rujukanP}}</td>
                    <td>{{$rujukanL+$rujukanP}}</td>
                    <td></td>
                </tr>
                <tr>
                    <td>2</td>
                    <td class="left-align">Rujukan Kebawah</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td></td>
                    <td class="left-align">a. Diterima dari UKGS</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td></td>
                    <td class="left-align">b. Diterima dari UKGM</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td></td>
                    <td class="left-align">c. Diterima dari KIA</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            </tbody>




            </tbody>
        </table>
        <div style="margin-top: 30px;">
            <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 50px;">
                <!-- Bagian Kiri -->
                <div style="text-align: left; width: 40%;">
                    <br><br>
                    <p>Mengetahui,</p>
                    <p>Kepala UPT Puskesmas Tamangapa</p>
                    <br><br><br>
                    <p>dr. Fatimah .M.Kes</p>
                    <p>NIP.198511252011012009</p>
                </div>

                <!-- Bagian Kanan -->
                <div style="text-align: left; width: 40%; padding-left: 50%;">
                    <p>Makassar, <span id="currentDate">{{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</span>
                    </p>
                    <p>Mengetahui,</p>
                    <p>Pengelola,</p>
                    <br><br><br>
                    <p>drg.Sukma</p>
                    <p>NIP. 197602092006042008</p>
                </div>
            </div>
        </div>


    </div>
</body>

</html>
=======
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LAPORAN HASIL KEGIATAN PELAYANAN KESEHATAN GIGI DAN MULUT

    </title>
    <style>
        body {
            font-family: "Times New Roman", Times, serif;
            font-size: 12px;
        }

        .header {
            text-align: center;
        }

        .header img {
            width: 80px;
            height: auto;
        }

        .header h1,
        .header h2,
        .header p {
            margin: 0;
            line-height: 1.2;
        }

        .table-container {
            margin-top: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table th,
        table td {
            border: 1px solid #000;
            padding: 5px;
            text-align: center;
        }

        table th {
            background-color: #f0f0f0;
        }

        @media print {
            @page {
                size: legal;
                /* Ukuran kertas Letter */
                margin: 20px;
                /* Margin */
            }

            body {
                transform: scale(1);
                /* Skala untuk mengecilkan */
                /* Titik asal transformasi */
            }
        }

        .left-align {
            text-align: left;
        }
    </style>

</head>

<body>
    <div class="header">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <img src="{{ asset('assets/assets/img/logo.png') }}" alt="Logo Left">
            <div>
                <h1>PEMERINTAH KOTA MAKASSAR</h1>
                <h2 style="margin: 0px">DINAS KESEHATAN</h2>
                <h3 style="margin:0px">UPT Puskesmas Tamangapa</h3>
                <p>Jl.Tamangapa Raya No.264 Kode Pos : 90235 Makassar</p>
                <p>Telp.0411-494014 Call Center : 081245193468</p>
                <p>email: Pkmtamangapa@gmail.com https://puskesmastamangapa.or.id</p>
            </div>
            <img src="../assets/assets/img/logo-puskesmas.png" alt="Logo Right">
        </div>
        <hr>
        <h3 style="margin-top: 20px;">LAPORAN HASIL KEGIATAN PELAYANAN KESEHATAN GIGI DAN MULUT

        </h3>
        <p>BULAN {{ strtoupper(\Carbon\Carbon::create()->month($bulan)->translatedFormat('F')) }}
            TAHUN {{ $tahun }}</p>
    </div>

    <div class="table-container">
        <table border="1">
            <thead>
                <tr>
                    <th rowspan="2" style="width: 10%">NO</th>
                    <th rowspan="2">KEGIATAN</th>
                    <th rowspan="2">TARGET</th>
                    <th colspan="2">HASIL</th>
                    <th rowspan="2">JUMLAH</th>
                    <th rowspan="2">%</th>

                </tr>
                <tr>
                    <th>L</th>
                    <th>P</th>
                </tr>
            </thead>
            <tbody>
            <tbody>
                <tr>
                    <td>I</td>
                    <td class="left-align">KUNJUNGAN PUSKESMAS</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>

                </tr>
                <tr>
                    <td>1</td>
                    <td class="left-align">Hari Buka BP. Gigi</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>

                </tr>
                <tr>
                    <td>2</td>
                    <td class="left-align">Jumlah Penduduk di Wilayah Kerja</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>

                </tr>
                <tr>
                    <td>3</td>
                    <td class="left-align">Jml. Kunjungan Baru Rawat Jalan Gigi</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>

                </tr>
                <tr>
                    <td>4</td>
                    <td class="left-align">Jml. Kunjungan Lama Rawat Jalan Gigi</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>

                </tr>
                <tr>
                    <td>5</td>
                    <td class="left-align">Jml. Kunjungan Baru Rawat Jalan Gigi Bumil</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>

                </tr>
                <tr>
                    <td>6</td>
                    <td class="left-align">Jml. Kunjungan Lama Rawat Jalan Gigi Bumil</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>

                </tr>
                <tr>
                    <td>7</td>
                    <td class="left-align">Jml. Kunjungan Baru Rawat Jalan Gigi Apras</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>

                </tr>
                <tr>
                    <td>8</td>
                    <td class="left-align">Jml. Kunjungan Lama Rawat Jalan Gigi Apras</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>

                </tr>
                <tr>
                    <td>9</td>
                    <td class="left-align">Jml. Kunjungan Baru Rawat Jalan Gigi Anak Sekolah</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>

                </tr>
                <tr>
                    <td>10</td>
                    <td class="left-align">Jml. Kunjungan Lama Rawat Jalan Gigi Anak Sekolah</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>

                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>

                </tr>
                <tr>
                    <td>II</td>
                    <td class="left-align">JENIS PENYAKIT DAN KELAINAN GIGI</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                @foreach ($diagnosisData as $index => $diagnosis)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td class="left-align">
                            {{ $diagnosis['name'] }}
                            @isset($diagnosis['code'])
                                ({{ $diagnosis['code'] }})
                            @endisset
                        </td>
                        <td></td>
                        <td>{{ $diagnosis['laki_laki'] ?? 0 }}</td>
                        <td>{{ $diagnosis['perempuan'] ?? 0 }}</td>
                        <td>{{ $diagnosis['total'] ?? 0 }}</td>
                        <td></td>
                    </tr>
                @endforeach

                <tr>
                    <td>III</td>
                    <td class="left-align">TINDAKAN PERAWATAN</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                @foreach ($tindakanGigi as $index=>$tindakanNama)
                @php
                    $filteredTindakan = $tindakan->where('tindakan', $tindakanNama)->where('tipe','poli-gigi');
                    $lakiLakiCount = $filteredTindakan->where('patient.gender', 2)->count();
                    $perempuanCount = $filteredTindakan->where('patient.gender', 1)->count();
                    $total = $lakiLakiCount + $perempuanCount;
                @endphp
    
                <tr>
                    <td>{{ $index+1 }}</td>
                    <td class="left-align">{{ $tindakanNama }}</td>
                    <td></td>
                    <td>{{ $lakiLakiCount }}</td>
                    <td>{{ $perempuanCount }}</td>
                    <td>{{ $total }}</td>
                    <td></td>
                </tr>
            @endforeach
                <tr>

                    <td>IV</td>
                    <td class="left-align">RUJUKAN</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>1</td>
                    <td class="left-align">Rujukan Keatas (Rumah Sakit)</td>
                    <td></td>
                    <td>{{$rujukanL}}</td>
                    <td>{{$rujukanP}}</td>
                    <td>{{$rujukanL+$rujukanP}}</td>
                    <td></td>
                </tr>
                <tr>
                    <td>2</td>
                    <td class="left-align">Rujukan Kebawah</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td></td>
                    <td class="left-align">a. Diterima dari UKGS</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td></td>
                    <td class="left-align">b. Diterima dari UKGM</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td></td>
                    <td class="left-align">c. Diterima dari KIA</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            </tbody>




            </tbody>
        </table>
        <div style="margin-top: 30px;">
            <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 50px;">
                <!-- Bagian Kiri -->
                <div style="text-align: left; width: 40%;">
                    <br><br>
                    <p>Mengetahui,</p>
                    <p>Kepala UPT Puskesmas Tamangapa</p>
                    <br><br><br>
                    <p>dr. Fatimah .M.Kes</p>
                    <p>NIP.198511252011012009</p>
                </div>

                <!-- Bagian Kanan -->
                <div style="text-align: left; width: 40%; padding-left: 50%;">
                    <p>Makassar, <span id="currentDate">{{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</span>
                    </p>
                    <p>Mengetahui,</p>
                    <p>Pengelola,</p>
                    <br><br><br>
                    <p>drg.Sukma</p>
                    <p>NIP. 197602092006042008</p>
                </div>
            </div>
        </div>


    </div>
</body>

</html>
>>>>>>> 9df8fede466960d27744a11e4cb830e2a9437611
