<!-- Modal Add Action -->
<div class="modal fade" style="z-index: 1050;" id="addMasterObatModal" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary">

                <h5 class="modal-title" id="exampleModalLabel">TAMBAH MASTER DATA OBAT</h5>

                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-apotikel="Close"></button>
            </div>

            <div class="modal-body">
                <form id="addMasterObat" action="{{ route('store-obat-master-data') }}" method="POST" class="px-3">
                    @csrf
                    <div class="row mt-3">
                        <!-- Kode Obat -->
                        <div class="col-md-4" style="margin-bottom: 15px;">
                            <label for="code" style="color: rgb(19, 11, 241);">Kode Obat</label>
                            <input type="text" class="form-control" id="code" name="code"
                                placeholder="Kode Obat">
                        </div>

                        <!-- Nama Obat -->
                        <div class="col-md-4" style="margin-bottom: 15px;">
                            <label for="name" style="color: rgb(19, 11, 241);">Nama Obat</label>
                            <input type="text" class="form-control" id="name" name="name"
                                placeholder="Nama Obat">
                        </div>

                        <!-- Sediaan Obat -->
                        <div class="col-md-4" style="margin-bottom: 15px;">
                            <label for="shape" style="color: rgb(19, 11, 241);">Sediaan Obat</label>
                            <select class="form-control" id="shape" name="shape">
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
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-primary">Simpan Data</button>
                </form>
            </div>
        </div>

    </div>

</div>

<script>
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
