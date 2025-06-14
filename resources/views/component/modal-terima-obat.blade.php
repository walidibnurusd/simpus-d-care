<!-- Modal Add Action -->
<div class="modal fade" style="z-index: 1050;" id="terimaObatModal" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title" id="exampleModalLabel">PENERIMAAN OBAT APOTEK</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-apotikel="Close"></button>
            </div>
            <div class="modal-body">
                <form id="terimaObat" action="{{ route('store-terima-obat') }}" method="POST" class="px-3">
                    @csrf
                    @method('POST')
                    <div class="row mt-3">
                        <div class="col-md-6" style="margin-bottom: 15px;">
                            <label for="date" style="color: rgb(19, 11, 241);">Tanggal</label>
                            <input type="date" class="form-control" id="date" name="date">
                        </div>

                        <div class="col-md-6" style="margin-bottom: 15px;">
                            <label for="id_obat" style="color: rgb(19, 11, 241);">Kode dan Nama Obatt</label>
                            <select class="form-control" id="id_obat" name="id_obat" data-placeholder="pilih">
                                <option></option>
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
                        <div class="col-md-6 " style="margin-bottom: 15px;">
                            <label for="amount" style="color: rgb(19, 11, 241);">Jumlah</label>
                            <input type="text" class="form-control" id="amount" name="amount"
                                placeholder="Jumlah diterima">
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
    $(document).ready(function() {
        $('#id_obat').select2({
            placeholder: "Pilih",
            allowClear: true,
            minimumResultsForSearch: 0,
            dropdownParent: $('#terimaObatModal')
        });

        $('#id_obat').change(function() {
            var selectedOption = $(this).find('option:selected');
            var shapeValue = selectedOption.data('shape');

            if (shapeValue) {
                $('#shape').val(shapeValue).prop('disabled', false).trigger('change');
            } else {
                $('#shape').prop('disabled', true);
            }
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
