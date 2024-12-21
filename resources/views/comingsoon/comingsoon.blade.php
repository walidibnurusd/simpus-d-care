@extends('layouts.comingsoon.master')
@section('title', 'Comingsoon')

@section('css')
@endsection

@section('style')
@endsection

@section('content')
<div class="page-wrapper compact-wrapper" id="pageWrapper">
  <!-- Page Body Start-->
  <div class="container-fluid p-0">
    <div class="comingsoon">
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