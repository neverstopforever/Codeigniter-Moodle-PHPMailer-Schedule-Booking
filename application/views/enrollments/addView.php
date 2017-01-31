<!-- BEGIN PAGE CONTAINER -->
<div class="page-container">
 
    <!-- BEGIN PAGE CONTENT -->
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
                    <a href="<?php echo $_base_url; ?>enrollments">  <?php echo $this->lang->line('menu_enrollments'); ?></a>
                </li>
                <li class="active">
                    <?php echo $this->lang->line('add'); ?>
                </li>
            </ul>
            <!-- BEGIN PAGE CONTENT INNER -->
            <div class="portlet light text-left  bordered">
                 <div class="mt-element-step text-left">
                    <div class="row step-line">

                        <div class="col-md-3 mt-step-col step_1_line first active">
                            <div class="mt-step-number bg-white">1</div>
                            <div class="mt-step-title uppercase font-grey-cascade"><?php echo strtoupper($this->lang->line('students')); ?></div>
                            <div class="mt-step-content font-grey-cascade"></div>
                        </div>
                        <div class="col-md-3 mt-step-col step_2_line ">
                                  <div class="mt-step-number bg-white">2</div>
                            <div class="mt-step-title uppercase font-grey-cascade"><?php echo strtoupper($this->lang->line('enrollments_refine')); ?></div>
                            <div class="mt-step-content font-grey-cascade"></div>
                        </div>
                        <div class="col-md-3 mt-step-col step_3_line">
                            <div class="mt-step-number bg-white">3</div>
                            <div class="mt-step-title uppercase font-grey-cascade"><?php echo strtoupper($this->lang->line('enrollments_payment')); ?></div>
                            <div class="mt-step-content font-grey-cascade"></div>
                        </div>
                        <div class="col-md-3 mt-step-col step_4_line last">
                            <div class="mt-step-number bg-white">4</div>
                            <div class="mt-step-title uppercase font-grey-cascade"><?php echo strtoupper($this->lang->line('enrollments_confirm')); ?></div>
                            <div class="mt-step-content font-grey-cascade"></div>
                        </div>
                    </div>
                 </div>

                 <div class="step_1">
                     <div class="margin-top-20 step_header">
                         <h2 class="text-center step_title"><?php echo $this->lang->line('enrollments_select_course_group');?></h2>
                     </div>
                     <div class="row margin-top-20 step_content base_info_step">
                         <div class="col-xs-11 col-sm-8 col-sm-offset-2 ">
                             <?php if($allow_group_multicourse == 1){ ?>
                                 <div class="form-group text-left circle_select_div enrollments_select_group ">
                                     <lable><?php echo $this->lang->line('group'); ?>:</lable>
                                     <select class="form-control" name="select_group">
                                         <option value=""><?php echo $this->lang->line('enrollments_select_group'); ?></option>
                                         <?php if(!empty($groups)){ ?>
                                             <?php foreach($groups as $group) { ?>
                                                 <option value="<?php echo $group->id; ?>"><?php echo $group->name; ?></option>
                                             <?php } ?>
                                         <?php } ?>
                                     </select>
                                     <a href="#" class="filter_groups_icon" > <i class="fa fa-filter" aria-hidden="true"></i> </a>
                                 </div>

                                 <div class="form-group text-left">
                                     <lable>
                                         <?php echo $this->lang->line('course'); ?>
                                         <input disabled type="text" class="courses_select2 form-control"/>
                                     </lable>
                                 </div>


                             <?php }else{?>
                            <div class="form-group text-left circle_select_div ">
                                <lable>
                                    <?php echo $this->lang->line('course'); ?>
                                    <select class="form-control" name="select_course">
                                         <option value=""><?php echo $this->lang->line('enrollments_select_course'); ?></option>
                                        <?php if(!empty($courses)){ ?>
                                            <?php foreach($courses as $course) { ?>
                                                <?php if(!empty($course->id)) {?>
                                                   <option value="<?php echo $course->id; ?>"><?php echo $course->name; ?></option>
                                                 <?php } ?>
                                            <?php } ?>
                                        <?php } ?>
                                    </select>
                                </lable>
                          </div>

                            <div class="form-group text-left circle_select_div enrollments_select_group ">
                                <lable><?php echo $this->lang->line('group'); ?>:</lable>
                                <select disabled class="form-control" name="select_group">
                                     <option value=""><?php echo $this->lang->line('enrollments_select_group'); ?></option>
                                    <?php if(!empty($groups)){ ?>
                                        <?php foreach($groups as $group) { ?>
                                               <option value="<?php echo $group->id; ?>"><?php echo $group->name; ?></option>
                                        <?php } ?>
                                    <?php } ?>
                                </select>
                                   <a href="#" class="filter_groups_icon" > <i class="fa fa-filter" aria-hidden="true"></i> </a>
                            </div>
                             <?php }?>
                         </div>
                         <div class="col-xs-12 col-sm-10 col-sm-offset-0 ">
                             <div class="text-left back_save_group">
                                 <a type="button" href="<?php echo $_base_url; ?>enrollments" class="btn btn-circle btn-default-back back_system_settigs exit_steps"><?php echo $this->lang->line('exit'); ?></a>
                                 <button disabled="disabled" class="btn btn-primary btn-circle enroll_btn select_student_enroll_btn hidden-xs hidden-sm hidden-md"><i class="fa fa-plus"></i> <?php echo $this->lang->line('enrollments_add_students'); ?></button>
                                 <button  disabled="disabled" type="button" style="" class="btn btn-primary btn-circle text-center  add_past_group hidden-xs hidden-sm hidden-md" ><?php echo $this->lang->line('enrollments_add_past_group'); ?></button>

                                 <button type="button" class="btn btn-primary btn-circle pull-right text-center step1_to_step2" data-next_step="2"><?php echo $this->lang->line('continue'); ?> <i class="fa fa-arrow-right" aria-hidden="true"></i></button>
                                 <button type="button" style="display: none" class="btn btn-primary btn-circle pull-right text-center hide_show_already_enrolled hidden-xs hidden-sm hidden-md" ><?php echo $this->lang->line('enrollments_show_enrolled'); ?></button>
                                 <div class="overf_hidden">
                                 <button disabled="disabled"  class="btn btn-primary btn-circle enroll_btn select_student_enroll_btn hidden-lg"><i class="fa fa-plus"></i> <?php echo $this->lang->line('enrollments_add_students'); ?></button>
                                 <button type="button" style="display: none" class="btn btn-primary btn-circle pull-right text-center hide_show_already_enrolled hidden-lg" ><?php echo $this->lang->line('enrollments_show_enrolled'); ?></button>
                                 </div>
                                     <a type="button" href="<?php echo $_base_url; ?>enrollments" class="btn btn-circle text-center btn-default-back back_system_settigs_min exit_steps"><?php echo $this->lang->line('exit'); ?></a>

                             </div>
                             <div class="form-group select_student_enroll_btn margin-top-20" style="display: none">
                                 <div class="">
                                     <!--                            <a href="#" class="btn btn-primary btn-circle pull-right enroll_btn"><i class="fa fa-plus"></i> --><?php //echo $this->lang->line('enrollments_add_students'); ?><!--</a>-->

                                     <div class=" select_student_part" style="display: none">
                                         <div id="the-basics" class="text-right pull-right" >
                                             <input  type="text" class="form-control  text-left typeahead " name="select_student"  />
                                           
                                             <button class="btn btn-xs btn-primary students_multiselect"> <i class="fa fa-plus"></i> <?php echo $this->lang->line('enrollments_multiselect'); ?></button>
                                         </div>
                                     </div>
                                 </div>
                             </div>
                             <div class="clearfix"></div>
                             <div class="form-group select_student_part" style="display: none">
                                 <div class=" back_save_group text-right">
                                     <button  class="btn btn-primary btn-circle add_selected_student"><?php echo $this->lang->line('add'); ?></button>
                                     <button type="button" class="btn btn-circle btn-default-back btn_cancel" data-dismiss="modal"><?php echo $this->lang->line('cancel'); ?></button>
                                 </div>
                             </div>

                             <div class="form-group select_student_part_group" style="display: none">
                                     <div id="" class="text-right pull-right" >
                                         <div class="form-group text-left circle_select_div enrollments_select_group ">
                                             <lable><?php echo $this->lang->line('group'); ?>:</lable>
                                             <select class="form-control" name="select_past_group">

                                             </select>
                                         </div>
                                     </div>
                             </div>
                             <div class="clearfix"></div>
                             <div class="form-group select_student_part_group" style="display: none">
                                 <div class=" back_save_group text-right">
                                     <button type="button" class="btn btn-circle btn-default-back btn_cancel" ><?php echo $this->lang->line('cancel'); ?></button>
                                 </div>
                             </div>
                         </div>
                     </div>

                    <div class="">
                        <div id="SelectedStudentsTable"></div>
                    </div>
                    <div class="clearfix"></div>
                    <div style="display: none" id="AlreadyEnrolaedsTable"></div>



                     <!--                     <div class="text-left back_save_group">-->
