<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Kasus Campak</title>
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
        <span class="badge bg-primary">FORMAT : C-1</span>

    </h1>
    <h1 style="text-align: center">
        <span class="badge bg-primary">LAPORAN KASUS CAMPAK</span>

    </h1>
    <p style="text-align: center">Bulan/Tahun : September / 2024</p>

    <div class="header" style="align-content: left">
        <table style="width: 100%; margin-left: 0; border: none; border-radius: 10px; overflow: hidden;">
            <tbody style="border: none;">
                <tr style="border: none;">
                    <th style="text-align: left; border: none;width: 100%;">Puskesmas : Tamangapa</th>


                </tr>
                <tr style="border: none;">
                    <th style="text-align: left; border: none;width: 100%;">Kecamatan : Manggala</th>
                </tr>
                <tr style="border: none;">
                    <th style="text-align: left; border: none;width: 100%;">Propinsi : Sulawesi Selatan</th>
                </tr>
            </tbody>
        </table>
    </div>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th rowspan="3">No Epid Kasus/ KLB</th>
                <th rowspan="3">Nama Anak</th>
                <th rowspan="3">Nama Org Tua</th>
                <th rowspan="3">Alamat Lengkap (Desa/RT/RW)</th>
                <th colspan="2">Umur/Sex</th>
                <th colspan="2">Vaksin campak seblm sakit</th>
                <th colspan="2">Tgl Timbul</th>
                <th colspan="2">Tgl Diambil Spesimen</th>
                <th colspan="2">Hasil Spesimen</th>
                <th rowspan="3">Diberi Vit.A Y/T</th>
                <th rowspan="3">Keadaan Akhir H/M</th>
                <th colspan="5">Klasifikasi Final*</th>
            </tr>
            <tr>
                <th rowspan="2">L</th>
                <th rowspan="2">P</th>
                <th rowspan="2">Brp Kali</th>
                <th rowspan="2">Tidak/Tdk Tahu</th>
                <th rowspan="2">Demam</th>
                <th rowspan="2">Rash</th>
                <th rowspan="2">Darah</th>
                <th rowspan="2">Urin</th>
                <th rowspan="2">Darah</th>
                <th rowspan="2">Urin</th>
                <th colspan="3">Campak</th>
                <th rowspan="2">Rubella Lab (+)</th>
                <th rowspan="2">Bukan Camp/Rub</th>
            </tr>
            <tr>
                <th>Lab (+)</th>
                <th>Epid</th>
                <th>Klinis</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>001/KLB/2024</td>
                <td>Ahmad</td>
                <td>Budi</td>
                <td>Desa A, RT 01 RW 02</td>
                <td>5</td>
                <td>L</td>
                <td>1</td>
                <td>Tidak</td>
                <td>12-12-2024</td>
                <td>14-12-2024</td>
                <td>15-12-2024</td>
                <td>-</td>
                <td>Negatif</td>
                <td>-</td>
                <td>Y</td>
                <td>H</td>
                <td>Lab (+)</td>
                <td>-</td>
                <td>-</td>
                <td>-</td>
                <td>-</td>
            </tr>
            <tr>
                <td>002/KLB/2024</td>
                <td>Siti</td>
                <td>Ali</td>
                <td>Desa B, RT 03 RW 04</td>
                <td>4</td>
                <td>P</td>
                <td>2</td>
                <td>Tidak Tahu</td>
                <td>10-12-2024</td>
                <td>12-12-2024</td>
                <td>13-12-2024</td>
                <td>14-12-2024</td>
                <td>Positif</td>
                <td>-</td>
                <td>Y</td>
                <td>M</td>
                <td>-</td>
                <td>Epid</td>
                <td>-</td>
                <td>Positif</td>
                <td>-</td>
            </tr>
            <tr>
                <td>003/KLB/2024</td>
                <td>Rizky</td>
                <td>Dewi</td>
                <td>Desa C, RT 05 RW 06</td>
                <td>3</td>
                <td>L</td>
                <td>0</td>
                <td>Tidak</td>
                <td>08-12-2024</td>
                <td>09-12-2024</td>
                <td>10-12-2024</td>
                <td>-</td>
                <td>Negatif</td>
                <td>-</td>
                <td>T</td>
                <td>H</td>
                <td>-</td>
                <td>-</td>
                <td>Klinis</td>
                <td>-</td>
                <td>Bukan</td>
            </tr>
        </tbody>
    </table>


    <div style="margin-top: 30px;">
        <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 50px;">
            <!-- Bagian Kiri -->
            <div style="text-align: left; width: 40%;">
                <p>
                    <strong>Penjelasan:</strong><br>
                    - Kolom 16: Pemberian Vit. A saat sakit campak<br>
                    - Kolom 17: H = Hidup, M = Mati<br>
                    - *Klasifikasi final diisi oleh Kabupaten
                </p>
            </div>

            <!-- Bagian Kanan -->
            <div style="text-align: left; width: 40%; padding-left: 50%;">
                <p>Makassar, <span id="currentDate">21 Desember 2024</span></p>
                <p>Mengetahui,</p>
                <p>Kepala UPT Puskesmas Tamangapa</p>
                <br><br><br>
                <p><strong>(___________________)</strong></p>
            </div>
        </div>
    </div>


    <!-- Bootstrap JS (including Popper.js) -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

</body>

</html>
