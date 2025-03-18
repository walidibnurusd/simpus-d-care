<!-- Modal Edit Obat -->
<div class="modal fade" id="editMasterObatModal{{ $obat->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title">EDIT MASTER DATA OBAT</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form id="editMasterObat{{ $obat->id }}" action="{{ route('update-obat-master-data', $obat->id) }}"
                    method="POST">
                    @csrf
                    @method('PUT') <!-- Gunakan PUT untuk update -->

                    <div class="row mt-3">
                        <!-- Kode Obat -->
                        <div class="col-md-4 mb-3">
                            <label for="code" class="text-primary">Kode Obat</label>
                            <input type="text" class="form-control" id="code" name="code"
                                value="{{ $obat->code }}" required>
                        </div>

                        <!-- Nama Obat -->
                        <div class="col-md-4 mb-3">
                            <label for="name" class="text-primary">Nama Obat</label>
                            <input type="text" class="form-control" id="name" name="name"
                                value="{{ $obat->name }}" required>
                        </div>

                        <!-- Sediaan Obat -->
                        <div class="col-md-4 mb-3">
                            <label for="shape" class="text-primary">Sediaan Obat</label>
                            <select class="form-control" id="shape" name="shape" required>
                                <option value="1" {{ $obat->shape == '1' ? 'selected' : '' }}>Tablet</option>
                                <option value="2" {{ $obat->shape == '2' ? 'selected' : '' }}>Botol</option>
                                <option value="3" {{ $obat->shape == '3' ? 'selected' : '' }}>Pcs</option>
                                <option value="4" {{ $obat->shape == '4' ? 'selected' : '' }}>Suppositoria</option>
                                <option value="5" {{ $obat->shape == '5' ? 'selected' : '' }}>Ovula</option>
                                <option value="6" {{ $obat->shape == '6' ? 'selected' : '' }}>Drop</option>
                                <option value="7" {{ $obat->shape == '7' ? 'selected' : '' }}>Tube</option>
                                <option value="8" {{ $obat->shape == '8' ? 'selected' : '' }}>Pot</option>
                                <option value="9" {{ $obat->shape == '9' ? 'selected' : '' }}>Injeksi</option>
                            </select>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Simpan Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        document.querySelectorAll("form[id^='editMasterObat']").forEach(form => {
            form.addEventListener("submit", function(e) {
                console.log("Form submitted: ", form.id);
            });
        });

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
                html: '<ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>',
                icon: 'error',
                confirmButtonText: 'OK'
            });
        @endif
    });
</script>
