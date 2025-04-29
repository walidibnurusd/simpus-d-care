var dateFilter
$(function () {
    $('input[name="datefilter"]').daterangepicker({
        locale: {
            format: 'YYYY-MM-DD'
        },
        startDate: new Date(),
    },
        function (start, end, label) {
            dateFilter = "" + start.format('YYYY-MM-DD') + '" and "' + end.format('YYYY-MM-DD') + ""
        });
});
var no = 1;
var validation_datatable = $('#validation_datatable').DataTable({
    destroy: true,
    processing: true,
    deferLoading: 0,
    serverSide: true,
    responsive: true,
    searching: false,
    ajax: {
        "url": "" + BASE_URL + "/get-validation-table",
        'type': 'POST',
        'dataType': 'JSON',
        "data": function (d) {
            return $.extend({}, d, {
                "_token": token,
                "status_post": $('#status_post').val(),
                "campaign_post": $('#campaign_post').val(),
                "datefilter": dateFilter,
                "media_id": $('#media_id').val()
            });
        },
        'error': function (xhr, textStatus, ThrownException) {
            alert('Error loading data. Exception: ' + ThrownException + "\n" + textStatus);
        }
    },
    columns: [{
        data: "id",
        name: "id",
        className: "select-checkbox",
        render: function (data, type, full, meta) {
            return '<input type="checkbox" id="checkbox" class="editor-active" value="' + data + '">';
        }

    }, {
        data: "id",
        name: "id",
        render: function (data, type, full, meta) {

            return meta.row + meta.settings._iDisplayStart + 1;
        }
    }, {
        data: "agent_name",
        name: "agent_name",
    }, {
        data: "media_name",
        name: "media_name",
    }, {
        data: "file",
        name: "file",
        className: "dt-center",
        render: function (data, type, full, meta) {
            var result = '';
            result += '<img src="https://gamification.jooal.my/storage/img/post/' + data + '" style="border-radius:15px;" width="100" height="100">';
            return result;
        }
    }, {
        data: 'dt_record',
        name: 'dt_record',
        searchable: false,
        render: function (data, type, full, meta) {
            return moment(data).format('DD-MMM-YYYY HH:mm:ss');
        }
    }, {
        data: 'status',
        name: 'status',
        searchable: false,
        render: function (data, type, full, meta) {
            var stat = ''
            if (full.status == 'valid') {
                stat = ' <font style="green">VALID<font>';
            } else if (full.status == 'reject') {
                stat = ' <font style="green">REJECTED<font>';
            } else {
                stat = ' <font style="green">On Review<font>';
            }
            return stat;
        }
    }, {
        data: 'id',
        name: 'button',
        searchable: false,
        className: "text-center",
        render: function (data, type, full, meta) {
            var btn = ''
            if (full.status == 'valid') {
                btn += ' <a type="button" class="btn btn-success btn-sm">Valid</a>';
            } else {

                btn += ' <a type="button" class="btn btn-primary btn-sm" style="background-color: #7638FF;" data-toggle="modal" data-target="#modalValid" onclick="getActiveMission(\'' + data + '\',\'' + full.file + '\',\'' + full.agent_id + '\')"><i class="fa fa-check fa-lg"></i></a>';
            }
            return btn;
        }
    }]
});

var update_point_datatable = $('#update_point_datatable').DataTable({
    destroy: true,
    processing: true,
    serverSide: true,
    responsive: true,
    ajax: {
        "url": "" + BASE_URL + "/get-update-data-poin",
        'type': 'POST',
        'dataType': 'JSON',
        "data": function (d) {
            return $.extend({}, d, {
                "_token": token
            });
        },
        'error': function (xhr, textStatus, ThrownException) {
            alert('Error loading data. Exception: ' + ThrownException + "\n" + textStatus);
        }
    },
    columns: [{
        data: "agent_id",
        name: "agent_id",
        className: "dt-center",
        render: function (data, type, full, meta) {

            return meta.row + meta.settings._iDisplayStart + 1;
        }
    }, {
        data: "agent_id",
        name: "agent_id",
        className: "dt-center",
    }, {
        data: "agent_name",
        name: "agent_name",
    }, {
        data: "total_points",
        name: "total_points",
        className: "dt-center",
        searchable: false,
        render: function (data, type, full, meta) {
            if (data == null) {
                var total = 0;
            } else {
                var total = data;
            }
            return total;
        }
    }, {
        data: 'agent_id',
        name: 'button',
        searchable: false,
        className: "text-center",
        render: function (data, type, full, meta) {
            if (full.total_points == null) {
                var total = 0;
            } else {
                var total = full.total_points;
            }
            var btn = '<a type="button" class="btn btn-success btn-sm" style="background-color: #7630b8;" data-toggle="modal" data-target="#modalUpdatePoint" onclick="getUpdateDataModal(\'' + total + '\',\'' + data + '\',\'' + full.id_mission + '\')">Update</a>'
            return btn;
        }
    }]
});

