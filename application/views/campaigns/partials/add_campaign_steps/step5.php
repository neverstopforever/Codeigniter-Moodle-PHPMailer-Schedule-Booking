<div class="step_finish">
    <div class="row margin-top-20 step_header">    
        <h2 class=" text-center step_title"><?php echo $this->lang->line('campaigns_step_title_5'); ?></h2>
    </div>    
    <div class="row margin-top-20">
        <div class="col-sm-6 col-sm-offset-3">
            <div class="form-group circle_select_div">
                <select name="state" id="state" class="form-control">
                    <option value="1"><?php echo $this->lang->line('campaigns_shedule_campaign'); ?></option>
                    <option value="2"><?php echo $this->lang->line('campaigns_send_campaign_now'); ?></option>
                </select>
            </div>
    
        </div>

    </div>
    <div class="row">
        <div class="col-xs-12 col-sm-6 back_save_group exit_back_step">
            <button type="button" class=" btn btn-circle btn-default-back exit_steps"><?php echo $this->lang->line('exit'); ?></button>
            <button type="button" class=" btn btn-circle btn-default-back back_step" data-prev_step="4"><i class="fa fa-arrow-left" aria-hidden="true"></i> <?php echo $this->lang->line('back'); ?></button>
        </div>
        <div class="col-xs-12 col-sm-6 back_save_group">
            <button type="button" class="btn btn-danger btn-circle" id="cancel_campaign"><?php echo $this->lang->line('cancel');?></button>
            <button type="button" class="btn  btn-primary btn-circle  finish_steps" id="finish_steps"><?php echo $this->lang->line('finish'); ?></button>
        </div>
    </div>

</div>