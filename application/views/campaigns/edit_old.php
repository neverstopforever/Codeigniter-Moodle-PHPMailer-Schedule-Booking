<div class="page-container campaigns_edit_page">
    <!-- BEGIN PAGE HEAD -->
    <div class="page-head">
        <ul class="<?php echo $layoutClass ?> page-breadcrumb breadcrumb">
            <li>
                <a href="/"><?= $this->lang->line('menu_Home') ?></a>
            </li>
            <li>
                <a href="/campaigns"><?php echo $this->lang->line('menu_campaigns'); ?></a>
            </li>
            <li class="active">
                <?php echo $this->lang->line('edit'); ?>
            </li>
        </ul>
        </div>
        <div class="table_loading"></div>
        <div class="page-content">
            <div class="<?php echo $layoutClass ?>">
                <div class="portlet light overf_hidden">
                <div class="clear"></div>
                    <form class="form-horizontal" action="/campaigns/edit/<?php echo $campaign_id;?>" method="post">
                       <div>
                        <div class="col-xs-12 col-md-6 col-md-offset-3 ">
                        <div class="form-group">
                            <label for="campaign_title" class="control-label"><?php echo $this->lang->line('campaigns_name_your_campaign'); ?><i class="text-danger">*</i></label>
                            <input type="text" name="campaign_title" id="campaign_title" class="form-control" value="<?php echo set_value('campaign_title', $campaign->title); ?>"/>
                            <?php echo form_error('campaign_title'); ?>
                        </div>
                        <div class="form-group">
                            <label for="date_sending" class="control-label"><?php echo $this->lang->line('campaigns_new_date_sending'); ?></label>
                            <input type="text" name="date_sending" id="date_sending" value="<?php echo set_value('date_sending', $campaign->date_sending);?>" class="form-control" />
                            <?php echo form_error('date_sending'); ?>
                        </div>
                        <div class="form-group circle_select_div">
                            <label for="id_folder" class="control-label id_folder_label"><?php echo $this->lang->line('folder'); ?></label>
                            <select name="id_folder" id="id_folder" class="form-control form-control-campaign-folder">
                                <?php
                                if(!empty($folders)){
                                    foreach($folders as $folder){
                                        ?>
                                        <option value="<?php echo $folder->id_folder; ?>"<?php echo ($folder->id_folder == set_value('id_folder', $campaign->id_folder))?' selected="selected"':''; ?>><?php echo $folder->title; ?></option>
                                    <?php  }
                                }
                                ?>
                            </select>
                            <?php echo form_error('id_folder'); ?>
                            <a href="#" class="btn btn-circle btn-default-back" id="add_folder">+ <?php echo $this->lang->line('campaigns_add_folder');?></a>
                        </div>
        
                        <div class="form-group circle_select_div">
                            <select name="state" id="state" class="form-control">
                                <option value="0" <?php echo (set_value('state', $campaign->state) == 0) ? 'selected="selected"': '';?>><?php echo $this->lang->line('paused'); ?></option>
                                <option value="1" <?php echo (set_value('state', $campaign->state) == 1) ? 'selected="selected"': '';?>><?php echo $this->lang->line('scheduled'); ?></option>
                            </select>
                            <?php echo form_error('state'); ?>
                        </div>
        
                        <div class="form-group subject_section ">
                    <div class="col-xs-8 no-padding">
                        <label for="email_subject"><?php echo $this->lang->line('campaigns_subject');?> <i class="text-danger">*</i></label>
                        <input type="text" name="email_subject" id="email_subject" class="form-control" value="<?php echo set_value('email_subject', $campaign->Subject); ?>"/>
                        <?php echo form_error('email_subject'); ?>
                    </div>
                    <div class="col-xs-4 circle_select_div">
                        <label for="personalize"><?php echo $this->lang->line('campaigns_personalize');?></label>
                        <?php $this->load->view('campaigns/partials/select_personalize.php', $this->data);?>
                    </div>
                </div>
              </div>
                        </div>
                <div>
                    <div class="col-xs-12 margin-top-20 ">
                        <div class="form-group">
                            <textarea name="campaign_body" id="campaign_body" rows="10" cols="80" class="form-control"><?php echo set_value('campaign_body', $campaign->Body); ?></textarea>
                            <?php echo form_error('campaign_body'); ?>
                        </div>
                    </div>
                </div>
                <div>
                    <div class="col-xs-12  ">
                        <div class="form-group">
                         <?php $this->load->view('campaigns/partials/edit_recipients_old', $this->data);?>
                        </div>
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
                    <i><?php echo $this->lang->line('campaigns_test_emails_desc'); ?><i>
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
    var selected_recipients = <?php print_r(json_encode($selected_recipients)); ?>;
    var check_recipients = <?php print_r(json_encode($this->input->post('check_recipient', true))); ?>;

    var  surname_data = <?php echo isset($surname_data) ? json_encode($surname_data) : json_encode(array()); ?>;
    var  first_name_data = <?php echo isset($first_name_data) ? json_encode($first_name_data) : json_encode(array()); ?>;
    var  email_data = <?php echo isset($email_data) ? json_encode($email_data) : json_encode(array()); ?>;
</script>
