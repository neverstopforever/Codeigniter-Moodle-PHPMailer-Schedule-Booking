        <div class="page-container">
            <!-- BEGIN PAGE HEAD -->
       
                <div class="clearfix"></div>
                <div class="table_loading"></div>
                <div class="page-content">
                    <div class="<?php echo $layoutClass ?>">
                        <ul class="page-breadcrumb breadcrumb">
                            <li>
                                <a href="<?php echo $_base_url; ?>" ><?= $this->lang->line('menu_Home') ?></a>
                            </li>
                            <li>
                                <a href="<?php echo $_base_url; ?>schedules"><?php echo $this->lang->line('menu_planning'); ?></a>
                            </li>
                            <li class="">
                                <a href="javascript:;"><?php echo $this->lang->line('menu_calendar'); ?></a>
                            </li>
                            <li class="active">
                                <?php echo $this->lang->line('courses'); ?>
                            </li>
                        </ul>
                        <!-- BEGIN PAGE CONTENT INNER -->
                        <div class="row portlet light">
                            <div class="tabbable" style="margin-bottom: 15px;">
                                <ul class="nav nav-tabs" style="margin-bottom:0;border-bottom: 6px solid #1f6a8c">
                                    <?php foreach ($courses as $course){
                                        if(!empty($course->course_name)){
                                        ?>
                                        <li class="ab-calendar-tab" data-staff_id="<?php echo $course->course_id;?>" data-staff_color="<?php echo $course->color;?>" style="display: none">
                                            <a href="#" data-toggle="tab"><?php echo $course->course_name;?></a>
                                        </li>
                                        <?php }
                                    }?>
                                    <li class="ab-calendar-tab active" data-staff_id="0" data-staff_color="0">
                                        <a href="#" data-toggle="tab"><?php echo $this->lang->line('all'); ?></a>
                                    </li>
                                    <li class="pull-right">
                                        <div class="btn-group pull-right open">
                                            <button class="btn btn-info ab-staff-filter-button" data-toggle="dropdown">
                                                <i class="glyphicon glyphicon-user"></i>
                                                <span id="ab-staff-button"></span>
                                            </button>
                                            <button class="btn btn-info dropdown-toggle ab-staff-filter-button" data-toggle="dropdown" aria-expanded="true"><span class="caret"></span></button>
                                            <ul class="dropdown-menu pull-right">
                                                <li>
                                                    <a href="javascript:void(0)">
                                                        <input style="margin-right: 5px;" type="checkbox" id="ab-filter-all-staff" class="left">
                                                        <label for="ab-filter-all-staff"><?php echo $this->lang->line('schedules_all_classrooms');?></label>
                                                    </a>
                                                    <?php foreach ($courses as $course){
                                                        if(!empty($course->course_name)){
                                                            ?>
                                                            <a style="padding-left: 35px;" href="javascript:void(0)">
                                                                <input style="margin-right: 5px;" type="checkbox" id="ab-filter-staff-<?php echo $course->course_id;?>" value="<?php echo $course->course_id;?>" data-staff_name="<?php echo $course->course_name;?>" class="ab-staff-filter left">
                                                                <label style="padding-right: 15px;" for="ab-filter-staff-<?php echo $course->course_id;?>"><?php echo $course->course_name;?></label>
                                                            </a>
                                                        <?php }
                                                    }?>
                                                </li>
                                            </ul>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <div id="full_calendar_wrapper">

                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <!-- END PAGE CONTENT INNER -->
                </div>
            </div>