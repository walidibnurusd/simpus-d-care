
function getPostChart() {
    $.ajax({
        type: "POST",
        url: "" + BASE_URL + "/get-chart-post",
        async: true,
        cache: false,
        dataType: 'JSON',
        data: {
            _token: token,
            filter_bulan: $('#monthFilter').val(),
            filter_tahun: $('#yearFilter').val(),
        },
        beforeSend: function () {
            $(".loader_active").LoadingOverlay("show");
        },
        success: function (data) {
            $(".loader_active").LoadingOverlay("hide");

            var categories = []
            $.each(data.data_media, function (i, item) {
                categories.push(item.media_name)
            });
            console.log(categories)


            var facebook = []
            if (data.data_facebook.length == 0) {
                facebook.push(0)
            } else {
                $.each(data.data_facebook, function (i, item) {
                    facebook.push(item.total_post)
                });
            }

            var google = []
            if (data.data_google.length == 0) {
                google.push(0)
            } else {
                $.each(data.data_google, function (i, item) {
                    google.push(item.total_post)
                });
            }

            var tiktok = []
            if (data.data_tiktok.length == 0) {
                tiktok.push(0)
            } else {
                $.each(data.data_tiktok, function (i, item) {
                    tiktok.push(item.total_post)
                });
            }

            var instagram = []
            if (data.data_instagram.length == 0) {
                instagram.push(0)
            } else {
                $.each(data.data_instagram, function (i, item) {
                    instagram.push(item.total_post)
                });
            }

            var whatsapp = []
            if (data.data_whatsapp.length == 0) {
                whatsapp.push(0)
            } else {
                $.each(data.data_whatsapp, function (i, item) {
                    whatsapp.push(item.total_post)
                });
            }

            Highcharts.chart('containerPost', {
                colors: ['#003399', '#33CC66', '#333333', '#FF0066', '#006633'],
                chart: {
                    type: 'column',
                },
                title: {
                    text: ''
                },
                xAxis: {
                    visible: false,
                    crosshair: true
                },
                yAxis: {
                    title: {
                        text: ''
                    },
                },
                plotOptions: {
                    column: {
                        pointPadding: 0.2,
                        borderWidth: 0
                    }
                },

                series: [{
                    name: 'Facebook',
                    data: facebook
                },
                {
                    name: 'Google+',
                    data: google
                },
                {
                    name: 'TikTok',
                    data: tiktok
                },
                {
                    name: 'Instagram',
                    data: instagram
                },
                {
                    name: 'Whatsapp',
                    data: whatsapp
                }]
            });
            console.log(categories);
        },
        error: function (xmlhttprequest, textstatus, message) {
        }
    });
}