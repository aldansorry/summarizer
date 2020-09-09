<script>
    var base_url = "<?php echo base_url(); ?>";
    var cname_url = "<?php echo base_url($cname); ?>";

    var table_data_news;

    $(document).ready(function() {
        table_data_news = $('#table-data-news').DataTable({
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
                url: cname_url + "/getData",
            },
            buttons: [{
                text: 'Delete Batch',
                className: "btn btn-danger",
                action: function(e, dt, node, config) {
                    let data = table_data_news.rows({
                        selected: true
                    }).data();

                    let selected_id = [];
                    $.each(data, function(i, item) {
                        selected_id.push(item.id);
                    });

                    delete_berita_batch(selected_id);

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
                        ret += '<a href="javascript:void(0)" onclick="delete_berita(this)" class="btn btn-sm btn-flat text-danger" data-id="' + data.id + '"><i class="fa fa-trash"></i> Hapus</a>';
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
    });


    var detail_prompt = (obj) => {
        $.ajax({
            url: cname_url + "/modalDetail",
            type: "POST",
            data: {
                id_berita: $(obj).data('id'),
            },
        }).done((data) => {
            $('#modal-shower').find('.modal-content').html(data);
            $('#modal-shower').modal('show');
        });
    }

    var delete_berita = (obj) => {

        Swal.fire({
            title: 'Apakan anda yakin?',
            text: "Data yang dihapus tidak dapat dikembalikan",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#cf0606',
            cancelButtonColor: '#505050',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: cname_url + "/deleteBerita",
                    type: "POST",
                    data: {
                        id_berita: $(obj).data('id'),
                    },
                    dataType: "JSON",
                }).done((data) => {
                    Swal.fire(
                        data.title,
                        data.text,
                        data.type
                    );

                    table_data_news.ajax.reload(null, false);
                });
            }
        })


    }

    var delete_berita_batch = (list) => {
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
                        url: cname_url + "/deleteBeritaBatch",
                        type: "POST",
                        data: {
                            list_berita: list,
                        },
                        dataType: "JSON",
                    }).done((data) => {
                        Swal.fire(
                            data.title,
                            data.text,
                            data.type
                        );

                        table_data_news.ajax.reload(null, false);
                    });
                }
            })

        }
    }
</script>