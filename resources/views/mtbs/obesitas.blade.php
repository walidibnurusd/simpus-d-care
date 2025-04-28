@extends('layouts.skrining.master')
@section('title', 'Skrining Obesitas')
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

    <form action="{{ isset($obesitas) ? route('obesitas.mtbs.update', $obesitas->id) : route('obesitas.mtbs.store') }}"
        method="POST">
        @csrf
        @if (isset($obesitas))
            @method('PUT')
        @endif

        <div class="form-section">
            <h3>Identitas</h3>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Pasien</label>
                        <select class="form-control form-select select2" id="pasien" name="pasien">
                            <option value="" disabled {{ old('pasien') == '' ? 'selected' : '' }}>Pilih</option>
                            @foreach ($pasien as $item)
                                <option value="{{ $item->id }}" data-pob="{{ $item->place_birth }}"
                                    data-nik="{{ $item->nik }}" data-dob="{{ $item->dob }}"
                                    data-alamat="{{ $item->address }}" data-jenis_kelamin="{{ $item->genderName->name }}"
                                    {{ old('pasien', $obesitas->pasien ?? '') == $item->id ? 'selected' : '' }}>
                                    {{ $item->name }} - {{ $item->nik }}
                                </option>
                            @endforeach
                        </select>
                        @error('pasien')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Tempat</label>
                        <input type="text" class="form-control" name="tempat_lahir" id="tempat_lahir" readonly
                            value="{{ old('tempat_lahir', isset($obesitas) ? $obesitas->tempat_lahir : '') }}"
                            placeholder="Masukkan tempat lahir">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Tanggal Lahir</label>
                        <input type="date" class="form-control" name="tanggal_lahir" id="tanggal_lahir" readonly
                            value="{{ old('tanggal_lahir', isset($obesitas) ? $obesitas->tanggal_lahir : '') }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Alamat</label>
                        <input type="text" class="form-control" name="alamat" id="alamat" readonly
                            value="{{ old('alamat', isset($obesitas) ? $obesitas->alamat : '') }}"
                            placeholder="Masukkan alamat">
                    </div>
                </div>
            </div>
        </div>

        <div class="form-section mt-4">
            <h3>Pemeriksaan Fisik</h3>

            <div class="col-md-12 mb-3">
                <div class="form-group">
                    <label style="width: 150px;">1. Tinggi Badan</label>
                    <input type="text" class="form-control" name="tinggi_badan"
                        value="{{ old('tinggi_badan', isset($obesitas) ? $obesitas->tinggi_badan : '') }}"
                        placeholder="Masukkan" style="width: 100px; display: inline-block;">
                    <span style="margin-left: 5px;">m</span>
                </div>
            </div>

            <div class="col-md-12 mb-3">
                <div class="form-group">
                    <label style="width: 150px;">2. Berat Badan</label>
                    <input type="text" class="form-control" name="berat_badan"
                        value="{{ old('berat_badan', isset($obesitas) ? $obesitas->berat_badan : '') }}"
                        placeholder="Masukkan" style="width: 100px; display: inline-block;">
                    <span style="margin-left: 5px;">kg</span>
                </div>
            </div>

            <div class="col-md-12 mb-3">
                <div class="form-group">
                    <label style="width: 150px;">3. Lingkar Perut</label>
                    <input type="text" class="form-control" name="lingkar_peru"
                        value="{{ old('lingkar_peru', isset($obesitas) ? $obesitas->lingkar_peru : '') }}"
                        placeholder="Masukkan" style="width: 100px; display: inline-block;">
                    <span style="margin-left: 5px;">cm</span>
                </div>
            </div>
        </div>

        <div class="form-section mt-4">
            <img src="{{ asset('assets/images/imt.png') }}" alt="">
        </div>
        <div class="col-md-12 mb-3">
            <div class="form-group">
                <label style="width: 150px;">Hasil</label>
                <input type="text" class="form-control" name="hasil"
                    value="{{ old('hasil', isset($obesitas) ? $obesitas->hasil : '') }}" placeholder="Masukkan"
                    style=" display: inline-block;">

            </div>
        </div>
        <div class="form-group">
            <div class="col-md-12">
                <label for="kesimpulan" style="color: rgb(19, 11, 241);">Kesimpulan</label>
                <textarea class="form-control" id="kesimpulan" name="kesimpulan" placeholder="Kesimpulan">{{ old('kesimpulan', $obesitas->kesimpulan ?? '') }}</textarea>
            </div>
        </div>


        <div class="text-right mt-4">
            {{-- @if (isset($obesitas) && $obesitas)
                <a href="{{ route('obesitas.mtbs.admin') }}" type="button" class="btn btn-secondary mr-2"
                    style="font-size: 20px">Kembali</a>
            @else
                <a href="{{ route('skrining.ilp') }}" type="button" class="btn btn-secondary mr-2"
                    style="font-size: 20px">Kembali</a>
            @endif --}}
            <button type="submit" class="btn btn-primary" style="font-size: 20px">Kirim</button>
        </div>
    </form>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $(document).ready(function() {

            $('.select2').select2({
                placeholder: "Pilih pasien",
                allowClear: true
            });

            $('#pasien').on('change', function() {
                var selectedOption = $(this).find(':selected');

                var dob = selectedOption.data('dob');
                var alamat = selectedOption.data('alamat');
                var pob = selectedOption.data('pob');



                $('#tanggal_lahir').val(dob);
                $('#tempat_lahir').val(pob);
                $('#alamat').val(alamat);

            });
            $('#pasien').trigger('change');
        });
    </script>

@endsection
