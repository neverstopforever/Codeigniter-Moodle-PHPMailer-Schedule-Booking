<style type="text/css">
.customfields{
     border-bottom: 2px solid rgb(77, 144, 254);
    font-weight: 600;
    margin-bottom: 15px;
    padding-bottom: 5px;
}    
</style>
<div class="page-container">
    <div class="table_loading"></div>
    <div class="page-content">
        <div class="<?php echo $layoutClass ?>">
            <ul class="page-breadcrumb breadcrumb">
                <li>
                    <a href="<?php echo $_base_url; ?>" ><?= $this->lang->line('menu_Home') ?></a>
                </li>
                <li>
                    <a href="javascript:;"><?php echo $this->lang->line('menu_academics'); ?></a>
                </li>
                <li>
                    <a href="<?php echo $_base_url; ?>teachers" ><?php echo $this->lang->line('teachers_index'); ?></a>
                </li>

                <li class="active">
                    <?php echo isset($add_edit) ? $add_edit : ''; ?>
                </li>
            </ul>
            <!-- BEGIN PAGE CONTENT INNER -->
            <div class="portlet light">
                  <div class="">

                        <div class="tabbable-line">
                            <ul class="nav nav-tabs ">
                                <li class="active">
                                    <a href="#tab_1" data-toggle="tab"
                                       aria-expanded="true"> <?php echo $this->lang->line('teachers_section_personal_data'); ?> </a>
                                </li>
                                <li class="">
                                    <a href="#tab_2" data-toggle="tab"
                                       aria-expanded="false"> <?php echo $this->lang->line('teachers_section_courses'); ?></a>
                                </li>
                                <li class="">
                                    <a href="#tab_3" data-toggle="tab"
                                       aria-expanded="false"> <?php echo $this->lang->line('teachers_section_calendar'); ?> </a>
                                </li>
