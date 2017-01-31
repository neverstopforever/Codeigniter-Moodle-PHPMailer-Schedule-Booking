<!-- BEGIN : LOGIN PAGE 5-1 user-login-5-->
<div class="content">
    <div>
        <div class="login-container bs-reset">

            <div class="table_loading"></div>
            <div class="login-content">

                <form action="javascript:;" class="login-form login_admin_form" method="post">
                    <h3><?php echo $this->lang->line('admin_softaula_akaud'); ?></h3>
                    <p><?php echo $this->lang->line('admin_welcome_softaula_akaud'); ?></p>
                    <div class="alert alert-danger display-hide login_msg">
                        <button class="close" data-close="alert"></button>
                        <span id="login_msg_err_msg"><?php echo $this->lang->line('admin_enter_username_password'); ?>.</span>
                    </div>
                    <div class="log_pas_inputs">
                        <div class="form-group">
                            <label class="control-label"><?php echo $this->lang->line('username'); ?></label>
                            <input class="form-control form-control-solid placeholder-no-fix form-group" type="text" autocomplete="off" placeholder="<?php echo $this->lang->line('admin_username'); ?>" id="username" name="username" required/>
                        </div>
                        <div class="form-group">
                            <label class="control-label"><?php echo $this->lang->line('password'); ?></label>
                            <input class="form-control form-control-solid placeholder-no-fix form-group" type="password" autocomplete="off" placeholder="<?php echo $this->lang->line('admin_password'); ?>" id="password" name="password" required/>
                        </div>
                    </div>
                    <div class="rem_forg_pass">
                        <button class="btn btn-primary btn-circle" type="submit"><?php echo $this->lang->line('admin_sign_in'); ?></button>
                        <a href="javascript:;" id="forget-password" class="forget-password"><?php echo $this->lang->line('admin_forgot_password'); ?></a>
                    </div>

                </form>
                <!-- BEGIN FORGOT PASSWORD FORM -->
                <form class="forget-form" action="javascript:;" method="post" style="display: none;">
                    <h3 class="font-green"><?php echo $this->lang->line('admin_forgot_password'); ?></h3>
                    <p> <?php echo $this->lang->line('admin_enter_email_for_reset_pwd'); ?>. </p>
                    <div class="form-group">
                        <input class="form-control placeholder-no-fix form-group" type="text" autocomplete="off" placeholder="<?php echo $this->lang->line('admin_email'); ?>" name="email" /> </div>
                    <div class="form-actions back_save_group">
                        <button type="button" id="back-btn" class="btn-sm btn btn-circle btn-default-back"><?php echo $this->lang->line('admin_back'); ?></button>
                        <button type="submit" class="btn btn-sm btn-primary btn-circle uppercase pull-right"><?php echo $this->lang->line('admin_submit'); ?></button>
                    </div>
                </form>
                <!-- END FORGOT PASSWORD FORM -->
            </div>
                <div class="login-footer">
                    <div class="login-copyright text-center">
                        <p><?php echo $this->lang->line('admin_copyright'); ?> &copy; <?php echo $this->lang->line('admin_softaula_akaud'); ?></p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
