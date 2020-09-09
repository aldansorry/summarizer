<div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel">Berita Detail</h5>
    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">×</span>
    </button>
</div>
<div class="modal-body">
    <?php if ($this->input->post('auto') != null) : ?>
        <ul class="list-unstyled nav-modal-detail">
            <li><a href="javascript:void(0)" class="nav-link" data-status="true" data-select="text-dark"><i class="fa fa-circle text-dark"></i> Kalimat Asli</a></li>
            <li><a href="javascript:void(0)" class="nav-link" data-status="true" data-select="text-primary"><i class="fa fa-circle text-primary"></i> Kalimat ringkasan auto dan manual</a></li>
            <li><a href="javascript:void(0)" class="nav-link" data-status="true" data-select="text-info"><i class="fa fa-circle text-info"></i> Kalimat ringkasan auto</a></li>
            <li><a href="javascript:void(0)" class="nav-link" data-status="true" data-select="text-success"><i class="fa fa-circle text-success"></i> Kalimat ringkasan manual</a></li>
        </ul>
    <?php endif ?>
    <div class="berita-content">
        <p>
            <?php $paragraft = 0 ?>
            <?php foreach ($data_berita_kalimat as $key => $value) : ?>

                <span class="<?php echo $value->class ?>"><sup><?php echo $value->index_kalimat+1 ?></sup><?php echo $value->kalimat . "."; ?></span>
                <?php if ($paragraft != $value->paragraft) : ?>
        </p>
        <p>
            <?php $paragraft = $value->paragraft ?>
        <?php endif ?>
    <?php endforeach ?>
        </p>
    </div>
</div>
<div class="modal-footer">
    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
</div>