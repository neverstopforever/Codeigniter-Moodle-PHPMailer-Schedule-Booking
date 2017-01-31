<div class="page-container">


    <div class="table_loading"></div>
    <div class="page-content">
        <div class="<?php echo $layoutClass ?>">
            <ul class="page-breadcrumb breadcrumb">

                <li>
                    <a href="<?php echo $_base_url; ?>" ><?php echo $this->lang->line('menu_Home'); ?></a>
                </li>
                <li class="active"><?php echo $this->lang->line('campus_student_dashboard'); ?></li>
            </ul>
                <div class="row">
                    <div class="col-sm-7 col-md-8 inner_calendar_event">

                        <div class="portlet light">

                            <div class="portlet-body">
                                <div class="portlet light portlet-fit  calendar">
                                    <div class=" calendar_event_box">
                                        <div class="text-right quick_tip_wrapper">
                                            <a href="http://blog.akaud.com" target="_blank" type="button" class="btn btn-xs quick_tip green-meadow "> <i class="fa fa-lightbulb-o" aria-hidden="true"></i> <span class="button_text"><?php echo $this->lang->line('quick_tip');?></span> </a>
                                        </div>
                                        <div class="text-right  details_head calendar_event_box_header">
                                            <h3 class=" pull-left" id="calendar_title"><?php echo $this->lang->line('campus_calendar_title');?></h3>
                                        </div>
                                        <div  id="calendar"></div>
                                    </div>
                                </div>
                            </div>
                         </div>
                    </div>

                    <div class="col-sm-5 col-md-4 inner_calendar_event">
                        <div class=" calendar_event_box">
                            <div class=" text-right incomming_events_head details_head">
                                <h3 class=" pull-left" id="events_title"><?php echo $this->lang->line('campus_internal_events');?></h3>

                            </div>
                            <div  id="events"></div>
                        </div>
                    </div>
                </div>
            </div>
    </div>
</div>

<div class="modal fade" id="agenda_eventpanel" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title agenda_event_title"></h4>
            </div>
            <div class="modal-body">
                <div>
                <label><?php echo $this->lang->line('campus_calender_modal_date').' : ';?></label>
                <span class="agenda_event_date"></span>
                </div>
                <div>
                <label><?php echo $this->lang->line('time').' : ';?></label>
                <span class="agenda_event_time"></span>
                </div>
                <label><?php echo $this->lang->line('campus_calender_modal_detail');?></label>
                <p class="agenda_event_detail"></p>
            </div>
            <div class="modal-footer">
                <i class="fa fa-bars pull-left" aria-hidden="true"></i>
                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->lang->line('campus_calender_modal_close');?></button>
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
<!--                <button type="button" class="btn btn-success save_custom_fields">--><?php //echo $this->lang->line('save');?><!--</button>-->
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    var _data = <?php echo $agenda_event;?>;
    var events = [];
    var _customfields_fields = <?php echo json_encode($customfields_fields);?>;
</script>