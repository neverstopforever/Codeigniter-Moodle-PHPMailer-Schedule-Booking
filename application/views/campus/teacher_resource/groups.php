<!-- BEGIN PAGE CONTAINER -->
<div class="page-container">

    <!-- BEGIN PAGE CONTENT -->
    <div class="table_loading"></div>
    <div class="page-content">
        <div class="<?php echo $layoutClass ?>">
            <ul class="page-breadcrumb breadcrumb">
                <li>
                    <a href="<?php echo $_base_url; ?>" ><?php echo $this->lang->line('menu_Home'); ?></a>
                </li>
                <li>
                    <a href="javascript:;"><?php echo $this->lang->line('manage_resources'); ?></a>
                </li>
                <li class="active">
                    <?php echo $this->lang->line('resources'); ?>
                </li>
            </ul>
            <!-- BEGIN PAGE CONTENT INNER -->
            <div class="portlet light row resources_content">

                <div class="portlet box sections green" >
                    <div class="portlet-body  col-sm-8 col-md-9">

                        <div class="tabbable-line">
                            <div class="text-right">
                                <a href="http://blog.akaud.com" target="_blank" type="button" class="btn btn-xs quick_tip green-meadow "> <i class="fa fa-lightbulb-o" aria-hidden="true"></i> <span class="button_text"><?php echo $this->lang->line('quick_tip');?></span> </a>
                            </div>
                            <div class="tab-content">
                                <div class="row">
                                    <div class=" visible-xs col-sm-4  col-md-3 manage_groups_section manage_groups_section_xs">
                                        <div>
                                            <div class="manage_groups text-center">
                                                <h4><?php echo $this->lang->line('teacher_resource_g_manage_groups'); ?></h4>
                                                <p><?php echo $this->lang->line('teacher_resource_g_all_desc'); ?></p>
                                                <div class="overf_hidden">
                                                    <div class="col-xs-6 text-left course_div" >
                                                        <div class="form-group circle_select_div">
                                                            <label><?php echo $this->lang->line('teacher_resource_g_course');?>:
                                                                <select required id="CourseId1" name="idactividad1"
                                                                        class="form-control"/>
                                                                <option value="">--<?php echo $this->lang->line('teacher_resource_g_everyone');?>--</option>
                                                                <?php foreach ($courses as $list): ?>
                                                                    <option
                                                                        value="<?php echo $list->idactividad; ?>"><?php echo $list->actividad; ?></option>
                                                                <?php endforeach; ?>
                                                                </select>
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-xs-6 text-left group_div" >
                                                    <div class="form-group circle_select_div">
                                                        <label><?php echo $this->lang->line('teacher_resource_g_group'); ?>:
                                                            <select required id="GroupId1" name="Idgrupo1"
                                                                    class="form-control filter_events"/>
                                                            <option value="">--<?php echo $this->lang->line('teacher_resource_g_everyone'); ?>--</option>
                                                            </select>
                                                        </label>
                                                    </div>
                                                </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="col-md-4" style="padding-left:0;">
                                                        <input type="text" id="group_title1" class="form-control" required
                                                               data-required="1" name="title1" placeholder="<?php echo $this->lang->line('teacher_resource_g_group_name'); ?>">
                                                    </div>
                                                    <button class="btn btn-primary add_group btn-circle" type="button" data-xs_top="1"><?php echo $this->lang->line('teacher_resource_g_create_group'); ?></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <div>
                                    <ul class="nav nav-tabs ">
                                        <li>
                                            <a href="<?php echo base_url();?>campus/teacher-resource/resources"> <?php echo $this->lang->line('resources'); ?> </a>
                                        </li>
                                        <li>
                                            <a href="<?php echo base_url();?>campus/teacher-resource/templates"> <?php echo $this->lang->line('templates'); ?></a>
                                        </li>
                                        <li class="active">
                                            <a href="<?php echo base_url();?>campus/teacher-resource/groups" id="documentsTab"> <?php echo $this->lang->line('groups') ?> </a>
                                        </li>
                                    </ul>
                                </div>
                                    <div class="no_group" style="display: none;"></div>

                                        <div id="manage_group" class="">
                                            <?php if(!empty($groups)){?>
                                            <div class="for_group_search">
                                                <input class="pull-right form-control" type="search" id="search_group" placeholder="<?php echo $this->lang->line('teacher_resource_g_search');?>"/>
                                            </div>
                                            <?php } ?>
                                                <div class="clearfix"></div>
                                                <div class="ze_wrapper">
                                                <table id="groups" class="groups table dbtable_hover_theme dataTable">
                                                    <thead>
                                                    <tr>
                                                        <td><?php echo $this->lang->line('teacher_resource_g_group'); ?></td>
                                                        <td><?php echo $this->lang->line('teacher_resource_g_group_title'); ?></td>
                                                        <td width="80"><?php echo $this->lang->line('teacher_resource_g_action'); ?></td>
                                                    </tr>
                                                    </thead>
                                                    <tbody id="table_body_groups">
                                                    <?php if(!empty($groups)){?>
                                                        <?php foreach($groups as $k=>$group){ ?>
                                                            <tr>
                                                                <td class="manage_group_title"><?php echo $group->grupo;?></td>
                                                                <td class="manage_course_title"><?php echo $group->title;?></td>
                                                                <td width="80">
                                                                    <div class="btn-group dropdown pull-right circle_dropdown_div" >
                                                                        <button type="button" class="btn btn-default btn-xs  dropdown-toggle"
                                                                                data-toggle="dropdown"
                                                                                aria-haspopup="true"
                                                                                aria-expanded="false"><?php echo $this->lang->line('teacher_resource_g_actions'); ?> <span class="caret"></span>
                                                                        </button>
                                                                        <ul class="dropdown-menu dropdown-menu-right" id="ul_<?php echo $group->id; ?>" data-sr_group_id="<?php echo $group->id; ?>" data-group_id="<?php echo $group->group_id; ?>">
                                                                            <li><a href="#" class="g_edit" data-toggle="tooltip"><i class="fa fa-edit"></i> <?php echo $this->lang->line('teacher_resource_g_edit_group'); ?></a></li>
                                                                            <li><a href="#" class="g_manage" data-toggle="tooltip"><i class="fa fa-file-text-o"></i> <?php echo $this->lang->line('teacher_resource_g_manage_resource'); ?></a></li>
                                                                            <li><a href="#" class="g_post" data-toggle="tooltip"><i class="fa fa-file-text-o"></i> <?php echo $this->lang->line('teacher_resource_g_pmt_group'); ?></a></li>
                                                                            <li><a href="#" data-toggle="tooltip" class="g_delete" data-confirm="<?php echo $this->lang->line('are_you_sure_delete');?>"><i class="fa fa-trash-o"></i> <?php echo $this->lang->line('teacher_resource_g_delete_group');?></a></li>
                                                                        </ul>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        <?php }
                                                    }else{?>
                                                        
                                                    <?php }?>

                                                    </tbody>
                                                </table>
                                                    </div>
                                            </div>
                                        </div>
                                        <div id="manage_resource" class="" style="display:none">

                                        </div>
                                    <div class="col-xs-3">