<!--                         <a type="button" href="--><?php //echo $_base_url; ?><!--enrollments" class="btn btn-circle btn-default-back back_system_settigs exit_steps">--><?php //echo $this->lang->line('exit'); ?><!--</a>                        -->
<!--                         <button type="button" class="btn btn-primary btn-circle pull-right text-center step1_to_step2" data-next_step="2">--><?php //echo $this->lang->line('continue'); ?><!-- <i class="fa fa-arrow-right" aria-hidden="true"></i></button>-->
<!--                         <a type="button" href="--><?php //echo $_base_url; ?><!--enrollments" class="btn btn-circle text-center btn-default-back back_system_settigs_min exit_steps">--><?php //echo $this->lang->line('exit'); ?><!--</a>-->
<!--                     </div>-->
              </div>


                 <div class="step_2" style="display: none">
                     <div class="margin-top-20 step_header">
                         <h2 class="text-center step_title"><?php echo $this->lang->line('enrollments_refine');?></h2>
                     </div>
                     <div class="row margin-top-20 step_content base_info_step">
                         <div class="col-xs-12 col-sm-6 col-sm-offset-3 ">
                            <div class="form-group text-left">
                                <div class="category_part circle_select_div">

                                        <lable><?php echo $this->lang->line('category'); ?>:</lable>

                                    <div class="text-left no-padding selected_category">

                                    </div>
                                 </div>
                                <div class="clearfix"></div>

                                <div class="no_coursesTable" style="display: none;">

                                </div>
                                    <div id="CoursesTable">

                                    </div>
                                
                                <div class="clearfix"></div>
                                <?php if($allow_group_change_startdate == '1'){ ?>
                                    <div class="form-group row ">
                                        <div class="col-sm-6">
                                            <lable><?php echo $this->lang->line('start_date'); ?>
                                            <input class="form-control" type="text" id="step2_start_date" name="start_date" />
                                            </lable>
                                        </div>
                                        <div class="col-sm-6">
                                            <lable><?php echo $this->lang->line('end_date'); ?>
                                             <input class="form-control" id="step2_end_date" type="text" name="end_date" />
                                            </lable>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
<!--                             <div class="row margin-top-20 margin-right-10">-->
<!--                                 <button class="btn btn-default pull-left btn-circle step2_to_step1">--><?php //echo $this->lang->line('back'); ?><!--</button>-->
<!--                                 <button class="btn pull-right btn-success btn-circle step2_to_step3">--><?php //echo $this->lang->line('next'); ?><!--</button>-->
<!--                             </div>-->
                             <div class="text-left back_save_group">
                                 <a type="button" href="<?php echo $_base_url; ?>enrollments" class="btn btn-circle btn-default-back back_system_settigs exit_steps"><?php echo $this->lang->line('exit'); ?></a>
                                 <button type="button" class="btn btn-circle btn-default-back step2_to_step1 back_system_settigs" ><i class="fa fa-arrow-left" aria-hidden="true"></i> <?php echo $this->lang->line('back'); ?></button>
                                 <button type="button" class="btn btn-primary btn-circle pull-right text-center step2_to_step3" data-next_step="2"><?php echo $this->lang->line('continue'); ?> <i class="fa fa-arrow-right" aria-hidden="true"></i></button>
                                 <button type="button" class="btn btn-circle btn-default-back step2_to_step1 back_system_settigs_min" ><i class="fa fa-arrow-left" aria-hidden="true"></i> <?php echo $this->lang->line('back'); ?></button>
                                 <a type="button" href="<?php echo $_base_url; ?>enrollments" class="btn btn-circle text-center btn-default-back back_system_settigs_min exit_steps"><?php echo $this->lang->line('exit'); ?></a>
                             </div>
                         </div>
                     </div>
                </div>
                <div class="step_3" style="display: none">
                    <div class="margin-top-20 step_header">
                        <h2 class="text-center step_title"><?php echo $this->lang->line('enrollments_payment');?></h2>
                    </div>

                    <div class="row margin-top-20 ">
                        <div class="col-xs-12 col-sm-6 col-sm-offset-3 ">


                        <div class="form-group  text-left predefined_rate_part">
                            <div class=" text-left no-padding predefined_rate_select circle_select_div" >
                                <lable><?php echo $this->lang->line('enrollments_predefined_rate'); ?>
                                <select class="form-control" name="select_rate">
                                </select>
                                </lable>
                            </div>
                        </div>
                            <div class="text-left  back_save_group">
                                <a type="button" href="<?php echo $_base_url; ?>enrollments" class="btn btn-circle btn-default-back back_system_settigs exit_steps"><?php echo $this->lang->line('exit'); ?></a>
                                <button type="button" class="btn btn-circle btn-default-back step3_to_step2 back_system_settigs" ><i class="fa fa-arrow-left" aria-hidden="true"></i> <?php echo $this->lang->line('back'); ?></button>
                                <button type="button" class="btn btn-primary btn-circle pull-right text-center step3_to_step4" data-next_step="2"><?php echo $this->lang->line('continue'); ?> <i class="fa fa-arrow-right" aria-hidden="true"></i></button>
                                <button type="button" class="btn btn-circle btn-default-back step3_to_step2 back_system_settigs_min" ><i class="fa fa-arrow-left" aria-hidden="true"></i> <?php echo $this->lang->line('back'); ?></button>
                                <a type="button" href="<?php echo $_base_url; ?>enrollments" class="btn btn-circle text-center btn-default-back back_system_settigs_min exit_steps"><?php echo $this->lang->line('exit'); ?></a>
                            </div>
                        </div>
                    </div>
                    <div class="row margin-top-20 ">
                        <div class="col-xs-12">
                            <div id="feesTable"></div>
                        </div>
                        <div class="clearfix"></div>
<!--                        <div class="row ">-->
<!--                            <div class="text-left col-xs-12 back_save_group">-->
<!--                                <a type="button" href="--><?php //echo $_base_url; ?><!--enrollments" class="btn btn-circle btn-default-back back_system_settigs exit_steps">--><?php //echo $this->lang->line('exit'); ?><!--</a>-->
<!--                                <button type="button" class="btn btn-circle btn-default-back step3_to_step2 back_system_settigs" ><i class="fa fa-arrow-left" aria-hidden="true"></i> --><?php //echo $this->lang->line('back'); ?><!--</button>-->
<!--                                <button type="button" class="btn btn-primary btn-circle pull-right text-center step3_to_step4" data-next_step="2">--><?php //echo $this->lang->line('continue'); ?><!-- <i class="fa fa-arrow-right" aria-hidden="true"></i></button>-->
<!--                                <button type="button" class="btn btn-circle btn-default-back step3_to_step2 back_system_settigs_min" ><i class="fa fa-arrow-left" aria-hidden="true"></i> --><?php //echo $this->lang->line('back'); ?><!--</button>-->
<!--                                <a type="button" href="--><?php //echo $_base_url; ?><!--enrollments" class="btn btn-circle text-center btn-default-back back_system_settigs_min exit_steps">--><?php //echo $this->lang->line('exit'); ?><!--</a>-->
<!--                            </div>-->
<!--                        </div>-->
                    </div>
                    
                    
                </div>
                <div class="step_4" style="display: none">
                    <div class="margin-top-20 step_header">
                        <h2 class="text-center step_title"><?php echo $this->lang->line('enrollments_confirm_action');?></h2>
                        <p class="text-center"><?php echo $this->lang->line('enrollments_please_confirm_action'); ?></p>
                    </div>

                     <h4 class="personalized"><?php echo $this->lang->line('custom_fields'); ?></h4>
                                                 <?php  
                                                 if(isset($student->custom_fields)){
                                                 $custom = explode(',',$student->custom_fields);
                                                    }else{
                                                    $custom = array();
                                                    } 
                                                     if(!empty($customfields_fields)) { $i=0; ?>
                                    <?php foreach($customfields_fields as $customfields){  ?>
                                    <div class="form-group text-left circle_select_div">

                                    <?php if($customfields['field_type'] == 'textarea' && $customfields['active']== 1){ ?>

                                        <lable><?php echo $customfields['field_name']; ?>:</lable>
                                        <textarea type="text" class="form-control " name="custom_fields[]" <?php if($customfields['required']== 1){echo 'required';}  if($customfields['disabled']== 1){echo 'disabled';} ?>><?php if(!empty($custom[$i])){ echo $custom[$i]; }else{ }?></textarea>
                                    <?php $i++;} elseif($customfields['field_type'] =='input' && $customfields['active']== 1){ ?>
                                        <lable><?php echo  $customfields['field_name']; ?>:</lable>
                                        <input type="text" <?php if($customfields['required']== 1){echo 'required';}  
                                        if($customfields['disabled']== 1){
                                            echo 'disabled';
                                        } ?>  class="form-control" name="custom_fields[]" value="<?php if(!empty($custom[$i])){ echo $custom[$i]; }else{ }?>">
                                    <?php $i++;} 
                                    
                                    elseif($customfields['field_type'] =='select' && $customfields['active']== 1){ ?>
                                     <lable><?php echo  $customfields['field_name']; ?>:</lable>
                                        <select class="form-control" name="custom_fields[]">
                                            <?php 
                                            $options = explode(',',$customfields['options']);
                                            foreach ($options as $value) {?>
                                                <option value="<?php echo $value;?>" <?php if(!empty($custom[$i]) && $custom[$i] == $value){ echo "selected"; }else{ }?>><?php echo $value;?></option>
                                            <?php }?>
                                        </select>            
                                    <?php $i++;} 
                                  elseif($customfields['field_type'] =='datepicker' && $customfields['active']== 1){ ?>
                                        <lable><?php echo  $customfields['field_name']; ?>:</lable>
                                        <input type="text" <?php if($customfields['required']== 1){echo 'required';}  
                                        if($customfields['disabled']== 1){
                                            echo 'disabled';
                                        } ?>  class="form-control datepicker" name="custom_fields[]" value="<?php if(!empty($custom[$i])){ echo $custom[$i]; }else{ }?>">
                                    <?php $i++;} 
                                    elseif($customfields['field_type'] =='checkbox' && $customfields['active']== 1){ ?>
                                        <input type="checkbox" <?php if($customfields['required']== 1){echo 'required';}  
                                        if($customfields['disabled']== 1){
                                            echo 'disabled';
                                        } ?>   name="custom_fields[]" <?php if(!empty($custom[$i])){ echo "checked"; }else{ }?> value="yes">&nbsp;&nbsp;&nbsp;<?php echo  $customfields['field_name']; ?>
                                    <?php $i++;}
                                    else{ 
                                    
                                     }?>
                                    </div>
                                     <?php
                                     }
                                 }?>

<!--                        <p>--><?php //echo $this->lang->line('enrollments_confirm_action'); ?><!--</p>-->

<!--                        <p><button class="btn btn-default confirm_action_btn">--><?php //echo $this->lang->line('enrollments_confirm'); ?><!--</button></p>-->

<!--                    <div class="row margin-top-20 margin-right-10">-->
<!--                        <button class="btn btn-default pull-left btn-circle step4_to_step3">--><?php //echo $this->lang->line('back'); ?><!--</button>-->
<!--                    </div>-->
                    <div class="row ">
                        <div class="text-center col-xs-12 back_save_group">
                            <a type="button" href="<?php echo $_base_url; ?>enrollments" class="btn btn-circle btn-default-back back_system_settigs exit_steps"><?php echo $this->lang->line('exit'); ?></a>
                            <button type="button" class="btn btn-circle btn-default-back step4_to_step3 back_system_settigs" ><i class="fa fa-arrow-left" aria-hidden="true"></i> <?php echo $this->lang->line('back'); ?></button>
                            <button class="btn btn-primary btn-circle  confirm_action_btn"><?php echo $this->lang->line('enrollments_confirm'); ?></button>

                            <button type="button" class="btn btn-circle btn-default-back step4_to_step3 back_system_settigs_min" ><i class="fa fa-arrow-left" aria-hidden="true"></i> <?php echo $this->lang->line('back'); ?></button>
                            <a type="button" href="<?php echo $_base_url; ?>enrollments" class="btn btn-circle text-center btn-default-back back_system_settigs_min exit_steps"><?php echo $this->lang->line('exit'); ?></a>
                        </div>
                    </div>
                </div>

            </div>

              <div class="clearfix"></div>

                <div class="modal fade" id="FilterGroupsModal" tabindex="-1" role="dialog"  aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-body">
                                <div id="FilterGroupsTable">

                                </div>
                            </div>
                            <div class="modal-footer">
                                <button  class="btn blue select_groups_btn"><?php echo $this->lang->line('enrollments_select'); ?></button>
                                <button type="button" class="btn default btn-default-back" data-dismiss="modal"><?php echo $this->lang->line('close'); ?></button>
                            </div>

                        </div>
                        <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                </div>
                <div class="modal fade" id="deleteConfirmModal" tabindex="-1" role="dialog"  aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                <h4 class="modal-title" id="dataConfirmLabel"><?php echo $this->lang->line('please_confirm'); ?></h4>
                            </div>
                            <div class="modal-body">
                                 <p><?php echo $this->lang->line('are_you_sure_delete'); ?></p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn default" data-dismiss="modal"><?php echo $this->lang->line('close'); ?></button>
                                <button id="deleteConfirmOK"  class="btn red"><?php echo $this->lang->line('delete'); ?></button>
                            </div>

                        </div>
                        <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                </div>






            <div class="modal fade" id="students_multiselect" tabindex="-1" role="dialog"  aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                            <h4 class="modal-title"><?php echo $this->lang->line('enrollemts_add_students'); ?></h4>
                        </div>
                        <div class="modal-body">
                            <div id="NotEnrolledStudentsTable">

                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-default-back" data-dismiss="modal"><?php echo $this->lang->line('close'); ?></button>
                            <button  class="btn btn-primary addStudents"><?php echo $this->lang->line('add'); ?></button>
                        </div>

                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            
            <div class="modal fade" id="students_from_past_group" tabindex="-1" role="dialog"  aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                            <h4 class="modal-title"><?php echo $this->lang->line('enrollments_enroll_from_group'); ?></h4>
                        </div>
                        <div class="modal-body">
                            <div style="" id="PastStudentsTable"></div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-default-back" data-dismiss="modal"><?php echo $this->lang->line('close'); ?></button>
                            <button  class="btn btn-primary addStudents"><?php echo $this->lang->line('add'); ?></button>
                        </div>

                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
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
//var _courses = <?php //echo json_encode($courses); ?>//;
var _groups = <?php echo json_encode($groups); ?>;
var _allow_group_multicourse = <?php echo $allow_group_multicourse; ?>;
//var _notEnrolledStudents = <?php //echo json_encode($not_enrolled_students); ?>//;
//var _enrolaeds_students = <?php //echo json_encode($enrolaeds_students); ?>//;


</script>