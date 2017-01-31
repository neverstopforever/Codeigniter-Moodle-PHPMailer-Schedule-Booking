
<div class="page-container">
    <div class="table_loading"></div>
    <div class="page-content">
        <div class="<?php echo $layoutClass ?>">
            <ul class="page-breadcrumb breadcrumb">
                <li>
                    <a href="javascript:;"><?= $this->lang->line('menu_Home') ?></a>
                </li>
                <li class="">
                    <a href="javascript:;"><?php echo $this->lang->line('manage_resources'); ?></a>
                </li>
                <li class="active">
                    <?php echo $this->lang->line('campus_students_my_courses'); ?>
                </li>
            </ul>
            <!-- BEGIN PAGE CONTENT INNER -->
            <div class="portlet light resources_content">
                <div class="portlet box sections green" >
                    <div class="portlet-body">
                        <div class="tabbable-line">
                            <div class="tab-content">
                                <div class="row">
                                    <div class="col-xs-12">
                                        <div class="text-right quick_tip_wrapper">
                                            <a href="http://blog.akaud.com" target="_blank" type="button" class="btn btn-xs quick_tip green-meadow "> <i class="fa fa-lightbulb-o" aria-hidden="true"></i> <span class="button_text"><?php echo $this->lang->line('quick_tip');?></span> </a>
                                        </div>
                                        <div class="no_courses" style="display: none;"></div>
                                        <table id="courses" class="table display" cellspacing="0" >
                                            <thead>
                                            <tr>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php if(isset($courses) && !empty($courses)) {?>

                                                <?php foreach($courses as $course){ ?>

                                                    <tr id="tr_<?php echo $course->ml_id; ?>">
                                                        <td>
                                                            <a href="<?php echo base_url().'campus/student-resource/resources/'.$course->ml_id; ?>"><?php echo $course->course_name; ?></a>
                                                            <p>
                                                                <?php
                                                                switch ($course->state){
                                                                    case 0:
                                                                        echo '<button class="btn btn-info awaiting_state_btn state_btn">'.$this->lang->line('student_resource_awaiting').'</button>';
                                                                        break;
                                                                    case 1:
                                                                        echo '<button class="btn btn-success active_state_btn state_btn">'.$this->lang->line('student_resource_active').'</button>';
                                                                        break;
                                                                    case 2:
                                                                        echo '<button class="btn btn-default state_btn">'.$this->lang->line('student_resource_finished').'</button>';
                                                                        break;
                                                                    case 3:
                                                                        echo '<button class="btn btn-danger state_btn">'.$this->lang->line('student_resource_cancelled').'</button>';
                                                                        break;
                                                                    default:
                                                                        echo '<button class="btn btn-info awaiting_state_btn state_btn">'.$this->lang->line('student_resource_awaiting').'</button>';
                                                                }
                                                                ?>
                                                            </p>
                                                        </td>
                                                        <td>
                                                            <p><?php echo $this->lang->line('student_resource_start_date');?>: <?php echo date($datepicker_format,strtotime($course->start_date));?></p>
                                                            <p><?php echo $this->lang->line('student_resource_end_date');?>: <?php echo date($datepicker_format,strtotime($course->end_date));?></p>
                                                            <p><?php echo $this->lang->line('student_resource_hours');?>: <?php echo round($course->hours);?></p>
                                                        </td>
                                                        <td>
                                                            <p><?php echo $this->lang->line('student_resource_group');?>: <?php echo $course->group_name;?></p>
                                                            <p><?php echo $this->lang->line('student_resource_teacher');?>: <?php echo $course->teacher_name;?></p>
                                                            <p><?php echo $this->lang->line('student_resource_classroom');?>: <?php echo $course->classroom;?></p>
                                                        </td>
                                                    </tr>
                                                <?php }
                                            } else { ?>

                                            <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
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