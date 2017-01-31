<?php if(!empty($controller_lists)){ ?>
<hr />
<form class="form-horizontal" action="<?php echo base_url(); ?>cpanel/edit_plan_options/<?php echo $plan_id; ?>" method="POST" id="change_permission_form">

    <div>
            <?php
            foreach($controller_lists as $controller_name=>$default_plans){ ?>
            <div class="col-xs-6 col-sm-4 col-md-3">
                <div class="form-group">
                    <?php $checked = ''; $def_plan = true;
                    foreach($plan_options as $plan_option){
                        $option_value = str_replace("/", "", $plan_option->option_value);
                        if (strtolower(trim($option_value)) == strtolower($controller_name)) {
                            $checked = 'checked="checked"';
                            if(!in_array($plan_type, $default_plans)){
                                $def_plan = false;
                            }
                            break;
                        }
                    }
                    ?>

                    <div class="md-checkbox">
                        <input type="checkbox" class="<?php echo  !$def_plan && $checked != '' ? 'not_default' : ''; ?>" id="id_<?php echo $controller_name;?>" name="<?php echo $controller_name;?>"  value="<?php echo set_value($controller_name, $controller_name); ?>" <?php echo $checked; ?>  />
                        <label for="id_<?php echo $controller_name; ?>">
                            <span class="inc"></span>
                            <span class="check" style="<?php echo  !$def_plan && $checked != '' ? 'border: 2px solid #f35656; border-top: none; border-left: none;' : ''; ?>"></span>
                            <span class="box"></span>
                            <?php echo trim($controller_name); ?>
                        </label>
                    </div>
                </div>
            </div>
            <?php  } ?>
            <div class="clearfix"></div>
            <div class="back_save_group margin-bottom-20 text-right">
                <button type="submit" class="btn btn-primary btn-circle " id="change_permission"><?php echo $this->lang->line('save');?></button>
            </div>
    </div>

</form>

<?php } ?>