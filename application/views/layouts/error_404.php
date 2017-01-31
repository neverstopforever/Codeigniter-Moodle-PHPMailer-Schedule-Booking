<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en" class="no-js">
<!--<![endif]-->
<head>
    <?php $this->load->view("includes/error_404/head"); ?>
<!--    --><?php //$this->load->view('layouts/partials/header'); ?>
</head>
<body class=" page-404-3 <?php echo $page; ?>">
<!-- Page Content -->
    <?php echo $content_for_layout; ?>
<!-- /.container -->
<!-- Page Footer -->
<?php $this->load->view("includes/error_404/footer"); ?>
<!-- Page Footer end-->
<?php //$this->load->view('layouts/partials/footer'); ?>
</body>
</html>