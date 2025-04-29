<<<<<<< HEAD
<!-- Modal Add Action -->
<div class="modal fade" style="z-index: 1050;" id="addActionObatModal" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title" id="exampleModalLabel">TAMBAH OBAT TINDAKAN DOKTER</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-apotikel="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addActionObat" method="POST" class="px-3">
                    @csrf
                    <input type="hidden" name="medications" id="medicationsData">
                    <div class="row mt-3">
                        <!-- Kode Obat -->
                        <div class="col-md-4" style="margin-bottom: 15px;">
                            <label for="code_obat" style="color: rgb(19, 11, 241);">Kode dan Nama Obat</label>
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
                            <input type="text" class="form-control" id="stok" name="stok[]" readonly
                                placeholder="Stok">
                        </div>

                        <div class="col-md-4" style="margin-bottom: 15px;">
                            <label for="gangguan_ginjal" style="color: rgb(19, 11, 241);">Gangguan Fungsi
                                Hati/Ginjal</label>
                            <input type="text" class="form-control" id="gangguan_ginjal" name="gangguan_ginjal[]"
                                placeholder="Detail Gangguan Hati/Ginjal">
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
                    <button type="button" class="btn btn-success" id="addMedicationBtn">Tambah Obat</button>
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
                        <tbody id="medicationTableBody">
                        </tbody>
                    </table>

                    <!-- Tombol untuk Menambah dan Menghapus Obat -->
                    <div class="d-flex justify-content-between">
                        <button type="button" class="btn btn-danger" id="clearTableBtn">Hapus Tabel</button>
                    </div>
                    <input type="hidden" id="medicationsData" name="medicationsData">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal" id="saveToPreviousModalBtn"  >Simpan</button>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        let obatData = @json($obats); // Ambil data obat dari Laravel
        let originalStock = 0;

        $('#code_obat').select2({
            placeholder: "Pilih Obat",
            allowClear: true,
            minimumResultsForSearch: 0
        });

        $('#code_obat').change(function () {
            let selectedId = $(this).val();
            let selectedObat = obatData.find(obat => obat.id == selectedId);

            if (selectedObat) {
                originalStock = parseInt(selectedObat.total_stock) || 0;
                $('#stok').val(originalStock);
                $('#jumlah').val('');

                // Set sediaan (shape)
                console.log(selectedObat.shape);
                
                $('#shape').val(selectedObat.shape).trigger('change');
            } else {
                $('#stok').val('');
                $('#jumlah').val('');
                $('#shape').val('');
            }
        });

        $('#jumlah').on('input', function () {
            let jumlah = parseInt($(this).val()) || 0;
            let stokTersisa = originalStock - jumlah;

            if (jumlah < 0) {
                alert('Jumlah tidak boleh negatif!');
                $(this).val(0);
                stokTersisa = originalStock;
            } else if (stokTersisa < 0) {
                alert('Jumlah melebihi stok yang tersedia!');
                $(this).val(originalStock);
                stokTersisa = 0;
            }

            $('#stok').val(stokTersisa);
        });
    });
</script>


