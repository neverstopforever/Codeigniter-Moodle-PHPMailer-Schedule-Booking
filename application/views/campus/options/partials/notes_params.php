<div class="assessment_detail ze_wrapper">
          <table width="100%" cellspacing="2" cellpadding="2" class="notas_table">
                    <tr>
                        <td rowspan="5" style="width:120px;">
                            <img class="user-profile" src="<?php echo $dtlrs->photo_link ? $dtlrs->photo_link : base_url('assets/img/dummy-image.jpg'); ?>" width="120" alt="user" />
                        </td>
                        <td class="notas_td1">
                            <span class="notas_title"><?php echo $this->lang->line('first_name'); ?>:*</span><br />
                            <span class="notas_conce"><?php echo htmlentities($dtlrs->st_nomb) ?>&nbsp;</span>
                        </td>
                        <td class="notas_td1 notas_td2">
                            <span class="notas_title"><?php echo $this->lang->line('last_name');?>:*</span><br />
                            <span class="notas_conce"><?php echo htmlentities($dtlrs->st_apell) ?>&nbsp;</span>
                        </td>
                    </tr>
                    <tr>
                        <td class="notas_td1">
                            <span class="notas_title"><?php echo $this->lang->line('enrollment');?>:*</span><br />
                            <span class="notas_conce"><?php echo $dtlrs->matricula ?>&nbsp;</span>
                        </td>
                        <td class="notas_td1 notas_td2">
                            <span class="notas_title"><?php echo $this->lang->line('academic_year');?>:*</span><br />
                            <span class="notas_conce"><?php echo $dtlrs->anno ?>&nbsp;</span>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" class="notas_td1">
                            <span class="notas_title"><?php echo $this->lang->line('group');?>:*</span><br />
                            <span class="notas_conce"><?php echo htmlentities($dtlrs->grupo) ?>&nbsp;</span>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" class="notas_td1">
                            <span class="notas_title"><?php echo $this->lang->line('course');?>:*</span><br />
                            <span class="notas_conce"><?php echo htmlentities($dtlrs->actividad) ?>&nbsp;</span>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2"  class="notas_td1" style="padding-left:0px;">
                            <table width="100%">
                                <tr>
                                    <td>
                                        <span class="notas_title"><?php echo $this->lang->line('teacher');?>:*</span><br />
                                        <span class="notas_conce"><?php echo htmlentities($dtlrs->docente) ?>&nbsp;</span>
                                    </td>
                                    <td class="notas_td2">
                                        <span class="notas_title"><?php echo $this->lang->line('date');?>:*</span><br />
                                        <span class="notas_conce"><?php echo date($datepicker_format); //if($_SESSION["wp_lang"]!="en_GB" && $_SESSION["wp_lang"]!="eu_ES"){echo date('j/m/Y');}else{echo date('Y/m/d');} ?>&nbsp;</span>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>

</div>

<div class="note_params_note_top_data ze_wrapper">
    <table  border="0" cellpadding="1" cellspacing="0"  >
        <?php $Contador = 0;
        ?>
        <tr>
            <th><?php echo $this->lang->line('date'); ?></th>
            <th><?php echo $this->lang->line('detail'); ?></th>
            <th><?php echo $this->lang->line('note'); ?></th>
            <th><?php echo $this->lang->line('state'); ?></th>
            <th><?php echo $this->lang->line('comment'); ?></th>
            <th><?php echo $this->lang->line('option'); ?></th>
        </tr>
        <?php
        if(sizeof($note_data) > 0){
            foreach($note_data as $rs){?>
                <tr>
                    <td class="notas_td1 td_date"  width="85" height="45" align="center" ><?php echo date($datepicker_format, strtotime($rs->fecha)); ?></td>
                    <td class="notas_td1 td_description"  width="101" align="center" ><?php echo utf8_encode( $rs->descripcion );?></td>
                    <td class="notas_td1 td_note"  width="99" align="center" data-note_peso="<?php echo str_replace(".",",",$rs->peso); ?>" ><?php echo str_replace(".",",",$rs->nota) ?></td>
                    <td class="notas_td1 td_state"  width="75" align="center" state_id="<?php echo $rs->idestado ?>" ><?php echo $rs->estado ?></td>
                    <td class="notas_td1 td_comment"  width="210" align="center" id="com<?php echo $rs->id?>" title="<?php echo utf8_encode($rs->observaciones)?>" onmouseover="">

                        <?php echo utf8_encode(nl2br(substr($rs->observaciones,0,25))); if($rs->observaciones != "" && $rs->observaciones != NULL) echo "..."; ?>
                    </td>
                    <td class="notas_td1" width="70" align="center"><a href="#" class="edit_note_parm_row"><i class="fa fa-cog"></i></a></td>
                </tr>
                <?php

            }
        } // end if
        ?>
    </table>
