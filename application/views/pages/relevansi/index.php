<div class="">
    <a href="<?php echo base_url("Settings") ?>" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm float-right"><i class="fas fa-cogs fa-sm text-white-50"></i> Pengaturan</a>
    <h1 class="h3 mb-4 text-gray-800"><?= $title ?></h1>
</div>

<div class="row">
    <div class="col-md-12 mt-3">
        <div class="card">
            <div class="card-body">
                <div class="mb-3">

                    <button type="button" class="btn btn-success " id="btn-relevansi" onclick="doRelevansi()">Auto Relevansi</button>
                    <button type="button" class="btn btn-danger" id="btn-abort" onclick="abort()" style="display:none">Abort Relevansi</button>
                    <div class="float-right"><span class="badge badge-primary" id="jumlah-berita-unrelevanted">0</span></div>
                </div>
                <div id="progress-header" class="mb-3">
                    <h4 class="small font-weight-bold ml-1"><span id="progress-title">Loading....</span> <span class="float-right" id="progress-text">Complete!</span></h4>
                    <div class="progress">
                        <div class="progress-bar bg-success" role="progressbar" style="width: 0%" id="progress-bar"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12 mt-3">
        <div class="card border-left-primary shadow h-100">

            <div class="card-body">
               
                <table class="table table-bordered table-sm table-hover" id="table-relevansi" width="100%" style="width:100%" cellspacing="0">
                </table>
            </div>
        </div>
    </div>
</div>