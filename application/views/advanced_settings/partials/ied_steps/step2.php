<div class="external_data_step2">
<div class="row margin-top-20 step_header">
    <h2 class="text-center step_title"><?php echo $this->lang->line('advanced_settings_step_title_2');?></h2>
</div>

<div class="row margin-top-20 text-center">
    <div class="col-xs-12 col-sm-6 col-sm-offset-3">
        <p>
            <?php echo $this->lang->line('advanced_settings_file_valid_format'); ?>
        </p>
        <div class="form-group form-md-radios import_file_section" style="display: none">
            <div class="col-md-7">
                <botton type="button" class="btn  btn-success btn-circle import_file margin-bottom-10" > <i class="fa fa-plus" aria-hidden="true"></i> <?php echo $this->lang->line('import_file'); ?></botton>
            </div>
            <label class="col-md-3 control-label no-padding" for="form_control_1"><?php echo $this->lang->line('choose_delimiter'); ?></label>
            <div class="col-md-2">
                <div class="md-radio-list">
                    <div class="md-radio">
                        <input type="radio" id="checkbox1_6" name="delimiter" value="1" checked class="md-radiobtn">
                        <label for="checkbox1_6">
                            <span class="inc"></span>
                            <span class="check"></span>
                            <span class="box"></span> , </label>
                    </div>
                    <div class="md-radio">
                        <input type="radio" id="checkbox1_7" name="delimiter" value="2" class="md-radiobtn">
                        <label for="checkbox1_7">
                            <span class="inc"></span>
                            <span class="check"></span>
                            <span class="box"></span> ; </label>
                    </div>
                </div>
            </div>

        </div>

        <form method="post" enctype="multipart/form-data" id="import_file_form">
            <div class="fileinput fileinput-new" data-provides="fileinput">
                <div class="input-group input-large">
                    <div class="form-control uneditable-input input-fixed input-medium" data-trigger="fileinput">
                        <i class="fa fa-file fileinput-exists"></i>&nbsp;
                        <span class="fileinput-filename"></span>
                    </div>
                <span class="input-group-addon btn default btn-file">
                    <span class="fileinput-new"> <?php echo $this->lang->line('select_file'); ?> </span>
                    <span class="fileinput-exists"> <?php echo $this->lang->line('_change'); ?> </span>
                    <input type="hidden" value="" name="import_file_hidden" id="import_file_hidden">
                    <input type="file" name="import_file" id="import_file">
                </span>
                    <a href="javascript:;" class="input-group-addon btn red fileinput-exists" data-dismiss="fileinput"> <?php echo $this->lang->line('_remove'); ?> </a>
                </div>
            </div>

        </form>
    </div>

    <div class="" id="mapping_fileds">
        
    </div>
</div>
<div class="row margin-top-20">
    <div class="col-xs-12 col-sm-6 back_save_group exit_back_step">
        <button type="button" class="btn btn-circle btn-default-back exit_steps"><?php echo $this->lang->line('exit'); ?></button>
        <button type="button" class="btn btn-circle btn-default-back back_step" data-prev_step="1"><i class="fa fa-arrow-left" aria-hidden="true"></i> <?php echo $this->lang->line('back'); ?></button>
    </div>
    <div class="col-xs-12 col-sm-6 back_save_group">
        <button type="button" class="btn  btn-primary btn-circle continue_step" data-next_step="3"><?php echo $this->lang->line('continue'); ?> <i class="fa fa-arrow-right" aria-hidden="true"></i></button>
    </div>
</div>
<script src="<?php echo base_url(); ?>app/js/advanced_settings/partials/ied_step2.js"></script>