<div class="row margin-top-20 step_header">
    <h2 class="text-center step_title"><?php echo $this->lang->line('campaigns_step_title_1');?></h2>

</div>
<div class="row margin-top-20 step_content base_info_step">
    <div class="col-xs-12 col-sm-6 col-sm-offset-3 ">
        <div class="form-group">
            <label for="title" ><?php echo $this->lang->line('campaigns_name_new_campaign'); ?> <i class="text-danger">*</i>
                    <input type="text" name="title" id="title" class="form-control" value="" />
            </label>
        </div>
        <div class="form-group circle_select_div">
            <label for="id_folder" class="control-label"><span class="id_folder_label"><?php echo $this->lang->line('folder'); ?></span>

                 <select name="id_folder" id="id_folder" class="form-control margin-top-10 form-control-campaign-folder">
                    <?php
                    if(!empty($folders)){
                        foreach($folders as $folder){ ?>
                            <option value="<?php echo $folder->id_folder; ?>"><?php echo $folder->title; ?></option>
                        <?php  }
                    }
                    ?>
                </select>
                <a href="#" class="btn btn-circle btn-default-back" id="add_folder">+ <?php echo $this->lang->line('campaigns_new_folder'); ?></a>

            </label>
        </div>
        <div class="form-group">
            <label for="date_sending"><?php echo $this->lang->line('campaigns_new_date_sending'); ?>

                <input type="text" name="date_sending" id="date_sending" class="form-control" value="" />

            </label>
        </div>
        <div class="col-md-12 text-left back_save_group">
            <button type="button" class="btn btn-circle btn-default-back exit_steps"><?php echo $this->lang->line('exit'); ?></button>
            <button type="button" class="btn btn-primary btn-circle  continue_step" data-next_step="2"><?php echo $this->lang->line('continue'); ?> <i class="fa fa-arrow-right" aria-hidden="true"></i></button>
        </div>
    </div>
</div>