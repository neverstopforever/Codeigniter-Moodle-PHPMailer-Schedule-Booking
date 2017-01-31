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
<div class="visible-sm visible-xs drop_files_section">
    <div class="">
        <form action="/aws_s3/uploadDocuments/course/<?php echo $course_id;?>" class="dropzone dropzone-file-area dz-clickable " method="POST" name="documents_import"
              id="documents_import1" >
            <div class="dz-default dz-message">
                <h3 class="sbold"><?php echo $this->lang->line('document_drop_files'); ?></h3>
            </div>
        </form>
    </div>
</div>
<div class="no_CourseDocumentsTable col-xs-12 col-sm-9" style="display:none;"></div>
<div id="CourseDocumentsTable" class="student_documents_table col-xs-12 col-sm-9">
    
</div>
<div class="hidden-sm hidden-xs col-sm-3 drop_files_section">
    <div class="">
        <form action="/aws_s3/uploadDocuments/course/<?php echo $course_id;?>" class="dropzone dropzone-file-area dz-clickable " method="POST" name="documents_import"
              id="documents_import" >
            <div class="dz-default dz-message">
                <h3 class="sbold"><?php echo $this->lang->line('document_drop_files'); ?></h3>
            </div>
        </form>
    </div>
</div>





<div class="modal fade" id="courseDeleteDocumentModal" role="dialog">
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
                <button type="button" class="btn btn-danger delete_document" data-dismiss="modal"><?php echo $this->lang->line('delete');?></button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="documentUpload" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel"> <?php echo $this->lang->line('teachers_upload_document'); ?></h4>
            </div>
            <!--                            <form id="DocumentUp" method="POST" enctype="multipart/form-data">-->
            <div class="modal-body">
                <!-- <div class="file_name">
                                        <input placeholder="<?php /*echo $this->lang->line('fileTitle'); */?>" type="text" name="document_name"
                                               required class="filenombre"/>
                                    </div>-->
                <form action="/aws_s3/uploadDocuments/course/<?php echo $course_id;?>" class="dropzone dropzone-file-area dz-clickable " method="POST" name="documents_import"
                      id="documents_import" >
                    <div class="dz-default dz-message">
                        <h3 class="sbold"><?php echo $this->lang->line('document_drop_files'); ?></h3>
                    </div>
                </form>

            </div>

            <!--                            </form>-->
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->lang->line('close'); ?></button>
                <!--                                <button type="submit" class="btn btn-primary">--><?php //echo $this->lang->line('upload'); ?><!--</button>-->
            </div>
        </div>
    </div>
</div>
<script>
    var documents = <?php echo json_encode($documents); ?>;
    var _courseId = "<?php echo $course_id; ?>";
</script>

<script src="<?php echo base_url(); ?>app/js/courses/partials/documents.js"></script>