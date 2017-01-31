
<div class="tabbable-line">
    <div class="form-group row ">
        <div class="col-sm-3">
            <lable><?php echo $this->lang->line('start_date'); ?> :
                <span id="group_calendar_start_date"><?php echo $start_date; ?></span>
<!--                <input disabled class="form-control" type="text" id="group_calendar_start_date" name="group_start_date" />-->
            </lable>
        </div>
        <div class="col-sm-3">
            <lable><?php echo $this->lang->line('end_date'); ?> :
                <span  id="group_calendar_end_date"><?php echo $end_date; ?></span>
<!--                <input disabled class="form-control" id="group_calendar_end_date" type="text" name="group_end_date" />-->
            </lable>
        </div>
    </div>
    <ul class="nav nav-tabs ">
        <li class="active">
            <a href="#tab_3_1" class="calendar_view" data-toggle="tab"
               aria-expanded="true"> <?php echo $this->lang->line('groups_timetable'); ?> </a>
        </li>
        <li class="">
            <a href="#tab_3_2" data-toggle="tab"
               aria-expanded="false"> <?php echo $this->lang->line('groups_events'); ?></a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tools">
        </div>
        <div class="tab-pane active " id="tab_3_1">


            <div class="row">
                <div class="col-md-9">
                    <div id="calendar" class="margin-top-10 portlet light portlet-fit  calendar fc fc-ltr fc-unthemed"></div>
                </div>
                <div class="col-md-3 student_documents_table  no-padding">
                    <div id="calendar_right_bar" >
                        <div id="datePicker" class="datepicker ">
                        </div>

                        <table border="1" class="margin-top-10" id="CourseTagsTable">
                            <thead>
                            <tr>
                                <th> <?php echo $this->lang->line('groups_course_id') ?></th>
                                <th><?php echo $this->lang->line('groups_description') ?></th>
                                <th><?php echo $this->lang->line('color') ?></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if(!empty($courses)){ ?>
                                <?php foreach($courses as $course){ ?>
                                    <tr data-course_id="<?php echo $course->courseid; ?>">
                                        <td>
                                            <?php echo $course->courseid; ?>
                                        </td>
                                        <td>
                                            <?php echo $course->course_description; ?>
                                        </td>
                                        <td>
                                             <div class="class_color_box" style="background-color: <?php echo '#'.$course->color; ?>" ></div>
                                        </td>

                                    </tr>
                                <?php } ?>
                            <?php } ?>
                            </tbody>
                        </table>

                    </div>
                </div>

            </div>
         </div>

        <div class="tab-pane student_sub_tab" id="tab_3_2">
            <div id="groups_events_table_empty" class=" no_data_table">

            </div>
         <div id="CalendarEventTable" class="student_documents_table" >

         </div>

            <div class="mt-element-step event_generator steps" style="display: none">

                <h2 class="text-left"><?php echo $this->lang->line('groups_event_generator'); ?></h2>

