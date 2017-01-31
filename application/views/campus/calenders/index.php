<div class="page-container">


    <div class="table_loading"></div>
    <div class="page-content">
        <ul class="<?php echo $layoutClass ?> page-breadcrumb breadcrumb">
            <li><a href="#"><?= $this->lang->line('menu_Home') ?></a></li>
            <li class="active"><?php echo $this->lang->line('calender'); ?></li>
        </ul>
        <div class="<?php echo $layoutClass ?> calender_section">

            <div class="portlet light">
                <div class="portlet-body">
                    <div class="portlet light portlet-fit  calendar">
                        <div class="text-right margin-bottom-20">
                            <a href="http://blog.akaud.com" target="_blank" type="button" class="btn btn-xs quick_tip green-meadow "> <i class="fa fa-lightbulb-o" aria-hidden="true"></i> <span class="button_text"><?php echo $this->lang->line('quick_tip');?></span> </a>
                        </div>
                    <div class="col-md-12 portlet-title">

                        <div class="form-inline">
                            <div class="form-group">
                                <label>Curso:
                                    <select id="CourseId" name="idactividad" class="form-control filter_events calender_filter"/>
                                    <option value="">--Todos--</option>
                                    <?php foreach ($course as $list): ?>
                                        <option
                                            value="<?php echo $list->idactividad; ?>"><?php echo $list->actividad; ?></option>
                                    <?php endforeach; ?>
                                    </select>
                                </label>
                            </div>
                            <div class="form-group">
                                <label>Grupo:
                                    <select id="GroupId" name="Idgrupo" class="form-control filter_events calender_filter"/>
                                    <option value="">--Todos--</option>
                                    </select>
                                </label>
                            </div>
                        </div>

                        <div class="clearfix"></div>
                        <div class="calendar-ui ">
                            <div class="pull-right">
                            </div>
                            <div id="calendar"></div>
                        </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
</div>
<div class="modal fade" id="eventpanel" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="event_title"></h4>
            </div>
            <div class="modal-body">
                <label><?php echo $this->lang->line('campus_calender_modal_date');?></label>
                <p class="event_date"></p>
                <label><?php echo $this->lang->line('campus_calender_modal_detail');?></label>
                <p class="event_detail"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->lang->line('campus_calender_modal_close');?></button>
                <i class="fa fa-bars pull-left" aria-hidden="true"></i>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="eventCustomFealds" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title"> <?php echo $this->lang->line('custom_fields');?> </h4>
            </div>
            <div class="modal-body">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->lang->line('close');?></button>
                <button type="button" class="btn btn-success save_custom_fields"><?php echo $this->lang->line('save');?></button>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    var _data = <?php echo $event;?>;
    var _group = <?php echo $group?>;
    var events = [];
    var _customfields_fields = <?php echo json_encode($customfields_fields);?>;
</script>
