<div class="row margin-top-20 step_header">

    <h2 class="text-center step_title"><?php echo $this->lang->line('advanced_settings_step_title_1');?></h2>

</div>
<div class="row margin-top-20 step_content">
    <div class="col-xs-12 col-sm-6 col-sm-offset-3">
        <div class="form-group circle_select_div">
            <label for="import_model_id" class=" control-label"><?php echo $this->lang->line('_model'); ?></label>
                <select name="import_model_id" id="import_model_id" class="form-control">
                    <option value="" data-table="">--<?php echo $this->lang->line('advanced_settings_select_model'); ?>--</option>
                    <?php
                    if(!empty($import_models)){
                        foreach($import_models as $import_model){
                            $title = $import_model->title;
                            if($this->lang->line($import_model->title) ){
                                $title = $this->lang->line($import_model->title);
                            }
                            ?>
                            <option value="<?php echo $import_model->id; ?>" data-table="<?php echo $import_model->table; ?>"><?php echo $title; ?></option>
                        <?php  }
                    }
                    ?>
                </select>
        </div>
        <div class="col-md-12 text-left back_save_group">
            <button type="button" class="btn btn-circle btn-default-back exit_steps"><?php echo $this->lang->line('exit'); ?></button>
            <button type="button" class="btn btn-primary btn-circle  continue_step" data-next_step="2"><?php echo $this->lang->line('continue'); ?> <i class="fa fa-arrow-right" aria-hidden="true"></i></button>
        </div>
    </div>
</div>