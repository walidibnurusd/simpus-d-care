<div class="modal fade" id="addUserModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <form id="createDoctorForm">
        @csrf
        <div class="modal-header"><h5>Buat Data Dokter</h5></div>
            <div class="modal-body">
                <div class="mb-3">
                    <label>Name <span class="text-danger">*</span></label>
                    <input type="text" id="add-user-name" name="name" class="form-control" required>
                </div>
                 <div class="mb-3">
                    <label>NIP <span class="text-danger">*</span></label>
                    <input type="text" id="add-user-nip" name="nip" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Email <span class="text-danger">*</span></label>
                    <input type="email" id="add-user-email" name="email" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>password <span class="text-danger">*</span></label>
                    <input type="text" id="add-user-password" name="password" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>No. Telpon <span class="text-danger">*</span></label>
                    <input type="text" id="add-user-phone_number" name="phone_number" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Alamat <span class="text-danger">*</span></label>
                    <input type="text" id="add-user-address" name="address" class="form-control" required>
                </div>
                <!-- <div class="mb-3">
                    <label>NIK</label>
                    <input type="text" id="add-user-nik" name="nik" class="form-control" required>
                </div> -->
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Save</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            </div>
        </div>
    </form>
  </div>
</div>