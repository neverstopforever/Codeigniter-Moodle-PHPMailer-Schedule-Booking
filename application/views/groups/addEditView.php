<!-- BEGIN PAGE CONTAINER -->
<div class="page-container">
    <!-- BEGIN PAGE CONTENT -->
    <div class="table_loading"></div>
    <div class="page-content groups add_edit_groups">
        <div class="<?php echo $layoutClass ?>">
            <ul class="page-breadcrumb breadcrumb">
                <li>
                    <a href="<?php echo $_base_url; ?>" ><?= $this->lang->line('menu_Home') ?></a>
                </li>
                <li>
                    <a href="javascript:;"><?php echo $this->lang->line('menu_academics'); ?></a>
                </li>
                <li>
                    <a href="<?php echo $_base_url; ?>groups"> <?php echo $this->lang->line('menu_groups'); ?></a>
                </li>
                <li class="active">
                    <?php echo isset($add_edit) ? $add_edit : ''; ?>
                </li>
            </ul>
            <!-- BEGIN PAGE CONTENT INNER -->
            <div class="portlet light text-center">

                <div class="portlet box sections " >
                    <div class="portlet-body">
                        <div class="tabbable-line">
                            <ul class="nav nav-tabs ">
                                <?php $tab_attr = isset($group->id) ? 'data-toggle="tab"' : ''; ?>
                                <?php $first_general_data = !isset($group->id) ? 'first_general_data' : ''; ?>
                                <li class="active">
                                    <a href="#tab_1" data-toggle="tab"
                                       aria-expanded="true"> <?php echo $this->lang->line('general'); ?> </a>
                                </li>
                                <li class="">
                                    <a href="<?php echo isset($group->id) ? '#tab_2' : 'javascript:;'; ?>" class="<?php echo $first_general_data; ?>" <?php echo $tab_attr; ?>
                                       aria-expanded="false"> <?php echo $this->lang->line('courses'); ?></a>
                                </li>
                                <li class="">
                                    <a href="<?php echo isset($group->id) ? '#tab_3' : 'javascript:;'; ?>" class="<?php echo $first_general_data; ?>" <?php echo $tab_attr; ?>
                                       aria-expanded="false"> <?php echo $this->lang->line('calendar') ?> </a>
                                </li>
                                <li class="">
                                    <a href="<?php echo isset($group->id) ? '#tab_4' : 'javascript:;'; ?>" class="<?php echo $first_general_data; ?>" <?php echo $tab_attr; ?>
                                       aria-expanded="false"> <?php echo $this->lang->line('documents').' ( <i class="documetns_count">'. (isset($documents[0]->doc_count) ? $documents[0]->doc_count : 0) .' </i> )' ; ?> </a>
                                </li>
                                <li class="">
                                    <a href="<?php echo isset($group->id) ? '#tab_5' : 'javascript:;'; ?>" class="<?php echo $first_general_data; ?>" <?php echo $tab_attr; ?>
                                       aria-expanded="false"> <?php echo $this->lang->line('resources') ?> </a>
                                </li>
