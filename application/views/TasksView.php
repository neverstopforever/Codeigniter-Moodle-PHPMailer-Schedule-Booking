        <!-- BEGIN PAGE CONTAINER -->
        <div class="page-container">
            <!-- BEGIN PAGE HEAD -->

            <!-- END PAGE HEAD -->

            <!-- BEGIN PAGE CONTENT -->
            <div class="table_loading"></div>
            <div class="page-content">
                <div class="<?php echo $layoutClass ?>">
                    <ul class="page-breadcrumb breadcrumb">
                        <li>
                            <a href="<?php echo $_base_url; ?>" ><?= $this->lang->line('menu_Home') ?></a>
                        </li>
                        <li class="active">
                            <?php echo $this->lang->line('menu_tasks'); ?>
                        </li>
                    </ul>
                    <!-- BEGIN PAGE CONTENT INNER -->
<!--                    <div class="portlet light">-->
                    <div class="row">
                        <div class="col-md-3 visible-xs visible-sm">
                            <div class="tags_cont_min">
                                <div class="portlet light ">
                                    <div class="portlet-title">
                                        <div class="caption">
                                            <span class="caption-subject bold uppercase"><?php echo $this->lang->line('tasks_tags'); ?></span>
                                        </div>
                                    </div>

                                    <div class="tagTemp">
                                        <div class="label label-default filter_by_tag"></div>
                                    </div>
                                    <div class="tags">
                                    </div>
                                    <div class="pull-right margin-top-20 add_tags_button">
                                        <button class="btn pull-right btn-primary btn-circle" data-toggle="modal" data-target="#addTags">
                                            <i class="fa fa-plus"></i>
                                            <?php echo $this->lang->line('buttons_addTags'); ?>
                                        </button>
                                    </div>
                                </div></div>
                        </div>
                        <div class="col-md-9 ">
                            <div class="tasks_main_content">
                                

                                <div class="portlet light ">
                                    <div class="text-right">
                                        <button type="button" id="quick_tips" class="btn btn-xs green-meadow "> <i class="fa fa-lightbulb-o" aria-hidden="true"></i> <span class="button_text"><?php echo $this->lang->line('show_quick_tips'); ?></span> <i class="fa fa-angle-down fa-angledown"></i></button>
                                    </div>
                                    <div class="quick_tips_sidebar margin-top-20 margin-bottom-20">
                                        <div class=" note note-info text-left quick_tips_content">
                                            <h2><?php echo $this->lang->line('quick_box_title'); ?></h2>
                                            <p><?php echo $this->lang->line('tasks_quick_tips_text'); ?>
                                                <strong><a href="<?php echo $this->lang->line('tasks_quick_tips_link'); ?>" target="_blank"><?php echo $this->lang->line('tasks_quick_tips_link_text'); ?></a></strong>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="portlet-title">
                                        <div class="caption">
                                            <span class="caption-subject  bold uppercase"><?php echo $this->lang->line('tasks_smallTitle'); ?></span>
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                    <div class="todo-ui col-xs-12 col-sm-4">

                                        <div class="todo-content">
                                            <div class="">

                                                <div class="portlet-body">
                                                    <div class="row">
                                                        <div class="col-md-12 col-sm-12">
                                                            <div class="no_tasks" style="display:none;">
                                                                <h3 class=""><?php echo $this->lang->line('tasks_noTasksFound'); ?></h3>
                                                            </div>
                                                            <div class="todo-tasklist">
                                                                <div class="task_temp" style="display:none;">
                                                                    <div class="todo-tasklist-item todo-tasklist-item-border">
                                                                        <img class="todo-userpic pull-left" src="" width="27px" height="27px">
                                                                        <div class="todo-tasklist-item-title"> </div>
                                                                        <div class="todo-tasklist-item-text"> </div>
                                                                        <div class="todo-tasklist-controls pull-left">
                                                                            <span class="todo-tasklist-date">
                                                                            <i class="fa fa-calendar"></i> <span class="date"></span> </span>
                                                                            <span class="todo-tasklist-badge badge badge-roundless"></span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="todo-tasklist_real"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- END TODO CONTENT -->
                                    </div>
                                    <div class="calendar-ui  col-xs-12 col-sm-8">
                                        <div class="pull-right">
                                        </div>
                                        <div id="calendar" class="portlet light portlet-fit  calendar fc fc-ltr fc-unthemed">
                                            
                                        </div>
                                        <div class="pull-right margin-top-20 add_task_button">
                                            <button class="btn pull-right btn-primary btn-circle add_Task">
                                                <i class="fa fa-plus"></i>
                                                <?php echo $this->lang->line('buttons_addTasks'); ?>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3  hidden-xs hidden-sm">
                            <div class="tags_cont">
                                <div class="portlet light ">
                                    <div class="portlet-title">
                                        <div class="caption">
                                            <span class="caption-subject bold uppercase"><?php echo $this->lang->line('tasks_tags'); ?></span>
                                        </div>
                                    </div>

                                    <div class="tagTemp">                                        
                                         <div class="label label-default"></div>
                                    </div>
                                    <div class="tags">
                                    </div>
                                    <div class="pull-right margin-top-20">
                                        <button class="btn pull-right btn-primary btn-circle" data-toggle="modal" data-target="#addTags">
                                            <i class="fa fa-plus"></i>
                                            <?php echo $this->lang->line('buttons_addTags'); ?>
                                        </button>
                                    </div>
                            </div></div>
                        </div>
                    </div>
