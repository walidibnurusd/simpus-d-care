@php
    $obats = App\Models\Obat::all();
@endphp

<!-- Modal Edit Action -->
<div class="modal fade" style="z-index: 1050;" id="editPengeluaranObatModal{{ $obat->id }}" tabindex="-1"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title" id="exampleModalLabel">EDIT PENGELUARAN UNIT LAIN</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editPengeluaranObat{{ $obat->id }}"
                    action="{{ route('update-pengeluaran-obat', $obat->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <label for="date" style="color: rgb(19, 11, 241);">Tanggal</label>
                            <input type="date" class="form-control" id="date" name="date"
                                value="{{ $obat->date }}">
                        </div>
                        <div class="col-md-6">
                            <label for="id_obat" style="color: rgb(19, 11, 241);">Kode dan Nama Obat</label>
                            <select class="form-control" id="id_obat_edit" name="id_obat">
                                <option value="" disabled selected>pilih</option>
                                @foreach ($obats as $item)
                                    <option value="{{ $item->id }}" data-shape="{{ $item->shape }}"
                                        data-stock="{{ $item->stock }}"
                                        {{ $item->id == $obat->id_obat ? 'selected' : '' }}>
                                        {{ $item->name }} - {{ $item->code }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-6" style="margin-bottom: 15px;">
                            <label for="unit" style="color: rgb(19, 11, 241);">Nama Unit</label>
                            <select class="form-control" id="unit" name="unit" required>
                                <option value="1">Home Care</option>
                                <option value="2">P3K</option>
                                <option value="3">Pustu</option>
                                <option value="4">Puskel</option>
                                <option value="5">IGD</option>
                                <option value="6">Lab</option>
                                <option value="7">Lansia</option>
                                <option value="8">Poli Gigi</option>
                            </select>
                        </div>
                        <div class="col-md-6" style="margin-bottom: 15px;">
                            <label for="amount" style="color: rgb(19, 11, 241);">Jumlah</label>
                            <input type="text" class="form-control" id="amountEdit" name="amount"
                                placeholder="Jumlah" required value="{{ $obat->amount }}">
                        </div>
                        <div class="col-md-6">
                            <label for="shape" style="color: rgb(19, 11, 241);">Sediaan</label>
                            <select class="form-control" id="shape_edit" name="shape" disabled>
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
                        <div class="col-md-6" style="margin-bottom: 15px;">
                            <label for="stock" style="color: rgb(19, 11, 241);">Stock</label>
                            <input type="text" class="form-control" id="stockEdit" name="stock" disabled>
                        </div>
                        <div class="col-md-12" style="margin-bottom: 15px;">
                            <label for="remarks" style="color: rgb(19, 11, 241);">Keterangan</label>
                            <textarea class="form-control" id="remarks" name="remarks" rows="3">{{ $obat->remarks }}</textarea>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll("form[id^='editPengeluaranObat']").forEach(form => {
            form.addEventListener("submit", function(e) {});
        });

        @if (session('success'))
            Swal.fire({
                title: 'Success!',
                text: "{{ session('success') }}",
                icon: 'success',
                confirmButtonText: 'OK'
            });
        @endif

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
    $(document).ready(function() {
        let originalStock = 0;

        // Initialize Select2 for the obat dropdown
        $('#id_obat_edit').select2({
            placeholder: "Pilih Obat",
            allowClear: true,
            minimumResultsForSearch: 0
        });

        // Function to update the shape and stock fields
        function updateFields() {
            const selectedOption = $('#id_obat_edit option:selected');
            const shapeValue = selectedOption.data('shape'); // Get the shape from the selected option
            const obatId = $('#id_obat_edit').val();

            // Set shape
            if (shapeValue) {
                $('#shape_edit').val(shapeValue).prop('disabled', false); // Enable and set value for shape
                console.log('Shape updated:', shapeValue); // Log if shape is updated
            } else {
                $('#shape_edit').val('').prop('disabled',
                    true); // Disable and clear shape dropdown if no shape found
                console.log('Shape disabled'); // Log if shape is disabled
            }

            // Fetch stock for the selected obat
            if (obatId) {
                $.ajax({
                    url: '/obat/get-stock/' + obatId, // Ensure this route exists and works
                    method: 'GET',
                    success: function(res) {
                        console.log('Stock response:', res); // Log the response from the server

                        if (res && res.stock !== undefined) {
                            originalStock = parseInt(res.stock) || 0; // Set originalStock
                            console.log('Original stock:',
                                originalStock); // Log the original stock value
                            $('#stockEdit').val(
                                originalStock); // Display stockEdit in the input field

                        } else {
                            console.error('Invalid stockEdit response:', res);
                            $('#stockEdit').val(
                                '0'); // If the stockEdit response is invalid, display 0
                        }
                    },
                    error: function() {
                        originalStock = 0;

                        console.error(
                            'Failed to fetch stockEdit'); // Log error if fetching stock fails
                        alert('Gagal mengambil stok obat.');
                    }
                });
            }
        }

        // Trigger when the obat selection changes
        $('#id_obat_edit').change(function() {
            console.log('Obat selection changed');
            updateFields();
        });

        // On page load, set the initial value for shape and stock based on the selected obat
        updateFields();

        // Handle amount input validation
        $('#amountEdit').on('input', function() {
            const amount = parseInt($(this).val()) || 0;


            // Check if amount is valid
            if (amount < 0) {
                alert('Jumlah tidak boleh negatif!');
                $(this).val(0);
                $('#stockEdit').val(originalStock);
                return;
            }

            const remainingStock = originalStock - amount;

            // Check if the amount exceeds the available stock
            if (remainingStock < 0) {
                alert('Jumlah melebihi stok tersedia!');
                $(this).val(originalStock); // Set value back to the stock
                $('#stockEdit').val(0);
                return;
            }

            $('#stockEdit').val(remainingStock); // Update stock field with the remaining stock
        });


    });
</script>
