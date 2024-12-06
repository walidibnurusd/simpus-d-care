@extends('layouts.simple.master')
@section('title', 'Sticky')

@section('css')

@endsection

@section('style')
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/vendors/sticky.css')}}">
@endsection

@section('breadcrumb-title')
<h3>Sticky</h3>
@endsection

@section('breadcrumb-items')
<li class="breadcrumb-item">Bonus Ui</li>
<li class="breadcrumb-item active">Sticky</li>
@endsection

@section('content')
<div class="container-fluid">
	<div class="row sticky-header-main">
	  <div class="col-sm-12">
	    <div class="card">
	      <div class="card-header">
	        <h5>Sticky Note <a class="btn btn-primary pull-right m-l-10" id="add_new" href="javascript:;">Add New Note</a></h5>
	      </div>
	      <div class="card-body">
	        <div class="sticky-note" id="board"></div>
	      </div>
	    </div>
	  </div>
	</div>
</div>
@endsection

@section('script')
<script src="{{asset('assets/js/jquery.ui.min.js')}}"></script>
<script src="{{asset('assets/js/sticky/sticky.js')}}"></script>
@endsection