var post_datatable = $('#post_datatable').DataTable({
    destroy: true,
    processing: true,
    serverSide: true,
    responsive: true,
    searching: false,
    ajax: {
        "url": "" + BASE_URL + "/get-post-table",
        'type': 'POST',
        'dataType': 'JSON',
        "data": function (d) {
            return $.extend({}, d, {
                "_token": token
            });
        },
        'error': function (xhr, textStatus, ThrownException) {
            alert('Error loading data. Exception: ' + ThrownException + "\n" + textStatus);
        }
    },
    columns: [{
        data: "id",
        name: "id",
        render: function (data, type, full, meta) {

            return meta.row + meta.settings._iDisplayStart + 1;
        }
    }, {
        data: "agent_id",
        name: "agent_id",
    }, {
        data: "agent_name",
        name: "agent_name",
    }, {
        data: "media_name",
        name: "media_name",
    }, {
        data: "file",
        name: "file",
        className: "dt-center",
        render: function (data, type, full, meta) {
            var result = '';
            result += '<img src="https://gamification.jooal.my/storage/img/post/' + data + '" style="border-radius:15px;" width="100" height="100">';
            return result;
        }
    }, {
        data: 'dt_record',
        name: 'dt_record',
        searchable: false,
        render: function (data, type, full, meta) {
            return moment(data).format('DD-MMM-YYYY HH:mm:ss');
        }
    }, {
        data: 'status',
        name: 'status',
        searchable: false,
        render: function (data, type, full, meta) {
            var stat = ''
            if (full.status == 'valid') {
                stat = ' <font style="green">VALID<font>';
            } else if (full.status == 'reject') {
                stat = ' <font style="green">REJECTED<font>';
            } else {
                stat = ' <font style="green">On Review<font>';
            }
            return stat;
        }
    }]
});

function userProgress(id) {
    // localStorage.setItem('periode_id', id);
    window.location.href = "{{url('')}}/historyUser";
}

function getUpdateDataModal(total_points, agent_id, id_mission) {
    var total
    if (total_points == null) {
        total = 0;
    } else {
        total = total_points;
    }

    $('#currentPoint').val(total);
    localStorage.setItem("agent_id", agent_id);
    $('.id_mission').val('').trigger('change');
    $('#total_points').val('');

    $.ajax({
        type: "POST",
        url: "" + BASE_URL + "/get-active-mission",
        dataType: 'JSON',
        data: {
            _token: token,
            agent_id: agent_id
        },
        beforeSend: function () {
            $(".loader_active").LoadingOverlay("show");
        },
        success: function (data) {
            $(".loader_active").LoadingOverlay("hide");
            var optionsValues = "";
            optionsValues += '<option value="">Choose a Campaign</option>';
            jQuery.each(data.data, function (i, item) {
                optionsValues += '<option value="' + item.id + '">' + item.name + '</option>';
            });
            jQuery('#missionTypes').html(optionsValues);
        },
        error: function (xmlhttprequest, textstatus, message) {
        }
    });
}

function comboMedia() {
    jQuery.ajax({
        type: "POST",
        url: "" + BASE_URL + "/get-media",
        dataType: 'JSON',
        timeout: 10000,
        data: {
            _token: token
        },
        beforeSend: function () {
            $(".media-overlay").LoadingOverlay("show");
        },
        success: function (data) {
            $(".media-overlay").LoadingOverlay("hide");
            var no = 0;
            var optionsValues = "";
            optionsValues += '<option value="empty" selected>Choose Your Media.</option>';
            jQuery.each(data.data, function (i, item) {
                no++
                optionsValues += '<option value="' + item.id + '">' + item.media_name + '</option>';

            });
            jQuery('#media_id').html(optionsValues);

        },
        error: function (xmlhttprequest, textstatus, message) {
        }
    });
}

function getAddOnMission() {
    $.ajax({
        type: "POST",
        url: "" + BASE_URL + "/get-mission-addon",
        dataType: 'JSON',
        data: {
            _token: token,
            id_mission_header: $('#missionTypes').val(),
        },
        beforeSend: function () {
            $(".addOn_active").LoadingOverlay("show");
        },
        success: function (data) {
            $(".addOn_active").LoadingOverlay("hide");
            var optionsValues = "";
            optionsValues += '<option value="">Choose a Mission</option>';
            jQuery.each(data.data, function (i, item) {
                optionsValues += '<option value="' + item.id_mission + '">' + item.name + '</option>';
            });
            jQuery('#id_mission').html(optionsValues);
        },
        error: function (xmlhttprequest, textstatus, message) {
        }
    });
}

