        <!-- BEGIN PAGE CONTAINER -->
        <div class="page-container">
            <!-- BEGIN PAGE HEAD -->
            <div class="page-head">
                <div class="<?php echo $layoutClass ?>">
                    <!-- BEGIN PAGE TITLE -->
                    <div class="page-title">
                        <h1><?php echo $this->lang->line('menu_account'); ?></h1>
                    </div>
                    <!-- END PAGE TITLE -->
                </div>
            </div>
            <!-- END PAGE HEAD -->
            <ul class="<?php echo $layoutClass ?> page-breadcrumb breadcrumb">
                <li>
                    <a href="#">Home</a><i class="fa fa-circle"></i>
                </li>
                <li class="active">
                    <?php echo $this->lang->line('menu_advanced_settings'); ?>
                </li>
            </ul>
            <!-- BEGIN PAGE CONTENT -->
            <div class="table_loading"></div>
            <div class="page-content">
                <div class="<?php echo $layoutClass ?>">
                    <!-- BEGIN PAGE CONTENT INNER -->
                    <div class="portlet light text-center">
                        <h2><?php echo $this->lang->line('user_advanced_settings'); ?></h2>
                        <div class="row margin-bottom-40">
                                <!-- BEGIN INLINE NOTIFICATIONS PORTLET-->
                                    <div class="col-sm-6  col-md-4">
                                        <div class="advanced_settings_item">
                                            <i class="icon-monthly"></i>
                                            <h3><?php echo $this->lang->line('user_subscription_plans'); ?></h3>
                                            <p class="desc_text"><?php echo $this->lang->line('user_subscription_plans_desc'); ?></p>
                                        </div>
                                    </div>
                                    <div class="col-sm-6  col-md-4">
                                        <div class="advanced_settings_item">
                                            <i class="icon-billing"></i>
                                            <h3><?php echo $this->lang->line('user_billing_information'); ?></h3>
                                            <p class="desc_text"><?php echo $this->lang->line('user_billing_information_desc'); ?></p>
                                        </div>
                                    </div>

                                    <div class=" col-sm-6  col-md-4">
                                        <div class="advanced_settings_item">
                                            <i class="icon-myusers "></i>
                                            <h3><?php echo $this->lang->line('user_users'); ?></h3>
                                            <p class="desc_text"><?php echo $this->lang->line('user_users_desc'); ?></p>
                                        </div>
                                    </div>
                                <!-- END INLINE NOTIFICATIONS PORTLET-->



                            <!-- BEGIN INLINE NOTIFICATIONS PORTLET-->
                            <div class="col-sm-6  col-md-4">
                                <div class="advanced_settings_item">
                                    <i class="icon-system"></i>
                                    <h3><?php echo $this->lang->line('user_system_settings'); ?></h3>
                                    <p class="desc_text"><?php echo $this->lang->line('user_system_settings_desc'); ?></p>
                                </div>
                            </div>
                            <div class="col-sm-6  col-md-4">
                                <div class="advanced_settings_item">
                                    <i class="icon-email "></i>
                                    <h3><?php echo $this->lang->line('user_email_notifications'); ?></h3>
                                    <p class="desc_text"><?php echo $this->lang->line('user_email_notifications_desc'); ?></p>
                                </div>
                            </div>
                            <div class="col-sm-6  col-md-4">
                                <div class="advanced_settings_item">
                                    <i class="icon-email-integration "></i>
                                    <h3><?php echo $this->lang->line('user_email_integration'); ?></h3>
                                    <p class="desc_text"><?php echo $this->lang->line('user_email_integration_desc'); ?></p>
                                </div>
                            </div>
                            <!-- END INLINE NOTIFICATIONS PORTLET-->
                        </div>

                        <h2><?php echo $this->lang->line('user_modules_integrations'); ?></h2>

                        <div class="row margin-bottom-40">
                            <!-- BEGIN INLINE NOTIFICATIONS PORTLET-->
                            <div class="col-sm-6  col-md-4">
                                <div class="advanced_settings_item">
                                    <i class="icon-campus-teachers"></i>
                                    <h3><?php echo $this->lang->line('user_campus_teachers'); ?></h3>
                                    <p class="desc_text"><?php echo $this->lang->line('user_campus_teachers_desc'); ?></p>
                                </div>
                            </div>
                            <div class="col-sm-6  col-md-4">
                                <div class="advanced_settings_item">
                                    <i class="icon-campus-students"></i>
                                    <h3><?php echo $this->lang->line('user_campus_students'); ?></h3>
                                    <p class="desc_text"><?php echo $this->lang->line('user_campus_students_desc'); ?></p>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-4">
                                <div class="advanced_settings_item">
                                    <i class="icon-company "></i>
                                    <h3><?php echo $this->lang->line('user_company_platform'); ?></h3>
                                    <p class="desc_text"><?php echo $this->lang->line('user_company_platform_desc'); ?></p>
                                </div>
                            </div>
                            <!-- END INLINE NOTIFICATIONS PORTLET-->
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
