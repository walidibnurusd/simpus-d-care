<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <style>
        @page {
            size: legal landscape;
            margin: 1cm;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 9px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 3px;
            text-align: center;
            word-wrap: break-word;
            font-size: 9px;
        }

        tr {
            page-break-inside: avoid;
        }
    </style>
</head>

<body>
    <table>
        <tr>
            <td colspan="18" align="center"><strong>LIST PENDERITA AFP</strong></td>
        </tr>
        <tr>
            <td colspan="7" align="left">KOTA : MAKASSAR</td>
            <td colspan="6" align="center">Bulan : {{ $bulan }}</td>
            <td colspan="5" align="right">Tahun : {{ $tahun }}</td>
        </tr>

        <tr>
            <th rowspan="2">Nomor EPID</th>
            <th rowspan="2">Nama</th>
            <th rowspan="2">Kota</th>
            <th rowspan="2">Umur (Tahun)</th>
            <th rowspan="2">Lumpuh</th>
            <th rowspan="2">Laporan diterima</th>
            <th rowspan="2">Pelacakan</th>
            <th colspan="2">Ambil Spesimen</th>
            <th rowspan="2">Kirim Spesimen</th>
            <th rowspan="2">Diterima Lab.</th>
            <th rowspan="2">Kondisi Spesimen</th>
            <th colspan="2">Kunjungan Ulang</th>
            <th rowspan="2">Tanggal terima hasil Lab.</th>
            <th colspan="2">Hasil Laboratorium</th>
            <th rowspan="2">Spesimen Adekuat</th>
        </tr>
        <tr>
            <th>I</th>
            <th>II</th>
            <th>Tanggal Kunjungan</th>
            <th>Paralisis residual</th>
            <th>Virus Polio</th>
            <th>Entero Virus</th>
        </tr>

        @for ($i = 1; $i <= 10; $i++)
            <tr>
                <td>{{ $i }}</td>
                @for ($j = 1; $j <= 17; $j++)
                    <td></td>
                @endfor
            </tr>
        @endfor
    </table>
</body>

</html>
