
<div id="follow_up_table" class="student_documents_table no_data_table">

</div>

<div class="modal fade" id="deleteSeguimientoModal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <p><?php echo $this->lang->line('confirmDelete'); ?></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->lang->line('close');?></button>
                <button type="button" class="btn btn-danger delete_seguimiento" data-dismiss="modal"><?php echo $this->lang->line('delete');?></button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="add_seguimiento" tabindex="-1" role="dialog" aria-labelledby="add_seguimientoModalLabel">

    <div class="modal-dialog" role="add_seguimiento">
        <form method="post">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="<?php echo $this->lang->line('close'); ?>"><span
                            aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="add_seguimientoModalLabel"> <?php echo $this->lang->line('cpanel_add_follow_up'); ?></h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>
                            <?php echo $this->lang->line(
                                'cpanel_followup_title'
                            ); ?>
                        </label>
                        <input type="text" class="form-control" id="add_title" name="title"/>
                    </div>
                    <div class="form-group">
                        <label>
                            <?php echo $this->lang->line(
                                'cpanel_followup_fecha'
                            ); ?>
                        </label>
                        <input type="text" class="form-control datepicker" id="add_follow_date" name="follow_date"/>
                    </div>
                    <div class="form-group">
                        <label>
                            <?php echo $this->lang->line(
                                'cpanel_followup_usuario'
                            ); ?>
                        </label>
                        <div style="text-transform:uppercase">
                            <?php
                            echo $this->data['userData']->user;
                            ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>
                            <?php echo $this->lang->line(
                                'cpanel_followup_comentario'
                            ); ?>
                        </label>
                            <textarea class="form-control" id="add_comments" name="comments"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default"
                            data-dismiss="modal">
                        <?php echo $this->lang->line('close'); ?>
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <?php echo $this->lang->line('save'); ?>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="modal fade" id="edit_seguimiento" tabindex="-1" role="dialog" aria-labelledby="edit_seguimientoModalLabel">

    <div class="modal-dialog" role="edit_seguimiento">
        <form method="post">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="<?php echo $this->lang->line('close'); ?>"><span
                            aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="edit_seguimientoModalLabel"> <?php echo $this->lang->line('cpanel_editrecord'); ?></h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>
                            <?php echo $this->lang->line(
                                'cpanel_followup_title'
                            ); ?>
                        </label>
                        <input type="text" class="form-control" id="edit_title" name="title"/>
                    </div>
                    <div class="form-group">
                        <label>
                            <?php echo $this->lang->line(
                                'cpanel_followup_fecha'
                            ); ?>
                        </label>
                        <input type="text" class="form-control datepicker" id="edit_follow_date" name="follow_date"/>
                    </div>
                    <div class="form-group">
                        <label>
                            <?php echo $this->lang->line(
                                'cpanel_followup_usuario'
                            ); ?>
                        </label>
                        <div style="text-transform:uppercase">
                            <?php
                            echo $this->data['userData']->user;
                            ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>
                            <?php echo $this->lang->line(
                                'cpanel_followup_comentario'
                            ); ?>
                        </label>
                            <textarea class="form-control" id="edit_comments" name="comments"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default"
                            data-dismiss="modal">
                        <?php echo $this->lang->line('close'); ?>
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <?php echo $this->lang->line('save'); ?>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>


<script>
       var _segumentos = <?php echo isset($follow_up) ? json_encode($follow_up) : json_encode(array()); ?>;
        var _client_id = <?php echo json_encode($client_id); ?>
</script>
<script src="<?php echo base_url(); ?>app/js/cpanel/edit_customer/partials/follow_up.js"></script>
