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
                                <?php echo $this->lang->line('menu_courses'); ?>
                            </li>
                        </ul>
                        <!-- BEGIN PAGE CONTENT INNER -->
                        <div class="row portlet light">
                            <div class="course_tags_tmp col-md-3 visible-xs visible-sm">
                                <div class=" course_tags">
                                    <h3><?php echo $this->lang->line('courses_tags'); ?></h3>
                                    <span><?php echo $this->lang->line('courses_click_tag_filter'); ?></span>
                                    <div class="tag_buttons">
                                        <button  class="btn btn-sm btn-outline green tag_btn active_state_btn"><?php echo $this->lang->line('courses_active'); ?></button>
                                        <button  class="btn  btn-sm  btn-outline red tag_btn not_active_state_btn"><?php echo $this->lang->line('courses_not_active'); ?></button>
                                    </div>
                                </div>
                            </div>
                                <div class="col-md-9 coursesTable">

                                    <div class="text-right margin-bottom-10">
                                        <button type="button" id="quick_tips" class="btn btn-xs green-meadow "> <i class="fa fa-lightbulb-o" aria-hidden="true"></i> <span class="button_text"><?php echo $this->lang->line('show_quick_tips'); ?></span> <i class="fa fa-angle-down fa-angledown"></i></button>
                                    </div>
                                    <div class="quick_tips_sidebar margin-top-20">
                                        <div class=" note note-info quick_tips_content">
                                            <h2><?php echo $this->lang->line('quick_box_title'); ?></h2>
                                            <p><?php echo $this->lang->line('courses_quick_tips_text'); ?>
                                                <strong><a href="<?php echo $this->lang->line('courses_quick_tips_link'); ?>" target="_blank"><?php echo $this->lang->line('courses_quick_tips_link_text'); ?></a></strong>
                                            </p>
                                        </div>
                                    </div>

                                    <div class="no_courses_wrapper" style="display: none"></div>
                                    <div id="coursesTable"></div>
                                </div>
                            <div class="course_tags_tmp col-md-3 hidden-xs hidden-sm">
                                <div class=" course_tags">
                                    <h3><?php echo $this->lang->line('courses_tags'); ?></h3>
                                    <span><?php echo $this->lang->line('courses_click_tag_filter'); ?></span>
                                    <div class="tag_buttons">
                                        <button  class="btn btn-sm btn-outline green tag_btn active_state_btn"><?php echo $this->lang->line('courses_active'); ?></button>
                                        <button  class="btn  btn-sm  btn-outline red tag_btn  not_active_state_btn"><?php echo $this->lang->line('courses_not_active'); ?></button>
                                    </div>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                    <!-- END PAGE CONTENT INNER -->
                </div>
            </div>

        <script>
            var _courses = <?php echo json_encode($courses); ?>;
        </script>