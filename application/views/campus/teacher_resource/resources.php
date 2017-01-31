<!-- BEGIN PAGE CONTAINER -->
<div class="page-container">

    <!-- BEGIN PAGE CONTENT -->
    <div class="table_loading"></div>
    <div class="page-content">
        <div class="<?php echo $layoutClass ?>">
            <ul class=" page-breadcrumb breadcrumb">
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
                    <div class="portlet-body col-sm-8 col-md-9  ">
                        <div class="tabbable-line">
                            <div class="text-right">
                                <a href="http://blog.akaud.com" target="_blank" type="button" class="btn btn-xs quick_tip green-meadow "> <i class="fa fa-lightbulb-o" aria-hidden="true"></i> <span class="button_text"><?php echo $this->lang->line('quick_tip');?></span> </a>
                            </div>
                            <div class="tab-content">
                                <div class="row">
                                    <div class="visible-xs drop_files_section drop_files_section_xs margin-bottom-20">
                                        <div>
                                            <div class="upload_resource_section">
                                                <h4 class="sbold"><strong><?php echo $this->lang->line('teacher_resource_upload_resources');?></strong></h4>
                                                <p><?php echo $this->lang->line('teacher_resource_upload_all_desc');?></p>
                                                <div class="dropdown">
                                                    <button type="button" class="btn btn-sm btn-primary btn-circle dropdown-toggle"
                                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <i class="fa fa-plus"></i> <?php echo $this->lang->line('teacher_resource_add_resources');?>
                                                    </button>
                                                    <ul class="dropdown-menu dropdown-menu-right">
                                                        <li><a href="#"  data-resource_type="3" title="<?php echo $this->lang->line('teacher_resource_file');?>" class="add_resource_type"><i class="fa fa-file-text-o"></i> <?php echo $this->lang->line('teacher_resource_file');?></a></li>
                                                        <li><a href="#" data-resource_type="4" title="<?php echo $this->lang->line('teacher_resource_picture');?>" class="add_resource_type"><i class="fa fa-file-image-o"></i> <?php echo $this->lang->line('teacher_resource_picture');?></a></li>
                                                        <li><a href="#"  data-resource_type="1" title="<?php echo $this->lang->line('teacher_resource_video');?>" class="add_resource_type"><i class="fa fa-file-video-o"></i> <?php echo $this->lang->line('teacher_resource_video');?></a></li>
                                                        <li><a href="#"  data-resource_type="2" title="<?php echo $this->lang->line('teacher_resource_audio');?>" class="add_resource_type"><i class="fa fa-file-audio-o"></i> <?php echo $this->lang->line('teacher_resource_audio');?></a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-12">
                                        <ul class="nav nav-tabs ">
                                            <li class="active">
                                                <a href="<?php echo base_url();?>campus/teacher-resource/resources"> <?php echo $this->lang->line('resources'); ?> </a>
                                            </li>
                                            <li class="">
                                                <a href="<?php echo base_url();?>campus/teacher-resource/templates"> <?php echo $this->lang->line('templates'); ?></a>
                                            </li>
                                            <li class="">
                                                <a href="<?php echo base_url();?>campus/teacher-resource/groups" id="documentsTab"> <?php echo $this->lang->line('groups') ?> </a>
                                            </li>
                                        </ul>
                                        <div class="no_search_resource" style="display: none;"></div>
                                        <?php if(!empty($resources)){?>
                                        <input class="pull-right form-control dt_search" type="search" id="search_resource" placeholder="<?php echo $this->lang->line('teacher_resource_search');?>"/>
                                        <?php }?>
                                        <table id="resources" class="table dbtable_hover_theme" cellspacing="0" width="100%">
                                            <thead>
