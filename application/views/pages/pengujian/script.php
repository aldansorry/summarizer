<script>
    var base_url = "<?php echo base_url() ?>";
    var cname_url = "<?php echo base_url($cname) ?>";

    var table_pengujian;
    var table_data_news;
    var table_result;

    var chart_result;

    var data_bobot;

    var chart_option = {
        maintainAspectRatio: false,
        layout: {
            padding: {
                left: 10,
                right: 25,
                top: 25,
                bottom: 0
            }
        },
        scales: {
            xAxes: [{
                time: {
                    unit: 'date'
                },
                gridLines: {
                    display: false,
                    drawBorder: false
                },
                ticks: {
                    maxTicksLimit: 7
                }
            }],
            yAxes: [{
                ticks: {
                    max: 100,
                    beginAtZero: true,
                    maxTicksLimit: 5,
                    stepSize: 25,
                    padding: 10,
                    // Include a dollar sign in the ticks
                    callback: function(value, index, values) {
                        return number_format(value) + "%";
                    }
                },
                gridLines: {
                    color: "rgb(234, 236, 244)",
                    zeroLineColor: "rgb(234, 236, 244)",
                    drawBorder: false,
                    borderDash: [2],
                    zeroLineBorderDash: [2]
                }
            }],
        },
        legend: {
            display: true,
            position: 'bottom',
            labels: {
                boxWidth: 20,
            }
        },
        tooltips: {
            backgroundColor: "rgb(255,255,255)",
            bodyFontColor: "#858796",
            titleMarginBottom: 10,
            titleFontColor: '#6e707e',
            titleFontSize: 14,
            borderColor: '#dddfeb',
            borderWidth: 1,
            xPadding: 15,
            yPadding: 15,
            displayColors: false,
            intersect: false,
            mode: 'index',
            caretPadding: 10,
            callbacks: {
                label: function(tooltipItem, chart) {
                    var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
                    return datasetLabel + ': ' + number_format(tooltipItem.yLabel) + "%";
                }
            }
        }
    };

    $(document).ready(function() {
        $('[name="jenis_sample"]').change(function() {
            let val = $(this).val();

            if (val == "random") {
                $("#container-jenis-pilih-berita").slideUp('fast');
                $("#container-jenis-random-berita").slideDown('fast');
            } else {
                $("#container-jenis-pilih-berita").slideDown('fast');
                $("#container-jenis-random-berita").slideUp('fast');
            }
        })

        table_data_news = $('#table-data-news').DataTable({
            columnDefs: [{
                orderable: false,
                className: 'select-checkbox',
                targets: 0
            }],
            select: {
                style: 'multi',
                selector: 'td:first-child'
            },
            order: [
                [1, 'asc']
            ],
            ajax: {
                url: cname_url + "/getData",
            },
            buttons: [{
                text: 'Delete Batch',
                className: "btn btn-danger",
                action: function(e, dt, node, config) {

                }
            }],
            'columns': [{
                    'title': '',
                    "width": "15px",
                    'orderable': false,
                    'data': (data) => {
                        let ret = "";
                        return ret;
                    }
                },
                {
                    "title": "No",
                    "width": "15px",
                    "data": null,
                    "visible": true,
                    "class": "text-center",
                    render: (data, type, row, meta) => {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {
                    'title': '',
                    "width": "79px",
                    'data': (data) => {
                        let ret = "";
                        ret += '<div class="btn-group">';
                        ret += '<a href="javascript:void(0)" onclick="detail_prompt(this)" class="btn btn-sm btn-flat text-info" data-id="' + data.id + '"><i class="fa fa-info"></i> Detail</a>';
                        ret += '</div>';
                        return ret;
                    }
                },
                {
                    'title': 'Source',
                    'width': 20,
                    'data': (data) => {
                        let ret = "";
                        if (data.fk_sumber == 1) {
                            ret = '<span class="badge badge-primary btn-block">Katadata</span>';
                        }
                        if (data.fk_sumber == 2) {
                            ret = '<span class="badge badge-info btn-block">Detik</span>';
                        }
                        if (data.fk_sumber == 3) {
                            ret = '<span class="badge badge-danger btn-block">Kompas</span>';
                        }
                        return ret;
                    }
                },
                {
                    'title': 'Tanggal',
                    'data': 'tanggal'
                },
                {
                    'title': 'Judul',
                    'data': 'judul'
                },
                {
                    'title': 'Kategori',
                    'data': 'kategori'
                },
            ],
        });

        table_pengujian = $('#table-pengujian').DataTable({
            dom: "<'pb-1'B><'float-left ml-3'l>frtip",
            columnDefs: [{
                orderable: false,
                className: 'select-checkbox',
                targets: 0
            }],
            select: {
                style: 'multi',
                selector: 'td:first-child'
            },
            order: [
                [1, 'asc']
            ],
            ajax: {
                url: cname_url + "/getPengujian",
            },
            buttons: [{
                text: 'Delete Batch',
                className: "btn btn-danger",
                action: function(e, dt, node, config) {
                    let data = table_pengujian.rows({
                        selected: true
                    }).data();

                    let selected_id = [];
                    $.each(data, function(i, item) {
                        selected_id.push(item.id);
                    });

                    delete_prompt_batch(selected_id);

                }
            }],
            'columns': [{
                    'title': '',
                    "width": "15px",
                    'orderable': false,
                    'data': (data) => {
                        let ret = "";
                        return ret;
                    }
                },
                {
                    "title": "No",
                    "width": "15px",
                    "data": null,
                    "visible": true,
                    "class": "text-center",
                    render: (data, type, row, meta) => {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {
                    'title': '',
                    "width": "79px",
                    'class': "",
                    'data': (data) => {
                        let ret = "";
                        ret += '<div class="btn-group">';
                        ret += '<a href="javascript:void(0)" class="btn btn-sm text-warning" onclick="excelDownload(this)" data-id="' + data.id + '"><i class="fa fa-download"></i> Download</a>';
                        if (data.status == 2) {
                            ret += '<a href="javascript:void(0)" class="btn btn-sm text-success" onclick="viewDetail(this)" data-id="' + data.id + '"><i class="fa fa-crosshairs"></i> View</a>';
                        } else {
                            ret += '<a href="javascript:void(0)" class="btn btn-sm text-primary" onclick="doUpload(this)" data-id="' + data.id + '"><i class="fa fa-upload"></i> Upload</a>';
                        }
                        ret += '</div>';
                        return ret;
                    }
                },
                {
                    'title': 'Tanggal',
                    'data': 'tanggal'
                },
                {
                    'title': 'berita',
                    'data': 'berita'
                },
                {
                    'title': 'status',
                    'data': 'status_text'
                },
            ],
        });

        table_result = $('#table-result').DataTable({
            'columns': [{
                    "title": "No",
                    "width": "15px",
                    "data": null,
                    "visible": true,
                    "class": "text-center",
                    render: (data, type, row, meta) => {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {
                    'title': '',
                    "width": "79px",
                    'class': "",
                    'data': (data) => {
                        let ret = "";
                        ret += '<div class="btn-group">';
                        ret += '<a href="javascript:void(0)" onclick="detail_prompt(this)" class="btn btn-sm btn-flat text-info" data-id="' + data.id + '" data-auto="' + data.auto + '" data-manual="' + data.manual + '"><i class="fa fa-info"></i> Detail</a>';
                        ret += '</div>';
                        return ret;
                    }
                },
                {
                    'title': 'judul',
                    'data': 'judul'
                },
                {
                    'title': 'kategori',
                    'data': 'kategori'
                },
                {
                    'title': 'fk_sumber',
                    'data': 'fk_sumber'
                },
                {
                    'title': 'auto',
                    'data': 'auto'
                },
                {
                    'title': 'manual',
                    'data': 'manual'
                },
                {
                    'title': 'precision',
                    'data': 'precision'
                },
                {
                    'title': 'recall',
                    'data': 'recall'
                },
                {
                    'title': 'f_measure',
                    'data': 'f_measure'
                },
            ],
        });


        $('#select-bobot option').mousedown(function(e) {
            e.preventDefault();
            $(this).prop('selected', !$(this).prop('selected'));
            return false;
        });

        $('#form-sample').submit(function(e) {
            e.preventDefault();

            let elementForm = $(this);
            let formData = new FormData(this);

            let data = table_data_news.rows({
                selected: true
            }).data();

            let selected_id = [];
            $.each(data, function(i, item) {
                selected_id.push(item.id);
            });

            formData.append('list_berita', selected_id);

            $.ajax({
                url: cname_url + "/pengujian_action",
                type: "POST",
                data: formData,
                dataType: 'JSON',
                cache: false,
                contentType: false,
                processData: false,
                success: (data) => {
                    Swal.fire(data.swal);
                    table_pengujian.ajax.reload(null, false);
                }
            });
        });

        $('#form-import').submit(function(e) {
            e.preventDefault();

            let elementForm = $(this);
            let formData = new FormData(this);

            $.ajax({
                url: cname_url + "/import_pengujian",
                type: "POST",
                data: formData,
                dataType: 'JSON',
                cache: false,
                contentType: false,
                processData: false,
                success: (data) => {

                    Swal.fire(data);
                    table_pengujian.ajax.reload(null, false);
                    $('#input-file').val(null);
                }
            });
        });

        $('#input-file').change(function() {
            $('#form-import').submit();
        })

        //new
        $('#form-bobot select[name="fk_bobot"]').change(function() {
            let val = $(this).val();
            if (val == -1) {
                $('#form-bobot').find('input[type="number"]').attr('readonly', false);
            } else {
                $('#form-bobot').find('input[type="number"]').attr('readonly', true);

                let bobot_data = $(this).find(":selected").data('value');

                $('#form-bobot').find("[name='f1']").val(bobot_data.f1);
                $('#form-bobot').find("[name='f2']").val(bobot_data.f2);
                $('#form-bobot').find("[name='f3']").val(bobot_data.f3);
                $('#form-bobot').find("[name='f4']").val(bobot_data.f4);
                $('#form-bobot').find("[name='f5']").val(bobot_data.f5);
                $('#form-bobot').find("[name='f6']").val(bobot_data.f6);
                $('#form-bobot').find("[name='kompresi']").val(bobot_data.kompresi);
            }
        });

        $('#form-bobot').submit(function(e) {
            e.preventDefault();

            let elementForm = $(this);
            let formData = new FormData(this);

            $.ajax({
                url: cname_url + "/calculateAccuracy",
                type: "POST",
                data: formData,
                dataType: 'JSON',
                cache: false,
                contentType: false,
                processData: false,
                success: (data) => {
                    let accuracy = data.accuracy;
                    $('#accuracy-f-measure-text').text(accuracy.f_measure + "%");
                    $('#accuracy-precision-text').text(accuracy.precision + "%");
                    $('#accuracy-recall-text').text(accuracy.recall + "%");
                    $('#accuracy-f-measure-bar').css("width", accuracy.f_measure + "%");
                    $('#accuracy-precision-bar').css("width", accuracy.precision + "%");
                    $('#accuracy-recall-bar').css("width", accuracy.recall + "%");


                    table_result.clear();
                    table_result.rows.add(data.tabel);
                    table_result.draw();

                    if (chart_result != null) {
                        chart_result.destroy();
                    }

                    chart_result = new Chart(document.getElementById('chart-result'), {
                        type: 'bar',
                        data: {
                            labels: data.chart.label,
                            datasets: [{
                                    label: "F-measure",
                                    lineTension: 0.3,
                                    backgroundColor: "#4e73df",
                                    borderColor: "rgba(78, 115, 223, 1)",
                                    pointRadius: 3,
                                    pointBackgroundColor: "rgba(78, 115, 223, 1)",
                                    pointBorderColor: "rgba(78, 115, 223, 1)",
                                    pointHoverRadius: 3,
                                    pointHoverBackgroundColor: "rgba(78, 115, 223, 1)",
                                    pointHoverBorderColor: "rgba(78, 115, 223, 1)",
                                    pointHitRadius: 10,
                                    pointBorderWidth: 2,
                                    data: data.chart.f_measure,
                                },
                                {
                                    label: "Precision",
                                    lineTension: 0.3,
                                    backgroundColor: "#36b9cc",
                                    borderColor: "rgba(78, 115, 223, 1)",
                                    pointRadius: 3,
                                    pointBackgroundColor: "rgba(78, 115, 223, 1)",
                                    pointBorderColor: "rgba(78, 115, 223, 1)",
                                    pointHoverRadius: 3,
                                    pointHoverBackgroundColor: "rgba(78, 115, 223, 1)",
                                    pointHoverBorderColor: "rgba(78, 115, 223, 1)",
                                    pointHitRadius: 10,
                                    pointBorderWidth: 2,
                                    data: data.chart.precision,
                                },
                                {
                                    label: "Recall",
                                    lineTension: 0.3,
                                    backgroundColor: "#1cc88a",
                                    borderColor: "rgba(78, 115, 223, 1)",
                                    pointRadius: 3,
                                    pointBackgroundColor: "rgba(78, 115, 223, 1)",
                                    pointBorderColor: "rgba(78, 115, 223, 1)",
                                    pointHoverRadius: 3,
                                    pointHoverBackgroundColor: "rgba(78, 115, 223, 1)",
                                    pointHoverBorderColor: "rgba(78, 115, 223, 1)",
                                    pointHitRadius: 10,
                                    pointBorderWidth: 2,
                                    data: data.chart.recall,
                                },
                            ],
                        },
                        options: chart_option
                    });
                }
            });
        });

        $('#form-bobot #btn-reset').click(function() {

            $('#form-bobot').trigger('reset');
            $('#form-bobot').find('[name="fk_bobot"]').trigger('change');
        });

        getContent();
    });


    var delete_prompt_batch = (list) => {
        if (list.length == 0) {
            Swal.fire({
                title: 'Peringatan',
                text: "Pilih berita yang akan dihapus terlebih dahulu!",
                icon: 'warning',
            });
        } else {

            Swal.fire({
                title: 'Apakan anda yakin?',
                text: list.length + " data yang dipilih akan dihapus",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#cf0606',
                cancelButtonColor: '#505050',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: cname_url + "/deleteBatch",
                        type: "POST",
                        data: {
                            list_pengujian: list,
                        },
                        dataType: "JSON",
                    }).done((data) => {
                        Swal.fire(data.swal);

                        table_pengujian.ajax.reload(null, false);
                    });
                }
            })

        }
    }

    var detail_prompt = (obj) => {
        $.ajax({
            url: cname_url + "/modalDetailBerita",
            type: "POST",
            data: {
                id_berita: $(obj).data('id'),
                auto: $(obj).data('auto'),
                manual: $(obj).data('manual'),
            },
        }).done((data) => {
            $('#modal-shower').find('.modal-content').html(data);
            $('#modal-shower').modal('show');

            $('.nav-modal-detail a').each(function(index) {
                $(this).on("click", function() {
                    let className = $(this).data("select");
                    let status = $(this).data("status");
                    if (status) {
                        $('.berita-content').find('.' + className).fadeOut('fast');
                        $(this).css('text-decoration', 'line-through');
                    } else {
                        $('.berita-content').find('.' + className).fadeIn('fast');
                        $(this).css('text-decoration', 'none');
                    }
                    $(this).data("status", !status)
                });
            })
        });
    }

    var doUpload = (obj) => {
        let id = $(obj).data("id");
        $('#import-id-pengujian').val(id);
        $('#input-file').click();
    }

    var viewDetail = (obj) => {
        let id = $(obj).data('id');

        $('#form-bobot').find("[name='id_pengujian']").val(id);
        $('#container-detail-pengujian').fadeIn("fast");

        $('#form-bobot').submit();

        $('html, body').animate({
            scrollTop: $($('#container-detail-pengujian')).offset().top
        }, 500);
    }

    var doResetPengujian = () => {
        let id = $('#form-bobot').find('[name="id_pengujian"]').val();
        Swal.fire({
            title: 'Apakah kamu yakin?',
            text: "Kamu tidak dapat mengembalikan data yang direset",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, reset',
            cancelButtonText: 'Tidak'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: cname_url + "/doResetPengujian",
                    type: "POST",
                    data: {
                        id_pengujian: id,
                    },
                    dataType: "JSON",
                }).done((data) => {
                    Swal.fire(data.swal);

                    table_pengujian.ajax.reload(null, false);

                    $('#container-detail-pengujian').fadeOut("fast");
                    $('html, body').animate({
                        scrollTop: $($('.container-fluid')).offset().top
                    }, 500);
                });
            }
        })
    }

    var excelDownload = (obj) => {
        let id = $(obj).data('id');

        Swal.fire({
            title: 'Pilih Tanda peringkasan otomatis',
            input: 'select',
            inputOptions: data_bobot,
            showCancelButton: true,
            inputValidator: (value) => {
                window.open(
                    cname_url+"/download_excel/"+id+"/"+value,
                    '_blank'
                );
            }
        });
    }

    var getContent = () => {
        $.ajax({
            url: cname_url + "/getBobot",
            type: "POST",
            dataType: "JSON",
            success: (data) => {
                data_bobot = data.bobot;
            }
        })
    }
</script>