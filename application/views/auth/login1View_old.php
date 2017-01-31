<!-- BEGIN : LOGIN PAGE 5-1 -->
<div class="user-login-5">
    <div class="row bs-reset">
        <div class="col-md-6 bs-reset">
            <?php
            $login2_picture = base_url().'assets/pages/img/login/bg1.jpg';
            if(!empty($variables2->login2_picture)){
                $login2_picture = $variables2->login2_picture;
            }
            $site_logo = base_url().'assets/img/logo-akaud.png';
            if(!empty($variables2->logo)){
                $site_logo = $variables2->logo;
            }
            ?>
            <script>
                var _login2_picture = "<?php echo $login2_picture;?>";
            </script>
            <div class="login-bg" style="background-image:url(<?php echo $login2_picture; ?>)">
<!--                <img class="login-logo" src="--><?php //echo $site_logo; ?><!--" />-->
            </div>
        </div>

        <div class="col-md-6 login-container bs-reset">
            <div class="table_loading"></div>
            <div class="login-content">
                <h1><?php echo $this->lang->line('key_code_softaula_akaud'); ?></h1>
                <p><?php echo $this->lang->line('key_code_welcome_softaula_akaud'); ?></p>
                <form action="javascript:;" class="login-form key_code_form" method="post">
                    <div class="alert alert-danger key_code_msg" style="display: none;">
                        <button class="close" data-close="alert"></button>
                        <span id="key_code_invalid" style="display: none;"><?php echo $this->lang->line('key_code_invalid'); ?>.</span>
                        <span id="key_code_err_msg" style="display: none;"><?php echo $this->lang->line('key_code_enter'); ?>.</span>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12">
                            <input class="form-control form-control-solid placeholder-no-fix" type="text" autocomplete="off" placeholder="<?php echo $this->lang->line('key_code'); ?>" name="key_code" id="key_code" required/>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12 margin-bottom-20 margin-top-10">
                            <select class="form-control" id="lang" name="lang">
                                <option value="english" <?php echo ($lang=='english')?'selected':'';?>><?php echo $this->lang->line('english'); ?></option>
                                <option value="spanish"  <?php echo (empty($lang) || $lang=='spanish')?'selected':'';?>><?php echo $this->lang->line('spanish'); ?></option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-10"></div>
                        <div class="col-xs-2">
                            <button class="btn blue" type="submit"><?php echo $this->lang->line('key_code_sign_in'); ?></button>
                        </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>