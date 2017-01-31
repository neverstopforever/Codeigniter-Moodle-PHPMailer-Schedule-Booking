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
                <li class="active">
                    <?php echo $this->lang->line('classroom'); ?>
                </li>
            </ul>
            <div class="portlet light ">

                <div class="text-right">
                    <button type="button" id="quick_tips" class="btn btn-xs green-meadow "> <i class="fa fa-lightbulb-o" aria-hidden="true"></i> <span class="button_text"><?php echo $this->lang->line('show_quick_tips'); ?></span> <i class="fa fa-angle-down fa-angledown"></i></button>
                </div>
                <div class="quick_tips_sidebar margin-top-20">
                    <div class=" note note-info quick_tips_content">
                        <h2><?php echo $this->lang->line('quick_box_title'); ?></h2>
                        <p><?php echo $this->lang->line('classroom_quick_tips_text'); ?>
                            <strong><a href="<?php echo $this->lang->line('classroom_quick_tips_link'); ?>" target="_blank"><?php echo $this->lang->line('classroom_quick_tips_link_text'); ?></a></strong>
                        </p>
                    </div>                    
                </div>

                <div>
                    <button class="btn pull-right btn-primary add_classroom_table btn-circle add_classroom margin-bottom-10"> <i class="fa fa-plus"></i> <?php echo $this->lang->line('classroom_add_new'); ?></button>

                </div>
                <div id="classroomTable_no" class="no_data_table">

                </div>
                
                <div id="classroomTable">

                </div>
                

                <div class="section " style="display: none;">

                    <div class="portlet-body">

                        <div class="tabbable-line">
                            <ul class="nav nav-tabs ">
                                <li class="active">
                                    <a href="#tab_1" data-toggle="tab"
                                       aria-expanded="true"> <?php echo $this->lang->line('classroom_section_general'); ?> </a>
                                </li>
                                <li class="">
                                    <a href="#tab_2" data-toggle="tab"
                                       aria-expanded="false"> <?php echo $this->lang->line('classroom_section_courses'); ?></a>
                                </li>
                                <li class="">
                                    <a href="#tab_3" data-toggle="tab"
                                       aria-expanded="false"> <?php echo $this->lang->line('classroom_section_calendar'); ?> </a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane active" id="tab_1">

                                    <div class="tools">
                                    </div>
                                    <div class="portlet-body">
                                        <form name="generalForm" class="gen_form">
                                            <div class="form-group color_form_group">
                                                <label class=""><?php echo $this->lang->line('classroom_section_general_color'); ?> </label>
                                                <input class="" name="color" id="mycolor" placeholder="<?php echo $this->lang->line('classroom_select_color'); ?>" readonly="readonly" />
                                                <div class="test_color"></div>
                                                <i class="fa fa-angle-right"></i>

                                            </div>
                                            <div class="form-group">
                                                <label  class=" "><?php echo $this->lang->line('classroom_section_general_name'); ?></label>
                                                <input type="text" class="classroom_name" name="classroom_name"/>


                                            </div>
                                            <div class="form-inline">
                                                <div class="form-group french">
                                                    <label><?php echo $this->lang->line('classroom_section_general_capacity'); ?> </label>
                                                    <div class="dec plus_minus"><i class="fa fa-minus"></i> </div>
                                                        <input type="text" class="text-center" name="capacity" id="french-hens" value="0">
                                                    <div class="inc plus_minus"><i class="fa fa-plus"></i></div>

                                                </div>
                                                <div class="form-group">
                                                    <label><?php echo $this->lang->line('classroom_section_general_active'); ?></label>
                                                    <input data-checkbox="icheckbox_minimal-blue" type="checkbox" name="active" id="active_check" class="icheck"/>

                                                </div>

<!--                                                <input type="number" name="capacity" class=""/>-->

                                            </div>
                                           <!-- <div class="form-group">
                                                <label><?php /*echo $this->lang->line('classroom_section_general_idcentro'); */?>
                                                    : </label>
                                                <input type="text" name="idcentro" class=""/>

                                            </div>-->
                                            <button id="generalSave"  class="btn btn-sm btn-primary btn-circle"><?php echo $this->lang->line('classroom_save'); ?></button>
                                            <button class=" back_classroom btn-sm btn btn-circle btn-default-back " style="display: none;">  <?php echo $this->lang->line('classroom_back'); ?></button>


                                        </form>
                                    </div>

                                </div>
                                <div class="tab-pane" id="tab_2">
                                    <button id="addCourses" class="btn btn-primary btn-circle addCourses pull-right"><i class="fa fa-plus"></i> <?php echo $this->lang->line('classroom_add_courses'); ?></button>
                                    <div id="coursesTable_no" class="coursesTable_no"></div>
                                    <div id="coursesTable"></div>
                                    <button class="btn btn-circle btn-primary btn-back back_classroom back_classroom_for_hide margin-top-20 "><i class="fa fa-arrow-left"></i> <?php echo $this->lang->line('classroom_back'); ?></button>
                                </div>
                                <div class="tab-pane" id="tab_3">
                                    <div id="calendar" class="portlet light portlet-fit  calendar"></div>
                                    <button class="btn btn-circle btn-primary btn-back back_classroom "><i class="fa fa-arrow-left"></i> <?php echo $this->lang->line('classroom_back'); ?></button>
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

                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <!-- END PAGE CONTENT INNER -->

        <div class="modal fade" id="deleteClassroomModal" tabindex="-1" role="dialog"  aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                        <h4 class="modal-title"><?php echo $this->lang->line("please_confirm"); ?></h4>
                    </div>
                    <div class="modal-body">
                        <p><?php echo $this->lang->line('classroom_are_you_sure_delete'); ?></p>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn default" data-dismiss="modal"><?php echo $this->lang->line('close'); ?></button>
                        <button  class="btn btn-danger deleteClassroom"><?php echo $this->lang->line('classroom_done'); ?></button>
                    </div>

                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
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
                        <button  class="btn btn-danger deleteCourseModal"><?php echo $this->lang->line('classroom_done'); ?></button>
                    </div>

                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
    </div>
    <!-- BEGIN QUICK SIDEBAR -->
    <!-- END QUICK SIDEBAR -->
</div>
<!-- END PAGE CONTENT -->
</div>
<!-- END PAGE CONTAINER -->
<script>
    var dbdata =
    <?php echo json_encode($classrooms); ?>

</script>