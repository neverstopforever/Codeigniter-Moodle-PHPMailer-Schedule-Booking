        <!-- BEGIN PAGE CONTAINER -->
        <div class="page-container system_settings">

           
            <!-- BEGIN PAGE CONTENT -->
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
                        <?php echo $this->lang->line('user_system_settings'); ?>
                    </li>
                    </ul>
                    <!-- BEGIN PAGE CONTENT INNER -->
                    <div class="portlet light text-center overf_hidden">
                        <div class="text-right">
                            <button type="button" id="quick_tips" class="btn btn-xs green-meadow "> <i class="fa fa-lightbulb-o" aria-hidden="true"></i> <span class="button_text"><?php echo $this->lang->line('show_quick_tips'); ?></span> <i class="fa fa-angle-down fa-angledown"></i></button>
                        </div>
                        <div class="quick_tips_sidebar margin-top-20 margin-bottom-20">
                            <div class=" note note-info text-left quick_tips_content">
                                <h2><?php echo $this->lang->line('quick_box_title'); ?></h2>
                                <p><?php echo $this->lang->line('system_settings_quick_tips_text'); ?>
                                    <strong><a href="<?php echo $this->lang->line('system_settings_quick_tips_link'); ?>" target="_blank"><?php echo $this->lang->line('system_settings_quick_tips_link_text'); ?></a></strong>
                                </p>
                            </div>
                        </div>
                        <div class="tab-pane">
                            <div class="portlet box">
                                <div class="">
                                    <ul class="nav nav-tabs">
<!--                                        <li class="active">-->
<!--                                            <a href="#company_tab" data-toggle="tab" aria-expanded="true">--><?php //echo $this->lang->line('company'); ?><!-- </a>-->
<!--                                        </li>-->
                                        <li class="active">
                                            <a href="#general_tab" data-toggle="tab" aria-expanded="false"> <?php echo $this->lang->line('advanced_settings_general_settings'); ?>  </a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="portlet-body">
                                    <div class="tab-content">
                                        <div class="tab-pane active overf_hidden" id="general_tab" >
                                        
                                        </div>
                                    </div>
                                </div>
                            </div>
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



       <!-- <div class="col-xs-4">
            <form action="/aws_s3/uploadImg/logo" class="logo_login2_picture dropzone dropzone-file-area dz-clickable" data-img_field="logo">
                <div class="dz-default dz-message">
                    <h4 class="sbold"><?php /*echo $this->lang->line('advanced_settings_drop_site_logo'); */?></h4>
                </div>
            </form>
        </div>
        <div class="col-xs-4">
            <form action="/aws_s3/uploadImg/login2_picture" class="logo_login2_picture dropzone dropzone-file-area dz-clickable" data-img_field="login2_picture">
                <div class="dz-default dz-message">
                    <h4 class="sbold"><?php /*echo $this->lang->line('advanced_settings_drop_login2_image'); */?></h4>
                </div>
            </form>
        </div>-->