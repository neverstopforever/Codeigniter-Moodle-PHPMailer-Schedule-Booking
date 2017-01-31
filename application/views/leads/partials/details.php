<form class="fcturation_form col-md-5" id="fcturation_form">
    <div class=" col-md-12 margin-top-10">
        <div class="form-group">
            <label>
                <?php echo $this->lang->line("prospects_modify_score"); ?>
            </label>
                <div >
                    <input  name="score" min="0" max="100" type="number" class="form-control"  value="<?php echo $content[0]->score; ?>"  />
                </div>

        </div>
    </div>
    <div class=" col-md-12 margin-top-10">
        <div class="form-group">
            <label>
                <?php echo $this->lang->line('priority'); ?>
            </label>
            <div class="col-md-4 no-padding margin-top-5">
                <select class="form-control select_priority" name="priority">
                    <option value="0" <?php echo $content[0]->prospect_priority == '0' ? 'selected' : ''; ?> ><?php echo $this->lang->line("priority_normal"); ?></option>
                    <option value="1" <?php echo $content[0]->prospect_priority == '1' ? 'selected' : ''; ?> ><?php echo $this->lang->line("priority_high"); ?></option>
                    <option value="2" <?php echo $content[0]->prospect_priority == '2' ? 'selected' : ''; ?> ><?php echo $this->lang->line("priority_veryhigh"); ?></option>
                </select>
            </div>
            <div class="col-md-4 margin-top-10">
                <?php echo $bookmark; ?>
            </div>

        </div>
    </div>
    <div class=" col-md-12 margin-top-10">
        <div class="form-group">
            <label>
                <?php echo $this->lang->line('Middle_Catchment'); ?>
            </label>
                <div  id="show_not_exist_medios">
                    <input id="mediodesc" name="mediodesc" type="text" class="form-control typeahead"
                           placeholder="<?php echo $this->lang->line('leads_select_media'); ?>"
                           value="<?php echo @$content[0]->Descripcion; ?>"/>
                        <i class="fa fa-remove unassign_icon" title="<?php echo $this->lang->line('unassign'); ?>" style="z-index: 9999;"></i>
                    <input type="hidden" class="form-control" id="medio" name="medio"
                           value="<?php echo @$content[0]->IdMedio; ?>"/>
                </div>

        </div>
    </div>
    <div class="col-md-12">
        <div class="form-group">
            <label>
                <?php echo $this->lang->line('campaign'); ?>
            </label>
                <div  id="show_not_exist_campaigns">
                    <input id="campaign" name="campaign" type="text" class="form-control typeahead"
                           placeholder="<?php echo $this->lang->line('leads_select_campaign'); ?>"
                           value="<?php echo @$content[0]->company_desc; ?>"/>
                    <i class="fa fa-remove unassign_icon" title="<?php echo $this->lang->line('unassign'); ?>" style="z-index: 9999;"></i>
                    <input type="hidden" class="form-control" id="Campaña" name="Campaña"
                           value="<?php echo @$content[0]->IdCampaña; ?>" />
                </div>
        </div>
    </div>
    <div class="col-md-16">
            <div class="back_save_group">
                <button class="btn btn-sm btn-primary btn-circle "><?php echo $this->lang->line('save'); ?></button>
                <button class="btn btn-primary btn-circle enroll_prospect"><?php echo $this->lang->line('enroll'); ?></button>
                <button class="btn btn-primary btn-circle view_template"><?php echo $this->lang->line('leads_print'); ?></button>
            </div>
    </div>
</form>

<div class="col-md-6 text-center margin-top-10  margin-bottom-20 ">
    <table id="tags_bg" class="table tag_table margin-top-30">
        <tbody>
        <tr class="success">
            <td> <?php echo $this->lang->line('prospects_tags'); ?> </td>
            <td>
                <a href="javascript:;" class="enroll_tags">  </a>
            </td>
        </tr>
        </tbody>
    </table>
