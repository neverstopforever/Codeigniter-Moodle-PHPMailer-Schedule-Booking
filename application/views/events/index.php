        <div class="page-container">
            <div class="table_loading"></div>
            <!-- BEGIN PAGE CONTENT -->
            <div class="page-content">
                <div class="<?php echo $layoutClass ?>">
                    <ul class=" page-breadcrumb breadcrumb">
                        <li>
                            <a href="<?php echo $_base_url; ?>" ><?= $this->lang->line('menu_Home') ?></a>
                        </li>
                        <li>
                            <a href="javascript:;"><?php echo $this->lang->line('menu_planning'); ?></a>
                        </li>
                        <li class="active">
                            <?php echo $this->lang->line('menu_events'); ?>
                        </li>
                    </ul>
                    <div class="row">
                        <div class="col-sm-7 visible-xs">
                            <div class=" messages_event_box">
                                <div class="text-right">
                                    <button type="button" id="quick_tips" class="btn btn-xs green-meadow "> <i class="fa fa-lightbulb-o" aria-hidden="true"></i> <span class="button_text"><?php echo $this->lang->line('show_quick_tips'); ?></span> <i class="fa fa-angle-down fa-angledown"></i></button>
                                </div>
                                <div class="quick_tips_sidebar margin-top-20">
                                    <div class=" note note-info quick_tips_content">
                                        <h2><?php echo $this->lang->line('quick_box_title'); ?></h2>
                                        <p><?php echo $this->lang->line('event_quick_tips_text'); ?>
                                            <strong><a href="<?php echo $this->lang->line('event_quick_tips_link'); ?>" target="_blank"><?php echo $this->lang->line('event_quick_tips_link_text'); ?></a></strong>
                                        </p>
                                    </div>
                                </div>
                                <div class=" text-right event_details_head">
                                    <h3 class="panel-title pull-left" id="event_title1"><?php echo $this->lang->line('events_details'); ?></h3>
                                </div>
                                <div id="event_details1"><?php echo $this->lang->line('campus_click_an_event');?></div>
                                <div class="row" id="pi_boxes">
                                    <div class="internal_box"></div><span class="internal_box_title"><?php echo $this->lang->line('events_internal'); ?></span>
                                    <div class="public_box"></div><span class="public_box_title"><?php echo $this->lang->line('events_public'); ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-5">
                            <input type="hidden" name="h_events_type" id="h_events_type" value="">
                            <div class=" messages_event_box">
                                <div class="panel-heading text-right ">
                                    <h3 class="panel-title pull-left" id="events_title"><?php echo $this->lang->line('campus_internal_events');?></h3>
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


                                <div class="" >
                                    <div class="margin-bottom-10 text-right">
                                        <button class="btn btn-primary btn-circle" id="add_event" data-toggle="modal" data-target="#add_event_modal">+ <?php echo $this->lang->line('events_add') ?></button>
                                    </div>
                                    <div id="events"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-7 hidden-xs">
                            <div class=" messages_event_box">
                                <div class="text-right">
                                    <button type="button" id="quick_tips1" class="btn btn-xs green-meadow "> <i class="fa fa-lightbulb-o" aria-hidden="true"></i> <span class="button_text"><?php echo $this->lang->line('show_quick_tips'); ?></span> <i class="fa fa-angle-down fa-angledown"></i></button>
                                </div>
                                <div class="quick_tips_sidebar margin-top-20 margin-bottom-20">
                                    <div class=" note note-info quick_tips_content">
                                        <h2><?php echo $this->lang->line('quick_box_title'); ?></h2>
                                        <p><?php echo $this->lang->line('event_quick_tips_text'); ?>
                                            <strong><a href="<?php echo $this->lang->line('event_quick_tips_link'); ?>" target="_blank"><?php echo $this->lang->line('event_quick_tips_link_text'); ?></a></strong>
                                        </p>
                                    </div>
                                </div>
                                <div class=" text-right event_details_head">
                                    <h3 class="panel-title pull-left" id="event_title"><?php echo $this->lang->line('events_details'); ?></h3>
                                </div>
                                <div id="event_details"><?php echo $this->lang->line('campus_click_an_event');?></div>
                                <div class="row" id="pi_boxes">
                                    <div class="internal_box"></div><span class="internal_box_title"><?php echo $this->lang->line('events_internal'); ?></span>
                                    <div class="public_box"></div><span class="public_box_title"><?php echo $this->lang->line('events_public'); ?></span>
                                </div>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END PAGE CONTENT -->
        <div class="modal fade" id="add_event_modal" tabindex="-1" role="dialog" aria-labelledby="addEventModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="addEventModalLabel"><?php echo $this->lang->line('events_new'); ?></h4>
                    </div>
                    <form  id="add_event_form" method="POST" enctype="multipart/form-data">
                    <div class="modal-body">
                                <div class="form-group">
                                    <label><?php echo $this->lang->line('events_select_option_label'); ?> </label>
                                    <select class="form-control" name="public" id="public">
                                        <option value="">--<?php echo $this->lang->line('events_select_option');?>--</option>
                                        <option value="0"><?php echo $this->lang->line('events_internal');?></option>
                                        <option value="1"><?php echo $this->lang->line('events_public');?></option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>
                                        <?php echo $this->lang->line('events_event_date'); ?> </label>                                                                 </label>
                                    <input type="text" class="form-control" id="event_date" name="event_date" readonly>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">
                                        <?php echo $this->lang->line('events_title') ?>:</label>
                                    <input type="text" class="form-control" id="title" name="title" placeholder="<?php echo $this->lang->line('events_title');?>">
                                </div>
                                <div class="form-group">
                                    <label class="control-label"><?php echo $this->lang->line('events_content') ?>:</label>
                                    <textarea autocomplete="off" class="form-control" id="content" name="content" rows="12" placeholder="<?php echo $this->lang->line('events_write_content');?>"></textarea>
                                </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->lang->line('close');?></button>
                            <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i><?php echo $this->lang->line('events_add') ?></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
