@extends('layouts.simple.master')
@section('title', 'JS Grid Tables')

@section('css')

@endsection

@section('style')
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/vendors/jsgrid.css')}}">
@endsection

@section('breadcrumb-title')
<h3>JS Grid Tables</h3>
@endsection

@section('breadcrumb-items')
<li class="breadcrumb-item">Tables</li>
<li class="breadcrumb-item active">JS Grid Tables</li>
@endsection

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-sm-12">
			<div class="card">
				<div class="card-header">
					<h5>Basic Scenario</h5>
					<span>Grid with filtering, editing, inserting, deleting, sorting and paging. Data provided by controller.</span>
				</div>
				<div class="card-body">
					<div id="basicScenario"></div>
				</div>
			</div>
		</div>
		<div class="col-sm-12">
			<div class="card">
				<div class="card-header">
					<h5>Sorting Scenario</h5>
					<span>Sorting can be done not only with column header interaction, but also with sort method.</span>
				</div>
				<div class="card-body">
					<div class="sort-panel mb-3">
						<label>
							Sorting Field:
							<select class="btn btn-primary dropdown-toggle btn-sm" id="sortingField">
								<option>Name</option>
								<option>Age</option>
								<option>Address</option>
								<option>Country</option>
								<option>Married</option>
							</select>
						</label>
						<div class="d-inline">
							<button class="btn btn-sm btn-secondary" id="sort" type="button">Sort</button>
						</div>
					</div>
					<div class="js-shorting" id="sorting-table"></div>
				</div>
			</div>
		</div>
		<div class="col-sm-12">
			<div class="card">
				<div class="card-header">
					<h5>Batch Delete</h5>
					<span>Cell content of every column can be customized with itemTemplate, headerTemplate, filterTemplate and insertTemplate functions specified in field config. This example shows how to implement batch deleting with custom field for selecting items.</span>
				</div>
				<div class="card-body">
					<div id="batchDelete"></div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection

@section('script')
<script src="{{asset('assets/js/jsgrid/jsgrid.min.js')}}"></script>
<script src="{{asset('assets/js/jsgrid/griddata.js')}}"></script>
<script src="{{asset('assets/js/jsgrid/jsgrid.js')}}"></script>
@endsection