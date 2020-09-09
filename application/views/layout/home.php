<!DOCTYPE html>
<html lang="en">

<?php $this->load->view('includes/head') ?>
<style>
    .sidenavR {
        background-color: #fff;
        height: 100%;
        overflow-x: hidden;
        position: fixed;
        right: 0;
        top: 70px;
        transition: .2s;
        width: 0;
        z-index: 1031;
    }

    .filter-container {
        width: 100%;
        margin: 0;
        padding: 0;
        left: 0;
        background-color: #fff;
        position: fixed;
        top: 70px;
        z-index: 1030;
    }
</style>

<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <a class="btn btn-primary" href="<?php echo base_url("Logout") ?>">Logout</a>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-shower" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

        </div>
    </div>
</div>


<body id="page-top">
    <div id="wrapper">


        <div id="content-wrapper" class="d-flex flex-column">

            <div id="content">

                <div class="loading-bar">aa</div>
                <nav class="navbar navbar-expand navbar-light bg-white topbar fixed-top shadow">

                    <div class="container">
                        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?php echo base_url() ?>">
                            <div class="sidebar-brand-icon rotate-n-15">
                                <i class="fas fa-newspaper"></i>
                            </div>
                            <div class="sidebar-brand-text mx-3">Berita <sup>&copy;</sup></div>
                        </a>

                        <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">

                        </form>

                        <ul class="navbar-nav ml-auto">

                            <a class="nav-link d-sm-inline-block d-lg-none text-primary btn-tooglesidebar" href="#" role="button" onclick="toogleSidebar()">
                                <i class="fas fa-bars fa-fw"></i>
                            </a>
                        </ul>
                    </div>

                    <a class="nav-link d-none d-lg-inline-block  btn-tooglesidebar" href="javascript:void(0)" role="button" onclick="toogleSidebar()" style="position: absolute;right:20px">
                        <i class="fas fa-bars fa-fw"></i>
                    </a>

                </nav>
                <div class="preloader">
                    <div class="lds-dual-ring"></div>
                </div>
                <div class="container-fluid mt-4" style="padding-top: 100px;">


                    <?php $this->load->view('pages/' . $page) ?>

                </div>

                <div id="mySidenavR" class="sidenavR border-left shadow">
                    <div class="col-md-12 ">
                        <div class="card mt-3">
                            <div class="card-body">
                                <a href="<?php echo base_url("Login") ?>">Login</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Your Website 2019 SB ADMIN 2</span>
                    </div>
                </div>
            </footer>

        </div>

    </div>

    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>



    <?php $this->load->view('includes/foot') ?>

    <script>
        var sidebarOpen = false


        let clickEvent = function(event) {
            if (!$(event.target).closest('.sidenavR').length) {
                document.getElementById("mySidenavR").style.width = "0";
                sidebarOpen = false;
            }
        };

        function toogleSidebar() {
            if (!sidebarOpen) {
                document.getElementById("mySidenavR").style.width = "250px";
            } else {
                document.getElementById("mySidenavR").style.width = "0";
            }
            sidebarOpen = !sidebarOpen;
        }
    </script>
    <?php $this->load->view('pages/' . $script) ?>
</body>

</html>