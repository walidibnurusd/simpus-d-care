<!-- Edit User Modal -->
<div class="modal fade" id="editObatModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <form id="editObatForm">
        @csrf
        <div class="modal-header"><h5>Edit Obat</h5></div>
            <div class="modal-body">
                <input type="hidden" id="edit-obat-id">
                <div class="mb-3">
                    <label>Name <span class="text-danger">*</span></label>
                    <input type="text" id="edit-obat-name" name="name" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Kode <span class="text-danger">*</span></label>
                    <input type="text" id="edit-obat-code" name="code" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Bentuk <span class="text-danger">*</span></label>
                    <select name="shape" id="edit-obat-shape" class="form-control">
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
                <div class="mb-3">
                    <label>Jumlah <span class="text-danger">*</span></label>
                    <input type="text" id="edit-obat-amount" name="amount" class="form-control" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Save Changes</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            </div>
        </div>
    </form>
  </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteObatModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <form id="deleteObatForm">
        @csrf
        @method('DELETE')
            <div class="modal-header"><h5>Konfirmasi Hapus?</h5></div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin menghapus data obat ini?</p>
                <input type="hidden" id="delete-obat-id">
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-danger">Hapus</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
            </div>
        </div>
    </form>
  </div>
</div>