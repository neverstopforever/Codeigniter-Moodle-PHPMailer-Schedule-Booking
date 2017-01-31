<h4><?php if($lang == 'spanish') { echo 'Este es el desglose de tu nota para la evaluaci&oacute;n:'; } else { echo "Here's the breakdown of your grade for evaluation :"; }  ?></h4>
<table width="100%" cellpadding="10" cellspacing="10"  class="TableBlueBorder" id="TableHeadBlue" style="width:100%;margin:0 auto">
    <tr>
        <td style="width:100%;margin:0 auto;padding:4px; border: 1px solid #26A9E0" align="middle"><b><?php echo $evaluacion; ?></b></td>
    </tr>
</table>
<div id="NoteParams_table_empty" class="NoteParams_table no_data_table">

</div>
<div id="NoteParamsTable">

</div>
<div class="table-scrollable">
<table id="tbl-foot" width="100%" cellpadding="5" cellspacing="0" class="row_head">
    <tr>
        <td width="179" height="27" align="center" valign="middle">
        </td>
        <td width="91" align="center" valign="middle" >&nbsp;</td>
        <td width="67" align="center" valign="middle" >&nbsp;</td>
        <td width="93" align="center" valign="middle" >&nbsp;</td>
        <td width="158" align="center" valign="middle" >&nbsp;</td>
    </tr>
    <tr id="tr-foot">
        <td colspan="5" align="center" valign="right" >

            <table style="background-color: #F1F4FA" width="100%" height="109" cellpadding="0" cellspacing="5" class="TableBlueBorder">
                <tr>
                    <td valign="top" bgcolor="#F1F4FA" style=" border: 1px solid #c3d4f5; padding: 28px">
    <table style="background-color:#F1F4FA" id="tbl-foot" width="100%" cellpadding="5" cellspacing="0" class="row_head">
                            <tr>
                                <td colspan="5">
                                    <table>
                                        <tr>

                                            <td width="300" height="27" align="left" valign="middle"><strong><?php echo $this->lang->line('detail').'/'.$this->lang->line('concept'); ?></strong></td>
                                            <td width="158" align="left" valign="middle" ><strong><?php echo $this->lang->line('date')?></strong></td>
                                        </tr>
                                        <tr>
                                            <td height="27" colspan="0" align="left" valign="middle" style="background-color:#FFF">
                                <span id="spry-detalle">
                                    <?php echo $note_data->descripcion; ?></span>
                                            </td>
                                            <td align="left" valign="middle" style="background-color:#FFF"><span id="spry-fecha">
                               <?php echo date($datepicker_format, strtotime($note_data->fecha)); ?></span></td>

                                    </table>

                            </tr>
                            <tr>
                                <td height="27" align="center" valign="middle"><strong><?php echo $this->lang->line('note')?></strong></td>
                                <td align="center" valign="middle" ><strong><?php echo $this->lang->line('note_status')?></strong></td>
                            </tr>
                            <tr>
                                <td height="27" align="center" valign="middle" style="background-color:#FFF">
                                    <?php  echo str_replace(".",",",$note_data->nota);?>
                                </td>
                                <td align="center" valign="middle" style="background-color:#FFF;border-left:#CCC 1px solid">
                                    <?php 	if($note_data->idestado == 1) echo $this->lang->line('no_submitted');
                                    else if($note_data->idestado == 2) echo $this->lang->line("approved");
                                    else if($note_data->idestado == 3) echo $this->lang->line("suspended");
                                    else if($note_data->idestado == 4) echo $this->lang->line("accept");
                                    else if($note_data->idestado == 0 || $note_data->idestado == '') echo $this->lang->line("by_evaluating");?>
                                </td>

                            </tr>
                            <tr align="left">
                                <td height="27" valign="middle"><strong><?php echo $this->lang->line('comment')?></strong></td>
                                <td valign="middle" >&nbsp;</td>
                                <td valign="middle" >&nbsp;</td>
                                <td valign="middle" >&nbsp;</td>
                                <td valign="middle" >&nbsp;</td>
                            </tr>
                            <tr align="left">
                                <td height="27" colspan="5" valign="middle" style="background-color:#FFF"><?php echo $note_data->observaciones ?></td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
</table>
    </div>
<div class="clearfix"></div>



<button class="btn btn-default beck_to_notes_list margin-top-50"><?php echo $this->lang->line('back'); ?></button>



<style>
    #noteEditModal  table tr td{
        padding: 4px;
    }
    .row_head {
        color: #666666;
        font-family: Arial, Helvetica, sans-serif;
        font-size: 12px;
        font-weight: normal;
        height: 15px;
        text-align: center;
        vertical-align: middle;
        float: right;
        width: 80%;
    }
    table#tbl-foot tr td, table#tbl-foot tr th, #tbl-foot table tr td, #tbl-foot table tr th {
        padding: 4px;
        vertical-align: middle;
    }
</style>

<script>
   var note_paramas = <?php echo json_encode($note_paramas); ?>;
//   var _dtlrs = <?php //echo json_encode($dtlrs); ?>//;
   var _course_id = <?php echo json_encode($course_id); ?>;


</script>
<?php if($lang == 'spanish'){ ?>
    <script src="<?php echo base_url(); ?>assets/global/plugins/jquery-ui/ui/i18n/datepicker-es.js"></script>
<?php } ?>
<script src="<?php echo base_url(); ?>app/js/campus/options/partials/student/notes_params.js"></script>