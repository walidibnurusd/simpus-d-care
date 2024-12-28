<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LAPORAN BULANAN KESAKITAN TERBANYAK

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
                <p>Jl. xx yy No.264 Kode Pos : 90235 Makassar</p>
                <p>Telp. 0411-494014 Call Center : 081245194368</p>
                <p>Email: pkmmakassar@gmail.com | Situs: puskesmasmakassar.or.id</p>
            </div>
            <img src="../assets/assets/img/logo-puskesmas.png" alt="Logo Right">
        </div>
        <hr>
        <h4>FORMULIR 14</h4>
        <hr>
        <h3 style="margin-top: 20px;">LAPORAN BULANAN KESAKITAN TERBANYAK

        </h3>
        <p>BULAN OKTOBER TAHUN 2024</p>
    </div>

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
            <tbody>
                <tr>
                    <td>1</td>
                    <td class="left-align">Infeksi pernafasan atas akut</td>
                    <td>J00-J01 </td>
                    <td>1694 </td>
                    <td>565 </td>
                    <td>2259</td>


                </tr>
                <tr>
                    <td>2</td>
                    <td class="left-align">Hipertensi (asensial -primer) </td>
                    <td>I10-I15 </td>
                    <td>1694 </td>
                    <td>565 </td>
                    <td>2259</td>


                </tr>
                <tr>
                    <td>3</td>
                    <td class="left-align">Karies Gigi </td>
                    <td>K02 </td>
                    <td>1694 </td>
                    <td>565 </td>
                    <td>2259</td>


                </tr>
                <tr>
                    <td>4</td>
                    <td class="left-align">Diabetes Militus Getstation</td>
                    <td>0</td>
                    <td>1694 </td>
                    <td>565 </td>
                    <td>2259</td>


                </tr>
                <tr>
                    <td>5</td>
                    <td class="left-align">Benda Asing, Luka</td>
                    <td>T16-T19 </td>
                    <td>1694 </td>
                    <td>565 </td>
                    <td>2259</td>


                </tr>
                <tr>
                    <td>6</td>
                    <td class="left-align">Batuk</td>
                    <td>R05 </td>
                    <td>1694 </td>
                    <td>565 </td>
                    <td>2259</td>


                </tr>
                <tr>
                    <td>7</td>
                    <td class="left-align">Post Op</td>
                    <td>Z48</td>
                    <td>1694 </td>
                    <td>565 </td>
                    <td>2259</td>


                </tr>
                <tr>
                    <td>8</td>
                    <td class="left-align">Dispepsia </td>
                    <td>K30</td>
                    <td>1694 </td>
                    <td>565 </td>
                    <td>2259</td>


                </tr>
                <tr>
                    <td>9</td>
                    <td class="left-align">Demam gengue </td>
                    <td>A90 </td>
                    <td>1694 </td>
                    <td>565 </td>
                    <td>2259</td>


                </tr>
                <tr>
                    <td>10</td>
                    <td class="left-align">Dermatitis dan Eksim </td>
                    <td>L20-L30 </td>
                    <td>1694 </td>
                    <td>565 </td>
                    <td>2259</td>


                </tr>
                <tr>
                    <td></td>
                    <td class="left-align">TOTAL </td>
                    <td> </td>
                    <td>1694 </td>
                    <td>565 </td>
                    <td>2259</td>


                </tr>

            </tbody>




            </tbody>
        </table>
        <div style="margin-top: 30px;">
            <div style="display: flex; justify-content: space-between; align-items: flex-center; margin-bottom: 50px;">
                <!-- Bagian Kiri -->
                <div style="text-align: center; width: 100%;">
                    <p>Makassar, 28 November 2024
                    </p>
                    <p>Mengetahui,</p>
                    <p>Kepala UPT Puskesmas Tamangapa</p>
                    <br><br><br>
                    <p><strong>(___________________)</strong></p>
                </div>


            </div>
        </div>


    </div>
</body>

</html>
