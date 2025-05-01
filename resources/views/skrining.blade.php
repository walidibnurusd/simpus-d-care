<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Skrining ILP Puskesmas Tamangapa</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            background-color: #f5f5f5;
            margin: 0;
        }

        .header {
            background-color: #ffffff;
            padding: 20px;
            border-bottom: 3px solid #4CAF50;
        }

        .header h1 {
            margin: 0;
            font-size: 36px;
            font-weight: bold;
            color: #333;
        }

        .section-title {
            background-color: #4CAF50;
            color: #ffffff;
            padding: 15px;
            font-weight: bold;
            font-size: 18px;
        }

        .section-title p {
            margin: 5px 0 0;
            font-size: 14px;
        }

        .button-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 15px;
            padding: 20px;
            background-color: #ffffff;
        }

        .button {
            background-color: #4CAF50;
            color: #ffffff;
            border: none;
            padding: 15px 30px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            border-radius: 5px;
        }

        .button:hover {
            background-color: #45A049;
        }

        .footer {
            background-color: #4CAF50;
            color: #ffffff;
            padding: 15px;
            font-weight: bold;
            font-size: 16px;
        }
    </style>
</head>

<body>

    <div class="header">
        <h1>SKRINING ILP Puskesmas Tamangapa</h1>
    </div>

    <div class="section-title">
        <p>KLASTER 2 = PELAYANAN KESEHATAN IBU DAN ANAK</p>
        <p>Poli KIA (Ibu Hamil, Bersalin, Nifas)</p>
    </div>

    <div class="button-container">


        <a href="{{ route('hipertensi.view') }}" class="button">SKRINING HIPERTENSI</a>
        <a href="{{ route('gangguan.autis.view') }}" class="button">SKRINING GANGGUAN SPEKTRUM AUTISM</a>
        <a href="{{ route('kecacingan.view') }}" class="button">SKRINING KECACINGAN</a>
        <a href="{{ route('hiv.view') }}" class="button">SKRINING HIV & IMS</a>
        <a href="{{ route('anemia.view') }}" class="button">SKRINING ANEMIA</a>
        <a href="{{ route('talasemia.view') }}" class="button">SKRINING TALASEMIA</a>
        <a href="{{ route('hepatitis.view') }}" class="button">SKRINING HEPATITIS</a>
        <a href="{{ route('kekerasan.anak.view') }}" class="button">SKRINING KEKERASAN TERHADAP ANAK</a>
        <a href="{{ route('kekerasan.perempuan.view') }}" class="button">SKRINING KEKERASAN TERHADAP PEREMPUAN</a>
        <a href="{{ route('diabetes.mellitus.view') }}" class="button">SKRINING DIABETES MELLITUS</a>
        <a href="{{ route('tbc.view') }}" class="button">SKRINING TBC</a>
        <a href="{{ route('triple.eliminasi.view') }}" class="button">SKRINING TRIPLE ELIMINASI BUMIL</a>
    </div>

    <div class="footer">
        <p>KLASTER 2 = PELAYANAN KESEHATAN IBU DAN ANAK</p>
        <p>Poli MTBS dan Remaja (Usia &lt;18 Tahun)</p>
    </div>

    <div class="button-container">
        <a href="{{ route('testPendengaran.mtbs.view') }}" class="button">SKRINING TES PENDENGARAN</a>
        <a href="{{ route('hipertensi.mtbs.view') }}" class="button">SKRINING HIPERTENSI</a>
        <a href="{{ route('kecacingan.mtbs.view') }}" class="button">SKRINING KECACINGAN</a>
        <a href="{{ route('tbc.mtbs.view') }}" class="button">SKRINING TBC</a>
        <a href="{{ route('sdq.mtbs.view') }}" class="button">SKRINING SDQ (4-11 TAHUN)</a>
        <a href="{{ route('sdq.remaja.mtbs.view') }}" class="button">SKRINING SDQ (11-18 TAHUN)</a>
        <a href="{{ route('kekerasan.anak.mtbs.view') }}" class="button">SKRINING KEKERASAN TERHADAP ANAK</a>
        <a href="{{ route('kekerasan.perempuan.mtbs.view') }}" class="button">SKRINING KEKERASAN TERHADAP PEREMPUAN</a>
        <a href="{{ route('diabetes.mellitus.mtbs.view') }}" class="button">SKRINING DIABETES MELLITUS</a>
        <a href="{{ route('anemia.mtbs.view') }}" class="button">SKRINING ANEMIA</a>
        <a href="{{ route('talasemia.mtbs.view') }}" class="button">SKRINING TALASEMIA</a>
        <a href="{{ route('obesitas.mtbs.view') }}" class="button">SKRINING OBESITAS</a>
        <a href="{{ route('napza.mtbs.view') }}" class="button">SKRINING NAPZA</a>
        <a href="{{ route('merokok.mtbs.view') }}" class="button">SKRINING PERILAKU MEROKOK BAGI ANAK SEKOLAH</a>
    </div>

    <div class="footer">
        <p>KLASTER 3 = PELAYANAN USIA DEWASA DAN LANJUT USIA</p>
        <p>(Dewasa usia 18-59 Tahun dan Lansia usia >60 Tahun)</p>
    </div>

    <div class="button-container">
        <a href="{{ route('kankerParu.lansia.view') }}" class="button">SKRINING KANKER PARU</a>
        <a href="{{ route('kankerKolorektal.lansia.view') }}" class="button">SKRINING KANKER KOLOREKTAL</a>
        <a href="{{ route('puma.lansia.view') }}" class="button">SKRINING PPOK (PUMA)</a>
        <a href="{{ route('geriatri.lansia.view') }}" class="button">SKRINING GERIATRI</a>
        <a href="{{ route('kankerPayudara.lansia.view') }}" class="button">SKRINING KANKER LEHER RAHIM DAN KANKER
            PAYUDARA</a>
        <a href="{{ route('hipertensi.lansia.view') }}" class="button">SKRINING HIPERTENSI</a>
        <a href="{{ route('tbc.lansia.view') }}" class="button">SKRINING TBC</a>
        <a href="{{ route('layakHamil.lansia.view') }}" class="button">SKRINING LAYAK HAMIL</a>
        <a href="{{ route('anemia.lansia.view') }}" class="button">SKRINING ANEMIA</a>
        <a href="{{ route('talasemia.lansia.view') }}" class="button">SKRINING TALASEMIA</a>



    </div>

</body>

</html>
