@php
    $obats = App\Models\Obat::all();
@endphp

<!-- Modal Edit Action -->
<div class="modal fade" style="z-index: 1050;" id="editTerimaObatModal{{ $obat->id }}" tabindex="-1"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title" id="exampleModalLabel">EDIT PENERIMAAN OBAT APOTEK</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editTerimaObat{{ $obat->id }}" action="{{ route('update-terima-obat', $obat->id) }}"
                    method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row
                    mt-3">
                        <div class="col-md-6" style="margin-bottom: 15px;">
                            <label for="date" style="color: rgb(19, 11, 241);">Tanggal</label>
                            <input type="date" class="form-control" id="date" name="date"
                                value="{{ $obat->date }}">
                        </div>
                        <div class="col-md-6" style="margin-bottom: 15px;">
                            <label for="id_obat" style="color: rgb(19, 11, 241);">Kode dan Nama Obat</label>
                            <select class="form-control" id="id_obat_edit" name="id_obat">
                                <option value="" disabled selected>pilih</option>
                                @foreach ($obats as $item)
                                    <option value="{{ $item->id }}" data-shape="{{ $item->shape }}"
                                        {{ $item->id == $obat->id_obat ? 'selected' : '' }}>
                                        {{ $item->name }} - {{ $item->code }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-6" style="margin-bottom: 15px;">
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
                            <label for="amount" style="color: rgb(19, 11, 241);">Jumlah</label>
                            <input type="text" class="form-control" id="amount" name="amount"
                                placeholder="Jumlah diterima" value="{{ $obat->amount }}">
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
        document.querySelectorAll("form[id^='editTerimaObat']").forEach(form => {
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
        // Initialize Select2 for the obat dropdown
        $('#id_obat_edit').select2({
            placeholder: "Pilih",
            allowClear: true,
            minimumResultsForSearch: 0,
            dropdownParent: $('#editTerimaObatModal{{ $obat->id }}')
        });

        // Function to update the shape field
        function updateShapeField() {
            var selectedOption = $('#id_obat_edit option:selected');
            var shapeValue = selectedOption.data('shape'); // Get the shape from the selected option

            if (shapeValue) {
                $('#shape_edit').val(shapeValue).prop('disabled', false); // Enable and set value for shape
            } else {
                $('#shape_edit').val('').prop('disabled',
                    true); // Disable and clear shape dropdown if no shape found
            }
        }

        // Trigger change event on obat select
        $('#id_obat_edit').change(function() {
            updateShapeField();
        });

        // On page load, set the initial value for shape based on the selected obat
        updateShapeField();
    });
</script>
