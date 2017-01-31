<!DOCTYPE html>
<!--
Template Name: Metronic - Responsive Admin Dashboard Template build with Twitter Bootstrap 3.3.5
Version: 3.3.0
Author: KeenThemes
Website: http://www.keenthemes.com/
Contact: support@keenthemes.com
Follow: www.twitter.com/keenthemes
Like: www.facebook.com/keenthemes
Purchase: http://themeforest.net/item/metronic-responsive-admin-dashboard-template/4021469?ref=keenthemes
License: You must have a valid license purchased only from themeforest(the above link) in order to legally use the theme for your project.
-->
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
<?php $this->load->view("includes/campus/head"); ?>
</head>
<!-- END HEAD -->
<!-- BEGIN BODY -->
<body class="page-md login">
<div class="login_overlay"></div>
<!-- BEGIN SIDEBAR TOGGLER BUTTON -->
<div class="menu-toggler sidebar-toggler">
</div>
<!-- END SIDEBAR TOGGLER BUTTON -->
<!-- BEGIN LOGO -->
<div class="logo">
	<a href="/">
		<img src="<?php echo base_url() ?>/assets/img/hader-logo.png" alt=""/>
	</a>
</div>
<!-- END LOGO -->
<!-- BEGIN LOGIN -->
<div class="content">
	<!-- BEGIN LOGIN FORM -->
	<form class="login-form" id="campus_login_form" action="/campus/auth/login/" method="post">
		<h3 class="form-title"><?php echo $this->lang->line('campus_sign_in'); ?></h3>
		<div class="error_message alert alert-danger display-hide	">
			<button class="close" data-close="alert"></button>
			<span><?php echo $this->lang->line('campus_username_password_msg'); ?></span>
		</div>
		<div class="alert alert-danger" id="error_msg" style="display: none;"></div>
		<div class="form-group">
			<!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
			<label class="control-label visible-ie8 visible-ie9"><?php echo $this->lang->line('campus_username'); ?></label>
			<input class="form-control form-control-solid placeholder-no-fix username" type="text" autocomplete="off" placeholder="<?php echo $this->lang->line('campus_username'); ?>" id="username" name="username" required />
		</div>
		<div class="form-group">
			<label class="control-label visible-ie8 visible-ie9"><?php echo $this->lang->line('campus_password'); ?></label>
			<input class="form-control form-control-solid placeholder-no-fix password" value="epsilonxxc" type="password" autocomplete="off" placeholder="<?php echo $this->lang->line('campus_password'); ?>" id="password" name="password" required />
		</div>
		<div class="form-group">
			<label for="user_role" class="control-label visible-ie8 visible-ie9 uppercase"><?php echo $this->lang->line('campus_user_role'); ?></label>
			<select class="form-control user_role" id="user_role" name="user_role" required >
				<option value="1"><?php echo $this->lang->line('campus_user_role_teacher'); ?></option>
				<option value="2"><?php echo $this->lang->line('campus_user_role_student'); ?></option>
			</select>
		</div>
		<div class="form-actions">
			<button type="submit" class="btn btn-success uppercase"><?php echo $this->lang->line('campus_access'); ?></button>
			<label class="rememberme check">
				<div class="checker"><span><input type="checkbox" name="remember" value="1"></span></div><?php echo $this->lang->line('campus_remember'); ?> </label>
			<a href="javascript:;" id="forget-password" class="forget-password"><?php echo $this->lang->line('campus_forgot_password'); ?> </a>
		</div>
	</form>
	<!-- END LOGIN FORM -->

	<!-- BEGIN FORGOT PASSWORD FORM -->
	<form class="forget-form" action="<?php echo base_url().'campus/user/forget_password'?>" method="post" novalidate="novalidate" style="display: none;">
		<h3 class="font-green"><?php echo $this->lang->line('campus_forgot_password'); ?> </h3>
		<p> <?php echo $this->lang->line('campus_forgot_password_msg'); ?></p>
		<div class="form-group">
			<input class="form-control placeholder-no-fix" type="text" autocomplete="off" placeholder="<?php echo $this->lang->line('campus_email'); ?>" name="email"> </div>
		<div class="form-actions">
			<button type="button" id="back-btn" class="btn btn-default"><?php echo $this->lang->line('campus_back'); ?></button>
			<button type="submit" class="btn btn-success uppercase pull-right"><?php echo $this->lang->line('campus_submit'); ?></button>
		</div>
	</form>
	<!-- END FORGOT PASSWORD FORM -->
	<div class="form-group">
			<select class="form-control" id="lang" name="lang">
				<option value="1" <?php echo (empty($lang)||$lang=='english')?'selected':'';?>>English</option>
				<option value="2"  <?php echo ($lang=='spanish')?'selected':'';?>>Spanish</option>
			</select>
		</div>
</div>

<?php $this->load->view("includes/campus/footer"); ?>
<script>
jQuery(document).ready(function() {     
	Metronic.init(); // init metronic core components
	Layout.init(); // init current layout
	Login.init();
	Demo.init();
	app.campus_auth.login();
	$('#lang').change('on', function(){
		var lang = $(this).val();
		$.ajax({
			url:base_url+'/campus/auth/setLang',
			type:'POST',
			data: {
				'lang':lang
			},
			success:function(data){
				location.reload();
			}
		});
	});
});
</script>
<!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>