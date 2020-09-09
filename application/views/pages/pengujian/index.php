<h1 class="h3 mb-1 text-gray-800"><?= $title ?></h1>
<p class="mb-4">Pengujian dilakukan dengan membandingkan ringkasan oleh pakar</p>

<div class="row mb-3">
    <div class="col-md-12 mt-3">
        <div class="card">
            <div class="card-header">
                <div class="nav nav-tabs card-header-tabs" id="nav-tab" role="tablist">
                    <a class="nav-item nav-link active" id="nav-data-pengujian-tab" data-toggle="tab" href="#nav-data-pengujian" role="tab" aria-controls="nav-data-pengujian" aria-selected="true">Data Pengujian</a>
                    <a class="nav-item nav-link" id="nav-tambah-pengujian-tab" data-toggle="tab" href="#nav-tambah-pengujian" role="tab" aria-controls="nav-tambah-pengujian" aria-selected="false">Tambah Pengujian</a>
                </div>
            </div>


            <div class="card-body">
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="nav-data-pengujian" role="tabpanel" aria-labelledby="nav-data-pengujian-tab">

                        <table class="table table-bordered nowrap table-sm" id="table-pengujian" width="100%" style="width:100%" cellspacing="0">
                        </table>
                    </div>
                    <div class="tab-pane fade" id="nav-tambah-pengujian" role="tabpanel" aria-labelledby="nav-tambah-pengujian-tab">
                        <?php echo form_open('', ['id' => 'form-sample']); ?>
                        <div class="form-group row">
                            <label for="" class="col-form-label col-md-2 ">Jenis Sample</label>
                            <div class="col-md-10">
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" id="jenis-pilih-berita" name="jenis_sample" class="custom-control-input" value="pilih" checked>
                                    <label class="custom-control-label" for="jenis-pilih-berita">Pilih Berita</label>
                                </div>
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" id="jenis-random-berita" name="jenis_sample" class="custom-control-input" value="random">
                                    <label class="custom-control-label" for="jenis-random-berita">Random Berita</label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row" id="container-jenis-pilih-berita">
                            <label for="" class="col-form-label col-md-2 ">Pilih Berita</label>
                            <div class="col-md-10">
                                <div class="border border-primary rounded p-3">
                                    <table class="table table-bordered table-responsive nowrap table-sm" id="table-data-news" width="100%" style="width:100%" cellspacing="0">
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row" id="container-jenis-random-berita" style="display: none">
                            <label for="" class="col-form-label col-md-2 ">Jumlah Berita</label>
                            <div class="col-md-10">
                                <input type="number" name="jumlah_berita" class="form-control" min="2" value="2">
                            </div>
                        </div>

                        <div class="row">
                            <div class="offset-md-2 col-md-10">
                                <button type="submit" class="btn btn-primary">Submit</button>
                                <button type="button" class="btn btn-secondary" onclick="$('#container-tambah-pengujian').slideUp('fast')">Cancel</button>
                            </div>
                        </div>
                        <?php echo form_close(); ?>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<div class="row mb-3" id="container-detail-pengujian" style="display: none;">

    <div class="col-md-12 mt-3">
        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Precision</div>
                                <div class="row no-gutters align-items-center">
                                    <div class="col-auto">
                                        <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800" id="accuracy-precision-text">50%</div>
                                    </div>
                                    <div class="col">
                                        <div class="progress progress-sm mr-2">
                                            <div class="progress-bar bg-info" role="progressbar" style="width: 50%" id="accuracy-precision-bar"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-crop fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Recall</div>
                                <div class="row no-gutters align-items-center">
                                    <div class="col-auto">
                                        <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800" id="accuracy-recall-text">50%</div>
                                    </div>
                                    <div class="col">
                                        <div class="progress progress-sm mr-2">
                                            <div class="progress-bar bg-success" role="progressbar" style="width: 50%" id="accuracy-recall-bar"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-compress fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">F-Measure</div>
                                <div class="row no-gutters align-items-center">
                                    <div class="col-auto">
                                        <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800" id="accuracy-f-measure-text">50%</div>
                                    </div>
                                    <div class="col">
                                        <div class="progress progress-sm mr-2">
                                            <div class="progress-bar bg-primary" role="progressbar" style="width: 50%" id="accuracy-f-measure-bar"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-crosshairs fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <div class="nav nav-tabs card-header-tabs" id="nav-tab" role="tablist">
                    <a class="nav-item nav-link active" id="nav-result-data-tab" data-toggle="tab" href="#nav-result-data" role="tab" aria-controls="nav-result-data" aria-selected="true">Hasil</a>
                    <a class="nav-item nav-link" id="nav-result-bobot-tab" data-toggle="tab" href="#nav-result-bobot" role="tab" aria-controls="nav-result-bobot" aria-selected="false">Bobot</a>
                    <a class="nav-item nav-link" id="nav-result-setting-tab" data-toggle="tab" href="#nav-result-setting" role="tab" aria-controls="nav-result-setting" aria-selected="false">Pengaturan</a>
                </div>
            </div>
            <div class="card-body">

                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="nav-result-data" role="tabpanel" aria-labelledby="nav-result-data-tab">
                        <div class="btn-group btn-group-sm btn-group-toggle float-right btn-chart-toggle" role="group" aria-label="Basic example" data-toggle="buttons" style="z-index: 100;">
                            <label class="btn btn-outline-secondary active" data-toggle="collapse" data-target="#view-table">
                                <input type="radio" name="option_view" id="view_table" autocomplete="off" checked> <span class="fa fa-table"></span>
                            </label>
                            <label class="btn btn-outline-secondary" data-toggle="collapse" data-target="#view-chart">
                                <input type="radio" name="option_view" id="view_chart" autocomplete="off"> <span class="fa fa-chart-bar"></span>
                            </label>
                        </div>
                        <div class="accordion" id="accordion-view">
                            <div class="collapse show" id="view-table" data-parent="#accordion-view">
                                <table class="table table-bordered table-responsive nowrap table-sm" id="table-result" width="100%" style="width:100%" cellspacing="0">
                                </table>
                            </div>
                            <div class="collapse pb-5" id="view-chart" data-parent="#accordion-view">
                                <div class="chart-area">
                                    <canvas id="chart-result"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="nav-result-bobot" role="tabpanel" aria-labelledby="nav-result-bobot-tab">
                        <?php echo form_open("", ['id' => "form-bobot"]) ?>
                        <input type="hidden" name="id_pengujian">
                        <div class="form-group">
                            <label for="">Bobot</label>
                            <div class="row">
                                <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                                    <select name="fk_bobot" class="form-control">
                                        <option value="-1" selected>Custom</option>
                                        <?php foreach ($this->db->get("bobot")->result() as $key => $value) : ?>
                                            <option value="<?php echo $value->id ?>" data-value='<?php echo json_encode($value) ?>'><?php echo $value->nama ?></option>
                                        <?php endforeach ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <?php $bobot_default = $this->db->where('id',getConfig("bobot_default"))->get('bobot')->row(0); ?>
                        <div class="form-group">
                            <label for="">Tingkat Kompresi</label>
                            <div class="row">
                                <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                                    <input type="number" name="kompresi" class="form-control" value="<?php echo $bobot_default->kompresi ?>" step="5" min="5" max="100">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="">Bobot Feature</label>
                            <div class="row px-2">
                                <div class="col-lg-2 col-sm-4 col-6 px-1 pt-0 pt-sm-0 pt-lg-0">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon1">F1</span>
                                        </div>
                                        <input type="number" name="f1" class="form-control" value="<?php echo $bobot_default->f1 ?>" step="0.01">
                                    </div>
                                </div>
                                <div class="col-lg-2 col-sm-4 col-6 px-1 pt-0 pt-sm-0 pt-lg-0">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon1">F2</span>
                                        </div>
                                        <input type="number" name="f2" class="form-control" value="<?php echo $bobot_default->f2 ?>" step="0.01">
                                    </div>
                                </div>
                                <div class="col-lg-2 col-sm-4 col-6 px-1 pt-2 pt-sm-0 pt-lg-0">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon1">F3</span>
                                        </div>
                                        <input type="number" name="f3" class="form-control" value="<?php echo $bobot_default->f3 ?>" step="0.01">
                                    </div>
                                </div>
                                <div class="col-lg-2 col-sm-4 col-6 px-1 pt-2 pt-sm-2 pt-lg-0">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon1">F4</span>
                                        </div>
                                        <input type="number" name="f4" class="form-control" value="<?php echo $bobot_default->f4 ?>" step="0.01">
                                    </div>
                                </div>
                                <div class="col-lg-2 col-sm-4 col-6 px-1 pt-2  pt-sm-2 pt-lg-0">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon1">F5</span>
                                        </div>
                                        <input type="number" name="f5" class="form-control" value="<?php echo $bobot_default->f5 ?>" step="0.01">
                                    </div>
                                </div>
                                <div class="col-lg-2 col-sm-4 col-6 px-1 pt-2  pt-sm-2 pt-lg-0">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon1">F6</span>
                                        </div>
                                        <input type="number" name="f6" class="form-control" value="<?php echo $bobot_default->f6 ?>" step="0.01">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <button type="button" id="btn-reset" class="btn btn-secondary">Reset</button>
                        <?php echo form_close(); ?>
                    </div>
                    <div class="tab-pane fade" id="nav-result-setting" role="tabpanel" aria-labelledby="nav-result-setting-tab">
                        <button type="button" class="btn btn-danger" onclick="doResetPengujian()">Reset Pengujian</button>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<div style="display: none;">
    <?php echo form_open_multipart($cname . '/import_pengujian', ['id' => 'form-import']) ?>
    <input type="hidden" name="id_pengujian" id="import-id-pengujian">
    <input type="file" name="excel" id="input-file" class="dropify">
    <?php echo form_close(); ?>
</div>