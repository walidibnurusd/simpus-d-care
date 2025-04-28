@extends('layouts.skrining.master')
@section('title', 'Skrining Diabetes Mellitus')
@section('content')
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show d-flex align-items-center" role="alert">
            <i class="mr-2 text-success"></i>
            <strong>Success:</strong> {{ session('success') }}
            <button type="button" class="close ml-auto" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif


    <!-- Validation Errors Alert -->
    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Warning:</strong> Please check the form for errors.
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="container">
        <form
            action="{{ isset($diabetesMellitus) ? route('diabetes.mellitus.update', $diabetesMellitus->id) : route('diabetes.mellitus.store') }}"
            method="POST">
            @csrf
            @if (isset($diabetesMellitus))
                @method('PUT')
            @endif
            @if ($routeName === 'diabetes.mellitus.view')
                <input type="hidden" name="klaster" value="2">
                <input type="hidden" name="poli" value="kia">
            @elseif($routeName === 'diabetes.mellitus.mtbs.view')
                <input type="hidden" name="klaster" value="2">
                <input type="hidden" name="poli" value="mtbs">
            @endif
            <!-- Identitas -->
            <div class="form-section">
                <h3>Identitas</h3>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <div class="form-group">
                            <label>Pasien</label>
                            <select class="form-control form-select select2" id="pasien" name="pasien">
                                <option value="" disabled {{ old('pasien') == '' ? 'selected' : '' }}>Pilih</option>
                                @if ($pasien)
                                    <option value="{{ $pasien->id }}" selected>{{ $pasien->name }} - {{ $pasien->nik }}
                                    </option>
                                @endif
                            </select>
                            @error('pasien')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Tempat Lahir</label>
                        <input type="text" class="form-control" name="tempat_lahir" placeholder="Masukkan tempat lahir"
                            readonly id="tempat_lahir" value="{{ old('tempat_lahir', $pasien->place_birth ?? '') }}">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>Tanggal Lahir</label>
                        <input type="date" class="form-control" name="tanggal_lahir" id="tanggal_lahir" readonly
                            value="{{ old('tanggal_lahir', $pasien->dob ?? '') }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Alamat Lengkap</label>
                        <input type="text" class="form-control" name="alamat" placeholder="Masukkan alamat lengkap"
                            readonly id="alamat" value="{{ old('alamat', $pasien->address ?? '') }}">
                    </div>
                </div>
            </div>

            <!-- Pemeriksaan Fisik -->
            <div class="form-section mt-4">
                <h3>Pemeriksaan Fisik</h3>
                <div class="row">
                    <div class="col-sm-6 col-md-3 mb-3">
                        <label>Tinggi Badan</label>
                        <div class="input-group">
                            <input type="number" class="form-control" name="tinggi_badan" placeholder="cm"
                                value="{{ old('tinggi_badan', $diabetesMellitus->tinggi_badan ?? '') }}">
                            <div class="input-group-append">
                                <span class="input-group-text">cm</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-3 mb-3">
                        <label>Berat Badan</label>
                        <div class="input-group">
                            <input type="number" class="form-control" name="berat_badan" placeholder="kg"
                                value="{{ old('berat_badan', $diabetesMellitus->berat_badan ?? '') }}">
                            <div class="input-group-append">
                                <span class="input-group-text">kg</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-3 mb-3">
                        <label>Lingkar Perut</label>
                        <div class="input-group">
                            <input type="number" class="form-control" name="lingkar_perut" placeholder="cm"
                                value="{{ old('lingkar_perut', $diabetesMellitus->lingkar_perut ?? '') }}">
                            <div class="input-group-append">
                                <span class="input-group-text">cm</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-3 mb-3">
                        <label>Tekanan Darah</label>
                        <div class="input-group">
                            <input type="number" class="form-control" name="tekanan_darah_sistol" placeholder="Sistol"
                                value="{{ old('tekanan_darah_sistol', $diabetesMellitus->tekanan_darah_sistol ?? '') }}">
                            <span class="input-group-text">/</span>
                            <input type="number" class="form-control" name="tekanan_darah_diastol" placeholder="Diastol"
                                value="{{ old('tekanan_darah_diastol', $diabetesMellitus->tekanan_darah_diastol ?? '') }}">
                            <div class="input-group-append">
                                <span class="input-group-text">mmHg</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Laboratorium -->
            <div class="form-section mt-4">
                <h3>Laboratorium Sederhana</h3>
                <ul>
                    <li><strong>Pemeriksaan kadar gula menggunakan Glucometer</strong></li>
                    <li><strong>Bila telah diperoleh hasilnya, cocokkan dengan tabel di bawah ini</strong></li>
                </ul>
                <div class="text-center">
                    <img src="{{ asset('assets/images/tabel_gula_darah.png') }}" alt="Tabel Gula Darah"
                        class="img-fluid" style="max-width: 100%; height: auto;">
                </div>
                <div class="col-sm-12">
                    <label>Hasil pemeriksaan</label>
                    <div class="input-group">
                        <input type="text" class="form-control" name="hasil" placeholder="hasil"
                            value="{{ old('hasil', $diabetesMellitus->hasil ?? '') }}">

                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-12">
                        <label for="kesimpulan" style="color: rgb(19, 11, 241);">Kesimpulan</label>
                        <textarea class="form-control" id="kesimpulan" name="kesimpulan" placeholder="Kesimpulan">{{ old('kesimpulan', $diabetesMellitus->kesimpulan ?? '') }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Tombol -->
            <div class="text-right mt-4">
                {{-- @if (isset($diabetesMellitus))
                    <a href="{{ route('diabetes.mellitus.admin') }}" type="button" class="btn btn-secondary mr-2"
                        style="font-size: 20px">Kembali</a>
                @else
                    <a href="{{ route('skrining.ilp') }}" type="button" class="btn btn-secondary mr-2"
                        style="font-size: 20px">Kembali</a>
                @endif --}}
                <button type="submit" class="btn btn-primary" style="font-size: 16px;">Kirim</button>
            </div>
        </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $(document).ready(function() {

            $('.select2').select2({
                placeholder: "Pilih pasien",
                allowClear: true
            });
        });
    </script>
@endsection
