<!-- Edit User Modal -->
<div class="modal fade" id="editPoliModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <form id="editPoliForm">
        @csrf
        <div class="modal-header"><h5>Edit Poli</h5></div>
            <div class="modal-body">
                <input type="hidden" id="edit-poli-id">
                <div class="mb-3">
                    <label>Name <span class="text-danger">*</span></label>
                    <input type="text" id="edit-poli-name" name="name" class="form-control" required>
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
<div class="modal fade" id="deletePoliModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <form id="deletePoliForm">
        @csrf
        @method('DELETE')
            <div class="modal-header"><h5>Konfirmasi Hapus?</h5></div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin menghapus data poli ini?</p>
                <input type="hidden" id="delete-poli-id">
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-danger">Hapus</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
            </div>
        </div>
    </form>
  </div>
</div>