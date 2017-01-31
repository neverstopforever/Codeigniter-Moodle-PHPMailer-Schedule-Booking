<!-- BEGIN : LOGIN PAGE 5-1 -->
<div class=" content">

                <h1><?php echo $this->lang->line('key_code_softaula_akaud'); ?></h1>
                <p><?php echo $this->lang->line('key_code_welcome_softaula_akaud'); ?></p>
                <form action="javascript:;" class="login-form key_code_form" method="post">
                    <div class="alert alert-danger key_code_msg" style="<?php echo $forgot_pass_date_expired ? 'display: block': 'display: none'; ?>">
                        <button class="close" data-close="alert"></button>
                        <span id="key_code_invalid" style="display: none;"><?php echo $this->lang->line('key_code_invalid'); ?>.</span>
                        <span id="key_code_err_msg" style="display: none;"><?php echo $this->lang->line('key_code_enter'); ?>.</span>
                        <?php if(!empty($forgot_pass_date_expired)){ ?>
                            <span><?php echo $this->lang->line('forgot_pass_date_expired_msg'); ?></span>
                        <?php } ?>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            <input class="form-control form-control-solid placeholder-no-fix" type="text" autocomplete="off" placeholder="<?php echo $this->lang->line('key_code'); ?>" name="key_code" id="key_code" required/>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            <button class="btn btn-sm btn-primary btn-circle" type="submit"><?php echo $this->lang->line('key_code_sign_in'); ?></button>
                        </div>
                    </div>
                    <div class="form-group margin-top-20 circle_select_div">
                        <select class="form-control" id="lang" name="lang">
                            <option value="english" <?php echo ($lang=='english')?'selected':'';?>><?php echo $this->lang->line('english'); ?></option>
                            <option value="spanish"  <?php echo (empty($lang) || $lang=='spanish')?'selected':'';?>><?php echo $this->lang->line('spanish'); ?></option>
                        </select>
                    </div>

                </form>

    </div>