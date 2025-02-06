<div class="modal fade" style="z-index: 9999;" id="editKunjunganModal{{ $k->id }}" tabindex="-1"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl"> <!-- Using modal-lg for a moderate width -->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Data</h5> <!-- Updated the title -->
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('kunjungan.update', $k->id) }}" method="POST" class="px-3">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="row g-2">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="poli">Poli Tujuan Berobat</label>
                                <select class="form-control" id="poli" name="poli">
                                    <option value="" disabled selected>Pilih</option>
                                    <option value="poli-umum"
                                        {{ old('poli-berobat', $k->poli) == 'poli-umum' ? 'selected' : '' }}>
                                        Poli Umum</option>
                                    <option value="poli-gigi"
                                        {{ old('poli', $k->poli) == 'poli-gigi' ? 'selected' : '' }}>
                                        Poli Gigi
                                    </option>
                                    <option value="ruang-tindakan"
                                        {{ old('poli', $k->poli) == 'ruang-tindakan' ? 'selected' : '' }}>
                                        UGD
                                    </option>
                                    <option value="poli-kia"
                                        {{ old('poli', $k->poli) == 'poli-kia' ? 'selected' : '' }}>
                                        Poli KIA
                                    </option>
                                    <option value="poli-kb" {{ old('poli', $k->poli) == 'poli-kb' ? 'selected' : '' }}>
                                        Poli KB
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4 mt-2">
                            <div class="form-group">
                                <label for="hamil">Hamil?</label>
                                <select class="form-control" id="hamil" name="hamil">
                                    <option value="">Pilih</option>
                                    <option value="1" {{ old('hamil', $k->hamil) == 1 ? 'selected' : '' }}>
                                        Ya</option>
                                    <option value="0" {{ old('hamil', $k->hamil) == 0 ? 'selected' : '' }}>
                                        Tidak</option>
                                </select>
                            </div>
                        </div>

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

<script>
    document.addEventListener('DOMContentLoaded', function() {

        // Success notification using SweetAlert2
        @if (session('success'))
            Swal.fire({
                title: 'Success!',
                text: "{{ session('success') }}",
                icon: 'success',
                confirmButtonText: 'OK'
            });
        @endif

        // Validation error handling
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
