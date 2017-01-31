<!-- BEGIN : LOGIN PAGE 5-1 -->
<div class="user-login-5">
    <div class="row bs-reset">
        <div class="col-md-6 bs-reset">
            <div class="login-bg" style="background-image:url(<?php echo base_url() ?>assets/pages/img/login/bg1.jpg)">
<!--                <img class="login-logo" src="--><?php //echo base_url() ?><!--assets/pages/img/login/logo.png" /> </div>-->
            </div>
        </div>
        <div class="col-md-6 login-container bs-reset">
            <div class="table_loading"></div>
            <div class="login-content">
                <h1><?php echo $this->lang->line('admin_softaula_akaud'); ?></h1>
                <p><?php echo $this->lang->line('admin_welcome_softaula_akaud'); ?></p>
                <form action="javascript:;" class="login-form login_admin_form" method="post">
                    <div class="alert alert-danger display-hide login_msg">
                        <button class="close" data-close="alert"></button>
                        <span id="login_msg_err_msg"><?php echo $this->lang->line('admin_enter_username_password'); ?>.</span>
                    </div>
                    <div class="row">
                        <div class="col-xs-6">
                            <input class="form-control form-control-solid placeholder-no-fix form-group" type="text" autocomplete="off" placeholder="<?php echo $this->lang->line('admin_username'); ?>" id="username" name="username" required/> </div>
                        <div class="col-xs-6">
                            <input class="form-control form-control-solid placeholder-no-fix form-group" type="password" autocomplete="off" placeholder="<?php echo $this->lang->line('admin_password'); ?>" id="password" name="password" required/> </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="rem-password">
                                <p><?php echo $this->lang->line('admin_remember_me'); ?>
                                    <input type="checkbox" class="rem-checkbox" />
                                </p>
                            </div>
                        </div>
                        <div class="col-sm-8 text-right">
                            <div class="forgot-password">
                                <a href="javascript:;" id="forget-password" class="forget-password"><?php echo $this->lang->line('admin_forgot_password'); ?></a>
                            </div>
                            <button class="btn blue" type="submit"><?php echo $this->lang->line('admin_sign_in'); ?></button>
                        </div>
                    </div>
                </form>
                <!-- BEGIN FORGOT PASSWORD FORM -->
                <form class="forget-form" action="javascript:;" method="post">
                    <h3 class="font-green"><?php echo $this->lang->line('admin_forgot_password'); ?></h3>
                    <p> <?php echo $this->lang->line('admin_enter_email_for_reset_pwd'); ?>. </p>
                    <div class="form-group">
                        <input class="form-control placeholder-no-fix form-group" type="text" autocomplete="off" placeholder="<?php echo $this->lang->line('admin_email'); ?>" name="email" /> </div>
                    <div class="form-actions">
                        <button type="button" id="back-btn" class="btn grey btn-default"><?php echo $this->lang->line('admin_back'); ?></button>
                        <button type="submit" class="btn blue btn-success uppercase pull-right"><?php echo $this->lang->line('admin_back'); ?></button>
                    </div>
                </form>
                <!-- END FORGOT PASSWORD FORM -->
            </div>
            <div class="login-footer">
                <div class="row bs-reset">
                    <div class="col-xs-5 bs-reset">
                        <ul class="login-social">
                            <li>
                                <a href="javascript:;">
                                    <i class="icon-social-facebook"></i>
                                </a>
                            </li>
                            <li>
                                <a href="javascript:;">
                                    <i class="icon-social-twitter"></i>
                                </a>
                            </li>
                            <li>
                                <a href="javascript:;">
                                    <i class="icon-social-dribbble"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-xs-7 bs-reset">
                        <div class="login-copyright text-right">
                            <p><?php echo $this->lang->line('admin_copyright'); ?> &copy; <?php echo $this->lang->line('admin_softaula_akaud'); ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>