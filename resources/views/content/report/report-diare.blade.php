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
    </style>

</head>

<body>
    <div class="header">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <img src="{{ asset('assets/assets/img/logo.png') }}" alt="Logo Left">
            <div>
                <h1>PEMERINTAH KOTA MAKASSAR</h1>
                <h2 style="margin: 0px">DINAS KESEHATAN</h2>
                <h3 style="margin:0px">UPT Puskesmas Makassar</h3>
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
                    <th>NO</th>
                    <th>TANGGAL</th>
                    <th>NO.RM</th>
                    <th>NIK</th>
                    <th>NAMA PASIEN</th>
                    <th>TGL.LAHIR</th>
                    <th>KEPESERTAAN</th>
                    <th>ALAMAT</th>
                    <th>JENIS KELAMIN</th>
                    <th>TD</th>
                    <th>TB</th>
                    <th>BB</th>
                    <th>LP</th>
                    <th>KUNJ</th>
                    <th>KELUHAN</th>
                    <th>DIAGNOSA</th>
                    <th>TINDAKAN</th>
                    <th>RUJUKAN</th>
                    <th>KETERANGAN</th>
                    <th>DOKTER</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>2024-12-21</td>
                    <td>RM001</td>
                    <td>1234567890123456</td>
                    <td>Ahmad Fauzi</td>
                    <td>1990-02-15</td>
                    <td>BPJS</td>
                    <td>Jl. Merdeka No. 10</td>
                    <td>Laki-laki</td>
                    <td>120/80</td>
                    <td>170 cm</td>
                    <td>70 kg</td>
                    <td>85 cm</td>
                    <td>Rawat Jalan</td>
                    <td>Demam Tinggi</td>
                    <td>Diare Akut</td>
                    <td>Pemberian Obat</td>
                    <td>Tidak</td>
                    <td>-</td>
                    <td>Dr. Surya</td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>2024-12-21</td>
                    <td>RM002</td>
                    <td>2345678901234567</td>
                    <td>Siti Aminah</td>
                    <td>1995-06-10</td>
                    <td>Umum</td>
                    <td>Jl. Pahlawan No. 20</td>
                    <td>Perempuan</td>
                    <td>110/70</td>
                    <td>160 cm</td>
                    <td>55 kg</td>
                    <td>75 cm</td>
                    <td>Rawat Jalan</td>
                    <td>Sakit Kepala</td>
                    <td>Hipertensi</td>
                    <td>Konseling</td>
                    <td>Tidak</td>
                    <td>-</td>
                    <td>Dr. Budi</td>
                </tr>
                <tr>
                    <td>3</td>
                    <td>2024-12-21</td>
                    <td>RM003</td>
                    <td>3456789012345678</td>
                    <td>Joko Susanto</td>
                    <td>1988-03-25</td>
                    <td>BPJS</td>
                    <td>Jl. Raya No. 30</td>
                    <td>Laki-laki</td>
                    <td>130/85</td>
                    <td>180 cm</td>
                    <td>80 kg</td>
                    <td>90 cm</td>
                    <td>Rawat Inap</td>
                    <td>Nyeri Perut</td>
                    <td>Maag Kronis</td>
                    <td>Pemberian Cairan</td>
                    <td>Tidak</td>
                    <td>-</td>
                    <td>Dr. Sari</td>
                </tr>
            </tbody>
        </table>

    </div>
</body>

</html>
