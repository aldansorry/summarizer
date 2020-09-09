<!DOCTYPE html>
<html lang="en">

<?php $this->load->view('includes/head') ?>

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

        <?php $this->load->view('includes/menu') ?>

        <div id="content-wrapper" class="d-flex flex-column">

            <div id="content">
    
            <div class="loading-bar">aa</div>
                <?php $this->load->view('includes/header') ?>
                <div class="preloader">
                    <div class="lds-dual-ring"></div>
                </div>
                <div class="container-fluid mt-4">


                    <?php $this->load->view('pages/' . $page) ?>
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

    <?php $this->load->view('pages/' . $script) ?>
</body>

</html>