<!--                                --><?php //if(isset($data->id) && count($personalized_fields) > 1) {?>
<!--                                    <li class="">-->
<!--                                        <a href="#tab_4" data-toggle="tab"-->
<!--                                           aria-expanded="false"> --><?php //echo $this->lang->line('teachers_section_personalized'); ?><!-- </a>-->
<!--                                    </li>-->
<!--                                --><?php //} ?>
                                <li class="">
                                    <a href="#tab_4" id="documentsTab" data-toggle="tab"
                                       aria-expanded="false"> <?php echo $this->lang->line('teachers_section_documents'); ?> </a>
                                </li>
                                <li class="">
                                    <a href="#tab_5" data-toggle="tab"
                                       aria-expanded="false"> <?php echo $this->lang->line('teachers_section_reports'); ?> </a>
                                </li>
                                <li class="">
                                    <a href="#tab_6" data-toggle="tab"
                                       aria-expanded="false"> <?php echo $this->lang->line('teachers_section_templates'); ?> </a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane active peronal_data" id="tab_1">

                                    <div class="tools">
                                    </div>
                                    <div class="portlet-body">
                                        <form name="teachersDataForm" method="POST" class="form-horizontal col-md-5" enctype="multipart/form-data">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="text-left">
                                                        <?php echo $this->lang->line('first_name'); ?>
                                                    </label>
                                                    <input  type="text" class="form-control" value="<?php echo set_value('first_name', (isset($data->first_name) ? $data->first_name : '')); ?>"  name="first_name"  />
                                                        <?php echo form_error('first_name'); ?>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="text-left">
                                                        <?php echo $this->lang->line('sur_name'); ?>
                                                    </label>
                                                    <input  type="text" class="form-control" value="<?php echo set_value('sur_name', (isset($data->sur_name) ? $data->sur_name : '')); ?>"  name="sur_name"  />

                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="text-left">
                                                        <?php echo $this->lang->line('clientes_empleados_domicilio'); ?>
                                                    </label>
                                                        <input  type="text" class="form-control" value="<?php echo set_value('adress', (isset($data->adress) ? $data->adress : '')); ?>" name="adress"  />
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="text-left">
                                                        <?php echo $this->lang->line('city'); ?>
                                                        </label>
                                                    <input  type="text" class="form-control" value="<?php echo set_value('city',(isset($data->city) ? $data->city : '')); ?>"  name="city"  />
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="text-left">
                                                        <?php echo $this->lang->line('province'); ?>
                                                    </label>
                                                    <input  type="text" class="form-control" value="<?php echo set_value('provincia', (isset($data->provincia) ? $data->provincia : '')); ?>" name="provincia"  />

                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="text-left">
                                                        <?php echo $this->lang->line('postal_code'); ?>
                                                    </label>
                                                    <input  type="text" class="form-control" value="<?php echo set_value('postal_code', (isset($data->postal_code) ? $data->postal_code : '')); ?>" name="postal_code"  />

                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="text-left">
                                                        <?php echo $this->lang->line('passport'); ?>
                                                    </label>
                                                    <input  type="text" class="form-control" value="<?php echo set_value('passport', (isset($data->passport) ? $data->passport : '')); ?>" name="passport"  />

                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="text-left">
                                                        <?php echo $this->lang->line('phone1'); ?>
                                                    </label>
                                                    <input  type="text" class="form-control" value="<?php echo set_value('phone1', (isset($data->phone1) ? $data->phone1 : '')); ?>" name="phone1"  />

                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="text-left">
                                                        <?php echo $this->lang->line('phone2'); ?>
                                                    </label>
                                                    <input  type="text" class="form-control" value="<?php echo set_value('phone2', (isset($data->phone2) ? $data->phone2 : '')); ?>" name="phone2"  />
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="text-left">
                                                        <?php echo $this->lang->line('mobile'); ?>
                                                    </label>
                                                    <input  type="text" class="form-control" value="<?php echo set_value('mobile', (isset($data->mobile) ? $data->mobile : '')); ?>" name="mobile"  />
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="text-left">
                                                        <?php echo $this->lang->line('teachers_skype'); ?>
                                                    </label>
                                                    <input  type="text" class="form-control" value="<?php echo set_value('skype', (isset($data->skype) ? $data->skype : '')); ?>" name="skype"  />
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="text-left">
                                                        <?php echo $this->lang->line('teachers_date_of_creation');  ?>
                                                    </label>
                                                    <input  type="text" class="form-control datepicker" value="<?php echo set_value('date_of_creation', (isset($data->date_of_creation) ? (strtotime($data->date_of_creation) > 0 ? date($datepicker_format, strtotime($data->date_of_creation)) : '') : date($datepicker_format))); ?>" name="date_of_creation" disabled />

                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="text-left">
                                                        <?php echo $this->lang->line('teachers_last_update'); ?>
                                                    </label>
                                                    <input  type="text" class="form-control datepicker" value="<?php echo set_value('last_update', (isset($data->last_update)  ? (strtotime($data->last_update) > 0 ? date($datepicker_format, strtotime($data->last_update)) : '') : date($datepicker_format))); ?>" name="last_update" disabled />
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="radio_button form-group text-left">
                                                    <label class="">
                                                        <input  type="radio" <?php echo isset($data->active) && $data->active == 1 ? 'checked' : !isset($data->active) ? 'checked' : ''; ?> class=" " value="1" name="active"  />
                                                        <?php echo $this->lang->line('teachers_active'); ?>
                                                    </label>
                                                </div>
                                                <div class="radio_button form-group text-left">
                                                    <label class="">
                                                         <input  type="radio" <?php echo isset($data->active) && $data->active  == '0' ? 'checked' : ''; ?> class=" " value="0" name="active"  />
                                                         <?php echo $this->lang->line('teachers_inactive'); ?>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="text-left">
                                                        <?php echo $this->lang->line('email'); ?>
                                                    </label>
                                                    <input  type="email" class="form-control" value="<?php echo set_value('email1', (isset($data->email1) ? $data->email1 : '')); ?>" name="email1"  />
                                                    <?php echo form_error('email1'); ?>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="text-left">
                                                        <?php echo $this->lang->line('email2'); ?>
                                                    </label>
                                                    <input  type="email" class="form-control" value="<?php echo set_value('email2', (isset($data->email2) ? $data->email2 : '')); ?>" name="email2"  />
                                                    <?php echo form_error('email2'); ?>

                                                </div>
                                            </div>
                                           <!-- <div class="col-md-12">
                                                <div class="form-group">
                                                    <label >
                                                        <?php /*echo $this->lang->line('teachers_photo'); */?>
                                                        <input type="image" src="<?php /*echo base_url().'assets/img/dummy-image.jpg'; */?>" border="0" name="default_image" alt="image!">
                                                        <input type="file" id="file" name="teacher_photo" />
                                                        <input type="hidden" name="photo">
                                                        <input  type="file" class="form-control" value="<?php /*//echo set_value('photo', (isset($data->photo) ? $data->photo : '')); */?>" name="photo"  />
                                                    </label>
                                                </div>
                                            </div>-->
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="text-left">
                                                        <?php echo $this->lang->line('teachers_social_security'); ?>
                                                    </label>
                                                    <input  type="text" class="form-control" value="<?php echo set_value('social_security', (isset($data->social_security) ? $data->social_security : '')); ?>" name="social_security"  />

                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="text-left">
                                                        <?php echo $this->lang->line('teachers_nacionality'); ?>
                                                    </label>
                                                    <input  type="text" class="form-control" value="<?php echo set_value('nacionality', (isset($data->nacionality) ? $data->nacionality : '')); ?>" name="nacionality"  />

                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="text-left">
                                                        <?php echo $this->lang->line('teachers_birthdate'); ?>
                                                    </label>
                                                    <input  type="text" class="form-control datepicker_teachers" value="<?php echo set_value('birth_date', (isset($data->birth_date) && strtotime($data->birth_date) > 0 ? date($datepicker_format, strtotime($data->birth_date)) : '')); ?>" name="birth_date" />

                                                </div>
                                            </div>