</div>
<div class="col-md-12">
    <h3 class="leads_detail_application"><?php echo $this->lang->line('leads_detail_app'); ?></h3>
    <div class="lst_sol_sol no_data_table">
        <table class="lst_sol_solTable  table">

        </table>
    </div>
</div>

<div class="col-md-12">
    <h3 class="leads_offered_courses"><?php echo $this->lang->line('leads_offered_courses'); ?></h3>
    <div id="offeredCoursesTable_no" class="no_data_table"></div>
    <div id="offeredCoursesTable">

    </div>
</div>


<div class="modal fade" id="sel_cursos_modal" tabindex="-1" role="dialog" aria-labelledby="selCursosModalLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><?php echo $this->lang->line('leads_add_courses'); ?></h4>
            </div>
            <div class="modal-body">
                <table class="sel_cursos table ">
                </table>
            </div>
            <div class="modal-footer">
                <div class="col-md-12 margin-top-10">
                    <div class="pull-left">
                        <button class="btn pull-right btn-primary btn-circle selectall"><i class="fa fa-check-square-o" aria-hidden="true"></i> <?php echo $this->lang->line('select_all'); ?></button>
                    </div>
                    <div class="pull-right">
                        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->lang->line(
                                'close'
                            ); ?></button>
                        <button class="btn btn-primary savecursos"><?php echo $this->lang->line('save'); ?></button>
                    </div>
                </div>
            </div>
        </div>

        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<div class="modal fade" id="add_offered_courses_modal" tabindex="-1" role="dialog" aria-labelledby="add_offered_courses_modal"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><?php echo $this->lang->line('leads_add_courses'); ?></h4>
            </div>
            <div class="modal-body">
                <div id="add_offered_courses">
                </div>
            </div>
            <div class="modal-footer">
                <div class="col-md-12 margin-top-10">
                    <div class="pull-left">
                        <button class="btn pull-right btn-primary btn-circle selectall"><i class="fa fa-check-square-o" aria-hidden="true"></i> <?php echo $this->lang->line('select_all'); ?></button>
                    </div>
                    <div class="pull-right">
                        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->lang->line(
                                'close'
                            ); ?></button>
                        <button class="btn btn-primary save_courses"><?php echo $this->lang->line('save'); ?></button>
                    </div>
                </div>
            </div>
        </div>

        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div class="modal fade" id="deleteCourseModal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"> <?php echo $this->lang->line("please_confirm"); ?></h4>
            </div>
            <div class="modal-body">
                <p><?php echo $this->lang->line('confirmDelete'); ?></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->lang->line('close'); ?></button>
                <button type="button" class="btn btn-danger delete_course_confirm" data-dismiss="modal"><?php echo $this->lang->line('delete'); ?></button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="deleteTagModal" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title"><?php echo $this->lang->line('please_confirm'); ?></h4>
            </div>
            <div class="modal-body">
                <p> <?php echo $this->lang->line('are_you_sure_delete'); ?>                                </p>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn default" data-dismiss="modal"><?php echo $this->lang->line('close'); ?></button>
                <button  class="btn btn-danger deleteTagModal"><?php echo $this->lang->line('done'); ?></button>
            </div>

        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>




<script>
    var _lst_sol_solContents = <?php echo isset($lst_sol_sol) ? json_encode($lst_sol_sol) : json_encode(array()); ?>;
    var _sel_cursosTableContents = <?php echo isset($sel_cursos) ? json_encode($sel_cursos) : json_encode(array()); ?>;
    var _offered_courses = <?php echo isset($offered_courses) ? json_encode($offered_courses) : json_encode(array()); ?>;
    var _tags = <?php echo  json_encode($tags);?>;
    var _prospect_tag_ids = <?php echo  json_encode($prospect_tag_ids);?>;
</script>
<script src="<?php echo base_url(); ?>app/js/leads/partials/details.js"></script>