<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Data Pasien</title>
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
        .header h1, .header h2, .header p {
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
        table th, table td {
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
                <h3 style="margin:0px">UPT Puskesmas Makassar</h3>
                <p>Jl. xx yy No.264 Kode Pos : 90235 Makassar</p>
                <p>Telp. 0411-494014 Call Center : 081245194368</p>
                <p>Email: pkmmakassar@gmail.com | Situs: puskesmasmakassar.or.id</p>
            </div>
            <img src="../assets/assets/img/logo-puskesmas.png" alt="Logo Right">
        </div>
        <hr>
        <h3 style="margin-top: 20px;">DAFTAR DATA PASIEN</h3>
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
                    <th>TEMPAT/TGL.LAHIR</th>
                    <th>UMUR</th>
                    <th>JENIS KELAMIN</th>
                    <th>ALAMAT</th>
                    <th>RW</th>
                    <th>TELEPON</th>
                    <th>MENIKAH</th>
                    <th>PENDIDIKAN</th>
                    <th>PEKERJAAN</th>
                    <th>GOLONGAN DARAH</th>
                    <th>TGL INPUT</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($patients as $index => $patient)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $patient->no_rm }}</td>
                        <td>{{ $patient->nik }}</td>
                        <td>{{ $patient->name }}</td>
                        <td>{{ $patient->dob }}<br>{{ $patient->place_birth }}</td>
                        <td>{{ $patient->umur }} thn</td>
                        <td>{{ $patient->genderName->name }}</td>
                        <td>{{ $patient->address }}</td>
                        <td>{{ $patient->rw }}</td>
                        <td>{{ $patient->phone }}</td>
                        <td>{{ $patient->marritalStatus->name }}</td>
                        <td>{{ $patient->educations->name }}</td>
                        <td>{{ $patient->occupations->name }}</td>
                        <td>{{ $patient->blood_type }}</td>
                        <td>{{ $patient->created_at }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>
