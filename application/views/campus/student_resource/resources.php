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
                    <a href="javascript:;">
                        <?php echo $this->lang->line('resources'); ?>
                    </a>
                </li>
                <li>
                    <a href="<?php echo $_base_url; ?>campus/student-resource/my_courses"><?php echo $this->lang->line('campus_students_my_courses'); ?></a>
                </li>
                <li class="active">
                    <?php echo $this->lang->line('resources'); ?>
                </li>
            </ul>
            <!-- BEGIN PAGE CONTENT INNER -->
            <div class="portlet light resources_content">
                <div class="portlet box sections green" >
                    <div class="portlet-body">
                        <div class="tabbable-line  col-sm-8 col-md-9">
                            <div class="tab-content">
                                <div class="row">
                                    <div class="col-xs-12">
                                        <p><?php echo $this->lang->line('student_resource_course');?>: <?php echo @$course->course_name;?></p>
                                        <p><?php echo $this->lang->line('student_resource_group');?>: <?php echo @$course->group_name;?></p>
                                        <ul class="nav nav-tabs ">
                                            <li class="active">
                                                <a href="<?php echo base_url();?>campus/student-resource/resources"> <?php echo $this->lang->line('resources'); ?> </a>
                                            </li>
                                        </ul>
                                        <div class="margin-top-10">
                                        <input class="pull-right form-control dt_search" type="search" id="search_resource" placeholder="<?php echo $this->lang->line('student_resource_search');?>"/>
                                            <div class="no_search_resource" style="display: none;"></div>
                                            <table id="resources" class="table dbtable_hover_theme" cellspacing="0" width="100%">
                                            <thead>
<!--                                            <tr>-->
<!--                                                <td width="80">--><?php //echo $this->lang->line('student_resource_type');?><!--</td>-->
<!--                                                <td>--><?php //echo $this->lang->line('student_resource_title_document');?><!--</td>-->
<!--                                                <td>--><?php //echo $this->lang->line('student_resource_date_limit');?><!--</td>-->
<!--                                                <td></td>-->
<!--                                            </tr>-->
                                            </thead>
                                            <tbody>
                                            <?php if(!empty($resources)){?>
                                            <?php foreach($resources as $k=>$resource){
                                                    $resource_type = '';
                                                    switch($resource->resource_type){

                                                        case 'Picture':
                                                            $resource_type = '<i class="fa fa-file-image-o fa-2x"></i>';
                                                            break;

                                                        case 'File':
                                                            $resource_type = '<i class="fa fa-file-text-o"></i>';
                                                            break;

                                                        case 'Video':
                                                            $resource_type = '<i class="fa fa-file-video-o"></i>';
                                                            break;

                                                        case 'Audio':
                                                            $resource_type = '<i class="fa fa-file-audio-o"></i>';
                                                            break;
                                                        default:
                                                            $resource_type = '<i class="fa fa-file-text-o"></i>';

                                                    }

                                                    if($this->data['lang'] == "spanish"){
                                                        setlocale(LC_TIME, 'es_ES.utf8');
                                                        $start_date = strftime("%e %B, %G", strtotime($resource->start_date));
                                                        $end_date = strftime("%e %B, %G", strtotime($resource->end_date));
                                                    }else{
                                                        setlocale(LC_TIME, 'en_GB.utf8');
                                                        $start_date = strftime("%B %e, %G", strtotime($resource->start_date));
                                                        $end_date = strftime("%B %e, %G", strtotime($resource->end_date));
                                                    }
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $resource_type;?></td>
                                                        <td><a href="<?php echo $resource->aws_link;?>" target="_blank" title="<?php echo $resource->resource_title;?>" class="resource_title"><?php echo $resource->resource_title;?></a></td>
                                                        <td><?php echo !empty($end_date) ? $end_date : null; ?></td>
                                                        <td><?php echo !empty($start_date) ? $start_date : null; ?></td>

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
                        <div class="tabbable-line  col-sm-4 col-md-3">
                            <div>
                            <p style="word-break: normal;"><?php echo $this->lang->line('campus_comments'); ?></p>
                            <?php if($c_type == 'individual'){ ?>
                                <p id="post_individual_title" style="margin-top:0;"></p>
                                <textarea class="form-control c-square" placeholder="<?php echo $this->lang->line('comments'); ?>" id="comment" name="comment"
                                          rows="2"></textarea>
                                <div style="padding:15px 0;">
                                    <button type="button" class="btn green post_comment" id="post_comment"
                                            data-resource_individual_id="<?php echo @$course->resource_individual_id;?>"
                                            data-course_id="<?php echo @$course->course_id;?>"
                                            data-teacher_id="<?php echo @$course->teacher_id;?>"><?php echo $this->lang->line('post_comment'); ?></button>
                                </div>
                                <div class="clearfix"></div>
                                <div class="c-comment-list">

                                </div>
                            <?php } ?>
                            <?php if(!empty($comments)){ ?>
                                <?php foreach($comments as $comment){ ?>
                                    <div class="row">
                                        <h4><?php echo $comment->nombre; ?></h4>
                                        <p style="word-break: normal;"><?php echo $comment->comments; ?></p>
                                        <div class="col-xs-12">
                                            <div class="margin-right-10 text-center pull-right">
                                                <p><?php echo date("F",strtotime($comment->created_date)); ?></p>
                                                <span><?php echo date("j",strtotime($comment->created_date)); ?></span>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                            <?php } ?>
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
<script>
    var _student_id = "<?php echo $student_id; ?>";
</script>