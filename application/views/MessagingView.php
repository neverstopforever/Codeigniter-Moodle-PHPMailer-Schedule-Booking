        <!-- BEGIN PAGE CONTAINER -->
        <div class="page-container">

            <div class="page-content">
                <div class="<?php echo $layoutClass ?>">
                    <ul class="page-breadcrumb breadcrumb">
                        <li>
                            <a href="<?php echo $_base_url; ?>" ><?= $this->lang->line('menu_Home') ?></a>
                        </li>
                        <li>
                            <a href="javascript:;"><?php echo $this->lang->line('menu_planning'); ?></a>
                        </li>
                        <li class="active">
                            <?php echo $this->lang->line('menu_messaging'); ?>
                        </li>
                    </ul>

                    <!-- END SAMPLE PORTLET CONFIGURATION MODAL FORM-->
                    <div class="table_loading"></div>
                    <div class="portlet light">

                        <div class="text-right">
                            <button type="button" id="quick_tips" class="btn btn-xs green-meadow "> <i class="fa fa-lightbulb-o" aria-hidden="true"></i> <span class="button_text"><?php echo $this->lang->line('show_quick_tips'); ?></span> <i class="fa fa-angle-down fa-angledown"></i></button>
                        </div>
                        <div class="quick_tips_sidebar margin-top-20">
                            <div class=" note note-info quick_tips_content">
                                <h2><?php echo $this->lang->line('quick_box_title'); ?></h2>
                                <p><?php echo $this->lang->line('messaging_quick_tips_text'); ?>
                                    <strong><a href="<?php echo $this->lang->line('messaging_quick_tips_link'); ?>" target="_blank"><?php echo $this->lang->line('messaging_quick_tips_link_text'); ?> </a></strong>
                                </p>
                            </div>
                        </div>

                        <div class="portlet-body">
                            <div class="row inbox">
                                <div class="col-sm-3 text-center inbox-nav">

                                        <div class="compose-btn">
                                            <button  data-title="Compose" class="btn btn-block btn-primary btn-circle user_compose">
                                                <i class="fa fa-plus"></i>
                                                <?php echo $this->lang->line('new_message') ?>
                                            </button>
                                        </div>
                                        <div class="inbox active io_active">
                                            <button  class="btn btn-block btn-circle text-primary message_from " data-title="Inbox"><?php echo $this->lang->line('button_msgInbox') ?> </button>

                                        </div>
                                        <div class="sent io_active">
                                            <button class="btn btn-block btn-circle text-primary message_from"  data-title="Sent"><?php echo $this->lang->line('button_msgSent') ?></button>
                                        </div>
                                    <?php if($referer_is_profile){ ?>
                                        <div class="io_active">
                                            <a href="<?php echo $_base_url; ?>user/profile" class="btn-sm btn btn-circle btn-default-back btn-block" > <i class="fa fa-arrow-left" aria-hidden="true"></i> <?php echo $this->lang->line('back') ?></a>
                                        </div>
                                    <?php  } else if($referer_is_dashboard) {?>
                                        <div class="io_active">
                                            <a href="<?php echo $_base_url; ?>dashboard" class="btn-sm btn btn-circle btn-default-back btn-block" > <i class="fa fa-arrow-left" aria-hidden="true"></i> <?php echo $this->lang->line('back') ?></a>
                                        </div>
                                    <?php } ?>
                                </div>
                                <div class="col-sm-9 messages_section">
