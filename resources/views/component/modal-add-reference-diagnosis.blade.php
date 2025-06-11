<div class="modal fade" id="addDiagnosisModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <form id="createDiagnosisForm">
        @csrf
        <div class="modal-header"><h5>Buat Data Diagnosis</h5></div>
            <div class="modal-body">
                <div class="mb-3">
                    <label>Name <span class="text-danger">*</span></label>
                    <input type="text" id="add-diagnosis-name" name="name" class="form-control" required>
                </div>
                 <div class="mb-3">
                    <label>ICD 10 <span class="text-danger">*</span></label>
                    <input type="text" id="add-diagnosis-icd10" name="icd10" class="form-control" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Save</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            </div>
        </div>
    </form>
  </div>
</div>