<div class="modal fade" id="addImtModal" tabindex="-1" role="dialog" aria-labelledby="addImtModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addImtModalLabel">Tambah Data IMT</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('imt.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="id_employe">Pegawai</label>
                        <select class="form-control" id="id_employe" name="id_employe" required>
                            <option value="{{ $employees->id }}">{{ $employees->nama }}</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="beratbadan">Berat Badan (kg)</label>
                        <input type="number" step="0.01" class="form-control" id="beratbadan" name="beratbadan" required>
                    </div>
                    <div class="form-group">
                        <label for="tinggibadan">Tinggi Badan (cm)</label>
                        <input type="number" step="0.01" class="form-control" id="tinggibadan" name="tinggibadan" required>
                    </div>
                    <div class="form-group">
                        <label for="imt">IMT (kg/m<sup>2</sup>)</label>
                        <input type="text" class="form-control" id="imt" name="imt" readonly>
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

<!-- Script untuk menghitung IMT -->
<script>
    document.getElementById('beratbadan').addEventListener('input', hitungIMT);
    document.getElementById('tinggibadan').addEventListener('input', hitungIMT);

    function hitungIMT() {
        const berat = parseFloat(document.getElementById('beratbadan').value);
        const tinggiCm = parseFloat(document.getElementById('tinggibadan').value);
        
        if (!isNaN(berat) && !isNaN(tinggiCm) && tinggiCm > 0) {
            const tinggiM = tinggiCm / 100; // Ubah tinggi ke meter
            const imt = (berat / (tinggiM * tinggiM)).toFixed(2); // Rumus IMT
            document.getElementById('imt').value = imt;
        } else {
            document.getElementById('imt').value = ''; // Kosongkan jika input tidak valid
        }
    }
</script>
