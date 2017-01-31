<div class="page-container">
    <div class="table_loading"></div>
    <div class="page-content">
        <div class="<?php echo $layoutClass ?>">
            <ul class="<?php echo $layoutClass ?> page-breadcrumb breadcrumb">
                <li>
                    <a href="<?php echo $_base_url; ?>" ><?php echo $this->lang->line('menu_Home'); ?></a>
                </li>
                <li>
                    <a href="<?php echo $_base_url; ?>advancedSettings"><?php echo $this->lang->line('menu_advanced_settings'); ?></a>
                </li>
                <li>
                    <a href="<?php echo $_base_url; ?>automatedEmails"><?php echo $this->lang->line('menu_automated_emails'); ?></a>
                </li>
                <li class="active">
                    <?php echo $this->lang->line('edit'); ?>
                </li>

            </ul>
            <div class="portlet light">
                <form class="form-horizontal" action="/automatedEmails/editTemplate/<?php echo $template_id;?>" method="post">
                <div>
                    <div class="col-xs-12 col-md-6 col-md-offset-3 ">
                <div class="form-group">
                    <label for="template_title" class="control-label"><?php echo $this->lang->line('automated_emails_template_name'); ?><i class="text-danger">*</i></label>
                    <input type="text" name="template_title" id="template_title" class="form-control" value="<?php echo set_value('template_title', $this->lang->line($template->title)); ?>" readonly/>
                    <?php echo form_error('template_title'); ?>
                </div>
                <div class="form-group">
                    <label for="from_email" class="control-label"><?php echo $this->lang->line('automated_emails_from_email'); ?><i class="text-danger">*</i></label>
                    <input type="text" name="from_email" id="from_email" class="form-control" value="<?php echo set_value('from_email', $template->from_email); ?>" />
                    <?php echo form_error('from_email'); ?>
                </div>


                <div class="form-group subject_section">
                    <div class="col-xs-8 no-padding">
                        <label for="email_subject">Subject <i class="text-danger">*</i></label>
                        <input type="text" name="email_subject" id="email_subject" class="form-control" value="<?php echo set_value('email_subject', $template->Subject); ?>"/>
                        <?php echo form_error('email_subject'); ?>
                    </div>
                    <div class="col-xs-4 circle_select_div">
                        <label for="personalize"><?php echo $this->lang->line('automated_emails_personalize');?></label>
                        <select class="form-control" name="personalize" id="personalize">
                            <option value="[FIRSTNAME]"><?php echo $this->lang->line('automated_emails_df_first_name');?></option>
                            <option value="[SURNAME]"><?php echo $this->lang->line('automated_emails_df_surname');?></option>
                            <option value="[FULLNAME]"><?php echo $this->lang->line('automated_emails_df_full_name');?></option>
                            <option value="[PHONE1]"><?php echo $this->lang->line('automated_emails_df_phone') . '1';?></option>
                            <option value="[PHONE2]"><?php echo $this->lang->line('automated_emails_df_phone') . '2';?></option>
                            <option value="[MOBILE]"><?php echo $this->lang->line('automated_emails_df_mobile');?></option>
                            <option value="[EMAIL1]"><?php echo $this->lang->line('automated_emails_df_email') . ' 1';?></option>
                            <option value="[EMAIL2]"><?php echo $this->lang->line('automated_emails_df_email') . ' 2';?></option>
                            <option value="[USERNAME]"><?php echo $this->lang->line('automated_emails_df_user_name');?></option>
                            <option value="[COURSE_NAME]"><?php echo $this->lang->line('automated_emails_course_name');?></option>
                            <option value="[GROUP]"><?php echo $this->lang->line('group');?></option>
                            <option value="[START_DATE]"><?php echo $this->lang->line('start_date');?></option>
                            <option value="[END_DATE]"><?php echo $this->lang->line('end_date');?></option>
                        </select>
                    </div>
                </div>
                    </div>
            </div>
               <div class="col-xs-12 margin-top-20 ">
                <div class="form-group">
                    <textarea name="template_body" id="template_body" rows="10" cols="80" class="form-control"><?php echo set_value('template_body', $template->Body); ?></textarea>
                    <?php echo form_error('template_body'); ?>
                </div>
               </div>
               <div class="col-xs-12 margin-top-20 ">
                <div class="form-group back_save_group">
                    <a type="button" href="/automatedEmails" class="btn btn-circle btn-default-back  margin-right-10 back_system_settigs "> <i class="fa fa-arrow-left" aria-hidden="true"></i> <?php echo $this->lang->line('back'); ?></a>
                    <button type="button" class="btn btn-circle btn-default-back  margin-right-10 " id="send_test_email"><?php echo $this->lang->line('automated_send_test_email'); ?></button>
                    <button type="submit" class="btn btn-primary btn-circle"><?php echo $this->lang->line('save'); ?></button>
                    <a type="button" href="/automatedEmails" class="btn btn-circle btn-default-back  margin-right-10 back_system_settigs_min"> <i class="fa fa-arrow-left" aria-hidden="true"></i> <?php echo $this->lang->line('back'); ?></a>
                </div>
               </div>

            </form>
            </div>
            <!-- BEGIN PAGE CONTENT INNER -->
        </div>
        <!-- END PAGE CONTENT INNER -->
    </div>

</div>

<div class="modal fade" id="add_folder_modal" tabindex="-1" role="dialog" aria-labelledby="addFolderModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title"><?php echo $this->lang->line('campaigns_new_folder'); ?></h4>
            </div>
            <form action="" method="POST" id="new_folder_form">
                <div class="modal-body">
                    <?php echo $this->lang->line('campaigns_folder_name'); ?>
                    <input type="text" id="new_folder_name" name="new_folder_name" class="form-control" placeholder="<?php echo $this->lang->line('campaigns_folder_name'); ?>">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn default" data-dismiss="modal"><?php echo $this->lang->line('close'); ?></button>
                    <button type="submit" class="btn blue"><?php echo $this->lang->line('campaigns_create_folder'); ?></button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<div class="modal fade" id="test_email_modal" tabindex="-1" role="dialog" aria-labelledby="testEmailModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title"><?php echo $this->lang->line('campaigns_send_test_email'); ?></h4>
            </div>
            <form action="" method="POST" id="send_test_email_form">
                <div class="modal-body">
                    <label for="test_emails"><?php echo $this->lang->line('campaigns_test_emails'); ?></label>
                    <input type="text" id="test_emails" name="test_emails" class="form-control" placeholder="Test emails">
                    <i><?php echo $this->lang->line('campaigns_test_emails_desc'); ?></i>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn default" data-dismiss="modal"><?php echo $this->lang->line('close'); ?></button>
                    <button type="submit" class="btn blue"><?php echo $this->lang->line('send'); ?></button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<script>
//    var selected_recipients = <?php //print_r(json_encode($selected_recipients)); ?>//;
//    var check_recipients = <?php //print_r(json_encode($this->input->post('check_recipient', true))); ?>//;
</script>

