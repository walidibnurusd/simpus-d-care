<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FORMULIR 11</title>
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
        @media print {
            @page {
                size: legal; /* Ukuran kertas Letter */
                margin: 20px; /* Margin */
            }

            body {
                transform: scale(1); /* Skala untuk mengecilkan */
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
                <h3 style="margin:0px">UPT Puskesmas Tamangapar</h3>
                <p>Jl. xx yy No.264 Kode Pos : 90235 Makassar</p>
                <p>Telp. 0411-494014 Call Center : 081245194368</p>
                <p>Email: pkmmakassar@gmail.com | Situs: puskesmasmakassar.or.id</p>
            </div>
            <img src="../assets/assets/img/logo-puskesmas.png" alt="Logo Right">
        </div>
    <hr>
        <h3 style="margin-top: 20px;">FORMULIR 11</h3>
        <h3 style="margin-top: 20px;">LAPORAN BULANAN KESAKITAN UMUM</h3>
  
    </div>
    <div class="header" style="align-content: left">
        <table style="width: 100%; margin-left: 0; border: none; border-radius: 10px; overflow: hidden;">
            <tbody style="border: none;">
                <tr style="border: none;">
                    <td style="text-align: left; border: none;">Kode</td>
                    <td style="text-align: left; border: none;">:</td>
                    <td style="text-align: left; border: none;">Bulan</td>
                    <td style="text-align: left; border: none;">:</td>
                    <td style="text-align: left; border: none;">Jml. PP</td>
                    <td style="text-align: left; border: none;">:</td>
                    <td style="text-align: left; border: none;">Jml Poskesdes/bidan desa</td>
                    <td style="text-align: left; border: none;">:</td>
                </tr>
                <tr style="border: none;">
                    <td style="text-align: left; border: none;">Puskesmas</td>
                    <td style="text-align: left; border: none;">: TAMANGAPA </td>
                    <td style="text-align: left; border: none;">Tahun</td>
                    <td style="text-align: left; border: none;">: 2024</td>
                    <td style="text-align: left; border: none;">Jml melapor</td>
                    <td style="text-align: left; border: none;">:12130</td>
                    <td style="text-align: left; border: none;">Jml melapor</td>
                    <td style="text-align: left; border: none;">:120</td>
                </tr>
               
             
               
            </tbody>
        </table>
    </div>
    <div class="table-container">
        <table border="1">
            <thead>
                <tr>
                    <th rowspan="2" style="width: 5%">No.</th>
                    <th rowspan="2">JENIS PENYAKIT</th>
                    <th rowspan="2">ICD 10</th>
                    <th colspan="13">JUMLAH KASUS BARU (Umur dan Jenis Kelamin)</th>
                    <th colspan="3">JUMLAH KASUS LAMA</th>
                </tr>
                <tr>
                    <th>0-7 hari</th>
                    <th>8-28 hari</th>
                    <th>1-11 bl</th>
                    <th>1-4 th</th>
                    <th>5-9 th</th>
                    <th>10-14 th</th>
                    <th>15-19 Th</th>
                    <th>20-44 th</th>
                    <th>45-59 th</th>
                    <th>>59 th</th>
                    <th>L</th>
                    <th>P</th>
                    <th>JML</th>
                    <th>L</th>
                    <th>P</th>
                    <th>JML</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>ISPA</td>
                    <td>J06.9</td>
                    <td>5</td>
                    <td>3</td>
                    <td>8</td>
                    <td>12</td>
                    <td>10</td>
                    <td>7</td>
                    <td>6</td>
                    <td>15</td>
                    <td>8</td>
                    <td>10</td>
                    <td>9</td>
                    <td>78</td>
                    <td>25</td>
                    <td>22</td>
                    <td>47</td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>Diabetes Mellitus</td>
                    <td>E11.9</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>2</td>
                    <td>1</td>
                    <td>0</td>
                    <td>3</td>
                    <td>8</td>
                    <td>7</td>
                    <td>5</td>
                    <td>4</td>
                    <td>30</td>
                    <td>10</td>
                    <td>12</td>
                    <td>22</td>
                </tr>
                <tr>
                    <td>3</td>
                    <td>Hipertensi</td>
                    <td>I10</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>1</td>
                    <td>0</td>
                    <td>0</td>
                    <td>5</td>
                    <td>20</td>
                    <td>15</td>
                    <td>12</td>
                    <td>18</td>
                    <td>71</td>
                    <td>30</td>
                    <td>28</td>
                    <td>58</td>
                </tr>
                <tr>
                    <td>4</td>
                    <td>Demam Berdarah</td>
                    <td>A90</td>
                    <td>2</td>
                    <td>1</td>
                    <td>3</td>
                    <td>8</td>
                    <td>10</td>
                    <td>7</td>
                    <td>6</td>
                    <td>4</td>
                    <td>2</td>
                    <td>3</td>
                    <td>2</td>
                    <td>48</td>
                    <td>5</td>
                    <td>4</td>
                    <td>9</td>
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
