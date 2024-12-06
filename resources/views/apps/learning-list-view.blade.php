@extends('layouts.simple.master')
@section('title', 'Learning List')

@section('css')
@endsection

@section('style')
@endsection

@section('breadcrumb-title')
<h3>Learning List</h3>
@endsection

@section('breadcrumb-items')
<li class="breadcrumb-item">Learning</li>
<li class="breadcrumb-item active">Learning List</li>
@endsection

@section('content')
<div class="container-fluid">
	<div class="row">
	  <div class="col-xl-9 xl-60 order-xl-0 order-1 box-col-12">
		<div class="row">
		  <div class="col-xl-12">
			<div class="card">
			  <div class="blog-box blog-list row">
				<div class="col-sm-5"><img class="img-fluid sm-100-w" src="{{ asset('assets/images/faq/1.jpg') }}" alt=""></div>
				<div class="col-sm-7">
				  <div class="blog-details">
					<div class="blog-date"><span>05</span> January 2022</div>
					<h6>Java Language </h6>
					<div class="blog-bottom-content">
					  <ul class="blog-social">
						<li>by: Paige Turner</li>
						<li>15 Hits</li>
					  </ul>
					  <hr>
					  <p class="mt-0">inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit.</p>
					</div>
				  </div>
				</div>
			  </div>
			</div>
		  </div>
		  <div class="col-xl-12">
			<div class="card">
			  <div class="blog-box blog-list row">
				<div class="col-sm-5"><img class="img-fluid sm-100-w" src="{{ asset('assets/images/faq/2.jpg') }}" alt=""></div>
				<div class="col-sm-7">
				  <div class="blog-details">
					<div class="blog-date"><span>10</span> March 2022</div>
					<h6>Web Development </h6>
					<div class="blog-bottom-content">
					  <ul class="blog-social">
						<li>by: Petey Cruiser</li>
						<li>34 Hits</li>
					  </ul>
					  <hr>
					  <p class="mt-0">inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit.</p>
					</div>
				  </div>
				</div>
			  </div>
			</div>
		  </div>
		  <div class="col-xl-4 xl-50 col-sm-6 box-col-6">
			<div class="card">
			  <div class="blog-box blog-grid text-center product-box">
				<div class="product-img"><img class="img-fluid top-radius-blog" src="{{ asset('assets/images/faq/3.jpg') }}" alt="">
				  <div class="product-hover">
					<ul>
					  <li><i class="icon-link"></i></li>
					  <li><i class="icon-import"></i></li>
					</ul>
				  </div>
				</div>
				<div class="blog-details-main">
				  <ul class="blog-social">
					<li>9 April 2018</li>
					<li>by: Admin</li>
					<li>0 Hits</li>
				  </ul>
				  <hr>
				  <h6 class="blog-bottom-details">Perspiciatis unde omnis iste natus error sit.Dummy text</h6>
				</div>
			  </div>
			</div>
		  </div>
		  <div class="col-xl-4 xl-50 col-sm-6 box-col-6">
			<div class="card">
			  <div class="blog-box blog-grid text-center product-box">
				<div class="product-img"><img class="img-fluid top-radius-blog" src="{{ asset('assets/images/faq/1.jpg') }}" alt="">
				  <div class="product-hover">
					<ul>
					  <li><i class="icon-link"></i></li>
					  <li><i class="icon-import"></i></li>
					</ul>
				  </div>
				</div>
				<div class="blog-details-main">
				  <ul class="blog-social">
					<li>9 April 2018</li>
					<li>by: Admin</li>
					<li>0 Hits</li>
				  </ul>
				  <hr>
				  <h6 class="blog-bottom-details">Perspiciatis unde omnis iste natus error sit.Dummy text</h6>
				</div>
			  </div>
			</div>
		  </div>
		  <div class="col-xl-4 xl-50 col-sm-6 box-col-6">
			<div class="card">
			  <div class="blog-box blog-grid text-center product-box">
				<div class="product-img"><img class="img-fluid top-radius-blog" src="{{ asset('assets/images/faq/4.jpg') }}" alt="">
				  <div class="product-hover">
					<ul>
					  <li><i class="icon-link"></i></li>
					  <li><i class="icon-import"></i></li>
					</ul>
				  </div>
				</div>
				<div class="blog-details-main">
				  <ul class="blog-social">
					<li>9 April 2018</li>
					<li>by: Admin</li>
					<li>0 Hits</li>
				  </ul>
				  <hr>
				  <h6 class="blog-bottom-details">Perspiciatis unde omnis iste natus error sit.Dummy text</h6>
				</div>
			  </div>
			</div>
		  </div>
		  <div class="col-xl-4 xl-50 col-sm-6 box-col-6">
			<div class="card">
			  <div class="blog-box blog-grid text-center product-box">
				<div class="product-img"><img class="img-fluid top-radius-blog" src="{{ asset('assets/images/faq/2.jpg') }}" alt="">
				  <div class="product-hover">
					<ul>
					  <li><i class="icon-link"></i></li>
					  <li><i class="icon-import"></i></li>
					</ul>
				  </div>
				</div>
				<div class="blog-details-main">
				  <ul class="blog-social">
					<li>9 April 2018</li>
					<li>by: Admin</li>
					<li>0 Hits</li>
				  </ul>
				  <hr>
				  <h6 class="blog-bottom-details">Perspiciatis unde omnis iste natus error sit.Dummy text</h6>
				</div>
			  </div>
			</div>
		  </div>
		  <div class="col-xl-4 xl-50 col-sm-6 box-col-6">
			<div class="card">
			  <div class="blog-box blog-grid text-center product-box">
				<div class="product-img"><img class="img-fluid top-radius-blog" src="{{ asset('assets/images/faq/4.jpg') }}" alt="">
				  <div class="product-hover">
					<ul>
					  <li><i class="icon-link"></i></li>
					  <li><i class="icon-import"></i></li>
					</ul>
				  </div>
				</div>
				<div class="blog-details-main">
				  <ul class="blog-social">
					<li>9 April 2018</li>
					<li>by: Admin</li>
					<li>0 Hits</li>
				  </ul>
				  <hr>
				  <h6 class="blog-bottom-details">Perspiciatis unde omnis iste natus error sit.Dummy text</h6>
				</div>
			  </div>
			</div>
		  </div>
		  <div class="col-xl-4 xl-50 col-sm-6 box-col-6">
			<div class="card">
			  <div class="blog-box blog-grid text-center product-box">
				<div class="product-img"><img class="img-fluid top-radius-blog" src="{{ asset('assets/images/faq/3.jpg') }}" alt="">
				  <div class="product-hover">
					<ul>
					  <li><i class="icon-link"></i></li>
					  <li><i class="icon-import"></i></li>
					</ul>
				  </div>
				</div>
				<div class="blog-details-main">
				  <ul class="blog-social">
					<li>9 April 2018</li>
					<li>by: Admin</li>
					<li>0 Hits</li>
				  </ul>
				  <hr>
				  <h6 class="blog-bottom-details">Perspiciatis unde omnis iste natus error sit.Dummy text</h6>
				</div>
			  </div>
			</div>
		  </div>
		</div>
	  </div>
	  <div class="col-xl-3 xl-40 box-col-12 learning-filter">
		<div class="md-sidebar"><a class="btn btn-primary email-aside-toggle md-sidebar-toggle">Learning filter</a>
		  <div class="md-sidebar-aside job-sidebar">
			<div class="default-according style-1 faq-accordion job-accordion" id="accordionoc">
			  <div class="row">
				<div class="col-xl-12">
				  <div class="card">
					<div class="card-header">
					  <h5 class="mb-0">
						<button class="btn btn-link" data-bs-toggle="collapse" data-bs-target="#collapseicon" aria-expanded="true" aria-controls="collapseicon">Find Course</button>
					  </h5>
					</div>
					<div class="collapse show" id="collapseicon" aria-labelledby="collapseicon" data-bs-parent="#accordion">
					  <div class="card-body filter-cards-view animate-chk">
						<div class="job-filter">
						  <div class="faq-form">
							<input class="form-control" type="text" placeholder="Search.."><i class="search-icon" data-feather="search"></i>
						  </div>
						</div>
						<div class="checkbox-animated">
						  <div class="learning-header"><span class="f-w-600">Categories</span></div>
						  <label class="d-block" for="chk-ani">
							<input class="checkbox_animated" id="chk-ani" type="checkbox">                      Accounting
						  </label>
						  <label class="d-block" for="chk-ani0">
							<input class="checkbox_animated" id="chk-ani0" type="checkbox">                            Design
						  </label>
						  <label class="d-block" for="chk-ani1">
							<input class="checkbox_animated" id="chk-ani1" type="checkbox">                            Development
						  </label>
						  <label class="d-block" for="chk-ani2">
							<input class="checkbox_animated" id="chk-ani2" type="checkbox">                            Management
						  </label>
						</div>
						<div class="checkbox-animated mt-0">
						  <div class="learning-header"><span class="f-w-600">Duration</span></div>
						  <label class="d-block" for="chk-ani6">
							<input class="checkbox_animated" id="chk-ani6" type="checkbox">                            0-50 hours
						  </label>
						  <label class="d-block" for="chk-ani7">
							<input class="checkbox_animated" id="chk-ani7" type="checkbox">                            50-100 hours
						  </label>
						  <label class="d-block" for="chk-ani8">
							<input class="checkbox_animated" id="chk-ani8" type="checkbox">                            100+ hours
						  </label>
						</div>
						<div class="checkbox-animated mt-0">
						  <div class="learning-header"><span class="f-w-600">Price</span></div>
						  <label class="d-block" for="edo-ani">
							<input class="radio_animated" id="edo-ani" type="radio" name="rdo-ani" checked="">                            All Courses
						  </label>
						  <label class="d-block" for="edo-ani1">
							<input class="radio_animated" id="edo-ani1" type="radio" name="rdo-ani" checked="">                            Paid Courses
						  </label>
						  <label class="d-block" for="edo-ani2">
							<input class="radio_animated" id="edo-ani2" type="radio" name="rdo-ani" checked="">                            Free Courses
						  </label>
						</div>
						<div class="checkbox-animated mt-0">
						  <div class="learning-header"><span class="f-w-600">Status</span></div>
						  <label class="d-block" for="chk-ani3">
							<input class="checkbox_animated" id="chk-ani3" type="checkbox">                            Registration
						  </label>
						  <label class="d-block" for="chk-ani4">
							<input class="checkbox_animated" id="chk-ani4" type="checkbox">                            Progress
						  </label>
						  <label class="d-block" for="chk-ani5">
							<input class="checkbox_animated" id="chk-ani5" type="checkbox">                            Completed
						  </label>
						</div>
						<button class="btn btn-primary text-center" type="button">Filter</button>
					  </div>
					</div>
				  </div>
				</div>
				<div class="col-xl-12">
				  <div class="card">
					<div class="card-header">
					  <h5 class="mb-0">
						<button class="btn btn-link" data-bs-toggle="collapse" data-bs-target="#collapseicon1" aria-expanded="true" aria-controls="collapseicon1">Categories</button>
					  </h5>
					</div>
					<div class="collapse card-body px-0 show" id="collapseicon1" aria-labelledby="collapseicon1" data-bs-parent="#accordion">
					  <div class="categories">
						<div class="learning-header"><span class="f-w-600">Design</span></div>
						<ul>
						  <li><a href="#">UI Design </a><span class="badge badge-primary pull-right">28</span></li>
						  <li><a href="#">UX Design </a><span class="badge badge-primary pull-right">35</span></li>
						  <li><a href="#">Interface Design </a><span class="badge badge-primary pull-right">17</span></li>
						  <li><a href="#">User Experience </a><span class="badge badge-primary pull-right">26</span></li>
						</ul>
					  </div>
					  <div class="categories pt-0">
						<div class="learning-header"><span class="f-w-600">Development</span></div>
						<ul>
						  <li><a href="#">Frontend Development</a><span class="badge badge-primary pull-right">48</span></li>
						  <li><a href="#">Backend Development</a><span class="badge badge-primary pull-right">19</span></li>
						</ul>
					  </div>
					</div>
				  </div>
				</div>
				<div class="col-xl-12">
				  <div class="card">
					<div class="card-header">
					  <h5 class="mb-0">
						<button class="btn btn-link" data-bs-toggle="collapse" data-bs-target="#collapseicon2" aria-expanded="true" aria-controls="collapseicon2">Upcoming Courses</button>
					  </h5>
					</div>
					<div class="collapse show" id="collapseicon2" aria-labelledby="collapseicon2" data-bs-parent="#accordion">
					  <div class="upcoming-course card-body">
						<div class="media">
						  <div class="media-body"><span class="f-w-600">UX Development</span><span class="d-block">Course By <a href="#"> Lorem ipsum</a></span><span class="d-block"><i class="fa fa-star font-warning"></i><i class="fa fa-star font-warning"></i><i class="fa fa-star font-warning"></i><i class="fa fa-star font-warning"></i><i class="fa fa-star-half-o font-warning"></i></span></div>
						  <div>
							<h5 class="mb-0 font-primary">18</h5><span class="d-block">Dec</span>
						  </div>
						</div>
						<div class="media">
						  <div class="media-body"><span class="f-w-600">Business Analyst</span><span class="d-block">Course By <a href="#">Lorem ipsum </a></span><span class="d-block"><i class="fa fa-star font-warning"></i><i class="fa fa-star font-warning"></i><i class="fa fa-star font-warning"></i><i class="fa fa-star font-warning"></i><i class="fa fa-star font-warning"></i></span></div>
						  <div>
							<h5 class="mb-0 font-primary">28</h5><span class="d-block">Dec</span>
						  </div>
						</div>
						<div class="media">
						  <div class="media-body"><span class="f-w-600">Web Development</span><span class="d-block">Course By <a href="#">Lorem ipsum </a></span><span class="d-block"><i class="fa fa-star font-warning"></i><i class="fa fa-star font-warning"></i><i class="fa fa-star font-warning"></i><i class="fa fa-star font-warning"></i><i class="fa fa-star-o font-warning"></i></span></div>
						  <div>
							<h5 class="mb-0 font-primary">5</h5><span class="d-block">Jan</span>
						  </div>
						</div>
					  </div>
					</div>
				  </div>
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