<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>REKAPITULASI RUJUKAN TERBANYAK


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
                <h3 style="margin:0px">UPT Puskesmas Tamangapa</h3>
                <p>Jl. xx yy No.264 Kode Pos : 90235 Makassar</p>
                <p>Telp. 0411-494014 Call Center : 081245194368</p>
                <p>Email: pkmmakassar@gmail.com | Situs: puskesmasmakassar.or.id</p>
            </div>
            <img src="../assets/assets/img/logo-puskesmas.png" alt="Logo Right">
        </div>
        <hr>
        <h3 style="margin-top: 20px;">REKAPITULASI RUJUKAN TERBANYAK</h3>
        <p>BULAN OKTOBER TAHUN 2024</p>
        <h3>10 RUMAH SAKIT RUJUKAN TERBANYAK</h3>
    </div>

    <div class="table-container">
        <table border="1">
            <thead>
                <tr>
                    <th  style="width: 10%">NO</th>
                    <th >RUMAH SAKIT</th>
                    <th >JUMLAH</th>
                  
                   
                </tr>
            
            </thead>
            <tbody>
                <tbody>
                   <tr>
                    <td>1</td>
                    <td>RS.Hermina </td>
                    <td>10</td>
                   </tr>
                </tbody>
        
               
         
              
            </tbody>
        </table>
        <h3 style="text-align: center">10 PENYAKIT TERBANYAK YANG DIRUJUKAN
        </h3>
        <table border="1">
            <thead>
                <tr>
                    <th  style="width: 10%">NO</th>
                    <th >PENYAKIT </th>
                    <th >ICDX</th>
                    <th >JUMLAH</th>
                  
                   
                </tr>
            
            </thead>
            <tbody>
                <tbody>
                   <tr>
                    <td>1</td>
                    <td>Hipertensi (asensial -primer)</td>
                    <td>I10-I15 </td>
                    <td>10</td>
                   </tr>
                </tbody>
        
               
         
              
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
                    <p>Pembuat Laporan</p>
                    <br><br><br>
                    <p><strong>(___________________)</strong></p>
                </div>
            </div>
        </div>
        
        
    </div>
</body>
</html>
