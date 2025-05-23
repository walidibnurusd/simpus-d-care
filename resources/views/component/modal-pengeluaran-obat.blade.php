<!-- Modal Add Action -->
<div class="modal fade" style="z-index: 1050;" id="pengeluaranObatModal" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title" id="exampleModalLabel">PENGELUARAN OBAT UNIT LAIN</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-apotikel="Close"></button>
            </div>
            <div class="modal-body">
                <form id="pengeluaranObat" action="{{ route('store-terima-obat') }}" method="POST" class="px-3">
                    @csrf
                    @method('POST')
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <label for="date" style="color: rgb(19, 11, 241);">Tanggal</label>
                            <input type="date" class="form-control" id="date" name="date">
                        </div>

                        <div class="col-md-6">
                            <label for="id_obat" style="color: rgb(19, 11, 241);">Kode dan Nama Obat</label>
                            <select class="form-control" id="id_obat" name="id_obat">
                                <option value="" disabled selected>pilih</option>
                                @foreach ($obats as $item)
                                    <option value="{{ $item->id }}"data-shape="{{ $item->shape }}">
                                        {{ $item->name }} - {{ $item->code }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row mt-3">

                        <div class="col-md-6" style="margin-bottom: 15px;">
                            <label for="unit" style="color: rgb(19, 11, 241);">Nama Unit</label>
                            <select class="form-control" id="unit" name="unit">
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
                        <div class="col-md-6 " style="margin-bottom: 15px;">
                            <label for="amount" style="color: rgb(19, 11, 241);">Jumlah</label>
                            <input type="text" class="form-control" id="amount" name="amount"
                                placeholder="Jumlah">
                        </div>

                        <div class="col-md-6" style="margin-bottom: 15px;">
                            <label for="shape" style="color: rgb(19, 11, 241);">Sediaan</label>
                            <select class="form-control" id="shape" name="shape" disabled>
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
                        <div class="col-md-6 " style="margin-bottom: 15px;">
                            <label for="stock" style="color: rgb(19, 11, 241);">Stock</label>
                            <input type="text" class="form-control" id="stock" name="stock" disabled>
                        </div>
                        <div class="col-md-12" style="margin-bottom: 15px;">
                            <label for="remarks" style="color: rgb(19, 11, 241);">Keterangan</label>
                            <textarea class="form-control" id="remarks" name="remarks" rows="3"></textarea>
                        </div>

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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    let originalStock = 0;

    $(document).ready(function() {
        $('#id_obat').select2({
            placeholder: "Pilih",
            allowClear: true,
            minimumResultsForSearch: 0
        });

        $('#id_obat').change(function() {
            const selectedOption = $(this).find('option:selected');
            const shapeValue = selectedOption.data('shape');
            const obatId = $(this).val();

            // Set shape
            if (shapeValue) {
                $('#shape').val(shapeValue).prop('disabled', false).trigger('change');
            } else {
                $('#shape').prop('disabled', true);
            }

            // Fetch stok
            if (obatId) {
                $.ajax({
                    url: '/obat/get-stock/' + obatId, // pastikan route ini tersedia
                    method: 'GET',
                    success: function(res) {
                        originalStock = parseInt(res.stock) || 0;
                        $('#stock').val(originalStock);
                        $('#amount').val('');
                    },
                    error: function() {
                        originalStock = 0;
                        $('#stock').val('0');
                        $('#amount').val('');
                        alert('Gagal mengambil stok obat.');
                    }
                });
            }
        });

        $('#amount').on('input', function() {
            const jumlah = parseInt($(this).val()) || 0;

            if (jumlah < 0) {
                alert('Jumlah tidak boleh negatif!');
                $(this).val(0);
                $('#stock').val(originalStock);
                return;
            }

            const sisaStok = originalStock - jumlah;

            if (sisaStok < 0) {
                alert('Jumlah melebihi stok tersedia!');
                $(this).val(originalStock);
                $('#stock').val(0);
                return;
            }

            $('#stock').val(sisaStok);
        });
    });


    document.addEventListener('DOMContentLoaded', function() {
        document.querySelector("form#terimaObat").addEventListener("submit", function(e) {
            // Hapus preventDefault agar form tetap bisa dikirim
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
</script>