<!--                                <li class="">-->
<!--                                    <a href="#tab_6"  data-toggle="tab"-->
<!--                                       aria-expanded="false"> --><?php //echo $this->lang->line('billing') ?><!-- </a>-->
<!--                                </li>-->
                                <li class="">
                                    <a href="<?php echo isset($group->id) ? '#tab_7' : 'javascript:;'; ?>" class="<?php echo $first_general_data; ?>" <?php echo $tab_attr; ?>
                                       aria-expanded="false"> <?php echo $this->lang->line('reports') ?> </a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div class="tools">
                                </div>
                                <div class="tab-pane active student_sub_tab" id="tab_1">
                                    <form method="POST" class="form-horizontal" enctype="multipart/form-data">
                                        <div class="col-md-5">
                                             <div class="col-md-12 text-left">
                                                <div class="form-group ">
                                                        <label>
                                                            <?php echo $this->lang->line('groups_reference'); ?>:
                                                        </label>
                                                        <input  type="text" <?php echo isset($group->id) ? 'readonly' : ''; ?> class="form-control reference_input" value="<?php echo set_value('id', (isset($group->id) ? $group->id : ($group_id ))); ?>"  name="id"  />
                                                        <?php echo form_error('id'); ?>
                                                        <?php echo isset($error_id) ? $error_id : '';?>

                                                </div>
                                                <div class="form-group text-left result_color">
    <!--     like  /classroom/ page -->                 <label >
                                                            <?php echo $this->lang->line('color'); ?>:
                                                        </label>
                                                        <input  readonly="readonly" type="text" class="form-control" placeholder="<?php echo $this->lang->line('group_select_color'); ?>"  id="result_color" value="<?php echo set_value('color', (isset($group->color) ? '#'.$group->color : '')); ?>"  name="color"  />
                                                        <input  type="text" class="form-control "  id="flatClearable" name=""  />
                                                    <i class="fa fa-angle-right"></i>
                                                </div>
                                                <div class="form-group text-left">
                                                        <label>
                                                            <?php echo $this->lang->line('groups_name'); ?>:
                                                        </label>
                                                        <input  type="text" class="form-control " value="<?php echo set_value('title', (isset($group->title) ? $group->title : '')); ?>"  name="title"  />
                                                    <?php echo form_error('title'); ?>
                                                </div>
                                             </div>
                                         </div>
                                        <div class="col-md-12">
                                            <div class="col-md-12 text-left">
                                                <div class="form-group text-left">
                                                        <label>
                                                            <?php echo $this->lang->line('groups_description'); ?>:
                                                        </label>
                                                        <textarea  class="form-control editor" id="group_description"  name="group_description"  ><?php echo isset($group->group_description) ? $group->group_description : ''; ?></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-5">
                                            <div class="col-md-12 text-left">
                                            <div class="form-group text-left circle_select_div">
                                                    <label>
                                                        <?php echo $this->lang->line('groups_academic_area'); ?>:
                                                    </label>
                                                    <select  class="form-control " name="academic_area"  >
                                                        <option value=""><?php echo $this->lang->line('groups_select_area') ?></option>
                                                        <?php if(!empty($academic_area)){ ?>
                                                            <?php foreach($academic_area as $area){ ?>
                                                                <option value="<?php echo $area->id; ?>"  <?php echo isset($group->id_area_academic) && $area->id == $group->id_area_academic ? 'selected' : ''; ?> ><?php echo $area->valor; ?></option>

                                                            <?php } ?>
                                                        <?php } ?>
                                                    </select>
                                            </div>
                                            <div class="form-group text-left circle_select_div">
                                                    <label>
                                                        <?php echo $this->lang->line('category'); ?>:
                                                    </label>
                                                    <select  class="form-control "  name="category"  >
                                                        <option value=""><?php echo $this->lang->line('groups_select_category') ?></option>
                                                        <?php if(!empty($categories)){ ?>
                                                            <?php foreach($categories as $category){ ?>
                                                                <option value="<?php echo $category->id; ?>" <?php echo isset($group->id_category) && $category->id == $group->id_category ? 'selected' : ''; ?> ><?php echo $category->title; ?></option>

                                                            <?php } ?>
                                                        <?php } ?>
                                                    </select>
                                            </div>
                                            <div class="form-group text-left circle_select_div">
                                                    <label >
                                                        <?php echo $this->lang->line('groups_academic_year'); ?>:
                                                    </label>
                                                    <select  class="form-control "  name="academic_year"  >
                                                        <option value=""><?php echo $this->lang->line('groups_select_year') ?></option>
                                                        <?php if(!empty($academic_years)){ ?>
                                                            <?php foreach($academic_years as $year){ ?>
                                                                <option value="<?php echo $year->id; ?>" <?php echo isset($group->id_Academicyear) && $year->id == $group->id_Academicyear ? 'selected' : ''; ?> ><?php echo $year->title; ?></option>

                                                            <?php } ?>
                                                        <?php } ?>
                                                    </select>

                                            </div>
                                            <div class="form-group text-left min_max_seats">
                                                <div class="col-md-6">
                                                    <label>
                                                        <?php echo $this->lang->line('groups_min_seats'); ?>:
                                                    </label>
                                                    <input  type="number" min="1" max="300" class="form-control " value="<?php echo set_value('min_seats', (isset($group->min_seats) ? $group->min_seats : 1)); ?>"  name="min_seats"  />

                                            </div>
                                                <div class="col-md-6">
                                                    <label >
                                                        <?php echo $this->lang->line('groups_max_seats'); ?>:
                                                    </label>

                                                    <input  type="number" max="300"  min="1" class="form-control " value="<?php echo set_value('max_seats', (isset($group->max_seats) ? $group->max_seats : 1)); ?>"  name="max_seats"  />
                                                </div>
                                            </div>
                                            <div class="form-group text-left">

                                                    <label>
                                                        <?php echo $this->lang->line('groups_time_short_description'); ?>:
                                                    </label>

                                                    <textarea  class="form-control editor" id="group_time_short_desc"  name="group_time_short_desc"  ><?php echo set_value('group_time_short_desc', (isset($group->group_time_short_desc) ? $group->group_time_short_desc : '')); ?></textarea>

                                            </div>
                                            <div class="form-group text-left">

                                                <label >

                                                </label>

<!--                                                 <h4 class="personalized text-uppercase">--><?php //echo $this->lang->line('groups_additional_data'); ?><!--</h4>-->
                                                <h4 class="personalized text-uppercase"><?php echo $this->lang->line('custom_fields'); ?></h4>


                                             </div>
                                            <?php if(!empty($personalized_fields)) {?>
                                                <?php foreach($personalized_fields as $personalized){ ?>
                                                    <div class="form-group text-left circle_select_div">


                                                            <lable><?php echo  ucfirst(strtolower(str_replace('_', " ", $personalized->name))); ?>:</lable>

                                                            <?php if($personalized->type != 'textarea'){ ?>
                                                                <?php if($personalized->name == 'area_academica' && isset($area_academica) && !empty($area_academica)){?>
                                                                    <select class="form-control" name="area_academica">
                                                                        <?php foreach ($area_academica as $value) { ?>

                                                                            <option value="<?php echo $value->id; ?>"  <?php echo $value->id == $personalized->value ? 'selected' : ''; ?> ><?php echo $value->valor; ?></option>';
                                                                        <?php }  ?>
                                                                    </select>

                                                                <?php }else{ ?>

                                                                    <input type="<?php echo $personalized->type; ?>" class="form-control " name="<?php echo $personalized->name; ?>"
                                                                           value="<?php echo $personalized->value; ?>" >
                                                                <?php } ?>
                                                            <?php }else{ ?>
                                                                <textarea type="text" class="form-control " name="<?php echo $personalized->name; ?>"><?php echo $personalized->value; ?></textarea>

                                                            <?php } ?>


                                                    </div>
                                                <?php } ?>
                                            <?php } ?>

                                                 <?php  
                                                 
                                                 if(isset($group->custom_fields)){
                                                 $custom = $group->custom_fields;
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
                                                         <div class="form-group text-left circle_select_div">
                                                             <?php if($customfields['field_type'] == 'textarea' && $customfields['active']== 1 && $show){ ?>

                                                                 <lable><?php echo $customfields['field_name']; ?>:</lable>
                                                                 <textarea <?php echo $disabled; ?>  type="text" class="form-control " name="custom_fields[<?php echo $customfields['id']; ?>]" <?php if($customfields['required']== 1){echo 'required';}?>><?php if(!empty($custom->$customfields['id'])){ echo $custom->$customfields['id']; }else{ }?></textarea>
                                                             <?php } elseif($customfields['field_type'] =='input' && $customfields['active']== 1){ ?>
                                                                 <lable><?php echo  $customfields['field_name']; ?>:</lable>
                                                                 <input type="text" <?php if($customfields['required']== 1){echo 'required';} echo $disabled; ?>  class="form-control" name="custom_fields[<?php echo $customfields['id']; ?>]" value="<?php if(!empty($custom->$customfields['id'])){ echo $custom->$customfields['id']; }else{ }?>">
                                                             <?php }

                                                             elseif($customfields['field_type'] =='select' && $customfields['active']== 1 && $show){ ?>
                                                                 <lable><?php echo  $customfields['field_name']; ?>:</lable>
                                                                 <select <?php if($customfields['required']== 1){echo ' required ';} echo $disabled; ?> class="form-control" name="custom_fields[<?php echo $customfields['id']; ?>]">
                                                                     <option value=""> <?php echo $this->lang->line('events_select_option');?> </option>
                                                                     <?php
                                                                     $options = explode(',',$customfields['options']);
                                                                     foreach ($options as $value) {?>
                                                                         <option value="<?php echo $value;?>" <?php if(!empty($custom->$customfields['id']) && $custom->$customfields['id'] == $value){ echo "selected"; }else{ }?>><?php echo $value;?></option>
                                                                     <?php }?>
                                                                 </select>
                                                             <?php }
                                                             elseif($customfields['field_type'] == 'datepicker' && $customfields['active']== 1 && $show){
                                                                 $date='';
                                                                 $datePost='';
                                                                 if(isset($custom->$customfields['id']) && !empty($custom->$customfields['id'])){
                                                                     if($lang == 'spanish'){
                                                                         $date = date("d/m/Y", strtotime($custom->$customfields['id']));
                                                                     }elseif ($lang = 'english'){
                                                                         $date = date("Y/m/d", strtotime($custom->$customfields['id']));
                                                                     }
                                                                     $datePost = date("Y-m-d", strtotime($custom->$customfields['id']));
                                                                 }
                                                                 ?>

                                                                 <lable><?php echo  $customfields['field_name']; ?>:</lable>
                                                                 <input type="text" <?php if($customfields['required']== 1){echo ' required ';} echo $disabled; ?>  class="form-control datepicker_field" fild_id="<?php echo $customfields['id']; ?>" value="<?php echo $date; ?>">
                                                                 <input type="hidden" <?php if($customfields['required']== 1){echo ' required ';} echo $disabled; ?>  class="hidden_date" fild_id="<?php echo $customfields['id']; ?>" id="hidden_date<?php echo $customfields['id']; ?>" name="custom_fields[<?php echo $customfields['id']; ?>]" value="<?php echo $datePost; ?>">
                                                             <?php }
                                                             elseif($customfields['field_type'] =='checkbox' && $customfields['active']== 1){ ?>
                                                                 <div class="form-group">
                                                                     <div class="md-checkbox">
                                                                         <input type="checkbox" <?php echo $disabled; ?> id="custom_fields[<?php echo $customfields['id']; ?>]" name="custom_fields[<?php echo $customfields['id']; ?>]" <?php if(!empty($custom->$customfields['id'])){ echo "checked"; }else{ }?> value="yes">
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
                                                         </div>
                                                         <?php
                                                     }
                                                 }?>
                                        </div>
                                        </div>
                                        <div class="form-group back_save_group text-left col-md-12 ">
                                            <a href="<?php echo base_url('groups'); ?>" class="btn-sm btn btn-circle btn-default-back xs_hide" ><?php echo $this->lang->line('back'); ?></a>
                                            <button type="submit" class="btn btn-sm btn-primary btn-circle" ><?php echo $this->lang->line('save'); ?></button>
                                            <a href="<?php echo base_url('groups'); ?>" class="btn-sm btn btn-circle btn-default-back xs_show" ><?php echo $this->lang->line('back'); ?></a>

                                        </div>
                                    </form>
                                </div>
                                <div class="tab-pane" id="tab_2">

                                </div>
                                <div class="tab-pane" id="tab_3">

                                </div>
                                <div class="tab-pane" id="tab_4">

                                </div>
                                <div class="tab-pane" id="tab_5">

                                </div>
                                <div class="tab-pane" id="tab_6">

                                </div>
                                <div class="tab-pane" id="tab_7">

                                </div>



                            </div>

                        </div>
                    </div>





                    <div class="clearfix"></div>

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
     var group_color = false;
     var _groupId = false;
     <?php if(isset($group->color)){ ?>
      group_color = <?php echo json_encode($group->color); ?>;
     <?php } ?>
     <?php if(isset($group->id)){ ?>
       _groupId = <?php echo json_encode($group->id); ?>;
     <?php } ?>
    </script>