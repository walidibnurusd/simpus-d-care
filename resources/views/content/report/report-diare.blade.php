<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Poli Umum Diare</title>
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
                size: Legal landscape;
                margin: 1cm;
            }
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
                <p>Jl. xx yy No.264 Kode Pos : 90235 Makassar</p>
                <p>Telp. 0411-494014 Call Center : 081245194368</p>
                <p>Email: pkmmakassar@gmail.com | Situs: puskesmasmakassar.or.id</p>
            </div>
            <img src="../assets/assets/img/logo-puskesmas.png" alt="Logo Right">
        </div>
        <hr>
        <h3 style="margin-top: 20px;">LAPORAN DATA REGISTER KASUS PENYAKIT DIARE</h3>
        <p>TANGGAL S/D</p>
    </div>

    <div class="table-container">
        <table border="1">
            <thead>
                <tr>
                    <th rowspan="2">NO</th>
                    <th rowspan="2">NO.RM</th>
                    <th rowspan="2">NIK</th>
                    <th rowspan="2">NAMA PASIEN</th>
                    <th rowspan="2">TGL.LAHIR</th>
                    <th rowspan="2">KEPESERTAAN</th>
                    <th colspan="2">ALAMAT</th>
                    <th rowspan="2">JENIS KELAMIN</th>
                    <th rowspan="2">TD</th>
                    <th rowspan="2">TB</th>
                    <th rowspan="2">BB</th>
                    <th rowspan="2">LP</th>
                    <th rowspan="2">TANGGAL KUNJUNGAN</th>
                    <th rowspan="2">TANGGAL MULAI SAKIT</th>
                    <th rowspan="2">KELUHAN</th>
                    <th rowspan="2">DIAGNOSIS DIARE</th>
                    <th rowspan="2">DERAJAT DEHIDRASI</th>
                    <th colspan="3">JUMLAH PEMBERIAN</th>
                    <th rowspan="2">Penggunaan Antibiotik Terapi Diare (Ya/ Tidak)</th>
                    <th rowspan="2">Status Kematian Pasien (Meninggal/ Hidup)</th>
                    <th rowspan="2">KONSELING</th>
                    <th  rowspan="2">TINDAKAN</th>
                    <th  rowspan="2">RUJUKAN</th>
                    <th  rowspan="2">KETERANGAN</th>
                    <th  rowspan="2">DOKTER</th>
                </tr>
                <tr>
                    <th>Desa/Kelurahan</th>
                    <th>Alamat Lengkap</th>
                    <th>Oralit (bungkus)</th>
                    <th>Zinc (tablet)</th>
                    <th>RL (botol)</th>
                </tr>
            </thead>
            <tbody>
                @for ($i = 1; $i <= 10; $i++)
                <tr>
                    <td>{{ $i }}</td>
                    <td>RM{{ str_pad($i, 4, '0', STR_PAD_LEFT) }}</td>
                    <td>123456789{{ $i }}</td>
                    <td>Pasien {{ $i }}</td>
                    <td>{{ date('d-m-Y', strtotime('-'.$i.' years')) }}</td>
                    <td>BPJS</td>
                    <td>Kelurahan {{ $i }}</td>
                    <td>Alamat Lengkap {{ $i }}</td>
                    <td>{{ $i % 2 == 0 ? 'Laki-laki' : 'Perempuan' }}</td>
                    <td>120/80</td>
                    <td>165</td>
                    <td>60</td>
                    <td>85</td>
                    <td>{{ date('d-m-Y') }}</td>
                    <td>{{ date('d-m-Y', strtotime('-'.$i.' days')) }}</td>
                    <td>Keluhan {{ $i }}</td>
                    <td>Ya</td>
                    <td>Ringan</td>
                    <td>{{ rand(1, 5) }}</td>
                    <td>{{ rand(1, 10) }}</td>
                    <td>{{ rand(1, 3) }}</td>
                    <td>Tidak</td>
                    <td>Hidup</td>
                    <td>Konseling {{ $i }}</td>
                    <td>Tindakan {{ $i }}</td>
                    <td>Rujukan {{ $i }}</td>
                    <td>Keterangan {{ $i }}</td>
                    <td>Dokter {{ $i }}</td>
                </tr>
                @endfor
            </tbody>
          
        </table>

    </div>
</body>

</html>
