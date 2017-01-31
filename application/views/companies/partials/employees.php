<div class="col-sm-4 col-md-3 show_not_linked_students pull-right" style="display: none;">
    <div class="text-left no-padding" >
        <div id="linked-students-multiple-datasets">
            <input class="typeahead" type="text" placeholder="<?php echo $this->lang->line('companies_select_student'); ?>">
        </div>
    </div>
    <div class="col-sm-12 text-left no-padding margin-top-10 back_save_group">
        <div class="pull-left margin-right-10"  >
            <button class="btn btn-sm btn-primary btn-circle addLinkBtn"><?php echo $this->lang->line('add'); ?></button>
        </div>
        <div class="">
            <button class="btn-sm btn btn-circle btn-default-back hide_add_link"><?php echo $this->lang->line('cancel'); ?></button>
        </div>

    </div>
</div>
<div id="empleados_table" class="student_documents_table no_data_table">

</div>

<div class="modal fade" id="unlinkStudentModal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <p><?php echo $this->lang->line('confirmDelete'); ?></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->lang->line('close');?></button>
                <button type="button" class="btn btn-danger unlink_student" data-dismiss="modal"><?php echo $this->lang->line('companies_unlink');?></button>
            </div>
        </div>
    </div>
</div>

<script>
       var _empleados = <?php echo isset($empleados) ? json_encode($empleados) : json_encode(array()); ?>;
</script>
<script src="<?php echo base_url(); ?>app/js/companies/partials/employees.js"></script>
