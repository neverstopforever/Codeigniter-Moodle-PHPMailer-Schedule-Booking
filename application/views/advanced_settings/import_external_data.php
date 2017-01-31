<!-- BEGIN PAGE CONTAINER -->
<div class="page-container">
    <!-- BEGIN PAGE HEAD -->


    <!-- BEGIN PAGE CONTENT -->
    <div class="table_loading"></div>
    <div class="page-content">
        <div class="<?php echo $layoutClass ?>">
            <ul class=" page-breadcrumb breadcrumb">
                <li>
                    <a href="<?php echo $_base_url; ?>" ><?php echo $this->lang->line('menu_Home'); ?></a>
                </li>
                <li>
                    <a href="<?php echo $_base_url; ?>advancedSettings"><?php echo $this->lang->line('menu_advanced_settings'); ?></a>
                </li>
                <li class="active">
                    <?php echo $this->lang->line('menu_import_external_data'); ?>
                </li>
            </ul>
            <!-- BEGIN PAGE CONTENT INNER -->
            <div class="portlet light">

                <div class="text-right">
                    <button type="button" id="quick_tips" class="btn btn-xs green-meadow "> <i class="fa fa-lightbulb-o" aria-hidden="true"></i> <span class="button_text"><?php echo $this->lang->line('show_quick_tips'); ?></span> <i class="fa fa-angle-down fa-angledown"></i></button>
                </div>
                <div class="quick_tips_sidebar margin-top-20">
                    <div class=" note note-info quick_tips_content">
                        <h2><?php echo $this->lang->line('quick_box_title'); ?></h2>
                        <p><?php echo $this->lang->line('import_external_data_quick_tips_text'); ?>
                            <strong><a href="<?php echo $this->lang->line('import_external_data_quick_tips_link'); ?>" target="_blank"><?php echo $this->lang->line('import_external_data_quick_tips_link_text'); ?></a></strong>
                        </p>
                    </div>
                </div>

                <div class="mt-element-step">
                    <div class="row step-line">
                        <div class="col-md-4 mt-step-col first active" id="ied_step_1">
                            <div class="mt-step-number bg-white">1</div>
                            <div class="mt-step-title uppercase font-grey-cascade"><?php echo $this->lang->line('setup');?></div>
                            <div class="mt-step-content font-grey-cascade"><?php echo $this->lang->line('advanced_settings_step_title_1');?></div>
                        </div>
                        <div class="col-md-4 mt-step-col" id="ied_step_2">
                            <div class="mt-step-number bg-white">2</div>
                            <div class="mt-step-title uppercase font-grey-cascade"><?php echo $this->lang->line('style');?></div>
                            <div class="mt-step-content font-grey-cascade"><?php echo $this->lang->line('advanced_settings_step_title_2');?></div>
                        </div>
                        <div class="col-md-4 mt-step-col last" id="ied_step_3">
                            <div class="mt-step-number bg-white">3</div>
                            <div class="mt-step-title uppercase font-grey-cascade"><?php echo $this->lang->line('finish');?></div>
                            <div class="mt-step-content font-grey-cascade"><?php echo $this->lang->line('advanced_settings_step_title_3');?></div>
                        </div>
                    </div>
                </div>
                <div class="margin-top-20" id="step_body">

                </div>
            </div>
            <!-- END PAGE CONTENT INNER -->
        </div>
        <!-- BEGIN QUICK SIDEBAR -->
        <!-- END QUICK SIDEBAR -->
    </div>
    <!-- END PAGE CONTENT -->
</div>
<!-- END PAGE CONTAINER -->