<script>
    // let rowNumber = 1;
    // document.getElementById("addMedicationBtn").addEventListener("click", function() {
    //     var codeElement = document.getElementById("code_obat");
    //     var shape = document.getElementById("shape");
    //     var alergi = document.getElementById("alergi").value;
    //     var jumlah = document.getElementById("jumlah").value;
    //     var stok = document.getElementById("stok").value;
    //     var gangguanGinjal = document.getElementById("gangguan_ginjal").value;
    //     var dosis = document.getElementById("dosis").value;
    //     var hamil = document.getElementById("hamil").value;
    //     var menyusui = document.getElementById("menyusui").value;


    //     var selectedOption = codeElement.options[codeElement.selectedIndex];
    //     var selectedOptionShape = shape.options[shape.selectedIndex];
    //     var medicationName = selectedOption.text;
    //     var medicationCode = selectedOption.value;
    //     var shapeName = selectedOptionShape.text;

    //     // Menambahkan row baru ke tabel
    //     var tableBody = document.getElementById("medicationTableBody");
    //     var newRow = tableBody.insertRow();

    //     newRow.innerHTML = `
    //    <td>${rowNumber}</td>
    //     <td>${medicationName}</td>
    //     <td>${dosis}</td>
    //     <td>${jumlah}</td>
    //     <td>${shapeName}</td>
    //     <td>${stok}</td>
    //     <td><button class="btn btn-danger btn-sm" onclick="removeRow(this)">Hapus</button></td>
    // `;
    //     rowNumber
    //     // Clear input fields after adding to the table
    //     document.getElementById("addActionObat").reset();
    // });

    // // Fungsi untuk menghapus row dari tabel
    // function removeRow(button) {
    //     button.closest("tr").remove();
    // }

    // // Fungsi untuk menghapus seluruh tabel
    // document.getElementById("clearTableBtn").addEventListener("click", function() {
    //     var tableBody = document.getElementById("medicationTableBody");
    //     tableBody.innerHTML = '';
    // });

    $(document).ready(function() {
        // Initialize select2 for all relevant elements

        $('#code_obat')
            .select2({
                placeholder: "Pilih",
                allowClear: true,
                minimumResultsForSearch: 0
            });
    });
    document.addEventListener('DOMContentLoaded', function() {

        // Display success message if session has a success
        @if (session('success'))
            Swal.fire({
                title: 'Success!',
                text: "{{ session('success') }}",
                icon: 'success',
                confirmButtonText: 'OK'
            });
        @endif

        // Display error message if validation errors exist
        @if ($errors->any())
            Swal.fire({
                title: 'Error!',
                html: '<ul>' +
                    '@foreach ($errors->all() as $error)' +
                    '<li>{{ $error }}</li>' +
                    '@endforeach' +
                    '</ul>',
                icon: 'error',
                confirmButtonText: 'OK'
            });
        @endif
    });
</script>
=======
<!-- Modal Add Action -->
<div class="modal fade" style="z-index: 1050;" id="addActionObatModal" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title" id="exampleModalLabel">TAMBAH OBAT TINDAKAN DOKTER</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-apotikel="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addActionObat" method="POST" class="px-3">
                    @csrf
                    <input type="hidden" name="medications" id="medicationsData">
                    <div class="row mt-3">
                        <!-- Kode Obat -->
                        <div class="col-md-4" style="margin-bottom: 15px;">
                            <label for="code_obat" style="color: rgb(19, 11, 241);">Kode dan Nama Obat</label>
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
                            <input type="text" class="form-control" id="stok" name="stok[]" readonly
                                placeholder="Stok">
                        </div>

                        <div class="col-md-4" style="margin-bottom: 15px;">
                            <label for="gangguan_ginjal" style="color: rgb(19, 11, 241);">Gangguan Fungsi
                                Hati/Ginjal</label>
                            <input type="text" class="form-control" id="gangguan_ginjal" name="gangguan_ginjal[]"
                                placeholder="Detail Gangguan Hati/Ginjal">
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
                    <button type="button" class="btn btn-success" id="addMedicationBtn">Tambah Obat</button>
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
                        <tbody id="medicationTableBody">
                        </tbody>
                    </table>

                    <!-- Tombol untuk Menambah dan Menghapus Obat -->
                    <div class="d-flex justify-content-between">
                        <button type="button" class="btn btn-danger" id="clearTableBtn">Hapus Tabel</button>
                    </div>
                    <input type="hidden" id="medicationsData" name="medicationsData">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal" id="saveToPreviousModalBtn"  >Simpan</button>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        let obatData = @json($obats); // Ambil data obat dari Laravel
        let originalStock = 0;

        $('#code_obat').select2({
            placeholder: "Pilih Obat",
            allowClear: true,
            minimumResultsForSearch: 0
        });

        $('#code_obat').change(function () {
            let selectedId = $(this).val();
            let selectedObat = obatData.find(obat => obat.id == selectedId);

            if (selectedObat) {
                originalStock = parseInt(selectedObat.total_stock) || 0;
                $('#stok').val(originalStock);
                $('#jumlah').val('');

                // Set sediaan (shape)
                console.log(selectedObat.shape);
                
                $('#shape').val(selectedObat.shape).trigger('change');
            } else {
                $('#stok').val('');
                $('#jumlah').val('');
                $('#shape').val('');
            }
        });

        $('#jumlah').on('input', function () {
            let jumlah = parseInt($(this).val()) || 0;
            let stokTersisa = originalStock - jumlah;

            if (jumlah < 0) {
                alert('Jumlah tidak boleh negatif!');
                $(this).val(0);
                stokTersisa = originalStock;
            } else if (stokTersisa < 0) {
                alert('Jumlah melebihi stok yang tersedia!');
                $(this).val(originalStock);
                stokTersisa = 0;
            }

            $('#stok').val(stokTersisa);
        });
    });