</div>
<div id="NoteParamsTable">

</div>

<div class="table_f">
    <table class="calculate_tabel">
        <tr>

            <td width="316" class="text-right">

                <button class="btn btn-success " type="button" name="cmd-calcular-media" id="cmd-calcular-media" ><span><span><?php echo $this->lang->line('calculate_media'); ?></span></span></button>
            </td>
            <td width="196" class="text-center">
                <strong><?php echo  isset($note_data[0]->nota) ? str_replace(".",",",$note_data[0]->nota) : '0,00'; ?></strong>
            </td>
        <tr>
    </table>
</div>
<div class="back_save_group">
<button class="btn btn-default btn-circle-default xs_btn_block beck_to_notes_list margin-top-50"><?php echo $this->lang->line('back'); ?></button>
</div>
<div class="modal fade" id="noteEditModal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"> <?php echo $this->lang->line("edit").' '.$this->lang->line('note'); ?></h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" name="form_note_data" type="post">
                    <div class="row">
                    <div class="form-group">
                        <div class="col-sm-9">
                            <lable><strong><?php echo $this->lang->line('detail').'/'.$this->lang->line('concept'); ?></strong></lable>
                        </div>
                        <div class="col-sm-3">
                            <lable><strong><?php echo $this->lang->line('date'); ?></strong></lable>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="note_detail" value="<?php echo utf8_encode($note_data[0]->descripcion) ?>"/>
                        </div>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" name="note_date" value="<?php echo date($datepicker_format, strtotime($note_data[0]->fecha)); ?>"/>
                        </div>
                    </div>
                        <div class="table-scrollable">
                            <table class="margin-top-20" width="100%">
                            <tr>
                                <td height="27" width="80">
                                    <strong><?php echo $this->lang->line('note'); ?></strong>
                                </td>
                                <td width="110">
                                    <strong><?php echo $this->lang->line('note_status'); ?></strong>
                                </td>
                                <td width="100">
                                    <strong><?php echo $this->lang->line('type_of_note'); ?></strong>
                                </td>
                                <td width="80">
                                    <strong><?php echo $this->lang->line('weight').' %'; ?></strong>
                                </td>
                                <td width="20">
                                    <strong><?php echo $this->lang->line('requires_approval').' %'; ?></strong>
                                </td>
                            </tr>
                            <tr>
                                <td height="27" width="80">
                                    <input type="text" class="form-control" name="note"  value="<?php echo str_replace(".",",",$note_data[0]->nota); ?>"/>
                                </td>
                                <td width="110">
                                    <select class="form-control" name="select_state" >
                                        <option value=""><?php echo $this->lang->line('by_evaluating'); ?></option>
                                        <?php foreach($notes as $note){
                                            $desc = trim($note->Descripcion);
                                            switch (trim($note->Descripcion)){
                                                case 'No Evaluado':
                                                    $desc =  $this->lang->line('not_evaluated');
                                                    break;
                                                case 'No Presentado':
                                                    $desc =  $this->lang->line('no_submitted');
                                                    break;
                                                case 'Aprobado':
                                                    $desc =  $this->lang->line('approved');
                                                    break;
                                                case 'Suspendido':
                                                    $desc =  $this->lang->line('suspended');
                                                    break;
                                                case 'Convalidado':
                                                    $desc =  $this->lang->line('accept');
                                                    break;
                                                case 'nuevo estado':
                                                    $desc =  $this->lang->line('new_state');
                                                    break;
                                            }
                                            ?>
                                            <option value="<?php echo $note->id?>" <?php echo $note_data[0]->idestado == $note->id ? "selected='selected'" : ''; ?> ><?php echo $desc; ?></option>
                                        <?php }?>
                                    </select>
                                </td width="100">
                                <td>
                                    <select class="form-control" name="select_type_note" >
                                        <option value="0"><?php echo $this->lang->line('partial_note')?></option>
                                    </select>
                                </td>
                                <td width="80">
                                    <input type="text" class="form-control" name="note_peso" value="<?php echo str_replace(".",",",$note_data[0]->peso) ?>" maxlength="3" />
                                </td>
                                <td width="20">
                                    <select class="form-control" name="select_approval" >
                                        <option value="1"><?php echo $this->lang->line('yes'); ?></option>
                                        <option value="0"><?php echo $this->lang->line('no'); ?></option>
                                    </select>
                                </td>
                            </tr>
                            <tr align="left">
                                <td height="27" valign="middle"><strong><?php echo $this->lang->line('comment'); ?></strong></td>
                                <td valign="middle" >&nbsp;</td>
                                <td valign="middle" >&nbsp;</td>
                                <td valign="middle" >&nbsp;</td>
                                <td valign="middle" >&nbsp;</td>
                            </tr>
                            <tr align="left">
                                <td height="27" colspan="5" valign="middle"><textarea name="note_comment" cols="60" style="width: 100%" rows="5" class="textarea_600" ><?php echo utf8_encode( $note_data[0]->observaciones); ?></textarea></td>
                            </tr>
                        </table>
                        </div>
                   </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->lang->line('close');?></button>
                <button type="button" class="btn btn-primary modal_update" ><?php echo $this->lang->line('update');?></button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="notesUpdateStateModal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"> <?php echo $this->lang->line("please_confirm"); ?></h4>
            </div>
            <div class="modal-body">
                <p><?php echo $this->lang->line('campus_notes_update_state_confirm'); ?></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->lang->line('close');?></button>
                <button type="button" class="btn btn-success modal_update" data-dismiss="modal"><?php echo $this->lang->line('update');?></button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="noteParamsEditModal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title"> <?php echo $this->lang->line("setting_parameters"); ?></h3>

            </div>
            <div class="modal-body">
                <p><?php echo $this->lang->line('note_edit_parameters_p'); ?></p>
                <form class="form-horizontal" name="form_note_params_data" type="post">
                    <div class="row">
                        <div class="form-group">
                            <div class="col-sm-12">
                                <lable><strong>
                                        <?php echo $this->lang->line('detail').'/'.$this->lang->line('concept'); ?>
                                    </strong>
                                </lable>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-12">
                                <input type="text" class="form-control" name="note_param_detail" value="<?php echo utf8_encode($note_data[0]->descripcion) ?>"/>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-4">
                                <lable><strong><?php echo $this->lang->line('weight').' %'; ?></strong></strong></lable>
                            </div>
                            <div class="col-sm-4">
                                <lable><strong><?php echo $this->lang->line('note'); ?></strong></lable>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="note_param_peso" value="" />
                            </div>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="note_param_note" value=""/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-12">
                                <lable><strong><?php echo $this->lang->line('comment') ?> </strong></lable>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-12">
                                <textarea class="form-control" style="height: 100px" name="note_param_comment"></textarea>
                            </div>
                        </div>

                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->lang->line('close');?></button>
                <button type="button" class="btn btn-primary modal_update_note_params" ><?php echo $this->lang->line('update');?></button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="noteDeleteParamModal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title"> <?php echo $this->lang->line("deleting_parameter"); ?></h3>
            </div>
            <div class="modal-body">
                <p><?php echo $this->lang->line('note_delete_parameters_p'); ?></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->lang->line('close');?></button>
                <button type="button" class="btn btn-danger modal_delete" data-dismiss="modal"><?php echo $this->lang->line('delete');?></button>
            </div>
        </div>
    </div>
</div>
<style>
    #noteEditModal  table tr td{
        padding: 4px;
    }
</style>

<script>
//   var recoveries_data = <?php //echo json_encode($recoveries_data); ?>//;
   var delete_paramas = <?php echo $delete_paramas; ?>;
   var note_paramas = <?php echo json_encode($note_paramas); ?>;
   var _dtlrs = <?php echo json_encode($dtlrs); ?>;
//   var _course_id = <?php //echo json_encode($course_id); ?>//;
//   var _group_id = <?php //echo json_encode($group_id); ?>//;
   var _idm = <?php echo json_encode($idm); ?>;
   var _idml = <?php echo json_encode($idml); ?>;
   var _st = <?php echo json_encode($st); ?>;
   var _ide = <?php echo json_encode($ide); ?>;

</script>
<?php if($lang == 'spanish'){ ?>
    <script src="<?php echo base_url(); ?>assets/global/plugins/jquery-ui/ui/i18n/datepicker-es.js"></script>
<?php } ?>
<script src="<?php echo base_url(); ?>app/js/campus/options/partials/notes_params.js"></script>