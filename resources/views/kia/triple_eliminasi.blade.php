@extends('layouts.skrining.master')
@section('title', 'Skrining Triple Eliminasi Bumil')
@section('content')
    <!-- Identitas Section -->
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

    <form action="{{ isset($triple) ? route('triple.eliminasi.update', $triple->id) : route('triple.eliminasi.store') }}"
        method="POST">
        @csrf
        @if (isset($triple))
            @method('PUT')
        @endif
        <div class="form-section">
            <h3>Identitas</h3>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>1. Nama</label>
                        <input type="text" 
                               class="form-control" 
                               name="nama" 
                               placeholder="Masukkan nama lengkap" 
                               value="{{ isset($triple->nama) ? $triple->nama : old('nama') }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>2. Tempat lahir</label>
                        <input type="text" 
                               class="form-control" 
                               name="tempat_lahir" 
                               placeholder="Masukkan tempat lahir" 
                               value="{{ isset($triple->tempat_lahir) ? $triple->tempat_lahir : old('tempat_lahir') }}">
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>3. Tanggal Lahir</label>
                        <input type="date" 
                               class="form-control" 
                               name="tanggal_lahir" 
                               value="{{ isset($triple->tanggal_lahir) ? $triple->tanggal_lahir->format('Y-m-d') : old('tanggal_lahir') }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>4. Pekerjaan</label>
                        <div class="d-flex">
                            <div class="form-check mr-3">
                                <input type="radio" class="form-check-input" name="pekerjaan" value="1" 
                                       {{ isset($triple->pekerjaan) && $triple->pekerjaan == 1 ? 'checked' : '' }}>
                                <label class="form-check-label">Belum bekerja</label>
                            </div>
                            <div class="form-check mr-3">
                                <input type="radio" class="form-check-input" name="pekerjaan" value="2" 
                                       {{ isset($triple->pekerjaan) && $triple->pekerjaan == 2 ? 'checked' : '' }}>
                                <label class="form-check-label">PNS</label>
                            </div>
                            <div class="form-check mr-3">
                                <input type="radio" class="form-check-input" name="pekerjaan" value="3" 
                                       {{ isset($triple->pekerjaan) && $triple->pekerjaan == 3 ? 'checked' : '' }}>
                                <label class="form-check-label">Swasta</label>
                            </div>
                            <div class="form-check mr-3">
                                <input type="radio" class="form-check-input" name="pekerjaan" value="4" 
                                       {{ isset($triple->pekerjaan) && $triple->pekerjaan == 4 ? 'checked' : '' }}>
                                <label class="form-check-label">Pedagang</label>
                            </div>
                            <div class="form-check">
                                <input type="radio" class="form-check-input" name="pekerjaan" value="5" 
                                       {{ isset($triple->pekerjaan) && $triple->pekerjaan == 5 ? 'checked' : '' }}>
                                <label class="form-check-label">Lainnya</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>5. Status perkawinan</label>
                        <div class="d-flex">
                            <div class="form-check mr-3">
                                <input type="radio" class="form-check-input" name="status_kawin" value="1" 
                                       {{ isset($triple->status_kawin) && $triple->status_kawin == 1 ? 'checked' : '' }}>
                                <label class="form-check-label">Kawin</label>
                            </div>
                            <div class="form-check mr-3">
                                <input type="radio" class="form-check-input" name="status_kawin" value="2" 
                                       {{ isset($triple->status_kawin) && $triple->status_kawin == 2 ? 'checked' : '' }}>
                                <label class="form-check-label">Cerai hidup</label>
                            </div>
                            <div class="form-check mr-3">
                                <input type="radio" class="form-check-input" name="status_kawin" value="3" 
                                       {{ isset($triple->status_kawin) && $triple->status_kawin == 3 ? 'checked' : '' }}>
                                <label class="form-check-label">Cerai mati</label>
                            </div>
                            <div class="form-check">
                                <input type="radio" class="form-check-input" name="status_kawin" value="4" 
                                       {{ isset($triple->status_kawin) && $triple->status_kawin == 4 ? 'checked' : '' }}>
                                <label class="form-check-label">Belum kawin</label>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="form-group">
                        <label>6. Status GPA</label>
                        <div class="row">
                            <!-- Gravida -->
                            <div class="col-md-4">
                                <label>Gravida</label>
                                <input type="number" 
                                       name="gravida" 
                                       class="form-control" 
                                       placeholder="0" 
                                       min="0" 
                                       value="{{ isset($triple->gravida) ? $triple->gravida : old('gravida') }}">
                            </div>
                            <!-- Partus -->
                            <div class="col-md-4">
                                <label>Partus</label>
                                <input type="number" 
                                       name="partus" 
                                       class="form-control" 
                                       placeholder="0" 
                                       min="0" 
                                       value="{{ isset($triple->partus) ? $triple->partus : old('partus') }}">
                            </div>
                            <!-- Abortus -->
                            <div class="col-md-4">
                                <label>Abortus</label>
                                <input type="number" 
                                       name="abortus" 
                                       class="form-control" 
                                       placeholder="0" 
                                       min="0" 
                                       value="{{ isset($triple->abortus) ? $triple->abortus : old('abortus') }}">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>7. Umur kehamilan</label>
                        <div class="row">
                            <div class="col-md-12">
                                <input type="number" 
                                       name="umur_kehamilan" 
                                       class="form-control" 
                                       placeholder="0" 
                                       min="0" 
                                       value="{{ isset($triple->umur_kehamilan) ? $triple->umur_kehamilan : old('umur_kehamilan') }}">
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="form-group">
                        <label>8. Taksiran persalinan</label>
                        <div class="row">
                            <div class="col-md-12">
                                <input type="text" 
                                       name="taksiran_kehamilan" 
                                       class="form-control" 
                                       placeholder="masukkan taksiran kehamilan" 
                                       value="{{ isset($triple->taksiran_kehamilan) ? $triple->taksiran_kehamilan : old('taksiran_kehamilan') }}">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>9. Nama puskesmas</label>
                        <div class="row">
                            <div class="col-md-12">
                                <input type="text" 
                                       name="nama_puskesmas" 
                                       class="form-control" 
                                       placeholder="masukkan nama puskesmas" 
                                       value="{{ isset($triple->nama_puskesmas) ? $triple->nama_puskesmas : old('nama_puskesmas') }}">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>10. Kode specimen</label>
                        <div class="row">
                            <div class="col-md-12">
                                <input type="text" 
                                       name="kode_specimen" 
                                       class="form-control" 
                                       placeholder="masukkan kode specimen" 
                                       value="{{ isset($triple->kode_specimen) ? $triple->kode_specimen : old('kode_specimen') }}">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>11. No Telp/Hp</label>
                        <div class="row">
                            <div class="col-md-12">
                                <input type="number" 
                                       name="no_hp" 
                                       class="form-control" 
                                       placeholder="masukkan no hp" 
                                       value="{{ isset($triple->no_hp) ? $triple->no_hp : old('no_hp') }}">
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="form-group">
                        <label>12. Umur ibu</label>
                        <div class="row align-items-center">
                            <div class="col-md-10">
                                <input type="text" 
                                       class="form-control" 
                                       name="umur_ibu" 
                                       placeholder="masukkan umur ibu" 
                                       value="{{ isset($triple->umur_ibu) ? $triple->umur_ibu : old('umur_ibu') }}">
                            </div>
                            <div class="col-auto">
                                <p class="mb-0">Tahun</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>13. Alamat</label>
                        <div class="row">
                            <div class="col-md-12">
                                <input type="text" 
                                       name="alamat" 
                                       class="form-control" 
                                       placeholder="masukkan alamat" 
                                       value="{{ isset($triple->alamat) ? $triple->alamat : old('alamat') }}">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>14. Pendidikan terakhir</label>
                        <div class="d-flex">
                            <!-- SD -->
                            <div class="form-check mr-3">
                                <input type="radio" 
                                       class="form-check-input" 
                                       name="pendidikan" 
                                       value="1" 
                                       {{ isset($triple->pendidikan) && $triple->pendidikan == 1 ? 'checked' : '' }}>
                                <label class="form-check-label">SD</label>
                            </div>
                            <!-- SMTP -->
                            <div class="form-check mr-3">
                                <input type="radio" 
                                       class="form-check-input" 
                                       name="pendidikan" 
                                       value="2" 
                                       {{ isset($triple->pendidikan) && $triple->pendidikan == 2 ? 'checked' : '' }}>
                                <label class="form-check-label">SMTP</label>
                            </div>
                            <!-- SMTA -->
                            <div class="form-check mr-3">
                                <input type="radio" 
                                       class="form-check-input" 
                                       name="pendidikan" 
                                       value="3" 
                                       {{ isset($triple->pendidikan) && $triple->pendidikan == 3 ? 'checked' : '' }}>
                                <label class="form-check-label">SMTA</label>
                            </div>
                            <!-- PT -->
                            <div class="form-check">
                                <input type="radio" 
                                       class="form-check-input" 
                                       name="pendidikan" 
                                       value="4" 
                                       {{ isset($triple->pendidikan) && $triple->pendidikan == 4 ? 'checked' : '' }}>
                                <label class="form-check-label">PT</label>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>

        </div>
        <div class="form-section">
            <h3>Data Klinis dan Diagnostik</h3>
            <div class="form-group">
                <label>1. Apakah pernah mengalami gejala-gejala Hepatitis:</label>
                <div class="d-flex align-items-center mb-2">
                    <div class="form-check mr-3">
                        <input type="radio" 
                               name="gejala_hepatitis" 
                               value="1" 
                               class="form-check-input" 
                               id="hepatitis-ya" 
                               {{ isset($triple->gejala_hepatitis) && $triple->gejala_hepatitis == 1 ? 'checked' : '' }}>
                        <label class="form-check-label" for="hepatitis-ya">Ya</label>
                    </div>
                    <div class="form-check">
                        <input type="radio" 
                               name="gejala_hepatitis" 
                               value="0" 
                               class="form-check-input" 
                               id="hepatitis-tidak" 
                               {{ isset($triple->gejala_hepatitis) && $triple->gejala_hepatitis == 0 ? 'checked' : '' }}>
                        <label class="form-check-label" for="hepatitis-tidak">Tidak</label>
                    </div>
                </div>
                
                <!-- Detail Gejala -->
                <div id="detail-gejala" style="{{ isset($triple->gejala_hepatitis) && $triple->gejala_hepatitis == 1 ? '' : 'display: none;' }}">
                    <div class="mb-2">
                        <label>Bila ya, gejalanya:</label>
                    </div>
                    <div class="form-group">
                        <label>Urine berwarna gelap (seperti teh):</label>
                        <input type="text" 
                               name="gejala_urine_gelap" 
                               class="form-control" 
                               placeholder="Jelaskan..." 
                               value="{{ isset($triple->gejala_urine_gelap) ? $triple->gejala_urine_gelap : old('gejala_urine_gelap') }}">
                    </div>
                    <div class="form-group">
                        <label>Mata/kuku/kulit kuning:</label>
                        <input type="text" 
                               name="gejala_kuning" 
                               class="form-control" 
                               placeholder="Jelaskan..." 
                               value="{{ isset($triple->gejala_kuning) ? $triple->gejala_kuning : old('gejala_kuning') }}">
                    </div>
                    <div class="form-group">
                        <label>Gejala Lainnya:</label>
                        <textarea name="gejala_lainnya" 
                                  class="form-control" 
                                  rows="3" 
                                  placeholder="Jelaskan gejala lainnya...">{{ isset($triple->gejala_lainnya) ? $triple->gejala_lainnya : old('gejala_lainnya') }}</textarea>
                    </div>
                </div>
            </div>
            <div class="form-group" id="pertanyaan-2" style="display: none;">
                <label>2. Apakah pernah test Hepatitis B sebelumnya?</label>
                <div class="d-flex align-items-center mb-2">
                    <div class="form-check mr-3">
                        <input type="radio" 
                               name="test_hepatitis" 
                               value="1" 
                               class="form-check-input" 
                               id="test-ya" 
                               {{ isset($triple->test_hepatitis) && $triple->test_hepatitis == 1 ? 'checked' : '' }}>
                        <label class="form-check-label" for="test-ya">Ya</label>
                    </div>
                    <div class="form-check">
                        <input type="radio" 
                               name="test_hepatitis" 
                               value="0" 
                               class="form-check-input" 
                               id="test-tidak" 
                               {{ isset($triple->test_hepatitis) && $triple->test_hepatitis == 0 ? 'checked' : '' }}>
                        <label class="form-check-label" for="test-tidak">Tidak</label>
                    </div>
                </div>
                
                <div id="detail-test" style="{{ isset($triple->test_hepatitis) && $triple->test_hepatitis == 1 ? '' : 'display: none;' }}">
                    <label for="lokasi">Dimana:</label>
                    <input type="text" 
                           id="lokasi" 
                           name="lokasi_tes" 
                           class="form-control" 
                           placeholder="Masukkan lokasi tes" 
                           value="{{ isset($triple->lokasi_tes) ? $triple->lokasi_tes : old('lokasi_tes') }}"><br>
                    <label for="tanggalTes">Kapan:</label>
                    <input type="date" 
                           id="tanggalTes" 
                           name="tanggal_tes" 
                           class="form-control" 
                           value="{{ isset($triple->tanggal_tes) ? $triple->tanggal_tes : old('tanggal_tes') }}"><br>
                    <label>Hasil Tes:</label>
                    <ul>
                        <li>HBsAg: <input type="text" name="HBsAg" class="form-control" placeholder="Hasil" value="{{ isset($triple->HBsAg) ? $triple->HBsAg : old('HBsAg') }}"></li>
                        <li>Anti HBs: <input type="text" name="anti_hbs" class="form-control" placeholder="Hasil" value="{{ isset($triple->anti_hbs) ? $triple->anti_hbs : old('anti_hbs') }}"></li>
                        <li>Anti HBC: <input type="text" name="anti_hbc" class="form-control" placeholder="Hasil" value="{{ isset($triple->anti_hbc) ? $triple->anti_hbc : old('anti_hbc') }}"></li>
                        <li>SGPT/ALT: <input type="text" name="sgpt" class="form-control" placeholder="Hasil" value="{{ isset($triple->sgpt) ? $triple->sgpt : old('sgpt') }}"></li>
                        <li>Anti Hbe: <input type="text" name="anti_hbe" class="form-control" placeholder="Hasil" value="{{ isset($triple->anti_hbe) ? $triple->anti_hbe : old('anti_hbe') }}"></li>
                        <li>HBeAg: <input type="text" name="hbeag" class="form-control" placeholder="Hasil" value="{{ isset($triple->hbeag) ? $triple->hbeag : old('hbeag') }}"></li>
                        <li>HBV DNA: <input type="text" name="hbv_dna" class="form-control" placeholder="Hasil" value="{{ isset($triple->hbv_dna) ? $triple->hbv_dna : old('hbv_dna') }}"></li>
                    </ul>
                </div>
                
                <div class="form-group">
                    <label>3. Apakah pernah menerima transfusi darah atau produk darah?</label>
                    <div class="d-flex align-items-center mb-2">
                        <div class="form-check mr-3">
                            <input type="radio" 
                                   name="transfusi_darah" 
                                   value="1" 
                                   class="form-check-input" 
                                   id="transfusi-ya" 
                                   {{ isset($triple->transfusi_darah) && $triple->transfusi_darah == 1 ? 'checked' : '' }}>
                            <label class="form-check-label" for="transfusi-ya">Ya</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" 
                                   name="transfusi_darah" 
                                   value="0" 
                                   class="form-check-input" 
                                   id="transfusi-tidak" 
                                   {{ isset($triple->transfusi_darah) && $triple->transfusi_darah == 0 ? 'checked' : '' }}>
                            <label class="form-check-label" for="transfusi-tidak">Tidak</label>
                        </div>
                    </div>
                    <div id="detail-transfusi" style="{{ isset($triple->transfusi_darah) && $triple->transfusi_darah == 1 ? '' : 'display: none;' }}">
                        <label for="kapanTransfusi">Bila ya, kapan:</label>
                        <input type="text" 
                               id="kapanTransfusi" 
                               name="kapan_transfusi" 
                               class="form-control" 
                               placeholder="Kapan" 
                               value="{{ isset($triple->kapan_transfusi) ? $triple->kapan_transfusi : old('kapan_transfusi') }}">
                    </div>
                </div>
                <div class="form-group">
                    <label>4. Apakah pernah menjalani hemodialisa/cuci darah?</label>
                    <div class="d-flex align-items-center mb-2">
                        <div class="form-check mr-3">
                            <input type="radio" 
                                   name="hemodialisa" 
                                   value="1" 
                                   class="form-check-input" 
                                   id="hemodialisa-ya" 
                                   {{ isset($triple->hemodialisa) && $triple->hemodialisa == 1 ? 'checked' : '' }}>
                            <label class="form-check-label" for="hemodialisa-ya">Ya</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" 
                                   name="hemodialisa" 
                                   value="0" 
                                   class="form-check-input" 
                                   id="hemodialisa-tidak" 
                                   {{ isset($triple->hemodialisa) && $triple->hemodialisa == 0 ? 'checked' : '' }}>
                            <label class="form-check-label" for="hemodialisa-tidak">Tidak</label>
                        </div>
                    </div>
                    <div id="detail-hemodialisa" style="{{ isset($triple->hemodialisa) && $triple->hemodialisa == 1 ? '' : 'display: none;' }}">
                        <label for="kapanHemodialisa">Bila ya, kapan:</label>
                        <input type="text" 
                               id="kapanHemodialisa" 
                               name="kapan_hemodialisa" 
                               class="form-control" 
                               placeholder="Kapan" 
                               value="{{ isset($triple->kapan_hemodialisa) ? $triple->kapan_hemodialisa : old('kapan_hemodialisa') }}">
                    </div>
                </div>
                
                <div class="form-group">
                    <label>5. Berapa banyak pasangan seksual sebelum perkawinan sekarang?</label>
                    <input type="number" 
                           name="jmlh_pasangan_seks" 
                           class="form-control" 
                           value="{{ isset($triple->jmlh_pasangan_seks) ? $triple->jmlh_pasangan_seks : old('jmlh_pasangan_seks') }}" 
                           placeholder="Masukkan jumlah pasangan seksual">
                </div>
                
                <div class="form-group">
                    <label>6. Apakah pernah menggunakan narkoba suntik?</label>
                    <div class="d-flex align-items-center mb-2">
                        <div class="form-check mr-3">
                            <input type="radio" 
                                   name="narkoba" 
                                   value="1" 
                                   class="form-check-input" 
                                   id="narkoba-ya" 
                                   {{ isset($triple->narkoba) && $triple->narkoba == 1 ? 'checked' : '' }}>
                            <label class="form-check-label" for="narkoba-ya">Ya</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" 
                                   name="narkoba" 
                                   value="0" 
                                   class="form-check-input" 
                                   id="narkoba-tidak" 
                                   {{ isset($triple->narkoba) && $triple->narkoba == 0 ? 'checked' : '' }}>
                            <label class="form-check-label" for="narkoba-tidak">Tidak</label>
                        </div>
                    </div>
                    <div id="detail-narkoba" style="{{ isset($triple->narkoba) && $triple->narkoba == 1 ? '' : 'display: none;' }}">
                        <label for="kapannarkoba">Bila ya, kapan:</label>
                        <input type="text" 
                               id="kapannarkoba" 
                               name="kapan_narkoba" 
                               class="form-control" 
                               placeholder="Kapan" 
                               value="{{ isset($triple->kapan_narkoba) ? $triple->kapan_narkoba : old('kapan_narkoba') }}">
                    </div>
                </div>  
                <div class="form-group">
                    <label>7. Apakah pernah mendapat vaksinasi Hepatitis B?</label>
                    <div class="d-flex align-items-center mb-2">
                        <div class="form-check mr-3">
                            <input type="radio" 
                                   name="vaksin" 
                                   value="1" 
                                   class="form-check-input" 
                                   id="vaksin-ya" 
                                   {{ isset($triple->vaksin) && $triple->vaksin == 1 ? 'checked' : '' }}>
                            <label class="form-check-label" for="vaksin-ya">Ya</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" 
                                   name="vaksin" 
                                   value="0" 
                                   class="form-check-input" 
                                   id="vaksin-tidak" 
                                   {{ isset($triple->vaksin) && $triple->vaksin == 0 ? 'checked' : '' }}>
                            <label class="form-check-label" for="vaksin-tidak">Tidak</label>
                        </div>
                    </div>
                    <div id="detail-vaksin" style="{{ isset($triple->vaksin) && $triple->vaksin == 1 ? '' : 'display: none;' }}">
                        <label for="kapanvaksin">Bila ya, kapan:</label>
                        <input type="text" 
                               id="kapanvaksin" 
                               name="kapan_vaksin" 
                               class="form-control" 
                               placeholder="Kapan" 
                               value="{{ isset($triple->kapan_vaksin) ? $triple->kapan_vaksin : old('kapan_vaksin') }}">
                    </div>
                </div>
                
                <div class="form-group" id="pertanyaan-8" style="{{ isset($triple->vaksin) && $triple->vaksin == 1 ? '' : 'display: none;' }}">
                    <label>8. Bila sudah mendapat vaksinasi Hepatitis B, berapa kali?</label>
                    <div class="d-flex align-items-center mb-2">
                        <div class="form-check mr-3">
                            <input type="radio" 
                                   name="jmlh_vaksin" 
                                   value="1" 
                                   class="form-check-input" 
                                   id="jmlh_vaksin-1x"
                                   {{ isset($triple->jmlh_vaksin) && $triple->jmlh_vaksin == 1 ? 'checked' : '' }}>
                            <label class="form-check-label" for="jmlh_vaksin-1x">1x</label>
                        </div>
                        <div class="form-check mr-3">
                            <input type="radio" 
                                   name="jmlh_vaksin" 
                                   value="2" 
                                   class="form-check-input" 
                                   id="jmlh_vaksin-2x"
                                   {{ isset($triple->jmlh_vaksin) && $triple->jmlh_vaksin == 2 ? 'checked' : '' }}>
                            <label class="form-check-label" for="jmlh_vaksin-2x">2x</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" 
                                   name="jmlh_vaksin" 
                                   value="3" 
                                   class="form-check-input" 
                                   id="jmlh_vaksin-3x"
                                   {{ isset($triple->jmlh_vaksin) && $triple->jmlh_vaksin == 3 ? 'checked' : '' }}>
                            <label class="form-check-label" for="jmlh_vaksin-3x">3x</label>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label>9. Apakah anda tinggal serumah/pernah tinggal serumah dengan penderita hep B?</label>
                    <div class="d-flex align-items-center mb-2">
                        <div class="form-check mr-3">
                            <input type="radio" 
                                   name="tinggal_serumah" 
                                   value="1" 
                                   class="form-check-input" 
                                   id="tinggal_serumah-ya"
                                   {{ isset($triple->tinggal_serumah) && $triple->tinggal_serumah == 1 ? 'checked' : '' }}>
                            <label class="form-check-label" for="tinggal_serumah-ya">Ya</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" 
                                   name="tinggal_serumah" 
                                   value="0" 
                                   class="form-check-input" 
                                   id="tinggal_serumah-tidak"
                                   {{ isset($triple->tinggal_serumah) && $triple->tinggal_serumah == 0 ? 'checked' : '' }}>
                            <label class="form-check-label" for="tinggal_serumah-tidak">Tidak</label>
                        </div>
                    </div>
                    <div id="detail-tinggal_serumah" style="{{ isset($triple->tinggal_serumah) && $triple->tinggal_serumah == 1 ? '' : 'display: none;' }}">
                        <label for="kapanTinggal">Bila ya, kapan:</label>
                        <input type="text" 
                               id="kapanTinggal" 
                               name="kapan_tinggal_serumah" 
                               class="form-control" 
                               placeholder="Kapan" 
                               value="{{ isset($triple->kapan_tinggal_serumah) ? $triple->kapan_tinggal_serumah : old('kapan_tinggal_serumah') }}">
                        
                        <label for="hubungan">Apa hubungan anda dengan penderita hepatitis B tsb?</label>
                        <div class="d-flex align-items-center mb-2">
                            <div class="form-check mr-3">
                                <input type="radio" 
                                       name="hubungan_hepatitis" 
                                       value="1" 
                                       class="form-check-input" 
                                       id="hubungan-pasangan"
                                       {{ isset($triple->hubungan_hepatitis) && $triple->hubungan_hepatitis == 1 ? 'checked' : '' }}>
                                <label class="form-check-label" for="hubungan-pasangan">Pasangan</label>
                            </div>
                            <div class="form-check">
                                <input type="radio" 
                                       name="hubungan_hepatitis" 
                                       value="2" 
                                       class="form-check-input" 
                                       id="hubungan-lainnya"
                                       {{ isset($triple->hubungan_hepatitis) && $triple->hubungan_hepatitis == 2 ? 'checked' : '' }}>
                                <label class="form-check-label" for="hubungan-lainnya">Lainnya</label>
                            </div>
                        </div>
                        <input type="text" 
                               id="hubunganDetail" 
                               name="hubungan_detail" 
                               class="form-control" 
                               placeholder="Jelaskan jika lainnya" 
                               style="{{ isset($triple->hubungan_hepatitis) && $triple->hubungan_hepatitis == 2 ? '' : 'display: none;' }}"
                               value="{{ isset($triple->hubungan_detail) ? $triple->hubungan_detail : old('hubungan_detail') }}">
                    </div>
                </div>
                <div class="form-group">
                    <label>10. Apakah pernah test HIV sebelumnya?</label>
                    <div class="d-flex align-items-center mb-2">
                        <div class="form-check mr-3">
                            <input type="radio" 
                                   name="test_hiv" 
                                   value="1" 
                                   class="form-check-input" 
                                   id="test_hiv-ya"
                                   {{ isset($triple->test_hiv) && $triple->test_hiv == 1 ? 'checked' : '' }}>
                            <label class="form-check-label" for="test_hiv-ya">Ya</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" 
                                   name="test_hiv" 
                                   value="0" 
                                   class="form-check-input" 
                                   id="test_hiv-tidak"
                                   {{ isset($triple->test_hiv) && $triple->test_hiv == 0 ? 'checked' : '' }}>
                            <label class="form-check-label" for="test_hiv-tidak">Tidak</label>
                        </div>
                    </div>
                    <div id="detail-hiv" style="{{ isset($triple->test_hiv) && $triple->test_hiv == 1 ? '' : 'display: none;' }}">
                        <label for="hasilHiv">a. Bila ya, bagaimana hasilnya?</label>
                        <div class="d-flex align-items-center mb-2">
                            <div class="form-check mr-3">
                                <input type="radio" 
                                       name="hasil_hiv" 
                                       value="1" 
                                       class="form-check-input" 
                                       id="hasil-reaktif"
                                       {{ isset($triple->hasil_hiv) && $triple->hasil_hiv == 1 ? 'checked' : '' }}>
                                <label class="form-check-label" for="hasil-reaktif">Reaktif</label>
                            </div>
                            <div class="form-check">
                                <input type="radio" 
                                       name="hasil_hiv" 
                                       value="2" 
                                       class="form-check-input" 
                                       id="hasil-nonreaktif"
                                       {{ isset($triple->hasil_hiv) && $triple->hasil_hiv == 2 ? 'checked' : '' }}>
                                <label class="form-check-label" for="hasil-nonreaktif">Non Reaktif</label>
                            </div>
                        </div>
                
                        <div id="reaktif-detail" style="{{ isset($triple->hasil_hiv) && $triple->hasil_hiv == 1 ? '' : 'display: none;' }}">
                            <label for="cd4Check">b. Bila reaktif, apakah pernah pemeriksaan CD4?</label>
                            <div class="d-flex align-items-center mb-2">
                                <div class="form-check mr-3">
                                    <input type="radio" 
                                           name="cd4_check" 
                                           value="1" 
                                           class="form-check-input" 
                                           id="cd4-ya"
                                           {{ isset($triple->cd4_check) && $triple->cd4_check == 1 ? 'checked' : '' }}>
                                    <label class="form-check-label" for="cd4-ya">Ya</label>
                                </div>
                                <div class="form-check">
                                    <input type="radio" 
                                           name="cd4_check" 
                                           value="0" 
                                           class="form-check-input" 
                                           id="cd4-tidak"
                                           {{ isset($triple->cd4_check) && $triple->cd4_check == 0 ? 'checked' : '' }}>
                                    <label class="form-check-label" for="cd4-tidak">Tidak</label>
                                </div>
                            </div>
                            <div id="kapan-cd4" style="{{ isset($triple->cd4_check) && $triple->cd4_check == 1 ? '' : 'display: none;' }}">
                                <label for="kapancd4">Bila ya, dimana:</label>
                                <input type="text" 
                                       id="kapancd4" 
                                       name="dimana_cd4" 
                                       class="form-control" 
                                       placeholder="Dimana" 
                                       value="{{ isset($triple->dimana_cd4) ? $triple->dimana_cd4 : old('dimana_cd4') }}">
                            </div>
                            <div id="cd4-detail" style="{{ isset($triple->cd4_check) && $triple->cd4_check == 1 ? '' : 'display: none;' }}">
                                <label>c. Bila ya, bagaimana hasilnya?</label>
                                <div class="d-flex align-items-center mb-2">
                                    <div class="form-check mr-3">
                                        <input type="radio" 
                                               name="hasil_cd4" 
                                               value="1" 
                                               class="form-check-input" 
                                               id="cd4-low"
                                               {{ isset($triple->hasil_cd4) && $triple->hasil_cd4 == 1 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="cd4-low">≤ 350 sel/ml</label>
                                    </div>
                                    <div class="form-check">
                                        <input type="radio" 
                                               name="hasil_cd4" 
                                               value="2" 
                                               class="form-check-input" 
                                               id="cd4-high"
                                               {{ isset($triple->hasil_cd4) && $triple->hasil_cd4 == 2 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="cd4-high">> 350 sel/ml</label>
                                    </div>
                                </div>
                            </div>
                
                            <label for="arvCheck">d. Apakah sudah mendapat ARV?</label>
                            <div class="d-flex align-items-center mb-2">
                                <div class="form-check mr-3">
                                    <input type="radio" 
                                           name="arv_check" 
                                           value="1" 
                                           class="form-check-input" 
                                           id="arv-ya"
                                           {{ isset($triple->arv_check) && $triple->arv_check == 1 ? 'checked' : '' }}>
                                    <label class="form-check-label" for="arv-ya">Ya</label>
                                </div>
                                <div class="form-check">
                                    <input type="radio" 
                                           name="arv_check" 
                                           value="0" 
                                           class="form-check-input" 
                                           id="arv-tidak"
                                           {{ isset($triple->arv_check) && $triple->arv_check == 0 ? 'checked' : '' }}>
                                    <label class="form-check-label" for="arv-tidak">Tidak</label>
                                </div>
                            </div>
                            <div id="detail-arv" style="{{ isset($triple->arv_check) && $triple->arv_check == 1 ? '' : 'display: none;' }}">
                                <label for="kapanarv">Bila ya, kapan:</label>
                                <input type="date" 
                                       id="kapanArv" 
                                       name="kapan_arv" 
                                       class="form-control" 
                                       value="{{ isset($triple->kapan_arv) ? $triple->kapan_arv : old('kapan_arv') }}">
                            </div>
                        </div>
                    </div>
                </div>                

                <div class="form-group">
                    <label>11. Apakah anda pernah menderita gejala PMS dalam 1 bulan terakhir?</label>
                    <div class="d-flex align-items-center mb-2">
                        <div class="form-check mr-3">
                            <input type="radio" 
                                   name="gejala_pms" 
                                   value="1" 
                                   class="form-check-input" 
                                   id="pms-ya"
                                   {{ isset($triple->gejala_pms) && $triple->gejala_pms == 1 ? 'checked' : '' }}>
                            <label class="form-check-label" for="pms-ya">Ya</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" 
                                   name="gejala_pms" 
                                   value="0" 
                                   class="form-check-input" 
                                   id="pms-tidak"
                                   {{ isset($triple->gejala_pms) && $triple->gejala_pms == 0 ? 'checked' : '' }}>
                            <label class="form-check-label" for="pms-tidak">Tidak</label>
                        </div>
                    </div>
                    <div id="detail-pms" style="{{ isset($triple->gejala_pms) && $triple->gejala_pms == 1 ? '' : 'display: none;' }}">
                        <label for="kapanpms">Bila ya, kapan:</label>
                        <input type="date" 
                               id="kapan-pms" 
                               name="kapan_pms" 
                               class="form-control" 
                               value="{{ isset($triple->kapan_pms) ? $triple->kapan_pms : old('kapan_pms') }}">
                    </div>
                </div>
            </div>
            <div class="text-right mt-4">
                @if (isset($triple))
                <a href="{{ route('triple.eliminasi.admin') }}" type="button" class="btn btn-secondary mr-2" style="font-size: 20px">Kembali</a>
            @else
                <a href="{{ route('skrining.ilp') }}" type="button" class="btn btn-secondary mr-2" style="font-size: 20px">Kembali</a>
            @endif
            
                <button type="submit" class="btn btn-primary" style="font-size: 20px">Kirim</button>
            </div>
    </form>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const gejalaRadios = document.getElementsByName('gejala_hepatitis');
            const detailGejala = document.getElementById('detail-gejala');
            const pertanyaan2 = document.getElementById('pertanyaan-2');

            gejalaRadios.forEach(radio => {
                radio.addEventListener('change', function() {
                    if (this.value === '1') {
                        detailGejala.style.display = 'block';
                        pertanyaan2.style.display = 'block';
                    } else if (this.value === '0') {
                        detailGejala.style.display = 'none';
                        pertanyaan2.style.display = 'block';
                    }
                });
            });

            const testRadios = document.getElementsByName('test_hepatitis');
            const detailTest = document.getElementById('detail-test');

            testRadios.forEach(radio => {
                radio.addEventListener('change', function() {
                    if (this.value === '1') {
                        detailTest.style.display = 'block';
                    } else if (this.value === '0') {
                        detailTest.style.display = 'none';
                    }
                });
            });
            const transfusiRadios = document.getElementsByName('transfusi_darah');
            const detailTransfusi = document.getElementById('detail-transfusi');

            transfusiRadios.forEach(radio => {
                radio.addEventListener('change', function() {
                    if (this.value === '1') {
                        detailTransfusi.style.display = 'block';
                    } else if (this.value === '0') {
                        detailTransfusi.style.display = 'none';
                    }
                });
            });


            const hemodialisaRadios = document.getElementsByName('hemodialisa');
            const detailHemodialisa = document.getElementById('detail-hemodialisa');

            hemodialisaRadios.forEach(radio => {
                radio.addEventListener('change', function() {
                    if (this.value === '1') {
                        detailHemodialisa.style.display = 'block';
                    } else if (this.value === '0') {
                        detailHemodialisa.style.display = 'none';
                    }
                });
            });
            const narkobaRadios = document.getElementsByName('narkoba');
            const detailNarkoba = document.getElementById('detail-narkoba');

            narkobaRadios.forEach(radio => {
                radio.addEventListener('change', function() {
                    if (this.value === '1') {
                        detailNarkoba.style.display = 'block';
                    } else if (this.value === '0') {
                        detailNarkoba.style.display = 'none';
                    }
                });
            });
            const vaksinRadios = document.getElementsByName('vaksin');
            const detailVaksin = document.getElementById('detail-vaksin');
            const pertanyaan8 = document.getElementById('pertanyaan-8');
            const pertanyaan9 = document.getElementById('pertanyaan-9');

            vaksinRadios.forEach(radio => {
                radio.addEventListener('change', function() {
                    if (this.value === '1') { // Jika "Ya"
                        detailVaksin.style.display = 'block';
                        pertanyaan8.style.display = 'block';
                        pertanyaan9.style.display = 'block';
                    } else if (this.value === '0') { // Jika "Tidak"
                        detailVaksin.style.display = 'none';
                        pertanyaan8.style.display = 'none';
                        pertanyaan9.style.display = 'block'; // Tetap tampilkan nomor 9
                    }
                });
            });

            const serumahRadios = document.getElementsByName('tinggal_serumah');
            const detailSerumah = document.getElementById('detail-tinggal_serumah');
            const pertanyaan10 = document.getElementById('pertanyaan-10');
            const hubunganRadios = document.getElementsByName('hubungan_hepatitis');
            const hubunganDetail = document.getElementById('hubunganDetail');

            serumahRadios.forEach(radio => {
                radio.addEventListener('change', function() {
                    if (this.value === '1') { // Jika "Ya"
                        detailSerumah.style.display = 'block';
                        pertanyaan10.style.display = 'block'; // Tetap tampilkan pertanyaan 10
                    } else if (this.value === '0') { // Jika "Tidak"
                        detailSerumah.style.display = 'none';
                        pertanyaan10.style.display = 'block'; // Tampilkan langsung pertanyaan 10
                    }
                });
            });

            hubunganRadios.forEach(radio => {
                radio.addEventListener('change', function() {
                    hubunganDetail.style.display = this.value === '2' ? 'block' : 'none';
                });
            });
            const testHivRadios = document.getElementsByName('test_hiv');
            const detailHiv = document.getElementById('detail-hiv');
            const hasilHivRadios = document.getElementsByName('hasil_hiv');
            const reaktifDetail = document.getElementById('reaktif-detail');
            const cd4CheckRadios = document.getElementsByName('cd4_check');
            const arvCheckRadios = document.getElementsByName('arv_check');
            const pmsCheckRadios = document.getElementsByName('gejala_pms');
            const cd4Detail = document.getElementById('cd4-detail');
            const arvDetail = document.getElementById('detail-arv');
            const pmsDetail = document.getElementById('detail-pms');
            const cd4Kapan = document.getElementById('kapan-cd4');
            const pmsKapan = document.getElementById('kapan-pms');

            testHivRadios.forEach(radio => {
                radio.addEventListener('change', function() {
                    if (this.value === '1') { // Jika "Ya"
                        detailHiv.style.display = 'block';
                    } else {
                        detailHiv.style.display = 'none';
                        reaktifDetail.style.display = 'none';
                        cd4Detail.style.display = 'none';
                    }
                });
            });

            hasilHivRadios.forEach(radio => {
                radio.addEventListener('change', function() {
                    reaktifDetail.style.display = this.value === '1' ? 'block' : 'none';
                });
            });

            cd4CheckRadios.forEach(radio => {
                radio.addEventListener('change', function() {
                    cd4Detail.style.display = this.value === '1' ? 'block' : 'none';
                    cd4Kapan.style.display = this.value === '1' ? 'block' : 'none';
                });
            });
            arvCheckRadios.forEach(radio => {
                radio.addEventListener('change', function() {
                    arvDetail.style.display = this.value === '1' ? 'block' : 'none';

                });
            });
            pmsCheckRadios.forEach(radio => {
                radio.addEventListener('change', function() {
                    pmsDetail.style.display = this.value === '1' ? 'block' : 'none';

                });
            });

        });
    </script>

@endsection
