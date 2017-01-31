<div class="row margin-top-20 step_header">
    <h2 class="text-center step_title"><?php echo $this->lang->line('campaigns_step_title_2');?></h2>
</div>

<div class="row margin-top-20 text-center select_an_option">
    <div class="col-sm-4">
        <span class="icon-select-code"></span>
        <h2><?php echo $this->lang->line('campaigns_code');?></h2>
        <p><?php echo $this->lang->line('campaigns_code_text');?></p>
        <a href="#" class="btn btn-primary btn-circle select_continue" data-body_type="code" data-next_step="3"><?php echo $this->lang->line('select');?></a>
    </div>
    <div class="col-sm-4">
        <span class="icon-select-basic"></span>
        <h2><?php echo $this->lang->line('campaigns_basic');?></h2>
        <p><?php echo $this->lang->line('campaigns_basic_text');?></p>
        <a href="#" class="btn btn-primary btn-circle select_continue" data-body_type="basic" data-next_step="3"><?php echo $this->lang->line('select');?></a>
    </div>
    <div class="col-sm-4">
        <span class="icon-select-draft"></span>
        <h2><?php echo $this->lang->line('campaigns_templates');?></h2>
        <p><?php echo $this->lang->line('campaigns_templates_text');?></p>
        <a href="#" class="btn btn-primary btn-circle select_continue" data-body_type="templates" data-next_step="3"><?php echo $this->lang->line('select');?></a>
    </div>

</div>
<div class="margin-left-40 text-left back_save_group margin-bottom-20 margin-top-20">
    <button type="button" class=" btn btn-circle btn-default-back exit_steps"><?php echo $this->lang->line('exit'); ?></button>
    <button type="button" class=" btn btn-circle btn-default-back back_step" data-prev_step="1"><i class="fa fa-arrow-left" aria-hidden="true"></i> <?php echo $this->lang->line('back'); ?></button>
</div>


<div id="putHtmlModal" class="modal fade" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h2 class="modal-title"> <?php echo $this->lang->line("email_templates_insert_code"); ?> </h2>
            </div>
            <div class="modal-body">
                <p><?php echo $this->lang->line("email_templates_insert_html_code"); ?></p>
                <div class="form-group">
                    <textarea name="template_insert_html" id="template_insert_html" rows="10" cols="60"> </textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn  btn-danger" data-dismiss="modal"><?php echo $this->lang->line("close"); ?></button>
                <button class="btn btn-success next_step_3"><?php echo $this->lang->line("email_templates_insert"); ?></button>
            </div>
        </div>
    </div>
</div>