</script>


<script>
    // let rowNumber = 1;
    // document.getElementById("addMedicationBtn").addEventListener("click", function() {
    //     var codeElement = document.getElementById("code_obat");
    //     var shape = document.getElementById("shape");
    //     var alergi = document.getElementById("alergi").value;
    //     var jumlah = document.getElementById("jumlah").value;
    //     var stok = document.getElementById("stok").value;
    //     var gangguanGinjal = document.getElementById("gangguan_ginjal").value;
    //     var dosis = document.getElementById("dosis").value;
    //     var hamil = document.getElementById("hamil").value;
    //     var menyusui = document.getElementById("menyusui").value;


    //     var selectedOption = codeElement.options[codeElement.selectedIndex];
    //     var selectedOptionShape = shape.options[shape.selectedIndex];
    //     var medicationName = selectedOption.text;
    //     var medicationCode = selectedOption.value;
    //     var shapeName = selectedOptionShape.text;

    //     // Menambahkan row baru ke tabel
    //     var tableBody = document.getElementById("medicationTableBody");
    //     var newRow = tableBody.insertRow();

    //     newRow.innerHTML = `
    //    <td>${rowNumber}</td>
    //     <td>${medicationName}</td>
    //     <td>${dosis}</td>
    //     <td>${jumlah}</td>
    //     <td>${shapeName}</td>
    //     <td>${stok}</td>
    //     <td><button class="btn btn-danger btn-sm" onclick="removeRow(this)">Hapus</button></td>
    // `;
    //     rowNumber
    //     // Clear input fields after adding to the table
    //     document.getElementById("addActionObat").reset();
    // });

    // // Fungsi untuk menghapus row dari tabel
    // function removeRow(button) {
    //     button.closest("tr").remove();
    // }

    // // Fungsi untuk menghapus seluruh tabel
    // document.getElementById("clearTableBtn").addEventListener("click", function() {
    //     var tableBody = document.getElementById("medicationTableBody");
    //     tableBody.innerHTML = '';
    // });

    $(document).ready(function() {
        // Initialize select2 for all relevant elements

        $('#code_obat')
            .select2({
                placeholder: "Pilih",
                allowClear: true,
                minimumResultsForSearch: 0
            });
    });
    document.addEventListener('DOMContentLoaded', function() {

        // Display success message if session has a success
        @if (session('success'))
            Swal.fire({
                title: 'Success!',
                text: "{{ session('success') }}",
                icon: 'success',
                confirmButtonText: 'OK'
            });
        @endif

        // Display error message if validation errors exist
        @if ($errors->any())
            Swal.fire({
                title: 'Error!',
                html: '<ul>' +
                    '@foreach ($errors->all() as $error)' +
                    '<li>{{ $error }}</li>' +
                    '@endforeach' +
                    '</ul>',
                icon: 'error',
                confirmButtonText: 'OK'
            });
        @endif
    });
</script>
>>>>>>> 9df8fede466960d27744a11e4cb830e2a9437611