<!--                                            <h4 class="personalized">--><?php //echo $this->lang->line('teachers_section_personalized'); ?><!--</h4>-->
                                            <h4 class="personalized text-uppercase"><?php echo $this->lang->line('custom_fields'); ?></h4>
                                            <?php if(!empty($personalized_data)){ ?>
                                                <?php foreach($personalized_data as $key=>$personalized) {?>
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label class="text-left">
                                                                <?php echo ucfirst(strtolower(str_replace('_', " ", $key))); ?>
                                                            </label>
                                                            <input  type="text" class="form-control" value="<?php echo  set_value($key, (isset($personalized) ? $personalized : '')); ?>"  name="<?php echo $key; ?>"  />
                                                        </div>
                                                    </div>
                                                <?php } ?>

                                            <?php }elseif(!empty($personalized_fields)){ ?>

                                                <?php foreach($personalized_fields as $field){ ?>
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label class="text-left">
                                                                <?php echo ucfirst(strtolower(str_replace('_', " ", $field->name))); ?>
                                                            </label>
                                                            <input  type="text" class="form-control" value=""  name="<?php echo $field->name; ?>"  />
                                                        </div>
                                                    </div>
                                                <?php } ?>
                                            <?php } ?>

                                                 <?php  
                                                 if(isset($data->custom_fields)){
                                                 $custom = $data->custom_fields;
                                                    }else{
                                                    $custom = array();
                                                    }
                                                 if(!empty($customfields_fields)) { ?>

                                                     <?php foreach($customfields_fields as $customfields){  ?>
                                                         <?php $disabled = '';
                                                         $show = 1;
                                                         if($customfields['disabled'] == '1'){
                                                             $disabled = ' disabled ';
                                                         }
                                                         if($isOwner == 0 && $customfields['only_admin'] == 1 ){
                                                             $show = 0;
                                                         }
                                                         ?>

                                                         <?php if($customfields['field_type'] == 'textarea' && $customfields['active']== 1 && $show){ ?>
                                                             <div class="form-group text-left">
                                                                 <lable class="text-capitalize"><?php echo $customfields['field_name']; ?>:</lable>
                                                                 <textarea <?php echo $disabled; ?>  type="text" class="form-control " name="custom_fields[<?php echo $customfields['id']; ?>]" <?php if($customfields['required']== 1){echo 'required';}?>><?php if(!empty($custom->$customfields['id'])){ echo $custom->$customfields['id']; }else{ }?></textarea>
                                                             </div>
                                                         <?php } elseif($customfields['field_type'] =='input' && $customfields['active']== 1){ ?>
                                                             <div class="form-group text-left">
                                                                 <lable class="text-capitalize"><?php echo  $customfields['field_name']; ?>:</lable>
                                                                 <input type="text" <?php if($customfields['required']== 1){echo ' required ';} echo $disabled; ?>  class="form-control" name="custom_fields[<?php echo $customfields['id']; ?>]" value="<?php if(!empty($custom->$customfields['id'])){ echo $custom->$customfields['id']; }else{ }?>">
                                                             </div>
                                                         <?php }

                                                         elseif($customfields['field_type'] =='select' && $customfields['active']== 1 && $show){ ?>
                                                             <div class="form-group text-left circle_select_div">
                                                                 <lable class="text-capitalize"><?php echo  $customfields['field_name']; ?>:</lable>
                                                                 <select <?php if($customfields['required']== 1){echo ' required ';} echo $disabled; ?> class="form-control" name="custom_fields[<?php echo $customfields['id']; ?>]">
                                                                     <option value=""> <?php echo $this->lang->line('events_select_option');?> </option>
                                                                     <?php
                                                                     $options = explode(',',$customfields['options']);
                                                                     foreach ($options as $value) {?>
                                                                         <option value="<?php echo $value;?>" <?php if(!empty($custom->$customfields['id']) && $custom->$customfields['id'] == $value){ echo "selected"; }else{ }?>><?php echo $value;?></option>
                                                                     <?php }?>
                                                                 </select>
                                                             </div>
                                                         <?php }
                                                         elseif($customfields['field_type'] == 'datepicker' && $customfields['active']== 1 && $show){
                                                             $date='';
                                                             $datePost='';
                                                             if(isset($custom->$customfields['id']) && !empty($custom->$customfields['id'])){
                                                                 if($lang == 'spanish'){
                                                                     $date = date("d-m-Y", strtotime($custom->$customfields['id']));
                                                                 }elseif ($lang = 'english'){
                                                                     $date = date("Y-m-d", strtotime($custom->$customfields['id']));
                                                                 }
                                                                 $datePost = date("Y-m-d", strtotime($custom->$customfields['id']));
                                                             }
                                                             ?>
                                                             <div class="form-group text-left circle_select_div" >
                                                                 <lable class="text-capitalize"><?php echo  $customfields['field_name']; ?>:</lable>
                                                                 <input type="text" <?php if($customfields['required']== 1){echo ' required ';} echo $disabled; ?>  class="form-control datepicker_field" fild_id="<?php echo $customfields['id']; ?>" value="<?php echo $date; ?>">
                                                                 <input type="hidden" <?php if($customfields['required']== 1){echo ' required ';} echo $disabled; ?>  class="hidden_date" fild_id="<?php echo $customfields['id']; ?>" id="hidden_date<?php echo $customfields['id']; ?>" name="custom_fields[<?php echo $customfields['id']; ?>]" value="<?php echo $datePost; ?>">
                                                             </div>
                                                         <?php }
                                                         elseif($customfields['field_type'] =='checkbox' && $customfields['active']== 1){ ?>
                                                             <div class="form-group">
                                                                 <div class="md-checkbox">
                                                                     <input type="checkbox" <?php echo $disabled ?> id="custom_fields[<?php echo $customfields['id']; ?>]" name="custom_fields[<?php echo $customfields['id']; ?>]" <?php if(!empty($custom->$customfields['id'])){ echo "checked"; }else{ }?> value="yes">
                                                                     <label for="custom_fields[<?php echo $customfields['id']; ?>]">
                                                                         <span></span>
                                                                         <span class="check"></span>
                                                                         <span class="box"></span>
                                                                         <?php echo  $customfields['field_name'];  ?>
                                                                     </label>
                                                                 </div>
                                                             </div>
                                                         <?php }
                                                         else{

                                                         }?>
                                                         <?php
                                                     }
                                                 }?>

                                            <div class="back_save_group text-left">
                                                <a href="<?php echo base_url('teachers'); ?>" class="btn-sm btn btn-circle btn-default-back back_teachers xs_hide " ><?php echo $this->lang->line('back'); ?></a>
                                                <input type="submit"  class="btn btn-sm btn-primary btn-circle " value="<?php echo $this->lang->line('save'); ?>" />
                                                <a href="<?php echo base_url('teachers'); ?>" class="btn-sm btn btn-circle btn-default-back back_teachers xs_show" ><?php echo $this->lang->line('back'); ?></a>
                                            </div>
                                        </form>
                                    </div>


                                </div>
                                <div class="tab-pane" id="tab_2">
                                    <div class="no_coursesTable" style="display: none;"></div>
                                    <div id="coursesTable"></div>
                                    <a href="<?php echo base_url('teachers'); ?>" class=" back_teachers btn btn-circle btn-primary btn-back margin-top-20 " > <i class="fa fa-arrow-left"></i> <?php echo $this->lang->line('back'); ?></a>
<!--                                    <button id="addCourses" class="btn btn-success pull-left addCourses">--><?php //echo $this->lang->line('classroom_add_courses'); ?><!--</button>-->
                                </div>
                                <div class="tab-pane teacher_calendar" id="tab_3">
                                    <div>
                                        <div class="col-sm-8 col-md-9">
                                            <div id="calendar" class=" portlet light portlet-fit  calendar fc fc-ltr fc-unthemed"></div>
                                        </div>
                                        <div class="col-sm-4  col-md-3 tags_section">
                                        <h2><?php echo $this->lang->line('teachers_tags'); ?></h2>
                                      <?php if(!empty($calendar_tags)){ ?>
                                          <?php foreach($calendar_tags as $k=>$tag){ ?>
                                             <button class="btn btn-circle margin-top-10 " style="border-color:<?php echo '#'.$tag->color; ?>; <?php echo $k == 0 ? 'margin-left: 5px' : '' ;?> "><?php echo
                                                 $tag->tag; ?></button>
                                          <?php } ?>
                                      <?php } ?>
                                    </div>

                                    </div>
                                </div>
<!--                                <div class="tab-pane personalized_field" id="tab_4">-->
<!--                                    -->
<!--                                </div>-->
                                <div class="tab-pane teacher_document_section" id="tab_4">
                                    <div class="visible-sm visible-xs col-xs-12 drop_files_section">
                                        <div>
                                            <form action="/aws_s3/uploadDocuments/profesor/<?php echo (isset($data->id) ? $data->id : null);?>" class="dropzone dropzone-file-area dz-clickable " method="POST" name="documents_import"
                                                  id="documents_import" >
                                                <div class="dz-default dz-message">
                                                    <h4 class="sbold"><strong><?php echo $this->lang->line('document_drop_files'); ?></strong></h4>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="no_documentsTable col-xs-12 col-sm-9" style="display: none;"></div>
                                    <div id="documentsTable" class="custom_response_table col-xs-12 col-sm-9">

                                    </div>
                                    <div class="hidden-sm hidden-xs col-sm-3 drop_files_section">
                                        <div>
                                            <form action="/aws_s3/uploadDocuments/profesor/<?php echo (isset($data->id) ? $data->id : null);?>" class="dropzone dropzone-file-area dz-clickable " method="POST" name="documents_import"
                                                  id="documents_import1" >
                                                <div class="dz-default dz-message">
                                                    <h4 class="sbold"><strong><?php echo $this->lang->line('document_drop_files'); ?></strong></h4>
                                                </div>
                                            </form>

                                    </div>
                                    </div>
