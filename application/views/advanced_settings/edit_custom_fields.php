<div class="page-container system_settings custom_field_edit_page">
   <div class="page-content tags">
        <div class="<?php echo $layoutClass ?>">
            <ul class= "page-breadcrumb breadcrumb">
                <li>
                    <a href="<?php echo $_base_url; ?>" ><?php echo $this->lang->line('menu_Home'); ?></a>
                </li>
                <li>
                    <a href="<?php echo $_base_url; ?>advancedSettings"><?php echo $this->lang->line('menu_advanced_settings'); ?> </a>
                </li>
                <li >
                    <a href="<?php echo $_base_url; ?>advancedSettings/custom_fields"> <?php echo $this->lang->line('advanced_settings_custom_fields'); ?></a>
                </li>
                <li class="active">
                    <?php echo $this->lang->line('edit'); ?>
                </li>
            </ul>
   <div class="portlet light" >
<div class="row">
   
        <form id="customfield-form" class="col-md-5 " action="<?= base_url()?>advancedSettings/updateField/<?php echo $editfields->id;?>" method="post" >
            <div class="col-md-12">
                <div class="form-group circle_select_div">
                  <label classs="form-lable"> <small class="req text-danger">* </small><?php echo $this->lang->line('fields_field_belongto'); ?></label>
                    <select required="" name="form_type" class="form-control" >
                        <option value=""> <?php echo $this->lang->line('fields_select_form_type'); ?></option>
                        <option value="contacts" <?php if($editfields->form_type=="contacts"){echo 'selected=selected';} ?>><?php echo $this->lang->line('contacts'); ?></option>
                        <option value="leads" <?php if($editfields->form_type == "leads"){echo 'selected=selected';} ?>><?php echo $this->lang->line('leads'); ?></option>
                        <option value="course" <?php if($editfields->form_type == "course"){echo 'selected=selected';} ?>><?php echo $this->lang->line('course'); ?></option>
                        <option value="companies" <?php if($editfields->form_type=="companies"){echo 'selected=selected';} ?>><?php echo $this->lang->line('Companies'); ?></option>
                        <option value="students" <?php if($editfields->form_type=="students"){echo 'selected=selected';} ?>><?php echo $this->lang->line('Students'); ?></option>
                        <option value="teachers" <?php if($editfields->form_type=="teachers"){echo 'selected=selected';} ?>><?php echo $this->lang->line('Teachers'); ?></option>
                        <option value="groups" <?php if($editfields->form_type=="groups"){echo 'selected=selected';} ?>><?php echo $this->lang->line('groups'); ?></option>
                        <option value="enrollments" <?php if($editfields->form_type=="enrollments"){echo 'selected=selected';} ?>><?php echo $this->lang->line('Enrollments'); ?></option>
                        <option value="events" <?php if($editfields->form_type=="events"){echo 'selected=selected';} ?>><?php echo $this->lang->line('events'); ?></option>
                    </select>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                  <label classs="form-lable"> <small class="req text-danger">* </small><?php echo $this->lang->line('fields_field_name'); ?> </label>
                    <input type="text" placeholder="" id="field-5" class="form-control" name="field_name" required="" value="<?php echo $editfields->field_name;?>" />
               </div>
            </div>
            <div class="col-md-12 ">
                <div class="circle_select_div form-group" >
                  <label classs="form-lable"> <small class="req text-danger">* </small><?php echo $this->lang->line('fields_field_type'); ?> </label>
                    <select name="field_type" id="field_type" class="form-control" required="">
                        <option value=""> <?php echo $this->lang->line('fields_select_field_type'); ?></option>
                        <option value="input" <?php if($editfields->field_type=="input"){echo 'selected=selected';} ?>><?php echo $this->lang->line('fields_input'); ?></option>
                        <option value="textarea" <?php if($editfields->field_type=="textarea"){echo 'selected=selected';} ?>><?php echo $this->lang->line('fields_textarea'); ?></option>
                        <option value="datepicker" <?php if($editfields->field_type=="datepicker"){echo 'selected=selected';} ?>><?php echo $this->lang->line('fields_date_picker'); ?></option>
                        <option value="select" <?php if($editfields->field_type=="select"){echo 'selected=selected';} ?>><?php echo $this->lang->line('fields_select'); ?></option>
                        <option value="checkbox" <?php if($editfields->field_type=="checkbox"){echo 'selected=selected';} ?>><?php echo $this->lang->line('fields_checkBox'); ?></option>

                    </select>
                </div>
            </div>
            <?php if($editfields->field_type == "select"){ $display = "block";  $disable = "";}else{ $display = "none";$disable = "disabled"; }?>
          <div class="col-md-12 options_class" style="display:<?php echo $display;?>">
                  <div class="circle_select_div form-group" >
                    <label classs="form-lable"> <small class="req text-danger">* </small> <?php echo $this->lang->line('fields_options'); ?></label>
                    <textarea class="form-control" id="options" name="options" <?php echo $disable;?>><?php echo $editfields->options;?></textarea>
                       <?php echo $this->lang->line('fields_value_with_comma'); ?>
                      <?php echo $this->lang->line('fields_options'); ?>
                  </div>
              </div>
            <div class="col-md-12 margin-top-20">
                <div class="form-group">
                    <div class="md-checkbox">
                        <input id="disabled" name="disabled" type="checkbox" value=1 <?php if($editfields->disabled== 1){echo 'checked=checked';} ?> >
                        <label for="disabled">
                            <span></span>
                            <span class="check"></span>
                            <span class="box"></span>
                            <?php echo $this->lang->line('fields_disabled'); ?>
                        </label>
                    </div>

               </div>
            </div>

            <div class="col-md-12">
                <div class="form-group">
                    <div class="md-checkbox">
                        <input id="only_admin" name="only_admin" type="checkbox" value=1 <?php if($editfields->only_admin== 1){echo 'checked=checked';} ?>>
                        <label for="only_admin">
                            <span></span>
                            <span class="check"></span>
                            <span class="box"></span>
                            <?php echo $this->lang->line('fields_restriction_administrators_only'); ?>
                        </label>
                    </div>
               </div>
            </div>

            <div class="col-md-12">
                <div class="form-group">
                    <div class="md-checkbox">
                       <input id="required" name="required" type="checkbox" value=1 <?php if($editfields->required== 1){echo 'checked=checked';} ?>>
                      <label for="required">
                          <span></span>
                          <span class="check"></span>
                          <span class="box"></span>
                          <?php echo $this->lang->line('fields_required'); ?>
                      </label>
                    </div>
               </div>
            </div>
            
            <div class="col-md-12" id="allow_students_field" style="display: none">
                <div class="form-group">
                    <div class="md-checkbox">
                        <input id="allow_students" name="allow_students" type="checkbox" value=1 <?php if($editfields->allow_students== 1){echo 'checked=checked';} ?>>
                        <label for="allow_students">
                            <span></span>
                            <span class="check"></span>
                            <span class="box"></span>
                            <?php echo $this->lang->line('fields_allow_students'); ?>
                        </label>
                    </div>
                </div>
            </div>
            
            <div class="col-md-12">
                <p class="bold text-info"><?php echo $this->lang->line('fields_status'); ?></p>
            </div>
             <div class="col-md-12">
                <div class="form-group circle_select_div">
