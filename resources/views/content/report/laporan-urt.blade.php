<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>REKAPAN JENIS PELAYANAN TINDAKAN BERDASARKAN KARTU ASURANSI DI RUANG TINDAKAN


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
        <h3 style="margin-top: 20px;">REKAPAN JENIS PELAYANAN TINDAKAN BERDASARKAN KARTU ASURANSI DI RUANG TINDAKAN


        </h3>
        <p>BULAN {{ strtoupper(\Carbon\Carbon::create()->month($bulan)->translatedFormat('F')) }}
            TAHUN {{ $tahun }}</p>
    </div>

    <div class="table-container">
        <table border="1">
            <thead>
                <tr>
                    <th rowspan="3" style="width: 10%">NO</th>
                    <th rowspan="3">JENIS PELAYANAN TINDAKAN</th>
                    <th colspan="5">ASURANSI</th>


                </tr>
                <tr>
                    <th rowspan="2">AKSES</th>
                    <th colspan="2">BPJS</th>
                    <th rowspan="2">GRATIS</th>
                    <th rowspan="2">UMUM</th>

                </tr>
                <tr>
                    <th>MANDIRI</th>
                    <th>KIS</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $service => $counts)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td class="left-align">{{ $service }}</td>
                        <td>{{ $counts['askes'] }}</td>
                        <td>{{ $counts['jkn_mandiri'] }}</td>
                        <td>{{ $counts['pbi'] }}</td>
                        <td>{{ $counts['jkd'] }}</td>
                        <td>{{ $counts['umum'] }}</td>
                    </tr>
                @endforeach
                <tr>
                    <td></td>
                    <td class="left-align"><strong>TOTAL</strong></td>
                    <td>{{ array_sum(array_column($data, 'askes')) }}</td>
                    <td>{{ array_sum(array_column($data, 'jkn_mandiri')) }}</td>
                    <td>{{ array_sum(array_column($data, 'pbi')) }}</td>
                    <td>{{ array_sum(array_column($data, 'jkd')) }}</td>
                    <td>{{ array_sum(array_column($data, 'umum')) }}</td>
                </tr>
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
                    <p style="margin-bottom: 0px;padding-bottom:0px">dr. Fatimah .M.Kes</p>
                    <p style="margin-top: 0px;padding-top:0px">NIP.198511252011012009</p>
                </div>

                <!-- Bagian Kanan -->
                <div style="text-align: left; width: 40%; padding-left: 50%;">
                    <p>Makassar, <span id="currentDate">{{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</span></p>
                    <p>Mengetahui,</p>
                    <p>Pembuat Laporan</p>
                    <br><br><br>
                    <p style="margin-bottom: 0px;padding-bottom:0px">Nurinayah,S.Kep.,Ns</p>
                    <p style="margin-top: 0px;padding-top:0px">NIP.197808042003122007</p>
                </div>
            </div>
        </div>


    </div>
</body>

</html>