<!--                                            <tr>-->
<!--                                                <td width="80">--><?php //echo $this->lang->line('teacher_resource_type');?><!--</td>-->
<!--                                                <td>--><?php //echo $this->lang->line('teacher_resource_title_document');?><!--</td>-->
<!--<!--                                            <td>--><?php ////echo $this->lang->line('teacher_resource_visibility');?><!--<!--</td>-->
<!--                                                <td width="120">--><?php //echo $this->lang->line('teacher_resource_action');?><!--</td>-->
<!--                                            </tr>-->
                                            </thead>
                                            <tbody>
                                            <?php if(!empty($resources)){?>
                                            <?php foreach($resources as $k=>$resource){
                                                    $resource_type = '';
                                                    $resource_type_class = '';
                                                    switch($resource->type){

                                                        case 'Picture':
                                                            $resource_type = '<i class="fa fa-file-image-o fa-2x"></i>';
                                                            $resource_type_class = 'fancybox';
                                                            break;

                                                        case 'File':
                                                            $resource_type = '<i class="fa fa-file-text-o"></i>';
                                                            $resource_type_class = '';
                                                            break;

                                                        case 'Video':
                                                            $resource_type = '<i class="fa fa-file-video-o"></i>';
                                                            $resource_type_class = '';
                                                            break;

                                                        case 'Audio':
                                                            $resource_type = '<i class="fa fa-file-audio-o"></i>';
                                                            $resource_type_class = 'iframe';
                                                            break;
                                                        default:
                                                            $resource_type = '<i class="fa fa-file-text-o"></i>';
                                                            $resource_type_class = 'fancybox';

                                                    }


                                                    ?>
                                                    <tr>
                                                        <td><?php echo $resource_type;?>

                                                        </td>
                                                        <td>

                                                            <a href="<?php echo $resource->link;?>"   title="<?php echo $resource->title;?>" class="<?php echo $resource_type_class;?> resource_title"><?php echo $resource->title;?></a>
<!--                                                            <a class="fancybox" data-type="swf" href="pathToPlayer/jwplayer.swf?file=--><?php //echo $resource->link;?><!--&autostart=true" title="local video mp4">open local video</a>-->


                                                        </td>
<!--                                                        <td>-->
<!--                                                            --><?php //if($resource->available == 1){?>
<!--                                                                <a href="javascript:;" class="btn btn-outline btn-circle red btn-sm blue resource_available" data-available="--><?php //echo $resource->available; ?><!--"><i class="fa fa-share"></i>--><?php //echo $this->lang->line('teacher_resource_share');?><!--</a>-->
<!--                                                            --><?php //}else { ?>
<!--                                                                <a href="javascript:;" class="btn btn-outline btn-circle resource_available" data-available="--><?php //echo $resource->available; ?><!--">--><?php //echo $this->lang->line('teacher_resource_invisible');?><!--</a>-->
<!--                                                            --><?php //}?>
<!--                                                        </td>-->
                                                        <td>
                                                            <div class="btn-group dropdown pull-left circle_dropdown_div">
                                                                <button type="button" class="btn btn-xs btn-default dropdown-toggle"
                                                                        data-toggle="dropdown" aria-expanded="false">
                                                                    <?php echo $this->lang->line('teacher_resource_t_actions');?> <span class="caret"></span>
                                                                </button>
                                                                <ul class="dropdown-menu dropdown-menu-right" id="ul_<?php echo $resource->id; ?>" data-resource_id="<?php echo $resource->id; ?>">
                                                                    <li><a href="#" data-toggle="tooltip" title="" class="edit_resource_item"><i class="fa fa-edit"></i> <?php echo $this->lang->line('teacher_resource_edit_resource');?></a></li>
                                                                    <li><a href="#" data-toggle="tooltip" title="" class="delete_resource_item" data-confirm="<?php echo $this->lang->line('are_you_sure_delete');?>"><i class="fa fa-trash-o"></i> <?php echo $this->lang->line('teacher_resource_delete_resource');?></a></li>
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

                        </div>
                    </div>
                    <div class="hidden-xs col-sm-4  col-md-3 drop_files_section">
                        <div>
                            <div class="upload_resource_section">
                                <h4 class="sbold"><strong><?php echo $this->lang->line('teacher_resource_upload_resources');?></strong></h4>
                                <p><?php echo $this->lang->line('teacher_resource_upload_all_desc');?></p>
                                <div class="dropdown">
                                    <button type="button" class="btn btn-sm btn-primary btn-circle dropdown-toggle"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fa fa-plus"></i> <?php echo $this->lang->line('teacher_resource_add_resources');?>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-right">
                                        <li><a href="#"  data-resource_type="3" title="<?php echo $this->lang->line('teacher_resource_file');?>" class="add_resource_type"><i class="fa fa-file-text-o"></i> <?php echo $this->lang->line('teacher_resource_file');?></a></li>
                                        <li><a href="#" data-resource_type="4" title="<?php echo $this->lang->line('teacher_resource_picture');?>" class="add_resource_type"><i class="fa fa-file-image-o"></i> <?php echo $this->lang->line('teacher_resource_picture');?></a></li>
                                        <li><a href="#"  data-resource_type="1" title="<?php echo $this->lang->line('teacher_resource_video');?>" class="add_resource_type"><i class="fa fa-file-video-o"></i> <?php echo $this->lang->line('teacher_resource_video');?></a></li>
                                        <li><a href="#"  data-resource_type="2" title="<?php echo $this->lang->line('teacher_resource_audio');?>" class="add_resource_type"><i class="fa fa-file-audio-o"></i> <?php echo $this->lang->line('teacher_resource_audio');?></a></li>
                                    </ul>
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