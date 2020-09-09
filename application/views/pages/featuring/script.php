<script>
    var base_url = "<?php echo base_url(); ?>";
    var cname_url = "<?php echo base_url($cname); ?>";

    var table_berita;
    var table_detail;
    var table_pembobotan;
    var table_preprocessing;
    var table_tf;
    var table_tfidf;
    var table_f1;

    var berita_featured;

    var berita_index;


    $(document).ready(function() {

        load_raw_data();

        table_berita = $('#table-berita').DataTable({
            'ajax': {
                url: cname_url + "/getFeaturingBerita",
                "dataSrc": function(data) {
                    berita_featured = data.data;
                    return data.data;
                }
            },
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

        $('#table-berita tbody').on('click', 'tr', function() {
            let index = table_berita.row(this).index();
            berita_index = index;
            open_analyst(berita_featured[berita_index].id);
        });

        table_detail = $('#table-detail').DataTable({
            dom: "<'pb-1'B><'float-left ml-3'i>frt",
            orderCellsTop: true,
            scrollX: true,
            scrollY: '50vh',
            scrollCollapse: true,
            paging: false,
            buttons: [{
                text: 'Hide Sentence',
                className: "btn btn-warning",
                action: function(e, dt, node, config) {
                    var column = table_detail.column(7);
                    column.visible(!column.visible());
                    var column = table_detail.column(8);
                    column.visible(!column.visible());
                }
            }],
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
                    'title': 'f1',
                    'data': (data) => {
                        return parseFloat(data.f1).toFixed(4);
                    },
                },
                {
                    'title': 'f2',
                    'data': (data) => {
                        return parseFloat(data.f2).toFixed(4);
                    },
                },
                {
                    'title': 'f3',
                    'data': (data) => {
                        return parseFloat(data.f3).toFixed(4);
                    },
                },
                {
                    'title': 'f4',
                    'data': (data) => {
                        return parseFloat(data.f4).toFixed(4);
                    },
                },
                {
                    'title': 'f5',
                    'data': (data) => {
                        return parseFloat(data.f5).toFixed(4);
                    },
                },
                {
                    'title': 'f6',
                    'data': (data) => {
                        return parseFloat(data.f6).toFixed(4);
                    },
                },
                {
                    'title': 'Kalimat',
                    'data': 'kalimat'
                },
                {
                    'title': 'Paragraft',
                    'data': 'paragraft'
                },
            ],
        });

        table_pembobotan = $('#table-pembobotan').DataTable({
            dom: "<'pb-1'B><'float-left ml-3'i>frt",
            orderCellsTop: true,
            scrollX: true,
            scrollY: '50vh',
            scrollCollapse: true,
            paging: false,
            buttons: [{
                text: 'Hide Sentence',
                className: "btn btn-warning",
                action: function(e, dt, node, config) {
                    var column = table_pembobotan.column(8);
                    column.visible(!column.visible());
                    var column = table_pembobotan.column(9);
                    column.visible(!column.visible());
                }
            }],
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
                    'title': 'f1',
                    'data': (data) => {
                        return parseFloat(data.f1).toFixed(4);
                    },
                },
                {
                    'title': 'f2',
                    'data': (data) => {
                        return parseFloat(data.f2).toFixed(4);
                    },
                },
                {
                    'title': 'f3',
                    'data': (data) => {
                        return parseFloat(data.f3).toFixed(4);
                    },
                },
                {
                    'title': 'f4',
                    'data': (data) => {
                        return parseFloat(data.f4).toFixed(4);
                    },
                },
                {
                    'title': 'f5',
                    'data': (data) => {
                        return parseFloat(data.f5).toFixed(4);
                    },
                },
                {
                    'title': 'f6',
                    'data': (data) => {
                        return parseFloat(data.f6).toFixed(4);
                    },
                },
                {
                    'title': 'sum',
                    'data': (data) => {
                        return parseFloat(data.sum).toFixed(4);
                    },
                },
                {
                    'title': 'Kalimat',
                    'data': 'kalimat'
                },
                {
                    'title': 'Paragraft',
                    'data': 'paragraft'
                },
            ],
        });

        table_preprocessing = $('#table-preprocessing').DataTable({
            dom: "t",
            orderCellsTop: true,
            scrollX: true,
            scrollY: '100vh',
            scrollCollapse: true,
            paging: false,
            'columns': [{
                    'title': 'No',
                    'className': "th-sticky",
                    'class': "th-sticky",
                    'width': "10px",
                    'data': 'no_kalimat'
                },
                {
                    'title': 'plain',
                    'data': 'plain'
                },
                {
                    'title': 'lower',
                    'visible': false,
                    'data': 'lower'
                },
                {
                    'title': 'filtered',
                    'visible': false,
                    'data': 'filtered'
                },
                {
                    'title': 'stem',
                    'visible': false,
                    'data': 'stem'
                },
                {
                    'title': 'Tokenizing',
                    'visible': false,
                    'data': 'tokenizing'
                },
                {
                    'title': 'Stopword',
                    'visible': false,
                    'data': 'stopword'
                },
            ],
        });

        $('.btn-toogle-table-preprocessing').on('click', function(e) {
            e.preventDefault();
            table_preprocessing.columns([1, 2, 3, 4, 5, 6]).visible(false);
            var column = table_preprocessing.column($(this).attr('data-column'));
            column.visible(!column.visible());
        });
    });

    var open_analyst = (id) => {

        $('#ringkasan-kalimat').html("");
        $('#select-pembobotan').val(-1);
        table_pembobotan.clear();
        table_pembobotan.draw();

        $.ajax({
            url: cname_url + "/getBeritaDetail",
            type: "POST",
            data: {
                id: id,
            },
            dataType: "JSON",
        }).done((data) => {
            // alert(JSON.stringify(data));

            $('.berita-judul').html(data.berita_data.judul);
            table_detail.clear();
            table_detail.rows.add(data.kalimat_data);
            table_detail.draw();

            //konten-tab
            $('#konten').html(data.konten_data);

            //preprocessing-tab
            table_preprocessing.clear();
            table_preprocessing.rows.add(data.preprocessing_data);
            table_preprocessing.draw();

            //tfidf

            if (table_tfidf != null) {
                table_tfidf.destroy();
                $('#tfidf').html("");
                let table = '<h3>TF</h3><table class="table table-bordered nowrap table-sm table-striped" id="table-tf" cellspacing="0"></table><h3>TF - IDF</h3><table class="table table-bordered nowrap table-sm table-striped mt-3" id="table-tfidf" cellspacing="0"></table>';
                $('#tfidf').html(table);
            }

            table_tf = $('#table-tf').DataTable({
                dom: "t",
                scrollX: true,
                scrollY: '50vh',
                scrollCollapse: true,
                paging: false,
                'columns': data.tf.column
            });

            table_tf.clear();
            table_tf.rows.add(data.tf.data);
            table_tf.draw();

            table_tfidf = $('#table-tfidf').DataTable({
                dom: "t",
                scrollX: true,
                scrollY: '50vh',
                scrollCollapse: true,
                paging: false,
                'columns': data.tfidf.column
            });

            table_tfidf.clear();
            table_tfidf.rows.add(data.tfidf.data);
            table_tfidf.draw();

            //f1
            $('#f1').html(data.f1_data);
            $('#f2').html(data.f2_data);
            $('#f3').html(data.f3_data);
            $('#f4').html(data.f4_data);
            $('#f5').html(data.f5_data);
            $('#f6').html(data.f6_data);


            update_interface();
        })
    }

    var next = () => {
        if ((parseInt(berita_index) + 1) <= (berita_featured.length - 1)) {
            berita_index = parseInt(berita_index) + 1;
        }
        open_analyst(berita_featured[berita_index].id);
    }

    var prev = () => {
        if ((parseInt(berita_index) - 1) >= 0) {
            berita_index = parseInt(berita_index) - 1;
        }
        open_analyst(berita_featured[berita_index].id);
    }

    var update_interface = () => {
        if (berita_index == berita_featured.length - 1) {
            $('.btn-next').fadeOut();
        } else {
            $('.btn-next').fadeIn();
        }
        if (berita_index == 0) {
            $('.btn-prev').fadeOut();
        } else {
            $('.btn-prev').fadeIn();
        }

        if (berita_index != null) {
            $('.container-table-berita').fadeOut();
            $('.container-table-detail').fadeIn();
        } else {
            $('.container-table-berita').fadeIn();
            $('.container-table-detail').fadeOut();
        }
    }

    var open_daftar = () => {
        berita_index = null;
        update_interface();
    }

    var change_pembobotan = (obj) => {
        let id_bobot = $(obj).val();
        let id_berita = berita_featured[berita_index].id;
        $.ajax({
            'url': cname_url + "/getSummarized",
            'type': "POST",
            'data': {
                'id_bobot': id_bobot,
                'id_berita': id_berita,
            },
            'dataType': "JSON",
            success: (data) => {

                table_pembobotan.clear();
                table_pembobotan.rows.add(data.data_pembobotan);
                table_pembobotan.draw();

                $('#ringkasan-kalimat').html(data.ringkasan_data);
            }
        });
    }

    var data_raw_berita = [];
    var load_raw_data = () => {
        $.ajax({
            url: cname_url + "/getRawData",
            dataType: 'JSON',
        }).done((data) => {
            data_raw_berita = data.raw_berita;
            $('#jumlah-berita-no-feature').text(data_raw_berita.length);
        })
    }

    var first_idx = 0;
    var abort_featuring = () => {
        is_aborted = true;
        $('#btn-abort').text('Abourting.....');
        $('#progress-title').text('Abourting.....');
    }

    let count_data = 0;
    let data_featured;

    var do_featuring = () => {
        count_data = data_raw_berita.length;
        is_aborted = false;
        data_featured = 0;

        if (count_data == 0) {
            Swal.fire({
                'icon': "info",
                'title': "No Data",
            });
            return;
        }
        $('#progress-header').fadeIn('fast');
        $('#progress-bar').css('width', "0%");
        $('#progress-title').text('Loading.....');
        featuring();
    }

    var featuring = () => {

        $('#btn-featuring').hide();
        $('#btn-abort').show();

        $.ajax({
            url: cname_url + "/doFeaturing/",
            type: "POST",
            dataType: 'JSON',
        }).done((data) => {



            data_featured += data.count_featured;
            $('#progress-bar').css('width', parseFloat((data_featured / count_data) * 100).toFixed(0) + "%");
            $('#progress-text').text(parseFloat((data_featured / count_data) * 100).toFixed(0) + "%");

            if (data.has_continue) {
                if (!is_aborted) {
                    featuring();
                } else {
                    $('#progress-title').text('Abourted.....');
                    $('#btn-featuring').show();
                    $('#btn-abort').hide().text('Abort Featuring');
                    load_raw_data();
                }

                if (data_raw_berita.length == 0) {
                    $('#btn-featuring').show();
                    $('#btn-abort').hide().text('Abort Featuring');
                    $('#progress-title').text('Finished');
                }
            } else {
                $('#btn-featuring').show();
                $('#btn-abort').hide().text('Abort Featuring');
                $('#progress-title').text('Finished');
                load_raw_data();
            }

        });
    }
</script>