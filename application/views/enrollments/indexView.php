        <div class="page-container">
            <!-- BEGIN PAGE HEAD -->

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
                                <?php echo $this->lang->line('menu_enrollments'); ?>
                            </li>
                        </ul>
                        <!-- BEGIN PAGE CONTENT INNER -->
                        <div class="row ">
                            <div class="col-md-3 visible-sm visible-xs enrollments_tags1">
                            </div>
                            <div class="col-md-9">
                                <div class="student_documents_table enrollments_documents_table">
                                    <div class="text-right margin-bottom-10">
                                        <button type="button" id="quick_tips" class="btn btn-xs green-meadow "> <i class="fa fa-lightbulb-o" aria-hidden="true"></i> <span class="button_text"><?php echo $this->lang->line('show_quick_tips'); ?></span> <i class="fa fa-angle-down fa-angledown"></i></button>
                                    </div>
                                    <div class="quick_tips_sidebar margin-top-20">
                                        <div class=" note note-info quick_tips_content">
                                            <h2><?php echo $this->lang->line('quick_box_title'); ?></h2>
                                            <p><?php echo $this->lang->line('enrollments_quick_tips_text'); ?>
                                                <strong><a href="<?php echo $this->lang->line('enrollments_quick_tips_link'); ?>" target="_blank"><?php echo $this->lang->line('enrollments_quick_tips_link_text'); ?></a></strong>
                                            </p>
                                        </div>
                                    </div>
                                    <div id="enrollmentsTable_no" class="no_data_table">

                                    </div>
                                    <div id="enrollmentsTable"></div>
                                </div>
                            </div>
                            <div class="col-md-3 hidden-sm hidden-xs enrollments_tags2">
                              <div id="enrollments_tags"></div>
                               <div class="enrollment_tags_tmp" style="display: none">
                                <div class="enrollment_tags">
                                    <h2><?php echo $this->lang->line('enrollments_filter_by');?></h2>

                                    <div class="form-group">
                                        <label class="control-label select_state_label text-left"><?php echo $this->lang->line('state');?>:</label>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label select_name_label text-left"><?php echo $this->lang->line('name');?>:</label>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label select_course_label text-left"><?php echo $this->lang->line('course');?>:</label>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label select_group_label text-left"><?php echo $this->lang->line('group');?>:</label>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label select_tag_label text-left"><?php echo $this->lang->line('enrollments_tags');?>:</label>
                                    </div>
                                </div>
                                   </div>


                                <div class="clearfix"></div>
                        </div>
                        </div>

                    </div>
                    <!-- END PAGE CONTENT INNER -->

                </div>

            </div>

        <div class="modal fade" id="previewModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" >
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title"><?php echo $this->lang->line('templates');?></h4>
                    </div>
                    <div class="modal-body" align="center">
                        <div class="select_template"></div>
                        <div id="previewFrame" class="margin-top-20" ></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary print_template"><?php echo $this->lang->line('enrollments_print'); ?></button>
                        <button type="button" class="btn btn-info" data-dismiss="modal"><?php echo $this->lang->line('close'); ?></button>
                    </div>
                </div>
            </div>
        </div>
<script>
    var names_data = <?php echo json_encode($students_names); ?>;
    var courses = <?php echo json_encode($courses); ?>;
    var groups = <?php echo json_encode($groups); ?>;
    var tags_group_by_tag_id = <?php echo json_encode($tags_group_by_tag_id); ?>;
    var tags_for_filter = <?php echo json_encode($tags_for_filter); ?>;

</script>