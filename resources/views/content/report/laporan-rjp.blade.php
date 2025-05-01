<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>REKAPAN JENIS PELAYANAN TINDAKAN DI RUANG TINDAKAN</title>
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
        <h3 style="margin-top: 20px;">REKAPAN JENIS PELAYANAN TINDAKAN DI RUANG TINDAKAN</h3>
          <p>BULAN {{ strtoupper($namaBulan) }}
            TAHUN {{ $tahun }}</p>
    </div>

    <div class="table-container">
        <table border="1" style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr>
                    <th style="width: 10%; text-align: center;">NO</th>
                    <th style="text-align: left;">JENIS TINDAKAN</th>
                    <th style="width: 15%; text-align: center;">JUMLAH</th>
                </tr>
            </thead>
            <tbody>
                @if ($result->isEmpty())
                    <tr>
                        <td colspan="3" style="text-align: center; font-style: italic;">Data tidak tersedia</td>
                    </tr>
                @else
                    @foreach ($result as $index => $item)
                        <tr>
                            <td style="text-align: center;">{{ $index + 1 }}</td>
                            <td style="text-align: left;">{{ $item['tindakan_ruang_tindakan'] }}</td>
                            <td style="text-align: center;">{{ $item['jumlah'] }}</td>
                        </tr>
                    @endforeach
                @endif
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
                    @php
                    use Carbon\Carbon;
                    
                    $hariIni = Carbon::now()->translatedFormat('l, d F Y');
                    @endphp
                    
                    <p>Makassar, <span id="currentDate">{{ $hariIni }}</span></p>
                    <p>Mengetahui,</p>
                    <p>Pengelola</p>
                    <br><br><br>
                    <p style="margin-bottom: 0px;padding-bottom:0px">Nurinayah,S.Kep.,Ns</p>
                    <p style="margin-top: 0px;padding-top:0px">NIP.197808042003122007</p>
                </div>
            </div>
        </div>


    </div>
</body>

</html>
