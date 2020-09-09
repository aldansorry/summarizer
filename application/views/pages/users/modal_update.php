<div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel">Edit Users</h5>
    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">×</span>
    </button>
</div>
<div class="modal-body">
    <?php echo form_open_multipart("", ['id' => 'form-update']); ?>
    <div class="form-group row">
        <label for="" class="col-form-label col-md-3 text-md-right">Nama</label>
        <div class="col-md-9">
            <input type="text" name="nama" class="form-control" value="<?php echo $data_users->nama ?>">
            <small class="invalid-feedback"></small>
        </div>
    </div>
    <div class="form-group row">
        <label for="" class="col-form-label col-md-3 text-md-right">Username</label>
        <div class="col-md-9">
            <input type="text" name="username" class="form-control" value="<?php echo $data_users->username ?>">
            <small class="invalid-feedback"></small>
        </div>
    </div>
    <div class="form-group row">
        <label for="" class="col-form-label col-md-3 text-md-right">Level</label>
        <div class="col-md-9">
            <select name="level" class="form-control">
                <option value="1" <?php echo ($data_users->level == 1 ? "selected" : "") ?>>Admin</option>
                <option value="2" <?php echo ($data_users->level == 2 ? "selected" : "") ?>>Maintance</option>
            </select>
            <small class="invalid-feedback"></small>
        </div>
    </div>

    <hr>
    <div class="row">
        <div class="col-md-3 text-md-right">
            <h5>Optional</h5>
        </div>
    </div>
    <div class="form-group row">
        <label for="" class="col-form-label col-md-3 text-md-right">Password</label>
        <div class="col-md-9">
            <div class="row">
                <div class="col-md-6">
                    <input type="password" name="password" class="form-control" placeholder="Password">
                    <small class="invalid-feedback"></small>
                </div>
                <div class="col-md-6">
                    <input type="password" name="repassword" class="form-control" placeholder="Re-Password">
                    <small class="invalid-feedback"></small>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group row">
        <label for="" class="col-form-label col-md-3 text-md-right">Gambar</label>
        <div class="col-md-9">
            <label for="input-file">
                <img src="<?php echo base_url("storage/users/" . $data_users->gambar) ?>" alt="deleted" for="input-file" width="100px" class="img-hover" data-default="<?php echo base_url("storage/users/" . $data_users->gambar) ?>">
            </label>
            <input type="file" name="gambar" class="form-control" id="input-file" style="display: none" onchange="preview_img_upload(this)">
            <small class="invalid-feedback"></small>
        </div>
    </div>
    <?php echo form_close(); ?>
</div>
<div class="modal-footer">
    <button type="submit" class="btn btn-success" form="form-update">Edit</button>
    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
</div>