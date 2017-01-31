<div class="external_data_step3">
    <div class="row margin-top-20 step_header">

        <h2 class="text-center step_title"><?php echo $this->lang->line('advanced_settings_step_title_3'); ?></h2>

    </div>

    <div class=" margin-top-20">
        <div class="col-xs-12 text-center col-sm-6 col-sm-offset-3">
        <div class="form-horizontal">
            <div class="form-group">
                <h4><?php echo $this->lang->line('advanced_settings_items_count_for'); ?> <span id="items_count"></span></h4>
                <p><?php echo $this->lang->line('are_you_sure'); ?></p>
            </div>
            <?php
            $check_section = false;
            if(!empty($fields)){
                foreach($fields as $k=>$field){
                    if(!empty($field)){
                        if($import_model_id == 1 || $import_model_id == 2 || $import_model_id == 5){ //Students or Companies or Prospect
                            if($field == 'email' || $field == 'cdnicif'){
                                $check_section = true;
                                break;
                            }
                        }else if($import_model_id == 3){ //Teachers
                            if($field == 'email'){
                                $check_section = true;
                                break;
                            }
                        }else if($import_model_id == 4){ //Courses
                            if($field == 'codigo'){
                                $check_section = true;
                                break;
                            }
                        }else if($import_model_id == 5){ //Contacts
                            if($field == 'email' || $field == 'nif'){
                                $check_section = true;
                                break;
                            }
                        }
                    }
                }
            }
            if($check_section){ ?>
            <div class="form-group">
                <input type="checkbox" name="q1" id="q1">
                <lable for="q1"><?php echo $this->lang->line('advanced_settings_check_fields_q1'); ?></lable>
            </div>
            <div class="q_content" id="q1_content" style="display:none;">
                <div class="form-group">
                    <lable for="q2_answer"><?php echo $this->lang->line('advanced_settings_check_fields_q2'); ?></lable>
                    <br />
                    <input type="radio" name="q2_answer" value="1" checked> <?php echo $this->lang->line('yes'); ?><br>
                    <input type="radio" name="q2_answer" value="0"> <?php echo $this->lang->line('no'); ?><br>
                </div>
                <form class="col-xs-12" id="check_import_data_form">
                    <?php
                    if(!empty($fields)){
                        foreach($fields as $k=>$field){

                            if(!empty($field)){
                                if($import_model_id == 1 || $import_model_id == 2 || $import_model_id == 5){ //Students or Companies or Prospects
                                    if($field == 'email' || $field == 'cdnicif'){
                                    ?>
                                    <div class="col-xs-3 text-left">
                                        <lable for="c_<?php echo $field; ?>"><?php echo ucfirst($k); ?></lable>
                                        <input
                                            type="checkbox"
                                            value="<?php echo $field; ?>"
                                            name="fields[]"
                                            id="c_<?php echo $field; ?>" />
                                    </div>
                                <?php }
                                }else if($import_model_id == 3){ //Teachers
                                    if($field == 'email'){
                                        ?>
                                        <div class="col-xs-3 text-left">
                                            <lable for="c_<?php echo $field; ?>"><?php echo ucfirst($k); ?></lable>
                                            <input
                                                type="checkbox"
                                                value="<?php echo $field; ?>"
                                                name="fields[]"
                                                id="c_<?php echo $field; ?>" />
                                        </div>
                                <?php }
                                }else if($import_model_id == 4){ //Courses
                                    if($field == 'codigo'){
                                        ?>
                                        <div class="col-xs-3 text-left">
                                            <lable for="c_<?php echo $field; ?>"><?php echo ucfirst($k); ?></lable>
                                            <input
                                                type="checkbox"
                                                value="<?php echo $field; ?>"
                                                name="fields[]"
                                                id="c_<?php echo $field; ?>" />
                                        </div>
                                    <?php }
                                }else if($import_model_id == 5){ //Contacts
                                    if($field == 'email' || $field == 'nif'){
                                        ?>
                                        <div class="col-xs-3 text-left">
                                            <lable for="c_<?php echo $field; ?>"><?php echo ucfirst($k); ?></lable>
                                            <input
                                                type="checkbox"
                                                value="<?php echo $field; ?>"
                                                name="fields[]"
                                                id="c_<?php echo $field; ?>" />
                                        </div>
                                    <?php }
                                }
                                ?>
                            <?php }
                        }
                    }
                    ?>
                </form>
            </div>
            <?php } ?>
        </div>
    </div>
        <div class="row">
            <div class="col-xs-12 col-sm-6 back_save_group exit_back_step">
                <button type="button" class="btn btn-circle btn-default-back exit_steps"><?php echo $this->lang->line('exit'); ?></button>
                <button type="button" class="btn btn-circle btn-default-back back_step" data-prev_step="2"><i class="fa fa-arrow-left" aria-hidden="true"></i>  <?php echo $this->lang->line('back'); ?></button>
           </div>
            <div class="col-xs-12 col-sm-6 back_save_group">
                <button type="button" class="btn btn-danger btn-circle" id="cancel_import"><?php echo $this->lang->line('cancel');?></button>
                <button type="button" class="btn  btn-primary btn-circle  finish_steps" id="finish_steps"><?php echo $this->lang->line('finish'); ?></button>
            </div>
        </div>
    </div>
</div>

<script src="<?php echo base_url(); ?>app/js/advanced_settings/partials/ied_step3.js"></script>
