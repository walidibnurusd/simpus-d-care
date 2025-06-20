@extends('layouts.simple.master')
@section('title', 'Detail Rekap Resep Obat')

@section('css')

@endsection

@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/datatables.css') }}">
@endsection

@section('breadcrumb-title')
    <h3>Detail Rekap Resep Obat Pasien</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">{{ Auth::user()->name }}</li>
    <li class="breadcrumb-item active">Daftar Pasien</li>
@endsection

@php
    use App\Models\Diagnosis;
@endphp

@section('content')
    <div class="main-content content mt-6" id="main-content">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Success!</strong> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row">
            <div class="col-12 mb-4">
                <div class="card">
                    <div class="card-header pb-0">
                        <h6>Daftar Resep Obat</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <table>
                                    <tr>
                                        <td>NIK</td>
                                        <td style="width: 30px; text-align: center">:</td>
                                        <td>{{ $patient->nik }}</td>
                                    </tr>
                                    <tr>
                                        <td>No. RM</td>
                                        <td style="width: 30px; text-align: center">:</td>
                                        <td>{{ $patient->no_rm }}</td>
                                    </tr>
                                    <tr>
                                        <td>Nama</td>
                                        <td style="width: 30px; text-align: center">:</td>
                                        <td>{{ $patient->name }}</td>
                                    </tr>
                                    <tr>
                                        <td>Alamat</td>
                                        <td style="width: 30px; text-align: center">:</td>
                                        <td>{{ $patient->address }}</td>
                                    </tr>
                                    <tr>
                                        <td>TTL</td>
                                        <td style="width: 30px; text-align: center">:</td>
                                        <td>{{ $patient->place_birth }}/{{ \Carbon\Carbon::parse($patient->dob)->format('d-m-Y') }}</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-8">
                                
                            </div>
                            <table class="table m-1 mt-4">
                                    <tr>
                                        <th scope="col">Tanggal</th>
                                        <th scope="col">Dokter</th>
                                        <th scope="col">Obat</th>
                                        <th scope="col">Diagnosa</th>
                                        <th scope="col">Aksi</th>
                                    </tr>
                                    @foreach($patient->actions as $patientAction)
                                    <tr>
                                        <td>{{ \Carbon\Carbon::parse($patientAction->tanggal)->format('d-m-Y') }}</td>
                                        <td>{{ $patientAction->doctor }}</td>
                                        <td>
                                            @if($patientAction->actionObats->isNotEmpty())
                                                <ol style="padding-left: 15px;">
                                                    @foreach($patientAction->actionObats as $patientObat)
                                                        <li>{{ $patientObat->obat->name }}</li>
                                                    @endforeach
                                                </ol>
                                            @else
                                                <p>{{ $patientAction->obat ?? '-' }}</p>
                                            @endif
                                        </td>
                                        <td>
                                            @if($patientAction->diagnosaPrimer)
                                                {{ $patientAction->diagnosaPrimer->name }}
                                            @elseif(!$patientAction->diagnosaPrimer)
                                                @php
                                                    $diagnosisIds = $patientAction->diagnosa ?? [];
                                                    $diagnoses = Diagnosis::whereIn('id', $diagnosisIds)->get();
                                                @endphp
                                                <ol style="margin: 0; padding-left: 7px">
                                                    @foreach ($diagnoses as $diagnosis)
                                                        <li>{{ $diagnosis->name }}</li>
                                                    @endforeach
                                                </ol>
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>
                                            <a class="btn btn-primary" href="{{ route('print-prescription', ['id' => $patientAction->id]) }}" target="_blank" role="button">Print</a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection