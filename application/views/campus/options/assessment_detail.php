<div class="assessment_detail">
    <table width="100%" id="tbl1">
        <tr>
            <td>
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
            </td>
        </tr>
    </table>
</div>

<div class="portlet margin-top-20">
    <div class="portlet-body">
        <div class="tabbable-line">
            <ul class="nav nav-tabs ">
                <li class="active">
                    <a href="#tab_1" data-toggle="tab" aria-expanded="true"> <?php echo $this->lang->line('management_notes'); ?> </a>
                </li>
                <li class="">
                    <a href="#tab_2" data-toggle="tab" aria-expanded="false"> <?php echo $this->lang->line('recoveries'); ?> </a>
                </li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="tab_1">
                    <div id="manageNotesTable">
                        
                    </div>
                    <div class="notes_data">
                        
                    </div>
                </div>
                <div class="tab-pane" id="tab_2">

                </div>
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
                <button type="button" class="btn btn-danger modal_update" data-dismiss="modal"><?php echo $this->lang->line('update');?></button>
            </div>
        </div>
    </div>
</div>
<button class="btn btn-default back_to_list"><?php echo $this->lang->line('back'); ?> </button>
<script>
   var _manageNotesData = <?php echo json_encode($notes_data); ?>;
   var is_option_active = <?php echo $is_option_active; ?>;
   var _notes = <?php echo json_encode($notes); ?>;
   var _dtlrs = <?php echo json_encode($dtlrs); ?>;
</script>
<script src="<?php echo base_url(); ?>app/js/campus/options/assessment_details.js"></script>