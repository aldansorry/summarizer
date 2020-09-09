<h1 class="h3 mb-4 text-gray-800"><?= $title ?></h1>

<div class="row">
    <div class="col-sm-12 col-md-12 col-lg-8">
        <div class="card">
            <div class="card-body">
                <?php echo form_open('', ['id' => 'form-update']); ?>
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

                <hr>
                <div class="row">
                    <div class="col-md-3 text-md-right">
                        <h5>Optional</h5>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-form-label col-md-3 text-md-right">Old Password</label>
                    <div class="col-md-9">
                        <input type="password" name="oldpassword" class="form-control" value="" placeholder="Old Password">
                        <small class="invalid-feedback"></small>
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
                            <img src="<?php echo base_url("storage/users/" . $data_users->gambar . "?time=" . time()) ?>" alt="deleted" for="input-file" width="100px" class="img-hover" data-default="<?php echo base_url("storage/users/" . $data_users->gambar) ?>">
                        </label>
                        <input type="file" name="gambar" class="form-control" id="input-file" style="display: none" onchange="preview_img_upload(this)">
                        <small class="invalid-feedback"></small>
                    </div>
                </div>

                <div class="row">
                    <div class="offset-md-3 col-md-9">

                        <button type="submit" class="btn btn-primary btn-loading"><i class="fa fa-sync-alt fa-spin loading-ico"></i><span> Edit Profile</span></button>
                    </div>
                </div>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</div>