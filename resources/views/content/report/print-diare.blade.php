<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Harian Diare</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQpzPvcKRFEM3fDMXaWWf8fR25S4HCo97uNx0Tk3hRChY7Ntuw3s4lB6E" crossorigin="anonymous">

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
        REGISTER HARIAN PISP FASYANKES
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
                    <th style="border: none;text-align: left;"><span class="badge bg-warning text-dark">:2024</span>
                    </th>
                </tr>
            </tbody>
        </table>
    </div>

    <table class="table">
        <thead>
            <tr>

                <th colspan="9">INFO DASAR PASIEN</th>
                <th colspan="9">DIARE</th>
            </tr>
            <tr>
                <th rowspan="2">No</th>
                <th rowspan="2">NIK</th>
                <th rowspan="2">Nama Penderita</th>
                <th rowspan="2">Tanggal Lahir</th>
                <th rowspan="2">Jenis Kelamin</th>
                <th colspan="2">Alamat</th>
                <th rowspan="2">Tanggal Kunjungan</th>
                <th rowspan="2">Tanggal Mulai sakit</th>
                <th rowspan="2">Diagnosis Diare</th>
                <th rowspan="2">Derajat Dehidrasi</th>
                <th colspan="3">Jumlah Pemberian</th>
                <th rowspan="2">Penggunaan Antibiotik Terapi Diare (Ya/ Tidak)</th>
                <th rowspan="2">Status Kematian Pasien (Meninggal/ Hidup)</th>
                <th rowspan="2">Konseling</th>
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
            <tr>
                <td>1</td>
                <td>1234567890</td>
                <td>John Doe</td>
                <td>10-Feb-24</td>
                <td>Laki-laki</td>
                <td>Kelurahan A</td>
                <td>Jl. Merdeka No. 10, Makassar</td>
                <td>20-Feb-24</td>
                <td>18-Feb-24</td>
                <td>Positif</td>
                <td>Ringan</td>
                <td>1</td>
                <td>2</td>
                <td>1</td>
                <td>Ya</td>
                <td>Hidup</td>
                <td>Ya</td>
            </tr>
        </tbody>
    </table>

    <!-- Bootstrap JS (including Popper.js) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-p6eV0HO9s6rYY2gMXU+quz4v0N4zBi9hZSPz5CFOCjI4CgWcIeec1/c3p6tI2DT8" crossorigin="anonymous">
    </script>
</body>

</html>
