@extends('layouts.authentication.master')
@section('title', 'Unlock')

@section('css')
@endsection

@section('style')
@endsection


@section('content')
<div class="tap-top"><i data-feather="chevrons-up"></i></div>
<!-- tap on tap ends-->
<!-- page-wrapper Start-->
<div class="page-wrapper">
   <div class="container-fluid p-0">
      <!-- Unlock page start-->
      <div class="authentication-main mt-0">
         <div class="row">
            <div class="col-12">
               <div class="login-card">
                  <div>
                     <div><a class="logo" href="{{ route('index') }}"><img class="img-fluid for-light" src="{{asset('assets/images/logo/login.png')}}" alt="looginpage"><img class="img-fluid for-dark" src="{{asset('assets/images/logo/logo_dark.png')}}" alt="looginpage"></a></div>
                     <div class="login-main">
                        <form class="theme-form">
                           <h4>Unlock                          </h4>
                           <div class="form-group">
                              <label class="col-form-label">Enter your Password</label>
                              <input class="form-control" type="password" name="login[password]" required="" placeholder="*********">
                              <div class="show-hide"><span class="show">                      </span></div>
                           </div>
                           <div class="form-group mb-0">
                              <div class="checkbox p-0">
                                 <input id="checkbox1" type="checkbox">
                                 <label class="text-muted" for="checkbox1">Remember password</label>
                              </div>
                              <button class="btn btn-primary btn-block" type="submit">Unlock</button>
                           </div>
                           <p class="mt-4 mb-0">Already Have an account?<a class="ms-2" href="{{ route('login') }}">Sign in</a></p>
                        </form>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection

@section('script')
@endsection