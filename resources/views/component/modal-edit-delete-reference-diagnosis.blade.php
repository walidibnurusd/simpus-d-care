<!-- Edit User Modal -->
<div class="modal fade" id="editDiagnosisModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <form id="editDiagnosisForm">
        @csrf
        <div class="modal-header"><h5>Edit Diagnosis</h5></div>
            <div class="modal-body">
                <input type="hidden" id="edit-diagnosis-id">
                <div class="mb-3">
                    <label>Name <span class="text-danger">*</span></label>
                    <input type="text" id="edit-diagnosis-name" name="name" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>ICD 10 <span class="text-danger">*</span></label>
                    <input type="text" id="edit-diagnosis-icd10" name="icd10" class="form-control" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
            </div>
        </div>
    </form>
  </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteDiagnosisModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <form id="deleteDiagnosisForm">
        @csrf
        @method('DELETE')
            <div class="modal-header"><h5>Konfirmasi hapus?</h5></div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin menghapus data diagnosis ini?</p>
                <input type="hidden" id="delete-diagnosis-id">
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-danger">Hapus</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
            </div>
        </div>
    </form>
  </div>
</div>