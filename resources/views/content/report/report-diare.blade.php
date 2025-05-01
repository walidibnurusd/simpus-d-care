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
                <p>Jl.Tamangapa Raya No.264 Kode Pos : 90235 Makassar</p>
                <p>Telp.0411-494014 Call Center : 081245193468</p>
                <p>email: Pkmtamangapa@gmail.com https://puskesmastamangapa.or.id</p>
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
                    <th rowspan="2">TINDAKAN</th>
                    <th rowspan="2">RUJUKAN</th>
                    <th rowspan="2">KETERANGAN</th>
                    <th rowspan="2">DOKTER</th>
                </tr>
                <tr>
                    <th>Desa/Kelurahan</th>
                    <th>Alamat Lengkap</th>
                    <th>Oralit (bungkus)</th>
                    <th>Zinc (tablet)</th>
                    <th>RL (botol)</th>
                </tr>
            </thead>
            @foreach ($diare as $index => $data)
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

                @endphp

                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $data->patient->no_rm }}</td>
                    <td>{{ $data->patient->nik }}</td>
                    <td>{{ ucwords(strtolower($data->patient->name)) }}</td>
                    <td>{{ \Carbon\Carbon::parse($data->patient->dob)->format('d-m-Y') }}</td>
                    <td>{{ ucwords(strtolower($data->kartu)) }}<br>{{ $data->nomor }}</td>
                    <td>{{ $data->patient->villages ? ucwords(strtolower($data->patient->villages->name)) : 'Tidak Diketahui' }}
                    </td>
                    <td>{{ ucwords(strtolower($data->patient->address)) }}</td>
                    <td>{{ $data->patient->genderName->name }}</td>
                    <td>{{ $data->sistol }}<br>{{ $data->diastol }}</td>
                    <td>{{ $data->tinggiBadan }}</td>
                    <td>{{ $data->beratBadan }}</td>
                    <td>{{ $data->lingkarPinggang }}</td>
                    <td>{{ \Carbon\Carbon::parse($data->tanggal)->format('d-m-Y') }}</td>
                    <td>{{ \Carbon\Carbon::parse($data->tanggal)->format('d-m-Y') }}</td>
                    <td>{{ ucwords(strtolower($data->keluhan)) }}</td>
                    <td>
                        @if (!empty($data->diagnosa_names))
                            {{ implode(', ', $data->diagnosa_names) }}
                        @else
                            Tidak Ada Diagnosa Diare
                        @endif
                    </td>
                    <td>{{ $data->dehidrasi }}</td>
                    <td>
                        @if ($data->oralit == 'ya')
                            6
                        @else
                            0
                        @endif
                    </td>
                    <td>
                        @if ($data->zinc == 'tidak')
                            10
                        @else
                            0
                        @endif
                    </td>
                    <td>0</td>
                    <td>Ya</td>
                    <td>Hidup</td>
                    <td>Ya</td>
                    <td>{{ ucwords(strtolower($data->keterangan)) }}</td>
                    <td>{{ $data->hospitalReferral->name }}</td>
                    <td>{{ $data->tindakan }}</td>
                    <td>{{ $data->doctor }}</td>

                </tr>
            @endforeach

        </table>

    </div>
</body>

</html>
