<div class="row">
    <div class="col-md-5 reports_list circle_select_div margin-top-20">
        <select class="form-control" id="select_reports" name="select_reports">
            <option value=""><?php echo $this->lang->line('select_report');?></option>
            <?php foreach ($lst_informes as $item){ ?>
                <option value="<?php echo $item->id;?>"><?php echo $item->title;?></option>
            <?php }?>
        </select>
    </div>
</div>
<div class="no_CourseReportsTable" style="display: none;"></div>
<div id="CourseReportsTable" class="student_documents_table">

</div>
<script>
    var _courseId = "<?php echo isset($course_id) ? $course_id : null; ?>";
</script>
<script src="<?php echo base_url(); ?>app/js/courses/partials/reports.js"></script>