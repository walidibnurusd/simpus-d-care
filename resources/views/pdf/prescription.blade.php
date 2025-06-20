@php
    use App\Models\Diagnosis;
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Resep Obat Pasien</title>
    <link rel="stylesheet" href="{{ public_path('assets/css/prescription.css') }}">
</head>
<body style="margin: 0;">
    <div style="display: flex; flex-direction: column; min-height: 100vh;">
        <div>
        <div class="header">
            <strong>UPT PUSKESMAS TAMANGAPA</strong><br>
            <small>Jl.Tamangapa Raya No.264 Kode Pos : 90235 Makassar</small><br>
            <small>Telp.0411-494014 Call Center : 081245193468</small><br>
            <strong><small>RESEP OBAT</small></strong>
            <hr>
        </div>

        <div class="section">
            <table>
                <tr>
                    <td>No. RM</td><td>:</td><td>{{ $action->patient->no_rm }}</td>
                    <td>No. Kartu</td><td>:</td><td>{{ $action->patient->nomor_kartu }}</td>
                </tr>
                <tr>
                    <td>Tanggal</td><td>:</td><td>{{ \Carbon\Carbon::parse($action->tanggal)->format('d-m-Y') }}</td>
                    <td>Dokter</td><td>:</td><td>{{ $action->doctor }}</td>
                </tr>
                <tr>
                    <td>Menyusui</td><td>:</td><td>{{ ($action->menyusui == 0) ? 'Tidak' : 'Ya' }}</td>
                    <td>Poli</td><td>:</td><td>{{ $action->tipe }}</td>
                </tr>
                <tr>
                    <td>Hamil</td><td>:</td><td>{{ $action->hamil ?? 'Tidak' }}</td>
                </tr>
                <tr>
                    <td>Alergi Obat</td><td>:</td><td colspan="6">{{ $action->alergi ?? '-' }}</td>
                </tr>
                <tr>
                    <td>G. Hati/Ginjal</td><td>:</td><td colspan="6">{{ $action->gangguan_ginjal ?? '-' }}</td>
                </tr>
                <tr>
                    <td>Diagnosa</td>
                    <td>:</td>
                    <td colspan="6">
                    @if($action->diagnosaPrimer)
                        {{ $action->diagnosaPrimer->name }}
                    @elseif(!$action->diagnosaPrimer)
                        @php
                            $diagnosisIds = $action->diagnosa ?? [];
                            $diagnoses = Diagnosis::whereIn('id', $diagnosisIds)->get();
                        @endphp
                        @foreach ($diagnoses as $diagnosis)
                            <ul style="margin: 0; padding-left: 7px">
                                <li>{{ $diagnosis->name }}</li>
                            </ul>
                        @endforeach
                    @else
                        -
                    @endif
                    </td>
                </tr>
            </table>
        </div>

        <div class="prescription">
            @forelse($action->actionObats as $obat)
                <strong>R/</strong> {{ $obat->obat->name }} [{{ $obat->amount }} {{ $obat->obat->shapeLabel }}]<br>
                &nbsp;&nbsp;&nbsp;{{ $obat->dose }}<br><br>
            @empty
                <strong>R/</strong> {{ $action->obat }}
            @endforelse
        </div>
        </div>

        <div class="section">
            <table>
                <tr>
                    <td style="width: 50px;">Nama Pasien</td>
                    <td style="width: 10px;">:</td>
                    <td style="width: 100px;">{{ $action->patient->name }}</td>
                </tr>
                <tr>
                    <td>Tgl. Lahir</td>
                    <td style="width: 10px;">:</td>
                    <td>{{ \Carbon\Carbon::parse($action->patient->dob)->format('d-m-Y') }}</td>
                    <td style="width: 30px; text-align: right">BB</td>
                    <td style="width: 10px;">:</td>
                    <td>{{ $action->beratBadan ?? '-' }}</td>
                </tr>
                <tr>
                    <td>Alamat</td>
                    <td style="width: 10px;">:</td>
                    <td>{{ $action->patient->address }}</td>
                    <td style="width: 30px; text-align: right">TB</td>
                    <td style="width: 10px;">:</td>
                    <td>{{ $action->tinggiBadan ?? '-' }}</td>
                </tr>
            </table>
        </div>

        <!-- Signatures -->
        <div class="signature-table">
            <table>
                <tr>
                    <!-- Signature 1 -->
                    <td class="signature-cell">
                        Dokter
                        <div class="line-container">
                            <span class="parens">(</span>
                            <span class="line-text"></span>
                            <span class="parens">)</span>
                        </div>
                        <div class="name-label">Nama Terang</div>
                    </td>

                    <!-- Signature 2 -->
                    <td class="signature-cell">
                        Penerima Obat
                        <div class="line-container">
                            <span class="parens">(</span>
                            <span class="line-text"></span>
                            <span class="parens">)</span>
                        </div>
                        <div class="name-label">Nama Terang</div>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</body>
</html>