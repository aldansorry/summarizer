<h1 class="h3 mb-4 text-gray-800"><?= $title ?></h1>

<div class="row">
    <div class="col-md-12 mt-3">
        <div class="card">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Daftar Pengujian</h6>
            </div>
            <div class="card-body">
                <table class="table table-bordered nowrap table-sm" id="table-pengujian" width="100%" style="width:100%" cellspacing="0">
                </table>
            </div>
        </div>
    </div>
</div>
<div class="row mt-3" id="accuracy-status" style="display: none;">
    <div class="col-md-12">
        <div class=" btn-group-toggle" role="group" data-toggle="buttons" id="navs-bobot">

        </div>
    </div>
    <div class="col-md-12 mt-3">
        <div class="row">
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
        </div>
        <div class="card">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary float-left mt-1" id="bobot-nama"></h6>
                <div class="btn-group btn-group-sm btn-group-toggle float-right" role="group" aria-label="Basic example" data-toggle="buttons">
                    <label class="btn btn-outline-secondary active" data-toggle="collapse" data-target="#view-table">
                        <input type="radio" name="option_view" id="view_table" autocomplete="off" checked> <span class="fa fa-table"></span>
                    </label>
                    <label class="btn btn-outline-secondary" data-toggle="collapse" data-target="#view-chart">
                        <input type="radio" name="option_view" id="view_chart" autocomplete="off"> <span class="fa fa-chart-bar"></span>
                    </label>
                </div>
            </div>
            <div class="card-body">
                <div class="accordion" id="accordion-view">
                    <div class="collapse show" id="view-table" data-parent="#accordion-view">
                        <table class="table table-bordered table-responsive nowrap table-sm" id="table-bobot" width="100%" style="width:100%" cellspacing="0">
                        </table>
                    </div>
                    <div class="collapse" id="view-chart" data-parent="#accordion-view">
                        <div class="chart-area">
                            <canvas id="chart-bobot"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>