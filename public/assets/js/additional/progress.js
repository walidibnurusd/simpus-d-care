var progress_table = $('#progress_datatable').DataTable({
    destroy: true,
    responsive: true,
    searching: false,
    ajax: {
        "url": "" + BASE_URL + "/get-progress-table",
        'type': 'POST',
        'dataType': 'JSON',
        "data": function (d) {
            return $.extend({}, d, {
                "_token": token,
                "id_category_user": $('#category_progress').val()
            });
        },
        'error': function (xhr, textStatus, ThrownException) {
            alert('Error loading data. Exception: ' + ThrownException + "\n" + textStatus);
        }
    },
    columns: [{
        data: "agent_id",
        name: "agent_id",
        render: function (data, type, full, meta) {

            return meta.row + meta.settings._iDisplayStart + 1;
        }
    }, {
        data: "agent_name",
        name: "agent_name",
    }, {
        data: "total_post",
        name: "total_post",
        className: "dt-center",
    }, {
        data: "total_point",
        name: "total_point",
        className: "dt-center",
    }, {
        data: "M1",
        name: "M1",
        className: "dt-center",
    }, {
        data: "M2",
        name: "M2",
        className: "dt-center",
    }, {
        data: "M3",
        name: "M3",
        className: "dt-center",
    }, {
        data: "M4",
        name: "M4",
        className: "dt-center",
    }, {
        data: "M5",
        name: "M5",
        className: "dt-center",
    }, {
        data: "agent_id",
        name: 'button',
        searchable: false,
        className: "text-center",
        render: function (data, type, full, meta) {
            var btn = '<a type="button" class="btn btn-success btn-sm" style="background-color: #7630b8;" onclick="getProgress(\'' + data + '\',\'' + full.agent_name + '\',\'' + full.id_user_category + '\')">Progress</a>'
            return btn;
        }
    }]
});


function changeFilterCategory() {
    $('#progress_datatable').DataTable({
        destroy: true,
        responsive: true,
        searching: false,
        ajax: {
            "url": "" + BASE_URL + "/get-progress-table",
            'type': 'POST',
            'dataType': 'JSON',
            "data": function (d) {
                return $.extend({}, d, {
                    "_token": token,
                    "id_category_user": $('#category_progress').val()
                });
            },
            'error': function (xhr, textStatus, ThrownException) {
                alert('Error loading data. Exception: ' + ThrownException + "\n" + textStatus);
            }
        },
        columns: [{
            data: "agent_id",
            name: "agent_id",
            render: function (data, type, full, meta) {

                return meta.row + meta.settings._iDisplayStart + 1;
            }
        }, {
            data: "agent_name",
            name: "agent_name",
        }, {
            data: "total_post",
            name: "total_post",
            className: "dt-center",
        }, {
            data: "total_point",
            name: "total_point",
            className: "dt-center",
        }, {
            data: "M1",
            name: "M1",
            className: "dt-center",
        }, {
            data: "M2",
            name: "M2",
            className: "dt-center",
        }, {
            data: "M3",
            name: "M3",
            className: "dt-center",
        }, {
            data: "M4",
            name: "M4",
            className: "dt-center",
        }, {
            data: "M5",
            name: "M5",
            className: "dt-center",
        }, {
            data: "agent_id",
            name: 'button',
            searchable: false,
            className: "text-center",
            render: function (data, type, full, meta) {
                var btn = '<a type="button" class="btn btn-success btn-sm" style="background-color: #7630b8;" onclick="getProgress(\'' + data + '\',\'' + full.agent_name + '\',\'' + full.id_user_category + '\')">Progress</a>'
                return btn;
            }
        }]
    });
}

function getCategoryFilter() {
    $.ajax({
        type: "POST",
        url: "" + BASE_URL + "/get-category-filter",
        dataType: 'JSON',
        data: {
            _token: token,
        },
        beforeSend: function () {
            $(".category_filter").LoadingOverlay("show");
        },
        success: function (data) {
            $(".category_filter").LoadingOverlay("hide");
            var optionsValues = "";
            optionsValues += '<option value="empty">Choose a Category.</option>';
            jQuery.each(data.data, function (i, item) {
                optionsValues += '<option value="' + item.id + '">' + item.category_name + '</option>';
            });
            jQuery('#category_progress').html(optionsValues);
        },
        error: function (xmlhttprequest, textstatus, message) {
        }
    });

}



