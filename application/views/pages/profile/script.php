<script>
    var base_url = "<?php echo base_url(); ?>";
    var cname_url = "<?php echo base_url($cname); ?>";
    $(document).ready(function() {

        $('#form-update').submit(function(e) {
            e.preventDefault();

            let elementForm = $(this);
            let formData = new FormData(this);

            $.ajax({
                url: cname_url + "/update_profile",
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
                    }
                }
            });
        });
    })

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