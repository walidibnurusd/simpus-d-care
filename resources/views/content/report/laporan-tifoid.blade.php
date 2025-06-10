<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Harian Tifoid</title>
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
                    <th style="border: none;text-align: left;"><span class="badge bg-warning text-dark">:2024</span>
                    </th>
                </tr>
            </tbody>
        </table>
    </div>

    <table class="table">
        <thead>
            <tr>
                <td style="border: none"></td>
                <td style="border: none;color:red" colspan="2">Note: Penambahan BARIS bisa dilakukan sebelum baris
                    warna orange (No. 2500)</td>
                <td style="border: none"></td>
                <td style="border: none;color:red" colspan="2">usia < 1 TAHUN TULIS DALAM "BULAN" </td>
                <td style="border: none"></td>
                <td style="border: none"></td>
                <td style="border: none"></td>
                <td style="border: none"></td>
                <td style="border: none;color:red" colspan="2">APABILA DUA-DUANYA POSITIF TULIS YANG PEMERIKSAAN LAB
                    SAJA POSITIF</td>
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
                <th></th>
                <th>Bulan/Tahun</th>
                <th>Desa/Kelurahan</th>
                <th>Alamat Lengkap</th>
                <th>Tanda/Gejala Klinis</th>
                <th>Konfirmasi Lab (+)</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($tifoid as $index => $data)
                @php
                    $bulanIndo = [
                        '01' => 'Jan',
                        '02' => 'Feb',
                        '03' => 'Mar',
                        '04' => 'Apr',
                        '05' => 'Mei',
                        '06' => 'Jun',
                        '07' => 'Jul',
                        '08' => 'Agu',
                        '09' => 'Sep',
                        '10' => 'Okt',
                        '11' => 'Nov',
                        '12' => 'Des',
                    ];
                    $dob = \Carbon\Carbon::parse($data->patient->dob);
                    $ageInYears = $dob->age;
                    $ageInMonths = $dob->diffInMonths(\Carbon\Carbon::now());
                    if ($ageInYears < 1) {
                        $age = $ageInMonts;
                        $ageUnit = 'Bulan';
                    } else {
                        $age = $ageInYears;
                        $ageUnit = 'Tahun';
                    }
                    $genderId = $data->patient->gender;
                    if ($genderId == 1) {
                        $gender = 'P';
                    } else {
                        $gender = 'L';
                    }

                @endphp

                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $data->patient->nik }}</td>
                    <td>{{ ucwords(strtolower($data->patient->name)) }}</td>
                    <td>{{ $bulanIndo[\Carbon\Carbon::parse($data->tanggal)->format('m')] }}</td>
                    <td>{{ \Carbon\Carbon::parse($data->tanggal)->format('d-m-Y') }}</td>
                    <td>
                        {{ $age }}
                    </td>
                    <td>
                        {{ $ageUnit }}
                    </td>
                    <td>{{ $gender }}
                    </td>
                    <td>{{ $data->patient->indonesia_village ? ucwords(strtolower($data->patient->indonesia_village)) : 'Tidak Diketahui' }}
                    </td>
                    <td>{{ ucwords(strtolower($data->patient->address)) }}</td>
                    <td>Positif</td>
                    <td>Positif</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
