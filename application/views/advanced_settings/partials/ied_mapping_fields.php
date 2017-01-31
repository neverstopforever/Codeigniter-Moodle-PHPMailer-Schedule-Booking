    <div class="col-xs-12 col-sm-6 col-sm-offset-3">
        <form method="post" class="form-horizontal" id="import_data_form">
        <?php if(!empty($import_data['fields'])){
            foreach ($import_data['fields'] as $k=>$item) { ?>
                <div class="form-group text-left circle_select_div">
                    <lable for="<?php echo $item; ?>"><?php echo ucfirst($item); ?></lable>
                    <select name="<?php echo $item; ?>" id="<?php echo $item; ?>" class="form-control">
                        <option value="" data-table="">--<?php echo $this->lang->line('advanced_settings_select_column'); ?>--</option>
                        <?php
                        if(!empty($fields)){
                            foreach($fields as $field){
                                $required = ($field->required == 1) ? 'style="color:red;"' : '';
                                ?>
                                <option value="<?php echo $field->field; ?>"
                                        data-table="<?php echo $field->table; ?>"
                                        data-id="<?php echo $field->id; ?>" <?php echo $required; ?>>
                                    <?php echo $field->alias; ?>

                                </option>
                            <?php  }
                        }
                        ?>
                    </select>
                </div>
            <?php }
        }?>
        </form>
    </div>