function getProgress(agent_id, agent_name, id_user_category) {
    window.location.href = "" + BASE_URL + "/historyUser";
    localStorage.setItem('agent_id', agent_id);
    localStorage.setItem('agent_name', agent_name)
    localStorage.setItem('id_user_category', id_user_category)
}

function getSummaryPost() {
    // start koding ajax
    jQuery.ajax({
        type: "POST", //pake post jangan  get rawan di hack
        url: "" + BASE_URL + "/get-summary-points",
        dataType: 'JSON',
        timeout: 10000,
        data: {
            _token: token,
            agent_id: localStorage.getItem('agent_id'),
            id_user_category: localStorage.getItem('id_user_category')
        },
        beforeSend: function () {
            $(".post-overlay").LoadingOverlay("show");
        },
        success: function (data) {
            $(".post-overlay").LoadingOverlay("hide");
            if (data.data[0].points != null) {
                $('#sumPoints').html(data.data[0].points);
                $('#sumPointsMobile').html(data.data[0].points);
            } else {
                $('#sumPoints').html(0);
                $('#sumPointsMobile').html(0);
            }

        },
        error: function (xmlhttprequest, textstatus, message) {
        }
    });
}


function getDataAgent() {
    $('#agent_id').html(localStorage.getItem('agent_id'));
    $('#agent_name').html(localStorage.getItem('agent_name'));
}

function getDataTotalPost() {
    $.ajax({
        type: "POST",
        url: "" + BASE_URL + "/get-data-total-post",
        dataType: 'JSON',
        data: {
            _token: token,
            agent_id: localStorage.getItem('agent_id'),
            id_user_category: localStorage.getItem('id_user_category')
        },
        timeout: 10000,
        beforeSend: function () {

        },
        success: function (data) {
            var total_post_value = "";


            $.each(data.data, function (i, val) {
                total_post_value += '<div class="col-lg-4 col-md-4 col-xs-4 col-4 border-progress2" style="padding:5px;">';
                total_post_value += '   <div class="text-right" style="font-size: 12px;">' + val.qty + ' ' + val.type + ' | ' + val.pts + ' Pts</div>';
                total_post_value += '</div>';
            });

            var percen_value = ((data.data_total_post / 150) * 100);

            $('#total_post_progres').html('<div class="progress-bar" role="progressbar" aria-valuenow="27" aria-valuemin="0" aria-valuemax="100" style="width: ' + percen_value + '%;"></div>');
            $('#count_total_post').html(data.data_total_post);
            $('#total_post_value').html(total_post_value);
        },
        error: function (xmlhttprequest, textstatus, message) {

            Toast.fire({
                icon: 'error',
                title: '<font style="font-size:18px; text-align:right;">There is a problem on the server, contact the support team</font>'
            })
        }
    });
}

