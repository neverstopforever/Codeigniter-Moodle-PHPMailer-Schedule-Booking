        <!-- BEGIN PAGE CONTAINER -->
        <div class="page-container">
            <!-- BEGIN PAGE HEAD -->
            <div class="page-head">
                <div class="<?php echo $layoutClass ?>">
                    <!-- BEGIN PAGE TITLE -->
                    <div class="page-title">
                        <h1><?php echo $this->lang->line('menu_events'); ?></h1>
                    </div>
                    <!-- END PAGE TITLE -->
                </div>
            </div>
            <!-- END PAGE HEAD -->
            <ul class="<?php echo $layoutClass ?> page-breadcrumb breadcrumb">
                <li>
                    <a href="#"><?=$this->lang->line('menu_Home')?></a></i>
                </li>
                <li class="active">
                    <?php echo $this->lang->line('menu_events'); ?>
                </li>
            </ul>

            <div class="table_loading"></div>
            <!-- BEGIN PAGE CONTENT -->
            <div class="page-content">
                <div class="<?php echo $layoutClass ?>">
                    <div class="row">
                        <div class="col-sm-6">
                            <input type="hidden" name="h_events_type" id="h_events_type" value="">
                            <div class="panel panel-primary messages_event_box">
                                <div class="panel-heading text-right incomming_events_head">
                                    <h3 class="panel-title pull-left" id="events_title"><?php echo $this->lang->line('campus_internal_events');?></h3>
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-xs btn-default dropdown-toggle"
                                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fa fa-cog"></i> <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a href="#" class="event_type" data-events_type="all"><?php echo $this->lang->line('campus_all'); ?></a></li>
                                            <li><a href="#" class="event_type" data-events_type="internal"><?php echo $this->lang->line('campus_internal'); ?></a></li>
                                            <li><a href="#" class="event_type" data-events_type="public"><?php echo $this->lang->line('campus_public'); ?></a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="panel-body" id="events"></div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="panel panel-primary messages_event_box">
                                <div class="panel-heading text-right incomming_events_head event_details_head">
                                    <h3 class="panel-title pull-left" id="event_title">Event Details</h3>
                                </div>
                                <div class="panel-body" id="event_details"><?php echo $this->lang->line('campus_click_an_event');?></div>
                                <div class="row" id="pi_boxes">
                                    <div class="internal_box"></div><span class="internal_box_title"><?php echo $this->lang->line('campus_internal'); ?></span>
                                    <div class="public_box"></div><span class="public_box_title"><?php echo $this->lang->line('campus_public'); ?></span>
                                </div>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END PAGE CONTENT -->