        <div class="page-container">
           
            <div class="table_loading"></div>
            <div class="page-content">
                <div class="<?php echo $layoutClass ?>">
                    <ul class="page-breadcrumb breadcrumb">
                        <li>
                            <a href="<?php echo $_base_url; ?>" ><?= $this->lang->line('menu_Home') ?></a>
                        </li>
                        <li>
                            <a href="javascript:;"><?php echo $this->lang->line('menu_planning'); ?></a>
                        </li>
                        <li class="">
                            <a href="<?php echo $_base_url; ?>schedules "><?php echo $this->lang->line('menu_calendar'); ?></a>
                        </li>
                        <li class="active">
                            <?php echo isset($action) ? $this->lang->line($action) : $this->lang->line('groups'); ?>
                        </li>
                    </ul>
                    <!-- BEGIN PAGE CONTENT INNER -->
                    <div class="schedule_sections_section widget-row">
                        <div class="col-sm-3 ">
                            <a href="<?php echo base_url(); ?>schedules?action=groups">
                                <div class="widget-thumb  text-uppercase  groups_schedul <?php echo $active_groups;?>">
                                    <div class="widget-thumb-wrap">
                                        <i class="fa fa-users pull-left "></i>
                                        <div class="pull-right text-left">
                                            <h4 class="widget-thumb-heading  margin-left-10"><?php echo $this->lang->line('groups'); ?></h4>
                                        </div>
                                    </div>

                                </div>
                            </a>
                        </div>
                        <div class="col-sm-3">
                            <a href="<?php echo base_url(); ?>schedules?action=courses">
                                <div class=" widget-thumb  text-uppercase  courses_schedul <?php echo $active_courses;?>">
                                    <div class="widget-thumb-wrap">
                                        <i class="fa fa-book"></i>
                                        <div class="pull-right text-left">
                                            <h4 class="widget-thumb-heading"><?php echo $this->lang->line('courses'); ?></h4>
                                        </div>
                                    </div>

                                </div>
                            </a>
                        </div>
                        <div class="col-sm-3">
                            <a href="<?php echo base_url(); ?>schedules?action=classrooms">
                                <div class="widget-thumb  text-uppercase  classrooms_schedul <?php echo $active_classrooms;?>">
                                    <div class="widget-thumb-wrap">
                                        <i class="fa fa-street-view"></i>
                                        <div class="pull-right text-left">
                                            <h4 class="widget-thumb-heading"><?php echo $this->lang->line('classrooms'); ?></h4>
                                        </div>
                                    </div>

                                </div>
                            </a>
                        </div>
                        <div class="col-sm-3">
                            <a href="<?php echo base_url(); ?>schedules?action=teachers">
                                <div class=" widget-thumb  text-uppercase teachers_schedul <?php echo $active_teachers;?>">

                                    <div class="widget-thumb-wrap">
                                        <i class="fa fa-user "></i>
                                        <div class="pull-right text-left">
                                            <h4 class="widget-thumb-heading"><?php echo $this->lang->line('teachers'); ?></h4>
                                        </div>
                                    </div>

                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="portlet light">
                        <div class="text-right">
                            <button type="button" id="quick_tips" class="btn btn-xs green-meadow "> <i class="fa fa-lightbulb-o" aria-hidden="true"></i> <span class="button_text"><?php echo $this->lang->line('show_quick_tips'); ?></span> <i class="fa fa-angle-down fa-angledown"></i></button>
                        </div>
                        <div class="quick_tips_sidebar margin-top-20">
                            <div class=" note note-info quick_tips_content">
                                <h2><?php echo $this->lang->line('quick_box_title'); ?></h2>
                                <p><?php echo $this->lang->line('schedules_quick_tips_text'); ?>
                                    <strong><a href="<?php echo $this->lang->line('schedules_quick_tips_link'); ?>" target="_blank"><?php echo $this->lang->line('schedules_quick_tips_link_text'); ?></a></strong>
                                </p>
                            </div>
                        </div>                        
                        <!--calendar-->
                        <div class="tabbable" >
                            <ul class="nav nav-tabs" >
                                <?php foreach ($staffs as $staff){
                                    if(!empty($staff['name'])){
                                        ?>
                                        <li class="ab-calendar-tab" data-staff_id="<?php echo $staff['id'];?>" data-staff_color="<?php echo $staff['color'];?>" style="display: none">
                                            <a href="#" data-toggle="tab"><?php echo $staff['name'];?></a>
                                        </li>
                                    <?php }
                                }?>
                                <li class="ab-calendar-tab active" data-staff_id="0" data-staff_color="0">
                                    <a href="#" data-toggle="tab"><?php echo $this->lang->line('all'); ?></a>
                                </li>
                                <li class="pull-right">
                                    <div class="btn-group pull-right">
                                        <button class="btn  btn-primary btn-semi-left-circle ab-staff-filter-button" data-toggle="dropdown">
                                            <i class="glyphicon glyphicon-user"></i>
                                            <span id="ab-staff-button"></span>
                                        </button>
                                        <button class="btn btn-primary btn-semi-right-circle dropdown-toggle ab-staff-filter-button" data-toggle="dropdown" aria-expanded="true"><span class="caret"></span></button>
                                        <ul class="dropdown-menu pull-right">
                                            <li>
                                                <a href="javascript:void(0)">
                                                    <div class="md-checkbox">
                                                        <input type="checkbox" id="ab-filter-all-staff" class="left">
                                                        <label for="ab-filter-all-staff"><?php echo isset($all_staffs) ? $all_staffs :$this->lang->line('schedules_all_groups');?><span></span><span class="check"></span><span class="box"></span></label>
                                                    </div>
                                                </a>
                                            </li>
                                                <?php foreach ($staffs as $staff){
                                                    if(!empty($staff['name'])){
                                                        ?>
                                                        <li>
                                                        <a href="javascript:void(0)">
                                                            <div class="md-checkbox md-checkbox_min">
                                                                 <input type="checkbox" id="ab-filter-staff-<?php echo $staff['id'];?>" value="<?php echo $staff['id'];?>" data-staff_name="<?php echo $staff['name'];?>" class="ab-staff-filter left">
                                                                 <label for="ab-filter-staff-<?php echo $staff['id'];?>"><?php echo $staff['name'];?><span></span><span class="check"></span><span class="box"></span></label>
                                                            </div>
                                                        </a>
                                                        </li>
                                                    <?php }
                                                }?>

                                        </ul>
                                    </div>
                                </li>
                            </ul>
                        </div>
                            <div class="portlet-body">
                                <div class="portlet light portlet-fit  calendar">
                                    <div id="full_calendar_wrapper">

                                    </div>
                                </div>
                            </div>
                        <!--end calendar-->
                        
                    </div>
                    <div class="clearfix"></div>
                </div>
                <!-- END PAGE CONTENT INNER -->
            </div>
        </div>
        <div class="modal fade" id="eventpanel" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                        <h4 class="modal-title event_title"></h4>
                    </div>
                    <div class="modal-body">
                        <label><?php echo $this->lang->line('date');?>: <span class="event_date"></span></label>
                        <p class="event_time"></p>
<!--                        <label>--><?php //echo $this->lang->line('campus_calender_modal_detail');?><!--</label>-->
                        <p class="event_detail"></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->lang->line('close');?></button>
                    </div>
                </div>
            </div>
        </div>
        <script>
            _schedules = {
                "ajaxurl": "<?php echo base_url()."schedules/getCalendarData"; ?>",
                "firstDay": "1",
                "axisFormat": "h:mm a",
                "timeFormat":    "h:mm a",
                "action":    "<?php echo isset($action) ? $action : "groups"; ?>",
                "noStaffSelected":  "<?php echo isset($no_staff_selected) ? $no_staff_selected : $this->lang->line('schedules_no_group_selected'); ?>",
                "allDay": "<?php echo $this->lang->line('schedules_all_day'); ?>",
                "slotDuration": "00:15:00",
                "delete": "<?php echo $this->lang->line('delete'); ?>",
            };
        </script>