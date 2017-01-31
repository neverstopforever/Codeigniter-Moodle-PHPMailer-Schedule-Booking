<div class="col-sm-12 show_not_exist_subsidiaries no-padding" style="display: none;">
    <div class="col-sm-5 text-left no-padding" >
        <div id="not-exist-subsidiaries-multiple-datasets">
            <input class="typeahead" type="text" placeholder="<?php echo $this->lang->line('clientes_select_subsidiaries'); ?>">
        </div>
    </div>
    <div class="col-sm-12 text-left no-padding margin-top-10"  >
        <div class="pull-left margin-right-10"  >
            <button class="btn btn-success addSubsidiarieBtn"><?php echo $this->lang->line('add'); ?></button>
        </div>
        <div class="">
            <button class="btn hide_add_link"><?php echo $this->lang->line('cancel'); ?></button>
        </div>

    </div>
</div>
<div id="subsidiaries_table" class="student_documents_table">

</div>

<div class="modal fade" id="deleteSubsidiaryModal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <p><?php echo $this->lang->line('confirmDelete'); ?></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->lang->line('close');?></button>
                <button type="button" class="btn btn-danger delete_subsidiary" data-dismiss="modal"><?php echo $this->lang->line('delete');?></button>
            </div>
        </div>
    </div>
</div>

<script>
       var _subsidiaries = <?php echo isset($subsidiaries) ? json_encode($subsidiaries) : json_encode(array()); ?>;
</script>
<script src="<?php echo base_url(); ?>app/js/clientes/partials/subsidiaries.js"></script>
