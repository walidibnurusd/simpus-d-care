<div class="modal fade" id="addKadarLemakModal" tabindex="-1" role="dialog" aria-labelledby="addKadarLemakModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addKadarLemakModalLabel">Tambah Data Kadar Lemak</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('kl.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="id_employe">Pegawai</label>
                        <select class="form-control" id="id_employe" name="id_employe" required>
                            <option value="{{ $employees->id }}">{{ $employees->nama }}</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="kadar_lemak">Kadar Lemak (%)</label>
                        <input type="number" step="0.01" class="form-control" id="kadar_lemak" name="kadar_lemak" required>
                    </div>
                    <div class="form-group">
                        <label for="waktu_periksa">Waktu Periksa</label>
                        <input type="datetime-local" class="form-control" id="waktu_periksa" name="waktu_periksa" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