function changeFilter() {
    validation_datatable.draw();
}

function getActiveMission(id, file, agent_id) {
    localStorage.setItem('id_post', id);
    localStorage.setItem('agent_id', agent_id);
    $('#categoryMission').html("");
    $('.acceptanceSelect').val('').trigger('change');
    $('#description').val('');
    $('.showCategory').hide();
    $.ajax({
        type: "POST",
        url: "" + BASE_URL + "/get-active-mission",
        dataType: 'JSON',
        data: {
            _token: token,
            agent_id: agent_id
        },
        beforeSend: function () {
            $(".loader_active").LoadingOverlay("show");
        },
        success: function (data) {
            $(".loader_active").LoadingOverlay("hide");
            jQuery('#imagePost').html('<img width="250" src="https://gamification.jooal.my/storage/img/post/' + file + '" style="border-radius:25px;padding:10px;"/>');

            var optionsValues = "";
            optionsValues += '<option value="">Choose a Mission Type</option>';
            jQuery.each(data.data, function (i, item) {
                optionsValues += '<option value="' + item.id + '">' + item.name + '</option>';
            });
            jQuery('#missionType').html(optionsValues);
        },
        error: function (xmlhttprequest, textstatus, message) {
        }
    });

}

function getActiveMissionFilter() {
    $.ajax({
        type: "POST",
        url: "" + BASE_URL + "/get-active-mission-filter",
        dataType: 'JSON',
        data: {
            _token: token,
        },
        beforeSend: function () {
            $(".campaign_filter").LoadingOverlay("show");
        },
        success: function (data) {
            $(".campaign_filter").LoadingOverlay("hide");
            var optionsValues = "";
            optionsValues += '<option value="empty">Choose a User Category.</option>';
            jQuery.each(data.data, function (i, item) {
                optionsValues += '<option value="' + item.id + '">' + item.category_name + '</option>';
            });
            jQuery('#campaign_post').html(optionsValues);
        },
        error: function (xmlhttprequest, textstatus, message) {
        }
    });

}
function getMissionType() {
    console.log('AJAX request initiated');

    $.ajax({
        type: "POST",
        url: "" + BASE_URL + "/get-mission",
        dataType: 'JSON',
        data: {
            id_mission_header: $('#missionType').val(),
            _token: token
        },
        beforeSend: function () {
            $(".mission_active").LoadingOverlay("show");
        },
        success: function (data) {
            console.log(data);  // Cek apakah ada respon dari server
            $(".mission_active").LoadingOverlay("hide");

            if ($('#missionType').val() == "") {
                $('.showCategory').hide();
            } else {
                $('.showCategory').show();
                var optionsValues = "";
                jQuery.each(data.data, function (i, item) {
                    optionsValues += '<option value="' + item.id_mission + '">' + item.name + '</option>';
                });
                jQuery('#id_mission').html(optionsValues);
            }
        },
        error: function (xmlhttprequest, textstatus, message) {
            console.log('Error occurred: ', message);  // Cek apakah ada error
        }
    });
}


function postValid() {

    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        },
        willClose: () => {
        }
    })
    if ($('#postValid').valid()) {

        if (localStorage.getItem('id_post') != "" && $('#acceptance').val() != "") {

            var formData = new FormData(jQuery('#postValid')[0]);

            var no_array = 0;
            $.each($("#id_mission").val(), function (i, item) {
                no_array++
                formData.append('id_mission_' + no_array + '', item);
            });

            formData.append('_token', token);
            formData.append('id_post', localStorage.getItem('id_post'));
            formData.append('agent_id', localStorage.getItem('agent_id'));
            formData.append('mission_length', no_array);

            jQuery.ajax({
                type: "POST",
                url: "" + BASE_URL + "/insert-post-valid",
                dataType: 'JSON',
                timeout: 10000,
                data: formData,
                contentType: false,
                processData: false,
                beforeSend: function () {
                    $(".insert-overlay").LoadingOverlay("show");
                    $('#btnValid').hide();
                },
                success: function (data) {
                    $(".insert-overlay").LoadingOverlay("hide");
                    if (data.status == 'failed') {
                        Toast.fire({
                            icon: 'error',
                            title: '<font style="font-size:18px; float:right;">' + data.message + '</font>'
                        });
                    } else {
                        Toast.fire({
                            icon: 'success',
                            title: '<font style="font-size:18px; float:right;">' + data.message + '</font>'

                        });
                        $('#btnValid').show();
                        $('#modalValid').modal('hide');
                        $('.close').click();
                        validation_datatable.draw();
                    }
                },
                error: function (xmlhttprequest, textstatus, message) {
                    Toast.fire({
                        icon: 'error',
                        title: '<font style="font-size:18px; text-align:right;">There is a problem on the server, contact the support team</font>'
                    })
                }
            });
        } else {
            if ($('#acceptance').val() == "") {
                $("#errAccept").html("<font style='color:red;'>Please Choose Acceptance</font>");
            }

            Toast.fire({
                icon: 'error',
                title: '<font style="font-size:18px; text-align:right;">Please Complete fill this form.</font>'
            })
        }
    } else {
        Toast.fire({
            icon: 'error',
            title: '<font style="font-size:18px; text-align:right;">Please Complete fill this form.</font>'
        })
    }
}

