<script>
    var cname_url = "<?php echo base_url($cname); ?>";

    var berita_unrelevanted = 0;
    var table_relevansi;
    $(document).ready(function() {
        table_relevansi = $('#table-relevansi').DataTable({
            'ajax': {
                url: cname_url + "/getRelevansiData",
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
                    'title': 'Judul Berita',
                    'data': 'judul_berita_1'
                },
                {
                    'title': 'Judul Berita',
                    'data': 'judul_berita_2'
                },
                {
                    'title': 'Nilai',
                    'data': 'nilai'
                },
            ],
        });

        $.ajax({
            url: cname_url + "/getContent",
            dataType: "JSON",
            success: (data) => {
                $('#jumlah-berita-unrelevanted').text(data.count_unrelevanted);
                berita_unrelevanted = data.count_unrelevanted;
            }
        });
    });

    var abort = () => {
        is_aborted = true;
        $('#btn-abort').text('Abourting.....');
        $('#progress-title').text('Abourting.....');
    }

    let count_data = 0;
    let data_relevanted;

    var doRelevansi = () => {
        count_data = berita_unrelevanted;
        is_aborted = false;
        data_relevanted = 0;

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
        relevansi();
    }

    var relevansi = () => {

        $('#btn-relevansi').hide();
        $('#btn-abort').show();

        $.ajax({
            url: cname_url + "/doRelevansi/",
            type: "POST",
            dataType: 'JSON',
        }).done((data) => {
            
            data_relevanted += data.count_relevanted;
            $('#progress-bar').css('width', parseFloat((data_relevanted / count_data) * 100).toFixed(0) + "%");
            $('#progress-text').text(parseFloat((data_relevanted / count_data) * 100).toFixed(0) + "%");
            $('#jumlah-berita-unrelevanted').text(data_relevanted+"/"+count_data);

            if (data.has_continue) {
                if (!is_aborted) {
                    relevansi();
                } else {
                    $('#progress-title').text('Abourted.....');
                    $('#btn-relevansi').show();
                    $('#btn-abort').hide().text('Abort Relevansi');
                    table_relevansi.ajax.reload(null,false);
                }
            } else {
                $('#btn-relevansi').show();
                $('#btn-abort').hide().text('Abort Relevansi');
                $('#progress-title').text('Finished');
                table_relevansi.ajax.reload(null,false);
            }

        });
    }
</script>