<div class="col-sm-12 show_courses no-padding" style="display: none;">
    <div class="col-sm-12 text-left no-padding margin-top-10"  >
        <div class="pull-left margin-right-10"  >
            <button class="btn btn-success addCourseBtn"><?php echo $this->lang->line('add'); ?></button>
        </div>
        <div class="">
            <button class="btn show_add_course"><?php echo $this->lang->line('cancel'); ?></button>
        </div>
    </div>
</div>
<div class="col-sm-12 show_courses no-padding" style="display: none;">
    <hr>
</div>
<div class="col-sm-4 pull-right show_resources no-padding" style="display: none;">
    <div class=" no-padding" >
        <div id="resources-multiple-datasets">
            <input class="typeahead" type="text" placeholder="<?php echo $this->lang->line('courses_select_resource'); ?>">
        </div>
    </div>
    <div class="no-padding margin-top-10 text-left back_save_group"  >
        <div class="pull-left margin-right-10"  >
            <button class="btn btn-sm btn-primary btn-circle addResourceBtn"><?php echo $this->lang->line('add'); ?></button>
        </div>
        <div class=""  >
            <button class="btn-sm btn btn-circle btn-default-back hide_add_resource"><?php echo $this->lang->line('cancel'); ?></button>
        </div>

    </div>
</div>

<div class="no_CourseResourcesTable" style="display: none;"></div>
<div id="CourseResourcesTable" class="student_documents_table">

</div>
<div class="modal fade" id="courseDeleteResourceModal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title"><?php echo $this->lang->line('please_confirm'); ?></h4>
            </div>
            <div class="modal-body">
                <p><?php echo $this->lang->line('confirmDelete'); ?></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->lang->line('close');?></button>
                <button type="button" class="btn btn-danger delete_resource" data-dismiss="modal"><?php echo $this->lang->line('delete');?></button>
            </div>
        </div>
    </div>
</div>
<script>
    var resources = <?php echo isset($resources) ? json_encode($resources) : null; ?>;
    var _courseId = "<?php echo isset($course_id) ? $course_id : null; ?>";
</script>

<script src="<?php echo base_url(); ?>app/js/courses/partials/resources.js"></script>