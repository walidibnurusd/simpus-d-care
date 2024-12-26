@include('partials.header')

<style>
    body {
        margin: 0;
        padding: 0
    }

    .position-relative .toggle-password {
        position: absolute;
        right: 15px;
        top: 10px;
        cursor: pointer;
    }
</style>
<main class="main-content mt-0">
    <section style="overflow: hidden ;margin: 0; padding: 0;">
        <div class="row align-items-center">
            <div class="col-auto">
                <img src="{{ 'assets/assets/img/logo-mks.png' }}" alt="Healthcare Workers" class="header-logo" />
            </div>
            <div class="col-auto">
                <div class="header-text">Puskesmas Tamangapa</div>
            </div>
        </div>

        <div class="page-header min-vh-100">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 d-none d-lg-flex pe-0 text-center justify-content-center flex-column">
                        <div
                            class="position-relative h-100 m-3 border-radius-lg d-flex flex-column justify-content-center overflow-hidden">
                            <img src="{{ 'assets/assets/img/login-img.png' }}" alt="Healthcare Workers"
                                class="img-fluid" />
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-7 d-flex flex-column mx-lg-0 mx-auto">
                        <div class="card-custom card-plain">
                            <div class="card-header pb-0 text-start">
                                <h4 class="font-weight-bolder">Selamat Datang 👋</h4>
                                <p class="mb-0">Silahkan anda masuk :</p>
                            </div>
                            <div class="card-body">
                                <form role="form" action="{{ route('login') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <div class="mb-3">
                                        <input type="text" class="form-control form-control" name="login"
                                            placeholder="User Name" value="{{ old('login') }}" required>
                                        @error('login')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3 position-relative">
                                        <input type="password" class="form-control form-control" name="password"
                                            placeholder="Password" required id="password">
                                        <i class="fas fa-eye toggle-password" toggle="#password"></i>
                                        @error('password')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="captcha-container">
                                        <div class="captcha-box">
                                            <canvas id="captcha" class="captcha-canvas"></canvas>
                                            <button type="button" class="btn btn-secondary btn-refresh">
                                                <i class="fa fa-sync"></i>
                                            </button>
                                        </div>
                                        <input type="hidden" id="captcha-code" name="captcha-code">
                                        <input type="text" id="captcha-input" name="captcha" class="form-control"
                                            placeholder="Masukkan Code" required>
                                        @error('captcha')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-check form-switch mt-3 ml-4">
                                        <input class="form-check-input" type="checkbox" id="rememberMe">
                                        <label class="form-check-label" for="rememberMe">Remember me</label>
                                    </div>
                                    <div class="text-center mt-4">
                                        <button type="submit"
                                            class="btn btn-lg btn-primary btn-lg w-100 mb-0">Masuk</button>
                                    </div>
                                    <div class="text-left mt-4">
                                        <button type="button" class="btn btn-lg btn-warning btn-lg mb-0">Petunjuk
                                            Teknis</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
@include('component.modal-eror')


<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

<!-- Bootstrap JS -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

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

    function generateCaptcha() {
        var canvas = document.getElementById('captcha');
        var ctx = canvas.getContext('2d');

        // Set the canvas size to match the CSS size
        canvas.width = canvas.offsetWidth;
        canvas.height = canvas.offsetHeight;

        var chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        var captchaCode = '';
        for (var i = 0; i < 6; i++) {
            captchaCode += chars.charAt(Math.floor(Math.random() * chars.length));
        }

        ctx.clearRect(0, 0, canvas.width, canvas.height);
        ctx.fillStyle = '#ffffff';
        ctx.fillRect(0, 0, canvas.width, canvas.height);
        ctx.font = '16px Arial'; // Increased font size
        ctx.fillStyle = '#000000';
        ctx.fillText(captchaCode, 10, canvas.height / 2 + 10); // Adjusted Y-coordinate to center the text

        document.getElementById('captcha-code').value = captchaCode;
    }

    document.querySelector('.btn-refresh').addEventListener('click', generateCaptcha);
    generateCaptcha(); // Generate CAPTCHA when page loads

    function showErrorModal(message) {
        document.getElementById('errorMessage').innerText = message;
        $('#errorModal').modal('show');
    }
    document.querySelector('form').addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent form submission for AJAX handling

        var login = document.querySelector('input[name="login"]').value;
        var password = document.querySelector('input[name="password"]').value;
        var inputCaptcha = document.getElementById('captcha-input').value;
        var generatedCaptcha = document.getElementById('captcha-code').value;

        // Verifikasi CAPTCHA
        if (inputCaptcha !== generatedCaptcha) {
            Swal.fire({
                icon: 'error',
                title: 'CAPTCHA salah',
                text: 'Silakan coba lagi.'
            });
            return; // Stop further processing
        }

        // Validasi login dan password
        if (!login || !password) {
            Swal.fire({
                icon: 'error',
                title: 'User Name atau Password tidak boleh kosong',
                text: 'Silakan isi semua field.'
            });
            return; // Stop further processing
        }

        // Jika semua validasi berhasil, kirimkan form dengan AJAX
        $.ajax({
            type: 'POST',
            url: '/login', // Ganti dengan URL login yang sesuai
            data: {
                login: login,
                password: password,
                captcha: inputCaptcha,
                _token: document.querySelector('input[name="_token"]').value
            },
            success: function(response) {
                Swal.fire({
                    icon: 'success',
                    title: 'Login berhasil',
                    text: 'Anda akan diarahkan ke dashboard.'
                }).then(() => {
                    window.location.href = '/profile'; // Adjust this path if necessary
                });
            },
            error: function(xhr) {
                var errorMessage = xhr.responseJSON.message || 'Terjadi kesalahan saat login.';
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: errorMessage
                });
            }
        });
    });
</script>

@include('partials.footer')
