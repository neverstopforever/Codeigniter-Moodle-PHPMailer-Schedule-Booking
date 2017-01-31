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
                <li>
                    <a href="<?php echo $_base_url; ?>advancedSettings"><?php echo $this->lang->line('menu_advanced_settings'); ?></a>
                </li>
                <li class="active">
                    <?php echo $this->lang->line('user_email_settings'); ?>
                </li>
            </ul>
            <!-- BEGIN PAGE CONTENT INNER -->
            <div class="portlet light">

                <div class="text-right">
                    <button type="button" id="quick_tips" class="btn btn-xs green-meadow "> <i class="fa fa-lightbulb-o" aria-hidden="true"></i> <span class="button_text"><?php echo $this->lang->line('show_quick_tips'); ?></span> <i class="fa fa-angle-down fa-angledown"></i></button>
                </div>
                <div class="quick_tips_sidebar margin-top-20 margin-bottom-20">
                    <div class=" note note-info quick_tips_content">
                        <h2><?php echo $this->lang->line('quick_box_title'); ?></h2>
                        <p><?php echo $this->lang->line('email_settings_quick_tips_text'); ?>
                            <strong><a href="<?php echo $this->lang->line('email_settings_quick_tips_link'); ?>" target="_blank"><?php echo $this->lang->line('email_settings_quick_tips_link_text'); ?></a></strong>
                        </p>
                    </div>
                </div>

                <div class="tabbable-line">
                    <ul class="nav nav-tabs ">
                        <li class="active">
                            <a href="#tab_1" data-toggle="tab"
                               aria-expanded="true"> <?php echo $this->lang->line('tabPrefix_statistics'); ?> </a>
                        </li>
                        <li class="">
                            <a href="#tab_2" data-toggle="tab"
                               aria-expanded="false"> <?php echo $this->lang->line('account_information'); ?></a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tools">
                        </div>
                        <div class="tab-pane active " id="tab_1">
                            <div class="overf_hidden start_end_interval ">
<!--                            <button class="btn btn-success pull-left">--><?php //echo $this->lang->line('daily'); ?><!--</button>-->
<!--                            <button class="btn btn-success pull-left">--><?php //echo $this->lang->line('monthly'); ?><!--</button>-->
                                <div class="col-sm-3">
                                    <lable><?php echo $this->lang->line('from'); ?>
                                        <input type="text" id="start_interval" class="form-control" />
                                    </lable>
                                </div>
                                <div class="col-sm-3">
                                    <lable><?php echo $this->lang->line('to'); ?>
                                         <input type="text" id="end_interval" class="form-control" />
                                    </lable>
                                 </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 ">
                                    <!-- BEGIN CHART PORTLET-->
                                    <div id="chart_2" class="chart" >
                                    </div>
                                    <!-- END CHART PORTLET-->
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane student_sub_tab" id="tab_2">
                             <div class="col-sm-6">
                                <table class="table dbtable ">
                                     <tr>
                                         <td><?php echo $this->lang->line('advanced_settings_email_limit_day'); ?></td>
                                         <td><?php echo $emails_limit_daily; ?></td>
                                     </tr>
                                     <tr>
                                         <td><?php echo $this->lang->line('advanced_settings_email_limit_month'); ?></td>
                                         <td><?php echo $emails_limit_monthly; ?></td>
                                     </tr>
                                    <tr>
                                         <td><?php echo $this->lang->line('advanced_settings_email_sent_current_day'); ?></td>
                                         <td><?php echo $count_emails->count_daily; ?></td>
                                     <tr>
                                    <tr>
                                         <td><?php echo $this->lang->line('advanced_settings_email_sent_current_month'); ?></td>
                                         <td><?php echo $count_emails->count_monthly; ?></td>
                                     </tr>
                                 </table>
                             </div>
                            <div class="col-sm-6">
                                <table class="table dbtable email_setting_second_table">
                                     <tr>
                                         <td><?php echo $this->lang->line('advanced_settings_email_available_by_day'); ?></td>
                                         <td><?php echo $emails_remaining_daily; ?></td>
                                     </tr>
                                     <tr>
                                         <td><?php echo $this->lang->line('advanced_settings_email_available_by_month'); ?></td>
                                         <td><?php echo $emails_remaining_monthly; ?></td>
                                     </tr>
                                    <tr>
                                         <td class="text-danger"><?php echo $this->lang->line('advanced_settings_email_not_sent_by_day'); ?></td>
                                         <td><?php echo $count_emails->count_daily_not_sent; ?></td>
                                     </tr>
                                    <tr>
                                         <td class="text-danger"><?php echo $this->lang->line('advanced_settings_email_not_sent_by_month'); ?></td>
                                         <td><?php echo $count_emails->count_monthly_not_sent; ?></td>
                                     </tr>
                                 </table>
                             </div>
                            <button class="btn red btn-circle pull-right show_not_sent_emails" > <i class="fa fa-ban fa-fw"></i> <?php echo $this->lang->line('advanced_settings_show_not_sent_emails'); ?></button>
                            <button class="btn btn-primary btn-circle margin-left-10 pull-right hide_not_sent_emails" style="display: none" ><i class="fa fa-times" aria-hidden="true"></i> <?php echo $this->lang->line('close'); ?></button>
                            <div class="clearfix"></div>
                            <div class="col-sm-12 not_sent_emails" style="display: none">
                                <div id="notSentEmailsTable">
                                </div>
                            </div>
                            <div class="clearfix"></div>
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
<script>
    var maximum_axis = parseInt(<?php echo ((int)$emails_limit_daily + 8); ?>);

</script>