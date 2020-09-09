<div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel">Berita Detail</h5>
    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">×</span>
    </button>
</div>
<div class="modal-body">
    <?php if (count($data_berita_kalimat) != 0) : ?>
        <p>
            <?php $paragraft = 0 ?>
            <?php foreach ($data_berita_kalimat as $key => $value) : ?>

                <?php echo $value->kalimat . "."; ?>
                <?php if ($paragraft != $value->paragraft) : ?>
        </p>
        <p>
            <?php $paragraft = $value->paragraft ?>
        <?php endif ?>
    <?php endforeach ?>
        </p>
    <?php else : ?>
        <code>Belum dilakukan scraping konten</code> <a href="<?php echo base_url("Scraping") ?>">Lakukan Scraping Konten</a>
    <?php endif ?>
</div>
<div class="modal-footer">
    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
</div>