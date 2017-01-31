<div class="assessment_detail table-scrollable">
     <table width="100%" cellspacing="2" cellpadding="2" class="notas_table">
                    <tr>
<!--                        <td rowspan="5" style="width:120px;">-->
<!--                            <img class="user-profile" src="--><?php //echo $dtlrs->photo_link ? $dtlrs->photo_link : base_url('assets/img/dummy-image.jpg'); ?><!--" width="120" alt="user" />-->
<!--                        </td>-->
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
                                    <td class="notas_td2">
                                        <span class="notas_title"><?php echo $this->lang->line('date');?>:*</span><br />
                                        <span class="notas_conce"><?php echo date($datepicker_format);  ?>&nbsp;</span>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
</div>

<div class="portlet margin-top-20 notes_list">
    <div class="portlet-body">
        <div class="tabbable-line">
            <ul class="nav nav-tabs ">
                <li class="active">
                    <a href="#tab_1" data-toggle="tab" aria-expanded="true"> <?php echo $this->lang->line('partial_assessment'); ?> </a>
                </li>
                <li class="">
                    <a href="#tab_2" data-toggle="tab" aria-expanded="false"> <?php echo $this->lang->line('recoveries'); ?> </a>
                </li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="tab_1">
                    <div id="Assessment_table_empty" class="assessment_table no_data_table">

                    </div>
                    <div id="PartialAssessmentTable">
                        
                    </div>
                </div>
                <div class="tab-pane" id="tab_2">
                    <div id="recoveries_table_empty" class="recoveries_table no_data_table">

                    </div>
                    <div id="recoveriesDataTable">

                    </div>
                </div>
                <?php if(sizeof($notes_data) > 0){ ?>
                    <div class="table-scrollable">
                    <table id="tbl-foot" width="100%" cellpadding="5" cellspacing="0" class="row_head">
                        <tr>
                            <td  class="notas_td1" width="179" height="27" align="center" valign="middle">&nbsp;</td>
                            <td  class="notas_td1" style="bgcolor:red;" width="91" align="center" valign="middle" ><strong><?php echo $this->lang->line('campus_final_note')?> </strong><br />
                                <?php echo str_replace(".",",",number_format($dtlrs->nota, 2));?>
                            </td>
                            <td class="notas_td1"  width="67" align="center" valign="middle" ></td>
                            <td class="notas_td1"  style="bgcolor:red;"width="93" align="center" valign="middle" ><strong><?php echo $this->lang->line('final_state')?></strong> <br />
                                <?php 	if($dtlrs->idestado == 1) echo $this->lang->line('no_submitted');
                                else if($dtlrs->idestado == 2) echo $this->lang->line("approved");
                                else if($dtlrs->idestado == 3) echo $this->lang->line("suspended");
                                else if($dtlrs->idestado == 4) echo $this->lang->line("accept");
                                else if($dtlrs->idestado == 0 || $dtlrs->idestado == '') echo $this->lang->line("by_evaluating");?>
                            </td>
                            <td  class="notas_td1" width="158" align="center" valign="middle" >

                            </td>
                        </tr>
                        <tr>
                            <td height="27" align="center" valign="middle"></td>
                            <td colspan="2" align="center" valign="middle" ></td>
                            <td colspan="2" align="center" valign="middle" >&nbsp;</td>
                        </tr>

                    </table>
                        </div>
                <?php } ?>
            </div>
        </div>
    </div>

</div>


<style>
    .notas_td1 {
        border-bottom: 1px solid #CCCCCC;
    }
</style>
<script>
    var recoveries_data = <?php echo json_encode($recoveries_data); ?>;
   var _NotesData = <?php echo json_encode($notes_data); ?>;
//   var _notes = <?php //echo json_encode($notes); ?>//;

   var _course_id = <?php echo json_encode($course_id); ?>;

   var _enroll_id = <?php echo json_encode($enroll_id); ?>;

</script>
<script src="<?php echo base_url(); ?>app/js/campus/options/partials/student/assessment_details.js"></script>