<!--                </div>-->
            </div>
            <!-- END PAGE CONTENT INNER -->
        </div>
        <!-- BEGIN QUICK SIDEBAR -->
        <!-- END QUICK SIDEBAR -->
        </div>
        <!-- END PAGE CONTENT -->
        </div>
        <!-- Modal -->
        <form class="addtagform">
            <div class="modal fade" id="addTags" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="myModalLabel"><?php echo $this->lang->line('Tasks_addTagTitle') ?></h4>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label class=" control-label">
                                    <?php echo $this->lang->line('Tasks_inputTagName') ?>
                                </label>
                                <div class="">
                                    <input type="text" class="form-control tagName">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label">
                                    <?php echo $this->lang->line('Tasks_inputTagColor') ?>
                                </label>
                                <div class="">
                                    <input type="text" id="hue" class="form-control tagColor" data-control="hue" value="#ff6161">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">
                                <?php echo $this->lang->line("button_modalClose") ?>
                            </button>
                            <button type="submit" class="btn btn-primary addtag">
                                <?php echo $this->lang->line('button_saveTag') ?>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>



        <div class="modal fade" id="task_detail" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel"><?php echo $this->lang->line('tasks_edittask') ?></h4>
                    </div>
                    <div class="modal-body">
                        <div class="task_detail" >
                            <h3 class="task_title"></h3>
                            <div class="todo-tasklist-controls">
                              <div class="col-md-3 no-padding" style="display: none">
                                  <div class="input-icon">
                                      <i class="fa fa-calendar"></i>
                                      <input type="text" name="task_date"  class="form-control todo-taskbody-due task_end" placeholder="<?php echo $this->lang->line('tasks_addTaskDueDatePlaceholder'); ?>">
                                  </div>
                              </div>
                                <span class="todo-tasklist-date" style="display: none">
                                 <i class="fa fa-calendar"></i>
                                   <span class="date" ></span>
                                </span>
                                <input type="checkbox" name="activity" class="task_activity" />
                                <div class="col-md-3" style="display: none">
                                    <select class="form-control task_is_public" name="task_is_public">
                                        <option value="0">
                                            <?php echo $this->lang->line('tasks_addTaskPrivateLabel'); ?>
                                        </option>
                                        <option value="1">
                                            <?php echo $this->lang->line('tasks_addTaskPublicLabel'); ?>
                                        </option>
                                    </select>
                                 </div>

                                <span class="todo-tasklist-badge badge badge-roundless margin-left-10"></span>
                            </div>
                        <p class="tasks_detail"></p>
                        <div class="tasks_comments">
                            <div class="tabbable-line">
                                <ul class="nav nav-tabs ">
                                    <li class="active">
                                        <a href="#tab_1" data-toggle="tab"><?php echo $this->lang->line('tasks_commentsTitle'); ?></a>
                                    </li>
                                </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab_1">
                            <!-- TASK COMMENTS -->
                            <div class="form-group">
