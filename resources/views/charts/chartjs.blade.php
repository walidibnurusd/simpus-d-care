@extends('layouts.simple.master')
@section('title', 'ChartJS Chart')

@section('css')
@endsection

@section('style')
@endsection

@section('breadcrumb-title')
<h3>ChartJS Chart</h3>
@endsection

@section('breadcrumb-items')
<li class="breadcrumb-item">Charts</li>
<li class="breadcrumb-item active">ChartJS Chart</li>
@endsection

@section('content')
<div class="container-fluid">
   <div class="row">
      <div class="col-xl-6 col-md-12 box-col-12">
         <div class="card">
            <div class="card-header">
               <h5>Bar Chart</h5>
            </div>
            <div class="card-body chart-block">
               <canvas id="myBarGraph"></canvas>
            </div>
         </div>
      </div>
      <div class="col-xl-6 col-md-12 box-col-12">
         <div class="card">
            <div class="card-header">
               <h5>Line Graph</h5>
            </div>
            <div class="card-body chart-block">
               <canvas id="myGraph"></canvas>
            </div>
         </div>
      </div>
      <div class="col-xl-6 col-md-12 box-col-12">
         <div class="card">
            <div class="card-header">
               <h5>Radar Graph</h5>
            </div>
            <div class="card-body chart-block">
               <canvas id="myRadarGraph"></canvas>
            </div>
         </div>
      </div>
      <div class="col-xl-6 col-md-12 box-col-12">
         <div class="card">
            <div class="card-header">
               <h5>Line Chart</h5>
            </div>
            <div class="card-body chart-block">
               <canvas id="myLineCharts"></canvas>
            </div>
         </div>
      </div>
      <div class="col-xl-6 col-md-12 box-col-12">
         <div class="card">
            <div class="card-header">
               <h5>Doughnut Chart</h5>
            </div>
            <div class="card-body chart-block chart-vertical-center">
               <canvas id="myDoughnutGraph"></canvas>
            </div>
         </div>
      </div>
      <div class="col-xl-6 col-md-12 box-col-12">
         <div class="card">
            <div class="card-header">
               <h5>Polar Chart</h5>
            </div>
            <div class="card-body chart-block chart-vertical-center">
               <canvas id="myPolarGraph"></canvas>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection

@section('script')
<script src="{{asset('assets/js/chart/chartjs/chart.min.js')}}"></script>
<script src="{{asset('assets/js/chart/chartjs/chart.custom.js')}}"></script>
@endsection