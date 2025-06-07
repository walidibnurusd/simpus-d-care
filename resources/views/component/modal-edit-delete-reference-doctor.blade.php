<!-- Edit User Modal -->
<div class="modal fade" id="editUserModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <form id="editUserForm">
        @csrf
        <div class="modal-header"><h5>Edit User</h5></div>
            <div class="modal-body">
                <input type="hidden" id="edit-user-id">
                <div class="mb-3">
                    <label>Name <span class="text-danger">*</span></label>
                    <input type="text" id="edit-user-name" name="name" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>NIP <span class="text-danger">*</span></label>
                    <input type="text" id="edit-user-nip" name="nip" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Email <span class="text-danger">*</span></label>
                    <input type="email" id="edit-user-email" name="email" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>No. Telpon <span class="text-danger">*</span></label>
                    <input type="text" id="edit-user-phone_number" name="phone_number" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Alamat <span class="text-danger">*</span></label>
                    <input type="text" id="edit-user-address" name="address" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Password</label>
                    <input type="text" id="edit-user-password" name="password" class="form-control">
                    <small>* Kosongkan bila tidak ingin mengubah password</small>
                </div>
                <!-- <div class="mb-3">
                    <label>NIK</label>
                    <input type="text" id="edit-user-nik" name="nik" class="form-control" required>
                </div> -->
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
<div class="modal fade" id="deleteUserModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <form id="deleteUserForm">
        @csrf
        @method('DELETE')
            <div class="modal-header"><h5>Confirm Delete</h5></div>
            <div class="modal-body">
                <p>Are you sure you want to delete this user?</p>
                <input type="hidden" id="delete-user-id">
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-danger">Yes, Delete</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            </div>
        </div>
    </form>
  </div>
</div>