@extends('layouts.simple.master')
@section('title', 'Management')

@section('css')
    
@endsection

@section('style')
<style>
    /* Target the header cells in the DataTable */
    #validation_datatable thead th {
        color: white; /* Change this to your desired color */
    }
</style>

<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/animate.css') }}">
@endsection

@section('breadcrumb-title')
    <h3>Management</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">Dashboard</li>
    <li class="breadcrumb-item active">Management</li>
@endsection

@section('content')
    <div class="main-content container-fluid">
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="card">
                    <div class="card-header" style="background-color:#7630b8; ">
                        <h5 style="color:white; font-weight:bold;">Filter By :</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-3 col-md-3 col-xs-12 col-12" style="padding-top:20px;">
                                <div class="form-group">
                                    <label class="label-select" for="mediaLabel">Acceptance:</label>
                                    <select onchange="changeFilter();" class="form-select status_post" id="status_post"
                                        name="status_post" aria-label="Default select example">
                                        <option value="empty" selected>On Review Post</option>
                                        <option value="valid">Valid Post</option>
                                        <option value="reject">Reject Post</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-5 col-md-5 col-xs-12 col-12 campaign_filter" style="padding-top:20px;">
                                <div class="form-group">
                                    <label class="label-select" for="mediaLabel">User Category :</label>
                                    <select class="form-select campaign_post" onchange="changeFilter();" id="campaign_post"
                                        name="campaign_post">
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-xs-12 col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-lg-4 col-md-4 col-xs-4 col-4">
                                <div class="form-group">
                                    <label class="label-select" for="mediaLabel">Media :</label>
                                    <select id="media_id" name="media_id" required onchange="changeFilter();"
                                        class="media_id wd-100 form-control form-control-lg" style="width:100%;">
                                        <option value="empty" selected>Choose Your Media.</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-xs-4 col-4">
                                <div class="form-group">
                                    <label class="label-select" for="mediaLabel">Date :</label>
                                    <input id="datefilter" name="datefilter" style="width:100%;" onchange="changeFilter();"
                                        class="form-control form-control-lg" type="text" />
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-xs-4 col-4">
                                <div class="text-right">
                                    <button type="button" class="btn btn-danger" id="btnDelete"
                                        onclick="deletePost();">Delete</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-xs-12 col-12 table-responsive-lg">
                                <table class="wd-100 ft-tb table table-striped" id="validation_datatable"
                                    style="margin-left:5px;margin-right:5px;width:100%;">
                                    <thead class="text-center" style="background-color:#7630b8; color:white;">

                                        <tr class="cl-1" style="color:white">
                                            <th class="text-center"></th>
                                            <th class="text-center">No</th>
                                            <th class="text-center">Agent Name</th>
                                            <th class="text-center">Media</th>
                                            <th class="text-center">Picture</th>
                                            <th class="text-center">Datetime</th>
                                            <th class="text-center">Stats</th>
                                            <th class="text-center">ACTION</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Basic Inputs end -->
    <!-- Modal -->
    <div class="modal fade" id="modalValid" tabindex="-1" style="padding:20px;" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background-color:#7630b8;">
                    <h5 class="modal-title" style="color:white;" id="exampleModalLabel">Validation Post</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span style="color:white;"
                            aria-hidden="true">x</span></button>
                </div>
                <div class="modal-body insert-overlay">
                    <form id="postValid">
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-xs-6 col-6" id="imagePost">

                            </div>
                            <div class="col-lg-6 col-md-6 col-xs-6 col-6 loader_active">
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-xs-12 col-12">
                                        <div class="form-group">
                                            <label class="label-select" for="mediaLabel">Campaign :</label>
                                            <select id="missionType" name="missionType" required
                                                onchange="getMissionType();"
                                                class="missionType wd-100 form-control form-control-lg"
                                                style="width:100%;">

                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label class="label-select" for="mediaLabel">Acceptance :</label>
                                            <select id="acceptance" name="acceptance" onchange="showHideDesc();" required
                                                class="acceptanceSelect wd-100 form-control form-control-lg"
                                                style="width:100%;">
                                                <option value=''>Choose Acceptance</option>
                                                <option value='reject'>Reject</option>
                                                <option value='valid'>Valid</option>
                                            </select>
                                            <div id="errAccept"></div>
                                        </div>
                                        <div class="form-group showDesc">
                                            <label class="label-select" for="mediaLabel">Description :</label>
                                            <textarea style="width:100%;border-bottom-left-radius: 10px !important;border-bottom-right-radius: 10px !important;"
                                                id="description" name="description" rows="4" style="width:100%;" placeholder="Type Description"></textarea>
                                            <div id="errAccept"></div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-xs-12 col-12 showCategory">
                                        <div class="form-group">
                                            <label class="label-select" for="typeLabel"> Mission :</label>
                                            <div id="erMission"></div>
                                            <select id="id_mission" name="id_mission" multiple="multiple" required
                                                class="id_mission wd-100 form-control form-control-lg"
                                                style="width:100%;"></select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" style="background-color:#7630b8;color:white;"
                        id="btnValid" onclick="postValid();">Validation</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal end -->
    </div>
@endsection

@section('script')
    <script>
        var user_name = "{{ auth()->user()->name }}";
        if (user_name == "") {
            window.location.href = '/';
        }
        var BASE_URL = "{{ url('/') }}";
        var token = "{{ csrf_token() }}";
    </script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@2.1.7/dist/loadingoverlay.min.js"></script>
    <script type="text/javascript" src="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js"></script>
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css" />
    
    <script src="{{ asset('assets/js/additional/management.js') }}"></script>

    <script>
        $(document).ready(function() {
            $('.missionType').select2();
            $('.media_id').select2();
            $(".id_mission").select2({
                placeholder: "Select a Mission",
            });
            $('.campaign_post').select2();
            $('.status_post').select2();
            $('.acceptanceSelect').select2();
            $('.showDesc').hide();
            $('.showCategory').hide();
            getActiveMissionFilter();
            comboMedia();
            validation_datatable.draw();

            $("#postValid").validate({
                rules: {
                    missionType: "required",
                    acceptance: "required",
                },
                messages: {
                    missionType: "<font style='color:red;'>Please Choose Mission Name</font>",
                    acceptance: "<font style='color:red;'>Please Choose Acceptance</font>",
                }
            });

        });

        function showHideDesc() {
            if ($('#acceptance').val() == 'reject') {
                $('.showDesc').show();
            } else {
                $('.showDesc').show();
            }
        }
    </script>
@endsection
