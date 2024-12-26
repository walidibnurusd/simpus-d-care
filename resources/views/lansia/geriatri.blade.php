@extends('layouts.skrining.master')
@section('title', 'SKRINING LANSIA SEDERHANA (SKILAS)')
@section('content')
    <!-- Success Alert -->
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

    <form action="{{ isset($geriatri) ? route('geriatri.lansia.update', $geriatri->id) : route('geriatri.lansia.store') }}"
        method="POST">
        @csrf
        @if (isset($geriatri))
            @method('PUT')
        @endif
        <div class="form-section">
            
            <h3>Identitas</h3>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Nama</label>
                        <input type="text" class="form-control" name="nama" placeholder="Masukkan nama lengkap"
                            value="{{ old('nama', $geriatri->nama ?? '') }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Umur</label>
                        <input type="number" class="form-control" name="umur" placeholder="Masukkan nama umur"
                            value="{{ old('umur', $geriatri->umur ?? '') }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Jenis Kelamin</label>
                        <div class="d-flex">
                            <div class="form-check mr-3">
                                <input type="radio" class="form-check-input" name="jenis_kelamin" value="laki-laki" id="laki-laki"
                                    {{ old('jenis_kelamin', $geriatri->jenis_kelamin ?? '') == 'laki-laki' ? 'checked' : '' }}>
                                <label class="form-check-label" for="laki-laki">Laki-laki</label>
                            </div>
                            <div class="form-check">
                                <input type="radio" class="form-check-input" name="jenis_kelamin" value="perempuan" id="perempuan"
                                    {{ old('jenis_kelamin', $geriatri->jenis_kelamin ?? '') == 'perempuan' ? 'checked' : '' }}>
                                <label class="form-check-label" for="perempuan">Perempuan</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Alamat</label>
                        <input type="text" class="form-control" name="alamat" placeholder="Masukkan nama alamat"
                            value="{{ old('alamat', $geriatri->alamat ?? '') }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>RT</label>
                        <input type="text" class="form-control" name="rt" placeholder="Masukkan nama rt"
                            value="{{ old('rt', $geriatri->rt ?? '') }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>RW</label>
                        <input type="text" class="form-control" name="rw" placeholder="Masukkan nama rw"
                            value="{{ old('rw', $geriatri->rw ?? '') }}">
                    </div>
                </div>
            </div>
            



        </div>
        <div class="form-section mt-4">
            <h3>Pertanyaan</h3>
            <div class="row">
                <div class="col-md-12">
                 
                </div>
                
                <div class="col-md-12">
                    <div class="form-group">
                        <label>1. Orientasi terhadap waktu dan tempat: <br>
                            a. Tanggal berapa sekarang? <br>
                            b. Dimana anda berada sekarang (rumah, klinik, dsb)?
                        </label>
                        <div class="d-flex">
                            <div class="form-check mr-3">
                                <input type="radio" class="form-check-input" name="tempat_waktu" value="1" onclick="calculateTotalScore()"
                                    {{ old('tempat_waktu', $geriatri->tempat_waktu ?? '') == '1' ? 'checked' : '' }}>
                                <label class="form-check-label">Ya, ada penurunan kognitif</label>
                            </div>
                
                            <div class="form-check ml-3">
                                <input type="radio" class="form-check-input" name="tempat_waktu" value="0" onclick="calculateTotalScore()"
                                    {{ old('tempat_waktu', $geriatri->tempat_waktu ?? '') == '0' ? 'checked' : '' }}>
                                <label class="form-check-label">Tidak</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label>2. Mengingat dan mengulang tiga kata: bunga, pintu, nasi (sebagai contoh)

                        </label>
                        <div class="d-flex">
                            <div class="form-check mr-3">
                                <input type="radio" class="form-check-input" name="ulang_kata" value="1" onclick="calculateTotalScore()"
                                    {{ old('ulang_kata', $geriatri->ulang_kata ?? '') == '1' ? 'checked' : '' }}>
                                <label class="form-check-label">Ya, ada penurunan kognitif</label>
                            </div>
                
                            <div class="form-check ml-3">
                                <input type="radio" class="form-check-input" name="ulang_kata" value="0" onclick="calculateTotalScore()"
                                    {{ old('ulang_kata', $geriatri->ulang_kata ?? '') == '0' ? 'checked' : '' }}>
                                <label class="form-check-label">Tidak</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label>3. Tes berdiri dari kursi: Berdiri dari kursi lima kali tanpa menggunakan tangan. Apakah orang tersebut dapat berdiri dikursi sebanyak 5 kali dalam 14 detik?

                        </label>
                        <div class="d-flex">
                            <div class="form-check mr-3">
                                <input type="radio" class="form-check-input" name="tes_berdiri" value="1" onclick="calculateTotalScore()"
                                    {{ old('tes_berdiri', $geriatri->tes_berdiri ?? '') == '1' ? 'checked' : '' }}>
                                <label class="form-check-label">Ya, ada keterbatasan mobilisasi</label>
                            </div>
                
                            <div class="form-check ml-3">
                                <input type="radio" class="form-check-input" name="tes_berdiri" value="0" onclick="calculateTotalScore()"
                                    {{ old('tes_berdiri', $geriatri->tes_berdiri ?? '') == '0' ? 'checked' : '' }}>
                                <label class="form-check-label">Tidak</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label>4. Apakah berat badan anda berkurang > 3kg dalam 3 bulan terakhir atau pakaian menjadi lebih longgar?

                        </label>
                        <div class="d-flex">
                            <div class="form-check mr-3">
                                <input type="radio" class="form-check-input" name="pakaian" value="1" onclick="calculateTotalScore()"
                                    {{ old('pakaian', $geriatri->pakaian ?? '') == '1' ? 'checked' : '' }}>
                                <label class="form-check-label">Ya, berat badan menurun</label>
                            </div>
                
                            <div class="form-check ml-3">
                                <input type="radio" class="form-check-input" name="pakaian" value="0" onclick="calculateTotalScore()"
                                    {{ old('pakaian', $geriatri->pakaian ?? '') == '0' ? 'checked' : '' }}>
                                <label class="form-check-label">Tidak</label>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-12">
                    <div class="form-group">
                        <label>5. Apakah anda hilang nafsu makan atau mengalami kesulitan makan, menggunakan selang/sonde)?

                        </label>
                        <div class="d-flex">
                            <div class="form-check mr-3">
                                <input type="radio" class="form-check-input" name="nafsu_makan" value="1" onclick="calculateTotalScore()"
                                    {{ old('nafsu_makan', $geriatri->nafsu_makan ?? '') == '1' ? 'checked' : '' }}>
                                <label class="form-check-label">Ya, berat badan menurun</label>
                            </div>
                
                            <div class="form-check ml-3">
                                <input type="radio" class="form-check-input" name="nafsu_makan" value="0" onclick="calculateTotalScore()"
                                    {{ old('nafsu_makan', $geriatri->nafsu_makan ?? '') == '0' ? 'checked' : '' }}>
                                <label class="form-check-label">Tidak</label>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-12">
                    <div class="form-group">
                        <label>6. Apakah ukuran lingkar lengan atas (LiLA) <21 cm?
                            *

                        </label>
                        <div class="d-flex">
                            <div class="form-check mr-3">
                                <input type="radio" class="form-check-input" name="ukuran_lingkar" value="1" onclick="calculateTotalScore()"
                                    {{ old('ukuran_lingkar', $geriatri->ukuran_lingkar ?? '') == '1' ? 'checked' : '' }}>
                                <label class="form-check-label">Ya, Lila kurang dari 21 cm</label>
                            </div>
                
                            <div class="form-check ml-3">
                                <input type="radio" class="form-check-input" name="ukuran_lingkar" value="0" onclick="calculateTotalScore()"
                                    {{ old('ukuran_lingkar', $geriatri->pakaian ?? '') == '0' ? 'checked' : '' }}>
                                <label class="form-check-label">Tidak</label>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-12">
                    <div class="form-group">
                        <label>7. Apakah anda mengalami masalah pada mata: kesulitan melihat jauh, membaca, penyakit mata,atau sedang dalam pengobatan medis (diabetes, tekanan darah tinnggi)? Jika tidak, lakukan TES MELIHAT

                        </label>
                        <div class="d-flex">
                            <div class="form-check mr-3">
                                <input type="radio" class="form-check-input" name="tes_melihat" value="1" onclick="calculateTotalScore()"
                                    {{ old('tes_melihat', $geriatri->tes_melihat ?? '') == '1' ? 'checked' : '' }}>
                                <label class="form-check-label">Ya, ada gangguan penglihatan</label>
                            </div>
                
                            <div class="form-check ml-3">
                                <input type="radio" class="form-check-input" name="tes_melihat" value="0" onclick="calculateTotalScore()"
                                    {{ old('tes_melihat', $geriatri->tes_melihat ?? '') == '0' ? 'checked' : '' }}>
                                <label class="form-check-label">Tidak</label>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-12">
                    <div class="form-group">
                        <label>8. TES MELIHAT : Apakah jawaban hitung jari benar dalam 3 kali berturut-turut?

                        </label>
                        <div class="d-flex">
                            <div class="form-check mr-3">
                                <input type="radio" class="form-check-input" name="hitung_jari" value="1" onclick="calculateTotalScore()"
                                    {{ old('hitung_jari', $geriatri->hitung_jari ?? '') == '1' ? 'checked' : '' }}>
                                <label class="form-check-label">Ya, ada gangguan penglihatan</label>
                            </div>
                
                            <div class="form-check ml-3">
                                <input type="radio" class="form-check-input" name="hitung_jari" value="0" onclick="calculateTotalScore()"
                                    {{ old('hitung_jari', $geriatri->hitung_jari ?? '') == '0' ? 'checked' : '' }}>
                                <label class="form-check-label">Tidak</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label>9. Mendengar bisikan saat TES BISIK. Jika tidak dapat dilakukan Tes Bisik, rujuk Puskesmas

                        </label>
                        <div class="d-flex">
                            <div class="form-check mr-3">
                                <input type="radio" class="form-check-input" name="tes_bisik" value="1" onclick="calculateTotalScore()"
                                    {{ old('tes_bisik', $geriatri->tes_bisik ?? '') == '1' ? 'checked' : '' }}>
                                <label class="form-check-label">Ya, ada gangguan pendengaran
                                </label>
                            </div>
                
                            <div class="form-check ml-3">
                                <input type="radio" class="form-check-input" name="tes_bisik" value="0" onclick="calculateTotalScore()"
                                    {{ old('tes_bisik', $geriatri->tes_bisik ?? '') == '0' ? 'checked' : '' }}>
                                <label class="form-check-label">Tidak</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label>10. Selama dua minggu terakhir, apakah anda merasa terganggu oleh Perasaan sedih, tertekan, atau putus asa

                        </label>
                        <div class="d-flex">
                            <div class="form-check mr-3">
                                <input type="radio" class="form-check-input" name="perasaan_sedih" value="1" onclick="calculateTotalScore()"
                                    {{ old('perasaan_sedih', $geriatri->perasaan_sedih ?? '') == '1' ? 'checked' : '' }}>
                                <label class="form-check-label">Ya</label>
                            </div>
                
                            <div class="form-check ml-3">
                                <input type="radio" class="form-check-input" name="perasaan_sedih" value="0" onclick="calculateTotalScore()"
                                    {{ old('perasaan_sedih', $geriatri->perasaan_sedih ?? '') == '0' ? 'checked' : '' }}>
                                <label class="form-check-label">Tidak</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label>11.Selama dua minggu terakhir, apakah anda merasa terganggu oleh sedikit minat atau kesenangan dalam melakukan sesuatu

                        </label>
                        <div class="d-flex">
                            <div class="form-check mr-3">
                                <input type="radio" class="form-check-input" name="kesenangan" value="1" onclick="calculateTotalScore()"
                                    {{ old('kesenangan', $geriatri->kesenangan ?? '') == '1' ? 'checked' : '' }}>
                                <label class="form-check-label">Ya</label>
                            </div>
                
                            <div class="form-check ml-3">
                                <input type="radio" class="form-check-input" name="kesenangan" value="0" onclick="calculateTotalScore()"
                                    {{ old('kesenangan', $geriatri->kesenangan ?? '') == '0' ? 'checked' : '' }}>
                                <label class="form-check-label">Tidak</label>
                            </div>
                        </div>
                    </div>
                </div>
           
                
               
                
            </div>
            <div class="form-group mt-4">
                <div class="form-group">
                    <label><strong>Hasil:</strong></label>
                    <p id="totalScore">Total Skor: 0</p>
                </div>
            </div>
        

        </div>

        <div class="text-right mt-4">
            @if (isset($geriatri) && $geriatri)
            <a href="{{ route('puma.lansia.admin') }}" type="button" class="btn btn-secondary mr-2" style="font-size: 20px">Kembali</a>
        @else
            <a href="{{ route('skrining.ilp') }}" type="button" class="btn btn-secondary mr-2" style="font-size: 20px">Kembali</a>
        @endif
            <button type="submit" class="btn btn-primary" style="font-size: 20px">Kirim</button>
        </div>
    </form>
    <script>
        function calculateTotalScore() {
            // Daftar nama pertanyaan
            let questionNames = [
                'tempat_waktu',
                'ulang_kata',
                'tes_berdiri',
                'pakaian',
                'nafsu_makan',
                'ukuran_lingkar',
                'tes_melihat',
                'hitung_jari',
                'tes_bisik',
                'perasaan_sedih',
                'kesenangan'
            ];
    
            let totalScore = 0;
    
            // Iterasi melalui setiap nama pertanyaan
            questionNames.forEach(name => {
                let selectedOption = document.querySelector(`input[name="${name}"]:checked`);
                totalScore += selectedOption ? parseInt(selectedOption.value) : 0;
            });
    
            // Tampilkan hasil
            document.getElementById('totalScore').innerText = `Total Skor: ${totalScore}`;
        }
    </script>
    

@endsection
