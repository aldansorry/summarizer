<!DOCTYPE html>
<html lang="en">

<?php $this->load->view('includes/head') ?>

<body class="mt-5">

    <div class="container-fluid">

        <!-- 404 Error Text -->
        <div class="text-center">
            <div class="error mx-auto" data-text="<?php echo $error_no ?>"><?php echo $error_no ?></div>
            <p class="lead text-gray-800 mb-5"><?php echo $error_title ?></p>
            <p class="text-gray-500 mb-0"><?php echo $error_description ?></p>
            <a href="<?php echo $error_redirect_url ?>">← <?php echo $error_redirect_text ?></a>
        </div>

    </div>

    <?php $this->load->view('includes/foot') ?>

</body>

</html>