<!--                <div class="portlet light">-->
<!--                    <div class="mt-element-step">-->
<!--                        <div class="row step-line">-->
<!---->
<!--                    <div class="col-md-3 mt-step-col active step_1">-->
<!--                        <div class="mt-step-number bg-white text-left">1.--><?php //echo $this->lang->line('groups_service'); ?><!--</div>-->
<!--                        <div class="mt-step-title uppercase font-grey-cascade"></div>-->
<!--                        <div class="mt-step-content font-grey-cascade"></div>-->
<!--                    </div>-->
<!--                    <div class="col-md-3 mt-step-col step_2">-->
<!--                        <div class="mt-stepr bg-white text-left">2.--><?php //echo $this->lang->line('groups_intervals'); ?><!--</div>-->
<!--                        <div class="mt-step-title uppercase font-grey-cascade"></div>-->
<!--                        <div class="mt-step-content font-grey-cascade"></div>-->
<!--                    </div>-->
<!--                    <div class="col-md-3 mt-step-col step_3 ">-->
<!--                        <div class="mt-step bg-white text-left">3.--><?php //echo $this->lang->line('groups_refine_time'); ?><!--</div>-->
<!--                        <div class="mt-step-title uppercase font-grey-cascade"></div>-->
<!--                        <div class="mt-step-content font-grey-cascade"></div>-->
<!--                    </div>-->
<!--                    <div class="col-md-3 mt-step-col step_4 ">-->
<!--                        <div class="mt-step bg-white text-left">4.--><?php //echo $this->lang->line('groups_finish'); ?><!--</div>-->
<!--                        <div class="mt-step-title uppercase font-grey-cascade"></div>-->
<!--                        <div class="mt-step-content font-grey-cascade"></div>-->
<!--                    </div>-->
<!--                </div>-->
<!--                    </div>-->
<!--                </div>-->

                    <div class="mt-element-step">
                        <div class="row step-line">
                            <div class="col-sm-3 mt-step-col step_1 first active " id="template_step_1">
                                <div class="mt-step-number bg-white ">1</div>
                                <div class="mt-step-title uppercase font-grey-cascade"><?php echo $this->lang->line('groups_service'); ?></div>
                                <div class="mt-step-content font-grey-cascade"></div>
                            </div>
                            <div class="col-sm-3 mt-step-col step_2" id="template_step_2">
                                <div class="mt-step-number bg-white">2</div>
                                <div class="mt-step-title uppercase font-grey-cascade"><?php echo $this->lang->line('groups_intervals'); ?></div>
                                <div class="mt-step-content font-grey-cascade"></div>
                            </div>
                            <div class="col-sm-3 mt-step-col step_3" id="template_step_3">
                                <div class="mt-step-number bg-white">3</div>
                                <div class="mt-step-title uppercase font-grey-cascade"><?php echo $this->lang->line('groups_refine_time'); ?></div>
                                <div class="mt-step-content font-grey-cascade"></div>
                            </div>
                            <div class="col-sm-3 mt-step-col step_4 last" id="template_step_4">
                                <div class="mt-step-number bg-white">4</div>
                                <div class="mt-step-title uppercase font-grey-cascade"><?php echo $this->lang->line('segment');?></div>
                                <div class="mt-step-content font-grey-cascade"></div>
                            </div>
                        </div>
                    </div>

                    <!-- BEGIN PAGE CONTENT INNER -->

            </div>

            <div id="generator_step_1" class="col-md-12 generator_content steps " style="display: none">
                <div class="row margin-top-20 step_header">
                    <h2 class="text-center step_title"><?php echo $this->lang->line('groups_please_fillout_inform'); ?>:</h2>
                </div>
                <form class="form col-xs-12 col-sm-6 col-sm-offset-3" name="wizard_service">
                    <div class="form-group text-left circle_select_div">
                             <label >
                                 <?php echo $this->lang->line('groups_course'); ?>:
                             </label>
                             <select name="select_course" class="form-control">
                                 <option value=""><?php echo $this->lang->line('groups_select_course'); ?></option>
                                 <?php if(!empty($courses)){?>
                                     <?php foreach($courses as $course){ ?>
                                         <?php $select_course = ''; ?>
                                         <?php if(isset($one_course_data->courseid) && $course->courseid == $one_course_data->courseid){
                                             $select_course = 'selected="selected"';
                                         }?>
                                         <option value="<?php echo $course->courseid; ?>" <?php echo $select_course; ?>><?php echo $course->courseid.'-'.$course->course_description; ?></option>
                                     <?php } ?>
                                 <?php } ?>
                             </select>
                        </div>
                    <div class="form-group text-left hours_input">
                             <label >
                                 <?php echo $this->lang->line('groups_hours'); ?>:
                             </label>
                            <input type="text" readonly class="form-control" name="hours" value="<?php echo isset($one_course_data->hours) ? floatval($one_course_data->hours) . ' ' . $this->lang->line('groups_hours') : '' ;?>" />
                         </div>
                    <div class="form-group ">
                        <h4><?php echo $this->lang->line('groups_calculate_later'); ?></h4>
                    </div>

                    <div class="form-group circle_select_div text-left">
