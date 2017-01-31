<!-- BEGIN LOGIN -->
<div class="content">
	<!-- BEGIN LOGIN FORM -->

	<div class="table_loading_login">
		<h3><?php echo $this->lang->line('loading_message'); ?></h3>
		<p><?php echo $this->lang->line('loading_message_second_line'); ?></p>
		<i class="fa fa-spinner fa-pulse fa-3x fa-fw margin-bottom"></i>
	</div>

	<form class="login-form" id="campus_login_form" action="/campus/auth/login2/" method="post">
		<h3 class="form-title"><?php echo $this->lang->line('campus_sign_in'); ?></h3>
		<div class="error_message alert alert-danger display-hide">
			<button class="close" data-close="alert"></button>
			<span><?php echo $this->lang->line('campus_username_password_msg'); ?></span>
		</div>
		<div class="alert alert-danger" id="error_msg" style="<?php echo $forgot_pass_date_expired ? 'display: block': 'display: none'; ?>">
			<?php if(!empty($forgot_pass_date_expired)){ ?>
				<span><?php echo $this->lang->line('forgot_pass_date_expired_msg'); ?></span>
			<?php } ?>
		</div>
		<div class="form-group">
			<!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
			<label class="control-label visible-ie8 visible-ie9"><?php echo $this->lang->line('email'); ?></label>
			<input class="form-control form-control-solid placeholder-no-fix username"  type="text" autocomplete="off" placeholder="<?php echo $this->lang->line('email'); ?>" id="username" name="email" required />
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
		<div class="form-actions overf_hidden">
			<button type="submit" class="btn btn-primary btn-circle uppercase pull-left"><?php echo $this->lang->line('campus_access'); ?></button>
			<a href="javascript:;" id="delete_cookie" class="delete_cookie_link"><?php echo $this->lang->line('login2_by_new_account'); ?></a>
			<a href="javascript:;" id="forget-password" class="forget-password"><?php echo $this->lang->line('campus_forgot_password'); ?> </a>
		</div>
	</form>
	<!-- END LOGIN FORM -->
	<!-- BEGIN FORGOT PASSWORD FORM -->
	<form class="forget-form" action="<?php echo base_url().'campus/user/forget_password'?>" method="post" novalidate="novalidate" style="display: none;">
		<h3 class="font-green"><?php echo $this->lang->line('campus_forgot_password'); ?> </h3>
		<p> <?php echo $this->lang->line('campus_forgot_password_msg'); ?></p>
		<div class="form-group">
			<input class="form-control placeholder-no-fix" id="key_code" type="text" autocomplete="off" user_role="teacher" placeholder="<?php echo $this->lang->line('campus_email'); ?>" name="email"> </div>
		<div class="form-actions back_save_group">
			<button type="button" id="back-btn" class="btn-sm btn btn-circle btn-default-back"><?php echo $this->lang->line('campus_back'); ?></button>
			<button type="submit" id="forgot_password" class="btn btn-sm btn-primary btn-circle uppercase pull-right"><?php echo $this->lang->line('campus_submit'); ?></button>
		</div>
	</form>
	<!-- END FORGOT PASSWORD FORM -->
	<div class="form-group table_loading_group">
		<select class="form-control" id="lang" name="lang">
			<option value="1" <?php echo (empty($lang)||$lang=='english')?'selected':'';?>> <?php echo $this->lang->line('campus_english'); ?></option>
			<option value="2"  <?php echo ($lang=='spanish')?'selected':'';?>><?php echo $this->lang->line('campus_spenish'); ?></option>
		</select>
	</div>
</div>

