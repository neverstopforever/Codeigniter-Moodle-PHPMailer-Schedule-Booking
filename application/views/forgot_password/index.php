
<div class="content change_pass">
	<!-- BEGIN LOGIN FORM -->

	<div class="table_loading_login">
		<h3><?php echo $this->lang->line('loading_message'); ?></h3>
		<p><?php echo $this->lang->line('loading_message_second_line'); ?></p>
		<i class="fa fa-spinner fa-pulse fa-3x fa-fw margin-bottom"></i>
	</div>
	<h3><?php echo $this->lang->line('forget_pass_create_new_password'); ?></h3><br>
	<div class="form-group">
		<label><?php echo $this->lang->line('password'); ?></label>
		<input type="password" name="password" class="form-control" />
		<div class="help-block with-errors passwd_error" style="display: none"></div>
	</div>
	<div class="form-group">
		<label><?php echo $this->lang->line('forget_pass_confirm_password'); ?></label>
		<input type="password" name="comfirm_password" class="form-control" />
		<div class="help-block with-errors err_confirm_password" style="display: none"></div>
	</div>
	<div class="form-group text-right">
		<button type="button" id="create_password"   class="btn btn-sm btn-primary btn-circle"><?php echo $this->lang->line('forget_pass_creat'); ?></button>
	</div>


</div>



