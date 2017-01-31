<div class="page-container">


    <div class="table_loading"></div>
    <div class="page-content">
        <div class="<?php echo $layoutClass ?>">
            <ul class=" page-breadcrumb breadcrumb">
                <li>
                    <a href="<?php echo $_base_url; ?>" ><?php echo $this->lang->line('menu_Home'); ?></a>
                </li>
                <li class="active"><?php echo $this->lang->line('calender'); ?></li>
            </ul>
        <div class="calender_section overf_hidden" >

            <div class="portlet light">
                <div class="portlet-body">
                    <div class="portlet light portlet-fit  calendar">
                    <div class=" portlet-title">
                        <div class="clearfix"></div>
                        <div class="calendar-ui  col-md-12">
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
</div>
<div class="modal fade" id="eventpanel" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="event_title"></h4>
            </div>
            <div class="modal-body">
                <div class="event_time"></div>
                <label><?php echo $this->lang->line('campus_calender_modal_date').' :';?></label>
                <span class="event_date"></span>
                <div>
                <label><?php echo $this->lang->line('campus_calender_modal_detail');?></label>
                <p class="event_detail"></p>
                </div>
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
<!--                <button type="button" class="btn btn-success save_custom_fields">--><?php //echo $this->lang->line('save');?><!--</button>-->
            </div>
        </div>
    </div>
</div>


<script type="text/javascript">
    var _data = <?php echo $event; ?>;
    var events = [];
    var _customfields_fields = <?php echo json_encode($customfields_fields);?>;
</script>
