<div class="page-container">
    <div class="page-content">
        <div class="<?php echo $layoutClass ?>">
            <ul class="page-breadcrumb breadcrumb">
                <li>
                    <a href="<?php echo $_base_url; ?>" ><?php echo $this->lang->line('menu_Home'); ?></a>
                </li>
                <li>
                    <a href="javascript:;"><?php echo $this->lang->line('option'); ?></a>
                </li>
                <li class="active"><?php echo $this->lang->line('my_document'); ?></li>
            </ul>
            <div class="portlet light row">
                <div class="portlet-body">

                    <div role="tabpanel" class="col-sm-9" id="documentos">
                        <div>
                            <div class="text-right">
                                <a href="http://blog.akaud.com" target="_blank" type="button" class="btn btn-xs quick_tip green-meadow "> <i class="fa fa-lightbulb-o" aria-hidden="true"></i> <span class="button_text"><?php echo $this->lang->line('quick_tip');?></span> </a>
                            </div>
                            <div class="documentheader"></div>
                            <div class="clearfix"></div>
                            <div class="no_document" style="display: none;"></div>
                            <div class="doc_section">
                            <table class="documentos table dbtable_hover_theme">
                                <thead>
                                <tr>
                                    <td></td>
                                    <td></td>
                                </tr>
                                </thead>
                                    <tbody id="table_body_documentos">
                                    </tbody>
                            </table>
                                </div>
                    </div>
                    </div>
                    <div class="col-sm-3 drop_files_section">
                        <div>
                            <form action="/campus/aws_s3/uploadCampusDocument/profesor/<?php echo $teacherid;?>" class="dropzone dropzone-file-area dz-clickable"  name="documents_import"
                                  id="documents_import" style="">
                                <div class="dz-default dz-message">
                                    <h3 class="sbold"><?php echo $this->lang->line('campus_document_drop_files'); ?></h3>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
</div>
</div>

<div class="modal fade" id="delete_document_teacher"  role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title"><?php echo $this->lang->line('please_confirm'); ?></h4>
            </div>

            <div class="modal-body">
                <h4> <?php echo $this->lang->line('are_you_sure_delete'); ?></h4>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn default" data-dismiss="modal"><?php echo $this->lang->line('close'); ?></button>
                <button type="button" class="btn btn-danger delete_document"><?php echo $this->lang->line('delete'); ?></button>
            </div>

        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<script type="text/javascript">
    var data = <?php echo $json_document?>;
    var teacherID = <?php echo $teacherid;?>;
</script>