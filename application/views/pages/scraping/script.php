<script>
    var base_url = "<?php echo base_url(); ?>";
    var cname_url = "<?php echo base_url($cname); ?>";

    var table_berita_scraped;
    var data_raw_berita;

    $(document).ready(function() {


        $('.date-picker').daterangepicker({
            opens: 'left',
            startDate: moment().startOf('now'),
            endDate: moment().startOf('now'),
            locale: {
                format: 'DD MMM YYYY'
            }
        }, function(start, end, label) {
            $('.input-date-from').val(start.format('YYYY-MM-DD'));
            $('.input-date-to').val(end.format('YYYY-MM-DD'));
        });


        $('#form-scraping').submit(function(e) {
            e.preventDefault();

            let elementForm = $(this);
            let submitForm = elementForm.find('button[type="submit"]');
            let formData = new FormData(this);

            $.ajax({
                    url: cname_url + "/doScraping/",
                    type: 'POST',
                    data: formData,
                    dataType: 'JSON',
                    cache: false,
                    contentType: false,
                    processData: false,
                    beforeSend: () => {
                        submitForm.addClass('disabled');
                    }
                })
                .done((data) => {
                    submitForm.removeClass('disabled');

                    if (data.error) {
                        Swal.fire({
                            icon: 'error',
                            title: data.message.title,
                            html: data.message.html,
                        });
                    } else {

                        loadBeritaScraped();
                        Swal.fire({
                            icon: 'success',
                            title: data.message.title,
                            html: data.message.html,
                        });
                    }
                    return;
                });
        })

        table_berita_scraped = $('#table-berita-scraped').DataTable({
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
                    "width": "15px",
                    'data': (data) => {
                        return "<span class='badge badge-primary loader' style='display:none'><i class='fas fa-spinner fa-spin'></i></span>"
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
                    "width": "15px",
                    'data': 'tanggal'
                },
                {
                    'title': 'Kategori',
                    "width": "15px",
                    'data': 'kategori'
                },
                {
                    'title': 'Judul',
                    'data': 'judul'
                },
                {
                    'title': 'link',
                    'data': 'link'
                },
            ],
        });
        loadBeritaScraped();
    });

    var loadBeritaScraped = () => {
        $.ajax({
            url: cname_url + "/getBeritaScraped",
            dataType: 'JSON',
        }).done((data) => {
            data_raw_berita = data.raw_berita;
            $('#jumlah-berita-no-konten').text(data_raw_berita.length);
            table_berita_scraped.clear();
            table_berita_scraped.rows.add(data_raw_berita);
            table_berita_scraped.draw();
        })
    }

    var first_idx = 0;
    var abort_scraping = () => {
        is_aborted = true;
        $('#btn-abort').text('Abourting.....');
        $('#progress-title').text('Abourting.....');
    }


    let count_data = 0;
    let data_scraped;

    var do_scraping = () => {
        count_data = data_raw_berita.length;
        is_aborted = false;
        data_scraped = 0;

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
        scraping();
    }

    var scraping = () => {
        $('#btn-scraping').hide();
        $('#btn-abort').show();
        $.ajax({
            url: cname_url + "/doScrapingKonten/",
            type: "POST",
            dataType: 'JSON',
        }).done((data) => {
            if (data.internet_error) {
                Swal.fire(data.swal);
                $('#progress-title').text('Check for connection');
                $('#btn-scraping').show();
                $('#progress-text').text("0%")
                $('#btn-abort').hide().text('Abort Scraping');
                loadBeritaScraped();
                return;
            }

            data_scraped += data.scraped;
            $('#progress-bar').css('width', parseFloat((data_scraped / count_data) * 100).toFixed(0) + "%");
            $('#progress-text').text(parseFloat((data_scraped / count_data) * 100).toFixed(0) + "%");

            if (data.has_continue) {
                $('.log').append(data.message);

                if (!is_aborted) {
                    scraping();
                } else {
                    $('#progress-title').text('Abourted.....');
                    $('#btn-scraping').show();
                    $('#btn-abort').hide().text('Abort Scraping');
                    loadBeritaScraped();
                }
            } else {
                $('#btn-scraping').show();
                $('#btn-abort').hide().text('Abort Scraping');
                $('#progress-title').text('Finished');
                loadBeritaScraped();
            }


        });
    }
</script>