<div class="page-container">
      <div class="table_loading"></div>
        <div class="page-content">
            <div class="<?php echo $layoutClass ?>">
                <ul class="page-breadcrumb breadcrumb">
                    <li>
                        <a href="<?php echo $_base_url; ?>" ><?= $this->lang->line('menu_Home') ?></a>
                    </li>
                    <li>
                        <a href="javascript:;"><?php echo $this->lang->line('menu_crm'); ?></a>
                    </li>
                    <li>
                        <a href="<?php echo $_base_url; ?>email_templates" ><?php echo $this->lang->line('menu_email_templates'); ?></a>
                    </li>
                    <li class="active">
                        <?php echo $this->lang->line('edit'); ?>
                    </li>
                </ul>
                <div class="portlet light overf_hidden">
                <div class="clear"></div>
                <form class="form-horizontal" action="/email_templates/edit/<?php echo $template_id;?>" method="post">
                    <div>
                        <div class="col-xs-12 col-md-6 col-md-offset-3 ">
                        <div class="form-group">
                            <label for="template_title" class="control-label"><?php echo $this->lang->line('email_templates_email_template_name'); ?><i class="text-danger">*</i></label>
                            <input type="text" name="template_title" id="template_title" class="form-control" value="<?php echo set_value('template_title', $template->title); ?>"/>
                            <?php echo form_error('template_title'); ?>
                        </div>
                        <div class="form-group circle_select_div">
                            <label for="template_folder" class="control-label template_folder"><?php echo $this->lang->line('folder'); ?></label>
                            <select name="template_folder" id="template_folder" class="form-control form-control-template-folder">
                                <?php
                                if(!empty($folders)){
                                    foreach($folders as $folder){
                                        ?>
                                        <option value="<?php echo $folder->id_folder; ?>"<?php echo ($folder->id_folder == set_value('template_folder', $template->id_folder))?' selected="selected"':''; ?>><?php echo $folder->title; ?></option>
                                    <?php  }
                                }
                                ?>
                            </select>
                            <?php echo form_error('template_folder'); ?>
                            <a href="#" class="btn btn-circle btn-default-back" id="add_folder">+ <?php echo $this->lang->line('email_templates_add_folder');?></a>
                        </div>
                        <div class="form-group subject_section">
                            <div class="col-xs-8 no-padding">
                                <label for="email_subject"><?php echo $this->lang->line('email_templates_subject');?> <i class="text-danger">*</i></label>
                                <input type="text" name="email_subject" id="email_subject" class="form-control" value="<?php echo set_value('email_subject', $template->Subject); ?>"/>
                                <?php echo form_error('email_subject'); ?>
                            </div>
                            <div class="col-xs-4 circle_select_div">
                                <label for="personalize"><?php echo $this->lang->line('email_templates_personalize');?></label>
                                <?php $this->load->view('email_templates/partials/select_personalize.php', $this->data);?>
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
                            <a type="button" href="/email_templates" class="btn btn-circle btn-default-back  margin-right-10 back_system_settigs "> <i class="fa fa-arrow-left" aria-hidden="true"></i> <?php echo $this->lang->line('back'); ?></a>
                            <button type="button" class="btn btn-circle btn-default-back  margin-right-10 " id="send_test_email"><?php echo $this->lang->line('email_templates_send_test_email'); ?></button>
                            <button type="submit" class="btn btn-primary btn-circle"><?php echo $this->lang->line('save'); ?></button>
                            <a type="button" href="/email_templates" class="btn btn-circle btn-default-back  margin-right-10 back_system_settigs_min"> <i class="fa fa-arrow-left" aria-hidden="true"></i> <?php echo $this->lang->line('back'); ?></a>
                        </div>
                    </div>
                </form>
                <!-- BEGIN PAGE CONTENT INNER -->
            </div>
            </div>
            <!-- END PAGE CONTENT INNER -->
        </div>

</div>

<div class="modal fade" id="add_folder_modal" tabindex="-1" role="dialog" aria-labelledby="addFolderModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title"><?php echo $this->lang->line('email_templates_new_folder'); ?></h4>
            </div>
            <form action="" method="POST" id="new_folder_form">
                <div class="modal-body">
                    <?php echo $this->lang->line('email_templates_folder_name'); ?>
                    <input type="text" id="new_folder_name" name="new_folder_name" class="form-control" placeholder="Folder Name">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn default" data-dismiss="modal"><?php echo $this->lang->line('close'); ?></button>
                    <button type="submit" class="btn blue"><?php echo $this->lang->line('email_templates_create_folder'); ?></button>
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
                <h4 class="modal-title"><?php echo $this->lang->line('email_templates_send_test_email'); ?></h4>
            </div>
            <form action="" method="POST" id="send_test_email_form">
                <div class="modal-body">
                    <label for="test_emails"><?php echo $this->lang->line('email_templates_test_emails'); ?></label>
                    <input type="text" id="test_emails" name="test_emails" class="form-control" placeholder="Test emails">
                    <i><?php echo $this->lang->line('email_templates_test_emails_desc'); ?><i>
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

