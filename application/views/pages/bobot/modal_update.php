<div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel">Edit Bobot</h5>
    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">×</span>
    </button>
</div>
<div class="modal-body">
    <?php echo form_open_multipart("", ['id' => 'form-update']); ?>
    <div class="form-group row">
        <label for="" class="col-form-label col-md-3 text-md-right">Nama</label>
        <div class="col-md-9">
            <input type="text" name="nama" class="form-control" value="<?php echo $data_bobot->nama ?>">
            <small class="invalid-feedback"></small>
        </div>
    </div>
    <div class="form-group row">
        <label for="" class="col-form-label col-md-3 text-md-right">Kompresi</label>
        <div class="col-md-9">
            <input type="number" min="1" max="99" value="50" name="kompresi" class="form-control" value="<?php echo $data_bobot->kompresi ?>">
            <small class="invalid-feedback"></small>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-md-3 text-md-right">
            <h5>Feature</h5>
        </div>
    </div>
    <div class="form-group row">
        <label for="" class="col-form-label col-2 col-md-3 text-md-right">F1</label>

        <label for="" class="col-form-label col-10 col-md-7 ">Kesamaan kata antar kalimat</label>

        <div class="col-md-2">
            <input type="number" step="0.01" value="<?php echo $data_bobot->f1 ?>" name="f1" class="form-control">
            <small class="invalid-feedback"></small>
        </div>
    </div>
    <div class="form-group row">
        <label for="" class="col-form-label col-2 col-md-3 text-md-right">F2</label>

        <label for="" class="col-form-label col-10 col-md-7 ">Kesamaan kata dengan judul</label>

        <div class="col-md-2">
            <input type="number" step="0.01" value="<?php echo $data_bobot->f2 ?>" name="f2" class="form-control">
            <small class="invalid-feedback"></small>
        </div>
    </div>
    <div class="form-group row">
        <label for="" class="col-form-label col-2 col-md-3 text-md-right">F3</label>

        <label for="" class="col-form-label col-10 col-md-7 ">Huruf Kapital</label>

        <div class="col-md-2">
            <input type="number" step="0.01" value="<?php echo $data_bobot->f3 ?>" name="f3" class="form-control">
            <small class="invalid-feedback"></small>
        </div>
    </div>
    <div class="form-group row">
        <label for="" class="col-form-label col-2 col-md-3 text-md-right">F4</label>

        <label for="" class="col-form-label col-10 col-md-7 ">Kalimat Kutipan</label>

        <div class="col-md-2">
            <input type="number" step="0.01" value="<?php echo $data_bobot->f4 ?>" name="f4" class="form-control">
            <small class="invalid-feedback"></small>
        </div>
    </div>
    <div class="form-group row">
        <label for="" class="col-form-label col-2 col-md-3 text-md-right">F5</label>

        <label for="" class="col-form-label col-10 col-md-7 ">Penggunaan Angka</label>

        <div class="col-md-2">
            <input type="number" step="0.01" value="<?php echo $data_bobot->f5 ?>" name="f5" class="form-control">
            <small class="invalid-feedback"></small>
        </div>
    </div>
    <div class="form-group row">
        <label for="" class="col-form-label col-2 col-md-3 text-md-right">F6</label>

        <label for="" class="col-form-label col-10 col-md-7 ">Panjang Kalimat</label>

        <div class="col-md-2">
            <input type="number" step="0.01" value="<?php echo $data_bobot->f6 ?>" name="f6" class="form-control">
            <small class="invalid-feedback"></small>
        </div>
    </div>

    <?php echo form_close(); ?>
</div>
<div class="modal-footer">
    <button type="submit" class="btn btn-success" form="form-update">Edit</button>
    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
</div>