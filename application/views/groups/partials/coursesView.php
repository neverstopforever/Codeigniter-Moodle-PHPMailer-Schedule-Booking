<!--<div class="col-sm-12 show_courses no-padding" style="display: none;">-->
<!---->
<!--    <div class="col-sm-12 text-left no-padding margin-top-10"  >-->
<!--        <div class="pull-left margin-right-10"  >-->
<!--            <button class="btn btn-success addCourseBtn">--><?php //echo $this->lang->line('add'); ?><!--</button>-->
<!--        </div>-->
<!--        <div class=""  >-->
<!--            <button class="btn show_add_course">--><?php //echo $this->lang->line('cancel'); ?><!--</button>-->
<!--        </div>-->
<!---->
<!--    </div>-->
<!---->
<!---->
<!---->
<!--</div>-->

<div class="col-sm-4 no-padding pull-right show_courses" style="display: none;">
    <div class="no-padding" >
        <div id="multiple-datasets" >
            <input class="typeahead" type="text" placeholder="<?php echo $this->lang->line('groups_select_course'); ?>">
        </div>
    </div>
    <div class="col-sm-12 text-left no-padding margin-top-10 back_save_group"  >
        <div class="pull-left margin-right-10"  >
            <button class="btn btn-sm btn-primary btn-circle addCourseBtn"><?php echo $this->lang->line('add'); ?></button>
        </div>
        <div class=""  >
            <button class="btn-sm btn btn-circle btn-default-back show_add_course"><?php echo $this->lang->line('cancel'); ?></button>
        </div>

    </div>
</div>
<div id="courses_table_empty" class=" no_data_table">

</div>
<div id="GroupsCoursesTable" class="student_documents_table">

</div>
<div class="modal fade" id="groupDeleteCourseModal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title"> <?php echo $this->lang->line('please_confirm'); ?></h4>
            </div>
            <div class="modal-body">
                <p><?php echo $this->lang->line('confirmDelete'); ?></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->lang->line('close');?></button>
                <button type="button" class="btn btn-danger delete_course" data-dismiss="modal"><?php echo $this->lang->line('delete');?></button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="groupCourseAddEnrollModal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title"> <?php echo $this->lang->line('groups_add_enrollments'); ?></h4>
            </div>
            <div class="modal-body">
                <div id="showStudentsForEnroll"></div>
            </div>
            <div class="modal-footer">
                <p><?php echo $this->lang->line('groups_confirm_add_enrollment'); ?>
                <button type="button" class="btn btn-default do_not_enroll" data-dismiss="modal"><?php echo $this->lang->line('no');?></button>
                <button type="button" class="btn btn-success add_enroll" data-dismiss="modal"><?php echo $this->lang->line('yes');?></button>
            </div>
        </div>
    </div>
</div>


<script>
    var courses = <?php echo isset($courses) ? json_encode($courses) : json_encode(array()); ?>;
    var allow_group_multicourse = <?php echo isset($allow_group_multicourse) ? json_encode($allow_group_multicourse) : ''; ?>;
</script>

<script src="<?php echo base_url(); ?>app/js/groups/courses.js"></script>