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
                            <div class="col-sm-4 circle_select_div" id="campus_groups">
                                <!--                            <label for="courseid">--><?php //echo $this->lang->line('campus_course');?><!--:</label>-->
                                <select name="select_group" id="select_group" class="form-control ">
                                    <option value="">--<?php echo $this->lang->line('campus_select_group');?>--</option>
                                    <?php foreach($groups as $k=>$group){ ?>
                                        <option value="<?php echo $group->Idgrupo;?>"><?php echo $group->grupo;?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="  col-sm-4 circle_select_div courses_select" >

                            </div>

                        </div>

                        <div class="row">
                            <div class="col-sm-12" id="course_type_type">
                                <div id="hour" style="display: none;"></div>
                                <div id="attendees" style="display: none;">
                                    La acción realizada no ha devuelto ningún dato!</div>
                            </div>
                        </div>
                        <div class="row margin-top-50">

                                <div class="" id="notesTable">

                                </div>

                        </div>

                    </div>
                    <div class="assessment_details" style="display: none">
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
