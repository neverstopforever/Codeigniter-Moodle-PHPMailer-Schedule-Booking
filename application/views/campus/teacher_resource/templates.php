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

                    <div class="portlet-body col-sm-8 col-md-9">
                        <div class="tabbable-line">
                        <div class="text-right">
                            <a href="http://blog.akaud.com" target="_blank" type="button" class="btn btn-xs quick_tip green-meadow "> <i class="fa fa-lightbulb-o" aria-hidden="true"></i> <span class="button_text"><?php echo $this->lang->line('quick_tip');?></span> </a>
                        </div>
                        <div class="visible-xs  drop_files_section drop_files_section_xs">
                            <div>
                                <div class="creat_tamplate_section text-center">
                                    <h4> <strong><?php echo $this->lang->line('teacher_resource_cy_template');?></strong> </h4>
                                    <p><?php echo $this->lang->line('teacher_resource_t_upload_all_desc1');?> <br><?php echo $this->lang->line('teacher_resource_t_upload_all_desc2');?></p>
                                    <div class="form-group text-center">
                                        <input type="text" id="template_title_1" name="template_title_1" class="form-control template_title" data-required="1"  placeholder="<?php echo $this->lang->line('teacher_resource_t_template_name');?>">
                                        <button class="btn btn-primary btn-circle add_template" type="button"><?php echo $this->lang->line('teacher_resource_t_create_template');?></button>
                                    </div>
                                </div>
                            </div>
                        </div>


                            <ul class="nav nav-tabs ">
                                <li class="">
                                    <a href="<?php echo base_url();?>campus/teacher-resource/resources"> <?php echo $this->lang->line('resources'); ?> </a>
                                </li>
                                <li class="active">
                                    <a href="<?php echo base_url();?>campus/teacher-resource/templates"> <?php echo $this->lang->line('templates'); ?></a>
                                </li>
                                <li class="">
                                    <a href="<?php echo base_url();?>campus/teacher-resource/groups" id="documentsTab"> <?php echo $this->lang->line('groups') ?> </a>
                                </li>
                            </ul>
                            <div class="no_templates" style="display: none;"></div>
                            <div class="" id="manage_template">


                                <div class="clearfix"></div>

                                <table id="templates" class="table dbtable_hover_theme dataTable" cellspacing="0" width="100%">
                                    <?php if(!empty($templates)){?>
                                    <thead>
                                    <tr>
                                        <td><?php echo $this->lang->line('teacher_resource_t_title');?></td>
                                        <td width="80"><?php echo $this->lang->line('teacher_resource_action');?></td>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    <?php foreach($templates as $k=>$template){?>
                                            <tr>
                                                <td class="manage_template_title"><?php echo $template->title;?></td>
                                                <td width="80">
                                                    <div class="btn-group pull-right dropdown circle_dropdown_div" >
                                                        <button type="button" class="btn btn-default btn-xs   dropdown-toggle"
                                                                data-toggle="dropdown" aria-expanded="false"><?php echo $this->lang->line('teacher_resource_t_actions');?> <span class="caret"></span>
                                                        </button>
                                                        <ul class="dropdown-menu dropdown-menu-right" id="ul_<?php echo $template->id; ?>" data-template_id="<?php echo $template->id; ?>" data-teacher_id="<?php echo $template->teacher_id;?>">
                                                            <li><a href="#" data-toggle="tooltip" class="t_edit edit_template_item"><i class="fa fa-edit"></i> <?php echo $this->lang->line('teacher_resource_t_edit_template');?></a></li>
                                                            <li><a href="#" data-toggle="tooltip" class="t_manage manage_template_item"><i class="fa fa-file-text-o"></i> <?php echo $this->lang->line('teacher_resource_t_manage_resource');?></a></li>
                                                            <li><a href="#" data-toggle="tooltip" class="delete_template_item" data-confirm="<?php echo $this->lang->line('are_you_sure_delete');?>"><i class="fa fa-trash-o"></i> <?php echo $this->lang->line('teacher_resource_t_delete_template');?></a></li>
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
                            <div id="manage_resource" class="" style="display:none">

                            </div>
                        </div>
                    </div>
                    <div class="hidden-xs col-sm-4  col-md-3 drop_files_section">
                                        <div>
                                            <div class="creat_tamplate_section">
                                                <h4> <strong><?php echo $this->lang->line('teacher_resource_cy_template');?></strong> </h4>
                                                <p><?php echo $this->lang->line('teacher_resource_t_upload_all_desc1');?> <br><?php echo $this->lang->line('teacher_resource_t_upload_all_desc2');?></p>
                                                <div class="form-group">
                                                    <input type="text" id="template_title_2" name="template_title_2" class="form-control template_title" data-required="1"  placeholder="<?php echo $this->lang->line('teacher_resource_t_template_name');?>">
                                                    <button class="btn btn-primary btn-circle add_template" type="button"><?php echo $this->lang->line('teacher_resource_t_create_template');?></button>
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
<script>
    var _teacher_id = <?php echo $teacher_id; ?>;
</script>