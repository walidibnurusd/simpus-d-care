<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LAPORAN BULANAN PELAYANAN PUSKESMAS


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
                <h3 style="margin:0px">UPT Puskesmas Makassar</h3>
                <p>Jl. xx yy No.264 Kode Pos : 90235 Makassar</p>
                <p>Telp. 0411-494014 Call Center : 081245194368</p>
                <p>Email: pkmmakassar@gmail.com | Situs: puskesmasmakassar.or.id</p>
            </div>
            <img src="../assets/assets/img/logo-puskesmas.png" alt="Logo Right">
        </div>
        <hr>
        <h3 style="margin-top: 20px;">LAPORAN BULANAN PELAYANAN PUSKESMAS</h3>
  
    </div>
    <div class="header" style="align-content: left">
        <table style="width: 100%; margin-left: 0; border: none; border-radius: 10px; overflow: hidden;">
            <tbody style="border: none;">
                <tr style="border: none;">
                    <td style="text-align: left; border: none;width: 10%;">Kode</td>
                    <td style="text-align: left; border: none;width: 50%;">:</td>
                    <td style="text-align: left; border: none;width: 10%;">Bulan</td>
                    <td style="text-align: left; border: none;">:</td>
                </tr>
                <tr style="border: none;">
                    <td style="text-align: left; border: none;width: 10%;">Puskesmas</td>
                    <td style="text-align: left; border: none;width: 50%;">:TAMANGAPA</td>
                    <td style="text-align: left; border: none;width: 10%;">Tahun</td>
                    <td style="text-align: left; border: none;">:2024</td>
                </tr>
                <tr style="border: none;">
                    <td style="text-align: left; border: none;width: 10%;"></td>
                    <td style="text-align: left; border: none;width: 50%;">Jumlah Puskesmas Pembantu</td>
                    <td style="text-align: left; border: none;width: 10%;">Jml Lapor</td>
                    <td style="text-align: left; border: none;"></td>
                </tr>
             
                <tr style="border: none;">
                    <td style="text-align: left; border: none;width: 10%;"></td>
                    <td style="text-align: left; border: none;width: 50%;">Jml Poskesdes/bidan desa</td>
                    <td style="text-align: left; border: none;width: 10%;">Jml Lapor</td>
                    <td style="text-align: left; border: none;"></td>
                </tr>
             
               
            </tbody>
        </table>
    </div>
    <div class="table-container">
        <table border="1">
            <thead>
                <tr>
                    <th rowspan="2" style="width: 5%">NO</th>
                    <th rowspan="2" colspan="2" >KEGIATAN</th>
                    <th  colspan="2" style="width: 20%">JUMLAH</th>
                   
                   
                </tr>
               <tr>
                <th>Baru</th>
                <th>Lama</th>
               </tr>
            
            </thead>
            <tbody>
               <tr>
                <td>I</td>
                <td colspan="2" class="left-align">KUNJUNGAN PUSKESMAS</td>
                <td></td>
                <td></td>
               </tr>
               <tr>
                <td>1</td>
                <td colspan="2" class="left-align">Jumlah kunjungan puskesmas (baru dan lama)</td>
                <td></td>
                <td></td>
               </tr>
               <tr>
                <td>2</td>
                <td colspan="2" class="left-align">Jumlah kunjungan peserta JKN</td>
                <td></td>
                <td></td>
               </tr>
               <tr>
                <td>3</td>
                <td colspan="2" class="left-align">Jumlah kunjungan peserta asuransi kesehatan lainnya</td>
                <td></td>
                <td></td>
               </tr>
               <tr>
                <td>4</td>
                <td colspan="2" class="left-align">Jumlah penderita yang dirujuk ke</td>
                <td></td>
                <td></td>
               </tr>
               <tr>
                <td></td>
                <td colspan="2" class="left-align">a. Puskesmas rawat inap</td>
                <td></td>
                <td></td>
               </tr>
               <tr>
                <td></td>
                <td colspan="2" class="left-align">b. Fasilitas kesehatan rujukan tingkat lanjut (FKRTL)</td>
                <td></td>
                <td></td>
               </tr>
               <tr>
                <td>5</td>
                <td colspan="2" class="left-align">Jumlah penderita penyakit tidak menular dirujuk ke fasilitas pelayanan kesehatan rujukan tingkat lanjut</td>
                <td></td>
                <td></td>
               </tr>
               <tr>
                <td>6</td>
                <td colspan="2" class="left-align">Jumlah penderita yang dirujuk balik dari:</td>
                <td></td>
                <td></td>
               </tr>
               <tr>
                <td></td>
                <td colspan="2" class="left-align">a. Puskesmas rawat inap</td>
                <td></td>
                <td></td>
               </tr>
               <tr>
                <td></td>
                <td colspan="2" class="left-align">b. Fasilitas kesehatan rujukan tingkat lanjut (FKRTL)</td>
                <td></td>
                <td></td>
               </tr>
               <tr>
                <td>7</td>
                <td colspan="2" class="left-align">Jumlah rujukan dari Posbindu PTM ke puskesmas</td>
                <td></td>
                <td></td>
               </tr>
            </tbody>
        </table>
        <table border="1" style="margin-top:10px">
        
            <tbody>
               <tr>
                <td style="width: 5%">II</td>
                <td colspan="2" class="left-align">RAWAT INAP</td>
                <td style="width: 10%"></td>
                <td style="width: 10%"></td>
               </tr>
               <tr>
                <td>1</td>
                <td colspan="2" class="left-align">Jumlah penderita rawat inap</td>
                <td></td>
                <td></td>
               </tr>
               <tr>
                <td>2</td>
                <td colspan="2" class="left-align">Jumlah ibu hamil, melahirkan, nifas dengan gangguan kesehatan dirawat inap</td>
                <td></td>
                <td></td>
               </tr>
               <tr>
                <td>3</td>
                <td colspan="2" class="left-align">Jumlah anak berumur < 5 tahun sakit dirawat inap </td>
                <td></td>
                <td></td>
               </tr>
               <tr>
                <td>4</td>
                <td colspan="2" class="left-align">Jumlah penderita cedera/kecelakaan dirawat inap</td>
                <td></td>
                <td></td>
               </tr>
             
               <tr>
                <td>5</td>
                <td colspan="2" class="left-align">Jumlah penderita penyakit tidak menular dirawat inap</td>
                <td></td>
                <td></td>
               </tr>
               <tr>
                <td>6</td>
                <td colspan="2" class="left-align">Jumlah penderita yang keluar sembuh dari rawat inap puskesmas</td>
                <td></td>
                <td></td>
               </tr>
             
               <tr>
                <td>7</td>
                <td colspan="2" class="left-align">Jumlah hari rawat semua penderita rawat ina  </td>
                <td></td>
                <td></td>
               </tr>
            </tbody>
        </table>
        <table border="1" style="margin-top:10px">
        
            <tbody>
               <tr>
                <td style="width: 5%">III</td>
                <td colspan="2" class="left-align">PELAYANAN KESAKITAN GIGI DAN MULUT</td>
                <td style="width: 10%"></td>
                <td style="width: 10%"></td>
               </tr>
               <tr>
                <td>1</td>
                <td colspan="2" class="left-align">Jumlah penambalan gigi tetap</td>
                <td></td>
                <td></td>
               </tr>
               <tr>
                <td>2</td>
                <td colspan="2" class="left-align">Jumlah penambalan gigi sulung</td>
                <td></td>
                <td></td>
               </tr>
               <tr>
                <td>3</td>
                <td colspan="2" class="left-align">Jumlah pencabutan gigi tetap</td>
                <td></td>
                <td></td>
               </tr>
               <tr>
                <td>4</td>
                <td colspan="2" class="left-align">Jumlah pencabutan gigi sulung</td>
                <td></td>
                <td></td>
               </tr>
             
               <tr>
                <td>5</td>
                <td colspan="2" class="left-align">Jumlah pembersihan karang gigi</td>
                <td></td>
                <td></td>
               </tr>
               <tr>
                <td>6</td>
                <td colspan="2" class="left-align">Jumlah premedikasi/pengobatan</td>
                <td></td>
                <td></td>
               </tr>
             
               <tr>
                <td>7</td>
                <td colspan="2" class="left-align">Jumlah pelayanan rujukan gigi</td>
                <td></td>
                <td></td>
               </tr>
               <tr>
                <td>8</td>
                <td colspan="2" class="left-align">Jumlah SD/MI dilaksanakan pemeriksaan kesehatan gigi dan mulut</td>
                <td></td>
                <td></td>
               </tr>
               <tr>
                <td>9</td>
                <td colspan="2" class="left-align">Jumlah murid SD/MI perlu perawatan kesehatan gigi</td>
                <td></td>
                <td></td>
               </tr>
               <tr>
                <td>10</td>
                <td colspan="2" class="left-align">Jumlah murid SD/MI yang mendapat perawatan kesehatan gigi</td>
                <td></td>
                <td></td>
               </tr>
               <tr>
                <td>11</td>
                <td colspan="2" class="left-align">Jumlah pemasangan gigi tiruan</td>
                <td></td>
                <td></td>
               </tr>
               <tr>
                <td>12</td>
                <td colspan="2" class="left-align">Jumlah ibu hamil yang mendapatkan perawatan gigi </td>
                <td></td>
                <td></td>
               </tr>
               <tr>
                <td>12</td>
                <td colspan="2" class="left-align">Jumlah TK/PAUD yang dilakukan pemeriksaan kesehatan gigi dan mulut</td>
                <td></td>
                <td></td>
               </tr>
            </tbody>
        </table>
        <table border="1" style="margin-top:10px">
        
            <tbody>
               <tr>
                <td style="width: 5%">IV</td>
                <td colspan="2" class="left-align">PELAYANAN LABORATORIUM</td>
                <td style="width: 10%"></td>
                <td style="width: 10%"></td>
               </tr>
               <tr>
                <td>1</td>
                <td colspan="2" class="left-align">Jumlah pemeriksaan hematologi</td>
                <td></td>
                <td></td>
               </tr>
               <tr>
                <td>2</td>
                <td colspan="2" class="left-align">Jumlah pemeriksaan kimia klinik</td>
                <td></td>
                <td></td>
               </tr>
               <tr>
                <td>3</td>
                <td colspan="2" class="left-align">Jumlah pemeriksaan urinalisa</td>
                <td></td>
                <td></td>
               </tr>
               <tr>
                <td>4</td>
                <td colspan="2" class="left-align">Jumlah pemeriksaan mikrobiologi dan parasitologi</td>
                <td></td>
                <td></td>
               </tr>
             
               <tr>
                <td>5</td>
                <td colspan="2" class="left-align">Jumlah pemeriksaan imunologi</td>
                <td></td>
                <td></td>
               </tr>
               <tr>
                <td>6</td>
                <td colspan="2" class="left-align">Jumlah pemeriksaan tinja</td>
                <td></td>
                <td></td>
               </tr>
             
             
            </tbody>
        </table>
        <table border="1" style="margin-top:10px">
        
            <tbody>
               <tr>
                <td style="width: 5%">V</td>
                <td colspan="2" class="left-align">PELAYANAN FARMASI</td>
                <td style="width: 10%"></td>
                <td style="width: 10%"></td>
               </tr>
               <tr>
                <td>1</td>
                <td colspan="2" class="left-align">Jumlah resep dari rawat jalan</td>
                <td></td>
                <td></td>
               </tr>
               <tr>
                <td>2</td>
                <td colspan="2" class="left-align">Jumlah resep dari rawat inap</td>
                <td></td>
                <td></td>
               </tr>
               <tr>
                <td>3</td>
                <td colspan="2" class="left-align">Jumlah konseling obat</td>
                <td></td>
                <td></td>
               </tr>
               <tr>
                <td>4</td>
                <td colspan="2" class="left-align">Jumlah pemberian informasi obat</td>
                <td></td>
                <td></td>
               </tr>
             
               <tr>
                <td rowspan="2">5</td>
                <td colspan="2" class="left-align">Jumlah penggunaan antibiotik pada ISPA Non-Pneumonia</td>
                <td></td>
                <td></td>
               </tr>
               <tr>
              
                <td colspan="2" class="left-align">Jumlah kasus ISPA Non-Pneumonia</td>
                <td></td>
                <td></td>
               </tr>
               <tr>
                <td rowspan="2">6</td>
                <td colspan="2" class="left-align">Jumlah penggunaan antibiotik pada Diare Non-Spesifik</td>
                <td></td>
                <td></td>
               </tr>
               <tr>
              
                <td colspan="2" class="left-align">Jumlah kasus Diare Non-Spesifik</td>
                <td></td>
                <td></td>
               </tr>
               <tr>
                <td rowspan="2">7</td>
                <td colspan="2" class="left-align">Jumlah penggunaan injeksi pada Myalgia</td>
                <td></td>
                <td></td>
               </tr>
               <tr>
              
                <td colspan="2" class="left-align">Jumlah kasus Myalgia</td>
                <td></td>
                <td></td>
               </tr>
               <tr>
              <td>8</td>
                <td colspan="2" class="left-align">Jumlah item obat semua resep</td>
                <td></td>
                <td></td>
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
