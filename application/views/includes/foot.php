<script src="<?= base_url('assets/') ?>vendor/jquery/jquery.min.js"></script>
<script src="<?= base_url('assets/') ?>vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<script src="<?= base_url('assets/') ?>vendor/jquery-easing/jquery.easing.min.js"></script>

<!-- chartjs -->
<script src="<?= base_url('assets/') ?>vendor/chart.js/Chart.min.js"></script>

<script src="<?= base_url('assets/') ?>js/demo/chart-area-demo.js"></script>

<!-- datatables -->
<script src="<?= base_url('assets/') ?>vendor/datatables/jquery.dataTables.min.js"></script>
<script src="<?= base_url('assets/') ?>vendor/datatables/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/select/1.3.1/js/dataTables.select.min.js"></script>
<script src="https://cdn.datatables.net/fixedcolumns/3.3.0/js/dataTables.fixedColumns.min.js"></script>

<!-- sweeetalert2 -->
<script src="<?= base_url('assets/') ?>vendor/sweetalert2/dist/sweetalert2.min.js" rel="stylesheet"></script>

<!-- dropify -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.min.js"></script>

<!-- daterangepicker -->
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

<!-- lazy -->
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery.lazy/1.7.9/jquery.lazy.min.js"></script>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery.lazy/1.7.9/jquery.lazy.plugins.min.js"></script>

<script src="<?= base_url('assets/') ?>js/sb-admin-2.min.js"></script>

<script src="<?= base_url('assets/') ?>js/main.js"></script>

<script>
    $(document).ajaxStart(function() {
        $('.loading-bar').slideDown("fast");
    });

    $(document).ajaxError(function(request, status, error) {
        Swal.fire({
            title: "Error Script",
            message: "",
            icon: "error"
        })
    });

    $(document).ajaxComplete(function(event, request, settings) {
        $('.loading-bar').slideUp("fast");
    });
</script>