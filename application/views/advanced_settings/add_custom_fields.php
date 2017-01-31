<div class="page-container system_settings custom_field_add_page">
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
                    <?php echo $this->lang->line('add'); ?>
                </li>
            </ul>
   <div class="portlet light" >
   <div class="row">
        <form id="customfield-form" class="col-md-5 " action="<?= base_url()?>advancedSettings/addField" method="post" >
            <div class="col-md-12">
                <div class="form-group circle_select_div">
                  <label classs="form-lable"> <small class="req text-danger">* </small><?php echo $this->lang->line('fields_field_belongto'); ?></label>
                    <select required="" name="form_type" class="form-control" >
                    <option value=""><?php echo $this->lang->line('fields_select_form_type'); ?></option>
                    <option value="contacts"><?php echo $this->lang->line('contacts'); ?></option>
                    <option value="leads"><?php echo $this->lang->line('leads'); ?></option>
                     <option value="course"><?php echo $this->lang->line('course'); ?></option>
                    <option value="companies"><?php echo $this->lang->line('Companies'); ?></option>
                    <option value="students"><?php echo $this->lang->line('Students'); ?></option>
                    <option value="teachers"><?php echo $this->lang->line('Teachers'); ?></option>
                    <option value="groups"><?php echo $this->lang->line('groups'); ?></option>
                    <option value="enrollments"><?php echo $this->lang->line('Enrollments'); ?></option>
                    <option value="events" ><?php echo $this->lang->line('events'); ?></option>

                    </select>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                  <label classs="form-lable"> <small class="req text-danger">* </small><?php echo $this->lang->line('fields_field_name'); ?></label>
                    <input type="text" placeholder="" id="field-5" class="form-control " name="field_name" required="" />
               </div>
            </div>
            <div class="col-md-12 ">
                <div class="circle_select_div form-group" >
                  <label classs="form-lable"> <small class="req text-danger">* </small><?php echo $this->lang->line('fields_field_type'); ?>  </label>
                    <select name="field_type" id="field_type" class="form-control" required="">
                    <option value=""> <?php echo $this->lang->line('fields_select_field_type'); ?></option>
                    <option value="input"><?php echo $this->lang->line('fields_input'); ?></option>
                    <option value="textarea"><?php echo $this->lang->line('fields_textarea'); ?></option>
                    <option value="datepicker"><?php echo $this->lang->line('fields_date_picker'); ?></option>
                    <option value="select"><?php echo $this->lang->line('fields_select'); ?></option>
                    <option value="checkbox"><?php echo $this->lang->line('fields_checkBox'); ?></option>
                    </select>
                </div>
            </div>
            <div class="col-md-12 options_class"  style="display:none;">
                <div class="circle_select_div form-group" >
                  <label classs="form-lable"> <small class="req text-danger">* </small><?php echo $this->lang->line('fields_options'); ?> </label>
                  <textarea class="form-control" id="options" name="options"></textarea>
                    <?php echo $this->lang->line('fields_value_with_comma'); ?>

                </div>
            </div>
        
            <div class="col-md-12 margin-top-20">
                <div class="form-group">
                    <div class="md-checkbox">
                       <input id="disabled" name="disabled" type="checkbox" value=1 >
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
                     <input id="only_admin" name="only_admin" type="checkbox" value=1>
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
                      <input id="required" name="required" type="checkbox" value=1>  
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
                        <input id="allow_students" name="allow_students" type="checkbox" value=1 >
                        <label for="allow_students">
                            <span></span>
                            <span class="check"></span>
                            <span class="box"></span>
                            <?php echo $this->lang->line('fields_allow_students'); ?>
                        </label>
                    </div>
                </div>
            </div>

            <div class="col-md-12 text-left back_save_group">
                <a href="<?= base_url() ?>advancedSettings/custom_fields" class="btn-sm btn btn-circle btn-default-back back_teachers xs_hide"> <i class="fa fa-arrow-left" aria-hidden="true"></i> <?php echo $this->lang->line('back'); ?></a>
                <button  type="submit" class="btn btn-sm btn-primary btn-circle"><?php echo $this->lang->line('save'); ?> </button>
                <a href="<?= base_url() ?>advancedSettings/custom_fields" class="btn-sm btn btn-circle btn-default-back back_teachers xs_show"> <i class="fa fa-arrow-left" aria-hidden="true"></i> <?php echo $this->lang->line('back'); ?></a>

            </div>
        </form>
        </div>
       </div>
      </div> 
    </div>
</div>
  
<div class="clearfix"></div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script type="text/javascript">
$( document ).ready(function() {
   $( "#field_type" ).change(function() {
      var type = $("#field_type").val();
      if(type == "select"){
        $(".options_class").show();
        $('#options').prop("disabled", false);
      }else{
        $(".options_class").hide();
        $('#options').prop("disabled", true);
      }
    });

    <?php if(isset($add_error_msg)){ ?>
    var msg = '<?php echo  $add_error_msg; ?>';
    toastr.error(msg, '');
    <?php } ?>


    <?php if(isset($valid_errors)){ ?>
    var errors = JSON.parse('<?php echo  json_encode($valid_errors); ?>');
    $.each(errors, function(key, value){
        toastr.error(value, '');
    });

    <?php } ?>

    $('#customfield-form select[name="form_type"]').on('change', function(){
        var form_type = $(this).val();
        var is_owner = $('input[name="only_admin"]').is(':checked');
        if(form_type == 'events' && !is_owner){
            $('#allow_students_field').show();
        }else{
            $('input[name="allow_students"]').prop('checked',false);
            $('#allow_students_field').hide();
        }

    });

    $('input[name="only_admin"]').on('change', function(){
        var _this = $(this);
        var form_state = $('#customfield-form select[name="form_type"]').val();
        if(_this.is(':checked') && form_state == 'events'){
            $('input[name="allow_students"]').prop('checked',false);
            $('#allow_students_field').hide();
        }else if(form_state == 'events'){
            $('#allow_students_field').show();
        }
    });
});


</script>