<!--                                    <button class="btn btn-success pull-right margin-top-10 add_document">--><?php //echo $this->lang->line('clientes_addDocument');  ?><!--</button>-->
                                </div>
                                <div class="tab-pane" id="tab_5">
                                    <div id="reports"></div>
                                    <fieldset>
                                        <!-- Select Basic -->
                                        <div class="form-group-informes">
                                              <div class="col-sm-6">
                                                <div class="circle_select_div">
                                                <label class="control-label" for="categorias"> <?php echo $this->lang->line('campus_student_repo_information') ?></label>
                                                    <select id="categorias" name="categorias" class="form-control">
                                                        <option value=""><?php echo $this->lang->line('campus_student_select_information'); ?></option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-3"></div>

                                            <br />
                                            <div class="col-md-12 search_button">
                                                <button type="button" style="display:none;" class="btn btn-default mostrar" id="mostrar" name="mostrar"> <?php echo $this->lang->line('button_Show'); ?></button>
                                            </div>
                                        </div>
                                    </fieldset>
                                    <div class=" index_table ">
                                        <div class="col-md-12 ">
                                            <div class="tabs_container" style="display:none;">
                                                <div class="card">
                                                    <div class="tab temp" style="display:none;">
                                                        <li role="presentation" class="tab_link"><a href="#table1" aria-controls="table1" role="tab" data-toggle="tab"><span class="link_text"> </span> <i class="fa fa-trash link_trash"></i></a></li>
                                                    </div>
                                                    <ul class="nav nav-tabs" role="tablist">
                                                    </ul>
                                                    <!-- Tab panes -->
                                                    <div class="content temp" style="display:none;">
                                                        <div role="tabpanel" class="tab-pane" id="table1"></div>
                                                    </div>
                                                    <div class="tab-content">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="tab_6">
                                    <div id="templates">
                                        <form id="template-form" action="<?php echo base_url(); ?>teachers/printTemplate" method="post">
                                            <div class="col-sm-6">
                                               <lable class="lable text-left">
                                                   <?php echo $this->lang->line('select_template'); ?>
                                               </lable>
                                                <div class="circle_select_div">
                                                    <select class="form-control " name="templateId" >
                                                        <option value="0"><?php echo $this->lang->line('select_template'); ?></option>
                                                    <?php if(!empty($templates)) { ?>
                                                        <?php foreach($templates as $template) { ?>
                                                           <option  value="<?php echo $template->id; ?>"><?php echo $template->Nombre; ?></option>
                                                        <?php } ?>
                                                    <?php } ?>
                                                    </select>
                                                </div>

                                            <input type="hidden" name="teacherId" value="<?php echo isset($data->id)?$data->id:''; ?>">
                                        </div>
                                          <div class="col-sm-6">
                                            <button id="" type="submit" class="btn btn-default tamplate_print  btn-default btn-circle"><i class="fa fa-print"></i> <?php echo $this->lang->line('print'); ?></button>
                                          </div>
                                        </form>
                                    </div>
                                </div>


                            </div>
                        </div>

                    </div>

                <div class="modal fade" id="addCoursesModal" tabindex="-1" role="dialog"  aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                <h4 class="modal-title"><?php echo $this->lang->line('classroom_add_courses'); ?></h4>
                            </div>
                            <div class="modal-body">
                                <div id="allCourses">

                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-circle btn-default-back" data-dismiss="modal"><?php echo $this->lang->line('close'); ?></button>
                                <button  class="btn btn-primary btn-circle coursesSave"><?php echo $this->lang->line('classroom_save'); ?></button>
                            </div>

                        </div>
                        <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                </div>

                <div class="modal fade" id="eventpanel" role="dialog">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                <h4 class="modal-title"> <?php echo $this->lang->line('view_event');?> </h4>
                            </div>
                            <div class="modal-body">
                                <div class="event_time"></div>
                                <div><strong><?php echo $this->lang->line('date').":";?> </strong><span class="event_date"></span></div>
                                <label><strong><?php echo $this->lang->line('details');?></strong></label>
                                <div class="event_detail"></div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->lang->line('close');?></button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="deleteCourseModal" tabindex="-1" role="dialog"  aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                <h4 class="modal-title"><?php echo $this->lang->line('please_confirm'); ?></h4>
                            </div>
                            <div class="modal-body">
                                <p><?php echo $this->lang->line('classroom_are_you_sure_delete_course'); ?></p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn default" data-dismiss="modal"><?php echo $this->lang->line('close'); ?></button>
                                <button  class="btn btn-danger deleteCourseModal"><?php echo $this->lang->line('done'); ?></button>
                            </div>

                        </div>
                        <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                </div>


