<h1 class="h3 mb-2 text-gray-800"><?= $title ?></h1>

<div class="row">
    <div class="col-md-12 mt-3">
        <div class="card">
            <div class="card-body">
                <div class="mb-3">
                    <button type="button" class="btn btn-success " id="btn-featuring" onclick="do_featuring()">Auto featuring</button>
                    <button type="button" class="btn btn-danger" id="btn-abort" onclick="abort_featuring()" style="display:none">Abort featuring</button>
                    <div class="float-right">berita tanpa feature : <span class="badge badge-primary" id="jumlah-berita-no-feature">0</span></div>
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

            <div class="card-body container-table-detail" style="display: none">
                <div class="row mb-3">
                    <div class="col-2">
                        <a href="javascript:void(0)" onclick="prev()" class="btn btn-primary btn-block btn-prev" style="display: none">Previous</a>
                    </div>
                    <div class="col-8 text-center">

                        <a href="javascript:void(0)" onclick="open_daftar()" class="btn btn-link berita-judul">Daftar Berita</a><span>(Buka Daftar)</span>
                    </div>
                    <div class="col-2">
                        <a href="javascript:void(0)" onclick="next()" class="btn btn-primary btn-block float-right btn-next" style="display: none">Next</a>
                    </div>
                </div>
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="feature-table" data-toggle="tab" href="#feature" role="tab" aria-controls="feature" aria-selected="true">Feature</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="konten-tab" data-toggle="tab" href="#konten" role="tab" aria-controls="konten" aria-selected="false">Konten</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="preprocessing-tab" data-toggle="tab" href="#preprocessing" role="tab" aria-controls="preprocessing" aria-selected="false">Preprocessing</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="tfidf-tab" data-toggle="tab" href="#tfidf" role="tab" aria-controls="tfidf" aria-selected="false">TF IDF</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="f1-tab" data-toggle="tab" href="#f1" role="tab" aria-controls="f1" aria-selected="false">f1</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="f2-tab" data-toggle="tab" href="#f2" role="tab" aria-controls="f2" aria-selected="false">f2</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="f3-tab" data-toggle="tab" href="#f3" role="tab" aria-controls="f3" aria-selected="false">f3</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="f4-tab" data-toggle="tab" href="#f4" role="tab" aria-controls="f4" aria-selected="false">f4</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="f5-tab" data-toggle="tab" href="#f5" role="tab" aria-controls="f5" aria-selected="false">f5</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="f6-tab" data-toggle="tab" href="#f6" role="tab" aria-controls="f6" aria-selected="false">f6</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="pembobotan-tab" data-toggle="tab" href="#pembobotan" role="tab" aria-controls="pembobotan" aria-selected="false">pembobotan</a>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active pt-3" id="feature" role="tabpanel" aria-labelledby="feature-table">
                        <table class="table table-bordered nowrap table-sm table-striped" id="table-detail" cellspacing="0">
                        </table>
                    </div>
                    <div class="tab-pane fade pt-3" id="konten" role="tabpanel" aria-labelledby="konten-tab">...</div>
                    <div class="tab-pane fade pt-3" id="preprocessing" role="tabpanel" aria-labelledby="preprocessing-tab">
                        <button type="button" class="btn btn-primary btn-toogle-table-preprocessing" data-column="1">Plain</button>
                        <button type="button" class="btn btn-primary btn-toogle-table-preprocessing" data-column="2">Lower</button>
                        <button type="button" class="btn btn-primary btn-toogle-table-preprocessing" data-column="3">Filtered</button>
                        <button type="button" class="btn btn-primary btn-toogle-table-preprocessing" data-column="4">Stem</button>
                        <button type="button" class="btn btn-primary btn-toogle-table-preprocessing" data-column="5">Tokenizing</button>
                        <button type="button" class="btn btn-primary btn-toogle-table-preprocessing" data-column="6">Stopword</button>
                        <table class="table table-bordered nowrap table-sm table-striped" id="table-preprocessing" cellspacing="0"></table>
                    </div>
                    <div class="tab-pane fade pt-3" id="tfidf" role="tabpanel" aria-labelledby="tfidf-tab">
                        <h3>TF</h3>
                        <table class="table table-bordered nowrap table-sm table-striped" id="table-tf" cellspacing="0">
                        </table>
                        <h3>TF - IDF</h3>
                        <table class="table table-bordered nowrap table-sm table-striped mt-3" id="table-tfidf" cellspacing="0">
                        </table>
                    </div>
                    <div class="tab-pane fade pt-3" id="f1" role="tabpanel" aria-labelledby="f1-tab">
                    </div>
                    <div class="tab-pane fade pt-3" id="f2" role="tabpanel" aria-labelledby="f2-tab">...</div>
                    <div class="tab-pane fade pt-3" id="f3" role="tabpanel" aria-labelledby="f3-tab">...</div>
                    <div class="tab-pane fade pt-3" id="f4" role="tabpanel" aria-labelledby="f4-tab">...</div>
                    <div class="tab-pane fade pt-3" id="f5" role="tabpanel" aria-labelledby="f5-tab">...</div>
                    <div class="tab-pane fade pt-3" id="f6" role="tabpanel" aria-labelledby="f6-tab">...</div>
                    <div class="tab-pane fade pt-3" id="pembobotan" role="tabpanel" aria-labelledby="pembobotan-tab">
                        <div class="form-group">
                            <label for="">Bobot</label>
                            <select name="" id="select-pembobotan" class="form-control" onchange="change_pembobotan(this)">
                                <option value="-1" disabled selected>Choose Bobot</option>
                                <?php foreach ($bobot as $key => $value) : ?>
                                    <option value="<?php echo $value->id ?>"><?php echo $value->nama ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                        <table class="table table-bordered nowrap table-sm table-striped" id="table-pembobotan" cellspacing="0">
                        </table>
                        <div id="ringkasan-kalimat"></div>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-12">
                        <h4>Keterangan</h4>
                        <ul class="list-group">
                            <li class="list-group-item"><span>F1</span> - Kesamaan kata antar kalimat</li>
                            <li class="list-group-item"><span>F2</span> - Kesamaan kata dengan judul</li>
                            <li class="list-group-item"><span>F3</span> - Huruf Kapital</li>
                            <li class="list-group-item"><span>F4</span> - Kalimat Kutipan</li>
                            <li class="list-group-item"><span>F5</span> - Penggunaan Angka</li>
                            <li class="list-group-item"><span>F6</span> - Panjang Kalimat</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="card-body container-table-berita">
                <code>*Tekan berita jika ingin melihat detail featuring</code>
                <table class="table table-bordered table-sm table-hover" id="table-berita" width="100%" style="width:100%" cellspacing="0">
                </table>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12 mt-3">
        <div class="card">

        </div>
    </div>
</div>