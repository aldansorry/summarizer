<script>
    var cname_url = "<?php echo base_url($cname) ?>";
    var img_placeholder = "<?php echo base_url("assets/img/img-placeholder.jpg") ?>";

    var offset = 0;
    var limit = 10;

    let filter_sumber;
    let filter_tanggal;
    var filter_search;

    var is_scroll_loading = false;
    var lastScrollTop = 0;
    $(window).scroll(function() {
        if (!is_scroll_loading && $(window).scrollTop() >= $(document).height() - $(window).height() - 10) {
            is_scroll_loading = true;
            get_berita($('#container-berita'));
        }

        var st = $(this).scrollTop();
        if (st > lastScrollTop) {
            $('.filter-form').slideUp();
        } else {
            $('.filter-form').slideDown();
        }
        lastScrollTop = st;
    });

    $(document).ready(function() {

        $('input[name="daterange"]').daterangepicker({
            opens: 'right',
            locale: {
                format: 'DD MMM YYYY'
            }
        }, function(start, end, label) {
            console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
        });

        $('#filter-check-tanggal').change(function() {
            if ($(this).is(":checked")) {
                $('.filter-tanggal').attr('disabled', false);
            } else {
                $('.filter-tanggal').attr('disabled', true);
            }

        });

        get_berita($('#container-berita'));
    });


    var get_berita = (objContainer) => {
        $('#berita-loading').show();
        $.ajax({
            url: cname_url + "/getBerita",
            type: "POST",
            data: {
                limit: limit,
                offset: offset,
                sumber: filter_sumber,
                tanggal: filter_tanggal,
                search: filter_search,
            },
            dataType: "JSON",
        }).done((data) => {
            $('#berita-loading').hide();
            if (data.length != 0) {
                $.each(data, function(i, obj) {
                    let html = "";

                    html += '<div class="col-md-12">';
                    html += '<div class="card mb-4 border-left-' + obj.sumber.class + ' berita-header" data-id="' + obj.id + '">';
                    html += '<div class="card-body">';
                    html += '<div class="row">';

                    html += '<div class="col-md-12">';
                    html += '<a href="javascript:void(0)" class="badge badge-' + obj.sumber.class + ' mb-2 mt-0" data-id="' + obj.id + '" onclick="openRelevansi(this)">' + obj.sumber.text + '</a> | ';

                    html += '<div class="relevan-container" style="display:inline;">';
                    html += '<div class="spinner-border spinner-border-sm loading berita-konten" role="status" style="display:none;">';
                    html += '<span class="sr-only">Loading...</span>';
                    html += '</div>';
                    html += '</div>';

                    html += '</div>';
                    html += '<div class="col-md-2 col-4 mb-2">';
                    html += '<img class="lazy" src="' + img_placeholder + '"  data-src="' + obj.gambar + '" class="align-self-start mr-3 berita-gambar" alt="..." width="100%">';
                    html += '<a href="' + obj.link_full_page + '" target="_BLANK" class="btn btn-link btn-sm btn-block mt-1">Full Page</a>';

                    html += '</div>';
                    html += '<div class="col-md-10">';
                    html += '<h6 class="float-right berita-tanggal">' + obj.tanggal.time + ' | ' + obj.tanggal.format + '</h6>';
                    html += '<h6 class="text-primary berita-kategori">' + obj.kategori + '</h6>';
                    html += '<h5 class="mt-0 berita-judul font-weight-bold" data-id="1">' + obj.judul + '</h5>';
                    html += '<p class="berita-narasi">' + obj.deskripsi_text + '</p>';
                    html += '<div class="berita-konten" style="display: none;">' + obj.konten + '</div>';
                    html += '<a href="javascript:void(0)" class="card-link" onclick="show_konten(this)">Lihat</a>';
                    html += '</div>';
                    html += '</div>';
                    html += '</div>';
                    html += '</div>';
                    html += '</div>';

                    objContainer.append(html);
                });
                $('.lazy').Lazy();
                offset += limit;
                is_scroll_loading = false;
            } else {

                let html = "";
                html += '<div class="col-md-12">';
                html += '<div class="alert alert-warning" role="alert">';
                html += '<h4 class="alert-heading">No More Data!</h4>';
                html += '<p>Data Sudah Habis</p>';
                html += '</div>';
                html += '</div>';
                objContainer.append(html);
            }
        });
    }

    var show_konten = (obj) => {
        let button = $(obj);
        let header = $(obj).parents(".berita-header");


        $('html, body').animate({
            scrollTop: (header.offset().top - 110) + 'px'
        }, 500);

        if (header.find('.berita-narasi').is(':visible')) {
            button.text("Sembunyikan");
            header.addClass("shadow");
            header.find('.berita-narasi').slideUp('fast');
            header.find('.berita-konten').slideDown('fast');
            do_relevansi(obj);
        } else {
            button.text("Lihat");
            header.removeClass("shadow");
            header.find('.berita-narasi').slideDown('fast');
            header.find('.berita-konten').slideUp('fast');
        }
    }


    var filterSearch = () => {

        $('#container-filter-badge').html("");
        let badge = "";

        filter_sumber = [];
        $('.filter-sumber:checked').each(function() {
            filter_sumber.push($(this).val());
        });
        if (filter_sumber.length == 3) {
            badge += '<span class="badge badge-light mr-1">Semua sumber</span>';
        } else {
            $.each(filter_sumber, function(i, item) {
                switch (item) {
                    case '1':
                        badge += '<span class="badge badge-primary mr-1">Katadata</span>';
                        break;
                    case '2':
                        badge += '<span class="badge badge-info mr-1">Detik</span>';
                        break;
                    case '3':
                        badge += '<span class="badge badge-danger mr-1">Kompas</span>';
                        break;
                }
            });
        }

        if ($('#filter-check-tanggal').is(":checked")) {
            filter_tanggal = $('.filter-tanggal').val();
            badge += '<span class="badge badge-warning mr-1">Tanggal : ' + filter_tanggal + '</span>';
        }else{
            filter_tanggal = null;
        }

        filter_search = $('.filter-search').val();
        if (filter_search != "") {
            badge += '<span class="badge badge-success mr-1">Search : ' + filter_search + '</span>';
        }

        $('#container-filter-badge').append(badge);
        $('#container-berita').html("");

        offset = 0;
        is_scroll_loading = false;
        get_berita($('#container-berita'));
    }


    var do_relevansi = (obj) => {
        let header = $(obj).parents(".berita-header");
        let id = header.data('id');


        if (header.find('.loading').length != 0) {
            $.ajax({
                url: cname_url + "/doRelevansi",
                type: "POST",
                data: {
                    id_berita: id,
                },
                dataType: "JSON",
                success: (data) => {
                    let html = "";
                    html += "Relevansi : ";
                    if (data.badge.length != 0) {
                        $.each(data.badge, function(i, item) {
                            html += '<a href="javascript:void(0)" class="badge badge-' + item.class + ' mr-1" data-id="' + item.id + '" onclick="openRelevansi(this)">' + item.text + '</a>';
                        });
                    } else {
                        html += '<span class="badge badge-secondary mr-1">tidak ada berita relevan</span>';
                    }
                    header.find('.relevan-container').html(html);
                }
            });
        }
    }

    var openRelevansi = (obj) => {
        let header = $(obj).parents(".berita-header");
        let id = $(obj).data('id');

        $.ajax({
            url: cname_url + "/getSingleBerita",
            type: "POST",
            data: {
                id_berita: id,
            },
            dataType: "JSON",
            success: (data) => {
                header.find('.lazy').attr('src', data.gambar);
                header.find('.btn-link').attr('href', data.link_full_page);
                header.find('.berita-tanggal').text(data.tanggal.time + ' | ' + data.tanggal.format);
                header.find('.berita-kategori').text(data.kategori);
                header.find('.berita-judul').text(data.judul);
                header.find('.berita-narasi').html(data.deskripsi_text);
                header.find('.berita-konten').html(data.konten);

                header.removeClass('border-left-primary').removeClass('border-left-info').removeClass('border-left-danger');
                header.addClass('border-left-' + data.sumber.class);
            }
        })
    }
</script>