<div class="page-container">
    <div class="page-head">
        <div class="<?php echo $layoutClass ?>">
            <div class="page-title">
                <h1><?php echo $this->lang->line('menu_information'); ?></h1>
            </div>
        </div>
    </div>
    <ul class="<?php echo $layoutClass ?> page-breadcrumb breadcrumb">
        <li><a href="#"><?= $this->lang->line('menu_Home') ?></a></li>
        <li class="active"><?php echo $this->lang->line('campus_teacher_dashboard'); ?></li>
    </ul>
    <div class="<?php echo $layoutClass ?>">
            <h2><?php echo $this->lang->line('campus_dashboard'); ?></h2>
    </div>
    <div class="table_loading"></div>

        <div class="<?php echo $layoutClass ?>">

                <div class="">

                    <div class="statistic_counts">
                        <div class="text-right ">
                            <a href="http://blog.akaud.com" target="_blank" type="button" class="btn btn-xs quick_tip green-meadow "> <i class="fa fa-lightbulb-o" aria-hidden="true"></i> <span class="button_text"><?php echo $this->lang->line('quick_tip');?></span> </a>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-3">
                            <div class="active_students box_statistic text-center ">
                                <i class="fa fa-user fa-3x hidden-md"></i>
                                <div class="text-left">
                                    <i class="fa fa-user fa-3x visible-md-inline "></i>
                                    <span><?php echo $count_active_students;?></span>
                                    <p><?php echo $this->lang->line('campus_active_students');?></p>
                                </div>
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-6 col-md-3">
                            <div class="active_groups box_statistic text-center">
                                <i class="fa fa-users fa-3x hidden-md "></i>
                                <div class="text-left">
                                    <i class="fa fa-users fa-3x visible-md-inline "></i>
                                     <span><?php echo $count_active_groups;?></span>
                                     <p><?php echo $this->lang->line('campus_active_groups');?></p>
                                </div>
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-6 col-md-3">
                            <div class="new_messages box_statistic text-center">
                                <i class="fa fa-envelope-o fa-3x hidden-md "></i>
                                <div class="text-left">
                                    <i class="fa fa-envelope-o fa-3x visible-md-inline "></i>
                                    <span><?php echo $num_messages;?></span>
                                    <p><?php echo $this->lang->line('campus_new_messages');?></p>
                                </div>
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-6 col-md-3">
                             <div class="new_posts box_statistic text-center">
                                <i class="fa fa-file-text-o fa-3x hidden-md "></i>
                                <div class="text-left">
                                    <i class="fa fa-file-text-o fa-3x visible-md-inline "></i>
                                     <span><?php echo $count_recent_events;?></span>
                                    <p><?php echo $this->lang->line('campus_new_posts');?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row ">
                    <div class="col-md-8 inner_messages_event">
                        <div class=" messages_event_box">
                            <div class="text-right messages_event_box_header ">
                                <h3 class="panel-title pull-left" id="message_title"><?php echo $this->lang->line('campus_inbox_messages');?></h3>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-xs btn-default dropdown-toggle"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fa fa-cog"></i> <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-right">
                                        <li><a href="#" class="message_from" data-message_from="inbox"><?php echo $this->lang->line('campus_inbox'); ?></a></li>
                                        <li><a href="#" class="message_from" data-message_from="outbox"><?php echo $this->lang->line('campus_outbox'); ?></a></li>
                                    </ul>
                                </div>
                            </div>
                            <div id="messages"></div>
                        </div>
                    </div>

                    <div class="col-md-4 inner_messages_event">
                        <div class="messages_event_box">
                            <div class=" text-right incomming_events_head">
                                <h3 class="panel-title pull-left" id="event_title"><?php echo $this->lang->line('campus_internal_events');?></h3>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-xs btn-default dropdown-toggle"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fa fa-cog"></i> <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-right">
                                        <li><a href="#" class="event_type" data-events_type="all"><?php echo $this->lang->line('campus_all'); ?></a></li>
                                        <li><a href="#" class="event_type" data-events_type="internal"><?php echo $this->lang->line('campus_internal'); ?></a></li>
                                        <li><a href="#" class="event_type" data-events_type="public"><?php echo $this->lang->line('campus_public'); ?></a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="" id="events"></div>
                        </div>
                    </div>
                </div>
            </div>

</div>