<!--                <div class="modal fade" id="documentUpload" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">-->
<!--                    <div class="modal-dialog" role="document">-->
<!--                        <div class="modal-content">-->
<!--                            <div class="modal-header">-->
<!--                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span-->
<!--                                        aria-hidden="true">&times;</span></button>-->
<!--                                <h4 class="modal-title" id="myModalLabel"> --><?php //echo $this->lang->line('teachers_upload_document'); ?><!--</h4>-->
<!--                            </div>-->
<!--                            <form id="DocumentUp" method="POST" enctype="multipart/form-data">-->
<!--                                <div class="modal-body">-->
                                   <!-- <div class="file_name">
                                        <input placeholder="<?php /*echo $this->lang->line('fileTitle'); */?>" type="text" name="document_name"
                                               required class="filenombre"/>
                                    </div>-->
<!--                                    <form action="/aws_s3/uploadDocuments/profesor/--><?php //echo (isset($data->id) ? $data->id : null);?><!--" class="dropzone dropzone-file-area dz-clickable " method="POST" name="documents_import"-->
<!--                                          id="documents_import" >-->
<!--                                        <div class="dz-default dz-message">-->
<!--                                            <h3 class="sbold">--><?php //echo $this->lang->line('document_drop_files'); ?><!--</h3>-->
<!--                                        </div>-->
<!--                                    </form>-->

<!--                                </div>-->

<!--                            </form>-->
<!--                            <div class="modal-footer">-->
<!--                                <button type="button" class="btn btn-default" data-dismiss="modal">--><?php //echo $this->lang->line('close'); ?><!--</button>-->
<!--                                <button type="submit" class="btn btn-primary">--><?php //echo $this->lang->line('upload'); ?><!--</button>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->

