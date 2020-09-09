<!-- ##### Featured Post Area Start ##### -->

<div class="filter-container shadow-sm">
    <div class="filter-form">
        <div class="container">
            <h6 class="text-primary mt-1">Filter & Search</h6>
            <div class="form-group row">
                <div class="col-md-12">
                    <div class="input-group input-group-sm">
                        <div class="btn-group btn-group-toggle btn-group-sm btn-filter-sumber" data-toggle="buttons">
                            <label class="btn btn-primary active">
                                <input type="checkbox" name="filter_sumber[]" class="filter-sumber" autocomplete="off" value="1" checked> KataData
                            </label>
                            <label class="btn btn-info active">
                                <input type="checkbox" name="filter_sumber[]" class="filter-sumber" autocomplete="off" value="2" checked> Detik
                            </label>
                            <label class="btn btn-danger active">
                                <input type="checkbox" name="filter_sumber[]" class="filter-sumber" autocomplete="off" value="3" checked> Kompas
                            </label>
                        </div>
                        <div class="input-group-prepend ml-2">
                            <div class="input-group-text">
                                <input type="checkbox" id='filter-check-tanggal' aria-label="Checkbox for following text input">
                            </div>
                        </div>
                        <input type="text" name="daterange" value="<?php echo date("d M Y",strtotime("-2 days")) . " - " . date("d M Y") ?>" class="form-control filter-tanggal" disabled />
                        <input type="text" name="search" placeholder="Search" class="form-control filter-search  ml-2" />
                        <div class="input-group-append ml-2">
                            <button type="button" class="btn btn-primary" onclick="filterSearch()">Submit</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="filter-badge border-top">
        <div class="container" id="container-filter-badge">
        </div>
    </div>
</div>
<div class="container" style="padding-top:60px;">
    <div class="row" id="container-berita">
        
    </div>
    <div class="row" id="berita-loading" style="display: none;">
        <div class="col-md-12 text-center mb-3">
            <div class="spinner-grow" role="status">
                <span class="sr-only">Loading...</span>
            </div>
            <div class="spinner-grow" role="status">
                <span class="sr-only">Loading...</span>
            </div>
            <div class="spinner-grow" role="status">
                <span class="sr-only">Loading...</span>
            </div>
            <div class="spinner-grow" role="status">
                <span class="sr-only">Loading...</span>
            </div>
            <div class="spinner-grow" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
    </div>
</div>
<!-- ##### Featured Post Area End ##### -->