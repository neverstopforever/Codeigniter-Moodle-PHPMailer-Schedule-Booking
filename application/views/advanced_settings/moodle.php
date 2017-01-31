<div class="page-container system_settings">
  <div class="table_loading"></div>
  <div class="page-content">
    <div class="<?php echo $layoutClass ?>">
      <ul class= "page-breadcrumb breadcrumb">
        <li> <a href="<?php echo $_base_url; ?>" ><?php echo $this->lang->line('menu_Home'); ?></a> </li>
        <li> <a href="<?php echo $_base_url; ?>advancedSettings"><?php echo $this->lang->line('menu_advanced_settings'); ?></a> </li>
        <li class="active"> <?php echo $this->lang->line('moodle'); ?> </li>
      </ul>
      <div class="portlet light moodle service_not_active service_page">
        <div class="text-right">
          <button type="button" id="quick_tips" class="btn btn-xs green-meadow "> <i class="fa fa-lightbulb-o" aria-hidden="true"></i> <span class="button_text"><?php echo $this->lang->line('show_quick_tips'); ?></span> <i class="fa fa-angle-down fa-angledown"></i></button>
        </div>
        <div class="quick_tips_sidebar margin-top-20">
          <div class=" note note-info quick_tips_content">
            <h2><?php echo $this->lang->line('quick_box_title'); ?></h2>
            <p><?php echo $this->lang->line('moodle_quick_tips_text'); ?>
              <strong><a href="<?php echo $this->lang->line('moodle_quick_tips_link'); ?>" target="_blank"><?php echo $this->lang->line('moodle_quick_tips_link_text'); ?></a></strong>
            </p>
          </div>
        </div>
        <img src="<?php echo $_base_url; ?>app/images/moodle_logo.png" />

        <div class="moodle_text">
          <p> <?php echo $this->lang->line('moodle_service_not_active_text1'); ?> </p>
          <p> <?php echo $this->lang->line('moodle_service_not_active_text2'); ?> </p>
          <?php if($current_plan != '4') { ?>
          <p class="text-danger"> <?php echo $this->lang->line('moodle_service_not_active_text3'); ?> </p>
          <?php } ?>
        </div>
        <div class="control-group ">
          <?php if($current_plan == '4') { ?>
          <input  type="checkbox"   class="bootstrap-switch" name="my-checkbox" data-size="small" />
          <button type="button" class="btn btn-primary btn-sm setup_moodle"><i class="fa fa-cog" aria-hidden="true"></i> <?php echo $this->lang->line('setup'); ?> </button>
          <?php } ?>
        </div>
      </div>
      <div class="portlet light moodle service_setup hidden"> <img src="<?php echo $_base_url; ?>app/images/moodle_logo.png">
        <div class="moodle_text">
          <p><?php echo $this->lang->line('moodle_setup_text'); ?></p>
        </div>
        <div class="col-sm-8 moodle_form">
          <form class="form-horizontal" name="setup_moodle_form" method="post">
            <div class="form-group ">
              <label class="control-label col-md-4"><?php echo $this->lang->line('moodle_server'); ?></label>
              <div class="col-md-8">
                <input type="text" name="server" class="form-control input-sm input-large server" placeholder="" value="<?php echo (isset($configData['rpc_server']) && !empty($configData['rpc_server'])) ? $configData['rpc_server'] :'' ?>">
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-4"><?php echo $this->lang->line('moodle_token'); ?></label>
              <div class="col-md-6">
                <input type="text" name="token" class="form-control input-sm input-large token" placeholder="" value="<?php echo (isset($configData['rpc_token']) && !empty($configData['rpc_token'])) ? $configData['rpc_token'] :'' ?>">
              </div>
              <div class="col-md-2">
                <button  class="btn btn-sm btn-success valid_button" type="button"><?php echo $this->lang->line('moodle_valid'); ?></button>
              </div>
            </div>
            
            <!--                        <div class="form-group">--> 
            <!--                            <label class="control-label col-sm-4">-->
            <?php //echo $this->lang->line('username'); ?>
            <!--</label>--> 
            <!--                            <div class="col-sm-6">--> 
            <!--                                <input type="text" name="username" class="form-control input-sm input-medium" placeholder="" value="-->
            <?php //echo (isset($configData['rpc_user']) && !empty($configData['rpc_user'])) ? $configData['rpc_user'] :'' ?>
            <!--">--> 
            <!--                            </div>--> 
            <!--                        </div>--> 
            <!--                        <div class="form-group">--> 
            <!--                            <label class="control-label col-sm-4">--> 
            <!--                                -->
            <?php //echo $this->lang->line('password'); ?>
            <!--                            </label>--> 
            <!--                            <div class="col-sm-6">--> 
            <!--                                <div class="input-group">--> 
            <!--                                    <input type="password" name="password" class="form-control input-sm input-medium" placeholder="" value="-->
            <?php //echo (isset($configData['rpc_pwd']) && !empty($configData['rpc_pwd'])) ? $configData['rpc_pwd'] :'' ?>
            <!--" >--> 
            <!--                                    <span class="input-group-btn">--> 
            <!--                                        <button id="" class="btn btn-sm btn-success" type="button">-->
            <?php //echo $this->lang->line('moodle_valid'); ?>
            <!--</button>--> 
            <!--                                    </span>--> 
            <!--                                </div>--> 
            <!--                            </div>--> 
            <!--                        </div>-->
            <div >
              <div class="col-md-4"></div>
              <div class="col-md-6 margin-top-40">
                <input type="hidden" name="hidden" value="hidden">
                <input type="hidden" name="id" value="<?php echo (isset($configData['id']) && !empty($configData['id'])) ? $configData['id'] :'' ?>">
                <button type="submit" class="btn btn-primary btn-sm moodle_save"><?php echo $this->lang->line('save'); ?></button>
                <?php 
				if($webservice==true){
					$sty = '';
				}else{
					$sty = 'style="display:none;"';
				}?>
                <samp <?php echo $sty;?> id="manage_btn"><a href="<?php echo $_base_url; ?>advancedSettings/moodle_manage" type="button" class="btn btn-primary btn-sm moodle_manage_button"> <?php echo $this->lang->line('moodle_manage'); ?> </a></samp> </div>
            </div>
          </form>
          <div class="clearfix"></div>
          <button class="btn btn-default  btn-sm back_to_service_active_page margin-top-100" ><?php echo $this->lang->line('back'); ?></button>
        </div>
      </div>
    </div>
  </div>
</div>
