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
                            <select class="form-control" id="id_obat_edit{{ $obat->id }}" name="id_obat">
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
                            <input type="text" class="form-control" id="amountEdit{{ $obat->id }}"
                                name="amount" placeholder="Jumlah" required value="{{ $obat->amount }}">
                        </div>
                        <div class="col-md-6">
                            <label for="shape" style="color: rgb(19, 11, 241);">Sediaan</label>
                            <select class="form-control" id="shape_edit{{ $obat->id }}" name="shape" disabled>
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
                        <div class="col-md-6" style="margin-bottom: 15px;">
                            <label for="stock" style="color: rgb(19, 11, 241);">Stock</label>
                            <input type="text" class="form-control" id="stockEdit{{ $obat->id }}" name="stock"
                                disabled>
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
        let previousAmount = 0;
        let obatId = 0;
        const obatEdit = {{ $obat->id_obat }};

        // Select2 init
        $('#id_obat_edit{{ $obat->id }}').select2({
            placeholder: "Pilih Obat",
            allowClear: true,
            minimumResultsForSearch: 0,
            dropdownParent: $('#editPengeluaranObatModal{{ $obat->id }}')
        });

        function validateAmountAndUpdateStock() {
            const currentAmount = parseInt($('#amountEdit{{ $obat->id }}').val()) || 0;
            console.log('[validate] currentAmount:', currentAmount, 'previousAmount:', previousAmount,
                'originalStock:', originalStock);

            if (currentAmount < 0) {
                alert('Jumlah tidak boleh negatif!');
                $('#amountEdit{{ $obat->id }}').val(previousAmount);
                $('#stockEdit{{ $obat->id }}').val(originalStock);
                console.log('[validate] Jumlah negatif - reset nilai');
                return;
            }

            // if (currentAmount === previousAmount) {
            //     $('#stockEdit{{ $obat->id }}').val(originalStock);
            //     console.log('[validate] Jumlah tidak berubah - stock tetap:', originalStock);
            //     return;
            // }

            const remainingStock = originalStock - (currentAmount - previousAmount);
            console.log('[validate] remainingStock:', remainingStock);

            if (remainingStock < 0) {
                alert('Jumlah melebihi stok tersedia!');
                $('#amountEdit{{ $obat->id }}').val(previousAmount);
                $('#stockEdit{{ $obat->id }}').val(originalStock);
                console.log('[validate] Melebihi stok - reset nilai');
                return;
            }

            $('#stockEdit{{ $obat->id }}').val(remainingStock);
            console.log('[validate] Stock updated to:', remainingStock);
        }

        function updateFields(callback) {
            const selectedOption = $('#id_obat_edit{{ $obat->id }} option:selected');
            obatId = $('#id_obat_edit{{ $obat->id }}').val();
            const shapeValue = selectedOption.data('shape');
            if (shapeValue) {
                $('#shape_edit{{ $obat->id }}').val(shapeValue).prop('disabled', false);
            } else {
                $('#shape_edit{{ $obat->id }}').val('').prop('disabled', true);
            }

            if (obatId) {
                $.ajax({
                    url: '/obat/get-stock/' + obatId,
                    method: 'GET',
                    success: function(res) {
                        originalStock = parseInt(res.stock) || 0;
                        $('#stockEdit{{ $obat->id }}').val(originalStock);

                        initialAmount = parseInt($('#amountEdit{{ $obat->id }}').val()) || 0;
                        // previousAmount = initialAmount;

                        console.log('[updateFields] Stock:', originalStock, '| initialAmount:',
                            initialAmount);

                        // Jalankan callback setelah AJAX selesai (jika ada)
                        if (typeof callback === 'function') {
                            callback();
                        }
                    },
                    error: function() {
                        originalStock = 0;
                        $('#stockEdit{{ $obat->id }}').val(0);
                        alert('Gagal mengambil stok obat.');

                        if (typeof callback === 'function') {
                            callback();
                        }
                    }
                });
            } else {
                originalStock = 0;
                $('#stockEdit{{ $obat->id }}').val(0);
                if (typeof callback === 'function') {
                    callback();
                }
            }
        }

        $('#id_obat_edit{{ $obat->id }}').change(function() {
            console.log('[event] Obat diubah');
            updateFields(function() {
                console.log(obatId, obatEdit);

                if (obatId != obatEdit) {
                    validateAmountAndUpdateStock();
                }
                // Panggil hanya setelah update selesai
            });

        });

        $('#amountEdit{{ $obat->id }}').on('focus', function() {

            const currentObatId = parseInt(obatId) || 0;
            const currentObatEdit = parseInt(obatEdit) || 0;

            console.log('obatId:', currentObatId, 'obatEdit:', currentObatEdit);

            if (currentObatId === currentObatEdit) {
                previousAmount = parseInt($(this).val()) || 0;
                console.log('previousAmount set to:', previousAmount);
            }
        });

        $('#amountEdit{{ $obat->id }}').on('input', function() {
            console.log('[event] Input pada amountEdit{{ $obat->id }}');
            validateAmountAndUpdateStock();
        });

        // Inisialisasi awal
        updateFields();
    });
</script>
