<div class="page-container">
    <div class="table_loading"></div>
    <div class="page-content">
        <div class="<?php echo $layoutClass ?>">
            <ul class="page-breadcrumb breadcrumb">
                <li>
                    <a href="<?php echo $_base_url; ?>" ><?php echo $this->lang->line('menu_Home'); ?></a>
                </li>
                <li>
                    <a href="javascript:;"><?php echo $this->lang->line('option'); ?></a>
                </li>
                <li class="active"><?php echo $this->lang->line('campus_attendance'); ?></li>
            </ul>
            <div class="row">
                <div class="col-md-9 attendance_section">

                    <div class="for_top_datepicker">
                        <div class="datepicker "></div>
                    </div>
                    <div>
                    <input type="hidden" id="classdate" name="classdate" maxlength="10" value="<?php echo date($datepicker_format);?>">
                        <div class="text-right margin-bottom-10">
                            <a href="http://blog.akaud.com" target="_blank" type="button" class="btn btn-xs quick_tip green-meadow "> <i class="fa fa-lightbulb-o" aria-hidden="true"></i> <span class="button_text"><?php echo $this->lang->line('quick_tip');?></span> </a>
                        </div>
                    <div class="row">

                        <div class="col-xs-7 col-sm-4 circle_select_div" id="campus_course">

<!--                            <label for="courseid">--><?php //echo $this->lang->line('campus_course');?><!--:</label>-->
                            <select name="courseid" id="courseid" class="form-control ">
                                <option selected="selected">--<?php echo $this->lang->line('campus_select_course');?>--</option>
                                <?php foreach($sa_courses_assigned as $k=>$course_assigned){ ?>
                                    <option value="<?php echo $course_assigned->idactividad;?>"><?php echo $course_assigned->actividad;?></option>
                                <?php }?>
                            </select>
                        </div>
                        <div class="col-xs-7  col-sm-4 circle_select_div" id="course_type">

                        </div>

                        <div class="col-xs-7  col-sm-4 circle_select_div" id="course_type_type">

                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12" id="course_type_type1">
                            <div id="hour" style="display: none;"></div>
                            <div id="attendees" style="display: none;">
                                La acción realizada no ha devuelto ningún dato!</div>
                        </div>
                    </div>

                    </div>
                </div>
                <div class="col-md-3 attendance_calender_section text-center">
                    <div>
                        <div class="datepicker hidden-xs hidden-sm"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="groupCustomFealds" role="dialog">
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
