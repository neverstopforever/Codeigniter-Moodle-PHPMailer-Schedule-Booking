<!-- BEGIN PAGE CONTAINER -->
<div class="page-container">


    <!-- BEGIN PAGE CONTENT -->
    <div class="table_loading"></div>
    <div class="page-content courses">
        <div class="<?php echo $layoutClass ?>">
            <ul class="page-breadcrumb breadcrumb">

                <li>
                    <a href="<?php echo $_base_url; ?>" ><?= $this->lang->line('menu_Home') ?></a>
                </li>
                <li>
                    <a href="javascript:;"><?php echo $this->lang->line('menu_academics'); ?></a>
                </li>
                <li>
                    <a href="<?php echo $_base_url; ?>courses"><?php echo $this->lang->line('menu_courses'); ?></a>
                </li>

                <li class="active">
                    <?php echo isset($add_edit) ? $add_edit : ''; ?>
                </li>
            </ul>
            <!-- BEGIN PAGE CONTENT INNER -->
            <div class="portlet light text-center">

                <div class="portlet box sections " >
                    <div class="portlet-title">
<!--                        <div class="caption">-->
<!--                            <i class="fa fa-gift"></i> --><?php //echo $this->lang->line('classroom_description'); ?><!--</div>-->
<!--                    </div>-->
                    <div class="portlet-body">

                        <div class="">
                            <ul class="nav nav-tabs ">
                                <li class="active">
                                    <a href="#tab_general" data-toggle="tab"
                                       aria-expanded="true"> <?php echo $this->lang->line('general'); ?> </a>
                                </li>
                                <li class="">
                                    <a href="#tab_documents" data-toggle="tab"
                                       aria-expanded="false"> <?php echo $this->lang->line('documents').' ( <i class="documents_count">'. (isset($doc_count) ? $doc_count : 0) .'</i> )' ; ?> </a>
                                </li>
                                <li class="" style="display: none">
                                    <a href="#tab_books" data-toggle="tab"
                                       aria-expanded="false"> <?php echo $this->lang->line('materials') .' ( <i class="books_count">'. (isset($books_count) ? $books_count : 0) .'</i> )' ; ?></a>
                                </li>
                                <li class="" style="display: none">
                                    <a href="#tab_resources"  data-toggle="tab"
                                       aria-expanded="false"> <?php echo $this->lang->line('resources') .' ( <i class="resources_count">'. (isset($resources_count) ? $resources_count : 0) .'</i> )' ; ?> </a>
                                </li>
                                <li class="">
                                    <a href="#tab_reports"  data-toggle="tab"
                                       aria-expanded="false"> <?php echo $this->lang->line('reports') .' ( <i class="reports_count">'. (isset($reports_count) ? $reports_count : 0) .'</i> )' ; ?> </a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div class="tools">
                                </div>
                                <div class="tab-pane active student_sub_tab" id="tab_general">
                                    <form method="POST" class="form-horizontal " enctype="multipart/form-data">
                                        <div class="col-md-12">
                                            <div class="form-group text-left margin-top-20">
                                                    <label >
                                                        <?php echo $this->lang->line('courses_reference'); ?>:
                                                    </label>

                                                    <input  type="text" <?php echo isset($course->course_id) ? 'readonly' : ''; ?> class=" " value="<?php echo set_value('course_id', (isset($course->course_id) ? $course->course_id : $course_id)); ?>"  id="course_id" name="course_id"  />
                                                    <?php echo form_error('course_id'); ?>
                                                <?php if(isset($error_msg)){ ?>
                                                    <div class="text-danger err"><?php echo $error_msg; ?></div>
                                                <?php } ?>
                                                </div>
                                                <div class="form-group text-left color_form_group">
                                                    <label >
                                                        <?php echo $this->lang->line('color'); ?>:
                                                    </label>

                                                    <input  type="text" class=" " id="result_color"    name="result_color"  value="<?php echo set_value('result_color', (isset($course->color) ? '#'.$course->color : '')); ?>" />

                                                    <input  type="text" class=" "  id="flatClearable" name=""  />
                                                    <i class="fa fa-angle-right"></i>
                                                </div>

                                            <div class="form-group text-left">

                                                    <label >
                                                        <?php echo $this->lang->line('courses_title_course'); ?>:
                                                    </label>

                                                    <input  type="text" class=" " value="<?php echo set_value('title', (isset($course->course_name) ? $course->course_name : '')); ?>"  id="title"   name="title" />
                                                    <?php echo form_error('title'); ?>
                                                </div>

                                            <div class="form-group text-left">

                                                    <label >
                                                        <?php echo $this->lang->line('courses_description'); ?>:
                                                    </label>

                                                    <textarea  class="editor" id="course_description"  name="course_description"  ><?php echo isset($course->course_description) ? $course->course_description : ''; ?></textarea>

                                            </div>

                                            <div class="form-inline text-left">
                                                <div class="hours_form">
                                                    <label>
                                                        <?php echo $this->lang->line('courses_hours'); ?>:
                                                    </label>
                                                    <div class="dec plus_minus"><i class="fa fa-minus"></i> </div>
                                                    <input  type="text" min="0" max="300" class="form-control text-center " value="<?php echo set_value('hours', (isset($course->hours) ? round($course->hours) : '')); ?>"  id="hours"   name="hours"  />

                                                    <div class="inc plus_minus"><i class="fa fa-plus"></i></div>
                                                    <?php echo form_error('hours'); ?>
                                                </div>
                                                <div class="credits_form">
                                                    <label >
                                                        <?php echo $this->lang->line('courses_credits'); ?>:
                                                    </label>
                                                    <div class="dec plus_minus"><i class="fa fa-minus"></i> </div>
                                                    <input  type="text" max="300"  min="0" class="form-control text-center" value="<?php echo set_value('credits', (isset($course->credits) ? round($course->credits) : '')); ?>"  id="credits" name="credits"  />
                                                    <div class="inc plus_minus"><i class="fa fa-plus"></i></div>
                                                    <?php echo form_error('credits'); ?>
                                                </div>
                                            </div>



                                            <?php if(!empty($personalized_fields)) {?>
                                                <div class="form-group text-left persinalized_field margin-top-10">
<!--                                                     <h4>--><?php //echo $this->lang->line('courses_additional_data'); ?><!--</h4>-->
                                                    <h4 class="personalized"><?php echo $this->lang->line('custom_fields'); ?></h4>
                                                </div>
                                                <?php foreach($personalized_fields as $personalized){ ?>
                                                    <div class="form-group text-left commentaries">

                                                            <label><?php echo  ucfirst(strtolower(str_replace('_', " ", $personalized->name))); ?>:</label>

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
                                            <div class="col-md-6">
                                             <?php

                                                 if(isset($course->custom_fields)){
                                                 $custom = $course->custom_fields;
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
                                            </div>


                                        <div class="form-group">

                                            <div class="col-md-12 text-left back_save_group">
                                                <a href="<?php echo base_url();?>courses" class="btn-sm btn btn-circle btn-default-back xs_hide"><?php echo $this->lang->line('back'); ?></a>
                                                <input type="submit" class="btn btn-sm btn-primary btn-circle  " value="<?php echo $this->lang->line('save'); ?>" />
                                                <a href="<?php echo base_url();?>courses" class="btn-sm btn btn-circle btn-default-back xs_show"><?php echo $this->lang->line('back'); ?></a>
                                            </div>
                                        </div>
                                        </div>
                                    </form>
                                </div>

                                <div class="tab-pane" id="tab_documents">

                                </div>
<!--                                <div class="tab-pane" id="tab_books">-->
<!---->
<!--                                </div>-->
<!--                                <div class="tab-pane" id="tab_resources">-->
<!---->
<!--                                </div>-->
                                <div class="tab-pane" id="tab_reports">

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
     var course_color = false;
     var _courseId = false;
     <?php if(isset($course->color)){ ?>
      course_color = <?php echo json_encode($course->color); ?>;
     <?php } ?>
     <?php if(isset($course->course_id)){ ?>
       _courseId = <?php echo json_encode($course->course_id); ?>;
     <?php } ?>
    </script>