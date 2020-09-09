<script>
    var base_url = "<?php echo base_url(); ?>";
    var cname_url = "<?php echo base_url($cname); ?>";

    var table_raw_berita;

    var data_raw_berita;

    var is_aborted;
    $(document).ready(function() {
        table_raw_berita = $('#table-raw-berita').DataTable({
            order: false,
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
            ],
        });

        load_raw_data();
    });

    
</script>