<!--                                        <p class="text-danger free_res_text"><strong>--><?php //echo sprintf($this->lang->line('teacher_resource_free_resource'), 12); ?><!-- </strong></p>-->
                                    </div>
                                </div>

                            </div>

                        </div>

                    <div class=" hidden-xs col-sm-4  col-md-3 manage_groups_section">
                        <div>
                        <div class="manage_groups">
                        <h4><?php echo $this->lang->line('teacher_resource_g_manage_groups'); ?></h4>
                        <p><?php echo $this->lang->line('teacher_resource_g_all_desc'); ?></p>

                        <div class="col-md-6" style="padding-left:0;">
                            <div class="form-group circle_select_div">
                                <label><?php echo $this->lang->line('teacher_resource_g_course');?>:
                                    <select required id="CourseId" name="idactividad"
                                            class="form-control"/>
                                    <option value="">--<?php echo $this->lang->line('teacher_resource_g_everyone');?>--</option>
                                    <?php foreach ($courses as $list): ?>
                                        <option
                                            value="<?php echo $list->idactividad; ?>"><?php echo $list->actividad; ?></option>
                                    <?php endforeach; ?>
                                    </select>
                                </label>
                            </div>
                        </div>
                        <div class="col-md-6" style="padding-left:0;">
                            <div class="form-group circle_select_div">
                                <label><?php echo $this->lang->line('teacher_resource_g_group'); ?>:
                                    <select required id="GroupId" name="Idgrupo"
                                            class="form-control filter_events"/>
                                    <option value="">--<?php echo $this->lang->line('teacher_resource_g_everyone'); ?>--</option>
                                    </select>
                                </label>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="" style="padding-left:0;">
                                <input type="text" id="group_title" class="form-control" required
                                       data-required="1" name="title" placeholder="<?php echo $this->lang->line('teacher_resource_g_group_name'); ?>">
                            </div>
                            <button class="btn btn-primary add_group btn-circle" type="button" data-xs_top="0"><?php echo $this->lang->line('teacher_resource_g_create_group'); ?></button>
                        </div>
                    </div>
                    </div>
                    </div>
                   <div class="clearfix"></div>

                </div>
                <!-- END PAGE CONTENT INNER -->
            </div>
            <!-- BEGIN QUICK SIDEBAR -->
            <!-- END QUICK SIDEBAR -->
        </div>
        <!-- END PAGE CONTENT -->
    </div>
