<div class="step_copmose">
    <div class="row margin-top-20 step_header">
        <h2 class="text-center campaigns_step_title_3"><?php echo $this->lang->line('campaigns_step_title_3_1'); ?></h2>
    </div>
    <div class="row margin-top-20">
        <div class="col-xs-12 col-sm-6 col-sm-offset-3" id=select_template >
            <select class="form-control margin-top-10" name="select_template">
                <option value=""><?php echo $this->lang->line('select_template'); ?></option>
                <?php if(!empty($templates)) { ?>
                    <?php foreach($templates as $template){ ?>
                        <option value="<?php echo $template->id; ?>"><?php echo $template->title; ?></option>
                    <?php } ?>
                <?php } ?>
            </select>
            <hr>
        </div>
        <div class="col-xs-12 col-sm-6 col-sm-offset-3 email_subject_personalize">
        <div class="form-group">
            <label for="email_subject"><?php echo $this->lang->line('subject'); ?> <i class="text-danger">*</i>
                <input type="text" name="email_subject" id="email_subject" class="form-control" value=""/>
            </label>
        </div>
        <div class="form-group circle_select_div">
            <label for="personalize"><?php echo $this->lang->line('campaigns_personalize');?>
                <?php $this->load->view('campaigns/partials/select_personalize.php', $this->data);?>
            </label>
        </div>

        </div>
    </div>
    <div class="row html_editor">
        <div class="col-xs-12 ">
            <div class="form-group">
                <textarea name="campaign_body" id="campaign_body" rows="10" cols="60"></textarea>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12 col-sm-6 back_save_group text-center">
            <button type="button" class=" btn btn-circle btn-default-back exit_steps"><?php echo $this->lang->line('exit'); ?></button>
            <button type="button" class=" btn btn-circle btn-default-back back_step" data-prev_step="2"><i class="fa fa-arrow-left" aria-hidden="true"></i> <?php echo $this->lang->line('back'); ?></button>
        </div>
        <div class="col-xs-12 col-sm-6 back_save_group text-center">
            <button type="button" class="btn  btn-primary btn-circle" id="send_test_email"><?php echo $this->lang->line('campaigns_send_test_email'); ?></button>
            <button type="button" class="btn  btn-primary btn-circle continue_step" data-next_step="4"><?php echo $this->lang->line('continue'); ?> <i class="fa fa-arrow-right" aria-hidden="true"></i></button>
        </div>
    </div>
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
    var _templates = <?php echo json_encode($templates); ?>;
</script>
