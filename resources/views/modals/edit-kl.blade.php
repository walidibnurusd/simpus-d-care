<div class="modal fade" id="editKadarLemakModal{{$item->id}}" tabindex="-1" role="dialog" aria-labelledby="editKadarLemakModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editKadarLemakModalLabel">Edit Data Kadar Lemak</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('kl.update', $item->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="form-group">
                        <label for="edit_id_employe">Pegawai</label>
                        <select class="form-control" id="edit_id_employe" name="id_employe" required>
                            <option value="{{ $employees->id }}" {{ $item->id_employe == $employees->id ? 'selected' : '' }}>
                                {{ $employees->nama }}
                            </option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="edit_kadar_lemak">Kadar Lemak (%)</label>
                        <input type="number" step="0.01" class="form-control" id="edit_kadar_lemak" name="kadar_lemak" value="{{ $item->kadar_lemak }}" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_waktu_periksa">Waktu Periksa</label>
                        <input type="datetime-local" class="form-control" id="edit_waktu_periksa" name="waktu_periksa" value="{{ date('Y-m-d\TH:i', strtotime($item->waktu_periksa)) }}" required>
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
