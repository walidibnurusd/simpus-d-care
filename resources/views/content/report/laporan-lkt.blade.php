<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LAPORAN KESAKITAN TERBANYAK

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
        <hr style="border:1px solid rgb(95, 94, 94);">

        <hr style="border: 1px solid  rgb(95, 94, 94);">

        <h3 style="margin-top: 20px;">LAPORAN BULANAN KESAKITAN TERBANYAK

        </h3>
        <p>BULAN {{ strtoupper(\Carbon\Carbon::create()->month($bulan)->translatedFormat('F')) }}
            TAHUN {{ $tahun }}</p </div>

        <div class="table-container">
            <table border="1">
                <thead>
                    <tr>
                        <th style="width: 10%">NO</th>
                        <th>Jenis Penyakit Terbanyak</th>
                        <th>ICD 10 </th>
                        <th>Jumlah Kasus
                            Baru
                        </th>
                        <th>Jumlah Kasus
                            Lama</th>
                        <th>TOTAL</th>

                    </tr>

                </thead>
                <tbody>
                    @php
                        $totalBaru = 0;
                        $totalLama = 0;
                    @endphp

                    @forelse ($data as $index => $item)
                        @php
                            $totalBaru += $item['baru'];
                            $totalLama += $item['lama'];
                        @endphp
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td class="left-align">{{ $item['diagnosa'] }}</td>
                            <td>{{ $item['icd10'] }}</td>
                            <td>{{ $item['baru'] }}</td>
                            <td>{{ $item['lama'] }}</td>
                            <td>{{ $item['baru'] + $item['lama'] }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">Tidak ada data diagnosa untuk tahun
                                {{ $tahun }}</td>
                        </tr>
                    @endforelse

                    @if (count($data) > 0)
                        <tr class="fw-bold table-success">
                            <td colspan="3" class="text-center">Total Keseluruhan</td>
                            <td>{{ $totalBaru }}</td>
                            <td>{{ $totalLama }}</td>
                            <td>{{ $totalBaru + $totalLama }}</td>
                        </tr>
                    @endif
                </tbody>


            </table>
            <div style="margin-top: 30px;">
                <div
                    style="display: flex; justify-content: space-between; align-items: flex-center; margin-bottom: 50px;">
                    <!-- Bagian Kiri -->
                    <div style="text-align: center; width: 100%;">
                        <p>Makassar, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>

                        <p>Mengetahui,</p>
                        <p>Kepala UPT Puskesmas Tamangapa</p>
                        <br><br><br>
                        <p style="margin-bottom: 0px;padding-bottom:0px">dr. Fatimah .M.Kes</p>
                        <p style="margin-top: 0px;padding-top:0px">NIP.198511252011012009</>
                        </p>
                    </div>


                </div>
            </div>


        </div>
</body>

</html>
