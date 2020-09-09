<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion my-header-menu" id="accordionSidebar">
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-newspaper"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Summarizer</div>
    </a>
    <hr class="sidebar-divider my-0">
    <li class="nav-item">
        <a class="nav-link" href="<?= base_url('Dashboard') ?>">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>
    <hr class="sidebar-divider">
    <div class="sidebar-heading">
        Master Data
    </div>
    <?php if (user_allow([1], false)) : ?>
        <li class="nav-item">
            <a class="nav-link" href="<?= base_url('Users') ?>">
                <i class="fas fa-fw fa-users"></i>
                <span>Users</span>
            </a>
        </li>
    <?php endif ?>
    <li class="nav-item">
        <a class="nav-link" href="<?= base_url('Bobot') ?>">
            <i class="fas fa-fw fa-weight"></i>
            <span>Bobot</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="<?= base_url('Berita') ?>">
            <i class="fas fa-fw fa-newspaper"></i>
            <span>Berita</span>
        </a>
    </li>
    <hr class="sidebar-divider">
    <div class="sidebar-heading">
        Sistem
    </div>

    <li class="nav-item">
        <a class="nav-link" href="<?= base_url('Scraping') ?>">
            <i class="fas fa-fw fa-cog"></i>
            <span>Scraping</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="<?= base_url('Featuring') ?>">
            <i class="fas fa-fw fa-calculator"></i>
            <span>Featuring</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="<?= base_url('Relevansi') ?>">
            <i class="fas fa-fw fa-balance-scale"></i>
            <span>Relevansi</span></a>
    </li>

    <?php if (user_allow([1], false)) : ?>
    <hr class="sidebar-divider">
    <div class="sidebar-heading">
        Penelitian
    </div>
    <li class="nav-item">
        <a class="nav-link" href="<?= base_url('Pengujian') ?>">
            <i class="fas fa-fw fa-crosshairs"></i>
            <span>Pengujian</span></a>
    </li>
    <?php endif ?>
</ul>