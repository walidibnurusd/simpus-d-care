@php
    $diagnosa = App\Models\Diagnosis::all();
    // dd($diagnosa);
@endphp
<style>
    .form-check-input {
        width: 20px !important;
        height: 20px !important;
        cursor: pointer !important;
    }

    .form-check-label {
        font-size: 16px;
        margin-left: 8px;
    }
</style>
<!-- Modal Add Action -->
<div class="modal fade" style="z-index: 1050;" id="editActionModal{{ $action->id }}" tabindex="-1"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                @if ($routeName === 'action.apotik.index')
                    <h5 class="modal-title" id="exampleModalLabel">TINDAKAN POLI UMUM</h5>
                @elseif ($routeName === 'action.apotik.gigi.index')
                    <h5 class="modal-title" id="exampleModalLabel">TINDAKAN POLI GIGI</h5>
                @elseif ($routeName === 'action.apotik.kia.index')
                    <h5 class="modal-title" id="exampleModalLabel">TINDAKAN POLI KIA</h5>
                @elseif ($routeName === 'action.apotik.kb.index')
                    <h5 class="modal-title" id="exampleModalLabel">TINDAKAN POLI KB</h5>
                @else
                    <h5 class="modal-title" id="exampleModalLabel">TINDAKAN UGD</h5>
                @endif
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form id="addPatientForm{{ $action->id }}" class="px-3">
                    @csrf
                    @if ($routeName === 'action.apotik.index')
                        <input type="hidden" name="tipe" value="poli-umum">
                    @elseif($routeName === 'action.apotik.gigi.index')
                        <input type="hidden" name="tipe" value="poli-gigi">
                    @elseif($routeName === 'action.apotik.kia.index')
                        <input type="hidden" name="tipe" value="poli-kia">
                    @elseif($routeName === 'action.apotik.kb.index')
                        <input type="hidden" name="tipe" value="poli-kb">
                    @else
                        <input type="hidden" name="tipe" value="ruang-tindakan">
                    @endif
                    <div class="row">
                        <div class="col-4">
                            <h5>Detail Pasien</h5>
                            <div id="patientDetailsEdit" style=" margin-top: 10px; padding: 10px; border-radius: 5px;">
                                <p><strong>N I K</strong> : <span
                                        id="NIK{{ $action->id }}">{{ $action->patient->nik }}</span></p>
                                <p><strong>Nama Pasien</strong> : <span
                                        id="Name{{ $action->id }}">{{ $action->patient->name }}</span></p>
                                {{-- <p><strong>J.Kelamin</strong> : <span id="Gender">{{ $action->patient->genderName->name }}</span></p> --}}
                                <p><strong>Umur</strong> : <span id="Age"></span>
                                    {{ \Carbon\Carbon::parse($action->patient->dob)->age }}</p>
                                <p><strong>Telepon/WA</strong> : <span
                                        id="Phone{{ $action->id }}">{{ $action->patient->phone }}</span></p>
                                <p><strong>Alamat</strong> : <span id="Address">{{ $action->patient->address }}</span>
                                </p>
                                <p><strong>Darah</strong> : <span
                                        id="Blood{{ $action->id }}">{{ $action->patient->blood_type }}</span></p>
                                <p><strong>Nomor RM</strong> : <span
                                        id="RmNumber{{ $action->id }}">{{ $action->patient->no_rm }}</span>
                                </p>
                            </div>

                        </div>

                        <div class="row col-8">
                            <div class="col-12">
                                <input type="text" hidden id="idAction{{ $action->id }}"
                                    name="idAction{{ $action->id }}" value="{{ $action->id }}">
                                <div class="row g-2">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="nik">Cari Pasien</label>
                                            <div class="input-group">
                                                <input readonly type="text" class="form-control"
                                                    id="nikEdit{{ $action->id }}" value="" name="nik"
                                                    placeholder="NIK" required>
                                                <div class="input-group-append">
                                                    <button class="btn btn-primary" type="button" id="btnCariNIK"
                                                        data-bs-toggle="modal" data-bs-target="#modalPasienEdit">
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
                                                value="{{ $action->tanggal }}" placeholder="Pilih Tanggal" required>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="doctor">Dokter</label>
                                            <select class="form-control" id="doctor" name="doctor" required>
                                                <option value="" disabled selected>Pilih Dokter</option>
                                                @foreach ($dokter as $item)
                                                    <option value="{{ $item->name }}"
                                                        {{ $action->doctor == $item->name ? 'selected' : '' }}>
                                                        {{ $item->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    @php
                                        $verifikasi_awal_raw = old('verifikasi_awal', $action->verifikasi_awal ?? []);
                                        $verifikasi_awal = is_array($verifikasi_awal_raw)
                                            ? $verifikasi_awal_raw
                                            : json_decode($verifikasi_awal_raw, true);

                                        $verifikasi_akhir_raw = old(
                                            'verifikasi_akhir',
                                            $action->verifikasi_akhir ?? [],
                                        );
                                        $verifikasi_akhir = is_array($verifikasi_akhir_raw)
                                            ? $verifikasi_akhir_raw
                                            : json_decode($verifikasi_akhir_raw, true);

                                        $informasi_obat_raw = old('informasi_obat', $action->informasi_obat ?? []);
                                        $informasi_obat = is_array($informasi_obat_raw)
                                            ? $informasi_obat_raw
                                            : json_decode($informasi_obat_raw, true);
                                    @endphp


                                    <div class="col-md-12">
                                        <div class="card">
                                            <div class="card-header font-weight-bold p-2">Verifikasi Awal Resep :</div>
                                            <div class="card-body row p-2">
                                                @php
                                                    $verifikasi_awal_list = [
                                                        'Benar Pasien',
                                                        'Benar Waktu Pemberian',
                                                        'Benar Obat',
                                                        'Tidak Ada Duplikasi',
                                                        'Benar Dosis',
                                                        'Tidak Ada Interaksi Obat',
                                                        'Benar Rute',
                                                    ];
                                                @endphp

                                                @foreach ($verifikasi_awal_list as $value)
                                                    <div class="col-md-6 mb-2 d-flex align-items-center">
                                                        <input type="checkbox" name="verifikasi_awal[]"
                                                            value="{{ $value }}"
                                                            {{ in_array($value, $verifikasi_awal ?? []) ? 'checked' : '' }} />
                                                        {{ $value }}
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-12 mt-2">
                                        <div class="card">
                                            <div class="card-header font-weight-bold p-2">Verifikasi Akhir Resep :
                                            </div>
                                            <div class="card-body row p-2">
                                                @php
                                                    $verifikasi_akhir_list = [
                                                        'Benar Pasien',
                                                        'Benar Waktu Pemberian',
                                                        'Benar Obat',
                                                        'Benar Informasi',
                                                        'Benar Dosis',
                                                        'Benar Dokumentasi',
                                                        'Benar Rute',
                                                        'Cek Kadaluarsa Obat',
                                                    ];
                                                @endphp

                                                @foreach ($verifikasi_akhir_list as $value)
                                                    <div class="col-md-6 mb-2 d-flex align-items-center">
                                                        <input type="checkbox" name="verifikasi_akhir[]"
                                                            value="{{ $value }}"
                                                            {{ in_array($value, $verifikasi_akhir ?? []) ? 'checked' : '' }} />
                                                        {{ $value }}
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-12 mt-2">
                                        <div class="card">
                                            <div class="card-header font-weight-bold p-2">Pemberian Informasi Obat :
                                            </div>
                                            <div class="card-body row p-2">
                                                @php
                                                    $informasi_obat_list = [
                                                        'Nama Obat',
                                                        'Kontra Indikasi',
                                                        'Sediaan',
                                                        'Stabilitas',
                                                        'Dosis',
                                                        'Efek Samping',
                                                        'Cara Pakai',
                                                        'Interaksi',
                                                        'Indikasi',
                                                        'Lain-Lain',
                                                    ];
                                                @endphp

                                                @foreach ($informasi_obat_list as $value)
                                                    <div class="col-md-6 mb-2 d-flex align-items-center">
                                                        <input type="checkbox" name="informasi_obat[]"
                                                            value="{{ $value }}"
                                                            {{ in_array($value, $informasi_obat ?? []) ? 'checked' : '' }} />
                                                        {{ $value }}
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="col-md-4">
                                            <label for="diagnosaEditAction"
                                                style="color: rgb(19, 11, 241);">DIAGNOSA</label>
                                            <select class="form-control" id="diagnosaEditAction{{ $action->id }}"
                                                name="diagnosa[]" multiple>
                                                @php
                                                    // Decode JSON if it exists
                                                    $selectedDiagnosa = is_string($action->diagnosa)
                                                        ? json_decode($action->diagnosa, true)
                                                        : $action->diagnosa;
                                                @endphp
                                                @foreach ($diagnosa as $item)
                                                    <option value="{{ $item->id }}"
                                                        {{ in_array($item->id, old('diagnosa', $selectedDiagnosa ?: [])) ? 'selected' : '' }}>
                                                        {{ $item->name }}-{{ $item->icd10 }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    {{-- <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="kunjungan">Kunjungan</label>
                                            <select class="form-control" id="kunjungan" name="kunjungan" required>
                                                <option value="" disabled
                                                    {{ empty($action->kunjungan) ? 'selected' : '' }}>Pilih Jenis
                                                    Kunjungan</option>
                                                <option value="baru"
                                                    {{ $action->kunjungan == 'baru' ? 'selected' : '' }}>Baru</option>
                                                <option value="lama"
                                                    {{ $action->kunjungan == 'lama' ? 'selected' : '' }}>Lama</option>
                                            </select>
                                        </div>
                                    </div> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- <div class="row mt-3">
                        <div class="col-md-12" style="margin-bottom: 15px;">
                            <label for="obat" style="color: rgb(19, 11, 241);">Obat</label>
                            <textarea class="form-control" id="obat" name="obat" readonly placeholder="Obat">{{ old('obat', $action->obat ?? '') }}</textarea>
                        </div>
                        <div class="col-md-12">
                            <label for="update_obat" style="color: rgb(19, 11, 241);">Update Obat</label>
                            <textarea class="form-control" id="update_obat" name="update_obat" placeholder="Update Obat">{{ old('update_obat', $action->update_obat ?? '') }}</textarea>
                        </div>
                    </div> --}}
                    <div class="col-md-12">
                        <div id="addActionObat{{ $action->id }}" class="px-3">

                            <input type="hidden" name="medications" id="medicationsData{{ $action->id }}">
                            <div class="row mt-3">
                                <!-- Kode Obat -->
                                <div class="col-md-4" style="margin-bottom: 15px;">
                                    <label for="code_obat{{ $action->id }}" style="color: rgb(19, 11, 241);">Kode
                                        dan Nama Obat</label>
                                    <select class="form-control" id="code_obat{{ $action->id }}"
                                        name="code_obat[]">
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
                                    <select class="form-control" id="shape{{ $action->id }}" name="shape[]">
                                        <option value="1">Tablet</option>
                                        <option value="2">Botol</option>
                                        <option value="3">Pcs</option>
                                        <option value="4">Suppositoria</option>
                                        <option value="5">Ovula</option>
                                        <option value="6">Drop</option>
                                        <option value="7">Tube</option>
                                        <option value="8">Pot</option>
                                        <option value="9">Injeksi</option>
                                        <option value="10">Kapsul</option>
                                        <option value="11">Ampul</option>
                                        <option value="12">Sachet</option>
                                        <option value="13">Paket</option>
                                        <option value="14">Vial</option>
                                        <option value="15">Bungkus</option>
                                        <option value="16">Strip</option>
                                        <option value="17">Test</option>
                                        <option value="18">Lbr</option>
                                        <option value="19">Tabung</option>
                                        <option value="20">Buah</option>
                                        <option value="21">Lembar</option>
                                    </select>
                                </div>

                                <!-- Alergi Obat -->
                                <div class="col-md-4" style="margin-bottom: 15px;">
                                    <label for="alergi" style="color: rgb(19, 11, 241);">Alergi Obat</label>
                                    <input type="text" class="form-control" id="alergi{{ $action->id }}"
                                        name="alergi[]" placeholder="Alergi obat apa saja">
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-4" style="margin-bottom: 15px;">
                                    <label for="jumlah" style="color: rgb(19, 11, 241);">Jumlah</label>
                                    <input type="text" class="form-control" id="jumlah{{ $action->id }}"
                                        name="jumlah[]" placeholder="Jumlah">
                                </div>

                                <div class="col-md-4" style="margin-bottom: 15px;">
                                    <label for="stok" style="color: rgb(19, 11, 241);">Stok</label>
                                    <input type="text" class="form-control" id="stok{{ $action->id }}"
                                        name="stok[]" readonly placeholder="Stok">
                                </div>

                                <div class="col-md-4" style="margin-bottom: 15px;">
                                    <label for="gangguan_ginjal" style="color: rgb(19, 11, 241);">Gangguan Fungsi
                                        Hati/Ginjal</label>
                                    <input type="text" class="form-control"
                                        id="gangguan_ginjal{{ $action->id }}" name="gangguan_ginjal[]"
                                        placeholder="Detail Gangguan Hati/Ginjal">
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-4" style="margin-bottom: 15px;">
                                    <label for="dosis" style="color: rgb(19, 11, 241);">Dosis</label>
                                    <input type="text" class="form-control" id="dosis{{ $action->id }}"
                                        name="dosis[]" placeholder="Dosis">
                                </div>

                                <div class="col-md-4" style="margin-bottom: 15px;">
                                    <label for="hamil" style="color: rgb(19, 11, 241);">Hamil ?</label>
                                    <input type="text" class="form-control" id="hamil{{ $action->id }}"
                                        name="hamil[]" placeholder="Berapa bulan">
                                </div>

                                <div class="col-md-4" style="margin-bottom: 15px;">
                                    <label for="menyusui" style="color: rgb(19, 11, 241);">Menyusui</label>
                                    <select class="form-control" id="menyusui{{ $action->id }}" name="menyusui[]">
                                        <option value="" disabled selected>Pilih</option>
                                        <option value="1">Ya</option>
                                        <option value="0">Tidak</option>
                                    </select>
                                </div>
                            </div>
                            <button type="button" class="btn btn-success"
                                id="addMedicationBtn{{ $action->id }}">Tambah Obat</button>
                            <!-- Tabel untuk Menampilkan Data Obat yang Ditambahkan -->
                            <table class="table mt-3" id="medicationTable{{ $action->id }}">
                                <thead>
                                    <tr>
                                        <th>Kode</th>
                                        <th>Nama Obat</th>
                                        <th>Dosis</th>
                                        <th>Jumlah</th>
                                        <th>Bentuk</th>
                                        {{-- <th>Stok</th> --}}
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="medicationTableBody1{{ $action->id }}">
                                    @forelse ($action->actionObats as $item)
                                        <tr>
                                            <td>{{ $item->obat->code }}</td>
                                            <td>{{ $item->obat->name }}</td>
                                            <td>{{ $item->dose }}</td>
                                            <td>{{ $item->amount }}</td>
                                            <td>
                                                @php
                                                    $shapes = [
                                                        1 => 'Tablet',
                                                        2 => 'Botol',
                                                        3 => 'Pcs',
                                                        4 => 'Suppositoria',
                                                        5 => 'Ovula',
                                                        6 => 'Drop',
                                                        7 => 'Tube',
                                                        8 => 'Pot',
                                                        9 => 'Injeksi',
                                                        10 => 'Kapsul',
                                                        11 => 'Ampul',
                                                        12 => 'Sachet',
                                                        13 => 'Paket',
                                                        14 => 'Vial',
                                                        15 => 'Bungkus',
                                                        16 => 'Strip',
                                                        17 => 'Test',
                                                        18 => 'Lbr',
                                                        19 => 'Tabung',
                                                        20 => 'Buah',
                                                        21 => 'Lembar',
                                                    ];
                                                @endphp

                                                {{ $shapes[$item->shape] ?? 'Tidak diketahui' }}
                                            </td>

                                            {{-- <td>{{ $item->obat->total_stock }}</td> --}}
                                            <td><button class="btn btn-danger btn-sm"
                                                    onclick="removeRow(this)">Hapus</button></td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7">Tidak ada data obat</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                                <tbody id="medicationTableBody{{ $action->id }}">
                                </tbody>
                            </table>

                            <!-- Tombol untuk Menambah dan Menghapus Obat -->
                            <div class="d-flex justify-content-between">
                                <button type="button" class="btn btn-danger" id="clearTableBtn">Hapus Tabel</button>
                            </div>
                            <input type="hidden" id="medicationsData{{ $action->id }}" name="medicationsData">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary" id="btnSubmit">Simpan Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>


@include('component.modal-table-edit-pasien')
<!-- jQuery harus PERTAMA -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- CSS -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css" />

<!-- JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.full.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function() {
        let obatData = @json($obats); // Ambil data obat dari Laravel
        console.log("Data Obat:", obatData);

        let originalStock = 0; // Simpan stok awal

        $('#code_obat{{ $action->id }}').select2({
            placeholder: "Pilih Obat",
            allowClear: true,
            minimumResultsForSearch: 0,
            dropdownParent: $('#editActionModal{{ $action->id }}')
        });

        $('#code_obat{{ $action->id }}').change(function() {
            let selectedId = $(this).val();
            let selectedObat = obatData.find(obat => obat.id == selectedId); // Cari obat berdasarkan ID

            console.log("Obat Terpilih:", selectedObat, "ID:", selectedId);

            if (selectedObat) {
                originalStock = parseInt(selectedObat.total_stock) || 0; // Pastikan nilai angka
                console.log(" stock Obat Terpilih:", originalStock);
                $('#stok{{ $action->id }}').val(originalStock); // Tampilkan stok awal
                $('#jumlah{{ $action->id }}').val(''); // Reset jumlah saat obat diganti
            } else {
                $('#stok{{ $action->id }}').val('');
                $('#jumlah{{ $action->id }}').val('');
            }
        });

        $('#jumlah{{ $action->id }}').on('input', function() {
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

            $('#stok{{ $action->id }}').val(stokTersisa); // Update stok di input stok
        });
    });
</script>
<script>
    var nikValue = "{{ $action->patient->nik ?? '' }}";
    document.getElementById('nikEdit{{ $action->id }}').value = nikValue;
    console.log(nikValue);
</script>
<script>
    $(document).ready(function() {
        $('#diagnosaEditAction{{ $action->id }}').select2({
            placeholder: "Pilih",
            allowClear: true,
            minimumResultsForSearch: 0
        });
    });
    $(document).ready(function() {
        $('#tindakanEdit').select2({
            placeholder: "Pilih",
            allowClear: true,
            minimumResultsForSearch: 0
        });
    });
</script>

<style>
    .select2-dropdown {
        z-index: 9999 !important;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Attach event listeners dynamically for all modal edit elements
        const allModals = document.querySelectorAll('.modal'); // Semua modal yang memiliki form edit
        allModals.forEach((modal) => {
            const selectPenyakitDulu = modal.querySelector('[id^="riwayat_penyakit_dulu_edit"]');
            const selectPenyakitKeluarga = modal.querySelector(
                '[id^="riwayat_penyakit_keluarga_edit"]');

            // Container untuk input "lainnya"
            const lainnyaContainer = modal.querySelector('#penyakit_lainnya_container_edit');
            const lainnyaTextarea = modal.querySelector('#penyakit_lainnya_edit');

            const lainnyaKeluargaContainer = modal.querySelector(
                '#penyakit_lainnya_keluarga_container_edit');
            const lainnyaKeluargaTextarea = modal.querySelector('#penyakit_lainnya_keluarga_edit');

            if (selectPenyakitDulu) {
                // Event listener untuk 'riwayat_penyakit_dulu_edit'
                selectPenyakitDulu.addEventListener('change', function() {
                    toggleLainnya(selectPenyakitDulu, lainnyaContainer, lainnyaTextarea);
                });
            }

            if (selectPenyakitKeluarga) {
                // Event listener untuk 'riwayat_penyakit_keluarga_edit'
                selectPenyakitKeluarga.addEventListener('change', function() {
                    toggleLainnya(selectPenyakitKeluarga, lainnyaKeluargaContainer,
                        lainnyaKeluargaTextarea);
                });
            }

            // Populate form data on modal show
            modal.addEventListener('show.bs.modal', function() {
                populateFormData(
                    modal,
                    selectPenyakitDulu,
                    lainnyaContainer,
                    lainnyaTextarea,
                    'riwayat_penyakit_dulu'
                );
                populateFormData(
                    modal,
                    selectPenyakitKeluarga,
                    lainnyaKeluargaContainer,
                    lainnyaKeluargaTextarea,
                    'riwayat_penyakit_keluarga'
                );
            });
        });
    });

    // Fungsi toggle "lainnya"
    function toggleLainnya(select, container, textarea) {
        if (select.value === 'lainnya') {
            container.style.display = 'block';
            textarea.required = true;
        } else {
            container.style.display = 'none';
            textarea.value = '';
            textarea.required = false;
        }
    }

    // Populate data berdasarkan modal
    function populateFormData(modal, selectElement, container, textarea, field) {
        const actionId = modal.getAttribute('id').replace('editActionModal', ''); // Ambil ID tindakan dari modal
        const actions = {!! json_encode($actions ?? []) !!}; // Semua data tindakan dari Laravel

        const actionData = actions.find((action) => action.id.toString() === actionId);

        if (actionData && actionData[field]) {
            selectElement.value = actionData[field];
            toggleLainnya(selectElement, container, textarea);

            if (actionData[field] === 'lainnya' && actionData[`${field}_lainnya`]) {
                textarea.value = actionData[`${field}_lainnya`];
            }
        }
    }
    document.getElementById("addMedicationBtn{{ $action->id }}").addEventListener("click", function() {
        let rowNumber = 0; // d
        const codeElement = document.getElementById("code_obat{{ $action->id }}");
        const shape = document.getElementById("shape{{ $action->id }}");
        const menyusuiSelect = document.getElementById("menyusui{{ $action->id }}");
        const menyusuiValue = menyusuiSelect.value; // value terpilih
        const menyusuiText = menyusuiSelect.options[menyusuiSelect.selectedIndex].text; // label teks terpilih


        const selectedOption = codeElement.options[codeElement.selectedIndex];
        const selectedOptionShape = shape.options[shape.selectedIndex];

        const medicationName = selectedOption.text;
        const medicationCode = selectedOption.value;
        const shapeName = selectedOptionShape.text;

        const alergi = document.getElementById("alergi{{ $action->id }}").value;
        const jumlah = document.getElementById("jumlah{{ $action->id }}").value;
        const stok = document.getElementById("stok{{ $action->id }}").value;
        const gangguanGinjal = document.getElementById("gangguan_ginjal{{ $action->id }}").value;
        const dosis = document.getElementById("dosis{{ $action->id }}").value;
        const hamil = document.getElementById("hamil{{ $action->id }}").value;


        // Validasi sederhana (opsional)
        if (!jumlah || !dosis || !medicationCode) {
            Swal.fire({
                icon: 'warning',
                title: 'Peringatan!',
                text: 'Harap lengkapi data obat sebelum menambahkan.',
                confirmButtonText: 'OK'
            });
            return;
        }

        const tableBody = document.getElementById("medicationTableBody{{ $action->id }}");
        console.log(tableBody);

        const newRow = tableBody.insertRow();

        newRow.setAttribute("data-medication-code", medicationCode);
        newRow.innerHTML = `
            <td>${medicationName}</td>
            <td>${medicationName}</td>
            <td>${dosis}</td>
            <td>${jumlah}</td>
            <td>${shapeName}</td>
            <td><button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this)">Hapus</button></td>
            <td  style="display: none;">${stok}</td>
             <td style="display: none;">${rowNumber}</td>
            <td style="display: none;">${menyusuiValue}</td>
            <td style="display: none;">${gangguanGinjal}</td>
            <td style="display: none;">${alergi}</td>
            <td style="display: none;">${hamil}</td>
        `;
        rowNumber++;
    });
    $('#addPatientForm{{ $action->id }}').submit(function(e) {
        e.preventDefault();

        const rows = document.getElementById("medicationTableBody{{ $action->id }}").rows;
        const medicationsData = [];

        for (let i = 0; i < rows.length; i++) {
            const row = rows[i];
            medicationsData.push({
                number: row.cells[7].textContent.trim(),
                name: row.cells[1].textContent.trim(),
                dose: row.cells[2].textContent.trim(),
                quantity: row.cells[3].textContent.trim(),
                shape: row.cells[4].textContent.trim(),
                stock: row.cells[6].textContent.trim(),
                idObat: row.getAttribute("data-medication-code"),
                menyusui: row.cells[8].textContent.trim(),
                gangguan_ginjal: row.cells[9]?.textContent.trim() || '',
                alergi: row.cells[10]?.textContent.trim() || '',
                hamil: row.cells[11]?.textContent.trim() || '',
            });
        }
        console.table(medicationsData);

        let formData = $('#addPatientForm{{ $action->id }}').serialize();
        formData += "&_token=" + $('meta[name="csrf-token"]').attr('content');
        formData += "&medications=" + encodeURIComponent(JSON.stringify(medicationsData));

        const actionId = $('#idAction{{ $action->id }}').val() ?? null;
        const url = actionId ? `/tindakan-apotik/${actionId}` : '/tindakan';

        $.ajax({
            url: url,
            type: 'POST',
            data: formData,
            success: async function(response) {
                await Swal.fire({
                    title: 'Success!',
                    text: response.success || 'Data berhasil disimpan!',
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then(() => {
                    location.reload(); // ⬅ reload halaman setelah tombol OK diklik
                });

                // Reset form dan elemen terkait

                $('#addPatientForm{{ $action->id }}')[0].reset(); // Reset form HTML
                $('#medicationTableBody{{ $action->id }}').empty(); // Kosongkan tabel obat
                $('#diagnosaEdit').val([]).trigger('change');
                $('#code_obat').val([]).trigger('change');
                $('#addActionObat').find('input, select, textarea').each(function() {
                    if (this.type === 'select-one' || this.tagName === 'SELECT') {
                        $(this).val('').trigger('change'); // handle Select2 juga
                    } else {
                        $(this).val('');
                    }
                });


                $('#addPatientForm').find('select.select2').val(null).trigger('change');
                table.ajax.reload(null, false);
                resetPatientDetails
                    (); // Kosongkan dan sembunyikan detail pasien (fungsi harus sudah didefinisikan)
            },
            error: function(xhr) {
                const errorMsg = xhr.responseJSON?.error || "Terjadi kesalahan!";
                Swal.fire({
                    title: 'Error!',
                    text: errorMsg,
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            }
        });
    });

    function removeRow(button) {
        const row = button.closest('tr');
        if (row) row.remove();
    }
</script>
