        <!-- BEGIN PAGE CONTAINER -->
        <div class="page-container">


            <!-- BEGIN PAGE CONTENT -->
            <div class="table_loading"></div>
            <div class="page-content">
                <div class="<?php echo $layoutClass ?>">
                    <ul class="page-breadcrumb breadcrumb">
                        <li>
                            <a href="<?php echo $_base_url; ?>" ><?php echo $this->lang->line('menu_Home'); ?></a>
                        </li>
                        <li class="active">
                            <?php echo $this->lang->line('menu_advanced_settings'); ?>
                        </li>
                    </ul>
                    <!-- BEGIN PAGE CONTENT INNER -->
                    <div class="portlet light">
                        <div class="text-right">
                            <button type="button" id="quick_tips" class="btn btn-xs green-meadow "> <i class="fa fa-lightbulb-o" aria-hidden="true"></i> <span class="button_text"><?php echo $this->lang->line('show_quick_tips'); ?></span> <i class="fa fa-angle-down fa-angledown"></i></button>
                        </div>
                        <div class="quick_tips_sidebar margin-top-20 margin-bottom-20">
                            <div class=" note note-info text-left quick_tips_content">
                                <h2><?php echo $this->lang->line('quick_box_title'); ?></h2>
                                <p><?php echo $this->lang->line('advanced_settings_quick_tips_text'); ?>
                                    <strong><a href="<?php echo $this->lang->line('advanced_settings_quick_tips_link'); ?>" target="_blank"><?php echo $this->lang->line('advanced_settings_quick_tips_link_text'); ?></a></strong>
                                </p>
                            </div>
                        </div>
                        <h2><?php echo $this->lang->line('user_advanced_settings'); ?></h2>
                        <div class="row margin-bottom-40">
                                <!-- BEGIN INLINE NOTIFICATIONS PORTLET-->
                                    <div class="col-sm-6  col-md-4">
                                        <div class="advanced_settings_item for_list_border_colors">
                                            <a href="<?php echo base_url(); ?>subscription-plans">
                                                <i class="icon-monthly"></i>
                                                <h3><?php echo $this->lang->line('user_subscription_plans'); ?></h3>
                                                <p class="desc_text"><?php echo $this->lang->line('user_subscription_plans_desc'); ?></p>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col-sm-6  col-md-4">
                                        <div class="advanced_settings_item for_list_border_colors">
                                            <a href="<?php echo base_url(); ?>advancedSettings/billing_information">
                                                <i class="icon-billing"></i>
                                                <h3><?php echo $this->lang->line('user_billing_information'); ?></h3>
                                                <p class="desc_text"><?php echo $this->lang->line('user_billing_information_desc'); ?></p>
                                            </a>
                                        </div>
                                    </div>

                                    <div class=" col-sm-6  col-md-4">
                                        <div class="advanced_settings_item for_list_border_colors">
                                            <a href="<?php echo base_url(); ?>advancedSettings/users_list">
                                                <i class="icon-myusers "></i>
                                                <h3><?php echo $this->lang->line('user_users'); ?></h3>
                                                <p class="desc_text"><?php echo $this->lang->line('user_users_desc'); ?></p>
                                            </a>
                                        </div>
                                    </div>
                                <!-- END INLINE NOTIFICATIONS PORTLET-->



                            <!-- BEGIN INLINE NOTIFICATIONS PORTLET-->
                            <div class="col-sm-6  col-md-4">
                                <div class="advanced_settings_item for_list_border_colors">
                                    <a href="<?php echo base_url(); ?>advancedSettings/system_settings">
                                        <i class="icon-system"></i>
                                        <h3><?php echo $this->lang->line('user_system_settings'); ?></h3>
                                        <p class="desc_text"><?php echo $this->lang->line('user_system_settings_desc'); ?></p>
                                    </a>
                                </div>
                            </div>
                            <div class="col-sm-6  col-md-4">
                                <div class="advanced_settings_item for_list_border_colors">
                                    <a href="<?php echo base_url(); ?>advancedSettings/email_settings">
                                        <i class="icon-email "></i>
                                        <h3><?php echo $this->lang->line('user_email_settings'); ?></h3>
                                        <p class="desc_text"><?php echo $this->lang->line('user_configure_your_account'); ?></p>
                                    </a>
                                </div>
                            </div>

                            <div class="col-sm-6  col-md-4">
                                <div class="advanced_settings_item for_list_border_colors">
                                    <a href="<?php echo base_url('automatedEmails'); ?>">
                                        <i class="icon-email-integration "></i>
                                        <h3><?php echo $this->lang->line('menu_automated_emails'); ?></h3>
                                        <p class="desc_text"><?php echo $this->lang->line('menu_automated_emails'); ?></p>
                                    </a>
                                </div>
                            </div>

                            <div class="col-sm-6  col-md-4">
                                <div class="advanced_settings_item for_list_border_colors">
                                    <a href="<?php echo base_url(); ?>formOnline">
                                        <i class="icon-system"></i>
                                        <h3><?php echo $this->lang->line('webforms'); ?></h3>
                                        <p class="desc_text"><?php echo $this->lang->line('advanced_settings_webforms_desc'); ?>.</p>
                                    </a>
                                </div>
                            </div>