<!--                                <button type="button" class="pull-right save_comment bottom_sc btn btn-sm btn-circle green-haze">-->
<!--                                    --><?php //echo $this->lang->line('button_addComment'); ?>
<!--                                </button>-->
                                <div class="col-md-12">
                                    <div class="commentTemp" style="display:none;">
                                        <li class="media">
                                            <a class="pull-left" href="javascript:;">
                                                <img class="todo-userpic" src="<?php echo base_url() ?>assets/admin/layout/img/avatar8.jpg" width="27px" height="27px">
                                            </a>
                                            <div class="media-body todo-comment">
                                                <!-- <button type="button" class="todo-comment-btn btn btn-circle btn-default btn-xs">&nbsp; Reply &nbsp;</button> -->
                                                <p class="todo-comment-head">
                                                    <span class="todo-comment-username"></span> &nbsp; <span class="todo-comment-date">17 Sep 2014 at 2:05pm</span>
                                                </p>
                                                <p class="todo-text-color">
                                                </p>
                                                <!-- Nested media object -->
                                                <div class="child"></div>
                                            </div>
                                        </li>
                                    </div>
                                    <ul class="media-list comment_list">
                                    </ul>
                                </div>
                            </div>
                            <!-- END TASK COMMENTS -->
                            <div class="table_loading"></div>
                            <!-- TASK COMMENT FORM -->
                            <div class="form-group">
                                <div class="col-md-12">
                                    <ul class="media-list">
                                        <li class="media">
                                            <div class="media-body">
                                                <textarea class="form-control comment_text todo-taskbody-taskdesc" rows="4" placeholder="<?php echo $this->lang->line('tasks_commentsInputPlaceholder'); ?>"></textarea>
                                            </div>
                                        </li>
                                    </ul>
                                    <button type="button" class=" pull-left delete_task btn  btn-danger btn-circle margin-top-10" data-toggle="confirmation" data-placement="right">
                                        <i class="fa fa-trash-o" aria-hidden="true"></i>
                                        <?php echo $this->lang->line('button_delete_task'); ?>
                                    </button>
                                    <button type="button" class="pull-right save_comment btn btn-primary btn-circle margin-top-10">
                                        <i class="fa fa-plus"></i>
                                        <?php echo $this->lang->line('button_addComment'); ?>
                                    </button>
                                </div>
                            </div>
                            <!-- END TASK COMMENT FORM -->
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
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                        <h4 class="modal-title"> <?php echo $this->lang->line('group_view_event');?> </h4>
                    </div>
                    <div class="modal-body">
                        <div class="event_date"></div>
                        <label><?php echo $this->lang->line('groups_detail');?></label>
                        <div class="event_detail"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->lang->line('close');?></button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="deleteConfirm" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                        <h4 class="modal-title"> <?php echo $this->lang->line("please_confirm"); ?> </h4>
                    </div>
                    <div class="modal-body">
                        <div class="event_date"></div>
                        <p><?php echo $this->lang->line('are_you_sure_delete');?></p>
                        <div class="event_detail"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->lang->line('close');?></button>
                        <button type="button" class="btn btn-danger confirm_ok" data-dismiss="modal"><?php echo $this->lang->line('okay');?></button>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Modal -->
        <div class="modal fade" id="add_task_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel"><?php echo $this->lang->line('tasks_addTaskTitle'); ?></h4>
                    </div>
                    <div class="modal-body">
                        <form action="javascript:;" class="form-horizontal">
                            <!-- TASK HEAD -->
                            <div class="form">
                                <!-- END TASK HEAD -->
                                <!-- TASK TITLE -->
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <input type="text" class="form-control todo-taskbody-tasktitle task_title_input" placeholder="<?php echo $this->lang->line('tasks_addTaskTitlePlaceholder'); ?>">
                                    </div>
                                </div>
                                <!-- TASK DESC -->
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <textarea class="form-control todo-taskbody-taskdesc task_desc" style="resize:none;" rows="8" placeholder="<?php echo $this->lang->line('tasks_addTaskDescriptionPlaceholder'); ?>"></textarea>
                                    </div>
                                </div>
                                <!-- END TASK DESC -->
                                <!-- TASK DUE DATE -->
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <div class="input-icon">
                                            <i class="fa fa-calendar"></i>
                                            <input type="text" class="form-control todo-taskbody-due task_end" placeholder="<?php echo $this->lang->line('tasks_addTaskDueDatePlaceholder'); ?>">
                                        </div>
                                    </div>
                                </div>
                                <!-- TASK TAGS -->
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <select class="form-control todo-taskbody-tags  task_tags">
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <select class="form-control todo-taskbody-public  task_public">
                                            <option value="0">
                                                <?php echo $this->lang->line('tasks_addTaskPrivateLabel'); ?>
                                            </option>
                                            <option value="1">
                                                <?php echo $this->lang->line('tasks_addTaskPublicLabel'); ?>
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">
                            <?php echo $this->lang->line('button_modalClose'); ?>
                        </button>
                        <button type="button" class="btn btn-primary task_save">
                            <?php echo $this->lang->line('button_saveTask'); ?>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <!-- END PAGE CONTAINER -->
<script>
    var _current_user_id = <?php echo $user_id; ?>
</script>