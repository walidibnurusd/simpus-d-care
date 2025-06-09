<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Penyakit Diare</title>
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
            background-color: #8fed8f;
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
    @php
        $month = request()->query('bulan', now()->month);
        $year = request()->query('tahun', now()->year);

        $months = [
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember',
        ];

        $monthName = $months[$month] ?? 'Tidak Diketahui';
    @endphp
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
        <p><b>BULAN {{ strtoupper($monthName) }} TAHUN {{ $year }}</b></p>
    </div>

    <div class="table-container">
        <table border="1">
            <thead>
                <tr>
                    <th rowspan="2">NO</th>
                    <th rowspan="2">TANGGAL</th>
                    <th rowspan="2">NO.RM</th>
                    <th rowspan="2">NIK</th>
                    <th rowspan="2">NAMA PASIEN</th>
                    <th rowspan="2">TGL.LAHIR</th>
                    <th rowspan="2">KEPESERTAAN</th>
                    <th rowspan="2">ALAMAT</th>
                    <th rowspan="2">JENIS KELAMIN</th>
                    <th rowspan="2">TD</th>
                    <th rowspan="2">TB</th>
                    <th rowspan="2">BB</th>
                    <th rowspan="2">LP</th>
                    <th rowspan="2">KUNJ</th>
                    <th rowspan="2">KELUHAN</th>
                    <th rowspan="2">DIAGNOSA</th>
                    <th rowspan="2">TINDAKAN</th>
                    <th rowspan="2">RUJUKAN</th>
                    <th rowspan="2">KETERANGAN</th>
                    <th rowspan="2">DOKTER</th>
                </tr>

            </thead>
            @foreach ($diare as $index => $data)
                @php
                    $kunjunganCount = App\Models\Kunjungan::where('pasien', $data->patient->id)->count();
                @endphp
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ \Carbon\Carbon::parse($data->tanggal)->format('d-m-Y') }}</td>
                    <td>{{ $data->patient->no_rm }}</td>
                    <td>{{ $data->patient->nik }}</td>
                    <td>{{ ucwords(strtolower($data->patient->name)) }}</td>
                    <td>
                        {{ \Carbon\Carbon::parse($data->patient->dob)->format('d-m-Y') }} <br>
                        {{ \Carbon\Carbon::parse($data->patient->dob)->age }} thn
                    </td>
                    <td>
                        @if ($data->patient->jenis_kartu == 'pbi')
                            PBI (KIS)
                        @elseif($data->patient->jenis_kartu == 'askes')
                            AKSES
                        @elseif($data->patient->jenis_kartu == 'jkn_mandiri')
                            JKN Mandiri
                        @elseif($data->patient->jenis_kartu == 'umum')
                            Umum
                        @elseif($data->patient->jenis_kartu == 'jkd')
                            JKD
                        @else
                            Tidak Diketahui
                        @endif
                        <br>{{ $data->patient->nomor_kartu ?? '' }}
                    </td>
                    <td>
                        {{ ucwords(strtolower($data->patient->address)) }} - RW
                        {{ $data->patient->rw === 'luar-wilayah' ? 'Luar Wilayah' : $data->patient->rw }}
                    </td>
                    <td>{{ $data->patient->genderName->name }}</td>
                    <td>{{ $data->sistol }}<br>{{ $data->diastol }}</td>
                    <td>{{ $data->tinggiBadan }}</td>
                    <td>{{ $data->beratBadan }}</td>
                    <td>{{ $data->lingkarPinggang }}</td>
                    <td>
                        {{ $kunjunganCount == 1 ? 'Baru' : 'Lama' }}
                    </td>
                    <td>{{ ucwords(strtolower($data->keluhan)) }}</td>
                    <td>
                        @if (!empty($data->diagnosa_names) && count($data->diagnosa_names) > 0)
                            {{ implode(', ', $data->diagnosa_names) }}
                        @else
                            Tidak Ada Diagnosa Diare
                        @endif
                    </td>
                    <td>{{ $data->tindakan }}</td>
                    <td>{{ $data->hospitalReferral->name ?? 'Tidak' }}</td>
                    <td>{{ $data->keterangan }}</td>
                    <td>{{ $data->doctor }}</td>

                </tr>
            @endforeach

        </table>

    </div>
</body>

</html>
