<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en" class="no-js">
<!--<![endif]-->
<head>
    <?php $this->load->view("includes/auth/head"); ?>
</head>
<body class="page-md <?php echo $page; ?>">
<div class="login_overlay"></div>
<!-- BEGIN SIDEBAR TOGGLER BUTTON -->
<div class="menu-toggler sidebar-toggler">
</div>
<!-- END SIDEBAR TOGGLER BUTTON -->
<div class="logo">
    <a href="/">
<!--        --><?php //$site_logo = base_url().'assets/img/logo-akaud.png';
//        if(!empty($variables2->logo)){
//        $site_logo = $variables2->logo;
//        }
//        ?>
        <img src="<?php echo base_url() ?>assets/img/header_logo.png" alt="logo"/>
    </a>
</div>
<!-- END LOGO -->
<!-- Page Content -->
    <?php echo $content_for_layout; ?>
<!-- /.container -->

<!-- Page Footer -->
<?php $this->load->view("includes/auth/footer"); ?>
<!-- Page Footer end-->

</body>
</html>