function updatePostPoint() {

    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        },
        willClose: () => {
        }
    })
    if ($('#updatePoint').valid()) {
        var formData = new FormData(jQuery('#updatePoint')[0]);
        formData.append('_token', token);
        formData.append('agent_id', localStorage.getItem('agent_id'));

        jQuery.ajax({
            type: "POST",
            url: "" + BASE_URL + "/update-point-post",
            dataType: 'JSON',
            timeout: 10000,
            data: formData,
            contentType: false,
            processData: false,
            beforeSend: function () {
                $(".update-overlay").LoadingOverlay("show");
                $('#btnUpdatePoint').hide();
            },
            success: function (data) {
                $(".update-overlay").LoadingOverlay("hide");
                if (data.status == 'failed') {
                    Toast.fire({
                        icon: 'error',
                        title: '<font style="font-size:18px; float:right;">' + data.message + '</font>'
                    });
                } else {
                    Toast.fire({
                        icon: 'success',
                        title: '<font style="font-size:18px; float:right;">' + data.message + '</font>'

                    });
                    $('#btnUpdatePoint').show();
                    $('#modalUpdatePoint').modal('hide');
                    $('.close').click();
                    update_point_datatable.draw();
                }
            },
            error: function (xmlhttprequest, textstatus, message) {
                Toast.fire({
                    icon: 'error',
                    title: '<font style="font-size:18px; text-align:right;">There is a problem on the server, contact the support team</font>'
                })
            }
        });

    } else {
        Toast.fire({
            icon: 'error',
            title: '<font style="font-size:18px; text-align:right;">Please Complete fill this form.</font>'
        })
    }
}

function deletePost() {
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        },
        willClose: () => {
        }
    })

    if ($("#checkbox:checked").val() == "" || $("#checkbox:checked").val() == null) {
        Toast.fire({
            icon: 'error',
            title: '<font style="font-size:18px; text-align:right;">Choose Post First..</font>'
        })
    } else {
        var id_post_detail = ''
        $.each($("#checkbox:checked"), function (i, item) {
            id_post_detail += $(this).val() + ','
        });

        Swal.fire({
            title: 'Are you sure? delete this post',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        })
            .then(isConfirm => {
                if (isConfirm.isConfirmed) {
                    jQuery.ajax({
                        type: "POST",
                        url: "" + BASE_URL + "/delete-post-valid",
                        dataType: 'JSON',
                        timeout: 10000,
                        data: {
                            id_post_detail: id_post_detail.slice(0, -1),
                            _token: token
                        },
                        beforeSend: function () {
                            $('#btnDelete').hide();
                        },
                        success: function (data) {
                            if (data.status == 'failed') {
                                Toast.fire({
                                    icon: 'error',
                                    title: '<font style="font-size:18px; float:right;">' + data.message + '</font>'
                                });
                            } else {
                                Toast.fire({
                                    icon: 'success',
                                    title: '<font style="font-size:18px; float:right;">' + data.message + '</font>'

                                });
                                $('#btnDelete').show();
                                validation_datatable.draw();
                            }
                        },
                        error: function (xmlhttprequest, textstatus, message) {
                            Toast.fire({
                                icon: 'error',
                                title: '<font style="font-size:18px; text-align:right;">There is a problem on the server, contact the support team</font>'
                            })
                        }
                    });

                } else {
                    Toast.fire({
                        icon: 'error',
                        title: '<font style="font-size:18px; text-align:right;">Cancel Delete Post</font>'
                    })
                }
            });
    }
}