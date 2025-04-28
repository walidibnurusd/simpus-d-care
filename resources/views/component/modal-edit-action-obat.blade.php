<!-- Modal Add Action -->
<div class="modal fade" style="z-index: 1050;" id="editActionObatModal{{$action->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title" id="exampleModalLabel">TAMBAH OBAT TINDAKAN DOKTER</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-apotikel="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addActionObat" method="POST" class="px-3">
                    @csrf
                    <input type="hidden" name="medications" id="medicationsData{{ $action->id }}">
                    <div class="row mt-3">
                        <!-- Kode Obat -->
                        <div class="col-md-4" style="margin-bottom: 15px;">
                            <label for="code_obat" style="color: rgb(19, 11, 241);">Kode dan Nama Obat</label>
                            <select class="form-control" id="code_obat{{ $action->id }}" name="code_obat[]">
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
                            </select>
                        </div>

                        <!-- Alergi Obat -->
                        <div class="col-md-4" style="margin-bottom: 15px;">
                            <label for="alergi" style="color: rgb(19, 11, 241);">Alergi Obat</label>
                            <input type="text" class="form-control" id="alergi{{ $action->id }}" name="alergi[]" placeholder="Alergi obat apa saja">
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-4" style="margin-bottom: 15px;">
                            <label for="jumlah" style="color: rgb(19, 11, 241);">Jumlah</label>
                            <input type="text" class="form-control" id="jumlah{{ $action->id }}" name="jumlah[]" placeholder="Jumlah">
                        </div>

                        <div class="col-md-4" style="margin-bottom: 15px;">
                            <label for="stok{{ $action->id }}" style="color: rgb(19, 11, 241);">Stok</label>
                            <input type="text" class="form-control" id="stok{{ $action->id }}" name="stok[]" readonly placeholder="Stok">
                        </div>

                        <div class="col-md-4" style="margin-bottom: 15px;">
                            <label for="gangguan_ginjal" style="color: rgb(19, 11, 241);">Gangguan Fungsi Hati/Ginjal</label>
                            <input type="text" class="form-control" id="gangguan_ginjal{{ $action->id }}" name="gangguan_ginjal[]" placeholder="Detail Gangguan Hati/Ginjal">
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-4" style="margin-bottom: 15px;">
                            <label for="dosis" style="color: rgb(19, 11, 241);">Dosis</label>
                            <input type="text" class="form-control" id="dosis{{ $action->id }}" name="dosis[]" placeholder="Dosis">
                        </div>

                        <div class="col-md-4" style="margin-bottom: 15px;">
                            <label for="hamil" style="color: rgb(19, 11, 241);">Hamil ?</label>
                            <input type="text" class="form-control" id="hamil{{ $action->id }}" name="hamil[]" placeholder="Berapa bulan">
                        </div>

                        <div class="col-md-4" style="margin-bottom: 15px;">
                            <label for="menyusui" style="color: rgb(19, 11, 241);">Menyusui</label>
                            <select class="form-control" id="menyusui{{ $action->id }}" name="menyusui[]">
                                <option value="1">Ya</option>
                                <option value="0">Tidak</option>
                            </select>
                        </div>
                    </div>
                    <button type="button" class="btn btn-success" id="addMedicationBtn{{ $action->id }}">Tambah Obat</button>
                    <!-- Tabel untuk Menampilkan Data Obat yang Ditambahkan -->
                    <table class="table mt-3" id="medicationTable">
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
                        <tbody id="medicationTableBody{{ $action->id }}">
                            @forelse ($action->actionObats as $item)
                                <tr>
                                    <td>{{ $item->obat->code }}</td>
                                    <td>{{ $item->obat->name }}</td>
                                    <td>{{ $item->dose }}</td>
                                    <td>{{ $item->amount }}</td>
                                    <td>{{ $item->shape }}</td>
                                    {{-- <td>{{ $item->obat->total_stock }}</td> --}}
                                    <td><button class="btn btn-danger btn-sm" onclick="removeRow(this)">Hapus</button></td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7">Tidak ada data obat</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <!-- Tombol untuk Menambah dan Menghapus Obat -->
                    <div class="d-flex justify-content-between">
                        <button type="button" class="btn btn-danger" id="clearTableBtn">Hapus Tabel</button>
                    </div>
                    <input type="hidden" id="medicationsData{{ $action->id }}" name="medicationsData">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary" id="saveToPreviousModalBtn{{ $action->id }}" data-bs-dismiss="modal">Simpan</button>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.full.min.js"></script>
