<h1 class="h3 mb-4 text-gray-800"><?= $title ?></h1>
<div class="col-md-12 mt-3">
    <div class="card">
        <div class="card-body">
            <div class="mb-3">
                <button type="button" class="btn btn-success " id="btn-scraping" onclick="do_scraping()">Scraping</button>
                <button type="button" class="btn btn-danger" id="btn-abort" onclick="abort_scraping()" style="display:none">Abort Scraping</button>
            </div>
            <div id="progress-header" class="mb-3" style="display: none">
                <h4 class="small font-weight-bold ml-1"><span id="progress-title">Loading....</span> <span class="float-right" id="progress-text">Complete!</span></h4>
                <div class="progress">
                    <div class="progress-bar bg-success" role="progressbar" style="width: 0%" id="progress-bar"></div>
                </div>
            </div>
            <table class="table table-bordered nowrap table-sm table-responsive" id="table-raw-berita" width="100%" style="width:100%" cellspacing="0">
            </table>


        </div>
    </div>
</div>