<!--                                    <div class="inbox-header">-->
<!--                                        <h3 class="pull-left msg_type">--><?php //echo $this->lang->line('msg_inboxTitle') ?><!--</h3>-->
<!--                                    </div>-->
                                    <div class="inbox-loading">
                                        <?php echo $this->lang->line('msg_loading') ?>
                                    </div>
                                    <div class="inbox-content">
                                        <table class="table dbtable_hover_theme table-advance msg_table">
                                            <thead>
                                                <tr>
                                                    <th>
                                                    </th>
                                                    <th class="pagination-control" colspan="2">
                                                        <span class="pagination-info" style="display:none">
                                                        </span>
                                                        <a class="btn btn-sm blue pagi_prev">
                                                            <i class="fa fa-angle-left"></i>
                                                        </a>
                                                        <a class="btn btn-sm blue pagi_next">
                                                            <i class="fa fa-angle-right"></i>
                                                        </a>
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody class="temp" style="display:none;">
                                                <tr>
                                                    <td class="view-message Asunto ">
                                                    </td>
                                                    <td class="view-message hidden-xs Remitente">
                                                    </td>
                                                    <td class="view-message text-right Fecha">
                                                    </td>
                                                </tr>
                                            </tbody>
                                            <tbody class="real"></tbody>
                                        </table>
                                        <div class="msg_detail_view" style="display:none">
                                            <div class="inbox-header inbox-view-header">
                                                <h2 class="pull-left message_subject"></h2>
                                            </div>
                                            <div class="inbox-view-info">
                                                <div class="row">
                                                    <div class="col-md-7">
                                                        <?php echo $this->lang->line('from') ?>: <span class="bold from_name"></span>

                                                             <span class="date"></span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="inbox-view ">
                                            </div>
                                            <button class="btn btn-circle btn-primary btn-back message_back margin-top-20 "><i class="fa fa-arrow-left"></i> <?php echo $this->lang->line('back') ?></button>
                                            <button class="btn btn-circle btn-danger btn-delete message_delete margin-top-20 "><i class="fa fa-trash-o"></i> <?php echo $this->lang->line('delete') ?></button>
                                        </div>
                                    </div>
                                    <div class="compose_cont" style="display:none;">
                                        <form class="inbox-compose form-horizontal" id="composemsg" method="POST" enctype="multipart/form-data">
                                            <div class="inbox-form-group div_theme_hover_border mail-to">
                                                <label class="control-label">
                                                    <?php echo $this->lang->line('msg_to_type') ?>:</label>
                                                <div class="controls controls-to">
                                                   <!-- <select class="allUsers form-control" required>
                                                    </select>-->
                                                    <select class="form-control" id="select_to_type" style="border: none;">
                                                        <option value="-1"><?php echo $this->lang->line('msg_select_type'); ?></option>
                                                        <option value="1"><?php echo $this->lang->line('Student'); ?></option>
                                                        <option value="2"><?php echo $this->lang->line('teacher'); ?></option>
                                                        <option value="3"><?php echo $this->lang->line('staff'); ?></option>
                                                        <option value="4"><?php echo $this->lang->line('group'); ?></option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="inbox-form-group div_theme_hover_border mail-to to_show_select2" style="display: none">
                                                <label class="control-label">
                                                    <?php echo $this->lang->line('msg_messageDetailTo') ?>:</label>
                                                <div class="controls controls-to">
                                                   <!-- <select class="allUsers form-control" required>
                                                    </select>-->
                                                    <input type="text" class="form-control to_select2"  />
                                                </div>
                                            </div>
                                            <div class="inbox-form-group div_theme_hover_border mail-to to_course_show_select2" style="display: none">
                                                <label class="control-label" style="width: auto">
                                                    <?php echo $this->lang->line('msg_messageDetailTo').' '.$this->lang->line('courses'); ?>:</label>
                                                <div class="controls controls-to">
                                                   <!-- <select class="allUsers form-control" required>
                                                    </select>-->
                                                    <input type="text" class="form-control to_course_select2"  />
                                                </div>
                                            </div>
                                            <div class="inbox-form-group div_theme_hover_border mail-to to_show" style="display: none">
                                                <label class="control-label">
                                                    <?php echo $this->lang->line('msg_messageDetailTo') ?>:</label>
                                                <div class="controls controls-to">
                                                   <!-- <select class="allUsers form-control" required>
                                                    </select>-->
                                                    <div id="multiple-datasets">
                                                        <input class="typeahead" type="text" placeholder="<?php echo $this->lang->line('choose_user'); ?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="inbox-form-group">
                                                <label class="control-label">
                                                    <?php echo $this->lang->line('msg_messageSubject') ?>:</label>
                                                <div class="controls">
                                                    <input type="text" class="form-control subject" required name="subject">
                                                </div>
                                            </div>
                                            <div class="inbox-form-group">
                                                <label class="control-label">
                                                    <?php echo $this->lang->line('message') ?>:</label>
                                                <div class="control">
                                                    <textarea autocomplete="off" required class="inbox-editor inbox-wysihtml5 form-control message wysihtml5" name="message" rows="12"></textarea>
                                                </div>
                                            </div>
                                            <!-- The template to display files available for download -->
                                            <div class="inbox-compose-btn">
                                                <button class="btn btn-primary btn-circle" type="submit"><i class="fa fa-check"></i>
                                                    <?php echo $this->lang->line('msg_messageSend') ?>
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END PAGE CONTENT -->
        </div>
        <!-- END PAGE CONTAINER -->
        <div id="DeleteMessageModal" class="modal fade" role="dialog">
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