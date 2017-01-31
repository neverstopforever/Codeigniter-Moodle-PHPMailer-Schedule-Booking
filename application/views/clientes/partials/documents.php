<div id="documents_table" class="student_documents_table">

</div>

<div class="modal fade" id="documentUpload" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="<?php echo $this->lang->line('close'); ?>"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel"> <?php echo $this->lang->line('teachers_upload_document'); ?></h4>
            </div>
            <div class="modal-body">
                <form action="/aws_s3/uploadDocuments/clients/<?php echo $client_id;?>" class="dropzone dropzone-file-area dz-clickable " method="POST" name="documents_import"
                      id="documents_import" >
                    <div class="dz-default dz-message">
                        <h3 class="sbold"><?php echo $this->lang->line('document_drop_files'); ?></h3>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->lang->line('close'); ?></button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="deleteDocumentModal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <p><?php echo $this->lang->line('confirmDelete'); ?></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->lang->line('close');?></button>
                <button type="button" class="btn btn-danger delete_document" data-dismiss="modal"><?php echo $this->lang->line('delete');?></button>
            </div>
        </div>
    </div>
</div>
<script>
       var _documents = <?php echo isset($documents) ? json_encode($documents) : json_encode(array()); ?>;
</script>
<script src="<?php echo base_url(); ?>app/js/clientes/partials/documents.js"></script>
