<form class="alerts_add_form" action="<?php echo base_url(); ?>alerts/<?php echo $action;?>/<?php echo $data->id; ?>" method="POST">
    <ul>
        <li><a data-toggle="tab"><?php echo $this->lang->line('alerts_data'); ?></a></li>
    </ul>


    <div class="col-md-6">
        <div class="form-group">
            <label>
                <?php echo $this->lang->line('alerts_company') ?>
                <select name="idcliente" class="form-control">
                    <option value="" <?php if (set_value('idcliente') == 0){echo 'selected="selected"';}?>><?php echo $this->lang->line('alerts_all'); ?></option>
                    <?php foreach($companies as $company){ ?>
                        <option value="<?php echo $company->Customer_id;?>" <?php if (set_value('idcliente', $data->idcliente) == $company->Customer_id){echo 'selected="selected"';}?>><?php echo $company->Company;?></option>
                    <?php }?>
                </select>
            </label>
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            <label>
                <?php echo $this->lang->line('alerts_read'); ?>
                <select name="read" class="form-control">
                    <option value="0" <?php if (set_value('read',$data->read) == 0){echo 'selected="selected"';}?>><?php echo $this->lang->line('no');?></option>
                    <option value="1" <?php if (set_value('read',$data->read) == 1){echo 'selected="selected"';}?>><?php echo $this->lang->line('yes');?></option>
                </select>
            </label>
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            <label>
                <?php echo $this->lang->line('alerts_startdate'); ?>
                <input type="date" name="startdate"  value="<?php echo set_value('startdate', $data->startdate); ?>" class="form-control" />
            </label>
            <?php echo form_error('startdate'); ?>
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            <label>
                <?php echo $this->lang->line('alerts_enddate'); ?>
                <input type="date" name="enddate"  value="<?php echo set_value('enddate', $data->enddate); ?>" class="form-control" />
            </label>
            <?php echo form_error('enddate'); ?>
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            <label>
                <?php echo $this->lang->line('alerts_title'); ?>
                <input type="text" name="title"  value="<?php echo set_value('title', $data->title); ?>" class="form-control" />
            </label>
            <?php echo form_error('title'); ?>
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group" id="toastTypeGroup">
            <label><?php echo $this->lang->line('alerts_toast'); ?></label>
            <div class="radio-list my_radio_list">
                <label>
                    <div class="radio "><span class="checked">
                                                            <input value="success" name="toast"   type="radio" <?php echo (set_value('toast', $data->toast) == 'success') ? 'checked="checked"': "";?> />
                                                        </span></div> <?php echo $this->lang->line('alerts_success'); ?>
                </label>
                <label>
                    <div class="radio"><span class="">
                                                        <input value="info" name="toast"   type="radio" <?php echo (set_value('toast', $data->toast) == 'info') ? 'checked="checked"': "";?> />
                                                        </span></div> <?php echo $this->lang->line('alerts_info'); ?></label>
                <label>
                    <div class="radio"><span class="">
                                                        <input value="warning" name="toast"   type="radio" <?php echo (set_value('toast', $data->toast) == 'warning') ? 'checked="checked"': "";?> />
                                                        </span></div> <?php echo $this->lang->line('alerts_warning'); ?></label>
                <label>
                    <div class="radio"><span class="">
                                                        <input value="error" name="toast"   type="radio" <?php echo (set_value('toast', $data->toast) == 'error') ? 'checked="checked"': "";?> />
                                                        </span></div> <?php echo $this->lang->line('alerts_error'); ?></label>
            </div>
            <?php echo form_error('toast'); ?>
        </div>
    </div>

    <div class="col-md-12">
        <div class="form-group">
            <label>
                <?php echo $this->lang->line('alerts_message'); ?>
                <textarea class="form-control" name = "message" ><?php echo set_value('message', $data->message); ?></textarea>
            </label>
            <?php echo form_error('message'); ?>
        </div>
    </div>



    <div class="col-md-12 wizard-footer">
        <div class="pull-right">
            <button class="btn btn-success " type="submit">
                <?php
                if($action == 'add'){
                    echo $this->lang->line('alerts_addBtn');
                }elseif($action == 'edit'){
                    echo $this->lang->line('alerts_editBtn');
                } ?>
            </button>
        </div>
    </div>

</form>