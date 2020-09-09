<script>
    var cname_url = "<?php echo base_url($cname) ?>";
    $(document).ready(function() {
        Swal.fire({
            position: 'bottom-start',
            icon: 'success',
            title: 'Your work has been saved',
            showConfirmButton: false,
            timer: 500
        })

        get_berita($('#recent-berita'),10,0);
    });

    var get_berita = (objContainer,limit,offset) => {
        $.ajax({
            url: cname_url + "/getBerita",
            type: "POST",
            data: {
                limit: limit,
                offset: offset,
            },
            dataType: "JSON",
        }).done((data) => {
            console.log(data);
            $.each(data, function(i,obj) {
                
                let html = "";
                html += '<div class="single-blog-post small-featured-post d-flex">';
                html += '<div class="post-thumb">';
                html += '<a href="#"><img src="'+obj.gambar+'" alt=""></a>';
                html += '</div>';
                html += '<div class="post-data">';
                html += '<a href="#" class="post-catagory">'+obj.sumber.text+'</a>';
                html += '<div class="post-meta">';
                html += '<a href="'+obj.link+'" class="post-title">';
                html += '<h6>'+obj.judul+'</h6>';
                html += '</a>';
                html += '<p class="post-date"><span>'+obj.tanggal.time+'</span> | <span>'+obj.tanggal.format+'</span></p>';
                html += '</div>';
                html += '</div>';
                html += '</div>';

                objContainer.append(html);
            })
        })
    }
</script>