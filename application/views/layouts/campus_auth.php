<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en" class="no-js">
<!--<![endif]-->
<head>
    <?php $this->load->view("includes/campus/head"); ?>
<!--    --><?php //$this->load->view('layouts/partials/header'); ?>
</head>
<body class="page-md login <?php echo $page; ?>">
<div class="login_overlay"></div>
<!-- BEGIN SIDEBAR TOGGLER BUTTON -->
<div class="menu-toggler sidebar-toggler">
</div>
<!-- END SIDEBAR TOGGLER BUTTON -->
<!-- BEGIN LOGO -->
<div class="logo">
    <a href="/">
        <img src="<?php echo base_url() ?>assets/img/header_logo.png" alt="logo"/>
    </a>
</div>
<!-- END LOGO -->
<!-- Page Content -->
    <?php echo $content_for_layout; ?>
<!-- /.container -->
<div class="scroll-to-top"><i class="icon-arrow-up"></i></div>
<!-- Page Footer -->
<?php $this->load->view("includes/campus/auth/footer"); ?>
<!-- Page Footer end-->
<?php //$this->load->view('layouts/partials/footer'); ?>
</body>
</html>