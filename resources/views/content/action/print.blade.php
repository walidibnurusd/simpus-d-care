<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Data Tindakan</title>
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
        <h3 style="margin-top: 20px;">REKAPAN KUNJUNGAN PASIEN</h3>
        <p>TANGGAL {{ \Carbon\Carbon::parse($startDate)->format('d-m-Y') }}
            S/D {{ \Carbon\Carbon::parse($endDate)->format('d-m-Y') }} </p>
    </div>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>NO</th>
                    <th>TANGGAL</th>
                    <th>NO.RM</th>
                    <th>NIK</th>
                    <th>NAMA PASIEN</th>
                    <th>TGL.LAHIR</th>
                    <th>KEPESERTAAN</th>
                    <th>ALAMAT</th>
                    <th>JENIS KELAMIN</th>
                    <th>TD</th>
                    <th>TB</th>
                    <th>BB</th>
                    <th>LP</th>
                    <th>KUNJ</th>
                    <th>KELUHAN</th>
                    <th>DIAGNOSA</th>
                    <th>ICD10</th>
                    <th>TINDAKAN</th>
                    <th>RUJUKAN</th>
                    <th>KETERANGAN</th>
                    <th>DOKTER</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($actions as $index => $actions)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ \Carbon\Carbon::parse($actions->tanggal)->format('d-m-Y') }}</td>
                        <td>{{ $actions->patient->no_rm }}</td>
                        <td>{{ $actions->patient->nik }}</td>
                        <td>{{ $actions->patient->name }}<br>{{ $actions->place_birth }}</td>
                        <td>{{ \Carbon\Carbon::parse($actions->patient->dob)->format('d-m-Y') }}</td>
                        <td>
                            @if ($actions->patient->jenis_kartu == 'pbi')
                                PBI (KIS)
                            @elseif($actions->patient->jenis_kartu == 'askes')
                                AKSES
                            @elseif($actions->patient->jenis_kartu == 'jkn_mandiri')
                                JKN Mandiri
                            @elseif($actions->patient->jenis_kartu == 'umum')
                                Umum
                            @elseif($actions->patient->jenis_kartu == 'jkd')
                                JKD
                            @else
                                Tidak Diketahui
                            @endif
                            <br>{{ $actions->patient->nomor_kartu ?? '' }}
                        </td>
                        <td>{{ $actions->patient->address }}</td>
                        <td>{{ $actions->patient->genderName->name }}</td>
                        <td>{{ $actions->tinggiBadan }}</td>
                        <td>{{ $actions->tinggiBadan }}</td>
                        <td>{{ $actions->beratBadan }}</td>
                        <td>{{ $actions->lingkarPinggang }}</td>
                        <td>{{ $actions->kunjungan }}</td>
                        <td>{{ $actions->keluhan }}</td>
                        @php
                            // Assuming $actions->diagnosa is an array of Diagnosis IDs
                            $diagnosaIds =
                                is_array($actions->diagnosa) || $actions->diagnosa instanceof \Countable
                                    ? $actions->diagnosa
                                    : [];
                            $diagnosa = App\Models\Diagnosis::whereIn('id', $diagnosaIds)->get();
                        @endphp

                        <td>
                            {{ implode(', ', $diagnosa->pluck('icd10')->toArray()) }}
                        </td>
                        @php
                            // Assuming $actions->diagnosa is an array of Diagnosis IDs
                            $diagnosaIds =
                                is_array($actions->diagnosa) || $actions->diagnosa instanceof \Countable
                                    ? $actions->diagnosa
                                    : [];
                            $diagnosa = App\Models\Diagnosis::whereIn('id', $diagnosaIds)->get();
                        @endphp

                        <td>
                            {{ implode(', ', $diagnosa->pluck('icd10')->toArray()) }}
                        </td>
                        <td>{{ $actions->tindakan }}</td>
                        <td>{{ $actions->hospitalReferral->name ?? '' }}</td>

                        <td>{{ $actions->keterangan }}</td>
                        <td>{{ $actions->doctor }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>

</html>
