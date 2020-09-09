<h1 class="h3 mb-4 text-gray-800"><?= $title ?></h1>

<div class="row">
    <div class="col-sm-12 col-md-12 col-lg-8">
        <div class="card">
            <div class="card-body">
                <?php echo form_open($cname.'/update_settings', ['id' => 'form-scraping']); ?>
                <div class="form-group mb-1">
                    <label class="col-form-label ">Bobot Default</label>
                    <div class="">
                        <select name="bobot_default" id="" class="form-control">
                            <?php foreach($this->db->get('bobot')->result() as $key => $value): ?>
                                <option value="<?php echo $value->id ?>" <?php echo getConfig("bobot_default") == $value->id ? "selected" : "" ?>><?php echo $value->nama ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                </div>

                <hr>
                <div class="form-group mb-1">
                    <label class="col-form-label ">Threshold</label>
                    <div class="">
                        <input type="number" name="relevansi_kompresi" min="0.01" max="1" step="0.01" class="form-control" value="<?php echo getConfig("relevansi_kompresi") ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-form-label ">Selisih Perbandingan *hari</label>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="input-group">
                                <input type="text" disabled class="form-control" value="Sebelum">
                                <input type="number" min="1" name="relevansi_selisih_sebelum" class="form-control" value="<?php echo getConfig("relevansi_selisih_sebelum") ?>">
                            </div>
                        </div>
                        <div class="col-md-6 mt-1 mt-md-0">
                            <div class="input-group">
                                <input type="text" disabled class="form-control" value="Sesudah">
                                <input type="number" min="1" name="relevansi_selisih_sesudah" class="form-control" value="<?php echo getConfig("relevansi_selisih_sesudah") ?>">
                            </div>
                        </div>
                    </div>

                </div>
                <button type="submit" class="btn btn-primary btn-loading"><i class="fa fa-sync-alt fa-spin loading-ico"></i><span> Edit Pengaturan</span></button>

                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</div>