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
<div class="main-content container-fluid" style="padding-top: 10px;">

    <!-- <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="card">
                <div class="card-header cl-1">
                    <h4 class="card-title text-cl1">Filter</h4>
                </div>
                <div class="card-body" style="padding: 10px;">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 text-right">
                            <div id="date-picker-example" class="md-form md-outline input-with-post-icon datepicker" inline="true">
                                <input placeholder="Select Month" type="month" id="monthFilter" name="monthFilter" class="form-control">
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 text-right">
                            <div id="date-picker-example" class="md-form md-outline input-with-post-icon datepicker" inline="true">
                                <input class="yearsFilter form-control" id="yearFilter" name="yearFilter" placeholder="Select Year" type="text">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> -->

    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="card">
                <div class="card-header cl-1">
                    <h4 class="card-title text-cl1">Total Post </h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12 col-md-12">
                            <div class="table-responsive">
                                <figure class="highcharts-figure">
                                    <div id="containerPost"></div>
                                </figure>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- <div class="row">
        <div class="col-lg-6 col-md-6">
            <div class="card">
                <div class="card-header cl-1">
                    <h4 class="card-title text-cl1">Total Sales (Qty)</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12 col-md-12">
                            <div class="table-responsive">
                                <figure class="highcharts-figure">
                                    <div id="containerSales"></div>
                                </figure>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-6">
            <div class="card">
                <div class="card-header cl-1">
                    <h4 class="card-title text-cl1">Total Sales (RM) </h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12 col-md-12">
                            <div class="table-responsive">
                                <figure class="highcharts-figure">
                                    <div id="containerRevenue"></div>
                                </figure>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> -->
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="card">
                <div class="card-header cl-1">
                    <div class="row">
                        <div class="col-lg-7 col-md-7 text-left">
                            <h4 class="card-title text-cl1">Leaderboard </h4>
                        </div>
                        <!-- <div class="col-lg-2 col-md-2 text-right">

                        </div>
                        <div class="col-lg-3 col-md-3 text-right">
                            <div id="date-picker-example" class="md-form md-outline input-with-post-icon datepicker" inline="true">
                                <input placeholder="Select Month" type="month" id="monthFilterTop" name="monthFilterTop" class="form-control">
                            </div>
                        </div> -->
                    </div>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-xs-12 col-12 table-responsive-lg">
                            <table class="wd-100 ft-tb table table-striped" id="leaderboard_datatable" style="margin:5px;width:100%;">
                                <thead class="text-center" style="background-color:#7630b8; color:white;">
                                    <tr class="cl-1">
                                        <th class="text-center">No</th>
                                        <th class="text-center">Name</th>
                                        <th class="text-center">Total Post</th>
                                        <th class="text-center">Total Points</th>
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
    <!-- Basic Inputs end -->

</div>

@endsection

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
<script src="{{ asset('assets/js/additional/dashboard.js') }}"></script>
@section('script')
<script>
    var user_name = "{{auth()->user()->name}}";
    if (user_name == "") {
        window.location.href = '/';
    }
    var BASE_URL = "{{ url('/') }}";
    var token = "{{ csrf_token() }}";
</script>
<script>
    $(document).ready(function() {
        $(".yearsFilter").datepicker({
            format: "yyyy",
            viewMode: "years",
            minViewMode: "years",
            autoclose: true
        });
        getPostChart();
    });
    var leaderBoard = $('#leaderboard_datatable').DataTable({
        destroy: true,
        processing: true,
        serverSide: true,
        responsive: true,
        searching: false,
        paging: false,
        ajax: {
            "url": "" + BASE_URL + "/get-Leader-Board",
            'type': 'POST',
            'dataType': 'JSON',
            "data": function(d) {
                return $.extend({}, d, {
                    "_token": token,
                });
            },
            'error': function(xhr, textStatus, ThrownException) {
                alert('Error loading data. Exception: ' + ThrownException + "\n" + textStatus);
            }
        },
        columns: [{
            data: "id",
            name: "id",
            render: function(data, type, full, meta) {
                return meta.row + meta.settings._iDisplayStart + 1;
            }

        }, {
            data: "agent_name",
            name: "agent_name",
        }, {
            data: "total_post",
            name: "total_post",
        }, {
            data: "total_point",
            name: "total_point",
        }]
    });




    // Highcharts.chart('containerSales', {

    //     title: {
    //         text: 'Total Sales Qty'
    //     },

    //     subtitle: {
    //         text: ''
    //     },

    //     yAxis: {
    //         title: {
    //             text: 'Total Sales'
    //         }
    //     },

    //     xAxis: {
    //         accessibility: {
    //             rangeDescription: 'Range: 2022'
    //         }
    //     },

    //     legend: {
    //         layout: 'vertical',
    //         align: 'right',
    //         verticalAlign: 'middle'
    //     },

    //     plotOptions: {
    //         series: {
    //             label: {
    //                 connectorAllowed: false
    //             },
    //             pointStart: 2010
    //         }
    //     },

    //     series: [{
    //         name: 'Total Sales',
    //         data: [43934, 48656, 65165, 81827, 112143, 142383,
    //             171533, 165174, 155157, 161454, 154610
    //         ]
    //     }],

    //     responsive: {
    //         rules: [{
    //             condition: {
    //                 maxWidth: 500
    //             },
    //             chartOptions: {
    //                 legend: {
    //                     layout: 'horizontal',
    //                     align: 'center',
    //                     verticalAlign: 'bottom'
    //                 }
    //             }
    //         }]
    //     }
    // });


    // Highcharts.chart('containerRevenue', {

    //     title: {
    //         text: 'Total Sales RM '
    //     },

    //     subtitle: {
    //         text: ''
    //     },

    //     yAxis: {
    //         title: {
    //             text: 'Total Sales'
    //         }
    //     },

    //     xAxis: {
    //         accessibility: {
    //             rangeDescription: 'Range: 2022'
    //         }
    //     },

    //     legend: {
    //         layout: 'vertical',
    //         align: 'right',
    //         verticalAlign: 'middle'
    //     },

    //     plotOptions: {
    //         series: {
    //             label: {
    //                 connectorAllowed: false
    //             },
    //             pointStart: 2022
    //         }
    //     },

    //     series: [{
    //         name: 'Total Sales',
    //         data: [38, 100, 544, 3455, 6000, 10383]
    //     }],

    //     responsive: {
    //         rules: [{
    //             condition: {
    //                 maxWidth: 500
    //             },
    //             chartOptions: {
    //                 legend: {
    //                     layout: 'horizontal',
    //                     align: 'center',
    //                     verticalAlign: 'bottom'
    //                 }
    //             }
    //         }]
    //     }
    // });
</script>
@endsection