<script>
    $(document).ready(function () {
        $('#clearTableBtn').click(function () {
        // Empty the table body (remove all rows)
        $('#medicationTableBody').empty();
    });
        let obatData = @json($obats); // Ambil data obat dari Laravel
        let originalStock = 0;

        $('#code_obat{{ $action->id }}').select2({
            placeholder: "Pilih Obat",
            allowClear: true,
            minimumResultsForSearch: 0
        });

        $('#code_obat{{ $action->id }}').change(function () {
            let selectedId = $(this).val();
            let selectedObat = obatData.find(obat => obat.id == selectedId);

            if (selectedObat) {
                originalStock = parseInt(selectedObat.total_stock) || 0;
                $('#stok{{ $action->id }}').val(originalStock);
                $('#jumlah{{ $action->id }}').val('');

                // Set sediaan (shape)
                $('#shape{{ $action->id }}').val(selectedObat.shape).trigger('change');
            } else {
                $('#stok{{ $action->id }}').val('');
                $('#jumlah{{ $action->id }}').val('');
                $('#shape{{ $action->id }}').val('');
            }
        });

        $('#jumlah{{ $action->id }}').on('input', function () {
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

            $('#stok{{ $action->id }}').val(stokTersisa);
        });
        $(document).on('click', '#addMedicationBtn{{ $action->id }}', function () {
    let selectedId = $('#code_obat{{ $action->id }}').val();
    let selectedObat = obatData.find(obat => obat.id == selectedId);

    if (!selectedObat) {
        alert('Silakan pilih obat terlebih dahulu');
        return;
    }

    let jumlah = $('#jumlah{{ $action->id }}').val();
    let shape = $('#shape{{ $action->id }} option:selected').text();
    let dosis = $('#dosis{{ $action->id }}').val();
    let hamil = $('#hamil{{ $action->id }}').val();
    let stok = $('#stok{{ $action->id }}').val();
    let menyusui = $('#menyusui{{ $action->id }}').val();
    let gangguanGinjal = $('#gangguan_ginjal{{ $action->id }}').val();
    let alergi = $('#alergi{{ $action->id }}').val();

    // Validasi input
    if (!jumlah || !dosis) {
        alert('Jumlah dan Dosis harus diisi!');
        return;
    }

    // Buat baris baru
    let row = `
        <tr data-medication-code="${selectedObat.id}">
            <td>${selectedObat.code}</td>
            <td>${selectedObat.name}</td>
            <td>${dosis}</td>
            <td>${jumlah}</td>
            <td>${shape}</td>
            <td style="display: none;">${menyusui}</td>
            <td style="display: none;">${stok}</td>
            <td style="display: none;">${gangguanGinjal}</td>
            <td style="display: none;">${alergi}</td>
            <td style="display: none;">${hamil}</td>
            <td><button class="btn btn-danger btn-sm" onclick="removeRow(this)">Hapus</button></td>
        </tr>
    `;
    $('#medicationTableBody{{ $action->id }}').append(row);

    // Bersihkan form
    $('#code_obat{{ $action->id }}').val('').trigger('change');
    $('#jumlah{{ $action->id }}').val('');
    $('#dosis{{ $action->id }}').val('');
    $('#shape{{ $action->id }}').val('');
    $('#hamil{{ $action->id }}').val('');
    $('#menyusui{{ $action->id }}').val('');
    $('#gangguan_ginjal{{ $action->id }}').val('');
    $('#alergi{{ $action->id }}').val('');
    $('#stok{{ $action->id }}').val('');
});

document.getElementById("saveToPreviousModalBtn{{ $action->id }}").addEventListener("click", function () {
    var rows = document.getElementById("medicationTableBody{{ $action->id }}").rows;
    var medicationsData = [];

    for (var i = 0; i < rows.length; i++) {
        var row = rows[i];

        // Cek apakah jumlah kolom cukup
        if (row.cells.length < 10) continue;

        var medicationData = {
            number: row.cells[0].textContent,
            name: row.cells[1].textContent,
            dose: row.cells[2].textContent,
            quantity: row.cells[3].textContent,
            shape: row.cells[4].textContent,
            menyusui: row.cells[5].textContent,
            stock: row.cells[6].textContent,
            gangguan_ginjal: row.cells[7].textContent,
            alergi: row.cells[8].textContent,
            hamil: row.cells[9].textContent,
            idObat: row.getAttribute("data-medication-code")
        };

        medicationsData.push(medicationData);
    }

    // Simpan ke hidden input dalam bentuk JSON
    document.getElementById("medicationsData{{ $action->id }}").value = JSON.stringify(medicationsData);

    // Debug: tampilkan di console
    console.log(medicationsData);

    // Tutup modal
    $('#editActionObatModal').modal('hide');
});

// Fungsi hapus baris
function removeRow(button) {
    $(button).closest('tr').remove();
}



        // Function to remove row
        window.removeRow = function(button) {
            $(button).closest('tr').remove();
        }
        $('#editPatientForm{{ $action->id }}').submit(async function(e) {
            e.preventDefault();
            let formData = $('#editPatientForm{{ $action->id }}').serialize();
            formData += "&_token=" + $('meta[name="csrf-token"]').attr('content');
            let medicationsData = document.getElementById("medicationsData{{ $action->id }}")
                .value; // Get the JSON string from the hidden input
            formData += "&medications=" + encodeURIComponent(medicationsData);
            let actionId = {{ $action->id }} ?? null;
            let url = actionId ? `/tindakan-edit/${actionId}` : '/tindakan';

            $.ajax({
                url: url,
                type: 'POST',
                data: formData,
                success: async function(response) {
                    // Menampilkan notifikasi sukses
                    await Swal.fire({
                        title: 'Success!',
                        text: response.success || 'Data berhasil diproses!',
                        icon: 'success',
                        confirmButtonText: 'OK'
                    });
                    location.reload();

                },
                error: function(xhr) {
                    console.error(xhr);
                    let errorMsg = xhr.responseJSON?.error || "Terjadi kesalahan!";
                    Swal.fire({
                        title: 'Error!',
                        text: errorMsg,
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }
            });
        });

 
    });
</script>
