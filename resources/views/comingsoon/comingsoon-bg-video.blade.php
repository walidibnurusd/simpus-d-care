@extends('layouts.comingsoon.master')
@section('title', 'Comingsoon BG Video')

@section('css')
@endsection

@section('style')
@endsection

@section('content')
<div class="page-wrapper compact-wrapper" id="pageWrapper">
  <!-- Page Body Start-->
  <div class="container-fluid p-0">
    <div class="comingsoon auth-bg-video">
      <video class="bgvideo-comingsoon" id="bgvid" poster="{{asset('assets/images/other-images/coming-soon-bg.jpg')}}" playsinline="" autoplay="" muted="" loop="">
        <source src="{{asset('assets/video/auth-bg.mp4')}}" type="video/mp4">
      </video>
      <div class="comingsoon-inner text-center"><img src="{{asset('assets/images/other-images/coming-soon-Logo.png')}}" alt="">
        <h5>WE ARE COMING SOON</h5>
        <div class="countdown" id="clockdiv">
          <ul>
            <li><span class="time digits" id="days"></span><span class="title">days</span></li>
            <li><span class="time digits" id="hours"></span><span class="title">Hours</span></li>
            <li><span class="time digits" id="minutes"></span><span class="title">Minutes</span></li>
            <li><span class="time digits" id="seconds"></span><span class="title">Seconds</span></li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@section('script')
<script src="{{asset('assets/js/countdown.js')}}"></script>
@endsection