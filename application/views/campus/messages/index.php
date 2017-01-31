        <div class="page-container">
            <div class="table_loading"></div>
            <!-- BEGIN PAGE CONTENT -->
            <div class="page-content">
                <div class="<?php echo $layoutClass ?>">
                    <ul class="page-breadcrumb breadcrumb">
                        <li>
                            <a href="<?php echo $_base_url; ?>" ><?php echo $this->lang->line('menu_Home'); ?></a>
                        </li>
                        <li>
                            <a href="javascript:;"><?php echo $this->lang->line('option'); ?></a>
                        </li>
                        <li class="active">
                            <?php echo $this->lang->line('menu_messaging'); ?>
                        </li>
                    </ul>
                    <div class="portlet light">
                        <div class="portlet-body">
                            <div class="text-right quick_tip_wrapper margin-bottom-10">
                                <a href="http://blog.akaud.com" target="_blank" type="button" class="btn btn-xs quick_tip green-meadow "> <i class="fa fa-lightbulb-o" aria-hidden="true"></i> <span class="button_text"><?php echo $this->lang->line('quick_tip');?></span> </a>
                            </div>
                            <div class="row inbox">
                                <div class="col-sm-3 text-center">
                                    <input type="hidden" name="h_message_from" id="h_message_from" value="">

                                        <div class="compos_new_message">
                                            <button  class="btn btn-block btn-primary btn-circle message_from new_message" data-message_from="campose" data-title="Compose"  data-toggle="modal" data-target="#compose_modal">
                                                <i class="fa fa-plus"></i>
                                                <?php echo $this->lang->line('new_message') ?>
                                            </button>
                                        </div>
                                        <div class="inbox active io_active">
                                            <button  class="btn btn-block message_from btn-circle text-primary" data-message_from="inbox" data-title="Inbox"><?php echo $this->lang->line('button_msgInbox') ?> </button>
                                            <b></b>
                                        </div>
                                        <div class="sent io_active">
                                            <button class="btn btn-block message_from btn-circle text-primary"  data-message_from="outbox"  data-title="Sent"><?php echo $this->lang->line('button_msgSent') ?></button>
                                            <b></b>
                                        </div>

                                </div>
                                <div class="col-sm-9 messages_section">

                                    <div class="inbox-loading">
                                        <?php echo $this->lang->line('msg_loading') ?>
                                    </div>
                                    <div class="inbox-content">
                                        <div>
                                            <div class="panel-body" id="messages"></div>
                                        </div>
                                    </div>
                                    <div class="modal fade" id="compose_modal" tabindex="-1" role="dialog" aria-labelledby="composeModalLabel">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                    <h4 class="modal-title" id="composeModalLabel"><?php echo $this->lang->line('campus_send_message'); ?></h4>
                                                </div>
                                                <div class="modal-body">
                                                    <form class="form-horizontal" id="composemsg" method="POST" enctype="multipart/form-data">
                                                            <div class="form-group">
                                                                <label class="control-label" for="totype"><?php echo $this->lang->line('campus_to_type') ?>:</label>
                                                                <select class="form-control" name="totype" id="totype" required>
                                                                    <option value="-1"><?php echo $this->lang->line('campus_select_to_type');?></option>
                                                                    <option value="0"><?php echo $this->lang->line('school');?></option>
                                                                    <option value="2"><?php echo $this->lang->line('student');?></option>
                                                                    <option value="3"><?php echo $this->lang->line('group');?></option>
                                                                </select>
                                                            </div>
                                                            <div id="to_select" style="display:none;">
                                                                <div class="form-group">
                                                                    <label class="control-label">
                                                                        <?php echo $this->lang->line('msg_messageDetailTo') ?>:</label>
                                                                        <select name="to" id="to" class="allUsers form-control" ></select>
                                                                        <input name="to_select2" id="to_select2" class="allGroups form-control"  style="display: none;">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label class="control-label">
                                                                        <?php echo $this->lang->line('msg_messageSubject') ?>:</label>
                                                                        <input type="text" class="form-control subject" required name="subject" placeholder="<?php echo $this->lang->line('msg_messageSubject');?>">
                                                                    <label class="control-label"><?php echo $this->lang->line('msg_messageBody') ?>:</label>
                                                                    <textarea autocomplete="off" required class="form-control" name="message" rows="12" placeholder="<?php echo $this->lang->line('campus_write_message');?>"></textarea>
                                                                </div>
                                                                <div class="form-group">
                                                            <!-- The template to display files available for download -->
                                                                    <button class="btn btn-primary pull-right" type="submit"><i class="fa fa-check"></i>
                                                                        <?php echo $this->lang->line('msg_messageSend') ?>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                    </form>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->lang->line('close');?></button>
<!--                                                    <button type="button" class="btn btn-primary">Save changes</button>-->
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
        </div>

        <div id="CampusDeleteMessageModal" class="modal fade" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title"> <?php echo $this->lang->line("please_confirm"); ?></h4>
                    </div>
                    <form id="" method="POST" enctype="multipart/form-data">
                        <div class="modal-body">
                            <p><?php echo $this->lang->line("message_confirm_delete"); ?></p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->lang->line("close"); ?></button>
                            <button type="submit" data-task="delete_message" class="btn btn-danger delete_message"><?php echo $this->lang->line("done"); ?></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- END PAGE CONTENT -->