<div class="page-container system_settings">
    <div class="table_loading"></div>
    <div class="page-content">
        <div class="<?php echo $layoutClass ?>">
            <ul class= "page-breadcrumb breadcrumb">
                <li>
                    <a href="<?php echo $_base_url; ?>" ><?php echo $this->lang->line('menu_Home'); ?></a>
                </li>
                <li>
                    <a href="<?php echo $_base_url; ?>advancedSettings"><?php echo $this->lang->line('menu_advanced_settings'); ?></a>
                </li>
                <li class="active">
                    <?php echo $this->lang->line('livebeep'); ?>
                </li>
            </ul>

            <div class="portlet light livebeep service_not_active service_page">

                <div class="text-right">
                    <button type="button" id="quick_tips" class="btn btn-xs green-meadow "> <i class="fa fa-lightbulb-o" aria-hidden="true"></i> <span class="button_text"><?php echo $this->lang->line('show_quick_tips'); ?></span> <i class="fa fa-angle-down fa-angledown"></i></button>
                </div>
                <div class="quick_tips_sidebar margin-top-20">
                    <div class=" note note-info quick_tips_content">
                        <h2><?php echo $this->lang->line('quick_box_title'); ?></h2>
                        <p><?php echo $this->lang->line('livebeep_quick_tips_text'); ?>
                            <strong><a href="<?php echo $this->lang->line('livebeep_quick_tips_link'); ?>" target="_blank"><?php echo $this->lang->line('livebeep_quick_tips_link_text'); ?></a></strong>
                        </p>
                    </div>
                </div>

                <img src="<?php echo $_base_url; ?>app/images/livebeep_logo.png">
                <div class="livebeep_text">
                    <p>
                        <?php echo $this->lang->line('livebeep_text1'); ?>
                    </p>
                    <p>
                        <?php echo $this->lang->line('livebeep_text2'); ?>
                    </p>
                    <p>
                        <?php echo $this->lang->line('livebeep_text3'); ?>
                    </p>
                    <p>
                        <?php echo $this->lang->line('livebeep_text4'); ?>
                    </p>
                    <div class="control-group ">
                        <input  type="checkbox"   class="make-switch checkbox_switch" name="my-checkbox" data-on-color="success" data-size="small" />
                        <button type="button" class="btn btn-primary btn-sm setup_livebeep"><i class="fa fa-cog" aria-hidden="true"></i> <?php echo $this->lang->line('setup'); ?> </button>
                    </div>
                    <p class="margin-top-20 "><?php echo $this->lang->line('livebeep_have_not_account').'  '; ?>  <a href="http://www.livebeep.com/es/signup/?saAKP67HJmms" target="_blank"><?php echo $this->lang->line('livebeep_click_here'); ?></a></p>

                </div>
                
            </div>
            <div class="portlet light livebeep service_setup hidden">
                <img src="<?php echo $_base_url; ?>app/images/livebeep_logo.png">
                <div class="livebeep_text">
                    <p><?php echo $this->lang->line('livebeep_service_setup_text1'); ?></p>
                </div>
                <div class="col-sm-6 livebeep_form">
                    <form class="form" name="setup_livebeep_form">
                        <div class="form-group ">
                            <label><?php echo $this->lang->line('livebeep_domain'); ?></label>
                            <input type="text" name="username" class="form-control input-sm input-medium" placeholder="" value="<?php echo isset($e_goi->login) ? $e_goi->login : ''; ?>">
                        </div>
                        <div class="form-group">
                            <label><?php echo $this->lang->line('livebeep_service_setup_clave_key'); ?></label>
                            <div class="input-group">
                                <input type="text" name="api_key" class="form-control input-sm " placeholder="" value="" >
                                <span class="input-group-btn">
                                    <button id="" class="btn btn-sm btn-success" type="button"><?php echo $this->lang->line('livebeep_valid'); ?></button>
                                </span>
                            </div>
                        </div>
                        <div class="margin-top-20">
                            <button type="submit" class="btn btn-primary btn-sm"><?php echo $this->lang->line('save'); ?></button>
                            <a href="<?php echo $_base_url; ?>advancedSettings/livebeep_manage" type="button" class="btn btn-primary btn-sm livebeep_manage_button"> <?php echo $this->lang->line('livebeep_manage'); ?> </a>
                        </div>
                    </form>
                    <p class="margin-top-20"><?php echo $this->lang->line('livebeep_have_not_account').'  '; ?>  <a href="http://www.livebeep.com/es/signup/?saAKP67HJmms" target="_blank"><?php echo $this->lang->line('livebeep_click_here'); ?></a></p>
                    <hr>
                    <button class="btn btn-default margin-top-10 back_to_service_active_page" ><?php echo $this->lang->line('back'); ?></button>
                </div>

            </div>

        </div>
    </div>
</div>
