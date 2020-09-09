<h1 class="h3 mb-4 text-gray-800"><?= $title ?></h1>
<div class="row">

  <!-- Earnings (Monthly) Card Example -->
  <div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-primary shadow h-100 py-2">
      <div class="card-body">
        <div class="row no-gutters align-items-center">
          <div class="col mr-2">
            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Berita</div>
            <div class="h5 mb-0 font-weight-bold text-gray-800 counter" id="count-total-berita">0</div>
          </div>
          <div class="col-auto">
            <i class="fas fa-newspaper fa-2x text-gray-300"></i>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Earnings (Monthly) Card Example -->
  <div class="col-xl-3 col-md-6 mb-4" onclick="window.location.href='<?php echo base_url('Scraping') ?>'">
    <div class="card border-left-success shadow h-100 py-2">
      <div class="card-body">
        <div class="row no-gutters align-items-center">
          <div class="col mr-2">
            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Berita Scraped</div>
            <div class="row no-gutters align-items-center">
              <div class="col-auto">
                <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><span class="counter" id="bar-scraped-text">0</span>%</div>
              </div>
              <div class="col">
                <div class="progress progress-sm mr-2">
                  <div class="progress-bar bg-success" role="progressbar" style="width: 0%" id="bar-scraped-bar"></div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-auto">
            <i class="fas fa-cog fa-2x text-gray-300"></i>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Earnings (Monthly) Card Example -->
  <div class="col-xl-3 col-md-6 mb-4" onclick="window.location.href='<?php echo base_url('Featuring') ?>'">
    <div class="card border-left-info shadow h-100 py-2">
      <div class="card-body">
        <div class="row no-gutters align-items-center">
          <div class="col mr-2">
            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Berita Featured</div>
            <div class="row no-gutters align-items-center">
              <div class="col-auto">
                <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><span class="counter" id="bar-featured-text">0</span>%</div>
              </div>
              <div class="col">
                <div class="progress progress-sm mr-2">
                  <div class="progress-bar bg-info" role="progressbar" style="width: 0%" id="bar-featured-bar"></div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-auto">
            <i class="fas fa-calculator fa-2x text-gray-300"></i>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Pending Requests Card Example -->
  <div class="col-xl-3 col-md-6 mb-4" onclick="window.location.href='<?php echo base_url('Relevansi') ?>'">
    <div class="card border-left-warning shadow h-100 py-2">
      <div class="card-body">
        <div class="row no-gutters align-items-center">
          <div class="col mr-2">
            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Berita Relevansi</div>
            <div class="h5 mb-0 font-weight-bold text-gray-800 counter" id="count-relevansi-berita">18</div>
          </div>
          <div class="col-auto">
            <i class="fas fa-balance-scale fa-2x text-gray-300"></i>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="row">

  <!-- Area Chart -->
  <div class="col-xl-8 col-lg-7">
    <div class="card shadow mb-4">
      <!-- Card Header - Dropdown -->
      <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">Berita Bulanan</h6>
        <div class="float-right">
          <input type="number" class="form-control form-control-sm w-25" style="position:absolute;right:0.5rem;top:0.75rem;" max="<?php echo date('Y') ?>" value="<?php echo date('Y') ?>" onchange="get_berita_month(this.value)">
        </div>
      </div>
      <!-- Card Body -->
      <div class="card-body">
        <div class="chart-area">
          <div class="chartjs-size-monitor">
            <div class="chartjs-size-monitor-expand">
              <div class=""></div>
            </div>
            <div class="chartjs-size-monitor-shrink">
              <div class=""></div>
            </div>
          </div>
          <div class="chart-area">
            <canvas id="chart-berita-month"></canvas>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Pie Chart -->
  <div class="col-xl-4 col-lg-5 pb-4">
    <div class="card shadow mb-4 h-100">
      <!-- Card Header - Dropdown -->
      <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">Berita per Sumber</h6>

      </div>
      <!-- Card Body -->
      <div class="card-body">
        <div class="chart-pie pt-4 pb-2">
          <canvas id="chart-berita-sumber" width="382" height="306" class="chartjs-render-monitor" style="display: block; height: 245px; width: 306px;"></canvas>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="row">
<div class="col-lg-12">
    <div class="card shadow mb-4">
      <!-- Card Header - Dropdown -->
      <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">Berita Katadata per kategori</h6>

      </div>
      <!-- Card Body -->
      <div class="card-body">
        <div class="chart-pie pt-4 pb-2">
          <canvas id="chart-berita-katadata" width="382" height="306" class="chartjs-render-monitor" style="display: block; height: 245px; width: 306px;"></canvas>
        </div>
      </div>
    </div>
  </div>
  <div class="col-lg-12">
    <div class="card shadow mb-4">
      <!-- Card Header - Dropdown -->
      <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">Berita Detik per kategori</h6>

      </div>
      <!-- Card Body -->
      <div class="card-body">
        <div class="chart-pie pt-4 pb-2">
          <canvas id="chart-berita-detik" width="382" height="306" class="chartjs-render-monitor" style="display: block; height: 245px; width: 306px;"></canvas>
        </div>
      </div>
    </div>
  </div>
  <div class="col-lg-12">
    <div class="card shadow mb-4">
      <!-- Card Header - Dropdown -->
      <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">Berita Kompas per kategori</h6>

      </div>
      <!-- Card Body -->
      <div class="card-body">
        <div class="chart-pie pt-4 pb-2">
          <canvas id="chart-berita-kompas" width="382" height="306" class="chartjs-render-monitor" style="display: block; height: 245px; width: 306px;"></canvas>
        </div>
      </div>
    </div>
  </div>
</div>