<!--                         <label >-->
<!--                             --><?php //echo $this->lang->line('groups_mine_teacher'); ?><!--:-->
<!--                         </label>-->
                        <select <?php echo $disable; ?> name="select_min_teacher" class="form-control select_classroom">
                            <option value=""><?php echo $this->lang->line('groups_select_teacher'); ?></option>
                            <?php if(!empty($teachers_for_events)){ ?>
                                <?php foreach($teachers_for_events as $teacher){ ?>
                                    <?php $select = ''; ?>
                                    <?php if(isset($one_course_data->teacher_id) && $teacher->teacher_id == $one_course_data->teacher_id){
                                        $select = 'selected="selected"';
                                    }?>
                                    <option value="<?php echo $teacher->teacher_id; ?>"  <?php echo $select; ?>><?php echo $teacher->teacher_name; ?></option>
                                <?php } ?>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="form-group circle_select_div text-left">
<!--                        <label>-->
<!--                            --><?php //echo $this->lang->line('classroom'); ?><!--:-->
<!--                        </label>-->
                        <select <?php echo $disable; ?> name="select_classroom" class="form-control select_classroom">
                            <option value="0"><?php echo $this->lang->line('groups_select_classroom'); ?></option>
                            <?php if(!empty($classrooms)){ ?>
                                <?php foreach($classrooms as $classroom){ ?>
                                    <?php $select = ''; ?>
                                    <?php if(isset($one_course_data->classroom_id) && $classroom->id == $one_course_data->classroom_id){
                                        $select = 'selected="selected"';
                                        echo  '<option value= "' . $classroom->id .'" ' . $select .'>' . $classroom->classroom . '</option>';
                                    }else{?>
                                        <option value="<?php echo $classroom->id; ?>"  <?php echo $select; ?>><?php echo $classroom->classroom; ?></option>
                                        <?php } ?>
                                <?php } ?>
                            <?php } ?>
                        </select>
                     </div>

                    <div class="form-group circle_select_div text-left add_second_teacher">
                        <label>
                            <?php echo $this->lang->line('groups_secondary_teacher'); ?>:
                        </label>
                        <select <?php echo $disable; ?> name="select_second_teacher_1" class="form-control margin-bottom-10">
                            <option value="0"><?php echo $this->lang->line('groups_select_teacher'); ?></option>
                            <?php if(!empty($teachers_for_events)){ ?>
                                <?php foreach($teachers_for_events as $teacher){ ?>
                                    <?php $select = ''; ?>
<!--                                    --><?php //if(isset($one_course_data->second_teacher1) && $teacher->teacher_id == $one_course_data->second_teacher1){
//                                        $select = 'selected="selected"';
//                                    }?>
                                    <option value="<?php echo $teacher->teacher_id; ?>" <?php echo $select; ?>><?php echo $teacher->teacher_name; ?></option>
                                <?php } ?>
                            <?php } ?>
                        </select>
                        <select <?php echo $disable; ?> name="select_second_teacher_2" class="form-control margin-bottom-10">
                            <option value="0"><?php echo $this->lang->line('groups_select_teacher'); ?></option>
                            <?php if(!empty($teachers_for_events)){ ?>
                                <?php foreach($teachers_for_events as $teacher){ ?>
                                    <?php $select = ''; ?>
<!--                                    --><?php //if(isset($one_course_data->second_teacher2) && $teacher->teacher_id == $one_course_data->second_teacher2){
//                                        $select = 'selected="selected"';
//                                    }?>
                                    <option value="<?php echo $teacher->teacher_id; ?>" <?php echo $select; ?>><?php echo $teacher->teacher_name; ?></option>
                                <?php } ?>
                            <?php } ?>
                        </select>
                        <select <?php echo $disable; ?> name="select_second_teacher_3" class="form-control margin-bottom-10">
                            <option value="0"><?php echo $this->lang->line('groups_select_teacher'); ?></option>
                            <?php if(!empty($teachers_for_events)){ ?>
                                <?php foreach($teachers_for_events as $teacher){ ?>
                                    <?php $select = ''; ?>
<!--                                    --><?php //if(isset($one_course_data->second_teacher3) && $teacher->teacher_id == $one_course_data->second_teacher3){
//                                        $select = 'selected="selected"';
//                                    }?>
                                    <option value="<?php echo $teacher->teacher_id; ?>" <?php echo $select; ?>><?php echo $teacher->teacher_name; ?></option>
                                <?php } ?>
                            <?php } ?>
                        </select>

                    </div>

                    <div class="col-md-12 text-left back_save_group event_generator">
                        <button class="btn btn-circle btn-default-back back_event_list " ><?php echo $this->lang->line('back'); ?></button>
                        <button type="button" class="btn btn-primary btn-circle  generator_event_btn next"><?php echo $this->lang->line('continue'); ?> <i class="fa fa-arrow-right" aria-hidden="true"></i></button>
                    </div>
                </form>
            </div>

                     <!--STEP 1 -> STEP 2-->

            <div id="generator_step_2" class="generator_content steps" style="display: none" >
                <div class="col-md-12 margin-bottom-30">
                    <h3 class="text-center step_title"><?php echo $this->lang->line('groups_please_fillout_inform_interval'); ?>:</h3>
                </div>
                <form class="form col-xs-12 " name="wizard_service">
                    <div class="form-content ">
                        <div class="form-group text-right col-md-12 ">
                            <button class="btn btn-primary btn-circle  add_interval_btn"><i class="fa fa-plus"></i> <?php echo $this->lang->line('groups_add_interval'); ?></button>
                            <p class="add_interval_btn_notexist text-danger text-right" style="display: none"><?php echo $this->lang->line('groups_you_can_add_5interval'); ?></p>

                        </div>
                        <div class="ze_wrapper">
                            <table class="table  dbtable  dbtable_hover_theme">
                                <thead class="form-group text-left   interval_lable" style="display:none">
                                    <tr>
                                        <th >
                                            <label >
                                                <?php echo $this->lang->line('start_date'); ?>:
                                            </label>
                                        </th>
                                        <th class="  ">
                                            <label >
                                                <?php echo $this->lang->line('end_date'); ?>:
                                            </label>
                                        </th>
                                        <th class=" week_days" >
                                            <div class="pull-left "><?php echo $this->lang->line('groups_mon'); ?></div>
                                            <div class="pull-left"><?php echo $this->lang->line('groups_tue'); ?></div>
                                            <div class="pull-left"><?php echo $this->lang->line('groups_wed'); ?></div>
                                            <div class="pull-left"><?php echo $this->lang->line('groups_thu'); ?></div>
                                            <div class="pull-left"><?php echo $this->lang->line('groups_fri'); ?></div>
                                            <div class="pull-left"><?php echo $this->lang->line('groups_sat'); ?></div>
                                            <div class="pull-left"><?php echo $this->lang->line('groups_sun'); ?></div>
                                        </th>
                                        <th class=" time_select" >
                                            <label >
                                                <?php echo $this->lang->line('groups_start_time'); ?>:
                                            </label>
                                        </th>
                                        <th class="col- time_select" >
                                            <label >
                                                <?php echo $this->lang->line('groups_end_time'); ?>:
                                            </label>
                                        </th>
                                        <th><?php echo $this->lang->line('action'); ?></th>
                                    </tr>
                                </thead>
                                <tbody id="interval_info">

                                </tbody>
                                 <div id="default_interval_address">


                                 </div>
                            </table>
                        </div>



                    </div>

                    <div class="col-md-12 text-right back_save_group">
                        <button class="btn btn-circle btn-default-back generator_event_btn back pull-left"><?php echo $this->lang->line('back'); ?> </button>
                        <button type="button" class="btn btn-primary btn-circle  generator_event_btn next"><?php echo $this->lang->line('continue'); ?> <i class="fa fa-arrow-right" aria-hidden="true"></i></button>
                    </div>


                </form>
            </div>
            <div id="generator_step_3" class="steps" style="display:none">
                <div class="col-md-12 margin-bottom-30">
                    <h3 class="text-center step_title"><?php echo $this->lang->line('confirm_time_interval'); ?></h3>
                </div>
                <div class="" style="position:relative; z-index: 15">
                    <div class="col-sm-2">
                        <label><?php echo $this->lang->line('start_time'); ?></label>
                     </div>
                    <div class="col-sm-2">
                        <div  class="  step_3_start_time">

                        </div>
                    </div>
                    <div class="col-sm-2">
                        <label><?php echo $this->lang->line('end_time'); ?></label>
                     </div>
                    <div class="col-sm-2">
                        <div  class=" step_3_end_time">

                        </div>
                    </div>
                </div>

                    <div id="myCarousel" class="carousel slide" data-ride="carousel">
                        <!-- Indicators -->
                        <ol class="carousel-indicators">
                            <!--<li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                            <li data-target="#myCarousel" data-slide-to="1"></li>
                            <li data-target="#myCarousel" data-slide-to="2"></li>
                            <li data-target="#myCarousel" data-slide-to="3"></li>-->
                        </ol>

                        <!-- Wrapper for slides -->
                        <div class="carousel-inner" role="listbox">

                        </div>

                        <!-- Left and right controls -->
                        <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
                            <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
                            <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </a>
                    </div>



                <div id="slider">

                </div>
                <div class="col-md-12 text-right back_save_group">
                    <button class="btn btn-circle btn-default-back generator_event_btn back pull-left"><?php echo $this->lang->line('back'); ?> </button>
                    <button type="button" class="btn btn-primary btn-circle  generator_event_btn next"><?php echo $this->lang->line('continue'); ?> <i class="fa fa-arrow-right" aria-hidden="true"></i></button>
                </div>
            </div>
            <div id="generator_step_4" class="steps" style="display: none;">
                <div id="showCalendar" class=" portlet light portlet-fit  calendar fc fc-ltr fc-unthemed"></div>
                <div class="col-md-12 text-right back_save_group">
<!--                    <button class="btn btn-circle btn-default-back generator_event_btn back pull-left">--><?php //echo $this->lang->line('back'); ?><!-- </button>-->
                    <button type="button" class="btn btn-primary btn-circle  generator_event_btn next"><?php echo $this->lang->line('finish'); ?> </button>
                </div>
            </div>

        </div>
    </div>
</div>


<div class="modal fade" id="groupDeleteEventModal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><?php echo $this->lang->line("please_confirm"); ?></h4>
            </div>
            <div class="modal-body">
                <p><?php echo $this->lang->line('groups_delete_event_msg'); ?></p>
                <div class="form-group text-left">
                    <div class="col-md-9">
                        <label  class="text-danger">
                            <?php echo $this->lang->line('confirm_update_start_end_date'); ?>:
                        </label>
                    </div>
                    <div class="col-md-2">
                        <div id="the_basics_classroom">
                            <input type="checkbox" class="update_start_end_date">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->lang->line('close');?></button>
                <button type="button" class="btn red delete_event" data-dismiss="modal"><?php echo $this->lang->line('delete');?></button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="SelectAllEventsModal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title"><?php echo $this->lang->line('groups_select_all_events'); ?></h4>
            </div>
            <div class="modal-body">
                <p><?php echo $this->lang->line('groups_select_all_events_msg'); ?></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default cancel " data-dismiss="modal"><?php echo $this->lang->line('groups_cancel');?></button>
                <button type="button" class="btn blue select_page " data-select-type="this_page" data-dismiss="modal"><?php echo $this->lang->line('groups_this_page');?></button>
                <button type="button" class="btn blue select_page " data-select-type="all_pages" data-dismiss="modal"><?php echo $this->lang->line('groups_all_pages');?></button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="EditEventsModal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header ">
               <div class="text-left">
                   <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                   <h4 class="modal-title"><?php echo $this->lang->line('groups_edit_appointment'); ?></h4>
               </div>
            </div>
            <div class="modal-body">
                <form class="form-horizontal">
                    <div class="form-group text-left">
                        <div class="col-md-2">
                            <label >
                                <?php echo $this->lang->line('teacher'); ?>:
                            </label>
                        </div>
                        <div class="col-md-6">
                            <div id="the_basics_teachers">
                                <input  type="text" class="form-control typeahead " value="" name="event_teacher"  />
                                <img src="<?php echo base_url().'assets/global/img/loading/spinner1.gif'; ?>" class="input_spinner" style="display: none;">
                                <i class="fa fa-remove unassign_icon" title="Unassign" style="display: none"></i>
                            </div>
                        </div>
                    </div>
                    <div class="form-group text-left">
                        <div class="col-md-2">
                            <label >
                                <?php echo $this->lang->line('course'); ?>:
                            </label>
                        </div>
                        <div class="col-md-10">
                            <select name="select_course" disabled class="form-control" >

                            </select>
                        </div>
                    </div>
                    <div class="form-group text-left">
                        <div class="col-md-2">
                            <label >
                                <?php echo $this->lang->line('date'); ?>:
                            </label>
                        </div>
                        <div class="col-md-10">
                            <input type="text" name="event_date" class="form-control" />
                            <input type="text" name="event_date_hidden" class="form-control" id="classDateEvent" style="display: none" />
                        </div>
                    </div>

                    <div class="form-group text-left start_end_date_update" style="display: none">
                        <div class="col-md-9">
                            <label class="text-danger">
                                <?php echo $this->lang->line('confirm_update_start_end_date'); ?>:
                            </label>
                        </div>
                        <div class="col-md-2">
                            <div id="the_basics_classroom">
                                <input type="checkbox" class="update_start_end_date">
                            </div>
                        </div>
                    </div>

                    <div class="form-group text-left">
                        <div class="col-md-2">
                            <label >
                                <?php echo $this->lang->line('groups_period'); ?>:
                            </label>
                        </div>
                        <div class="col-md-3 circle_select_div">
                            <select class="form-control  start_period " id="" name="start_period" >

                            </select>
                        </div>
                        <div class="col-md-1 margin-top-5">
                            <span class="avail_to end_period_to " > to </span>
                        </div>

                        <div class="col-md-3 circle_select_div">
                            <select class="form-control end_period " id="" name="end_period" >
                            </select>
                        </div>

                    </div>
                    <div class="form-group text-left">
                        <div class="col-md-2">
                            <label >
                                <?php echo $this->lang->line('teacher'); ?>:
                            </label>
                        </div>
                        <div class="col-md-10">
                            <div class="col-md-8">
                            <div class="form-group text-left second_teacher_1" style="display: none;">
                                <input  type="text" class="form-control typeahead " value="" name="event_second_teacher1"  />
                                <img src="<?php echo base_url().'assets/global/img/loading/spinner1.gif'; ?>" class="input_spinner" style="display: none;">
                                <i class="fa fa-remove unassign_icon" title="Unassign" style="display: none"></i>
                            </div>
                                </div>
                            <div class="col-md-8">
                            <div class="form-group text-left second_teacher_2" style="display: none">
                                <input  type="text" class="form-control typeahead " value="" name="event_second_teacher2"  />
                                <img src="<?php echo base_url().'assets/global/img/loading/spinner1.gif'; ?>" class="input_spinner" style="display: none;">
                                <i class="fa fa-remove unassign_icon" title="Unassign" style="display: none"></i>
                            </div>
                                </div>
                            <div class="col-md-8">
                            <div class="form-group text-left second_teacher_3" style="display: none;">
                                <input  type="text" class="form-control typeahead " value="" name="event_second_teacher3"  />
                                <img src="<?php echo base_url().'assets/global/img/loading/spinner1.gif'; ?>" class="input_spinner" style="display: none;">
                                <i class="fa fa-remove unassign_icon" title="Unassign" style="display: none"></i>
                            </div>
                            </div>

                        </div>
                    </div>
                    <div class="form-group text-left">
                        <div class="col-md-2">
                            <label>
                                <?php echo $this->lang->line('classroom'); ?>:
                            </label>
                        </div>
                        <div class="col-md-6">
                            <div id="the_basics_classroom">
                                <input  type="text" class="form-control typeahead " value="" name="event_classroom"  />
                                <img src="<?php echo base_url().'assets/global/img/loading/spinner1.gif'; ?>" class="input_spinner" style="display: none;">
                                <i class="fa fa-remove unassign_icon" title="Unassign" style="display: none"></i>
                            </div>
                        </div>
                    </div>
                    <div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default cancel " data-dismiss="modal"><?php echo $this->lang->line('groups_cancel');?></button>
                <button type="button" class="btn blue save " ><?php echo $this->lang->line('save');?></button>
            </div>
                </form>

        </div>
    </div>
</div>
<div class="modal fade" id="eventpanel" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title"> <?php echo $this->lang->line('group_view_event');?> </h4>
            </div>
            <div class="modal-body">
                <div class="event_title"></div>
                <div class="event_date"></div>
                <label><strong><?php echo $this->lang->line('groups_detail');?></strong></label>
                <div class="event_detail"></div>
            </div>
            <div class="modal-footer">
                <i class="fa fa-bars pull-left" aria-hidden="true"></i>
                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->lang->line('close');?></button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="eventCustomFealds" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title"> <?php echo $this->lang->line('custom_fields');?> </h4>
            </div>
            <div class="modal-body">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->lang->line('close');?></button>
                <button type="button" class="btn btn-success save_custom_fields"><?php echo $this->lang->line('save');?></button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="confirmEditStudentEvent" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><?php echo $this->lang->line('please_confirm'); ?></h4>
            </div>
            <div class="modal-body">
                <h3><?php echo $this->lang->line('groups_confirm_update_student_events'); ?></h3>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success confirm_edit" data-dismiss="modal"><?php echo $this->lang->line('save');?></button>

                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->lang->line('close');?></button>
            </div>
        </div>
    </div>
</div>

<div id="addIntervalModal" class="modal fade groups" role="dialog">
    <div class="modal-dialog modal-lg">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><?php echo $this->lang->line('groups_add_interval'); ?></h4>
            </div>
            <div class="modal-body generator_content">
                <div class="ze_wrapper">
                    <table class="table  dbtable  dbtable_hover_theme">
                    <thead class="form-group text-left   interval_lable" style="">
                        <tr>
                            <th >
                                <label>
                                    <?php echo $this->lang->line('start_date'); ?>:
                                </label>
                            </th>

                            <th>
                                <label >
                                    <?php echo $this->lang->line('end_date'); ?>:
                                </label>
                            </th>
                            <th class=" week_days" >
                                <div class="pull-left "><?php echo $this->lang->line('groups_mon'); ?></div>
                                <div class="pull-left"><?php echo $this->lang->line('groups_tue'); ?></div>
                                <div class="pull-left"><?php echo $this->lang->line('groups_wed'); ?></div>
                                <div class="pull-left"><?php echo $this->lang->line('groups_thu'); ?></div>
                                <div class="pull-left"><?php echo $this->lang->line('groups_fri'); ?></div>
                                <div class="pull-left"><?php echo $this->lang->line('groups_sat'); ?></div>
                                <div class="pull-left"><?php echo $this->lang->line('groups_sun'); ?></div>
                            </th>
                            <th class="time_select" >
                                <label >
                                    <?php echo $this->lang->line('groups_start_time'); ?>:
                                </label>
                            </th>
                            <th class="time_select" >
                                <label >
                                    <?php echo $this->lang->line('groups_end_time'); ?>:
                                </label>
                            </th>
                        </tr>
                    </thead>
                        <tbody class="form-group text-left" id="line_default" style="">
                        <tr>
                            <td>
                                <input name="start_interval" class="form-control" />
                            </td>

                            <td>
                                <input name="end_interval" class="form-control" />
                            </td>

                            <td class="week_days  margin-top-10 check_circle" >
                                <div class="pull-left "><!--<img style="display:none" class="spinner_1" src="<?php /*echo base_url().'assets/global/img/loading/spinner1.gif' */?>"/>--> <i class="fa fa-check-circle" data-id="1"></i></div>
                                <div class="pull-left"><i class="fa fa-check-circle" data-id="2"></i></div>
                                <div class="pull-left"><i class="fa fa-check-circle" data-id="3"></i></div>
                                <div class="pull-left"><i class="fa fa-check-circle" data-id="4"></i></div>
                                <div class="pull-left"><i class="fa fa-check-circle" data-id="5"></i></div>
                                <div class="pull-left"><i class="fa fa-check-circle" data-id="6"></i></div>
                                <div class="pull-left" ><i class="fa fa-check-circle" data-id="0"></i></div>
                            </td>
                            <td class="time_select circle_select_div">
                                <select name="select_start_time" class="form-control">
                                </select>

                            </td>
                            <td class="time_select circle_select_div">
                                <select name="select_end_time" class="form-control">
                                </select>
                            </td>

                        </tr>
                        </tbody>
                     </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn blue add_interval" ><?php echo $this->lang->line('add'); ?></button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>
<div id="AssignTeacherModal" class="modal fade groups" role="dialog">
    <div class="modal-dialog ">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><?php echo $this->lang->line('groups_assign_a_teacher'); ?></h4>
            </div>
            <div class="modal-body ">
                <div class="col-sm-4 no-padding pull-left " >
                    <div class="no-padding" >
<!--                        <div id="multiple-datasets-all_teachers" >-->
<!--                            <input class="typeahead" type="text" placeholder="--><?php //echo $this->lang->line('groups_select_teacher'); ?><!--">-->
<!--                        </div>-->
                        <select class="form-control" name="assign_teacher_select">

                        </select>
                    </div>
                </div>
                <div class="col-sm-2 pull-left " >
                    <button type="button" class="btn blue assign_teacher" ><?php echo $this->lang->line('assign'); ?></button>

                </div>
                <div class="col-sm-10" >
                    <div class="assigned_teachers">
                        
                    </div>
                </div>
                <div class="col-sm-10" >
                    <div class="selected_rows"></div>
                </div>
                <div class="clearfix">
                    
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>

<div id="AssignClassroomModal" class="modal fade groups" role="dialog">
    <div class="modal-dialog ">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><?php echo $this->lang->line('groups_assign_a_classroom'); ?></h4>
            </div>
            <div class="modal-body ">
                <div class="col-sm-4 no-padding pull-left " >
                    <div class="no-padding" >
                        <select class="form-control" name="assign_classroom_select">

                        </select>
                    </div>
                </div>
                <div class="col-sm-2 pull-left " >
                    <button type="button" class="btn blue assign_classroom" ><?php echo $this->lang->line('assign'); ?></button>

                </div>
                <div class="col-sm-10" >
                    <div class="assigned_classrooms">

                    </div>
                </div>
                <div class="col-sm-10" >
                    <div class="selected_rows"></div>
                </div>
                <div class="clearfix">

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>

<div id="AllowConflictsModal" class="modal fade groups" role="dialog">
    <div class="modal-dialog ">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><?php echo $this->lang->line('groups_confirmation_allow_conflicts'); ?></h4>
            </div>
            <div class="modal-body ">
                <p class="conflicts_messages">
                </p>
            </div>
            <div class="modal-footer">
                <?php echo $this->lang->line('groups_allow_conflicts_in_calendars'); ?>
                <button type="button" class="btn btn-danger allow_confirm_yes" data-dismiss="modal"><?php echo $this->lang->line('yes'); ?></button>
                <button type="button" class="btn btn-success allow_confirm_no" data-dismiss="modal"><?php echo $this->lang->line('no'); ?></button>
            </div>
        </div>

    </div>
</div>

<div id="ChangeStartEndDate" class="modal fade groups" role="dialog">
    <div class="modal-dialog ">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><?php echo $this->lang->line('update_start_end_date'); ?></h4>
            </div>
            <div class="modal-body ">
                <div class="form-group text-left start_end_date_update" style="display: none">
                    <div class="col-md-9">
                        <label>
                            <?php echo $this->lang->line('confirm_update_start_end_date'); ?>
                        </label>
                    </div>
                    <div class="col-md-2">
                        <div id="the_basics_classroom">
                            <input type="checkbox" class="update_start_end_date">
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <?php echo $this->lang->line('confirm_update_start_end_date'); ?>
                <button type="button" class="btn btn-success update_start_end_date" data-dismiss="modal"><?php echo $this->lang->line('yes'); ?></button>
                <button type="button" class="btn btn-danger not_update_start_end_date" data-dismiss="modal"><?php echo $this->lang->line('no'); ?></button>
            </div>
        </div>

    </div>
</div>

<script>
    var courses = <?php echo isset($courses) ? json_encode($courses) : json_encode(array()); ?>;
    var events = <?php echo isset($events) ? json_encode($events) : json_encode(array()); ?>;
    var teachers = <?php echo isset($teachers) ? json_encode($teachers) : json_encode(array()); ?>;
    var classrooms = <?php echo isset($classrooms) ? json_encode($classrooms) : json_encode(array()); ?>;
    var periods = <?php echo isset($periods) ? json_encode($periods) : json_encode(array()); ?>;
    var default_start_time = <?php echo json_encode($def_start_time); ?>;
    var default_end_time = <?php echo json_encode($def_end_time); ?>;
    var _time_fractions = <?php echo json_encode($time_fractions); ?>;
    var _customfields_fields = <?php echo json_encode($customfields_fields);?>;
    var _isOwner = <?php echo isset($isOwner) ? $isOwner : 0; ?>;

</script>

<script src="<?php echo base_url(); ?>app/js/groups/calendar.js"></script> <!--TODO need to remvove or something else
