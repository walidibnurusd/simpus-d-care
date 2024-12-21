@extends('layouts.authentication.master')
@section('title', 'Login')

@section('css')
<!-- Include any additional CSS here -->
@endsection

@section('style')
<style>
   .position-relative {
       position: relative;
   }

   .btn-toggle-password {
       position: absolute;
       top: 50%;
       right: 10px;
       transform: translateY(-50%);
       background: none;
       border: none;
       cursor: pointer;
       padding: 0;
       color: #6c757d;
   }

   .btn-toggle-password:focus {
       outline: none;
   }

   /* Additional styling for mobile */
   .login-card {
       padding: 1rem;
   }

   /* Center logo for mobile */
   .logo-container {
       display: flex;
       justify-content: center;
       padding: 1rem;
   }
</style>
@endsection

@section('content')
<div class="container-fluid p-0">
   <div class="row m-0">
      <div class="col-12 p-0">
         {{-- Display session error if login fails --}}
         @if(session('login_error'))
         <div class="alert alert-danger alert-dismissible fade show" role="alert">
             {{ session('login_error') }}
             <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
         </div>
         @endif

         <div class="row m-0">
            {{-- Left column with logo --}}
            <div class="col-md-6 col-12 d-flex align-items-center justify-content-center logo-container">
               <a class="logo" href="{{ route('index') }}">
                   <img src="{{ asset('assets/images/logo/logo.png') }}" alt="Logo" class="img-fluid">
               </a>
            </div>

            {{-- Right column with login form --}}
            <div class="login-card col-md-6 col-12">
               <div class="login-main">
                  <form class="theme-form" action="{{ route('proses_login') }}" method="POST">
                     @csrf
                     <h4>Sign in to your account</h4>
                     <p>Enter your username & password to login</p>

                     <div class="form-group">
                        <label class="col-form-label" for="username">Username</label>
                        <input id="username" class="form-control" type="text" name="username" required placeholder="Username" autocomplete="username">
                        @if($errors->has('username'))
                        <span class="error text-danger">{{ $errors->first('username') }}</span>
                        @endif
                     </div>

                     <div class="form-group">
                        <label class="col-form-label" for="passwordInput">Password</label>
                        <div class="position-relative">
                           <input id="passwordInput" class="form-control" type="password" name="password" required placeholder="*********" autocomplete="current-password">
                           <button class="btn-toggle-password" type="button" onclick="togglePasswordVisibility()">
                               <i id="passwordIcon" class="fa fa-eye"></i>
                           </button>
                        </div>
                        @if($errors->has('password'))
                        <span class="error text-danger">{{ $errors->first('password') }}</span>
                        @endif
                     </div>

                     <div class="form-group mb-0">
                        <div class="checkbox p-0">
                           <input id="checkbox1" type="checkbox" name="remember">
                           <label class="text-muted" for="checkbox1">Remember password</label>
                        </div>
                        <a class="link" href="{{ route('forget-password') }}">Forgot password?</a>
                        <button class="btn btn-warning w-100" type="submit">Sign in</button>
                     </div>
                  </form>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection

@section('script')
<script>
   function togglePasswordVisibility() {
       const passwordInput = document.getElementById("passwordInput");
       const passwordIcon = document.getElementById("passwordIcon");

       if (passwordInput.type === "password") {
           passwordInput.type = "text";
           passwordIcon.classList.remove("fa-eye");
           passwordIcon.classList.add("fa-eye-slash");
       } else {
           passwordInput.type = "password";
           passwordIcon.classList.remove("fa-eye-slash");
           passwordIcon.classList.add("fa-eye");
       }
   }
</script>
@endsection
