<!-- Edit Profile Modal -->
<div class="modal fade" id="changePasswordModal" tabindex="-1" aria-labelledby="changePasswordModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="changePasswordModalLabel">Ganti Password</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="changePasswordForm" action="{{ route('change.password', $user->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3 position-relative">
                                <label for="password" class="form-label">Password Lama</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                                <i class="fas fa-eye toggle-password" toggle="#password"></i>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3 position-relative">
                                <label for="newPassword" class="form-label">Password Baru</label>
                                <input type="password" class="form-control" id="newPassword" name="newPassword"
                                    required>
                                <i class="fas fa-eye toggle-password" toggle="#newPassword"></i>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3 position-relative">
                                <label for="confirmPassword" class="form-label">Konfirmasi Password Baru</label>
                                <input type="password" class="form-control" id="confirmPassword" name="confirmPassword"
                                    required>
                                <i class="fas fa-eye toggle-password" toggle="#confirmPassword"></i>
                            </div>
                        </div>
                    </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-primary">Ganti Password</button>
            </div>
            </form>
        </div>
    </div>
</div>
<style>
    .position-relative .toggle-password {
        position: absolute;
        right: 15px;
        top: 45px;
        cursor: pointer;
    }
</style>
<script>
    document.querySelectorAll('.toggle-password').forEach(item => {
        item.addEventListener('click', function() {
            var input = document.querySelector(this.getAttribute('toggle'));
            if (input.getAttribute('type') === 'password') {
                input.setAttribute('type', 'text');
                this.classList.remove('fa-eye');
                this.classList.add('fa-eye-slash');
            } else {
                input.setAttribute('type', 'password');
                this.classList.remove('fa-eye-slash');
                this.classList.add('fa-eye');
            }
        });
    });
</script>
