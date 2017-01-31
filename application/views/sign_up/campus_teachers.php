
<div class="page-lock">
    <div class="page-logo">
            <a href="<?php echo base_url() ?>"><img src="<?php echo $variables2->logo; ?>" alt="logo" class="logo-default"></a>
    </div>

    <div class="page-body">
        <h3><?php echo $this->lang->line('sign_up_create_passwd'); ?></h3><br>
       <div class="form-group">
           <label><?php echo $this->lang->line('sign_up_user_name'); ?></label>
           <input type="text" name="user_name" class="form-control" value="<?php echo $teacher->user_name; ?>" <?php echo  $teacher->user_name != '' ? 'disabled' : ''; ?> />
           <div class="help-block with-errors user_name_error" style="display: none" ></div>
       </div>
        <div class="form-group">
            <label><?php echo $this->lang->line('sign_up_passwd'); ?></label>
           <input type="password" name="password" class="form-control" />
            <div class="help-block with-errors passwd_error" style="display: none"></div>
       </div>
        <div class="form-group">
            <label><?php echo $this->lang->line('sign_up_conf_passwd'); ?></label>
            <input type="password" name="confirm_password" class="form-control" />
            <div class="help-block with-errors err_confirm_password" style="display: none"></div>
        </div>
        <div class="form-group">
            <button type="button" id="create"  teacher_id="<?php  echo $teacher->id; ?>" class="btn btn-primary"><?php echo $this->lang->line('sign_up_create'); ?></button>
        </div>
    </div>

</div>


<div class="backstretch" style="left: 0px; top: 0px; overflow: hidden; margin: 0px; padding: 0px; height: 329px; width: 1547px; z-index: -999999; position: fixed;"><img src="<?php echo base_url() ?>assets/pages/media/bg/1.jpg" style="position: absolute; margin: 0px; padding: 0px; border: none; width: 1547px; height: 1160.66px; max-height: none; max-width: none; z-index: -999999; left: 0px; top: -415.83px;"></div>