<!--                <div class="clearfix"></div>-->
                <div class="temp_filter" style="display:none;">
                    <div style="display:none;">
                        <div id="advancedSearchForm">
                            <div class="advancedSearchForm_wrapper" id="advancedSearchForm_wrapper">
                                <input type="hidden" name="table" value="">
                                <div class="clearfix">
                                    <h5 class="pull-left"><span class="fui-search"></span> <?php echo $this->lang->line('dt_filter') ?></h5>
                                </div>
                                <hr>
                                <div class="panel-group margin-bottom-15" id="advancedSearch_accordion">
                                    <!-- templ -->
                                    <div class="panel panel-default filter_item" style="display: none;" id="newSearchItem_templ">
                                        <div class="panel-heading">
                                            <h4 class="panel-title">
                                                <a data-parent="#advancedSearch_accordion" href="#as_collapse0">
                                                    <b class="item"><?php echo $this->lang->line('dt_filterItem') ?> 1</b> <span class="pull-right"><?php echo $this->lang->line('dt_collapsExpand') ?></span>
                                                </a>
                                            </h4>
                                        </div>
                                        <div id="as_collapse0" class="panel-collapse collapse in">
                                            <div class="panel-body">
                                                <div class="form-group clearfix margin-bottom-0">
                                                    <div class="col-sm-6">
                                                        <div class="mbl margin-bottom-0 circle_select_div">
                                                            <select name="columns[]" class="select-block selector dt_column  form-control aaa" placeholder="Selecciona Columna">
                                                                <option value=""><?php echo $this->lang->line('dt_selectColumn') ?></option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="mbl margin-bottom-0 circle_select_div">
                                                            <select name="operators[]" class="select-block selector dt_operator form-control aaa" placeholder="Selecciona Operador">
                                                                <option value=""><?php echo $this->lang->line('dt_selectOperator') ?></option>
                                                                <option value="="><?php echo $this->lang->line('dt_operatorEquil') ?></option>
                                                                <option value="!="><?php echo $this->lang->line('dt_operatorNotEquil') ?></option>
                                                                <option value="LIKE%"><?php echo $this->lang->line('dt_operatorLike') ?></option>
                                                                <option value="NOT LIKE%"><?php echo $this->lang->line('dt_operatorNotLike') ?></option>
                                                                <option value="<"><?php echo $this->lang->line('dt_operatorLessThen') ?> (&lt;)</option>
                                                                <option value=">"><?php echo $this->lang->line('dt_operatorGreaterThen') ?>(&gt;)</option>
                                                                <option value="<="><?php echo $this->lang->line('dt_operatorLessthenEquil') ?> (&lt;=)</option>
                                                                <option value=">="><?php echo $this->lang->line('dt_operatorgreaterThenEquil') ?> (&gt;=)</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group clearfix margin-bottom-15">
                                                    <div class="col-sm-12">
                                                        <input type="text" class="form-control dt_value" id="inputEmail3" placeholder="<?php echo $this->lang->line('de_placeholderValue'); ?>" name="values[]">
                                                    </div>
                                                </div>
                                                <div class="form-group clearfix margin-bottom-0">
                                                    <div class="col-sm-12">
                                                        <a href="" class="pull-right text-danger small removeAsItem"><span class="fui-cross-inverted"></span> <?php echo $this->lang->line('dt_deleteItem') ?></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /templ -->
                                    <div class="panel panel-default filter_item">
                                        <div class="panel-heading">
                                            <h4 class="panel-title">
                                                <a data-parent="#advancedSearch_accordion" href="#as_collapseOne">
                                                    <b class="item"><?php echo $this->lang->line('dt_filterItem') ?> 1</b> <span class="pull-right"><?php echo $this->lang->line('dt_collapsExpand') ?></span>
                                                </a>
                                            </h4>
                                        </div>
                                        <div id="as_collapseOne" class="panel-collapse collapse in">
                                            <div class="panel-body">
                                                <div class="form-group clearfix margin-bottom-0">
                                                    <div class="col-sm-6">
                                                        <div class="mbl margin-bottom-0 circle_select_div">
                                                            <select name="columns[]" class="select-block selector dt_column  form-control aaa" placeholder="Selecciona Columna">
                                                                <option value=""><?php echo $this->lang->line('dt_selectColumn') ?></option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="mbl margin-bottom-0 circle_select_div">
                                                            <select name="operators[]" class="select-block selector dt_operator form-control aaa" placeholder="Selecciona Operador">
                                                                <option value=""><?php echo $this->lang->line('dt_selectOperator') ?></option>
                                                                <option value="="><?php echo $this->lang->line('dt_operatorEquil') ?></option>
                                                                <option value="!="><?php echo $this->lang->line('dt_operatorNotEquil') ?></option>
                                                                <option value="LIKE%"><?php echo $this->lang->line('dt_operatorLike') ?></option>
                                                                <option value="NOT LIKE%"><?php echo $this->lang->line('dt_operatorNotLike') ?></option>
                                                                <option value="<"><?php echo $this->lang->line('dt_operatorLessThen') ?> (&lt;)</option>
                                                                <option value=">"><?php echo $this->lang->line('dt_operatorGreaterThen') ?>(&gt;)</option>
                                                                <option value="<="><?php echo $this->lang->line('dt_operatorLessthenEquil') ?> (&lt;=)</option>
                                                                <option value=">="><?php echo $this->lang->line('dt_operatorgreaterThenEquil') ?> (&gt;=)</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group clearfix margin-bottom-15">
                                                    <div class="col-sm-12">
                                                        <input type="text" class="form-control dt_value" id="inputEmail3" placeholder="<?php echo $this->lang->line('de_placeholderValue') ?>" name="values[]">
                                                    </div>
                                                </div>
                                                <div class="form-group clearfix margin-bottom-0">
                                                    <div class="col-sm-12">
                                                        <a href="" class="pull-right text-danger small removeAsItem"><span class="fui-cross-inverted"></span> <?php echo $this->lang->line('dt_deleteItem') ?></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.panel -->
                                </div>
                                <div class="form-group clearfix" style="width:100%;">
                                    <button type="button" class="btn btn-primary btn-circle applyFilter"><?php echo $this->lang->line('dt_apply') ?></button>
                                    <button type="button" class="btn btn-primary btn-circle resetTable"><?php echo $this->lang->line('dt_undo') ?></button>
                                    <a href="" class="addColumnLink pull-right" id="addSearchItem"><span class="fui-plus"></span> <?php echo $this->lang->line('dt_addItem') ?></a>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="temp_groupby" style="display:none;">
                        <div style="display:none;">
                            <div id="advancedgroupForm">
                                <div class="advancedgroupForm_wrapper" id="advancedgroupForm_wrapper">
                                    <input type="hidden" name="table" value="">
                                    <div class="clearfix">
                                        <h5 class="pull-left"><span class="fui-group"></span> <?php echo $this->lang->line('dt_group') ?></h5>
                                    </div>
                                    <hr>
                                    <div class="panel-group margin-bottom-15" id="advancedgroup_accordion">
                                        <!-- templ -->
                                        <div class="panel panel-default agregate_item" style="display: none;" id="newgroupItem_templ">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                    <a data-parent="#advancedgroup_accordion" href="#as_collapse0">
                                                        <b class="item"><?php echo $this->lang->line('dt_groupTitle') ?> </b> <span class="pull-right" style="display:none"><?php echo $this->lang->line('dt_collapsExpand'); ?></span>
                                                    </a>
                                                </h4>
                                            </div>
                                            <div id="as_collapse0" class="panel-collapse collapse in">
                                                <div class="panel-body">
                                                    <div class="form-group clearfix margin-bottom-0">
                                                        <h6><?php echo $this->lang->line('dt_selectColumn') ?></h6>
                                                        <div class="col-sm-6">
                                                            <div class="mbl margin-bottom-0 circle_select_div">
                                                                <select name="columns[]" class="select-block selector  dt_column form-control" placeholder="Selecciona Columna">
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="mbl margin-bottom-0 circle_select_div">
                                                                <select class="select-block selector  dt_agregate form-control" placeholder="Selecciona Columna">
                                                                    <option value="max"><?php echo $this->lang->line('dt_max') ?></option>
                                                                    <option value="min"><?php echo $this->lang->line('dt_min') ?></option>
                                                                    <option value="average"><?php echo $this->lang->line('dt_average') ?></option>
                                                                    <option value="count"><?php echo $this->lang->line('dt_count') ?></option>
                                                                    <option value="sum"><?php echo $this->lang->line('dt_sum') ?></option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 result_aggregate"></div>
                                                    <div class="form-group clearfix margin-bottom-0">
                                                        <div class="col-sm-12">
                                                            <a href="" class="pull-right text-danger small removeAsItem"><span class="fui-cross-inverted"></span> <?php echo $this->lang->line('dt_deleteItem') ?></a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- /templ -->
                                        <div class="panel panel-default agregate_item">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                    <a data-parent="#advancedgroup_accordion" href="#as_collapse0">
                                                        <b class="item"> <?php echo $this->lang->line('dt_groupby') ?> </b> <span class="pull-right" style="display:none"><?php echo $this->lang->line('dt_collapsExpand'); ?></span>
                                                    </a>
                                                </h4>
                                            </div>
                                            <div id="as_collapse0" class="panel-collapse collapse in">
                                                <div class="panel-body">
                                                    <div class="form-group clearfix margin-bottom-0">
                                                        <div class="col-sm-12">
                                                            <div class="mbl margin-bottom-0 circle_select_div">
                                                                <h6> <?php echo $this->lang->line('dt_chooseGroup') ?></h6>
                                                                <select name="columns[]" class="select-block selector  dt_column group_by_dt form-control" placeholder="Seleciona Columna">
                                                                    <!-- <option value="">Choose column to Group</option> -->
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12 agr_items">
                                                    </div>
                                                    <div class="form-group clearfix margin-bottom-0">
                                                        <div class="col-sm-12">
                                                            <a href="" class="addColumnLink pull-right" id="addagregateItem"><span class="fui-plus"></span> <?php echo $this->lang->line('dt_addAggregateCondition') ?></a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- /.panel -->
                                    </div>
                                    <div class="form-group clearfix">
                                        <button type="button" class="btn btn-primary btn-circle resetTable pull-right"><?php echo $this->lang->line('dt_undo') ?></button>
                                        <button type="button" class="btn btn-primary btn-circle groupColumn"><?php echo $this->lang->line('dt_apply') ?></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <!-- END PAGE CONTENT INNER -->
        </div>
        <!-- BEGIN QUICK SIDEBAR -->
        <!-- END QUICK SIDEBAR -->
    </div>
    <!-- END PAGE CONTENT -->
</div>
<!-- END PAGE CONTAINER -->
<script>
    global_teacherId = false;
    <?php if(isset($data->id)) { ?>
        global_teacherId = <?php echo  json_encode($data->id); ?>;
    <?php } ?>
    var courses = <?php echo  !empty($courses) ? json_encode($courses):json_encode(array()); ?>;
    var _events = <?php echo !empty($event) ? json_encode($event) :json_encode(array()); ?>;
    var _errors = <?php echo !empty($_errors) ? json_encode($_errors) : json_encode(array()); ?>;
</script>