</div>

    <div id="post_panel" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                    <h4 class="modal-title"><?php echo $this->lang->line('post_comments'); ?></h4>
                </div>
                <div class="modal-body">
                    <p id="post_group_title" style="margin-top:0;"></p>
                    <textarea class="form-control c-square" placeholder="<?php echo $this->lang->line('comments'); ?>" id="comment" name="comment"
                              rows="2"></textarea>
                    <div style="padding:15px 0;">
                        <button type="button" class="btn green post_comment"><?php echo $this->lang->line('post_comment'); ?></button>
                    </div>
                    <div class="clearfix"></div>
                    <div class="c-comment-list">

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->lang->line('close');?></button>
                </div>
            </div>
        </div>
    </div>

    <div id="plan_group" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                    <h4 class="modal-title"><?php echo $this->lang->line('planning');?></h4>
                </div>
                <div class="modal-body">
                    <h3 id="plan_select_group_title" style="margin-top:0;"></h3>
                    <h4 id="plan_select_course_title" style="margin-top:0;"></h4>
                    <div class="col-md-6" style="padding-left:0;">
                        <div class="form-group">
                            <label><?php echo $this->lang->line('teacher_resource_g_start_date');?> :
                                <input type="text" id="group_start_date" class="form-control datepicker"
                                       data-required="1" name="start_date" placeholder="<?php echo $this->lang->line('teacher_resource_g_start_date');?>">
                            </label>
                        </div>
                    </div>
                    <div class="col-md-6" style="padding-left:0;">
                        <div class="form-group">
                            <label><?php echo $this->lang->line('teacher_resource_g_end_date');?> :
                                <input type="text" id="group_end_date" class="form-control datepicker" data-required="1"
                                       name="end_date" placeholder="<?php echo $this->lang->line('teacher_resource_g_end_date');?> ">
                            </label>
                        </div>
                    </div>
                    <textarea class="form-control c-square" placeholder="<?php echo $this->lang->line('teacher_resource_g_comment');?>" id="plan_comment" name="plan_comment"
                              rows="2"></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary save_plan"><?php echo $this->lang->line('save');?></button>
                </div>
            </div>
        </div>
    </div>

<div id="group_list_resource_panel" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                <h4 class="modal-title"><?php echo $this->lang->line('teacher_resource_t_select_resource'); ?></h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <table class="main_resources table" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <td></td>
                            <td><?php echo $this->lang->line('teacher_resource_t_title'); ?></td>
                        </tr>
                        </thead>
                        <tbody id="main_table_body_resource">
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary resource_group_save" data-group_id="" data-resource_group_id=""><?php echo $this->lang->line('_done'); ?></button>
            </div>
        </div>
    </div>
</div>

<div id="list_template_panel" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                <h4 class="modal-title"><?php echo $this->lang->line('teacher_resource_g_select_template');?></h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <p><?php echo $this->lang->line('teacher_resource_g_import_all_desc');?></p>
                    <table class="list_template table">
                        <thead>
                        <tr>
                            <td></td>
                            <td><?php echo $this->lang->line('teacher_resource_g_title');?></td>
                        </tr>
                        </thead>
                        <tbody id="list_templates_table_body_resource">

                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary save_import_template" data-group_id="" data-resource_group_id=""><?php echo $this->lang->line('_done'); ?></button>
            </div>
        </div>
    </div>
</div>

<script>
    var _teacher_id = "<?php echo $teacher_id; ?>";
    var _groups = <?php echo json_encode($_groups); ?>;
</script>