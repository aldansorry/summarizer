<script>
    var base_url = "<?php echo base_url(); ?>";
    var cname_url = "<?php echo base_url($cname); ?>";
    var bobot_default = "<?php echo getConfig("bobot_default") ?>";

    var table_bobot;

    $(document).ready(function() {
        table_bobot = $('#table-bobot').DataTable({
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
                url: cname_url + "/getBobot",
            },
            buttons: [{
                text: 'Tambah',
                className: "btn btn-primary",
                action: function(e, dt, node, config) {
                    insert_prompt();
                }
            }, {
                text: 'Delete Batch',
                className: "btn btn-danger",
                action: function(e, dt, node, config) {
                    let data = table_bobot.rows({
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
                    'data': (data) => {
                        let ret = "";
                        ret += '<div class="btn-group">';
                        ret += '<a href="javascript:void(0)" onclick="update_prompt(this)" class="btn btn-sm text-warning" data-id="' + data.id + '"><i class="fa fa-pencil-alt"></i> Edit</a>';
                        if (bobot_default != data.id)
                            ret += '<a href="javascript:void(0)" onclick="delete_prompt(this)" class="btn btn-sm text-danger" data-id="' + data.id + '"><i class="fa fa-trash"></i> Hapus</a>';
                        else
                            ret += '<a href="'+base_url+'/Settings" class="btn btn-sm text-secondary"><i class="fa fa-cog"></i> Default</a>';
                        ret += '</div>';
                        return ret;
                    }
                },
                {
                    'title': 'Nama',
                    'data': 'nama'
                },
                {
                    'title': 'F1',
                    'data': 'f1'
                },
                {
                    'title': 'F2',
                    'data': 'f2'
                },
                {
                    'title': 'F3',
                    'data': 'f3'
                },
                {
                    'title': 'F4',
                    'data': 'f4'
                },
                {
                    'title': 'F5',
                    'data': 'f5'
                },
                {
                    'title': 'F6',
                    'data': 'f6'
                },
                {
                    'title': 'kompresi',
                    'data': (data) => {
                        return data.kompresi + "%";
                    }
                },
            ],
        });
    });

    var insert_prompt = () => {
        $.ajax({
            url: cname_url + "/modalInsert",
            type: "GET",
        }).done((data) => {
            $('#modal-shower').find('.modal-content').html(data);
            $('#modal-shower').modal('show');

            $('#form-insert').submit(function(e) {
                e.preventDefault();

                let elementForm = $(this);
                let multipleInsert = $('#multipleInsert').is(":checked");
                let formData = new FormData(this);

                $.ajax({
                    url: cname_url + "/insert_action",
                    type: "POST",
                    data: formData,
                    dataType: 'JSON',
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: (data) => {
                        elementForm.find(".is-invalid").removeClass('is-invalid');

                        if (data.error) {
                            $.each(data.form_error, function(key, text) {
                                elementForm.find('[name="' + key + '"]').addClass('is-invalid').parent().find('.invalid-feedback').html(text);
                            });
                        } else {
                            Swal.fire(data.swal);
                            table_bobot.ajax.reload(null, false);

                            if (!multipleInsert) {
                                $('#modal-shower').modal('hide');
                                $('#modal-shower').find('.modal-content').html("");
                            } else {
                                elementForm.find(".is-invalid").removeClass('is-invalid');
                                elementForm.trigger('reset');
                            }
                        }
                    }
                });
            });
        });
    }

    var update_prompt = (obj) => {

        let id_bobot = $(obj).data('id');
        $.ajax({
            url: cname_url + "/modalUpdate",
            type: "POST",
            data: {
                id_bobot: id_bobot,
            },
        }).done((data) => {
            $('#modal-shower').find('.modal-content').html(data);
            $('#modal-shower').modal('show');

            $('#form-update').submit(function(e) {
                e.preventDefault();

                let elementForm = $(this);
                let formData = new FormData(this);
                formData.append("id_bobot", id_bobot);

                $.ajax({
                    url: cname_url + "/update_action",
                    type: "POST",
                    data: formData,
                    dataType: 'JSON',
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: (data) => {

                        elementForm.find(".is-invalid").removeClass('is-invalid');

                        if (data.error) {
                            $.each(data.form_error, function(key, text) {
                                elementForm.find('[name="' + key + '"]').addClass('is-invalid').parent().find('.invalid-feedback').html(text);
                            });
                        } else {
                            Swal.fire(data.swal);
                            table_bobot.ajax.reload(null, false);

                            $('#modal-shower').modal('hide');
                            $('#modal-shower').find('.modal-content').html("");
                        }
                    }
                });
            });
        });
    }

    var delete_prompt = (obj) => {

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
                    url: cname_url + "/delete",
                    type: "POST",
                    data: {
                        id_bobot: $(obj).data('id'),
                    },
                    dataType: "JSON",
                }).done((data) => {
                    Swal.fire(data.swal);

                    table_bobot.ajax.reload(null, false);
                });
            }
        })


    }

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
                            list_bobot: list,
                        },
                        dataType: "JSON",
                    }).done((data) => {
                        Swal.fire(data.swal);

                        table_bobot.ajax.reload(null, false);
                    });
                }
            })

        }
    }


    var preview_img_upload = (obj) => {
        var input = obj;
        let img = $(obj).parent().find('img');
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                img.attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        } else {

            img.attr('src', img.data('default'));
        }
    }
</script>