function getDataMission() {
    $.ajax({
        type: "POST",
        url: "" + BASE_URL + "/get-data-mission",
        dataType: 'JSON',
        data: {
            _token: token,
            agent_id: localStorage.getItem('agent_id'),
            id_user_category: localStorage.getItem('id_user_category')
        },
        timeout: 10000,
        beforeSend: function () {
            $("#mission_value").LoadingOverlay("show");
        },
        success: function (data) {
            $("#mission_value").LoadingOverlay("hide");
            var mission_value = "";
            var mission_extra = "";

            $.each(data.data, function (i, val) {

                mission_value += '<div class="row" style="margin-top: 10px;">';
                mission_value += '        <div class="col-lg-8 col-md-8 col-xs-12 col-12">';
                mission_value += '            <div class="form-group">';
                mission_value += '                <label for="judul" class="font-weight-bold">MISSION ' + val.code + ': ' + val.name + '</label>';
                mission_value += '                 <div class="progress">';
                mission_value += '                   <div  id="percen_progress_' + val.id_mission + '" class="progress-bar" role="progressbar" aria-valuenow="11" aria-valuemin="0" aria-valuemax="100" ></div>';
                mission_value += '                </div>';
                mission_value += '                <div class="row d-flex justify-content-between" style="margin: 0px;padding:0px;" id="mission_formula_' + val.id_mission + '">';

                mission_value += '                </div>';
                mission_value += '            </div>';
                mission_value += '        </div>';
                mission_value += '        <div class="col-lg-4 col-md-4 col-xs-12 col-12  text-center justify-content-center" style="margin: auto;">';
                mission_value += '            <div class="card cl-1 card-mobile">';
                mission_value += '                <div class="card-body" style="padding:0px;">';
                mission_value += '                    <h4 class="text-cl1">' + val.label + '</h4>';
                mission_value += '                    <h3 class="text-cl2" style="margin-bottom:0px;" id="count_mission_' + val.id_mission + '"></h3>';
                mission_value += '                </div>';
                mission_value += '           </div>';
                mission_value += '        </div>';
                mission_value += '    </div>';

                $('#mission_value').html(mission_value);
                jQuery.ajax({
                    type: "POST",
                    url: "" + BASE_URL + "/get-data-formula",
                    dataType: 'JSON',
                    data: {
                        _token: token,
                        id_mission: val.id_mission,
                        agent_id: localStorage.getItem('agent_id'),
                        id_user_category: localStorage.getItem('id_user_category')
                    },
                    timeout: 10000,
                    beforeSend: function () { },
                    success: function (data) {

                        var percen_progres = ((data.count_mission / val.max_extra_point) * 100);

                        var mission_value_formula = "";

                        $.each(data.data, function (i, val) {
                            mission_value_formula += '                    <div class="col-lg-4 col-md-4 col-xs-4 col-4 border-progress2" style="padding:5px;">';
                            mission_value_formula += '                        <div class="text-right" style="font-size: 12px;">' + val.name + '</div>';
                            mission_value_formula += '                    </div>';

                            $('#mission_formula_' + val.id_mission + '').html(mission_value_formula);



                        });
                        $('#percen_progress_' + val.id_mission + '').css('width', '' + percen_progres + '%');
                        $('#count_mission_' + val.id_mission + '').html(data.count_mission);




                    },
                    error: function (xmlhttprequest, textstatus, message) { }
                });




            });


        },
        error: function (xmlhttprequest, textstatus, message) {
            $("#mission_value").LoadingOverlay("hide");
            Toast.fire({
                icon: 'error',
                title: '<font style="font-size:18px; text-align:right;">There is a problem on the server, contact the support team</font>'
            })
        }
    });
}

var history_user = $('#history_datatable').DataTable({
    destroy: true,
    processing: true,
    serverSide: true,
    responsive: true,
    searching: false,
    ajax: {
        "url": "" + BASE_URL + "/get-history-table",
        'type': 'POST',
        'dataType': 'JSON',
        "data": function (d) {
            return $.extend({}, d, {
                _token: token,
                agent_id: localStorage.getItem('agent_id'),
                id_user_category: localStorage.getItem('id_user_category')
            });
        },
        'error': function (xhr, textStatus, ThrownException) {
            alert('Error loading data. Exception: ' + ThrownException + "\n" + textStatus);
        }
    },
    columns: [{
        data: "id",
        name: "id",
        className: "dt-center",
        render: function (data, type, full, meta) {

            return meta.row + meta.settings._iDisplayStart + 1;
        }
    }, {
        data: 'dt_record',
        name: 'dt_record',
        className: "dt-center",
        render: function (data, type, full, meta) {
            return moment(data).format('DD-MMM-YYYY HH:mm:ss');
        }
    }, {
        data: "file",
        name: "file",
        className: "dt-center",
        render: function (data, type, full, meta) {
            var result = '';
            result += '<img src="https://gamification.jooal.my/storage/img/post/' + data + '"  style="border-radius:15px;" data-toggle="modal" data-target="#modalRepost" width="100" height="100">';
            return result;
        }
    }, {
        data: "media_name",
        name: "media_name"
    }, {
        data: "description",
        name: "description"
    }, {
        data: 'status',
        name: 'status',
        className: "dt-center",
        render: function (data, type, full, meta) {

            var result = '';
            if (data == "valid") {
                result = '<i class="fa fa-check-circle fa-2x" style="color:green;" aria-hidden="true">';
            } else if (data == "reject") {
                result = '<i class="fa fa-times-circle fa-2x"  style="color:red;" aria-hidden="true">';
            } else {
                result = '<i class="fa fa-spinner fa-2x"  style="color:red;" aria-hidden="true">';
            }
            return result;

        }
    }]
});