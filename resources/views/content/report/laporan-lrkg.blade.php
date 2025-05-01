<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LAPORAN BULANAN KESAKITAN GIGI & MULUT FORMULIR 13

    </title>
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
                size: legal;
                /* Ukuran kertas Letter */
                margin: 20px;
                /* Margin */
            }

            body {
                transform: scale(1);
                /* Skala untuk mengecilkan */
                /* Titik asal transformasi */
            }
        }

        .left-align {
            text-align: left;
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
        <h3 style="margin-top: 20px;">LAPORAN BULANAN KESAKITAN GIGI & MULUT FORMULIR 13

        </h3>
        <p>BULAN {{ strtoupper(\Carbon\Carbon::create()->month($bulan)->translatedFormat('F')) }}
            TAHUN {{ $tahun }}</p>
    </div>

    <div class="table-container">
        <table border="1">
            <thead>
                <tr>
                    <th rowspan="3">NO</th>
                    <th rowspan="3">JENIS PENYAKIT</th>
                    <th rowspan="3">ICD 10</th>
                    <th colspan="33">JUMLAH KASUS BARU</th>
                    <th colspan="3" rowspan="2">JUMLAH KASUS LAMA</th>
                </tr>
                <tr>
                    @foreach (['0-4', '5-6', '7-11', '12', '13-14', '15-18', '19-34', '35-44', '45-64', '65+', 'TOTAL'] as $group)
                        <th colspan="3">{{ $group }} thn</th>
                    @endforeach
                </tr>
                <tr>
                    @for ($i = 0; $i < 11; $i++)
                        <th>L</th>
                        <th>P</th>
                        <th>JML</th>
                    @endfor
                    <th>L</th>
                    <th>P</th>
                    <th>JML</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $total = [
                        'ageGroups' => [],
                        'total' => ['laki_laki' => 0, 'perempuan' => 0, 'jumlah' => 0],
                        'kasus_lama' => ['laki_laki' => 0, 'perempuan' => 0, 'jumlah' => 0],
                    ];

                    foreach (
                        ['0-4', '5-6', '7-11', '12', '13-14', '15-18', '19-34', '35-44', '45-64', '65+']
                        as $group
                    ) {
                        $total['ageGroups'][$group] = ['laki_laki' => 0, 'perempuan' => 0, 'jumlah' => 0];
                    }
                @endphp

                @foreach ($diagnosisData as $index => $data)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $data['name'] }}</td>
                        <td>{{ $data['code'] }}</td>
                        @foreach ($data['ageGroups'] as $group => $values)
                            <td>{{ $values['laki_laki'] }}</td>
                            <td>{{ $values['perempuan'] }}</td>
                            <td>{{ $values['jumlah'] }}</td>
                            @php
                                $total['ageGroups'][$group]['laki_laki'] += $values['laki_laki'];
                                $total['ageGroups'][$group]['perempuan'] += $values['perempuan'];
                                $total['ageGroups'][$group]['jumlah'] += $values['jumlah'];
                            @endphp
                        @endforeach
                        <td>{{ $data['total']['laki_laki'] }}</td>
                        <td>{{ $data['total']['perempuan'] }}</td>
                        <td>{{ $data['total']['jumlah'] }}</td>
                        <td>{{ $data['kasus_lama']['laki_laki'] }}</td>
                        <td>{{ $data['kasus_lama']['perempuan'] }}</td>
                        <td>{{ $data['kasus_lama']['jumlah'] }}</td>
                        @php
                            $total['total']['laki_laki'] += $data['total']['laki_laki'];
                            $total['total']['perempuan'] += $data['total']['perempuan'];
                            $total['total']['jumlah'] += $data['total']['jumlah'];
                            $total['kasus_lama']['laki_laki'] += $data['kasus_lama']['laki_laki'];
                            $total['kasus_lama']['perempuan'] += $data['kasus_lama']['perempuan'];
                            $total['kasus_lama']['jumlah'] += $data['kasus_lama']['jumlah'];
                        @endphp
                    </tr>
                @endforeach
                <tr>
                    <td colspan="3" style="font-weight: bold; text-align: center;">TOTAL</td>
                    @foreach ($total['ageGroups'] as $group)
                        <td>{{ $group['laki_laki'] }}</td>
                        <td>{{ $group['perempuan'] }}</td>
                        <td>{{ $group['jumlah'] }}</td>
                    @endforeach
                    <td>{{ $total['total']['laki_laki'] }}</td>
                    <td>{{ $total['total']['perempuan'] }}</td>
                    <td>{{ $total['total']['jumlah'] }}</td>
                    <td>{{ $total['kasus_lama']['laki_laki'] }}</td>
                    <td>{{ $total['kasus_lama']['perempuan'] }}</td>
                    <td>{{ $total['kasus_lama']['jumlah'] }}</td>
                </tr>
            </tbody>
        </table>

        <div style="margin-top: 30px;">
            <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 50px;">
                <!-- Bagian Kiri -->
                <div style="text-align: left; width: 40%;">
                    <br><br>
                    <p>Mengetahui,</p>
                    <p>Kepala UPT Puskesmas Tamangapa</p>
                    <br><br><br>
                    <p style="margin-bottom: 0px;padding-bottom:0px">dr. Fatimah .M.Kes</p>
                    <p style="margin-bottom: 0px;padding-bottom:0px">NIP.198511252011012009</p>
                </div>

                <!-- Bagian Kanan -->
                <div style="text-align: left; width: 40%; padding-left: 50%;">
                    <p>Makassar, <span id="currentDate">{{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</span>
                    </p>
                    <p>Mengetahui,</p>
                    <p>Pengelola,</p>
                    <br><br><br>
                    <p style="margin-bottom: 0px;padding-bottom:0px">drg.Sukma</p>
                    <p style="margin-bottom: 0px;padding-bottom:0px">NIP. 197602092006042008</p>
                </div>
            </div>
        </div>


    </div>
</body>

</html>
