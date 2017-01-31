<?php if(isset($medios) && !empty($medios)){ ?>
    <div class="form-group circle_select_div">
        <label for="medios_fields"><?php echo $this->lang->line('medio'); ?>: </label>
        <select name="medios_fields" id="medios_fields" class="form-control">
<!--            <option value="">----><?php //echo $this->lang->line('form_online_select_medio'); ?><!----</option>-->
            <?php
            foreach($medios as $k=>$medio){?>
                <option value="<?php echo $medio->IdMedio;?>"><?php echo $medio->Descripcion;?></option>
            <?php } ?>
        </select>
    </div>
<?php }?>

<div class="form-group">
        <strong><?php echo $this->lang->line('form_online_form_submission_behavior'); ?>:</strong>
</div>
<div class="form-group">
        <label for="_url‐error"><?php echo $this->lang->line('form_online_url_error_title'); ?>: </label>
        <input type="text" id="_url‐error" name="_url‐error" class="form-control url_err_des" placeholder="<?php echo $this->lang->line('form_online_url_error_title'); ?>">
</div>
<div class="form-group">
        <label for="_url‐destino"><?php echo $this->lang->line('form_online_url_destino_title'); ?>: </label>
        <input type="text" id="_url‐destino" name="_url‐destino" class="form-control url_err_des" placeholder="<?php echo $this->lang->line('form_online_url_destino_title'); ?>">
</div>

<div class="form-group circle_select_div">
        <label for="select_fields"><?php echo $this->lang->line('fields'); ?>: </label>
        <select name="select_fields" id="select_fields" class="form-control">
                <option value="">--<?php echo $this->lang->line('form_online_select_source'); ?>--</option>
                <?php if(!empty($select_fields)){
                        foreach($select_fields as $k=>$select_field){ ?>
                                <option value="<?php echo $k;?>"><?php echo $select_field;?></option>
                        <?php }
                }?>
        </select>
</div>
<?php if(isset($courses) && !empty($courses)){ ?>
<div class="form-group">
        <label for="courses_fields"><?php echo $this->lang->line('course'); ?>: </label>
    <input type="text"  id="courses_fields" class="form-control">
</div>
<?php }?>
<?php if(!empty($tags)){ ?>
    <div class="form-group">
        <label for="courses_fields"><?php echo $this->lang->line('tags'); ?>: </label>
        <input type="text"  id="tags_fields" class="form-control">
    </div>
<?php }?>

<div class="form-group margin-top-20 margin-bottom-20">
    <div class="md-checkbox">
        <input type="checkbox" id="s_validate_data" name="s_validate_data" class="md-check" value="1">
        <label for="s_validate_data">
            <?php echo $this->lang->line('form_online_validate_data'); ?>
            <span></span>

            <span class="check"></span>

            <span class="box"></span>
        </label>

    </div>
</div>
<div class="form-group">
    <p><strong><?php echo $this->lang->line('form_online_drag_drop_title'); ?></strong></p>
        <ol id="s_fileds" class="s_filedsSortable">
                <li class="ui-state-default " id="s_nombre" data-field="nombre" data-lable="<?php echo $this->lang->line('first_name'); ?>"><?php echo $this->lang->line('first_name'); ?></li>
                <li class="ui-state-default" id="s_email" data-field="email" data-lable="<?php echo $this->lang->line('email'); ?>"><?php echo $this->lang->line('email'); ?></li>
        </ol>
</div>

<div class="form-group">
      <div id="fields_prev"></div>
</div>

<div class="form-group">
        <p><strong><?php echo $this->lang->line('form_online_gen_form_title'); ?></strong></p>
        <textarea id="generated_form" class="form-control" placeholder="generated form" rows="20"></textarea>
</div>
<div id="viewForm" style="display: none">
    <p><strong><?php echo $this->lang->line('form_online_view'); ?></strong></p>
    <div style="border: 1px solid #ccc" id="view_form" placeholder="generated form" rows="20"></div>
</div>

<div class="form-group back_save_group">
       <input type="hidden"  id="api_key" name="api_key" value="<?php echo $api_key; ?>">
        <a type="button" href="/advancedSettings" class="btn btn-circle btn-default-back  margin-right-10 back_system_settigs "> <i class="fa fa-arrow-left" aria-hidden="true"></i> <?php echo $this->lang->line('back'); ?> </a>
       <input type="button" class="btn btn-primary btn-circle pull-right margin-top-20" id="generate_page" value="<?php echo $this->lang->line('form_online_generate_page'); ?>"/>
       <input type="button" class="btn btn-success btn-circle pull-right margin-top-20" id="view_page" value="<?php echo $this->lang->line('form_online_preview'); ?>"/>
       <input type="button" class="btn btn-success btn-circle pull-right margin-top-20 hidden" id="view_code" value="<?php echo $this->lang->line('form_online_viewcode'); ?>"/>
        <a type="button" href="/email_templates" class="btn btn-circle btn-default-back  margin-right-10 back_system_settigs_min"> <i class="fa fa-arrow-left" aria-hidden="true"></i> <?php echo $this->lang->line('back'); ?></a>
</div>
<script>
    var _courses = <?php echo json_encode($courses);?>;
    var _tags = <?php echo json_encode($tags);?>;
</script>