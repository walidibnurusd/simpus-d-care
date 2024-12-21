<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Harian Tifoid</title>
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
            margin-bottom: 20px;
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
            margin-top: 10px;
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
        <span class="badge bg-primary">REGISTER HARIAN TIFOID</span>
    </h1>
    
  
    <div class="header" style="align-content: left">
        <table style="width: 40%; margin-left: 0; border: none; border-radius: 10px; overflow: hidden;">
            <tbody style="border: none;">
                <tr style="border: none;">
                    <th style="text-align: left; width: 40%; border: none;">Puskesmas</th>
                    <th style="border: none;text-align: left;"><span class="badge bg-primary">:Tamangapa</span></th>
                </tr>
                <tr style="border: none;">
                    <th style="text-align: left; border: none;">Kabupaten/Kota</th>
                    <th style="border: none;text-align: left;"><span class="badge bg-success">:Makassar</span></th>
                </tr>
                <tr style="border: none;">
                    <th style="text-align: left; border: none;">Provinsi</th>
                    <th style="border: none;text-align: left;"><span class="badge bg-info">:Sulawesi Selatan</span></th>
                </tr>
                <tr style="border: none;">
                    <th style="text-align: left; border: none;">Tahun</th>
                    <th style="border: none;text-align: left;"><span class="badge bg-warning text-dark">:2024</span></th>
                </tr>
            </tbody>
        </table>
    </div>

    <table class="table">
        <thead>
            <tr>
                <td style="border: none"></td>
                <td style="border: none;color:red" colspan="2">Note: Penambahan BARIS bisa dilakukan sebelum baris warna orange (No. 2500)</td>
                <td style="border: none"></td>
                <td style="border: none;color:red" colspan="2">usia < 1 TAHUN TULIS DALAM "BULAN"</td>
                <td style="border: none"></td>
                <td style="border: none"></td>
                <td style="border: none"></td>
                <td style="border: none"></td>  
                <td style="border: none;color:red" colspan="2">APABILA DUA-DUANYA POSITIF TULIS YANG PEMERIKSAAN LAB SAJA POSITIF</td>
            </tr>
            <tr>
                <th rowspan="2">No</th>
                <th rowspan="2">NIK</th>
                <th rowspan="2">Nama Penderita</th>
                <th colspan="2">Tanggal Kunjungan</th>
                <th colspan="2">Umur</th>
                <th rowspan="2">Jenis Kelamin</th>
                <th colspan="2">Alamat</th>
                <th colspan="2">Diagnosa</th>
            </tr>
            <tr>
                <th>Bulan</th>
                <th>Tanggal</th>
                <th>Bulan/Tahun</th>
                <th>Usia</th>
                <th>Desa/Kelurahan</th>
                <th>Alamat Lengkap</th>
                <th>Tanda/Gejala Klinis</th>
                <th>Konfirmasi Lab (+)</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>1</td>
                <td>1234567890</td>
                <td>John Doe</td>
                <td>Feb</td>
                <td>10-Feb-24</td>
                <td>30</td>
                <td>30</td>
                <td>Laki-laki</td>
                <td>Kelurahan A</td>
                <td>Jl. Merdeka No. 10, Makassar</td>
                <td>Demam, Batuk</td>
                <td>Positif</td>
            </tr>
            <tr>
                <td>2</td>
                <td>2345678901</td>
                <td>Jane Smith</td>
                <td>Mar</td>
                <td>15-Mar-24</td>
                <td>25</td>
                <td>25</td>
                <td>Perempuan</td>
                <td>Kelurahan B</td>
                <td>Jl. Pahlawan No. 20, Makassar</td>
                <td>Mual, Pusing</td>
                <td>Negatif</td>
            </tr>
            <tr>
                <td>3</td>
                <td>3456789012</td>
                <td>Mike Johnson</td>
                <td>Apr</td>
                <td>22-Apr-24</td>
                <td>40</td>
                <td>40</td>
                <td>Laki-laki</td>
                <td>Kelurahan C</td>
                <td>Jl. Raya No. 30, Makassar</td>
                <td>Sakit Kepala, Pusing</td>
                <td>Positif</td>
            </tr>
        </tbody>
    </table>

    <!-- Bootstrap JS (including Popper.js) -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

</body>

</html>
