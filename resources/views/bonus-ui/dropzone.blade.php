@extends('layouts.simple.master')
@section('title', 'Dropzone')

@section('css')

@endsection

@section('style')
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/vendors/dropzone.css')}}">
@endsection

@section('breadcrumb-title')
<h3>Dropzone</h3>
@endsection

@section('breadcrumb-items')
<li class="breadcrumb-item">Bonus Ui</li>
<li class="breadcrumb-item active">Dropzone</li>
@endsection

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-sm-12">
			<div class="card">
				<div class="card-header">
					<h5>Single File Upload</h5>
				</div>
				<div class="card-body">
					<form class="dropzone digits" id="singleFileUpload" action="/upload.php">
						<div class="dz-message needsclick">
							<i class="icon-cloud-up"></i>
							<h6>Drop files here or click to upload.</h6>
							<span class="note needsclick">(This is just a demo dropzone. Selected files are <strong>not</strong> actually uploaded.)</span>
						</div>
					</form>
				</div>
			</div>
		</div>
		<div class="col-sm-12">
			<div class="card">
				<div class="card-header">
					<h5>Multi File Upload</h5>
				</div>
				<div class="card-body">
					<form class="dropzone dropzone-primary" id="multiFileUpload" action="/upload.php">
						<div class="dz-message needsclick">
							<i class="icon-cloud-up"></i>
							<h6>Drop files here or click to upload.</h6>
							<span class="note needsclick">(This is just a demo dropzone. Selected files are <strong>not</strong> actually uploaded.)</span>
						</div>
					</form>
				</div>
			</div>
		</div>
		<div class="col-sm-12">
			<div class="card">
				<div class="card-header">
					<h5>File Type Validation</h5>
				</div>
				<div class="card-body">
					<form class="dropzone dropzone-info" id="fileTypeValidation" action="/upload.php">
						<div class="dz-message needsclick">
							<i class="icon-cloud-up"></i>
							<h6>Drop files here or click to upload.</h6>
							<span class="note needsclick">(This is just a demo dropzone. Selected files are <strong>not</strong> actually uploaded.)</span>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection

@section('script')
<script src="{{asset('assets/js/dropzone/dropzone.js')}}"></script>
<script src="{{asset('assets/js/dropzone/dropzone-script.js')}}"></script>
@endsection

