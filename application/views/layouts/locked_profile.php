<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en" class="no-js">
<!--<![endif]-->
<head>
    <?php $this->load->view("includes/locked_profile/head"); ?>
<!--    --><?php //$this->load->view('layouts/partials/header'); ?>
</head>
<body class="page-md <?php echo $page; ?> locked_profile_page">
<?php $this->load->view("includes/locked_profile/header1"); ?>
<!-- Page Content -->
    <?php echo $content_for_layout; ?>
<!-- /.container -->
<!--<div class="scroll-to-top"><i class="icon-arrow-up"></i></div>-->
<!-- Page Footer -->
<?php $this->load->view("includes/locked_profile/footer"); ?>
<!-- Page Footer end-->
<?php //$this->load->view('layouts/partials/footer'); ?>
</body>
</html>