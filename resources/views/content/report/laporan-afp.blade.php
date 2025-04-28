<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LIST PENDERITA AFP</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles -->
    <style>
        body {
            font-family: 'Arial', sans-serif;
            font-size: 12px;
        }

        .header {
            text-align: center;

        }

        .header h1 {
            font-size: 20px;
            margin: 0;
            padding: 0;
        }

        .header .subtitle {
            font-size: 14px;
        }

        .table {
            width: 100%;
            border-collapse: collapse;

        }

        .table th,
        .table td {
            border: 1px solid #000;
            padding: 5px;
            text-align: center;
        }

        .table th {
            background-color: #e0e0e0;
        }

        .note {
            font-size: 10px;
            margin-top: 10px;
            color: red;
        }

        .custom-badge {
            font-size: 1.5rem;
            padding: 10px 20px;
            border-radius: 10px;
            background-color: #007bff;
            color: #fff;
            display: inline-block;
            text-transform: uppercase;
        }
    </style>

</head>

<body>
    <h1 style="text-align: center">
        <span class="badge bg-primary">LIST PENDERITA AFP</span>

    </h1>

    <div class="header" style="align-content: left">
        <table style="width: 100%; margin-left: 0; border: none; border-radius: 10px; overflow: hidden;">
            <tbody style="border: none;">
                <tr style="border: none;">
                    <th style="text-align: left; border: none;width: 100%;">Dinas Kesehatan Kota Makassar</th>


                </tr>
                <tr style="border: none;">
                    <th style="text-align: left; border: none;width: 100%;">Bulan/Tahun : MARET/2024</th>
                </tr>
            </tbody>
        </table>
    </div>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th rowspan="3">Nomor EPID</th>
                <th rowspan="3">Nama</th>
                <th rowspan="3">Kota</th>
                <th rowspan="3">Umur (Tahun)</th>
                <th colspan="7">Tanggal</th>
                <th rowspan="3">Kondisi Spesimen</th>
                <th colspan="2">Kunjungan Ulang</th>
                <th rowspan="3">Tanggal terima hasil Lab.</th>
                <th colspan="2">Hasil Laboratorium</th>
                <th rowspan="3">Spesimen Adekuat</th>
            </tr>
            <tr>
                <th rowspan="2">Lumpuh</th>
                <th rowspan="2">Laporan diterima</th>
                <th rowspan="2">Pelacakan</th>
                <th colspan="2">Ambil Spesimen</th>
                <th rowspan="2">Kirim Spesimen</th>
                <th rowspan="2">Diterima Lab.</th>
                <th rowspan="2">Tanggal Kunjungan</th>
                <th rowspan="2">Paralisis residual</th>
                <th rowspan="2">Virus Polio</th>
                <th rowspan="2">Entero Virus</th>
            </tr>
            <tr>
                <th>I</th>
                <th>II</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>EPID-001</td>
                <td>Ahmad</td>
                <td>Jakarta</td>
                <td>10</td>
                <td>2024-12-10</td>
                <td>2024-12-11</td>
                <td>2024-12-12</td>
                <td>2024-12-13</td>
                <td>2024-12-14</td>
                <td>2024-12-15</td>
                <td>2024-12-16</td>
                <td>Baik</td>
                <td>2024-12-18</td>
                <td>No</td>
                <td>2024-12-19</td>
                <td>Negative</td>
                <td>Negative</td>
                <td>Ya</td>
            </tr>
            <tr>
                <td>EPID-002</td>
                <td>Siti</td>
                <td>Bandung</td>
                <td>8</td>
                <td>2024-12-09</td>
                <td>2024-12-10</td>
                <td>2024-12-11</td>
                <td>2024-12-12</td>
                <td>2024-12-13</td>
                <td>2024-12-14</td>
                <td>2024-12-15</td>
                <td>Buruk</td>
                <td>2024-12-17</td>
                <td>Yes</td>
                <td>2024-12-18</td>
                <td>Positive</td>
                <td>Negative</td>
                <td>Tidak</td>
            </tr>
            <tr>
                <td>EPID-003</td>
                <td>Budi</td>
                <td>Surabaya</td>
                <td>12</td>
                <td>2024-12-08</td>
                <td>2024-12-09</td>
                <td>2024-12-10</td>
                <td>2024-12-11</td>
                <td>2024-12-12</td>
                <td>2024-12-13</td>
                <td>2024-12-14</td>
                <td>Baik</td>
                <td>2024-12-16</td>
                <td>No</td>
                <td>2024-12-17</td>
                <td>Negative</td>
                <td>Negative</td>
                <td>Ya</td>
            </tr>
        </tbody>
    </table>

    <div style="margin-top: 30px;">
        <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 50px;">
            <!-- Bagian Kiri -->
            <div style="text-align: left; width: 40%;">
                <p>Mengetahui,</p>
                <p>Kepala UPT Puskesmas Tamangapa</p>
                <br><br><br>
                <p><strong>(___________________)</strong></p>
            </div>

            <!-- Bagian Kanan -->
            <div style="text-align: left; width: 40%; padding-left: 50%;">
                <p>Makassar, <span id="currentDate">21 Desember 2024</span></p>
                <p>Mengetahui,</p>
                <p>Pengelola</p>
                <br><br><br>
                <p><strong>(___________________)</strong></p>
            </div>
        </div>
    </div>


    <!-- Bootstrap JS (including Popper.js) -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

</body>

</html>
