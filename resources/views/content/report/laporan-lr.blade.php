<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LAPORAN RUJUKAN</title>
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
                size: letter landscape; /* Ukuran Letter dalam mode lanskap */
                margin: 10mm; 
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
        @media print {
    @page {
        size: letter landscape; /* Ukuran Letter dalam mode lanskap */
        margin: 10mm; /* Sesuaikan margin jika diperlukan */
    }

    body {
        transform: scale(1); /* Skala 81% */
        transform-origin: top left; /* Titik asal transformasi */
    }

    .left-align {
        text-align: left;
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
             <p>BULAN {{ strtoupper(\Carbon\Carbon::create()->month($bulan)->translatedFormat('F')) }}
            TAHUN {{ $tahun }}</p>
        <h3 style="margin-top: 20px;">LAPORAN RUJUKAN</h3>


    </div>

    <div class="table-container">
        <table border="1">
            <thead>
                <tr>
                    <th rowspan="2" style="width: 5%">No.</th>
                    <th rowspan="2">ICD X </th>
                    <th rowspan="2">JENIS PENYAKIT</th>
                    <th colspan="3">Jenis Kelamin </th>
                    <th colspan="6">Jenis Pembayaran</th>
                    @foreach ($hospitalColumns as $hospitalName)
                        <th rowspan="2">{{ $hospitalName }}</th>
                    @endforeach
                </tr>
                <tr>
                    <th>L</th>
                    <th>P</th>
                    <th>JML</th>
                    <th>PBI (KIS)</th>
                    <th>ASKES</th>
                    <th>JKN Mandiri</th>
                    <th>Umum</th>
                    <th>JKD</th>
                    <th>JML</th>
                </tr>
            </thead>
              <tbody>
                @foreach ($topDiagnoses as $index => $diagnosis)
                <tr>
                    @if ($diagnosis['name'] === 'Total')
                        <td colspan="3" style="text-align: center; font-weight: bold;">Total</td> <!-- Menggabungkan No + ICD X + Jenis Penyakit -->
                    @else
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $diagnosis['icd10'] }}</td>
                        <td>{{ $diagnosis['name'] }}</td>
                    @endif
                    <td>{{ $diagnosis['male'] }}</td>
                    <td>{{ $diagnosis['female'] }}</td>
                    <td>{{ $diagnosis['male'] + $diagnosis['female'] }}</td>
                    <td>{{ $diagnosis['payments']['pbi'] }}</td>
                    <td>{{ $diagnosis['payments']['askes'] }}</td>
                    <td>{{ $diagnosis['payments']['jkn_mandiri'] }}</td>
                    <td>{{ $diagnosis['payments']['umum'] }}</td>
                    <td>{{ $diagnosis['payments']['jkd'] }}</td>
                    <td>{{ array_sum($diagnosis['payments']) }}</td>
                    @foreach ($hospitalColumns as $hospitalName)
                        <td>{{ $diagnosis['hospitals'][$hospitalName] ?? 0 }}</td>
                    @endforeach
                </tr>
                @endforeach
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
                    <p style="margin-top: 0px;padding-top:0px">NIP.198511252011012009</p>
                </div>

                <!-- Bagian Kanan -->
                <div style="text-align: left; width: 40%; padding-left: 50%;">
                    <p>Makassar, <span id="currentDate">{{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</span></p>
                    <p>Mengetahui,</p>
                    <p>Pengelola</p>
                    <br><br><br>
                    <p style="margin-bottom: 0px;padding-bottom:0px">dr.Aryanti Abd Razak</p>
                    <p style="margin-top: 0px;padding-top:0px">NIP. 197908012010012014</p>
                </div>
            </div>
        </div>


    </div>
</body>

</html>
