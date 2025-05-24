<!-- Modal Add Action -->
<div class="modal fade" style="z-index: 1050;" id="addActionModal" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header bg-primary">

                <h5 class="modal-title" id="exampleModalLabel">TINDAKAN POLI APOTEK</h5>

                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-apotikel="Close"></button>
            </div>

            <div class="modal-body">
                <form id="addPatientForm" action="" method="POST" class="px-3">
                    @csrf
                    @if ($routeName === 'action.apotik.index')
                        <input type="hidden" name="tipe" id="tipe" value="poli-umum">
                    @elseif($routeName === 'action.apotik.gigi.index')
                        <input type="hidden" name="tipe" id="tipe" value="poli-gigi">
                    @elseif($routeName === 'action.apotik.kia.index')
                        <input type="hidden" name="tipe" id="tipe" value="poli-kia">
                    @elseif($routeName === 'action.apotik.kb.index')
                        <input type="hidden" name="tipe" id="tipe" value="poli-kb">
                    @else
                        <input type="hidden" name="tipe" id="tipe" value="ruang-tindakan">
                    @endif
                    <div class="row">
                        <div class="col-4">
                            <h5>Detail Pasien</h5>
                            <div id="patientDetails"
                                style="display:none; margin-top: 10px; padding: 10px; border-radius: 5px;">
                                <p><strong>N I K</strong> : <span id="displayNIK"></span></p>
                                <p><strong>Nama Pasien</strong> : <span id="displayName"></span></p>
                                <p><strong>Umur</strong> : <span id="displayAge"></span></p>
                                <p><strong>Telepon/WA</strong> : <span id="displayPhone"></span></p>
                                <p><strong>Alamat</strong> : <span id="displayAddress"></span></p>
                                <p><strong>Darah</strong> : <span id="displayBlood"></span></p>
                                <p><strong>Nomor RM</strong> : <span id="displayRmNumber"></span></p>
                            </div>
                        </div>
                        <div class="row col-8">
                            <div class="col-12">
                                <div class="row g-2">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="nik">Cari Pasien</label>
                                            <div class="input-group">
                                                <input type="text" hidden id="idAction" name="idAction"
                                                    value="">
                                                <input readonly type="text" class="form-control" id="nik"
                                                    name="nik" placeholder="NIK" required>
                                                <div class="input-group-append">
                                                    <button class="btn btn-primary" type="button" id="btnCariNIK"
                                                        data-bs-toggle="modal" data-bs-target="#modalPasienApotik">
                                                        Cari
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="tanggal">Tanggal</label>
                                            <input type="date" class="form-control" id="tanggal" name="tanggal"
                                                placeholder="Pilih Tanggal" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="doctor">Dokter</label>
                                            <select class="form-control" id="doctor" name="doctor" disabled>
                                                <option value="" disabled selected>Pilih Dokter</option>
                                                @foreach ($dokter as $item)
                                                    <option value="{{ $item['name'] }}">{{ $item['name'] }}</option>
                                                @endforeach

                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="card">
                                            <div class="card-header font-weight-bold p-2">Verifikasi Awal Resep :</div>
                                            <div class="card-body row p-2">
                                                <div class="col-md-6"><input type="checkbox" name="verifikasi_awal[]"
                                                        value="Benar Pasien" /> Benar Pasien</div>
                                                <div class="col-md-6"><input type="checkbox" name="verifikasi_awal[]"
                                                        value="Benar Waktu Pemberian" /> Benar Waktu Pemberian</div>
                                                <div class="col-md-6"><input type="checkbox" name="verifikasi_awal[]"
                                                        value="Benar Obat" /> Benar Obat</div>
                                                <div class="col-md-6"><input type="checkbox" name="verifikasi_awal[]"
                                                        value="Tidak Ada Duplikasi" /> Tidak Ada Duplikasi</div>
                                                <div class="col-md-6"><input type="checkbox" name="verifikasi_awal[]"
                                                        value="Benar Dosis" /> Benar Dosis</div>
                                                <div class="col-md-6"><input type="checkbox" name="verifikasi_awal[]"
                                                        value="Tidak Ada Interaksi Obat" /> Tidak Ada Interaksi Obat
                                                </div>
                                                <div class="col-md-6"><input type="checkbox" name="verifikasi_awal[]"
                                                        value="Benar Rute" /> Benar Rute</div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="card">
                                            <div class="card-header font-weight-bold p-2">Verifikasi Akhir Resep :
                                            </div>
                                            <div class="card-body row p-2">
                                                <div class="col-md-6"><input type="checkbox"
                                                        name="verifikasi_akhir[]" value="Benar Pasien" /> Benar Pasien
                                                </div>
                                                <div class="col-md-6"><input type="checkbox"
                                                        name="verifikasi_akhir[]" value="Benar Waktu Pemberian" />
                                                    Benar Waktu Pemberian</div>
                                                <div class="col-md-6"><input type="checkbox"
                                                        name="verifikasi_akhir[]" value="Benar Obat" /> Benar Obat
                                                </div>
                                                <div class="col-md-6"><input type="checkbox"
                                                        name="verifikasi_akhir[]" value="Benar Informasi" /> Benar
                                                    Informasi</div>
                                                <div class="col-md-6"><input type="checkbox"
                                                        name="verifikasi_akhir[]" value="Benar Dosis" /> Benar Dosis
                                                </div>
                                                <div class="col-md-6"><input type="checkbox"
                                                        name="verifikasi_akhir[]" value="Benar Dokumentasi" /> Benar
                                                    Dokumentasi</div>
                                                <div class="col-md-6"><input type="checkbox"
                                                        name="verifikasi_akhir[]" value="Benar Rute" /> Benar Rute
                                                </div>
                                                <div class="col-md-6"><input type="checkbox"
                                                        name="verifikasi_akhir[]" value="Cek Kadaluarsa Obat" /> Cek
                                                    Kadaluarsa Obat</div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="card">
                                            <div class="card-header font-weight-bold p-2">Pemberian Informasi Obat :
                                            </div>
                                            <div class="card-body row p-2">
                                                <div class="col-md-6"><input type="checkbox" name="informasi_obat[]"
                                                        value="Nama Obat" /> Nama Obat</div>
                                                <div class="col-md-6"><input type="checkbox" name="informasi_obat[]"
                                                        value="Kontra Indikasi" /> Kontra Indikasi</div>
                                                <div class="col-md-6"><input type="checkbox" name="informasi_obat[]"
                                                        value="Sediaan" /> Sediaan</div>
                                                <div class="col-md-6"><input type="checkbox" name="informasi_obat[]"
                                                        value="Stabilitas" /> Stabilitas</div>
                                                <div class="col-md-6"><input type="checkbox" name="informasi_obat[]"
                                                        value="Dosis" /> Dosis</div>
                                                <div class="col-md-6"><input type="checkbox" name="informasi_obat[]"
                                                        value="Efek Samping" /> Efek Samping</div>
                                                <div class="col-md-6"><input type="checkbox" name="informasi_obat[]"
                                                        value="Cara Pakai" /> Cara Pakai</div>
                                                <div class="col-md-6"><input type="checkbox" name="informasi_obat[]"
                                                        value="Interaksi" /> Interaksi</div>
                                                <div class="col-md-6"><input type="checkbox" name="informasi_obat[]"
                                                        value="Indikasi" /> Indikasi</div>
                                                <div class="col-md-6"><input type="checkbox" name="informasi_obat[]"
                                                        value="Lain-Lain" /> Lain-Lain</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="col-md-8">
                                            <label for="alkohol" style="color: rgb(19, 11, 241);">DIAGNOSA</label>
                                            <select class="form-control" id="diagnosaEdit" name="diagnosa[]"
                                                disabled>
                                                <option value="" disabled selected>pilih</option>
                                                @foreach ($diagnosa as $item)
                                                    <option value="{{ $item->id }}">
                                                        {{ $item->name }} - {{ $item->icd10 }}
                                                    </option>
                                                @endforeach
                                            </select>

                                        </div>
                                    </div>


                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-3">
                        {{-- <div class="col-md-12" style="margin-bottom: 15px;">
                            <label for="obat" style="color: rgb(19, 11, 241);">Obat</label>
                            <textarea class="form-control" id="obat" name="obat" readonly placeholder="Obat"></textarea>
                        </div> --}}


                        <!--<div class="col-md-12">-->
                        <!--    <label for="update_obat" style="color: rgb(19, 11, 241);">Update Obat</label>-->
                        <!--    <textarea class="form-control" id="update_obat" name="update_obat" placeholder="Update Obat"></textarea>-->
                        <!--</div>-->
                        <div class="col-md-12">
                            <div id="addActionObat" class="px-3">

                                <input type="hidden" name="medications" id="medicationsData">
                                <div class="row mt-3">
                                    <!-- Kode Obat -->
                                    <div class="col-md-4" style="margin-bottom: 15px;">
                                        <label for="code_obat" style="color: rgb(19, 11, 241);">Kode dan Nama
                                            Obat</label>
                                        <select class="form-control" id="code_obat" name="code_obat[]">
                                            <option value="" disabled selected>pilih</option>
                                            @foreach ($obats as $item)
                                                <option value="{{ $item->id }}">
                                                    {{ $item->name }} - {{ $item->code }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!-- Sediaan Obat -->
                                    <div class="col-md-4" style="margin-bottom: 15px;">
                                        <label for="shape" style="color: rgb(19, 11, 241);">Sediaan</label>
                                        <select class="form-control" id="shape" name="shape[]">
                                            <option value="1">Tablet</option>
                                            <option value="2">Botol</option>
                                            <option value="3">Pcs</option>
                                            <option value="4">Suppositoria</option>
                                            <option value="5">Ovula</option>
                                            <option value="6">Drop</option>
                                            <option value="7">Tube</option>
                                            <option value="8">Pot</option>
                                            <option value="9">Injeksi</option>
                                        </select>
                                    </div>

                                    <!-- Alergi Obat -->
                                    <div class="col-md-4" style="margin-bottom: 15px;">
                                        <label for="alergi" style="color: rgb(19, 11, 241);">Alergi Obat</label>
                                        <input type="text" class="form-control" id="alergi" name="alergi[]"
                                            placeholder="Alergi obat apa saja">
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-4" style="margin-bottom: 15px;">
                                        <label for="jumlah" style="color: rgb(19, 11, 241);">Jumlah</label>
                                        <input type="text" class="form-control" id="jumlah" name="jumlah[]"
                                            placeholder="Jumlah">
                                    </div>

                                    <div class="col-md-4" style="margin-bottom: 15px;">
                                        <label for="stok" style="color: rgb(19, 11, 241);">Stok</label>
                                        <input type="text" class="form-control" id="stok" name="stok[]"
                                            readonly placeholder="Stok">
                                    </div>

                                    <div class="col-md-4" style="margin-bottom: 15px;">
                                        <label for="gangguan_ginjal" style="color: rgb(19, 11, 241);">Gangguan Fungsi
                                            Hati/Ginjal</label>
                                        <input type="text" class="form-control" id="gangguan_ginjal"
                                            name="gangguan_ginjal[]" placeholder="Detail Gangguan Hati/Ginjal">
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-4" style="margin-bottom: 15px;">
                                        <label for="dosis" style="color: rgb(19, 11, 241);">Dosis</label>
                                        <input type="text" class="form-control" id="dosis" name="dosis[]"
                                            placeholder="Dosis">
                                    </div>

                                    <div class="col-md-4" style="margin-bottom: 15px;">
                                        <label for="hamil" style="color: rgb(19, 11, 241);">Hamil ?</label>
                                        <input type="text" class="form-control" id="hamil" name="hamil[]"
                                            placeholder="Berapa bulan">
                                    </div>

                                    <div class="col-md-4" style="margin-bottom: 15px;">
                                        <label for="menyusui" style="color: rgb(19, 11, 241);">Menyusui</label>
                                        <select class="form-control" id="menyusui" name="menyusui[]">
                                            <option value="1">Ya</option>
                                            <option value="0">Tidak</option>
                                        </select>
                                    </div>
                                </div>
                                <button type="button" class="btn btn-success" id="addMedicationBtn">Tambah
                                    Obat</button>
                                <!-- Tabel untuk Menampilkan Data Obat yang Ditambahkan -->
                                <table class="table mt-3" id="medicationTable">
                                    <thead>
                                        <tr>
                                            <th>Kode</th>
                                            <th>Nama Obat</th>
                                            <th>Dosis</th>
                                            <th>Jumlah</th>
                                            <th>Bentuk</th>
                                            <th>Stok</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody id="medicationTableBody1">
                                    </tbody>
                                    <tbody id="medicationTableBody">
                                    </tbody>
                                </table>

                                <!-- Tombol untuk Menambah dan Menghapus Obat -->
                                <div class="d-flex justify-content-between">
                                    <button type="button" class="btn btn-danger" id="clearTableBtn">Hapus
                                        Tabel</button>
                                </div>
                                <input type="hidden" id="medicationsData" name="medicationsData">
                            </div>
                        </div>

                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-primary" data-bs-toggle="modal"
                    data-bs-target="#modalPasienApotik">Simpan Data</button>
                </form>
            </div>
        </div>

    </div>

</div>


@include('component.modal-table-pasien-apotik')

<!-- Tambahkan di dalam <head> atau sebelum </body> -->

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function() {
        let obatData = @json($obats); // Ambil data obat dari Laravel
        console.log("Data Obat:", obatData);

        let originalStock = 0; // Simpan stok awal

        $('#code_obat').select2({
            placeholder: "Pilih Obat",
            allowClear: true,
            minimumResultsForSearch: 0
        });


        $('#code_obat').change(function() {
            let selectedId = $(this).val();
            let selectedObat = obatData.find(obat => obat.id == selectedId); // Cari obat berdasarkan ID
            if (selectedObat) {
                originalStock = parseInt(selectedObat.total_stock) || 0; // Pastikan nilai angka
                $('#stok').val(originalStock); // Tampilkan stok awal
                $('#jumlah').val(''); // Reset jumlah saat obat diganti
            } else {
                $('#stok').val('');
                $('#jumlah').val('');
            }
        });

        $('#jumlah').on('input', function() {
            let jumlah = parseInt($(this).val()) || 0; // Ambil nilai jumlah, default 0 jika kosong
            let stokTersisa = originalStock - jumlah; // Hitung stok setelah dikurangi jumlah

            if (jumlah < 0) {
                alert('Jumlah tidak boleh negatif!');
                $(this).val(0);
                stokTersisa = originalStock;
            } else if (stokTersisa < 0) {
                alert('Jumlah melebihi stok yang tersedia!');
                $(this).val(originalStock); // Batasi jumlah maksimal ke stok awal
                stokTersisa = 0;
            }

            $('#stok').val(stokTersisa); // Update stok di input stok
        });
    });
</script>
