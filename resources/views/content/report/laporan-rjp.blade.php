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
        <h3 style="margin-top: 20px;">REKAPAN JENIS PELAYANAN TINDAKAN DI RUANG TINDAKAN</h3>
        <p>TANGGAL S/D</p>
    </div>

    <div class="table-container">
        <table border="1">
            <thead>
                <tr>
                    <th style="width: 10%s">NO</th>
                    <th>JENIS TINDAKAN</th>
                    <th>JUMLAH</th>
                   
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td style="text-align: left">Tampon/Off Tampon</td>
                    <td>15</td>
                </tr>
                <tr>
                    <td>2</td>
                    <td style="text-align: left">Hecting (Jahit Luka) </td>
                    <td>15</td>
                </tr>
                <tr>
                    <td>3</td>
                    <td style="text-align: left">Aff Hecting</td>
                    <td>15</td>
                </tr>
                <tr>
                    <td>4</td>
                    <td style="text-align: left">Tetes Telinga </td>
                    <td>15</td>
                </tr>
                <tr>
                    <td>5</td>
                    <td style="text-align: left">Toilet Telinga</td>
                    <td>15</td>
                </tr>
                <tr>
                    <td>6</td>
                    <td style="text-align: left">Spooling</td>
                    <td>15</td>
                </tr>
                <tr>
                    <td>7</td>
                    <td style="text-align: left">Ganti Verban</td>
                    <td>15</td>
                </tr>
                <tr>
                    <td>8</td>
                    <td style="text-align: left">Rawat Luka</td>
                    <td>15</td>
                </tr>
                <tr>
                    <td>9</td>
                    <td style="text-align: left">Insici Abses</td>
                    <td>15</td>
                </tr>
                <tr>
                    <td>10</td>
                    <td style="text-align: left">Sircumsisi (Bedah Ringan) </td>
                    <td>15</td>
                </tr>
                <tr>
                    <td>11</td>
                    <td style="text-align: left">Ekstraksi Kuku </td>
                    <td>15</td>
                </tr>
                <tr>
                    <td>12</td>
                    <td style="text-align: left">Corpus Alineum </td>
                    <td>15</td>
                </tr>
                <tr>
                    <td>13</td>
                    <td style="text-align: left">Observasi dengan tindakan Invasif</td>
                    <td>15</td>
                </tr>
                <tr>
                    <td>14</td>
                    <td style="text-align: left">Observasi tanpa tindakan Invasif</td>
                    <td>15</td>
                </tr>
              
            </tbody>
        </table>
        <div style="margin-top: 30px;">
            <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 50px;">
                <!-- Bagian Kiri -->
                <div style="text-align: left; width: 40%;">
                    <p>Mengetahui,</p>
                    <p>Kepala UPT Puskesmas Tamangapa</p>
                    <br><br><br>
                    <p><strong>(___________________)</strong></p>
                </div>
        
                <!-- Bagian Kanan -->
                <div style="text-align: left; width: 40%; padding-left: 50%;">
                    <p>Makassar, <span id="currentDate">21 Desember 2024</span></p>
                    <p>Mengetahui,</p>
                    <p>Pengelola</p>
                    <br><br><br>
                    <p><strong>(___________________)</strong></p>
                </div>
            </div>
        </div>
        
        
    </div>
</body>
</html>
