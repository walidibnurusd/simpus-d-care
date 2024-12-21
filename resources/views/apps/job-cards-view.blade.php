@extends('layouts.simple.master')
@section('title', 'Cards View')

@section('css')
@endsection

@section('style')
@endsection

@section('breadcrumb-title')
<h3>Cards View</h3>
@endsection

@section('breadcrumb-items')
<li class="breadcrumb-item">Job Search</li>
<li class="breadcrumb-item active">Cards View</li>
@endsection

@section('content')
<div class="container-fluid">
	<div class="row">
	  <div class="col-xl-3 xl-40 box-col-12">
		<div class="md-sidebar"><a class="btn btn-primary email-aside-toggle md-sidebar-toggle">Job filter</a>
		  <div class="md-sidebar-aside job-sidebar">
			<div class="default-according style-1 faq-accordion job-accordion">
			  <div class="accordion" id="accordionExample">
				<div class="card">
				  <div class="card-header" id="headingOne">
					<h2 class="mb-0">
					  <button class="btn btn-link btn-block text-start" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">Filter</button>
					</h2>
				  </div>
				  <div class="collapse show" id="collapseOne" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
					<div class="card-body filter-cards-view animate-chk">
					  <div class="job-filter mb-2">
						<div class="faq-form">
						  <input class="form-control" type="text" placeholder="Search.."><i class="search-icon" data-feather="search"></i>
						</div>
					  </div>
					  <div class="job-filter">
						<div class="faq-form">
						  <input class="form-control" type="text" placeholder="location.."><i class="search-icon" data-feather="map-pin"></i>
						</div>
					  </div>
					  <div class="checkbox-animated">
						<label class="d-block" for="chk-ani">
						  <input class="checkbox_animated" id="chk-ani" type="checkbox"> Full-time (8688)
						</label>
						<label class="d-block" for="chk-ani1">
						  <input class="checkbox_animated" id="chk-ani1" type="checkbox">Contract (503)
						</label>
						<label class="d-block" for="chk-ani2">
						  <input class="checkbox_animated" id="chk-ani2" type="checkbox">Part-time (288)
						</label>
						<label class="d-block" for="chk-ani3">
						  <input class="checkbox_animated" id="chk-ani3" type="checkbox">Internship (236)
						</label>
						<label class="d-block" for="chk-ani4">
						  <input class="checkbox_animated" id="chk-ani4" type="checkbox">Temporary (146)
						</label>
						<label class="d-block" for="chk-ani5">
						  <input class="checkbox_animated" id="chk-ani5" type="checkbox">Commission (25)
						</label>
					  </div>
					  <button class="btn btn-primary text-center" type="button">Find jobs</button>
					</div>
				  </div>
				</div>
				<div class="card">
				  <div class="card-header" id="headingTwo">
					<h2 class="mb-0">
					  <button class="btn btn-link btn-block text-start collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">Location</button>
					</h2>
				  </div>
				  <div class="collapse show" id="collapseTwo" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
					<div class="card-body animate-chk">
					  <div class="location-checkbox">
						<label class="d-block" for="chk-ani6">
						  <input class="checkbox_animated" id="chk-ani6" type="checkbox">                          New York<span class="d-block">NY (399)</span>
						</label>
						<label class="d-block" for="chk-ani7">
						  <input class="checkbox_animated" id="chk-ani7" type="checkbox">                           San Francisco<span class="d-block">CA (252)</span>
						</label>
						<label class="d-block mb-0" for="chk-ani8">
						  <input class="checkbox_animated" id="chk-ani8" type="checkbox">                            Washington<span class="d-block">DC (226)</span>
						</label>
						<label class="d-block mb-0" for="chk-ani9">
						  <input class="checkbox_animated" id="chk-ani9" type="checkbox">                           Seattle<span class="d-block">WA (242)</span>
						</label>
						<label class="d-block mb-0" for="chk-ani10">
						  <input class="checkbox_animated" id="chk-ani10" type="checkbox">                          Chicago<span class="d-block">IL (187)</span>
						</label>
					  </div>
					</div>
					<button class="btn btn-block btn-primary text-center" type="button">All Locations</button>
				  </div>
				</div>
				<div class="card">
				  <div class="card-header" id="headingThree">
					<h2 class="mb-0">
					  <button class="btn btn-link btn-block text-start collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="true" aria-controls="collapseThree">Job Title</button>
					</h2>
				  </div>
				  <div class="collapse show" id="collapseThree" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
					<div class="card-body animate-chk">
					  <label class="d-block" for="chk-ani11">
						<input class="checkbox_animated" id="chk-ani11" type="checkbox">                          UI/Ux designer(25)
					  </label>
					  <label class="d-block" for="chk-ani12">
						<input class="checkbox_animated" id="chk-ani12" type="checkbox">                          Graphic designer(10)
					  </label>
					  <label class="d-block" for="chk-ani13">
						<input class="checkbox_animated" id="chk-ani13" type="checkbox">                          Front end designer(15)
					  </label>
					  <label class="d-block" for="chk-ani14">
						<input class="checkbox_animated" id="chk-ani14" type="checkbox">                          PHP developer(42)
					  </label>
					  <label class="d-block mb-0" for="chk-ani15">
						<input class="checkbox_animated" id="chk-ani15" type="checkbox">                         React Developer(5)
					  </label>
					</div>
					<button class="btn btn-block btn-primary text-center" type="button">All Job Title</button>
				  </div>
				</div>
				<div class="card">
				  <div class="card-header" id="headingFour">
					<h2 class="mb-0">
					  <button class="btn btn-link btn-block text-start collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="true" aria-controls="collapseFour">Industry</button>
					</h2>
				  </div>
				  <div class="collapse show" id="collapseFour" aria-labelledby="headingFour" data-bs-parent="#accordionExample">
					<div class="card-body animate-chk">
					  <label class="d-block" for="chk-ani16">
						<input class="checkbox_animated" id="chk-ani16" type="checkbox">                          Computer Software(14)
					  </label>
					  <label class="d-block" for="chk-ani17">
						<input class="checkbox_animated" id="chk-ani17" type="checkbox">                          IT Engineer(10)
					  </label>
					  <label class="d-block" for="chk-ani18">
						<input class="checkbox_animated" id="chk-ani18" type="checkbox">                          Service industry(20)
					  </label>
					  <label class="d-block" for="chk-ani19">
						<input class="checkbox_animated" id="chk-ani19" type="checkbox">                         Accounting(34)
					  </label>
					  <label class="d-block mb-0" for="chk-ani20">
						<input class="checkbox_animated" id="chk-ani20" type="checkbox">                          Financial Services(5)
					  </label>
					</div>
					<button class="btn btn-block btn-primary text-center" type="button">All Industries</button>
				  </div>
				</div>
				<div class="card">
				  <div class="card-header" id="headingFive">
					<h2 class="mb-0">
					  <button class="btn btn-link btn-block text-start collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="true" aria-controls="collapseFive">Specific skills</button>
					</h2>
				  </div>
				  <div class="collapse show" id="collapseFive" aria-labelledby="headingFive" data-bs-parent="#accordionExample">
					<div class="card-body animate-chk">
					  <label class="d-block" for="chk-ani21">
						<input class="checkbox_animated" id="chk-ani21" type="checkbox">                          HTML,scss & sass
					  </label>
					  <label class="d-block" for="chk-ani22">
						<input class="checkbox_animated" id="chk-ani22" type="checkbox">                          Javascript
					  </label>
					  <label class="d-block" for="chk-ani23">
						<input class="checkbox_animated" id="chk-ani23" type="checkbox">                          Node.js
					  </label>
					  <label class="d-block" for="chk-ani24">
						<input class="checkbox_animated" id="chk-ani24" type="checkbox">                          Gulp & Pug
					  </label>
					  <label class="d-block mb-0" for="chk-ani25">
						<input class="checkbox_animated" id="chk-ani25" type="checkbox">                          Angular.js
					  </label>
					</div>
					<button class="btn btn-block btn-primary text-center" type="button">All Skills </button>
				  </div>
				</div>
			  </div>
			</div>
		  </div>
		</div>
	  </div>
	  <div class="col-xl-9 xl-60 box-col-12">
		<div class="row">
		  <div class="col-xl-6 xl-100">
			<div class="card">
			  <div class="job-search">
				<div class="card-body">
				  <div class="media"><img class="img-40 img-fluid m-r-20" src="{{ asset('assets/images/job-search/1.jpg') }}" alt="">
					<div class="media-body">
					  <h6 class="f-w-600"><a href="#">UI/UX IT Frontend Developer</a><span class="badge badge-primary pull-right">New</span></h6>
					  <p>(L6) Salt Lake City, UT<span><i class="fa fa-star font-warning"></i><i class="fa fa-star font-warning"></i><i class="fa fa-star font-warning"></i><i class="fa fa-star font-warning"></i><i class="fa fa-star font-warning"></i></span></p>
					</div>
				  </div>
				  <p>We are looking for an experienced and Cuba designer and/or frontend engineer with expertise in accessibility to join our team , 3+ years of experience working in as a Frontend Engineer or comparable role. You won’t be a team of one though — you’ll be collaborating closely with other...</p>
				</div>
			  </div>
			</div>
		  </div>
		  <div class="col-xl-6 xl-100">
			<div class="card">
			  <div class="job-search">
				<div class="card-body">
				  <div class="media"><img class="img-40 img-fluid m-r-20" src="{{ asset('assets/images/job-search/2.jpg') }}" alt="">
					<div class="media-body">
					  <h6 class="f-w-600"><a href="#">React/React Native Developer </a><span class="badge badge-primary pull-right">New</span></h6>
					  <p>San <span>Diego, CA </span><span><i class="fa fa-star font-warning"></i><i class="fa fa-star font-warning"></i><i class="fa fa-star font-warning"></i><i class="fa fa-star font-warning"></i><i class="fa fa-star font-warning-o"></i></span></p>
					</div>
				  </div>
				  <p>Ideally 2+ years experience with React. Bonus points if you have React Native experience. This is an incredibly exciting opportunity to gain commercial , Professional experience of React Native and other front end frameworks. Transform product wireframes into responsive, mobile user interface</p>
				</div>
			  </div>
			</div>
		  </div>
		  <div class="col-xl-6 xl-100">
			<div class="card ribbon-vertical-left-wrapper">
			  <div class="ribbon ribbon-bookmark ribbon-vertical-left ribbon-secondary"><i class="icofont icofont-love"></i></div>
			  <div class="job-search">
				<div class="card-body">
				  <div class="media"><img class="img-40 img-fluid m-r-20" src="{{ asset('assets/images/job-search/3.jpg') }}" alt="">
					<div class="media-body">
					  <h6 class="f-w-600"><a href="#">Senior UX designer</a><span class="pull-right">2 days ago</span></h6>
					  <p>Minneapolis, MN<span><i class="fa fa-star font-warning"></i><i class="fa fa-star font-warning"></i><i class="fa fa-star font-warning"></i><i class="fa fa-star font-warning-half-o"></i><i class="fa fa-star font-warning-o"></i></span></p>
					</div>
				  </div>
				  <p>The designer will apply Lean UX and Design Thinking practices in a highly collaborative, fast-paced, distributed environment You have 4+ years of UX experience. You support UX leadership by providing continuous feedback regarding the evolution of team process standards</p>
				</div>
			  </div>
			</div>
		  </div>
		  <div class="col-xl-6 xl-100">
			<div class="card">
			  <div class="job-search">
				<div class="card-body">
				  <div class="media"><img class="img-40 img-fluid m-r-20" src="{{ asset('assets/images/job-search/4.jpg') }}" alt="">
					<div class="media-body">
					  <h6 class="f-w-600"><a href="#">Front end web developer</a><span class="pull-right">3 days ago</span></h6>
					  <p>Cisco <span>Lelystad, Netherlands </span><span><i class="fa fa-star font-warning"></i><i class="fa fa-star font-warning"></i><i class="fa fa-star font-warning"></i><i class="fa fa-star font-warning"></i><i class="fa fa-star font-warning-half-o"></i></span></p>
					</div>
				  </div>
				  <p>Insipidity the sufficient discretion imprudence resolution sir him decisively. Proceed how any engaged visitor. Explained propriety off out perpetual his you. Feel sold off felt nay rose met you. We so entreaties cultivated astonished is. Was sister for few longer mrs sudden talent become.</p>
				</div>
			  </div>
			</div>
		  </div>
		  <div class="col-xl-6 xl-100">
			<div class="card">
			  <div class="job-search">
				<div class="card-body">
				  <div class="media"><img class="img-40 img-fluid m-r-20" src="{{ asset('assets/images/job-search/5.jpg') }}" alt="">
					<div class="media-body">
					  <h6 class="f-w-600"><a href="#">Graphic designer</a><span class="pull-right">3 days ago</span></h6>
					  <p>Infosys <span>Lelystad, Netherlands </span><span><i class="fa fa-star font-warning"></i><i class="fa fa-star font-warning"></i><i class="fa fa-star font-warning"></i><i class="fa fa-star font-warning-half-o"></i><i class="fa fa-star font-warning-o"></i></span></p>
					</div>
				  </div>
				  <p>Contented get distrusts certainty nay are frankness concealed ham. On unaffected resolution on considered of. No thought me husband or colonel forming effects. End sitting shewing who saw besides son musical adapted. Contrasted interested eat alteration pianoforte sympathize was.</p>
				</div>
			  </div>
			</div>
		  </div>
		  <div class="col-xl-6 xl-100">
			<div class="card">
			  <div class="job-search">
				<div class="card-body">
				  <div class="media"><img class="img-40 img-fluid m-r-20" src="{{ asset('assets/images/job-search/6.jpg') }}" alt="">
					<div class="media-body">
					  <h6 class="f-w-600"><a href="#">Designer, CRM</a><span class="pull-right">3 days ago</span></h6>
					  <p>Citrix <span>Lelystad, Netherlands </span><span><i class="fa fa-star font-warning"></i><i class="fa fa-star font-warning"></i><i class="fa fa-star font-warning"></i><i class="fa fa-star font-warning-o"></i><i class="fa fa-star font-warning-o"></i></span></p>
					</div>
				  </div>
				  <p>Situation admitting promotion at or to perceived be. Mr acuteness we as estimable enjoyment up. An held late as felt know. Learn do allow solid to grave. Middleton suspicion age her attention. Chiefly several bed its wishing. Is so moments on chamber pressed to. Doubtful yet way properly answered.</p>
				</div>
			  </div>
			</div>
		  </div>
		  <div class="col-xl-6 xl-100">
			<div class="card ribbon-vertical-left-wrapper">
			  <div class="ribbon ribbon-bookmark ribbon-vertical-left ribbon-secondary"><i class="icofont icofont-love"></i></div>
			  <div class="job-search">
				<div class="card-body">
				  <div class="media"><img class="img-40 img-fluid m-r-20" src="{{ asset('assets/images/job-search/2.jpg') }}" alt="">
					<div class="media-body">
					  <h6 class="f-w-600"><a href="#">React/React Native Developer </a><span class="pull-right">5 days ago</span></h6>
					  <p>San <span>Diego, CA</span><span><i class="fa fa-star font-warning"></i><i class="fa fa-star font-warning"></i><i class="fa fa-star font-warning"></i><i class="fa fa-star font-warning"></i><i class="fa fa-star font-warning-o"></i></span></p>
					</div>
				  </div>
				  <p>Ideally 2+ years experience with React. Bonus points if you have React Native experience. This is an incredibly exciting opportunity to gain commercial , Professional experience of React Native and other front end frameworks. Transform product wireframes into responsive</p>
				</div>
			  </div>
			</div>
		  </div>
		  <div class="col-xl-6 xl-100">
			<div class="card">
			  <div class="job-search">
				<div class="card-body">
				  <div class="media"><img class="img-40 img-fluid m-r-20" src="{{ asset('assets/images/job-search/3.jpg') }}" alt="">
					<div class="media-body">
					  <h6 class="f-w-600"><a href="#">Senior UX designer</a><span class="pull-right">5 days ago</span></h6>
					  <p>Minneapolis, MN<span><i class="fa fa-star font-warning"></i><i class="fa fa-star font-warning"></i><i class="fa fa-star font-warning"></i><i class="fa fa-star font-warning-half-o"></i><i class="fa fa-star font-warning-o"></i></span></p>
					</div>
				  </div>
				  <p>The designer will apply Lean UX and Design Thinking practices in a highly collaborative, fast-paced, distributed environment You have 4+ years of UX experience. You support UX leadership by providing continuous feedback regarding the evolution of team process standards</p>
				</div>
			  </div>
			</div>
		  </div>
		  <div class="col-xl-6 xl-100">
			<div class="card">
			  <div class="job-search">
				<div class="card-body">
				  <div class="media"><img class="img-40 img-fluid m-r-20" src="{{ asset('assets/images/job-search/5.jpg') }}" alt="">
					<div class="media-body">
					  <h6 class="f-w-600"><a href="#">Graphic designer</a><span class="pull-right">3 days ago</span></h6>
					  <p>Infosys <span>Lelystad, Netherlands </span><span><i class="fa fa-star font-warning"></i><i class="fa fa-star font-warning"></i><i class="fa fa-star font-warning"></i><i class="fa fa-star font-warning-half-o"></i><i class="fa fa-star font-warning-o"></i></span></p>
					</div>
				  </div>
				  <p>Contented get distrusts certainty nay are frankness concealed ham. On unaffected resolution on considered of. No thought me husband or colonel forming effects. End sitting shewing who saw besides son musical adapted. Contrasted interested eat alteration pianoforte sympathize was.</p>
				</div>
			  </div>
			</div>
		  </div>
		  <div class="col-xl-6 xl-100">
			<div class="card">
			  <div class="job-search">
				<div class="card-body">
				  <div class="media"><img class="img-40 img-fluid m-r-20" src="{{ asset('assets/images/job-search/6.jpg') }}" alt="">
					<div class="media-body">
					  <h6 class="f-w-600"><a href="#">Designer, CRM</a><span class="pull-right">3 days ago</span></h6>
					  <p>Citrix <span>Lelystad, Netherlands </span><span><i class="fa fa-star font-warning"></i><i class="fa fa-star font-warning"></i><i class="fa fa-star font-warning"></i><i class="fa fa-star font-warning-o"></i><i class="fa fa-star font-warning-o"></i></span></p>
					</div>
				  </div>
				  <p>Situation admitting promotion at or to perceived be. Mr acuteness we as estimable enjoyment up. An held late as felt know. Learn do allow solid to grave. Middleton suspicion age her attention. Chiefly several bed its wishing. Is so moments on chamber pressed to. Doubtful yet way properly answered.</p>
				</div>
			  </div>
			</div>
		  </div>
		  <div class="col-xl-6 xl-100">
			<div class="card">
			  <div class="job-search">
				<div class="card-body">
				  <div class="media"><img class="img-40 img-fluid m-r-20" src="{{ asset('assets/images/job-search/1.jpg') }}" alt="">
					<div class="media-body">
					  <h6 class="f-w-600"><a href="#">UI/UX IT Frontend Developer</a><span class="badge badge-primary pull-right">New</span></h6>
					  <p>(L6) Salt Lake City, UT<span><i class="fa fa-star font-warning"></i><i class="fa fa-star font-warning"></i><i class="fa fa-star font-warning"></i><i class="fa fa-star font-warning"></i><i class="fa fa-star font-warning"></i></span></p>
					</div>
				  </div>
				  <p>We are looking for an experienced and Cuba designer and/or frontend engineer with expertise in accessibility to join our team , 3+ years of experience working in as a Frontend Engineer or comparable role. You won’t be a team of one though — you’ll be collaborating closely with other...</p>
				</div>
			  </div>
			</div>
		  </div>
		  <div class="col-xl-6 xl-100">
			<div class="card">
			  <div class="job-search">
				<div class="card-body">
				  <div class="media"><img class="img-40 img-fluid m-r-20" src="{{ asset('assets/images/job-search/2.jpg') }}" alt="">
					<div class="media-body">
					  <h6 class="f-w-600"><a href="#">React/React Native Developer </a><span class="badge badge-primary pull-right">New</span></h6>
					  <p>San <span>Diego, CA </span><span><i class="fa fa-star font-warning"></i><i class="fa fa-star font-warning"></i><i class="fa fa-star font-warning"></i><i class="fa fa-star font-warning"></i><i class="fa fa-star font-warning-o"></i></span></p>
					</div>
				  </div>
				  <p>Ideally 2+ years experience with React. Bonus points if you have React Native experience. This is an incredibly exciting opportunity to gain commercial , Professional experience of React Native and other front end frameworks. Transform product wireframes into responsive, mobile user interface</p>
				</div>
			  </div>
			</div>
		  </div>
		  <div class="col-xl-6 xl-100">
			<div class="card">
			  <div class="job-search">
				<div class="card-body">
				  <div class="media"><img class="img-40 img-fluid m-r-20" src="{{ asset('assets/images/job-search/4.jpg') }}" alt="">
					<div class="media-body">
					  <h6 class="f-w-600"><a href="#">Front end web developer</a><span class="pull-right">3 days ago</span></h6>
					  <p>Cisco <span>Lelystad, Netherlands </span><span><i class="fa fa-star font-warning"></i><i class="fa fa-star font-warning"></i><i class="fa fa-star font-warning"></i><i class="fa fa-star font-warning"></i><i class="fa fa-star font-warning-half-o"></i></span></p>
					</div>
				  </div>
				  <p>Insipidity the sufficient discretion imprudence resolution sir him decisively. Proceed how any engaged visitor. Explained propriety off out perpetual his you. Feel sold off felt nay rose met you. We so entreaties cultivated astonished is. Was sister for few longer mrs sudden talent become.</p>
				</div>
			  </div>
			</div>
		  </div>
		  <div class="col-xl-6 xl-100">
			<div class="card ribbon-vertical-left-wrapper">
			  <div class="ribbon ribbon-bookmark ribbon-vertical-left ribbon-secondary"><i class="icofont icofont-love"></i></div>
			  <div class="job-search">
				<div class="card-body">
				  <div class="media"><img class="img-40 img-fluid m-r-20" src="{{ asset('assets/images/job-search/3.jpg') }}" alt="">
					<div class="media-body">
					  <h6 class="f-w-600"><a href="#">Senior UX designer</a><span class="pull-right">2 days ago</span></h6>
					  <p>Minneapolis, MN<span><i class="fa fa-star font-warning"></i><i class="fa fa-star font-warning"></i><i class="fa fa-star font-warning"></i><i class="fa fa-star font-warning-half-o"></i><i class="fa fa-star font-warning-o"></i></span></p>
					</div>
				  </div>
				  <p>The designer will apply Lean UX and Design Thinking practices in a highly collaborative, fast-paced, distributed environment You have 4+ years of UX experience. You support UX leadership by providing continuous feedback regarding the evolution of team process standards</p>
				</div>
			  </div>
			</div>
		  </div>
		  <div class="col-sm-12">
			<div class="job-pagination">
			  <nav aria-label="Page navigation example">
				<ul class="pagination pagination-primary">
				  <li class="page-item disabled"><a class="page-link" href="#">Previous</a></li>
				  <li class="page-item active"><a class="page-link" href="#">1</a></li>
				  <li class="page-item"><a class="page-link" href="#">2</a></li>
				  <li class="page-item"><a class="page-link" href="#">3</a></li>
				  <li class="page-item"><a class="page-link" href="#">Next</a></li>
				</ul>
			  </nav>
			</div>
		  </div>
		</div>
	  </div>
	</div>
  </div>
@endsection

@section('script')

@endsection