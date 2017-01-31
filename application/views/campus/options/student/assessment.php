<div class="page-container">

    <div class="table_loading"></div>
    <div class="page-content attendance">
        <div class="<?php echo $layoutClass ?>">
            <ul class="page-breadcrumb breadcrumb">
                <li>
                    <a href="<?php echo $_base_url; ?>" ><?php echo $this->lang->line('menu_Home'); ?></a>
                </li>
                <li>
                    <a href="javascript:;"><?php echo $this->lang->line('option'); ?></a>
                </li>
                <li class="active"><?php echo $this->lang->line('campus_assessment'); ?></li>
            </ul>
            <div class="row">
                <div class="col-md-12 attendance_section">
                    <div class="assessment_list">
                        <div class="text-right quick_tip_wrapper pull-right margin-bottom-10">
                            <a href="http://blog.akaud.com" target="_blank" type="button" class="btn btn-xs quick_tip green-meadow "> <i class="fa fa-lightbulb-o" aria-hidden="true"></i> <span class="button_text"><?php echo $this->lang->line('quick_tip');?></span> </a>
                        </div>
                        <div class="row">
                            <div class=" col-sm-6 circle_select_div" id="campus_groups">

                                    <label for="courseid"><?php echo $this->lang->line('active_enrollments');?>:</label>

                                    <select name="select_group" id="select_course" class="form-control ">
                                        <option value="">--<?php echo $this->lang->line('campus_select_course');?>--</option>
                                        <?php if(!empty($courses)){ ?>
                                            <?php foreach($courses as $k=>$course){ ?>
                                                 <option value="<?php echo $course->idactividad;?>"><?php echo trim($course->actividad); ?></option>
                                            <?php } ?>
                                        <?php } ?>
                                    </select>

                            </div>

                        </div>
                        <div class="assessment_details margin-top-20" style="display: none">

                        </div>
                    </div>
                    <div class="notes_params_data" style="display: none">

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
