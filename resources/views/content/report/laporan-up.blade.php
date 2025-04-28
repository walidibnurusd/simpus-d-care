<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Pasien Produktif</title>
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
        <h3 style="margin-top: 20px;">LAPORAN USIA PRODUKTIF (15-59 Tahun)</h3>
        <p>TANGGAL S/D</p>
    </div>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>NO</th>
                    <th>NO.RM</th>
                    <th>NIK</th>
                    <th>NAMA PASIEN</th>
                    <th>TGL.LAHIR</th>
                    <th>KEPESERTAAN</th>
                    <th>ALAMAT</th>
                    <th>JENIS KELAMIN</th>
                    <th>PENYAKIT</th>
                    <th>KETERANGAN</th>
                    <th>DOKTER</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($patients as $index => $patient)
                    @php
                        $kartuLabels = [
                            'umum' => 'Umum',
                            'akses' => 'AKSES',
                            'bpjs' => 'BPJS-KIS_JKM',
                            'gratis_jkd' => 'Gratis-JKD',
                            'bpjs_mandiri' => 'BPJS-Mandiri',
                        ];
                        $diagnosaIds = $patient->diagnosa;
                        $diagnosa = App\Models\Diagnosis::whereIn('id', $diagnosaIds)->get();
                    @endphp
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $patient->patient->no_rm }}</td>
                        <td>{{ $patient->patient->nik }}</td>
                        <td>{{ $patient->patient->name }}</td>
                        <td>
                            {{ \Carbon\Carbon::parse($patient->patient->dob)->format('d-m-Y') }}<br>
                            {{ \Carbon\Carbon::parse($patient->patient->dob)->age }} thn
                        </td>
                        <td> {{ $kartuLabels[$patient->kartu] ?? 'Tidak Diketahui' }} <br>{{ $patient->nomor }}</td>
                        <td>{{ $patient->patient->address }}</td>
                        <td>{{ $patient->patient->genderName->name }}</td>
                        <td>{{ implode(', ', $diagnosa->pluck('name')->toArray()) }}</td>
                        <td>{{ $patient->keterangan }}</td>
                        <td>{{ $patient->doctor }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>

</html>
