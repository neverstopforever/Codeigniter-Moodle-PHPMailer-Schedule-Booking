<!-- BEGIN PAGE CONTAINER -->
<div class="page-container">

    <!-- BEGIN PAGE CONTENT -->
    <div class="table_loading"></div>
    <div class="page-content">
        <div class="<?php echo $layoutClass ?>">
            <ul class=" page-breadcrumb breadcrumb">
                <li>
                    <a href="<?php echo $_base_url; ?>" ><?php echo $this->lang->line('menu_Home'); ?></a>
                </li>
                <li>
                    <a href="<?php echo $_base_url; ?>advancedSettings"><?php echo $this->lang->line('menu_advanced_settings'); ?></a>
                </li>
                <li class="active">
                    <?php echo $this->lang->line('campus_students'); ?>
                </li>
            </ul>
            <!-- BEGIN PAGE CONTENT INNER -->
            <div class="portlet light">

                <div class="text-right">
                    <button type="button" id="quick_tips" class="btn btn-xs green-meadow "> <i class="fa fa-lightbulb-o" aria-hidden="true"></i> <span class="button_text"><?php echo $this->lang->line('show_quick_tips'); ?></span> <i class="fa fa-angle-down fa-angledown"></i></button>
                </div>
                <div class="quick_tips_sidebar margin-top-20 margin-bottom-20">
                    <div class=" note note-info quick_tips_content">
                        <h2><?php echo $this->lang->line('quick_box_title'); ?></h2>
                        <p><?php echo $this->lang->line('campus_students_quick_tips_text'); ?>
                            <strong><a href="<?php echo $this->lang->line('campus_students_quick_tips_link'); ?>" target="_blank"><?php echo $this->lang->line('campus_students_quick_tips_link_text'); ?></a></strong>
                        </p>
                    </div>
                </div>

                <h2 class="margin-top-0"><?php echo $this->lang->line('campus_students_manage_students'); ?></h2>
                <h4><?php echo $this->lang->line('campus_students_manage_students_access_to_campus'); ?></h4>

                <p class="select_all_rows_p" style="display: none">
                    <?php echo $this->lang->line('select_all_message_text1'); ?>
                    <span class="count_this_page"></span> <span class="str_lower_tb_name"><?php echo strtolower($this->lang->line('student')); ?></span>
                    <?php echo ' '.$this->lang->line('select_all_message_text2'); ?>
                    <a href="#" class="select_all_table_rows"><?php echo $this->lang->line('select_all_message_text3').' <span class="count_all_pages"></span> <span class="str_lower_tb_name">'.strtolower($this->lang->line('student')).'</span> '. ($lang == 'spanish' ? '' : $this->lang->line('in').' <span class="tb_name">'.$this->lang->line('student').'</span>'); ?> ?</a>
                </p>
                <p class="unselect_all_rows_p" style="display: none">
                    <?php echo $this->lang->line('unselect_all_message_text1'); ?>
                    <span class="count_this_page"></span> <span class="str_lower_tb_name"><?php echo strtolower($this->lang->line('student')); ?></span>
                    <?php echo ' '.$this->lang->line('select_all_message_text2'); ?>
                    <a href="#" class="unselect_all_table_rows"><?php echo $this->lang->line('unselect_all_message_text3').' <span class="count_all_pages"></span> <span class="str_lower_tb_name">'.strtolower($this->lang->line('student')).'</span>'; ?>?</a>
                </p>
                <div id="students_table_empty" class=" no_data_table">

                </div>
                <div id="campusStudents"></div>



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
    var _group_data = <?php echo json_encode($group_data); ?>;
</script>