<!--                            new-->

<!--                            <div class="col-sm-6  col-md-4">-->
<!--                                <div class="advanced_settings_item for_list_border_colors">-->
<!--                                    <a href="--><?php //echo base_url(); ?><!--templates">-->
<!--                                        <i class="icon-email"></i>-->
<!--                                        <h3>--><?php //echo $this->lang->line('menu_email_templates'); ?><!--</h3>-->
<!--                                        <p class="desc_text">--><?php //echo $this->lang->line('advanced_settings_email_templates_desc'); ?><!--.</p>-->
<!--                                    </a>-->
<!--                                </div>-->
<!--                            </div>-->

<!--                            <div class="col-sm-6  col-md-4">-->
<!--                                <div class="advanced_settings_item for_list_border_colors">-->
<!--                                    <a href="--><?php //echo base_url(); ?><!--blog/list">-->
<!--                                        <i class="icon-system"></i>-->
<!--                                        <h3>--><?php //echo $this->lang->line('menu_blog'); ?><!--</h3>-->
<!--                                        <p class="desc_text">--><?php //echo $this->lang->line('advanced_settings_blog_desc'); ?><!--.</p>-->
<!--                                    </a>-->
<!--                                </div>-->
<!--                            </div>-->

                            <div class="col-sm-6  col-md-4">
                                <div class="advanced_settings_item for_list_border_colors">
                                    <a href="<?php echo base_url(); ?>tables">
                                        <i class="icon-system"></i>
                                        <h3><?php echo $this->lang->line('menu_tablas'); ?></h3>
                                        <p class="desc_text"><?php echo $this->lang->line('advanced_settings_tablas_desc'); ?>.</p>
                                    </a>
                                </div>
                            </div>

                            <div class="col-sm-6  col-md-4">
                                <div class="advanced_settings_item for_list_border_colors">
                                    <a href="<?php echo base_url(); ?>advancedSettings/import_external_data">
                                        <i class="icon-system"></i>
                                        <h3><?php echo $this->lang->line('menu_import_external_data'); ?></h3>
                                        <p class="desc_text"><?php echo $this->lang->line('advanced_settings_import_external_data'); ?>.</p>
                                    </a>
                                </div>
                            </div>

                            <div class="col-sm-6  col-md-4">
                                <div class="advanced_settings_item for_list_border_colors">
                                    <a href="<?php echo base_url(); ?>templates">
                                        <i class="icon-template" ></i>
                                        <h3><?php echo $this->lang->line('advanced_settings_document_templates'); ?></h3>
                                        <p class="desc_text"><?php echo $this->lang->line('advanced_settings_manage_templates'); ?>.</p>
                                    </a>
                                </div>
                            </div>

                            <div class="col-sm-6  col-md-4">
                                <div class="advanced_settings_item for_list_border_colors">
                                    <a href="<?php echo base_url(); ?>leadsConfig">
                                        <i class="fa fa-key" ></i>
                                        <h3><?php echo $this->lang->line('advanced_settings_leads_config'); ?></h3>
                                        <p class="desc_text"><?php echo $this->lang->line('advanced_settings_leads_config_desc'); ?>.</p>
                                    </a>
                                </div>
                            </div>

                            <div class="col-sm-6  col-md-4">
                                <div class="advanced_settings_item for_list_border_colors">
                                    <a href="<?php echo base_url('advancedSettings/tags'); ?>">
                                        <i class="fa fa-tags" ></i>
                                        <h3><?php echo $this->lang->line('advanced_settings_tags'); ?></h3>
                                        <p class="desc_text"><?php echo $this->lang->line('advanced_settings_tags_desc'); ?>.</p>
                                    </a>
                                </div>
                            </div>
                              <div class="col-sm-6  col-md-4">
                                <div class="advanced_settings_item for_list_border_colors">
                                    <a href="<?php echo base_url('advancedSettings/custom_fields'); ?>">
                                        <i class="icon-system"></i>
                                        <h3><?php echo $this->lang->line('advanced_settings_custom_fields'); ?></h3>
                                        <p class="desc_text"><?php echo $this->lang->line('advanced_settings_custom_fields_desc'); ?>.</p>
                                    </a>
                                </div>
                            </div>
                            <!-- END INLINE NOTIFICATIONS PORTLET-->
                        </div>

                        <h2><?php echo $this->lang->line('user_modules_integrations'); ?></h2>

                        <div class="row margin-bottom-40">

                            <!-- BEGIN INLINE NOTIFICATIONS PORTLET-->
                            <div class="col-sm-6  col-md-4">
                                <div class="advanced_settings_item for_list_border_colors">
                                    <a href="<?php echo base_url('advancedSettings/campus_teachers'); ?>" id="<?php echo $campus_teachers_active == '1' || $is_super_admin ? '' : 'campus_teachers_disable'; ?>" >
                                        <i class="icon-campus-teachers"></i>
                                        <h3><?php echo $this->lang->line('user_campus_teachers'); ?></h3>
                                        <p class="desc_text"><?php echo $this->lang->line('user_campus_teachers_desc'); ?></p>
                                    </a>
                                    <?php if($campus_teachers_active == '1'){ ?>
                                        <div class="checked_img">
                                            <img src="<?php echo base_url(); ?>app/images/success.png">
                                        </div>
                                    <?php  } ?>
                                </div>
                            </div>

                            <div class="col-sm-6  col-md-4">
                                <div class="advanced_settings_item for_list_border_colors">
                                    <a href="<?php echo base_url('advancedSettings/campus_students'); ?>" id="<?php echo $campus_students_active == '1' || $is_super_admin ? '' : 'campus_students_disable'; ?>">
                                        <i class="icon-campus-students"></i>
                                        <h3><?php echo $this->lang->line('user_campus_students'); ?></h3>
                                        <p class="desc_text"><?php echo $this->lang->line('user_campus_students_desc'); ?></p>
                                    </a>
                                    <?php if($campus_students_active == '1'){ ?>
                                        <div class="checked_img">
                                            <img src="<?php echo base_url(); ?>app/images/success.png">
                                        </div>
                                    <?php  } ?>
                                </div>
                            </div>
                            <div class="col-sm-6  col-md-4">
                                <div class="advanced_settings_item advanced_settings_item_logo for_list_border_colors">
                                    <a href="<?php echo base_url('advancedSettings/e_goi'); ?>">
                                        <i class="icon-e-goi "></i>
                                        <h3><?php echo $this->lang->line('user_email_integration'); ?></h3>
                                        <p class="desc_text"><?php echo $this->lang->line('user_email_integration_desc'); ?></p>
                                    </a>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-4">
                                <div class="advanced_settings_item advanced_settings_item_logo for_list_border_colors">
                                    <a href="<?php echo base_url('advancedSettings/livebeep'); ?>">
                                        <i class="icon-livebeep"></i>
                                        <h3><?php echo $this->lang->line('user_system_settings_livebeep'); ?></h3>
                                        <p class="desc_text"><?php echo $this->lang->line('user_system_settings_livebeep_desc'); ?></p>
                                    </a>
                                </div>
                            </div>
                            <div class="col-sm-6  col-md-4">
                                <div class="advanced_settings_item advanced_settings_item_logo for_list_border_colors">
                                    <a href="<?php echo base_url('advancedSettings/moodle'); ?>">
                                        <i class="icon-moodle"></i>
                                        <h3><?php echo $this->lang->line('user_system_settings_moodle'); ?></h3>
                                        <p class="desc_text"><?php echo $this->lang->line('user_system_settings_moodle_desc'); ?></p>
                                    </a>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <h3 class="text-center comming_soon_advanced"><?php echo $this->lang->line('user_comming_soon'); ?> ...</h3>

                            <div class="col-sm-6  col-md-4">
                                <div class="advanced_settings_item advanced_settings_item_logo for_list_border_colors">
                                    <a href="#">
                                        <i class="icon-zapier "></i>
                                        <h3><?php echo $this->lang->line('user_system_settings_zapier'); ?></h3>
                                        <p class="desc_text"><?php echo $this->lang->line('user_system_settings_zapier_desc'); ?></p>
                                    </a>
                                </div>
                            </div>

                            <div class="col-sm-6 col-md-4">
                                <div class="advanced_settings_item advanced_settings_item_logo for_list_border_colors">
                                    <a href="#">
                                        <i class="icon-mailchimp"></i>
                                        <h3><?php echo $this->lang->line('user_system_settings_mailchimp'); ?></h3>
                                        <p class="desc_text"><?php echo $this->lang->line('user_system_settings_mailchimp_desc'); ?></p>
                                    </a>
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
        

        
        <div class="modal fade" id="campus_students_disable_modal" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                        <h4 class="modal-title"><?php echo $this->lang->line('please_confirm'); ?></h4>
                    </div>
                    <div class="modal-body">
                        <p><?php echo $this->lang->line('advanced_settings_option_access_upgrade_plan'); ?></p>
                        <p><?php echo $this->lang->line('advanced_settings_confirm_going_plan_page'); ?></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->lang->line('close');?></button>
                        <button type="button" class="btn blue delete_blog" id="campus_students_plan_confirm" ><?php echo $this->lang->line('confirm');?></button>
                    </div>
                </div>
            </div>
        </div>