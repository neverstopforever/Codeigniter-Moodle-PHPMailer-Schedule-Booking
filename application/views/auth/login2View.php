<!-- BEGIN : LOGIN PAGE 5-1 -->


<div class="content">
    <div>
         <div class=" login-container bs-reset">
<!--            <div class="table_loading"></div>-->
            <div class="table_loading_login">
                <h3><?php echo $this->lang->line('loading_message'); ?></h3>
                <p><?php echo $this->lang->line('loading_message_second_line'); ?></p>
                <i class="fa fa-spinner fa-pulse fa-3x fa-fw margin-bottom"></i>
            </div>

                <form action="javascript:;" class="login-form" method="post">
                    <h3 class="form-title"><?php echo $this->lang->line('sign_in'); ?></h3>
                    <div class="alert alert-danger display-hide login_msg">
                        <button class="close" data-close="alert"></button>
                        <span id="login_msg_err_msg"><?php echo $this->lang->line('login2_enter_username_password'); ?>.</span>
                    </div>
                    <?php if(!empty($forgot_pass_date_expired)){ ?>
                        <div class="alert alert-danger login_msg">
                            <button class="close" data-close="alert"></button>
                            <span><?php echo $this->lang->line('forgot_pass_date_expired_msg'); ?></span>
                        </div>
                    <?php } ?>
                    <div class="log_pas_inputs">
                        <div class="form-group">
                            <label class="control-label"><?php echo $this->lang->line('username'); ?></label>
                            <input class="form-control form-control-solid placeholder-no-fix form-group" type="text" autocomplete="off" placeholder="<?php echo $this->lang->line('login2_username'); ?>" id="username" name="username" required/>

                        </div>
                        <div class="form-group">
                            <label class="control-label"><?php echo $this->lang->line('password'); ?></label>
                            <input class="form-control form-control-solid placeholder-no-fix form-group" type="password" autocomplete="off" placeholder="<?php echo $this->lang->line('login2_password'); ?>" id="password" name="password" required/> </div>
                    </div>
                    <div class="rem_forg_pass">
                        <button class="btn btn-primary btn-circle pull-left" type="submit"><?php echo $this->lang->line('key_code_sign_in'); ?></button>
                        <a href="javascript:;" id="delete_cookie" class="delete_cookie_link"><?php echo $this->lang->line('login2_by_new_account'); ?></a>
                        <a href="javascript:;" id="forget-password" class="forget-password"><?php echo $this->lang->line('login2_forgot_password'); ?></a>
                    </div>
                </form>
                <!-- BEGIN FORGOT PASSWORD FORM -->
                <form class="forget-form" action="javascript:;" method="post" style="display: none;">
                    <h3 class="font-green"><?php echo $this->lang->line('login2_forgot_password'); ?></h3>
                    <p> <?php echo $this->lang->line('login2_enter_email_for_reset_pwd'); ?>. </p>
                    <div class="form-group">
                        <input class="form-control placeholder-no-fix form-group" id="forgot_password_input" type="text" autocomplete="off" placeholder="<?php echo $this->lang->line('login2_email'); ?>" name="email" user_role="user" /> </div>
                    <div class="form-actions back_save_group  margin-bottom-40">
                        <button type="button" id="back-btn" class="btn-sm btn btn-circle btn-default-back"><?php echo $this->lang->line('login2_back'); ?></button>
                        <button type="submit" id="forgot_password" class="btn btn-sm btn-primary btn-circle uppercase pull-right"><?php echo $this->lang->line('_submit'); ?></button>
                    </div>
                </form>
                <!-- END FORGOT PASSWORD FORM -->

            <div class="clearfix"></div>
            <div class="login-footer">
                <div class="login-copyright text-center">
                     <p><?php echo $this->lang->line('login2_copyright'); ?> &copy; <?php echo $this->lang->line('key_code_softaula_akaud'); ?></p>
                </div>
            </div>
        </div>
    </div>
</div>