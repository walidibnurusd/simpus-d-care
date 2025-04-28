<div class="modal fade" id="editImtModal{{$item->id}}" tabindex="-1" role="dialog" aria-labelledby="editImtModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editImtModalLabel">Edit Data IMT</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('imt.update', $item->id) }}" method="POST">
                @csrf
                @method('PUT') <!-- For PUT request, which is required for updating -->
                <div class="modal-body">
                    <div class="form-group">
                        <label for="id_employe">Pegawai</label>
                        <select class="form-control" id="id_employe" name="id_employe" required>
                           
                                <option value="{{ $employees->id }}" {{ $item->id_employe == $employees->id ? 'selected' : '' }}>
                                    {{ $employees->nama }}
                                </option>
    
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="beratbadan">Berat Badan (kg)</label>
                        <input type="number" step="0.01" class="form-control" id="beratbadan" name="beratbadan" value="{{ old('beratbadan', $item->beratBadan) }}" required>
                    </div>
                    <div class="form-group">
                        <label for="tinggibadan">Tinggi Badan (cm)</label>
                        <input type="number" step="0.01" class="form-control" id="tinggibadan" name="tinggibadan" value="{{ old('tinggibadan', $item->tinggiBadan) }}" required>
                    </div>
                    <div class="form-group">
                        <label for="waktu_periksa">Waktu Periksa</label>
                        <input type="datetime-local" class="form-control" id="waktu_periksa" name="waktu_periksa" value="{{ old('waktu_periksa', \Carbon\Carbon::parse($item->waktu_periksa)->format('Y-m-d\TH:i')) }}" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