<!--                <select id="active" class="form-control" name="active">
                  <option value="1" <?php /*if($editfields->active== 1){echo 'selected';} */?>>Active</option>
                  <option value="0" <?php /*if($editfields->active== 0){echo 'selected';} */?>>Deactive</option>
                </select>-->
                    <input type="checkbox" class="bootstrap-switch" value="<?php echo $editfields->active; ?>" name="active"/>
                    <input type="hidden" value="<?php echo $editfields->active; ?>" name="active_hidden"/>
               </div>
            </div>

            <div class="col-md-12 text-left back_save_group">
                <a href="<?= base_url() ?>advancedSettings/custom_fields" class="btn-sm btn btn-circle btn-default-back back_teachers xs_hide"> <i class="fa fa-arrow-left" aria-hidden="true"></i> <?php echo $this->lang->line('back'); ?></a>
                <button  type="submit" class="btn btn-sm btn-primary btn-circle"> <?php echo $this->lang->line('update'); ?></button>
                <a href="<?= base_url() ?>advancedSettings/custom_fields" class="btn-sm btn btn-circle btn-default-back back_teachers xs_show"> <i class="fa fa-arrow-left" aria-hidden="true"></i> <?php echo $this->lang->line('back'); ?></a>

            </div>
        </form>
       </div>
       </div>
      </div> 
    </div>

</div>
<div class="clearfix"></div>

<script>
    var state = '<?php echo $editfields->active == 1 ? 1 : 0; ?>';
</script>