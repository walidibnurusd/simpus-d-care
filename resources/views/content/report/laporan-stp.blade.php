<<<<<<< HEAD
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LAPORAN STP</title>
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
        <span class="badge bg-primary">SURVEILANS TERPADU PENYAKIT BERBASIS PUSKESMAS</span>

    </h1>
    <h3 style="text-align: center">
        <span class="badge bg-primary">( KASUS BARU)</span>
    </h3>


    <div class="header" style="align-content: left">
        <table style="width: 100%; margin-left: 0; border: none; border-radius: 10px; overflow: hidden;">
            <tbody style="border: none;">
                <tr style="border: none;">
                    <th style="text-align: left; border: none;width: 10%;"></th>
                    <th style="border: none;text-align: left; width: 70%;"><span class="badge bg-info"></span></th>
                    <th style="text-align: left; border: none;width: 10%;">Tahun</th>
                    <th style="border: none;text-align: left;width: 10%;"><span class="badge bg-warning text-dark">
                            :2024</span></th>
                </tr>
                <tr style="border: none;">
                    <th style="text-align: left;  border: none;">Puskesmas</th>
                    <th style="border: none;text-align: left;"><span class="badge bg-primary">:Tamangapa</span></th>
                    <th style="text-align: left; border: none;">Bulan</th>
                    <th style="border: none;text-align: left;"><span class="badge bg-warning text-dark"> :Oktober</span>
                    </th>
                </tr>
                <tr style="border: none;">
                    <th style="text-align: left; border: none;">Kabupaten/Kota</th>
                    <th style="border: none;text-align: left;"><span class="badge bg-success">:Makassar</span></th>
                    <th style="text-align: left; border: none;">Jumlah Kunjungan</th>
                    <th style="border: none;text-align: left;"><span class="badge bg-warning text-dark"> :</span></th>
                </tr>


            </tbody>
        </table>
    </div>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th rowspan="2">No</th>
                <th rowspan="2">Jenis Penyakit</th>
                <th colspan="12">GOLONGAN UMUR (tahun)</th>
                <th colspan="2">Total Jenis Kelamin</th>
                <th rowspan="2">Total Kunjungan</th>
            </tr>
            <tr>
                <th>0-7 hr</th>
                <th>8-28 hr</th>
                <th>&lt; 1</th>
                <th>1-4</th>
                <th>5-9</th>
                <th>10-14</th>
                <th>15-19</th>
                <th>20-44</th>
                <th>45-54</th>
                <th>55-59</th>
                <th>60-69</th>
                <th>70+</th>
                <th>Laki-laki</th>
                <th>Perempuan</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($report as $diagnosaName => $ageData)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $diagnosaName }}</td>
                    @foreach ($ageGroups as $ageGroup)
                        <td>{{ $ageData[$ageGroup]['total'] }}</td>
                    @endforeach
                    <td>{{ array_sum(array_column($ageData, 'male')) }}</td>
                    <td>{{ array_sum(array_column($ageData, 'female')) }}</td>
                    <td>{{ array_sum(array_column($ageData, 'total')) }}</td>
                </tr>
            @endforeach
        </tbody>

    </table>
    <div style="margin-top: 30px;">
        <div style="display: flex; justify-content: space-between; margin-bottom: 50px;">
            <div style="padding-left: 70%">
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
=======
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LAPORAN STP</title>
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
        <span class="badge bg-primary">SURVEILANS TERPADU PENYAKIT BERBASIS PUSKESMAS</span>

    </h1>
    <h3 style="text-align: center">
        <span class="badge bg-primary">( KASUS BARU)</span>
    </h3>


    <div class="header" style="align-content: left">
        <table style="width: 100%; margin-left: 0; border: none; border-radius: 10px; overflow: hidden;">
            <tbody style="border: none;">
                <tr style="border: none;">
                    <th style="text-align: left; border: none;width: 10%;"></th>
                    <th style="border: none;text-align: left; width: 70%;"><span class="badge bg-info"></span></th>
                    <th style="text-align: left; border: none;width: 10%;">Tahun</th>
                    <th style="border: none;text-align: left;width: 10%;"><span class="badge bg-warning text-dark">
                            :2024</span></th>
                </tr>
                <tr style="border: none;">
                    <th style="text-align: left;  border: none;">Puskesmas</th>
                    <th style="border: none;text-align: left;"><span class="badge bg-primary">:Tamangapa</span></th>
                    <th style="text-align: left; border: none;">Bulan</th>
                    <th style="border: none;text-align: left;"><span class="badge bg-warning text-dark"> :Oktober</span>
                    </th>
                </tr>
                <tr style="border: none;">
                    <th style="text-align: left; border: none;">Kabupaten/Kota</th>
                    <th style="border: none;text-align: left;"><span class="badge bg-success">:Makassar</span></th>
                    <th style="text-align: left; border: none;">Jumlah Kunjungan</th>
                    <th style="border: none;text-align: left;"><span class="badge bg-warning text-dark"> :</span></th>
                </tr>


            </tbody>
        </table>
    </div>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th rowspan="2">No</th>
                <th rowspan="2">Jenis Penyakit</th>
                <th colspan="12">GOLONGAN UMUR (tahun)</th>
                <th colspan="2">Total Jenis Kelamin</th>
                <th rowspan="2">Total Kunjungan</th>
            </tr>
            <tr>
                <th>0-7 hr</th>
                <th>8-28 hr</th>
                <th>&lt; 1</th>
                <th>1-4</th>
                <th>5-9</th>
                <th>10-14</th>
                <th>15-19</th>
                <th>20-44</th>
                <th>45-54</th>
                <th>55-59</th>
                <th>60-69</th>
                <th>70+</th>
                <th>Laki-laki</th>
                <th>Perempuan</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($report as $diagnosaName => $ageData)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $diagnosaName }}</td>
                    @foreach ($ageGroups as $ageGroup)
                        <td>{{ $ageData[$ageGroup]['total'] }}</td>
                    @endforeach
                    <td>{{ array_sum(array_column($ageData, 'male')) }}</td>
                    <td>{{ array_sum(array_column($ageData, 'female')) }}</td>
                    <td>{{ array_sum(array_column($ageData, 'total')) }}</td>
                </tr>
            @endforeach
        </tbody>

    </table>
    <div style="margin-top: 30px;">
        <div style="display: flex; justify-content: space-between; margin-bottom: 50px;">
            <div style="padding-left: 70%">
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
>>>>>>> 9df8fede466960d27744a11e4cb830e2a9437611
