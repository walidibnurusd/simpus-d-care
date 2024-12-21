@extends('layouts.simple.master')
@section('title', 'Date Picker')

@section('css')

@endsection

@section('style')
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/vendors/date-picker.css')}}">
@endsection

@section('breadcrumb-title')
<h3>Date Picker</h3>
@endsection

@section('breadcrumb-items')
<li class="breadcrumb-item">Form Widgets</li>
<li class="breadcrumb-item active">Date Picker</li>
@endsection

@section('content')
<div class="container-fluid">
	<div class="card">
		<div class="card-header">
			<h5>Date Picker</h5>
		</div>
		<div class="card-body">
			<div class="row">
				<div class="col-md-12">
					<div class="date-picker">
						<form class="theme-form">
							<div class="mb-3 row g-3">
								<label class="col-sm-3 col-form-label text-sm-end">Default</label>
								<div class="col-xl-5 col-sm-9">
									<div class="input-group">
										<input class="datepicker-here form-control digits" type="text" data-language="en">
									</div>
								</div>
							</div>
							<div class="mb-3 row g-3">
								<label class="col-sm-3 col-form-label text-sm-end">Selecting multiple dates</label>
								<div class="col-xl-5 col-sm-9">
									<input class="datepicker-here form-control digits" type="text" data-multiple-dates="3" data-multiple-dates-separator=", " data-language="en">
								</div>
							</div>
							<div class="mb-3 row g-3">
								<label class="col-sm-3 col-form-label text-sm-end">Month selection</label>
								<div class="col-xl-5 col-sm-9">
									<input class="datepicker-here form-control digits" type="text" data-language="en" data-min-view="months" data-view="months" data-date-format="MM yyyy">
								</div>
							</div>
							<div class="mb-3 row g-3">
								<label class="col-sm-3 col-form-label text-sm-end">Minimum and maximum dates</label>
								<div class="col-xl-5 col-sm-9">
									<input class="form-control digits" id="minMaxExample" type="text">
								</div>
							</div>
							<div class="mb-3 row g-3">
								<label class="col-sm-3 col-form-label text-sm-end">Range of dates</label>
								<div class="col-xl-5 col-sm-9">
									<input class="datepicker-here form-control digits" type="text" data-range="true" data-multiple-dates-separator=" - " data-language="en">
								</div>
							</div>
							<div class="mb-3 row g-3">
								<label class="col-sm-3 col-form-label text-sm-end">Disable days of week</label>
								<div class="col-xl-5 col-sm-9">
									<input class="form-control digits" id="disabled-days" type="text">
								</div>
							</div>
							<div class="mb-3 row g-3">
								<label class="col-sm-3 col-form-label text-sm-end">Orientation</label>
								<div class="col-xl-5 col-sm-9">
									<div class="form-row">
										<div class="col-md-12 mb-2">
											<input class="datepicker-here form-control digits" type="text" data-language="en" data-multiple-dates-separator=", " data-position="top left" placeholder="top left">
										</div>
										<div class="col-md-12 mb-2">
											<input class="datepicker-here form-control digits" type="text" data-language="en" data-multiple-dates-separator=", " data-position="top right" placeholder="top right">
										</div>
										<div class="col-md-12 mb-2">
											<input class="datepicker-here form-control digits" type="text" data-language="en" data-multiple-dates-separator=", " data-position="bottom left" placeholder="bottom left">
										</div>
										<div class="col-md-12">
											<input class="datepicker-here form-control digits" type="text" data-language="en" data-multiple-dates-separator=", " data-position="bottom right" placeholder="bottom right">
										</div>
									</div>
								</div>
							</div>
							<div class="mb-3 row g-3 mb-0">
								<label class="col-sm-3 col-form-label text-sm-end">Permanently visible Datepicker</label>
								<div class="col-sm-3">
									<div class="datepicker-here" data-language="en"></div>
								</div>
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
<script src="{{asset('assets/js/datepicker/date-picker/datepicker.js')}}"></script>
<script src="{{asset('assets/js/datepicker/date-picker/datepicker.en.js')}}"></script>
<script src="{{asset('assets/js/datepicker/date-picker/datepicker.custom.js')}}"></script>
@endsection