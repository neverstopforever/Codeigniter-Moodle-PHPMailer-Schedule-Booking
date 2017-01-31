        <!-- BEGIN PAGE CONTAINER -->
        <div class="page-container">


            <!-- BEGIN PAGE CONTENT -->
            <div class="table_loading"></div>
            <div class="page-content attendance">
                <div class="<?php echo $layoutClass ?>">
                    <ul class="page-breadcrumb breadcrumb">
                        <li>
                            <a href="<?php echo $_base_url; ?>" ><?= $this->lang->line('menu_Home') ?></a>
                        </li>
                        <li>
                            <a href="javascript:;"><?php echo $this->lang->line('menu_academics'); ?></a>
                        </li>
                        <li class="active">
                            <?php echo $this->lang->line('attendance'); ?>
                        </li>
                    </ul>
                    <!-- BEGIN PAGE CONTENT INNER -->
                    <div class="portlet light text-center attendance_section col-md-9">

                        <div class="text-right">
                            <button type="button" id="quick_tips" class="btn btn-xs green-meadow "> <i class="fa fa-lightbulb-o" aria-hidden="true"></i> <span class="button_text"><?php echo $this->lang->line('show_quick_tips'); ?></span> <i class="fa fa-angle-down fa-angledown"></i></button>
                        </div>
                        <div class="quick_tips_sidebar text-left margin-top-20">
                            <div class=" note note-info quick_tips_content">
                                <h2><?php echo $this->lang->line('quick_box_title'); ?></h2>
                                <p><?php echo $this->lang->line('attendance_quick_tips_text'); ?>
                                    <strong><a href="<?php echo $this->lang->line('attendance_quick_tips_link'); ?>" target="_blank"><?php echo $this->lang->line('attendance_quick_tips_link_text'); ?></a></strong>
                                </p>
                            </div>
                        </div>

                        <div class="visible-sm visible-xs text-center attendance_calender_section_min ">
                            <div class="datepicker"></div>
                        </div>
                            <div>
                                <input type="hidden" id="classdate" name="classdate" maxlength="10" value="<?php echo date($datepicker_format);?>">

                                    <form class="form-horizontal" role="form">
                                        <div class="form-group">
<!--                                            <label for="courseid" class="col-md-1">--><?php //echo $this->lang->line('attendance_choose_teacher'); ?><!--:</label>-->
                                            <div class="col-sm-6 text-left">
                                                <div id="the-basics">
                                                    <input class="typeahead" type="text" placeholder="<?php echo $this->lang->line('attendance_choose_teacher'); ?>">
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    <hr>

                                    <form class="" role="form">
                                        <div class="col-sm-6 text-left">
                                        <div class="form-group">

                                            <label for="courseid"><?php echo $this->lang->line('attendance_course')?>:</label>
                                            <div class="circle_select_div" id="campus_course">
                                                <select  class="form-control"  name="courseid" id="courseid">
                                                    <option selected="selected"><?php echo $this->lang->line('attendance_select_course');?></option>
                                                    <?php foreach($all_courses as $k=>$course){ ?>
                                                        <option value="<?php echo $course->idactividad;?>"><?php echo $course->actividad;?></option>
                                                    <?php }?>
                                                </select>
                                            </div>
                                        </div>
                                        </div>
                                            <div  id="course_type" class="col-sm-6 text-left">

                                            </div>

                                    </form>

                                    <hr>
                                    <form class="form-horizontal" role="form">
                                        <div  class="col-sm-6 text-left" id="course_type_type">
                                            <div class="form-group">
                                            </div>
                                        </div>
                                        <div class="col-sm-6 text-left"  id="course_type_type2">
                                            <div id="hour" style="display: none;"></div>
                                        </div>
                                    </form>
                                <div class="clearfix"></div>
                                    <div>
                                <div id="attendees" style="display: none;">
                                    La acción realizada no ha devuelto ningún dato!
                                </div>
                                        </div>

                                </div>


                        </div>
                    <div class="col-md-3 attendance_calender_section hidden-sm hidden-xs">
                        <div class="datepicker"></div>
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
    var _teachers_data = <?php echo  json_encode($teachers); ?>;

</script>