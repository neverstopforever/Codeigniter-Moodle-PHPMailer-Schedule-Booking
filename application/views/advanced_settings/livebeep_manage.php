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
            <li >
                <a href="<?php echo $_base_url; ?>advancedSettings/moodle"><?php echo $this->lang->line('livebeep'); ?></a>
            </li>
            <li class="active">
                <?php echo $this->lang->line('livebeep_manage'); ?>
            </li>
            </ul>

            <div class="portlet light livebeep_manage">
                <div  class="no_livebeep_manage_prospects">

                </div>
                <div class="back_livebeep_mobile">
                    <a href="<?php echo $_base_url; ?>advancedSettings/livebeep" class="btn btn-default  btn-sm back_to_service_active_page"> <i class="fa fa-arrow-left margin-right-3" aria-hidden="true"></i> <?php echo $this->lang->line('back'); ?></a>
                </div>
                <div id="livebeep_manage_prospects" class="manage_prospects_table">

                </div>
            </div>

        </div>
    </div>
</div>
