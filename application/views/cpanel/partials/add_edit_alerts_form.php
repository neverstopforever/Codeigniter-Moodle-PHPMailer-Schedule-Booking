<form class="alerts_add_form col-md-5" action="<?php echo base_url(); ?>cpanel/<?php echo $action;?>/<?php echo $data->id; ?>" method="POST">
    <ul>
        <li><a data-toggle="tab"><?php echo $this->lang->line('cpanel_data'); ?></a></li>
    </ul>


    <div class="col-md-12">
        <div class="form-group circle_select_div">
            <label>
                <?php echo $this->lang->line('cpanel_company') ?>
                <select name="idcliente" class="form-control">
                    <option value="" <?php if (set_value('idcliente') == 0){echo 'selected="selected"';}?>><?php echo $this->lang->line('cpanel_all'); ?></option>
                    <?php foreach($companies as $company){ ?>
                        <option value="<?php echo $company->Customer_id;?>" <?php if (set_value('idcliente', $data->idcliente) == $company->Customer_id){echo 'selected="selected"';}?>><?php echo $company->Company;?></option>
                    <?php }?>
                </select>
            </label>
        </div>

        <div class="form-group circle_select_div">
            <label>
                <?php echo $this->lang->line('cpanel_read'); ?>
            </label>
                <select name="read" class="form-control">
                    <option value="0" <?php if (set_value('read',$data->read) == 0){echo 'selected="selected"';}?>><?php echo $this->lang->line('no');?></option>
                    <option value="1" <?php if (set_value('read',$data->read) == 1){echo 'selected="selected"';}?>><?php echo $this->lang->line('yes');?></option>
                </select>

        </div>

        <div class="form-group min_max_seats">
            <div class="col-md-6">
                <label>
                    <?php echo $this->lang->line('cpanel_startdate'); ?>
                </label>
                    <input type="date" name="startdate"  value="<?php echo set_value('startdate', $data->startdate); ?>" class="form-control" />

                <?php echo form_error('startdate'); ?>
            </div>
            <div class="col-md-6">
                <label>
                    <?php echo $this->lang->line('cpanel_enddate'); ?>
                </label>
                    <input type="date" name="enddate"  value="<?php echo set_value('enddate', $data->enddate); ?>" class="form-control" />

                <?php echo form_error('enddate'); ?>
            </div>
        </div>

        <div class="form-group">
            <label>
                <?php echo $this->lang->line('cpanel_title'); ?>
            </label>
                <input type="text" name="title"  value="<?php echo set_value('title', $data->title); ?>" class="form-control" />

            <?php echo form_error('title'); ?>
        </div>

        <div class="form-group" id="toastTypeGroup">
            <div class="form-md-radios">
                <label><?php echo $this->lang->line('cpanel_toast'); ?></label>
                <div class="radio-list md-radio-list">
                    <div class="md-radio has-success">
                        <input value="success" id="radio1" name="toast" class="md-radiobtn"  type="radio" <?php echo (set_value('toast', $data->toast) == 'success') ? 'checked="checked"': "";?> />
                        <label for="radio1">
                            <span></span>
                            <span class="check"></span>
                            <span class="box"></span> <?php echo $this->lang->line('cpanel_success'); ?>
                        </label>
                    </div>

                    <div class="md-radio has-info">
                        <input value="info" id="radio2" name="toast" class="md-radiobtn"    type="radio" <?php echo (set_value('toast', $data->toast) == 'info') ? 'checked="checked"': "";?> />
                         <label for="radio2">
                            <span></span>
                            <span class="check"></span>
                            <span class="box"></span>
                            <?php echo $this->lang->line('cpanel_info'); ?>
                        </label>
                    </div>
                    <div class="md-radio has-warning">
                        <input value="warning" name="toast" id="radio3" class="md-radiobtn"  type="radio" <?php echo (set_value('toast', $data->toast) == 'warning') ? 'checked="checked"': "";?> />
                        <label for="radio3">
                            <span></span>
                            <span class="check"></span>
                            <span class="box"></span>
                            <?php echo $this->lang->line('cpanel_warning'); ?>
                        </label>
                    </div>
                    <div class="md-radio has-error">
                        <input value="error" name="toast" id="radio4" class="md-radiobtn"   type="radio" <?php echo (set_value('toast', $data->toast) == 'error') ? 'checked="checked"': "";?> />
                        <label for="radio4">
                            <span></span>
                            <span class="check"></span>
                            <span class="box"></span>
                            <?php echo $this->lang->line('cpanel_error'); ?></label>
                    </div>
                </div>
                <?php echo form_error('toast'); ?>
            </div>
        </div>

    </div>

    <div class="col-md-12">
        <div class="form-group circle_select_div">
            <label>
                <?php echo $this->lang->line('cpanel_message'); ?>
            </label>
                <textarea class="form-control" name = "message" ><?php echo set_value('message', $data->message); ?></textarea>

            <?php echo form_error('message'); ?>
        </div>
    </div>

    <div class="col-md-12 wizard-footer">
        <div class="form-group back_save_group text-left ">
            <a href="<?php echo base_url('cpanel/alerts'); ?>" class="btn-sm btn btn-circle btn-default-back back_system_settigs"><?php echo $this->lang->line('back'); ?></a>
            <button class="btn btn-sm btn-primary btn-circle " type="submit">
                <?php
                if($action == 'addAlert'){
                    echo $this->lang->line('cpanel_addBtn');
                }elseif($action == 'editAlert'){
                    echo $this->lang->line('cpanel_editBtn');
                } ?>
            </button>
            <a href="<?php echo base_url('cpanel/alerts'); ?>" class="btn-sm btn btn-circle btn-default-back back_system_settigs_min "><?php echo $this->lang->line('back'); ?></a>

        </div>

    </div>

</form>