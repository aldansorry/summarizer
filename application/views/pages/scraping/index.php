<h1 class="h3 mb-4 text-gray-800"><?= $title ?></h1>

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Scraping Berita</h6>
            </div>
            <div class="card-body">
                <?php echo form_open('', ['id' => 'form-scraping']); ?>
                <div class="form-group mb-1">
                    <label class="col-form-label ">Source</label>
                    <div class="">
                        <select name="source" class="form-control">
                            <option value="1">Katadata</option>
                            <option value="2">Detik</option>
                            <option value="3">Kompas</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-form-label ">Tanggal</label>

                    <input type="text" class="form-control date-picker"/>
                    <input type="hidden" name="date[from]" class="form-control input-date-from" value="<?php echo date('Y-m-d') ?>">
                    <input type="hidden" name="date[to]" class="form-control input-date-to" value="<?php echo date('Y-m-d') ?>">

                </div>
                <button type="submit" class="btn btn-primary btn-loading"><i class="fa fa-sync-alt fa-spin loading-ico"></i><span> Search</span></button>

                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Scraping Konten</h6>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <button type="button" class="btn btn-success " id="btn-scraping" onclick="do_scraping()">Scraping Konten</button>
                    <button type="button" class="btn btn-danger" id="btn-abort" onclick="abort_scraping()" style="display:none">Abort Scraping</button>
                    <div class="float-right">berita tanpa konten : <span class="badge badge-primary" id="jumlah-berita-no-konten">0</span></div>
                </div>
                <div id="progress-header" class="mb-3" style="display: block">
                    <h4 class="small font-weight-bold ml-1"><span id="progress-title">Loading....</span> <span class="float-right" id="progress-text">Complete!</span></h4>
                    <div class="progress">
                        <div class="progress-bar bg-success" role="progressbar" style="width: 0%" id="progress-bar"></div>
                    </div>
                </div>
                <div class="log" style="overflow-y: scroll;height:100px;">
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-12 mt-3">
        <div class="card">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Berita tidak berkonten</h6>
            </div>
            <div class="card-body">

                <table class="table table-bordered nowrap table-sm table-responsive" id="table-berita-scraped" width="100%" style="width:100%" cellspacing="0">
                </table>
                <div class=""></div>
            </div>
        </div>
    </div>
</div>